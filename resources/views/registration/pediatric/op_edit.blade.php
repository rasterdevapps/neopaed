@extends('app')
@section('content')
<?php 
    $write_permission = session('write_permission');
?>
<style type="text/css">    
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
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="fa fa-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li><a href="{{ action('Registration\PediatricOpController@index') }}">Pediatric OP Registration</a></li>
        <li><a href="{{ action('Registration\PediatricOpController@OpsubList',SiteHelpers::encrypt_id($baby_detail->baby_id)) }}">Visits</a></li>
        <li class="current"><a title="">Edit @if(isset($baby_detail->BabyName)){{ $baby_detail->BabyName.' - '.$baby_detail->BMrNo }} @endif</a></li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<div class="row mt-10">

    <a class="btn btn-primary pull-right mb-10 mlr-10 @if($current_age >= 5) active-btn @else not-active-btn @endif" id="Greater-than-five-chart" href="{{ action('charts\WhoGrowthChartcontroller@greaterthanfive').'?baby_id='.SiteHelpers::encrypt_id($baby_detail->BabyId).'&closewinlink=pediatric_edit&id='.SiteHelpers::encrypt_id($baby_detail->id) }}">WHO Growth Chart (>= 5)</a>
    
    <a class="btn btn-primary pull-right mb-10 mlr-10 @if(((empty($baby_detail->g_weeks) || (isset($baby_detail->g_weeks) && $baby_detail->g_weeks > 36)) || (isset($baby_detail->g_weeks) && $baby_detail->g_weeks <= 36 && $current_chart_age > 64)) && $current_age < 5) active-btn @else not-active-btn @endif" id="zero-five-chart" href="{{ action('charts\WhoGrowthChartcontroller@index').'?baby_id='.SiteHelpers::encrypt_id($baby_detail->BabyId).'&closewinlink=pediatric_edit&id='.SiteHelpers::encrypt_id($baby_detail->id) }}"> WHO Growth Chart</a>

    <a class="btn btn-primary pull-right mb-10 mlr-10 @if(isset($baby_detail->g_weeks) && !empty($baby_detail->g_weeks) && $baby_detail->g_weeks < 37 && $current_chart_age <= 64 && $current_age < 5) active-btn @else not-active-btn @endif" id="intergrowth-chart" href="{{ action('charts\InterGrowthChartController@index').'?baby_id='.SiteHelpers::encrypt_id($baby_detail->BabyId).'&closewinlink=pediatric_edit&id='.SiteHelpers::encrypt_id($baby_detail->id) }}">Intergrowth 21st Century Chart</a>

</div>
{!! Form::model($baby_detail,['method'=>'PATCH', 'url' => action('Registration\PediatricOpController@update', $baby_detail->id),'id'=>'pediatric-op-form']) !!}
{!! Form::hidden('id',@$baby_detail->id) !!}
<div class="row row-spacing m-15">
    <div role="tabpanel" class="tabbable tabbable-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="@if(isset($_GET['closewinlink']) && $_GET['closewinlink'] == 'flow') @else active @endif"><a href="#basicform" aria-controls="basicform" role="tab" data-toggle="tab">Basic Details</a></li>
            <li role="presentation" class="@if(isset($_GET['closewinlink']) && $_GET['closewinlink'] == 'flow') active @endif"><a href="#vaccine_chart" aria-controls="vaccine_chart" role="tab" data-toggle="tab">Vaccine</a></li>
 	    @if (isset($neonatal_today_visit->OpId))
                <span class="pull-right">
                    <a class="btn btn-info-must ptb-5 ml-15" target="_blank" href="{{ action('Registration\OpController@OpsubList',SiteHelpers::encrypt_id($neonatal_today_visit->BabyId))  }}"> Neonatal OP</a>
                </span>
            @endif

        @if(in_array('LABREQUEST',$write_permission))   
            <a href="{{ action('Nurse\NurseSheetController@overallLabValuePrint', $baby_detail->BMrNo).'?visitid='.SiteHelpers::encrypt_id($baby_detail->id).'&closewinlink=pediatric-op-visit' }}" class="btn btn-primary ptb-5 pull-right">
                <i class="fa fa-print"></i>
                <span>Lab Report</span>
            </a> 
        @endif  
        </ul>
        <!-- Tab panes -->
        <div class="tab-content tab-view-shadow">
            <div role="tabpanel" class="tab-pane @if(isset($_GET['closewinlink']) && $_GET['closewinlink'] == 'flow') @else active @endif" id="basicform">
                @include('errors.list')
                @include('registration.pediatric.op_form')
            </div>
            <div role="tabpanel" class="tab-pane @if(isset($_GET['closewinlink']) && $_GET['closewinlink'] == 'flow') active @endif" id="vaccine_chart">
                @include('registration.vaccine_chart')
            </div>
            <div class="col-md-12 col-sm-12 mb-15">
                <input type="hidden" name="print_flag" value="0" id="print_flag">
                @if(isset($_GET['closewinlink']) && $_GET['closewinlink'] == 'flow')
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <button type="button" class="btn btn-block edit-button-shadow btn-primary form-control custom-submit" data-flag="5">
                        <i class="fa fa-floppy-o"></i> 
                        <span>Finish & Close</span>
                    </button>
                </div>
                @else
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <button type="button" class="btn btn-block edit-button-shadow btn-primary form-control custom-submit" data-flag="2">
                        <i class="fa fa-floppy-o"></i> 
                        <span>Update</span>
                    </button>
                </div>
                @endif
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <button type="submit" class="btn btn-block edit-button-shadow btn-info form-control" data-flag="3">
                        <i class="fa fa-print"></i> 
                        <span>Print</span>
                    </button>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <button type="submit" class="btn btn-block edit-button-shadow btn-info form-control" data-flag="4">
                        <i class="fa fa-print"></i> 
                        <span>Print All</span>
                    </button>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="{{ action('Registration\PediatricOpController@index') }}" class="btn btn-block btn-default form-control" data-flag="0">
                        <i class="fa fa-exclamation-circle"></i> 
                        <span>Cancel</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection
