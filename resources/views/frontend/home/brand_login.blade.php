 @extends('frontend/layout/frontend_template')
@section('content')

<script>
  
  // When the browser is ready...
  $(function() {
  
   $.validator.addMethod("email", function(value, element) 
      { 
      return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value); 
      }, "Please enter a valid email address.");

    // Setup form validation  //

    $("#brand_login").validate({
        // Specify the validation rules
        rules: {            
            email: 
            {
                required : true,
                email: true
            },
            password: "required"            
        },
        
        // Specify the validation error messages
        messages: {
            email: {
               required: "Please enter email id",
               email : "Please enter a valid email address."
            },
            price: "Please enter password"
        },
        
        submitHandler: function(form) {
            form.submit();
        }
    });

  });
  
</script>
    
     <!--for login page-->
    <div class="brand_login">
    	
        <!--login_cont-->
        <div class="login_cont">
            <div class="log_inner text-center">
                <h2 class="wow fadeInDown">Login to your Brand</h2>
                  @if(Session::has('error'))
                    <div class="alert alert-danger container">
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
                <div class="log_btnblock md15">
               <a href="{!!URL::to('facebook')!!}"><img src="<?php echo url();?>/public/frontend/images/log_fb.png" alt=""></a>
               <a href="{!!URL::to('google')!!}"><img src="<?php echo url();?>/public/frontend/images/log_google.png" alt=""></a>
                </div>
                <!--<img src="<?php echo url();?>/public/frontend/images/or.png" alt="">-->

                {!! Form::open(['url' => 'brandLogin','method'=>'POST', 'id'=>'brand_login','files'=>true]) !!}
                <div class="tot_formlog clearfix">
                    <div class="input-group wow slideInLeft md15">
                      <!--<input type="text" class="form-control" placeholder="email" aria-describedby="basic-addon2" id="email">-->
                      
                        {!! Form::text('email',$brand_email,['class'=>'form-control','id'=>'email','aria-describedby'=>'basic-addon2','placeholder'=>'email']) !!}
                      <span class="input-group-addon glyphicon glyphicon-user" id="basic-addon2"></span>
                    </div>
                    <div class="input-group wow slideInRight md30">
                      <!--<input type="password" class="form-control" placeholder="password" aria-describedby="basic-addon3" id="password">-->
                    {!! Form::password('password',['class'=>'form-control','id'=>'password','aria-describedby'=>'basic-addon3','placeholder'=>'password']) !!}
                      <span class="input-group-addon glyphicon glyphicon-lock" id="basic-addon3"></span>
                    </div>
                    <div class="wow fadeInLeft checkbox pull-left">
                        <label><input type="checkbox" name="remember_me" id="remember_me" <?php if($brand_email!=""){ ?> checked <?php } ?> value="1">Keep me logged in!</label>
                    </div>
                    <a href="<?php echo url();?>/brand-forgot-password" class="wow fadeInRight btn-link pull-right">Forgot your password?</a>
                    <button type="submit" class="wow fadeInUp btn btn-default sub_btn">Submit</button>                    
                </div>
               {!! Form::close() !!}
                <p class="wow zoomInUp brand_p clearfix">Want a Brand Account? <a href="<?php echo url();?>/brandregister">Sign up now!</a></p>
            </div>
            <div class="container">
                <div class="total_mirslider"><div id="slider" class="miramix-slider" style="margin:50px"></div></div>
            </div>
        </div>
        <!--login_cont-->
        
    </div>
    <!--for login page-->
    <script src="<?php echo url();?>/public/frontend/js/jquery.ui.touch-punch.min.js"></script>
    <script>
  $(function() {
    var initialValue =0;
    var baseprice='<?php echo ($subfee->value)?>';
    var perproduct='<?php echo ($subprofee->value)?>';

var sliderTooltip = function(event, ui) {
    var curValue = ui.value || initialValue;
    var totalval=(parseInt(perproduct)*parseInt(curValue))+parseInt(baseprice);
    var tooltip = '<div class="tooltip"><div class="tooltip-header"></div><div class="tooltip-content"><h3 id="employee-amount-header">' + curValue + ' product(s)</h3><ul><li class="enterprise-pricing hidden">Contact us for enterprise pricing</li><li class="small-pricing undefined">$<span id="base-cost">'+baseprice+'</span> base price</li><li class="small-pricing undefined">$<span id="person-cost">'+perproduct+'</span>/product x <span id="base-employees">' + curValue + ' product(s)</span>=$<span id="totalval">'+totalval+'</span></li></ul></div></div>';

    $('.ui-slider-handle').html(tooltip);

}

$("#slider").slider({
    value: initialValue,
    min: 0,
    max: 500,
    step: 1,
	range: "min",
    create: sliderTooltip,
    slide: sliderTooltip
});
  });
  </script>
    
@stop