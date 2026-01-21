<?php
namespace App\Models\NurseManual;

use Illuminate\Database\Eloquent\Model;
use App\Models\DischargeLog;

class ManualLogHeader extends Model
{
    protected $table = 'manual_log_hdr';
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
        return $this->hasMany('App\Models\Nurse\EmrMoniterValues', 'log_hdr_id', 'id')
            ->orderBy('result_date_time', 'asc');
    }

    /**
     * This method get join the emrlogheader and emrlogdetails
     *
     * @return array of object data
     */
    public function GetEmrVentilatorValues()
    {
        return $this->hasMany('App\Models\Nurse\EmrVentilatorValues', 'log_hdr_id', 'id')
            ->orderBy('result_date_time', 'asc');
    }

    /**
     * This method get join the emrlogheader and emrlogdetails_discharged
     *
     * @return array of object data
     */
    public function GetManualLogDetails()
    {
        return $this->hasMany('App\Models\NurseManual\ManualLogDetails', 'log_hdr_id', 'id')
            ->orderBy('time', 'asc');
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

        return \DB::table('loinc_reference_nurse')
            ->get();

    }

    /**
     * This method to get loinc code based on local code
     * @param $local_code type string
     *
     * @return array of object data
     */
    public static function get_remove_drugs($day_id, $local_id, $list_ids)
    {

        $ids = \DB::table('manual_log_hdr')->select('manual_log_dtl.id')
            ->join('manual_log_dtl', 'manual_log_dtl.log_hdr_id', '=', 'manual_log_hdr.id')
            ->where('manual_log_hdr.day_id', $day_id)->where('manual_log_dtl.loinc_local_map_id', $local_id)->whereNotIn('manual_log_dtl.id', $list_ids)->get()
            ->pluck('id')
            ->toArray();
        \DB::table('manual_log_dtl')
            ->whereIn('id', $ids)->delete();

    }

    /**
     * This method get the sender time
     *
     * @return array of object data
     */
    public static function getSenderTimeList($sheet_id)
    {
        return \DB::table('manual_log_hdr')->select('sender_time', 'day_id')
            ->where('day_id', $sheet_id)->get();
    }

    /**
     * This method get the emr log header id
     *
     * @return array of object data
     */
    public static function getIdList($day_id)
    {
        return \DB::table('manual_log_hdr')->select('id', 'day_id')
            ->where('day_id', $day_id)->get();
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
        return \DB::table('manual_log_hdr')->select('id')
            ->where('day_id', $sheet_id)->where('sender_time', $sheetTime)->first();
    }

    /**
     * This method get the emr log header
     *
     * @return array of object data
     */
    public static function getEmrLogHdr($baby_id, $admission_id, $start_time, $end_time)
    {

        return \DB::table('manual_log_hdr')
                    ->select('*')
                    ->where('baby_id', $baby_id)
                    ->where('admission_id', $admission_id)
                    ->whereBetween('sender_time', [$start_time, $end_time])
                    ->orderBy('sender_time', 'asc')
                    ->get();
    }

    /**
     * This method get the local code details
     *
     * @return array of object data
     */
    public static function getLocalCode($local_map_id)
    {

        return \DB::table('local_code_group')->select('local_code')
            ->where('id', $local_map_id)->first();
    }
    /**
     * This method get the emr values from various tables
     *
     * @return array of object data
     */
    public static function get_manual_values($header_id, $table_name)
    {
        // echo $header_id; exit;
        return \DB::table($table_name)->select($table_name . '.*', 'local_code_group.local_code')->join('local_code_group', 'local_code_group.id', '=', $table_name . '.loinc_local_map_id')->where('log_hdr_id', $header_id)->orderBy('result_date_time', 'desc')->get();

        // echo "<pre>"; print_r($result); exit;
        
    }

    /**
     * This method to get graphical data
     *
     * @param $baby_id type integer
     * @param $periods_start date
     * @param $periods_end   date
     */
    public static function getgraphicaldata($baby_id, $admission_id ,$periods_start, $periods_end, $vendilator_parameters = array() , $type = '')
    {

        $results = \DB::table('nurse_main_sheet')->select('manual_log_hdr.sender_time', 'manual_log_hdr.id')
            ->join('manual_log_hdr', 'manual_log_hdr.day_id', '=', 'nurse_main_sheet.id');
        if ($periods_start != '' && $periods_end != '')
        {
            $results = $results->whereBetween('nurse_main_sheet.sheet_date', [$periods_start, $periods_end]);
        }

        $results = $results->where('nurse_main_sheet.baby_id', '=', $baby_id)->orderBy('manual_log_hdr.sender_time', 'asc')
            ->get();

        $return_array = array();
        if (count($results) > 0)
        {
            if ($type == 'discharged')
            {
                foreach ($results as $key => $result)
                {
                    $values = \DB::table('manual_log_dtl')->select('intf_ref_value as mean', 'local_code_group.local_code', 'sender_time')
                        ->join('manual_log_hdr', 'manual_log_hdr.id', '=', 'manual_log_dtl.log_hdr_id')
                        ->join('local_code_group', 'local_code_group.id', '=', 'manual_log_dtl.loinc_local_map_id')
                        ->whereIn('local_code_group.local_code', $vendilator_parameters)
                        ->where('manual_log_dtl.log_hdr_id', $result->id)
                        ->where('intf_ref_value', '<>', 'N/A')
                        ->where('intf_ref_value', '<>', '')
                        ->where('manual_log_hdr.admission_id', $admission_id)
                        ->get()
                        ->toArray();
                    // $ventilator_values = \DB::table('manual_ventilator_values_discharged')->select('intf_ref_value', 'local_code_group.local_code')
                    //     ->join('local_code_group', 'local_code_group.id', '=', 'manual_ventilator_values_discharged.loinc_local_map_id')
                    //     ->whereIn('local_code_group.local_code', $vendilator_parameters)->where('manual_ventilator_values_discharged.log_hdr_id', $result->id)
                    //     ->get()
                    //     ->toArray();
                    // $merged_values = array_merge($moniter_values, $ventilator_values);
                    // foreach ($return_array as $merged_key => $value)
                    // {
                    //     $return_array->sender_time = $result->sender_time;
                    // }
                    $return_array = array_merge($return_array, $values);
                }
            }
            else
            {
                foreach ($results as $key => $result)
                {
                    $values = \DB::table('manual_log_dtl')->select('intf_ref_value as mean', 'local_code_group.local_code', \DB::raw("DATE(sender_time) as tempDate"), 'time as date', 'sender_time')
                        ->join('manual_log_hdr', 'manual_log_hdr.id', '=', 'manual_log_dtl.log_hdr_id')
                        ->join('local_code_group', 'local_code_group.id', '=', 'manual_log_dtl.loinc_local_map_id')
                        ->whereIn('local_code_group.local_code', $vendilator_parameters)
                        ->where('manual_log_dtl.log_hdr_id', $result->id)
                        ->where('intf_ref_value', '<>', 'N/A')
                        ->where('intf_ref_value', '<>', '')
                        ->where('manual_log_hdr.admission_id', $admission_id)
                        ->get()
                        ->toArray();
                    // $ventilator_values = \DB::table('manual_ventilator_values')->select('intf_ref_value', 'local_code_group.local_code')
                    //     ->join('local_code_group', 'local_code_group.id', '=', 'manual_ventilator_values.loinc_local_map_id')
                    //     ->whereIn('local_code_group.local_code', $vendilator_parameters)->where('manual_ventilator_values.log_hdr_id', $result->id)
                    //     ->get()
                    //     ->toArray();
                    // $merged_values = array_merge($moniter_values, $ventilator_values);
                    // foreach ($return_array as $merged_key => $value)
                    // {
                    //     $return_array->sender_time = $result->sender_time;
                    // }
                    $return_array = array_merge($return_array, $values);
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
    public static function getmachinedata($baby_id, $local_code, $ip_number = '', $periods = array() , $type = '')
    {

        if ($type == 'discharged')
        {

            $ventilator = \DB::table('local_code_group')->select('low', 'first_quartile as open', 'mean as mid', 'last_quartile as close', 'close as high', 'local_code', 'result_date_time as issued')
                ->selectRaw("date(result_date_time) as date")
                ->join('loinc_local_code_map_part', 'loinc_local_code_map_part.ref_loc_master_id', '=', 'local_code_group.id')
                ->join('manual_ventilator_values_discharged', 'manual_ventilator_values_discharged.loinc_local_map_id', '=', 'loinc_local_code_map_part.ref_loc_master_id')
                ->join('manual_log_hdr', 'manual_log_hdr.id', '=', 'manual_ventilator_values_discharged.log_hdr_id')
                ->whereIn('local_code_group.local_code', $local_code)->where('manual_log_hdr.baby_id', $baby_id);

            if (isset($periods['period_start']) && isset($periods['period_start']) && $periods['period_start'] != '' && $periods['period_end'] != '')
            {
                $ventilator = $ventilator->whereRaw('result_date_time::date between \'' . $periods['period_start'] . '\' and \'' . $periods['period_end'] . '\'');

            }
            $results= $ventilator->orderBy('result_date_time', 'asc')
                ->get();
        }
        else
        {
            $ventilator = \DB::table('local_code_group')->select('low', 'first_quartile as open', 'mean as mid', 'last_quartile as close', 'close as high', 'local_code', 'result_date_time as issued')
                ->selectRaw("date(result_date_time) as date")
                ->join('loinc_local_code_map_part', 'loinc_local_code_map_part.ref_loc_master_id', '=', 'local_code_group.id')
                ->join('manual_ventilator_values', 'manual_ventilator_values.loinc_local_map_id', '=', 'loinc_local_code_map_part.ref_loc_master_id')
                ->join('manual_log_hdr', 'manual_log_hdr.id', '=', 'manual_ventilator_values.log_hdr_id')
                ->whereIn('local_code_group.local_code', $local_code)->where('manual_log_hdr.baby_id', $baby_id);

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
    public static function getmachinevitaldata($baby_id, $local_code, $ip_number = '', $periods = array() , $type = '')
    {

        $prefix = str_replace('_', '', $local_code);
        if ($type == 'discharged') {
          $moniter = \DB::table('local_code_group')->select('low', 'first_quartile as open', 'mean as mid', 'last_quartile as close', 'close as high', 'local_code', 'result_date_time as issued', 'result_date_time as date')
          // ->selectRaw("date(result_date_time) as date")
          
              ->join('loinc_local_code_map_part', 'loinc_local_code_map_part.ref_loc_master_id', '=', 'local_code_group.id')
              ->join('manual_moniter_values_discharged', 'manual_moniter_values_discharged.loinc_local_map_id', '=', 'loinc_local_code_map_part.ref_loc_master_id')
              ->join('manual_log_hdr', 'manual_log_hdr.id', '=', 'manual_moniter_values_discharged.log_hdr_id')
              ->where('local_code_group.local_code', $local_code)->where('manual_log_hdr.baby_id', $baby_id);

          if (isset($periods['period_start']) && isset($periods['period_start']) && $periods['period_start'] != '' && $periods['period_end'] != '')
          {
              $moniter = $moniter->whereRaw('result_date_time::date between \'' . $periods['period_start'] . '\' and \'' . $periods['period_end'] . '\'');

          }
          $results = $moniter->orderBy('result_date_time', 'asc')->get();
        }
        else
        {
            echo '<pre>';print_r('hi!');exit;
          $moniter = \DB::table('local_code_group')->select('low', 'first_quartile as open', 'mean as mid', 'last_quartile as close', 'close as high', 'local_code', 'result_date_time as issued', 'result_date_time as date')
          // ->selectRaw("date(result_date_time) as date")
          
              ->join('loinc_local_code_map_part', 'loinc_local_code_map_part.ref_loc_master_id', '=', 'local_code_group.id')
              ->join('manual_moniter_values', 'manual_moniter_values.loinc_local_map_id', '=', 'loinc_local_code_map_part.ref_loc_master_id')
              ->join('manual_log_hdr', 'manual_log_hdr.id', '=', 'manual_moniter_values.log_hdr_id')
              ->where('local_code_group.local_code', $local_code)->where('manual_log_hdr.baby_id', $baby_id);

          if (isset($periods['period_start']) && isset($periods['period_start']) && $periods['period_start'] != '' && $periods['period_end'] != '')
          {
              $moniter = $moniter->whereRaw('result_date_time::date between \'' . $periods['period_start'] . '\' and \'' . $periods['period_end'] . '\'');

          }
          $results = $moniter->orderBy('result_date_time', 'asc')->get();
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
    public static function getVitalListChart($log_header, $snomed_code, $type = '')
    {
        if ($type == 'discharged')
        {

            $result = \DB::table('manual_moniter_values_discharged')->select('manual_moniter_values_discharged.*', 'manual_moniter_values_discharged.result_date_time as date', 'snomed_nurse_reference.snomed_code')
                ->join('snomed_nurse_reference', 'snomed_nurse_reference.ref_loc_master_id', '=', 'manual_moniter_values_discharged.loinc_local_map_id')
                ->where('snomed_nurse_reference.snomed_code', $snomed_code)->whereIn('log_hdr_id', $log_header)->orderby('manual_moniter_values_discharged.result_date_time', 'asc')
                ->get();
        }
        else
        {

            $result = \DB::table('manual_moniter_values')->select('manual_moniter_values.*', 'manual_moniter_values.result_date_time as date', 'snomed_nurse_reference.snomed_code')
                ->join('snomed_nurse_reference', 'snomed_nurse_reference.ref_loc_master_id', '=', 'manual_moniter_values.loinc_local_map_id')
                ->where('snomed_nurse_reference.snomed_code', $snomed_code)->whereIn('log_hdr_id', $log_header)->orderby('manual_moniter_values.result_date_time', 'asc')
                ->get();
        }
        return $result;

    }
    /**
     * This method to get fhir valuse
     * based on mrn and snomed code
     *
     * @param $baby_mrn type number
     * @param $snomed_code type array
     */
    public static function getVentilatorListChart($log_header, $snomed_code, $type ='')
    {
        if ($type == 'discharged')
        {
            $result = \DB::table('manual_ventilator_values_discharged')->select('manual_ventilator_values_discharged.*', 'manual_ventilator_values_discharged.result_date_time as date', 'snomed_nurse_reference.snomed_code')
                ->join('snomed_nurse_reference', 'snomed_nurse_reference.ref_loc_master_id', '=', 'manual_ventilator_values_discharged.loinc_local_map_id')
                ->where('snomed_nurse_reference.snomed_code', $snomed_code)->whereIn('log_hdr_id', $log_header)->orderby('manual_ventilator_values_discharged.result_date_time', 'asc')
                ->get();
        }
        else
        {
            $result = \DB::table('manual_ventilator_values')->select('manual_ventilator_values.*', 'manual_ventilator_values.result_date_time as date', 'snomed_nurse_reference.snomed_code')
                ->join('snomed_nurse_reference', 'snomed_nurse_reference.ref_loc_master_id', '=', 'manual_ventilator_values.loinc_local_map_id')
                ->where('snomed_nurse_reference.snomed_code', $snomed_code)->whereIn('log_hdr_id', $log_header)->orderby('manual_ventilator_values.result_date_time', 'asc')
                ->get();
        }

        return $result;

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

    // public static function get_emr_values($header_id)
    // {
    //     return \DB::table('manual_log_dtl')->select('manual_log_dtl.*', 'local_code_group.local_code')->join('local_code_group', 'local_code_group.id', '=', 'manual_log_dtl.loinc_local_map_id')->where('log_hdr_id', $header_id)->orderBy('create_tstamp', 'desc')->get();   
    // }

    public static function get_emr_values($sheet_date, $baby_id, $admission_id)
    {
        return \DB::table('manual_log_dtl')
                ->select('manual_log_dtl.*', 'local_code_group.local_code', \DB::raw("lpad(EXTRACT(day FROM sender_time)::text, 2, '0') || ':' || lpad(EXTRACT(hour FROM sender_time)::text, 2, '0') || ':00' as result_hour"), 'manual_log_hdr.added_nurse as time_sheet', 'manual_log_hdr.id as header_id', 'manual_log_hdr.sender_time')
                ->join('local_code_group', 'local_code_group.id', '=', 'manual_log_dtl.loinc_local_map_id')
                ->join('manual_log_hdr', 'manual_log_hdr.id', '=', 'manual_log_dtl.log_hdr_id')
                ->where('manual_log_hdr.baby_id', $baby_id)
                ->where('manual_log_hdr.admission_id', $admission_id)
                ->whereRaw("manual_log_hdr.visit_date::date = '".$sheet_date."'")
                ->orderBy('id', 'asc')
                ->get();   
    }

    public static function getNonLonicValues($sheet_date, $baby_id, $admission_id)
    {
        return \DB::table('nurse_hour_wise_sheet')
                ->select('nurse_hour_wise_sheet.*', \DB::raw("lpad(EXTRACT(day FROM sender_time)::text, 2, '0') || ':' || lpad(EXTRACT(hour FROM sender_time)::text, 2, '0') || ':00' as result_hour"), 'manual_log_hdr.added_nurse as time_sheet', 'manual_log_hdr.id as header_id', 'manual_log_hdr.sender_time')
                ->join('manual_log_hdr', 'manual_log_hdr.id', '=', 'nurse_hour_wise_sheet.log_header_id')
                ->where('manual_log_hdr.baby_id', $baby_id)
                ->where('manual_log_hdr.admission_id', $admission_id)
                ->whereRaw("manual_log_hdr.visit_date::date = '".$sheet_date."'")
                ->get();   
    }

    public static function getBasicDetails($basic_local_ids, $baby_id, $admission_id)
    {
        return \DB::table('manual_log_dtl')
                ->select('manual_log_dtl.*', 'local_code_group.local_code')
                ->join('local_code_group', 'local_code_group.id', '=', 'manual_log_dtl.loinc_local_map_id')
                ->join('manual_log_hdr', 'manual_log_hdr.id', '=', 'manual_log_dtl.log_hdr_id')
                ->where('manual_log_hdr.baby_id', $baby_id)
                ->where('manual_log_hdr.admission_id', $admission_id)
                ->whereIn('local_code_group.local_code', $basic_local_ids)
                ->orderBy('create_tstamp', 'desc')
                ->get()->unique('loinc_local_map_id');
    }
}

