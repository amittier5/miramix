<?php namespace App\Http\Controllers\Frontend; /* path of this controller*/

use App\Model\Brandmember; /* Model name*/
use App\Model\Newsletter;
use App\Http\Requests;
use App\Http\Controllers\Controller;    
use Illuminate\Support\Facades\Request;
use Mail;
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
use App\Helper\helpers;
use Cart;
use App\Model\Subscription;


class HomeController extends BaseController {

    public function __construct() 
    {
        parent::__construct();
	       
        $obj = new helpers();
        view()->share('obj',$obj);
    }
   /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
	
        $body_class = 'home';
	$page=Request::input('page');
	if(!empty($page)){
	    $current_page = filter_var($page, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
	    if(!is_numeric($current_page)){die('Invalid page number!');} //incase of invalid page number
	    if($current_page<1){$current_page=1;}
	}else{
	    $current_page = 1; //if there's no page number, set it to 1
	}
	
	

	$item_per_page=6;
	
	$products =DB::table('products')
                 ->select(DB::raw('products.id,products.brandmember_id,products.product_name,products.product_slug,products.image1, MIN(`actual_price`) as `min_price`,MAX(`actual_price`) as `max_price`,products.created_at'))
                 ->leftJoin('product_formfactors', 'products.id', '=', 'product_formfactors.product_id')
                 ->leftJoin('brandmembers', 'products.brandmember_id', '=', 'brandmembers.id')
                 ->where('subscription_status', "active")
                 ->where('brandmembers.admin_status', 1)
                 ->where('is_deleted', 0)
                 ->whereRaw('products.active="1"')
		 ->where('product_formfactors.actual_price','!=', 0)
                 ->groupBy('product_formfactors.product_id');
                
	$tags=Request::input('tags');  
	  if(!empty($tags)){
	    $tag=explode(",",$tags);
	    $ptags='';
	    foreach($tag as $t){
		$ptags .=trim($t)."','";
	    }
	    $ptags=rtrim($ptags,",'");
	    
	    $tagpro = DB::table('searchtags')->whereRaw("name IN('".$ptags."')")->get();
	    
	    $pids='';
	    foreach($tagpro as $tagp){
		 $pids .=$tagp->product_id.",";
	    }
	   
	   $pids=rtrim($pids,",");
	  
	    $i=1;
	   /* foreach($tag as $t){
		if($i==1){
		$products->whereRaw('product_name LIKE "%'.trim($t).'%"');
		}else{
		    $products->orWhereRaw('product_name LIKE "%'. trim($t).'%"');
		}
		$products->orWhereRaw('INSTR(tags,"'.trim($t).'")');
		$i++;
	    }*/
	  if(!empty($pids)){ 
	   $products->whereRaw('products.id IN('.$pids.')');
	  }
	  
	  }
	$sortby=Request::input('sortby');
	 if(!empty($sortby)){
	    
	    if($sortby=='popularity'){
		$products->orderBy('popularity', 'DESC');
	    }elseif($sortby=='price'){
		$products->orderBy('min_price', 'ASC');
	    }elseif($sortby=='date'){
		$products->orderBy('created_at', 'DESC');
	    }else{
		$products->orderBy('id', 'DESC');
	    }
	    
	 }
	 $products=$products->paginate($item_per_page);
	 
	
	 
	 
	 /*$products2 = DB::table('products')
                 
                 ->where('is_deleted', 0)
                 ->whereRaw('products.active="1"')
                 ;*/
      $products2 = DB::table('products')
                 ->select(DB::raw('products.id,products.brandmember_id,products.product_name,products.product_slug,products.image1, MIN(`actual_price`) as `min_price`,MAX(`actual_price`) as `max_price`,products.created_at'))
                 ->leftJoin('product_formfactors', 'products.id', '=', 'product_formfactors.product_id')
                 ->leftJoin('brandmembers', 'products.brandmember_id', '=', 'brandmembers.id')
                 ->where('subscription_status', "active")
                 ->where('brandmembers.admin_status', 1)
                 ->where('is_deleted', 0)
                 ->whereRaw('products.active="1"')
         ->where('product_formfactors.actual_price','!=', 0)
                 ->groupBy('product_formfactors.product_id');          
	$tags=Request::input('tags');  
	  if(!empty($tags)){
	    
	    
	    
	    /*$tag=explode(",",$tags);
	    $i=1;
	    foreach($tag as $t){
		if($i==1){
		$products2->whereRaw('product_name LIKE "%'.trim($t).'%"');
		}else{
		    $products2->orWhereRaw('product_name LIKE "%'.trim($t).'%"');
		}
		$products2->orWhereRaw('INSTR(tags,"'.trim($t).'")');
		$i++;
	    }*/
	   
	    if(!empty($pids)){ 
	    $products2->whereRaw('products.id IN('.$pids.')');
	   }
	  }
	  $p2=$products2->get();
	  $total_records=count($p2);
	
	
	$total_pages=ceil($total_records/$item_per_page);
	
	 $offset = ($current_page - 1)  * $item_per_page;

	    // Some information to display to the user
	    $from = $offset + 1;
	    $to = min(($offset + $item_per_page), $total_records);
	    if($to==0){
		$from=0;
	    }
	if($current_page==1 && (!Request::isMethod('post'))){
        return view('frontend.home.index',compact('body_class','products','item_per_page','current_page','total_records','total_pages','from','to'),array('title'=>'MIRAMIX | Home'));
	}else{
	    
	  
	    
	    
	    
	return view('frontend.home.indexnextpage',compact('body_class','products','item_per_page','current_page','total_records','total_pages','from','to'),array('title'=>'MIRAMIX | Home'));
	   
	   // echo $html = View::make('frontend.home.indexnextpage', compact('body_class','products','item_per_page','current_page','total_records','total_pages'))->render();
	 //exit;
	}
    }
    
