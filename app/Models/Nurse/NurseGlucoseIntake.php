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
class NurseGlucoseIntake extends Model
{
    protected $table     = 'nurse_glucose_intake';
  protected $primaryKey  = 'id';
  public    $timestamps  =  false;
  protected $fillable    = ['speical_iv_day', 'speical_iv_fluid_name_one', 'speical_fluid_vol_one', 
                            'speical_iv_fluid_name_two', 'speical_fluid_vol_two', 'speical_iv_syringe', 
                            'speical_iv_dextrose', 'speical_iv_glucose', 'speical_iv_infusion_rate', 
                            'speical_iv_instruction', 'date_prescribed', 'date_started',
                            'date_stopped', 'baby_id', 'admission_id',
                            'mother_id', 'day_id', 'IsDeleted', 'is_send', 'order_status', 'infusion_type', 
                            'working_weight', 'time_id', 'is_canceld',
                            'created_date', 'modified_date', 'created_user', 'modified_user'];
   
    /**
     * This method get glucoseintake 
     *
     * @param $baby_id type integer
     * @param $admission_id type integer
     * @return array of object 
     */
    public static function getGlucoseIntake($baby_id, $admission_id)
    {
      return \DB::table('nurse_glucose_intake')
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
    public static function getglucoseintaketopump()
    {
        return \DB::table('nurse_glucose_intake')
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
    public static function getglucoseintaketoCancel()
    {
        return \DB::table('nurse_glucose_intake')
                   ->where('is_send','3')
                   ->where('is_canceld', false)
                   ->where('IsDeleted', 0)
                   ->first();
    }  

    /**
     * This method to get last glucose intake
     */
    public static function getLastGlucose()
    {
        return \DB::table('nurse_glucose_intake')
                   ->select('id')
                   ->orderBy('id', 'desc')
                   ->first();
    } 

    /**
     * This method get glucoseintake 
     *
     * @param $baby_id type integer
     * @param $admission_id type integer
     * @return array of object 
     */
    public static function getGlucoseIntakeByDate($baby_id, $admission_id, $date = '')
    {
      return \DB::table('nurse_glucose_intake')
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
