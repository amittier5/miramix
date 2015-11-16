<?php namespace App\Http\Controllers\Frontend; /* path of this controller*/

use App\Model\Brandmember;  /* Model name*/
use App\Model\ProductIngredient;
use App\Model\ProductFormfactor;
use App\Model\Address;      /* Model name*/
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Input;              /* For input */
use Validator;
use Session;
use Imagine\Image\Box;
use Image\Image\ImageInterface;
use Illuminate\Pagination\Paginator;
use DB;
use Hash;
use Mail;
use Authorizenet;
use App\Helper\helpers;



class InventoryController extends BaseController {

    public function __construct() 
    {
        parent::__construct();
        $obj = new helpers();
        
        view()->share('obj',$obj);
    }
   /**
    * Display a listing of the resource.
    *
    * @return Response
    */
   
    public function inventory(){
      $start='a';
      $end='z'; 
      $pageindex=array();
      for($i=$start;$i<$end;$i++){
         
         $inv=DB::table('ingredients')->whereRaw(" name like '".$i."%'")
                     ->orderBy('name', 'ASC')->get();
             $pageindex[$i]=$inv;
      }
      $inv=DB::table('ingredients')->whereRaw(" name like 'z%'")
                     ->orderBy('name', 'ASC')->get();
             $pageindex['z']=$inv;
      
      return view('frontend.inventory.inventory',compact('pageindex'),array('title'=>'Miramix Inventory')); 
    }

    public function inventory_details($inventory_id=false){

      if($inventory_id==''){
		Session::flash('error', 'Please select valid ingrediant.');
		return redirect('inventory');	
	}
        $ingrproducts=ProductIngredient::with('ingredientProducts')->where("ingredient_id",$inventory_id)->get();
       
        //$ingrproducts->setpath("inventory-products/".$inventory_id);
        return view('frontend.inventory.products',compact('ingrproducts'),array('title'=>'Miramix Inventory Products'));
    }


    
}