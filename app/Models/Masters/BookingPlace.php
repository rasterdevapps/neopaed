<?php namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BookingPlace extends Model 
{

	protected $table = 'booking_place';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	protected $fillable = ['hospital_name','hospital_email','hospital_number','status','UserAdded','UserModified','DateAdded','DateModified','UserDeleted','IsDeleted'];
	/**
		FETCH RECORDS TO DISPLAY IN THE MASTERS LISTING.
	*/
	public static function  ListData($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
	{

    	$limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt =  isset($condition) ? trim($condition) : '';
        
        $results    = DB::table('booking_place')
	                    ->select('*')
	                    ->where('IsDeleted', '0')
	                    ->where(function ($query) use ($search_txt) {
	                        if ($search_txt) {
			                    $query->where('hospital_name', 'ilike', '%'.$search_txt.'%');
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
		$results = DB::table('booking_place')
            ->select('id', 'hospital_name', 'hospital_email', 'hospital_number')
            ->where('status', 'Active')
            ->where('IsDeleted', '0')
            ->orderBy('id', 'asc')
            ->get();		
		return $results;
	}

	/**
	 * GET NON DELETED RECORDS COUNT 
	 *
	 * @return booking place count in integer
	 */
	public static function getCount()
	{
		$results = \DB::table('booking_place')
	                    ->where('IsDeleted', '0')
		            	->get()->count();		
		return $results;
	}

}
