<?php

namespace App\Http\Controllers\prescription;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\prescription;
use Carbon\Carbon;
use App\Models\Settings\Settings;
use App\Models\Nurse\ImportFhir;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Http\Controllers\NicuDashboardController;
use App\Http\Controllers\Nurse\NurseSheetController;
use App\Http\Controllers\prescription\PrescriptionController;
use App\Events\WardEvent;
use App\Http\Controllers\Reports\NsofaController;
use App\Http\Controllers\Fhir\FhirFormateController;

class prescriptionFormatController extends Controller
{
    /**
     * Time zone type 
     *  
     * @var $time_zone
     */
    protected $time_zone;

    /**
    * This for site settings instance 
    * 
    * @var $site_settings
    */
    public $site_settings;

    function __construct(Settings $site_settings)
    {
        $this->site_settings = $site_settings;
        $this->time_zone     = env('TIME_ZONE');
        $this->custom_error = new ErrorLogController();
        $this->nsofaController = new NsofaController();
        $this->fhirformateController = new FhirFormateController($site_settings);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getPrescriptionData(Request $request)
    {
        $machine_data = (array)json_decode(file_get_contents('php://input'));
        $secure_user  = false;
        
        if (isset($machine_data['securityLabel'])) {

            $check_auth    = $machine_data['securityLabel'];

            $api_key       = \SiteHelpers::decrypt_id($check_auth->api_key);
            $user_password = \SiteHelpers::decrypt_id($check_auth->user_password);

            $settings               = $this->site_settings->find(1);
            $settings_api_key       = \SiteHelpers::decrypt_id($settings->api_key);
            $settings_user_name     =  $settings->api_user_name;
            $settings_user_password = \SiteHelpers::decrypt_id($settings->api_password);

            if (($api_key == $settings_api_key) && ($check_auth->user_name == $settings_user_name) &&  ($user_password == $settings_user_password)) {
                $secure_user = true;
            }

        }

        $check_prescription = $baby_id = $admission_id = 0;
        if ($secure_user && isset($machine_data['prescriptionData'])) {

            foreach ($machine_data['prescriptionData'] as $pump_key => $pump_value) {

                if ($pump_key == 'uhid') {
                    $baby_id = \DB::table('baby')->where('BMrNo', $pump_value)->first();
                    if (empty($baby_id)) {
                        return \Response::json(['status'=>'failure','message'=>'Unknown baby!'], 401);
                    } else {
                        $baby_id = $baby_id->BabyId;
                        $admission_id = \DB::table('baby_admission')->where('BabyId', $baby_id)->where('Status', 'Inpatient')->first();
                        if (empty($admission_id)) {
                            return \Response::json(['status'=>'failure','message'=>'Unknown admission!'], 401);
                        } else {
                            $admission_id =  $admission_id->AdmissionId;
                            $check_prescription = \DB::table('prescription_hdr')
                            ->leftjoin('prescription_dtl', 'prescription_dtl.pres_hdr_id', 'prescription_hdr.id')
                            ->where('prescription_id', $input['prescription_id'])
                            ->where('baby_id', $baby_id)
                            ->where('admission_id', $admission_id)
                            ->count();
                        }
                    }
                }

                if (is_object($pump_value)) {
                    $input[$pump_key] = $pump_value->value;
                    $local_code = ImportFhir::get_nurse_snomed_details($pump_value->snomed_code)->first();
                    $input[$pump_key.'_loinc_local_map_id'] = $local_code->ref_loc_master_id;
                    if ($pump_key == 'infused') {
                        $input['original_infused'] = $input[$pump_key];                
                    } elseif ($pump_key == 'remain_volume' && (is_null($pump_value->value) || $pump_value->value == 'null' || $pump_value->value == null)) {
                        $input[$pump_key] = 0;                
                    }  elseif ($pump_key == 'rate' && (is_null($pump_value->value) || $pump_value->value == 'null' || $pump_value->value == null)) {
                        $input[$pump_key] = 0;                
                    } 
                } elseif ($pump_key == 'prescription_id') {
                    $input[$pump_key] = str_replace('T', '', $pump_value);            
                } elseif ($pump_key != 'uhid') {
                    $input[$pump_key] = $pump_value;
                } 
            }

            $input['created_date_time'] = Carbon::now($this->time_zone);
            $input['created_user'] = $check_auth->user_name;

            $exist_result = \DB::table('prescription')->select('result_time')->where('prescription_id', $input['prescription_id'])->get()->pluck('result_time')->toArray();

            if (count($exist_result) > 0) {

                $temp_result_time = date('Y-m-d H:i:s', strtotime($input['result_time']));

                if (!in_array($temp_result_time, $exist_result) ) {
                    prescription::insert($input);
                }
                
            } else {
                
                prescription::insert($input);
                $this->custom_error->emergencyLog('Error: Prescription - '. json_encode($machine_data['prescriptionData']));

                if (!is_numeric($input['infused'])) {
                    $this->custom_error->emergencyLog('Error: Prescription - '. json_encode($machine_data['prescriptionData']));
                }
                
                if ($input['infused'] != '0.00') {

                    $rate_per_sec = $input['rate'] / 60;
                    $rate_per_sec = $rate_per_sec / 60;

                    if ($rate_per_sec > 0) {
                        $infused_time = $input['infused'] / $rate_per_sec;
                    } else {
                        $infused_time = 0;                        
                    }

                    $result_time = $input['result_time'];
                    $infused = $input['infused'];

                    $input['result_time'] = date('Y-m-d H:i:s', strtotime($result_time));

                    $resulttime = $input['result_time'];

                    $infused_timing = Carbon::createFromFormat('Y-m-d H:i:s', $input['result_time']);

                    $input['result_time'] = Carbon::createFromFormat('Y-m-d H:i:s', $infused_timing)->subSeconds($infused_time);
                    $input['infused'] = '0.00';
                    $input['original_infused'] = '0.00';                

                    if (is_numeric($input['remain_volume'])) {
                        $input['remain_volume'] = $input['remain_volume'] + $infused;
                    } else {
                        $input['remain_volume'] = 0;                        
                    }

                    $start_time = strtotime($input['result_time']);
                    $end_time = strtotime($result_time);

                    $diff_time = $end_time-$start_time;

                    if (is_numeric($input['remain_time'])) {
                        $input['remain_time'] = $input['remain_time'] + $diff_time;
                    }
                    
                    if (($infused_time/60) < 30){
                        prescription::insert($input);
                    }

                }
                
            }
            self::infusionCalculation($input['prescription_id'], $input['result_time']);
            self::sendToNSofaScoreCalculation($input['prescription_id'], $input['result_time']);
        }

        return \Response::json(['status'=>'success','message'=>'Success!'], 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     *  0 - Executing
     *
     *  1 - Pause
     *
     *  2 - Completed alias stop
     *
     *  3 - Pump Cancel (Machine)
     *
     *  4 - Queue
     *
     */
    public function getPrescriptionInstantStatus(Request $request)
    {
        $machine_data = (array)json_decode(file_get_contents('php://input'));
        $secure_user  = false;
        
        if (isset($machine_data['securityLabel'])) {

            $check_auth    = $machine_data['securityLabel'];

            $api_key       = \SiteHelpers::decrypt_id($check_auth->api_key);
            $user_password = \SiteHelpers::decrypt_id($check_auth->user_password);

            $settings               = $this->site_settings->find(1);
            $settings_api_key       = \SiteHelpers::decrypt_id($settings->api_key);
            $settings_user_name     =  $settings->api_user_name;
            $settings_user_password = \SiteHelpers::decrypt_id($settings->api_password);

            if (($api_key == $settings_api_key) && ($check_auth->user_name == $settings_user_name) &&  ($user_password == $settings_user_password)) {
                $secure_user = true;
            }

        }

        if ($secure_user && isset($machine_data['prescriptionData'])) {

            $prescription_id     = str_replace('T', '', $machine_data['prescriptionData']->prescription_id);

            $status = trim($machine_data['prescriptionData']->status);
            $collect_time = $machine_data['prescriptionData']->collect_time;

            $status_content = '';

            if ($status == 0) {
                
                $update_data = ['is_send'=>5, 'started_date'=>$collect_time];
                
                $status_content = 'Executing';

            } else if ($status == 1) {
                
                $update_data = ['is_send'=>4];
                
                $status_content = 'Pause';

            } else if ($status == 2) {
                
                $update_data = ['is_send'=>7, 'stopped_date'=>$collect_time];
                
                $status_content = 'Completed';

            }  else if ($status == 3) {
                
                $update_data = ['is_send'=>8, 'cancel_datetime'=>$collect_time];
                
                $status_content = 'Cancel';

            } else if ($status == 4) {
                
                $update_data = ['is_send'=>2];
                
                $status_content = 'Queue';

            }

            $this->custom_error->emergencyLog('Prescription Status - '. $prescription_id . ' is ' . $status_content);

            if (isset($update_data) && is_array($update_data) && ($prescription_id != '' && $prescription_id != null) && ($collect_time != '' && $collect_time != null)) {
                \DB::table('prescription_dtl')->where('prescription_id', $prescription_id)->where('is_send', '<>', 20)->update($update_data);
            }

            $post['prescription_from'] = 6;
            $post['prescription_id'] = $prescription_id;
            $post['data'] = $update_data;

            $basic_details  = \DB::table('patient_bed_log')
            ->select('prescription_hdr.admission_id', 'prescription_hdr.baby_id')
            ->leftjoin('prescription_hdr', 'patient_bed_log.admission_id', 'prescription_hdr.admission_id')
            ->leftjoin('prescription_dtl', 'prescription_hdr.id', 'prescription_dtl.pres_hdr_id')
            ->where('prescription_id', $prescription_id)
            ->orderBy('patient_bed_log.id', 'desc')
            ->first();

            if (isset($basic_details->baby_id)) {
                
                $post['admission_id'] = $basic_details->admission_id;
                PrescriptionController::prescriptionSendToUser($post);

                \SiteHelpers::updateDashboardAtFormUpdation($basic_details->baby_id, 'Prescription Status - Update');
                if (isset($basic_details->admission_id)) {
                    $prescription_exe_count = \DB::table('prescription_hdr')
                    ->leftjoin('prescription_dtl', 'prescription_hdr.id', 'prescription_dtl.pres_hdr_id')
                    ->where('admission_id', $basic_details->admission_id)
                    ->where('is_send', 5)
                    ->count();
                    $event_input['admission_id'] = $basic_details->admission_id;
                    $event_input['status'] = 'INDICATION';
                    $event_input['indication_no'] = 4;
                    $event_input['active'] = false;
                    if ($prescription_exe_count > 0) {
                        $event_input['active'] = true;
                    }
                    broadcast(new WardEvent($event_input))->toOthers();
                }
            }

        }

        echo "Success";

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPrescriptionInstantStop(Request $request)
    {
        $machine_data = (array)json_decode(file_get_contents('php://input'));
        $secure_user  = false;
        
        if (isset($machine_data['securityLabel'])) {

            $check_auth    = $machine_data['securityLabel'];

            $api_key       = \SiteHelpers::decrypt_id($check_auth->api_key);
            $user_password = \SiteHelpers::decrypt_id($check_auth->user_password);

            $settings               = $this->site_settings->find(1);
            $settings_api_key       = \SiteHelpers::decrypt_id($settings->api_key);
            $settings_user_name     =  $settings->api_user_name;
            $settings_user_password = \SiteHelpers::decrypt_id($settings->api_password);

            if (($api_key == $settings_api_key) && ($check_auth->user_name == $settings_user_name) &&  ($user_password == $settings_user_password)) {
                $secure_user = true;
            }

        }

        if ($secure_user && isset($machine_data['prescriptionData'])) {

            $prescription_id     = str_replace('T', '', $machine_data['prescriptionData']->prescription_id);

            $update_data = ['is_send'=>7, 'stopped_date'=>$machine_data['prescriptionData']->result_time];

            $this->custom_error->emergencyLog('Prescription Status - '. $prescription_id . ' is Stopped');

            \DB::table('prescription_dtl')->where('prescription_id', $prescription_id)->where('is_send', '<>', 20)->update($update_data);
		
            $post['prescription_from'] = 6;
            $post['prescription_id'] = $prescription_id;
            $post['data'] = $update_data;

            PrescriptionController::prescriptionSendToUser($post);       

        }

    }

    /**
     * Calculate prescription infusion for that hour
     *
     * @param  string  $prescription_id
     * @param  timestamp  $result_time
     */
    public static function infusionCalculation($prescription_id, $result_time)
    {
        
        $current_hour_start = date('Y-m-d H:00:00', strtotime($result_time));
        $current_hour_end = date('Y-m-d H:i:s', strtotime('+59 minutes +59 second', strtotime($current_hour_start)));

        $previous_hour_start = date('Y-m-d H:00:00', strtotime('-1 hour', strtotime($result_time)));
        $previous_hour_end = date('Y-m-d H:i:s', strtotime('+59 minutes +59 second', strtotime($previous_hour_start)));

        $results = \DB::table('prescription')
        ->select('*', \DB::raw("TO_CHAR(result_time,'YYYY-MM-DD HH24:00:00') as temp_result_time"))
        ->where('prescription_id', $prescription_id)
        ->whereBetween('result_time', [$previous_hour_start, $current_hour_end])
        ->whereNotNull('infused')
        ->where('infused', '<>', '')
        ->orderBy('result_time', 'asc')
        ->get()
        ->groupBy('temp_result_time');

        $previous_hour_result = isset($results[$previous_hour_start]) ? $results[$previous_hour_start] : [];
        $current_hour_result = isset($results[$current_hour_start]) ? $results[$current_hour_start] : [];

        if (count($previous_hour_result) > 0) {

            $previous_hour_first_result = collect($previous_hour_result)->first();
            $current_hour_first_result = collect($current_hour_result)->first();

            $current_hour_first_result->infused = isset($current_hour_first_result->infused) ? $current_hour_first_result->infused : 0;
            $previous_hour_first_result->infused = isset($previous_hour_first_result->infused) ? $previous_hour_first_result->infused : 0;

            $hour_infused = $current_hour_first_result->infused - $previous_hour_first_result->infused;

            if ($hour_infused > 0) {

                $previous_hour_last_result = collect($previous_hour_result)->last();

                $calculated_hour = date('Y-m-d H:00', strtotime($previous_hour_first_result->result_time));
                $prescription_id = $previous_hour_last_result->prescription_id;
                $hour_rate = is_numeric($previous_hour_last_result->rate) ? $previous_hour_last_result->rate : 0;   

                if ($hour_rate <= 0) {
                    $hour_rate = is_numeric($previous_hour_first_result->rate) ? $previous_hour_first_result->rate : 0;   
                }

                $input['hour_infused'] = $hour_infused;
                $input['original_hour_infused'] = $hour_infused;
                $input['hour_rate'] = $hour_rate;
                $input['is_calculated'] = true;

                $check_exist_calculation = \DB::table('prescription_infused_calculation')
                ->where('prescription_id', $prescription_id)
                ->where('calculated_hour', $calculated_hour)
                ->count();

                if ($check_exist_calculation > 0) {
                    \DB::table('prescription_infused_calculation')
                    ->where('prescription_id', $prescription_id)
                    ->where('calculated_hour', $calculated_hour)
                    // ->where('is_calculated', false)
                    ->update($input);
                } else {
                    $input['prescription_id'] = $prescription_id;
                    $input['calculated_hour'] = $calculated_hour;
                    \DB::table('prescription_infused_calculation')->insert($input);                    
                }
            }

        }

        if (count($current_hour_result) > 0) {
            self::currentHourCalculation($current_hour_result);
        }

        $baby_details = \DB::table('prescription_hdr')
        ->select('admission_id')
        ->leftJoin('prescription_dtl', 'prescription_hdr.id', 'prescription_dtl.pres_hdr_id')
        ->where('prescription_id', $prescription_id)
        ->first();

        if (isset($baby_details->admission_id)) {
            $input['admission_id'] = $baby_details->admission_id;
            $input['sheet_date'] = $result_time;
            $input['time_hour'] = $result_time;

            NurseSheetController::dayTotalInput($input);
        }    

    }

    /**
     * Calculate prescription infusion for current hour
     *
     * @param  string  $prescription_id
     * @param  timestamp  $result_time
     */
    public static function currentHourCalculation($current_hour_result) {

        $current_hour_first_result = collect($current_hour_result)->first();
        $current_hour_last_result = collect($current_hour_result)->last();

        $current_hour_first_result->infused = isset($current_hour_first_result->infused) ? $current_hour_first_result->infused : 0;
        $current_hour_last_result->infused = isset($current_hour_last_result->infused) ? $current_hour_last_result->infused : 0;

        $hour_infused = $current_hour_last_result->infused - $current_hour_first_result->infused;

        if ($hour_infused > 0) {
            $calculated_hour = date('Y-m-d H:00', strtotime($current_hour_first_result->result_time));
            $prescription_id = $current_hour_first_result->prescription_id;
            $hour_rate = is_numeric($current_hour_last_result->rate) ? $current_hour_last_result->rate : 0;                
            if ($hour_rate <= 0) {
                $hour_rate = is_numeric($current_hour_first_result->rate) ? $current_hour_first_result->rate : 0;   
            }

            $input['hour_infused'] = $hour_infused;
            $input['original_hour_infused'] = $hour_infused;
            $input['hour_rate'] = $hour_rate;

            $check_exist_calculation = \DB::table('prescription_infused_calculation')
            ->where('prescription_id', $prescription_id)
            ->where('calculated_hour', $calculated_hour)
            ->count();

            if ($check_exist_calculation > 0) {
                \DB::table('prescription_infused_calculation')
                ->where('prescription_id', $prescription_id)
                ->where('calculated_hour', $calculated_hour)
                // ->where('is_calculated', false)
                ->update($input);
            } else {
                $input['prescription_id'] = $prescription_id;
                $input['calculated_hour'] = $calculated_hour;
                \DB::table('prescription_infused_calculation')->insert($input);                    
            }
        }

    }

    public function sendToNSofaScoreCalculation($prescription_id, $result_date_time){

        $current_hour_start = date('Y-m-d H:00:00', strtotime($result_date_time));
        $current_hour_end = date('Y-m-d H:i:s', strtotime('+59 minutes +59 second', strtotime($current_hour_start)));


        $getPrescriptionData = \DB::table('mas_drugivfluid as mdi')
            ->join('prescription_hdr as ph', 'ph.pharmacological_name', '=', 'mdi.id')
            ->join('prescription_dtl as pd', 'pd.pres_hdr_id', '=', 'ph.id')
            ->select('mdi.generic_pharmacological_name', 'ph.admission_id', 'ph.baby_id', 'ph.mother_id')
            ->where('pd.prescription_id', $prescription_id)
            ->first();

        if (isset($getPrescriptionData->generic_pharmacological_name) && !empty($getPrescriptionData->generic_pharmacological_name)) {
            $getNurseSheetHeaderDetails = \DB::table('emr_log_hdr')->select('id')
                ->whereBetween('sender_time',  [$current_hour_start, $current_hour_end])
                ->where('admission_id', $getPrescriptionData->admission_id)
                ->first();

            if (isset($getNurseSheetHeaderDetails->id) && !empty($getNurseSheetHeaderDetails->id)) {
                $this->nsofaController->calculateAndStoreNsofaScoreHourly($getNurseSheetHeaderDetails->id, null, null, null, null, null, $getPrescriptionData->generic_pharmacological_name);
            } else {
                $nurse_date = date('Y-m-d', strtotime($result_date_time));
                $day_sheet_id = ImportFhir::get_nurse_sheet_check($nurse_date, $getPrescriptionData->baby_id, $getPrescriptionData->admission_id);
                if (count($day_sheet_id) == 0) {
                    $day_sheet_id = $this->fhirformateController->createmainday($getPrescriptionData->baby_id, $getPrescriptionData->admission_id, $nurse_date, $result_date_time, false);
                } else {
                    $day_sheet_id = $day_sheet_id->id;
                }

                $emr_log_header = ImportFhir::get_emr_header_checks($nurse_date, $getPrescriptionData->baby_id, $getPrescriptionData->admission_id, $result_date_time);
                if (count($emr_log_header) == 0) {
                    $baby_details = \DB::table('baby')->select('Sex', 'MotherId')->where('BabyId', $getPrescriptionData->baby_id)->where('IsDeleted', '0')->first();
                    $header_id = $this->fhirformateController->createsheetheader($getPrescriptionData->baby_id, $getPrescriptionData->admission_id, $baby_details,$result_date_time, $day_sheet_id);
                } else {
                    $header_id = $emr_log_header->id;
                }
                $this->nsofaController->calculateAndStoreNsofaScoreHourly($header_id, null, null, null, null, null, $getPrescriptionData->generic_pharmacological_name);
            }
        }
        return true;
    }
}
