<?php
namespace App\Http\Controllers\Nurse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Nurse\EmrLogDetails;
use App\Models\Nurse\EmrLogHeader;
use Carbon\Carbon;
use App\Models\Admission;
use App\Models\DischargeLog;

/**
 * All the method  to create vitals nurse chart
 *
 * @author Manikandan M
 */

class MachineVitalsChartController extends Controller
{

    public function __construct(NurseChartPropertyController $chart_property)
    {
        $this->chart_property = $chart_property;
        $this->time_zone = env('TIME_ZONE');
    }

    /**
     * This method to create vitals from machine data
     * single view chart
     *
     * @param $input type array
     *
     * @param $baby_id type integer
     *
     * @param $periods type array
     *
     * @return type array
     */
    public function getviatlsfrommachine($input, $baby_id, $admission_id, $periods, $selected_date = '', $box_parameter_list, $dot_parameter_list)
    {
        $parameter_data = array();

        /*To check discharge status */
        // $admission_id = Admission::get_baby_lists($baby_id)->AdmissionId;
        $discharge_log = DischargeLog::getDischargeDetail($baby_id, $admission_id);
        $is_discharged = false;
        if (count($discharge_log) > 0)
        {
            $is_discharged = true;
        }
        $type = ($is_discharged === true) ? 'discharged' : 'inPatient';

        $parameter_list = array_merge($box_parameter_list, $dot_parameter_list);

        $results = EmrLogHeader::getmachinevitaldata($baby_id, $admission_id, $parameter_list, '', $periods, $type, $selected_date);

        $vitals['parameters'] = collect($results)->pluck('local_description', 'local_code')->toArray();

        $vital_box_results = collect($results)->where('chart_type', true);

        $vital_box_results = $vital_box_results->sortBy('issued')->toArray(); 

        $map_param = [];

        if (count($vital_box_results) > 0)
        {
            foreach ($vital_box_results as $temp_value_details_key => $temp_value_details_value)
            {
                $prefix = str_replace('_', '', $temp_value_details_value->local_code);
                $temp_details_data['date'] = Carbon::createFromTimestamp(strtotime($temp_value_details_value->date))
                ->format('H') . ':00';
                $temp_details_data['tempDate'] = Carbon::createFromTimestamp(strtotime($temp_value_details_value->date))
                ->format('d-M-y');

                $temp_details_data[$prefix . 'low'] = $temp_value_details_value->low;
                $temp_details_data[$prefix . 'open'] = $temp_value_details_value->open;
                $temp_details_data[$prefix . 'mid'] = $temp_value_details_value->mid;
                $temp_details_data[$prefix . 'close'] = $temp_value_details_value->close;
                $temp_details_data[$prefix . 'high'] = $temp_value_details_value->high;
                $property = $temp_value_details_value->local_code.':'.$prefix . 'mid:'.$temp_value_details_value->color_code. ':'.$temp_value_details_value->chart_type;
                $parameter_data[$property][] = $temp_details_data;

                $map_param[$temp_value_details_value->local_code] = $property;
                unset($temp_details_data);
            }
            unset($temp_value_details);
        }

        $vital_dot_results = collect($results)->where('chart_type', false);
                
        $vital_dot_results = $vital_dot_results->sortBy('issued')->toArray();

        if (count($vital_dot_results) > 0)
        {

            foreach ($vital_dot_results as $temp_value_details_key => $temp_value_details_value)
            {
                $prefix = str_replace('_', '', $temp_value_details_value->local_code);
                $temp_details_data['date'] = Carbon::createFromTimestamp(strtotime($temp_value_details_value->date))
                ->format('H') . ':00';
                $temp_details_data['tempDate'] = Carbon::createFromTimestamp(strtotime($temp_value_details_value->date))
                ->format('d-M-y');

                $temp_details_data[$prefix] = $temp_value_details_value->mid;
                $property = $temp_value_details_value->local_code.':'.$prefix . ':'.$temp_value_details_value->color_code. ':'.$temp_value_details_value->chart_type;
                $parameter_data[$property][] = $temp_details_data;

                $map_param[$temp_value_details_value->local_code] = $property;
                unset($temp_details_data);
            }
            unset($temp_value_details);
        }

        $vitals['parameter_data'] = $parameter_data;
        $vitals['map_param'] = $map_param;

        // if (in_array('t1_t2', $input['parameters']) && $t1_t2_single_view == 1 && isset($vitals['peripheral_temp']))
        // {
        //     unset($vitals['peripheral_temp']);
        // }

        // if (in_array('t1_t2', $input['parameters']) && $t1_t2_single_view == 1 && isset($vitals['core_temp']))
        // {
        //     unset($vitals['core_temp']);
        // }
        return $vitals;
    }

