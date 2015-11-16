@extends('frontend/layout/frontend_template')
@section('content')
 <script type="text/javascript" src="<?php echo url();?>/public/frontend/js/bootstrap-tokenfield.js"></script>
    <link href="<?php echo url();?>/public/frontend/css/bootstrap-tokenfield.css" rel="stylesheet">
 <link href="<?php echo url();?>/public/frontend/css/tokenfield-typeahead.css" rel="stylesheet">
    <!-- Start Home Page Slider -->
    <section class="header_section">
        <div class="overlay">
            <div class="content">
      <h2>Miramix will help you find a nutritional product <span class="test1">that is unique as you are to fit your exact wants</span></h2>
      <!--<p>Think of us as a customized service provider who supports you in the fulfillment of your nutritional goals and conquests. Whether that is ensuring you get the right servings of fruits, vegetables, or other essential ingredients for creating the perfect protein shake or making a custom multivitamin that fits your specific needs.</p>-->
      
      <div id="top_searvh_addhere"></div>
      <div class="search_panel">
        <input type="text" class="form-control textbox" placeholder="Enter your keywords" id="searchbox">
        <input type="button" class="search_button">
      </div>
      </div>
      </div>
    </section>
    <div>
    </div> 
<!-- End Home Page Slider -->       
<!-- Start Filter Spanel -->
<div class="filter_panel">
    <!--<div class="container">
        <div class="col-sm-9">
            <h2>Showing <span id="fromtorec"><?php echo $from?>–<?php echo $to?></span> of <span id="totalrec"><?php echo $total_records?></span> results</h2>
            <div class="listing_panel">
           
            </div>
        </div>
        <div class="col-sm-3">
            <div class="filter_section"><span>Short By : </span>
                <select name="sortby" id="sortby">
                <option value="popularity">Popularity</option>
                <option value="price">Price</option>
                <option value="date">Date</option>
                </select>
            </div>
        </div>
    </div>-->
    <div class="container">
    <p>Think of us as a customized service provider who supports you in the fulfillment of your nutritional goals and conquests. Whether that is ensuring you get the right servings of fruits, vegetables, or other essential ingredients for creating the perfect protein shake or making a custom multivitamin that fits your specific needs.</p>
    </div>
</div>
<!-- End Filter Spanel -->  

<div class="filter_panel for_nav_prod">
<div class="container">
        <div class="col-sm-9">
            <h2>Showing <span id="fromtorec"><?php echo $from?>–<?php echo $to?></span> of <span id="totalrec"><?php echo $total_records?></span> results</h2>
            <div class="listing_panel">
           
            </div>
        </div>
        <div class="col-sm-3">
            <div class="filter_section"><span>Short By : </span>
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
              <p class="price"><?php echo '$'.$product->min_price;?> </p>
            </div>
            <div class="image_section" style="background:url('<?php echo url();?>/uploads/product/<?php echo $product->image1?>');background-size:cover;height:240px;">
                
                <div class="image_info">
                    <a href="<?php echo url();?>/product-details/{!! $product->product_slug !!}" class="butt cart"><img src="<?php echo url();?>/public/frontend/images/icon2.png" alt=""/> Add to cart</a>
                    <a href="<?php echo url();?>/product-details/{!! $product->product_slug !!}" class="butt butt-green"><img src="<?php echo url();?>/public/frontend/images/icon3.png" alt=""/> Get Details</a>
                </div>
          </div> 
      </div>
      <?php  }?>
    </div>
      <!--<ul class="pagination pagination-sm">
        <li><a href="#"><</a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li class="active"><a href="#">4</a></li>
        <li><a href="#">5</a></li>
        <li><a href="#">></a></li>
      </ul>-->
      <?php echo $obj->paginate_function($item_per_page, $current_page, $total_records, $total_pages)?>
    </div>
</div></div>
<!-- End Products panel --> 
<div class="subscribe_panel">
    <div class="container">
        <div class="col-md-1">&nbsp;</div>
        <div class="col-md-5"><h2>Join our community to receive offers on 
products invented by people like you.</h2></div>
        <div class="col-md-6 subscribe_form">
            <input type="text" class="textbox" placeholder="Enter your email address">
            <input type="submit" value="Subscribe" class="subscribe_button">
        </div>
    </div>
</div> 
<script>
    
   $(document).ready(function(){
   $('#searchbox').on('tokenfield:createtoken', function (event) {
            var existingTokens = $(this).tokenfield('getTokens');
            $.each(existingTokens, function(index, token) {
                if (token.value === event.attrs.value)
                    event.preventDefault();
            });
        });
var temp = new Array();
var u=0;
    $('#searchbox').tokenfield({
        autocomplete: {
         
          source: function( request, response ) {
            $.ajax({
                url: "<?php echo url();?>/search-tags",
                data: {term: request.term,sortby:$("#sortby").val()},
                dataType: "json",
                success: function( data ) {
                    response( $.map( data, function( item ) {
                    
                    temp1 = item.tags.split(",");
                    //console.log(temp1);
                    //temp[u++]=temp1;
                    for (var i=0;i<temp1.length;i++){
                        temp.push(temp1[i]);    
                    }
                    
                        return {
                            label: item.value,
                            value: item.value
                        }
                    }));
                }
            });
        },
          delay: 100,
          
          close: function( event, ui ) {
            var uniqueArray = temp.filter(function(elem, pos) {

                    return temp.indexOf(elem) == pos;
                  }); 
               $(".listing_panel").html('');  
                for (var i in uniqueArray){
                    var html='<p data="'+uniqueArray[i]+'" class="alert tags" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">×</button>'+uniqueArray[i]+'</p>';
                    //$(".listing_panel").append(html);
                }
          },
		  select: function( event, ui ) {
			//alert(ui.item.value);
			var html='<p data="'+ui.item.value+'" class="alert tags" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">×</button><span class="ui_span_val">'+ui.item.value+'</span></p>';
			$("#top_searvh_addhere").append(html);
		  }
        },
        showAutocompleteOnFocus: true
      });
      $(document).on("click",'.tags', function(){
        //$('#searchbox').tokenfield('createToken', $(this).attr("data"));
         $('#top_searvh_addhere').tokenfield('createToken', $(this).attr("data"));
        //alert($('#searchbox').tokenfield('getTokensList', ';'));
      });
      
      $(".products_panel").on( "click", ".pagination a", function (e){
            e.preventDefault();
            $(".loading-div").show(); //show loading element
			$('html, body').animate({
				scrollTop: $(".loading-div").offset().top-200
			}, 2000);
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
                $(".loading-div").show(); //show loading element
           var selectedval=$('#searchbox').tokenfield('getTokensList', ',');
            $(".products_panel").load("<?php echo url();?>/",{"page":1,"_token":'{!! csrf_token() !!}',"tags":selectedval,"sortby":$("#sortby").val()}, function(){ //get content from PHP page
				$('html, body').animate({
					scrollTop: $(".products_panel").offset().top-200
				}, 400);
                $(".loading-div").hide(); //once done, hide loading element
            });
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
			var $this=$(this);
			var this_val=$this.parent().find('.ui_span_val').text();
			$('.tokenfield .token').each(function(index, element) {
                var $this=$(this);
				var this_text=$this.find('.token-label').text();
				if(this_val==this_text){
					$this.find('.close').trigger('click');	
				}				
            });
		});
		
   });

   
</script>
@stop
