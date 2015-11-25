<?php namespace App\Http\Controllers\Admin; /* path of this controller*/

use App\Model\Brandmember; /* Model name*/
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
use Mail;

class MemberController extends Controller {

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
        $limit = 50;
		$members = DB::table('brandmembers')->where('role',0)->orderBy('id','DESC')->paginate($limit);
        //echo '<pre>';print_r($members); exit;
	    $members->setPath('member');
        return view('admin.members.index',compact('members'),array('title'=>'Member Management','module_head'=>'Members'));

    }

    public function edit($id)
    {
        $member=Brandmember::find($id);
	$member->password='';
        return view('admin.members.edit',compact('member'),array('title'=>'Edit Member','module_head'=>'Edit Member'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
	$obj = new helpers();
	
       $memberUpdate=Request::all();
       
       if($memberUpdate['password']==''){
	unset($memberUpdate['password']);
       }else{
	$memberUpdate['password']=Hash::make(Request::input('password'));
	
       }
       
       if(isset($_FILES['pro_image']['name']) && $_FILES['pro_image']['name']!="")
			{
				$destinationPath = 'uploads/member/'; // upload path
				$thumb_path = 'uploads/member/thumb/';
				$medium = 'uploads/member/thumb/';
				$extension = Input::file('pro_image')->getClientOriginalExtension(); // getting image extension
				$fileName = rand(111111111,999999999).'.'.$extension; // renameing image
				Input::file('pro_image')->move($destinationPath, $fileName); // uploading file to given path
				
                $obj->createThumbnail($fileName,661,440,$destinationPath,$thumb_path);
                $obj->createThumbnail($fileName,116,116,$destinationPath,$medium);
			}
			else
			{
				$fileName = '';
			}
                        
       
       if($fileName ==''){
	unset($memberUpdate['pro_image']);
       }else{
	$memberUpdate['pro_image']=$fileName;
	
       }
       
       
       $member=Brandmember::find($id);
       $member->update($memberUpdate);

       Session::flash('success', 'Member updated successfully'); 
       return redirect('admin/member');
    }

    public function status($id)
    {
        $brandmember=Brandmember::find($id);
        $brandmember->status = 1;
        $brandmember->update();
        
        Session::flash('success', 'Member status updated successfully'); 
        return redirect('admin/member');
    }

    public function admin_active_status($id)
    {
        $brandmember=Brandmember::find($id);
        $brandmember->admin_status = 1;
        $brandmember->update();
        
        $sitesettings = DB::table('sitesettings')->where("name","email")->first();
        $admin_users_email=$sitesettings->value;
        
        if($brandmember->fname !='')
        $user_name = $brandmember->fname.' '.$brandmember->lname;
        else
        $user_name = $brandmember->username;

        $user_email = $brandmember->email;

        $msg ="Your account has been activated by admin.Please try to log in with your valid credentials.";

        $sent = Mail::send('admin.members.activate_member', array('name'=>$user_name,'email'=>$user_email,'admin_users_email'=>$admin_users_email,'msg'=>$msg), 
        function($message) use ($admin_users_email, $user_email,$user_name,$msg)
        {
            $message->from($admin_users_email);
            $message->to($user_email, $user_name)->subject('Account Activation Mail From Miramix Support');
        });
                        
        if(!$sent)
        {
            Session::flash('error', 'something went wrong!! Mail not sent.'); 
            return redirect('admin/member');
        }
        else
        {
            Session::flash('success', 'Member status updated successfully'); 
            return redirect('admin/member');
        }
    }

    public function admin_inactive_status($id)
    {
        $brandmember=Brandmember::find($id);
        $brandmember->admin_status = 0;
        $brandmember->update();

        $sitesettings = DB::table('sitesettings')->where("name","email")->first();
        $admin_users_email=$sitesettings->value;
        
        if($brandmember->fname !='')
        $user_name = $brandmember->fname.' '.$brandmember->lname;
        else
        $user_name = $brandmember->username;

        $user_email = $brandmember->email;

        $msg = "Your account has been de-activated by admin.Please contact with miramix support.";
        
        $sent = Mail::send('admin.members.activate_member', array('name'=>$user_name,'email'=>$user_email,'admin_users_email'=>$admin_users_email,'msg'=>$msg), 
        function($message) use ($admin_users_email, $user_email,$user_name,$msg)
        {
            $message->from($admin_users_email);
            $message->to($user_email, $user_name)->subject('Account Deactivation Mail From Miramix Support');
        });
                        
        if(!$sent)
        {
            Session::flash('error', 'something went wrong!! Mail not sent.'); 
            return redirect('admin/member');
        }
        else
        {
            Session::flash('success', 'Member status updated successfully'); 
            return redirect('admin/member');
        }
       
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   

}