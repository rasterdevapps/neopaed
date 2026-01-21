<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cardio extends Model 
{
	protected $table = 'echo_cardio';
	protected $primaryKey = 'EchoId';
	public $timestamps  =  false;
	
	protected $fillable = ['AdmissionId','BabyId','Findings','Impression','Outcome','TestDate','Age','SeenBy','UserAdded','UserModified','DateAdded','DateModified','UserDeleted','IsDeleted','age_year','age_month','age_days'];

	/*
	*	GET NON DELETED RECORDS FOR LISTING
	*/
	public static function  get_lists($page=1, $limit=50, $condition='', $order=array()) 
	{

        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend = $limit;

        $search_txt    =  isset($condition) ? trim($condition) : '';
        $contact_check = is_numeric($search_txt) ? $search_txt : '';
        $checkdate     ='';
        if (strpos($search_txt, '-') > 0) {
              $get_date      = strtotime($search_txt);
              $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
              $search_txt    = '';
        }

		$results = DB::table('echo_cardio')
            ->join('baby', 'echo_cardio.BabyId', '=', 'baby.BabyId')
            ->select('baby.BabyName', 'baby.BMrNo', 'baby.DOB', 'echo_cardio.TestDate', 'echo_cardio.EchoId', 'echo_cardio.Outcome')
            ->where('echo_cardio.IsDeleted', 0)
            ->where(function ($query) use ($search_txt, $checkdate)
            {
                if ($search_txt) {
                    $query->orWhere('baby.BabyName', 'ilike', '%'.trim($search_txt).'%');
                    $query->orWhere('baby.BMrNo', trim($search_txt));
                    $query->orWhere('Outcome', 'ilike', '%'.trim($search_txt).'%');
                } elseif ($checkdate) {
                    $query->orWhereRaw('"baby"."DOB"::date='.$checkdate);
                    $query->orWhereRaw('"echo_cardio"."TestDate"::date='.$checkdate);
                }


            });

            if (isset($order['sortby']) && isset($order['sortorder'])) {
            	$results->orderBy($order['sortby'], $order['sortorder']);	
            }

        $result['total']  = $results->get()->count();  
        $result['result'] = $results->limit($limitend)->offset($limitstart)->get(); 

		return $result;
	}
	/*
	*	FETCH THE BABY AND ECHO CARDIO DETAIL FOR EDIT FORM
	*/	
	public static function  get_record($id)
	{
		$results = DB::table('echo_cardio')
            ->join('baby', 'echo_cardio.BabyId', '=', 'baby.BabyId')
            ->where('EchoId', $id)->get();		
		return $results;
	}

    /**
     * Method to get list count 
     * @return list count in type integer 
     */
	public static function GetTotalCount() 
    {
        $result = DB::table('echo_cardio')
		        	->join('baby', 'echo_cardio.BabyId', '=', 'baby.BabyId')
		            ->select('baby.BabyName', 'baby.BMrNo', 'baby.DOB', 'echo_cardio.TestDate', 'echo_cardio.EchoId', 'echo_cardio.Outcome')
		            ->where('echo_cardio.IsDeleted', 0)
		            ->count();
        return $result;
    }

	public static function GetTotal($searchText)
	{
		$search_txt = isset($searchText) ? $searchText : '';
		$contact_check = is_numeric($search_txt) ? $search_txt : '';
        $get_date      = strtotime($search_txt);
        $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
		$results = DB::table('echo_cardio')
		            ->join('baby', 'echo_cardio.BabyId', '=', 'baby.BabyId')
		             ->where(function ($query) use ($search_txt, $contact_check, $checkdate)
			            {
			                if ($search_txt) {
			                    $query->orwhere('baby.BabyName', 'like', '%'.trim($search_txt).'%');
			                    $query->orwhere('baby.BMrNo', $contact_check);
			                    $query->orWhere('Outcome', 'like', '%'.trim($search_txt).'%');
			                }


			            })
		            ->where('echo_cardio.IsDeleted', '0')
		            ->get();
	   return count($results);	            
	}
	
	/**
	 * This Method to get echocardiography record 
	 * 
	 * @param $baby_id type integer
	 *
	 * @return array of objects
	 */
	public static function GetList_delete_approval($baby_id)
	{
		$results = DB::table('echo_cardio')
				->where('BabyId', $baby_id)
                ->orderby('TestDate', 'desc')
                ->get();
        return $results;
	}

}
