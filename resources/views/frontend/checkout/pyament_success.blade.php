@extends('frontend/layout/frontend_template')
@section('content')

<div class="inner_page_container">
    	<div class="header_panel">
        	<div class="container">
        	 <h2>Payment Success</h2>
            </div>
        </div> 

    <div class="products_panel no_marg">
	<div class="container">
  <div class="product_list shop_cart">
  <div class="col-xs-12 text-center noprod_cart">
  <img src="<?php echo url();?>/public/frontend/images/paypent-success.png" alt="">
  <p class="empt_shpcart">Your Order Has Been Received Successfully<br>
  Thank you For Your Purchase!<br>
  Your Order Id is #<a href="<?php url();?>/order-detail/{!! Session::get('order_id') !!}">{!! Session::get('order_number') !!}</a><br> 
  You will receive an order confirmation email with details of your order.</p>
  </div>
  </div>
	</div>
	</div>

</div>



@stop