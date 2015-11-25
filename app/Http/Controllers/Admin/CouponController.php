<?php namespace App\Http\Controllers\Admin; /* path of this controller*/

use App\Model\Coupon; /* Model name*/
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
use App\Model\Address; 

class CouponController extends BaseController {

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
        $coupons = DB::table('coupons')->orderBy('id','DESC')->paginate($limit);
        //echo '<pre>';print_r($brands); exit;
        $coupons->setPath('coupons');
        return view('admin.coupons.index',compact('coupons'),array('title'=>'Coupon Management','module_head'=>'Coupon'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupons.create',array('title'=>'Coupon Management','module_head'=>'Add Coupon'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $coupons=Request::all();
        coupons::create($coupons);
        Session::flash('success', 'Coupon added successfully'); 
        return redirect('admin/coupons');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $coupons=Coupon::find($id);
       return view('admin.coupons.show',compact('coupons'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand=Coupon::find($id);
        $brand->password='';
         //$brand->slug='';
        $baddress=Address::find($brand->address);
       
       $country = DB::table('countries')->orderBy('name','ASC')->get();
        
        $alldata = array();
        foreach($country as $key=>$value)
        {
            $alldata[$value->country_id] = $value->name;
        }
        
         $states = DB::table('zones')->where('country_id',  $baddress->country_id)->orderBy('name','ASC')->get();
        
        $allstates = array();
        foreach($states as $key=>$value)
        {
            $allstates[$value->zone_id] = $value->name;
        }
        return view('admin.brands.edit',compact('brand','baddress','alldata','allstates'),array('title'=>'Edit Brand','module_head'=>'Edit Brand'));
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
       $brandUpdate=Request::all();
       $brand=Brandmember::find($id);
       
       if($brandUpdate['password']==''){
	unset($brandUpdate['password']);
       }else{
	$brandUpdate['password']=Hash::make(Request::input('password'));
	
       }
     /*  
       if($brandUpdate['slug']==''){
	unset($brandUpdate['slug']);
       }else{
	$brandUpdate['slug']=$obj->edit_slug(Request::input('slug'),'brandmembers','slug',$id);
	
       }*/
       $brandUpdate['slug']=$obj->edit_slug(Request::input('slug'),'brandmembers','slug',$id);
       
       $address['first_name'] = Request::input('first_name');
	$address['last_name']  = Request::input('last_name');
	$address['address']  = Request::input('address1');
	$address['address2']  = Request::input('address2');
	$address['country_id'] = Request::input('country_id');
	$address['zone_id'] =  Request::input('zone_id'); // State id
	$address['city'] =  Request::input('city');
	$address['postcode'] =  Request::input('postcode');
                        
       Address::where('id', '=', Request::input('address'))->update($address);
        unset($brandUpdate['first_name']);
	unset($brandUpdate['last_name']);
        unset($brandUpdate['address1']);
        unset($brandUpdate['address2']);
        unset($brandUpdate['country_id']);
        unset($brandUpdate['zone_id']);
        unset($brandUpdate['city']);
        unset($brandUpdate['postcode']);
       
       if(isset($_FILES['pro_image']['name']) && $_FILES['pro_image']['name']!="")
			{
				$destinationPath = 'uploads/brandmember/'; // upload path
                                $thumb_path = 'uploads/brandmember/thumb/';
                                $medium = 'uploads/brandmember/thumb/';
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
	unset($brandUpdate['pro_image']);
       }else{
	$brandUpdate['pro_image']=$fileName;
	
       }
       
       
       if(isset($_FILES['government_issue']['name']) && $_FILES['government_issue']['name']!="")
			{
				$destinationPath = 'uploads/brand_government_issue_id/'; // upload path
				$extension = Input::file('government_issue')->getClientOriginalExtension(); 
				$government_issue = rand(111111111,999999999).'.'.$extension; 
				Input::file('government_issue')->move($destinationPath, $government_issue); // uploading file to given path
				
			}
			else
			{
				$government_issue = '';
			}
	 if($government_issue ==''){
            unset($brandUpdate['government_issue']);
           }else{
            $brandUpdate['government_issue']=$government_issue;
            
           }		
			
			if(isset($_FILES['business_doc']['name']) && $_FILES['business_doc']['name']!="")
			{
				$destinationPath = 'uploads/brandmember/business_doc/'; // upload path
				$extension = Input::file('business_doc')->getClientOriginalExtension(); 
				$business_doc = rand(111111111,999999999).'.'.$extension; 
				Input::file('business_doc')->move($destinationPath, $business_doc); 
				
			}
			else
			{
				$business_doc = '';
			}
			
           if($business_doc ==''){
            unset($brandUpdate['business_doc']);
           }else{
            $brandUpdate['business_doc']=$business_doc;
            
           }	             
       $brand->update($brandUpdate);
       
       
       
       
        
       Session::flash('success', 'Brand updated successfully'); 
       return redirect('admin/brand');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response	7278876384
     */
    public function destroy($id)
    {
        //
        Brandmember::find($id)->delete();
        return redirect('admin/brand');

        Session::flash('success', 'Brand deleted successfully'); 
        return redirect('admin/brand');
    }
    
    public function status($id)
    {
        $brandmember=Brandmember::find($id);
        $brandmember->status = 1;
        $brandmember->update();

        Session::flash('success', 'Brand status updated successfully'); 
        return redirect('admin/brand');

    }

    public function admin_active_status($id)
    {
        //echo $id;exit;
        
        $brandmember=Brandmember::find($id);
        $brandmember->admin_status = 1;
        $brandmember->update();
        //dd($brandmember);exit;
        
        Session::flash('success', 'Brand status updated successfully'); 
        return redirect('admin/brand');
    }
    public function admin_inactive_status($id)
    {
        $brandmember=Brandmember::find($id);
        $brandmember->admin_status = 0;
        $brandmember->update();
        
        Session::flash('success', 'Brand status updated successfully'); 
        return redirect('admin/brand');
    }
}
