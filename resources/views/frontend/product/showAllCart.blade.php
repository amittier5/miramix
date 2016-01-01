@extends('frontend/layout/frontend_template')
@section('content')


<!----Fb Script Start-->

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=<?php echo env('FB_CLIENT_ID')?>";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!------------ Fb Script End ------------>


  <div class="inner_page_container">
    <div class="header_panel">
        <div class="container">
         <h2>Shopping Cart : <?php echo Session::get('share_product_id').' = '.Session::get('force_social_share'); ?></h2>
         
          </div>
    </div>   
    <!-- Start Products panel -->
    <div class="products_panel no_marg">
      <div class="container">
        <div class="product_list shop_cart">
         @if(Session::has('success'))
          <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>{!! Session::get('success') !!}</strong>
          </div>
         @endif
          @if(Session::has('error'))
          <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>{!! Session::get('error') !!}</strong>
          </div>
         @endif
         <?php 
          if(!empty($cart_result))
          {
         ?> 
         <div class="row"> 
          <div class="col-sm-9 clearfix">
          <div class="table-responsive shad_tabres hidefromtabdown">
              <table class="table table-cart">
              <thead>             
              <tr>
                  <th>Product Image</th>
                  <th>Product Name</th>
                  <th class="text-center">Brand</th>
                  <th class="text-center">Quantity</th>
                  <th>Unit Price</th>
                  <th>Total</th>
                  <th>&nbsp;</th>
                </tr>              
              </thead>
              <tbody>
                <?php
                $all_sub_total =0.00;
                $all_total =0.00;
                $coupon_amount = 0.00;
                $social_discount = 0.00;
                if(!empty($cart_result))
                { 
                  $i=1;
                  foreach($cart_result as $eachcart)
                  {
                    $all_sub_total = $all_sub_total+$eachcart['subtotal'];
                   // $all_sub_total = number_format($all_sub_total,2);
                    //$share_discount = $share_discount + $eachcart['share_discount'];
                ?>
                <tr>
                  <td><a href="<?php echo url();?>/product-details/{!! $eachcart['product_slug'] !!}"><img src="<?php echo url();?>/uploads/product/{!! $eachcart['product_image'] !!}" width="116" alt=""></a></td>
                  <td><a href="<?php echo url();?>/product-details/{!! $eachcart['product_slug'] !!}">{!! ucwords($eachcart['product_name']) !!}</a><br>
                  {!! $eachcart['duration'] !!}<br>
                  {!! $eachcart['formfactor_name'] !!}
                  
                  </td>
                  <td><a href="<?php echo url();?>/brand-details/{!! $eachcart['brand_slug'] !!}">{!! $eachcart['brand_name'] !!}</a></td>
                  <td><div class="input-group bootstrap-touchspin pull-left"><span class="input-group-addon bootstrap-touchspin-prefix"></span><input type="text" value="<?php echo $eachcart['qty']; ?>" id="cart<?php echo $i;?>" name="demo1" class="form-control demo1"></div><a href="javascript:void(0);" class="refresh_btn" onclick="updateCart('<?php echo $eachcart['rowid'];?>','cart<?php echo $i;?>')"><i class="fa fa-refresh"></i></a></td>
                  <td>${!! number_format($eachcart['price'],2) !!}</td>
                  <td>${!! number_format($eachcart['subtotal'],2) !!}</td>
                  <td><a href="javascript:void(0);" onclick="deleteCart('<?php echo $eachcart['rowid'];?>')" class="btn-link del_link"><img src="<?php echo url();?>/public/frontend/images/proddetails/dele_cart.png" alt=""></a></td>

                </tr>
                <?php 
                 $i++;
                
                  //$share_discount = $share_discount+$eachcart['share_discount'];
                 }
                
                 //echo "o= ".$share_discount;
                /*---------------------*/
                

                 if(Session::has('coupon_discount'))
                 {
                    if(($share_discount==0) || ($share_discount==''))
                    {
                      if(Session::get('coupon_type')=='P')
                      {
                        $dis_percent = Session::get('coupon_discount');

                        $dis_amnt = ($dis_percent/100) * $all_sub_total;
                        $net_amnt = $all_sub_total - $dis_amnt;
                        if($net_amnt<0)
                          $all_total = $all_sub_total;
                        else
                          $all_total = $net_amnt;


                        $coupon_amount = $dis_amnt;
                      }
                      else
                      {
                        $all_total = $all_sub_total - Session::get('coupon_discount');
                        $coupon_amount = Session::get('coupon_discount');
                      }
                    } // share coupon status if end
                    elseif(($share_discount>0) && (Session::get('share_coupon_status')==1))
                    {
                      // Show coupon+ social
                      if(Session::get('coupon_type')=='P')
                      {
                        $dis_percent = Session::get('coupon_discount');

                        $dis_amnt = ($dis_percent/100) * $all_sub_total;
                        $net_amnt = $all_sub_total - ($dis_amnt+$share_discount);
                        if($net_amnt<0)
                          $all_total = $all_sub_total;
                        else
                          $all_total = $net_amnt;


                        $coupon_amount = $dis_amnt;
                        $social_discount = $share_discount;
                      }
                      else
                      {
                        $all_total = $all_sub_total - (Session::get('coupon_discount')+$share_discount);
                        $coupon_amount = Session::get('coupon_discount');
                        $social_discount = $share_discount;
                      }
                    } // else share coupon status end 
                    elseif(($share_discount>0) && (Session::get('share_coupon_status')==0))
                    {
                      // Show  social discount
                      $all_total = $all_sub_total - $share_discount;
                      $social_discount = $share_discount;
                    } // else share coupon status end 
                  
                 }
                 else // If there is no Coupon Discount
                 {
                    if($share_discount>0)
                    {
                      $all_total = $all_sub_total - $share_discount;
                      $social_discount = $share_discount;
                    }
                    else
                    {
                      $all_total = $all_sub_total;
                      $social_discount = $share_discount;
                    }
                    
                 }
                 
                 //for redeemption
                 if(isset($cartcontent->redeem_amount) && $cartcontent->redeem_amount>0){
                 $all_total=$all_total-$cartcontent->redeem_amount;
                 }
                  
                } // empty cart if end

                ?>
                
              </tbody>
              <tfoot>
              <tr>
              <td colspan="7">
              <a href="<?php echo url();?>" class="butt pull-left">Continue Shopping</a>
              </td>
              </tr>
              </tfoot>
            </table>
          </div>

          </div>
          <div class="col-sm-3">
            <div class="row">
              <div class="right_table">
                <div class="table-responsive">
                 {!! Form::open(['url' => 'coupon-cart','method'=>'POST', 'files'=>true, 'id'=>'coupon_form']) !!}
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>Sub Total:</td>
                        <td>{!! ($all_sub_total!='')?'$':'' !!}{!! number_format($all_sub_total,2); !!}</td>
                      </tr>
                        <?php if(isset($cartcontent->redeem_amount) &&  $cartcontent->redeem_amount>0){ ?>
                          <tr>
                            <td>Redeem Discount:</td>
                            <td><?php echo '- $'.number_format($cartcontent->redeem_amount,2);?></td>
                          </tr>
                        <?php }?>
                      <?php if($share_discount > 0 ){ ?>
                      <tr>
                        <td>Social Discount:</td>
                        <td><?php echo '- $'.number_format($social_discount,2);?></td>
                      </tr>
                      <?php } ?>

                      <?php 
                      if($share_discount == 0)
                      {
                        if(Session::has('coupon_discount') && Cart::count() > 0 ){ ?>
                        <tr>
                          <td>Coupon Discount:</td>
                          <td><?php echo '- $'.number_format($coupon_amount,2);?></td>
                        </tr>
                        <?php } 
                      }
                      elseif(($share_discount > 0) && (Session::get('share_coupon_status')==1))
                      {
                      ?>
                        <tr>
                          <td>Coupon Discount:</td>
                          <td><?php echo '- $'.number_format($coupon_amount,2);?></td>
                        </tr>
                      <?php 
                      }
                      ?>

                      <tr>
                        <td>Total:</td>
                        <td>{!! ($all_total!='')?'$':'' !!}{!! number_format($all_total,2); !!}</td>
                      </tr>

                      <tr>
                        <td colspan="2" class="special-pad" align="center">Apply Coupon: </td>
                      </tr>
                      <tr>
                        <td colspan="2" class="special-pad no-bord" align="center"><div class="couponcode_apply"><input type="text" name="coupon_code" id="coupon_code" class="coupon_code" value="<?php if(Session::has('coupon_code') && Cart::count() > 0) { echo Session::get('coupon_code'); } ?>"><button type="submit" name="sub" id="sub_coupon" class="sub_coupon">Apply</button></div></td>
                      </tr>
                      
                       <!--<tr>
                        <td>Submit:</td>
                        <td><input type="submit" name="sub" value="Submit"></td>
                      </tr>-->
                    </tbody>
                  </table>
                  {!! Form::close() !!}
                  
                  {!! Form::open(['url' => 'redeem-cart','method'=>'POST', 'files'=>true, 'id'=>'redeem_form']) !!}
                  <table class="table">
                    <tbody>
                         <?php if(Session::has('member_userid')){
                         if(isset($member->user_points) && $member->user_points>0){
                         ?> 
                        <tr>
                        <td colspan="2" class="special-pad" align="center">Redeem Points: </td>
                      </tr>
                      <tr>
                        <td colspan="2" class="special-pad no-bord" align="center"><div class="couponcode_apply"><input type="number" name="user_points" id="user_points" class="coupon_code" value="" min="<?php echo $redemctrl['min']?>" max="<?php echo $redemctrl['max']?>" step="<?php echo $redemctrl['step']?>"><button type="submit" name="redeem" id="sub_coupon" class="sub_coupon">Redeem</button></div></td>
                      </tr>
                        
                        <?php }}?>
                  
                  </tbody>
                  </table>
                  {!! Form::close() !!}
                  
                  
                </div>
              </div>
              <?php //echo (Session::get('force_social_share'));
               if((($share_discount==0) || ($share_discount==''))&&(Session::get('force_social_share')==''))
              {?>
              <div class="social-share-checkout">
              <p class="social_share"><strong>Click to Share for a ${!! number_format($all_sitesetting['discount_share'],2) !!} credit on your purchase :</strong></p>
                <ul class="social_plug_new new-cart-social">
                 <li class="fb_li"><a href="javascript:void(0);" onclick="fb_share('<?php echo ucwords($all_sitesetting['FromName']);?>','<?php echo url().'/social-content';?>','<?php echo "social_share";?>');"><i class="fa fa-facebook"></i>
                 </a>
                 </li>
<g:plusone size="medium" href="" callback="myCallback"  onendinteraction="onPlusDone"></g:plusone>
                </ul>
              </div>
              <?php
              }
              ?>
            <?php if(Cart::count()>0){?>
            <a class="butt full-disp" href="<?php echo url();?>/checkout" id="proceed_check_btn">Proceed to Checkout</a>
            <?php } ?>
            </div>
          </div>
         </div>
         <?php } else {?>
         <div class="col-xs-12 text-center noprod_cart">
         <img src="<?php echo url();?>/public/frontend/images/nocart_prod.png" alt="">
         <p class="empt_shpcart">Your shopping cart is empty</p>
         <a href="<?php echo url();?>" class="butt">Continue Shopping</a>
         </div>
         <?php } ?>
        </div>
        </div>
    </div>
  </div>
  <script type="text/javascript" src="<?php echo url();?>/public/frontend/js/bootstrap.touchspin.js"></script>
  <script>
  $(document).ready(function(e) {
  
  $(document).on('click','.refresh_btn',function(){
   // $(this).parent().find(".demo1").val(0);
  });
  $(document).on('click','.del_link',function(){
    var $this=$(this);
    $this.closest('tr').remove();
  }); 
  
    $("input[name='demo1']").TouchSpin({
        min: 1,
        max: 100,
        boostat: 5,
        maxboostedstep: 10
    });
    
    $("#user_points").ForceNumericOnly();
  });    

