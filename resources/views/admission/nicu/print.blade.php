@extends('print')
@section('content')
@php $public_url =url('public').'/'; @endphp
@if (isset($editor_gen) && $editor_gen)
<div class="editor_style">
    @include('editor_print')  
</div>
@endif
<style type="text/css">
    .nicu-container ol
    {
        counter-reset: LIST-ITEMS 0;
    }
    .nicu-container li
    {
        display: inline;
        padding-right: 0.5em;
    }
    .nicu-container li:before
    {
        content: counter( LIST-ITEMS ) ".";
        counter-increment: LIST-ITEMS;
        padding-right: 0.25em;
    }
</style>
<div class="temp-container nicu-proforma">
    <div class="temp-row">
        <div class="col-md-12">
            <img src="{{ SiteHelpers::getNicuLogo($results->NicuId) }}">
        </div>
        <div class="col-md-12 mt-10">
            <h3 class="print-head mt-0">NICU Admission Pro forma</h3>
        </div>
        {{ Form::hidden('NicuId', $results->NicuId) }}
        <div class="col-md-12 nicu-container">
            <div class="content-block mt-must-0">
                <h4>Basic Details</h4>
                <div class="content-section">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <span class="print-label">DOA:</span> 
                            <span class="print-value">{!! date("d-m-Y",strtotime($results->AdmissionDate)); !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Name:</span>
                            <span class="print-value">{!! $results->BabyName; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">DOB:</span> 
                            <span class="print-value">{!! date("d-m-Y",strtotime($results->DOB)); !!}</span>
                        </div>
                        @php $results->TOB_TIME=(strlen($results->TOB_TIME)==1) ? '0'.$results->TOB_TIME:$results->TOB_TIME;   @endphp
                        @php 
                        if(isset($results->TOB_MINS) && $results->TOB_MINS == 'N/A')
                        $results->TOB_MINS = '00';
                        $results->TOB_MINS=(strlen($results->TOB_MINS)==1) ? '0'.$results->TOB_MINS:$results->TOB_MINS;  
                        @endphp       
                        <div class="form-group">
                            <span class="print-label">TOB:</span>
                            <span class="print-value">{!! $results->TOB_TIME .':'.$results->TOB_MINS.':'.$results->TOB_AM  !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Birth Order:</span> 
                            <span class="print-value">{!! $results->BirthOrder; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Referred From:</span> 
                            <span class="print-value">{!! $results->ReferredBy; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Reason for Referral:</span>
                            <span class="print-value">{!! $results->ReferralReason; !!}</span>
                        </div>
                        @if(!empty($results->Surgeon) && $results->Surgeon!='None')
                        <div class="form-group">
                            <span class="print-label">Surgeon:</span>
                            <span class="print-value">{!! empty(ValuelistHelpers::mas_doctors_list($results->Surgeon)) ? $results->Surgeon : ValuelistHelpers::mas_doctors_list($results->Surgeon); !!}</span>
                        </div>
                        @endif 
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        @if((strlen($results->SeenBy) > 3) && is_array(json_decode($results->SeenBy)) && count(json_decode($results->SeenBy)) > 0)
                        <div class="form-group row">
                            <table>
                                @php $temp_consultant = ValuelistHelpers::mas_doctors_list(); @endphp
                                <th class="print-label" style="padding: 0px !important; color: black;"><b>Seen By:</b></th>
                                @php $i=1; $lenthofiv=count(json_decode($results->SeenBy)) @endphp
                                <tr>
                                    <td>
                                        @foreach(json_decode($results->SeenBy) as $SeenBy)
                                        @if(isset($temp_consultant[$SeenBy]) && !empty($temp_consultant[$SeenBy]))
                                        {!! $temp_consultant[$SeenBy]; !!} @if($lenthofiv != $i) , @endif
                                        @php $i++; @endphp
                                        @endif
                                    @endforeach  </td>
                                </tr>
                            </table>
                        </div>
                        @endif 
                        <div class="form-group">
                            <span class="print-label">{{ Lang::get('home.mrn') }}:</span> 
                            <span class="print-value">{!! $results->BMrNo; !!}</span>
                        </div>
                        @if(isset($ip_details->ip_number))
                        <div class="form-group">
                            <span class="print-label">{{ Lang::get('home.ip') }}:</span> 
                            <span class="print-value"> {!! $ip_details->ip_number; !!} </span>
                        </div>
                        @endif
                        <div class="form-group">
                            <span class="print-label" >Gestation (wks):</span>
                            <span class="print-value">{!! $results->Gestation; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label" >Birth Weight (In Gms):</span>
                            <span class="print-value"> {!! $results->BirthWeight; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Sex:</span> 
                            <span class="print-value"> {!! $results->Sex; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Age on admission:</span> 
                            <span class="print-value">{!! $results->AgeOnAdmissioninDays; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">OFC (cm):</span> 
                            <span class="print-value">{!! $results->OFC; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Length (cm):</span> 
                            <span class="print-value">{!! $results->Length; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">CGA:</span>
                            <span class="print-value">{!! $results->CorrectedGestation; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Admission Type:</span>
                            <span class="print-value">{!! $results->TypeOfCare; !!}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-block">
                <h4>Maternal Details</h4>
                <div class="content-section">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <span class="print-label">Name M:</span> 
                            <span class="print-value">{!! ucwords(@$results->MotherName); !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Age M:</span>
                            <span class="print-value">{!! @$results->MothercYear; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Address1:</span> 
                            <span class="print-value">{!! ucwords(@$results->Address1); !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Address2:</span> 
                            <span class="print-value">{!! ucwords(@$results->Address2); !!}</span>
                        </div>
                        <!--   <div class="form-group">
                            <span class="print-label">City:</span>
                            <span class="print-value">{!! ucwords(@$results->City); !!}</span>
                        </div> -->
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <span class="print-label">{{ Lang::get('home.mrn') }} M:</span> 
                            <span class="print-value">{!! (!empty($results->MMrNo)) ? $results->MMrNo :'Not registered'; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Spoken Languages M:</span> 
                            <span class="print-value">{!! (!empty($results->MotherSpokenLanguages)) ? ucwords($results->MotherSpokenLanguages) :'Not Mentioned'; !!}</span>
                        </div>
                        <!-- <div class="form-group">
                            <span class="print-label">Occupation M:</span>
                            <span class="print-value"> {!! @$results->Occupation; !!}</span>
                        </div> -->
                        <div class="form-group">
                            <span class="print-label">Address3:</span> 
                            <span class="print-value">{!! ucwords(@$results->Address3); !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Address4:</span>
                            <span class="print-value">{!! ucwords(@$results->Address4); !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Contact No :</span>
                            <span class="print-value">{!! @$results->Mobile.' , '.@$results->PartnerContact; !!}</span>
                        </div>
                        <!-- <div class="form-group">
                            <div><span class="print-label">Contact No F:</span> {!! @$results->PartnerContact; !!}</div>
                        </div> -->
                        <!-- <div class="form-group">
                            <div ><span class="print-label">Spoken Languages F:</span> {!! @$results->FatherSpokenLanguages; !!}</div>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="content-block">
                <h4>Maternal History</h4>
                <div class="col-xs-12 col-sm-12 col-md-12 pl-must-5">
                    <table cellspacing="3">
                        <thead>
                            <tr>
                                <td>
                                    <h5>Medical History</h5>
                                </td>
                                <td>
                                    <h5>Medications</h5>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($pbm_data) && count($pbm_data) > 0)
                            @foreach ($pbm_data as $data)
                            @if($data['Problem']!=0 && isset($maternal_problems[$data['Problem']]) && isset($data['Medication']))
                            <tr>
                                <td>{!! $maternal_problems[$data['Problem']] !!}</td>
                                <td>{!! $data['Medication']; !!}</td>
                            </tr>
                            @endif
                            @endforeach
                            @else
                            <tr>
                                <td>Nil</td>
                                <td>Nil</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="content-section">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        @if(isset($results->Smoking) && !empty($results->Smoking))
                        <div class="form-group">
                            <span class="print-label">Smoking:</span> 
                            <span class="print-value">  {!! $results->Smoking; !!}</span>
                        </div>
                        @endif
                        @if(isset($results->Alcohol) && !empty($results->Alcohol))
                        <div class="form-group">
                            <span class="print-label">Alcohol:</span>
                            <span class="print-value">{!! $results->Alcohol; !!}</span>
                        </div>
                        @endif
                        @if(isset($results->Tobacco) && !empty($results->Tobacco))
                        <div class="form-group">
                            <span class="print-label">Tobacco:</span> 
                            <span class="print-value">{!! $results->Tobacco; !!}</span>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-12 col-xs-12 pl-must-5">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <div>G {!! @$results->G_Value; !!}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div>P {!! @$results->P_Value; !!}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div>L {!! @$results->L_Value; !!}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div>A {!! @$results->A_Value; !!}</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 col-xs-12 pl-must-5 overflow-auto">
                    <table cellspacing="3">
                        @if (isset($delivery_details) && count($delivery_details) > 0)
                        <thead>
                            <tr>
                                <th>Year</th>
                                <th>Place</th>
                                <th>Delivery</th>
                                <th>Complications</th>
                                <th>Gender</th>
                                <th>GA</th>
                                <th>BW</th>
                                <th>Health</th>
                            </tr>
                        </thead>
                        <tbody>
                            @endif
                            @if (isset($delivery_details) && count($delivery_details) > 0)
                            @foreach ($delivery_details as $com_data)
                            <tr>
                                <td>{!! $com_data['Year']; !!}</td>
                                <td>{!! $com_data['Place']; !!}</td>
                                <td>{!! $com_data['Delivery']; !!}</td>
                                <td>{!! $com_data['Complications']; !!}</td>
                                <td>{!! $com_data['Gender']; !!}</td>
                                <td>{!! $com_data['GA']; !!}</td>
                                <td>{!! $com_data['BW']; !!}</td>
                                <td>{!! $com_data['Health']; !!}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="content-block">
                <h4>Current Pregnancy</h4>
                <div class="content-section">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <span class="print-label">Place of Supervision:</span>
                            <span class="print-value">{!! is_numeric($results->PlaceofSupervision) ? ValuelistHelpers::mas_referral_list($results->PlaceofSupervision) : $results->PlaceofSupervision; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Conception:</span> 
                            <span class="print-value">{!! $results->Conception; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Supervised:</span>
                            <span class="print-value"> {!! $results->Supervised; !!}</span>
                        </div>
                        @if(!empty($results->LMP) && date("Y",strtotime($results->LMP))!= 1970)
                        <div class="form-group">
                            <span class="print-label">LMP:</span> 
                            <span class="print-value">{!! date("d-m-Y",strtotime($results->LMP)); !!}</span>
                        </div>
                        @endif
                        @if(!empty($results->EDDbyUSG) && date("Y",strtotime($results->EDDbyUSG))!= 1970) 
                        <div class="form-group">
                            <span class="print-label">EDD by USG:</span>
                            <span class="print-value">{!! date("d-m-Y",strtotime($results->EDDbyUSG)); !!}</span>
                        </div>
                        @endif
                        @if(!empty($results->EDDbyDates) && date("Y",strtotime($results->EDDbyDates))!= 1970)  
                        <div class="form-group">
                            <span class="print-label">EDD by Dates:</span>
                            <span class="print-value">{!! date("d-m-Y",strtotime($results->EDDbyDates)); !!}</span>
                        </div>
                        @endif 
                        <!-- <div class="form-group">
                            <div ><span class="print-label">Investigations:</span> {!! $results->OtherInvestigations; !!}</div>
                        </div> -->                                                                          
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <span class="print-label">Mother's BG:</span>
                            <span class="print-value">{!! @$results->MotherBloodGroup; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Hepatitis B:</span>
                            <span class="print-value">{!! $results->HepatitisB; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">HIV:</span>
                            <span class="print-value">{!! $results->HIV; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">VDRL:</span> 
                            <span class="print-value">{!! $results->VDRL; !!}</span>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                @if (isset($gestation) && count($gestation) > 0)
                <div class="col-md-12">
                    <h4>Antenatal USG & Doppler</h4>
                    <table>
                        <thead>
                            <tr>
                                <td>
                                    <h5>Usg Date</h5>
                                </td>
                                <td>
                                    <h5>Usg Gestation</h5>
                                </td>
                                <td>
                                    <h5>Usg Findings</h5>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < count($gestation); $i++)
                            <tr>
                                <td>{{ $date[$i] or '' }}</td>
                                <td>{{ $gestation[$i] or '' }}</td>
                                <td>{{ $findings[$i]  or '' }}</td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
            <div class="page-break"></div>
            <div class="content-block">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <span class="print-label label-increase">Complication During Pregnancy : </span>
                        <span class="print-value value-decrease"> {!!$results->PregnancyComplications; !!} </span>
                    </div>
                </div>
                @if($results->PregnancyComplications!='No')
                <div class="col-xs-12 col-sm-12 col-md-12 pl-must-5">
                    <table>
                        <thead>
                            <tr>
                                <td>
                                    <h5>Complication</h5>
                                </td>
                                <td>
                                    <h5>Treatment</h5>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($complication) && count($complication) > 0)
                            @forelse ($complication as $data)
                            @if($data['Complication'] != 0 || count($complication) != 1)
                            <tr>
                                <td>{!! $complication_master[$data['Complication']] !!}</td>
                                <td>{!! $data['Treatment']; !!}</td>
                            </tr>
                            @else
                            <tr>
                                <td>Nil</td>
                                <td>Nil</td>
                            </tr>
                            @endif
                            @empty
                            <tr>
                                <td>Nil</td>
                                <td>Nil</td>
                            </tr>
                            @endforelse
                            @else
                            <tr>
                                <td>Nil</td>
                                <td>Nil</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                @endif 
                <div class="content-section">
                    <div class="col-xs-8 col-sm-6 col-md-6">
                        <div class="form-group">
                            <span class="print-label">Antenatal Steroids:</span>
                            <span class="print-value"> {!! $results->AntenatalSteroids; !!}</span>
                        </div>
                        @if($results->AntenatalSteroids!='No')
                        <div class="form-group">
                            <span class="print-label">Last Dose Delivery Interval:</span>
                            <span class="print-value">{!! $results->LastDoseDeliveryInterval; !!}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="content-block">
                <h4>Labour & delivery</h4>
                <div class="content-section">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <span class="print-label">Delivery Mode:</span>
                            <span class="print-value"> {!! $results->ModeOfDelivery; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">PROM:</span> 
                            <span class="print-value">{!! $results->PROM; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">PROM (hours):</span> 
                            <span class="print-value">{!! $results->DurationOfROM; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Maternal Pyrexia:</span> 
                            <span class="print-value">{!! $results->MaternalPyrexia; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Liquor:</span>
                            <span class="print-value"> {!! $results->CommentOnLiquor; !!}</span>
                        </div>
                        @if($results->Maternal_antibiotics_status == 'Yes') 
                        @if(!empty($results->MaternalAntibiotics) && $results->MaternalAntibiotics != 'N/A' && is_array(json_decode($results->MaternalAntibiotics)))
                        <div class="form-group">
                            <span class="print-label"> MaternalAntibiotics:</span>
                            <ul class="baby-lists list-none">
                                @forelse(json_decode($results->MaternalAntibiotics) ? : [] as $maternalantibiotics)
                                <li>  {!! $maternalantibiotics;  !!} </li>
                                @empty
                                <li>  Nil </li>
                                @endforelse
                            </ul>
                        </div>
                        @elseif(!empty($results->MaternalAntibiotics) && $results->MaternalAntibiotics != 'N/A' && is_array(unserialize($results->MaternalAntibiotics)))
                        <div class="form-group">
                            <span class="print-label"> MaternalAntibiotics:</span>
                            <ul class="baby-lists list-none">
                                @forelse(unserialize($results->MaternalAntibiotics) ? : [] as $maternalantibiotics)
                                <li>  {!! $maternalantibiotics;  !!} </li>
                                @empty
                                <li>  Nil </li>
                                @endforelse
                            </ul>
                        </div>
                        @endif
                        <div class="form-group">
                            <span class="print-label">Last Dose Time:</span> 
                            <span class="print-value">{!! $results->TimeofLastDose; !!}</span>
                        </div>
                        @endif
                        <div class="form-group">
                            <span class="print-label">Labour:</span> 
                            <span class="print-value">{!! $results->Labour; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Presentation:</span>
                            <span class="print-value">{!! $results->Presentation; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Cord Blood Gas:</span>
                            <span class="print-value"> {!! $results->CordBloodGas; !!}</span>
                        </div>
                        @if($results->CordBloodGas!='Not done' && $results->CordBloodGas!='')
                        <div class="form-group">
                            <span class="print-label">Cord pH:</span>
                            <span class="print-value"> {!! $results->CordpH; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Cord HCO3:</span> 
                            <span class="print-value">{!! $results->CordHCO3; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Cord BE:</span> 
                            <span class="print-value">{!! $results->CordBE; !!}</span>
                        </div>
                        @endif
                        <div class="form-group">
                            <span class="print-label">Resuscitation:</span>
                            <span class="print-value"> {!! $results->Resuscitation; !!}</span>
                        </div>
                        @if($results->Resuscitation!='No')  
                        <div class="form-group">
                            <span class="print-label">Time Of 1st Gasp (min):</span>
                            <span class="print-value">{!! $results->TimeOf1stGasp; !!}</span>
                        </div>
                        @endif
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        @if(isset($results->Indication) && !empty($results->Indication))
                        <div class="form-group">
                            <span class="print-label">Indication:</span> 
                            <span class="print-value">{!! $results->Indication; !!}</span>
                        </div>
                        @endif
                        <div class="form-group">
                            <span class="print-label">Nature of Labour:</span>
                            <span class="print-value">{!! $results->NatureofLabour; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">CTG Details:</span>
                            <span class="print-value">{!! $results->CTGDetails; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Fetal Distress:</span> 
                            <span class="print-value">{!! $results->FoetalDistress; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Gastric Aspirate:</span> 
                            <span class="print-value">{!! $results->GastricAspirate; !!}</span>
                        </div>
                        @if($results->Resuscitation != 'No') 
                        <div class="form-group">
                            <span class="print-label">Regular Respiration (min):</span> 
                            <span class="print-value">{!! $results->RegularRespiration; !!}</span>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 plr-must-0 apgar overflow-auto">
                    @if($results->known_field==1)
                    <th>APGAR</th>
                    <table>
                        <tr>
                            <td></td>
                            <td><strong>1 min</strong></td>
                            <td><strong>5 mins</strong></td>
                            <td><strong>10 mins</strong></td>
                            <td><strong>15 mins</strong></td>
                            <td><strong>20 mins</strong></td>
                        </tr>
                        <!-- <tr>
                            <td>Colour</td>
                            <td> {!! $results->Colour1; !!}</td>
                            <td> {!! $results->Colour5; !!}</td>
                            <td> {!! $results->Colour10; !!}</td>
                            <td> {!! $results->Colour20; !!}</td>
                            </tr>
                            <tr>
                            <td>HR</td>
                            <td> {!! $results->HR1; !!}</td>
                            <td> {!! $results->HR5; !!}</td>
                            <td> {!! $results->HR10; !!}</td>
                            <td> {!! $results->HR20; !!}</td>
                            </tr>
                            <tr>
                            <td>Reflex</td>
                            <td> {!! $results->Reflex1; !!}</td>
                            <td> {!! $results->Reflex5; !!}</td>
                            <td> {!! $results->Reflex10; !!}</td>
                            <td> {!! $results->Reflex20; !!}</td>
                            </tr>
                            <tr>
                            <td>Tone</td>
                            <td> {!! $results->Tone1; !!}</td>
                            <td> {!! $results->Tone5; !!}</td>
                            <td> {!! $results->Tone10; !!}</td>
                            <td> {!! $results->Tone20; !!}</td>
                            </tr>
                            <tr>
                            <td>Respiration</td>
                            <td> {!! $results->Respiration1; !!}</td>
                            <td> {!! $results->Respiration5; !!}</td>
                            <td> {!! $results->Respiration10; !!}</td>
                            <td> {!! $results->Respiration20; !!}</td>
                            </tr>
                            <tr></tr> -->
                            <tr>
                                <td>Total</td>
                                <td> {!! $results->Apgars1min; !!}</td>
                                <td> {!! $results->Apgars5min; !!}</td>
                                <td> {!! $results->Apgars10min; !!}</td>
                                <td> {!! $results->Apgars15min; !!}</td>
                                <td> {!! $results->Apgars20min; !!}</td>
                            </tr>
                        </table>
                        @endif
                    </div>
                </div>
                <div class="content-block">
                    <h4>Resuscitation Details</h4>
                    <div class="content-section">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span class="print-label">Facial Oxygen:</span>
                                <span class="print-value">  {!! $results->FacialOxygen; !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">PPV:</span>
                                <span class="print-value"> {!! $results->PPV; !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Intubation:</span> 
                                <span class="print-value">  {!! $results->Intubation; !!}</span>
                            </div>
                            @if($results->Intubation!='No')
                            <div class="form-group">
                                <span class="print-label">ETT Size (mm):</span> 
                                <span class="print-value"> {!! $results->ETTSize; !!}</span>
                            </div>
                            @if($results->FacialOxygen!='No')
                            <div class="form-group">
                                <span class="print-label">Duration Of Oxygen (min):</span>
                                <span class="print-value"> {!! $results->DurationOfOxygen; !!}</span>
                            </div>
                            @endif 
                            @if($results->PPV!='No')
                            <div class="form-group">
                                <span class="print-label">Duration Of PPV (min):</span> 
                                <span class="print-value">  {!! $results->DurationOfPPV; !!}</span>
                            </div>
                            @endif
                            <div class="form-group">
                                <span class="print-label">CPR:</span> 
                                <span class="print-value">  {!! $results->CPR; !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Depth Of Insertion (cm):</span>
                                <span class="print-value">  {!! $results->DepthOfInsertion; !!}</span>
                            </div>
                            @endif
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span class="print-label">Drugs:</span>
                                <span class="print-value">  {!! $results->Drugs; !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Surfactant Given:</span>
                                <span class="print-value">{!! $results->SurfactantGiven; !!}</span>
                            </div>
                            @if( !empty($results->SurfactantGiven) && $results->SurfactantGiven!='No' && $results->SurfactantGiven!='N/A') 
                            <div class="form-group">
                                <span class="print-label">Time:</span>
                                <span class="print-value">{!! $results->TimeOfAdministration; !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Surfactant Type:</span>
                                <span class="print-value">{!! $results->SurfactantType; !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Dose:</span> 
                                <span class="print-value">{!! $results->Dose; !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Age after birth (hrs):</span> 
                                <span class="print-value">{!! $results->AgeAfterBirth; !!}</span>
                            </div>
                            @endif 
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 full-width">
                        <div class="form-group">
                            <span class="print-label plr-must-0">Description of resuscitation:</span>
                        </div>
                        <div class="ml-10">
                            <span class="print-value">{!! $results->DescriptionOfResuscitation; !!}</span>
                        </div>
                    </div>
                </div>
                <div class="page-break"></div>
                <div class="content-block">
                    <h4>Transfer Details</h4>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <span class="print-label">Ventilation Required:</span> 
                            <span class="print-value">{!! $results->VentilationRequired; !!}</span>
                        </div>
                        @if(!empty($results->TotalSNAPPE2Score)) 
                        <div class="form-group">
                            <span class="print-label">SNAPPE II Score:</span> 
                            <span class="print-value">{!! $results->TotalSNAPPE2Score; !!}</span>
                        </div>
                        @endif
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <span class="print-label">Transfer FIO2 (L/min or %):</span> 
                            <span class="print-value">{!! $results->TransferFiO2; !!}</span>
                        </div>
                        @if(!empty($results->TotalCRIB2Score))
                        <div class="form-group">
                            <span class="print-label">CRIB II Score:</span> 
                            <span class="print-value">{!! $results->TotalCRIB2Score; !!}</span>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="content-block">
                    <div class="topbar1">
                        <h4>Admission Details</h4>
                        <div class="content-section">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <span class="print-label">Admitted From:</span>
                                    <span class="print-value">{!! $results->AdmittedFrom; !!}</span>
                                </div>
                            </div>
                        </div>
                        <div class="content-section">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    @php $Ad_Time=(strlen($results->AdmissionTime)=='1')? '0'.$results->AdmissionTime: $results->AdmissionTime;  @endphp
                                    @php 
                                    if(isset($results->AdmissionTime_MINS) && ($results->AdmissionTime_MINS == 'N/A' || $results->AdmissionTime_MINS == ''))
                                    $Ad_MINS = '00';
                                    else
                                    $Ad_MINS=(strlen($results->AdmissionTime_MINS)==1) ? '0'.$results->AdmissionTime_MINS:$results->AdmissionTime_MINS;
                                    @endphp
                                    @php $Ad_AM=$results->AdmissionTime_AM;  @endphp
                                    @php $admission_time=$Ad_Time.':'.$Ad_MINS.':'.$Ad_AM;  @endphp
                                    <span class="print-label">Time of Admission:</span>
                                    <span class="print-value">{!! $admission_time; !!}</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <span class="print-label">Major C/O:</span>
                                    <span class="print-value"> {!! $results->MajorComplaints; !!}</span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-12 col-sm-6 col-md-6 topbar1">
                            <h4>Initial Examination at NICU</h4>
                        </div>
                        <div class="content-section">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <span class="print-label">BP:</span> 
                                    <span class="print-value">{!! $results->BP; !!}</span>
                                </div>
                                <div class="form-group">
                                    <span class="print-label">Temperature:</span>
                                    <span class="print-value">{!! $results->Temperature; !!}</span>
                                </div>
                                <div class="form-group">
                                    <span class="print-label">Ventilation:</span>
                                    <span class="print-value">{!! $results->Ventilation; !!}</span>
                                </div>
                                @if($results->Ventilation!='No')
                                <div class="form-group">
                                    <span class="print-label">PIP:</span> 
                                    <span class="print-value">{!! $results->Pip; !!}</span>
                                </div>
                                @endif
                                <div class="form-group">
                                    <span class="print-label">Chest:</span> 
                                    <span class="print-value">{!! $results->ChestMovement; !!}</span>
                                </div>
                                <div class="form-group">
                                    <span class="print-label">Malformation:</span> 
                                    <span class="print-value">{!! $results->Malformation; !!}</span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="content-section">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <span class="print-label">HR in bpm:</span> 
                                    <span class="print-value">{!! $results->HR; !!}</span>
                                </div>
                                <div class="form-group">
                                    <span class="print-label">Mean BP:</span>    
                                    <span class="print-value">{!! $results->MeanBP; !!}</span>
                                </div>
                                <div class="form-group">
                                    <span class="print-label">CFT:</span> 
                                    <span class="print-value">{!! $results->CFT; !!}</span>
                                </div>
                                @if($results->Ventilation!='No')
                                <div class="form-group">
                                    <span class="print-label">Mode:</span> 
                                    <span class="print-value">{!! \SiteHelpers::gettable_values('mas_admissionmode', 'Mode_name', 'Id', $results->Mode) !!}</span>
                                </div>
                                <div class="form-group">
                                    <span class="print-label">PEEP:</span>
                                    <span class="print-value">{!! $results->PEEP; !!}</span>
                                </div>
                                <div class="form-group">
                                    <span class="print-label">Rate:</span> 
                                    <span class="print-value">{!! $results->Rate; !!}</span>
                                </div>
                                @endif
                            <!--  <div class="form-group">
                                <span class="print-label">Skin:</span>
                                <span class="print-value">{!! $results->Skin; !!}</span>
                            </div> -->
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span class="print-label">RR:</span>
                                <span class="print-value">{!! $results->RR; !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">SpO2:</span> 
                                <span class="print-value">{!! $results->SpO2; !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Fio2:</span> 
                                <span class="print-value">{!! $results->Fio2; !!}</span>
                            </div>
                            @if($results->Ventilation!='No') 
                            <div class="form-group">
                                <span class="print-label">IT:</span>
                                <span class="print-value">{!! $results->IT; !!}</span>
                            </div>
                            @endif
                            <div class="form-group">
                                <span class="print-label">Tone:</span>
                                <span class="print-value">{!! $results->Tone; !!}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label">Malformation Type:</span> 
                                <span class="print-value">{!! $results->MalformationType; !!}</span>
                            </div>
                        </div>
                    </div>
                    <div class="content-section">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span class="print-label">Abnormalities:</span> 
                                <span class="print-value">{!! $results->Abnormalities; !!}</span>
                            </div>
                        </div>
                    </div>
@if (strtotime($results->initial_assessment_completed_date))
                    <div class="content-section">
                        <div class="col-xs-12 col-sm-12 col-md-12">

                        @php 
                        $initial_assessment_completed_date = date('d-m-Y', strtotime($results->initial_assessment_completed_date));
                        $initial_assessment_completed_hr = strlen($results->initial_assessment_completed_hr) == 1 ? '0' . $results->initial_assessment_completed_hr : $results->initial_assessment_completed_hr;  
                        $initial_assessment_completed_min = strlen($results->initial_assessment_completed_min) == 1 ? '0' . $results->initial_assessment_completed_min : $results->initial_assessment_completed_min;  
                        @endphp
                            <h4>Initial Assessment Completed Time: {!! $initial_assessment_completed_date . '  ' . $initial_assessment_completed_hr . ':' . $initial_assessment_completed_min . '  ' . $results->initial_assessment_completed_session; !!}</h4>
                        </div>
                    </div>
@endif
                </div>
            </div>
            <div class="content-block">
                <h4>Investigations On Admission</h4>
                <div class="content-section">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <span class="print-label">Initial Blood Gas:</span>
                            <span class="print-value"> {!! $results->InitialBloodGas; !!}</span>
                        </div>
                        @if($results->InitialBloodGas != 'Not done' && $results->InitialBloodGas != 'Not indicated')                          
                        <div class="form-group">
                            <span class="print-label">pH:</span> 
                            <span class="print-value">{!! $results->pH; !!}</span>
                        </div>                         
                        <div class="form-group">
                            <span class="print-label">Lactate:</span> 
                            <span class="print-value">{!! $results->lab_lactate; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">paO2:</span>
                            <span class="print-value">{!! $results->PaO2; !!}</span>
                        </div>
                        @endif
                        <div class="form-group">
                            <span class="print-label">Initial X ray:</span>
                            <span class="print-value">{!! $results->InitialXray; !!}</span>
                        </div>
                        @if($results->InitialXray=='Performed')
                        @if(!empty($results->xrayfindings))
                        <div class="form-group">
                            <span class="print-label">X ray findings:</span>
                            <span class="print-value">{!! $results->xrayfindings; !!}</span>
                        </div>
                        @endif
                        @if(!empty( $results->AgeofCXR))
                        <div class="form-group">
                            <span class="print-label">Age of X-ray:</span>
                            <span class="print-value">{!! $results->AgeofCXR; !!}</span>
                        </div>
                        @endif
                        @endif
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        @if($results->InitialBloodGas != 'Not done' && $results->InitialBloodGas != 'Not indicated')  
                        <div class="form-group">
                            <span class="print-label">paCo2:</span>
                            <span class="print-value">{!! $results->PaCo2; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">HCO3:</span>
                            <span class="print-value">{!! $results->HCO3; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">BE:</span>
                            <span class="print-value">{!! $results->BE; !!}</span>
                        </div>
                        @endif
                        <div class="form-group">
                            <span class="print-label">RBS:</span>
                            <span class="print-value">{!! $results->RBS; !!}</span>
                        </div>
                        @if($results->InitialBloodGas != 'Not done' && $results->InitialBloodGas != 'Not indicated')  
                        <div class="form-group">
                            <span class="print-label">Hct:</span>
                            <span class="print-value"> {!! $results->Hct; !!}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="page-break"></div>
            <div class="content-block">
                <h4>Procedures</h4>
                <div class="content-section">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <span class="print-label">UAC:</span>
                            <span class="print-value">{!! $results->UAC; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">UVC:</span> 
                            <span class="print-value">{!! $results->UVC; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Sepsis Screen:</span>
                            <span class="print-value">{!! $results->SepsisScreen; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Indications:</span> 
                            <span class="print-value">{!! $results->Indications; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Fluids (ml/kg/day):</span> 
                            <span class="print-value">{!! $results->Fluids; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Investigations:</span>
                            <span class="print-value">{!! $results->Investigations; !!}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        @if($results->UAC!='No' && !empty($results->UAC) && !empty($results->UACPosition))
                        <div class="form-group">
                            <span class="print-label">UAC Position:</span>
                            <span class="print-value">{!! $results->UACPosition; !!}</span>
                        </div>
                        @endif
                        @if($results->UVC!='No' && !empty($results->UVC) && !empty($results->UVCPosition))
                        <div class="form-group">
                            <span class="print-label">UVC Position:</span>
                            <span class="print-value">{!! $results->UVCPosition; !!}</span>
                        </div>
                        @endif
                        <div class="form-group">
                            <span class="print-label">Vitamin K:</span> 
                            <span class="print-value">{!! $results->VitaminK; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Dose:</span> 
                            <span class="print-value">{!! $results->DoseVitK; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Route:</span> 
                            <span class="print-value">{!! $results->RouteVitK; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">NBM:</span>
                            <span class="print-value">{!! $results->NBM; !!}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 plr-must-0">
                    @if((strlen($results->IVAntibiotic) > 3) && is_array(json_decode($results->IVAntibiotic)) && count(json_decode($results->IVAntibiotic)) > 0)
                    <div class="form-group">
                        <div>
                            <table>
                                @php $temp_antibiotic = ValuelistHelpers::getDrugIvFluidsAntibiotic(); @endphp
                                <th class="custom-padding">IV Antibiotic:</th>
                                @php $i=1; $lenthofiv=count(json_decode($results->IVAntibiotic)) @endphp
                                @foreach(json_decode($results->IVAntibiotic) as $IVAntibiotic)
                                @if(!empty($temp_antibiotic[$IVAntibiotic]))
                                <tr>
                                    <td>{!! $i.' ) ' !!}{!! $temp_antibiotic[$IVAntibiotic]; !!} @if($lenthofiv != $i) , @endif</td>
                                </tr>
                                @php $i++; @endphp
                                @endif
                                @endforeach  
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="page-break"></div>
            @if(count(json_decode($results->DifferentialDiagnosis)) > 0 || count(json_decode($results->additional_diagnosis)) > 0)                                                              
            <div class="content-block">
                <h4>Differential Diagnosis</h4>
                <div class="col-xs-12 col-sm-12 col-md-12 topbar">
                    <div class="form-group">
                        <div class="text-justify"> 
                            @if(count(json_decode($results->DifferentialDiagnosis)) > 0)
                            @forelse(json_decode($results->DifferentialDiagnosis) as $Diagnosis)
                            {!! $icd_master[$Diagnosis].'-'.$Diagnosis  !!}<br/>
                            @empty  
                            @endforelse
                            @endif
                            @if(count(json_decode($results->additional_diagnosis)) > 0)  
                            @forelse(json_decode($results->additional_diagnosis) as $additional_diagnosis)
                            {!! $additional_diagnosis !!} <br/>
                            @empty  
                            @endforelse
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="content-block">
                <h4>Plan</h4>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="text-justify">
                            <span class="print-value full-width-must">{!! $results->Plan; !!}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-break"></div>
            <div class="col-xs-12 col-sm-12 col-md-12 plr-must-0 page-break-page">
                <div class="content-block">
                    <h4>Family</h4>
                    <div class="content-section">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span class="print-label">Parents Spoken To:</span>
                                <span class="print-value"> {!! $results->ParentsSpokenTo; !!}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        @if($results->ParentsSpokenTo!='No')
                        <div class="form-group">
                            <span class="print-label">Time of Discussion:</span> 
                            <span class="print-value">{!! $results->DiscussionTime; !!}</span>
                        </div>
                        @endif
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        @if($results->ParentsSpokenTo!='No') 
                        <div class="form-group">
                            <span class="print-label">Matters Discussed :</span>
                        </div>
                        <div class="full-width">
                            <div class="ml-15">
                                <span class="print-value">{!! $results->MattersDiscussed; !!}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

        <div class="col-xs-12 col-sm-12 col-md-12 plr-must-0 page-break-page">
            <div class="content-block">
                <h4>Seen By:</h4>
                <div class="content-section">
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-50">
                        <div class="form-group mtb-must-0 custom-seen-by">
                            {!! $results->formatted_SeenBy !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>
        <div class="col-md-12 page-break-page plr-must-0">
            <div class="col-xs-3 col-md-3 col-sm-3 pull-left page-break-page plr-must-0 mtb-15">
                <ul class="plr-must-0" style="list-style: none;">
                    <li>Date : {!! date("d-m-Y",strtotime($results->AdmissionDate)); !!}</li>
                    <li>Place : {!! env('LOCATION') !!} </li>
                </ul>
            </div>
            <div class="col-xs-9 col-md-9 col-sm-9 page-break-page plr-must-0 pull-right">
                {!! $results->neonatal_consultant !!}
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $('.open-editor').click(function() {
      bootbox.confirm("If you edit this document, the changes will not be reflected in the main database and vice versa. Do you still want to continue?",function(confirmed){
        if(confirmed){
          var nicu_id = $('input[name="NicuId"]').val();
          var requestUrl = "{{ url('nicu-adm-abbreviated/'.Request::segment(2)) }}";
          $.ajax({
            type: "GET",
            url: '{{ url("nicu-adm-reports-editors") }}',
            data: {
              dataUrl: requestUrl,
              nicu_id: nicu_id
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
