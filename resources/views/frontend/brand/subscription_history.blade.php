@extends('frontend/layout/frontend_template')
@section('content')

<script src="<?php echo url();?>/public/frontend/js/stacktable.js"></script>
<link href="<?php echo url();?>/public/frontend/css/stacktable.css" rel="stylesheet">

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
               		<h3>Subscription History</h3>
                    
                    <div class="table-responsive">
                    <table class="table special_height" id="subscribe_table">
                    <thead>
                      <tr>
                        <th>Subscription ID</th>
                        <th>Pay Status</th>
                        <th>Start Date</th>
			<th>End Date</th>
                        <th>Total Amount</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                     
                     <?php foreach($subscription as $sub){?>
                      <tr>
                        <td>#<?php echo $sub->subscription_id ?></td>
                        <td><?php echo $sub->payment_status ?></td>
                        <td><?php echo $sub->start_date ?></td>
                        <td><?php echo $sub->end_date ?></td>
			<td>$<?php echo $sub->subscription_fee+$sub->other_fee ?></td>
                      </tr>
                     <?php }?> 
                      
                    </tbody>
                  </table>
                  </div>
                    <div><?php echo $subscription->render() ?></div>
					<h5 class="subs_head">Subscription Status : <strong><?php echo $brand->subscription_status?></strong></h5>
                    <div class="form_bottom_panel">
                    <!--<a href="<?php echo url();?>/brand-dashboard" class="green_btn pull-left"><i class="fa fa-angle-left"></i> Back to Dashboard</a>-->
                   
                    </div>
                    
               </div>
               
               </div>
               
               </div>
               
               </div>           
           </div>
           <!--my_acct_sec ends-->
 </div>
<script>
$(document).ready(function(e) {
    $('#subscribe_table').stacktable({myClass:'brand-table-section'}); 
});
</script>

 @stop