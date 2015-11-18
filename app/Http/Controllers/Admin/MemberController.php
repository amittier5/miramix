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
        $limit = 5;
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
        //dd($brandmember);exit;
        
        Session::flash('success', 'Member status updated successfully'); 
        return redirect('admin/member');

    }

    public function admin_active_status($id)
    {
        //echo $id;exit;
        
        $brandmember=Brandmember::find($id);
        $brandmember->admin_status = 1;
        $brandmember->update();
        //dd($brandmember);exit;
        
        Session::flash('success', 'Member status updated successfully'); 
        return redirect('admin/member');
    }

    public function admin_inactive_status($id)
    {
        //echo $id;exit;
        
        $brandmember=Brandmember::find($id);
        $brandmember->admin_status = 0;
        $brandmember->update();
        //dd($brandmember);exit;
        
        Session::flash('success', 'Member status updated successfully'); 
        return redirect('admin/member');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   

}