    /** 
     * This method for create compare vitals chart from
     * machine data
     *
     * @param $input type array
     *
     * @param $baby_id type integer
     *
     * @param $periods type array
     *
     * @return type array
     */
    public function getviatlsfrommachinecompare($input, $baby_id, $periods)
    {

        $parameter_data = EmrLogHeader::getmachinedata($baby_id, $input['parameters'], '', $periods);
        $vitals_group = $vitals = array();

        foreach ($parameter_data as & $value)
        {
            $value->issued_date = date('d-m-Y H:i:s', strtotime($value->issued));
        }
        $date_list = $parameter_data->unique('issued_date')
        ->pluck('issued_date');

        foreach ($date_list as $date_list_key => $date_list_value)
        {
            foreach ($this
                ->chart_property->vitals_group_one as $key => $value)
            {
                $value_set = $parameter_data->where('issued_date', $date_list_value)->where('local_code', $value)->first();
                $prefix = str_replace('_', '', $value);

                if (count($value_set) > 0)
                {
                    $temp_vitals['date'] = Carbon::createFromTimestamp(strtotime($value_set->issued))
                    ->format('d-M-y H:i:s');
                    $temp_vitals[$prefix . 'open'] = $value_set->open;
                    $temp_vitals[$prefix . 'high'] = $value_set->high;
                    $temp_vitals[$prefix . 'mid'] = $value_set->mid;
                    $temp_vitals[$prefix . 'low'] = $value_set->low;
                    $temp_vitals[$prefix . 'close'] = $value_set->close;
                    $temp_vitals['slug'] = $value;
                    $vitals[] = $temp_vitals;
                    unset($temp_vitals);
                    $t1_t2 = $this->getCalculateT1T2difference($parameter_data, $date_list_value, '1', $vitals);
                    if (count($t1_t2) > 0)
                    {
                        $vitals[] = $t1_t2;
                    }

                }

            }
        }
        if (count($vitals) > 0)
        {
            $main_vitals['vitals_group1'] = $vitals;
        }

        $vitals = array();

        foreach ($date_list as $date_list_key => $date_list_value)
        {
            foreach ($this
                ->chart_property->vitals_group_two as $key => $value)
            {
                $value_set = $parameter_data->where('issued_date', $date_list_value)->where('local_code', $value)->first();
                $prefix = str_replace('_', '', $value);

                if (count($value_set) > 0)
                {
                    $temp_vitals['date'] = Carbon::createFromTimestamp(strtotime($value_set->issued))
                    ->format('d-M-y H:i:s');
                    $temp_vitals[$prefix . 'open'] = $value_set->open;
                    $temp_vitals[$prefix . 'high'] = $value_set->high;
                    $temp_vitals[$prefix . 'mid'] = $value_set->mid;
                    $temp_vitals[$prefix . 'low'] = $value_set->low;
                    $temp_vitals[$prefix . 'close'] = $value_set->close;
                    $temp_vitals['slug'] = $value;
                    $vitals[] = $temp_vitals;
                    unset($temp_vitals);

                }

            }
        }
        if (count($vitals) > 0)
        {
            $main_vitals['vitals_group2'] = $vitals;
        }
        $vitals = array();

        foreach ($date_list as $date_list_key => $date_list_value)
        {
            foreach ($this
                ->chart_property->vitals_group_three as $key => $value)
            {
                $value_set = $parameter_data->where('issued_date', $date_list_value)->where('local_code', $value)->first();
                $prefix = str_replace('_', '', $value);

                if (count($value_set) > 0)
                {
                    $temp_vitals['date'] = Carbon::createFromTimestamp(strtotime($value_set->issued))
                    ->format('d-M-y H:i:s');
                    $temp_vitals[$prefix . 'open'] = $value_set->open;
                    $temp_vitals[$prefix . 'high'] = $value_set->high;
                    $temp_vitals[$prefix . 'mid'] = $value_set->mid;
                    $temp_vitals[$prefix . 'low'] = $value_set->low;
                    $temp_vitals[$prefix . 'close'] = $value_set->close;
                    $temp_vitals['slug'] = $value;
                    $vitals[] = $temp_vitals;
                    unset($temp_vitals);

                }

            }
        }
        if (count($vitals) > 0)
        {
            $main_vitals['vitals_group3'] = $vitals;
        }

        $vitals = array();

        foreach ($date_list as $date_list_key => $date_list_value)
        {
            foreach ($this
                ->chart_property->vitals_group_four as $key => $value)
            {
                $value_set = $parameter_data->where('issued_date', $date_list_value)->where('local_code', $value)->first();
                $prefix = str_replace('_', '', $value);

                if (count($value_set) > 0)
                {
                    $temp_vitals['date'] = Carbon::createFromTimestamp(strtotime($value_set->issued))
                    ->format('d-M-y H:i:s');
                    $temp_vitals[$prefix . 'open'] = $value_set->open;
                    $temp_vitals[$prefix . 'high'] = $value_set->high;
                    $temp_vitals[$prefix . 'mid'] = $value_set->mid;
                    $temp_vitals[$prefix . 'low'] = $value_set->low;
                    $temp_vitals[$prefix . 'close'] = $value_set->close;
                    $temp_vitals['slug'] = $value;
                    $vitals[] = $temp_vitals;
                    unset($temp_vitals);

                }

            }
        }

        if (count($vitals) > 0)
        {
            $main_vitals['vitals_group4'] = $vitals;
        }
        $vitals = $main_vitals;

        return $vitals;

    }

