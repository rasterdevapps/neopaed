@extends('app')
@section('content')
@php
$site_url = url('/').'/public';
@endphp
<style type="text/css">   
    #date-range {
        border: 1px solid #ddd;
        padding: 5px;
        display: flex;
        float: right;
    } 
    #fio2-chart {
        width: 25%;
        height: 400px;
        margin: auto;
    }
    #filter-icon {
        background: black;
        color: white;
        padding: 6.5px 10px;
        float: right;
        margin-left: 5px;
    }
    .loader-view {
        position: absolute;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 5;
        background: url('public/img/icons/preloader.gif') center no-repeat #F9F9F9;
    }
    .empty-div {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 24px;
        color: grey;
        font-weight: bold;
    }
    .empty-div:after {
        content: 'No data found';
    }
</style>
<link type="text/css" href="{{ $site_url }}/css/daterangepicker.css" rel="stylesheet" />
<script type="text/javascript" src="{{ $site_url }}/js/amcharts5/index.js"></script>
<script type="text/javascript" src="{{ $site_url }}/js/amcharts5/xy.js"></script>
<script type="text/javascript" src="{{ $site_url }}/js/amcharts5/themes/Animated.js"></script>
<script type="text/javascript" src="{{ $site_url }}/js/fio2-chart.js"></script>
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
        echo \SiteHelpers::menuList($mrn, 'fio2_chart');
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
        <h3 class="text-center mt-0 mb-5"><strong>{{ $baby_details->BabyName }} ({{ $baby_details->BMrNo }})</strong></h3>
        {{ Form::hidden('mrn', $baby_details->BMrNo) }}
        {{ Form::hidden('admission_date', $admission_date) }}
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
                                    <div id="filter-icon" class="pull-right">
                                        <i class="fa fa-filter" aria-hidden="true"></i>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {!! Form::label('otfrom_date', 'From:') !!}
                                </td>
                                <td>
                                    {!! Form::text('otfrom_date', date('d-m-Y'), ['class'=>'form-control input-width-small', 'id'=>'otfrom-date', 'readonly']) !!}
                                </td>
                                <td>
                                    {!! Form::select('otfrom_hours', $hours_list, '12', ['class'=>'input-width-mini select2-select-00', 'id'=>'otfrom-hour']) !!}
                                </td>
                                <td>
                                    {!! Form::select('otfrom_mins', $mins_list, '0', ['class'=>'input-width-mini select2-select-00', 'id'=>'otfrom-mins']) !!}
                                </td>
                                <td>
                                    {!! Form::select('otfrom_session', $session_list, 'AM', ['class'=>'input-width-mini select2-select-00', 'id'=>'otfrom-session']) !!}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {!! Form::label('otto_date', 'To:') !!}
                                </td>
                                <td>
                                    {!! Form::text('otto_date', date('d-m-Y'), ['class'=>'form-control input-width-small', 'id'=>'otto-date', 'readonly']) !!}
                                </td>
                                <td>
                                    {!! Form::select('otto_hours', $hours_list, '11', ['class'=>'input-width-mini select2-select-00', 'id'=>'otto-hour']) !!}
                                </td>
                                <td>
                                    {!! Form::select('otto_mins', $mins_list, '59', ['class'=>'input-width-mini select2-select-00', 'id'=>'otto-mins']) !!}
                                </td>
                                <td>
                                    {!! Form::select('otto_session', $session_list, 'PM', ['class'=>'input-width-mini select2-select-00', 'id'=>'otto-session']) !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div id="range-loader" class="loader-view display-none"></div>
                    <div id="fio2-chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
