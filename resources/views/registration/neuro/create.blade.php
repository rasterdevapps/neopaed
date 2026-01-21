@extends('app')
@section('content')
@php
$site_url = url('/').'/public';
$write_permission = session('write_permission');
$read_permission = session('read_permission');
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
        <li><a href="{{ action('Registration\NeuroController@index') }}">Neuro Development</a></li>
        <li class="current"><a title="">Create @if(isset($baby_detail->BabyName)){{ $baby_detail->BabyName.' - '.$baby_detail->BMrNo }} @endif</a></li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing" id="create-neuro">

    @if (isset($baby_detail->BabyId))
    <a class="btn btn-primary pull-right mb-10 mlr-10 @if($current_age != null && $current_age >= 5) active-btn @else not-active-btn @endif" id="Greater-than-five-chart" href="{{ action('charts\WhoGrowthChartcontroller@greaterthanfive').'?baby_id='.SiteHelpers::encrypt_id($baby_detail->BabyId).'&closewinlink=neuro_create' }}">WHO Growth Chart (>= 5)</a>

    <a class="btn btn-primary pull-right mb-10 mlr-10 @if(isset($baby_detail->g_weeks) && ((empty($baby_detail->g_weeks) || (isset($baby_detail->g_weeks) && $baby_detail->g_weeks > 36)) || (isset($baby_detail->g_weeks) && $baby_detail->g_weeks <= 36 && $current_chart_age != null && $current_chart_age > 64)) && $current_age != null && $current_age < 5) active-btn @else not-active-btn @endif" id="zero-five-chart" href="{{ action('charts\WhoGrowthChartcontroller@index').'?baby_id='.SiteHelpers::encrypt_id($baby_detail->BabyId).'&closewinlink=neuro_create' }}"> WHO Growth Chart</a>

        <a class="btn btn-primary pull-right mb-10 mlr-10 @if(isset($baby_detail->g_weeks) && !empty($baby_detail->g_weeks) && $baby_detail->g_weeks < 37 && $current_chart_age != null && $current_chart_age <= 64 && $current_age != null && $current_age < 5) active-btn @else not-active-btn @endif" id="intergrowth-chart" href="{{ action('charts\InterGrowthChartController@index').'?baby_id='.SiteHelpers::encrypt_id($baby_detail->BabyId).'&closewinlink=neuro_create' }}">Intergrowth 21st Century Chart</a>
            @endif

            <div class="col-md-12">
                {!! Form::model($baby_detail,['url' => action('Registration\NeuroController@store'),'id'=>'neuro-form']) !!}
                {!! Form::hidden('baby_id', @$baby_detail->BabyId) !!}   
                {!! Form::hidden('BabyId',null) !!}
                {!! Form::hidden('MotherId',null) !!}   
                {!! Form::hidden('basic_permission',(in_array('NEURO_DEVELOPMENT_BASIC',$read_permission) ||  in_array('NEURO_DEVELOPMENT_BASIC',$write_permission)), ['id'=>'basic_permission']) !!}     
                <div role="tabpanel" class="tabbable tabbable-custom">
                    <ul class="nav nav-tabs" role="tablist">
                        @if(in_array('NEURO_DEVELOPMENT_BASIC',$read_permission) ||  in_array('NEURO_DEVELOPMENT_BASIC',$write_permission))
                        <li role="presentation" class="active">
                            <a href="#babyform" aria-controls="babyform" role="tab" data-toggle="tab">Baby Details</a>
                        </li>
                        <li role="presentation">
                            <a href="#eligibility" aria-controls="eligibility" role="tab" data-toggle="tab">Eligibility</a>
                        </li>
                        <li role="presentation">
                            <a href="#screening" aria-controls="screening" role="tab" data-toggle="tab">Screening</a>
                        </li>
                        @endif
                        @if(in_array('SCREENING_ASSESSMENT',$read_permission) || in_array('SCREENING_ASSESSMENT',$write_permission))
                        <li role="presentation">
                            <a href="#assessment" aria-controls="assessment" role="tab" data-toggle="tab">Screening / Assessment</a>
                        </li>
                        @endif
                    </ul>            
                    {!! Form::hidden('current_tab', null) !!}
                    <div class="tab-content tab-view-shadow">
                        @php
                        $activeTab = null;
                        @endphp
                        @if ((in_array('NEURO_DEVELOPMENT_BASIC', $read_permission) || in_array('NEURO_DEVELOPMENT_BASIC', $write_permission)) && (in_array('SCREENING_ASSESSMENT', $read_permission) || in_array('SCREENING_ASSESSMENT', $write_permission)))
                        @php
                        $activeTab = 'babyform';
                        @endphp
                        @elseif (in_array('NEURO_DEVELOPMENT_BASIC', $read_permission) || in_array('NEURO_DEVELOPMENT_BASIC', $write_permission))
                        @php
                        $activeTab = 'babyform'; 
                        @endphp
                        @elseif (in_array('SCREENING_ASSESSMENT', $read_permission) || in_array('SCREENING_ASSESSMENT', $write_permission))
                        @php
                        $activeTab = 'assessment';
                        @endphp
                        @endif
                        @if(in_array('NEURO_DEVELOPMENT_BASIC',$read_permission) ||  in_array('NEURO_DEVELOPMENT_BASIC',$write_permission))
                        <div role="tabpanel" class="tab-pane @if($activeTab == 'babyform') active @endif" id="babyform">
                            @include('registration.neuro.baby_details')
                        </div>
                        <div role="tabpanel" class="tab-pane" id="eligibility">
                            @include('registration.neuro.eligibility', (array)$baby_detail)
                        </div>
                        <div role="tabpanel" class="tab-pane" id="screening">
                            @include('registration.neuro.screening')
                            @include('registration.neuro.muscle_tone_norms')
                        </div>
                        @endif
                        @if(in_array('SCREENING_ASSESSMENT', $read_permission) || in_array('SCREENING_ASSESSMENT', $write_permission))
                        <div role="tabpanel" class="tab-pane  @if($activeTab == 'assessment') active @endif" id="assessment">
                            @include('registration.neuro.assessment')
                        </div>                    
                        @endif
                        @if(in_array('SCREENING_HNNE',$read_permission) || in_array('SCREENING_HNNE',$write_permission))
                        <div role="tabpanel" class="tab-pane" id="hnne_form">
                            @include('registration.neuro.hnne_report')
                        </div>
                        @endif
                        @if(in_array('SCREENING_HINE',$read_permission) || in_array('SCREENING_HINE',$write_permission))
                        <div role="tabpanel" class="tab-pane" id="hine_form">
                            @include('registration.neuro.hine_report')
                        </div>
                        @endif
                        @if(in_array('SCREENING_M_CHAT',$read_permission) || in_array('SCREENING_M_CHAT',$write_permission))
                        <div role="tabpanel" class="tab-pane" id="m-chat_form">
                            @include('registration.neuro.m_chat_report')
                        </div>
                        @endif
                        @if(in_array('SCREENING_DASII',$read_permission) || in_array('SCREENING_DASII',$write_permission))
                        <div role="tabpanel" class="tab-pane" id="dasii_form">
                            @include('registration.neuro.dasii_report')
                        </div>
                        @endif
                        @if(in_array('SCREENING_DDST',$read_permission) || in_array('SCREENING_DDST',$write_permission))
                        <div role="tabpanel" class="tab-pane" id="ddst_form">
                            {!! Form::hidden('age') !!}
                            @include('registration.neuro.ddst_chart')
                        </div>
                        @endif
                        @if(in_array('SCREENING_CBCL',$read_permission) || in_array('SCREENING_CBCL',$write_permission))
                        <div role="tabpanel" class="tab-pane" id="cbcl_form">
                            @include('registration.neuro.cbcl_report')
                        </div>
                        @endif
                        @if(in_array('SCREENING_BAYLEY',$read_permission) || in_array('SCREENING_BAYLEY',$write_permission))
                        <div role="tabpanel" class="tab-pane" id="bayley_form">
                            @include('registration.bayley.scale')
                        </div>
                        @endif
                        @if(in_array('SCREENING_ISSA',$read_permission) || in_array('SCREENING_ISSA',$write_permission))
                        <div role="tabpanel" class="tab-pane" id="issa_form">
                            @include('registration.neuro.issa')
                        </div>
                        @endif
                        @if(in_array('SCREENING_CARS',$read_permission) || in_array('SCREENING_CARS',$write_permission))
                        <div role="tabpanel" class="tab-pane" id="cars_form">
                            @include('registration.neuro.cars')
                        </div>
                        @endif
                        @if(in_array('SCREENING_INFANTS',$read_permission) || in_array('SCREENING_INFANTS',$write_permission))
                        <div role="tabpanel" class="tab-pane" id="infants_form">
                            @include('registration.neuro.infants_report')
                        </div>
                        @endif
                        @if(in_array('SCREENING_PRESCHOOLERS',$read_permission) || in_array('SCREENING_PRESCHOOLERS',$write_permission))
                        <div role="tabpanel" class="tab-pane" id="preschoolers_form">
                            @include('registration.neuro.preschoolers_report')
                        </div>
                        @endif
                        @if(in_array('SCREENING_PEP3',$read_permission) || in_array('SCREENING_PEP3',$write_permission))
                        <div role="tabpanel" class="tab-pane" id="pep3_form">
                            @include('registration.neuro.pep3')
                        </div>
                        @endif
                        <div class="col-md-12 col-sm-12 mt-15">
                            <input type="hidden" name="print_flag" value="0" id="print_flag" />
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <button type="button" class="btn btn-primary save-button-shadow btn-block form-control neuro_save_btn" data-flag="1">
                                    <i class="fa fa-floppy-o"></i> 
                                    <span>Save & Next</span>
                                </button>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <button type="button"  class="btn btn-block save-button-shadow btn-primary form-control neuro_save_btn" data-flag="2">
                                    <i class="fa fa-floppy-o"></i> 
                                    <span>Save & Close</span>
                                </button>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <a href="{{ action('Registration\NeuroController@index') }}" class="btn btn-block save-button-shadow btn-default form-control" onclick="$('form')[0].reset();">
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

