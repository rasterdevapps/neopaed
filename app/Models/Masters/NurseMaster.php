<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class NurseMaster extends Model
{
   protected $table = 'mas_nures';
   protected $primaryKey = 'id';
   public $timestamps  =  false;
   protected $fillable = ['name', 'register_no','status', 'DateAdded', 'DateModified', 'UserAdded', 'IsDeleted', 'UserDeleted', 'UserModified', 'user_id'];

	/**
     * Method to fetch the list 
     *
     * @param $page type integer
     * @param $limit type integer 
     * @param $condition type string 
     * @param $order type array 
     * @param $slug type integer 
     * @return nurse master list in array of object 
     */
    public static function listData($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
    {
    	$limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt =  isset($condition) ? trim($condition) : '';
        
        $results    = \DB::table('mas_nures')
	                    ->select('*')
	                    ->where('IsDeleted', '0')
	                    ->where(function ($query) use ($search_txt) {
	                        if ($search_txt) {
			                    $query->where('name', 'ilike', '%'.$search_txt.'%');
			                    $query->orwhere('status', $search_txt);
			                    $query->orwhere('register_no', $search_txt);
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
     * GET NON DELETED RECORDS COUNT 
     *
     * @return nurse master count in integer
     */
    public static function getCount()
	{
		$results = \DB::table('mas_nures')
	                    ->where('IsDeleted', '0')
		            	->get()->count();		
		return $results;
	}




}
