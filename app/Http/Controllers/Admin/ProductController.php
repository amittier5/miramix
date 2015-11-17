<?php namespace App\Http\Controllers\Admin; /* path of this controller*/

use App\Model\Brandmember;          /* Model name*/
use App\Model\Product;              /* Model name*/
use App\Model\ProductIngredientGroup;    /* Model name*/
use App\Model\ProductIngredient;      /* Model name*/
use App\Model\ProductFormfactor;      /* Model name*/
use App\Model\Ingredient;             /* Model name*/
use App\Model\FormFactor;             /* Model name*/

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

class ProductController extends BaseController {
  var $obj;
    public function __construct() 
    {

      parent::__construct(); 
      view()->share('product_class','active');
      $obj = new helpers();
      $this->obj = $obj;
    }
   /**
    * Display a listing of the resource.
    *
    * @return Response
    */

    public function index($discountinue = false,$param = false)
    {
       
      $limit = 10;
      if($param){

        $condition_arr = array('is_deleted'=>0,'discountinue'=>$discountinue);
        $products = Product::with('GetBrandDetails','AllProductFormfactors')->where($condition_arr)->where('product_name', 'LIKE', '%' . $param . '%')->orderBy('id','DESC')->paginate($limit);

        $products->setPath('product-list');
      }
      else{

          $condition_arr = array('is_deleted'=>0,'discountinue'=>$discountinue);
          $products = Product::with('GetBrandDetails','AllProductFormfactors')->where($condition_arr)->orderBy('id','DESC')->paginate($limit);

          $products->setPath('product-list');
      }


      //Get all formfactor names
      if(!empty($products)){

        foreach ($products as $key => $value) {

          if(!empty($value->AllProductFormfactors)){

            $value->formfactor_name = '';
            $value->formfactor_price = '';
            foreach ($value->AllProductFormfactors as $key1 => $each_formfactor) {

              if($each_formfactor['servings']!=0){

                $frm_fctr = DB::table('form_factors')->where('id',$each_formfactor['formfactor_id'])->first();

                // Assign Form-factor and its prices  
                $value->formfactor_name .= ' '.$frm_fctr->name.' ($'.number_format($each_formfactor->actual_price,2).')<br/>';

              }

            } 
          }
        }

      }

      if($discountinue==0)
        $title = "Continue";
      else
        $title = "Discontinue";
      
     //echo "<pre>";print_r($products);     exit;
      return view('admin.product.index',compact('products','param','discountinue'),array('title'=>$title.' Products','module_head'=>$title.' Products'));
    }

    public function discontinue_product_search($param = false){

      $ingredients = DB::table('products')->where('product_name', 'LIKE', '%' . $_REQUEST['term'] . '%')->where('discountinue',$param)->groupBy('product_name')->orderBy('product_name','ASC')->get();
      $arr = array();

      foreach ($ingredients as $value) {
          
          $arr[] = $value->product_name;
      }
      echo json_encode($arr);
    }

