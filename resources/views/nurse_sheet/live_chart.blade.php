@extends('app')
@section('content')
@php
$site_url = url('/').'/public';
@endphp
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li><a href="javascript:void(0);"></a></li>
        <li class="current"><a></a></li>
    </ul>
    <div class="pull-right">
        @php 
        $mrn = $baby_details->BMrNo; 
        echo \SiteHelpers::menuList($mrn, 'live_chart');
        @endphp
    </div>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12">
        <input type="hidden" name="baby_name" id ="baby_name" value="{{ $baby_details->BabyName }}">
        <input type="hidden" name="g_weeks" id ="g_weeks" value="{{ $baby_details->g_weeks }}">
        <input type="hidden" name="file_name" id ="file_name" value="{{ $baby_details->BabyName }}-{{ $baby_details->BMrNo }}">
        <input type="hidden" name="baby_details" id ="baby_details" value="{{ $baby_details->BMrNo }} - {{ @$baby_details->ip_number }}">
        <input type="hidden" name="mrn" id ="mrn" value="{{ $baby_details->BMrNo }}">
        <input type="hidden" name="patient_status" id="patient_status" value="{{$patient_status}}">
        <input type="hidden" name="all_parameter" id ="all_parameter" value="{{json_encode($param)}}">
        <input type="hidden" name="parameter" id ="parameter" value="">
        <input type="hidden" name="observation" id ="observation" value="">
        <input type="hidden" name="startfrom" id ="startfrom" value="{{$startfrom}}">
        <input type="hidden" name="endto" id ="endto" value="{{$endto}}">
        <input type="hidden" name="display_time" id="display_time" value="30">
        <input type="hidden" name="event_color" value="{{json_encode($event_color_list)}}">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div id="live-chart">
                <div class="display-flex display-none-must chartrange" style="flex-direction: column;">
                    <div class="display-flex">
                        <button class="mlr-5" id="fast-backward" title="First"><i class="fas fa-fast-backward"></i></button>
                        <button class="mlr-5" id="step-backward" title="Previous"><i class="fas fa-step-backward"></i></button>
                        <div class="range-wrap">
                            @if ($minutes == 1)
                            <input type="range" value="1" min="0" max="{{ $minutes }}" id="selected-range" class="range" style="margin-bottom: 0px;">
                            @else
                            <input type="range" value="0" min="1" max="{{ $minutes }}" id="selected-range" class="range" style="margin-bottom: 0px;">
                            @endif
                            <input type="hidden" name="old_range" id="old-range" value="{{ $minutes }}">
                            <output class="bubble" style="display: none;"></output>
                        </div>
                        <button class="mlr-5" id="step-forward" title="Next"><i class="fas fa-step-forward"></i></button>
                        <button class="mlr-5" id="fast-forward" title="Last"><i class="fas fa-fast-forward"></i></button>
                    </div>
                    <div class="col-xs-12 plr-0">
                        <b>{{ date('d-m-Y H:i:s', strtotime($startfrom)) }}</b>
                        <b class="pull-right" id="rangeend">{{ date('d-m-Y H:i:s', strtotime($endto)) }}</b>
                    </div>
                </div>
                <div id="event-name-list" class="col-xs-12 display-none hide-event-time">
                    <input type="hidden" name="event_name" value="{{json_encode($event_name_list)}}">
                    <input type="hidden" name="current_event_list">
                    <input type="hidden" name="current_event_name">
                    <ul>
                        @foreach($event_name_list as $key => $value)
                        @php 
                        $img_name = strtolower($key);
                        @endphp
                        <li>
                            <img src="{{$site_url}}/img/event_icons/icons/{{$img_name}}.svg" /> {{$value}}
                        </li>
                        @endforeach
                    </ul>
                    <button id="event-with-time" class="btn"><img src="data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>" /></button>
                </div>
                <div class="col-xs-12 control-container">
                    <div class="btn-container">
                        <button id="reset" class="btn pull-right display-none" title="Re-generate Chart"><i class="fas fa-angle-double-left"></i></button>
                        <select id="time-interval" name="time-interval" class="form-control input-width-small pull-right">
                            <option value="900">15 mins</option>
                            <option value="1800" selected="true">30 mins</option>
                            <option value="3600">1 hour</option>
                            <option value="7200">2 hours</option>
                        </select>
                        <button id="custom-date-time-filter" class="btn pull-right display-none" title="Filter"><i class="fa fa-calendar"></i></button>
                        <button id="range-filter" class="btn pull-right display-none" title="Normal Range Highlighter"><i class="fas fa-sliders"></i></button>
                        <button id="display-event" class="btn pull-right display-none active" title="Event"><i class="fa fa-clock"></i></button>
                        <button id="add-xlabel" class="btn pull-right display-none" title="X-axis Label"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div id="chartdiv"></div>
                <div id="chart-loader" class="chart-loading-center" style="background: url('{{ url('/') }}/public/img/chart-loader.gif') center no-repeat #000"></div>
            </div>
        </div>
        <!-- <div class="col-sm-12 col-md-6 col-lg-6">
            <div id="live-ecg-chart">
                <div id="ecg-chart-div"></div>            
            </div>
        </div> -->
        <!-- <div id="testdata"></div> -->
    </div>
