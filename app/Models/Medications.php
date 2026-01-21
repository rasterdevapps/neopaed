<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Medications extends Model 
{
   /**
	* Used for table name
	*
	* @var $table type string 
	*/
	protected $table = 'discharge_medications';

	/**
	* Define primary key
	*
	* @var $primaryKey type string 
	*/
	protected $primaryKey = 'Id';

	/**
	 * Define timestamps to table
	 *
	 * @var $timestamps type boolean
	 */
	public $timestamps  =  false;

	/**
	 * Define fillable colmuns for table 
	 *
	 * @var $fillable type array 
	 */
	protected $fillable = ['AdmissionId','BabyId','Dose','route','Medication','Frequency','Duration','genericname','formulation','flag','source_id', 'standard_dose', 'additional_instruction'];
    
    /**
     *This Method to get medicine list based on parameter
     *
     * @param $BabyId type integer
     * 
     * @param $flage type integer
     */
	public static function get_medicines_lists($BabyId, $flag = 1)
	{
		return \DB::table('discharge_medications')
		        ->where('BabyId', $BabyId)
		        ->where('flag', $flag)
		        ->get()
		        ->toArray();
	}

   /**
	* This Method to get medicine based on admission list
	* @param $baby_id type integer
	* @param $admissionid type integer
	* @param $flag type integer
	*/
	public static function get_medicines_details($baby_id, $admissionid, $flag)
	{
		return \DB::table('discharge_medications')
		        ->where('BabyId', $baby_id)
		        ->where('AdmissionId', $admissionid)
		        ->where('flag', $flag)
		        ->get()
		        ->toArray();

	}

    /**
     *This Method to get medicine list based on parameter
     *
     * @param $flag type integer
     */
	public static function get_existing_medication_list($flag)
	{
		return \DB::table('discharge_medications')
		        ->select('Medication', 'Dose', 'Frequency', 'Duration', 'genericname', 'formulation', 'route')
		        ->distinct('Medication', 'Dose', 'Frequency', 'Duration', 'genericname', 'formulation', 'route')
		        ->where('flag', $flag)
		        ->get()
		        ->toArray();
	}


	


}
