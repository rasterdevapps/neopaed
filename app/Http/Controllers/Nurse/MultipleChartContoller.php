<?php
namespace App\Http\Controllers\Nurse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Baby;
use App\Models\Fhir\FhirFormatedValues;
use App\Http\Controllers\Nurse\NurseChartPropertyController;
use App\Models\Nurse\EmrLogDetails;
use App\Models\Nurse\EmrLogHeader;
use App\Models\DischargeLog;
use App\Models\IpNumber;

class MultipleChartContoller extends Controller
{
    /**
     * This variable for instance of NurseChartPropertyController
     *
     * @var $chart_property;
     */
    public function __construct(NurseChartPropertyController $chart_property)
    {
        $this->chart_property = $chart_property;
    }

    public function show($baby_id, $admission_id, $sheet_date, $slug = '', $module = '')
    {

        $baby_id = \SiteHelpers::decrypt_id($baby_id);
        $admission_id = \SiteHelpers::decrypt_id($admission_id);

        $baby_details = Baby::find($baby_id);
        $admission_start_date = EmrLogHeader::selectRaw('visit_date::date')->where('baby_id', $baby_id)->where('admission_id', $admission_id)->orderBy('visit_date', 'asc')->first();
        $sheet_end_date = EmrLogHeader::selectRaw('visit_date::date')->where('baby_id', $baby_id)->where('admission_id', $admission_id)->orderBy('visit_date', 'desc')->first();
        $header_start_date = (isset($admission_start_date->visit_date) && !empty($admission_start_date->visit_date) && !is_null($admission_start_date->visit_date)) ? $admission_start_date->visit_date : date('Y-m-d');
        $header_end_date = (isset($sheet_end_date->visit_date) && !empty($sheet_end_date->visit_date) && !is_null($sheet_end_date->visit_date)) ? $sheet_end_date->visit_date : date('Y-m-d');

        $sheet_start_date = ($sheet_date == 0) && isset($header_start_date) ? $header_start_date : $sheet_date . ' 00:00:00';
        $sheet_end_date = ($sheet_date == 0) && isset($header_end_date) ? $header_end_date : $sheet_date . ' 23:59:59';

        if (isset($slug) && $slug != 'nicu-nurse-sheet-day') {
            $closewinlink = url('all-in-one-chart-list');
        } 
        if (isset($slug) && ($slug == 'nicu-nurse-sheets' || $slug == 'ward-dashboard')) {
            $closewinlink = action('Nurse\NurseSheetController@GetDaylist', \SiteHelpers::encrypt_id($admission_id)).'/'.$slug;
        } else if (isset($slug) && $slug == 'search-reports') {
            $closewinlink = action('HomeController@search').'?baby_id='.\SiteHelpers::encrypt_id($baby_id);
        } else {
            $closewinlink = url('all-in-one-chart-baby-select');
        }
        $color_code = \DB::table('local_code_group')->whereNotNull('color_code')->pluck('color_code', 'local_code')->toArray();
        $ip_number = IpNumber::getCurrent_ip($baby_id, $admission_id);
        $ip_number = isset($ip_number->ip_number) ? $ip_number->ip_number : null;

        return view('chart.multiple_chart', compact('baby_details', 'baby_id', 'admission_id', 'sheet_start_date', 'sheet_end_date', 'ventilator_label', 'closewinlink', 'header_start_date', 'header_end_date', 'color_code', 'ip_number'));

    }

