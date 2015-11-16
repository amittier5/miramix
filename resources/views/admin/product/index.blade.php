@extends('admin/layout/admin_template')
 
@section('content')
<?php //print_r($ingredients);exit; ?>
  
    @if(Session::has('success'))
      <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <strong>{!! Session::get('success') !!}</strong>
      </div>
   @endif
 

<script type="text/javascript">
    function search(){
        if($('#search_name').val()=='')
            window.location.href = "{!! url('admin/product-list')!!}"+'/'+$('#pro_type').val();
        else
            window.location.href = "{!! url('admin/product-list')!!}"+'/'+$('#pro_type').val()+'/'+$('#search_name').val();
    }

    $(document).ready(function(){
      $('#pro_type').change(function(){
        //alert('{!! url('admin/product-list')!!}');
        window.location.href = "{!! url('admin/product-list')!!}/"+$('#pro_type').val();
      })
    })

$(function(){
 $("#search_name").keyup(function (e) {
  if (e.which == 13) {
    search();
  }
 });
});

/****** Auto complete ********/
$(document).ready(function(){  
//alert('r');  
    $( "#search_name" ).autocomplete({
      source: "{!!url('admin/discontinue-product-search')!!}"
    });
});
 
</script>

    <div class="pull-left">
       <input type="text" name="search_name" id="search_name" value="{!! $param !!}"  placeholder="Search By Product Name" class="span4"> 
       <a href="javascript:search()" class="btn btn-success marge">Search</a>
       <a href="{!! url('admin/product-list/'.$discountinue);!!}" class="btn btn-success marge">Clear</a>
    </div>

    <select name="pro_type" id="pro_type" style="float:right">
      <option value="1">Discontinue Product</option>
      <option value="0">Continue Product</option>
    </select>
    <hr>                      
    <div class="module">
      <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped  display" width="100%">
        <thead>
            <tr>
              <th>Image</th>
              <th>Name</th>
              <th>Brand</th>
              <th>Form Factors (Price)</th>
              <th>Edit</th>
             <!--  <th>Delete</th> -->                
            </tr>
        </thead>            
        <tbody>
            <?php $i=1;?>
            @foreach ($products as $product)
            <!-- {!! "<pre>"; print_r($product); !!} -->
            <tr class="odd gradeX">
               <td class=""><img src="{!! url();!!}/uploads/product/medium/{!! $product->image1 !!}"></td>
               <td class="">{!! $product->product_name !!}</td>
               <td class="">{!! $product->GetBrandDetails['fname'].' '.$product->GetBrandDetails['lname']; !!}</td>
               <td class="">{!! rtrim($product->formfactor_name,'<br/>'); !!}</td>
               
                <td>
                    <a href="{!!route('admin.product.edit',$product->id)!!}" class="btn btn-warning">Edit</a>
                </td>
                <!-- <td>
                    {!! Form::open(['method' => 'DELETE', 'route'=>['admin.ingredient.destroy', $product->id], 'onsubmit' => 'return ConfirmDelete()']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </td> -->
            </tr>
            <?php $i++; ?>
            @endforeach
        </tbody>          
      </table>
    </div>

  <div><?php echo $products->render(); ?></div>

  <script>

  function ConfirmDelete()
  {
  var x = confirm("Are you sure you want to delete?");
  if (x)
    return true;
  else
    return false;
  }

</script>
@endsection
