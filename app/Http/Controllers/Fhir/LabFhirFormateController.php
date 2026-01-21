<?php
namespace App\Http\Controllers\Fhir;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Machine\MachineData;
use App\Models\Fhir\FhirFormatedValues;
use App\Models\Fhir\FhirJsonSchema;
use App\Models\Settings\Settings;
use App\Http\Controllers\Fhir\ImportFhirController;
use App\Http\Controllers\Fhir\FhirFormateController;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Models\Nurse\ImportFhir;
use App\Models\Mother;
use Carbon\Carbon;
use App\Models\Baby;
use App\Models\Admission;

use App\Models\Nurse\NurseIvInfusion;
use App\Models\Nurse\NurseOtherIvDrugs;
use App\Models\Nurse\NurseOtherIvInfusion;
use App\Models\Nurse\NurseGlucoseIntake;
use App\Models\Nurse\NurseOralDrugs;
use App\Models\Ward\BedLog;
use App\Models\IpNumber;
use App\Models\Nurse\NurseSheetMain;
use App\Models\Nurse\EmrLogHeader;
use App\Models\lab\LabRequest;
use GuzzleHttp\Exception;
use Excel;
use App\Http\Controllers\Nurse\DialpadSupportProperty;
use App\Models\DischargeLog;
use App\Models\Nurse\DayWisePatientBedLog;
use App\Http\Controllers\Reports\NsofaController;

