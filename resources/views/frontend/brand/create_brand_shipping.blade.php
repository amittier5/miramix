 @extends('frontend/layout/frontend_template')
@section('content')
<div class="inner_page_container nomar_bottom">
<div id="nav-icon2">
  <span></span>
  <span></span>
  <span></span>
  <span></span>
  <span></span>
  <span></span>
</div>
<div class="mob_topmenu_back"></div>

<div class="top_menu_port">
    	<div class="acct_box yellow_act">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <img src="<?php echo url();?>/public/frontend/images/account/sold_products.png" alt="">
                        <a href="<?php echo url();?>/sold-products" class="link_wholediv">Sold Products History</a>
                        </div>                    	
                    </div>
                </div>
                
                <div class="acct_box red_acct">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="<?php echo url();?>/product/create"><img src="<?php echo url();?>/public/frontend/images/account/add_products.png" alt=""></a>
                        <a href="<?php echo url();?>/product/create" class="link_wholediv">Add Products</a>
                        </div>                    	
                    </div>
                </div>
                
                <div class="acct_box org_org_acct no_marg">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="<?php echo url();?>/my-products"><img src="<?php echo url();?>/public/frontend/images/account/productlist.png" alt=""></a>
                        <a href="<?php echo url();?>/my-products" class="link_wholediv">Product List</a>
                        </div>                    	
                    </div>
                </div>
                
                <div class="acct_box new_green_acct no_marg">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                         <a href=""><img src="<?php echo url();?>/public/frontend/images/account/order_hist.png" alt=""></a>
                         <a href="javascript:void(0);" class="link_wholediv">Order History<span>Coming Soon</span></a>
                        </div>                    	
                    </div>
                </div>
                
                <div class="acct_box blue_acct front">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="<?php echo url();?>/brand-account"><img src="<?php echo url();?>/public/frontend/images/account/pers_info.png" alt=""></a>
                        <a href="<?php echo url();?>/brand-account" class="link_wholediv">Brand Information</a>
                        </div>                    	
                    </div>
                </div>
                
                <!--<div class="acct_box green_acct">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="<?php echo url();?>/change-password"><img src="<?php echo url();?>/public/frontend/images/account/changepassword.png" alt=""></a>
                        <a href="<?php echo url();?>/change-password">Change Password</a>
                        </div>                    	
                    </div>
                </div>-->
                
                <div class="acct_box violet_acct front">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <img src="<?php echo url();?>/public/frontend/images/account/address.png" alt="">
                        <a href="<?php echo url();?>/brand-shipping-address" class="link_wholediv">My Address</a>
                        </div>                    	
                    </div>
                </div>
                
               <!-- <div class="acct_box orange_acct no_marg pull-right">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <img src="<?php echo url();?>/public/frontend/images/account/store.png" alt="">
                        <a href="javascript:void(0);">Store Font<span>Coming Soon</span></a>
                        </div>                    	
                    </div>
                </div>-->
		    
		    
		<div class="acct_box blue_acct front">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="<?php echo url();?>/brand-creditcards"><i class="fa fa-credit-card"></i></a>
                        <a href="<?php echo url();?>/brand-creditcards" class="link_wholediv">Credit Card Details</a>
                        </div>                    	
                    </div>
                </div>
		    
		    
		<div class="acct_box blue_acct no_marg">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="<?php echo url();?>/brand-paydetails"><i class="fa fa-cc-paypal"></i></a>
                        <a href="<?php echo url();?>/brand-paydetails" class="link_wholediv">Payment Details</a>
                        </div>                    	
                    </div>
                </div>
		    
		<div class="acct_box org_org_acct front">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="#"><img src="<?php echo url();?>/public/frontend/images/account/productlist.png" alt=""></a>
                        <a href="<?php echo url();?>/subscription-history" class="link_wholediv">Subscription History</a>
                        </div>                    	
                    </div>
                </div>
		    
		<div class="acct_box blue_acct front">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="#"><i class="fa fa-credit-card"></i></a>
                        <a href="#" class="link_wholediv">Wholesale<span>Coming Soon</span></a>
                        </div>                    	
                    </div>
                </div>
    </div>
    	   <!--my_acct_sec-->
           <div class="my_acct_sec">           
               <div class="container">
               
               <div class="col-sm-10 col-sm-offset-1">
               
               <div class="row"><div class="form_dashboardacct">
               		<h3>Add New Address</h3>
			    
		 @if(Session::has('error'))
                    <div class="alert alert-error container-fluid">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{!! Session::get('error') !!}</strong>
                    </div>
                  @endif
                  @if(Session::has('success'))
                    <div class="alert alert-success container-fluid">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{!! Session::get('success') !!}</strong>
                    </div>
                  @endif
		  
		  {!! Form::open(['url' => 'create-brand-shipping-address','method'=>'POST', 'files'=>true,  'id'=>'member_form']) !!}
                    <div class="bottom_dash special_bottom_pad clearfix">
                    	
                        <div class="row">
                        
                        <div class="col-sm-12">
                        <div class="row">
                         <div class="form-group col-sm-12">
                            {!! Form::text('address_title',null,['class'=>'form-control','id'=>'address_title','placeholder'=>'Address Title'])!!}
                          </div>
                          <div class="form-group col-sm-6">
                            {!! Form::text('first_name',null,['class'=>'form-control','id'=>'first_name','placeholder'=>'First Name'])!!}
                          </div>
                          <div class="form-group col-sm-6">
                            {!! Form::text('last_name',null,['class'=>'form-control','id'=>'last_name','placeholder'=>'Last Name'])!!}
                          </div>
                         
                          <div class="form-group col-sm-6">
                            {!! Form::text('address',null,['class'=>'form-control','id'=>'address1','placeholder'=>'Address 1'])!!}
                          </div>
			    
			  <div class="form-group col-sm-6">
                            {!! Form::text('address2',null,['class'=>'form-control','id'=>'address2','placeholder'=>'Address 2'])!!}
                          </div>
			    
			   <div class="form-group col-sm-6">
                             {!! Form::select('country', array('' => 'Please select country') +$alldata,'default', array('id' => 'country', 'class'=>"form-control",'onchange' => 'getState(this.value,"shipping")')); !!}
                          </div>
			    
			  <div class="form-group col-sm-6">
                             {!! Form::select('zone_id', array('' => 'Please select state'),'default', array('id' => 'state','class'=>"form-control")); !!}
                          </div>
			    
			 <div class="form-group col-sm-6">
                            {!! Form::text('city',null,['class'=>'form-control','id'=>'city','placeholder'=>'City'])!!}
                          </div>
			    
			<div class="form-group col-sm-6">
                            {!! Form::text('postcode',null,['class'=>'form-control','id'=>'postcode','placeholder'=>'Zip code'])!!}
                          </div>
			<div class="form-group col-sm-6">
                            {!! Form::text('phone',null,['class'=>'form-control','id'=>'phone','placeholder'=>'Phone'])!!}
                          </div>
			    
                          
                          <div class="col-sm-12">
                          <p class="pull-left">Default Address</p>
                          
                          <div class="check_box_tab marg_left pull-left">                            
                              <input type="radio" class="regular-checkbox" id="radio-4" name="default_address" value="1">
                              <label for="radio-4">Yes</label>
                          </div>
                          <div class="check_box_tab marg_left pull-left">                            
                              <input type="radio" class="regular-checkbox" id="radio-5" name="default_address" value="0" checked="checked">
                              <label for="radio-5">No</label>
                          </div>
                          
                          </div>
                                                   
                        
                         
                        </div>  
                        </div>
                        </div>
                        
                    </div>
                    
                    <div class="form_bottom_panel">
                    <!--<a href="<?php echo url();?>/brand-dashboard" class="green_btn pull-left"><i class="fa fa-angle-left"></i> Back to Dashboard</a>-->
                    <button type="submit" form="member_form" class="btn btn-default green_sub pull-right">Save</button>
                    </div>
                     {!! Form::close() !!}
               </div>
               
               </div>
               
               </div>
               
               </div>           
           </div>
           <!--my_acct_sec ends-->
	   <script>
	   function getState(country_id,param)
 {
    //alert("country= "+country_id);
    $.ajax({
      url: '<?php echo url();?>/getState',
      method: "POST",
      data: { countryId : country_id ,_token: '{!! csrf_token() !!}'},
      success:function(data)
      {
        
	        $("#state").html(data);
      }
    });

 } 
	    $(function() {

   

    // Setup form validation  //
    $("#member_form").validate({
    
        // Specify the validation rules
        rules: {
	address_title: "required",
		
	    first_name: "required",
	    last_name: "required",
	    
	    address: "required",
	    country: "required",
	    state: "required",
	    city: "required",
	    postcode: "required",
	    phone :
                {
                    required : true,
                    phoneUS: true
                },
      
      
            
     },
		
        submitHandler: function(form) {
            form.submit();
        }
    });


  });
	    
	   </script>
 </div>
 @stop