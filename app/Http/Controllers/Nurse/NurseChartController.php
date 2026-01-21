<?php
namespace App\Http\Controllers\Nurse;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Baby;
use App\Exceptions\InvalidInputException;
use App\Models\Nurse\EmrLogHeader;
use App\Models\Nurse\EmrLogDetails;
use App\Models\Nurse\NurseSheetMain;
use App\Models\Nurse\NurseHourSheet;
use Carbon\Carbon;
use App\Models\IpNumber;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Models\Masters\NurseMaster;
use App\Models\Settings\Settings;
use App\Http\Controllers\Nurse\DialpadSupportProperty;
use App\Http\Controllers\Nurse\NurseChartPropertyController;
use App\Http\Controllers\Nurse\MachineVitalsChartController;
use App\Http\Controllers\Nurse\MachineVendilatorChartController;
use App\Models\Fhir\FhirFormatedValues;
use App\Models\Admission;
use App\Models\DischargeLog;
use App\Http\Controllers\InterfaceData\InterfaceDataController;
use App\Models\LocalCodeGroup;

/**
 * All the method  to create nurse chart
 *
 * @author Manikandan M
 */

class NurseChartController extends NurseChartBaseController
{

    public function __construct(Guard $auth, EmrLogHeader $emr_log_head, ErrorLogController $error_log, NurseChartPropertyController $chart_property, MachineVitalsChartController $vital_chart, MachineVendilatorChartController $vendilator_chart)
    {

        $this->auth = $auth;
        $this->emr_log_head = $emr_log_head;
        $this->time_zone = env('TIME_ZONE');
        $this->time_interval = 1;

        $this->chart_property = $chart_property;
        $this->vital_chart = $vital_chart;
        $this->vendilator_chart = $vendilator_chart;
        $this->ventilator_group = $chart_property->ventilator_group;
        $this->navigate['main_nav'] = 'nicu_nurse_sheet';
        $this->navigate['sub_nav'] = 'nicu_nurse_sheet';
        $this->singleObsList = ['cuff_systalic_bp', 'cuff_diastolic_bp', 'cuff_mean_bp'];

    }

