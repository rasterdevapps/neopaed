<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Problems extends Model 
{
	protected $table = 'medical_problems';
	protected $primaryKey = 'Id';
	public $timestamps  =  false;
	
	protected $fillable = ['MotherId','BabyId','Problem','Medication','AdmissionId'];

	public static function getProblems($baby_id)
	{
		return DB::table('medical_problems')
			        ->select('Medication', 'Problem')
			        ->where('BabyId', '=', $baby_id)
			        ->get();
	}

}
