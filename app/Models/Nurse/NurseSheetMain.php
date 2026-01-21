<?php

namespace App\Models\Nurse;

use Illuminate\Database\Eloquent\Model;

class NurseSheetMain extends Model
{
   protected $table = 'nurse_main_sheet';
   protected $primaryKey = 'id';
   public $timestamps  =  false;
   protected $fillable = ['day_name', 'sheet_date','baby_id', 'admission_id', 'dcp', 'hemolysis', 'edited', 'edited_content', 'edited_time', 'ward_rounds_instruction', 'lab_flag', 'current_weight', 'working_weight', 'ett_status', 'et_size', 'et_length', 'ngt_status', 'ngt_size', 'ngt_length', 'total_input', 'total_output'];

   /**
    * This method to get nurse sheet details
    * 
    * @param $sheet_date type date
    * @param $baby_id type integer  
    * @param $admission_id type integer
    */
   public static function GetNurseSheet($sheet_date, $baby_id, $admission_id) 
   {

      return  \DB::table('nurse_main_sheet')
                  ->where('sheet_date', date('Y-m-d', strtotime($sheet_date)))
                  ->where('baby_id', $baby_id)
                  ->where('admission_id', $admission_id)
                  ->first();
   }

   /**
    * This method to get nurse sheet count
    * 
    * @param $baby_id type integer  
    * @param $admission_id type integer
    */
   public static function GetNurseSheetCount($baby_id, $admission_id) 
   {

       $result = \DB::table('nurse_main_sheet')
                  ->where('baby_id', $baby_id)
                  ->where('admission_id', $admission_id)
                  ->get();

        return $result;          
   }

  /**
   * This Method to get join the emrlogheader and 
   * nurse main sheet's together 
   *
   * @return  type array of object 
   */
   public function GetEmrHeaderDetails() 
   {
       // return $this->hasMany('App\Models\NurseManual\ManualLogHeader', 'day_id', 'id')->orderby('sender_time', 'asc');
       return $this->hasMany('App\Models\Nurse\EmrLogHeader', 'day_id', 'id')->orderby('sender_time', 'asc');
   }

   /**
    * This method to get join the emrlogheader and
    * nurse main sheet's together 
    *
    * @param $sheet_date type date
    * @param $baby_id type integer  
    * @param $admission_id type integer
    */

    public static function GetEmrHeaderChecks($sheet_date, $baby_id, $admission_id,$time)
    {
      return  \DB::table('nurse_main_sheet')
                  ->select('emr_log_hdr.*', 'nurse_main_sheet.id as main_sheet_id')
                  ->join('emr_log_hdr','emr_log_hdr.day_id','=','nurse_main_sheet.id')
                  ->where('nurse_main_sheet.sheet_date', date('Y-m-d', strtotime($sheet_date)))
                  ->whereRaw('extract(hour from emr_log_hdr.sender_time)='.date('H',strtotime($time)))
                  ->where('nurse_main_sheet.baby_id', $baby_id)
                  ->where('nurse_main_sheet.admission_id', $admission_id)
                  ->first();


    // return  \DB::table('nurse_main_sheet')
    //               ->select('manual_log_hdr.*')
    //               ->join('manual_log_hdr','manual_log_hdr.day_id','=','nurse_main_sheet.id')
    //               ->where('nurse_main_sheet.sheet_date', date('Y-m-d', strtotime($sheet_date)))
    //               ->whereRaw('extract(hour from manual_log_hdr.sender_time)='.date('H',strtotime($time)))
    //               ->where('nurse_main_sheet.baby_id', $baby_id)
    //               ->where('nurse_main_sheet.admission_id', $admission_id)
    //               ->first();


    }

    /**
  * This will get the all the baby details with sorting,pagination.
  *
  * @param $page integer
  *
  * @param $limit integer
  *
  * @param $condition array
  *   
  * @param $order array 
  *
  * @return array of object baby details. 
  */
    public static function GetBabyLists($page = 1, $limit = 50, $condition = array(), $order = array(), $slug = '')
    {

      $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend = $limit;
      // echo $limitend;
      // exit;
        $search_txt = isset($condition['search_txt']) ? $condition['search_txt'] : '';
        $checkdate = '';
      
        if (strpos($search_txt, '-') > 0) {
            $get_date      = strtotime($search_txt);
            $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
            $search_txt    = '';
        }
        $results = \DB::table('baby')
                  ->select( 'baby.*', 'nurse_main_sheet.sheet_date')
                   ->join('nurse_main_sheet','nurse_main_sheet.baby_id','=','baby.BabyId')
                    ->join('baby_admission', 'baby_admission.BabyId', '=',  'baby.BabyId')
                   //->where('baby_admission.AdmissionType', 'NICU')
                   ->where('baby.IsDeleted','0') 
                   ->where('lab_flag', 0)
            ->where(function ($query) use ($search_txt, $checkdate)
            {
                if (!empty($search_txt) && empty($checkdate)) {

                    $query->orwhere('BabyName', 'ilike', '%'.trim($search_txt).'%');
                    $query->orwhere('baby.BMrNo', $search_txt);
                    $query->orWhere('Sex', 'like', '%'.trim($search_txt).'%');
                    $query->orWhere('BabyBloodGroup', 'like', '%'.trim($search_txt).'%');
                }

                if (!empty($checkdate) && empty($search_txt)) {

                    $query->whereRaw('"baby"."DOB"::date='.$checkdate);
                }
            });
            if (isset($order['sortby']) && isset($order['sortorder']) && !empty($order['sortby']) && !empty($order['sortorder'])) {
              $results->orderBy('baby.'.$order['sortby'], $order['sortorder']);
            }
            else
            {
              $results->orderBy('nurse_main_sheet.sheet_date', 'desc');
            }

      if ($slug) {
        // $result['result'] = $results->limit($limitend)->offset($limitstart)->get()->unique('BabyId'); 
        $result_set = $results->get()->unique('BabyId')->toArray();
        // $result_set = $results->get()->toArray();
        
        $result['total'] = count($result_set);  
        $result['result'] = array_slice($result_set, $limitstart, $limitend);  
      } else {
        // $result = $results->limit($limitend)->offset($limitstart)->get()->unique('BabyId'); 
        $result_set = $results->get()->unique('BabyId')->toArray();
        // $result_set = $results->get()->toArray();
        $result['result'] = array_slice($result_set, $limitstart, $limitend);  
      }
        return $result;
    }


    /**
     * This method to get nurse sheet baby total count
     * 
     *
     * @return total by integer 
     */
    public static function GetBabyListTotal()
    {
     
        // $result =  \DB::table('baby')
        //            ->join('nurse_main_sheet','nurse_main_sheet.baby_id','=','baby.BabyId')
        //            ->where('baby.IsDeleted','0')->get()->unique('BabyId')->toArray();
        $result =  \DB::table('baby')
                   ->join('nurse_main_sheet','nurse_main_sheet.baby_id','=','baby.BabyId')
                   ->where('baby.IsDeleted','0')->get()->toArray();
        return count($result);

    }



