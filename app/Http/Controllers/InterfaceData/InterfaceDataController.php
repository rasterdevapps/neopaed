<?php
namespace App\Http\Controllers\InterfaceData;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Excel;

class InterfaceDataController extends Controller
{

    /**
     * Time zone type
     *
     * @var $time_zone
     */
    protected $time_zone;


    public function __construct()
    {
        $this->time_zone = env('TIME_ZONE');
    }

    /**
     * Get data from mirth server to create live chart.
     *
     * @return json array
     */
    public function getInterfaceData(Request $request)
    {
            $input = $request->all();
            $mrn = $input['mrn'];
            $parameter = $input['parameter'];

            $zone = $this->time_zone;
            $result_date_time_query = "result_date_time";

            if (isset($input['client_zone']) && $input['client_zone'] != $this->time_zone) {
                $zone = $input['client_zone'];
                $result_date_time_query = "((result_date_time AT TIME ZONE '".$this->time_zone."') AT TIME ZONE '".$zone."')::timestamp as result_date_time";
            }

            $current_date_time = strtotime(Carbon::now($zone));
            $selected_date_time = strtotime($input['from_time']);

            $diff_time = ($current_date_time - $selected_date_time) / 60;

            $table_name = 'mrn_' . $mrn;

            $from_time = date('Y-m-d H:i:s', strtotime($input['from_time']));
            $to_time = date('Y-m-d H:i:s', strtotime($input['to_time']));  

            $query_from_time = Carbon::createFromFormat('Y-m-d H:i:s', $from_time, $zone);
            $start_at = $query_from_time->timestamp;  

            $query_from_time = $query_from_time->setTimezone($this->time_zone);

            $query_to_time = Carbon::createFromFormat('Y-m-d H:i:s', $to_time, $zone);
            $query_to_time = $query_to_time->setTimezone($this->time_zone);

            $start_at = (int)$start_at; 

            $count = $diff_time * 60;
            $count = (int)$count;
            if (isset($input['slug']) && $input['slug'] != 'add') {
                $count = $input['interval'] * 60;
            }

            $time_string = array_fill($start_at, $count, null);
            $time_string = array_keys($time_string);
            $time_string = implode(",", $time_string);
            $time_string = str_replace(',', '000,', $time_string);
            $time_string = $time_string . '000';
            $time_string = explode(",", $time_string);
            $time_string = array_fill_keys($time_string, null);
            $data = [];
            $results = [];

            $data = \DB::connection('mirth_db')->table($table_name)
            ->select('observation_name', \DB::raw($result_date_time_query))
            ->selectRaw("result_value::float")
            ->where('uhid', $mrn)
            ->whereBetween('result_date_time', [$query_from_time, $query_to_time])
            ->whereIn('observation_name', $parameter)
            ->where('result_value', '~', '[0-9]')
            ->orderBy('result_date_time')
            ->get();

            if (count($data) > 0) {
                $results = $data->groupBy('observation_name')
                ->map(function ($group) use ($time_string, $zone) {

                    $date_value_result = $group->pluck('result_value', 'result_date_time')->toArray();
                    $result = [];

                    array_walk_recursive($date_value_result, function($value, $key) use (&$result, $zone) {
                        $result[strtotime($key. ' ' . $zone)*1000] = (float)$value;
                    });

                    $results = $result + $time_string;

                    ksort($results);

                    $temp_results = [];

                    array_walk_recursive($results, function($value, $key) use (&$temp_results) {
                        $result['date'] = $key;
                        $result['value'] = is_numeric($value) ? (float)$value : null;

                        $temp_results[] = $result;
                    });

                    return $temp_results;

                })->toArray();
            }

            $found_params = array_keys($results);
            $unfound_params = array_diff($parameter, $found_params);

            foreach ($unfound_params as $value) {

                $results[$value] = [];

                array_walk_recursive($time_string, function($item, $index) use (&$results, $value) {
                    $result['date'] = $index;
                    $result['value'] = null;

                    $results[$value][] = $result;
                });

            }

            return \Response::json(['results' => $results, 'query_from_time'=>$query_from_time, 'query_to_time'=>$query_to_time, 'count'=>$count, 'time_string'=>$time_string]);
    }