    public function edit($id)
    {
      
      // Get All Ingredient whose status != 2
      $ingredients = DB::table('ingredients')->whereNotIn('status',[2])->get();
      
      // Get All Form factors
      $formfac = FormFactor::all();

      // Get Product details regarding to slug
      $products = DB::table('products')->where('id',$id)->first();

      // Get Ingredient group and their individual ingredients
      $ingredient_group = DB::table('product_ingredient_group')->where('product_id',$products->id)->get();

      $check_arr = $weight_check_arr = $arr = $ing_form_ids = $all_ingredient = $group_ingredient = array(); 
      $total_count = $tot_price = $tot_weight = 0;

     $total_group_count = 0;
      if(!empty($ingredient_group)){
        foreach($ingredient_group as $each_ing_gr){
           $i = 0;
          $total_group_weight = 0;
          $group_ingredient[$i]['group_name'] = $each_ing_gr->group_name;

          $ingredient_lists = DB::table('product_ingredients')->select(DB::raw('product_ingredients.*,ingredients.price_per_gram,ingredients.name'))->Join('ingredients','ingredients.id','=','product_ingredients.ingredient_id')->where('ingredient_group_id',$each_ing_gr->id)->get();
          if(!empty($ingredient_lists)){
            foreach($ingredient_lists as $each_ingredient_list){

              $tot_weight += $each_ingredient_list->weight;
              $total_group_weight += $each_ingredient_list->weight;

              // collect total price
              $tot_price += $each_ingredient_list->ingredient_price;

              // put all ingredient in an array
              $all_ingredient[$total_count]['id'] = $each_ingredient_list->ingredient_id;
              $all_ingredient[$total_count]['name'] = $each_ingredient_list->name;

              $group_ingredient[$i]['all_group_ing'][] = array('ingredient_id'=>$each_ingredient_list->ingredient_id,'weight'=>$each_ingredient_list->weight,'price_per_gram'=>$each_ingredient_list->price_per_gram,'ingredient_price'=>$each_ingredient_list->ingredient_price);
              $total_count++;
            }
            $group_ingredient[$i]['tot_weight'] = $total_group_weight;
          }
          $total_group_count++;
          $i++;
        }
      }
    

      //Get All individual ingredient
      $individual_total_count =0;
      $individual_ingredient_lists = DB::table('product_ingredients')->select(DB::raw('product_ingredients.*,ingredients.price_per_gram,ingredients.name'))->Join('ingredients','ingredients.id','=','product_ingredients.ingredient_id')->where('ingredient_group_id',0)->where('product_id',$products->id)->get();
      if(!empty($individual_ingredient_lists)){
        foreach ($individual_ingredient_lists as $key => $value1) {
            $tot_weight += $value1->weight;
            $tot_price += $value1->ingredient_price;

            // put all ingredient in an array
            $all_ingredient[$total_count]['id'] = $value1->ingredient_id;
            $all_ingredient[$total_count]['name'] = $value1->name;
            $total_count++;
            $individual_total_count++;
        }
      }

      
      // Ingredient and their form factors
      if(!empty($all_ingredient)){

        foreach ($all_ingredient as $key => $value) {
          $arr = array();
          $ing_form_ids = DB::table('ingredients as I')->select(DB::raw('IFF.form_factor_id'))->Join('ingredient_formfactors as IFF','I.id','=','IFF.ingredient_id')->where('I.id',$value['id'])->get();

            if(!empty($ing_form_ids)){
              foreach ($ing_form_ids as $key1 => $value1) {
                $arr[] = $value1->form_factor_id;
              }
            }
          $all_ingredient[$key]['factors'] = $arr;
        }
      }


      //Get All Form factors corresponding to that product
      $pro_form_factor = DB::table('product_formfactors as pff')->select(DB::raw('pff.*,ff.name,ff.price,ff.maximum_weight,ff.minimum_weight'))->Join('form_factors as ff','ff.id','=','pff.formfactor_id')->where('product_id',$products->id)->get();  // Get All formfactor available for this product

      $pro_form_factor_ids = array();
      if(!empty($pro_form_factor)){
        $j=0;
        foreach ($pro_form_factor as $key => $value) {
          $pro_form_factor_ids[$j]['formfactor_id'] = $value->formfactor_id;
          $pro_form_factor_ids[$j]['name'] = $value->name;

          $check_arr[] = $value->formfactor_id;
          $j++;          
        }
      }

      // Get only those form factor which is created for this particular prouct
      $pro_form_factor = DB::table('product_formfactors as pff')->select(DB::raw('pff.*,ff.name,ff.price,ff.maximum_weight,ff.minimum_weight'))->Join('form_factors as ff','ff.id','=','pff.formfactor_id')->where('product_id',$products->id)->where('min_price','!=',0)->get();
      
      $discountinue = $products->discountinue;

    // echo "<pre>";print_r($total_group_count);exit;

      
      return view('admin.product.edit',compact('products','ingredients','all_ingredient','check_arr','tot_weight','tot_price','formfac','pro_form_factor','group_ingredient','individual_ingredient_lists','pro_form_factor_ids','total_count','total_group_count','individual_total_count','discountinue'),array('title'=>'Edit Product'));
      
    }

