<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Search\SearchQueryLog;


class NeuroVisit extends Model 
{
	protected $table = 'neuro_visit_details';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	
	protected $fillable = ['baby_id','mrn','visit_date','seen_by','user_added','user_deleted','date_added','date_modified','is_deleted','user_modified','comments','chronological_days','chronological_month','chronological_weeks','chronological_year','corrected_days','corrected_month','corrected_weeks','corrected_year','current_weight_g','review_time','review_min','review_session','total_chronological_weeks','total_chronological_days','total_corrected_weeks','total_corrected_days','baby_background','hospital_name', 'deleted_date_time', 'mental_development_age', 'mental_development_quotient', 'motor_development_age', 'motor_development_quotient', 'clusters', 'recommendation', 'tone_type', 'others', 'review', 'review_time', 'review_min', 'review_session', 'baby_behavior', 'hnne_interpretation', 'hine_interpretation', 'm_chat_r_interpretation', 'm_chat_followup_interpretation', 'dasii_interpretation', 'ddst_interpretation', 'head_circumference', 'current_ofc', 'current_length', 'ddst_interpretation_status', 'hnne_interpretation_others', 'hine_interpretation_others', 'm_chat_r_interpretation_others', 'm_chat_followup_interpretation_others', 'dasii_interpretation_others', 'ddst_interpretation_others', 'fee_status', 'fee_amount', 'mental_prior_pass', 'mental_rest_fail', 'motor_prior_pass', 'motor_rest_fail', 'motor_cluster_1', 'motor_cluster_2', 'motor_cluster_3', 'motor_cluster_4', 'motor_cluster_5', 'mental_cluster_1', 'mental_cluster_2', 'mental_cluster_3', 'mental_cluster_4', 'mental_cluster_5', 'mental_cluster_6', 'mental_cluster_7', 'mental_cluster_8', 'mental_cluster_9', 'mental_cluster_10', 'mental_cluster_pr_1', 'mental_cluster_pr_2', 'mental_cluster_pr_3', 'mental_cluster_pr_4', 'mental_cluster_pr_5', 'mental_cluster_pr_6', 'mental_cluster_pr_7', 'mental_cluster_pr_8', 'mental_cluster_pr_9', 'mental_cluster_pr_10', 'motor_cluster_pr_1', 'motor_cluster_pr_2', 'motor_cluster_pr_3', 'motor_cluster_pr_4', 'motor_cluster_pr_5', 'mental_cluster_remarks_1', 'mental_cluster_remarks_2', 'mental_cluster_remarks_3', 'mental_cluster_remarks_4', 'mental_cluster_remarks_5', 'mental_cluster_remarks_6', 'mental_cluster_remarks_7', 'mental_cluster_remarks_8', 'mental_cluster_remarks_9', 'mental_cluster_remarks_10', 'motor_cluster_remarks_1', 'motor_cluster_remarks_2', 'motor_cluster_remarks_3', 'motor_cluster_remarks_4', 'motor_cluster_remarks_5', 'cluster_range', 'mental_cluster_interpretation', 'motor_cluster_interpretation', 'ddst_gross_motor_interpretation_status', 'ddst_language_interpretation_status', 'ddst_fine_motor_interpretation_status', 'ddst_personal_interpretation_status', 'affective_problem', 'anxiety_problem', 'pervasive_developmental_problem', 'attention_deficit_hyperactivity_problem', 'oppositional_defiant_problem', 'cbcl_interpretation', 'cbcl_interpretation_status', 'visit_time', 'visit_min', 'visit_session', 'confidential_background_details', 'others_asymmetric', 'no_fee_reason', 'referral_status', 'referral_reason', 'visit_number', 'visit_from', 'reason_referral', 'examiner', 'caregiver_name', 'relationship_to_child', 'other_relationship', 'diagnosis', 'contact_no', 'home_program', 'cars', 'primary_caregiver_education', 'hour_of_intervention', 'caregiver_assessment'];
	
	public static function getNeuroEligibilityData($id)
	{
		$result = DB::table('neuro_eligibility')
		->select('*', 'id as neuro_eligibility_id')
		->where('op_id', $id)
		->orderBy('id', 'desc')
		->first();

		return $result;
	}

