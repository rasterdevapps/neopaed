<?php

namespace App\Http\Controllers\Import;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NeonatalImportController extends Controller
{
   private function neonatalImports() 
	{


		$nicuadmission = Excel::load(public_path().'/im/neonatalproforma.xls', function ($reader) {
			         
			         $nicuadmission = $reader->skipRows(1)->takeRows(4000)->get();
		   
		})->all();




		foreach ($nicuadmission as $key => $nicumvalue) {

		 		    $complications[] = $nicumvalue['complication_1'];
		 		    $complications[] = $nicumvalue['complication_2'];
		 		    $complications[] = $nicumvalue['complication_3'];

		        	$problem_temp[]      = $nicumvalue['med_prob._1'];
		        	$problem_temp[]      = $nicumvalue['med_prob._2'];

		        	$neonatal_consultant[] = trim($nicumvalue['attending_consultant']);

		        	//unsupported string of discharge medications so skipped 

		        	// $temp_medication[] = $nicumvalue['discharge_medications_1'];
		        	// $temp_medication[] = $nicumvalue['discharge_medications_2'];
		        	// $temp_medication[] = $nicumvalue['discharge_medications_3'];

		}
		  //creating master complications 
         if (isset($complications)) {
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

          //creating master problems 
          if (isset($problem_temp)) {
            $problem_temp = array_unique($problem_temp);

              foreach ($problem_temp as $mediproblemValues) {

          	     $comcheck = MediprobsMaster::where('Name', $mediproblemValues)->get();

          	    if (!empty($mediproblemValues) && count($comcheck) == 0) {

			         $master_prob = array('Name'   =>$mediproblemValues,
						            'Status' =>'InActive');

		              MediprobsMaster::create($master_prob);

          	    }

             }
           } 
           
           if (isset($neonatal_consultant)) { 

             $neonatal_consultant = array_unique($neonatal_consultant);


             foreach ($neonatal_consultant as $neonatal_consultant_name) {

             	$previous_doctor = DoctorMaster::where('Name', $neonatal_consultant_name)->first();

                   if (count($previous_doctor) == 0) {
	             	$post['Name']          = $neonatal_consultant_name;
	                $post['type']          = 1;
	                $post['status']        = 0;  
	                $post['Qualification'] = '';
	                $post['UserAdded']     = 0;
	                $post['UserModified']  = 0;                    
	                $post['DateModified']  = Carbon::now();
	                $post['DateAdded']     = Carbon::now();
	                DoctorMaster::create($post);
                   unset($post);
                  } 

             }
           }  

           //unsupported string of discharge medications so skipped 


    //         //creating master medication 
    //           $temp_medication = array_unique($temp_medication);

				// foreach ($temp_medication as  $value) {

				//   $drugs = Drug::where('Name',$value)->first();

				//  	if(!empty($value) && count($drugs) == 0) {

				//  	   $medi = array('Name'   => $value,
				//  	   	             'Status' => 'Active');
				 	   
				//  	   Drug::create($medi);

				//  	}

		  //      } 





         //baby & mother &  neonatal 

             $i = 1;

        foreach ($nicuadmission as $key => $value) {


            $doctors = DoctorMaster::where('Name', 'like', '%'.$value['attending_consultant'].'%')->first();
            $value['name_m'] = str_replace('Mrs.', '', trim($value['name_m']));
            $value['name_m'] = str_replace('mrs.', '', trim($value['name_m']));
            $value['name_m'] = str_replace('MRS.', '', trim($value['name_m']));


              $indication     = explode(',', $value['indication']);
              $tempindication = array();

              foreach ($indication as $indicationValue) {

              	   
              	    $indica  = Indication::whereRaw('LOWER("indication_name") like '."'%".strtolower($indicationValue)."%'")->pluck('Id')->toArray();
                    
                    if (count($indica) > 0  && isset($indica[0]) && !empty($indica[0])) {
                          $tempindication[] = $indica[0];
                    
                    } else {

                    	$newindication  = array("indication_name"    => $indicationValue,
                    		                    "indication_status"  => 1,
                    		                    "DateAdded" => date('Y-m-d'),
                    		                    "DateModified" => date('Y-m-d'));

                    	$temp_id           = Indication::create($newindication)->Id;
                        $tempindication[]  = $temp_id; 

                    } 


              }
              $mother_check = Mother::where('MMrNo', $value['mr_no._m'])->first();

           if (count($mother_check) == 0) {    
           //mother
			$data['MMrNo']                     = trim($value['mr_no._m']);
			$data['MotherTitle']               = 'Mrs';
			$data['MotherInitial']             = null;
			$data['MotherName']                = trim($value['name_m']);
			$data['MotherLastName']            = null;
			$data['MotherDOB']                 = $value['dob_m'];
			$data['MothercYear']               = $value['age_m_in_yrs'];
			$data['education_status']          = null;
			$data['Occupation']                = $value['occupation_m'];			
			$data['occupation_status']         = null;
			$data['Mobile']                    = $value['contact_no_m'];
			$data['LandLine']                  = $value['landline_no'];
			$data['MotherEmail']               = $value['e_mail'];
			$data['MotherSpokenLanguages']     = null; 
			$data['Address1']                  = $value['address'];
			$data['Address2']                  = null;
			$data['Address3']                  = $value['city'];
			$data['Address4']                  = null;
			$data['Address5']                  = null;

			//father
			$data['PartnerTitle']              = 'Mr';
			$data['PartnerInitial']            = null;
			$data['PartnerName']			   = $value['name_f'];
			$data['PartnerLastName']           = null;
			$data['PartnerDOB']                = null;
			$data['PartnercYear']              = $value['age_f_in_yrs'];
			$data['partner_education_status']  = null;
			$data['PartnerOccupation']         = $value['occupation_f'];
			$data['partner_occupation_status'] = null;
			$data['PartnerContact']            = $value['landline_no'];
			$data['PartnerMobile']             = $value['contact_no_f'];			
			$data['Email']                     = $value['e_mail'];
			$data['FatherSpokenLanguages']     = null;
			$data['FatherAddress1']            = $value['address'];
			$data['FatherAddress2']            = null;
			$data['City']                      = $value['city'];
			$data['Postcode']                  = null;
			$data['Country']				   = null;
			$data['State']					   = null;


			$data['G_Value']                   = $value['g'];
			$data['P_Value']                   = $value['p'];
			$data['L_Value']                   = $value['l'];
			$data['A_Value']                   = $value['a'];
			$data['G_sequence']                = null;
			$data['UserAdded']                 = 0;
			$data['DateAdded']                 = $value['date'];
			$data['DateModified']              = $value['date'];
			$data['UserDeleted']               = 0;
			$data['IsDeleted']                 = 0;
			$data['MotherBloodGroup']          = $value['mothers_blood_group'];

		}


		    $mother_check = Mother::where('MMrNo', $value['mr_no._m'])->first();

			if (count($mother_check) > 0) {

                $mother_id = $mother_check->MotherId; 
		        $baby =  Baby::where('MotherId', $mother_check->MotherId)->first();
		        $Baby_group_id = isset($baby->BabyId) ? $baby->BabyId : null;


				
			} else {

				$mother_id = Mother::create($data)->MotherId;
		        $Baby_group_id = null;

			}

		      	$baby = Baby::where(['BMrNo'=>$value['mr_no.'], 'IsDeleted'=>0])->first();

          if (count($baby)==0) {    

			$data['BMrNo']                         = $value['mr_no.'];
     		$data['BabyName']                      = $value['name'];
			$data['BirthOrder']                    = $value['birth_order'];
			$data['BirthStatus']                   = $value['birth_status'];
			$data['BirthWeight']                   = $value['birth_weight'];
			$data['Gestation']                     = json_encode(['g_weeks'=>$value['gestation'], 'g_days'=>0]);

			$data['Sex']                           = $value['sex'];
			$data['ConfidentialBackgroundDetails'] = $value['confidential_background_details'];
			$data['DOB']                           = $value['dob'];
			
			$data['TOB']                           = null;
			$data['TOB_TIME']                      = (int)date('h', strtotime($value['time_of_birth']));
			$data['TOB_MINS']                      = (int)date('i', strtotime($value['time_of_birth']));
			$data['TOB_AM']                        = date('A', strtotime($value['time_of_birth']));;

			$data['Background']                    = $value['background'];
			$data['BirthCity']                     = $value['city'];
			$data['BabyBloodGroup']                = $value['babys_blood_group'];
			$data['MultiplePregnancy']     		   = $value['multiple_pregnancy'];

			$data['MultiplePregnancyType'] 	       = (strpos('Twin', $value['birth_order'])) ? 'Twins': $value['birth_order'];
			$data['neonatal_consultant']   	       = isset($doctors->id) ? serialize(array($doctors->id)) : serialize(array());
		    $data['paediatric_surgeon']    	       = isset($doctors->id) ? serialize(array($doctors->id)) : serialize(array());
			$data['Noofbabies']                    = 0;

			$data['g_weeks']                       = $value['gestation'];
			$data['g_days']                        = 0;

			$data['Baby_group_id']                 = $Baby_group_id;
			$data['MotherId']                      = $mother_id;
			$data['UserAdded']                     = 0;
			$data['DateAdded']                     = $value['date'];
			$data['DateModified']                  = $value['date'];
			$data['UserDeleted']                   = 0;
			$data['IsDeleted']                     = 0;

			$BabyId = Baby::create($data)->BabyId;


			unset($data);

			//neonatal

         
                $data['BMrNo']        	                  = 	$value['mr_no.'];
				$data['AdmissionId']             	      = 	0;
				$data['BabyId'] 	                      = 	$BabyId;

				$data['Booked'] 	                      = 	'';
				$data['PlaceBooked'] 	                  = 	'';

				$data['AdditionalInformation'] 	          = 	$value['additional_information'].$value['outpatient_appointment'].$nicumvalue['discharge_medications_1'].$nicumvalue['discharge_medications_2'].$nicumvalue['discharge_medications_3'];
				$data['AdjustedRiskForTrisomy13'] 	      = 	$value['adjusted_risk_for_trisomy_13'];
				$data['AdjustedRiskForTrisomy18'] 	      = 	$value['adjusted_risk_for_trisomy_18'];
				$data['AdjustedRiskForTrisomy21'] 	      = 	$value['adjusted_risk_for_trisomy_21'];
				$data['AntenatalSteroids'] 	              = 	$value['antenatal_steroids'];

				$data['CommentOnLiquor'] 	              = 	$value['comment_on_liquor'];
				$data['SteroidCourse'] 	                  = 	'';
               
				$data['BCG'] 	                          = 	$value['bcg'];
				$data['SeenBy'] 	                      = 	isset($doctors->id) ? $doctors->id: null;

				$data['CordBE'] 	                      = 	$value['cord_be'];
				$data['CordBloodGas'] 	                  = 	$value['cord_blood_gas'];
				$data['CordHCO3'] 	                      = 	$value['cord_hco3'];
				$data['CordpH']                   	      = 	$value['cord_ph'];
				$data['CPR'] 	                          = 	$value['cpr'];
				$data['CTG'] 	                          = 	$value['ctg'];
				$data['CTGDetails'] 	                  = 	$value['ctg_details'];
				$data['DCT']                       	      = 	$value['dct'];
				$data['DepthOfInsertion'] 	              = 	$value['depth_of_insertion_in_cm'];
				$data['DischargeMedications'] 	          = 	null;
				$data['DischargeWeight'] 	              = 	$value['discharge_weight'];
				$data['DoseVitK'] 	                      = 	$value['dose_vitk'];
				$data['Drugs'] 	                          = 	$value['drugs'];

				$data['OtherInformation'] 	              = 	'';

				$data['DurationOfOxygen'] 	              = 	$value['duration_of_oxygen'];
				$data['DurationOfPPV']     	              = 	$value['duration_of_ppv'];
				$data['PPV'] 	                          = 	$value['ppv'];
			//	$data['DurationOfROM']      	          = 	$value['DurationOfROM'];
				$data['EDDbyDates']              	      = 	$value['edd_by_dates'];
				$data['EDDbyUSG']     	                  = 	$value['edd_by_usg'];
				$data['EmbryoTransfer'] 	              = 	$value['embryo_transfer'];
				$data['ETTSize'] 	                      = 	$value['ett_size_in_mm'];
				$data['FacialOxygen'] 	                  = 	$value['facial_oxygen'];

				$data['FoetalDistress'] 	              = 	$value['foetal_distress'];
				$data['GastricAspirate'] 	              = 	$value['gastric_aspirate'];
				$data['HepatitisB']      	              = 	$value['hepatitis_b'];
				$data['HepatitisBVaccine'] 	              = 	$value['hepatitis_b_vaccine'];
				$data['HIV'] 	                          = 	$value['hiv'];
				$data['HR1'] 	                          = 	$value['hr1'];
				$data['HR10'] 	                          = 	$value['hr10'];
				$data['HR20'] 	                          = 	$value['hr20'];
				$data['HR5'] 	                          = 	$value['hr5'];
				$data['Indication'] 	                  = 	json_encode($tempindication);
				$data['Presentation'] 	                  = 	$value['presentation'];
				$data['InitialExamination'] 	          = 	$value['initial_examination'];
				$data['Intubation']       	              = 	$value['intubation'];
				$data['Labour']           	              = 	$value['labour'];
				$data['LastDoseDeliveryInterval'] 	      = 	$value['last_dose_delivery_interval'];
				$data['Length'] 	                      = 	$value['length_in_cm'];
				$data['LMP'] 	                          = 	$value['lmp'];
				$data['Malformation'] 	                  = 	$value['malformation'];
				$data['MalformationType']     	          = 	$value['malformation_type'];

                 if (!empty($value['maternal_antibiotics1']) || !empty($value['maternal_antibiotics2']) || !empty($value['maternal_antibiotics3'])) {

                 	$data['MaternalAntibiotics'] =serialize(array($value['maternal_antibiotics1'], $value['maternal_antibiotics2'], $value['maternal_antibiotics3']));
                 } else {

                 	 $data['MaternalAntibiotics'] ='';
                 }

                 $ModeOfDelivery ='';

                 if ($value['mode_of_delivery'] == 'Emergency LSCS') {
                      
                      $ModeOfDelivery  = 'Emergency Caesarian';

                 } elseif ($value['mode_of_delivery'] == 'PTVD') {

                 	   $ModeOfDelivery  = 'Preterm Vaginal';

                 } elseif ($value['mode_of_delivery'] == 'NVD') {

                 	   $ModeOfDelivery = 'Normal Vaginal';

                 } elseif ($value['mode_of_delivery'] == 'Elective LSCS') {

                 	   $ModeOfDelivery = 'Elective Caesarian';

                 } else {

                 	   $ModeOfDelivery = $value['mode_of_delivery'];
                 }



				$data['MaternalPyrexia'] 	              = 	$value['maternal_pyrexia'];
				$data['ModeOfDelivery']      	          = 	$ModeOfDelivery;
				$data['PregnancyComplications'] 	      = 	$value['pregnancy_complication'];
				$data['MultiplePregnancy'] 	              = 	$value['multiple_pregnancy'];
				$data['NatureofLabour']          	      = 	$value['nature_of_labour'];
				$data['NewBornExamination']      	      = 	$value['newborn_examination'];
				$data['NewBornScreen']            	      = 	$value['newborn_screen'];
				$data['Notes']                    	      = 	$value['notes'];
				$data['OFC']                      	      = 	$value['ofc_in_cm'];
				$data['OralPolio']                	      = 	$value['oral_polio'];
				$data['OtherInvestigations'] 	          = 	$value['other_investigations'];
				$data['OpAppointment'] 	                  = 	'N/A';

				$data['PlaceofART'] 	                  = 	$value['place_of_art'];
				$data['PlaceofSupervision'] 	          = 	$value['place_of_supervision'];
				$data['PLAN'] 	                          = 	$value['plan'];
				$data['PROM'] 	                          = 	$value['prom'];
				$data['Reflex1'] 	                      = 	$value['reflex1'];
				$data['Reflex10'] 	                      = 	$value['reflex10'];
				$data['Reflex20'] 	                      = 	$value['reflex20'];
				$data['Reflex5'] 	                      = 	$value['reflex5'];
				$data['RegularRespiration']      	      = 	$value['regular_respiration_in_sec'];
				$data['Respiration1'] 	                  = 	$value['respiration1'];
				$data['Respiration10'] 	                  = 	$value['respiration10'];
				$data['Respiration20'] 	                  = 	$value['respiration20'];
				$data['Respiration5'] 	                  = 	$value['respiration5'];
				$data['Resuscitation'] 	                  = 	$value['resuscitation'];
				$data['RouteVitK']                 	      = 	$value['route_vitk'];
				$data['Status']                   	      = 	$value['status'];
				$data['Supervised']              	      = 	$value['supervised'];
				$data['TimeOf1stGasp'] 	                  = 	$value['time_of_1st_gasp_in_sec'];

				$data['TimeofLastDose'] 	              = 	$value['time_of_last_dose'];
				$data['Tone1'] 	                          = 	$value['tone1'];
				$data['Tone10'] 	                      = 	$value['tone10'];
				$data['Tone20'] 	                      = 	$value['tone20'];
				$data['Tone5'] 	                          = 	$value['tone5'];
				$data['TypeofAnesthesia'] 	              = 	$value['type_of_anesthesia'];
				$data['TypeofART'] 	                      = 	$value['type_of_art'];
				$data['VDRL']                       	  = 	$value['vdrl'];
				$data['VitaminK']                  	      = 	$value['vitamin_k'];
				$data['known_field'] 	                  = 	1;
				$data['Apgars1min']               	      = 	$value['apgars_1_min'];
				$data['Apgars10min']               	      = 	$value['apgars_10_min'];
				$data['Apgars20min']               	      = 	$value['apgars_20_min'];
				$data['Apgars5min']                	      = 	$value['apgars_5_min'];
				$data['Colour1'] 	                      = 	$value['colour1'];
				$data['Colour10'] 	                      = 	$value['colour10'];
				$data['Colour20'] 	                      = 	$value['colour20'];
				$data['Colour5'] 	                      = 	$value['colour5'];
				$data['Conception'] 	                  = 	$value['conception'];
				$data['TestDate'] 	                      = 	$value['date'];
				$data['TestTime'] 	                      = 	$value['time'];
				$data['DateOfDischarge'] 	              = 	$value['date_of_discharge'];
				$data['UserAdded'] 	                      = 	0;
				$data['DateAdded'] 	                      = 	$value['date'];
				$data['DateModified'] 	                  = 	$value['date'];
				$data['IsDeleted'] 	                      = 	0;
				$data['UserDeleted'] 	                  = 	0;
				$data['TEST_TIME'] 	                      = (int)date('h', strtotime($value['time']));
				$data['TEST_MINS'] 	                      = (int)date('i', strtotime($value['time']));
				$data['TEST_AM'] 	                      = 	date('A', strtotime($value['time']));
				$data['Booking'] 	                      = 	'';
				$data['Vaccine'] 	                      = 	serialize(array());
				$data['VaccineDate'] 	                  = 	serialize(array());
				$data['VaccineDate'] 	                  = 	serialize(array());
				$data['discharge_ofc']                    =  	$value['ofc_in_cm'];
                $data['discharge_length']                 =     $value['length_in_cm'];

				Neonatal::create($data);

				// $data['HearingScreen'] 	                  = 	$value['HearingScreen'];
				// $data['PostductalSaturation']    	      = 	$value['PostductalSaturation'];
				// $data['AdditionalDetails'] 	              = 	$value['AdditionalDetails'];
				$data['Outpatient_TIME'] 	              = 	'N/A';
				$data['Outpatient_MINS'] 	              = 	'N/A';
				$data['Outpatient_AM'] 	                  = 	'N/A';

				//$data['transfer_status'] 	              = 	$value['transfer_status'];
				$data['Maternal_antibiotics_status']      = 	($value['prom'] == 'No') ? 'No': 'Not known';
				//$data['delayed_cord_clamping'] 	      = 	$value['delayed_cord_clamping'];
				//$data['duration_dcc'] 	              = 	$value['duration_dcc'];
				//$data['Vaccine_status'] 	              = 	$value['Vaccine_status'];

				$data['mp_common_status'] 	              = 	null;
				$data['Syntocinon'] 					  = 	3;
				$data['Colour15'] 					      = 	null;
				$data['HR15'] 					          = 	null;
				$data['Reflex15'] 	                      = 	null;
				$data['Tone15'] 	                      = 	null;
				$data['Respiration15'] 	                  = 	null;
				$data['Apgars15min'] 	                  = 	null;
				$data['newbornStatus'] 	                  = 	1;
				$data['adjustedtrisomies'] 	              = 	1;
			    $data['SteroidCourse'] 	                  = 	null;
				$data['Consanguinity'] 	                  = 	'No'; 

			$complications = array();
		if ($value['complication_1']!='') {
	
			$com = Complications::where('Name', $value['complication_1'])->first();

				$complications[] = array(
			
					'Complication'      => isset($com->Id) ? $com->Id : 0 ,
					'Treatment'         => !empty($value['treatment1']) ? $value['treatment1'] : '',
					'duration_in_weeks'	=> null,
					'AdmissionId'	    => 1,
					'BabyId'	        => $BabyId,
					'flags'             => 1,			
				);
			}
		if ($value['complication_2']!='') {
	
			$com = Complications::where('Name', $value['complication_2'])->first();

				$complications[] = array(
					'Complication'      => isset($com->Id) ? $com->Id : 0 ,
					'Treatment'         =>  !empty($value['treatment2']) ? $value['treatment2'] : '',
					'duration_in_weeks'	=> null,
					'AdmissionId'	    => 1,
					'BabyId'	        => $BabyId,
					'flags'             => 1,			
				);
			}
			if ($value['complication_3']!='') {
				$com = Complications::where('Name', $value['complication_3'])->first();
					$complications[] = array(

						'Complication'      => isset($com->Id) ? $com->Id : 0 ,
						'Treatment'         => !empty($value['treatment3']) ? $value['treatment3'] : '',
						'duration_in_weeks'	=> null,
						'AdmissionId'	    => 1,
						'BabyId'	        => $BabyId,
						'flags'             => 1,			
					);
			}

			if ($complications) {
				$complication_delete = Complication::Where(['BabyId'=>$data['BabyId']]);
				$complication_delete->delete();
				foreach ($complications as $com_data)
					Complication::create($com_data);
			}

		
			Problems::where('BabyId', '=', $data['BabyId'])->delete();

			if (!empty($value['med_prob._1'])) {
                $medprom = MediprobsMaster::where('Name', $value['med_prob._1'])->first();
              if (count($medprom) > 0) {  
				$pbms = array(
					'Problem'    => $medprom->Id,
					'Medication' => $value['medication1'],
					'MotherId'	 => $mother_id,
					'BabyId' 	 => $data['BabyId']
				);
				Problems::create($pbms);
			   }	
					
			}

			if (!empty($value['med_prob._2'])) {
                $medprom = MediprobsMaster::where('Name', $value['med_prob._1'])->first();
              if (count($medprom) > 0) {  
				$pbms = array(
					'Problem' => $medprom->Id,
					'Medication'=> $value['medication2'],
					'MotherId'	=> $mother_id,
					'BabyId'	=> $data['BabyId']
				);
				Problems::create($pbms);
		       }			
			}

			if (!empty($value['usg_1_gestation'])) {


					$usg = array(
						'Gestation' => substr(trim($value['usg_1_gestation']), 0, 2),
						'Finding'	=> $value['usg_1_findings'],
						'MotherId'	=> $mother_id,
						'BabyId'	=> $data['BabyId'],
						'flags'     => 1,
						'type'      => 3,
					);
					Usg::create($usg);

			}	

			if (!empty($value['usg_2_gestation'])) {

					$usg = array(
						'Gestation' => substr(trim($value['usg_2_gestation']), 0, 2),
						'Finding'	=> $value['usg_2_findings'],
						'MotherId'	=> $mother_id,
						'BabyId'	=> $data['BabyId'],
						'flags'     => 1,
						'type'      => 3,
					);
					Usg::create($usg);

			}	

			if (!empty($value['usg_3_gestation'])) {

					$usg = array(
						'Gestation' => substr(trim($value['usg_3_gestation']), 0, 2),
						'Finding'	=> $value['usg_3_findings'],
						'MotherId'	=> $mother_id,
						'BabyId'	=> $data['BabyId'],
						'flags'     => 1,
						'type'      => 3,
					);
					Usg::create($usg);

			}	

			Delivery::where('MotherId', $mother_id)->delete();

			if (!empty($value['complications1'])) {  	
				$deli_data = array(
						'Year' => $value['year1'],
						'Place'	=> $value['place1'],
						'Delivery'	=> $value['delivery1'],
						'Complications'	=> $value['complications1'],
						'Gender'	=> $value['gender1'],
						'GA'	=> $value['ga1'],
						'BW'	=> $value['bw1'],
						'Health'	=> $value['health1'],
						'MotherId'	=> $mother_id,
					);
			     Delivery::create($deli_data);
            }	



            if (!empty($value['complications2'])) {  	
				$deli_data = array(
						'Year' => $value['year2'],
						'Place'	=> $value['place2'],
						'Delivery'	=> $value['delivery2'],
						'Complications'	=> $value['complications2'],
						'Gender'	=> $value['gender2'],
						'GA'	=> $value['ga2'],
						'BW'	=> $value['bw2'],
						'Health'	=> $value['health2'],
						'MotherId'	=> $mother_id,
					);
			     Delivery::create($deli_data);
            }

            if (!empty($value['complications3'])) {  	
				$deli_data = array(
						'Year' => $value['year3'],
						'Place'	=> $value['place3'],
						'Delivery'	=> $value['delivery3'],
						'Complications'	=> $value['complications3'],
						'Gender'	=> $value['gender3'],
						'GA'	=> $value['ga3'],
						'BW'	=> $value['bw3'],
						'Health'	=> $value['health3'],
						'MotherId'	=> $mother_id,
					);
			     Delivery::create($deli_data);
            }

            if (!empty($value['complications4'])) {  	
				$deli_data = array(
						'Year' => $value['year4'],
						'Place'	=> $value['place4'],
						'Delivery'	=> $value['delivery4'],
						'Complications'	=> $value['complications4'],
						'Gender'	=> $value['gender4'],
						'GA'	=> $value['ga4'],
						'BW'	=> $value['bw4'],
						'Health'	=> $value['health4'],
						'MotherId'	=> $mother_id,
					);
			     Delivery::create($deli_data);
            }

            if (!empty($value['complications5'])) {  	
				$deli_data = array(
						'Year' => $value['year5'],
						'Place'	=> $value['place5'],
						'Delivery'	=> $value['delivery5'],
						'Complications'	=> $value['complications5'],
						'Gender'	=> $value['gender5'],
						'GA'	=> $value['ga5'],
						'BW'	=> $value['bw5'],
						'Health'	=> $value['health5'],
						'MotherId'	=> $mother_id,
					);
			     Delivery::create($deli_data);
            }
 			}	

         }
	}
}
