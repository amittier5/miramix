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
               
               <div class="col-sm-6 col-sm-offset-3">
               
               <div class="row">
	      
	      {!! Form::open(array('url' => 'member-changepass','method'=>'POST','id' =>'change_mem_form')) !!}
		
               <div class="form_dashboardacct">
               		<h3>Change Password</h3>
                    <div class="bottom_dash clearfix">
                    	<div class="row">
			 @if(Session::has('error'))
			    <div class="alert alert-danger container-fluid">
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
                              <div class="col-sm-12">
			    <div class="row">
                            
			    <?php if(!empty($member_details['password'])){ ?>
                            <div class="form-group col-sm-12">
				 {!! Form::password('old_password',array('class'=>'form-control','id'=>'old_password','placeholder'=>'Old Password')) !!}
                                
			    </div>
                            <?php }?>
			    <div class="form-group col-sm-12">
				 {!! Form::password('password',array('class'=>'form-control','id'=>'password','placeholder'=>'New Password')) !!}
                                
			    </div>
				
			    <div class="form-group col-sm-12">
				{!! Form::password('conf_pass',array('class'=>'form-control', 'id'=>'conf_pass','placeholder'=>'Confirm Password')) !!}
                                
			    </div>
			 
			    </div>
			    
			    </div>
                        </div>
                        
                    </div>
                    
                    <div class="form_bottom_panel">
                    <!--<a href="<?php echo url();?>/member-dashboard" class="green_btn pull-left"><i class="fa fa-angle-left"></i> Back to Dashboard</a>-->
                    <button type="submit" form="change_mem_form" class="btn btn-default green_sub pull-right">Update</button>
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
  
  // When the browser is ready...
  $( document ).ready(function(){

    $.validator.addMethod("notequalto", function(value, element, param) {
     return this.optional(element) || value != $(param).val();
    }, "Password and Old Password should not match...");


    $("#change_mem_form").validate({

       rules: {
                old_password: "required",
                password: {
                            required: true,
                            minlength:6,
                            notequalto:"#old_password"
                        },
                conf_pass: {
                  equalTo: "#password"
                }
            },
            messages: {
                old_password: "Please enter old password",
                password: {
                        required:"Please enter current password",
                        minlength:"Please enter minimum 6 character"
                },
               conf_pass: "Please enter the same value again"
      }

        
    });

  });
  
</script>
@stop
