@extends('print')
@section('content')
<style>
    #score {
        margin: auto;
    }
    #scaled-container {
        width: 400px;
        float: left;
    }
    #scaled {
        width: 400px;
        height: 650px;        
    }
    #standard-container {
        width: 260px;
        float: left;
    }
    #standard {
        width: 260px;
        height: 650px;        
    }
    @media print {
        .col-md-7.col-sm-12.col-xs-12 {
            width: 58.333333333%;
        }
        .col-md-6.col-sm-12.col-xs-12 {
            width: 50%;
        }
        .col-md-5.col-sm-12.col-xs-12 {
            width: 41.666666665%;
        }
        #fixed-footer {
            margin-top: 80vh;
        }
    }
</style>
@php $size = 6; @endphp
@if (empty($results->BirthWeight) && empty($results->current_weight_g) && empty($results->current_ofc) && empty($results->current_length) && (empty($results->MotherBloodGroup) || $results->MotherBloodGroup == 'Not Known') && (empty($results->BabyBloodGroup) || $results->BabyBloodGroup == 'Not Known')) 
@php $size = 12; @endphp
@endif
<div class="temp-container">
    <div class="temp-row">
        <div class="@if(isset($page_config->id)) hidden-print @endif">
            <div class="col-md-12 col-sm-12 col-xs-12 header-img">
                @if(isset($results->id))
                <img src="{{ SiteHelpers::getOpLogo($results->id) }}">
                @endif
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h4 class="print-head">
                <strong>
                    <p>Bayley Scales of Infant and Toddler Development<sup>TM</sup>, Fourth Edition (Bayley<sup>TM</sup>-4)</p>
                    <p>Cognitive, Language, and Motor Scales Score Report</p>
                </strong>
            </h4>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="content-block"> 
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                    <div class="col-md-7 col-sm-12 col-xs-12 plr-must-0">
                        <h5><b><u>Basic Details</u></b></h5>
                        <div class="col-md-{!! $size !!} col-sm-12 col-xs-12 plr-must-0">
                            <div class="form-group">
                                <div>
                                    <span class="print-label-text">{{ Lang::get('home.mrn') }}:</span> 
                                    <span class="print-label-value">{!! $results->BMrNo; !!}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <span class="print-label-text">Name:</span> 
                                    <span class="print-label-value">{!! $results->BabyName; !!}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <span class="print-label-text">DOB:</span> 
                                    <span class="print-label-value">{!! date("d-m-Y",strtotime($results->DOB)); !!}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <span class="print-label-text">Sex:</span> 
                                    <span class="print-label-value">{!! $results->Sex; !!}</span>
                                </div>                            
                            </div> 
                            @if (!empty($results->g_weeks))
                            <div class="form-group">
                                <div>
                                    <span class="print-label-text">Gestation (wks):</span> 
                                    <span class="print-label-value"><b>{!! $results->g_weeks !!}</b> {!! !empty($results->g_days) ? ('W <b>' . $results->g_days . '</b> D') : '' !!}</span>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 plr-must-0">
                            @if (!empty($results->BirthWeight))
                            <div class="form-group">
                                <span class="print-label-text">Birth Weight(g):</span> 
                                <span class="print-label-value">{!! $results->BirthWeight; !!}</span>
                            </div>  
                            @endif
                            @if (!empty($results->current_weight_g))
                            <div class="form-group">
                                <span class="print-label-text">Current Weight:</span> 
                                <span class="print-label-value">{{ $results->current_weight_g > 1000 ? number_format($results->current_weight_g / 1000, 2) . ' (KG)': $results->current_weight_g.' (G)'  }}</span>
                            </div> 
                            @endif
                            @if (!empty($results->current_ofc))
                            <div class="form-group">
                                <span class="print-label-text">OFC (cm):</span> 
                                <span class="print-label-value">{!! $results->current_ofc; !!}</span>
                            </div>
                            @endif
                            @if (!empty($results->current_length))
                            <div class="form-group">
                                <span class="print-label-text">Length / Height (cm):</span> 
                                <span class="print-label-value">{!! $results->current_length; !!}</span>
                            </div>   
                            @endif
                            @if (!empty($results->MotherBloodGroup) && $results->MotherBloodGroup != 'Not Known')
                            <div class="form-group">
                                <span class="print-label-text">Mother Blood Group:</span> 
                                <span class="print-label-value">{!! $results->MotherBloodGroup; !!}</span>
                            </div> 
                            @endif
                            @if (!empty($results->BabyBloodGroup) && $results->BabyBloodGroup != 'Not Known')
                            <div class="form-group">
                                <span class="print-label-text">Baby's Blood Group:</span> 
                                <span class="print-label-value">{!! $results->BabyBloodGroup; !!}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-12 col-xs-12 plr-must-0">
                        <h5><b><u>Test Information</u></b></h5>
                        <div class="form-group">
                            <div>
                                <span class="print-label-text">Test Date:</span> 
                                <span class="print-label-value">{!! date("d-m-Y",strtotime($results->visit_date)); !!}</span>
                            </div>
                        </div>
                        @if($results->g_weeks == 0 || $results->g_weeks > 36 || ($results->g_weeks < 37 && $results->corrected_year > 1))
                        <div class="form-group">
                            <div>
                                <span class="print-label-text">Test Age:</span> 
                                {!! empty($results->chronological_year)  ? '<b>0 </b>Year' : ' <b>'.$results->chronological_year .' </b>Years';  !!}
                                {!! empty($results->chronological_month) ? '<b>0 </b>Month' : ' <b>'.$results->chronological_month.' </b>Months';  !!} 
                                {!! empty($results->chronological_days) ? '<b>0 </b>Day' : ' <b>'.$results->chronological_days.' </b>Days';  !!} 
                            </div>
                        </div>
                        @else
                        <div class="form-group">
                            <div>
                                <span class="print-label-text">Test Age:</span> 
                                {!! empty($results->chronological_year)  ? ' <b>0 </b>Year' : ' <b>'.$results->chronological_year .' </b>Years';  !!}
                                {!! empty($results->chronological_month) ? ' <b>0 </b>Month' : ' <b>'.$results->chronological_month.' </b>Months';  !!} 
                                {!! empty($results->chronological_days) ? '<b>0 </b>Day' : ' <b>'.$results->chronological_days.' </b>Days';  !!} 
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label-text">Adjusted Test Age:</span> 
                                {!! empty($results->corrected_year)  ? '<b>0 </b>Year' : ' <b>'.$results->corrected_year .' </b>Year(s)';  !!}
                                {!! empty($results->corrected_month) ? '<b>0 </b>Month' : ' <b>'.$results->corrected_month .' </b>Month(s)';  !!} 
                                {!! empty($results->corrected_days) ? '<b>0 </b>Day' : ' <b>'.$results->corrected_days.' </b>Days';  !!} 
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <div>
                                <span class="print-label-text">Examiner Name:</span> 
                                <span class="print-label-value">{!! \ValuelistHelpers::mas_doctors_list($results->examiner) !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label-text">Caregiver Name:</span> 
                                <span class="print-label-value">{!! $results->caregiver_name; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <span class="print-label-text">Relationship to Child:</span> 
                            <span class="print-label-value">{!! $results->relationship_to_child; !!}</span>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                        <div class="form-group">
                            <span class="print-label print-label-text">Background Details:</span> 
                            <span class="op-value print-label-value">{!! $results->baby_background; !!}</span>
                        </div>   
                        <div class="form-group">
                            <span class="print-label-text">Reason for Referral:</span> 
                            <span class="print-label-value">{!! $results->reason_referral; !!}</span>
                        </div> 
                    </div> 
                </div>  
            </div>  
            <div class="col-md-12 col-sm-12 col-xs-12 mt-15">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 mt-15 plr-must-0">
                        <h4><b>SCORE SUMMARY</b></h4>
                        <div class="">
                            <h5><b>Subtest Scaled Score Summary</b></h5>
                            <table class="table table-bordered table-responsive table-fixed">
                                <thead>
                                    <tr>
                                        <th class="text-left">Scale<br/><span class="pl-15">Subtest</span></th>
                                        <th>Raw score</th>
                                        <th>Scaled score</th>
                                        <th>Age equivalent</th>
                                        <th>Growth scale<br/>value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-left score-bg-cg" colspan="5"><b>Cognitive</b></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left plr-15">Cognitive (CG)</td>
                                        <td>{!! $results->cg !!}</td>
                                        <td>{!! $results->cg_scaled_score !!}</td>
                                        <td>{!! $results->cg_age_equivalent !!}</td>
                                        <td>{!! $results->cg_growth_scale !!}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left score-bg-rc" colspan="5"><b>Language</b></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left plr-15">Receptive<br/>Communication (RC)</td>
                                        <td>{!! $results->rc !!}</td>
                                        <td>{!! $results->rc_scaled_score !!}</td>
                                        <td>{!! $results->rc_age_equivalent !!}</td>
                                        <td>{!! $results->rc_growth_scale !!}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left plr-15">Expressive<br/>Communication (EC)</td>
                                        <td>{!! $results->ec !!}</td>
                                        <td>{!! $results->ec_scaled_score !!}</td>
                                        <td>{!! $results->ec_age_equivalent !!}</td>
                                        <td>{!! $results->ec_growth_scale !!}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left score-bg-fm" colspan="5"><b>Motor</b></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left plr-15">Fine Motor (FM)</td>
                                        <td>{!! $results->fm !!}</td>
                                        <td>{!! $results->fm_scaled_score !!}</td>
                                        <td>{!! $results->fm_age_equivalent !!}</td>
                                        <td>{!! $results->fm_growth_scale !!}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left plr-15">Gross Motor (GM)</td>
                                        <td>{!! $results->gm !!}</td>
                                        <td>{!! $results->gm_scaled_score !!}</td>
                                        <td>{!! $results->gm_age_equivalent !!}</td>
                                        <td>{!! $results->gm_growth_scale !!}</td>
                                    </tr>
                                </tbody>
                            </table>  
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 mt-15">
                        <div class="row">      
                            <h5><b>Standard Score Summary</b></h5>
                            <table class="table table-bordered table-responsive table-fixed">
                                <thead>
                                    <tr>
                                        <th class="text-left">Scale<br/><span class="pl-15">Subtest</span></th>
                                        <th>Sum of scaled<br/>scores</th>
                                        <th>Standard score</th>
                                        <th>Percentile rank</th>
                                        <th>{!! $results->confidence_interval !!} % Confidence<br/>interval</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-left score-bg-cg" colspan="5"><b>Cognitive, Language, and Motor</b></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Cognitive (COG)</td>
                                        <td>{!! $results->cg_scaled_score !!}</td>
                                        <td>{!! $results->cog_standard_score !!}</td>
                                        <td>{!! $results->cog_percentile_rank !!}</td>
                                        <td>{!! $results->cog_confidence_interval_start !!} - {!! $results->cog_confidence_interval_end !!}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Language (LANG)</td>
                                        <td>{!! $results->lang_scaled_score !!}</td>
                                        <td>{!! $results->lang_standard_score !!}</td>
                                        <td>{!! $results->lang_percentile_rank !!}</td>
                                        <td>{!! $results->lang_confidence_interval_start !!} - {!! $results->lang_confidence_interval_end !!}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Motor (MOT)</td>
                                        <td>{!! $results->mot_scaled_score !!}</td>
                                        <td>{!! $results->mot_standard_score !!}</td>
                                        <td>{!! $results->mot_percentile_rank !!}</td>
                                        <td>{!! $results->mot_confidence_interval_start !!} - {!! $results->mot_confidence_interval_end !!}</td>
                                    </tr>
                                </tbody>
                            </table>    
                        </div>
                    </div>
                    {!! Form::hidden('cg', $results->cg_scaled_score) !!}
                    {!! Form::hidden('rc', $results->rc_scaled_score) !!}
                    {!! Form::hidden('ec', $results->ec_scaled_score) !!}
                    {!! Form::hidden('fm', $results->fm_scaled_score) !!}
                    {!! Form::hidden('gm', $results->gm_scaled_score) !!}

                    {!! Form::hidden('cog', $results->cog_standard_score) !!}
                    {!! Form::hidden('lang', $results->lang_standard_score) !!}
                    {!! Form::hidden('mot', $results->mot_standard_score) !!}

                    {!! Form::hidden('cog_start', $results->cog_confidence_interval_start) !!}
                    {!! Form::hidden('cog_end', $results->cog_confidence_interval_end) !!}
                    {!! Form::hidden('lang_start', $results->lang_confidence_interval_start) !!}
                    {!! Form::hidden('lang_end', $results->lang_confidence_interval_end) !!}
                    {!! Form::hidden('mot_start', $results->mot_confidence_interval_start) !!}
                    {!! Form::hidden('mot_end', $results->mot_confidence_interval_end) !!}

                    {!! Form::hidden('confidence_interval', $results->confidence_interval) !!}
                    <div class="page-break-always"></div>
                    <div class="col-md-12 col-sm-12 col-xs-12 mt-15 plr-must-0">
                        <h4><b>SCORE SUMMARY PROFILE</b></h4>
                        <div class=" display-flex">
                            <div id="score">
                                <div id="scaled-container">
                                    <h5 class="text-center mb-0"><b>Subtest Score Profile</b></h5>
                                    <div id="scaled"></div>
                                </div>
                                <div id="standard-container">
                                    <h5 class="text-center mb-0"><b>Standard Score Profile</b></h5>
                                    <div id="standard"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-break-always"></div>
                </div>  
            </div>  
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0" id="fixed-footer">
                <div class="col-md-6 col-sm-6 col-xs-6 text pull-left plr-must-0">
                    <p class="col-md-12 col-sm-12 col-xs-12">Date : <b>{!! date("d-m-Y",strtotime($results->visit_date)); !!} </b></p>
                    <p class="col-md-12 col-sm-12 col-xs-12">Place: <b>{!! env('LOCATION')!!}</b></p>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 text-center fontweight">
                    <div class="pull-right">
                        @if (!empty($results->seen_by))
                        @php 
                        $seen_by = $results->seen_by; 
                        $seen_by = \ValuelistHelpers::signatureFormat($seen_by);
                        @endphp
                        {!! $seen_by !!}
                        @endif                    
                    </div>
                </div>
            </div>
        </div> 
    </div>      
    @endsection