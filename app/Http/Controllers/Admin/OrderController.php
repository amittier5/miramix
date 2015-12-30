<?php namespace App\Http\Controllers\Admin; /* path of this controller*/

use App\Model\Brandmember;          /* Model name*/
use App\Model\Product;              /* Model name*/
use App\Model\ProductIngredientGroup;    /* Model name*/
use App\Model\ProductIngredient;      /* Model name*/
use App\Model\ProductFormfactor;      /* Model name*/
use App\Model\Ingredient;             /* Model name*/
use App\Model\FormFactor;             /* Model name*/
use App\Model\Order;             /* Model name*/
use App\Model\OrderItem;             /* Model name*/
use App\Model\AddProcessOrderLabel;             /* Model name*/

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
use Mail;
use App\Helper\helpers;
use App\libraries\Usps;

class OrderController extends BaseController {

    public function __construct() 
    {
    	parent::__construct();
        view()->share('order_class','active');
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
      
	$limit = 20;
	Session::forget('orderstatus');
	Session::forget('filterdate');
	Session::forget('brandemail');
	$order_list = Order::with('getOrderMembers','AllOrderItems')->orderBy('id','DESC')->paginate($limit);
	//print_r($order_list);exit;
	$order_list->setPath('orders');
	$orderstatus='';
	$filterdate='';
	$brandemail='';

	// Get All selected check Usps mail
	//$all_process_labels = DB::table('add_process_order_labels')->select('order_id', 'label')->get();
	$all_process_labels = AddProcessOrderLabel::all();


	return view('admin.order.order_history',compact('order_list','orderstatus','filterdate','brandemail','all_process_labels'),array('title'=>'MIRAMIX | All Order','module_head'=>'Orders'));

    }

