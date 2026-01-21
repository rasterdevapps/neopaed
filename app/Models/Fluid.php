<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Fluid extends Model 
{
	protected $table = 'blood_products';
	protected $primaryKey = 'DayId';
	public $timestamps  =  false;
	
	protected $fillable = ['DayId','BabyId','Product','Volume','AdmissionId'];

	public static function GetRecordList($baby_id, $day_id) 
	{

		return DB::table('blood_products')
		       ->where(['BabyId'=>$baby_id,'DayId'=>$day_id])
		       ->get()->toArray();

	}

}
