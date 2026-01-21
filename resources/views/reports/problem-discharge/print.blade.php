@extends('print')
@section('content')
@php $public_url =url('public').'/'; @endphp
@php $dischargeEditpermission = ''; @endphp
{!! Form::model(null,['method' => 'POST','url' => action('Reports\ProblemDischargeController@store',null), 'id'=>'problem-summary']) !!}    
{!! Form::hidden('flag',2) !!}
{!! Form::hidden('BabyId',SiteHelpers::encrypt_id($nicuDetails->BabyId)) !!}
{!! Form::hidden('BMrNo',$nicuDetails->BMrNo) !!}
{!! Form::hidden('AdmissionId',SiteHelpers::encrypt_id($nicuDetails->AdmissionId)) !!}
{!! Form::hidden('status',0) !!}
@if (isset($editor_gen) && $editor_gen)
<div class="editor_style">
    @include('editor_print')  
</div>
@endif
@php $newproblem = unserialize($discharge_details['newproblem']); @endphp
<link rel="stylesheet" type="text/css" href="{{$public_url}}/css/nicu-problem-based-summary.css">
<div class="temp-container nicu-summary">
    <div class="temp-row">
        <div class="col-md-12 text-center">
            <img src="{{ ValuelistHelpers::printPagelogo(@$nicuDetails->hospital_name) }}">
        </div>
        <div class="col-md-12 text-center mt-10">
            <h5 class="text-center"><strong>{!! \ValuelistHelpers::getHospitalsDetails($nicuDetails->hospital_name, $headerContent) !!}</strong> </h5>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 plr-must-0">
            <div id="patient-list" class="nicu-pull-left">
                <div id="company">
                    {!! $headerContent['discharge_report_right'] !!}
                </div>
            </div>
            <div id="doctor-list" class="nicu-pull-left">
                <div id="project">
                    {!! \ValuelistHelpers::headerContent($nicuDetails->hospital_name, $headerContent) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 pb-10 plr-must-0 text-center">
        <h5><strong>Neonatal Intensive Care Unit - Summary Of Stay</strong></h5>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 plr-must-0">
        <div class="col-xs-6 col-sm-6 col-md-6">
        </div>
        <div class="col-md-offset-1 col-xs-6 col-sm-6 col-md-5 pl-10">
            <div class="full-width pull-left">
                <div class="pull-right">
                    Status : {{ $nicuDetails->status }}
                </div>
            </div>
            @if(isset($summary_type) && $summary_type == 'interim')
            <div class="full-width pull-left">
                <div class="pull-right">
                    Date : {{ date('d-m-Y') }} 
                </div>
            </div>
            @else
            @if(date('Y', strtotime($nicuDetails->DischargeDate)) != '1970')
            <div class="full-width pull-left">
                <div class="pull-right">
                    {{ ($nicuDetails->status == 'Died') ? 'Date of Death' : 'Date of Discharge'}} : {{ date('d-m-Y', strtotime($nicuDetails->DischargeDate)) }} 
                </div>
            </div>
            @endif
            @if($nicuDetails->status == 'Died')
            <div class="full-width pull-left">
                <div class="pull-right">
                    Time of Death: {{ $nicuDetails->diedTime.' :'.$nicuDetails->diedMins.':'.$nicuDetails->diedAm }}
                </div>
            </div>
            @endif
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <hr class="summary-hr">
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 problem-summary-content @if(!in_array('NICU_DISCHARGE', \Session::get('write_permission'))) hide-customization @endif">
        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page neonatal-basic-details">
            <h6>
                <span class="check-box-div">
                    {!! Form::checkbox('hide', null) !!}
                    <label><span></span></label>
                </span>
                <span class="custom-heading"><u>NEWBORN DETAILS:</u></span>
            </h6>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <span class="print-label">{{ Lang::get('home.mrn') }}:</span>
                            <span class="print-value">{!! $neonatalDetails->mrno !!}</span>
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
                        @if($summary_type != 'interim')
                        <div class="form-group">
                            <span class="print-label">Discharge weigth (gms):</span>
                            <span class="print-value">{!! $neonatalDetails->discharge_wt !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Discharge OFC (cm):</span>
                            <span class="print-value">{!! $neonatalDetails->discharge_ofc !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Discharge Length (cm):</span>
                            <span class="print-value">{!! $neonatalDetails->discharge_length !!}</span>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">                    
                        <div class="form-group">
                            <span class="print-label">{{ Lang::get('home.ip') }}:</span>
                            <span class="print-value">{!! $nicuDetails->ip_number !!}</span>
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
                        @if ($neonatalDetails->known_field == 1)
                        <div class="form-group">
                            <span class="print-label">
                                <span class="display-inline-block mb-5">Apgars:</span>
                            </span>
                            <span class="print-value">
                                <p class="mb-0 font-normal">1 min : {!! !empty($neonatalDetails->Apgars1min) ? $neonatalDetails->Apgars1min : 'N/A' !!}</p>
                                <p class="mb-0 font-normal">5 min : {!! !empty($neonatalDetails->Apgars5min) ? $neonatalDetails->Apgars5min : 'N/A' !!}</p>
                                <p class="mb-0 font-normal">10 min : {!! !empty($neonatalDetails->Apgars10min) ? $neonatalDetails->Apgars10min : 'N/A' !!}</p>
                            </span>
                        </div>   
                        @endif
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
        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page discharge-details">
            <h6>
                <span class="check-box-div">
                    {!! Form::checkbox('hide', null) !!}
                    <label><span></span></label>
                </span>
                <span class="custom-heading"><u>ADMISSION/DISCHARGE DETAILS:</u></span>
            </h6>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <span class="print-label">Date of Admission:</span>
                            <span class="print-value">{!! $nicuDetails->admission_date !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Admission Corrected Gestational Age (wks):</span>
                            <span class="print-value">{!! $nicuDetails->admission_cga !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Admission Weight (gms):</span>
                            <span class="print-value">{!! $nicuDetails->AdmissionWt !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Admission Age (Day of life):</span>
                            <span class="print-value">{!! ($nicuDetails->AgeOnAdmissioninDays != '' && $nicuDetails->AgeOnAdmissioninDays != 0) ? (preg_replace('/[a-zA-Z]/', '', $nicuDetails->AgeOnAdmissioninDays).' Days') : (!empty($nicuDetails->AgeOnAdmissionhour) ? $nicuDetails->AgeOnAdmissionhour.' Hours' : '0 Hours') !!}</span>
                        </div>
                    </div>
                    @if($summary_type != 'interim')
                    <div class="col-md-6 col-sm-6 col-xs-6">                    
                        <div class="form-group">
                            <span class="print-label">{!! ($nicuDetails->status == 'Died') ? 'Date of Death:' : 'Date of Discharge:' !!}</span>
                            <span class="print-value">{!! $nicuDetails->discharge_date !!}</span>
                        </div>                   
                        <div class="form-group">
                            <span class="print-label">Discharge Corrected Gestational Age (wks):</span>
                            <span class="print-value">{!! $nicuDetails->discharge_cga !!}</span>
                        </div>                  
                        <div class="form-group">
                            <span class="print-label">Discharge weight (gms):</span>
                            <span class="print-value">{!! $nicuDetails->DischargeWeight !!}</span>
                        </div> 
                        <div class="form-group">
                            <span class="print-label">Discharge Age (Day of life):</span>
                            <span class="print-value">{!! $nicuDetails->DOLatDischarge !!}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
            <h6>
                <span class="check-box-div">
                    {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'printstatus_checkbox_prob']) !!}
                    <label for="printstatus_checkbox_prob"><span class="hidden-print"></span></label>
                </span>
                <span class="custom-heading"><u>DIAGNOSIS/NEONATAL PROBLEMS:</u></span>
                <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" id="preport-p31" style="cursor: pointer;" title="Edit" data-count="p31">
                    <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                </a>
            </h6>
            @if(isset($neonatalProblems) && count($neonatalProblems) > 0)
            <div class="generated-content-container">
                <div class="generated-content-checkbox-div">
                    {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'diagnosis_info_checkbox']) !!}
                    <label for="diagnosis_info_checkbox"><span class="hidden-print"></span></label>
                </div>
                <div class="generated-content">    
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0 plr-must-0-print">
                            <ol class="plr-must-0 plr-must-0-print">
                                @foreach($episodes as $episodeLists) 
                                @php $problem = 0 @endphp
                                @foreach($episodeLists as $episodeDetails)
                                @php $flag = 0 @endphp
                                @php $problem_id     = $episodeDetails->problem_id; @endphp
                                @php $problembase    = ProblemBaseHelpers::getProblem($problem_id)  @endphp
                                @php $problem_fields = json_decode($problembase->problem_fields); @endphp
                                @php $problems_parameters = (array)json_decode($episodeDetails->problems_parameters); @endphp 
                                @foreach($problem_fields as $field)
                                @if(isset($field->para_discharge) && $field->para_discharge == '' && !empty($problems_parameters[$field->para_name]))
                                @php $flag = 1 @endphp
                                @endif
                                @endforeach
                                @if( $problem == 0)
                                <li>{!! $episodeDetails->problem_name !!}</li>
                                @endif
                                @php $problem += 1 @endphp
                                @endforeach
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="editor">
                <div id="new-problem-report-editor-p31" class="editor-align @if(isset($newproblem['p31'][0]) && !empty($newproblem['p31'][0])) @else hide @endif">
                    <div class="editor-align-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print','id'=>'problem_checkbox_p31']) !!}
                        <label for="problem_checkbox_p31"><span class="hidden-print"></span></label>
                    </div>
                    <div class="editor-align-content">
                        @php echo stripcslashes(@$newproblem['p31'][0]); @endphp
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
            <h6>
                <span class="check-box-div">
                    {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'printstatus_checkbox_procedure']) !!}
                    <label for="printstatus_checkbox_procedure"><span class="hidden-print"></span></label>
                </span>
                <span class="custom-heading"><u>NEONATAL PROCEDURES PERFORMED:</u></span>
                <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" id="preport-p32" style="cursor: pointer;" title="Edit" data-count="p32">
                    <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                </a>
            </h6>
            @if(is_array($nicuDetails->procedures) && count($nicuDetails->procedures) > 0)
            <div class="generated-content-container">
                <div class="generated-content-checkbox-div">
                    {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'additional_info_checkbox']) !!}
                    <label for="additional_info_checkbox"><span class="hidden-print"></span></label>
                </div>
                <div class="generated-content">   
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0 plr-must-0-print">
                        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0 plr-must-0-print">
                            @php sort($nicuDetails->procedures) @endphp
                            @if(count($nicuDetails->procedures) > 0 && is_array($nicuDetails->procedures))
                            <ol class="pl-13">
                                @foreach($nicuDetails->procedures as $procedure)
                                <li>{{ $procedure }}</li>
                                @endforeach     
                            </ol>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="editor">
                <div id="new-problem-report-editor-p32" class="editor-align @if(isset($newproblem['p32'][0]) && !empty($newproblem['p32'][0])) @else hide @endif">
                    <div class="editor-align-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print','id'=>'problem_checkbox_p32']) !!}
                        <label for="problem_checkbox_p32"><span class="hidden-print"></span></label>
                    </div>
                    <div class="editor-align-content">
                        @php echo stripcslashes(@$newproblem['p32'][0]); @endphp
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page maternal-details">
            <h6>
                <span class="check-box-div">
                    {!! Form::checkbox('hide', null) !!}
                    <label><span></span></label>
                </span>
                <span class="custom-heading"><u>MATERNAL DETAILS:</u></span>
            </h6>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
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
                            <span class="print-value">{{ 'G '.$neonatalDetails->G_Value.' : '.'P '.$neonatalDetails->P_Value.' : '.'L '.$neonatalDetails->L_Value.' : '.'A '.$neonatalDetails->A_Value  }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Conception:</span>
                            <span class="print-value">{!! $neonatalDetails->Conception !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">LMP:</span>
                            <span class="print-value">{!! (!is_null($neonatalDetails->LMP) && !empty($neonatalDetails->LMP)) ? date('d-m-Y', strtotime($neonatalDetails->LMP)) : '' !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">EDD (by dates):</span>
                            <span class="print-value">{!! (!is_null($neonatalDetails->EDDbyDates) && !empty($neonatalDetails->EDDbyDates)) ? date('d-m-Y', strtotime($neonatalDetails->EDDbyDates)) : '' !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">EDD (by USG):</span>
                            <span class="print-value">{!! (!is_null($neonatalDetails->EDDbyUSG) && !empty($neonatalDetails->EDDbyUSG)) ? date('d-m-Y', strtotime($neonatalDetails->EDDbyUSG)) : '' !!}</span>
                        </div>
                        @if(count($mMedicalproblems) > 0)
                        <div class="form-group">
                            <span class="print-label">
                                <span class="display-inline-block mb-5"><u>Medical Problems:</u></span>
                                <ol>
                                    @foreach($mMedicalproblems as $problems)
                                    <li>{!! $problems !!}</li>
                                    @endforeach
                                </ol>
                            </span>
                        </div>   
                        @endif
                        @if(count($usgFinding->where('type',1)) > 0 && count($usgFinding->where('type',1)->where('Gestation','!=',' ')->where('Gestation','!=','')) > 0 && count($usgFinding->where('type',1)->where('Finding','!=',' ')->where('Finding','!=','')) > 0 || count($usgFinding->where('type',2)) > 0 && count($usgFinding->where('type',2)->where('Gestation','!=',' ')->where('Gestation','!=','')) > 0 && count($usgFinding->where('type',2)->where('Finding','!=',' ')->where('Finding','!=','')) > 0 || count($usgFinding->where('type',3)) > 0 && count($usgFinding->where('type',3)->where('Gestation','!=',' ')->where('Gestation','!=','')) > 0 && count($usgFinding->where('type',3)->where('Finding','!=',' ')->where('Finding','!=','')) > 0 || count($usgFinding->where('type',4)) > 0 && count($usgFinding->where('type',4)->where('Gestation','!=',' ')->where('Gestation','!=','')) > 0 && count($usgFinding->where('type',4)->where('Finding','!=',' ')->where('Finding','!=','')) > 0)
                        <div class="form-group">
                            <table>
                                <thead>
                                    <tr>
                                        <th colspan="2"><b><u>Antenatal USG Findings:</u></b></th>
                                    </tr>
                                    <tr>
                                        <th><b><u>Gestation:</b></u></th>
                                        <th><b><u>Findings:</b></u></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($usgFinding->where('type',1)) > 0  && count($usgFinding->where('type',1)->where('Gestation','!=',' ')->where('Gestation','!=','')) > 0 && count($usgFinding->where('type',1)->where('Finding','!=',' ')->where('Finding','!=','')) > 0)
                                    <tr>
                                        <td colspan="2"><b>Dating Scan:</b></td>
                                    </tr>
                                    @foreach($usgFinding->where('type',1) as $usg)    
                                    <tr>
                                        <td>{!! $usg->Gestation !!}</td>
                                        <td>{!! $usg->Finding !!}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    @if(count($usgFinding->where('type',2)) > 0 && count($usgFinding->where('type',2)->where('Gestation','!=',' ')->where('Gestation','!=','')) > 0 && count($usgFinding->where('type',2)->where('Finding','!=',' ')->where('Finding','!=','')) > 0)
                                    <tr>
                                        <td colspan="2"><b>Anomaly Scan:</b></td>
                                    </tr>
                                    @foreach($usgFinding->where('type',2) as $usg)    
                                    <tr>
                                        <td>{!! $usg->Gestation !!}</td>
                                        <td>{!! $usg->Finding !!}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    @if(count($usgFinding->where('type',3)) > 0 && count($usgFinding->where('type',3)->where('Gestation','!=',' ')->where('Gestation','!=','')) > 0 && count($usgFinding->where('type',3)->where('Finding','!=',' ')->where('Finding','!=','')) > 0)
                                    <tr>
                                        <td colspan="2"><b>Follow up scan:</b></td>
                                    </tr>
                                    @foreach($usgFinding->where('type',3) as $usg)    
                                    <tr>
                                        <td>{!! @unserialize($usg->Gestation) !== false ? '' : $usg->Gestation !!}</td>
                                        <td>{!! @unserialize($usg->Finding) !== false ? '' : $usg->Finding !!}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    @if(count($usgFinding->where('type',4)) > 0 && count($usgFinding->where('type',4)->where('Gestation','!=',' ')->where('Gestation','!=','')) > 0 && count($usgFinding->where('type',4)->where('Finding','!=',' ')->where('Finding','!=','')) > 0)
                                    <tr>
                                        <td colspan="2"><b>Doppler Scan:</b></td>
                                    </tr>
                                    @foreach($usgFinding->where('type',4) as $usg)    
                                    <tr>
                                        <td>{!! $usg->Gestation !!}</td>
                                        <td>{!! $usg->Finding !!}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">                    
                        <div class="form-group">
                            <span class="print-label">{{ Lang::get('home.mrn') }}.:</span>
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
                        @if(count($pregnancyComplications) > 0)
                        <div class="form-group">
                            <span class="print-label">
                                <span class="display-inline-block mb-5"><u>Pregnancy Complications:</u></span>
                                <ol>
                                    @foreach($pregnancyComplications as $complications)
                                    <li>{!! $complications !!}</li>
                                    @endforeach
                                </ol>
                            </span>
                        </div>
                        @endif
                        <div class="form-group">
                            <span class="print-label">Antenatal Steroids:</span>
                            <span class="print-value">{!! $neonatalDetails->AntenatalSteroids !!}</span>
                        </div>
                        @if($neonatalDetails->AntenatalSteroids != 'No')
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
                        @if($neonatalDetails->PROM  != 'No')
                        <div class="form-group">
                            <span class="print-label">Duration of PROM:</span>
                            <span class="print-value">{!! $neonatalDetails->DurationOfROM !!}</span>
                        </div>
                        @endif
                        <div class="form-group">
                            <span class="print-label">Maternal Antibiotics:</span>
                            <span class="print-value">{!! $neonatalDetails->Maternal_antibiotics_status !!}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page delivery-details">
            <h6>
                <span class="check-box-div">
                    {!! Form::checkbox('hide', null) !!}
                    <label><span></span></label>
                </span>
                <span class="custom-heading"><u>DELIVERY DETAILS:</u></span>
            </h6>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <span class="print-label">Mode of delivery:</span>
                            <span class="print-value">{!! $neonatalDetails->ModeOfDelivery !!}</span>
                        </div>
                        @if(isset($neonatalDetails->Indication) && is_array($neonatalDetails->Indication)) 
                        <div class="form-group">
                            <span class="print-label">
                                <span class="display-inline-block mb-5"><u>Indication:</u></span>
                                <ol>
                                    @foreach($neonatalDetails->Indication as $indication)
                                    <li>{!! $indication !!}</li>
                                    @endforeach 
                                </ol>
                            </span>
                        </div>   
                        @endif
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
                        @if($neonatalDetails->delayed_cord_clamping != 'No')
                        <div class="form-group">
                            <span class="print-label">Duration of DCC (sec):</span>
                            <span class="print-value">{!! $neonatalDetails->duration_dcc !!}</span>
                        </div>
                        @endif
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
                <span class="custom-heading"><u>DETAILED SUMMARY:</u></span>
            </h6>
            {{ Form::hidden('episodeCount',count($episodes),['id'=>'episode-count']) }}
            @php $i = 0 @endphp
            @foreach($episodes as $episodeLists)    
            <div class="parent-generated-content-container">

                @php $problem = 0 @endphp

                @foreach($episodeLists as $episodeDetails)

                @php $flag = 0 @endphp
                @php $problem_id     = $episodeDetails->problem_id; @endphp
                @php $problembase    = ProblemBaseHelpers::getProblem($problem_id)  @endphp
                @php $problem_fields = json_decode($problembase->problem_fields); @endphp
                @php $problems_parameters = (array)json_decode($episodeDetails->problems_parameters); @endphp 

                @foreach($problem_fields as $field)
                @if(isset($field->para_discharge) && $field->para_discharge == '' && !empty($problems_parameters[$field->para_name]))
                @php $flag = 1 @endphp
                @endif
                @endforeach
                @if( $problem == 0)
                <div class="parent-generated-content-checkbox-div">
                    {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'printstatus_checkbox_'.$i]) !!}
                    <label for="printstatus_checkbox_{{$i}}"><span class="hidden-print"></span></label>
                    <span class="custom-heading"><u> {!! strtoupper($episodeLists->pluck('problem_name')->unique()->implode('')) !!} :</u></span>
                </div>
                @endif
                <div class="parent-generated-content">
                    <h6>                    
                        <span class="check-box-div">

                        </span>
                        <span><b>{!! $episodeDetails->episode_name; !!}</b></span>
                        <a href="javascript:" class="pull-right checkingtest hidden-print {!! $dischargeEditpermission !!}" id="problems-report-{{$episodeDetails->episode_id}}" style="cursor: pointer;" title="Edit">
                            <i class="fa fa-pencil report-editing" id="problems-report-editing-{{$episodeDetails->episode_id}}" data-report="{{$episodeDetails->episode_id}}" aria-hidden="true" data-problem="{{str_replace(' ','',$episodeLists->pluck('problem_name')->unique()->implode(''))}}" data-episode="{{str_replace(' ','',$episodeDetails->episode_name)}}"></i>
                        </a>
                    </h6>
                    <div class="generated-content-container">
                        <div class="generated-content-checkbox-div">
                            {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'episode_checkbox_'.$episodeDetails->episode_id]) !!}
                            <label for="episode_checkbox_{{$episodeDetails->episode_id}}"><span class="hidden-print"></span></label>
                        </div>
                        <div class="generated-content">
                            <table class="problem-editor-{{$episodeDetails->episode_id}}">
                                <tr>
                                    <td id="episode-problem-{{$episodeDetails->episode_id}}">

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
                                        <span class="episode-label"><strong>{!! $episodeproperty->para_label !!}</strong> <strong>:&nbsp</strong></span>
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
                                        <span class="episode-label"><strong>{!! $episodeproperty->para_label !!} </strong><strong>:&nbsp</strong></span>
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
                                        <span class="episode-label">{!! title_case($episodeproperty->para_label) !!} <strong>&nbsp:&nbsp</strong></span>
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
                                        <span class="episode-label"> {!! (isset($episodeproperty->para_label) && !empty($episodeproperty->para_label)) ? title_case($episodeproperty->para_label).':' : '' !!}</span>
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
                    @php $problemname = str_replace(' ', '', $episodeLists->pluck('problem_name')->unique()->implode('')) @endphp
                    @php $episode = str_replace(' ', '', $episodeDetails->episode_name) @endphp
                    <div id="report-editor-{{$episodeDetails->episode_id}}" class="editor-align @if(isset($newproblem[$problemname][$episode]) && !empty($newproblem[$problemname][$episode])) @else hide @endif">
                        <div class="editor-align-checkbox-div">
                            {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'report_checkbox_'.$episodeDetails->episode_id]) !!}
                            <label for="report_checkbox_{{$episodeDetails->episode_id}}"><span class="hidden-print"></span></label>
                        </div>
                        <div class="editor-align-content">
                            @php echo stripcslashes(@$newproblem[$problemname][$episode]); @endphp
                        </div>
                    </div>
                    @php $i++ @endphp
                </div>
                {{ Form::hidden('editor_val['.$problemname.']['.$episode.']', @$newproblem[$problemname][$episode]) }}
                @php $problem += 1 @endphp                    
                @endforeach
            </div>

            @endforeach
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
            <h6>
                <span class="check-box-div">
                    {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'additional_info_hdr_checkbox']) !!}
                    <label for="additional_info_hdr_checkbox"><span class="hidden-print"></span></label>
                </span>
                <span class="custom-heading"><u>ADDITIONAL INFORMATION:</u></span>
                    <!-- <a href="javascript:void(0);" class="hidden-print" title="Add">
                        <i class="fa fa-plus new-problems-adding" aria-hidden="true"></i>
                    </a> -->
                    <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" id="preport-p1" style="cursor: pointer;" title="Edit" data-count="p1">
                        <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                    </a>
                </h6>
                @if (!empty($nicuDetails->additional_information))
                <div class="generated-content-container">
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'additional_info_checkbox']) !!}
                        <label for="additional_info_checkbox"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content">                        
                        {!! $nicuDetails->additional_information !!}
                    </div>
                </div>
                @endif
                <div class="editor">
                    <div id="new-problem-report-editor-p1" class="editor-align @if(isset($newproblem['p1'][0]) && !empty($newproblem['p1'][0])) @else hide @endif">
                        <div class="editor-align-checkbox-div">
                            {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print','id'=>'problem_checkbox_p1']) !!}
                            <label for="problem_checkbox_p1"><span class="hidden-print"></span></label>
                        </div>
                        <div class="editor-align-content">
                            @php echo stripcslashes(@$newproblem['p1'][0]); @endphp
                        </div>
                    </div>
                </div>

            </div>
            @if($summary_type != 'interim')
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page discharged-details">
                <h6>
                    <span class="check-box-div">
                        {!! Form::checkbox('hide', null) !!}
                        <label><span></span></label>
                    </span>
                    <span class="custom-heading"><u>DISCHARGE DETAILS:</u></span>
                </h6>
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <span class="print-label"><u>Newborn Examination</u></span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Eyes:</span>
                                <span class="print-value">{!! $nicuDetails->Eyes !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Cardiac murmur:</span>
                                <span class="print-value">{!! $nicuDetails->cardiacmurmur !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Postductal Spo2:</span>
                                <span class="print-value">{!! $nicuDetails->PostductalSaturation !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Femorals:</span>
                                <span class="print-value">{!! $nicuDetails->nicu_femoral_pulses !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Hips:</span>
                                <span class="print-value">{!! $nicuDetails->Hips !!}</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">                    
                            <div class="form-group">
                                <span class="print-label">Genitalia:</span>
                                <span class="print-value">{!! $nicuDetails->gentila !!}</span>
                            </div>   
                            @if($nicuDetails->gentila != 'Normal')
                            <div class="form-group">
                                <span class="print-label">Genitalia:</span>
                                <span class="print-value">{!! $nicuDetails->gentila_findings !!}</span>
                            </div> 
                            @endif
                            <div class="form-group">
                                <span class="print-label">Malformation:</span>
                                <span class="print-value">{!! $nicuDetails->nicu_malformation !!}</span>
                            </div>
                            @if($nicuDetails->nicu_malformation !='No')
                            <div class="form-group">
                                <span class="print-label">Details:</span>
                                <span class="print-value">{!! $nicuDetails->nicu_malformation_details !!}</span>
                            </div>
                            @endif
                            <div class="form-group">
                                <span class="print-label">Feeding at discharge:</span>
                                <span class="print-value">{!! $nicuDetails->FeedingAtDischarge !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Neurological status:</span>
                                <span class="print-value">{!! $nicuDetails->NeurologicalStatus !!}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @if(!empty($nicuDetails->DischargeHb) || !empty($nicuDetails->DischargePCV) || !empty($nicuDetails->DischargeTSB) || !empty($nicuDetails->DischargeSerumNa) || !empty($nicuDetails->DischargeSerumCa) || !empty($nicuDetails->DischargeSerumPo4) || !empty($nicuDetails->DischargeSerumALP) )
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <span class="print-label"><u>Discharge Blood Tests</u></span>
                            </div>
                            @if(!empty($nicuDetails->DischargeHb))
                            <div class="form-group">
                                <span class="print-label">Hb (g/dl):</span>
                                <span class="print-value">{!! $nicuDetails->DischargeHb !!}</span>
                            </div>
                            @endif
                            @if(!empty($nicuDetails->DischargePCV))
                            <div class="form-group">
                                <span class="print-label">PCV:</span>
                                <span class="print-value">{!! $nicuDetails->DischargePCV !!}</span>
                            </div>
                            @endif
                            @if(!empty($nicuDetails->DischargeTSB))
                            <div class="form-group">
                                <span class="print-label">TSB (mg/dl):</span>
                                <span class="print-value">{!! $nicuDetails->DischargeTSB !!}</span>
                            </div>
                            @endif
                            @if(!empty($nicuDetails->DischargeSerumNa))
                            <div class="form-group">
                                <span class="print-label">Na (mmol/l):</span>
                                <span class="print-value">{!! $nicuDetails->DischargeSerumNa !!}</span>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">    
                            <br/>                
                            @if(!empty($nicuDetails->DischargeSerumCa))
                            <div class="form-group">
                                <span class="print-label">Ca (mg/dl):</span>
                                <span class="print-value">{!! $nicuDetails->DischargeSerumCa !!}</span>
                            </div> 
                            @endif
                            @if(!empty($nicuDetails->DischargeSerumPo4))
                            <div class="form-group">
                                <span class="print-label">PO4 (mg/dl):</span>
                                <span class="print-value">{!! $nicuDetails->DischargeSerumPo4 !!}</span>
                            </div>
                            @endif
                            @if(!empty($nicuDetails->DischargeSerumALP))
                            <div class="form-group">
                                <span class="print-label">ALP(IU/L):</span>
                                <span class="print-value">{!! $nicuDetails->DischargeSerumALP !!}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @endif
            @if(count($VaccineDetails) > 0)
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
                <h6>
                    <span class="check-box-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'immunization_checkbox']) !!}
                        <label for="immunization_checkbox"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading"><u>Immunization :</u> {{ $nicuDetails->Immunization }}</span>
                    <!-- <a href="javascript:void(0);" class="hidden-print" title="Add">
                        <i class="fa fa-plus new-problems-adding" aria-hidden="true"></i>
                    </a> -->
                    <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" id="preport-p3" style="cursor: pointer;" title="Edit" data-count="p3">
                        <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                    </a>
                </h6>
                @if(!empty($nicuDetails->Schedule))
                <div class="generated-content-container">
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'schedule_checkbox']) !!}
                        <label for="schedule_checkbox"><span class="hidden-print"></span></label>
                        <span class="custom-heading"><u>Schedule:</u></span>
                    </div>
                    <div class="generated-content">                        
                        {!! $nicuDetails->Schedule !!}
                    </div>
                </div>
                @endif
                <div class="editor">
                    <div id="new-problem-report-editor-p3" class="editor-align @if(isset($newproblem['p3'][0]) && !empty($newproblem['p3'][0])) @else hide @endif">
                        <div class="editor-align-checkbox-div">
                            {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print','id'=>'problem_checkbox_p3']) !!}
                            <label for="problem_checkbox_p3"><span class="hidden-print"></span></label>
                        </div>
                        <div class="editor-align-content">
                            @php echo stripcslashes(@$newproblem['p3'][0]); @endphp
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
                <h6>
                    <span class="check-box-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print','id'=>'vaccine_date_checkbox']) !!}
                        <label for="vaccine_date_checkbox"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading"><u>Vaccines & Date :</u></span>
                    <!-- <a href="javascript:void(0);" class="hidden-print" title="Add">
                        <i class="fa fa-plus new-problems-adding" aria-hidden="true"></i>
                    </a> -->
                    <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" id="preport-p4" style="cursor: pointer;" title="Edit" data-count="p4">
                        <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                    </a>
                </h6>
                <div class="generated-content-container">
                    <div class="generated-content-checkbox-div pl-15">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print','id'=>'vaccine_checkbox']) !!}
                        <label for="vaccine_checkbox"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content">                        
                        <table style="position: relative; left: -15px;">
                            <thead>
                                <tr>
                                    <th class="print-label-text">Vaccine</th>
                                    <th class="print-label-text">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $vaccineIndex = 0; @endphp
                                @foreach($VaccineDetails as $vaccinelist) 
                                @if(isset($Vaccine[$vaccinelist]))
                                <tr>
                                    <td class="print-label-value">{!! $Vaccine[$vaccinelist] !!}</td>
                                    <td class="print-label-value">@if(isset($VaccineDate[$vaccineIndex]) && !empty($VaccineDate[$vaccineIndex])){!! date('d-m-Y',strtotime($VaccineDate[$vaccineIndex])); !!} @endif</td>
                                </tr>
                                @endif 
                                @php $vaccineIndex++; @endphp
                                @endforeach  
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="editor">
                    <div id="new-problem-report-editor-p4" class="editor-align @if(isset($newproblem['p4'][0]) && !empty($newproblem['p4'][0])) @else hide @endif">
                        <div class="editor-align-checkbox-div">
                            {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'problem_checkbox_p4']) !!}
                            <label for="problem_checkbox_p4"><span class="hidden-print"></span></label>
                        </div>
                        <div class="editor-align-content">
                            @php echo stripcslashes(@$newproblem['p4'][0]); @endphp
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($nicuDetails->HearingScreening != '' || $nicuDetails->RopScreening !='')
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page neonatal-basic-details">
                <h6>
                    <span class="check-box-div">
                        {!! Form::checkbox('hide', null) !!}
                        <label><span></span></label>
                    </span>
                    <span class="custom-heading"><u>Other Screening Tests:</u></span>
                </h6>
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <span class="print-label">Newborn Metabolic Screen:</span>
                                <span class="print-value">{!! $nicuDetails->NicuNewBornScreen !!}</span>
                            </div>
                            @if($nicuDetails->HearingScreening == 'Performed')
                            <div class="form-group">
                                <span class="print-label">Hearing Screen:</span>
                                <span class="print-value">{!! $nicuDetails->HearingScreening !!}</span>
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
                                                <td>{!! $nicuDetails->oae_left !!}</td>
                                                <td>{!! $nicuDetails->oae_right !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </span>
                            </div>   
                            @if(!empty($nicuDetails->abr_left) || !empty($nicuDetails->abr_right))
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
                                                <td>{!! $nicuDetails->abr_left !!}</td>
                                                <td>{!! $nicuDetails->abr_right !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </span>
                            </div>   
                            @endif
                            @endif
                            <br/>
                            @if($nicuDetails->RopScreening !='')
                            <div class="form-group">
                                <span class="print-label">ROP Screen:</span>
                                <span class="print-value">{!! $nicuDetails->RopScreening !!}</span>
                            </div>  
                            @if(!empty($nicuDetails->result_rop_left) || !empty($nicuDetails->result_rop_right))
                            <div class="form-group">
                                <span class="print-label">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th colspan="2"><b><u>ROP Screening Result:</u></b></th>
                                            </tr>
                                            <tr>
                                                <th><b>Left:</b></th>
                                                <th><b>Right:</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{!! $nicuDetails->result_rop_left !!}</td>
                                                <td>{!! $nicuDetails->result_rop_right !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </span>
                            </div>   
                            @endif
                            @endif 
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(!empty($nicuDetails->cranial_ultrasound))  
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page neonatal-basic-details">
                <h6>
                    <span class="check-box-div">
                        {!! Form::checkbox('hide', null) !!}
                        <label><span></span></label>
                    </span>
                    <span class="custom-heading"><u>Cranial ultrasound:</u></span>
                </h6>
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                        <!-- <div class="col-md-6 col-sm-6 col-xs-6"> -->
                            <div class="form-group">
                                {!! $nicuDetails->cranial_ultrasound !!}
                            </div>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
                @endif
                @if(!empty($nicuDetails->echocardiography))
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page neonatal-basic-details">
                    <h6>
                        <span class="check-box-div">
                            {!! Form::checkbox('hide', null) !!}
                            <label><span></span></label>
                        </span>
                        <span class="custom-heading"><u>Echocardiography:</u></span>
                    </h6>
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-print">
                            <!-- <div class="col-md-6 col-sm-6 col-xs-6"> -->
                                <div class="form-group">
                                    {!! $nicuDetails->echocardiography !!}
                                </div>
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
                        <h6>
                            <span class="check-box-div">
                                {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print','id'=>'communication_title_checkbox']) !!}
                                <label for="communication_title_checkbox"><span class="hidden-print"></span></label>
                            </span>
                            <span class="custom-heading"><u>Communication with Parents :</u></span>
                    <!-- <a href="javascript:void(0);" class="hidden-print" title="Add">
                        <i class="fa fa-plus new-problems-adding" aria-hidden="true"></i>
                    </a> -->
                    <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" id="preport-p5" style="cursor: pointer;" title="Edit" data-count="p5">
                        <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                    </a>
                </h6>
                <div class="generated-content-container">
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print','id'=>'communication_checkbox']) !!}
                        <label for="communication_checkbox"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content">    
                        Parents were fully updated regarding the baby’s daily progress and they were provided with sufficient opportunities to clarify their questions.                    
                    </div>
                </div>
                <div class="editor">
                    <div id="new-problem-report-editor-p5" class="editor-align @if(isset($newproblem['p5'][0]) && !empty($newproblem['p5'][0])) @else hide @endif">
                        <div class="editor-align-checkbox-div">
                            {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'problem_checkbox_p5']) !!}
                            <label for="problem_checkbox_p5"><span class="hidden-print"></span></label>
                        </div>
                        <div class="editor-align-content">
                            @php echo stripcslashes(@$newproblem['p5'][0]); @endphp
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
                <h6>
                    <span class="check-box-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print','id'=>'discharge_checkbox']) !!}
                        <label for="discharge_checkbox"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading"><u>DISCHARGE MEDICATIONS:</u></span>
                    <!-- <a href="javascript:void(0);" class="hidden-print" title="Add">
                        <i class="fa fa-plus new-problems-adding" aria-hidden="true"></i>
                    </a> -->
                    <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" id="preport-p6" style="cursor: pointer;" title="Edit" data-count="p6">
                        <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                    </a>
                </h6>
                <div class="generated-content-container">
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'discharge_machine_checkbox']) !!}
                        <label for="discharge_machine_checkbox"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content" style="overflow: auto;">    
                        <table class="table" style="table-layout: auto;">
                            <thead>
                                <tr>
                                    <th>Drug</th>
                                    <th>Generic Name</th>
                                    <th>Formulation</th>
                                    <th>Dose</th>
                                    <th>Frequency</th>
                                    <th>Duration</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $frequency_list = ValuelistHelpers::drugFrequencyList(); @endphp
                                @foreach($discharge_medications as $medications)    
                                <tr>
                                    <td>{!! isset($medications->Name) ? $medications->Name : '' !!}</td>
                                    <td>{!! isset($medications->genericname) ? $medications->genericname : '' !!}</td>
                                    <td>{!! isset($medications->Value) ? $medications->Value : '' !!}</td>
                                    <td>{!! isset($medications->Dose) ? $medications->Dose : '' !!}</td>
                                    <td>{!! isset($medications->Frequency) ? (isset($frequency_list[$medications->Frequency]) ? $frequency_list[$medications->Frequency] : $medications->Frequency) : '' !!}</td>
                                    <td>{!! isset($medications->Duration) ? $medications->Duration : '' !!}</td>
                                </tr>
                                @endforeach    
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="editor">
                    <div id="new-problem-report-editor-p6" class="editor-align @if(isset($newproblem['p6'][0]) && !empty($newproblem['p6'][0])) @else hide @endif">
                        <div class="editor-align-checkbox-div">
                            {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'problem_checkbox_p6']) !!}
                            <label for="problem_checkbox_p6"><span class="hidden-print"></span></label>
                        </div>
                        <div class="editor-align-content">
                            @php echo stripcslashes(@$newproblem['p6'][0]); @endphp
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
                <h6>
                    <span class="check-box-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'advice_title_checkbox']) !!}
                        <label for="advice_title_checkbox"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading"><u>ADVICE:</u></span>
                    <!-- <a href="javascript:void(0);" class="hidden-print" title="Add">
                        <i class="fa fa-plus new-problems-adding" aria-hidden="true"></i>
                    </a> -->
                    <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" id="preport-p7" style="cursor: pointer;" title="Edit" data-count="p7">
                        <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                    </a>
                </h6>
                @if (!empty($nicuDetails->advice))
                <div class="generated-content-container">
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'advice_checkbox']) !!}
                        <label for="advice_checkbox"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content">  
                        {!! $nicuDetails->advice !!}
                    </div>
                </div>
                @endif 
                <div class="editor">
                    <div id="new-problem-report-editor-p7" class="editor-align @if(isset($newproblem['p7'][0]) && !empty($newproblem['p7'][0])) @else hide @endif">
                        <div class="editor-align-checkbox-div">
                            {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'problem_checkbox_p7']) !!}
                            <label for="problem_checkbox_p7"><span class="hidden-print"></span></label>
                        </div>
                        <div class="editor-align-content">
                            @php echo stripcslashes(@$newproblem['p7'][0]); @endphp
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
                <h6>
                    <span class="check-box-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print','id'=>'review_title_checkbox']) !!}
                        <label for="review_title_checkbox"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading"><u>REVIEW APPOINTMENT:</u></span>
                    <!-- <a href="javascript:void(0);" class="hidden-print" title="Add">
                        <i class="fa fa-plus new-problems-adding" aria-hidden="true"></i>
                    </a> -->
                    <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" id="preport-p8" style="cursor: pointer;" title="Edit" data-count="p8">
                        <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                    </a>
                </h6>
                @if($nicuDetails->NextAppointmentStatus == 'Yes') 
                <div class="generated-content-container">
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'review_checkbox']) !!}
                        <label for="review_checkbox"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content">  
                        <b>
                            <h4 class="m-0">
                                @if($nicuDetails->NextAppointmentStatus == 'Yes' && !str_contains($nicuDetails->NextAppointment, '1970-01-01')) 
                                @php $appoinment = date('d-m-Y', strtotime($nicuDetails->NextAppointment))  @endphp
                                @php $time = strlen($nicuDetails->NAT_TIME)  == 1 ? '0'.$nicuDetails->NAT_TIME : $nicuDetails->NAT_TIME;  @endphp
                                @php $min = strlen($nicuDetails->NAT_MINS)  == 1 ? '0'.$nicuDetails->NAT_MINS : $nicuDetails->NAT_MINS;  @endphp
                                @php $session = strlen($nicuDetails->NAT_AM)  == 1 ? '0'.$nicuDetails->NAT_AM : $nicuDetails->NAT_AM;  @endphp
                                {!! $appoinment !!}
                                @if ((isset($time) && !empty($time)) && (isset($min) && !empty($min)) && (isset($session) && !empty($session)))
                                {!! ' '.$time.':'.$min.':'.$session !!}
                                @endif
                                @endif
                            </h4>
                        </b>
                    </div>
                </div>
                @endif 
                <div class="editor">
                    <div id="new-problem-report-editor-p8" class="editor-align @if(isset($newproblem['p8'][0]) && !empty($newproblem['p8'][0])) @else hide @endif">
                        <div class="editor-align-checkbox-div">
                            {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print','id'=>'problem_checkbox_p8']) !!}
                            <label for="problem_checkbox_p8"><span class="hidden-print"></span></label>
                        </div>
                        <div class="editor-align-content">
                            @php echo stripcslashes(@$newproblem['p8'][0]); @endphp
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
                <h6>
                    <span class="check-box-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'follow_up_title_checkbox']) !!}
                        <label for="follow_up_title_checkbox"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading"><u>PLAN FOR FOLLOW UP:</u></span>
                    <!-- <a href="javascript:void(0);" class="hidden-print" title="Add">
                        <i class="fa fa-plus new-problems-adding" aria-hidden="true"></i>
                    </a> -->
                    <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" id="preport-p9" style="cursor: pointer;" title="Edit" data-count="p9">
                        <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                    </a>
                </h6>
                @if (!empty($nicuDetails->plan_follow_up))
                <div class="generated-content-container">
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'follow_up_checkbox']) !!}
                        <label for="follow_up_checkbox"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content">  
                        {!! $nicuDetails->plan_follow_up !!}
                    </div>
                </div>
                @endif                
                <div class="editor">
                    <div id="new-problem-report-editor-p9" class="editor-align @if(isset($newproblem['p9'][0]) && !empty($newproblem['p9'][0])) @else hide @endif">
                        <div class="editor-align-checkbox-div">
                            {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'problem_checkbox_p9']) !!}
                            <label for="problem_checkbox_p9"><span class="hidden-print"></span></label>
                        </div>
                        <div class="editor-align-content">
                            @php echo stripcslashes(@$newproblem['p9'][0]); @endphp
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0-screen page-break-page">
                <h6>
                    <span class="check-box-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'instruction_checkbox']) !!}
                        <label for="instruction_checkbox"><span class="hidden-print"></span></label>
                    </span>
                    <span class="custom-heading"><u>ROUTINE INSTRUCTIONS:</u></span>
                    <!-- <a href="javascript:void(0);" class="hidden-print" title="Add">
                        <i class="fa fa-plus new-problems-adding" aria-hidden="true"></i>
                    </a> -->
                    <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" id="preport-p10" style="cursor: pointer;" title="Edit" data-count="p10">
                        <i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>
                    </a>
                </h6>
                @if (!empty($headerContent['discharge_instraction']))
                <div class="generated-content-container">
                    <div class="generated-content-checkbox-div">
                        {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print', 'id'=>'discharge_instruction_checkbox']) !!}
                        <label for="discharge_instruction_checkbox"><span class="hidden-print"></span></label>
                    </div>
                    <div class="generated-content">  
                        {!! $headerContent['discharge_instraction'] !!}
                    </div>
                </div>
                @endif                
                <div class="editor">
                    <div id="new-problem-report-editor-p10" class="editor-align @if(isset($newproblem['p10'][0]) && !empty($newproblem['p10'][0])) @else hide @endif">
                        <div class="editor-align-checkbox-div">
                            {!! Form::checkbox('printstatus', '',true, ['class'=>'hidden-print','title'=>'Remove from the print','id'=>'problem_checkbox_p10']) !!}
                            <label for="problem_checkbox_p10"><span class="hidden-print"></span></label>
                        </div>
                        <div class="editor-align-content">
                            @php echo stripcslashes(@$newproblem['p10'][0]); @endphp
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0 summary-info page-break-page">
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
{{ Form::hidden('editor_val[p31][0]', @$newproblem[p31][0]) }}
{{ Form::hidden('editor_val[p32][0]', @$newproblem[p32][0]) }}
{{ Form::hidden('editor_val[p1][0]', @$newproblem[p1][0]) }}
{{ Form::hidden('editor_val[p3][0]', @$newproblem[p3][0]) }}
{{ Form::hidden('editor_val[p4][0]', @$newproblem[p4][0]) }}
{{ Form::hidden('editor_val[p5][0]', @$newproblem[p5][0]) }}
{{ Form::hidden('editor_val[p6][0]', @$newproblem[p6][0]) }}
{{ Form::hidden('editor_val[p7][0]', @$newproblem[p7][0]) }}
{{ Form::hidden('editor_val[p8][0]', @$newproblem[p8][0]) }}
{{ Form::hidden('editor_val[p9][0]', @$newproblem[p9][0]) }}
{{ Form::hidden('editor_val[p10][0]', @$newproblem[p10][0]) }}
{!! Form::close() !!}
@endsection
@section('scripts')
@include('reports.copy_summary_list_script')
@endsection