    public function show()
    {
    	// No action needed.
    }
    
public function filters(){
    $limit = 10;

    $orderstatus=Request::input('orderstatus');
	$filterdate=Request::input('filterdate');
	$brandemail=Request::input('brandemail');
	if($orderstatus == '0') // If choose nothing in select box.
	{
		$orderstatus = '';
		if(Request::isMethod('post'))
        {
		Session::forget('orderstatus');
		}
	}
	if($filterdate == '') // If choose nothing in select box.
	{
		$filterdate = '';
		if(Request::isMethod('post'))
		{
		Session::forget('filterdate');
		}
	}
	if($brandemail == '') // If choose nothing in select box.
	{
		$brandemail = '';
		if(Request::isMethod('post'))
		{
		Session::forget('brandemail');
		}
	}
	//echo $filterdate; exit;
	if(Request::isMethod('post'))
        {
			if($orderstatus !='0')
			Session::put('orderstatus',$orderstatus);
			if($filterdate !='')
			Session::put('filterdate',$filterdate);
			if($brandemail !='')
			Session::put('brandemail',$brandemail);
		}

   // $order_list = Order::with('getOrderMembers','AllOrderItems')->orderBy('id','DESC');
	$order_list = DB::table('orders')
	->select(DB::raw('orders.*'))
	
	->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
	->leftJoin('brandmembers', 'order_items.brand_id', '=', 'brandmembers.id')
	->orderBy('id','DESC');
	
	$orderstatus = Session::get('orderstatus');
	$filterdate = Session::get('filterdate');
	$brandemail = Session::get('brandemail');
	
	if(($orderstatus =='' || $orderstatus =='0') && $filterdate =='' && $brandemail=='')
		{
			Session::forget('orderstatus');
			return redirect('/admin/orders');
		}

	if($orderstatus!='0' && $orderstatus!=''){
	   $order_list->whereRaw("orders.order_status='".$orderstatus."'"); 
	}
	if($filterdate!=''){ 
	   $order_list->whereRaw("DATE(orders.created_at)='".$filterdate."'"); 
	}
	if($brandemail!=''){
	   $order_list->whereRaw("(brandmembers.email='".$brandemail."' or brandmembers.business_name like '%".$brandemail."%')"); 
	}
	
	$order_list=$order_list->paginate($limit);
	//print_r($order_list);exit;
    $order_list->setPath('');
  	
  	if($orderstatus == '0') // If choose nothing in select box.
	{
		Session::forget('orderstatus');
		Session::forget('filterdate');
		Session::forget('brandemail');
		return redirect('/admin/orders');
	}
        
    return view('admin.order.order_history',compact('order_list','orderstatus','filterdate','brandemail'),array('title'=>'MIRAMIX | All Order','module_head'=>'Orders'));
}
 public function edit($id)
    {
	
        $orders=Order::find($id);
        return view('admin.order.edit',compact('orders'),array('title'=>'Edit Order','module_head'=>'Edit Order'));
    }
    
public function update(Request $request, $id)
    { 

       $orderUpdate=Request::all();
       
       	$order=Order::with('getOrderMembers','AllOrderItems')->where("id",$id)->first();
		$order->update($orderUpdate);
	

		$shipping_detail = unserialize($order->shiping_address_serialize);
		
		$user_email = $shipping_detail['email'];
		$user_name = $shipping_detail['first_name']." ".$shipping_detail['last_name'];
		
		if($order->user_id!=''){
		$user_email = $order->getOrderMembers->email;
		
		$user_name = !empty($order->getOrderMembers->fname)?$order->getOrderMembers->fname." ".$order->getOrderMembers->lname:$order->getOrderMembers->username;
		}


		
		$subject = 'Order status change of : #'.$order->order_number;
		$cmessage = 'Your order status is changed to '.$order->order_status.'. Please visit your account for details.';
		$tracking = '';
		$shipping = '';

		if($order->order_status=='shipped'){
			$tracking = 'Tracking Number is : '.$order->tracking_number;
			$shipping='Shipping Method is : '.$order->shipping_carrier .'<br />Please visit your account for details';
		}
		
		$setting = DB::table('sitesettings')->where('name', 'email')->first();
		$admin_users_email=$setting->value;
		
		$sent = Mail::send('admin.order.statusemail', array('name'=>$user_name,'email'=>$user_email,'messages'=>$cmessage,'admin_users_email'=>$admin_users_email,'tracking'=>$tracking,'shipping'=>$shipping), 
		
		function($message) use ($admin_users_email, $user_email,$user_name,$subject)
		{
			$message->from($admin_users_email);
			$message->to($user_email, $user_name)->cc($admin_users_email)->subject($subject);
			
		});

		if( ! $sent) 
		{
			Session::flash('error', 'something went wrong!! Mail not sent.'); 
			return redirect('admin/orders');
		}
		else
		{
		    Session::flash('success', 'Message is sent to user and order status is updated successfully.'); 
		    return redirect('admin/orders');
		}

       
    }

    
    public function destroy($id)
    { 
        Order::find($id)->delete();
        return redirect('admin/orders');

        Session::flash('success', 'Order deleted successfully'); 
        return redirect('admin/orders');
    }
   
   	public function orderDetails($id)
    { 
        $order_list = Order::find($id);
        if($order_list=='')
            return redirect('order-history');
        $order_items_list = $order_list->AllOrderItems;
		$order_members=$order_list->getOrderMembers;
        return view('admin.order.order_details',compact('order_list','order_items_list','order_members'),array('title'=>'MIRAMIX | All Order','module_head'=>'Orders'));
        
    }
   public function brand_search(){
	 $brands = DB::table('brandmembers')->whereRaw("role='1'")->whereRaw('(business_name LIKE "%' . $_REQUEST['term'] . '%" OR email LIKE "' . $_REQUEST['term'] . '%")' )->orderBy('id','DESC')->get();
      $arr = array();
	
      foreach ($brands as $value) {
          if(!empty($value->business_name) && $value->role=="1"){
          $arr[] = $value->business_name;
	  }
      }
      echo json_encode($arr);
    }


    public function add_process_queue()
    { 
        $mail_option = Input::get('mail_option');
        $param = Input::get('param');
        $order_id = Input::get('order_id');

        if($param=='add'){

        	$cnt = DB::table('add_process_order_labels')->where('order_id',$order_id)->count();
        	if($cnt==0){
        		$arr = array('order_id'=>$order_id,'label'=>$mail_option);
				AddProcessOrderLabel::create($arr);
        	}
        	else{
        		AddProcessOrderLabel::where('order_id',$order_id)->update(['label'=>$mail_option]);
        	}			
        }
        else{

        	AddProcessOrderLabel::where('order_id', '=',$order_id)->delete();
        }

        
        exit;
        
    }

