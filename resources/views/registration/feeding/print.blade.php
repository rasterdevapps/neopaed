@extends('print')
@section('content')
<style type="text/css">
    span.custom-print-label {
        display: block;
        padding-top: 5px;
        padding-left: 15px;
        font-weight: normal;
    }
</style>
<div class="temp-container" id="neuro-report-print">
    <div class="temp-row">
        <div class="col-md-12 col-xs-12 m">
            @if(isset($results->id))
            <img src="{{ SiteHelpers::getOpLogo($results->id) }}" class="img-responsive">
            @endif
        </div>@if ($neuro_consultant_id == @$results->visit_from)
        <div class="col-md-12 col-sm-12 col-xs-12 mt-15">
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
        <div class="clearfix"></div>
        <div class="col-md-12 col-sm-12 col-xs-12">
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
        <div class="clearfix"></div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <table style="margin-bottom: 0px;">
                <tr>
                    <td class="vertical-top" style="border: 0px !important;">
                        <p>
                            <span style="font-size:14px">
                                <u>
                                    <strong>Childhood Interventionist, Infant feeding&Lactation Professional</strong>
                                </u>
                            </span>
                        </p>
                        <p>
                            <strong>Mrs Nivetha J</strong> M.Sc.,ACD; ACLP
                        </p>
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
        <div class="col-md-12 col-sm-12 col-xs-12">
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
                            <strong>Ms Soundarya G</strong> B.O.T ., MOT
                        </p>
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
                                    <strong>Childhood Interventionist, Infant feeding&Lactation Professional</strong>
                                </u>
                            </span>
                        </p>
                        <p>
                            <strong>J. Nivetha</strong> M.Sc.,ACD; ACLP
                        </p>
                        {!! $headerContent['discharge_report_right'] !!}
                    </td>
                </tr>
            </table>
        </div>
        @endif
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h3 class="print-head">Feeding/Lactation Assessment</h3>
            <span class="pull-right font-bold text-right" style="font-size: 14px;margin-top: 10px;">Date : {!! @$results->visit_date ; !!} {!! strlen(@$results->visit_time) > 1 ? @$results->visit_time : '0' . @$results->visit_time !!}:{!! strlen(@$results->visit_min) > 1 ? @$results->visit_min : '0' . @$results->visit_min !!} {!! @$results->visit_session !!}</span>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="content-block">                
                <h5><b><u>Basic Details</u></b></h5>
                <div class="col-md-7 col-sm-12 col-xs-6">
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
                <div class="col-md-5 col-sm-12 col-xs-6">
                    @if (!empty($results->BirthWeight))
                    <div class="form-group">
                        <span class="print-label-text">Birth Weight(g):</span> 
                        <span class="print-label-value">{!! $results->BirthWeight; !!}</span>
                    </div>  
                    @endif
                    @if (!empty($results->discharge_weight))
                    <div class="form-group">
                        <span class="print-label-text">Discharge Weight(g):</span> 
                        <span class="print-label-value">{!! $results->discharge_weight; !!}</span>
                    </div>  
                    @endif
                    @if (!empty($results->current_weight))
                    <div class="form-group">
                        <span class="print-label-text">Current Weight(g):</span> 
                        <span class="print-label-value">{!! $results->current_weight; !!}</span>
                    </div>  
                    @endif
                    @if($results->g_weeks == 0 || $results->g_weeks > 36 || ($results->g_weeks < 37 && $results->corrected_year > 1))
                    <div class="form-group">
                        <div>
                            <span class="print-label-text">Chronological Age: </span> 
                            {!! empty($results->chronological_year)  ? '<b>0 </b>Year' : ' <b>'.$results->chronological_year .' </b>Years';  !!}
                            {!! empty($results->chronological_month) ? '<b>0 </b>Month' : ' <b>'.$results->chronological_month.' </b>Months';  !!} 
                            {!! empty($results->chronological_days) ? '<b>0 </b>Day' : ' <b>'.$results->chronological_days.' </b>Days';  !!} 
                        </div>
                    </div>
                    @else
                    <div class="form-group">
                        <div>
                            <span class="print-label-text">Chronological Age: </span> 
                            {!! empty($results->chronological_year)  ? ' <b>0 </b>Year' : ' <b>'.$results->chronological_year .' </b>Years';  !!}
                            {!! empty($results->chronological_month) ? ' <b>0 </b>Month' : ' <b>'.$results->chronological_month.' </b>Months';  !!} 
                            {!! empty($results->chronological_days) ? '<b>0 </b>Day' : ' <b>'.$results->chronological_days.' </b>Days';  !!} 
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label-text">Corrected Age:</span> 
                            {!! empty($results->corrected_year)  ? '<b>0 </b>Year' : ' <b>'.$results->corrected_year .' </b>Year(s)';  !!}
                            {!! empty($results->corrected_month) ? '<b>0 </b>Month' : ' <b>'.$results->corrected_month .' </b>Month(s)';  !!} 
                            {!! empty($results->corrected_days) ? '<b>0 </b>Day' : ' <b>'.$results->corrected_days.' </b>Days';  !!} 
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @if (!empty($results->background_details))
            <div class="content-block">
                <div class="form-group">
                    <h5 class="m-0"><strong>Background Details:</h5></strong>
                    <span class="custom-print-label">{!! @$results->background_details; !!}</span>
                </div> 
            </div>
            @endif
            @if (!empty($results->development))
            <div class="content-block">
                <div class="form-group">
                    <h5 class="m-0"><strong>Development:</h5></strong>
                    <span class="custom-print-label">{!! @$results->development; !!}</span>
                </div> 
            </div>
            @endif
            @if ($results->is_parent_concerns && !empty($results->parent_concerns))
            <div class="content-block">
                <div class="form-group">
                    <h5 class="m-0"><strong>Parent Concerns:</h5></strong>
                    <span class="custom-print-label">{!! @$results->parent_concerns; !!}</span>
                </div> 
            </div>
            @endif
            @if ($results->is_current_feeding && !empty($results->current_feeding))
            <div class="content-block">
                <div class="form-group">
                    <h5 class="m-0"><strong>Current Feeding:</h5></strong>
                    <span class="custom-print-label">{!! @$results->current_feeding; !!}</span>
                </div> 
            </div>
            @endif
            @if ($results->is_oral_motor_assessment && !empty($results->oral_motor_assessment))
            <div class="content-block">
                <div class="form-group">
                    <h5 class="m-0"><strong>Oral Motor Assessment:</h5></strong>
                    <span class="custom-print-label">{!! @$results->oral_motor_assessment; !!}</span>
                </div> 
            </div>
            @endif
            @if ($results->is_cranial_nerve_assesment && !empty($results->cranial_nerve_assesment))
            <div class="content-block">
                <div class="form-group">
                    <h5 class="m-0"><strong>Cranial Nerve Assesment:</h5></strong>
                    <span class="custom-print-label">{!! @$results->cranial_nerve_assesment; !!}</span>
                </div> 
            </div>
            @endif
            @if ($results->is_feeding_assesment && !empty($results->feeding_assesment))
            <div class="content-block">
                <div class="form-group">
                    <h5 class="m-0"><strong>Feeding Assesment:</h5></strong>
                    <span class="custom-print-label">{!! @$results->feeding_assesment; !!}</span>
                </div> 
            </div>
            @endif
            @if ($results->is_mothers_examination && !empty($results->mothers_examination))
            <div class="content-block">
                <div class="form-group">
                    <h5 class="m-0"><strong>Mothers Examination:</h5></strong>
                    <span class="custom-print-label">{!! @$results->mothers_examination; !!}</span>
                </div> 
            </div>
            @endif
            @if ($results->is_interpretation && !empty($results->interpretation))
            <div class="content-block">
                <div class="form-group">
                    <h5 class="m-0"><strong>Interpretation:</h5></strong>
                    <span class="custom-print-label">{!! @$results->interpretation; !!}</span>
                </div> 
            </div>
            @endif
            @if (!empty($results->recommendation))
            <div class="content-block">
                <div class="form-group">
                    <h5 class="m-0"><strong>Recommendation:</h5></strong>
                    <span class="custom-print-label">{!! @$results->recommendation; !!}</span>
                </div> 
            </div>
            @endif
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