	public static function get_lists($page = 1, $limit = 50, $condition = array(), $order = array(), $slug = '')
	{
		$limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
		$limitend   = $limit;
		$search_txt = isset($condition['search_txt']) ? $condition['search_txt'] : '';
		$results = \DB::table('neuro_visit_details')
					->Select('DOB', 'BMrNo', 'BabyName', 'id', 'baby.BabyId', 'visit_date')
					->join('baby', 'baby.BabyId', '=', 'neuro_visit_details.baby_id')
					->where(function ($query) use ($search_txt) {
						if ($search_txt) {

							if (empty(preg_replace('/[0-9]/', '', trim($search_txt)))) {
								$query->where('baby.BMrNo', '=', $search_txt);

							} elseif (empty(preg_replace('/[0-9,-]/', '', trim($search_txt)))) {  
								$query->whereDate('baby.DOB', '=', date('Y-m-d', strtotime($search_txt)));

							} else {
								$query->where('baby.BabyName', 'ilike', '%'.$search_txt.'%');
							}
						}
					})
					->where('is_deleted', 0)
					->whereNotNull('id')
					->where('IsDeleted', '0')
					->orderBy($order['sortby'], $order['sortorder']);
		if ($slug) {
			$result_set = $results->get()->toArray();
	        $result['total'] = count($result_set);  
	        $result['result'] = array_slice($result_set, $limitstart, $limitend);  
		} else {
			$result = $results->limit($limitend)->offset($limitstart)->get();
		}
		return $result;
	}


	/**
	*To get op list count 
	*
	*@param $baby_id integer
	*@return op list count in integer
	*/

	public static function GetTotal() 
	{

		return  self::join('baby', 'neuro_visit_details.baby_id', '=', 'baby.BabyId')
		->where('neuro_visit_details.is_deleted', 0)
		->get()->unique('BabyId')->count();

	}

	/**
	*To get op visit list based on baby id 
	*
	*@param $baby_id integer
	*@return op list in array of objects
	*/
	public static function GetNeuroVisitList($baby_id) 
	{

		return self::select('baby.BabyName', 'baby.BMrNo', 'neuro_visit_details.visit_date', 'neuro_visit_details.id', 'neuro_visit_details.seen_by', 'current_weight_g', 'current_ofc', 'current_length', 'visit_number')
   			->addSelect(\DB::raw("'neuro' as type"))
			->join('baby', 'neuro_visit_details.baby_id', '=', 'baby.BabyId')
			->where(['neuro_visit_details.is_deleted'=>0,'neuro_visit_details.baby_id'=>$baby_id])
			->orderBy('neuro_visit_details.id', 'desc')
			->get();


	}

	/**
	*To get op visit list based on baby id 
	*
	*@param $baby_id integer
	*@return op list in array of objects
	*/
	public static function getVisitList($baby_id) 
	{
		return self::join('baby', 'neuro_visit_details.baby_id', '=', 'baby.BabyId')
               ->where(['neuro_visit_details.is_deleted'=>0,'neuro_visit_details.baby_id'=>$baby_id])
               ->orderBy('neuro_visit_details.id', 'desc')
               ->get();

	}

	/**
	*To get op visit list based on baby id 
	*
	*@param $baby_id integer
	*@return op list in array of objects
	*/
	public static function getVisit($id) 
	{
		return self::select('*', 'neuro_visit_details.id as visit_id')
			   ->join('baby', 'neuro_visit_details.baby_id', '=', 'baby.BabyId')
			   ->join('mother', 'baby.MotherId', '=', 'mother.MotherId')
               ->where(['neuro_visit_details.is_deleted'=>0,'neuro_visit_details.id'=>$id])
               ->first();


	}

	/**
	*To get baby's background details from latest op details 
	*
	*@param $baby_id integer
	*@return op list in array of objects
	*/
	public static function getBabyBackgroundDetails($baby_id) 
	{
		$last_op_visit = \DB::table('op_details')->select('baby_background')->where('BabyId', $baby_id)->where('IsDeleted', 0)->orderBy('OpDate', 'desc')->first();
		if (isset($last_op_visit->baby_background) && $last_op_visit->baby_background != '') {
			return $last_op_visit->baby_background;
		}
		else
		{
			$baby_background = \DB::table('baby')->select('Background')->where('BabyId', $baby_id)->where('IsDeleted', 0)->first();
			if (isset($baby_background->Background) && $baby_background->Background != '') {
				return $baby_background->Background;
			}
			else
			{
				return '';
			}
		}
	}

	/**
	 * This Method to get baby weight, height and head circumference
	 * 
	 * @param $baby_mrn
	 * 
	 * @param $visit_date
	 *
	 * @return array of objects
	 */
	public static function getTodayPhysicalDetails($baby_mrn, $visit_date)
	{
		return self::select('current_weight_g', 'current_ofc', 'current_length')
            ->where('mrn', $baby_mrn)
            ->where('visit_date', $visit_date)
            ->orderBy('id', 'desc')
            ->first();
	}
}
