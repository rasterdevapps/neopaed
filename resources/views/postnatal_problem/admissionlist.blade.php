@extends('app')
@section('content')
<?php $read_permission = session('read_permission'); ?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{url('/')}}">Dashboard</a>
		</li>
		<li>
			<a href="{{ action('ProblemBaseDaycare\ProblemPostnatalController@index') }}">{!! $navigate['module_name'] !!}</a>
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
				<h4>Postnatal Problem Base System </h4>                            
			</div>
			<div class="widget-content inherittable">                  
			    <table class="table table-striped table-bordered table-responsive  @if(count($admissionList) > 0)  datatable @endif dataTable"  id="data-list">
	                <thead>
	                    <tr>
	                       <th>Admissions</th>
	                       <th>{{ Lang::get('home.ip') }}</th>
	                       <th>Date of Admission</th>	                
	                    </tr>
	                </thead>
	                <tbody>
	                @if(count($admissionList) > 0)  	
		                @for ($i = 0; $i <  @count($admissionList); $i++)
		                    <tr>
		                        <td>
		                        	<a href="@if(in_array('POST_PROBLEM_SYSTEM',$read_permission)) {{ action('ProblemBaseDaycare\ProblemPostnatalController@episodeslist',SiteHelpers::encrypt_id($admissionList[$i]->BabyId.'-'.$admissionList[$i]->AdmissionId) ) }} @else javascript:void(0); @endif">
		                        	{{  $admissionList[$i]->episodes }}
		                        	</a>
		                        </td>
		                        <td>{{  $admissionList[$i]->ip_number }}</td>
		                        <td>@if(date('Y',strtotime($admissionList[$i]->AdmissionDate)) > 1980) {{  date('d-m-Y',strtotime($admissionList[$i]->AdmissionDate)) }} @endif</td>                                            
		                    </tr>
		                @endfor
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
