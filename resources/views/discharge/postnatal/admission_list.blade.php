@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
@php $hide=true ; @endphp
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Dashboard</a>
		</li>
		<li >
			<a href="{{ action('Admission\PostnatalDischargeController@index') }}">Postnatal Discharge</a>
		</li> 
    <li class="current">
      <a href="javascript:void(0);">Postnatal History of {{ $baby_name }}</a>
    </li>                                               
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12">
		<div class="widget box table-view-shadow">
			<div class="widget-header">
				<h4>Postnatal Discharge</h4>
        @if(in_array('POST_DAY',$write_permission))
				<a href="{{ action('Admission\PostnatalController@create') }}" title="Create New" class="btn btn-basic-shadow hide create-btn-spacing btn-info pull-right">
  				<i class="fa fa-plus "></i>
  				 <span>Create New</span>
  			</a>  
        @endif                              
			</div>
			<div class="widget-content inherittable">    
				<div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
          <div>
		         <table class="table table-striped table-bordered @if(@count($admissionList) > 0 )  datatable @endif table-responsive"  id="data-list">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th >Admissions</th>
                  <th >{{ Lang::get('home.ip') }}</th>
                  <th data-hide="tablet,phone">Admission Date </th>
                  <th>Discharge Date</th>
                </tr>
              </thead>
              <tbody>
                
              @if(@count($admissionList) > 0 )  
                @for ($i = 0; $i <  @count($admissionList); $i++)
                <tr>
                  <td>{{ $i+1 }}</td>
                  <td>
                    <a class="@if(!in_array('POST_DISCHARGE',$write_permission)) permission-denied @endif" href=" @if(in_array('POST_DISCHARGE',$write_permission)) {{ action('Admission\PostnatalDischargeController@edit', SiteHelpers::encrypt_id($admissionList[$i]->posdisid)) }} @else javascript:void(0); @endif">
                      {{  $admissionList[$i]->episodes }}
                    </a>
                  </td>
                  <td>{{  $admissionList[$i]->ip_number }}</td>
                  <td>@if(date('Y',strtotime($admissionList[$i]->AdmissionDate)) > 1970) {{ date('d-m-Y',strtotime($admissionList[$i]->AdmissionDate)) }} @endif</td>
                  <td>{{ !is_null($admissionList[$i]->discharge_date) ? date('d-m-Y', strtotime($admissionList[$i]->discharge_date)) : ''  }}</td>
                </tr>
                @endfor
              @else
                <tr class="text-center">
                  <td colspan="3">No Record Found </td>
                </tr>  
              @endif  
             </tbody>
            </table>
          </div>
      
		</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
				<!-- /Page Content -->    
@endsection

