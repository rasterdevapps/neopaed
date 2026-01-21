<?php

namespace App\Models\Calender;

use Illuminate\Database\Eloquent\Model;

class AppointmentDetail extends Model
{
   /** 
    * This table name appoinment_details 
    *
	* @var $table 
	*/
    protected $table = 'appointment_details';

   /** 
    * This primarykey id 
    *
	* @var $primaryKey primaryKey  
	*/
	protected $primaryKey = 'id';

   /** 
    * This timestamps column on timestamps 
    *
	* @var $timestamps timestamps  
	*/
	public $timestamps  =  false;

   /** 
    * This fillable column on fillable 
    *
	* @var $fillable array   
	*/
	protected $fillable = ['category', 'appointment_date', 'appointment_time', 'appointment_min', 'appointment_session', 'seen_by', 'baby_id', 'baby_name', 'reason', 'modified_appointment_date', 'modified_appointment_time', 'modified_appointment_min',  'modified_appointment_session', 'ref_id', 'module_id', 'created_date_time', 'created_user_id', 'modified_date_time', 'modified_user_id', 'is_cancel'];

   /** 
    * This fillable column on fillable 
    *
	* @var $userId integer id    
	*/
	public static function userFilter($start_at, $end_at) 
	{
		$results = self::select('appointment_details.*')
            	->selectRaw('"BabyName"|| \' - \' ||"BMrNo" as baby_name_mrn')
            	->leftJoin('baby', \DB::raw('CAST("BabyId" AS INTEGER)'), 'baby_id')
					->where(function($query) use ($start_at, $end_at) {
                		$query->orWhereBetween('appointment_date', [$start_at, $end_at]);
                		$query->orWhereBetween('modified_appointment_date', [$start_at, $end_at]);
            	})
					->where('is_cancel', 0)
            	->get();		
		return $results;
	}

	/** 
    * This method to get all appointments 
    *
	*/
	public static function user() {
		$results = self::select('*')
            		->get();	
		return $results;
	}

	/** 
    * This method to get the op patients
    *
	* @param $id 
	*/
	public static function getOpRef($id) {
		$results = self::select('id')
						->where('ref_id', $id)
            		->first();	
		return $results;
	}

	/** 
    * This method to get the check existing appointment
    *
	* @param $id 
	*/
	public static function checkAppointment($ref_id, $module_id = 0, $seen_by = 0) {
		$results = self::select('id')
					->where('ref_id', $ref_id)
					->where('module_id', $module_id)
					->where(function($query) use ($seen_by) {
						if ($seen_by != 0) {
                		$query->where('seen_by', $seen_by);
                	}
            	})
					->orderBy('id', 'desc')
            	->first();	
		return $results;
	}

  /**
  * This will get the baby phone numbers.
  *
  * @param $mrn 
  *
  * @return array of object 
  */
  public static function getContactDetails($baby_id)
  {
    return \DB::table('mother')
              ->select('Mobile', 'LandLine', 'PartnerContact', 'PartnerMobile')
              ->leftJoin('baby', 'mother.MotherId', 'baby.MotherId')
              ->where('BabyId', $baby_id)
              ->first();    
  }

   /** 
    * Get appointment details
    *
	* @var $userId integer id    
	*/
	public static function getAppDetails($id) 
	{
		$results = self::select('appointment_details.*', 'Mobile', 'LandLine', 'PartnerContact', 'PartnerMobile')
            	->selectRaw('"BabyName"|| \' - \' ||"BMrNo" as baby_name_mrn')
            	->selectRaw('CASE WHEN length("Qualification") > 0 THEN "Name" || \', \' || "Qualification" ELSE "Name" END as name_qualification')
            	->leftJoin('baby', \DB::raw('CAST("BabyId" AS INTEGER)'), 'baby_id')
              	->leftJoin('mother', 'baby.MotherId', 'mother.MotherId')
            	->leftJoin('mas_doctors', 'seen_by', 'mas_doctors.id')
					->where('is_cancel', 0)
					->where('appointment_details.id', $id)
            	->first();

            if (isset($results->baby_name_mrn)) {
            	$results = $results->toArray();		
            } else {
            	$results = [];
            }
		return $results;
	}


}
