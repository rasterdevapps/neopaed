<?php
namespace App\Models\Nurse;

use Illuminate\Database\Eloquent\Model;
use App\Models\DischargeLog;

class EmrLogHeader extends Model
{
    protected $table = 'emr_log_hdr';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['intf_id', 'intf_group_seq_id', 'sender', 'sender_time', 'interface_time', 'patient_id', 'gender', 'visit_id', 'visit_date', 'loinc_version', 'active_flag', 'create_user_id', 'create_tstamp', 'modify_user_id', 'modify_tstamp', 'proc_status', 'app_id', 'device_id', 'day_id', 'baby_id', 'mother_id', 'admission_id', 'added_nurse'];

    /**
     * This method to get loinc code based on local code
     * loinc_reference_nurse is view joining of loinc_local_code_map_part, loinc_part, local_code_group tables
     * @param $local_code type string
     *
     * @return array of object data
     */
    public static function get_details($local_code)
    {

        return \DB::table('loinc_reference_nurse')->where('local_code', $local_code)->first();

    }

    /**
     * This method get join the emrlogheader and emrlogdetails
     *
     * @return array of object data
     */
    public function GetEmrMoniterValues()
    {
        return $this->hasMany('App\Models\Nurse\EmrMoniterValues', 'log_hdr_id', 'id')->orderBy('result_date_time', 'asc');
    }

    /**
     * This method get join the emrlogheader and emrlogdetails
     *
     * @return array of object data
     */
    public function GetEmrVentilatorValues()
    {
        return $this->hasMany('App\Models\Nurse\EmrVentilatorValues', 'log_hdr_id', 'id')->orderBy('result_date_time', 'asc');
    }

    /**
     * This method get join the emrlogheader and emrlogdetails_discharged
     *
     * @return array of object data
     */
    public function GetEmrLogDetailsDischarged()
    {
        return $this->hasMany('App\Models\Nurse\EmrLogDetailsDischarged', 'log_hdr_id', 'id')->orderBy('time', 'asc');
    }

    /**
     * This method to get loinc code based on local code
     * loinc_reference_nurse is view joining of loinc_local_code_map_part, loinc_part, local_code_group tables
     * @param $local_code type string
     *
     * @return array of object data
     */
    public static function get_details_all()
    {

        return \DB::table('snomed_nurse_reference')->get();

    }

    /**
     * This method to get loinc code based on local code
     * @param $local_code type string
     *
     * @return array of object data
     */
    public static function get_remove_drugs($day_id, $local_id, $list_ids)
    {

        $ids = \DB::table('emr_log_hdr')->select('emr_log_dtl.id')
            ->join('emr_log_dtl', 'emr_log_dtl.log_hdr_id', '=', 'emr_log_hdr.id')
            ->where('emr_log_hdr.day_id', $day_id)
            ->where('emr_log_dtl.loinc_local_map_id', $local_id)
            ->whereNotIn('emr_log_dtl.id', $list_ids)->get()
            ->pluck('id')
            ->toArray();
        \DB::table('emr_log_dtl')->whereIn('id', $ids)->delete();

    }

    /**
     * This method get the sender time
     *
     * @return array of object data
     */
    public static function getSenderTimeList($sheet_id)
    {
        return \DB::table('emr_log_hdr')->select('sender_time', 'day_id')->where('day_id', $sheet_id)->get();
    }

    /**
     * This method get the emr log header id
     *
     * @return array of object data
     */
    public static function getIdList($day_id)
    {
        return \DB::table('emr_log_hdr')->select('id', 'day_id')->where('day_id', $day_id)->get();
    }

    /**
     * This method get the reference table values
     *
     * @return array of object data
     */
    public static function getLoincReferenceDetail($value)
    {
        return \DB::table('loinc_reference_nurse')->where('local_code', $value)->first();
    }

    /**
     * This method get the emr log header id
     *
     * @return array of object data
     */
    public static function getEmrLogHdrId($sheet_id, $sheetTime)
    {
        return \DB::table('emr_log_hdr')->select('id')->where('day_id', $sheet_id)->where('sender_time', $sheetTime)->first();
    }

    /**
     * This method get the emr log header
     *
     * @return array of object data
     */
    public static function getEmrLogHdr($baby_id, $admission_id, $start_time, $end_time)
    {

        return \DB::table('emr_log_hdr')->select('*')
            ->where('baby_id', $baby_id)
            ->where('admission_id', $admission_id)
            ->where('sender_time', '>=', date('Y-m-d H:i:s', strtotime($start_time)))
            ->where('sender_time', '<', date('Y-m-d H:i:s', strtotime($end_time)))
            ->orderBy('sender_time', 'asc')
            ->get();
    }
    /**
     * This method get the emr log header
     *
     * @return array of object data
     */
    public static function getEmrLogHdrWithNSofaScore($baby_id, $admission_id, $start_time, $end_time)
    {

        $startTimeFormatted = date('Y-m-d H:i:s', strtotime($start_time));
        $endTimeFormatted = date('Y-m-d H:i:s', strtotime($end_time));

        $results = \DB::table('emr_log_hdr')
            ->select('emr_log_hdr.*', 'n_sofa_score.total_nsofa_score')
            ->leftJoin('n_sofa_score', 'n_sofa_score.log_hdr_id', '=', 'emr_log_hdr.id')
            ->where('emr_log_hdr.baby_id', $baby_id)
            ->where('emr_log_hdr.admission_id', $admission_id)
            ->where('emr_log_hdr.sender_time', '>=', $startTimeFormatted)
            ->where('emr_log_hdr.sender_time', '<', $endTimeFormatted)
            ->orderBy('emr_log_hdr.sender_time', 'asc')
            ->get();

        return $results;
    }

