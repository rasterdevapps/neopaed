<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Admissionmode extends Model
{
    protected $table = 'mas_admissionmode';
    protected $primaryKey = 'Id';
    public $timestamps = false;
    protected $fillable = ['Mode_name', 'Status', 'IsDeleted', 'UserAdded','DateAdded','UserDeleted','UserModified','DateModified'];

    public static function GetList()
    {
      $results = DB::table('mas_admissionmode')
            ->select('*')->where('IsDeleted', '0')
            ->get();    
      return $results;    	
    }

   public static function ListData()
   {
     $results=DB::table('mas_admissionmode')->where(['IsDeleted'=>'0', 'Status'=>'1'])->pluck('Mode_name', 'Id')->toArray();
     return $results;
   } 

   public static function list($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
   {
   	    $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt =  isset($condition) ? trim($condition) : '';
        
        $results    = DB::table('mas_admissionmode')
                      ->select('*')
                      ->where('IsDeleted', '0')
                      ->where(function ($query) use ($search_txt) {
                          if ($search_txt) {
                              $query->where('Mode_name', 'ilike', '%'.$search_txt.'%');
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
    * Get total count of admission mode
    *
    *@return antibiotic list in array
    */  
    public static function get_lists()
    {
      $results = DB::table('mas_admissionmode')
                  ->get()->count();    
      return $results;
    }

    /**
     * Get the admissionmode by id
     *
     * @param $id is integer
     * 
     * @return array of object
     */
    public static function getName($id)
    {
      $results = DB::table('mas_admissionmode')
              ->select('Mode_name')
              ->where('Id', $id)
              ->where('Status', '1')
              ->where('IsDeleted', '0')
              ->first();    
      return $results;
    }
}
