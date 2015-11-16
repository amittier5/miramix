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

class OrderController extends Controller {

    public function __construct() 
    {
        view()->share('member_class','active');
    }

   /**
    * Display a listing of the resource.
    *
    * @return Response
    */
   public function index()
   {
      
	 $limit = 2;
        
        $order_list = Order::with('getOrderMembers','AllOrderItems')->paginate($limit);
	//print_r($order_list);exit;
        $order_list->setPath('orders');
  
        
        return view('admin.order.order_history',compact('order_list'),array('title'=>'MIRAMIX | All Order','module_head'=>'Orders'));

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
	
        	
		
				$user_name = $order->getOrderMembers->fname." ".$order->getOrderMembers->lname;
				$user_email = $order->getOrderMembers->email;
				$subject = 'Order status change of : #'.$order->order_number;
				$cmessage = 'Your order status is changed to '.$order->order_status.'. Please visit your account for details.';
				
				$setting = DB::table('sitesettings')->where('name', 'email')->first();
				$admin_users_email=$setting->value;
				
				
				$sent = Mail::send('admin.order.statusemail', array('name'=>$user_name,'email'=>$user_email,'messages'=>$cmessage), 
				
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
   

}