    /**
     * This method to view the daycare sheet
     * In the format of chart
     *
     * @param $request object of request
     * @param $id day id
     */
    public function graphicalview($baby_id, $admission_id, Request $request)
    {
        //get input all
        $input = $request->all();
        if (!is_numeric($baby_id))
        {
            $baby_id = \SiteHelpers::decrypt_id($baby_id);
        }

        $selected_date = '';
        if (isset($input['date']))
        {
            $selected_date = $input['date'];
        }

        if (!is_numeric($admission_id))
        {
            $admission_id = \SiteHelpers::decrypt_id($admission_id);
        }

        $current_admission_dates = EmrLogHeader::getCurrentAdmissionDates($admission_id);
        $date_options = array();
        foreach ($current_admission_dates as $date_key => $date_value)
        {
            $date_options[$date_value] = date('d-m-Y', strtotime($date_value));
        }
        ksort($date_options);
        if (isset($input['closewinlink']) && ($input['closewinlink'] == 'nicu-nurse-sheets' || $input['closewinlink'] == 'ward-dashboard'))
        {
            $closewinlink = action('Nurse\NurseSheetController@GetDaylist', \SiteHelpers::encrypt_id($admission_id)) . '/' . $input['closewinlink'];
            $redirect_option = $input['closewinlink'];
        } else if (isset($input['closewinlink']) && $input['closewinlink'] == 'search-reports') {
            $closewinlink = action('HomeController@search').'?baby_id='.\SiteHelpers::encrypt_id($baby_id);
            $redirect_option = $closewinlink;
        } else {
            $closewinlink = url('ward-dashboard');
            $closewinlink = url('chart-baby-select');

            $redirect_option = 'ward-dashboard';
        }

        $baby_details = Baby::find($baby_id);

        /*To check discharge status */
        $discharge_log = DischargeLog::getDischargeDetail($baby_id, $admission_id);
        $is_discharged = false;
        $table_name = 'emr_ventilator_values';
        if (count($discharge_log) > 0)
        {
            $is_discharged = true;
            $table_name = 'emr_ventilator_values_discharged';
        }
        $type = ($is_discharged === true) ? 'discharged' : 'inPatient';

        $vendilationMode = \DeviceHelpers::getAssetDetails($baby_details->BabyId, '', $table_name);
        $vendilationModelist = \DeviceHelpers::getModeList($baby_details->BabyId, '', $table_name);

        $tempModeList = array();
        foreach ($vendilationModelist as $key => $value)
        {
            $tempModeList[strtolower($key) ] = strtoupper($value);
        }

        $vendilationModelist = $tempModeList;

        $vendilationMode = (isset($input['vendilation_mode']) && $input['vendilation_mode'] != '') ? $input['vendilation_mode'] : collect(array_keys($vendilationModelist))->first();

        $vendilator_settings = (array)json_decode(\SiteHelpers::getConfigSettings('VENTILATOR_MODE_SETTING'));

        $vendilationMode = strtolower($vendilationMode);

        if ($vendilationMode == 'high flow o2')
        {
            $temp_ventilator_mode = 'o2';
        } else if ($vendilationMode == '+vtv')
        {
            $temp_ventilator_mode = 'o2';
        } else {
            $temp_ventilator_mode = $vendilationMode;
        }
        if (isset($vendilator_settings[$temp_ventilator_mode]))
        {
            $vendilator_settings = collect($vendilator_settings[$temp_ventilator_mode])->pluck('local_code')
                ->toArray();
        }
        else
        {
            $vendilator_settings = [];
        }
        $encrypt_baby_id = \SiteHelpers::encrypt_id($baby_id);

        $color_code = \DB::table('local_code_group')->whereNotNull('color_code')
            ->pluck('color_code', 'local_code')
            ->toArray();

        $ip_details = IpNumber::getCurrent_ip($baby_id, $admission_id);
        $ip_number = isset($ip_details->ip_number) ? $ip_details->ip_number : null;

        return view('nurse_sheet.graphical_view', compact('baby_id', 'vendilationMode', 'vendilator_settings', 'encrypt_baby_id', 'vendilationModelist', 'closewinlink', 'baby_details', 'selected_date', 'date_options', 'admission_id', 'redirect_option', 'color_code', 'ip_number'));
    }

