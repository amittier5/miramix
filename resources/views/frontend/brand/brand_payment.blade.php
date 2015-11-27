 @extends('frontend/layout/frontend_template')
@section('content')

<div class="inner_page_container nomar_bottom">
<div class="top_menu_port">
    	<div class="acct_box yellow_act">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <img src="<?php echo url();?>/public/frontend/images/account/sold_products.png" alt="">
                        <a href="<?php echo url();?>/sold-products">Sold Products History</a>
                        </div>                    	
                    </div>
                </div>
                
                <div class="acct_box red_acct">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="<?php echo url();?>/product/create"><img src="<?php echo url();?>/public/frontend/images/account/add_products.png" alt=""></a>
                        <a href="<?php echo url();?>/product/create">Add Products</a>
                        </div>                    	
                    </div>
                </div>
                
                <div class="acct_box org_org_acct no_marg">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="<?php echo url();?>/my-products"><img src="<?php echo url();?>/public/frontend/images/account/productlist.png" alt=""></a>
                        <a href="<?php echo url();?>/my-products">Product List</a>
                        </div>                    	
                    </div>
                </div>
                
                <div class="acct_box new_green_acct no_marg">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                         <a href=""><img src="<?php echo url();?>/public/frontend/images/account/order_hist.png" alt=""></a>
                        <a href="javascript:void(0);">Order History</a>
                        </div>                    	
                    </div>
                </div>
                
                <div class="acct_box blue_acct front">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="<?php echo url();?>/brand-account"><img src="<?php echo url();?>/public/frontend/images/account/pers_info.png" alt=""></a>
                        <a href="<?php echo url();?>/brand-account">Brand Information</a>
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
                        <a href="<?php echo url();?>/brand-shipping-address">My Address</a>
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
                        <a href="<?php echo url();?>/brand-creditcards">Credit Card Details</a>
                        </div>                    	
                    </div>
                </div>
		    
		    
		<div class="acct_box blue_acct no_marg">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="<?php echo url();?>/brand-paydetails"><i class="fa fa-cc-paypal"></i></a>
                        <a href="<?php echo url();?>/brand-paydetails">Payment Details</a>
                        </div>                    	
                    </div>
                </div>
		    
		<div class="acct_box org_org_acct front">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="#"><img src="<?php echo url();?>/public/frontend/images/account/productlist.png" alt=""></a>
                        <a href="<?php echo url();?>/subscription-history">Subscription History</a>
                        </div>                    	
                    </div>
                </div>
		    
		<div class="acct_box blue_acct front">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="#"><i class="fa fa-credit-card"></i></a>
                        <a href="#">Wholesale</a>
                        </div>                    	
                    </div>
                </div>
    </div>
    	   <!--my_acct_sec-->
           <div class="my_acct_sec">           
               <div class="container">
               
               <div class="col-sm-12 col-md-10 col-md-offset-1">
               
               <div class="row">
	      
	        {!! Form::open(['url' => 'brand-paydetails','method'=>'POST', 'files'=>true,  'id'=>'member_form']) !!}
		
               <div class="form_dashboardacct">
               		<h3>Payment Information</h3>
                    <div class="bottom_dash clearfix">
                    	<div class="row">
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
			 </div>
                        <div class="row">
			
			 <h5 class="col-sm-offset-4 col-md-offset-3">Routing / Account</h5>
			    <div class="col-sm-4 col-md-3">
			    <div class="check_box_tab">                            
			      <input type="radio" class="regular-checkbox" id="radio-1" name="default_band_preference" value="0" <?php if($brand_details['default_band_preference']==0) echo 'checked="checked"';?>>
			      <label for="radio-1">Make Default deposit source</label>
			    </div>
			    </div>
			    <div class="col-sm-8 col-md-9">
			    <div class="form-group">
				{!! Form::text('bank_name',$brand_details['bank_name'],['class'=>'form-control address-group','id'=>'bank_name','placeholder'=>'Bank Name', 'aria-describedby'=>'basic-addon2'])!!}
			    </div>
			    
			    <div class="form-group">
				{!! Form::text('routing_number',$brand_details['routing_number'],['class'=>'form-control address-group','id'=>'routing_number','placeholder'=>'Routing Number', 'aria-describedby'=>'basic-addon2'])!!}
			    </div>
			    <div class="form-group">
				{!! Form::text('account_number',$brand_details['account_number'],['class'=>'form-control address-group','id'=>'account_number','placeholder'=>'Account Number', 'aria-describedby'=>'basic-addon2'])!!}
			    </div>
			    </div>
			    
			    <h5 class="col-sm-offset-4 col-md-offset-3">Paypal Information</h5>
			    <div class="col-sm-4 col-md-3">
			    <div class="check_box_tab">                            
			      <input type="radio" class="regular-checkbox" id="radio-2" name="default_band_preference" value="1" <?php if($brand_details['default_band_preference']==1) echo 'checked="checked"';?>>
			      <label for="radio-2"> Make Default deposit source</label>
			    </div>
			    </div>
			    <div class="col-sm-8 col-md-9">
			    <div class="form-group">
				 {!! Form::text('paypal_email',$brand_details['paypal_email'],['class'=>'form-control address-group','id'=>'paypal_email','placeholder'=>'Paypal email', 'aria-describedby'=>'basic-addon2'])!!}
			    </div>
			    
			    </div>
			    
			    <h5 class="col-sm-offset-4 col-md-offset-3">Check Information</h5>
			    <div class="col-sm-4 col-md-3">
			    <div class="check_box_tab">                            
			      <input type="radio" class="regular-checkbox" id="radio-3" name="default_band_preference" value="2" <?php if($brand_details['default_band_preference']==2) echo 'checked="checked"';?>>
			      <label for="radio-3">Make Default deposit source</label>
			    </div>
			    </div>
			    <div class="col-sm-8 col-md-9 last_group">
			    <div class="row">
			    <div class="form-group col-sm-6">
				{!! Form::text('mailing_name',$brand_details['mailing_name'],['class'=>'form-control','id'=>'mailing_name','placeholder'=>'First Name'])!!}
			    </div>
			<div class="form-group col-sm-6">
				{!! Form::text('mailing_lastname',$brand_details['mailing_lastname'],['class'=>'form-control','id'=>'mailing_lastname','placeholder'=>'Last Name'])!!}
			    </div>
			    <div class="form-group col-sm-6">
				{!! Form::text('mailing_address',$brand_details['mailing_address'],['class'=>'form-control','id'=>'mailing_address','placeholder'=>'Address 1'])!!}
			    </div>
				<div class="form-group col-sm-6">
				 {!! Form::text('mailing_address2',$brand_details['mailing_address2'],['class'=>'form-control','id'=>'mailing_address2','placeholder'=>'Address 2'])!!}
			    </div>
				
			    <div class="form-group col-sm-6">
				   {!! Form::select('mailing_country_id', array('' => 'Please select country') +$alldata,$brand_details['mailing_country_id'], array('id' => 'mailing_country_id','class'=>'form-control','onchange' => 'getState(this.value,"mail")')); !!}                        
			    </div>
			    <div class="form-group col-sm-6">
				{!! Form::select('mailing_state', array('' => 'Please select state') +$allstates,$brand_details['mailing_state'], array('id' => 'mailing_state','class'=>'form-control')); !!}
			    </div>
			   
			    <div class="form-group col-sm-6">
				 {!! Form::text('mailing_city',$brand_details['mailing_city'],['class'=>'form-control','id'=>'mailing_city','placeholder'=>'City'])!!}
			    </div>
			    <div class="form-group col-sm-6">
				 {!! Form::text('mailing_postcode',$brand_details['mailing_postcode'],['class'=>'form-control','id'=>'mailing_postcode','placeholder'=>'Post Code'])!!}
			    </div>
			    
			    
			    </div>
			    
			    </div>
			    
                        
                         </div>
                        
                    </div>
                    
                    <div class="form_bottom_panel">
                    <a href="<?php echo url();?>/brand-dashboard" class="green_btn pull-left"><i class="fa fa-angle-left"></i> Back to Dashboard</a>
                    <button type="submit" form="member_form" class="btn btn-default green_sub pull-right">Save</button>
                    </div>
                    
               </div>
               
               {!! Form::close() !!} 
	       </div>
               
               </div>
               
               </div>           
           </div>
           <!--my_acct_sec ends-->
 </div>
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
        //alert(data);
		if(param=="card")
	        $("#card_state").html(data);
		else if (param=='mail') {
		    $("#mailing_state").html(data)
		}else
	        $("#state").html(data);
      }
    });

 }
  
  // When the browser is ready...
  $(function() {
	  
	  $.validator.addMethod("bankinginfo", function(value, element) {
		  if($('#radio-1').is(':checked')){
			if ($("#routing_number").val()==''){
			  return false;
			}else{
			  return true;
			}
			  }else{
			  return true;
			}
		  }, "Please enter routing number.");
	  
	  $.validator.addMethod("paypalemail", function(value, element) {
		  if($('#radio-2').is(':checked')){
			if ($("#paypal_email").val()==''){
			  return false;
			}else{
			  return true;
			}
			  }else{
			  return true;
			}
		  }, "Please enter Paypal Email.");
	  
	  $.validator.addMethod("mailinginfo", function(value, element) {
		  if($('#radio-3').is(':checked')){
			if ($("#mailing_address").val()=='' || $('#mailing_name').val()=='' || $('#mailing_country_id').val()=='' || $('#mailing_city').val()=='' || $('#mailing_state').val()=='' || $('#mailing_postcode').val()==''){
			  return false;
			}else{
			  return true;
			}
			  }else{
			  return true;
			}
		  }, "This Field Is Required.");
	
	// Setup form validation  //
    $("#member_form").validate({
    
        // Specify the validation rules
        rules: {
	
		routing_number: {bankinginfo: true},
	      paypal_email: {paypalemail: true},
	      mailing_address: {mailinginfo: true},	      
	    mailing_name: {mailinginfo: true},
	    mailing_country_id: {mailinginfo: true},
	    mailing_city: {mailinginfo: true},	  
	    mailing_state: {mailinginfo: true},
	    mailing_postcode: {mailinginfo: true}       
     },
		
        submitHandler: function(form) {
            //form.submit();
        }
    });

  });
  
  
    
</script>
@stop