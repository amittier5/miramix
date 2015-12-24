@extends('admin/layout/admin_template')
 
@section('content')
  
@if(Session::has('success'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! Session::get('success') !!}</strong>
        </div>
 @endif
 <?php 
    $orderstatus = Session::get('orderstatus');
    $filterdate = Session::get('filterdate');
?> 
    <div class="module">
          
        <form method="post" id="filterform" action="<?php echo url();?>/admin/orders/filter">
          <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
          <div class="filter filt_css pull-left"><span>Filter by status</span>
          
          <select id="orderstatus" name="orderstatus">
            <option value="0">Select</option>
            <option value="pending" <?php if($orderstatus=='pending'){echo 'selected="selected"';}?>>Pending</option>
            <option value="processing" <?php if($orderstatus=='processing'){echo 'selected="selected"';}?>>Processing</option>
            <option value="completed" <?php if($orderstatus=='completed'){echo 'selected="selected"';}?>>Completed</option>
            <option value="shipped" <?php if($orderstatus=='shipped'){echo 'selected="selected"';}?>>Shipped</option>
            <option value="cancel" <?php if($orderstatus=='cancel'){echo 'selected="selected"';}?>>Cancel</option>
            <option value="fraud" <?php if($orderstatus=='fraud'){echo 'selected="selected"';}?>>Fraud</option>
          </select>
            
            
          </div>
            <div class="filter filt_css filter_right" style="clear:both;padding-left: 10px;">
                <div class="pull-left" style="margin-right: 10px;"><span>Filter by brand</span> <input type="text" name="brandemail" value="<?php echo $brandemail?>" id="brandemail" /></div>
                <div class="pull-left"><span>Filter by date</span> <input type="text" name="filterdate" value="<?php echo $filterdate?>" id="filterdate" /></div>
                <div class="search_top pull-right"><input type="submit" class="btn btn-success marge" value="search" name="search"/></div>
                <a href="<?php echo url();?>/admin/push_order_process">Push</a>
            </div>
        </form>
        <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped  display" width="100%">
            <thead>
                <tr>
                    <th>Sl No.</th>
                    <th>Order ID</th>
                    <th>Order Total</th>
                    <th>Order Status</th>
                    <th>Ordered By</th>
                    <th>Order Date</th>
                    <th>View Details</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
                
                
            <tbody>
                <?php $i=1;?>
                @foreach ($order_list as $order)
               <?php  $serialize_address = unserialize($order->shiping_address_serialize);?>
                <tr class="odd gradeX">
                    <td><?php echo $i; ?>
                        <input type="checkbox" class="checkbox_cls" name="add_queue[]" id="add_queue<?php echo $order->id;?>" value="<?php echo $order->id;?>">
                    </td>
                    <td>{!! $order->order_number !!}</td>
                    <td>{!! '$'.number_format($order->order_total,2); !!}</td>
                    <td><a href="#" data-toggle="tooltip" title="Status" >{!! $order->order_status !!}</a></td>
                    <td>{!! $serialize_address['first_name'].' '.$serialize_address['last_name'] !!}</td>
                    <td>{!! date('m/d/Y',strtotime($order->created_at)) !!}</td>                    
                    <td>
                        <input type="radio" class="radio_cls" name="mail<?php echo $order->id;?>" id="id1_<?php echo $order->id;?>" value="priority">Priority Mail
                        <input type="radio" class="radio_cls" name="mail<?php echo $order->id;?>" id="id2_<?php echo $order->id;?>"  value="flat">Flat Rate
                        <a href="<?php echo url();?>/admin/order-details/<?php echo $order->id;?>" class="btn btn-success">Details</a>
                    </td>
                    <td>
                        <a href="{!!route('admin.orders.edit',$order->id)!!}" class="btn btn-warning">Edit</a>
                    </td>
                    <td>
                        {!! Form::open(['method' => 'DELETE', 'route'=>['admin.orders.destroy', $order->id]]) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
                <?php $i++;?>
                @endforeach
                </tbody>
                
            </table>
    </div>

  <div><?php echo $order_list->render(); ?></div>

<script type="text/javascript">
    $('.radio_cls').on('change',function(){
        $this = $(this);

        $('#add_queue'+$this.attr('id')).attr("checked",true);
        call_ajax($this.attr('id'),'checkbox_cls');

        var str = $('.radio_cls:checked').attr('id');
        var allData = str.split("_");
        
        $('#add_queue'+allData[1]).attr("checked",true);

        call_ajax(allData[1],$('.checkbox_cls'));

    });

    $('.checkbox_cls').on('click',function(){
        $this = $(this);

        call_ajax($this.val(),$this);
       
    });


    function call_ajax(order_id,obj){

        if(obj.is(':checked'))
            var param = 'add';
        else
            var param = 'remove';

        var mail_option = $('input[name="mail'+order_id+'"]:checked').val();
        //alert(mail_option);return false;
        
        $.ajax({
              url: '<?php echo url();?>/admin/add-process-queue',
              method: "POST",      
              data: { "mail_option" : mail_option,"order_id" : order_id,"param" :param ,_token: '{!! csrf_token() !!}'},
              success:function(data)
              {
               
               
              }
        });
    }


</script>  
    
<script>
    
    $("#orderstatus").change(function(){
          //  $("#filterform").submit();
    });
    $(document).ready(function(){
        $( "#filterdate" ).datepicker({ dateFormat: 'yy-mm-dd' });
        
        $( "#brandemail" ).autocomplete({
            source: "{!!url('admin/brand-search/')!!}" 
          });
    });
    
</script>
@endsection
