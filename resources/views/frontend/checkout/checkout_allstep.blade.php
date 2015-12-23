@extends('frontend/layout/frontend_template')
@section('content')
<script src="https://connect.facebook.net/en_US/all.js"></script>
 
 <script src="https://apis.google.com/js/api:client.js"></script>

<meta name="google-signin-client_id" content="<?php echo env('GOOGLE_CLIENT_ID')?>">
<script>




      var clientId = '<?php echo env('GOOGLE_CLIENT_ID')?>';
      
      var apiKey = '<?php echo env('GOOGLE_CLIENT_SECRET')?>';
      var response=[];
       function attachSignin(element) {
      
       auth2.attachClickHandler(element, {},
	   function(googleUser) {
	     console.log(googleUser.getBasicProfile());
	     
	     //response['_token']='{!! csrf_token() !!}';
	     //response['name']=googleUser.getBasicProfile().getName();
	    // response['email']=googleUser.getBasicProfile().getEmail();
	   
	       $.post( "<?php echo url();?>/account/google",{_token:'{!! csrf_token() !!}',name:googleUser.getBasicProfile().getName(),email:googleUser.getBasicProfile().getEmail(),id:googleUser.getBasicProfile().getId(),checkout:'yes'} , function(response) {
	    location.href=response;
	    //console.log("Response: "+response);
	    });
	 
	   }, function(error) {
	    // alert(JSON.stringify(error, undefined, 2));
	   });
     }

var googleUser = {};
  var startApp = function() {
    gapi.load('auth2', function(){
      // Retrieve the singleton for the GoogleAuth library and set up the client.
      auth2 = gapi.auth2.init({
        client_id: '<?php echo env('GOOGLE_CLIENT_ID')?>',
        cookiepolicy: 'single_host_origin',
        // Request scopes in addition to 'profile' and 'email'
        //scope: 'additional_scope'
      });
      attachSignin(document.getElementById('googleSignIn'));
    });
  };
startApp();
   function fbAsyncInit() {
  FB.init({
   appId      : '<?php echo env('FB_CLIENT_ID')?>',
   status     : true, // check login status
   cookie     : true, // enable cookies to allow the server to access the session
   xfbml      : true  // parse XFBML
  });
 }

 function fblogIn() {
    FB.login(
       function(response) {
    	if (response.status== 'connected') {
			FB.api('/me?fields=name,email', function(response) {
			 console.log(response);
			  // console.log('Good to see you, ' + response.email + '.');
			response._token='{!! csrf_token() !!}';
			response.checkout='yes'
			 $.post( "<?php echo url();?>/account/facebook",response , function(response) {
			location.href=response;
			//console.log("Response: "+response);
			});  

			});

		}
     },
     {
 		scope: "email,public_profile,user_location"
     }
  );
 }
 fbAsyncInit();
 
 
  function fblogOut() {
  FB.logout(function(response) {
   console.log('logout :: ', response);
   
  });
 }
