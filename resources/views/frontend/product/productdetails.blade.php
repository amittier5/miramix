@extends('frontend/layout/frontend_template')
@section('content')
<?php //echo "<pre/>"; print_r($productdetails); exit;
//print_r($productformfactor);  exit;?>

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


<script src="<?php echo url();?>/public/frontend/js/jquery.raty.js"></script> 
<script src="<?php echo url();?>/public/frontend/js/jquery.elevatezoom.js"></script>
<link href="<?php echo url();?>/public/frontend/css/jquery.raty.css" rel="stylesheet">
<div class="inner_page_container">
  <div class="header_panel">
    <div class="container">
      <h2>Brands</h2>
      <ul class="breadcrumb">
        <li><a href="<?php echo url();?>">Home</a></li>
        <li><a href="<?php echo url();?>/{!! $productdetails->slug !!}">Brands</a></li>
        <li>{!! ucwords($productdetails->product_name) !!}</li>
      </ul>
    </div>
  </div>

  

  <!-- Start Products panel -->
  <div class="products_panel nopad_bot">
    <div class="container"> 
      <!--top_proddetails-->
      <div class="top_proddetails">
        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="main_img"> <img src="<?php if(($productdetails->image1 !='') && (file_exists('uploads/product/'.$productdetails->image1))) {?><?php echo url();?>/uploads/product/{!! $productdetails->image1 !!}<?php } ?>" class="img-responsive" alt=""> </div>
            <div class="sub_img clearfix">
              <?php if(($productdetails->image1 !='') && (file_exists('uploads/product/'.$productdetails->image1))) {?>
              <a href="javascript:void(0);" class="pull-left img_bord" data-rel="<?php echo url();?>/uploads/product/{!! $productdetails->image1 !!}"><img src="<?php echo url();?>/uploads/product/thumb/{!! $productdetails->image1 !!}" alt=""></a>
              <?php } ?>
              <?php if(($productdetails->image2 !='') && (file_exists('uploads/product/'.$productdetails->image2))) {?>
              <a href="javascript:void(0);" class="pull-left img_bord" data-rel="<?php echo url();?>/uploads/product/{!! $productdetails->image2 !!}"><img src="<?php echo url();?>/uploads/product/thumb/{!! $productdetails->image2 !!}" alt=""></a>
              <?php } ?>
              <?php if(($productdetails->image3 !='') && (file_exists('uploads/product/'.$productdetails->image3))) {?>
              <a href="javascript:void(0);" class="pull-left img_bord" data-rel="<?php echo url();?>/uploads/product/{!! $productdetails->image3 !!}"><img src="<?php echo url();?>/uploads/product/thumb/{!! $productdetails->image3 !!}" alt=""></a>
              <?php } ?>
              <?php if(($productdetails->image4 !='') && (file_exists('uploads/product/'.$productdetails->image4))) {?>
              <a href="javascript:void(0);" class="pull-left img_bord" data-rel="<?php echo url();?>/uploads/product/{!! $productdetails->image4 !!}"><img src="<?php echo url();?>/uploads/product/thumb/{!! $productdetails->image4 !!}" alt=""></a>
              <?php } ?>
              <?php if(($productdetails->image5 !='') && (file_exists('uploads/product/'.$productdetails->image5))) {?>
              <a href="javascript:void(0);" class="pull-left img_bord" data-rel="<?php echo url();?>/uploads/product/{!! $productdetails->image5 !!}"><img src="<?php echo url();?>/uploads/product/thumb/{!! $productdetails->image5 !!}" alt=""></a>
              <?php } ?>
              <?php if(($productdetails->image6 !='') && (file_exists('uploads/product/'.$productdetails->image6))) {?>
              <a href="javascript:void(0);" class="pull-left img_bord" data-rel="<?php echo url();?>/uploads/product/{!! $productdetails->image6 !!}"><img src="<?php echo url();?>/uploads/product/thumb/{!! $productdetails->image6 !!}" alt=""></a>
              <?php } ?>
            </div>
            <div class="bordered_panel clearfix special_add">
              <p class="spec_text">Tags: <span>{!! rtrim($productdetails->tags,',') !!}</span></p>
              <p class="social_share"><strong>Click to Share for a ${!! number_format($all_sitesetting['discount_share'],2) !!} credit on your purchase :</strong></p>
              <ul class="social_plug_new">
                 <li class="fb_li"><a href="javascript:void(0);" onclick="fb_share('<?php echo ucwords($productdetails->product_name);?>','<?php echo url().'/product-details/'.$productdetails->product_slug;?>','<?php echo ($productdetails->id);?>');"><i class="fa fa-facebook-square"></i>
                 <span> Share this on facebook </span>
                 </a>
                 </li>
