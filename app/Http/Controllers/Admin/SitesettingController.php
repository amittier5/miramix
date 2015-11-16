<?php namespace App\Http\Controllers\Admin; /* path of this controller*/

use App\Model\Sitesetting; /* Model name*/
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

class SitesettingController extends Controller {

   /**
    * Display a listing of the resource.
    *
    * @return Response
    */
   public function __construct() {

      view()->share('sitesetting_class','active');
    }
   public function index()
   {
        $limit = 10;
		$sitesettings = DB::table('sitesettings')->orderBy('name','ASC')->paginate($limit);
        //echo '<pre>';print_r($vitamins); exit;
	    $sitesettings->setPath('sitesetting');
        return view('admin.sitesetting.index',compact('sitesettings'),array('title'=>'Site Setting Management','module_head'=>'Site Setting'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     return view('admin.sitesetting.create',array('title'=>'Site Setting Management','module_head'=>'Add Content'));
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $cms=Request::all();
    //     //echo $title = Request::input('title'); exit;

    //     $title = Request::input('title');
    //     $description=htmlentities(Request::input('description'));
    //     $slug = $title;
    //     $meta_name=Request::input('meta_name');
    //     $meta_description=Request::input('meta_description');
    //     $meta_keyword=Request::input('meta_keyword');
    //     //$description=Request::input('description');
    //     $updated_at=Request::input('updated_at');
    //     $created_at=Request::input('created_at');
        

    //     //print_r($cms); exit;
    //     //Cms::create($cms);
    //     DB::table('cmspages')->insert(
    //         ['title' => $title, 'description' => $description,'slug' => $slug,'meta_name' => $meta_name,'meta_description' => $meta_description,'meta_keyword' => $meta_keyword,'updated_at' => $updated_at,'created_at' => $created_at]
    //     );
    //     Session::flash('success', 'Content added successfully'); 
    //     return redirect('admin/cms');
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //    $cms=Cmspage::find($id);
    //    return view('admin.cms.show',compact('cms'));
    // }

    public function edit($id)
    {
        $sitesettings=Sitesetting::find($id);
        //echo   $sitesettings ; exit;
        return view('admin.sitesetting.edit',compact('sitesettings'),array('title'=>'Edit Site Setting','module_head'=>'Edit Site Setting'));
    }

   
    public function update(Request $request, $id)
    {
        //
           $sitesettingUpdate=Request::all();
           $sitesetting=Sitesetting::find($id);
           //$cmsUpdate['description']=htmlentities($cmsUpdate['description']);
           $sitesetting->update($sitesettingUpdate);
           Session::flash('success', 'Site setting updated successfully'); 
           return redirect('admin/sitesetting');
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
        Sitesetting::find($id)->delete();
        Session::flash('success', 'Site setting deleted successfully'); 
        return redirect('admin/sitesetting');
    }
    
    
}
