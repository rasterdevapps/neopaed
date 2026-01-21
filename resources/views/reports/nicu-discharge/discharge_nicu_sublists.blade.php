@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }} ">{{ Lang::get('home.nicu_summary_sub_dashborad') }}</a>
        </li>
        <li>
            <!-- <a href="{{ url('nicu-discharge-main-list') }}">{{ Lang::get('home.nicu_summary_sub_summary')}}</a> -->
            <a href="{{ action('Reports\NicuDischargeController@discharge_main_list') }}@if(isset($summary_type) && $summary_type == 'interim')/interim @endif">@if(isset($summary_type) && $summary_type == 'interim') Interim Summary @else {{ Lang::get('home.nicu_summary_summary') }} @endif</a>
        </li>
        <li class="current">
            <a href="javascript:void(0);">@if(isset($summary_type) && $summary_type == 'interim') Interim Summary of @else {{ Lang::get('home.nicu_summary_sub_history') }} @endif {{ $BabyName }}</a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>@if(isset($summary_type) && $summary_type == 'interim') Interim Summary @else {{ Lang::get('home.nicu_summary_sub_summary')}} @endif</h4>
            </div>
            <div class="widget-content inherittable">
                <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <div class="row">  
                    </div>
                </div>
                <table class="table table-striped table-bordered table-responsive datatable"  id="data-list">
                    <thead>
                        <tr>
                            <th class="hidden-xs">{{ Lang::get('home.nicu_summary_sub_sno') }}</th>
                            <th>{{ Lang::get('home.nicu_summary_sub_admission') }}</th>
                            <th>{{ Lang::get('home.ip') }}</th>
                            <th class="hidden-xs">{{ Lang::get('home.nicu_summary_sub_admission_date') }}</th>
                            @if (!isset($summary_type) || $summary_type != 'interim')
                            <th>{{ Lang::get('home.nicu_summary_sub_discharge_date') }}</th>
                            @endif
                            <!-- <th>{{ Lang::get('home.nicu_summary_sub_detailed') }}</th>
                                @if(in_array('ABBREVIATED_DISCHARGE_EDIT', Session::get('specialPermissions')))
                                <th>{{ Lang::get('home.nicu_summary_sub_edited') }}</th>
                                @endif -->
                            <!-- <th>System Generated Original Summary</th> -->
                                <!-- <th>System Generated Summary <br/> Edited Version</th> -->
                                <th>Summary</th>
                            <!-- <th>Edited Summary</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($results) > 0)
                        @php $i = 0; @endphp
                            @foreach ($results as $res_key => $result)
                            <tr>
                                <td class="hidden-xs">{{ $i+1 }}</td>
                                <td>{{  $result->episodes }}</td>
                                <td>{{  $result->ip_number }}</td>
                                <td>
                                    @if(date('Y',strtotime($result->AdmissionDate)) > 1970) 
                                    {{  date('d-m-Y',strtotime($result->AdmissionDate)) }}
                                    @endif
                                </td>
                                @if (!isset($summary_type) || $summary_type != 'interim')
                                <td class="hidden-xs">
                                    @if(date('Y',strtotime($result->DischargeDate)) > 1970) 
                                    {{  date('d-m-Y',strtotime($result->DischargeDate)) }}
                                    @endif
                                </td>
                                @endif
                              <!--   <td class="center-align-phone">
                                    <a class="btn btn-warning btn-view nicu-generated-summary" href="{{ url('nicu-discharge-summary/'.SiteHelpers::encrypt_id($result->BabyId.'-'.$result->AdmissionId.'-generated')) }}@if(isset($summary_type) && $summary_type == 'interim')/interim @endif"><i class="fa fa-print"></i></a>
                                </td> -->
                                <td class="center-align-phone">
                                    <a class="btn btn-warning btn-view" href="{{ url('nicu-discharge-summary/'.SiteHelpers::encrypt_id($result->BabyId.'-'.$result->AdmissionId)) }}@if(isset($summary_type) && $summary_type == 'interim')/interim @endif"><i class="fa fa-print"></i></a>
                                </td>
                                <!-- <td class="center-align-phone">
                                    @if(in_array('ABBREVIATED_DISCHARGE_EDIT', Session::get('specialPermissions')))
                                        <?php 
                                        $summary_details = \DB::table('nicu_problem_based_discharge_edited')->where('baby_id', $result->BabyId)->where('admission_id', $result->AdmissionId)->first(); 
                                         ?>
                                        @if(isset($summary_type) && $summary_type == 'interim' && isset($abbrivated_summary->interim_summary_content) && !is_null($abbrivated_summary->interim_summary_content))
                                        <a class="btn btn-default btn-view open-doc-editor" href="{{ url('nicu-abbrivated-summary/'.SiteHelpers::encrypt_id($result->BabyId.'-'.$result->AdmissionId)) }}/interim"><i class="fa fa-file-word-o"></i></a>

                                        @elseif(isset($abbrivated_summary->edited_content) && !is_null($abbrivated_summary->edited_content))
                                        <a class="btn btn-default btn-view open-doc-editor" href="{{ url('nicu-abbrivated-summary/'.SiteHelpers::encrypt_id($result->BabyId.'-'.$result->AdmissionId)) }}@if(isset($summary_type) && $summary_type == 'interim')/interim @endif"><i class="fa fa-file-word-o"></i></a>
                                        @else
                                        -
                                        @endif
                                    @else
                                    -
                                    @endif
                                </td> -->
                            </tr>
                            @php $i++; @endphp
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.col-md-12 -->
</div>
<!-- /.row -->
<!-- /Page Content -->
<div class="row">
    <div class="col-md-12">
    </div>
</div>
@endsection
