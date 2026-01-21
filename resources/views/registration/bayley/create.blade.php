@extends('app')
@section('content')
@php
$site_url = url('/').'/public';
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
        <li><a href="{{ action('Registration\BayleyScaleController@index') }}">{{ Lang::get('menu.side_menu_bayley_scale') }}</a></li>
        <li class="current"><a title="">Create @if(isset($baby_detail->BabyName)){{ $baby_detail->BabyName.' - '.$baby_detail->BMrNo }} @endif</a></li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing" id="create-bayley">
    
    <div class="col-md-12">
        {!! Form::model($baby_detail,['url' => action('Registration\BayleyScaleController@store'),'id'=>'bayley-form']) !!}
            <div role="tabpanel" class="tabbable tabbable-custom">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#babyform" aria-controls="babyform" role="tab" data-toggle="tab">Baby Details</a>
                    </li>
                    <li role="presentation">
                        <a href="#scale" aria-controls="scale" role="tab" data-toggle="tab">Scale</a>
                    </li>
                </ul>            
                <div class="tab-content tab-view-shadow">
                    <div role="tabpanel" class="tab-pane active" id="babyform">
                        <input type="hidden" name="print_flag" value="0" id="print_flag" />
                        {!! Form::hidden('baby_id', @$baby_detail->BabyId) !!}   
                        {!! Form::hidden('bayley_current_tab', null) !!}
                        @include('registration.bayley.baby_details')
                    </div>
                    <div role="tabpanel" class="tab-pane" id="scale">
                        @include('registration.bayley.scale')
                    </div>
                    <div class="col-md-12 col-sm-12 mt-15">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <button type="button" class="btn btn-primary save-button-shadow btn-block form-control bayley_save_btn" data-flag="1">
                                <i class="fa fa-floppy-o"></i> 
                                <span>Save & Next</span>
                            </button>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <button type="button"  class="btn btn-block save-button-shadow btn-primary form-control bayley_save_btn" data-flag="2">
                                <i class="fa fa-floppy-o"></i> 
                                <span>Save & Close</span>
                            </button>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <a href="{{ action('Registration\BayleyScaleController@index') }}" class="btn btn-block save-button-shadow btn-default form-control" onclick="$('form')[0].reset();">
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