    private function getCalculateT1T2difference($t1_t2_sample, $date_values_value, $slug, $t1_t2 = array())
    {
        $temp_t1_t2 = array();
        if ($slug == 1)
        {
            $tempt1t2_date = date('d-M-y', strtotime($date_values_value));
            $tempcalc = collect($t1_t2_sample);

            $t1_t2 = collect($t1_t2)->where('date', date('d-M-y H:i:s', strtotime($date_values_value)))->where('slug', 't1_t2');
            if (count($t1_t2) == 0)
            {
                $temp_t1_t2['date'] = date('d-M-y H:i:s', strtotime($date_values_value));
                $temp_date = date('d-m-Y H:i:s', strtotime($temp_t1_t2['date']));

                $coretemphigh = $tempcalc->where('issued_date', $temp_date)->where('local_code', 'core_temp')
                ->pluck('high')
                ->first();
                $coretemplow = $tempcalc->where('issued_date', $temp_date)->where('local_code', 'core_temp')
                ->pluck('low')
                ->first();
                $coretempmid = $tempcalc->where('issued_date', $temp_date)->where('local_code', 'core_temp')
                ->pluck('mid')
                ->first();
                $coretempclose = $tempcalc->where('issued_date', $temp_date)->where('local_code', 'core_temp')
                ->pluck('close')
                ->first();
                $coretempopen = $tempcalc->where('issued_date', $temp_date)->where('local_code', 'core_temp')
                ->pluck('open')
                ->first();

                $peripheraltemphigh = $tempcalc->where('issued_date', $temp_date)->where('local_code', 'peripheral_temp')
                ->pluck('high')
                ->first();
                $peripheraltemplow = $tempcalc->where('issued_date', $temp_date)->where('local_code', 'peripheral_temp')
                ->pluck('low')
                ->first();
                $peripheraltempmid = $tempcalc->where('issued_date', $temp_date)->where('local_code', 'peripheral_temp')
                ->pluck('mid')
                ->first();
                $peripheraltempclose = $tempcalc->where('issued_date', $temp_date)->where('local_code', 'peripheral_temp')
                ->pluck('close')
                ->first();
                $peripheraltempopen = $tempcalc->where('issued_date', $temp_date)->where('local_code', 'peripheral_temp')
                ->pluck('open')
                ->first();

                $temp_t1_t2['t1t2high'] = number_format($coretemphigh - $peripheraltemphigh, 1);
                $temp_t1_t2['t1t2low'] = number_format($coretemplow - $peripheraltemplow, 1);
                $temp_t1_t2['t1t2mid'] = number_format($coretempmid - $peripheraltempmid, 1);
                $temp_t1_t2['t1t2close'] = number_format($coretempclose - $peripheraltempclose, 1);
                $temp_t1_t2['t1t2open'] = number_format($coretempopen - $peripheraltempopen, 1);
                $temp_t1_t2['slug'] = 't1_t2';

                return $temp_t1_t2;

            }
            else
            {

                return $temp_t1_t2;

            }

        }
        elseif ($slug == 2)
        {

            $date_values_value = date('d-m-Y H:i:s', strtotime($date_values_value));
            $temp_date = date('d-M-y H:i:s', strtotime($date_values_value));

            $coretemphigh = $t1_t2_sample->where('issued_date', $date_values_value)->where('local_code', 'core_temp')
            ->pluck('high')
            ->first();
            $coretemplow = $t1_t2_sample->where('issued_date', $date_values_value)->where('local_code', 'core_temp')
            ->pluck('low')
            ->first();
            $coretempmid = $t1_t2_sample->where('issued_date', $date_values_value)->where('local_code', 'core_temp')
            ->pluck('mid')
            ->first();
            $coretempclose = $t1_t2_sample->where('issued_date', $date_values_value)->where('local_code', 'core_temp')
            ->pluck('close')
            ->first();
            $coretempopen = $t1_t2_sample->where('issued_date', $date_values_value)->where('local_code', 'core_temp')
            ->pluck('open')
            ->first();

            $peripheraltemphigh = $t1_t2_sample->where('issued_date', $date_values_value)->where('local_code', 'peripheral_temp')
            ->pluck('high')
            ->first();
            $peripheraltemplow = $t1_t2_sample->where('issued_date', $date_values_value)->where('local_code', 'peripheral_temp')
            ->pluck('low')
            ->first();
            $peripheraltempmid = $t1_t2_sample->where('issued_date', $date_values_value)->where('local_code', 'peripheral_temp')
            ->pluck('mid')
            ->first();
            $peripheraltempclose = $t1_t2_sample->where('issued_date', $date_values_value)->where('local_code', 'peripheral_temp')
            ->pluck('close')
            ->first();
            $peripheraltempopen = $t1_t2_sample->where('issued_date', $date_values_value)->where('local_code', 'peripheral_temp')
            ->pluck('open')
            ->first();

            $t1_exists = collect($t1_t2)->where('date', $temp_date);

            if (!empty($coretemphigh) & count($t1_exists) == 0)
            {
                $temp_t1_t2['date'] = date('d-M-y H:i:s', strtotime($date_values_value));
                $temp_t1_t2['t1t2high'] = number_format($coretemphigh - $peripheraltemphigh, 1);
                $temp_t1_t2['t1t2low'] = number_format($coretemplow - $peripheraltemplow, 1);
                $temp_t1_t2['t1t2mid'] = number_format($coretempmid - $peripheraltempmid, 1);
                $temp_t1_t2['t1t2close'] = number_format($coretempclose - $peripheraltempclose, 1);
                $temp_t1_t2['t1t2open'] = number_format($coretempopen - $peripheraltempopen, 1);
                return $temp_t1_t2;
            }

            return $temp_t1_t2;

        }
        return $temp_t1_t2;

    }

