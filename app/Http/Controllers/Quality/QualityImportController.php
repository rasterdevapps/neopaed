<?php

namespace App\Http\Controllers\Quality;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Quality\DemographicDetails;
use Excel;
use Carbon\Carbon;
       // $test =  \DB::getSchemaBuilder()->getColumnListing('res_details');

use App\Http\Controllers\Quality\ExportResource;

class QualityImportController extends Controller
{
   /**
    * This get header rows 
    * @var $headerRow
    *
    */	
    public $headerRow;	

   /**
     * Construct qualityimportcontroller
     *
     *
     *
     */
   public function __construct() 
   {
   	  $this->headerRow  =  ExportResource::IMPORT_RESOURS;

   }
  /**
   * This method to get the import the
   * data from neopaed.com
   * @param $babyid type integer 
   * 
   * @return string
   */
   public function importbaby($baby_id) 
   {
       $baby_details        = collect(DemographicDetails::GetNicuBaby($baby_id))->toArray();
       $respiratory_details = DemographicDetails::GetNurseSheetDetails($baby_id);
       $results = \DB::table('local_code_group')->select('local_code')->get();
       $results = $results->pluck('local_code')->toArray();

      

     	$baby_check   = DemographicDetails::where('babyId', $baby_id)->get();

     	if (count($baby_check) > 0) {
        	 return \Response::json(['type'=>'error','message'=>'Baby already exist !'],200);
     	}

     	if (count($baby_details) > 0) {

     		$demograph_id  = $this->demographicDetails($baby_details); 
        $demograph_id  = $this->respiratory_details($baby_details);


    		return \Response::json(['type'=>'success','message'=>'Baby created successfully !'],200);

     	} 

		return \Response::json(['type'=>'error','message'=>'No Record found !'],200);



   }

  /**
   * This method to import from excel 
   * 
   * @return string 
   */
   public function importbabyexcel(Request $request) 
   {

   	    $path = public_path('imports/QualityIndicator9.xls');


	    Excel::load($path, function($reader) {
   	   
   	        $results         = $reader->get();
   	        $this->headerRow = $reader->first()->keys()->toArray();

   	        

		});



   }

