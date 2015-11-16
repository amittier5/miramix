{!! HTML::script('resources/assets/js/ckeditor/ckeditor.js') !!} 


@extends('admin/layout/admin_template')

@section('content')

<script>
  $(document).ready(function(){
  /****** Auto complete ********/
      $( ".tags_auto" ).autocomplete({
        source: "{!!url('admin/vitamin-search')!!}"
      });

      $( ".comp_name" ).autocomplete({
        source: "{!!url('admin/component-search')!!}"
      });
  });
</script>

<!-- jQuery Form Validation code -->
  <script>
  var keyup_vit_weight=0;
  function vit_weightval(){
	  keyup_vit_weight=0;
	  //alert();
	$('.input_fields_wrap').each(function(index, element) {
		 
			var ind_weight=0; 
			var $this=$(this); 
            $this.find('.vit_text').each(function(index, element) {
				var this_uniq_elm=$(this);
                var this_uniqval=this_uniq_elm.val();
				if(this_uniqval=='')
				this_uniqval=0;
				keyup_vit_weight=parseInt(keyup_vit_weight)+parseInt(this_uniqval);
				ind_weight=parseInt(ind_weight)+parseInt(this_uniqval);
            });
			$this.find('.tot_vitval').html('Total Vitamin Value is:'+ind_weight);	
        });
			
		 $('.tot_vit_weight').html('<p>Total Weight is:'+keyup_vit_weight+'</p>');  
  }
  var intRegex = /^\d+$/;
  form_notsubmit_vitamin = 0;
  form_notsubmit_value = 0;
  form_notsubmit_name = 0;
  
	

	
	
  // When the browser is ready...
  $(document).ready(function(e) {

var vit_car=0;
	  var total=0;
	  var com_namevar=0;
	  var com_valvar=0;
	  var vit_total=0;
	  var total_weight=0;
      
		  $(document).on('keyup','.vit_text',function(){
		 var $this=$(this);
		 var this_val=$this.val();
		if(!intRegex.test(this_val)){
			$this.val('');
			$this.addClass('error_red');
			if($this.parent().find('.appended_error').length>0){
			$this.parent().find('.appended_error').html('Please Enter a Numeric value');	
			}
			else{
			$this.parent().append('<label class="appended_error">Please Enter a numeric value</label>');
			}
		}
		else if($this.val()==''){
			$this.addClass('error_red');
			if($this.parent().find('.appended_error').length>0){
				
			}
			else{
			$this.parent().append('<label class="appended_error">Enter A Vitamins Value</label>');
			}
		}
		else{
			$this.parent().find('.appended_error').remove();
			$this.removeClass('error_red');	
		}
	  });
	  $(document).on('keyup','.comp_name',function(){
		 var $this=$(this);
				if($this.val()==''){
					$this.addClass('error_red');
					if($this.parent().find('.appended_error').length>0){
						
					}
					else{
					$this.parent().append('<label class="appended_error">Enter A Component Name</label>');
					}
				}
				else{
					$this.parent().find('.appended_error').remove();
					$this.removeClass('error_red');	
				}
	  });
	  
	  $(document).on('keyup','.comp_value',function(){
		var $this=$(this);
				 var this_val=$this.val();
				if(!intRegex.test(this_val)){
					$this.val('');
					$this.addClass('error_red');
					if($this.parent().find('.appended_error').length>0){
					$this.parent().find('.appended_error').html('Please Enter a Numeric value');	
					}
					else{
					$this.parent().append('<label class="appended_error">Please Enter a numeric value</label>');
					}
				}
				else{
					$this.parent().find('.appended_error').remove();
					$this.removeClass('error_red');	
				}
	  });
	  $(document).on('blur','.vit_text',function(){
		 //alert(); 
		 var $this=$(this);
		 var this_val=$this.val();
		 vit_weightval();	
	  });
	  
	  $("#edit_frm").validate({
        
        ignore: [],

        rules: {
            name: "required",
            chemical_name: "required",
            price_per_gram: {
                required:true,
                number:true
            },
            list_manufacture: "required",

            description: {
                        required: function() 
                        {
                        CKEDITOR.instances.description.updateElement();
                        }
                    }
        },
        
        // Specify the validation error messages
        messages: {
            name: "Please enter ingredient name.",
            chemical_name: "Please enter chemical name.",
            price_per_gram: {
                required:"Please enter price per gram.",
                number:"Input only numbers."
            },
            list_manufacture: "Please enter manufacture.",
            description: "Please enter description."
        },               

        submitHandler: function(form, event) {
			//alert('submithandler');
          //alert(form_notsubmit_vitamin+'///'+form_notsubmit_value+'////'+form_notsubmit_name)

          		//alert('vit_car:'+vit_car);
				//alert('total:'+total);
				//alert('com_namevar:'+com_namevar);
				//alert('com_valvar:'+com_valvar);
				alert('total_weight:'+total_weight);
				
				if(total!=100 || vit_car==1 || com_namevar==1 || com_valvar==1 || total_weight<100){
					//alert('ifsubmit');
					//alert();
						/*if($('.module-head').find('.appended_error').length>0){					
								$('.module-head').find('.appended_error').html('Total Amount For all The component(%) should be equal to 100');
							}
							else{
								$('.module-head').append('<label class="appended_error">Total Amount For all The component(%) should be equal to 100</label>');	
						}*/
						if(total!=100){
							alert();
							$('.module-head').append('<label class="appended_error">Total Amount For all The component(%) should be equal to 100</label>');	
						}
						
						else if(vit_car==1 || total_weight<100){	
												
							if(vit_car==1){
								//alert('submitvit1');
								if($('.vit_text.error_red').parent().find('.appended_error').length>0){
									
								}
								else{
								$('.vit_text.error_red').parent().append('<label class="appended_error">Enter A Vitamins Value</label>');	
								}
							}
							else{
							 $('.vit_text').addClass('error_red');	 
							 $('.tot_vit_weight').html('<p>Total Weight is:'+total_weight+'<br><label style="color:red;">Total Weight Should be at least 100</label></p>');
							}
						}
						
						else if(com_namevar==1){
							if($('.comp_name.error_red').parent().find('.appended_error').length>0){
								
							}
							else{
							$('.comp_name.error_red').parent().append('<label class="appended_error">Enter A Component Name</label>');	
							}	
						}
						
						return false;
				}
				else{
					$('.tot_vit_weight').html('<p>Total Weight is:'+total_weight+'</p>');
					//alert('else');
					form.submit();
				}
       
    
      
        }
    });	
	  
    $(document).on('click','.sub_btn_spec',function(){
		   total=0;
		 total_weight=0;
		 
		 $('.input_fields_wrap').each(function(index, element) {
			var total_vitval=0;
            var $this=$(this);
			var this_id=$this.attr('id');
			$this.find('.vit_text').each(function(index, element) {				
				var this_vit=$(this);
				if(this_vit.val()=='')
				total_vitval=parseInt(total_vitval)+0;
				else
                total_vitval=parseInt(total_vitval)+parseInt(this_vit.val());
				$this.find('.tot_vitval').html('Total Vitamin Value is:'+total_vitval); 
            });
        });
		 
		   //$('.input_fields_wrap').each(function(index, element) {            
        
			$('.vit_text').each(function(index, element) {
                var $this=$(this);
				if($this.val()==''){
				$this.addClass('error_red');
					//alert();
					total_weight=parseInt(total_weight)+0;	
					//$('.tot_vit_weight').html('<p>Total Weight is:'+total_weight+'</p>');	

					
					
					//alert(total_weight);
					
					
					
						
						$this.parent().append('<label class="appended_error">Enter A Vitamin Value</label>');
						
						
					
				vit_car=1;
				}
				else{
					//alert('totalweightelse');
					//total_weight=parseInt(total_weight)+parseInt($this.val());
					//$('.tot_vit_weight').html('<p>Total Weight is:'+total_weight+'</p>');
					$this.parent().find('.appended_error').remove();
					$this.removeClass('error_red');
					total_weight=parseInt(total_weight)+parseInt($this.val());
					$('.tot_vit_weight').html('<p>Total Weight is:'+total_weight+'</p>');	
					vit_car=0;	
				}
         });

		 //});
		 $('.comp_name').each(function(index, element) {
                var $this=$(this);
				if($this.val()==''){
				$this.addClass('error_red');	
				if($this.parent().find('.appended_error').length>0){
				
					}
					else{
					$this.parent().append('<label class="appended_error">Enter A Component Name</label>');
					}
					com_namevar=1;
					
				}
				else{
					$this.parent().find('.appended_error').remove();
					$this.removeClass('error_red');	
					com_namevar=0;
				}
         });
		 $('.comp_value').each(function(index, element) {
                var $this=$(this);
				
				//alert(total);
				//console.log(total);
				
				if($this.val()==''){
					//$this.parent().find('.appended_error').remove();
					//alert(total);
					total=parseInt(total)+0;
					$this.addClass('error_red');
				if($this.parent().find('.appended_error').length>0){
				
					}
					else{
						
							$this.parent().append('<label class="appended_error">Please Enter A Value</label>');	
						
						
					}
					com_valvar=1;
				}
				else{
					//alert($this.val());	
					
					total=parseInt(total)+parseInt($this.val());
					$('.module-head').parent().find('.appended_error').remove();
					$this.parent().find('.appended_error').remove();	
					$('.comp_value').removeClass('error_red');
					
					com_valvar=0;
				}
         });
		 
		 
		 
		 
	  });
    // Setup form validation on the #register-form element
    

  });
  
   
  
  
  </script>
