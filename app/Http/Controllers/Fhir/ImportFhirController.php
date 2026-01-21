<?php

namespace App\Http\Controllers\Fhir;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Fhir\FhirFormatedValues;
use App\Models\Baby;
use App\Models\Admission;
use App\Models\Nurse\EmrLogHeader;
use App\Models\Nurse\EmrLogDetails;
use App\Models\Nurse\ImportFhir;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Models\Nurse\NurseSheetMain;
use App\Models\Mother;
use Carbon\Carbon;

use App\Models\Nurse\NurseIvInfusion;
use App\Models\Nurse\NurseOtherIvDrugs;
use App\Models\Nurse\NurseOtherIvInfusion;
use App\Models\Nurse\NurseGlucoseIntake;
use App\Models\Nurse\NurseOralDrugs;
use App\Models\Ward\BedLog;
use App\Models\IpNumber;
class ImportFhirController extends Controller
{
    /**
     *
     * @var $fhir_format_values
     *
     */
     public $fhir_format_values;

    /**
     *
     * @var $auth
     *
     */
     public $auth;

    /**
     *
     * @var $custom_error
     *
     */
     public $custom_error;

    /**
	 * controller constructor
	 *
	 */
	public function __construct() {
		 $this->fhir_format_values = new FhirFormatedValues();
         $this->custom_error       = new ErrorLogController();
	}
	/**
	 * controller constructor
	 *
	 */
	public function creatensursesheet()
	{
		    $machine_values = $this->fhir_format_values->where('is_completed', false)
                                                   ->orderBy('id', 'asc')
                                                   ->limit(5000)
                                                   ->get();
        foreach ($machine_values  as $machine_values_key => $machine_values_value) {


            $baby_details    = ImportFhir::get_baby_details($machine_values_value->mrn); 
            if (!isset($baby_details->BabyId)) {
                 $this->custom_error->emergencyLog('baby details not found mrn:'.$machine_values_value->mrn);
                 $this->custom_error->emergencyLog('create baby registeration for mrn:'.$machine_values_value->mrn);
                $babyId = $this->createbabyreg($machine_values_value);
                $baby_details    = ImportFhir::get_baby_details($machine_values_value->mrn); 

            } else {
                $babyId = $baby_details->BabyId;
            }

            $baby_admission  = ImportFhir::get_baby_admission($babyId);
            if (!isset($baby_admission->AdmissionId)) {

                  $this->custom_error->emergencyLog('admission details not found BabyId:'.$babyId);
                  $this->custom_error->emergencyLog('create baby admission for mrn:'.$babyId);
                $this->createbabyadmisison($baby_details->BabyId, $baby_details->MotherId, $baby_details->BMrNo);
                $baby_admission  = ImportFhir::get_baby_admission($babyId);
                $admissionid = $baby_admission->AdmissionId;
       
            } else {

               $admissionid     = $baby_admission->AdmissionId;
            }


			       $time_issued     = $machine_values_value->start_time;
			       $nurse_date 	 = date('Y-m-d', strtotime($time_issued));
			       $nurse_time 	 = date('H:i:s', strtotime($time_issued));
            $machine_values_value->snomed_code =  str_replace(';', '', $machine_values_value->snomed_code);
            $machine_values_value->snomed_code =  str_replace('-', '', $machine_values_value->snomed_code);
            
            $get_local_code     = ImportFhir::get_nurse_snomed_details($machine_values_value->snomed_code)->first(); 
            if($nurse_date == '2021-01-06' && $machine_values_value->snomed_code =='767002') {
              echo '<pre>';print_r($get_local_code);exit;
            }
            if (count($get_local_code) == 0) {
               $this->custom_error->emergencyLog('The snomed code is not found in table code :'.$machine_values_value->snomed_code);
                  //$machine_values_value->is_completed  = true;
                  $machine_values_value->save();
            } else {
    			      $emr_log_header  = ImportFhir::get_emr_header_checks($nurse_date, $babyId, $admissionid, $nurse_time);
                $this->custom_error->emergencyLog('sheet log: nurse-date-'.$nurse_date.' baby-id-'.$babyId.' admission-id-'.$admissionid.' nurse-time-'.$nurse_time);
    		    if (count($emr_log_header) > 0) {
       			    $emr_log_header_id  = $emr_log_header->id;
                    //$this->custom_error->emergencyLog('snomed value updated'.$emr_log_header_id);

                    //volume targeting and vendilation mode
                     if($machine_values_value->model == 'SLE6000' || $machine_values_value->model == 'SLE5000') {
                         $volume_target  = ImportFhir::get_nurse_sheet_details($emr_log_header_id, $nurse_time, '113');
                         //volume targeting 
                         if(count($volume_target) == 0 && $machine_values_value->asset_number != '' && count(explode(':', $machine_values_value->asset_number))==5) {
                           $asset_number = explode(':', $machine_values_value->asset_number);
                           if($asset_number[2] == '16') {
                             $volume_targeting = null;
                           }else{
                             $volume_targeting = ($asset_number[3] == '255') ? 'on':null;
                           }

                           $volume_targeting_local_code = ImportFhir::get_nurse_snomed_details('405609003')->first(); 
                           //$this->custom_error->emergencyLog('adding volume targeting');
                           $this->createlogdtl($emr_log_header_id, $volume_targeting_local_code, $nurse_time, $volume_targeting);
                          
                          }elseif(count($volume_target) == 0 && $machine_values_value->asset_number != '' && count(explode(':', $machine_values_value->asset_number))==4){

                            $asset_number = explode(':', $machine_values_value->asset_number);
                           if($asset_number[2] == '16') {
                             $volume_targeting = null;
                           }else{
                             $volume_targeting = ($asset_number[3] == '255') ? 'on':null;
                           }

                           $volume_targeting_local_code = ImportFhir::get_nurse_snomed_details('405609003')->first(); 
                           //$this->custom_error->emergencyLog('adding volume targeting');
                           $this->createlogdtl($emr_log_header_id, $volume_targeting_local_code, $nurse_time, $volume_targeting);
                          

                          } elseif($machine_values_value->asset_number != '' && count(explode(':', $machine_values_value->asset_number))==5) {
                            $asset_number = explode(':', $machine_values_value->asset_number);
                            if($asset_number[2] == '16') {
                               $volume_targeting = null;
                             }else{
                               $volume_targeting = ($asset_number[3] == '255') ? 'on':null;
                             }
                            // $this->custom_error->emergencyLog('updating volume targeting');
                            $this->updatelogdtl($volume_target->id, $volume_targeting);
                         } elseif($machine_values_value->asset_number != '' && count(explode(':', $machine_values_value->asset_number))==4) {
                            $asset_number = explode(':', $machine_values_value->asset_number);
                            if($asset_number[2] == '16') {
                               $volume_targeting = null;
                             }else{
                               $volume_targeting = ($asset_number[3] == '255') ? 'on':null;
                             }
                            // $this->custom_error->emergencyLog('updating volume targeting');
                            $this->updatelogdtl($volume_target->id, $volume_targeting);
                         }
                        //volume targeting 
                        $vendilation    = ImportFhir::get_nurse_sheet_details($emr_log_header_id, $nurse_time, '47');
                        if(count($vendilation) == 0 && $machine_values_value->asset_number != '' && count(explode(':', $machine_values_value->asset_number))==5) {
                           $asset_number = explode(':', $machine_values_value->asset_number);
                           $vendilation_mode = \DeviceHelpers::getVendilationMode($asset_number[2],$machine_values_value->model);
                           $vendilation_mode_local_code = ImportFhir::get_nurse_snomed_details('397814002')->first(); 
                           //$this->custom_error->emergencyLog('adding vendilator mode');
                            if(!is_array($vendilation_mode)) {
                             $this->createlogdtl($emr_log_header_id, $vendilation_mode_local_code, $nurse_time, $vendilation_mode);
                            }                           
                        }elseif(count($vendilation) == 0 && $machine_values_value->asset_number != '' && count(explode(':', $machine_values_value->asset_number))==4) {
                           $asset_number = explode(':', $machine_values_value->asset_number);
                           $vendilation_mode = \DeviceHelpers::getVendilationMode($asset_number[2],$machine_values_value->model);
                           $vendilation_mode_local_code = ImportFhir::get_nurse_snomed_details('397814002')->first(); 
                           //$this->custom_error->emergencyLog('adding vendilator mode');
                            if(!is_array($vendilation_mode)) {
                             $this->createlogdtl($emr_log_header_id, $vendilation_mode_local_code, $nurse_time, $vendilation_mode);
                            }                           
                        } elseif($machine_values_value->asset_number != '' && count(explode(':', $machine_values_value->asset_number))==5){
                            $asset_number = explode(':', $machine_values_value->asset_number);
                            $vendilation_mode = \DeviceHelpers::getVendilationMode($asset_number[2],$machine_values_value->model);
                            //$this->custom_error->emergencyLog('updating vendilator mode');
                            $this->updatelogdtl($vendilation->id, $vendilation_mode);

                        } elseif($machine_values_value->asset_number != '' && count(explode(':', $machine_values_value->asset_number))==4){
                            $asset_number = explode(':', $machine_values_value->asset_number);
                            $vendilation_mode = \DeviceHelpers::getVendilationMode($asset_number[2],$machine_values_value->model);
                            //$this->custom_error->emergencyLog('updating vendilator mode');
                            $this->updatelogdtl($vendilation->id, $vendilation_mode);

                        }

                    }    
                    //volume targeting and vendilation mode

                    $local_id           = $get_local_code->ref_loc_master_id;
                    $emr_log_details 	= ImportFhir::get_nurse_sheet_details($emr_log_header_id, $nurse_time, $local_id);
                   
                    if (count($emr_log_details) > 0 && isset($emr_log_details->id)) {
                       $this->updatelogdtl($emr_log_details->id, $machine_values_value->mean);
                    } else {
                        //set parameter for o2 
                       $asset_number = explode(':', $machine_values_value->asset_number);
                       if($asset_number == '16') {
                          if($get_local_code->snomed_code =='250849000' || $get_local_code->snomed_code =='250774007') {
                            $this->createlogdtl($emr_log_header_id, $get_local_code, $nurse_time, $machine_values_value->mean);
                          }
                            //set parameter for o2
                       } elseif($asset_number != '16') {
                          $this->createlogdtl($emr_log_header_id, $get_local_code, $nurse_time, $machine_values_value->mean);
                       }
                    }
    		    } else {
                        $day_sheet_id = ImportFhir::get_nurse_sheet_check($nurse_date, $baby_details->BabyId, $admissionid);

                    if(count($day_sheet_id) == 0) {
                        $day_sheet_id  =  $this->createmainday($baby_details->BabyId, $admissionid, $nurse_date);
 
                     } else {
                        $day_sheet_id = ImportFhir::get_nurse_sheet_check($nurse_date, $baby_details->BabyId, $admissionid)->id;
                     }

                    $header_id     =  $this->createsheetheader($baby_details->BabyId, $admissionid, $baby_details, $time_issued, $day_sheet_id);
                    $get_local_code     = ImportFhir::get_nurse_snomed_details($machine_values_value->snomed_code)->first(); 
                    
                    $local_id           = $get_local_code->ref_loc_master_id;
                    $this->createlogdtl($header_id, $get_local_code, $nurse_time, $machine_values_value->mean);

    		    }  
            	$mrn_number = $machine_values_value->mrn;
            	$date       = date('Y-m-d', strtotime($nurse_time));
            	$dateTime   = date('Y-m-d', strtotime($nurse_time));
               // $machine_values_value->is_completed  = true;
                if(isset(explode('-', $machine_values_value->model)[1]) &&explode('-', $machine_values_value->model)[1] == 'pump') {
                  $this->custom_error->emergencyLog('Prescription details MRN-'.$machine_values_value->mrn.' Name-'.$machine_values_value->name .' asset_number-'.$machine_values_value->asset_number.' mean'.$machine_values_value->mean. ' date-'.$machine_values_value->issued);
                }

                $machine_values_value->save();
            }
        }
        return \Response::json(['type'=>'success'], 200);

	}