    public function homenext(){
	
	echo 'test';
    }

    
    public function userLogout() /* For All user logout */
    {
    	

        if(Session::has('member_userid'))
        {
            Session::forget('member_userid');
            Session::forget('member_user_email');
            Session::forget('payment_method');

            /* Delete Checkout Session */
            Session::forget('select_address');                  
            Session::forget('selected_address_id');
            /* Delete Checkout Session */
            
			Cart::destroy(); // If any thing in cart session destroy the cart session  //
            Session::flash('success', 'You are successfully logged out.'); 
            return redirect('memberLogin');
        }  
        else if(Session::has('brand_userid'))
        {
            Session::forget('brand_userid');
            Session::forget('brand_user_email');
            Session::flash('success', 'You are successfully logged out.'); 
            return redirect('brandLogin');
        } 
        else{
        	 return redirect('home');
        }      
    }


    public function member_login()
    {
        $obj = new helpers();
         if($obj->checkMemberLogin()){
            return redirect('member-dashboard');
        }
	if($obj->checkBrandLogin()){
            return redirect('brand-dashboard');
        }

        if(Request::isMethod('post'))
        {
            $email = Request::input('email');
            $password = Request::input('password');
            $encrypt_pass = Hash::make($password);

            $login_arr = array('email' => $email, 'password' => $encrypt_pass);


            $users = DB::table('brandmembers')->where('email', $email)->where('role', 0)->first();            
           // print_r($_POST);exit;
            
            if($users!=""){

                $user_pass = $users->password;
                // check for password
                if(Hash::check($password, $user_pass)){

                    // Check for active                 
                    $user_cnt = DB::table('brandmembers')->where('email', $email)->where('status', 1)->where('admin_status', 1)->count();
                    //echo $user_cnt;exit;
                    //echo DB::enableQueryLog();exit;
                    if($user_cnt){
                        Session::put('member_userid', $users->id);
						Session::put('member_user_email', $users->email);

                        // Check for remember me
                        if(Request::input('remember_me')==1){
                            Cookie::queue(Cookie::make('mem_email', Request::input('email'), 60 * 24 * 30));
                        }
						$this->update_cart($users->id);
						//exit;
                        return redirect('member-dashboard');
                    }
                    else{
			$site = DB::table('sitesettings')->where('name','email')->first();
                        Session::flash('error', 'Your Status is inactive. Contact Admin at '.$site->value.' to get your account activated!'); 
                        return redirect('memberLogin');
                    }
                }
                else{
                        Session::flash('error', 'Email and password does not match.'); 
                        return redirect('memberLogin');
                }
            }
            else{
                    Session::flash('error', 'Email and password does not match.'); 
                    return redirect('memberLogin');
            }
        }


        // check for remenber me cookie
        $mem_email = '';
        $mem_email = Cookie::get('mem_email');

        return view('frontend.home.member_login',compact('mem_email'),array('title'=>'MIRAMIX | Member Login'));
    } 

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

   
/**************************************  MEMBER FORGOT PASSWORD START ************************************/
/**************************  MEMBER RESET PASSWORD START  **************************/
    public function member_forgotPassword()
    {
        
       $obj = new helpers();
        if($obj->checkUserLogin()){
            return redirect('member-dashboard');
        }

        if(Request::isMethod('post'))
        {
            $email = Request::input('email');
            $brandmembers = DB::table('brandmembers')->where('email', '=', $email)->where('role', '=', 0)->first();
            $random_code = mt_rand();
            $updateWithCode = DB::table('brandmembers')->where('email', '=', $email)->update(array('code_number' => $random_code));
            $sitesettings = DB::table('sitesettings')->get();
            //exit;
            if(!empty($sitesettings))
            {
            foreach($sitesettings as $each_sitesetting)
            {
              if($each_sitesetting->name == 'email')
              {
                $admin_users_email = $each_sitesetting->value;
              }
            }
            }

            if(!(empty($brandmembers)))
            {
                $user_name = $brandmembers->fname.' '.$brandmembers->lname;
                $user_email = $brandmembers->email;
                $resetpassword_link = url().'/member-reset-password/'.base64_encode($user_email).'-'.base64_encode($random_code);
                //echo $resetpassword_link; exit;
 				$sent = Mail::send('frontend.home.reset_password_link', array('name'=>$user_name,'email'=>$user_email,'reset_password_link'=>$resetpassword_link,'admin_users_email'=>$admin_users_email), 
                function($message) use ($admin_users_email, $user_email,$user_name)
                {
                    $message->from($admin_users_email);
                    $message->to($user_email, $user_name)->subject('Forgot Password Email!');
                });

                if( ! $sent) 
                {
                  Session::flash('error', 'something went wrong!! Mail not sent.'); 
                  return redirect('member-forgot-password');
                }
                else
                {
                  Session::flash('success', 'Please check your email to reset your password.'); 
                  return redirect('memberLogin');
                }              
            }
            else
            {
              Session::flash('error', 'Email Id not matched.'); 
              return redirect('member-forgot-password');
            }

        }
        
        return view('frontend.home.memberforgotpassword');
    }
  
