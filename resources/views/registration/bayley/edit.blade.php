@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="fa fa-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li><a href="{{ action('Registration\BayleyScaleController@index') }}">{{ Lang::get('menu.side_menu_bayley_scale') }}</a></li>
        <li class="current"><a title="">Edit @if(isset($results->BabyName)){{ $results->BabyName.' - '.$results->BMrNo }} @endif</a></li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing" id="edit-bayley">
    <div class="col-md-12">
        {!! Form::hidden('active_tab', @$active_tab) !!}
        {!! Form::model($results,['method'=> 'PATCH','url' => action('Registration\BayleyScaleController@update', $results->id),'id'=>'bayley-form']) !!}

        <div role="tabpanel" class="tabbable tabbable-custom">
            <ul class="nav nav-tabs" role="tablist" id="container-div">
                <li role="presentation" class="{{ $active_tab == '#babyform' ? 'active' : '' }}">
                    <a href="#babyform" aria-controls="babyform" role="tab" data-toggle="tab">Baby Details</a>
                </li>
                <li role="presentation" class="{{ $active_tab == '#scale' ? 'active' : '' }}">
                    <a href="#scale" aria-controls="scale" role="tab" data-toggle="tab">Scale</a>
                </li>
            </ul>            
            <div class="tab-content tab-view-shadow">
                <div role="tabpanel" class="tab-pane {{ $active_tab == '#babyform' ? 'active' : '' }}" id="babyform">
                    {!! Form::hidden('id', $results->id) !!}        
                    {!! Form::hidden('baby_id', $results->baby_id) !!}        
                    <input type="hidden" name="print_flag" value="0" id="print_flag" />
                    @include('registration.bayley.baby_details')
                </div>
                <div role="tabpanel" class="tab-pane {{ $active_tab == '#scale' ? 'active' : '' }}" id="scale">
                    @include('registration.bayley.scale')
                </div>
                <div class="col-md-12 col-sm-12 mt-15">
                    <input type="hidden" name="print_flag" value="0" id="print_flag" />
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <button type="button"  class="btn btn-block save-button-shadow btn-primary form-control bayley_update_btn" data-flag="2">
                            <i class="fa fa-floppy-o"></i> 
                            @if($active_tab == '#scale') <span>Finish & Close</span> @else <span>Update & Next</span> @endif
                        </button>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <button type="button" class="btn btn-primary save-button-shadow btn-block form-control bayley_update_btn" data-flag="1">
                            <i class="fa fa-floppy-o"></i> 
                            <span>Update</span>
                        </button>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <button type="button" class="btn btn-block save-button-shadow btn-info form-control bayley_update_btn" data-flag="3">
                            <i class="fa fa-print"></i> 
                            <span>Print</span>
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