    /**
     * This method get the local code details
     *
     * @return array of object data
     */
    public static function getLocalCode($local_map_id)
    {
        return \DB::table('local_code_group')->select('local_code')->where('id', $local_map_id)->first();
    }
    /**
     * This method get the emr values from various tables
     *
     * @return array of object data
     */
    public static function get_emr_values($header_id, $table_name)
    {
        // echo $header_id; exit;

        if ($table_name == 'emr_log_dtl') {
            return \DB::table($table_name)->select($table_name . '.*', 'emr_log_dtl.create_tstamp as result_date_time', 'local_code_group.local_code')->join('local_code_group', 'local_code_group.id', '=', $table_name . '.loinc_local_map_id')->where('log_hdr_id', $header_id)->orderBy('result_date_time', 'desc')->get();
        } else {
            return \DB::table($table_name)->select($table_name . '.*', 'local_code_group.local_code')->join('local_code_group', 'local_code_group.id', '=', $table_name . '.loinc_local_map_id')->where('log_hdr_id', $header_id)->whereNotNull('intf_ref_value')->where('intf_ref_value', '<>', '')->orderBy('result_date_time', 'desc')->get();
        }
        
    }

    /**
     * This method to get graphical data
     *
     * @param $baby_id type integer
     * @param $periods_start date
     * @param $periods_end   date
     */
    public static function getgraphicaldata($baby_id, $periods_start, $periods_end, $vendilator_parameters = array() , $type = '')
    {

        $results = \DB::table('nurse_main_sheet')->select('emr_log_hdr.sender_time', 'emr_log_hdr.id')
            ->join('emr_log_hdr', 'emr_log_hdr.day_id', '=', 'nurse_main_sheet.id');
        if ($periods_start != '' && $periods_end != '')
        {
            $results = $results->whereBetween('nurse_main_sheet.sheet_date', [$periods_start, $periods_end]);
        }

        $results = $results->where('nurse_main_sheet.baby_id', '=', $baby_id)->orderBy('emr_log_hdr.sender_time', 'asc')
            ->get();
        $return_array = array();
        if (count($results) > 0)
        {
            if ($type == 'discharged')
            {
                foreach ($results as $key => $result)
                {
                    $moniter_values = \DB::table('emr_moniter_values_discharged')->select('intf_ref_value', 'local_code_group.local_code')
                        ->join('local_code_group', 'local_code_group.id', '=', 'emr_moniter_values_discharged.loinc_local_map_id')
                        ->whereIn('local_code_group.local_code', $vendilator_parameters)->where('emr_moniter_values_discharged.log_hdr_id', $result->id)
                        ->get()
                        ->toArray();
                    $ventilator_values = \DB::table('emr_ventilator_values_discharged')->select('intf_ref_value', 'local_code_group.local_code')
                        ->join('local_code_group', 'local_code_group.id', '=', 'emr_ventilator_values_discharged.loinc_local_map_id')
                        ->whereIn('local_code_group.local_code', $vendilator_parameters)->where('emr_ventilator_values_discharged.log_hdr_id', $result->id)
                        ->get()
                        ->toArray();
                    $merged_values = array_merge($moniter_values, $ventilator_values);
                    foreach ($merged_values as $merged_key => $value)
                    {
                        $value->sender_time = $result->sender_time;
                    }
                    $return_array = array_merge($return_array, $merged_values);
                }
            }
            else
            {
                foreach ($results as $key => $result)
                {
                    $moniter_values = \DB::table('emr_moniter_values')->select('intf_ref_value', 'local_code_group.local_code')
                        ->join('local_code_group', 'local_code_group.id', '=', 'emr_moniter_values.loinc_local_map_id')
                        ->whereIn('local_code_group.local_code', $vendilator_parameters)->where('emr_moniter_values.log_hdr_id', $result->id)
                        ->whereRaw("emr_moniter_values.result_date_time >= now() - interval '2 days'")
                        ->get()
                        ->toArray();
                    $ventilator_values = \DB::table('emr_ventilator_values')->select('intf_ref_value', 'local_code_group.local_code')
                        ->join('local_code_group', 'local_code_group.id', '=', 'emr_ventilator_values.loinc_local_map_id')
                        ->whereIn('local_code_group.local_code', $vendilator_parameters)->where('emr_ventilator_values.log_hdr_id', $result->id)
                        ->whereRaw("emr_ventilator_values.result_date_time >= now() - interval '2 days'")
                        ->get()
                        ->toArray();
                    $merged_values = array_merge($moniter_values, $ventilator_values);
                    foreach ($merged_values as $merged_key => $value)
                    {
                        $value->sender_time = $result->sender_time;
                    }
                    $return_array = array_merge($return_array, $merged_values);
                }
            }
        }
        return $return_array;
    }
    /**
     * This method to get data for graph from machine
     *VENTILATOR DATA
     * $baby_id
     */
    public static function getmachinedata($baby_id, $admission_id, $local_code, $ip_number = '', $periods = array() , $type = '', $selected_date = '')
    {

        if ($type == 'discharged')
        {

            $ventilator = \DB::table('local_code_group')->select('low', 'first_quartile as open', 'mean as mid', 'last_quartile as close', 'close as high', 'local_code', 'result_date_time as issued', 'local_description', 'color_code', 'chart_type')
                ->selectRaw("date(result_date_time) as date")
                ->join('loinc_local_code_map_part', 'loinc_local_code_map_part.ref_loc_master_id', '=', 'local_code_group.id')
                ->join('emr_ventilator_values_discharged', 'emr_ventilator_values_discharged.loinc_local_map_id', '=', 'loinc_local_code_map_part.ref_loc_master_id')
                ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_ventilator_values_discharged.log_hdr_id')
                ->whereIn('local_code_group.local_code', $local_code)
                ->where('mean', '<>', '')
                ->whereNotNull('mean')
                ->where('emr_log_hdr.baby_id', $baby_id)
                ->where('emr_log_hdr.admission_id', $admission_id);

            if ($selected_date != '')
            {
                $ventilator->whereRaw("emr_ventilator_values_discharged.result_date_time::date='" . $selected_date . "'");
            }

            if (isset($periods['period_start']) && isset($periods['period_start']) && $periods['period_start'] != '' && $periods['period_end'] != '')
            {
                $ventilator = $ventilator->whereRaw('result_date_time::date between \'' . $periods['period_start'] . '\' and \'' . $periods['period_end'] . '\'');
            }
            $results = $ventilator->orderBy('result_date_time', 'asc')
                ->get();
        }
        else
        {
            $ventilator = \DB::table('local_code_group')->select('low', 'first_quartile as open', 'mean as mid', 'last_quartile as close', 'close as high', 'local_code', 'result_date_time as issued', 'local_description', 'color_code', 'chart_type')
                ->selectRaw("date(result_date_time) as date")
                ->join('loinc_local_code_map_part', 'loinc_local_code_map_part.ref_loc_master_id', '=', 'local_code_group.id')
                ->join('emr_ventilator_values', 'emr_ventilator_values.loinc_local_map_id', '=', 'loinc_local_code_map_part.ref_loc_master_id')
                ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_ventilator_values.log_hdr_id')
                ->whereIn('local_code_group.local_code', $local_code)
                ->where('mean', '<>', '')
                ->whereNotNull('mean')
                ->where('emr_log_hdr.baby_id', $baby_id)
                ->where('emr_log_hdr.admission_id', $admission_id);

            if ($selected_date != '')
            {
                $ventilator->whereRaw("emr_ventilator_values.result_date_time::date='" . $selected_date . "'");
            }

            if (isset($periods['period_start']) && isset($periods['period_start']) && $periods['period_start'] != '' && $periods['period_end'] != '')
            {
                $ventilator = $ventilator->whereRaw('result_date_time::date between \'' . $periods['period_start'] . '\' and \'' . $periods['period_end'] . '\'');
            }
            $results = $ventilator->orderBy('result_date_time', 'asc')
                ->get();
        }
        return $results;

    }
    /**
     * This method to get vital data data for graph from machine
     * MONITER DATA
     * $baby_id
     */
    public static function getmachinevitaldata($baby_id, $admission_id, $local_code, $ip_number = '', $periods = array() , $type = '', $selected_date = '')
    {
        $prefix = str_replace('_', '', $local_code);
        if ($type == 'discharged')
        {
            $emr_moniter_results = \DB::table('local_code_group')
                ->select('low', 'first_quartile as open', 'mean as mid', 'last_quartile as close', 'close as high', 'local_code', 'result_date_time as issued', 'result_date_time as date', 'color_code', 'parameter_priority', 'chart_type', 'local_description')
                ->join('loinc_local_code_map_part', 'loinc_local_code_map_part.ref_loc_master_id', '=', 'local_code_group.id')
                ->join('emr_moniter_values_discharged', 'emr_moniter_values_discharged.loinc_local_map_id', '=', 'loinc_local_code_map_part.ref_loc_master_id')
                ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_moniter_values_discharged.log_hdr_id')
                ->whereNotNull('mean')
                ->where('mean', '<>', '')
                ->whereIn('local_code_group.local_code', $local_code)
                ->where('emr_log_hdr.baby_id', $baby_id)
                ->where('emr_log_hdr.admission_id', $admission_id);
            if ($selected_date != '')
            {
                $emr_moniter_results->whereRaw("emr_moniter_values_discharged.result_date_time::date='" . $selected_date . "'");
            }

            if (isset($periods['period_start']) && isset($periods['period_start']) && $periods['period_start'] != '' && $periods['period_end'] != '')
            {
                $emr_moniter_results = $emr_moniter_results->whereRaw('result_date_time::date between \'' . $periods['period_start'] . '\' and \'' . $periods['period_end'] . '\'');

            }

            $emr_manual_results = \DB::table('local_code_group')
                ->select('low', 'first_quartile as open', 'mean as mid', 'last_quartile as close', 'close as high', 'local_code', 'result_date_time as issued', 'result_date_time as date', 'color_code', 'parameter_priority', 'chart_type', 'local_description')
                ->join('loinc_local_code_map_part', 'loinc_local_code_map_part.ref_loc_master_id', '=', 'local_code_group.id')
                ->join('emr_nurse_manual_values_discharged', 'emr_nurse_manual_values_discharged.loinc_local_map_id', '=', 'loinc_local_code_map_part.ref_loc_master_id')
                ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_nurse_manual_values_discharged.log_hdr_id')
                ->whereNotNull('mean')
                ->where('mean', '<>', '')
                ->whereIn('local_code_group.local_code', $local_code)
                ->where('emr_log_hdr.baby_id', $baby_id)
                ->where('emr_log_hdr.admission_id', $admission_id);
            if ($selected_date != '')
            {
                $emr_manual_results->whereRaw("emr_nurse_manual_values_discharged.result_date_time::date='" . $selected_date . "'");
            }

            if (isset($periods['period_start']) && isset($periods['period_start']) && $periods['period_start'] != '' && $periods['period_end'] != '')
            {
                $emr_manual_results = $emr_manual_results->whereRaw('result_date_time::date between \'' . $periods['period_start'] . '\' and \'' . $periods['period_end'] . '\'');

            }

            if ($emr_moniter_results->count() > 0 && $emr_manual_results->count() > 0) {
                $results = $emr_manual_results->union($emr_moniter_results);
                $results = $results->orderby('parameter_priority', 'asc')
                ->get()->toArray();
            } else if ($emr_moniter_results->count() > 0) {
                $results = $emr_moniter_results->orderby('parameter_priority', 'asc')
                ->get()->toArray();
            } else if ($emr_manual_results->count() > 0) {
                $results = $emr_manual_results->orderby('parameter_priority', 'asc')
                ->get()->toArray();
            } else {
                $results = [];
            }
        }
        else
        {
            $emr_moniter_results = \DB::table('local_code_group')
                ->select('low', 'first_quartile as open', 'mean as mid', 'last_quartile as close', 'close as high', 'local_code', 'result_date_time as issued', 'result_date_time as date', 'color_code', 'parameter_priority', 'chart_type', 'local_description')
                ->join('loinc_local_code_map_part', 'loinc_local_code_map_part.ref_loc_master_id', '=', 'local_code_group.id')
                ->join('emr_moniter_values', 'emr_moniter_values.loinc_local_map_id', '=', 'loinc_local_code_map_part.ref_loc_master_id')
                ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_moniter_values.log_hdr_id')
                ->whereNotNull('mean')
                ->where('mean', '<>', '')
                ->whereIn('local_code_group.local_code', $local_code)
                ->where('emr_log_hdr.baby_id', $baby_id)
                ->where('emr_log_hdr.admission_id', $admission_id);
            if ($selected_date != '')
            {
                $emr_moniter_results->whereRaw("emr_moniter_values.result_date_time::date='" . $selected_date . "'");
            }
            if (isset($periods['period_start']) && isset($periods['period_start']) && $periods['period_start'] != '' && $periods['period_end'] != '')
            {
                $emr_moniter_results = $emr_moniter_results->whereRaw('result_date_time::date between \'' . $periods['period_start'] . '\' and \'' . $periods['period_end'] . '\'');
            }

            $emr_manual_results = \DB::table('local_code_group')
                ->select('low', 'first_quartile as open', 'mean as mid', 'last_quartile as close', 'close as high', 'local_code', 'result_date_time as issued', 'result_date_time as date', 'color_code', 'parameter_priority', 'chart_type', 'local_description')
                ->join('loinc_local_code_map_part', 'loinc_local_code_map_part.ref_loc_master_id', '=', 'local_code_group.id')
                ->join('emr_nurse_manual_values', 'emr_nurse_manual_values.loinc_local_map_id', '=', 'loinc_local_code_map_part.ref_loc_master_id')
                ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_nurse_manual_values.log_hdr_id')
                ->whereNotNull('mean')
                ->where('mean', '<>', '')
                ->whereIn('local_code_group.local_code', $local_code)
                ->where('emr_log_hdr.baby_id', $baby_id)
                ->where('emr_log_hdr.admission_id', $admission_id);
            if ($selected_date != '')
            {
                $emr_manual_results->whereRaw("emr_nurse_manual_values.result_date_time::date='" . $selected_date . "'");
            }
            if (isset($periods['period_start']) && isset($periods['period_start']) && $periods['period_start'] != '' && $periods['period_end'] != '')
            {
                $emr_manual_results = $emr_manual_results->whereRaw('result_date_time::date between \'' . $periods['period_start'] . '\' and \'' . $periods['period_end'] . '\'');
            }
            
            if ($emr_moniter_results->count() > 0 && $emr_manual_results->count() > 0) {
                $results = $emr_manual_results->union($emr_moniter_results);
                $results = $results->orderby('parameter_priority', 'asc')
                ->get()->toArray();
            } else if ($emr_moniter_results->count() > 0) {
                $results = $emr_moniter_results->orderby('parameter_priority', 'asc')
                ->get()->toArray();
            } else if ($emr_manual_results->count() > 0) {
                $results = $emr_manual_results->orderby('parameter_priority', 'asc')
                ->get()->toArray();
            } else {
                $results = [];
            }

        }
        return $results;

    }
    /**
     * This method to get fhir valuse
     * based on mrn and snomed code
     *
     * @param $log_header type array
     * @param $snomed_code type array
     */
    public static function getVitalListChart($log_header, $type = '', $start_date = '', $end_date = '', $interfacing_status)
    {

        if ($type == 'discharged')
        {

            $emr_moniter_results = \DB::table('emr_moniter_values_discharged')->select('emr_moniter_values_discharged.mean', 'emr_moniter_values_discharged.first_quartile', 'emr_moniter_values_discharged.last_quartile', 'emr_moniter_values_discharged.close', 'emr_moniter_values_discharged.low', 'emr_moniter_values_discharged.result_date_time as date', 'snomed_nurse_reference.snomed_code', 'snomed_nurse_reference.local_code', 'chart_type', 'local_description', 'parameter_priority')
                ->join('snomed_nurse_reference', 'snomed_nurse_reference.ref_loc_master_id', '=', 'emr_moniter_values_discharged.loinc_local_map_id')
                ->join('local_code_group', 'local_code_group.id', '=', 'snomed_nurse_reference.ref_loc_master_id')
                ->whereNotNull('mean')
                ->where('mean', '<>', '')
                ->where('chart_status', true);
            if ($interfacing_status)
            {
                $emr_moniter_results->where('interfacing_chart', true);
            }
            else
            {
                $emr_moniter_results->where('manual_chart', true);
            }
            $emr_moniter_results->whereIn('log_hdr_id', $log_header);

            if ($start_date != '' && $end_date != '')
            {
                $emr_moniter_results->where("emr_moniter_values_discharged.result_date_time", ">=", $start_date)->where("emr_moniter_values_discharged.result_date_time", "<=", $end_date);
            }

            $emr_manual_results = \DB::table('emr_nurse_manual_values_discharged')->select('emr_nurse_manual_values_discharged.mean', 'emr_nurse_manual_values_discharged.first_quartile', 'emr_nurse_manual_values_discharged.last_quartile', 'emr_nurse_manual_values_discharged.close', 'emr_nurse_manual_values_discharged.low', 'emr_nurse_manual_values_discharged.result_date_time as date', 'snomed_nurse_reference.snomed_code', 'snomed_nurse_reference.local_code', 'chart_type', 'local_description', 'parameter_priority')
                ->join('snomed_nurse_reference', 'snomed_nurse_reference.ref_loc_master_id', '=', 'emr_nurse_manual_values_discharged.loinc_local_map_id')
                ->join('local_code_group', 'local_code_group.id', '=', 'snomed_nurse_reference.ref_loc_master_id')
                ->whereNotNull('mean')
                ->where('mean', '<>', '')
                ->where('chart_status', true);
            if ($interfacing_status)
            {
                $emr_manual_results->where('interfacing_chart', true);
            }
            else
            {
                $emr_manual_results->where('manual_chart', true);
            }
            $emr_manual_results->whereIn('log_hdr_id', $log_header);

            if ($start_date != '' && $end_date != '')
            {
                $emr_manual_results->where("emr_nurse_manual_values_discharged.result_date_time", ">=", $start_date)->where("emr_nurse_manual_values_discharged.result_date_time", "<=", $end_date);
            }
            
            if ($emr_moniter_results->count() > 0 && $emr_manual_results->count() > 0) {
                $results = $emr_manual_results->union($emr_moniter_results);
                $results = $results->orderby('parameter_priority', 'asc')
                ->get()->toArray();
            } else if ($emr_moniter_results->count() > 0) {
                $results = $emr_moniter_results->orderby('parameter_priority', 'asc')
                ->get()->toArray();
            } else if ($emr_manual_results->count() > 0) {
                $results = $emr_manual_results->orderby('parameter_priority', 'asc')
                ->get()->toArray();
            } else {
                $results = [];
            }
            
        }
        else
        {
            $emr_moniter_results = \DB::table('emr_moniter_values')->select('emr_moniter_values.mean', 'emr_moniter_values.first_quartile', 'emr_moniter_values.last_quartile', 'emr_moniter_values.close', 'emr_moniter_values.low', 'emr_moniter_values.result_date_time as date', 'snomed_nurse_reference.snomed_code', 'snomed_nurse_reference.local_code', 'chart_type', 'local_description', 'parameter_priority')
                ->join('snomed_nurse_reference', 'snomed_nurse_reference.ref_loc_master_id', '=', 'emr_moniter_values.loinc_local_map_id')
                ->join('local_code_group', 'local_code_group.id', '=', 'snomed_nurse_reference.ref_loc_master_id')
                ->whereNotNull('mean')
                ->where('mean', '<>', '')
                ->where('chart_status', true);
            if ($interfacing_status)
            {
                $emr_moniter_results->where('interfacing_chart', true);
            }
            else
            {
                $emr_moniter_results->where('manual_chart', true);
            }
            $emr_moniter_results->whereIn('log_hdr_id', $log_header);

            if ($start_date != '' && $end_date != '')
            {
                $emr_moniter_results->where("emr_moniter_values.result_date_time", ">=", $start_date)->where("emr_moniter_values.result_date_time", "<=", $end_date);
            }

            $emr_manual_results = \DB::table('emr_nurse_manual_values')->select('emr_nurse_manual_values.mean', 'emr_nurse_manual_values.first_quartile', 'emr_nurse_manual_values.last_quartile', 'emr_nurse_manual_values.close', 'emr_nurse_manual_values.low', 'emr_nurse_manual_values.result_date_time as date', 'snomed_nurse_reference.snomed_code', 'snomed_nurse_reference.local_code', 'chart_type', 'local_description', 'parameter_priority')
                ->join('snomed_nurse_reference', 'snomed_nurse_reference.ref_loc_master_id', '=', 'emr_nurse_manual_values.loinc_local_map_id')
                ->join('local_code_group', 'local_code_group.id', '=', 'snomed_nurse_reference.ref_loc_master_id')
                ->whereNotNull('mean')
                ->where('mean', '<>', '')
                ->where('chart_status', true);
            if ($interfacing_status)
            {
                $emr_manual_results->where('interfacing_chart', true);
            }
            else
            {
                $emr_manual_results->where('manual_chart', true);
            }
            $emr_manual_results->whereIn('log_hdr_id', $log_header);

            if ($start_date != '' && $end_date != '')
            {
                $emr_manual_results->where("emr_nurse_manual_values.result_date_time", ">=", $start_date)->where("emr_nurse_manual_values.result_date_time", "<=", $end_date);
            }
            
            if ($emr_moniter_results->count() > 0 && $emr_manual_results->count() > 0) {
                $results = $emr_manual_results->union($emr_moniter_results);
                $results = $results->orderby('parameter_priority', 'asc')
                ->get()->toArray();
            } else if ($emr_moniter_results->count() > 0) {
                $results = $emr_moniter_results->orderby('parameter_priority', 'asc')
                ->get()->toArray();
            } else if ($emr_manual_results->count() > 0) {
                $results = $emr_manual_results->orderby('parameter_priority', 'asc')
                ->get()->toArray();
            } else {
                $results = [];
            }

        }
        return $results;

    }
    /**
     * This method to get fhir valuse
     * based on mrn and snomed code
     *
     * @param $baby_mrn type number
     * @param $snomed_code type array
     */
    public static function getVentilatorListChart($log_header, $type = '', $start_date = '', $end_date = '', $interfacing_status)
    {
        if ($type == 'discharged')
        {
            $emr_ventilator_results = \DB::table('emr_ventilator_values_discharged')->select('emr_ventilator_values_discharged.*', 'emr_ventilator_values_discharged.result_date_time as date', 'snomed_nurse_reference.snomed_code', 'snomed_nurse_reference.local_code', 'chart_type', 'local_description', 'parameter_priority')
                ->join('snomed_nurse_reference', 'snomed_nurse_reference.ref_loc_master_id', '=', 'emr_ventilator_values_discharged.loinc_local_map_id')
                ->join('local_code_group', 'local_code_group.id', '=', 'snomed_nurse_reference.ref_loc_master_id')
                ->whereNotNull('mean')
                ->where('mean', '<>', '')
                ->where('chart_status', true);
            if ($interfacing_status)
            {
                $emr_ventilator_results->where('interfacing_chart', true);
            }
            else
            {
                $emr_ventilator_results->where('manual_chart', true);
            }
            $emr_ventilator_results->whereIn('log_hdr_id', $log_header);

            if ($start_date != '' && $end_date != '')
            {
                $emr_ventilator_results->where("emr_ventilator_values_discharged.result_date_time", ">=", $start_date)->where("emr_ventilator_values_discharged.result_date_time", "<=", $end_date);
            }

            $emr_manual_results = \DB::table('emr_nurse_manual_values_discharged')->select('emr_nurse_manual_values_discharged.*', 'emr_nurse_manual_values_discharged.result_date_time as date', 'snomed_nurse_reference.snomed_code', 'snomed_nurse_reference.local_code', 'chart_type', 'local_description', 'parameter_priority')
                ->join('snomed_nurse_reference', 'snomed_nurse_reference.ref_loc_master_id', '=', 'emr_nurse_manual_values_discharged.loinc_local_map_id')
                ->join('local_code_group', 'local_code_group.id', '=', 'snomed_nurse_reference.ref_loc_master_id')
                ->whereNotNull('mean')
                ->where('mean', '<>', '')
                ->where('chart_status', true);
            if ($interfacing_status)
            {
                $emr_manual_results->where('interfacing_chart', true);
            }
            else
            {
                $emr_manual_results->where('manual_chart', true);
            }
            $emr_manual_results->whereIn('log_hdr_id', $log_header);

            if ($start_date != '' && $end_date != '')
            {
                $emr_manual_results->where("emr_nurse_manual_values_discharged.result_date_time", ">=", $start_date)->where("emr_nurse_manual_values_discharged.result_date_time", "<=", $end_date);
            }

            if ($emr_ventilator_results->count() > 0 && $emr_manual_results->count() > 0) {
                $results = $emr_manual_results->union($emr_ventilator_results);
                $results = $results->orderby('parameter_priority', 'asc')
                ->get()->toArray();
            } else if ($emr_ventilator_results->count() > 0) {
                $results = $emr_ventilator_results->orderby('parameter_priority', 'asc')
                ->get()->toArray();
            } else if ($emr_manual_results->count() > 0) {
                $results = $emr_manual_results->orderby('parameter_priority', 'asc')
                ->get()->toArray();
            } else {
                $results = [];
            }

        }
        else
        {

            $emr_ventilator_results = \DB::table('emr_ventilator_values')->select('emr_ventilator_values.*', 'emr_ventilator_values.result_date_time as date', 'snomed_nurse_reference.snomed_code', 'snomed_nurse_reference.local_code', 'chart_type', 'local_description', 'parameter_priority')
                ->join('snomed_nurse_reference', 'snomed_nurse_reference.ref_loc_master_id', '=', 'emr_ventilator_values.loinc_local_map_id')
                ->join('local_code_group', 'local_code_group.id', '=', 'snomed_nurse_reference.ref_loc_master_id')
                ->whereNotNull('mean')
                ->where('mean', '<>', '')
                ->where('chart_status', true);
            if ($interfacing_status)
            {
                $emr_ventilator_results->where('interfacing_chart', true);
            }
            else
            {
                $emr_ventilator_results->where('manual_chart', true);
            }
            $emr_ventilator_results->whereIn('log_hdr_id', $log_header);
            if ($start_date != '' && $end_date != '')
            {
                $emr_ventilator_results->where("emr_ventilator_values.result_date_time", ">=", $start_date)->where("emr_ventilator_values.result_date_time", "<=", $end_date);
            }

            $emr_manual_results = \DB::table('emr_nurse_manual_values')->select('emr_nurse_manual_values.*', 'emr_nurse_manual_values.result_date_time as date', 'snomed_nurse_reference.snomed_code', 'snomed_nurse_reference.local_code', 'chart_type', 'local_description', 'parameter_priority')
                ->join('snomed_nurse_reference', 'snomed_nurse_reference.ref_loc_master_id', '=', 'emr_nurse_manual_values.loinc_local_map_id')
                ->join('local_code_group', 'local_code_group.id', '=', 'snomed_nurse_reference.ref_loc_master_id')
                ->whereNotNull('mean')
                ->where('mean', '<>', '')
                ->where('chart_status', true);
            if ($interfacing_status)
            {
                $emr_manual_results->where('interfacing_chart', true);
            }
            else
            {
                $emr_manual_results->where('manual_chart', true);
            }
            $emr_manual_results->whereIn('log_hdr_id', $log_header);

            if ($start_date != '' && $end_date != '')
            {
                $emr_manual_results->where("emr_nurse_manual_values.result_date_time", ">=", $start_date)->where("emr_nurse_manual_values.result_date_time", "<=", $end_date);
            }

            if ($emr_ventilator_results->count() > 0 && $emr_manual_results->count() > 0) {
                $results = $emr_manual_results->union($emr_ventilator_results);
                $results = $results->orderby('parameter_priority', 'asc')
                ->get()->toArray();
            } else if ($emr_ventilator_results->count() > 0) {
                $results = $emr_ventilator_results->orderby('parameter_priority', 'asc')
                ->get()->toArray();
            } else if ($emr_manual_results->count() > 0) {
                $results = $emr_manual_results->orderby('parameter_priority', 'asc')
                ->get()->toArray();
            } else {
                $results = [];
            }

        }
        return $results;

    }

