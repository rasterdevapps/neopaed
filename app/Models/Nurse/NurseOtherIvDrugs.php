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

class NurseOtherIvDrugs extends Model
{
  protected $table = 'nurse_other_iv_drugs';
  protected $primaryKey = 'id';
  public $timestamps  =  false;
  protected $fillable = ['other_iv_drugs_day', 'other_iv_drugs_brandname', 'other_iv_drugs_pharmacological', 'other_iv_drugs_dose_required','other_iv_drugs_dose_units_g',
                         'other_iv_drugs_frequency', 'other_iv_drugs_syringe', 'other_iv_drugs_rate', 'other_iv_drugs_additional', 
                         'date_started', 'date_prescribed', 'date_stopped', 
                         'baby_id', 'admission_id', 'mother_id', 'day_id', 'IsDeleted', 'is_send', 
                         'order_status', 'infusion_type', 'working_weight', 'time_id','is_canceld', 'prescribed_user_id',
                             'created_date', 'modified_date', 'created_user', 'modified_user'
                          // 'repeat_prescription'
                        ];
    /**
     * This method to get infusion drugs 
     *
     * @param $baby_id type integer
     * @param $admission_id type integer 
     *
     */
     public static function getOtherIvDrugs($baby_id, $admission_id)
     {
      return \DB::table('nurse_other_iv_drugs')
                 ->select('*')
                 ->where('baby_id',$baby_id)
                 ->where('admission_id',$admission_id)
                 ->where('IsDeleted', 0)
                 ->get();
     }  

     /**
      * This method to sent infusion to syrange
      * pump
      *
      */
     public static function getotherIvDrugstopump()
     {
        return \DB::table('nurse_other_iv_drugs')
                   ->where('is_send','1')
                   ->where('IsDeleted', 0)
                   ->first();
     }

    /**
      * This method to sent infusion to syrange
      * pump
      *
      */
     public static function getotherIvDrugstoCancel()
     {
        return \DB::table('nurse_other_iv_drugs')
                   ->where('is_send','3')
                   ->where('is_canceld', false)
                   ->where('IsDeleted', 0)
                   ->first();
     }       

    /**
     * This method to get last iv Drugs
     */
    public static function getLastIvDrugs()
    {
        return \DB::table('nurse_other_iv_drugs')
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
     public static function getOtherIvDrugsByDate($baby_id, $admission_id, $date = '')
     {
      return \DB::table('nurse_other_iv_drugs')
                 ->select('*')
                 ->where('baby_id',$baby_id)
                 ->where('admission_id',$admission_id)
                 ->where('IsDeleted', 0)
                 ->where('is_canceld', false)
                 ->where('is_send', '<>', 3)
                 ->orderBy('time_id', 'asc')
                 ->get();
     } 


}
