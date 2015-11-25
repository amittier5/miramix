@extends('frontend/layout/frontend_template')
@section('content')

<div class="inner_page_container">
    	<div class="header_panel">
        	<div class="container">
        	  <h2>Payment Cancel</h2>
            
            </div>
        </div> 

    <div class="products_panel">
	<div class="container">
	  <div>Payment Canceled.</div>
       <p>
       @if(Session::has('success'))
                    <div class="alert alert-success container">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{!! Session::get('success') !!}</strong>
                    </div>
                @endif
                @if(Session::has('error'))
                <div class="alert alert-error container">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{!! Session::get('error') !!}</strong>
                </div>
              @endif
        </p>
        <p>
            Your Order Id #<a href="<?php echo url();?>/order-detail/{!! Session::get('order_id') !!}">{!! Session::get('order_number') !!}</a>  Is Canceled.
        </p>
	</div>
	</div>

</div>



@stop