    /**
     * This method to create baby
     *
     * @param $baby_details type array 
     * 
     * @return $baby_id
     *
     */
    public function createbabyreg($baby_details) 
    {

        \DB::beginTransaction();

        try {
        
            $mother['MotherName']   = 'M/O'.$baby_details->name;
            $mother['UserAdded']    = 8;
            $mother['UserModified'] = 8;
            $mother['DateAdded']    = Carbon::now();
            $mother['IsDeleted']    = '0';
            $mother_id = Mother::create($mother)->MotherId;

            $baby['MotherId']              = $mother_id;
            $baby['BMrNo']                 = trim($baby_details->mrn);
            $baby['BabyName']              = 'B/O '.strtolower($baby_details->name);
            $baby['Sex']                   = $baby_details->gender;
            $baby['DOB']                   = $baby_details->birthdate;
            //$baby['TOB']                   = $baby_details->name;
            $baby['MultiplePregnancy']     = 'No';
            $baby['MultiplePregnancyType'] = 'Singleton';
            // $baby['Noofbabies']            = $baby_details->name;
            $baby['UserAdded']             = 8;
            $baby['DateAdded']             = Carbon::now();
            $baby['IsDeleted']             = 0;
            // $baby['TOB_TIME']              = $baby_details->name;
            // $baby['TOB_MINS']              = $baby_details->name;
            // $baby['TOB_AM']                = $baby_details->name;
            // $baby['g_weeks']               = $baby_details->name;
            // $baby['g_days']                = $baby_details->name;

            $babyIsExist = Baby::where('BMrNo', trim($baby_details->mrn))->first();
            if (count($babyIsExist) > 0) {
                $baby_id = $babyIsExist->BMrNo;
            } else {
                $baby_id = Baby::create($baby)->BabyId;
            }
            


        } catch(\Exception $e) {

            $this->custom_error->emergencyLog('failed to create baby registeration for mrn:'.$machine_values_value->mrn);
            \DB::rollback();
             return false;
        }
        \DB::commit();
        return $baby_id;
    }

