@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }} ">{{ Lang::get('home.nicu_problem_sub_dashboard') }}</a>
        </li>
        <li>
            <a href="{{ action('Reports\ProblemDischargeController@dischargeBabylist') }}@if(isset($summary_type) && $summary_type == 'interim')/interim @endif">@if(isset($summary_type) && $summary_type == 'interim') Interim Summary ( Problem Based ) @else {{ Lang::get('home.nicu_problem_sub_summary') }} @endif</a>
            <!-- <a href="{{ action('Reports\ProblemDischargeController@dischargeBabylist') }}">{{ Lang::get('home.nicu_problem_sub_summary') }}</a> -->
        </li>
        <li class="current">
            <a href="javascript:void(0);">@if(isset($summary_type) && $summary_type == 'interim') Interim Summary ( Problem Based ) @else {{ Lang::get('home.nicu_problem_sub_history') }} @endif {{ $BabyName }}</a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>@if(isset($summary_type) && $summary_type == 'interim') Interim Summary ( Problem Based ) @else {{ Lang::get('home.nicu_problem_sub_summary') }} @endif</h4>
            </div>
            <div class="widget-content inherittable">
                <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <div class="row">  
                    </div>
                </div>
                <table class="table table-striped table-bordered table-responsive datatable"  id="data-list">
                    <thead>
                        <tr>
                            <th class="hidden-xs">{{ Lang::get('home.nicu_problem_sub_sno') }}</th>
                            <th>{{ Lang::get('home.nicu_problem_admission') }}</th>
                            <th>{{ Lang::get('home.ip') }}</th>
                            <th class="hidden-xs">{{ Lang::get('home.nicu_problem_admission_date') }}</th>
                            @if (!isset($summary_type) || $summary_type != 'interim')
                            <th>{{ Lang::get('home.nicu_problem_discharge_date') }}</th>
                            @endif
                            <!-- <th class="center-align-phone">{{ Lang::get('home.nicu_problem_detailed') }}</th> -->
                            <!-- <th class="center-align-phone">System Generated Original Summary</th> -->
                            <!-- <th class="center-align-phone">Edited Summary</th> -->
                            <th class="center-align-phone">Summary</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 0; @endphp
                        @foreach ($results as $value)
                        @if(isset($value->episodes))
                        <tr>
                            <td class="hidden-xs">{{ $i+1 }}</td>
                            <td>{{  $value->episodes }}</td>
                            <td>
                                @if(isset($value->ip_number) && !empty($value->ip_number))
                                {{  $value->ip_number }}
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                @if(date('Y',strtotime($value->AdmissionDate)) > 1970) 
                                {{  date('d-m-Y',strtotime($value->AdmissionDate)) }}
                                @endif
                            </td>
                            @if (!isset($summary_type) || $summary_type != 'interim')
                            <td class="hidden-xs">
                                @if(date('Y',strtotime($value->DischargeDate)) > 1970) 
                                {{  date('d-m-Y',strtotime($value->DischargeDate)) }}
                                @endif
                            </td>
                            @endif
                            <td class="center-align-phone">
                                <a class="btn btn-warning btn-view"  href="{{ url('problems-discharge-summary/'.SiteHelpers::encrypt_id($value->BabyId.'-'.$value->AdmissionId)) }}@if(isset($summary_type) && $summary_type == 'interim')/interim @endif" title="Generated Print"><i class="fa fa-print"></i></a>
                            </td>
                            <!-- <td class="center-align-phone">
                                @if ($value->edited || ($summary_type == 'interim' && !is_null($value->interim_updated_at)))
                                <a class="btn btn-default btn-view open-doc-editor"  href="{{ url('nicu-pblm-disch-abbreviated/'.SiteHelpers::encrypt_id($value->BabyId.'-'.$value->AdmissionId)) }}@if(isset($summary_type) && $summary_type == 'interim')/interim @endif" title="Final Print"><i class="fa fa-file-word-o"></i></a>
                                @else
                                -
                                @endif
                            </td> -->
                        </tr>
                        @php $i++; @endphp
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.col-md-12 -->
</div>
<!-- /.row -->
<!-- /Page Content -->
@endsection
