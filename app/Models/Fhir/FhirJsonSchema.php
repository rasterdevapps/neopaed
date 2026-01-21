<?php

namespace App\Models\Fhir;

use Illuminate\Database\Eloquent\Model;

class FhirJsonSchema extends Model
{
    protected $table      = 'fihr_json_schema';
	public $timestamps    =  false;
	protected $primaryKey = 'id';
	protected $fillable   = ['resource_type', 'resource_schema', 'version'];

	/**
	 * This method get json schema 
	 * based on resource type
	 *
	 * @param $resource_type
	 */
	public static function get_resource_schema($resource_type)
	{
		$result = \DB::table('fihr_json_schema')
		           ->select('resource_schema')
		           ->where('resource_type', $resource_type)
		           ->first();

		return isset($result->resource_schema) ? json_decode($result->resource_schema) : false;          
        
	}

	public static function get_list($page=1, $limit=50, $search_txt, $order=array()) {
		$limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend = $limit;
		$search_txt = isset($search_txt) ? $search_txt : '';
      
       	$results = \DB::table('fihr_json_schema')
						->select('*')
						->where(function ($query) use ($search_txt)
		            	{
							if (!empty($search_txt)) {
								$query->whereRaw('LOWER("resource_type") like '."'%".strtolower(trim($search_txt))."%'");
							}
				        });
				        
		if (isset($order['sortby']) && isset($order['sortorder'])) {
            $results->orderBy($order['sortby'], $order['sortorder']);
        }
        $result = $results->limit($limitend)->offset($limitstart)->paginate($limit);

		return $result;
	}

	/**
	 * This get find particular id 
	 *
	 * @param $id type integer
	 *
	 */
	public static function get_record($id)
	{
		$result = \DB::table('fihr_json_schema')
		          // ->selectRaw('jsonb_pretty("resource_schema") as resource_schema')
		          ->addSelect('id', 'resource_type', 'version', 'resource_schema')
		          ->where('id', $id)
		          ->first();
		          // echo '<pre>';print_r($result);exit;
		return $result;
	}

	/**
     * Get The total records count 
     * 
     * @return list count
     */
    public static function getTotal() {
        return \DB::table('fihr_json_schema')->get()->count();
    }
}
