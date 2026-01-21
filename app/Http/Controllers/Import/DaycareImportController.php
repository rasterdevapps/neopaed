<?php

namespace App\Http\Controllers\Import;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DaycareImportController extends Controller
{
    
	private function daycareImports() 
	{

		$daylist = Excel::load(public_path().'/im/nicudaycaresheet.xls', function ($reader) {
					         
					         $daylist = $reader->skipRows(1)->takeRows(5102)->get();
				   
		})->all();


		 
		  foreach ($daylist as $key => $daycare) {

		  	     $daycare_baby = Baby::where(['baby.BMrNo'=>$daycare['mr_no.'], 'IsDeleted'=>0])
		  	                     ->leftjoin('baby_admission', 'baby_admission.BabyId', '=', 'baby.BabyId')
		  	                     ->first();

 					$surfactant = \DB::table('nicu_admission')
		                 			->where('BMrNo', $daycare['mr_no.'])
		                 			->select('SurfactantGiven')
		                 			->first();

		           	

		  	     $gestation = explode('+', $daycare['cga']);
		  	     $cgw = isset($gestation[0]) ? (int)$gestation[0] : 0;
		  	     $cgd = isset($gestation[1]) ? (int)$gestation[1] : 0;

		  	     $daycare_date = date('Y-m-d', strtotime($daycare['date']));

		  	     $bp = explode('/', $daycare['bp']);

		  	     $sbp = isset($bp[0]) ? (int)$bp[0] : null;
		  	     $dbp = isset($bp[1]) ? (int)$bp[1] : null;
                  
                   $day_name = 1;

		  	     if (isset($daycare_baby->BabyId)) {

		  	     	  $day_name = Daycare::where('BabyId', $daycare_baby->BabyId)->get(); 
		  	          $day_name = count($day_name) + 1;


		  	     }
		  	   
		  	     $day_name = 'day '.$day_name;

				$data['AdmissionId']		        = 	isset($daycare_baby->AdmissionId) ? $daycare_baby->AdmissionId : 0 ;
				$data['BabyId']		                = 	isset($daycare_baby->BabyId) ? $daycare_baby->BabyId : 0 ;
				$data['MotherId']		            = 	isset($daycare_baby->MotherId)? $daycare_baby->MotherId : 0;
				$data['DateModified']	            = 	$daycare_date;
				$data['Notes']		                = 	$daycare['notes'] ;
				$data['cg_weeks']		            = 	$cgw ;
				$data['cg_days']		            = 	$cgd ;
				$data['DayDate']		            = 	$daycare_date;
				$data['DayTime']		            = 	(int)date('h', strtotime($daycare['time']));
				$data['DayOfLife']		            = 	$daycare['day_of_life'] ;
				$data['CGA']		                = 	json_encode(['cg_weeks'=>$cgw,'cg_days'=>$cgd]);
				$data['Care']		                = 	ucwords($daycare['care']);
				$data['PreviousProblems']	        = 	$daycare['previous_problems'] ;
				$data['CurrentProblems']	        = 	$daycare['current_problems'] ;
				$data['Rop']		                = 	$daycare['rop'] ;
				$data['Plan']		                = 	$daycare['plan'] ;
				$data['Skin']		                = 	$daycare['skin'] ;
				$data['PeripheralCannula']	        = 	$daycare['peripheral_cannula'] ;
				$data['PvcSites']		            = 	null ;
				$data['PvcDay']		                = 	$daycare['pvc_day'] ;
				$data['DayChange']		            = 	$daycare['change'] ;
				$data['PvcComplication']	        = 	$daycare['pvc_complication'] ;
				$data['Picc']		                = 	$daycare['picc'] ;
				$data['PiccSite']		            = 	$daycare['picc_site'] ;
				$data['PiccDay']		            = 	$daycare['picc_day'] ;
				$data['PiccComplication']	        = 	$daycare['picc_complication'] ;
				$data['Uvc']		                = 	$daycare['uvc'] ;
				$data['UvcPosition']		        = 	$daycare['uvc_position'] ;
				$data['UvcDay']		                = 	$daycare['uvc_day'] ;
				$data['UvcComplication']	        = 	$daycare['uvc_complication'] ;
				$data['Uac']		                = 	$daycare['uac'] ;
				$data['UacPosition']		        = 	$daycare['uac_position'] ;
				$data['UacDay']		                = 	$daycare['uac_day'] ;
				$data['UacComplication']	        = 	$daycare['uac_complication'] ;
				$data['Pac']		                = 	$daycare['pac'] ;
				$data['PacSite']		            = 	$daycare['pac_site'] ;
				$data['PacDay']		                = 	$daycare['pac_day'] ;
				$data['PacComplication']	        = 	$daycare['pac_complication'] ;
				$data['Cuss']		                = 	$daycare['cuss'] ;
				$data['Sepsis']		                = 	$daycare['sepsis'] ;
				$data['BloodCulture']		        = 	$daycare['blood_culture'] ;
				$data['Organism']		            = 	serialize($daycare['organism']) ;
				$data['PositiveBlood']		        = 	$daycare['positive_blood_culture_dol'] ;
				$data['Meningitis']		            = 	$daycare['meningitis'] ;
				$data['OtherDrugs']		            = 	serialize([$daycare['other_drugs_1'], $daycare['other_drugs_2'], $daycare['other_drugs_3'], $daycare['other_drugs_4']]) ;
				$data['CRP']		                = 	$daycare['crp_mg_per_l'] ;
				$data['TLC']		                = 	$daycare['tlc'] ;
				$data['Percentage']		            = 	null ;
				$data['ANC']		                = 	$daycare['anc'] ;
				$data['Platelets']		            = 	$daycare['platelets'] ;
				$data['TotalFluid']		            = 	$daycare['total_fluid_mlkgd'] ;
				$data['PreviousWt']		            = 	$daycare['previous_weight'] ;
				$data['CurrentWt']		            = 	$daycare['current_weight'] ;
				$data['WtChange']		            = 	$daycare['weight_change'] ;
				$data['PercentageChange']	        = 	number_format((int)$daycare['percentage_change'], 1);
				$data['UrineOutput']		        = 	$daycare['urine_output_ml'] ;
				$data['UO']		                    = 	$daycare['uo_mlkgh'] ;
				$data['BloodOut']		            = 	$daycare['blood_out'] ;
				$data['DrainOutput']		        = 	$daycare['drain_output'] ;
				$data['RBS']		                = 	$daycare['rbs'] ;
				$data['SerumNa']		            = 	$daycare['serum_na'] ;
				$data['SerumK']		                = 	$daycare['serum_k'] ;
				$data['Transfusion']		        = 	$daycare['transfusion'] ;
				$data['AnteriorFontanelle']	        = 	$daycare['anterior_fontanelle'] ;
				$data['Activity']		            = 	$daycare['activity'] ;
				$data['Tone']		                = 	$daycare['tone'] ;
				$data['Cry']		                = 	$daycare['cry'] ;
				$data['Seizures']		            = 	$daycare['seizures'] ;
				$data['TypeOfSeizures']		        = 	$daycare['type_of_seizures'] ;
				$data['NeonatalReflexes']	        = 	$daycare['neonatal_reflexes'] ;
				$data['CnsFindings']		        = 	$daycare['other_cns_findings'] ;
				$data['Feeds']		                = 	$daycare['feeds_mlkgd'] ;
				$data['Volume']		                = 	$daycare['volume'] ;
				$data['Frequency']		            = 	$daycare['frequency'] ;
				$data['Ivf']		                = 	$daycare['ivf'] ;
				$data['Tpn']		                = 	$daycare['tpn'] ;
				$data['AspirateVolume']		        = 	$daycare['aspirate_volume'] ;
				$data['AspirateNature']		        = 	$daycare['aspirate_nature'] ;
				$data['Stools']		                = 	$daycare['stools'] ;
				$data['StoolNature']		        = 	$daycare['stool_nature'] ;
				$data['Abdomen']		            = 	$daycare['abdomen'] ;
				$data['BowelSounds']		        = 	$daycare['bowel_sounds'] ;
				$data['AbdominalGirth']		        = 	$daycare['abdominal_girth'] ;

				$data['PAFindings']		            = 	$daycare['other_pa_findings'] ;
				$data['AxrFindings']	            = 	$daycare['axr_findings'] ;
				$data['Umbilicus']		            = 	$daycare['umbilicus'] ;
				$data['Hepatomegaly']		        = 	$daycare['hepatomegaly'] ;
				$data['LiverSpan']		            = 	$daycare['liver_span'] ;
				$data['Splenomegaly']		        = 	$daycare['splenomegaly'] ;
				$data['SpleenSpan']		            = 	$daycare['spleen_span'] ;
				$data['Herina']		                = 	$daycare['hernia'] ;
				$data['Genitalia']		            = 	$daycare['genitalia'] ;
				$data['TSB']		                = 	$daycare['tsb'] ;
				$data['NNJTreatment']		        = 	$daycare['nnj_treatment'] ;
				$data['HR']		                    = 	$daycare['hr'] ;
				$data['systolic_bp']		        = 	$sbp ;
				$data['diastolic_bp']		        = 	$dbp ;
				$data['MeanBP']		                = 	$daycare['mean_bp'] ;
				$data['PulsePressure']		        = 	$daycare['pulse_pressure'] ;
				$data['CentralPulses']		        = 	$daycare['central_pulses'] ;
				$data['PeripheralPulses']	        = 	$daycare['peripheral_pulses'] ;
				$data['FemoralPulses']		        = 	$daycare['femoral_pulses'] ;
				$data['PrecordialActivity']	        = 	$daycare['precordial_activity'] ;
				$data['S1S2']		                = 	$daycare['s1_s2'] ;
				$data['Murmur']		                = 	$daycare['murmur'] ;
				$data['CharacterOfMurmur']	        = 	$daycare['character_of_murmur'] ;
				$data['CVSFindings']		        = 	$daycare['other_cvs_findings'] ;
				$data['CFT']		                = 	$daycare['cft'] ;
				$data['CentralTemperature']	        = 	$daycare['central_temperature'] ;
				$data['PeripheralTemperature']		= 	$daycare['peripheral_temperature'] ;
				$data['Color']		                = 	$daycare['color'] ;

				$data['Inotropes']		            = 	$daycare['inotropes'] ;
				$data['Dopamine']		            = 	$daycare['dopamine_mcgkgmin'] ;
				$data['Dobutamine']		            = 	$daycare['dobutamine_mcgkgmin'] ;
				$data['Adrenaline']		            = 	$daycare['adrenaline'] ;
				$data['DayEcho']		            = 	$daycare['echo'] ;
				$data['ModeOfVentilation']		    = 	$daycare['mode_of_ventilation'] ;
				$data['RR']		                    = 	$daycare['rr'] ;
				$data['Retractions']		        = 	$daycare['retractions'] ;
				$data['AirEntry']		            = 	$daycare['airentry'] ;

				$data['ChestMovement']		        = 	$daycare['chest_movement'] ;
				$data['AddedSounds']		        = 	$daycare['added_sounds'] ;
				$data['DayCharacter']		        = 	$daycare['character'] ;
				$data['CXRFindings']		        = 	$daycare['cxr_findings'] ;
				$data['RSFindings']		            = 	$daycare['other_rs_findings'] ;
				$data['Indication']		            = 	$daycare['indication'] ;
				$data['PIP']		                = 	$daycare['pip'] ;
				$data['PEEP']		                = 	$daycare['peep'] ;
				$data['MAP']		                = 	$daycare['map'] ;
				$data['FiO2']		                = 	$daycare['fio2'] ;
				$data['Rate']		                = 	$daycare['rate'] ;
				$data['IT']		                    = 	$daycare['it_in_sec'] ;
				$data['DayOfVentilation']		    = 	$daycare['day_of_ventilation'] ;
				$data['LastBG']		                = 	$daycare['last_abg_at'] ;
				$data['TypeOfBloodGas']		        = 	$daycare['type_of_blood_gas'] ;
				$data['Ph']		                    = 	$daycare['ph'] ;
				$data['PaO2']		                = 	$daycare['pao2'] ;
				$data['PaCo2']		                = 	$daycare['paco2'] ;
				$data['HCO3']		                = 	$daycare['hco3'] ;
				$data['BE']		                    = 	$daycare['be'] ;
				$data['Lactate']	             	= 	$daycare['lactate'] ;
				$data['EtTube']		                = 	$daycare['et_tube'] ;
				$data['Size']		                = 	$daycare['size_in_cm'] ;
				$data['Lips']		                = 	$daycare['cm_at_lips'] ;
				$data['SaO2PostDuctal']		        = 	$daycare['sao2_postductal'] ;
				$data['AaDO2']		                = 	$daycare['aado2'] ;
				$data['OI']		                    = 	$daycare['oi'] ;
			
				$data['PDA']		                = 	strpos(strtoupper($daycare['current_problems']), 'PDA') > 0 ? 'Yes':'';
				$data['PDATreatment']		        = 	null;
				$data['InvasiveVentilation']		= 	null;
				$data['DayTime_MINS']		        = 	(int)date('i', strtotime($daycare['time']));
				$data['DayTime_AM']		            = 	date('A', strtotime($daycare['time']));
				$data['NonInvasiveVentilation']		= 	null;
				$data['OtherRespiratorySupport']	= 	null;
				$data['FullEnteralFeeds']		    = 	null;
				$data['TypeofFeeds']		        = 	null;
				$data['NECtreatment']		        = 	null;
				$data['NEC']		                = 	strpos(strtoupper($daycare['current_problems']), 'PPHN') > 0 ? 'Yes':'';
				$data['Hypoglycemia']		        = 	strpos(strtoupper($daycare['current_problems']), 'Hypoglycemia') > 0 ? 1 : 0 ;
				$data['Hyperglycemia']		        = 	strpos(strtoupper($daycare['current_problems']), 'Hyperglycemia') > 0 ? 1 : 0 ;
				$data['InsulinTherapy']		        = 	strpos(strtoupper($daycare['current_problems']), 'InsulinTherapy') > 0 ? 1 : 0;
				$data['Hyponatremia']		        = 	strpos(strtoupper($daycare['current_problems']), 'Hyponatremia') > 0 ? 1 : 0;
				$data['Hypernatremia']		        = 	strpos(strtoupper($daycare['current_problems']), 'Hypernatremia') > 0 ? 1 : 0;
				$data['Hypokalemia']		        = 	strpos(strtoupper($daycare['current_problems']), 'Hypokalemia') > 0 ? 1 : 0;
				$data['Hyperkalemia']		        = 	strpos(strtoupper($daycare['current_problems']), 'Hyperkalemia') > 0 ? 1 : 0;
				$data['Hypocalcemia']		        = 	strpos(strtoupper($daycare['current_problems']), 'Hypocalcemia') > 0 ? 1 : 0;
				$data['Hypercalcemia']		        = 	strpos(strtoupper($daycare['current_problems']), 'Hypercalcemia') > 0 ? 1 : 0;

				$data['NicuICD']		            = 	json_encode(array()) ;
				$data['Immunoglobulins']		    = 	null;
				$data['Noradrenaline']		        = 	null;
				$data['Milrinone']		            = 	null;
				$data['TherapeuticHypothermia']		= 	null;
				$data['frequency_rep']		        = 	null;
				$data['Flow']		                = 	null;
				$data['Surfactant_therapy_nicu']	= 	(isset($surfactant->SurfactantGiven) && !empty($surfactant->SurfactantGiven)) ? $surfactant->SurfactantGiven : 'No';
				$data['Spontaneouslyventilating']	= 	null;
				$data['Ventilation_choose']		    = 	null;
				$data['day_name']		            = 	$day_name;
				$data['echo_status']		        = 	!empty($daycare['echo']) ?  "Yes" : '';
				$data['pphn']		                = 	strpos(strtoupper($daycare['current_problems']), 'PPHN') > 0 ? 1 : 0;
				$data['pphn_treatement']		    = 	null;
				$data['chronic_lung']		        = 	1;
				$data['surfactant_indication']		= 	null; 
				$data['pvc_number']		            = 	null;

				$data['DateAdded']		            = 	$daycare['date'] ;
				$data['UserAdded']		            = 	0;
				$data['UserDeleted']		        = 	0;
				$data['IsDeleted']		            = 	0;


				$dayid = Daycare::create($data)->DayId;

				  unset($data);


				$data['respiratory_problem']	    = 	'';
				$data['Cardiovascular_problem']	    =  	'';
				$data['isDeleted']	                =  	0;
				$data['UserAdded']	                =  	0;
				$data['UserModified']       	    =  	0;
				$data['DateAdded']          	    =   $daycare['date'];
				$data['DateModified']        	    =  	$daycare['date'];
				$data['DayId']                 	    =  	$dayid;
				$data['BabyId']	                    =  	isset($daycare_baby->BabyId) ? $daycare_baby->BabyId : 0 ;
				$data['AdmissionId']	            =  	isset($daycare_baby->AdmissionId) ? $daycare_baby->AdmissionId : 0 ;
				$data['directlybreastfeed'] 	    =  	0;
				$data['othertypefeed']	            =  	0;
				$data['workingWeight']	            =  	'';
				$data['iv_fluids']	                =  	'';
				$data['drug_infusions']	            =  	'';
				$data['other_drugs']	            =  	'';
				$data['Carbohydrates']	            =  	'';
				$data['Protein']	                =  	'';
				$data['Fat']                  	    =  	'';
				$data['gastrointestinal_problem'] 	= 	'';
				$data['Pupils']	                    = 	'';
				$data['central_problem']	        = 	'';
				$data['sedation_paralysis']	        = 	'';
				$data['urine_output_day']	        = 	'';
				$data['drug_infusions_ml_day']	    = 	'';
				$data['iv_fluids_ml_day']	        = 	'';
				$data['total_energy']	            = 	'';
				$data['neuro_sonogram']	            = 	'Not performed';
				$data['gir']	                    = 	'';
				$data['needlethoracentesis']	    = 	1;
				$data['intercostaldrain']	        = 	1;
				$data['ultrasoundabdominal']	    = 	1;
				$data['ultrasoundkeyfindings']	    = 	'';
				$data['renalultrasound']	        = 	1;
				$data['renalultrasoundkeyfindings']	= 	'';
				$data['mri_ct_brain']	            = 	'';
				$data['mrict_brain_status']	        = 	1;
				$data['viral_meningitis']	        = 	1;
				$data['lumbar_puncture']	        = 	'Not Performed';
				$data['ultrasound_spine']	        = 	1;
				$data['ultrasound_spine_report']	= 	'';
				$data['dilution_exchange']       	= 	1;  

		  	     DaycareQuestions::create($data);
		  }
	}
}