    /**
     * This method to get fhir valuse
     * based on mrn
     *
     */
    public static function getListChartdata($baby_mrn, $snomed_ct, $visit)
    {
        $result = \DB::table('fihr_formated_values')->select('d', 'mean as ' . $visit)->where('mrn', $baby_mrn)->limit('2')
            ->get();

        return $result;

    }
    /**
     * This method used to get lab values based on dates
     *
     * @param $dates type array 
     * @param $admission_id type int 
     */
    public static function getLabValuePrint($baby_id, $mother_id, $order, $table_name, $departments)
    {
        $result = \DB::table($table_name)
                    ->select($table_name.'.intf_ref_value', 'local_code_group.local_code', 'local_code_group.approval_parameter_priority', 'loinc_local_map_id', \DB::raw($table_name.'.result_date_time::date AS result_date'), 'result_date_time', 'lab_number', 'material_name', 'is_display', 'result_status', 'result_date_time')
                    ->selectRaw('CASE WHEN char_length(result_date_time::text) > 0 THEN to_char(result_date_time, \'DD-MM-YYYY HH24:MI\') END AS temp_result_date_time')
                    ->join('emr_log_hdr', 'emr_log_hdr.id', '=', $table_name.'.log_hdr_id')
                    ->join('local_code_group', 'local_code_group.id', '=', $table_name.'.loinc_local_map_id')
                    // ->whereIn(\DB::raw('emr_log_hdr.visit_date::date'), $dates)
//                    ->where('emr_log_hdr.mother_id', $mother_id)
                    ->where('emr_log_hdr.baby_id', $baby_id)
                    // ->where('emr_log_hdr.admission_id', $admission_id)
                    ->where($table_name.'.create_user_id', 4)
                    ->where($table_name.'.is_display', '!=',false)
                    ->whereIn('lab_department', $departments)
        ->whereNotNull('approval_parameter_priority')
                    ->orderBy($table_name.'.result_date_time', $order)
                    ->get();

        return $result;

    }