    /**
     * Get parameter from mirth server to create live chart.
     *
     * @return json array
     */
    public static function getInterfaceParameter(Request $request) {

        $input = $request->all();

        $mrn = $input['mrn'];

        $table_name = 'mrn_' . $mrn;

        $param = [];
        $parameters = [];
        
        $results_live_parameters = \DB::connection('mirth_db')->select("select observation_name from ".$table_name." group by observation_name");

        $parameter_content = '';

        if (count($results_live_parameters) > 0) {

            $parameter_list = collect($results_live_parameters)
            ->pluck('observation_name')
            ->toArray();

            $temp_param = \DB::table('local_code_group')
            ->select('observation_name', 'color_code', 'normal_range_start_at', 'normal_range_end_at')
            ->selectRaw('local_code|| \'^\' ||local_description|| \'^\' ||acronym as code')
            ->whereNotNull('observation_name')
            ->whereNotNull('parameter_priority')
            ->where('local_code', '<>', '')
            ->where('local_description', '<>', '')
            ->where('acronym', '<>', '')
            ->where('parameter_priority', '<>', '')
            ->whereIn('observation_name', $parameter_list)
            ->orderBy('parameter_priority')
            ->get();

            $param = $temp_param->pluck('code', 'observation_name');
            $param_color = $temp_param->pluck('color_code', 'observation_name');
            $range_start_at = $temp_param->pluck('normal_range_start_at', 'observation_name');
            $range_end_at = $temp_param->pluck('normal_range_end_at', 'observation_name');

            $cuff_bp = 0;
            $arterial_bp = 0;
            foreach ($param as $key => $value) {
                $param_key = isset(explode('^', $value)[0]) ? explode('^', $value)[0] : '';
                $param_name = isset(explode('^', $value)[1]) ? explode('^', $value)[1] : '';
                $acronym = isset(explode('^', $value)[2]) ? explode('^', $value)[2] : '';
                $block_hide = ((str_contains($param_key, 'cuff') && $cuff_bp != 0) || (str_contains($param_key, 'arterial') && $arterial_bp != 0)) ? 'hide' : '';

                $parameter_content .= '<div class="col-md-4 parameter-block ' . $block_hide . '">
                <input type="hidden" name="' . $param_key . '" value="' . $key . '" />';
                if (!str_contains($param_key, 'bp')) {
                    $parameter_content .= '<input type="checkbox" id="' . $param_key . '" name="active_param" value="' . $param_key . '">
                    <label for="' . $param_key . '" data-acronym="' . $acronym . '" class="color-white pl-5" data-color="' . $param_color[$key] . '" data-start-at="' . $range_start_at[$key] . '" data-end-at="' . $range_end_at[$key] . '"><b>' . $param_name . '</b></label>';
                } else {
                    $parameter_content .= '<input type="checkbox" id="' . $param_key . '" name="active_param" value="' . $param_key . '" class="'.$block_hide.'">';

                    $parameter_content .= '<label for="' . $param_key . '" data-acronym="' . $acronym . '" class="color-white pl-5 '.$block_hide.'" data-color="' . $param_color[$key] . '" data-start-at="' . $range_start_at[$key] . '" data-end-at="' . $range_end_at[$key] . '">';

                    if ($block_hide != '') {
                        $parameter_content .= '<b>' . $param_name . '</b>';
                    } else {
                        if (str_contains($param_key, 'arterial')) {
                            $parameter_content .= '<b>Arterial BP</b>';
                        } else {                            
                            $parameter_content .= '<b>Cuff BP</b>';
                        }
                    }

                    $parameter_content .= '</label>';

                    if (str_contains($param_key, 'cuff') && $cuff_bp == 0) {
                        $cuff_bp++;
                    } elseif (str_contains($param_key, 'arterial') && $arterial_bp == 0) {
                        $arterial_bp++;
                    }
                }
                $parameter_content .= '</div>';
            }
        }

        return [$parameter_content, $param];
    }

