<?php

namespace App\Http\Controllers\Reports;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use App\Models\Baby;

class nsofaController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:NSOFA,read');
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
        $non_invasive_list = ['SV', 'SVA', 'NPO2', 'HFNC', 'HHHFNC', 'NIPPV', 'NIPPV (D)', 'NIPPV Tr', 'CPAP'];
        $invasive_list = ['SIMV', 'PTV', 'PSV', 'HFOV', 'HFO'];

        $inpatient_ventilator_hdr_id = \DB::table('emr_log_hdr')
        ->select('emr_log_hdr.id')
        ->leftJoin('emr_ventilator_values', 'emr_log_hdr.id', 'emr_ventilator_values.log_hdr_id')
        ->where('baby_id', $baby_id)
        ->whereBetween('sender_time', [$starting_time, $ending_time])   
        ->whereIn('loinc_local_map_id', [$mode_of_ventilation, $mode_of_ventilation_invasive])
        ->whereIn('intf_ref_value', $invasive_list)
        ->where('intf_ref_value', '<>', '')
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
            ->get()
            ->pluck('id')
            ->toArray();

            $ventilator_hdr_id = array_merge($inpatient_ventilator_hdr_id, $discharge_ventilator_hdr_id);
        }

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

        $ventilator_hour_list = $ventilator_monitor_data->pluck('hour')->unique()->toArray();
        $ventilator_result = $ventilator_monitor_data->groupBy(['loinc_local_map_id', 'hour'])->map(function ($item, $index) use ($mode_of_ventilation, $mode_of_ventilation_invasive, $invasive_list) {
            $invasive_found = false;
            if ($index == $mode_of_ventilation || $index == $mode_of_ventilation_invasive) {
                $temp = array_flatten($item);
                foreach ($temp as $key => $value) {
                    if (in_array($value->intf_ref_value, $invasive_list)) {
                        $invasive_found = true;
                        $filtered_value = $value;
                        $data[$filtered_value->hour] = $filtered_value;
                    }
                }
                if (!$invasive_found) {
                    foreach ($item as $key => $value) {
                        $filtered_value = $value->last();
                        $data[$filtered_value->hour] = $filtered_value;
                    }
                }
            } else {
                foreach ($item as $key => $value) {
                    $filtered_value = $value->last();
                    $data[$filtered_value->hour] = $filtered_value;
                }
            }
            return $data;
        });

        $inotropes = ['Dopamine', 'Dobutamine', 'Noradrenaline', 'Adrenalin', 'Milrinone', 'Vasopressin'];
        $non_steroid = ['Hydrocortisone', 'Dexamethasone', 'Methyl prednisolone'];

        $inotropes_drug_ids = \DB::table('mas_drugivfluid')
        ->select('id')
        ->whereIn('brand_name', $inotropes)
        ->OrWhereIn('generic_pharmacological_name', $inotropes)
        ->get()
        ->pluck('id');

        $non_steroid_drug_ids = \DB::table('mas_drugivfluid')
        ->select('id')
        ->whereIn('brand_name', $non_steroid)
        ->OrWhereIn('generic_pharmacological_name', $non_steroid)
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

        return ['ventilator_result' => $ventilator_result, 'ventilator_hour_list' => $ventilator_hour_list, 'ventilator_type' => $ventilator_type, 'lab_selected_date' => $selected_date, 'lab_result' => $lab_result, 'lab_hour_list' => $lab_hour_list, 'inotropes_drug_list' => $inotropes_drug_list, 'non_steroid_drug_list' => $non_steroid_drug_list, 'drug_hour_list' => $drug_hour_list, 'score_hour' => $score_hour];

    }

}
