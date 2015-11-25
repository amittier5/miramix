@extends('frontend/layout/frontend_template')
@section('content')
  <div class="inner_page_container nomar_bottom">
    	   <!--my_acct_sec-->
           <div class="my_acct_sec">           
               <div class="container">
               
               <div class="col-sm-10 col-sm-offset-1">
               
               <div class="row"><div class="form_dashboardacct">
               		<h3>Subscription History</h3>
                    
                    <div class="table-responsive">
                    <table class="table special_height">
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
                    <a href="<?php echo url();?>/brand-dashboard" class="green_btn pull-left"><i class="fa fa-angle-left"></i> Back to Dashboard</a>
                   
                    </div>
                    
               </div>
               
               </div>
               
               </div>
               
               </div>           
           </div>
           <!--my_acct_sec ends-->
 </div>


 @stop