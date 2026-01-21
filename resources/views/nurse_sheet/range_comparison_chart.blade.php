@extends('app')
@section('content')
@php
$site_url = url('/').'/public';
@endphp
<style type="text/css">
</style>
<link type="text/css" href="{{ $site_url }}/css/daterangepicker.css" rel="stylesheet" />
<link type="text/css" href="{{ $site_url }}/css/range-comparison-chart.css" rel="stylesheet" />
<script type="text/javascript" src="{{ $site_url }}/js/amcharts5/index.js"></script>
<script type="text/javascript" src="{{ $site_url }}/js/amcharts5/xy.js"></script>
<script type="text/javascript" src="{{ $site_url }}/js/amcharts5/themes/Animated.js"></script>
<script type="text/javascript" src="{{ $site_url }}/js/range-comparison-chart.js"></script>
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li class="current">
            <a href="javascript:void(0);" title="">Chart for {{ $baby_details->BabyName }} ({{ $baby_details->BMrNo }})</a>
        </li>
    </ul>
    <div class="pull-right">
        @php 
        $mrn = $baby_details->BMrNo; 
        echo \SiteHelpers::menuList($mrn, 'range_chart');
        @endphp
    </div>
</div>
@php 
$hours_list = SiteHelpers::prepare_time()['time'];
$mins_list = SiteHelpers::prepare_time()['mins']; 
$session_list = SiteHelpers::prepare_time()['session']; 
@endphp
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <h3 class="text-center mt-0 mb-5"><strong>{{ $baby_details->BabyName }} ({{ $baby_details->BMrNo }})</strong></h3>
            {{ Form::hidden('baby_id', $baby_details->BabyId) }}
            {{ Form::hidden('admission_date', $admission_date) }}
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="widget box">
                    <div class="widget-content row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                            
                            <table id="date-range" class="default">
                                <tbody>
                                    <tr>
                                        <td colspan="5">
                                            <label><strong>Date & Time Range:</strong></label>
                                        </td>
                                        <td rowspan="3">                                            
                                            <div id="comparison-icon" class="pull-right">
                                                <i class="fa fa-exchange" aria-hidden="true"></i>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {!! Form::label('dtfrom_date', 'From:') !!}
                                        </td>
                                        <td>
                                            {!! Form::text('dtfrom_date', date('d-m-Y'), ['class'=>'form-control input-width-small', 'id'=>'dtfrom-date', 'readonly']) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('dtfrom_hours', $hours_list, '12', ['class'=>'input-width-mini select2-select-00', 'id'=>'dtfrom-hour']) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('dtfrom_mins', $mins_list, '0', ['class'=>'input-width-mini select2-select-00', 'id'=>'dtfrom-mins']) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('dtfrom_session', $session_list, 'AM', ['class'=>'input-width-mini select2-select-00', 'id'=>'dtfrom-session']) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {!! Form::label('dtto_date', 'To:') !!}
                                        </td>
                                        <td>
                                            {!! Form::text('dtto_date', date('d-m-Y'), ['class'=>'form-control input-width-small', 'id'=>'dtto-date', 'readonly']) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('dtto_hours', $hours_list, '11', ['class'=>'input-width-mini select2-select-00', 'id'=>'dtto-hour']) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('dtto_mins', $mins_list, '59', ['class'=>'input-width-mini select2-select-00', 'id'=>'dtto-mins']) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('dtto_session', $session_list, 'PM', ['class'=>'input-width-mini select2-select-00', 'id'=>'dtto-session']) !!}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div id="comparison-date-range" class="display-none">
                                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td colspan="5">
                                                    <label><strong>Base Date & Time Range (D1):</strong></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {!! Form::label('bdtfrom_date', 'From:') !!}
                                                </td>
                                                <td>
                                                    {!! Form::text('bdtfrom_date', date('d-m-Y'), ['class'=>'form-control input-width-small', 'id'=>'bdtfrom-date', 'readonly']) !!}
                                                </td>
                                                <td>
                                                    {!! Form::select('bdtfrom_hours', $hours_list, '12', ['class'=>'input-width-mini select2-select-00', 'id'=>'bdtfrom-hour']) !!}
                                                </td>
                                                <td>
                                                    {!! Form::select('bdtfrom_mins', $mins_list, '0', ['class'=>'input-width-mini select2-select-00', 'id'=>'bdtfrom-mins']) !!}
                                                </td>
                                                <td>
                                                    {!! Form::select('bdtfrom_session', $session_list, 'AM', ['class'=>'input-width-mini select2-select-00', 'id'=>'bdtfrom-session']) !!}        
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {!! Form::label('bdtto_date', 'To:') !!}
                                                </td>
                                                <td>
                                                    {!! Form::text('bdtto_date', date('d-m-Y'), ['class'=>'form-control input-width-small', 'id'=>'bdtto-date', 'readonly']) !!}
                                                </td>
                                                <td>
                                                    {!! Form::select('bdtto_hours', $hours_list, '11', ['class'=>'input-width-mini select2-select-00', 'id'=>'bdtto-hour']) !!}
                                                </td>
                                                <td>
                                                    {!! Form::select('bdtto_mins', $mins_list, '59', ['class'=>'input-width-mini select2-select-00', 'id'=>'bdtto-mins']) !!}
                                                </td>
                                                <td>
                                                    {!! Form::select('bdtto_session', $session_list, 'PM', ['class'=>'input-width-mini select2-select-00', 'id'=>'bdtto-session']) !!}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                    <table>
                                        <tr>
                                            <td colspan="5">
                                                <label><strong>Compare Date & Time Range (D2):</strong></label>
                                            </td>
                                            <td rowspan="3">                                                
                                                <div id="reset-icon" class="display-none pull-right">
                                                    <i class="fa fa-refresh" aria-hidden="true"></i>
                                                </div>
                                                <div id="apply-btn" class="pull-right">
                                                    <i class="fa fa-filter" aria-hidden="true"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                {!! Form::label('cdtfrom_date', 'From:') !!}
                                            </td>
                                            <td>
                                                {!! Form::text('cdtfrom_date', date('d-m-Y'), ['class'=>'form-control input-width-small', 'id'=>'cdtfrom-date', 'readonly']) !!}
                                            </td>
                                            <td>
                                                {!! Form::select('cdtfrom_hours', $hours_list, '12', ['class'=>'input-width-mini select2-select-00', 'id'=>'cdtfrom-hour']) !!}
                                            </td>
                                            <td>
                                                {!! Form::select('cdtfrom_mins', $mins_list, '0', ['class'=>'input-width-mini select2-select-00', 'id'=>'cdtfrom-mins']) !!}
                                            </td>
                                            <td>
                                                {!! Form::select('cdtfrom_session', $session_list, 'AM', ['class'=>'input-width-mini select2-select-00', 'id'=>'cdtfrom-session']) !!}        
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                {!! Form::label('cdtto_date', 'To:') !!}
                                            </td>
                                            <td>
                                                {!! Form::text('cdtto_date', date('d-m-Y'), ['class'=>'form-control input-width-small', 'id'=>'cdtto-date', 'readonly']) !!}
                                            </td>
                                            <td>
                                                {!! Form::select('cdtto_hours', $hours_list, '11', ['class'=>'input-width-mini select2-select-00', 'id'=>'cdtto-hour']) !!}
                                            </td>
                                            <td>
                                                {!! Form::select('cdtto_mins', $mins_list, '59', ['class'=>'input-width-mini select2-select-00', 'id'=>'cdtto-mins']) !!}
                                            </td>
                                            <td>
                                                {!! Form::select('cdtto_session', $session_list, 'PM', ['class'=>'input-width-mini select2-select-00', 'id'=>'cdtto-session']) !!}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3 class="text-center mt-10 mb-0" id="range-chart"></h3>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="range-container">
                            <div class="row">
                                <div id="range-loader" class="loader-view display-none"></div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="range-view-0" class="comparison-chart"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="range-view-1" class="comparison-chart"></div>
                                </div>
                                <div class="col-lg-offset-3 col-lg-6 col-md-12">
                                    <div id="range-view-2" class="comparison-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget box">
                    <div class="widget-content row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table id="ddate-range">
                                <tbody>
                                    <tr>
                                        <td colspan="4">
                                            <label><strong>Date Range:</strong></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {!! Form::label('dfrom_date', 'From:') !!}
                                        </td>
                                        <td>
                                            {!! Form::text('dfrom_date', date('d-m-Y'), ['class'=>'form-control input-width-small', 'id'=>'dfrom-date', 'readonly']) !!}
                                        </td>
                                        <td>
                                            {!! Form::label('dto_date', 'To:') !!}
                                        </td>
                                        <td>
                                            {!! Form::text('dto_date', date('d-m-Y'), ['class'=>'form-control input-width-small', 'id'=>'dto-date', 'readonly']) !!}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3 class="text-center mt-10 mb-0" id="table-chart"></h3>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div id="table-container">
                                <div id="table-loader" class="loader-view display-none"></div>
                                <div role="tabpanel" class="tabbable tabbable-custom"></div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
