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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>DOB</th>
                    <th>Status</th>
                    <th>Admin Status</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
                
                
            <tbody>
                <?php $i=1;?>
                @foreach ($members as $member)
                <tr class="odd gradeX">
                    <td class=""><?php echo $i; ?></td>
                    <td class="">{!! $member->fname.' '.$member->lname !!}</td>
                    <td class="">{!! $member->email !!}</td>
                    <td class="">{!! $member->phone_no !!}</td>
                    <td class="">{!! $member->gender !!}</td>
                    <td class="">{!! date('m/d/Y',strtotime($member->dob)) !!}</td>
                    <td class="">
                        @if ($member->status == 1)
                            Active 
                        @else
                            <a href="{{ URL::to('admin/member/status/' . $member->id) }}" data-toggle="tooltip" title="Make Active" >Inactive</a>
                        @endif
                    </td>
                    <td class="">
                        @if ($member->admin_status == 1)
                           <a href="{{ URL::to('admin/member/admin_inactive_status/' . $member->id) }}" data-toggle="tooltip" title="Make Inactive" >Active</a>
                        @else
                           <a href="{{ URL::to('admin/member/admin_active_status/' . $member->id) }}" data-toggle="tooltip" title="Make Active" >Inactive</a>
                        @endif
                    </td>
                   
                   <!--  <td><a href="{!!route('admin.member.edit',$member->id)!!}" class="btn btn-warning">Edit</a></td> -->
                    <td>
                        <a href="{!!route('admin.member.edit',$member->id)!!}" class="btn btn-warning">Edit</a>
                    </td>
                    <td>
                        {!! Form::open(['method' => 'DELETE', 'route'=>['admin.member.destroy', $member->id]]) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
                <?php $i++;?>
                @endforeach
                </tbody>
                
            </table>
    </div>

  <div><?php echo $members->render(); ?></div>
@endsection
