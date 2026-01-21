<?php namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Usergroups extends Model 
{

	protected $table = 'user_role';
	protected $primaryKey = 'RoleId';
	public $timestamps  =  false;
	protected $fillable = ['RoleName','Permissions','Status','UserAdded','UserModified','DateAdded','DateModified'];
	/*
	* USED FOR USERGROUP EDIT FORM
	*/
	public static function  get_record($id)
	{
		$results = DB::table('user_role')
            ->where('RoleId', $id)->get();		
		return $results;
	}	
	/*
	* USED IN USER CREATION FORMS
	*/
	public static function  get_list($id, $page=1, $limit=50, $condition = array(), $order=array(), $slug = '')
	{
		// $results = DB::table('user_role');
  //       if ($id!=1) {
  //         $results->where('RoleId', '!=', $id);
  //       }
  //       $result=$results->get();
		// return $result;	

		$limitstart    = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
		$limitend      = $limit;
		$search_txt    = isset($condition['search_txt']) ? trim($condition['search_txt']) : '';

		$results = DB::table('user_role')
						->where(function ($query) use ($id, $search_txt) {
							if ($search_txt) {
								$query->whereRaw('LOWER("RoleName") like '."'%".strtolower($search_txt)."%'");
								$query->orWhereRaw('LOWER("Status") like '."'%".strtolower($search_txt)."%'");
							}
							if ($id != 1 && $id != 0) {
					          	$query->where('RoleId', '!=', $id);
					        }
						});

		if (isset($order['sortby']) && isset($order['sortorder'])) {
			$results->orderBy($order['sortby'], $order['sortorder']);  
		}
		if ($slug) {
			return $results;
		} else {
			$result = $results->limit($limitend)->offset($limitstart)->get();           
		}

		return $result;
	}

  	/**
     * FETCH NON DELETED DATA RECORD COUNT
     *
     * @return integer
     */	
	public static function GetTotal($id) 
    {
		$result = DB::table('user_role')
						->where(function ($query) use ($id) {						
							if ($id != 1) {
					          	$query->where('RoleId', '!=', $id);
					        }
						})->get()->count();
		return $result;
	}			
}
