<?php

namespace App\Http\Controllers\Search;

interface SearchNicuadmissionSupport
{

  const  NICUADMISSIONFIELDS = [
						     'nicuadmission'=>[
					                             'BabyName'      		=>  'Baby Name',
					                             'BirthStatus'   		=>  'Birth Status',
					                             'BabyBloodGroup'		=>  'Baby BloodGroup',
					                             'Sex'           		=>  'Sex',
					                             'ReferredBy'    		=>  'Referred From',
					                             'ReferralReason'		=>  'Referral Reason',
					                             'TypeOfCare'    		=>  'Care',
					                             'baby_mr'       		=>  'Mr No',
					                             'BirthWeight'   		=>  'Birth Weight',
					                             'ip_number'     		=>  'ip number',
					                             'AdmissionWt'   		=>  'Admission Weight',
					                             'AgeOnAdmissioninDays' =>  'Age On Admission in days',
						                       ],
						        'nicuText'  => [
						        	             'BabyName'               	  => 'Baby Name',
						        	             'BirthStatus'            	  => 'Birth Status',
						        	             'BabyBloodGroup'         	  => 'Baby BloodGroup',
						        	             'Sex'                    	  => 'Sex',
						        	             'ReferredBy'             	  => 'Referred From',
						        	             'ReferralReason'         	  => 'Referral Reason',
						        	             'TypeOfCare'             	  => 'Care',
						        	             'DescriptionOfResuscitation' => 'Description Of Resuscitation',
						        	             'Dose'                       => 'Dose',


						                       ],  

						         'nicuNumbers' =>[
						         	             'baby_mr'              =>'Mr No',
						         	             'BirthWeight'          =>'Birth Weight',
						         	             'ip_number'            =>'Ip Number',
						         	             'AdmissionWt'          =>'Admission Weight',
						         	             'AgeOnAdmissioninDays' =>'Age On Admission in Days',
						         	             'g_weeks'              =>'gestation weeks',  
						         	             'g_days'               =>'gestation days',
						         	             'AgeAfterBirth'        =>'Age After Birth'

						                        ], 
						          'subFields' =>[
						          	              'Problems'            => 'Problems',
						          	              'Medications'         => 'Medications',
						          	              'Complication'        => 'Complication',
						          	               'Treatments'         => 'Treatments',
						          	               'findings'           => 'Finding',
						          	               'Gestation'          => 'Gestation',

						                          ],  

						        'nicuSelecttext' =>[
						          	                 'SurfactantGiven'            =>'Surfactant Given In Labour Room / Theatre',
						          	                 'SurfactantType'             =>'Surfactant Type',
						          	                 'TimeOfAdministration'       =>'TimeOfAdministration',
						          	                 'TimeOfAdministration_MINS'  =>'TimeOfAdministration_MINS',
						          	                 'TimeOfAdministration_AM'    =>'TimeOfAdministration_AM',
						                             ],  
						            'dateFields' =>[
						             	            'DateofAdministration'=>'Date of Administration'
						                           ],   

						           'onoffFields' =>[
						           	                'VentilationRequired'=>'Invasive Ventilation Required',
						                            ],             



        ];


}