    public static function getLabParameters($departments)
    {
        $result = \DB::table('local_code_group')
                    ->select('local_description', 'approval_parameter_priority', 'lab_department')
                    ->whereNotNull('approval_parameter_priority')
                    ->whereIn('lab_department', $departments)
                    ->orderBy('approval_parameter_priority', 'asc')
                    ->get();

        return $result;

    }

    /**
     * This method used to get baby admission dates
     *
     * @param $admission_id type int 
     */
    public static function getCurrentAdmissionDates($admission_id)
    {
        $result = \DB::table('emr_log_hdr')
                    ->selectRaw('DISTINCT(sender_time)::date')
                    ->where('admission_id', $admission_id)
                    ->pluck('sender_time')
                    ->toArray();

        return $result;

    }

    public static function getWorkingWeight($admission_id, $start_date, $end_date, $table_name) {
        $result = \DB::table($table_name)
                  ->select('intf_ref_value', \DB::raw("CONCAT(result_date_time::date,'_',lpad(extract(hour from result_date_time)::text, 2, '0')) as result_date"))
                  ->join('local_code_group', 'local_code_group.id', '=', $table_name.'.loinc_local_map_id')
                  ->join('emr_log_hdr', 'emr_log_hdr.id', '=', $table_name.'.log_hdr_id')
                  ->where('admission_id', $admission_id)
                  ->where('local_code', 'current_weight')
                  ->whereBetween('result_date_time', [$start_date, $end_date])
                  ->orderBy('result_date_time', 'desc')
                  ->pluck('intf_ref_value', 'result_date')
                  ->toArray();
        return $result;

    }