    /**
     * This method to view the daycare sheet
     * In the format of chart
     *
     * @param $request object of request
     * @param $id day id
     */
    public function graphicaldata($baby_id, $admission_id, Request $request)
    {
        $input = $request->all();
        $selected_date = $input['date'];
        unset($input['date']);
        $flag = $input['flag'];
        $periods = $input['periods'];
        $periods = $this
            ->chart_property
            ->getdateduration($periods);

        if (env('MONITOR_INTERFACE'))
        {
            $vitals_box_label = \DB::table('local_code_group')->where('module_type', 1)
                ->where('chart_status', true)
                ->where('interfacing_chart', true)
                ->where('chart_type', true)
                ->pluck('local_description', 'local_code')
                ->toArray();
            $vitals_dot_label = \DB::table('local_code_group')->where('module_type', 1)
                ->where('chart_status', true)
                ->where('interfacing_chart', true)
                ->where('chart_type', false)
                ->pluck('local_description', 'local_code')
                ->toArray();
        }

        if (!env('MONITOR_INTERFACE'))
        {
            $vitals_box_label = \DB::table('local_code_group')->where('module_type', 1)
                ->where('chart_status', true)
                ->where('manual_chart', true)
                ->where('chart_type', true)
                ->pluck('local_description', 'local_code')
                ->toArray();
            $vitals_dot_label = \DB::table('local_code_group')->where('module_type', 1)
                ->where('chart_status', true)
                ->where('manual_chart', true)
                ->where('chart_type', false)
                ->pluck('local_description', 'local_code')
                ->toArray();
        }
        $vitals_label = [];
        $vitals_box_label = array_flip($vitals_box_label);
        $vitals_dot_label = array_flip($vitals_dot_label);

        $zoomPosition = '';

        // $parameter = $input['parameters'];
        // if (count($parameter) == 1)
        // {
        //     $selected_date = '';
        // }

        $date_text = '';

        // $parameter = array_merge($parameter, ['type_of_care']);

        /*To check discharge status */
        $discharge_log = DischargeLog::getDischargeDetail($baby_id, $admission_id);
        $is_discharged = false;
        if (count($discharge_log) > 0)
        {
            $is_discharged = true;
        }
        $type = ($is_discharged === true) ? 'discharged' : 'inPatient';

        $parameter_count = 0;
        $vitals = $temp_vitals = $date_vitals = $observation_keys = $vitals_parameters = array();

        // $search_key = array_search('type_of_care', $parameter);
        // unset($parameter[$search_key]);
        $chart_property_temp = $this
            ->chart_property
            ->getchartvitalproperty($flag);

        $event_list = [];
        if (isset($input['eventstartDate']) && isset($input['eventendDate']))
        {
            $data_filter = new Request(['mrn' => Baby::find($baby_id)->BMrNo, 'from_time' => date('Y-m-d', strtotime($input['eventstartDate'])) , 'to_time' => date('Y-m-d', strtotime($input['eventendDate'])) , 'module' => 'chart', ]);

            $event_lists = InterfaceDataController::getEventList($data_filter);

            $temp_event_list = collect($event_lists)->sortBy('start')->map(function ($value, $key)
            {
                $temp_start = date('d-M-y H', strtotime($value->start)) . ':00';
                $temp_stop = date('d-M-y H', strtotime($value->stop)) . ':00';
                if ($temp_start == $temp_stop)
                {
                    $value->temp_start = $temp_start;
                }
                else
                {
                    $value->temp_start = $temp_start;
                    $value->temp_stop = $temp_stop;
                }
                $value->start_datetime = date('H:i:s', strtotime($value->start));
                $value->stop_datetime = date('H:i:s', strtotime($value->stop));
                return $value;
            });

            $event_list_start = $temp_event_list->groupBy('temp_start')
                ->toArray();
            $event_list_stop = collect($temp_event_list)->where('temp_stop', '<>', '')
                ->groupBy('temp_stop')
                ->toArray();

            $event_list = array_merge_recursive($event_list_start, $event_list_stop);

        }

        $map_param = [];
        
        if ($flag == 3)
        {

            $chart_type = 0;
            $mid_value = 1;

            if ($input['dataFlag'] == 1)
            {
                //main window
                $vitals_results = $this
                    ->vital_chart
                    ->getviatlsfrommachine($input, $baby_id, $admission_id, $periods, $selected_date, $vitals_box_label, $vitals_dot_label);
                $vitals = $vitals_results['parameter_data'];
                $vitals_label = $vitals_results['parameters'];
                $map_param = $vitals_results['map_param'];

            }
            if ($input['dataFlag'] == 2 && $input['viewType'] == 'single-view')
            {
                $selected_date = '';
                // modal single observation view
                $vitals_box_label = in_array($input['parameters'][0], $vitals_box_label) ? $input['parameters'] : [];
                $vitals_dot_label = in_array($input['parameters'][0], $vitals_dot_label) ? $input['parameters'] : [];

                $vitals_results = $this
                    ->vital_chart
                    ->getviatlsfrommachine($input, $baby_id, $admission_id, $periods, $selected_date, $vitals_box_label, $vitals_dot_label);
                
                $vitals_label = $vitals_results['parameters'];

                $vitals = collect($vitals_results['parameter_data'])->first();

                $chart_type = 1;

                $mid_value = '';

                $dateList = collect($vitals)->pluck('tempDate')->unique();

                $prefix = str_replace('_', '', $input['parameters'][0]);

                foreach ($dateList as $dateListkey => $dateListvalue)
                {
                    for ($i = 0;$i < 24;$i++)
                    {

                        $time = (strlen($i) == 2) ? $i : '0' . $i;
                        $time = $time . ':00';
                        $temp_vitals = collect($vitals)->where('date', $time)->where('tempDate', $dateListvalue)->first();

                        if (count($temp_vitals) > 0)
                        {
                            $vital_temp_use[] = $temp_vitals;

                        }
                        else
                        {
                            if (count($vitals_dot_label) > 0)
                            {
                                $temp_vitals_empty['date'] = $time;
                                $temp_vitals_empty['event'] = '';
                                $temp_vitals_empty['event_option'] = null;
                                $temp_vitals_empty['tempDate'] = $dateListvalue;
                                $temp_vitals_empty[$prefix] = null;
                                $vital_temp_use[] = $temp_vitals_empty;
                                $prefix_min = $prefix;

                                $mid_value = $prefix;

                            }
                            else
                            {

                                $temp_vitals_empty['date'] = $time;
                                $temp_vitals_empty['event'] = '';
                                $temp_vitals_empty['event_option'] = null;
                                $temp_vitals_empty['tempDate'] = $dateListvalue;

                                $temp_vitals_empty[$prefix . 'low'] = null;
                                $temp_vitals_empty[$prefix . 'open'] = null;
                                $temp_vitals_empty[$prefix . 'mid'] = null;
                                $temp_vitals_empty[$prefix . 'close'] = null;
                                $temp_vitals_empty[$prefix . 'high'] = null;
                                $vital_temp_use[] = $temp_vitals_empty;
                                $prefix_min = $prefix . 'low';
                                $chart_type = 2;

                                $mid_value = $prefix . 'mid';
                            }
                        }

                    }
                }

                $min = collect($vitals)->where($prefix_min, '<>', '')->pluck($prefix_min)->min();
                $min = $min - 1 > 0 ? $min - 1 : $min;

                foreach ($vital_temp_use as &$value)
                {

                    $temp_date = $value['tempDate'] . ' ' . $value['date'];
                    $event = '';
                    if (isset($event_list[$temp_date]))
                    {
                        $event .= '<table>';
                        $event .= '<tbody>';
                        foreach ($event_list[$temp_date] as $event_key => $event_value)
                        {
                            $event .= '<tr>';
                            $event .= '<td style="font-size: 12px; white-space: nowrap;">';
                            $event .= $event_value->event;
                            $event .= '</td>';
                            $event .= '<td style="color: #FF6961; font-size: 11px; white-space: nowrap;">';

                            if (isset($event_value->temp_stop))
                            {
                                if (strtotime($temp_date) == strtotime($event_value->temp_start))
                                {
                                    $event .= '(' . $event_value->start_datetime . ' to ...)';
                                }
                                elseif (strtotime($temp_date) == strtotime($event_value->temp_stop))
                                {
                                    $event .= '(... to ' . $event_value->stop_datetime . ')';
                                }
                            }
                            else
                            {
                                $event .= '(' . $event_value->start_datetime . ' to ' . $event_value->stop_datetime . ')';
                            }
                            $event .= '</td>';
                            $event .= '</tr>';
                        }
                        $event .= '</tbody>';
                        $event .= '</table>';
                    }
                    $value['event_option'] = strlen($event) > 0 ? $min : null;
                    $value['event'] = strlen($event) > 0 ? $event : null;
                    $value['bullet'] = url('/') . "/public/img/event.png";
                }

                if (count($vitals_box_label) > 0)
                {

                    foreach ($vital_temp_use as & $value)
                    {
                        $value['date'] = $value['tempDate'] . ' ' . $value['date'];
                    }

                }
                else
                {

                    foreach ($vital_temp_use as $key => & $value)
                    {
                        $value['date'] = $value['tempDate'] . ' ' . $value['date'];
                        $value['time'] = $value['date'];
                    }
                }
                $vitals = $vital_temp_use;

                // setting zoom position start
                if (isset($vitals))
                {
                    $todayDate = collect($vitals)->unique('tempDate')
                        ->last() ['tempDate'];
                    $zoomPosition = array_keys(collect($vitals)->where('tempDate', $todayDate)->toArray()) [0];
                }

            }

        }

        $start_date = !empty($periods['period_start']) ? date('d-m-Y', strtotime($periods['period_start'])) : '';
        $end_date = !empty($periods['period_end']) ? date('d-m-Y', strtotime($periods['period_end'])) : '';

        return \Response::json(['values' => $vitals, 'vitals_label' => $vitals_label, 'zoomPosition' => $zoomPosition, 'chart_type' => $chart_type, 'mid_value' => $mid_value, 'map_param' => $map_param], 200);

    }

