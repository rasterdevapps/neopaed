<?php namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vaccine extends Model 
{

	protected $table = 'mas_vaccine';
	protected $primaryKey = 'Id';
	public $timestamps  =  false;
	protected $fillable = ['Name','Value','Status','UserAdded','UserModified','DateAdded','DateModified','UserDeleted','IsDeleted'];
	/**
	* FETCH RECORDS TO DISPLAY IN THE DROPDOWN OF ADMISSION MODULES(Only active records).
	*/
	public static function  get_lists()
	{
		$results = DB::table('mas_vaccine')
		            ->select('Id', 'Name', 'Value')
		            ->where('Status', 'Active')
		            ->where('IsDeleted', '0')
		            ->get();		
		return $results;
	}
	/**
		FETCH RECORDS TO DISPLAY IN THE MASTERS LISTING.
	*/	
	public static function  ListData()
	{
		$results = DB::table('mas_vaccine')
            ->select('*')->where('IsDeleted', '0')
            ->get();		
		return $results;
	}
	
	public static function  list($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
	{
    	$limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt =  isset($condition) ? trim($condition) : '';
        
        $results    = DB::table('mas_vaccine')
	                    ->select('*')
	                    ->where('IsDeleted', '0')
	                    ->where(function ($query) use ($search_txt) {
	                        if ($search_txt) {
			                    $query->where('Name', 'ilike', '%'.$search_txt.'%');
			                    $query->orwhere('Status', $search_txt);
			                    $query->orwhere('Value', $search_txt);
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
	 * @return collection site count in integer
	 */
	public static function getCount()
	{
		$results = \DB::table('mas_vaccine')
	                    ->where('IsDeleted', '0')
		            	->get()->count();		
		return $results;
	}		
}
