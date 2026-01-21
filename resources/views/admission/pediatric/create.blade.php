@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="fa fa-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li class=""><a title="" href="{{ action('Admission\PediatricController@index') }}">Pediatric Admission</a></li>
        <li class="current"><a title="">Create</a></li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing">
    <div class="col-md-12" id="create-pediatric">
        {!! Form::model($baby_detail,['url' => action('Admission\PediatricController@store'), 'id'=>'pediatric-form']) !!}
        @include('admission.pediatric.form')
        <div class="col-md-12 col-sm-12 col-xs-12 tab-view-shadow ptb-15 action-btn">
            <input type="hidden" name="print_flag" value="0" id="print_flag" />
            <div class="col-md-3 col-sm-6 col-xs-12">
                <button type="button" class="btn btn-primary btn-basic-shadow btn-block form-control pediatric-save">
                    <i class="fa fa-floppy-o"></i>
                    <span>Save & Close</span>
                </button>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <button type="button" class="btn btn-primary btn-basic-shadow btn-block form-control pediatric-save" data-flag="2">
                    <i class="fa fa-floppy-o"></i>
                    <span>Save</span>
                </button>
            </div>
           <!--  <div class="col-md-3 col-sm-6 col-xs-12">
                <button type="button" class="btn btn-block  btn-basic-shadow btn-info form-control pediatric-save" data-flag="3">
                    <i class="fa fa-print"></i>
                    <span>Print</span>
                </button>
            </div> -->
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
