@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<?php $delete_permission = session('delete_permission'); ?>
<!-- Breadcrumbs line -->
<style type="text/css">
  .tooltip-arrow::after
  {
    content: none !important;
  }
  .tooltip-arrow
    {  
      width: auto;
      height: auto;
    }
</style>
<div class="crumbs bread-crumbs-shadow ">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{url('/')}}">Dashboard</a>
		</li>
		<li>
			<a href="{{ action('ProblemBaseDaycare\ProblemDaycareController@index') }}">Problem Base Daycare </a>
		</li> 
		<li class="current">
			<a href="javascript:void(0);">Admission List</a>
		</li> 
		<li class="current">
			<a href="javascript:void(0);">Problem List @if($babyName != '') of  <b class="plbabyname"> {{ $babyName }} @endif </b> </a>
		</li>                                               
	</ul>
    <div class="pull-right">
    	@if (!empty($bmrn))
        @php
        echo \SiteHelpers::menuList($bmrn, 'problem_base_daycare_list');
        @endphp
        @endif
    </div>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12 default-table">
		<div class="widget box table-view-shadow">
			<div class="widget-header">
				<h4>Problems List</h4>
	            @if(in_array('NICU_PROBLEM_DAY',$write_permission))
					<a href="{{ action('ProblemBaseDaycare\ProblemDaycareController@create',$babyadmission) }}" title="Create New Sheet" class="btn btn-info btn-basic-shadow get_problem_list pull-right create-btn-spacing">
						<i class="fa fa-plus "></i> 
						<span>Add New Problem</span>
					</a>  
	            @endif                              
			</div>
			<div class="widget-content">                  
			    <table class="table table-striped table-bordered table-responsive @if(count($episodelist) > 0)  datatable @endif dataTable"  id="data-list">
	                <thead>
	                    <tr>
	                       <th>Problems</th>
                  @if(in_array('NICU_PROBLEM_DAY',$delete_permission))
	                       <th>Delete</th>
	                    </tr>
		            @endif
	                </thead>
	                <tbody>
	                @if(count($episodelist) > 0)  	
		                @for ($i = 0; $i <  @count($episodelist); $i++)
		                  @php $j = $i+1; @endphp
                          @if(isset($episodelist[$i]->problem_name))
		                    <tr>
		                        <td>
		                        	<a href="@if(in_array('NICU_PROBLEM_DAY',$write_permission)) {{ action('ProblemBaseDaycare\ProblemDaycareController@edit',SiteHelpers::encrypt_id($episodelist[$i]->pb_day_id) ) }} @else javascript:void(0); @endif">
		                        	{{  $episodelist[$i]->problem_name }}
		                        	</a>
		                        	@php $episode_status = SiteHelpers::getProblemStatus($episodelist[$i]->problem_id, $episodelist[$i]->baby_id ); @endphp
                              @if($episode_status == 'completed')
                              <a href="javascript:void(0);" class="tick btn-success tooltip_link" data-toggle="tooltip" title="Completed"><i class="fa fa-check" aria-hidden="true"></i></a>
                              @elseif($episode_status == 'incomplete')
                              <a href="javascript:void(0);" class="info-tick btn-info tooltip_link" data-toggle="tooltip" title="Incomplete"><i class="fa fa-info" aria-hidden="true"></i></a>
                              @endif
		                        </td>
                  @if(in_array('NICU_PROBLEM_DAY',$delete_permission))
		                        <td>
		                        	<a class="btn btn-danger btn-view" href="javascript:void(0);" onclick="DeleteData({{ $episodelist[$i]->pb_day_id }})">
					                    <i class="fa fa-trash"></i> 
					                 </a>
		                        </td>
		            @endif
		                    </tr>
                          @endif
		                @endfor
		            @else
		             <tr> <td colspan="2" class="text-center"> No Record found !  </td></tr>
		            @endif
	                </tbody>
				</table>
        	</div>
       </div>
	</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
<div class="problem-module">
	
</div>
{!! Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']) !!}
{!! Form::close() !!}   
@endsection
@section('scripts')
<script type="text/javascript">
 
 $(document).ready(function() {

   $('.tooltip_link').tooltip();
   $('.get_problem_list').click(function(e) {
      e.preventDefault();
      var link          = $(this).attr('href');
      var btnobject     = $(this);

       $.ajax({
       	
              type : 'get',
              url  : link,
              beforeSend : function() {
               btnobject.children('i').addClass('fa-spinner fa-spin');
               btnobject.attr('disabled','true');
              },
              success:function(responseText) {
              	$('.problem-module').html(responseText.list);
              },
              complete:function() {
              	 btnobject.children('i').removeClass('fa-spinner fa-spin');
                 btnobject.removeAttr('disabled');

                 $("#problem_id").select2({});
              	 $('#episodes').modal({backdrop: 'static', show: true, keyboard: false });
              },
              error:function(Response) {
              	 btnobject.children('i').removeClass('fa-spinner fa-spin');
                 btnobject.removeAttr('disabled');
                 var responseText = JSON.parse(Response.responseText);
                 Showalert(responseText.status,responseText.message);
              	
              } 

       });

   });	

 });
function DeleteData(id) {
	bootbox.confirm("Are you sure?",function(confirmed) {
		if(confirmed){
			$("#DeleteForm").attr('action',"{{ action('ProblemBaseDaycare\ProblemDaycareController@index') }}/"+id);
			$("#DeleteForm").submit();
		}
	});
}


	
</script>
@endsection
