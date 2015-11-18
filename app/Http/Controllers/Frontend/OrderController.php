<?php namespace App\Http\Controllers\Frontend; /* path of this controller*/

use App\Model\Brandmember;          /* Model name*/
use App\Model\Product;              /* Model name*/
use App\Model\ProductIngredientGroup;    /* Model name*/
use App\Model\ProductIngredient;      /* Model name*/
use App\Model\ProductFormfactor;      /* Model name*/
use App\Model\Ingredient;             /* Model name*/
use App\Model\FormFactor;             /* Model name*/
use App\Model\Order;             /* Model name*/
use App\Model\OrderItem;             /* Model name*/

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

class OrderController extends BaseController {

	var $obj;

    public function __construct() 
    {
    	parent::__construct(); 
    	$this->obj = new helpers();
        view()->share('obj',$this->obj);
    }
   /**
    * Display a listing of the resource.
    *
    * @return Response
    */


    public function index()
    {
        if(!$this->obj->checkMemberLogin())
        {
            return redirect('memberLogin');
        }

        $limit = 10;
        //$order_list = Order::with('AllOrderItems')->paginate($limit);
        $order_list = Order::with('AllOrderItems')->where('user_id','=',Session::get('member_userid'))->orderBy('id', 'desc')->paginate($limit);

        
        $order_list->setPath('order-history');

        
        //echo "<pre>";print_r($order_list);exit;
        return view('frontend.order.member_order_history',compact('order_list'),array('title'=>'MIRAMIX | My Past Order'));
    }

    public function order_detail($id)
  	{
  		if(!$this->obj->checkMemberLogin())
        {
            return redirect('memberLogin');
        }

        $order_list = Order::find($id);
        if($order_list=='')
            return redirect('order-history');
        $order_items_list = $order_list->AllOrderItems;
	
       //echo "<pre>";print_r($order_list);exit;
       return view('frontend.order.member_order_details',compact('order_list','order_items_list'),array('title'=>'MIRAMIX | My Past Order'));

  	}


 public function rateProduct($product_id=''){
	
	if(!$this->obj->checkMemberLogin())
        {
            return redirect('memberLogin');
        }
	
	if($product_id==''){
		Session::flash('error', 'Please select valid product.');
		return redirect('member-dashboard');	
	}
	
	$member2=Session::get('member_userid');
	if(!empty($member2)){
	   $memberdetail =DB::table('brandmembers')->where("id",$member2)->first();
	}
	
	
	$rating_details = DB::table('product_rating')->where('product_id',$product_id)->where("user_id",$memberdetail->id)->first();
         if(count($rating_details)>0){
		Session::flash('error', 'You have already rated for this product.');
		return redirect('order-history');
	 }
	 
	  if(Request::isMethod('post'))
        {
		$ratedata=array(
		"product_id"=>Request::input('product_id'),
		"user_id"=>$member2,
		"rating_value"=>Request::input('rating_val'),
		"rating_title"=>Request::input('review_title'),
		"comment"=>Request::input('message'),
		"created_on"=> date('Y-m-d H:i:s'),
		
		);
		DB::table('product_rating')->insert($ratedata);
		
		
		Session::flash('success', 'You have rated successfully for this product.');
                        
		return redirect('order-history');	
	}
	 
	 
	 
	 
	 
	 
	 
	 
	 $product=DB::table('products')->where('id',$product_id)->first();
	
	return view('frontend.order.member_rating',compact('product','memberdetail'),array('title'=>'MIRAMIX | Rate Product'));
	
 }
 
 public function rateAjax(){
	
	echo "none";
 }



              
}