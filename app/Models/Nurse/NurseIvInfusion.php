<?php

namespace App\Models\Nurse;

use Illuminate\Database\Eloquent\Model;

/**
 * @property get $fillable['is_send'] => 0 => ready to send new admission  
 * @property set $fillable['is_send'] => 1 => new admission send to pump   
 *
 * @property get $fillable['is_send'] => 2 => Waiting for execution
 * @property set $fillable['is_send'] => 3 => transfer admission send to pump  
 *
 * @property get $fillable['is_send'] => 4 => ready to send discharge admission
 * @property set $fillable['is_send'] => 5 => discharge admission send to pump
 * @property set $fillable['is_send'] => 6 => pump in pause
 * @property set $fillable['is_send'] => 7 => medicine completed
 * @property set $fillable['is_send'] => 9 => Send to pump
 */
class NurseIvInfusion extends Model
{
  protected $table      = 'nurse_iv_infusion';
  protected $primaryKey = 'id';
  public    $timestamps    =  false;
  protected $fillable   = ['infusion_day', 'infusion_brandname', 'infusion_pharmacological', 'infusion_dose',
                             'infusion_dose_units_g', 'infusion_dose_units_kg', 'infusion_dose_units_time', 
                             'infusion_quantity', 'infusion_quantity_units', 'infusion_syringe', 'infusion_rate', 
                             'infusion_instruction', 'date_prescribed', 'date_started', 'baby_id', 'admission_id', 
                             'mother_id', 'day_id','is_send', 'IsDeleted', 'order_status', 'infusion_type',
                             'working_weight', 'time_id', 'is_canceld', 'date_stopped',
                             'created_date', 'modified_date', 'created_user', 'modified_user'];


    /**
     * This method to get infusion drugs 
     *
     * @param $baby_id type integer
     * @param $admission_id type integer 
     *
     */
     public static function getivInfusionDetails($baby_id, $admission_id)
     {
  
      return \DB::table('nurse_iv_infusion')
                 ->select('*')
                 ->where('baby_id',$baby_id)
                 ->where('admission_id',$admission_id)
                 ->where('IsDeleted', 0)
                 ->get();
     }

     /**
     * This method to get infusion drugs 
     *
     * @param $baby_id type integer
     * @param $admission_id type integer 
     *
     */
     public static function getivInfusionPump($baby_id, $admission_id)
     {
      return \DB::table('nurse_iv_infusion')
                 ->where('baby_id',$baby_id)
                 ->where('admission_id',$admission_id)
                 ->get();
     }

     /**
      * This method to sent infusion to syrange
      * pump
      *
      */
     public static function getivInfusiontopump()
     {
        return \DB::table('nurse_iv_infusion')
                   ->where('is_send','1')
                   ->where('IsDeleted', 0)
                   ->first();
     }

    /**
      * This method to sent infusion to syrange
      * pump
      *
      */
    public static function getivInfusiontoCancel()
    {
        return \DB::table('nurse_iv_infusion')
                   ->where('is_send','3')
                   ->where('is_canceld', false)
                   ->where('IsDeleted', 0)
                   ->first();
    }

    /**
     * This method to get last iv infusion
     */
    public static function getLastInfusion()
    {
        return \DB::table('nurse_iv_infusion')
                   ->select('id', 'working_weight')
                   ->orderBy('id', 'desc')
                   ->first();
    }
   
    /**
     * This method to get infusion drugs 
     *
     * @param $baby_id type integer
     * @param $admission_id type integer 
     *
     */
     public static function getivInfusionByDate($baby_id, $admission_id, $date = '')
     {
      return \DB::table('nurse_iv_infusion')
                 ->select('*')
                 ->where('baby_id',$baby_id)
                 ->where('admission_id',$admission_id)
                 ->where('IsDeleted', 0)
                 ->where(function ($query) use ($date) {
                    if ($date != '')
                    $query->where('date_prescribed', $date);
                 })
                 ->where('is_canceld', false)
                 ->where('is_send', '<>', 3)
                 ->orderBy('time_id', 'desc')
                 ->get();
     }

   
}
