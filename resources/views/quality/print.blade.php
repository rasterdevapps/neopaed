@extends('print')
@section('content')
<div class="temp-container quality-indicator">
  	<div class="temp-row">
    	<div class="col-md-12">
      		<img src="{{ ValuelistHelpers::printPagelogo() }}" >
        </div>
      <div class="col-md-12">
      		<h3 class="print-head mt-0">Quality Indicator</h3>
    	</div>
    	<div class="col-md-12">
      		<div class="content-block mt-must-0">
        		<h4>Demographic Details</h4>
        		<div class="content-section">
          			<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label">{{ Lang::get('home.mrn') }}</span> 
              				<span class="print-value">{{ $baby_detail->mr_number }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label">Name</span> 
              				<span class="print-value">{{ $baby_detail->name }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label">Maternal Age</span> 
              				<span class="print-value">{{ $baby_detail->maternal_age }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label">Married Since</span> 
              				<span class="print-value">{{ $baby_detail->married_month }}M&nbsp{{ $baby_detail->married_years }}Yrs</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label">Height / Weight / BMI</span> 
              				<span class="print-value">{{ $baby_detail->hwbstatus }}</span>
            			</div>
                        @if ($baby_detail->hwbstatus == 'N/A')
                			<div class="form-group">
                  				<span class="print-label">Height</span> 
                  				<span class="print-value">{{ $baby_detail->height }}</span>
                			</div>
                			<div class="form-group">
                  				<span class="print-label print-label-text">Weight</span> 
                  				<span class="print-value print-label-value">{{ $baby_detail->weight }}</span>
                			</div>
                			<div class="form-group">
                  				<span class="print-label print-label-text">BMI</span> 
                  				<span class="print-value print-label-value">{{ $baby_detail->bmi }}</span>
                			</div>
                        @endif
            			<div class="form-group">
              				<span class="print-label print-label-text">Gravida</span> 
              				<span class="print-value print-label-value">{{ $baby_detail->gravida }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Para</span> 
              				<span class="print-value print-label-value">{{ $baby_detail->para }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Live</span> 
              				<span class="print-value print-label-value">{{ $baby_detail->live }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Abortions</span> 
              				<span class="print-value print-label-value">{{ $baby_detail->abortions }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Sex</span> 
              				<span class="print-value print-label-value">{{ $baby_detail->gender }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Birth Weight (grams)</span> 
              				<span class="print-value print-label-value">{{ $baby_detail->birth_weight }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Admission Weight (grams)</span> 
              				<span class="print-value print-label-value">{{ $baby_detail->admission_weight }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">DOB</span> 
              				<span class="print-value print-label-value">{{ date('d-m-Y', strtotime($baby_detail->dob)) }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">TOB</span> 
              				<span class="print-value print-label-value">{{ $baby_detail->tob }}</span>
            			</div>
            		</div>
            		<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">Age At Admission In</span> 
              				<span class="print-value print-label-value">{{ $baby_detail->age_at_admission_method }}</span>
            			</div>
                        @if ($baby_detail->age_at_admission_method == 'HOURS')
                			<div class="form-group">
                  				<span class="print-label print-label-text">Age At Admission In (Hours)</span> 
                  				<span class="print-value print-label-value">{{ $baby_detail->age_at_admission_h }}</span>
                			</div>
                        @else
                			<div class="form-group">
                  				<span class="print-label print-label-text">Age At Admission In (Days)</span> 
                  				<span class="print-value print-label-value">{{ $baby_detail->age_at_admission_d }}</span>
                			</div>
                        @endif
            			<div class="form-group">
              				<span class="print-label print-label-text">Birth Status</span> 
              				<span class="print-value print-label-value">{{ $baby_detail->intramural_extramural }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Sga</span> 
              				<span class="print-value print-label-value">{{ $baby_detail->sga }}</span>
            			</div>
            			<div class="form-group">
                            @php $gestation = json_decode($baby_detail->gestation) @endphp
                            <span class="print-label print-label-text">Gestation Age</span> 
              				<span class="print-value print-label-value">{{ $gestation->g_weeks }} + {{ $gestation->g_days }}</span> 
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Mode Of Delivery</span> 
              				<span class="print-value print-label-value">{{ $baby_detail->mode_of_delivery }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">If Lscs</span> 
              				<span class="print-value print-label-value">{{ $baby_detail->iflscs }}</span>
            			</div>
                        @if($baby_detail->iflscs == 'Maternal Cause')
                			<div class="form-group">
                                @if (isset($baby_detail->maternalcause))
                                    @switch($baby_detail->maternalcause)
                                        @case(1)
                                            @php $maternalcause = 'Pregnancy-induced hypertension'; @endphp
                                            @break
                                        @case(2)
                                            @php $maternalcause = 'pPROM'; @endphp
                                            @break
                                        @case(3)
                                            @php $maternalcause = 'Maternal infection'; @endphp
                                            @break
                                        @case(4)
                                            @php $maternalcause = 'Hypothyroidism'; @endphp
                                            @break
                                        @case(5)
                                            @php $maternalcause = 'Gestational Diabetes / Type I , II Diabetes'; @endphp
                                            @break
                                        @case(6)
                                            @php $maternalcause = 'Autoimmune disorder'; @endphp
                                            @break
                                        @case(7)
                                            @php $maternalcause = 'Previous preterm birth'; @endphp
                                            @break
                                        @case(8)
                                            @php $maternalcause = 'Chronic systemic illness'; @endphp
                                            @break
                                        @case(9)
                                            @php $maternalcause = 'Other'; @endphp
                                            @break
                                        @default
                                            @php $maternalcause = ''; @endphp
                                            @break
                                    @endswitch
                                    <span class="print-label print-label-text">Maternal Cause</span> 
                                    <span class="print-value print-label-value">{{ $maternalcause }}</span>
                                @endif
                			</div>
                        @else
                			<div class="form-group">
                                @if (isset($baby_detail->fetalcause))
                                    @switch($baby_detail->fetalcause)
                                        @case(1)
                                            @php $fetalcause = 'Multiple Pregnancy'; @endphp
                                            @break
                                        @case(2)
                                            @php $fetalcause = 'Fetal Distress'; @endphp
                                            @break
                                        @case(3)
                                            @php $fetalcause = 'guGR / Placetal insufficiency'; @endphp
                                            @break
                                        @case(4)
                                            @php $fetalcause = 'Congenital malformations'; @endphp
                                            @break
                                        @case(5)
                                            @php $fetalcause = 'Hydrops fetalis'; @endphp
                                            @break
                                        @case(6)
                                            @php $fetalcause = 'Other'; @endphp
                                            @break
                                        @default
                                            @php $fetalcause = ''; @endphp
                                            @break
                                    @endswitch
                                    <span class="print-label print-label-text">Fetal Cause</span> 
                                    <span class="print-value print-label-value">{{ $fetalcause }}</span>
                                @endif
                			</div>
                        @endif
            			<div class="form-group">
              				<span class="print-label print-label-text">Antenatal Mgso<sub>4</sub> For Neuroprotection</span> 
              				<span class="print-value print-label-value">{{ $baby_detail->antenatalMgSO4 }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Antenatal Steriods Covered</span> 
              				<span class="print-value print-label-value">{{ $baby_detail->antenatalsteriods }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Last Dose</span> 
              				<span class="print-value print-label-value">{{ $baby_detail->steriod_last_dose }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Type Of Steroids</span> 
              				<span class="print-value print-label-value">{{ $baby_detail->dexa_beta }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Risk Factors For Sepsis In Mothers</span> 
              				<span class="print-value print-label-value">{{ $baby_detail->sepsisinmother }}</span>
            			</div>
          			</div>
        		</div>
      		</div>
      		<div class="content-block">
        		<h4>Risk Factors</h4>
        		<div class="content-section">
        			<div class="col-xs-12 col-sm-12 col-md-12">
                        @php $baby_detail->sepsis_in_mother_type = isset($baby_detail->sepsis_in_mother_type) ? json_decode($baby_detail->sepsis_in_mother_type) : []; @endphp
                        @foreach ($baby_detail->sepsis_in_mother_type as $value)
                            @switch($value)
                                @case(1)
                                    @php $sepsis_in_mother_type[] = 'Chorioamnionitis'; @endphp
                                    @break
                                @case(2)
                                    @php $sepsis_in_mother_type[] = 'Unclean vaginal examination / > 3 PV examination'; @endphp
                                    @break
                                @case(3)
                                    @php $sepsis_in_mother_type[] = 'Leaking PV > 18hours / pPROM'; @endphp
                                    @break
                                @case(4)
                                    @php $sepsis_in_mother_type[] = 'GBS in maternal recto-vaginal swab'; @endphp
                                    @break
                                @case(5)
                                    @php $sepsis_in_mother_type[] = 'UTI in mother'; @endphp
                                    @break
                                @case(6)
                                    @php $sepsis_in_mother_type[] = 'Maternal fever'; @endphp
                                    @break
                            @endswitch
                        @endforeach
                        @php $sepsis_in_mother_type = isset($sepsis_in_mother_type) ? $sepsis_in_mother_type : []; @endphp
            			<div class="form-group">
              				<span class="print-value full-width-must print-label-value">{{ implode(', ', $sepsis_in_mother_type) }}</span>
            			</div>
            		</div>
        		</div>
        	</div>
      		<div class="content-block">
        		<h4>Resuscitation Details</h4>
        		<div class="content-section">
        			<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">Resuscitation Required At Birth</span>
              				<span class="print-value print-label-value">{{ $baby_detail->resuscitationatbirth }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Initial Steps</span>
              				<span class="print-value print-label-value">{{ $baby_detail->initialsteps }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Fio2</span>
              				<span class="print-value print-label-value">{{ $baby_detail->ffo2 }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">BMV</span>
              				<span class="print-value print-label-value">{{ $baby_detail->bmv }}</span>
            			</div>
                        @if ($baby_detail->bmv == 'Yes')
                            <div class="form-group">
                                <span class="print-label print-label-text">BMV (sec)</span>
                                <span class="print-value print-label-value">{{ $baby_detail->bmv_duration }}</span>
                            </div>
                        @endif
            		</div>
        			<div class="col-xs-12 col-sm-6 col-md-6 plr-0">
            			<div class="form-group">
              				<span class="print-label print-label-text">BTV</span>
              				<span class="print-value print-label-value">{{ $baby_detail->btv }}</span>
            			</div>
                        @if ($baby_detail->btv == 'Yes')
                            <div class="form-group">
                                <span class="print-label print-label-text">BTV (sec)</span>
                                <span class="print-value print-label-value">{{ $baby_detail->btv_duration }}</span>
                            </div>
                        @endif
            			<div class="form-group">
              				<span class="print-label print-label-text">CC</span>
              				<span class="print-value print-label-value">{{ $baby_detail->cc }}</span>
            			</div>
                        @if ($baby_detail->cc_duration == 'Yes')
                            <div class="form-group">
                                <span class="print-label print-label-text">CC (sec)</span>
                                <span class="print-value print-label-value">{{ $baby_detail->cc_duration }}</span>
                            </div>
                        @endif
            			<div class="form-group">
              				<span class="print-label print-label-text">Medications</span>
              				<span class="print-value print-label-value">{{ $baby_detail->medications }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Details</span>
              				<span class="print-value print-label-value">{{ $baby_detail->medication_details }}</span>
            			</div>
            		</div>
        		</div>
        	</div>
      		<div class="content-block">
        		<h4>Apgar Score</h4>
        		<div class="content-section">
        			<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">Apgar</span>
              				<span class="print-value print-label-value">{{ $baby_detail->apgarstatus }}</span>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                        @if ($baby_detail->apgarstatus != 'Not Available')
                			<div class="form-group">
                				<table>
                					<tr>
                						<th class="print-label-text">1 Min</th>
                						<th class="print-label-text">5 Min</th>
                						<th class="print-label-text">10 Min</th>
                						<th class="print-label-text">15 Min</th>
                						<th class="print-label-text">20 Min</th>
                					</tr>
                					<tr>
                						<td class="print-label-value">{{ $baby_detail->apgar_1_min }}</td>
                						<td class="print-label-value">{{ $baby_detail->apgar_5_min }}</td>
                						<td class="print-label-value">{{ $baby_detail->apgar_10_min }}</td>
                						<td class="print-label-value">{{ $baby_detail->apgar_15_min }}</td>
                						<td class="print-label-value">{{ $baby_detail->apgar_20_min }}</td>
                					</tr>
                				</table>
                            </div>
                        @endif
            		  </div>
              </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">Cord Blood Gas</span>
              				<span class="print-value print-label-value">{{ $baby_detail->cord_blood_gas }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Ph</span>
              				<span class="print-value print-label-value">{{ $baby_detail->ph }}</span>
            			</div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Base Deficit</span>
                            <span class="print-value print-label-value">{{ $baby_detail->base_deficit }}</span>
                        </div>
                    </div>
            	</div>
                <div class="content-section col-xs-12 col-sm-12 col-md-12 plr-must-0">
        			<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">Severe Perinatal Asphyxia</span>
              				<span class="print-value print-label-value">{{ $baby_detail->severeperinatalasphyxia }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Delayed Cord Clamping</span>
              				<span class="print-value print-label-value">{{ $baby_detail->delayedcordclamping }}</span>
            			</div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">Umbilical Cord Milking</span>
              				<span class="print-value print-label-value">{{ $baby_detail->umbilicalcordmilking }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Cut Cord Milking</span>
              				<span class="print-value print-label-value">{{ $baby_detail->cutcordmilking }}</span>
            			</div>
            		</div>
        		</div>
        	</div>
      		<div class="content-block">
        		<h4>Admission / Course During Stay</h4>
        		<div class="content-section">
        			<div class="col-xs-12 col-sm-12 col-md-12">
            			<div class="form-group">
              				<span class="print-label full-width-must">Indication For Admission</span>
            			</div>
            			<div class="form-group pl-10">
                            @php $baby_detail->indication_of_admission = isset($baby_detail->indication_of_admission) ? json_decode($baby_detail->indication_of_admission) : []; @endphp
                            @foreach ($baby_detail->indication_of_admission as $value)
                                @switch($value)
                                    @case(1)
                                        @php $indication_of_admission[] = 'Prematurity'; @endphp
                                        @break
                                    @case(2)
                                        @php $indication_of_admission[] = 'Low birth weight'; @endphp
                                        @break
                                    @case(3)
                                        @php $indication_of_admission[] = 'RD'; @endphp
                                        @break
                                    @case(4)
                                        @php $indication_of_admission[] = 'Birth asphyxia'; @endphp
                                        @break
                                    @case(5)
                                        @php $indication_of_admission[] = 'Sepsis'; @endphp
                                        @break
                                    @case(6)
                                        @php $indication_of_admission[] = 'Shock'; @endphp
                                        @break
                                    @case(7)
                                        @php $indication_of_admission[] = 'Jaundice'; @endphp
                                        @break
                                @endswitch
                            @endforeach
                            @php $indication_of_admission = isset($indication_of_admission) ? $indication_of_admission : []; @endphp
              				<span class="print-value full-width-must print-label-value">{{ implode(', ', $indication_of_admission) }}</span>
            			</div>
                    </div>
            	</div>
                <div class="content-section">
        			<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">Others (Specify)</span>
              				<span class="print-value print-label-value">{{ $baby_detail->indication_of_admission_other }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Respiratory Distress At Birth</span>
              				<span class="print-value print-label-value">{{ $baby_detail->respiratorydistressat_birth }}</span>
            			</div>
            		</div>
        			<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">Surfactant Given</span>
              				<span class="print-value print-label-value">{{ $baby_detail->surfactantgiven }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Type</span>
                            @php $baby_detail->surfactant_type = isset($baby_detail->surfactant_type) ? json_decode($baby_detail->surfactant_type) : []; @endphp
                            @foreach ($baby_detail->surfactant_type as $value)
                                @switch($value)
                                    @case(1)
                                        @php $surfactant_type[] = 'Survanta'; @endphp
                                        @break
                                    @case(2)
                                        @php $surfactant_type[] = 'Curosurf'; @endphp
                                        @break
                                    @case(3)
                                        @php $surfactant_type[] = 'Neosurf'; @endphp
                                        @break
                                @endswitch
                            @endforeach
                            @php $surfactant_type = isset($surfactant_type) ? $surfactant_type : []; @endphp
              				<span class="print-value print-label-value">{{ implode(', ', $surfactant_type) }}</span>
            			</div>
            		</div>
        		</div>
        	</div>
      		<div class="content-block">
        		<h4>Age At Admission (hours)</h4>
        		<div class="content-section">
        			<div class="col-xs-12 col-sm-6 col-md-6 overflow-auto">
            			<div class="form-group">
            				<table>
            					<tr>
            						<th class="print-label-text">First</th>
            						<th class="print-label-text">Second</th>
            						<th class="print-label-text">Third</th>
            						<th class="print-label-text">Fourth</th>
            						<th class="print-label-text">Total Number Of Doses</th>
            					</tr>
            					<tr>
            						<td class="print-label-value">{{ $baby_detail->age_first }}</td>
            						<td class="print-label-value">{{ $baby_detail->age_second }}</td>
            						<td class="print-label-value">{{ $baby_detail->age_third }}</td>
            						<td class="print-label-value">{{ $baby_detail->age_fourth }}</td>
            						<td class="print-label-value">{{ $baby_detail->total_number_of_doses }}</td>
            					</tr>
            				</table>
            			</div>
            		</div>
        		</div>
            </div>
      		<div class="content-block custom">
        		<h4></h4>
        		<div class="content-section">
        			<div class="col-xs-12 col-sm-12 col-md-12">
            			<div class="form-group">
              				<span class="print-label print-label-text">Primary Respiratory Support Required</span> 
              				<span class="print-value print-label-value">{{ $baby_detail->primary_res_support }} {{ $baby_detail->res_support_type }}</span>
            			</div>
            		</div>
        		</div>
        		<div class="content-section">
        			<div class="col-xs-12 col-sm-12 col-md-12">
            			<div class="form-group">
              				<span class="print-label">Details Of All Types Of Respiratory Support Required (Primary & Weaning):</span> 
            			</div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
            			<table class="overflow-auto full-width">
            				<tr>
            					<th></th>
            					<th class="text-center">Highest Settings<br/><span class="font-normal-must custom-font">(Map Or Pressure Or Flow/Fio2)</span></th>
            					<th class="text-center">Total Duration Of<br/>Respiratory Support<br/><span class="font-normal-must custom-font">(Hours)</span></th>
            					<th class="text-center">Failure Of Primary Respiratory Support<br/><span class="font-normal-must custom-font">(HHHFNC/CPAP/NIPPV/Nasal HFOV)<br/>Extubation Failure Mention Yes/No</span></th>
            				</tr>
            				<tr>
            					<td><b>HHHFNC</b></td>
            					<td>
            						<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            							<span class="col-md-5 plr-must-0">{{ $baby_detail->hhhnfc_settings_liter }}</span>
            							<span class="col-md-7 plr-must-0">L/Mins</span>
            						</div>
            						<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            							<span class="col-md-5 plr-must-0">{{ $baby_detail->hhhnfc_settings_fio2 }}</span>
            							<span class="col-md-7 plr-must-0">Fio2 (%)</span>
            						</div>
            					</td>
            					<td class="text-center">{{ $baby_detail->hhhnfc_duration }}</td>
            					<td class="text-center">{{ $baby_detail->hhhnfc_failure }}</td>
            				</tr>
            				<tr>
            					<td><b>CPAP</b></td>
            					<td>
            						<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            							<span class="col-md-5 plr-must-0">{{ $baby_detail->cpap_settings_peep }}</span>
            							<span class="col-md-7 plr-must-0">Peep</span>
            						</div>
            						<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            							<span class="col-md-5 plr-must-0">{{ $baby_detail->cpap_settings_fio2 }}</span>
            							<span class="col-md-7 plr-must-0">Fio2 (%)</span>
            						</div>
            					</td>
            					<td class="text-center">{{ $baby_detail->cpap_duration }}</td>
            					<td class="text-center">{{ $baby_detail->cpap_failure }}</td>
            				</tr>
            				<tr>
            					<td><b>NIPPV</b></td>
            					<td>{{ $baby_detail->nippv_settings }}</td>
            					<td class="text-center">{{ $baby_detail->nippv_duration }}</td>
            					<td class="text-center">{{ $baby_detail->nippv_failure }}</td>
            				</tr>
            				<tr>
            					<td><b>Nasal HFOV</b> (Primary)</td>
            					<td>
            						<div class="col-md-12 plr-must-0">
            							<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            								<span class="col-md-5 plr-must-0">{{ $baby_detail->nasal_hfov_pduration_map }}</span>
            								<span class="col-md-7 plr-must-0">MAP</span>
            							</div>
            							<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            								<span class="col-md-5 plr-must-0">{{ $baby_detail->nasal_hfov_pduration_fio2 }}</span>
            								<span class="col-md-7 plr-must-0">Fio2 (%)</span>
            							</div>
            						</div>
            						<div class="col-md-12 plr-must-0">
            							<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            								<span class="col-md-5 plr-must-0">{{ $baby_detail->nasal_hfov_pduration_amp }}</span>
            								<span class="col-md-7 plr-must-0">AMP</span>
            							</div>
            							<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            								<span class="col-md-5 plr-must-0">{{ $baby_detail->nasal_hfov_pduration_hz }}</span>
            								<span class="col-md-7 plr-must-0">HZ</span>
            							</div>
            						</div>
            					</td>
            					<td class="text-center">{{ $baby_detail->nasal_hfov_pduration }}</td>
            					<td class="text-center">{{ $baby_detail->nasal_hfov_pfailure }}</td>
            				</tr>
            				<tr>
            					<td><b>Nasal HFOV</b> (Secondary)</td>
            					<td>
            						<div class="col-md-12 plr-must-0">
            							<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            								<span class="col-md-5 plr-must-0">{{ $baby_detail->nasal_hfov_ssettings_map }}</span>
            								<span class="col-md-7 plr-must-0">MAP</span>
            							</div>
            							<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            								<span class="col-md-5 plr-must-0">{{ $baby_detail->nasal_hfov_ssettings_fio2 }}</span>
            								<span class="col-md-7 plr-must-0">Fio2 (%)</span>
            							</div>
            						</div>
            						<div class="col-md-12 plr-must-0">
            							<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            								<span class="col-md-5 plr-must-0">{{ $baby_detail->nasal_hfov_ssettings_amp }}</span>
            								<span class="col-md-7 plr-must-0">AMP</span>
            							</div>
            							<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            								<span class="col-md-5 plr-must-0">{{ $baby_detail->nasal_hfov_ssettings_hz }}</span>
            								<span class="col-md-7 plr-must-0">HZ</span>
            							</div>
            						</div></td>
            					<td class="text-center">{{ $baby_detail->nasal_hfov_sduration }}</td>
            					<td class="text-center">{{ $baby_detail->nasal_hfov_sfailure }}</td>
            				</tr>
            				<tr>
            					<td><b>Mechanical Ventilation</b><br/>(Conventional / Volume Grantee)</td>
            					<td>
            						<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            							<span class="col-md-5 plr-must-0">{{ $baby_detail->mechanical_csettings_vol }}</span>
            							<span class="col-md-7 plr-must-0">vol/ml/kg</span>
            						</div>
            						<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            							<span class="col-md-5 plr-must-0">{{ $baby_detail->nmechanical_csettings_fio2 }}</span>
            							<span class="col-md-7 plr-must-0">Fio2 (%)</span>            							
            						</div>
            					</td>
            					<td class="text-center">{{ $baby_detail->mechanical_cduration }}</td>
            					<td class="text-center">{{ $baby_detail->mechanical_cfailure }}</td>
            				</tr>
            				<tr>
            					<td><b>Mechanical Ventilation</b><br/>(Conventional / Pressure Control)</td>
            					<td>
            						<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            							<span class="col-md-5 plr-must-0">{{ $baby_detail->mechanical_pressure_map }}</span>
            							<span class="col-md-7 plr-must-0">Map</span>
            						</div>
            						<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            							<span class="col-md-5 plr-must-0">{{ $baby_detail->mechanical_csettings_fio2 }}</span>
            							<span class="col-md-7 plr-must-0">Fio2 (%)</span>            							
            						</div>
            					</td>
            					<td class="text-center">{{ $baby_detail->mechanical_pressureduration }}</td>
            					<td class="text-center">{{ $baby_detail->mechanical_pressurefailure }}</td>
            				</tr>
            				<tr>
            					<td><b>Mechanical Ventilation (HFO)</b> (Primary)</td>
            					<td>
            						<div class="col-md-12 plr-must-0">
            							<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            								<span class="col-md-5 plr-must-0">{{ $baby_detail->mechanical_psettings_map }}</span>
            								<span class="col-md-7 plr-must-0">Map</span>
            							</div>
            							<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            								<span class="col-md-5 plr-must-0">{{ $baby_detail->mechanical_psettings_fio2 }}</span>
            								<span class="col-md-7 plr-must-0">Fio2 (%)</span>            								
            							</div>
            						</div>
            						<div class="col-md-12 plr-must-0">
            							<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            								<span class="col-md-5 plr-must-0">{{ $baby_detail->mechanical_psettings_amp }}</span>
            								<span class="col-md-7 plr-must-0">AMP</span>
            							</div>
            							<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            								<span class="col-md-5 plr-must-0">{{ $baby_detail->mechanical_psettings_hz }}</span>
            								<span class="col-md-7 plr-must-0">HZ</span>            								
            							</div>
            						</div>
            					</td>
            					<td class="text-center">{{ $baby_detail->mechanical_pduration }}</td>
            					<td class="text-center">{{ $baby_detail->mechanical_pfailure }}</td>
            				</tr>
            				<tr>
            					<td><b>Mechanical Ventilation (HFO)</b><br/>(Rescue after failed conventional)</td>
            					<td>
            						<div class="col-md-12 plr-must-0">
            							<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            								<span class="col-md-5 plr-must-0">{{ $baby_detail->mechanical_rcsettings_map }}</span>
            								<span class="col-md-7 plr-must-0">MAP</span>
            							</div>
            							<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            								<span class="col-md-5 plr-must-0">{{ $baby_detail->mechanical_rcsettings_fio2 }}</span>
            								<span class="col-md-7 plr-must-0">Fio2 (%)</span>
            							</div>
            						</div>
            						<div class="col-md-12 plr-must-0">
            							<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            								<span class="col-md-5 plr-must-0">{{ $baby_detail->mechanical_rcsettings_amp }}</span>
            								<span class="col-md-7 plr-must-0">AMP</span>
            							</div>
            							<div class="col-xs-6 col-sm-6 col-md-6 plr-must-0">
            								<span class="col-md-5 plr-must-0">{{ $baby_detail->mechanical_rcsettings_hz }}</span>
            								<span class="col-md-7 plr-must-0">HZ</span>            								
            							</div>
            						</div>
            					</td>
            					<td class="text-center">{{ $baby_detail->mechanical_rcduration }}</td>
            					<td class="text-center">{{ $baby_detail->mechanical_rcfailure }}</td>
            				</tr>
            				<tr>
            					<td><b>Oxygen By Hood / Prongs</b></td>
            					<td>
            						<div class="col-md-12 plr-must-0">
            							<span class="col-xs-5 col-sm-5 col-md-8 plr-must-0">{{ $baby_detail->oxygen_prongs_settings_fio2 }}</span>
            							<span class="col-xs-7 col-sm-7 col-md-4 custom-padding">Fio2 (%)</span>            								
            						</div>
            					</td>
            					<td class="text-center">{{ $baby_detail->oxygen_prongs_duration }}</td>
            					<td class="text-center">{{ $baby_detail->oxygen_prongs_failure }}</td>
            				</tr>
            			</table>
            		</div>
        		</div>
            	<div class="content-section">
        			<div class="col-xs-12 col-sm-12 col-md-12">
            			<div class="form-group">
              				<span class="print-label">Total Duration Of Mechanical Ventilation (Conventional)</span>
              				<span class="print-value pull-right-flex">
              					<span>{{ $baby_detail->mvc_total }}</span>
              					<span>&nbsp(hours)</span>
              				</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label">Total Duration Of Mechanical Ventilation (HFOV)</span>
              				<span class="print-value pull-right-flex">
              					<span>{{ $baby_detail->hfov_total }}</span>
              					<span>&nbsp(hours)</span>
              				</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label">Total Duration Of Mechanical Ventilation (Conventinal & HFOV)</span>
              				<span class="print-value pull-right-flex">
              					<span>{{ $baby_detail->hfov_mc_total }}</span>
              					<span>&nbsp(hours)</span>
              				</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label">Total Duration Of Non-Invasive Ventilation Combined (O2 Prongs / HHFNC / CPAP / NIPPV)</span>
              				<span class="print-value pull-right-flex">
              					<span>{{ $baby_detail->non_invasive_total }}</span>
              					<span>&nbsp(hours)</span>
              				</span>
            			</div>
            		</div>
            	</div>
            </div>
      		<div class="content-block">
        		<h4>Sepsis</h4>
        		<div class="content-section">
        			<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">Sepsis<br/><span class="font-normal-must">(Clinical sepsis, Suspect sepsis, Culture positive sepsis)</span></span>
              				<span class="print-value print-label-value">{{ $baby_detail->sepsis }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Developed Shock</span>
              				<span class="print-value print-label-value">{{ $baby_detail->developedshock }}</span>
            			</div>
            		</div>
        			<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">Sclerema</span>
              				<span class="print-value print-label-value">{{ $baby_detail->sclerema }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Meningitis</span>
              				<span class="print-value print-label-value">{{ $baby_detail->meningitis }}</span>
            			</div>
            		</div>
            	</div>
                <div class="clearfix"></div>
        		<div class="content-section">
        			<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">Type</span>
                            @php $baby_detail->spesis_type = isset($baby_detail->spesis_type) ? json_decode($baby_detail->spesis_type) : []; @endphp
                            @foreach ($baby_detail->spesis_type as $value)
                                @switch($value)
                                    @case(1)
                                        @php $spesis_type[] = 'Fluid responsive'; @endphp
                                        @break
                                    @case(2)
                                        @php $spesis_type[] = 'Fluid resistant,catecholamine responsive'; @endphp
                                        @break
                                    @case(3)
                                        @php $spesis_type[] = 'Catecholamine resistant'; @endphp
                                        @break
                                @endswitch
                            @endforeach
                            @php $spesis_type = isset($spesis_type) ? $spesis_type : []; @endphp
              				<span class="print-value print-label-value">{{ implode(', ', $spesis_type) }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Postnatal Steriod Used</span>
              				<span class="print-value print-label-value">{{ $baby_detail->postnatalsteriodused }}</span>
            			</div>
            		</div>
        			<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">Steriod Type</span>
              				<span class="print-value print-label-value">{{ $baby_detail->steriod_type }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Maximum Cumulative Dose</span>
              				<span class="print-value print-label-value">{{ $baby_detail->max_cumulative_dose }}&nbsp(per / kg body weight)</span>
            			</div>
            		</div>
            	</div>
        		<div class="content-section">
            		<div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
            			<div class="form-group">
            				<span class="print-label">Blood Culture</span>
            			</div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
            			<table>
            				<tr>
            					<th></th>
            					<th>Gram Positive</th>
            					<th>Gram Negative</th>
            					<th>Fungus</th>
            				</tr>
            				<tr>
            					<td>1 <sup>st</sup> Culture</td>
            					<td>{{ $baby_detail->gram_positive_culture1 }}</td>
            					<td>{{ $baby_detail->gram_negative_culture1 }}</td>
            					<td>{{ $baby_detail->fungus_culture1 }}</td>
            				</tr>
            				<tr>
            					<td>2 <sup>nd</sup> Culture</td>
            					<td>{{ $baby_detail->gram_positive_culture2 }}</td>
            					<td>{{ $baby_detail->gram_negative_culture2 }}</td>
            					<td>{{ $baby_detail->fungus_culture2 }}</td>
            				</tr>
            				<tr>
            					<td>3 <sup>rd</sup> Culture</td>
            					<td>{{ $baby_detail->gram_positive_culture3 }}</td>
            					<td>{{ $baby_detail->gram_negative_culture3 }}</td>
            					<td>{{ $baby_detail->fungus_culture3 }}</td>
            				</tr>
            			</table>
            		</div>
        		</div>
        		<div class="content-section">
        			<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">Extended-Spectrum Cephalosporins</span>
              				<span class="print-value print-label-value">{{ $baby_detail->ext_spectrum }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Carbapenems</span>
              				<span class="print-value print-label-value">{{ $baby_detail->carbapenems }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Aminoglycosides</span>
              				<span class="print-value print-label-value">{{ $baby_detail->aminoglycosides }}</span>
            			</div>
            		</div>
        			<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">Fluoroquinolones</span>
              				<span class="print-value print-label-value">{{ $baby_detail->fluoroquinolones }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Piperacillin - Tazobactam</span>
                            <span class="print-value print-label-value">{{ $baby_detail->piperacillin_tazobactam }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Tetracycline</span>
              				<span class="print-value print-label-value">{{ $baby_detail->tetracycline }}</span>
            			</div>
            		</div>
            	</div>
        		<div class="content-section">
        			<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">First Line Antibiotics</span>
              				<span class="print-value print-label-value">{{ $baby_detail->first_antibotics }}&nbsp(Duration)</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Second Line Antibiotics</span>
              				<span class="print-value print-label-value">{{ $baby_detail->second_antibotics }}&nbsp(Duration)</span>
            			</div>
            		</div>
        			<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">Third Line Antibiotics</span>
              				<span class="print-value print-label-value">{{ $baby_detail->third_antibotics }}&nbsp(Duration)</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Total Duration Of Antibiotics In Days</span>
              				<span class="print-value print-label-value">{{ $baby_detail->total_antibiotics_days }}</span>
            			</div>
            		</div>
            	</div>
        	</div>
      		<div class="content-block custom2">
        		<h4>EONS</h4>
        		<div class="content-section">
        			<div class="col-xs-12 col-sm-12 col-md-12">
            			<div class="form-group">
              				<span class="print-label print-label-text">Clinical Sepsis: (Clinical Course +, Screen Neg, Culture Neg)</span>
              				<span class="print-value print-label-value">{{ $baby_detail->eonsclinicalsepsis }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Suspect Sepsis: (Clinical Course +, Screen Pos, Culture Neg)</span>
              				<span class="print-value print-label-value">{{ $baby_detail->eonssuspectsepsis }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Culture Positive Sepsis: (Clinical Course +, Screen Neg / Pos, Culture Pos)</span>
              				<span class="print-value print-label-value">{{ $baby_detail->eonsculturepositive_sepsis }}</span>
            			</div>
            		</div>
            	</div>
            </div>
      		<div class="content-block custom2">
        		<h4>LONS</h4>
        		<div class="content-section">
        			<div class="col-xs-12 col-sm-12 col-md-12">
            			<div class="form-group">
              				<span class="print-label print-label-text">Clinical Sepsis: (Clinical Course +, Screen Neg, Culture Neg)</span>
              				<span class="print-value print-label-value">{{ $baby_detail->lonsclinical_sepsis }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Suspect Sepsis: (Clinical Course +, Screen Pos, Culture Neg)</span>
              				<span class="print-value print-label-value">{{ $baby_detail->lonssuspect_sepsis }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Culture Positive Sepsis: (Clinical Course +, Screen Neg / Pos, Culture Pos)</span>
              				<span class="print-value print-label-value">{{ $baby_detail->lonsculture_sepsis }}</span>
            			</div>
            		</div>
            	</div>
            </div>
      		<div class="content-block">
        		<div class="content-section">
        			<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">Cumulative Duration Of Antibiotic Therapy</span>
              				<span class="print-value print-label-value">{{ $baby_detail->cumulative_antibiotic }}</span>
            			</div>
            		</div>
        			<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">Antifungal Prophylaxis</span>
              				<span class="print-value print-label-value">{{ $baby_detail->anti_prophylaxis }}</span>
              			</div>
            		</div>
            	</div>
            </div>
      		<div class="content-block">
      			<h4>Feeding</h4>
        		<div class="content-section">
        			<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">Started</span>
              				<span class="print-value print-label-value">{{ $baby_detail->feeding_start_hours }}&nbsphours / {{ $baby_detail->feeding_start_dof }} days of life</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Amount Started</span>
              				<span class="print-value print-label-value">{{ $baby_detail->feeding_amount_start }}&nbsp(ml / kg / day)</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Time To Achieve Full Feeds (150ml / kg) (Days)</span>
              				<span class="print-value print-label-value">{{ $baby_detail->full_feed_time }}&nbsp(ml / kg / day)</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Expired Prior To The Event</span>
              				<span class="print-value print-label-value">{{ $baby_detail->expired_prior_event_full_feed }}&nbsp</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Day Of Regaining Birth Weight</span>
              				<span class="print-value print-label-value">{{ $baby_detail->regain_birth_weight }}&nbsp(ml / kg / day)</span>
            			</div>
            		</div>
        			<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">Expired Prior To The Event</span>
              				<span class="print-value print-label-value">{{ $baby_detail->expired_prior_event_regain_weight }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Probiotics</span>
              				<span class="print-value print-label-value">{{ $baby_detail->probiotics }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Name Of The Brand Used</span>
              				<span class="print-value print-label-value">{{ $baby_detail->brand_name }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Duration Of Probiotics Usage</span>
              				<span class="print-value print-label-value">{{ $baby_detail->probiotics_usage }}&nbsp(days)</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">PMA Stopped At</span>
              				<span class="print-value print-label-value">{{ $baby_detail->probiotics_stopped }}&nbsp(weeks)</span>
            			</div>
            		</div>
            	</div>
        		<div class="content-section">
        			<div class="col-xs-12 col-sm-12 col-md-12">
            			<div class="form-group">
              				<span class="print-label print-label-text">Wherther Total Parenteral Nutrition Or IVF Initiated At Admission</span>
              				<span class="print-value print-label-value pl-15">{{ $baby_detail->total_pn }}</span>
            			</div>
            		</div>
            	</div>
        		<div class="content-section">
        			<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">If Yes, Then Duration Of Use (In Days)</span>
              				<span class="print-value print-label-value">{{ $baby_detail->total_pn_duration }}&nbsp(days)</span>
            			</div>
            		</div>
        			<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">Hyperbilirubinemia</span>
              				<span class="print-value print-label-value">{{ $baby_detail->hyperbilirubinemia }}</span>
            			</div>
            		</div>
            	</div>
                <div class="clearfix"></div>
        		<div class="content-section">
        			<div class="col-xs-12 col-sm-6 col-md-6">
            			<div class="form-group">
              				<span class="print-label print-label-text">Phototherapy (total)</span>
              				<span class="print-value print-label-value">{{ $baby_detail->phototherapy_hours }}&nbspHOURS</span>
            			</div>
            		</div>
        			<div class="col-xs-12 col-sm-6 col-md-6">
                        @switch($baby_detail->dvet)
                            @case('one')
                                @php $dvet = 'YES'; @endphp
                                @break
                            @case('two')
                                @php $dvet = 'NO'; @endphp
                                @break
                            @default
                                @php $max_grade_rt = 'N/A'; @endphp
                                @break
                        @endswitch
            			<div class="form-group">
              				<span class="print-label print-label-text">DVET</span>
              				<span class="print-value print-label-value">{{ $baby_detail->dvet }}</span>
            			</div>
            			<div class="form-group">
              				<span class="print-label print-label-text">Maximum Bilirubin (mg / dl)</span>
              				<span class="print-value print-label-value">{{ $baby_detail->max_bilirubin }}</span>
            			</div>
            		</div>
            	</div>
                <div class="content-section">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <span class="print-label print-label-text">Seizures</span>
                            <span class="print-value print-label-value">{{ $baby_detail->seizures }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Anticonvulsants</span>
                            <span class="print-value print-label-value">{{ $baby_detail->anticonvulsants }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Duration Of Anticonvulsants Use</span>
                            <span class="print-value print-label-value">{{ $baby_detail->seizures_duration }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Hs Patent Ductus Arteriosus</span>
                            <span class="print-value print-label-value">{{ $baby_detail->patent_ductus_arteriosus }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Medical &#8478;</span>
                            <span class="print-value print-label-value">{{ $baby_detail->pda_medicine }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Surgical Ligation</span>
                            <span class="print-value print-label-value">{{ $baby_detail->surgical_ligation }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <span class="print-label print-label-text">Central Line</span>
                            <span class="print-value print-label-value">{{ $baby_detail->centeralline }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Central Line Type</span>
                            @php $baby_detail->central_line_type = isset($baby_detail->central_line_type) ? json_decode($baby_detail->central_line_type) : []; @endphp
                            @foreach ($baby_detail->central_line_type as $value)
                                @switch($value)
                                    @case(1)
                                        @php $central_line_type[] = 'UVC'; @endphp
                                        @break
                                    @case(2)
                                        @php $central_line_type[] = 'UAC'; @endphp
                                        @break
                                    @case(3)
                                        @php $central_line_type[] = 'PICC'; @endphp
                                        @break
                                    @case(4)
                                        @php $central_line_type[] = 'Central Line'; @endphp
                                        @break
                                @endswitch
                            @endforeach
                            @php $central_line_type = isset($central_line_type) ? $central_line_type : []; @endphp
                            <span class="print-value print-label-value">{{ implode(', ', $central_line_type) }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Total Duration Of Line (Days)</span>
                            <span class="print-value print-label-value">{{ $baby_detail->total_duration_of_line }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Hearing Screen Done</span>
                            <span class="print-value print-label-value">{{ $baby_detail->hearing_screen_done }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Hearing Screen Result</span>
                            <span class="print-value print-label-value">{{ $baby_detail->hearscreen_result }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Caffeine Use</span>
                            <span class="print-value print-label-value">{{ $baby_detail->caffeine_use }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">PMA At Which It Was Stopped</span>
                            <span class="print-value print-label-value">{{ $baby_detail->caffeine_use_val }} (Weeks)</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-block">
                <h4>Blood Component Therapy</h4>
                <div class="content-section">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <span class="print-label print-label-text">Received PRBC</span>
                            <span class="print-value print-label-value">{{ $baby_detail->received_prbc }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Received Platelet</span>
                            <span class="print-value print-label-value">{{ $baby_detail->receivedplatelet }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <span class="print-label print-label-text">Total Number Of PRBC Tranfusions</span>
                            <span class="print-value print-label-value">{{ $baby_detail->total_prbc_transfusions }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Fresh Frozen Plasma</span>
                            <span class="print-value print-label-value">{{ $baby_detail->freshfrozenplasma }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-block">
                <h4>OutComes</h4>
                <div class="content-section">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <span class="print-label print-label-text">Outcomes</span>
                            <span class="print-value print-label-value">{{ $baby_detail->outcome_result }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <span class="print-label print-label-text">Duration Of Hospital Stay (Days)</span>
                            <span class="print-value print-label-value">{{ $baby_detail->hospital_stay }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-block">
                <h4>Morbidities</h4>
                <div class="content-section">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <span class="print-label print-label-text">Eugr</span>
                            <span class="print-value print-label-value">{{ $baby_detail->eugr }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Congenital Heart Disease (Excluding PFO / PDA)</span>
                            <span class="print-value print-label-value">{{ $baby_detail->congenital_heart_disease }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Respiratory Distress Syndrome</span>
                            <span class="print-value print-label-value">{{ $baby_detail->rds }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Pneumothorax</span>
                            <span class="print-value print-label-value">{{ $baby_detail->pneumothorax }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">PPHN</span>
                            <span class="print-value print-label-value">{{ $baby_detail->pphn }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Intarventricular Hemorrhage</span>
                            <span class="print-value print-label-value">{{ $baby_detail->intar_hommorrhage }}</span>
                        </div>
                        <div class="form-group">
                            @switch($baby_detail->max_grade_rt)
                                @case(1)
                                    @php $max_grade_rt = 'Grade 1'; @endphp
                                    @break
                                @case(2)
                                    @php $max_grade_rt = 'Grade 2'; @endphp
                                    @break
                                @case(3)
                                    @php $max_grade_rt = 'Grade 3'; @endphp
                                    @break
                                @case(4)
                                    @php $max_grade_rt = 'Grade 4'; @endphp
                                    @break
                                @default
                                    @php $max_grade_rt = 'N/A'; @endphp
                                    @break
                            @endswitch
                            <span class="print-label print-label-text">Max Grade RT</span>
                            <span class="print-value print-label-value">{{ $max_grade_rt }}</span>
                        </div>
                        <div class="form-group">
                            @if (isset($baby_detail->max_grade_lt))
                                @switch($baby_detail->max_grade_lt)
                                    @case(1)
                                        @php $max_grade_lt = 'Grade 1'; @endphp
                                        @break
                                    @case(2)
                                        @php $max_grade_lt = 'Grade 2'; @endphp
                                        @break
                                    @case(3)
                                        @php $max_grade_lt = 'Grade 3'; @endphp
                                        @break
                                    @case(4)
                                        @php $max_grade_lt = 'Grade 4'; @endphp
                                        @break
                                    @default
                                        @php $max_grade_lt = 'N/A'; @endphp
                                        @break
                                @endswitch
                                <span class="print-label print-label-text">Max Grade LT</span>
                                <span class="print-value print-label-value">{{ $max_grade_lt }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Necrotising Enterocoitis (Nec)</span>
                            <span class="print-value print-label-value">{{ $baby_detail->nec }}</span>
                        </div>
                        <div class="form-group">
                            @if (isset($baby_detail->nec_max_stage))
                                @switch($baby_detail->nec_max_stage)
                                    @case('N/A')
                                    @case(1)
                                        @php $nec_max_stage = 'NEC 1'; @endphp
                                        @break
                                    @case(2)
                                        @php $nec_max_stage = 'NEC 2'; @endphp
                                        @break
                                    @case(3)
                                        @php $nec_max_stage = 'NEC 3'; @endphp
                                        @break
                                    @default
                                        @php $nec_max_stage = 'N/A'; @endphp
                                        @break
                                @endswitch
                                <span class="print-label print-label-text">Max Stage</span>
                                <span class="print-value print-label-value">{{ $nec_max_stage }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">PPD</span>
                            <span class="print-value print-label-value">{{ $baby_detail->ppd }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Surgery</span>
                            <span class="print-value print-label-value">{{ $baby_detail->surgery }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Congenital Pneumonia</span>
                            <span class="print-value print-label-value">{{ $baby_detail->congenital_pneumonia }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <span class="print-label print-label-text">Pulmonary Hemorrahge</span>
                            <span class="print-value print-label-value">{{ $baby_detail->pulmonary_hemorrahge }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Retinopathy Of Prematurity</span>
                            <span class="print-value print-label-value">{{ $baby_detail->rop }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">RT Eye: Max Grade / Stage</span>
                            <span class="print-value print-label-value">{{ $baby_detail->rt_eye_grade }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">LT Eye: Max Grade / Stage</span>
                            <span class="print-value print-label-value">{{ $baby_detail->lt_eye_grade }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Rop Treatment Required</span>
                            <span class="print-value print-label-value">{{ $baby_detail->rop_treatment_required }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Periventricular Leukomalacia</span>
                            <span class="print-value print-label-value">{{ $baby_detail->pventricular_leukomalacia }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Cystic Pvl</span>
                            <span class="print-value print-label-value">{{ $baby_detail->cystic_pvl }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">BPD</span>
                            <span class="print-value print-label-value">{{ $baby_detail->bronchopulmonary_dysplasia }}</span>
                        </div>
                        @if ($baby_detail->bronchopulmonary_dysplasia == 'Yes')
                            <div class="form-group">
                                <span class="print-label print-label-text">BPD Stage</span>
                                <span class="print-value print-label-value">{{ $baby_detail->dysplasia_stage }}</span>
                            </div>
                            <div class="form-group">
                                <span class="print-label print-label-text">BPD Detail</span>
                                <span class="print-value print-label-value">{{ $baby_detail->dysplasia_details }}</span>
                            </div>
                        @endif
                        <div class="form-group">
                            <span class="print-label print-label-text">Acute Renal Failure (Increase in Scr > 0.3 mg / dl from baseline)</span>
                            <span class="print-value print-label-value">{{ $baby_detail->acute_renal_failure }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">VAP</span>
                            <span class="print-value print-label-value">{{ $baby_detail->vap }}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label print-label-text">Osteopenia Of Prematurity</span>
                            <span class="print-value print-label-value">{{ $baby_detail->osteopenia_prematurity }}</span>
                        </div>
                    </div>
                </div>
                <div class="content-section">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <span class="print-label full-width-must print-label-text">In Case Of Death, Predominant Cause</span>
                        </div>
                        <div class="form-group">
                            @php $baby_detail->case_death = isset($baby_detail->case_death) ? json_decode($baby_detail->case_death) : []; @endphp
                            @foreach($baby_detail->case_death as $value)
                                @switch($value)
                                    @case(1)
                                        @php $case_death[] = 'Extreme prematurity'; @endphp
                                        @break
                                    @case(2)
                                        @php $case_death[] = 'Respiratory failure'; @endphp
                                        @break
                                    @case(3)
                                        @php $case_death[] = 'Sepsis'; @endphp
                                        @break
                                    @case(4)
                                        @php $case_death[] = 'Perinatal asphyxia'; @endphp
                                        @break
                                    @case(5)
                                        @php $case_death[] = 'IVH'; @endphp
                                        @break
                                    @case(6)
                                        @php $case_death[] = 'NEC'; @endphp
                                        @break
                                @endswitch
                            @endforeach
                            @php $case_death = isset($case_death) ? $case_death : []; @endphp
                            <span class="print-value full-width-must pl-10 print-label-value">{{ implode(', ', $case_death) }}</span>
                        </div>
                    </div>
                </div>
                <div class="content-section">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <span class="print-label full-width-must print-label-text">Others</span>
                        </div>
                        <div class="form-group">
                            <span class="print-value full-width-must pl-10 print-label-value">{{ $baby_detail->others_case_death }}</span>
                        </div>
                    </div>
                </div>
            </div>
      	</div>
    </div>
</div>
@endsection
