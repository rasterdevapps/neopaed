@extends('app')
@section('content')
@php
$site_url = url('/').'/public';
@endphp
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="fa fa-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li><a href="{{ action('Registration\FeedingController@index') }}">Feeding</a></li>
        <li class="current"><a title="">Create @if(!$type) @if(isset($results->MotherName)) {{ $results->MotherName.' - '.$results->MMrNo }} @endif @else @if(isset($results->BabyName)) {{ $results->BabyName.' - '.$results->BMrNo }} @endif @endif</a></li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing" id="create-feeding">
    <div class="col-md-12">
        {!! Form::model($results,['url' => action('Registration\FeedingController@store'),'id'=>'feeding-form']) !!}
            {!! Form::hidden('mother_id', @$results->MotherId) !!}   
            {!! Form::hidden('baby_id', @$results->BabyId) !!}   
            {!! Form::hidden('type', @$type) !!}   
            <div role="tabpanel" class="tabbable tabbable-custom">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#babyform" aria-controls="babyform" role="tab" data-toggle="tab">Baby Details</a>
                    </li>
                    <li role="presentation">
                        <a href="#form" aria-controls="form" role="tab" data-toggle="tab">Form</a>
                    </li>
                </ul>            
                {!! Form::hidden('current_tab', null) !!}
                <div class="tab-content tab-view-shadow">
                    <div role="tabpanel" class="tab-pane active" id="babyform">
                        @include('registration.feeding.baby_details')
                    </div>
                    <div role="tabpanel" class="tab-pane" id="form">
                        @include('registration.feeding.form')
                    </div>
                    <div class="col-md-12 col-sm-12 mt-15">
                        <input type="hidden" name="print_flag" value="0" id="print_flag" />
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <button type="button" class="btn btn-primary save-button-shadow btn-block form-control feeding_save_btn" data-flag="1">
                                <i class="fa fa-floppy-o"></i> 
                                <span>Save & Next</span>
                            </button>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <button type="button"  class="btn btn-block save-button-shadow btn-primary form-control feeding_save_btn" data-flag="2">
                                <i class="fa fa-floppy-o"></i> 
                                <span>Save & Close</span>
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