class LabFhirFormateController extends Controller
{
    /**
     * This for machine data instance
     *@var $machine_data
     */
    public $machine_data;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Settings $site_settings)
    {
        // $this->machine_data = new MachineData();
        $this->site_settings       = $site_settings;  
        $this->time_zone           = env('TIME_ZONE');
        $this->custom_error = new ErrorLogController();
        $this->lab_user = 4;
        $this->nsofaController = new NsofaController();
        $this->platelet_local_code = 245;
    }

    /**
     * This method to get formate
     *
     * @param  $input type array
     *
     * @return type bool
     */
    public function getlabformatfhir()
    {
        $lab_request_list = ImportFhir::getLabRequestList();
        $table_name = 'emr_lab_values';
        $lab_request_url = \SiteHelpers::getConfigSettings('GET_LIS_LAB_RESULT');
        $lab_package_url = \SiteHelpers::getConfigSettings('GET_LIS_PACKAGE_LIST');
        
        $update_request = $non_exist_snomed_codes = array();
        $blood_gas_values = ['interface_blood_gas_ph', 'interface_blood_gas_pao2',' interface_blood_gas_paco2', 'interface_blood_gas_hco3', 'interface_blood_gas_be',' interface_blood_gas_na', 'interface_blood_gas_k', 'interface_blood_gas_cl',' interface_blood_gas_hb', 'interface_blood_gas_pcv', 'interface_blood_gas_lactate', 'interface_blood_gas_bilirubin', 'interface_blood_gas_blood_sugar',' interface_blood_gas_methemoglobin',' interface_blood_calcium'];

        
        if (count($lab_request_list) > 0) {
            foreach ($lab_request_list as $lab_req_key => $lab_req_value) {
                $data_array = $resource_data1 = array();
                // if (!is_null($lab_req_value->investigations) && !is_null($lab_req_value->request_id)) {
                    $patient_details = array();
                    $ip_number_obj = IpNumber::getCurrent_ip($lab_req_value->baby_id);
                    if (isset($ip_number_obj->ip_number) && !empty($ip_number_obj->ip_number)) {
                        $ip_number = $ip_number_obj->ip_number;
                        if (substr($ip_number, 0, 3) !== 'IP/') {
                            $this->custom_error->emergencyLog('Error on getting results for IP number :'.$ip_number.' Baby ID : '.$lab_req_value->baby_id);
                            continue;
                        }
                        $client = new \GuzzleHttp\Client();
                        $response = $client->request('GET', $lab_request_url.$ip_number, ['http_errors' => false]);
                        // $response = $client->request('GET', 'http://172.17.1.33:8909/getItem?visitnumber='.$ip_number, ['http_errors' => false]);
                        $status_code = $response->getStatusCode();
                        if ($status_code != 200) {
                            $this->custom_error->emergencyLog('HTTP ERROR for IP number :'.$ip_number.' Baby ID : '.$lab_req_value->baby_id);
                            continue;
                        }
                        $lab_result = $response->getBody();
                        $lab_result = $lab_result->getContents();
                        $auth = false;

                        if ($lab_result == 'No Patient Found') {
                            $this->custom_error->emergencyLog('NO patient found in LIS for IP number :'.$ip_number.' Baby ID : '.$lab_req_value->baby_id);
                            continue;
                        }
                        if ($lab_result == 'No Lab Result Found') {
                            $this->custom_error->emergencyLog('NO LAB result found in LIS for IP number :'.$ip_number.' Baby ID : '.$lab_req_value->baby_id);
                            continue;
                        }
                        $machine_entry = (array)json_decode($lab_result);
                        if (!isset($machine_entry['entry']) && empty($machine_entry))
                        {
                            $this->custom_error->emergencyLog('Invalid response error for IP number :'.$ip_number.' Baby ID : '.$lab_req_value->baby_id);
                            continue;
                        }
                        $machine_entry = $machine_entry['entry'];
                        foreach ($machine_entry as $machine_entry_key => $machine_entry_value)
                        {
                            if (isset($machine_entry_value->resource->resourceType) && $machine_entry_value->resource->resourceType == 'AuditEvent')
                            {
                                if (isset($machine_entry_value->resource->object))
                                {
                                    foreach ($machine_entry_value->resource->object as $resource_key => $resource_value)
                                    {
                                        if (isset($resource_value->securityLabel))
                                        {
                                            $securityLabel = collect($resource_value->securityLabel);
                                            $api_key = $securityLabel->where('code', 'api_key')->first();
                                            $user_name = $securityLabel->where('code', 'user_name')->first();
                                            $user_password = $securityLabel->where('code', 'user_password')->first();

                                            if (isset($api_key->display) && isset($user_name->display) && isset($user_password->display))
                                            {

                                                $input['api_key'] = $api_key->display;
                                                $input['user_password'] = $user_password->display;
                                                $input['user_name'] = $user_name->display;
                                                $auth        = $this->getCheckAuth($input);
                                                // $auth = true;

                                            }
                                            else
                                            {
                                                $this->custom_error->emergencyLog('Invalid JSON format for IP number :'.$ip_number.' Baby ID : '.$lab_req_value->baby_id);
                                                // return \Response::json(['status' => 'failure', 'message' => 'Invalid json formate !'], 422);
                                            }
                                        } 
                                    }
                                }

                            }
                            if (!$auth)
                            {
                                // $this->custom_error->emergencyLog('Invalid api key or credentials for IP number :'.$ip_number.' Baby ID : '.$lab_req_value->baby_id);
                                // return \Response::json(['status' => 'failure', 'message' => 'Invalid api key or credentials !'], 401);
                            }
                                
                            if ($machine_entry_value->resource->resourceType == 'Patient')
                            {
                                $resource_data['Patient'] = $this->patientFormat($machine_entry_value->resource);
                            }

                            if ($machine_entry_value->resource->resourceType == 'Location')
                            {
                                $resource_data['Location'] = $this->locationFormat($machine_entry_value->resource);
                            }
                        
                            if ($machine_entry_value->resource->resourceType == 'Observation' && isset($machine_entry_value->resource->valueCodeableConcept))
                            {

                                $resource_data['Observation'] = $this->getObservationInterpretation($machine_entry_value->resource);
                                $resource_data1 = collect($resource_data)->collapse()->toArray();
                            }

                            if ($machine_entry_value->resource->resourceType == 'Observation' && !isset($machine_entry_value->resource
                                ->valueCodeableConcept))
                            {

                                $resource_data['Observation'] = $this->observationFormat($machine_entry_value->resource);
                                $resource_data1 = collect($resource_data)->collapse()->toArray();
                            }
                            if (isset($resource_data1) && !empty($resource_data1)) {
                                $data_array[] = $resource_data1;
                            }

                        }

                        $lab_results = $data_array;
                        // $this->custom_error->emergencyLog('Lab results this baby===== :'.json_encode($lab_results));
                        $insert_lab_data = $update_lab_data = array();
                        // $lab_result_package_list = collect($lab_results)->pluck('display', 'test_id')->toArray();
                        
                        // $order_investigations = $lab_req_value->investigations;
                        // $order_investigations = str_replace(['"', '[', ']'], '', $order_investigations);
                        // $order_investigations = explode(',', $order_investigations);

                        // $actual_pakcage_list = array();
                        // foreach ($order_investigations as $inves_key => $inves_value) {
                        //     $package_client = new \GuzzleHttp\Client();
                        //     $package_response = $package_client->request('GET', $lab_package_url.$inves_value);
                        //     $package_result = $package_response->getBody();
                        //     $package_result = $package_result->getContents();
                        //     $package_result = json_decode($package_result);
                        //     $current_inves_package_list = collect($package_result)->pluck('id')->toArray();
                        //     $actual_pakcage_list = array_merge($actual_pakcage_list, $current_inves_package_list);
                        // }
                        
                        if (isset($lab_results) && !empty($lab_results)) 
                        {
                            $machine_values_value = (object) collect($lab_results)->first();
                            $baby_details = ImportFhir::get_baby_details($machine_values_value->mrn);
                            if (count($baby_details) == 0) {
                                $this->custom_error->emergencyLog('ERROR for IP number :'.$ip_number.' machine Details : '.$lab_req_value->baby_id);
                                continue;
                            }
                            $babyId = $baby_details->BabyId;

                            $baby_admission = ImportFhir::get_baby_admission($babyId, $machine_values_value->ip_number);
                            if (!isset($baby_admission->AdmissionId) || empty($baby_admission->AdmissionId)) {
                                $this->custom_error->emergencyLog('Error on finding admission id for BabyId:'.$baby_details->BabyId.' IP number====='.$machine_values_value->ip_number);
                                continue;
                            }
                            
                            $admissionid = $baby_admission->AdmissionId;

                            foreach ($lab_results as $lab_key => $lab_value) {

                                $lab_value = (object) $lab_value;
                                // $this->custom_error->emergencyLog('Checking Patient details ===== Requested patient UHID is ===='.$lab_req_value->BMrNo.' and received patinet UHID === '.$lab_value->mrn.', Requested patient visit number is ==='.$ip_number.' and received patient visit number is '.$lab_value->ip_number);
                                
                                if ($lab_value->mrn == $lab_req_value->BMrNo && $lab_value->ip_number == $ip_number) {
                                    
                                    $nurse_date = date('Y-m-d', strtotime($lab_value->sheet_date));
                                    $nurse_time = date('Y-m-d H:i:s', strtotime($lab_value->sheet_date));
                                    
                                    /*Check Nurse main sheet*/
                                    $day_sheet_id = ImportFhir::get_nurse_sheet_check($nurse_date, $baby_details->BabyId, $admissionid);

                                    if (count($day_sheet_id) == 0)
                                    {
                                        $day_sheet_id = $this->createmainday($baby_details->BabyId, $admissionid, $nurse_date);
                                    }
                                    else
                                    {
                                        $day_sheet_id = $day_sheet_id->id;
                                    }
                                    
                                    $time_issued = $lab_value->sheet_date;
                                    /*Check EMR header*/
                                    $emr_log_header = ImportFhir::get_emr_header_checks($nurse_date, $babyId, $admissionid, $nurse_time);
                                    if (count($emr_log_header) == 0)
                                    {
                                        $header_id = $this->createsheetheader($baby_details->BabyId, $admissionid, $baby_details, $time_issued, $day_sheet_id);
                                    }
                                    else
                                    {
                                        $header_id = $emr_log_header->id;
                                    }

                                    // $this->custom_error->emergencyLog('sheet log: nurse-date-' . $nurse_date . ' baby-id-' . $babyId . ' admission-id-' . $admissionid . ' nurse-time-' . $nurse_time);
                                    $time_issued = $lab_value->sheet_date;
                                    $nurse_time = date('Y-m-d H:i:s', strtotime($time_issued));
                                    
                                    // FOR UPDATE THE REQUEST IS COMPLETED
                                    // if (in_array($lab_value->test_id, $actual_pakcage_list) && $lab_value->result_status == 'final') {
                                    //     // unset($lab_result_package_list[$lab_value->test_id]);
                                    //     if (($test_key = array_search($lab_value->test_id, $actual_pakcage_list)) !== false) {
                                    //         unset($actual_pakcage_list[$test_key]);
                                    //     }
                                    // }

                                    
                                    $get_local_code = ImportFhir::get_nurse_snomed_details($lab_value->snomed_code)->first();

                                    if (count($get_local_code) == 0)
                                    {
                                        // $non_exist_snomed_codes[$lab_value->snomed_code] = $lab_value->display;
                                        $this->custom_error->emergencyLog('The snomed code is not found in table code :' . $lab_value->snomed_code);
                                    }
                                    else
                                    {
                                        $check_lab_value_data = ImportFhir::get_lab_values($header_id, $get_local_code->ref_loc_master_id);
                                        if (count($check_lab_value_data) == 0) {
                                            /*INSERT PART*/
                                            $insert = array();
                                            $insert['log_hdr_id'] = $header_id;
                                            $insert['result_date_time'] = $lab_value->sheet_date;
                                            $insert['loinc_local_map_id'] = $get_local_code->ref_loc_master_id;
                                            $insert['mean'] = $lab_value->mean;
                                            $insert['intf_ref_value'] = $lab_value->mean;
                                            $insert['original_intf_ref_value'] = $lab_value->mean;
                                            $insert['lab_number'] = $lab_value->lab_number;
                                            $insert['material_name'] = $lab_value->material_name;
                                            $insert['lab_sample_number'] = $lab_value->lab_sample_number;
                                            /*For Blood Gas local code id */
                                            if ($get_local_code->ref_loc_master_id >= 297 && $get_local_code->ref_loc_master_id <= 311) {
                                                $insert["create_user_id"] = $this->lab_user;
                                                $insert["modify_user_id"] = $this->lab_user;
                                            }
                                            else
                                            {
                                                $insert["create_user_id"] = $this->lab_user;
                                                $insert["modify_user_id"] = $this->lab_user;
                                            }
                                            $insert["create_tstamp"] = Carbon::now($this->time_zone);
                                            $insert["modify_tstamp"] = Carbon::now($this->time_zone);
                                            $insert['range_low'] = (isset($lab_value->range_low)) ? $lab_value->range_low : null;
                                            $insert['range_high'] = (isset($lab_value->range_high)) ? $lab_value->range_high : null;
                                            $insert['value_quality_unitr'] = (isset($lab_value->value_quality_unit)) ? $lab_value->value_quality_unit : null;
                                            $insert['result_status'] = (isset($lab_value->result_status)) ? $lab_value->result_status : null;
                                            $insert_lab_data[] = $insert;
                                            $get_pilim_record = ImportFhir::getPilimReport($lab_value->lab_sample_number, $get_local_code->ref_loc_master_id);
                                            if(count($get_pilim_record) > 0 && !empty($get_pilim_record))
                                            {
                                                $update_lab_data = array_merge($get_pilim_record, $update_lab_data);
                                                $this->custom_error->emergencyLog('Preliminary result updated successfully for IP Number :'.$ip_number.' Baby ID : '.$lab_req_value->baby_id.' Lab Sample Number :'.$lab_value->lab_sample_number);
                                            }
                                        }
                                        
                                        /*Update Part*/
                                        else
                                        {
                                            if ($check_lab_value_data->result_status != 'final' || $lab_value->mean != $check_lab_value_data->mean) 
                                            {
                                                $this->updatelogdtl($lab_value, $check_lab_value_data->id, $header_id);
                                            }
                                            $get_pilim_record = ImportFhir::getPilimReport($lab_value->lab_sample_number, $get_local_code->ref_loc_master_id);
                                            if(count($get_pilim_record) > 0 && !empty($get_pilim_record))
                                            {
                                                $update_lab_data = array_merge($get_pilim_record, $update_lab_data);
                                                $this->custom_error->emergencyLog('Preliminary result updated successfully for IP Number :'.$ip_number.' Baby ID : '.$lab_req_value->baby_id.' Lab Sample Number :'.$lab_value->lab_sample_number);
                                            }
                                        }
                                    }
                                }
                                else
                                {
                                    $this->custom_error->emergencyLog('ERROR: Patient details not matched, Requested patient UHID is ===='.$lab_req_value->BMrNo.' and received patinet UHID === '.$lab_value->mrn.', Requested patient visit number is ==='.$ip_number.' and received patient visit number is '.$lab_value->ip_number);
                                }
                            }
                            
                            if (count($insert_lab_data) > 0) {
                                // $insert_lab_data = collect($insert_lab_data)->unique('loinc_local_map_id')->toArray();
                                \DB::table('emr_lab_values')->insert($insert_lab_data);
                            }
                            if (count($update_lab_data) > 0) {
                                \DB::table('emr_lab_values')->whereIn('id', $update_lab_data)->update(['is_display' => false]);
                            }
                            $this->custom_error->emergencyLog('Lab value updated successfully for IP Number :'.$ip_number.' Baby ID : '.$lab_req_value->baby_id.' Lab Sample Number :'.$lab_value->lab_sample_number);

                            // if (count($actual_pakcage_list) == 0) {
                            //     array_push($update_request, $lab_req_value->id);
                            // }
                        }
                        else
                        {
                            $this->custom_error->emergencyLog('No result yet for IP Number :'.$ip_number.' Baby ID : '.$lab_req_value->baby_id .' Request ID :'.$lab_req_value->request_id);
                        }
                    }
                    else
                    {
                        $this->custom_error->emergencyLog('Error = IP number is empty for Baby ID : '.$lab_req_value->baby_id);
                        continue;
                    }
                // }
            }
            if (count($update_request) != 0) {
                // \DB::table('lab_request')->whereIn('id', $update_request)->update(['is_processed' => true]);
            }
            // $this->custom_error->emergencyLog('NON EXIST SNOMED CODES ARE :'.json_encode($non_exist_snomed_codes));
        }
        
    }
    /**
     * This method to get formate
     *
     * @param  $patient_details type array
     *
     * @return type array
     */
    public function patientFormat($patient_details)
    {

        $patient = array();

        if (isset($patient_details->name))
        {
            $temp_name = '';
            foreach ($patient_details->name as $name_key => $name_value)
            {

                $temp_given = isset($name_value->given) ? $temp_name . ' ' . implode(' ', $name_value->given) : '';
                $temp_family = isset($name_value->family) ? $temp_name . ' ' . implode(' ', $name_value->family) : '';
                $temp_suffix = isset($name_value->suffix) ? $temp_name . ' ' . implode(' ', $name_value->suffix) : '';
                $patient['name'] = $temp_given . ' ' . $temp_family;
                $patient['name'] = trim($patient['name']);

            }
        }

        if (isset($patient_details->gender))
        {

            $patient['gender'] = null;
            if (trim($patient_details->gender) == 'M')
            {
                $patient['gender'] = 'Male';
            }
            elseif (trim($patient_details->gender) == 'F')
            {
                $patient['gender'] = 'Female';
            }

        }

        $pattern = $this->patternFormate('date');
        if (isset($patient_details->birthDate) && preg_match($pattern, $patient_details->birthDate))
        {
            $patient['birthdate'] = trim($patient_details->birthDate);

        }

        if (isset($patient_details->identifier))
        {
            foreach ($patient_details->identifier as $identifier_key => $identifier_value)
            {
                $patient['mrn'] = $identifier_value->value;
            }
        }
        return $patient;
    }

    public function locationFormat($location_details)
    {
        $location = array();
        if (isset($location_details->identifier))
        {
            foreach ($location_details->identifier as $identifier_key => $identifier_value)
            {

                if ($identifier_value->system == 'VisitType')
                {
                    $location['visit_type'] = $identifier_value->value;
                }

                if ($identifier_value->system == 'Date')
                {
                    $location['date'] = $identifier_value->value;
                    $location['start_time'] = $identifier_value->value;
                    $location['issued'] = $identifier_value->value;

                }

                if ($identifier_value->system == 'Visit Number')
                {
                    $location['ip_number'] = $identifier_value->value;
                }

                if ($identifier_value->system == 'Ward')
                {
                    $location['ward'] = $identifier_value->value;
                }

                if ($identifier_value->system == 'Room')
                {
                    $location['room'] = $identifier_value->value;
                }

                if ($identifier_value->system == 'Bed')
                {
                    $location['bed'] = $identifier_value->value;
                }
                if ($identifier_value->system == 'Number')
                {
                    $location['ip_number'] = $identifier_value->value;
                }
            }

            return $location;

        }
        return array();
    }
    public function observationFormat($observation_detials)
    {
        //loinc code system start
        $temp_code = $observation_detials->code->coding[0];
        $observation['snomed_code'] = isset($temp_code->code) ? $temp_code->code : 'unknown';
        $observation['loinc_code'] = isset($temp_code->code) ? $temp_code->code : 'unknown';
        $observation['display'] = isset($temp_code->display) ? $temp_code->display : 'unknown';
        $observation['result_status'] = isset($observation_detials->status) ? $observation_detials->status : '';
        // $observation['sheet_date'] = isset($observation_detials->identifier[0]->value) ? date('y-m-d H:i:s', strtotime($observation_detials->identifier[0]->value)) : '';
        // $observation['issued'] = isset($observation_detials->issued) ? date('Y-m-d H:i:s', strtotime($observation_detials->issued)) : '';
        if (isset($observation_detials->issued)) {
            $date_time = date('Y-m-d H:i:s', strtotime($observation_detials->issued));
            $date_issued  = Carbon::parse($date_time, $this->time_zone);
            $observation['issued'] = $date_issued;
            // $observation['issued'] = date('Y-m-d H:i:s', strtotime($observation_detials->issued));
            // $observation['issued']->settime_zone($this->time_zone);
        }
        unset($temp_code);

        $temp_identifer = $observation_detials->identifier;
        foreach ($temp_identifer as $temp_identifer_key => $temp_identifer_value)
        {
            if ($temp_identifer_value->system == 'createTime')
            {
                $observation['sheet_date'] = date('Y-m-d H:i:s', strtotime($temp_identifer_value->value));
            }
            if ($temp_identifer_value->system == 'labNumber')
            {
                $observation['lab_number'] = $temp_identifer_value->value;
            }

            if ($temp_identifer_value->system == 'labSampleNumber')
            {
                $observation['lab_sample_number'] = $temp_identifer_value->value;
            }
            if ($temp_identifer_value->system == 'materialName')
            {
                $observation['material_name'] = $temp_identifer_value->value;
            }
            if ($temp_identifer_value->system == 'requestId')
            {
                $observation['request_id'] = $temp_identifer_value->value;
            }
            if ($temp_identifer_value->system == 'testId')
            {
                $observation['test_id'] = $temp_identifer_value->value;
            }
            if ($temp_identifer_value->system == 'requestCreatedTime' && $temp_identifer_value->value != 'null')
            {
                $observation['sheet_date'] = date('Y-m-d H:i:s', strtotime($temp_identifer_value->value));
            }
        }
        unset($temp_identifer);

        //lab sample number system end
        //value start
        $temp_value_quantity = isset($observation_detials->valueQuantity) ? $observation_detials->valueQuantity : null;
        $observation['mean'] = isset($temp_value_quantity->value) ? $temp_value_quantity->value : null;
        $observation['value_quality_unit'] = isset($temp_value_quantity->unit) ? $temp_value_quantity->unit : null;
        unset($temp_value_quantity);
        //value end
        //reference range start
        $temp_reference_range = isset($observation_detials->referenceRange[0]) ? $observation_detials->referenceRange[0] : null;
        $observation['range_low'] = isset($temp_reference_range->low->value) ? $temp_reference_range->low->value : null;
        $observation['range_high'] = isset($temp_reference_range->high->value) ? $temp_reference_range->high->value : null;
        unset($temp_reference_range);

        //reference range end
        return $observation;

    }

    public function getObservationInterpretation($observation_details)
    {
        //loinc code system start
        $temp_code = $observation_details->code->coding[0];
        $observation['snomed_code'] = isset($temp_code->code) ? $temp_code->code : 'unknown';
        $observation['loinc_code'] = isset($temp_code->code) ? $temp_code->code : 'unknown';
        $observation['display'] = isset($temp_code->display) ? $temp_code->display : 'unknown';
        $observation['result_status'] = isset($observation_details->status) ? $observation_details->status : '';
        unset($temp_code);
        // $observation['sheet_date'] = isset($observation_details->identifier[0]->value) ? date('y-m-d H:i:s', strtotime($observation_details->identifier[0]->value)) : '';

        if (isset($observation_details->issued)) {
            $date_time = date('Y-m-d H:i:s', strtotime($observation_details->issued));
            $date_issued  = Carbon::parse($date_time, $this->time_zone);
            $observation['issued'] = $date_issued;
        }
        //loinc code system end
        //lab sample number system start
        $temp_identifer = $observation_details->identifier;
        foreach ($temp_identifer as $temp_identifer_key => $temp_identifer_value)
        {
            if ($temp_identifer_value->system == 'createTime')
            {
                $observation['sheet_date'] = date('Y-m-d H:i:s', strtotime($temp_identifer_value->value));
            }
            if ($temp_identifer_value->system == 'labNumber')
            {
                $observation['lab_number'] = $temp_identifer_value->value;
            }

            if ($temp_identifer_value->system == 'labSampleNumber')
            {
                $observation['lab_sample_number'] = $temp_identifer_value->value;
            }
            if ($temp_identifer_value->system == 'materialName')
            {
                $observation['material_name'] = $temp_identifer_value->value;
            }
            if ($temp_identifer_value->system == 'requestId')
            {
                $observation['request_id'] = $temp_identifer_value->value;
            }
            if ($temp_identifer_value->system == 'testId')
            {
                $observation['test_id'] = $temp_identifer_value->value;
            }
            if ($temp_identifer_value->system == 'requestCreatedTime'  && $temp_identifer_value->value != 'null')
            {
                $observation['sheet_date'] = date('Y-m-d H:i:s', strtotime($temp_identifer_value->value));
            }
        }
        unset($temp_identifer);

        $temp_values = $observation_details->valueCodeableConcept->coding[0];
        $observation['mean'] = $temp_values->system;
        return $observation;

    }

    public function patternFormate($patternType)
    {
        $fhir_date = FhirJsonSchema::get_resource_schema($patternType);
        $pattern = '/' . $fhir_date->pattern . '/';
        $pattern = str_replace('#', '$', $pattern);
        return $pattern;

    }

    /**
     * This method to get check the credentials
     *
     * @param  $input type array
     *
     * @return type bool
     */
    private function getCheckAuth($input)
    {
        $input['api_key'] = \SiteHelpers::decrypt_id($input['api_key']);
        $input['user_password'] = \SiteHelpers::decrypt_id($input['user_password']);

        $settings = $this->site_settings->find(1);
        $api_key = \SiteHelpers::decrypt_id($settings->api_key);
        $user_name = $settings->api_user_name;
        $user_password = \SiteHelpers::decrypt_id($settings->api_password);

        if (($input['api_key'] == $api_key) && ($input['user_name'] == $user_name) && ($input['user_password'] == $user_password))
        {
            return true;
        }
        else
        {
            return false;
        }

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
     *
     * @param $table_name type string
     *
     * @param $model type string
     *
     * @param $asset_number type string
     *
     * @param $fhir_calculated_values type array
     */
    public function createlogdtl($emr_log_header_id, $result, $nurse_time, $value, $table_name, $model='', $asset_number='', $fhir_calculated_values = array())
    {
        $result = collect($result)->toArray();
        $sub_sheet_values["log_hdr_id"] = $emr_log_header_id;
        $sub_sheet_values["loinc_local_map_id"] = $result['ref_loc_master_id'];
        $sub_sheet_values["intf_ref_value"] = $value;
        $sub_sheet_values["original_intf_ref_value"] = $value;
        $sub_sheet_values["property"] = $result['property'];
        $sub_sheet_values["result_date_time"] = $nurse_time;
        $sub_sheet_values["scale"] = $result["scale_typ"];
        $sub_sheet_values["method"] = $result["method_typ"];
        $sub_sheet_values["low"] = $fhir_calculated_values["low"];
        $sub_sheet_values["last_quartile"] = $fhir_calculated_values["last_quartile"];
        $sub_sheet_values["first_quartile"] = $fhir_calculated_values["first_quartile"];
        $sub_sheet_values["mean"] = $fhir_calculated_values["mean"];
        $sub_sheet_values["device_model"] = $model;
        $sub_sheet_values["device_id"] = $asset_number;
        $sub_sheet_values["create_user_id"] = $this->lab_user;
        $sub_sheet_values["create_tstamp"] = Carbon::now($this->time_zone);
        $sub_sheet_values["modify_user_id"] = $this->lab_user;
        $sub_sheet_values["modify_tstamp"] = Carbon::now($this->time_zone);
        \DB::table($table_name)->insert($sub_sheet_values);
        if ($emr_log_header_id == $this->platelet_local_code) {
            $this->nsofaController->calculateAndStoreNsofaScoreHourly($emr_log_header_id, null, null, null, null, $fhir_calculated_values["mean"], null);
        }
        return true;

    }

    /**
     * This method to update value log
     * with time
     *
     * @param $id type integer
     *
     * @param $lab_value type array
     */
    public function updatelogdtl($lab_value, $id, $header_id)
    {
        $fhir_calculated_values['intf_ref_value'] = $lab_value->mean;
        $fhir_calculated_values['original_intf_ref_value'] = $lab_value->mean;
        $fhir_calculated_values['range_high'] = (isset($lab_value->range_high)) ? $lab_value->range_high : null;
        $fhir_calculated_values['range_low'] = (isset($lab_value->range_low)) ? $lab_value->range_low : null;
        $fhir_calculated_values['result_status'] = (isset($lab_value->result_status)) ? $lab_value->result_status : null;
        $fhir_calculated_values['modify_tstamp'] = Carbon::now($this->time_zone);
        $fhir_calculated_values['material_name'] = (isset($lab_value->material_name)) ? $lab_value->material_name : null;
        $fhir_calculated_values['is_display'] = true;
        $log_emr_details_count = \DB::table('emr_lab_values')->where('id', $id)->update($fhir_calculated_values);
        if ($header_id == $this->platelet_local_code) {
            $this->nsofaController->calculateAndStoreNsofaScoreHourly($header_id, null, null, null, null, $lab_value->mean, null);
        }
        return true;
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

        $main_sheet['sender'] = env('APP_NAME');
        $main_sheet['gender'] = $baby_details->Sex;
        $main_sheet['sender_time'] = date('Y-m-d H:i:s', strtotime($time_issued));
        $main_sheet['visit_date'] = date('Y-m-d H:i:s', strtotime($time_issued));
        $main_sheet['loinc_version'] = 2.63;
        $main_sheet['active_flag'] = 'Y';
        $main_sheet['create_user_id'] = $this->lab_user;
        $main_sheet['create_tstamp'] = date('Y-m-d H:i:s', time());
        $main_sheet['modify_user_id'] = $this->lab_user;
        $main_sheet['modify_tstamp'] = date('Y-m-d H:i:s', time());
        $main_sheet['day_id'] = isset($day_sheet_id) ? $day_sheet_id : null;
        $main_sheet['baby_id'] = isset($babyid) ? $babyid : null;
        $main_sheet['mother_id'] = isset($baby_details->MotherId) ? $baby_details->MotherId : null;
        $main_sheet['admission_id'] = isset($admissionid) ? $admissionid : null;
        $main_sheet['added_nurse'] = null;
        $emr_log_head_id = EmrLogHeader::create($main_sheet)->id;
        return $emr_log_head_id;

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

        $sheet_id = FhirFormateController::createmainday($babyid, $admissionid, $nurse_date, $nurse_date, true);

        return $sheet_id;

        // $dayCount = count(ImportFhir::get_nurse_sheet_count($babyid, $admissionid));

        // $sheet_details['day_name'] = 'Day ' . ($dayCount + 1);
        // $sheet_details['sheet_date'] = date('Y-m-d', strtotime($nurse_date));
        // $sheet_details['baby_id'] = $babyid;
        // $sheet_details['admission_id'] = $admissionid;
        // $sheet_details['lab_flag'] = 1;
        // $sheet_id = NurseSheetMain::create($sheet_details)->id;

        // $this->dayWiseBedLog($sheet_id, $babyid, $admissionid);
        // return $sheet_id;

    }

    public static function dayWiseBedLog($sheet_id, $babyid, $admissionid)
    {
        $bed_details = BedLog::getBedDeatails($babyid, $admissionid);
        
        $old_bed_details = DayWisePatientBedLog::where('day_id', $sheet_id)->orderBy('id', 'desc')->first();

        if (isset($bed_details->bed_id)) {

            if ((isset($old_bed_details->bed_id) && ($old_bed_details->bed_id != $bed_details->bed_id)) || !isset($old_bed_details->bed_id)) {

                $patient_log['day_id'] = $sheet_id;
                $patient_log['bed_id'] = isset($bed_details->bed_id) ? $bed_details->bed_id : 0;
                $patient_log['created_date_time'] = Carbon::now();
                $patient_log['created_by'] = 0;

                DayWisePatientBedLog::create($patient_log);

            } else {

                $patient_log['modified_date_time'] = Carbon::now();
                $patient_log['modified_by'] = 0;

                $old_bed_details->update($patient_log);

            }

        }
    }

    /**
     * This method to get formate
     *
     * @param  $input type array
     *
     * @return type bool
     */
    public function getSingleLabReport(Request $request)
    {        
        $input = $request->all();

        $baby_id = $input['baby_id'];
        $closewinlink = $input['closewinlink'];
        $lab_request_url = \SiteHelpers::getConfigSettings('GET_LIS_LAB_RESULT');

        $data_array = $resource_data1 = array();
        $patient_details = array();
        $ip_number_obj = IpNumber::get_all_ip($baby_id);

        foreach ($ip_number_obj as $key => $value) {

            if (isset($value->ip_number) && !empty($value->ip_number)) {
                $ip_number = $value->ip_number;
                if (substr($ip_number, 0, 3) !== 'IP/') {
                    $this->custom_error->emergencyLog('Error on getting results for IP number :'.$ip_number.' Baby ID : '.$baby_id);
                    // return \Response::json(['type' => 'error', 'message' => 'Error on getting results']);
                }
                $client = new \GuzzleHttp\Client();
                $response = $client->request('GET', $lab_request_url.$ip_number, ['http_errors' => false]);
                $status_code = $response->getStatusCode();
                if ($status_code != 200) {
                    $this->custom_error->emergencyLog('HTTP ERROR for IP number :'.$ip_number.' Baby ID : '.$baby_id);
                    // return \Response::json(['type' => 'error', 'message' => 'HTTP ERROR']);
                }
                $lab_result = $response->getBody();
                $lab_result = $lab_result->getContents();
                $auth = false;

                if ($lab_result == 'No Patient Found') {
                    $this->custom_error->emergencyLog('NO patient found in LIS for IP number :'.$ip_number.' Baby ID : '.$baby_id);
                    // return \Response::json(['type' => 'error', 'message' => 'NO patient found in LIS']);
                }
                if ($lab_result == 'No Lab Result Found') {
                    $this->custom_error->emergencyLog('NO LAB result found in LIS for IP number :'.$ip_number.' Baby ID : '.$baby_id);
                    // return \Response::json(['type' => 'error', 'message' => 'NO LAB result found in LIS']);
                }
                $machine_entry = (array)json_decode($lab_result);
                if (!isset($machine_entry['entry']) && empty($machine_entry))
                {
                    $this->custom_error->emergencyLog('Invalid response error for IP number :'.$ip_number.' Baby ID : '.$baby_id);
                    // return \Response::json(['type' => 'error', 'message' => 'Invalid response error for IP number']);
                }
                if (isset($machine_entry['entry'])) {
                    $machine_entry = $machine_entry['entry'];
                    foreach ($machine_entry as $machine_entry_key => $machine_entry_value)
                    {
                        if (isset($machine_entry_value->resource->resourceType) && $machine_entry_value->resource->resourceType == 'AuditEvent')
                        {
                            if (isset($machine_entry_value->resource->object))
                            {
                                foreach ($machine_entry_value->resource->object as $resource_key => $resource_value)
                                {
                                    if (isset($resource_value->securityLabel))
                                    {
                                        $securityLabel = collect($resource_value->securityLabel);
                                        $api_key = $securityLabel->where('code', 'api_key')->first();
                                        $user_name = $securityLabel->where('code', 'user_name')->first();
                                        $user_password = $securityLabel->where('code', 'user_password')->first();

                                        if (isset($api_key->display) && isset($user_name->display) && isset($user_password->display))
                                        {

                                            $input['api_key'] = $api_key->display;
                                            $input['user_password'] = $user_password->display;
                                            $input['user_name'] = $user_name->display;
                                            $auth        = $this->getCheckAuth($input);

                                        }
                                        else
                                        {
                                            $this->custom_error->emergencyLog('Invalid JSON format for IP number :'.$ip_number.' Baby ID : '.$baby_id);
                                            // return \Response::json(['type' => 'error', 'message' => 'Invalid JSON format']);
                                        }
                                    } 
                                }
                            }

                        }
                        if (!$auth)
                        {
                                        // $this->custom_error->emergencyLog('Invalid api key or credentials for IP number :'.$ip_number.' Baby ID : '.$baby_id);
                                        // return \Response::json(['status' => 'failure', 'message' => 'Invalid api key or credentials !'], 401);
                        }

                        if ($machine_entry_value->resource->resourceType == 'Patient')
                        {
                            $resource_data['Patient'] = $this->patientFormat($machine_entry_value->resource);
                        }

                        if ($machine_entry_value->resource->resourceType == 'Location')
                        {
                            $resource_data['Location'] = $this->locationFormat($machine_entry_value->resource);
                        }

                        if ($machine_entry_value->resource->resourceType == 'Observation' && isset($machine_entry_value->resource->valueCodeableConcept))
                        {

                            $resource_data['Observation'] = $this->getObservationInterpretation($machine_entry_value->resource);
                            $resource_data1 = collect($resource_data)->collapse()->toArray();
                        }

                        if ($machine_entry_value->resource->resourceType == 'Observation' && !isset($machine_entry_value->resource
                            ->valueCodeableConcept))
                        {

                            $resource_data['Observation'] = $this->observationFormat($machine_entry_value->resource);
                            $resource_data1 = collect($resource_data)->collapse()->toArray();
                        }
                        if (isset($resource_data1) && !empty($resource_data1)) {
                            $data_array[] = $resource_data1;
                        }

                    }

                    $lab_results = $data_array;
                    $insert_lab_data = $update_lab_data = array();

                    if (isset($lab_results) && !empty($lab_results)) 
                    {
                        $machine_values_value = (object) collect($lab_results)->first();
                        $baby_details = ImportFhir::get_baby_details($machine_values_value->mrn);
                        if (count($baby_details) == 0) {
                            $this->custom_error->emergencyLog('ERROR for IP number :'.$ip_number.' machine Details : '.$baby_id);
                            // return \Response::json(['type' => 'error', 'message' => 'ERROR - Machine details']);
                        }
                        $babyId = $baby_details->BabyId;

                        $baby_admission = ImportFhir::get_all_baby_admission($babyId, $machine_values_value->ip_number);
                        $admissionid = $baby_admission->AdmissionId;

                        foreach ($lab_results as $lab_key => $lab_value) {
                            $lab_value = (object) $lab_value;
                            $nurse_date = date('Y-m-d', strtotime($lab_value->sheet_date));
                            $nurse_time = date('Y-m-d H:i:s', strtotime($lab_value->sheet_date));

                            /*Check Nurse main sheet*/
                            $day_sheet_id = ImportFhir::get_nurse_sheet_check($nurse_date, $baby_details->BabyId, $admissionid);

                            if (count($day_sheet_id) == 0)
                            {
                                $day_sheet_id = $this->createmainday($baby_details->BabyId, $admissionid, $nurse_date);
                            }
                            else
                            {
                                $day_sheet_id = $day_sheet_id->id;
                            }

                            $time_issued = $lab_value->sheet_date;
                            /*Check EMR header*/
                            $emr_log_header = ImportFhir::get_emr_header_checks($nurse_date, $babyId, $admissionid, $nurse_time);
                            if (count($emr_log_header) == 0)
                            {
                                $header_id = $this->createsheetheader($baby_details->BabyId, $admissionid, $baby_details, $time_issued, $day_sheet_id);
                            }
                            else
                            {
                                $header_id = $emr_log_header->id;
                            }

                            $this->custom_error->emergencyLog('sheet log: nurse-date-' . $nurse_date . ' baby-id-' . $babyId . ' admission-id-' . $admissionid . ' nurse-time-' . $nurse_time);
                            $time_issued = $lab_value->sheet_date;
                            $nurse_time = date('Y-m-d H:i:s', strtotime($time_issued));

                            $get_local_code = ImportFhir::get_nurse_snomed_details($lab_value->snomed_code)->first();

                            if (count($get_local_code) == 0)
                            {
                                $this->custom_error->emergencyLog('The snomed code is not found in table code :' . $lab_value->snomed_code);
                            }
                            else
                            {
                                $check_lab_value_data = ImportFhir::get_lab_values($header_id, $get_local_code->ref_loc_master_id);
                                if (count($check_lab_value_data) == 0) {
                                    /*INSERT PART*/
                                    $insert = array();
                                    $insert['log_hdr_id'] = $header_id;
                                    $insert['result_date_time'] = $lab_value->sheet_date;
                                    $insert['loinc_local_map_id'] = $get_local_code->ref_loc_master_id;
                                    $insert['mean'] = $lab_value->mean;
                                    $insert['intf_ref_value'] = $lab_value->mean;
                                    $insert['original_intf_ref_value'] = $lab_value->mean;
                                    $insert['lab_number'] = $lab_value->lab_number;
                                    $insert['material_name'] = $lab_value->material_name;
                                    $insert['lab_sample_number'] = $lab_value->lab_sample_number;
                                    /*For Blood Gas local code id */
                                    if ($get_local_code->ref_loc_master_id >= 297 && $get_local_code->ref_loc_master_id <= 311) {
                                        $insert["create_user_id"] = $this->lab_user;
                                        $insert["modify_user_id"] = $this->lab_user;
                                        $this->updateLabFlag($day_sheet_id);
                                    }
                                    else
                                    {
                                        $insert["create_user_id"] = $this->lab_user;
                                        $insert["modify_user_id"] = $this->lab_user;
                                    }
                                    $insert["create_tstamp"] = Carbon::now($this->time_zone);
                                    $insert["modify_tstamp"] = Carbon::now($this->time_zone);
                                    $insert['range_low'] = (isset($lab_value->range_low)) ? $lab_value->range_low : null;
                                    $insert['range_high'] = (isset($lab_value->range_high)) ? $lab_value->range_high : null;
                                    $insert['value_quality_unitr'] = (isset($lab_value->value_quality_unit)) ? $lab_value->value_quality_unit : null;
                                    $insert['result_status'] = (isset($lab_value->result_status)) ? $lab_value->result_status : null;
                                    $insert_lab_data[] = $insert;
                                    $get_pilim_record = ImportFhir::getPilimReport($lab_value->lab_sample_number, $get_local_code->ref_loc_master_id);
                                    if(count($get_pilim_record) > 0 && !empty($get_pilim_record))
                                    {
                                        $update_lab_data = array_merge($get_pilim_record, $update_lab_data);
                                        $this->custom_error->emergencyLog('Preliminary result updated successfully for IP Number :'.$ip_number.' Baby ID : '.$baby_id.' Lab Sample Number :'.$lab_value->lab_sample_number);
                                    }
                                }

                                /*Update Part*/
                                else
                                {
                                    // if ($check_lab_value_data->result_status != 'final' || $lab_value->mean != $check_lab_value_data->mean) 
                                    // {
                                    $this->updatelogdtl($lab_value, $check_lab_value_data->id, $header_id);
                                    // }
                                    $get_pilim_record = ImportFhir::getPilimReport($lab_value->lab_sample_number, $get_local_code->ref_loc_master_id);
                                    if(count($get_pilim_record) > 0 && !empty($get_pilim_record))
                                    {
                                        $update_lab_data = array_merge($get_pilim_record, $update_lab_data);
                                        $this->custom_error->emergencyLog('Preliminary result updated successfully for IP Number :'.$ip_number.' Baby ID : '.$baby_id.' Lab Sample Number :'.$lab_value->lab_sample_number);
                                    }
                                }
                            }
                        }

                        if (count($insert_lab_data) > 0) {
                            \DB::table('emr_lab_values')->insert($insert_lab_data);
                        }
                        if (count($update_lab_data) > 0) {
                            \DB::table('emr_lab_values')->whereIn('id', $update_lab_data)->update(['is_display' => false]);
                        }
                        $this->custom_error->emergencyLog('Lab value updated successfully for IP Number :'.$ip_number.' Baby ID : '.$baby_id.' Lab Sample Number :'.$lab_value->lab_sample_number);
                        

                    }
                    else
                    {
                        $this->custom_error->emergencyLog('No result yet for IP Number :'.$ip_number.' Baby ID : '.$baby_id .' Request ID :'.$lab_req_value->request_id);
                        // return \Response::json(['type' => 'error', 'message' => 'No result yet']);
                    }
                }
            }
            else
            {
                $this->custom_error->emergencyLog('Error = IP number is empty for Baby ID : '.$baby_id);
                // return \Response::json(['type' => 'error', 'message' => 'Error = IP number is empty']);
            }
            
        }
        return \Response::json(['type' => 'success', 'message' => 'Lab value updated successfully']);

    }

    public function updateLabFlag($day_id)
    {
        \DB::table('nurse_main_sheet')->where('id', $day_id)->update(['lab_flag'=>0]);
    }

    public function exportLabReport(Request $request) {
        $input = $request->all();
        $baby_mrn = $input['mrn'];
        $baby_name = $input['baby_name'];
        $order = 'result_date_time';

        $baby = Baby::get_baby_by_mrn($baby_mrn);
        $baby_id = $baby->BabyId;
        $mother_id = $baby->MotherId;

        $admission_ids = Admission::where('BabyId', $baby_id)->pluck('AdmissionId');

        $lab_data_table_name = 'emr_lab_values';

        $abg_test_list = DialpadSupportProperty::ABG_TEST_LIST;
        $lab_values_1 = [];
        $lab_values_2 = [];
        $lab_values_4 = [];

        foreach ($admission_ids as $admission_id) {
            $patient_status = DischargeLog::getDischargeDetail($baby_id, $admission_id);
            if (count($patient_status) > 0) {
                $lab_data_table_name = 'emr_lab_values_discharged';
            }

            $temp_lab_values_1 = EmrLogHeader::getLabValuePrint($baby_id, $mother_id, $order, $lab_data_table_name, ['haematology', 'biochemistry'])->toArray();
            $lab_values_1 = array_merge($lab_values_1, $temp_lab_values_1);

            $temp_lab_values_2 = EmrLogHeader::getLabValuePrint($baby_id, $mother_id, $order, $lab_data_table_name, ['urine', 'csf', 'stool'])->toArray();
            $lab_values_2 = array_merge($lab_values_2, $temp_lab_values_2);
            
            $temp_lab_values_4 = EmrLogHeader::getInterfacingData($baby_id, $admission_id, $abg_test_list, '', '', $lab_data_table_name, false)->toArray();
            $lab_values_4 = array_merge($lab_values_4, $temp_lab_values_4);
        }
        $lab_values_1 = collect($lab_values_1);
        $lab_values_2 = collect($lab_values_2);
        $lab_values_4 = collect($lab_values_4);

        $test_names_1 = EmrLogHeader::getLabParameters(['haematology', 'biochemistry'])->pluck('local_description', 'approval_parameter_priority');

        $results_1 = collect($lab_values_1)->groupBy(['approval_parameter_priority', 'lab_number'])->toArray();
        $date_list_1 = collect($lab_values_1)->pluck('temp_result_date_time', 'lab_number')->toArray();

        $temp_test_names_2 = EmrLogHeader::getLabParameters(['urine', 'csf', 'stool']);

        $urine_test = collect($temp_test_names_2)->where('lab_department', 'urine')->pluck('local_description', 'approval_parameter_priority')->toArray();
        $csf_test = collect($temp_test_names_2)->where('lab_department', 'csf')->pluck('local_description', 'approval_parameter_priority')->toArray();
        $stool_test = collect($temp_test_names_2)->where('lab_department', 'stool')->pluck('local_description', 'approval_parameter_priority')->toArray();

        $test_names_2 = array_merge($urine_test, $csf_test, $stool_test);

        $results_2 = collect($lab_values_2)->groupBy(['approval_parameter_priority', 'lab_number'])->toArray();
        $date_list_2 = collect($lab_values_2)->pluck('temp_result_date_time', 'lab_number')->toArray();

        $results_3 = \DB::table('emr_microbiology_report')
        ->where('specimen', '!=', '')->where('specimen', '!=', '*')
        ->whereIn('admission_id', $admission_ids)
        ->orderBy('test_name')
        ->get();
        
        $results_3 = $results_3->map(function($item) {
            $item->test_name = str_ireplace('final', '', $item->test_name);
            $item->test_name = str_ireplace('preliminary', '', $item->test_name);
            $item->test_name = str_replace('()', '', $item->test_name);
            $item->test_name = str_replace('BLOODCULTURE', 'BLOOD CULTURE', $item->test_name);
            $item->temp_result_collect_time = strtotime(date('Y-m-d H:i', strtotime($item->result_collect_time)));
            return $item;
        });

        $microbiology_results_id = $results_3->pluck('id')->toArray();

        $results_3 = $results_3->groupBy('test_name');
        
        $microbiology_results_items = \DB::table('emr_microbiology_report_items')
        ->whereIn('report_id', $microbiology_results_id)
        ->where('display_status', true)
        ->get();  
        
        $test_names_4 = \DB::table('local_code_group')->where('approval_parameter_priority', 'ilike', '%abg%')->orderBy('approval_parameter_priority', 'asc')->pluck('local_description', 'approval_parameter_priority');

        $results_4 = collect($lab_values_4)->groupBy(['approval_parameter_priority', 'temp_result_date_time'])->toArray();
        $date_list_4 = collect($lab_values_4)->pluck('temp_result_date_time')->unique()->toArray();

        $file_name = 'lab_report_' . $baby_mrn;
        $mrn = 'MRN: ' . $baby_mrn;
        $babyname = 'Baby Name : ' . $baby_name;

        Excel::create($file_name, function ($excel) use ($mrn, $babyname, $file_name, $results_1, $date_list_1, $test_names_1, $results_2, $date_list_2, $test_names_2, $results_3, $microbiology_results_items, $results_4, $date_list_4, $test_names_4) {
            $excel->sheet('Haematology and Biochemistry', function ($sheet1) use ($mrn, $babyname, $file_name, $results_1, $date_list_1, $test_names_1) {
                $sheet_name = 'tab1';
                $sheet1->loadView('nurse_sheet.lab_export', compact('mrn', 'babyname', 'results_1', 'file_name', 'date_list_1', 'test_names_1', 'sheet_name'));
            });
            $excel->sheet('Urine, CSF, Stool', function ($sheet2) use ($mrn, $babyname, $file_name, $results_2, $date_list_2, $test_names_2) {
                $sheet_name = 'tab2';
                $sheet2->loadView('nurse_sheet.lab_export', compact('mrn', 'babyname', 'results_2', 'file_name', 'date_list_2', 'test_names_2', 'sheet_name'));
            });
            $excel->sheet('Microbiology', function ($sheet3) use ($mrn, $babyname, $file_name, $results_3, $microbiology_results_items) {
                $sheet_name = 'tab3';
                $sheet3->loadView('nurse_sheet.lab_export', compact('mrn', 'babyname', 'file_name', 'results_3', 'sheet_name', 'microbiology_results_items'));
                $cell_width = ['A' => 25, 'B' => 25, 'C' => 50];
                $sheet3->setWidth($cell_width);
            });
            $excel->sheet('ABG', function ($sheet1) use ($mrn, $babyname, $file_name, $results_4, $date_list_4, $test_names_4) {
                $sheet_name = 'tab4';
                $sheet1->loadView('nurse_sheet.lab_export', compact('mrn', 'babyname', 'results_4', 'file_name', 'date_list_4', 'test_names_4', 'sheet_name'));
            });
            $excel->setActiveSheetIndex(0);
        })->export('xlsx');

    }

    public function exportLabReportLive(Request $request) {
        $input = $request->all();
        $mrn = $input['mrn'];   
        $baby = Baby::get_baby_by_mrn($mrn);
        $baby_id = isset($baby->BabyId) ? $baby->BabyId : '';

        $departments = ['haematology', 'biochemistry', 'urine', 'csf', 'stool'];
        
        $test_names = \DB::table('local_code_group')
        ->select('lis_test_id', 'local_description', 'approval_parameter_priority', 'lab_department')
        ->whereNotNull('approval_parameter_priority')
        ->whereIn('lab_department', $departments)
        ->whereNotNull('approval_parameter_priority')
        ->whereNotNull('lis_test_id')
        ->orderBy('approval_parameter_priority', 'asc')
        ->get();

        $get_lis_test_id = collect($test_names)->pluck('lis_test_id')->toArray();

        $description = collect($test_names)->pluck('local_description', 'lis_test_id')->toArray();
        $test_names_1 = collect($test_names)->whereIn('lab_department', ['haematology', 'biochemistry'])->pluck('lis_test_id', 'approval_parameter_priority')->toArray();
        // $test_names_2 = collect($test_names)->whereIn('lab_department', ['urine', 'csf', 'stool'])->pluck('lis_test_id', 'approval_parameter_priority')->toArray();
        
        $urine_test = collect($test_names)->where('lab_department', 'urine')->pluck('lis_test_id', 'approval_parameter_priority')->toArray();
        $csf_test = collect($test_names)->where('lab_department', 'csf')->pluck('lis_test_id', 'approval_parameter_priority')->toArray();
        $stool_test = collect($test_names)->where('lab_department', 'stool')->pluck('lis_test_id', 'approval_parameter_priority')->toArray();

        $test_names_2 = array_merge($urine_test, $csf_test, $stool_test);

        $client = new \GuzzleHttp\Client();
        
        $lab_report_url = \SiteHelpers::getConfigSettings('GET_LIS_LAB_RESULT_BY_MRN');
        
        $response = $client->request('GET', $lab_report_url.$mrn, ['http_errors' => false]);
        
        $status_code = $response->getStatusCode();
        if ($status_code != 200) {
            // $this->custom_error->emergencyLog('HTTP ERROR for IP number :'.$ip_number.' Baby ID : '.$lab_req_value->baby_id);
        }
        $lab_result = $response->getBody();
        $lab_result = $lab_result->getContents();
        $lab_values = collect(json_decode($lab_result));

        $date_list_1 = [];

        $results_1 = $lab_values->whereIn('testId', $test_names_1)->groupBy(['testId', function($item) use (&$date_list_1, &$lab_values) {
            $date = date('d-m-Y H:i' ,strtotime($item->createTime));
            $date = strtotime($date);
            $date_list_1[] = $date;
            $item->temp_result_date_time = $date;
            return $date;
        }])->toArray();
        $date_list_1 = array_unique($date_list_1);
        rsort($date_list_1);
        $date_list_2 = [];

        $results_2 = $lab_values->whereIn('testId', $test_names_2)->groupBy(['testId', function($item) use (&$date_list_2, &$lab_values) {
            $date = date('d-m-Y H:i' ,strtotime($item->createTime));
            $date = strtotime($date);
            $date_list_2[] = $date;
            $item->temp_result_date_time = $date;
            return $date;
        }])->toArray();
        $date_list_2 = array_unique($date_list_2);
        rsort($date_list_2);

        $results_4 = $date_list_4 = $test_names_4 = [];

        if ($baby_id != '') {
            $admission_ids = Admission::where('BabyId', $baby_id)->pluck('AdmissionId');
            $lab_data_table_name = 'emr_lab_values';

            $abg_test_list = DialpadSupportProperty::ABG_TEST_LIST;
            $lab_values_4 = [];
            foreach ($admission_ids as $admission_id) {
                $patient_status = DischargeLog::getDischargeDetail($baby_id, $admission_id);
                if (count($patient_status) > 0) {
                    $lab_data_table_name = 'emr_lab_values_discharged';
                }
                $temp_lab_values_4 = EmrLogHeader::getInterfacingData($baby_id, $admission_id, $abg_test_list, '', '', $lab_data_table_name, false)->toArray();
                $lab_values_4 = array_merge($lab_values_4, $temp_lab_values_4);
            }

            $test_names_4 = \DB::table('local_code_group')->where('approval_parameter_priority', 'ilike', '%abg%')->orderBy('approval_parameter_priority', 'asc')->pluck('local_description', 'approval_parameter_priority');

            $results_4 = collect($lab_values_4)->groupBy(['approval_parameter_priority', 'temp_result_date_time'])->toArray();
            $date_list_4 = collect($lab_values_4)->pluck('temp_result_date_time')->unique()->toArray();
        }
        $file_name = 'lab_report_' . $mrn;
        $mrn = 'MRN: ' . $mrn;
        $babyname = 'Baby Name : ';

        Excel::create($file_name, function ($excel) use ($mrn, $babyname, $file_name, $results_1, $date_list_1, $test_names_1, $results_2, $date_list_2, $test_names_2, $description, $baby_id, $results_4, $date_list_4, $test_names_4) {
            $excel->sheet('Haematology and Biochemistry', function ($sheet1) use ($mrn, $babyname, $file_name, $results_1, $date_list_1, $test_names_1, $description) {
                $sheet_name = 'all_tab1';
                $sheet1->loadView('nurse_sheet.lab_export', compact('mrn', 'babyname', 'results_1', 'file_name', 'date_list_1', 'test_names_1', 'sheet_name', 'description'));
            });
            $excel->sheet('Urine, CSF, Stool', function ($sheet2) use ($mrn, $babyname, $file_name, $results_2, $date_list_2, $test_names_2, $description) {
                $sheet_name = 'all_tab2';
                $sheet2->loadView('nurse_sheet.lab_export', compact('mrn', 'babyname', 'results_2', 'file_name', 'date_list_2', 'test_names_2', 'sheet_name', 'description'));
            });
            if ($baby_id != '') {
                $excel->sheet('ABG', function ($sheet1) use ($mrn, $babyname, $file_name, $results_4, $date_list_4, $test_names_4) {
                    $sheet_name = 'all_tab4';
                    $sheet1->loadView('nurse_sheet.lab_export', compact('mrn', 'babyname', 'results_4', 'file_name', 'date_list_4', 'test_names_4', 'sheet_name'));
                });
            }
            $excel->setActiveSheetIndex(0);
        })->export('xlsx');

    }

}

