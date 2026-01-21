<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DoseMaster extends Model
{
   /**
	* Define the table name
	*
    *@var $table
	*/
	protected $table = 'mas_dose';

	/**
	* Define the table primary key 
	*
    *@var $primaryKey
	*/
	protected $primaryKey = 'id';

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
	protected $fillable = ['volume', 'status', 'user_added', 'user_modified', 'date_added', 'date_modified',
	'user_deleted', 'is_deleted'];


	public static function  list($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
	{

		$limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
		$limitend   = $limit;
		$search_txt = isset($condition) ? trim($condition) : '';

		$results    = DB::table('mas_dose')
		->select('*')
		->where('is_deleted', 0)
		->where(function ($query) use ($search_txt) {
			if ($search_txt) {
				$query->orWhere('volume', 'ilike', '%'.$search_txt.'%');
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
		$results = DB::table('mas_dose')
		->where('is_deleted', 0)
		->get();	

		return count($results);		

	}
}
