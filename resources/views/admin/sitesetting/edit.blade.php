{!! HTML::script('resources/assets/js/ckeditor/ckeditor.js') !!} 
@extends('admin/layout/admin_template')

@section('content')
    
    <!-- jQuery Form Validation code -->
  <script>
  
  // When the browser is ready...
  $(function() {
    // Setup form validation on the #register-form element
    $("#cms_form").validate({
        
        ignore: [],
        // Specify the validation rules
        rules: {
            name: "required",
            address: {
                        required: function() 
                        {
                        CKEDITOR.instances.address.updateElement();
                        }
                    },
            value: 
                    {
                      required: true,
                      phoneUS: true
                    }
            
        },
        
        // Specify the validation error messages
        messages: {
            title: "Please enter title.",
            address: "Please enter address.",
            value: "Please enter valid phone number."
        },               

        submitHandler: function(form) {
            form.submit();
        }
    });

  });
  
  </script>

    {!! Form::model($sitesettings,['method' => 'PATCH','id'=>'cms_form','class'=>'form-horizontal row-fluid','route'=>['admin.sitesetting.update',$sitesettings->id]]) !!}
   
    <div class="control-group">
        <label class="control-label" for="basicinput">Name</label>

        <div class="controls">
             {!! Form::text('name',null,['class'=>'span8','id'=>'name']) !!}
        </div>
    </div>


    <div class="control-group">
        <label class="control-label" for="basicinput">Value</label>

        <div class="controls">
             <?php 
             //echo $sitesettings->type;
            if($sitesettings->type == 'textarea')
            {
               echo  Form::textarea('value',null,['class'=>'span8 ckeditor','id'=>snake_case($sitesettings->name)]) ;
            }
            else if($sitesettings->type == 'text')
            {
                echo  Form::text('value',null,['class'=>'span8','id'=>snake_case($sitesettings->name)]) ;
            }

            ?>
        </div>
    </div>

    

    <div class="control-group">
        <div class="controls">
            {!! Form::submit('Save', ['class' => 'btn']) !!}
           
             <a href="{!! url('admin/sitesetting')!!}" class="btn">Back</a>
           
        </div>
    </div>
        
    {!! Form::close() !!}
@stop