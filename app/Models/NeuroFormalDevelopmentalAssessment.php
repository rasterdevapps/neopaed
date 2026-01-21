<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Search\SearchQueryLog;


class NeuroFormalDevelopmentalAssessment extends Model 
{
	protected $table = 'neuro_formal_developmental_assessment';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	
	protected $fillable = ['baby_id', 'op_id', 'op_date', 'corrected_age_and_due_date', 'formal_developmental_assessment_date', 'formal_developmental_pna_ca_assessment', 'motor_dq_centile', 'mental_dq_centile', 'formal_interpretation', 'created_date_time', 'created_user', 'modified_date_time', 'modified_user', 'is_deleted', 'deleted_date_time', 'deleted_user', 'neuro_visit_id'];


	public static function getFormalDevelopmentalAssessmentData($op_id)
	{
		$result = DB::table('neuro_formal_developmental_assessment')
					->select('*', 'id as neuro_formal_developmental_assessment_id', \DB::raw("to_char(formal_developmental_assessment_date, 'DD-MM-YYYY') formal_developmental_assessment_date"))
					->where('neuro_visit_id', $op_id)
					->orderBy('id', 'asc')
					->get();
		return $result;
	}
}
