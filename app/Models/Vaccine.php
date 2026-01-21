<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vaccine extends Model 
{
	protected $table = 'discharge_vaccine';
	protected $primaryKey = 'BabyId';
	public $timestamps  =  false;
	
	protected $fillable = ['AdmissionId','BabyId','Vaccine','VaccineDate'];
}
