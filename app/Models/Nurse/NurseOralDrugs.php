<?php

namespace App\Models\Nurse;

use Illuminate\Database\Eloquent\Model;

class NurseOralDrugs extends Model
{
    protected $table      = 'nurse_oral_drugs';
  protected $primaryKey = 'id';
  public $timestamps    =  false;
  protected $fillable   =['oral_days', 'oral_brandname', 'oral_pharmacological', 'oral_dose_required', 
                            'oral_frequency', 'oral_route', 'oral_additional', 'date_prescribed', 
                            'date_stopped', 'date_started', 'baby_id', 'admission_id', 'mother_id', 
                            'day_id', 'IsDeleted', 'is_send', 'order_status', 'working_weight', 
                            'prescribed_user_id', 'created_date', 'modified_date', 'created_user', 
                            'modified_user'];

    /**
     * This method to get oral drugs
     *
     * @param $baby_id type integer
     * @param $admission_id type integer
     */
     public static function getOralDrugs($baby_id, $admission_id)
     {
      return \DB::table('nurse_oral_drugs')
                  ->select('*')
                  ->where('baby_id', $baby_id)
                  ->where('admission_id', $admission_id)
                  ->where('IsDeleted', 0)
                  ->get();

     }        
     /**
     * This method to get oral drugs
     *
     * @param $baby_id type integer
     * @param $admission_id type integer
     */
     public static function getOralDrugsByDate($baby_id, $admission_id, $date = '')
     {
        return \DB::table('nurse_oral_drugs')
                  ->select('*')
                  ->where('baby_id', $baby_id)
                  ->where('admission_id', $admission_id)
                  ->where('IsDeleted', 0)
                  ->where(function ($query) use ($date) {
                     if ($date != '')
                     $query->where('date_prescribed', $date);
                  })
                  ->orderBy('id', 'asc')
                  ->get();

     }               
}
