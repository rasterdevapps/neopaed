@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{url('/')}}">Dashboard</a>
		</li>
		<li>
			<a href="{{ action('ProblemBaseDaycare\ProblemDaycareController@index') }}">Problem Base Daycare </a>
		</li> 
		<li class="current">
			<a href="javascript:void(0);">Admission List @if($babyName != '') of {{ $babyName }}  @endif</a>
		</li>                                                
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12">
		<div class="widget box table-view-shadow">
			<div class="widget-header">
				<h4>Problem Daycare Admission List</h4>                            
			</div>
			<div class="widget-content inherittable">                  
			    <table class="table table-striped table-bordered table-responsive datatable dataTable"  id="data-list">
	                <thead>
	                    <tr>
	                       <th>Admissions</th>
	                       <th>{{ Lang::get('home.ip') }}</th>
	                       <th>Date of Admission</th>	                
	                    </tr>
	                </thead>
	                <tbody>
	                @if(count($admissionList) > 0)  
	                	@php( $i =0 )
          				@foreach($admissionList as $res_key => $result)	
		                    <tr>
		                        <td>
		                        	<a href="@if(in_array('NICU_PROBLEM_DAY',$write_permission)) {{ action('ProblemBaseDaycare\ProblemDaycareController@episodeslist',SiteHelpers::encrypt_id($result->BabyId.'-'.$result->AdmissionId) ) }} @else javascript:void(0); @endif">
		                        	{{  $result->episodes }}
		                        	</a>
		                        </td>
		                        <td>{{  $result->ip_number }}</td>
		                        <td>@if(date('Y',strtotime($result->AdmissionDate)) > 1980) {{  date('d-m-Y',strtotime($result->AdmissionDate)) }} @endif</td>                              
		                    </tr>
		                @endforeach
		            @else
		             <tr> <td colspan="4" class="text-center"> No Record found !  </td></tr>
		            @endif
	                </tbody>
				</table>
        	</div>
       </div>
	</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {
  		$('.dataTables_paginate .pagination').addClass('table-view-shadow');

	});
</script>
@endsection