    /**
     * This method careate baby admission
     *
     * @param $baby_id type integer
     *
     * @param $mother_id type integer 
     *
     * @return $admission_id  
     */
    public function createbabyadmisison($baby_id, $mother_id, $bmr_no)
    {

        \DB::beginTransaction();

        try {

            $admission_old = Admission::where('BabyId', $baby_id)->count();
            $admission_old = $admission_old + 1;
            $admission["BMrNo"]         = $bmr_no;  
            $admission["MotherId"]      = $mother_id;
            $admission["BabyId"]        = $baby_id;
            $admission["AdmissionDate"] = Carbon::now()->format('Y-m-d');
            $admission["AdmissionTime"] = Carbon::now()->format('H:i:s');
            $admission["InOrOut"]       = 'In';
            $admission["AdmissionType"] = 'NICU';
            $admission["Status"]        = 'Inpatient';
            $admission["UserAdded"]     = '8';
            $admission["DateAdded"]     = Carbon::now();
            $admission["DateModified"]  = Carbon::now();
            $admission["episodes"]      = 'Admission '.$admission_old;
            $admission_exists           = Admission::get_existing_admission($baby_id);
        
            if (count($admission_exists) > 0) {
                $admission_id = $admission_exists->AdmissionId;
            } else {
                $admission_id =  Admission::create($admission)->AdmissionId;
            }
                         
          

        } catch(\Exception $e) {

            $this->custom_error->emergencyLog('failed to create baby admission for mrn:'.$machine_values_value->mrn);
            \DB::rollback();
             return false;
        }
        \DB::commit();
        return $admission_id;
    }

