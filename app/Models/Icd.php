<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Icd extends Model 
{
    /**
     *This variable used to bind the table name
     *@var $table type string 
     */
	protected $table = 'icd';

    /**
     *This variable used to bind the table primary key
     *@var $primaryKey type string 
     */
	protected $primaryKey = 'id';

    /**
     *This variable used to bind the table timestamps
     *@var $primaryKey type string 
     */
	public $timestamps  =  false;

    /**
     *This variable used to bind the table fillable column
     *@var $fillable type array  
     */
	protected $fillable = ['ICDCode','ICDDescription','ICDFormat'];

    /**
     * Method fetch the list 
     *
     * @param $page type integer
     * @param $limit type integer 
     * @param $condition type array 
     * @return icd list in array of object 
     */
	public static function  ListData($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
    {

        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt =  isset($condition) ? trim($condition) : '';
        
        $results    = DB::table('icd')
                        ->select('icd.*')
                        ->where(function ($query) use ($search_txt) {
                            if ($search_txt) {
                                $query->orwhere('ICDCode', 'like', '%'.$search_txt.'%');
                                $query->orwhere('ICDDescription', 'like', '%'.$search_txt.'%');
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
     * Method to get list count 
     * @return list count in type integer 
     */
	public static function GetTotal() 
    {
        $result = DB::table('icd')->get()->count();
        return $result;
    }

    /**
     * Method to get list for value
     *
     * @return list in array of object 
     */
    public static function GetList()
    {
        $results = \DB::table('icd')
                    ->selectRaw('"ICDDescription"|| \' - \' || "ICDCode" as icdcode')
                    ->addSelect('*')
                    ->where('ICDCode', '<>', '')
                    ->get();

        return $results;

    }

}






