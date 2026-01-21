<?php

namespace App\Models\Nurse;

use Illuminate\Database\Eloquent\Model;

class ImportFhir extends Model
{
    /**
     * This method to get baby details
     *  
     * @param $mrn_number type int
     * 
     * @return array of objecct
     */
    public static function get_baby_details($mrn_number)
    {
        $result = \DB::table('baby')
                     ->where('BMrNo', $mrn_number)
                     ->where('IsDeleted','0')
                     ->first();

        return $result;
    }

    /**
     * This method to get baby details
     *  
     * @param $mrn_number type int
     * @param $ip_number type int
     * 
     * @return array of objecct
     */
    public static function get_baby_admission($baby_id, $ip_number)
    {
        // $result = \DB::table('baby_admission')
        //              ->where('BabyId', $baby_id)
     //               ->where('Status','!=', 'Discharged')
        //              ->first();

       $result = \DB::table('ip_numbers')
                   ->join('baby_admission', 'ip_numbers.AdmissionId', '=', 'baby_admission.AdmissionId')
                   ->where('ip_numbers.baby_id', $baby_id)
                   // ->where('ip_numbers.ip_number', $ip_number)
                   ->where('baby_admission.AdmissionType', 'NICU')
                   // Reason: If the patient had more than 1 admission, last admission status is discharge but previous admission status is inpatient, then data is stored against the previous admission. To avoid this issue AISWARYA hides the below line.
                   // ->where('baby_admission.Status', 'Inpatient')
                   ->whereNotNUll('ip_numbers.AdmissionId')
                   ->orderBy('baby_admission.AdmissionId', 'desc')
                   ->first();
        return $result;
    }

    /**
     * This method to get baby details
     *  
     * @param $mrn_number type int
     * 
     * @return array of objecct
     */
    public static function get_nurse_sheet_header($babyId, $admissionid, $nurse_date)
    {
        $result = \DB::table('emr_log_hdr')
                      ->where('baby_id', $babyId)
                      ->where('admission_id', $admissionid)
                      ->where('visit_date', $nurse_date)
                      ->first();
        return $result;
    }

    /**
     * This method to get baby details
     *  
     * @param $mrn_number type int
     * 
     * @return array of objecct
     */
    // public static function get_nurse_sheet_details($emr_log_header_id, $nurse_time, $local_id)
    // {
    //  $result = \DB::table('emr_log_dtl')
    //                ->where('log_hdr_id', $emr_log_header_id)
    //                   ->where('time', $nurse_time)
    //                   ->where('loinc_local_map_id', $local_id)
                //    ->first();

    //  return $result;
    // }


    /** UPDATED
     * This method to get baby details
     *  
     * @param $mrn_number type int
     * 
     * @return array of objecct
     */
    public static function get_nurse_sheet_details($emr_log_header_id, $nurse_time, $local_id, $table_name, $asset_number)
    {
        $result = \DB::table($table_name)
                      ->where('log_hdr_id', $emr_log_header_id)
                      // ->where('time', $nurse_time)
                      ->whereRaw('extract(hour from '. $table_name .'.result_date_time)='.date('H',strtotime($nurse_time)))
                      ->where('loinc_local_map_id', $local_id)
                      ->where('device_id', $asset_number)
                      ->first();

        return $result;
    }

    /**
    * This method to get join the emrlogheader and
    * nurse main sheet's together 
    *
    * @param $sheet_date type date
    * @param $baby_id type integer  
    * @param $admission_id type integer
    */

    public static function get_emr_header_checks($sheet_date, $baby_id, $admission_id, $time)
    {

      return  \DB::table('nurse_main_sheet')
                  ->select('emr_log_hdr.*')
                  ->join('emr_log_hdr','emr_log_hdr.day_id','=','nurse_main_sheet.id')
                  ->where('nurse_main_sheet.sheet_date', date('Y-m-d', strtotime($sheet_date)))
                  ->whereRaw('extract(hour from emr_log_hdr.sender_time)='.date('H',strtotime($time)))
                  ->whereRaw("sender_time::DATE='".date('Y-m-d',strtotime($sheet_date))."'")
                  ->where('nurse_main_sheet.baby_id', $baby_id)
                  ->where('nurse_main_sheet.admission_id', $admission_id)
                  ->first();

    }
    
    /**
     * This method to check sheet exists
     * or not
     * 
     * @param $sheet_date type date
     * @param $baby_id type integer
     * @param $date type date 
     * 
     */
     public static function get_nurse_sheet_check($sheet_date, $baby_id, $admission_id)
     {
        return \DB::table('nurse_main_sheet')
                   ->where('nurse_main_sheet.sheet_date', date('Y-m-d', strtotime($sheet_date)))
                   ->where('nurse_main_sheet.baby_id', $baby_id)
                   ->where('nurse_main_sheet.admission_id', $admission_id)
                   ->first();

     }



