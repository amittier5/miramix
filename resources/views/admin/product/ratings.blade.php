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
                    <th>Product Name</th>
                    <th>Rating</th>
                    <th>User</th>
                    <th>Comment</th>
                    
                    <th>Status</th>
                  
                    <th>Delete</th>
                </tr>
            </thead>
                
                
            <tbody>
                <?php $i=1;?>
                @foreach ($ratings as $rating)
                <tr class="odd gradeX">
                    <td class=""><?php echo $i; ?></td>
                    <td class="">{!! $rating->getRatings->product_name !!}</td>
                    <td class="">{!! $rating->rating_value !!}</td>
                    <td class="">{!! $rating->getMembers->email !!}</td>
                    <td class="">{!! $rating->comment !!}</td>
                 
                    <td class="">
                        @if ($rating->status == 1)
                            <a href="{{ URL::to('admin/ratingstatus/' . $rating->rating_id) }}" data-toggle="tooltip" title="Make Inactive" >Active</a>
                        @else
                            <a href="{{ URL::to('admin/ratingstatus/' . $rating->rating_id) }}" data-toggle="tooltip" title="Make Active" >Inactive</a>
                        @endif
                    </td>
                  
                   
                    
                    <td>
                       
                       
                        <input type="button" class="btn btn-danger" onclick="ConfirmDelete()" value="Delete"/>
                    </td>
                </tr>
                <?php $i++;?>
                @endforeach
                </tbody>
                
            </table>
    </div>

  <div><?php echo $ratings->render(); ?></div>
  <script>

  function ConfirmDelete()
  {
  var x = confirm("Are you sure you want to delete?");
  if (x)
    location.href='{{ URL::to('admin/destroyrating/' . $rating->rating_id) }}';
  else
    return false;
  }

</script>
@endsection