    /**
     * This method for get vendilator graphical data
     *
     * @param $baby_id type integer
     * @param $request type object
     * @return response json object
     */
    public function vendilatorgraphicaldata($baby_id, Request $request)
    {
        $input = $request->all();
        $selected_date = date('Y-m-d', strtotime($input['date']));
        $vendilator_flag = $input['flag'];

        if (env('VENTILATOR_MACHINE'))
        {
            $ventilator_box_label = \DB::table('local_code_group')->where('module_type', 2)
                ->where('chart_status', true)
                ->where('interfacing_chart', true)
                ->where('chart_type', true);
            if (isset($input['settings'])) {
            $ventilator_box_label = $ventilator_box_label->whereIn('local_code', $input['settings']);
            }
            $ventilator_box_label = $ventilator_box_label->pluck('local_description', 'local_code')
                ->toArray();
            $ventilator_dot_label = \DB::table('local_code_group')->where('module_type', 2)
                ->where('chart_status', true)
                ->where('interfacing_chart', true)
                ->where('chart_type', false);
            if (isset($input['settings'])) {
            $ventilator_dot_label = $ventilator_dot_label->whereIn('local_code', $input['settings']);
            }
            $ventilator_dot_label = $ventilator_dot_label->pluck('local_description', 'local_code')
                ->toArray();
        }

        if (!env('VENTILATOR_MACHINE'))
        {
            $ventilator_box_label = \DB::table('local_code_group')->where('module_type', 2)
                ->where('chart_status', true)
                ->where('manual_chart', true)
                ->where('chart_type', true);
            if (isset($input['settings'])) {
            $ventilator_box_label = $ventilator_box_label->whereIn('local_code', $input['settings']);
            }
            $ventilator_box_label = $ventilator_box_label->pluck('local_description', 'local_code')
                ->toArray();
            $ventilator_dot_label = \DB::table('local_code_group')->where('module_type', 2)
                ->where('chart_status', true)
                ->where('manual_chart', true)
                ->where('chart_type', false);
            if (isset($input['settings'])) {
            $ventilator_dot_label = $ventilator_dot_label->whereIn('local_code', $input['settings']);
            }
            $ventilator_dot_label = $ventilator_dot_label->pluck('local_description', 'local_code')
                ->toArray();
        }

        $ventilator_label = [];
        $ventilator_box_label = array_flip($ventilator_box_label);
        $ventilator_dot_label = array_flip($ventilator_dot_label);

        $zoomPosition = '';
        $chart_property = array();

        if ($input['startDate'] == '' && $input['endDate'] == '')
        {

            $temp_vendilator_periods = $this
                ->chart_property
                ->getdateduration($input['periods']);
            $vendilator_periods['period_start'] = $temp_vendilator_periods['period_start'];
            $vendilator_periods['period_end'] = $temp_vendilator_periods['period_end'];

        }
        else
        {

            $vendilator_periods['period_start'] = date('Y-m-d', strtotime($input['startDate']));
            $vendilator_periods['period_end'] = date('Y-m-d', strtotime($input['endDate']));
        }

        $vendilator_parameters = (!empty($input['parameters'])) ? $input['parameters'] : array();

        // if (count($vendilator_parameters) == 1)
        // {
        //     $selected_date = '';
        // }

        $vendilator_label_group = collect($this->ventilator_group)
            ->pluck('name', 'param')
            ->toArray();

        $admission_id = Admission::get_baby_lists($baby_id)->AdmissionId;

        $discharge_log = DischargeLog::getDischargeDetail($baby_id, $admission_id);
        $is_discharged = false;
        if (count($discharge_log) > 0)
        {
            $is_discharged = true;
        }
        $type = ($is_discharged === true) ? 'discharged' : 'inPatient';

        $vendilator = $temp_vendilator = $date_vendilator = $observation_keys = $temp_chart_property = $vendilator_group = array();
        $parameter_count = 0;

        $data_filter = new Request(['mrn' => Baby::find($baby_id)->BMrNo, 'from_time' => date('Y-m-d', strtotime($input['eventstartDate'])) , 'to_time' => date('Y-m-d', strtotime($input['eventendDate'])) , 'module' => 'chart', ]);

        $event_lists = InterfaceDataController::getEventList($data_filter);

        $temp_event_list = collect($event_lists)->sortBy('start')->map(function ($value, $key)
        {
            $temp_start = date('d-M-y H', strtotime($value->start)) . ':00';
            $temp_stop = date('d-M-y H', strtotime($value->stop)) . ':00';
            if ($temp_start == $temp_stop)
            {
                $value->temp_start = $temp_start;
            }
            else
            {
                $value->temp_start = $temp_start;
                $value->temp_stop = $temp_stop;
            }
            $value->start_datetime = date('H:i:s', strtotime($value->start));
            $value->stop_datetime = date('H:i:s', strtotime($value->stop));
            return $value;
        });

        $event_list_start = $temp_event_list->groupBy('temp_start')
            ->toArray();
        $event_list_stop = collect($temp_event_list)->where('temp_stop', '<>', '')
            ->groupBy('temp_stop')
            ->toArray();

        $event_list = array_merge_recursive($event_list_start, $event_list_stop);
        
        $chart_type = 0;
        
        $mid_value = 1;

        $map_param = [];

        if ($vendilator_flag == 3)
        {

            if ($input['dataFlage'] == 1)
            {
                $vendilator_results = $this
                    ->vendilator_chart
                    ->getventilatorfrommachine($input, $baby_id, $admission_id, $vendilator_periods, $selected_date, $ventilator_box_label, $ventilator_dot_label);
                $vendilator = $vendilator_results['parameter_data'];
                $ventilator_label = $vendilator_results['parameters'];
                $map_param = $vendilator_results['map_param'];
            }

            if ($input['dataFlage'] == 2 && $input['viewType'] == 'single-view')
            {
                $selected_date = '';
                $ventilator_box_label = in_array($input['parameters'][0], $ventilator_box_label) ? $input['parameters'] : [];
                $ventilator_dot_label = in_array($input['parameters'][0], $ventilator_dot_label) ? $input['parameters'] : [];

                $vendilator_results = $this
                    ->vendilator_chart
                    ->getventilatorfrommachine($input, $baby_id, $admission_id, $vendilator_periods, $selected_date, $ventilator_box_label, $ventilator_dot_label);

                $ventilator_label = $vendilator_results['parameters'];

                $vendilator = collect($vendilator_results['parameter_data'])->first();

                $chart_type = 1;

                $mid_value = '';

                $dateList = collect($vendilator)->unique('tempDate')
                    ->pluck('tempDate');

                $prefix = str_replace('_', '', $input['parameters'][0]);

                foreach ($dateList as $dateListkey => $dateListvalue)
                {

                    for ($i = 0;$i < 24;$i++)
                    {

                        $time = (strlen($i) == 2) ? $i : '0' . $i;
                        $time = $time . ':00';
                        $temp_vendilator = collect($vendilator)->where('date', $time)->where('tempDate', $dateListvalue)->first();
                        if (count($temp_vendilator) > 0)
                        {
                            $vendilator_temp_use[] = $temp_vendilator;
                        }
                        else
                        {
                            if (count($ventilator_box_label) > 0)
                            {
                                $temp_vendilator['date'] = $time;
                                $temp_vendilator['event'] = '';
                                $temp_vendilator['event_option'] = null;
                                $temp_vendilator['tempDate'] = $dateListvalue;
                                $temp_vendilator[$prefix . 'low'] = null;
                                $temp_vendilator[$prefix . 'open'] = null;
                                $temp_vendilator[$prefix . 'mid'] = null;
                                $temp_vendilator[$prefix . 'close'] = null;
                                $temp_vendilator[$prefix . 'high'] = null;
                                $vendilator_temp_use[] = $temp_vendilator;
                                $prefix_min = $prefix . 'low';
                                $chart_type = 2;

                                $mid_value = $prefix . 'mid';

                            }
                            elseif (count($ventilator_dot_label) > 0)
                            {
                                $temp_vendilator['date'] = $time;
                                $temp_vendilator['event'] = '';
                                $temp_vendilator['event_option'] = null;
                                $temp_vendilator['tempDate'] = $dateListvalue;
                                $temp_vendilator[$prefix] = null;
                                $vendilator_temp_use[] = $temp_vendilator;
                                $prefix_min = $prefix;

                                $mid_value = $prefix;
                            }

                        }
                    }

                }

                $min = collect($vendilator)->where($prefix_min, '<>', '')->pluck($prefix_min)->min();
                $min = $min - 1 > 0 ? $min - 1 : $min;

                foreach ($vendilator_temp_use as & $value)
                {
                    $temp_date = $value['tempDate'] . ' ' . $value['date'];

                    $event = '';
                    if (isset($event_list[$temp_date]))
                    {
                        $event .= '<table>';
                        $event .= '<tbody>';
                        foreach ($event_list[$temp_date] as $event_key => $event_value)
                        {
                            $event .= '<tr>';
                            $event .= '<td style="font-size: 12px; white-space: nowrap;">';
                            $event .= $event_value->event;
                            $event .= '</td>';
                            $event .= '<td style="color: #FF6961; font-size: 11px; white-space: nowrap;">';

                            if (isset($event_value->temp_stop))
                            {
                                if (strtotime($temp_date) == strtotime($event_value->temp_start))
                                {
                                    $event .= '(' . $event_value->start_datetime . ' to ...)';
                                }
                                elseif (strtotime($temp_date) == strtotime($event_value->temp_stop))
                                {
                                    $event .= '(... to ' . $event_value->stop_datetime . ')';
                                }
                            }
                            else
                            {
                                $event .= '(' . $event_value->start_datetime . ' to ' . $event_value->stop_datetime . ')';
                            }
                            $event .= '</td>';
                            $event .= '</tr>';
                        }
                        $event .= '</tbody>';
                        $event .= '</table>';
                    }
                    $value['event_option'] = strlen($event) > 0 ? $min : null;
                    $value['event'] = strlen($event) > 0 ? $event : null;
                    $value['bullet'] = url('/') . "/public/img/event.png";
                }

                if (count($ventilator_box_label) > 0)
                {

                    foreach ($vendilator_temp_use as & $value)
                    {
                        $value['date'] = $value['tempDate'] . ' ' . $value['date'];
                    }

                }
                else
                {

                    foreach ($vendilator_temp_use as $key => & $value)
                    {
                        $value['date'] = $value['tempDate'] . ' ' . $value['date'];
                        $value['time'] = $value['date'];
                    }
                }
                $vendilator = $vendilator_temp_use;

                // setting zoom position start
                if (isset($vendilator)) {
                    $todayDate = collect($vendilator)->unique('tempDate')->last() ['tempDate'];
                    $zoomPosition = array_keys(collect($vendilator)->where('tempDate', $todayDate)->toArray()) [0];
                }
            }

        }

        $start_date = $vendilator_periods['period_start'] != '' ? date('d-m-Y', strtotime($vendilator_periods['period_start'])) : '';
        $end_date = $vendilator_periods['period_end'] != '' ? date('d-m-Y', strtotime($vendilator_periods['period_end'])) : '';

        return \Response::json(['values' => $vendilator, 'parameter_count' => $parameter_count, 'ventilator_label' => $ventilator_label, 'zoomPosition' => $zoomPosition, 'chart_type' => $chart_type, 'mid_value' => $mid_value, 'map_param' => $map_param], 200);

    }
}