</script>
<script type="text/javascript">
$(document).ready(function() {
// Guest Login Button
	$('#guest_login_btn').on('click',function(){
		
		$.ajax({
	      url: '<?php echo url();?>/checkout-guest-login',
	      method: "POST",
	      data: { _token: '{!! csrf_token() !!}'},
	      success:function(data)
	      {
	        //alert(data);
			$('#whole_accordloader').show();
	        $('#collapseOne').removeClass("in");
	        $('#collapseTwo').addClass("in").removeAttr('style');
			$('.panel-title a[href="#collapseTwo"]').attr('data-toggle','collapse');
			//$('#current_step').val(9);
			$('.steps_main ul li:nth-child(1)').removeClass('active').addClass('done');
			$('.steps_main ul li:nth-child(1) span').html('&#10003;');
			$('.steps_main ul li:nth-child(2)').addClass('active');
			setTimeout(function(){
				$('#whole_accordloader').hide();
				$('html,body').animate({
					scrollTop: $('#collapseTwo').offset().top-140 
				}, 500);	
			},1000);
						
			
	      }
	    });

	});

// Guest Registration button
	$('#guest_reg_btn').on('click',function(){
		
		$("#checkout_guest_form3").validate({
    
	        // Specify the validation rules
	        rules: {
	            guest_fname: {required:true},
	            guest_lname: {required:true},
	            guest_email: 
	            {
	                required:true,
	                email: true
	            },
	           guest_phone :
	            {
	                required:true,
	                phoneUS: true
	            },
	            guest_address: {required:true},
	            guest_country_id: {required:true},
	            guest_city:{required:true},
	            guest_zip_code: {
					required: true,
      				number: true
					}
	            
	        },
	        submitHandler: function(form) {
				//alert('inside sub below');
				
	        }
    	});
		
		if ($("#checkout_guest_form3").valid()){

		 $.ajax({
			      url: '<?php echo url();?>/checkout-guest-submit',
			      method: "POST",
			      data:  $('#checkout_guest_form3').serialize()+'&_token: {!! csrf_token() !!}',
			      success:function(data)
			      {
					$('#whole_accordloader').show();  
			        $('#collapseThree').addClass("in").removeAttr('style');
			        $('#collapseTwo').removeClass("in");
					$('.panel-title a[href="#collapseThree"]').attr('data-toggle','collapse');
					$('.panel-title a[href="#collapseTwo"]').attr('data-toggle','collapse');
					<?php 
						//if(Session::has('guest')){
					?>
						$('.panel-title a[href="#collapseOne"]').attr('data-toggle','collapse');
					<?php		
						//}
					?>
					$('.steps_main ul li:nth-child(2)').removeClass('active').addClass('done');
					$('.steps_main ul li:nth-child(2) span').html('&#10003;');
					$('.steps_main ul li:nth-child(3)').addClass('active');
					setTimeout(function(){
						$('#whole_accordloader').hide();
						$('html,body').animate({
							scrollTop: $('#collapseThree').offset().top-140 
						}, 500);  
					},1000);
					

			      }
			    });
				
		}

		

		

	});



// Select Payment Method
	$('#payment_btn').on('click',function(){
		
		$("#checkout_form2").validate({
			errorPlacement: function(error, element) 
			{
			  error.insertBefore(element);
			},
			// Specify the validation rules
			rules: {
					payment_type: "required",
					//privacy:"required"
			},
			// Specify the validation error messages
			messages: {
				payment_type: "Please select preffered payment method"            
			},
			submitHandler: function(form) {
				form.submit();
			}
	 });
		if($("#checkout_form2").valid()){
		$.ajax({
	      url: '<?php echo url();?>/checkout-submit-step2',
	      method: "POST",
		  data:  $('#checkout_form2').serialize()+'&_token: {!! csrf_token() !!}',
	      success:function(data)
	      {
			$('#whole_accordloader').show();  
	      	//alert(data);
	        $('#collapseFour').addClass("in").removeAttr('style');
	        $('#collapseThree').removeClass("in");
			$('.panel-title a[href="#collapseFour"]').attr('data-toggle','collapse');
			$('.panel-title a[href="#collapseThree"]').attr('data-toggle','collapse');
			$('.panel-title a[href="#collapseTwo"]').attr('data-toggle','collapse');
			<?php if(Session::has('member_userid')) {?>
				$('.panel-title a[href="#collapseOne"]').removeAttr('data-toggle');			
			<?php } else { ?>
				$('.panel-title a[href="#collapseOne"]').attr('data-toggle','collapse');
			<?php } ?>
			//alert($('input[name=\'payment_type\']:checked').val());
			$('.credit_div').hide();
			$('.paypal_div').hide();
			if($('input[name=\'payment_type\']:checked').val()=="creditcard"){
				$('.credit_div').show();
			}
			else{
				$('.paypal_div').show();

			}
			
			
			$('#payment_type_hidden').val($('input[name=\'payment_type\']:checked').val());
			
			$('.steps_main ul li:nth-child(3)').removeClass('active').addClass('done');
			$('.steps_main ul li:nth-child(3) span').html('&#10003;');
			$('.steps_main ul li:nth-child(4)').addClass('active');
			setTimeout(function(){
				$('#whole_accordloader').hide();
				$('html,body').animate({
						scrollTop: $('#collapseFour').offset().top-140 
				}, 500); 
			},1000)
			
	      }
	    });
	  }
	});

});
</script>



 <div class="inner_page_container">
	<div class="header_panel">
    	<div class="container">
    	 <h2>Brands</h2>
         <ul class="breadcrumb">
            <li><a href="<?php echo url();?>">Home</a></li>
            <li><a href="#">Brands</a></li>
            <li>Health Takes Guts</li>
         </ul>
        </div>
    </div>   
	<!-- Start Products panel -->
	<div class="products_panel">
		<div class="container">
	    
	    <!--steps_main-->
	    <div class="steps_main text-center">
		    <ul>
			    <li class="active"><span>1</span><h6>Checkout Option</h6></li>
			    <li><span>2</span><h6>Shipping Details</h6></li>
			    <li><span>3</span><h6>Payment Method</h6></li>
			    <li><span>4</span><h6>Confirm Order</h6></li>
		    </ul>
	    </div>
	    <!--steps_main-->
	    
	    <div class="col-sm-12">
	    <div class="row">
	    <?php 
	    	$current_step = 1;
	    	/*if(Session::has('payment_method')){
	    		$current_step = 4;
	    	}
	    	else if(Session::has('step3')){
	    		$current_step = 3;
	    	}	    	
	    	else if(Session::has('step1')){
	    		$current_step = 9;
	    	}
	    	else */ if(Session::has('member_userid')){
	    		$current_step = 2;
	    	}
	    ?>
	    <input type="hidden" name="current_step" id="current_step" value="<?php echo $current_step;?>">
	    <input type="hidden" name="payment_type_hidden" id="payment_type_hidden" value="">

	    <div class="one_page_checkout">
        <div id="whole_accordloader"></div>
	    <div class="panel-group" id="accordion">
	        <div class="panel panel-default checkout_cont">
	            <div class="panel-heading">
	                <h4 class="panel-title">
	                    <a  data-parent="#accordion" href="#collapseOne">Step 1 :  Checkout option</a>
	                </h4>
	            </div>
	            <div id="collapseOne" class="panel-collapse collapse">
	                <div class="panel-body">
	                    <div class="row">
	                    <div class="col-sm-6 spec_padright">
	                        <h4>Checkout As Guest</h4>
	                        
	                        <!-- <a href="{!! url('checkout-guest-login') !!}" class="full_green_btn pull-left text-uppercase">Continue</a> -->
	                        <button id="guest_login_btn" class="full_green_btn pull-left text-uppercase cont_checkout">Continue</button>
	                        
	                        </div>
	                        <div class="col-sm-6 spec_padleft"> 
	                        <h4>Returning Customer</h4>
	                        <p class="specil_p">I am a returning customer</p>
	                         @if(Session::has('error'))
						        <div class="alert alert-danger">
						            <button type="button" class="close" data-dismiss="alert">×</button>
						            <strong>{!! Session::get('error') !!}</strong>
						        </div>
						    @endif

						    @if(Session::has('success'))
						        <div class="alert alert-success">
						        <button type="button" class="close" data-dismiss="alert">×</button>
						        <strong>{!! Session::get('success') !!}</strong>
						        </div>
						    @endif
	                        <form class="form-horizontal" role="form" id="member_login" name="member_login" method="POST" action="{{ url('checkout-member-login') }}" autocomplete="off">
							    <input type="hidden" name="_token" value="{{ csrf_token() }}">

							    <div class="form-group">
							    <input type="email" name="email" id="email" class="form-control" placeholder="Email">
							    </div>
							    <div class="form-group">
							    <input type="password" name="password" id="password"  class="form-control" placeholder="Password">
							    </div>
							    <a href="{!! url() !!}/member-forgot-password" class="btn-link">Forgot Password?</a>
							    <input type="submit" class="full_green_btn text-uppercase" value="Login">
							</form>
	                        
	                        <p class="specil_p clearfix">OR</p>
	                       	<a href="javascript:void(0)" onclick="fblogIn()"><img src="<?php echo url();?>/public/frontend/images/log_fb_big.png" width="167" alt=""></a>
               				<a href="javascript:void(0)"  id="googleSignIn"><img src="<?php echo url();?>/public/frontend/images/log_google.png" width="167" alt=""></a>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	        <div class="panel panel-default checkout_cont">
	            <div class="panel-heading">
	                <h4 class="panel-title">
	                    <a data-parent="#accordion" href="#collapseTwo">Step 2 :  Shipping Detail</a>
	                </h4>
	            </div>
	            <div id="collapseTwo" class="panel-collapse collapse">
	               <div class="panel-body">
	               	<div id="login_div" <?php if(!Session::has('member_userid')) { echo 'style="display:none"';} ?>>
	                    <cite>Please select the mailing address you would like to have your item(s) delivered to.</cite>
	    				<?php 


	    				//$selected_address_id=Session::get('selected_address_id');
							$select_address=Session::get('select_address');
							$selected_address_id = 0;
						foreach($shipAddress as $eachAddress){

								 
							    if(Session::has('selected_address_id'))
							    {
							        $selected_address_id = Session::get('selected_address_id');
							    }
							    else 
							    {
							        if(($eachAddress->default_address)!='')
							        {
							            $selected_address_id = $eachAddress->default_address;
							        }
							    }

						}


						?>
					    {!! Form::open(['url' => 'checkout-submit-step3','method'=>'POST', 'files'=>true,'class'=>'form row-fluid','id'=>'checkout_form3','autocomplete'=>'off']) !!}
					    <?php if($selected_address_id>0){ ?>
					    <div class="check_box_tab selectionbasedshow green_version">                            
					         <input type="radio" class="regular-checkbox" id="radio-1" <?php echo ($selected_address_id)>0? "checked=checked":"" ?> name="RadioGroup1">
					         <label for="radio-1">I want to use an existing address</label>
					    </div>
					    <?php } ?>
					    <div class="col-sm-12 clearfix show_hide" id="old_address" <?php if(($selected_address_id)<=0){ echo 'style="display:none"';} else { echo 'style="display:block"'; }?>>
					    
					    <div class="form-group">
					    <select class="form-control" name="existing_address">
					    <?php foreach($shipAddress as $eachAddress){
					    $ship_fname = (($eachAddress->first_name) =='')?$eachAddress->fname:$eachAddress->first_name;
					    $ship_lname = (($eachAddress->last_name) =='')?$eachAddress->lname:$eachAddress->last_name;
					    //echo $ship_fname.$ship_lname; exit;
					   
					    ?>
					    <option value="<?php echo $eachAddress->id;?>" <?php echo (($selected_address_id==$eachAddress->id)?"selected=selected":'')?>><?php echo $ship_fname.' '.$ship_lname.', '.$eachAddress->address.', '.$eachAddress->address2.', '.$eachAddress->country_name.', '.$eachAddress->zone_name ?>
					    </option>
					    <?php } ?>
					      
					    </select>
					    </div>
					    
					    </div>
					    <div class="check_box_tab selectionbasedshow green_version bot_clear">                            
					         <input type="radio" class="regular-checkbox" id="radio-2" name="RadioGroup1" <?php echo ($selected_address_id)<=0? "checked=checked":"" ?>>
					         <label for="radio-2">I want to use a new shipping address</label>
					    </div>
					    <div class="col-sm-12 clearfix show_hide">
					   
					    <div class="row" id="new_address" <?php echo ($selected_address_id)<=0? "style=display:block;":"style=display:none;" ?> >
						    <div class="form-group col-sm-6">
						    	<input type="text" class="form-control" placeholder="First Name" name="fname"  id="fname">
						    </div>
						    <div class="form-group col-sm-6">
						    	<input type="text" class="form-control" placeholder="Last Name" name="lname"  id="lname">
						    </div>
						    <div class="form-group col-sm-6">
						    	<input type="email" class="form-control" placeholder="Email" name="email_custom_address"  id="email_custom_address">
						    </div>
						    <div class="form-group col-sm-6">
						    	<input type="text" class="form-control" placeholder="Phone" name="phone"  id="phone">
						    </div>
						    <div class="form-group col-sm-6">
						    	<input type="text" class="form-control" placeholder="Address 1" name="address"  id="address" onFocus = 'geolocate()'>
						    </div>
						    <div class="form-group col-sm-6">
						    	<input type="text" class="form-control" placeholder="Address 2" name="address2"  id="address2">
						    </div>
						    <div class="form-group col-sm-6">
							    <select  class="form-control" name="country_id" onchange ="getState(this.value)" id="country">
							        <option value="">Please select country</option>
							        <?php foreach($allcountry as $eachCountry)
							        {
							        ?>
							        <option value="{!! $eachCountry->country_id !!}" <?php if($eachCountry->country_id==223){echo 'selected=selected';}?>>{!! $eachCountry->name !!}</option>
							        <?php   
							        }  
							        ?>
							    </select>
						    </div>
						    <div class="form-group col-sm-6">						  
						      {!! Form::select('state', array('' => 'Please select state') +$allstates,'default', array('id' => 'administrative_area_level_1',"class"=>"form-control")); !!}
						    </div>
						    <div class="form-group col-sm-6">
						    	<input type="text" class="form-control" placeholder="City" name="city" id="locality" >
						    </div>
						    <div class="form-group col-sm-6">
						    	<input type="text" class="form-control" placeholder="Post Code"  name="zip_code"  id="postal_code">
						    </div>
					    </div>
					    <input type="hidden" name="select_address" id="select_address" value="<?php echo ($selected_address_id>0)?"existing":"newaddress";?>">
					    
					    <input type="button" id="logged_in_user" class="full_green_btn text-uppercase pull-right" value="Continue">

					    </div>
					    {!! Form::close() !!}
	               	</div>
	               	<div id="guest_div" <?php if(Session::has('member_userid')) { echo 'style="display:none"';} ?>>
	               		<cite>Please select the mailing address you would like to have your item(s) delivered to.</cite>
	    				
					    {!! Form::open(['url' => 'checkout-guest-submit','method'=>'POST', 'files'=>true,'class'=>'form row-fluid','id'=>'checkout_guest_form3','autocomplete'=>'off']) !!}
					    
					    <div class="row">
                            <div class="col-sm-12 clearfix">
                           
                            <div class="row">
                                <div class="form-group col-sm-6">
                                <input type="text" class="form-control" placeholder="First Name" name="guest_fname"  id="guest_fname">
                                </div>
                                <div class="form-group col-sm-6">
                                <input type="text" class="form-control" placeholder="Last Name" name="guest_lname"  id="guest_lname">
                                </div>
                                <div class="form-group col-sm-6">
                                <input type="email" class="form-control" placeholder="Email" name="guest_email"  id="guest_email">
                                </div>
                                <div class="form-group col-sm-6">
                                <input type="text" class="form-control" placeholder="Phone" name="guest_phone"  id="guest_phone">
                                </div>
                                <div class="form-group col-sm-6">
                                <input type="text" class="form-control" placeholder="Address 1" name="guest_address"  id="guest_address">
                                </div>
                                <div class="form-group col-sm-6">
                                <input type="text" class="form-control" placeholder="Address 2" name="guest_address2"  id="guest_address2">
                                </div>
                                <div class="form-group col-sm-6">
                                <select  class="form-control" name="guest_country_id" onchange ="getGuestState(this.value)" id="guest_country_id">
                                    <option value="">Please select country</option>
                                    <?php foreach($allcountry as $eachCountry)
                                    {
                                    ?>
                                    <option value="{!! $eachCountry->country_id !!}" <?php if($eachCountry->country_id==223){echo 'selected=selected';}?>>{!! $eachCountry->name !!}</option>
                                    <?php   
                                    }  
                                    ?>
                                </select>
    
                                </div>
                                <div class="form-group col-sm-6">
                              
                                  {!! Form::select('guest_state', array('' => 'Please select state') +$allstates,'default', array('id' => 'guest_state',"class"=>"form-control")); !!}
                                </div>
                                <div class="form-group col-sm-6">
                                <input type="text" class="form-control" placeholder="City" name="guest_city" id="guest_city">
                                </div>
                                <div class="form-group col-sm-6">
                                <input type="text" class="form-control" placeholder="Post Code"  name="guest_zip_code"  id="guest_zip_code">
                                </div>
                            </div>
                            
                            <input type="button" id="guest_reg_btn" class="full_green_btn text-uppercase pull-right" value="Continue">
    
                            </div>
                        </div>
					    {!! Form::close() !!}
	               	</div>
	               </div>
	            </div>
	        </div>
	        <div class="panel panel-default checkout_cont">
	            <div class="panel-heading">
	                <h4 class="panel-title">
	                    <a data-parent="#accordion" href="#collapseThree">Step 3 :  Payment Method</a>
	                </h4>
	            </div>
	            <div id="collapseThree" class="panel-collapse collapse">
	            	 <div class="panel-body">
	                    
                    	<cite>Please select the preferred payment method to use on this order.</cite>
    
                        {!! Form::open(['url' => 'checkout-submit-step2','method'=>'POST', 'files'=>true,'class'=>'form-horizontal row-fluid','id'=>'checkout_form2','autocomplete'=>'off']) !!}
						    <div class="check_box_tab green_version">                            
						         <input type="radio" class="regular-checkbox payment_type" id="creditcard" name="payment_type" value="creditcard"
						          <?php echo (Session::get('payment_method') =='creditcard')? "checked=checked":''  ?>>
						         <label for="creditcard">Credit or Debit Card</label>
						    </div> 
						    <div class="check_box_tab green_version">                            
						         <input type="radio" class="regular-checkbox payment_type" id="paypal" name="payment_type" value="paypal" 
						         <?php echo (Session::get('payment_method') =='paypal')? "checked=checked":''  ?>>
						         <label for="paypal">Paypal</label>
						    </div>
						    <!-- <div class="normal_label"><input type="checkbox" id="privacy"  name="privacy"><label for="check-1">I have read and agree to the Privacy Policy</label></div> -->
						    <input type="button" id="payment_btn" class="full_green_btn text-uppercase" value="Continue">
						{!! Form::close() !!}  
                    
	                </div>
	                
	            </div>
	        </div>
	        
	        <div class="panel panel-default checkout_cont">
	            <div class="panel-heading">
	                <h4 class="panel-title">
	                    <a data-parent="#accordion" href="#collapseFour">Step 4 :  Confirm Order</a>
	                </h4>
	            </div>
	            <div id="collapseFour" class="panel-collapse collapse">
	                <div class="panel-body">
	                    
				    	{!! Form::open(['url' => 'checkout-step4','method'=>'POST', 'files'=>true,'class'=>'form-horizontal row-fluid','id'=>'checkout_form','autocomplete'=>'off']) !!}
					    <input type="hidden" name="_token" value="{{ csrf_token() }}">
					    
					    <div class="table-responsive table_ship_checkout">
						    <table class="table">
							    <thead>
								  <tr>
								    <th>Product Image</th>
								    <th>Product Name</th>
								    <th>Brand</th>
								    <th>Form Factor Name</th>
								    <th>Duration</th>
								    <th>Quantity</th>
								    <th>Unit Price</th>
								    <th>Total</th>
								  </tr>
							    </thead>
						      <tbody>
						        <?php
						          $all_sub_total =0.00;
						          $all_total =0.00;
						          $total =0.00;
						          $grand_total=0.00;
						          $total_discount = 0.00;


						          if(!empty($cart_result))
						          { 
						            $i=1;
						            foreach($cart_result as $eachcart)
						            {
						              $all_sub_total = $all_sub_total+$eachcart['subtotal'];
						              $all_total = number_format((float)$all_sub_total,2);
						              $total = (float)$all_sub_total;                     // Without Adding Shipping Price
						        ?>
						          
						          <tr>
						          	<td><a href="<?php echo url();?>/product-details/{!! $eachcart['product_slug'] !!}"><img src="<?php echo url();?>/uploads/product/{!! $eachcart['product_image'] !!}" width="116" alt=""></a></td>
						            <td><a href="<?php echo url();?>/product-details/{!! $eachcart['product_slug'] !!}">{!! ucwords($eachcart['product_name']) !!}</a></td>
						            <td>{!! $eachcart['brand_name'] !!}</td>
						            <td>{!! $eachcart['formfactor_name'] !!}</td>
						            <td>{!! $eachcart['duration'] !!}</td>
						            <td><input type="text" class="form-control spec_width" value="<?php echo $eachcart['qty']; ?>" readonly></td>
						            <td>$ {!! number_format($eachcart['price'],2) !!}</td>
						            <td>$ {!! number_format($eachcart['subtotal'],2) !!}</td>
						          </tr>
						        <?php 
						         $i++;
						         }
						        }

						        if(Session::has('coupon_type') && Session::has('coupon_discount'))
						        {
						          $coupon_type = Session::get('coupon_type');
						          $coupon_discount = Session::get('coupon_discount');
						            if($coupon_type == 'F')
						            {
						              $grand_total = ($total - $coupon_discount);
						              $total_discount = $coupon_discount;
						            }
						            elseif($coupon_type == 'P')
						            {
						              $grand_total = ($total - (($total) * ($coupon_discount)/100));
						              $total_discount = (($total)* ($coupon_discount)/100);
						            }
						          
						        }
						        else
						        {
						          $grand_total = $total;
						        }

						        ?>
						        <?php 
						        if($grand_total<=$all_sitesetting['free_discount_rate']) 
						            {
						              $shipping_rate = $all_sitesetting['shipping_rate'];
						            }
						        elseif($grand_total>$all_sitesetting['free_discount_rate'])
						        {
						          $shipping_rate = 0.00;
						        }
						        ?>

							     <tr>
							      <td colspan="5"></td>
							      <td class="text-left" colspan="2">
							      <span>Sub-Total:</span>
							      </td>
							      <td class="text-right">
							      <span>{!! ($all_total!='')?'$':'' !!}{!!  $all_total !!}</span>
							      </td>
							     </tr>
						      <?php 
						      if(Session::has('coupon_type') && Session::has('coupon_discount'))
						        {
						      ?>

						      <tr>
							      <td colspan="5"></td>
							      <td class="text-left" colspan="2">
							      <span>Discount(coupon code  {!! Session::get('coupon_code') !!}):</span>
							      </td>
							      <td class="text-right">
							      <span> -${!! number_format($total_discount,2) !!}</span>
							      </td>
						      </tr>

						      <?php 
						        }
						      ?>
						      <tr>
							      <td colspan="5"></td>
							      <td class="text-left" colspan="2">
							      <span>Shipping Rate:</span>
							      </td>
							      <td class="text-right">
							      <span>{!! (isset($shipping_rate))?'$':'' !!}{!! number_format($shipping_rate,2) !!}</span>
							      </td>
						      </tr>
						      <tr>
							      <td colspan="5"></td>
							      <td class="text-left" colspan="2">
							      <span>Total:</span>
							      </td>
							      <td class="text-right">
							      <span>{!! ($grand_total!='')?'$':'' !!}{!! number_format(($grand_total+$shipping_rate),2) !!}</span>
							      </td>
						      </tr>
							    </tbody>
							</table>
						  </div>
					     <div class="form_bottom_part clearfix <?php if(Session::has('member_userid')) {?>no_botpad<?php } else { ?>bot_padreq<?php } ?>">					    
						    <div class="credit_div" style="display:none;">
					    	<div class="row">
						     <h4>Card Details</h4>
						      <div class="form-group col-sm-12 col-md-6">
						        <label class="col-sm-4">Card Number:*</label>
						        <div class="col-sm-8">
						        <input type="text" class="form-control ccjs-number" placeholder="Card Number" name="card_number"  id="card_number" value="">
						        </div>
						      </div>
						      <div class="form-group col-sm-12 col-md-6">
						         <label class="col-sm-4 col-md-5">Card Expiry Date:*</label>
						        <div class="col-sm-8 col-md-7">
						        <div class="row custom_row">
						        <div class="col-sm-6">
						        <select class="form-control" name="card_exp_month"  id="card_exp_month">
						          
						          <option value="">Month</option>
						          <?php for($i=1;$i<=12;$i++) {?>
						          <option value="<?php echo sprintf('%02d', $i)?>"><?php echo sprintf('%02d', $i);?></option>
						          <?php } ?>
						     
						        </select>
						        </div>
						        
						        <div class="col-sm-6">
						          <select class="form-control" name="card_exp_year"  id="card_exp_year">
						          <option value="">Year</option>
						          <?php for($i=15;$i<50;$i++) {?>
						          <option value="<?php echo $i;?>"><?php echo $i;?></option>
						          <?php } ?>
						          </select>
						        </div>
						        </div>
						        </div>
						      </div>

						      <div class="form-group col-sm-12 col-md-6">
						        <label class="col-sm-4">Name on Card:</label>
						        <div class="col-sm-8"><input type="text" class="form-control" placeholder="Name on Card" name="name_card" id="name_card"  value=""></div>
						      </div>

						      <div class="form-group col-sm-12 col-md-6">
						        <label class="col-sm-4 col-md-5">Card Security Code:*</label>
						        <div class="col-sm-8 col-md-7 no_sidepad">
						        <input type="password" class="form-control" placeholder="Card Security Code (CVV)" name="cvv" id="cvv"  value="">
						        </div>
						      </div>
						     
						      </div>
						      
						     
						      <input type="submit" class="full_green_btn text-uppercase pull-right <?php if(Session::has('member_userid')) {?>logged_inbtn<?php } else { ?>logged_outbtn<?php } ?>" id="checkout_submit" value="Checkout">					    
						    </div>
						    <div class="paypal_div" style="display:none;">
						      
						        <img src="<?php echo url();?>/public/frontend/images/shopping-checkout/paypal_shp.png" alt="">
						        <input type="submit" class="full_green_btn text-uppercase no_topmarg pull-right <?php if(Session::has('member_userid')) {?>logged_inbtn<?php } else { ?>logged_outbtn<?php } ?>" id="paypal_checkout" value="Checkout">
						    <!--###################### HIDDEN FIELD TO INSERT ORDER TABLE START ###############################-->
						    <input name="grand_total" type="hidden" value="{!! ($grand_total+$shipping_rate) !!}">
						    <input name="sub_total" type="hidden" value="{!! ($total) !!}">
						    <input name="discount" type="hidden" value="{!! ($total_discount) !!}">
                            <input name="shipping_rate" type="hidden" value="{!! ($shipping_rate) !!}">
						    <!--##################### HIDDEN FIELD TO INSERT ORDER TABLE END ##################################-->
						    </div>
						     <?php if(!Session::has('member_userid')){?>
						      <div class="col-sm-12 no_double_pad for_register_only_bot">

	                          	<div class="row">
	                                <div class="check_box_tab color_white">                            
	                                     <input type="checkbox" class="regular-checkbox credit_register" id="register_user" name="register_user" value="register">
	                                     <label for="register_user">Register As A User</label>
	                                </div>
	                                <div class="col-sm-4">                            
	                                     <input type="text" id="guest_username" class="form-control hide_first_time_credit" name="guest_username" placeholder="Username">
	                                     <div class="showduplierr"></div> 
	                                </div>
	                                <div class="col-sm-4">                            
	                                     <input type="password" id="guest_password" class="form-control hide_first_time_credit" name="guest_password" placeholder="Password">
	                                </div>
	                                 <div class="col-sm-4">                            
	                                     <input type="password" id="guest_conf_password" class="form-control hide_first_time_credit" name="guest_conf_password" placeholder="Confirm Password">
	                                </div>
	                            </div>
							    
	                          </div>
	                          <?php } ?>
						</div>

					    {!! Form::close() !!} 
	                    
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
    
    </div>
    </div>
    
    </div>
	</div>
