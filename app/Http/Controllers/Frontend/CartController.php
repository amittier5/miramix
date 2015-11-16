<?php namespace App\Http\Controllers\Frontend; /* path of this controller*/

use App\Model\Brandmember; /* Model name*/
use App\Model\Ingredient; /* Model name*/
use Illuminate\Support\Collection;
use App\Http\Requests;
use App\Http\Controllers\Controller;    
use Illuminate\Support\Facades\Request;

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
//use Anam\Phpcart\Cart;
use Cart;

class CartController extends BaseController {

    public function __construct() 
    {
        parent::__construct();
        $obj = new helpers();
        if(!$obj->checkBrandLogin())
        {
            $brandlogin = 0; // Logged as a member
        }
        else
        {
            $brandlogin = 1; // Logged as a brand
        }
        view()->share('brandlogin',$brandlogin);
    }
   /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        
    }

    public function cart2()
        {
            //Cart::remove("76c580d3655de904428445212b864688");
            //echo 1; //exit;
           
		   // Cart::destroy(); 
             $content = Cart::content();
            echo "<pre>";print_r($content);
    }

    public function cart()
    {
        $obj = new helpers();
        $product_id = Input::get('product_id');
        $quantity = Input::get('quantity');
        $product_name = Input::get('product_name');
        $amount = Input::get('amount');
        $duration = Input::get('duration');
        $no_of_days = Input::get('no_of_days');
        $form_factor = Input::get('form_factor');
        
		$res=Cart::add($product_id, $product_name, $quantity, $amount, array('duration' => $duration,'no_of_days'=>$no_of_days,'form_factor'=>$form_factor));
		$content = Cart::content();
		//print_r($content);
		//echo $content->rowid;
		
		foreach($content as $eachcontentCart)
		{
			$cartRowId = $eachcontentCart->rowid;
            $sub_total = $eachcontentCart->subtotal;
		}
		
        if($obj->checkMemberLogin())
        {
            $cartContent = DB::table('carts')
                                ->where('user_id',Session::get('member_userid'))
                                ->where('product_id',$product_id)
                                ->where('no_of_days',$no_of_days)
                                ->where('form_factor',$form_factor)
                                ->first();

            if(count($cartContent)<1)
            {
                $insert_cart = DB::table('carts')->insert(['user_id' => Session::get('member_userid'), 'row_id' => $cartRowId, 'product_id' => $product_id , 'product_name' => $product_name, 'quantity' => $quantity, 'amount' => $amount, 'duration' => $duration, 'no_of_days' => $no_of_days, 'form_factor' => $form_factor,'sub_total' => $sub_total, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            }
            else
            {
                $new_quantity = ($cartContent->quantity)+$quantity;
                $new_sub_total = $new_quantity * $amount;
                $update_cart = DB::table('carts')
                                    ->where('cart_id', $cartContent->cart_id)
                                    ->update(['quantity' => $new_quantity,'sub_total'=>$new_sub_total]);
            }
            
        }
		$str = Cart::count();
		echo $str; 
    }

    

    public function showAllCart()
    {
        /*----- Only Member Will Access This Page ----*/
        $obj = new helpers();
        if(!$obj->checkMemberLogin())
        {
            return redirect('home');
        }

        $content = Cart::content();
        //echo "<pre>";print_r($content);
        
        foreach($content as $each_content)
        {
            
            $product_res = DB::table('products')->where('id',$each_content->id)->first();
           // echo $each_content->brandmember_id; exi
            $brandmember = DB::table('products')
                                ->leftJoin('brandmembers', 'brandmembers.id', '=', 'products.brandmember_id')
                                ->select('products.*', 'brandmembers.fname', 'brandmembers.lname', 'brandmembers.username', 'brandmembers.slug', 'brandmembers.pro_image', 'brandmembers.brand_details', 'brandmembers.brand_sitelink', 'brandmembers.status', 'brandmembers.admin_status')
                                ->where('products.id','=',$each_content->id)
                                ->first();
                                //echo "<pre>";print_r($brandmember); 
                                //echo $brandmember->slug ; exit;
            $brand_name = ($brandmember->fname)?($brandmember->fname.' '.$brandmember->lname):$brandmember->username;

            $formfactor = DB::table('form_factors')->where('id','=',$each_content->options->form_factor)->first();
            $formfactor_name = $formfactor->name;
            $formfactor_id = $formfactor->id;

            $cart_result[] = array('rowid'=>$each_content->rowid,
                'product_name'=>$each_content->name,
                'product_slug'=>$brandmember->product_slug,
                'product_image'=>$product_res->image1,
                'qty'=>$each_content->qty,
                'price'=>$each_content->price,
                'duration'=>$each_content->options->duration,
                'formfactor_name'=>$formfactor_name,
                'formfactor_id'=>$formfactor_id,
                'brand_name'=>$brand_name,
                'brand_slug'=>$brandmember->slug,
                'subtotal'=>$each_content->subtotal);

        }

        return view('frontend.product.showAllCart',compact('cart_result'),array('title'=>'cart product'));

    }


    public function updateCart()
    {
        $obj = new helpers();
        $rowid = Input::get('rowid');
        $quantity = Input::get('quantity');
        Cart::update($rowid, $quantity); 		// Update cart product from SESSION respect with cart rowid.
        $cartContent = Cart::get($rowid);       // Get All Cart Details By Row ID.
        
        $subtotal = $cartContent->subtotal;     //Sub Total For Updated Row Id.
        
        if($obj->checkMemberLogin())            // If logged in as a member then Update from DB too
        {
            $update_cart = DB::table('carts')
                            ->where('row_id', '=',$rowid)
                            ->where('user_id', '=',Session::get('member_userid'))
                            ->update(['quantity' => $quantity,'sub_total' => $subtotal]);  // Update cart product quatity in DB respect with cart rowid.
        }
		
        echo 1;  // Update cart
    }

    public function deleteCart()
    {
        $obj = new helpers();
        $rowid = Input::get('rowid');
        Cart::remove($rowid);			// Delete cart product from SESSION respect with cart rowid.
		if($obj->checkMemberLogin())   // If logged in as a member then delete from DB too
        {
            DB::table('carts')
                ->where('row_id', '=', $rowid)
                ->where('user_id', '=',Session::get('member_userid'))
                ->delete();   // Delete cart product from DB respect with cart rowid.
        }
        echo 1; // Remove from  cart
    }
              
}