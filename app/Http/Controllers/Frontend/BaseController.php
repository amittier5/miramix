<?php namespace App\Http\Controllers\Frontend; /* path of this controller*/

use App\Book;
use App\Model\Mobile;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Input; /* For input */
use Validator;
use Session;
use Illuminate\Pagination\Paginator;
use DB;

use App\Helper\helpers;



class BaseController extends Controller {

	public function __construct() 
    {
    	if( Session::has('member_userid'))
    	{
             // Logged as a member
            $cart_value = DB::table('carts')
			                    ->where('user_id','=',Session::get('member_userid'))
			                    ->sum('quantity');
        }
        else
        {
        	$cart_value ='';
        }

        view()->share('cart_value',$cart_value);
	
	
        //define("AUTHORIZENET_API_LOGIN_ID", "32px8XM76GZg");
        //define("AUTHORIZENET_TRANSACTION_KEY", "9PLV89n5LPD9dx55");
	    define("AUTHORIZENET_API_LOGIN_ID", "6Z7S5dmfD");
        define("AUTHORIZENET_TRANSACTION_KEY", "2uKS73by9W9Rw3mN");
        define("AUTHORIZENET_SANDBOX", false);
        
        $getHelper = new helpers();
        view()->share('getHelper',$getHelper);

        /* All Site Settings List */
        $sitesettings = DB::table('sitesettings')->get();
        $all_sitesetting = array();
        foreach($sitesettings as $each_sitesetting)
        {
            $all_sitesetting[$each_sitesetting->name] = $each_sitesetting->value; 
        }
        
	    view()->share('all_sitesetting',$all_sitesetting);

       
        
    }

    public function index(){
    	
    }
   
   

}