  /**
   * This method to create demograph details
   * 
   * @param $baby_details type array 
   * 
   * @return string
   */
   private function demographicDetails($baby_details) 
   {

      		$demographic_details['sno'] 	                		= 	null;
      		$demographic_details['institute_number'] 	    	 	= 	null;
      		$demographic_details['mr_number'] 			    		  = 	$baby_details['BMrNo'];
      		$demographic_details['name'] 				    		      = 	$baby_details['BabyName'];

      		$demographic_details['maternal_age']	 	    		  = 	null;
      		$demographic_details['married_for']		 	    		  = 	null;
      		$demographic_details['hwbstatus']		 	    	    	= 	'N/A';
      		$demographic_details['height'] 							      = 	null;
      		$demographic_details['weight']						 	      = 	null;
      		$demographic_details['bmi'] 						        	= 	null;

      		$demographic_details['gravida']			 	    		    = 	$baby_details['G_Value'];
      		$demographic_details['para']			 	    	       	= 	$baby_details['P_Value'];
      		$demographic_details['live']			 	    	      	= 	$baby_details['L_Value'];
      		$demographic_details['abortions']		 	    	    	= 	$baby_details['A_Value'];
      		$demographic_details['gender']			 	    	     	= 	$baby_details['Sex'];
      		$demographic_details['birth_weight']	 	    		  = 	$baby_details['BirthWeight'];
      		$demographic_details['admission_weight'] 	    		= 	$baby_details['AdmissionWt'];
      		$demographic_details['dob']				 	    		      = 	$baby_details['DOB'];
      		$demographic_details['tob']				 	    		      = 	$baby_details['TOB'];
      		$demographic_details['intramural_extramural'] 		= 	$baby_details['BirthStatus'];
      		$demographic_details['sga'] 						        	= 	'N/A';
      		$demographic_details['gestation'] 						    = 	$baby_details['Gestation'];
          
        if ($baby_details['ModeOfDelivery'] == 'Normal Vaginal' || $baby_details['ModeOfDelivery'] == 'Preterm Vaginal' || $baby_details['ModeOfDelivery'] == 'Assisted Breech') {
        
        	$demographic_details['mode_of_delivery']	 		    = 	'NVD';
       
        } elseif ($baby_details['ModeOfDelivery'] == 'Emergency Caesarian') {
        
        	$demographic_details['mode_of_delivery']	 		    = 	'LSCS(Emergency)';
       
        } elseif ($baby_details['ModeOfDelivery'] == 'Ventouse') {
        
        	$demographic_details['mode_of_delivery']	 	     	= 	'Ventouse';
       
        } elseif ($baby_details['ModeOfDelivery'] == 'Caesarian') {
        
        	$demographic_details['mode_of_delivery']	 	    	= 	'Caesarian';
       
        } elseif ($baby_details['ModeOfDelivery'] == 'Elective Caesarian') {
        
        	$demographic_details['mode_of_delivery']	 	    	= 	'LSCS(Elective)';
       
        } elseif ($baby_details['ModeOfDelivery'] == 'Forceps') {
        
        	$demographic_details['mode_of_delivery']	 		    = 	'VD(Assisted)';
       
        } else {

        	$demographic_details['mode_of_delivery']	 		    = 	$baby_details['ModeOfDelivery'];

        }


      		$demographic_details['iflscs'] 							      = 	null;
      		$demographic_details['maternalcause'] 					  = 	null;
      		$demographic_details['fetalcause'] 					    	= 	null;

		      $demographic_details['antenatalMgSO4'] 				   	= 	$baby_details['antenatal_MgSO4'];
		
		    if ($baby_details['AntenatalSteroids'] == 'Yes' && $baby_details['SteroidCourse'] == 'Partial/Incomplete') {
		   
            $demographic_details['antenatalsteriods'] 			= 	'Partial';

	    	} else {

	      		$demographic_details['antenatalsteriods'] 		  = 	null;

	    	}

      		$demographic_details['steriod_last_dose'] 				= 	null;
      		$demographic_details['dexa_beta'] 					    	= 	$baby_details['typeofsteroids'];
      		$demographic_details['sepsisinmother']		 			  = 	$baby_details['sepsis_in_mother'];
      		$demographic_details['sepsis_in_mother_type'] 		= 	$baby_details['sepsis_in_mother_type'];
      		$demographic_details['resuscitationatbirth'] 			= 	$baby_details['Resuscitation'];
      		$demographic_details['initialsteps'] 					    = 	$baby_details['initial_steps'];
      		$demographic_details['ffo2'] 						        	= 	$baby_details['FacialOxygen'];
      		$demographic_details['bmv'] 						        	= 	$baby_details['bag_mask_ventilator'];
      		$demographic_details['bmv_duration'] 					    = 	($baby_details['bag_mask_ventilator_duration'] == 'known' && $baby_details['bag_mask_ventilator_min'] != '') ? ($baby_details['bag_mask_ventilator_min']*60) : null;
      		$demographic_details['btv'] 							        = 	$baby_details['PPV'];
      		$demographic_details['btv_duration'] 				    	= 	($baby_details['ppv_status'] == 'known' && $baby_details['DurationOfPPV'] != '') ? ($baby_details['DurationOfPPV']*60) : null;
      		$demographic_details['cc']					 			        = 	$baby_details['CPR'];
      		$demographic_details['cc_duration'] 					    = 	($baby_details['cpr_status'] == 'known' && $baby_details['duration_of_cpr'] != '') ? ($baby_details['duration_of_cpr']*60) : null ;
      		$demographic_details['medications'] 				     	= 	$baby_details['Drugs'];

      		 //need to discuss                    
      		$demographic_details['medication_details'] 				= 	null;
       		//need to discuss

 	      	$demographic_details['apgarstatus'] 					    = 	($baby_details['known_field'] == 2) ? 'N/A': null;

        if ($baby_details['known_field'] == 1) {

        	$demographic_details['apgar_1_min'] 				      = 	$baby_details['Apgars1min'];
    			$demographic_details['apgar_5_min'] 				      = 	$baby_details['Apgars5min'];
    			$demographic_details['apgar_10_min'] 				      = 	$baby_details['Apgars10min'];
    			$demographic_details['apgar_15_min'] 				      = 	$baby_details['Apgars15min'];
    			$demographic_details['apgar_20_min'] 				      = 	$baby_details['Apgars20min'];

        } else {

          $demographic_details['apgar_1_min'] 				      = 	null;
      		$demographic_details['apgar_5_min'] 				      = 	null;
      		$demographic_details['apgar_10_min'] 				      = 	null;
      		$demographic_details['apgar_15_min'] 				      = 	null;
      		$demographic_details['apgar_20_min'] 				      = 	null;
        }

        if ($baby_details['CordBloodGas'] == 'Not done') {

        	$demographic_details['cord_blood_gas'] 			     	= 	'N/A';

        } elseif($baby_details['CordBloodGas'] == 'Not indicated') {

        	$demographic_details['cord_blood_gas'] 			    	= 	'Not indicated';

        } else {

        	$demographic_details['cord_blood_gas'] 				    = 	null;

        }

      		$demographic_details['ph'] 								        = 	($baby_details['CordBloodGas'] == 'Not done' && $baby_details['CordBloodGas'] == 'Not indicated') ? $baby_details['CordpH'] : null;
      		$demographic_details['base_deficit'] 					    = 	($baby_details['CordBloodGas'] == 'Not done' && $baby_details['CordBloodGas'] == 'Not indicated') ? $baby_details['CordBE'] : null;

		      $demographic_details['severeperinatalasphyxia'] 	= 	'N/A';

        if ($baby_details['delayed_cord_clamping'] == 'Unknown') {

			    $demographic_details['delayedcordclamping']      =   'Not known';

        } else {

        	$demographic_details['delayedcordclamping']       =   $baby_details['delayed_cord_clamping'];
        }

        if ($baby_details['umbilicalcordmilking'] == 'N/A') {

		     	$demographic_details['umbilicalcordmilking']      =   'Not known';

        } else {

        	$demographic_details['umbilicalcordmilking']      =   $baby_details['umbilicalcordmilking'];

        }

        if ($baby_details['cutcordmilking'] == 'N/A') {

			    $demographic_details['cutcordmilking']            =   'Not known';

        } else {

        	$demographic_details['cutcordmilking']            =   $baby_details['cutcordmilking'];

        }

      	$demographic_details['indication_of_admission'] 		  = 	$baby_details['indication_of_admission'];
      	$demographic_details['indication_of_admission_other'] = 	$baby_details['indication_of_admission_other'];
      	$demographic_details['respiratorydistressat_birth'] 	= 	$baby_details['VentilationRequired'];

      	$demographic_details['surfactantgiven'] 				    = 	$baby_details['SurfactantGiven'];
      	$demographic_details['surfactant_type'] 			    	= 	json_encode($baby_details['SurfactantType']);

    		$demographic_details['age_first'] 						      = 	null;
    		$demographic_details['age_second'] 						      = 	null;
    		$demographic_details['age_third'] 						      = 	null;
    		$demographic_details['age_fourth'] 						      = 	null;
    		$demographic_details['total_number_of_doses'] 			= 	null;	
    		$demographic_details['age_at_admission_method'] 		= 	null;
    		$demographic_details['married_month'] 				    	= 	null;
    		$demographic_details['married_years'] 				    	= 	null;
    		$demographic_details['age_at_admission_h'] 			   	= 	null;
    		$demographic_details['age_at_admission_d'] 			  	= 	null;
    		$demographic_details['babyId'] 						        	= 	null;
    		$demographic_details['user_added'] 					       	= 	null;
    		$demographic_details['date_added'] 						      = 	null;
    		$demographic_details['user_modified'] 				    	= 	null;
    		$demographic_details['date_modified'] 				    	= 	null;
        $demographic_details['babyId']                      =   $baby_details['BabyId'];


		//return DemographicDetails::create($demographic_details)->id;

		

   }

