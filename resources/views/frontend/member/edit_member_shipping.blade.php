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
    	<div class="acct_box blue_acct front">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="<?php echo url();?>/member-account"><img src="<?php echo url();?>/public/frontend/images/account/pers_info.png" alt=""></a>
                        <a href="<?php echo url();?>/member-account" class="link_wholediv">Personal Information</a>
                        </div>                    	
                    </div>
                </div> 
        <div class="acct_box green_acct no_marg">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="<?php echo url();?>/member-changepass"><img src="<?php echo url();?>/public/frontend/images/account/changepassword.png" alt=""></a>
                        <a href="<?php echo url();?>/member-changepass" class="link_wholediv">Change Password</a>
                        </div>                    	
                    </div>
                </div>                
        <div class="acct_box violet_acct">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="<?php echo url();?>/member-shipping-address"><img src="<?php echo url();?>/public/frontend/images/account/address.png" alt=""></a>
                        <a href="<?php echo url();?>/member-shipping-address" class="link_wholediv">My Address</a>
                        </div>                    	
                    </div>
                </div>                
        <div class="acct_box orange_acct wish_acct no_marg">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <img src="<?php echo url();?>/public/frontend/images/account/wishlist_icn.png" alt="">
                        <a href="" class="link_wholediv">My Wishlist<span>Coming Soon</span></a>
                        </div>                    	
                    </div>
                </div>
        <div class="acct_box new_green_acct no_marg">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="<?php echo url();?>/order-history"><img src="<?php echo url();?>/public/frontend/images/account/order_hist.png" alt=""></a>
                        <a href="<?php echo url();?>/order-history" class="link_wholediv">Order History</a>
                      </div>                    	
                    </div>
                </div>
    </div>

    	   <!--my_acct_sec-->
           <div class="my_acct_sec">           
               <div class="container">
               
               <div class="col-sm-10 col-sm-offset-1">
               
               <div class="row"><div class="form_dashboardacct">
               		<h3>Edit Address </h3>
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
		  {!! Form::open(['url' => 'edit-member-shipping-address','method'=>'POST', 'files'=>true,  'id'=>'member_form']) !!}
                    <div class="bottom_dash special_bottom_pad clearfix">
                    	 
			 <input type="hidden" name="id" value="<?php echo Request::input('id')?>" />
                        <div class="row">
                        
                        <div class="col-sm-12">
                        <div class="row">
                       
                          <div class="form-group col-sm-6">
                            {!! Form::text('first_name',$address->first_name,['class'=>'form-control','id'=>'first_name','placeholder'=>'First Name'])!!}
                          </div>
                          <div class="form-group col-sm-6">
                            {!! Form::text('last_name',$address->last_name,['class'=>'form-control','id'=>'last_name','placeholder'=>'Last Name'])!!}
                          </div>
                          <div class="form-group col-sm-6">
                            {!! Form::text('email',$address->email,['class'=>'form-control','id'=>'email','placeholder'=>'Email'])!!}
                          </div>
                          <div class="form-group col-sm-6">
                            {!! Form::text('address',$address->address,['class'=>'form-control','id'=>'address1','placeholder'=>'Address 1'])!!}
                          </div>
			    
			  
			    
			   <div class="form-group col-sm-6">
                             {!! Form::select('country', array('' => 'Please select country') +$alldata,$address->country_id, array('id' => 'country', 'class'=>"form-control",'onchange' => 'getState(this.value,"shipping")')); !!}
                          </div>
			    
			  <div class="form-group col-sm-6">
                             {!! Form::select('zone_id', array('' => 'Please select state') +$allstates,$address->zone_id, array('id' => 'state','class'=>"form-control")); !!}
                          </div>
			    
			 <div class="form-group col-sm-6">
                            {!! Form::text('city',$address->city,['class'=>'form-control','id'=>'city','placeholder'=>'City'])!!}
                          </div>
			    
			<div class="form-group col-sm-6">
                            {!! Form::text('postcode',$address->postcode,['class'=>'form-control','id'=>'postcode','placeholder'=>'Zip code'])!!}
                          </div>
			<div class="form-group col-sm-6">
                            {!! Form::text('phone',$address->phone,['class'=>'form-control','id'=>'phone','placeholder'=>'Phone'])!!}
                          </div>
			    <div class="form-group col-sm-6">
                            {!! Form::text('address2',$address->address2,['class'=>'form-control','id'=>'address2','placeholder'=>'Address 2'])!!}
                          </div>
                          
                          <?php if($total_add==0){?>
                              <div class="col-sm-12">
                                <p class="pull-left">Default Address</p>
                                
                                <div class="check_box_tab marg_left pull-left">                            
                                    <input type="radio" class="regular-checkbox" id="radio-4" name="default_address" value="1" checked="checked">
                                    <label for="radio-4">Yes</label>
                                </div>
                              </div>
                          <?php } else { ?>
                              <div class="col-sm-12">
                                  <p class="pull-left for_lineheight">Default Address</p>
                                  
                                  <div class="check_box_tab marg_left pull-left">                            
                                      <input type="radio" class="regular-checkbox" id="radio-4" name="default_address" value="1" <?php if($member_details->address==$address->id) {echo  'checked="checked"';} ?>>
                                      <label for="radio-4">Yes</label>
                                  </div>
                                  <!-- <div class="check_box_tab marg_left pull-left">                            
                                      <input type="radio" class="regular-checkbox" id="radio-5" name="default_address" value="0" <?php if($member_details->address!=$address->id) {echo  'checked="checked"';} ?>>
                                      <label for="radio-5">No</label>
                                  </div> -->
                              </div>
                          <?php } ?>
                         
                                                   
                        
                       
                        </div>  
                        </div>
                        </div>
                        
                    </div>
                    
                    <div class="form_bottom_panel">
                    <!--<a href="<?php echo url();?>/member-dashboard" class="green_btn pull-left"><i class="fa fa-angle-left"></i> Back to Dashboard</a>-->
                    <button type="submit" form="member_form" class="btn btn-default green_sub pull-right">Save</button>
                    </div>
                     {!! Form::close() !!}
               </div>
               
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
        
	        $("#state").html(data);
      }
    });

 } 
	    $(function() {

   

    // Setup form validation  //
    $("#member_form").validate({
    
        // Specify the validation rules
        rules: {
	
		
	    first_name: "required",
	    last_name: "required",
	    email: "required",
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
 @stop