@extends('frontend/layout/frontend_template')

@section('content')
  <script src="<?php echo url();?>/public/frontend/js/moment.js"></script>
  <script src="<?php echo url();?>/public/frontend/js/bootstrap-datetimepicker.min.js"></script>
	
	  <link rel="stylesheet" type="text/css" href="<?php echo url();?>/public/frontend/css/bootstrap-datetimepicker.min.css">

<!-- jQuery Form Validation code -->
  <script>
  
  // When the browser is ready...
  $(function() {

    $.validator.addMethod("email", function(value, element) 
    { 
    return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value); 
    }, "Please enter a valid email address.");
    
    $.validator.addMethod("bankinginfo", function(value, element) {
      
      if($('#banking_address1').is(':checked')) { 
	if ($("#routing_number").val()=='' && $("#account_number").val()==''){
	  return false;
	}else{
	  return true;
	}
      }else{
	  return true;
	}
      
    }, 'Please enter either routing number or account number.');
    
    $.validator.addMethod("paypalinfo", function(value, element) {
      
      if($('#paypal_email_radio').is(':checked')) { 
	if ($("#paypal_email").val()==''){
	  return false;
	}else{
	  return true;
	}
      }else{
	  return true;
	}
      
    }, 'Please enter your paypal email address.');
    
    $.validator.addMethod("mailinginfo", function(value, element) {
      
      if($('#mailing_info').is(':checked')) { 
	if ($("#mailing_name").val()=='' || $("#mailing_lastname").val()=='' || $("#mailing_address").val()=='' || $("#mailing_country_id").val()=='' || $("#mailing_state").val()=='' || $("#mailing_city").val()=='' || $("#mailing_postcode").val()==''){
	  return false;
	}else{
	  return true;
	}
      }else{
	  return true;
	}
      
    }, 'This field is required.');
    
  /*  $.validator.addMethod("requiredpayinfo", function(value, element, params) { 
    var selectedValue = $('input:radio[name=' + element.name + ']:checked').val();
    
    return (typeof(params) == 'array') ? (params.indexOf(selectedValue) != -1) : selectedValue == params;
}, "You must select the required option.");
    */

    // Setup form validation  //
    $("#member_form").validate({
    
        // Specify the validation rules
        rules: {
			business_name:"required",
      fname: "required",
      lname: "required",
      email: 
                {
                    required : true,
                    email: true
                },
			phone_no :
                {
                    required : true,
                    phoneUS: true
                },
      password:
                  {
                      required : true,
                      minlength:6 
                  }, 
      con_password: 
                  {
                    required :true,
                    equalTo: "#password",
                  },
            
      address: "required",
      banking_address1:"required",
      paypal_email_radio:"required",
      mailing_info:"required",
      routing_number: {
      bankinginfo: true
        },
      account_number: {
      bankinginfo: true
        },
      
      paypal_email: {paypalinfo:true},
     
           
			card_holder_fname: "required",
			card_holder_lname: "required",
			
			card_number: "required",
			expiry_month: "required",
			expiry_year: "required",
			//cvv: "required",
			card_shiping_name: "required",
			card_shiping_address: "required",
			card_country_id: "required",
			card_shiping_city: "required",
			card_state: "required",
			card_shipping_postcode: 
			{
                required :true,
                number: true,
            },
	    mailing_name: {mailinginfo: true},
	     mailing_address: {mailinginfo: true},
	    mailing_country_id: {mailinginfo: true},
	    mailing_city: {mailinginfo: true},
	    mailing_lastname: {mailinginfo: true},
	    mailing_state: {mailinginfo: true},
	    mailing_postcode: {mailinginfo: true},
			
			shiping_fname: "required",
			shiping_lname: "required",
			shiping_address: "required",
			country: "required",
			city: "required",
			
			state: "required",
			shipping_postcode:
			{
                required :true,
                number: true,
            },
			
            agree: "required",
	    government_issue: "required",
	    banking_address: "required",
	    calldate: "required",
	    calltime: "required",
			
        },
		
        submitHandler: function(form) {
            form.submit();
        }
    });


  });
  
  </script>