   /**
    * This method create respiratory 
    * support 
    *
    * @param $baby_details type array 
    *
    * @return resource id
    */
    private function respiratory_details($baby_details)
    {


        $ventilationset_one = DemographicDetails::GetPrimaryRespiratory($baby_details['BabyId'], 'mode_of_ventilation')->toArray();
        $ventilationset_two = DemographicDetails::GetPrimaryRespiratory($baby_details['BabyId'], 'mode_of_ventilation_invasive')->toArray();
        $ventilation        = array_merge($ventilationset_one, $ventilationset_two);
        $primary_support    = $this->getprimaryventilation($ventilation, $baby_details['BabyId'], $baby_details);



        $respiratory_details['primary_res_support']         =   ($primary_support['ventilation_primary_required'] != '') ? 'Yes' : 'No';
        $respiratory_details['res_support_type']            =    $primary_support['ventilation_primary_required'];


        $respiratory_details['hhhnfc_settings_liter']       =   $primary_support['ventilation_hhhfnc_flow'];
        $respiratory_details['hhhnfc_settings_fio2']        =   $primary_support['ventilation_hhhfnc_fio2'];
        $respiratory_details['hhhnfc_duration']             =   $primary_support['ventilation_hhhfnc_duration'];
        $respiratory_details['hhhnfc_failure']              =   ($primary_support['respiratory_reason_hhfnc'] == true) ? 'Yes' : 'No';

        $respiratory_details['cpap_settings_peep']          =   $primary_support['ventilation_cpap_peep'];
        $respiratory_details['cpap_settings_fio2']          =   $primary_support['ventilation_cpap_fio2'];
        $respiratory_details['cpap_duration']               =   $primary_support['ventilation_cpap_duration'];
        $respiratory_details['cpap_failure']                =   ($primary_support['respiratory_reason_cpap'] == true) ? 'Yes' : 'No';

     // $respiratory_details['nippv_settings']              =   $baby_details['nippv_settings'];
        $respiratory_details['nippv_duration']              =   $primary_support['ventilation_nippv_duration'];
        $respiratory_details['nippv_failure']               =   ($primary_support['respiratory_reason_nippv'] == true) ? 'Yes' : 'No';


        $respiratory_details['nasal_hfov_pduration_map']    =   $primary_support['nasal_hfov_primary_map'];
        $respiratory_details['nasal_hfov_pduration_fio2']   =   $primary_support['nasal_hfov_primary_fio2'];
        $respiratory_details['nasal_hfov_pduration_amp']    =   $primary_support['nasal_hfov_primary_amp'];
        $respiratory_details['nasal_hfov_pduration_hz']     =   $primary_support['nasal_hfov_primary_frequency'];

        $respiratory_details['nasal_hfov_pduration']        =   $primary_support['nasal_hfov_primary_duration'];
        $respiratory_details['nasal_hfov_pfailure']         =   ($primary_support['respiratory_reason_prinasal_hfov'] == true) ? 'Yes' : 'No';

        $respiratory_details['nasal_hfov_ssettings_map']    =   $primary_support['nasal_hfov_secondary_map'];;
        $respiratory_details['nasal_hfov_ssettings_amp']    =   $primary_support['nasal_hfov_secondary_amp'];;
        $respiratory_details['nasal_hfov_ssettings_fio2']   =   $primary_support['nasal_hfov_secondary_fio2'];;
        $respiratory_details['nasal_hfov_ssettings_hz']     =   $primary_support['nasal_hfov_secondary_frequency'];;
        $respiratory_details['nasal_hfov_sduration']        =   $primary_support['nasal_hfov_secondary_duration'];
        $respiratory_details['nasal_hfov_sfailure']         =   ($primary_support['respiratory_reason_secnasal_hfov'] == true) ? 'Yes' : 'No';;

        $respiratory_details['mechanical_csettings_vol']    =   $primary_support['mechanical_conventional_vol'];
        $respiratory_details['nmechanical_csettings_fio2']  =   $primary_support['mechanical_conventional_fio2'];
        $respiratory_details['mechanical_cduration']        =   $primary_support['mechanical_conventional_duration'];
        $respiratory_details['mechanical_cfailure']         =   ($primary_support['respiratory_reason_conventional'] == true) ? 'Yes' : 'No';

        $respiratory_details['mechanical_pressure_map']     =   $primary_support['mechanical_conventional_map'];
        $respiratory_details['mechanical_csettings_fio2']   =   $primary_support['mechanical_conventional_fio2'];
        $respiratory_details['mechanical_pressureduration'] =   $primary_support['mechanical_conventional_duration'];
        $respiratory_details['mechanical_pressurefailure']  =  ($primary_support['respiratory_reason_conventional'] == true) ? 'Yes' : 'No';

        $respiratory_details['mechanical_psettings_map']    =   $primary_support['mechanical_ventilation_hfo_map'];
        $respiratory_details['mechanical_psettings_fio2']   =   $primary_support['mechanical_ventilation_hfo_fio2'];
        $respiratory_details['mechanical_psettings_amp']    =   $primary_support['mechanical_ventilation_hfo_amp'];
        $respiratory_details['mechanical_psettings_hz']     =   $primary_support['mechanical_ventilation_hfo_hz'];
        $respiratory_details['mechanical_pduration']        =   $primary_support['mechanical_failed_hfo_duration'];
        $respiratory_details['mechanical_pfailure']         =   ($primary_support['respiratory_prireason_hfo'] == true) ? 'Yes' : 'No';

        $respiratory_details['mechanical_rcsettings_map']   =   $baby_details['mechanical_ventilation_hfo_map'];
        $respiratory_details['mechanical_rcsettings_fio2']  =   $baby_details['mechanical_ventilation_hfo_fio2'];
        $respiratory_details['mechanical_rcsettings_amp']   =   $baby_details['mechanical_ventilation_hfo_amp'];
        $respiratory_details['mechanical_rcsettings_hz']    =   $baby_details['mechanical_ventilation_hfo_hz'];
        $respiratory_details['mechanical_rcduration']       =   $baby_details['mechanical_failed_hfo_duration'];
        $respiratory_details['mechanical_rcfailure']        =   ($primary_support['respiratory_reason_hfo'] == true) ? 'Yes' : 'No';

        $respiratory_details['oxygen_prongs_settings_fio2'] =   $baby_details['oxygen_prong_hood_fio2'];
        $respiratory_details['oxygen_prongs_duration']      =   $baby_details['prong_hood_duration'];
        $respiratory_details['oxygen_prongs_failure']       =   $baby_details['oxygen_prongs_failure'];

        $respiratory_details['mvc_total']                   =   $baby_details['total_conventional_duration'];
        $respiratory_details['hfov_total']                  =   $baby_details['total_hfo_duration'];
        $respiratory_details['hfov_mc_total']               =   $baby_details['total_conventional_with_hfo'];
        $respiratory_details['non_invasive_total']          =   $baby_details['non_invasive_duration'];

        $respiratory_details['group_id']                    =   null;
        $respiratory_details['baby_id']                     =   $baby_details['BabyId'];

        //return RespiratoryDetails::create($respiratory_details);
      
        //$respiratory_details['tetracycline']                =   $baby_details['tetracycline'];
         

    } 

