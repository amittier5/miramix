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
               
               <div class="col-sm-10 col-sm-offset-1">
               
               <div class="row"><div class="form_dashboardacct">
                  <h3>My Address</h3>
                    
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
                  
                  
                    <div class="bottom_dash clearfix">
                      
                        <div class="row">
                        <h5 class="text-center">Your addresses are listed below</h5>
                        <?php foreach ($address as $adata){ ?>
                        <div class="col-sm-4">
                        <div class="box_edit_address">
                        <p>
                        <?php echo $adata->address_title?><br>
                        <?php echo $adata->first_name?> <?php echo $adata->last_name?><br>
                        
                        <?php echo $adata->address?><br>
                        <?php echo $adata->city?>, <?php  echo $obj->get_state($adata->zone_id)?><br>
                        <?php echo $obj->get_country($adata->country_id)?>
                         
                        </p>
                        <div class="btn-group">
                        <a href="<?php echo url();?>/edit-brand-shipping-address?id=<?php echo $adata->id?>" class="btn btn-small-green pull-left"><i class="fa fa-pencil-square-o"></i>Edit</a>
                        <?php if($brand_details->address!=$adata->id){ ?>
                        <a href="javascript:void(0)" onclick="Deladdress('<?php echo url();?>/delete-brand-shipping-address?id=<?php echo $adata->id?>')" class="btn btn-small-red pull-right"><i class="fa fa-times"></i>Delete</a>
                            
                        <?php }?>
                        </div> 
                        </div>
                        </div>
                        
                        <?php }?>
                        
                     
                        
                        </div>
                        
                    </div>
                    
                    <div class="form_bottom_panel">
                    <a href="<?php echo url();?>/brand-dashboard" class="green_btn pull-left"><i class="fa fa-angle-left"></i> Back to Dashboard</a>
                    <a href="<?php echo url();?>/create-brand-shipping-address" class="green_sub text-center pull-right"><i class="fa fa-plus-circle"></i>New Address</a> 
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