<!-- End Products panel --> 
 </div>


  </div>
  <!-- End Full Body Container -->


<script>
  
  // When the browser is ready...
  $(function() {
  
   $.validator.addMethod("email", function(value, element) 
      { 
      return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value); 
      }, "Please enter a valid email address.");

    // Setup form validation  //

    $("#member_login").validate({
        // Specify the validation rules
        rules: {            
            email: 
            {
                required : true,
                email: true
            },
            password: "required"            
        },
        
        // Specify the validation error messages
        messages: {
            email: {
               required: "Please enter email id",
               email : "Please enter a valid email address."
            },
            price: "Please enter password"
        },
        
        submitHandler: function(form) {
            form.submit();
        }
    });

  });
  
</script>
  
<script type="text/javascript">
	$(document).ready(function(){
		if($('#current_step').val()==1){
			$('#collapseOne').addClass("in");
			$('.panel-title a[href="#collapseOne"]').attr('data-toggle','collapse');
		}
		else if($('#current_step').val()==2){
			$('#collapseTwo').addClass("in");
			$('.panel-title a[href="#collapseTwo"]').attr('data-toggle','collapse');
			$('.steps_main ul li:nth-child(2)').removeClass('active').addClass('done');
			$('.steps_main ul li:nth-child(2) span').html('&#10003;');
			
		}
	// 	else if($('#current_step').val()==9){
	// 		$('#collapseTwo').addClass("in");
	// 		$('.panel-title a[href="#collapseTwo"]').attr('data-toggle','collapse');
	// 		$('.panel-title a[href="#collapseOne"]').attr('data-toggle','collapse');
	// 		$('.steps_main ul li:nth-child(1)').removeClass('active').addClass('done');
	// 		$('.steps_main ul li:nth-child(1) span').html('&#10003;');
	// 		$('.steps_main ul li:nth-child(2)').addClass('active');
	// 	}
	// 	else if($('#current_step').val()==2){
	// 		$('#collapseTwo').addClass("in");
	// 		$('.panel-title a[href="#collapseTwo"]').attr('data-toggle','collapse');
	// 	}
	// 	else if($('#current_step').val()==3){
	// 		$('#collapseThree').addClass("in");
	// 		$('.panel-title a[href="#collapseThree"]').attr('data-toggle','collapse');
	// 		$('.panel-title a[href="#collapseTwo"]').attr('data-toggle','collapse');
	// 		<?php 
	// 			if(Session::has('guest')){
	// 		?>
	// 			$('.panel-title a[href="#collapseOne"]').attr('data-toggle','collapse');
	// 		<?php		
	// 			}
	// 		?>
	// 		$('.steps_main ul li:nth-child(1)').removeClass('active').addClass('done');
	// 		$('.steps_main ul li:nth-child(1) span').html('&#10003;');
	// 		$('.steps_main ul li:nth-child(2)').removeClass('active').addClass('done');
	// 		$('.steps_main ul li:nth-child(2) span').html('&#10003;');
	// 		$('.steps_main ul li:nth-child(3)').addClass('active');			
	// 	}
	// 	else if($('#current_step').val()==4){
	// 		$('#collapseFour').addClass("in");
	// 		$('.panel-title a[href="#collapseFour"]').attr('data-toggle','collapse');
	// 		$('.panel-title a[href="#collapseThree"]').attr('data-toggle','collapse');
	// 		$('.panel-title a[href="#collapseTwo"]').attr('data-toggle','collapse');
	// 		<?php 
	// 			if(Session::has('guest')){
	// 		?>
	// 			$('.panel-title a[href="#collapseOne"]').attr('data-toggle','collapse');
	// 		<?php		
	// 			}
	// 		?>
	// 		$('.steps_main ul li:nth-child(1)').removeClass('active').addClass('done');
	// 		$('.steps_main ul li:nth-child(1) span').html('&#10003;');
	// 		$('.steps_main ul li:nth-child(2)').removeClass('active').addClass('done');
	// 		$('.steps_main ul li:nth-child(2) span').html('&#10003;');
	// 		$('.steps_main ul li:nth-child(3)').removeClass('active').addClass('done');
	// 		$('.steps_main ul li:nth-child(3) span').html('&#10003;');
	// 		$('.steps_main ul li:nth-child(4)').addClass('active');
	// 	}
	 })
