@extends('app')
@section('content')
<?php 
$write_permission = session('write_permission');
$read_permission = session('read_permission');
 ?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{url('/')}}">Dashboard</a>
		</li>
		<li>
			<a href="{{ action('Reports\PostnatalDischargeSummary@index') }}">Problem Base Postnatal Discharge Summary</a>
		</li> 
		<li class="current">
			<a href="javascript:void(0);">Admission List @if($babyName != '') of <b class="plbabyname">{{ $babyName }} </b> @endif</a>
		</li>                                                
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12">
		<div class="widget box table-view-shadow">
			<div class="widget-header">
				<h4>Problem Base Postnatal Discharge List</h4>                            
			</div>
			<div class="widget-content inherittable">                  
			    <table class="table table-striped table-bordered table-responsive datatable dataTable"  id="data-list">
	                <thead>
	                    <tr>
	                       <th>Admissions</th>
	                       <th>{{ Lang::get('home.ip') }}</th>
	                       <th>Date of Admission</th>	                
	                       <th>Summary</th>	                
	                       <th class="hide">Edited Print</th>	                
	                    </tr>
	                </thead>
	                <tbody>
	                @if(count($admissionList) > 0)  	
		                @for ($i = 0; $i <  @count($admissionList); $i++)
		                    <tr>
		                        <td>
		                        	<a class="@if(!in_array('POST_DISCHARGE',$write_permission)) permission-denied @endif" href="@if(in_array('POST_DISCHARGE',$write_permission)) {{ action('Reports\PostnatalDischargeSummary@show', SiteHelpers::encrypt_id($admissionList[$i]->BabyId.'-'.$admissionList[$i]->AdmissionId) ) }} @else javascript:void(0); @endif">
		                        	{{  $admissionList[$i]->episodes }}
		                        	</a>
		                        </td>
		                        <td>{{  $admissionList[$i]->ip_number }}</td>
		                        <td>@if(date('Y',strtotime($admissionList[$i]->AdmissionDate)) > 1980) {{  date('d-m-Y',strtotime($admissionList[$i]->AdmissionDate)) }} @endif</td>                                            
		                        <td>
		                        	<a class="btn btn-warning btn-view @if(!in_array('POST_DISCHARGE',$read_permission)) permission-denied @endif" href="@if(in_array('POST_DISCHARGE',$read_permission)) {{ action('Reports\PostnatalDischargeSummary@show', SiteHelpers::encrypt_id($admissionList[$i]->BabyId.'-'.$admissionList[$i]->AdmissionId) ) }} @else javascript:void(0); @endif" title="Generated Print">
                          <i class="fa fa-print"></i> 
                      </a>

		                        </td>
		                        <td class="hide">
		                        	@if($admissionList[$i]->edited)
		                        	<a class="btn btn-default btn-view open-doc-editor @if(!in_array('POST_DISCHARGE',$write_permission)) permission-denied @endif" href="@if(in_array('POST_DISCHARGE',$write_permission)) {{ action('Reports\PostnatalDischargeSummary@getAbbreviatedsummaryShow', SiteHelpers::encrypt_id($admissionList[$i]->BabyId.'-'.$admissionList[$i]->AdmissionId) ) }} @else javascript:void(0); @endif" title="Final Print">
                          <i class="fa fa-file-word-o"></i> 
		                        	</a>
		                        	@else
		                        	-
		                        	@endif
		                        </td>
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