/*------------ UPDATE CART THROUGH AJAX START -----------------*/
  function updateCart(rowid,fieldid)
  {
    var rowid = rowid;
    var quantity = $("#"+fieldid).val();
    //alert(rowid+' '+quantity);
    $.ajax({
        url: '<?php echo url();?>/updateCart',
        type: "post",
        data: { rowid : rowid , quantity : quantity ,_token: '{!! csrf_token() !!}'},
        success:function(data)
        {
       // alert(data);
          if(data !='' ) 
          {
            window.location.href = "<?php echo url()?>/show-cart";
          }
        }
      });
  }
/*------------ UPDATE CART THROUGH AJAX END -----------------*/

/*-----------------  DALETE CART THROUGH AJAX START --------------*/
  function deleteCart(rowid)
  {
    var rowid = rowid;
    $.ajax({
        url: '<?php echo url();?>/deleteCart',
        type: "post",
        data: { rowid : rowid ,_token: '{!! csrf_token() !!}'},
        success:function(data)
        {
        //alert(data);
          if(data !='' ) 
          {
            window.location.href = "<?php echo url()?>/show-cart";
          }
        }
      });
  }
/*-----------------  DALETE CART THROUGH AJAX END --------------*/
   
   jQuery.fn.ForceNumericOnly =
