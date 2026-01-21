<?php namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProcedureMaster extends Model 
{

	protected $table = 'mas_procedures';
	protected $primaryKey = 'Id';
	public $timestamps  =  false;
	protected $fillable = ['Name','Status','UserAdded','UserModified','DateAdded','DateModified','UserDeleted','IsDeleted'];
	/**
		FETCH RECORDS TO DISPLAY IN THE MASTERS LISTING AND IN THE ADMISSION MODULES TOO.
	*/
	public static function  ListData()
	{
		$results = DB::table('mas_procedures')
            ->select('*')->where('IsDeleted', '0')
            ->get();		
		return $results;
	}	

	public static function  list($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
	{
    	$limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt =  isset($condition) ? trim($condition) : '';
        
        $results    = DB::table('mas_procedures')
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
	 * GET NON DELETED RECORDS COUNT 
	 *
	 * @return procedures count in integer
	 */
	public static function getCount()
	{
		$results = \DB::table('mas_procedures')
	                    ->where('IsDeleted', '0')
		            	->get()->count();		
		return $results;
	}
}
