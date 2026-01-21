<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DischargeLog extends Model
{
    /**
     *This variable used to bind the table name
     *@var $table type string 
     */
    protected $table = 'discharged_log';

    /**
     *This variable used to bind the table primary key
     *@var $primaryKey type string 
     */
    protected $primaryKey = 'id';

    /**
     *This variable used to bind the table timestamps
     *@var $primaryKey type string 
     */
    public $timestamps  =  false;

    /**
     *This variable used to bind the table fillable column
     *@var $fillable type array  
     */
    protected $fillable = ['baby_id', 'admission_id', 'discharged_at', 'is_backuped', 'backup_time'];

	/**
	 * Method to get discharge patient list
	 *
	 * @return type array list 
	 */
	public static function getDischargeList() {

	  	$results = DischargeLog::whereRaw('discharged_at::date <= current_date - 10')
				  	->distinct('admission_id', 'baby_id')
				  	->select('admission_id', 'baby_id')
	  				->where('is_backuped', false)
					->get();

	  	return $results;

	}

	/**
	 * Method to update discharge patient list
	 *
	 */
	public static function updateDischargeList($updated_discharge_ids) {

	  	DischargeLog::whereIn('admission_id', $updated_discharge_ids)
					  	->update(['is_backuped' => true, 'backup_time' => Carbon::now(env('TIME_ZONE'))]);

	}

	/**
	 * Check patient status
	 *
	 */
	public static function getDischargeDetail($baby_id, $admission_id) {

	  	$results = DischargeLog::where('baby_id', $baby_id)
					  	->where('admission_id', $admission_id)
					  	->where('is_backuped', 1)
					  	->get()
					  	->toArray();
		return $results;

	}

}
