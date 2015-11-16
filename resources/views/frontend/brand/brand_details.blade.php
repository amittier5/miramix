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
                <li><a href="{!! url()!!}/brand">Brands</a></li>
                <li>{!! $all_brand_member->fname.' '.$all_brand_member->lname;!!}</li>
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
      <div class="video-panel">
        <div class="video">
          <img class="laptop img-responsive" src="<?php echo url();?>/public/frontend/images/laptop.png" alt=""/>
          <div class="iframe_panel">
            @if($all_brand_member->youtube_link!='')
            <?php $arr = explode("=",strip_tags($all_brand_member->youtube_link)); ?>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/{!! $arr[1];!!}" frameborder="0" allowfullscreen></iframe>
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
        <?php 
            $showing_res = $limit*$pg;
            if($showing_res>$total_brand_pro)
              $showing_res = $total_brand_pro;
          if($pg==1){

            echo $pg.'–'.$showing_res.' of '.$total_brand_pro.' results';
          }
          else{
            echo ((($pg-1)*$limit) + 1).'–'.$showing_res.' of '.$total_brand_pro.' results';
          }
        //echo 'total_brand_pro=='.$total_brand_pro;
        ?></p>
        <div class="short_by">
          <p>Short By:</p>
            <select><option>Popularity</option><option>Price</option></select>
        </div>
    </div>
    <div class="product_list">
      <?php 
      if((count($product[0]))>0) 
      {
        foreach ($product as $each_product) 
        {
        ?>
      
          <div class="product">
              <div class="head_section">
                  <h2>{!! $each_product->product_name !!}</h2>
                  <p class="price"><?php echo '$'.$each_product->min_price;?> </p>
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
      <div>No Record Found.<div>
      <?php 
      }
      ?>
    </div>
    @endif
  </div>
  <?php echo $product->render(); ?>
</div>
<!-- End Products panel --> 
 </div>
@stop