</script>

<script>
  
  // When the browser is ready...
  $(function() {
    //alert($('select[name="existing_address"] option:selected').val());
    $.validator.addMethod("email", function(value, element) 
    { 
    return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value); 
    }, "Please enter a valid email address.");
    $.validator.addMethod("existing_address", function(value, element) 
    { 
        if($('#radio-1').is(':checked')){
            if($('select[name="existing_address"] option').length<=0){
                return false;
            }
            else if($('select[name="existing_address"] option:selected').val()==''){
                return false;
            }
            else{
                return true;
            }
        }
        else{
            return true;
        }
    }, "Please enter a valid shipping address.");


    $.validator.addMethod("new_address", function(value, element) 
    { 
        if($('#radio-2').is(':checked')){
            if($('#fname').val()==''){
                return false;
            }
            else{
                return true;
            }
        }
        else{
            return true;
        }
    }, "Please Enter First Name.");
	
	$.validator.addMethod("new_address_name", function(value, element) 
    { 
        if($('#radio-2').is(':checked')){
            if($('#lname').val()==''){
                return false;
            }
            else{
                return true;
            }
        }
        else{
            return true;
        }
    }, "Please Enter Last Name.");
	
	$.validator.addMethod("new_address_email", function(value, element) 
    { 
        if($('#radio-2').is(':checked')){
        	console.log("checked")
;            if($('#email_custom_address').val()==''){
                return false;
            }
            else{
                return true;
            }
        }
        else{
            return true;
        }
    }, "Please Enter Email Address Here.");
	
	$.validator.addMethod("new_address_address", function(value, element) 
    { 
        if($('#radio-2').is(':checked')){
            if($('#address').val()==''){
                return false;
            }
            else{
                return true;
            }
        }
        else{
            return true;
        }
    }, "Please Enter Address.");
	
	$.validator.addMethod("new_address_phn", function(value, element) 
    { 
        if($('#radio-2').is(':checked')){
            if($('#phone').val()==''){
                return false;
            }
            else{
                return true;
            }
        }
        else{
            return true;
        }
    }, "Please Enter Phone Number.");
	
	$.validator.addMethod("new_address_country", function(value, element) 
    { 
        if($('#radio-2').is(':checked')){
            if($('#country_id').val()==''){
                return false;
            }
            else{
                return true;
            }
        }
        else{
            return true;
        }
    }, "Please Enter Country Name.");
	
	$.validator.addMethod("new_address_city", function(value, element) 
    { 
        if($('#radio-2').is(':checked')){
            if($('#locality').val()==''){
                return false;
            }
            else{
                return true;
            }
        }
        else{
            return true;
        }
    }, "Please Enter City.");
	
	$.validator.addMethod("new_address_zip", function(value, element) 
    { 
        if($('#radio-2').is(':checked')){
            if($('#postal_code').val()==''){
                return false;
            }
            else{
                return true;
            }
        }
        else{
            return true;
        }
    }, "Please Enter Zip Code.");
	
	// select shipping address for loggedin user
	$('#logged_in_user').on('click',function(){
		
		// Setup form validation  //
		$("#checkout_form3").validate({
		
			// Specify the validation rules
			rules: {
				fname: {new_address:true},
				lname: {new_address_name:true},
				email_custom_address: 
				{
					new_address_email:true,
					email: true
				},
				phone :
				{
					new_address_phn:true,
					phoneUS: true
				},
				existing_address:{existing_address:true},
				address:{new_address_address:true},
				country_id: {new_address_country:true},
				city:{new_address_city:true},
				zip_code: {new_address_zip:true}
				
			},
			
			submitHandler: function(form) {
				form.submit();
			}
		});
	
		if ($("#checkout_form3").valid()){
			//alert('form_submit');
		
		$.ajax({
	      url: '<?php echo url();?>/checkout-submit-step3',
	      method: "POST",
		  data:  $('#checkout_form3').serialize()+'&_token: {!! csrf_token() !!}',
	      success:function(data)
	      {
			$('#whole_accordloader').show();  
			//alert('success');  
	        $('#collapseThree').addClass("in");
	        $('#collapseTwo').removeClass("in");
			//$('.panel-title a[href="#collapseFour"]').attr('data-toggle','collapse');
			$('.panel-title a[href="#collapseThree"]').attr('data-toggle','collapse');
			$('.panel-title a[href="#collapseTwo"]').attr('data-toggle','collapse');
			$('.panel-title a[href="#collapseOne"]').removeAttr('data-toggle');
			setTimeout(function(){
				$('#whole_accordloader').hide();
				$('html,body').animate({
					scrollTop: $('#collapseThree').offset().top -140
			}, 500); 
				  
			},1000);
	      }
	    });
		
		}
	});
	
    

  });
  
  </script>

  <script> 
  /* For Toggle the Shipping address  */
  $(document).ready(function(){

    $('#radio-1').click(function(){
    	
        if ($(this).is(':checked'))
        {
          $('#radio-2').attr('checked',false);  
          $("#select_address").val('existing');
          $("#new_address").slideUp("slow");
          $("#old_address").slideDown("slow");
        }
    });
    $('#radio-2').click(function(){
        if ($(this).is(':checked'))
        {
          $('#radio-1').attr('checked',false);  
          $("#select_address").val('newaddress');
          $("#new_address").slideDown("slow");
          $("#old_address").slideUp("slow");
        }
    });
	
	$(document).on('change','input[name="RadioGroup1"]',function(){
		$('.one_page_checkout .panel-title a[href="#collapseThree"]').attr('data-toggle','');
		$('.one_page_checkout .panel-title a[href="#collapseFour"]').attr('data-toggle','');
	});
    
  });
