<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route:: get('/','Frontend\HomeController@index');
Route:: post('/','Frontend\HomeController@index');
Route::resource('home','Frontend\HomeController');

Route::resource('basecon','Frontend\BaseController');
Route::resource('image','MyController');


// ======================= BRAND CONTROLLER FUNCTIONALITY START  ============================

Route:: get('/brand','Frontend\BrandController@index');   
Route:: get('/brand-details/{id}','Frontend\BrandController@brandDetails');
Route:: get('/brand-dashboard','Frontend\BrandController@brandDashboard');  /* To Show the brand dashboard */ 
Route:: get('/brand-account','Frontend\BrandController@brandAccount');      /* To Show the brand account  */ 
Route:: post('/brand-account','Frontend\BrandController@brandAccount');      /* To post data the brand account  */ 
Route:: get('/validatecalltime','Frontend\BrandController@validateCalltime');  /* To validate Call Date Time Ajax */
Route:: post('/validatecalltime','Frontend\BrandController@validateCalltime');  
Route:: get('/change-password','Frontend\BrandController@brand_change_pass');    /* Change password for Brand */
Route:: post('/change-password','Frontend\BrandController@brand_change_pass');   /* Change password for Brand */

Route:: get('/brand-creditcards','Frontend\BrandController@brand_creditcard_details');    /* Change password for Brand */
Route:: post('/brand-creditcards','Frontend\BrandController@brand_creditcard_details');   /* Change password for Brand */
Route:: get('/brand-paydetails','Frontend\BrandController@brand_paydetails');    /* Change password for Brand */
Route:: post('/brand-paydetails','Frontend\BrandController@brand_paydetails');   /* Change password for Brand */

Route:: get('/brand-shipping-address','Frontend\BrandController@brandShippingAddress'); 		/* edit brand shipping address */
Route:: post('/brand-shipping-address','Frontend\BrandController@brandShippingAddress');		/* edit brand shipping address */

Route:: get('/create-brand-shipping-address','Frontend\BrandController@createBrandShippingAddress');   /* create brand shipping address */
Route:: post('/create-brand-shipping-address','Frontend\BrandController@createBrandShippingAddress');	/* create brand shipping address */
Route:: get('/edit-brand-shipping-address','Frontend\BrandController@editBrandShippingAddress'); 		/* edit brand shipping address */
Route:: post('/edit-brand-shipping-address','Frontend\BrandController@editBrandShippingAddress');		/* edit brand shipping address */
Route:: get('/delete-brand-shipping-address','Frontend\BrandController@delAddress');                    /* delete brand shiping address */
Route:: get('/sold-products','Frontend\BrandController@soldProducts');                    /* delete brand shiping address */

//============================== BRAND CONTROLLER FUNCTIONALITY END ========================


// ============================== For Payment Methods START=========================== 

// ============================== For Payment Methods End ============================= 


// ======================= Add To Cart Fuctionality Start  =======================

Route:: get('/allmycard','Frontend\CartController@cart');           // runnng...
Route:: post('/allmycard','Frontend\CartController@cart');          // runnng...
Route:: get('/updateCart','Frontend\CartController@updateCart');    // runnng...
Route:: post('/updateCart','Frontend\CartController@updateCart');   // runnng...
Route:: get('/deleteCart','Frontend\CartController@deleteCart');    // runnng...
Route:: post('/deleteCart','Frontend\CartController@deleteCart');   // runnng...
Route:: get('/show-cart','Frontend\CartController@showAllCart');
Route:: get('/reorder','Frontend\CartController@reorder');           // runnng...
Route:: post('/reorder','Frontend\CartController@reorder');          // runnng...


Route:: get('/allmycard1','Frontend\Product1Controller@cart1');  
Route:: post('/allmycard1','Frontend\Product1Controller@cart1');  
Route:: post('/mycarttest','Frontend\Product1Controller@mycarttest');
Route:: get('/mycarttest','Frontend\Product1Controller@mycarttest');
Route:: get('/carttest','Frontend\HomeController@cart');
Route:: get('/mycart','MyController@cart');  
Route:: get('/allCart','Frontend\CartController@cart2');  // runnng...

