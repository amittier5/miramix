@extends('frontend/layout/ajaxfrontend_template')
@section("content")
    <div class="container">
    <div class="product_list">
    <?php
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
        } ?>
    </div>
   </div>
      
      <?php echo $obj->paginate_function($item_per_page, $current_page, $total_brand_pro, $total_pages)?>
     
            <script>
            $(document).ready(function(){
                  $("#fromtorec").html('<?php echo $from?>–<?php echo $to?>');
                  $("#totalrec").html('<?php echo $total_brand_pro?>');
                  
            });
            </script>
@stop