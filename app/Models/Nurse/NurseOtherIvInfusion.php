<?php

namespace App\Models\Nurse;

use Illuminate\Database\Eloquent\Model;
/**
 * @property get $fillable['is_send'] => 0 => ready to send new admission  
 * @property set $fillable['is_send'] => 1 => new admission send to pump   
 *
 * @property get $fillable['is_send'] => 2 => ready to send transfer admission  
 * @property set $fillable['is_send'] => 3 => transfer admission send to pump  
 *
 * @property get $fillable['is_send'] => 4 => ready to send discharge admission
 * @property set $fillable['is_send'] => 5 => discharge admission send to pump
 * @property set $fillable['is_send'] => 6 => pump in pause
 * @property set $fillable['is_send'] => 7 => medicine completed
 */
class NurseOtherIvInfusion extends Model
{
  protected $table = 'nurse_other_iv_infusion';
  protected $primaryKey = 'id';
  public $timestamps  =  false;
  protected $fillable =['other_infusions_day', 'other_infusions_pharmacological', 'other_infusions_volume', 
                        'other_infusions_duration', 'other_infusions_durametnod', 'other_infusions_rate', 
                        'other_infusions_instruction', 'date_prescribed', 'date_started', 
                        'date_stopped', 'baby_id', 'admission_id', 'mother_id',
                        'day_id', 'IsDeleted', 'is_send', 'order_status', 'infusion_type', 'working_weight', 
                        'time_id','is_canceld', 'created_date', 'modified_date', 'created_user', 'modified_user'];


    /**
     * This method to get other 
     * infustion iv drugs 
     *
     * @param $baby_id
     * @param $admission_id
     */ 
     public static function getOtherIvInfusionDrugs($baby_id, $admission_id)
     {
       return \DB::table('nurse_other_iv_infusion')
                  ->select('*')
                  ->where('baby_id', $baby_id)
                  ->where('admission_id', $admission_id)
                  ->where('IsDeleted', 0)
                  ->get();
     }   
     
     /**
      * This method to get oother iv infusion
      * to send to syringe pump
      *
      *
      */
      public static function getotherIvinfusiontopump()
      {
        return \DB::table('nurse_other_iv_infusion')
                   ->where('is_send','1')
                   ->where('IsDeleted', 0)
                   ->first();
      }    

    /**
      * This method to get oother iv infusion
      * to send to syringe pump
      *
      *
      */
     public static function getotherIvinfusiontoCancel()
     {
        return \DB::table('nurse_other_iv_infusion')
                   ->where('is_send','3')
                   ->where('is_canceld', false)
                   ->where('IsDeleted', 0)
                   ->first();
     }     

    /**
     * This method to get last other iv infusion
     */
    public static function getLastOtherIvInfusion()
    {
        return \DB::table('nurse_other_iv_infusion')
                   ->select('id', 'working_weight')
                   ->orderBy('id', 'desc')
                   ->first();
    }

    /**
     * This method to get other 
     * infustion iv drugs 
     *
     * @param $baby_id
     * @param $admission_id
     */ 
     public static function getOtherIvInfusionDrugsByDate($baby_id, $admission_id, $date = '')
     {
       return \DB::table('nurse_other_iv_infusion')
                  ->select('*')
                  ->where('baby_id', $baby_id)
                  ->where('admission_id', $admission_id)
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
