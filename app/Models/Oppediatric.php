<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Search\SearchQueryLog;


class Oppediatric extends Model 
{
	protected $table = 'op_pediatric_details';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	
	protected $fillable = ['baby_id', 'mother_id', 'op_date', 'op_hours', 'op_mins', 'op_session', 'current_weight', 'current_ofc', 'current_length', 'current_bmi', 'hospital_name', 'seen_by', 'review', 'review_days', 'review_time', 'review_min', 'review_session', 'current_status', 'hopi', 'development', 'immunization_content', 'examination', 'impression', 'advice', 'immunization', 'schedule', 'created_by', 'created_date_time', 'modified_by', 'modified_date_time', 'deleted_by', 'is_deleted', 'vaccine', 'age_year', 'age_month', 'age_days', 'visit_number'];

	/** 
	 *get main baby
	 *
	 *@param $page integer
	 *@param $limit integer
	 *@param $condition array
	 *@return array of object 
	 */
	public static function get_lists($page = 1, $limit = 50, $condition = array(), $order = array(), $slug = '')
	{
        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt = isset($condition['search_txt']) ? $condition['search_txt'] : '';         

		$results     = DB::table('op_pediatric_details')
			            ->join('baby', 'op_pediatric_details.baby_id', '=', 'baby.BabyId')
			            ->select('op_pediatric_details.baby_id', 'baby.BabyName', 'baby.BMrNo', 'baby.DOB', 'op_pediatric_details.id','op_pediatric_details.op_date','op_pediatric_details.seen_by')
			            ->where('op_pediatric_details.is_deleted', 0)
			            ->where('baby.IsDeleted', 0)
			            ->where(function ($query) use ($search_txt)
			            {

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
           if (isset($order['sortby']) && isset($order['sortorder'])) {
                $results->orderBy($order['sortby'], $order['sortorder']);  
            }


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

        return  DB::table('op_pediatric_details')
	            ->join('baby', 'op_pediatric_details.baby_id', '=', 'baby.BabyId')
	            ->select('baby.BabyName', 'baby.BMrNo', 'op_pediatric_details.op_date', 'op_pediatric_details.id')
	            ->where('op_pediatric_details.is_deleted', 0)
	            ->get()
	            ->count();

    }

	/**
	*To get op visit list based on baby id 
	*
	*@param $baby_id integer
	*@return op list in array of objects
	*/
	public static function GetOpvisitList($baby_id) 
	{

		return DB::table('op_pediatric_details')
		       ->select('baby.BabyId', 'baby.BabyName', 'baby.BMrNo', 'op_pediatric_details.op_date', 'op_pediatric_details.id', 'op_pediatric_details.seen_by', 'visit_number')
		   	   ->join('baby', 'op_pediatric_details.baby_id', '=', 'baby.BabyId')
               ->where(['op_pediatric_details.is_deleted'=>0,'op_pediatric_details.baby_id'=>$baby_id])
               ->orderBy('op_pediatric_details.id', 'desc')
               ->get();

	}

    /**
	 *To get op record based on op id 
	 *
	 *@param id  integer
	 *@return op record in array of objects
	 */
	public static function  get_oprecord($id) 
	{
		$results = DB::table('op_pediatric_details')
            ->join('baby', 'op_pediatric_details.baby_id', '=', 'baby.BabyId')
            ->where('id', $id)
            ->get();		
		return $results;

	}

	/**
	 *To get op record based on op id 
	 *
	 *@param id  integer
	 *@return op record in array of objects
	 */
	public static function getAllPreviousOp($baby_id) 
	{
		return \DB::table('op_pediatric_details')
				->select('op_date', \DB::raw("(regexp_matches(current_weight, '[0-9]+\.?[0-9]*'))[1]::numeric AS current_weight"), \DB::raw("(regexp_matches(current_length, '[0-9]+\.?[0-9]*'))[1]::numeric AS current_length"), \DB::raw("(regexp_matches(current_ofc, '[0-9]+\.?[0-9]*'))[1]::numeric AS current_ofc"))
                ->where(['is_deleted'=>0, 'baby_id'=>$baby_id])
                ->orderBy('op_date', 'desc')
                ->get();

	}
}
