<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Search\SearchQueryLog;


class NeuroScreening extends Model 
{
	protected $table = 'neuro_screening';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	
	protected $fillable = ['baby_id', 'op_date', 'basic_screening', 'rop_date', 'rop_pna_ca', 'rop_right_hand_side', 'rop_left_hand_side', 'rop_remarks', 'hearing_screen_options', 'hearing_screen_aabr_date', 'hearing_screen_aabr_pna_ca', 'hearing_screen_aabr_right_hand_side', 'hearing_screen_aabr_left_hand_side', 'hearing_screen_aabr_remarks', 'hearing_screen_oae_date', 'hearing_screen_oae_pna_ca', 'hearing_screen_oae_right_hand_side', 'hearing_screen_oae_left_hand_side', 'hearing_screen_oae_remarks', 'diagnostic_abr_options', 'diagnostic_abr_date', 'diagnostic_abr_pna_ca', 'diagnostic_abr_right_hand_side', 'diagnostic_abr_left_hand_side', 'diagnostic_abr_remarks', 'diagnostic_cpa_date', 'diagnostic_cpa_pna_ca', 'diagnostic_cpa_right_hand_side', 'diagnostic_cpa_left_hand_side', 'diagnostic_cpa_remarks', 'created_date_time', 'created_user', 'modified_date_time', 'modified_user', 'is_deleted', 'deleted_date_time', 'deleted_user', 'neuro_visit_id', 'ct_imperssion', 'usg_imperssion', 'mri_imperssion', 'ct_age', 'usg_age', 'mri_age', 'ct_date', 'usg_date', 'mri_date', 'head_test', 'rop_options'];


	public static function getNeuroScreeningData($op_id)
	{
		$result = DB::table('neuro_screening')
					->select('*', 'id as neuro_screening_id', \DB::raw('(CASE WHEN char_length(rop_date::text) > 0 THEN to_char(rop_date, \'DD-MM-YYYY\') END) AS rop_date'), \DB::raw('(CASE WHEN char_length(hearing_screen_aabr_date::text) > 0 THEN to_char(hearing_screen_aabr_date, \'DD-MM-YYYY\') END) AS hearing_screen_aabr_date'), \DB::raw('(CASE WHEN char_length(hearing_screen_oae_date::text) > 0 THEN to_char(hearing_screen_oae_date, \'DD-MM-YYYY\') END) AS hearing_screen_oae_date'), \DB::raw('(CASE WHEN char_length(diagnostic_abr_date::text) > 0 THEN to_char(diagnostic_abr_date, \'DD-MM-YYYY\') END) AS diagnostic_abr_date'), \DB::raw('(CASE WHEN char_length(diagnostic_cpa_date::text) > 0 THEN to_char(diagnostic_cpa_date, \'DD-MM-YYYY\') END) AS diagnostic_cpa_date'), \DB::raw('(CASE WHEN char_length(ct_date::text) > 0 THEN to_char(ct_date, \'DD-MM-YYYY\') END) AS ct_date'), \DB::raw('(CASE WHEN char_length(usg_date::text) > 0 THEN to_char(usg_date, \'DD-MM-YYYY\') END) AS usg_date'), \DB::raw('(CASE WHEN char_length(mri_date::text) > 0 THEN to_char(mri_date, \'DD-MM-YYYY\') END) AS mri_date'))
					->where('neuro_visit_id', $op_id)
					->where('is_deleted', false)
					->orderBy('id', 'asc')
					->first();
		return $result;
	}

	public static function getPreviousScreeningDetails($baby_id, $op_id = '', $slug = false)
	{
		$result = self::select('*')
			->selectRaw('CASE WHEN char_length(rop_date::text) > 0 THEN to_char(rop_date, \'DD-MM-YYYY\') ELSE \'DD-MM-YYYY\' END AS rop_date')
			->selectRaw('CASE WHEN char_length(hearing_screen_aabr_date::text) > 0 THEN to_char(hearing_screen_aabr_date, \'DD-MM-YYYY\') ELSE \'DD-MM-YYYY\' END AS hearing_screen_aabr_date')
			->selectRaw('CASE WHEN char_length(hearing_screen_oae_date::text) > 0 THEN to_char(hearing_screen_oae_date, \'DD-MM-YYYY\') ELSE \'DD-MM-YYYY\' END AS hearing_screen_oae_date')
			->selectRaw('CASE WHEN char_length(diagnostic_abr_date::text) > 0 THEN to_char(diagnostic_abr_date, \'DD-MM-YYYY\') ELSE \'DD-MM-YYYY\' END AS diagnostic_abr_date')
			->selectRaw('CASE WHEN char_length(diagnostic_cpa_date::text) > 0 THEN to_char(diagnostic_cpa_date, \'DD-MM-YYYY\') ELSE \'DD-MM-YYYY\' END AS diagnostic_cpa_date')
			->selectRaw('CASE WHEN char_length(ct_date::text) > 0 THEN to_char(ct_date, \'DD-MM-YYYY\') ELSE \'DD-MM-YYYY\' END AS ct_date')
			->selectRaw('CASE WHEN char_length(usg_date::text) > 0 THEN to_char(usg_date, \'DD-MM-YYYY\') ELSE \'DD-MM-YYYY\' END AS usg_date')
			->selectRaw('CASE WHEN char_length(mri_date::text) > 0 THEN to_char(mri_date, \'DD-MM-YYYY\') ELSE \'DD-MM-YYYY\' END AS mri_date')
			->selectRaw('CASE WHEN hearing_screen_aabr_right_hand_side = \'1\' THEN \'Pass\' WHEN hearing_screen_aabr_right_hand_side = \'2\' THEN \'Refer\' END AS hearing_screen_aabr_right_hand_side')
			->selectRaw('CASE WHEN hearing_screen_aabr_left_hand_side = \'1\' THEN \'Pass\' WHEN hearing_screen_aabr_left_hand_side = \'2\' THEN \'Refer\' END AS hearing_screen_aabr_left_hand_side')
			->selectRaw('CASE WHEN hearing_screen_oae_right_hand_side = \'1\' THEN \'Pass\' WHEN hearing_screen_oae_right_hand_side = \'2\' THEN \'Refer\' END AS hearing_screen_oae_right_hand_side')
			->selectRaw('CASE WHEN hearing_screen_oae_left_hand_side = \'1\' THEN \'Pass\' WHEN hearing_screen_oae_left_hand_side = \'2\' THEN \'Refer\' END AS hearing_screen_oae_left_hand_side')
			->selectRaw('CASE WHEN diagnostic_cpa_right_hand_side = \'1\' THEN \'Pass\' WHEN diagnostic_cpa_right_hand_side = \'2\' THEN \'Refer\' END AS diagnostic_cpa_right_hand_side')
			->selectRaw('CASE WHEN diagnostic_cpa_left_hand_side = \'1\' THEN \'Pass\' WHEN diagnostic_cpa_left_hand_side = \'2\' THEN \'Refer\' END AS diagnostic_cpa_left_hand_side');
		if ($op_id != '' && $slug == true) {
			$result = $result->where('neuro_visit_id', '<=', $op_id);
		} elseif ($op_id != '') {			
			$result = $result->where('neuro_visit_id', '<', $op_id);
		}
		$result = $result->where('is_deleted', false)->where('baby_id', $baby_id)
			->orderBy('id', 'desc')
			->get();
			
		return $result;
	}
}
