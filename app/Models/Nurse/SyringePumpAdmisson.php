<?php

namespace App\Models\Nurse;

use Illuminate\Database\Eloquent\Model;

/**
 * @property get $fillable['admission_stauts'] => 0 => ready to send new admission  
 * @property set $fillable['admission_stauts'] => 1 => new admission send to pump   
 *
 * @property get $fillable['admission_stauts'] => 2 => ready to send transfer admission  
 * @property set $fillable['admission_stauts'] => 3 => transfer admission send to pump  
 *
 * @property get $fillable['admission_stauts'] => 4 => ready to send discharge admission
 * @property set $fillable['admission_stauts'] => 5 => discharge admission send to pump
 * @property set $fillable['admission_stauts'] => 6 => pump in pause
 * @property set $fillable['admission_stauts'] => 7 => medicine completed
 * 
 * @property set $fillable['admission_stauts'] => 8 => ready to send updated patient details
 * @property set $fillable['admission_stauts'] => 9 => patient details send to pump
 */

class SyringePumpAdmisson extends Model
{
    protected $table       = 'syringe_pump_admisson';
	protected $primaryKey  = 'id';
	public    $timestamps  =  false;
	protected $fillable    = ['baby_id', 'mother_id', 'admission_id', 'admission_stauts','height', 'weight', 'blood_group', 'is_admission_closed'];
	public $admission_new = 0;
	
	/**
	 * This method to get 
	 * baby details for syirange pump admission 
	 * 
	 * @param $baby_id
	 * @param $admission_id
	 * @return array of object 
	 */
	 public static function getAdmissionSyirangePump($baby_id, $admission_id)
	 {
	 	return \DB::table('baby')
				 	->join('ip_numbers', function ($join) {
			            $join->on('baby.BabyId', '=', 'ip_numbers.baby_id');
			        })
			       ->where('baby_id', $baby_id)  
			       ->where('AdmissionId', $admission_id)  
			       ->first();

	 }
	 /**
	  * This method to get pump details
	  * 
	  *@param $baby_id type integer
	  *@param $admission_id integer  
	  *@param $status boolean      
	  *@return array of object  
	  */
	 public static function getSyirangePumpDetails($baby_id, $admission_id, $status)
	 {
		return self::where('baby_id','=',$baby_id)
				   ->where('admission_id','=',$admission_id)
				  // ->where('is_admission_closed','=',$status)	
                   ->orderby('id','desc')
                   ->first();
	 }

	 /**
	  * This method to get baby admission status
	  * 
	  *@param $baby_id type integer
	  *@param $admission_id integer  
	  *@param $status boolean      
	  *@return array of object  
	  */
	 public static function getBabyAdmissionStatus($baby_id, $admission_id, $status)
	 {
		return self::where('baby_id','=',$baby_id)
				   ->where('admission_id','=',$admission_id)
				   ->where('admission_stauts',$status)
                   ->orderby('id','desc')
                   ->first();
	 }

 
}