    public function member_resetpassword($link=false)
    {
        if($link !='')
        {
            $link_arr = explode('-',$link);
            if(!empty($link_arr))
            {
                $user_email_en = $link_arr[0];     // encrypted email
                $user_code_en = $link_arr[1];     // encrypted code
            }
        }
          $user_email = base64_decode($user_email_en);
          $user_code = base64_decode($user_code_en);

        if(Request::isMethod('post'))
        {
            $password = Request::input('password');
            $conf_pass = Request::input('con_password');
           // echo $password." - ".$conf_pass. "email= ".$user_email; exit;
            $update = DB::table('brandmembers')->where('email', $user_email)->update(array('password' => Hash::make($password)));
            
            if($update)
            {
                Session::flash('success', 'Password successfully changed.'); 
                return redirect('memberLogin');
            }
            else
            {
                Session::flash('error', 'Password not changed.Somthing wrong!'); 
                return redirect('memberLogin');
            }
            
        }
       
        return view('frontend.home.memberresetpassword',array('title'=>'Reset Password','link'=>$link));

    }

 /**************************  MEMBER RESET PASSWORD END  **************************/
/**************************************  MEMBER FORGOT PASSWORD END ************************************/
/*
    public function brand_change_pass()
    { 
        $obj = new helpers();
        if(!$obj->checkBrandLogin()){
            return redirect('brandLogin');
        }
        if(Request::isMethod('post'))
        {

            if(!Session::has('brand_userid')){
                return redirect('brandLogin');
            }

           // print_r($_POST);exit;
          $old_password = Request::input('old_password');
          

          $password = Request::input('password');
          $conf_pass = Request::input('conf_pass');

          // Get Admin's password

          $user=Brandmember::find(Session::get('brand_userid'));
          

          if(Hash::check($old_password, $user['password']))
          {
            if($password!=$conf_pass){
              Session::flash('error', 'Password and confirm password is not matched.'); 
              return redirect('brandChangePass');

            }
            else{
              DB::table('brandmembers')->where('id', Session::get('brand_userid'))->update(array('password' => Hash::make($password)));
              
              Session::flash('success', 'Password successfully changed.'); 
              return redirect('brandChangePass');
            }
          }
          else{
            Session::flash('error', 'Old Password does not match.'); 
            return redirect('brandChangePass');
          }
        }

        return view('frontend.home.brandchangepassword',array('title' => 'Brand Change Password'));
    }
*/
    public function brand_login()
    {
        //echo Hash::make(123456); exit;
        $obj = new helpers();
        if($obj->checkMemberLogin()){
            return redirect('member-dashboard');
        }
	if($obj->checkBrandLogin()){
            return redirect('brand-dashboard');
        }
        if(Request::isMethod('post'))
        {
            $email = Request::input('email');
            $password = Request::input('password');

            $users = DB::table('brandmembers')->where('email', $email)->where('role', 1)->first();
            if($users!=""){

                $user_pass = $users->password;
                // check for password
                if(Hash::check($password, $user_pass)){

                    // Check for active                 
                    $user_cnt = DB::table('brandmembers')->where('email', $email)->where('status', 1)->count();

                    if($user_cnt){
		    
		    
		    /******************  check subscription **************************/
		    
		    
		    $subscription = DB::table('subscription_history')->where('member_id', $users->id)->orderBy('subscription_id','DESC')->first();
		    if(count($subscription)<=0){
			
			$end_date=date("Y-m-d",strtotime($users->created_at .' + 30 days'));
			$setting = DB::table('sitesettings')->where('name', 'brand_fee')->first();
			
			$subdata=array("member_id"=>$users->id,"start_date"=>$users->created_at,"end_date"=>$end_date,"subscription_fee"=>$setting->value);
			Subscription::create($subdata);
			
		    }else{
			
			$today=Date('Y-m-d');
			$enddate=date("Y-m-d",strtotime($subscription->end_date." + 1 day"));
			
			if($today>$enddate && $subscription->payment_status=='pending'){
			    
			    //Session::flash('error', 'Your subscription is expired. Contact Admin to activated your account'); 
			    //return redirect('brandLogin');
			     $updateWithCode = DB::table('brandmembers')->where('id', '=', $users->id)->update(array('subscription_status' => 'expired'));
			    
			}else{
			   $updateWithCode = DB::table('brandmembers')->where('id', '=', $users->id)->update(array('subscription_status' => 'active'));  
			    
			}
			
			
		    }
		    
		    /******************  check subscription **************************/
		    
		    
                         // Check for remember me
                        if(Request::input('remember_me')==1){
                            Cookie::queue(Cookie::make('brand_email', Request::input('email'), 60 * 24 * 30));
                        }
                        Session::put('brand_userid', $users->id);
						Session::put('brand_user_email', $users->email);
                        return redirect('brand-dashboard');
                    }
                    else{
                        Session::flash('error', 'Your Status is inactive. Contact Admin to activated your account'); 
                        return redirect('brandLogin');
                    }
                }
                else{
                        Session::flash('error', 'Email and password does not match.'); 
                        return redirect('brandLogin');
                }
            }
            else{
                    Session::flash('error', 'Email and password does not match.'); 
                    return redirect('brandLogin');
            }
        }
        // check for remenber me cookie
        $brand_email = '';
        $brand_email = Cookie::get('brand_email');
	$subfee = DB::table('sitesettings')->where('name','brand_fee')->first();
	$subprofee = DB::table('sitesettings')->where('name','brand_perproduct_fee')->first();
	
        return view('frontend.home.brand_login',compact('brand_email','subfee','subprofee'),array('title'=>'MIRAMIX | Brand Login'));
    }   

