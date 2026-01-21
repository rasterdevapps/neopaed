@extends('app')
@section('content')
<?php 
    $write_permission = session('write_permission');
?>
<!-- Breadcrumbs line -->
<style type="text/css">
    .master-icons{
        border: 1px solid;
        padding: 2px 8px;
        border-radius: 50%;
        box-shadow: 0px 17px 10px -10px rgba(0,0,0,0.4);
        background-color:#3968c6;
        color:white;
        cursor: pointer;
        font-size: 14px;
    }

    .report-left.half-width {
        width: 100%;
    }
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
}
.btn-info-must, .btn-info-must:hover, .btn-info-must:active {
    background-color: #2f96b4 !important;
    color: white !important;
}
</style>
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="fa fa-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li><a href="{{ action('Registration\OpController@index') }}">OP Registration</a></li>
        <li class="current text-captialize"><a title="Edit">Edit For {{ $results->BabyName.' - '.$results->BMrNo }} </a></li>
    </ul>
        <div class="pull-right">
            @if (!is_null($prev_id))
                @php
                    $prev_id = explode('||', $prev_id);
                    $previd = $prev_id[0];
                    $prev_day_name = $prev_id[1];
                @endphp
                <a href="{{ action('Registration\OpController@edit', \SiteHelpers::encrypt_id($previd)) }}" class="btn op-visit-nav" title="Visit {{$prev_day_name}}">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </a>
            @endif
            @if (!is_null($next_id))
                @php
                    $next_id = explode('||', $next_id);
                    $nextid = $next_id[0];
                    $next_day_name = $next_id[1];
                @endphp
                <a href="{{ action('Registration\OpController@edit', \SiteHelpers::encrypt_id($nextid)) }}" class="btn op-visit-nav" title="Visit {{$next_day_name}}">
                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                </a>
            @endif
      </div>
</div>
<!-- /Breadcrumbs line -->
<!-- <div class="row mt-10">

    <a class="btn btn-primary pull-right mb-10 mlr-10 @if($current_age >= 5) active-btn @else not-active-btn @endif" id="Greater-than-five-chart" href="{{ action('charts\WhoGrowthChartcontroller@greaterthanfive').'?baby_id='.SiteHelpers::encrypt_id($baby_detail->BabyId).'&closewinlink=neonatal_edit&id='.SiteHelpers::encrypt_id($results->OpId) }}">WHO Growth Chart (>= 5)</a>
    
    <a class="btn btn-primary pull-right mb-10 mlr-10 @if(((empty($results->g_weeks) || (isset($results->g_weeks) && $results->g_weeks > 36)) || (isset($results->g_weeks) && $results->g_weeks <= 36 && $current_chart_age > 64)) && $current_age < 5) active-btn @else not-active-btn @endif" id="zero-five-chart" href="{{ action('Growthchart\GrowthChartController@growthwhochartzerotofiveyears',SiteHelpers::encrypt_id($baby_detail->BabyId))  }}"> WHO Growth Chart</a>

    <a class="btn btn-primary pull-right mb-10 mlr-10 @if(isset($results->g_weeks) && !empty($results->g_weeks) && $results->g_weeks < 37 && $current_chart_age <= 64 && $current_age < 5) active-btn @else not-active-btn @endif" id="intergrowth-chart" href="{{ action('Growthchart\GrowthChartController@GenearateGrowthChart',SiteHelpers::encrypt_id($baby_detail->BabyId))  }}">Intergrowth 21st Century Chart</a>

    <span class="pull-right pt-5" style="font-size: 14px;"><b>Current Weight: {{(isset($results->CurrentWt) && $results->CurrentWt > 0) ? number_format($results->CurrentWt / 1000, 3) . ' KG' : 'null'}}</b></span>
</div> -->
<div class="row mt-10">

    <!-- <span style="display: inline-block; width: 198px; float: right; height: 10px;"></span> -->
    
    <a class="btn btn-primary pull-right mb-10 mlr-10 @if($current_age >= 5) active-btn @else not-active-btn @endif" href="{{ action('charts\WhoGrowthChartcontroller@greaterthanfive').'?baby_id='.SiteHelpers::encrypt_id($baby_detail->BabyId).'&closewinlink=neonatal_edit&id='.SiteHelpers::encrypt_id($results->OpId) }}">WHO Growth Chart (>= 5)</a>
    
    <a class="btn btn-primary pull-right mb-10 mlr-10 @if(isset($results->g_weeks) && ((empty($results->g_weeks) || (isset($results->g_weeks) && $results->g_weeks > 36)) || (isset($results->g_weeks) && $results->g_weeks <= 36 && $current_chart_age > 64)) && $current_age < 5) active-btn @else not-active-btn @endif" href="{{ action('charts\WhoGrowthChartcontroller@index').'?baby_id='.SiteHelpers::encrypt_id($baby_detail->BabyId).'&closewinlink=neonatal_edit&id='.SiteHelpers::encrypt_id($results->OpId) }}"> WHO Growth Chart</a>

    <a class="btn btn-primary pull-right mb-10 mlr-10 @if(isset($results->g_weeks) && !empty($results->g_weeks) && $results->g_weeks < 37 && $current_chart_age <= 64 && $current_age < 5) active-btn @else not-active-btn @endif" href="{{ action('charts\InterGrowthChartController@index').'?baby_id='.SiteHelpers::encrypt_id($baby_detail->BabyId).'&closewinlink=neonatal_edit&id='.SiteHelpers::encrypt_id($results->OpId) }}">Intergrowth 21st Century Chart</a>
    
    <span class="pull-right pt-5" style="font-size: 14px;"><b>Current Weight: {{(isset($results->CurrentWt) && $results->CurrentWt > 0) ? number_format($results->CurrentWt / 1000, 3) . ' KG' : 'null'}}</b></span>

