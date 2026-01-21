@extends('print')
@section('content')
@php $public_url =url('public').'/'; @endphp
@if (isset($editor_gen) && $editor_gen)
<div class="editor_style">
  @include('editor_print')  
</div>
@endif
<div class="temp-container post-proforma">
  <div class="temp-row">
    <div class="col-md-12">
        <img src="{{ SiteHelpers::getPostnatalLogo($postnatalAdmission->pid) }}">
    </div>
    <div class="col-md-12 mt-10">
        <h3 class="print-head mt-0">Postnatal Admission Pro forma</h3>
    </div>
    <div class="col-md-12">
      <div class="content-block mt-must-0">
        <h4>Basic Details</h4>
        <div class="content-section">
          <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
              <span class="print-label">DOA:</span> 
              <span class="print-value">{!! date("d-m-Y", strtotime($postnatalAdmission->admission_date)); !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Name:</span> 
              <span class="print-value">{!! $postnatalAdmission->BabyName; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">DOB:</span> 
              <span class="print-value">{!! date("d-m-Y",strtotime($postnatalAdmission->DOB)); !!}</span>
            </div>
            @php $postnatalAdmission->TOB_TIME=(strlen($postnatalAdmission->TOB_TIME)==1) ? '0'.$postnatalAdmission->TOB_TIME:$postnatalAdmission->TOB_TIME;   @endphp
            @php $postnatalAdmission->TOB_MINS=(strlen($postnatalAdmission->TOB_MINS)==1) ? '0'.$postnatalAdmission->TOB_MINS:$postnatalAdmission->TOB_MINS;   @endphp           
            <div class="form-group">
              <span class="print-label">TOB:</span>
              <span class="print-value">{!! $postnatalAdmission->TOB_TIME .':'.$postnatalAdmission->TOB_MINS.':'.$postnatalAdmission->TOB_AM  !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Birth Order:</span> 
              <span class="print-value">{!! $postnatalAdmission->BirthOrder; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Referred From:</span> 
              <span class="print-value">{!! $postnatalAdmission->referredby; !!}</span>
            </div> 
            <div class="form-group">
              <span class="print-label">Reason for Referral:</span>
              <span class="print-value">{!! $postnatalAdmission->referralreason; !!}</span>
            </div>                                              
            @if(!empty($postnatalAdmission->Surgeon) && $postnatalAdmission->Surgeon != 'None')
            <div class="form-group">
              <span class="print-label">Surgeon:</span>
              <span class="print-value">{!! $postnatalAdmission->Surgeon; !!}</span>
            </div>
            @endif 
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6">
            @if(!empty($postnatalAdmission->SeenBy) && $postnatalAdmission->SeenBy != 'None')
            <div class="form-group">
              <span class="print-label">Consultant:</span>
              <span class="print-value">{!! ValuelistHelpers::mas_doctors_list($postnatalAdmission->SeenBy); !!}</span>
            </div>
            @endif
            <div class="form-group">
              <span class="print-label">{{ Lang::get('home.mrn') }}:</span>
              <span class="print-value">{!! $postnatalAdmission->BMrNo; !!}</span>
            </div> 
            @if(isset($ip_details->ip_number))
            <div class="form-group">
              <span class="print-label">{{ Lang::get('home.ip') }}:</span> 
              <span class="print-value"> {!! $ip_details->ip_number; !!} </span>
            </div> 
            @endif
            <div class="form-group">
              <span class="print-label" >Gestation (wks):</span>
              <span class="print-value">{!! SiteHelpers::decode_gestation($postnatalAdmission->Gestation) !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label" >Birth Weight(In Gms):</span>
              <span class="print-value"> {!! $postnatalAdmission->BirthWeight; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Sex:</span>
              <span class="print-value"> {!! $postnatalAdmission->Sex; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Age on admission:</span>
              <span class="print-value">{!! $postnatalAdmission->ageonadmissionindays; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">OFC(cm):</span> 
              <span class="print-value">{!! $postnatalAdmission->OFC; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Length(cm):</span> 
              <span class="print-value">{!! $postnatalAdmission->Length; !!}</span>
            </div> 
            <div class="form-group">
              <span class="print-label">CGA:</span>
              <span class="print-value">{!! SiteHelpers::decode_gestation($postnatalAdmission->admission_cg) !!}</span>
            </div> 
            <div class="form-group">
              <span class="print-label">Admission Type:</span> 
              <span class="print-value">{!! $postnatalAdmission->typeofcare; !!}</span>
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
              <span class="print-value">{!! ucwords($postnatalAdmission->MotherName); !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Age M:</span> 
              <span class="print-value">{!! $postnatalAdmission->MothercYear; !!}</span>
            </div> 
            <div class="form-group">
              <span class="print-label">Address1:</span> 
              <span class="print-value">{!! ucwords($postnatalAdmission->Address1); !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Address2:</span> 
              <span class="print-value">{!! ucwords($postnatalAdmission->Address2); !!}</span>
            </div>
           <!--  <div class="form-group">
              <span class="print-label">City:</span> 
              <span class="print-value">{!! ucwords($postnatalAdmission->City); !!}</span>
            </div> -->
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
              <span class="print-label">{{ Lang::get('home.mrn') }} M:</span>
              <span class="print-value">{!! (!empty($postnatalAdmission->MMrNo)) ? $postnatalAdmission->MMrNo :'Not registered'; !!}</span>
            </div> 
            <div class="form-group">
              <span class="print-label">Spoken Languages M:</span> 
              <span class="print-value">{!! (!empty($postnatalAdmission->MotherSpokenLanguages)) ? ucwords($postnatalAdmission->MotherSpokenLanguages) :'Not Mentioned'; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Address3:</span> 
              <span class="print-value">{!! ucwords($postnatalAdmission->Address3); !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Address4:</span> 
              <span class="print-value">{!! ucwords($postnatalAdmission->Address4); !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Contact No :</span> 
              <span class="print-value">{!! $postnatalAdmission->Mobile.' , '.$postnatalAdmission->PartnerContact; !!}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="content-block">
        <h4>Maternal History</h4>
        <div class="col-xs-12 col-sm-12 col-md-12 plr-must-0">
          <table cellspacing="3">
            <thead>
              <tr>
                <td><h5>Medical History</h5></td>
                <td><h5>Medications</h5></td> 
              </tr>
            </thead>
            <tbody>
              @if(isset($matarnalHistory) && count($matarnalHistory) > 0)
              @foreach ($matarnalHistory as $maternal_problem)
              @if(isset($matarnalProblemmaster[$maternal_problem->Problem]))
              <tr>
                <td>{!! $matarnalProblemmaster[$maternal_problem->Problem] !!}</td>
                <td>{!! $maternal_problem->Medication; !!}</td>
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
          <div class="col-xs-12 col-sm-12 col-md-12 plr-must-0">
            @if(isset($postnatalAdmission->Smoking) && !empty($postnatalAdmission->Smoking))
            <div class="form-group">
              <span class="print-label">Smoking:</span>
              <span class="print-value">  {!! $postnatalAdmission->Smoking; !!}</span>
            </div>
            @endif 
            @if(isset($postnatalAdmission->Alcohol) && !empty($postnatalAdmission->Alcohol))
            <div class="form-group">
              <span class="print-label">Alcohol:</span>
              <span class="print-value">{!! $postnatalAdmission->Alcohol; !!}</span>
            </div>
            @endif
            @if(isset($postnatalAdmission->Tobacco) && !empty($postnatalAdmission->Tobacco))
            <div class="form-group">
              <span class="print-label">Tobacco:</span> 
              <span class="print-value">{!! $postnatalAdmission->Tobacco; !!}</span>
            </div> 
            @endif
          </div>
        </div>
        <div class="col-md-12 plr-must-0">
          <table>
            <tbody>
              <tr>
                <td>
                  <div class="form-group">
                    <div>G {!! $postnatalAdmission->G_Value; !!}</div>
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <div>P {!! $postnatalAdmission->P_Value; !!}</div>
                  </div> 
                </td>
                <td>
                  <div class="form-group">
                    <div>L {!! $postnatalAdmission->L_Value; !!}</div>
                  </div>
                </td>
                <td>
                  <div class="form-group">
                    <div>A {!! $postnatalAdmission->A_Value; !!}</div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-md-12 plr-must-0 overflow-auto full-width">
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
              @foreach ($delivery_details as $delivery)
              <tr>
                <td>{!! $delivery->Year !!}</td>
                <td>{!! $delivery->Place !!}</td>
                <td>{!! $delivery->Delivery !!}</td>
                <td>{!! $delivery->Complications !!}</td>
                <td>{!! $delivery->Gender !!}</td>                                               
                <td>{!! $delivery->GA !!}</td>
                <td>{!! $delivery->BW !!}</td>
                <td>{!! $delivery->Health !!}</td>
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
              <span class="print-value"> {!! $postnatalAdmission->PlaceofSupervision; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Conception:</span> 
              <span class="print-value">{!! $postnatalAdmission->Conception; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Supervised:</span>
              <span class="print-value"> {!! $postnatalAdmission->Supervised; !!}</span>
            </div>
            @if(!empty($postnatalAdmission->LMP) && date("Y",strtotime($postnatalAdmission->LMP))!= 1970)  
            <div class="form-group">
              <span class="print-label">LMP:</span> 
              <span class="print-value">{!! date("d-m-Y",strtotime($postnatalAdmission->LMP)); !!}</span>
            </div>
            @endif
            @if(!empty($postnatalAdmission->EDDbyUSG) && date("Y",strtotime($postnatalAdmission->EDDbyUSG))!= 1970)  
            <div class="form-group">
              <span class="print-label">EDD by USG:</span>
              <span class="print-value">{!! date("d-m-Y",strtotime($postnatalAdmission->EDDbyUSG)); !!}</span>
            </div> 
            @endif
            @if(!empty($postnatalAdmission->EDDbyDates) && date("Y",strtotime($postnatalAdmission->EDDbyDates))!= 1970)  
            <div class="form-group">
              <span class="print-label">EDD by Dates:</span>
              <span class="print-value">{!! date("d-m-Y",strtotime($postnatalAdmission->EDDbyDates)); !!}</span>
            </div> 
            @endif
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
              <span class="print-label">Mother's BG:</span>
              <span class="print-value">{!! $postnatalAdmission->MotherBloodGroup; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Hepatitis B:</span>
              <span class="print-value">{!! $postnatalAdmission->HepatitisB; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">HIV:</span>
              <span class="print-value">{!! $postnatalAdmission->HIV; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">VDRL:</span>
              <span class="print-value">{!! $postnatalAdmission->VDRL; !!}</span>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        @if (isset($ultrascanGestation) && count($ultrascanGestation) > 0)
        <div class="col-md-12 plr-must-0">
          <h4>Antenatal USG & Doppler</h4>
          <table>
            <thead>
              <tr>
                <td><h5>Usg Gestation</h5></td>
                <td><h5>Usg Findings</h5></td>
              </tr>
            </thead>
            <tbody>
              @for ($i = 0; $i < count($ultrascanGestation); $i++)
              <tr>
                <td>{{ $ultrascanGestation[$i]->Gestation  }}</td> 
                <td>{{ $ultrascanGestation[$i]->Finding  }}</td>
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
            <span class="print-label">Complication During<br> Pregnancy : </span>
            <span class="print-value"> {!! $postnatalAdmission->PregnancyComplications; !!} </span>
          </div> 
        </div>
        @if($postnatalAdmission->PregnancyComplications != 'No')
        <div class="col-xs-12 col-sm-12 col-md-12">
          <table>
            <thead>
              <tr>
                <td><h5>Complication</h5></td>
                <td><h5>Treatment</h5></td>
              </tr>
            </thead>
            <tbody>
              @forelse($preganancyComplication as $complication)
              @if(isset($complicationMaster[$complication->Complication]) && !empty($complication->Treatment))
              <tr>
                <td>{!! $complicationMaster[$complication->Complication] !!}</td>    
                <td>{!! $complication->Treatment !!}</td>
              </tr>
              @endif
              @empty
              <tr>
                <td>Nil</td>
                <td>Nil</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        @endif 
        <div class="content-section">
          <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
              <span class="print-label">Antenatal Steroids:</span>
              <span class="print-value"> {!! $postnatalAdmission->AntenatalSteroids; !!}</span>
            </div> 
            @if($postnatalAdmission->AntenatalSteroids!='No')
            <div class="form-group">
              <span class="print-label">Last Dose Delivery Interval:</span>
              <span class="print-value">{!! $postnatalAdmission->LastDoseDeliveryInterval; !!}</span>
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
              <span class="print-value"> {!! $postnatalAdmission->ModeOfDelivery; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">PROM:</span>
              <span class="print-value">{!! $postnatalAdmission->PROM; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">PROM (hours):</span> 
              <span class="print-value">{!! $postnatalAdmission->DurationOfROM; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Maternal Pyrexia:</span>
              <span class="print-value">{!! $postnatalAdmission->MaternalPyrexia; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Liquor:</span>
              <span class="print-value"> {!! $postnatalAdmission->CommentOnLiquor; !!}</span>
            </div>
            @if($postnatalAdmission->Maternal_antibiotics_status=='Yes')
            @if(!empty($postnatalAdmission->MaternalAntibiotics))
            <div class="form-group">
              <span class="print-label"> MaternalAntibiotics:</span>
              <ul class="list-none">
                
            <?php try {
              ?>

                  @forelse(unserialize($postnatalAdmission->MaternalAntibiotics) as $maternalantibiotics)
                  <li> {!! $maternalantibiotics;  !!} </li>
                  @empty
                  <li>  Nil </li>
                  @endforelse 
              <?php 
            } catch (Exception $e) {
              ?>
              
              <?php 
            } ?>
                
              </ul> 
            </div>
            @endif
            <div class="form-group">
              <span class="print-label">Last Dose Time:</span>
              <span class="print-value">{!! $postnatalAdmission->TimeofLastDose; !!}</span>
            </div>
            @endif
            <div class="form-group">
              <span class="print-label">Labour:</span> 
              <span class="print-value">{!! $postnatalAdmission->Labour; !!}</span>
            </div> 
            <div class="form-group">
              <span class="print-label">Presentation:</span>
              <span class="print-value">{!! $postnatalAdmission->Presentation; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Cord Blood Gas:</span>
              <span class="print-value"> {!! $postnatalAdmission->CordBloodGas; !!}</span>
            </div> 
            @if($postnatalAdmission->CordBloodGas!='Not done' && $postnatalAdmission->CordBloodGas!='')  
            <div class="form-group">
              <span class="print-label">Cord pH:</span>
              <span class="print-value"> {!! $postnatalAdmission->CordpH; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Cord HCO3:</span> 
              <span class="print-value">{!! $postnatalAdmission->CordHCO3; !!}</span>
            </div>  
            <div class="form-group">
              <span class="print-label">Cord BE:</span>
              <span class="print-value">{!! $postnatalAdmission->CordBE; !!}</span>
            </div>
            @endif 
            <div class="form-group">
              <span class="print-label">Resuscitation:</span>
              <span class="print-value"> {!! $postnatalAdmission->Resuscitation; !!}</span>
            </div>
            @if($postnatalAdmission->Resuscitation!='No')
            <div class="form-group">
              <span class="print-label">Time Of 1st Gasp (sec):</span> 
              <span class="print-value">{!! $postnatalAdmission->TimeOf1stGasp; !!}</span>
            </div> 
            @endif
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6">
            @if(is_array($indication) && count($indication) > 0)
            <div class="form-group">
              <span class="print-label">Indication:</span>
              <span class="print-value">{!! implode(', ', $indication) !!}</span>
            </div>
            @endif
            <div class="form-group">
              <span class="print-label">Nature of Labour:</span> 
              <span class="print-value">{!! $postnatalAdmission->NatureofLabour; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">CTG Details:</span>
              <span class="print-value">{!! $postnatalAdmission->CTGDetails; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Fetal Distress:</span>
              <span class="print-value">{!! $postnatalAdmission->FoetalDistress; !!}</span>
            </div> 
            <div class="form-group">
              <span class="print-label">Gastric Aspirate:</span> 
              <span class="print-value">{!! $postnatalAdmission->GastricAspirate; !!}</span>
            </div>
            @if($postnatalAdmission->Resuscitation != 'No')
            <div class="form-group">
              <span class="print-label">Regular Respiration (sec):</span> 
              <span class="print-value">{!! $postnatalAdmission->RegularRespiration; !!}</span>
            </div> 
            @endif
          </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
          @if($postnatalAdmission->known_field == 1)
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
            <tr>
              <td>Total</td>
              <td> {!! $postnatalAdmission->Apgars1min; !!}</td>
              <td> {!! $postnatalAdmission->Apgars5min; !!}</td>
              <td> {!! $postnatalAdmission->Apgars10min; !!}</td>
              <td> {!! $postnatalAdmission->Apgars15min; !!}</td>
              <td> {!! $postnatalAdmission->Apgars20min; !!}</td>
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
              <span class="print-value">  {!! $postnatalAdmission->FacialOxygen; !!}</span>
            </div>                            
            <div class="form-group">
              <span class="print-label">PPV:</span>
              <span class="print-value"> {!! $postnatalAdmission->PPV; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Intubation:</span> 
              <span class="print-value">  {!! $postnatalAdmission->Intubation; !!}</span>
            </div>
            @if($postnatalAdmission->Intubation!='No')
            <div class="form-group">
              <span class="print-label">ETT Size (mm):</span> 
              <span class="print-value"> {!! $postnatalAdmission->ETTSize; !!}</span>
            </div>
            @if($postnatalAdmission->FacialOxygen!='No')
            <div class="form-group">
              <span class="print-label">Duration Of Oxygen (sec):</span> 
              <span class="print-value"> {!! $postnatalAdmission->DurationOfOxygen; !!}</span>
            </div>  
            @endif  
            @if($postnatalAdmission->PPV!='No')
            <div class="form-group">
              <span class="print-label">Duration Of PPV (sec):</span> 
              <span class="print-value">  {!! $postnatalAdmission->DurationOfPPV; !!}</span>
            </div>
            @endif  
            <div class="form-group">
              <span class="print-label">CPR:</span> 
              <span class="print-value">  {!! $postnatalAdmission->CPR; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Depth Of Insertion (cm):</span> 
              <span class="print-value">  {!! $postnatalAdmission->DepthOfInsertion; !!}</span>
            </div>   
            @endif 
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6">                         
            <div class="form-group">
              <span class="print-label">Drugs:</span>
              <span class="print-value">  {!! $postnatalAdmission->Drugs; !!}</span>
            </div>              
          </div>             
        </div>      
      </div>
      <div class="page-break"></div>
      <div class="content-block">
        <div class="topbar1">           
          <h4>Admission Details</h4> 
          <div class="content-section">                 
            <div class="col-xs-12 col-sm-6 col-md-6">
              <div class="form-group">
                <span class="print-label">Admitted From:</span> 
                <span class="print-value">{!! $postnatalAdmission->admitted_from; !!}</span>
              </div>                            
            </div>
          </div>
          <div class="content-section"> 
            <div class="col-xs-12 col-sm-6 col-md-6">
              <div class="form-group">
                @php $Ad_Time=(strlen($postnatalAdmission->admission_time_hour) == '1') ? '0'.$postnatalAdmission->admission_time_hour : $postnatalAdmission->admission_time_hour;  @endphp
                @php $Ad_MINS=(strlen($postnatalAdmission->admission_time_mins)=='1')   ? '0'.$postnatalAdmission->admission_time_mins : $postnatalAdmission->admission_time_mins;  @endphp
                @php $Ad_AM=$postnatalAdmission->admission_time_session;  @endphp
                @php $admission_time = $Ad_Time.':'.$Ad_MINS.':'.$Ad_AM;  @endphp
                <span class="print-label">Time of Admission:</span>
                <span class="print-value">@if(!is_null($Ad_Time)) {!! $admission_time; !!} @else N/A @endif</span>
              </div>
            </div>          
            <div class="clearfix"></div>            
            <div class="col-xs-12 col-sm-12 col-md-6">
              <div class="form-group">
                <span class="print-label">Major C/O:</span>
                <span class="print-value"> {!! $postnatalAdmission->major_complaints; !!}</span>
              </div>
            </div>
          </div>
          <div class="clearfix"></div> 
          <div class="col-xs-12 col-sm-6 col-md-6 topbar1">
            <h4>Initial Examination at Postnatal Ward</h4>  
          </div>  
          <div class="content-section">            
            <div class="col-xs-12 col-sm-6 col-md-6">                          
              <div class="form-group">
                <span class="print-label">BP:</span> 
                <span class="print-value">{!! $postnatalAdmission->systolic_bp; !!}</span>
              </div>                                                        
              <div class="form-group">
                <span class="print-label">Temperature:</span>
                <span class="print-value">{!! $postnatalAdmission->temperature; !!}</span>
              </div>                                                        
              <div class="form-group">
                <span class="print-label">Ventilation:</span>
                <span class="print-value">{!! ($postnatalAdmission->ventilation) ? "Yes" : "No"; !!}</span>
              </div> 
              @if($postnatalAdmission->ventilation == true)                                                       
              <div class="form-group">
                <span class="print-label">PIP:</span> 
                <span class="print-value">{!! $postnatalAdmission->pip; !!}</span>
              </div>
              @endif
              <div class="form-group">
                <span class="print-label">Chest:</span> 
                <span class="print-value">{!! $postnatalAdmission->chest_movement; !!}</span>
              </div>                                                        
              <div class="form-group">
                <span class="print-label">Malformation:</span> 
                <span class="print-value"></span>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="content-section">  
            <div class="col-xs-12 col-sm-6 col-md-6">
              <div class="form-group">
                <span class="print-label">HR in bpm:</span> 
                <span class="print-value">{!! $postnatalAdmission->hr; !!}</span>
              </div>
              <div class="form-group">
                <span class="print-label">Mean BP:</span>                    
                <span class="print-value">{!! $postnatalAdmission->mean_bp; !!}</span>
              </div>
              <div class="form-group">
                <span class="print-label">CFT:</span> 
                <span class="print-value">{!! $postnatalAdmission->cft; !!}</span>
              </div>
              @if($postnatalAdmission->ventilation == true)                                                       
              <div class="form-group">
                <span class="print-label">Mode:</span> 
                <span class="print-value">{!! $postnatalAdmission->mode; !!}</span>
              </div>
              <div class="form-group">
                <span class="print-label">PEEP:</span> 
                <span class="print-value">{!! $postnatalAdmission->peep; !!}</span>
              </div>
              <div class="form-group">
                <span class="print-label">Rate:</span> 
                <span class="print-value">{!! $postnatalAdmission->rate; !!}</span>
              </div>
              @endif  
              <div class="form-group">
                <span class="print-label">Color:</span> 
                <span class="print-value">{!! $postnatalAdmission->nicu_color; !!}</span>
              </div>                                                                                                               
            </div>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
              <span class="print-label">RR:</span> 
              <span class="print-value">{!! $postnatalAdmission->rr; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">SpO2:</span> 
              <span class="print-value">{!! $postnatalAdmission->spo2; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Fio2:</span> 
              <span class="print-value">{!! $postnatalAdmission->fio2; !!}</span>
            </div>
            @if($postnatalAdmission->ventilation == true)                                                       
            <div class="form-group">
              <span class="print-label">IT:</span> 
              <span class="print-value">{!! $postnatalAdmission->it; !!}</span>
            </div>
            @endif    
            <div class="form-group">
              <span class="print-label">Tone:</span> 
              <span class="print-value">{!! $postnatalAdmission->tone; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Malformation Type:</span> 
              <span class="print-value"></span>
            </div>
          </div>  
          <div class="content-section">                      
            <div class="col-xs-12 col-sm-12 col-md-6">
              <div class="form-group">
                <span class="print-label">Abnormalities:</span> 
                <span class="print-value">{!! $postnatalAdmission->abnormalities; !!}</span>
              </div> 
            </div>                        
          </div>  
        </div>             
      </div>
      <div class="content-block">
        <h4>Investigations On Admission</h4> 
        <div class="content-section"> 
          <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-group">
              <span class="print-label">Initial Blood Gas:</span>
              <span class="print-value"> {!! $postnatalAdmission->initialbloodgas; !!}</span>
            </div> 
            @if($postnatalAdmission->initialbloodgas != 'Not done' && $postnatalAdmission->initialbloodgas != 'Not indicated')                          
            <div class="form-group">
              <span class="print-label">pH:</span> 
              <span class="print-value">{!! $postnatalAdmission->ph; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">paO2:</span> 
              <span class="print-value">{!! $postnatalAdmission->pao2; !!}</span>
            </div>
            @endif 
            <div class="form-group">
              <span class="print-label">Initial X ray:</span>
              <span class="print-value">{!! $postnatalAdmission->initialxray; !!}</span>
            </div>
            @if($postnatalAdmission->initialxray=='Performed')
            @if(!empty($postnatalAdmission->xrayfindings))
            <div class="form-group">
              <span class="print-label">X ray findings:</span>
              <span class="print-value">{!! $postnatalAdmission->xrayfindings; !!}</span>
            </div> 
            @endif
            @if(!empty( $postnatalAdmission->ageofcxr))
            <div class="form-group">
              <span class="print-label">Age of X-ray:</span>
              <span class="print-value">{!! $postnatalAdmission->ageofcxr; !!}</span>
            </div>
            @endif
            @endif
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6">
            @if(!is_null($postnatalAdmission->initialbloodgas) && $postnatalAdmission->initialbloodgas != 'Not done' && $postnatalAdmission->initialbloodgas != 'Not indicated')  
            <div class="form-group">
              <span class="print-label">paCo2:</span> 
              <span class="print-value">{!! $postnatalAdmission->paco2; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">HCO3:</span>
              <span class="print-value">{!! $postnatalAdmission->hco3; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">BE:</span>
              <span class="print-value">{!! $postnatalAdmission->be; !!}</span>
            </div>
            @endif
            <div class="form-group">
              <span class="print-label">RBS:</span>
              <span class="print-value">{!! $postnatalAdmission->rbs; !!}</span>
            </div>
            @if(!is_null($postnatalAdmission->initialbloodgas) && $postnatalAdmission->initialbloodgas != 'Not done' && $postnatalAdmission->initialbloodgas != 'Not indicated')  
            <div class="form-group">
              <span class="print-label">Hct:</span>
              <span class="print-value"> {!! $postnatalAdmission->hct; !!}</span>
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
              <span class="print-value">{!! $postnatalAdmission->uac_status; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">UVC:</span>
              <span class="print-value">{!! $postnatalAdmission->uvc_status; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Sepsis Screen:</span> 
              <span class="print-value">{!! $postnatalAdmission->sepsisscreen; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Indications:</span> 
              <span class="print-value">{!! $postnatalAdmission->indications; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Fluids (ml/kg/day):</span> 
              <span class="print-value">{!! $postnatalAdmission->fluids; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Investigations:</span>
              <span class="print-value">{!! $postnatalAdmission->investigations; !!}</span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6">
            @if($postnatalAdmission->uac_status!='No' && !empty($postnatalAdmission->uac_status) && !empty($postnatalAdmission->uac_position))
            <div class="form-group">
              <span class="print-label">UAC Position:</span>
              <span class="print-value">{!! $postnatalAdmission->uac_position; !!}</span>
            </div>
            @endif
            @if($postnatalAdmission->uvc_status!='No' && !empty($postnatalAdmission->uvc_status) && !empty($postnatalAdmission->uvc_position))
            <div class="form-group">
              <span class="print-label">UVC Position:</span> 
              <span class="print-value">{!! $postnatalAdmission->uvc_position; !!}</span>
            </div>
            @endif
            <div class="form-group">
              <span class="print-label">Vitamin K:</span> 
              <span class="print-value">{!! $postnatalAdmission->VitaminK; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Dose:</span> 
              <span class="print-value">{!! $postnatalAdmission->DoseVitK; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">Route:</span> 
              <span class="print-value">{!! $postnatalAdmission->RouteVitK; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label">NBM:</span> 
              <span class="print-value"></span>
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 plr-must-0">
          @if((strlen($postnatalAdmission->ivantibiotic) > 3) && is_array(json_decode($postnatalAdmission->ivantibiotic)) && count(json_decode($postnatalAdmission->ivantibiotic)) > 0)
          <div class="form-group">
            <table>
              <th class="pl-must-15">IV Antibiotic:</th>
              @php $i=1; $lenthofiv=count(json_decode($postnatalAdmission->ivantibiotic)) @endphp
              @foreach(json_decode($postnatalAdmission->ivantibiotic) as $ivantibiotic)
              @if(!empty($antibiotic_data[$ivantibiotic]))
              <tr><td>{!! $i.' ) ' !!}{!! $antibiotic_data[$ivantibiotic]; !!} @if($lenthofiv != $i) , @endif</td></tr>
              @php $i++; @endphp
              @endif
              @endforeach
            </table>
          </div>
          @endif
        </div>
      </div>
      <div class="page-break"></div> 
      @if(count(json_decode($postnatalAdmission->differentialdiagnosis)) > 0 || count(json_decode($postnatalAdmission->additional_diagnosis)) > 0)                                                              
      <div class="content-block"> 
        <h4>Differential Diagnosis</h4>
        <div class="col-xs-12 col-sm-12 col-md-12 topbar">
          <div class="form-group">
            <div class="text-justify"> 
              @if(count(json_decode($postnatalAdmission->differentialdiagnosis)) > 0)
              @forelse(json_decode($postnatalAdmission->differentialdiagnosis) as $Diagnosis)
              {!! $icd_master[$Diagnosis].'-'.$Diagnosis  !!}<br/>
              @empty  
              @endforelse
              @endif
              @if(count(json_decode($postnatalAdmission->additional_diagnosis)) > 0)  
              @forelse(json_decode($postnatalAdmission->additional_diagnosis) as $additional_diagnosis)
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
              <span class="print-value">{!! $postnatalAdmission->plan; !!}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="page-break"></div> 
      <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0 page-break-page">

        <div class="content-block">
          <h4>Family</h4>
          <div class="content-section">
            <div class="col-xs-12 col-sm-6 col-md-6">
              <div class="form-group">
                <span class="print-label">Parents Spoken To:</span> 
                <span class="print-value"> {!! $postnatalAdmission->parents_spoken; !!}</span>
              </div> 
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
              @if($postnatalAdmission->parents_spoken != 'No')
              @php  @endphp
              @php $pdiscussion_hrs     = (strlen($postnatalAdmission->pdiscussion_hrs) == 2) ? $postnatalAdmission->pdiscussion_hrs : '0'.$postnatalAdmission->pdiscussion_hrs @endphp
              @php $pdiscussion_min     = (strlen($postnatalAdmission->pdiscussion_min) == 2) ? $postnatalAdmission->pdiscussion_min : '0'.$postnatalAdmission->pdiscussion_min @endphp
              @php $discussion_time = $pdiscussion_hrs.':'.$pdiscussion_min.':'.$postnatalAdmission->pdiscussion_session @endphp
              <div class="form-group">
                <span class="print-label">Time of Discussion:</span> 
                <span class="print-value"> @if(!is_null($postnatalAdmission->pdiscussion_hrs)) {!! ($discussion_time)  !!} @else N/A @endif</span>
              </div>
              @endif
            </div>
          </div> 
          <div class="print-content">
            <div class="col-xs-12 col-sm-12 col-md-6">
              @if($postnatalAdmission->parents_spoken != 'No')  
              <div class="form-group">
                <span class="print-label">Matters Discussed:</span>
                <span class="print-value">{!! $postnatalAdmission->matters_discussed; !!} </span>
              </div>
              @endif 
            </div>
          </div> 
        </div>
      </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
      <div class="col-md-12 mt-15">
        <div class="col-xs-3 col-sm-3 col-md-3 pull-left plr-must-0">
          <p class=" col-md-11 plr-must-0">Date : <b>{{ date('d-m-Y') }}</b></p>
          <p class=" col-md-11 plr-must-0"> Place: <b>Salem </b></p> 
        </div>
        <div class="col-xs-9 col-sm-9 col-md-9 pull-right text-center font-bold">
            {!! $postnatalAdmission->neonatal_consultant !!}   
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
      var requestUrl = "{{ url('postnatal-abbreviated/'.Request::segment(2)) }}";
      $.ajax({
          type: "GET",
          url: '{{ url("postnatal-reports-editors") }}',
          data: {
              dataUrl: requestUrl
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