function()
{
    return this.each(function()
    {
        $(this).keydown(function(e)
        {
            var key = e.charCode || e.keyCode || 0;
            // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
            // home, end, period, and numpad decimal
            return (
                key == 8 || 
                key == 9 ||
                key == 13 ||
                key == 46 ||
                key == 110 ||
                key == 190 ||
                (key >= 35 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
        });
    });
};

</script>

<!-------------------- for google Call back Start  ---------------------->

<script type="text/javascript">
     function onPlusDone(reponse) {
          console.log(reponse);

            var res = 'success';
             $.ajax({
                    type:"POST",
                    dataType: "json",
                    url: '<?php echo url();?>/saveShare',
                    data: { product_id : 'social_share' ,_token: '{!! csrf_token() !!}'},

                    success:function(result){
                        if(data!='')
                        window.location = "<?php echo url().'/show-cart' ?>";

                    }
                })
      }
     function myCallback(jsonParam) {

         console.log("URL: " + jsonParam.href + " state: " + jsonParam.state);

      }
</script>

<!-------------------- for google Call back End ---------------------->

<script>
function fb_share(product_name,url,product_id) {
  FB.ui(
  {
    method: 'share',
    name: product_name,
    href: url,
    product_id: product_id
  },
  
  function(response) {
    if (response && !response.error_code) 
    {
      $.ajax({
        url: '<?php echo url();?>/saveShare',
        type: "post",
        data: { product_id : product_id ,_token: '{!! csrf_token() !!}'},
        success:function(data)
        {
          //alert(data);
          if(data!='')
          window.location = "<?php echo url().'/show-cart' ?>";

        }
      });
    } // end of if response
  }
);

}
</script>

<!--------Google Share -------->

<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script> 



<!--------Google Share -------->
 @stop