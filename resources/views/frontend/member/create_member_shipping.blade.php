 @extends('frontend/layout/frontend_template')
@section('content')
<div class="inner_page_container nomar_bottom">
<div id="nav-icon2">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
  </div>
  <div class="mob_topmenu_back"></div>
<div class="top_menu_port">
    	<div class="acct_box blue_acct front">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="<?php echo url();?>/member-account"><img src="<?php echo url();?>/public/frontend/images/account/pers_info.png" alt=""></a>
                        <a href="<?php echo url();?>/member-account" class="link_wholediv">Personal Information</a>
                        </div>                    	
                    </div>
                </div> 
        <div class="acct_box green_acct no_marg">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="<?php echo url();?>/member-changepass"><img src="<?php echo url();?>/public/frontend/images/account/changepassword.png" alt=""></a>
                        <a href="<?php echo url();?>/member-changepass" class="link_wholediv">Change Password</a>
                        </div>                    	
                    </div>
                </div>                
        <div class="acct_box violet_acct">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="<?php echo url();?>/member-shipping-address"><img src="<?php echo url();?>/public/frontend/images/account/address.png" alt=""></a>
                        <a href="<?php echo url();?>/member-shipping-address" class="link_wholediv">My Address</a>
                        </div>                    	
                    </div>
                </div>                
        <div class="acct_box orange_acct wish_acct no_marg">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <img src="<?php echo url();?>/public/frontend/images/account/wishlist_icn.png" alt="">
                        <a href="" class="link_wholediv">My Wishlist<span>Coming Soon</span></a>
                        </div>                    	
                    </div>
                </div>
        <div class="acct_box new_green_acct no_marg">
                	<div class="acct_box_inn">
                    	<div class="acct_box_inn_inn">
                        <a href="<?php echo url();?>/order-history"><img src="<?php echo url();?>/public/frontend/images/account/order_hist.png" alt=""></a>
                        <a href="<?php echo url();?>/order-history" class="link_wholediv">Order History</a>
                      </div>                    	
                    </div>
                </div>
    </div>
    	   <!--my_acct_sec-->
           <div class="my_acct_sec">           
               <div class="container">
               
               <div class="col-sm-10 col-sm-offset-1">
               
               <div class="row"><div class="form_dashboardacct for_new_address">
               		<h3>Add New Address</h3>
			    
		 @if(Session::has('error'))
                    <div class="alert alert-error container-fluid">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{!! Session::get('error') !!}</strong>
                    </div>
                  @endif
                  @if(Session::has('success'))
                    <div class="alert alert-success container-fluid">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{!! Session::get('success') !!}</strong>
                    </div>
                  @endif
		  
		  {!! Form::open(['url' => 'create-member-shipping-address','method'=>'POST', 'files'=>true,  'id'=>'member_form']) !!}
                    <div class="bottom_dash special_bottom_pad clearfix">
                    	
                        <div class="row">
                        
                        <div class="col-sm-12">
                        <div class="row">
                         
                          <div class="form-group col-sm-6">
                            {!! Form::text('first_name',null,['class'=>'form-control','id'=>'first_name','placeholder'=>'First Name'])!!}
                          </div>
                          <div class="form-group col-sm-6">
                            {!! Form::text('last_name',null,['class'=>'form-control','id'=>'last_name','placeholder'=>'Last Name'])!!}
                          </div>
                          <div class="form-group col-sm-6">
                            {!! Form::text('email',null,['class'=>'form-control','id'=>'email','placeholder'=>'Email'])!!}
                          </div>
                          <div class="form-group col-sm-6">
                            {!! Form::text('address',null,['class'=>'form-control','id'=>'address1','placeholder'=>'Address 1', 'onFocus'=>'geolocate()'])!!}
                          </div>
			    
			  
			    
			   <div class="form-group col-sm-6">
                             {!! Form::select('country', array('' => 'Please select country') +$alldata,'default', array('id' => 'country', 'class'=>"form-control",'onchange' => 'getState(this.value,"shipping")')); !!}
                          </div>
			    
			  <div class="form-group col-sm-6">
                             {!! Form::select('zone_id', array('' => 'Please select state'),'default', array('id' => 'administrative_area_level_1','class'=>"form-control")); !!}
                          </div>
			    
			 <div class="form-group col-sm-6">
                            {!! Form::text('city',null,['class'=>'form-control','id'=>'locality','placeholder'=>'City'])!!}
                          </div>
			    
			<div class="form-group col-sm-6">
                            {!! Form::text('postcode',null,['class'=>'form-control','id'=>'postal_code','placeholder'=>'Zip code'])!!}
                          </div>
			<div class="form-group col-sm-6">
                            {!! Form::text('phone',null,['class'=>'form-control','id'=>'phone','placeholder'=>'Phone'])!!}
                          </div>
			    <div class="form-group col-sm-6">
                            {!! Form::text('address2',null,['class'=>'form-control','id'=>'address2','placeholder'=>'Address 2'])!!}
                          </div>
                          <?php if($total_add==0){?>
                              <div class="col-sm-12">
                                <p class="pull-left">Default Address</p>
                                
                                <div class="check_box_tab marg_left pull-left">                            
                                    <input type="radio" class="regular-checkbox" id="radio-4" name="default_address" value="1" checked="checked">
                                    <label for="radio-4">Yes</label>
                                </div>
                              </div>
                          <?php } else { ?>
                              <div class="col-sm-12">
                                <p class="pull-left">Default Address</p>
                                
                                <div class="check_box_tab marg_left pull-left">                            
                                    <input type="radio" class="regular-checkbox" id="radio-4" name="default_address" value="1">
                                    <label for="radio-4">Yes</label>
                                </div>
                                <div class="check_box_tab marg_left pull-left">                            
                                    <input type="radio" class="regular-checkbox" id="radio-5" name="default_address" value="0" checked="checked">
                                    <label for="radio-5">No</label>
                                </div>
                              </div>
                          <?php } ?>

                        </div>  
                        </div>
                        </div>
                        
                    </div>
                    
                    <div class="form_bottom_panel">
                    <!--<a href="<?php echo url();?>/member-dashboard" class="green_btn pull-left"><i class="fa fa-angle-left"></i> Back to Dashboard</a>-->
                    <button type="submit" form="member_form" class="btn btn-default green_sub pull-right">Save</button>
                    </div>
                     {!! Form::close() !!}
               </div>
               
               </div>
               
               </div>
               
               </div>           
           </div>
           <!--my_acct_sec ends-->
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
        
	        $("#administrative_area_level_1").html(data);
		if (state!='') {
		    $("#administrative_area_level_1 option").filter(function() {
		    return this.text == state; 
		}).attr('selected', true);
		}
		
      }
    });

 } 
	    $(function() {

   

    // Setup form validation  //
    $("#member_form").validate({
    
        // Specify the validation rules
        rules: {
	
		
	    first_name: "required",
	    last_name: "required",
	    email: "required",
	    address: "required",
	    country: "required",
	    administrative_area_level_1: "required",
	    city: "required",
	    postal_code: "required",
	    phone :
        {
            required : true,
            phoneUS: true
        },
      
      
            
     },
		
        submitHandler: function(form) {
            form.submit();
        }
    });


  });
	    
	   </script>	    
 </div>
  
   
