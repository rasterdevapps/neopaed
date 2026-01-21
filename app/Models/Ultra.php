<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ultra extends Model 
{
	protected $table      = 'ultra_sound';
	protected $primaryKey = 'UltraId';
	public $timestamps    =  false;
	protected $fillable   = ['AdmissionId','BabyId','UsgRt','UsgLt','UsgGeneral','Impression','Indication','TestDate','Age','SeenBy','UserAdded','UserModified','DateAdded','DateModified','UserDeleted','IsDeleted'];

	
	public static function  get_lists($page=1, $limit=50, $condition='', $order=array())
	{
		$limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend = $limit;
        $search_txt = isset($condition) ? $condition : '';

        $contact_check = is_numeric($search_txt) ? $search_txt : '';
        $get_date      = strtotime($search_txt);
        $checkdate     ='';
        if (strpos($search_txt, '-') > 0) {
              $get_date      = strtotime($search_txt);
              $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
              $search_txt    = '';
        }

		$results = DB::table('ultra_sound')
	               ->join('baby', 'ultra_sound.BabyId', '=', 'baby.BabyId')
	               ->select('baby.BabyName', 'baby.BMrNo', 'baby.DOB', 'ultra_sound.TestDate', 'ultra_sound.UltraId')
	               ->where('ultra_sound.IsDeleted', 0)
		            ->where(function ($query) use ($search_txt, $checkdate)
		            {
		                if ($search_txt) {
				            $query->orwhere('baby.BabyName', 'ilike', '%'.trim($search_txt).'%');
				            $query->orwhere('baby.BMrNo', trim($search_txt));
		                } elseif ($checkdate) {
		                    $query->orWhereRaw('"baby"."DOB"::date='.$checkdate);
		                    $query->orWhereRaw('"ultra_sound"."TestDate"::date='.$checkdate);
		                }


		            });
        if (isset($order['sortby']) && isset($order['sortorder'])) {
		   	$results->orderBy($order['sortby'], $order['sortorder']);
		}

		$result['total']  = $results->get()->count();  
        $result['result'] = $results->limit($limitend)->offset($limitstart)->get();		

		return $result;
	}
	public static function  get_record($id)
	{
		$results = DB::table('ultra_sound')
		           ->join('baby', 'ultra_sound.BabyId', '=', 'baby.BabyId')
		           ->where('UltraId', $id)
		           ->get();		
		return $results;
	}

	public static function GetTotal($searchText='') 
	{

        $contact_check = is_numeric($searchText) ? $searchText : '';
        $get_date      = strtotime($searchText);
        $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';

			$results = DB::table('ultra_sound')
            ->join('baby', 'ultra_sound.BabyId', '=', 'baby.BabyId')
            ->select('baby.BabyName', 'baby.BMrNo', 'ultra_sound.TestDate', 'ultra_sound.UltraId')
            ->where('ultra_sound.IsDeleted', 0)
            ->where(function ($query) use ($searchText,$contact_check,$checkdate) {
				if ($searchText) {
				    $query->orwhere('baby.BabyName', 'ilike', '%'.trim($searchText).'%');
				    $query->orwhere('baby.BMrNo', $contact_check);
				}

		    })
            ->get();

       return count($results);

	}
	
	/**
	 * This Method to get cranial ultrasonography record 
	 * 
	 * @param $baby_id type integer
	 *
	 * @return array of objects
	 */
	public static function GetList_delete_approval($baby_id)
	{
		$results = DB::table('ultra_sound')
				->where('BabyId', $baby_id)
                ->orderby('TestDate', 'desc')
                ->get();

        return $results;
	}
}
