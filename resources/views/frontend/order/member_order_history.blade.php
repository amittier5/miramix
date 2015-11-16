@extends('frontend/layout/frontend_template')
@section('content')

<div class="header_section nomar_bottom">
   <!--my_acct_sec-->
   <div class="my_acct_sec">           
     <div class="container">
       <div class="col-sm-10 col-sm-offset-1">
         <div class="row">
           <div class="form_dashboardacct">
              <h3>Order History</h3>
                <div class="row">
			 @if(Session::has('error'))
			    <div class="alert alert-error container">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>{!! Session::get('error') !!}</strong>
			    </div>
			  @endif
			  @if(Session::has('success'))
			    <div class="alert alert-success container">
			    <button type="button" class="close" data-dismiss="alert">×</button>
			    <strong>{!! Session::get('success') !!}</strong>
			    </div>
			  @endif
			 </div>
              <div class="table-responsive">
                <table class="table special_height">
                <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>No. of Products</th>
                    <th>Date Added</th>
                    <th>Total</th>
                    <th>Order Status</th>
                    <th>Tracking</th>
                  </tr>
                </thead>
                <tbody>
                @if(!empty($order_list))
                  @foreach($order_list as $each_order_list)
                  <tr>
                    <td>#{!! $each_order_list->id; !!}</td>
                    <td>{!! count($each_order_list->AllOrderItems); !!}</td>
                    <td>{!! date("M d, Y",strtotime($each_order_list->created_at)); !!}</td>
                    <td>$ {!! number_format($each_order_list->order_total,2); !!}</td>
                    <td><p class="status_btn">{!! $each_order_list->order_status; !!}</p></td>
                    <td><a href="{!! url()!!}/order-detail/{!! $each_order_list->id; !!}" class="btn btn-white">View Status</a></td>
                  </tr>
                  @endforeach
                @else
                <tr>
                    <td colspan="6">No records found</td>
                </tr>
                @endif
                </tbody>
              </table>
              </div>
                {!! $order_list->render() !!}
              <div class="form_bottom_panel">
                <a href="member-dashboard" class="green_btn pull-left"><i class="fa fa-angle-left"></i> Back to Dashboard</a>
              </div>
                
           </div>
         </div>
       
       </div>
     
     </div>           
   </div>
   <!--my_acct_sec ends-->
 </div>
@stop