</div>
    <div class="row op-head-main row-spacing">
        <div class="col-md-12">
            @include('errors.list')
            {!! Form::model($results,['method'=> 'PATCH','url' => action('Registration\OpController@update', $results->OpId),'id'=>'op-form']) !!}
            <!-- Nav tabs -->
            {!! Form::hidden('op_age_calculater',url('/age-calculate')) !!}
                {!! Form::hidden('visit_type', 'OP', ['id'=>'visit_type']) !!}
                {!! Form::hidden('visit_module_name', 'neonatal_op') !!}
                {!! Form::hidden('visit_number') !!}
                {!! Form::hidden('neuro_eligibility_id') !!}  
            <div role="tabpanel" class="tabbable tabbable-custom">
                <ul class="nav nav-tabs" role="tablist">
      <!--   <li role="presentation" @if(isset($_COOKIE['op-next']) && $_COOKIE['op-next'] == 'babyform') class="active" @endif @if(!isset($_COOKIE['op-next'])) class="active" @endif><a href="#babyform" aria-controls="babyform" role="tab" data-toggle="tab">Baby Details</a></li>
        <li role="presentation" @if(isset($_COOKIE['op-next']) && $_COOKIE['op-next'] == 'motherform') class="active" @endif><a href="#motherform" aria-controls="motherform" role="tab" data-toggle="tab">Parent Details</a></li>
        <li role="presentation" @if(isset($_COOKIE['op-next']) && $_COOKIE['op-next'] == 'opform') class="active" @endif><a href="#opform" aria-controls="opform" role="tab" data-toggle="tab">Medical Details</a></li> -->
        @if(in_array('NEONATAL_OP_BASIC', $write_permission))
        <li role="presentation" class="active"><a href="#babyform" aria-controls="babyform" role="tab" data-toggle="tab">Baby Details</a></li>
        <li role="presentation"><a href="#motherform" aria-controls="motherform" role="tab" data-toggle="tab">Parent Details</a></li> 
        @endif
        @if(in_array('OP_NEONATAL', $write_permission))
        @if (!empty($results->neuro_eligibility_id))
        <li role="presentation"><a href="#eligibility" aria-controls="eligibility" role="tab" data-toggle="tab">Eligibility</a></li>
        @endif
        <li role="presentation"><a href="#opform" aria-controls="opform" role="tab" data-toggle="tab">Medical Details</a></li>
        <li role="presentation"><a href="#vaccine_chart" aria-controls="#vaccine_chart" role="tab" data-toggle="tab">Vaccines</a></li>
        <li role="presentation"><a href="#media_tab" aria-controls="#media_tab" role="tab" data-toggle="tab">Attachments</a></li>
        @endif
        @if (isset($pediatric_today_visit->id))
        <span class="pull-right">
            <a class="btn btn-info-must ptb-5 ml-15" target="_blank" href="{{ action('Registration\PediatricOpController@OpsubList',SiteHelpers::encrypt_id($pediatric_today_visit->baby_id))  }}"> Pediatric OP</a>
        </span>
        @endif
        @if(in_array('LABREQUEST',$write_permission))   
            <a href="{{ action('Nurse\NurseSheetController@overallLabValuePrint', $results->BMrNo).'?visitid='.SiteHelpers::encrypt_id($results->OpId).'&closewinlink=neonatal-op-visit' }}" class="btn btn-primary pull-right ptb-5">
                <i class="fa fa-print"></i>
                <span>Lab Report</span>
            </a> 
        @endif  
        @php 
            $pacs_link = \SiteHelpers::pacsViewerLink();
            $pacs_link = str_replace('MRN', $results->BMrNo, $pacs_link);
        @endphp
        <a href="{{$pacs_link}}" target="_blank" class="btn btn-default pull-right btn-custom-pacs mtb-must-0 ptb-5">
        <i class="fas fa-x-ray"></i>
        <span>PACS</span>
        </a>  
    </ul>
    <!-- Tab panes -->
    <div class="tab-content tab-view-shadow">
        <!-- <div role="tabpanel" class="tab-pane @if(isset($_COOKIE['op-next']) && $_COOKIE['op-next'] == 'babyform') active @endif @if(!isset($_COOKIE['op-next'])) active @endif" id="babyform"> -->
            <div role="tabpanel" class="tab-pane active" id="babyform">
            <!-- <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('BMrNo','Baby\'s MRN.:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('BMrNo',@$bmrno,['class'=>'form-control']) !!}
                        <span id="mr_no_error" class="error-message display-none"></span>
                    </div>
                </div>
            </div> -->
            <div class="col-md-6 col-sm-6">
                <div class="mt-10 widget box">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> </h4>
                    </div>
                    <div class="widget-content">
                        {!! Form::hidden('MotherId') !!}
                        {!! Form::hidden('BabyId') !!}  
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('BMrNo','Baby\'s '.Lang::get('home.mrn').':') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('BMrNo',@$bmrno,['class'=>'form-control']) !!}
                                <span id="mr_no_error" class="error-message display-none"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('OpDate','OP Date:', ['class'=>'required-label']) !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('OpDate',null,['class'=>'form-control admission-date record-date','readonly'=>'true']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                {!! Form::label('OpTime','OP Time:') !!}
                            </div>
                            <div class="col-md-9 custom-input clear-xs">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <small>(Hour)</small>
                                    </div>
                                    <div class="col-xs-4">
                                        <small>(Minute)</small>
                                    </div>
                                    <div class="col-xs-4">
                                        <small>(Session)</small>
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::select('OpTime',$time['time'],null,['class'=>'form-control ']) !!}
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::select('OpTime_MINS',$time['mins'],null,['class'=>'form-control ']) !!}
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::select('OpTime_AM',$time['session'],null,['class'=>'form-control ']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('BabyName','Baby Name:', ['class'=>'required-label']) !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('BabyName',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('DOB','DOB:', ['class'=>'required-label']) !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('DOB',null,['class'=>'form-control datepicker birth-date', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                {!! Form::label('TOB','TOB:') !!}
                            </div>
                            <div class="col-md-9 custom-input clear-xs">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <small>(Hour)</small>
                                    </div>
                                    <div class="col-xs-4">
                                        <small>(Minute)</small>
                                    </div>
                                    <div class="col-xs-4">
                                        <small>(Session)</small>
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::select('TOB_TIME',$time['time'],null,['class'=>'form-control ']) !!}
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::select('TOB_MINS',$time['mins'],null,['class'=>'form-control ']) !!}
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::select('TOB_AM',$time['session'],null,['class'=>'form-control ']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('BirthStatus','Birth Status:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('BirthStatus',['Inborn'=>'Inborn','Outborn'=>'Outborn'], null, ['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                {!! Form::label('Gestation','Gestation:') !!}
                            </div>
                            <div class="col-md-9 custom-input clear-xs">
                                <div class="row col-md-12 display-flex">
                                    <div>
                                        <small>(Weeks)</small>
                                        {!! Form::text('g_weeks',null,['class'=>'form-control gestation-wks','max'=>'43','id'=>'g_weeks']) !!}
                                        <label class="error help-block" for="g_weeks" generated="true"></label> 
                                    </div>
                                    <div class="inbeween_two_fields">
                                        <span>+</span>
                                    </div>
                                    <div>
                                        <small>(Days)</small>
                                        {!! Form::text('g_days',null,['class'=>'form-control gestation-days','max'=>'6', 'id'=>'g_days']) !!}
                                        <label class="error help-block" for="g_days" generated="true"></label> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                {!! Form::label('Age','Chronological Age :') !!}
                            </div>
                            <div class="col-md-9 custom-input clear-xs">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <small>(Year)</small>
                                    </div>
                                    <div class="col-xs-4">
                                        <small>(Month)</small>
                                    </div>
                                    <div class="col-xs-4">
                                        <small>(Days)</small>
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::text('chronological_year',null,['class'=>'form-control ing-test']) !!}
                                        <label for="chronological_year" generated="true" class="error help-block"></label>
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::text('chronological_month',null,['class'=>'form-control ing-test']) !!}
                                        <label for="chronological_month" generated="true" class="error help-block"></label>
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::text('chronological_days',null,['class'=>'form-control ing-test']) !!}
                                        <label for="chronological_days" generated="true" class="error help-block"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                {!! Form::label('Age','Corrected Age:') !!}
                            </div>
                            <div class="col-md-9 custom-input clear-xs">
                                <div class="row corrected_age">
                                    <div class="col-xs-4">
                                        <small>(Year)</small>
                                    </div>
                                    <div class="col-xs-4">
                                        <small>(Month)</small>
                                    </div>
                                    <div class="col-xs-4">
                                        <small>(Days)</small>
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::text('corrected_year',null,['class'=>'form-control']) !!}
                                        <label for="corrected_year" generated="true" class="error help-block"></label>
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::text('corrected_month',null,['class'=>'form-control']) !!}
                                        <label for="corrected_month" generated="true" class="error help-block"></label>
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::text('corrected_days',null,['class'=>'form-control']) !!}
                                        <label for="corrected_days" generated="true" class="error help-block"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                {!! Form::label('Chronological Age','Chronological Age:') !!}
                            </div>
                            <div class="col-md-9 custom-input clear-xs">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <small>(Weeks)</small>
                                    </div>
                                    <div class="col-xs-6">
                                        <small>(Days)</small>
                                    </div>
                                    <div class="col-xs-6">
                                        {!! Form::text('total_chronological_weeks',null,['class'=>'form-control']) !!}
                                        <label for="total_chronological_weeks" generated="true" class="error help-block"></label>
                                    </div>
                                    <div class="col-xs-6">
                                        {!! Form::text('total_chronological_days',null,['class'=>'form-control ']) !!}
                                        <label for="total_chronological_days" generated="true" class="error help-block"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control" style="margin-top: 25px">
                                {!! Form::label('Age In','Corrected Age:') !!}
                            </div>
                            <div class="col-md-9 custom-input clear-xs">
                                <div class="row corrected_age">
                                    <div class="col-xs-6">
                                        <small>(Weeks)</small>
                                    </div>
                                    <div class="col-xs-6">
                                        <small>(Days)</small>
                                    </div>
                                    <div class="col-xs-6">
                                        {!! Form::text('total_corrected_weeks',null,['class'=>'form-control corrected-gestation-wks']) !!}
                                        <label for="total_corrected_weeks" generated="true" class="error help-block"></label>
                                    </div>
                                    <div class="col-xs-6">
                                        {!! Form::text('total_corrected_days',null,['class'=>'form-control corrected-gestation-days']) !!}
                                        <label for="total_corrected_days" generated="true" class="error help-block"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="mt-10 widget box">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> </h4>
                    </div>
                    <div class="widget-content">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('BabyBloodGroup','Baby\'s Blood Group:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('BabyBloodGroup',ValuelistHelpers::Blood_groups(),null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('mother_blood_group','Mother Blood Group:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('mother_blood_group',ValuelistHelpers::Blood_groups(),null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('BirthOrder','Birth Order:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('BirthOrder',[''=>'Select','Singleton'=>'Singleton','Twin 1'=>'Twin 1','Twin 2'=>'Twin 2','Triplet 1'=>'Triplet 1','Triplet 2'=>'Triplet 2','Triplet 3'=>'Triplet 3'],null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('Sex','Sex:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('Sex',[''=>'Select','Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                {!! Form::label('BirthWeight','Birth Weight:') !!}
                            </div>
                            <div class="col-md-9 custom-input clear-xs">
                                @php $weight = (!empty($baby_detail->BirthWeight))? $baby_detail->BirthWeight/1000 : 0 ; @endphp
                                <div class="row">
                                    <div class="col-xs-6">
                                        <small>(In Grams)</small>
                                    </div>
                                    <div class="col-xs-6">
                                        <small>(In Kilograms)</small>
                                    </div>
                                    <div class="col-xs-6">
                                        {!! Form::input('text','BirthWeight',null,['class'=>'form-control mobile-','maxlength'=>'4']) !!}
                                        <label for="BirthWeight" generated="true" class="error help-block"></label>
                                    </div>
                                    <div class="col-xs-6">
                                        {!! Form::input('text','birth_weight',$weight,['class'=>'form-control ','readonly'=>'true']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('HeadCircumference','Birth Head Circumference (cm):') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('HeadCircumference',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                {!! Form::label('CurrentWt','Current Weight:') !!}
                            </div>
                            <div class="col-md-9 custom-input clear-xs">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <small>(In Grams)</small>
                                    </div>
                                    <div class="col-xs-6">
                                        <small>(In Kilograms)</small>
                                    </div>
                                    <div class="col-xs-6">
                                        {!! Form::input('text','CurrentWt',null,['class'=>'form-control mobile-']) !!}
                                    </div>
                                    <div class="col-xs-6">
                                        {!! Form::input('text','Current_Wt',$results->CurrentWt/1000,['class'=>'form-control ','readonly'=>'true','id'=>'CurrentWtInKilo']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('CurrentOFC','Current OFC (Head Circumference in cm):') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('CurrentOFC',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('CurrentLength','Current Length / Height (cm) :') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('CurrentLength',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('hospital_name','Hospital Name', ['class'=>'required-label']) !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('hospital_name',ValuelistHelpers::getHospitals(),null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div role="tabpanel" class="tab-pane row mlr-0 @if(isset($_COOKIE['op-next']) && $_COOKIE['op-next'] == 'motherform') active @endif" id="motherform"> -->
            <div role="tabpanel" class="tab-pane row mlr-0" id="motherform">
                <div class="form-group mlr-15">
                    <div class="row">
                        <div class="col-md-12 label-control">
                            {!! Form::label('MMrNo','Mother\'s '. Lang::get('home.mrn').'.:') !!}
                        </div>
                        <div class="col-md-12 custom-input">
                            {!! Form::text('MMrNo',@$mmrno,['class'=>'form-control']) !!}
                            <span id="mr_no_error" class="error-message display-none"></span>
                        </div>
                    </div>
                </div>
            <!-- <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('MMrNo','Mother\'s MRN.:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('MMrNo',@$mmrno,['class'=>'form-control']) !!}
                        <span id="mr_no_error" class="error-message display-none"></span>
                    </div>
                </div>
            </div> -->
            <div class="col-md-6 col-sm-6">
                <div class="widget box">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> Mother Details</h4>
                    </div>
                    <div class="widget-content">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('MotherTitle','Title:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('MotherTitle',[''=>'Select','Ms.'=>'Ms.','Mrs.'=>'Mrs.','Miss.'=>'Miss.'],null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('MotherInitial','Initial:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('MotherInitial',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('MotherName','First Name:', ['class'=>'required-label']) !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('MotherName',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('MotherLastName','Last Name:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('MotherLastName',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('MotherDOB','DOB:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('MotherDOB',null,['class'=>'form-control datepicker']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('MothercYear','Completed Years:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('MothercYear',null,['class'=>'form-control','readonly']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('education_status','Mother\'s Education Level:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('education_status',ValuelistHelpers::getEducationstatus(),null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('Occupation','Occupation Type:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('Occupation',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('occupation_status','Current Occupation Status:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('occupation_status',ValuelistHelpers::getOccupationstatus(),null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('Mobile','Contact No 1:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('Mobile',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('LandLine','Contact No 2:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('LandLine',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('MotherEmail','Email :') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('MotherEmail',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('MotherSpokenLanguages','Mother Spoken Languages:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('MotherSpokenLanguages',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <p class="divider">&nbsp;</p>
                        </div>
                    </div>
                </div>
                <div class="widget box">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> Current Address</h4>
                    </div>
                    <div class="widget-content">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('Address1','Address Line 1 (Door/Flat No./Home Name) :') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('Address1',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('Address2','Address Line 2 (Street Name/Building Name):') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('Address2',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('Address3','Address Line 3 (City):') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('Address3',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('Address4','Address Line 4 (Pin code/Zip code):') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('Address4',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('Address5','Address Line 5 (Country):') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('Address5',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <p class="divider">&nbsp;</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" col-md-6 col-sm-6">
                <div class="widget box">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> Father Details</h4>
                    </div>
                    <div class="widget-content">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('PartnerTitle','Title:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('PartnerTitle',[''=>'Select','Mr.'=>'Mr.','Dr.'=>'Dr.'],null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('PartnerInitial','Initial:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('PartnerInitial',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('PartnerName','First Name:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('PartnerName',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('PartnerLastName','Last Name:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('PartnerLastName',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('PartnerDOB','DOB:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('PartnerDOB',null,['class'=>'form-control datepicker']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('PartnercYear','Completed Years:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('PartnercYear',null,['class'=>'form-control','readonly']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('partner_education_status','Father\'s Education Level:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('partner_education_status',ValuelistHelpers::getEducationstatus(),null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('PartnerOccupation','Occupation Type:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('PartnerOccupation',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('partner_occupation_status','Current Occupation Status:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('partner_occupation_status',ValuelistHelpers::getOccupationstatus(),null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('PartnerContact','Contact No 1:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('PartnerContact',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('PartnerMobile','Contact No 2 :') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('PartnerMobile',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('Email','Email:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('Email',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('FatherSpokenLanguages','Father Spoken Languages:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('FatherSpokenLanguages',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::checkbox('samecontacts', 1, null, ['class' => 'field samecontacts']) !!}
                            {!! Form::label('samecontacts','Same as mother\'s contact details including languages') !!}
                        </div>
                    </div>
                </div>
                <div class="widget box">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> Mailing Address</h4>
                    </div>
                    <div class="widget-content">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('FatherAddress1','Address Line 1 (Door/Flat No./Home Name):') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('FatherAddress1',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('FatherAddress2','Address Line 2 (Street Name/Building Name):') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('FatherAddress2',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('City','Address Line 3 (City):') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('City',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('Postcode','Address Line 4 (Pin code/Zip code):') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('Postcode',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('Country','Address Line 5 (Country):') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('Country',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::checkbox('sameasmailaddress', 1, null, ['class' => 'field sameasmailaddress']) !!}
                            {!! Form::label('sameasmailaddress','Same as Current Address') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

                <div role="tabpanel" class="tab-pane mb-15" id="eligibility">
                    @include('registration.neuro.eligibility', (array)$results)
                </div>
        <!-- <div role="tabpanel" class="tab-pane @if(isset($_COOKIE['op-next']) && $_COOKIE['op-next'] == 'opform') active @endif" id="opform"> -->
            <div role="tabpanel" class="tab-pane" id="opform">
                <div class=" col-md-6 col-sm-6">
                    <div class="mt-10 widget box">
                        <div class="widget-header">
                            <h4><i class="fa fa-reorder"></i> </h4>
                        </div>
                        <div class="widget-content">
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('baby_background','Background Details:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::textarea('baby_background',null,['class'=>'form-control editer-required']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('ConfidentialBackgroundDetails','Confidential Background Details:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::textarea('ConfidentialBackgroundDetails',null,['class'=>'form-control','rows'=>5]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('Complaints','Current Status:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::textarea('Complaints',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('HPI','HPI:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::textarea('HPI',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('AllergyHistory','Allergy History:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text('AllergyHistory',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('FamilyHistory','Family History:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text('FamilyHistory',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    {!! Form::label('TreatmentHistory','Treatment History:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text('TreatmentHistory',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="mt-10 widget box">
                        <div class="widget-header">
                            <h4><i class="fa fa-reorder"></i> </h4>
                        </div>
                        <div class="widget-content">
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('Development','Development:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::textarea('Development',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('Examination','Examination:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::textarea('Examination',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('neurosonogram','Neurosonogram:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    <input id="neurosonogram" name="neurosonogram" data-on="performed" data-off="Not performed"  data-toggle="toggle" data-width="200" data-size="small" class="form-control" type="checkbox">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('neurosonogram_report','Neurosonogram Report:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::textarea('neurosonogram_report',null,['class'=>'form-control','rows'=>'5']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('echocardiogram','Echocardiogram:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    <input id="echocardiogram" name="echocardiogram" data-on="performed" data-off="Not performed"  data-toggle="toggle" data-width="200" data-size="small" class="form-control" type="checkbox">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('echocardiogram_report','Echocardiogram Report:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::textarea('echocardiogram_report',null,['class'=>'form-control','rows'=>'5']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('Diagnosis','Impression:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::textarea('Diagnosis',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('Advice','Advice:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::textarea('Advice',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('Investigations','Investigations:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::textarea('investigations',null,['class'=>'form-control','rows'=>'4']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    {!! Form::label('AppointmentType','Current Appointment Type:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::select('AppointmentType',[''=>'N/A']+ValuelistHelpers::appointmentType(),null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                    {!! Form::label('Review','Review:') !!}
                                </div>
                                <div class="col-md-9 custom-input clear-xs">
                                    <div class="row">
                                        <div class="col-xs-3 pr-0">
                                            <small>(Date)</small>
                                        </div>
                                        <div class="col-xs-3">
                                            <small>(Days)</small>
                                        </div>
                                        <div class="col-xs-6 plr-0">
                                            <small>(Time)</small>
                                        </div>
                                        <div class="col-xs-3 pr-0">
                                            {!! Form::text('Review',null,['class'=>'form-control datepicker', 'readonly']) !!}
                                        </div>
                                        <div class="col-xs-3">
                                            {!! Form::text('review_days',null,['class'=>'form-control']) !!}
                                        </div>
                                        <div class="col-xs-6 plr-0">
                                            <div class="col-xs-4 plr-0">{!! Form::select('review_time',$time['time'],null,['class'=>'form-control']) !!}</div>
                                            <div class="col-xs-4 pl-5 pr-0">{!! Form::select('review_min',$time['mins'],null,['class'=>'form-control']) !!}</div>
                                            <div class="col-xs-4 pl-5 pr-0">{!! Form::select('review_session',$time['session'],null,['class'=>'form-control']) !!}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('nextreviewindication','Next Review Indication:') !!}
                                </div>
                                <div class="col-md-9 custom-input"> 
                                    {!! Form::textarea('nextreviewindication',null,['class'=>'form-control','rows'=>'5','columns'=>'5']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('need_neuro','Do you need Neuro Development on same date?') !!}
                                </div>
                                <div class="col-md-9 custom-input"> 
                                    <input id="need_neuro" name="need_neuro" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('Outcome','Outcome:') !!}
                                </div>
                                <div class="col-md-9 custom-input"> 
                                    {!! Form::select('Outcome',[''=>'N/A']+ValuelistHelpers::outcome(),null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('SeenBy','Seen By:', ['class'=> 'required-label']) !!}
                                </div>
                                <div class="col-md-9 custom-input"> 
                                    {!! Form::select('SeenBy',[''=>'N/A']+ValuelistHelpers::mas_doctors_list(),null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('fee_status','Fee charges:') !!}
                                </div>
                                <div class="col-md-9 custom-input"> 
                                    <input id="fee_status" name="fee_status" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('fee_amount','Fee Amount: (&#8377;)') !!}
                                </div>
                                <div class="col-md-9 custom-input"> 
                                    {!! Form::text('fee_amount',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('fee_reason','Reason:') !!}
                                </div>
                                <div class="col-md-9 custom-input"> 
                                    {!! Form::text('fee_reason',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 overflow-auto">
                    <div class="form-group row">
                        <div class="col-md-12 custom-input">
                            <h3>Medications 
                                <a href="javascript:void(0)" class="add_master_data" data-modal_header="Drugs & Iv Fluids" data-destination_elements="temp_drugs,M_Drugs[]" data-option_value="id" data-option_text="brand_name" data-mas_table="mas_drugivfluid" data-drug_type="oral">
                                    <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Drugs & Iv Fluids"></i>
                                </a>
                            </h3>
                            <table class="drugs table table-add-more full-width-fix">
                                <thead>
                                    <tr class="master-add-header">
                                        <th>Drug</th>
                                        <th>Generic Name</th>
                                        <th>Formulation/Strength</th>
                                        <th>Route</th>
                                        <th>
                                            Dose
                                            <a href="javascript:void(0)" class="add_master_data" data-modal_header="Dose" data-destination_elements="temp_does,M_Dose[]" data-option_value="volume" data-option_text="volume" data-mas_table="mas_dose">
                                                <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Dose"></i>
                                            </a>
                                        </th>
                                        <th>
                                            Frequency
                                            <a href="javascript:void(0)" class="add_master_data" data-modal_header="Frequency" data-destination_elements="temp_frequency,M_Frequency[]" data-option_value="value" data-option_text="name" data-mas_table="mas_frequency">
                                                <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Frequency"></i>
                                            </a>
                                        </th>
                                        <th>Duration</th>
                                        <th>
                                            <span>
                                                <a class="btn btn-success btn-view op_drugs_add btn_add" href="javascript:void(0);">
                                                    <b>Add Drugs</b> <i class="fa fa-plus"></i>
                                                </a>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $mas_frequency_list = ValuelistHelpers::drugFrequencyList(); @endphp
                                    <div class="hidden">
                                        {!! Form::select('temp_drugs',$drug_data,'') !!}
                                        {!! Form::select('temp_frequency',$mas_frequency_list,'') !!}
                                        {!! Form::select('temp_route',ValuelistHelpers::route(),'') !!}
                                        {!! Form::select('temp_does',[''=>'N/A']+ValuelistHelpers::dose(),'') !!}
                                        {!! Form::select('temp_duration',[''=>'N/A']+ValuelistHelpers::medicationDuration(),'') !!}                 
                                    </div>
                                    @if (isset($medications) && (count($medications) > 0))
                                    @php 
                                    $l = 0; 
                                    $medications = collect($medications)->groupBy('Medication');
                                    @endphp
                                    @foreach ($medications as $temp_key => $temp_medi_data)
                                    @php $standard_medication_id = $l; @endphp
                                    @foreach ($temp_medi_data as $key => $medi_data)
                                    @php $temp_l = $medi_data['Id']; @endphp
                                    <tr data-len="{{$l}}" class="standard_medication_{{$standard_medication_id}}" data-id="{{$temp_l}}">
                                        <td>
                                            <div class="@if($key > 0) hidden @endif">
                                                {!! Form::hidden('standard_dose['.$temp_l.']', @$medi_data['standard_dose']) !!}
                                                {!! Form::select('M_Drugs['.$temp_l.']',$drug_data,$medi_data['Medication'],['class'=>'drugs-changes1 drug-list-name'.$l,'data-id'=>$l, 'style'=>'min-width:300px;']) !!}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="@if($key > 0) hidden @endif">{!! Form::text('m_generic_name['.$temp_l.']',$medi_data['genericname'],['class'=>'form-control generic_name'.$l]) !!}</div>
                                        </td>
                                        <td>
                                            <div class="@if($key > 0) hidden @endif">{!! Form::select('formulation['.$temp_l.']',ValuelistHelpers::formulationStrength($medi_data['formulation']),$medi_data['formulation'],['class'=>'form-control formulation'.$l]) !!}</div>
                                        </td>
                                        <td class="input-width-medium">
                                            <div class="@if($key > 0) hidden @endif">
                                                {!! Form::select('M_Route['.$temp_l.']',ValuelistHelpers::route(),@$medi_data['route'],['class'=>'form-control']) !!}
                                            </div>
                                        </td>
                                        <td class="input-width-medium">{!! Form::select('M_Dose['.$temp_l.']',[''=>'N/A']+ValuelistHelpers::dose(),$medi_data['Dose'],['class'=>'form-control']) !!}</td>
                                        <td class="input-width-medium">{!! Form::select('M_Frequency['.$temp_l.']',$mas_frequency_list,$medi_data['Frequency'],['class'=>'form-control']) !!}</td>
                                        <td class="input-width-medium">{!! Form::select('M_Duration['.$temp_l.']',ValuelistHelpers::medicationDuration(),$medi_data['Duration'],['class'=>'form-control']) !!}</td>
                                        <td>
                                            @if($key == 0)
                                            <a class="btn btn-success standard_dose btn-view btn_add" href="javascript:void(0);" data-addid="{{$standard_medication_id}}">
                                                <!-- <i class="fa fa-plus"></i> -->
                                                <b>Continue</b>
                                            </a>
                                            <span class="fa fa-trash btn btn-danger btn-view standard_dose_remove"></span>
                                            @else
                                            <span class="fa fa-trash btn btn-danger btn-view medication_remove"></span>
                                            @endif
                                        </td>
                                    </tr>
                                    @php $l++; @endphp
                                    @endforeach  
                                    @endforeach  
                                    @else
                                    <tr data-len="0" class="standard_medication_0">
                                        <td>{!! Form::hidden('standard_dose[]', 0) !!}{!! Form::select('M_Drugs[]',$drug_data,null,['class'=>'drugs-changes drug-list-name0','data-id'=>'0', 'style'=>'min-width:300px;']) !!}</td>
                                        <td>{!! Form::text('m_generic_name[]',null,['class'=>'form-control generic_name0']) !!}</td>
                                        <td>{!! Form::select('formulation[]',[''=>'N/A'],null,['class'=>'form-control formulation0']) !!}</td>
                                        <td class="input-width-medium">{!! Form::select('M_Route[]',ValuelistHelpers::route(),null,['class'=>'form-control']) !!}</td>
                                        <td class="input-width-medium">{!! Form::select('M_Dose[]',[''=>'N/A']+ValuelistHelpers::dose(),null,['class'=>'form-control']) !!}</td>
                                        <td class="input-width-medium">{!! Form::select('M_Frequency[]',$mas_frequency_list,null,['class'=>'form-control']) !!}</td>
                                        <td class="input-width-medium">{!! Form::select('M_Duration[]',ValuelistHelpers::medicationDuration(),null,['class'=>'form-control']) !!}</td>
                                        <td>
                                            <a class="btn btn-success standard_dose btn-view btn_add" href="javascript:void(0);" disabled="true" data-addid="0">
                                                <!-- <i class="fa fa-plus"></i> -->
                                                <b>Continue</b>
                                            </a>
                                            <span class="fa fa-trash btn btn-danger btn-view standard_dose_remove"></span>
                                        </td>
                                    </tr>
                                    @endif  
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 plr-0">
                        <div class="col-md-5">
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('Immunization','Immunization:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::select('Immunization',[''=>'N/A','Due'=>'Due','Given'=>'Given','Complete'=>'Complete'],null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('Schedule','Schedule:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::select('Schedule',[''=>'N/A','At birth'=>'At birth','6 wks'=>'6 wks','10 wks'=>'10 wks','14 wks'=>'14 wks','6 mths'=>'6 mths','9 mths'=>'9 mths','1 year'=>'1 year','15 mths'=>'15 mths','16-18 mths'=>'16-18 mths','18 mths'=>'18 mths','2 years'=>'2 years','5 years'=>'5 years','10 years'=>'10 years','Optional'=>'Optional','Catch Up'=>'Catch Up'],null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="hidden">
                            {!! Form::select('temp_vaccines',$vaccine,null,['class'=>'form-control']) !!}
                        </div>
                        <div class="col-md-5">
                            <div class="form-group row">
                                <div class="col-md-12 custom-input">
                                    <table class="op_vaccine table table-add-more full-width-fix">
                                        <thead>
                                            <tr class="master-add-header">
                                                <th>
                                                    {!! Form::label('Vaccine','Vaccine:') !!}
                                                    <a href="javascript:void(0)" class="add_master_data" data-modal_header="Vaccine" data-destination_elements="temp_vaccines,Vaccine[]" data-option_value="Id" data-option_text="Name" data-mas_table="mas_vaccine">
                                                        <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Vaccine"></i>
                                                    </a>
                                                </th>
                                                <th>
                                                    <span>
                                                        <a class="btn btn-success btn-view op_vaccine_add btn_add" href="javascript:void(0);">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                    </span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(is_array($results->Vaccine) && count($results->Vaccine) > 0)
                                            @foreach($results->Vaccine as $vaccine_code) 
                                            <tr>
                                                <td class="full-width">
                                                    {!! Form::select('Vaccine[]',$vaccine,$vaccine_code,['class'=>'form-control']) !!}
                                                </td>
                                                <td>
                                                    <span class="fa fa-trash btn btn-danger btn-view remove"></span>
                                                </td>
                                            </tr>
                                            @endforeach   
                                            @else    
                                            <tr>
                                                <td class="full-width">
                                                    {!! Form::select('Vaccine[]',$vaccine,null,['class'=>'form-control']) !!}
                                                </td>
                                                <td>
                                                    <span class="fa fa-trash btn btn-danger btn-view remove"></span>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="vaccine_chart">
                @include('registration.vaccine_chart')
            </div>
        <div role="tabpanel" class="tab-pane" id="media_tab">
            <input type="hidden" name="module_name" value="1">
            @include('registration.media')
        </div>
            <div class="col-md-12 col-sm-12">
                <input type="hidden" name="print_flag" value="0" id="print_flag" />
                @if(!Session::has('registration_start'))
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <button type="button" class="btn btn-primary save-button-shadow btn-block form-control op_save_btn" data-flag="1">
                        <i class="fa fa-floppy-o"></i> 
                        <span>Update & Next</span>
                    </button>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <button type="button"  class="btn btn-block save-button-shadow btn-primary form-control op_save_btn" data-flag="2">
                        <i class="fa fa-floppy-o"></i> 
                        <span>{!! $SavedhereText !!}</span>
                    </button>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <button type="button" class="btn btn-block save-button-shadow btn-info form-control op_save_btn" data-flag="3">
                        <i class="fa fa-print"></i> 
                        <span>Print</span>
                    </button>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="{{ action('Registration\OpController@index') }}" class="btn btn-block save-button-shadow btn-default form-control" onclick="$('form')[0].reset();">
                        <i class="fa fa-exclamation-circle"></i> 
                        <span>Cancel</span>
                    </a>
                </div>
                @else   
                <div class="col-md-3 col-sm-6 col-xs-12 opbtnaction">
                    <button type="submit" class="btn btn-block save-button-shadow next save-next btn-info form-control" data-flag="2">
                        <i class="fa fa-floppy-o"></i> 
                        <span>{!! (isset($_COOKIE['op-next']) && $_COOKIE['op-next'] == 'opform') ? 'Finish & Close' : 'Next'; !!}</span>
                    </button>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 opbtnaction">
                    <button type="button" class="btn btn-block save-button-shadow  save-only btn-info form-control">
                        <i class="fa fa-floppy-o"></i> 
                        <span>Update</span>
                    </button>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 hide normal-print opbtnaction">
                    <button type="button" class="btn btn-block save-button-shadow btn-info form-control" onclick="$('#print_flag').val('3'); $(form).submit();">
                        <i class="fa fa-print"></i> 
                        <span>Print</span>
                    </button>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 opbtnaction">
                    <a href="{{ action('Registration\OpController@index') }}" class="btn btn-block save-button-shadow btn-default form-control" onclick="$('form')[0].reset();">
                        <i class="fa fa-exclamation-circle"></i> 
                        <span>Cancel</span>
                    </a>
                </div>
                @endif   
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    @include('prescription.prescription_master') 
    @endsection
    @section('scripts')
    <script type = "text/javascript">
        function upload(blob) {
            var formData = new FormData();
            formData.append('file', blob);
            var babyId = $('input[name="BabyId"]').val();
            var moduleId = null;
            var admissionId = null;
            var fieldId = $('.recordEnable').attr('id');
            var moduleSlug = 'OP_MODULE';
            var baseurl = "{{ url('audio-file-recording') }}";
            var audioUrl = baseurl + '/' + babyId + '/' + moduleId + '/' + admissionId + '/' + fieldId + '/' + moduleSlug;
            $('#' + fieldId).removeClass('recordEnable');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: audioUrl,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (responseText) {
                    var previewsText = $('#' + fieldId).val() + ' ' + responseText.message;
                    $('#' + fieldId).val(previewsText);
                },
                error: function (response) {
                    resposneText = JSON.parse(response.responseText);
                    Showalert('error', resposneText.message);
                }
            });
        }
        $(document).ready(function () {
            var list = ['baby_background', 'ConfidentialBackgroundDetails', 'Complaints', 'HPI', 'Development', 'Examination', 'Diagnosis', 'Advice', 'Investigations'];
    // $.each(list, function(index, value) {
    //     setSpeechcontrol(value);
    // })
});
        $(document).ready(function () {
            $('.nav-tabs li a').click(function () {
                if ($("#op-form").valid() === false) {
                    $("#op-form").valid();
                    return false;
                }
                submitForm();
                var opMenu = $(this).attr('aria-controls');
                flowComplete(opMenu);
        // $.cookie('op-next', opMenu.replace('#', ''), {
        //     path: '/'
        // })

        $.cookie('op-next', opMenu.replace('#', ''), {
            path: '/'
        });
    });
    // var setMenu = $.cookie('op-next');
    // $('a[href=#' + setMenu + ']').click()
    var currentMenu = $('#op-form li[class="active"]').children('a').attr('aria-controls');
    flowComplete(currentMenu);
    $('.op_vaccine_add').click(function () {
        var list = $('select[name="temp_vaccines"]').html();
        var option = '<tr>';
        option += '<td class="full-width"><select name="Vaccine[]" class="form-control">' + list + '</select></td>';
        option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
        option += '</tr>';
        $('.op_vaccine tbody').append(option);
    });
    jQuery('#BirthWeight').keyup(function () {
        this.value = this.value.replace(/[^0-9]/g, '');
        $("#birth_weight").empty();
        var birth_weight = $('#BirthWeight').val() / 1000;
        $('#birth_weight').val(birth_weight);
    });
    jQuery('#CurrentWt').keyup(function () {
        this.value = this.value.replace(/[^0-9]/g, '');
        $("#Current_Wt").empty();
        var Current_Wt = $('#CurrentWt').val() / 1000;
        $('#CurrentWtInKilo').val(Current_Wt);
    });
    $('.sameasmailaddress').click(function () {
        if ($('.sameasmailaddress').is(':checked')) {
            $('#FatherAddress1').val($('#Address1').val());
            $('#FatherAddress2').val($('#Address2').val());
            $('#City').val($('#Address3').val());
            $('#Postcode').val($('#Address4').val());
            $('#Country').val($('#Address5').val());
        } else {
            //Clear on uncheck
            $('#FatherAddress1').val("");
            $('#City').val("");
            $('#FatherAddress2').val("");
            $('#Country').val("");
            $('#Postcode').val("");
        }
    });
    $('#MotherDOB').change(function () {
        var today = new Date(),
        birthday = $('#MotherDOB').datepicker("getDate"),
        age = (
            (today.getMonth() > birthday.getMonth()) ||
            (today.getMonth() == birthday.getMonth() && today.getDate() >= birthday.getDate())
            ) ? today.getFullYear() - birthday.getFullYear() : today.getFullYear() - birthday.getFullYear() - 1;
        $('#MothercYear').val(age);
    });
    $('#PartnerDOB').change(function () {
        var today = new Date(),
        birthday1 = $('#PartnerDOB').datepicker("getDate"),
        age1 = (
            (today.getMonth() > birthday1.getMonth()) ||
            (today.getMonth() == birthday1.getMonth() && today.getDate() >= birthday1.getDate())
            ) ? today.getFullYear() - birthday1.getFullYear() : today.getFullYear() - birthday1.getFullYear() - 1;
        $('#PartnercYear').val(age1);
    });
});
        /* PLUGIN USED FOR FORM LOCAL STORAGE */
        $("form").sisyphus({
            customKeySuffix: "op",
            locationBased: true
        });
        $('input[name="review_days"]').blur(function () {
            var reviewDays = $(this).val();
            getReviewdays(reviewDays);
        });

        function getReviewdays(reviewDays) {
            $.ajax({
                Type: 'GET',
                url: '{{ url("out-patient-review") }}' + '/' + reviewDays,
                success: function (responseText) {
                    $('input[name="Review"]').val(responseText.next_review);
                },
                error: function (responseText) {}
            });
        }

        function drugsStrength(drug_id, id) {
            if (drug_id == null || !(drug_id > 0)) {
                Showalert('error', 'Please select valid drug');
                $('.formulation' + id).html('');
                $('.generic_name' + id).val('');
            } else {
                $.ajax({
                    Type: 'GET',
                    url: '{{ url("masters/drugs-strength/") }}' + '/' + drug_id,
                    success: function (responseText) {
                        var option = '<option value="">N/A</option>';
                        var generic_name = '';
                        var selectedTag = (responseText.length == 1) ? 'selected' : '';
                        $.each(responseText, function (index, values) {
                            if (values.Value != '' && values.Value != null) {
                                option += '<option value="' + values.Id + '" ' + selectedTag + '>' + values.Value + '</option>';
                                generic_name = values.generic_name;
                            }
                        });
                        $('.formulation' + id).html(option);
                        $('.generic_name' + id).val(generic_name);
                    },
                    error: function (responseText) {
                        var option = '<option value="">No data found</option>';
                        var generic_name = 'No data found';
                        $('.formulation' + id).html(option);
                        $('.generic_name' + id).val(generic_name);
                    }
                });
            }
        }
        $(document).on('change', '.drugs-changes', function () {
            var drug_id = $(this).val();
            var id = $(this).data('id');
            drugsStrength(drug_id, id);
            $(this).parent().parent().find('td .standard_dose').attr('disabled', false);
        });
        $('.drugs-changes1').change(function () {
            var drug_id = $(this).val();
            var id = $(this).data('id');
            drugsStrength(drug_id, id);
        });
        @if(Session::has('registration_start'))

        function saveNext() {
            var menuName = $('#op-form li[class="active"]').next('li').children('a').attr('href');
            var currentMenu = $('#op-form li[class="active"]').children('a').attr('href');
            if ($.cookie('op-next') == 'opform' && currentMenu.replace('#', '') == 'opform') {
                $('#print_flag').val('0');
            } else {
                $('#print_flag').val('2');
            }
            if (typeof menuName != 'undefined') {

                $.cookie('op-next', menuName.replace('#', ''), {
                    path: '/'
                });
            }
            $('#op-form').submit();
        }
        $('.save-only').click(function () {
            $('#print_flag').val('2');
            $('#op-form').submit();
        });
        $('.save-next').click(function () {
            saveNext();
        });
        var acive_id = $.cookie('op-next');
        if (acive_id != '' && acive_id != null) {
            $('#op-form li').each(function () {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                }
            });
            $('.tab-pane').each(function () {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                }
            });
            $('a[href="#' + acive_id + '"]').parent().addClass('active');
            $('#' + acive_id).addClass('active');
        }
        @endif
        $('.drug-masters').click(function () {
            $('#drug-master-modal').modal('show');
            $('input[name="generic_name"]').val('');
            $('input[name="Name"]').val('');
            $('input[name="Value[]"]').val('');
        });
        $('#save-btn').click(function () {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                data: $("#drug-post").serialize(),
                url: "{{ url('drug-update-master') }}",
                success: function (response) {
                    Showalert(response.messageType, response.message);
                    $('#drug-master-modal').modal('hide');
                    var options1 = '<option value="' + response.data.Id + '">' + response.data.generic_name + '</option>';
                    var options2 = '<option value="' + response.data.Id + '">' + response.data.Name + '</option>';
                    $('select[name="M_Drugs[]"]').each(function () {
                        $(this).append(options2)
                    });
                    $('select[name="temp_drugs"').append(options2);
                }
            });
        });
        $(document).on('click', '.op_save_btn', function (e) {
            if ($('#op-form').valid() === true) {
                e.preventDefault();
                var print_flag = $(this).data('flag');
                $('#print_flag').val(print_flag);
                $('.op_save_btn').prop('disabled', true);


                var current_clicked_element = $(this);
                $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: $('#op-form input, #op-form select, #op-form textarea').serialize(),
                    url: "{{ action('Registration\OpController@update', $results->OpId) }}",
                    success: function (response) {

                        if (print_flag == 1) {
                            Showalert('success', 'OP details updated successfully');
                            $('.op_save_btn').prop('disabled', false);
                            var next_tab = $('.nav.nav-tabs > .active').next('li').find('a');
                            if (next_tab.length > 0) {
                                if (next_tab.attr('href') == '#vaccine_chart') {
                                    current_clicked_element.html('<i class="fa fa-floppy-o" aria-hidden="true"></i> <span>Finish & Close</span>');
                                    window.location.href = response.list_url;
                                } else {
                                    current_clicked_element.html('<i class="fa fa-floppy-o" aria-hidden="true"></i> <span>Update & Next</span>');
                                    next_tab.trigger('click');
                                }
                            }
                            var medication_ids = response.medication_id;
                            medication_update(medication_ids);
                        } else if (print_flag == 2) {
                            Showalert('success', 'OP details updated successfully');
                            current_clicked_element.html('<i class="fa fa-floppy-o" aria-hidden="true"></i> <span>Update</span>');
                            $('.op_save_btn').prop('disabled', false);
                            var medication_ids = response.medication_id;
                            medication_update(medication_ids);
                        } else if (print_flag == 3) {
                            Showalert('success', 'OP details updated successfully');
                            window.location.href = response.print_url;
                        } else if (print_flag == 4) {
                            Showalert('success', 'OP details updated successfully');
                            window.location.href = response.neuro_print_url;
                        }
                    },
                    error: function () {
                        Showalert('error', 'Something went wrong, Please try again later...!');
                    }
                });
            }
        });

        function submitForm() {
    // $.ajax({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     },
    //     type: 'POST',
    //     data: $('#op-form input, #op-form select, #op-form textarea').serialize(),
    //         url: "{{ action('Registration\OpController@update', $results->OpId) }}",
    //     success: function (response) {
    //        console.log(response)
    //     },
    //     error: function()
    //     {

    //     }
    // });
}
$('#is_abnormal_movements').change(function () {
    checkAbnormalMovements();
});

$('#is_normal_movements').change(function () {
    checkNormalMovements();
});

checkAbnormalMovements();
checkNormalMovements();

$('#select-baby-age').change(function () {
    var selected_age = $(this).val();
    var baby_id = $('input[name=BabyId').val();
    if (selected_age != '' && baby_id != '') {
        changeFieldsWithBabyAge(selected_age);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            data: {
                baby_id: baby_id,
                selected_age: selected_age
            },
            url: "{{ action('Registration\OpController@checkNeuroRecordExist') }}",
            success: function (response) {

                if (response.result != null && response.result.length != 0) {
                    console.log(response.result);
                }
            },
            error: function () {
                Showalert('error', 'Something went wrong, Please try again later...!');
            }
        });
    }
});
var baby_age = $('#select-baby-age').val();
changeFieldsWithBabyAge(baby_age);

@if(!isset($_COOKIE['op-next-sub']) && empty($_COOKIE['op-next-sub']))
$(document).on('click', '#neuro_developmental_tab', function () {
    $('#eligibility_tab').addClass('active');
    $('#eligibilityform').addClass('active');
});
@endif

$('#intergrowth-chart').on('click', function (e) {
    e.preventDefault();
    var sex = $('#op-form #babyform #Sex').val();
    if (!(sex == 'Male' || sex == 'Female')) {
        Showalert('warning', 'Please select the Sex.');
        $("#Sex").select2("open");
    } else {
        $('#print_flag').val('6');
        $('#op-form').submit();
    }
});
$('#zero-five-chart').on('click', function (e) {
    e.preventDefault();
    var sex = $('#op-form #babyform #Sex').val();
    if (!(sex == 'Male' || sex == 'Female')) {
        Showalert('warning', 'Please select the Sex.');
        $("#Sex").select2("open");
    } else {
        $('#print_flag').val('5');
        $('#op-form').submit();
    }
});    
</script>
@include('registration.op_script');       
@endsection
