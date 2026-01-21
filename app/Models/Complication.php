<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Complication extends Model 
{
	protected $table = 'complications';
	protected $primaryKey = 'Id';
	public $timestamps  =  false;
	protected $fillable = ['AdmissionId','BabyId','Complication','duration_in_weeks','Treatment','flags','duration_unit'];
   
    /**
     * Method to get list of complication
     *
     * @param $admission_id type integer
     * @param $baby_id type integer
     * @return complication list based on babyid and admissionid in array of object
     */
    public static function GetList($baby_id) 
    {
    	return \DB::table('complications')
                   ->where('BabyId', $baby_id)
                   ->get(); 
    }
    
}
