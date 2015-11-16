 @extends('frontend/layout/frontend_template')
@section('content')

<div class="inner_page_container nomar_bottom">
    	   <!--my_acct_sec-->
           <div class="my_acct_sec">           
               <div class="container">
               
               <div class="col-sm-10 col-sm-offset-1">
               
               <div class="row">
	      
	        {!! Form::open(['url' => 'brand-account','method'=>'POST', 'files'=>true,  'id'=>'member_form']) !!}
		
               <div class="form_dashboardacct">
               		<h3>Brand Information</h3>
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
                        <h5 class="col-sm-offset-3">Brand Details</h5>
                         
                        <div class="col-sm-3 left_acct_img">
			
			
			   
				
				<div class="upload_button_panel img_modify">
				<p class="upload_image">
				<input class="upload_button filesbrand" type="file" name="image" id="image" accept="image/*" style="cursor:pointer;"><span>Upload Image</span></p>
				<div class="selectedFiles">
				 <?php if(!empty($brand_details['pro_image'])){?>
				   <img src="<?php echo url();?>/uploads/brandmember/<?php echo $brand_details['pro_image']?>" class="img-responsive" alt="" width="150">
				     <input type="hidden" name="hidden_image" id="hidden_image" value="<?php echo $brand_details['pro_image']?>">
				  <?php } else {?>
				    <img src="<?php echo url();?>/public/frontend/images/newdashimages/acct_imgd.png" class="img-responsive" alt="">
				    <a href="javascript:void(0);" class="text-center">Upload Image</a>
				  <?php } ?>                                
				</div>
			      </div> 
			    
                        </div>
                        <div class="col-sm-9">
                        
                          <div class="form-group">
                            
			    {!! Form::text('business_name',$brand_details['business_name'],['class'=>'form-control','placeholder'=>'Name / Business Name', 'aria-describedby'=>'basic-addon2'])!!}
                          </div>
                          <div class="form-group">
                            {!! Form::text('fname',$brand_details['fname'],['class'=>'form-control','id'=>'fname','placeholder'=>'Executive in Charge First Name', 'aria-describedby'=>'basic-addon2'])!!}
                          </div>
			    
			    <div class="form-group">
                             {!! Form::text('lname',$brand_details['lname'],['class'=>'form-control','id'=>'lname','placeholder'=>'Executive in Charge Last Name', 'aria-describedby'=>'basic-addon2'])!!}
                          </div>
			    
			     <div class="form-group">
                             {!! Form::text('youtube_link',$brand_details['youtube_link'],['class'=>'form-control','id'=>'youtube_link','placeholder'=>'Youtube Url', 'aria-describedby'=>'basic-addon2'])!!}
                          </div>
			    
			  <div class="form-group">
                             {!! Form::text('brand_sitelink',$brand_details['brand_sitelink'],['class'=>'form-control','id'=>'brand_sitelink','placeholder'=>'Site Url', 'aria-describedby'=>'basic-addon2'])!!}
                          </div>
			    
			    <div class="form-group">
                             {!! Form::textarea('brand_details',$brand_details['brand_details'],['class'=>'form-control', 'rows'=>5, 'cols'=>80,'id'=>'brand_details','placeholder'=>'Short Description About Brand', 'aria-describedby'=>'basic-addon2'])!!}
                          </div>
			    
                         
			    
                          <div class="form-group">
                             {!! Form::text('phone_no',$brand_details['phone_no'],['class'=>'form-control','placeholder'=>'Phone Number', 'aria-describedby'=>'basic-addon2'])!!}
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
$.validator.addMethod("youtube", function(value, element) {
     var p = /^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/;
     return (value.match(p)) ? RegExp.$1 : false;
    }, "Enter correct Youtube Url");
    
$.validator.addMethod("complete_url", function(val, elem) {
    
    if (val.length == 0) { return true; }
    if(!/^(https?|ftp):\/\//i.test(val)) {
        val = 'http://'+val; 
        $(elem).val(val); 
    }
 
    return /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&amp;'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(val);
});
  
  // When the browser is ready...
  $(function() {

   

    // Setup form validation  //
    $("#member_form").validate({
    
        // Specify the validation rules
        rules: {
			business_name:"required",
      fname: "required",
      lname: "required",
     
			phone_no :
                {
                    required : true,
                    phoneUS: true
                },
     youtube_link: {
                required: false,
                youtube: true,
            },
      brand_sitelink: {
                required: false,
                complete_url: true,
            },      
     },
		
        submitHandler: function(form) {
            form.submit();
        }
    });


  });
  
  
    
</script>
@stop