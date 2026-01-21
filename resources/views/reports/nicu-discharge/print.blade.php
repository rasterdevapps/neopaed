@extends('print')
@section('content')
@php $public_url =url('public').'/'; @endphp
@php $specialPermission = \Session::get('specialPermissions'); @endphp
@php $specialPermission = count($specialPermission) > 0 ? $specialPermission : array() @endphp
{{-- @php if(isset($dischargeSummarymodified['is_completed']) && $dischargeSummarymodified['is_completed'] == 2 && !in_array('DISCHARGE_EDIT',$specialPermission)){ $dischargeEditpermission = 'hide'; }else{ $dischargeEditpermission = ''; } @endphp --}}
@php $dischargeEditpermission = ''; @endphp
{!! Form::model(null,['method' => 'POST','url' => action('Reports\NicuDischargeController@store',null), 'id'=>'nicu-discharge']) !!}    
{!! Form::hidden('flag',2) !!}
{!! Form::hidden('BabyId',$enc['babyId']) !!}
{!! Form::hidden('BMrNo',$result->BMrNo) !!}
{!! Form::hidden('status',0) !!}
@if (isset($generated) && $generated)
<style type="text/css">
    a[title="Edit"] {
        display: none;
    }
    
</style>
@endif

@if(\Auth::user()->RoleId != env('SUPER_ADMIN_ROLE'))
<style type="text/css">

    #printed-content .temp-row, .disabled-content {
        cursor: not-allowed;
        pointer-events: none;
    }
</style>
@endif
<link rel="stylesheet" type="text/css" href="{{$public_url}}/css/nicu-daycare-summary.css">
@if (isset($editor_gen) && $editor_gen)
<div class="editor_style">
    @include('editor_print') 
</div>
@endif
@php $problem_status = $summarycontent_status = $procedure_status = $summary_status = $birth_status = $respiratorysystem_status = $cardiovascularsystem_status = $gastrointestinalsystem_status = $centralnervoussystem_status = $sepsis_status = $ophthalmology_status = $hematology_status = $newbornscreening_status = $communicationwithparents_status = $investigations_status = $dischargemedications_status = $vaccine_status = $dischargeinstruction_status = $followup_status = $addedinfo_status = ''; @endphp
@if(isset($dischargeSummarymodified['newdiagnosis']) && !empty($dischargeSummarymodified['newdiagnosis']))
@php $newly_added = unserialize($dischargeSummarymodified['newdiagnosis']);
$dischargeSummarymodified['newdiagnosis'] = ''; @endphp
@foreach($newly_added as $key => $value)
@php $i = 0; @endphp 
@foreach($value as $key1 => $value1)
@if ($key1 == 'add_diagnosis')
@if ($i == 1)
@php $dischargeSummarymodified['newdiagnosis'] .= stripcslashes($value1) . '++';  @endphp
@endif
@switch(str_replace('"', '', stripcslashes($value['dependency'])))
@case ('problem-status')
@php $problem_status .= $value1; @endphp
@break
@case ('summarycontent-status')
@php $summarycontent_status .= $value1; @endphp
@break
@case ('procedure-status')
@php $procedure_status .= $value1; @endphp
@break
@case ('summary-status')
@php $summary_status .= $value1; @endphp
@break
@case ('birth-status')
@php $birth_status .= $value1; @endphp
@break
@case ('respiratorysystem-status')
@php $respiratorysystem_status .= $value1; @endphp
@break
@case ('cardiovascularsystem-status')
@php $cardiovascularsystem_status .= $value1; @endphp
@break
@case ('gastrointestinalsystem-status')
@php $gastrointestinalsystem_status .= $value1; @endphp
@break
@case ('centralnervoussystem-status')
@php $centralnervoussystem_status .= $value1; @endphp
@break
@case ('sepsis-status')
@php $sepsis_status .= $value1; @endphp
@break
@case ('ophthalmology-status')
@php $ophthalmology_status .= $value1; @endphp
@break
@case ('hematology-status')
@php $hematology_status .= $value1; @endphp
@break
@case ('newbornscreening-status')
@php $newbornscreening_status .= $value1; @endphp
@break
@case ('communicationwithparents-status')
@php $communicationwithparents_status .= $value1; @endphp
@break
@case ('investigations-status')
@php $investigations_status .= $value1; @endphp
@break
@case ('dischargemedications-status')
@php $dischargemedications_status .= $value1; @endphp
@break
@case ('addedinfo-status')
@php $addedinfo_status .= $value1; @endphp
@break
@case ('vaccine-status')
@php $vaccine_status .= $value1; @endphp
@break
@case ('dischargeinstruction-status')
@php $dischargeinstruction_status .= $value1; @endphp
@break
@case ('followup-status')
@php $followup_status .= $value1; @endphp
@break
@endswitch
@else
@if ($i == 0)
@php $dischargeSummarymodified['newdiagnosis'] .= str_replace('"', '', stripslashes($value1)) . '||'; @endphp
@endif
@endif
@php $i += 1; @endphp 
@endforeach
@endforeach
@endif
{!! Form::hidden('newdiagnosis', @$dischargeSummarymodified['newdiagnosis']) !!}

