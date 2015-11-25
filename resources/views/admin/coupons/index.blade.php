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
                    <th>Coupon Name</th>
                    <th>Code</th>
                    <th>Discount</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <!-- <th>Status</th> -->
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
                
                
            <tbody>
                <?php $i=1;?>
                @foreach ($coupons as $coupons)
                <tr class="odd gradeX">
                    <td class=""><?php echo $i; ?></td>
                    <td class="">{!! $coupons->name !!}</td>
                    <td class="">{!! $coupons->code !!}</td>
                    <td class="">{!! $coupons->discount !!}</td>
                    <td class="">{!! $coupons->date_start !!}</td>
                    <td class="">{!! $coupons->date_end !!}</td>
                    <td>
                        <a href="{!!route('admin.coupons.edit',$coupons->id)!!}" class="btn btn-warning">Edit</a>
                    </td>
                    <td>
                        {!! Form::open(['method' => 'DELETE', 'route'=>['admin.coupons.destroy', $coupons->id]]) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
                <?php $i++;?>
                @endforeach
                </tbody>
                
            </table>
    </div>

  <div><?php echo $coupons->render(); ?></div>
@endsection
