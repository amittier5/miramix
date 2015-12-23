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
         <div class="row">
           <div class="form_dashboardacct">
              <h3>Order History</h3>
                <div class="row">
			 
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
                  <td><a href="javascript:void(0)" class="btn btn-white reord_prod" onclick="reorderProduct('<?php echo $each_order_list->id;?>',this)">Reorder<span class="no_dis_orig"><i class="fa fa-check"></i>Product Added</span></a></td>
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

 function reorderProduct(order_id,el)
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
            /*$("#cart_det").html(data);
            $("#cart_det").effect( "shake", {times:4}, 1000 );*/
			
			//for add to cart animation
			   var foroffset_calc=$(el); 
			   if($(window).width()>767)
				var cart = $('.navbar-default .navbar-nav > li.cart');
			   else
			    var cart = $('#formob_only');	
				var imgtodrag = $(el).parent().parent().find('td:first-child');
				console.log(imgtodrag.length);
				if (imgtodrag.length>0) {
					var imgclone = imgtodrag.clone()
						.offset({
						top: foroffset_calc.offset().top,
						left: foroffset_calc.offset().left
					})
						.css({
						'opacity': '0.5',
							'position': 'absolute',
							'height': '40px',
							'width': '150px',
							'z-index': '9999999999',
							'background':'#fff',
							'color':'#000',
							'text-align':'center',
							'line-height':'40px',
							'border-radius':'4px'
					})
						.appendTo($('body'))
						.animate({
						'top': cart.offset().top + 10,
							'left': cart.offset().left + 10,
							'width': 75,
							'height': 75
					}, 1000, 'easeInOutExpo');
					
					
					imgclone.animate({
						'width': 0,
							'height': 0
					}, function () {
						$(this).detach()
					});
				}
				setTimeout(function(){
					//$("#cart_det").show();
			  		//$("#cart_mob_det").show();	
				},1100)
				setTimeout(function(){
					$(el).find('.no_dis_orig').animate({'left':0});
					$('.reord_prod').prop('disabled',true);
					
				},600);		
				setTimeout(function(){
					$(el).find('.no_dis_orig').animate({'left':100+'%'});
					$('.reord_prod').prop('disabled',false);
					
				},4000);
			   //for add to cart animation
			
          }
          
        }
  });
 }
 </script>
@stop
