<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class InvestigationsTestMaster extends Model
{
    /**
     * Define the table name
     *
     * @var $table
     */
    protected $table = 'mas_investigations_test';

    /**
     * Define the table primary key
     *
     * @var $primary key
     */
    protected $primaryKey = 'id';

    /**
     * Define the table timestamps
     *
     * @var $timestamps
     */
    public $timestamps    = false;

    /**
     * Define the table fillable columns
     *
     * @var $fillable
     */
    protected $fillable   = ['package_id', 'test_name', 'test_status', 'is_deleted', 'deleted_user_id', 'created_user_id', 'created_date_time', 'modified_user_id', 'modified_date_time'];
            

    public static function  list($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
    {

        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt = isset($condition) ? trim($condition) : '';

        $results    = self:: select('*')
        ->where('is_deleted', 0)
        ->where('test_status', 1)
        ->where(function ($query) use ($search_txt) {
            if ($search_txt) {
                $query->orWhere('test_name', 'ilike', '%'.$search_txt.'%');
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

    public static function GetTotal() 
    {
        $results = self::where('is_deleted', 0)->where('test_status', 1)
        ->get();    

        return count($results);     

    } 

    public static function getTestList($package_id) 
    {
            $results = self::where('package_id', $package_id)->where('is_deleted', 0)->where('test_status', 1)
            ->get();    
        return $results;     

    }   
}