</script>
<script type="text/javascript">
 // function getState(country_id)
 // {
 //    //alert("country= "+country_id);
 //    $.ajax({
 //      url: '<?php echo url();?>/getState',
 //      method: "POST",
 //      data: { countryId : country_id ,_token: '{!! csrf_token() !!}'},
 //      success:function(data)
 //      {
 //        //alert(data);
 //        if(data!='')
 //        {
	// 		$("#state").attr('disabled',false);
 //            $("#state").html(data);
			
 //        }
	// 	else{
	// 		$("#state").html('<option>Please Select Country First</option>');
	// 		$("#state").attr('disabled','disabled');	
	// 	}
 //      }
 //    });

 // }

</script>
<script type="text/javascript">
 function getGuestState(country_id)
 {
    //alert("country= "+country_id);
    $.ajax({
      url: '<?php echo url();?>/getState',
      method: "POST",
      data: { countryId : country_id ,_token: '{!! csrf_token() !!}'},
      success:function(data)
      {
        //alert(data);
        if(data!='')
        {
			$("#guest_state").attr('disabled',false);
            $("#guest_state").html(data);


            if (state!='') {
			    $("#guest_state option").filter(function() {
			    	return this.text == state; 
				}).attr('selected', true);
			}
			
        }
		else{
			$("#guest_state").html('<option>Please Select Country First</option>');
			$("#guest_state").attr('disabled','disabled');	
		}
      }
    });

 }

