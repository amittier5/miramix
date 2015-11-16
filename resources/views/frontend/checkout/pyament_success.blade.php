@extends('frontend/layout/frontend_template')
@section('content')

<div class="inner_page_container">
    	<div class="header_panel">
        	<div class="container">
        	 <h2>Payment Success</h2>
            </div>
        </div> 

    <div class="products_panel">
	<div class="container">
  <p>Your Order Has Been Received Successfully</p>
  <p>Thank you For Your Purchase!</p>
  <p>Your Order Id is <a href="<?php url();?>/order-detail/{!! Session::put('order_id') !!}">{!! Session::put('order_number') !!}</a> </p>
  <p>You will receive an order confirmation email with details of your order.</p>
	</div>
	</div>

</div>



@stop