Route:: get('/getallrate','Frontend\Product1Controller@getallrate');  
Route:: post('/getallrate','Frontend\Product1Controller@getallrate');  



// ======================= Product Route +========================
Route:: resource('product','Frontend\ProductController');   
Route:: post('/getIngDtls','Frontend\ProductController@getIngDtls');  
Route:: get('/getFormFactor','Frontend\ProductController@getFormFactor');  
Route:: post('/getFormFactor','Frontend\ProductController@getFormFactor');  
Route:: get('/product-details/{param}','Frontend\Product1Controller@productDetails'); 
Route:: get('/my-products','Frontend\ProductController@allProductByBrand'); 

Route:: get('/getFormFactorPrice','Frontend\ProductController@getFormFactorPrice'); 
Route:: post('/getFormFactorPrice','Frontend\ProductController@getFormFactorPrice'); 
Route:: get('/edit-product/{id}','Frontend\ProductController@edit_product'); 
Route:: get('/delete-product/{id}','Frontend\ProductController@delete_product'); 

Route:: post('/productPost','Frontend\ProductController@productPost');


// ======================= Product Route +========================


// ======================= CheckOut Start ========================
Route:: get('checkout-step1','Frontend\CheckoutController@checkoutStep1');   
Route:: get('/checkout-step2','Frontend\CheckoutController@checkoutStep2'); 
Route:: post('/checkout-step2','Frontend\CheckoutController@checkoutStep2');
Route:: get('/checkout-step3','Frontend\CheckoutController@checkoutStep3'); 
Route:: post('/checkout-step3','Frontend\CheckoutController@checkoutStep3'); 
Route:: get('/checkout-step4','Frontend\CheckoutController@checkoutStep4'); 
Route:: post('/checkout-step4','Frontend\CheckoutController@checkoutStep4'); 

Route:: get('/checkout-paypal/{id}','Frontend\CheckoutController@checkoutPaypal');
Route:: post('/checkout-paypal/{id}','Frontend\CheckoutController@checkoutPaypal');

Route:: get('/paypal-notify','Frontend\CheckoutController@paypalNotify');
Route:: post('/paypal-notify','Frontend\CheckoutController@paypalNotify');
Route:: get('/checkout-success','Frontend\CheckoutController@success');
Route:: post('/checkout-success','Frontend\CheckoutController@success');
Route:: get('/checkout-cancel','Frontend\CheckoutController@cancel');
Route:: post('/checkout-cancel','Frontend\CheckoutController@cancel');

Route:: get('/checkout-authorize/{id}','Frontend\CheckoutController@checkoutAuthorize');
Route:: post('/checkout-authorize/{id}','Frontend\CheckoutController@checkoutAuthorize');

Route:: get('/checkout-member-login','Frontend\CheckoutController@checkoutMemberLogin'); 
Route:: post('/checkout-member-login','Frontend\CheckoutController@checkoutMemberLogin');


// ======================= CheckOut End ========================

// =======================REGISTER CONTROLLER START ===============================

Route:: resource('register','Frontend\RegisterController');              
Route:: get('/register','Frontend\RegisterController@index');            /* For Show signup page - registration */
Route:: post('/getState','Frontend\RegisterController@getState');         /* For Save signup page - registration [call store function on controller]*/
Route:: get('/activateLink/{id}/{parameter}','Frontend\RegisterController@activateLink'); /* For Register user activation */
Route:: post('/emailChecking','Frontend\RegisterController@emailChecking');  /* For duplicate email checking - registration [call store function on controller]*/
Route:: post('/emailChecking2','Frontend\RegisterController@emailChecking2');  /* For duplicate email checking - registration [call store function on controller]*/

Route:: post('/usernameChecking','Frontend\RegisterController@usernameChecking'); /* For duplicate email checking - registration [call store function on controller] */

Route:: get('/brandregister','Frontend\RegisterController@brandRegister');            /* For Show signup page - registration */
Route:: post('/brandregister','Frontend\RegisterController@brandRegister');            /* For Show signup page - registration */
Route:: post('/updateDate','Frontend\RegisterController@updateDate');           /* For ajax sign up page calender date update */