     /**
     * This method to create main sheet 
     * with date 
     *
     * @param $babyid type integer
     *
     * @param $admissionid type integer
     *
     * @param $nurse_date type date
     *
     * @return $sheet_id type integer
     */
    public function createmainday($babyid, $admissionid, $nurse_date)
    {
        $dayCount = count(ImportFhir::get_nurse_sheet_count($babyid, $admissionid));

        $sheet_details['day_name']     = 'Day '.($dayCount + 1);
        $sheet_details['sheet_date']   = date('Y-m-d', strtotime($nurse_date));
        $sheet_details['baby_id']      = $babyid;
        $sheet_details['admission_id'] = $admissionid;
        $sheet_id =  NurseSheetMain::create($sheet_details)->id;

        return $sheet_id;

    }


    /**
     * This method to create header log
     * with time
     *
     * @param $babyid type integer
     *
     * @param $admissionid type integer
     *
     * @param $baby_details type array 
     *
     * @param $time_issued type time stamp
     * 
     * @param $day_sheet_id type integer
     */
    public function createsheetheader($babyid, $admissionid, $baby_details, $time_issued, $day_sheet_id) 
    {

        $main_sheet['sender']         = env('APP_NAME');  
        $main_sheet['gender']         = $baby_details->Sex;
        $main_sheet['sender_time']    = date('Y-m-d H:i:s', strtotime($time_issued));
        $main_sheet['visit_date']     = date('Y-m-d H:i:s', strtotime($time_issued));
        $main_sheet['loinc_version']  = 2.63;
        $main_sheet['active_flag']    = 'Y';
        $main_sheet['create_user_id'] = 'interface machine';
        $main_sheet['create_tstamp']  = date('Y-m-d H:i:s', time());
        $main_sheet['modify_user_id'] = 'interface machine';
        $main_sheet['modify_tstamp']  = date('Y-m-d H:i:s', time());
        $main_sheet['day_id']         = isset($day_sheet_id) ? $day_sheet_id : null;
        $main_sheet['baby_id']        = isset($babyid) ? $babyid : null;
        $main_sheet['mother_id']      = isset($baby_details->MotherId) ? $baby_details->MotherId : null;
        $main_sheet['admission_id']   = isset($admissionid) ? $admissionid : null;
        $main_sheet['added_nurse']    = null;
        $emr_log_head_id              = EmrLogHeader::create($main_sheet)->id;
        return $emr_log_head_id;


    }

