<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Search\SearchQueryLog;


class NeuroEligibility extends Model 
{
	protected $table = 'neuro_eligibility';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	
	protected $fillable = ['op_id', 'baby_id', 'op_date', 'birth_weight_gestation_is_lesser', 'birth_weight_gestation_is_greater', 'intrauterine_growth', 'meningitis', 'mechanical_ventilation', 'encephalopathy_stage_2_more', 'major_malformation', 'inborn_errors', 'symptomatic_hypoglycemia', 'symptomatic_polycythemia', 'retrovirus_positive_mother', 'hyperbilirubinemia_transfusion_rh', 'abnormal_neuro_exam', 'major_morbidities', 'other_specify', 'other_specify_is_present', 'created_date_time', 'created_user', 'modified_date_time', 'modified_user', 'is_deleted', 'deleted_date_time', 'deleted_user', 'neuro_visit_id', 'general_checkup', 'op_type'];

	public static function getNeuroEligibilityData($id)
	{
		$result = DB::table('neuro_eligibility')
		->select('*', 'id as neuro_eligibility_id')
		->where('neuro_visit_id', $id)
		->orderBy('id', 'desc')
		->first();
		return $result;
	}

	public static function get_lists($page = 1, $limit = 50, $condition = array(), $order = array(), $slug = '')
	{
		$limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
		$limitend   = $limit;
		$search_txt = isset($condition['search_txt']) ? $condition['search_txt'] : '';         

		$results     = \DB::table('baby')
		->whereIn('baby.BabyId', function ($query) use ($order) {
			$query->from('neuro_eligibility')
			->select('baby_id')
			->whereNotNull('op_id')
			->where('neuro_eligibility.is_deleted', 0);
			if (isset($order['sortby']) && isset($order['sortorder'])) {
				$query->orderBy($order['sortby'], $order['sortorder']);  
			}
			$query->get()
			->toArray();
		})
		->where('baby.IsDeleted', 0)
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
		});

		if ($slug) {
			$result['total']  = $results->get()->count();  
			$result['result'] = $results->limit($limitend)->offset($limitstart)->get();
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

		return  self::join('baby', 'neuro_eligibility.baby_id', '=', 'baby.BabyId')
		->where('neuro_eligibility.is_deleted', 0)
		->get()
		->count();

	}

	/**
	*To get op visit list based on baby id 
	*
	*@param $baby_id integer
	*@return op list in array of objects
	*/
	public static function GetNeuroVisitList($baby_id) 
	{

		return self::join('baby', 'neuro_eligibility.baby_id', '=', 'baby.BabyId')
		->where(['neuro_eligibility.is_deleted'=>0,'neuro_eligibility.baby_id'=>$baby_id])
		->orderBy('neuro_eligibility.id', 'desc')
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
		return self::join('baby', 'neuro_eligibility.baby_id', '=', 'baby.BabyId')
               ->where(['neuro_eligibility.is_deleted'=>0,'neuro_eligibility.baby_id'=>$baby_id])
               ->orderBy('neuro_eligibility.id', 'desc')
               ->get();


	}

	public static function getPreviousDetails($mrn)
	{
		$result = self::select('neuro_eligibility.*')
			->leftjoin('baby', 'baby_id', 'BabyId')
			->where('BMrNo', $mrn)
			->where('is_deleted', false)
			->orderBy('id', 'desc')
			->first();
			
		return $result;
	}
}
