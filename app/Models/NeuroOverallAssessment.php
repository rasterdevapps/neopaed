<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Search\SearchQueryLog;


class NeuroOverallAssessment extends Model 
{
	protected $table = 'neuro_over_all_assessment';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	
	protected $fillable = ['baby_id', 'op_id', 'op_date', 'overall_assessement_date', 'ca', 'tone', 'developmental_age', 'head_percentile_sutures', 'seizures_is_present', 'involuntary_movements_is_present', 'vision', 'hearing', 'other_problems', 'interpretation_advice', 'created_date_time', 'created_user', 'modified_date_time', 'modified_user', 'is_deleted', 'deleted_date_time', 'deleted_user', 'motor_dq_centile', 'mental_dq_centile', 'formal_interpretation'];


	public static function getNeuroOverallAssessmentData($op_id)
	{
		$result = DB::table('neuro_over_all_assessment')
					->select('*', 'id as neuro_over_all_assessment_id', \DB::raw("to_char(overall_assessement_date, 'DD-MM-YYYY') overall_assessement_date"))
					->where('op_id', $op_id)
					->orderBy('id', 'asc')
					->get();
		return $result;
	}
}
