@extends('frontend/layout/frontend_template')
@section('content')
<div class="inner_page_container">
    	<div class="header_panel">
        	<div class="container">
        	 <h2>FAQs</h2>
            </div>
        </div>   
<!-- Start Products panel -->
<div class="products_panel faq_cnt"><div class="container"><div class="bs-example">
    <div class="panel-group" id="accordion">
      
      <?php 
	  $i=1;
	  if(!empty($allfaq))
	  {
		  foreach($allfaq as $eachfaq)
		  {
	  ?> 
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i;?>"><span class="num_span"><?php echo $i;?></span> {!! $eachfaq->question  !!}<i class="fa fa-minus-square pull-right"></i></a>
                </h4>
            </div>
            <div id="collapseOne<?php echo $i;?>" class="panel-collapse collapse in">
                <div class="panel-body">
                    {!! html_entity_decode($eachfaq->answer)  !!}
                </div>
            </div>
        </div>
     <?php 
		$i++;
		} 
	  }
	  else
	  {
	?>
    <div>No Data Found.</div>
	<?php 
	}
	?>
            
    </div>
</div></div></div>
<!-- End Products panel --> 
 </div>
@stop