<!-- 
                 <li class="goog_li"><a href="javascript:void(0)" id="signin" ><i class="fa fa-google-plus-square"></i></a>
                <div id="plusone-div"></div></li> -->

                <!-- <li> <a id="ref_gp" data-product="<?php // echo $productdetails->id;?>" href="https://plus.google.com/share?url=<?php echo url().'/product-details/'.$productdetails->product_slug;?>" 
onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=yes,height=400,width=600');return false"><i class="fa fa-google-plus"></i></a></li> -->

<g:plusone size="medium" href="<?php echo url().'/product-details/'.$productdetails->product_slug;?>" callback="myCallback"  onendinteraction="onPlusDone"></g:plusone>

              </ul>
            </div>
          </div>

         
    
          <div class="col-md-6 col-sm-12 pad_top">
            <div class="bordered_panel clearfix">
              <div class="top_panel_border clearfix">
                <h3 class="pull-left">{!! ucwords($productdetails->product_name) !!}</h3>
                <p class="spec_prc pull-right">$ <small id="min_val">{!! sprintf("%.2f",($productformfactor[0]->actual_price)*($timeduration[0]->no_of_days)) !!} </small><span id="min_val2">/ {!! $timeduration[0]->name !!}</span></p>
              </div>
              <div class="bot_panel">
                <ul class="nav nav-tabs" id="myTab">
                  <?php $i= 1; 
          foreach($productformfactor as $eachformfactor){
            if($i ==1)
              $active = "active";
            else
              $active = "";
          ?>
                  <li class="<?php echo $active;?>"><a data-toggle="tab" href="#section<?php echo $eachformfactor->id?>" onclick="changeval('<?php echo $eachformfactor->id;?>','<?php echo $eachformfactor->actual_price;?>','<?php echo $eachformfactor->product_id;?>','<?php echo trim($eachformfactor->product_name); ?>','<?php echo $eachformfactor->formfactor_id?>')"><img src="<?php echo url();?>/uploads/formfactor/{!! $eachformfactor->image !!}" alt=""></a></li>
                  <?php $i++;} ?>
                </ul>
                <form id="form1" action="">
                  <div class="tab-content" id="myTabContent">
                    <?php 
        $i= 1; 
        foreach($productformfactor as $eachformfactor)
         { 
            if($i ==1)
              $in_active = "in active";
            else
              $in_active = "";
        ?>
                    <div id="section<?php echo $eachformfactor->id?>" class="tab-pane fade <?php echo $in_active;?>">
                      <ul class="list-group" id="duration<?php echo $eachformfactor->id ?>">
                        <?php 
                foreach($timeduration as $eachduration){
                  if($eachduration->no_of_days==90){
                    $total_price = $eachduration->no_of_days*$productformfactor[0]->actual_price;

                    $percen_amnt = 0.17*$total_price;

                    $net_price = $total_price - $percen_amnt;

                  }
                  else{

                      $net_price = $eachduration->no_of_days*$productformfactor[0]->actual_price;
                  }
              ?>
                        <li class="list-group-item clearfix"><span class="pull-left">{!! $eachduration->name !!}</span><span class="pull-right" data-duration="{!! ($eachduration->name)!!}" data-days="{!! ($eachduration->no_of_days) !!}" data-product-id="{!! ($eachformfactor->product_id)!!}" data-product="{!! ($eachformfactor->product_name)!!}" data-formfactor="{!! ($eachformfactor->formfactor_id)!!}" data-money="{!! sprintf("%.2f",$net_price)!!}"> {!! '$'.sprintf("%.2f",$net_price)!!}</span></li>
                        <?php } ?>
                      </ul>
                    </div>
                    <?php 
        $i++;
        } 
        ?>
                  </div>
                </form>
                <div class="row">
                  <div class="total_top">
                    <div class="col-sm-8 price_panel">
                      <p class="pull-left price_pan" data-money="5.20">$5.20</p>
                      <div id="incdec" class="col-sm-6"> <a href="javascript:void(0);" id="down" class="pull-left incremt_a"><i class="fa fa-minus"></i></a>
                        <div class="col-sm-10" id="increment_input">
                          <input type="text" class="form-control text-center" value="1"  id="qty" readonly/>
                        </div>
                        <a href="javascript:void(0);" id="up" class="pull-left incremt_a"><i class="fa fa-plus"></i></a> </div>
                      <p id="result">=&nbsp;$5.00</p>
                    </div>
                    <div class="col-sm-4">
                      <?php if($brandlogin == 0) {?>
                      <button type="button" class="butt cart" id="add_cart"  onclick="addCart()"><img src="<?php echo url();?>/public/frontend/images/icon2.png" alt="">Add to cart<span id="no_dis_orig"><i class="fa fa-check"></i>Product Added</span></button>
                      <?php } ?>
                      <!----------------------- ADD TO CART ALL VALUE HIDDEN START ---------------------------->
                      
                      <input type="hidden" name="product_id" id="product_id" value=""/>
                      <input type="hidden" name="quantity" id="quantity" value=""/>
                      <input type="hidden" name="product_name" id="product_name" value=""/>
                      <input type="hidden" name="amount" id="amount" value=""/>
                      <input type="hidden" name="duration" id="duration" value=""/>
                      <input type="hidden" name="no_of_days" id="no_of_days" value=""/>
                      <input type="hidden" name="form_factor" id="form_factor" value=""/>
                      
                      <!----------------------- ADD TO CART ALL VALUE HIDDEN START ----------------------------> 
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--top_proddetails--> 
      
      <!--mid_panel-->
      <div class="mid_panel">
        <div class="row">
          <div class="total_block">
            <div class="col-sm-6 lefted_img"> <img src="<?php echo url();?>/uploads/product/{!! $productdetails->image1 !!}" class="img-responsive" alt=""> </div>
            <div class="col-sm-6 righted_text">
              <p>{!! ucfirst($productdetails->description1) !!}</p>
            </div>
          </div>
          <div class="total_block">
            <div class="col-sm-6 lefted_img col-sm-push-6"> <img src="<?php echo url();?>/uploads/product/{!! $productdetails->image2 !!}" class="img-responsive" alt=""> </div>
            <div class="col-sm-6 righted_text col-sm-pull-6">
              <p>{!! ucfirst($productdetails->description2) !!}</p>
            </div>
            
          </div>
          <div class="total_block">
            <div class="col-sm-6 lefted_img"> <img src="<?php echo url();?>/uploads/product/{!! $productdetails->image3 !!}" class="img-responsive" alt=""> </div>
            <div class="col-sm-6 righted_text">
              <p>{!! ucfirst($productdetails->description3) !!}</p>
            </div>
          </div>
        </div>
      </div>
      <!--mid_panel--> 
      
    </div>

    <!--accnt_desc panel-->
    <section class="accnt_desc">
      <div class="container">
        <div class="acct_text">
          <?php if(($productdetails->pro_image !='') && (file_exists('uploads/brandmember/'.$productdetails->pro_image))) {
      $brand_profile_image = $productdetails->pro_image;
      }
      else
      {
        $brand_profile_image ='noimage.png';
      } 
    ?>
          <div class="acct_img" style="background:url(<?php echo url();?>/uploads/brandmember/{!! $brand_profile_image !!}) no-repeat 0 0;background-size:cover;"></div>
          <h4>{!! ucwords($productdetails->business_name) !!}</h4>
          <p>{!! ucfirst($productdetails->brand_details) !!}</p>
        </div>
      </div>
    </section>
    <!--accnt_desc panel-->
    
    <div class="container"> 
      <!--bottom_panel_rev-->
      <div class="bottom_panel_rev">
        <div class="row">
          <div class="col-sm-6 review_block">
            <h6>Reviews</h6>
            <div class="avrating_box">
              <p class="pull-left">Average rating</p>
              <?php
          $rval=0;
          foreach($rating as $prate){
          $rval +=$prate->rating_value;
          }
          if($rval>0){
          $avg=$rval/count($rating);
          }else{
          $avg=0;
          }
          ?>
              <div id="avgrate"></div>
              <script>
             $(document).ready(function(){
                $('#avgrate').raty({
                readOnly: true,
                score: <?php echo $avg?>,
                starHalf    : '<?php echo url();?>/public/frontend/css/images/star-half.png',
                starOff     : '<?php echo url();?>/public/frontend/css/images/star-off.png',
                starOn      : '<?php echo url();?>/public/frontend/css/images/star-on.png'  , 
                });
                
                });
          </script> 
              <small>(Based on <?php echo count($rating);?> Reviews)</small> </div>
            <?php if(count($rating)>0) {?>
            <div class="news_list">
              <div class="wrap_load"><a href="javascript:void(0);" class="btn btn-special loadmore" data-page="0">View More Reviews</a> <span class="disable_click"></span></div>
            </div>
            <?php } ?>
          </div>
          <div class="col-sm-6 suppl_facts">
            <h6>Supplement Facts</h6>
            <!--supp_box-->
            <div class="supp_box">
              <?php if(($productdetails->label !='') && (file_exists('uploads/product/'.$productdetails->label))) {?>
              <img src="<?php echo url();?>/uploads/product/thumb/{!! $productdetails->label !!}" id="zoom_01" data-zoom-image="<?php echo url();?>/uploads/product/{!! $productdetails->label !!}" alt="">
              <?php } else { ?>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi elementum nulla et nisi lacinia viverra. Class aptent taciti sociosqu </p>
              <div class="table-responsive spec_table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th width="60%">&nbsp;</th>
                      <th width="20%">Amount per Savings</th>
                      <th width="20%">% Daliy Value</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Kale Powder</td>
                      <td>100 mg</td>
                      <td>N/A</td>
                    </tr>
                    <tr>
                      <td>Cocao Extract</td>
                      <td>50 mg</td>
                      <td>N/A</td>
                    </tr>
                    <tr>
                      <td>Kale Powder</td>
                      <td>100 mg</td>
                      <td>N/A</td>
                    </tr>
                    <tr>
                      <td>Cocao Extract</td>
                      <td>50 mg</td>
                      <td>N/A</td>
                    </tr>
                    <tr>
                      <td>Kale Powder</td>
                      <td>100 mg</td>
                      <td>N/A</td>
                    </tr>
                    <tr>
                      <td>Cocao Extract</td>
                      <td>50 mg</td>
                      <td>N/A</td>
                    </tr>
                    <tr>
                      <td>Cocao Extract</td>
                      <td>50 mg</td>
                      <td>N/A</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <?php } ?>
            </div>
            <!--supp_box--> 
          </div>
        </div>
      </div>
      <!--bottom_panel_rev--> 
      
      <!--related_prod-->
      <div class="related_prod">
        <?php 
          if(!empty($related_product)){
      ?>
        <h3>Related Products</h3>
        <div class="product_list">
          <?php 
         
            foreach ($related_product as $key => $value) {
        ?>
          <div class="product">
            <div class="head_section">
              <h2><?php echo $value->product_name;?></h2>
              <p class="price"><?php echo '$'.number_format($value->min_price*7,2);?></p>
            </div>
            <div class="image_section" <?php if(($value->image1 !='') && (file_exists('uploads/product/thumb/'.$value->image1))) {?>
                style="background:url(<?php echo url();?>/uploads/product/thumb/{!! $value->image1 !!}) no-repeat center center; background-size:cover;height:240px;" <?php } else {?> style="background:url(<?php echo url();?>/uploads/brandmember/noimage.png) no-repeat center center;background-size:cover;height:240px;" <?php } ?>>
            <div class="image_info"><!-- <a href="<?php // echo url().'/product-details/'.$value->product_slug;?>" class="butt cart"><img src="<?php // echo url();?>/public/frontend/images/icon2.png" alt=""/> Add to cart</a>--> <a href="<?php echo url().'/product-details/'.$value->product_slug;?>" class="butt butt-green"><img src="<?php echo url();?>/public/frontend/images/icon3.png" alt=""/> Get Details</a> </div>
          </div>
        </div>
        <?php
            }
        ?>
      </div>
      <?php } ?>
    </div>
    <!--related_prod--> 
  </div>