    /**
     * This method to create value log
     * with time
     *
     * @param $emr_log_header_id type integer
     *
     * @param $result type array
     *
     * @param $nurse_time type time stamp
     * 
     * @param $value type integer
     */
     public function createlogdtl($emr_log_header_id, $result, $nurse_time, $value)
     {
        $result  = collect($result)->toArray();
        $sub_sheet_values["log_hdr_id"]         = $emr_log_header_id;
        $sub_sheet_values["loinc_local_map_id"] = $result['ref_loc_master_id'];
        $sub_sheet_values["loinc_code"]         = $result['loinc_code']; 
        $sub_sheet_values["loinc_version"]      = $result['loinc_version'];  
        $sub_sheet_values["intf_ref_name"]      = 'None'; 
        $sub_sheet_values["intf_ref_value"]     = $value;  
        $sub_sheet_values["component"]          = $result['component']; 
        $sub_sheet_values["property"]           = $result['property']; 
        $sub_sheet_values["time"]               = $nurse_time;
        $sub_sheet_values["system"]             = $result["system"];
        $sub_sheet_values["scale"]              = $result["scale_typ"];
        $sub_sheet_values["method"]             = $result["method_typ"];
        $sub_sheet_values["classtype"]          = $result["classtype"];
        $sub_sheet_values["active_flag"]        = $result["active_flag"];
        $sub_sheet_values["create_user_id"]     = 'interface machine';
        $sub_sheet_values["create_tstamp"]      = date('Y-m-d H:i:s', time());
        $sub_sheet_values["modify_user_id"]     = 'interface machine';
        $sub_sheet_values["modify_tstamp"]      = date('Y-m-d H:i:s', time());
        EmrLogDetails::create($sub_sheet_values);
        return true;

     }

    /**
     * This method to update value log
     * with time
     *
     * @param $id type integer
     * 
     * @param $value type integer
     */
     public function updatelogdtl($id, $value)
     {
        $log_emr_details =  EmrLogDetails::find($id);
        
        if (count($log_emr_details) > 0) {
           $emr_value['intf_ref_value'] = $value;
           $log_emr_details->update($emr_value); 
           return true;
        } 


        //$this->custom_error->emergencyLog('The rows not found in emr observation values');
        return true;

     }

