@extends('print')
@section('content')
<div class="border-container"></div>
<div class="temp-container" id="admission-container">
    <div class="temp-row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="row">
                <img src="{{ ValuelistHelpers::printPagelogo($results->hospital_name) }}" >
                <h3 class="print-head">Pediatric Admission Proforma</h3>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="row">
                <div class="content-block">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <div class="row">
                                    <h4>BASIC DETAILS:</h4>
                                    <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                                        <div class="row plr-10">
                                            <table class="table-layout-fixed">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <span class="font-weight-bold">{{ Lang::get('home.mrn') }}:</span>
                                                            <span>{!! $results->BMrNo; !!}</span>
                                                        </td>
                                                        <td>
                                                            <span class="font-weight-bold">Baby Name:</span>
                                                            <span>{!! $results->BabyName; !!}</span>
                                                        </td>
                                                        <td>
                                                            <span class="font-weight-bold">DOB:</span>
                                                            <span>{!! $results->DOB; !!}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="font-weight-bold">Sex:</span>
                                                            <span>{!! $results->Sex; !!}</span>
                                                        </td>
                                                        <td colspan="2">
                                                            <span class="font-weight-bold">Mother Name:</span>
                                                            <span>{!! $results->MotherName; !!}</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table-layout-fixed">
                                                <tbody>
                                                    @if((isset($results->referred_by) && !empty($results->referred_by)) || (isset($results->referral_reason) && !empty($results->referral_reason)))
                                                    <tr>
                                                        @if(isset($results->referred_by) && !empty($results->referred_by))
                                                        <td>
                                                            <span class="font-weight-bold">Referred From:</span>
                                                            <span>{!! $results->referred_by; !!}</span>
                                                        </td>
                                                        @endif
                                                        @if(isset($results->referral_reason) && !empty($results->referral_reason))
                                                        <td>
                                                            <span class="font-weight-bold">Referral Reason:</span>
                                                            <span>{!! $results->referral_reason; !!}</span>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <div class="row">
                                    <h4>ADMISSION DETAILS:</h4>
                                    <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                                        <div class="row">
                                            <table class="table-layout-fixed">
                                                <tr>
                                                    <td>
                                                        <span class="font-weight-bold">{{ Lang::get('home.ip') }}:</span>
                                                        <span>{!! $results->ip_number; !!}</span>
                                                    </td>
                                                    <td>
                                                        <span class="font-weight-bold">Type Of Care:</span>
                                                        <span>{!! $results->type_of_care; !!}</span>
                                                    </td>
                                                    <td>
                                                        <span class="font-weight-bold">Admission At:</span>
                                                        <span>{!! $results->admission_date_time; !!}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="font-weight-bold">Admission Weight (kg):</span>
                                                        <span>{!! (is_numeric($results->current_weight) && $results->current_weight > 0) ? $results->current_weight / 1000 : ''; !!}</span>
                                                    </td>
                                                    @if(isset($results->seen_by) && !empty($results->seen_by) && isset($mas_doctors_list[$results->seen_by]))
                                                    <td>
                                                        <span class="font-weight-bold">Seen By:</span>
                                                        <span>{!! $mas_doctors_list[$results->seen_by]; !!}</span>
                                                    </td>
                                                    @endif
                                                    <td>
                                                        <span class="font-weight-bold">Initial Assessment Completed At:</span>
                                                        <span>{!! $results->assessment_date_time; !!}</span>
                                                    </td>
                                                </tr>
                                                @if(isset($results->surgeon) && !empty($results->surgeon) && $results->surgeon != 'N/A')
                                                <tr>
                                                    <td colspan="3">
                                                        <span class="font-weight-bold">Surgeon:</span>
                                                        <span>{!! $results->surgeon; !!}</span>
                                                    </td>
                                                </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
                <div class="clearfix"></div>
                @if (!empty($results->complaints) && strip_tags($results->complaints) != '')
                <div class="content-block">
                    <h4>COMPLAINTS:</h4>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row">
                            <div class="editor-container">
                                {!! $results->complaints; !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                @endif
                @if (!empty($results->hopi) && strip_tags($results->hopi) != '')
                <div class="content-block">
                    <h4>HISTORY OF PRESENT ILLNESS:</h4>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row">
                            <div class="editor-container">
                                {!! $results->hopi; !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                @endif
                @if (!empty($results->treatment_history) && strip_tags($results->treatment_history) != '')
                <div class="content-block">
                    <h4>TREATMENT HISTORY:</h4>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row">
                            <div class="editor-container">
                                {!! $results->treatment_history; !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                @endif
                @if (!empty($results->past_history) && strip_tags($results->past_history) != '')
                <div class="content-block">
                    <h4>PAST HISTORY:</h4>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row">
                            <div class="editor-container">
                                {!! $results->past_history; !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                @endif
                @if (!empty($results->perinatal_history) && strip_tags($results->perinatal_history) != '')
                <div class="content-block">
                    <h4>PERINATAL HISTORY:</h4>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row">
                            <div class="editor-container">
                                {!! $results->perinatal_history; !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                @endif
                @if (!empty($results->immunization) && strip_tags($results->immunization) != '')
                <div class="content-block">
                    <h4>IMMUNIZATION:</h4>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row">
                            <div class="editor-container">
                                {!! $results->immunization; !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                @endif
                @if (!empty($results->development) && strip_tags($results->development) != '')
                <div class="content-block">
                    <h4>DEVELOPMENT:</h4>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row">
                            <div class="editor-container">
                                {!! $results->development; !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                @endif
                @if (!empty($results->family_history) && strip_tags($results->family_history) != '')
                <div class="content-block">
                    <h4>FAMILY HISTORY:</h4>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row">
                            <div class="editor-container">
                                {!! $results->family_history; !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                @endif
                @php $e = $v = $a = false; @endphp
                @if ($results->stage != 0 || $results->gpallor != 0 || $results->ihm != 0 || $results->cyanosis != 0 || $results->clubby != 0 || $results->glymphadenopathy != 0 || $results->pedal_edema != 0 || (!empty($results->general_examination) && strip_tags($results->general_examination) != ''))
                @php $e = true; @endphp
                @endif
                @if ((isset($results->hr) && !empty($results->hr)) || (isset($results->pulse_volume) && !empty($results->pulse_volume)) || (isset($results->bp) && !empty($results->bp)) || (isset($results->temperature_f) && !empty($results->temperature_f)) || (isset($results->spo2) && !empty($results->spo2)) || (isset($results->cft) && !empty($results->cft)) || (!empty($results->vitals_content) && strip_tags($results->vitals_content) != ''))
                @php $v = true; @endphp
                @endif
                @if ((isset($results->current_weight) && !empty($results->current_weight)) || (isset($results->current_height) && !empty($results->current_height)) || (isset($results->current_hc) && !empty($results->current_hc)) || (isset($results->current_bmi) && !empty($results->current_bmi)) || (isset($results->current_bsa) && (!empty($results->current_bsa)) || !empty($results->anthropometry_content) && strip_tags($results->anthropometry_content) != ''))
                @php $a = true; @endphp
                @endif
                @if($e || $v || $a)
                <div class="content-block">
                    <h4>GENERAL EXAMINATION:</h4>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row plr-10">
                            @if($e)
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                                        <div class="row">
                                            <table class="table-layout-fixed">
                                                <tbody>
                                                    <tr>
                                                        @if ($results->stage != 0)
                                                        <td>
                                                            <span class="font-weight-bold">Status:</span>
                                                            <span>{!! $results->stage == 1 ? 'Alert' : 'Awake' !!}</span>
                                                        </td>
                                                        @endif
                                                        @if ($results->gpallor != 0)
                                                        <td>
                                                            <span class="font-weight-bold">Pallor:</span>
                                                            <span>{!! $yes_or_no[$results->gpallor]; !!}</span>
                                                        </td>
                                                        @endif
                                                        @if ($results->ihm != 0)
                                                        <td>
                                                            <span class="font-weight-bold">Icterus:</span>
                                                            <span>{!! $yes_or_no[$results->ihm]; !!}</span>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        @if ($results->cyanosis != 0)
                                                        <td>
                                                            <span class="font-weight-bold">Cyanosis:</span>
                                                            <span>{!! $yes_or_no[$results->cyanosis]; !!}</span>
                                                        </td>
                                                        @endif
                                                        @if ($results->clubby != 0)
                                                        <td>
                                                            <span class="font-weight-bold">Clubbing:</span>
                                                            <span>{!! $yes_or_no[$results->clubby]; !!}</span>
                                                        </td>
                                                        @endif
                                                        @if ($results->glymphadenopathy != 0)
                                                        <td>
                                                            <span class="font-weight-bold">Lymphadenopathy:</span>
                                                            <span>{!! $yes_or_no[$results->glymphadenopathy]; !!}</span>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        @if ($results->pedal_edema != 0)
                                                        <td>
                                                            <span class="font-weight-bold">Pedal edema:</span>
                                                            <span>{!! $yes_or_no[$results->pedal_edema]; !!}</span>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @if (!empty($results->general_examination) && strip_tags($results->general_examination) != '')
                                    <div class="clearfix"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="row plr-5">
                                            <div>
                                                <div><b>Additional Findings:</b></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">{!! $results->general_examination; !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            @endif
                            @if($v)
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="row plr-5">
                                    <h4>VITALS:</h4>
                                    <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                                        <div class="row plr-10">
                                            <table class="table-layout-fixed">
                                                <tbody>
                                                    <tr>
                                                        @if(isset($results->hr) && !empty($results->hr))
                                                        <td>
                                                            <span class="font-weight-bold">Heart Rate:</span>
                                                            <span>{!! $results->hr; !!} BPM</span>
                                                        </td>
                                                        @endif                    
                                                        @if(isset($results->pulse_volume) && !empty($results->pulse_volume))
                                                        <td>
                                                            <span class="font-weight-bold">Volume Pulse:</span>
                                                            <span>{!! $results->pulse_volume; !!}</span>
                                                        </td>
                                                        @endif
                                                        @if(isset($results->bp) && !empty($results->bp))
                                                        <td>
                                                            <span class="font-weight-bold">Blood Pressure:</span>
                                                            <span>{!! $results->bp; !!} mmHg</span>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        @if(isset($results->temperature_f) && !empty($results->temperature_f))
                                                        <td>
                                                            <span class="font-weight-bold">Temperature:</span>
                                                            <span>{!! $results->temperature_f; !!} F</span>
                                                        </td>
                                                        @endif                    
                                                        @if(isset($results->spo2) && !empty($results->spo2))
                                                        <td>
                                                            <span class="font-weight-bold">SpO2:</span>
                                                            <span>{!! $results->spo2; !!} %</span>
                                                        </td>
                                                        @endif
                                                        @if(isset($results->cft) && !empty($results->cft))
                                                        <td>
                                                            <span class="font-weight-bold">Capillary Refill Time:</span>
                                                            <span>{!! $results->cft; !!}</span>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                </tbody>                                        
                                            </table>
                                        </div>
                                    </div>
                                    @if(!empty($results->vitals_content) && strip_tags($results->vitals_content) != '')
                                    <div class="clearfix"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="row plr-15">
                                            <div class="mt-5">
                                                <div><b>Additional Findings:</b></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">{!! $results->vitals_content; !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            @endif
                            @if($a)
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="row plr-5">
                                    <h4>ANTHROPOMETRY:</h4>
                                    <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                                        <div class="row plr-10">
                                            <table class="table-layout-fixed">
                                                <tbody>
                                                    <tr>
                                                        @if(isset($results->current_weight) && !empty($results->current_weight) && is_numeric($results->current_weight) && $results->current_weight > 0)
                                                        <td>
                                                            <span class="font-weight-bold">Weight (Kg):</span>
                                                            <span>{!! $results->current_weight / 1000; !!}</span>
                                                        </td>
                                                        @endif
                                                        @if(isset($results->current_height) && !empty($results->current_height))
                                                        <td>
                                                            <span class="font-weight-bold">Length/Height (cm):</span>
                                                            <span>{!! $results->current_height; !!}</span>
                                                        </td>
                                                        @endif
                                                        @if(isset($results->current_head_circumference) && !empty($results->current_head_circumference))
                                                        <td>
                                                            <span class="font-weight-bold">Head Circumference (cm):</span>
                                                            <span>{!! $results->current_head_circumference; !!}</span>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        @if(isset($results->current_bmi) && !empty($results->current_bmi))
                                                        <td>
                                                            <span class="font-weight-bold">Body Mass Index:</span>
                                                            <span>{!! $results->current_bmi; !!}</span>
                                                        </td>
                                                        @endif
                                                        @if(isset($results->current_bsa) && !empty($results->current_bsa))
                                                        <td>
                                                            <span class="font-weight-bold">Body Surface Area:</span>
                                                            <span>{!! $results->current_bsa; !!}</span>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @if(!empty($results->anthropometry_content) && strip_tags($results->anthropometry_content) != '')
                                    <div class="clearfix"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="row plr-15">
                                            <div class="mt-5">
                                                <div><b>Additional Findings:</b></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">{!! $results->anthropometry_content; !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
                @endif
                @php $cs = $rs = $cns = $ad = false; @endphp
                @if(isset($results->cvs) && !empty($results->cvs) || (isset($results->precordial_activity) && !empty($results->precordial_activity)) || (isset($results->s1s2) && !empty($results->s1s2)) || (isset($results->apical_impulse) && !empty($results->apical_impulse)) || (isset($results->bounding_pulses) && !empty($results->bounding_pulses)) || (isset($results->murmur) && !empty($results->murmur)) || (isset($results->character_of_murmur) && !empty($results->character_of_murmur)) || (!empty($results->cvs_findings) && strip_tags($results->cvs_findings) != ''))
                @php $cs = true; @endphp
                @endif
                @if((isset($results->rs) && !empty($results->rs)) || (isset($results->chest_movement) && !empty($results->chest_movement)) || (isset($results->air_entry) && !empty($results->air_entry)) || (isset($results->breath_sounds) && !empty($results->breath_sounds)) || (isset($results->added_sounds) && !empty($results->added_sounds)) || (isset($results->character_of_added_sounds) && !empty($results->character_of_added_sounds)) || (isset($results->site_of_added_sounds) && !empty($results->site_of_added_sounds))|| (!empty($results->rs_findings) && strip_tags($results->rs_findings) != ''))
                @php $rs = true; @endphp
                @endif
                @if((isset($results->cns_stage) && !empty($results->cns_stage)) || (isset($results->cn_meningeal_signs) && !empty($results->cn_meningeal_signs)) || (isset($results->cn_exam) && !empty($results->cn_exam)) || (isset($results->ms_exam) && !empty($results->ms_exam)) || (!empty($results->ms_findings) && strip_tags($results->ms_findings) != '') || (isset($results->deep_tendon) && !empty($results->deep_tendon)) || (!empty($results->deep_tendon_findings) && strip_tags($results->deep_tendon)) || (!empty($results->cns_findings) && strip_tags($results->cns_findings) != '') || ($results->eye_opening > 0 || $results->verbal > 0 || $results->motor > 0))
                @php $cns = true; @endphp
                @endif
                @if((isset($results->abdomen_status) && !empty($results->abdomen_status)) || (isset($results->skin_over_abdomen) && !empty($results->skin_over_abdomen)) || (isset($results->air_entry) && !empty($results->air_entry)) || (isset($results->Palpation) && !empty($results->Palpation)) || (isset($results->added_sounds) && !empty($results->added_sounds)) || (isset($results->abdomen_findings) && !empty($results->abdomen_findings) && strip_tags($results->abdomen_findings) != ''))
                @php $ad = true; @endphp
                @endif

                @if($cs || $rs || $cns || $ad)
                <div class="content-block">
                    <h4 class="mb-0">SYSTEMATIC EXAMINATION:</h4>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row plr-10">
                            @if($cs)
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="row plr-5">
                                    <h4>CARDIOVASCULAR SYSTEM:</h4>
                                    <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                                        <div class="row plr-10">
                                            <table class="table-layout-fixed">
                                                <tbody>
                                                    <tr>
                                                        @if(isset($results->cvs) && !empty($results->cvs))
                                                        <td>
                                                            <span class="font-weight-bold">Status:</span>
                                                            <span>{!! $results->cvs; !!}</span>
                                                        </td>
                                                        @endif
                                                        @if(isset($results->precordial_activity) && !empty($results->precordial_activity))
                                                        <td>
                                                            <span class="font-weight-bold">Precordial Activity:</span>
                                                            <span>{!! $results->precordial_activity; !!}</span>
                                                        </td>
                                                        @endif
                                                        @if(isset($results->s1s2) && !empty($results->s1s2))
                                                        <td>
                                                            <span class="font-weight-bold">S1S2:</span>
                                                            <span>{!! $results->s1s2; !!}</span>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        @if(isset($results->apical_impulse) && !empty($results->apical_impulse))
                                                        <td>
                                                            <span class="font-weight-bold">Apical Impulse:</span>
                                                            <span>{!! $results->apical_impulse; !!}</span>
                                                        </td>
                                                        @endif
                                                        @if(isset($results->murmur) && !empty($results->murmur))
                                                        <td>
                                                            <span class="font-weight-bold">Murmur:</span>
                                                            <span>{!! $results->murmur; !!}</span>
                                                        </td>
                                                        @endif
                                                        @if(isset($results->character_of_murmur) && !empty($results->character_of_murmur))
                                                        <td>
                                                            <span class="font-weight-bold">Character of Murmur:</span>
                                                            <span>{!! $results->character_of_murmur; !!}</span>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    @if (!empty($results->cvs_findings) && strip_tags($results->cvs_findings) != '')
                                    <div class="clearfix"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="row plr-15">
                                            <div class="mt-5">
                                                <div><b>Other CVS Findings:</b></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">{!! $results->cvs_findings; !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            @endif
                            @if($rs)
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="row plr-5">
                                    <h4>RESPIRATORY SYSTEM:</h4>
                                    <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                                        <div class="row plr-10">
                                            <table class="table-layout-fixed">
                                                <tbody>
                                                    <tr>
                                                        @if(isset($results->rs) && !empty($results->rs))
                                                        <td>
                                                            <span class="font-weight-bold">Status:</span>
                                                            <span>{!! $results->rs; !!}</span>
                                                        </td>
                                                        @endif
                                                        @if(isset($results->chest_movement) && !empty($results->chest_movement))
                                                        <td>
                                                            <span class="font-weight-bold">Chest Movement:</span>
                                                            <span>{!! $results->chest_movement; !!}</span>
                                                        </td>
                                                        @endif
                                                        @if(isset($results->air_entry) && !empty($results->air_entry))
                                                        <td>
                                                            <span class="font-weight-bold">Air Entry:</span>
                                                            <span>{!! $results->air_entry; !!}</span>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        @if(isset($results->breath_sounds) && !empty($results->breath_sounds))
                                                        <td>
                                                            <span class="font-weight-bold">Breath Sounds:</span>
                                                            <span>{!! $results->breath_sounds; !!}</span>
                                                        </td>
                                                        @endif
                                                        @if(isset($results->added_sounds) && !empty($results->added_sounds))
                                                        <td>
                                                            <span class="font-weight-bold">Added Sounds:</span>
                                                            <span>{!! $results->added_sounds; !!}</span>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table-layout-fixed">                                                
                                                <tr>
                                                    @if(isset($results->character_of_added_sounds) && !empty($results->character_of_added_sounds))
                                                    <td>
                                                        <span class="font-weight-bold">Character Of Added Sounds:</span>
                                                        <span>{!! $results->character_of_added_sounds; !!}</span>
                                                    </td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if(isset($results->site_of_added_sounds) && !empty($results->site_of_added_sounds))
                                                    <td>
                                                        <span class="font-weight-bold">Site of Added Sounds:</span>
                                                        <span>{!! $results->site_of_added_sounds; !!}</span>
                                                    </td>
                                                    @endif
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    @if(!empty($results->rs_findings) && strip_tags($results->rs_findings) != '')
                                    <div class="clearfix"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="row plr-15">
                                            <div class="mt-5">
                                                <div><b>Other RS Findings:</b></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">{!! $results->rs_findings; !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            @endif

                            @if($cns)
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="row plr-5">
                                    <h4>CENTRAL NERVOUS SYSTEM:</h4>
                                    <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                                        <div class="row plr-10">
                                            <table class="table-layout-fixed">
                                                <tbody>
                                                    <tr>
                                                        @if(isset($results->cns_stage) && !empty($results->cns_stage))
                                                        @php $status =  json_decode($results->cns_stage); @endphp
                                                        <td>
                                                            <span class="font-weight-bold">Status:</span>
                                                            <span>{!! implode(', ', $status) !!}</span>
                                                        </td>
                                                        @endif
                                                        @if(isset($results->cn_meningeal_signs) && !empty($results->cn_meningeal_signs))
                                                        <td>
                                                            <span class="font-weight-bold">Meningeal signs:</span>
                                                            <span>{!! $yes_or_no[$results->cn_meningeal_signs] !!}</span>
                                                        </td>
                                                        @endif
                                                        @if(isset($results->cn_exam) && !empty($results->cn_exam))
                                                        <td>
                                                            <span class="font-weight-bold">Cranial Nerve Examination:</span>
                                                            <span>
                                                                @if($results->cn_exam == 0) N/A @elseif($results->cn_exam == 1) Normal @else Abnormal @endif
                                                            </span>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                </tbody>
                                            </table>
                                            @if ($results->eye_opening > 0 || $results->verbal > 0 || $results->motor > 0)
                                            <table class="table-layout-fixed">
                                                <tbody>                                                    
                                                    <tr>
                                                        <td>
                                                            <?php 
                                                                if ($results->verbal == '') {
                                                                    $results->verbal = 0;
                                                                }

                                                                if ($results->motor == '') {
                                                                     $results->motor = 0;
                                                                 } 
                                                            ?>
                                                            <h4 class="display-inline-block">GCS</h4> - ({!! $results->eye_opening + $results->verbal + $results->motor !!} / 15)&ensp;
                                                            <strong>E</strong>-{!! $results->eye_opening !!}&ensp;
                                                            <strong>V</strong>-{!! $results->verbal !!}&ensp;
                                                            <strong>M</strong>-{!! $results->motor !!}&ensp;
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            @endif
                                            <table class="table-layout-fixed">
                                                <tbody>
                                                    <tr>
                                                        @if(isset($results->ms_exam) && !empty($results->ms_exam))
                                                        <td>
                                                            <span class="font-weight-bold">Motor System Examination:</span>
                                                            <span>
                                                                @if($results->ms_exam == 0) N/A @elseif($results->ms_exam == 1) Normal @else Abnormal @endif
                                                            </span>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                    @if(!empty($results->ms_findings) && strip_tags($results->ms_findings) != '')
                                                    <tr>
                                                        <td class="font-weight-bold">Motor System Findings:</td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @if(!empty($results->ms_findings) && strip_tags($results->ms_findings) != '')
                                    <div class="clearfix"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="row plr-15">
                                            <div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">{!! $results->ms_findings; !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="clearfix"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                                        <div class="row plr-10">
                                            <table class="table-layout-fixed">
                                                <tbody>
                                                    <tr>
                                                        @if(isset($results->deep_tendon) && !empty($results->deep_tendon))
                                                        <td>
                                                            <span class="font-weight-bold">Deep Tendon Reflex(DTR):</span>
                                                            <span>
                                                                @if($results->deep_tendon == 0) N/A @elseif($results->deep_tendon == 1) Normal @else Abnormal @endif
                                                            </span>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                    @if(!empty($results->deep_tendon_findings) && strip_tags($results->deep_tendon_findings) != '')
                                                    <tr>
                                                        <td class="font-weight-bold">DTR Additional Findings:</td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @if(!empty($results->deep_tendon_findings) && strip_tags($results->deep_tendon_findings) != '')
                                    <div class="clearfix"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="row plr-15">
                                            <div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">{!! $results->deep_tendon_findings; !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if(!empty($results->cns_findings) && strip_tags($results->cns_findings) != '')
                                    <div class="clearfix"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="row plr-15">
                                            <div class="mt-5">
                                                <div><b>Other CNS Findings:</b></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">{!! $results->cns_findings; !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            @endif
                            @if($ad)
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="row plr-5">
                                    <h4>ABDOMEN:</h4>
                                    <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                                        <div class="row plr-10">
                                            <table class="table-layout-fixed">
                                                <tbody>
                                                    <tr>
                                                        @if(isset($results->abdomen_status) && !empty($results->abdomen_status))
                                                        <td>
                                                            <span class="font-weight-bold">Status:</span>
                                                            <span>
                                                                @if ($results->abdomen_status == 1)
                                                                Distended
                                                                @elseif ($results->abdomen_status == 2)
                                                                Not Distended 
                                                                @else
                                                                N/A
                                                                @endif
                                                            </span>
                                                        </td>
                                                        @endif
                                                        @if(isset($results->skin_over_abdomen) && !empty($results->skin_over_abdomen))
                                                        <td>
                                                            <span class="font-weight-bold">Skin Over Abdomen:</span>
                                                            <span>
                                                                @if ($results->skin_over_abdomen == 1)
                                                                Normal
                                                                @elseif ($results->skin_over_abdomen == 2)
                                                                Visible Gastric Pinstalims 
                                                                @elseif ($results->skin_over_abdomen == 3)
                                                                Umbilicus - Normal 
                                                                @else
                                                                N/A
                                                                @endif
                                                            </span>
                                                        </td>
                                                        @endif
                                                        @if((isset($results->palpation_soft) && $results->palpation_soft) || (isset($results->palpation_rigidity) && $results->palpation_rigidity) || (isset($results->palpation_guarding) && $results->palpation_guarding) || (isset($results->palpation_tender) && $results->palpation_tender) || (isset($results->palpation_non_tender) && $results->palpation_non_tender))
                                                        <td>
                                                            <span class="font-weight-bold">Palpation:</span>
                                                            <span>
                                                                {!! $results->palpation_soft ? 'Soft' : ''; !!}
                                                                {!! $results->palpation_rigidity ? 'Rigidity' : ''; !!}
                                                                @if ($results->palpation_rigidity && $results->palpation_guarding)
                                                                <span>, </span>
                                                                {!! $results->palpation_guarding ? 'Guarding' : ''; !!}
                                                                @endif
                                                            </span>
                                                            @if (($results->palpation_soft || $results->palpation_rigidity || $results->palpation_guarding) && ($results->palpation_tender || $results->palpation_non_tender))
                                                            <span>, </span>
                                                            {!! $results->palpation_tender ? 'Tender' : ''; !!}
                                                            {!! $results->palpation_non_tender ? 'Non Tender' : ''; !!}
                                                            @endif
                                                        </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        @if(isset($results->liver) && !empty($results->liver))
                                                        <td>
                                                            <span class="font-weight-bold">Liver:</span>
                                                            <span>
                                                                @if ($results->liver == 1)
                                                                Palpation
                                                                {!! $results->liver_palpation_value !!} <span>cm below <i class="fa fa-right" aria-hidden="true"></i> sub costal margin</span>
                                                                @elseif ($results->liver == 2)
                                                                Non-Palpation
                                                                @else
                                                                N/A
                                                                @endif
                                                            </span>
                                                        </td>
                                                        @endif
                                                        @if(isset($results->spleen) && !empty($results->spleen))
                                                        <td>
                                                            <span class="font-weight-bold">Spleen:</span>
                                                            <span>
                                                                @if ($results->spleen == 1)
                                                                Palpation
                                                                {!! $results->spleen_palpation_value !!} <span>cm below <i class="fa fa-left" aria-hidden="true"></i> sub costal margin</span>
                                                                @elseif ($results->spleen == 2)
                                                                Non-Palpation
                                                                @else
                                                                N/A
                                                                @endif
                                                            </span>
                                                        </td>
                                                        @endif
                                                        @if(isset($results->spleen) && !empty($results->spleen))
                                                        <td>
                                                            <span class="font-weight-bold">External Genitalia:</span>
                                                            <span>
                                                                @if ($results->external_genitalia == 1)
                                                                Normal
                                                                @else
                                                                N/A
                                                                @endif
                                                            </span>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @if(isset($results->abdomen_findings) && !empty($results->abdomen_findings))
                                    <div class="clearfix"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="row plr-15">
                                            <div class="mt-5">
                                                <div><b>Additional Findings:</b></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">{!! $results->abdomen_findings; !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                @endif
                @if (!empty($results->investigations) || !empty($results->investigations_test) || (!empty($results->treatment) && strip_tags($results->treatment) != ''))
                <div class="content-block">
                    <h4>PLANS:</h4>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row plr-15">
                            @if (!empty($results->investigations_test))
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="row">
                                    <div>
                                        <div><b>Investigations:</b></div>
                                        <div class="pl-15">{!! $results->investigations_test; !!}</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if (!empty($results->investigations_test))
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="row">
                                    <div>
                                        <div><b>Treatment:</b></div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 editor-container">{!! $results->treatment; !!}</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                @endif
                 @if (!empty($results->working_diagnosis) && strip_tags($results->working_diagnosis) != '')
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h6>
                            <span class="custom-heading">WORKING DIAGNOSIS:</span>
                        </h6>
                        <div class="col-xs-12 col-sm-12 col-md-12 editor-container">
                            {!! $results->working_diagnosis; !!}
                        </div>
                    </div>
                @endif
                @if(isset($results->admission_entered_by) && !empty($results->admission_entered_by))
                <div class="content-block">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row">
                            <div>
                                <h5><strong>Admission proforma done by:</strong> {{ $mas_doctors_list[$results->admission_entered_by] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                @endif
                @if(isset($results->admission_entered_by) && !empty($results->admission_entered_by))
                <div class="content-block">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-xs-3 col-md-3 col-sm-3 pull-left page-break-page mtb-15">
                                <div class="row">
                                    <ul class="plr-must-0 list-none">
                                        <li>Date : {!! $results->admission_date; !!}</li>
                                        <li>Place : {!! env('LOCATION') !!} </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xs-9 col-md-9 col-sm-9 page-break-page mtb-15 pull-right">
                                {!! $results->pediatric_consultant !!}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
