@extends('app')
@section('content')
<style>
    .not-active-btn
    {
        opacity: 0.5;
    }
    .active-btn
    {
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
      0% {
        transform: scale(.9);
    }
    70% {
        transform: scale(1);
        box-shadow: 0 0 0 7px #4d77cc5c;
    }
    100% {
        transform: scale(.9);
        box-shadow: 0 0 0 0 #4d77cc5c;
    }
</style>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>            
            <a href="{{ url('/') }}"><i class="fa fa-home"></i></a>
        </li>
        <li class="">
            <a title="" href="{{ action('Admission\PediatricController@index') }}">Pediatric Admission</a>
        </li>
        <li class="">
            <a title="" href="{{ action('Admission\PediatricController@sublist',\SiteHelpers::encrypt_id($baby_detail->baby_id)) }}">Admission List</a>
        </li>
        <li class="current">
            <a title="">Edit</a>
        </li> 
    </ul>
</div>
<!-- /Breadcrumbs line -->
<div class="row mt-10">

    <a class="btn btn-primary pull-right mb-10 mlr-10 @if($current_age >= 5) active-btn @else not-active-btn @endif" id="Greater-than-five-chart" href="{{ action('charts\WhoGrowthChartcontroller@greaterthanfive').'?baby_id='.SiteHelpers::encrypt_id($baby_detail->baby_id).'&closewinlink=pediatric_admission_edit&id='.SiteHelpers::encrypt_id($baby_detail->id) }}">WHO Growth Chart (>= 5)</a>
    
    <a class="btn btn-primary pull-right mb-10 mlr-10 @if($current_age < 5) active-btn @else not-active-btn @endif" id="zero-five-chart" href="{{ action('charts\WhoGrowthChartcontroller@index').'?baby_id='.SiteHelpers::encrypt_id($baby_detail->baby_id).'&closewinlink=pediatric_admission_edit&id='.SiteHelpers::encrypt_id($baby_detail->id) }}"> WHO Growth Chart</a>
    <a class="btn btn-primary pull-right mb-10 mlr-10 @if($current_age < 5) active-btn @else not-active-btn @endif" id="zero-five-chart" href="{{ action('charts\ZScoreChartController@index').'?baby_id='.SiteHelpers::encrypt_id($baby_detail->baby_id).'&closewinlink=pediatric_admission_edit&id='.SiteHelpers::encrypt_id($baby_detail->id) }}"> Zscore Growth Chart</a>
    <a class="btn btn-primary pull-right mb-10 mlr-10 not-active-btn" id="intergrowth-chart" href="{{ action('charts\InterGrowthChartController@index').'?baby_id='.SiteHelpers::encrypt_id($baby_detail->baby_id).'&closewinlink=pediatric_admission_edit&id='.SiteHelpers::encrypt_id($baby_detail->id) }}">Intergrowth 21st Century Chart</a>

</div>
<div class="row row-spacing">
    <div class="col-md-12" id="edit-pediatric">
        {!! Form::model($baby_detail,['method'=> 'PATCH','url' => action('Admission\PediatricController@update', $baby_detail->id),'id'=>'pediatric-form']) !!}
        @include('errors.list')
        @include('admission.pediatric.form')
        <div class="col-md-12 col-sm-12 col-xs-12 tab-view-shadow ptb-15 action-btn">
            <input type="hidden" name="print_flag" value="0" id="print_flag" />
            <div class="col-md-3 col-sm-6 col-xs-12">
                <button type="button" class="btn btn-primary btn-basic-shadow btn-block form-control pediatric-update" data-flag="1">
                    <i class="fa fa-floppy-o"></i>
                    <span>Update & Next</span>
                </button>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <button type="button" class="btn btn-primary btn-basic-shadow btn-block form-control pediatric-update" data-flag="2">
                    <i class="fa fa-floppy-o"></i>
                    <span>Update</span>
                </button>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 hide" id="admission-print">
                <button type="button" class="btn btn-block  btn-basic-shadow btn-info form-control pediatric-update" data-flag="3">
                    <i class="fa fa-print"></i>
                    <span>Admission Profroma Print</span>
                </button>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 hide" id="summary-print">
                <button type="button" class="btn btn-block  btn-basic-shadow btn-info form-control pediatric-update" data-flag="4">
                    <i class="fa fa-print"></i>
                    <span>Summary Print</span>
                </button>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="{{ action('Admission\PediatricController@index') }}" class="btn btn-basic-shadow btn-default btn-block form-control" onclick="$('form')[0].reset();">
                    <i class="fa fa-exclamation-circle"></i>
                    <span>Cancel</span>
                </a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
