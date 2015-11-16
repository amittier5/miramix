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
use App\Helper\helpers;
use DB;
use Hash;
use Mail;


class CmsController extends BaseController {
    
    public function __construct() 
    {
	   parent::__construct();
	   $obj = new helpers();
        
        view()->share('obj',$obj);
    }

    public function showContent($param)
    {
        $cms = DB::table('cmspages')
                    ->where('slug',$param)
                    ->first();
        //print_r($cms);  exit;          
        //echo $param;
	//exit;
        return view('frontend.cms.cms',compact('cms'),array('title'=>'Miramix '.$cms->title,'meta_name'=>$cms->meta_name,'meta_description'=>$cms->meta_description,'meta_keyword'=>$cms->meta_keyword));
    }
    
    
    public function contactUs(){
	$member1=Session::get('brand_userid');
	$member2=Session::get('member_userid');
	if(!empty($member1)){
	$memberdetail = Brandmember::find($member1);
	}elseif(!empty($member2)){
	   $memberdetail = Brandmember::find($member2); 
	}else{
	   $memberdetail=(object)array("email"=>"","fname"=>"","lname"=>""); 
	}
	
	 if(Request::isMethod('post'))
        {
				$user_name = Request::input('contact_name');
				$user_email = Request::input('contact_email');
				$subject = Request::input('contact_subject');
				$cmessage = Request::input('message');
				
				$setting = DB::table('sitesettings')->where('name', 'email')->first();
				$admin_users_email=$setting->value;
				
				
				$sent = Mail::send('frontend.cms.contactemail', array('name'=>$user_name,'email'=>$user_email,'messages'=>$cmessage), 
				
				function($message) use ($admin_users_email, $user_email,$user_name)
				{
					$message->from($admin_users_email);
					$message->to($user_email, $user_name)->cc($admin_users_email)->subject(Request::input('contact_subject'));
					
				});
	
				if( ! $sent) 
				{
					Session::flash('error', 'something went wrong!! Mail not sent.'); 
					return redirect('contact-us');
				}
				else
				{
				    Session::flash('success', 'Message is sent to admin successfully. We will getback to you shortly'); 
				    return redirect('contact-us');
				}
	    
	}
	
	return view('frontend.cms.contactus',compact('memberdetail'),array('title'=>'Miramix - Contact Us'));	
    }
}
?>