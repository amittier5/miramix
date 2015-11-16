@extends('frontend/layout/frontend_template')
@section('content')

<!-- jQuery Form Validation code -->
  <script>
  
  // When the browser is ready...
  $(function() {

    $.validator.addMethod("email", function(value, element) 
    { 
    return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value); 
    }, "Please enter a valid email address.");

    // Setup form validation  //
    $("#checkout_form3").validate({
    
        // Specify the validation rules
        rules: {
            fname: "required",
            lname: "required",
            email: 
            {
                required : true,
                email: true
            },
            phone :
            {
                required : true,
                phoneUS: true
            },
            address: "required",
            country_id: "required",
            city: "required",
            zip_code: "required"
            
        },
        
        submitHandler: function(form) {
            form.submit();
        }
    });

  });
  
  </script>

 <div class="inner_page_container">
        <div class="header_panel">
            <div class="container">
             <h2>Brands</h2>
             <ul class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Brands</a></li>
                <li>Health Takes Guts</li>
             </ul>
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
    <li class="active"><span>3</span><h6>Shipping Details</h6></li>
    <li><span>4</span><h6>Confirm Order</h6></li>
    </ul>
    </div>
    <!--steps_main-->
    
    <div class="col-sm-12">
    <div class="row">
    <div class="checkout_cont check_3 clearfix">
    <h5>Step 3 :  Shipping Detail</h5>
   <?php // echo "w= ".Session::get('selected_address_id'); ?>
    <cite>Please select the mailing address you would like to have your item(s) delivered to.</cite>
    
    {!! Form::open(['url' => 'checkout-step3','method'=>'POST', 'files'=>true,'class'=>'form row-fluid','id'=>'checkout_form3']) !!}

    <div class="check_box_tab selectionbasedshow green_version">                            
         <input type="radio" class="regular-checkbox" id="radio-1" <?php echo (Session::has('selected_address_id'))?"checked=checked":"checked=checked" ?>name="RadioGroup1">
         <label for="radio-1">I want to use an existing address</label>
    </div>
    <div class="col-sm-12 clearfix show_hide" id="old_address">
    
    <div class="form-group">
    <select class="form-control" name="existing_address">
    <?php foreach($shipAddress as $eachAddress){
    $ship_fname = (($eachAddress->first_name) =='')?$eachAddress->fname:$eachAddress->first_name;
    $ship_lname = (($eachAddress->last_name) =='')?$eachAddress->lname:$eachAddress->last_name;
    //echo $ship_fname.$ship_lname; exit;
    if(Session::has('selected_address_id'))
    {
        $selected_address_id = Session::get('selected_address_id');
    }
    else 
    {
        if(($eachAddress->default_address)!='')
        {
            $selected_address_id = $eachAddress->default_address;
        }
    }
    ?>
    <option value="<?php echo $eachAddress->id;?>" <?php echo (($selected_address_id==$eachAddress->id)?"selected=selected":'')?>><?php echo $ship_fname.' '.$ship_lname.', '.$eachAddress->address.', '.$eachAddress->address2.', '.$eachAddress->country_name.', '.$eachAddress->zone_name ?>
    </option>
    <?php } ?>
      
    </select>
    </div>
    
    </div>
    <div class="check_box_tab selectionbasedshow green_version bot_clear">                            
         <input type="radio" class="regular-checkbox" id="radio-2" name="RadioGroup1">
         <label for="radio-2">I want to use a new shipping address</label>
    </div>
    <div class="col-sm-12 clearfix show_hide">
   
    <div class="row" id="new_address">
    <div class="form-group col-sm-6">
    <input type="text" class="form-control" placeholder="First Name" name="fname">
    </div>
    <div class="form-group col-sm-6">
    <input type="text" class="form-control" placeholder="Last Name" name="lname">
    </div>
    <div class="form-group col-sm-6">
    <input type="email" class="form-control" placeholder="Email" name="email">
    </div>
    <div class="form-group col-sm-6">
    <input type="text" class="form-control" placeholder="Phone" name="phone">
    </div>
    <div class="form-group col-sm-6">
    <input type="text" class="form-control" placeholder="Address 1" name="address">
    </div>
    <div class="form-group col-sm-6">
    <input type="text" class="form-control" placeholder="Address 2" name="address2">
    </div>
    <div class="form-group col-sm-6">
    <select  class="form-control" name="country_id" onchange ="getState(this.value)">
        <option value="">Please select country</option>
        <?php foreach($allcountry as $eachCountry)
        {
        ?>
        <option value="{!! $eachCountry->country_id !!}">{!! $eachCountry->name !!}</option>
        <?php   
        }  
        ?>
    </select>

    </div>
    <div class="form-group col-sm-6">
    <select class="form-control" name="state" id="state">
      <option value="">Please select state</option>
      
    </select>
    </div>
    <div class="form-group col-sm-6">
    <input type="text" class="form-control" placeholder="City" name="city" id="city">
    </div>
    <div class="form-group col-sm-6">
    <input type="text" class="form-control" placeholder="Post Code"  name="zip_code"  id="zip_code">
    </div>
    </div>
    <input type="hidden" value="existing" name="select_address" id="select_address">
    
    <input type="submit" class="full_green_btn text-uppercase pull-right" value="Continue">

    </div>
    {!! Form::close() !!}


    </div>
    </div>
    </div>
    
    </div>
</div>
<!-- End Products panel --> 
 </div>
 
 <script type="text/javascript">
 function getState(country_id)
 {
    //alert("country= "+country_id);
    $.ajax({
      url: '<?php echo url();?>/getState',
      method: "POST",
      data: { countryId : country_id ,_token: '{!! csrf_token() !!}'},
      success:function(data)
      {
        //alert(data);
        if(data!='')
        {
            $("#state").html(data);
        }
      }
    });

 }

</script>


 <script> 
  /* For Toggle the Shipping address  */
  $(document).ready(function(){

    $('#radio-1').click(function(){
    
        if ($(this).is(':checked'))
        {
          $('#radio-2').attr('checked',false);  
          $("#select_address").val('existing');
          $("#new_address").slideUp("slow");
          $("#old_address").slideDown("slow");
        }
    });
    $('#radio-2').click(function(){
        if ($(this).is(':checked'))
        {
          $('#radio-1').attr('checked',false);  
          $("#select_address").val('newaddress');
          $("#new_address").slideDown("slow");
          $("#old_address").slideUp("slow");
        }
    });
    
  });
</script>
<style>
    #new_address{display:none;}
</style>
@stop
