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
       <div class="col-sm-12">
         <div class="row">
           <div class="form_dashboardacct">
              <h3>Order History</h3>
                <div class="row">
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
			 </div>
            <div class="table-responsive">
              <table class="table special_height">
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>No. of Products</th>
                  <th>Date Purchased</th>
                  <th>Total</th>
                  <th>Order Status</th>
                  <th>Tracking</th>
                  <th>Reorder</th>
                </tr>
              </thead>
              <tbody>
              @if($order_list->count()!=0)
                @foreach($order_list as $each_order_list)

                <tr>
                  <td>#{!! $each_order_list->order_number; !!}</td>
                  <td>{!! count($each_order_list->AllOrderItems); !!}</td>
                  <td>{!! date("M d, Y",strtotime($each_order_list->created_at)); !!}</td>
                  <td>$ {!! number_format($each_order_list->order_total,2); !!}</td>
                  <td><p class="status_btn">{!! $each_order_list->order_status; !!}</p></td>
                  <td><a href="{!! url()!!}/order-detail/{!! $each_order_list->id; !!}" class="btn btn-white">View Status</a></td>
                  <td><a href="javascript:void(0)" class="btn btn-white" onclick="reorderProduct('<?php echo $each_order_list->id;?>')">Reorder</a></td>
                </tr>
                @endforeach
              @else
              <tr>
                  <td colspan="6">No records found</td>
              </tr>
              @endif
              </tbody>
            </table>
            </div>
              {!! $order_list->render() !!}
            <div class="form_bottom_panel">
              <a href="member-dashboard" class="green_btn pull-left"><i class="fa fa-angle-left"></i> Back to Dashboard</a>
            </div>
                
           </div>
         </div>
       
       </div>
     
     </div>           
   </div>
   <!--my_acct_sec ends-->
 </div>

 <script>

 function reorderProduct(order_id)
 {
    $.ajax({
    url: '<?php echo url();?>/reorder',
    type: "post",
    data: { order_id : order_id ,_token: '{!! csrf_token() !!}'},
    success:function(data)
        {
          //alert(data);
          if(data !='' ) // email exist already
          {
            $("#cart_det").html(data);
            $("#cart_det").effect( "shake", {times:4}, 1000 );
          }
          
        }
  });
 }
 </script>
@stop