    /**
     * This method to get nurse sheet admission list
     *
     * @param $baby_id type integer 
     * @return array of object 
     */
    public static function GetAdmissionLists($baby_id)
    {
        // return \DB::table('baby')
        //          ->select('baby_admission.*','ip_numbers.ip_number')
        //          ->join('nicu_admission', 'nicu_admission.BabyId', '=', 'baby.BabyId')
        //          ->join('baby_admission', 'baby_admission.AdmissionId', '=', 'nicu_admission.AdmissionId')
        //          ->join('nurse_main_sheet', 'nurse_main_sheet.admission_id', '=', 'baby_admission.AdmissionId')
        //          ->leftJoin('ip_numbers', 'ip_numbers.AdmissionId', '=', 'baby_admission.AdmissionId')
        //          ->where('baby.BabyId', $baby_id)
        //          ->get()->unique('AdmissionId');
         
      // return \DB::table('baby')
      //            ->select('baby_admission.*','ip_numbers.ip_number')
      //            ->leftJoin('nicu_admission', 'nicu_admission.BabyId', '=', 'baby.BabyId')
      //            ->join('baby_admission', 'baby_admission.BabyId', '=',  'baby.BabyId')
      //            ->join('nurse_main_sheet', 'nurse_main_sheet.admission_id', '=', 'baby_admission.AdmissionId')
      //            ->leftJoin('ip_numbers', 'ip_numbers.AdmissionId', '=', 'baby_admission.AdmissionId')
      //            ->where('baby.BabyId', $baby_id)
      //            ->get()->unique('AdmissionId');

      // return  \DB::table('baby')
      //            ->select('baby_admission.*','ip_numbers.ip_number')
      //            ->leftJoin('nicu_admission', 'nicu_admission.BabyId', '=', 'baby.BabyId')
      //            ->join('baby_admission', 'baby_admission.BabyId', '=',  'baby.BabyId')
      //            ->join('nurse_main_sheet', 'nurse_main_sheet.admission_id', '=', 'baby_admission.AdmissionId')
      //            ->leftJoin('ip_numbers', 'ip_numbers.AdmissionId', '=', 'baby_admission.AdmissionId')
      //            ->where('baby.BabyId', $baby_id)
      //            ->get()->unique('AdmissionId');

      return \DB::table('baby')
                 ->select('baby_admission.*')
                 ->join('baby_admission', 'baby_admission.BabyId', '=',  'baby.BabyId')
                 ->where('baby.BabyId', $baby_id)
                 // ->where('baby_admission.AdmissionType', 'NICU')
                 ->whereNotNull('baby_admission.episodes')
                 ->orderBy('DateAdded')
                 ->get()->unique('AdmissionId');
    }

    /**
     * This method to get nurse sheet day sheets 
     *
     *@param $admission_id type integer
     *
     */
    public static function GetDayLists($admission_id)
    {
       return \DB::table('baby')
                       ->join('nurse_main_sheet','nurse_main_sheet.baby_id','=','baby.BabyId')
                       ->where('baby.IsDeleted','0') 
                       ->where('nurse_main_sheet.admission_id',$admission_id)
                       ->where('lab_flag',0) 
                       ->get();
       
    }

    /**
     * This method to get nurse sheet previous day 
     *
     *@param $admission_id type integer 
     *@param $baby_id type integer 
     */
    public static function GetPrevousDayNurse($baby_id, $admission_id, $date) 
    {

        return \DB::table('nurse_main_sheet')
                   ->select('emr_log_hdr.*')
                   ->join('emr_log_hdr', 'emr_log_hdr.day_id', '=', 'nurse_main_sheet.id')
                   ->where('nurse_main_sheet.baby_id', $baby_id)
                   ->where('nurse_main_sheet.admission_id', $admission_id)
                   ->whereDate('sheet_date', $date)
                   ->orderby('sheet_date', 'desc')
                   ->orderby('emr_log_hdr.sender_time','desc')
                   ->first();
 
    }

    /**
     * This method to get 
     * 
     * @param $nurse_id type id
     * @param $local_code type string
     * @param $durg_id type id 
     */
    public static function getrunningfluids($nurse_id, $local_code, $drug_id)
    {
        return \DB::table('nurse_main_sheet')
                   ->select('emr_log_dtl.*')
                   ->join('emr_log_hdr', 'emr_log_hdr.day_id', '=', 'nurse_main_sheet.id')
                   ->join('emr_log_dtl', 'emr_log_dtl.log_hdr_id', '=', 'emr_log_hdr.id')
                   ->join('local_code_group','local_code_group.id', '=','emr_log_dtl.loinc_local_map_id')
                   ->where('local_code_group.local_code', $local_code)
                   ->where('nurse_main_sheet.id', $nurse_id)
                   ->where('emr_log_dtl.intf_ref_value', $drug_id)
                   ->get();

    }

    /**
     * This method to  get list data 
     * 
     * @param $durg_id type id 
     * @param $local_code type string  
     */
    public static function getfluidsrate($drug_id, $local_code)
    {
         return \DB::table('emr_log_dtl')
                    ->join('local_code_group','local_code_group.id', '=','emr_log_dtl.loinc_local_map_id')
                    ->whereIn('emr_log_dtl.observation_type_id', $drug_id)
                    ->where('local_code_group.local_code', $local_code)
                    ->get();
    }

    /**
     * This method to get 
     * 
     * @param $nurse_id type id
     * @param $local_code type string
     * @param $durg_id type id 
     */
    public static function getreplacementrunningfluids($nurse_id, $local_code, $drug_id)
    {
        return \DB::table('nurse_main_sheet')
                   ->select('nurse_hour_wise_sheet.*')
                   ->join('emr_log_hdr', 'emr_log_hdr.day_id', '=', 'nurse_main_sheet.id')
                   ->join('nurse_hour_wise_sheet', 'nurse_hour_wise_sheet.log_header_id', '=', 'emr_log_hdr.id')
                   ->where('nurse_hour_wise_sheet.local_code', $local_code)
                   ->where('nurse_main_sheet.id', $nurse_id)
                   ->where('nurse_hour_wise_sheet.value', $drug_id)
                   ->get();

    }

     /**
     * This method to  get list data 
     * 
     * @param $durg_id type id 
     * @param $local_code type string  
     */
    public static function getreplacementfluidsrate($drug_id, $local_code)
    {
         return \DB::table('nurse_hour_wise_sheet')
                    ->whereIn('nurse_hour_wise_sheet.observe_id', $drug_id)
                    ->where('nurse_hour_wise_sheet.local_code', $local_code)
                    ->get();
    }

    /**
     * This method to get 
     * 
     * @param $nurse_id type id
     * @param $local_code type string
     * @param $durg_id type id 
     */
    public static function getrunningoutput($nurse_id, $local_code)
    {
        return \DB::table('nurse_main_sheet')
                   ->select('emr_log_dtl.*','emr_nurse_manual_values.*')
                   ->join('emr_log_hdr', 'emr_log_hdr.day_id', '=', 'nurse_main_sheet.id')
                   ->leftjoin('emr_log_dtl', 'emr_log_dtl.log_hdr_id', '=', 'emr_log_hdr.id')
                   ->leftjoin('emr_nurse_manual_values', 'emr_nurse_manual_values.log_hdr_id', '=', 'emr_log_hdr.id')
                   ->join('local_code_group', function ($join) {
                      $join->orOn('emr_log_dtl.loinc_local_map_id', '=', 'local_code_group.id')
                      ->orOn('emr_nurse_manual_values.loinc_local_map_id', '=', 'local_code_group.id');
                    })
                   ->where('local_code_group.local_code', $local_code)
                   ->where('nurse_main_sheet.id', $nurse_id)
                   ->get();

    }

   /**
    * This method to get spot urine 
    * output 
    * 
    * @param $sheet_date type date 
    * @param $baby_id type integer 
    * @param $admisson type integer 
    */
   public static function getspoturineoutput($sheet_date, $baby_id, $admission_id, $slug)
   {

       return \DB::table('emr_log_hdr')
                  ->select('emr_log_dtl.*', 'emr_log_hdr.sender_time')
                  ->join('emr_log_dtl','emr_log_dtl.log_hdr_id', '=', 'emr_log_hdr.id') 
                  ->join('local_code_group','local_code_group.id','=', 'emr_log_dtl.loinc_local_map_id')
                  ->where('emr_log_hdr.baby_id', $baby_id)
                  ->where('emr_log_hdr.admission_id', $admission_id)
                  ->where('local_code_group.local_code',$slug)
                  ->orderBy('emr_log_hdr.sender_time','desc')
                  ->first();
   }

    /**
     * This method to get nurse sheet day sheets 
     *
     * @param $admission_id type integer
     *
     * @param $order type string
     */
    public static function GetDayOrderLists($admission_id, $admission_date, $admission_date_end, $order)
    {
       return \DB::table('baby')
                       ->join('nurse_main_sheet','nurse_main_sheet.baby_id','=','baby.BabyId')
                       ->where('baby.IsDeleted','0') 
                       ->where('nurse_main_sheet.admission_id',$admission_id)
                       ->where('nurse_main_sheet.sheet_date', '>=', $admission_date)
                       ->where('nurse_main_sheet.sheet_date', '<=', $admission_date_end)
                       ->orderBy('nurse_main_sheet.id', $order)
                       ->get();
    }

    /**
     * FETCH NON DELETED DATA RECORD COUNT
     *
     * @return integer
     */
    public static function GetTotal()
    {
        // $result =  \DB::table('baby')
        //                 ->whereIn('baby.BabyId', \DB::table('nurse_main_sheet')->get()->pluck('baby_id'))
        //                 ->where('baby.IsDeleted','0') 
        //                 ->where('baby.BabyName','<>','   ') 
        //                 ->where('baby.BMrNo','<>','   ') 
        //                 ->orderBy('baby.BabyId', 'desc')
        //                 ->get()->unique('BabyId');

        $result =  \DB::table('baby')
                        ->whereIn('baby.BabyId', \DB::table('nurse_main_sheet')->get()->pluck('baby_id'))
                        ->where('baby.IsDeleted','0') 
                        ->where('baby.BabyName','<>','   ') 
                        ->where('baby.BMrNo','<>','   ') 
                        ->orderBy('baby.BabyId', 'desc')
                        ->get();
        return count($result);

    }



    /**
     * This method to get 
     * 
     * @param $nurse_id type id
     * @param $local_code type string
     * @param $durg_id type id 
     */
    public static function getManualRunningFluids($nurse_id, $local_code, $drug_id)
    {
        return \DB::table('nurse_main_sheet')
                   ->select('manual_log_dtl.*')
                   ->join('manual_log_hdr', 'manual_log_hdr.day_id', '=', 'nurse_main_sheet.id')
                   ->join('manual_log_dtl', 'manual_log_dtl.log_hdr_id', '=', 'manual_log_hdr.id')
                   ->join('local_code_group','local_code_group.id', '=','manual_log_dtl.loinc_local_map_id')
                   ->where('local_code_group.local_code', $local_code)
                   ->where('nurse_main_sheet.id', $nurse_id)
                   ->where('manual_log_dtl.intf_ref_value', $drug_id)
                   ->get();

    }

    /**
     * This method to  get list data 
     * 
     * @param $durg_id type id 
     * @param $local_code type string  
     */
    public static function getManualFluidsRate($drug_id, $local_code)
    {
         return \DB::table('manual_log_dtl')
                    ->join('local_code_group','local_code_group.id', '=','manual_log_dtl.loinc_local_map_id')
                    ->whereIn('manual_log_dtl.observation_type_id', $drug_id)
                    ->where('local_code_group.local_code', $local_code)
                    ->get();
    }

    /**
     * This method to get 
     * 
     * @param $nurse_id type id
     * @param $local_code type string
     * @param $durg_id type id 
     */
    public static function getManualReplacementRunningFluids($nurse_id, $local_code, $drug_id)
    {
        return \DB::table('nurse_main_sheet')
                   ->select('nurse_hour_wise_sheet.*')
                   ->join('manual_log_hdr', 'manual_log_hdr.day_id', '=', 'nurse_main_sheet.id')
                   ->join('nurse_hour_wise_sheet', 'nurse_hour_wise_sheet.log_header_id', '=', 'manual_log_hdr.id')
                   ->where('nurse_hour_wise_sheet.local_code', $local_code)
                   ->where('nurse_main_sheet.id', $nurse_id)
                   ->where('nurse_hour_wise_sheet.value', $drug_id)
                   ->get();

    }

    /**
     * @param $durg_id type id 
     * @param $local_code type string  
     */
    public static function getManualReplacementFluidsRate($drug_id, $local_code)
    {
         return \DB::table('nurse_hour_wise_sheet')
                    ->whereIn('nurse_hour_wise_sheet.observe_id', $drug_id)
                    ->where('nurse_hour_wise_sheet.local_code', $local_code)
                    ->get();
    }

    /**
     * This method to get 
     * 
     * @param $nurse_id type id
     * @param $local_code type string
     * @param $durg_id type id 
     */
    public static function getManualRunningOutput($nurse_id, $local_code)
    {
        return \DB::table('nurse_main_sheet')
                   ->select('manual_log_dtl.*')
                   ->join('manual_log_hdr', 'manual_log_hdr.day_id', '=', 'nurse_main_sheet.id')
                   ->join('manual_log_dtl', 'manual_log_dtl.log_hdr_id', '=', 'manual_log_hdr.id')
                   ->join('local_code_group','local_code_group.id', '=','manual_log_dtl.loinc_local_map_id')
                   ->where('local_code_group.local_code', $local_code)
                   ->where('nurse_main_sheet.id', $nurse_id)
                   ->get();

    }

   /**
    * This method to get spot urine 
    * output 
    * 
    * @param $sheet_date type date 
    * @param $baby_id type integer 
    * @param $admisson type integer 
    */
   public static function getManualSpotUrineOutput($sheet_date, $baby_id, $admission_id, $slug)
   {

       return \DB::table('manual_log_hdr')
                  ->select('manual_log_dtl.*', 'manual_log_hdr.sender_time')
                  ->join('manual_log_dtl','manual_log_dtl.log_hdr_id', '=', 'manual_log_hdr.id') 
                  ->join('local_code_group','local_code_group.id','=', 'manual_log_dtl.loinc_local_map_id')
                  ->where('manual_log_hdr.baby_id', $baby_id)
                  ->where('manual_log_hdr.admission_id', $admission_id)
                  ->where('local_code_group.local_code',$slug)
                  ->orderBy('manual_log_hdr.sender_time','desc')
                  ->first();
   }

   /**
    * This method to get monitor entry dates to list nurse sheet
    * output 
    * 
    * @param $sheet_date type date 
    * @param $baby_id type integer 
    * @param $admisson type integer 
    */
   public static function GetMonitorEntryDates($admission_id, $table_name)
   {
        return \DB::table('emr_log_hdr')
                    ->selectRaw("DISTINCT sender_time::date")
                    ->join($table_name, $table_name.'.log_hdr_id', '=', 'emr_log_hdr.id')
                    ->where('emr_log_hdr.admission_id', $admission_id)
                    ->get();
   }

   public static function getPreviousWorkingWeight($baby_id) {
        return self::select('working_weight')
                    ->where('baby_id', $baby_id)
                    ->whereNotNull('working_weight')
                    ->where('working_weight', '<>', '')
                    ->orderBy('sheet_date', 'desc')
                    ->first();
   }

   public static function getAWeekDetails($admission_id, $start_date, $end_date) {
        $result = self::select('current_weight', 'total_input', 'total_output', 'sheet_date')
                  ->where('admission_id', $admission_id)
                  ->whereBetween('sheet_date', [$start_date, $end_date])
                  ->orderBy('sheet_date', 'desc')
                  ->get();
        return $result;

    }
    
    // To get the previous and next day sheet id for the currently selected data
    public static function getPrevNextIds($admission_id, $id)
    {
        return self::select('id')->where('lab_flag', false)->where('admission_id', $admission_id)->orderBy('id', 'asc')->get();
    }

}