    /**
     * Get baby's first record date & time.
     *
     * @return object
     */
    public function getStartTime($mrn) {

        $results = \DB::table('baby_admission')
        ->select('DateAdded as admission_date_time')
        ->where('BMrNo', $mrn)
        ->orderBy('AdmissionId', 'asc')
        ->first();

        return $results;

    }

    /**
     * Get event details
     *
     * @return object
     */
    public static function getEventList(Request $request)
    {
            $input = $request->all();
            $mrn = $input['mrn'];

            $env_zone = env('TIME_ZONE');
            $zone = $env_zone;
            $event_time_query = "event_date_time AS start, next_ts AS stop";
            if (isset($input['client_zone']) && $input['client_zone'] != $env_zone) {
                $zone = $input['client_zone'];
                $event_time_query = "((event_date_time AT TIME ZONE '".$env_zone."') AT TIME ZONE '".$zone."')::timestamp as start, ((next_ts AT TIME ZONE '".$env_zone."') AT TIME ZONE '".$zone."')::timestamp as stop";
            }

            $from_time = date('Y-m-d H:i:s', strtotime('-5 hours', strtotime($input['from_time'])));
            $to_time = date('Y-m-d H:i:s', strtotime($input['to_time']));

            $query_from_time = Carbon::createFromFormat('Y-m-d H:i:s', $from_time, $zone);
            $query_from_time = $query_from_time->setTimezone($env_zone);

            $query_to_time = Carbon::createFromFormat('Y-m-d H:i:s', $to_time, $zone);
            $query_to_time = $query_to_time->setTimezone($env_zone);

            $results = \DB::select("SELECT event, event_code, ".$event_time_query." FROM (SELECT *, lead(event_date_time) OVER (PARTITION BY event_code ORDER BY event_date_time) AS next_ts FROM dashboard_events WHERE event_date_time BETWEEN '".$query_from_time."' and '".$query_to_time."' and event_status IN ('START', 'STOP') and mrn = '".$mrn."') AS ts_pairs WHERE event_status = 'START'");

            return $results;

    }