    /**
     * This method for get box whishker plot
     *
     * @param $parameter type array
     * @param $day_details type array
     * @return $vitals type array
     */
    public function getvitalsboxwhisker($parameter, $day_details)
    {

        foreach ($parameter as $parameterkey => $parametervalue)
        {

            $temp_vital = $day_details->where('local_code', $parametervalue);

            foreach ($temp_vital as $temp_vital_key => $temp_vital_value)
            {
                $temp_vital_value->sender_time = date('Y-m-d', strtotime($temp_vital_value->sender_time));

            }

            $temp_date_temp = $temp_vital->unique('sender_time')
            ->pluck('sender_time')
            ->toArray();

            foreach ($temp_date_temp as $date_key => $date_value)
            {
                $temp_vitals = array();

                $date_wise = $temp_vital->where('sender_time', $date_value)->sortBy('intf_ref_value');
                $prefix = str_replace('_', '', $parametervalue);
                $median = '';

                if (count($date_wise) >= 4)
                {

                    $key_temp_date = date('d-M-y', strtotime($date_value));
                    $temp_vitals['date'] = date('d-M-y', strtotime($date_value));
                    $temp_vitals[$prefix . 'high'] = $date_wise->max('intf_ref_value');
                    $temp_vitals[$prefix . 'low'] = $date_wise->min('intf_ref_value');

                    if (is_int(count($date_wise) / 2))
                    {

                        $median_one_index = (count($date_wise) / 2) - 1;
                        $median_two_index = $median_one_index + 1;
                        $temp_date_wise = $date_wise->values()
                        ->toArray();

                        $temp_date_wise[$median_one_index]->intf_ref_value = preg_replace('/[^0-9\.]/', '', $temp_date_wise[$median_one_index]->intf_ref_value);
                        $temp_date_wise[$median_two_index]->intf_ref_value = preg_replace('/[^0-9\.]/', '', $temp_date_wise[$median_two_index]->intf_ref_value);

                        $temp_vitals[$prefix . 'mid'] = number_format(($temp_date_wise[$median_one_index]->intf_ref_value + $temp_date_wise[$median_two_index]->intf_ref_value) / 2, 2);

                    }
                    elseif (is_float(count($date_wise) / 2))
                    {
                        $median = (round(count($date_wise) / 2)) - 1;
                        $temp_date_wise = $date_wise->values()
                        ->toArray();
                        $temp_date_wise[$median]->intf_ref_value = preg_replace('/[^0-9\.]/', '', $temp_date_wise[$median]->intf_ref_value);

                        $temp_vitals[$prefix . 'mid'] = $temp_date_wise[$median]->intf_ref_value;

                    }
                    $quartiles = $date_wise->split('2');
                    $temp_quartile = $quartiles[0]->values()
                    ->toArray();
                    if (is_int(count($temp_quartile) / 2))
                    {

                        $quartiles_median_one = (count($temp_quartile) / 2) - 1;
                        $quartiles_median_two = $quartiles_median_one + 1;

                        $temp_quartile[$quartiles_median_one]->intf_ref_value = preg_replace('/[^0-9\.]/', '', $temp_quartile[$quartiles_median_one]->intf_ref_value);
                        $temp_quartile[$quartiles_median_two]->intf_ref_value = preg_replace('/[^0-9\.]/', '', $temp_quartile[$quartiles_median_two]->intf_ref_value);

                        $temp_vitals[$prefix . 'close'] = ($temp_quartile[$quartiles_median_one]->intf_ref_value + $temp_quartile[$quartiles_median_two]->intf_ref_value) / 2;

                    }
                    elseif (is_float(count($temp_quartile) / 2) && isset($temp_quartile[$median]->intf_ref_value))
                    {

                        $temp_quartile[$median]->intf_ref_value = preg_replace('/[^0-9\.]/', '', $temp_quartile[$median]->intf_ref_value);
                        $median = (round((count($temp_quartile) / 2))) - 1;
                        $temp_vitals[$prefix . 'close'] = $temp_quartile[$median]->intf_ref_value;

                    }

                    $temp_quartile = $quartiles[1]->values()
                    ->toArray();
                    if (is_int(count($temp_quartile) / 2))
                    {

                        $quartiles_median_one = (count($temp_quartile) / 2) - 1;
                        $quartiles_median_two = $quartiles_median_one + 1;
                        $temp_quartile[$quartiles_median_one]->intf_ref_value = preg_replace('/[^0-9\.]/', '', $temp_quartile[$quartiles_median_one]->intf_ref_value);
                        $temp_quartile[$quartiles_median_two]->intf_ref_value = preg_replace('/[^0-9\.]/', '', $temp_quartile[$quartiles_median_two]->intf_ref_value);
                        $temp_vitals[$prefix . 'open'] = ($temp_quartile[$quartiles_median_one]->intf_ref_value + $temp_quartile[$quartiles_median_two]->intf_ref_value) / 2;

                    }
                    elseif (is_float(count($temp_quartile) / 2))
                    {

                        $median = (round((count($temp_quartile) / 2))) - 1;
                        $temp_quartile[$median]->intf_ref_value = preg_replace('/[^0-9\.]/', '', $temp_quartile[$median]->intf_ref_value);
                        $temp_vitals[$prefix . 'open'] = $temp_quartile[$median]->intf_ref_value;

                    }

                }
                $date_vitals[$parametervalue][] = $temp_vitals;
                unset($temp_vitals);

            }

        }

        $vitals = $date_vitals;

        return $vitals;
    }

