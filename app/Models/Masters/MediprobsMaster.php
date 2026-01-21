<?php namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MediprobsMaster extends Model 
{

	protected $table = 'mas_medical_problems';
	protected $primaryKey = 'Id';
	public $timestamps  =  false;
	protected $fillable = ['Name','Status','UserAdded','UserModified','DateAdded','DateModified','UserDeleted','IsDeleted'];
	/**
		FETCH RECORDS TO DISPLAY IN THE MASTERS LISTING.
	*/
	public static function  ListData()
	{
		$results = DB::table('mas_medical_problems')
            ->select('*')->where('IsDeleted', '0')
            ->orderBy('Id', 'asc')
            ->get();		
		return $results;
	}

	public static function list($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
	{

		$limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt =  isset($condition) ? trim($condition) : '';
        
        $results    = DB::table('mas_medical_problems')
	                    ->select('*')
	                    ->where('IsDeleted', '0')
	                    ->where(function ($query) use ($search_txt) {
	                        if ($search_txt) {
			                    $query->where('Name', 'ilike', '%'.$search_txt.'%');
			                    $query->orwhere('Status', $search_txt);
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
	public static function  get_lists()
	{
		$results = DB::table('mas_medical_problems')
            ->select('Id', 'Name')
            ->where('Status', 'Active')
            ->where('IsDeleted', '0')
            ->orderBy('Id', 'asc')
            ->get();		
		return $results;
	}

	/**
	 * Get the medical problems name by id
	 *
	 * @param $id is integer
	 * 
	 * @return array of object
	 */
	public static function getName($id)
	{
		$results = DB::table('mas_medical_problems')
            ->select('Name')
            ->where('Id', $id)
            //->where('Status', 'Active')
            ->where('IsDeleted', '0')
            ->first();		
		return $results;
	}

}
