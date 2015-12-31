<?php namespace App\Http\Controllers\Frontend; /* path of this controller*/

use App\Model\Brandmember;  /* Model name*/
use App\Model\Order; 		/* Model name*/
use App\Model\OrderItems;	/* Model name*/
use Illuminate\Support\Collection;
use App\Http\Requests;
use App\Http\Controllers\Controller;    
use Illuminate\Support\Facades\Request;
use App\Model\Address; 
use Input; /* For input */
use Validator;
use Session;
use Imagine\Image\Box;
use Image\Image\ImageInterface;
use Illuminate\Pagination\Paginator;
use DB;
use Hash;
use Auth;
use Cookie;
use Redirect; 
use App\Helper\helpers;
use Cart;
use Mail;
use Twilio;
use App\libraries\Usps;

class CheckoutController extends BaseController {

    public function __construct() 
    {
    	parent::__construct();

    	$obj = new helpers();
        view()->share('obj',$obj);
      	//echo "<pre>"; print_r($obj->content()); exit;
    }
   /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        
    }
	
	public function checkoutMemberLogin()
    {
        $obj = new helpers();
	    if($obj->checkMemberLogin())
	    {
            return redirect('member-dashboard');
        }
		if($obj->checkBrandLogin())
		{
	        return redirect('brand-dashboard');
	    }

        if(Request::isMethod('post'))
        {
            $email = Request::input('email');
            $password = Request::input('password');
            $encrypt_pass = Hash::make($password);

            $login_arr = array('email' => $email, 'password' => $encrypt_pass);


            $users = DB::table('brandmembers')->where('email', $email)->where('role', 0)->first();    // Only member Can Login here        
           // print_r($_POST);exit;
            
            if($users!="")
            {
                $user_pass = $users->password;
                // check for password
                if(Hash::check($password, $user_pass))
                {
                    // Check for active                 
                    $user_cnt = DB::table('brandmembers')->where('email', $email)->where('status', 1)->where('admin_status', 1)->count();
                    //echo $user_cnt;exit;
                    //echo DB::enableQueryLog();exit;
                    if($user_cnt)
                    {
                        Session::put('member_userid', $users->id);
						Session::put('member_user_email', $users->email);
                        Session::put('member_username', ucfirst($users->username));

                        Session::forget('step1');
                        Session::forget('guest_array');
                        Session::forget('guest');
                        Session::forget('step3');


                        //Set the user cart 
						$this->update_cart($users->id);
						
                        return redirect('/checkout');
                    }
                    else
                    {
						$site = DB::table('sitesettings')->where('name','email')->first();
                        Session::flash('error', 'Your Status is inactive. Contact Admin at '.$site->value.' to get your account activated!'); 
                        return redirect('/checkout');
                    }
                }
                else
                {
                        Session::flash('error', 'Email and password does not match.'); 
                        return redirect('/checkout');
                }
            }
            else
            {
                    Session::flash('error', 'This email-id is not register as a member.'); 
                    return redirect('/checkout');
            }
        }

        return view('frontend.checkout.checkout_setp1',compact('body_class'),array('title'=>'MIRAMIX | checkout'));
    } 
	public function checkoutStep1()
    {
		$obj = new helpers();
 

	/* ==================== For Step 3 ========================================= */	
		$allcountry = DB::table('countries')->orderBy('name','ASC')->get();

		$states = DB::table('zones')->where('country_id',  223)->orderBy('name','ASC')->get();
        
		$allstates = array();
		foreach($states as $key=>$value)
		{
		    $allstates[$value->zone_id] = $value->name;
		}

		$shipAddress = DB::table('addresses')
                                ->leftJoin('brandmembers', 'brandmembers.id', '=', 'addresses.mem_brand_id')
                                ->leftJoin('countries', 'countries.country_id', '=', 'addresses.country_id')
                                ->leftJoin('zones', 'zones.zone_id', '=', 'addresses.zone_id')
                                ->select('addresses.*', 'brandmembers.fname', 'brandmembers.lname', 'brandmembers.username','brandmembers.address as default_address','countries.name as country_name', 'zones.name as zone_name', 'brandmembers.status', 'brandmembers.admin_status')
                                ->where('addresses.mem_brand_id','=',Session::get('member_userid'))
				->whereRaw('addresses.email<>"" and addresses.phone<>"" and addresses.address<>"" and addresses.country_id<>"" and addresses.city<>"" and addresses.zone_id<>"" and addresses.postcode<>""')
                                ->get();

    /* ==================== For Step 4 ========================================= */	
     $sitesettings = DB::table('sitesettings')->get();
     $all_sitesetting = array();
        if(!empty($sitesettings))
        {
            foreach($sitesettings as $each_sitesetting)
            {
              if($each_sitesetting->name == 'shipping_rate')
              {
                $shipping_rate = ((float)$each_sitesetting->value);
              }
              if($each_sitesetting->name == 'free_discount_rate')
              {
                $free_discount_rate = ((float)$each_sitesetting->value);
              }

              $all_sitesetting[$each_sitesetting->name] = $each_sitesetting->value;
            }
        }
        // All Cart Contain  In Session Will Display Here //
		if(Session::has('member_userid'))
			$content = DB::table('carts')->where('user_id',Session::get('member_userid'))->get();
		else
		{
			$content = $obj->content();
			foreach($content as $each_content)
	        {
	        	$each_content->product_id=$each_content->id;
	        	$each_content->form_factor=$each_content->options->form_factor;

                $each_content->row_id=$each_content->rowid;
                $each_content->product_name=$each_content->name;
                $each_content->quantity=$each_content->qty;
                $each_content->amount=$each_content->price;
                $each_content->duration=$each_content->options->duration;
                $each_content->sub_total=$each_content->subtotal;
	        }
	    }

	    // redirect to cart page if cart is empty
		if(Cart::count()==0){
			return redirect('show-cart');
		}
		//echo "<pre>";print_r($content); exit; 
        $share_discount = '';
		foreach($content as $each_content)
        {
            
            $product_res = DB::table('products')->where('id',$each_content->product_id)->first();
           // echo $each_content->brandmember_id; exit;
            $brandmember = DB::table('products')
                                ->leftJoin('brandmembers', 'brandmembers.id', '=', 'products.brandmember_id')
                                ->select('products.*', 'brandmembers.fname', 'brandmembers.lname', 'brandmembers.username', 'brandmembers.slug', 'brandmembers.pro_image', 'brandmembers.brand_details', 'brandmembers.brand_sitelink', 'brandmembers.status', 'brandmembers.admin_status')
                                ->where('products.id','=',$each_content->product_id)
                                ->first();
          	//echo "<pre>";print_r($brandmember); 
            //echo $brandmember->slug ; exit;
            $brand_name = ($brandmember->fname)?($brandmember->fname.' '.$brandmember->lname):$brandmember->username;

            $formfactor = DB::table('form_factors')->where('id','=',$each_content->form_factor)->first();
            $formfactor_name = $formfactor->name;
            $formfactor_id = $formfactor->id;

            /* Discount Share Start */
            if(Session::has('product_id'))
            {
                $pid=unserialize(Session::get('product_id'));
                if(in_array($each_content->product_id,$pid) )
                {
                    $share_discount = $all_sitesetting['discount_share'];
                }
                
            }
            if(Session::get('force_social_share')!='') // For cart page share
            {
                $share_discount = $all_sitesetting['discount_share'];
            }           
            /* Discount Share End */

            $cart_result[] = array('rowid'=>$each_content->row_id,
                'product_id'=>$each_content->product_id,
                'product_name'=>$each_content->product_name,
                'product_slug'=>$brandmember->product_slug,
                'product_image'=>$product_res->image1,
                'qty'=>$each_content->quantity,
                'price'=>$each_content->amount,
                'duration'=>$each_content->duration,
                'formfactor_name'=>$formfactor_name,
                'formfactor_id'=>$formfactor_id,
                'brand_name'=>$brand_name,
                'brand_slug'=>$brandmember->slug,
                'subtotal'=>$each_content->sub_total);

        }
	$cartcontent = Cart::content();


		
		return view('frontend.checkout.checkout_allstep',compact('body_class','shipAddress','allcountry','allstates','cart_result','shipping_rate','cartcontent','share_discount'),array('title'=>'MIRAMIX | Checkout-Step1'));

    }

    //
    public function checkoutSubStep3()
    {

		if(Request::input('select_address') == 'existing')
		{
			Session::put('select_address','existing');
			Session::put('selected_address_id',Request::input('existing_address'));
			//echo Request::input('existing_address'); exit;
		}
		else if(Request::input('select_address') == 'newaddress')
		{
			Session::put('select_address','newaddress');

			$insert_address = DB::table('addresses')
									->insert([
										'mem_brand_id' => Session::get('member_userid'), 
										'first_name' => Request::input('fname'), 
										'last_name' => Request::input('lname'), 
										'email' => Request::input('email_custom_address'),
										'phone' => Request::input('phone'), 
										'address' => Request::input('address'),
										'address2' => Request::input('address2'),
										'city' => Request::input('city'),
										'country_id' => Request::input('country_id'),
										'zone_id' => Request::input('state'),
										'postcode' => Request::input('zip_code')
										]);
			$lastInsertedId =DB::getPdo()->lastInsertId();   
			if(isset($userShipAddress) && $userShipAddress<=0){
			    $dataUpdateAddress = DB::table('brandmembers')
			->where('id', Session::get('member_userid'))
			->update(['address' => $lastInsertedId]);
			}

			// Getting last inserted id

			Session::put('selected_address_id',$lastInsertedId);		// shipping address option value store in session.
		}

		$userShipAddress = DB::table('addresses')->where('addresses.mem_brand_id','=',Session::get('member_userid'))->count();
		if($userShipAddress == 1)
		{
			$addrs=DB::table('addresses')->where('addresses.mem_brand_id','=',Session::get('member_userid'))->first();
			
			DB::table('brandmembers')
                                ->where('id', Session::get('member_userid'))
                                ->update(['address' =>$addrs->id]);
		}			

		//Session::put('step3','completed');
		//return redirect('/checkout');
		
    }

	public function checkoutSubStep2()
    {
    	Session::put('payment_method',Input::get('payment_type'));
		//return redirect('/checkout');
    }
	
	public function checkoutguestlogin()
    {
    	Session::put('step1','completed');
		return redirect('/checkout');
    }

	public function checkoutguestsubmit()
    {
    	$guest_array = array('guest_fname'=>Request::input('guest_fname'),'guest_lname'=>Request::input('guest_lname'),'guest_email'=>Request::input('guest_email'),'guest_phone'=>Request::input('guest_phone'),'guest_address'=>Request::input('guest_address'),'guest_address2'=>Request::input('guest_address2'),'guest_country_id'=>Request::input('guest_country_id'),'guest_state'=>Request::input('guest_state'),'guest_city'=>Request::input('guest_city'),'guest_zip_code'=>Request::input('guest_zip_code'));
    	Session::put('guest_array',$guest_array);
    	Session::put('guest',1);
    	Session::put('step3','completed');
		return redirect('/checkout');
    }
	
	/*public function checkoutStep2()
    {
    	
		$obj = new helpers();
        if(($obj->checkMemberLogin()) && (!$obj->checkBrandLogin()))  //for loggedin member
        {
			if(Request::isMethod('post'))
			{
				//echo "pay= ".Request::input('payment_type'); exit;
				Session::put('payment_method',Request::input('payment_type'));
				return redirect('/checkout-step3');
			}
			return view('frontend.checkout.checkout_setp2',compact('body_class'),array('title'=>'MIRAMIX | Checkout-Step2'));
		}
		else
		{
			redirect('/checkout');
		}
    }
	
	public function checkoutStep3()
    {

		$obj = new helpers();
		//echo Session::get('member_userid');
		$userShipAddress = DB::table('addresses')->where('addresses.mem_brand_id','=',Session::get('member_userid'))
		->whereRaw('addresses.email<>"" and addresses.phone<>"" and addresses.address<>"" and addresses.country_id<>"" and addresses.city<>"" and addresses.zone_id<>"" and addresses.postcode<>""')
		->count();
		//print_r($userShipAddress); exit;
		if($userShipAddress == 1)
		{
			$addrs=DB::table('addresses')->where('addresses.mem_brand_id','=',Session::get('member_userid'))->get();
			//echo $addrs->id;
				
		}

	
        if(($obj->checkMemberLogin()) && (!$obj->checkBrandLogin()))  //for not logged in member
        {
        	
    
        	$shipAddress = DB::table('addresses')
                                ->leftJoin('brandmembers', 'brandmembers.id', '=', 'addresses.mem_brand_id')
                                ->leftJoin('countries', 'countries.country_id', '=', 'addresses.country_id')
                                ->leftJoin('zones', 'zones.zone_id', '=', 'addresses.zone_id')
                                ->select('addresses.*', 'brandmembers.fname', 'brandmembers.lname', 'brandmembers.username','brandmembers.address as default_address','countries.name as country_name', 'zones.name as zone_name', 'brandmembers.status', 'brandmembers.admin_status')
                                ->where('addresses.mem_brand_id','=',Session::get('member_userid'))
				->whereRaw('addresses.email<>"" and addresses.phone<>"" and addresses.address<>"" and addresses.country_id<>"" and addresses.city<>"" and addresses.zone_id<>"" and addresses.postcode<>""')
                                ->get();

                         
                                //echo "<pre>";print_r($shipAddress); exit;
            $allcountry = DB::table('countries')->orderBy('name','ASC')->get();

            if(Request::isMethod('post'))
			{//echo "s_add= ".Request::input('select_address'); exit;
				if(Request::input('select_address') == 'existing')
				{
					Session::put('select_address','existing');
					Session::put('selected_address_id',Request::input('existing_address'));
					//echo Request::input('existing_address'); exit;
				}
				else if(Request::input('select_address') == 'newaddress')
				{
					Session::put('select_address','newaddress');

					$insert_address = DB::table('addresses')
											->insert([
												'mem_brand_id' => Session::get('member_userid'), 
												'first_name' => Request::input('fname'), 
												'last_name' => Request::input('lname'), 
												'email' => Request::input('email'),
												'phone' => Request::input('phone'), 
												'address' => Request::input('address'),
												'address2' => Request::input('address2'),
												'city' => Request::input('city'),
												'country_id' => Request::input('country_id'),
												'zone_id' => Request::input('state'),
												'postcode' => Request::input('zip_code')
												]);
					$lastInsertedId =DB::getPdo()->lastInsertId();   
					if(isset($userShipAddress) && $userShipAddress<=0){
					    $dataUpdateAddress = DB::table('brandmembers')
					->where('id', Session::get('member_userid'))
					->update(['address' => $lastInsertedId]);
					}

					// Getting last inserted id

					Session::put('selected_address_id',$lastInsertedId);		// shipping address option value store in session.
				}

				$userShipAddress = DB::table('addresses')->where('addresses.mem_brand_id','=',Session::get('member_userid'))->count();
					if($userShipAddress == 1)
					{
						$addrs=DB::table('addresses')->where('addresses.mem_brand_id','=',Session::get('member_userid'))->first();
						
						DB::table('brandmembers')
			                                ->where('id', Session::get('member_userid'))
			                                ->update(['address' =>$addrs->id]);
					}			

				
				return redirect('/checkout-step4');
			}
			
			$states = DB::table('zones')->where('country_id',  223)->orderBy('name','ASC')->get();
        
			$allstates = array();
			foreach($states as $key=>$value)
			{
			    $allstates[$value->zone_id] = $value->name;
			}

			return view('frontend.checkout.checkout_setp3',compact('body_class','shipAddress','allcountry','allstates'),array('title'=>'MIRAMIX | Checkout-Step3'));
		}
		else   //If logged in member
		{
			return redirect('/checkout');
		}
    }*/

    public function checkoutStep4()
    {
		$obj = new helpers();
		$shp_address=array();
        
        	$sitesettings = DB::table('sitesettings')->get();
            if(!empty($sitesettings))
            {
	            foreach($sitesettings as $each_sitesetting)
	            {
	              if($each_sitesetting->name == 'shipping_rate')
	              {
	                $shipping_rate = ((float)$each_sitesetting->value);
	              }
	              if($each_sitesetting->name == 'free_discount_rate')
	              {
	                $free_discount_rate = ((float)$each_sitesetting->value);
	              }
	            }
            }

			if(Request::isMethod('post'))
			{
				Session::put('name_card',Input::get('name_card'));//Input::get('name_card');
		        Session::put('card_number',Input::get('card_number')); //Input::get('card_number'); //"4042760173301988";//
		        Session::put('card_exp_month',Input::get('card_exp_month')); // "03"; //
		        Session::put('card_exp_year',Input::get('card_exp_year'));  // "19"; //

		        //checkout as guest

		       
		        if(!Session::has('member_userid')){

		        	$guestdata=Session::get('guest_array');
		        	$shiping_address = array('address_title' 		=> 'default address',
										'first_name' 				=> $guestdata["guest_fname"],
										'last_name' 				=> $guestdata["guest_lname"],
										'email' 					=> $guestdata["guest_email"],
										'phone' 					=> $guestdata["guest_phone"],
										'address' 					=> $guestdata["guest_address"],
										'address2' 					=> $guestdata["guest_address2"],
										'city' 						=> $guestdata["guest_city"],
										'zone_id' 					=> $guestdata["guest_state"],
										'country_id' 				=> $guestdata["guest_country_id"],
										'postcode' 					=> $guestdata["guest_zip_code"]
										);


		        	$want_reg=Request::input('register_user');
		        	if($want_reg=='register'){

	        			//register the member
	        			Session::put('guest_username_sess',Request::input('guest_username'));
	        			
				        $brandmember= Brandmember::create([
				            'fname'             => $guestdata['guest_fname'],
				            'lname'             => $guestdata['guest_lname'],
				            'email'             => $guestdata['guest_email'],
				            'username'          => Request::input('guest_username'),
				            'password'          => Hash::make(Request::input('guest_password')),
				            'role'              => 0,                   // for member role is "0"
				            'admin_status'      => 1, 
				            'status'			=>1,                  // Admin status
				            'updated_at'        => date('Y-m-d H:i:s'),
				            'created_at'        => date('Y-m-d H:i:s')
				        ]);

				        $lastInsertedId = $brandmember->id;

				        $shiping_address['mem_brand_id']=$brandmember->id;
				        
						$shp_address=Address::create($shiping_address);
						$lastAddressId =DB::getPdo()->lastInsertId();  
				        $user_id=$brandmember->id;

				        // Update Address id in brandmember table
				        $addressId = $shp_address->id;
						$dataUpdateAddress = DB::table('brandmembers')
							->where('id', $brandmember->id)
							->update(['address' => $addressId]);
								
		        	}else{
		        		//set userid for not loggedin users to pass the order
		        		$user_id=NULL;
		        		$shp_address['id']=NULL;
		        		$shp_address=(object)$shp_address;
		        		//print_r($shp_address); exit;
		        	}
		        	// End of registration ==================================================

		        /* To get the country code And Zone code */
		        	
					$shp_country = DB::table('countries')
									->where('country_id',$guestdata["guest_country_id"])
									->first();
					$shp_zone = DB::table('zones')
									->where('zone_id',$guestdata["guest_state"])
									->first();

				
					$shiping_address = array('address_title' 		=> 'default address',
										'first_name' 				=> $guestdata["guest_fname"],
										'last_name' 				=> $guestdata["guest_lname"],
										'email' 					=> $guestdata["guest_email"],
										'phone' 					=> $guestdata["guest_phone"],
										'address' 					=> $guestdata["guest_address"],
										'address2' 					=> $guestdata["guest_address2"],
										'city' 						=> $guestdata["guest_city"],
										'zone_id' 					=> $shp_zone->code,
										'country_id' 				=> $shp_country->iso_code_3,
										'postcode' 					=> $guestdata["guest_zip_code"]
										);
				//print_r($shiping_address); exit;
				$shiping_address_serial = serialize($shiping_address);

		        }
		        else
		        {
		        	//for logged-in users
					$shp_address = DB::table('addresses')
                                ->leftjoin('countries', 'countries.country_id', '=', 'addresses.country_id')
                                ->leftjoin('zones', 'zones.zone_id', '=', 'addresses.zone_id')
                                ->select('addresses.*', 'countries.name as country_name','countries.iso_code_3 as country_code', 'zones.name as zone_name', 'zones.code as zone_code')
                                ->where('mem_brand_id',Session::get('member_userid'))
								->where('id',Session::get('selected_address_id'))
								->first();

								//echo "<pre>111111";print_r($shp_address); exit;
					// Serialize the Shipping Address because If user delete there address from "addresses" table,After that the address also store in the "order" table for  getting order history//
					$shiping_address = array('address_title' 			=> $shp_address->address_title,
											'mem_brand_id'				=> $shp_address->mem_brand_id,
											'first_name' 				=> $shp_address->first_name,
											'last_name' 				=> $shp_address->last_name,
											'email' 					=> $shp_address->email,
											'phone' 					=> $shp_address->phone,
											'address' 					=> $shp_address->address,
											'address2' 					=> $shp_address->address2,
											'city' 						=> $shp_address->city,
											'zone_id' 					=> $shp_address->zone_code, // two digit code //
											'country_id' 				=> $shp_address->country_code,  // three digit code iso_code_3//
											'postcode' 					=> $shp_address->postcode
											);

					$shiping_address_serial = serialize($shiping_address);
					//echo "pm= ".Session::get('payment_method'); exit;
					$user_id=Session::get('member_userid');
				}


				$order= Order::create([
										'order_total'            	=> Request::input('grand_total'),
										'sub_total'					=> Request::input('sub_total'),
										'discount'					=> Request::input('discount'),
                                        'share_discount'            => Request::input('social_discount'),
                                        'total_discount'            => Request::input('total_discount'),
										'redeem_amount'				=> Request::input('redeem_amount'),
										'order_status'           	=> 'pending',
										'shipping_address_id'    	=> $shp_address->id,
										'shipping_cost'    			=> Request::input('shipping_rate'),
										'shipping_type'    			=> 'flat',
										'user_id'          			=> $user_id,
										'ip_address'  				=> $_SERVER['REMOTE_ADDR'],
										'payment_method'          	=> Session::get('payment_method'),
										'transaction_id'    		=> '',
										'transaction_status'      	=> '',
										'shiping_address_serialize' => $shiping_address_serial,
										'created_at' => date('Y-m-d H:s:i'),
										'updated_at' => date('Y-m-d H:s:i')
									]);
				$last_order_id = $order->id;
				

				$obj = new helpers();
				$order_number = 'ORD-'.$obj->random_string(5).'-'.$last_order_id;   // Generate random String for order number
				$update_order_number = DB::table('orders')
			                                ->where('id', $last_order_id)
			                                ->update(['order_number' => $order_number]);

			    Session::put('order_number',$order_number);
		        Session::put('order_id',$last_order_id);


				///we are not storing new registered cart in cart table as it will be destroyed soon
				if(Session::has('member_userid'))
					$allCart = DB::table('carts')->where('user_id',Session::get('member_userid'))->get();
				else
				{
					$allCart = $obj->content();

					foreach($allCart as $each_content)
			        {
			        	$each_content->product_id=$each_content->id;
			        	$each_content->form_factor=$each_content->options->form_factor;

		                $each_content->row_id=$each_content->rowid;
		                $each_content->product_name=$each_content->name;
		                $each_content->quantity=$each_content->qty;
		                $each_content->amount=$each_content->price;
		                $each_content->duration=$each_content->options->duration;
		                $each_content->sub_total=$each_content->subtotal;
		                $each_content->no_of_days=$each_content->options->no_of_days;

			        }
			    }


				foreach($allCart as $eachCart)
				{
					$product_details = DB::table('products')->where('id',$eachCart->product_id)->first();
		           // echo $each_content->brandmember_id; exit;
		            $brandmember_deatils = DB::table('products')
		                                ->leftJoin('brandmembers', 'brandmembers.id', '=', 'products.brandmember_id')
		                                ->select('products.*', 'brandmembers.fname', 'brandmembers.lname', 'brandmembers.username','brandmembers.email', 'brandmembers.slug', 'brandmembers.pro_image', 'brandmembers.brand_details', 'brandmembers.brand_sitelink', 'brandmembers.status', 'brandmembers.admin_status')
		                                ->where('products.id','=',$eachCart->product_id)
		                                ->first();
		                                //echo "<pre>";print_r($brandmember_deatils); exit;
		                                //echo $brandmember->slug ; exit;
		            $brand_member_name = ($brandmember_deatils->fname)?($brandmember_deatils->fname.' '.$brandmember_deatils->lname):$brandmember_deatils->username;

		            $formfactor = DB::table('form_factors')->where('id','=',$eachCart->form_factor)->first();
				
					$order_item = OrderItems::create([
												'order_id'       	=> $last_order_id,
												'brand_id'          => $brandmember_deatils->brandmember_id,
												'brand_name'    	=> $brand_member_name,
												'brand_email'		=> $brandmember_deatils->email,
												'product_id'        => $eachCart->product_id,
												'product_name'  	=> $eachCart->product_name,
												'product_image'     => $product_details->image1,
												'quantity'     		=> $eachCart->quantity,
												'price'    			=> $eachCart->amount,
												'form_factor_id'    => $formfactor->id,
												'form_factor_name'  => $formfactor->name,
												'duration'  		=> $eachCart->duration,
												'no_of_days'  		=> $eachCart->no_of_days
											]);

					//All Cart deleted from cart table after inserting all data to order and order_item table.
					if(Session::has('member_userid'))
					$deleteCart =  DB::table('carts')->where('user_id', '=', Session::get('member_userid'))->delete();
					Cart::destroy(); // After inserting all cart data into Order and Order_item Table database 
				}
				
				//set points for users on purchase
				
				
				
				
				
				if(Session::get('payment_method') =='creditcard') 	  // if Payment With Credit Card 
				{
					return redirect('/checkout-authorize/'.$last_order_id);
				}
				elseif(Session::get('payment_method') =='paypal')	 // if Payment With Paypal Account 
				{
					return redirect('/checkout-paypal/'.$last_order_id);	
				}
				
			} //end of post




			
			/*
		
			
			// All Cart Contain  In Session Will Display Here //
			$content = DB::table('carts')->where('user_id',Session::get('member_userid'))->get();
			//echo "<pre>";print_r($content); exit;
			foreach($content as $each_content)
	        {
	            
	            $product_res = DB::table('products')->where('id',$each_content->product_id)->first();
	           // echo $each_content->brandmember_id; exit;
	            $brandmember = DB::table('products')
	                                ->leftJoin('brandmembers', 'brandmembers.id', '=', 'products.brandmember_id')
	                                ->select('products.*', 'brandmembers.fname', 'brandmembers.lname', 'brandmembers.username', 'brandmembers.slug', 'brandmembers.pro_image', 'brandmembers.brand_details', 'brandmembers.brand_sitelink', 'brandmembers.status', 'brandmembers.admin_status')
	                                ->where('products.id','=',$each_content->product_id)
	                                ->first();
	                                //echo "<pre>";print_r($brandmember); 
	                                //echo $brandmember->slug ; exit;
	            $brand_name = ($brandmember->fname)?($brandmember->fname.' '.$brandmember->lname):$brandmember->username;

	            $formfactor = DB::table('form_factors')->where('id','=',$each_content->form_factor)->first();
	            $formfactor_name = $formfactor->name;
	            $formfactor_id = $formfactor->id;

	            $cart_result[] = array('rowid'=>$each_content->row_id,
                    'product_id'=>$each_content->id,
	                'product_name'=>$each_content->product_name,
	                'product_slug'=>$brandmember->product_slug,
	                'product_image'=>$product_res->image1,
	                'qty'=>$each_content->quantity,
	                'price'=>$each_content->amount,
	                'duration'=>$each_content->duration,
	                'formfactor_name'=>$formfactor_name,
	                'formfactor_id'=>$formfactor_id,
	                'brand_name'=>$brand_name,
	                'brand_slug'=>$brandmember->slug,
	                'subtotal'=>$each_content->sub_total);

	        }
	    

            //echo "sph= ".$shipping_rate; exit;
			return view('frontend.checkout.checkout_setp4',compact('body_class','cart_result','shipping_rate'),array('title'=>'MIRAMIX | Checkout-Step4'));
			*/
    }


    public function checkoutPaypal($id)
    {
    	/* Site Setting All details */
    	$sitesettings = DB::table('sitesettings')->get();
    	$all_sitesetting = array();
    	foreach($sitesettings as $each_sitesetting)
	    {
	    	$all_sitesetting[$each_sitesetting->name] = $each_sitesetting->value; 
    	}

    	$order_id = $id;
		$order_list = DB::table('orders')
                    ->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id')
                    ->select('orders.*', 'order_items.brand_id', 'order_items.brand_name', 'order_items.product_id', 'order_items.product_name', 'order_items.product_image', 'order_items.quantity', 'order_items.price', 'order_items.form_factor_id', 'order_items.form_factor_name')
                    ->where('orders.id','=',$order_id)
                    ->get();

        Session::put('miramix_order_id',$order_id); // use for paypal cancel
        // echo "<pre>";
        // print_r($order_list);
        // exit;
        return view('frontend.checkout.checkout_paypalpage',compact('body_class','order_list'),array('title'=>'MIRAMIX | Checkout-Paypal'));
    	//echo "boom";
    }
		
	public function paypalNotify()
    {
    
    	@mail("sumitra.unified@gmail.com", "enter notify", "Paypal Response<pre>".print_r($_POST,true));	
    	// Call ipn
    	$req = 'cmd=_notify-validate';
		foreach ($_POST as $key => $value) 
		{
			$value = urlencode(stripslashes($value));
			$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
			$req .= "&$key=$value";
		}
			// assign posted variables to local variables
			$data['payment_status'] 	= $_POST['payment_status'];
			$data['payment_amount'] 	= $_POST['mc_gross'];
			$data['mc_shipping'] 		= $_POST['mc_shipping'];
			$data['mc_handling'] 		= $_POST['mc_handling'];
			$data['payment_currency']	= $_POST['mc_currency'];
			$data['txn_id']				= $_POST['txn_id'];
			$data['receiver_email'] 	= $_POST['receiver_email'];
			$data['payer_email'] 		= $_POST['payer_email'];
			$cnt		 				= explode(",",$_POST['custom']);
			@mail("sumitra.unified@gmail.com", "paypalnotify", "Paypal Response<br />data = <pre>".print_r($data, true)."</pre>");

			$user_id =  $cnt[0];	//User_id
		    $order_id = $cnt[1];	//Order_id
		// For Paypal Payment Only //
    	$sitesettings = DB::table('sitesettings')->get();
    	$all_sitesetting = array();
    	foreach($sitesettings as $each_sitesetting)
	    {
	    	$all_sitesetting[$each_sitesetting->name] = $each_sitesetting->value; 
    	}
    	
    	$admin_users_email = $all_sitesetting['email']; // Admin Support Email
    	$payment_method =  $all_sitesetting['payment_mode']; 

		if($all_sitesetting['payment_mode'] == 'test')
		{
			$paypal_host = $all_sitesetting['paypal_host_test'];
		}
		else if($all_sitesetting['payment_mode'] == 'live')
		{
			$paypal_host = $all_sitesetting['paypal_host_live'];
		}

		$pay_date=date('l jS \of F Y h:i:s A');

		// post back to PayPal system to validate
		$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Host: ".$paypal_host."\r\n";
		//$header .= "Host: www.paypal.com:443\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
		//$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);	
		$fp = fsockopen ('ssl://'.$paypal_host, 443, $errno, $errstr, 30);	
		//$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
		if (!$fp) 
		{
			// HTTP ERROR
			@mail("sumitra.unified@gmail.com", "fshok error", "Invalid Response<br />data = <pre>".print_r($_POST, true)."</pre>");
		} 
		else 
		{
			@mail("sumitra.unified@gmail.com", "Me PAYPAL DEBUGGING1", "Invalid Response<br />data = <pre>".print_r($_POST, true)."</pre>");
			fputs ($fp, $header . $req);
			while (!feof($fp)) 
			{
				$res = fgets ($fp, 1024);
				$order=DB::table('orders')->where('id', $order_id)->first();
				$status=$order->order_status;
				
				if (strcmp($res, "VERIFIED") == 0 && $status=='pending') 
				{
					@mail("sumitra.unified@gmail.com", "notify1-completed", "valid Response<br />data = <pre>".print_r($data, true)."</pre>");
					
		        	

					$transaction_status =$_POST['payment_status'];
					$update_order = DB::table('orders')
									->where('id', $order_id)
									->update(['order_status'=>'processing','transaction_id' => $_POST['txn_id'],'transaction_status'=>$transaction_status]);

					// Order details for perticular order id 
					$order_list = DB::table('orders')
			                    ->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id')
			                    ->select('orders.*', 'order_items.brand_id', 'order_items.brand_name','order_items.brand_email', 'order_items.product_id', 'order_items.product_name', 'order_items.product_image', 'order_items.quantity', 'order_items.price', 'order_items.form_factor_id', 'order_items.form_factor_name')
			                    ->where('orders.id','=',$order_id)
			                    ->get();

			        
		            $mobile = '' ;

			        if($user_id!=''){
						$user_details = DB::table('brandmembers')->where('id', $user_id)->first();
						
						$name = $user_details->fname.' '.$user_details->lname;
						$username = $user_details->username;
						if($name!='')
							$mailing_name = $name;
						else
							$mailing_name = $username;

			            $user_email = $user_details->email; 

			            $mobile =  $user_details->phone_no; // logged user  phone number
				    
				    
				    
				
				$order_total=$order->sub_total;
				$price_for_point = DB::table('sitesettings')->where('name','price_for_point')->first();
				$points=round($order_total/$price_for_point->value)+$user_details->user_points;
				if($order->redeem_amount>0){
				$points=$points-($order->redeem_amount/$price_for_point->value);
				}
				DB::table('brandmembers')
			                                ->where('id', $user_id)
			                                ->update(['user_points' => $points]);
				

		        	}else{
		        		//for guest checkout
		        		$guestdata = unserialize($order_list[0]->shiping_address_serialize);
		        		
		        		$name = $guestdata["first_name"].' '.$guestdata["last_name"];
						$username = $guestdata["first_name"];
						$mailing_name = $name;
						

			            $user_email = $guestdata["email"]; 

			            $mobile =  $guestdata["phone"]; // Guest user  phone number

		        	}

		            // Mail For Member  
		            $sent = Mail::send('frontend.checkout.order_details_mail', array('admin_users_email'=>$admin_users_email,'receiver_name'=>$mailing_name,'email'=>$user_email,'order_list'=>$order_list), 
		            function($message) use ($admin_users_email, $user_email,$mailing_name)
		            {
		                $message->from($admin_users_email);  //support mail
		                $message->to($user_email, $mailing_name)->subject('Miramix Order Details');
		            });

		            // Mail For Brand 
		            /*$branduser = array();
		            foreach($order_list as $each_order_list)
		            {

		            	$branduser[$each_order_list->brand_email]=$each_order_list->brand_name;

		            }
		            $brandusers=array_unique($branduser);

		            foreach($brandusers as $brand_email=>$brand_name)
		            {
		            	$items=array();
		            	foreach($order_list as $each_order_list)
		            	{
		            			if($each_order_list->brand_email!=$brand_email) continue;

		            			$items[]=$each_order_list;
		            	}

		            	$sent_brand = Mail::send('frontend.checkout.brand_order_details_mail', array('admin_users_email'=>$admin_users_email,'brand_name'=>$brand_name,'brand_email'=>$brand_email,'order_list'=>$items), 
				            function($message) use ($admin_users_email, $brand_email,$brand_name)
				            {
				                $message->from($admin_users_email); //support mail
				                $message->to($brand_email, $brand_name)->subject('Miramix Order Details For Brand');
				            });
		            }*/

		            // Mail For Admin 
		            $admin_user = DB::table('users')->first();

		            $admin_email = $admin_user->email;

		            if(($admin_user->name)!='')
		            	$admin_name = $admin_user->name;
		            else
		            	$admin_name = 'Admin';

		            $sent_admin = Mail::send('frontend.checkout.admin_order_details_mail', array('admin_users_email'=>$admin_users_email,'receiver_name'=>$admin_name,'admin_email'=>$admin_email,'order_list'=>$order_list), 
		            function($message) use ($admin_users_email, $admin_email,$admin_name)
		            {
		                $message->from($admin_users_email);  //support mail
		                $message->to($admin_email, $admin_name)->subject('Miramix Order Details For Admin');
		            });

		            /* TWILIO SMS SENDING AFTER SUCCESSFUL ORDER START */

		            if($mobile !='')
		            {
		            	$order_message = "Thanks for your order at The Miramix"."\r\n";
		            	$order_message .="Order Number :".$order_list[0]->order_number." Order Amount: ".$order_list[0]->order_total;
		            	Twilio::message('+'.$mobile, $order_message);
		            }

		            /* TWILIO SMS SENDING AFTER SUCCESSFUL ORDER START */

				}
				if (strcmp ($res, "INVALID") == 0) 
				{
					// Used for debugging
					@mail("sumitra.unified@gmail.com", "Me PAYPAL DEBUGGING2", "Invalid Response<br />data = <pre>".print_r($_POST, true)."</pre>");
					$order_id = $order_id;		//Order_id
					//echo $order_id;
					$transaction_status =$_POST['payment_status'];
					$update_order = DB::table('orders')
									->where('id', $order_id)
									->update(['order_status'=>'cancel','transaction_status'=>$transaction_status]);

					// Order details for perticular order id 
					$order_list = DB::table('orders')
			                    ->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id')
			                    ->select('orders.*', 'order_items.brand_id', 'order_items.brand_name','order_items.brand_email', 'order_items.product_id', 'order_items.product_name', 'order_items.product_image', 'order_items.quantity', 'order_items.price', 'order_items.form_factor_id', 'order_items.form_factor_name')
			                    ->where('orders.id','=',$order_id)
			                    ->get();
					//print_r($order_list); exit;

			                    

					 if($user_id!=''){
						$user_details = DB::table('brandmembers')->where('id', $user_id)->first();
						
						$name = $user_details->fname.' '.$user_details->lname;
						$username = $user_details->username;
						if($name!='')
							$mailing_name = $name;
						else
							$mailing_name = $username;

			            $user_email = $user_details->email; 

		        	}else{
		        		//for guest checkout
		        		$guestdata = unserialize($order_list[0]->shiping_address_serialize);
		        		
		        		$name = $guestdata["first_name"].' '.$guestdata["last_name"];
						$username = $guestdata["first_name"];
						$mailing_name = $name;
						

			            $user_email = $guestdata["email"]; 

		        	}
		            
		            //echo $resetpassword_link; exit;

		            // Mail For Member  
		            $sent = Mail::send('frontend.checkout.order_cancel_mail', array('admin_users_email'=>$admin_users_email,'receiver_name'=>$mailing_name,'email'=>$user_email,'order_list'=>$order_list), 
		            function($message) use ($admin_users_email, $user_email,$mailing_name)
		            {
		                $message->from($admin_users_email);  //support mail
		                $message->to($user_email, $mailing_name)->subject('Miramix Order Details');
		            });

				}
			}	//end of while
			fclose ($fp);
		}//end of if
		
    }

    public function success()
    {
    
    	if (Session::has('coupon_code'))
		{
			Session::forget('coupon_code');
		}
		elseif(Session::has('coupon_type'))
		{
			Session::forget('coupon_type');
		}
		elseif(Session::has('coupon_discount'))
		{
			Session::forget('coupon_discount');
		}
		elseif(Session::has('coupon_amount'))
		{
			Session::forget('coupon_amount');
		}

    	//SuccessFull payment View
    	$xsrfToken = app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token());  

    	// For Paypal Payment Only //
    	$sitesettings = DB::table('sitesettings')->get();
    	$all_sitesetting = array();
    	foreach($sitesettings as $each_sitesetting)
	    {
	    	$all_sitesetting[$each_sitesetting->name] = $each_sitesetting->value; 
    	}
    	
    	$admin_users_email = $all_sitesetting['email']; // Admin Support Email
    	$payment_method =  $all_sitesetting['payment_mode'];

    	if(Session::get('payment_method')=='paypal')
        {
            if(Request::isMethod('post'))
            {
                
	            $custom = explode(',',$_POST['custom']); //Return From Paypal
	            $user_id =  $custom[0];                 //User_id
	            $order_id = $custom[1];                 //Order_id
		    
		    $order=DB::table('orders')->where('id', $order_id)->first();
		    $status=$order->order_status;
		if($status=='pending'){	
	            $transaction_status =$_POST['payment_status'];
	            $update_order = DB::table('orders')
	                            ->where('id', $order_id)
	                            ->update(['order_status'=>'processing','transaction_id' => $_POST['txn_id'],'transaction_status'=>$transaction_status]);

	            /* Order details for perticular order id */
	            $order_list = DB::table('orders')
	                        ->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id')
	                        ->select('orders.*', 'order_items.brand_id', 'order_items.brand_name','order_items.brand_email', 'order_items.product_id', 'order_items.product_name', 'order_items.product_image', 'order_items.quantity', 'order_items.price', 'order_items.form_factor_id', 'order_items.form_factor_name')
	                        ->where('orders.id','=',$order_id)
	                        ->get();

	            Session::put('order_number',$order_list[0]->order_number);
	            Session::put('order_id',$order_id);

	            if(Session::has('member_userid')){
	                $user_details = DB::table('brandmembers')->where('id', Session::get('member_userid'))->first();
	                
	                $name = $user_details->fname.' '.$user_details->lname;
	                $username = $user_details->username;
	                if($name!='')
	                    $mailing_name = $name;
	                else
	                    $mailing_name = $username;

	                $user_email = $user_details->email; 

	            }else{
	                //for guest checkout

	                $guestdata=Session::get('guest_array');
	                $name = $guestdata["guest_fname"].' '.$guestdata["guest_lname"];
	                $username = Session::get('guest_username_sess');
	                $mailing_name = $name;

	                $user_email = $guestdata["guest_email"]; 
	            }

	             /* Mail For Member  */
	            $sent = Mail::send('frontend.checkout.order_details_mail', array('admin_users_email'=>$admin_users_email,'receiver_name'=>$mailing_name,'email'=>$user_email,'order_list'=>$order_list), 
	            function($message) use ($admin_users_email, $user_email,$mailing_name)
	            {
	                $message->from($admin_users_email);  //support mail
	                $message->to($user_email, $mailing_name)->subject('Miramix Order Details');
	            });

	            /* Mail For Brand */
	            /*$branduser = array();
	            foreach($order_list as $each_order_list)
	            {

	                $branduser[$each_order_list->brand_email]=$each_order_list->brand_name;

	            }
	             $brandusers=array_unique($branduser);
	            foreach($brandusers as $brand_email=>$brand_name)
	            {
	                $items=array();
	                foreach($order_list as $each_order_list)
	                {
	                        if($each_order_list->brand_email!=$brand_email) continue;

	                        $items[]=$each_order_list;
	                }

	                $sent_brand = Mail::send('frontend.checkout.brand_order_details_mail', array('admin_users_email'=>$admin_users_email,'brand_name'=>$brand_name,'brand_email'=>$brand_email,'order_list'=>$items), 
	                    function($message) use ($admin_users_email, $brand_email,$brand_name)
	                    {
	                        $message->from($admin_users_email); //support mail
	                        $message->to($brand_email, $brand_name)->subject('Miramix Order Details For Brand');
	                    });
	            }*/

	            /* Mail For Admin */
	            $admin_user = DB::table('users')->first();

	            $admin_email = $admin_user->email;

	            if(($admin_user->name)!='')
	                $admin_name = $admin_user->name;
	            else
	                $admin_name = 'Admin';

	            $sent_admin = Mail::send('frontend.checkout.admin_order_details_mail', array('admin_users_email'=>$admin_users_email,'receiver_name'=>$admin_name,'admin_email'=>$admin_email,'order_list'=>$order_list), 
	            function($message) use ($admin_users_email, $admin_email,$admin_name)
	            {
	                $message->from($admin_users_email);  //support mail
	                $message->to($admin_email, $admin_name)->subject('Miramix Order Details For Admin');
	            });

	           	if( ! $sent) 
	            {
	              Session::flash('error', 'something went wrong!! Mail not sent.'); 
	              //return redirect('member-forgot-password');
	            }
	            else
	            {
	              Session::flash('success', 'Your order successfully placed.'); 
	              //return redirect('memberLogin');
	            }
		}
            }
        }
	
	

		/* ========================= Remove session ==================================== */	
			Session::forget('payment_method');
			Session::forget('step3');
			Session::forget('step1');
			Session::forget('guest_array');
			Session::forget('guest');
	        Session::forget('coupon_code');
	        Session::forget('coupon_type');
	        Session::forget('coupon_amount');
	        Session::forget('coupon_discount');
	        Session::forget('share_coupon_status');
            Session::forget('product_id');
            Session::forget('force_social_share');
		/* ========================= End Remove session ==================================== */	
    	return view('frontend.checkout.pyament_success',array('title'=>'MIRAMIX | Checkout-Success'))->with('xsrf_token', $xsrfToken);
    }
   

    public function cancel()
    {
    
    	// For Paypal Payment Only //
    	$sitesettings = DB::table('sitesettings')->get();
    	$all_sitesetting = array();
    	foreach($sitesettings as $each_sitesetting)
	    {
	    	$all_sitesetting[$each_sitesetting->name] = $each_sitesetting->value; 
    	}
    	
    	$admin_users_email = $all_sitesetting['email']; // Admin Support Email
    	$payment_method =  $all_sitesetting['payment_mode'];
		
		if(Session::get('payment_method')=='paypal')
    	{
    												
        	$order_id = Session::get('miramix_order_id');				//Order_id
			//echo $order_id;
			$transaction_status ='Canceled';
			$update_order = DB::table('orders')
							->where('id', $order_id)
							->update(['order_status'=>'cancel','transaction_status'=>$transaction_status]);

			/* Order details for perticular order id */
			$order_list = DB::table('orders')
	                    ->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id')
	                    ->select('orders.*', 'order_items.brand_id', 'order_items.brand_name','order_items.brand_email', 'order_items.product_id', 'order_items.product_name', 'order_items.product_image', 'order_items.quantity', 'order_items.price', 'order_items.form_factor_id', 'order_items.form_factor_name')
	                    ->where('orders.id','=',$order_id)
	                    ->get();
			//print_r($order_list); exit;

            Session::put('order_number',$order_list[0]->order_number);
            Session::put('order_id',$order_id);

			if(Session::has('member_userid')){
				$user_details = DB::table('brandmembers')->where('id', Session::get('member_userid'))->first();
				
				$name = $user_details->fname.' '.$user_details->lname;
				$username = $user_details->username;
				if($name!='')
					$mailing_name = $name;
				else
					$mailing_name = $username;

	            $user_email = $user_details->email; 

        	}else{
        		//for guest checkout

        		$guestdata=Session::get('guest_array');
        		$name = $guestdata["guest_fname"].' '.$guestdata["guest_lname"];
				$username = Session::get('guest_username_sess');
				$mailing_name = $name;

	            $user_email = $guestdata["guest_email"]; 
        	}

        /* ========================= Remove session ==================================== */	
			Session::forget('payment_method');
	        Session::forget('step3');
	        Session::forget('step1');
	        Session::forget('guest_array');
	        Session::forget('guest');
	        Session::forget('coupon_code');
            Session::forget('coupon_type');
            Session::forget('coupon_discount');
            Session::forget('coupon_amount');
            Session::forget('share_coupon_status');
            Session::forget('product_id');
            Session::forget('force_social_share');

		/* ========================= End Remove session ==================================== */	

            /* Mail For Member  */
            $sent = Mail::send('frontend.checkout.order_cancel_mail', array('admin_users_email'=>$admin_users_email,'receiver_name'=>$mailing_name,'email'=>$user_email,'order_list'=>$order_list), 
            function($message) use ($admin_users_email, $user_email,$mailing_name)
            {
                $message->from($admin_users_email);  //support mail
                $message->to($user_email, $mailing_name)->subject('Miramix Order Details');
            });


    	}
    	return view('frontend.checkout.payment_cancel',array('title'=>'MIRAMIX | Checkout-Cancel'));
    }

    public function checkoutAuthorize($id)
    {
    	$sitesettings = DB::table('sitesettings')->get();
    	$all_sitesetting = array();
    	foreach($sitesettings as $each_sitesetting)
	    {
	    	$all_sitesetting[$each_sitesetting->name] = $each_sitesetting->value; 
    	}
    	
    	$admin_users_email = $all_sitesetting['email']; // Admin Support Email
    	$payment_method =  $all_sitesetting['payment_mode'];

    	if($payment_method == 'test')
        {
        	$authorize_url = $all_sitesetting['authorize.net_url_test'];	
        	$authorize_login_key = $all_sitesetting['authorize.net_login_key_test'];
        	$authorize_transaction_key = $all_sitesetting['authorize.net_transaction_key_test'];
        }
        elseif($payment_method == 'live')
        {
        	$authorize_url = $all_sitesetting['authorize.net_url_live'];	
        	$authorize_login_key = $all_sitesetting['authorize.net_login_key_live'];
        	$authorize_transaction_key = $all_sitesetting['authorize.net_transaction_key_live'];
        }

		//echo 'cn='.Session::get('card_number').' card_exp_month= '.Session::get('card_exp_month').'  pm= '.Session::get('payment_method'); exit;
    	$order_id = $id;
    	$order_details = DB::table('orders')->where('id',$order_id)->first();

    	/* Order details for perticular order id */
		$order_list = DB::table('orders')
                    ->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id')
                    ->select('orders.*', 'order_items.brand_id', 'order_items.brand_name','order_items.brand_email', 'order_items.product_id', 'order_items.product_name', 'order_items.product_image', 'order_items.quantity', 'order_items.price', 'order_items.form_factor_id', 'order_items.form_factor_name')
                    ->where('orders.id','=',$order_id)
                    ->get();
		
    	$post_url = $authorize_url; //"https://test.authorize.net/gateway/transact.dll";

		$post_values = array(
			
			// the API Login ID and Transaction Key must be replaced with valid values
			"x_login"			=> $authorize_login_key, 		//"2BPuf2X4wmn",
			"x_tran_key"		=> $authorize_transaction_key, //"7kR5A9k8xa8F9ztz",
			"x_version"			=> "3.1",
			"x_delim_data"		=> "TRUE",
			"x_delim_char"		=> "|",
			"x_relay_response"	=> "FALSE",
			"x_type"			=> "AUTH_CAPTURE",
			"x_method"			=> "CC",
			"x_trans_id"		=> uniqid(),
			"x_card_num"		=> Session::get('card_number'), //"4042760173301988", $card_number
			"x_exp_date"		=> Session::get('card_exp_month').Session::get('card_exp_year'),				//$card_exp_month.$card_exp_year 
			"x_amount"			=> $order_details->order_total,
			"x_description"		=> "Miramix Transaction"
			
		);
		//echo "<pre>"; print_r($post_values); exit;
		// This section takes the input fields and converts them to the proper format
		// for an http post.  For example: "x_login=username&x_tran_key=a1B2c3D4"
		$post_string = "";
		foreach( $post_values as $key => $value )
			{ $post_string .= "$key=" . urlencode( $value ) . "&"; }
		$post_string = rtrim( $post_string, "& " );

		$request = curl_init($post_url); // initiate curl object
			curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
			curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
			curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data
			curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
			$post_response = curl_exec($request); // execute curl post and store results in $post_response
			
			curl_close ($request); // close curl object

		// This line takes the response and breaks it into an array using the specified delimiting character
		$response_array = explode($post_values["x_delim_char"],$post_response);

		//echo "<pre>"; print_r($response_array); exit;



		if($response_array[0] == ''){
			Session::flash('error', 'Something is wrong here!!!');
			Session::put('order_number',$order_list[0]->order_number);
            Session::put('order_id',$order_id);

		    /* ========================= Remove session ==================================== */	
				Session::forget('payment_method');
		        Session::forget('step3');
		        Session::forget('step1');
		        Session::forget('guest_array');
		        Session::forget('guest');
		        Session::forget('coupon_code');
		        Session::forget('coupon_type');
		        Session::forget('coupon_discount');
		        Session::forget('coupon_amount');
		        Session::forget('share_coupon_status');
                Session::forget('product_id');
                Session::forget('force_social_share');
			/* ========================= End Remove session ==================================== */	


            return redirect('/checkout-cancel'); 
        }

		if($response_array[0] == 1)
		{ 
			//echo "ss= ".$admin_users_email; exit;
			$transaction_status ="Completed";
			$update_order = DB::table('orders')
							->where('id', $order_id)
							->update(['order_status'=>'processing','card_type'=>$response_array[51],'card_number' => $response_array[50],'transaction_id' => $response_array[6],'transaction_status'=>$transaction_status,'response_code'=>$response_array[0]]);

			$mobile = '' ;
			
			if(Session::has('member_userid')){
				$user_details = DB::table('brandmembers')->where('id', Session::get('member_userid'))->first();
				
				$name = $user_details->fname.' '.$user_details->lname;
				$username = $user_details->username;
				if($name!='')
					$mailing_name = $name;
				else
					$mailing_name = $username;

	            $user_email = $user_details->email; 
	            $mobile =  $user_details->phone_no; // logged user  phone number
		    
		    
		    //update user's points
		    $order_total=$order_details->sub_total;
				$price_for_point = DB::table('sitesettings')->where('name','price_for_point')->first();
				$points=round($order_total/$price_for_point->value)+$user_details->user_points;
				
				if($order_details->redeem_amount>0){
				$points=$points-($order_details->redeem_amount/$price_for_point->value);
				}
				
				DB::table('brandmembers')
			                                ->where('id', Session::get('member_userid'))
			                                ->update(['user_points' => $points]);

        	}
        	else
        	{
        		//for guest checkout
        		$guestdata=Session::get('guest_array');
        		$name = $guestdata["guest_fname"].' '.$guestdata["guest_lname"];
				$username = Session::get('guest_username_sess');
				$mailing_name = $name;
	            $user_email = $guestdata["guest_email"]; 
	            $mobile =  $guestdata["guest_phone"]; // logged user  phone number
        	}
            
            

            /* Mail For Member  */
            $sent = Mail::send('frontend.checkout.order_details_mail', array('admin_users_email'=>$admin_users_email,'receiver_name'=>$mailing_name,'email'=>$user_email,'order_list'=>$order_list), 
            function($message) use ($admin_users_email, $user_email,$mailing_name)
            {
                $message->from($admin_users_email);  //support mail
                $message->to($user_email, $mailing_name)->subject('Miramix Order Details');
            });

            /* Mail For Brand */
            /*$branduser = array();
            foreach($order_list as $each_order_list)
            {

            	$branduser[$each_order_list->brand_email]=$each_order_list->brand_name;

            }
            foreach($branduser as $brand_email=>$brand_name)
            {
            	$items=array();
            	foreach($order_list as $each_order_list)
            	{
            			if($each_order_list->brand_email!=$brand_email) continue;

            			$items[]=$each_order_list;
            	}

            	$sent_brand = Mail::send('frontend.checkout.brand_order_details_mail', array('admin_users_email'=>$admin_users_email,'brand_name'=>$brand_name,'brand_email'=>$brand_email,'order_list'=>$items), 
		            function($message) use ($admin_users_email, $brand_email,$brand_name)
		            {
		                $message->from($admin_users_email); //support mail
		                $message->to($brand_email, $brand_name)->subject('Miramix Order Details For Brand');
		            });
            }*/

            /* Mail For Admin */
            $admin_user = DB::table('users')->first();

            $admin_email = $admin_user->email;

            if(($admin_user->name)!='')
            	$admin_name = $admin_user->name;
            else
            	$admin_name = 'Admin';

            $sent_admin = Mail::send('frontend.checkout.admin_order_details_mail', array('admin_users_email'=>$admin_users_email,'receiver_name'=>$admin_name,'admin_email'=>$admin_email,'order_list'=>$order_list), 
            function($message) use ($admin_users_email, $admin_email,$admin_name)
            {
                $message->from($admin_users_email);  //support mail
                $message->to($admin_email, $admin_name)->subject('Miramix Order Details For Admin');
            });


            if( ! $sent) 
            {
              Session::flash('error', 'something went wrong!! Mail not sent.'); 
              //return redirect('member-forgot-password');
            }
            else
            {
              Session::flash('success', 'Your order successfully placed.'); 
              //return redirect('memberLogin');
            }

            /* TWILIO SMS SENDING AFTER SUCCESSFUL ORDER START */

	            if($mobile !='')
	            {
	            	$order_message = "Thanks for your order at The Miramix"."\r\n";
	            	$order_message .="Order Number :".$order_list[0]->order_number." Order Amount: ".$order_list[0]->order_total;
	            	Twilio::message('+'.$mobile, $order_message);
	            }

		    /* TWILIO SMS SENDING AFTER SUCCESSFUL ORDER START */

            Session::put('order_number',$order_list[0]->order_number);
            Session::put('order_id',$order_id);
			/* ========================= Remove session ==================================== */	
			Session::forget('payment_method');
			Session::forget('step3');
			Session::forget('step1');
			Session::forget('guest_array');
			Session::forget('guest');
			Session::forget('coupon_code');
	        Session::forget('coupon_type');
	        Session::forget('coupon_discount');
	        Session::forget('coupon_amount');
	        Session::forget('share_coupon_status');
            Session::forget('product_id');
            Session::forget('force_social_share');
			/* ========================= End Remove session ==================================== */	

            return redirect('/checkout-success'); 
		}
		else
		{
			$transaction_status = "cancel";
			$update_order = DB::table('orders')
							->where('id', $order_id)
							->update(['order_status'=>'cancel','card_type'=>$response_array[51],'card_number' => $response_array[50],'transaction_id' => $response_array[6],'transaction_status'=>$transaction_status,'response_code'=>$response_array[0]]);
			$msg = $response_array[3];
			Session::flash('error', $msg);
			Session::put('order_number',$order_list[0]->order_number);
            Session::put('order_id',$order_id);
			/* ========================= Remove session ==================================== */	
			Session::forget('payment_method');
			Session::forget('step3');
			Session::forget('step1');
			Session::forget('guest_array');
			Session::forget('guest');
			Session::forget('coupon_code');
	        Session::forget('coupon_type');
	        Session::forget('coupon_discount');
	        Session::forget('coupon_amount');
	        Session::forget('share_coupon_status');
            Session::forget('product_id');
            Session::forget('force_social_share');
			/* ========================= End Remove session ==================================== */	

            return redirect('/checkout-cancel'); 
		}	
    }

    /* update Cart Start */

    private function update_cart($uid)
	{
		/*  All cart get from DB of logged user */
	
		//echo "<pre>"; print_r($db_cart); exit;					
		$cart_num = Cart::count(); //Count cart item from session
		
		if($cart_num>0)  // If there cart data in Session
		{
			//add to db for guest user's added cart
			$content = Cart::content();
			foreach($content as $eachcontentCart)
			{
				$cartRowId = $eachcontentCart->rowid;
			}
			//echo "<pre>";print_r($content);
			
			foreach($content as $each_content)
			{
				$product_id = $each_content->id;
				$product_name = $each_content->name;
				$product_quantity = $each_content->qty;
				$product_price = $each_content->price; // Price amount for each item
				$product_duration = $each_content->options->duration;
				$product_no_of_days = $each_content->options->no_of_days;
				$product_form_factor = $each_content->options->form_factor;
				$subtotal = $each_content->subtotal;
				$cartRowId = $each_content->rowid;
				
				 $cartContent = DB::table('carts')
                                ->where('user_id',Session::get('member_userid'))
                                ->where('product_id',$product_id)
                                ->where('no_of_days',$product_no_of_days)
                                ->where('form_factor',$product_form_factor)
                                ->first();
								
				if(count($cartContent)<1) // cart item not matches with database content so, insert as a new cart item
				{
					$insert_cart = DB::table('carts')->insert(['user_id' => Session::get('member_userid'), 'row_id' => $cartRowId, 'product_id' => $product_id , 'product_name' => $product_name, 'quantity' => $product_quantity, 'amount' => $product_price, 'duration' => $product_duration, 'no_of_days' => $product_no_of_days, 'form_factor' => $product_form_factor,'sub_total' => $subtotal, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
					//exit;
				}
				else  // cart item  matches with database content so, update quantity ofthat particular item
				{
					$new_quantity = ($cartContent->quantity)+$product_quantity;  //quantity from DB + cart item quantity
                    $new_sub_total = $new_quantity * $product_price;            // Sub Total 
					$update_cart = DB::table('carts')
										->where('cart_id', $cartContent->cart_id)
										->update(['quantity' => $new_quantity,'sub_total'=>$new_sub_total]);
				}
			} //Foreach End
			//now db contains all previous and current added cart items...so deleted all cart items and add all contents from db
			
			Cart::destroy(); // After inserting all cart data into database just
			
			
		} // Cart session If End
		 
		 
		 /*  All cart get from DB of logged user */
			 $dbCartContent = DB::table('carts')
                                ->where('user_id',Session::get('member_userid'))
                               ->get();
			
			foreach($dbCartContent as $eachCartContent)
			{
				Cart::add($eachCartContent->product_id, $eachCartContent->product_name, $eachCartContent->quantity, $eachCartContent->amount, array('duration' => $eachCartContent->duration,'no_of_days'=>$eachCartContent->no_of_days,'form_factor'=>$eachCartContent->form_factor));	

			}
			
			DB::table('carts')->where("user_id",Session::get('member_userid'))->delete();
			
			$content = Cart::content();
			foreach($content as $each_content)
			{
				$product_id = $each_content->id;
				$product_name = $each_content->name;
				$product_quantity = $each_content->qty;
				$product_price = $each_content->price; // Price amount for each item
				$product_duration = $each_content->options->duration;
				$product_no_of_days = $each_content->options->no_of_days;
				$product_form_factor = $each_content->options->form_factor;
				$subtotal = $each_content->subtotal;
				$cartRowId = $each_content->rowid;
				 
				
				$insert_cart = DB::table('carts')->insert(['user_id' => Session::get('member_userid'), 'row_id' => $cartRowId, 'product_id' => $product_id , 'product_name' => $product_name, 'quantity' => $product_quantity, 'amount' => $product_price, 'duration' => $product_duration, 'no_of_days' => $product_no_of_days, 'form_factor' => $product_form_factor,'sub_total' => $subtotal, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
			}
	}

	/* update Cart End */
	
    public function uspsAddressValidate(){
	
	 $street = Request::input('street');
     $city = Request::input('city');
	 $state = Request::input('state');
	 $zip = Request::input('zip');
	 
	 $status=Usps::varifyaddress(array("Address1"=>$street,"Address2"=>$street,"City"=>$city,"State"=>$state,"Zip4"=>$zip));
	 echo $status;
	
    }

    public function socialShareContent()  // this page only share content from cart page
    {
    /* Site Setting Start */
        $sitesettings = DB::table('sitesettings')->get();
        $all_sitesetting = array();
        foreach($sitesettings as $each_sitesetting)
        {
            $all_sitesetting[$each_sitesetting->name] = $each_sitesetting->value; 
        }

    /* End */   
    return view('frontend.product.social_share',compact('all_sitesetting'),array('title'=>'Share Content'));
    }
    
	public function socialShareCheckout()
	{
		if(Session::has('product_id'))
		{
		  $product_array = Session::get('product_id');
		}
		else
		{
		   $product_array = array();
		}
		$product_array[] = Input::get('product_id');
		Session::put('product_id',serialize($product_array));

		// If Social Share from Cart Page and Checkout Page.
		if(Input::get('product_id') == 'social_share')
		{
		  Session::put('force_social_share','social_share'); 
		  return redirect('/checkout');
		}
	}
}