// =======================REGISTER CONTROLLER END ===============================

// ======================= HOME CONTROLLER START ===============================

Route:: get('/brandLogin','Frontend\HomeController@brand_login');       /* For showing Brand login page*/
Route:: post('/brandLogin','Frontend\HomeController@brand_login');    /* For Member login page, use for login */

Route:: get('/member-dashboard','Frontend\MemberController@index');     /* To Show the memeber dashboard */ 
Route:: get('/member-account','Frontend\MemberController@memberAccount');         /* To Show the memeber account */ 
Route:: post('/member-account','Frontend\MemberController@memberAccount');         /* To Show the memeber account */ 

Route:: get('/member-shipping-address','Frontend\MemberController@memberShippingAddress');         /* To Show the memeber account */ 
Route:: post('/member-shipping-address','Frontend\MemberController@memberShippingAddress');         /* To Show the memeber account */ 

Route:: get('/create-member-shipping-address','Frontend\MemberController@createMemberShippingAddress');   /* create brand shipping address */
Route:: post('/create-member-shipping-address','Frontend\MemberController@createMemberShippingAddress');	/* create brand shipping address */
Route:: get('/edit-member-shipping-address','Frontend\MemberController@editMemberShippingAddress'); 		/* edit brand shipping address */
Route:: post('/edit-member-shipping-address','Frontend\MemberController@editMemberShippingAddress');		/* edit brand shipping address */
Route:: get('/delete-member-shipping-address','Frontend\MemberController@delAddress');    

Route:: get('/brand-forgot-password','Frontend\HomeController@brand_forgotPassword');    /* For brand forgot passsword */
Route:: post('/brand-forgot-password','Frontend\HomeController@brand_forgotPassword');   /* For brand forgot passsword */
Route:: get('/brand-reset-password/{id}','Frontend\HomeController@brand_resetpassword');     /* For brand Reset passsword */
Route:: post('/brand-reset-password/{id}','Frontend\HomeController@brand_resetpassword');    /* For brand Reset passsword */

Route:: get('/memberLogin','Frontend\HomeController@member_login');                         /* For showing Member login page*/
Route:: post('/memberLogin','Frontend\HomeController@member_login');                        /* For Member login page, use for login */
Route:: get('/member-changepass','Frontend\MemberController@member_change_pass');    
Route:: post('/member-changepass','Frontend\MemberController@member_change_pass');    

Route:: get('/member-forgot-password','Frontend\HomeController@member_forgotPassword');    /* For member forgot passsword */
Route:: post('/member-forgot-password','Frontend\HomeController@member_forgotPassword');   /* For member forgot passsword */
Route:: get('/member-reset-password/{id}','Frontend\HomeController@member_resetpassword');    /* For member Reset passsword */
Route:: post('/member-reset-password/{id}','Frontend\HomeController@member_resetpassword');   /* For member Reset passsword */

Route:: get('/userLogout','Frontend\HomeController@userLogout');    /* For member logout */
//Route:: get('/brandLogout','Frontend\HomeController@brandLogout');      /* For brand logout */

Route:: get('/search-tags','Frontend\HomeController@searchtags');    /* For Search Tags */
Route:: post('/search-tags','Frontend\HomeController@searchtags');   /* For Search Tags */

Route:: get('/home-next','Frontend\HomeController@homenext');    /* For Search Tags */
Route:: post('/home-next','Frontend\HomeController@homenext');   /* For Search Tags */

//============================ HOME CONTROLLER END ================================

//============================ FAO CONTROLLER START ===============================
Route:: get('/faq-list', 'Frontend\FaqController@faqList');
//============================ FAO CONTROLLER START ===============================

//============================ Corn Controller Start ==============================
Route:: get('/cron','Frontend\CronController@index'); 

//============================ Corn Controller End ================================

//============================ ORDER CONTROLLER START ==============================
Route:: get('/order-history','Frontend\OrderController@index');  
Route:: get('/order-detail/{id}','Frontend\OrderController@order_detail');
Route:: get('/rate-product/{id}','Frontend\OrderController@rateProduct');  
Route:: post('/rate-product/{id}','Frontend\OrderController@rateProduct');
Route:: get('/rate-ajax','Frontend\OrderController@rateAjax');
Route:: post('/rate-ajax','Frontend\OrderController@rateAjax');
//============================ ORDER CONTROLLER END ================================

