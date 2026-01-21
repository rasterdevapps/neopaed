<?php

namespace App\Http\Controllers\Fhir;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\InterfaceData\InterfaceDataController;
use App\Models\Baby;
use App\Models\Fhir\ObservationRange;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Models\Settings\Settings;
use Carbon\Carbon;

class RangeComparisonChartController extends Controller
{
    /**
     * Parameters & their range 
     *  
     * @var $range_list
     */
    public $range_list;

    function __construct()
    {
        $this->range_list['Heart Rate Trend (BPM)'] = ['>180', '161-180', '141-160', '121-140', '101-120', '81-100', '61-80', '<60'];
        $this->range_list['Oxygen Saturation (%)'] = ['96-100', '91-95', '86-90', '81-85', '76-80', '71-75', '66-70', '61-65', '<60'];
        $this->range_list['Ventilator SpO2 (%)'] = ['96-100', '91-95', '86-90', '81-85', '76-80', '71-75', '66-70', '61-65', '<60'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function rangePost(Request $request)
    {
        $received_data = (array)json_decode(file_get_contents('php://input'));   

        foreach ($received_data as $received_key => $received_value) {
            if ($received_key == 'mrn') {
                $baby_details = Baby::getBabyId($received_value);
                if (isset($baby_details->BabyId)) {
                    $post['baby_id'] = $baby_details->BabyId;
                }
                if (isset($post['baby_id']) && is_null($post['baby_id'])) {
                    return "Invalid patient data";
                }
            }
            if ($received_key == 'observation') {
                $local_code_ids = ['MDC_PULS_OXIM_SAT_O2' => 8, 'MDC_PULS_OXIM_PULS_RATE' => 35, 'SpO2' => 366];
                $post['loinc_local_map_id'] = $local_code_ids[$received_value];
            }
            if ($received_key == 'result_date_time') {
                $post['result_date_time'] = $received_value;
            }
            if ($received_key == 'values') {
                $received_value = json_decode($received_value);
                $received_value = (array)$received_value;
                foreach ($received_value as $range => $value) {
                    $post['range'] = $range;
                    $post['percentage'] = $value;

                    $result = ObservationRange::where('result_date_time', $post['result_date_time'])
                    ->where('loinc_local_map_id', $post['loinc_local_map_id'])
                    ->where('range', $post['range'])
                    ->where('baby_id', $post['baby_id'])
                    ->first();

                    if (isset($result->id)) {
                        ObservationRange::where('id', $result->id)->update(['percentage'=>$post['percentage']]);
                    } else {
                        ObservationRange::insert($post);
                    }
                }
            }
        }
        return "Success";
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
        $baby_id = \SiteHelpers::decrypt_id($input['baby_id']);
        $admission_date = \SiteHelpers::decrypt_id($input['admission_date']);
        $baby_details = Baby::findOrfail($baby_id);

        return view('nurse_sheet.range_comparison_chart', compact('baby_details', 'admission_date'));
    }

    /**
     * Method to get chart data
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function rangeData(Request $request)
    {

        if ($request->ajax())
        {
            $input = $request->all();
            $baby_id = $input['baby_id'];
            $result_set_2 = [];
            if (isset($input['set_2_start_from']) && isset($input['set_2_end_to'])) {
                $result_set_2 = $this->processComparisonData($baby_id, $input['set_2_start_from'], $input['set_2_end_to'], 'percentage_2');
            }

            $result_set = $this->processComparisonData($baby_id, $input['start_from'], $input['end_to'], 'percentage', $result_set_2);

            if (isset($result_set_2)) {
                $temp_results = array_merge_recursive($result_set, $result_set_2);
            } else {
                $temp_results = $result_set;
            }
            $parameters = json_encode(array_unique($temp_results['parameters']));
            $results = json_encode($temp_results['results']);

            return \Response::json(['parameters' => $parameters, 'results' => $results]);
        }
    }    

    /**
     * Method to process chart data
     */
    public function processComparisonData($baby_id, $from_date, $to_date, $column_name, $existing_set = [])
    {

        $from_date = date('Y-m-d H:i', strtotime($from_date));
        $to_date = date('Y-m-d H:i', strtotime($to_date));

        $from = date_create($from_date);
        $to = date_create($to_date);

        $results = [];
        $raw_results = ObservationRange::getData($baby_id, $from_date, $to_date)
        ->groupBy(['local_description', 'range'])
        ->map(function($item, $index) use (&$results, $column_name, $existing_set, &$collected_range) {
            $collected_range = [];
            array_walk($this->range_list[$index], function($key) use ($item, $index, &$collected_range, &$i, $existing_set, $column_name) {
                $percentage = 0;
                if (isset($item[$key])) {
                    $data = $item[$key]->pluck('percentage', 'result_date_time')->toArray();
                    $hour = count($data);
                    $percentage = array_sum($data);
                }
                if (isset($existing_set['results'][$index]) && count($existing_set['results'][$index]) >= 0) {
                } else {
                    $collected_range[$index][$key]['range'] = $key;
                }
                if (isset($hour) && $hour > 0) {
                    $percentage = $percentage / $hour;
                }
                $collected_range[$index][$key][$column_name] = str_replace('.00', '', number_format($percentage, 2));
            });
            $results = array_merge($results, $collected_range);
        })
        ->toArray();
        $parameters = array_keys($results);
        return ['parameters' => $parameters, 'results' => $results];
    }

    /**
     * Method to get dates of the chart
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function tableData(Request $request)
    {

        if ($request->ajax())
        {
            $input = $request->all();
            $baby_id = $input['baby_id'];
            $start_from = $input['start_from'];
            $end_to = $input['end_to'];

            $temp_diff_days = date_diff(date_create($start_from), date_create($end_to))->days;

            $date_list = [];
            $working_time = Settings::getPeriod()->period;

            $starts_at = date('d-m-Y', strtotime($start_from));
            for ($i = 0; $i <= $temp_diff_days; $i++) { 
                $from_date = $starts_at . ' '. $working_time;
                $to_date = date('d-m-Y H:i:s', strtotime($from_date . ' +1 day -1 second'));
                $date_list[$from_date . ' - ' . $to_date] = $starts_at;
                $starts_at = date('d-m-Y', strtotime($to_date));
            }

            return \Response::json(['date_list' => $date_list]);
        }

    }

    /**
     * Method to get table data
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function hourWiseRangeData(Request $request)
    {

        if ($request->ajax())
        {
            $input = $request->all();
            $baby_id = $input['baby_id'];
            $start_from = date('Y-m-d H:i', strtotime($input['start_from']));
            $end_to = date('Y-m-d H:i', strtotime($input['end_to'].' +1 hour'));

            $data = [];
            $raw_results = ObservationRange::getHourWiseData($baby_id, $start_from, $end_to)
            ->groupBy(['local_description', 'range']);

            collect($this->range_list)->map(function($values, $parameter) use ($raw_results, &$data) {
                $data_set = [];
                collect($values)->map(function($range) use ($raw_results, $parameter, &$data_set, &$data) {
                    $value = [];
                    if (isset($raw_results[$parameter]) && isset($raw_results[$parameter][$range])) {
                        $temp_values = $raw_results[$parameter][$range];
                        $value = $temp_values->pluck('percentage', 'temp_result_date_time');;
                    }
                    $data_set[$parameter][$range] = $value;
                });
                $data = array_merge($data, $data_set);
            });

            $time_list = [];
            $first_day_column_count = 0;
            for ($i = 0; $i <= 23; $i++) {
                $temp_date_time = Carbon::createFromFormat('Y-m-d H:i', $start_from)->addHours($i);
                $time_list[] = $temp_date_time->format('d-m-Y H:i');
                if (date('Y-m-d', strtotime($start_from)) == date('Y-m-d', strtotime($temp_date_time))) {
                    $first_day_column_count++;
                }
            }

            $hero_data = \DB::table('emr_log_hdr')
            ->select( 'intf_ref_value')
            ->selectRaw("TO_CHAR(sender_time,'DD-MM-YYYY HH24:00') as temp_sender_time")
            ->leftJoin('emr_moniter_values', 'emr_log_hdr.id', 'emr_moniter_values.log_hdr_id')
            ->whereBetween('sender_time', [$start_from, $end_to])
            ->where('baby_id', $baby_id)
            ->where('loinc_local_map_id', 9)
            ->get()->pluck('intf_ref_value', 'temp_sender_time');

            return \Response::json(['data' => $data, 'time_list' => $time_list, 'hero_data' => $hero_data, 'first_day_column_count' => $first_day_column_count]);

        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fio2Show(Request $request)
    {
        $input = $request->all();
        $baby_id = \SiteHelpers::decrypt_id($input['baby_id']);
        $admission_date = \SiteHelpers::decrypt_id($input['admission_date']);
        $baby_details = Baby::findOrfail($baby_id);

        return view('nurse_sheet.fio2_chart', compact('baby_details', 'admission_date'));
    }

    /**
     * Method to get fio2 data
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function fio2CalculationData(Request $request)
    {
        $input = $request->all();
        $mrn = $input['mrn'];
        $table_name = 'mrn_' . $input['mrn'];
        $start_from = date('Y-m-d H:i', strtotime($input['start_from'])). ':00';
        $end_to = date('Y-m-d H:i', strtotime($input['end_to'])) . ':59';

        $auto_o2 = 'Auto-O2 Status';
        $delivered_fio2 = 'Oxygen Concentration';
        $set_fio2 = 'Set O2%';
        $set_fio2_1 = 'O2';
        // $set_fio2_1 = 'MDC_ECG_HEART_RATE';

        $observation_list = "('" . $auto_o2 ."','". $delivered_fio2 ."','". $set_fio2 ."','". $set_fio2_1 . "')";

        $sub_query = "select observation_name, result_date_time, result_value from " . $table_name . " where result_value != '-' and observation_name in " . $observation_list . " and observation_name = case when (observation_name = '". $auto_o2  ."' and result_value = '2') then '" . $delivered_fio2 . "' else (case when (observation_name = '" . $set_fio2 . "') then '" . $set_fio2 . "' else '" . $set_fio2_1 . "' end) end and (result_date_time between '" . $start_from . "' and '" . $end_to . "') order by result_date_time";

        $query = "SELECT PERCENTILE_CONT(0) WITHIN GROUP(ORDER BY cast(result_value as integer)) as low, PERCENTILE_CONT(0.25) WITHIN GROUP(ORDER BY cast(result_value as integer)) as first_quartile, PERCENTILE_CONT(0.5) WITHIN GROUP(ORDER BY cast(result_value as integer)) as mean, PERCENTILE_CONT(0.75) WITHIN GROUP(ORDER BY cast(result_value as integer)) as last_quartile, PERCENTILE_CONT(1) WITHIN GROUP(ORDER BY cast(result_value as integer)) as close FROM (" . $sub_query . ") as q";

        $result = \DB::connection('mirth_db')->select($query);

        return $result;

    }

}
