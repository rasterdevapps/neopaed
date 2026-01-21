@extends('print')
@section('content')
    @php $public_url =url('public').'/'; @endphp
    @php $specialPermission = \Session::get('specialPermissions'); @endphp
    @php $specialPermission = count($specialPermission) > 0 ? $specialPermission : array() @endphp
    @php if(isset($dischargeSummarymodified['is_completed']) && $dischargeSummarymodified['is_completed'] == 2 && !in_array('DISCHARGE_EDIT',$specialPermission)){ $dischargeEditpermission = 'hide'; }else{ $dischargeEditpermission = ''; } @endphp

    {!! Form::model(null,['method' => 'POST','url' => action('Reports\NicuDischargeController@store',null)]) !!}    
        {!! Form::hidden('flag',2) !!}
        {!! Form::hidden('BabyId',$enc['babyId']) !!}
        {!! Form::hidden('status',0) !!}
        <style type="text/css">
            body {
                font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
                font-size: 12px;
                line-height: 1.42857143;
            }
            #company div {
                line-height: 1.7;
            }
            #project div, #company div {
                font-weight: 600;
            }
            .header-down {
                margin-top: 100px !important;
            }
            .customTableSelector.hidden-print, .hide {
                display: none;
            }
            table > tbody {
                vertical-align: top;
            }
            .pull-left {
                float: left
            }
            .pull-right {
                float: right;
            }
            .text-center {
                text-align: center;
            }
            .table {
                width: 100%;
                margin-bottom: 20px;
            }
            .dischargemedications-report-editor td {
                padding: 5px 10px;
                line-height: 1.42857143;
                vertical-align: top;
                border-top: 1px solid #ddd;
            }
            .page-break {
                display: table;
                page-break-after: auto;
            }
            .page-break-always {
                page-break-before: always;
                display: table;
            }
            td {
                page-break-inside: auto;
            }
            .mother-detail {
                padding-top:30px;
                page-break-before: always;
            }
            .discharge-print {
                margin: 45px 0px 0px -33px;
            }
            .list-none {
                list-style: none;
            }
        </style>
        <div class="temp-container">
            <div class="temp-row">
            <!-- BEGIN HEADER CONTENT -->
                <div class="col-md-12 @if(isset($headerContent['header_required']) && $headerContent['header_required'] == 1) hide @endif">
                       <img src="{{ SiteHelpers::getNicuLogoDocs($result->NicuId) }}" />
                </div>

                {{--*\ $phone = strpos($headerContent['hospital_contact'],'/') > 0 ? explode('/', $headerContent['hospital_contact'])[0] : $headerContent['hospital_contact'] ;  \*--}}

                <div class="@if(isset($headerContent['header_required']) && $headerContent['header_required'] == 1) hide @endif"> 
                    @if($result->hospital_name == 'Sudha Hospital')
                     <h5 class="text-center"><strong>Sudha Hospitals Phone : 9786065454, 6384047007</strong> </h5>
                    @elseif($result->hospital_name == 'Saraswathi Hospital')
                        <h5 class="text-center"><strong>Saraswathi Hospital Phone : 9786065454, 6384047007</strong> </h5>
                    @else
                    <h5 class="text-center"><strong>{{ $headerContent['hospital_name'] }} PHONE : {{ $headerContent['hospital_contact'] }}</strong> </h5>
                    @endif
                </div>
                <div class=" @if(isset($headerContent['header_required']) && $headerContent['header_required'] == 1) header-down @endif">
                    <div id="patient-list">
                        <div id="company" class="pull-right">
                            <div><span style="text-decoration:underline;font-size:1em;">CONSULTANTS</span></div>
                            {!! $headerContent['discharge_report_right'] !!}
                        </div>
                    </div>
                    <div id="doctor-list" style="margin-bottom: 30px;">
                        <div id="project">
                            <div><span style="text-decoration:underline;font-size:1em;">CONSULTANTS</span></div>
                            {!! $headerContent['discharge_report_left'] !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h5 class="text-center"><strong>Neonatal Intensive Care Unit - Summary Of Stay</strong> </h5>
                        <div class="row" style="margin-bottom:15px;">
                            <span class="col-xs-3 col-sm-6 col-md-6">
                                <span><b>Neonatal Paediatrician :</b></span>
                            </span>
                            <div class="col-xs-9 col-sm-12">
                                {{ $result->neonatal_consultant }}
                            </div>
                            @if(!empty(trim($result->paediatric_surgeon)))
                                <span class="pull-left col-xs-3 col-sm-6 col-md-6"><b>Paediatric Surgeon :</b></span>
                                <div class="col-xs-9 col-sm-12">
                                    {!! ValuelistHelpers::get_surgeons_lists($result->paediatric_surgeon) !!}
                                    <!-- DR D.V.SURESH DCH , DNB(PED),MNAMS -->
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <hr style="margin-top:0px;border-top:2px solid #000;margin-bottom:10px;" />
                    </div>
                </div>
                <!-- END HEADER CONTENT -->
              
                <div class="">
                    <div class="">
                        <table class="table col-xs-12 col-md-11 col-sm-9 customTableSelector" style="">
                            <tbody>
                                <tr><td colspan="2"><b> Baby Details: </b></td></tr>  
                                <tr>
                                    <td class='not-affect-parent'>    
                                        <table class="baby-basic-details">
                                            <tr>
                                                <td>{{ Lang::get('home.mrn') }}: </td>
                                                <td>{{ $result->babymr }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Name : </b></td>
                                                <td><b>{{ $result->BabyName }}</b></td>
                                            </tr>
                                            @php $result->TOB_TIME = (strlen($result->TOB_TIME)==1)? '0'.$result->TOB_TIME : $result->TOB_TIME ;@endphp
                                            @php $result->TOB_MINS = (strlen($result->TOB_MINS)==1)? '0'.$result->TOB_MINS : $result->TOB_MINS ;@endphp
                                            <tr>
                                                <td> <b>Birth Date & Time :</b></td>
                                                <td><b>{{ date('d-m-Y',strtotime($result->DOB)) }} ; {{ $result->TOB_TIME }}:{{ $result->TOB_MINS }}:{{ $result->TOB_AM }} </b></td>
                                            </tr>
                                            <tr>
                                                <td><b>Sex :</b></td>
                                                <td><b>{{ $result->Sex }}</b></td>
                                            </tr>
                                            <tr>
                                                <td><b>Gestation :</b></td>
                                                <td><b>{{ $result->Gestation }}</b></td>
                                            </tr>
                                            <tr>
                                                <td><b>Corrected Gestational Age :</b></td>
                                                <td><b>{{ $result->corrected_gestation }}</b></td>
                                            </tr>
                                            <tr>
                                                <td>Day Of Life :</td>
                                                <td>{{ SiteHelpers::calculate_day_of_life_two(date('Y-m-d',strtotime($result->DOB)),date('Y-m-d',strtotime($result->DischargeDate)))  }}</td>
                                            </tr>
                                            <tr>
                                                <td>Birth Status :</td>
                                                <td>{{ ($result->BirthStatus =='Inborn') ? 'Intramural' : 'Extramural' }}</td>
                                            </tr>
                                            <tr>
                                                <td> Mode of delivery :</td>
                                                <td> {{ $result->ModeOfDelivery }}</td>
                                            </tr>
                                            <tr>
                                                <td> Birth Order:</td>
                                                <td>{{ $result->BirthOrder }}</td>
                                            </tr>                                                              
                                        </table>
                                    </td>
                                    <td class='not-affect-parent'>
                                        <table class="baby-basic-details">
                                            <tr>
                                                <td>{{ Lang::get('home.ip') }} :</td>
                                                <td>{{ $ipnumber }}</td>
                                            </tr>
                                            <tr>
                                                <td>Baby's Blood Group :</td>
                                                <td>{{ $result->BabyBloodGroup }}</td>
                                            </tr>
                                            <tr>
                                                <td>Date of Admission :</td>
                                                <td>{{ $result->AdmissionDate }}</td>
                                            </tr>
                                            @if($result->Discharge_status == 'Died' || $result->Discharge_status == 'Died (OCNR)')
                                                <tr>
                                                    <td>Date of Death :</td>
                                                    <td>{{ $result->DischargeDate }}</td>
                                                </tr>
                                                @php $result->diedTime = (strlen($result->diedTime) == 1) ? '0'.$result->diedTime : $result->diedTime ; @endphp
                                                @php $result->diedMins = (strlen($result->diedMins) == 1) ? '0'.$result->diedMins : $result->diedMins ; @endphp
                                                <tr>
                                                    <td>Time of Death :</td>
                                                    <td>{{ $result->diedTime.':'.$result->diedMins.':'.$result->diedAm }}</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>Date of Discharge :</td>
                                                    <td>{{ $result->DischargeDate }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>Birth Weight (g) :</td>
                                                <td>{{ (!empty($result->BirthWeight) && $result->BirthWeight != 0) ?  $result->BirthWeight : 'N/A' }} </td>
                                            </tr>
                                            <tr>
                                                <td>Birth OFC (cm) :</td>
                                                <td>{{ (!empty($result->OFC) && $result->OFC != 0) ?  $result->OFC : 'N/A' }} </td>
                                            </tr>
                                            <tr>
                                                <td>Birth Length (cm) :</td>
                                                <td>{{ (!empty($result->Length) && $result->Length != 0) ?  $result->Length : 'N/A' }} </td>
                                            </tr>
                                            <tr>
                                                <td>Discharge Weight (g) :</td>
                                                <td>{{ (!empty($result->nicuDischargeWeight) && $result->nicuDischargeWeight != 0) ?  $result->nicuDischargeWeight : 'N/A' }} </td>
                                            </tr>                                
                                            <tr>
                                                <td>Discharge OFC (cm) :</td>
                                                <td>{{ (!empty($result->nicu_ofc) && $result->nicu_ofc != 0) ?  $result->nicu_ofc : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Discharge length (cm) :</td>
                                                <td>{{ (!empty($result->nicu_Length) && $result->nicu_Length != 0) ?  $result->nicu_Length : 'N/A' }} </td>
                                            </tr>                                    
                                        </table>    
                                    </td>   
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align:justify ;">
                                        {!! Form::hidden('Problems') !!}
                                        <br/>
                                            <b>Diagnosis :</b>                                   
                                            <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="float: right; cursor: pointer;" title="Edit">
                                            <i class="fa fa-pencil-square-o problems-report-editing" aria-hidden="true"></i>
                                            </a>
                                        <br/>
                                        <div class="problems-report-editor">
                                            @if(count($dischargeSummarymodified) <=  0)
                                                @if (isset($get_problem) && is_array($get_problem)) 
                                                    <ol>                           
                                                        @foreach ($get_problem as $key => $value)
                                                            @if(!empty($value))
                                                                <li>{{ $value }}</li>
                                                            @endif 
                                                        @endforeach
                                                    </ol>
                                                @endif
                                                {{ $Problems_text or '' }}
                                            @else
                                                {!! $dischargeSummarymodified['Problems'] !!}
                                            @endif        
                                        </div>
                                    </td>
                                </tr>
                                @if(!empty($proceduresSystem))
                                    <tr>
                                        <td colspan="2">
                                            {!! Form::hidden('Procedures') !!}
                                        <br/>
                                        <b>Procedures:</b>  
                                        <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="float: right; cursor: pointer;" title="Edit">
                                            <i class="fa fa-pencil-square-o Procedures-report-editing" aria-hidden="true"></i>
                                        </a>
                                        <br/>
                                        <div class="procedures-report-editor">
                                            @if(count($dischargeSummarymodified) <= 0)
                                                {!! $proceduresSystem !!}
                                            @else
                                                {!! $dischargeSummarymodified['Procedures'] !!}
                                            @endif  
                                        </div>
                                        </td>
                                    </tr>
                                @endif
                                @if(!empty($result->ReferredBy) && !empty($result->ReferralReason))
                    <!--  <tr class="page-break"> -->
                                    <tr>
                                        <td colspan="2">
                                            {!! Form::hidden('Summarybirth') !!} 
                                            <br/>
                                            <b>Summary:</b>
                                            <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="float: right; cursor: pointer;" title="Edit">
                                                <i class="fa fa-pencil-square-o Summarybirth-report-editing" aria-hidden="true"></i>
                                            </a>
                                            <br/> 
                                            <div class="summarybirth-report-editor">
                                                @if(count($dischargeSummarymodified) <= 0)        
                                                    @if($result->BirthStatus == 'Outborn')
                                                        {{ $result->BabyName }} was refered from {{ $result->ReferredBy }} with history of {{ $result->ReferralReason }} on day {{ SiteHelpers::calculate_day_of_life(date('Y-m-d',strtotime($result->DOB))) }} of life.
                                                    @endif
                                                    @if($result->BirthStatus == 'Inborn')
                                                        {{ $result->BabyName }} was born at {{ $result->ReferredBy }} and admitted to the neonatal unit with a history of {{ $result->ReferralReason }} on day {{ SiteHelpers::calculate_day_of_life(date('Y-m-d',strtotime($result->DOB))) }} of life. 
                        
                                                    @endif
                                                @else
                                                    {!! $dischargeSummarymodified['Summarybirth'] !!}
                                                @endif   
                                            </div> 
                                        </td>
                                    </tr>
                                @endif
                                <!-- <tr class="blank_row"><td colspan="2"></td></tr>
                                <tr class="blank_row"><td colspan="2"></td></tr>
                                <tr class="blank_row"><td colspan="2"></td></tr>
                                <tr class="blank_row"><td colspan="2"></td></tr>
                                <tr class="blank_row"><td colspan="2"></td></tr>
                                <tr class="blank_row"><td colspan="2"></td></tr>
                                <tr class="blank_row"><td colspan="2"></td></tr>
                                <tr class="blank_row"><td colspan="2"></td></tr> -->
                                <!-- <tr class="blank_row"><td colspan="2"></td></tr> -->
                                <!-- <tr class="page-break"></tr> -->
                                <tr class="page-break"></tr>
                                <tr class="mother-detail"><td colspan="2"><b>Mother Details :</b></td></tr>  
                                <tr>
                                    <td>
                                        <table class="baby-basic-details">
                                            <tr>
                                                <td>Mother's Name :</td>
                                                <td>{{ $result->MotherTitle }} {{ $result->MotherInitial }} {{ $result->MotherName }} {{ $result->MotherLastName }}</td>
                                            </tr>
                                            <tr>
                                                <td>Age :</td>
                                                <td>{{ $result->MothercYear }}</td>
                                            </tr>
                                            <tr>
                                                <td>Mother's Blood Group :</td>
                                                <td>{{ $result->MotherBloodGroup }}</td>
                                            </tr>                                        
                                        </table>
                                    </td>
                                    <td>                                     
                                        <table class="baby-basic-details">
                                            <tr>
                                                <td>EDD by dates :</td>
                                                <td>@if(date('Y',strtotime($result->EDDbyDates)) > 1970) {{ date('d-m-Y',strtotime($result->EDDbyDates)) }} @else N/A @endif</td>
                                            </tr>
                                            @if(!empty($result->EDDbyUSG))
                                                <tr>
                                                    <td>EDD by USG :</td>
                                                    <td>{{ date('d-m-Y',strtotime($result->EDDbyUSG)) }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>Conception :</td>
                                                <td> {{ $result->Conception }}</td>
                                            </tr>  
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        Obstetric history: Gravida @if(!empty($result->G_Value)) {{ $result->G_Value }} @else 0 @endif  Para @if(!empty($result->P_Value)) {{ $result->P_Value }} @else 0 @endif Live @if(!empty($result->L_Value)) {{ $result->L_Value }} @else 0 @endif Abortion @if(!empty($result->A_Value)) {{ $result->A_Value }} @else 0 @endif
                                    </td>
                                </tr>   
                                <tr>
                                    <td colspan="2">
                                        <b>Mother's Medical Problems :</b>
                                        <br/>
                                        <table class="table-condensed">
                                            <tr>
                                                <th style="font-size: 12px;">Problems</th>
                                                <th style="font-size: 12px;">Medications</th>
                                            </tr>
                                            @forelse($medical_problems as $problems)
                                                <tr>
                                                    <td> {{ $problems->Name }}       </td>
                                                    <td> {{ $problems->Medication }} </td>
                                                </tr> 
                                            @empty  
                                                <tr>
                                                    <td> Nil </td>
                                                    <td> Nil </td>
                                                </tr> 
                                            @endforelse
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <b>Pregnancy problems:</b>
                                        <br/>
                                        <table class="table-condensed">
                                                <tr>
                                                    <th style="font-size: 12px;">Complications</th>
                                                    <th style="font-size: 12px;">Treatment</th>
                                                </tr>
                                                @forelse($medical_complications as $complication)
                                                <tr>
                                                    <td>{{ $complication->Name }}</td>
                                                    <td>{{ $complication->Treatment }}</td> 
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td> Nil </td>
                                                    <td> Nil </td> 
                                                </tr>
                                                @endforelse    
                                        </table>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Antenatal Ultrasound scan findings:</b>
                                        <br/>
                                        <table>
                                            <tr>
                                                <th style="font-size: 12px;">Gestations</th>
                                                <th style="font-size: 12px;">Findings</th>  
                                            </tr>
                                            @forelse($ultrasoundfindings as $ultrasounds)
                                                <tr>
                                                    <td>{{ $ultrasounds['gastations'] }}</td>
                                                    <td>{{ $ultrasounds['findings'] }}</td> 
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td> Not available </td>
                                                    <td> Not available </td> 
                                                </tr>
                                            @endforelse
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align:justify ;">
                                        {!! Form::hidden('Birth') !!}
                                        <br/>
                                        <b>Birth:</b>
                                        <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="float: right; cursor: pointer;" title="Edit">
                                            <i class="fa fa-pencil-square-o birth-report-editing" aria-hidden="true"></i>
                                        </a>
                                        <br/>
                                        <div class="birth-report-editor">
                                            @if(count($dischargeSummarymodified) <=  0)

                                                @if($daycaresheetscount != 0)


                                                Baby was born at {{ $result->Gestation }} weeks of
                                                gestation by  {{ strtolower($result->ModeOfDelivery) }} delivery.
                                                
                                                {{ $result->Indication }}

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

                                                {{ $result->Birth }}

                                                @endif

                                            @else
                                                {!! $dischargeSummarymodified['Birth'] !!}
                                            @endif  
                                        </div>
                                    </td>
                                </tr>
                                <tr class="page-break"></tr>
                                <tr>
                                    <td colspan="2" style="text-align:justify ;">
                                        {!! Form::hidden('RespiratorySystem') !!}
                                        <br/>
                                        <b>Respiratory system:</b>
                                        <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="float: right; cursor: pointer;" title="Edit">
                                            <i class="fa fa-pencil-square-o respiratorysystem-report-editing" aria-hidden="true"></i>
                                        </a>
                                        <br/>
                                        <div class="respiratorysystem-report-editor">
                                            @if(count($dischargeSummarymodified) <=  0)  

                                                @if($daycaresheetscount != 0)

                                                    @if ( $result->Intubation == 'No' && $InvasiveVentilation != 'Yes')
                                                        {{ $sex}} did not require ventilator support during the neonatal stay.
                                                    @elseif ( $result->Intubation == 'Yes' && $InvasiveVentilation == 'Yes')
                                                        {{ $sex}} required ventilator support.
                                                    @elseif ( $result->Intubation == 'No' && $InvasiveVentilation == 'Yes')
                                                        {{ $sex}} did not require intubation at birth but required invasive ventilation
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
                                                        {{ $sex}} required {{ $InvasiveVentilationType }} during ICU stay.

                                                    @endif


                                                    @if(!empty(trim($NonInvasiveVentilationType)) && !is_null($NonInvasiveVentilationType) && $NonInvasiveVentilationType!='NULL')
                                                        {{ $sex}} required {{ $NonInvasiveVentilationType }} during ICU stay.

                                                    @endif

                                                    @if(!empty($OtherRespiratorySupport))
                                                        {{ $OtherRespiratorySupport }} therapy was provided.

                                                    @endif

                                                    @if(!empty($WithoutVentilation))
                                                        The baby did not require any respiratory support after admission to the Neonatal
                                                        unit.

                                                    @endif
                                  
                                                    <br/>
                                                    <table style="width:auto; margin-top:10px;">
                                                        <tr>
                                                            <td>Invasive Ventilation</td>
                                                            <td>{{ $InvasiveVentilationCount }} days</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Non Invasive Ventilation</td>
                                                            <td>{{ $NonInvasiveVentilationCount }} days</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Other Respiratory Support</td>
                                                            <td>{{ $OtherRespiratorySupportCount }} days</td>
                                                        </tr>
                                                    </table>


                                                    @if ( $result->SurfactantGiven == 'Yes')
                                                        {{ $sex}} received surfactant therapy.
                                                    @else
                                                        {{ $sex}} did not receive surfactant therapy.

                                                    @endif

                                                    @if(!empty($NeedleThoracocentesis))
                                                        {{ $sex }} required needle thoracocentesis.
                                                    @endif

                                                    @if(!empty($intercostalDrain))
                                                      {{ $sex }} required insertion of an intercostal drain.
                                                    @endif

                                                    @if(!empty(trim($maxFiO2)) && $maxFiO2 != 0)
                                                        {{ $passsex}}  maximum oxygen requirment after admission to the Neonatal unit
                                                        was {{ $maxFiO2 }}%.
                                                    @endif    

                                                    @if(!empty($maxPIP))
                                                    {{ $sex}} required a maximum peak inspiratory pressure of  {{ $maxPIP }} cm H2O.
                                                    @endif

                                                    @if(!empty(trim($maxOI)) && $maxOI != 0)
                                                     {{ $passsex}} maximum oxygenation index was  {{ $maxOI }}.
                                                    @endif

                                                    @if(!empty(trim($Indication)))

                                                      {{ $sex}} required assisted respiratory support after admission to the neonatal unit due to  {{ $Indication }}
                                                  
                                                    @endif

                                                    @if(!empty($chronicLung))
                     
                                                       {{ $sex}} was diagnosed with chronic lung disease. 

                                                    @endif

                                                    @if($result->HomeOxygen == 'No' && $result->Discharge_status !='Died' && $result->Discharge_status !='Died (OCNR)')
                                                        {{ $sex}} was spontaneously breathing in air with good saturation at the time of
                                                        discharge.
                                                    @elseif($result->HomeOxygen == 'Yes' && $result->Discharge_status !='Died' && $result->Discharge_status !='Died (OCNR)')
                                                        {{ $sex}} is discharged on home oxygen.
                                                    @endif

                                                    {{ $result->RespiratorySystemExtra }}
                                                @endif    
                                            @else
                                                {!! $dischargeSummarymodified['RespiratorySystem'] !!}
                                            @endif    
                                        </div>
                                    </td>
                                </tr>
                                <tr class="page-break-always" style="margin-top: : 100px !important;"></tr>
                                <tr>                            
                                    <td colspan="2" style="text-align:justify ;">
                                        {!! Form::hidden('CardiovascularSystem') !!}
                                        <br/>
                                        <b>Cardiovascular System:</b>
                                        <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="float: right; cursor: pointer;" title="Edit">
                                            <i class="fa fa-pencil-square-o cardiovascularsystem-report-editing" aria-hidden="true"></i>
                                        </a>
                                        <br/>
                                        <div class="cardiovascularsystem-report-editor">
                                            @if(count($dischargeSummarymodified) <=  0)  
                                                @if($daycaresheetscount != 0)
                                                    {!! $CardiovascularSystem !!}
                                                @endif 
                                            @else
                                                {!! $dischargeSummarymodified['CardiovascularSystem'] !!}
                                            @endif   
                                        </div>   
                                    </td>
                                </tr>
                                <tr class="page-break"></tr>
                                <tr>
                                    <td colspan="2" style="text-align:justify ;">
                                        {!! Form::hidden('GastrointestinalSystem') !!}
                                        <br/>
                                        <b>Gastrointestinal System:</b>
                                        <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="float: right; cursor: pointer;" title="Edit">
                                            <i class="fa fa-pencil-square-o gastrointestinalsystem-report-editing" aria-hidden="true"></i>
                                        </a>
                                        <br/>
                                        <div class="gastrointestinalsystem-report-editor">
                                            @if(count($dischargeSummarymodified) <=  0)  
                                                @if($daycaresheetscount != 0)
                                                    {{ $GastrointestinalSystem }}
                                                @endif 

                                                @if(!empty($UltrasoundAbdominal))
                                                    <br/>
                                                        The baby underwent a abdominal ultrasound scan and key findings are given below
                                                    <br/>
                                                    <table>    
                                                        <tr><th>Date</th><th>Findings</th></tr>
                                                        @foreach($UltrasoundAbdominalkeys as $temp_findings)
                                                            <tr><td>{{ $temp_findings['Dateofultrasound'] }}</td><td>{{ empty($temp_findings['abdominalultrasoundkeyfindings']) ? 'N/A' : $temp_findings['abdominalultrasoundkeyfindings'] }}</td></tr>
                                                        @endforeach
                                                    </table>

                                                @endif   
                                            @else
                                                {!! $dischargeSummarymodified['GastrointestinalSystem'] !!}
                                            @endif  
                                        </div>   
                                    </td>
                                </tr>
                                <tr class="page-break"></tr>
                                <tr>
                                    <td colspan="2" style="text-align:justify ;">
                                        {!! Form::hidden('CentralNervousSystem') !!}
                                        <br/>
                                        <b>Central Nervous System:</b>
                                        <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="float: right; cursor: pointer;" title="Edit">
                                            <i class="fa fa-pencil-square-o centralnervoussystem-report-editing" aria-hidden="true"></i>
                                        </a>
                                        <br/>
                                        <div class="centralnervoussystem-report-editor">
                                            @if(count($dischargeSummarymodified) <=  0)  
                                                @if($daycaresheetscount != 0)
                                                    {!! $CentralNervousSystem !!}
                                                @endif   
                                            @else
                                                {!! $dischargeSummarymodified['CentralNervousSystem'] !!}
                                            @endif  
                                        </div> 
                                    </td>
                                </tr>
                                <tr class="page-break"></tr>
                                <tr>
                                    <td colspan="2" style="text-align:justify ;">
                                        {!! Form::hidden('Sepsis') !!}
                                        <br/>
                                        <b>Sepsis:</b>
                                        <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="float: right; cursor: pointer;" title="Edit">
                                            <i class="fa fa-pencil-square-o sepsis-report-editing" aria-hidden="true"></i>
                                        </a>
                                        <br/>
                                        <div class="sepsis-report-editor">
                                            @if(count($dischargeSummarymodified) <=  0)  
                                                @if($daycaresheetscount != 0)
                                                    {!! $Sepsis !!}
                                                @endif 
                                            @else
                                                {!! $dischargeSummarymodified['Sepsis'] !!}
                                            @endif  
                                        </div> 
                                    </td>
                                </tr>
                                <tr class="page-break"></tr>
                                <tr>
                                    <td colspan="2" style="text-align:justify ;">
                                        {!! Form::hidden('Ophthalmology') !!}
                                        <br/>
                                        <b>Ophthalmology:</b>
                                        <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="float: right; cursor: pointer;" title="Edit">
                                            <i class="fa fa-pencil-square-o ophthalmology-report-editing" aria-hidden="true"></i>
                                        </a>
                                        <br/>
                                        <div class="ophthalmology-report-editor">
                                            @if(count($dischargeSummarymodified) <=  0)  
                                                @if($daycaresheetscount != 0)
                                                {!! $Ophthalmology !!}
                                                @endif 
                                            @else
                                                {!! $dischargeSummarymodified['Ophthalmology'] !!}
                                            @endif
                                        </div> 
                                    </td>
                                </tr>
                                <tr class="page-break"></tr>
                                <tr>
                                    <td colspan="2" style="text-align:justify ;">
                                        {!! Form::hidden('Hematology') !!}
                                        <br/>
                                        <b> Renal, Hematology, electrolytes, Glucose and Jaundice:</b>
                                        <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="float: right; cursor: pointer;" title="Edit">
                                            <i class="fa fa-pencil-square-o hematology-report-editing" aria-hidden="true"></i>
                                        </a>
                                        <br/>
                                        <div class="hematology-report-editor">
                                            @if(count($dischargeSummarymodified) <=  0)  
                                                @if($daycaresheetscount != 0)
                                                    {!! $Hematology !!}
                                                    @if(count($Hypoglycemia) != 0)
                                                        {{ $sex}} developed the following electrolyte abnormalities, which were managed
                                                        effectively as per our unit guidelines
                                                        <ul>
                                                            @foreach ($Hypoglycemia as $key => $value)
                                                                <li>{{ $value }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                    {{ $InsulinTherapytext }}
                                                    @if(count($NNJTreatments) != 0)
                                                        {{ $sex }} received the following treatment for neonatal jaundice
                                                        <ul>
                                                            @foreach ($NNJTreatments as $key => $value)
                                                                <li>{{ $value }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                    {{ $Hematologytext }}
                                                    @if(!empty($RenalUltrasound))
                                                        The baby underwent a renal ultrasound scan and key findings are below 
                                                        <table>
                                                            <tr><th>Date</th><th>Findings</th></tr>  
                                                            <tr>
                                                                @foreach($RenalUltrasoundkeys as $RenalUltrasoundfindings)
                                                                    <td>{{ $RenalUltrasoundfindings['Dateofultrasound'] }}</td><td> {{ empty($RenalUltrasoundfindings['renalultrasoundkeyfindings']) ? 'N/A' : $RenalUltrasoundfindings['renalultrasoundkeyfindings']   }}</td>
                                                                @endforeach 
                                                            </tr>
                                                        </table>  
                                                    @endif
                                                @endif   
                                            @else
                                                {!! $dischargeSummarymodified['Hematology'] !!}
                                            @endif
                                        </div>  
                                    </td>
                                </tr>
                                <tr class="page-break"></tr>
                                <tr>
                                    <td colspan="2" style="text-align:justify ;">
                                        {!! Form::hidden('NewbornScreening') !!}
                                        <br/>
                                        <b>Newborn Screening:</b>
                                        <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="float: right; cursor: pointer;" title="Edit">
                                            <i class="fa fa-pencil-square-o newbornscreening-report-editing" aria-hidden="true"></i>
                                        </a>
                                        <br/>
                                        <div class="newbornscreening-report-editor">
                                            @if(count($dischargeSummarymodified) <=  0)  
                                                @if($daycaresheetscount != 0)
                                                    {{ $NewbornScreening }}
                                                @endif  
                                            @else
                                                {!! $dischargeSummarymodified['NewbornScreening'] !!}
                                            @endif    
                                        </div>
                                    </td>
                                </tr>
                                <tr class="page-break"></tr>
                                <tr>
                                    <td colspan="2" style="text-align:justify ;">
                                        {!! Form::hidden('Communicationwithparents') !!}
                                        <br/>
                                        <b>Communication with parents:</b>
                                        <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="float: right; cursor: pointer;" title="Edit">
                                            <i class="fa fa-pencil-square-o communicationwithparents-report-editing" aria-hidden="true"></i>
                                        </a>
                                        <br/>
                                        <div class="communicationwithparents-report-editor">
                                            @if(count($dischargeSummarymodified) <=  0)  
                                                @if($daycaresheetscount != 0)
                                                    Parents were fully updated regarding {{ strtolower($passsex)}} daily progress in the
                                                    neonatal unit and they were provided with sufficient opportunities to clarify their
                                                    questions.<br/>
                                                    {{ $Communicationwithparents }}
                                                @endif  
                                            @else
                                                {!! $dischargeSummarymodified['Communicationwithparents'] !!}
                                            @endif     
                                        </div> 
                                    </td>
                                </tr>
                                @if(!empty($result->DischargeHb) ||  !empty($result->DischargePCV) || !empty($result->DischargeTSB) || !empty($result->DischargeSerumCa) || !empty($result->DischargeSerumPo4) || !empty($result->DischargeSerumALP) || !empty($result->DischargeSerumNa))
                                    <tr class="page-break"></tr>
                                    <tr>
                                        <td colspan="2" style="text-align:justify ;">
                                            {!! Form::hidden('Investigations') !!}
                                            <br/>
                                            <b>Investigations:</b>
                                            <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="float: right; cursor: pointer;" title="Edit">
                                                <i class="fa fa-pencil-square-o investigations-report-editing" aria-hidden="true"></i>
                                            </a>                               
                                            <br/>
                                            <div class="investigations-report-editor col-md-12">
                                                @if(count($dischargeSummarymodified) <=  0)  
                                                    @if($daycaresheetscount != 0)
                                                        {{ $passsex }} latest blood investigations showed the following results 
                                                        <ul>
                                                            @if(!empty($result->DischargeHb))
                                                                <li>Hemoglobin (g/dl) : {{ $result->DischargeHb }}</li>
                                                            @endif

                                                            @if(!empty($result->DischargePCV))
                                                                <li>Hematocrit (PCV) (%) : {{ $result->DischargePCV }}</li>
                                                            @endif

                                                            @if(!empty($result->DischargeTSB))
                                                                <li>Total Serum Bilirubin (mg/dl) : {{ $result->DischargeTSB }}</li>
                                                            @endif

                                                            @if(!empty($result->DischargeSerumCa))
                                                                <li>Calcium (mg/dl) : {{ $result->DischargeSerumCa }}</li>
                                                            @endif 

                                                            @if(!empty($result->DischargeSerumPo4))
                                                                <li>Phosphate (mg/dl) : {{ $result->DischargeSerumPo4 }}</li>
                                                            @endif

                                                            @if(!empty($result->DischargeSerumALP))
                                                                <li>Alkaline Phosphatase (IU/L) : {{ $result->DischargeSerumALP }}</li>
                                                            @endif

                                                            @if(!empty($result->DischargeSerumNa))
                                                                <li>Sodium (mmol/L) : {{ $result->DischargeSerumNa }}</li>
                                                            @endif
                                                        </ul>
                                                        {{ $Investigations }}
                                                    @endif  
                                                @else
                                                    {!! $dischargeSummarymodified['Investigations'] !!}
                                                @endif    
                                            </div>  
                                        </td>
                                    </tr>
                                @endif 
                                @if($result->Discharge_status!='Died' && $result->Discharge_status!='Died (OCNR)')
                                    <tr class="page-break"></tr>
                                    <tr>
                                        <td colspan="2">
                                            {!! Form::hidden('DischargeMedications') !!}
                                            <br/>
                                            <b>Discharge Medications:</b>
                                            <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="float: right; cursor: pointer;" title="Edit">
                                                <i class="fa fa-pencil-square-o dischargemedications-report-editing" aria-hidden="true"></i>
                                            </a>
                                            <br/>
                                            <div class="dischargemedications-report-editor">
                                                @if(count($dischargeSummarymodified) <=  0)  
                                                    <table class="table col-md-12" style="margin-bottom: 20px;">
                                                        <tr>
                                                            <td>DRUG</td>
                                                            <td>DOSE</td>
                                                            <td>FREQUENCY</td>
                                                            <td>DURATION</td>
                                                        </tr>
                                                        @if(count($discharge_medications) > 0 )
                                                            @if($daycaresheetscount != 0)
                                                                @foreach($discharge_medications as $key =>  $value)
                                                                    <tr>
                                                                        <td>{{ $value->Name }}</td>
                                                                        <td>{{ $value->Dose }}</td>
                                                                        <td>{{ $value->Frequency }}</td>
                                                                        <td>{{ $value->Duration }}</td>
                                                                    </tr>                                                                
                                                                @endforeach
                                                            @endif 
                                                        @else
                                                            <tr>
                                                                <td colspan="4" style="text-align: center;">None Prescribed</td>
                                                            </tr>
                                                        @endif
                                                    </table>
                                                    {{ $Investigations }}
                                                @else
                                                    {!! $dischargeSummarymodified['DischargeMedications'] !!}
                                                @endif   
                                            </div>   
                                        </td>
                                    </tr>
                                    <tr class="page-break"></tr>
                                    <tr>
                                        <td colspan="2">
                                            {!! Form::hidden('vaccine') !!}
                                            <br/>
                                            <b>Vaccine:</b>
                                            <a href="javascript:void(0);" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="float: right; cursor: pointer;" title="Edit">
                                                <i class="fa fa-pencil-square-o vaccine-report-editing" aria-hidden="true"></i> 
                                            </a>
                                            <br/>
                                            <div class="vaccine-report-editor">
                                                @if(count($dischargeSummarymodified) <=  0)  
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($vaccinelist as $vaccinename)
                                                                <tr>
                                                                    <td>{{ $vaccinename['vaccineName'] }}</td>
                                                                    <td>{{ $vaccinename['vaccineDate'] }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @else
                                                    {!! $dischargeSummarymodified['vaccine'] !!}    
                                                @endif    
                                            </div> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            {!! Form::hidden('DischargeInstructions') !!}
                                            <br/>
                                            <b>Discharge Instructions:</b>
                                            <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="float: right; cursor: pointer;" title="Edit">
                                                <i class="fa fa-pencil-square-o dischargeinstructions-report-editing" aria-hidden="true"></i>
                                            </a>
                                            <br/>
                                            <div class="dischargeinstructions-report-editor">
                                                @if(count($dischargeSummarymodified) <=  0)  
                                                    @if($daycaresheetscount != 0)
                                                       {!! $headerContent['discharge_instraction'] !!}
                                                    @endif 
                                                        {!! $headerContent['discharge_summary_footer'] !!} 
                                                @else
                                                    {!! $dischargeSummarymodified['DischargeInstructions'] !!}
                                                    <div>                                   
                                                    </div>  
                                                @endif     
                                            </div>                            
                                        </td>
                                    </tr>
                                    <tr class="page-break"></tr>
                                    <tr>
                                        <td colspan="2">
                                            {!! Form::hidden('Followup') !!}
                                            <br/>
                                            <b>Follow Up:</b>
                                            <a href="javascript:" class="checkingtest hidden-print {!! $dischargeEditpermission !!}" style="float: right; cursor: pointer;" title="Edit">
                                                <i class="fa fa-pencil-square-o followup-report-editing" aria-hidden="true"></i>
                                            </a>
                                            <br/>
                                            <div class="followup-report-editor">
                                                @if(count($dischargeSummarymodified) <=  0)  
                                                    @if($daycaresheetscount != 0)
                                                        @if( date('Y', strtotime($result->NextAppointment)) <= 1970 || $result->NextAppointment == '0000-00-00' )
                                                            A neonatal follow up has not been arranged with us and we recommend local Paediatric
                                                            follow up.
                                                        @else
                                                            A neonatal outpatient appointment has been made
                                                            on {{ date('d-m-Y', strtotime($result->NextAppointment)) }}
                                                            at {{ $result->NAT_TIME }} :
                                                            @if(strlen($result->NAT_MINS) == 1)
                                                                0{{ $result->NAT_MINS }} @else {{ $result->NAT_MINS }} @endif
                                                                {{ $result->NAT_AM }}
                                                            @endif
                                                            {{ $Followup }}
                                                        @endif  
                                                @else
                                                    {!! $dischargeSummarymodified['Followup'] !!}
                                                @endif    
                                            </div>  
                                        </td>
                                    </tr>
                                @endif
                                @if (!isset($docs))
                                    <tr class="hidden-print {!! $dischargeEditpermission !!}">
                                        <td colspan="2"> 
                                            <table>
                                                <tr>
                                                    <td>{!! Form::label('is_completed','Is Summary Completed ? ') !!}</td>  
                                                    <td><input id="is_completed" name="is_completed" data-on="Completed" data-off="Not Completed" data-toggle="toggle" data-width="150" data-size="small"  type="checkbox"></td>
                                                </tr>                          
                                            </table>                            
                                        </td> 
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="2">
                                        <div style="margin: 45px 0px 0px -33px;">
                                            <div class="pull-left"> 
                                                <ul class="list-none">
                                                    <li>Date : {{ $result->DischargeDate }} </li>
                                                    <li>Place :  </li>
                                                </ul>
                                            </div>
                                            @php $s = 1; $ms_doctors = explode(',',$result->neonatal_consultant);    @endphp
                                            @foreach($ms_doctors as $doctors)  
                                                @if($s <= 3)
                                                    <div class="pull-right" style="display: inline-block; width: 200px;">
                                                        <ul class="list-none" style="text-align: center; ">
                                                            <li> {{ $doctors }} </li>
                                                            <li><b>Signature</b></li>
                                                        </ul>
                                                    </div>
                                                @endif 
                                                @php $s++; @endphp
                                            @endforeach   
                                        </div>
                                    </td> 
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @if (!isset($docs))
                    <div class="button-row hidden-print">
                        <div class="col-md-2 col-sm-2 col-xs-3 pb-15">
                            <a href="javascript:void(0);" onclick="window.print();" class="btn btn-primary hidden-print">
                            <i class="fa fa-print"></i><span>{{ Lang::get('basic.print') }}</span></a>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-3 savebtn hide pb-15">
                            <a href="javascript:void(0);" class="btn btn-primary hidden-print neonatal-intensive-care-save {{ $dischargeEditpermission }}">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i><span>{{ Lang::get('basic.save') }}</span></a>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-3 pb-15 {{ $dischargeEditpermission }} @if(count($dischargeSummarymodified) > 0 && $dischargeSummarymodified['status']==0) hide @elseif(count($dischargeSummarymodified)<=0) hide @endif" >
                            <a href="javascript:void(0);" class="btn btn-primary hidden-print neonatal-intensive-care-default">
                            <i class="fa fa-undo" aria-hidden="true"></i><span>Default</span></a>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-3 pb-15">
                            <a href="javascript:window.history.back(-1);" class="btn btn-default hidden-print">
                            <i class="fa fa-exclamation-circle"></i><span>Back</span></a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    {!! Form::close() !!}
@endsection
@section('scripts')

<script type="text/javascript">



  @if(isset($dischargeSummarymodified['is_completed']) &&$dischargeSummarymodified['is_completed'] == 2)
      $('#is_completed').bootstrapToggle('on');
  @endif

 $('.neonatal-intensive-care-save').click(function(){

   if(checkActiveeditor()){

            bootbox.confirm("Are you sure want save changes ?",function(confirmed){
                  if(confirmed){
                        
                        $('form').submit();

                       // $.ajax({
                       //          type    :"POST",
                       //          url     : "{{ url('nicu-discharge-reports') }}",
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
                  }
              });
       
   }else{
        Showalert('warning','Please close editor before save !');
   }     
   

});
$('.neonatal-intensive-care-default').click(function(){

     var babyId=$('input[name="BabyId"]').val();

     bootbox.confirm(" Are you sure want go for Default ?",function(confirmed){

              if(confirmed){

                    $.ajax({
                          type    :"GET",
                          url     : '{{ url("nicu-discharge-remove") }}',
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
    var requestUrl = "{{ url('nicu-abbrivated-summary/'.Request::segment(2)) }}";

      $.ajax({
               type:"GET",
               url:'{{ url("nicu-discharge-reports-editors") }}',
               data:{dataUrl:requestUrl},
               cache:false,
               dataType: "json",
               success:function(responseText){
                   window.location = requestUrl;
               },
               error:function(response){

               }

     });

 });


</script>

@endsection




