 @extends('frontend/layout/frontend_template')
@section('content')

<div class="inner_page_container nomar_bottom">

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
                  <h3>My Address</h3>
                    
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
                  
                  
                    <div class="bottom_dash clearfix">
                      
                        <div class="row">
                        <h5 class="text-center">Your addresses are listed below</h5>
                        <?php foreach ($address as $adata){ ?>
                        <div class="col-sm-4">
                        <div class="box_edit_address">
                        <p><?php echo $adata->first_name?> <?php echo $adata->last_name?><br>
                        <?php echo $adata->email?><br>
                        <?php echo $adata->address?><br>
                        <?php echo $adata->city?>, <?php  echo $obj->get_state($adata->zone_id)?><br>
                        <?php echo $obj->get_country($adata->country_id)?>
                         
                        </p>
                        <div class="btn-group">
                        <a href="<?php echo url();?>/edit-member-shipping-address?id=<?php echo $adata->id?>" class="btn btn-small-green pull-left"><i class="fa fa-pencil-square-o"></i>Edit</a>
                        <?php if($member_details->address!=$adata->id){ ?>
                        <a href="javascript:void(0)" onclick="Deladdress('<?php echo url();?>/delete-member-shipping-address?id=<?php echo $adata->id?>')" class="btn btn-small-red pull-right"><i class="fa fa-times"></i>Delete</a>
                            
                        <?php }?>
                        </div> 
                        </div>
                        </div>
                        
                        <?php }?>
                        
                     
                        
                        </div>
                        
                    </div>
                    
                    <div class="form_bottom_panel">
                    <a href="<?php echo url();?>/member-dashboard" class="green_btn pull-left"><i class="fa fa-angle-left"></i> Back to Dashboard</a>
                    <a href="<?php echo url();?>/create-member-shipping-address" class="green_sub text-center pull-right"><i class="fa fa-plus-circle"></i>New Address</a> 
                    </div>
                    
               </div>
               
               </div>
               
               </div>
               
               </div>           
           </div>
           <!--my_acct_sec ends-->
 </div>
    
    <script>
        function Deladdress(url){
            
            var a =confirm("Are you sure to delete this address");
            
            if (a){
               location.href=url;
            }
        }
        
    </script>
 @stop