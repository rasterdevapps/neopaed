@extends('print')
@section('content')
@php  $public_url =url('public').'/'; @endphp
@php  $mas_nont_antibio = ValuelistHelpers::getDrugIvFluidsNonAntibiotic(); @endphp

@if (isset($editor_gen) && $editor_gen)
<div class="editor_style">
@include('editor_print')  
</div>
@endif

<style type="text/css">
ol {
  counter-reset: LIST-ITEMS 0;
}
li {
  display: inline;
  padding-right: 0.5em;
}
li:before {
  content: counter( LIST-ITEMS ) ".";
  counter-increment: LIST-ITEMS;
  padding-right: 0.25em;
}
</style>
<div class="temp-container daycare">
    <div class="temp-row">
        <div class="col-md-12">
                <img src="{{ SiteHelpers::getNicuLogo($nicu_id) }}">
        </div>
        <div class="col-md-12 mt-10">
                <h3 class="print-head mt-0">DAY CARE SHEET </h3>
        </div>
      {{ Form::hidden('DayId', $results->DayId) }}
        <div class="col-md-12">
            <div class="content-block mt-must-0">
                <h4>Basic Details</h4>
                <div class="section-set">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">                 
                            <span class="print-label">{{ Lang::get('home.mrn') }}:</span>
                            <span class="print-value"> {!! $results->BMrNo; !!}</span>                 
                        </div>
                        <div class="form-group">                 
                            <span class="print-label">{{ Lang::get('home.ip') }}:</span>
                            <span class="print-value"> {!! $ip_number; !!}</span>                 
                        </div>
                        <div class="form-group">                 
                            <span class="print-label">Name:</span>
                            <span class="print-value">{!! $results->BabyName; !!}</span>                 
                        </div>
                        <div class="form-group">                 
                            <span class="print-label">DOB:</span>
                            <span class="print-value">{!! date("d-m-Y",strtotime($results->DOB)) !!}</span>               
                        </div>
                    </div>
                </div>
                <div class="section-set">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">                 
                            <span class="print-label">Care:</span>
                            <span class="print-value">{!! $results->Care !!} </span>                  
                        </div>
                        <div class="form-group">
                            <span class="print-label">Gestation:</span>
                            <span class="print-value">{!! $results->Gestation; !!}</span>
                        </div>
                        <div class="form-group">                 
                            <span class="print-label">Day of life:</span>
                            <span class="print-value"> {!! $results->DayOfLife; !!}</span>                
                        </div>
                        <div class="form-group">                
                            <span class="print-label">Baby\'s BG:</span>
                            <span class="print-value">{!! $results->BabyBloodGroup; !!}</span>                 
                        </div>
                    </div>
                </div>
                <div class="section-set">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">        
                            @php  $results->DayTime=(strlen($results->DayTime)==1)? '0'.$results->DayTime:$results->DayTime;@endphp
                            @php  $results->DayTime_MINS=(strlen($results->DayTime_MINS)==1)? '0'.$results->DayTime_MINS:$results->DayTime_MINS; @endphp
                            <span class="print-label">Date:</span>
                            <span class="print-value">{!! date("d-m-Y",strtotime($results->DayDate)); !!} {!! $results->DayTime.':'.$results->DayTime_MINS.':'.$results->DayTime_AM !!}</span>                 
                        </div>
                        <div class="form-group">                
                            <span class="print-label">CGA:</span>
                            <span class="print-value">{!! $results->CGA; !!}</span>                 
                        </div>
                        <div class="form-group">                 
                            <span class="print-label">Sex:</span>
                            <span class="print-value"> {!! $results->Sex; !!}</span>                 
                        </div>
                        <div class="form-group">                  
                            <span class="print-label">Mother BG:</span>
                            <span class="print-value">  {!! $Mother_details->MotherBloodGroup !!}</span>                 
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group mtb-must-0">
                        <span class="print-label">Background:</span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 ml-10">
                    <div class="form-group mtb-must-0">
                        <span class="print-value full-width-must">{!! $results->Background; !!}</span>
                    </div>
                </div>
            </div>
            @if(!empty($results->CurrentProblems) || !empty($results->PreviousProblems))
            <div class="content-block">
                <h4>Problems</h4>
                @if(!empty($results->CurrentProblems))
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group mtb-must-0">
                        <span class="print-label full-width-must">Current Problems:</span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 ml-10">
                    <div class="form-group mtb-must-0">
                        <span class="print-value full-width-must">{!! str_replace('||', ', ', $results->CurrentProblems); !!}</span>
                    </div>
                </div>
                @endif
                @if(!empty($results->PreviousProblems))
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group mtb-must-0">
                        <span class="print-label full-width-must">Previous Problems:</span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 ml-10">
                    <div class="form-group mtb-must-0">
                        <span class=" print-value full-width-must">{!! str_replace('||', ', ', $results->PreviousProblems); !!}</span>
                    </div>
                </div>
                @endif
            </div>
            @endif
            <!-- <div class="page-break"></div> -->
            <div class="content-block custom-print">
                <h4>Respiratory System</h4>
                <div class="print-block">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <div>
                                <span class="print-label">Mode of Ventilation:</span>
                                <span class="print-value">
                                    @if($results->InvasiveVentilation=='Yes')
                                    {!! $results->ModeOfVentilation; !!}
                                    @elseif($results->InvasiveVentilation=='No' && !empty($results->Ventilation_choose))
                                    @if($results->Ventilation_choose=='NonInvasiveVentilation')
                                    {!! $results->NonInvasiveVentilation; !!}
                                    @elseif($results->Ventilation_choose=='OtherRespiratorySupport')
                                    {!! $results->OtherRespiratorySupport; !!}
                                    @elseif($results->Ventilation_choose=='Spontaneouslyventilating')
                                    {!! ($results->Spontaneouslyventilating=='Yes')? 'Spontaneously ': ''; !!}
                                    @endif
                                    @endif
                                </span>
                            </div>
                        </div>
                        @if(isset($results->Indication) && !empty($results->Indication) && is_array($results->Indication))
                        <div class="form-group">
                            <div>
                                <span class="print-label">Indication:</span>
                                <span class="print-value">
                                    @php  $i=1; $lenofarray=count($results->Indication); @endphp
                                    @foreach($results->Indication as $indication_value)
                                    @if($lenofarray==$i)
                                    {!! $Mastersrespirtory[$indication_value]; !!}
                                    @else
                                    {!! $Mastersrespirtory[$indication_value].','; !!}
                                    @endif
                                    @php  $i++; @endphp
                                    @endforeach
                                </span>
                            </div>
                        </div>
                        @endif             
                        <div class="form-group">
                            <div>
                                <span class="print-label">IT in sec:</span>
                                <span class="print-value">{!! $results->IT; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">FiO2:</span>
                                <span class="print-value">{!! isset($results->FiO2) ? $results->FiO2 : '' !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">Size in cm:</span>
                                <span class="print-value">{!! $results->Size; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">Cm at lips:</span>
                                <span class="print-value">{!! $results->Lips; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">Set RR:</span>
                                <span class="print-value">{!! $results->Rate; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">ET Tube:</span>
                                <span class="print-value">{!! $results->EtTube; !!}</span>
                            </div>
                        </div>
                        @if($results->EtTube=='Yes')
                        @endif
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <div>
                                <span class="print-label">PIP:</span>
                                <span class="print-value">{!! isset($results->PIP) ? $results->PIP : '' !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">PEEP:</span>
                                <span class="print-value">{!! $results->PEEP; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">MAP:</span>
                                <span class="print-value">{!! $results->MAP; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">Baby's RR:</span>
                                <span class="print-value">{!! $results->RR; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">Retractions:</span>
                                <span class="print-value">{!! $results->Retractions; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">Airentry:</span>
                                <span class="print-value">{!! $results->AirEntry; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">Chest Movement:</span>
                                <span class="print-value">{!! $results->ChestMovement; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">Added Sounds:</span>
                                <span class="print-value">{!! $results->AddedSounds; !!}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <div>
                                <span class="print-label">Character:</span>
                                <span class="print-value">{!! $results->DayCharacter; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">SaO2 Postductal:</span>
                                <span class="print-value">{!! $results->SaO2PostDuctal; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">Lactate:</span>
                                <span class="print-value"> {!! $results->Lactate; !!}</span>
                            </div>
                        </div>
                        @if(!empty($results->PaO2) && !empty($results->PaCo2))
                        <div class="form-group">
                            <div>
                                <span class="print-label">AaDO2:</span>
                                <span class="print-value">{!! $results->AaDO2; !!}</span>
                            </div>
                        </div>
                        @endif
                        @if(!empty($results->MAP) && !empty($results->FiO2) && !empty($results->PaO2))
                        <div class="form-group">
                            <div>
                                <span class="print-label">OI:</span>
                                <span class="print-value">{!! $results->OI; !!}</span>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <div>
                                <span class="print-label">ABG at:</span>
                                <span class="print-value">{!! $results->LastBG; !!}</span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="print-block">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <div>
                                <span class="print-label">Blood Gas:</span>
                                <span class="print-value">{!! $results->TypeOfBloodGas; !!}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    @if($results->TypeOfBloodGas!='Not done' && $results->TypeOfBloodGas!='Not indicated')
                    <div class="form-group">
                        <div>
                            <span class="print-label">pH:</span>
                            <span class="print-value">{!! $results->Ph; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">paO2:</span>
                            <span class="print-value"> {!! $results->PaO2; !!}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group">
                        <div>
                            <span class="print-label">paCO2:</span>
                            <span class="print-value">{!! $results->PaCo2; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">HCO3:</span>
                            <span class="print-value"> {!! $results->HCO3; !!}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group">
                        <div>
                            <span class="print-label">BE:</span>
                            <span class="print-value">{!! $results->BE; !!}</span>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    @if(!empty($results->RSFindings))
                    <div class="form-group">
                        <div>
                            <span class="print-label">Other RS findings:</span>
                            <span class="print-value">{!! $results->RSFindings; !!}</span>
                        </div>
                    </div>
                    @endif
                    @if(!empty($results->CXRFindings))
                    <div class="form-group">
                        <div>
                            <span class="print-label">CXR Findings:</span>
                            <span class="print-value">{!! $results->CXRFindings; !!}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="content-block custom-print">
                <h4>Cardiovascular System</h4>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="form-group">
                        <div>
                            <span class="print-label">HR:</span>
                            <span class="print-value">{!! $results->HR; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Systolic BP:</span>
                            <span class="print-value">{!! $results->systolic_bp; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Diastolic BP:</span>
                            <span class="print-value">{!! $results->diastolic_bp; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Mean BP:</span>
                            <span class="print-value">{!! $results->MeanBP; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Pulse Pressure:</span>
                            <span class="print-value">{!! $results->PulsePressure; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Central Pulses:</span>
                            <span class="print-value">{!! $results->CentralPulses; !!}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="form-group">
                        <div>
                            <span class="print-label">Peripheral Pulses:</span>
                            <span class="print-value">{!! $results->PeripheralPulses; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Femoral Pulses:</span>
                            <span class="print-value">{!! $results->FemoralPulses; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">CFT:</span>
                            <span class="print-value">{!! $results->CFT; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Central Temperature:</span>
                            <span class="print-value">{!! $results->CentralTemperature; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Peripheral Temperature:</span>
                            <span class="print-value">{!! $results->PeripheralTemperature; !!}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="form-group">
                        <div>
                            <span class="print-label">Color:</span>
                            <span class="print-value">{!! $results->Color; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Precordial Activity:</span>
                            <span class="print-value">{!! $results->PrecordialActivity; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">S1 S2:</span>
                            <span class="print-value">{!! $results->S1S2; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Murmur:</span>
                            <span class="print-value">{!! $results->Murmur; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Character Of Murmur:</span>
                            <span class="print-value">{!! $results->CharacterOfMurmur; !!}</span>
                        </div>
                    </div>
                </div>
                <div class="clearfix">  </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="form-group">
                        <div>
                            <span class="print-label">Inotropes:</span>
                            <span class="print-value">{!! $results->Inotropes; !!}</span>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    @if($results->Inotropes=='Yes')
                    <div class="form-group">
                        <div>
                            <span class="print-label">Dopamine (mcg/kg/min):</span>
                            <span class="print-value">{!! $results->Dopamine; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Dobutamine (mcg/kg/min):</span>
                            <span class="print-value">{!! $results->Dobutamine; !!}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="form-group">
                        <div>
                            <span class="print-label">Adrenaline (ng/kg/min):</span>
                            <span class="print-value">{!! $results->Adrenaline; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label"> Nor adrenaline (ng/kg/min):</span>
                            <span class="print-value">{!! $results->Noradrenaline; !!}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="form-group">
                        <div>
                            <span class="print-label">Milrinone (mcg/kg/hour):</span>
                            <span class="print-value">{!! $results->Milrinone; !!}</span>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    @if(!empty($results->CVSFindings))
                    <div class="form-group">
                        <div>
                            <span class="print-label">Other CVS findings:</span>
                            <span class="print-value">{!! $results->CVSFindings; !!}</span>
                        </div>
                    </div>
                    @endif
                    @if(!empty($results->DayEcho))
                    <div class="form-group">
                        <div>
                            <span class="print-label ">ECHO:</span>
                            <span class="print-value">{!! $results->DayEcho; !!}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="page-break"></div>
            <div class="content-block custom-print">
                <h4>GI System</h4>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="form-group">
                        <div>
                            <span class="print-label">Feeds (ml/kg/d):</span>
                            <span class="print-value"> {!! $results->Feeds; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Volume:</span>
                            <span class="print-value"> {!! $results->Volume; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Frequency:</span>
                            <span class="print-value"> {!! $results->Frequency; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">TPN(ml/kg/d):</span>
                            <span class="print-value"> {!! $results->Tpn; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Abdominal Girth:</span>
                            <span class="print-value"> {!! $results->AbdominalGirth; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Aspirates:</span>
                            <span class="print-value"> {!! $results->AspirateVolume; !!}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="form-group">
                        <div>
                            <span class="print-label">Aspirate Nature:</span>
                            <span class="print-value"> {!! $results->AspirateNature; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Stool Nature:</span>
                            <span class="print-value"> {!! $results->StoolNature; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">IVF ml/kg/d:</span>
                            <span class="print-value"> {!! $results->Ivf; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Bowel Sounds:</span>
                            <span class="print-value"> {!! $results->BowelSounds; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Hepatomegaly:</span>
                            <span class="print-value"> {!! $results->Hepatomegaly; !!}</span>
                        </div>
                    </div>
                    @if($results->Hepatomegaly=='Yes')
                    <div class="form-group">
                        <div>
                            <span class="print-label">Liver Span:</span>
                            <span class="print-value"> {!! $results->LiverSpan; !!}</span>
                        </div>
                    </div>
                    @endif
                    <div class="form-group">
                        <div>
                            <span class="print-label">Splenomegaly:</span>
                            <span class="print-value"> {!! $results->Splenomegaly; !!}</span>
                        </div>
                    </div>
                    @if($results->Splenomegaly=='Yes')
                    <div class="form-group">
                        <div>
                            <span class="print-label">Spleen span:</span>
                            <span class="print-value"> {!! $results->SpleenSpan; !!}</span>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="form-group">
                        <div>
                            <span class="print-label">Umbilicus:</span>
                            <span class="print-value"> {!! $results->Umbilicus; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Herina:</span>
                            <span class="print-value"> {!! $results->Herina; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Genitalia:</span>
                            <span class="print-value"> {!! $results->Genitalia; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Maximum TSB (mg/dl):</span>
                            <span class="print-value"> {!! $results->TSB; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Stools:</span>
                            <span class="print-value"> {!! $results->Stools; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">NNJ Treatment:</span>
                            <span class="print-value"> {!! $results->NNJTreatment; !!}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="form-group">
                        <div>
                            <span class="print-label">AXR Findings:</span>
                            <span class="print-value">{!! $results->AxrFindings; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">Other findings:</span>
                            <span class="print-value">{!! $results->PAFindings; !!}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-break"></div>
            <div class="content-block custom-print">
                <h4>CNS</h4>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="form-group">
                        <div>
                            <span class="print-label">Anterior Fontanelle:</span>
                            <span class="print-value"> {!! $results->AnteriorFontanelle; !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">Activity:</span>
                                <span class="print-value"> {!! $results->Activity; !!}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                        <div class="form-group">
                            <div>
                                <span class="print-label">Tone:</span>
                                <span class="print-value"> {!! $results->Tone; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">Cry:</span>
                                <span class="print-value" > {!! $results->Cry; !!}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                        <div class="form-group">
                            <div>
                                <span class="print-label">Seizures:</span>
                                <span class="print-value"> {!! $results->Seizures; !!}</span>
                            </div>
                        </div>
                        @if($results->Seizures=='Yes')
                        <div class="form-group">
                            <div>
                                <span class="print-label">Type of Seizures:</span>
                                <span class="print-value "> {!! $results->TypeOfSeizures; !!}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                        @if(!empty($results->CnsFindings))
                        <div class="form-group">
                            <div>
                                <span class="print-label">Other CNS Findings:</span>
                                <span class="print-value"> {!! $results->CnsFindings; !!}</span>
                            </div>
                        </div>
                        @endif
                        @if(!empty($results->Cuss))
                        <div class="form-group">
                            <div>
                                <span class="print-label">CUSS:</span>
                                <span class="print-value"> {!! $results->Cuss; !!}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="page-break"></div>
                <div class="content-block custom-print">
                    <h4>Sepsis</h4>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                        @if(!empty($results->BloodCulture))
                        <div class="form-group">
                            <div>
                                <span class="print-label">Blood Culture:</span>
                                <span class="print-value"> {!! $results->BloodCulture; !!}</span>
                            </div>
                        </div>
                        @endif
                        @if(!empty($results->Sepsis))
                        <div class="form-group">
                            <div>
                                <span class="print-label">Sepsis:</span>
                                <span class="print-value"> {!! $results->Sepsis; !!}</span>
                            </div>
                        </div>
                        @endif
                        @if(!empty($results->TLC))
                        <div class="form-group">
                            <div>
                                <span class="print-label">TLC:</span>
                                <span class="print-value"> {!! $results->TLC; !!}</span>
                            </div>
                        </div>
                        @endif
                        @if(!empty($results->ANC))
                        <div class="form-group">
                            <div>
                                <span class="print-label">ANC:</span>
                                <span class="print-value"> {!! $results->ANC; !!}</span>
                            </div>
                        </div>
                        @endif
                        @if(!empty($results->Meningitis))
                        <div class="form-group">
                            <div>
                                <span class="print-label">Meningitis:</span>
                                <span class="print-value"> {!! $results->Meningitis; !!}</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if (isset($antibiotics) && count($antibiotics) > 0)
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                        @if(!empty($results->Organism) && @unserialize($results->Organism) !== false)
                        <div class="form-group">
                            <div>
                                <span class="print-label">Organism:</span>
                                <span class="print-value float-left">
                                    <ol class="margin-left-neg">
                                        @foreach (unserialize($results->Organism) as $value)
                                        <li>{!! $value !!}</li>
                                        @endforeach
                                    </ol>
                                </span>
                            </div>
                        </div>
                        @else
                        <div class="form-group">
                            <div>
                                <span class="print-label">Organism:</span>
                                <span class="print-value float-left">
                                    N/A
                                </span>
                            </div>
                        </div>                        
                        @endif
                        @if(!empty($results->PositiveBlood))
                        <div class="form-group">
                            <div>
                                <span class="print-label">Positive Blood Culture DOL:</span>
                                <span class="print-value"> {!! $results->PositiveBlood; !!}</span>
                            </div>
                        </div>
                        @endif
                        @if(!empty($results->Percentage))
                        <div class="form-group">
                            <div>
                                <span class="print-label">% N:</span>
                                <span class="print-value"> {!! $results->Percentage; !!}</span>
                            </div>
                        </div>
                        @endif
                        @if(!empty($results->Platelets))
                        <div class="form-group">
                            <div>
                                <span class="print-label">Platelets:</span>
                                <span class="print-value"> {!! $results->Platelets; !!}</span>
                            </div>
                        </div>
                        @endif
                        @if(!empty($results->CRP))
                        <div class="form-group">
                            <div>
                                <span class="print-label">CRP:</span>
                                <span class="print-value"> {!! $results->CRP; !!}</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    @php  $mas_antibio = ValuelistHelpers::getDrugIvFluidsAntibiotic(); @endphp
                    <table class="antibiotic col-xs-12 col-sm-6 col-md-4 col-lg-4">
                        <thead>
                            <tr>
                                <th><b>Antibiotic</b></th>
                                <th><b>Day</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($antibiotics as $data)
                            @if(isset($mas_antibio[$data['Antibiotic']]))
                            <tr>
                                <td>{!! $mas_antibio[$data['Antibiotic']]; !!}</td>
                                <td>{!! $data['Day']; !!}</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    @if (isset($drugs) && is_array($drugs) && count($drugs) > 0)
                    <div class="clearfix"></div>
                    <table class="sep_drugs col-xs-6 col-sm-6 col-md-4 col-lg-4">
                        <thead>
                            <tr>
                                <th><b>Other Drugs</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($drugs as $data)
                            <tr>
                                @if (preg_match('/[a-zA-Z]/', $data))
                                <td>{!! $data; !!}</td>
                                @else
                                <td>{!! $mas_nont_antibio[$data]; !!}</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
                <div class="content-block custom-print">
                    <h4>Fluids & Electrolytes</h4>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                        <div class="form-group">
                            <div>
                                <span class="print-label">Total Fluid ml/kg/d:</span>
                                <span class="print-value"> {!! $results->TotalFluid; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">Previous Weight:</span>
                                <span class="print-value"> {!! $results->PreviousWt; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">Current Weight:</span>
                                <span class="print-value"> {!! $results->CurrentWt; !!}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                        <div class="form-group">
                            <div>
                                <span class="print-label">UO (ml/kg/hr):</span>
                                <span class="print-value"> {!! $results->UO; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">Blood Out:</span>
                                <span class="print-value"> {!! $results->BloodOut; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">Drain Output:</span>
                                <span class="print-value"> {!! $results->DrainOutput; !!}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                        <div class="form-group">
                            <div>
                                <span class="print-label">Weight Change:</span>
                                <span class="print-value"> {!! $results->WtChange; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">Percentage Change:</span>
                                <span class="print-value"> {!! $results->PercentageChange; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">Transfusion:</span>
                                <span class="print-value"> {!! $results->Transfusion; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="print-label">RBS:</span>
                                <span class="print-value"> {!! $results->RBS; !!}</span>
                            </div>
                        </div>
                    <!-- <div class="form-group">
                        <div ><span class="print-label">SerumNa:</span> {!! $results->SerumNa; !!}</div>
                        </div>
                        <div class="form-group">
                        <div ><span class="print-label">SerumK:</span> {!! $results->SerumK; !!}</div>
                    </div> -->
                </div>
            </div>
            <div class="content-block custom-print">
                <h4>Invasive Lines</h4>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="form-group">
                        <div>
                            <span class="print-label">PVC:</span>
                            <span class="print-value"> {!! $results->PeripheralCannula; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">UAC:</span>
                            <span class="print-value"> {!! $results->Uac; !!}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="form-group">
                        <div>
                            <span class="print-label">PICC:</span>
                            <span class="print-value"> {!! $results->Picc; !!}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <span class="print-label">PAC:</span>
                            <span class="print-value"> {!! $results->Pac; !!}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="form-group">
                        <div>
                            <span class="print-label">UVC:</span>
                            <span class="print-value "> {!! $results->Uvc; !!}</span>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-sm-12 col-md-12 plr-must-0">
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <div>
                                <span class="print-label">ROP:</span>
                                <span class="print-value"> {!! $results->Rop; !!}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="form-group">
                        <div>
                            <span class="print-label">Skin:</span>
                            <span class="print-value"> {!! $results->Skin; !!}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-break"></div>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0 page-break-page">
                <div class="content-block">
                    <h4>Management Plan</h4>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="pl-10"><b>{!! $results->Plan; !!}</b></div>
                        </div>
                    </div>
                </div>
                <div class="content-block">
                    <h4>Notes</h4>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="pl-10"><b>{!! $results->Notes; !!}</b></div>
                        </div>
                    </div>
                </div>
                <div class="content-block">
                    <h4>Seen By</h4>
                    <div class="col-md-12">
                        <div class="form-group custom-seen-by">
                            {!! $results->seenby !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                    <div class="col-xs-3 col-sm-3 col-md-3 mt-15 plr-sm-0">
                        <p class=" col-md-11 plr-must-0">Date : <b>{!! date("d-m-Y",strtotime($results->DayDate)); !!}</b></p>
                        <p class=" col-md-11 plr-must-0"> Place: <b>{{ env('LOCATION') }} </b></p>
                    </div>
                    <div class="col-xs-9 col-sm-9 col-md-9 pull-right text-center mt-15 pr-sm-0">
                        {!! $results->rawdr !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br/>
<br/>
<br/>
<br/>
<div></div>
@endsection
@section('scripts')

<script type="text/javascript">
$('.open-editor').click(function() {
    bootbox.confirm("If you edit this document, the changes will not be reflected in the main database and vice versa. Do you still want to continue?",function(confirmed){
        if(confirmed){    var day_id = $('input[name="DayId"]').val();
            var requestUrl = "{{ url('nicu-daycare-abbreviated/'.Request::segment(2)) }}";
            $.ajax({
                type: "GET",
                url: '{{ url("nicu-daycare-reports-editors") }}',
                data: {
                    dataUrl: requestUrl,
                    day_id: day_id
                },
                cache: false,
                dataType: "json",
                success: function(responseText) {
                    window.location = requestUrl;
                },
                error: function(response) {}
            });
        }
    });
}); 
</script>
@endsection
