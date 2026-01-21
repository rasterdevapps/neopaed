@extends('print')
@section('content')
@php $public_url =url('public').'/'; @endphp

@if (isset($editor_gen) && $editor_gen)
<div class="editor_style">
@include('editor_print')  
</div>
@endif

<div class="fix-print neonatal">
  <div class="temp-container">
    <div class="temp-row">
      <div class="col-md-12 mt-10">
        <div class="col-md-4 col-sm-4 col-xs-4 custom-padding-0">
          <img src="{{ ValuelistHelpers::printPagelogo(@$results->BMrNo) }}">
        </div>
      </div>
      <div class="col-md-12 mt-10">
        <div class="col-md-12 col-sm-12 col-xs-12 custom-padding-0">
          <h3 class="print-head mt-0">Neonatal Pro forma</h3>
        </div>
      </div>
      {{ Form::hidden('AdmissionId', $results->AdmissionId) }}
      {{ Form::hidden('NeonatalId', $results->NeonatalId) }}
      <div class="col-md-12">
          <div class="content-block mt-must-0">
            <h4>Basic Details</h4>
            <div class="content-section">                            
              <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                  <div>
                    <span class="print-label">Date:</span>
                    <span class="print-value"> {!! date("d-m-Y",strtotime($results->TestDate)); !!} </span>
                  </div>
                </div>
                <div class="form-group">
                  <div>
                    <span class="print-label">Name:</span>
                    <span class="print-value">{!! $results->BabyName; !!}</span>
                  </div>
                </div>
                <div class="form-group">
                  <div>
                    <span class="print-label">DOB:</span>
                    <span class="print-value">{!! date("d-m-Y",strtotime($results->DOB)); !!}</span>
                  </div>
                </div>
                <div class="form-group">
                  @php $results->TOB_TIME=(strlen($results->TOB_TIME)==1) ? '0'.$results->TOB_TIME:$results->TOB_TIME;  @endphp
                  @php 
                    if(isset($results->TOB_MINS) && $results->TOB_MINS == 'N/A')
                      $results->TOB_MINS = '00';
                    $results->TOB_MINS=(strlen($results->TOB_MINS)==1) ? '0'.$results->TOB_MINS:$results->TOB_MINS;  
                  @endphp
                    <div>
                      <span class="print-label">Time of Birth:</span>
                      <span class="print-value">{!! $results->TOB_TIME.' : '.$results->TOB_MINS.' : '.$results->TOB_AM; !!}</span>
                    </div>
                </div>
                <div class="form-group">
                  <div>
                    <span class="print-label">Birth Order:</span>
                    <span class="print-value"> {!! $results->BirthOrder; !!}</span>
                  </div>
                </div>
                @if(!empty($results->temp_neonatal_consultant))
                  <div class="form-group">
                    <div>
                      <span class="print-label">Attending Consultant:</span>
                      <span class="print-value">{!! $results->temp_neonatal_consultant; !!}</span>
                      <br />
                    </div>
                  </div>
                @endif
              </div>       

              <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                  <div>
                    <span class="print-label">{{ Lang::get('home.mrn') }}:</span>
                    <span class="print-value"> {!! $results->BMrNo; !!}</span>
                  </div>
                </div>
                <div class="form-group">
                  <div>
                    <span class="print-label">Sex:</span>
                    <span class="print-value"> {!! $results->Sex; !!}</span>
                  </div>
                </div>
                <div class="form-group">
                  <div>
                    <span class="print-label">Birth Weight(In Gms):</span>
                    <span class="print-value"> {!! $results->BirthWeight; !!}</span>
                  </div>
                </div>
                <div class="form-group">
                  <div>
                    <span class="print-label">Gestation (wks):</span>
                    <span class="print-value"> {!! $results->Gestation; !!}</span>
                  </div>
                </div>
                <div class="form-group">
                  <div>
                    <span class="print-label">OFC (cm):</span>
                    <span class="print-value"> {!! $results->OFC; !!}</span>
                  </div>
                </div>
                <div class="form-group">
                  <div>
                    <span class="print-label">Length (cm):</span>
                    <span class="print-value"> {!! $results->Length; !!}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
      
          <div class="content-block">
            <h4>Maternal Details</h4>
            <div class="content-section">   
              <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                  <div>
                    <span class="print-label">Name M:</span>
                    <span class="print-value">{!! $results->MotherName; !!}</span>
                  </div>
                </div>
                <div class="form-group">
                  <div>
                    <span class="print-label">Age M:</span>
                    <span class="print-value">{!! $results->MothercYear; !!}</span>
                  </div>
                </div>
                <div class="form-group">
                  <div>
                    <span class="print-label">Address1:</span>
                    <span class="print-value">{!! $results->Address1; !!}</span>
                  </div>
                </div>
                <div class="form-group">
                  <div>
                    <span class="print-label">Address2:</span>
                    <span class="print-value">{!! $results->Address2; !!}</span>
                  </div>
                </div>
                <!-- <div class="form-group">
                  <div>
                    <span class="print-label">City:</span>
                    <span class="print-value">{!! $results->City; !!}</span>
                  </div>
                </div> -->
              </div>

              <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                  <div>
                    <span class="print-label">{{ Lang::get('home.mrn') }} M:</span>
                    <span class="print-value">{!! (!empty($results->MMrNo)) ? $results->MMrNo :'Not Register'; !!}</span>
                  </div>
                </div>
                <div class="form-group">
                  <div>
                    <span class="print-label">Address3:</span>
                    <span class="print-value">{!! $results->Address3; !!}</span>
                  </div>
                </div>
                <div class="form-group">
                  <div>
                    <span class="print-label">Address4:</span>
                    <span class="print-value">{!! $results->Address4; !!}</span>
                  </div>
                </div>
                <div class="form-group">
                  <div>
                    <span class="print-label">Contact No :</span>
                    <span class="print-value">{!! $results->Mobile.' , '.$results->PartnerContact; !!}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
                            
          <div class="content-block">
            <h4>Maternal History</h4>
            <div class="col-md-12">
              <div class="col-xs-12 col-sm-6 col-md-6 pl-must-0">
                <table class="table" cellspacing="3">
                  <thead>
                    <tr>
                      <th class="col-xs-12 col-sm-6 col-md-6 wrap">Medical History</th>
                      <th class="col-xs-12 col-sm-6 col-md-6">Medications</th>
                    </tr>
                  </thead>
                  <tbody>     
                    @if (isset($pbm_data) && count($pbm_data) > 0)
                      @foreach ($pbm_data as $data)
                        @if($data['Problem']!=0 && isset($probs[$data['Problem']]))
                          <tr>
                            <td>{!! $probs[$data['Problem']]; !!}</td>
                            <td>{!! title_case($data['Medication']); !!}</td>
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

              <div class="col-xs-12 col-sm-6 col-md-6 pr-must-0 plr-sm-0 overflow-auto">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Gravida</th>
                      <th>Para</th>
                      <th>Livebirth</th>
                      <th>Abortion</th>
                      <th></th>
                    </tr>
                  </thead>  
                  <tbody>
                    <tr>
                      @if(!empty($results->G_Value))
                        <td> {!! $results->G_Value !!}</td>
                      @else
                        <td> Nil </td>
                      @endif

                      @if(!empty($results->P_Value))
                        <td>{!! $results->P_Value !!}</td>
                      @else
                        <td> Nil </td>
                      @endif

                      @if(!empty($results->L_Value ))
                        <td> {!! $results->L_Value !!}</td>
                      @else
                        <td> Nil </td>
                      @endif

                      @if(!empty($results->A_Value))
                        <td>{!! $results->A_Value !!}</td>
                      @else
                       <td> Nil </td>
                      @endif
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-md-12 col-xs-12 overflow-auto">
              <table class="table" cellspacing="3">
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
                  @if(isset($delivery_details) && count($delivery_details) > 0)
                    @foreach ($delivery_details as $com_data)
                    @if (!empty($com_data['Year']))
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
                  @endif
                    @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>

          <div class="content-block">
            <h4>Current Pregnancy</h4>
            <div class="content-section">   
              <div class="col-md-12 plr-must-0">
                <div class="col-xs-12 col-sm-6 col-md-6">
                  <div class="form-group">
                    <div>
                      <span class="print-label">Conception:</span>
                      <span class="print-value">{!! $results->Conception; !!}</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <div>
                      <span class="print-label">Supervised:</span>
                      <span class="print-value">{!! $results->Supervised; !!}</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <div>
                      <span class="print-label">Place of Supervision:</span>
                      <span class="print-value">{!! is_numeric($results->PlaceofSupervision) ? ValuelistHelpers::mas_referral_list($results->PlaceofSupervision) : $results->PlaceofSupervision; !!}</span>
                    </div>
                  </div>
                  @if(!empty($results->LMP) && date("Y",strtotime($results->LMP))!= 1970)
                  <div class="form-group">
                    <div>
                      <span class="print-label">LMP:</span>
                      <span class="print-value">{!! date("d-m-Y",strtotime($results->LMP)); !!}</span>
                    </div>
                  </div>
                  @endif

                  @if(!empty($results->EDDbyUSG) && date("Y",strtotime($results->EDDbyUSG))!= 1970)
                  <div class="form-group">
                    <div>
                      <span class="print-label">EDD by USG:</span>
                      <span class="print-value">{!! date("d-m-Y",strtotime($results->EDDbyUSG)); !!}</span>
                    </div>
                  </div>
                  @endif

                  @if(!empty($results->EDDbyDates) && date("Y",strtotime($results->EDDbyDates))!= 1970)
                  <div class="form-group">
                    <div>
                      <span class="print-label">EDD by Dates:</span>
                      <span class="print-value">{!! date("d-m-Y",strtotime($results->EDDbyDates)); !!}</span>
                    </div>
                  </div>
                  @endif
                  <div class="form-group">
                    <div>
                      <span class="print-label">Other Investigations:</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="ml-15">
                      <span class="print-value full-width-must">{!! $results->OtherInvestigations; !!}</span>
                    </div>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 text">
                  <div class="form-group">
                    <div>
                      <span class="print-label">Mother's Blood Group:</span>
                      <span class="print-value">{!! $results->MotherBloodGroup; !!}</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <div>
                      <span class="print-label">Baby's Blood Group:</span>
                      <span class="print-value">{!! $results->BabyBloodGroup; !!}</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <div>
                      <span class="print-label">HIV:</span>
                      <span class="print-value">{!! $results->HIV; !!}</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <div>
                      <span class="print-label">Hepatitis B:</span>
                      <span class="print-value">{!! $results->HepatitisB; !!}</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <div>
                      <span class="print-label">VDRL:</span>
                      <span class="print-value">{!! $results->VDRL; !!}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="content-block">
            <h4>Antenatal Details</h4>

            <div class="col-xs-12 col-sm-6 col-md-6">
              <div class="form-group">
                <div ><span class="print-label label-increase">Complication During Pregnancy:</span>
                <span class="print-value value-decrease">{!! $results->PregnancyComplications; !!}</span></div>
              </div>
              <table>
                <thead>
                  <tr>
                    <td><h5 class="mtb-0"><b>Complication</b></h5></td>
                    <td><h5 class="mtb-0"><b>Treatment</b></h5></td>
                  </tr>
                </thead>
                <tbody>
                  @if($results->PregnancyComplications=='Yes')
                    @if (isset($complication) && count($complication) > 0)
                      @foreach ($complication as $data)
                        @if(isset($complication_master[$data['Complication']]))
                          <tr>
                            <td>{!! $complication_master[$data['Complication']] !!}</td>
                            <td>{!! $data['Treatment']; !!}</td>
                          </tr>
                        @endif
                      @endforeach
                    @endif
                  @else
                    <tr>
                      <td>None</td>
                      <td>None</td>
                    </tr>
                  @endif
                </tbody>
              </table>
                <div class="form-group">
                  <div ><span class="print-label label-increase">Antenatal Steroids:</span>
                  <span class="print-value value-decrease">{!! $results->AntenatalSteroids; !!}</span></div>
                </div>
                <div class="form-group">
                  <div><span class="print-label label-increase">Last Dose Delivery Interval:</span>
                  <span class="print-value value-decrease">{!! $results->LastDoseDeliveryInterval; !!}</span></div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
              <table>
                <thead>
                  <tr>
                    <td><b>Usg Date</b></td>
                    <td><b>Usg Gestation</b></td>
                    <td><b>Usg Findings</b></td>
                  </tr>
                </thead>
                <tbody>
                  @if (isset($usg_scaning) && count($usg_scaning) > 0)
                    @for ($i = 0; $i < count($usg_scaning); $i++)
                      @if(!empty($usg_scaning[$i]['date']) || !empty($usg_scaning[$i]['findings']))
                        <tr>
                          <td>{{ (isset($usg_scaning[$i]['date']) && !empty($usg_scaning[$i]['date']) && !is_null($usg_scaning[$i]['date'])) ? date('d-m-Y', strtotime($usg_scaning[$i]['date'])) : "" }}</td>
                          <td>{{ (isset($usg_scaning[$i]['gestation']) && !empty($usg_scaning[$i]['gestation']) && !is_null($usg_scaning[$i]['gestation'])) ? $usg_scaning[$i]['gestation'] .' Weeks' : '' }}</td>
                          <td>{{ $usg_scaning[$i]['findings'] }}</td>
                        </tr>
                      @endif  
                    @endfor
                    @else
                    <tr>
                      <td colspan="2" class="text-center">N/A</td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
                      
          <div class="content-block">
            <h4>Labour & delivery</h4>
            <div class="content-section">   
              <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                  <div ><span class="print-label">Delivery Mode:</span>
                  <span class="print-value">{!! $results->ModeOfDelivery; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">PROM:</span>
                  <span class="print-value">{!! $results->PROM; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">PROM (hrs):</span>
                  <span class="print-value">{!! $results->DurationOfROM; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Maternal Pyrexia:</span>
                  <span class="print-value">{!! $results->MaternalPyrexia; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Liquor:</span>
                  <span class="print-value">{!! $results->CommentOnLiquor; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Labour:</span>
                  <span class="print-value">{!! $results->Labour; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Presentation:</span>
                  <span class="print-value">{!! $results->Presentation; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Cord Blood Gas:</span>
                  <span class="print-value">{!! $results->CordBloodGas; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Cord pH:</span>
                  <span class="print-value">{!! $results->CordpH; !!}</span></div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                  <div ><span class="print-label">Cord HCO3:</span>
                  <span class="print-value">{!! $results->CordHCO3; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Cord BE:</span>
                  <span class="print-value">{!! $results->CordBE; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Resuscitation:</span>
                  <span class="print-value">{!! $results->Resuscitation; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Time Of 1st Gasp (min):</span>
                  <span class="print-value">{!! $results->TimeOf1stGasp; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Regular Respiration (min):</span>
                  <span class="print-value">{!! $results->RegularRespiration; !!}</span></div>
                </div>
                @if(isset($results->Indication) && !empty($results->Indication))
                  <div class="form-group">
                    <div ><span class="print-label">Indication:</span>
                    <span class="print-value">{!! $results->Indication; !!}</span></div>
                  </div>
                @endif
                <div class="form-group">
                  <div ><span class="print-label">Last Dose Time:</span>
                  <span class="print-value">{!! $results->TimeofLastDose; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Nature of Labour:</span>
                  <span class="print-value">{!! $results->NatureofLabour; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">CTG Details:</span>
                  <span class="print-value">{!! $results->CTGDetails; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Gastric Aspirate:</span>
                  <span class="print-value">{!! $results->GastricAspirate; !!}</span></div>
                </div>
              </div>
            </div>
          </div>

          @if($results->known_field ==1)
            <div class="content-block">
              <h4>Apgar</h4>
                <div class="content-section">
                  <div>
                    <table class="table">
                      <tr>
                        <td><h6>Apgar</h6></td>
                        <td><strong>1 min</strong></td>
                        <td><strong>5 mins</strong></td>
                        <td><strong>10 mins</strong></td>
                        @if ($results->Colour15 > 0 || $results->HR15 > 0 || $results->Reflex15 > 0 || $results->Tone15 > 0 || $results->Respiration15 > 0)
                        <td><strong>15 mins</strong></td>
                        @endif
                        @if ($results->Colour20 > 0 || $results->HR20 > 0 || $results->Reflex20 > 0 || $results->Tone20 > 0 || $results->Respiration20 > 0)
                        <td><strong>20 mins</strong></td>
                        @endif
                      </tr>
                      <tr>
                        <td>Colour</td>
                        <td> {!! $results->Colour1 > 0 ? $results->Colour1 : 'N/A'; !!}</td>
                        <td> {!! $results->Colour5 > 0 ? $results->Colour5 : 'N/A'; !!}</td>
                        <td> {!! $results->Colour10 > 0 ? $results->Colour10 : 'N/A'; !!}</td>
                        @if ($results->Colour15 > 0 || $results->HR15 > 0 || $results->Reflex15 > 0 || $results->Tone15 > 0 || $results->Respiration15 > 0)
                        <td> {!! $results->Colour15 > 0 ? $results->Colour15 : 'N/A'; !!}</td>
                        @endif
                        @if ($results->Colour20 > 0 || $results->HR20 > 0 || $results->Reflex20 > 0 || $results->Tone20 > 0 || $results->Respiration20 > 0)
                        <td> {!! $results->Colour20 > 0 ? $results->Colour20 : 'N/A'; !!}</td>
                        @endif
                      </tr>
                      <tr>
                        <td>HR</td>
                        <td> {!! $results->HR1 > 0 ? $results->HR1 : 'N/A'; !!}</td>
                        <td> {!! $results->HR5 > 0 ? $results->HR5 : 'N/A'; !!}</td>
                        <td> {!! $results->HR10 > 0 ? $results->HR10 : 'N/A'; !!}</td>
                        @if ($results->Colour15 > 0 || $results->HR15 > 0 || $results->Reflex15 > 0 || $results->Tone15 > 0 || $results->Respiration15 > 0)
                        <td> {!! $results->HR15 > 0 ? $results->HR15 : 'N/A'; !!}</td>
                        @endif
                        @if ($results->Colour20 > 0 || $results->HR20 > 0 || $results->Reflex20 > 0 || $results->Tone20 > 0 || $results->Respiration20 > 0)
                        <td> {!! $results->HR20 > 0 ? $results->HR20 : 'N/A'; !!}</td>
                        @endif
                      </tr>
                      <tr>
                        <td>Reflex</td>
                        <td> {!! $results->Reflex1 > 0 ? $results->Reflex1 : 'N/A'; !!}</td>
                        <td> {!! $results->Reflex5 > 0 ? $results->Reflex5 : 'N/A'; !!}</td>
                        <td> {!! $results->Reflex10 > 0 ? $results->Reflex10 : 'N/A'; !!}</td>
                        @if ($results->Colour15 > 0 || $results->HR15 > 0 || $results->Reflex15 > 0 || $results->Tone15 > 0 || $results->Respiration15 > 0)
                        <td> {!! $results->Reflex15 > 0 ? $results->Reflex15 : 'N/A'; !!}</td>
                        @endif
                        @if ($results->Colour20 > 0 || $results->HR20 > 0 || $results->Reflex20 > 0 || $results->Tone20 > 0 || $results->Respiration20 > 0)
                        <td> {!! $results->Reflex20 > 0 ? $results->Reflex20 : 'N/A'; !!}</td>
                        @endif
                      </tr>
                      <tr>
                        <td>Tone</td>
                        <td> {!! $results->Tone1 > 0 ? $results->Tone1 : 'N/A'; !!}</td>
                        <td> {!! $results->Tone5 > 0 ? $results->Tone5 : 'N/A'; !!}</td>
                        <td> {!! $results->Tone10 > 0 ? $results->Tone10 : 'N/A'; !!}</td>
                        @if ($results->Colour15 > 0 || $results->HR15 > 0 || $results->Reflex15 > 0 || $results->Tone15 > 0 || $results->Respiration15 > 0)
                        <td> {!! $results->Tone15 > 0 ? $results->Tone15 : 'N/A'; !!}</td>
                        @endif
                        @if ($results->Colour20 > 0 || $results->HR20 > 0 || $results->Reflex20 > 0 || $results->Tone20 > 0 || $results->Respiration20 > 0)
                        <td> {!! $results->Tone20 > 0 ? $results->Tone20 : 'N/A'; !!}</td>
                        @endif
                      </tr>
                      <tr>
                        <td>Respiration</td>
                        <td> {!! $results->Respiration1 > 0 ? $results->Respiration1 : 'N/A'; !!}</td>
                        <td> {!! $results->Respiration5 > 0 ? $results->Respiration5 : 'N/A'; !!}</td>
                        <td> {!! $results->Respiration10 > 0 ? $results->Respiration10 : 'N/A'; !!}</td>
                        @if ($results->Colour15 > 0 || $results->HR15 > 0 || $results->Reflex15 > 0 || $results->Tone15 > 0 || $results->Respiration15 > 0)
                        <td> {!! $results->Respiration15 > 0 ? $results->Respiration15 : 'N/A'; !!}</td>
                        @endif
                        @if ($results->Colour20 > 0 || $results->HR20 > 0 || $results->Reflex20 > 0 || $results->Tone20 > 0 || $results->Respiration20 > 0)
                        <td> {!! $results->Respiration20 > 0 ? $results->Respiration20 : 'N/A'; !!}</td>
                        @endif
                      </tr>
                      <tr></tr>
                      <tr>
                        <td>Total</td>
                        <td> {!! $results->Apgars1min > 0 ? $results->Apgars1min : 'N/A'; !!}</td>
                        <td> {!! $results->Apgars5min > 0 ? $results->Apgars5min : 'N/A'; !!}</td>
                        <td> {!! $results->Apgars10min > 0 ? $results->Apgars10min : 'N/A'; !!}</td>
                        @if ($results->Colour15 > 0 || $results->HR15 > 0 || $results->Reflex15 > 0 || $results->Tone15 > 0 || $results->Respiration15 > 0)
                        <td> {!! $results->Apgars15min > 0 ? $results->Apgars15min : 'N/A'; !!}</td>
                        @endif
                        @if ($results->Colour20 > 0 || $results->HR20 > 0 || $results->Reflex20 > 0 || $results->Tone20 > 0 || $results->Respiration20 > 0)
                        <td> {!! $results->Apgars20min > 0 ? $results->Apgars20min : 'N/A'; !!}</td>
                        @endif
                      </tr>
                    </table>
                  </div>
                </div>
            </div>          
          @endif

          <div class="content-block">
            <h4>Resuscitation Details</h4>
            <div class="content-section">
              <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                  <div ><span class="print-label">Facial Oxygen:</span>
                  <span class="print-value"> {!! $results->FacialOxygen; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Duration Of Oxygen (min):</span>
                  <span class="print-value"> {!! $results->DurationOfOxygen; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">PPV:</span>
                  <span class="print-value"> {!! $results->PPV; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Duration Of PPV (min):</span>
                  <span class="print-value"> {!! $results->DurationOfPPV; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Intubation:</span>
                  <span class="print-value"> {!! $results->Intubation; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">ETT Size (mm):</span>
                  <span class="print-value"> {!! ($results->ETTSize > 0) ? $results->ETTSize : 'N/A'; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Depth Of Insertion (cm):</span>
                  <span class="print-value"> {!! $results->DepthOfInsertion; !!}</span></div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                  <div ><span class="print-label">CPR:</span>
                  <span class="print-value"> {!! $results->CPR; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Drugs:</span>
                  <span class="print-value">  {!! $results->Drugs; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Vitamin K:</span>
                  <span class="print-value"> {!! $results->VitaminK; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Dose VitK:</span>
                  <span class="print-value"> {!! $results->DoseVitK; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Route VitK:</span>
                  <span class="print-value"> {!! $results->RouteVitK; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Malformation:</span>
                  <span class="print-value"> {!! $results->Malformation; !!}</span></div>
                </div>
                <div class="form-group">
                  <div ><span class="print-label">Malformation Type:</span>
                  <span class="print-value"> {!! $results->MalformationType; !!}</span></div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0 page-break-page">
          <div class="content-block">
            <div class="col-xs-12 col-sm-12 col-md-12 plr-must-0">
              <div class="form-group">
                <div>
                  <span class="print-label full-width-must">Summary of Initial Examination Following Birth :</span>
                </div>
              </div>
              <div class="full-width">
                <div class="ml-15">
                  <span class="print-value">{!! $results->InitialExamination; !!}</span>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 plr-must-0">
              <div class="form-group">
                <div>
                  <span class="print-label full-width-must">Plan :</span>
                </div>
              </div>
              <div class="full-width">
                <div class="ml-15">
                  <span class="print-value">{!! $results->PLAN; !!}</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
            <div class="col-xs-3 col-sm-3 col-md-3 mt-15 plr-must-0">
              <p class="col-xs-12 col-sm-7 col-md-7 plr-must-0 plr-sm-0">Completed on : <b>{!! date("d-m-Y",strtotime($results->TestDate)); !!}</b></p>
              <p class="col-xs-12 col-sm-7 col-md-7 plr-must-0 plr-sm-0">Printed on: <b>{{ date('d-m-Y') }} </b></p>
              <p class="col-xs-12 col-sm-7 col-md-7 plr-must-0 plr-sm-0">Place: <b>{{ env('LOCATION') }} </b></p>
            </div>
            <div class="col-xs-9 col-sm-9 col-md-9 pull-right text-center pr-sm-0">
              {!! $results->neonatal_consultant !!}
            </div>                
          </div>
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
      var neonatal_id = $('input[name="NeonatalId"]').val();
      var requestUrl = "{{ url('neonatal-abbreviated/'.Request::segment(2)) }}";
      $.ajax({
          type: "GET",
          url: '{{ url("neonatal-reports-editors") }}',
          data: {
              dataUrl: requestUrl,
              neonatal_id: neonatal_id
          },
          cache: false,
          dataType: "json",
          success: function(responseText) {
              window.location = requestUrl + '?id=' + neonatal_id;
          },
          error: function(response) {}
      });
    }
  });
}); 
</script>
@endsection