    public function update(Request $request, $id)
    {
      //echo "<pre>";print_r(Request::all());exit;

      if(Input::hasFile('image1')){
        $destinationPath = 'uploads/product/';   // upload path
        $thumb_path = 'uploads/product/thumb/';
        $medium = 'uploads/product/medium/';
        $extension = Input::file('image1')->getClientOriginalExtension(); // getting image extension
        $fileName1 = rand(111111111,999999999).'.'.$extension; // renameing image
        Input::file('image1')->move($destinationPath, $fileName1); // uploading file to given path

        $this->obj ->createThumbnail($fileName1,771,517,$destinationPath,$thumb_path);
        $this->obj->createThumbnail($fileName1,109,89,$destinationPath,$medium);

      }
      else{
        $fileName1 = Request::input('hidden_image1');
      }

      if(Input::hasFile('image2')){
        $destinationPath = 'uploads/product/';   // upload path
        $thumb_path = 'uploads/product/thumb/';
        $medium = 'uploads/product/medium/';
        $extension = Input::file('image2')->getClientOriginalExtension(); // getting image extension
        $fileName2 = rand(111111111,999999999).'.'.$extension; // renameing image
        Input::file('image2')->move($destinationPath, $fileName2); // uploading file to given path

        $this->obj->createThumbnail($fileName2,771,517,$destinationPath,$thumb_path);
        $this->obj->createThumbnail($fileName2,109,89,$destinationPath,$medium);
        
      }
      else{
        $fileName2 = Request::input('hidden_image2');
      }

      if(Input::hasFile('image3')){
        $destinationPath = 'uploads/product/';   // upload path
        $thumb_path = 'uploads/product/thumb/';
        $medium = 'uploads/product/medium/';
        $extension = Input::file('image3')->getClientOriginalExtension(); // getting image extension
        $fileName3 = rand(111111111,999999999).'.'.$extension; // renameing image
        Input::file('image3')->move($destinationPath, $fileName3); // uploading file to given path

        $this->obj->createThumbnail($fileName3,771,517,$destinationPath,$thumb_path);
        $this->obj->createThumbnail($fileName3,109,89,$destinationPath,$medium);

      }
      else{
        $fileName3 = Request::input('hidden_image3');
      }

      if(Input::hasFile('image4')){
        $destinationPath = 'uploads/product/';   // upload path
        $thumb_path = 'uploads/product/thumb/';
        $medium = 'uploads/product/medium/';
        $extension = Input::file('image4')->getClientOriginalExtension(); // getting image extension
        $fileName4 = rand(111111111,999999999).'.'.$extension; // renameing image
        Input::file('image4')->move($destinationPath, $fileName4); // uploading file to given path

        $this->obj->createThumbnail($fileName4,771,517,$destinationPath,$thumb_path);
        $this->obj->createThumbnail($fileName4,109,89,$destinationPath,$medium);
      
      }
      else{
        $fileName4 = Request::input('hidden_image4');
      }
      if(Input::hasFile('image5')){
        $destinationPath = 'uploads/product/';   // upload path
        $thumb_path = 'uploads/product/thumb/';
        $medium = 'uploads/product/medium/';
        $extension = Input::file('image5')->getClientOriginalExtension(); // getting image extension
        $fileName5 = rand(111111111,999999999).'.'.$extension; // renameing image
        Input::file('image5')->move($destinationPath, $fileName5); // uploading file to given path

        $this->obj->createThumbnail($fileName5,771,517,$destinationPath,$thumb_path);
        $this->obj->createThumbnail($fileName5,109,89,$destinationPath,$medium);

      }
      else{
        $fileName5 = (Request::input('hidden_image5')!='')?Request::input('hidden_image5'):'';
      }
      
      if(Input::hasFile('image6')){
        $destinationPath = 'uploads/product/';   // upload path
        $thumb_path = 'uploads/product/thumb/';
        $medium = 'uploads/product/medium/';
        $extension = Input::file('image6')->getClientOriginalExtension(); // getting image extension
        $fileName6 = rand(111111111,999999999).'.'.$extension; // renameing image
        Input::file('image6')->move($destinationPath, $fileName6); // uploading file to given path

        $this->obj->createThumbnail($fileName6,771,517,$destinationPath,$thumb_path);
        $this->obj->createThumbnail($fileName6,109,89,$destinationPath,$medium);

      }
      else{
        $fileName6 = Request::input('hidden_image6');
      }

      if(Input::hasFile('label')){
        $destinationPath = 'uploads/product/';   // upload path
        $thumb_path = 'uploads/product/thumb/';
        $medium = 'uploads/product/medium/';
        $extension = Input::file('label')->getClientOriginalExtension(); // getting image extension
        $label = rand(111111111,999999999).'.'.$extension; // renameing image
        Input::file('label')->move($destinationPath, $label); // uploading file to given path

        $this->obj->createThumbnail($label,600,650,$destinationPath,$thumb_path);
        $this->obj->createThumbnail($label,109,89,$destinationPath,$medium);
      }
      else{
        $label = Request::input('hidden_label');
      }

      $product = Product::find($id);

      $product['id'] = $id;
      $product['product_name'] = Request::input('product_name');
      $product['product_slug'] = $this->obj->edit_slug($product['product_name'],'products','product_slug',$id);
      $product['image1'] = $fileName1;
      $product['image2'] = $fileName2;
      $product['image3'] = $fileName3;
      $product['image4'] = $fileName4;
      $product['image5'] = $fileName5;
      $product['image6'] = $fileName6;
      $product['label']   = $label;
      $product['description1']      = htmlentities(Request::input('description1'));
      $product['description2']      = htmlentities(Request::input('description2'));
      $product['description3']      = htmlentities(Request::input('description3'));
      
      $product['tags'] = Request::input('tags');   

      $product['script_generated'] = '<a href="'.url().'/product-details/'.$product['product_slug'].'" style="color: #FFF;background: #78d5e5 none repeat scroll 0% 0%;padding: 10px 20px;font-weight: 400;font-size: 12px;line-height: 25px;text-shadow: none;border: 0px none;text-transform: uppercase;font-weight: 200;vertical-align: middle;box-shadow: none;display: block;float: left;" onMouseOver="this.style.backgroundColor=\'#afc149\'" onMouseOut="this.style.backgroundColor=\'#78d5e5\'">Buy Now</a>';
      $product['created_at'] = date("Y-m-d H:i:s");

      $product->save();


      // Delete all ingredient before save new
        ProductIngredientGroup::where('product_id', '=', $id)->delete();   // Delete ingredient group

        ProductIngredient::where('product_id', '=', $id)->delete();     // Delete ingredient individual


       // Create Product Ingredient group 
      if(NULL!=Request::input('ingredient_group')){

        foreach (Request::input('ingredient_group') as $key => $value) {
          
          $arr = array('product_id'=>$id,'group_name'=>$value['group_name']);
          $pro_ing_grp = ProductIngredientGroup::create($arr);
          $group_id = $pro_ing_grp->id;

           if(NULL!=$value['ingredient']){

              foreach ($value['ingredient'] as $key1 => $next_value) {
                $arr_next = array('product_id'=>$id,'ingredient_id'=>$next_value['ingredient_id'],'weight'=>$next_value['weight'],'ingredient_price'=>$next_value['ingredient_price'],'ingredient_group_id'=>$group_id);
                ProductIngredient::create($arr_next);
              }

           }
        }
      }

      // Create Product Ingredient 
      foreach (Request::input('ingredient') as $key2 => $ing_value) {
          $arr_next = array('product_id'=>$id,'ingredient_id'=>$ing_value['id'],'weight'=>$ing_value['weight'],'ingredient_price'=>$ing_value['ingredient_price'],'ingredient_group_id'=>0);
          ProductIngredient::create($arr_next);
      }


      // Delete all Formfactor before save new
      ProductFormfactor::where('product_id', '=', $id)->delete();

      // Add Ingredient form factor
      foreach (Request::input('formfactor') as $key3 => $formfactor_value) {
        
        $arr_pro_fac = array('product_id'=>$id,'formfactor_id'=>$formfactor_value['formfactor_id'],'servings'=>$formfactor_value['servings'],'min_price'=>$formfactor_value['min_price'],'recomended_price'=>$formfactor_value['recomended_price'],'actual_price'=>$formfactor_value['actual_price']);
        ProductFormfactor::create($arr_pro_fac);
      }

      // Add Ingredient form factor for available form factor
      if(Request::input('excluded_val')!=""){
        $all_form_factor_ids = rtrim(Request::input('excluded_val'),",");
        $all_ids = explode(",", $all_form_factor_ids);

        foreach ($all_ids as $key => $value) {
         
          $arr_pro_factor = array('product_id'=>$id,'formfactor_id'=>$value);
          ProductFormfactor::create($arr_pro_factor);

        }
      }

    

      Session::flash('success', 'Product edit successfully'); 
      return redirect('admin/product-list/'.$product['discountinue']);


      //echo "<pre>";print_r(Request::all());exit;
    }

    public function destroy($id)
    {        
        $pro = Product::find($id);
        $pro['is_deleted'] = 1;
        
        $pro->save();

        Session::flash('success', 'Product deleted successfully'); 
        return redirect('admin/product-list/'.$pro['discountinue']);
    }

    

              
}