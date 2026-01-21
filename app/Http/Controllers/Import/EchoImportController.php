<?php

namespace App\Http\Controllers\Import;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EchoImportController extends Controller
{
   private function echoImports()
	{

		 $echoreport  = Excel::load(public_path().'/im/echocardiography.xls', function ($reader) {
					         
					         $echoreport = $reader->skipRows(1)->takeRows(4000)->get();
				   
		   })->all();

              foreach ($echoreport as $key => $echoreport_done) {
                	$neonatal_consultant[] = trim($echoreport_done['echo_done_by']);
               }  

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
		            }     

             
                }



          foreach ($echoreport as $key => $op_value) {

			    	$baby=Baby::where('BMrNo', $op_value['mr_no.'])
	                      ->join('mother', 'mother.MotherId', '=', 'baby.MotherId')
	                      ->first();

                    $doctors = DoctorMaster::where('Name', 'like', '%'.$op_value['echo_done_by'].'%')->first();

	              if (count($baby) == 0) {
			   	    $data['MMrNo']                     = null;
					$data['MotherTitle']               = 'Mrs';
					$data['MotherInitial']             = null;
					$data['MotherName']                = empty(trim($op_value['name'])) ? 'N/A' : $op_value['name'];
					$data['MotherLastName']            = null;
					$data['MotherDOB']                 = null;
					$data['MothercYear']               = null;
					$data['education_status']          = null;
					$data['Occupation']                = null;			
					$data['occupation_status']         = null;
					$data['Mobile']                    = null;
					$data['LandLine']                  = null;
					$data['MotherEmail']               = null;
					$data['MotherSpokenLanguages']     = null; 
					$data['Address1']                  = null;
					$data['Address2']                  = null;
					$data['Address3']                  = null;
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
				    $data['FatherAddress1']            = null;
				    $data['FatherAddress2']            = null;
				    $data['City']                      = null;
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
				    $data['MotherBloodGroup']          = null;



				    $mother_id = Mother::create($data)->MotherId;

				    unset($data);
	             
	                $data['BabyName']	              = 	empty(trim($op_value['name'])) ? 'N/A' : $op_value['name'];
					$data['BirthOrder'] 	          = 	null;
					$data['BirthStatus']	          = 	$op_value['birth_status'];
					$data['BirthWeight']	          = 	$op_value['birth_wt'];
					$data['Gestation']  	          = 	json_encode(array('g_weeks'=>'', 'g_days'=>''));
					$data['Sex']	                  = 	$op_value['sex'];
					$data['ConfidentialBackgroundDetails']	= 	null;
					$data['DOB']	                  = 	$op_value['date_of_birth'];
					$data['TOB']	                  = 	null;
					$data['Background']	              = 	null;
					$data['BirthCity']	              = 	null;
					$data['BabyBloodGroup']	          = 	null;
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
					$data['neonatal_consultant']	  = 	isset($doctors->id) ? serialize(array($doctors->id)) : serialize(array()) ;
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

                        $data['AdmissionId']	= 	0;
						$data['BabyId']        	= 	$baby->BabyId;
						$data['Findings']	    = 	$op_value['echo_findings'];
						$data['Impression']	    = 	$op_value['impression'];
						$data['Outcome']	    = 	$op_value['outcome'];
						$data['TestDate']	    = 	$op_value['date'];
						$data['Age']	        = 	$op_value['age'];
						$data['SeenBy']	        = 	isset($doctors->id) ? $doctors->id : null;
						$data['UserAdded']	    = 	0;
						$data['UserModified']	=   0;
						$data['DateAdded']	    = 	$op_value['date'];
						$data['DateModified']	= 	$op_value['date'];
						$data['UserDeleted']	= 	0;
						$data['IsDeleted']	    = 	0;
				        Cardio::create($data);		
		    }
	}
}
