@extends('frontend/layout/frontend_template')
@section('content')

<div class="inner_page_container">
    	<div class="header_panel">
        	<div class="container">
        	 <h2>Brands</h2>
             <!-- <ul class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Brands</a></li>
                <li>Health Takes Guts</li>
             </ul> -->
            </div>
        </div>   
<!-- Start Products panel -->
<div class="products_panel">
	<div class="container">
    
    <!--steps_main-->
    <div class="steps_main text-center">
    <ul>
    <li class="done"><span>&#10003;</span><h6>Checkout Option</h6></li>
    <li class="done"><span>&#10003;</span><h6>Payment Method</h6></li>
    <li class="done"><span>&#10003;</span><h6>Shipping Details</h6></li>
    <li class="active"><span>4</span><h6>Confirm Order</h6></li>
    </ul>
    </div>
    <!--steps_main-->
    
    <div class="col-sm-12">
    <div class="row">
    {!! Form::open(['url' => 'checkout-step4','method'=>'POST', 'files'=>true,'class'=>'form-horizontal row-fluid','id'=>'checkout_form']) !!}
    <div class="checkout_cont clearfix nopad_bot">
    <h5>Step 4 :  Confirm Order</h5>
    
    
    <div class="table-responsive table_ship_checkout">
    <table class="table">
    <thead>
    <tr>
    <th>Product Name</th>
    <th>Brand</th>
    <th>Form Factor Name</th>
    <th>Duration</th>
    <th>Quantity</th>
    <th>Unit Price</th>
    <th>Total</th>
  </tr>
    </thead>
      <tbody>
        <?php
          $all_sub_total =0.00;
          $all_total =0.00;
          $total =0.00;
          if(!empty($cart_result))
          { 
            $i=1;
            foreach($cart_result as $eachcart)
            {
              $all_sub_total = $all_sub_total+$eachcart['subtotal'];
              $all_total = number_format((int)$all_sub_total,2);
              $total = (int)$all_sub_total;                     // Without Adding Shipping Price
        ?>
          
          <tr>
            <td><a href="<?php echo url();?>/product-details/{!! $eachcart['product_slug'] !!}">{!! ucwords($eachcart['product_name']) !!}</a></td>
            <td>{!! $eachcart['brand_name'] !!}</td>
            <td>{!! $eachcart['formfactor_name'] !!}</td>
            <td>{!! $eachcart['duration'] !!}</td>
            <td><input type="text" class="form-control spec_width" value="<?php echo $eachcart['qty']; ?>" readonly></td>
            <td>$ {!! number_format($eachcart['price'],2) !!}</td>
            <td>$ {!! number_format($eachcart['subtotal'],2) !!}</td>
          </tr>
        <?php 
         $i++;
         }
        }

        ?>
      
      <tr>
      <td colspan="5"></td>
      <td class="text-left">
      <span>Sub-Total:</span>
      </td>
      <td class="text-right">
      <span>{!! ($all_total!='')?'$':'' !!}{!!  $all_total !!}</span>
      </td>
      </tr>
      <tr>
      <td colspan="5"></td>
      <td class="text-left">
      <span>Shipping Rate:</span>
      </td>
      <td class="text-right">
      <span>{!! ($shipping_rate!='')?'$':'' !!}{!! number_format($shipping_rate,2) !!}</span>
      </td>
      </tr>
      <tr>
      <td colspan="5"></td>
      <td class="text-left">
      <span>Total:</span>
      </td>
      <td class="text-right">
      <span>{!! ($total!='')?'$':'' !!}{!! number_format(($total+$shipping_rate),2) !!}</span>
      </td>
      </tr>
    </tbody>
  </table>
  </div>
    
    
    </div>
    
    <div class="form_bottom_part clearfix">
    <?php if(Session::get('payment_method') =='creditcard')
    {
    ?>
    <h4>Card Details</h4>
    
    <div class="row">
      <div class="row">
      <div class="form-group col-sm-6">
        <label class="col-sm-4">Card Type:</label>
        <div class="col-sm-8">
        <select class="form-control" name="card_type">
          <option value="visa">Visa</option>
          <option value="mastercard">MasterCard</option>
          <option value="amex">American Express</option>
        </select>
        </div>
      </div>
      <div class="form-group col-sm-6">
        <label class="col-sm-4">Card Number:</label>
        <div class="col-sm-8"><input type="password" class="form-control" placeholder="Card Number" name="card_number"></div>
      </div>
      <div class="form-group col-sm-6">
        <label class="col-sm-4">Card Expiry Date:</label>
        <div class="col-sm-8">
        <div class="row">
        <div class="col-sm-6">
        <select class="form-control" name="card_exp_month">
          
          <option value="">Month</option>
          <?php for($i=1;$i<=12;$i++) {?>
          <option value="<?php echo sprintf('%02d', $i)?>"><?php echo sprintf('%02d', $i);?></option>
          <?php } ?>
		 
        </select>
        </div>
        
        <div class="col-sm-6">
        <select class="form-control" name="card_exp_year">
          <option value="">Year</option>
          <?php for($i=15;$i<50;$i++) {?>
          <option value="<?php echo $i;?>"><?php echo $i;?></option>
          <?php } ?>
        </select>
        </div>
        </div>
        </div>
      </div>
      <div class="form-group col-sm-6">
        <label class="col-sm-4">Card Security Code:</label>
        <div class="col-sm-8">
        <input type="text" class="form-control" placeholder="Card Security Code (CVV)" name="cvv">
        </div>
      </div>
      </div>
      </div>
      
      <input type="submit" class="full_green_btn text-uppercase pull-right" value="Continue">
    <?php 
    } 
    elseif(Session::get('payment_method') =='paypal')
    {
    ?>
        <img src="<?php echo url();?>/public/frontend/images/shopping-checkout/paypal_shp.png" alt="">
        <input type="submit" class="full_green_btn text-uppercase no_topmarg pull-right" value="Continue">
    <?php 
    }
    ?>
    <!--###################### HIDDEN FIELD TO INSERT ORDER TABLE START ###############################-->
    <input name="grand_total" type="hidden" value="{!! ($total+$shipping_rate) !!}">
    <input name="sub_total" type="hidden" value="{!! ($total) !!}">
    <!--##################### HIDDEN FIELD TO INSERT ORDER TABLE END ##################################-->
    </div>

    {!! Form::close() !!} 
    
    </div>
    </div>
    
    </div>
</div>
<!-- End Products panel --> 
 </div>
 @stop