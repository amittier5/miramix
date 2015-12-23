@extends('admin/layout/admin_template')

@section('content')
<?php 
use App\Helper\helpers;
$obj = new helpers();
$serialize_address = unserialize($order_list->shiping_address_serialize);
?>

<div class="inner_page_container nomar_bottom">
     <!--my_acct_sec-->
     <div class="my_acct_sec">           
      <div class="container-fluid">
        <div class="col-sm-12">
         <div class="row">
         <div class="form_dashboardacct">
            <h3>Order History</h3>
              <div class="bottom_dash clearfix">
                  
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="order_box">
                  <h6>Order Information</h6>
                    <div class="bottom_panel_ship"><p>Order ID: #{!! $order_list->order_number; !!}<br>
                    <?php if($order_list->shipping_address_id == 1){?>
                      Account Email: {!! isset($serialize_address['email'])?$serialize_address['email']:''; !!}<br>
                      <?php }else {?>
                      Account Email: {!! isset($serialize_address['email'])?$serialize_address['email']:''; !!}<br>
                      <?php }?>
                      Date Added: {!! date("M d, Y",strtotime($order_list->created_at)); !!}<br>
                      Payment Method: {!! $order_list->payment_method; !!}<br>
                      Shipping Type: {!! $order_list->shipping_type; !!}<br>
                      Shipping Cost: ${!! number_format($order_list->shipping_cost,2); !!}</p>
                    </div>
                  </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="order_box">
                      <h6>Shipping Address</h6>
                       <div class="bottom_panel_ship">
                       <?php 
                        if((isset($serialize_address['zone_id'])))
                        {
                          if(is_numeric($serialize_address['zone_id']))
                          {
                            $state = $obj->get_state($serialize_address['zone_id']);
                          }
                          else
                          {
                            $state = $serialize_address['zone_id'];
                          }
                        }

                        if((isset($serialize_address['country_id'])))
                        {
                          if(is_numeric($serialize_address['country_id']))
                          {
                            $country = $obj->get_country($serialize_address['country_id']);
                          }
                          else
                          {
                            $country = $serialize_address['country_id'];
                          }
                        }
                      ?>

                      <p>
                      {!! isset($serialize_address['first_name'])?($serialize_address['first_name'].' '.$serialize_address['last_name']):'' !!}<br>                          
                      {!! isset($serialize_address['email'])?$serialize_address['email']:''; !!}<br>
                      {!! isset($serialize_address['address'])?$serialize_address['address']:''; !!}<br>
                      {!! ($serialize_address['address2']!='')?$serialize_address['address2'].'<br>':''; !!}
                      {!! "City: ".isset($serialize_address['city'])?$serialize_address['city']:''; !!}<br>
                      {!! (isset($serialize_address['zone_id']) && ($serialize_address['zone_id']!=''))?"State: ".$state :'' !!}<br>
                      {!! (isset($serialize_address['country_id']) && ($serialize_address['country_id']!=''))? "Country : " .$country:'' !!}<br>
                      {!! "Post Code: ". isset($serialize_address['postcode'])?$serialize_address['postcode']:'';!!}</p>
                       </div>
                      </div>
                    </div>                    
                  </div>
                  
                  <div class="table-responsive spec_tab_resp">
                    <table class="table table-information">
                        <thead>
                          <tr>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          
                            
                              
                              @if(!empty($order_items_list))
                                @foreach($order_items_list as $each_item)

                                 <?php  $pro_dtls = $obj->getProductDetails($each_item->product_id);?>
                                
                                  <tr>
                                    <td>
                                      @if($each_item->product_image!="" && file_exists('./uploads/product/medium/'.$each_item->product_image))
                                      <img src="{!! url(); !!}/uploads/product/medium/{!! $each_item->product_image !!}" alt=""  style="max-width:100px"">
                                      @else
                                      <img src="{!! url(); !!}/uploads/brandmember/noimage.png" alt=""  style="max-width:100px"">
                                      @endif
              
              
                                    </td>
                                    <td><a href="{!! url().'/product-details/'.$pro_dtls->product_slug; !!}" target="_blank"> {!! $each_item->product_name; !!} </a></td>
                 
                                    <td>{!! $each_item->quantity; !!}</td>
                                    <td>${!! number_format($each_item->price,2); !!}</td>
                                    <td class="text-right">${!! number_format(($each_item->price * $each_item->quantity),2); !!}</td>
                                  </tr>
          @endforeach
                              @else
                                  <tr>
                                    <td colspan="5">No records found</td>
                                  </tr>      
                              @endif                       
                              </tbody>    
                              <tfoot>
                                <tr>
                                    <td colspan="3">&nbsp;</td>
                                    <td class="text-right">Sub-Total</td><td class="text-right">${!! number_format($order_list->sub_total,2); !!}</td>
                                </tr>
                                 <?php if($order_list->discount!=0){?>
                                 <tr>
                                    <td colspan="3">&nbsp;</td>
                                    <td class="text-right">Discount</td>
                                    <td class="text-right">${!! number_format($order_list->discount,2); !!}</td>
                                </tr>
                                 <?php } ?>
                                <tr>
                                    <td colspan="3">&nbsp;</td>
                                    <td class="text-right">Flat Shipping Rate</td>
                                    <td class="text-right">${!! number_format($order_list->shipping_cost,2); !!}</td>
                                </tr>
                                <tr>
                                    <td colspan="3">&nbsp;</td>
                                    <td class="text-right">Total</td>
                                    <td class="text-right">${!! number_format($order_list->order_total,2); !!}</td>
                                </tr>
                              </tfoot>
                            
                          
                                                   
                    </table>
                  </div>
                  
                  <div class="order_box clearfix">
                    <h6>Order History</h6>
                    <div class="row"><div class="col-sm-12">
                      <div class="table-responsive">
                        <table class="table table_bottom_new">
                          <thead>
                            <tr>
                              <th>Date Updated</th>
                              <th>Order Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>{!! date("M d, Y",strtotime($order_list->updated_at)); !!}</td> 
                              <td>{!! $order_list->order_status; !!}</td>
                            </tr>                   
                          </tbody>
                        </table>
                      </div>
                    </div></div>
                  </div>
              </div>
              
              
              <div class="controls">
                <a class="btn" href="{!! url(); !!}/admin/orders">Back</a>
              </div>
              
         </div>
         </div>
         </div>
        </div>           
     </div>
     <!--my_acct_sec ends-->
  </div>
    
    <script>
      
      function rateproduct(productid) {
    
  location.href='<?php echo url();?>/rate-product/'+productid
      }
    </script>
@stop


