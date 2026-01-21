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
               Intergrowth 21st Century Chart
           </h3>
       </div> 
    </div>
    <div class="col-md-12" style="margin-bottom: 30px;">
        <div class="col-md-6 col-sm-6 col-xs-6">
            Baby Name : {{ $baby_detail->BabyName}}
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6">
            B{{ Lang::get('home.mrn') }} : {{ $baby_detail->BMrNo}}
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6">
            DOB : {{ date('d-m-Y', strtotime($baby_detail->DOB)) }}
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6">
            Gestation : {{ SiteHelpers::decode_gestation($baby_detail->Gestation)}}
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6">
            Gender : {{ $baby_detail->Sex }}
        </div>
    </div>
    <div class="clearfix"></div> 
    <input type="hidden" name="wt_percentiles" value="{{ json_encode($wt_percentiles) }}">
    <input type="hidden" name="ht_percentiles" value="{{ json_encode($ht_percentiles) }}">
    <input type="hidden" name="hc_percentiles" value="{{ json_encode($hc_percentiles) }}">

    <input type="hidden" name="wt_value_count" value="{{ json_encode($wt_value_count) }}">
    <input type="hidden" name="ht_value_count" value="{{ json_encode($ht_value_count) }}">
    <input type="hidden" name="hc_value_count" value="{{ json_encode($hc_value_count) }}">
    
    <input type="hidden" name="corrected_gestation_plot" value="{{ json_encode($corrected_gestation_plot) }}">

    @php $theme_setting = (strtolower($baby_detail->Sex) == 'male') ? '#2F97DA' : '#E65EB6'; @endphp
    @php $theme_name = (strtolower($baby_detail->Sex) == 'male') ? 'BOYS' : 'GIRLS'; @endphp
    <input type="hidden" name="color" value="{{$theme_setting}}">
    <input type="hidden" name="gender" value="{{strtolower($baby_detail->Sex)}}">
    <div id="wt-container" class="col-xs-12">
        <h4 class="chart-title">Weight</h4>
        <div id="wt-chart-container" class="pull-left full-width"></div>
    </div>
    <div class="clearfix"></div> 
    <div id="ht-container" class="col-xs-12">
        <h4 class="chart-title">Length</h4>
        <div id="ht-chart-container" class="pull-left full-width"></div>
    </div>
    <div class="clearfix"></div> 
    <div id="hc-container" class="col-xs-12">
        <h4 class="chart-title">Head Circumference</h4>
        <div id="hc-chart-container" class="pull-left full-width"></div>
    </div>
</div>
</div>
@endsection
