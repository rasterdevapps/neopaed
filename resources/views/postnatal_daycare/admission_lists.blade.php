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
			<a href="{{ action('Admission\PostnatalDaycareController@index') }}">Postnatal Daycare</a>
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
				<h4>Daycare</h4>
        @if(in_array('POST_DAY',$write_permission))
				<a href="{{ action('Admission\PostnatalDaycareController@create') }}" title="Create New" class="btn btn-basic-shadow create-btn-spacing btn-info pull-right">
  				<i class="fa fa-plus "></i>
  				 <span>Create New</span>
  			</a>  
        @endif                              
			</div>
			<div class="widget-content inherittable">    
				<div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
          <div>
		         <table class="table table-striped table-bordered datatable table-responsive"  id="data-list">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Admissions</th>
                  <th>{{ Lang::get('home.ip') }}</th>
                  <th>Admission date</th>
                  <th data-hide="tablet,phone">Discharge date </th>
                </tr>
              </thead>
              <tbody>
              @if(@count($results) > 0 )  
                @for ($i = 0; $i <  @count($results); $i++)
                <tr>
                  <td>{{ $i+1 }}</td>
                  <td>
                    <a href="{{ url('postnatal-daycare-daywiselist/'.SiteHelpers::encrypt_id($results[$i]->AdmissionId.'-'.$results[$i]->BabyId)) }}">
                      {{  $results[$i]->episodes }}
                    </a>
                  </td>
                  <td>{{  $results[$i]->ip_number }}</td>
                  <td>{!! !is_null($results[$i]->admission_date) ? date('d-m-Y', strtotime($results[$i]->admission_date)) : '' ; !!}</td>
                  <td>@if(date('Y',strtotime($results[$i]->DayDate)) > 1970) {{ date('d-m-Y',strtotime($results[$i]->DayDate)) }} @endif</td>
                </tr>
                @endfor
              @else
                <tr class="text-center">
                  <td colspan="5">No Record Found </td>
                </tr>  
              @endif  
             </tbody>
            </table>
          </div>
      
		</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
				<!-- /Page Content -->    
@endsection