    public static function getPrescriptionIntake($admission_id, $start_date, $end_date, $prescription_dtl, $prescription_table) {
        $result = \DB::table($prescription_table)
                  ->select('infused', 'result_time', $prescription_dtl.'.prescription_id')
                  ->join($prescription_dtl, $prescription_dtl.'.prescription_id', '=', $prescription_table.'.prescription_id')
                  ->join('prescription_hdr', 'prescription_hdr.id', '=', $prescription_dtl.'.pres_hdr_id')
                  ->where('prescription_hdr.admission_id', $admission_id)
                  ->whereBetween('result_time', [$start_date, $end_date])
                  ->orderBy('result_time', 'desc')
                  ->get();
        return $result;

    }

    public static function getMilkVolumeIntake($admission_id, $start_date, $end_date) {
        $result = \DB::table('emr_nurse_manual_values')
                  ->select('intf_ref_value', \DB::raw("CONCAT(result_date_time::date,'_',lpad(extract(hour from result_date_time)::text, 2, '0')) as result_date"))
                  ->join('local_code_group', 'local_code_group.id', '=', 'emr_nurse_manual_values.loinc_local_map_id')
                  ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_nurse_manual_values.log_hdr_id')
                  ->where('admission_id', $admission_id)
                  ->where('local_code', 'milk_volume')
                  ->whereBetween('result_date_time', [$start_date, $end_date])
                  ->orderBy('result_date_time', 'desc')
                  ->pluck('intf_ref_value', 'result_date')
                  ->toArray();

        return $result;

    }