    /**
     * This method to view the daycare sheet
     * In the format of chart
     *
     * @param $baby_id type integer
     * @param $admission_id type integer
     * @param $start_date type date
     * @param $end_date type date
     *
     * @return Response to view
     */
    public function multipleChart($baby_id, $admission_id, $selected_start_date, $selected_end_date)
    {
        $baby_details = Baby::find($baby_id);

        $selected_start_date = date("Y-m-d", strtotime($selected_start_date)) . " 00:00:00";
        $selected_end_date = date("Y-m-d", strtotime($selected_end_date)) . " 23:59:59";

        $monitor_interfacing_status = env('VENTILATOR_MACHINE');
        $ventilator_filter_chart = env('VENTILATOR_MACHINE');

        $chart_data = $this->getMultiplechart($baby_id, $admission_id, $selected_start_date, $selected_end_date, $monitor_interfacing_status, $ventilator_filter_chart);

        $closewinlink = action('Nurse\NurseSheetController@index');

        if (env('MONITOR_INTERFACE')) {
            $vitals_label = json_encode(\DB::table('local_code_group')->where('module_type', 1)->where('chart_status', true)->where('interfacing_chart', true)->pluck('local_description', 'local_code'));
        }
        if (env('VENTILATOR_MACHINE')) {
            $ventilator_label = json_encode(\DB::table('local_code_group')->where('module_type', 2)->where('chart_status', true)->where('interfacing_chart', true)->pluck('local_description', 'local_code'));
        }

        if (!env('MONITOR_INTERFACE')) {
            $vitals_label = json_encode(\DB::table('local_code_group')->where('module_type', 1)->where('chart_status', true)->where('manual_chart', true)->pluck('local_description', 'local_code'));
        } 
        if (!env('VENTILATOR_MACHINE')) {
            $ventilator_label = json_encode(\DB::table('local_code_group')->where('module_type', 2)->where('chart_status', true)->where('manual_chart', true)->pluck('local_description', 'local_code'));
        }

        $vitals_param = collect(json_decode($vitals_label))->toArray();
        $ventilator_param = collect(json_decode($ventilator_label))->toArray();

        $chart_param = array_merge($vitals_param, $ventilator_param);
        $chart_param = array_flip($chart_param);

        return \Response::json(['status' => 'Success', 'chart_data' => $chart_data, 'vitals_label' => $vitals_label, 'ventilator_label' => $ventilator_label, 'chart_param' => $chart_param]);

    }

    /**
     * This method to get value from fhir
     *
     * @param $baby_id type integer
     * @param $admission_id type integer
     * @param $start_date type date
     * @param $end_date type date
     *
     * @return array
     */
    public function getMultipleChart($baby_id, $admission_id, $selected_start_date, $selected_end_date, $monitor_interfacing_status, $ventilator_interfacing_status)
    {

        $baby_details = Baby::find($baby_id);
        $result = $vitals_result = $ventilator_result = $results = $date = array();

        $log_header = \DB::table('emr_log_hdr')->select('id')->where('baby_id', $baby_id)->where('admission_id', $admission_id)->pluck('id')->unique()->toArray();

        $patient_status = DischargeLog::getDischargeDetail($baby_id, $admission_id);

        $type = count($patient_status) > 0 ? 'discharged' : 'inPatient';
        
        $vital_temp_results = EmrLogHeader::getVitalListChart($log_header, $type, $selected_start_date, $selected_end_date, $monitor_interfacing_status);
        $vital_temp_results = collect($vital_temp_results)->groupBy('local_code')->toArray();

        foreach ($vital_temp_results as $temp_key => $temp_value) {

            if (isset($temp_value[0]) && $temp_value[0]->chart_type == 1) {

                $results = $this->getBoxwhiskerData($temp_value, $temp_value[0]->local_code, $temp_value[0]->snomed_code, $results);

                if (count($results) > 0) {
                    $result['parameter'][] = "box:" . $temp_value[0]->local_code;
                }

            } elseif (isset($temp_value[0]) && $temp_value[0]->chart_type == 0) {

                $results = $this->getLineData($temp_value[0]->local_code, $temp_value, $results);

                if (count($results) > 0) {
                    $result['parameter'][] = "line:" . $temp_value[0]->local_code;
                }

            }

        }

        $ventilator_temp_results = EmrLogHeader::getVentilatorListChart($log_header, $type, $selected_start_date, $selected_end_date, $ventilator_interfacing_status);
        $ventilator_temp_results = collect($ventilator_temp_results)->groupBy('local_code')->toArray();

        foreach ($ventilator_temp_results as $temp_key => $temp_value) {

            if (isset($temp_value[0]) && $temp_value[0]->chart_type == 1) {

                $results = $this->getBoxwhiskerData($temp_value, $temp_value[0]->local_code, $temp_value[0]->snomed_code, $results);

                if (count($results) > 0) {
                    $result['parameter'][] = "box:" . $temp_value[0]->local_code;
                }

            } elseif (isset($temp_value[0]) && $temp_value[0]->chart_type == 0) {

                $results = $this->getLineData($temp_value[0]->local_code, $temp_value, $results);

                if (count($results) > 0) {
                    $result['parameter'][] = "line:" . $temp_value[0]->local_code;
                }

            }

        }

        if (count($results) > 0) {
            $result["param_value"] = collect($results["param_value"])->sortBy('temp_date')->toArray();
            return $result;
        } else {
            return $results;
        }
    }

