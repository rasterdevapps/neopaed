<?php

namespace App\Http\Controllers\Import;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OpImportController extends Controller
{
   private function opImportsnew() 
	{

		$op_list = Excel::load(public_path().'/im/newoutpatientclinics.xls', function ($reader) {
					         
					         $op_list = $reader->skipRows(1)->takeRows(1403)->get();
				   
		})->all();


		   $medicine = array();
		   $vaccine  = array();

		  foreach ($op_list as $medic) {

            $medicine[] = $medic->drug_name_1;
            $medicine[] = $medic->drug_name_2;
            $medicine[] = $medic->drug_name_3;
            $medicine[] = $medic->drug_name_4;
            $medicine[] = $medic->drug_name_5;
            $medicine[] = $medic->drug_name_6;
            $medicine[] = $medic->drug_name_7;
            $vaccine[]  = $medic->vaccine_1;
            $vaccine[]  = $medic->vaccine_2;
            $vaccine[]  = $medic->vaccine_3;
            $vaccine[]  = $medic->vaccine_4;

		  	
		  }

		  $vaccine = array_unique($vaccine);


		  $medicine = array_unique($medicine);

		  foreach ($medicine as $value) {
		  $drugs = DrugIvFluidMaster::where('brand_name', $value)->where('type', 'ORAL')->first();

		 	if (!empty($value) && count($drugs) < 1) {

		 	   $medi = array('brand_name'   => $value,
		 	   	             'status' => 'InActive');
		 	   
		 	   DrugIvFluidMaster::create($medi);

		 	}

		  } 

		  foreach ($vaccine as $value) {
		  $drugs = Vaccine::where('Name', $value)->first();

		 	if (!empty($value) && count($drugs) < 1) {

		 	   $medi = array('Name'   => $value,
		 	   	             'Status' => 'InActive');
		 	   Vaccine::create($medi);

		 	}

		  } 	
	

		 

		$op_list = $op_list->sortBy('date');


		   foreach ($op_list as $key => $op_value) {
                
                $baby=Baby::where('BMrNo', $op_value['mr_no.'])
                      ->join('mother', 'mother.MotherId', '=', 'baby.MotherId')
                      ->first();

                 $vaccinemas = array();

				  if (isset($op_value['vaccine_1']) && !empty($op_value['vaccine_1'])) {

				  	$vaccinemas[] = $op_value['vaccine_1'];

				  }   
				  if (isset($op_value['vaccine_2']) && !empty($op_value['vaccine_2'])) {

				  	$vaccinemas[] = $op_value['vaccine_2'];

				  }   
				  if (isset($op_value['vaccine_3']) && !empty($op_value['vaccine_3'])) {

				  	$vaccinemas[] = $op_value['vaccine_3'];

				  }   
				  if (isset($op_value['vaccine_4']) && !empty($op_value['vaccine_4'])) {

				  	$vaccinemas[] = $op_value['vaccine_4'];

				  }  

				   $vaccine = array();

                  if (count($vaccinemas) > 0) {

                   $vaccine = Vaccine::whereIn('Name', $vaccinemas)->pluck('Id')->toArray();

                  } 


               if (isset($baby->BabyId) && !empty($baby->BabyId)) {

               

               	   $vitie = Op::where('BabyId', $baby->BabyId)->get();

               	   $vitie = count($vitie)+1;


	                $data['BMrNo']	                      =	$op_value['mr_no.'];
					$data['AdmissionId']	              =	0;
					$data['BabyId']	                      =	isset($baby->BabyId) ? $baby->BabyId : 0;
					$data['Advice']	                      =	$op_value['advice'].'Next review'.$op_value['review'];
					$data['AllergyHistory'] 	          =	$op_value['allergy_history'];
					$data['mother_blood_group']	          =	$baby->MotherBloodGroup;
					$data['AppointmentType']	          =	$op_value['appointment_type'];
					$data['Complaints']     	          =	$op_value['complaints'];
					$data['CurrentLength']   	          =	(int)$op_value['current_length_cm'];
					$data['CurrentOFC']     	          =	(int)$op_value['current_ofc_cm'];
					$data['CurrentWt']      	          =	(int)$op_value['current_wt_gms'];
					$data['Development']	              =	$op_value['development'];
					$data['Diagnosis']       	          =	$op_value['diagnosis'];
					$data['Examination']	              =	$op_value['examination'];
					$data['FamilyHistory']	              =	$op_value['family_history'];
					$data['HPI']	                      =	$op_value['hpi'];
					$data['Immunization']	              =	$op_value['immunization'];
					$data['Outcome']	                  =	$op_value['outcome'];
					$data['Review']           	          =	null;
					$data['Schedule']         	          =	$op_value['schedule'];
					$data['TreatmentHistory']	          =	$op_value['treatment_history'];
					$data['OpDate']           	          =	date('Y-m-d', strtotime($op_value['date']));
					$data['OpTime']          	          =	(int)date('h', strtotime($op_value['time']));
					$data['Vaccine']          	          =	json_encode($vaccine);
					$data['SeenBy']           	          =	null;
					$data['UserAdded']	                  =	0;
					$data['DateAdded']	                  =	date('Y-m-d', strtotime($op_value['date']));
					$data['DateModified']	              =	date('Y-m-d', strtotime($op_value['date']));
					$data['UserModified']                 = 0;
					$data['UserDeleted']	              =	0;
					$data['IsDeleted']	                  =	0;
					$data['OpTime_AM']	                  =	date('A', strtotime($op_value['time']));
					$data['OpTime_MINS']	              =	date('i', strtotime($op_value['time']));
					$data['HeadCircumference']	          =	$op_value['current_ofc_cm'];
					$data['review_time']	              =	null;
					$data['review_session']	              =	null;
					$data['review_min']	                  =	null;
					$data['chronological_days']	          =	null;
					$data['chronological_month']	      =	null;
					$data['chronological_weeks']	      =	null;
					$data['chronological_year']	          =	null;
					$data['corrected_days']     	      =	null;
					$data['corrected_month']	          =	null;
					$data['corrected_weeks']    	      =	null;
					$data['corrected_year']     	      =	null;
					$data['op_visite']             	      =	'visit '.$vitie;
					$data['total_chronological_weeks']	  =	null;
					$data['total_chronological_days']	  =	null;
					$data['total_corrected_weeks']	      =	null;
					$data['total_corrected_days']	      = null;
					$data['baby_background']	          =	null;
					$data['neurosonogram']	              =	1  ;
					$data['neurosonogram_report']	      =	'' ;
					$data['echocardiogram']	              =	1  ;
					$data['echocardiogram_report']	      = '' ;


					$opid = Op::create($data)->OpId;
				    unset($data);	
                    $drugs = DrugIvFluidMaster::where('brand_name', $op_value['drug_name_1'])->where('type', 'ORAL')->first();

                    if (count($drugs) > 0) {

                        	$medication["AdmissionId"]	=	0;
							$medication["BabyId"]   	=	$baby->BabyId;
							$medication["Dose"]     	=	$op_value["dose_1"];
							$medication["Medication"]	=	$drugs->id;
							$medication["Frequency"]	=	$op_value["frequency_1"];
							$medication["Duration"] 	=	$op_value["duration_1"];
							$medication["genericname"]	=	'';
							$medication["formulation"]	=	'';
							$medication["flag"]     	=	3;
							$medication["source_id"]	=	$opid;
							Medications::create($medication);
                    }

                    $drugs = DrugIvFluidMaster::where('brand_name', $op_value['drug_name_2'])->where('type', 'ORAL')->first();

                    if (count($drugs) > 0) {

                        	$medication["AdmissionId"]	=	0;
							$medication["BabyId"]   	=	$baby->BabyId;
							$medication["Dose"]     	=	$op_value["dose_2"];
							$medication["Medication"]	=	$drugs->id;
							$medication["Frequency"]	=	$op_value["frequency_2"];
							$medication["Duration"] 	=	$op_value["duration_2"];
							$medication["genericname"]	=	'';
							$medication["formulation"]	=	'';
							$medication["flag"]     	=	3;
							$medication["source_id"]	=	$opid;
							Medications::create($medication);

                    }

                    $drugs = DrugIvFluidMaster::where('brand_name', $op_value['drug_name_3'])->where('type', 'ORAL')->first();

                    if (count($drugs) > 0) {

                        	$medication["AdmissionId"]	=	0;
							$medication["BabyId"]   	=	$baby->BabyId;
							$medication["Dose"]     	=	$op_value["dose_3"];
							$medication["Medication"]	=	$drugs->id;
							$medication["Frequency"]	=	$op_value["frequency_3"];
							$medication["Duration"] 	=	$op_value["duration_3"];
							$medication["genericname"]	=	'';
							$medication["formulation"]	=	'';
							$medication["flag"]     	=	3;
							$medication["source_id"]	=	$opid;
							Medications::create($medication);

                    }

                    $drugs = DrugIvFluidMaster::where('brand_name', $op_value['drug_name_4'])->where('type', 'ORAL')->first();

                    if (count($drugs) > 0) {

                        	$medication["AdmissionId"]	=	0;
							$medication["BabyId"]   	=	$baby->BabyId;
							$medication["Dose"]     	=	$op_value["dose_4"];
							$medication["Medication"]	=	$drugs->id;
							$medication["Frequency"]	=	$op_value["frequency_4"];
							$medication["Duration"] 	=	$op_value["duration_4"];
							$medication["genericname"]	=	'';
							$medication["formulation"]	=	'';
							$medication["flag"]     	=	3;
							$medication["source_id"]	=	$opid;
							Medications::create($medication);

                    }


                    $drugs = DrugIvFluidMaster::where('brand_name', $op_value['drug_name_5'])->where('type', 'ORAL')->first();

                    if (count($drugs) > 0) {

                        	$medication["AdmissionId"]	=	0;
							$medication["BabyId"]   	=	$baby->BabyId;
							$medication["Dose"]     	=	$op_value["dose_5"];
							$medication["Medication"]	=	$drugs->id;
							$medication["Frequency"]	=	$op_value["frequency_5"];
							$medication["Duration"] 	=	$op_value["duration_5"];
							$medication["genericname"]	=	'';
							$medication["formulation"]	=	'';
							$medication["flag"]     	=	3;
							$medication["source_id"]	=	$opid;
							Medications::create($medication);

                    }

                    $drugs = DrugIvFluidMaster::where('brand_name', $op_value['drug_name_6'])->where('type', 'ORAL')->first();

                    if (count($drugs) > 0) {

                        	$medication["AdmissionId"]	=	0;
							$medication["BabyId"]   	=	$baby->BabyId;
							$medication["Dose"]     	=	$op_value["dose_6"];
							$medication["Medication"]	=	$drugs->id;
							$medication["Frequency"]	=	$op_value["frequency_6"];
							$medication["Duration"] 	=	$op_value["duration_6"];
							$medication["genericname"]	=	'';
							$medication["formulation"]	=	'';
							$medication["flag"]     	=	3;
							$medication["source_id"]	=	$opid;
							Medications::create($medication);

                    }

                     $drugs = DrugIvFluidMaster::where('brand_name', $op_value['drug_name_7'])->where('type', 'ORAL')->first();

                    if (count($drugs) > 0) {

                        	$medication["AdmissionId"]	=	0;
							$medication["BabyId"]   	=	$baby->BabyId;
							$medication["Dose"]     	=	$op_value["dose_7"];
							$medication["Medication"]	=	$drugs->id;
							$medication["Frequency"]	=	$op_value["frequency_7"];
							$medication["Duration"] 	=	$op_value["duration_7"];
							$medication["genericname"]	=	'';
							$medication["formulation"]	=	'';
							$medication["flag"]     	=	3;
							$medication["source_id"]	=	$opid;
							Medications::create($medication);

                    }


				    // 

				}	

		   
		  }
	}

	
	private function opImports() 
	{

		$op_list = Excel::load(public_path().'/im/newpatientbasicdetails.xls', function ($reader) {
					         
					         $op_list = $reader->skipRows(1)->takeRows(908)->get();
				   
		})->all();


		  foreach ($op_list as $key => $opvalue) {

		  	  $baby=Baby::where('BMrNo', $opvalue['mr_no.'])
                      ->join('mother', 'mother.MotherId', '=', 'baby.MotherId')
                      ->first();

              if (count($baby) == 0) {

		  	    $data['MMrNo']                     = null;
				$data['MotherTitle']               = 'Mrs';
				$data['MotherInitial']             = null;
				$data['MotherName']                = trim($opvalue['name']);
				$data['MotherLastName']            = null;
				$data['MotherDOB']                 = null;
				$data['MothercYear']               = null;
				$data['education_status']          = null;
				$data['Occupation']                = null;			
				$data['occupation_status']         = null;
				$data['Mobile']                    = $opvalue['contact_no.'];
				$data['LandLine']                  = null;
				$data['MotherEmail']               = $opvalue['e_mail'];
				$data['MotherSpokenLanguages']     = null; 
				$data['Address1']                  = $opvalue['address'];
				$data['Address2']                  = null;
				$data['Address3']                  = $opvalue['city'];
				$data['Address4']                  = null;
				$data['Address5']                  = null;

			    //father
			    $data['PartnerTitle']              = 'Mr';
			    $data['PartnerInitial']            = null;
			    $data['PartnerName']			   = null;
			    $data['PartnerLastName']           = null;
			    $data['PartnerDOB']                = null;
			    $data['PartnercYear']              = null;
			    $data['partner_education_status']  = null;
			    $data['PartnerOccupation']         = null;
			    $data['partner_occupation_status'] = null;
			    $data['PartnerContact']            = null;
			    $data['PartnerMobile']             = null;			
			    $data['Email']                     = null;
			    $data['FatherSpokenLanguages']     = null;
			    $data['FatherAddress1']            = $opvalue['address'];
			    $data['FatherAddress2']            = null;
			    $data['City']                      = $opvalue['city'];
			    $data['Postcode']                  = null;
			    $data['Country']				   = null;
			    $data['State']					   = null;


			    $data['G_Value']                   = null;
			    $data['P_Value']                   = null;
			    $data['L_Value']                   = null;
			    $data['A_Value']                   = null;
			    $data['G_sequence']                = null;
			    $data['UserAdded']                 = 0;
			    $data['DateAdded']                 = $opvalue['date'];
			    $data['DateModified']              = $opvalue['date'];
			    $data['UserDeleted']               = 0;
			    $data['IsDeleted']                 = 0;
			    $data['MotherBloodGroup']          = $opvalue['mother_blood_group'];

			    $mother_id = Mother::create($data)->MotherId;

			    unset($data);
             
                $data['BabyName']	              = 	$opvalue['name'];
				$data['BirthOrder'] 	          = 	$opvalue['birth_order'];
				$data['BirthStatus']	          = 	$opvalue['birth_status'];
				$data['BirthWeight']	          = 	$opvalue['birth_weight_gms'];
				$data['Gestation']  	          = 	json_encode(array('g_weeks'=>'', 'g_days'=>''));
				$data['Sex']	                  = 	$opvalue['sex'];
				$data['ConfidentialBackgroundDetails']	= 	$opvalue['confidential_background_details'];
				$data['DOB']	                  = 	$opvalue['dob'];
				$data['TOB']	                  = 	$opvalue['tob'];
				$data['Background']	              = 	$opvalue['backround'];
				$data['BirthCity']	              = 	$opvalue['city'];
				$data['BabyBloodGroup']	          = 	$opvalue['baby_blood_group'];
				$data['BMrNo']	                  = 	$opvalue['mr_no.'];
				$data['MotherId']	              = 	$mother_id;
				$data['UserAdded']	              = 	0;
				$data['DateAdded']	              = 	$opvalue['date'];
				$data['DateModified']	          = 	$opvalue['date'];
				$data['UserDeleted']	          = 	0;
				$data['IsDeleted']	              = 	0;
				$data['TOB_TIME']	              = 	null;
				$data['TOB_MINS']	              = 	null;
				$data['TOB_AM']	                  = 	null;
				$data['MultiplePregnancy']	      = 	null;
				$data['MultiplePregnancyType']	  = 	null;
				$data['neonatal_consultant']	  = 	serialize(array());
				$data['paediatric_surgeon'] 	  = 	serialize(array());
				$data['Noofbabies']	              = 	null;
				$data['g_weeks']	              = 	null;
				$data['g_days']	                  = 	null;
				$data['Baby_group_id']	          = 	null;

				Baby::create($data);

			}	

		 
		  }
	}


