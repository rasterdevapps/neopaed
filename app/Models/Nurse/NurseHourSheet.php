<?php

namespace App\Models\Nurse;

use Illuminate\Database\Eloquent\Model;

class NurseHourSheet extends Model
{
   protected $table = 'nurse_hour_wise_sheet';
   protected $primaryKey = 'id';
   public $timestamps  =  false;
   protected $fillable = ['local_code', 'value','log_header_id', 'observe_id'];


  /**
   * This method to get exisiting hourwise sheets
   *
   * @param $day_id type 
   *
   * @return array of object 
   */

   public static function gethourwisesheet($day_id)
   {
       $hourwisesheet = \DB::table('nurse_hour_wise_sheet')
                        ->select('nurse_hour_wise_sheet.*')
                        ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'nurse_hour_wise_sheet.log_header_id')
                        ->where('emr_log_hdr.day_id',$day_id)
                        ->get();

        return  $hourwisesheet;
       
   }

   /**
    * This method to get previous data
    *
    * @param $header_id type integer 
    * @param $local_code type integer
    */
    public static function Getpreviousdata($header_id, $local_code)
    {
   
       return \DB::table('nurse_hour_wise_sheet')
                 ->whereIn('local_code', $local_code)
                 ->where('log_header_id', $header_id)
                 ->get();

    }

    /**
     * This method to get data based on header id 
     *
     * @param $header_id
     */
    public static function GetData($header_id)
    {
        return \DB::table('nurse_hour_wise_sheet')
                 ->where('log_header_id', $header_id)
                 ->orderBy('id', 'desc')
                 ->get()
                 ->unique('local_code');

    }

  /**
   * This method to get exisiting hourwise sheets
   *
   * @param $day_id type 
   *
   * @return array of object 
   */

   public static function gethourwisesheetmanual($day_id)
   {
       $hourwisesheet = \DB::table('nurse_hour_wise_sheet')
                            ->select('nurse_hour_wise_sheet.*')
                            ->join('manual_log_hdr', 'manual_log_hdr.id', '=', 'nurse_hour_wise_sheet.log_header_id')
                            ->where('manual_log_hdr.day_id',$day_id)
                            ->get();

        return  $hourwisesheet;
       
   }

}
