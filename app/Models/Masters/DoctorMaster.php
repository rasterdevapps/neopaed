<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class DoctorMaster extends Model
{
	protected $table = 'mas_doctors';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	protected $fillable = ['Name','type','status','UserAdded','UserModified','DateAdded','DateModified','UserDeleted','IsDeleted','code','hms_key', 'userId', 'Qualification', 'job_title', 'register_no'];
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
		$results = DB::table('mas_doctors')
            ->select('*')->where('IsDeleted', '0')
            ->get();		
		return $results;
	}

	public static function list($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
	{

    	$limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt =  isset($condition) ? trim($condition) : '';
        
        $results    = DB::table('mas_doctors')
	                    ->select('*')
	                    ->where('IsDeleted', '0')
	                    ->where(function ($query) use ($search_txt) {
	                        if ($search_txt) {
			                    $query->where('Name', 'ilike', '%'.$search_txt.'%');
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
		$results = DB::table('mas_doctors')
            ->select('id', 'Name')
            ->where('status', 1)
            ->where('IsDeleted', '0')
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
    public static function getName($id)
    {
      $results = DB::table('mas_doctors')
              ->select('Name')
              ->where('id', $id)
              //->where('status', 1)
              ->where('IsDeleted', '0')
              ->first();    
      return $results;
    }


}
