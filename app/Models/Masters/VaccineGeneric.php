<?php namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VaccineGeneric extends Model 
{

	protected $table = 'mas_vaccine_generic';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	protected $fillable = ['name', 'vaccine_age_id', 'status', 'user_added', 'user_modified', 'date_added', 'date_modified', 'user_deleted', 'is_deleted', 'deleted_date_time'];
	/**
		FETCH RECORDS TO DISPLAY IN THE MASTERS LISTING.
	*/
	public static function  ListData()
	{
		$results = DB::table('mas_vaccine_generic')
            ->select('*')
            ->get();		
		return $results;
	}

	public static function  list($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
	{
		$limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt =  isset($condition) ? trim($condition) : '';
        
        $results    = DB::table('mas_vaccine_generic')
	                    ->select('*')
	                    ->where('is_deleted', '0')
	                    ->where(function ($query) use ($search_txt) {
	                        if ($search_txt) {
			                    $query->where('name', 'ilike', '%'.$search_txt.'%');
			                    $query->orwhere('status', $search_txt);
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
		FETCH RECORDS TO DISPLAY IN THE DROPDOWN OF ADMISSION MODULES(Only active records).
	*/
	public static function  get_lists()
	{
		$results = DB::table('mas_vaccine_generic')
            ->select('id', 'age', 'status')
            ->where('status', 'Active')
            ->where('is_deleted', '0')
            ->orderBy('sort_order', 'asc')
            ->get();		
		return $results;
	}

	// /**
	// 	Check age already exist in vaccine_age_table.
	// */
	// public static function checkAgeExist($age)
	// {
	// 	$results = DB::table('mas_vaccine_generic')
 //            ->select('id')
 //            ->where('status', 'Active')
 //            ->where('age', $age)
 //            ->where('is_deleted', '0')
 //            ->first();		
	// 	return $results;
	// }
	// /**
	// 	get vaccine from mas_vaccine_generic table
	// */
	// public static function getVaccine()
	// {
	// 	$results = DB::table('mas_vaccine_generic')
 //            ->where('is_deleted', '0')
 //            ->get();		
	// 	return $results;
	// }

}