    /**
     * This method to get baby details
     *  
     * @param $mrn_number type int
     * 
     * @return array of objecct
     */
    public static function get_nurse_snomed_details($code_details)
    {       
        $code_details = str_replace(' ', '', $code_details);
        $result = \DB::table('snomed_nurse_reference')
                      ->where('snomed_code', '=',$code_details)
                      ->get();

        return $result;
    }

    /**
    * This method to get nurse sheet count
    * 
    * @param $baby_id type integer  
    * @param $admission_id type integer
    */
   public static function get_nurse_sheet_count($baby_id, $admission_id, $sheet_date = '') 
   {

    $result = \DB::table('nurse_main_sheet')
        ->where('baby_id', $baby_id)
        ->where('admission_id', $admission_id);
        if ($sheet_date != '') {
            $result = $result->where('sheet_date', $sheet_date);
        }
    $result = $result->count();

    return $result;          
   }

    /**
    * This method to get nurse sheet count
    * 
    * @param $baby_id type integer  
    * @param $admission_id type integer
    */
   public static function get_baby_bed_log($baby_id, $admission_id) 
   {

       $result = \DB::table('patient_bed_log')
                  ->where('baby_id', $baby_id)
                  ->where('admission_id', $admission_id)
                  ->where('IsDeleted', '0')
                  ->where('status', 'Occupied')
                  ->orderBy('DateAdded', 'desc')
                  ->first();

        return $result;          
   }

    /**
    * This method to get syrange pump status
    * 
    * @param $baby_id type integer  
    * @param $admission_id type integer
    */
   public static function getSyrangePump($baby_id, $admission_id, $pump_type) 
   {

       $result = \DB::table('syringe_pump_admisson')
                  ->where('baby_id', $baby_id)
                  ->where('admission_id', $admission_id)
                  ->where('pump_modal', $pump_type)
                  ->first();

        return $result;          
   }
   
    /**
    * This method to get syrange pump status
    * 
    * @param $baby_id type integer  
    * @param $admission_id type integer
    */
   public static function get_existing_admission($baby_id, $ip_number) 
   {

       $result = \DB::table('ip_numbers')
                  ->where('baby_id', $baby_id)
                  ->where('ip_number', $ip_number)
                  ->whereNotNull('AdmissionId')
                  ->orderBy('id', 'desc')
                  ->first();

        return $result;          
   }

     /**
    * This method to get nurse sheet count
    * 
    * @param $header_id type integer  
    * @param $loinc_local_map_id type integer
    */
   public static function get_lab_values($header_id, $loinc_local_map_id) 
   {

       $result = \DB::table('emr_lab_values')
                  ->where('log_hdr_id', $header_id)
                  ->where('loinc_local_map_id', $loinc_local_map_id)
                  ->first();

        return $result;          
   }
   /**
    * This method to get lab request for currently admitted babies
    * 
    */
   public static function getLabRequestList() 
   {

       $result = \DB::table('patient_bed_log')
                  ->select('ip_numbers.ip_number', 'patient_bed_log.*', 'baby_admission.BMrNo')
                  ->join('ip_numbers', 'ip_numbers.AdmissionId', '=', 'patient_bed_log.admission_id')
                  ->join('baby_admission', 'ip_numbers.AdmissionId', '=', 'baby_admission.AdmissionId')
                  ->where('patient_bed_log.status', 'Occupied')
                  // ->where('patient_bed_log.IsDeleted', 0)
                  ->where('baby_admission.Status', 'Inpatient')
                  // ->whereBetween('patient_bed_log.bed_no', ['1', '14'])
                  ->whereNotNull('ip_numbers.AdmissionId')
                  ->whereNotNull('ip_numbers.ip_number')
                  ->get()->unique('ip_number');

        return $result;          
   }
   /**
    * This method is used to get Piliminary result for particular sample number
    * 
    */
   public static function getPilimReport($lab_sample_number, $local_code_id) 
   {
        $result = \DB::table('emr_lab_values')
              ->select('id', 'intf_ref_value')
              ->where('lab_sample_number', $lab_sample_number)
              ->where('loinc_local_map_id', $local_code_id)
              ->where('result_status', 'preliminary')
              ->where('is_display', true)
              ->pluck('id')->toArray();

        return $result;   
   }
   
    /**
     * This method to get baby details
     *  
     * @param $mrn_number type int
     * @param $ip_number type int
     * 
     * @return array of objecct
     */
    public static function get_all_baby_admission($baby_id, $ip_number)
    {

       $result = \DB::table('ip_numbers')
                   ->join('baby_admission', 'ip_numbers.AdmissionId', '=', 'baby_admission.AdmissionId')
                   ->where('ip_numbers.baby_id', $baby_id)
                   ->where('ip_numbers.ip_number', $ip_number)
                   ->where('baby_admission.AdmissionType', 'NICU')
                   ->first();
        return $result;
    }
}