    /**
     * This method to format values
     * for boxwhisker data
     *
     */
    public function getBoxwhiskerData($temp_results, $parameter, $parameter_snomedct, $results_array)
    {
        $dateList = $result = $temp_result = array();

        $temp_result = $temp_results;

        foreach ($temp_result as & $value) {
            $value->tempdate_time = date('Y-m-d H', strtotime($value->date)) . ':00';
            $value->tempdate = date('Y-m-d', strtotime($value->date));
        }

        $dateList = collect($temp_result)->unique('tempdate')->pluck('tempdate')->toArray();

        foreach ($dateList as $key => $value) {

            for ($hour = 0;$hour < 24;$hour++) {

                $tempTime = (strlen($hour) == 1) ? '0' . $hour : $hour;
                $time = $value . ' ' . $tempTime . ':00';
                $results = collect($temp_results)->where('snomed_code', $parameter_snomedct)->where('tempdate_time', $time)->last();

                if (count($results) > 0 && ((isset($results->first_quartile) && $results->first_quartile > 0) || (isset($results->last_quartile) && $results->last_quartile > 0) || (isset($results->mean) && $results->mean > 0) || (isset($results->close) && $results->close > 0) || (isset($results->low) && $results->low > 0))) {

                    $temvalue[$parameter . '_open'] = $results->first_quartile;
                    $temvalue[$parameter . '_close'] = $results->last_quartile;
                    $temvalue[$parameter . '_value'] = $results->mean;
                    $temvalue[$parameter . '_high'] = $results->close;
                    $temvalue[$parameter . '_low'] = $results->low;
                    $temvalue['date'] = date('d-M-Y H', strtotime($time)) . ':00';
                    $temvalue['temp_date'] = strtotime($time);
                    $temvalue[$parameter . '_volume'] = $results->mean;

                    $date = $temvalue['date'];

                    if (isset($results_array['param_value']) && is_array($results_array['param_value']) && array_key_exists($date, $results_array['param_value'])) {

                        $results_array['param_value'][$date] = array_merge($results_array['param_value'][$date], $temvalue);

                    } else {

                        $results_array['param_value'][$date] = $temvalue;

                    }
                }
            }
        }

        return $results_array;
    }

    /**
     * This method to format values
     * for boxwhisker data
     *
     */
    public function getLineData($parameter, $temp_result, $results_array)
    {
        $result = array();
        foreach ($temp_result as $key => $value)
        {
            if ($value->mean > 0)
            {
                $temvalue['date'] = date('d-M-Y H', strtotime($value->date)) . ':00';
                $temvalue['temp_date'] = strtotime($value->date);
                $temvalue[$parameter . '_lvalue'] = $value->mean;
                
                $date = $temvalue['date'];

                if (isset($results_array['param_value']) && is_array($results_array['param_value']) && array_key_exists($date, $results_array['param_value'])) {

                    $results_array['param_value'][$date] = array_merge($results_array['param_value'][$date], $temvalue);

                } else {

                    $results_array['param_value'][$date] = $temvalue;

                }
            }
        }
        return $results_array;
    }

    /**
     * This method to view the daycare sheet
     * In the format of chart
     *
     * @param $baby_id type integer
     * @param $admission_id type integer
     * @param $current_parameter type string
     *
     * @return Response to view
     */
    public function multipleSingleChart($baby_id, $admission_id, $current_parameter = '')
    {

        $baby_details = Baby::find($baby_id);

        $chart_data = $this->getMultipleSingleChart($baby_id, $admission_id, $current_parameter);
        $closewinlink = action('Nurse\NurseSheetController@index');

        return \Response::json(['status' => 'Success', 'chart_data' => $chart_data, 'sheet_date' => $chart_data['start_date'], 'sheet_date1' => $chart_data['end_date']]);

    }

