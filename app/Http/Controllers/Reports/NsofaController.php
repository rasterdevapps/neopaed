<?php

namespace App\Http\Controllers\Reports;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use App\Models\Baby;
use App\Models\Reports\NsofaScore;

class NsofaController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:NSOFA,read');
        $this->non_invasive_list = ['SV', 'SVA', 'NPO2', 'HFNC', 'HHHFNC', 'NIPPV', 'NIPPV (D)', 'NIPPV Tr', 'nippv tr', 'CPAP', 'High Flow O2', 'Incubator O2', 'nCPAP (D)', 'BiPAP', 'Nasal HFOV', 'HBO2'];

        $this->invasive_list = ['CMV', 'IMV', 'SIMV', 'PTV', 'PSV', 'HFOV', 'HFO'];

        $this->inotropes = ['DOPAMINE', 'DOBUTAMINE', 'ADRENALIN', 'NORADRENALIN', 'MILRINONE', 'VASOPRESSIN'];
        $this->non_steroid = ['HYDROCORTISONE', 'DEXAMETHASONE', 'METHYL PREDNISOLONE'];
    }

    /**
     * DISPLAY THE RECORDS ACCORDING TO THE FILTERS APPLIED
     *
     */
    public function index(Request $request)
    {
        $baby_id = $request->baby_id;
        if (!empty($baby_id)) {
            $baby_id = \SiteHelpers::decrypt_id($baby_id);
        } else {
            $baby_id = null;
        }
        $navigate['main_nav'] = '';
        $navigate['sub_nav'] = '';

        $babies = Baby::babyListData()->pluck('baby_name_mrn', 'BabyId')->toArray();

        for ($i = 0; $i < 24; $i++) {
            $time = (strlen($i) == 1) ? '0' . $i : $i;
            $hour_24[$time] = $time;
        }

        return view('reports.nsofa.view', compact('babies', 'navigate', 'baby_id', 'hour_24'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $input = $request->all();

        $baby_id = $input['id'];
        $selected_date = date('Y-m-d', strtotime($input['date']));
        $selected_hour = $input['hour'];
        $starting_time = $selected_date . ' ' . $selected_hour . ':00:00';
        $ending_time = $selected_date . ' ' . $selected_hour . ':59:59';

        $mode_of_ventilation = 47;
        $mode_of_ventilation_invasive = 225;
        $preductal_sao2 = 44; 
        $fio2 = 52;
        $delivered_fio2 = 296;

        $ventilator_type = 'Invasive';

        // 47,225,366,52,296
        // 'SV', 'SVA', 'NPO2', 'HFNC', 'HHHFNC', 'NIPPV', 'NIPPV (D)', 'NIPPV Tr', 'CPAP', 'SIMV', 'PTV', 'PSV'
        // $non_invasive_list = ['SV', 'SVA', 'NPO2', 'HFNC', 'HHHFNC', 'NIPPV', 'NIPPV (D)', 'NIPPV Tr', 'nippv tr', 'CPAP', 'High Flow O2', 'Incubator O2', 'nCPAP (D)', 'BiPAP', 'Nasal HFOV', 'HBO2'];

        // $invasive_list = ['CMV', 'IMV', 'SIMV', 'PTV', 'PSV', 'HFOV', 'HFO'];

        $mode_list = array_merge($invasive_list, $non_invasive_list);

        $inpatient_ventilator_hdr_id = \DB::table('emr_log_hdr')
        ->select('emr_log_hdr.id')
        ->leftJoin('emr_ventilator_values', 'emr_log_hdr.id', 'emr_ventilator_values.log_hdr_id')
        ->where('baby_id', $baby_id)
        ->whereBetween('sender_time', [$starting_time, $ending_time])   
        ->whereIn('loinc_local_map_id', [$mode_of_ventilation, $mode_of_ventilation_invasive])
        ->whereIn('intf_ref_value', $invasive_list)
        ->where('intf_ref_value', '<>', '')
        ->orderBy('id', 'desc')
        ->limit(1)
        ->get()
        ->pluck('id')
        ->toArray();

        $discharge_ventilator_hdr_id = \DB::table('emr_log_hdr')
        ->select('emr_log_hdr.id')
        ->leftJoin('emr_ventilator_values_discharged', 'emr_log_hdr.id', 'emr_ventilator_values_discharged.log_hdr_id')
        ->where('baby_id', $baby_id)
        ->whereBetween('sender_time', [$starting_time, $ending_time])   
        ->whereIn('loinc_local_map_id', [$mode_of_ventilation, $mode_of_ventilation_invasive])
        ->whereIn('intf_ref_value', $invasive_list)
        ->where('intf_ref_value', '<>', '')
        ->orderBy('id', 'desc')
        ->limit(1)
        ->get()
        ->pluck('id')
        ->toArray();

        $ventilator_hdr_id = array_merge($inpatient_ventilator_hdr_id, $discharge_ventilator_hdr_id);
        
        if (count($ventilator_hdr_id) == 0) {
            $ventilator_type = 'Non-Invasive';

            $inpatient_ventilator_hdr_id = \DB::table('emr_log_hdr')
            ->select('emr_log_hdr.id')
            ->leftJoin('emr_ventilator_values', 'emr_log_hdr.id', 'emr_ventilator_values.log_hdr_id')
            ->where('baby_id', $baby_id)
            ->whereBetween('sender_time', [$starting_time, $ending_time])   
            ->whereIn('loinc_local_map_id', [$mode_of_ventilation, $mode_of_ventilation_invasive])
            ->whereIn('intf_ref_value', $non_invasive_list)
            ->where('intf_ref_value', '<>', '')
            ->orderBy('id', 'desc')
            ->limit(1)
            ->get()
            ->pluck('id')
            ->toArray();

            $discharge_ventilator_hdr_id = \DB::table('emr_log_hdr')
            ->select('emr_log_hdr.id')
            ->leftJoin('emr_ventilator_values_discharged', 'emr_log_hdr.id', 'emr_ventilator_values_discharged.log_hdr_id')
            ->where('baby_id', $baby_id)
            ->whereBetween('sender_time', [$starting_time, $ending_time])   
            ->whereIn('loinc_local_map_id', [$mode_of_ventilation, $mode_of_ventilation_invasive])
            ->whereIn('intf_ref_value', $non_invasive_list)
            ->where('intf_ref_value', '<>', '')
            ->orderBy('id', 'desc')
            ->limit(1)
            ->get()
            ->pluck('id')
            ->toArray();

            $ventilator_hdr_id = array_merge($inpatient_ventilator_hdr_id, $discharge_ventilator_hdr_id);
        }

        $prev_value = false;
        if (count($ventilator_hdr_id) == 0) {
            $ventilator_type = 'Invasive';

            $inpatient_ventilator_hdr_id = \DB::table('emr_log_hdr')
            ->select('emr_log_hdr.id')
            ->leftJoin('emr_ventilator_values', 'emr_log_hdr.id', 'emr_ventilator_values.log_hdr_id')
            ->where('baby_id', $baby_id)
            ->where('sender_time', '<=', $starting_time)   
            ->whereIn('loinc_local_map_id', [$mode_of_ventilation, $mode_of_ventilation_invasive])
            ->whereIn('intf_ref_value', $invasive_list)
            ->where('intf_ref_value', '<>', '')
            ->orderBy('id', 'desc')
            ->limit(1)
            ->get()
            ->pluck('id')
            ->toArray();

            $discharge_ventilator_hdr_id = \DB::table('emr_log_hdr')
            ->select('emr_log_hdr.id')
            ->leftJoin('emr_ventilator_values_discharged', 'emr_log_hdr.id', 'emr_ventilator_values_discharged.log_hdr_id')
            ->where('baby_id', $baby_id)
            ->where('sender_time', '<=', $starting_time)   
            ->whereIn('loinc_local_map_id', [$mode_of_ventilation, $mode_of_ventilation_invasive])
            ->whereIn('intf_ref_value', $invasive_list)
            ->where('intf_ref_value', '<>', '')
            ->orderBy('id', 'desc')
            ->limit(1)
            ->get()
            ->pluck('id')
            ->toArray();

            $ventilator_hdr_id = array_merge($inpatient_ventilator_hdr_id, $discharge_ventilator_hdr_id);
            $prev_value = true;
        }

        if (($prev_value && count($ventilator_hdr_id) > 0) || count($ventilator_hdr_id) == 0) {
            $ventilator_type = 'Non-Invasive';

            $inpatient_ventilator_hdr_id = \DB::table('emr_log_hdr')
            ->select('emr_log_hdr.id')
            ->leftJoin('emr_ventilator_values', 'emr_log_hdr.id', 'emr_ventilator_values.log_hdr_id')
            ->where('baby_id', $baby_id)
            ->where('sender_time', '<=', $starting_time)   
            ->whereIn('loinc_local_map_id', [$mode_of_ventilation, $mode_of_ventilation_invasive])
            ->whereIn('intf_ref_value', $non_invasive_list)
            ->where('intf_ref_value', '<>', '')
            ->orderBy('id', 'desc')
            ->limit(1)
            ->get()
            ->pluck('id')
            ->toArray();

            $discharge_ventilator_hdr_id = \DB::table('emr_log_hdr')
            ->select('emr_log_hdr.id')
            ->leftJoin('emr_ventilator_values_discharged', 'emr_log_hdr.id', 'emr_ventilator_values_discharged.log_hdr_id')
            ->where('baby_id', $baby_id)
            ->where('sender_time', '<=', $starting_time)   
            ->whereIn('loinc_local_map_id', [$mode_of_ventilation, $mode_of_ventilation_invasive])
            ->whereIn('intf_ref_value', $non_invasive_list)
            ->where('intf_ref_value', '<>', '')
            ->orderBy('id', 'desc')
            ->limit(1)
            ->get()
            ->pluck('id')
            ->toArray();

            $prev_value = 0;
            if (isset($ventilator_hdr_id[0])) {
                $prev_value = $ventilator_hdr_id[0];
            }
            $temp_ventilator_hdr_id = array_merge($inpatient_ventilator_hdr_id, $discharge_ventilator_hdr_id);

            $next_value = 0;
            if (isset($temp_ventilator_hdr_id[0])) {
                $next_value = $temp_ventilator_hdr_id[0];
            }
            if ($prev_value <= $next_value) {
                $ventilator_hdr_id = $temp_ventilator_hdr_id;
            }

        }

        sort($ventilator_hdr_id);

        $inpatient_ventilator_data = \DB::table('emr_log_hdr')
        ->select('loinc_local_map_id', 'intf_ref_value', 'result_date_time', 'emr_ventilator_values.create_user_id', 'sender_time', 'log_hdr_id', \DB::raw("TO_CHAR(sender_time,'HH24:00') as hour"))
        ->leftJoin('emr_ventilator_values', 'emr_log_hdr.id', 'emr_ventilator_values.log_hdr_id')
        ->whereIn('loinc_local_map_id', [$mode_of_ventilation, $mode_of_ventilation_invasive, $fio2, $delivered_fio2])
        ->whereIn('emr_log_hdr.id', $ventilator_hdr_id)
        ->where('intf_ref_value', '<>', '')
        ->orderBy('result_date_time', 'asc')
        ->get()
        ->toArray();

        $discharge_ventilator_data = \DB::table('emr_log_hdr')
        ->select('loinc_local_map_id', 'intf_ref_value', 'result_date_time', 'emr_ventilator_values_discharged.create_user_id', 'sender_time', 'log_hdr_id', \DB::raw("TO_CHAR(sender_time,'HH24:00') as hour"))
        ->leftJoin('emr_ventilator_values_discharged', 'emr_log_hdr.id', 'emr_ventilator_values_discharged.log_hdr_id')
        ->whereIn('loinc_local_map_id', [$mode_of_ventilation, $mode_of_ventilation_invasive, $fio2, $delivered_fio2])
        ->whereIn('emr_log_hdr.id', $ventilator_hdr_id)
        ->where('intf_ref_value', '<>', '')
        ->orderBy('result_date_time', 'asc')
        ->get()
        ->toArray();

        $ventilator_data = array_merge($inpatient_ventilator_data, $discharge_ventilator_data);

        $inpatient_monitor_data = \DB::table('emr_log_hdr')
        ->select('loinc_local_map_id', 'intf_ref_value', 'result_date_time', 'emr_moniter_values.create_user_id', 'sender_time', 'log_hdr_id', \DB::raw("TO_CHAR(sender_time,'HH24:00') as hour"))
        ->leftJoin('emr_moniter_values', 'emr_log_hdr.id', 'emr_moniter_values.log_hdr_id')
        ->whereIn('loinc_local_map_id', [$preductal_sao2])
        ->whereIn('emr_log_hdr.id', $ventilator_hdr_id)
        ->where('intf_ref_value', '<>', '')
        ->orderBy('result_date_time', 'asc')
        ->get()
        ->toArray();

        $discharge_monitor_data = \DB::table('emr_log_hdr')
        ->select('loinc_local_map_id', 'intf_ref_value', 'result_date_time', 'emr_moniter_values_discharged.create_user_id', 'sender_time', 'log_hdr_id', \DB::raw("TO_CHAR(sender_time,'HH24:00') as hour"))
        ->leftJoin('emr_moniter_values_discharged', 'emr_log_hdr.id', 'emr_moniter_values_discharged.log_hdr_id')
        ->whereIn('loinc_local_map_id', [$preductal_sao2])
        ->whereIn('emr_log_hdr.id', $ventilator_hdr_id)
        ->where('intf_ref_value', '<>', '')
        ->orderBy('result_date_time', 'asc')
        ->get()
        ->toArray();

        $monitor_data = array_merge($inpatient_monitor_data, $discharge_monitor_data);

        $ventilator_monitor_data = collect(array_merge($ventilator_data, $monitor_data));

        $single = true;

        $ventilator_hour_lists = $ventilator_monitor_data->pluck('hour')->unique()->toArray();
        $ventilator_hour_list = [];
        if (count($ventilator_hour_lists)) {
            $ventilator_hour_list[] = collect($ventilator_hour_lists)->last();
        }
        $ventilator_result = $ventilator_monitor_data->groupBy(['loinc_local_map_id', 'hour'])->map(function ($item, $index) use ($mode_of_ventilation, $mode_of_ventilation_invasive, $invasive_list) {
            $invasive_found = false;
            if ($index == $mode_of_ventilation || $index == $mode_of_ventilation_invasive) {
                $temp = array_flatten($item);
                foreach ($temp as $key => $value) {
                    if (in_array($value->intf_ref_value, $invasive_list)) {
                        $invasive_found = true;
                        $filtered_value = $value;
                        $datas[$filtered_value->hour] = $filtered_value;
                    }
                }
                if (!$invasive_found) {
                    foreach ($item as $key => $value) {
                        $filtered_value = $value->last();
                        $datas[$filtered_value->hour] = $filtered_value;
                    }
                }
            } else {
                foreach ($item as $key => $value) {
                    $filtered_value = $value->last();
                    $datas[$filtered_value->hour] = $filtered_value;
                }
            }
            $data[$filtered_value->hour] = collect($datas)->last();
            return $data;
        });

        // $inotropes = ['Dopamine', 'Dobutamine', 'Noradrenaline', 'Adrenalin', 'Milrinone', 'Vasopressin'];
        // $non_steroid = ['Hydrocortisone', 'Dexamethasone', 'Methyl prednisolone'];

        $inotropes_drug_ids = \DB::table('mas_drugivfluid')
        ->select('id')
        ->whereIn('brand_name', $inotropes)
        ->OrWhereIn('generic_pharmacological_name', $this->inotropes)
        ->get()
        ->pluck('id');

        $non_steroid_drug_ids = \DB::table('mas_drugivfluid')
        ->select('id')
        ->whereIn('brand_name', $non_steroid)
        ->OrWhereIn('generic_pharmacological_name', $this->non_steroid)
        ->get()
        ->pluck('id');

        $inpatient_inotropes_drug_list = \DB::table('prescription_hdr')
        ->select(\DB::raw('count(*)'), \DB::raw("TO_CHAR(calculated_hour,'HH24:00') as hour"))
        ->leftJoin('prescription_dtl', 'prescription_hdr.id', 'pres_hdr_id')
        ->leftJoin('prescription_infused_calculation', 'prescription_dtl.prescription_id', 'prescription_infused_calculation.prescription_id')
        ->where('baby_id', $baby_id)
        ->whereBetween('calculated_hour', [$starting_time, $ending_time])   
        // ->whereRaw('CAST("calculated_hour" AS TEXT) ILIKE \'%' . $selected_date . '%\'')
        ->whereIn('brand_name', $inotropes_drug_ids)
        ->groupBy('hour')
        ->get()
        ->pluck('count', 'hour')
        ->toArray();

        $discharged_inotropes_drug_list = \DB::table('prescription_hdr')
        ->select(\DB::raw('count(*)'), \DB::raw("TO_CHAR(calculated_hour,'HH24:00') as hour"))
        ->leftJoin('prescription_dtl_discharged', 'prescription_hdr.id', 'pres_hdr_id')
        ->leftJoin('prescription_infused_calculation_discharged', 'prescription_dtl_discharged.prescription_id', 'prescription_infused_calculation_discharged.prescription_id')
        ->where('baby_id', $baby_id)
        ->whereBetween('calculated_hour', [$starting_time, $ending_time])   
        // ->whereRaw('CAST("calculated_hour" AS TEXT) ILIKE \'%' . $selected_date . '%\'')
        ->whereIn('brand_name', $inotropes_drug_ids)
        ->groupBy('hour')
        ->get()
        ->pluck('count', 'hour')
        ->toArray();

        $inotropes_drug_list = array_merge($inpatient_inotropes_drug_list, $discharged_inotropes_drug_list);

        $inpatient_non_steroid_drug_list = \DB::table('prescription_hdr')
        ->select(\DB::raw('count(*)'), \DB::raw("TO_CHAR(calculated_hour,'HH24:00') as hour"))
        ->leftJoin('prescription_dtl', 'prescription_hdr.id', 'pres_hdr_id')
        ->leftJoin('prescription_infused_calculation', 'prescription_dtl.prescription_id', 'prescription_infused_calculation.prescription_id')
        ->where('baby_id', $baby_id)
        ->whereBetween('calculated_hour', [$starting_time, $ending_time])   
        // ->whereRaw('CAST("calculated_hour" AS TEXT) ILIKE \'%' . $selected_date . '%\'')
        ->whereIn('brand_name', $non_steroid_drug_ids)
        ->groupBy('hour')
        ->get()
        ->pluck('count', 'hour')
        ->toArray();

        $discharged_non_steroid_drug_list = \DB::table('prescription_hdr')
        ->select(\DB::raw('count(*)'), \DB::raw("TO_CHAR(calculated_hour,'HH24:00') as hour"))
        ->leftJoin('prescription_dtl', 'prescription_hdr.id', 'pres_hdr_id')
        ->leftJoin('prescription_infused_calculation', 'prescription_dtl.prescription_id', 'prescription_infused_calculation.prescription_id')
        ->where('baby_id', $baby_id)
        ->whereBetween('calculated_hour', [$starting_time, $ending_time])   
        // ->whereRaw('CAST("calculated_hour" AS TEXT) ILIKE \'%' . $selected_date . '%\'')
        ->whereIn('brand_name', $non_steroid_drug_ids)
        ->groupBy('hour')
        ->get()
        ->pluck('count', 'hour')
        ->toArray();

        $non_steroid_drug_list = array_merge($inpatient_non_steroid_drug_list, $discharged_non_steroid_drug_list);

        $drug_hour_list = array_filter(collect(array_keys(array_merge($inotropes_drug_list, $non_steroid_drug_list)))->unique()->toArray());
        sort($drug_hour_list);

        $platelets = 245;

        $inpatient_lab_data = \DB::table('emr_log_hdr')
        ->select('loinc_local_map_id', 'intf_ref_value', 'result_date_time', 'emr_lab_values.create_user_id', 'sender_time', 'log_hdr_id', \DB::raw("TO_CHAR(sender_time,'HH24:00') as hour"))
        ->leftJoin('emr_lab_values', 'emr_log_hdr.id', 'emr_lab_values.log_hdr_id')
        ->where('baby_id', $baby_id)
        ->whereIn('loinc_local_map_id', [$platelets])
        ->where('intf_ref_value', '<>', '')
        ->where('result_status', 'final')
        ->orderBy('result_date_time', 'asc')
        ->get()
        ->toArray();

        $discharged_lab_data = \DB::table('emr_log_hdr')
        ->select('loinc_local_map_id', 'intf_ref_value', 'result_date_time', 'emr_lab_values_discharged.create_user_id', 'sender_time', 'log_hdr_id', \DB::raw("TO_CHAR(sender_time,'HH24:00') as hour"))
        ->leftJoin('emr_lab_values_discharged', 'emr_log_hdr.id', 'emr_lab_values_discharged.log_hdr_id')
        ->where('baby_id', $baby_id)
        ->whereIn('loinc_local_map_id', [$platelets])
        ->where('intf_ref_value', '<>', '')
        ->where('result_status', 'final')
        ->orderBy('result_date_time', 'asc')
        ->get()
        ->toArray();

        $lab_data = array_merge($inpatient_lab_data, $discharged_lab_data);
        $lab_data = collect($lab_data);

        $lab_hour_list = [];
        $target_date_time = strtotime($selected_date);

        $lab_result = $lab_data->groupBy(['loinc_local_map_id', 'result_date_time'])->map(function ($item) use ($target_date_time, &$lab_hour_list, &$selected_date) {
            $data_list = [];
            foreach ($item as $key => $value) {
                $filtered_value = $value->last();
                $filtered_date = date('Y-m-d', strtotime($filtered_value->result_date_time));
                $data[$filtered_value->result_date_time] = $filtered_value;
            }
            $dateTimes = array_keys($data);

            $nearest_date_time = null;
            $shortest_diff = null;

            foreach ($dateTimes as $dt) {
                $diff = abs($target_date_time - strtotime($dt));
                if (is_null($shortest_diff) || $diff < $shortest_diff) {
                    $shortest_diff = $diff;
                    $nearest_date_time = $dt;
                }
            }
            $time = date('H', strtotime($nearest_date_time)) . ':00';
            $lab_hour_list[] = $time;
            $data_list[$time] = $data[$nearest_date_time];
            $selected_date = date('Y-m-d', strtotime($nearest_date_time));
            return $data_list;
        });

        $score_hour = collect(array_merge($ventilator_hour_list, $drug_hour_list, $lab_hour_list))->unique()->toArray();
        sort($score_hour);

        return ['ventilator_result' => $ventilator_result, 'ventilator_hour_list' => $ventilator_hour_list, 'ventilator_type' => $ventilator_type, 'lab_selected_date' => $selected_date, 'lab_result' => $lab_result, 'lab_hour_list' => $lab_hour_list, 'inotropes_drug_list' => $inotropes_drug_list, 'non_steroid_drug_list' => $non_steroid_drug_list, 'drug_hour_list' => $drug_hour_list, 'score_hour' => $score_hour, 'non_invasive_list' => $non_invasive_list];

    }
    /**
     * Main method to calculate and store the NSOFA score.
     * Triggers internal methods for prescription data processing and scoring.
     *
     * @param string $log_hdr_id The unique ID for the hourly record (used as primary key/identifier).
     * @param float|null $spo2 Minimum Spo2 value received in the latest update.
     * @param string|null $ventilation_mode The latest ventilation mode received.
     * @param float|null $fio2 Maximum FiO2 received in the latest update.
     * @param float|null $delivered_fio2 Maximum Delivered FiO2 received in the latest update.
     * @param float|null $platelet_count Latest Platelet count received.
     * @param array $new_inotropes_list List of active Inotropes (e.g., ['Dopamine', 'Adrenalin']).
     * @param array $new_steroids_list List of active Steroids (e.g., ['Hydrocortisone']).
     * @return array Status of the calculation and storage.
     */
    public function calculateAndStoreNsofaScoreHourly($log_hdr_id, $spo2 = null, $ventilation_mode = null, $fio2 = null, $delivered_fio2 = null, $platelet_count = null, $new_prescription_name) {
        
        $now = Carbon::now();
        
        $existing_score_data = \DB::table('n_sofa_score')->where('log_hdr_id', $log_hdr_id)->first();

        $stored_data = [
            'spo2'                  => null, 
            'fio2'                  => null,
            'delivered_fio2'        => null,
            'platelet_count'        => null,
            'ventilation_mode'      => null,
            'given_inotropes'       => '[]', 
            'given_steroids'        => '[]', 
            'created_date_time'     => $now,
        ];
        
        if ($existing_score_data) {
            foreach ($stored_data as $key => $default_value) {
                if (isset($existing_score_data->$key)) {
                    $stored_data[$key] = $existing_score_data->$key;
                }
            }
            $stored_data['created_date_time'] = $existing_score_data->created_date_time;
        }

        $prescription_update = $this->_updatePrescriptionData($stored_data, $new_prescription_name);

        $stored_data['given_inotropes'] = $prescription_update['given_inotropes'];
        $stored_data['given_steroids'] = $prescription_update['given_steroids'];
        
        if ($spo2 !== null) { $stored_data['spo2'] = $spo2; }
        if ($fio2 !== null) { $stored_data['fio2'] = $fio2; }
        if ($delivered_fio2 !== null) { $stored_data['delivered_fio2'] = $delivered_fio2; }
        if ($ventilation_mode !== null) { $stored_data['ventilation_mode'] = $ventilation_mode; }
        if ($platelet_count !== null) { 
            $stored_data['platelet_count'] = $platelet_count; 
        } elseif ($existing_score_data && $existing_score_data->platelet_count !== null) {
            $stored_data['platelet_count'] = $existing_score_data->platelet_count;
        } else {
            $lastHourValue = NsofaScore::getLastHematologyScoreForThatBaby($log_hdr_id);
            if (isset($lastHourValue->previous_platelet_count) && !empty($lastHourValue->previous_platelet_count)) {
                $stored_data['platelet_count'] = $lastHourValue->previous_platelet_count;
            }
        }

        $is_invasive_ventilation = !empty($stored_data['ventilation_mode']) && in_array($stored_data['ventilation_mode'], $this->invasive_list);
        
        $final_fio2 = ($stored_data['delivered_fio2'] ?? 0.0);
        if ($final_fio2 === 0.0) {
            $final_fio2 = ($stored_data['fio2'] ?? 0.0);
        }

        $resp_result = $this->calculateRespiratoryScore($stored_data['spo2'], $final_fio2, $is_invasive_ventilation);
        $resp_score = $resp_result['respiratory_score'] ?? 0;

        $hemato_result = $this->calculateHematologyScore($stored_data['platelet_count']);
        $hemato_score = $hemato_result['hematology_score'] ?? 0;

        $cardio_result = $this->calculateCardiovascularScore($stored_data['given_inotropes'], $stored_data['given_steroids']);
        $cardio_score = $cardio_result['cardiovascular_score'] ?? 0;

        $nsofa_score = $resp_score + $hemato_score + $cardio_score;

        \DB::table('n_sofa_score')->updateOrInsert(
            ['log_hdr_id' => $log_hdr_id], 
            [
                'total_nsofa_score'     => $nsofa_score, 
                'respiratory_score'     => $resp_score,
                'hematology_score'      => $hemato_score,
                'cardiovuscular_score'  => $cardio_score,
                'spo2'                  => $stored_data['spo2'],
                'fio2'                  => $stored_data['fio2'], 
                'delivered_fio2'        => $stored_data['delivered_fio2'], 
                'platelet_count'        => $stored_data['platelet_count'],
                'ventilation_mode'      => $stored_data['ventilation_mode'],
                'given_inotropes'       => $stored_data['given_inotropes'],
                'given_steroids'        => $stored_data['given_steroids'],
                'modified_date_time'    => $now,
                'created_date_time'     => $stored_data['created_date_time'], 
            ]
        );

        return [
            'status' => 'success',
            'message' => "NSOFA score updated for record $log_hdr_id. Total Score: $nsofa_score",
            'score' => $nsofa_score,
        ];
    }

    /**
     * Classifies a single new drug name and merges it with the existing lists.
     * @param array $stored_data The current data array (contains existing JSON drug lists).
     * @param string|null $new_drug_name The single drug name received from the API.
     * @return array Updated $stored_data portion with new JSON strings.
     */
    private function _updatePrescriptionData($stored_data, $new_drug_name) {

        $inotropes = json_decode($stored_data['given_inotropes'], true) ?: [];
        $steroids = json_decode($stored_data['given_steroids'], true) ?: [];
        
        if (!empty($new_drug_name)) {
            $normalized_drug = strtoupper(trim($new_drug_name));

            if (in_array($normalized_drug, $this->inotropes)) {
                $inotropes[] = $normalized_drug;
            } elseif (in_array($normalized_drug, $this->non_steroid)) {
                $steroids[] = $normalized_drug;
            }
        }

        $inotropes = array_values(array_unique($inotropes));
        $steroids = array_values(array_unique($steroids));

        return [
            'given_inotropes' => json_encode($inotropes),
            'given_steroids' => json_encode($steroids),
        ];
    }

    private function calculateRespiratoryScore($spo2, $final_fio2, $is_invasive_ventilation) {
        $score = 0;
        $cal = null; 

        $effective_fio2 = $final_fio2 !== null && $final_fio2 > 1.0 ? $final_fio2 / 100.0 : $final_fio2;
        
        
        if (($spo2 ?? 0.0) > 0.0 && ($effective_fio2 ?? 0.0) > 0.0) {
            $cal = $spo2 / $effective_fio2;
        }

        if ($is_invasive_ventilation) {
            if ($cal === null || $cal >= 300) {
                $score = 0;
            } elseif ($cal >= 200) {
                $score = 2;
            } elseif ($cal >= 150) {
                $score = 4;
            } elseif ($cal >= 100) {
                $score = 6;
            } else {
                $score = 8;
            }
        } else {
            $score = 0;
        }

        return [
            'cal' => $cal !== null ? round($cal, 2) : null,
            'respiratory_score' => $score
        ];
    }

    private function calculateHematologyScore($platelet_count) {
        $score = 0;
        $platelet_count_to_use = (int) ($platelet_count ?? 0);
        
        if ($platelet_count_to_use > 0) {
            if ($platelet_count_to_use < 50000) { $score = 3; }
            elseif ($platelet_count_to_use < 75000) { $score = 2; }
            elseif ($platelet_count_to_use < 150000) { $score = 1; }
        }

        return [
            'cal' => $platelet_count_to_use,
            'hematology_score' => $score
        ];
    }

    private function calculateCardiovascularScore($inotropes_json, $steroids_json) {
        $cardiovascularScore = 0;
        
        $inotropes_array = json_decode($inotropes_json, true);
        $steroids_array = json_decode($steroids_json, true);
        
        if (!is_array($inotropes_array) || !is_array($steroids_array)) {
            return ['cardiovascular_score' => 0];
        }
        
        $inotrope_count = count($inotropes_array);
        $has_steroids = count($steroids_array) > 0;

        if ($inotrope_count >= 2 && $has_steroids) { $cardiovascularScore = 4; }
        elseif ($inotrope_count >= 2 || ($inotrope_count == 1 && $has_steroids)) { $cardiovascularScore = 3; }
        elseif ($inotrope_count == 1 && !$has_steroids) { $cardiovascularScore = 2; }
        elseif ($inotrope_count == 0 && $has_steroids) { $cardiovascularScore = 1; }

        return [
            'cardiovascular_score' => $cardiovascularScore,
        ];
    }
}