</div>
<!-- End Products panel -->
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('.loadmore').trigger('click');
  });

  $( document ).on( 'click', '.loadmore', function () {
       $(this).text('Loading...');
       $(this).next('span').show();
      var ele = $(this);
     setTimeout(function(){
       $.ajax({
        url: '<?php echo url();?>/getallrate',
        type: "POST",
        data: { page:ele.attr('data-page'),'product_id':'<?php echo $product_id;?>',_token: '{!! csrf_token() !!}'},
        success:function(response)
        {
    //alert(ele.attr('data-page')); 
          if(response){
            ele.parent('.wrap_load').hide();
            ele.next('span').hide();
            $(".news_list").append(response);
          }          
        }
    
      });
    },4000);

        
  });
  </script> 
<script>
  jQuery(document).ready(function(e) {
  var flag=false;  
    $('.rating span.star').click(function(){
              var total=$(this).parent().children().length;
              var clickedIndex=$(this).index();
              $('.rating span.star').removeClass('filled');
              for(var i=clickedIndex;i<total;i++){
                $('.rating span.star').eq(i).addClass('filled');
              }
    }); 
  
  //for image changer
  $(document).on('click','.img_bord',function(){
    var $this=$(this);
    var this_rel=$this.attr('data-rel');
    $('.main_img img').attr('src',this_rel);
  });
  
  //decrement
  $('#down').on('click',function(){
    if(parseInt($('#increment_input input').val())>1)   
      $('#increment_input input').val(parseInt($('#increment_input input').val())-1);
    total_calc(); 
    $('#quantity').val($('#increment_input input').val());
  });
  //increment
  $('#up').on('click',function(){
    $('#increment_input input').val(parseInt($('#increment_input input').val())+1);
    total_calc();
    $('#quantity').val($('#increment_input input').val());
  });
 
  
  //quantity_add
  
    <?php if((Session::has('member_userid')) || !(Session::has('brand_userid'))) { ?>
      $(document).on('click','.list-group-item',function(){
    //alert('listitem');    

      var $this=$(this);
      $('.list-group-item').removeClass('main_active');
      $this.addClass('main_active');
      var data_money=$this.find('span.pull-right').attr('data-money');
      var data_duration=$this.find('span.pull-right').attr('data-duration');
      var data_no_of_days=$this.find('span.pull-right').attr('data-days');
      var data_product_id=$this.find('span.pull-right').attr('data-product-id');
      var data_product=$this.find('span.pull-right').attr('data-product');
      var data_formfactor=$this.find('span.pull-right').attr('data-formfactor');
      var quantity = $('#increment_input input').val();
      //alert(data_product);
      //alert(data_money+','+data_duration+','+data_product_id+','+data_product+','+data_formfactor+','+quantity);

      $('.price_panel').show();
      $('.price_panel .price_pan').html('$'+data_money);
      $('.top_panel_border .spec_prc').html('$'+data_money+'<span>/'+data_duration+'</span>');
      $('.price_panel .price_pan').attr('data-money',data_money);
      //$("#hidid").val(data_product_id+','+data_product+','+quantity+','+data_money+','+data_formfactor+','+data_duration);
      
      $("#product_id").val(data_product_id);
      $("#quantity").val(quantity);
      $("#product_name").val(data_product);
      $("#amount").val(data_money);
      $("#duration").val(data_duration);
      $("#no_of_days").val(data_no_of_days);
      $("#form_factor").val(data_formfactor);

      total_calc();
      flag=true;
      //alert(flag);
    $('#myTabContent .error_msg').remove(); //remove error message after selecting item
    });
    
  <?php } ?>

  $('#add_cart').on('click',function(e){
    //alert("p="+flag);
    //e.preventDefault();   
    
  });
  
  
  });

   //total Calculation
  function total_calc(){
  
   var total_res=parseFloat($('.price_pan').attr('data-money'))*parseFloat($('#increment_input input').val());
    $('#result').html('=&nbsp;$' + total_res.toFixed(2)); 
  }