    public static function getTotalOutput($admission_id, $start_date, $end_date, $output_params) {
        $result = \DB::table('emr_nurse_manual_values')
                    ->select(\DB::raw("CASE WHEN COALESCE(substring(intf_ref_value FROM '(([0-9]+.*)*[0-9]+)'), intf_ref_value) != '' THEN COALESCE(substring(intf_ref_value FROM '(([0-9]+.*)*[0-9]+)'), intf_ref_value) ELSE intf_ref_value END AS intf_ref_value"), 'result_date_time')
                    // ->select('intf_ref_value', 'result_date_time')
                  ->join('local_code_group', 'local_code_group.id', '=', 'emr_nurse_manual_values.loinc_local_map_id')
                  ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_nurse_manual_values.log_hdr_id')
                  ->where('admission_id', $admission_id)
                  ->whereIn('local_code', $output_params)
                  ->where('intf_ref_value', '!=', '')
                  ->where('intf_ref_value', '!=', '.')
                  ->where('intf_ref_value', '!=', 'Nil')
                  ->whereBetween('result_date_time', [$start_date, $end_date])
                  ->orderBy('result_date_time', 'desc')
                  ->get();
        return $result;

    }

    public static function getBowelsStatus($admission_id, $start_date, $end_date, $field_name) {
        $result = \DB::table('emr_nurse_manual_values')
                  ->select('intf_ref_value', \DB::raw("CONCAT(result_date_time::date,'_',lpad(extract(hour from result_date_time)::text, 2, '0')) as result_date_time"))
                  ->join('local_code_group', 'local_code_group.id', '=', 'emr_nurse_manual_values.loinc_local_map_id')
                  ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_nurse_manual_values.log_hdr_id')
                  ->where('admission_id', $admission_id)
                  ->where('local_code', $field_name)
                  ->whereBetween('result_date_time', [$start_date, $end_date])
                  ->orderBy('result_date_time', 'desc')
                  ->pluck('intf_ref_value', 'result_date_time')
                  ->toArray();
        return $result;

    }
    
