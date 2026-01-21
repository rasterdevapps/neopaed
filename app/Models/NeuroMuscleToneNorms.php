<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Search\SearchQueryLog;


class NeuroMuscleToneNorms extends Model 
{
	protected $table = 'neuro_muscle_tone_norms';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	
	protected $fillable = ['baby_id', 'neuro_visit_id', 'visit_date', 'age', 'date_of_assessment_0_3', 'pna_ca_assessment_0_3', 'adductor_as_assessed_left_0_3', 'adductor_as_assessed_right_0_3', 'popliteal_as_assessed_left_0_3', 'popliteal_as_assessed_right_0_3', 'dorsiflexion_as_assessed_left_0_3', 'dorsiflexion_as_assessed_right_0_3', 'elbow_not_cross_midline_left_0_3', 'elbow_not_cross_midline_right_0_3', 'elbow_cross_midline_left_0_3', 'elbow_cross_midline_right_0_3', 'elbow_goes_beyond_axillary_line_left_0_3', 'elbow_goes_beyond_axillary_line_right_0_3', 'date_of_assessment_4_6', 'pna_ca_assessment_4_6', 'adductor_as_assessed_left_4_6', 'adductor_as_assessed_right_4_6', 'popliteal_as_assessed_left_4_6', 'popliteal_as_assessed_right_4_6', 'dorsiflexion_as_assessed_left_4_6', 'dorsiflexion_as_assessed_right_4_6', 'elbow_not_cross_midline_left_4_6', 'elbow_not_cross_midline_right_4_6', 'elbow_cross_midline_left_4_6', 'elbow_cross_midline_right_4_6', 'elbow_goes_beyond_axillary_line_left_4_6', 'elbow_goes_beyond_axillary_line_right_4_6', 'date_of_assessment_7_9', 'pna_ca_assessment_7_9', 'adductor_as_assessed_left_7_9', 'adductor_as_assessed_right_7_9', 'popliteal_as_assessed_left_7_9', 'popliteal_as_assessed_right_7_9', 'dorsiflexion_as_assessed_left_7_9', 'dorsiflexion_as_assessed_right_7_9', 'elbow_not_cross_midline_left_7_9', 'elbow_not_cross_midline_right_7_9', 'elbow_cross_midline_left_7_9', 'elbow_cross_midline_right_7_9', 'elbow_goes_beyond_axillary_line_left_7_9', 'elbow_goes_beyond_axillary_line_right_7_9', 'date_of_assessment_10_12', 'pna_ca_assessment_10_12', 'adductor_as_assessed_left_10_12', 'adductor_as_assessed_right_10_12', 'popliteal_as_assessed_left_10_12', 'popliteal_as_assessed_right_10_12', 'dorsiflexion_as_assessed_left_10_12', 'dorsiflexion_as_assessed_right_10_12', 'elbow_not_cross_midline_left_10_12', 'elbow_not_cross_midline_right_10_12', 'elbow_cross_midline_left_10_12', 'elbow_cross_midline_right_10_12', 'elbow_goes_beyond_axillary_line_left_10_12', 'elbow_goes_beyond_axillary_line_right_10_12', 'created_date_time', 'created_user', 'modified_date_time', 'modified_user', 'is_deleted', 'deleted_date_time', 'deleted_user'];


	public static function getNeuroMuscleToneNormsData($op_id)
	{
		$result = DB::table('neuro_muscle_tone_norms')
					->select('*', 'id as neuro_muscle_tone_norms_id', \DB::raw("to_char(date_of_assessment_0_3, 'DD-MM-YYYY') date_of_assessment_0_3"), \DB::raw("to_char(date_of_assessment_4_6, 'DD-MM-YYYY') date_of_assessment_4_6"), \DB::raw("to_char(date_of_assessment_7_9, 'DD-MM-YYYY') date_of_assessment_7_9"), \DB::raw("to_char(date_of_assessment_10_12, 'DD-MM-YYYY') date_of_assessment_10_12"))
					->where('neuro_visit_id', $op_id)
					->orderBy('id', 'asc')
					->first();
		return $result;
	}
}