    /**
     * This method to get the ventilation  
     * group
     *
     */
     public function getprimaryventilation($ventilation_type, $baby_id, $baby_details) 
     {
         $ventilation_details = $vendilation_formated =array();

         $ventilation_type = collect($ventilation_type)->sortBy('sender_time')->toArray();

         foreach ($ventilation_type as $key => $value) {

            $vendilation_formated[]  = (array)$value;       
         }

        #If check whether primary respiratory support is requied and mode of primary ventilation
         foreach ($ventilation_type as $key => $value) {
            if (!empty($value->intf_ref_value) && $value->intf_ref_value != '') {
             $ventilation_details['ventilation_primary_required'] = $value->intf_ref_value;  
             break;
            }
         }

         if ($ventilation_details['ventilation_primary_required'] == 'HBO2' || $ventilation_details['ventilation_primary_required'] == 'NPO2') {

            $ventilation_details['ventilation_primary_required'] = 'O2 prongs, hood';

         } else if ($ventilation_details['ventilation_primary_required'] == 'HHHFNC') {

            $ventilation_details['ventilation_primary_required'] = 'HHHFNC';

         } else if ($ventilation_details['ventilation_primary_required'] == 'CPAP') {

            $ventilation_details['ventilation_primary_required'] = 'CPAP';

         } else if ($ventilation_details['ventilation_primary_required'] == 'NIPPV') {

            $ventilation_details['ventilation_primary_required'] = 'NIPPV';

         } else if ($ventilation_details['ventilation_primary_required'] == 'Nasal HFOV') {

            $ventilation_details['ventilation_primary_required'] = 'Nasal HFOV';

         } else if ($ventilation_details['ventilation_primary_required'] == 'CMV' || $ventilation_details['ventilation_primary_required'] == 'IMV' || $ventilation_details['ventilation_primary_required'] == 'SIMV' || $ventilation_details['ventilation_primary_required'] == 'PSV' || $ventilation_details['ventilation_primary_required'] == 'PTV') {

            $ventilation_details['ventilation_primary_required'] = 'MV (Conventional)';

         } else if ($ventilation_details['ventilation_primary_required'] == 'HFO' ) {

            $ventilation_details['ventilation_primary_required'] = 'MV(HFOV)';

         }

         # EndIf check whether primary respiratory support is requied and mode of primary ventilation

         # If ventilation mode is hhhfnc
            $ventilation_details['ventilation_hhhfnc_flow'] = number_format((DemographicDetails::GetVentilatorMaxValues($baby_id, 'HHHFNC', 'fio2')[0]->get_max_value)/60, 2);
            $ventilation_details['ventilation_hhhfnc_fio2'] =  DemographicDetails::GetVentilatorMaxValues($baby_id, 'HHHFNC', 'flow')[0]->get_max_value;
           
            $temp_hhhfnc_details = collect($ventilation_type)->where('intf_ref_value', 'HHHFNC');

            $ventilation_details['ventilation_hhhfnc_duration'] = '';
            if (count($temp_hhhfnc_details) > 0) {
              $ventilation_details['ventilation_hhhfnc_duration'] = \SiteHelpers::calculate_hours_difference_two($temp_hhhfnc_details->first()->sender_time, $temp_hhhfnc_details->last()->sender_time);
            }
        
         # endIf ventilation mode is hhhfnc

         # if ventilation mode is cpap    
        
           $ventilation_details['ventilation_cpap_peep'] = DemographicDetails::GetVentilatorMaxValues($baby_id, 'CPAP', 'peep')[0]->get_max_value;
           $ventilation_details['ventilation_cpap_fio2'] = DemographicDetails::GetVentilatorMaxValues($baby_id, 'CPAP', 'fio2')[0]->get_max_value;
           $temp_cpap_details = collect($ventilation_type)->where('intf_ref_value', 'CPAP');
           
           $ventilation_details['ventilation_cpap_duration'] = '';
           if (count($temp_cpap_details) > 0) {
              $ventilation_details['ventilation_cpap_duration'] = \SiteHelpers::calculate_hours_difference_two($temp_cpap_details->first()->sender_time, $temp_cpap_details->last()->sender_time);
           }
         
         # endif ventilation mode is cpap   

         #if ventilation mode is NIPPV
           $temp_nippv_details = collect($ventilation_type)->where('intf_ref_value', 'NIPPV');
           
           $ventilation_details['ventilation_nippv_duration'] = '';
           if (count($temp_nippv_details) > 0) {
            $ventilation_details['ventilation_nippv_duration'] = \SiteHelpers::calculate_hours_difference_two($temp_nippv_details->first()->sender_time, $temp_nippv_details->last()->sender_time);

           }
         #endif ventilation mode is NIPPV  



        # if Nasal HFOV is primary calculated the required parameter 
         foreach ($ventilation_type as $key => $value) {
            if (!empty($value->intf_ref_value) && $value->intf_ref_value != '' && $value->intf_ref_value != 'Nasal HFOV') {
             $ventilation_details['nasal_hfov_primary'] = false;  
             break;
            } else if (!empty($value->intf_ref_value) && $value->intf_ref_value != '' && $value->intf_ref_value == 'Nasal HFOV') {
             $ventilation_details['nasal_hfov_primary'] = true;  
             break;
            }
         }

         $ventilation_details['nasal_hfov_primary_amp']  = $ventilation_details['nasal_hfov_primary_map'] = null;
         $ventilation_details['nasal_hfov_primary_fio2'] = $ventilation_details['nasal_hfov_primary_frequency'] = null;

         if (isset($ventilation_details['nasal_hfov_primary']) && $ventilation_details['nasal_hfov_primary'] == true) {

            $ventilation_details['nasal_hfov_primary_amp']       = DemographicDetails::GetVentilatorMaxValues($baby_id, 'Nasal HFOV', 'p_amplitude')[0]->get_max_value;
            $ventilation_details['nasal_hfov_primary_map']       = DemographicDetails::GetVentilatorMaxValues($baby_id, 'Nasal HFOV', 'map')[0]->get_max_value;
            $ventilation_details['nasal_hfov_primary_fio2']      = DemographicDetails::GetVentilatorMaxValues($baby_id, 'Nasal HFOV', 'fio2')[0]->get_max_value;
            $ventilation_details['nasal_hfov_primary_frequency'] = DemographicDetails::GetVentilatorMaxValues($baby_id, 'Nasal HFOV', 'frequency')[0]->get_max_value;
             
         }

          $temp_nasalhfov_primary = collect($ventilation_type)->where('intf_ref_value', 'Nasal HFOV');
          $ventilation_details['nasal_hfov_primary_duration'] = '';
          if (count($temp_nasalhfov_primary) > 0 && $ventilation_details['nasal_hfov_primary'] == true) {
            $ventilation_details['nasal_hfov_primary_duration']  = \SiteHelpers::calculate_hours_difference_two($temp_nasalhfov_primary->first()->sender_time, $temp_nasalhfov_primary->last()->sender_time);
          }

         # endif Nasal HFOV is primary calculated the required parameter 

         # if Nasal HFOV is secondary calculated the required parameter 
         $ventilation_details['nasal_hfov_secondary'] = false;

         for ($i = 0; $i  < count($vendilation_formated); $i++) { 

            $ventilation_mode = $vendilation_formated[$i]['intf_ref_value'];

            $j = $i;
            $j = $j + 1; 

            if (($ventilation_mode =='HBO2' || $ventilation_mode =='NPO2' || $ventilation_mode =='CPAP' || $ventilation_mode =='BiPAP' || $ventilation_mode =='HHHFNC') && isset($vendilation_formated[$j]['intf_ref_value']) && $vendilation_formated[$j]['intf_ref_value'] == 'Nasal HFOV') {
                $ventilation_details['nasal_hfov_secondary'] = true;
                break;  
            }
               
         }

         if ($ventilation_details['nasal_hfov_secondary'] == true) {

            $ventilation_details['nasal_hfov_secondary_amp']       = DemographicDetails::GetVentilatorMaxValues($baby_id, 'Nasal HFOV', 'p_amplitude')[0]->get_max_value;
            $ventilation_details['nasal_hfov_secondary_map']       = DemographicDetails::GetVentilatorMaxValues($baby_id, 'Nasal HFOV', 'map')[0]->get_max_value;
            $ventilation_details['nasal_hfov_secondary_fio2']      = DemographicDetails::GetVentilatorMaxValues($baby_id, 'Nasal HFOV', 'fio2')[0]->get_max_value;
            $ventilation_details['nasal_hfov_secondary_frequency'] = DemographicDetails::GetVentilatorMaxValues($baby_id, 'Nasal HFOV', 'frequency')[0]->get_max_value;

         }

          $temp_nasalhfov_secondary = collect($ventilation_type)->where('intf_ref_value', 'Nasal HFOV');
          $ventilation_details['nasal_hfov_secondary_duration'] = '';

          if (count($temp_nasalhfov_secondary) > 0 && $ventilation_details['nasal_hfov_secondary'] == true) {
            $ventilation_details['nasal_hfov_secondary_duration']  = \SiteHelpers::calculate_hours_difference_two($temp_nasalhfov_secondary->first()->sender_time, $temp_nasalhfov_secondary->last()->sender_time);
          }

         # endif Nasal HFOV is secondary calculated the required parameter 

          #start mechanical conventional
          $mechanical_conventional = collect($ventilation_type)->whereIn('intf_ref_value', ['CMV', 'SIMV', 'IMV', 'PSV', 'PTV'])->unique('intf_ref_value')->pluck('intf_ref_value')->toArray();
         
          $ventilation_details['mechanical_conventional_duration'] = 0;


          if (count($mechanical_conventional) > 0) {

            foreach ($mechanical_conventional as $mechanical_conventional_value) {
                
              $ventilation_vol[]   = DemographicDetails::GetVentilatorMaxValues($baby_id, $mechanical_conventional_value, 'targeted_tidal_volume')[0]->get_max_value;
              $ventilation_fio2[]  = DemographicDetails::GetVentilatorMaxValues($baby_id, $mechanical_conventional_value, 'fio2')[0]->get_max_value;
              $ventilation_map[]   = DemographicDetails::GetVentilatorMaxValues($baby_id, $mechanical_conventional_value, 'map')[0]->get_max_value;
              
               $temp_mechanical_conventional = collect($ventilation_type)->where('intf_ref_value', $mechanical_conventional_value);
              
               if (count($temp_mechanical_conventional) > 0) {

                   $ventilation_details['mechanical_conventional_duration'] += \SiteHelpers::calculate_hours_difference_two($temp_mechanical_conventional->first()->sender_time, $temp_mechanical_conventional->last()->sender_time);
               }

            }

            $ventilation_details['mechanical_conventional_vol']  = max($ventilation_vol);
            $ventilation_details['mechanical_conventional_fio2'] = max($ventilation_fio2);
            $ventilation_details['mechanical_conventional_map']  = max($ventilation_map);

          }


          #end mechanical conventional

          #if only ventilation mode is hfo
          if ($ventilation_details['ventilation_primary_required'] == 'MV(HFOV)') {

            $ventilation_details['mechanical_primary_hfo_map']  = DemographicDetails::GetVentilatorMaxValues($baby_id, 'HFO', 'map')[0]->get_max_value;
            $ventilation_details['mechanical_primary_hfo_fio2'] = DemographicDetails::GetVentilatorMaxValues($baby_id, 'HFO', 'fio2')[0]->get_max_value;
            $ventilation_details['mechanical_primary_hfo_amp']  = DemographicDetails::GetVentilatorMaxValues($baby_id, 'HFO', 'p_amplitude')[0]->get_max_value;
            $ventilation_details['mechanical_primary_hfo_hz']   = DemographicDetails::GetVentilatorMaxValues($baby_id, 'HFO', 'frequency')[0]->get_max_value;


          }

           $temp_mechanical_hfo = collect($ventilation_type)->where('intf_ref_value', 'HFO');
              
           if (count($temp_mechanical_hfo) > 0 && $ventilation_details['ventilation_primary_required'] == 'MV(HFOV)') {
               $ventilation_details['mechanical_primary_hfo_duration'] = \SiteHelpers::calculate_hours_difference_two($temp_mechanical_hfo->first()->sender_time, $temp_mechanical_hfo->last()->sender_time);
           }

          #endif only ventilation mode is hfo

           #if only ventilation mode is hfo due failed of mechanical conventional 
           $ventilation_details['mechanical_ventilation_hfo'] = false;
           for ($i = 0; $i  < count($vendilation_formated); $i++) { 

              $ventilation_mode = $vendilation_formated[$i]['intf_ref_value'];

              $j = $i;
              $j = $j + 1; 

              if (($ventilation_mode =='CMV' || $ventilation_mode =='IMV' || $ventilation_mode =='SIMV' || $ventilation_mode =='PSV' || $ventilation_mode =='PTV') && isset($vendilation_formated[$j]['intf_ref_value']) && $vendilation_formated[$j]['intf_ref_value'] == 'HFO') {
                  $ventilation_details['mechanical_ventilation_hfo'] = true;
                  break;  
              }
                 
           }

           if ($ventilation_details['mechanical_ventilation_hfo'] == true) {

              $ventilation_details['mechanical_ventilation_hfo_map']  = DemographicDetails::GetVentilatorMaxValues($baby_id, 'HFO', 'map')[0]->get_max_value;
              $ventilation_details['mechanical_ventilation_hfo_fio2'] = DemographicDetails::GetVentilatorMaxValues($baby_id, 'HFO', 'fio2')[0]->get_max_value;
              $ventilation_details['mechanical_ventilation_hfo_amp']  = DemographicDetails::GetVentilatorMaxValues($baby_id, 'HFO', 'p_amplitude')[0]->get_max_value;
              $ventilation_details['mechanical_ventilation_hfo_hz']   = DemographicDetails::GetVentilatorMaxValues($baby_id, 'HFO', 'frequency')[0]->get_max_value;
             
           }

              $temp_mechanical_failed_hfo = collect($ventilation_type)->where('intf_ref_value', 'HFO');
              $ventilation_details['mechanical_failed_hfo_duration'] = '';

              if (count($temp_mechanical_failed_hfo) > 0 && $ventilation_details['mechanical_ventilation_hfo'] == true) {
                     $ventilation_details['mechanical_failed_hfo_duration'] = \SiteHelpers::calculate_hours_difference_two($temp_mechanical_failed_hfo->first()->sender_time, $temp_mechanical_failed_hfo->last()->sender_time);
              }

             #endif only ventilation mode is hfo due failed of mechanical conventional 

             # if ventilator mode is hood or prong 
              $oxygen_hood_prong[]  = DemographicDetails::GetVentilatorMaxValues($baby_id, 'HBO2', 'fio2')[0]->get_max_value;
              $oxygen_hood_prong[]  = DemographicDetails::GetVentilatorMaxValues($baby_id, 'NPO2', 'fio2')[0]->get_max_value;
              $ventilation_details['oxygen_prong_hood_fio2'] = max($oxygen_hood_prong);

              $temp_duration_hbo2 = collect($ventilation_type)->where('intf_ref_value', 'HBO2');
              $temp_duration_npo2 = collect($ventilation_type)->where('intf_ref_value', 'NPO2');

              $ventilation_details['prong_hood_duration'] = 0;

              if (count($temp_duration_hbo2 ) > 0) {
                $ventilation_details['prong_hood_duration'] += \SiteHelpers::calculate_hours_difference_two($temp_duration_hbo2->first()->sender_time, $temp_duration_hbo2->last()->sender_time);

              }

              if (count($temp_duration_npo2 ) > 0) {
                $ventilation_details['prong_hood_duration'] += \SiteHelpers::calculate_hours_difference_two($temp_duration_npo2->first()->sender_time, $temp_duration_npo2->last()->sender_time);

              }
              #Endif  ventilator mode is hood or prong 


              #hhhfnc faild or not
              $ventilation_details['respiratory_reason_hhfnc'] = false;

              for ($i = 0; $i  < count($vendilation_formated); $i++) { 
                
                  $j = $i + 1; 
                  $ventilation_current = $vendilation_formated[$i]['intf_ref_value'];
                  $ventilation_next    = isset($vendilation_formated[$j]['intf_ref_value']) ? $vendilation_formated[$j]['intf_ref_value'] : null;
                  
                if ($ventilation_current == 'HHHFNC' && in_array($ventilation_next, ['CMV', 'IMV', 'SIMV', 'PSV', 'PTV', 'HFO'])) {
                   $ventilation_details['respiratory_reason_hhfnc'] = true;
                   break;  
                }
                 
              }

               #cpap failed or not 
              $ventilation_details['respiratory_reason_cpap'] = false;

              for ($i = 0; $i  < count($vendilation_formated); $i++) { 
                  
                  $j = $i + 1; 
                  $ventilation_current = $vendilation_formated[$i]['intf_ref_value'];
                  $ventilation_next    = isset($vendilation_formated[$j]['intf_ref_value']) ? $vendilation_formated[$i]['intf_ref_value'] : null ;

                  if ($ventilation_current == 'CPAP' && in_array($ventilation_next, ['CMV', 'IMV', 'SIMV', 'PSV', 'PTV', 'HFO'])) {
                      $ventilation_details['respiratory_reason_cpap'] = true;
                      break;  
                  }
                 
              }

              #nippv reason failed or not 
              $ventilation_details['respiratory_reason_nippv'] = false;

              for ($i = 0; $i  < count($vendilation_formated); $i++) { 

                  $j = $i + 1; 
                  $ventilation_current = $vendilation_formated[$i]['intf_ref_value'];
                  $ventilation_next    = isset($vendilation_formated[$j]['intf_ref_value']) ? $vendilation_formated[$j]['intf_ref_value'] : null ;

                  if ($ventilation_current == 'NIPPV' && in_array($ventilation_next, ['CMV', 'IMV', 'SIMV', 'PSV', 'PTV', 'HFO'])) {
                      $ventilation_details['respiratory_reason_nippv'] = true;
                      break;  
                  }
                 
              }

              #nasal hfov primary  failed or not
              $ventilation_details['respiratory_reason_prinasal_hfov'] = false;

              if ($ventilation_details['ventilation_primary_required'] == 'Nasal HFOV') {
                for ($i = 0; $i  < count($vendilation_formated); $i++) { 

                    $j = $i + 1; 
                    $ventilation_current = $vendilation_formated[$i]['intf_ref_value'];
                    $ventilation_next    = isset($vendilation_formated[$j]['intf_ref_value']) ? $vendilation_formated[$j]['intf_ref_value'] : null ;

                    if ($ventilation_current == 'Nasal HFOV' && in_array($ventilation_next, ['CMV', 'IMV', 'SIMV', 'PSV', 'PTV', 'HFO'])) {
                        $ventilation_details['respiratory_reason_prinasal_hfov'] = true;
                        break;  
                    }
                   
                }
              }  

              #nasal hfov secondary failed or not
              $ventilation_details['respiratory_reason_secnasal_hfov'] = false;

              for ($i = 0; $i  < count($vendilation_formated); $i++) { 

                $j = $i + 1; 
                $ventilation_current = $vendilation_formated[$i]['intf_ref_value'];
                $ventilation_next    = isset($vendilation_formated[$j]['intf_ref_value']) ? $vendilation_formated[$j]['intf_ref_value'] : null ;
                   
                if ($i != 0) {
                  if ($ventilation_current == 'Nasal HFOV' && in_array($ventilation_next, ['CMV', 'IMV', 'SIMV', 'PSV', 'PTV', 'HFO'])) {
                      $ventilation_details['respiratory_reason_secnasal_hfov'] = true;
                      break;  
                  }
                }  
                   
              }
              

              #conventional failed both
              $ventilation_details['respiratory_reason_conventional'] = false;

              for ($i = 0; $i  < count($vendilation_formated); $i++) { 

                  $j = $i + 1; 
                  $ventilation_current = $vendilation_formated[$i]['intf_ref_value'];
                  $ventilation_next    = isset($vendilation_formated[$j]['intf_ref_value']) ? $vendilation_formated[$j]['intf_ref_value'] : null ;


                  if (in_array($ventilation_current, ['CMV', 'IMV', 'SIMV', 'PSV', 'PTV']) && $ventilation_next == 'HFO') {
                      $ventilation_details['respiratory_reason_conventional'] = true;
                      break;  
                  }
                 
              }


              #hfo primary failed or not
              $ventilation_details['respiratory_prireason_hfo'] = false;

              if ($ventilation_details['ventilation_primary_required'] == 'MV(HFOV)') {

                  for ($i = 0; $i  < count($vendilation_formated); $i++) { 

                      $j = $i + 1; 
                      $ventilation_current = $vendilation_formated[$i]['intf_ref_value'];
                      $ventilation_next    = isset($vendilation_formated[$j]['intf_ref_value']) ? $vendilation_formated[$j]['intf_ref_value'] : null ;

                      if (($ventilation_current == 'HFO' && in_array($ventilation_next, ['CMV', 'IMV', 'SIMV', 'PSV', 'PTV', 'Nasal HFOV'])) || ($baby_details['status'] == 'Died' || $baby_details['status'] == 'Died (OCNR)')) {
                           $primary_hfo  =  collect($vendilation_formated)->where('intf_ref_value', $ventilation_current);
                           $conventional =  collect($vendilation_formated)->where('intf_ref_value', $ventilation_next);
                           $first_hfo_details  = $primary_hfo->first();
                           $first_conventional = $conventional->first();

                          $duration = \SiteHelpers::calculate_hours_difference_two($first_hfo_details['sender_time'], $first_conventional['sender_time']);
                          if($duration <= 2) {
                           $ventilation_details['respiratory_prireason_hfo'] = true;
                          }   

                          break;  
                      } elseif ($ventilation_current == 'HFO' && !in_array($ventilation_next, ['CMV', 'IMV', 'SIMV', 'PSV', 'PTV', 'Nasal HFOV']) && ($baby_details['status'] == 'Died' || $baby_details['status'] == 'Died (OCNR)')) {
                          $ventilation_details['respiratory_prireason_hfo'] = true;
                          break;  

                      }
                     
                  }
              }

                echo '<pre>';print_r(var_dump($ventilation_details['respiratory_prireason_hfo']));exit;
              $mechanical_conventional_modes = collect($ventilation_type)->whereIn('intf_ref_value', ['CMV', 'IMV', 'SIMV', 'PSV', 'PTV'])
                                                                          ->unique('intf_ref_value')
                                                                          ->pluck('intf_ref_value')
                                                                          ->toArray();

              $ventilation_details['total_conventional_duration'] = 0;
              foreach ($mechanical_conventional_modes as $mechanical_conventional_key => $mechanical_conventional_value) {

                $temp_duration_conventional = collect($ventilation_type)->where('intf_ref_value', $mechanical_conventional_value);
                
                if (count($temp_duration_conventional) > 0) {
                  $ventilation_details['total_conventional_duration'] += \SiteHelpers::calculate_hours_difference_two($temp_duration_conventional->first()->sender_time, $temp_duration_conventional->last()->sender_time);
                }
                  
              } 

              $temp_duration_hfo = collect($ventilation_type)->where('intf_ref_value', 'HFO');

              $ventilation_details['total_hfo_duration'] = 0;

              if (count($temp_duration_hfo) > 0) {
                  $ventilation_details['total_hfo_duration'] = \SiteHelpers::calculate_hours_difference_two($temp_duration_hfo->first()->sender_time, $temp_duration_hfo->last()->sender_time);
              }

              $ventilation_details['total_conventional_with_hfo'] = $ventilation_details['total_conventional_duration'] + $ventilation_details['total_hfo_duration'];

              $non_invasive_modes = collect($ventilation_type)->whereIn('intf_ref_value', ['HHHFNC', 'CPAP', 'NPO2', 'NIPPV'])
                                                                          ->unique('intf_ref_value')
                                                                          ->pluck('intf_ref_value')
                                                                          ->toArray();
              $ventilation_details['non_invasive_duration'] = 0;

              foreach ($non_invasive_modes as $non_invasive_modes_value) {

                $temp_duration_non_invasive = collect($ventilation_type)->where('intf_ref_value', $non_invasive_modes_value);
                
                if (count($temp_duration_non_invasive) > 0) {
                  $ventilation_details['non_invasive_duration'] += \SiteHelpers::calculate_hours_difference_two($temp_duration_non_invasive->first()->sender_time, $temp_duration_non_invasive->last()->sender_time);
                }
              
              }


        return $ventilation_details;


     }





}
