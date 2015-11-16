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
	
	
        define("AUTHORIZENET_API_LOGIN_ID", "32px8XM76GZg");
        define("AUTHORIZENET_TRANSACTION_KEY", "9PLV89n5LPD9dx55");
        define("AUTHORIZENET_SANDBOX", true);
        
        $getHelper = new helpers();
        view()->share('getHelper',$getHelper);
	    
    }

    public function index(){
    	
    }
   
   

}
