<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class CollectionMethod extends Model
{
	
    protected $table = 'mas_collection_method';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	protected $fillable = ['name','status','UserAdded','UserModified','DateAdded','DateModified','UserDeleted','IsDeleted'];
	
	/**
	 * FETCH RECORDS TO DISPLAY IN THE MASTERS LISTING AND IN THE ADMISSION MODULES TOO.
	 */
	public static function  ListData()
	{
		$results = \DB::table('mas_collection_method')
                      ->select('*')->where('IsDeleted', '0')
                      ->get();		
		return $results;
	}
	/**
     * Method to fetch the list 
     *
     * @param $page type integer
     * @param $limit type integer 
     * @param $condition type string 
     * @param $order type array 
     * @param $slug type integer 
     * @return collection method list in array of object 
     */
	public static function list($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
	{
    	$limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt =  isset($condition) ? trim($condition) : '';
        
        $results    = \DB::table('mas_collection_method')
	                    ->select('*')
	                    ->where('IsDeleted', '0')
	                    ->where(function ($query) use ($search_txt) {
	                        if ($search_txt) {
			                    $query->where('name', 'ilike', '%'.$search_txt.'%');
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
	 * @return collection method count in integer
	 */
	public static function getCount()
	{
		$results = \DB::table('mas_collection_method')
	                    ->where('IsDeleted', '0')
		            	->get()->count();		
		return $results;
	}
}
