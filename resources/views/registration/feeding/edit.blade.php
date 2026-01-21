@extends('app')
@section('content')
@php
$site_url = url('/').'/public';
$write_permission = session('write_permission');
@endphp
<style type="text/css">
    .not-active-btn {
        opacity: 0.5;
    }
    .active-btn {
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
    }
</style>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="fa fa-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li><a href="{{ action('Registration\FeedingController@index') }}">Feeding</a></li>
        <li class="current"><a title="">Edit @if(isset($results->BabyName)){{ $results->BabyName.' - '.$results->BMrNo }} @endif</a></li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing" id="edit-feeding">
    <div class="col-md-12">
        <div class="row">
    <a class="btn btn-primary pull-right mb-10 mlr-10 @if($current_age >= 5) active-btn @else not-active-btn @endif" href="{{ action('charts\WhoGrowthChartcontroller@greaterthanfive').'?baby_id='.SiteHelpers::encrypt_id($results->baby_id).'&closewinlink=feeding_edit&id='.SiteHelpers::encrypt_id($results->id) }}">WHO Growth Chart (>= 5)</a>
    
    <a class="btn btn-primary pull-right mb-10 mlr-10 @if(isset($results->g_weeks) && ((empty($results->g_weeks) || (isset($results->g_weeks) && $results->g_weeks > 36)) || (isset($results->g_weeks) && $results->g_weeks <= 36 && $current_chart_age > 64)) && $current_age < 5) active-btn @else not-active-btn @endif" href="{{ action('charts\WhoGrowthChartcontroller@index').'?baby_id='.SiteHelpers::encrypt_id($results->baby_id).'&closewinlink=feeding_edit&id='.SiteHelpers::encrypt_id($results->id) }}"> WHO Growth Chart</a>

    <a class="btn btn-primary pull-right mb-10 mlr-10 @if(isset($results->g_weeks) && !empty($results->g_weeks) && $results->g_weeks < 37 && $current_chart_age <= 64 && $current_age < 5) active-btn @else not-active-btn @endif" href="{{ action('charts\InterGrowthChartController@index').'?baby_id='.SiteHelpers::encrypt_id($results->baby_id).'&closewinlink=feeding_edit&id='.SiteHelpers::encrypt_id($results->id) }}">Intergrowth 21st Century Chart</a>

    <span class="pull-right pt-5" style="font-size: 14px;"><b>Current Weight: {{(isset($results->current_weight) && $results->current_weight > 0) ? number_format($results->current_weight / 1000, 3) . ' KG' : 'null'}}</b></span>
</div>

        {!! Form::model($results,['method'=> 'PATCH','url' => action('Registration\FeedingController@update', $results->id),'id'=>'feeding-form']) !!}
        {!! Form::hidden('id', $results->id) !!}        
        {!! Form::hidden('baby_id', $results->baby_id) !!}        
        {!! Form::hidden('mother_id', $results->mother_id) !!}        
        {!! Form::hidden('type', @$type) !!}   

        <div role="tabpanel" class="tabbable tabbable-custom">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="{{ $active_tab == '#babyform' ? 'active' : '' }}">
                    <a href="#babyform" aria-controls="babyform" role="tab" data-toggle="tab">Baby Details</a>
                </li>
                <li role="presentation" class="{{ $active_tab == '#form' ? 'active' : '' }}">
                    <a href="#form" aria-controls="form" role="tab" data-toggle="tab">Form</a>
                </li>
            </ul>            
            <div class="tab-content tab-view-shadow">
                <div role="tabpanel" class="tab-pane {{ $active_tab == '#babyform' ? 'active' : '' }}" id="babyform">
                    @include('registration.feeding.baby_details')
                </div>
                <div role="tabpanel" class="tab-pane {{ $active_tab == '#form' ? 'active' : '' }}" id="form">
                    @include('registration.feeding.form')
                </div>
                <div class="col-md-12 col-sm-12 mt-15">
                    <input type="hidden" name="print_flag" value="0" id="print_flag" />
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <button type="button"  class="btn btn-block save-button-shadow btn-primary form-control feeding_update_btn" data-flag="2">
                            <i class="fa fa-floppy-o"></i> 
                            <span>{{ $active_tab == '#form' ? 'Finish' : 'Update & Next' }}</span>
                        </button>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <button type="button" class="btn btn-primary save-button-shadow btn-block form-control feeding_update_btn" data-flag="1">
                            <i class="fa fa-floppy-o"></i> 
                            <span>Update</span>
                        </button>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <button type="button" class="btn btn-block save-button-shadow btn-info form-control feeding_update_btn" data-flag="3">
                            <i class="fa fa-print"></i> 
                            <span>Print</span>
                        </button>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">                        
                        <a href="{{ action('Registration\FeedingController@index') }}" class="btn btn-block save-button-shadow btn-default form-control" onclick="$('form')[0].reset();">
                            <i class="fa fa-exclamation-circle"></i> 
                            <span>Cancel</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection