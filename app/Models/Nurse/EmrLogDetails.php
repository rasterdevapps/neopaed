<?php

namespace App\Models\Nurse;

use Illuminate\Database\Eloquent\Model;

class EmrLogDetails extends Model
{
   protected $table = 'emr_log_dtl';
	 protected $primaryKey = 'id';
	 public    $timestamps  =  false;
	 protected $fillable = ['log_hdr_id', 'emr_intf_data_id', 'loinc_local_map_id', 'loinc_code','loinc_version','intf_ref_name', 'intf_ref_value', 'component', 'property', 'time', 'system', 'scale', 'method', 'classtype', 'active_flag', 'create_user_id', 'create_tstamp', 'modify_user_id', 'modify_tstamp', 'device_parameter_map_id', 'observation_type_id', 'emr_vendor_ans_list_map_id', 'intf_ref_code', 'is_calulated'];

    /**
     * This method to get local code bindings 
     *
     * @return array of object 
     */
    public function GetLocalCodeBind() 
    {
    	return $this->hasOne('App\Models\Nurse\LoincCodeGroup','id','loinc_local_map_id');
    }

    /**
     * This method to check data exists
     *
     * @param $header_id type integer 
     * @param $log_id  type integer
     * 
     * @return array of object 
     */
    public static function Getlogdetails($header_id, $log_id)
    {
        return \DB::table('emr_log_dtl')
                   ->where('id', $log_id)
                   ->where('log_hdr_id', $header_id)
                   ->get();

    }

    /**
     * This method to get toggle values
     * @param $nurse_id type integer
     * @param $local_code type integer
     **/
    public static function GetToggleValues($nurse_id, $local_code)
    {
        return \DB::table('nurse_main_sheet')
                    ->selectRaw('emr_log_hdr.id as log_hdr, emr_log_dtl.id as log_dtl_id, emr_log_hdr.day_id, local_code_group.local_code')
                    ->join('emr_log_hdr', 'emr_log_hdr.day_id','=','nurse_main_sheet.id')
                    ->join('emr_log_dtl','emr_log_dtl.log_hdr_id', '=','emr_log_hdr.id')
                    ->join('local_code_group', 'local_code_group.id', '=','emr_log_dtl.loinc_local_map_id')
                    ->where('nurse_main_sheet.id',$nurse_id)
                    ->whereIn('local_code_group.local_code', $local_code)
                    ->get();

    }

     /**
     * This method to check data exists
     *
     * @param $header_id type integer 
     * @param $log_id  type integer
     * 
     * @return array of object 
     */
    public static function Getpreviousdata($header_id, $local_code)
    {
        return \DB::table('emr_log_dtl')
                   ->select('emr_log_dtl.*', 'local_code_group.*','emr_log_dtl.id as log_id')
                   ->join('local_code_group', 'local_code_group.id','=','emr_log_dtl.loinc_local_map_id')
                   ->where('emr_log_dtl.log_hdr_id', $header_id)
                   ->whereIn('local_code_group.local_code', $local_code)
                   ->orderBy('emr_log_dtl.id', 'desc')
                   ->get();

    }

    /**
     * This method to check data exists
     *
     * @param $header_id type integer 
     * @param $log_id  type integer
     * 
     * @return array of object 
     */
    public static function Getpreviousbasic($local_code, $admission_id)
    {
        return \DB::table('emr_nurse_manual_values')
                   ->select('emr_nurse_manual_values.*', 'local_code_group.*','emr_nurse_manual_values.id as log_id')
                   ->join('emr_log_hdr', 'emr_log_hdr.id','=','emr_nurse_manual_values.log_hdr_id')
                   ->join('local_code_group', 'local_code_group.id','=','emr_nurse_manual_values.loinc_local_map_id')
                   ->whereIn('local_code_group.local_code', $local_code)
                   ->where('admission_id', $admission_id)
                   ->get();

    }


    /**
     *This method to get e-prescriprion 
     * 
     * @param $date type date 
     * @param $baby_id type integer
     */
    public static function GetprescriptionDetails($baby_id,  $sheet_date, $admission_id)
    {

        return \DB::table('emr_log_hdr')
                   ->select('emr_log_dtl.*', 'local_code_group.*','emr_log_dtl.id as log_id')
                   ->join('emr_log_dtl','emr_log_dtl.log_hdr_id', '=', 'emr_log_hdr.id')
                   ->join('local_code_group', 'local_code_group.id', '=','emr_log_dtl.loinc_local_map_id')
                   ->where('emr_log_hdr.baby_id', $baby_id)
                   ->where('emr_log_hdr.visit_date', date('Y-m-d', strtotime($sheet_date)))
                   ->where('emr_log_hdr.admission_id', $admission_id)
                   ->get();

    }

    /**
     * This method to get output running total
     * 
     * @param $local_code type array 
     * @param $day_id type integer
     * 
     */
    public static function Getoutputrunning($local_code, $day_id)
    {
        return \DB::table('emr_log_dtl')
                   ->select('emr_log_dtl.*','local_code_group.local_code')
                   ->join('local_code_group', 'local_code_group.id','=','emr_log_dtl.loinc_local_map_id')
                   ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_log_dtl.log_hdr_id')
                   ->where('emr_log_hdr.day_id', $day_id)
                   ->whereIn('local_code_group.local_code', $local_code)
                   ->get();

    }

    /**
     * This method to get output running total
     * 
     * @param $local_code type array 
     * @param $day_id type integer
     * 
     */
    public static function getremovedetails($day_id, $log_ids, $local_codes)
    {


          return \DB::table('emr_log_dtl')
                      ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_log_dtl.log_hdr_id')
                      ->join('local_code_group', 'local_code_group.id','=','emr_log_dtl.loinc_local_map_id')
                      ->whereIn('local_code_group.local_code', $local_codes)
                      ->where('emr_log_hdr.day_id', $day_id)
                      ->whereNotIn('emr_log_dtl.id',$log_ids)
                      ->delete();

    } 

    /**
     * This method to get graphical data
     * 
     * @param $baby_id type integer
     * @param $periods_start date
     * @param $periods_end   date
     */
    public static function getgraphicaldata($baby_id, $periods_start, $periods_end, $vendilator_parameters = array()) 
    {

        $results = \DB::table('nurse_main_sheet')
                   ->select('emr_log_hdr.sender_time', 'local_code_group.local_code', 'emr_log_dtl.intf_ref_value')
                   ->join('emr_log_hdr', 'emr_log_hdr.day_id','=','nurse_main_sheet.id')
                   ->join('emr_log_dtl', 'emr_log_dtl.log_hdr_id','=','emr_log_hdr.id')
                   ->join('local_code_group','local_code_group.id','=','emr_log_dtl.loinc_local_map_id')
                   ->whereIn('local_code_group.local_code', $vendilator_parameters);
        
        if ($periods_start != '' && $periods_end != '') {
         $results = $results->whereBetween('nurse_main_sheet.sheet_date',[$periods_start,$periods_end]);
        }   

        $results = $results->where('nurse_main_sheet.baby_id', '=',$baby_id)
                           ->orderBy('emr_log_hdr.sender_time','asc')
                           ->get();

         return $results;           
    } 

    
    /**
     * This method to get data for graph from machine
     * 
     * $baby_id
     */
    public static function getbabydata($baby_id)
    {
       $results = \DB::table('baby')
                      ->select('baby.*')
                      ->join('baby_admission', 'baby_admission.BabyId','=','baby.BabyId')
                      ->where('baby.BabyId', $baby_id)
                      ->where('IsDeleted','0')
                      ->first();

       return $results;
    }

    /**
     * This method to get data for graph from machine
     * 
     * $baby_id
     */
    public static function getmachinedata($baby_number, $local_code, $ip_number = '', $periods = array())
    {

        $results = \DB::table('local_code_group')
                       ->select('low', 'first_quartile as open', 'mean as mid', 'last_quartile as close', 'close as high', 'local_code', 'date', 'issued')
                       ->join('loinc_local_code_map_part', 'loinc_local_code_map_part.ref_loc_master_id', '=', 'local_code_group.id')
                       ->join('fihr_formated_values', 'fihr_formated_values.snomed_code', '=', 'loinc_local_code_map_part.snomed_code')
                       ->whereIn('local_code_group.local_code', $local_code)
                       ->where('mrn', $baby_number);

         if (isset($periods['period_start']) && isset($periods['period_start']) && $periods['period_start'] != '' && $periods['period_end'] != '') {
            $results = $results->whereRaw('issued::date between \''.$periods['period_start'].'\' and \''.$periods['period_end'].'\'');

         }
         $results = $results->orderBy('issued', 'asc')->get();


        return  $results;           

    }

    /**
     * This method to get vital data data for graph from machine
     * 
     * $baby_id
     */
    public static function getmachinevitaldata($baby_number, $local_code, $ip_number = '', $periods = array())
    {
        $prefix = str_replace('_', '', $local_code);

        $results = \DB::table('local_code_group')
                       ->selectRaw('issued::timestamp as date')
                       ->selectRaw('issued as date')
                   //    ->addSelect('low', 'first_quartile as '.$prefix.'open', 'mean as '.$prefix.'mid', 'last_quartile as '.$prefix.'close', 'close as '.$prefix.'high')
                       ->addSelect('low', 'first_quartile as open', 'mean as mid', 'last_quartile as close', 'close as high')
                       ->join('loinc_local_code_map_part', 'loinc_local_code_map_part.ref_loc_master_id', '=', 'local_code_group.id')
                       ->join('fihr_formated_values', 'fihr_formated_values.snomed_code', '=', 'loinc_local_code_map_part.snomed_code')
                       ->where('local_code_group.local_code', $local_code)
                       ->where('mrn', $baby_number);

         if (isset($periods['period_start']) && isset($periods['period_start']) && $periods['period_start'] != '' && $periods['period_end'] != '') {
            $results = $results->whereRaw('issued::date between \''.$periods['period_start'].'\' and \''.$periods['period_end'].'\'');

         }
         $results = $results->orderBy('issued', 'asc')->get();

        return  $results;           

    }

    /**
     * Filter prescription
     * 
     * @param $from_time type date
     * @param $to_time type date
     */
    public static function getDrugByDate($from_time, $to_time) {
       return \DB::table('emr_log_dtl')
                  ->select('emr_log_dtl.*', 'local_code_group.*','emr_log_dtl.id as log_id', 'emr_log_hdr.sender_time')
                  ->join('local_code_group', 'local_code_group.id','=','emr_log_dtl.loinc_local_map_id')
                  ->join('emr_log_hdr', 'emr_log_hdr.id','=','emr_log_dtl.log_hdr_id')
                  // ->where('emr_log_dtl.log_hdr_id', $previous_day->id)
                  ->whereIn('local_code_group.local_code', DialpadSupportProperty::DRUG_FLUIDS)   
                  ->where('emr_log_hdr.sender_time', '>=' ,date('Y-m-d H:i',strtotime($from_time)))
                  ->where('emr_log_hdr.sender_time', '<=' ,date('Y-m-d H:i',strtotime($to_time)))
                  ->get();
    }

    /**
     * This method to get emr log id
     */
    public static function emrLogId($emrLogId,$loinc_code)
    {
       $results = \DB::table('emr_log_dtl')
                      ->select('id')
                      ->where('log_hdr_id',$emrLogId)
                      ->where('loinc_code',$loinc_code)
                      ->first();

       return $results;
    }

    /**
     * This method to get table data
     */
    public static function emrLogIdDetail($start_date, $end_date, $baby_id)
    {
       $results = \DB::table('emr_log_dtl')
                      ->select('emr_log_dtl.*')
                      ->join('emr_log_hdr', 'emr_log_hdr.id','=','emr_log_dtl.log_hdr_id')
                      ->where('emr_log_hdr.baby_id', $baby_id)
                      // ->where('log_hdr_id',$refId)
                      ->whereBetween('emr_log_dtl.create_tstamp',[$start_date, $end_date])
                      // ->where('emr_log_dtl.create_tstamp', '>=', $start_date)
                      // ->where('emr_log_dtl.create_tstamp', '<', $end_date)
                      ->where('emr_log_dtl.intf_ref_value','<>',0)
                      ->get();
       return $results;
    }


    /**
     * This method to check data exists
     *
     * @param $header_id type integer 
     * @param $log_id  type integer
     * 
     * @return array of object 
     */
    public static function GetFhirPrescribeddata($local_code, $baby_id, $admission_id, $today_start, $today_current)
    {
        return \DB::table('emr_log_dtl')
                   ->select('emr_log_dtl.*', 'local_code_group.*','emr_log_dtl.id as log_id')
                   ->join('emr_log_hdr', 'emr_log_hdr.id','=','emr_log_dtl.log_hdr_id')
                   ->join('local_code_group', 'local_code_group.id','=','emr_log_dtl.loinc_local_map_id')
                   ->whereIn('local_code_group.local_code', $local_code)
                   ->where('emr_log_hdr.baby_id', $baby_id)
                   ->where('emr_log_hdr.admission_id', $admission_id)
                   ->where('emr_log_hdr.sender_time', '>=', $today_start)
                   ->where('emr_log_hdr.sender_time', '<=', $today_current)
                   ->orderBy('emr_log_dtl.time', 'desc')
                   ->get()->toArray();

    }

    /**
     * This method to check data exists
     *
     * @param $header_id type integer 
     * @param $log_id  type integer
     * 
     * @return array of object 
     */
    public static function compareFhirPrescribeddata($local_code, $baby_id, $admission_id, $today_start, $today_current, $values)
    {

        return \DB::table('emr_log_dtl')
                   ->select('emr_log_dtl.*', 'local_code_group.*','emr_log_dtl.id as log_id')
                   ->join('emr_log_hdr', 'emr_log_hdr.id','=','emr_log_dtl.log_hdr_id')
                   ->join('local_code_group', 'local_code_group.id','=','emr_log_dtl.loinc_local_map_id')
                   // ->whereIn('local_code_group.local_code', $local_code)
                   // ->whereIn('emr_log_dtl.intf_ref_value', $values)
                   ->whereIn('emr_log_dtl.log_hdr_id', $values)
                   ->where('emr_log_hdr.baby_id', $baby_id)
                   ->where('emr_log_hdr.admission_id', $admission_id)
                   ->where('emr_log_hdr.sender_time', '>=', $today_start)
                   ->where('emr_log_hdr.sender_time', '<=', $today_current)
                   ->get();

    }
    /**
     * This method to get oxygen index
     * @param $loinc_code
     *
     * @return array of objects
     */
    public static function getOxygenIndex($loinc_code) 
    {
       return \DB::table('emr_log_hdr')
                  ->select('emr_log_dtl.*', 'emr_log_hdr.*', 'emr_log_dtl.id as log_id')
                  ->join('emr_log_dtl', 'emr_log_dtl.log_hdr_id', '=', 'emr_log_hdr.id')
                  ->where('emr_log_dtl.loinc_code', '=', $loinc_code)
                  ->where('is_calulated', false)
                  ->get();
    }

    public static function getLabResult($baby_id)
    {
      

    }

    /**
     * This method to get data for all in one chart
     *
     * @param $baby_id type integer
     * @return array of object 
     */
    public static function getChartData($baby_number)
    {
  
       $result = \DB::table('local_code_group')
                    ->join('loinc_local_code_map_part', 'loinc_local_code_map_part.ref_loc_master_id', '=','local_code_group.id')
                    ->join('fihr_formated_values', 'fihr_formated_values.snomed_code', '=', 'loinc_local_code_map_part.snomed_code')
                    ->where('mrn', $baby_number)
                    ->get();
      return $result;            
    }

    public static function getLocalName($id)
    {
      $result =  \DB::table('local_code_group')
                    ->join('loinc_local_code_map_part', 'loinc_local_code_map_part.ref_loc_master_id', '=','local_code_group.id')
                    ->where('local_code_group.id',$id)
                    ->first();
    }


    public static function checkLogIsExist($start_sender_time, $end_sender_time, $BabyId, $admission_id, $MotherId = 0) {
        $query =  \DB::table('emr_log_hdr')
                  ->select('id')
                  ->where('sender_time', '>=', $start_sender_time)
                  ->where('sender_time', '<', $end_sender_time)
                  ->where('baby_id', $BabyId)
                  ->where('admission_id', $admission_id);
                  if ($MotherId != 0) { 
                        $query->where('mother_id', $MotherId);
                  }
        return $query->orderby('id', 'desc')->first();
    }

    public static function checkLogDetailIsExist($header_id, $local_code, $table_name) {
        $query =  \DB::table($table_name)
                  ->select($table_name.'.id', $table_name.'.intf_ref_value', $table_name.'.loinc_local_map_id', $table_name.'.result_date_time')
                  ->join('local_code_group', 'local_code_group.id', '=', $table_name.'.loinc_local_map_id')
                  ->where('log_hdr_id', $header_id)
                  ->where('local_code_group.local_code', $local_code)
                  ->orderby('id', 'desc')->first();
        return $query;
    }

    /**
     * This will get the list of users who are using nurse sheet.
     *
     * @return array of object. 
     */
    public static function GetNursesUsage($from_date, $to_date) {
        $results = \DB::table('emr_log_hdr')
            ->select(\DB::raw('count(*)'), 'added_nurse')
            ->whereNotNull('added_nurse')
            ->where('added_nurse', '<>', '');
            if (!is_null($from_date) && !is_null($to_date)) {
                $results = $results->whereBetween('emr_log_hdr.create_tstamp', [$from_date, $to_date]);
            }
        $results = $results->groupBy('added_nurse')->get()->pluck('count', 'added_nurse');

        return $results;
    }    

}