    /**************************************  BRAND FORGOT PASSWORD START ************************************/
                /**************************  BRAND RESET PASSWORD START  **************************/
    public function brand_forgotPassword()
    {
        $obj = new helpers();
        if($obj->checkUserLogin()){
            return redirect('brand-dashboard');
        }

        if(Request::isMethod('post'))
        {
            $email = Request::input('email');
            $brandmembers = DB::table('brandmembers')->where('email', '=', $email)->where('role', '=', 1)->first();
            $random_code = mt_rand();
            $updateWithCode = DB::table('brandmembers')->where('email', '=', $email)->update(array('code_number' => $random_code));
            $sitesettings = DB::table('sitesettings')->get();
            //exit;
            if(!empty($sitesettings))
            {
            foreach($sitesettings as $each_sitesetting)
            {
              if($each_sitesetting->name == 'email')
              {
                $admin_users_email = $each_sitesetting->value;
              }
            }
            }

            if(!(empty($brandmembers)))
            {
                $user_name = $brandmembers->fname.' '.$brandmembers->lname;
                $user_email = $brandmembers->email;
                $resetpassword_link = url().'/brand-reset-password/'.base64_encode($user_email).'-'.base64_encode($random_code);
                //echo $resetpassword_link; exit;
                $sent = Mail::send('frontend.home.reset_password_link', array('name'=>$user_name,'email'=>$user_email,'reset_password_link'=>$resetpassword_link), 
                function($message) use ($admin_users_email, $user_email,$user_name)
                {
                    $message->from($admin_users_email);
                    $message->to($user_email, $user_name)->subject('Forgot Password Email!');
                });

                if( ! $sent) 
                {
                  Session::flash('error', 'something went wrong!! Mail not sent.'); 
                  return redirect('brand-forgot-password');
                }
                else
                {
                  Session::flash('success', 'Please check your email to reset your password.'); 
                  return redirect('brandLogin');
                }              
            }
            else
            {
              Session::flash('error', 'Email Id not matched.'); 
              return redirect('brand-forgot-password');
            }

        }
        
        return view('frontend.home.brandforgotpassword');
    }
  