    /**
     * This method for get box whishker plot compare
     *
     * @param $parameter type array
     * @param $day_details type array
     * @return $vitals type array
     */
    public function vitalsboxwhiskercompare($parameter, $day_details, $date_vitals)
    {
        $date_values = array();

        $temp_date_values = $day_details->whereIn('local_code', $parameter)->unique('sender_time')
        ->pluck('sender_time')
        ->toArray();

        foreach ($temp_date_values as $key => $value)
        {
            $date_values[] = date('Y-m-d', strtotime($value));
        }

        $date_values = collect($date_values)->unique()
        ->toArray();

        foreach ($date_values as $date_values_key => $date_values_value)
        {

            foreach ($parameter as $parameterkey => $parametervalue)
            {

                $temp_vitals = array();

                $temp_vital = $day_details->where('local_code', $parametervalue);
                foreach ($temp_vital as $temp_vital_key => $temp_vital_value)
                {
                    $temp_vital_value->sender_time = date('Y-m-d', strtotime($temp_vital_value->sender_time));

                }

                $date_wise = $temp_vital->where('sender_time', date('Y-m-d', strtotime($date_values_value)))->sortBy('intf_ref_value');

                $prefix = str_replace('_', '', $parametervalue);

                if (count($date_wise) >= 4)
                {

                    $key_temp_date = date('d-M-y', strtotime($date_values_value));
                    $temp_vitals['date'] = date('d-M-y', strtotime($date_values_value));
                    $temp_vitals[$prefix . 'high'] = $date_wise->max('intf_ref_value');
                    $temp_vitals[$prefix . 'low'] = $date_wise->min('intf_ref_value');

                    if (is_int(count($date_wise) / 2))
                    {

                        $median_one_index = (count($date_wise) / 2) - 1;
                        $median_two_index = $median_one_index + 1;
                        $temp_date_wise = $date_wise->values()
                        ->toArray();

                        $temp_date_wise[$median_one_index]->intf_ref_value = preg_replace('/[^0-9\.]/', '', $temp_date_wise[$median_one_index]->intf_ref_value);
                        $temp_date_wise[$median_two_index]->intf_ref_value = preg_replace('/[^0-9\.]/', '', $temp_date_wise[$median_two_index]->intf_ref_value);

                        $temp_vitals[$prefix . 'mid'] = number_format(($temp_date_wise[$median_one_index]->intf_ref_value + $temp_date_wise[$median_two_index]->intf_ref_value) / 2, 2);

                    }
                    elseif (is_float(count($date_wise) / 2))
                    {
                        $median = (round(count($date_wise) / 2)) - 1;
                        $temp_date_wise = $date_wise->values()
                        ->toArray();

                        $temp_date_wise[$median]->intf_ref_value = preg_replace('/[^0-9\.]/', '', $temp_date_wise[$median]->intf_ref_value);
                        $temp_vitals[$prefix . 'mid'] = $temp_date_wise[$median]->intf_ref_value;

                    }
                    $quartiles = $date_wise->split('2');

                    $temp_quartile = $quartiles[0]->values()
                    ->toArray();
                    if (is_int(count($temp_quartile) / 2))
                    {

                        $quartiles_median_one = (count($temp_quartile) / 2) - 1;
                        $quartiles_median_two = $quartiles_median_one + 1;

                        $temp_quartile[$quartiles_median_one]->intf_ref_value = preg_replace('/[^0-9\.]/', '', $temp_quartile[$quartiles_median_one]->intf_ref_value);
                        $temp_quartile[$quartiles_median_two]->intf_ref_value = preg_replace('/[^0-9\.]/', '', $temp_quartile[$quartiles_median_two]->intf_ref_value);

                        $temp_vitals[$prefix . 'close'] = ($temp_quartile[$quartiles_median_one]->intf_ref_value + $temp_quartile[$quartiles_median_two]->intf_ref_value) / 2;

                    }
                    elseif (is_float(count($temp_quartile) / 2))
                    {

                        $median = (round((count($temp_quartile) / 2))) - 1;
                        $temp_quartile[$median]->intf_ref_value = preg_replace('/[^0-9\.]/', '', $temp_quartile[$median]->intf_ref_value);
                        $temp_vitals[$prefix . 'close'] = $temp_quartile[$median]->intf_ref_value;

                    }

                    $temp_quartile = $quartiles[1]->values()
                    ->toArray();
                    if (is_int(count($temp_quartile) / 2))
                    {

                        $quartiles_median_one = (count($temp_quartile) / 2) - 1;
                        $quartiles_median_two = $quartiles_median_one + 1;

                        $temp_quartile[$quartiles_median_one]->intf_ref_value = preg_replace('/[^0-9\.]/', '', $temp_quartile[$quartiles_median_one]->intf_ref_value);
                        $temp_quartile[$quartiles_median_two]->intf_ref_value = preg_replace('/[^0-9\.]/', '', $temp_quartile[$quartiles_median_two]->intf_ref_value);

                        $temp_vitals[$prefix . 'open'] = ($temp_quartile[$quartiles_median_one]->intf_ref_value + $temp_quartile[$quartiles_median_two]->intf_ref_value) / 2;

                    }
                    elseif (is_float(count($temp_quartile) / 2))
                    {

                        $median = (round((count($temp_quartile) / 2))) - 1;
                        $temp_quartile[$median]->intf_ref_value = preg_replace('/[^0-9\.]/', '', $temp_quartile[$median]->intf_ref_value);
                        $temp_vitals[$prefix . 'open'] = $temp_quartile[$median]->intf_ref_value;

                    }
                    $vitals[] = $temp_vitals;
                    $temp_vitals['slug'] = $prefix;
                    $t1_t2_sample[] = $temp_vitals;
                    unset($temp_vitals);
                }

            }

        }
        $vitals = $date_vitals;
        return $vitals;

    }
}