<!--for login page-->
    <div class="brand_login">
        
        <!--login_cont-->
        <div class="login_cont">
            <div class="log_inner text-center">
                <h2 class="wow fadeInDown">Sign Up</h2>
		@if(Session::has('error'))
                    <div class="alert alert-error container">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{!! Session::get('error') !!}</strong>
                    </div>
                  @endif
                  @if(Session::has('success'))
                    <div class="alert alert-success container">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{!! Session::get('success') !!}</strong>
                    </div>
                  @endif
                <!--<div class="log_btnblock md15">
                    <a href=""><img src="<?php echo url();?>/public/frontend/images/log_google.png" alt=""></a>
                    <a href=""><img src="<?php echo url();?>/public/frontend/images/log_fb.png" alt=""></a>                
                </div>
                <img src="<?php url();?>public/frontend/images/or.png" alt="">-->
                
        {!! Form::open(['url' => 'brandregister','method'=>'POST', 'files'=>true, 'onsubmit'=>'return validatebrand()', 'id'=>'member_form']) !!}
	<input type="hidden" name="callvalid" id="callvalid" value="invalid"/>
                <div class="brand_login_panel">
                    <div class="row">
                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-8  wow fadeInDown"><h2 class="">Personal Information</h2></div>
                        <div class="col-sm-2">&nbsp;</div>
                    </div>
                    <div class="form_panel">
                      <div class="row signup_form_panel">                    
                        <div class="col-sm-2">&nbsp;</div>
                        
			  <div class="col-sm-4">
			    <div class="input-group wow slideInLeft md15">
                                {!! Form::text('business_name',null,['class'=>'form-control','placeholder'=>'Name / Business Name', 'aria-describedby'=>'basic-addon2'])!!}
                            </div>
			  </div>
			  <div class="col-sm-4">
			    <div class="input-group wow slideInRight md15">
                                {!! Form::text('email',null,['class'=>'form-control','id'=>'email','placeholder'=>'Email', 'aria-describedby'=>'basic-addon2','onblur' =>'emailChecking(this.value)'])!!}
                                 <label id="email_error" class="error">Email-Id is already exist.</label>
                            </div>
			  </div>
			
			<div class="col-sm-4 col-sm-offset-2">
			  <div class="input-group wow slideInRight md15">
                                {!! Form::text('fname',null,['class'=>'form-control','id'=>'fname','placeholder'=>'Executive in Charge First Name', 'aria-describedby'=>'basic-addon2'])!!}
                            </div>
			</div>
			<div class="col-sm-4">
			  <div class="input-group wow slideInRight md15">
                                {!! Form::text('lname',null,['class'=>'form-control','id'=>'lname','placeholder'=>'Executive in Charge Last Name', 'aria-describedby'=>'basic-addon2'])!!}
                            </div>
			</div>
			
			<div class="col-sm-4 col-sm-offset-2">
			  <div class="input-group wow slideInRight md15">
                                {!! Form::password('password',['class'=>'form-control','id'=>'password','placeholder'=>'Password', 'aria-describedby'=>'basic-addon2'])!!}
                            </div>  
			</div>
			<div class="col-sm-4">
			  <div class="input-group wow slideInRight md15">
                                {!! Form::password('con_password',['class'=>'form-control','id'=>'con_password','placeholder'=>'Confirm Password', 'aria-describedby'=>'basic-addon2'])!!}
                            </div> 
			</div>
			
			
			
			<div class="col-sm-4 col-sm-offset-2">
                          
                            <div class="input-group wow slideInLeft md15">
                                {!! Form::text('phone_no',null,['class'=>'form-control','placeholder'=>'Phone Number', 'aria-describedby'=>'basic-addon2'])!!}
                            </div>                
                            
                        </div>
                        <div class="col-sm-4">
                           
                            <div class="input-group wow slideInRight md15">
                                {!! Form::file('image',['class'=>'btn','id'=>'image','placeholder'=>'Issue Id'])!!}
                            </div>
                         </div>
                         <div class="col-sm-2">&nbsp;</div>                             

                        </div>
                      </div>
                	</div>
                <div class="brand_login_panel">
                    <div class="row">
                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-8  wow fadeInDown"><h2 class="">Banking Information</h2></div>
                        <div class="col-sm-2">&nbsp;</div>
                    </div>
                    <div class="form_panel">
                    <div class="row signup_form_panel">                    
                    <div class="col-sm-2">&nbsp;</div>
                    <div class="col-sm-8">
		    <div class="row">
		     <div class="checkbox check_now wow slideInRight md15">
			    <label><input type="radio" name="default_band_preference" id="banking_address1" value="0" > Routing Number / Account Number</label>
			    </div>
		    </div>
                    <div class="row">
                    <div class="clearfix">
		    <div class="col-sm-6">
                        <div class="input-group wow slideInLeft md15">
                            {!! Form::text('routing_number',null,['class'=>'form-control address-group','id'=>'routing_number','placeholder'=>'Routing Number', 'aria-describedby'=>'basic-addon2'])!!}
			    
			    
			   
			    
                        </div>
			    
			    
                     </div>
                     <div class="col-sm-6">
                     	<div class="input-group wow slideInLeft md15">
			     {!! Form::text('account_number',null,['class'=>'form-control address-group','id'=>'account_number','placeholder'=>'Account Number', 'aria-describedby'=>'basic-addon2'])!!}
			</div>
                     </div>
		    </div>
		    </div></div></div></div>
			
		<div class="row">
                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-8  wow fadeInDown"><h2 class="">Paypal Information</h2></div>
                        <div class="col-sm-2">&nbsp;</div>
                 </div>
		   
		   <div class="form_panel">
                    <div class="row signup_form_panel">                    
                    <div class="col-sm-2">&nbsp;</div>
                    <div class="col-sm-8">
                    <div class="row"> 
			
                        <div class="clearfix"><div class="col-sm-6"><div class="input-group wow slideInRight md15">
                            {!! Form::text('paypal_email',null,['class'=>'form-control address-group','id'=>'paypal_email','checked'=>'checked','placeholder'=>'Paypal email', 'aria-describedby'=>'basic-addon2'])!!}
			    
                        </div></div>
                        <div class="col-sm-6">
                        <div class="checkbox check_now wow slideInRight md15">
                        	<label><input type="radio" name="default_band_preference" id="paypal_email_radio" value="1" checked="checked"> Paypal Email</label>
                        </div>
                        </div></div>
		    </div></div></div></div>
			
		    <div class="row">
                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-8  wow fadeInDown"><h2 class="">Check Information</h2></div>
                        <div class="col-sm-2">&nbsp;</div>
                 </div>
			    
		 <div class="form_panel">
                    <div class="row signup_form_panel">                    
                    <div class="col-sm-2">&nbsp;</div>
                    <div class="col-sm-8">
		    <div class="row">
		     <div class="checkbox check_now wow slideInRight md15">
                        <label><input type="radio" name="default_band_preference" id="mailing_info" value="2"> Check</label>
                        </div>
		    </div>
                    <div class="row">	    
			    
                
			    
			      <div class="form-group">
                          
			   <div class="col-sm-6">
			      <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
                                    <!-- <input class="form-control" placeholder="Full Name" aria-describedby="basic-addon2" type="text"> -->
                                    {!! Form::text('mailing_name',null,['class'=>'form-control address-group','id'=>'mailing_name','placeholder'=>'First Name'])!!}
                                </div>
			   </div>
			   <div class="col-sm-6">
				  <div style="visibility: visible; animation-name: slideInRight;" class="input-group wow slideInRight md15 animated">
                                    <!-- <input class="form-control" placeholder="Phone" aria-describedby="basic-addon2" type="text"> -->
                                     {!! Form::text('mailing_lastname',null,['class'=>'form-control address-group','id'=>'mailing_lastname','placeholder'=>'Last Name'])!!}
                                </div>
			   </div>
			  
			  <div class="col-sm-6">
			     <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
                                    <!-- <input class="form-control" placeholder="Address 1" aria-describedby="basic-addon2" type="text"> -->
                                    {!! Form::text('mailing_address',null,['class'=>'form-control address-group','id'=>'mailing_address','placeholder'=>'Address'])!!}
                                </div>
			  </div>
			  <div class="col-sm-6">
			    <div style="visibility: visible; animation-name: slideInRight;" class="input-group wow slideInRight md15 animated">
                                   
                                   {!! Form::text('mailing_address2',null,['class'=>'form-control address-group','id'=>'mailing_address2','placeholder'=>'Address 2'])!!}
                                </div>
			  </div>
			  
			   <div class="col-sm-6">
			    <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
				    {!! Form::select('mailing_country_id', array('' => 'Please select country') +$alldata,'default', array('id' => 'mailing_country_id','class'=>'form-control address-group','onchange' => 'getState(this.value,"mail")')); !!}
                                </div>
			   </div>
			    <div class="col-sm-6">
			      <div style="visibility: visible; animation-name: slideInRight;" class="input-group wow slideInRight md15 animated">
                            		{!! Form::select('mailing_state', array('' => 'Please select state'),'default', array('id' => 'mailing_state','class'=>'form-control address-group')); !!}
                                </div>
			    </div>
			   
			   <div class="col-sm-6">
                              
                                <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
                                    {!! Form::text('mailing_city',null,['class'=>'form-control address-group','id'=>'mailing_city','class'=>'form-control address-group','placeholder'=>'City'])!!}
                                </div>                                
                            </div>
                            <div class="col-sm-6">
                            
                                <div style="visibility: visible; animation-name: slideInRight;" class="input-group wow slideInRight md15 animated">
                                   
                                   {!! Form::text('mailing_postcode',null,['class'=>'form-control address-group','id'=>'mailing_postcode','placeholder'=>'Post Code'])!!}
                                </div>
                            </div>
                          </div>
			    
			    
			    
			    
                        </div>
                    
                 
                    </div>
                    <div class="col-sm-2">&nbsp;</div>
                </div>
                    </div>
                </div>
                <div class="brand_login_panel">
                    <div class="row">
                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-8  wow fadeInDown"><h2 class="">Card Information</h2></div>
                        <div class="col-sm-2">&nbsp;</div>
                    </div>
                    <div class="form_panel">
                         <div class="row signup_form_panel">                    
                    <div class="col-sm-2">&nbsp;</div>
                    
                    <div class="form-horizontal col-sm-8" >
                        <fieldset>
                          <div class="form-group">
                           
				<div class="col-sm-6">
				 <div class="input-group wow slideInRight md15">
				    {!! Form::text('card_holder_fname',null,['class'=>'form-control','id'=>'card_holder_fname','placeholder'=>'First Name'])!!}
				</div>
				</div>
				    
				<div class="col-sm-6">
				<div class="input-group wow slideInRight md15">
				    {!! Form::text('card_holder_lname',null,['class'=>'form-control','id'=>'card_holder_lname','placeholder'=>'Last Name'])!!}
				</div>
				</div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-6">
                            <div class="input-group wow slideInRight md15">
                          {!! Form::text('card_number',null,['class'=>'form-control','id'=>'card_number','placeholder'=>'Debit/Credit Card Number'])!!}
                      </div>
                            </div>
                          
                            <div class="col-sm-6">
                              <div class="row">
                                <div class="col-xs-6">
                                <div class="input-group wow slideInRight md15">
                                  <select class="form-control col-sm-2" name="expiry_month" id="expiry_month">
                                    <option value="">Month</option>
                                    <option value="01">Jan (01)</option>
                                    <option value="02">Feb (02)</option>
                                    <option value="03">Mar (03)</option>
                                    <option value="04">Apr (04)</option>
                                    <option value="05">May (05)</option>
                                    <option value="06">June (06)</option>
                                    <option value="07">July (07)</option>
                                    <option value="08">Aug (08)</option>
                                    <option value="09">Sep (09)</option>
                                    <option value="10">Oct (10)</option>
                                    <option value="11">Nov (11)</option>
                                    <option value="12">Dec (12)</option>
                                  </select>
                                  </div>
                                </div>
                                <div class="col-xs-6">
                                <div class="input-group wow slideInRight md15">
                                  <select class="form-control" name="expiry_year" id="expiry_year">
                                  <?php 
									$current_yr = date("Y");
								  	for($i=1;$i<30;$i++){
										$yr  = $current_yr+$i;
								   ?>
                                   	<option value="<?php echo $yr;?>"><?php echo $yr;?></option>
                                   <?php		
									}
								  ?>
                                    
                                  </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!--<div class="form-group">
                            <div class="col-sm-3">
                            <div class="input-group wow slideInRight md15">
                             
                              {!! Form::password('cvv',null,['class'=>'form-control','id'=>'cvv','placeholder'=>'Security Code'])!!}
                              </div>
				
				
                            </div>
                          </div>-->
                          
                          <div class="form-group">
                           
			   <div class="col-sm-6">
			    <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
                                   
                                    {!! Form::text('company_name',null,['class'=>'form-control','id'=>'company_name','placeholder'=>'Company Name'])!!}
                                </div>
			   </div>
			   <div class="col-sm-6">
			    <div style="visibility: visible; animation-name: slideInRight;" class="input-group wow slideInRight md15 animated">
                                   
                                     {!! Form::text('card_shipping_phone_no',null,['class'=>'form-control','id'=>'card_shipping_phone_no','placeholder'=>'Phone'])!!}
                                </div>
			   </div>
			   <div class="col-sm-6">
			     <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
                                   
                                    {!! Form::text('card_shiping_address',null,['class'=>'form-control','id'=>'card_shiping_address','placeholder'=>'Address '])!!}
                                </div>
			   </div>
			   <div class="col-sm-6">
			    <div style="visibility: visible; animation-name: slideInRight;" class="input-group wow slideInRight md15 animated">
                                   
                                   {!! Form::text('card_shipping_fax',null,['class'=>'form-control','id'=>'card_shipping_fax','placeholder'=>'Fax'])!!}
                                </div>
			   </div>
			   <div class="col-sm-6">
			    <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
					        	{!! Form::select('card_country_id', array('' => 'Please select country') +$alldata,'default', array('id' => 'card_country_id','onchange' => 'getState(this.value,"card")')); !!}
                                </div>
			   </div>
			   <div class="col-sm-6">
			    <div style="visibility: visible; animation-name: slideInRight;" class="input-group wow slideInRight md15 animated">
                            		{!! Form::select('card_state', array('' => 'Please select state'),'default', array('id' => 'card_state')); !!}
                                </div>
			    </div>
			   <div class="col-sm-6">
                              
                                <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
                                    {!! Form::text('card_shiping_city',null,['class'=>'form-control','id'=>'card_shiping_city','placeholder'=>'City'])!!}
                                </div>                                
                            </div>
                            <div class="col-sm-6">
                            
                                <div style="visibility: visible; animation-name: slideInRight;" class="input-group wow slideInRight md15 animated">
                                   
                                    {!! Form::text('card_shipping_postcode',null,['class'=>'form-control','id'=>'card_shipping_postcode','placeholder'=>'Post Code'])!!}
                                </div>
                            </div>
                          </div>
                        </fieldset>
                    </div>
                    <div class="col-sm-2">&nbsp;</div>
                </div>
                    </div>
                </div>
                <div class="brand_login_panel">
                    <div class="row">
                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-8  wow fadeInDown"><h2 class="">Shipping address for monthly samples</h2></div>
                        <div class="col-sm-2">&nbsp;</div>
                    </div>
                    <div class="form_panel">
                         <div class="row signup_form_panel">
                   
                    
                    
		    <div class="col-sm-4 col-sm-offset-2">
			<div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
                            
                              {!! Form::text('shiping_fname',null,['class'=>'form-control','id'=>'shiping_fname','placeholder'=>'First Name'])!!}
                        </div>
		    </div>
		    <div class="col-sm-4">
		      <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
                            
                              {!! Form::text('shiping_lname',null,['class'=>'form-control','id'=>'shiping_lname','placeholder'=>'Last Name'])!!}
                        </div>
		    </div>
		    
		    <div class="col-sm-4 col-sm-offset-2">
		      <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
                            
                             {!! Form::text('shiping_address',null,['class'=>'form-control','id'=>'shiping_address','placeholder'=>'Address 1'])!!}
                        </div>
		    </div>
		    <div class="col-sm-4">
		      <div style="visibility: visible; animation-name: slideInRight;" class="input-group wow slideInRight md15 animated">
                            {!! Form::text('shipping_address2',null,['class'=>'form-control','id'=>'shipping_address2','placeholder'=>'Address 2'])!!}
                        </div>
		    </div>
		    
		    <div class="col-sm-4 col-sm-offset-2">
		      <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
					        {!! Form::select('country', array('' => 'Please select country') +$alldata,'default', array('id' => 'country','onchange' => 'getState(this.value,"shipping")')); !!}
                        </div>
		    </div>
		    <div class="col-sm-4">
		      <div style="visibility: visible; animation-name: slideInRight;" class="input-group wow slideInRight md15 animated">
                            {!! Form::select('state', array('' => 'Please select state'),'default', array('id' => 'state')); !!}
                        </div>
		    </div>
		    <div class="col-sm-4 col-sm-offset-2">
                    
                        <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
                            {!! Form::text('city',null,['class'=>'form-control','id'=>'city','placeholder'=>'City'])!!}
                        </div>
                       
                    </div>
                    <div class="col-sm-4">
		                            
                        <div style="visibility: visible; animation-name: slideInRight;" class="input-group wow slideInRight md15 animated">
                           <!--  <input class="form-control" placeholder="Post Code" aria-describedby="basic-addon2" type="text"> -->
                           {!! Form::text('shipping_postcode',null,['class'=>'form-control','id'=>'shipping_postcode','placeholder'=>'Post Code'])!!}
                        </div>
                    </div>
                    <div class="col-sm-2">&nbsp;</div>
                </div>
                    </div>
                </div>
                <div class="brand_login_panel">
                    <div class="row">
                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-8  wow fadeInDown"><h2 class="">Picture of govt issues ID(passport or Driver's License)</h2></div>
                        <div class="col-sm-2">&nbsp;</div>
                    </div>
                    <div class="form_panel">
                         <div class="row signup_form_panel">
                    <div class="col-sm-2">&nbsp;</div>
                    <div class="col-sm-8">
                        <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
                             {!! Form::file('government_issue',['class'=>'btn','id'=>'government_issue','placeholder'=>'Issue Id'])!!}
                        </div>
                    </div>
                    
                    <div class="col-sm-2">&nbsp;</div>
                </div>
                    </div>
                </div>
                

                <div class="brand_login_panel">
                    <div class="row">
                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-8  wow fadeInDown"><h2 class="">Call Date Time</h2></div>
                        <div class="col-sm-2">&nbsp;</div>
                    </div>
                    <div class="form_panel">
                         <div class="row signup_form_panel">
                    <div class="col-sm-2">&nbsp;</div>
                    <div class="col-sm-8">
                        <div class="row">
                        <div class="col-sm-6"><div class="input-group ">
                             {!! Form::text('calldate',null,['class'=>'form-control','id'=>'calldate','placeholder'=>'Call Date'])!!}
                        </div></div>
                        <div class="col-sm-6"><div  class="input-group ">
                             {!! Form::text('calltime',null,['class'=>'form-control','id'=>'calltime','placeholder'=>'Call Time'])!!}
                        </div></div>
                        </div>
                    </div>
                    
                    <div class="col-sm-2">&nbsp;</div>
                </div>
		    <div class="row" id="callmsg"></div>
                    </div>
                </div>

		<div class="brand_login_panel">
                    <div class="form_panel">
                         <div class="row signup_form_panel">
                    <div class="col-sm-2">&nbsp;</div>
                    <div class="col-sm-8">
                        <p>{!! Form::checkbox('agree', 1, null, ['class' => 'field']) !!} Accepting of Brand Contract with electronic signature on document</p>
                    </div>
                    
                    <div class="col-sm-2">&nbsp;</div>
                </div>
                    </div>
                </div>
		    
		    
                <div class="row  signup_form_panel text-center md30">
                    <div class="col-sm-4">&nbsp;</div>
                    <div class="col-sm-4 mu15">
                      <button type="submit" class="wow fadeInUp btn btn-default sub_btn">Submit</button>
                    </div>
                    <div class="col-sm-4">&nbsp;</div>                    
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <!--login_cont-->
        
    </div>
    <!--for login page-->
    
	
	

		  
