@extends('app')
@section('content')
@php
$site_url = url('/').'/public';
@endphp
<style type="text/css">
    #event-chart, #empty-chart {
        width: 100%;
        height: 500px;
        margin-top: 15px;
        margin-bottom: 15px;
        margin: auto;
    }
    #empty-chart{
        display: grid;
        justify-content: center;
        align-content: center;
        color: #e6e6e6;
        font-size: 50px;
        font-weight: bold;
    }
    .select-view {
        border: 1px solid #ddd;
        padding: 5px;
        margin-right: 15px;
        float: right;
    }
    .loader-view {
        position: absolute;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 5;
        background: url('./public/img/icons/preloader.gif') center no-repeat #F9F9F9;
    }
    .highlight a {
        background-color: #5EAF5E !important;
        color: white !important;
    }
</style>
<link type="text/css" href="{{ $site_url }}/css/daterangepicker.css" rel="stylesheet" />
<script type="text/javascript" src="{{ $site_url }}/js/amcharts5/index.js"></script>
<script type="text/javascript" src="{{ $site_url }}/js/amcharts5/xy.js"></script>
<script type="text/javascript" src="{{ $site_url }}/js/amcharts5/themes/Animated.js"></script>
<script type="text/javascript" src="{{ $site_url }}/js/care-event.js"></script>
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li><a href="{{ action('Nurse\DashboardEventController@index') }}">Chart</a></li>
        <li class="current">
            <a href="javascript:void(0);" title="">{{ $baby_details->BabyName }} ({{ $baby_details->BMrNo }})</a>
        </li>
    </ul>
    <div class="pull-right">
        @php 
        $mrn = $baby_details->BMrNo; 
        echo \SiteHelpers::menuList($mrn, 'care_event_chart');
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
            {{ Form::hidden('mrn', $baby_details->BMrNo) }}
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="widget box">
                    <div class="widget-content row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">   
                            <div class="select-view">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td colspan="5">
                                                <label><strong>Date Range:</strong></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                {!! Form::label('from_date', 'From:') !!}
                                            </td>
                                            <td>
                                                {!! Form::text('from_date', date('d-m-Y'), ['class'=>'form-control input-width-small', 'id'=>'from-date', 'readonly']) !!}
                                            </td>
                                            <td>
                                                {!! Form::label('to_date', 'To:') !!}
                                            </td>
                                            <td>
                                                {!! Form::text('to_date', date('d-m-Y'), ['class'=>'form-control input-width-small', 'id'=>'to-date', 'readonly']) !!}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>    
                            <div class="select-view">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td colspan="2">
                                                <label><strong>Select Admission:</strong></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                {!! Form::hidden('admission_date', json_encode($date)) !!}
                                                {!! Form::select('admission', $admission_ids, null, ['class'=>'form-control']) !!}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>                 
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 overflow-auto mt-15">
                            <div id="range-loader" class="loader-view display-none"></div>
                            <div id="event-chart"></div>
                            <div class="text-center mt-10 mb-0 hide" id="empty-chart">No events found</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