<script>
// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

var placeSearch, autocomplete,state;
var componentForm = {
  //street_number: 'short_name',
  //route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'long_name',
 country: 'long_name',
  postal_code: 'short_name'
};
  var input=document.getElementById('address1');
function initAutocomplete() {

var options = {
  types:  ['geocode']
};

autocomplete = new google.maps.places.Autocomplete(input, options);

  // When the user selects an address from the dropdown, populate the address
  // fields in the form.
  autocomplete.addListener('place_changed', fillInAddress);
}



// [START region_fillform]
function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();
console.log(place);
  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }

  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
  
  document.getElementById("address1").value = place.address_components[0]['long_name'] +" "+ place.address_components[1]['long_name'];
  
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      
     
	document.getElementById(addressType).value = val;
     
      if(addressType=='country'){
	
	$("#country option").filter(function() {
	    return this.text == val; 
	}).prop('selected', true);
	$( "#country" ).change();
    }
      
      if(addressType=='administrative_area_level_1'){
	state=val;
      }
      
      
    }
  }
}
// [END region_fillform]

// [START region_geolocation]
// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle({
        center: geolocation,
        radius: position.coords.accuracy
      });
      autocomplete.setBounds(circle.getBounds());
    });
  }
}
// [END region_geolocation]

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo env('GOOGLE_CLIENT_SECRET')?>&signed_in=true&libraries=places&callback=initAutocomplete"
        async defer></script>
   
 @stop