<script type="text/javascript">

 
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

</script>


<script type="text/javascript">


function updateDate(brand_member_id)
 {
    var selectdate = $("#idTourDateDetails").val();
	var brand_member_id = brand_member_id;
        $.ajax({
          url: '<?php echo url();?>/updateDate',
          method: "POST",
          data: { selectdate : selectdate , brand_member_id : brand_member_id ,_token: '{!! csrf_token() !!}'},
          success:function(data)
          {
            //alert(data);
            if(data !='' ) // email exist already
            {
               window.location.href = "<?php echo url()?>/brandregister";
            }
            
          }
		  
        });
    
 }


 /***** DUPLICATE E-MAIL CHECK ****/

 function emailChecking(email_id)
 {
    if(email_id !='')
    {
        $.ajax({
          url: '<?php echo url();?>/emailChecking',
          method: "POST",
          data: { email : email_id ,_token: '{!! csrf_token() !!}'},
          success:function(data)
          {
            //alert(data);
            if(data == 1 ) // email exist already
            {
                $("#email").val('');
                $("#email_error").show();
            }
            else
            {
                $("#email_error").hide();
            }
          }
        });
    }
 }

/***** DUPLICATE E-MAIL CHECK ****/
// $(function () {
//             $('#datetimepicker12').datetimepicker({
//                 inline: true,
//                 sideBySide: true
//             });
//         });
/*
 $('#calldate').datepicker({
      pickTime: false,
      dateFormat: 'dd-mm-yy',
     minDate: '+5d',
     changeMonth: true,
     changeYear: true,
     altFormat: "yy-mm-dd"
    });
*/
</script>
  
