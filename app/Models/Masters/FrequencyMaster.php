<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FrequencyMaster extends Model
{
   /**
	* Define the table name
	*
    *@var $table
	*/
	protected $table = 'mas_frequency';

	/**
	* Define the table primary key 
	*
    *@var $primaryKey
	*/
	protected $primaryKey = 'freq_id';

	/**
	* Define the table timestamps
	*
    *@var $timestamps
	*/
	public    $timestamps  =  false;

	/**
	* Define the table fillable columns 
	*
    *@var $fillable
	*/
	protected $fillable = ['name', 'value', 'status', 'user_added', 'user_modified', 'date_added', 'date_modified',
	'user_deleted', 'is_deleted', 'usage_type'];


	public static function  list($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
	{

		$limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
		$limitend   = $limit;
		$search_txt = isset($condition) ? trim($condition) : '';

		$results    = DB::table('mas_frequency')
		->select('*')
		->where('is_deleted', 0)
		->where(function ($query) use ($search_txt) {
			if ($search_txt) {
				$query->orWhere('name', 'ilike', '%'.$search_txt.'%');
				$query->orWhere('value', 'ilike', '%'.$search_txt.'%');
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


	public static function GetTotal() 
	{
		$results = DB::table('mas_frequency')
		->where('is_deleted', 0)
		->get();	

		return count($results);		

	}
}
