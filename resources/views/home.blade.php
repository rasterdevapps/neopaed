@extends('app')
@section('content')
<?php 
$permission = session('menu_permission');
$specialPermission = \Session::get('specialPermissions');
$permissions=session('menu_permission');
$read_permission = session('read_permission');
$write_permission = session('write_permission');
?>
<style type="text/css">
    .widget-content.no-padding table
    {
        text-align: left; 
    }
</style>
@if (!isset($_GET['seperate']) || (isset($_GET['seperate']) && !$_GET['seperate']))
<div class="row row-spacing">
    <div class="page-header">
        @if(in_array('NICU_FORM',$write_permission) || in_array('POST_FORM',$write_permission) || in_array('OP_REG',$write_permission))                                
            <div class="col-md-3 col-sm-4">
                <a href="javascript:void(0);" id="new-patinent-home" class="btn btn-primary input-block-level homepage-banner">
                    <i class="fa fa-plus fa-2x"></i>
                    <div>{{ Lang::get('menu.card_admission_registration') }}</div>
                </a>
            </div>
        @endif
        @if(in_array('NICU_DAY',$write_permission) || in_array('POST_DAY',$write_permission))                                
            <div class="col-md-3 col-sm-4">
                <a href="javascript:void(0);" id="daily-care-home" class="btn btn-info input-block-level homepage-banner">
                    <i class="fas fa-notes-medical fa-2x"></i>
                    <div>{{ Lang::get('menu.card_daily_entry') }}</div>
                </a>
            </div>
        @endif
        @if(in_array('NICU_MODULE_SHEET',$write_permission))                                
        <div class="col-md-3 col-sm-4">
            <a href="javascript:void(0);" id="nurse-by-registration" class="btn btn-info input-block-level homepage-banner">
                <i class="fas fa-user-nurse fa-2x"></i>
                <div>{{ Lang::get('menu.card_registartion_by_nurse') }}</div>
            </a>
        </div>
        @endif
        @if(in_array('NICU_NURSE_DAY',$write_permission))                                
            <div class="col-md-3 col-sm-4">
                <a href="{{ action('Nurse\NicuNurseDaycareController@create') }}" id="nurse-daily-care-home" class="btn btn-info input-block-level homepage-banner">
                    <i class="fas fa-user-nurse fa-2x"></i>
                    <div> {{ Lang::get('menu.card_nurse_daily_entry') }}</div>
                </a>
            </div>
        @endif
        <!-- <div class="clearfix"></div> -->
        <!-- Flow Control -->
        @if(in_array('NICU_MODULE_SHEET',$write_permission))                                
            @if(env('MONITOR_INTERFACE') || env('VENTILATOR_MACHINE') || env('LAB_INTERFACE'))
                <div class="col-md-3 col-sm-4">
                    <a href="{{ action('Nurse\NurseSheetController@create') }}"  class="btn btn-alert input-block-level homepage-banner" id="nurse-hour-wise">
                        <i class="fas fa-user-nurse fa-2x"></i>
                        <div>{{ Lang::get('menu.card_nurse_hour_wise') }}</div>
                    </a>
                </div>
            @else
                <div class="col-md-3 col-sm-4">
                    <a href="{{ action('NurseManual\NurseManualController@create') }}"  class="btn btn-alert input-block-level homepage-banner" id="nurse-hour-wise">
                        <i class="fas fa-user-nurse fa-2x"></i>
                        <div>{{ Lang::get('menu.card_nurse_hour_wise') }}</div>
                    </a>
                </div>
            @endif
        @endif
        @if(in_array('NICU_DISCHARGE',$write_permission) || in_array('POST_DISCHARGE',$write_permission))                                
            <div class="col-md-3 col-sm-4">
                <a href="javascript:void(0);" id="discharge-home" class="btn btn-alert input-block-level homepage-banner">
                    <i class="fas fa-clinic-medical fa-2x"></i>
                    <div>{{ Lang::get('menu.card_discharge_transfer')}}</div>
                </a>
            </div>
        @endif
        @if(in_array('CALENDAR',$permission) || Auth::user()->id == env('CALENDAR_SEEN_BY_ID'))                                
        <div class="col-md-3 col-sm-4">
            <a href="{{ action('HomeController@calendar') }}" class="btn btn-alert input-block-level homepage-banner" id="home-calendar">
                <i class="fa fa-calendar fa-2x"></i>
                <div>{{ Lang::get('menu.card_home_calendar') }}</div>
            </a>
        </div>
        @endif
        <!-- <div class="clearfix"></div> -->
        <!-- /Flow Control -->
        <!--=== Page Content ===-->
        @if(in_array('CALCULATOR',$permission))
            <div class="col-md-3 col-sm-4">
                <a href="{{ action('Calculators\BallardController@index') }}" class="btn btn-primary input-block-level homepage-banner" id="ballard-score">
                    <i class="fa fa-tachometer fa-2x"></i>
                    <div>{{ Lang::get('menu.card_ballard_score') }}</div>
                </a>
            </div>
            <div class="col-md-3 col-sm-4">
                <a href="{{ action('Calculators\GlucoseController@index') }}" class="btn btn-info input-block-level homepage-banner" id="glucose-rate">
                    <i class="fa fa-calculator fa-2x"></i>
                    <div>{{ Lang::get('menu.card_glucose_rate') }}</div>
                </a>
            </div>
            <div class="col-md-3 col-sm-4">
                <a href="{{ action('Calculators\AgeController@index') }}" class="btn btn-success input-block-level homepage-banner" id="age-calculator">
                    <i class="fas fa-weight fa-2x"></i>
                    <div>{{ Lang::get('menu.card_age_calculator') }}</div>
                </a>
            </div>
            <div class="col-md-3 col-sm-4">
                <a href="{{ action('Calculators\TpnCalculatorController@index') }}" class="btn btn-success input-block-level homepage-banner" id="tpn-calculator">
                    <i class="fas fa-balance-scale fa-2x"></i>
                    <div>{{ Lang::get('menu.side_menu_tpn_calculator') }}</div>
                </a>
            </div>
        @endif
        @if(is_array($permissions) && in_array('DELETE_ACCESS',$permissions))   
            <div class="col-md-3 col-sm-4">
                <a href="javascript:void(0);" class="btn btn-alert input-block-level homepage-banner" id="remove-record">
                    <i class="fa fa-eraser fa-2x"></i>
                    <div>{{ Lang::get('menu.card_remove_record') }}</div>
                </a>
            </div>
        @endif
        @if(is_array($permissions) && in_array('WARD_MANAGEMENT',$permissions))   
            <div class="col-md-3 col-sm-4">
                <a href="{{ action('Ward\BabyWardController@index') }}" class="btn btn-success input-block-level homepage-banner" id="ward-management">
                    <i class="fas fa-bed"></i>
                    <div>{{ Lang::get('menu.card_ward_mangagement')}}</div>
                </a>
            </div>
        @endif
        @if(is_array($permissions) && in_array('HERO',$permissions))   
        <div class="col-md-3 col-sm-4">
            <a href="javascript:void(0)" class="btn btn-success input-block-level homepage-banner side-nav-btn hero-btn" id="hero-score" onclick="openSideMenu('hero')">
                <img src="{{url('public/bed-image/monitor-wave.png')}}" >
                <div>
                    {{ Lang::get('menu.card_hero')}}
                </div>
            </a>
            <a href="{{ action('Nurse\NurseSheetController@getHeroScore') }}" class="btn btn-default" id="hero-export-btn" title="Export"><i class="fa fa-download" aria-hidden="true"></i></a>
        </div>
        @endif
        @if(is_array($permissions) && in_array('NSOFA',$permissions))   
        <div class="col-md-3 col-sm-4">
            <a href="{{ action('Reports\NsofaController@index') }}" class="btn btn-success input-block-level homepage-banner side-nav-btn nsofa-btn" id="nsofa-score">
                <!-- <img src="{{url('public/img/nsofa.png')}}" > -->
                <i class="fa fa-stethoscope" aria-hidden="true"></i>
                <div>{{ Lang::get('menu.card_nsofa_score')}}</div>
            </a>
        </div>
        @endif
        @if(is_array($permissions) && in_array('MSNS',$permissions))   
        <div class="col-md-3 col-sm-4">
            <a href="{{ action('Reports\MSNSController@index') }}" class="btn btn-success input-block-level homepage-banner side-nav-btn msns-btn" id="msns-score">
                <i class="fa fa-tasks" aria-hidden="true"></i>
                <div>{{ Lang::get('menu.card_msns_score')}}</div>
            </a>
        </div>
        @endif
        @if(is_array($permissions) && in_array('NICU_TIME_LINE',$read_permission))   
        <div class="col-md-3 col-sm-4">
            <a href="{{ action('HomeController@getNICUTimelinePage') }}" class="btn btn-success input-block-level homepage-banner" id="nicu-time-line">
                <i class="fas fa-history fa-2x"></i>
                <div>{{ Lang::get('menu.card_nicu_time_line') }}</div>
            </a>
        </div>
        @endif
        @if(is_array($permissions) && in_array('NUTRITION_CHART',$permissions))   
        <div class="col-md-3 col-sm-4">
            <a href="{{ action('Reports\NutritionChartController@index') }}" class="btn btn-success input-block-level homepage-banner side-nav-btn nutrition-btn" id="nutrition-score">
                <i class="fa fa-heartbeat" aria-hidden="true"></i>
                <div>
                    {{ Lang::get('menu.card_nutrition_chart')}}
                </div>
            </a>
        </div>
        @endif
    </div>
</div>
@include('search.report')     
@endif
@endsection
@section('scripts')
<script type="text/javascript">
    $('.fa-angle-down').click();
    
    $(".hover-fx").each(function() {   
        if (this.href == window.location.href) {
            $(this).addClass("active-menu");
        }
    });
</script>
@endsection