</script>
<script type="text/javascript">
$(document).ready(function(e) {
	$(document).on('click','#guest_reg_btn',function(e){
		
		$("#checkout_guest_form3").valid();
		
	});
	$(document).on('click','#logged_in_user',function(e){
		
		$("#checkout_form3").valid();
		
	});
	$(document).on('click','#payment_btn',function(e){
		//e.preventDefault();
		//alert($('#checkout_guest_form3').length);
		$("#checkout_form2").valid();		
	});
	$(document).on('click','#paypal_checkout',function(e){
		$("#checkout_form").valid();				
	});
        
});
</script>

<style>
    #new_address{display:none;}
</style>

 <script>
  // When the browser is ready...
  $(function() {

    
  });
  
  </script>
  <script>
  var check_email;
  // When the browser is ready...
  $(function() {
	 check_email=''; 
	 $(document).on('blur','#guest_email',function(){
		 if($(this).val==check_email){
			 if($('.custom_errorlabel').length>0){}
			 else
				$( "<label class='custom_errorlabel'>This Email already exists</label>" ).insertAfter( $( "#guest_email" ) ); 
		 }
		 else{
			 $('.custom_errorlabel').remove();
		 }
	 });
    // Setup form validation  //
	$.validator.addMethod("guest_username", function(value, element) 
		{ 
		
			if($('#register_user').is(':checked')){
				
				if($('#guest_username').val()==''){
					return false;
				}
				// else if($('#guest_email').val()!=''){

					

				// }
				else{
					return true;
				}
			}
			else{
				return true;
			}
		}, "Please Enter User Name.");
		
	$.validator.addMethod("guest_password", function(value, element) 
		{ 
		
			if($('#register_user').is(':checked')){
				
				if($('#guest_password').val()==''){
					return false;
				}
				else{
					return true;
				}
			}
			else{
				return true;
			}
		}, "Please Enter Password.");	
		
	$.validator.addMethod("guest_conf_password", function(value, element) 
		{ 
		
			if($('#register_user').is(':checked')){
				
				if($('#guest_conf_password').val()=='' || $('#guest_conf_password').val()!=$('#guest_password').val()){
					return false;
				}
				else{
					return true;
				}
			}
			else{
				return true;
			}
		}, "Please Match Password.");	
		
    var validator_form_reset=$("#checkout_form").validate({
        // Specify the validation rules
        rules: {  
			guest_username:{guest_username:true},
			guest_password:{guest_password:true}, 
		  	guest_conf_password:{guest_conf_password :true},          
            card_number: {
                          required: true,
                          creditcard: true
                         },
            card_exp_month: "required",
            card_exp_year: "required",
            cvv: {
                  required: true,
                  minlength: 3
                }   
        },
        
        // Specify the validation error messages
        messages: {
            card_number: {
               required: "Please enter valid card number."
            }
        },
        
        submitHandler: function(form) {
			check_email='';
        	if($('#register_user').is(':checked')){
	        	if($('#guest_username').val()!="" && $('#guest_email').val()!=""){

	        		$.ajax({
				      url: '<?php echo url();?>/usernameEmailChecking',
				      method: "POST",
				      data: { user_name : $('#guest_username').val(), email : $('#guest_email').val() ,_token: '{!! csrf_token() !!}'},
				      success:function(data)
				      {
				      	//alert(data);
				        if(data==1)
				        {
							//alert("Username already exists");					
				        }
				        else if(data==2){
				        	//alert("email already exists");
							$('.one_page_checkout .panel-title a[href="#collapseTwo"]').trigger('click');
							$('#guest_email').trigger('focus');						
							$( "<label class='custom_errorlabel'>This Email already exists</label>" ).insertAfter( $( "#guest_email" ) );
							check_email=$('#guest_email').val();
				        }
						else{
							form.submit();
						}

				      }
				    });
	        		
	        	}
			}
			else{
				form.submit();	
			}
            
        }
    });
	
	$(document).on('change','#register_user',function(){
		var $this=$(this);
		validator_form_reset.resetForm();
		if($this.is(':checked')){
			$('#checkout_form .full_green_btn').addClass('tobelow');
			$('.form_bottom_part').addClass('give_pad');	
		}
		else{
			$('#checkout_form .full_green_btn').removeClass('tobelow');	
			$('.form_bottom_part').removeClass('give_pad');	
		}
	});

  });
  
</script>
<script type="text/javascript">
	$(document).ready(function(){
	// By default hide 3 fields 
		$('.hide_first_time_paypal').hide();
		$('.hide_first_time_credit').hide();
		
	// Toggle 3 fields according to check and uncheck 
		$('.paypal_register').on('click',function(){
			$('.hide_first_time_paypal').toggle();
		});
		$('.credit_register').on('click',function(){
			$('.hide_first_time_credit').toggle();
		});

	// check duplicate username
	$('#guest_username').on('blur',function(){

		$this = $(this);
		$('.showduplierr').html("");

		if($this.val()!=""){
			$.ajax({
		      url: '<?php echo url();?>/usernameChecking',
		      method: "POST",
		      data: { user_name : $this.val() ,_token: '{!! csrf_token() !!}'},
		      success:function(data)
		      {
		        //alert(data);
		        if(data==1)
		        {
					$this.val('');
					$('.showduplierr').html("<p class='custom_errorlabel'>Username already exists</p>");
					setTimeout("$('.showduplierr').html('')",4000)					
		        }
				else{
					$('.showduplierr').html("<p class='custom_errorlabel_success'>Username available</p>");	
					setTimeout("$('.showduplierr').html('')",4000)	
				}
		      }
		    });
		}

	})

	})
</script>