var input = document.getElementById('qty');
input.onkeydown = function(e) {
    var k = e.which;
   if (k==48) {
   
      e.preventDefault();
        return false;
   }
    /* numeric inputs can come from the keypad or the numeric row at the top */
    if ( (k < 48 || k > 57) && (k < 96 || k > 105) || k==48 ) {
        e.preventDefault();
        return false;
    }
}

$('#qty').keyup(function () { 
    var qty = this.value;
   
    $('#increment_input input').val(parseInt(qty));
    total_calc();
    $('#quantity').val($('#increment_input input').val());
    
});

function changeval(id,price,product_id,product_name,formfactor_id)
  {

  var str = "<ul class='list-group' id='duration"+id+"'>";
  var formfactor_id = formfactor_id;
  var net_price ;

  <?php foreach($timeduration as $eachduration){?> 
    var no_days = '<?php echo $eachduration->no_of_days;?>';
    var duration = '<?php echo  $eachduration->name; ?>';


    <?php  if($eachduration->no_of_days==90){ ?>
      var total_amnt = no_days * price;
      var percen_amnt = 0.17 * total_amnt;
          net_price = total_amnt - percen_amnt;

    <?php } else{ ?>
          
          net_price = no_days * price;

    <?php } ?>

    str += "<li class='list-group-item clearfix'><span class='pull-left'><?php echo  $eachduration->name; ?></span><span class='pull-right' data-duration='<?php echo  $eachduration->name; ?>' data-days='<?php echo $eachduration->no_of_days; ?>' data-product-id='<?php echo  $eachformfactor->product_id; ?>' data-product='"+product_name+"' data-formfactor="+formfactor_id+" data-money="+(net_price).toFixed(2)+">$"+(net_price).toFixed(2)+"</span></li>"; 
    // .toFixed(2)

   <?php } ?>   

   str += "</ul>";

    $("#product_id").val('');
    $("#quantity").val('');
    $("#product_name").val('');
    $("#amount").val('');
    $("#duration").val('');
    $("#no_of_days").val('');
    $("#form_factor").val('');

   //alert(str);
   //flag =false;
   //alert(flag);
   $(".price_panel").hide();
   $("#section"+id).html(str);
   //return false;
  }
  </script> 
