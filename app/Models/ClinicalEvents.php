<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClinicalEvents extends Model 
{
	protected $table = 'clinical_event_details';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	
	protected $fillable = ['diagnosis', 'other_diagnosis', 'date_of_diagnosis', 'time_of_diagnosis', 'min_of_diagnosis', 'session_of_diagnosis', 'date_of_resolution', 'time_of_resolution', 'min_of_resolution', 'session_of_resolution', 'diagnosis_status', 'comments'];

}