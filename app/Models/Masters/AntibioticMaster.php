<?php namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AntibioticMaster extends Model 
{
   /**
	* Define the table name
	*
    *@var $table
	*/
	protected $table = 'mas_antibiotic';

	/**
	* Define the table primary key 
	*
    *@var $primaryKey
	*/
	protected $primaryKey = 'Id';

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
	protected $fillable = ['Name', 'Value', 'Status', 'UserAdded', 'UserModified', 'DateAdded', 'DateModified',
	                       'UserDeleted', 'IsDeleted'];
	
	/**
	* Method to return list with search, order and limit 
	*
    *@param $limit type integer
    *@param $search type array 
    *@param $order  type array 
    *@return antibiotic list in array of object  
	*/
    public static function ListData($limit='', $search=array(), $order=array())
    {
	    $results = DB::table('mas_antibiotic')
				->select('*')->where('IsDeleted', '0')
				->where(function ($query) use ($search) {

	                if ($search) {
	                    $query->where('Name', 'ilike', '%'.$search['search_txt'].'%');
	                    $query->orwhere('Status', $search['search_txt']);
	                    $query->orwhere('Value', $search['search_txt']);
	                }

          		 });
			    if (isset($order['sortby']) && isset($order['sortorder'])) {	
				 $results->orderBy($order['sortby'], $order['sortorder']);
			    }
			    if (!empty($limit)) {
				  $result = $results->paginate($limit);	
				} else {
				  $result = $results->get();		
				}

			return $result;
	}

    public static function list($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
    {
    	$limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt =  isset($condition) ? trim($condition) : '';
        
        $results    = DB::table('mas_antibiotic')
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
	* Method to return list with id and name of antibiotic
	*
    *@return antibiotic list in array
	*/	
	public static function  get_lists()
	{
		$results = DB::table('mas_antibiotic')
		            ->select('Id', 'Name')
		            ->where('Status', 'Active')
		            ->where('IsDeleted', '0')
		            ->orderby('Name','asc')
		            ->get();		
		return $results;
	}	

	/**
	 * Get the antibiotic name by id
	 *
	 * @param $id is integer
	 * 
	 * @return array of object
	 */
	public static function getName($id)
	{
		$results = DB::table('mas_antibiotic')
            ->select('Name')
            ->where('Id', $id)
            ->where('Status', 'Active')
            ->where('IsDeleted', '0')
            ->first();		
		return $results;
	}	

	/**
	 * FETCH NON DELETED DATA RECORD COUNT
	 *
	 * @return integer
	 */	
	public static function GetTotal() 
	{
		$result = DB::table('mas_antibiotic')->where('IsDeleted', '0')->get()->count();
		return $result;
	}
}
