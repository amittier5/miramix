<?php
namespace App\Http\Controllers\Frontend;

use App\Model\Brandmember;  /* Model name*/
use App\Model\Subscription;
use App\Model\Address;      /* Model name*/
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Input;              /* For input */
use Validator;
use Session;
use Imagine\Image\Box;
use Image\Image\ImageInterface;

use DB;
use Hash;
use Mail;
use Authorizenet;
use App\Helper\helpers;
use App\libraries\auth\AuthorizeNetCIM;
use App\libraries\auth\shared\AuthorizeNetTransaction;
use App\libraries\auth\shared\AuthorizeNetLineItem;



class CronController extends BaseController {
    
    public function __construct() 
    {
	   parent::__construct();
	   
	 
    
    }
    
     public function index()
    {
         $all_brand_member = DB::table('brandmembers')->where('role', 1)->where('status', 1)->where('admin_status', 1)->get();
        
         
         foreach($all_brand_member as $brand){
            //echo $brand->fname;
	   
	
            $subscription = DB::table('subscription_history')->where('payment_status', 'pending')->where('member_id', $brand->id)->first();
           if(count($subscription)<=0){
            $end_date=date("Y-m-d",strtotime($brand->created_at .' + 30 days'));
            $setting = DB::table('sitesettings')->where('name', 'brand_fee')->first();
            
            $subdata=array("member_id"=>$brand->id,"start_date"=>$brand->created_at,"end_date"=>$end_date,"subscription_fee"=>$setting->value);
            Subscription::create($subdata);
           }else{
	    
	    $paidsubscription = DB::table('subscription_history')->where('payment_status', 'paid')->where('member_id', $brand->id)->orderBy('end_date','DESC')->first();
	    
	    if(is_object($paidsubscription) && $paidsubscription->end_date<=date("Y-m-d")){
	    
            echo 'subid-'.$paidsubscription->subscription_id.'- paid in prev month <br />';
	    
	    }else{
		
	    $today=Date('Y-m-d');
            $enddate=date("Y-m-d",strtotime($subscription->end_date." + 1 day"));
             if($enddate==$today){
                //charge here
		 if(empty($brand->auth_profile_id))
		continue;
		
		echo "will be charged ".$subscription->subscription_id .'<br />';
		
		// Create Auth & Capture Transaction
		$request = new AuthorizeNetCIM;
		
		$transaction = new AuthorizeNetTransaction;
		$transaction->amount =$subscription->subscription_fee;
		$transaction->customerProfileId = $brand->auth_profile_id;
		$transaction->customerPaymentProfileId = $brand->auth_payment_profile_id;
		$transaction->customerShippingAddressId = $brand->auth_address_id;
	    
		$lineItem              = new AuthorizeNetLineItem;
		$lineItem->itemId      = $subscription->subscription_id;
		$lineItem->name        = $brand->fname;
		$lineItem->description = $brand->fname. " charged for subscription of " .$subscription->start_date;
		$lineItem->quantity    = "1";
		$lineItem->unitPrice   = $subscription->subscription_fee;
		$lineItem->taxable     = "false";
		
		$transaction->lineItems[] = $lineItem;
		
		$response = $request->createCustomerProfileTransaction("AuthCapture", $transaction);
		
		if($response->isOk()){
		    $transactionResponse = $response->getTransactionResponse();
		   
		    $transactionId = $transactionResponse->transaction_id;
    
		$subdata=array("transaction_id"=>$transactionResponse->transaction_id,"payment_status"=>'paid');
		
		$sub = DB::table('subscription_history')
                                    ->where('subscription_id', $subscription->subscription_id)
                                    ->update($subdata);
		}
                
             }
	     
	     
	      
	     
	     
	    }
            
           }
           
         }
         
    }
    
}
?>