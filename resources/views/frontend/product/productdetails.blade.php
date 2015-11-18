@extends('frontend/layout/frontend_template')
@section('content')
<?php //echo "<pre/>";print_r($productformfactor);  exit;?>
<script src="<?php echo url();?>/public/frontend/js/jquery.raty.js"></script>
<link href="<?php echo url();?>/public/frontend/css/jquery.raty.css" rel="stylesheet">
<div class="inner_page_container">
      <div class="header_panel">
          <div class="container">
           <h2>Brands</h2>
             <ul class="breadcrumb">
                <li><a href="<?php echo url();?>">Home</a></li>
                <li><a href="<?php echo url();?>/brand-details/{!! ucwords($productdetails->product_slug) !!}">Brands</a></li>
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
        <div class="main_img">

          <img src="<?php if(($productdetails->image1 !='') && (file_exists('uploads/product/'.$productdetails->image1))) {?><?php echo url();?>/uploads/product/{!! $productdetails->image1 !!}<?php } ?>" class="img-responsive" alt="">
          
        </div>
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
        </div>
        </div>
        <div class="col-md-6 col-sm-12 pad_top">
        
        <div class="bordered_panel clearfix">
        <div class="top_panel_border clearfix"><h3 class="pull-left">{!! ucwords($productdetails->product_name) !!}</h3>
        <p class="spec_prc pull-right">$ {!! sprintf("%.2f",($productformfactor[0]->actual_price)*($timeduration[0]->no_of_days)) !!} <span>/ {!! $timeduration[0]->name !!}</span></p>
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
              <?php foreach($timeduration as $eachduration){?>
              <li class="list-group-item clearfix"><span class="pull-left">{!! $eachduration->name !!}</span><span class="pull-right" data-duration="{!! ($eachduration->name)!!}" data-days="{!! ($eachduration->no_of_days) !!}" data-product-id="{!! ($eachformfactor->product_id)!!}" data-product="{!! ($eachformfactor->product_name)!!}" data-formfactor="{!! ($eachformfactor->formfactor_id)!!}" data-money="{!! sprintf("%.2f",($eachduration->no_of_days)*($productformfactor[0]->actual_price))!!}">
                {!! '$'.sprintf("%.2f",($eachduration->no_of_days)*($productformfactor[0]->actual_price))!!}</span></li>
              
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
        <div class="col-sm-8 price_panel"><p class="pull-left price_pan" data-money="5.20">$5.20</p>
        <div id="incdec" class="col-sm-6">
          <a href="javascript:void(0);" id="down" class="pull-left incremt_a"><i class="fa fa-minus"></i></a>
            <div class="col-sm-10" id="increment_input"><input type="text" class="form-control text-center" value="1"  id="qty"/></div>
            <a href="javascript:void(0);" id="up" class="pull-left incremt_a"><i class="fa fa-plus"></i></a>
        </div>
        
        <p id="result">=&nbsp;$5.00</p>
    </div>
        <div class="col-sm-4">
        <?php if($brandlogin == 0) {?>
        <button type="button" class="butt cart" id="add_cart"  onclick="addCart()"><img src="<?php echo url();?>/public/frontend/images/icon2.png" alt="">Add to cart</button>
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
    <div class="total_block"><div class="col-sm-6 lefted_img">
    <img src="<?php echo url();?>/uploads/product/{!! $productdetails->image1 !!}" class="img-responsive" alt="">
    </div>
    <div class="col-sm-6 righted_text">
    <p>{!! ucfirst($productdetails->description1) !!}</p>
    </div></div>
    <div class="total_block">
    <div class="col-sm-6 righted_text">
    <p>{!! ucfirst($productdetails->description2) !!}</p>
    </div>
    <div class="col-sm-6 lefted_img">
    <img src="<?php echo url();?>/uploads/product/{!! $productdetails->image2 !!}" class="img-responsive" alt="">
    </div>
    </div>
    <div class="total_block"><div class="col-sm-6 lefted_img">
    <img src="<?php echo url();?>/uploads/product/{!! $productdetails->image3 !!}" class="img-responsive" alt="">
    </div>
    <div class="col-sm-6 righted_text">
    <p>{!! ucfirst($productdetails->description3) !!}</p>
    </div></div>
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
    <h4>{!! ucwords($productdetails->fname.' '.$productdetails->lname) !!}</h4>
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
        
        <small>(Based on <?php echo count($rating);?>  Reviews)</small>
    </div>
    <?php if(count($rating)>0) {?>
    <div class="news_list">
        <a href="javascript:void(0);" class="btn btn-special loadmore" data-page="0">View More Reviews</a>
    </div>
   <?php } ?> 
     
    </div>


    <div class="col-sm-6 suppl_facts">
      <h6>Supplement Facts</h6>
        <!--supp_box--0
      <div class="supp_box">
      <?php if(($productdetails->label !='') && (file_exists('uploads/product/'.$productdetails->label))) {?>
       <img src="<?php echo url();?>/uploads/product/thumb/{!! $productdetails->label !!}" alt="">
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
    <h3>Related Products</h3>
    <div class="product_list">
      <div class="product">
          <div class="head_section">
              <h2>Fat Blaster</h2>
              <p class="price">$99.99 </p>
              </div>
            <div class="image_section">
              <img src="<?php echo url();?>/public/frontend/images/portfolio/1.png" alt=""/>
                <div class="image_info">
                  <a href="#" class="butt cart"><img src="<?php echo url();?>/public/frontend/images/icon2.png" alt=""/> Add to cart</a>
                    <a href="#" class="butt butt-green"><img src="<?php echo url();?>/public/frontend/images/icon3.png" alt=""/> Get Details</a>
                </div>
          </div> 
      </div>
      <div class="product">
          <div class="head_section">
              <h2>Fat Blaster</h2>
              <p class="price">$99.99 </p>
              </div>
            <div class="image_section">
              <img src="<?php echo url();?>/public/frontend/images/portfolio/2.png" alt=""/>
                <div class="image_info">
                  <a href="#" class="butt cart"><img src="<?php echo url();?>/public/frontend/images/icon2.png" alt=""/> Add to cart</a>
                    <a href="#" class="butt butt-green"><img src="<?php echo url();?>/public/frontend/images/icon3.png" alt=""/> Get Details</a>
                </div>
          </div> 
      </div>
      <div class="product">
          <div class="head_section">
              <h2>Fat Blaster</h2>  
              <p class="price">$99.99 </p>
              </div>
            <div class="image_section">
              <img src="<?php echo url();?>/public/frontend/images/portfolio/3.png" alt=""/>
                <div class="image_info">
                  <a href="#" class="butt cart"><img src="<?php echo url();?>/public/frontend/images/icon2.png" alt=""/> Add to cart</a>
                    <a href="#" class="butt butt-green"><img src="<?php echo url();?>/public/frontend/images/icon3.png" alt=""/> Get Details</a>
                </div>
          </div> 
      </div>  
      
      
      
      </div>
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
      var ele = $(this);

       $.ajax({
        url: '<?php echo url();?>/getallrate',
        type: "POST",
        data: { page:$(this).data('page'),'product_id':'<?php echo $product_id;?>',_token: '{!! csrf_token() !!}'},
        success:function(response)
        {
          if(response){
            ele.hide();
            $(".news_list").append(response);
          }          
        }
    
      });

        
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
  
    
      $(document).on('click','.list-group-item',function(){

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
    });
    
  
  $('#add_cart').on('click',function(e){
    //alert("p="+flag);
    //e.preventDefault();   
    if(flag===true){
      $('#myTabContent .error_msg').remove();
      //$('#form1').submit();
    }
    else{
      $('#myTabContent .error_msg').remove();
      $('#myTabContent').append('<div class="alert alert-danger fade in error_msg"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Danger!</strong> Please Select A Value.</div>');
      flag=false;
      return false; 
    }
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

  <?php foreach($timeduration as $eachduration){?>
    var no_days = '<?php echo $eachduration->no_of_days;?>';
    var duration = '<?php echo  $eachduration->name; ?>';

    str += "<li class='list-group-item clearfix'><span class='pull-left'><?php echo  $eachduration->name; ?></span><span class='pull-right' data-duration='<?php echo  $eachduration->name; ?>' data-days='<?php echo $eachduration->no_of_days; ?>' data-product-id='<?php echo  $eachformfactor->product_id; ?>' data-product='"+product_name+"' data-formfactor="+formfactor_id+" data-money="+(no_days*price).toFixed(2)+">$"+(no_days*price).toFixed(2)+"</span></li>";

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
            $("#cart_det").fadeIn(2000);
             //window.location.href = "<?php echo url()?>/brandregister";
          }
          
        }
    
      });


  }
  
   
  </script>

 @stop