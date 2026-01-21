<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Nurse\EmrLogDetails;
use Carbon\Carbon;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Models\Settings\Settings;
use App\Models\Baby;
use App\Models\Mother;
use App\Models\Admission;
use App\Models\IpNumber;
use App\Models\Nicu;
use App\Models\Ward\BedLog;
use App\Models\Masters\Bed;
use App\Http\Controllers\Fhir\HmsInterfacingController;
use App\Http\Controllers\Fhir\FhirFormateController;
use App\Models\Nurse\SyringePumpAdmisson;
use App\Models\Nurse\NurseSheetMain;
use App\Models\Nurse\DayWisePatientBedLog;
use App\Http\Controllers\Nurse\NurseSheetController;
use App\Events\WardEvent;
use App\Events\DashboardEvent;
use App\Http\Controllers\Fhir\PrescriptionToMirthController;

class NicuDashboardController extends Controller 
{

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->custom_error = new ErrorLogController();
		$this->time_zone = env('TIME_ZONE');
		$this->iomt_user = 1;
	}

	/**
	 * Construct data for NICU dashboard.
	 *
	 * @return Response
	 */
	public static function updateDashboardData()
	{
		$results = \DB::table('nicu_dashboard_results')->where('need_data', true)->get();

		if (count($results) > 0) {
			
			// $basic_details_local_code = array(
			// 	'current_weight', 'working_weight', 'et_size','ngt_size'
			// );

			/*44 - SPO2, 34-Peripheral Temp, 35-Heart Rate, 36-Respiratory Rate, 38- CUFF SYS BP, 39- CUFF DIA BP, 40- CUFF MEAN BP  */
			$monitor_local_ids = ['44', '34', '35', '36', '38', '39', '40', '41', '42', '43'];
			$monitor_local_ids_with_codes = array(
				"38" => "cuff_systalic_bp", 
				"39" => "cuff_diastolic_bp",
				"40" => "cuff_mean_bp",
				"41" => "arterial_systalic_bp", 
				"42" => "arterial_diastolic_bp",
				"43" => "arterial_mean_bp",
				"35" => "hr", 
				"36" => "rr", 
				"44" => "spo2", 
				"34" => "temp" 
			);

			/*219 - Hemoglobin, 265 - WBC,  245 - Platelets, '253 - Direct Bilirubin, 238 - Total Bilirubin, 290 - CRP, 311 - Blood Gas Calcium, 310 - Blood Gas Methemoglobin, 309 - Blood Gas Blood Sugar, 308 - Blood Gas Bilirubin, 307 - Blood Gas Lactate, 306 - Blood Gas PCV, 305 - Blood Gas HB, 304 - Blood Gas Cl, 303 - Blood Gas K, 302 - Blood Gas Na, 301 - Blood Gas BE, 300 - Blood Gas HCO3, 299 - Blood Gas Paco2, 298 - Blood Gas Pco2, 298 - Blood Gas pH*/

			$lab_local_ids = ['219', '265', '245', '253', '238', '236', '290', '298', '299', '300','301', '302', '303', '304', '305', '306', '307', '308', '309', '310', '311', '210', '297'];

			$lab_local_ids_with_codes = array(
				"219" => "hbVal", 
				"290" => "crpVal",
				"265" => "wccVal",
				"" => "cultureVal", 
				"236" => "glugoseVal",
				"245" => "plateletVal", 
				"253" => "bilirubinVal", 
        									// "238" => Total Bilirubin, 
			);

			$blood_gas_local_ids_with_codes = array(
				"303" => "k",
				"301" => 'be',
				"304" => "cl",
				"302" => "na",
				"297" => "ph",
				"298" => "po2",
				"300" => "hco3",
				"299" => "pco2", 
				"310" => "methHb",
				"309" => "glucose",
				"307" => "lactate",
				"308" => "bilirubin",
				"210" => "latestAbg",
        								// "311" => "calcium",
    									// "306" => "pcv",
    									// "305" => "hb",
			);
			/*36 - Respiratory Rate  */
			$manual_local_ids = ['36'];

			$table_headers = array(
				"HR",
				"RR",
				"SpO2(%)",
				"BP (mmHg)",
				"Temp(&#8457;)"
			);

			$tcp_local_ids = ['282', '283', '314', '315'];

			$tcp_local_ids_with_codes = array(
				"282" => "nirs1",
				"283" => 'nirs2',
				"314" => 'tcpo2',
				"315" => 'tcpCo2'
			);

            // ICON
			$tfc_local_ids = ['', '', '', '', '', '', '', '', '', '', ''];

			$tfc_local_ids_with_codes = array(
				"" => "ci",
				"" => 'si',
				"" => 'cpi',
				"" => 'ftc',
				"" => 'str',
				"" => 'svv',
				"" => 'tfc',
				"" => 'vic',
				"" => 'icon',
				"" => 'svri'
			);

			$resp_local_ids = ['48', '51', '81', '296' , '56', '47', '54', '50', '55', '57', '49', '52', '113', '82', '141', '58', '279', '53', '36'];

			$resp_local_ids_with_codes = array(
				"51" => 'MAP',
				"56" => 'Freq.',
				"48" => "&#x394;P",
				"47" => 'Mode',
				"54" => 'Rate',
				"50" => 'PEEP',
				"55" => 'IT (%)',
				"57" => 'IT (S)',
				"113" => 'VT',
				"58" => 'IE RATIO',
				"279" => 'Measured Ti',
				"53" => 'FLOW',
				"36" => 'RR',
				"49" => 'PIP (S)',
				"141" => 'PIP (D)',
				// "52" => 'FiO₂ (S)',
				"52" => 'FiO2 (S)',
				// "296" => 'FiO₂ (D)',
				"296" => 'FiO2 (D)',
				"81" => 'TTV',
				"82" => 'DTV',
			);

			$intake_local_ids = ['84', '91', '90', '89', '87', '93'];

			$intake_local_ids_with_codes = array(
				"84" => "milk",
				"91" => 'drugs',
				"90" => 'fluid',
				"89" => 'ivFluids',
				"87" => 'products',
				"93" => 'totalIntake'
			);

			$output_local_ids = ['144', '143', '146', '142', '100', '355'];

			$output_local_ids_with_codes = array(
				"144" => "blood",
				"143" => 'urine',
				// "145" => 'drains_r',
				// "146" => 'drains_l',
				"146" => 'drains',
				"142" => 'aspirates',
				"100" => 'stoolFreq',
				"355" => 'totalOutput',
			);

			$inhaled_local_ids = ['', '', ''];

			$inhaled_local_ids_with_codes = array(
				"" => 'inhaledNo',
				"" => 'hypothermia',
				"" => 'intensivePT'
			);

			foreach ($results as $key => $value) {
				$load = sys_getloadavg();
				// if ($load[0] <= '5') {

					$patient_result = $patient_info = $weight_info = $blood_info = $table_values = $table_info = $lab_results = $lab_info = $abg_info = $xray_info = $mri_ct_info = $page_info = $tcp_info = $resp_info = $intake_info = $output_info = $tfc_info = $inhaled_info = $current_problem_info = $previous_problem_info = array();

					$baby_details = \DB::table('patient_bed_log')
					->select('patient_bed_log.baby_id', 'patient_bed_log.admission_id', 'baby.BabyName', 'baby.Gestation', 'baby.Sex','baby.BirthWeight', 'baby.BabyBloodGroup', 'baby.DOB', 'baby.TOB_TIME', 'baby.TOB_MINS', 'baby.TOB_AM', 'baby.BMrNo', 'mother.MotherBloodGroup', 'mother.MotherName', 'mother.MotherName', 'nicu_admission.AdmissionDate','nicu_admission.AdmissionTime', 'nicu_admission.AdmissionTime_MINS','nicu_admission.AdmissionTime_AM','ip_numbers.ip_number', 'patient_bed_log.bed_id', 'patient_bed_log.bed_no', 'room.number as room_no')
					->join('baby','baby.BabyId', '=', 'patient_bed_log.baby_id')
					->join('mother','mother.MotherId', '=', 'baby.MotherId')
					->join('nicu_admission','nicu_admission.AdmissionId', '=', 'patient_bed_log.admission_id')
					->join('ip_numbers','ip_numbers.AdmissionId', '=', 'patient_bed_log.admission_id')
					->join('bed','bed.number', '=', 'patient_bed_log.bed_no')
					->join('room','room.id', '=', 'bed.room_id')
					->where('bed_no', $value->bed)
					->where('patient_bed_log.status', 'Occupied')
					->orderBy('patient_bed_log.id', 'desc')
					->first();
					if (isset($baby_details->baby_id)) {
						// $basic_details = EmrLogDetails::Getpreviousbasic($basic_details_local_code, $baby_details->admission_id)
						// ->pluck('intf_ref_value', 'local_code')
						// ->toArray();

						$header_details = \DB::table('nurse_main_sheet')
						->select('dcp', 'hemolysis', 'current_weight', 'working_weight', 'total_input', 'total_output', 'total_input_ml_per_kg', 'total_output_ml_per_kg')
						->where(['baby_id'=>$baby_details->baby_id, 'admission_id'=> $baby_details->admission_id])
						->orderBy('sheet_date', 'desc')
						->first();

						$temp_monitor_local_ids = array_merge($monitor_local_ids, $tcp_local_ids);

						$monitor_values = \DB::table('emr_moniter_values')
						->selectRaw('DISTINCT ON (loinc_local_map_id) loinc_local_map_id')
						->selectRaw('CASE WHEN loinc_local_map_id = 282 THEN intf_ref_value|| \' % \' WHEN loinc_local_map_id = 283 THEN intf_ref_value|| \' % \' ELSE intf_ref_value END as intf_ref_value')
						->addselect( 'mean', 'first_quartile', 'last_quartile', 'close', 'loinc_local_map_id', 'result_date_time','low')
						->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_moniter_values.log_hdr_id')
						->whereIn("loinc_local_map_id", $temp_monitor_local_ids)
						->whereNotNull("result_date_time")
						->where('emr_log_hdr.admission_id', $baby_details->admission_id)
              			->whereRaw("emr_moniter_values.result_date_time > NOW() - INTERVAL '90 minutes'")
						->orderBy("loinc_local_map_id", 'desc')
						->orderBy("result_date_time", 'desc')
						->get();
						$high_result = $mean_result = $low_result = array(); 

						$high_result = $monitor_values->pluck('close', 'loinc_local_map_id')->toArray();
						$low_result = $monitor_values->pluck('low', 'loinc_local_map_id')->toArray();
						$mean_result = $monitor_values->pluck('mean', 'loinc_local_map_id')->toArray();

						$high_result = self::changeKeys($high_result, $monitor_local_ids_with_codes);
						$mean_result = self::changeKeys($mean_result, $monitor_local_ids_with_codes);
						$low_result = self::changeKeys($low_result, $monitor_local_ids_with_codes);

						$high_result['label'] = 'High';
						$mean_result['label'] = 'Median';
						$low_result['label'] = 'Low';

						$tcp_result = $monitor_values->whereIn('loinc_local_map_id', $tcp_local_ids)->pluck('intf_ref_value', 'loinc_local_map_id')->toArray();

						$tcp_info = self::changeKeys($tcp_result, $tcp_local_ids_with_codes, false);

						$resp_values = \DB::table('emr_ventilator_values')
						->selectRaw('DISTINCT ON (loinc_local_map_id) loinc_local_map_id')
						->selectRaw('CASE WHEN loinc_local_map_id = 296 THEN intf_ref_value|| \'\' WHEN loinc_local_map_id = 81 THEN intf_ref_value|| \' ml/kg \' ELSE intf_ref_value END as intf_ref_value')
						->addselect('result_date_time', 'emr_ventilator_values.device_id', 'local_code', 'approval_parameter_priority', 'emr_log_hdr.id')
						->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_ventilator_values.log_hdr_id')
						->join('local_code_group', 'emr_ventilator_values.loinc_local_map_id', '=', 'local_code_group.id')
						->where('emr_log_hdr.admission_id', $baby_details->admission_id)
              			->whereRaw("emr_ventilator_values.result_date_time > NOW() - INTERVAL '90 minutes'")
						->where('intf_ref_value', '<>', 'Standby')
						->where('intf_ref_value', '<>', '')
						->whereNotNull("intf_ref_value")
						->whereIn("loinc_local_map_id", $resp_local_ids)
						->orderBy("loinc_local_map_id", 'desc')
						->orderBy("result_date_time", 'desc')
						->get()
						->groupBy('id')
						->first();

						if (count($resp_values) > 0) {
							$resp_list = $resp_values->groupBy('loinc_local_map_id');
							if (isset($resp_list[47])) {

								$ventilation_mode = $resp_list[47][0]->intf_ref_value;
								$device_id = $resp_list[47][0]->device_id;
	                    		$ventilator_value_filtered = \DeviceHelpers::getVentilatorvaluesByMode($ventilation_mode, $device_id);
	                    		$ventilator_value_list = $resp_values->sortBy('approval_parameter_priority')->whereIn('local_code', $ventilator_value_filtered);
	                    		$ventilation_values = $ventilator_value_list->where('loinc_local_map_id', '<>', '47')->pluck('intf_ref_value', 'loinc_local_map_id')->toArray();
								$temp_resp_info = self::changeKeys($ventilation_values, $resp_local_ids_with_codes);

							}
						}

						$resp_info['respValues'] = isset($temp_resp_info) ? $temp_resp_info : [];
						$resp_info['respMode'] = isset($ventilation_mode) ? $ventilation_mode : '';
						$resp_info['respSupport'] = 'Today';

						$temp_manual_local_ids = array_merge($manual_local_ids, $intake_local_ids, $output_local_ids);

						$manual_values = \DB::table('emr_nurse_manual_values')
						->selectRaw('DISTINCT ON (loinc_local_map_id) loinc_local_map_id')
						->selectRaw('CASE WHEN loinc_local_map_id != 100 THEN intf_ref_value|| \' ml \' ELSE intf_ref_value END as intf_ref_value')
						->addselect('result_date_time')
						->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_nurse_manual_values.log_hdr_id')
						->whereIn("loinc_local_map_id", $temp_manual_local_ids)
						->where('emr_log_hdr.admission_id', $baby_details->admission_id)
						->orderBy("loinc_local_map_id", 'desc')
						->orderBy("result_date_time", 'desc')
						->get();

						$intake_result = $manual_values->whereIn('loinc_local_map_id', $intake_local_ids)->pluck('intf_ref_value', 'loinc_local_map_id')->toArray();

						$intake_info = self::changeKeys($intake_result, $intake_local_ids_with_codes);

						$output_result = $manual_values->whereIn('loinc_local_map_id', $output_local_ids)->pluck('intf_ref_value', 'loinc_local_map_id')->toArray();

						$output_info = self::changeKeys($output_result, $output_local_ids_with_codes);

						$urine_output_hour = '';
						if (isset($baby_details->admission_id) && isset($header_details->current_weight)) {
							$urine_output_hour = \ValuelistHelpers::urineOutputHour($baby_details->admission_id, $header_details->current_weight);
						}

						$lab_values = \DB::table('emr_lab_values')
						->selectRaw('DISTINCT ON (loinc_local_map_id) loinc_local_map_id')
						->addselect('intf_ref_value', 'loinc_local_map_id', 'result_date_time')
						->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_lab_values.log_hdr_id')
						->where('emr_log_hdr.admission_id', $baby_details->admission_id)
						->whereIn("loinc_local_map_id", $lab_local_ids)
						->orderBy("loinc_local_map_id", 'desc')
						->orderBy("result_date_time", 'desc')
						->get();

						$yesterday_date = Carbon::now()->subDay()->format('Y-m-d') . ' 00:00:00';
						$tomorrow_date = Carbon::now()->addDays(1)->format('Y-m-d') . ' 23:59:59';

						// ErrorLogController::emergencyLogStat('CONDITION FOR PREV DAY INOUT baby_id='.$baby_details->baby_id.' admission_id='.$baby_details->admission_id.' sheet_date='.date('Y-m-d', strtotime($yesterday_date)));

						// $yesterday_in_out = \DB::table('nurse_main_sheet')->select('total_input', 'total_output')
						// ->where(['baby_id'=>$baby_details->baby_id, 'admission_id'=> $baby_details->admission_id, 'sheet_date'=> date('Y-m-d', strtotime($yesterday_date))])
						// ->first();

						// ErrorLogController::emergencyLogStat('PREV DAY INOUT='.json_encode($yesterday_in_out));

						$yesterday_header_details = \DB::table('nurse_main_sheet')->select('id', 'total_input', 'total_output', 'total_input_ml_per_kg', 'total_output_ml_per_kg')
						->where(['baby_id'=>$baby_details->baby_id, 'admission_id'=> $baby_details->admission_id])
						->whereRaw("sheet_date = TIMESTAMP 'yesterday'::date")
						->orderBy('sheet_date', 'desc')
						->first();
						$total_output = $total_output_ml_per_kg = $total_input = $total_input_ml_per_kg = '';
						if (isset($yesterday_header_details->total_input)) {
							$total_input = $yesterday_header_details->total_input;
							$total_input_ml_per_kg = $yesterday_header_details->total_input_ml_per_kg;
						}
						if (isset($yesterday_header_details->total_output)) {
							$total_output = $yesterday_header_details->total_output;
							$total_output_ml_per_kg = $yesterday_header_details->total_output_ml_per_kg;
						}

						$intake_info['totalIntake'] = $total_input != '' ? $total_input . ' ml' : '';
						$intake_info['totalIntakeMlKg'] = $total_input_ml_per_kg != '' ? $total_input_ml_per_kg . ' ml/kg/day' : '';
						$output_info['totalOutput'] = $total_output != '' ? $total_output . ' ml' : '';
						$output_info['totalOutputMlKg'] = $total_output_ml_per_kg != '' ? $total_output_ml_per_kg . ' ml/kg/day' : '';
						$output_info['urineOutput'] = $urine_output_hour != '' ? $urine_output_hour . ' ml/kg/h' : '';

						$drugs = \DB::table('prescription_dtl')
						->select(\DB::raw('mas_drugivfluid.brand_name as name'), \DB::raw('prescription_hdr.rate|| \' ml/h\' as value'))
						->addSelect('event_time', 'event_time', \DB::raw("TO_CHAR(event_time,'HH24:00') as time"), \DB::raw("TO_CHAR(event_time,'DD-MM-YYYY') as date"), \DB::raw("TO_CHAR(event_time,'DD-MM-YYYY HH24:00') as event_time"), 'is_send', 'prescription_type')
						->join('prescription_hdr', 'prescription_hdr.id', '=', 'prescription_dtl.pres_hdr_id')
						->join('mas_drugivfluid', 'mas_drugivfluid.id', '=', 'prescription_hdr.brand_name')
						->where('prescription_hdr.admission_id', $baby_details->admission_id)
						->whereNull('prescription_hdr.terminate')
			            ->where('order_status', '<>', 'RS')
			            ->where('order_status', '<>', 'EP')
			            // ->where('is_cancel', '<>', true)
						->whereBetween('prescription_dtl.event_time', [$yesterday_date, $tomorrow_date])
						->orderBy('prescription_dtl.event_time', 'asc')
						->get();

						$medications_date = [date('d-m-Y', strtotime($yesterday_date)), date('d-m-Y'), date('d-m-Y', strtotime($tomorrow_date))];

						$regular_drugs = [];
						$i = 0;

						$temp_regular_drugs = collect($drugs)->where('prescription_type', 1)
						->groupBy('name')
						->map(function($item, $index) use (&$regular_drugs, &$i) {
							$regular_drugs[$i]['drug_name'] = $index;
							$pres_has_active_state = false;
							$sub_list = $item->map(function($sub_list) use (&$pres_has_active_state) {
								$temp_sub_list = (object)[];
								$temp_sub_list->date = $sub_list->date;
								$temp_sub_list->is_send = $sub_list->is_send;
								$temp_sub_list->time = $sub_list->time;
								if ($sub_list->is_send == 0 && !$pres_has_active_state) {
									$pres_has_active_state = true;
									$temp_sub_list->is_send = $sub_list->is_send;
									$temp_sub_list->next_prescription = true;
								}
								return $temp_sub_list;
							});
							$regular_drugs[$i]['sub_list'] = $sub_list->groupBy(['time', 'date'])->toArray();
							$i++;
						})
						->toArray();

						$required_drugs = [];
						$i = 0;
						$temp_required_drugs = collect($drugs)->where('prescription_type', 2)->where('is_send', 0)->sortByDesc('event_time')
						->groupBy('name')
						->map(function($item, $index) use (&$required_drugs, &$i) {
							$required_drugs[$i]['event_time'] = $item->min('event_time');
							$required_drugs[$i]['name'] = $item[0]->name;
							$required_drugs[$i]['value'] = $item[0]->value;
							$i++;
						});

						$infusion_drugs = [];
						$i = 0;
						$temp_infusion_drugs = collect($drugs)->where('prescription_type', 3)->where('is_send', 0)->sortByDesc('event_time')
						->groupBy('name')
						->map(function($item, $index) use (&$infusion_drugs, &$i) {
							$infusion_drugs[$i]['event_time'] = $item->min('event_time');
							$infusion_drugs[$i]['name'] = $item[0]->name;
							$infusion_drugs[$i]['value'] = $item[0]->value;
							$i++;
						});

						$current_running_drugs = \DB::table('prescription_dtl')
						->select(\DB::raw('DISTINCT ON (mas_drugivfluid.brand_name) mas_drugivfluid.brand_name as name'), \DB::raw('prescription_hdr.rate|| \' ml/h\' as value'))
						->join('prescription_hdr', 'prescription_hdr.id', '=', 'prescription_dtl.pres_hdr_id')
						->join('mas_drugivfluid', 'mas_drugivfluid.id', '=', 'prescription_hdr.brand_name')
						->where('prescription_hdr.admission_id', $baby_details->admission_id)
						->where('prescription_type', '<>', 1)
						->where('prescription_dtl.is_send', '5')
						->whereNull('prescription_hdr.terminate')
			            ->where('order_status', '<>', 'RS')
			            ->where('order_status', '<>', 'EP')
			            // ->where('is_cancel', '<>', true)
						->orderBy('mas_drugivfluid.brand_name', 'asc')
						->get();

						$get_cxr_result = \DB::table('daycare')
						->select('CXRFindings', 'DayDate')
						->where('AdmissionId', $baby_details->admission_id)
						->whereNotNull('CXRFindings')
						->where('CXRFindings','!=','')
						->orderBy('DayDate', 'desc')
						->first();

						$get_axr_result = \DB::table('daycare')
						->select('AxrFindings', 'DayDate')
						->where('AdmissionId', $baby_details->admission_id)
						->whereNotNull('AxrFindings')
						->where('AxrFindings', '!=', '')
						->orderBy('DayDate', 'desc')
						->first();

						$get_mri_ct_result = \DB::table('daycare_questions')
						->select('mrict_brain_status', 'mri_ct_brain', 'DateAdded')
						->where('AdmissionId', $baby_details->admission_id)
						->where('mrict_brain_status', '2')
						->get();

						$current_problem_results = \DB::table('daycare')
						->select(\DB::raw('TRIM("CurrentProblems") AS current_problems'))
						->where('AdmissionId', $baby_details->admission_id)
						->where('CurrentProblems', '<>', '')
						->orderBy('DayDate', 'desc')
						->limit(1)
						->get()
						->pluck('current_problems')
						->toArray();

						$previous_problem_results = \DB::table('daycare')
						->select(\DB::raw('TRIM("PreviousProblems") AS previous_problems'))
						->where('AdmissionId', $baby_details->admission_id)
						->where('PreviousProblems', '<>', '')
						->orderBy('DayDate', 'desc')
						->limit(1)
						->get()
						->pluck('previous_problems')
						->toArray();

						$current_problem_results = array_filter($current_problem_results);

						foreach ($current_problem_results as $problem_key => $problem_value) {
							$temp_value = explode('||', $problem_value);
							$current_problem_info = array_merge($current_problem_info, $temp_value);
						}

						$previous_problem_results = array_filter($previous_problem_results);

						foreach ($previous_problem_results as $problem_key => $problem_value) {
							$temp_value = explode('||', $problem_value);
							$previous_problem_info = array_merge($previous_problem_info, $temp_value);
						}

						$blood_info['dct'] 			= isset($header_details->dcp) ? $header_details->dcp : '';
						$blood_info['baby'] 		= isset($baby_details->BabyBloodGroup) ? $baby_details->BabyBloodGroup : '';
						$blood_info['mother'] 		= isset($baby_details->MotherBloodGroup) ? $baby_details->MotherBloodGroup : '';
						$blood_info['haemolysis'] 	= isset($header_details->hemolysis) ? $header_details->hemolysis : '';

						array_push($table_values, $high_result);
						array_push($table_values, $mean_result);
						array_push($table_values, $low_result);

						$table_info['values'] = $table_values;
						$table_info['headers'] = $table_headers;
						
						foreach ($lab_values as $lab_key => $lab_value) {
							if (isset($lab_local_ids_with_codes[$lab_value->loinc_local_map_id])) {
								$lab_info[$lab_local_ids_with_codes[$lab_value->loinc_local_map_id]] = $lab_value->intf_ref_value;
								$lab_info[str_replace('Val', 'Day', $lab_local_ids_with_codes[$lab_value->loinc_local_map_id])] = self::checkDiffDatesFormat(date('Y-m-d', strtotime($lab_value->result_date_time)));
							}
							elseif(isset($blood_gas_local_ids_with_codes[$lab_value->loinc_local_map_id]))
							{
								$abg_info[$blood_gas_local_ids_with_codes[$lab_value->loinc_local_map_id]] = $lab_value->intf_ref_value;
							}
						}

						if (isset($get_cxr_result->CXRFindings) && !empty($get_cxr_result->CXRFindings)) {
							$xray_result = array(
								"desc" => $get_cxr_result->CXRFindings,
								"day" => self::checkDiffDatesFormat($get_cxr_result->DayDate)
							);
							array_push($xray_info, $xray_result);
						}
						
						if (isset($get_axr_result->AxrFindings) && !empty($get_axr_result->AxrFindings)) {
							$xray_result = array(
								"desc" => $get_axr_result->AxrFindings,
								"day" => self::checkDiffDatesFormat($get_axr_result->DayDate)
							);
							array_push($xray_info, $xray_result);
						}


						foreach ($get_mri_ct_result as $mri_key => $mri_value) {
							if (isset($mri_value->mri_ct_brain) && !empty($mri_value->mri_ct_brain)) {
								$mri_ct_result['desc'] = $mri_value->mri_ct_brain;
								$mri_ct_result['day'] = self::checkDiffDatesFormat(date('Y-m-d', strtotime($mri_value->DateAdded)));
								array_push($mri_ct_info, $mri_ct_result);
							}
						}

						$weekly_request = new Request();
        				$weekly_request['from_dashboard'] = true;

						$weekly_data = NurseSheetController::getWeeklyObservations(\SiteHelpers::encrypt_id($baby_details->admission_id), '', $weekly_request);
						
						$page_info['respSupport']['tcpInfo'] = count($tcp_info) > 0 ? $tcp_info : (object)$tcp_info;
						$page_info['respSupport']['tfcInfo'] = count($tfc_info) > 0 ? $tfc_info : (object)$tfc_info;
						$page_info['respSupport']['respInfo'] = count($resp_info) > 0 ? $resp_info : (object)$resp_info;
						$page_info['respSupport']['intakeInfo'] = count($intake_info) > 0 ? $intake_info : (object)$intake_info;
						$page_info['respSupport']['outputInfo'] = count($output_info) > 0 ? $output_info : (object)$output_info;
						$page_info['respSupport']['inhaledInfo'] = count($inhaled_info) > 0 ? $inhaled_info : (object)$inhaled_info;
						$page_info['respSupport']['weeklyInfo'] = $weekly_data;

						$page_info['labAndScanInfo']['mri'] = $mri_ct_info;
						$page_info['labAndScanInfo']['xray'] = $xray_info;
						$page_info['labAndScanInfo']['ctScan'] = $mri_ct_info;
						$page_info['labAndScanInfo']['abgInfo'] = count($abg_info) > 0 ? $abg_info : (object)$abg_info;
						$page_info['labAndScanInfo']['labInvestigation'] = count($lab_info) > 0 ? $lab_info : (object)$lab_info;

						$page_info['medications']['currentMedications'] = $current_running_drugs;
						$page_info['medications']['regularMedications']['date'] = $medications_date;
						$page_info['medications']['regularMedications']['items'] = $regular_drugs;
						$page_info['medications']['requiredMedications'] = $required_drugs;
						$page_info['medications']['infusionMedications'] = $infusion_drugs;

						$patient_info['mrn'] = $baby_details->BMrNo; 
						$patient_info['ipNo'] = $baby_details->ip_number; 					
						$patient_info['gender'] = $baby_details->Sex; 
						if (isset($baby_details->BirthWeight)) {
							$weight_info['atBirth'] = $baby_details->BirthWeight . ' g';
						}
						else
						{
							$weight_info['atBirth'] = '';
						}

						if (isset($header_details->current_weight)) {
							$weight_info['current'] = $header_details->current_weight . ' g';
						}
						else
						{
							$weight_info['current'] = '';
						}

						if (isset($header_details->working_weight)) {
							$weight_info['working'] = $header_details->working_weight . ' g';
						}
						else
						{
							$weight_info['working'] = '';
						}
						$patient_info['weight'] = $weight_info;
						$patient_info['babyName'] = $baby_details->BabyName; 
						$patient_info['pageInfo'] = $page_info; 

						$patient_info['currentProblems'] =  $current_problem_info;
						$patient_info['previousProblems'] =  $previous_problem_info;
						$patient_info['admitDate'] = (isset($baby_details->AdmissionDate) && !empty($baby_details->AdmissionDate)) ? date('d/m/Y', strtotime($baby_details->AdmissionDate)) : null;
						if ($baby_details->AdmissionTime_AM == 'PM' && $baby_details->AdmissionTime != 12) {
							$baby_details->AdmissionTime += 12;
						}
						if ($baby_details->AdmissionTime_AM == 'AM' && $baby_details->AdmissionTime == 12) {
							$baby_details->AdmissionTime = 0;
						}						
						$patient_info['admitTime'] = $patient_info['admitDate'] != null ? substr('0'.$baby_details->AdmissionTime, -2).':'.substr('0'.$baby_details->AdmissionTime_MINS, -2) : null;
						$patient_info['ageInDays'] =  self::checkDiffDatesFormat($baby_details->DOB);
						$patient_info['birthDate'] = date('d/m/Y', strtotime($baby_details->DOB)); 
						$patient_info['birthTime'] =  '';	
						if ($baby_details->TOB_MINS >= 0 && !is_null($baby_details->TOB_AM)) {						
							$baby_details->TOB_MINS = $baby_details->TOB_MINS > 9 ? $baby_details->TOB_MINS : '0'.$baby_details->TOB_MINS;
							$baby_details->TOB_TIME = $baby_details->TOB_AM == 'AM' ? ($baby_details->TOB_TIME == 12 ? 0 : $baby_details->TOB_TIME) : ($baby_details->TOB_TIME == 12 ? $baby_details->TOB_TIME : $baby_details->TOB_TIME + 12);
							$baby_details->TOB_TIME = $baby_details->TOB_TIME > 9 ? $baby_details->TOB_TIME : '0'.$baby_details->TOB_TIME;
							$patient_info['birthTime'] =  $baby_details->TOB_TIME.':'.$baby_details->TOB_MINS;
						}
						$patient_info['bloodInfo'] 	= $blood_info;
						
						$baby_gestation = json_decode($baby_details->Gestation);

						$gestation_weeks = isset($baby_gestation->g_weeks) && !empty($baby_gestation->g_weeks) ? $baby_gestation->g_weeks : 0;
						$gestation_days = isset($baby_gestation->g_days) && !empty($baby_gestation->g_days) ? $baby_gestation->g_days : 0;

						$patient_info['corrected'] = $patient_info['gestation'] = '';
						if($gestation_weeks != 0)
						{

							$patient_info['gestation'] =  $gestation_weeks.'+'.$gestation_days;
							$corrected_gestation =  \SiteHelpers::calculateCorrectedGestation($baby_gestation->g_weeks, $baby_gestation->g_days, $baby_details->DOB, date('Y-m-d'));
							$patient_info['corrected'] = (isset($corrected_gestation['corrected_age_weeks']) ? $corrected_gestation['corrected_age_weeks'] : '').'+'.(isset($corrected_gestation['corrected_age_days']) ? $corrected_gestation['corrected_age_days'] : '');
						}
						$patient_info['tableInfo'] 	= $table_info;
						// $patient_info['ageOnadmission'] =  self::checkDiffDatesFormat($baby_details->DOB, date('Y-m-d', strtotime($baby_details->AdmissionDate)), 'days only');
						// $patient_info['ageOnadmission'] =  self::checkDiffDatesFormat($baby_details->DOB, date('Y-m-d', strtotime($baby_details->AdmissionDate)), 'days only');
						$patient_info['ageOnadmission'] =  self::checkDiffDatesFormat($baby_details->AdmissionDate);

						$patient_result['cotId'] = (Int)$baby_details->bed_no; 
						$patient_result['roomId'] = (Int)$baby_details->room_no; 
						$patient_result['pageNo'] = (Int)$value->page_no;
						$patient_result['patient'] = $patient_info;
						$previous_result_data = json_decode($value->result_data);
						
						if (isset($previous_result_data[0]->pacsInfo) && !empty($previous_result_data[0]->pacsInfo)) {
							$patient_result['pacsInfo'] = $previous_result_data[0]->pacsInfo;
						}
						$patient_result['currentDateTime'] = date('d F - H:i');

						broadcast(new DashboardEvent([$patient_result]))->toOthers();

						\DB::table('nicu_dashboard_results')->where('id', $value->id)->update(['result_data'=>json_encode([$patient_result]), 'need_data'=> false]);
					}
					else
					{
						\DB::table('nicu_dashboard_results')->where('id', $value->id)->update(['need_data'=> false]);
					}

				// }
				// else
				// {
				// 	ErrorLogController::emergencyLogStat('SERVER OVERLOADED (LOAD VALUE======='.$load[0].') at : ' .Carbon::now());
				// 	return false;
				// }
			}
		}
	}

	/**
	 * Store data from IoMT device to update JSON data.
	 *
	 * @return Response
	 */
	public function postIomtRequest(Request $request)
	{
		$input = $request->all();
		$this->custom_error->emergencyLog('IOMT REQUEST values '.json_encode($input).') at : ' .Carbon::now($this->time_zone));
		if (isset($input['status']) && !empty($input['status'])) {
			if (empty($input['page_no'])) {
				$this->custom_error->emergencyLog('ERROR in IoMT Request');			
				return \Response::json(['type' => 'success', 'message' => 'IoMT request completed'], 200);
			}
			$adt_status = $input['status'];
			if ($adt_status == 'ADMITTED') {
				$patient_admit = $this->admitPatient($input['page_no'], $input['bed'], $input['room']);
				if ($patient_admit === true) {
					$this->updateDashboardRequest($input);
					return \Response::json(['type' => 'success', 'message' => 'patient admitted to the bed!'], 200);
				}
				else
				{
					return \Response::json(['type' => 'failure', 'message' => 'couldn\'t admit the patient to the bed...'], 500);
				}

			}
			elseif ($adt_status == 'DISCHARGED') {
				$this->dischargePatient($input['page_no'], $input['bed'], $input['room']);
			}
		}
		$this->updateDashboardRequest($input);
		return \Response::json(['type' => 'success', 'message' => 'IoMT request completed'], 200);
	}


	/**
	 * update dashboard request in nicu_dashboard_results table.
	 *
	 * @return Response
	 */
	public function updateDashboardRequest($input)
	{
		if (isset($input['status'])) {
			unset($input['status']);
		}

		if (isset($input['page_no']) && strlen($input['page_no']) > 5) {
			$input['page_no'] = 1;
		}
		$check_exist = \DB::table('nicu_dashboard_results')->where('bed', $input['bed'])->orderBy('id', 'desc')->first();
		if (count($check_exist) > 0) {
			$check_exist = \DB::table('nicu_dashboard_results')->where('id', $check_exist->id)->update(['need_data'=>true, 'page_no'=>$input['page_no'], 'modify_tstamp'=>date('Y-m-d H:i:s'), 'modify_user_id'=>'IoMT']);
			$this->updateDashboardData();

		}
		else
		{
			$input['page_no'] = $input['page_no'];
			$input['create_tstamp'] = date('Y-m-d H:i:s');
			$input['create_user_id'] = 'IoMT';
			\DB::table('nicu_dashboard_results')->insert($input);
			$this->updateDashboardData();
		}

	}

	/**
	 * Find Different B/W two dates and covert it as customized format.
	 *
	 * @return Response
	 */
	public static function checkDiffDatesFormat($start_date, $end_date='', $format_type = '')
	{
		if ($start_date == '' || $start_date == null) {
			$datework = Carbon::now();
		}
		else
		{
			$datework = Carbon::createFromFormat('Y-m-d', $start_date);
		}
		if ($end_date == '' || $end_date == null) {
			$now = Carbon::now();
		}
		else
		{
			$now = Carbon::createFromFormat('Y-m-d', $end_date);
		}
		$days_different = $datework->diffInDays($now);
		$result = '';
		// if ($format_type == '') {
			if ($days_different == 0) {
				$result = 'Today';
			}
			elseif ($days_different == 1) {
				$result = 'Yesterday';
			}
			else{
				$result = $days_different.' days';
			}
		// }
		// else
		// {
		// 	$days_different = $days_different + 1;
		// 	$result = $days_different.' day(s)';
		// }
		return $result;

	}

	/**
	 * Get dashboard JSON data from Database.
	 *
	 * @return Response
	*/

	public function getDashboardData(Request $request)
	{
		$input = $request->all();
		if (isset($input['bed_no'])) {
			$check_exist = \DB::table('nicu_dashboard_results')->select('result_data')->where('bed', $input['bed_no'])->orderBy('id', 'desc')->first();
			if (isset($check_exist->result_data)) {
				return $check_exist->result_data;
			}
			else
			{
				return '[{"cotId": '.$input["bed_no"].', "pageNo": 1, "roomId": 400, "patient": {"mrn": "", "ipNo": "", "gender": "", "weight": {"atBirth": "", "current": "", "working": ""}, "babyName": "", "pageInfo": {"medications": {"currentMedications": [], "regularMedications": {"date": [], "items": []}, "infusionMedications": [], "requiredMedications": []}, "respSupport": {"tcpInfo": {}, "tfcInfo": {}, "respInfo": {"respSupport": ""}, "intakeInfo": {}, "outputInfo": {}, "inhaledInfo": {}}, "labAndScanInfo": {"mri": [], "xray": [], "ctScan": [], "abgInfo": {}, "labInvestigation": {}}}, "admitDate": "", "admitTime": "", "ageInDays": "", "birthDate": "", "birthTime": "", "bloodInfo": {"dct": "", "baby": "", "mother": "", "haemolysis": ""}, "corrected": "", "gestation": "", "tableInfo": {"values": [{"label": "High"}, {"label": "Median"}, {"label": "Low"}], "headers": ["HR", "RR", "SpO2(%)", "BP (mmHg)", "Temp(&#8457;)"]}, "ageOnadmission": "", "currentProblems": [], "previousProblems": []}, "currentDateTime": ""}]';
			}
		}
		else
		{

			return '[{"cotId": -, "pageNo": 1, "roomId": 400, "patient": {"mrn": "", "ipNo": "", "gender": "", "weight": {"atBirth": "", "current": "", "working": ""}, "babyName": "", "pageInfo": {"medications": {"currentMedications": [], "regularMedications": {"date": [], "items": []}, "infusionMedications": [], "requiredMedications": []}, "respSupport": {"tcpInfo": {}, "tfcInfo": {}, "respInfo": {"respSupport": ""}, "intakeInfo": {}, "outputInfo": {}, "inhaledInfo": {}}, "labAndScanInfo": {"mri": [], "xray": [], "ctScan": [], "abgInfo": {}, "labInvestigation": {}}}, "admitDate": "", "admitTime": "", "ageInDays": "", "birthDate": "", "birthTime": "", "bloodInfo": {"dct": "", "baby": "", "mother": "", "haemolysis": ""}, "corrected": "", "gestation": "", "tableInfo": {"values": [{"label": "High"}, {"label": "Median"}, {"label": "Low"}], "headers": ["HR", "RR", "SpO2(%)", "BP (mmHg)", "Temp(&#8457;)"]}, "ageOnadmission": "", "currentProblems": [], "previousProblems": []}, "currentDateTime": ""}]';
		}
	}

	/**
	 * Calculate Corrected age with gestation and current date
	 *
	 * @return Response
	*/

	public static function calculateCorrectedGestaion($dob, $baby_gestaion, $current_date = '')
	{
		if ($current_date == '') {
			$current_date = Carbon::now();
		}
		else
		{
			$current_date = Carbon::createFromFormat('Y-m-d', $end_date);
		}
		if ($dob != '') {
			$dob = Carbon::createFromFormat('Y-m-d', $dob);
		} else {
			$dob = null;
			return '';
		}
		$chronological_age = $dob->diffInDays($current_date) + 1;
		if (isset($baby_gestaion) && !empty($baby_gestaion)) {
			// code...
			$gestation = json_decode($baby_gestaion);
			$gestation_weeks = !empty($gestation->g_weeks) ? $gestation->g_weeks : 0; 
			$gestation_days = !empty($gestation->g_days) ? $gestation->g_days : 0; 
			if ($gestation_weeks < 37) {
				$corrected_age = $chronological_age - (((40 - $gestation_weeks) * 7) + $gestation_days);
				if ($corrected_age > 0) {
					$corrected_age_weeks = $corrected_age / 7;
					$corrected_age_weeks = (int)$corrected_age_weeks;
					$corrected_age_days = (int) $corrected_age % 7;
					if ($corrected_age_days == 0) {
						return $corrected_age_weeks.' weeks';
					}
					else
					{

						return $corrected_age_weeks.' + '.$corrected_age_days;
					}
				}
				else
				{
					return '';
				}
			}
			else
			{
				return '';
			}
		}
		else
		{
			return '';
		}
	}

	/**
	 * Rename Keys in array element 
	 *
	 * @return array
	*/

	public static function changeKeys($data_array = array(), $map_array = array(), $slug = true)
	{
		$custom_name = false;

		if (isset($data_array[41]) && isset($data_array[42]) && isset($data_array[43])) {
			if ($data_array[41] == 0 && $data_array[42] == 0 && $data_array[43] == 0) {
				$data_array[00] = '';
			}
			else{
				$data_array[00] = $data_array[41] . '/' . $data_array[42] . ' (' . $data_array[43] . ')';
			}
			unset($data_array[41]);
			unset($data_array[42]);
			unset($data_array[43]);
			unset($data_array[38]);
			unset($data_array[39]);
			unset($data_array[40]);
		} elseif (isset($data_array[38]) && isset($data_array[39]) && isset($data_array[40])) {
				if ($data_array[38] == 0 && $data_array[39] == 0 && $data_array[40] == 0) {
					$data_array[00] = '';
				}
				else{
					$data_array[00] = $data_array[38] . '/' . $data_array[39] . ' (' . $data_array[40] . ')';
				}
				unset($data_array[41]);
				unset($data_array[42]);
				unset($data_array[43]);
				unset($data_array[38]);
				unset($data_array[39]);
				unset($data_array[40]);
		}

		if (isset($data_array[49]) && isset($data_array[141])) {
			$data_array[49] = $data_array[141] . '/' . $data_array[49];
			$custom_name = true;
			// unset($data_array[49]);
			unset($data_array[141]);
		}

		if (isset($data_array[52]) && isset($data_array[296])) {
			$data_array[52] = $data_array[296] . '/' . $data_array[52];
			$custom_name = true;
			// unset($data_array[52]);
			unset($data_array[296]);
		}

		if ((isset($data_array[282]) || isset($data_array[283]) || isset($data_array[314]) || isset($data_array[315])) && $slug) {
			unset($data_array[282]);
			unset($data_array[283]);
			unset($data_array[314]);
			unset($data_array[315]);
		}
		$array = array_combine(array_map(function($el) use ($map_array, $custom_name) {
			if ($el == '00') {
				return 'bp';
			}
			if ($el == 49 && !isset($data_array[141]) && $custom_name) {
				return 'PIP (D/S)';
			}
			if ($el == 52 && !isset($data_array[296]) && $custom_name) {
				// return 'FiO₂ (D/S)';
				return 'FiO2 (D/S)';
			}
			return isset($map_array[$el]) ? $map_array[$el] : '';
		}, array_keys($data_array)), array_values($data_array));

		return $array;

	}

	/**
     * This method is used to admit the patient
     * with time
     *
     * @param $mrn type string
     * @param $bed_number type integer
     * @param $room_number type integer
     */
	public function admitPatient($mrn, $bed_number, $room_number)
	{
		try {
			$client = new \GuzzleHttp\Client();

			$settings = Settings::find(1);
			/*Baby create section start*/
	        $check_baby_exist = Baby::get_baby_by_mrn($mrn); // check the baby is in neonatal DB
	        if (isset($check_baby_exist->BabyId) && !empty($check_baby_exist->BabyId)) {
	        	$this->custom_error->emergencyLog('Patient already exist in Neopaed application for MRN : '.$mrn.' and Baby ID : '.$check_baby_exist->BabyId);
	        	$baby_id = $check_baby_exist->BabyId;
	        	$mother_id = $check_baby_exist->MotherId;
	        }
	        else
	        {
	        	// if baby not exist then get from web HIS
	        	$patient_info_url = \SiteHelpers::getConfigSettings('GET_PATIENT_INFO_FROM_HIS');

	        	if (!isset($settings->hms_token) || empty($settings->hms_token)) {
	        		$this->custom_error->emergencyLog('ERROR: Unable to find HIS token from DB...');
	        		return false;
	        	} 

	        	$header_content = [
	        		'Content-Type' => 'application/json',
	        		'token' => $settings->hms_token,
	        	];

	        	$response = $client->get($patient_info_url, [
	        		'headers' => $header_content,
	        		'query' => ['uhid' => trim($mrn)],
	        		'http_errors' => false
	        	]);

	        	$patient_response = $response->getBody();
	        	$patient_response = $patient_response->getContents();
	        	
	        	$status_code = $response->getStatusCode();
	        	if ($status_code != 200) {
	        		$this->custom_error->emergencyLog('HTTP ERROR for quering patient info from web HIS for MRN  :'.$mrn.' and received response : '.$patient_response);
	        		return false;
	        	}

	        	$patient_response = collect(json_decode($patient_response))->toArray();

	        	$collect_baby_count = 0;
	        	$patient_data = $patient_response['data'];

	        	if (isset($patient_data->mobile) && !is_null($patient_data->mobile) && $patient_data->mobile != '') {
	        		$this->custom_error->emergencyLog('Checking multiple pregnancy...');

	        		$check_mulitiple_preg = \DB::table('baby')->join('mother', 'mother.MotherId', '=', 'baby.MotherId')->where('baby.DOB', $patient_data->birth_date)->where('mother.Mobile', $patient_data->mobile)->get()->toArray();
	        		$collect_baby_count = count($check_mulitiple_preg);
	        	}


	        	if ($collect_baby_count > 0 && !is_null($patient_data->mobile) && $patient_data->mobile != '') {

	        		$currently_baby_count = $collect_baby_count + 1;
	        		$preganancy_types = array(2=>'Twins', 3=>'Triplets', 4=>'Quadruplets', 5=>'Quintuplets', 6=>'Sextuplets', 7=>'Septuplets', 8=>'Octuplets');

	        		$mother_id = $check_mulitiple_preg[0]->MotherId;
	        		$baby['MultiplePregnancy'] = 'Yes';
	        		$baby['MultiplePregnancyType'] = $preganancy_types[$currently_baby_count];
	        		$this->custom_error->emergencyLog('Another patient found for this mobile with same DOB... This is '.$preganancy_types[$currently_baby_count].' preganancy type');
	        		$baby['Noofbabies'] = $currently_baby_count;
	        		$this->updateTwinBaby($mother_id, $patient_data->birth_date, $preganancy_types[$currently_baby_count], $currently_baby_count);
	        	}
	        	else
	        	{
	        		$mother['MotherName'] 	= isset($patient_data->patient_name) ? ucfirst(strtolower($patient_data->patient_name)) : null;
	        		$mother['UserAdded'] 	= $this->iomt_user;
	        		$mother['UserModified'] = $this->iomt_user;
	        		$mother['DateAdded'] 	= Carbon::now();
	        		$mother['IsDeleted'] 	= '0';
	        		$mother['Address1'] 	= isset($patient_data->address1) ? $patient_data->address1 : null;
	        		$mother['Address2'] 	= isset($patient_data->address2) ? $patient_data->address2 : null;
	        		$mother['Address3'] 	= isset($patient_data->address3) ? $patient_data->address3 : null;
	        		$mother['City'] 		= isset($patient_data->city) ? $patient_data->city : null;
	        		$mother['Address4'] 	= isset($patient_data->pincode) ? $patient_data->pincode : null;
	        		$mother['Mobile'] 		= isset($patient_data->mobile) ? $patient_data->mobile : null;
	        		$mother_id 				= Mother::create($mother)->MotherId;
	        		$baby['MultiplePregnancy'] = 'No';
	        		$baby['BirthOrder'] = $baby['MultiplePregnancyType'] = 'Singleton';
	        		$this->custom_error->emergencyLog('This baby is Singleton...');

	        	}

	        	$baby['MotherId'] = $mother_id;
	        	$baby['BMrNo'] = trim($mrn);

                $salutation = $patient_data->salutation;
				if ($salutation == 'BABY OF.') {
                    $salutation = 'B/O';
                }
                $baby['BabyName'] = $salutation . ' ' .ucfirst(strtolower($patient_data->patient_name)).' '.ucfirst(strtolower(str_replace(["S/O.", "S/O", "D/O.", "D/O"], "", $patient_data->surname)));
	        	$baby['DOB'] = $patient_data->birth_date;
	        	$baby['Sex'] = ucfirst(strtolower($patient_data->sex));
	        	$baby['UserAdded'] = $this->iomt_user;
	        	$baby['DateAdded'] = Carbon::now();
	        	$baby['IsDeleted'] 	= 0;
	        	$baby['neonatal_consultant'] = env('DEFAULT_NEONATAL_CONSULTANTS');
	        	$baby_id = Baby::create($baby)->BabyId;
	        	$this->custom_error->emergencyLog('New baby created in neopaed ... Baby ID: '.$baby_id);
	        }
	        /*Baby create section end*/
	        


	        /*Admission section start*/
	        //get active visit number from web HIS
	        $visit_number_url = \SiteHelpers::getConfigSettings('GET_CURRENT_VISIT_NUMBER');
	        $header_content = [
	        	'Content-Type' => 'application/json',
	        	'token' => $settings->hms_token,
	        ];

	        $response = $client->get($visit_number_url, [
	        	'headers' => $header_content,
	        	'query' => ['uhid' => trim($mrn)],
	        	'http_errors' => false
	        ]);

	        $visit_response = $response->getBody();
	        $visit_response = $visit_response->getContents();
	        $status_code = $response->getStatusCode();
	        if ($status_code != 200) {
	        	$this->custom_error->emergencyLog('HTTP ERROR for quering patient info from web HIS for MRN  :'.$mrn.' and received response : '.$visit_response);
	        	return false;
	        }
	        $visit_response = collect(json_decode($visit_response)->data)->toArray();
	        $ip_number = '';
	        if (isset($visit_response[0]->visit_type) && $visit_response[0]->visit_type == 'IP') {
	        	$ip_number = $visit_response[0]->visit_no;
	        	$admission_time = $visit_response[0]->admission_time;
	        } else {
	        	$this->custom_error->emergencyLog('ERROR while quering patient visit details info from web HIS for MRN  :'.$mrn);
	        	return false;	        	
	        }
	        if ($ip_number != '' && !is_null($ip_number)) {

	        	$this->custom_error->emergencyLog('Checking the visit number exist in Neopaed application... Visit Number is :'.$ip_number);
	        	$check_visit_number = IpNumber::where('ip_number', $ip_number)->whereNotNull('AdmissionId')->orderBy('id', 'desc')->first();
	        	
	        	$this->custom_error->emergencyLog('Get bed details from Neopaed application... Bed NO is :'.$bed_number);
	        	$bed_details = \DB::table('bed')
	        	->select('room.id as room_id','room.number as room_no','ward.name as ward_name', 'ward.id as ward_id', 'bed.id as bed_id', 'pump_type', 'room.hms_room_id', 'ward.hms_ward_id', 'bed.hms_bed_id')
	        	->join('room', 'room.id', '=', 'bed.room_id')
	        	->join('ward', 'ward.id', '=', 'room.ward_id')
	        	->where('bed.number', $bed_number)
	        	->first();

	        	$his_transfer['bed_mrno'] = $mrn;
	        	$his_transfer['bed_ipnumber'] = $ip_number;
	        	$his_transfer['hms_bed_id'] = $bed_details->hms_bed_id;
	        	$his_transfer['hms_room_id'] = $bed_details->hms_room_id;
	        	$his_transfer['hms_ward_id'] = $bed_details->hms_ward_id;
	        	$his_transfer_request = new Request($his_transfer);
	        	$this->custom_error->emergencyLog('Initiating transfer request to HIS... VISIT NUMBER: '.$ip_number.' and UHID: '.$mrn);
	        	$send_his_transfer_request = HmsInterfacingController::transferPatientInHMS($his_transfer_request);

	        	if (isset($check_visit_number->AdmissionId) && !empty($check_visit_number->AdmissionId)) {

	        		$admission_id = $check_visit_number->AdmissionId;
	        		$this->custom_error->emergencyLog('Visit number exist in Neopaed. ADMISSION ID for this visit is '.$admission_id);
	        		
	        		$this->custom_error->emergencyLog('Update this visit as NICU admission and status as Inpatient');
	        		Admission::where('AdmissionId', $admission_id)->update(['AdmissionType' => 'NICU', 'Status'=> 'Inpatient']);

	        		
	        		/*This functionality is used to send transfer request only patient go transfer in NICU beds*/
	        		/*START*/
	        		// $this->custom_error->emergencyLog('Checking previous bed log entry from Neopaed...');
	        		// $get_previous_bed = BedLog::select('id', 'bed_no')->where('admission_id', $admission_id)->where('status', 'Occupied')->orderBy('DateModified', 'desc')->first();

	        		// if (isset($get_previous_bed->id) && !empty($get_previous_bed->id) && $get_previous_bed->bed_no != $bed_number) {

	        		// 	$this->custom_error->emergencyLog('Checking previous bed log entry from Neopaed...');
	        			
	        		// 	$bed_transfer_data = new Request([
	        		// 		'tbed_name' => $bed_number,
	        		// 		'bed_mrno' => $mrn,
	        		// 		'bed_ipnumber' => $ip_number
	        		// 	]);

	        		// 	HmsInterfacingController::transferPatientInHMS($bed_transfer_data);
	        		// }
	        		/*END*/

	        		$nicu_admission = \DB::table('nicu_admission')->select('NicuId')->where('AdmissionId', $admission_id)->orderBy('NicuId', 'desc')->first();

	        		if (isset($nicu_admission->NicuId)) {
	        			$post = array(
	        				'status' => 'Inpatient',
		        			'DateModified' => Carbon::now($this->time_zone),
		        			'UserModified' => $this->iomt_user
		        		);
						\DB::table('nicu_admission')->where('NicuId', $nicu_admission->NicuId)->update($post);
	        		} else {
	        			/*create NICU admission*/
		        		$nicu_admission = array(
		        			'BabyId' => $baby_id,
		        			'BMrNo' => $mrn,
		        			'AdmissionId' => $admission_id,
		        			'MotherId' => $mother_id,
		        			'AdmissionDate' => (isset($admission_time) && !empty($admission_time)) ? date('Y-m-d', strtotime($admission_time)) : date('Y-m-d'),
		        			'AdmissionTime' => (isset($admission_time) && !empty($admission_time)) ? date('h', strtotime($admission_time)) : date('h'),
		        			'AdmissionTime_MINS' => (isset($admission_time) && !empty($admission_time)) ? date('i', strtotime($admission_time)) : date('i'),
		        			'AdmissionTime_AM' => (isset($admission_time) && !empty($admission_time)) ? date('A', strtotime($admission_time)) : date('A'),
		        			'status' => 'Inpatient',
		        			'DateAdded' => Carbon::now($this->time_zone),
		        			'UserAdded' => $this->iomt_user
		        		);
		        		Nicu::create($nicu_admission);
		        		$this->custom_error->emergencyLog('NICU admission created based on IoMT request for MRN  :'.$mrn. ' VISIT NUMBER: '.$ip_number. ' ADMISSION ID : ' .$admission_id);
	        		}

	        		
	        		$this->custom_error->emergencyLog('Update current bed status as DISCHARGED for previous patients to make this bed available');
	        		BedLog::where('admission_id', $admission_id)->update(['status' => 'discharged', 'DateModified' => date('Y-m-d H:i:s'), 'UserModified' => $this->iomt_user]);

	        		$this->custom_error->emergencyLog('Update current bed status as INPATIENT for current patient to make this bed is occupied by the current patient');

	        		$patient_bed_id = BedLog::select('id')->where('admission_id', $admission_id)->orderBy('id', 'desc')->first();
	        		if (isset($patient_bed_id->id)) {
		        		BedLog::where('id', $patient_bed_id->id)->update(['status' => 'Occupied', 'bed_id' => $bed_details->bed_id, 'bed_no' => $bed_number, 'room_id' => $bed_details->room_id, 'room_no' => $bed_details->room_no, 'ward_id' => $bed_details->ward_id, 'ward_name' => $bed_details->ward_name, 'is_syringe_pump_connected' => true, 'DateModified' => date('Y-m-d H:i:s')]);
		        	} else 
		        	{
	        			$this->custom_error->emergencyLog('Bed no found again this admission id:' . $admission_id);

		        	}

	        		$re_admission_time = Carbon::now()->format('Y-m-d');
            		
	        		$this->custom_error->emergencyLog('get Nurse sheet details for DATE: '.$re_admission_time.' and ADMISSION ID : '.$admission_id);
            		$sheet_details = NurseSheetMain::GetNurseSheet($re_admission_time, $baby_id, $admission_id);

            		if (isset($sheet_details->id)) {
            			$sheet_id = $sheet_details->id;
	        			$this->custom_error->emergencyLog('Sheet details exist and SHEET ID for this date is '.$sheet_id);
            		} else {	

            			$sheet_date = Carbon::now();	

            			$sheet_id = FhirFormateController::createmainday($baby_id, $admission_id, $sheet_date, $sheet_date);

            			// $dayCount = count(NurseSheetMain::GetNurseSheetCount($baby_id, $admission_id));
				        // $this->custom_error->emergencyLog('Day count for this baby ==== ' . $dayCount.' and nurse_time is current time');

				        // if ($dayCount == 0) {
				        //     $working_time = Settings::getPeriod()->period;
				        //     $get_hour = (int) explode(':', $working_time)[0];
				        //     // $nurse_time_hour = (int) date('H');
		            	// 	$nurse_time_hour = (int) date('H', strtotime($admission_time));
				        //     if ($nurse_time_hour < $get_hour) {     
				        // 		$this->custom_error->emergencyLog('');
				        //         $previous_sheet_details['day_name'] = 'Day 0';
				        //         $previous_sheet_details['sheet_date'] = Carbon::now()->subDays(1)->format('Y-m-d');
				        //         $previous_sheet_details['baby_id'] = $baby_id;
				        //         $previous_sheet_details['admission_id'] = $admission_id;
				        //         NurseSheetMain::create($previous_sheet_details);
				        //         $dayCount = 0;
				        //     	$this->custom_error->emergencyLog('Day 0 created for BABY ID === ' . $baby_id);
				        //     }
				        // }
				        // $sheet_details['day_name'] = 'Day ' . ($dayCount + 1);
				        // $sheet_details['sheet_date'] = Carbon::now()->format('Y-m-d');
				        // $sheet_details['baby_id'] = $baby_id;
				        // $sheet_details['admission_id'] = $admission_id;
				        // $sheet_id = NurseSheetMain::create($sheet_details)->id;
				        // $this->custom_error->emergencyLog('Nurse main sheet created for BABY ID = '.$baby_id.' and ADMISSION ID = ' . $admission_id);
		                
				        // $patient_log['day_id'] = $sheet_id;
				        // $patient_log['bed_id'] = isset($bed_details->bed_id) ? $bed_details->bed_id : 0;
				        // $patient_log['created_date_time'] = Carbon::now($this->time_zone);
				        // $patient_log['created_by'] = 0;

				        // DayWisePatientBedLog::create($patient_log);
				        // $this->custom_error->emergencyLog('Daywise patient bed log created');

            		}

            		$check_bed_log = BedLog::select('id', 'status')->where('admission_id', $admission_id)->orderBy('id', 'desc')->first();
		        	BedLog::where('bed_id', $bed_details->bed_id)->update(['status'=>'discharged']);

            		if(isset($check_bed_log->id) && !empty($check_bed_log->id)){
            			$bed_log['bed_id'] = $bed_details->bed_id;
		        		$bed_log['bed_no'] = $bed_number;
		        		$bed_log['room_id'] = $bed_details->room_id;
		        		$bed_log['room_no'] = $bed_details->room_no;
		        		$bed_log['ward_id'] = $bed_details->ward_id;
		        		$bed_log['ward_name'] = $bed_details->ward_name;
		        		$bed_log['DateAdded'] = date('Y-m-d H:i:s');
		        		$bed_log['DateModified'] = date('Y-m-d H:i:s');
		        		$bed_log['status'] = 'Occupied';
            			BedLog::where('id', $check_bed_log->id)->update($bed_log);
            		} else{	            			
	            		/*create bed log*/
		        		$bed_log['bed_id'] = $bed_details->bed_id;
		        		$bed_log['bed_no'] = $bed_number;
		        		$bed_log['room_id'] = $bed_details->room_id;
		        		$bed_log['room_no'] = $bed_details->room_no;
		        		$bed_log['ward_id'] = $bed_details->ward_id;
		        		$bed_log['ward_name'] = $bed_details->ward_name;
		        		$bed_log['baby_id'] = $baby_id;
		        		$bed_log['admission_id'] = $admission_id;
		        		$bed_log['DateAdded'] = date('Y-m-d H:i:s');
		        		$bed_log['DateModified'] = date('Y-m-d H:i:s');
		        		$bed_log['status'] = 'Occupied';
		        		$bed_log['IsDeleted'] = 0;
		        		$bed_log['UserAdded'] = $this->iomt_user;
		        		$bed_log['is_syringe_pump_connected'] = true;
		        		BedLog::create($bed_log);
            		}

	        	}
	        	else
	        	{
	        		$this->custom_error->emergencyLog('Visit number not exist in Neopaed application ===== '.$ip_number);
	        		/*create baby admission*/
	        		$admission_old = Admission::where('BabyId', $baby_id)->count();
	        		$admission_old = $admission_old + 1;
	        		$admission["BMrNo"] = $mrn;
	        		$admission["MotherId"] = $mother_id;
	        		$admission["BabyId"] = $baby_id;
	        		$admission["episodes"] = 'Admission ' . $admission_old;
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
	        		$admission["UserAdded"] = $this->iomt_user;
	        		$admission["DateAdded"] = Carbon::now();
	        		$admission["DateModified"] = Carbon::now();
	        		$admission_id = Admission::create($admission)->AdmissionId;
	        		$this->custom_error->emergencyLog('Baby admission created based on IoMT request for MRN  :'.$mrn. ' VISIT NUMBER: '.$ip_number);
	        		

	        		$this->custom_error->emergencyLog('checking visit number again to confirm the process.....');
	        		$visit_number_is_exist = IpNumber::where('ip_number', $ip_number)->orderBy('id', 'desc')->first();

	        		if (isset($visit_number_is_exist->id)) {
	        			IpNumber::where('id', $visit_number_is_exist->id)->update(['AdmissionId'=>$admission_id]);
	        			$this->custom_error->emergencyLog('VISIT number exist...............');
	        		} else {
	        			$ip_post['baby_id'] = $baby_id;
	        			$ip_post['ip_number'] = $ip_number;
	        			$ip_post['status'] = 1;
	        			$ip_post['DateAdded'] = Carbon::now()->format('Y-m-d');
	        			$ip_post['DateModified'] = Carbon::now()->format('Y-m-d');
	        			$ip_post['AdmissionId'] = $admission_id;
	        			IpNumber::create($ip_post);
	        			$this->custom_error->emergencyLog('new entry created for visit number = '.$ip_number);
	        		}

	        		/*create NICU admission*/
	        		$nicu_admission = array(
	        			'BabyId' => $baby_id,
	        			'BMrNo' => $mrn,
	        			'AdmissionId' => $admission_id,
	        			'MotherId' => $mother_id,
	        			'AdmissionDate' => (isset($admission_time) && !empty($admission_time)) ? date('Y-m-d', strtotime($admission_time)) : date('Y-m-d'),
	        			'AdmissionTime' => (isset($admission_time) && !empty($admission_time)) ? date('h', strtotime($admission_time)) : date('h'),
	        			'AdmissionTime_MINS' => (isset($admission_time) && !empty($admission_time)) ? date('i', strtotime($admission_time)) : date('i'),
	        			'AdmissionTime_AM' => (isset($admission_time) && !empty($admission_time)) ? date('A', strtotime($admission_time)) : date('A'),
	        			'status' => 'Inpatient'
	        		);
	        		Nicu::create($nicu_admission);
	        		$this->custom_error->emergencyLog('NICU admission created based on IoMT request for MRN  :'.$mrn. ' VISIT NUMBER: '.$ip_number. ' ADMISSION ID : ' .$admission_id);

	        		/*create bed log*/
	        		$bed_log['bed_id'] = $bed_details->bed_id;
	        		$bed_log['bed_no'] = $bed_number;
	        		$bed_log['room_id'] = $bed_details->room_id;
	        		$bed_log['room_no'] = $bed_details->room_no;
	        		$bed_log['ward_id'] = $bed_details->ward_id;
	        		$bed_log['ward_name'] = $bed_details->ward_name;
	        		$bed_log['baby_id'] = $baby_id;
	        		$bed_log['admission_id'] = $admission_id;
	        		$bed_log['DateAdded'] = date('Y-m-d H:i:s');
	        		$bed_log['DateModified'] = date('Y-m-d H:i:s');
	        		$bed_log['status'] = 'Occupied';
	        		$bed_log['IsDeleted'] = 0;
	        		$bed_log['UserAdded'] = $this->iomt_user;
	        		$bed_log['is_syringe_pump_connected'] = true;
	        		BedLog::where('bed_id', $bed_details->bed_id)->update(['status'=>'discharged']);
	        		BedLog::create($bed_log);

			        $sheet_details['day_name'] = 'Day 1';
			        if (isset($admission_time) && !empty($admission_time)) {
			        	$sheet_details['sheet_date'] = date('Y-m-d', strtotime($admission_time));
			        }
			        else
			        {
			        	$sheet_details['sheet_date'] = Carbon::now()->format('Y-m-d');
			        }		        
			        $sheet_details['baby_id'] = $baby_id;
			        $sheet_details['admission_id'] = $admission_id;

			        $sheet_id = FhirFormateController::createmainday($baby_id, $admission_id, $admission_time, $admission_time);

			        // $working_time = Settings::getPeriod()->period;
		            // $get_hour = (int) explode(':', $working_time)[0];
		            // $nurse_time_hour = (int) date('H', strtotime($admission_time));
			        // $this->custom_error->emergencyLog('Check this baby admitted before day hour start...for DATE: '.$sheet_details['sheet_date'].' and SHEET STAR HOUR IS : '.$nurse_time_hour);
		            // if ($nurse_time_hour < $get_hour) {     
		        	// 	$this->custom_error->emergencyLog('===================================================================================================================================');
		            //     $previous_sheet_details['day_name'] = 'Day 0';
		            //     $previous_sheet_details['sheet_date'] = Carbon::now()->subDays(1)->format('Y-m-d');
		            //     $previous_sheet_details['baby_id'] = $baby_id;
		            //     $previous_sheet_details['admission_id'] = $admission_id;
		            //     NurseSheetMain::create($previous_sheet_details);
		            //     $dayCount = 0;
		            // 	$this->custom_error->emergencyLog('Day 0 created for BABY ID === ' . $baby_id);
		            // }
			        // $sheet_id = NurseSheetMain::create($sheet_details)->id;
	        	}

		        $patient_log['day_id'] = $sheet_id;
		        $patient_log['bed_id'] = isset($bed_details->bed_id) ? $bed_details->bed_id : 0;
		        $patient_log['created_date_time'] = Carbon::now($this->time_zone);
		        $patient_log['created_by'] = 0;

		        DayWisePatientBedLog::create($patient_log);

	            $syringepump['baby_id']          = $baby_id;
	            $syringepump['mother_id']        = $mother_id;
	            $syringepump['admission_id']     = $admission_id;
	            $syringepump['admission_stauts'] = 0;
		    	$syringepump['pump_modal']       = $bed_details->pump_type;
		    	$syringepump['send_e_gateway_admission']  = true;

	            SyringePumpAdmisson::create($syringepump);
				PrescriptionToMirthController::admission();

		        $event_input['admission_id'] = $admission_id;
		        $event_input['status'] = 'ADMISSION';
            	ErrorLogController::emergencyLogStat('NICU dashboard Admission ' . json_encode($event_input));
		        broadcast(new WardEvent($event_input))->toOthers();
		        \SiteHelpers::updateDashboardAtFormUpdation($baby_id, 'IoMT Admission');

	        }
	        else
	        {
	        	$this->custom_error->emergencyLog('ERROR while quering patient visit details info from web HIS for MRN  :'.$mrn);
	        	return false;
	        }
	        /*Admission section end*/

	        $this->custom_error->emergencyLog('Baby has admitted by using IoMT dashboard, MRN======  :'.$mrn.' and visit number==========='.$ip_number);
	        return true;

	    } catch (Exception $e) {
	    	$this->custom_error->emergencyLog('ERROR: Failed to admit the baby :' . $mrn.' in bed number'.$bed_number);
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
     * This method is used to discharge the patient
     *
     * @param $mrn type string
     * @param $bed_number type integer
     * @param $room_number type integer
     */
    public function dischargePatient($mrn, $bed_number, $room_number) {

    	$baby_admission_details = BedLog::where('bed_no', $bed_number)
    	->orderBy('id', 'desc')
    	->first();
    	if (isset($baby_admission_details->bed_no)) {

    		$patient_bed_log['is_syringe_pump_connected'] = false;
    		$patient_bed_log['status'] = 'discharged';
    		$patient_bed_log['DateModified'] = Carbon::now($this->time_zone);
    		$patient_bed_log['iomt_discharged'] = true;

    		BedLog::where('bed_no', $bed_number)->Update($patient_bed_log);

    		$bed_details = Bed::findorfail($baby_admission_details->bed_id);

    		$syringepump['baby_id']          = $baby_admission_details->baby_id;
    		$syringepump['admission_id']     = $baby_admission_details->admission_id;
    		$syringepump['admission_stauts'] = 4;
    		$syringepump['pump_modal'] = $bed_details->pump_type;

    		SyringePumpAdmisson::create($syringepump);
			PrescriptionToMirthController::admission();

    		$bed_details->Update(['status'=>null]);

            $event_input['status'] = 'DISCHARGE';
            $event_input['admission_id'] = $baby_admission_details->admission_id;
            
            ErrorLogController::emergencyLogStat('NICU dashboard discharged ' . json_encode($event_input));
            
            broadcast(new WardEvent($event_input))->toOthers();

    		\SiteHelpers::emptyDashboardData($bed_number, $room_number);

    		ErrorLogController::emergencyLogStat('Discharged Successfully ('.$mrn.') ! at ' . Carbon::now());

    		return true;

    	}

    	ErrorLogController::emergencyLogStat('Error: Discharged Failed ('.$mrn.') !');

    	return false;

    }
    /**
     * This method is used to get radiology image and store it in JSON
     *
     */
    public function postPACSRequest(Request $request) {
    	$input = $request->all();
    	if (isset($input['studyId']) && !empty($input['studyId']) && $input['studyId'] != "null" && isset($input['seriesId']) && !empty($input['seriesId']) && $input['seriesId'] != 'null' && isset($input['instanceId']) && !empty($input['instanceId']) && $input['instanceId'] != 'null') {
    		$url = parse_url($input['imageUrl']);
    		$study_url = $url['scheme'].'://'.$url['host'].':'.$url['port'].'/'.explode('/', $url['path'])[1].'/WadoImage.do';
    		$input['queryParams'] = 'studyId='.$input['studyId'].'&seriesId='.$input['seriesId'].'&instanceId='.$input['instanceId'];
    		$input['imageUrl'] = $study_url;
    		$updateQuery = 'UPDATE "nicu_dashboard_results" SET result_data = jsonb_set(jsonb_set(result_data, \'{0, pageNo}\', \'4\'), \'{0, pacsInfo}\', \''.json_encode($input).'\', true), page_no = 4 WHERE "bed" = \''.$input['bed'].'\'';
    		\DB::statement($updateQuery);
    		// echo "<pre>"; print_r($updateQuery); exit;
    		$patient_result = \DB::table('nicu_dashboard_results')->select('result_data')->where('bed', $input['bed'])->first();
    		if (isset($patient_result->result_data) && !empty($patient_result->result_data)) {
				broadcast(new DashboardEvent(json_decode($patient_result->result_data, true)))->toOthers();
			}

    		$this->custom_error->emergencyLog('Pacs page request succefully updated and requested params======= ('.json_encode($input).') !');
    	}
    	else
    	{
    		$this->custom_error->emergencyLog('Error: Pacs page equest failed ('.json_encode($input).') !');
    	}
    }

}
