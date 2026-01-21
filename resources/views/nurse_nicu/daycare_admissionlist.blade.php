@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<div class="crumbs bread-crumbs-shadow ">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">{{ Lang::get('home.nurse_day_list_dashboard') }}</a>
		</li>
		<li >
			<a href="{{ action('Nurse\NicuNurseDaycareController@index') }}">{{ Lang::get('home.nurse_day_list_daycare') }}</a>
		</li>   
        <li>
            <a href="{{ action('Nurse\NicuNurseDaycareController@nicuDaycarebabySublist',$BabyId) }}">{{ Lang::get('home.nurse_day_list_history') }} {{ $baby_name }}</a>
        </li>  
         <li class="current">
            <a href="javascript:void(0);"> {{ $admission }}</a>
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
	            @if(in_array('NICU_NURSE_DAY',$write_permission))
				  <a href="{{ url('nurse-nicu-daycare/'.SiteHelpers::encrypt_id($baby_details->AdmissionId.'-'.$baby_details->BabyId)) }}" title="Create New" class="btn create-btn-spacing btn-basic-shadow btn-info pull-right"><i class="fa fa-plus "></i> <span>{{ Lang::get('home.nurse_day_list_create_new') }}</span></a>   
	            @endif                             
			</div>
			<div class="widget-content inherittable">                    
		        <table class="table table-striped table-bordered table-responsive datatable dataTable"  id="data-list">
                    <thead>
                        <tr>
                            <th>{{ Lang::get('home.nurse_day_list_sno') }}</th>
                            <th>{{ Lang::get('home.nurse_day_list_days') }}</th>
                            <th>{{ Lang::get('home.nurse_day_list_date') }}</th>
                         </tr>
                    </thead>
                    <tbody>
                        @php ($i = 0)
                    @foreach($results as $res_key => $result)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>
                              <a class="icon @if(!in_array('NICU_NURSE_DAY',$write_permission)) permission-denied @endif" href="@if(in_array('NICU_NURSE_DAY',$write_permission)) {{ action('Nurse\NicuNurseDaycareController@edit',SiteHelpers::encrypt_id($result->DayId)) }} @else javascript:void(0); @endif">
                               Day {{ $i }}
                              </a> 
                            </td>
                            <td>{{ date('d-m-Y',strtotime($result->DayDate)) }}</td>
                        </tr>     

                    @endforeach
                    </tbody>
                </table>   
            </div>
        </div>
	</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
				<!-- /Page Content -->      



@endsection
