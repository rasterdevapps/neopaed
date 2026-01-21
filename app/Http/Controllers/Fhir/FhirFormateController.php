<?php
namespace App\Http\Controllers\Fhir;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Machine\MachineData;
use App\Models\Fhir\FhirFormatedValues;
use App\Models\Fhir\FhirJsonSchema;
use App\Models\Settings\Settings;
use App\Http\Controllers\Fhir\ImportFhirController;
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
use App\Http\Controllers\Fhir\HmsInterfacingController;
use App\Models\Nurse\DayWisePatientBedLog;
use App\Events\WardEvent;
use App\Http\Controllers\Reports\NsofaController;

class FhirFormateController extends Controller
{

    /**
     * This for machine data instance
     *
     *@var $machine_data
     */
    public $machine_data;
    private $spo2_ref_local_id;
    private $ventilator_mode_ref_local_id;
    private $fio2_ref_local_id;
    private $delivered_fio2_ref_local_id;

    /**
     * This for prescription key id
     *
     * @var $prescription_key_id
     */
    public $prescription_key_id = array(
        0 => "IVDI",
        1 => "OIVD",
        2 => "OIVI",
        3 => "GI"
    );

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Settings $site_settings)
    {
        $this->machine_data = new MachineData();
        $this->site_settings = $site_settings;  
        $this->time_zone = env('TIME_ZONE');
        $this->custom_error = new ErrorLogController();
        $this->monitor_user = 2;
        $this->ventilator_user = 3;
        $this->spo2_ref_local_id = 44;
        $this->ventilator_mode_ref_local_id = 47;
        $this->fio2_ref_local_id = 52;
        $this->delivered_fio2_ref_local_id = 296;
        $this->nsofaController = new NsofaController();

    }

    /**
     * This method to get formate
     *
     * @param  $input type array
     *
     * @return type bool
     */
    public function getformatfhir(Request $request)
    {
        $input = $request->all();
        $auth  = false;
        $machine_data['received'] = file_get_contents('php://input');

        $machine_entry = (array)json_decode($machine_data['received']);
        if (!isset($machine_entry['entry'])) {
            return \Response::json(['status'=>'failure','message'=>'Invalid json formate !'], 422);
        }

        $machine_entry = $machine_entry['entry'];
        $patient_details = array();
        $resource_data = array();

        foreach ($machine_entry as $machine_entry_key => $machine_entry_value) {

            if (isset($machine_entry_value->resource->resourceType) && $machine_entry_value->resource->resourceType == 'AuditEvent') {
                if (isset($machine_entry_value->resource->object)) {

                    foreach ($machine_entry_value->resource->object as $resource_key => $resource_value) {

                        if (isset($resource_value->securityLabel)) {
                            $securityLabel = collect($resource_value->securityLabel);
                            $api_key       = $securityLabel->where('code', 'api_key')->first();
                            $user_name     = $securityLabel->where('code', 'user_name')->first();
                            $user_password = $securityLabel->where('code', 'user_password')->first();


                            if (isset($api_key->display) && isset($user_name->display) &&  isset($user_password->display)) 
                            {
                                $input['api_key']       = $api_key->display;
                                $input['user_password'] = $user_password->display;
                                $input['user_name']     = $user_name->display;
                                $auth        = $this->getCheckAuth($input);
                            } 
                            else 
                            {
                                return \Response::json(['status'=>'failure','message'=>'Invalid json formate !'], 422);
                            }

                        }
                    }
                }
            }
            if ($auth === true) 
            {
                if ($machine_entry_value->resource->resourceType == 'Patient')
                {
                    $resource_data['patient'] = $this->patientFormat($machine_entry_value->resource, $machine_entry_value->resource->resourceType);
                }

                if ($machine_entry_value->resource->resourceType == 'Location')
                {

                    $resource_data['location'] = $this->locationFormat($machine_entry_value->resource);
                }

                if ($machine_entry_value->resource->resourceType == 'Device')
                {

                    $resource_data['device'] = $this->deviceFormat($machine_entry_value->resource);
                    if ($resource_data['device']['model'] == 'MINDRAY_N-SERIES' || ($resource_data['device']['model'] == 'ADMISSION_OBSERVATION' && stripos($resource_data['device']['asset_number'], 'MINDRAY_N-SERIES'))) {
                        $table_name = 'emr_moniter_values';
                    }
                    elseif (substr($resource_data['device']['model'], 0, 3) === 'SLE' || ($resource_data['device']['model'] == 'ADMISSION_OBSERVATION' && stripos($resource_data['device']['asset_number'], 'SLE'))) {
                        $table_name = 'emr_ventilator_values';
                    }
                }

                if ($machine_entry_value->resource->resourceType == 'Observation')
                {
                    $resource_data['observation'] = $this->observationFormat($machine_entry_value->resource);
                    $resource_data1 = collect($resource_data)->collapse()->toArray();

                }
            }
            else
            {
                return \Response::json(['status'=>'failure','message'=>'Invalid api key or  credentials !'], 401);
            }
        }
        $fhir_calculated_values = array(
            'low' => is_float($resource_data1['low']) ? number_format($resource_data1['low'], 2) : $resource_data1['low'],
            'first_quartile' => is_float($resource_data1['first_quartile']) ? number_format($resource_data1['first_quartile'], 2) : $resource_data1['first_quartile'],
            'last_quartile' => is_float($resource_data1['last_quartile']) ? number_format($resource_data1['last_quartile'], 2) : $resource_data1['last_quartile'],
            'mean' => is_float($resource_data1['mean']) ? number_format($resource_data1['mean'], 2) : $resource_data1['mean'],
            'close' => is_float($resource_data1['close']) ? number_format($resource_data1['close'], 2) : $resource_data1['close']
        );
        if (isset($resource_data1) && !empty($resource_data1)) {
            $machine_values_value = (object) $resource_data1;

            /*TO STORE HERO SCORE*/
            if ($machine_values_value->asset_number == 'HERO' && $machine_values_value->snomed_ct == 'HERO') {
                $score_res = $this->storeHeroScore($machine_values_value);
                if ($score_res === false) {
                    $this->custom_error->emergencyLog('Error While store HERO SCORE for bed:' . $machine_values_value->bed. ' at : ' .Carbon::now($this->time_zone));
                }
                else
                {
                    $this->custom_error->emergencyLog('HERO SCORE stored successfully for bed:' . $machine_values_value->bed. ' at : ' .Carbon::now($this->time_zone));
                }
                return \Response::json(['status' => 'success', 'message' => 'HERO Score stored Successfully'], 200);
            }


            $baby_details = ImportFhir::get_baby_details($machine_values_value->mrn);

            if (!isset($baby_details->BabyId))
            {
                $this->custom_error->emergencyLog('baby details not found mrn:' . $machine_values_value->mrn);
                $this->custom_error->emergencyLog('create baby registeration for mrn:' . $machine_values_value->mrn);
                $basic_details = $this->createbabyreg($machine_values_value);
                $babyId = isset($basic_details[0]) ? $basic_details[0] : '0';
                $MotherId = isset($basic_details[1]) ? $basic_details[1] : '0';
                $baby_details = (object)[];
                $baby_details->BabyId = $babyId;
                $baby_details->MotherId = $MotherId;
                if ($babyId == '0') {
                    $this->custom_error->emergencyLog('Can\'t Register the baby with Details:' . $machine_values_value->mrn. ' at : ' .Carbon::now($this->time_zone));
                    return \Response::json(['status' => 'success', 'message' => 'Invalid Baby MRN'], 200);
                }
                else
                {
                    $baby_details = ImportFhir::get_baby_details($machine_values_value->mrn);
                }

            }
            else
            {
                $babyId = $baby_details->BabyId;
                $MotherId = $baby_details->MotherId;
            }

            $baby_admission = ImportFhir::get_baby_admission($babyId, $machine_values_value->ip_number);
            if (!isset($baby_admission->AdmissionId))
            {

                $this->custom_error->emergencyLog('admission details not found BabyId:' . $babyId . '=======ip_number====='. $machine_values_value->ip_number);
                if (isset($babyId) && isset($MotherId) && isset($machine_values_value->mrn) && isset($machine_values_value->ip_number)) {
                    $admissionid = $this->createbabyadmisison($babyId, $MotherId, $machine_values_value->mrn, $machine_values_value->ip_number);
                    if ($admissionid == 0) {
                        $this->custom_error->emergencyLog('baby admission can\'t create for mrn:' . $machine_values_value->mrn);
                        return \Response::json(['status' => 'success', 'message' => 'Baby cannot Admitted created...... IP NUMBER EMPTY************** '], 200);
                    }
                    else
                    {
                        $this->custom_error->emergencyLog('create baby admission for mrn:' . $machine_values_value->mrn);
                    }
                } else {
                    $this->custom_error->emergencyLog('ERROR create baby admission====== babyId:' . $babyId.'* MotherId:' . $MotherId.'* machine_values_value->mrn:' . $machine_values_value->mrn.'*machine_values_value->ip_number:' . $machine_values_value->ip_number);
                }

            }
            else
            {
                $admissionid = $baby_admission->AdmissionId;

                if ($baby_admission->Status != 'Inpatient') {
                    Admission::where('AdmissionId', $admissionid)->update(['Status'=> 'Inpatient', 'DateModified'=> Carbon::now()]);
                    \DB::table('nicu_admission')->where('AdmissionId', $admissionid)->update(['status'=> 'Inpatient', 'DateModified'=> Carbon::now(), 'UserModified' => $this->monitor_user]);
                }
            }

            /*IF DATA FROM MONITER THEN CHECK FOR ADMISSION*/
            if ($machine_values_value->model == 'ADMISSION' && $machine_values_value->asset_number == 'ADMISSION') 
            {
                if (!isset($machine_values_value->bed) || empty($machine_values_value->bed)) {
                    $this->custom_error->emergencyLog('Get Bed Details From HMS for BabyId:' . $babyId);
                    $create_bed_log = $this->checkBedLogFromHMS($machine_values_value->mrn, $babyId, $admissionid);
                    if ($create_bed_log === false) {
                        return \Response::json(['status' => 'success', 'message' => 'Baby Admitted or Transfered Successfully************** '], 200);
                    }
                }
                else
                {
                    $bed_log = ImportFhir::get_baby_bed_log($babyId, $admissionid);
                    if (!isset($bed_log->id))
                    {
                        $this->custom_error->emergencyLog('Patient Log details not found BabyId:' . $babyId);
                        $this->custom_error->emergencyLog('create patient log for mrn:' . $babyId);
                        $this->createpatinetlog($machine_values_value, $babyId, $admissionid);
                    }
                    else
                    {
                        // if ($machine_values_value->room != $bed_log->room_no || $machine_values_value->bed != $bed_log->bed_no || $machine_values_value->ward != $bed_log->ward_name) {
                        if ($machine_values_value->bed != $bed_log->bed_no) {
                            $this->custom_error->emergencyLog('Patient Bed changed for BabyId:' . $babyId);
                            $this->updatepatinetlog($machine_values_value, $bed_log->id, $bed_log->bed_no, $babyId, $admissionid);
                        }
                    }  
                }

                $event_input['admission_id'] = $admissionid;
                $event_input['status'] = 'ADMISSION';
                ErrorLogController::emergencyLogStat('Fhir admission ' . json_encode($event_input));
                broadcast(new WardEvent($event_input))->toOthers();                
                \SiteHelpers::updateDashboardAtFormUpdation($babyId, 'Fhir formate admission data');
            }

            $time_issued = $nurse_time = $nurse_date = '';
            $time_issued = $machine_values_value->start_time;
            $nurse_date = date('Y-m-d', strtotime($time_issued));
            $nurse_time = date('Y-m-d H:i:s', strtotime($time_issued));
            $this->custom_error->emergencyLog('Nurse Time for this result ' . $nurse_time. ' ====== BABY ID: '.$baby_details->BabyId. ' ====== ADMISSION ID: '.$admissionid);
            /*Check admission or transfered FHIR*/
            if ($machine_values_value->model == 'ADMISSION' && $machine_values_value->asset_number == 'ADMISSION') 
            {
                $day_sheet_id = ImportFhir::get_nurse_sheet_check($nurse_date, $baby_details->BabyId, $admissionid);

                if (count($day_sheet_id) == 0)
                {
                    $day_sheet_id = $this->createmainday($baby_details->BabyId, $admissionid, $nurse_date, $nurse_time);
                }
                else
                {
                    $day_sheet_id = $day_sheet_id->id;

                    $this->dayWiseBedLog($day_sheet_id, $baby_details->BabyId, $admissionid);

                }
                $emr_log_header = ImportFhir::get_emr_header_checks($nurse_date, $babyId, $admissionid, $nurse_time);
                if (count($emr_log_header) == 0)
                {
                    $header_id = $this->createsheetheader($baby_details->BabyId, $admissionid, $baby_details, $time_issued, $day_sheet_id);
                } else {
                    $header_id = $emr_log_header->id;
                }
                $this->custom_error->emergencyLog('Baby Admitted or Transfered for BabyId:' . $babyId.' Baby MRN :'.$machine_values_value->mrn.' FOR TIME===================='.$nurse_time);

                $temp['ref_loc_master_id'] = 0;
                $temp['property'] = null;
                $temp['scale_typ'] = null;
                $temp['method_typ'] = null;

                $this->createlogdtl($header_id, $temp, $nurse_time, $machine_values_value->mean, 'emr_moniter_values', $machine_values_value->model, $machine_values_value->asset_number, $fhir_calculated_values);

                return \Response::json(['status' => 'success', 'message' => 'Baby Admitted or Transfered Successfully'], 200);
            }

                /* Check nicu admission
                 * If found, adding every first data from machine at the time of baby admitted in NICU admission
                 */
                if ($machine_values_value->model == 'ADMISSION_OBSERVATION') {

                    $nicu_admission_exist = \DB::table('nicu_admission')
                    ->where('BMrNo', $machine_values_value->mrn)
                    ->where('status', 'Inpatient')
                    ->first();

                    $this->custom_error->emergencyLog('NICU admission data======'.json_encode($machine_values_value));

                    if (isset($nicu_admission_exist->NicuId)) {
                        $get_local_code = ImportFhir::get_nurse_snomed_details($machine_values_value->snomed_code)->first();

                        if (isset($get_local_code->local_code)) {

                            if ($get_local_code->local_code == 'mode_of_ventilation') {

                                $admission_mode = Admissionmode::ListData();

                                $mode = array_search ($fhir_calculated_values['mean'], $admission_mode);

                                \DB::table('nicu_admission')->where('NicuId', $nicu_admission_exist->NicuId)->update(['Mode'=>$mode]);

                            } else if ($get_local_code->local_code == 'mode_of_ventilation_invasive') {

                                $admission_mode = Admissionmode::ListData();

                                $mode = array_search ($fhir_calculated_values['mean'], $admission_mode);

                                \DB::table('nicu_admission')->where('NicuId', $nicu_admission_exist->NicuId)->update(['Mode_invasive'=>$mode]);

                            } else if ($get_local_code->local_code == 'respiratory_rate') {

                                \DB::table('nicu_admission')->where('NicuId', $nicu_admission_exist->NicuId)->update(['RR'=>$fhir_calculated_values['mean']]);

                            } else if ($get_local_code->local_code == 'hr_rate') {

                                \DB::table('nicu_admission')->where('NicuId', $nicu_admission_exist->NicuId)->update(['HR'=>$fhir_calculated_values['mean']]);

                            } else if ($get_local_code->local_code == 'cuff_systalic_bp' || $get_local_code->local_code == 'arterial_systalic_bp') {

                                \DB::table('nicu_admission')->where('NicuId', $nicu_admission_exist->NicuId)->update(['BP'=>$fhir_calculated_values['mean']]);

                            } else if ($get_local_code->local_code == 'cuff_diastolic_bp' || $get_local_code->local_code == 'arterial_diastolic_bp') {

                                \DB::table('nicu_admission')->where('NicuId', $nicu_admission_exist->NicuId)->update(['diastolic_bp'=>$fhir_calculated_values['mean']]);

                            } else if ($get_local_code->local_code == 'cuff_mean_bp' || $get_local_code->local_code == 'arterial_mean_bp') {

                                \DB::table('nicu_admission')->where('NicuId', $nicu_admission_exist->NicuId)->update(['MeanBP'=>$fhir_calculated_values['mean']]);

                            } else if ($get_local_code->local_code == 'core_temp' || $get_local_code->local_code == 'peripheral_temp') {

                                \DB::table('nicu_admission')->where('NicuId', $nicu_admission_exist->NicuId)->update(['Temperature'=>$fhir_calculated_values['mean']]);

                            } else if ($get_local_code->local_code == 'preductal_sao2') {

                                \DB::table('nicu_admission')->where('NicuId', $nicu_admission_exist->NicuId)->update(['SpO2'=>$fhir_calculated_values['mean']]);

                            } else if ($get_local_code->local_code == 'peripheral_temp') {

                                \DB::table('nicu_admission')->where('NicuId', $nicu_admission_exist->NicuId)->update(['TemperatureAtAdmission'=>$fhir_calculated_values['mean']]);

                            }
                        }
                    } else {
                        $this->custom_error->emergencyLog('NICU admission not found======'.$nicu_admission_exist->NicuId);
                    }

                    // return \Response::json(['status' => 'success', 'message' => 'NICU admission data added successfully'], 200);

                }

                $machine_values_value->snomed_code = str_replace(';', '', $machine_values_value->snomed_code);
                $machine_values_value->snomed_code = str_replace('-', '', $machine_values_value->snomed_code);

                $get_local_code = ImportFhir::get_nurse_snomed_details($machine_values_value->snomed_code)
                ->first();
                if (count($get_local_code) == 0)
                {
                    $this->custom_error->emergencyLog('The snomed code is not found in table code :' . $machine_values_value->snomed_code);
                    // return \Response::json(['status'=>'failure','message'=>'The snomed code is not found in table code !'], 401);
                    return \Response::json(['status' => 'success', 'message' => 'Content Added Successfully ***'], 200);
                }
                else
                {
                    $emr_log_header = ImportFhir::get_emr_header_checks($nurse_date, $babyId, $admissionid, $nurse_time);
                    $this->custom_error->emergencyLog('sheet log: nurse-date = ' . $nurse_date . ', baby-id = ' . $babyId . ', admission-id = ' . $admissionid . ', nurse-time = ' . $nurse_time.', Snomed code = '.$machine_values_value->snomed_code.', Local code = '.$get_local_code->local_code);
                    if (count($emr_log_header) > 0)
                    {
                        $emr_log_header_id = $emr_log_header->id;

                        if ($machine_values_value->model == 'SLE6000' || $machine_values_value->model == 'SLE5000')
                        {
                            $volume_target = ImportFhir::get_nurse_sheet_details($emr_log_header_id, $nurse_time, '113', $table_name ,$machine_values_value->asset_number);
                            //volume targeting
                            if (count($volume_target) == 0 && $machine_values_value->asset_number != '' && count(explode(':', $machine_values_value->asset_number)) == 5)
                            {
                                $asset_number = explode(':', $machine_values_value->asset_number);
                                if ($asset_number[2] == '16')
                                {
                                    $volume_targeting = null;
                                }
                                else
                                {
                                    $volume_targeting = ($asset_number[3] == '255') ? 'on' : null;
                                }
                                $volume_targeting_local_code = ImportFhir::get_nurse_snomed_details('405609003')->first();
                                $this->createlogdtl($emr_log_header_id, $volume_targeting_local_code, $nurse_time, $volume_targeting, $table_name, $machine_values_value->model, $machine_values_value->asset_number, $fhir_calculated_values);
                            }
                            elseif (count($volume_target) == 0 && $machine_values_value->asset_number != '' && count(explode(':', $machine_values_value->asset_number)) == 4)
                            {

                                $asset_number = explode(':', $machine_values_value->asset_number);
                                if ($asset_number[2] == '16')
                                {
                                    $volume_targeting = null;
                                }
                                else
                                {
                                    $volume_targeting = ($asset_number[3] == '255') ? 'on' : null;
                                }

                                $volume_targeting_local_code = ImportFhir::get_nurse_snomed_details('405609003')->first();
                                $this->createlogdtl($emr_log_header_id, $volume_targeting_local_code, $nurse_time, $volume_targeting, $table_name, $machine_values_value->model, $machine_values_value->asset_number, $fhir_calculated_values);
                            }
                            elseif ($machine_values_value->asset_number != '' && count(explode(':', $machine_values_value->asset_number)) == 5)
                            {
                                $asset_number = explode(':', $machine_values_value->asset_number);
                                if ($asset_number[2] == '16')
                                {
                                    $volume_targeting = null;
                                }
                                else
                                {
                                    $volume_targeting = ($asset_number[3] == '255') ? 'on' : null;
                                }
                                // $this->custom_error->emergencyLog('updating volume targeting');
                                $this->updatelogdtl($volume_target->id, $volume_targeting, $table_name, $fhir_calculated_values, $machine_values_value->asset_number, $emr_log_header_id, $volume_target->loinc_local_map_id);
                            }
                            elseif ($machine_values_value->asset_number != '' && count(explode(':', $machine_values_value->asset_number)) == 4)
                            {
                                $asset_number = explode(':', $machine_values_value->asset_number);
                                if ($asset_number[2] == '16')
                                {
                                    $volume_targeting = null;
                                }
                                else
                                {
                                    $volume_targeting = ($asset_number[3] == '255') ? 'on' : null;
                                }
                                $this->updatelogdtl($volume_target->id, $volume_targeting, $table_name, $fhir_calculated_values, $machine_values_value->asset_number, $emr_log_header_id, $volume_target->loinc_local_map_id);
                            }
                            //volume targeting
                            $vendilation = ImportFhir::get_nurse_sheet_details($emr_log_header_id, $nurse_time, '47', $table_name,$machine_values_value->asset_number);
                            if (count($vendilation) == 0 && $machine_values_value->asset_number != '' && count(explode(':', $machine_values_value->asset_number)) == 5)
                            {
                                $asset_number = explode(':', $machine_values_value->asset_number);
                                $vendilation_mode = \DeviceHelpers::getVendilationMode($asset_number[2], $machine_values_value->model);
                                $vendilation_mode_local_code = ImportFhir::get_nurse_snomed_details('397814002')->first();
                                //$this->custom_error->emergencyLog('adding vendilator mode');
                                if (!is_array($vendilation_mode))
                                {
                                    $this->createlogdtl($emr_log_header_id, $vendilation_mode_local_code, $nurse_time, $vendilation_mode, $table_name, $machine_values_value->model, $machine_values_value->asset_number, $fhir_calculated_values);
                                }
                            }
                            elseif (count($vendilation) == 0 && $machine_values_value->asset_number != '' && count(explode(':', $machine_values_value->asset_number)) == 4)
                            {
                                $asset_number = explode(':', $machine_values_value->asset_number);
                                $vendilation_mode = \DeviceHelpers::getVendilationMode($asset_number[2], $machine_values_value->model);
                                $vendilation_mode_local_code = ImportFhir::get_nurse_snomed_details('397814002')->first();
                                //$this->custom_error->emergencyLog('adding vendilator mode');
                                if (!is_array($vendilation_mode))
                                {
                                    $this->createlogdtl($emr_log_header_id, $vendilation_mode_local_code, $nurse_time, $vendilation_mode, $table_name, $machine_values_value->model, $machine_values_value->asset_number, $fhir_calculated_values);
                                }
                            }
                            elseif ($machine_values_value->asset_number != '' && count(explode(':', $machine_values_value->asset_number)) == 5)
                            {
                                $asset_number = explode(':', $machine_values_value->asset_number);
                                $vendilation_mode = \DeviceHelpers::getVendilationMode($asset_number[2], $machine_values_value->model);
                                //$this->custom_error->emergencyLog('updating vendilator mode');
                                $this->updatelogdtl($vendilation->id, $vendilation_mode, $table_name, $fhir_calculated_values, $machine_values_value->asset_number, $emr_log_header_id, $vendilation->loinc_local_map_id);

                            }
                            elseif ($machine_values_value->asset_number != '' && count(explode(':', $machine_values_value->asset_number)) == 4)
                            {
                                $asset_number = explode(':', $machine_values_value->asset_number);
                                $vendilation_mode = \DeviceHelpers::getVendilationMode($asset_number[2], $machine_values_value->model);
                                //$this->custom_error->emergencyLog('updating vendilator mode');
                                $this->updatelogdtl($vendilation->id, $vendilation_mode, $table_name, $fhir_calculated_values, $machine_values_value->asset_number, $emr_log_header_id, $vendilation->loinc_local_map_id);

                            }

                        }

                        //volume targeting and vendilation mode
                        $local_id = $get_local_code->ref_loc_master_id;
                        $emr_log_details = ImportFhir::get_nurse_sheet_details($emr_log_header_id, $nurse_time, $local_id, $table_name,$machine_values_value->asset_number);
                        
                        if (count($emr_log_details) > 0 && isset($emr_log_details->id))
                        {
                            $this->custom_error->emergencyLog('EMR LOG HDR ID...... :' . $emr_log_header_id. '    DETAILS ID   '.$emr_log_details->id);
                            $this->updatelogdtl($emr_log_details->id, $machine_values_value->mean, $table_name, $fhir_calculated_values, $machine_values_value->asset_number, $emr_log_header_id, $emr_log_details->loinc_local_map_id);
                        }
                        else
                        {
                            //set parameter for o2
                            $asset_number = explode(':', $machine_values_value->asset_number);
                            if ($asset_number == '16')
                            {
                                if ($get_local_code->snomed_code == '250849000' || $get_local_code->snomed_code == '250774007')
                                {
                                    $this->createlogdtl($emr_log_header_id, $get_local_code, $nurse_time, $machine_values_value->mean, $table_name, $machine_values_value->model, $machine_values_value->asset_number);
                                }
                                //set parameter for o2
                                
                            }
                            elseif ($asset_number != '16')
                            {
                                $this->createlogdtl($emr_log_header_id, $get_local_code, $nurse_time, $machine_values_value->mean, $table_name, $machine_values_value->model, $machine_values_value->asset_number, $fhir_calculated_values);
                            }
                        }
                    }
                    else
                    {
                        $day_sheet_id = ImportFhir::get_nurse_sheet_check($nurse_date, $baby_details->BabyId, $admissionid);

                        if (count($day_sheet_id) == 0)
                        {
                            $day_sheet_id = $this->createmainday($baby_details->BabyId, $admissionid, $nurse_date, $nurse_time);
                        }
                        else
                        {
                            $day_sheet_id = ImportFhir::get_nurse_sheet_check($nurse_date, $baby_details->BabyId, $admissionid)->id;
                            $this->updateLabFlag($day_sheet_id);
                        }

                        $header_id = $this->createsheetheader($baby_details->BabyId, $admissionid, $baby_details, $time_issued, $day_sheet_id);
                        $get_local_code = ImportFhir::get_nurse_snomed_details($machine_values_value->snomed_code)->first();

                        $local_id = $get_local_code->ref_loc_master_id;
                        $this->createlogdtl($header_id, $get_local_code, $nurse_time, $machine_values_value->mean, $table_name, $machine_values_value->model, $machine_values_value->asset_number, $fhir_calculated_values);

                        \SiteHelpers::updateDashboardAtFormUpdation($baby_details->BabyId, 'Machine Data');                        

                    }
                    $mrn_number = $machine_values_value->mrn;
                    $date = date('Y-m-d', strtotime($nurse_time));
                    $dateTime = date('Y-m-d', strtotime($nurse_time));
                    if (isset(explode('-', $machine_values_value->model) [1]) && explode('-', $machine_values_value->model) [1] == 'pump')
                    {
                        $this->custom_error->emergencyLog('Prescription details MRN-' . $machine_values_value->mrn . ' Name-' . $machine_values_value->name . ' asset_number-' . $machine_values_value->asset_number . ' mean' . $machine_values_value->mean . ' date-' . $machine_values_value->issued);
                    }

                }
                return \Response::json(['status' => 'success', 'message' => 'Content Added Successfully'], 200);
            }
            else
            {
                return \Response::json(['status' => 'success', 'message' => 'Content Added Successfully'], 200);
            }
        }

    /**
     * This method to get formate
     *
     * @param  $patient_details type array
     *
     * @return type array
     */
    public function patientFormat($patient_details, $resourceType)
    {

        $patient = array();

        if (isset($patient_details->name))
        {
            $temp_name = '';
            foreach ($patient_details->name as $name_key => $name_value)
            {

                $temp_prefix = isset($name_value->prefix) && !empty($name_value->prefix) ? $temp_name . ' ' . implode(' ', $name_value->prefix) : '';
                $temp_given = isset($name_value->given) && !empty($name_value->given) ? $temp_name . ' ' . implode(' ', $name_value->given) : '';
                $temp_family = isset($name_value->family) && !empty($name_value->family) ? $temp_name . ' ' . implode(' ', $name_value->family) : '';
                $temp_suffix = isset($name_value->suffix) &&  !empty($name_value->suffix) ? $temp_name . ' ' . implode(' ', $name_value->suffix) : '';
                $patient['name'] = $temp_given . ' ' . $temp_family;
                // $patient['name'] = ltrim($temp_prefix.' '.$temp_given.' '.$temp_family.' '.$temp_suffix);


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

    /**
     * This method to get formate
     *
     * @param  $patient_details type array
     *
     * @return type array
     */
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
                }

                if ($identifier_value->system == 'Number')
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
            }
        }
        return $location;

    }

    /**
     * This method to get formate
     *
     * @param  $patient_details type array
     *
     * @return type array
     */
    public function deviceFormat($device_details)
    {
        $device = array();

        $device['model'] = isset($device_details->model) ? $device_details->model : '';
        $device['owner'] = isset($device_details
            ->owner
            ->reference) ? $device_details
        ->owner->reference : '';
        $device['patient'] = isset($device_details
            ->patient
            ->reference) ? $device_details
        ->patient->reference : '';
        $device['manufacturer'] = isset($device_details->manufacturer) ? $device_details->manufacturer : '';
        $device['asset_number'] = $device['start_time'] = $device['end_time'] = $device['from_id'] = $device['to_id'] = '';

        if (isset($device_details->identifier))
        {
            $device['asset_number'] = collect($device_details->identifier)->where('system', 'AssetNumber')->pluck('value')
            ->first();
            $device['start_time'] = collect($device_details->identifier)->where('system', 'messageAppResponseStartTime')->pluck('value')->first();
            $device['end_time'] = collect($device_details->identifier)->where('system', 'messageAppResponseEndTime')->pluck('value')->first();
            $device['from_id'] = collect($device_details->identifier)->where('system', 'messageEventStartId')->pluck('value')
            ->first();
            $device['to_id'] = collect($device_details->identifier)->where('system', 'messageEventGroupProcessId')->pluck('value')
            ->first();

            $asset_number = explode(':', collect($device_details->identifier)->where('system', 'AssetNumber')->pluck('value')
                ->first());
            $device['advice_id'] = isset($asset_number[1]) ? $asset_number[1] : null;
        }

        // $this->custom_error->emergencyLog("Message response times array is ".json_encode($device));
        return $device;

    }

    /**
     * This method to get device identifier
     *
     * @param $identifier type
     *
     * @return type array
     */

    /**
     * This method to get formate
     *
     * @param  $patient_details type array
     *
     * @return type array
     */
    public function observationFormat($observation_details)
    {
        $observation = array();

        foreach ($observation_details as $observation_details_key => $observation_details_value)
        {

            if ($observation_details_key == 'identifier')
            {
                foreach ($observation_details_value as $details_key => $details_value)
                {

                    if (isset($details_value->system) && $details_value->system == 'LOW')
                    {
                        $observation['low'] = $details_value->value;
                    }

                    if (isset($details_value->system) && $details_value->system == 'FIRST_QUARTILE')
                    {
                        $observation['first_quartile'] = $details_value->value;
                    }

                    if (isset($details_value->system) && $details_value->system == 'MEAN')
                    {
                        $observation['mean'] = $details_value->value;
                    }

                    if (isset($details_value->system) && $details_value->system == 'LAST_QUARTILE')
                    {
                        $observation['last_quartile'] = $details_value->value;
                    }

                    if (isset($details_value->system) && $details_value->system == 'HIGH')
                    {
                        $observation['close'] = $details_value->value;
                    }

                    if (isset($details_value->system) && $details_value->system == 'PUMP_VALUE')
                    {
                        $observation['mean'] = $details_value->value;
                    }

                }

            }

            if ($observation_details_key == 'code')
            {

                foreach ($observation_details_value->coding as $coding_key => $coding_value)
                {

                    $observation['loinc_code'] = isset($coding_value->code) ? str_replace(';', '|', $coding_value->code) : '';
                    $observation['display'] = isset($coding_value->display) ? $coding_value->display : '';
                    $observation['snomed_ct'] = isset($coding_value->code) ? preg_replace('/[;]/', '|', trim($coding_value->display)) : '';
                    $observation['snomed_ct'] = isset($observation['snomed_ct']) ? preg_replace('/[\s]/', '', trim($observation['snomed_ct'])) : '';
                    $observation['snomed_code'] = isset($coding_value->code) ? preg_replace('/[A-Z,a-z,\s,\/,|,%,-,;,(,)]/', '', trim($coding_value->display)) : '';

                }

            }

            if ($observation_details_key == 'valueQuantity')
            {

                $observation['value_quality_unit'] = isset($observation_details_value->unit) ? $observation_details_value->unit : '';
            }

            if ($observation_details_key == 'status')
            {
                $observation['status'] = $observation_details_value;

            }

            if ($observation_details_key == 'issued')
            {
                $observation['issued'] = $observation_details_value;
            }

        }

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
     * This method to update prescription status
     */
    public function prescriptionStatus($advice_id, $prescription, $other_iv_durgs)
    {
        foreach ($prescription as $key => $unqiueId)
        {
            $resource_id = substr($advice_id, 0, strlen($unqiueId));
            if ($resource_id == $unqiueId)
            {
                $id = substr($advice_id, strlen($unqiueId));
                \DB::table($key)->where('id', $id)->update($other_iv_durgs);
            }
        }
    }
    private function getCheckAuth($input)
    {
        $input['api_key']       = \SiteHelpers::decrypt_id($input['api_key']);
        $input['user_password'] = \SiteHelpers::decrypt_id($input['user_password']);

        $settings               = $this->site_settings->find(1);
        $api_key                = \SiteHelpers::decrypt_id($settings->api_key);
        $user_name              =  $settings->api_user_name;
        $user_password          = \SiteHelpers::decrypt_id($settings->api_password);

        if (($input['api_key'] == $api_key) && ($input['user_name'] == $user_name) &&  ($input['user_password'] == $user_password)) {
            return true;
        } else {
            return false;
        }

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
        // $mother['MotherName'] = 'M/O' . $baby_details->name;
        // $get_baby_details_from_his = \SiteHelpers::getConfigSettings('GET_PATIENT_INFO_FROM_HIS');
        // // $get_baby_details_from_his = 'http://172.17.1.17/rasterihmsapi/ihmsctrl.php?getPatientInfo&mrn=';
        // $client = new \GuzzleHttp\Client();
        // $response = $client->request('GET', $get_baby_details_from_his.trim($baby_details->mrn));
        // $patient_response = $response->getBody();
        // $patient_response = $patient_response->getContents();
        // $patient_response = collect(json_decode($patient_response))->toArray();

        $babyIsExist = Baby::where('BMrNo', trim($baby_details->mrn))->where('IsDeleted', '0')->first();
        if (count($babyIsExist) > 0)
        {
            $baby_id = $babyIsExist->BabyId;
        }
        else
        {
            $get_baby_details_from_his = \SiteHelpers::getConfigSettings('GET_PATIENT_INFO_FROM_HIS');
            $client = new \GuzzleHttp\Client();

            $settings = Settings::find(1);
            $header_content = [
                'Content-Type' => 'application/json',
                'token' => $settings->hms_token,
            ];

            $response = $client->get($get_baby_details_from_his, [
                'headers' => $header_content,
                'query' => ['uhid' => trim($baby_details->mrn)],
                'http_errors' => false
            ]);

            $patient_response = $response->getBody();
            $patient_response = $patient_response->getContents();

            $this->custom_error->emergencyLog('Patient response=================================='.$patient_response);
            $patient_response = collect(json_decode($patient_response))->toArray();
            if (isset($patient_response['data']) && !empty($patient_response['data'])) {

                $patient_data = $patient_response['data'];

                $name_aray = explode(' ', $patient_data->patient_name);
                $partial_mother_name = '';

                if (isset($name_aray[0])) {
                    $partial_mother_name = $name_aray[0];
                }
                $collect_baby_count = 0;
                if (!is_null($patient_data->mobile) && $patient_data->mobile != '') {

                    $check_mulitiple_preg = \DB::table('baby')->join('mother', 'mother.MotherId', '=', 'baby.MotherId')->where('baby.DOB', $patient_data->birth_date)->where('mother.Mobile', $patient_data->mobile)->get()->toArray();
                    $collect_baby_count = count($check_mulitiple_preg);
                }


                if ($collect_baby_count > 0 && !is_null($patient_data->mobile) && $patient_data->mobile != '') {

                    $currently_baby_count = $collect_baby_count + 1;

                    $preganancy_types = array(2=>'Twins', 3=>'Triplets', 4=>'Quadruplets', 5=>'Quintuplets', 6=>'Sextuplets', 7=>'Septuplets', 8=>'Octuplets');

                    $mother_id = $check_mulitiple_preg[0]->MotherId;
                    $baby['MultiplePregnancy'] = 'Yes';
                    $baby['MultiplePregnancyType'] = $preganancy_types[$currently_baby_count];
                    $baby['Noofbabies'] = $currently_baby_count;
                    $this->updateTwinBaby($mother_id, $patient_data->birth_date, $preganancy_types[$currently_baby_count], $currently_baby_count);

                }
                else
                {
                    $mother['MotherName'] = ucfirst(strtolower($patient_data->patient_name));
                    $mother['PartnerName'] = ucfirst(strtolower(str_replace(["S/O.", "S/O", "D/O.", "D/O"], "", $patient_data->surname)));
                    $mother['UserAdded'] = $this->monitor_user;
                    $mother['UserModified'] = $this->monitor_user;
                    $mother['DateAdded'] = Carbon::now();
                    $mother['IsDeleted'] = '0';
                    $mother['Address1'] = $patient_data->address1;
                    $mother['Address2'] = $patient_data->address2;
                    $mother['Address3'] = $patient_data->address3;
                    $mother['City'] = $patient_data->city;
                    $mother['Address4'] = $patient_data->pincode;
                    $mother['Mobile'] = $patient_data->mobile;
                    $mother_id = Mother::create($mother)->MotherId;
                    $baby['MultiplePregnancy'] = 'No';
                    $baby['BirthOrder'] = $baby['MultiplePregnancyType'] = 'Singleton';
                }

                $baby['MotherId'] = $mother_id;
                $baby['BMrNo'] = trim($baby_details->mrn);
                $salutation = $patient_data->salutation;
                if ($salutation == 'BABY OF.') {
                    $salutation = 'B/O';
                }
                $baby['BabyName'] = $salutation . ' ' .ucfirst(strtolower($patient_data->patient_name)).' '.ucfirst(strtolower(str_replace(["S/O.", "S/O", "D/O.", "D/O"], "", $patient_data->surname)));
                $baby['DOB'] = $patient_data->birth_date;
                // if (isset($patient_data->blood_group) && !empty($patient_data->blood_group)) {
                //     $baby['BabyBloodGroup'] = $patient_data->blood_group;
                // }
                $baby['Sex'] = ucfirst(strtolower($patient_data->sex));
                // $baby['Noofbabies']            = $baby_details->name;
                $baby['UserAdded'] = $this->monitor_user;
                $baby['DateAdded'] = Carbon::now();
                $baby['IsDeleted'] = '0';
                $baby['neonatal_consultant'] = env('DEFAULT_NEONATAL_CONSULTANTS');
                $baby_id = Baby::create($baby)->BabyId;
            }
            else
            {
                $this->custom_error->emergencyLog('Unable to get patient information from WEB HIS for UHID:' . $baby_details->mrn. ' at : ' .Carbon::now($this->time_zone));
                return false;
            }
        }
        return [$baby_id, $mother_id];
    }

    /**
     * This method create baby admission
     *
     * @param $baby_id type integer
     *
     * @param $mother_id type integer
     *
     * @return $admission_id
     */
    public function createbabyadmisison($baby_id, $mother_id, $bmr_no, $ip_number = '')
    {

        \DB::beginTransaction();

        try
        {

            if ($ip_number == '' || is_null($ip_number)) {


                // $visit_number_url = \SiteHelpers::getConfigSettings('GET_CURRENT_VISIT_NUMBER');
                // // $visit_number_url = 'http://172.17.1.17/rasterihmsapi/ihmsctrl.php?getActiveVisitList&mrn=';
                // $client = new \GuzzleHttp\Client();
                // $response = $client->request('GET', $visit_number_url.$bmr_no);
                // $visit_response = $response->getBody();
                // $visit_response = $visit_response->getContents();
                // $visit_response = collect(json_decode($visit_response)->data)->toArray();

                $settings = Settings::find(1);
                $visit_number_url = \SiteHelpers::getConfigSettings('GET_CURRENT_VISIT_NUMBER');
                $client = new \GuzzleHttp\Client();
                $header_content = [
                    'Content-Type' => 'application/json',
                    'token' => $settings->hms_token,
                ];

                $response = $client->get($visit_number_url, [
                    'headers' => $header_content,
                    'query' => ['uhid' => trim($bmr_no)],
                    'http_errors' => false
                ]);

                $visit_response = $response->getBody();
                $visit_response = $visit_response->getContents();
                $status_code = $response->getStatusCode();
                if ($status_code != 200) {
                    $this->custom_error->emergencyLog('HTTP ERROR for quering patient info from web HIS for MRN  :'.$bmr_no.' and received response : '.$visit_response);
                    return false;
                }
                $visit_response = collect(json_decode($visit_response)->data)->toArray();

                if (isset($visit_response[0]) && $visit_response[0]->visit_type == 'IP') {
                    $ip_number = $visit_response[0]->visit_no;
                    $admission_time = $visit_response[0]->admission_time;
                }
            }
            // $this->custom_error->emergencyLog('BABY MRN:' . $bmr_no.' ==========ADMISSION TO CREATE WITH IP========='.$ip_number);

            if ($ip_number != '' && !is_null($ip_number)) {

                $admission_old = Admission::where('BabyId', $baby_id)->count();
                $admission_old = $admission_old + 1;
                $admission["BMrNo"] = $bmr_no;
                $admission["MotherId"] = $mother_id;
                $admission["BabyId"] = $baby_id;
                if (isset($admission_time) && !empty($admission_time)) {
                    $admission["AdmissionDate"] = date('Y-m-d', strtotime($admission_time));
                    $admission["AdmissionTime"] = date('H:i:s', strtotime($admission_time));
                }
                else
                {
                    $admission["AdmissionDate"] = Carbon::now()->format('Y-m-d');
                    $admission["AdmissionTime"] = Carbon::now()->format('H:i:s');
                }
                $admission["InOrOut"] = 'In';
                $admission["AdmissionType"] = 'NICU';
                $admission["Status"] = 'Inpatient';
                $admission["UserAdded"] = $this->monitor_user;
                $admission["DateAdded"] = Carbon::now();
                $admission["DateModified"] = Carbon::now();
                $admission["episodes"] = 'Admission ' . $admission_old;
                $admission_exists = ImportFhir::get_existing_admission($baby_id, $ip_number);
                if (isset($admission_exists->AdmissionId) && !empty($admission_exists->AdmissionId))
                {
                    $admission_id = $admission_exists->AdmissionId;
                    $checkAdmission = Admission::where('AdmissionId', $admission_id)->first();

                    if ($checkAdmission->Status != 'Inpatient') {
                        $updateAdmissionStatus = Admission::where('AdmissionId', $admission_id)->update(['Status' => 'Inpatient']);
                    } 
                    if ($checkAdmission->AdmissionType == 'Post') {
                        $updateAdmissionStatus = Admission::where('AdmissionId', $admission_id)->update(['AdmissionType' => 'NICU']);                        
                    }
                }
                else
                {
                    Admission::where('BabyId', $baby_id)->update(['Status' => 'Discharged']);
                    $admission_id = Admission::create($admission)->AdmissionId;
                }

                $ip_exist =  IpNumber::where('baby_id', $baby_id)->where('ip_number', $ip_number)->first();
                $ip_insert = array(
                    'baby_id' => $baby_id,
                    'AdmissionId' => $admission_id,
                    'status' => '1',
                    'ip_number' => $ip_number,
                    'DateModified' => date('Y-m-d')
                );
                if (count($ip_exist) == 0) {
                    $ip_insert['DateAdded'] = date('Y-m-d');
                    IpNumber::insert($ip_insert);
                }
                else
                {
                    IpNumber::where('baby_id', $baby_id)->where('AdmissionId', $admission_id)->update($ip_insert);
                }
                $nicu_admission_exist = \DB::table('nicu_admission')
                ->where('BabyId', $baby_id)
                ->where('AdmissionId', $admission_id)
                                        // ->where('status', 'Inpatient')
                ->where('IsDeleted', '0')
                ->first();

                if (count($nicu_admission_exist) == 0) {
                    $nicu_admission = array(
                        'BabyId' => $baby_id,
                        'BMrNo' => $bmr_no,
                        'AdmissionId' => $admission_id,
                        'MotherId' => $mother_id,
                        'AdmissionDate' => (isset($admission_time) && !empty($admission_time)) ? date('Y-m-d', strtotime($admission_time)) : date('Y-m-d'),
                        'AdmissionTime' => (isset($admission_time) && !empty($admission_time)) ? date('h', strtotime($admission_time)) : date('h'),
                        'AdmissionTime_MINS' => (isset($admission_time) && !empty($admission_time)) ? date('i', strtotime($admission_time)) : date('i'),
                        'AdmissionTime_AM' => (isset($admission_time) && !empty($admission_time)) ? date('A', strtotime($admission_time)) : date('A'),
                        'status' => 'Inpatient',
                        'UserAdded' => $this->monitor_user,
                        'DateAdded' => date('Y-m-d H:i:s')
                    );
                    \DB::table('nicu_admission')->insert($nicu_admission);
                } else {
                    \DB::table('nicu_admission')->where('NicuId', $nicu_admission_exist->NicuId)->update(['status'=>'Inpatient', 'DateModified'=>Carbon::now($this->time_zone)]);
                }
            }
            else
            {
                $admission_id = 0;
            }
        }
        catch(\Exception $e)
        {

            $this->custom_error->emergencyLog('failed to create baby admission for mrn:' . $bmr_no);
            $this->custom_error->emergencyLog($e);
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
    public static function createmainday($babyid, $admissionid, $nurse_date, $nurse_time = '', $lab_slug = false)
    {
        $prev_date = date('Y-m-d', strtotime('-1 day', strtotime($nurse_date)));

        $is_exist = ImportFhir::get_nurse_sheet_count($babyid, $admissionid, $prev_date);
        $dayCount = ImportFhir::get_nurse_sheet_count($babyid, $admissionid);
        ErrorLogController::emergencyLogStat('Day count for this baby ==== ' . $dayCount.' and nurse_time ==== '.$nurse_time);

        if ($nurse_time != '' && $is_exist == 0) {
            ErrorLogController::emergencyLogStat('previous day sheet created' . $babyid);
            $working_time = Settings::getPeriod()->period;
            $get_hour = (int) explode(':', $working_time)[0];
            $nurse_time_hour = (int) date('H', strtotime($nurse_time));
            if ($nurse_time_hour < $get_hour) {     
                if ($dayCount > 0) {
                    $dayCount++;
                }
                $previous_sheet_details['day_name'] = 'Day ' . $dayCount;
                $previous_sheet_details['sheet_date'] = date('Y-m-d', strtotime('-1 day', strtotime($nurse_date)));
                $previous_sheet_details['baby_id'] = $babyid;
                $previous_sheet_details['admission_id'] = $admissionid;
                NurseSheetMain::create($previous_sheet_details);
            }
        }
        $sheet_details['day_name'] = 'Day ' . ($dayCount + 1);
        $sheet_details['sheet_date'] = date('Y-m-d', strtotime($nurse_date));
        $sheet_details['baby_id'] = $babyid;
        $sheet_details['admission_id'] = $admissionid;
        $sheet_details['lab_flag'] = $lab_slug;
        $sheet_id = NurseSheetMain::create($sheet_details)->id;

        self::dayWiseBedLog($sheet_id, $babyid, $admissionid);

        return $sheet_id;

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
        $main_sheet['create_user_id'] = $this->monitor_user;
        $main_sheet['create_tstamp'] = Carbon::now($this->time_zone);
        $main_sheet['modify_user_id'] = $this->monitor_user;
        $main_sheet['modify_tstamp'] = Carbon::now($this->time_zone);
        $main_sheet['day_id'] = isset($day_sheet_id) ? $day_sheet_id : null;
        $main_sheet['baby_id'] = isset($babyid) ? $babyid : null;
        $main_sheet['mother_id'] = isset($baby_details->MotherId) ? $baby_details->MotherId : null;
        $main_sheet['admission_id'] = isset($admissionid) ? $admissionid : null;
        $main_sheet['added_nurse'] = null;
        $emr_log_head_id = EmrLogHeader::create($main_sheet)->id;
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

        $user_id = $this->monitor_user;
        if ($table_name == 'emr_ventilator_values') {
            $user_id = $this->ventilator_user;
        }
        $result = collect($result)->toArray();
        $sub_sheet_values["log_hdr_id"] = $emr_log_header_id;
        $sub_sheet_values["loinc_local_map_id"] = $result['ref_loc_master_id'];
        $sub_sheet_values["intf_ref_value"] = is_float($value) ? number_format($value, 2) : $value;
        $sub_sheet_values["original_intf_ref_value"] = is_float($value) ? number_format($value, 2) : $value;
        $sub_sheet_values["property"] = $result['property'];
        $sub_sheet_values["result_date_time"] = $nurse_time;
        $sub_sheet_values["scale"] = $result["scale_typ"];
        $sub_sheet_values["method"] = $result["method_typ"];
        $sub_sheet_values["low"] = $fhir_calculated_values["low"];
        $sub_sheet_values["last_quartile"] = $fhir_calculated_values["last_quartile"];
        $sub_sheet_values["first_quartile"] = $fhir_calculated_values["first_quartile"];
        $sub_sheet_values["mean"] = $fhir_calculated_values["mean"];
        $sub_sheet_values["close"] = $fhir_calculated_values["close"];
        $sub_sheet_values["device_model"] = $model;
        $sub_sheet_values["device_id"] = $asset_number;
        $sub_sheet_values["create_user_id"] = $user_id;
        $sub_sheet_values["create_tstamp"] = Carbon::now($this->time_zone);
        $sub_sheet_values["modify_user_id"] = $user_id;
        $sub_sheet_values["modify_tstamp"] = Carbon::now($this->time_zone);

        \DB::table($table_name)->insert($sub_sheet_values);

        if ($result['ref_loc_master_id'] == $this->spo2_ref_local_id || $result['ref_loc_master_id'] == $this->ventilator_mode_ref_local_id || $result['ref_loc_master_id'] == $this->fio2_ref_local_id || $result['ref_loc_master_id'] == $this->delivered_fio2_ref_local_id) {
            $refId = $result['ref_loc_master_id'];
            switch ($refId) {
                case $this->spo2_ref_local_id:
                    $this->nsofaController->calculateAndStoreNsofaScoreHourly($emr_log_header_id, $sub_sheet_values["intf_ref_value"], null, null, null, null, null);
                    break;
                    
                case $this->ventilator_mode_ref_local_id:
                    $this->nsofaController->calculateAndStoreNsofaScoreHourly($emr_log_header_id, null, $sub_sheet_values["intf_ref_value"], null, null, null, null);
                    break;
                    
                case $this->fio2_ref_local_id:
                    $this->nsofaController->calculateAndStoreNsofaScoreHourly($emr_log_header_id, null, null, $sub_sheet_values["intf_ref_value"], null, null, null);
                    break;
                    
                case $this->delivered_fio2_ref_local_id:
                    $this->nsofaController->calculateAndStoreNsofaScoreHourly($emr_log_header_id, null, null, null, $sub_sheet_values["intf_ref_value"], null, null);
                    break;
            }
        }
        return true;

    }

    /**
     * This method to update value log
     * with time
     *
     * @param $id type integer
     *
     * @param $value type integer
     *
     * @param $table_name type string
     *
     * @param $fhir_calculated_values type array
     */
    public function updatelogdtl($id, $value, $table_name, $fhir_calculated_values = array(), $asset_number = '', $emr_log_header_id, $ref_loc_master_id)
    {
        $log_emr_details_count = \DB::table($table_name)->where('id', $id)->count();

        if ($log_emr_details_count > 0)
        {
            $fhir_calculated_values['intf_ref_value'] = is_float($value) ? number_format($value, 2) : $value;
            $fhir_calculated_values['original_intf_ref_value'] = is_float($value) ? number_format($value, 2) : $value;
            if ($asset_number != '') {
                $fhir_calculated_values['device_id'] = $asset_number;
            }
            $log_emr_details_count = \DB::table($table_name)->where('id', $id)->update($fhir_calculated_values);

            if ($ref_loc_master_id == $this->spo2_ref_local_id || $ref_loc_master_id == $this->ventilator_mode_ref_local_id || $ref_loc_master_id == $this->fio2_ref_local_id || $ref_loc_master_id == $this->delivered_fio2_ref_local_id) {
                $refId = $ref_loc_master_id;
                $this->custom_error->emergencyLog("LOG REFER ID ". $refId. " and VALUE IS==============". $value);
                switch ($refId) {
                    case $this->spo2_ref_local_id:
                        $this->nsofaController->calculateAndStoreNsofaScoreHourly($emr_log_header_id, $value, null, null, null, null, null);
                        break;
                        
                    case $this->ventilator_mode_ref_local_id:
                        $this->nsofaController->calculateAndStoreNsofaScoreHourly($emr_log_header_id, null, $value, null, null, null, null);
                        break;
                        
                    case $this->fio2_ref_local_id:
                        $this->nsofaController->calculateAndStoreNsofaScoreHourly($emr_log_header_id, null, null, $value, null, null, null);
                        break;
                        
                    case $this->delivered_fio2_ref_local_id:
                        $this->nsofaController->calculateAndStoreNsofaScoreHourly($emr_log_header_id, null, null, null, $value, null, null);
                        break;
                }
            }
            return true;
        }
        return true;

    }

    /**
     * This method is used to create patient bed log
     * with time
     *
     * @param $machine_value type array
     * @param $baby_id type integer
     * @param $admission_id type integer
     */
    public function createpatinetlog($machine_value, $baby_id, $admission_id)
    {
        $log = array();
        if (strpos($machine_value->ward, 'NICU') !== false) {
            $ward_name = 'NICU';
        }
        else
        {
            $ward_name = $machine_value->ward;
        }
        $log['baby_id'] = $baby_id;
        $log['admission_id'] = $admission_id;
        $log['room_no'] = $machine_value->room;
        $log['bed_no'] = $machine_value->bed;
        $log['ward_name'] = $machine_value->ward;
        $log['ward_id'] = \DB::table('ward')->select('id')->where('name', $ward_name)->first()->id;

        $bed_details = \DB::table('bed')->select('id', 'room_id', 'pump_type')->where('number', (int) $machine_value->bed)->first();
        $log['bed_id'] = $bed_details->id;
        $log['room_id'] = $bed_details->room_id;
        $log['UserAdded'] = $this->monitor_user;
        $log['UserModified'] = $this->monitor_user;
        $log['IsDeleted'] = 0;
        $log['status'] = 'Occupied';
        $log['DateAdded'] = Carbon::now($this->time_zone);
        // $log['DateAdded'] = date('Y-m-d H:i:s');
        // $log['DateModified'] = date('Y-m-d H:i:s');
        $log['DateModified'] = Carbon::now($this->time_zone);

        /*Check the current baby alreaby in other Bed*/
        $checkExistBedLog = \DB::table('patient_bed_log')->where('baby_id', $baby_id)->where('status', 'Occupied')->orderBy('admission_id', 'desc')->first();
        
        if (count($checkExistBedLog) > 0) {
            // \DB::table('bed')->where('number', $checkExistBedLog->bed_id)->update(['status'=> null]);
            \DB::table('bed')->where('number', (int) $checkExistBedLog->bed_id)->update(['status'=> null]);

            $updateExistBedLog = \DB::table('patient_bed_log')->where('baby_id', $baby_id)->where('status', 'Occupied')->update(['status' => 'discharged', 'DateModified' => Carbon::now(), 'UserModified' => $this->monitor_user]);

                if (isset($checkExistBedLog->bed_no) && isset($checkExistBedLog->room_no)) {
                    $bed_number = $checkExistBedLog->bed_no;
                    $room_number = $checkExistBedLog->room_no;     
                    if ($bed_number != $log['bed_no']) {
                        \SiteHelpers::emptyDashboardData($bed_number, $room_number);
                    }
                }
        }

        $checkExist = \DB::table('patient_bed_log')->where('bed_no', $log['bed_no'])->where('status', 'Occupied')->first();
        if (isset($checkExist->id)) {
            /*Discharge Previous baby to admit current baby in that bed*/
            $updateBedLog = \DB::table('patient_bed_log')->where('bed_no', $log['bed_no'])->where('status', 'Occupied')->update(['status' => 'discharged', 'DateModified' => Carbon::now(), 'UserModified' => $this->monitor_user]);

            // if ($baby_id != $checkExist->baby_id) {
            //     $updateBabyAdmission = Admission::where('AdmissionId', $admission_id)->where('BabyId', $baby_id)->update(['Status' => 'Discharged']);
            // }
        }

        $this->updateSyrangePumpDetails($baby_id, $admission_id, $bed_details->id, $bed_details->pump_type);
        \DB::table('patient_bed_log')->insert($log);
        \DB::table('bed')->where('number', (int) $machine_value->bed)->update(['status'=> 'Occupied']);
        return true;

    }

    /**
     * This method is used to create patient bed log
     * with time
     *
     * @param $machine_value type array
     * @param $log_id type integer
     * @param $old_bed_no type integer
     * @param $admission_id type integer
     */
    public function updatepatinetlog($machine_value, $log_id, $old_bed_no, $baby_id, $admission_id)
    {
        try {
            $log = array();
            if (strpos($machine_value->ward, 'NICU') !== false) {
                $ward_name = 'NICU';
            }
            else
            {
                $ward_name = $machine_value->ward;
            }
            if ($ward_name === null || $ward_name == '') {
                $this->custom_error->emergencyLog('Ward error for baby_id: '. $baby_id .'==========='.$ward_name);
                return false;
            }
            $log['bed_no'] = $machine_value->bed;
            $log['ward_name'] = $machine_value->ward;
            $ward_details = \DB::table('ward')->select('id')->where('name', $ward_name)->first();
            if (!isset($ward_details->id) || empty($ward_details->id)) {
                $this->custom_error->emergencyLog('Ward error for baby_id: '. $baby_id .'==========='.$ward_name);
                return false;
            }
            $log['ward_id'] = $ward_details->id;

            $bed_details = \DB::table('bed')
            ->select('bed.id', 'bed.id as bed_id', 'room_id', 'room.number', 'pump_type', 'hms_bed_id', 'hms_room_id', 'hms_ward_id')
            ->join('room', 'room.id', '=', 'bed.room_id')
            ->join('ward', 'ward.id', '=', 'room.ward_id')
            ->where('bed.number', (int) $machine_value->bed)
            ->first();

            $log['bed_id'] = $bed_details->id;
            $log['room_id'] = $bed_details->room_id;
            $log['room_no'] = $bed_details->number;
            $log['status'] = 'Occupied';
            $log['DateModified'] = Carbon::now($this->time_zone);
            // $log['DateModified'] = date('Y-m-d H:i:s');

            // $checkExistBedLog = \DB::table('patient_bed_log')->where('baby_id', $baby_id)->where('admission_id', $admission_id)->where('status', 'Occupied')->first();
            
            // if (count($checkExistBedLog) > 0) {
            //     \DB::table('bed')->where('number', $checkExistBedLog->bed_id)->update(['status'=> null]);
            // }
            $checkExist = \DB::table('patient_bed_log')->where('bed_no', $log['bed_no'])->where('status', 'Occupied')->first();
            
            if (isset($checkExist->id)) {

                $updateBedLog = \DB::table('patient_bed_log')->where('bed_no', $log['bed_no'])->where('status', 'Occupied')->update(['status' => 'discharged']);
                // $updateBabyAdmission = Admission::where('AdmissionId', $admission_id)->where('BabyId', $baby_id)->update(['Status' => 'Discharged']);
                
                $sheet_details = NurseSheetMain::GetNurseSheet(Carbon::now($this->time_zone)->format('Y-m-d'), $baby_id, $admission_id);

                if (isset($sheet_details->id)) {
                    $sheet_id = $sheet_details->id;
                } else {
                    $dayCount = count(NurseSheetMain::GetNurseSheetCount($baby_id, $admission_id));

                    $sheet_details['day_name'] = 'Day ' . ($dayCount + 1);
                    $sheet_details['sheet_date'] = Carbon::now($this->time_zone)->format('Y-m-d');
                    $sheet_details['baby_id'] = $baby_id;
                    $sheet_details['admission_id'] = $admission_id;
                    $sheet_details['dcp'] = null;
                    $sheet_details['hemolysis'] = null;

                    $sheet_id = NurseSheetMain::create($sheet_details)->id;
                }

                $this->dayWiseBedLog($sheet_id, $baby_id, $admission_id);

            }

            $updateExistBedLog = \DB::table('patient_bed_log')->where('baby_id', $baby_id)->where('status', 'Occupied')->update(['status' => 'discharged']);

            if (isset($updateExistBedLog->bed_no) && isset($updateExistBedLog->room_no)) {
                $bed_number = $updateExistBedLog->bed_no;
                $room_number = $updateExistBedLog->room_no;     
                if ($bed_number != $log['bed_no']) {
                    \SiteHelpers::emptyDashboardData($bed_number, $room_number);
                }
            }

            \DB::table('patient_bed_log')->where('id', $log_id)->update($log);
            \DB::table('bed')->where('number', (int) $old_bed_no)->update(['status'=> null]);
            \DB::table('bed')->where('number', (int) $machine_value->bed)->update(['status'=> 'Occupied']);
            $this->updateSyrangePumpDetails($baby_id, $admission_id, $bed_details->id, $bed_details->pump_type);

            $bed_transfer_data = new Request([
                'bed_mrno' => $machine_value->mrn,
                'bed_ipnumber' => $machine_value->ip_number,
                'hms_bed_id' => $bed_details->hms_bed_id,
                'hms_room_id' => $bed_details->hms_room_id,
                'hms_ward_id' => $bed_details->hms_ward_id,
            ]);

            HmsInterfacingController::transferPatientInHMS($bed_transfer_data);

            return true;
        } catch (Exception $e) {
            $this->custom_error->emergencyLog('failed to create bed log for baby ID:' . $baby_id.' ADMISSION ID'.$admission_id);
            $this->custom_error->emergencyLog($e);
            \DB::rollback();
            return false;
        }
    }
        /**
     * This method is used to create Syrange Pumb log
     *
     * @param $baby_id type integer
     * @param $admission_id type integer
     * @param $mother_id type integer
     */
        public function createSyrangePumb($baby_id, $admission_id, $mother_id, $pump_type = '')
        {
            $syramge_pump = array();
            $syramge_pump['baby_id'] = $baby_id;
            $syramge_pump['admission_id'] = $admission_id;
            $syramge_pump['admission_stauts'] = 0;
            $syramge_pump['mother_id'] = $mother_id;
            if ($pump_type == '') {
                $syramge_pump['pump_type'] = 'cs5';
            }
            else
            {
                $syramge_pump['pump_type'] = $pump_type;
            }
        // \DB::table('syringe_pump_admisson')->insert($syramge_pump);
        }
        /**
     * This method is used to Get and Store Bed log from HMS
     *
     * @param $baby_mrn type integer
     */
        public function checkBedLogFromHMS($baby_mrn, $baby_id, $admission_id)
        {
            $bed_log = array();
        // $visit_number_url = \SiteHelpers::getConfigSettings('GET_CURRENT_VISIT_NUMBER');
        // // $visit_number_url = 'http://172.17.1.17/rasterihmsapi/ihmsctrl.php?getActiveVisitList&mrn=';
        // $client = new \GuzzleHttp\Client();
        // $response = $client->request('GET', $visit_number_url.$baby_mrn, ['http_errors' => false]);
        // $status_code = $response->getStatusCode();
        // if ($status_code != 200) {
        //     $this->custom_error->emergencyLog('HTTP ERROR while get bed results from HMS for MRN :'.$baby_mrn);
        //     return false;
        // }
        // $visit_response = $response->getBody();
        // $visit_response = $visit_response->getContents();
        // $visit_response = collect(json_decode($visit_response)->data)->toArray();


            $client = new \GuzzleHttp\Client();
            $visit_number_url = \SiteHelpers::getConfigSettings('GET_CURRENT_VISIT_NUMBER');
            $settings = Settings::find(1);
            $header_content = [
                'Content-Type' => 'application/json',
                'token' => $settings->hms_token,
            ];

            $response = $client->get($visit_number_url, [
                'headers' => $header_content,
                'query' => ['uhid' => trim($baby_mrn)],
                'http_errors' => false
            ]);

            $visit_response = $response->getBody();
            $visit_response = $visit_response->getContents();
            $status_code = $response->getStatusCode();
            if ($status_code != 200) {
                $this->custom_error->emergencyLog('HTTP ERROR for quering patient info from web HIS for MRN  :'.$baby_mrn.' and received response : '.$visit_response);
                return false;
            }
            $visit_response = collect(json_decode($visit_response)->data)->toArray();


            if ($visit_response[0]->visit_type == 'IP') {
                $bed_log['bed_no'] = ltrim($visit_response[0]->bed, "0");
                $bed_details = \DB::table('bed')->select('room.id as room_id','room.number as room_no','ward.name as ward_name', 'ward.id as ward_id', 'bed.id as bed_id')
                ->join('room', 'room.id', '=', 'bed.room_id')
                ->join('ward', 'ward.id', '=', 'room.ward_id')
                ->where('bed.number', $bed_log['bed_no'])
                ->first();
                if (isset($bed_details->room_id) && isset($bed_details->ward_id)) {
                    $bed_log['bed_id'] = $bed_details->bed_id;
                    $bed_log['room_id'] = $bed_details->room_id;
                    $bed_log['room_no'] = $bed_details->room_no;
                    $bed_log['ward_id'] = $bed_details->ward_id;
                    $bed_log['ward_name'] = $bed_details->ward_name;
                    $bed_log['baby_id'] = $baby_id;
                    $bed_log['admission_id'] = $admission_id;
                    $bed_log['DateAdded'] = date('Y-m-d');
                    $bed_log['DateModified'] = date('Y-m-d H:i:s');
                    $bed_log['status'] = 'Occupied';
                    $checkExistBedLog = BedLog::where('baby_id', $baby_id)->where('admission_id', $admission_id)->orderBy('id', 'desc')->first();
                    if (isset($checkExistBedLog->id)) {
                       if ($checkExistBedLog->bed_id != $bed_log['bed_id']) {
                        BedLog::where('id', $checkExistBedLog->id)->update($bed_log);   
                        \DB::table('bed')->where('id', $checkExistBedLog->bed_id)->update(['status' => null]);
                        \DB::table('bed')->where('id', $bed_log['bed_id'])->update(['status' => 'Occupied']);
                    }
                }
                else
                {
                    BedLog::create($bed_log);
                    \DB::table('bed')->where('id', $bed_log['bed_id'])->update(['status' => 'Occupied']);
                }
                return true;
            }
            else
            {
                $this->custom_error->emergencyLog('Bed deatails not found for this bed :'.$bed_log['bed_no']);
                return false;
            }
        }
    }

    /**
     * This method is used to store HERO score for baby
     *
     * @param $values type array
     */
    // public function storeHeroScore($values)
    // {
    //     $baby_details = BedLog::select('baby.MotherId', 'baby.Sex', 'patient_bed_log.*')->join('baby', 'baby.BabyId', '=', 'patient_bed_log.baby_id')->where('bed_no', $values->bed)
    //     ->where('status', '<>', 'discharged')
    //     ->orderBy('patient_bed_log.id', 'desc')
    //     ->first();

    //     if (!isset($baby_details->baby_id) || empty($baby_details->baby_id)) {
    //         $baby_details = BedLog::select('baby.MotherId', 'baby.Sex', 'patient_bed_log.*')->join('baby', 'baby.BabyId', '=', 'patient_bed_log.baby_id')->where('bed_no', $values->bed)
    //         ->where('status', 'discharged')
    //         ->orderBy('patient_bed_log.DateModified', 'desc')
    //         ->first();
    //     }

    //     if (isset($baby_details->baby_id) && !empty($baby_details->baby_id)) {
    //         $baby_id = $baby_details->baby_id;
    //         $admission_id = $baby_details->admission_id;
    //         $time_issued = $values->start_time;

    //         /*Subtract 1 Hr*/
    //         $time_issued = strtotime('-1 hours', strtotime($time_issued));
    //         $time_issued = date('Y-m-d H:i:s', $time_issued);

    //         $this->custom_error->emergencyLog('HeRO score baby_id===' .$baby_id.'===admission_id===' .$admission_id.'===time_issued===' .$time_issued);

    //         $nurse_date = date('Y-m-d', strtotime($time_issued));
    //         $nurse_time = date('Y-m-d H:i:s', strtotime($time_issued));

    //         $day_sheet_id = ImportFhir::get_nurse_sheet_check($nurse_date, $baby_id, $admission_id);
    //         if (count($day_sheet_id) == 0)
    //         {
    //             $day_sheet_id = $this->createmainday($baby_id, $admission_id, $nurse_date, $nurse_time);
    //         }
    //         else
    //         {
    //             $day_sheet_id = $day_sheet_id->id;
    //             $this->updateLabFlag($day_sheet_id);
    //         }

    //         $emr_log_header = ImportFhir::get_emr_header_checks($nurse_date, $baby_id, $admission_id, $nurse_time);
    //         if (count($emr_log_header) == 0)
    //         {
    //             $header_id = $this->createsheetheader($baby_id, $admission_id, $baby_details,$time_issued, $day_sheet_id);
    //         }
    //         else
    //         {
    //             $header_id = $emr_log_header->id;
    //         }
    //         $this->custom_error->emergencyLog('HeRO score header_id===' .$header_id);

    //         $snomed_code = preg_replace('/[A-Z,a-z,\s,\/,|,%,-,;,(,)]/', '', trim($values->loinc_code));
    //         $get_local_code = ImportFhir::get_nurse_snomed_details($snomed_code)->first();
    //         $local_id = $get_local_code->ref_loc_master_id;
    //         $emr_log_details = ImportFhir::get_nurse_sheet_details($header_id, $nurse_time, $local_id, 'emr_moniter_values',$values->asset_number);

    //         if (count($emr_log_details) > 0 && isset($emr_log_details->id))
    //         {
    //             if ($emr_log_details->intf_ref_value != $values->mean) {
    //                 $sub_sheet_values["intf_ref_value"] = $values->mean;
    //                 $sub_sheet_values["original_intf_ref_value"] = $values->mean;
    //                 $sub_sheet_values["mean"] = $values->mean;
    //                 $sub_sheet_values["modify_user_id"] = 'interface machine';
    //                 $sub_sheet_values["modify_tstamp"] = Carbon::now($this->time_zone);
    //                 \DB::table('emr_moniter_values')->where('id', $emr_log_details->id)->update($sub_sheet_values);
    //             }
    //             // $this->updatelogdtl($emr_log_details->id, $machine_values_value->mean, 'emr_moniter_values', $fhir_calculated_values, $machine_values_value->asset_number);
    //         }
    //         else
    //         {
    //             $sub_sheet_values["log_hdr_id"] = $header_id;
    //             $sub_sheet_values["loinc_local_map_id"] = $local_id;
    //             $sub_sheet_values["intf_ref_value"] = $values->mean;
    //             $sub_sheet_values["original_intf_ref_value"] = $values->mean;
    //             $sub_sheet_values["result_date_time"] = $nurse_time;
    //             $sub_sheet_values["low"] = '0';
    //             $sub_sheet_values["last_quartile"] = '0';
    //             $sub_sheet_values["first_quartile"] = '0';
    //             $sub_sheet_values["mean"] = $values->mean;
    //             $sub_sheet_values["close"] = '0';
    //             $sub_sheet_values["create_user_id"] = 'interface machine';
    //             $sub_sheet_values["create_tstamp"] = Carbon::now($this->time_zone);
    //             $sub_sheet_values["modify_user_id"] = 'interface machine';
    //             $sub_sheet_values["modify_tstamp"] = Carbon::now($this->time_zone);
    //             $sub_sheet_values["device_id"] = $values->asset_number;
    //             \DB::table('emr_moniter_values')->insert($sub_sheet_values);
    //         }
    //         return true;
    //     }
    //     else
    //     {
    //         $baby_details = BedLog::select('baby.MotherId', 'baby.Sex', 'patient_bed_log.*')->join('baby', 'baby.BabyId', '=', 'patient_bed_log.baby_id')->where('bed_no', $values->bed)
    //         ->where('status', 'discharged')
    //         ->orderBy('patient_bed_log.DateModified', 'desc')
    //         ->first();

    //         $this->custom_error->emergencyLog('No Patinet in the bed: ' .$values->bed);
    //         return false;
    //     }
    // }


    public function storeHeroScore($values)
    {


        // $this->custom_error->emergencyLog('HeRO score input :'.json_encode($values));

        if (isset($values->mrn) && !empty($values->mrn)) {

            /*To query baby admission details in patient_bed_log table*/
            $baby_details = BedLog::select('baby.MotherId', 'baby.Sex', 'patient_bed_log.baby_id', 'patient_bed_log.admission_id')
            ->join('baby', 'baby.BabyId', '=', 'patient_bed_log.baby_id')
            ->where('baby.BMrNo', trim($values->mrn))
            ->where('baby.IsDeleted', 0)
            ->orderBy('patient_bed_log.id', 'desc')
            ->first();


            if (count($baby_details) > 0)
            {
                $baby_id = $baby_details->baby_id;
                $admission_id = $baby_details->admission_id;
                $time_issued = $values->start_time;
                
                /*Subtract 1 Hr*/
                $time_issued = strtotime('-1 hours', strtotime($time_issued));
                $time_issued = date('Y-m-d H:i:s', $time_issued);
                
                $this->custom_error->emergencyLog('HeRO score baby_id===' .$baby_id.'===admission_id===' .$admission_id.'===time_issued===' .$time_issued);

                $nurse_date = date('Y-m-d', strtotime($time_issued));
                $nurse_time = date('Y-m-d H:i:s', strtotime($time_issued));
                
                $day_sheet_id = ImportFhir::get_nurse_sheet_check($nurse_date, $baby_id, $admission_id);
                if (count($day_sheet_id) == 0)
                {
                    $day_sheet_id = $this->createmainday($baby_id, $admission_id, $nurse_date, $nurse_time);
                }
                else
                {
                    $day_sheet_id = $day_sheet_id->id;
                    $this->updateLabFlag($day_sheet_id);
                }

                $emr_log_header = ImportFhir::get_emr_header_checks($nurse_date, $baby_id, $admission_id, $nurse_time);
                if (count($emr_log_header) == 0)
                {
                    $header_id = $this->createsheetheader($baby_id, $admission_id, $baby_details,$time_issued, $day_sheet_id);
                }
                else
                {
                    $header_id = $emr_log_header->id;
                }
                $this->custom_error->emergencyLog('HeRO score header_id===' .$header_id);
                
                $snomed_code = preg_replace('/[A-Z,a-z,\s,\/,|,%,-,;,(,)]/', '', trim($values->loinc_code));
                $get_local_code = ImportFhir::get_nurse_snomed_details($snomed_code)->first();
                $local_id = $get_local_code->ref_loc_master_id;
                $emr_log_details = ImportFhir::get_nurse_sheet_details($header_id, $nurse_time, $local_id, 'emr_moniter_values',$values->asset_number);

                if (count($emr_log_details) > 0 && isset($emr_log_details->id))
                {
                    if ($emr_log_details->intf_ref_value != $values->mean) {
                        $sub_sheet_values["intf_ref_value"] = is_float($values->mean) ? number_format($values->mean, 2) : $values->mean;
                        $sub_sheet_values["original_intf_ref_value"] = is_float($values->mean) ? number_format($values->mean, 2) : $values->mean;
                        $sub_sheet_values["mean"] = is_float($values->mean) ? number_format($values->mean, 2) : $values->mean;
                        $sub_sheet_values["modify_user_id"] = $this->monitor_user;
                        $sub_sheet_values["modify_tstamp"] = Carbon::now($this->time_zone);
                        \DB::table('emr_moniter_values')->where('id', $emr_log_details->id)->update($sub_sheet_values);
                    }
                    // $this->updatelogdtl($emr_log_details->id, $machine_values_value->mean, 'emr_moniter_values', $fhir_calculated_values, $machine_values_value->asset_number);
                }
                else
                {
                    $sub_sheet_values["log_hdr_id"] = $header_id;
                    $sub_sheet_values["loinc_local_map_id"] = $local_id;
                    $sub_sheet_values["intf_ref_value"] = is_float($values->mean) ? number_format($values->mean, 2) : $values->mean;
                    $sub_sheet_values["original_intf_ref_value"] = is_float($values->mean) ? number_format($values->mean, 2) : $values->mean;
                    $sub_sheet_values["result_date_time"] = $nurse_time;
                    $sub_sheet_values["low"] = '0';
                    $sub_sheet_values["last_quartile"] = '0';
                    $sub_sheet_values["first_quartile"] = '0';
                    $sub_sheet_values["mean"] = is_float($values->mean) ? number_format($values->mean, 2) : $values->mean;
                    $sub_sheet_values["close"] = '0';
                    $sub_sheet_values["create_user_id"] = $this->monitor_user;
                    $sub_sheet_values["create_tstamp"] = Carbon::now($this->time_zone);
                    $sub_sheet_values["modify_user_id"] = $this->monitor_user;
                    $sub_sheet_values["modify_tstamp"] = Carbon::now($this->time_zone);
                    $sub_sheet_values["device_id"] = $values->asset_number;
                    \DB::table('emr_moniter_values')->insert($sub_sheet_values);
                }
                return true;
            }
            else
            {
                $this->custom_error->emergencyLog('Couldn\'t find baby id for MRN : '.$values->mrn.' to store HeRO score');
                return false;
            }

        }
        else
        {
            $this->custom_error->emergencyLog('MRN is not valid to store HeRO score : '.$values->mrn);
            return false;
        }
    }


    /**
     * This method is used to update twin baby birth order and pregnancy details based on mother id and DOB
     *
     * @param $mother_id type int
     *
     * @param $dob type date
     */
    public function updateTwinBaby($mother_id, $dob, $preganancy_types, $currently_baby_count)
    {
        $twin_update['MultiplePregnancy'] = 'Yes';
        $twin_update['MultiplePregnancyType'] = $preganancy_types;
        $twin_update['Noofbabies'] = $currently_baby_count;
        $twin_update['BirthOrder'] = NULL;
        \DB::table('baby')->where('MotherId', $mother_id)->where('DOB', $dob)->update($twin_update);
    }

    /**
     * This method is used to update pump admission details based on bed and device type
     *
     * @param $bed_id type int
     *
     * @param $device_type type char
     *
     * @param $baby_id type int
     *
     * @param $admission_id type int
     */
    public function updateSyrangePumpDetails($baby_id, $admission_id, $bed_id, $pump_type = '')
    {
        $check_exist_syrange_pump_details = ImportFhir::getSyrangePump($baby_id, $admission_id, $pump_type);
        $syramge_pump = array();
        $syramge_pump['baby_id'] = $baby_id;
        $syramge_pump['admission_id'] = $admission_id;
        $syramge_pump['admission_stauts'] = 0;
        // $syramge_pump['mother_id'] = $mother_id;
        if ($pump_type == '') {
            $syramge_pump['pump_modal'] = 'cs5';
        }
        else
        {
            $syramge_pump['pump_modal'] = $pump_type;
        }
        if (isset($check_exist_syrange_pump_details->id) && !empty($check_exist_syrange_pump_details->id)) {
            \DB::table('syringe_pump_admisson')->where('id', $check_exist_syrange_pump_details->id)->update($syramge_pump);
        }
        else
        {
            \DB::table('syringe_pump_admisson')->insert($syramge_pump);
        }
        return true;
        
    }
    
    public function updateLabFlag($day_id)
    {
        \DB::table('nurse_main_sheet')->where('id', $day_id)->update(['lab_flag'=>0]);
    }
}
