@extends('print')
@section('content')
@php 
$site_url = url('/').'/public';
$frequency_list = ValuelistHelpers::drugFrequencyList();
@endphp
<style type="text/css">
    .px-20{
        padding: 0px 20px;
    }
    .p-15-must {
        padding: 15px;
    }
    .ui-datepicker {
        z-index: 1050 !important;
    }
    .print table.ui-datepicker-calendar td, .print table.ui-datepicker-calendar th {
        padding: 3px !important;
    }
</style>
<div class="temp-container" id="summary-container">
    <div class="temp-row">
        <!-- BEGIN HEADER CONTENT -->
        <div class="ml-15 @if(isset($headerContent['header_required']) && $headerContent['header_required'] == 1) hide @endif">
            <img src="{!! \ValuelistHelpers::printPagelogo($results->hospital_name) !!}" class="logo-align">
            @if ($results->hospital_name != 'Sudha Hospital' && $results->hospital_name != 'Saraswathi Nursing Home')
            <img src="{{url('public/img/nabh.png')}}" class="pull-right mr-15 nabh-logo">
            @endif
        </div>
        <div class="@if(isset($headerContent['header_required']) && $headerContent['header_required'] == 1) hide @endif mb-15 ml-15">
            <h5 class="mt-0"><strong>{!! \ValuelistHelpers::getHospitalsDetails($results->hospital_name, $headerContent) !!}</strong> </h5>
        </div>
        <div id="patient-list" class="@if(isset($headerContent['header_required']) && $headerContent['header_required'] == 1) header-down @endif">
            <div id="company">
                <span class="fs-16"> {!! $headerContent['discharge_report_right'] !!}</span>
            </div>
        </div>
        <div id="doctor-list">
            <div id="project">
                
                @php
                   $header_content = \ValuelistHelpers::headerContent($results->hospital_name, $headerContent);
                   $header_content = str_replace("<p><strong>Dr S. Ramakrishnan</strong> <strong>&nbsp;</strong>MRCPCH (UK), MRCP (IRE), DCH(UK), DIP PN (LON), Neonatal Fellowship (LON)</p>","",$header_content);
                   $header_content = str_replace("<p><strong>Dr&nbsp;Sivaranjani Sendilkumar</strong> MBBS.,MD(Pediatrics), DNB( Pediatrics)., DM( Neonatology)</p>","",$header_content)
                @endphp
                {!! $header_content !!}
            </div>
        </div>
        
        <div class="border-container"></div>
        <h5 class="text-center">
            <strong>
            @if (str_contains($results->status,'Died'))
            Death
            @else
            Discharge 
            @endif
            Summary
        </strong> 
        </h5>
            {!! Form::hidden('id', $results->id) !!}

                @if (isset($results->surgeon) && is_array($results->surgeon) && array_filter($results->surgeon,function($value) { return $value > 0; }))
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="row mb-15">
                        <span class="pull-left col-xs-12 pb-15"><b><u>Paediatric Surgeon :</u></b></span>
                        <div class="col-xs-12">
                            <ul class="list-none p-0">
                                @foreach ($results->surgeon as $value)
                                    @if ($value > 0)
                                        <li>{{ ValuelistHelpers::mas_surgeon_list($value) }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                
                </div>
            @endif

            <div class="col-xs-12 col-sm-12 col-md-12">
                @if (!empty($results->status))
                <div class="col-xs-12 col-sm-12 col-md-12">
                    
                    <!-- <div class="col-md-6">
                            Visit No: {{ $results->ip_number }}
                            @if (!empty($results->admission_date))              
                            <br>              
                            Admission Date: {{ date('d-m-Y', strtotime($results->admission_date)) }}
                            @endif
                        </div> -->
                        
                            <div class="pull-right">
                                <span>Status: {!! $results->status !!}</span>
                                @if ($results->status != 'Inpatient')
                                <br>
                                <span>Date: {!! $results->status_date !!} @if(isset($results->status_time) && !empty($results->status_time)) {!! $results->status_time !!} @endif</span>
                                @endif
                            </div>
                        
                    
                </div>
                @endif
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="row">
                        <hr class="summary-hr">
                    </div>
                </div>
            </div>
        

        <!-- END HEADER CONTENT -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page baby-basic-details">
                <h6 class="mt-0">
                    <span class="check-box-div">
                        {!! Form::checkbox('hide', null) !!}
                        <label><span></span></label>
                    </span>
                    <span class="custom-heading">Baby Details:</span>
                </h6>
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <span class="print-label">{{ Lang::get('home.mrn') }}:</span>
                                <span class="print-value">{!! $results->BMrNo; !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Name:</span>
                                <span class="print-value">{!! $results->BabyName; !!}</span>
                            </div>
                           
                            <div class="form-group">
                                <span class="print-label">DOB:</span>
                                <span class="print-value">{!! $results->DOB; !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Sex:</span>
                                <span class="print-value">{!! $results->Sex; !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Mother Name:</span>
                                <span class="print-value">{!! $results->MotherName; !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Age:</span>
                                    @php 
                                    $age = \SiteHelpers::dateDifferents(date('Y-m-d', strtotime($results->DOB))); 
                                    $year = $age['Year'] > 0 ? $age['Year'] . ' Y ' : '';
                                    $month = $age['Month'] > 0 ? $age['Month'] . ' M ' : '';
                                    $day = $age['Day'] > 0 ? $age['Day'] . ' D ' : '';
                                    @endphp
                                <span class="print-value">{!! $year; !!}{!! $month; !!}{!! $day; !!}</span>
                            </div>
                          
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <span class="print-label">{{ Lang::get('home.ip') }}:</span>
                                <span class="print-value">{{ $results->ip_number }}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Date of Admission:</span>
                                <span class="print-value">{{ date('d-m-Y', strtotime($results->admission_date)) }}</span>
                            </div>

                              <div class="form-group">
                                <span class="print-label">Admission Weight:</span>
                                <span class="print-value">{!! (is_numeric($results->current_weight) && $results->current_weight > 0) ? ($results->current_weight / 1000) .' KG': ''; !!}
                                </span>
                            </div>
                            
                             @if((isset($results->referred_by) && !empty($results->referred_by)) || (isset($results->referral_reason) && !empty($results->referral_reason)))
                                <div class="form-group">
                                    @if(isset($results->referred_by) && !empty($results->referred_by))
                                    <span class="print-label">Referred From::</span>
                                    <span class="print-value">{!! $results->referred_by; !!}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    @if(isset($results->referral_reason) && !empty($results->referral_reason))

                                    <span class="print-label">Referral Reason:</span>
                                    <span class="print-value">{!! $results->referral_reason; !!} </span>
                                    @endif
                                </div>
                                @endif

                            @if($results->status == 'Died' || $results->status == 'Died (OCNR)')
                                <div class="form-group">
                                    <span class="print-label">Date of Death:</span>
                                    <span class="print-value">{!! $results->status_date !!}</span>
                                </div>
                            @else
                            @if($results->status == 'Inpatient')
                                <div class="form-group">
                                    <span class="print-label">Current Date:</span>
                                    <span class="print-value">{!! $results->admission_date !!}</span>
                                </div>
                            @else
                                <div class="form-group">
                                    <span class="print-label">Date of Discharge:</span>
                                    <span class="print-value">{!! $results->status_date !!}</span>
                                </div>
                            @endif
                            @endif
                                <div class="form-group">
                                    <span class="print-label">Discharge Weight (In Kg):</span>
                                    <span class="print-value">{!! $results->status_weight !!}</span>
                                </div>

            
                        </div>
                            
                           
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="col-md-12 col-sm-12 col-xs-12 col-lg-6">
                <h6>
                    <span class="custom-heading">ADMISSION DETAILS:</span>
                </h6>
                <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                    <div class="row pl-must-10">
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
                                <td colspan="2">
                                    <span class="font-weight-bold">Seen By:</span>
                                    <span>{!! $mas_doctors_list[$results->seen_by]; !!}</span>
                                </td>
                                @endif
                            </tr>

                        </table>
                    </div>
                </div>
            </div> -->

            @if (!empty($results->working_diagnosis) && strip_tags($results->working_diagnosis) != '')
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h6>
                    <span class="custom-heading">FINAL DIAGNOSIS:</span>
                </h6>
                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">
                    {!! $results->working_diagnosis; !!}
                </div>
            </div>
            @endif
            @if (!empty($results->complaints) && strip_tags($results->complaints) != '')
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h6>
                    <span class="custom-heading">COMPLAINTS:</span>
                </h6>
                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">
                    {!! $results->complaints; !!}
                </div>
            </div>
            @endif
            @if (!empty($results->hopi) && strip_tags($results->hopi) != '')
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h6>
                    <span class="custom-heading">HISTORY OF PRESENT ILLNESS:</span>
                </h6>
                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">
                    {!! $results->hopi !!}
                </div>
            </div>
            @endif
            @if (!empty($results->treatment_history) && strip_tags($results->treatment_history) != '')
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h6>
                    <span class="custom-heading">Treatment History:</span>
                </h6>
                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">
                    {!! $results->treatment_history; !!}
                </div>
            </div>
            @endif
            @if (!empty($results->past_history) && strip_tags($results->past_history) != '')
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h6>
                    <span class="custom-heading">PAST HISTORY:</span>
                </h6>
                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">
                    {!! $results->past_history; !!}
                </div>
            </div>
            @endif
            @if (!empty($results->perinatal_history) && strip_tags($results->perinatal_history) != '')
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h6>
                    <span class="custom-heading">PERINATAL HISTORY:</span>
                </h6>
                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">
                    {!! $results->perinatal_history; !!}
                </div>
            </div>
            @endif
            @if (!empty($results->immunization) && strip_tags($results->immunization) != '')
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h6>
                    <span class="custom-heading">IMMUNIZATION:</span>
                </h6>
                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">
                    {!! $results->immunization; !!}
                </div>
            </div>
            @endif
            @if (!empty($results->development) && strip_tags($results->development) != '')
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h6>
                    <span class="custom-heading">DEVELOPMENT:</span>
                </h6>
                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">
                    {!! $results->development; !!}
                </div>
            </div>
            @endif
            
            @if (!empty($results->nutrition_history) && strip_tags($results->nutrition_history) != '')
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h6>
                    <span class="custom-heading">NUTRITION HISTORY:</span>
                </h6>
                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">
                    {!! $results->nutrition_history; !!}
                </div>
            </div>

            @endif  
            @if (!empty($results->family_history) && strip_tags($results->family_history) != '')
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h6>
                    <span class="custom-heading">FAMILY HISTORY:</span>
                </h6>
                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">
                    {!! $results->family_history; !!}
                </div>
            </div>

            @endif  

            @if (!empty($results->allergy_contact_history) && strip_tags($results->allergy_contact_history) != '')

            <div class="col-md-12 col-sm-12 col-xs-12">
                <h6>
                    <span class="custom-heading">ALLERGY / CONTACT HISTORY:</span>
                </h6>
                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">
                    {!! $results->allergy_contact_history; !!}
                </div>
            </div>

            @endif  

            @php $e = $v = $a = false;  @endphp
            @if ($results->stage != 0 || $results->gpallor != 0 || $results->ihm != 0 || $results->cyanosis != 0 || $results->clubby != 0 || $results->glymphadenopathy != 0 || $results->pedal_edema != 0 || (!empty($results->general_examination) && strip_tags($results->general_examination) != ''))
            @php $e = true; @endphp
            @endif
            @if ((isset($results->hr) && !empty($results->hr)) || (isset($results->pulse_volume) && !empty($results->pulse_volume)) || (isset($results->bp) && !empty($results->bp)) || (isset($results->temperature_f) && !empty($results->temperature_f)) || (isset($results->spo2) && !empty($results->spo2)) || (isset($results->cft) && !empty($results->cft)) || (!empty($results->vitals_content) && strip_tags($results->vitals_content) != ''))
            @php $v = true; @endphp
            @endif
            @if ((isset($results->current_weight) && !empty($results->current_weight)) || (isset($results->current_height) && !empty($results->current_height)) || (isset($results->current_hc) && !empty($results->current_hc)) || (isset($results->current_bmi) && !empty($results->current_bmi)) || (isset($results->current_bsa) && !empty($results->current_bsa)) || (!empty($results->anthropometry_content) && strip_tags($results->anthropometry_content) != ''))
            @php $a = true; @endphp
            @endif
            @if($e || $v || $a)

            <div class="col-md-12 col-sm-12 col-xs-12">
                <h6>
                    <span class="custom-heading">General Examination:</span>
                </h6>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="row">
                        @if($e)

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="row pl-must-10">
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
                                @if(!empty($results->general_examination) && strip_tags($results->general_examination) != '')
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="row plr-5">
                                        <div class="form-group">
                                            <div><b>Additional Findings:</b></div>
                                            <div class="editor-container">{!! $results->general_examination; !!}</div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                        @if($v)
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="row pl-must-15">
                                <h6>
                                    <span class="custom-heading">VITALS:</span>
                                </h6>
                                <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                                    <div class="row pl-must-10">
                                        <table class="table-layout-fixed">
                                            <tbody>
                                                <tr>
                                                    @if(isset($results->hr) && !empty($results->hr))
                                                    <td>
                                                        <span class="font-weight-bold">Heart Rate (BPM):</span>
                                                        <span>{!! $results->hr; !!}</span>
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
                                                        <span class="font-weight-bold">Blood Pressure (mmHg):</span>
                                                        <span>{!! $results->bp; !!}</span>
                                                    </td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    @if(isset($results->temperature_f) && !empty($results->temperature_f))
                                                    <td>
                                                        <span class="font-weight-bold">Temperature (F/C):</span>
                                                        <span>{!! $results->temperature_f; !!}</span>
                                                    </td>
                                                    @endif                    
                                                    @if(isset($results->spo2) && !empty($results->spo2))
                                                    <td>
                                                        <span class="font-weight-bold">SpO2 (%):</span>
                                                        <span>{!! $results->spo2; !!}</span>
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
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <div><b>Additional Findings:</b></div>
                                        <div class="editor-container">{!! $results->vitals_content; !!}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                        @if($a)
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="row pl-must-15">
                                <h6>
                                    <span class="custom-heading">ANTHROPOMETRY:</span>
                                </h6>
                                <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                                    <div class="row pl-must-10">
                                        <table class="table-layout-fixed">
                                            <tbody>
                                                <tr>
                                                    @if(isset($results->current_weight) && !empty($results->current_weight) && is_numeric($results->current_weight) && $results->current_weight > 0)
                                                    <td>
                                                        <span class="font-weight-bold">Weight:</span>
                                                        <span>{!! $results->current_weight / 1000; !!} Kg</span>
                                                    </td>
                                                    @endif
                                                    @if(isset($results->current_height) && !empty($results->current_height))
                                                    <td>
                                                        <span class="font-weight-bold">Length/Height:</span>
                                                        <span>{!! $results->current_height; !!} CM</span>
                                                    </td>
                                                    @endif
                                                    @if(isset($results->current_head_circumference) && !empty($results->current_head_circumference))
                                                    <td>
                                                        <span class="font-weight-bold">Head Circumference (cm):</span>
                                                        <span>{!! $results->current_head_circumference; !!} CM</span>
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
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <div><b>Additional Findings:</b></div>
                                        <div class="editor-container">{!! $results->anthropometry_content; !!}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
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
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h6>
                    <span class="custom-heading">SYSTEMATIC EXAMINATION:</span>
                </h6>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="row">
                        @if($cs)
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="row pl-must-15">
                                <h6>
                                    <span class="custom-heading">CARDIOVASCULAR SYSTEM:</span>
                                </h6>
                                <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                                    <div class="row pl-must-10">
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
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <div><b>Other CVS Findings:</b></div>
                                        <div class="editor-container">{!! $results->cvs_findings; !!}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                        @if($rs)
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="row pl-must-15">
                                <h6>
                                    <span class="custom-heading">RESPIRATORY SYSTEM:</span>
                                </h6>
                                <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                                    <div class="row pl-must-10">
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
                                            <tbody>
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
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                @if(!empty($results->rs_findings) && strip_tags($results->rs_findings) != '')
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <div><b>Other RS Findings:</b></div>
                                        <div class="editor-container">{!! $results->rs_findings; !!}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        @if($cns)
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="row pl-must-15">
                                <h6>
                                    <span class="custom-heading">CENTRAL NERVOUS SYSTEM:</span>
                                </h6>
                                <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                                    <div class="row pl-must-10">
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
                                                        <span>@if($results->cn_exam == 0) N/A @elseif($results->cn_exam == 1) Normal @else Abnormal @endif</span>
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

                                                            if ($results->eye_opening == '') {
                                                                $results->eye_opening = 0;
                                                            } 
                                                        ?>
                                                        <h6 class="display-inline-block font-weight-bold">GCS</h6> - ({!! $results->eye_opening + $results->verbal + $results->motor !!} / 15)&ensp;
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
                                                        <span>@if($results->ms_exam == 0) N/A @elseif($results->ms_exam == 1) Normal @else Abnormal @endif</span>
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
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <div class="editor-container">{!! $results->ms_findings; !!}</div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                                    <div class="row pl-must-10">
                                        <table class="table-layout-fixed">
                                            <tbody>
                                                <tr>
                                                    @if(isset($results->deep_tendon) && !empty($results->deep_tendon))
                                                    <td>
                                                        <span class="font-weight-bold">Deep Tendon Reflex(DTR):</span>
                                                        <span>@if($results->deep_tendon == 0) N/A @elseif($results->deep_tendon == 1) Normal @else Abnormal @endif</span>
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
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <div class="editor-container">{!! $results->deep_tendon_findings; !!}</div>
                                    </div>
                                </div>
                                @endif
                                @if(!empty($results->cns_findings) && strip_tags($results->cns_findings) != '')
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <div><b>Other CNS Findings:</b></div>
                                        <div class="editor-container">{!! $results->cns_findings; !!}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                        @if($ad)
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="row pl-must-15">
                                <h6>
                                    <span class="custom-heading">ABDOMEN:</span>
                                </h6>
                                <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                                    <div class="row pl-must-10">
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
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <div><b>Additional Findings:</b></div>
                                        <div class="editor-container">{!! $results->abdomen_findings; !!}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
                
            @if (!empty($results->discussion_findings) && strip_tags($results->discussion_findings) != '' )
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h6>
                    <span class="custom-heading">Discussion / Course In Hospital:</span>
                </h6>
                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">
                    {!! $results->discussion_findings; !!}
                </div>
            </div>
            @endif
    
            @if(!empty($results->treatment_findings) && strip_tags($results->treatment_findings) != '' && $results->treatment_specialist)

            <div class="col-md-12 col-sm-12 col-xs-12">
                <h6>
                    <span class="custom-heading">Treatment Given:</span>
                </h6>
                @if(isset($specialist_name) && !is_array($specialist_name) && !empty($specialist_name))
                <p class="px-20"><strong> {{ $specialist_name }}</strong></p>
                @endif
                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">
                    {!! $results->treatment_findings; !!}
                </div>
               

            </div>
            @endif
                    
           @if(isset($results->surgery) && !empty($results->surgery))
            <div class="col-md-12 col-sm-12 col-xs-12">
               
                     <h6>
                        <span class="custom-heading">SURGERY:</span>
                     </h6>
                        <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                                <table class="table-layout-fixed">
                                    <tbody>
                                        <tr>

                                            <td>
                                                <span class="font-weight-bold">Date:</span>
                                                <span>{!! $results->surgery_date; !!}</span>
                                            </td>
                                

                                            <td>
                                                <span class="font-weight-bold">Anaesthetist:</span>
                                                <span>{!! $anaesthetist_name !!}</span>
                                            </td>
                                            
                                        </tr>
                                        
                                    </tbody>
                                </table>
                         </div>
                        @if(isset($results->surgery_notes) && !empty($results->surgery_notes) && strip_tags($results->surgery_notes) != '' )                                
                         <div class="col-xs-12 col-sm-12 col-md-12">
                             <div class="form-group">
                                <div><b>Surgery Notes:</b></div>
                                    <div class="editor-container">{!! $results->surgery_notes; !!}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @endif
                
                                    
            @php 
            $doctor_medications = [];
            @endphp  

            @if(isset($results->treatment_medications) && !empty($results->treatment_medications) && count(json_decode($results->treatment_medications)) > 0)
            <div class="col-md-12 col-sm-12 col-xs-12">
               <h6>
                    <span class="custom-heading">TREAMENT MEDICATIONS:</span>
               </h6>
            @php 
            $doctor_medications = json_decode($results->treatment_medications);
            @endphp  
             <div class="col-md-12 col-sm-12 col-xs-12">
                <table class="table table-border" id="discharge-medication-table">ADDITIONAL INFORMATION:

                        <thead>
                           <tr>
                                <th width="2%">S.NO</th>
                                <th>DRUG</th>
                                <th>GENERIC NAME</th>
                                <th>FORMULATION</th>
                                <th>DOSE</th>
                                <th>FREQUENCY</th>
                                <th>DURATION</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($doctor_medications as $key =>  $value)
                            @if($value->Medication != '')
                            <tr>
                                <td>{{ ++$key }}. </td>
                                <td>{!! @$drug_master[$value->Medication] !!}</td>
                                <td>{!! @$value->genericname !!}</td>
                                <td>{!! @$value->Formulation !!}</td>
                                <td>{!! @$value->Dose !!}</td>
                                @if (isset($value->Frequency))
                                <td>{!! isset($frequency_list[$value->Frequency]) ? $frequency_list[$value->Frequency] : '' !!}</td>
                                @else
                                <td></td>
                                @endif
                                <td>{!! @$value->Duration !!}</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
          @endif
        @if(empty($results->status) || $results->status != 'Died')
        <div class="col-md-12 col-sm-12 col-xs-12">
                <h6>
                    <span class="custom-heading">DISCHARGE DETAILS:</span>
                </h6>
    
             @if(isset($results->condition_at_discharge) && strip_tags($results->condition_at_discharge) != '')
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h6>
                    <span class="custom-heading">Condition at discharge:</span>
                </h6>
                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">
                    {!! $results->condition_at_discharge; !!}
                </div>
            </div>      
            @endif
        </div>
        
            @php 
            $discharge_medications = [];
            @endphp  
            @if(isset($results->discharge_medications) && !empty($results->discharge_medications) && count(json_decode($results->discharge_medications)) > 0)
            
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h6>
                    <span class="custom-heading">DISCHARGE MEDICATIONS:</span>
                </h6>
                @php 
                $discharge_medications = json_decode($results->discharge_medications);
                @endphp
                <div class="col-md-12 col-sm-12 col-xs-12">
                    @php $show_instruction = false; @endphp
                    @if (count($discharge_medications) > 0 && count(collect($discharge_medications)->where('additional_instruction', '<>', null)->where('additional_instruction', '<>', '')->toArray()) > 0)
                    @php $show_instruction = true; @endphp
                    @endif
                    <table class="table table-border" id="discharge-medication-table">
                        <thead>
                            <tr>
                                <th width="2%">S.NO</th>
                                <th>DRUG</th>
                                <th>GENERIC NAME</th>
                                <th>FORMULATION</th>
                                <th>DOSE</th>
                                <th>FREQUENCY</th>
                                <th>DURATION</th>
                                @if ($show_instruction)
                                <td>ADDITIONAL INSTRUCTION</td>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        
                        @if(count($discharge_medications) > 0 )
                         @foreach($discharge_medications as $key =>  $value)
                            @if(isset($value->drug_name))
                                <tr>
                                    <td>{{ ++$key }}. </td>
                                    <td>{!! @$value->drug_name !!}</td>
                                    <td></td>
                                    <td></td>
                                    <td>{!! @$value->dose !!}</td>
                                    <td>{!! @$value->frequency !!}</td>
                                    <td>{!! @$value->duration !!}</td>
                                    @if ($show_instruction)
                                    <td></td>
                                    @endif
                                </tr>
                            @else
                                <tr>
                                    <td>{{ ++$key }}. </td>
                                    <td>{!! @$drug_master[$value->Medication] !!}</td>
                                    <td>{!! @$value->GenericName !!}</td>
                                    <td>{!! @$value->Formulation !!}</td>
                                    <td>{!! @$value->Dose !!}</td>
                                    @if (isset($value->Frequency))
                                    <td>{!! isset($frequency_list[$value->Frequency]) ? $frequency_list[$value->Frequency] : '' !!}</td>
                                    @else
                                    <td></td>
                                    @endif
                                    <td>{!! @$value->Duration !!}</td>
                                    @if ($show_instruction)
                                    <td>{!! @$value->AdditionalInstruction !!}</td>
                                    @endif
                                </tr>
                            @endif
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6" style="text-align: center;">None Prescribed</td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @if(isset($results->review_details) && strip_tags($results->review_details) != '')
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h6>
                    <span class="custom-heading">Review:</span>
                </h6>
                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">
                    {!! $results->review_details; !!}
                </div>
            </div>      
            @endif
            @endif
            @if(isset($results->discharge_findings) && strip_tags($results->discharge_findings) != '')
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h6>
                    <span class="custom-heading">Additional Information:</span>
                </h6>
                <div class="col-xs-12 col-sm-12 col-md-12 editor-container">
                    {!! $results->discharge_findings; !!}
                </div>
            </div>      
            @endif
            </div>
            <div class="col-md-12 page-break-page mt-15">
                <div class="row">
                    <div class="col-xs-3 col-md-3 col-sm-3 pull-left page-break-page mtb-15">
                        <div class="row">
                            <ul class="list-none pl-15">
                                <li>Date : {!! $results->status_date; !!}</li>
                                <li>Place : {!! env('LOCATION') !!} </li>
                            </ul>
                        </div>
                    </div>
                    @php
                        $pediatric_consultant = \ValuelistHelpers::signatureFormat($results->pediatric_consultant, 2, $approved_by_list);
                    @endphp
                    <div class="col-xs-9 col-md-9 col-sm-9 page-break-page mtb-15 pull-right">
                        {!! $pediatric_consultant !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-md in" id="issued-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="false">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close close-alt btn" data-dismiss="modal" aria-label="close"><span aria-hidden="true">×</span></button>
            <h5 class="text-center color-white"><b>Summary Hand-Over Marking</b></h5>
        </div>
        <div class="modal-body row p-15-must">
            {!! Form::model($results,['url' => action('Admission\PediatricController@issuedDetails'), 'id'=>'issued-form']) !!}
            {!! Form::hidden('id') !!}
            <div class="form-group row">
                <div class="col-md-4 text-right label-control">
                    {!! Form::label('issued_to','Issued To:', ['class'=>'required-label']) !!}
                </div>
                <div class="col-md-8 custom-input">
                    {!! Form::text('issued_to',null,['class'=>'form-control', 'required']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4 text-right label-control">
                    {!! Form::label('issued_to_relationship','Issued To Relationship:', ['class'=>'required-label']) !!}
                </div>
                <div class="col-md-8 custom-input">
                    {!! Form::text('issued_to_relationship',null,['class'=>'form-control', 'required']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4 text-right label-control">
                    {!! Form::label('issued_date','Issued Date:') !!}
                </div>
                <div class="col-md-8 custom-input">
                    {!! Form::text('issued_date',null,['class'=>'form-control','readonly', 'required']) !!}
                </div>
            </div>
            @php $prepare_time = \SiteHelpers::prepare_time(); @endphp
            <div class="form-group row">
                <div class="col-md-4 text-right label-control" style="margin-top: 25px;">
                    {!! Form::label('issued_time','Issued Time:') !!}
                </div>
                <div class="col-md-8 custom-input clear-xs">
                    <div class="row">
                        <div class="col-xs-4 text-center">
                            <small>(Hour)</small>
                        </div>
                        <div class="col-xs-4 text-center">
                            <small>(Minute)</small>
                        </div>
                        <div class="col-xs-4 text-center">
                            <small>(Session)</small>
                        </div>
                        <div class="col-xs-4 text-center">
                            {!! Form::select('issued_time',[''=>'N/A']+$prepare_time['time'],null,['class'=>'form-control input-width-small', 'required']) !!}
                        </div>
                        <div class="col-xs-4 text-center">
                            {!! Form::select('issued_time_mins',[''=>'N/A']+$prepare_time['mins'],null,['class'=>'form-control input-width-small', 'required']) !!}
                        </div>
                        <div class="col-xs-4 text-center">
                            {!! Form::select('issued_time_session',[''=>'N/A']+$prepare_time['session'],null,['class'=>'form-control input-width-small', 'required']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-offset-5 col-xs-12">
                <button type="submit" class="btn btn-primary btn-basic-shadow">
                    <i class="fa fa-floppy-o"></i>
                    <span>Submit</span>
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $("#pediatric-approval").on('click', function() {
            var id = $('input[name="id"]').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: {
                    id: id
                },
                url: "{{ url('pediatric-admission/approval') }}",
                success: function(response) {
                    location.reload();
                }
            });
        });
        $("#issued-mark").on('click', function() {
            var id = $('input[name="id"]').val();
            $('#issued-modal').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
            $('#issued-modal input[name="id"]').val(id);
            $('input[name="issued_date"]').datepicker({
                dateFormat: 'dd-mm-yy',
                yearRange: "-60:+02",
                changeMonth: true,
                changeYear: true,
                maxDate: '+0M',
            });
        });
        $("#issued-modal button[type='submit']").on('click', function(e) {
            e.preventDefault();
            if ($('#issued-modal form').valid() === true) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: $('#issued-modal form').serialize(),
                    url: $('#issued-modal form').attr('action'),
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        });
    });
</script>
@endsection