<script>
function getState(country_id) 
{
	//alert("country= "+country_id);
	$.ajax({
	  url: '<?php echo url();?>/getState',
	  method: "POST",
	  data: { countryId : country_id ,_token: '{!! csrf_token() !!}'},
	  success:function(data)
	  {
	    
	    $("#administrative_area_level_1").html(data);
		if (state!='') {
		    $("#administrative_area_level_1 option").filter(function() {
		    	return this.text == state; 
			}).attr('selected', true);
		}
		
	  }
	});

} 
	    
</script>	    
  
   
<script>
// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

var placeSearch, autocomplete,autocomplete1,state;
var componentForm = {
 // street_number: 'short_name',
  //route: 'long_name',
locality: 'long_name',
administrative_area_level_1: 'long_name',
country: 'long_name',
postal_code: 'short_name'
};



function initAutocomplete() {
  // Create the autocomplete object, restricting the search to geographical
  // location types.
  autocomplete = new google.maps.places.Autocomplete((document.getElementById('address')),      {types: ['geocode']});

  autocomplete1 = new google.maps.places.Autocomplete((document.getElementById('guest_address')),      {types: ['geocode']});

  // When the user selects an address from the dropdown, populate the address
  // fields in the form.
  autocomplete.addListener('place_changed', fillInAddress);

  autocomplete1.addListener('place_changed', fillInAddress1);


}

// [START region_fillform]
function fillInAddress1() {
  // Get the place details from the autocomplete object.
  var place = autocomplete1.getPlace();

  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }

  document.getElementById("guest_address").value = place.address_components[0]['long_name'] +" "+ place.address_components[1]['long_name'];

  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
      //alert(addressType);

      if(addressType=='locality'){
      	$('#guest_city').val(val);
		$('#guest_city').trigger('blur');
      }
      if(addressType=='administrative_area_level_1'){
      	$('#guest_state').val(val);
		$('#guest_state').trigger('blur');
      }
      if(addressType=='postal_code'){
      	$('#guest_zip_code').val(val);
		$('#guest_zip_code').trigger('blur');
      }
      if(addressType=='country'){
	
		$("#guest_country_id option").filter(function() {
		    return this.text == val; 
		}).prop('selected', true);
		$( "#guest_country_id" ).change();
	    }
      
      if(addressType=='administrative_area_level_1'){
			state=val;
      }
      
      
    }
  }
}
// [END region_fillform]



// [START region_fillform]
function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();

  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }

  document.getElementById("address").value = place.address_components[0]['long_name'] +" "+ place.address_components[1]['long_name'];

  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
      //alert(addressType);
      if(addressType=='country'){
	
	$("#country option").filter(function() {
	    return this.text == val; 
	}).prop('selected', true);
	$( "#country" ).change();
    }
      
      if(addressType=='administrative_area_level_1'){
	state=val;
      }
      
      
    }
  }
}
// [END region_fillform]

// [START region_geolocation]
// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle({
        center: geolocation,
        radius: position.coords.accuracy
      });
      autocomplete.setBounds(circle.getBounds());
    });
  }
}
// [END region_geolocation]

</script>

<script>
$(function () {
    $(document).on('shown.bs.collapse','.panel-collapse', function (e) {
		var $this=$(this);
		var this_id=$this.attr('id');
		//alert(this_id);
		$('html,body').animate({
                scrollTop: $('#'+this_id).offset().top -140
        }, 500); 
       
    }); 
});
</script>

<script>

</script>




<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo env('GOOGLE_CLIENT_SECRET')?>&signed_in=true&libraries=places&callback=initAutocomplete"
    async defer></script>

@stop