<script type="text/javascript">
$( document ).ready(function() {

 $('#calldate').datetimepicker({
   format:'YYYY-M-D',
   focusOnShow:false,
  
   minDate: '<?php echo date("Y/m/d")?>'
    });
    
$('#calltime').datetimepicker({ format: 'LT',
stepping:60,
 disabledHours: [0, 1, 2, 3, 4, 5, 6, 7, 21, 22, 23, 24],
enabledHours: [8,9, 10, 11, 12, 13, 14, 15, 16,17,18,19,20]
});

 $("#calltime, #calldate").on("dp.change", function(e) {
          // console.log(e.date);
	  $.ajax({
		url : "<?php echo url();?>/validatecalltime",
		type: "POST",
		data : '_token={!! csrf_token() !!}&date='+$('#calldate').val()+'&time='+$('#calltime').val(),
		success: function(data, textStatus, jqXHR)
		{
		    $("#callvalid").val(data);
		}
	      })
        });
	

});
  function SendToUrl()
  {
         window.location='<?php echo url();?>/brandregister'
  }
  
  function validatebrand() {
    var callstat=$("#callvalid").val();
    
    if (callstat=='invalid'){
	$("#callmsg").html("Please select valid time format");
	return false
    }
     if (callstat=='alreadybooked'){
	$("#callmsg").html("This time is already booked by another user.");
	return false
    }
   
  
    return true;
  }
</script>
  
<style>
#email_error
{
    display: none;
    }
	.button_hide
	{
	  display: none;
	}
.bootstrap-datetimepicker-widget{
  z-index: 9000 !important;
}
</style>
@stop