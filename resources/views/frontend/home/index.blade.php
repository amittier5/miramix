@extends('frontend/layout/frontend_template')
@section('content')
 <script type="text/javascript" src="<?php echo url();?>/public/frontend/js/bootstrap-tokenfield.js"></script>
 <script type="text/javascript" src="<?php echo url();?>/public/frontend/js/jquery.bxslider.min.js"></script>
    <link href="<?php echo url();?>/public/frontend/css/bootstrap-tokenfield.css" rel="stylesheet">
 <link href="<?php echo url();?>/public/frontend/css/tokenfield-typeahead.css" rel="stylesheet">
 <link href="<?php echo url();?>/public/frontend/css/jquery.bxslider.css" rel="stylesheet">
    <!-- Start Home Page Slider -->
    <section class="header_section">
        <div class="overlay">
            <div class="content">
      <h2>Miramix is a custom nutritional marketplace,<span class="test1"> search our platform to find your miracle mix</span></h2>
      <!--<p>Think of us as a customized service provider who supports you in the fulfillment of your nutritional goals and conquests. Whether that is ensuring you get the right servings of fruits, vegetables, or other essential ingredients for creating the perfect protein shake or making a custom multivitamin that fits your specific needs.</p>-->
      
      
      <div class="search_panel">
        <input type="text" class="form-control textbox" placeholder="Enter any feeling, ingredient, or brand" maxlength="40" id="searchbox">
        <input type="button" class="search_button">
      </div>
      
      <div id="for_slider">
      	<div class="owl-carousel">
        
        </div>
      </div>
      </div>
      </div>
    </section>
    <div>
    </div> 
<!-- End Home Page Slider -->       
<!-- Start Filter Spanel -->
<div class="filter_panel">
    
    <div class="container">
    <p>We'll help you find whatever nutritient blend you can ever imagine. We currently have the capability to create over a googolplexian ( yes seriously!) products. Just ask and we’ll deliver.</p>
    </div>
</div>
<!-- End Filter Spanel -->  

<div class="filter_panel for_nav_prod">
<div class="container">
        <div class="col-sm-9 formobile-col-sm-9">
            <h2>Showing <span id="fromtorec"><?php echo $from?>–<?php echo $to?></span> of <span id="totalrec"><?php echo $total_records?></span> results</h2>
            <div class="listing_panel">
           
            </div>
        </div>
        <div class="col-sm-3 formobile-col-sm-3">
            <div class="filter_section"><span>Sort By : </span>
                <select name="sortby" id="sortby">
                <option value="popularity">Popularity</option>
                <option value="price">Price</option>
                <option value="date">Date</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Start Products panel -->
<div class="tot_prod_load"><div class="loading-div" style="display:none"><img src="<?php echo url();?>/public/frontend/css/images/loader_productlist.GIF" alt=""></div>
<div class="products_panel">
    <div class="container">
    <div class="product_list">
    <?php foreach($products as $product){ ?>
      <div class="product">
            <div class="head_section">
              <h2><?php echo $product->product_name?></h2>
              <p class="price">Starting at <?php echo '$'.number_format($product->min_price*7,2);?> </p>
            </div>
            <div class="image_section" style="background:url('<?php echo url();?>/uploads/product/home_thumb/<?php echo $product->image1?>');background-size:cover;height:240px;">
                
                <div class="image_info">
                    <a href="<?php echo url();?>/product-details/{!! $product->product_slug !!}" class="butt cart"><img src="<?php echo url();?>/public/frontend/images/icon2.png" alt=""/> Add to cart</a>
                    <a href="<?php echo url();?>/product-details/{!! $product->product_slug !!}" class="butt butt-green"><img src="<?php echo url();?>/public/frontend/images/icon3.png" alt=""/> Get Details</a>
                </div>
          </div> 
      </div>
      <?php  }?>
    </div>
      
      <?php echo $obj->paginate_function($item_per_page, $current_page, $total_records, $total_pages)?>
    </div>
</div></div>
<!-- End Products panel --> 
<div class="subscribe_panel">
    <div class="container">
        
        <div class="col-sm-6 col-md-5 col-md-offset-1"><h2>Join our community to receive offers on 
products invented by people like you.</h2></div>
        <div class="col-sm-6 col-md-6 subscribe_form">
	    {!! Form::open(['url' => 'newsletterajax','method'=>'POST', 'id'=>'newsform', 'autocomplete'=>'off']) !!}
            <input type="text" class="textbox" placeholder="Enter your email address" name="newsemail" id="newsemail">
		<div id="nmsg"></div>
            <input type="submit" value="Subscribe" class="subscribe_button">
	   {!! Form::close() !!}
        </div>
    </div>
