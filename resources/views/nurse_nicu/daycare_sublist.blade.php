@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">{{ Lang::get('home.nurse_sublist_dashboard') }}</a>
		</li>
		<li>
			<a href="{{ action('Nurse\NicuNurseDaycareController@index') }}">{{ Lang::get('home.nurse_sublist_daycare') }}</a>
		</li> 
        <li class="current">
             <a href="javascript:void(0);"> {{ Lang::get('home.nurse_sublist_history') }} {{ $baby_name }}</a>
        </li>                                               
	</ul>
					
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12">
		<div class="widget box table-view-shadow">
			<div class="widget-header">
				<h4>{{ Lang::get('home.nurse_sublist_daycare') }}</h4>
	            @if(in_array('NICU_NURSE_DAY',$write_permission))
				  <a href="{{ action('Nurse\NicuNurseDaycareController@create') }}" title="Create New" class="btn create-btn-spacing btn-basic-shadow btn-info pull-right">
                    <i class="fa fa-plus "></i> <span>{{ Lang::get('home.nurse_sublist_create_new') }}</span>
                  </a>   
	            @endif                             
			</div>
			<div class="widget-content inherittable">                    
		        <table class="table table-striped table-bordered table-responsive datatable dataTable nurse-daycare"  id="data-list">
                    <thead>
                        <tr>
                            <th class="hidden-xs">{{ Lang::get('home.nurse_sublist_sno') }}</th>
                            <th>{{ Lang::get('home.nurse_sublist_admission') }}</th>
                            <th>{{ Lang::get('home.ip') }}</th>
                            <th>{{ Lang::get('home.nurse_sublist_doa') }}</th>
                            <th>{{ Lang::get('home.nurse_sublist_dod') }}</th>
                         </tr>
                    </thead>
                    <tbody>
                        @php ( $i = 0 )
                    @foreach($results as $res_key => $result)
                        <tr>
                            <td class="hidden-xs">{{ ++$i }}</td>
                            <td>
                                <a href="{{ action('Nurse\NicuNurseDaycareController@nicuDaycareadmissionList',SiteHelpers::encrypt_id($result->BabyId.'-'.$result->AdmissionId)) }}">
                                 {{  $result->episodes }}
                                </a>
                            </td>
                            <td>{{  $result->ip_number }}</td>
                            <td>{{  date('d-m-Y',strtotime($result->AdmissionDate)) }}</td>
                            <td>{{ date('Y',strtotime($result->DischargeDate)) > 1970 ? date('d-m-Y',strtotime($result->DischargeDate)) : '' }}</td>
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