<script>
  function addCart()
  {
    var product_id = $("#product_id").val();
    var quantity = $("#quantity").val();
    var product_name = $("#product_name").val();
    var amount = $("#amount").val();
    var duration = $("#duration").val();
    var no_of_days = $("#no_of_days").val();
    var form_factor = $("#form_factor").val();

    //alert(data_money+','+data_duration+','+data_product_id+','+data_product+','+data_formfactor+','+quantity);
    if(product_id!='' && quantity!='' && amount!='' && product_name!='' && duration!='' && no_of_days!='' && form_factor!='')
    {
      $.ajax({
          url: '<?php echo url();?>/allmycard',
          type: "post",
          data: { product_id : product_id , quantity : quantity ,product_name : product_name, amount : amount, duration : duration, no_of_days:no_of_days, form_factor : form_factor,_token: '{!! csrf_token() !!}'},
          success:function(data)
          {
           //alert(data);
            if(data !='' ) // email exist already
            {
              $("#cart_det").html(data);
        $("#cart_mob_det").html(data);
              //$("#cart_det").effect( "shake", {times:4}, 1000 );
               //window.location.href = "<?php echo url()?>/brandregister";
         $('#myTabContent .error_msg').remove();
         
         //for add to cart animation
         var foroffset_calc=$('#add_cart');
         if($(window).width()>767)
        var cart = $('.navbar-default .navbar-nav > li.cart');
         else
          var cart = $('#formob_only'); 
        var imgtodrag = $('.main_img').find("img").eq(0);
        console.log(imgtodrag);
        if (imgtodrag) {
          var imgclone = imgtodrag.clone()
            .offset({
            top: foroffset_calc.offset().top,
            left: foroffset_calc.offset().left
          })
            .css({
            'opacity': '0.5',
              'position': 'absolute',
              'height': '150px',
              'width': '150px',
              'z-index': '9999999999'
          })
            .appendTo($('body'))
            .animate({
            'top': cart.offset().top + 10,
              'left': cart.offset().left + 10,
              'width': 75,
              'height': 75
          }, 1000, 'easeInOutExpo');
          
          
          imgclone.animate({
            'width': 0,
              'height': 0
          }, function () {
            $(this).detach()
          });
        }
        setTimeout(function(){
          $("#cart_det").show();
            $("#cart_mob_det").show();  
        },1100)
        setTimeout(function(){
          $('#no_dis_orig').animate({'left':0});
          $('#add_cart').prop('disabled',true);
          /*if($(window).width()>767){
            $(".nav > li.cart a").tooltip({
              title: 'Product Added To Cart.',
              placement:'bottom'
            });
            $(".nav > li.cart a").tooltip('show');
          }
          else{
            $("#formob_only").tooltip({
              title: 'Product Added To Cart.',
              placement:'bottom'
            });
            $("#formob_only").tooltip('show');
          }*/
        },600);   
        setTimeout(function(){
          $('#no_dis_orig').animate({'left':100+'%'});
          $('#add_cart').prop('disabled',false);
          /*if($(window).width()>767){
            $(".nav > li.cart a").tooltip('destroy');
          }
          else{
            $("#formob_only").tooltip('destroy');
          }*/
        },4000);
         //for add to cart animation
         
         /*-- After Add to Cart Remove All the hidden required Fields Start --*/
        $("#product_id").val('');
        $("#quantity").val('');
        $("#product_name").val('');
        $("#amount").val('');
        $("#duration").val('');
        $("#no_of_days").val('');
        $("#form_factor").val('');
        $('.list-group-item').removeClass('main_active'); //Remove selected item
        $('.price_panel').hide(); // remove selected quantity
        /*-- After Add to Cart Remove All the hidden required Fields Start --*/
            }
                  
          }
      
        }); //ajax end
    } // if end
  else{
        //alert();
        //$('#myTabContent .error_msg').remove();
        $('#myTabContent .error_msg').remove();
        $('#myTabContent').append('<div class="alert alert-danger fade in error_msg"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Danger!</strong> Please Select A Value.</div>');
        //flag=false;
              
  }

  }
  
  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  var target = $(e.target).attr("href") // activated tab
  var first_price_val = $(target).find('ul li:first-child span.pull-right').attr('data-money');
  var first_duration_val = $(target).find('ul li:first-child span.pull-right').attr('data-duration');
  //alert(first_val);
  $("#min_val").html(first_price_val);
  $("#min_val2").html(' / '+first_duration_val);


  });

  </script> 
