@extends('print')
@section('content')
@php
$site_url = url('/').'/public';
$write_permission = session('write_permission');
@endphp

<div class="temp-container">
    <div class="temp-row mt-15">
        <div class="col-md-11">
            <div class="col-md-6">
                <img src="{{ ValuelistHelpers::printPagelogo() }}">
            </div>
        </div>
        <div class="col-md-11">
            <h3 class="print-head">
               WHO Growth Chart - Birth to Five Years

           </h3>
       </div> 
       <div class="col-md-12" style="margin-bottom: 30px;">
            <div class="col-md-6 col-sm-6 col-xs-6">
                Baby Name : {{ $baby->BabyName}}
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                B{{ Lang::get('home.mrn') }} : {{ $baby->BMrNo}}
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                DOB : {{ date('d-m-Y', strtotime($baby->DOB)) }}
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                Gestation : {{ SiteHelpers::decode_gestation($baby->Gestation)}}
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                Gender : {{ $baby->Sex }}
            </div>
        </div>
        <input type="hidden" name="wt_provider" value="{{ json_encode($wt_provider) }}">
        <input type="hidden" name="ht_provider" value="{{ json_encode($ht_provider) }}">
        <input type="hidden" name="hc_provider" value="{{ json_encode($hc_provider) }}">

        <input type="hidden" name="wt_value_count" value="{{ json_encode($wt_value_count) }}">
        <input type="hidden" name="ht_value_count" value="{{ json_encode($ht_value_count) }}">
        <input type="hidden" name="hc_value_count" value="{{ json_encode($hc_value_count) }}">

        <input type="hidden" name="corrected_gestation_plot" value="{{ $corrected_gestation_plot }}">

        @php $theme_setting = (strtolower($baby->Sex) == 'male') ? '#2F97DA' : '#E65EB6'; @endphp
        @php $theme_name = (strtolower($baby->Sex) == 'male') ? 'BOYS' : 'GIRLS'; @endphp
        <input type="hidden" name="color" value="{{$theme_setting}}">
        <input type="hidden" name="gender" value="{{strtolower($baby->Sex)}}">
        <div id="wt-container" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div id="wt-header-container" class="theme-{{strtolower($baby->Sex)}} ">
                <div class="pull-left">
                    <span class="chart-title left-spacing">Weight-for-age {{$theme_name}}</span>
                    <span class="underline"></span>
                    <span class="left-spacing text-left chart-title-1">Birth to 5 years (percentiles)</span>
                </div>
                <div class="pull-right mt-15">
                    <img src="{{$site_url}}/img/who-logo.png">
                </div>
            </div>
            <div id="wt-chart-container" class="pull-left full-width"></div>
            <div id="wt-chart-text">
                <span class="pull-right pt-5">WHO Child Growth Standards</span>
            </div>
        </div>
        <div id="ht-container" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div id="ht-header-container" class="theme-{{strtolower($baby->Sex)}} ">
                <div class="pull-left">
                    <span class="chart-title left-spacing">Length/height-for-age {{$theme_name}}</span>
                    <span class="underline"></span>
                    <span class="left-spacing text-left chart-title-1">Birth to 5 years (percentiles)</span>
                </div>
                <div class="pull-right mt-15">
                    <img src="{{$site_url}}/img/who-logo.png">
                </div>
            </div>
            <div id="ht-chart-container" class="pull-left full-width"></div>
            <div id="ht-chart-text">
                <span class="pull-right pt-5">WHO Child Growth Standards</span>
            </div>
        </div>
        <div id="hc-container" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div id="hc-header-container" class="theme-{{strtolower($baby->Sex)}} ">
                <div class="pull-left">
                    <span class="chart-title left-spacing">Head circumference-for-age {{$theme_name}}</span>
                    <span class="underline"></span>
                    <span class="left-spacing text-left chart-title-1">Birth to 5 years (percentiles)</span>
                </div>
                <div class="pull-right mt-15">
                    <img src="{{$site_url}}/img/who-logo.png">
                </div>
            </div>
            <div id="hc-chart-container" class="pull-left full-width"></div>
            <div id="hc-chart-text">
                <span class="pull-right pt-5">WHO Child Growth Standards</span>
            </div>
        </div>
    </div>
</div>
@endsection
