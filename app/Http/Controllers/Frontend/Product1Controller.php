<?php namespace App\Http\Controllers\Frontend; /* path of this controller*/

use App\Model\Brandmember; /* Model name*/
use App\Model\Ingredient; /* Model name*/
use Illuminate\Support\Collection;
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
use App\Helper\helpers;
//use Anam\Phpcart\Cart;
use Cart;

class Product1Controller extends BaseController {

    public function __construct() 
    {
        parent::__construct();
        $obj = new helpers();
        if(!$obj->checkBrandLogin())
        {
            $brandlogin = 0; // Logged as a member
        }
        else
        {
            $brandlogin = 1; // Logged as a brand
        }
        view()->share('brandlogin',$brandlogin);
        
        view()->share('obj',$obj);
    }
   /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        //return view('frontend.product.index',compact('body_class'),array('title'=>'MIRAMIX | Home'));
       //return Redirect::to('brandregister')->with('reg_brand_id', 1);
        //return redirect('product-details');
    }


    public function productDetails($slug)
    {

        //$content = Cart::content();echo "<pre>";print_r($content);exit;

        $productdetails = DB::table('products')
                                ->leftJoin('brandmembers', 'brandmembers.id', '=', 'products.brandmember_id')
                                ->select('products.*', 'brandmembers.fname', 'brandmembers.lname', 'brandmembers.pro_image', 'brandmembers.brand_details', 'brandmembers.brand_sitelink', 'brandmembers.status', 'brandmembers.admin_status')
                                ->where('products.product_slug','=',$slug)
                                ->where('products.active',1)
                                ->where('products.is_deleted',0)
                                ->where('brandmembers.status',1)
                                ->where('brandmembers.admin_status',1)
                                ->first();
        //echo "<pre/>";print_r($productdetails); exit;

        // Return to home page if the product is not active or deleted
        if(empty($productdetails))
            return redirect('home');

        $productformfactor = DB::table('product_formfactors')
                                ->join('form_factors', 'form_factors.id', '=', 'product_formfactors.formfactor_id')
                                ->join('products', 'products.id', '=', 'product_formfactors.product_id')
                                ->select('product_formfactors.*', 'form_factors.name', 'form_factors.image', 'form_factors.price', 'form_factors.maximum_weight', 'form_factors.minimum_weight', 'products.product_name')
                                ->where('product_formfactors.product_id','=',$productdetails->id)
                                ->where('products.active',1)
                                ->get();
        // echo print_r(DB::enableQueryLog()); exit;
        //echo "<pre/>";print_r($productformfactor);exit;                                            
        $timeduration = DB::table('time_durations')
                            ->where('status',1)
                            ->get();
        $rating = DB::table('product_rating')
                        ->leftJoin('brandmembers', 'brandmembers.id', '=', 'product_rating.user_id')
                        ->select('product_rating.*','brandmembers.username')
                            ->where('product_rating.status',1)
                            ->where('product_rating.product_id',$productdetails->id)
                            ->get();
        //echo "<pre/>";print_r($timeduration); exit;
        return view('frontend.product.productdetails',compact('productdetails','productformfactor','timeduration','rating'),array('title'=>'Product Details'));
        //return redirect('product-details');
    }

    public function create()
    {

        if(!Session::has('brand_userid')){
            //return redirect('brandLogin');
        }

        //$ingredients = DB::table('ingredients')->orderBy('id','DESC')->limit(2)->offset(0);

         $ingredients = DB::table('ingredients')->get();

        //echo "<pre>";print_r($ingredients);exit;



        return view('frontend.product.create',compact('ingredients'),array('title'=>'Add product'));
    }

    public function getIngDtls()
    {
        $ingredient_id = Input::get('ingredient_id');
        $ingredients_details = DB::table('ingredients')->where('id','=',$ingredient_id)->first();
         
        echo $ingredients_details->price_per_gram;
        exit;
    }

              
}