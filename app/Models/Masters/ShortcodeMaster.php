<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ShortcodeMaster extends Model
{
	protected $table = 'mas_shortcode';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	protected $fillable = ['short_code','description','created_date_time','active','modified_date_time','is_deleted','deleted_user','delete_time','UserModified','UserDeleted'];
	/**
       Status  1 active
       status  0 inactive

		FETCH RECORDS TO DISPLAY IN THE MASTERS LISTING.
	*/
	/**
	   Type 1 Doctors
	   Type 2 Surgons 
	*/	
	public static function ListData()
	{
		$results = DB::table('mas_shortcode')
            ->select('*')->where('is_deleted', '0')
            ->get();		
		return $results;
	}

	public static function list($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
	{

    	$limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt =  isset($condition) ? trim($condition) : '';
        
        $results    = DB::table('mas_shortcode')
	                    ->select('*')
	                    ->where('is_deleted', '0')
	                    ->where(function ($query) use ($search_txt) {
	                        if ($search_txt) {
			                    $query->where('short_code', 'ilike', '%'.$search_txt.'%');
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
	public static function get_lists()
	{
		$results = DB::table('mas_shortcode')
            ->select('id', 'short_code','description')
            ->where('active', 1)
            ->where('is_deleted', '0')
            ->orderBy('id')
            ->get();		
		return $results;
	}

	/**
     * Get the doctor name by id
     *
     * @param $id is integer
     * 
     * @return array of object
     */
    public static function getDescription($id)
    {
      $results = DB::table('mas_shortcode')
              ->select('short_code','description')
              ->where('id', $id)
              //->where('status', 1)
              ->where('is_deleted', '0')
              ->first();    
      return $results;
    }


}