    public function brand_resetpassword($link=false)
    {
        if($link !='')
        {
            $link_arr = explode('-',$link);
            if(!empty($link_arr))
            {
                $user_email_en = $link_arr[0];     // encrypted email
                $user_code_en = $link_arr[1];     // encrypted code
            }
        }
          $user_email = base64_decode($user_email_en);
          $user_code = base64_decode($user_code_en);

        if(Request::isMethod('post'))
        {
            $password = Request::input('password');
            $conf_pass = Request::input('con_password');
           // echo $password." - ".$conf_pass. "email= ".$user_email; exit;
            $update = DB::table('brandmembers')->where('email', $user_email)->update(array('password' => Hash::make($password)));
            
            if($update)
            {
                Session::flash('success', 'Password successfully changed.'); 
                return redirect('brandLogin');
            }
            else
            {
                Session::flash('error', 'Password not changed.Somthing wrong!'); 
                return redirect('brandLogin');
            }
            
        }
       
        return view('frontend.home.brandresetpassword',array('title'=>'Reset Password','link'=>$link));

    }

            /**************************  BRAND RESET PASSWORD END  **************************/
/**************************************  BRAND FORGOT PASSWORD END ************************************/

/**************************************  MEMBER DASH-BOARD AND MEMBER ACCOUNT START ************************************/

   /* public function memberDashboard()
    { 
        $body_class = 'home';
        $member_details = Brandmember::find(Session::get('member_userid'));
        return view('frontend.home.member_dashboard',compact('member_details','body_class'),array('title'=>'MIRAMIX | Member Dashboard'));
    } 

    public function memberAccount()
    {
        $obj = new helpers();
        if(!$obj->checkMemberLogin())
        {
            return redirect('home');
        }

        $body_class = 'home';
        return view('frontend.home.member_account',compact('body_class'),array('title'=>'Member Information'));
    }
*/
   
