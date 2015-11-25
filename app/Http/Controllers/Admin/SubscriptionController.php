<?php namespace App\Http\Controllers\Admin; /* path of this controller*/

use App\Model\Brandmember; /* Model name*/
use App\Model\Subscription;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Input; /* For input */
use Validator;
use Session;
use Hash;
use Imagine\Image\Box;
use Image\Image\ImageInterface;
use Illuminate\Pagination\Paginator;
use DB;
use App\Helper\helpers;


class SubscriptionController extends Controller {

    public function __construct() 
    {
        view()->share('brand_class','active');
    }
   /**
    * Display a listing of the resource.
    *
    * @return Response
    */
   public function index()
   {
        $limit = 5;
        //$subscription = DB::table('subscription_history')->orderBy('subscription_id','DESC')->paginate($limit);
        $subscriptions =  Subscription::with('getSubMembers')->orderBy('subscription_id', 'desc')->paginate($limit);
        //echo '<pre>';print_r($subscriptions); exit;
        
        $subscriptions->setPath('subscription');
        return view('admin.subscription.index',compact('subscriptions'),array('title'=>'Subscription Management','module_head'=>'Subscription'));

    }
    
      
    public function show($id)
    {
       $subscription=Subscription::find('subscription_id',$id);
       return view('admin.subscription.show',compact('subscription'));
    }
    
     public function edit($id)
    {
        $subscription=Subscription::with('getSubMembers')->where("subscription_id",$id)->first();
       // print_r($subscription);exit;
               return view('admin.subscription.edit',compact('subscription'),array('title'=>'Edit Subscription','module_head'=>'Edit Subscription'));
    }


    public function update(Request $request, $id)
    {
        $obj = new helpers();
       $subUpdate=Request::all();
      //print_r($subUpdate);exit;
      unset($subUpdate['_method']);
      unset($subUpdate['_token']);
        Subscription::where('subscription_id', '=', $id)->update($subUpdate);
       Session::flash('success', 'Subscription updated successfully'); 
       return redirect('admin/subscription');
    }

    
}