<script>
if($(window).width()>767){
    $('#zoom_01').elevateZoom({
    cursor: "crosshair",
    zoomWindowFadeIn: 500,
    zoomWindowFadeOut: 750,
    zoomWindowWidth: 500,
    zoomWindowHeight: 500,
    borderSize: 1,
    showLens: false,
    borderColour: "#6ED1E3"
    }); 
}
</script>
<style>
  .zoomWindow {
    left: -500px !important;
}

</style>

<script type="text/javascript">
     function onPlusDone(reponse) {
          console.log(reponse);

            var res = 'success';
             $.ajax({
                    type:"POST",
                    dataType: "json",
                    url: '<?php echo url();?>/saveShare',
                    data: { email : 'sumi@gmail.com', product_id : '10' ,_token: '{!! csrf_token() !!}'},
                    success:function(result){

                    }
                })
      }
     function myCallback(jsonParam) {

         console.log("URL: " + jsonParam.href + " state: " + jsonParam.state);

      }
</script>

<!--INNER PAGE CONTENT END -->

<script>
function fb_share(product_name,url,product_id) {
  FB.ui(
  {
    method: 'share',
  name: product_name,
  href: url,
  product_id: product_id
  //caption: details
  },
  
  function(response) {
    if (response && !response.error_code) 
    {
      FB.api('/me?fields=name,email', function(response)
      {
        //alert('Posting completed.'+response.email+product_id);
      $.ajax({
        url: '<?php echo url();?>/saveShare',
        type: "post",
        data: { product_id : product_id ,_token: '{!! csrf_token() !!}'},
        success:function(data)
        {
          //alert(data);
        }
      });
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