<div class="tot_vit_weight" style="position: fixed;right: 0;top: 80px;width: 140px;padding: 20px 20px;border: 1px solid #ccc;background: #fff;border-radius: 2px;text-align: center;"><p>Total Weight is:0</p></div>     

        {!! Form::model($ingredient,['method' => 'PATCH','files'=>true,'route'=>['admin.ingredient.update',$ingredient->id],'class'=>'form-horizontal row-fluid','id'=>'edit_frm']) !!}

        <div class="control-group">
                <label class="control-label" for="basicinput">Ingredient Name *</label>

                <div class="controls">
                     {!! Form::text('name',null,['class'=>'span8','id'=>'name']) !!}
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="basicinput">Chemical Name *</label>

                <div class="controls">
                     {!! Form::text('chemical_name',null,['class'=>'span8','id'=>'chemical_name']) !!}
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="basicinput">Price / gm *</label>

                <div class="controls">
                     {!! Form::text('price_per_gram',null,['class'=>'span8','id'=>'price_per_gram']) !!}
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="basicinput">Manufacture *</label>

                <div class="controls">
                     {!! Form::text('list_manufacture',null,['class'=>'span8','id'=>'list_manufacture']) !!}
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="basicinput">Image *</label>

                <div class="controls">
                     {!! Form::file('image',null,['class'=>'span8','id'=>'image_file']) !!}
                    <p><img  src="<?php echo url()?>/uploads/ingredient/{!! $ingredient->image; !!}" class="nav-avatar spec_navavatar"></p>
                    {!! Form::hidden('hidden_image',$ingredient->image,['class'=>'span8']) !!}
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="basicinput">Description *</label>
                <div class="controls">
                     {!! Form::textarea('description',null,['class'=>'span8 ckeditor','id'=>'description']) !!}
                </div>
            </div>
             <div class="control-group">
                <label class="control-label" for="basicinput">Type </label>
                <div class="controls">
                    {!! Form::select('type', array('synthetic' => 'Synthetic', 'whole_food' => 'Whole Food'),null, ['class' => 'field']); !!}
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="basicinput">Organic</label>
                <div class="controls">
                    {!! Form::select('organic', array('yes' => 'Yes', 'no' => 'No'),null, ['class' => 'field']); !!}
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="basicinput">Antibiotic Free</label>
                <div class="controls">
                    {!! Form::select('antibiotic_free', array('yes' => 'Yes', 'no' => 'No'),null, ['class' => 'field']); !!}
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="basicinput">GMO</label>
                <div class="controls">
                    {!! Form::select('gmo', array('yes' => 'Yes', 'no' => 'No'),null, ['class' => 'field']); !!}
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="basicinput">Form Factor</label>
                <div class="controls">
                @foreach($all_formfactors as $each_form_factor)
                    <input type="checkbox" name="form_factor[]" <?php echo ((in_array($each_form_factor->id, $all_check_formfactors))?'checked':''); ?> value="{!! $each_form_factor->id !!}" id="{!! $each_form_factor->id !!}"> &nbsp;{!! $each_form_factor->name !!}<br/>
                @endforeach

                </div>
            </div>
            <div class="tot_wrap">
               
                    <div class="control-group">
                        <label class="control-label" for="basicinput">Components Group</label>
                        <div class="controls">
                             <a href="javascript:void(0);" class="btn btn-success spec_btn"><span>+</span>Add Component Group</a>
                             
                        </div>
                    </div>
                     <div class="control-group">
                        <label class="control-label" for="basicinput">Vitamins Weight Measurement</label>

                        <div class="controls">
                             <input class="comp_value" <?php if($ingredient->weight_measurement==0){?> checked <?php } ?> type="radio" name="weight_measurement" id="weight_measurement1" value="0">Miligram<br/>
                             <input class="comp_value" <?php if($ingredient->weight_measurement==1){?> checked <?php } ?>  type="radio" name="weight_measurement" id="weight_measurement2" value="1">Microgram
                        </div>
                    </div>
                    <?php 
                    // echo "<pre>"; print_r($all_components); exit;
                   // echo $all_components[0]['component_details']->id;
                   //  exit;

                    $i=0;
                    foreach($all_components as $each_component)
                    {
                      //echo $each_component['component_details']->name;
                      ?>
                   <div class="input_fields_wrap" id="<?php echo $i;?>">
                    <div class="control-group">
                        <label class="control-label" for="basicinput">Components Group</label>
                        <div class="controls">
                             <a href="javascript:void(0);" class="btn btn-danger remove_btn"><span>-</span>Delete Component Group</a>
                             <p class="tot_vitval"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="basicinput">Component Name</label>

                        <div class="controls">
                             <input class="span8 comp_name" type="text" name="component_name[<?php echo $i;?>][name]" value="<?php echo $each_component['component_details']->component_name;?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="basicinput">Component(%) Value</label>

                        <div class="controls">
                             <input class="span8 comp_value" type="text" name="component_name[<?php echo $i;?>][percentage]" value="<?php echo $each_component['component_details']->percentage;?>">
                        </div>
                    </div>

                    <?php 
                        //foreach($each_component['vitamins'] as $each_vitamin) {
                        for($l=0;$l<count($each_component['vitamins']);$l++) {
                      ?>
                    <div class="new_panel_section"><div class="control-group">
                        <label class="control-label" for="basicinput">Vitamin</label>
                        <div class="controls">
                        <input class="span8 tags_auto vit_name" type="text" name="component_name[<?php echo $i;?>][vitamin][]" value="<?php echo $each_component['vitamins'][$l];?>">
                             <a href="javascript:void(0);" class="btn btn-danger remove_vitamin">-</a>
                        </div>
                    </div>
                    <div class="control-group new_field">
                        <label class="control-label" for="basicinput">Vitamin Weight</label>
                        <div class="controls">
                             <input class="span8 tags_auto vit_text" type="text" name="component_name[<?php echo $i;?>][weight][]" value="<?php echo $each_component['weights'][$l];?>">
                        </div>
                    </div></div>
                    
                 <?php }?>
                    <div class="control-group mu10">
                        <label class="control-label" for="basicinput">Add More Vitamins</label>
                        <div class="controls">
                          <a href="javascript:void(0);" class="btn btn-success add_vitamin normal_vitamin">+</a>
                        </div>
                    </div>
                  </div>    
                 <?php 
                    $i++;
                   } 
                  ?>
               
            </div>
            
            


            <div class="control-group">
                <div class="controls">
                    {!! Form::submit('Save', ['class' => 'btn sub_btn_spec']) !!}
                  
                     <a href="{!! url('admin/ingredient')!!}" class="btn">Back</a>
                   
                </div>
            </div>
        
        {!! Form::close() !!}


   <script type="text/javascript">
    $(document).ready(function() {
   
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".tot_wrap"); //Fields wrapper
    var add_button      = $(".spec_btn"); //Add button ID
    var a=0;
    var x = '<?php  echo count($all_components)-1;?>'; //initlal text box count
    $(document).on('click','.spec_btn',function(e){ //on add input button click
        e.preventDefault();
        
            x++; //text box increment
            $(wrapper).append('<div class="input_fields_wrap" id="'+x+'"><div class="control-group"><label class="control-label" for="basicinput">Components Group</label><div class="controls"><a href="javascript:void(0);" class="btn btn-danger remove_btn"><span>-</span>Remove This Group</a><p class="tot_vitval"></p></div></div><div class="control-group"><label class="control-label" for="basicinput">Component Name</label><div class="controls"><input class="span8 comp_name" type="text" name="component_name['+x+'][name]"></div></div><div class="control-group"><label class="control-label" for="basicinput">Component(%) Value</label><div class="controls"><input class="span8 comp_value" type="text" name="component_name['+x+'][percentage]"></div></div><div class="new_panel_section"><div class="control-group"><label class="control-label" for="basicinput">Vitamin</label><div class="controls"><input class="span8 tags_auto vit_name" type="text" name="component_name['+x+'][vitamin][]"><a href="javascript:void(0);" class="btn btn-danger remove_vitamin">-</a></div></div><div class="control-group new_field"><label class="control-label" for="basicinput">Vitamin Weight</label><div class="controls"><input class="span8 tags_auto vit_text" type="text" name="component_name['+x+'][weight][]"></div></div></div><div class="control-group mu10"><label class="control-label" for="basicinput">Add More Vitamins</label><div class="controls"> <a href="javascript:void(0);" class="btn btn-success add_vitamin normal_vitamin">+</a></div></div></div>'); //add input box
			
			setTimeout(function(){
			$('html, body').animate({
				scrollTop: $("div#"+x+".input_fields_wrap").offset().top
			}, 400);
			$("div#"+x+".input_fields_wrap").addClass('blink_me');
			
			},600);
			setTimeout(function(){
				$("div#"+x+".input_fields_wrap").removeClass('blink_me');	
			},1600);

      $('.tags_auto').autocomplete({
        source: "{!!url('admin/vitamin-search')!!}"
      });

     $( ".comp_name" ).autocomplete({
        source: "{!!url('admin/component-search')!!}"
      });
        
    });
    
    $(wrapper).on("click",".remove_btn", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent().parent().parent('div.input_fields_wrap').remove(); 
    });
	$(document).on("click",".add_vitamin", function(e){ //user click on remove text
        e.preventDefault(); 
		
		var $this=$(this);
		var this_id=$(this).parent().parent().parent('div.input_fields_wrap').attr('id');
		//alert(this_id);
		$this.parent().parent().parent('div.input_fields_wrap').append('<div class="new_panel_section"><div class="control-group"><label class="control-label" for="basicinput">Vitamin</label><div class="controls"><input class="span8 tags_auto vit_name" type="text" name="component_name['+this_id+'][vitamin][]" id="vitamin'+a+'"><a href="javascript:void(0);" class="btn btn-danger remove_vitamin">-</a></div></div><div class="control-group new_field"><label class="control-label" for="basicinput">Vitamin Weight</label><div class="controls"><input class="span8 tags_auto vit_text" type="text" name="component_name['+this_id+'][weight][]" id="weight'+a+'"></div></div></div>');

      $('.tags_auto').autocomplete({
        source: "{!!url('admin/vitamin-search')!!}"
      });
			
  	a++;
    });
	$(document).on("click",".remove_vitamin", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent().parent().parent().remove();
		vit_weightval();
    });
	
});
   </script>     

    @stop