	private function opold() 
	{

        $op_list = Excel::load(public_path().'/im/outpatientclinics.xls', function ($reader) {
					         
					         $op_list = $reader->takeRows(1000)->get();
				   
		})->all();
		
		   $medicine = array();
		   $vaccine  = array();

		  foreach ($op_list as $medic) {

            $medicine[] = $medic->drug_name_1;
            $medicine[] = $medic->drug_name_2;
            $medicine[] = $medic->drug_name_3;
            $medicine[] = $medic->drug_name_4;
            $medicine[] = $medic->drug_name_5;
            $medicine[] = $medic->drug_name_6;
            $medicine[] = $medic->drug_name_7;
            $vaccine[]  = $medic->vaccine_1;
            $vaccine[]  = $medic->vaccine_2;
            $vaccine[]  = $medic->vaccine_3;
            $vaccine[]  = $medic->vaccine_4;

		  	
		  }

		  $vaccine = array_unique($vaccine);


		  $medicine = array_unique($medicine);

		  foreach ($medicine as $value) {
		  $drugs = DrugIvFluidMaster::where('brand_name', $value)->where('type', 'ORAL')->first();

		 	if (!empty($value) && count($drugs) < 1) {

		 	   $medi = array('brand_name'   => $value,
		 	   	             'status' => 'InActive');
		 	   
		 	   DrugIvFluidMaster::create($medi);

		 	}

		  } 

		  foreach ($vaccine as $value) {
		  $drugs = Vaccine::where('Name', $value)->first();

		 	if (!empty($value) && count($drugs) < 1) {

		 	   $medi = array('Name'   => $value,
		 	   	             'Status' => 'InActive');
		 	   Vaccine::create($medi);

		 	}

		  } 	
	

		 

		$op_list = $op_list->sortBy('date');


		   foreach ($op_list as $key => $op_value) {

		   	    $baby=Baby::where('BMrNo', $op_value['mr_no.'])
                      ->join('mother', 'mother.MotherId', '=', 'baby.MotherId')
                      ->first();

              if (count($baby) == 0) {
		   	    $data['MMrNo']                     =  null;
				$data['MotherTitle']               = 'Mrs';
				$data['MotherInitial']             = null;
				$data['MotherName']                = trim($op_value['name']);
				$data['MotherLastName']            = null;
				$data['MotherDOB']                 = null;
				$data['MothercYear']               = null;
				$data['education_status']          = null;
				$data['Occupation']                = null;			
				$data['occupation_status']         = null;
				$data['Mobile']                    = $op_value['contact_no.'];
				$data['LandLine']                  = null;
				$data['MotherEmail']               = null;
				$data['MotherSpokenLanguages']     = null; 
				$data['Address1']                  = $op_value['address'];
				$data['Address2']                  = null;
				$data['Address3']                  = $op_value['city'];
				$data['Address4']                  = null;
				$data['Address5']                  = null;

			    //father
			    $data['PartnerTitle']              = 'Mr';
			    $data['PartnerInitial']            = null;
			    $data['PartnerName']			   = null;
			    $data['PartnerLastName']           = null;
			    $data['PartnerDOB']                = null;
			    $data['PartnercYear']              = null;
			    $data['partner_education_status']  = null;
			    $data['PartnerOccupation']         = null;
			    $data['partner_occupation_status'] = null;
			    $data['PartnerContact']            = null;
			    $data['PartnerMobile']             = null;			
			    $data['Email']                     = null;
			    $data['FatherSpokenLanguages']     = null;
			    $data['FatherAddress1']            = $op_value['address'];
			    $data['FatherAddress2']            = null;
			    $data['City']                      = $op_value['city'];
			    $data['Postcode']                  = null;
			    $data['Country']				   = null;
			    $data['State']					   = null;


			    $data['G_Value']                   = null;
			    $data['P_Value']                   = null;
			    $data['L_Value']                   = null;
			    $data['A_Value']                   = null;
			    $data['G_sequence']                = null;
			    $data['UserAdded']                 = 0;
			    $data['DateAdded']                 = $op_value['date'];
			    $data['DateModified']              = $op_value['date'];
			    $data['UserDeleted']               = 0;
			    $data['IsDeleted']                 = 0;
			    $data['MotherBloodGroup']          = $op_value['mother_blood_group'];

			    $mother_id = Mother::create($data)->MotherId;

			    unset($data);
             
                $data['BabyName']	              = 	$op_value['name'];
				$data['BirthOrder'] 	          = 	null;
				$data['BirthStatus']	          = 	$op_value['birth_status'];
				$data['BirthWeight']	          = 	$op_value['birth_weight_gms'];
				$data['Gestation']  	          = 	json_encode(array('g_weeks'=>'', 'g_days'=>''));
				$data['Sex']	                  = 	$op_value['sex'];
				$data['ConfidentialBackgroundDetails']	= 	null;
				$data['DOB']	                  = 	$op_value['dob'];
				$data['TOB']	                  = 	null;
				$data['Background']	              = 	$op_value['backround'];
				$data['BirthCity']	              = 	$op_value['city'];
				$data['BabyBloodGroup']	          = 	$op_value['baby_blood_group'];
				$data['BMrNo']	                  = 	$op_value['mr_no.'];
				$data['MotherId']	              = 	$mother_id;
				$data['UserAdded']	              = 	0;
				$data['DateAdded']	              = 	$op_value['date'];
				$data['DateModified']	          = 	$op_value['date'];
				$data['UserDeleted']	          = 	0;
				$data['IsDeleted']	              = 	0;
				$data['TOB_TIME']	              = 	null;
				$data['TOB_MINS']	              = 	null;
				$data['TOB_AM']	                  = 	null;
				$data['MultiplePregnancy']	      = 	null;
				$data['MultiplePregnancyType']	  = 	null;
				$data['neonatal_consultant']	  = 	serialize(array());
				$data['paediatric_surgeon'] 	  = 	serialize(array());
				$data['Noofbabies']	              = 	null;
				$data['g_weeks']	              = 	null;
				$data['g_days']	                  = 	null;
				$data['Baby_group_id']	          = 	null;

				Baby::create($data);


				unset($data);
		    }		

                
                $baby=Baby::where('BMrNo', $op_value['mr_no.'])
                      ->join('mother', 'mother.MotherId', '=', 'baby.MotherId')
                      ->first();

                 $vaccinemas = array();

				  if (isset($op_value['vaccine_1']) && !empty($op_value['vaccine_1'])) {

				  	$vaccinemas[] = $op_value['vaccine_1'];

				  }   
				  if (isset($op_value['vaccine_2']) && !empty($op_value['vaccine_2'])) {

				  	$vaccinemas[] = $op_value['vaccine_2'];

				  }   
				  if (isset($op_value['vaccine_3']) && !empty($op_value['vaccine_3'])) {

				  	$vaccinemas[] = $op_value['vaccine_3'];

				  }   
				  if (isset($op_value['vaccine_4']) && !empty($op_value['vaccine_4'])) {

				  	$vaccinemas[] = $op_value['vaccine_4'];

				  }  

				   $vaccine = array();

                  if (count($vaccinemas) > 0) {

                   $vaccine = Vaccine::whereIn('Name', $vaccinemas)->pluck('Id')->toArray();

                  } 


               if (isset($baby->BabyId) && !empty($baby->BabyId)) {

               

               	   $vitie = Op::where('BabyId', $baby->BabyId)->get();

               	   $vitie = count($vitie)+1;


	                $data['BMrNo']	                      =	$op_value['mr_no.'];
					$data['AdmissionId']	              =	0;
					$data['BabyId']	                      =	isset($baby->BabyId) ? $baby->BabyId : 0;
					$data['Advice']	                      =	$op_value['advice'].'Next review'.$op_value['review'];
					$data['AllergyHistory'] 	          =	$op_value['allergy_history'];
					$data['mother_blood_group']	          =	$baby->MotherBloodGroup;
					$data['AppointmentType']	          =	$op_value['appointment_type'];
					$data['Complaints']     	          =	$op_value['complaints'];
					$data['CurrentLength']   	          =	(int)$op_value['current_length_cm'];
					$data['CurrentOFC']     	          =	(int)$op_value['current_ofc_cm'];
					$data['CurrentWt']      	          =	(int)$op_value['current_wt_gms'];
					$data['Development']	              =	$op_value['development'];
					$data['Diagnosis']       	          =	$op_value['diagnosis'];
					$data['Examination']	              =	$op_value['examination'];
					$data['FamilyHistory']	              =	$op_value['family_history'];
					$data['HPI']	                      =	$op_value['hpi'];
					$data['Immunization']	              =	$op_value['immunization'];
					$data['Outcome']	                  =	$op_value['outcome'];
					$data['Review']           	          =	null;
					$data['Schedule']         	          =	$op_value['schedule'];
					$data['TreatmentHistory']	          =	$op_value['treatment_history'];
					$data['OpDate']           	          =	date('Y-m-d', strtotime($op_value['date']));
					$data['OpTime']          	          =	(int)date('h', strtotime($op_value['time']));
					$data['Vaccine']          	          =	json_encode($vaccine);
					$data['SeenBy']           	          =	null;
					$data['UserAdded']	                  =	0;
					$data['DateAdded']	                  =	date('Y-m-d', strtotime($op_value['date']));
					$data['DateModified']	              =	date('Y-m-d', strtotime($op_value['date']));
					$data['UserDeleted']	              =	0;
					$data['UserModified']                 = 0;
					$data['IsDeleted']	                  =	0;
					$data['OpTime_AM']	                  =	date('A', strtotime($op_value['time']));
					$data['OpTime_MINS']	              =	(int)date('i', strtotime($op_value['time']));
					$data['HeadCircumference']	          =	$op_value['current_ofc_cm'];
					$data['review_time']	              =	null;
					$data['review_session']	              =	null;
					$data['review_min']	                  =	null;
					$data['chronological_days']	          =	null;
					$data['chronological_month']	      =	null;
					$data['chronological_weeks']	      =	null;
					$data['chronological_year']	          =	null;
					$data['corrected_days']     	      =	null;
					$data['corrected_month']	          =	null;
					$data['corrected_weeks']    	      =	null;
					$data['corrected_year']     	      =	null;
					$data['op_visite']             	      =	'visit '.$vitie;
					$data['total_chronological_weeks']	  =	null;
					$data['total_chronological_days']	  =	null;
					$data['total_corrected_weeks']	      =	null;
					$data['total_corrected_days']	      = null;
					$data['baby_background']	          =	isset($baby->Background) ? $baby->Background : '' ;
					$data['neurosonogram']	              =	1  ;
					$data['neurosonogram_report']	      =	'' ;
					$data['echocardiogram']	              =	1  ;
					$data['echocardiogram_report']	      = '' ;


					$opid = Op::create($data)->OpId;
				    unset($data);	
                    $drugs = DrugIvFluidMaster::where('brand_name', $op_value['drug_name_1'])->where('type', 'ORAL')->first();

                    if (count($drugs) > 0) {

                        	$medication["AdmissionId"]	=	0;
							$medication["BabyId"]   	=	$baby->BabyId;
							$medication["Dose"]     	=	$op_value["dose_1"];
							$medication["Medication"]	=	$drugs->id;
							$medication["Frequency"]	=	$op_value["frequency_1"];
							$medication["Duration"] 	=	$op_value["duration_1"];
							$medication["genericname"]	=	'';
							$medication["formulation"]	=	'';
							$medication["flag"]     	=	3;
							$medication["source_id"]	=	$opid;
							Medications::create($medication);
                    }

                    $drugs = DrugIvFluidMaster::where('brand_name', $op_value['drug_name_2'])->where('type', 'ORAL')->first();

                    if (count($drugs) > 0) {

                        	$medication["AdmissionId"]	=	0;
							$medication["BabyId"]   	=	$baby->BabyId;
							$medication["Dose"]     	=	$op_value["dose_2"];
							$medication["Medication"]	=	$drugs->id;
							$medication["Frequency"]	=	$op_value["frequency_2"];
							$medication["Duration"] 	=	$op_value["duration_2"];
							$medication["genericname"]	=	'';
							$medication["formulation"]	=	'';
							$medication["flag"]     	=	3;
							$medication["source_id"]	=	$opid;
							Medications::create($medication);

                    }

                    $drugs = DrugIvFluidMaster::where('brand_name', $op_value['drug_name_3'])->where('type', 'ORAL')->first();

                    if (count($drugs) > 0) {

                        	$medication["AdmissionId"]	=	0;
							$medication["BabyId"]   	=	$baby->BabyId;
							$medication["Dose"]     	=	$op_value["dose_3"];
							$medication["Medication"]	=	$drugs->id;
							$medication["Frequency"]	=	$op_value["frequency_3"];
							$medication["Duration"] 	=	$op_value["duration_3"];
							$medication["genericname"]	=	'';
							$medication["formulation"]	=	'';
							$medication["flag"]     	=	3;
							$medication["source_id"]	=	$opid;
							Medications::create($medication);

                    }

                    $drugs = DrugIvFluidMaster::where('brand_name', $op_value['drug_name_4'])->where('type', 'ORAL')->first();

                    if (count($drugs) > 0) {

                        	$medication["AdmissionId"]	=	0;
							$medication["BabyId"]   	=	$baby->BabyId;
							$medication["Dose"]     	=	$op_value["dose_4"];
							$medication["Medication"]	=	$drugs->id;
							$medication["Frequency"]	=	$op_value["frequency_4"];
							$medication["Duration"] 	=	$op_value["duration_4"];
							$medication["genericname"]	=	'';
							$medication["formulation"]	=	'';
							$medication["flag"]     	=	3;
							$medication["source_id"]	=	$opid;
							Medications::create($medication);

                    }


                    $drugs = DrugIvFluidMaster::where('brand_name', $op_value['drug_name_5'])->where('type', 'ORAL')->first();

                    if (count($drugs) > 0) {

                        	$medication["AdmissionId"]	=	0;
							$medication["BabyId"]   	=	$baby->BabyId;
							$medication["Dose"]     	=	$op_value["dose_5"];
							$medication["Medication"]	=	$drugs->id;
							$medication["Frequency"]	=	$op_value["frequency_5"];
							$medication["Duration"] 	=	$op_value["duration_5"];
							$medication["genericname"]	=	'';
							$medication["formulation"]	=	'';
							$medication["flag"]     	=	3;
							$medication["source_id"]	=	$opid;
							Medications::create($medication);

                    }

                    $drugs = DrugIvFluidMaster::where('brand_name', $op_value['drug_name_6'])->where('type', 'ORAL')->first();

                    if (count($drugs) > 0) {

                        	$medication["AdmissionId"]	=	0;
							$medication["BabyId"]   	=	$baby->BabyId;
							$medication["Dose"]     	=	$op_value["dose_6"];
							$medication["Medication"]	=	$drugs->id;
							$medication["Frequency"]	=	$op_value["frequency_6"];
							$medication["Duration"] 	=	$op_value["duration_6"];
							$medication["genericname"]	=	'';
							$medication["formulation"]	=	'';
							$medication["flag"]     	=	3;
							$medication["source_id"]	=	$opid;
							Medications::create($medication);

                    }

                     $drugs = DrugIvFluidMaster::where('brand_name', $op_value['drug_name_7'])->where('type', 'ORAL')->first();

                    if (count($drugs) > 0) {

                        	$medication["AdmissionId"]	=	0;
							$medication["BabyId"]   	=	$baby->BabyId;
							$medication["Dose"]     	=	$op_value["dose_7"];
							$medication["Medication"]	=	$drugs->id;
							$medication["Frequency"]	=	$op_value["frequency_7"];
							$medication["Duration"] 	=	$op_value["duration_7"];
							$medication["genericname"]	=	'';
							$medication["formulation"]	=	'';
							$medication["flag"]     	=	3;
							$medication["source_id"]	=	$opid;
							Medications::create($medication);

                    }




				}	

		   
		  }


	}
}
