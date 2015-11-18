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
        $product_id = $productdetails->id;

        //echo "<pre/>";print_r($timeduration); exit;
        return view('frontend.product.productdetails',compact('productdetails','productformfactor','timeduration','rating','product_id'),array('title'=>'Product Details'));
        //return redirect('product-details');
    }

   

    public function getIngDtls()
    {
        $ingredient_id = Input::get('ingredient_id');
        $ingredients_details = DB::table('ingredients')->where('id','=',$ingredient_id)->first();
         
        echo $ingredients_details->price_per_gram;
        exit;
    }


    public function getallrate(){
    	$obj = new helpers();

    	$resultsPerPage = 3;

    	$paged = Input::get('page');
    	$product_id = Input::get('product_id');

    	if($paged>0){
    		$page_limit=$resultsPerPage*($paged-1);
    		$next_check_page = $page_limit+3;
    	}
    	else{
    		$page_limit = 0;
    		$next_check_page = 1;
    	}

    	$rating = DB::table('product_rating')
                        ->leftJoin('brandmembers', 'brandmembers.id', '=', 'product_rating.user_id')
                        ->select('product_rating.*','brandmembers.username')
                        ->where('product_rating.status',1)
                        ->where('product_rating.product_id',$product_id)
                        ->skip($page_limit)
                        ->take($resultsPerPage)
                        ->get();

        // For Next load more
 		$rating_count_arr = DB::table('product_rating')
                        ->leftJoin('brandmembers', 'brandmembers.id', '=', 'product_rating.user_id')
                        ->select('product_rating.*','brandmembers.username')
                        ->where('product_rating.status',1)
                        ->where('product_rating.product_id',$product_id)
                        ->skip($next_check_page)
                        ->take($resultsPerPage)
                        ->get();                  
        foreach($rating as $prate){
        ?>
        <div class="rating_block clearfix">
          <h5 class="text-capitalize"><?php echo $prate->rating_title?></h5>
              <div class="total_rev"><p> &ldquo; <?php echo $prate->comment?>  &rdquo;</p>
                <div class="ratn_box">
                  <div id="rate<?php echo $prate->rating_id?>"></div>
                </div>
              </div>
              <div class="bot_rev">
                <p class="author pull-left">Authored by <a href=""><?php echo $prate->username?></a> </p>
                <p class="date pull-left"><?php echo $obj->time_elapsed_string(strtotime($prate->created_on))?></p>
              </div>
         </div>
          <script>
            $(document).ready(function(){
              $('#rate<?php echo $prate->rating_id?>').raty({
              readOnly: true,
              score: <?php echo $prate->rating_value?>,
              starHalf    : '<?php echo url();?>/public/frontend/css/images/star-half.png',
              starOff     : '<?php echo url();?>/public/frontend/css/images/star-off.png',
              starOn      : '<?php echo url();?>/public/frontend/css/images/star-on.png'  , 
              });
            });
          </script>
        <?php
        }
       
         // if(count($rating) == $resultsPerPage){
        	if(count($rating_count_arr)>0){
        ?>

		 	<!-- <button class="loadmore" data-page="<?php echo  $paged+1 ;?>">Load More</button> -->
		 	<a href="javascript:void(0);" class="btn btn-special loadmore" data-page="<?php echo  $paged+1 ;?>">View More Reviews</a>
		 <?php 
		  }else{
		  	echo "<h3>No More Rating</h3>";
		 }


    }

              
}