    public static function getInterfacingData($baby_id, $admission_id, $nurse_sheet_id, $start_time = '', $end_time = '', $table_name = 'emr_lab_values', $slug = true) {

        $lab_results = \DB::table($table_name)
        ->select($table_name.'.intf_ref_value', 'local_code_group.local_code', $table_name.'.create_user_id', 'result_date_time', 'local_description', 'approval_parameter_priority')
        ->selectRaw('CASE WHEN char_length(result_date_time::text) > 0 THEN to_char(result_date_time, \'DD-MM-YYYY HH24:MI\') END AS temp_result_date_time')
        ->join('emr_log_hdr', 'emr_log_hdr.id', '=', $table_name.'.log_hdr_id')
        ->join('local_code_group', 'local_code_group.id', '=', $table_name.'.loinc_local_map_id')
        ->where('baby_id', $baby_id)
        ->where('admission_id', $admission_id)
        ->where('is_display', true);
        if ($nurse_sheet_id != '') {
            $lab_results = $lab_results->whereIn('local_code_group.local_code', $nurse_sheet_id);
        }
        $lab_results = $lab_results->where('intf_ref_value', '<>', '');                            
        if ($start_time != '' && $end_time != '') {
            $lab_results = $lab_results->whereBetween('result_date_time', [$start_time, $end_time]);
        }
        $lab_results = $lab_results
        // ->where('emr_lab_values.create_user_id', 'ilike', '%interface machine%')
        ->orderBy('result_date_time', 'desc')
        ->get();
        if ($slug) {
            $lab_results = $lab_results->unique('local_code');
        }

        return $lab_results;

    }

}

