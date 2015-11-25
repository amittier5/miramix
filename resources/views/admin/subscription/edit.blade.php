@extends('admin/layout/admin_template')

@section('content')
    <script type="text/javascript">

   // var dateToday = new Date();
   //  $(function() {
   //      $( "#dob" ).datepicker({
   //  startDate: dateToday,
   //      dateFormat: "yy-mm-dd",
   //   });

   //      $( "#utopia-dashboard-datepicker" ).datepicker().css({marginBottom:'20px'});

   //      $(".chzn-select").chosen(); $(".chzn-select-deselect").chosen({allow_single_deselect:true});

       
        
   //  });

</script>

<script>
  
  // When the browser is ready...
  $(function() {
 
    $("#form_brand").validate({
        
        ignore: [],
        // Specify the validation rules
        rules: {
            fname: "required",
            lname: "required",
            email: {
                      required: true,
                      email: true
                    },
            gender: "required",
            dob: "required",
           
            phone_no: 
                    {
                      phoneUS: true,
                      required: true
                    }
            
        },
        
        // Specify the validation error messages
        messages: {
            fname: "Please enter first name.",
            lname: "Please enter last name.",
            email: "Please enter valid email address.",
            gender: "Please choose gender.",
            dob: "Please enter date of birth.",
            phone_no: "Please enter valid phone number."
        },               

        submitHandler: function(form) {
            form.submit();
        }
    });

$( "#dob" ).datepicker({
                changeYear: true,
                yearRange: '1920:2015', 
                maxDate: <?php echo date('y/m/d')?>, 
                dateFormat: 'yy-mm-dd'
            });
  });
  
  </script>
    
   {!! Form::model($subscription,array('method' => 'PATCH','id'=>'form_subscription','files'=>true,'name'=>'form_subscription','class'=>'form-horizontal row-fluid','route'=>array('admin.subscription.update',$subscription->subscription_id))) !!}

    <div class="control-group">
          <label class="control-label" for="basicinput">Member Id </label>
          <div class="controls">
               {!! Form::text('member_id',null,['class'=>'span8','id'=>'member_id']) !!}
          </div>
        </div>
    
    <div class="control-group">
          <label class="control-label" for="basicinput">Subscription Start Date *</label>
          <div class="controls">
               {!! Form::text('start_date',null,['class'=>'span8','id'=>'start_date']) !!}
          </div>
        </div>
    
    
        <div class="control-group">
          <label class="control-label" for="basicinput">Subscription End Date *</label>
          <div class="controls">
               {!! Form::text('end_date',null,['class'=>'span8','id'=>'end_date']) !!}
          </div>
        </div>
     
        <div class="control-group">
            <label class="control-label" for="basicinput">Total Fee</label>
            <div class="controls">
                 {!! Form::text('subscription_fee',null,['class'=>'span8','id'=>'subscription_fee']) !!}
            </div>
        </div>
	    
	<div class="control-group">
            <label class="control-label" for="basicinput">Pay Status</label>
            <div class="controls">
                {!! Form::text('payment_status',null,['class'=>'span8','id'=>'payment_status']) !!}
            </div>
        </div>
	    
	<div class="control-group">
            <label class="control-label" for="basicinput">Transaction ID</label>
            <div class="controls">
                <?php echo $subscription->transaction_id ?>
            </div>
        </div>
 
    
    
    <div class="form-group">
        {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
@stop


