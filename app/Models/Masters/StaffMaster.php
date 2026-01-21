<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class StaffMaster extends Model
{
    protected $table = 'mas_staff';
	protected $primaryKey = 'staff_id';
	public $timestamps  =  false;
	protected $fillable = ['name','qualification','designation','status','UserAdded','UserModified','DateAdded','DateModified','UserDeleted','IsDeleted'];
	/**
		FETCH RECORDS TO DISPLAY IN THE MASTERS LISTING AND IN THE ADMISSION MODULES TOO.
	*/
	public static function  ListData()
	{
		$results = DB::table('mas_staff')
            ->select('*')->where('IsDeleted', '0')
            ->get();		
		return $results;
	}

	public static function GetList($limit=10, $search=array(), $order=array())
	{
    	
    	$results = DB::table('mas_staff')
				->select('*')->where('IsDeleted', '0')
				->where(function ($query) use ($search)
           		 {
	                if ($search) {
	                    
	                    $query->where('name', 'ilike', '%'.$search['search_txt'].'%');

	                }
                    if ($search['search_txt']=='Active' || $search['search_txt']=='Inactive') {
                       
                        $search['search_txt']=($search['search_txt']=='Active')? 1 : 0;

                    	$query->orwhere('Status', $search['search_txt']);
                    }

          		 });


        if (isset($order['sortby']) && isset($order['sortorder'])) {
			$results->orderBy($order['sortby'], $order['sortorder']);
		}
		$result = $results->paginate($limit);					

		return $result;
    }	

}
