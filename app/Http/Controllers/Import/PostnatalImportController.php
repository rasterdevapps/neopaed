<?php

namespace App\Http\Controllers\Import;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostnatalImportController extends Controller
{
   public function postnatal()
   {
   	
		$neonatal = \DB::table('neonatal_proforma')
		                ->where('transfer_status', 'Postnatal Ward')
		                ->get();

		foreach ($neonatal as $key => $value) {
		         $neonatal_proforma = (array)$value;      

		                            		                
			$baby_details                                   =   Baby::find($neonatal_proforma['BabyId']);  
			$postnatal_admission['BabyId']	                =   $neonatal_proforma['BabyId'];
			$postnatal_admission['MotherId']	            =   $baby_details->MotherId;
			$postnatal_admission['AdmissionId']	            =   $neonatal_proforma['AdmissionId'];
			$postnatal_admission['BMrNo']	                =   $neonatal_proforma['BMrNo'];
			$postnatal_admission['referredby']	            =   null;
			$postnatal_admission['referralreason']	        =   null;

		    $dayoflife    = \SiteHelpers::calculate_day_of_life_two($baby_details->DOB, $neonatal_proforma['TestDate']);
		    $gestationday = \SiteHelpers::convert_gestation_days($baby_details->Gestation);
		    $gestation    =  \SiteHelpers::calculate_corrected_gestation($gestationday, $dayoflife);

			$postnatal_admission['admission_cg']	        = 	json_encode(['cg_weeks'=>isset($gestation[0]) ? $gestation[0] : null, 
				                                                             'cg_days' =>isset($gestation[1]) ? $gestation[1] : null
				                                                            ]);

			$postnatal_admission['admission_time_hour']  	= 	$neonatal_proforma['TEST_TIME'];
			$postnatal_admission['admission_time_mins']	    = 	$neonatal_proforma['TEST_MINS'];
			$postnatal_admission['admission_time_session']	= 	$neonatal_proforma['TEST_AM'];
			$postnatal_admission['admission_date']	        = 	$neonatal_proforma['TestDate'];
			$postnatal_admission['typeofcare']	            = 	null;
			$postnatal_admission['ip_number']	            = 	null;
			$postnatal_admission['admission_wt']         	= 	null;
			$postnatal_admission['ageonadmissionindays']	= 	$dayoflife;
			$postnatal_admission['surgeon']	                = 	null;
			$postnatal_admission['seenby']	                = 	$neonatal_proforma['SeenBy'];
			$postnatal_admission['admitted_from']	        = 	(isset($baby_details->BirthStatus) && $baby_details->BirthStatus == 'Inborn') ? 'Labour ward': 'Outside Hospital';
			$postnatal_admission['major_complaints']    	= 	$neonatal_proforma['InitialExamination'];
            $new_born_details                               =   Newborn::where(['BabyId'=>$neonatal_proforma['BabyId'], 'MotherId'=>$baby_details->MotherId])->first(); 
			$postnatal_admission['ventilation']	            = 	null;
			$postnatal_admission['mode']                	= 	null;
			$postnatal_admission['pip']                 	= 	null;
			$postnatal_admission['peep']	                = 	null;
			$postnatal_admission['amplitude']	            = 	null;
			$postnatal_admission['mean_airway_pressure']	= 	null;
			$postnatal_admission['rate']	                = 	null;
			$postnatal_admission['it']	                    = 	null;
			$postnatal_admission['fio2']	                = 	null;
			$postnatal_admission['flow']	                = 	null;
			$postnatal_admission['rr']	                    = 	null;
			$postnatal_admission['nicu_retractions']	    = 	null;
			$postnatal_admission['nicu_airentry']	        = 	null;
			$postnatal_admission['chest_movement']	        = 	null;
			$postnatal_admission['hr']	                    = 	null;
			$postnatal_admission['systolic_bp']	            = 	null;
			$postnatal_admission['diastolic_bp']	        = 	null;
			$postnatal_admission['mean_bp']              	= 	null;
			$postnatal_admission['nicu_central_pulses']	    = 	null;
			$postnatal_admission['nicu_peripheral_pulses']	= 	null;
			$postnatal_admission['nicu_femoral_pulses']  	= 	null;
			$postnatal_admission['s1s2']	                = 	null;
			$postnatal_admission['nicu_murmur']         	= 	null;
			$postnatal_admission['cft']	                    = 	null;
			$postnatal_admission['nicu_color']	            = 	null;
			$postnatal_admission['temperature']	            = 	null;
			$postnatal_admission['nicu_abdomen']	        = 	null;
			$postnatal_admission['nicu_bowel_sounds']	    = 	null;
			$postnatal_admission['nicu_umbilicus']	        = 	null;
			$postnatal_admission['nicu_hepatomegaly']	    = 	null;
			$postnatal_admission['nicu_splenomegaly']	    = 	null;
			$postnatal_admission['nicu_herina']          	= 	null;
			$postnatal_admission['genitalia_findings']	    = 	null;
			$postnatal_admission['nicu_pupils_findings']	= 	null;
			$postnatal_admission['nicu_anteriorfontanelle']	= 	null;
			$postnatal_admission['nicu_activity']	        = 	null;
			$postnatal_admission['tone']	                = 	null;
			$postnatal_admission['nicu_cry']	            = 	null;
			$postnatal_admission['nicu_seizures']	        = 	null;
			$postnatal_admission['nicu_neonatalreflexes']	= 	null;
			$postnatal_admission['skin']                 	= 	null;
			$postnatal_admission['abnormalities']	        = 	null;
			$postnatal_admission['initialbloodgas']	        = 	null;
			$postnatal_admission['agetaken']	            = 	null;
			$postnatal_admission['spo2']	                = 	null;
			$postnatal_admission['ph']	                    = 	null;
			$postnatal_admission['pao2']	                = 	null;
			$postnatal_admission['paco2']	                = 	null;
			$postnatal_admission['hco3']	                = 	null;
			$postnatal_admission['be']						= 	null;
			$postnatal_admission['rbs']						= 	null;
			$postnatal_admission['hct']						= 	null;
			$postnatal_admission['initialxray']          	= 	null;
			$postnatal_admission['xrayfindings']	        = 	null;
			$postnatal_admission['ageofcxr']	            = 	null;
			$postnatal_admission['uac_status']	            = 	null;
			$postnatal_admission['uac_position']	        = 	null;
			$postnatal_admission['uvc_status']	            = 	null;
			$postnatal_admission['uvc_position']	        = 	null;
			$postnatal_admission['sepsisscreen']	        = 	null;
			$postnatal_admission['indications']	            = 	null;
			$postnatal_admission['ivantibiotic']	        = 	null;
			$postnatal_admission['investigations']	        = 	null;
			$postnatal_admission['fluids']	                = 	null;
			$postnatal_admission['enteral_feeding']      	= 	null;
			$postnatal_admission['differentialdiagnosis']	= 	null;
			$postnatal_admission['additional_diagnosis']	= 	null;
			$postnatal_admission['plan']	                = 	null;
			$postnatal_admission['parents_spoken']	        = 	null;
			$postnatal_admission['pdiscussion_hrs']	        = 	null;
			$postnatal_admission['pdiscussion_min']	        = 	null;
			$postnatal_admission['pdiscussion_session']	    = 	null;
			$postnatal_admission['matters_discussed']	    = 	null;
			$postnatal_admission['DateAdded']	            = 	$neonatal_proforma['DateAdded'];
			$postnatal_admission['DateModified']	        = 	$neonatal_proforma['DateModified'];
			$postnatal_admission['UserDeleted']	            = 	$neonatal_proforma['UserDeleted'];
			$postnatal_admission['UserAdded']	            = 	$neonatal_proforma['UserAdded'];
			$postnatal_admission['IsDeleted']	            = 	($neonatal_proforma['IsDeleted']!='') ? $neonatal_proforma['IsDeleted'] : null;
			$postnatal_admission['parents_addressed_by']	= 	null;
			$postnatal_admission['admission_examination']	= 	null;
			$postnatal_admission['nicu_pupils']	            = 	null;
			$postnatal_admission['genitalia']	            = 	null;
			Postnatal::create($postnatal_admission);

			//discharge 
			$postnatal_discharge['BabyId']	                = 	$neonatal_proforma['BabyId'];
			$postnatal_discharge['MotherId']	            = 	$baby_details->MotherId;
			$postnatal_discharge['AdmissionId']          	= 	$neonatal_proforma['AdmissionId'];
			$postnatal_discharge['BMrNo']	                = 	$neonatal_proforma['BMrNo'];

			$postnatal_discharge['discharge_status']	    = 	$neonatal_proforma['Status'];
			$postnatal_discharge['discharge_date']	        = 	!empty($neonatal_proforma['DateOfDischarge']) ? $neonatal_proforma['DateOfDischarge'] : null;
			$postnatal_discharge['discharge_wt']	        = 	!empty($neonatal_proforma['DischargeWeight']) ? $neonatal_proforma['DischargeWeight'] : null;
			$postnatal_discharge['discharge_dol']	        = 	null;
			$postnatal_discharge['discharge_ofc']	        = 	$neonatal_proforma['discharge_ofc'];
			$postnatal_discharge['discharge_length']	    = 	$neonatal_proforma['discharge_length'];

			$postnatal_discharge['discharge_immunization']	= 	null;
			$postnatal_discharge['schedule']	            = 	null;
            $postnatal_discharge['vaccine']                 =   null;

			if (count(unserialize($neonatal_proforma['Vaccine']))  > 0) {
				$vaccine      = unserialize($neonatal_proforma['Vaccine']);
				$vaccine_date = unserialize($neonatal_proforma['VaccineDate']);

				$vaccine_set = array();

				for ($i=0; $i < count($vaccine); $i++) { 
					if (!empty($vaccine[$i])) {
						$vaccine_set[] = array( 'vaccine' => $vaccine[$i],
					                            'vaccinedate' =>$vaccine_date[$i]);
					}
					
				}
				if (count($vaccine_set) > 0) {
                    $postnatal_discharge['vaccine'] = json_encode($vaccine_set);
				}

			}

			$postnatal_discharge['cgd']                  	= 	null;

			if (!is_null($neonatal_proforma['DateOfDischarge']) && date('Y',strtotime($neonatal_proforma['DateOfDischarge'])) != 1970) {

				$dayoflife    = \SiteHelpers::calculate_day_of_life_two($baby_details->DOB, $neonatal_proforma['DateOfDischarge']);
			    $gestationday = \SiteHelpers::convert_gestation_days($baby_details->Gestation);
			    $gestation    = \SiteHelpers::calculate_corrected_gestation($gestationday, $dayoflife);
				$postnatal_discharge['cgd']	        = 	json_encode(['dcg_weeks'=>isset($gestation[0]) ? $gestation[0] : null, 
					                                                 'dcg_days' =>isset($gestation[1]) ? $gestation[1] : null ]);
			}
  			
			$postnatal_discharge['discharge_eyes']	            = 	null;
			$postnatal_discharge['discharge_femorals']	        = 	null;
			$postnatal_discharge['discharge_hips']          	= 	null;
			$postnatal_discharge['postductal_spo2']          	= 	$neonatal_proforma['PostductalSaturation'];
			$postnatal_discharge['discharge_gentila_findings']	= 	null;
			$postnatal_discharge['discharge_cardiac_murmur']	= 	null;
			$postnatal_discharge['discharge_malinformation']	= 	null;

			$postnatal_discharge['malinformation_details']	    = 	null;
			$postnatal_discharge['feeding_at_discharge']	    = 	null;
			$postnatal_discharge['neourological_status']	    = 	null;
			$postnatal_discharge['appoinment_status']	        = (date('Y',strtotime($neonatal_proforma['OpAppointment'])) != '1970') ? true : false;
			$postnatal_discharge['appoinment_date']	            = (date('Y',strtotime($neonatal_proforma['OpAppointment'])) != '1970' && !empty($neonatal_proforma['OpAppointment'])) ? $neonatal_proforma['OpAppointment'] : null;
			
			$postnatal_discharge['appoinment_hrs']	            = (date('Y',strtotime($neonatal_proforma['OpAppointment'])) != '1970' && !empty($neonatal_proforma['Outpatient_TIME'])) ? $neonatal_proforma['Outpatient_TIME'] : null;
			$postnatal_discharge['appoinment_min']	            = (date('Y',strtotime($neonatal_proforma['OpAppointment'])) != '1970') ? $neonatal_proforma['Outpatient_MINS'] : null;
			$postnatal_discharge['appoinment_session']	        = (date('Y',strtotime($neonatal_proforma['OpAppointment'])) != '1970') ? $neonatal_proforma['Outpatient_AM'] : null;
		
			$postnatal_discharge['discharge_hb']	            = 	null;
			$postnatal_discharge['discharge_pcv']	            = 	null;
			$postnatal_discharge['discharge_dct']	            = 	null;
			$postnatal_discharge['discharge_tsb']	            = 	null;
			$postnatal_discharge['direct_bilirubin']	        = 	null;
			$postnatal_discharge['dischargeserum_ca']	        = 	null;
			$postnatal_discharge['dischargeserum_po4']	        = 	null;
			$postnatal_discharge['dischargeserum_alp']	        = 	null;
			$postnatal_discharge['dischargeserum_na']	        = 	null;
			$postnatal_discharge['discharge_home_oxygen']	    = 	null;
			$postnatal_discharge['discharge_cuss']	            = 	null;

			$postnatal_discharge['discharge_new_born']	        = 	$neonatal_proforma['NewBornScreen'];
			$postnatal_discharge['discharge_hearing_screen']	= 	$neonatal_proforma['HearingScreen'];

			$postnatal_discharge['oae_left']	                = 	null;
			$postnatal_discharge['oae_right']	                = 	null;
			$postnatal_discharge['abr_left']	                = 	null;
			$postnatal_discharge['abr_right']                  	= 	null;
			$postnatal_discharge['rop_screening_status']	    = 	null;
			$postnatal_discharge['left_rop_left']	            = 	null;
			$postnatal_discharge['left_rop_right']	            = 	null;
			$postnatal_discharge['rop_treatment']	            = 	null;
			$postnatal_discharge['typeoftreatment_left']	    = 	null;
			$postnatal_discharge['typeoftreatment_right']	    = 	null;
			$postnatal_discharge['rop_follow_up']	            = 	null;
			$postnatal_discharge['cranial_ultrasound']	        = 	null;
			$postnatal_discharge['echocardiography']	        = 	null;

			$postnatal_discharge['advice']	                    = 	null;
			$postnatal_discharge['plan_follow_up']          	= 	null;
			$postnatal_discharge['additional_information']	    = 	$neonatal_proforma['AdditionalInformation'].$baby_details->ConfidentialBackgroundDetails;
			$postnatal_discharge['procedures']               	= 	null;
			$postnatal_discharge['echocardiography_status']	    = 	$neonatal_proforma['wb_echo_report'];
			$postnatal_discharge['discharge_gentila']        	= 	null;

			$postnatal_discharge['DateAdded']	                = 	$neonatal_proforma['DateAdded'];
			$postnatal_discharge['DateModified']	            = 	$neonatal_proforma['DateModified'];
			$postnatal_discharge['UserDeleted']	                = 	!empty($neonatal_proforma['UserDeleted']) ? $neonatal_proforma['UserDeleted'] : null;
			$postnatal_discharge['UserModified']	            = 	!empty($neonatal_proforma['UserAdded'])   ? $neonatal_proforma['UserAdded'] : null;
			$postnatal_discharge['UserAdded']	                = 	!empty($neonatal_proforma['UserAdded'])   ? $neonatal_proforma['UserAdded'] : null;
			$postnatal_discharge['IsDeleted']	                = 	($neonatal_proforma['IsDeleted'] != '')   ? $neonatal_proforma['IsDeleted'] : null;
			PostnatalDischarge::create($postnatal_discharge);
		

        }  
   }
}
