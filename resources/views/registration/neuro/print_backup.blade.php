@extends('print')
@section('content')
@php
$site_url = url('/').'/public';
@endphp
@php $size = 6; @endphp
@if (empty($results->BirthWeight) && empty($results->current_weight_g) && empty($results->current_ofc) && empty($results->current_length) && (empty($results->MotherBloodGroup) || $results->MotherBloodGroup == 'Not Known') && (empty($results->BabyBloodGroup) || $results->BabyBloodGroup == 'Not Known')) 
@php $size = 12; @endphp
@endif
<div class="temp-container" id="neuro-report-print">
    <div class="temp-row">
        <div class="col-md-12 col-xs-12">
            @if(isset($results->neuro_visit_id))
            <img src="{{ SiteHelpers::getOpLogo($results->neuro_visit_id) }}" class="img-responsive">
            @endif
        </div>
        <div class="clearfix"></div>
        @if(($neuro_consultant_id == @$results->visit_from) || ($pvs == @$results->visit_from))
        <div class="col-md-6 col-sm-6 col-xs-6 mt-15">
            <table style="margin-bottom: 0px;">
                <tr>
                    <td class="vertical-top" style="border: 0px !important;">
                        <p>
                            <span style="font-size:14px">
                                <u>
                                    <strong>Consultant Child and Adolescent Psychiatrist</strong>
                                </u>
                            </span>
                        </p>
                        <p>
                            <strong>Dr R. Shinika</strong> MD, DNB, PDF (CAP)
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <table style="margin-bottom: 0px;">
                <tr>
                    <td class="vertical-top" style="border: 0px !important;">
                        <p>
                            <span style="font-size:14px">
                                <u>
                                    <strong>Consultant Developmental Pediatrician</strong>
                                </u>
                            </span>
                        </p>
                        <p>
                            <strong>Dr P. Vani </strong>  DCH, PGDDN (CDC, Trivandrum)
                          
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <table style="margin-bottom: 0px;">
                <tr>
                    <td class="vertical-top" style="border: 0px !important;">
                        <p>
                            <span style="font-size:14px">
                                <u>
                                    <strong>Clinical Psychologist</strong>
                                </u>
                            </span>
                        </p>
                        <p>
                            <strong>Ms Ramya Dharshini P</strong> M.sc., M.Phil, Clinical Psychology (NIMHANS)
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <table style="margin-bottom: 0px;">
                <tr>
                    <td class="vertical-top" style="border: 0px !important;">
                        <p>
                            <span style="font-size:14px">
                                <u>
                                    <strong>Early Childhood Interventionist, Infant feeding and Lactation professional</strong>
                                </u>
                            </span>
                        </p>
                        <p>
                            <strong>Mrs Nivetha .J</strong> M.Sc.,ACD; ACLP
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <table style="margin-bottom: 0px;">
                <tr>
                    <td class="vertical-top" style="border: 0px !important;">
                        <p>
                            <span style="font-size:14px">
                                <u>
                                    <strong>Early Childhood Interventionist</strong>
                                </u>
                            </span>
                        </p>
                        <p>
                            <strong>Ms Parimala</strong> M.Sc., ACD; B.Sc Psy
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <table style="margin-bottom: 0px;">
                <tr>
                    <td class="vertical-top" style="border: 0px !important;">
                        <p>
                            <span style="font-size:14px">
                                <u>
                                    <strong>Rehabilitation specialist and Special educator</strong>
                                </u>
                            </span>
                        </p>
                        <p>
                            <strong>Ms Alice Mary Ann D</strong> M.R.Sc., B.S.Ed-ID.,
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <table style="margin-bottom: 0px;">
                <tr>
                    <td class="vertical-top" style="border: 0px !important;">
                        <p>
                            <span style="font-size:14px">
                                <u>
                                    <strong>Pediatric Occupational Therapist</strong>
                                </u>
                            </span>
                        </p>
                        <p>
                            <strong>Ms Soundarya G</strong> B.O.T., MOT<br>
                            <strong>Mrs Vidhya M</strong> B.O.T

                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <table style="margin-bottom: 0px;">
                <tr>
                    <td class="vertical-top" style="border: 0px !important;">
                        <p>
                            <span style="font-size:14px">
                                <u>
                                    <strong>Speech Language Pathologist</strong>
                                </u>
                            </span>
                        </p>
                        <p>
                            <strong>Ms Jenny G</strong> B.ASLP(NIEPMD)
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="clearfix"></div>
        @else
        <div class="col-md-12 col-sm-12 col-xs-12">
            <table style="margin-bottom: 0px;">
                <tr>
                    <td class="vertical-top" style="border: 0px !important;">
                        {!! $headerContent['discharge_report_left'] !!}
                    </td>
                </tr>
            </table>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <table style="margin-bottom: 0px;">
                <tr>
                    <td class="vertical-top" style="border: 0px !important;">
                        <p>
                            <span style="font-size:14px">
                                <u>
                                    <strong>Child development Therapist, Breastfeeding & Lactation Professional</strong>
                                </u>
                            </span>
                        </p>
                        <p>
                            <strong>Mrs J. Nivetha</strong> M.Sc.,ACD; ACLP
                        </p>
                        {!! $headerContent['discharge_report_right'] !!}
                    </td>
                </tr>
            </table>
        </div>
        @endif
        <div class="clearfix"></div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h3 class="print-head">DETAILED NEURODEVELOPMENTAL REPORT
                <span class="pull-right font-bold text-right" style="font-size: 14px;margin-top: 10px;">Date : {!! date("d-m-Y",strtotime(@$results->visit_date)); !!} </span>
            </h3>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="content-block pl-10-must">
                <div class="col-md-7 col-sm-12 col-xs-12 plr-must-0">
                    <h5><b><u>Basic Details</u></b></h5>
                    <div class="col-md-12 col-sm-12 col-xs-12">
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
                </div>                
                <div class="col-md-5 col-sm-12 col-xs-12 plr-must-0">
                    <h5><b><u>Test Information</u></b></h5>
                    <div class="col-md-12 col-sm-12 col-xs-12">
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
                        @if (!empty($results->examiner))
                        <div class="form-group">
                            <div>
                                <span class="print-label-text">Examiner Name:</span> 
                                <span class="print-label-value">{!! \ValuelistHelpers::mas_doctors_list($results->examiner) !!}</span>
                            </div>
                        </div>
                        @endif
                        @if (!empty($results->caregiver_name))
                        <div class="form-group">
                            <div>
                                <span class="print-label-text">Caregiver Name:</span> 
                                <span class="print-label-value">{!! $results->caregiver_name; !!}</span>
                            </div>
                        </div>
                        @endif
                        @if (!empty($results->relationship_to_child))
                        <div class="form-group">
                            <span class="print-label-text">Relationship to Child:</span> 
                            <span class="print-label-value">{!! $results->relationship_to_child; !!}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        @if (!empty(trim(strip_tags($results->baby_background))) || !empty($results->reason_referral))
        <div class="col-md-12 col-sm-12">
            <div class="content-block pl-10-must">
                @if (!empty($results->baby_background))
                <div class="form-group">
                    <h5 class="m-0"><strong>Background Details:</h5></strong>
                    <span class="pt-5 display-block pl-15" style="font-weight: normal;">{!! @$results->baby_background; !!}</span>
                </div> 
                @endif
                @if (!empty($results->reason_referral))
                <div class="form-group">
                    <h5 class="m-0"><strong>Reason for Referral:</h5></strong>
                    <span class="pt-5 display-block pl-15" style="font-weight: normal;">{!! $results->reason_referral; !!}</span>
                </div> 
                @endif
            </div>
        </div>
        @endif
        <div class="clearfix"></div>
        @php
        $rowspan_rop = $rowspan_aabr_hearing_screening = $rowspan_oae_hearing_screening = $rowspan_oae_hearing_assessment = $rowspan_audiometery_hearing_assessment =
        $rowspan_ct = $rowspan_usg = $rowspan_mri = 1;
        $previous_rop = $previous_aabr_hearing_screening = $previous_oae_hearing_screening = $previous_oae_hearing_assessment = $previous_audiometery_hearing_assessment = $previous_ct = $previous_usg = $previous_mri = '';
        $empty_content = '<tr><td></td><td></td><td></td><td></td></tr>';
        $empty_content_1 = '<tr><td></td><td></td></tr>';
        @endphp
        @if (isset($neuro_screening_result) && count($neuro_screening_result) > 0)
        @foreach($neuro_screening_result as $value)
        @php $value = (object)$value; @endphp
        @php $apply_style = $hearing_screen_aabr_date_style = $hearing_screen_oae_date_style = $diagnostic_abr_date_style = $diagnostic_cpa_date_style = $ct_date_style = $usg_date_style = $mri_date_style = ''; @endphp
        @if (count(json_decode($value->rop_options)) > 0 && in_array('rop', json_decode($value->rop_options)))
        @if ($value->rop_date == 'DD-MM-YYYY')
        @php $value->rop_date = '-'; @endphp
        @endif
        @php 
        $rowspan_rop++; 
        $previous_rop .= '<tr class="previous_screening"><td class="'. $apply_style . ' whitespace-nowrap">'. $value->rop_date .'</td><td>'. $value->rop_right_hand_side .'</td><td>'. $value->rop_left_hand_side .'</td><td>'. $value->rop_remarks .'</td></tr>';
        @endphp
        @endif
        @if (count(json_decode($value->hearing_screen_options)) > 0)
        @if (in_array('aabr', json_decode($value->hearing_screen_options)))
        @if ($value->hearing_screen_aabr_date == 'DD-MM-YYYY')
        @php $value->hearing_screen_aabr_date = '-'; @endphp
        @endif
        @php 
        $rowspan_aabr_hearing_screening++; 
        $previous_aabr_hearing_screening .= '<tr class="previous_screening"><td class="'. $hearing_screen_aabr_date_style . ' whitespace-nowrap">'. $value->hearing_screen_aabr_date .'</td><td>'. $value->hearing_screen_aabr_right_hand_side .'</td><td>'. $value->hearing_screen_aabr_left_hand_side .'</td><td>'. $value->hearing_screen_aabr_remarks .'</td></tr>';
        @endphp
        @endif
        @if (in_array('oae', json_decode($value->hearing_screen_options)))
        @if ($value->hearing_screen_oae_date == 'DD-MM-YYYY')
        @php $value->hearing_screen_oae_date = '-'; @endphp
        @endif
        @php 
        $rowspan_oae_hearing_screening++; 
        $previous_oae_hearing_screening .= '<tr class="previous_screening"><td class="'. $hearing_screen_oae_date_style . ' whitespace-nowrap">'. $value->hearing_screen_oae_date .'</td><td>'. $value->hearing_screen_oae_right_hand_side .'</td><td>'. $value->hearing_screen_oae_left_hand_side .'</td><td>'. $value->hearing_screen_oae_remarks .'</td></tr>';
        @endphp
        @endif
        @endif
        @if (count(json_decode($value->diagnostic_abr_options)) > 0)
        @if (in_array('abr', json_decode($value->diagnostic_abr_options)))
        @if ($value->diagnostic_abr_date == 'DD-MM-YYYY')
        @php $value->diagnostic_abr_date = '-'; @endphp
        @endif
        @php 
        $rowspan_oae_hearing_assessment++; 
        $previous_oae_hearing_assessment .= '<tr class="previous_screening"><td class="'. $diagnostic_abr_date_style . ' whitespace-nowrap">'. $value->diagnostic_abr_date .'</td><td>'. $value->diagnostic_abr_right_hand_side .'</td><td>'. $value->diagnostic_abr_left_hand_side .'</td><td>'. $value->diagnostic_abr_remarks .'</td></tr>';
        @endphp
        @endif
        @if (in_array('cpa', json_decode($value->diagnostic_abr_options)))
        @if ($value->diagnostic_cpa_date == 'DD-MM-YYYY')
        @php $value->diagnostic_cpa_date = '-'; @endphp
        @endif
        @php 
        $rowspan_audiometery_hearing_assessment++; 
        $previous_audiometery_hearing_assessment .= '<tr class="previous_screening"><td class="'. $diagnostic_cpa_date_style . ' whitespace-nowrap">'. $value->diagnostic_cpa_date .'</td><td>'. $value->diagnostic_cpa_right_hand_side .'</td><td>'. $value->diagnostic_cpa_left_hand_side .'</td><td>'. $value->diagnostic_cpa_remarks .'</td></tr>';
        @endphp
        @endif
        @endif
        @if (count(json_decode($value->head_test)) > 0)
        @if (in_array('ct', json_decode($value->head_test)))
        @if ($value->ct_date == 'DD-MM-YYYY')
        @php $value->ct_date = '-'; @endphp
        @endif
        @php 
        $rowspan_ct++; 
        $previous_ct .= '<tr class="previous_screening"><td class="'. $ct_date_style . '">'. $value->ct_date .'</td><td>'. $value->ct_imperssion .'</td></tr>';
        @endphp
        @endif
        @if (in_array('usg', json_decode($value->head_test)))
        @if ($value->usg_date == 'DD-MM-YYYY')
        @php $value->usg_date = '-'; @endphp
        @endif
        @php 
        $rowspan_usg++; 
        $previous_usg .= '<tr class="previous_screening"><td class="'. $usg_date_style . '">'. $value->usg_date .'</td><td>'. $value->usg_imperssion .'</td></tr>';
        @endphp
        @endif
        @if (in_array('mri', json_decode($value->head_test)))
        @if ($value->mri_date == 'DD-MM-YYYY')
        @php $value->mri_date = '-'; @endphp
        @endif
        @php 
        $rowspan_mri++; 
        $previous_mri .= '<tr class="previous_screening"><td class="'. $mri_date_style . '">'. $value->mri_date .'</td><td>'. $value->mri_imperssion .'</td></tr>';
        @endphp
        @endif
        @endif
        @endforeach
        @endif
        @if ($previous_rop == '')
        @php 
        $previous_rop = $empty_content; 
        $rowspan_rop++; 
        @endphp
        @endif
        @if ($previous_aabr_hearing_screening == '')
        @php 
        $previous_aabr_hearing_screening = $empty_content; 
        $rowspan_aabr_hearing_screening++; 
        @endphp
        @endif
        @if ($previous_oae_hearing_screening == '')
        @php 
        $previous_oae_hearing_screening = $empty_content; 
        $rowspan_oae_hearing_screening++; 
        @endphp
        @endif
        @if ($previous_oae_hearing_assessment == '')
        @php 
        $previous_oae_hearing_assessment = $empty_content; 
        $rowspan_oae_hearing_assessment++; 
        @endphp
        @endif
        @if ($previous_audiometery_hearing_assessment == '')
        @php 
        $previous_audiometery_hearing_assessment = $empty_content; 
        $rowspan_audiometery_hearing_assessment++; 
        @endphp
        @endif

        @if ($previous_ct == '')
        @php 
        $previous_ct = $empty_content_1; 
        $rowspan_ct++; 
        @endphp
        @endif
        @if ($previous_usg == '')
        @php 
        $previous_usg = $empty_content_1; 
        $rowspan_usg++; 
        @endphp
        @endif
        @if ($previous_mri == '')
        @php 
        $previous_mri = $empty_content_1; 
        $rowspan_mri++; 
        @endphp
        @endif
        @if ($previous_rop != $empty_content || $previous_aabr_hearing_screening != $empty_content || $previous_oae_hearing_screening != $empty_content || $previous_oae_hearing_assessment != $empty_content || $previous_audiometery_hearing_assessment != $empty_content)
        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="content-block p-0" style="border: none !important;">
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                        <table class="table table-bordered table-responsive screening">
                            <thead>
                                <tr>
                                    <th colspan="2"></th>
                                    <th>Date</th>
                                    <th>Right</th>
                                    <th>Left</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($previous_rop != $empty_content)
                                <tr>
                                    <td colspan="2" rowspan="{!! $rowspan_rop !!}"><span class="row-title">ROP</span></td>
                                </tr>
                                {!! $previous_rop !!}
                                @endif
                                @if ($previous_aabr_hearing_screening != $empty_content || $previous_oae_hearing_screening != $empty_content)
                                <tr>
                                    <td rowspan="{!! $rowspan_aabr_hearing_screening + $rowspan_oae_hearing_screening + 1 !!}" class=""><span class="row-title">Hearing screening</span></td>
                                </tr>
                                @if ($previous_aabr_hearing_screening != $empty_content)
                                <tr>
                                    <td rowspan="{!! $rowspan_aabr_hearing_screening !!}"><span class="row-title">(AABR)</span></td>
                                </tr>
                                {!! $previous_aabr_hearing_screening !!}
                                @endif
                                @if ($previous_oae_hearing_screening != $empty_content)
                                <tr>
                                    <td rowspan="{!! $rowspan_oae_hearing_screening !!}"><span class="row-title">(OAE)</span></td>
                                </tr>
                                {!! $previous_oae_hearing_screening !!}
                                @endif
                                @endif
                                @if ($previous_oae_hearing_assessment != $empty_content || $previous_audiometery_hearing_assessment != $empty_content)
                                <tr>
                                    <td rowspan="{!! $rowspan_oae_hearing_assessment + $rowspan_audiometery_hearing_assessment + 1 !!}" class=""><span class="row-title">Hearing Assessment</span></td>
                                </tr>
                                @if ($previous_oae_hearing_assessment != $empty_content)
                                <tr>
                                    <td rowspan="{!! $rowspan_oae_hearing_assessment !!}" class=""><span class="row-title">Diagnostic ABR</span></td>
                                </tr>    
                                {!! $previous_oae_hearing_assessment !!}
                                @endif
                                @if ($previous_audiometery_hearing_assessment != $empty_content)
                                <tr>
                                    <td rowspan="{!! $rowspan_audiometery_hearing_assessment !!}" class=""><span class="row-title">Conditioning Play Audiometery</span></td>
                                </tr>                                   
                                {!! $previous_audiometery_hearing_assessment !!}
                                @endif
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        @endif            
        @if ($previous_ct != $empty_content_1 || $previous_usg != $empty_content_1 || $previous_mri != $empty_content_1)
        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="content-block p-0" style="border: none !important;">
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                        <table class="table table-bordered scan">
                            <thead>
                                <tr>
                                    <th>Head Scan</th>
                                    <th>Date</th>
                                    <!-- <th>Age</th> -->
                                    <th>Impression</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($previous_ct != $empty_content_1)
                                <tr>
                                    <td rowspan="{!! $rowspan_ct !!}" class="">CT</td>
                                </tr>
                                {!! $previous_ct !!}
                                @endif
                                @if ($previous_usg != $empty_content_1)
                                <tr>
                                    <td rowspan="{!! $rowspan_usg !!}" class="">USG</td>
                                </tr>
                                {!! $previous_usg !!}
                                @endif
                                @if ($previous_mri != $empty_content_1)
                                <tr>
                                    <td rowspan="{!! $rowspan_mri !!}" class="">MRI</td>
                                </tr>
                                {!! $previous_mri !!}
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        @endif
        @php 
        $tone = ValuelistHelpers::toneoption();
        $other = ValuelistHelpers::otheroption();
        @endphp
        @if ($muscle_tone_norms_display_status || $tone[$results->tone_type] != 'N/A' || $results->others == 2)
        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="content-block pl-10-must">
                    <div class="col-md-12 col-sm-12 col-xs-12 overflow-auto-screen p-0">
                        <h5 class="m-0"><strong>Muscle tone:</strong> <span class="color-black">{!! $tone[$results->tone_type] != 'N/A' ? ' - ' . $tone[$results->tone_type] . '.' : '' !!}</span> <span class="color-black">{!! $other[$results->others] != 'N/A' ? $other[$results->others] . '.' : '' !!}</span></h5>
                        @if ($results->others == 2)
                        <p>{{ $results->others_asymmetric }}</p>
                        @endif
                        @if ($muscle_tone_norms_display_status)
                        <div class="col-md-12">
                          <p class="mt-5 mb-5"><b>Amiel Tison angle</b></p>
                          @if (strtotime($results->date_of_assessment_0_3))
                          <div class="col-md-12">
                              <ol>
                                  @if (!empty($results->adductor_as_assessed_right_0_3) || !empty($results->adductor_as_assessed_left_0_3)) 
                                  <li>
                                      Adductor angle -
                                      @if (!empty($results->adductor_as_assessed_right_0_3))
                                      Right {!! $results->adductor_as_assessed_right_0_3 !!}°
                                      @endif
                                      @if (!empty($results->adductor_as_assessed_left_0_3))
                                      @if (!empty($results->adductor_as_assessed_right_0_3))
                                      / 
                                      @endif
                                      Left {!! $results->adductor_as_assessed_left_0_3 !!}°
                                      @endif
                                  </li>
                                  @endif
                                  @if (!empty($results->popliteal_as_assessed_right_0_3) || !empty($results->dorsiflexion_as_assessed_left_0_3)) 
                                  <li>
                                      Popliteal angle -
                                      @if (!empty($results->popliteal_as_assessed_right_0_3))
                                      Right {!! $results->popliteal_as_assessed_right_0_3 !!}°
                                      @endif
                                      @if (!empty($results->dorsiflexion_as_assessed_left_0_3))
                                      @if (!empty($results->popliteal_as_assessed_right_0_3))
                                      / 
                                      @endif
                                      Left {!! $results->dorsiflexion_as_assessed_left_0_3 !!}°
                                      @endif
                                  </li>
                                  @endif
                                  @if (!empty($results->dorsiflexion_as_assessed_right_0_3) || !empty($results->dorsiflexion_as_assessed_left_0_3)) 
                                  <li>
                                      Dorsiflexion angle -
                                      @if (!empty($results->dorsiflexion_as_assessed_right_0_3))
                                      Right {!! $results->dorsiflexion_as_assessed_right_0_3 !!}°
                                      @endif
                                      @if (!empty($results->dorsiflexion_as_assessed_left_0_3))
                                      @if (!empty($results->dorsiflexion_as_assessed_right_0_3))
                                      / 
                                      @endif
                                      Left {!! $results->dorsiflexion_as_assessed_left_0_3 !!}°
                                      @endif
                                  </li>
                                  @endif
                              </ol>
                          </div>
                          @endif
                          @if (strtotime($results->date_of_assessment_4_6))
                          <div class="col-md-12">
                              <ol>
                                  @if (!empty($results->adductor_as_assessed_right_4_6) || !empty($results->adductor_as_assessed_left_4_6)) 
                                  <li>
                                      Adductor angle - 
                                      @if (!empty($results->adductor_as_assessed_right_4_6))
                                      Right {!! $results->adductor_as_assessed_right_4_6 !!}°
                                      @endif
                                      @if (!empty($results->adductor_as_assessed_left_4_6))
                                      @if (!empty($results->adductor_as_assessed_right_4_6))
                                      / 
                                      @endif
                                      Left {!! $results->adductor_as_assessed_left_4_6 !!}°
                                      @endif
                                  </li>
                                  @endif
                                  @if (!empty($results->popliteal_as_assessed_right_4_6) || !empty($results->popliteal_as_assessed_left_4_6)) 
                                  <li>
                                      Popliteal angle - 
                                      @if (!empty($results->popliteal_as_assessed_right_4_6))
                                      Right {!! $results->popliteal_as_assessed_right_4_6 !!}°
                                      @endif
                                      @if (!empty($results->popliteal_as_assessed_left_4_6))
                                      @if (!empty($results->popliteal_as_assessed_right_4_6))
                                      / 
                                      @endif
                                      Left {!! $results->popliteal_as_assessed_left_4_6 !!}°
                                      @endif
                                  </li>
                                  @endif
                                  @if (!empty($results->dorsiflexion_as_assessed_right_4_6) || !empty($results->dorsiflexion_as_assessed_left_4_6)) 
                                  <li>
                                      Dorsiflexion angle - 
                                      @if (!empty($results->dorsiflexion_as_assessed_right_4_6))
                                      Right {!! $results->dorsiflexion_as_assessed_right_4_6 !!}°
                                      @endif
                                      @if (!empty($results->dorsiflexion_as_assessed_left_4_6))
                                      @if (!empty($results->dorsiflexion_as_assessed_right_4_6))
                                      / 
                                      @endif
                                      Left {!! $results->dorsiflexion_as_assessed_left_4_6 !!}°
                                      @endif
                                  </li>
                                  @endif
                              </ol>
                          </div>
                          @endif
                          @if (strtotime($results->date_of_assessment_7_9))
                          <div class="col-md-12">
                              <ol>
                                  @if (!empty($results->adductor_as_assessed_right_7_9) || !empty($results->adductor_as_assessed_left_7_9)) 
                                  <li>
                                      Adductor angle - 
                                      @if (!empty($results->adductor_as_assessed_right_7_9))
                                      Right {!! $results->adductor_as_assessed_right_7_9 !!}°
                                      @endif
                                      @if (!empty($results->adductor_as_assessed_left_7_9))
                                      @if (!empty($results->adductor_as_assessed_right_7_9))
                                      / 
                                      @endif
                                      Left {!! $results->adductor_as_assessed_left_7_9 !!}°
                                      @endif
                                  </li>
                                  @endif
                                  @if (!empty($results->popliteal_as_assessed_right_7_9) || !empty($results->popliteal_as_assessed_left_7_9)) 
                                  <li>
                                      Popliteal angle - 
                                      @if (!empty($results->popliteal_as_assessed_right_7_9))
                                      Right {!! $results->popliteal_as_assessed_right_7_9 !!}°
                                      @endif
                                      @if (!empty($results->popliteal_as_assessed_left_7_9))
                                      @if (!empty($results->popliteal_as_assessed_right_7_9))
                                      / 
                                      @endif
                                      Left {!! $results->popliteal_as_assessed_left_7_9 !!}°
                                      @endif
                                  </li>
                                  @endif
                                  @if (!empty($results->dorsiflexion_as_assessed_right_7_9) || !empty($results->dorsiflexion_as_assessed_left_7_9)) 
                                  <li>
                                      Dorsiflexion angle - 
                                      @if (!empty($results->dorsiflexion_as_assessed_right_7_9))
                                      Right {!! $results->dorsiflexion_as_assessed_right_7_9 !!}°
                                      @endif
                                      @if (!empty($results->dorsiflexion_as_assessed_left_7_9))
                                      @if (!empty($results->dorsiflexion_as_assessed_right_7_9))
                                      / 
                                      @endif
                                      Left {!! $results->dorsiflexion_as_assessed_left_7_9 !!}°
                                      @endif
                                  </li>
                                  @endif
                              </ol>
                          </div>
                          @endif
                          @if (strtotime($results->date_of_assessment_10_12))
                          <div class="col-md-12">
                              <ol>
                                  @if (!empty($results->adductor_as_assessed_right_10_12) || !empty($results->adductor_as_assessed_left_10_12)) 
                                  <li>
                                      Adductor angle - 
                                      @if (!empty($results->adductor_as_assessed_right_10_12))
                                      Right {!! $results->adductor_as_assessed_right_10_12 !!}°
                                      @endif
                                      @if (!empty($results->adductor_as_assessed_left_10_12))
                                      @if (!empty($results->adductor_as_assessed_right_10_12))
                                      / 
                                      @endif
                                      Left {!! $results->adductor_as_assessed_left_10_12 !!}°
                                      @endif
                                  </li>
                                  @endif
                                  @if (!empty($results->popliteal_as_assessed_right_10_12) || !empty($results->popliteal_as_assessed_left_10_12)) 
                                  <li>
                                      Popliteal angle - 
                                      @if (!empty($results->popliteal_as_assessed_right_10_12))
                                      Right {!! $results->popliteal_as_assessed_right_10_12 !!}°
                                      @endif
                                      @if (!empty($results->popliteal_as_assessed_left_10_12))
                                      @if (!empty($results->popliteal_as_assessed_right_10_12))
                                      / 
                                      @endif
                                      Left {!! $results->popliteal_as_assessed_left_10_12 !!}°
                                      @endif
                                  </li>
                                  @endif
                                  @if (!empty($results->dorsiflexion_as_assessed_right_10_12) || !empty($results->dorsiflexion_as_assessed_left_10_12)) 
                                  <li>
                                      Dorsiflexion angle - 
                                      @if (!empty($results->dorsiflexion_as_assessed_right_10_12))
                                      Right {!! $results->dorsiflexion_as_assessed_right_10_12 !!}°
                                      @endif
                                      @if (!empty($results->dorsiflexion_as_assessed_left_10_12))
                                      @if (!empty($results->dorsiflexion_as_assessed_right_10_12))
                                      / 
                                      @endif
                                      Left {!! $results->dorsiflexion_as_assessed_left_10_12 !!}°
                                      @endif
                                  </li>
                                  @endif
                              </ol>
                          </div>
                          @endif
                      </div>
                      <div class="col-md-12">
                          <p class="mt-0 mb-5"><b>Scarf sign (tick)</b></p>
                          @php $scarf_sign_1 = 'Elbow does not cross midline'; @endphp
                          @php $scarf_sign_2 = 'Elbow crosses midline'; @endphp
                          @php $scarf_sign_3 = 'Elbow goes beyond axillary line'; @endphp
                          @if (strtotime($results->date_of_assessment_0_3))
                          <div class="col-md-12">
                              <ol>
                                  @if (@$results->elbow_not_cross_midline_left_0_3 || @$results->elbow_not_cross_midline_right_0_3)
                                  <li>
                                      @if (@$results->elbow_not_cross_midline_left_0_3 && @$results->elbow_not_cross_midline_right_0_3)
                                      Left & Right - {!! $scarf_sign_1 !!}
                                      @elseif (@$results->elbow_not_cross_midline_left_0_3)
                                      Right - {!! $scarf_sign_1 !!}
                                      @elseif (@$results->elbow_not_cross_midline_right_0_3)
                                      Left - {!! $scarf_sign_1 !!}
                                      @endif
                                  </li>
                                  @endif
                                  @if (@$results->elbow_cross_midline_left_0_3 || @$results->elbow_cross_midline_right_0_3)
                                  <li>
                                      @if (@$results->elbow_cross_midline_left_0_3 && @$results->elbow_cross_midline_right_0_3)
                                      Left & Right - {!! $scarf_sign_2 !!}
                                      @elseif (@$results->elbow_cross_midline_left_0_3)
                                      Right - {!! $scarf_sign_2 !!}
                                      @elseif (@$results->elbow_cross_midline_right_0_3)
                                      Left - {!! $scarf_sign_2 !!}
                                      @endif
                                  </li>
                                  @endif
                                  @if (@$results->elbow_goes_beyond_axillary_line_left_0_3 || @$results->elbow_goes_beyond_axillary_line_right_0_3)
                                  <li>
                                      @if (@$results->elbow_goes_beyond_axillary_line_left_0_3 && @$results->elbow_goes_beyond_axillary_line_right_0_3)
                                      Left & Right - {!! $scarf_sign_3 !!}
                                      @elseif (@$results->elbow_goes_beyond_axillary_line_left_0_3)
                                      Right - {!! $scarf_sign_3 !!}
                                      @elseif (@$results->elbow_goes_beyond_axillary_line_right_0_3)
                                      Left - {!! $scarf_sign_3 !!}
                                      @endif
                                  </li>
                                  @endif
                              </ol>
                          </div>
                          @endif
                          @if (strtotime($results->date_of_assessment_4_6))
                          <div class="col-md-12">
                              <ol>
                                  @if ($results->elbow_not_cross_midline_left_4_6 || $results->elbow_not_cross_midline_right_4_6)
                                  <li>
                                      @if ($results->elbow_not_cross_midline_left_4_6 && $results->elbow_not_cross_midline_right_4_6)
                                      Left & Right - {!! $scarf_sign_1 !!}
                                      @elseif ($results->elbow_not_cross_midline_left_4_6)
                                      Right - {!! $scarf_sign_1 !!}
                                      @elseif ($results->elbow_not_cross_midline_right_4_6)
                                      Left - {!! $scarf_sign_1 !!}
                                      @endif
                                  </li>
                                  @endif
                                  @if ($results->elbow_cross_midline_left_4_6 || $results->elbow_cross_midline_right_4_6)
                                  <li>
                                      @if ($results->elbow_cross_midline_left_4_6 && $results->elbow_cross_midline_right_4_6)
                                      Left & Right - {!! $scarf_sign_2 !!}
                                      @elseif ($results->elbow_cross_midline_left_4_6)
                                      Right - {!! $scarf_sign_2 !!}
                                      @elseif ($results->elbow_cross_midline_right_4_6)
                                      Left - {!! $scarf_sign_2 !!}
                                      @endif
                                  </li>
                                  @endif
                                  @if ($results->elbow_goes_beyond_axillary_line_left_4_6 || $results->elbow_goes_beyond_axillary_line_right_4_6)
                                  <li>
                                      @if ($results->elbow_goes_beyond_axillary_line_left_4_6 && $results->elbow_goes_beyond_axillary_line_right_4_6)
                                      Left & Right - {!! $scarf_sign_3 !!}
                                      @elseif ($results->elbow_goes_beyond_axillary_line_left_4_6)
                                      Right - {!! $scarf_sign_3 !!}
                                      @elseif ($results->elbow_goes_beyond_axillary_line_right_4_6)
                                      Left - {!! $scarf_sign_3 !!}
                                      @endif
                                  </li>
                                  @endif
                              </ol>
                          </div>
                          @endif
                          @if (strtotime($results->date_of_assessment_7_9))
                          <div class="col-md-12">
                              <ol>
                                  @if (@$results->elbow_not_cross_midline_left_7_9 || @$results->elbow_not_cross_midline_right_7_9)
                                  <li>
                                      @if (@$results->elbow_not_cross_midline_left_7_9 && @$results->elbow_not_cross_midline_right_7_9)
                                      Left & Right - {!! $scarf_sign_1 !!}
                                      @elseif (@$results->elbow_not_cross_midline_left_7_9)
                                      Right - {!! $scarf_sign_1 !!}
                                      @elseif (@$results->elbow_not_cross_midline_right_7_9)
                                      Left - {!! $scarf_sign_1 !!}
                                      @endif
                                  </li>
                                  @endif
                                  @if (@$results->elbow_cross_midline_left_7_9 || @$results->elbow_cross_midline_right_7_9)
                                  <li>
                                      @if (@$results->elbow_cross_midline_left_7_9 && @$results->elbow_cross_midline_right_7_9)
                                      Left & Right - {!! $scarf_sign_2 !!}
                                      @elseif (@$results->elbow_cross_midline_left_7_9)
                                      Right - {!! $scarf_sign_2 !!}
                                      @elseif (@$results->elbow_cross_midline_right_7_9)
                                      Left - {!! $scarf_sign_2 !!}
                                      @endif
                                  </li>
                                  @endif
                                  @if (@$results->elbow_goes_beyond_axillary_line_left_7_9 || @$results->elbow_goes_beyond_axillary_line_right_7_9)
                                  <li>
                                      @if (@$results->elbow_goes_beyond_axillary_line_left_7_9 && @$results->elbow_goes_beyond_axillary_line_right_7_9)
                                      Left & Right - {!! $scarf_sign_3 !!}
                                      @elseif (@$results->elbow_goes_beyond_axillary_line_left_7_9)
                                      Right - {!! $scarf_sign_3 !!}
                                      @elseif (@$results->elbow_goes_beyond_axillary_line_right_7_9)
                                      Left - {!! $scarf_sign_3 !!}
                                      @endif
                                  </li>
                                  @endif
                              </ol>
                          </div>
                          @endif
                          @if (strtotime($results->date_of_assessment_10_12))
                          <div class="col-md-12">
                              <ol>
                                  @if ($results->elbow_not_cross_midline_left_10_12 || $results->elbow_not_cross_midline_right_10_12)
                                  <li>
                                      @if ($results->elbow_not_cross_midline_left_10_12 && $results->elbow_not_cross_midline_right_10_12)
                                      Left & Right - {!! $scarf_sign_1 !!}
                                      @elseif ($results->elbow_not_cross_midline_left_10_12)
                                      Right - {!! $scarf_sign_1 !!}
                                      @elseif ($results->elbow_not_cross_midline_right_10_12)
                                      Left - {!! $scarf_sign_1 !!}
                                      @endif
                                  </li>
                                  @endif
                                  @if ($results->elbow_cross_midline_left_10_12 || $results->elbow_cross_midline_right_10_12)
                                  <li>
                                      @if ($results->elbow_cross_midline_left_10_12 && $results->elbow_cross_midline_right_10_12)
                                      Left & Right - {!! $scarf_sign_2 !!}
                                      @elseif ($results->elbow_cross_midline_left_10_12)
                                      Right - {!! $scarf_sign_2 !!}
                                      @elseif ($results->elbow_cross_midline_right_10_12)
                                      Left - {!! $scarf_sign_2 !!}
                                      @endif
                                  </li>
                                  @endif
                                  @if ($results->elbow_goes_beyond_axillary_line_left_10_12 || $results->elbow_goes_beyond_axillary_line_right_10_12)
                                  <li>
                                      @if ($results->elbow_goes_beyond_axillary_line_left_10_12 && $results->elbow_goes_beyond_axillary_line_right_10_12)
                                      Left & Right - {!! $scarf_sign_3 !!}
                                      @elseif ($results->elbow_goes_beyond_axillary_line_left_10_12)
                                      Right - {!! $scarf_sign_3 !!}
                                      @elseif ($results->elbow_goes_beyond_axillary_line_right_10_12)
                                      Left - {!! $scarf_sign_3 !!}
                                      @endif
                                  </li>
                                  @endif
                              </ol>
                          </div>
                          @endif
                      </div>
                      @endif
                  </div>
              </div>
          </div>
      </div>
      <div class="clearfix"></div>
      @endif
      @php $dasii = false; @endphp
      @if (!empty($results->mental_development_age) || !empty($results->mental_development_quotient) || !empty($results->motor_development_age) || !empty($results->motor_development_quotient) || !empty($results->clusters) || !empty($results->interpretation))
      @php $dasii = true; @endphp
      @endif
      @php $screening_count = 0; @endphp
      @if ((is_object($hnne) && $hnne->total_hnne_score != 0))
      @php $screening_count++; @endphp
      @endif
      @if ((is_object($hine) && $hine->total_hine_score != 0))
      @php $screening_count++; @endphp
      @endif
      @if (isset($m_chat_score))
      @php $screening_count++; @endphp
      @endif
      @if ($dasii)
      @php $screening_count++; @endphp
      @endif
      @if ($results->ddst_interpretation_status != null)
      @php $screening_count++; @endphp
      @endif
      @if (count(@$bayley_result) > 0)
      @php $screening_count++; @endphp
      @endif

      @if ((is_object($hnne) && $hnne->total_hnne_score != 0) || (is_object($hine) && $hine->total_hine_score != 0) || isset($m_chat_score) || $dasii || $results->ddst_interpretation_status != null || count(@$bayley_result) > 0 || (isset($issa_result->id) && $issa_result->total > 0) || (isset($cars_result->id) && $cars_result->total > 0))
      <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="content-block pl-10-must">
                <h5 class="mt-0 mb-5"> 
                    <strong>Test done:</strong>
                </h5>
                <div class="col-md-12 col-sm-12 col-xs-12 pl-10">
                    <ol class="@if ($screening_count == 1) list-none pl-0 @endif">
                        @if (is_object($hnne) && $hnne->total_hnne_score != 0)
                        <li>Hammersmith Neonatal Neurological Examination <b>(HNNE)</b></li>
                        @endif
                        @if (is_object($hine) && $hine->total_hine_score != 0)
                        <li>Hammersmith Infant Neurological Examination <b>(HINE)</b></li>
                        @endif
                        @if (isset($m_chat_score))
                        <li>Modified Checklist for Autism in Toddlers, Revised with Follow-Up <b>(M-CHAT-R)</b></li>
                        @endif
                        @if ($dasii)
                        <li>Developmental assessment scales for Indian infants <b>(DASII)</b></li>
                        @endif
                        @if ($results->ddst_interpretation_status != null)
                        <li>Denver Developmental Screening Test <b>(DDST II)</b></li>
                        @endif
                        @if (count($cbcl_result) > 0)
                        <li>Child Behavior Checklist <b>(CBCL)</b></li>
                        @endif
                        @if (count(@$bayley_result) > 0 && !empty(@$bayley_result->cg) && !empty(@$bayley_result->rc) && !empty(@$bayley_result->ec) && !empty(@$bayley_result->fm) && !empty(@$bayley_result->gm))
                        <li>
                            <p>Bayley Scales of Infant and Toddler Development<sup>TM</sup>, Fourth Edition (Bayley<sup>TM</sup>-4)</p>
                            <p>Cognitive, Language, and Motor Scales Score Report</p>
                        </li>
                        @endif
                        @if (isset($issa_result->id) && $issa_result->total > 0)
                        <li>Indian scale for Assessment of Autism <b>(ISSA)</b></li>
                        @endif
                        @if (isset($cars_result->id) && $cars_result->total > 0)
                        <li>Childhood Autism Rating Scale <b>(CARS)</b></li>
                        @endif
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="clearfix"></div>
    @if (!empty(trim(strip_tags($results->baby_behavior))))
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="content-block pl-10-must">
                <h5 class="m-0"> <strong>Behavior during assessment:</strong></h5>
                <div class="pl-15 ptb-5 m-0">{!! $results->baby_behavior !!}</div>
            </div>
        </div>
    </div>
    <!-- <div class="clearfix"></div> -->
    @endif
    @if ((is_object($hnne) && $hnne->total_hnne_score != 0) || (is_object($hine) && $hine->total_hine_score != 0) || (isset($m_chat_score) || isset($m_chat_f_score)) || (isset($m_chat_f_score) && isset($m_chat_score) && $m_chat_score >= 3 && $m_chat_score <= 7) || $dasii || $results->ddst_interpretation_status != null || count($cbcl_result) > 0 || count(@$bayley_result) > 0 || (isset($issa_result->id) && $issa_result->total > 0) || (isset($cars_result->id) && $cars_result->total > 0) || (isset($cc_current_infant_result->infants_personal_social) && !empty($cc_current_infant_result->infants_personal_social)) || (isset($cc_previous_infant_result->infants_personal_social) && !empty($cc_previous_infant_result->infants_personal_social)) || (isset($cc_current_preschoolers_result->preschoolers_personal_social) && !empty($cc_current_preschoolers_result->preschoolers_personal_social)) || (isset($cc_previous_preschoolers_result->preschoolers_personal_social) && !empty($cc_previous_preschoolers_result->preschoolers_personal_social)))
        @php $test_count = 1; @endphp
        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="content-block pl-10-must">
                    <h5 class="mt-0 mb-5"> <strong>Test findings:</strong></h5>
                    @if (is_object($hnne) && $hnne->total_hnne_score != 0)
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h5 class="m-0"><strong>@if ($screening_count > 1) {{$test_count}}. @endif HNNE</strong></h5>
                        <table>
                            <tr>
                                <td class="p-must-0">1. Posture</td>
                                <td class="p-must-0"><span>&nbsp- {{@$hnne->posture}} / {{$posture_overall_score}}</span></td>
                            </tr>
                            <tr>
                                <td class="p-must-0">2. Tone pattern items</td>
                                <td class="p-must-0"><span>&nbsp- {{@$hnne->tone_pattern_items}} / {{$tone_pattern_items_overall_score}}</span></td>
                            </tr>
                            <tr>
                                <td class="p-must-0">3. Reflex items</td>
                                <td class="p-must-0"><span>&nbsp- {{@$hnne->reflex_items}} / {{$reflex_items_overall_score}}</span></td>
                            </tr>
                            <tr>
                                <td class="p-must-0">4. Movements</td>
                                <td class="p-must-0"><span>&nbsp- {{@$hnne->movements}} / {{$movements_overall_score}}</span></td>
                            </tr>
                            <tr>
                                <td class="p-must-0">5. Abnormal signs</td>
                                <td class="p-must-0"><span>&nbsp- {{@$hnne->abnormal_signs}} / {{$abnormal_signs_overall_score}}</span></td>
                            </tr>
                            <tr>
                                <td class="p-must-0">6. Behavioural signs, vision, hearing</td>
                                <td class="p-must-0"><span>&nbsp- {{@$hnne->behavioural_signs}} / {{$behavioural_signs_overall_score}}</span></td>
                            </tr>
                            <tr>
                                <td class="p-must-0 pull-right"><b>Total</b></td>
                                <td class="p-must-0"><span><b>&nbsp= {{explode('-', @$hnne->total_hnne_score)[0]}} / {{$hnne_total_score}}</b></span></td>
                            </tr>
                        </table>
                    </div>
                    @php $test_count++; @endphp
                    @endif
                    @if (is_object($hine) && $hine->total_hine_score != 0)
                    @php $hine_total_score = ''; @endphp
                    @if ($results->g_weeks <= 32) 
                    @if ($results->corrected_month < 4) 
                    @php $hine_total_score = '(51 - 67)'; @endphp
                    @elseif ($results->corrected_month >= 4 && $results->corrected_month < 7) 
                    @php $hine_total_score = '(52 - 71)'; @endphp
                    @elseif ($results->corrected_month >= 7 && $results->corrected_month < 10) 
                    @php $hine_total_score = '(57 - 76)'; @endphp
                    @elseif ($results->corrected_month >= 10) 
                    @php $hine_total_score = '(60 - 77)'; @endphp
                    @endif
                    @elseif ($results->g_weeks > 32 && $results->g_weeks <= 36) 
                    @if ($results->corrected_month < 4) 
                    @php $hine_total_score = '(57 - 69)'; @endphp
                    @elseif ($results->corrected_month >= 4 && $results->corrected_month < 7) 
                    @php $hine_total_score = '(60 - 72)'; @endphp
                    @elseif ($results->corrected_month >= 7 && $results->corrected_month < 10) 
                    @php $hine_total_score = '(63 - 75)'; @endphp
                    @elseif ($results->corrected_month >= 10) 
                    @php $hine_total_score = '(64 - 77)'; @endphp
                    @endif
                    @elseif ($results->g_weeks > 36) 
                    @if ($results->corrected_month < 4) 
                    @php $hine_total_score = '(62 - 69)'; @endphp
                    @elseif ($results->corrected_month >= 4 && $results->corrected_month < 7) 
                    @php $hine_total_score = '(64 - 74)'; @endphp
                    @elseif ($results->corrected_month >= 7 && $results->corrected_month < 10) 
                    @php $hine_total_score = '(65 - 78)'; @endphp
                    @elseif ($results->corrected_month >= 10) 
                    @php $hine_total_score = '(65 - 78)'; @endphp
                    @endif
                    @endif
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h5 class="mt-0 mb-5"><strong>@if ($screening_count > 1) {{$test_count}}. @endif HINE</strong></h5>
                        <table>
                            <tr>
                                <td class="p-must-0">1. Assessment of cranial nerve function</td>
                                <td class="p-must-0"><span>&nbsp- {{@$hine->assessment_of_cranial}} / {{$assessment_of_cranial_overall_score}}</span></td>
                            </tr>
                            <tr>
                                <td class="p-must-0">2. Assessment of posturen</td>
                                <td class="p-must-0"><span>&nbsp- {{@$hine->assessment_of_posture}} / {{$assessment_of_posture_overall_score}}</span></td>
                            </tr>
                            <tr>
                                <td class="p-must-0">3. Assessment of movements</td>
                                <td class="p-must-0"><span>&nbsp- {{@$hine->assessment_of_movements}} / {{$assessment_of_movements_overall_score}}</span></td>
                            </tr>
                            <tr>
                                <td class="p-must-0">4. Assessment of tone</td>
                                <td class="p-must-0"><span>&nbsp- {{@$hine->assessment_of_tone}} / {{$assessment_of_tone_overall_score}}</span></td>
                            </tr>
                            <tr>
                                <td class="p-must-0">5. Reflexes and reactions</td>
                                <td class="p-must-0"><span>&nbsp- {{@$hine->reflexes_and_reactions}} / {{$reflexes_and_reactions_overall_score}}</span></td>
                            </tr>
                            <tr>
                                <td class="p-must-0 pull-right"><b>Total</b></td>
                                <td class="p-must-0"><span><b>&nbsp= {{explode('-', @$hine->total_hine_score)[0]}} / {{$hine_total_score}}</b></span></td>
                            </tr>
                        </table>
                    </div>
                    @php $test_count++; @endphp
                    @endif
                    @if (isset($m_chat_score) || isset($m_chat_f_score))
                    @if (isset($m_chat_score))
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h5 class="mt-0 mb-5">
                            <strong>@if ($screening_count > 1) {{$test_count}}. @endif M-CHAT (R)</strong>
                            @if ($m_chat_score < 3)
                            <span class="font-size-12">- {{$m_chat_score}}</span>
                            @elseif ($m_chat_score >= 3 && $m_chat_score <= 7)
                            <span class="font-size-12">- {{$m_chat_score}}</span>
                            @else
                            <span class="font-size-12">- {{$m_chat_score}} </span>
                            @endif
                        </h5>
                    </div>
                    @endif
                    @if (isset($m_chat_f_score) && isset($m_chat_score) && $m_chat_score >= 3 && $m_chat_score <= 7)
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h5 class="mt-0 mb-5">
                            <strong>@if ($screening_count > 1) {{$test_count}}. @endif M-CHAT-R/F</strong>
                            @if ($m_chat_f_score > 1)
                            <small>- {{$m_chat_f_score}}</small>                                              
                            @else
                            <small>- {{$m_chat_f_score}}</small>                                               
                            @endif
                        </h5>
                    </div>
                    @endif
                    @php $test_count++; @endphp
                    @endif
                    @if ($dasii)
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h5 class="mt-0"><strong>@if ($screening_count > 1) {{$test_count}}. @endif DASII</strong></h5>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <ol>
                                <li><b>Mental Development</b></li>
                                @php $mental_quotient_total_score = ''; @endphp
                                @if (isset($results->mental_development_quotient) && !empty($results->mental_development_quotient))
                                @if ($results->mental_development_quotient < 70) 
                                @php $mental_quotient_total_score = '[Delay (< 70)]'; @endphp
                                @elseif ($results->mental_development_quotient >= 70 && $results->mental_development_quotient < 85) 
                                @php $mental_quotient_total_score = '[Below Average (70 - 85)]'; @endphp
                                @elseif ($results->mental_development_quotient >= 85 && $results->mental_development_quotient < 115) 
                                @php $mental_quotient_total_score = '[Average (85 - 115)]'; @endphp
                                @else
                                @php $motor_quotient_total_score = '[Above average]'; @endphp
                                @endif
                                @endif
                                <p>
                                    <ul>
                                        <li>Age - {{ isset($results->mental_development_age) && !empty($results->mental_development_age) ? $results->mental_development_age : '-'}}</li>
                                        <li>Quotient - {{ isset($results->mental_development_quotient) && !empty($results->mental_development_quotient) ? $results->mental_development_quotient : '-'}} {{$mental_quotient_total_score}}</li>
                                    </ul>
                                </p>
                                <li><b>Motor Development</b></li>
                                @php $motor_quotient_total_score = ''; @endphp
                                @if (isset($results->motor_development_quotient) && !empty($results->motor_development_quotient))
                                @if ($results->motor_development_quotient < 70) 
                                @php $motor_quotient_total_score = '[Delay (< 70)]'; @endphp
                                @elseif ($results->motor_development_quotient >= 70 && $results->motor_development_quotient < 85) 
                                @php $motor_quotient_total_score = '[Below Average (70 - 85)]'; @endphp
                                @elseif ($results->motor_development_quotient >= 85 && $results->motor_development_quotient < 115) 
                                @php $motor_quotient_total_score = '[Average (85 - 115)]'; @endphp
                                @else
                                @php $motor_quotient_total_score = '[Above average]'; @endphp
                                @endif
                                @endif
                                <p>
                                    <ul>
                                        <li>Age - {{ isset($results->motor_development_age) && !empty($results->motor_development_age) ? $results->motor_development_age : '-'}}</li>
                                        <li>Quotient - {{ isset($results->motor_development_quotient) && !empty($results->motor_development_quotient) ? $results->motor_development_quotient : '-'}} {{$motor_quotient_total_score}}</li>
                                    </ul>
                                </p>
                                <li><b>Clusters</b></li>
                                <table class="table table-bordered mt-5" id="clusters">
                                    <thead>
                                        <tr>
                                            <th>Cluster No.</th>
                                            <th>Mental clusters and no. of items</th>
                                            <th>Items Passed</th>
                                            <th>PR</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>I</td>
                                            <td>Cognizance - Visual (25)</td>
                                            <td>{{ $results->mental_cluster_1 }}</td>
                                            <td>{!! $results->mental_cluster_pr_1 !!}</td>
                                            <td>{{ $results->mental_cluster_remarks_1 }}</td>
                                        </tr>
                                        <tr>
                                            <td>II</td>
                                            <td>Cognizance - Auditory (7)</td>
                                            <td>{{ $results->mental_cluster_2 }}</td>
                                            <td>{!! $results->mental_cluster_pr_2 !!}</td>
                                            <td>{{ $results->mental_cluster_remarks_2 }}</td>
                                        </tr>
                                        <tr>
                                            <td>III</td>
                                            <td>Reaching, manipulating and exploring (36)</td>
                                            <td>{{ $results->mental_cluster_3 }}</td>
                                            <td>{!! $results->mental_cluster_pr_3 !!}</td>
                                            <td>{{ $results->mental_cluster_remarks_3 }}</td>
                                        </tr>
                                        <tr>
                                            <td>IV</td>
                                            <td>Memory (11)</td>
                                            <td>{{ $results->mental_cluster_4 }}</td>
                                            <td>{!! $results->mental_cluster_pr_4 !!}</td>
                                            <td>{{ $results->mental_cluster_remarks_4 }}</td>
                                        </tr>
                                        <tr>
                                            <td>V</td>
                                            <td>Social interaction and imitalive behaviour (22)</td>
                                            <td>{{ $results->mental_cluster_5 }}</td>
                                            <td>{!! $results->mental_cluster_pr_5 !!}</td>
                                            <td>{{ $results->mental_cluster_remarks_5 }}</td>
                                        </tr>
                                        <tr>
                                            <td>VI</td>
                                            <td>Language - Vocalisation, speech and communication (11)</td>
                                            <td>{{ $results->mental_cluster_6 }}</td>
                                            <td>{!! $results->mental_cluster_pr_6 !!}</td>
                                            <td>{{ $results->mental_cluster_remarks_6 }}</td>
                                        </tr>
                                        <tr>
                                            <td>VII</td>
                                            <td>Language - Vocabulary and comprehension (18)</td>
                                            <td>{{ $results->mental_cluster_7 }}</td>
                                            <td>{!! $results->mental_cluster_pr_7 !!}</td>
                                            <td>{{ $results->mental_cluster_remarks_7 }}</td>
                                        </tr>
                                        <tr>
                                            <td>VIII</td>
                                            <td>Understanding relationship (18)</td>
                                            <td>{{ $results->mental_cluster_8 }}</td>
                                            <td>{!! $results->mental_cluster_pr_8 !!}</td>
                                            <td>{{ $results->mental_cluster_remarks_8 }}</td>
                                        </tr>
                                        <tr>
                                            <td>IX</td>
                                            <td>Differentiation by use, shapes and movements (8)</td>
                                            <td>{{ $results->mental_cluster_9 }}</td>
                                            <td>{!! $results->mental_cluster_pr_9 !!}</td>
                                            <td>{{ $results->mental_cluster_remarks_9 }}</td>
                                        </tr>
                                        <tr>
                                            <td>X</td>
                                            <td>Manual dexterity (7)</td>
                                            <td>{{ $results->mental_cluster_10 }}</td>
                                            <td>{!! $results->mental_cluster_pr_10 !!}</td>
                                            <td>{{ $results->mental_cluster_remarks_10 }}</td>
                                        </tr>
                                    </tbody>
                                    <thead>
                                        <tr>
                                            <th colspan="5"></th>
                                        </tr>
                                        <tr>
                                            <th>Cluster No.</th>
                                            <th>Motor clusters and no. of items</th>
                                            <th>Items Passed</th>
                                            <th>PR</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>I</td>
                                            <td>Neck control (7)</td>
                                            <td>{{ $results->motor_cluster_1 }}</td>
                                            <td>{!! $results->motor_cluster_pr_1 !!}</td>
                                            <td>{{ $results->motor_cluster_remarks_1 }}</td>
                                        </tr>
                                        <tr>
                                            <td>II</td>
                                            <td>Body control (23)</td>
                                            <td>{{ $results->motor_cluster_2 }}</td>
                                            <td>{!! $results->motor_cluster_pr_2 !!}</td>
                                            <td>{{ $results->motor_cluster_remarks_2 }}</td>
                                        </tr>
                                        <tr>
                                            <td>III</td>
                                            <td>Locomotion - I (10)</td>
                                            <td>{{ $results->motor_cluster_3 }}</td>
                                            <td>{!! $results->motor_cluster_pr_3 !!}</td>
                                            <td>{{ $results->motor_cluster_remarks_3 }}</td>
                                        </tr>
                                        <tr>
                                            <td>IV</td>
                                            <td>Locomotion - II (13)</td>
                                            <td>{{ $results->motor_cluster_4 }}</td>
                                            <td>{!! $results->motor_cluster_pr_4 !!}</td>
                                            <td>{{ $results->motor_cluster_remarks_4 }}</td>
                                        </tr>
                                        <tr>
                                            <td>V</td>
                                            <td>Manipulation (14)</td>
                                            <td>{{ $results->motor_cluster_5 }}</td>
                                            <td>{!! $results->motor_cluster_pr_5 !!}</td>
                                            <td>{{ $results->motor_cluster_remarks_5 }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </ol>
                        </div>
                    </div>
                    @php $test_count++; @endphp
                    @endif
                    @if ($results->ddst_interpretation_status != null)
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h5 class="mt-0"><strong>@if ($screening_count > 1) {{$test_count}}. @endif DDST II</strong> - <span class="font-size-12">{{$ddst_interpretation_result[$results->ddst_interpretation_status]}}</span></h5>
                        <ol class="pl-25">
                            <li><b>GROSS MOTOR</b> - {{ @$ddst_interpretation_result[$results->ddst_gross_motor_interpretation_status] }}</li>
                            <li><b>LANGUAGE</b> - {{ @$ddst_interpretation_result[$results->ddst_language_interpretation_status] }}</li>
                            <li><b>FINE MOTOR - ADAPTIVE</b> - {{ @$ddst_interpretation_result[$results->ddst_fine_motor_interpretation_status] }}</li>
                            <li><b>PERSONAL - SOCIAL</b> - {{ @$ddst_interpretation_result[$results->ddst_personal_interpretation_status] }}</li>
                        </ol>
                    </div>
                    @php $test_count++; @endphp
                    @endif
                    @if (count($cbcl_result) > 0)
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        @if ($results->cbcl_interpretation_status == 0)
                        @php $cbcl_status = 'Normal'; @endphp
                        @elseif ($results->cbcl_interpretation_status == 0)
                        @php $cbcl_status = 'Borderline'; @endphp
                        @else
                        @php $cbcl_status = 'Risk'; @endphp
                        @endif
                        <h5 class="mt-0 mb-5"><strong>@if ($screening_count > 1) {{$test_count}}. @endif CBCL</strong> - {{ $cbcl_status }}</h5>
                        @php 
                        $cbcl_problems = \ValuelistHelpers::cbclQuestionTypes();
                        $normal_range_text = 'Normal';
                        $medium_range_text = 'Borderline clinical range';
                        $risk_range_text = 'clinical range';
                        @endphp
                        <ol class="pl-25">
                            @foreach($cbcl_problems as $key => $value)
                            @if ($key > 0)
                            @if ($results->cbcl_interpretation_status == 0)
                            @php $status = $normal_range_text; @endphp
                            @elseif ($results->cbcl_interpretation_status == 0)
                            @php $status = $medium_range_text; @endphp
                            @else
                            @php $status = $risk_range_text; @endphp
                            @endif                                
                            <li><b>{{ $value }} problems</b> - {{ $status }}</li>      
                            @endif
                            @endforeach
                        </ol>
                    </div>
                    @php $test_count++; @endphp
                    @endif                    
                    @php
                    $show_raw = false;
                    $show_scaled = false;
                    $show_age = false;
                    $show_growth = false;
                    $show_social = false;
                    $show_adaptive = false;
                    @endphp
                    @if (@$bayley_result->cg > 0 || @$bayley_result->rc > 0 || @$bayley_result->ec > 0 || @$bayley_result->fm > 0 || @$bayley_result->gm > 0 || @$bayley_result->se_raw_score > 0 || @$bayley_result->rec_raw_score > 0 || @$bayley_result->exp_raw_score > 0 || @$bayley_result->per_raw_score > 0 || @$bayley_result->ipr_raw_score > 0 || @$bayley_result->pla_raw_score > 0)
                    @php
                    $show_raw = true;
                    @endphp
                    @endif
                    @if (@$bayley_result->cg_scaled_score > 0 || @$bayley_result->rc_scaled_score > 0 || @$bayley_result->ec_scaled_score > 0 || @$bayley_result->fm_scaled_score > 0 || @$bayley_result->gm_scaled_score > 0 || @$bayley_result->se_scaled_score > 0 || @$bayley_result->rec_scaled_score > 0 || @$bayley_result->exp_scaled_score > 0 || @$bayley_result->per_scaled_score > 0 || @$bayley_result->ipr_scaled_score > 0 || @$bayley_result->pla_scaled_score > 0)
                    @php
                    $show_scaled = true;
                    @endphp
                    @endif
                    @if (!empty(@$bayley_result->cg_age_equivalent) || !empty(@$bayley_result->rc_age_equivalent) || !empty(@$bayley_result->ec_age_equivalent) || !empty(@$bayley_result->fm_age_equivalent) || !empty(@$bayley_result->gm_age_equivalent)  || !empty(@$bayley_result->rec_age_equivalent) || !empty(@$bayley_result->exp_age_equivalent) || !empty(@$bayley_result->per_age_equivalent) || !empty(@$bayley_result->ipr_age_equivalent) || !empty(@$bayley_result->pla_age_equivalent))
                    @php
                    $show_age = true;
                    @endphp
                    @endif
                    @if (!empty(@$bayley_result->cg_growth_scale) || !empty(@$bayley_result->rc_growth_scale) || !empty(@$bayley_result->ec_growth_scale) || !empty(@$bayley_result->fm_growth_scale) || !empty(@$bayley_result->gm_growth_scale)  || !empty(@$bayley_result->rec_growth_scale) || !empty(@$bayley_result->exp_growth_scale) || !empty(@$bayley_result->per_growth_scale) || !empty(@$bayley_result->ipr_growth_scale) || !empty(@$bayley_result->pla_growth_scale))
                    @php
                    $show_growth = true;
                    @endphp
                    @endif
                    @if (@$bayley_result->se_raw_score > 0 || @$bayley_result->se_scaled_score > 0)
                    @php
                    $show_social = true;
                    @endphp
                    @endif
                    @if ((@$bayley_result->rec_raw_score > 0 || @$bayley_result->rec_scaled_score > 0 || !empty(@$bayley_result->rec_age_equivalent) || !empty(@$bayley_result->rec_growth_scale)) || (@$bayley_result->exp_raw_score > 0 || @$bayley_result->exp_scaled_score > 0 || !empty(@$bayley_result->exp_age_equivalent) || !empty(@$bayley_result->exp_growth_scale)) || (@$bayley_result->per_raw_score > 0 || @$bayley_result->per_scaled_score > 0 || !empty(@$bayley_result->per_age_equivalent) || !empty(@$bayley_result->per_growth_scale)) || (@$bayley_result->ipr_raw_score > 0 || @$bayley_result->ipr_scaled_score > 0 || !empty(@$bayley_result->ipr_age_equivalent) || !empty(@$bayley_result->ipr_growth_scale)) || (@$bayley_result->pla_raw_score > 0 || @$bayley_result->pla_scaled_score > 0 || !empty(@$bayley_result->pla_age_equivalent) || !empty(@$bayley_result->pla_growth_scale)))
                    @php
                    $show_adaptive = true;
                    @endphp
                    @endif
                    @if (count($bayley_result) > 0 && ($show_raw || $show_scaled || $show_age || $show_growth))
                    {!! Form::hidden('id', @$bayley_result->id) !!}
                    <div class="col-md-12 col-sm-12 col-xs-12" id="bayley-table">
                        <h5 class="m-0"><strong> {{$test_count}}. Bayley 4</strong></h5>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                                    <h4><b>SCORE SUMMARY</b></h4>
                                    <div class="">
                                        <h5><b>Subtest Scaled Score Summary</b></h5>
                                        <table class="table table-bordered table-responsive table-fixed">
                                            <thead>
                                                <tr>
                                                    <th class="text-left">Scale<br/><span class="pl-15">Subtest</span></th>
                                                    @if ($show_raw)
                                                    <th>Raw score</th>
                                                    @endif
                                                    @if ($show_scaled)
                                                    <th>Scaled score</th>
                                                    @endif
                                                    @if ($show_age)
                                                    <th>Age equivalent</th>
                                                    @endif
                                                    @if ($show_growth)
                                                    <th>Growth scale<br/>value</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-left score-bg-cg" colspan="5"><b>Cognitive</b></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left plr-15">Cognitive (CG)</td>
                                                    @if ($show_raw)
                                                    <td>{!! @$bayley_result->cg !!}</td>
                                                    @endif
                                                    @if ($show_scaled)
                                                    <td>{!! @$bayley_result->cg_scaled_score !!}</td>
                                                    @endif
                                                    @if ($show_age)
                                                    <td>{!! @$bayley_result->cg_age_equivalent !!}</td>
                                                    @endif
                                                    @if ($show_growth)
                                                    <td>{!! @$bayley_result->cg_growth_scale !!}</td>
                                                    @endif
                                                </tr>
                                            </tr>
                                            <tr>
                                                <td class="text-left score-bg-rc" colspan="5"><b>Language</b></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left plr-15">Receptive<br/>Communication (RC)</td>
                                                @if ($show_raw)
                                                <td>{!! @$bayley_result->rc !!}</td>
                                                @endif
                                                @if ($show_scaled)
                                                <td>{!! @$bayley_result->rc_scaled_score !!}</td>
                                                @endif
                                                @if ($show_age)
                                                <td>{!! @$bayley_result->rc_age_equivalent !!}</td>
                                                @endif
                                                @if ($show_growth)
                                                <td>{!! @$bayley_result->rc_growth_scale !!}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td class="text-left plr-15">Expressive<br/>Communication (EC)</td>
                                                @if ($show_raw)
                                                <td>{!! @$bayley_result->ec !!}</td>
                                                @endif
                                                @if ($show_scaled)
                                                <td>{!! @$bayley_result->ec_scaled_score !!}</td>
                                                @endif
                                                @if ($show_age)
                                                <td>{!! @$bayley_result->ec_age_equivalent !!}</td>
                                                @endif
                                                @if ($show_growth)
                                                <td>{!! @$bayley_result->ec_growth_scale !!}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td class="text-left score-bg-fm" colspan="5"><b>Motor</b></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left plr-15">Fine Motor (FM)</td>
                                                @if ($show_raw)
                                                <td>{!! @$bayley_result->fm !!}</td>
                                                @endif
                                                @if ($show_scaled)
                                                <td>{!! @$bayley_result->fm_scaled_score !!}</td>
                                                @endif
                                                @if ($show_age)
                                                <td>{!! @$bayley_result->fm_age_equivalent !!}</td>
                                                @endif
                                                @if ($show_growth)
                                                <td>{!! @$bayley_result->fm_growth_scale !!}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td class="text-left plr-15">Gross Motor (GM)</td>
                                                @if ($show_raw)
                                                <td>{!! @$bayley_result->gm !!}</td>
                                                @endif
                                                @if ($show_scaled)
                                                <td>{!! @$bayley_result->gm_scaled_score !!}</td>
                                                @endif
                                                @if ($show_age)
                                                <td>{!! @$bayley_result->gm_age_equivalent !!}</td>
                                                @endif
                                                @if ($show_growth)
                                                <td>{!! @$bayley_result->gm_growth_scale !!}</td>
                                                @endif
                                            </tr>
                                            @if ($show_social)
                                            <tr>
                                                <td class="text-left score-bg-se" colspan="5"><b>Social-Emotional</b></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left plr-15">Social-Emotional (SE)</td>
                                                @if ($show_raw)
                                                <td>{!! @$bayley_result->se_raw_score !!}</td>
                                                @endif
                                                @if ($show_scaled)
                                                <td>{!! @$bayley_result->se_scaled_score !!}</td>
                                                @endif
                                                @if ($show_age)
                                                <td class="bg-default"></td>
                                                @endif
                                                @if ($show_growth)
                                                <td class="bg-default"></td>
                                                @endif
                                            </tr>
                                            @endif
                                            @if ($show_adaptive)
                                            <tr>
                                                <td class="text-left score-bg-ab" colspan="5"><b>Adaptive Behavior</b></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left plr-15">Receptive (REC)</td>
                                                @if ($show_raw)
                                                <td>{!! @$bayley_result->rec_raw_score !!}</td>
                                                @endif
                                                @if ($show_scaled)
                                                <td>{!! @$bayley_result->rec_scaled_score !!}</td>
                                                @endif
                                                @if ($show_age)
                                                <td>{!! @$bayley_result->rec_age_equivalent !!}</td>
                                                @endif
                                                @if ($show_growth)
                                                <td>{!! @$bayley_result->rec_growth_scale !!}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td class="text-left plr-15">Expressive (EXP)</td>
                                                @if ($show_raw)
                                                <td>{!! @$bayley_result->exp_raw_score !!}</td>
                                                @endif
                                                @if ($show_scaled)
                                                <td>{!! @$bayley_result->exp_scaled_score !!}</td>
                                                @endif
                                                @if ($show_age)
                                                <td>{!! @$bayley_result->exp_age_equivalent !!}</td>
                                                @endif
                                                @if ($show_growth)
                                                <td>{!! @$bayley_result->exp_growth_scale !!}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td class="text-left plr-15">Personal (PER)</td>
                                                @if ($show_raw)
                                                <td>{!! @$bayley_result->per_raw_score !!}</td>
                                                @endif
                                                @if ($show_scaled)
                                                <td>{!! @$bayley_result->per_scaled_score !!}</td>
                                                @endif
                                                @if ($show_age)
                                                <td>{!! @$bayley_result->per_age_equivalent !!}</td>
                                                @endif
                                                @if ($show_growth)
                                                <td>{!! @$bayley_result->per_growth_scale !!}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td class="text-left plr-15">Interpersonal Relationships (IPR)</td>
                                                @if ($show_raw)
                                                <td>{!! @$bayley_result->ipr_raw_score !!}</td>
                                                @endif
                                                @if ($show_scaled)
                                                <td>{!! @$bayley_result->ipr_scaled_score !!}</td>
                                                @endif
                                                @if ($show_age)
                                                <td>{!! @$bayley_result->ipr_age_equivalent !!}</td>
                                                @endif
                                                @if ($show_growth)
                                                <td>{!! @$bayley_result->ipr_growth_scale !!}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td class="text-left plr-15">Play and Leisure (PLA)</td>
                                                @if ($show_raw)
                                                <td>{!! @$bayley_result->pla_raw_score !!}</td>
                                                @endif
                                                @if ($show_scaled)
                                                <td>{!! @$bayley_result->pla_scaled_score !!}</td>
                                                @endif
                                                @if ($show_age)
                                                <td>{!! @$bayley_result->pla_age_equivalent !!}</td>
                                                @endif
                                                @if ($show_growth)
                                                <td>{!! @$bayley_result->pla_growth_scale !!}</td>
                                                @endif
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>  
                                </div>
                            </div>
                            @if (@$bayley_result->cog_standard_score > 0 || @$bayley_result->lang_standard_score > 0 || @$bayley_result->mot_standard_score > 0 || @$bayley_result->soem_standard_score > 0 || @$bayley_result->com_standard_score > 0 || @$bayley_result->dls_standard_score > 0 || @$bayley_result->soc_standard_score > 0 || @$bayley_result->adbe_standard_score > 0)
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
                                                <th>{!! @$bayley_result->confidence_interval !!} % Confidence<br/>interval</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-left score-bg-cg" colspan="5"><b>Cognitive, Language, and Motor</b></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Cognitive (COG)</td>
                                                <td>{!! @$bayley_result->cg_scaled_score !!}</td>
                                                <td>{!! @$bayley_result->cog_standard_score !!}</td>
                                                <td>{!! @$bayley_result->cog_percentile_rank !!}</td>
                                                <td>{!! @$bayley_result->cog_confidence_interval_start !!} - {!! @$bayley_result->cog_confidence_interval_end !!}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Language (LANG)</td>
                                                <td>{!! @$bayley_result->lang_scaled_score !!}</td>
                                                <td>{!! @$bayley_result->lang_standard_score !!}</td>
                                                <td>{!! @$bayley_result->lang_percentile_rank !!}</td>
                                                <td>{!! @$bayley_result->lang_confidence_interval_start !!} - {!! @$bayley_result->lang_confidence_interval_end !!}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Motor (MOT)</td>
                                                <td>{!! @$bayley_result->mot_scaled_score !!}</td>
                                                <td>{!! @$bayley_result->mot_standard_score !!}</td>
                                                <td>{!! @$bayley_result->mot_percentile_rank !!}</td>
                                                <td>{!! @$bayley_result->mot_confidence_interval_start !!} - {!! @$bayley_result->mot_confidence_interval_end !!}</td>
                                            </tr>
                                            @if ($show_social)
                                            <tr>
                                                <td class="text-left score-bg-se" colspan="5"><b>Social-Emotional</b></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Social-Emotional (SOEM)</td>
                                                <td>{!! @$bayley_result->se_scaled_score !!}</td>
                                                <td>{!! @$bayley_result->soem_standard_score !!}</td>
                                                <td>{!! @$bayley_result->soem_percentile_rank !!}</td>
                                                <td>{!! @$bayley_result->soem_confidence_interval_start !!} - {!! @$bayley_result->soem_confidence_interval_end !!}</td>
                                            </tr>
                                            @endif
                                            @if ($show_adaptive)
                                            <tr>
                                                <td class="text-left score-bg-ab" colspan="5"><b>Adaptive Behavior</b></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Communication (COM)</td>
                                                <td>{!! @$bayley_result->com_scaled_score !!}</td>
                                                <td>{!! @$bayley_result->com_standard_score !!}</td>
                                                <td>{!! @$bayley_result->com_percentile_rank !!}</td>
                                                <td>{!! @$bayley_result->com_confidence_interval_start !!} - {!! @$bayley_result->com_confidence_interval_end !!}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Daily Living Skills (DLS)</td>
                                                <td>{!! @$bayley_result->per_scaled_score !!}</td>
                                                <td>{!! @$bayley_result->dls_standard_score !!}</td>
                                                <td>{!! @$bayley_result->dls_percentile_rank !!}</td>
                                                <td>{!! @$bayley_result->dls_confidence_interval_start !!} - {!! @$bayley_result->dls_confidence_interval_end !!}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Socialization (SOC)</td>
                                                <td>{!! @$bayley_result->soc_scaled_score !!}</td>
                                                <td>{!! @$bayley_result->soc_standard_score !!}</td>
                                                <td>{!! @$bayley_result->soc_percentile_rank !!}</td>
                                                <td>{!! @$bayley_result->soc_confidence_interval_start !!} - {!! @$bayley_result->soc_confidence_interval_end !!}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Adaptive Behavior (ADBE)</td>
                                                <td>{!! @$bayley_result->adbe_scaled_score !!}</td>
                                                <td>{!! @$bayley_result->adbe_standard_score !!}</td>
                                                <td>{!! @$bayley_result->adbe_percentile_rank !!}</td>
                                                <td>{!! @$bayley_result->adbe_confidence_interval_start !!} - {!! @$bayley_result->adbe_confidence_interval_end !!}</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>    
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @php $test_count++; @endphp

                @if (count($bayley_result) > 0)        

                {!! Form::hidden('cg_scaled_score', @$bayley_result->cg_scaled_score) !!}
                {!! Form::hidden('rc_scaled_score', @$bayley_result->rc_scaled_score) !!}
                {!! Form::hidden('ec_scaled_score', @$bayley_result->ec_scaled_score) !!}
                {!! Form::hidden('fm_scaled_score', @$bayley_result->fm_scaled_score) !!}
                {!! Form::hidden('gm_scaled_score', @$bayley_result->gm_scaled_score) !!}
                {!! Form::hidden('se_scaled_score', @$bayley_result->se_scaled_score) !!}
                {!! Form::hidden('rec_scaled_score', @$bayley_result->rec_scaled_score) !!}
                {!! Form::hidden('exp_scaled_score', @$bayley_result->exp_scaled_score) !!}
                {!! Form::hidden('per_scaled_score', @$bayley_result->per_scaled_score) !!}
                {!! Form::hidden('ipr_scaled_score', @$bayley_result->ipr_scaled_score) !!}
                {!! Form::hidden('pla_scaled_score', @$bayley_result->pla_scaled_score) !!}

                {!! Form::hidden('cog', @$bayley_result->cog_standard_score) !!}
                {!! Form::hidden('lang', @$bayley_result->lang_standard_score) !!}
                {!! Form::hidden('mot', @$bayley_result->mot_standard_score) !!}
                {!! Form::hidden('soem', @$bayley_result->soem_standard_score) !!}
                {!! Form::hidden('com', @$bayley_result->com_standard_score) !!}
                {!! Form::hidden('dls', @$bayley_result->dls_standard_score) !!}
                {!! Form::hidden('soc', @$bayley_result->soc_standard_score) !!}
                {!! Form::hidden('adbe', @$bayley_result->adbe_standard_score) !!}

                {!! Form::hidden('cog_start', @$bayley_result->cog_confidence_interval_start) !!}
                {!! Form::hidden('cog_end', @$bayley_result->cog_confidence_interval_end) !!}

                {!! Form::hidden('lang_start', @$bayley_result->lang_confidence_interval_start) !!}
                {!! Form::hidden('lang_end', @$bayley_result->lang_confidence_interval_end) !!}

                {!! Form::hidden('mot_start', @$bayley_result->mot_confidence_interval_start) !!}
                {!! Form::hidden('mot_end', @$bayley_result->mot_confidence_interval_end) !!}

                {!! Form::hidden('mot_start', @$bayley_result->mot_confidence_interval_start) !!}
                {!! Form::hidden('mot_end', @$bayley_result->mot_confidence_interval_end) !!}

                {!! Form::hidden('soem_start', @$bayley_result->soem_confidence_interval_start) !!}
                {!! Form::hidden('soem_end', @$bayley_result->soem_confidence_interval_end) !!}

                {!! Form::hidden('com_start', @$bayley_result->com_confidence_interval_start) !!}
                {!! Form::hidden('com_end', @$bayley_result->com_confidence_interval_end) !!}

                {!! Form::hidden('dls_start', @$bayley_result->dls_confidence_interval_start) !!}
                {!! Form::hidden('dls_end', @$bayley_result->dls_confidence_interval_end) !!}

                {!! Form::hidden('soc_start', @$bayley_result->soc_confidence_interval_start) !!}
                {!! Form::hidden('soc_end', @$bayley_result->soc_confidence_interval_end) !!}

                {!! Form::hidden('adbe_start', @$bayley_result->adbe_confidence_interval_start) !!}
                {!! Form::hidden('adbe_end', @$bayley_result->adbe_confidence_interval_end) !!}

                {!! Form::hidden('confidence_interval', @$bayley_result->confidence_interval) !!}

                @if (false)
                @if (@$bayley_result->cg_scaled_score > 0 || @$bayley_result->lang_scaled_score > 0 || @$bayley_result->mot_scaled_score > 0 || @$bayley_result->se_scaled_score > 0 || @$bayley_result->com_scaled_score > 0 || @$bayley_result->per_scaled_score > 0 || @$bayley_result->soc_scaled_score > 0 || @$bayley_result->adbe_scaled_score > 0)
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0 chart-avoid-page-break">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class=" pl-10-must">
                            <h4><b>Score Summary Profile</b></h4>
                            <div class="display-flex justify-content-center">
                                <div id="scaled-container"  class="chart-avoid-page-break">
                                    <h5 class="text-center mb-0"><b>Subtest Score Profile</b></h5>
                                    <div id="scaled"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if (@$bayley_result->cog_standard_score > 0 || @$bayley_result->lang_standard_score > 0 || @$bayley_result->mot_standard_score > 0 || @$bayley_result->soem_standard_score > 0 || @$bayley_result->com_standard_score > 0 || @$bayley_result->dls_standard_score > 0 || @$bayley_result->soc_standard_score > 0 || @$bayley_result->adbe_standard_score > 0)
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0 chart-avoid-page-break">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class=" pl-10-must">
                            <h4><b>Score Summary Profile (Continued)</b></h4>
                            <div class="display-flex justify-content-center">
                                <div id="standard-container" class="chart-avoid-page-break">
                                    <h5 class="text-center mb-0"><b>Standard Score Profile</b></h5>
                                    <div id="standard"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endif
                @if ((@$bayley_result->cg_scaled_score > 0 || @$bayley_result->lang_scaled_score > 0 || @$bayley_result->mot_scaled_score > 0) || (@$bayley_result->cog_standard_score > 0 || @$bayley_result->lang_standard_score > 0 || @$bayley_result->mot_standard_score > 0))
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0 chart-avoid-page-break">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class=" pl-10-must">
                            <h4><b>Score Summary Profile</b></h4>
                            <div class="display-flex justify-content-center">
                                <!-- <div id="scaled-container"  class="chart-avoid-page-break"> -->
                                    <!-- <div id="scaled"></div> -->
                                    <!-- <div class="display-flex justify-content-center"> -->
                                        <div class="chart-avoid-page-break">
                                            <h5 class="text-center mb-0"><b>Subtest Score Profile</b></h5>
                                            <div id="scaled_chart_1"></div>
                                        </div>
                                        <div class="chart-avoid-page-break">
                                            <h5 class="text-center mb-0"><b>Standard Score Profile</b></h5>
                                            <div id="standard_chart_1"></div>
                                        </div>
                                        <!-- </div> -->
                                        <!-- </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if ((@$bayley_result->se_scaled_score > 0 || @$bayley_result->com_scaled_score > 0 || @$bayley_result->per_scaled_score > 0 || @$bayley_result->soc_scaled_score > 0 || @$bayley_result->adbe_scaled_score > 0) || (@$bayley_result->soem_standard_score > 0 || @$bayley_result->com_standard_score > 0 || @$bayley_result->dls_standard_score > 0 || @$bayley_result->soc_standard_score > 0 || @$bayley_result->adbe_standard_score > 0))
                        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0 chart-avoid-page-break">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class=" pl-10-must">
                                    <h4><b>Score Summary Profile (Continued)</b></h4>
                                    <div class="display-flex justify-content-center">
                                        <!-- <div id="standard-container" class="chart-avoid-page-break"> -->
                                            <!-- <div id="standard"></div> -->
                                            <!-- <div class="display-flex justify-content-center"> -->
                                                <div class="chart-avoid-page-break" style="position: relative;right: -25px;">
                                                    <h5 class="text-center mb-0"><b>Subtest/Subdomin Score Profile</b></h5>
                                                    <div id="scaled_chart_2"></div>
                                                </div>
                                                <div class="chart-avoid-page-break">
                                                    <h5 class="text-center mb-0"><b>Standard Score Profile</b></h5>
                                                    <div id="standard_chart_2"></div>
                                                </div>

                                                <!-- </div> -->
                                                <!-- </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="clearfix"></div>
                                @endif
                                @endif


                                @if (isset($issa_result->id) && $issa_result->total > 0)
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h5 class="mt-0 mb-5"><strong>{{$test_count}}. ISSA</strong></h5>
                                    <table class="pl-25 table table-bordered table-responsive table-fixed" id="issa">
                                        <thead>
                                            <tr>
                                                <td>Domains</td>
                                                <td>Total Score</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-left">1. Social relationship and reciprocity</td>
                                                <td>{{ $issa_result->srr }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">2. Emotional responsiveness</td>
                                                <td>{{ $issa_result->er }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">3. Speech-language and communication</td>
                                                <td>{{ $issa_result->slc }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">4. Behaviour patterns</td>
                                                <td>{{ $issa_result->bp }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">5. Sensory aspects</td>
                                                <td>{{ $issa_result->sa }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">6. Cognitive component</td>
                                                <td>{{ $issa_result->cc }}</td>
                                            </tr>
                                            <tr>
                                                <td class="align-right-must"><b>Total</b></td>
                                                <td><span><b>{{$issa_result->total}}</b></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @php $test_count++; @endphp
                                @endif  
                                @if (isset($cars_result->id) && $cars_result->total > 0)
                                <div class="col-md-12 col-sm-12 col-xs-12 pt-15">
                                    <h5 class="mt-0 mb-5"><strong>{{$test_count}}. CARS</strong></h5>
                                    <table class="pl-25 table table-bordered table-responsive table-fixed" id="cars">
                                        <thead>
                                            <tr>
                                                <td>Domains</td>
                                                <td>Total Score</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-left">1. Relating to People</td>
                                                <td> {{ $cars_result->relating_to_people }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">2. Imitation</td>
                                                <td> {{ $cars_result->imitation }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">3. Emotional Response</td>
                                                <td> {{ $cars_result->emotional_response }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">4. Body Use</td>
                                                <td> {{ $cars_result->body_use }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">5. Object Use</td>
                                                <td> {{ $cars_result->object_use }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">6. Adaptation to Change</td>
                                                <td> {{ $cars_result->adaptation_to_change }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">7. Visual Response</td>
                                                <td> {{ $cars_result->visual_response }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">8. Listening Response</td>
                                                <td> {{ $cars_result->listening_response }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">9. Taste, Smell and Touch Response and Use</td>
                                                <td> {{ $cars_result->tst_response_use }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">10. Fear or Nervousness</td>
                                                <td> {{ $cars_result->fear_nervous }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">11. Verbal Communication</td>
                                                <td> {{ $cars_result->verbal }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">12. Non Verbal Communication</td>
                                                <td> {{ $cars_result->non_verbal }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">13. Activity Level</td>
                                                <td> {{ $cars_result->activity_level }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">14. Level and Consistency of Intellectual Response</td>
                                                <td> {{ $cars_result->intellectual_response }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">15. General Impressions</td>
                                                <td> {{ $cars_result->general_imperssions }}</td>
                                            </tr>
                                            <tr>
                                                <td class="align-right-must"><b>Total</b></td>
                                                <td><span><b>{{$cars_result->total}}</b></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @php $test_count++;@endphp
                                @endif 
                                @if(isset($cc_current_infant_result->infants_personal_social) || !empty($cc_previous_infant_result->infants_personal_social))
                                <div class="col-md-12 col-sm-12 col-xs-12 pt-15">
                                    <h5 class="mt-0 mb-5"><strong>{{$test_count}}. CAROLINA CURRICULUM - INFANTS</strong></h5>
                                    <table class="pl-25 table table-bordered table-responsive table-fixed" id="cc_infants">
                                        <thead>
                                            <tr>
                                                <td>Domains</td>     
                                                 @if(isset($cc_current_infant_result->infants_personal_social)&& isset($cc_previous_infant_result->infants_personal_social))
                                                 <td>Age Range (Pre Intervention)</td>
                                                 @endif
                                                 <td>Age Range (Post Intervention)</td>
                                                 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-left">Personal Social</td>
                                                 @if(isset($cc_current_infant_result) && !empty($cc_previous_infant_result))
                                                <td>{{$cc_previous_infant_result->infants_personal_social}}</td>
                                                @endif
                                                <td>{{$cc_current_infant_result->infants_personal_social}}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Cognition</td>
                                                 @if(isset($cc_current_infant_result) && !empty($cc_previous_infant_result))
                                                <td>{{$cc_previous_infant_result->infants_cognition}}</td>
                                                @endif
                                                <td>{{$cc_current_infant_result->infants_cognition}}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Cognition Communication</td>
                                                 @if(isset($cc_current_infant_result) && !empty($cc_previous_infant_result))
                                                <td>{{$cc_previous_infant_result->infants_cognition_communication}}</td>
                                                @endif
                                                <td>{{$cc_current_infant_result->infants_cognition_communication}}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Fine Motor</td>
                                                 @if(isset($cc_current_infant_result) && !empty($cc_previous_infant_result))
                                                <td>{{$cc_previous_infant_result->infants_fine_motor}}</td>
                                                @endif
                                                <td>{{$cc_current_infant_result->infants_fine_motor}}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Gross Motor</td>
                                                 @if(isset($cc_current_infant_result) && !empty($cc_previous_infant_result))
                                                <td>{{$cc_previous_infant_result->infants_gross_motor}}</td>
                                                @endif
                                                <td>{{$cc_current_infant_result->infants_gross_motor}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @php $test_count++; @endphp
                                @endif
                                @if(isset($cc_current_preschoolers_result->preschoolers_personal_social) || !empty ($cc_previous_preschoolers_result->preschoolers_personal_social))
                                <div class="col-md-12 col-sm-12 col-xs-12 pt-15">
                                    <h5 class="mt-0 mb-5"><strong>{{$test_count}}. CAROLINA CURRICULUM - PRESCHOOLERS</strong></h5>
                                    <table class="pl-25 table table-bordered table-responsive table-fixed" id="cc_preschoolers">
                                        <thead>
                                            <tr>
                                                <td>Domains</td>
                                                @if(isset($cc_current_preschoolers_result->preschoolers_personal_social)&& isset($cc_previous_preschoolers_result->preschoolers_personal_social))
                                                <td>Age Range (Pre Intervention)</td>
                                                 @endif
                                                <td>Age Range (Post Intervention)</td>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-left">Personal Social</td>
                                                @if(isset($cc_current_preschoolers_result)&& isset($cc_previous_preschoolers_result))
                                                <td>{{$cc_previous_preschoolers_result->preschoolers_personal_social}}</td>
                                                @endif
                                                <td>{{$cc_current_preschoolers_result->preschoolers_personal_social}}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Cognition</td>
                                                 @if(isset($cc_current_preschoolers_result)&& isset($cc_previous_preschoolers_result))
                                                <td>{{$cc_previous_preschoolers_result->preschoolers_cognition}}</td>
                                                @endif
                                                <td>{{$cc_current_preschoolers_result->preschoolers_cognition}}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Cognition Communication</td>
                                                 @if(isset($cc_current_preschoolers_result)&& isset($cc_previous_preschoolers_result))
                                                <td>{{$cc_previous_preschoolers_result->preschoolers_cognition_communication}}</td>
                                                @endif
                                                 <td>{{$cc_current_preschoolers_result->preschoolers_cognition_communication}}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Fine Motor</td>
                                                 @if(isset($cc_current_preschoolers_result)&& isset($cc_previous_preschoolers_result))
                                                <td>{{$cc_previous_preschoolers_result->preschoolers_fine_motor}}</td>
                                                @endif
                                                <td>{{$cc_current_preschoolers_result->preschoolers_fine_motor}}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Gross Motor</td>
                                                 @if(isset($cc_current_preschoolers_result)&& isset($cc_previous_preschoolers_result))
                                                <td>{{$cc_previous_preschoolers_result->preschoolers_gross_motor }}</td>
                                                @endif
                                                <td>{{$cc_current_preschoolers_result->preschoolers_gross_motor}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @php $test_count++; @endphp
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if ((is_object($hnne) && $hnne->total_hnne_score != 0) || (is_object($hine) && $hine->total_hine_score != 0) || isset($m_chat_score) || ($dasii && (isset($results->mental_cluster_interpretation) && !empty($results->mental_cluster_interpretation)) || (isset($results->motor_cluster_interpretation) && !empty($results->motor_cluster_interpretation)) || isset($results->dasii_interpretation) && !empty($results->dasii_interpretation)) || ($results->ddst_interpretation_status != null && !empty($results->ddst_interpretation_status)) || count($cbcl_result) > 0 || (isset($issa_result->id) && $issa_result->total > 0) || (isset($cars_result->id) && $cars_result->total > 0))
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="content-block pl-10-must">
                                <h5 class="mt-0 mb-5"> 
                                    <strong>Interpretation:</strong>
                                </h5>
                                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                                    <ol class="@if ($screening_count == 1) list-none @else pl-30-must @endif">
                                        @if (is_object($hnne) && $hnne->total_hnne_score != 0)
                                        <li>
                                            <b>HNNE</b>
                                            @if (isset($hnne_hine_interpretation_options[$results->hnne_interpretation]) && $results->hnne_interpretation != 0)
                                            <span> - {{$hnne_hine_interpretation_options[$results->hnne_interpretation]}}</span>
                                            @endif
                                            @if (isset($results->hnne_interpretation_others) && !empty($results->hnne_interpretation_others))
                                            <span> ( <b>Note</b> : {{$results->hnne_interpretation_others}} )</span>
                                            @endif
                                        </li>
                                        @endif
                                        @if (is_object($hine) && $hine->total_hine_score != 0)
                                        <li>
                                            <b>HINE</b>
                                            @if (isset($hnne_hine_interpretation_options[$results->hine_interpretation]) && $results->hine_interpretation != 0)
                                            <span> - {{$hnne_hine_interpretation_options[$results->hine_interpretation]}}</span>
                                            @endif
                                            @if (isset($results->hine_interpretation_others) && !empty($results->hine_interpretation_others))
                                            <span> ( <b>Note</b> : {{$results->hine_interpretation_others}} )</span>
                                            @endif
                                        </li>
                                        @endif
                                        @if (isset($m_chat_score))
                                        <li>
                                            <b>M-CHAT</b>
                                            @if (isset($m_chat_interpretation_options[$results->m_chat_r_interpretation]) && $results->m_chat_r_interpretation != 0)
                                            <span> - {{$m_chat_interpretation_options[$results->m_chat_r_interpretation]}}</span>
                                            @endif
                                            @if (isset($m_chat_interpretation_options[$results->m_chat_followup_interpretation]) && $results->m_chat_followup_interpretation != 0)
                                            <span> - {{$m_chat_interpretation_options[$results->m_chat_followup_interpretation]}}</span>
                                            @endif
                                            @if (isset($results->m_chat_r_interpretation_others) && !empty($results->m_chat_r_interpretation_others))
                                            <span> ( <b>Note</b> : {{$results->m_chat_r_interpretation_others}} )</span>
                                            @endif
                                            @if (isset($results->m_chat_followup_interpretation_others) && !empty($results->m_chat_followup_interpretation_others))
                                            <span> ( <b>Note</b> : {{$results->m_chat_followup_interpretation_others}} )</span>
                                            @endif
                                        </li>
                                        @endif
                                        @if ($dasii && (isset($results->mental_cluster_interpretation) && !empty($results->mental_cluster_interpretation)) || (isset($results->motor_cluster_interpretation) && !empty($results->motor_cluster_interpretation)) || isset($results->dasii_interpretation) && !empty($results->dasii_interpretation))
                                        <li>
                                            <b>DASII</b>
                                            <ul class="pl-30">
                                                @if (isset($results->mental_cluster_interpretation) && !empty($results->mental_cluster_interpretation))
                                                <li><b>Mental Cluster</b> - {{ $results->mental_cluster_interpretation }}</li>
                                                @endif
                                                @if (isset($results->motor_cluster_interpretation) && !empty($results->motor_cluster_interpretation))
                                                <li><b>Motor Cluster </b>- {{ $results->motor_cluster_interpretation }}</li>
                                                @endif
                                                @if (isset($results->dasii_interpretation) && !empty($results->dasii_interpretation))
                                                <li>
                                                    <b>{{$results->dasii_interpretation}}</b>
                                                </li>
                                                @endif
                                            </ul>
                                            @if (isset($results->dasii_interpretation_others) && !empty($results->dasii_interpretation_others))
                                            <span> ( <b>Note</b> : {{$results->dasii_interpretation_others}} )</span>
                                            @endif
                                        </li>
                                        @endif
                                        @if ($results->ddst_interpretation_status != null && !empty($results->ddst_interpretation_status))
                                        <li>
                                            <b>DDST II</b>
                                            @if ($results->ddst_interpretation != null && !empty($results->ddst_interpretation))
                                            <span> - {{$results->ddst_interpretation}}</span>
                                            @endif
                                            @if (isset($results->ddst_interpretation_others) && !empty($results->ddst_interpretation_others))
                                            <span> ( <b>Note</b> : {{$results->ddst_interpretation_others}} )</span>
                                            @endif
                                        </li>
                                        @endif
                                        @if (count($cbcl_result) > 0)
                                        <li>
                                            <b>CBCL</b>
                                        </li>
                                        @endif
                                        @if (isset($issa_result->id) && $issa_result->total > 0)
                                        <li>
                                            <b>ISSA</b> - {{ $issa_result->status }}
                                        </li>
                                        @endif
                                        @if (isset($cars_result->id) && $cars_result->total > 0)
                                        <li>
                                            <b>CARS</b> - {{ $cars_result->status }} Symptoms of Autism Spectrum Disorder
                                        </li>
                                        @endif
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if (!empty(trim(strip_tags(@$results->diagnosis))))
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="content-block pl-10-must">
                                <h5 class="mt-0 mb-5"> 
                                    <strong>Diagnosis:</strong>
                                </h5>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    {!! @$results->diagnosis !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    @endif
                    @if (!empty(trim(strip_tags($results->recommendation))) || !empty(trim(strip_tags(@@$results->home_program))))
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="content-block pl-10-must">
                                <h5 class="mt-0 mb-5"> 
                                    <strong>Recommendation:</strong>
                                </h5>
                                @if (!empty(trim(strip_tags($results->recommendation))))
                                <div class="pl-15">{!! $results->recommendation !!}</div>
                                @endif
                                @if (count(@$results) > 0 && !empty(trim(strip_tags(@$results->home_program))))
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h5 class="mtb-0"> 
                                        <strong>Home Program:</strong>
                                    </h5>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        {!! @@$results->home_program !!}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    @endif
                    @if(isset($neuro_developmental_report) && count($neuro_developmental_report) > 0)
                    @foreach($neuro_developmental_report as $age_key => $age_value)
                    @if (strpos($age_value->baby_age, 'm') !== false)
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="content-block p-0">
                                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                                    @if($age_value->baby_age == 'term_corrected')
                                    <h2 style="display: inline-block;"><strong>Term Corrected</strong></h2>
                                    @else
                                    <h2 style="display: inline-block;"><strong>{{ str_replace(['m', 'y'], '', $age_value->baby_age) }} MONTHS (Corrected age)</strong></h2>
                                    @endif
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                                    <h5> <strong><u>LANGUAGE ASSESSMENT</u></strong></h5>
                                    <div class="age-report-details">
                                        @if($age_value->baby_age == '18m')
                                        <h5 style="display: inline-block;"><strong>LEST</strong></h5>
                                        <div style="display:inline-block; margin-left: 10px; !important" class="checkbox @if(isset($age_value->is_lest) && $age_value->is_lest == true) checked @endif"></div>
                                        @endif
                                        <h5><strong>DDST/DASII</strong></h5>
                                        <ul class="age-wise-report">
                                            <li>Mental developmental quotient : @if(isset($age_value->mental_development_quotient) && $age_value->mental_development_quotient != '') {{ $age_value->mental_development_quotient }} @endif</li>
                                            <li>Motor developmental quotient : @if(isset($age_value->motor_development_quotient) && $age_value->motor_development_quotient != '') {{ $age_value->motor_development_quotient }} @endif</li>
                                            <li>Clusters : @if(isset($age_value->clusters) && $age_value->clusters != '') {{ $age_value->clusters }} @endif</li>
                                            <li>Interpretation : @if(isset($age_value->interpretation) && $age_value->interpretation != '') {{ $age_value->interpretation }} @endif</li>
                                        </ul>
                                    </div>
                                </div>
                                @if($age_value->baby_age == '18m')
                                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                                    <h5><strong><u>M-CHAT</u></strong></h5>
                                    <div class="age-report-details">
                                        <h5><strong>@if(isset($age_value->m_chat_type) && $age_value->m_chat_type == true) Positive else Negative @endif Positive</strong></h5>
                                        <h5><strong>{{ $age_value->m_chat_info }}</strong></h5>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                                    <h5><strong><u>DIAGNOSIS AT @if($age_value->baby_age == 'term_corrected') Term Corrected @else {{ str_replace(['m', 'y'], '', $age_value->baby_age) }} MONTHS @endif</u></strong></h5>
                                    <div class="age-report-details">
                                        <h5 style="display: inline-block;"><strong>Any abnormal movements : @if(isset($age_value->is_abnormal_movements) && $age_value->is_abnormal_movements == true) YES @else NO @endif</strong></h5>
                                        @if(isset($age_value->is_abnormal_movements) && $age_value->is_abnormal_movements == true)
                                        <ul class="age-wise-report">
                                            @if(isset($age_value->choreoathetoid) && $age_value->choreoathetoid == true) 
                                            <li>Choreoathetios</li>
                                            @endif
                                            @if(isset($age_value->tremors) && $age_value->tremors == true) 
                                            <li>Tremors</li>
                                            @endif
                                            @if(isset($age_value->ataxia) && $age_value->ataxia == true) 
                                            <li>Ataxia &ensp;<span class="checkbox "></span></li>
                                            @endif
                                        </ul>
                                        @endif
                                        <p style="margin-top: 30px;padding-left: 20px;">
                                            &ensp;&ensp;&ensp; {{ $age_value->abnormal_movements_info }}
                                        </p>
                                        <h5 style="display: inline-block;"><strong>Normal : @if(isset($age_value->is_normal_movements) && $age_value->is_normal_movements == true) YES  @else NO @endif</strong></h5>
                                        @if(isset($age_value->is_normal_movements) && $age_value->is_normal_movements == true)
                                        <ul class="age-wise-report">
                                            @if(isset($age_value->cerebral_palsy) && $age_value->cerebral_palsy == true)
                                            <li>Cerebral palsy</li>
                                            @endif
                                            @if(isset($age_value->hearing_problem) && $age_value->hearing_problem == true)
                                            <li>Hearing problem</li>
                                            @endif
                                            @if(isset($age_value->language_delay) && $age_value->language_delay == true)
                                            <li>Language delay</li>
                                            @endif
                                            @if(isset($age_value->cognitive_problem) && $age_value->cognitive_problem == true)
                                            <li>Cognitive problems</li>
                                            @endif
                                            @if(isset($age_value->visual_problem) && $age_value->visual_problem == true)
                                            <li>Visual problems</li>
                                            @endif
                                            @if(isset($age_value->chronic_medical_problem) && $age_value->chronic_medical_problem == true)
                                            <li>Chronic medical problems</li>
                                            @endif
                                        </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    @elseif (strpos($age_value->baby_age, 'y') !== false)
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h3 style="margin-top: 50px;"><strong>2 YEARS</strong></h3>
                        <div class="content-block" style="margin-top: 0px; min-height: 100px;">
                            <div class="form-group">
                                <span class="print-label print-label-text">DDST II:</span> 
                                <span class="op-value print-label-value" style="font-weight: normal;letter-spacing: 0.4px;margin-top: 5px;">{{ $age_value->ddst }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="content-block" style="min-height: 100px;">
                            <div class="form-group">
                                <span class="print-label print-label-text">LEST:</span> 
                                <span class="op-value print-label-value" style="font-weight: normal;letter-spacing: 0.4px;margin-top: 5px;">{{ $age_value->lest }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="content-block" style="min-height: 100px;">
                            <div class="form-group">
                                <span class="print-label print-label-text">M-CHAT (R):</span> 
                                <span class="op-value print-label-value" style="font-weight: normal;letter-spacing: 0.4px;margin-top: 5px;">{{ $age_value->m_chat }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="content-block" style="min-height: 100px;">
                            <div class="form-group">
                                <span class="print-label print-label-text">REFRACTION:</span> 
                                <span class="op-value print-label-value" style="font-weight: normal;letter-spacing: 0.4px;margin-top: 5px;">{{ $age_value->refraction }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="content-block">
                            <div class="form-group">
                                <span class="print-label print-label-text">DEWORMING:</span> 
                                <span class="op-value print-label-value" style="font-weight: normal;letter-spacing: 0.4px;margin-top: 5px;">@if(isset($age_value->deworming) && $age_value->deworming == true) YES @else NO @endif</span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    @endif
                    @endforeach
                    @endif
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h5>
                            <strong>
                                Next Review:
                                @if(date("Y",strtotime($results->review)) > 1970) {!! date("d-m-Y",strtotime($results->review)); !!} {!! $results->review_time.':'.$results->review_min.' '.$results->review_session  !!} @else {{ title_case('A Review Appoinment not been made.') }}  @endif                                                                              
                            </strong>
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0 mt-15">
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
