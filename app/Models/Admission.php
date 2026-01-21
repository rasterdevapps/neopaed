<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
	Model handles the baby_admission table options.
*/
class Admission extends Model 
{
	protected $table = 'baby_admission';
	protected $primaryKey = 'AdmissionId';
	public $timestamps  =  false;
	protected $fillable = ['BMrNo','MotherId','BabyId','AdmissionDate','AdmissionTime','InOrOut','AdmissionType','Status','UserAdded','DateAdded','DateModified','episodes'];
    
    /**
     * This method to get baby admissionid 
     * 
     * @param $baby_id type integer
     *
     * @return array of objects
     */
	public static function get_baby_lists($baby_id)
	{
		return \DB::table('baby_admission')
		       ->select('AdmissionId')
		       ->where('BabyId', $baby_id)
		       ->orderby('AdmissionId', 'desc')
		       ->first();

	}

	/**
     * This method to get list data
     * 
     * @param $baby_id type integer
     *
     * @return array of objects
     */
	public static function get_existing_admission($baby_id)
	{
		return DB::table('baby_admission')
                 ->join('nicu_admission', 'nicu_admission.BabyId', '=', 'baby_admission.BabyId')
			      ->where('baby_admission.BabyId', $baby_id)
			      ->where('nicu_admission.status','Inpatient')
			      ->orderby('nicu_admission.AdmissionId', 'desc')
			      ->first();
		// return $result;	      
	}

    /*
	 * Method to get the mrn number
     */

    public static function getBabyMrn($admission_id) {
    	$result = DB::table('baby_admission')
    	 				->select('baby_admission.*','baby.*')
    	 				->join('baby', 'baby.BabyId' , '=', 'baby_admission.BabyId')
    	 				// ->join('neonatal_proforma', 'neonatal_proforma.BabyId' , '=', 'baby_admission.BabyId')
			          	->where('baby_admission.AdmissionId', $admission_id)
			          	->orderBy('baby_admission.AdmissionId', 'desc')
			          	->first();
		return $result;

    }

	//KS
	public static function getBabyAdmission($admission_id, $baby_id) 
    {

    	 return DB::table('baby_admission')
			    	  ->where('AdmissionId', '=', $admission_id)
			          ->where('BabyId', '=', $baby_id)
			          ->orderBy('AdmissionId', 'desc')
			          ->first();

    }

    //KS
	public static function getBaby($baby_id) 
    {

    	 return DB::table('baby_admission')
    	 			  ->select('*')
			          ->where('BabyId', '=', $baby_id)
			          ->orderBy('AdmissionId', 'desc')
			          ->first();

    }

    /**
     * This method to get baby admissionid 
     * 
     * @param $baby_id type integer
     *
     * @return array of objects
     */
	public static function get_baby_list($baby_id, $mother_id)
	{
		return DB::table('baby_admission')
		       ->select('AdmissionId')
		       ->where('BabyId', $baby_id)
		       ->where('MotherId', $mother_id)
		       ->orderby('AdmissionId', 'desc')
		       ->first();

	}
}