</div>
<div class="modal fade live-param-modal-up" id="live-param-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body row m-20">
                <div class="col-xs-12 p-0" style="display: flex">
                    <div class="col-xs-2 pl-0">
                        <span class="patient_mrn">{{ $baby_details->BMrNo }}</span>
                    </div>
                    <div class="col-xs-8 text-center plr-0">
                        <span class="patient_name">{{ $baby_details->BabyName }}</span>
                    </div>
                    <div class="col-xs-2">
                        <button type="button" class="close btn" data-dismiss="modal" aria-label="close" data-reset="0"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <div class="col-xs-12 p-0 mt-15" style="border: 1px solid grey;">
                    <button class="btn btn-default pull-right btn-check active" id="all" title="Check All"><i class="fa fa-check"></i></button>
                    <div class="col-xs-12 p-0">
                        @php echo $parameter_content; @endphp
                    </div>
                </div>
                <div class="col-xs-12 p-0 text-center mt-15">
                    <button type="button" id="generate-btn" class="btn btn-default save-button-shadow" disabled="true">Generate</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade live-param-modal-up" id="filter-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close btn" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <h3 class="color-white">Custom Date & Time Filter</h3>
                </h5>
            </div>
            <div class="modal-body row m-20">
                @php $hours_list = SiteHelpers::prepare_time()['time']; @endphp
                @php $mins_list = SiteHelpers::prepare_time()['mins']; @endphp
                @php $session_list = SiteHelpers::prepare_time()['session']; @endphp
                <div class="col-md-12 display-flex">
                    {!! Form::label('from_date', 'From', ['class'=>'input-width-small display-table']) !!}
                    {!! Form::text('from_date',null,['class'=>'form-control input-width-small mr-10', 'id'=>'from-date', 'readonly']) !!}
                    {!! Form::select('from_hours',$hours_list,null,['class'=>'form-control input-width-mini']) !!}
                    {!! Form::select('from_mins',$mins_list,null,['class'=>'form-control input-width-mini']) !!}
                    {!! Form::select('from_secs',$mins_list,null,['class'=>'form-control input-width-mini']) !!}
                    {!! Form::select('from_session',$session_list,null,['class'=>'form-control input-width-mini']) !!}
                </div>
                <div class="col-md-12 display-flex mt-15">
                    {!! Form::label('to_date', 'To', ['class'=>'input-width-small display-table']) !!}
                    {!! Form::text('to_date',null,['class'=>'form-control input-width-small mr-10', 'id'=>'to-date', 'readonly']) !!}
                    {!! Form::select('to_hours',$hours_list,null,['class'=>'form-control input-width-mini']) !!}
                    {!! Form::select('to_mins',$mins_list,null,['class'=>'form-control input-width-mini']) !!}
                    {!! Form::select('to_secs',$mins_list,null,['class'=>'form-control input-width-mini']) !!}
                    {!! Form::select('to_session',$session_list,null,['class'=>'form-control input-width-mini']) !!}
                </div>
                <div class="col-xs-12 p-0 text-center mt-15">
                    <button type="button" id="apply-btn" class="btn btn-default save-button-shadow">Apply</button>
                </div>
            </div>
            <!--  <div class="modal-footer">
                <button type="button" id="generate-btn" class="btn btn-default btn-primary save-button-shadow" disabled="true">Generate</button>
                </div> -->
        </div>
    </div>
</div>
<!-- /Page Content -->     
@endsection