</div> 
<script>
    var slide_html='';
	var tot_slideitem=[];
	var item_count=0;
	var sliderActive = false;
	var slider;
	 var config= {  
	 	auto: false,
		controls: true,
		pager:false,
		adaptiveHeight:true,
		onSliderLoad: function(){
			sliderActive = true;
		}
	 };
			  
   $(document).ready(function(){
    
     $.validator.addMethod("email", function(value, element) 
    { 
    return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value); 
    }, "Please enter a valid email address.");

    // Setup form validation  //
    $("#newsform").validate({
    
        // Specify the validation rules
        rules: {
            newsemail: 
            {
                required : true,
                email: true
            },
         
            
        },
        
	 submitHandler: function(form) {
          $.ajax({
			    url: "<?php echo url();?>/newsletterajax",
			    data: {newsemail:$("#newsemail").val(),_token: '{!! csrf_token() !!}'},
			    dataType: "json",
			    type :"post",
			    success: function( data ) {
				if (data.status=='success'){
				    $("#nmsg").removeClass("error");
				    $("#nmsg").html(data.message);
           // $("#mce-EMAIL").val($("#newsemail").val());
           // $("#mc-embedded-subscribe-form").submit();
            $("#newsemail").val("");
				}
				if (data.status=='fail'){
				    $("#nmsg").addClass("error");
				    $("#nmsg").html(data.message);
            $("#newsemail").val("");
				}
				
			    }
			});
	
          return false;
      }
    });
    
    
    
    
   $('#searchbox').on('tokenfield:createtoken', function (event) {
            var existingTokens = $(this).tokenfield('getTokens');
            $.each(existingTokens, function(index, token) {
                if (token.value === event.attrs.value || existingTokens.length>=3)
                    event.preventDefault();
            });
        });
	$('#searchbox').on('tokenfield:removedtoken', function (event) {
		//$(".search_button").trigger("click");
		search_product();
	});
       
        
var temp = new Array();
var u=0;
    $('#searchbox').tokenfield({
		minWidth: 290,
        autocomplete: {
         
          source: function( request, response ) {
            $.ajax({
                url: "<?php echo url();?>/search-tags",
                data: {term: request.term,sortby:$("#sortby").val()},
                dataType: "json",
                success: function( data ) {
                    response( $.map( data, function( item ) {
                    
                   /* temp1 = item.tags.split(",");
                    //console.log(temp1);
                    //temp[u++]=temp1;
                    for (var i=0;i<temp1.length;i++){
                        temp.push(temp1[i]);    
                    }*/
                    
                        return {
                            label: item.value,
                            value: item.value
                        }
                    }));
                }
            });
        },
          delay: 100,
		  create: function (ul,item) {
			  //tot_slideitem=[];
			  //item_count=0;
				$(this).data('ui-autocomplete')._renderItem = function (ul, item) {
					
					
					//ul.addClass('swiper-container');
					
					
						
					//tot_slideitem[item_count++]=item.value;	
					//create_slider();
						//alert(item_count);
						
				  return $('<div class="swiper-slide">')
						  .append(item.value)
						  .appendTo(ul);
				};
				
				
				
				
      }, 
          close: function( event, ui ) {
			 //alert(); 
			tot_slideitem=[];
			//$('#for_slider .owl-carousel').empty();
            var uniqueArray = temp.filter(function(elem, pos) {

                    return temp.indexOf(elem) == pos;
                  }); 
               $(".listing_panel").html('');  
                for (var i in uniqueArray){
                    var html='<p data="'+uniqueArray[i]+'" class="alert tags" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">×</button>'+uniqueArray[i]+'</p>';
                    //$(".listing_panel").append(html);
                }
				//slider.destroySlider();
				//$owl.removeAttr('style');
          },
		  open: function( event, ui ) {
			  tot_slideitem=[];
			  item_count=0;
			  //alert();
			  //$('#for_slider .swiper-wrapper').append(slide_html);
			  $(".ui-menu-divider").remove();
			  
			  $('.swiper-slide').each(function(index, element) {
				var $this=$(this); 
				//alert($this.text());
				if($this.hasClass('ui-menu-divider')){}
				else 
                tot_slideitem[item_count++]=$this.text();
              });
			  
			 
			  create_slider();
			  
			  
			  
		},
		  select: function( event, ui ) {
			  $(".search_button").trigger("click");
		  }
        }
        //showAutocompleteOnFocus: true
      });
	  
	  function create_slider(){
		$('#for_slider .owl-carousel').empty();
		for(var i=0;i<tot_slideitem.length;i++){
					for(var x=0;x<=8;x++){
						if(typeof tot_slideitem[i] === 'undefined') {
							// does not exist
						}
						else {
							slide_html=slide_html+'<div class="inn_owl-item">'+tot_slideitem[i]+'</div>';
						}							
						i++;
					}
					slide_html='<div class="inner-item">'+slide_html+'</div>';
					//alert(slide_html);
					$('#for_slider .owl-carousel').append(slide_html);
					
					slide_html='';
				}
			//alert($('#for_slider .owl-carousel').html());
			  //$('.swiper-slide').wrap("<div class='new'></div>");
			  
				  if(sliderActive === false) {
					  
					slider=$('#for_slider .owl-carousel').bxSlider({
						auto: false,
						controls: true,
						pager:false,
						adaptiveHeight:true,
						onSliderLoad: function(){
							sliderActive = true;
						}
					}); 
				  }
				  else{
					slider.reloadSlider(config);	  
				  }
				  
			  
	  }
	function search_product(){
		 $(".loading-div").show(); //show loading element
           var selectedval=$('#searchbox').tokenfield('getTokensList', ',');
            $(".products_panel").load("<?php echo url();?>/",{"page":1,"_token":'{!! csrf_token() !!}',"tags":selectedval,"sortby":$("#sortby").val()}, function(){ 
			
                $(".loading-div").hide(); //once done, hide loading element
			
            });
	}
	
      $(document).on("click",'.inn_owl-item', function(){
        $('#searchbox').tokenfield('createToken', $(this).text());
         //$('#top_searvh_addhere').tokenfield('createToken', $(this).attr("data"));
        //alert($('#searchbox').tokenfield('getTokensList', ';'));
		search_product();
        tagPopularity($(this).text());
      });
      
      $(".products_panel").on( "click", ".pagination a", function (e){
            e.preventDefault();
            $(".loading-div").show(); //show loading element
			/*$('html, body').animate({
				scrollTop: $(".loading-div").offset().top-200
			}, 2000);*/
            var page = $(this).attr("data-page"); //get page number from link
            var selectedval=$('#searchbox').tokenfield('getTokensList', ',');
			setTimeout(function(){
            $(".products_panel").load("<?php echo url();?>/",{"page":page,"_token":'{!! csrf_token() !!}',"tags":selectedval,"sortby":$("#sortby").val()}, function(){
            //get content from PHP page
                $(".loading-div").hide(); //once done, hide loading element
            });
			},2500);
           
        });
        
        $(".search_button").click(function(){
			//alert();
			if($('.token').length>0){
                $(".loading-div").show(); //show loading element
           var selectedval=$('#searchbox').tokenfield('getTokensList', ',');
            $(".products_panel").load("<?php echo url();?>/",{"page":1,"_token":'{!! csrf_token() !!}',"tags":selectedval,"sortby":$("#sortby").val()}, function(){ //get content from PHP page
			
				$('html, body').animate({
					scrollTop: $(".products_panel").offset().top-200
				}, 400);
			
                $(".loading-div").hide(); //once done, hide loading element
			
            });
			}
        });
        $("#sortby").on("change",function(){
                var sort=$(this).val();
                $(".loading-div").show();
				$('html, body').animate({
					scrollTop: $(".loading-div").offset().top-200
				}, 2000);
				setTimeout(function(){
					$(".products_panel").load("<?php echo url();?>/",{"page":1,"_token":'{!! csrf_token() !!}',"tags":selectedval,"sortby":$("#sortby").val()}, function(){
					//get content from PHP page
						$(".loading-div").hide(); //once done, hide loading element
					});
				},2500);
                var selectedval=$('#searchbox').tokenfield('getTokensList', ',');
                
                
        });
		$(document).on("click",'.home .header_section .content p.alert.tags button.close',function(){
			//alert();
			//var $this=$(this);
			//var this_val=$this.parent().find('.ui_span_val').text();
			/*$('.tokenfield .token').each(function(index, element) {
                var $this=$(this);
				var this_text=$this.find('.token-label').text();
				if(this_val==this_text){
					$this.find('.close').trigger('click');	
				}				
            });*/
		});
		
   });

   /* On Selecting tag Popularity Start */

   function tagPopularity(tag)
   {
    //alert(tag);
    
    $.ajax({
        url: '<?php echo url();?>/tag-popularity',
        type: "post",
        data: {tag:tag,_token: '{!! csrf_token() !!}'},
        success:function(data)
        {
          //alert(data);
        }
      });

   }

   /* On Selecting tag Popularity End */
</script>

<style>
.swiper-container {
        width: 100%;
        height: auto;
        margin-left: auto;
        margin-right: auto;
    }
    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;
        height: 200px;
        
        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }
</style>


@stop
