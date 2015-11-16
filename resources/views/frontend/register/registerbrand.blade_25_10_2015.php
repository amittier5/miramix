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
    $("#member_form").validate({
    
        // Specify the validation rules
        rules: {
			business_name:"required",
            fname: "required",
            lname: "required",
            email: 
            {
                required : true,
                email: true
            },
			phone_no :
            {
                required : true,
                phoneUS: true
            },
            password:
            {
                required : true,
                minlength:6 
            }, 
            con_password: {
                        required :true,
                      equalTo: "#password",
                  },
            
            address: "required",
            address2: "required",
           //country: "required",
           //state: "required",
           //city: "required",
            //postcode: 
//            {
//                required :true,
//                number: true,
//            },
			card_holder_name: "required",
			card_name: "required",
			expiry_month: "required",
			//expiry-year: "required",
			cvv: "required",
			card_shiping_name: "required",
			card_shiping_address: "required",
			card_country_id: "required",
			card_shiping_city: "required",
			card_shipping_phone_no: "required",
			card_shipping_address2: "required",
			card_state: "required",
			card_shipping_postcode: 
			{
                required :true,
                number: true,
            },
			
			shiping_fname: "required",
			shiping_address: "required",
			country: "required",
			city: "required",
			shipping_address2: "required",
			state: "required",
			shipping_postcode:
			{
                required :true,
                number: true,
            },
			
            agree: "required",
			government_issue: "required",
            
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
                <h2 class="wow fadeInDown">Sign Up</h2>
                <div class="log_btnblock md15">
                    <a href=""><img src="<?php echo url();?>/public/frontend/images/log_google.png" alt=""></a>
                    <a href=""><img src="<?php echo url();?>/public/frontend/images/log_fb.png" alt=""></a>                
                </div>
                <img src="<?php url();?>public/frontend/images/or.png" alt="">
                
        {!! Form::open(['url' => 'brandregister','method'=>'POST', 'files'=>true, 'id'=>'member_form']) !!}

                <div class="brand_login_panel">
                    <div class="row">
                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-8  wow fadeInDown"><h2 class="">Personal Information</h2></div>
                        <div class="col-sm-2">&nbsp;</div>
                    </div>
                    <div class="form_panel">
                      <div class="row signup_form_panel">                    
                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-4">
                            <div class="input-group wow slideInLeft md15">
                                {!! Form::text('business_name',null,['class'=>'form-control','placeholder'=>'Name / Business Name', 'aria-describedby'=>'basic-addon2'])!!}
                            </div>
                            <div class="input-group wow slideInRight md15">
                                {!! Form::text('fname',null,['class'=>'form-control','id'=>'fname','placeholder'=>'Executive in Charge First Name', 'aria-describedby'=>'basic-addon2'])!!}
                            </div>
                            <div class="input-group wow slideInRight md15">
                                {!! Form::password('password',['class'=>'form-control','id'=>'password','placeholder'=>'Password', 'aria-describedby'=>'basic-addon2'])!!}
                            </div>    
                            <div class="input-group wow slideInLeft md15">
                                {!! Form::text('phone_no',null,['class'=>'form-control','placeholder'=>'Phone Number', 'aria-describedby'=>'basic-addon2'])!!}
                            </div>                
                            
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group wow slideInRight md15">
                                {!! Form::text('email',null,['class'=>'form-control','id'=>'email','placeholder'=>'Email', 'aria-describedby'=>'basic-addon2','onblur' =>'emailChecking(this.value)'])!!}
                                 <label id="email_error" class="error">Email-Id is already exist.</label>
                            </div>
                            <div class="input-group wow slideInRight md15">
                                {!! Form::text('lname',null,['class'=>'form-control','id'=>'lname','placeholder'=>'Executive in Charge Last Name', 'aria-describedby'=>'basic-addon2'])!!}
                            </div>
                            <div class="input-group wow slideInRight md15">
                                {!! Form::password('con_password',['class'=>'form-control','id'=>'con_password','placeholder'=>'Confirm Password', 'aria-describedby'=>'basic-addon2'])!!}
                            </div> 
                            <div class="input-group wow slideInRight md15">
                                {!! Form::file('image',['class'=>'btn','id'=>'image','placeholder'=>'Issue Id'])!!}
                            </div>
                         </div>
                         <div class="col-sm-2">&nbsp;</div>                             

                        </div>
                      </div>
                	</div>
                <div class="brand_login_panel">
                    <div class="row">
                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-8  wow fadeInDown"><h2 class="">Banking Information</h2></div>
                        <div class="col-sm-2">&nbsp;</div>
                    </div>
                    <div class="form_panel">
                         <div class="row signup_form_panel">                    
                    <div class="col-sm-2">&nbsp;</div>
                    <div class="col-sm-4">
                        <div class="input-group wow slideInLeft md15">
                            {!! Form::text('routing_number',null,['class'=>'form-control','id'=>'routing','placeholder'=>'Routing / Account', 'aria-describedby'=>'basic-addon2'])!!}

                        </div>
                        <div class="input-group wow slideInRight md15">
                            <!-- <input type="text" class="form-control" placeholder="Paypal email" aria-describedby="basic-addon2"> -->
                            {!! Form::text('paypal_email',null,['class'=>'form-control','id'=>'paypal_email','placeholder'=>'Paypal email', 'aria-describedby'=>'basic-addon2'])!!}
                        </div>
                        <div class="input-group wow slideInRight md15">
                            {!! Form::textarea('mailing_address',null,['class'=>'form-control','id'=>'routing','placeholder'=>'Mailing address', 'aria-describedby'=>'basic-addon2'])!!}
                            
                        </div>
                    </div>
                    <div class="col-sm-4">
                        
                        <div class="wow slideInRight md15">
                        <p><input type="radio" name="default_band_preference" id="default_band_preference1" value="0"> Routing Number</p>
                        <p><input type="radio" name="default_band_preference" id="default_band_preference2" value="1"> Paypal Email</p>
                        <p><input type="radio" name="default_band_preference" id="default_band_preference3" value="2"> Mailing Address</p>
                        </div>
                    </div>
                    <div class="col-sm-2">&nbsp;</div>
                </div>
                    </div>
                </div>
                <div class="brand_login_panel">
                    <div class="row">
                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-8  wow fadeInDown"><h2 class="">Card Information</h2></div>
                        <div class="col-sm-2">&nbsp;</div>
                    </div>
                    <div class="form_panel">
                         <div class="row signup_form_panel">                    
                    <div class="col-sm-2">&nbsp;</div>
                    
                    <div class="form-horizontal" >
                        <fieldset>
                          <div class="form-group">
                            <div class="col-sm-6">
                            <div class="input-group wow slideInRight md15">
                              <!-- <input type="text" class="form-control" name="card-holder-name" id="card-holder-name" placeholder="Card Holder's Name"> -->
                              {!! Form::text('card_holder_name',null,['class'=>'form-control','id'=>'card_name','placeholder'=>'Card Holder\'s Name'])!!}
                          </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-6">
                            <div class="input-group wow slideInRight md15">
                              <!-- <input type="text" class="form-control" name="card-number" id="card-number" placeholder="Debit/Credit Card Number"> -->
                          {!! Form::text('card_name',null,['class'=>'form-control','id'=>'card_name','placeholder'=>'Debit/Credit Card Number'])!!}
                      </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-9">
                              <div class="row">
                                <div class="col-xs-3">
                                <div class="input-group wow slideInRight md15">
                                  <select class="form-control col-sm-2" name="expiry_month" id="expiry-month">
                                    <option value="">Month</option>
                                    <option value="01">Jan (01)</option>
                                    <option value="02">Feb (02)</option>
                                    <option value="03">Mar (03)</option>
                                    <option value="04">Apr (04)</option>
                                    <option value="05">May (05)</option>
                                    <option value="06">June (06)</option>
                                    <option value="07">July (07)</option>
                                    <option value="08">Aug (08)</option>
                                    <option value="09">Sep (09)</option>
                                    <option value="10">Oct (10)</option>
                                    <option value="11">Nov (11)</option>
                                    <option value="12">Dec (12)</option>
                                  </select>
                                  </div>
                                </div>
                                <div class="col-xs-3">
                                <div class="input-group wow slideInRight md15">
                                  <select class="form-control" name="expiry-year">
                                  <?php 
									$current_yr = date("Y");
								  	for($i=1;$i<20;$i++){
										$yr  = $current_yr+$i;
								   ?>
                                   	<option value="<?php echo $yr;?>"><?php echo $yr;?></option>
                                   <?php		
									}
								  ?>
                                    
                                  </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-3">
                            <div class="input-group wow slideInRight md15">
                              <!-- <input type="text" class="form-control" name="cvv" id="cvv" placeholder="Security Code"> -->
                              {!! Form::text('cvv',null,['class'=>'form-control','id'=>'cvv','placeholder'=>'Security Code'])!!}
                              </div>
                            </div>
                          </div>
                          
                          <div class="form-group">
                           <div class="col-sm-4">
                                <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
                                    <!-- <input class="form-control" placeholder="Full Name" aria-describedby="basic-addon2" type="text"> -->
                                    {!! Form::text('card_shiping_name',null,['class'=>'form-control','id'=>'card_shiping_name','placeholder'=>'Full Name'])!!}
                                </div>
                                <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
                                    <!-- <input class="form-control" placeholder="Address 1" aria-describedby="basic-addon2" type="text"> -->
                                    {!! Form::text('card_shiping_address',null,['class'=>'form-control','id'=>'shiping_address','placeholder'=>'Address 1'])!!}
                                </div>
                                <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
					        	{!! Form::select('card_country_id', array('' => 'Please select country') +$alldata,'default', array('id' => 'card_country_id','onchange' => 'getState(this.value,"card")')); !!}
                                </div>
                                <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
                                    {!! Form::text('card_shiping_city',null,['class'=>'form-control','id'=>'card_shiping_city','placeholder'=>'City'])!!}
                                </div>                                
                            </div>
                            <div class="col-sm-4">
                                <div style="visibility: visible; animation-name: slideInRight;" class="input-group wow slideInRight md15 animated">
                                    <!-- <input class="form-control" placeholder="Phone" aria-describedby="basic-addon2" type="text"> -->
                                     {!! Form::text('card_shipping_phone_no',null,['class'=>'form-control','id'=>'card_shipping_phone_no','placeholder'=>'Phone'])!!}
                                </div>
                                <div style="visibility: visible; animation-name: slideInRight;" class="input-group wow slideInRight md15 animated">
                                   <!--  <input class="form-control" placeholder="Address 2" aria-describedby="basic-addon2" type="text"> -->
                                   {!! Form::text('card_shipping_address2',null,['class'=>'form-control','id'=>'shipping_address2','placeholder'=>'Address 2'])!!}
                                </div>
                                <div style="visibility: visible; animation-name: slideInRight;" class="input-group wow slideInRight md15 animated">
                            		{!! Form::select('card_state', array('' => 'Please select state'),'default', array('id' => 'card_state')); !!}
                                </div>
                                <div style="visibility: visible; animation-name: slideInRight;" class="input-group wow slideInRight md15 animated">
                                    <!-- <input class="form-control" placeholder="Post Code" aria-describedby="basic-addon2" type="text"> -->
                                    {!! Form::text('card_shipping_postcode',null,['class'=>'form-control','id'=>'card_shipping_postcode','placeholder'=>'Post Code'])!!}
                                </div>
                            </div>
                          </div>
                        </fieldset>
                    </div>
                    <div class="col-sm-2">&nbsp;</div>
                </div>
                    </div>
                </div>
                <div class="brand_login_panel">
                    <div class="row">
                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-8  wow fadeInDown"><h2 class="">Shipping address for monthly samples</h2></div>
                        <div class="col-sm-2">&nbsp;</div>
                    </div>
                    <div class="form_panel">
                         <div class="row signup_form_panel">
                    <div class="col-sm-2">&nbsp;</div>
                    <div class="col-sm-4">
                        <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
                            <!-- <input class="form-control" placeholder="Full Name" aria-describedby="basic-addon2" type="text"> -->
                            {!! Form::text('shiping_fname',null,['class'=>'form-control','id'=>'cvv','placeholder'=>'Full Name'])!!}
                        </div>
                        <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
                            <!-- <input class="form-control" placeholder="Address 1" aria-describedby="basic-addon2" type="text"> -->
                             {!! Form::text('shiping_address',null,['class'=>'form-control','id'=>'shiping_address','placeholder'=>'Address 1'])!!}
                        </div>
                        <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
					        {!! Form::select('country', array('' => 'Please select country') +$alldata,'default', array('id' => 'country','onchange' => 'getState(this.value,"shipping")')); !!}
                        </div>
                        <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
                            {!! Form::text('city',null,['class'=>'form-control','id'=>'city','placeholder'=>'City'])!!}
                        </div>
                       
                    </div>
                    <div class="col-sm-4">
                        <div style="visibility: visible; animation-name: slideInRight;" class="input-group wow slideInRight md15 animated">
                            <!-- <input class="form-control" placeholder="Address 2" aria-describedby="basic-addon2" type="text"> -->
                            {!! Form::text('shipping_address2',null,['class'=>'form-control','id'=>'shipping_address2','placeholder'=>'Address 2'])!!}
                        </div>
                        <div style="visibility: visible; animation-name: slideInRight;" class="input-group wow slideInRight md15 animated">
                            {!! Form::select('state', array('' => 'Please select state'),'default', array('id' => 'state')); !!}
                        </div>
                        <div style="visibility: visible; animation-name: slideInRight;" class="input-group wow slideInRight md15 animated">
                           <!--  <input class="form-control" placeholder="Post Code" aria-describedby="basic-addon2" type="text"> -->
                           {!! Form::text('shipping_postcode',null,['class'=>'form-control','id'=>'shipping_postcode','placeholder'=>'Post Code'])!!}
                        </div>
                    </div>
                    <div class="col-sm-2">&nbsp;</div>
                </div>
                    </div>
                </div>
                <div class="brand_login_panel">
                    <div class="row">
                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-8  wow fadeInDown"><h2 class="">Picture of govt issues ID(passport or Driver's License)</h2></div>
                        <div class="col-sm-2">&nbsp;</div>
                    </div>
                    <div class="form_panel">
                         <div class="row signup_form_panel">
                    <div class="col-sm-2">&nbsp;</div>
                    <div class="col-sm-8">
                        <div style="visibility: visible; animation-name: slideInLeft;" class="input-group wow slideInLeft md15 animated">
                             {!! Form::file('government_issue',['class'=>'btn','id'=>'government_issue','placeholder'=>'Issue Id'])!!}
                        </div>
                    </div>
                    
                    <div class="col-sm-2">&nbsp;</div>
                </div>
                    </div>
                </div>
                <div class="brand_login_panel">
                    <div class="form_panel">
                         <div class="row signup_form_panel">
                    <div class="col-sm-2">&nbsp;</div>
                    <div class="col-sm-8">
                        <!--<p><input type="checkbox"> Accepting of Brand Contract with electronic signature on document</p>-->
                        <p>{!! Form::checkbox('agree', 1, null, ['class' => 'field']) !!} Accepting of Brand Contract with electronic signature on document</p>
                        
                    </div>
                    
                    <div class="col-sm-2">&nbsp;</div>
                </div>
                    </div>
                </div>
                <div class="row  signup_form_panel text-center md30">
                    <div class="col-sm-4">&nbsp;</div>
                    <div class="col-sm-4 mu15">
                    	<!--<button data-toggle="modal" data-target="#myModal" type="submit" class="wow fadeInUp btn btn-default sub_btn">Submit</button>-->
                    	<button type="submit" class="wow fadeInUp btn btn-default sub_btn">Submit</button>
                    </div>
                    <div class="col-sm-4">&nbsp;</div>                    
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <!--login_cont-->
        
    </div>
    <!--for login page-->
    <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div id="datetimepicker12"></div>
      </div>
    </div>    
  </div>
</div>

<script type="text/javascript">
 function getState(country_id,param)
 {
    alert("country= "+country_id);
    $.ajax({
      url: '<?php echo url();?>/getState',
      method: "POST",
      data: { countryId : country_id ,_token: '{!! csrf_token() !!}'},
      success:function(data)
      {
        //alert(data);
		if(param=="card")
	        $("#card_state").html(data);
		else
	        $("#state").html(data);
      }
    });

 }

</script>


<script type="text/javascript">

 /***** DUPLICATE E-MAIL CHECK ****/

 function emailChecking(email_id)
 {
    if(email_id !='')
    {
        $.ajax({
          url: '<?php echo url();?>/emailChecking',
          method: "POST",
          data: { email : email_id ,_token: '{!! csrf_token() !!}'},
          success:function(data)
          {
            //alert(data);
            if(data == 1 ) // email exist already
            {
                $("#email").val('');
                $("#email_error").show();
            }
            else
            {
                $("#email_error").hide();
            }
          }
        });
    }
 }

/***** DUPLICATE E-MAIL CHECK ****/
// $(function () {
//             $('#datetimepicker12').datetimepicker({
//                 inline: true,
//                 sideBySide: true
//             });
//         });

</script>
<style>
#email_error
{
    display: none;
    }
</style>
@stop