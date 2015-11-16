 @extends('frontend/layout/frontend_template')
@section('content')

<div class="inner_page_container nomar_bottom">
    	   <!--my_acct_sec-->
           <div class="my_acct_sec">           
               <div class="container">
               
               <div class="col-sm-12 col-md-10 col-md-offset-1">
               
               <div class="row">
	      
	        {!! Form::open(['url' => 'brand-paydetails','method'=>'POST', 'files'=>true,  'id'=>'member_form']) !!}
		
               <div class="form_dashboardacct">
               		<h3>Payment Information</h3>
                    <div class="bottom_dash clearfix">
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
                        <div class="row">
			
			 <h5 class="col-sm-offset-4 col-md-offset-3">Routing / Account</h5>
			    <div class="col-sm-4 col-md-3">
			    <div class="check_box_tab">                            
			      <input type="radio" class="regular-checkbox" id="radio-1" name="default_band_preference" value="0" <?php if($brand_details['default_band_preference']==0) echo 'checked="checked"';?>>
			      <label for="radio-1"> Choose Account</label>
			    </div>
			    </div>
			    <div class="col-sm-8 col-md-9">
			    <div class="form-group">
				{!! Form::text('bank_name',$brand_details['bank_name'],['class'=>'form-control address-group','id'=>'bank_name','placeholder'=>'Bank Name', 'aria-describedby'=>'basic-addon2'])!!}
			    </div>
			    
			    <div class="form-group">
				{!! Form::text('routing_number',$brand_details['routing_number'],['class'=>'form-control address-group','id'=>'routing_number','placeholder'=>'Routing Number', 'aria-describedby'=>'basic-addon2'])!!}
			    </div>
			    <div class="form-group">
				{!! Form::text('account_number',$brand_details['account_number'],['class'=>'form-control address-group','id'=>'account_number','placeholder'=>'Account Number', 'aria-describedby'=>'basic-addon2'])!!}
			    </div>
			    </div>
			    
			    <h5 class="col-sm-offset-4 col-md-offset-3">Paypal Information</h5>
			    <div class="col-sm-4 col-md-3">
			    <div class="check_box_tab">                            
			      <input type="radio" class="regular-checkbox" id="radio-2" name="default_band_preference" value="1" <?php if($brand_details['default_band_preference']==1) echo 'checked="checked"';?>>
			      <label for="radio-2"> Choose Paypal</label>
			    </div>
			    </div>
			    <div class="col-sm-8 col-md-9">
			    <div class="form-group">
				 {!! Form::text('paypal_email',$brand_details['paypal_email'],['class'=>'form-control address-group','id'=>'paypal_email','placeholder'=>'Paypal email', 'aria-describedby'=>'basic-addon2'])!!}
			    </div>
			    
			    </div>
			    
			    <h5 class="col-sm-offset-4 col-md-offset-3">Check Information</h5>
			    <div class="col-sm-4 col-md-3">
			    <div class="check_box_tab">                            
			      <input type="radio" class="regular-checkbox" id="radio-3" name="default_band_preference" value="2" <?php if($brand_details['default_band_preference']==2) echo 'checked="checked"';?>>
			      <label for="radio-3">Check</label>
			    </div>
			    </div>
			    <div class="col-sm-8 col-md-9">
			    <div class="row">
			    <div class="form-group col-sm-6">
				{!! Form::text('mailing_name',$brand_details['mailing_name'],['class'=>'form-control','id'=>'mailing_name','placeholder'=>'First Name'])!!}
			    </div>
			<div class="form-group col-sm-6">
				{!! Form::text('mailing_lastname',$brand_details['mailing_lastname'],['class'=>'form-control','id'=>'mailing_lastname','placeholder'=>'Last Name'])!!}
			    </div>
			    <div class="form-group col-sm-6">
				{!! Form::text('mailing_address',$brand_details['mailing_address'],['class'=>'form-control','id'=>'mailing_address','placeholder'=>'Address 1'])!!}
			    </div>
				<div class="form-group col-sm-6">
				 {!! Form::text('mailing_address2',$brand_details['mailing_address2'],['class'=>'form-control','id'=>'mailing_address2','placeholder'=>'Address 2'])!!}
			    </div>
				
			    <div class="form-group col-sm-6">
				   {!! Form::select('mailing_country_id', array('' => 'Please select country') +$alldata,$brand_details['mailing_country_id'], array('id' => 'mailing_country_id','class'=>'form-control','onchange' => 'getState(this.value,"mail")')); !!}                        
			    </div>
			    <div class="form-group col-sm-6">
				{!! Form::select('mailing_state', array('' => 'Please select state') +$allstates,$brand_details['mailing_state'], array('id' => 'mailing_state','class'=>'form-control')); !!}
			    </div>
			   
			    <div class="form-group col-sm-6">
				 {!! Form::text('mailing_city',$brand_details['mailing_city'],['class'=>'form-control','id'=>'mailing_city','placeholder'=>'City'])!!}
			    </div>
			    <div class="form-group col-sm-6">
				 {!! Form::text('mailing_postcode',$brand_details['mailing_postcode'],['class'=>'form-control','id'=>'mailing_postcode','placeholder'=>'Post Code'])!!}
			    </div>
			    
			    
			    </div>
			    
			    </div>
			    
                        
                         </div>
                        
                    </div>
                    
                    <div class="form_bottom_panel">
                    <a href="<?php echo url();?>/brand-dashboard" class="green_btn pull-left"><i class="fa fa-angle-left"></i> Back to Dashboard</a>
                    <button type="submit" form="member_form" class="btn btn-default green_sub pull-right">Save</button>
                    </div>
                    
               </div>
               
               {!! Form::close() !!} 
	       </div>
               
               </div>
               
               </div>           
           </div>
           <!--my_acct_sec ends-->
 </div>
<script>
 function getState(country_id,param)
 {
    //alert("country= "+country_id);
    $.ajax({
      url: '<?php echo url();?>/getState',
      method: "POST",
      data: { countryId : country_id ,_token: '{!! csrf_token() !!}'},
      success:function(data)
      {
        //alert(data);
		if(param=="card")
	        $("#card_state").html(data);
		else if (param=='mail') {
		    $("#mailing_state").html(data)
		}else
	        $("#state").html(data);
      }
    });

 }
  
  // When the browser is ready...
  $(function() {

   

    // Setup form validation  //
    $("#member_form").validate({
    
        // Specify the validation rules
        rules: {
	
		routing_number: {
	      require_from_group: [1, ".address-group"]
		},
	      paypal_email: "required",
	      mailing_address: {
		require_from_group: [1, ".address-group"]
	      },
	      
	    mailing_name: "required",
	    mailing_address: "required",
	    mailing_country_id: "required",
	    mailing_city: "required",
	  
	    mailing_state: "required",
	    mailing_postcode: "required",
      
      
      
            
     },
		
        submitHandler: function(form) {
            form.submit();
        }
    });


  });
  
  
    
</script>
@stop