<?php

namespace App\Http\Controllers\Import;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NicuImportController extends Controller
{
    private function nicuImports() 
	{

		 $nicuadmission = Excel::load(public_path().'/im/nicuadmissionproforma.xls', function ($reader) {
			         
			         $nicuadmission = $reader->skipRows(1)->takeRows(1002)->get();
		   
		    })->all();

		 	foreach ($nicuadmission as $key => $nicumvalue) {

		 		

					$vaccine[]       = $nicumvalue['vaccine1']; 
		        	$vaccine[]       = $nicumvalue['vaccine2'];
		        	$vaccine[]       = $nicumvalue['vaccine3'];
		        	$vaccine[]       = $nicumvalue['vaccine4'];

		        	$ivantibio[]       = $nicumvalue['iv_antibiotic_1'];
		        	$ivantibio[]       = $nicumvalue['iv_antibiotic_2'];
		        	$ivantibio[]       = $nicumvalue['iv_antibiotic_3'];
		        	$ivantibio[]       = $nicumvalue['iv_antibiotic_4'];

		        	$problem_temp[]    = $nicumvalue['med_prob._3'];
		        	$problem_temp[]    = $nicumvalue['med_prob._4'];
		        	$problem_temp[]    = $nicumvalue['med_prob._5'];

		        	$temp_medication[] = $nicumvalue['discharge_medications_1'];
		        	$temp_medication[] = $nicumvalue['discharge_medications_2'];
		        	$temp_medication[] = $nicumvalue['discharge_medications_3'];
		        	$temp_medication[] = $nicumvalue['discharge_medications_4'];
		        	$temp_medication[] = $nicumvalue['discharge_medications_5'];

		        	$complications[]   = isset($nicumvalue['complications_4']) ? $nicumvalue['complications_4'] : null;
		        	$complications[]   = isset($nicumvalue['complications_5']) ? $nicumvalue['complications_5'] : null;

		        	// $temp_mode[]       = $nicumvalue['mode'];
		        

			}


			//create master for vaccine

           if (isset($vaccine)) {
			$vaccine          = array_unique($vaccine);

			foreach ($vaccine as $value) {

				  $drugs = Vaccine::where('Name', $value)->first();

				 	if (!empty($value) && count($drugs) < 1) {

				 	   $medi = array('Name'   => $value,
				 	   	             'Status' => 'InActive');
				 	   Vaccine::create($medi);

				 	}

		    } 	
	 }

            //create antibiotic master 
	  if (isset($ivantibio)) {
			$ivantibio        = array_unique($ivantibio);

			foreach ($ivantibio as $value) {

				  $ivantibios = AntibioticMaster::where('Name', $value)->first();

				 	if (!empty($value) && count($ivantibios) < 1) {

				 	   $medi = array('Name'   => $value,
				 	   	             'Status' => 'InActive');
				 	   AntibioticMaster::create($medi);

				 	}

		    } 	
      }
			
			// $temp_mode        = array_unique($temp_mode); 



       

          //creating master problems 
      if (isset($problem_temp)) {
			$problem_temp     = array_unique($problem_temp);   

              foreach ($problem_temp as $mediproblemValues) {

          	     $comcheck = MediprobsMaster::where('Name', $mediproblemValues)->get();

          	    if (!empty($mediproblemValues) && count($comcheck) == 0) {

			         $master_prob = array('Name'   =>$mediproblemValues,
						            'Status' =>'InActive');

		              MediprobsMaster::create($master_prob);

          	    }

             }
       }      

             //create medication master 
       if (isset($temp_medication)) {    
            $temp_medication = array_unique($temp_medication);

				  foreach ($temp_medication as $value) {
				  $drugs = DrugIvFluidMaster::where('brand_name', $value)->where('type', 'ORAL')->first();

				 	if (!empty($value) && count($drugs) < 1) {

				 	   $medi = array('brand_name'   => $value,
				 	   	             'status' => 'InActive');
				 	   
				 	   DrugIvFluidMaster::create($medi);

				 	}

		    }
		}    

        if (isset($complications)) { 
           //creating master complication 

         $complications = array_unique($complications);

          foreach ($complications as $complicationsValues) {

          	  $comcheck = Complications::where('Name', $complicationsValues)->get();

          	 if (!empty($complicationsValues) && count($comcheck) == 0) {

			    $master_com = array('Name'   =>$complicationsValues,
						            'Status' =>'InActive');

		           Complications::create($master_com);

          	 }

          }
        }  

				


		foreach ($nicuadmission as $key => $nicuvalue) {


                $nicubaby = Baby::where(['BMrNo'=>$nicuvalue['mr_no.'], 'IsDeleted'=>0])->first();

                $preadmission = Admission::where(['BMrNo'=>$nicuvalue['mr_no.']])->count()+1;

                $mode  =  Admissionmode::where(['Mode_name'=>$nicuvalue['mode']])->first();

                $admissionExist = Admission::where(['BMrNo'=>$nicuvalue['mr_no.'], 'AdmissionDate'=> date('Y-m-d', strtotime($nicuvalue['date']))])->first();


                 $discharge_status = \DB::table('neonatal_proforma')
	                      ->where('BMrNo', $nicuvalue['mr_no.'])
		                 	->first(); 

 
                //creating the baby admission 
              if (isset($nicubaby->BabyId) && count($admissionExist) == 0) {

                  $baby_admission['BabyId']          = $nicubaby->BabyId; 
                  $baby_admission['BMrNo']           = $nicuvalue['mr_no.']; 
                  $baby_admission['MotherId']        = $nicubaby->MotherId; 
                  $baby_admission['AdmissionDate']   = date('Y-m-d', strtotime($nicuvalue['date'])); 
                  $baby_admission['AdmissionTime']   = date('h:i:a', strtotime($nicuvalue['time'])); 
                  $baby_admission['InOrOut']         = 'In'; 
                  $baby_admission['AdmissionType']   = 'NICU'; 
                  $baby_admission['Status']          = isset($discharge_status->Status) ? $discharge_status->Status  :'Inpatient'; 
                  $baby_admission['UserAdded']       =  0; 
                  $baby_admission['DateAdded']       =  date('Y-m-d', strtotime($nicuvalue['date']));
                  $baby_admission['DateModified']    =  date('Y-m-d', strtotime($nicuvalue['date']));
                  $baby_admission['episodes']        =  'Admission '.$preadmission;
                  $admission_id                      = Admission::create($baby_admission)->AdmissionId;




				$vaccinemas         = [$nicuvalue['vaccine1'],$nicuvalue['vaccine2'],$nicuvalue['vaccine3'],$nicuvalue['vaccine4']]; 
			    $vaccine_date       = [$nicuvalue['date1'],$nicuvalue['date2'],$nicuvalue['date3'],$nicuvalue['date4']]; 
                $vaccine_master     = Vaccine::whereIn('Name', $vaccinemas)->pluck('Id')->toArray();

                $antibiotic         = [$nicuvalue['iv_antibiotic_1'],$nicuvalue['iv_antibiotic_2'],$nicuvalue['iv_antibiotic_3'],$nicuvalue['iv_antibiotic_4']];
                $antibiotic_master  = AntibioticMaster::whereIn('Name', $antibiotic)->pluck('Name', 'Id')->unique()->keys()->toArray();

      

			        $data['BMrNo']       	            = 	$nicuvalue['mr_no.'];
					$data['diastolic_bp'] 	            = 	isset($nicuvalue['diastolic_bp']) ? $nicuvalue['diastolic_bp'] : null ;
					$data['AdmissionId'] 	            = 	$admission_id;
				    $data['BabyId']      	            = 	isset($nicubaby->BabyId) ? $nicubaby->BabyId : 0 ;
					$data['MotherId']    	            = 	isset($nicubaby->MotherId) ? $nicubaby->MotherId : 0 ;
					$data['Abnormalities'] 	            = 	$nicuvalue['abnormalities'];
					$data['AdmissionType'] 	            = 	$nicuvalue['admission_type'];
					$data['AdmissionWt'] 	            = 	$nicuvalue['admission_wt'];

					$data['AdmittedFrom'] 	            = 	$nicuvalue['admitted_from'];
					$data['Advice']      	            = 	$nicuvalue['advice'];
					$data['Age']         	            = 	$nicuvalue['age'];
					$data['AgeAfterBirth']       	    = 	$nicuvalue['age_after_birth'];
					$data['AgeofCXR'] 	                = 	$nicuvalue['age_of_cxr'];
					$data['AgeOfTransferToNICU'] 	    = 	$nicuvalue['age_of_transfer_to_nicu'];
					$data['AgeOnAdmissioninDays'] 	    = 	$nicuvalue['age_on_admission_in_days'];
					$data['AgeTaken'] 	                = 	$nicuvalue['age_taken'];
					$data['Alcohol'] 	                = 	$nicuvalue['alcohol'];
					$data['Apgar5Mins'] 	            = 	$nicuvalue['apgar_score_at_5_mins'];
					$data['BWeight'] 	                = 	$nicuvalue['sex_birth_wt_gestation'];
					$data['BaseExcess'] 	            = 	$nicuvalue['base_excess'];
					$data['BE'] 	                    = 	$nicuvalue['be'];
					$data['BP'] 	                    = 	$nicuvalue['bp'];
					$data['CFT'] 	                    = 	$nicuvalue['cft'];
					$data['CGAatDischarge'] 	        = 	$nicuvalue['cga_at_discharge'];
					$data['ChestMovement']        	    = 	$nicuvalue['chest_movement'];
					$data['CorrectedGestation'] 	    = 	json_encode(['cg_weeks'=>$nicuvalue['corrected_gestation'], 'cg_days'=>0]);
					$data['AdmissionDate'] 	            = 	$nicuvalue['date'];
					$data['DischargeDate']           	= 	date('Y-m-d', strtotime($nicuvalue['date_of_discharge']));
					$data['DescriptionOfResuscitation'] = 	$nicuvalue['description_of_resuscitation'];
					$data['DifferentialDiagnosis'] 	    = 	$nicuvalue['differential_diagnosis'];
					$data['discharge_cuss'] 	        = 	$nicuvalue['discharge_cuss'];
					$data['DischargeHb'] 	            = 	$nicuvalue['discharge_hb'];
					$data['DischargePCV'] 	            = 	$nicuvalue['discharge_pcv'];
					$data['DischargeSerumALP'] 	        = 	$nicuvalue['discharge_serum_alp'];
					$data['DischargeSerumCa'] 	        = 	$nicuvalue['discharge_serum_ca'];
					$data['DischargeSerumNa'] 	        = 	$nicuvalue['discharge_serum_na'];
					$data['DischargeSerumPo4'] 	        = 	$nicuvalue['discharge_serum_po4'];
					$data['DischargeTSB'] 	            = 	$nicuvalue['discharge_tsb'];

					$data['DischargeWeight']          	= 	$nicuvalue['discharge_weight_in_gm'];
					$data['DOLatDischarge']          	= 	$nicuvalue['dol_at_discharge'];
					$data['Dose']                    	= 	$nicuvalue['dose'];

					$fad = '';

					if ($nicuvalue['feeding_at_discharge'] =='Direct Breast Feeding' || $nicuvalue['feeding_at_discharge'] == 'DBF') {

						$fad = 'Directly Breast Fed';

					} elseif ($nicuvalue['feeding_at_discharge'] =='DBF + EBM Top up') {

						$fad = 'Fed DBF + EBM Top up';

					} elseif ($nicuvalue['feeding_at_discharge'] =='DBF + Formula Top up') {

						$fad = 'Fed DBF + Formula Top up';

					} elseif ($nicuvalue['feeding_at_discharge'] =='DBF + EBM/Formula Top up') {

						$fad = 'Fed DBF + EBM/Formula Top up';

					} elseif ($nicuvalue['feeding_at_discharge'] =='Spoon Feeding EBM') {
						$fad = 'Spoon Fed with EBM';

					} elseif ($nicuvalue['feeding_at_discharge'] =='Spoon Feeding Formula') {

						$fad = 'Spoon Fed with Formula';

					} elseif ($nicuvalue['feeding_at_discharge'] =='Bottle Feeding') {

						$fad = 'Bottle Fed';

					}


					$data['FeedingAtDischarge']      	= 	$fad;
					$data['FinalDiagnosis']           	= 	$nicuvalue['final_diagnosis'];
					$data['Fio2']                      	= 	$nicuvalue['fio2'];

					$data['Fluids']                    	= 	$nicuvalue['fluids_mlkgd'];
					$data['HCO3']                       = 	$nicuvalue['hco3'];
					$data['Hct']                       	= 	$nicuvalue['hct'];
					$data['HearingScreening']          	= 	$nicuvalue['hearing_screening'];
					$data['HR']                       	= 	$nicuvalue['hr_in_bpm'];
					$data['Immunization']            	= 	$nicuvalue['immunization'];
					$data['Indications']              	= 	$nicuvalue['indications'];
					$data['InitialBloodGas']         	= 	$nicuvalue['initial_blood_gas'];

					$data['InitialXray']               	= 	($nicuvalue['initial_cxr_finding'] =='not done' || empty($nicuvalue['initial_cxr_finding']) || $nicuvalue['initial_cxr_finding'] =='ND') ? 'Not done' : 'Performed' ;
					$data['Investigations']             = 	$nicuvalue['investigations'];
					$data['IT']                       	= 	$nicuvalue['it'];
					$data['IVAntibiotic']              	= 	serialize($antibiotic_master);

					$data['Length']                    	= 	$nicuvalue['length_in_cm'];
					$data['LowestSerumPh']             	= 	$nicuvalue['lowest_serum_ph'];
					$data['LowestTemperature']         	= 	$nicuvalue['lowest_temperature'];
					$data['MajorComplaints']          	= 	$nicuvalue['major_complaints'];
					$data['MattersDiscussed']           = 	$nicuvalue['matters_discussed'];
					$data['MBP']                      	= 	$nicuvalue['mbp'];
					$data['MeanBP']                   	= 	$nicuvalue['mean_bp'];
					$data['Mode']                      	= 	isset($mode->Id) ? $mode->Id : '' ;

					$data['MultipleSeizures']          	= 	$nicuvalue['multiple_seizures'];
					$data['NBM']                     	= 	$nicuvalue['nbm'];
					$data['NeurologicalStatus']       	= 	$nicuvalue['neurological_status'];
					$data['NicuNewBornScreen']        	= 	isset($discharge_status->NewBornScreen) ? $discharge_status->NewBornScreen : '';

					$data['NextAppointment']          	= 	date('Y-m-d', strtotime(substr(trim($nicuvalue['next_appointment']), 0, 10)));

					$data['OFC'] 	                    = 	$nicuvalue['ofc_in_cm'];
					$data['PaCo2'] 	                    = 	$nicuvalue['paco2'];
					$data['PaO2'] 	                    = 	$nicuvalue['pao2'];
					$data['ParentsAddressedBy'] 	    = 	$nicuvalue['parents_addressed_by'];
					$data['ParentsSpokenTo'] 	        = 	$nicuvalue['parents_spoken_to'];
					$data['PEEP'] 	                    = 	$nicuvalue['peep'];
					$data['pH'] 	                    = 	$nicuvalue['ph'];
					$data['Pip'] 	                    = 	$nicuvalue['pip'];
					$data['Plan'] 	                    = 	$nicuvalue['plan'].$nicuvalue['notes'];
					$data['Po2Fio2Ratio'] 	            = 	$nicuvalue['po2_fio2_ratio'];
					$data['PregnancyComplications'] 	= 	$nicuvalue['pregnancy_complications'];
					$data['Problem'] 	                = 	$nicuvalue['problem'];
					$data['PbmProcedure'] 	            = 	$nicuvalue['procedure'];

					$data['Rate'] 	                    = 	$nicuvalue['rate'];
					$data['RBS']                      	= 	$nicuvalue['rbs'];
					$data['Readmission'] 	            = 	$nicuvalue['readmission'];
					$data['ReferralReason'] 	        = 	$nicuvalue['reason_for_referral'];
					$data['ReferredBy'] 	            = 	$nicuvalue['referred_by'];
					$data['Rop'] 	                    = 	$nicuvalue['rop_check'];
					$data['RopScreening'] 	            = 	$nicuvalue['rop_screening'];
					$data['RR'] 	                    = 	$nicuvalue['rr'];
					$data['Schedule'] 	                = 	$nicuvalue['schedule'];
					$data['SepsisScreen'] 	            = 	$nicuvalue['sepsis_screen'];
					$data['SexBirthWtGestation'] 	    = 	$nicuvalue['sex_birth_wt_gestation'];
					$data['SgaLessThan3rdPercentile'] 	= 	$nicuvalue['sga_less_than_3rd_percentile'];
					$data['Skin']                     	= 	$nicuvalue['skin'];
					$data['Smoking']                  	= 	$nicuvalue['smoking'];
					$data['SpO2']                    	= 	$nicuvalue['spo2'];
					$data['status']                    	= 	isset($discharge_status->Status) ? $discharge_status->Status  :'Inpatient';
					$data['SurfactantGiven']         	= 	$nicuvalue['surfactant_given'];
					$data['SurfactantType']           	= 	$nicuvalue['surfactant_type'];
					$data['Surgeon']                 	= 	$nicuvalue['surgeon'];
					$data['Temperature']              	= 	number_format($nicuvalue['temperature'], 1);
					$data['TemperatureAtAdmission']   	= 	$nicuvalue['temperature_at_admission'];

					$data['DiscussionTime']          	= 	date('h:i:A', strtotime($nicuvalue['time_of_discussion']));
					$data['TransferTime']            	= 	$nicuvalue['time_of_transfer_to_nicu'];
					$data['Tobacco']                  	= 	$nicuvalue['tobacco'];
					$data['Tone']                     	= 	$nicuvalue['tone'];
					$data['TotalCRIB2Score'] 	        = 	$nicuvalue['total_crib_ii_score'];
					$data['TotalSNAP2Score'] 	        = 	$nicuvalue['total_snap_ii_score'];
					$data['TotalSNAPPE2Score'] 	        = 	$nicuvalue['total_snappe_ii_score'];
					$data['TransferFiO2'] 	            = 	$nicuvalue['transfer_fio2'];
					$data['TypeOfCare']              	= 	$nicuvalue['type_of_care'];
					$data['UAC']                       	= 	$nicuvalue['uac'];
					$data['UACPosition']               	= 	$nicuvalue['uac_position'];
					$data['UrineOutput']              	= 	$nicuvalue['urine_output'];
					$data['UVC']                       	= 	$nicuvalue['uvc'];
					$data['UVCPosition']              	= 	$nicuvalue['uvc_position'];
					$data['Ventilation']               	= 	($nicuvalue['transfer_fio2'] > 21) ? 'Yes': 'No';
					$data['VentilationRequired'] 	    = 	$nicuvalue['ventilation_required'];

					$data['SeenBy']                  	= 	0;
					$data['UserAdded']                	= 	0;
					$data['UserDeleted']              	= 	0;
					$data['IsDeleted']                	= 	0;
					$data['DateAdded']                 	= 	date('Y-m-d', strtotime($nicuvalue['date']));
					$data['DateModified'] 	            = 	date('Y-m-d', strtotime($nicuvalue['date']));
					$data['HomeOxygen'] 	            = 	'';
                
                //string in formate 
					$data['NAT_TIME'] 	                = 	'';
					$data['NAT_MINS'] 	                = 	'';
					$data['NAT_AM']                  	= 	'';
			  //string in formate		

					$data['AdmissionTime']            	= 	(int)date('h', strtotime($nicuvalue['time']));
					$data['AdmissionTime_MINS'] 	    = 	(int)date('i', strtotime($nicuvalue['time']));
					$data['AdmissionTime_AM'] 	        = 	date('A', strtotime($nicuvalue['time']));
					
					//not in use
					$data['TransferTime_MINS'] 	        = 	'';
					$data['TransferTime_AM'] 	        = 	'';
                      //not in use
					$data['TransferDate'] 	            = date('Y-m-d', strtotime($nicuvalue['time_of_transfer_to_nicu']));

                    // need to check 
					$data['ROPTreatment'] 	            = 	$nicuvalue['rop_check'];

					$data['TypeofTreatmen'] 	        = 	'';

					$data['DateofAdministration'] 	    = 	date('Y-m-d', strtotime($nicuvalue['time_of_administration']));
					$data['TimeOfAdministration']    	= 	(int)date('h', strtotime($nicuvalue['time_of_administration']));
					$data['TimeOfAdministration_MINS'] 	= 	(int)date('i', strtotime($nicuvalue['time_of_administration']));
					$data['TimeOfAdministration_AM'] 	= 	date('A', strtotime($nicuvalue['time_of_administration']));

					$data['Vaccine']                  	= 	is_array($vaccine_master) ? serialize($vaccine_master) : serialize(array());
					$data['VaccineDate']               	= 	serialize($vaccine_date);

					$data['NicuDCT']                 	= 	'';
					$data['xrayfindings']            	= 	($nicuvalue['initial_cxr_finding'] == 'not done' || empty($nicuvalue['initial_cxr_finding'])) ? '' : $nicuvalue['initial_cxr_finding'];
					
					$data['Flow_l_min']              	= 	'';
					$data['amplitude_delta']          	= 	'';
					$data['mean_airway_pressure']      	= 	'';
					
					$data['NextAppointmentStatus']     	= 	empty($nicuvalue['next_appointment']) ? 'No' : 'Yes';
					$data['AdmissionNo'] 	            = 	$nicuvalue['admission_no.'];
					
					$data['additional_diagnosis']     	= 	json_encode(array($nicuvalue['final_diagnosis'],$nicuvalue['differential_diagnosis']));
					
					$cga = !empty($nicuvalue['cga_at_discharge']) ? explode('+', $nicuvalue['cga_at_discharge']) : array();
					
					$data['corrected_gestation']      	= 	json_encode(['dcg_weeks'=>isset($cga[0]) ? $cga[0] : 0 , 'dcg_days'=>isset($cga[1]) ? $cga[1] : 0]);;
					
					$data['direct_bilirubin'] 	        = 	'';
					$data['rop_follow_up'] 	            = 	null;
					$data['diedTime'] 	                = 	null;
					$data['diedMins']        	        = 	null;
					$data['diedAm']           	        = 	'';
					$data['nicu_retractions'] 	        = 	'';
					$data['nicu_airentry'] 	            = 	'';
					$data['nicu_central_pulses'] 	    = 	'';
					$data['nicu_peripheral_pulses'] 	= 	'';
					$data['nicu_femoral_pulses'] 	    = 	'';

					$data['nicu_s1s2'] 	                = 	'';
					$data['nicu_murmur'] 	            = 	'';
					$data['nicu_color']              	= 	'';
					$data['nicu_abdomen'] 	            = 	'';
					$data['nicu_bowel_sounds'] 	        = 	'';
					$data['nicu_umbilicus']   	        = 	'';
					$data['nicu_hepatomegaly'] 	        = 	'';
					$data['nicu_splenomegaly'] 	        = 	'';
					$data['nicu_herina'] 	            = 	'';
					$data['nicu_genitalia']   	        = 	'';
					$data['nicu_pupils'] 	            = 	'';
					$data['nicu_anteriorfontanelle'] 	= 	'';
					$data['nicu_activity'] 	            = 	'';
					$data['nicu_cry'] 	                = 	'';
					$data['nicu_seizures'] 	            = 	'';
					$data['nicu_neonatalreflexes'] 	    = 	''; 
					$data['air_flow']    	            = 	null;
					$data['oxgen_flow']   	            = 	null;
					$data['delivery_cpap'] 	            = 	'No';

					if (!empty($nicuvalue['med_prob._3'])) {
		                $medprom = MediprobsMaster::where('Name', $nicuvalue['med_prob._3'])->first();
                          if (count($medprom) > 0) {
							$pbms = array(
								'Problem'    => $medprom->Id,
								'Medication' => $nicuvalue['medication3'],
								'MotherId'	 => $nicubaby->MotherId,
								'BabyId' 	 => $nicubaby->BabyId
							);
							Problems::create($pbms);
                          }
					
			        }
			        if (!empty($nicuvalue['med_prob._4'])) {
		                $medprom = MediprobsMaster::where('Name', $nicuvalue['med_prob._4'])->first();
                          if (count($medprom) > 0) {
							$pbms = array(
								'Problem'    => $medprom->Id,
								'Medication' => $nicuvalue['medication4'],
								'MotherId'	 => $nicubaby->MotherId,
								'BabyId' 	 => $nicubaby->BabyId
							);
							Problems::create($pbms);
                          }
					
			        }
			        if (!empty($nicuvalue['med_prob._5'])) {
		                $medprom = MediprobsMaster::where('Name', $nicuvalue['med_prob._5'])->first();
                          if (count($medprom) > 0) {
							$pbms = array(
								'Problem'    => $medprom->Id,
								'Medication' => $nicuvalue['medication5'],
								'MotherId'	 => $nicubaby->MotherId,
								'BabyId' 	 => $nicubaby->BabyId
							);
							Problems::create($pbms);
                          }
					
			        }


			       if (!empty($nicuvalue['usg_doppler_1_gestation']) && !empty($nicuvalue['usg_doppler_1_finding'])) {

			                $usg = array(
			                    'Gestation' => substr(trim($nicuvalue['usg_doppler_1_gestation']), 0, 2),
			                    'Finding'   => $nicuvalue['usg_doppler_1_finding'],
			                    'MotherId'  => $nicubaby->MotherId,
			                    'BabyId'    => $nicubaby->BabyId,
			                    'flags'     => 2,
			                    'type'      => 4,
			                );
			                Usg::create($usg);
			        }   

			        if (!empty($nicuvalue['usg_doppler_2_gestation']) && !empty($nicuvalue['usg_doppler_2_finding'])) {
			                
			                $usg = array(
			                    'Gestation' => substr(trim($nicuvalue['usg_doppler_2_gestation']), 0, 2),
			                    'Finding'   => $nicuvalue['usg_doppler_2_finding'],
			                    'MotherId'  => $nicubaby->MotherId,
			                    'BabyId'    => $nicubaby->BabyId,
			                    'flags'     => 2,
			                    'type'      => 4,
			                );
			                Usg::create($usg);
			        }

			        if (!empty($nicuvalue['usg_doppler_3_gestation']) && !empty($nicuvalue['usg_doppler_3_finding'])) {
			               
			                $usg = array(
			                    'Gestation' => substr(trim($nicuvalue['usg_doppler_3_gestation']), 0, 2),
			                    'Finding'   => $nicuvalue['usg_doppler_3_finding'],
			                    'MotherId'  => $nicubaby->MotherId,
			                    'BabyId'    => $nicubaby->BabyId,
			                    'flags'     => 2,
			                    'type'      => 4,
			                );
			                Usg::create($usg);
			        }  

			        if (!empty($nicuvalue['usg_4_gestation'])) {

							$usg = array(
								'Gestation' => $nicuvalue['usg_4_gestation'],
								'Finding'	=> $nicuvalue['usg_4_findings'],
								'MotherId'	=> $nicubaby->MotherId,
								'BabyId'	=> $nicubaby->BabyId,
								'flags'     => 1,
								'type'      => 3,
							);
					    Usg::create($usg);
			        }

			        if (!empty($nicuvalue['usg_5_gestation'])) {

							$usg = array(
								'Gestation' => $nicuvalue['usg_5_gestation'],
								'Finding'	=> $nicuvalue['usg_5_findings'],
								'MotherId'	=> $nicubaby->MotherId,
								'BabyId'	=> $nicubaby->BabyId,
								'flags'     => 1,
								'type'      => 3,
							);
					    Usg::create($usg);
			        }

			        if ($nicuvalue['complication_4']!='') {

						$com = Complications::where('Name', $nicuvalue['complication_4'])->first();
							$complications[] = array(

								'Complication'      => isset($com->Id) ? $com->Id : 0 ,
								'Treatment'         => !empty($nicuvalue['treatment4']) ? $nicuvalue['treatment4'] : '',
								'duration_in_weeks'	=> null,
								'AdmissionId'	    => $admission_id,
								'BabyId'	        => $nicubaby->BabyId,
							);
						Complication::create($complications);	
			        }

			        if ($nicuvalue['complication_5']!='') {

						$com = Complications::where('Name', $nicuvalue['complication_5'])->first();
							$complications[] = array(

								'Complication'      => isset($com->Id) ? $com->Id : 0 ,
								'Treatment'         => !empty($nicuvalue['treatment5']) ? $nicuvalue['treatment5'] : '',
								'duration_in_weeks'	=> null,
								'AdmissionId'	    => $admission_id,
								'BabyId'	        => $nicubaby->BabyId,
							);

						 Complication::create($complications);	
	
			        }

			        if (!empty(trim($nicuvalue['discharge_medications_1']))) {
                      $drug = DrugIvFluidMaster::where('brand_name', $nicuvalue['discharge_medications_1'])->where('type', 'ORAL')->first();
                     
                      if (count($drug) > 0) {

	                    $discharge_medications = array(
	                        'Medication'  => $drug->id,
	                        'Dose'        => $nicuvalue['dose_1'],
	                        'Frequency'   => $nicuvalue['frequency_1'],
	                        'Duration'    => $nicuvalue['duration_1'],
	                        'genericname' =>'',
	                        'formulation' =>'',
	                        'AdmissionId' =>$admission_id,
	                        'BabyId'      => $nicubaby->BabyId,
	                        'flag'        =>2,
	                        'source_id'   =>0

	                    );
	                    Medications::create($discharge_medications);
	                  }  

                    }

                    unset($discharge_medications);

                     if (!empty(trim($nicuvalue['discharge_medications_2']))) {
                      $drug = DrugIvFluidMaster::where('brand_name', $nicuvalue['discharge_medications_2'])->where('type', 'ORAL')->first();

                      if (count($drug) > 0) {

		                    $discharge_medications = array(
		                        'Medication'  => $drug->id,
		                        'Dose'        => $nicuvalue['dose_2'],
		                        'Frequency'   => $nicuvalue['frequency_2'],
		                        'Duration'    => $nicuvalue['duration_2'],
		                        'genericname' =>'',
		                        'formulation' =>'',
		                        'AdmissionId' =>$admission_id,
		                        'BabyId'      => $nicubaby->BabyId,
		                        'flag'        =>2,
		                        'source_id'   =>0

		                    );
		                    Medications::create($discharge_medications);
	                   }  

                    }

                    unset($discharge_medications);

                     if (!empty(trim($nicuvalue['discharge_medications_3']))) {
                      $drug = DrugIvFluidMaster::where('brand_name', $nicuvalue['discharge_medications_3'])->where('type', 'ORAL')->first();
                      if (count($drug) > 0) {

	                    $discharge_medications = array(
	                        'Medication'  => $drug->id,
	                        'Dose'        => $nicuvalue['dose_3'],
	                        'Frequency'   => $nicuvalue['frequency_3'],
	                        'Duration'    => $nicuvalue['duration_3'],
	                        'genericname' =>'',
	                        'formulation' =>'',
	                        'AdmissionId' =>$admission_id,
	                        'BabyId'      => $nicubaby->BabyId,
	                        'flag'        =>2,
	                        'source_id'   =>0

	                    );
	                    Medications::create($discharge_medications);
	                  }  

                    }

                    unset($discharge_medications);

                     if (!empty(trim($nicuvalue['discharge_medications_4']))) {
                      $drug = DrugIvFluidMaster::where('brand_name', $nicuvalue['discharge_medications_4'])->where('type', 'ORAL')->first();
                       if (count($drug) > 0) {
	                    $discharge_medications = array(
	                        'Medication'  => $drug->id,
	                        'Dose'        => $nicuvalue['dose_4'],
	                        'Frequency'   => $nicuvalue['frequency_4'],
	                        'Duration'    => $nicuvalue['duration_4'],
	                        'genericname' =>'',
	                        'formulation' =>'',
	                        'AdmissionId' =>$admission_id,
	                        'BabyId'      => $nicubaby->BabyId,
	                        'flag'        =>2,
	                        'source_id'   =>0

	                    );
	                    Medications::create($discharge_medications);
	                  }  

                    }

                    unset($discharge_medications);

                    if (!empty(trim($nicuvalue['discharge_medications_5']))) {

                     if (count($drug) > 0) {
 	
                        $drug = DrugIvFluidMaster::where('brand_name', $nicuvalue['discharge_medications_5'])->where('type', 'ORAL')->first();
	                    $discharge_medications = array(
	                        'Medication'  => $drug->id,
	                        'Dose'        => $nicuvalue['dose_5'],
	                        'Frequency'   => $nicuvalue['frequency_5'],
	                        'Duration'    => $nicuvalue['duration_5'],
	                        'genericname' =>'',
	                        'formulation' =>'',
	                        'AdmissionId' =>$admission_id,
	                        'BabyId'      => $nicubaby->BabyId,
	                        'flag'        =>2,
	                        'source_id'   =>0

	                    );
	                    Medications::create($discharge_medications);
	                  }  

                    }

                    unset($discharge_medications);	

                    Nicu::create($data);
             }       	            

		    }	
	}
}