     /**
      * This method to update oxygen index
      *
      */
      public function updateOxygenIndex() 
      {
        
        $map_values            = EmrLogDetails::getOxygenIndex('60949-5');
        $fio2_values           = EmrLogDetails::getOxygenIndex('3150-0');
        $predoctal_sao2_values = EmrLogDetails::getOxygenIndex('59407-7');
               
        foreach ($map_values as $key => $value) {
            $fio2_value           = $fio2_values->where('log_hdr_id', $value->log_hdr_id)->first();
            $predoctal_sao2_value = $predoctal_sao2_values->where('log_hdr_id', $value->log_hdr_id)->first();

            if(isset($fio2_value->intf_ref_value) && isset($predoctal_sao2_value->intf_ref_value) && isset($value->intf_ref_value)) {

                $oxygen_index_values = ($value->intf_ref_value *$fio2_value->intf_ref_value) / $predoctal_sao2_value->intf_ref_value;
                $baby_details =  Baby::find($value->baby_id);
                $bed_details  =  BedLog::getPatientBedLog($value->baby_id, $value->admission_id);
                $ip_number    =  IpNumber::getCurrent_ip($value->baby_id, $value->admission_id);

                $oxygen_set['name']               = isset($baby_details->BabyName) ? $baby_details->BabyName : '';
                $oxygen_set['gender']             = isset($baby_details->Sex) ? $baby_details->Sex : '';
                $oxygen_set['birthdate']          = isset($baby_details->DOB) ? $baby_details->DOB : '';
                $oxygen_set['mrn']                = isset($baby_details->BMrNo) ? $baby_details->BMrNo : '';
                $oxygen_set['visit_type']         = 'IP';
                $oxygen_set['ip_number']          = isset($ip_number->ip_number) ? $ip_number->ip_number : '';
                $oxygen_set['ward']               = isset($bed_details->ward_name) ? $bed_details->ward_name : '';
                $oxygen_set['bed']                = isset($bed_details->bed_no) ? $bed_details->bed_no : '';

                $oxygen_set['model']              = 'Manual Calculation';
                $oxygen_set['owner']              = '';
                $oxygen_set['patient']            = '';
                $oxygen_set['loinc_code']         = '313558004 |Oxygenation index measurement (procedure)|';
                $oxygen_set['display']            = '313558004 |Oxygenation index measurement (procedure)|';

                $oxygen_set['issued']             = $value->visit_date;
                $oxygen_set['status']             = 'final';

                $oxygen_set['low']                = '';
                $oxygen_set['first_quartile']     = '';
                $oxygen_set['mean']               = number_format($oxygen_index_values, 2);
                $oxygen_set['last_quartile']      = '';
                $oxygen_set['close']              = '';

                $oxygen_set['value_quality_unit'] = '';
                $oxygen_set['is_completed']       = false;
                $oxygen_set['asset_number']       = '';
                $oxygen_set['start_time']         = $value->visit_date;
                $oxygen_set['from_id']            = '';
                $oxygen_set['to_id']              = '';

                $oxygen_set['snomed_ct']          = '313558004 |Oxygenation index measurement (procedure)|';
                $oxygen_set['snomed_code']        = '313558004';

                $oxygen_set['is_calculated']      = true;
                FhirFormatedValues::create($oxygen_set);
                $mean_airway_pressure = EmrLogDetails::find($value->log_id);
                $mean_airway_pressure->is_calulated = true;
                $mean_airway_pressure->save();

                $fio2 = EmrLogDetails::find($fio2_value->log_id);
                $fio2->is_calulated = true;
                $fio2->save();

                $predoctal_sao2 = EmrLogDetails::find($predoctal_sao2_value->log_id);
                $predoctal_sao2->is_calulated = true;
                $predoctal_sao2->save();


            }
             FhirFormatedValues::where('id',$value->id)->update(['is_calculated'=>'true']);
        }
        return \Response::json(['type'=>'success','message'=>'Record confirmed successfully'],200);

      }
     

}
