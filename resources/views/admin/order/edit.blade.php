@extends('admin/layout/admin_template')

@section('content')


<script>
  
  // When the browser is ready...
  $(function() {
 
    $("#form_order").validate({
        
        ignore: [],
        // Specify the validation rules
        rules: {
            order_status: "required",
           
        },
        
        // Specify the validation error messages
        messages: {
            order_status: "Please enter valid status.",
         
        },               

        submitHandler: function(form) {
            form.submit();
        }
    });


  });
  
  </script>
    
   {!! Form::model($orders,array('method' => 'PATCH','id'=>'form_order','name'=>'form_order','class'=>'form-horizontal row-fluid','route'=>array('admin.orders.update',$orders->id))) !!}

    <div class="control-group">
          <label class="control-label" for="basicinput">Order Status: *</label>
          <div class="controls">
               
	  <select name="order_status" id="order_status">
		  <option value="">Select</option>
		  <option value="pending" <?php if($orders->order_status=='pending'){ echo 'selected="selected"';}?>>Pending</option>
		  <option value="processing" <?php if($orders->order_status=='processing'){ echo 'selected="selected"';}?>>Processing</option>	
		  <option value="fraud" <?php if($orders->order_status=='fraud'){ echo 'selected="selected"';}?>>Fraud</option>
		  <option value="shipped" <?php if($orders->order_status=='shipped'){ echo 'selected="selected"';}?>>Shipped</option>
		  <option value="completed" <?php if($orders->order_status=='completed'){ echo 'selected="selected"';}?>>Completed</option>
		  <option value="cancel" <?php if($orders->order_status=='cancel'){ echo 'selected="selected"';}?>>Cancel</option>	
		</select>
	       &nbsp;&nbsp;
		
          </div>
        </div>

      <!-- <div class="control-group" id="shipping_address">
          <label class="control-label" for="basicinput">Shipping Address:</label>
          <div class="controls"> -->
         <?php  
         //$shipping_address = unserialize($orders->shiping_address_serialize); 

         // foreach($shipping_address as $key=>$value)
         // {
         //  if($key == 'mem_brand_id' || $key == 'address_title')
         //  {
         //    continue;
         //  }
         //  if($key=='country_id')
         //    $key='Country';
         //  if($key=='zone_id')
         //    $key='State';
         //  if($key=='first_name')
         //    $key='First Name';
         //  if($key=='last_name')
         //    $key='Last Name';
         //  if($key=='email')
         //    $key='Email';
         //  if($key=='phone')
         //    $key='Phone Number';
         //  if($key=='address')
         //    $key='Address';
         //  if($key=='address2')
         //    $key='Address2';
         //  if($key=='city')
         //    $key='City';
         //  if($key=='postcode')
         //    $key='Postcode';

         //    echo $key.' : '.$value.'<br/>';
         // }
         ?>
          <!-- </div>
      </div>   -->


      <div class="control-group" id="tracking" <?php if($orders->order_status!='shipped'){ ?>style="display:none;" <?php }?>>
          <label class="control-label" for="basicinput">Tracking Number:</label>
          <div class="controls">
	       {!! Form::text('tracking_number',$orders->tracking_number,['id'=>'tracking_number','placeholder'=>'Tracking Number','class'=>'span8'])!!}
          </div>
      </div>  

      <div class="control-group" id="shipping_carrier" <?php if($orders->order_status!='shipped'){ ?>style="display:none;" <?php }?>>
          <label class="control-label" for="basicinput">Shipping Carrier:</label>
          <div class="controls">
         {!! Form::text('shipping_carrier',$orders->shipping_carrier,['id'=>'shipping_carrier','placeholder'=>'Shipping Carrier','class'=>'span8'])!!}
          </div>
      </div>   


    <div class="form-group">
        {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
    
    <script>
      $("#order_status").change(function(){
	var stat=$(this).val();
	if (stat=='shipped'){
	  $("#tracking").show();
    $("#shipping_carrier").show();
	}else{
	   $("#tracking").hide();
     $("#shipping_carrier").hide();
	}
	
	});
      
    </script>
@stop


