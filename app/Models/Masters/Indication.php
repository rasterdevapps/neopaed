<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Indication extends Model
{

    protected $table = 'mas_indication';
    protected $primaryKey = 'Id';
    public $timestamps = false;
    protected $fillable = ['indication_name','indication_status','UserAdded','DateAdded','UserDeleted','DateModified','IsDeleted'];

    public static function  ListData()
    {
        $results = DB::table('mas_indication')
                      ->select('*')
                      ->where('IsDeleted', '0')
                      ->get();
        return $results;
    }

    public static function  list($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
    {

        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt = isset($condition) ? trim($condition) : '';
        
        $results    = DB::table('mas_indication')
                          ->select('*')
                          ->where('IsDeleted', '0')
                          ->where(function ($query) use ($search_txt) {
                                if ($search_txt) {
                                    $query->where('indication_name', 'ilike', '%'.$search_txt.'%');
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
   public static function getFieldvalue()
   {

   	 $results = DB::table('mas_indication')
               ->where(['IsDeleted'=>'0','indication_status'=>1])
               ->pluck('indication_name', 'Id')->toArray();
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
      $results = DB::table('mas_indication')
              ->select('indication_name')
              ->where('Id', $id)
              //->where('indication_status', '1')
              ->where('IsDeleted', '0')
              ->first();    
      return $results;
    }

    /**
     * GET NON DELETED RECORDS COUNT 
     *
     * @return indication count in integer
     */
    public static function getCount()
    {
      $results = \DB::table('mas_indication')
                        ->where('IsDeleted', '0')
                        ->get()->count();    
      return $results;
    }
    
}