   public function searchtags(){
     $obj = new helpers();
    $stags=array();
    $terms=Request::input('term');
     $tags = DB::table('searchtags')->where('name', 'LIKE', '%'.Request::input('term').'%')->groupBy('name')->orderBy('popularity', 'DESC')->get();
    // echo $obj->get_last_query();
    //exit;
     $product_id='';
     foreach($tags as $tag){
	//$tag=preg_replace( "/\r|\n/", "", $tag->name );
	//$tag=str_replace(" ","",$tag);
    $stags[]=array("id"=>$tag->product_id,"value"=>$tag->name,"tags"=>$tag->name);
    
    }
    
    /* $products = DB::table('products')->where('active', 1)->where('is_deleted', 0);
     if(!empty($terms)){
	$products->where('product_name', 'LIKE', Request::input('term').'%');
	$products->orwhereRaw('INSTR(tags,"'.Request::input('term').'")');
     }
     $products=$products->skip(0)->take(10)->get();
     
    foreach($products as $product){
	$tag=preg_replace( "/\r|\n/", "", $product->tags );
	$tag=str_replace(" ","",$tag);
    $tags[]=array("id"=>$product->id,"value"=>$product->product_name,"tags"=>$tag);
    
    }*/
    
    echo json_encode($stags);
   }
   
   public function newsletterajax(){
    $email=Input::get('newsemail');
   
    
     if(Session::has('member_userid'))
        {
            $member = Brandmember::find(Session::get('member_userid'));
	   		$newsletter=array("email"=>$email,"fname"=>$member->fname,"lname"=>$member->lname,"created_on"=>date("Y-m-d H:s:i"),"status"=>1);
	   		$subscriber = (($member->fname) =='')?$member->username:$member->fname;
        }  
        else if(Session::has('brand_userid'))
        {
          	$member = Brandmember::find(Session::get('brand_userid'));
	   		$newsletter=array("email"=>$email,"fname"=>$member->fname,"lname"=>$member->lname,"created_on"=>date("Y-m-d H:s:i"),"status"=>1);
	   		$subscriber = $member->fname;
	   
        }
        else
        {
	  		$newsletter=array("email"=>$email,"fname"=>'guest',"lname"=>'guest',"created_on"=>date("Y-m-d H:s:i"),"status"=>1); 
	  		$subscriber = 'subscriber';
		}

	$setting = DB::table('sitesettings')->where('name', 'email')->first();
	$admin_users_email=$setting->value;

    $countexists = DB::table('newsletter_subscription')->where('email', '=', $email)->count();
    if($countexists>0){
	    $result=array("message"=>"You have already subscribed.","status"=>"fail");
	    
	
	}else{
	    $newsletterres= Newsletter::create($newsletter);
	    $result=array("message"=>"You have successfully subscribed.","status"=>"success");

	    $sent = Mail::send('frontend.home.newsletter', array('admin_users_email'=>$admin_users_email,'subscriber'=>$subscriber), 
            function($message) use ($admin_users_email,$email)
            {
                $message->from($admin_users_email);  //support mail
                $message->to($email)->subject('Miramix Subscription Mail');
            });
	}
    
     echo json_encode($result);
   }
   
   public function show404(){
    
    echo 'Page not found';
   }

   public function tagPopularity()
   {
        $tag_name = Input::get('tag');
        $tagpopularity = DB::table('searchtags')
                            ->where('name', 'like', '%'.$tag_name)->get();
           //echo "<pre>";print_r($tagpopularity); exit;                 
        if(!empty($tagpopularity))
        {
            foreach($tagpopularity as $eachtag)
            {
                //echo $eachtag->popularity; 
                $popularity =$eachtag->popularity;
                $popularity = $popularity+1;
                $update_tagpopularity = DB::table('searchtags')
                                            ->where('id', $eachtag->id)
                                            ->update(['popularity' => $popularity]);
            }
        }
        echo 1;
        exit;
   }

}