<?php namespace App\Http\Controllers\Admin; /* path of this controller*/

use App\Model\Brandmember; /* Model name*/
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

class BrandController extends Controller {

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
        $brands = DB::table('brandmembers')->where('role',1)->orderBy('id','DESC')->paginate($limit);
        //echo '<pre>';print_r($brands); exit;
        $brands->setPath('brand');
        return view('admin.brands.index',compact('brands'),array('title'=>'Brand Management','module_head'=>'Brands'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vitamins.create',array('title'=>'Vitamin Management','module_head'=>'Add Vitamins'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vitamin=Request::all();
        Vitamin::create($vitamin);
        Session::flash('success', 'Vitamin added successfully'); 
        return redirect('admin/vitamin');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $vitamin=Vitamin::find($id);
       return view('admin.vitamins.show',compact('vitamin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand=Brandmember::find($id);
        return view('admin.brands.edit',compact('brand'),array('title'=>'Edit Brand','module_head'=>'Edit Brand'));
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
       $brandUpdate=Request::all();
       $brand=Brandmember::find($id);
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