    public function push_order_process($param = false)
    { 
    	//echo $param;exit;
    	$usps_obj = new Usps();
    	$obj = new helpers();
        $all_process_orders = DB::table('add_process_order_labels')->get();
       
        $all_filename = array();
        $flag = 0;
        if(!empty($all_process_orders)){
        	foreach ($all_process_orders as $key => $value) {

        		// Get details for each order
        		$ord_dtls = Order::find($value->order_id);
        		$serialize_add = unserialize($ord_dtls['shiping_address_serialize']);
        		
        		$user_email = $serialize_add['email'];
				$user_name = $serialize_add['first_name']." ".$serialize_add['last_name'];
        		$phone = $serialize_add['phone'];
        		$address = $serialize_add['address'];
        		$address2 = $serialize_add['address2'];
        		$city = $serialize_add['city'];
        		$zone_id = $serialize_add['zone_id'];
        		$country_id = $serialize_add['country_id'];
        		$postcode = $serialize_add['postcode']; 


				$ToState = '';
				if(is_numeric($zone_id))
				{
					$ToState = $obj->get_statecode($zone_id);
				}
				else
				{
					$ToState = $obj->get_statecode_by_name($zone_id);
				}


        		// Call USPS API
        		$parameters_array = array('ToName'=>$user_name,'ToFirm'=>'','ToAddress1'=>$address2,'ToAddress2'=>$address,'ToCity'=>$city,'ToState'=>$ToState,'ToZip5'=>$postcode,'order_id'=>$value->order_id);
				$ret_array = $usps_obj->USPSLabel($parameters_array);
				//echo "<pre>";print_r($ret_array);exit;

				if($ret_array['filename']!=""){
					$flag = 1;
				}

        		$all_filename[] = $filename = $ret_array['filename'];
        		$tracking_number = $ret_array['tracking_no'];

        		// Update label name in DB
        		Order::where('id', $value->order_id)->update(['tracking_number' => $tracking_number,'shipping_carrier'=>'USPS','usps_label'=>$filename,'order_status'=>'shipped']);


        		// change order status and send mail
        		$order = Order::find($value->order_id);        		
				
				$subject = 'Order status change of : #'.$order->order_number;
				$cmessage = 'Your order status is changed to '.$order->order_status.'. Please visit your account for details.';
				$tracking = '';
				$shipping = '';

				if($order->order_status=='shipped'){
					$tracking = 'Tracking Number is : '.$tracking_number;
					$shipping='Shipping Method is : USPS<br />Please visit your account for details';
				}
				
				$setting = DB::table('sitesettings')->where('name', 'email')->first();
				$admin_users_email=$setting->value;
				
				/*$sent = Mail::send('admin.order.statusemail', array('name'=>$user_name,'email'=>$user_email,'messages'=>$cmessage,'admin_users_email'=>$admin_users_email,'tracking'=>$tracking,'shipping'=>$shipping), 
				
				function($message) use ($admin_users_email, $user_email,$user_name,$subject)
				{
					$message->from($admin_users_email);
					$message->to($user_email, $user_name)->cc($admin_users_email)->subject($subject);
					//$message->to('amit.unified@gmail.com', $user_name)->cc($admin_users_email)->subject($subject);
					
				});*/

        	}
        }
        // Delete from add_process_order_labels
		DB::table('add_process_order_labels')->delete();

		if($param==1){

		    $full_path = array();
			if(!empty($all_filename)){
				foreach ($all_filename as $file) {
					
					if($file!=""){
						$full_path[]= './uploads/pdf/'.$file;
					}

				}
			}
			if(!empty($full_path))
			$usps_obj->new_printPdf($full_path);

		}
		//echo $flag;print_r($all_filename);exit;

		if($flag==1)
	    	Session::flash('success', 'Message is sent to user and order status is updated successfully.'); 
		else
	    	Session::flash('error', 'No label is created.'); 

	    return redirect('admin/orders');
        
    }

}