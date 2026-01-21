@extends('print')
@section('content')
@php $public_url =url('public').'/'; @endphp
@if (isset($editor_gen) && $editor_gen)
<div class="editor_style">
    @include('editor_print')  
</div>
@endif
<link rel="stylesheet" type="text/css" href="{{$public_url}}/css/postnatal-summary.css">
{!! Form::model(null,['method' => 'POST','url' => action('Reports\PostnatalDischargeSummary@store',null), 'id'=>'post-problem-summary']) !!}    
{{ Form::hidden('baby_id', $postanatal_details->BabyId) }}
{{ Form::hidden('admission_id', $postanatal_details->AdmissionId) }}
@php $newproblem = unserialize($postanatal_details->newproblem); @endphp
<div class="temp-container postnatal-summary @if(!in_array('POST_DISCHARGE', \Session::get('write_permission'))) hide-customization @endif">
    <div class="temp-row">
        <div class="col-md-12 @if(isset($headerContent['header_required']) && $headerContent['header_required'] == 1) hide @endif">
            <img src="{{ SiteHelpers::getPostnatalLogo($postnatalDetails->pid) }}" class="logo-align"> 
            @if ($postnatalDetails->hospital_name != 'Sudha Hospital' && $postnatalDetails->hospital_name != 'Saraswathi Nursing Home')
            <img src="{{url('public/img/nabh.png')}}" class="pull-right mr-15 nabh-logo">
            @endif
        </div>
        <div class="@if(isset($headerContent['header_required']) && $headerContent['header_required'] == 1) hide @endif mb-15 ml-15">
            <h5 class="mt-0"><strong>{!! \ValuelistHelpers::getHospitalsDetails($postnatalDetails->hospital_name, $headerContent) !!}</strong> </h5>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 plr-must-0 @if(isset($headerContent['header_required']) && $headerContent['header_required'] == 1) header-down @endif">
            <div id="patient-list" class="postnatal-pull-left">
                <div id="company">
                   <!--  <div>
                        <span class="text-underline font-em"> CONSULTANTS</span>
                    </div> -->
                    {!! $headerContent['discharge_report_right'] !!}
                </div>
            </div>
            <div id="doctor-list" class="postnatal-pull-left">
                <div id="project">
                    {!! \ValuelistHelpers::headerContent($postnatalDetails->hospital_name, $headerContent) !!}
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 plr-must-0 mt-10">
            <h5 class="text-center">
                <strong>Neonatal Unit - Discharge Summary</strong>
            </h5>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 plr-must-0">
            <div class="col-xs-6 col-sm-6 col-md-6">
                @if($backgorund->obstetric_consultant != 0 && !is_null($backgorund->obstetric_consultant)) Consultant OBG :
                <div>
                    {!! ValuelistHelpers::mas_doctors_list($backgorund->obstetric_consultant) !!}
                </div>
                @endif 
            </div>
            <div class="col-md-offset-1 col-xs-6 col-sm-6 col-md-5 pl-10">
                <div class="full-width pull-left">
                    <div class="pull-right">
                        Status : {{ $postnatalDetails->discharge_status }}
                    </div>
                </div>
                <div class="full-width pull-left">
                    <div class="pull-right">
                        {{ ($postnatalDetails->discharge_status == 'Died') ? 'Date of Death' : 'Date of Discharge'}} : {{ date('d-m-Y', strtotime($postnatalDetails->discharge_date)) }} 
                    </div>
                </div>
                @if($postnatalDetails->discharge_status == 'Died')
                <div class="full-width pull-left">
                    <div class="pull-right"> 
                        Time of Death: {{ $postnatalDetails->diedTime.' :'.$postnatalDetails->diedMins.':'.$postnatalDetails->diedAm }}
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <hr style="margin-top:0px;border-top:2px solid #000;margin-bottom:10px;">
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 postnatal-summary-content">
            <div class="col-md-12 col-sm-12 col-xs-12 page-break-page custom-container-alignment">
                <h5>                    
                    <span class="check-box-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'diagnosis-container-checkbox']) !!}
                        <label for="diagnosis-container-checkbox"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading"><u>DIAGNOSIS:</u></span>
                    <a href="javascript:" class="checkingtest hidden-print" id="report-p1" style="cursor: pointer;" title="Edit" data-count="p1">
                        <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                    </a>
                </h5>
                @if(isset($postanatal_details->diagnosis) && !empty($postanatal_details->diagnosis))
                <div class="generated-content-container">
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'diagnosis-checkbox']) !!}
                        <label for="diagnosis-checkbox"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content">
                        {{ $postanatal_details->diagnosis }}
                    </div>
                </div>
                @endif
                {{ Form::hidden('editor_val[p1][0]', @$newproblem['p1'][0]) }}
                <div id="new-problem-report-editor-p1" class="editor-align @if(isset($newproblem['p1'][0]) && !empty($newproblem['p1'][0])) @else hide @endif">
                    <div class="editor-align-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'edited-checkbox-p1']) !!}
                        <label for="edited-checkbox-p1"><span class="hidden-print"></span></label>
                    </div>
                    <div class="editor-align-content">
                        @php echo stripcslashes(@$newproblem['p1'][0]); @endphp
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page newborn-details">
                <h5>
                    <span class="check-box-div">
                        {!! Form::checkbox('hide', null) !!}
                        <label><span></span></label>
                    </span>
                    <span class="custom-heading"><u>NEWBORN DETAILS:</u></span>
                </h5>
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <span class="print-label">{{ Lang::get('home.mrn') }}.:</span>
                                <span class="print-value">{!! $neonatalDetails->mr_no !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Name:</span>
                                <span class="print-value">{!! $neonatalDetails->BabyName !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Date of Birth:</span>
                                <span class="print-value">{!! $neonatalDetails->dateofbirth !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Time of Birth:</span>
                                <span class="print-value">{!! $neonatalDetails->tob !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Gestation(wks):</span>
                                <span class="print-value">{!! SiteHelpers::decode_gestation($neonatalDetails->Gestation) !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Sex:</span>
                                <span class="print-value">{!! $neonatalDetails->Sex !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Birth weight (gms):</span>
                                <span class="print-value">{!! $neonatalDetails->BirthWeight !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Discharge weight (gms):</span>
                                <span class="print-value">{!! $postnatalDetails->DischargeWeight !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Discharge OFC (cm):</span>
                                <span class="print-value">{!! $postnatalDetails->discharge_ofc !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Discharge Length (cm):</span>
                                <span class="print-value">{!! $postnatalDetails->discharge_length !!}</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <span class="print-label">{{ Lang::get('home.ip') }}:</span>
                                <span class="print-value">{!! $postnatalDetails->visit_number !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Mode of delivery:</span>
                                <span class="print-value">{!! $neonatalDetails->ModeOfDelivery !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Presentation:</span>
                                <span class="print-value">{!! $neonatalDetails->Presentation !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Birth order:</span>
                                <span class="print-value">{!! $neonatalDetails->BirthOrder !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Birth status:</span>
                                <span class="print-value">{!! $neonatalDetails->BirthStatus !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">
                                    <span class="display-inline-block mb-5">Apgars:</span>
                                </span>
                                <span class="print-value">
                                    <p class="mb-0 font-normal">1 min : {!! $neonatalDetails->Apgars1min !!}</p>
                                    <p class="mb-0 font-normal">5 min : {!! $neonatalDetails->Apgars5min !!}</p>
                                    <p class="mb-0 font-normal">10 min : {!! $neonatalDetails->Apgars10min !!}</p>
                                </span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Mother's Blood Group:</span>
                                <span class="print-value">{!! $neonatalDetails->MotherBloodGroup !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Baby's Blood Group:</span>
                                <span class="print-value">{!! $neonatalDetails->BabyBloodGroup !!}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page admission-details">
                <h5>
                    <span class="check-box-div">
                        {!! Form::checkbox('hide', null) !!}
                        <label><span></span></label>
                    </span>
                    <span class="custom-heading"><u>ADMISSION/DISCHARGE DETAILS:</u></span>
                </h5>
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <span class="print-label">Date of Admission:</span>
                                <span class="print-value">
                                    @if(date('Y', strtotime($postnatalDetails->admission_date)) > 1970)
                                    {!! date('d-m-Y', strtotime($postnatalDetails->admission_date)) !!}
                                    @else
                                    N/A
                                    @endif
                                </span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Admission Corrected Gestational Age (wks):</span>
                                <span class="print-value">{!! SiteHelpers::decode_gestation($postnatalDetails->admission_cga) !!}</span>
                            </div>
                            <div class="form-group hide">
                                <span class="print-label">Admission Weight (gms):</span>
                                <span class="print-value">{!! $postnatalDetails->AdmissionWt !!}</span>
                            </div>
                            <div class="form-group hide">
                                <span class="print-label">Admission Age (Day of life):</span>
                                <span class="print-value">{!! $postnatalDetails->AgeOnAdmissioninDays !!}</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <span class="print-label">Date of Discharge:</span>
                                <span class="print-value">
                                    @if(date('Y', strtotime($postnatalDetails->discharge_date)) > 1970)
                                    {!! date('d-m-Y', strtotime($postnatalDetails->discharge_date)) !!}
                                    @else
                                    N/A
                                    @endif
                                </span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Discharge Corrected Gestational Age (wks):</span>
                                <span class="print-value">{!! SiteHelpers::decode_gestation($postnatalDetails->discharge_cga) !!}</span>
                            </div>
                            <div class="form-group hide">
                                <span class="print-label">Discharge weight (gms):</span>
                                <span class="print-value">{!! $postnatalDetails->DischargeWeight !!}</span>
                            </div>
                            <div class="form-group hide">
                                <span class="print-label">Discharge Age (Day of life):</span>
                                <span class="print-value">{!! $postnatalDetails->discharge_dol !!}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(isset($neonatalProblems) && count($neonatalProblems) > 0)    
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
                <h5>
                    <span class="check-box-div">
                        {!! Form::checkbox('hide', null) !!}
                        <label><span></span></label>
                    </span>
                    <span class="custom-heading"><u>DIAGNOSIS/NEONATAL PROBLEMS:</u></span>
                </h5>
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print" style="margin-left: -10px">
                        <ol>
                            @foreach($neonatalProblems as $problems)
                            <li>{!! $problems !!}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-md-12 col-sm-12 col-xs-12 page-break-page custom-container-alignment">
                <h5>                    
                    <span class="check-box-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'procedures-container-checkbox']) !!}
                        <label for="procedures-container-checkbox"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading"><u>NEONATAL PROCEDURES PERFORMED:</u></span>
                    <a href="javascript:" class="checkingtest hidden-print" id="report-p2" style="cursor: pointer;" title="Edit" data-count="p2">
                        <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                    </a>
                </h5>
                @if(isset($postnatalDetails->procedures) && count($postnatalDetails->procedures) > 0 && is_array($postnatalDetails->procedures))
                <div class="generated-content-container">
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'procedures-checkbox']) !!}
                        <label for="procedures-checkbox"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content">
                        {!! implode(',', $postnatalDetails->procedures) !!}
                    </div>
                </div>
                @endif
                {{ Form::hidden('editor_val[p2][0]', @$newproblem['p2'][0]) }}
                <div id="new-problem-report-editor-p2" class="editor-align @if(isset($newproblem['p2'][0]) && !empty($newproblem['p2'][0])) @else hide @endif">
                    <div class="editor-align-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'edited-checkbox-p2']) !!}
                        <label for="edited-checkbox-p2"><span class="hidden-print"></span></label>
                    </div>
                    <div class="editor-align-content">
                        @php echo stripcslashes(@$newproblem['p2'][0]); @endphp
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page maternal-details">
                <h5>
                    <span class="check-box-div">
                        {!! Form::checkbox('hide', null) !!}
                        <label><span></span></label>
                    </span>
                    <span class="custom-heading"><u>MATERNAL DETAILS:</u></span>
                </h5>
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <span class="print-label">Name:</span>
                                <span class="print-value">{!! $neonatalDetails->MotherName !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Age:</span>
                                <span class="print-value">{!! $neonatalDetails->MothercYear !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Parity:</span>
                                <span class="print-value">{!! 'G '.$neonatalDetails->G_Value.' : '.'P '.$neonatalDetails->P_Value.' : '.'L '.$neonatalDetails->L_Value.' : '.'A '.$neonatalDetails->A_Value !!}</span>
                            </div>
                            @if($neonatalDetails->Conception != 'Medical ART' && $neonatalDetails->Conception != 'ART')
                            <div class="form-group">
                                <span class="print-label">Conception:</span>
                                <span class="print-value">{!! $neonatalDetails->Conception !!}</span>
                            </div>
                            @endif
                            <div class="form-group">
                                <span class="print-label">LMP:</span>
                                <span class="print-value">
                                    @if(date('Y', strtotime($neonatalDetails->LMP)) > 1970)
                                    {!! date('d-m-Y', strtotime($neonatalDetails->LMP)) !!}
                                    @else
                                    N/A
                                    @endif
                                </span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">EDD (by dates):</span>
                                <span class="print-value">
                                    @if(date('Y', strtotime($neonatalDetails->EDDbyDates)) > 1970)
                                    {!! date('d-m-Y', strtotime($neonatalDetails->EDDbyDates)) !!}
                                    @else
                                    N/A
                                    @endif
                                </span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">EDD (by USG):</span>
                                <span class="print-value">
                                    @if(date('Y', strtotime($neonatalDetails->EDDbyUSG)) > 1970)
                                    {!! date('d-m-Y', strtotime($neonatalDetails->EDDbyUSG)) !!}
                                    @else
                                    N/A
                                    @endif
                                </span>
                            </div>
                            <div class="form-group">
                                <span class="display-inline-block mb-5 font-size-12"><u>Medical Problems:</u></span>
                                @if(count($mMedicalproblems) > 0)
                                <ol>
                                    @foreach($mMedicalproblems as $problems)
                                    <li>{!! $problems !!}</li>
                                    @endforeach
                                </ol>
                                @else
                                <ul class="list-none">
                                    <li>Nil</li>
                                </ul>
                                @endif
                            </div>
                            <div class="form-group">
                                <table>
                                    <thead>
                                        <tr class="hide">
                                            <td colspan="2" class="print-label-text"><u>Antenatal USG Findings:</u></td>
                                        </tr>
                                        <tr class="hide" class="print-label-text">
                                            <td>Gestation:</td>
                                            <td>Findings:</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="hide" class="print-label-text">
                                            <td colspan="2"> Dating Scan: </td>
                                        </tr>
                                        @foreach($usgFinding->where('type',1) as $usg)
                                        <tr class="hide">
                                            <td class="print-label-value">{!! $usg->Gestation !!}</td>
                                            <td class="print-label-value">{!! $usg->Finding !!}</td>
                                        </tr>
                                        @endforeach
                                        <tr class="hide">
                                            <td colspan="2" class="print-label-text"> Anomaly Scan: </td>
                                        </tr>
                                        @foreach($usgFinding->where('type',2) as $usg)
                                        <tr class="hide">
                                            <td class="print-label-value">{!! $usg->Gestation !!}</td>
                                            <td class="print-label-value">{!! $usg->Finding !!}</td>
                                        </tr>
                                        @endforeach
                                        <tr class="hide">
                                            <td colspan="2" class="print-label-text"> Further Scan: </td>
                                        </tr>
                                        @foreach($usgFinding->where('type',3) as $usg)
                                        <tr class="hide">
                                            <td class="print-label-value">{!! $usg->Gestation !!}</td>
                                            <td class="print-label-value">{!! $usg->Finding !!}</td>
                                        </tr class="hide"> 
                                        @endforeach 
                                        @if(count($usgFinding->where('type',4)) > 0)
                                        <tr class="hide">
                                            <td colspan="2" class="print-label-text"> Doppler Scan: </td>
                                        </tr>
                                        @foreach($usgFinding->where('type',4) as $usg)
                                        <tr class="hide">
                                            <td class="print-label-value">{!! $usg->Gestation !!}</td>
                                            <td class="print-label-value">{!! $usg->Finding !!}</td>
                                        </tr>
                                        @endforeach 
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                       <!--      <div class="form-group">
                                <span class="print-label">Discharge Corrected Gestational Age (wks):</span>
                                <span class="print-value">{!! SiteHelpers::decode_gestation($postnatalDetails->discharge_cga) !!}</span>
                            </div> -->
                            <div class="form-group hide">
                                <span class="print-label">Discharge weight (gms):</span>
                                <span class="print-value">{!! $postnatalDetails->DischargeWeight !!}</span>
                            </div>
                            <div class="form-group hide">
                                <span class="print-label">Discharge Age (Day of life):</span>
                                <span class="print-value">{!! $postnatalDetails->discharge_dol !!}</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <span class="print-label">Mother's {{ Lang::get('home.mrn') }}.:</span>
                                <span class="print-value">{!! $neonatalDetails->MMrNo !!}</span>
                            </div>
                            <br/>                
                            <br/>                
                            <div class="form-group">
                                <span class="print-label"><u>Serologies:</u></span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">HIV:</span>
                                <span class="print-value">{!! $neonatalDetails->HIV !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Hepatitis B:</span>
                                <span class="print-value">{!! $neonatalDetails->HepatitisB !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">VDRL:</span>
                                <span class="print-value">{!! $neonatalDetails->VDRL !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="display-inline-block mb-5 font-size-12"><u>Pregnancy Complications:</u></span>
                                @if(count($pregnancyComplications) > 0)
                                <ol>
                                    @foreach($pregnancyComplications as $complications)
                                    <li>{!! $complications !!}</li>
                                    @endforeach
                                </ol>
                                @else
                                <ul class="list-none">
                                    <li>Nil</li>
                                </ul>
                                @endif
                            </div>
                            <div class="form-group">
                                <span class="print-label">Antenatal Steroids:</span>
                                <span class="print-value">{!! $neonatalDetails->AntenatalSteroids !!}</span>
                            </div>
                            @if($neonatalDetails->AntenatalSteroids =='Yes')
                            <div class="form-group">
                                <span class="print-label">Last Dose Delivery Interval:</span>
                                <span class="print-value">{!! $neonatalDetails->LastDoseDeliveryInterval !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Steroid Course:</span>
                                <span class="print-value">{!! $neonatalDetails->SteroidCourse !!}</span>
                            </div>
                            @endif
                            <div class="form-group">
                                <span class="print-label">PROM:</span>
                                <span class="print-value">{!! $neonatalDetails->PROM !!}</span>
                            </div>
                            @if($neonatalDetails->PROM =='Yes')
                            <div class="form-group">
                                <span class="print-label">Duration of PROM:</span>
                                <span class="print-value">{!! $neonatalDetails->DurationOfROM !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Maternal Antibiotics:</span>
                                <span class="print-value">{!! $neonatalDetails->Maternal_antibiotics_status !!}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page delivery-details">
                <h5>
                    <span class="check-box-div">
                        {!! Form::checkbox('hide', null) !!}
                        <label><span></span></label>
                    </span>
                    <span class="custom-heading"><u>DELIVERY DETAILS:</u></span>
                </h5>
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <span class="print-label">Mode of delivery:</span>
                                <span class="print-value">{!! $neonatalDetails->ModeOfDelivery !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="display-inline-block mb-5 font-size-12"><u>Indication:</u></span>
                                <ol>
                                    @if(isset($neonatalDetails->Indication) && is_array($neonatalDetails->Indication))
                                    @foreach($neonatalDetails->Indication as $indication) 
                                    @if(isset($indicationMaster[$indication]))
                                    <li>{!! $indicationMaster[$indication] !!}</li>
                                    @endif 
                                    @endforeach 
                                    @endif
                                </ol>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Liquor:</span>
                                <span class="print-value">{!! $neonatalDetails->CommentOnLiquor !!}</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <span class="print-label">Vitamin K:</span>
                                <span class="print-value">{!! $neonatalDetails->VitaminK !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Dose Vit K:</span>
                                <span class="print-value">{!! $neonatalDetails->DoseVitK !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Route Vit K:</span>
                                <span class="print-value">{!! $neonatalDetails->RouteVitK !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Delayed Cord Clamping:</span>
                                <span class="print-value">{!! $neonatalDetails->delayed_cord_clamping !!}</span>
                            </div>
                            @if($neonatalDetails->delayed_cord_clamping == 'Yes')
                            <div class="form-group">
                                <span class="print-label">Duration of DCC (sec):</span>
                                <span class="print-value">{!! $neonatalDetails->duration_dcc !!}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if(count($episodes) > 0)
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
                <h5>
                    <span class="check-box-div">
                        {!! Form::checkbox('hide', null) !!}
                        <label><span></span></label>
                    </span>
                    <span class="custom-heading"><u>DETAILED SUMMARY:</u></span>
                </h5>
                {{ Form::hidden('episodeCount',count($episodes),['id'=>'episode-count']) }} 
                @php $i = 0 @endphp 
                @foreach($episodes as $episodeLists)
                <div class="parent-generated-content-container">
                    @php $problem = 0 @endphp 
                    @foreach($episodeLists as $episodeDetails) 
                    @php $flag = 0 @endphp 
                    @php $problem_id = $episodeDetails->problem_id; @endphp 
                    @php $problembase = ProblemBaseHelpers::getProblem($problem_id) @endphp 
                    @php $problem_fields = json_decode($problembase->problem_fields); @endphp 
                    @php $problems_parameters = (array)json_decode($episodeDetails->problems_parameters); @endphp 
                    @foreach($problem_fields as $field) 
                    @if(isset($field->para_discharge) && $field->para_discharge == '' && !empty($problems_parameters[$field->para_name])) 
                    @php $flag = 1 @endphp 
                    @endif 
                    @endforeach 
                    @if( $problem == 0)
                    <div class="parent-generated-content-checkbox-div">                       
                        {!! Form::checkbox('status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'problem-container-checkbox-'.$problem_id]) !!}
                        <label for="problem-container-checkbox-{{$problem_id}}"><span class="hidden-print"></span></label>
                        <span class="custom-heading"><u> {!! strtoupper($episodeLists->pluck('problem_name')->unique()->implode('')) !!} :</u></span>
                    </div>
                    @endif
                    @php $problemname = str_replace(' ', '', $episodeLists->pluck('problem_name')->unique()->implode('')) @endphp 
                    @php $episode = str_replace(' ', '', $episodeDetails->episode_name) @endphp
                    <div class="parent-generated-content">
                        <h6>            
                            <span class="check-box-div">
                                {!! Form::checkbox('hide', null) !!}
                                <label><span></span></label>
                            </span>
                            <span><b>{!! $episodeDetails->episode_name; !!}</b></span>
                            <a href="javascript:" class="pull-right checkingtest hidden-print" id="post-problems-report-{{$episodeDetails->episode_id}}" style="cursor: pointer;" title="Edit">
                                <i class="fa fa-pencil post-report-editing" id="post-report-editing-{{$episodeDetails->episode_id}}" data-post-report="{{$episodeDetails->episode_id}}" aria-hidden="true" data-post-problem="{{str_replace(' ','',$episodeLists->pluck('problem_name')->unique()->implode(''))}}" data-post-episode="{{str_replace(' ','',$episodeDetails->episode_name)}}"></i>
                            </a>
                        </h6>
                        <div class="generated-content-container">
                            <div class="generated-content-checkbox-div">
                                {!! Form::checkbox('status', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'episode-problem-'.$problemname.'-'.$episode.'-checkbox']) !!}
                                <label for="episode-problem-{{$problemname}}-{{$episode}}-checkbox"><span class="hidden-print"></span></label>
                            </div>
                            <div class="generated-content">
                                <table>
                                    <tr>
                                        <td id="episode-problem-{{$i}}">
                                            @php $dependancyfields = array(); @endphp 
                                            @foreach($problem_fields as $episodeproperty) 
                                            @if ($episodeproperty->para_type == 'type-toggle') 
                                            @php $dependancy = json_decode($episodeproperty->para_toggle_dependancy) @endphp 
                                            @for ($i = 0; $i < count($dependancy); $i++) 
                                            @if (count($dependancy[$i]->dependencyValue) > 0) 
                                            @php $dependancyfields[$episodeproperty->para_name.':'.$dependancy[$i]->dependencyName] = $dependancy[$i]->dependencyValue @endphp
                                            @endif 
                                            @endfor 
                                            @endif 
                                            @endforeach 
                                            @foreach($problem_fields as $episodeproperty) 
                                            @php unset($slug) @endphp
                                            @if(array_key_exists($episodeproperty->para_name, $problems_parameters) && isset($episodeproperty->para_discharge) && $episodeproperty->para_discharge != 1 && !empty($problems_parameters[$episodeproperty->para_name]) && !ctype_space($problems_parameters[$episodeproperty->para_name])) 
                                            @switch($episodeproperty->para_type) 
                                            @case('type-text') 
                                            @foreach ($dependancyfields as $key => $value) 
                                            @php $para_match = in_array($episodeproperty->para_name, $value); @endphp 
                                            @if ($para_match) 
                                            @php $param = explode(":", $key); @endphp 
                                            @if (isset($problems_parameters[$param[0]]) && $problems_parameters[$param[0]] == $param[1]) 
                                            @php unset($slug) @endphp 
                                            @else 
                                            @php $slug = true; @endphp 
                                            @endif 
                                            @endif 
                                            @endforeach 
                                            @if (!isset($slug)) 
                                            @php $textflag = 0 @endphp 
                                            @if(isset($problems_parameters[$episodeproperty->para_name]) && is_string($problems_parameters[$episodeproperty->para_name]) && !empty($problems_parameters[$episodeproperty->para_name])) 
                                            <span class="episode-label">
                                                <strong>{!! $episodeproperty->para_label !!}</strong> 
                                                <strong>:&nbsp</strong>
                                                {!! $problems_parameters[$episodeproperty->para_name] !!}
                                                <strong>,&nbsp&nbsp</strong>
                                            </span> 
                                            @elseif(isset($problems_parameters[$episodeproperty->para_name]) && is_array($problems_parameters[$episodeproperty->para_name]) && !empty($problems_parameters[$episodeproperty->para_name])) 
                                            @foreach ($problems_parameters[$episodeproperty->para_name] as $value) 
                                            @if ($value != '')
                                            @php $textflag = $textflag + 1 @endphp
                                            @endif
                                            @endforeach
                                            @if ($textflag != 0)
                                            <span class="episode-label">
                                                <strong>{!! $episodeproperty->para_label !!}</strong> 
                                                <strong>:&nbsp&nbsp</strong>
                                                {!! implode(',&nbsp&nbsp', $problems_parameters[$episodeproperty->para_name]) !!}
                                                <strong>,&nbsp</strong>
                                            </span>
                                            @endif
                                            @endif
                                            @endif
                                            @break
                                            @case('type-number')
                                            @foreach ($dependancyfields as $key => $value)
                                            @php $para_match = in_array($episodeproperty->para_name, $value); @endphp
                                            @if ($para_match)
                                            @php $param = explode(":", $key); @endphp
                                            @if (isset($problems_parameters[$param[0]]) && $problems_parameters[$param[0]] == $param[1]) 
                                            @php unset($slug) @endphp
                                            @else
                                            @php $slug = true; @endphp
                                            @endif
                                            @endif
                                            @endforeach
                                            @if (!isset($slug))
                                            @if(!empty($problems_parameters[$episodeproperty->para_name]))
                                            <span class="episode-label">
                                                <strong>{!! $episodeproperty->para_label !!} </strong>
                                                <strong>:&nbsp</strong>
                                                {!! $problems_parameters[$episodeproperty->para_name] !!}
                                                <strong>,&nbsp</strong>
                                            </span>
                                            @endif
                                            @endif
                                            @break
                                            @case('type-decimal')
                                            @foreach ($dependancyfields as $key => $value)
                                            @php $para_match = in_array($episodeproperty->para_name, $value); @endphp
                                            @if ($para_match)
                                            @php $param = explode(":", $key); @endphp
                                            @if (isset($problems_parameters[$param[0]]) && $problems_parameters[$param[0]] == $param[1])
                                            @php unset($slug) @endphp
                                            @else
                                            @php $slug = true; @endphp
                                            @endif
                                            @endif
                                            @endforeach
                                            @if (!isset($slug))
                                            @if(!empty($problems_parameters[$episodeproperty->para_name]))
                                            <span class="episode-label">
                                                <strong>{!! $episodeproperty->para_label !!}</strong> 
                                                <strong>:&nbsp</strong>
                                                {!! $problems_parameters[$episodeproperty->para_name] !!}
                                                <strong>,&nbsp</strong>
                                            </span>
                                            @endif
                                            @endif
                                            @break
                                            @case('type-textarea')
                                            @foreach ($dependancyfields as $key => $value)
                                            @php $para_match = in_array($episodeproperty->para_name, $value); @endphp
                                            @if ($para_match)
                                            @php $param = explode(":", $key); @endphp
                                            @if (isset($problems_parameters[$param[0]]) && $problems_parameters[$param[0]] == $param[1])
                                            @php unset($slug) @endphp
                                            @else
                                            @php $slug = true; @endphp
                                            @endif
                                            @endif
                                            @endforeach
                                            @if (!isset($slug))
                                            @if(!empty($problems_parameters[$episodeproperty->para_name]))
                                            <span class="episode-label">
                                                <strong>{!! $episodeproperty->para_label !!}</strong> 
                                                <strong>:&nbsp</strong>
                                                {!! $problems_parameters[$episodeproperty->para_name] !!}
                                                <strong>,&nbsp</strong>
                                            </span>
                                            @endif
                                            @endif
                                            @break
                                            @case('type-select')
                                            @foreach ($dependancyfields as $key => $value)
                                            @php $para_match = in_array($episodeproperty->para_name, $value); @endphp
                                            @if ($para_match)
                                            @php $param = explode(":", $key); @endphp
                                            @if (isset($problems_parameters[$param[0]]) && $problems_parameters[$param[0]] == $param[1])
                                            @php unset($slug) @endphp
                                            @else
                                            @php $slug = true; @endphp
                                            @endif
                                            @endif
                                            @endforeach
                                            @if (!isset($slug))
                                            @php $options = ProblemBaseHelpers::getGroupoption($episodeproperty->para_option_value, $episodeproperty->para_option_name) @endphp
                                            <span class="episode-label">
                                                <strong>{!! $episodeproperty->para_label !!}</strong> 
                                                <strong>:&nbsp</strong>
                                                @if(isset($problems_parameters[$episodeproperty->para_name]) && is_string($problems_parameters[$episodeproperty->para_name])  && !empty($problems_parameters[$episodeproperty->para_name]))
                                                {!! isset($options[$problems_parameters[$episodeproperty->para_name]]) ? $options[$problems_parameters[$episodeproperty->para_name]] : '' !!}
                                                @elseif(is_array($problems_parameters[$episodeproperty->para_name]))                                                     
                                                {!! implode(', ', $problems_parameters[$episodeproperty->para_name] ) !!}
                                                @endif
                                                <strong>,&nbsp</strong>
                                            </span>
                                            @endif
                                            @break
                                            @case('type-toggle')
                                            @foreach ($dependancyfields as $key => $value)
                                            @php $para_match = in_array($episodeproperty->para_name, $value); @endphp
                                            @if ($para_match)
                                            @php $param = explode(":", $key); @endphp
                                            @if (isset($problems_parameters[$param[0]]) && $problems_parameters[$param[0]] == $param[1]) 
                                            @php unset($slug) @endphp 
                                            @else 
                                            @php $slug = true; @endphp 
                                            @endif 
                                            @endif 
                                            @endforeach 
                                            @if (!isset($slug)) 
                                            @php $dependancy = SiteHelpers::convert_obj_to_array(json_decode($episodeproperty->para_toggle_dependancy))['1']['dependencyValue'] @endphp 
                                            @php $dependancyKey=array_keys(collect($problem_fields)->whereIn('para_name',$dependancy )->toArray()); @endphp 
                                            @foreach($dependancyKey as $key) 
                                            @php unset($problem_fields[$key]); @endphp 
                                            @endforeach 
                                            <span class="episode-label">
                                                <strong>{!! $episodeproperty->para_label !!}</strong>
                                                <strong>:&nbsp</strong>
                                            </span>
                                            <span class="episode-value">
                                                @if($problems_parameters[$episodeproperty->para_name] == true)
                                                {!! $episodeproperty->para_toggle_on !!}
                                                @else
                                                {!! $episodeproperty->para_toggle_off !!}
                                                @endif
                                                <strong>,&nbsp</strong>
                                            </span>
                                            @endif
                                            @break
                                            @case('type-horizontal-selector')
                                            @foreach ($dependancyfields as $key => $value)
                                            @php $para_match = in_array($episodeproperty->para_name, $value); @endphp
                                            @if ($para_match)
                                            @php $param = explode(":", $key); @endphp
                                            @if (isset($problems_parameters[$param[0]]) && $problems_parameters[$param[0]] == $param[1])
                                            @php unset($slug) @endphp
                                            @else
                                            @php $slug = true; @endphp
                                            @endif
                                            @endif
                                            @endforeach
                                            @if (!isset($slug))
                                            @php $options = ProblemBaseHelpers::getGroupoption($episodeproperty->hpara_option_value, $episodeproperty->hpara_option_name) @endphp
                                            @if(!empty($options[$problems_parameters[$episodeproperty->para_name]])) 
                                            <span class="episode-label">
                                                <strong>{!! $episodeproperty->para_label !!}</strong> 
                                                <strong>:&nbsp</strong>
                                                {!! $options[$problems_parameters[$episodeproperty->para_name]] !!}
                                                <strong>,&nbsp</strong>
                                            </span>
                                            @endif
                                            @endif
                                            @break
                                            @case('type-check-box')
                                            @foreach ($dependancyfields as $key => $value)
                                            @php $para_match = in_array($episodeproperty->para_name, $value); @endphp
                                            @if ($para_match)
                                            @php $param = explode(":", $key); @endphp
                                            @if (isset($problems_parameters[$param[0]]) && $problems_parameters[$param[0]] == $param[1])
                                            @php unset($slug) @endphp
                                            @else
                                            @php $slug = true; @endphp
                                            @endif
                                            @endif
                                            @endforeach
                                            @if (!isset($slug))
                                            @php $options = ProblemBaseHelpers::getGroupoption($episodeproperty->para_chkop_value, $episodeproperty->para_chkop_name) @endphp
                                            @if(!empty($problems_parameters[$episodeproperty->para_name]))
                                            <span class="episode-label">
                                                <strong>{!! $episodeproperty->para_label !!} </strong>
                                                <strong>:&nbsp</strong>
                                            </span>
                                            <span class="episode-value">
                                                @if(isset($problems_parameters[$episodeproperty->para_name]))
                                                {!! implode(',', json_decode($problems_parameters[$episodeproperty->para_name])) !!}
                                                @endif
                                                <strong>,&nbsp</strong>
                                            </span>
                                            @endif
                                            @endif
                                            @break
                                            @case('type-radio')
                                            @foreach ($dependancyfields as $key => $value)
                                            @php $para_match = in_array($episodeproperty->para_name, $value); @endphp
                                            @if ($para_match)
                                            @php $param = explode(":", $key); @endphp
                                            @if (isset($problems_parameters[$param[0]]) && $problems_parameters[$param[0]] == $param[1])
                                            @php unset($slug) @endphp
                                            @else
                                            @php $slug = true; @endphp
                                            @endif
                                            @endif
                                            @endforeach
                                            @if (!isset($slug))
                                            @php $options = ProblemBaseHelpers::getGroupoption($episodeproperty->para_rdop_value, $episodeproperty->para_rdop_name) @endphp
                                            @if(!empty($options[$problems_parameters[$episodeproperty->para_name]]))
                                            <span class="episode-label">
                                                <strong>{!! $episodeproperty->para_label !!}</strong>
                                                <strong>:&nbsp</strong>
                                                @if(isset($options[$problems_parameters[$episodeproperty->para_name]]))
                                                {!! $options[$problems_parameters[$episodeproperty->para_name]] !!}
                                                <strong>,&nbsp</strong>
                                                @endif
                                            </span>
                                            @endif
                                            @endif
                                            @break
                                            @endswitch
                                            @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    @foreach($problem_fields as $episodeproperty)
                                    @if (strpos($episodeproperty->para_name,'[]'))
                                    @php $episodeproperty->para_name = str_replace('[]', '', $episodeproperty->para_name) @endphp
                                    @endif
                                    @if(array_key_exists($episodeproperty->para_name, $problems_parameters) && isset($episodeproperty->para_discharge) && $episodeproperty->para_discharge != 1)
                                    @switch($episodeproperty->para_type)
                                    @case('type-drugs')
                                    @php $temp_medicine = isset($problems_parameters[$episodeproperty->para_name]) ? $problems_parameters[$episodeproperty->para_name] : ''; @endphp
                                    <tr class="episode-drug">
                                        <td class="episode-table-cell">
                                            <span class="episode-label">{!! title_case($episodeproperty->para_label) !!}<strong>&nbsp:&nbsp</strong></span>
                                            <span class="episode-value">
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th>Medicine</th>
                                                            <th>Dose</th>
                                                            <th>Duration</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($temp_medicine as $medicine)   
                                                        @php $medicine = (array)$medicine; @endphp
                                                        @if(isset($medicine[$episodeproperty->para_name]) && !empty($drug_master[$medicine[$episodeproperty->para_name]]))
                                                        <tr>
                                                            <td>{!! isset($drug_master[$medicine[$episodeproperty->para_name]]) ? $drug_master[$medicine[$episodeproperty->para_name]] : '' !!}</td>
                                                            <td>{!! isset($medicine[$episodeproperty->para_name.'does']) ? $medicine[$episodeproperty->para_name.'does'] : '' !!}</td>
                                                            <td>{!! isset($medicine[$episodeproperty->para_name.'duration']) ? $medicine[$episodeproperty->para_name.'duration'] : '' !!}</td>
                                                        </tr>
                                                        @endif
                                                        @endforeach    
                                                    </tbody>
                                                </table>
                                            </span>
                                        </td>
                                    </tr>
                                    @break
                                    @case('type-antibiotic')
                                    @php $temp_antibiotic = isset($problems_parameters[$episodeproperty->para_name]) ? $problems_parameters[$episodeproperty->para_name] : ''; @endphp
                                    @if(count($temp_antibiotic) > 0)
                                    <tr class="episode-drug">
                                        <td class="episode-table-cell">
                                            <span class="episode-label">
                                                {!! title_case($episodeproperty->para_label) !!} 
                                                <strong>&nbsp:&nbsp</strong>
                                            </span>
                                            <span class="episode-value">
                                                @foreach($temp_antibiotic as $antibiotic_key => $antibiotic)   
                                                <table>
                                                    @if ($antibiotic_key == 0 && isset($antibiotic->popupantibiotics) && $antibiotic->popupantibiotics != "N/A")
                                                    <thead>
                                                        <tr>
                                                            <th>Medicine</th>
                                                            <!-- <th>Dose</th> -->
                                                            <th>Duration</th>
                                                        </tr>
                                                    </thead>
                                                    @endif
                                                    <tbody>
                                                        @php $antibiotic = (array)$antibiotic; @endphp
                                                        @if(isset($antibiotic[$episodeproperty->para_name]) && !empty($AntibioticMaster[$antibiotic[$episodeproperty->para_name]]))
                                                        <tr>
                                                            <td>{!! isset($AntibioticMaster[$antibiotic[$episodeproperty->para_name]]) ? $AntibioticMaster[$antibiotic[$episodeproperty->para_name]] : '' !!}</td>
                                                            <!-- <td>{!! isset($antibiotic[$episodeproperty->para_name.'dose']) ? $antibiotic[$episodeproperty->para_name.'dose'] : '' !!}</td> -->
                                                            <td>{!! isset($antibiotic[$episodeproperty->para_name.'duration']) ? $antibiotic[$episodeproperty->para_name.'duration'] : ''!!}</td>
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                                @endforeach    
                                            </span>
                                        </td>
                                    </tr>
                                    @endif
                                    @break
                                    @endswitch
                                    @endif
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                    {{ Form::hidden('editor_val['.$problemname.']['.$episode.']', @$newproblem[$problemname][$episode]) }}
                    <div id="post-report-editor-{{$episodeDetails->episode_id}}" class="editor-align @if(isset($newproblem[$problemname][$episode]) && !empty($newproblem[$problemname][$episode])) @else hide @endif">
                        <div class="editor-align-checkbox-div">
                            {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'post-report-editor-'.$episodeDetails->episode_id.'-checkbox']) !!}
                            <label for="post-report-editor-{{$episodeDetails->episode_id}}-checkbox"><span class="hidden-print"></span></label>
                        </div>
                        <div class="editor-align-content">
                            @php echo stripcslashes(@$newproblem[$problemname][$episode]); @endphp
                        </div>
                    </div>
                    @php $i++ @endphp
                    @php $problem += 1 @endphp
                    @endforeach 
                </div>
                @endforeach 
            </div>
            @endif
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page discharge-details">
                <h5>
                    <span class="check-box-div">
                        {!! Form::checkbox('hide', null) !!}
                        <label><span></span></label>
                    </span>
                    <span class="custom-heading"><u>DISCHARGE DETAILS:</u></span>
                </h5>
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                    @if($postnatalDetails->discharge_eyes != '' || $postnatalDetails->discharge_cardiac_murmur != '' || $postnatalDetails->postductal_spo2 != '' || $postnatalDetails->discharge_femorals !='' || $postnatalDetails->discharge_hips != '' || $postnatalDetails->discharge_gentila != '' || $postnatalDetails->discharge_malinformation != '' || $postnatalDetails->malinformation_details != '' || $postnatalDetails->feeding_at_discharge != '' || $postnatalDetails->neourological_status != '')
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <span class="display-inline-block mb-5 font-size-12"><u>Newborn Examination:</u></span>
                            </div>
                            @if($postnatalDetails->discharge_eyes != '')
                            <div class="form-group">
                                <span class="print-label">Eyes:</span>
                                <span class="print-value">{!! $postnatalDetails->discharge_eyes !!}</span>
                            </div>
                            @endif
                            @if($postnatalDetails->discharge_cardiac_murmur != '')
                            <div class="form-group">
                                <span class="print-label">Cardiac murmur:</span>
                                <span class="print-value">{!! $postnatalDetails->discharge_cardiac_murmur !!}</span>
                            </div>
                            @endif
                            @if($postnatalDetails->postductal_spo2 != '')
                            <div class="form-group">
                                <span class="print-label">Postductal Spo2:</span>
                                <span class="print-value">{!! $postnatalDetails->postductal_spo2 !!}</span>
                            </div>
                            @endif
                            @if($postnatalDetails->discharge_femorals != '')
                            <div class="form-group">
                                <span class="print-label">Femorals:</span>
                                <span class="print-value">{!! $postnatalDetails->discharge_femorals !!}</span>
                            </div>
                            @endif
                            @if($postnatalDetails->discharge_hips != '')
                            <div class="form-group">
                                <span class="print-label">Hips:</span>
                                <span class="print-value">{!! $postnatalDetails->discharge_hips !!}</span>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <br/>
                            @if($postnatalDetails->discharge_gentila != '')
                            <div class="form-group">
                                <span class="print-label">Genitalia:</span>
                                <span class="print-value">{!! $postnatalDetails->discharge_gentila !!}</span>
                            </div>
                            @endif
                            @if($postnatalDetails->discharge_malinformation != '')
                            <div class="form-group">
                                <span class="print-label">Malformation:</span>
                                <span class="print-value">{!! $postnatalDetails->discharge_malinformation !!}</span>
                            </div>
                            @endif
                            @if($postnatalDetails->malinformation_details != '')
                            <div class="form-group">
                                <span class="print-label">Details:</span>
                                <span class="print-value">{!! $postnatalDetails->malinformation_details !!}</span>
                            </div>
                            @endif
                            @if($postnatalDetails->feeding_at_discharge != '')
                            <div class="form-group">
                                <span class="print-label">Feeding at discharge:</span>
                                <span class="print-value">{!! $postnatalDetails->feeding_at_discharge !!}</span>
                            </div>
                            @endif
                            @if($postnatalDetails->neourological_status != '')
                            <div class="form-group">
                                <span class="print-label">Neurological status:</span>
                                <span class="print-value">{!! $postnatalDetails->neourological_status !!}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    @if($postnatalDetails->discharge_hb != '' || $postnatalDetails->discharge_pcv != '' || $postnatalDetails->discharge_tsb != '' || $postnatalDetails->dischargeserum_na != '' || $postnatalDetails->dischargeserum_ca != '' || $postnatalDetails->dischargeserum_po4 != '' || $postnatalDetails->dischargeserum_alp != '' || $postnatalDetails->discharge_dct != '')
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <span class="display-inline-block mb-5 font-size-12"><u>Discharge Blood Tests:</u></span>
                            </div>
                            @if($postnatalDetails->discharge_hb != '')
                            <div class="form-group">
                                <span class="print-label">Hb (g/dl):</span>
                                <span class="print-value">{!! $postnatalDetails->discharge_hb !!}</span>
                            </div>
                            @endif
                            @if($postnatalDetails->discharge_pcv != '')
                            <div class="form-group">
                                <span class="print-label">PCV:</span>
                                <span class="print-value">{!! $postnatalDetails->discharge_pcv !!}</span>
                            </div>
                            @endif
                            @if($postnatalDetails->discharge_dct != '')
                            <div class="form-group">
                                <span class="print-label">DCT:</span>
                                <span class="print-value">{!! $postnatalDetails->discharge_dct !!}</span>
                            </div>
                            @endif
                            @if($postnatalDetails->discharge_tsb != '')
                            <div class="form-group">
                                <span class="print-label">TSB (mg/dl):</span>
                                <span class="print-value">{!! $postnatalDetails->discharge_tsb !!}</span>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <br/>
                            @if($postnatalDetails->dischargeserum_na != '')
                            <div class="form-group">
                                <span class="print-label">Na (mmol/l):</span>
                                <span class="print-value">{!! $postnatalDetails->dischargeserum_na !!}</span>
                            </div>
                            @endif
                            @if($postnatalDetails->dischargeserum_ca != '')
                            <div class="form-group">
                                <span class="print-label">Ca (mg/dl):</span>
                                <span class="print-value">{!! $postnatalDetails->dischargeserum_ca !!}</span>
                            </div>
                            @endif
                            @if($postnatalDetails->dischargeserum_po4 != '')
                            <div class="form-group">
                                <span class="print-label">PO4 (mg/dl):</span>
                                <span class="print-value">{!! $postnatalDetails->dischargeserum_po4 !!}</span>
                            </div>
                            @endif
                            @if($postnatalDetails->dischargeserum_alp != '')
                            <div class="form-group">
                                <span class="print-label">ALP(IU/L):</span>
                                <span class="print-value">{!! $postnatalDetails->dischargeserum_alp !!}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @if(count($VaccineDetails) > 0)
            <div class="col-md-12 col-sm-12 col-xs-12 page-break-page custom-container-alignment">
                <h5>                    
                    <span class="check-box-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'vaccine-container-checkbox']) !!}
                        <label for="vaccine-container-checkbox"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading"><u>Vaccines & Date:</u></span>
                    <a href="javascript:" class="checkingtest hidden-print" id="report-p3" style="cursor: pointer;" title="Edit" data-count="p3">
                        <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                    </a>
                </h5>
                <div class="generated-content-container">
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'vaccine-checkbox']) !!}
                        <label for="vaccine-checkbox"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content min-width-250">
                        <div class="form-group">
                            <span class="print-label">Immunization:</span>
                            <span class="print-value">{!! $postnatalDetails->discharge_immunization !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Schedule:</span>
                            <span class="print-value">{!! $postnatalDetails->schedule !!}</span>
                        </div>
                        <div class="form-group">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="print-label-text">Vaccine</th>
                                        <th class="print-label-text">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(is_array( $postnatalDetails->vaccine)) 
                                    @foreach($postnatalDetails->vaccine as $vaccine)
                                    @if(isset($Vaccine[$vaccine->vaccine]))
                                    <tr>
                                        <td class="print-label-value">{!! $Vaccine[$vaccine->vaccine] !!}</td>
                                        <td class="print-label-value">{!! $vaccine->vaccinedate !!}</td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{ Form::hidden('editor_val[p3][0]', @$newproblem['p3'][0]) }}
                <div id="new-problem-report-editor-p3" class="editor-align @if(isset($newproblem['p3'][0]) && !empty($newproblem['p3'][0])) @else hide @endif">
                    <div class="editor-align-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'edited-checkbox-p3']) !!}
                        <label for="edited-checkbox-p3"><span class="hidden-print"></span></label>
                    </div>
                    <div class="editor-align-content">
                        @php echo stripcslashes(@$newproblem['p3'][0]); @endphp
                    </div>
                </div>
            </div>
            @endif
            @if($postnatalDetails->discharge_hearing_screen == 'Performed' || $postnatalDetails->rop_screening_status == 'Performed')
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page neonatal-basic-details">
                <h6>
                    <span class="check-box-div">
                        {!! Form::checkbox('hide', null) !!}
                        <label><span></span></label>
                    </span>
                    <span class="custom-heading"><u>Other Screening:</u></span>
                </h6>
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <span class="print-label">Newborn Metabolic Screen:</span>
                                <span class="print-value">{!! $postnatalDetails->discharge_new_born !!}</span>
                            </div>
                            @if($postnatalDetails->discharge_hearing_screen == 'Performed')
                            <div class="form-group">
                                <span class="print-label">Hearing Screen:</span>
                                <span class="print-value">{!! $postnatalDetails->discharge_hearing_screen !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th colspan="2"><b><u>OAE:</u></b></th>
                                            </tr>
                                            <tr>
                                                <th><b>Left:</b></th>
                                                <th><b>Right:</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{!! $postnatalDetails->oae_left !!}</td>
                                                <td>{!! $postnatalDetails->oae_right !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </span>
                            </div>
                            @if($postnatalDetails->abr_left != '' && $postnatalDetails->abr_right!='')
                            <div class="form-group">
                                <span class="print-label">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th colspan="2"><b><u>ABR:</u></b></th>
                                            </tr>
                                            <tr>
                                                <th><b>Left:</b></th>
                                                <th><b>Right:</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{!! $postnatalDetails->abr_left !!}</td>
                                                <td>{!! $postnatalDetails->abr_right !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </span>
                            </div>
                            @endif
                            @endif
                            <br/>
                            @if($postnatalDetails->rop_screening_status == 'Performed')
                            <div class="form-group">
                                <span class="print-label">ROP Screen:</span>
                                <span class="print-value">{!! $postnatalDetails->rop_screening_status !!}</span>
                            </div>
                            @endif 
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($postnatalDetails->discharge_cuss =='Normal' || $postnatalDetails->discharge_cuss =='Abnormal')
            <div class="col-md-12 col-sm-12 col-xs-12 page-break-page custom-container-alignment">
                <h5>                    
                    <span class="check-box-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'ultrasound-container-checkbox']) !!}
                        <label for="ultrasound-container-checkbox"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading"><u>Cranial ultrasound:</u></span>
                    <a href="javascript:" class="checkingtest hidden-print" id="report-p4" style="cursor: pointer;" title="Edit" data-count="p4">
                        <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                    </a>
                </h5>
                @if(!empty($postnatalDetails->cranial_ultrasound))
                <div class="generated-content-container">
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'ultrasound-checkbox']) !!}
                        <label for="ultrasound-checkbox"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content">
                        {!! $postnatalDetails->cranial_ultrasound !!}
                    </div>
                </div>
                @endif
                {{ Form::hidden('editor_val[p4][0]', @$newproblem['p4'][0]) }}
                <div id="new-problem-report-editor-p4" class="editor-align @if(isset($newproblem['p4'][0]) && !empty($newproblem['p4'][0])) @else hide @endif">
                    <div class="editor-align-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'edited-checkbox-p4']) !!}
                        <label for="edited-checkbox-p4"><span class="hidden-print"></span></label>
                    </div>
                    <div class="editor-align-content">
                        @php echo stripcslashes(@$newproblem['p4'][0]); @endphp
                    </div>
                </div>
            </div>
            @endif 
            @if($postnatalDetails->echocardiography_status =='Normal' || $postnatalDetails->echocardiography_status =='Abnormal')
            <div class="col-md-12 col-sm-12 col-xs-12 page-break-page custom-container-alignment">
                <h5>                    
                    <span class="check-box-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'echo-container-checkbox']) !!}
                        <label for="echo-container-checkbox"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading"><u>Echocardiography:</u></span>
                    <a href="javascript:" class="checkingtest hidden-print" id="report-p5" style="cursor: pointer;" title="Edit" data-count="p5">
                        <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                    </a>
                </h5>
                @if(!empty($postnatalDetails->echocardiography))
                <div class="generated-content-container">
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'echo-checkbox']) !!}
                        <label for="echo-checkbox"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content">
                        {!! $postnatalDetails->echocardiography !!}
                    </div>
                </div>
                @endif
                {{ Form::hidden('editor_val[p5][0]', @$newproblem['p5'][0]) }}
                <div id="new-problem-report-editor-p5" class="editor-align @if(isset($newproblem['p5'][0]) && !empty($newproblem['p5'][0])) @else hide @endif">
                    <div class="editor-align-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'edited-checkbox-p5']) !!}
                        <label for="edited-checkbox-p5"><span class="hidden-print"></span></label>
                    </div>
                    <div class="editor-align-content">
                        @php echo stripcslashes(@$newproblem['p5'][0]); @endphp
                    </div>
                </div>
            </div>
            @endif 
            @if($postnatalDetails->additional_information != '')
            <div class="col-md-12 col-sm-12 col-xs-12 page-break-page custom-container-alignment">
                <h5>                    
                    <span class="check-box-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'additional-info-container-checkbox']) !!}
                        <label for="additional-info-container-checkbox"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading"><u>POSTNATAL COURSE:</u></span>
                    <a href="javascript:" class="checkingtest hidden-print" id="report-p6" style="cursor: pointer;" title="Edit" data-count="p6">
                        <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                    </a>
                </h5>
                @if(!empty($postnatalDetails->additional_information))
                <div class="generated-content-container">
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'additional-info-checkbox']) !!}
                        <label for="additional-info-checkbox"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content">
                        {!! $postnatalDetails->additional_information !!}
                    </div>
                </div>
                @endif
                {{ Form::hidden('editor_val[p6][0]', @$newproblem['p6'][0]) }}
                <div id="new-problem-report-editor-p6" class="editor-align @if(isset($newproblem['p6'][0]) && !empty($newproblem['p6'][0])) @else hide @endif">
                    <div class="editor-align-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'edited-checkbox-p6']) !!}
                        <label for="edited-checkbox-p6"><span class="hidden-print"></span></label>
                    </div>
                    <div class="editor-align-content">
                        @php echo stripcslashes(@$newproblem['p6'][0]); @endphp
                    </div>
                </div>
            </div>
            @endif  
            <div class="col-md-12 col-sm-12 col-xs-12 page-break-page custom-container-alignment">
                <h5>                    
                    <span class="check-box-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'communication-container-checkbox']) !!}
                        <label for="communication-container-checkbox"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading"><u>Communication with Parents:</u></span>
                    <a href="javascript:" class="checkingtest hidden-print" id="report-p7" style="cursor: pointer;" title="Edit" data-count="p7">
                        <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                    </a>
                </h5>
                <div class="generated-content-container">
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'communication-checkbox']) !!}
                        <label for="communication-checkbox"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content">
                        Parents were fully updated regarding the baby’s daily progress in the postnatal unit and they were provided with sufficient opportunities to clarify their questions.
                    </div>
                </div>
                {{ Form::hidden('editor_val[p7][0]', @$newproblem['p7'][0]) }} 
                <div id="new-problem-report-editor-p7" class="editor-align @if(isset($newproblem['p7'][0]) && !empty($newproblem['p7'][0])) @else hide @endif">
                    <div class="editor-align-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'edited-checkbox-p7']) !!}
                        <label for="edited-checkbox-p7"><span class="hidden-print"></span></label>
                    </div>
                    <div class="editor-align-content">
                        @php echo stripcslashes(@$newproblem['p7'][0]); @endphp
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 page-break-page custom-container-alignment">
                <h5>                    
                    <span class="check-box-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'discharge-medication-container-checkbox']) !!}
                        <label for="discharge-medication-container-checkbox"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading"><u>DISCHARGE MEDICATIONS:</u></span>
                    <a href="javascript:" class="checkingtest hidden-print" id="report-p8" style="cursor: pointer;" title="Edit" data-count="p8">
                        <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                    </a>
                </h5>
                <div class="generated-content-container">
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'discharge-medication-checkbox']) !!}
                        <label for="discharge-medication-checkbox"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content full-width" style="overflow: auto;">
                        @php $show_instruction = false; @endphp
                        @if (count($discharge_medications) > 0 && count(collect($discharge_medications)->where('additional_instruction', '<>', null)->where('additional_instruction', '<>', '')->toArray()) > 0)
                        @php $show_instruction = true; @endphp
                        @endif
                        <table class="table" style="overflow: auto;">
                            <thead>
                                <tr>
                                    <th>Drug</th>
                                    <th>Generic Name</th>
                                    <th>Formulation</th>
                                    <th>Dose</th>
                                    <th>Frequency</th>
                                    <th>Duration</th>
                                    @if ($show_instruction)
                                    <td>Additional Instruction</td>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($discharge_medications as $medications)
                                <tr>
                                    <td>{!! $medications->Name !!}</td>
                                    <td>{!! $medications->genericname !!}</td>
                                    <td>{!! $medications->Value !!}</td>
                                    <td>{!! $medications->Dose !!}</td>
                                    <td>{!! $medications->Frequency !!}</td>
                                    <td>{!! $medications->Duration !!}</td>
                                    @if ($show_instruction)
                                    <td>{!! $medications->additional_instruction !!}</td>
                                    @endif
                                </tr>
                                @endforeach 
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ Form::hidden('editor_val[p8][0]', @$newproblem['p8'][0]) }}
                <div id="new-problem-report-editor-p8" class="editor-align @if(isset($newproblem['p8'][0]) && !empty($newproblem['p8'][0])) @else hide @endif">
                    <div class="editor-align-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'edited-checkbox-p8']) !!}
                        <label for="edited-checkbox-p8"><span class="hidden-print"></span></label>
                    </div>
                    <div class="editor-align-content">
                        @php echo stripcslashes(@$newproblem['p8'][0]); @endphp
                    </div>
                </div>
            </div>
            @if(!empty($postnatalDetails->advice))
            <div class="col-md-12 col-sm-12 col-xs-12 page-break-page custom-container-alignment">
                <h5>                    
                    <span class="check-box-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'advice-container-checkbox']) !!}
                        <label for="advice-container-checkbox"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading"><u>ADVICE:</u></span>
                    <a href="javascript:" class="checkingtest hidden-print" id="report-p9" style="cursor: pointer;" title="Edit" data-count="p9">
                        <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                    </a>
                </h5>
                <div class="generated-content-container">
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'advice-checkbox']) !!}
                        <label for="advice-checkbox"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content">
                        {!! $postnatalDetails->advice !!}
                    </div>
                </div>
                {{ Form::hidden('editor_val[p9][0]', @$newproblem['p9'][0]) }}
                <div id="new-problem-report-editor-p9" class="editor-align @if(isset($newproblem['p9'][0]) && !empty($newproblem['p9'][0])) @else hide @endif">
                    <div class="editor-align-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'edited-checkbox-p9']) !!}
                        <label for="edited-checkbox-p9"><span class="hidden-print"></span></label>
                    </div>
                    <div class="editor-align-content">
                        @php echo stripcslashes(@$newproblem['p9'][0]); @endphp
                    </div>
                </div>
            </div>
            @endif 
            @if($postnatalDetails->appoinment_status == 'Yes') 
            @php $appoinment = (!is_null($postnatalDetails->appoinment_date)) ? date('d-m-Y', strtotime($postnatalDetails->appoinment_date)) : null; @endphp 
            @php $time = strlen($postnatalDetails->appoinment_hrs) == 1 ? '0'.$postnatalDetails->appoinment_hrs : $postnatalDetails->appoinment_hrs; @endphp 
            @php $min = strlen($postnatalDetails->appoinment_min) == 1 ? '0'.$postnatalDetails->appoinment_min : $postnatalDetails->appoinment_min; @endphp 
            @php $session = $postnatalDetails->appoinment_session @endphp
            @php $appoinment_time = (!empty($time) && !empty($min) && !empty($session)) ? $time.':'.$min.':'.$session : '' @endphp 
            @else 
            @php $appoinment = ''; @endphp @php $appoinment_time = ''; @endphp 
            @endif 
            @if($postnatalDetails->appoinment_status == 'Yes' && !empty($appoinment) || $appoinment_time)
            <div class="col-md-12 col-sm-12 col-xs-12 page-break-page custom-container-alignment">
                <h5>                    
                    <span class="check-box-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'advice-container-checkbox']) !!}
                        <label for="advice-container-checkbox"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading"><u>REVIEW APPOINTMENT:</u></span> {!! $appoinment.' '.$appoinment_time !!}
                </h5>
            </div>
            @endif
            @if(!empty($postnatalDetails->plan_follow_up))
            <div class="col-md-12 col-sm-12 col-xs-12 page-break-page custom-container-alignment">
                <h5>                    
                    <span class="check-box-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'follow-up-container-checkbox']) !!}
                        <label for="follow-up-container-checkbox"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading"><u>PLAN FOR FOLLOW UP:</u></span>
                    <a href="javascript:" class="checkingtest hidden-print" id="report-p10" style="cursor: pointer;" title="Edit" data-count="p10">
                        <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                    </a>
                </h5>
                @if(!empty($postnatalDetails->plan_follow_up))
                <div class="generated-content-container">
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'follow-up-checkbox']) !!}
                        <label for="follow-up-checkbox"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content">
                        {!! $postnatalDetails->plan_follow_up !!}
                    </div>
                </div>
                @endif
                {{ Form::hidden('editor_val[p10][0]', @$newproblem['p10'][0]) }}
                <div id="new-problem-report-editor-p10" class="editor-align @if(isset($newproblem['p10'][0]) && !empty($newproblem['p10'][0])) @else hide @endif">
                    <div class="editor-align-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'edited-checkbox-p10']) !!}
                        <label for="edited-checkbox-p10"><span class="hidden-print"></span></label>
                    </div>
                    <div class="editor-align-content">
                        @php echo stripcslashes(@$newproblem['p10'][0]); @endphp
                    </div>
                </div>
            </div>
            @endif
            <div class="col-md-12 col-sm-12 col-xs-12 page-break-page custom-container-alignment">
                <h5>                    
                    <span class="check-box-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'routine-instruction-container-checkbox']) !!}
                        <label for="routine-instruction-container-checkbox"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading"><u>ROUTINE INSTRUCTIONS:</u></span>
                    <a href="javascript:" class="checkingtest hidden-print" id="report-p11" style="cursor: pointer;" title="Edit" data-count="p11">
                        <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                    </a>
                </h5>
                @if(!empty($headerContent['discharge_instraction']))
                <div class="generated-content-container">
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'routine-instruction-checkbox']) !!}
                        <label for="routine-instruction-checkbox"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content">
                        {!! $headerContent['discharge_instraction'] !!}
                    </div>
                </div>
                @endif
                {{ Form::hidden('editor_val[p11][0]', @$newproblem['p11'][0]) }}
                <div id="new-problem-report-editor-p11" class="editor-align @if(isset($newproblem['p11'][0]) && !empty($newproblem['p11'][0])) @else hide @endif">
                    <div class="editor-align-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'edited-checkbox-p11']) !!}
                        <label for="edited-checkbox-p11"><span class="hidden-print"></span></label>
                    </div>
                    <div class="editor-align-content">
                        @php echo stripcslashes(@$newproblem['p11'][0]); @endphp
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 mt-30 mb-30 plr-must-0">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="pull-left" style="width: 25%;">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="custom-width">Date:</td>
                                            <td class="custom-width"><b>{!! date('d-m-Y') !!}</b></td>
                                        </tr>
                                        <tr>
                                            <td class="custom-width">Place:</td>
                                            <td class="custom-width"><b>{{ env('LOCATION') }}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td class="pull-right" style="width: 75%;">
                                {!! $neonatalDetails->neonatal_consultant !!}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{!! Form::close(); !!}
@endsection
@section('scripts')
@include('reports.copy_summary_list_script')
@endsection
