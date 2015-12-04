@extends('frontend/layout/frontend_template')
@section('content')
<?php  
//echo $_REQUEST['page']; exit;
if(isset($_REQUEST['page'])){
  $pg = $_REQUEST['page'];
}
else{
  $pg = 1;
}
if(isset($_REQUEST['page']))
{
?>
  <script>
  $( document ).ready(function() {
  $('html, body').animate({scrollTop: $("#brand_show").offset().top}, 2000);
});
  </script>
<?php
}
?>
<!-- End Header Section -->
    <div class="inner_page_container">
      <div class="header_panel">
          <div class="container">
           <h2>Brands</h2>
             <ul class="breadcrumb">
                <li><a href="{!! url()!!}">Home</a></li>
                <li><a href="{!! url()!!}/brands">Brands</a></li>
                <li>{!! $all_brand_member->business_name;!!}</li>
             </ul>
            </div>
        </div>
          
<!-- Start Products panel -->
<div class="products_panel">

  <div class="container">
    <div class="brand_details_info">
      <p class="text-center">{!! $all_brand_member->brand_details;!!}</p>
      @if($all_brand_member->brand_sitelink!='')
      <p class="text-center">
          Please visit <a href="{!! $all_brand_member->brand_sitelink;!!}" target="blank">{!! $all_brand_member->brand_sitelink;!!}</a> for more information
      </p>
      @endif
      <div class="links_brands">@if($all_brand_member->youtube_link!='')
      <p class="text-center you_brand">
         <a href="{!! $all_brand_member->youtube_link;!!}" target="blank"><i class="fa fa-youtube-play"></i></a>
      </p>
      @endif
      @if($all_brand_member->facebook_url!='')
      <p class="text-center face_brand">
          <a href="{!! $all_brand_member->facebook_url;!!}" target="blank"><i class="fa fa-facebook-square"></i></a>
      </p>
      @endif
      @if($all_brand_member->twitter_url!='')
      <p class="text-center twit_brand">
          <a href="{!! $all_brand_member->twitter_url;!!}" target="blank"><i class="fa fa-twitter"></i></a>
      </p>
      @endif
      @if($all_brand_member->linkedin_url!='')
      <p class="text-center link_brand">
          <a href="{!! $all_brand_member->linkedin_url;!!}" target="blank"><i class="fa fa-linkedin-square"></i></a>
      </p>
      @endif</div>
      <div class="video-panel">
        <div class="video">
          <img class="laptop img-responsive" src="<?php echo url();?>/public/frontend/images/laptop.png" alt=""/>
          <div class="iframe_panel">
            @if($all_brand_member->youtube_link!='')
            <?php $arr = explode("=",strip_tags($all_brand_member->youtube_link));
            if(isset($arr[1])){
            ?>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/{!! $arr[1];!!}" frameborder="0" allowfullscreen></iframe>
              <?php }else{?>
              <iframe width="560" height="315" src="https://www.youtube.com/embed/qMYwIoPSkFM" frameborder="0" allowfullscreen></iframe>
              <?php }?>
            @else
            <iframe width="560" height="315" src="https://www.youtube.com/embed/qMYwIoPSkFM" frameborder="0" allowfullscreen></iframe>
            @endif 
          </div>
        </div>
      </div>
    </div>
    @if($total_brand_pro<=0)
    <div class="populer_panel">
      <p class="pull-left">No Product found.</p>
    </div>
    @else
    <div class="populer_panel" id="brand_show">
      <p class="pull-left">Showing 
        <span id="fromtorec"><?php echo $from?>–<?php echo $to?></span> of <span id="totalrec"><?php echo $total_brand_pro?></span> results</p>
        <div class="short_by">
          <p>Sort By:</p>
            <select id="sortby" name="sortby" >
            <option value="popularity">Popularity</option>
                <option value="price">Price</option>
                <option value="date">Date</option>
            </select>
        </div>
    </div>
    <div class="product_list ajax_content" id="">
    <div class="loading-div" style="display:none"><img src="<?php echo url();?>/public/frontend/images/load_genearted.GIF" alt=""></div>
      <?php 
      if((count($product[0]))>0) 
      {
        foreach ($product as $each_product) 
        {
        ?>
      
          <div class="product">
              <div class="head_section">
                  <h2 title="{!! $each_product->product_name !!}">{!! $each_product->product_name !!}</h2>
                  <p class="price">Starting at <?php echo '$'.number_format((float)$each_product->min_price*7,2);?> </p>
                  </div>
                <div class="image_section" style="background:url(<?php echo url();?>/uploads/product/{!! $each_product->image1 !!}) no-repeat center center; background-size:cover;height:240px;" >
                  <!--<img src="<?php echo url();?>/uploads/product/{!! $each_product->image1 !!}" alt=""/>-->
                    <div class="image_info">
                      <?php if($brandlogin == 0) {?>
                      <a href="<?php echo url();?>/product-details/{!! $each_product->product_slug !!}" class="butt cart"><img src="<?php echo url();?>/public/frontend/images/icon2.png" alt=""/> Add to cart</a>
                      <?php } ?>
                        <a href="<?php echo url();?>/product-details/{!! $each_product->product_slug !!}" class="butt butt-green"><img src="<?php echo url();?>/public/frontend/images/icon3.png" alt=""/> View Details</a>
                    </div>
              </div> 
          </div>

        <?php 
        } 
      }
      else
      {
      ?>
      <div>No Record Found.</div>
      <?php 
      }
      ?>
    <?php echo $obj->paginate_function($item_per_page, $current_page, $total_brand_pro, $total_pages)?>  
    </div>
    @endif
    
  </div>
 
  
</div>
<!-- End Products panel --> 
 </div>
  
  <script>
  $(document).ready(function(){
    $(".products_panel").on( "click", ".pagination a", function (e){
            e.preventDefault();
            $(".loading-div").show(); //show loading element
			
            var page = $(this).attr("data-page"); //get page number from link
           
			setTimeout(function(){
            $(".ajax_content").load("<?php echo url();?>/brand-details/<?php echo $brand_slug?>",{"page":page,"_token":'{!! csrf_token() !!}',"sortby":$("#sortby").val()}, function(){
            //get content from PHP page
                $(".loading-div").hide(); //once done, hide loading element
            });
			},2500);
           
        });
        
        $("#sortby").on("change",function(){
                var sort=$(this).val();
                $(".loading-div").show();
				
				setTimeout(function(){
					$(".ajax_content").load("<?php echo url();?>/brand-details/<?php echo $brand_slug?>",{"page":1,"_token":'{!! csrf_token() !!}',"sortby":$("#sortby").val()}, function(){
					//get content from PHP page
						$(".loading-div").hide(); //once done, hide loading element
					});
				},2500);
                
        });
});
  </script>
@stop