<div class="temp-container nicu-discharge-report @if(!in_array('NICU_DISCHARGE', \Session::get('write_permission'))) hide-customization @endif">
    <div class="temp-row">
        <!-- BEGIN HEADER CONTENT -->
        <div class="ml-15 @if(isset($headerContent['header_required']) && $headerContent['header_required'] == 1) hide @endif">
            <img src="{!! SiteHelpers::getNicuLogo($result->NicuId) !!}" class="logo-align">
            @if ($result->hospital_name != 'Sudha Hospital' && $result->hospital_name != 'Saraswathi Nursing Home')
            <img src="{{url('public/img/nabh.png')}}" class="pull-right mr-15 nabh-logo">
            @endif
        </div>
        <div class="@if(isset($headerContent['header_required']) && $headerContent['header_required'] == 1) hide @endif mb-15 ml-15">
            <h5 class="mt-0"><strong>{!! \ValuelistHelpers::getHospitalsDetails($result->hospital_name, $headerContent) !!}</strong> </h5>
        </div>
        <div id="patient-list" class="@if(isset($headerContent['header_required']) && $headerContent['header_required'] == 1) header-down @endif">
            <div id="company">
                <span style="font-size:16px;"> {!! $headerContent['discharge_report_right'] !!}</span>
            </div>
        </div>
        <div id="doctor-list">
            <div id="project">
                {!! \ValuelistHelpers::headerContent($result->hospital_name, $headerContent) !!}
            </div>
        </div>
        <div class="">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h5 class="text-center"><strong>Neonatal Intensive Care Unit - Summary Of Stay</strong> </h5>
                <div class="row" style="margin-bottom:15px;">
                    @if(!empty(trim($result->paediatric_surgeon)))
                    <span class="pull-left col-xs-3 col-sm-6 col-md-6"><b>Paediatric Surgeon :</b></span>
                    <div class="col-xs-9 col-sm-12">
                        {!! ValuelistHelpers::get_surgeons_lists($result->paediatric_surgeon) !!}
                        <!-- DR D.V.SURESH DCH , DNB(PED),MNAMS -->
                    </div>
                    @endif
                    <!-- @if($result->obstetric_consultant != 0 && !is_null($result->obstetric_consultant))
                    <span class="col-xs-9 col-sm-12">
                        <span><b>Consultant OBG :</b></span>
                    </span>
                    <div class="col-xs-9 col-sm-12">
                        {!! ValuelistHelpers::mas_doctors_list($result->obstetric_consultant) !!}
                    </div>
                    @endif -->
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 plr-must-0">
                <div class="col-xs-6 col-sm-6 col-md-6">
                </div>
                <div class="col-md-offset-1 col-xs-6 col-sm-6 col-md-5 pl-10">
                    <table class="pull-right">
                        <tr>
                            <td><h5 class="m-0 pull-right">Status :</h5></td>
                            <td><h5 class="m-0" id="temp-status-change">{{ $result->status }}</h5></td>
                        </tr>
                        @if((isset($summary_type) && $summary_type == 'interim') || $result->status == 'Inpatient')
                        <tr class="for-inpatient">
                            <td><h5 class="m-0 pull-right">Date :</h5></td>
                            <td><h5 class="m-0">{{ date('d-m-Y') }} </h5></td>
                        </tr>
                        @endif
                        
                        <tr class="@if(date('Y', strtotime($result->DischargeDate)) != '1970') @else hide @endif for-discharge discharge-date">
                            <td><h5 class="m-0 pull-right">{{ ($result->status == 'Died') ? 'Date of Death' : 'Date of Discharge'}} : </h5></td>
                            <td><h5 class="m-0" id="temp-discharge-date-change">{{ date('d-m-Y', strtotime($result->DischargeDate)) }}</h5></td>
                        </tr>
                        
                        @if($result->status == 'Died')
                            @php $result->diedTime = (strlen($result->diedTime) == 1) ? '0'.$result->diedTime : $result->diedTime ; @endphp
                            @php $result->diedMins = (strlen($result->diedMins) == 1) ? '0'.$result->diedMins : $result->diedMins ; @endphp
                        <tr>
                            <td><h5 class="m-0 pull-right">Time of Death:</h5></td>
                            <td><h5 class="m-0">{{ $result->diedTime.':'.$result->diedMins.' '.$result->diedAm }}</h5></td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <hr style="margin-top:0px;border-top:2px solid #000;margin-bottom:10px;">
            </div>
        </div>
        <!-- END HEADER CONTENT -->
        <div class="col-md-12 col-sm-12 col-xs-12 daycare-summary-content plr-must-0-screen">
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
                                <span class="print-value">{!! $result->babymr !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Name:</span>
                                <span class="print-value">{!! $result->BabyName !!}</span>
                            </div>
                            @php $result->TOB_TIME = (strlen($result->TOB_TIME)==1)? '0'.$result->TOB_TIME : $result->TOB_TIME ;@endphp
                            @php $result->TOB_MINS = (strlen($result->TOB_MINS)==1)? '0'.$result->TOB_MINS : $result->TOB_MINS ;@endphp
                            <div class="form-group">
                                <span class="print-label">Birth Date & Time:</span>
                                <span class="print-value">{!! date('d-m-Y',strtotime($result->DOB)) !!}; {!! $result->TOB_TIME !!}:{!! $result->TOB_MINS !!} {!! $result->TOB_AM !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Sex:</span>
                                <span class="print-value">{!! $result->Sex !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Gestation:</span>
                                <span class="print-value">{!! $result->Gestation !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Corrected Gestational Age:</span>
                                <span class="print-value">{!! $result->corrected_gestation > 0 ? $result->corrected_gestation : 'N/A' !!}</span>
                            </div>
                            @if($result->status != 'Inpatient')
                            <div class="form-group">
                                <span class="print-label">Day Of Life:</span>
                                <span class="print-value">{!! SiteHelpers::calculate_day_of_life_two(date('Y-m-d',strtotime($result->DOB)),date('Y-m-d',strtotime($result->DischargeDate)))  !!}</span>
                            </div>
                            @else
                            <div class="form-group">
                                <span class="print-label">Day Of Life:</span>
                                <span class="print-value">{!! SiteHelpers::calculate_day_of_life_two(date('Y-m-d',strtotime($result->DOB)),date('Y-m-d'))  !!}</span>
                            </div>
                            @endif
                            <div class="form-group">
                                <span class="print-label">Birth Status:</span>
                                <span class="print-value">{!! ($result->BirthStatus =='Inborn') ? 'Intramural' : 'Extramural' !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Mode of delivery:</span>
                                <span class="print-value">{!! $result->ModeOfDelivery !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Birth Order:</span>
                                <span class="print-value">{!! $result->BirthOrder !!}</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <span class="print-label">{{ Lang::get('home.ip') }}:</span>
                                <span class="print-value">{!! $ipnumber !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Baby's Blood Group:</span>
                                <span class="print-value">{!! $result->BabyBloodGroup !!}</span>
                            </div>

                            @php $admission_time = ''; @endphp

                            @if ($result->AdmissionTime >= 0 && $result->AdmissionTime_MINS >= 0 && $result->AdmissionTime_AM != '')

                            @php $result->AdmissionTime = (strlen($result->AdmissionTime) == 1) ? '0'.$result->AdmissionTime : $result->AdmissionTime ; @endphp

                            @php $result->AdmissionTime_MINS = (strlen($result->AdmissionTime_MINS) == 1) ? '0'.$result->AdmissionTime_MINS : $result->AdmissionTime_MINS ; @endphp

                            @php $result->AdmissionTime_AM = $result->AdmissionTime_AM; @endphp

                            @php $admission_time = $result->AdmissionTime.':'.$result->AdmissionTime_MINS.' '.$result->AdmissionTime_AM; @endphp

                            @endif

                            @php $discharge_time = ''; @endphp

                            @if ($result->DischargeTransferedTime >= 0 && $result->DischargeTransferedTime_MINS >= 0 && $result->DischargeTransferedTime_AM != '')

                            @php $result->DischargeTransferedTime = (strlen($result->DischargeTransferedTime) == 1) ? '0'.$result->DischargeTransferedTime : $result->DischargeTransferedTime ; @endphp

                            @php $result->DischargeTransferedTime_MINS = (strlen($result->DischargeTransferedTime_MINS) == 1) ? '0'.$result->DischargeTransferedTime_MINS : $result->DischargeTransferedTime_MINS ; @endphp

                            @php $result->DischargeTransferedTime_AM = $result->DischargeTransferedTime_AM; @endphp

                            @php $discharge_time = $result->DischargeTransferedTime.':'.$result->DischargeTransferedTime_MINS.' '.$result->DischargeTransferedTime_AM; @endphp

                            @endif

                            <div class="form-group">
                                <span class="print-label">Date of Admission:</span>
                                <span class="print-value">{!! $result->AdmissionDate . ' ' .$admission_time !!}</span>
                            </div>
                            @if($result->Discharge_status == 'Died' || $result->Discharge_status == 'Died (OCNR)')
                            <div class="form-group">
                                <span class="print-label">Date of Death:</span>
                                <span class="print-value">{!! $result->DischargeDate !!}</span>
                            </div>
                            @php $result->diedTime = (strlen($result->diedTime) == 1) ? '0'.$result->diedTime : $result->diedTime ; @endphp
                            @php $result->diedMins = (strlen($result->diedMins) == 1) ? '0'.$result->diedMins : $result->diedMins ; @endphp
                            <div class="form-group">
                                <span class="print-label">Time of Death:</span>
                                <span class="print-value">{!! $result->diedTime.':'.$result->diedMins.' '.$result->diedAm !!}</span>
                            </div>
                            @else
                            @if($result->status == 'Inpatient')
                            <div class="form-group">
                                <span class="print-label">Current Date:</span>
                                <span class="print-value">{!! date('d-m-Y') !!}</span>
                            </div>
                            @else
                            <div class="form-group">
                                <span class="print-label">Date of Discharge:</span>
                                <span class="print-value">{!! $result->DischargeDate . ' ' . $discharge_time !!}</span>
                            </div>
                            @endif
                            @endif
                            <div class="form-group">
                                <span class="print-label">Birth Weight (g):</span>
                                <span class="print-value">{!! (!empty($result->BirthWeight) && $result->BirthWeight != 0) ?  $result->BirthWeight : 'N/A' !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Birth OFC (cm):</span>
                                <span class="print-value">{!! (!empty($result->OFC) && $result->OFC != 0) ?  $result->OFC : 'N/A' !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Birth Length (cm):</span>
                                <span class="print-value">{!! (!empty($result->Length) && $result->Length != 0) ?  $result->Length : 'N/A' !!}</span>
                            </div>
                            
                            <div class="@if($result->status != 'Inpatient') @else hide @endif for-discharge">
                                <div class="form-group">
                                    <span class="print-label">Discharge Weight (g):</span>
                                    <span class="print-value" id="temp-discharge-weight-change">{!! (!empty($result->nicuDischargeWeight) && $result->nicuDischargeWeight != 0) ?  $result->nicuDischargeWeight : 'N/A' !!}</span>
                                </div>
                                <div class="form-group">
                                    <span class="print-label">Discharge OFC (cm):</span>
                                    <span class="print-value" id="temp-discharge-ofc-change">{!! (!empty($result->nicu_ofc) && $result->nicu_ofc != 0) ?  $result->nicu_ofc : 'N/A' !!}</span>
                                </div>
                                <div class="form-group">
                                    <span class="print-label">Discharge length (cm):</span>
                                    <span class="print-value" id="temp-discharge-length-change">{!! (!empty($result->nicu_Length) && $result->nicu_Length != 0) ?  $result->nicu_Length : 'N/A' !!}</span>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            @if($result->status != 'Inpatient')
            {{ Form::hidden('discharge_summary_edit_option', $dischargeEditpermission) }}
            @else
            {{ Form::hidden('discharge_summary_edit_option') }}
            @endif
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
                <h6>                    
                    <span class="check-box-div">
                        {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'patient_problems']) !!}
                        <label for="patient_problems"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading">Diagnosis:</span>
                    {!! Form::hidden('Problems', @$dischargeSummarymodified['Problems']) !!}
                    <a href="javascript:void(0);" class="hidden-print {!! $dischargeEditpermission !!}" title="Add">
                        <i class="fa fa-plus add-diagnosis problems-adding" aria-hidden="true"></i>
                    </a>
                    <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="cursor: pointer;" title="Edit">
                        <i class="fa fa-pencil problems-report-editing" aria-hidden="true"></i>
                    </a>
                </h6>
                @if (isset($get_problem) && is_array($get_problem) && count($get_problem) > 0) 
                <div class="generated-content-container">
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'problem-get-problem']) !!}
                        <label for="problem-get-problem"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content">
                        <ol>
                            @foreach ($get_problem as $key => $value)
                            <li>{!! $value !!}</li>
                            @endforeach
                        </ol>
                        {!! $Problems_text or '' !!}
                    </div>
                </div>
                @endif
                <div class="problems-report-editor editor-align @if(count($dischargeSummarymodified) >  0 && isset($dischargeSummarymodified['Problems']) && !empty($dischargeSummarymodified['Problems'])) @else hide @endif">
                    <div class="editor-align-checkbox-div">
                        {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'modified-problem']) !!}
                        <label for="modified-problem"><span class="hidden-print"></span></label>
                    </div>
                    <div class="editor-align-content">
                        {!! @$dischargeSummarymodified['Problems'] !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen newly-added">
                @php echo stripcslashes($problem_status); @endphp
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen">
                <h6>                    
                    <span class="check-box-div">
                        {!! Form::checkbox('summarycontent-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'patient_summary']) !!}
                        <label for="patient_summary"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading">SUMMARY:</span>
                    {!! Form::hidden('summary', @$dischargeSummarymodified['summary']) !!}
                    <a href="javascript:void(0);" class="hidden-print {!! $dischargeEditpermission !!}" title="Add">
                        <i class="fa fa-plus add-diagnosis problems-adding" aria-hidden="true"></i>
                    </a>
                    <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="cursor: pointer;" title="Edit">
                        <i class="fa fa-pencil summary-report-editing" aria-hidden="true"></i>
                    </a>
                </h6>
                <div class="summary-report-editor editor-align @if(count($dischargeSummarymodified) >  0 && isset($dischargeSummarymodified['summary']) && !empty($dischargeSummarymodified['summary'])) @else hide @endif">
                    <div class="editor-align-checkbox-div">
                        {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'modified-summary']) !!}
                        <label for="modified-summary"><span class="hidden-print"></span></label>
                    </div>
                    <div class="editor-align-content">
                        {!! @$dischargeSummarymodified['summary'] !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen newly-added" data-showtype="{!! $dischargeEditpermission !!}">
                @php echo stripcslashes($summarycontent_status); @endphp
            </div>
            @if(!empty($proceduresSystem))
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
                <h6>                    
                    <span class="check-box-div">
                        {!! Form::checkbox('procedure-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'proceduresSystem-status']) !!}
                        <label for="proceduresSystem-status"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading">Procedures:</span>
                    {!! Form::hidden('Procedures', @$dischargeSummarymodified['Procedures']) !!}
                    <a href="javascript:void(0);" class="hidden-print {!! $dischargeEditpermission !!}" title="Add">
                        <i class="fa fa-plus add-diagnosis procedure-adding" aria-hidden="true"></i>
                    </a>
                    <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="cursor: pointer;" title="Edit">
                        <i class="fa fa-pencil Procedures-report-editing" aria-hidden="true"></i>
                    </a>
                </h6>
                @if(!empty($proceduresSystem))
                <div class="generated-content-container no-table-border">
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'proceduresSystem']) !!}
                        <label for="proceduresSystem"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content">
                        {!! $proceduresSystem !!}
                    </div>
                </div>
                @endif  
                <div class="procedures-report-editor editor-align @if(count($dischargeSummarymodified) >  0 && isset($dischargeSummarymodified['Procedures']) && !empty($dischargeSummarymodified['Procedures'])) @else hide @endif">
                    <div class="editor-align-checkbox-div">
                        {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'proceduresSystem-modified']) !!}
                        <label for="proceduresSystem-modified"><span class="hidden-print"></span></label>
                    </div>
                    <div class="editor-align-content no-table-border">
                        {!! @$dischargeSummarymodified['Procedures'] !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen newly-added">
                @php echo stripcslashes($procedure_status); @endphp
            </div>
            @endif
            @if(!empty($result->ReferredBy) && !empty($result->ReferralReason))
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
                <h6>                    
                    <span class="check-box-div">
                        {!! Form::checkbox('summary-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print' , 'id' => 'Summarybirth']) !!}
                        <label for="Summarybirth"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading">Birth Summary:</span>
                    {!! Form::hidden('Summarybirth', @$dischargeSummarymodified['Summarybirth']) !!} 
                    <a href="javascript:void(0);" class="hidden-print {!! $dischargeEditpermission !!}" title="Add">
                        <i class="fa fa-plus add-diagnosis summary-adding" aria-hidden="true"></i>
                    </a>
                    <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="cursor: pointer;" title="Edit">
                        <i class="fa fa-pencil Summarybirth-report-editing" aria-hidden="true"></i>
                    </a>
                </h6>
                <div class="generated-content-container">
                    @if($result->BirthStatus == 'Outborn')
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id' => 'Outborn-summary']) !!}
                        <label for="Outborn-summary"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content">
                        {!! $result->BabyName !!} was refered from {!! $result->ReferredBy !!} with history of {!! $result->ReferralReason !!} on day {!! SiteHelpers::calculate_day_of_life(date('Y-m-d',strtotime($result->DOB))) !!} of life.
                    </div>
                    @endif
                    @if($result->BirthStatus == 'Inborn')
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'inborn-summary']) !!}
                        <label for="inborn-summary"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content">
                        {!! $result->BabyName !!} was born at {!! $result->ReferredBy !!} and admitted to the neonatal unit with a history of {!! $result->ReferralReason !!} on day {!! SiteHelpers::calculate_day_of_life(date('Y-m-d',strtotime($result->DOB))) !!}
                    </div>
                    @endif
                </div>
                <div class="summarybirth-report-editor editor-align @if(count($dischargeSummarymodified) >  0 && isset($dischargeSummarymodified['Summarybirth']) && !empty($dischargeSummarymodified['Summarybirth'])) @else hide @endif">
                    <div class="editor-align-checkbox-div">
                        {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'summary-modified']) !!}
                        <label for="summary-modified"><span class="hidden-print"></span></label>
                    </div>
                    <div class="editor-align-content">
                        {!! @$dischargeSummarymodified['Summarybirth'] !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen newly-added">
                @php echo stripcslashes($summary_status); @endphp
            </div>
            @endif
            <div class="page-break"></div>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page mother-basic-detail">
                <h6>
                    <span class="check-box-div">
                        {!! Form::checkbox('hide', null) !!}
                        <label><span></span></label>
                    </span>
                    <span class="custom-heading">Mother Details:</span>
                </h6>
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <span class="print-label">Mother's Name:</span>
                                <span class="print-value">{!! $result->MotherTitle !!} {!! $result->MotherInitial !!} {!! $result->MotherName !!} {!! $result->MotherLastName !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Age:</span>
                                <span class="print-value">{!! $result->MothercYear !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Mother's Blood Group:</span>
                                <span class="print-value">{!! $result->MotherBloodGroup !!}</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                          <div class="form-group">
                            <div>
                              <span class="print-label">LMP:</span>
                              <span class="print-value">@if($result->LMP != null && $result->LMP != ''){!! date("d-m-Y",strtotime($result->LMP)); !!}@else N/A @endif</span>
                          </div>
                      </div>
                      <div class="form-group">
                        <span class="print-label">EDD by dates:</span>
                        <span class="print-value">@if(date('Y',strtotime($result->EDDbyDates)) > 1970) {!! date('d-m-Y',strtotime($result->EDDbyDates)) !!} @else N/A @endif</span>
                    </div>
                    @if(!empty($result->EDDbyUSG))
                    <div class="form-group">
                        <span class="print-label">EDD by USG:</span>
                        <span class="print-value">{!! date('d-m-Y',strtotime($result->EDDbyUSG)) !!}</span>
                    </div>
                    @endif                 
                    <div class="form-group">
                        <span class="print-label">Conception:</span>
                        <span class="print-value">{!! $result->Conception !!}</span>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    Obstetric history: Gravida @if(!empty($result->G_Value)) {!! $result->G_Value !!} @else 0 @endif  Para @if(!empty($result->P_Value)) {!! $result->P_Value !!} @else 0 @endif Live @if(!empty($result->L_Value)) {!! $result->L_Value !!} @else 0 @endif Abortion @if(!empty($result->A_Value)) {!! $result->A_Value !!} @else 0 @endif           
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
        <h6>
            <span class="check-box-div">
                {!! Form::checkbox('hide', null) !!}
                <label><span></span></label>
            </span>
            <span class="custom-heading">Mother's Medical Problems:</span>
        </h6>
        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table-condensed" style="padding: 0px !important;">
                        <thead>
                            <tr>
                                <th style="font-size: 12px;"><b>Problems</b></th>
                                <th style="font-size: 12px;"><b>Medications</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($medical_problems as $problems)
                            <tr>
                                <td> {!! $problems->Name !!}       </td>
                                <td> {!! $problems->Medication !!} </td>
                            </tr>
                            @empty  
                            <tr>
                                <td> Nil </td>
                                <td> Nil </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
        <h6>
            <span class="check-box-div">
                {!! Form::checkbox('hide', null) !!}
                <label><span></span></label>
            </span>
            <span class="custom-heading">Pregnancy problems:</span>
        </h6>
        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table-condensed" style="padding: 0px !important;">
                        <thead>
                            <tr>
                                <th style="font-size: 12px;"><b>Complications</b></th>
                                <th style="font-size: 12px;"><b>Treatment</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($medical_complications as $complication)
                            <tr>
                                <td>{!! $complication->Name !!}</td>
                                <td>{!! $complication->Treatment !!}</td>
                            </tr>
                            @empty
                            <tr>
                                <td> Nil </td>
                                <td> Nil </td>
                            </tr>
                            @endforelse    
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
        <h6>
            <span class="check-box-div">
                {!! Form::checkbox('hide', null) !!}
                <label><span></span></label>
            </span>
            <span class="custom-heading">Antenatal Ultrasound scan findings:</span>
        </h6>
        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    @if(is_array($ultrasoundfindings) && count($ultrasoundfindings) > 0)
                    <table>
                        <thead>
                            <tr>
                                <th style="font-size: 12px;"><b>Gestations</b></th>
                                <th style="font-size: 12px;"><b>Findings</b></th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($ultrasoundfindings as $ultrasounds)
                            @if($ultrasounds['gastations'] != '' || $ultrasounds['findings'] != '')
                            <tr>
                                <td>{!! isset($ultrasounds['gastations']) ? $ultrasounds['gastations'] : '' !!}</td>
                                <td>{!! isset($ultrasounds['findings']) ? $ultrasounds['findings'] : '' !!}</td>
                            </tr>
                            @endif
                            @empty
                            <tr>
                                <td> Not available </td>
                                <td> Not available </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @else
                    N/A
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
        <h6>                    
            <span class="check-box-div">
                {!! Form::checkbox('birth-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'birth-status-report']) !!}
                <label for="birth-status-report"><span class="hidden-print"></span></label>
            </span>
            <span class="custom-heading">Birth:</span>
            {!! Form::hidden('Birth', @$dischargeSummarymodified['Birth']) !!}
            <a href="javascript:void(0);" class="hidden-print {!! $dischargeEditpermission !!}" title="Add">
                <i class="fa fa-plus add-diagnosis birth-adding" aria-hidden="true"></i>
            </a>
            <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="cursor: pointer;" title="Edit">
                <i class="fa fa-pencil birth-report-editing" aria-hidden="true"></i>
            </a>
        </h6>
        @if($daycaresheetscount != 0)
        <div class="generated-content-container">
            <div class="generated-content-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'birth-report']) !!}
                <label for="birth-report"><span class="hidden-print"></span></label>
            </div>
            <div class="generated-content">
                Baby was born at {!! $result->Gestation !!} weeks of
                gestation by  {!! strtolower($result->ModeOfDelivery) !!} delivery.
                {!! $result->Indication !!}
                @if ( $result->AntenatalSteroids == 'No')
                Mother did not receive antenatal steroids.
                @else
                Mother received antenatal steroids.
                @endif
                @if ( $result->Resuscitation == 'No')
                Baby did not require any resuscitation at birth.
                @else
                Baby required support at birth.
                @endif
                @if (!empty($result->Birth))
                {!! $result->Birth !!}
                @endif
            </div>
        </div>
        @endif
        <div class="birth-report-editor editor-align @if(count($dischargeSummarymodified) >  0 && isset($dischargeSummarymodified['Birth']) && !empty($dischargeSummarymodified['Birth'])) @else hide @endif">
            <div class="editor-align-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'birth-report-modified']) !!}
                <label for="birth-report-modified"><span class="hidden-print"></span></label>
            </div>
            <div class="editor-align-content">
                {!! @$dischargeSummarymodified['Birth'] !!}
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen newly-added">
        @php echo stripcslashes($birth_status); @endphp
    </div>
    <div class="page-break"></div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
        <h6>                    
            <span class="check-box-div">
                {!! Form::checkbox('respiratorysystem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'respiratorysystem-status']) !!}
                <label for="respiratorysystem-status"><span class="hidden-print"></span></label>
            </span>
            <span class="custom-heading">Respiratory system:</span>
            {!! Form::hidden('RespiratorySystem', @$dischargeSummarymodified['RespiratorySystem']) !!}
            <a href="javascript:void(0);" class="hidden-print {!! $dischargeEditpermission !!}" title="Add">
                <i class="fa fa-plus add-diagnosis respiratorysystem-adding" aria-hidden="true"></i>
            </a>
            <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="cursor: pointer;" title="Edit">
                <i class="fa fa-pencil respiratorysystem-report-editing" aria-hidden="true"></i>
            </a>
        </h6>
        @if($daycaresheetscount != 0)
        <div class="generated-content-container">
            <div class="generated-content-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print','id'=>'problem-status'] ) !!}
                <label for="problem-status"><span class="hidden-print"></span></label>
            </div>
            <div class="generated-content">
                @if ( $result->Intubation == 'No' && $InvasiveVentilation != 'Yes')
                {!! $sex!!} did not require ventilator support during the neonatal stay.
                @elseif ( $result->Intubation == 'Yes' && $InvasiveVentilation == 'Yes')
                {!! $sex!!} required ventilator support.
                @elseif ( $result->Intubation == 'No' && $InvasiveVentilation == 'Yes')
                {!! $sex!!} did not require intubation at birth but required invasive ventilation
                during
                @if ( $result->Sex == 'Male')
                his
                @else
                her
                @endif
                neonatal stay.
                @elseif ( $result->Intubation == 'Yes' && $InvasiveVentilation == 'No')
                required invasive ventilation at  birth.
                @endif
                @if(!empty($InvasiveVentilationType) && !is_null($InvasiveVentilationType) && $InvasiveVentilationType!='NULL')
                {!! $sex!!} required {!! $InvasiveVentilationType !!} during ICU stay.
                @endif
                @if(!empty(trim($NonInvasiveVentilationType)) && !is_null($NonInvasiveVentilationType) && $NonInvasiveVentilationType!='NULL')
                {!! $sex!!} required {!! $NonInvasiveVentilationType !!} during ICU stay.
                @endif
                @if(!empty($OtherRespiratorySupport))
                {!! $OtherRespiratorySupport !!} therapy was provided.
                @endif
                @if(!empty($WithoutVentilation))
                The baby did not require any respiratory support after admission to the Neonatal
                unit.
                @endif
                <table style="width:auto; margin-top:10px; margin-bottom:10px;">
                    <tr>
                        <td>Invasive Ventilation</td>
                        <td>{!! $InvasiveVentilationCount !!} days</td>
                    </tr>
                    <tr>
                        <td>Non Invasive Ventilation</td>
                        <td>{!! $NonInvasiveVentilationCount !!} days</td>
                    </tr>
                    <tr>
                        <td>Other Respiratory Support</td>
                        <td>{!! $OtherRespiratorySupportCount !!} days</td>
                    </tr>
                </table>
                @if ( $result->SurfactantGiven == 'Yes')
                {!! $sex!!} received surfactant therapy.
                @else
                {!! $sex!!} did not receive surfactant therapy.
                @endif
                @if(!empty($NeedleThoracocentesis))
                {!! $sex !!} required needle thoracocentesis.
                @endif
                @if(!empty($intercostalDrain))
                {!! $sex !!} required insertion of an intercostal drain.
                @endif
                @if(!empty(trim($maxFiO2)) && $maxFiO2 != 0)
                {!! $passsex!!}  maximum oxygen requirment after admission to the Neonatal unit
                was {!! $maxFiO2 !!}%.
                @endif    
                @if(!empty($maxPIP))
                {!! $sex!!} required a maximum peak inspiratory pressure of  {!! $maxPIP !!} cm H2O.
                @endif
                @if(!empty(trim($maxOI)) && $maxOI != 0)
                {!! $passsex!!} maximum oxygenation index was  {!! $maxOI !!}.
                @endif
                @if(!empty(trim($Indication)))
                {!! $sex!!} required assisted respiratory support after admission to the neonatal unit due to  {!! $Indication !!}
                @endif
                @if(!empty($chronicLung))
                {!! $sex!!} was diagnosed with chronic lung disease. 
                @endif
                @if($result->HomeOxygen == 'No' && $result->Discharge_status !='Died' && $result->Discharge_status !='Died (OCNR)')
                {!! $sex!!} was spontaneously breathing in air with good saturation at the time of
                discharge.
                @elseif($result->HomeOxygen == 'Yes' && $result->Discharge_status !='Died' && $result->Discharge_status !='Died (OCNR)')
                {!! $sex!!} is discharged on home oxygen.
                @endif
                {!! $result->RespiratorySystemExtra !!}
            </div>
        </div>
        @endif
        <div class="respiratorysystem-report-editor editor-align @if(count($dischargeSummarymodified) >  0 && isset($dischargeSummarymodified['RespiratorySystem']) && !empty($dischargeSummarymodified['RespiratorySystem'])) @else hide @endif">
            <div class="editor-align-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'problem-status-modified']) !!}
                <label for="problem-status-modified"><span class="hidden-print"></span></label>
            </div>
            <div class="editor-align-content">
                {!! @$dischargeSummarymodified['RespiratorySystem'] !!}
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen newly-added">
        @php echo stripcslashes($respiratorysystem_status); @endphp
    </div>
    <div class="page-break-always"></div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
        <h6>                    
            <span class="check-box-div">
                {!! Form::checkbox('cardiovascularsystem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'cardiovascularsystem-status']) !!}
                <label for="cardiovascularsystem-status"><span class="hidden-print"></span></label>
            </span>
            <span class="custom-heading">Cardiovascular System:</span>
            {!! Form::hidden('CardiovascularSystem', @$dischargeSummarymodified['CardiovascularSystem']) !!}
            <a href="javascript:void(0);" class="hidden-print {!! $dischargeEditpermission !!}" title="Add">
                <i class="fa fa-plus add-diagnosis cardiovascularsystem-adding" aria-hidden="true"></i>
            </a>
            <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="cursor: pointer;" title="Edit">
                <i class="fa fa-pencil cardiovascularsystem-report-editing" aria-hidden="true"></i>
            </a>
        </h6>
        @if($daycaresheetscount != 0 && !empty($CardiovascularSystem))
        <div class="generated-content-container">
            <div class="generated-content-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'cardiovascularsystem-problem-status']) !!}
                <label for="cardiovascularsystem-problem-status"><span class="hidden-print"></span></label>
            </div>
            <div class="generated-content">
                {!! $CardiovascularSystem !!}
            </div>
        </div>
        @endif
        <div class="cardiovascularsystem-report-editor editor-align @if(count($dischargeSummarymodified) >  0 && isset($dischargeSummarymodified['CardiovascularSystem']) && !empty($dischargeSummarymodified['CardiovascularSystem'])) @else hide @endif">
            <div class="editor-align-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'cardiovascularsystem-details']) !!}
                <label for="cardiovascularsystem-details"><span class="hidden-print"></span></label>
            </div>
            <div class="editor-align-content">
                {!! @$dischargeSummarymodified['CardiovascularSystem'] !!}
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen newly-added">
        @php echo stripcslashes($cardiovascularsystem_status); @endphp
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
        <h6>                    
            <span class="check-box-div">
                {!! Form::checkbox('gastrointestinalsystem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'gastrointestinalsystem-status']) !!}
                <label for="gastrointestinalsystem-status"><span class="hidden-print"></span></label>
            </span>
            <span class="custom-heading">Gastrointestinal System:</span>
            {!! Form::hidden('GastrointestinalSystem', @$dischargeSummarymodified['GastrointestinalSystem']) !!}
            <a href="javascript:void(0);" class="hidden-print {!! $dischargeEditpermission !!}" title="Add">
                <i class="fa fa-plus add-diagnosis gastrointestinalsystem-adding" aria-hidden="true"></i>
            </a>
            <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="cursor: pointer;" title="Edit">
                <i class="fa fa-pencil gastrointestinalsystem-report-editing" aria-hidden="true"></i>
            </a>
        </h6>
        @if($daycaresheetscount != 0 && (!empty($GastrointestinalSystem) || !empty($UltrasoundAbdominal)))
        <div class="generated-content-container">
            <div class="generated-content-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'gastrointestinalsystem-problem-status']) !!}
                <label for="gastrointestinalsystem-problem-status"><span class="hidden-print"></span></label>
            </div>
            <div class="generated-content">
                @if($daycaresheetscount != 0 && !empty($GastrointestinalSystem))
                {!! $GastrointestinalSystem !!}
                @endif 
                @if(!empty($UltrasoundAbdominal))
                The baby underwent a abdominal ultrasound scan and key findings are given below
                <table>
                    <tr>
                        <th>Date</th>
                        <th>Findings</th>
                    </tr>
                    @foreach($UltrasoundAbdominalkeys as $temp_findings)
                    <tr>
                        <td>{!! $temp_findings['Dateofultrasound'] !!}</td>
                        <td>{!! empty($temp_findings['abdominalultrasoundkeyfindings']) ? 'N/A' : $temp_findings['abdominalultrasoundkeyfindings'] !!}</td>
                    </tr>
                    @endforeach
                </table>
                @endif  
            </div>
        </div>
        @endif   
        <div class="gastrointestinalsystem-report-editor editor-align @if(count($dischargeSummarymodified) >  0 && isset($dischargeSummarymodified['GastrointestinalSystem']) && !empty($dischargeSummarymodified['GastrointestinalSystem'])) @else hide @endif">
            <div class="editor-align-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'gastrointestinalsystem-modified']) !!}
                <label for="gastrointestinalsystem-modified"><span class="hidden-print"></span></label>
            </div>
            <div class="editor-align-content">
                {!! @$dischargeSummarymodified['GastrointestinalSystem'] !!}
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen newly-added">
        @php echo stripcslashes($gastrointestinalsystem_status); @endphp
    </div>
    <div class="page-break"></div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
        <h6>                    
            <span class="check-box-div">
                {!! Form::checkbox('centralnervoussystem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'centralnervoussystem-status']) !!}
                <label for="centralnervoussystem-status"><span class="hidden-print"></span></label>
            </span>
            <span class="custom-heading">Central Nervous System:</span>
            {!! Form::hidden('CentralNervousSystem', @$dischargeSummarymodified['CentralNervousSystem']) !!}
            <a href="javascript:void(0);" class="hidden-print {!! $dischargeEditpermission !!}" title="Add">
                <i class="fa fa-plus add-diagnosis centralnervoussystem-adding" aria-hidden="true"></i>
            </a>
            <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style=" cursor: pointer;" title="Edit">
                <i class="fa fa-pencil centralnervoussystem-report-editing" aria-hidden="true"></i>
            </a>
        </h6>
        @if($daycaresheetscount != 0 && !empty($CentralNervousSystem))
        <div class="generated-content-container">
            <div class="generated-content-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'centralnervoussystem-problem-status']) !!}
                <label for="centralnervoussystem-problem-status"><span class="hidden-print"></span></label>
            </div>
            <div class="generated-content">
                {!! $CentralNervousSystem !!}
            </div>
        </div>
        @endif   
        <div class="centralnervoussystem-report-editor editor-align @if(count($dischargeSummarymodified) >  0 && isset($dischargeSummarymodified['CentralNervousSystem']) && !empty($dischargeSummarymodified['CentralNervousSystem'])) @else hide @endif">
            <div class="editor-align-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'centralnervoussystem-modified']) !!}
                <label for="centralnervoussystem-modified"><span class="hidden-print"></span></label>
            </div>
            <div class="editor-align-content">
                {!! @$dischargeSummarymodified['CentralNervousSystem'] !!}
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen newly-added">
        @php echo stripcslashes($centralnervoussystem_status); @endphp
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
        <h6>                    
            <span class="check-box-div">
                {!! Form::checkbox('sepsis-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'sepsis-status']) !!}
                <label for="sepsis-status"><span class="hidden-print"></span></label>
            </span>
            <span class="custom-heading">Sepsis:</span>
            {!! Form::hidden('Sepsis', @$dischargeSummarymodified['Sepsis']) !!}
            <a href="javascript:void(0);" class="hidden-print {!! $dischargeEditpermission !!}" title="Add">
                <i class="fa fa-plus add-diagnosis sepsis-adding" aria-hidden="true"></i>
            </a>
            <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="cursor: pointer;" title="Edit">
                <i class="fa fa-pencil sepsis-report-editing" aria-hidden="true"></i>
            </a>
        </h6>
        @if($daycaresheetscount != 0 && !empty($Sepsis))
        <div class="generated-content-container">
            <div class="generated-content-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'sepsis-summary']) !!}
                <label for="sepsis-summary"><span class="hidden-print"></span></label>
            </div>
            <div class="generated-content">
                {!! $Sepsis !!}
            </div>
        </div>
        @endif   
        <div class="sepsis-report-editor editor-align @if(count($dischargeSummarymodified) >  0 && isset($dischargeSummarymodified['Sepsis']) && !empty($dischargeSummarymodified['Sepsis'])) @else hide @endif">
            <div class="editor-align-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'sepsis-modified']) !!}
                <label for="sepsis-modified"><span class="hidden-print"></span></label>
            </div>
            <div class="editor-align-content">
                {!! @$dischargeSummarymodified['Sepsis'] !!}
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen newly-added">
        @php echo stripcslashes($sepsis_status); @endphp
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
        <h6>                    
            <span class="check-box-div">
                {!! Form::checkbox('ophthalmology-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'ophthalmology-status']) !!}
                <label for="ophthalmology-status"><span class="hidden-print"></span></label>
            </span>
            <span class="custom-heading">Ophthalmology:</span>
            {!! Form::hidden('Ophthalmology', @$dischargeSummarymodified['Ophthalmology']) !!}
            <a href="javascript:void(0);" class="hidden-print {!! $dischargeEditpermission !!}" title="Add">
                <i class="fa fa-plus add-diagnosis ophthalmology-adding" aria-hidden="true"></i>
            </a>
            <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="cursor: pointer;" title="Edit">
                <i class="fa fa-pencil ophthalmology-report-editing" aria-hidden="true"></i>
            </a>
        </h6>
        @if($daycaresheetscount != 0 && !empty($Ophthalmology))
        <div class="generated-content-container">
            <div class="generated-content-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'ophthalmology-summary']) !!}
                <label for="ophthalmology-summary"><span class="hidden-print"></span></label>
            </div>
            <div class="generated-content">
                {!! $Ophthalmology !!}
            </div>
        </div>
        @endif   
        <div class="ophthalmology-report-editor editor-align @if(count($dischargeSummarymodified) >  0 && isset($dischargeSummarymodified['Ophthalmology']) && !empty($dischargeSummarymodified['Ophthalmology'])) @else hide @endif">
            <div class="editor-align-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'ophthalmology-modified']) !!}
                <label for="ophthalmology-modified"><span class="hidden-print"></span></label>
            </div>
            <div class="editor-align-content">
                {!! @$dischargeSummarymodified['Ophthalmology'] !!}
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen newly-added">
        @php echo stripcslashes($ophthalmology_status); @endphp
    </div>
    <div class="page-break"></div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
        <h6>                    
            <span class="check-box-div">                                
                {!! Form::checkbox('hematology-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'hematology-status']) !!}
                <label for="hematology-status"><span class="hidden-print"></span></label>
            </span>
            <span class="custom-heading">Renal, Hematology, electrolytes, Glucose and Jaundice:</span>
            {!! Form::hidden('Hematology', @$dischargeSummarymodified['Hematology']) !!}
            <a href="javascript:void(0);" class="hidden-print {!! $dischargeEditpermission !!}" title="Add">
                <i class="fa fa-plus add-diagnosis hematology-adding" aria-hidden="true"></i>
            </a>
            <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="cursor: pointer;" title="Edit">
                <i class="fa fa-pencil hematology-report-editing" aria-hidden="true"></i>
            </a>
        </h6>
        @if($daycaresheetscount != 0)
        <div class="generated-content-container">
            <div class="generated-content-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'hematology-summary']) !!}
                <label for="hematology-summary"><span class="hidden-print"></span></label>
            </div>
            <div class="generated-content">
                {!! $Hematology !!}
                @if(count($Hypoglycemia) != 0)
                {!! $sex!!} developed the following electrolyte abnormalities, which were managed
                effectively as per our unit guidelines
                <ul>
                    @foreach ($Hypoglycemia as $key => $value)
                    <li>{!! $value !!}</li>
                    @endforeach
                </ul>
                @endif
                {!! $InsulinTherapytext !!}
                @if(count($NNJTreatments) != 0)
                {!! $sex !!} received the following treatment for neonatal jaundice
                <ul>
                    @foreach ($NNJTreatments as $key => $value)
                    <li>{!! $value !!}</li>
                    @endforeach
                </ul>
                @endif
                {!! $Hematologytext !!}
                @if(!empty($RenalUltrasound))
                The baby underwent a renal ultrasound scan and key findings are below 
                <table>
                    <tr>
                        <th>Date</th>
                        <th>Findings</th>
                    </tr>
                    <tr>
                        @foreach($RenalUltrasoundkeys as $RenalUltrasoundfindings)
                        <td>{!! $RenalUltrasoundfindings['Dateofultrasound'] !!}</td>
                        <td> {!! empty($RenalUltrasoundfindings['renalultrasoundkeyfindings']) ? 'N/A' : $RenalUltrasoundfindings['renalultrasoundkeyfindings']   !!}</td>
                        @endforeach 
                    </tr>
                </table>
                @endif
            </div>
        </div>
        @endif   
        <div class="hematology-report-editor editor-align @if(count($dischargeSummarymodified) >  0 && isset($dischargeSummarymodified['Hematology']) && !empty($dischargeSummarymodified['Hematology'])) @else hide @endif">
            <div class="editor-align-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'hematology-modified']) !!}
                <label for="hematology-modified"><span class="hidden-print"></span></label>
            </div>
            <div class="editor-align-content">
                {!! @$dischargeSummarymodified['Hematology'] !!}
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen newly-added">
        @php echo stripcslashes($hematology_status); @endphp
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
        <h6>                    
            <span class="check-box-div">                                
                {!! Form::checkbox('newbornscreening-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'newbornscreening-status']) !!}
                <label for="newbornscreening-status"><span class="hidden-print"></span></label>
            </span>
            <span class="custom-heading">Newborn Screening:</span>
            {!! Form::hidden('NewbornScreening', @$dischargeSummarymodified['NewbornScreening']) !!}
            <a href="javascript:void(0);" class="hidden-print {!! $dischargeEditpermission !!}" title="Add">
                <i class="fa fa-plus add-diagnosis newbornscreening-adding" aria-hidden="true"></i>
            </a>
            <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="cursor: pointer;" title="Edit">
                <i class="fa fa-pencil newbornscreening-report-editing" aria-hidden="true"></i>
            </a>
        </h6>
        @if($daycaresheetscount != 0 && !empty($NewbornScreening))
        <div class="generated-content-container">
            <div class="generated-content-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'newbornscreening-summary']) !!}
                <label for="newbornscreening-summary"><span class="hidden-print"></span></label>
            </div>
            <div class="generated-content">
                {!! $NewbornScreening !!}
            </div>
        </div>
        @endif   
        <div class="newbornscreening-report-editor editor-align @if(count($dischargeSummarymodified) >  0 && isset($dischargeSummarymodified['NewbornScreening']) && !empty($dischargeSummarymodified['NewbornScreening'])) @else hide @endif">
            <div class="editor-align-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'newbornscreening-modified']) !!}
                <label for="newbornscreening-modified"><span class="hidden-print"></span></label>
            </div>
            <div class="editor-align-content">
                {!! @$dischargeSummarymodified['NewbornScreening'] !!}
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen newly-added">
        @php echo stripcslashes($newbornscreening_status); @endphp
    </div>
    <div class="page-break"></div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
        <h6>                    
            <span class="check-box-div">                                
                {!! Form::checkbox('communicationwithparents-status', '', true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'communicationwithparents-status']) !!}
                <label for="communicationwithparents-status"><span class="hidden-print"></span></label>
            </span>
            <span class="custom-heading">Communication with parents:</span>
            {!! Form::hidden('Communicationwithparents', @$dischargeSummarymodified['Communicationwithparents']) !!}
            <a href="javascript:void(0);" class="hidden-print {!! $dischargeEditpermission !!}" title="Add">
                <i class="fa fa-plus add-diagnosis communicationwithparents-adding" aria-hidden="true"></i>
            </a>
            <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="cursor: pointer;" title="Edit">
                <i class="fa fa-pencil communicationwithparents-report-editing" aria-hidden="true"></i>
            </a>
        </h6>
        @if($daycaresheetscount != 0)
        <div class="generated-content-container">
            <div class="generated-content-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'communicationwithparents-summary']) !!}
                <label for="communicationwithparents-summary"><span class="hidden-print"></span></label>
            </div>
            <div class="generated-content">
                Parents were fully updated regarding {!! strtolower($passsex)!!} daily progress in the
                neonatal unit and they were provided with sufficient opportunities to clarify their
                questions.
                {!! $Communicationwithparents !!}
            </div>
        </div>
        @endif   
        <div class="communicationwithparents-report-editor editor-align @if(count($dischargeSummarymodified) >  0 && isset($dischargeSummarymodified['Communicationwithparents']) && !empty($dischargeSummarymodified['Communicationwithparents'])) @else hide @endif">
            <div class="editor-align-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'communicationwithparents-modified']) !!}
                <label for="communicationwithparents-modified"><span class="hidden-print"></span></label>
            </div>
            <div class="editor-align-content">
                {!! @$dischargeSummarymodified['Communicationwithparents'] !!}
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen newly-added">
        @php echo stripcslashes($communicationwithparents_status); @endphp
    </div>
    @if(!empty($result->DischargeHb) ||  !empty($result->DischargePCV) || !empty($result->DischargeTSB) || !empty($result->DischargeSerumCa) || !empty($result->DischargeSerumPo4) || !empty($result->DischargeSerumALP) || !empty($result->DischargeSerumNa))
    <div class="page-break"></div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
        <h6>                    
            <span class="check-box-div">                                
                {!! Form::checkbox('investigations-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'investigations-status']) !!}
                <label for="investigations-status"><span class="hidden-print"></span></label>
            </span>
            <span class="custom-heading">Investigations:</span>
            {!! Form::hidden('Investigations', @$dischargeSummarymodified['Investigations']) !!}
            <a href="javascript:void(0);" class="hidden-print {!! $dischargeEditpermission !!}" title="Add">
                <i class="fa fa-plus add-diagnosis investigations-adding" aria-hidden="true"></i>
            </a>
            <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="cursor: pointer;" title="Edit">
                <i class="fa fa-pencil investigations-report-editing" aria-hidden="true"></i>
            </a>
        </h6>
        @if($daycaresheetscount != 0)
        <div class="generated-content-container">
            <div class="generated-content-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'investigation-summary']) !!}
                <label for="investigation-summary"><span class="hidden-print"></span></label>
            </div>
            <div class="generated-content">
                {!! $passsex !!} latest blood investigations showed the following results 
                <ul>
                    @if(!empty($result->DischargeHb))
                    <li>Hemoglobin (g/dl) : {!! $result->DischargeHb !!}</li>
                    @endif
                    @if(!empty($result->DischargePCV))
                    <li>Hematocrit (PCV) (%) : {!! $result->DischargePCV !!}</li>
                    @endif
                    @if(!empty($result->DischargeTSB))
                    <li>Total Serum Bilirubin (mg/dl) : {!! $result->DischargeTSB !!}</li>
                    @endif
                    @if(!empty($result->DischargeSerumCa))
                    <li>Calcium (mg/dl) : {!! $result->DischargeSerumCa !!}</li>
                    @endif 
                    @if(!empty($result->DischargeSerumPo4))
                    <li>Phosphate (mg/dl) : {!! $result->DischargeSerumPo4 !!}</li>
                    @endif
                    @if(!empty($result->DischargeSerumALP))
                    <li>Alkaline Phosphatase (IU/L) : {!! $result->DischargeSerumALP !!}</li>
                    @endif
                    @if(!empty($result->DischargeSerumNa))
                    <li>Sodium (mmol/L) : {!! $result->DischargeSerumNa !!}</li>
                    @endif
                </ul>
                {!! $Investigations !!}
            </div>
        </div>
        @endif   
        <div class="investigations-report-editor editor-align @if(count($dischargeSummarymodified) >  0 && isset($dischargeSummarymodified['Investigations']) && !empty($dischargeSummarymodified['Investigations'])) @else hide @endif">
            <div class="editor-align-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'investigation-modified']) !!}
                <label for="investigation-modified"><span class="hidden-print"></span></label>
            </div>
            <div class="editor-align-content">
                {!! @$dischargeSummarymodified['Investigations'] !!}
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen newly-added">
        @php echo stripcslashes($investigations_status); @endphp
    </div>
    @endif 
    @if (strlen($result->additional_information) > 0)
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
        <h6>                    
            <span class="check-box-div">                                
                {!! Form::checkbox('addedinfo-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'addedinfo-status']) !!}
                <label for="addedinfo-status"><span class="hidden-print"></span></label>
            </span>
            <span class="custom-heading">Additional Information:</span>
            {!! Form::hidden('additional_information', @$dischargeSummarymodified['additional_information']) !!}
            <a href="javascript:void(0);" class="hidden-print {!! $dischargeEditpermission !!}" title="Add">
                <i class="fa fa-plus add-diagnosis addedinfo-adding" aria-hidden="true"></i>
            </a>
            <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="cursor: pointer;" title="Edit">
                <i class="fa fa-pencil addedinfo-report-editing" aria-hidden="true"></i>
            </a>
        </h6>
        @if($daycaresheetscount != 0)
        <div class="generated-content-container">
            <div class="generated-content-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'remove-addedinfo']) !!}
                <label for="remove-addedinfo"><span class="hidden-print"></span></label>
            </div>
            <div class="generated-content">                
                {!! $result->additional_information !!}
            </div>
        </div>
        @endif 
        <div class="addedinfo-report-editor editor-align @if(count($dischargeSummarymodified) >  0 && isset($dischargeSummarymodified['additional_information']) && !empty($dischargeSummarymodified['additional_information'])) @else hide @endif">
            <div class="editor-align-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'addedinfo-modified']) !!}
                <label for="addedinfo-modified"><span class="hidden-print"></span></label>
            </div>
            <div class="editor-align-content">
                {!! @$dischargeSummarymodified['additional_information'] !!}
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen newly-added">
        @php echo stripcslashes($addedinfo_status); @endphp
    </div>
    @endif
    
    
    <div class="@if($result->Discharge_status!='Died' && $result->Discharge_status!='Died (OCNR)') @else hide @endif for-discharge">
    <div class="@if($result->status != 'Inpatient') @else hide @endif for-discharge">
        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
            <h6>                    
                <span class="check-box-div">                                
                    {!! Form::checkbox('dischargemedications-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'dischargemedications-status']) !!}
                    <label for="dischargemedications-status"><span class="hidden-print"></span></label>
                </span>
                <span class="custom-heading">Discharge Medications:</span>
                {!! Form::hidden('DischargeMedications', @$dischargeSummarymodified['DischargeMedications']) !!}
                <a href="javascript:void(0);" class="hidden-print {!! $dischargeEditpermission !!}" title="Add">
                    <i class="fa fa-plus add-diagnosis dischargemedications-adding" aria-hidden="true"></i>
                </a>
                <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="cursor: pointer;" title="Edit">
                    <i class="fa fa-pencil dischargemedications-report-editing" aria-hidden="true"></i>
                </a>
            </h6>
            @if($daycaresheetscount != 0)
            <div class="generated-content-container">
                <div class="generated-content-checkbox-div">
                    {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'remove-drugs']) !!}
                    <label for="remove-drugs"><span class="hidden-print"></span></label>
                </div>
                <div class="generated-content">
                    @php $show_instruction = false; @endphp
                    @if (count($discharge_medications) > 0 && count(collect($discharge_medications)->where('additional_instruction', '<>', null)->where('additional_instruction', '<>', '')->toArray()) > 0)
                    @php $show_instruction = true; @endphp
                    @endif
                    <table class="table col-md-12 mb-0">
                        <tr>
                            <td>DRUG</td>
                            <td>GENERIC NAME</td>
                            <td>FORMULATION</td>
                            <td>DOSE</td>
                            <td>FREQUENCY</td>
                            <td>DURATION</td>
                            @if ($show_instruction)
                            <td>ADDITIONAL INSTRUCTION</td>
                            @endif
                        </tr>
                        @php $frequency_list = ValuelistHelpers::drugFrequencyList(); @endphp
                        @if(count($discharge_medications) > 0 )
                        @if($daycaresheetscount != 0)
                        @foreach($discharge_medications as $key =>  $value)
                        <tr>
                            <td>{!! $value->Name !!}</td>
                            <td>{!! $value->genericname !!}</td>
                            <td>{!! $value->value !!}</td>
                            <td>{!! $value->Dose !!}</td>
                            <td>{!! isset($frequency_list[$value->Frequency]) ? $frequency_list[$value->Frequency] : $value->Frequency !!}</td>
                            <td>{!! $value->Duration !!}</td>
                            @if ($show_instruction)
                            <td>{!! $value->additional_instruction !!}</td>
                            @endif
                        </tr>
                        @endforeach
                        @endif 
                        @else
                        <tr>
                            <td colspan="6" style="text-align: center;">None Prescribed</td>
                        </tr>
                        @endif
                    </table>
                    {!! $Investigations !!}
                </div>
            </div>
            @endif   
            <div class="dischargemedications-report-editor editor-align @if(count($dischargeSummarymodified) >  0 && isset($dischargeSummarymodified['DischargeMedications']) && !empty($dischargeSummarymodified['DischargeMedications'])) @else hide @endif">
                <div class="editor-align-checkbox-div">
                    {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'DischargeMedications']) !!}
                    <label for="DischargeMedications"><span class="hidden-print"></span></label>
                </div>
                <div class="editor-align-content">
                    {!! @$dischargeSummarymodified['DischargeMedications'] !!}
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen newly-added">
            @php echo stripcslashes($dischargemedications_status); @endphp
        </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
        <h6>                    
            <span class="check-box-div">                                
                {!! Form::checkbox('vaccine-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'vaccine-status']) !!}
                <label for="vaccine-status"><span class="hidden-print"></span></label>
            </span>
            <span class="custom-heading">Vaccine:</span>
            {!! Form::hidden('vaccine', @$dischargeSummarymodified['vaccine']) !!}
            <a href="javascript:void(0);" class="hidden-print {!! $dischargeEditpermission !!}" title="Add">
                <i class="fa fa-plus add-diagnosis vaccine-adding" aria-hidden="true"></i>
            </a>
            <a href="javascript:void(0);" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="cursor: pointer;" title="Edit">
                <i class="fa fa-pencil vaccine-report-editing" aria-hidden="true"></i> 
            </a>
        </h6>
        <div class="generated-content-container">
            <div class="generated-content-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'vaccine_drug_remove']) !!}
                <label for="vaccine_drug_remove"><span class="hidden-print"></span></label>
            </div>
            @php 
            $vaccinelist = array_map('array_filter', $vaccinelist); 
            $vaccinelist = array_filter($vaccinelist); 
            @endphp
            <div class="generated-content">
                @if (is_array($vaccinelist) && count($vaccinelist) > 0)
                <table class="col-md-6 col-sm-6 col-xs-6">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vaccinelist as $vaccinename)
                        <tr>
                            <td>{!! isset($vaccinename['vaccineName']) ? $vaccinename['vaccineName'] : '' !!}</td>
                            <td>{!! (!isset($vaccinename['vaccineDate']) && @unserialize($vaccinename['vaccineDate']) === false) ? '' : $vaccinename['vaccineDate'] !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                Vaccinations due as per National or IAP immunisation schedule.
                @endif
            </div>
        </div>
        <div class="vaccine-report-editor editor-align @if(count($dischargeSummarymodified) >  0 && isset($dischargeSummarymodified['vaccine']) && !empty($dischargeSummarymodified['vaccine'])) @else hide @endif">
            <div class="editor-align-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'vaccine-modified']) !!}
                <label for="vaccine-modified"><span class="hidden-print"></span></label>
            </div>
            <div class="editor-align-content">
                {!! @$dischargeSummarymodified['vaccine'] !!}    
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen newly-added">
        @php echo stripcslashes($vaccine_status); @endphp
    </div>
    
    <div class="@if($result->status != 'Inpatient') @else hide @endif for-discharge">
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
        <h6>                    
            <span class="check-box-div">                                
                {!! Form::checkbox('dischargeinstruction-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'dischargeinstruction-status']) !!}
                <label for="dischargeinstruction-status"><span class="hidden-print"></span></label>
            </span>
            <span class="custom-heading">Discharge Instructions:</span>
            {!! Form::hidden('DischargeInstructions', @$dischargeSummarymodified['DischargeInstructions']) !!}
            <a href="javascript:void(0);" class="hidden-print {!! $dischargeEditpermission !!}" title="Add">
                <i class="fa fa-plus add-diagnosis dischargeinstructions-adding" aria-hidden="true"></i>
            </a>
            <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="cursor: pointer;" title="Edit">
                <i class="fa fa-pencil dischargeinstructions-report-editing" aria-hidden="true"></i>
            </a>
        </h6>
        <div class="generated-content-container">
            <div class="generated-content-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'dischargeinstructions']) !!}
                <label for="dischargeinstructions"><span class="hidden-print"></span></label>
            </div>
            <div class="generated-content">
                @if($daycaresheetscount != 0)
                {!! $headerContent['discharge_instraction'] !!}
                @endif 
                {!! \ValuelistHelpers::summaryFooter($result->hospital_name, $headerContent) !!} 
            </div>
        </div>
        <div class="dischargeinstructions-report-editor editor-align @if(count($dischargeSummarymodified) >  0 && isset($dischargeSummarymodified['DischargeInstructions'])) @else hide @endif">
            <div class="editor-align-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'dischargeinstruction-modified']) !!}
                <label for="dischargeinstruction-modified"><span class="hidden-print"></span></label>
            </div>
            <div class="editor-align-content">
                {!! @$dischargeSummarymodified['DischargeInstructions'] !!}
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen newly-added">
        @php echo stripcslashes($dischargeinstruction_status); @endphp
    </div>
    
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page @if($result->status != 'Inpatient') @else hide @endif for-discharge">
        <h6>                    
            <span class="check-box-div">                                
                {!! Form::checkbox('followup-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'followup-status']) !!}
                <label for="followup-status"><span class="hidden-print"></span></label>
            </span>
            <span class="custom-heading">Follow Up:</span>
            {!! Form::hidden('Followup', @$dischargeSummarymodified['Followup']) !!}
            <a href="javascript:void(0);" class="hidden-print {!! $dischargeEditpermission !!}" title="Add">
                <i class="fa fa-plus add-diagnosis followup-adding" aria-hidden="true"></i>
            </a>
            <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="cursor: pointer;" title="Edit">
                <i class="fa fa-pencil followup-report-editing" aria-hidden="true"></i>
            </a>
        </h6>
        @if($daycaresheetscount != 0)
        <div class="generated-content-container">
            <div class="generated-content-checkbox-div">
                {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'NextAppointment']) !!}
                <label for="NextAppointment"><span class="hidden-print"></span></label>
            </div>
            <div class="generated-content">
                @if (strlen($result->advice) > 0)
                <p>{{$result->advice}}</p>
                @endif
                @if (strlen($result->plan_follow_up) > 0)
                <p>{{$result->plan_follow_up}}</p>
                @endif
                @if( date('Y', strtotime($result->NextAppointment)) <= 1970 || $result->NextAppointment == '0000-00-00' )
                    A neonatal follow up has not been arranged with us and we recommend local Paediatric
                    follow up.
                    @else
                    A neonatal outpatient appointment has been made
                    on {!! date('d-m-Y', strtotime($result->NextAppointment)) !!}
                    at {!! $result->NAT_TIME !!} :
                    @if(strlen($result->NAT_MINS) == 1)
                    0{!! $result->NAT_MINS !!} @else {!! $result->NAT_MINS !!} @endif
                    {!! $result->NAT_AM !!}
                    @endif
                    {!! $Followup !!}
                </div>
            </div>
        @endif  
        <div class="followup-report-editor editor-align @if(count($dischargeSummarymodified) >  0 && isset($dischargeSummarymodified['Followup']) && !empty($dischargeSummarymodified['Followup'])) @else hide @endif">
                <div class="editor-align-checkbox-div">
                    {!! Form::checkbox('problem-status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'NextAppointment-modified']) !!}
                    <label for="NextAppointment-modified"><span class="hidden-print"></span></label>
                </div>
                <div class="editor-align-content">
                    {!! @$dischargeSummarymodified['Followup'] !!}
                </div>
        </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen newly-added">
            @php echo stripcslashes($followup_status); @endphp
        </div>
    @if($result->status != 'Inpatient')
        <div class="col-md-12 col-sm-12 col-xs-12 hidden-print {!! $dischargeEditpermission !!} mt-15">
            {!! Form::label('is_completed','Is Summary Completed ? ') !!}<input id="is_completed" name="is_completed" data-on="Completed" data-off="Not Completed" data-toggle="toggle" data-width="150" data-size="small"  type="checkbox">
        </div>
    @endif 
        <div class="col-md-12 col-sm-12 col-xs-12 hidden-print mt-15">
            <div class=" display-flex" style="align-items: center;">
                {!! Form::label('is_completed','Do you want to send summary for any email Id ? ') !!}
                <input type="email" name="summary_mail" class="form-control input-width-xlarge" />
                <input id="is_send" name="is_send" data-on="Send" data-off="Not Send" data-toggle="toggle" data-width="150" data-size="small"  type="checkbox">
            </div>
            <div class="error-message display-none text-center">Please enter valid Mail Id</div>
        </div>
    </div>
    <div class="col-md-12 discharge-info page-break-page">
        <div class="col-xs-3 col-md-3 col-sm-3 pull-left page-break-page" style="margin-top: 15px; margin-bottom: 15px;">
            <ul class="plr-must-0" style="list-style: none;">
                @if($result->status != 'Inpatient')
                <li>Date : {!! $result->DischargeDate !!} </li>
                @else
                <li>Date : {!! date('d-m-Y') !!} </li>
                @endif
                <li>Place : {!! env('LOCATION') !!} </li>
            </ul>
        </div>
        <div class="col-xs-8 col-md-8 col-sm-8 page-break-page" style="margin-top: 15px; margin-bottom: 15px;">
          {!! $result->neonatal_consultant !!}

      </div>
  </div>
</div>
{!! Form::close() !!}



<div class="modal flow-control-modal fade" id="discharge-details" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-center text-white">Do you want to include discharge details ?</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button> 
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('temp_status','Status:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::select('temp_status',ValuelistHelpers::Discharge_Status(),null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('temp_discharge_date','Date of Discharge / Transfered:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::date('temp_discharge_date',null,['class'=>'form-control datepicker']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('temp_discharge_weight','Discharge Weight (In grams):') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('temp_discharge_weight',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('temp_ofc','OFC in cm:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('temp_ofc',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('temp_length','Length in cm:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('temp_length',null,['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: white;">
                <div class="row mx-0">
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-theme-primary" id="discharge-data"><i class="fa fa-save"></i> Apply</button>
                        <button type="button" class="btn btn-secondary" id="cancel-data"><i class="fa fa-refresh"></i> Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    @if(isset($dischargeSummarymodified['is_completed']) && $dischargeSummarymodified['is_completed'] == 2)
    $('#is_completed').bootstrapToggle('on');
    @endif

    @if(isset($dischargeSummarymodified['is_send']) && $dischargeSummarymodified['is_send'] == 2)
    $('#is_send').bootstrapToggle('on');
    @endif

    $('#is_send').on('change',function(){
      $('input[name="status"]').val(1);
      $('.savebtn').removeClass('hide');
  });
    // $('.neonatal-intensive-care-save').click(function(){

    //  if(checkActiveeditor()){

    //   bootbox.confirm("Are you sure want save changes ?",function(confirmed){
    //     if(confirmed){

    //       $('form').submit();

    // $.ajax({
    //          type    :"POST",
    //          url     : "{!! url('nicu-discharge-reports') !!}",
    //          data    :$('form').serialize(),
    //          cache   : false,
    //          dataType: "json",
    //          success:function(response){

    //            $('.neonatal-intensive-care-default').parent().removeClass('hide');
    //            $('.neonatal-intensive-care-default').removeClass('hide');
    //           responseMessageajax(response.code,response.message);  
    //          },
    //          error: function(response) {
    //            Showalert('error','Record Not Saved. Try after some time !');  
    
    //          }
    //  });
// }
// });

  // }else{
  //     Showalert('warning','Please close editor before save !');
  // }     


// });
    $('.neonatal-intensive-care-default').click(function(){

       var babyId=$('input[name="BabyId"]').val();

       bootbox.confirm(" Are you sure want go for Default ?",function(confirmed){

        if(confirmed){

          $.ajax({
            type    :"GET",
            url     : '{!! url("nicu-discharge-remove") !!}',
            data    :{ babyId:babyId },
            dataType: "json",
            cache   : false,                          
            success:function(response){

              Showalert('info','Report changed  with system report !');
              location.reload(); 

          },
          error: function(response) {

           Showalert('error','Report Not Chaned !');


       }

   });
      }
  });          

   });

    $('.open-editor').click(function(){

        bootbox.confirm("If you edit this document, the changes will not be reflected in the main database and vice versa. Do you still want to continue?",function(confirmed){
            if(confirmed){
                var requestUrl = "{!! url('nicu-abbrivated-summary/'.Request::segment(2)) !!}@if(isset($summary_type) && $summary_type == 'interim')/interim @endif";

                $.ajax({
                 type:"GET",
                 url:'{!! url("nicu-discharge-reports-editors") !!}',
                 data:{dataUrl:requestUrl},
                 cache:false,
                 dataType: "json",
                 success:function(responseText){
                     window.location = requestUrl;
                 },
                 error:function(response){

                 }

             });
            }
        });
    });

    $(document).on("change", "input[name='summary_mail'], #is_send", function(){
      var mailvalidation = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
      if ($('input[name="summary_mail"]').val() != '' || $('#is_send').prop('checked')) {
          if (mailvalidation.test($('input[name="summary_mail"]').val())) {
              $(".error-message").css('display','none');
          } else {
              $(".error-message").css('display','block');
          }
      } else if (!$('#is_send').prop('checked')) {
          $(".error-message").css('display','none');
      } 
  });

    $('.new-report-editing').parent('a').addClass($('input[name="discharge_summary_edit_option"]').val());

</script>
@include('reports.copy_summary_list_script')
@endsection

