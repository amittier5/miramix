@extends('admin/layout/admin_template')
 
@section('content')

  
@if(Session::has('success'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! Session::get('success') !!}</strong>
        </div>
 @endif
 
    <div class="module">
                               
        <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped  display" width="100%">
            <thead>
                <tr>
                    <th>Sl No.</th>
                    <th>Order ID</th>
                    <th>Order Total</th>
                    <th>Order Status</th>
                    <th>Ordered By</th>
                    <th>Order Date</th>
                    
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
                
                
            <tbody>
                <?php $i=1;?>
                @foreach ($order_list as $order)
                <tr class="odd gradeX">
                    <td class=""><?php echo $order->id; ?></td>
                    <td class="">{!! $order->order_number !!}</td>
                    <td class="">{!! $order->order_total !!}</td>
                    <td class=""><a href="#" data-toggle="tooltip" title="Status" >{!! $order->order_status !!}</a></td>
                    <td class="">{!! $order->getOrderMembers->fname." ".$order->getOrderMembers->lname !!}</td>
                    <td class="">{!! date('m/d/Y',strtotime($order->created_at)) !!}</td>
                    
               
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
@endsection