//============== STATIC FRONT PAGE URL START [** Write this Static section bellow all route **] ====================
Route:: get('/contact-us','Frontend\CmsController@contactUs');   /* For Show content */
Route:: post('/contact-us','Frontend\CmsController@contactUs');   /* For Show content */
//============== STATIC FRONT PAGE URL START [** Write this Static section bellow all route **] ====================



//============================= STATIC FRONT PAGE URL END ===========================================================

Route::resource('book','BookController');
Route:: get('/inventory','Frontend\InventoryController@inventory');   
Route:: get('/inventory-products/{id}','Frontend\InventoryController@inventory_details');   /* For Show content */
//Route:: get('/inventory-products/{id}/{page}','Frontend\InventoryController@inventory_details');   /* For Show content */

// ===================================== Admin area ================================
get('admin', function () {
  return redirect('/admin/home');
});



$router->group([
  'namespace' => 'Admin',
  'middleware' => 'auth',
], function () {
	
    resource('admin/post', 'PostController');

    resource('admin/home', 'HomeController');
    resource('admin/admin-profile', 'HomeController@getProfile');
    resource('admin/change-password', 'HomeController@changePass');

    resource('admin/ingredient', 'IngredientController');
    resource('admin/ingredient-list', 'IngredientController@index');
    resource('admin/ingredient-search', 'IngredientController@ingredient_search');    
    resource('admin/vitamin-search', 'IngredientController@viatmin_auto_search');
    resource('admin/component-search', 'IngredientController@component_auto_search');


// ++++++++++++++++++++++++++++===++++++++++++++ Product ++++++++++++++++++++++++++++===++++++++++++++ 
    resource('admin/product', 'ProductController');
    //resource('admin/product-list', 'ProductController');
    get('admin/product-list/{id}', 'ProductController@index');
    get('admin/product-list/{id}/{param}', 'ProductController@index');
    resource('admin/discontinue-product-search', 'ProductController@discontinue_product_search');  

// ++++++++++++++++++++++++++++===++++++++++++++ Product ++++++++++++++++++++++++++++===++++++++++++++ 

    resource('admin/book', 'BookController');

    resource('admin/member/status', 'MemberController@status');
    resource('admin/member/admin_active_status', 'MemberController@admin_active_status');
    resource('admin/member/admin_inactive_status', 'MemberController@admin_inactive_status');
    resource('admin/member', 'MemberController');

    resource('admin/brand/status', 'BrandController@status');
    resource('admin/brand/admin_active_status', 'BrandController@admin_active_status');
    resource('admin/brand/admin_inactive_status', 'BrandController@admin_inactive_status');
    resource('admin/brand', 'BrandController');
    
    resource('admin/vitamin', 'VitaminController');
	get('admin/upload', 'UploadController@index');
    resource('admin/cms', 'CmspageController');
    resource('admin/faq', 'FaqController');

    resource('admin/sitesetting', 'SitesettingController');
    
    resource('admin/formfactor', 'FormfactorController');
    resource('admin/form-factor', 'FormfactorController@index');
    resource('admin/form-factor-name', 'FormfactorController@form_factor_name');
    resource('admin/orders', 'OrderController');
   
  
});

// Logging in and out
get('/auth/login', 'Auth\AuthController@getLogin');
post('/auth/login', 'Auth\AuthController@postLogin');
get('/auth/logout', 'Auth\AuthController@getLogout');



// admin/test
Route::group(
    array('prefix' => 'admin'), 
    function() {
        Route::get('forgotpassword', 'Admin\HomeController@forgotPassword');
        Route::post('forgotpasswordcheck', 'Admin\HomeController@forgotpasswordcheck');
        Route::get('resetpassword/{id}', 'Admin\HomeController@resetpassword');
        Route::post('updatepassword/{id}', 'Admin\HomeController@updatePassword');

    }
);



Route:: get('/{param}','Frontend\CmsController@showContent');   /* For Show content */