    /**
     * This method to get value from fhir
     *
     * @param $baby_id type integer
     * @param $admission_id type integer
     * @param $current_parameter type string
     *
     * @return array
     */
    public function getMultipleSingleChart($baby_id, $admission_id, $current_parameter = '')
    {

        $baby_details = Baby::find($baby_id);
        $result = $vitals_result = $ventilator_result = $results = $date = array();

        $vitals_parameters = collect($this->chart_property->vitals_parameters);
        $ventilator_parameters = collect($this->chart_property->ventilator_parameters);

        $i = $j = 0;

        $log_header = \DB::table('emr_log_hdr')->select('id')->where('admission_id', $admission_id)->pluck('id')->toArray();
        foreach ($vitals_parameters as $key => $value)
        {

            if ($value->parameter == $current_parameter)
            {

                $tempresult = EmrLogHeader::getVitalListChart($log_header, $value->parameter_snomedct);
                $tempresult = collect($tempresult)->toArray();

                $date = array_merge($date, collect($tempresult)->pluck('date', 'date')
                    ->toArray());

                $temp_result = collect($tempresult)->toArray();

                if (count($temp_result) > 0)
                {
                    if ($value->parameter_charttype == 2)
                    {
                        $temp_result = $this->getBoxwhiskerData($temp_result, $value->parameter, $value->parameter_snomedct);

                        if (count($temp_result) > 0)
                        {
                            $result['parameter'][] = "box:" . $value->parameter;
                        }
                        foreach ($temp_result as $key => $value)
                        {
                            $results[$key][$i] = $value;
                        }

                        $i++;

                    }
                    elseif ($value->parameter_charttype == 1)
                    {

                        $temp_result = $this->getLineData($value->parameter, $temp_result);

                        if (count($temp_result) > 0)
                        {
                            $result['parameter'][] = "line:" . $value->parameter;
                        }

                        foreach ($temp_result as $key => $value)
                        {
                            $results[$key][$j] = $value;
                        }

                        $j++;

                    }
                }

            }

        }

        foreach ($ventilator_parameters as $key => $value)
        {

            if ($value->parameter == $current_parameter)
            {
                $tempresult = EmrLogHeader::getVentilatorListChart($log_header, $value->parameter_snomed);
                $tempresult = collect($tempresult)->toArray();
                $date = array_merge($date, collect($tempresult)->pluck('date', 'date')
                    ->toArray());

                $temp_result = collect($tempresult)->toArray();

                if (count($temp_result) > 0)
                {
                    if ($value->parameter_chattype == 1)
                    {
                        $temp_result = $this->getBoxwhiskerData($temp_result, $value->parameter, $value->parameter_snomed);

                        if (count($temp_result) > 0)
                        {
                            $result['parameter'][] = "box:" . $value->parameter;
                        }

                        foreach ($temp_result as $key => $value)
                        {
                            $results[$key][$i] = $value;
                        }
                        $i++;
                    }
                    elseif ($value->parameter_chattype == 2)
                    {
                        $temp_result = $this->getLineData($value->parameter, $temp_result);

                        if (count($temp_result) > 0)
                        {
                            $result['parameter'][] = "line:" . $value->parameter;
                        }

                        foreach ($temp_result as $key => $value)
                        {
                            $results[$key][$j] = $value;
                        }

                        $j++;
                    }
                }

            }

        }

        $date = array_unique($date);
        sort($date);
        foreach ($date as $key => $value)
        {
            if (!is_null($value))
            {
                $value = date('d-M-Y h', strtotime($value)) . ":00";
                $results[$value][]['date'] = $value;
            }
        }

        if (count($results) > 0)
        {

            $temp = collect(call_user_func_array('array_merge', $results))->groupBy('date')->toArray();

            usort($temp, function ($a, $b)
            {
                return strtotime(collect($a)->first() ['date']) - strtotime(collect($b)->first() ['date']);
            });

            foreach ($temp as $key => $value)
            {
                $result["param_value"][] = call_user_func_array('array_merge', $value);
            }

            $date = explode(" ", collect(collect($temp)->last())->pluck('date') [0]) [0];

            $start_date = $date . " 00:00";
            $end_date = $date . " 23:59";

            $date = collect($result["param_value"])->where('date', '>=', $start_date)->where('date', '<=', $end_date)->pluck('date');

            $result['start_date'] = $date->first();
            $result['end_date'] = $date->last();

            return $result;

        }
        else
        {

            return $results;

        }

    }

}

