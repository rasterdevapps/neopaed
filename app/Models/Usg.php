<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Usg extends Model 
{
	protected $table      = 'usg_finding';
	protected $primaryKey = 'MotherId';
	public $timestamps    =  false;
	protected $fillable   = ['MotherId','BabyId','Finding','Gestation','Doppler','flags','type', 'date'];

	/**
	 * Fields describtion
	 *
	 * @param  flags 1 => neonatal performa 2 => Nicu admission  
	 */

	/**
	 * Method to get ultra scan findings by baby and mother id 
	 *
	 * @param $baby_id type integer
	 * @param $mother_id type integer 
     * @return ultra sound list in array of object
	 */
	public static function GetList($baby_id, $mother_id)
	{
		return \DB::table('usg_finding')
		           ->where('BabyId', $baby_id)
		           ->where('MotherId', $mother_id)
		            ->get();
	}



	

}