    public function getInterfaceDataAccuracy(Request $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $mrn = $input['mrn'];
            $parameter = $input['parameter'];

            $current_date_time = strtotime(Carbon::now());
            $selected_date_time = strtotime($input['from_time']);

            $diff_time = ($current_date_time - $selected_date_time) / 60;

            $table_name = 'mrn_' . $mrn;

            $from_time = date('Y-m-d H:i:s', strtotime($input['from_time']));
            $to_time = date('Y-m-d H:i:s', strtotime($input['to_time']));    

            $observation_count = \DB::connection('mirth_db')
            ->table($table_name)
            ->select('observation_name', \DB::raw('count(*) as total'))
            ->where('uhid', $mrn)
            ->where('result_value', '!=', '-')
            ->whereBetween('result_date_time', [$from_time, $to_time])
            ->whereIn('observation_name', $parameter)
            ->groupBy('observation_name')
            ->get()->pluck('total', 'observation_name');

            return \Response::json(['observation_count' => $observation_count]);
        } else {
            return redirect('ward-dashboard');            
        }
    }

    public function babyData($baby_mrn, $admission_id) {

        $baby_mrn = \SiteHelpers::decrypt_id($baby_mrn);

        $table_name = 'mrn_' . $baby_mrn;

        $results = \DB::connection('mirth_db')
        ->table($table_name)
        ->select('result_date_time', 'result_value', 'observation_name')
        ->where('uhid', $baby_mrn)
        ->get()
        ->map(function ($group) {
            return (array)$group;
        })
        ->toArray();

        $heading = ['Date & Time', 'Value', 'Observation'];

        Excel::create('baby_data_'. date('dmYHis'), function ($excel) use ($results, $heading)
        {

            $excel->sheet('Excel sheet', function ($sheet) use ($results, $heading)
            {

                $sheet->fromArray($results, null, 'A1', false, false, false);
                $sheet->prependRow(1, $heading);
                $sheet->setOrientation('landscape');

            });

        })
        ->export('csv')
        ->download();

    }

    public function getPumpResults(Request $request)
    {

        $admission_id = $request->input('admission_id');

        $patient_details = \DB::table('patient_bed_log')
        ->where('admission_id', $admission_id)
        ->where('status', 'Occupied')
        ->orderBy('id', 'desc')
        ->first();

        if (isset($patient_details->bed_no)) {

            $results = \DB::connection('mirth_db')
            ->table('mindray_e_and_n_series_pump_details')
            ->whereIn('status', ['MNDRY_INFUSION_STATUS_UNSTARTED', 'MNDRY_INFUSION_STATUS_COMPLETED', 'MNDRY_INFUSION_STATUS_KVO'])
            ->where('bed_number', $patient_details->bed_no)
            ->orderBy('pump_order', 'asc')
            ->get()
            ->toArray();

            return \Response::json(['results' => $results]);

        }

        return \Response::json(['type' => 'error', 'message' => 'Bed not found.']);


    }
    public function getDashboardResultDetails(Request $request) {
        $bed_no = $request->query('bed_no');
        $result = \DB::select("SELECT result_data FROM nicu_dashboard_results WHERE bed = ? ORDER BY id DESC LIMIT 1", [$bed_no]);

        // If a result is found and not empty, return the data
        if (!empty($result) && !empty($result[0]->result_data)) {
            return response()->json(json_decode($result[0]->result_data));
        }

        $roomNumber = 0;

        if ($bed_no >= 21 && $bed_no <= 28) {
            $roomNumber = 134;
        } elseif ($bed_no >= 31 && $bed_no <= 36) {
            $roomNumber = 132;
        } else {
            $roomQuery = \DB::select("SELECT room.number AS room_number FROM bed INNER JOIN room ON bed.room_id = room.id WHERE bed.number = ?", [$bed_no]);
            if (!empty($roomQuery)) {
                $roomNumber = $roomQuery[0]->room_number;
            }
        }

        $defaultData = [
            'cotId' => (int) $bed_no,
            'pageNo' => 1,
            'roomId' => (int) $roomNumber,
            'patient' => [
                'mrn' => '',
                'ipNo' => '',
                'weight' => [
                    'atBirth' => '',
                    'current' => '',
                    'working' => '',
                ],
                'babyName' => ' ',
                'pageInfo' => [
                    'respSupport' => [
                        'tcpInfo' => [],
                        'tfcInfo' => [],
                        'respInfo' => [
                            'mode' => '',
                            'respSupport' => '',
                        ],
                        'intakeInfo' => [],
                        'outputInfo' => [],
                        'inhaledInfo' => [],
                    ],
                    'labAndScanInfo' => [
                        'mri' => [],
                        'xray' => [],
                        'ctScan' => [],
                        'abgInfo' => [],
                        'labInvestigation' => [],
                    ],
                    'currentMedications' => [],
                ],
                'problems' => [],
                'admitDate' => '',
                'admitTime' => '',
                'ageInDays' => '',
                'birthDate' => '',
                'birthTime' => null,
                'bloodInfo' => [
                    'dct' => '',
                    'baby' => '',
                    'mother' => '',
                    'haemolysis' => '',
                ],
                'corrected' => '',
                'gestation' => '',
                'tableInfo' => [
                    'values' => [
                        [
                            'bp' => '',
                            'hr' => '',
                            'spo2' => '',
                            'temp' => '',
                            'label' => 'High',
                        ],
                        [
                            'bp' => '',
                            'hr' => '',
                            'spo2' => '',
                            'temp' => '',
                            'label' => 'Median',
                        ],
                        [
                            'bp' => '',
                            'hr' => '',
                            'spo2' => '',
                            'temp' => '',
                            'label' => 'Low',
                        ],
                    ],
                    'headers' => [
                        'HR',
                        'RR',
                        'SpO2(%)',
                        'BP (mmHg)',
                        'Temp(℉)',
                    ],
                ],
                'ageOnadmission' => '',
            ],
            'currentDateTime' => '',
        ];
        
        return response()->json($defaultData);
    }

}
