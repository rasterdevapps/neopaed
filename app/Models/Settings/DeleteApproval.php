<?php namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DeleteApproval extends Model 
{
	protected $table = 'delete_approval';
	protected $primaryKey = 'Id';
	public $timestamps  =  false;
	protected $fillable = ['Name','BabyId','AdmissionDate','ModuleController','ModuleId','ModuleName','Status','UserDeleted','UserApproved','DateDeleted','DateApproved', 'SubModuleId'];
	/**
	* USED TO LIST THE PENDING REQUESTS IN THE LISTING PAGE FOR APPROVAL
	*/
	public static function  ListData($page=1, $limit=50, $condition = array(), $order=array(), $slug = '')
	{
		$limitstart    = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
		$limitend      = $limit;
		$search_txt    = isset($condition['search_txt']) ? trim($condition['search_txt']) : '';
		$checkint 	   = is_numeric($search_txt) ? $search_txt : '';
        $checkdate     = '';

        if (strpos($search_txt, '-') > 0) {
            $get_date      = strtotime($search_txt);
            $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
            $search_txt    = '';
        }
		$results = DB::table('delete_approval')
		           		->join('users', 'users.id', '=', 'delete_approval.UserDeleted')
		           		->select('delete_approval.*', 'users.name as UserName')
       			  		->where('Status', "Pending")
						->where(function ($query) use ($search_txt, $checkdate, $checkint) {
							if ($search_txt) {
								$query->whereRaw('LOWER("Name") like '."'%".strtolower($search_txt)."%'");
								$query->orWhereRaw('LOWER("ModuleName") like '."'%".strtolower($search_txt)."%'");
							} elseif ($checkdate) {
	                          	$query->whereRaw('"AdmissionDate"::date='.$checkdate);
	                          	$query->orWhereRaw('"DateDeleted"::date='.$checkdate);
	                        } elseif ($checkint) {
	                          	$query->where("UserDeleted",$checkint);
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
	public static function GetTotal() 
    {
		$result = DB::table('delete_approval')->where('Status', "Pending")->get()->count();
		return $result;
	}
}
