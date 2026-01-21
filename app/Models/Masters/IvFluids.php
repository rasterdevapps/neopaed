<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class IvFluids extends Model
{
    protected $table       = 'mas_ivfluid';
    protected $primaryKey  = 'id';
    public $timestamps     = false;
    protected $fillable    = ['name','status','UserAdded','DateAdded','UserDeleted','UserModified','DateModified','IsDeleted','pharmacological_name', 'group_id', 'drug_library'];

    /**
     * This method to get fluid list
     */
    public static function  ListData()
    {
        $results = \DB::table('mas_ivfluid')
                      ->select('*')
                      ->where('IsDeleted', '0')
                      ->get();
        return $results;
    }
    public static function  list($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
    {
      $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt =  isset($condition) ? trim($condition) : '';
        
        $results    = \DB::table('mas_ivfluid')
                      ->select('*')
                      ->where('IsDeleted', '0')
                      ->where(function ($query) use ($search_txt) {
                          if ($search_txt) {
                              $query->where('name', 'ilike', '%'.$search_txt.'%');
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
     * This method to get fluid list
     */
    public static function  get_lists()
    {
        $results = \DB::table('mas_ivfluid')
                      ->select('*')
                      ->where('IsDeleted', '0')
                      ->get();
        return $results;
    }

    /**
     * This method to get fluid list as an array
     */
    public static function getFieldvalue()
    {
   	  $results = \DB::table('mas_ivfluid')
               ->where(['IsDeleted'=>'0','status'=>'1'])
               ->pluck('name', 'id')->toArray();
      return $results;
    }

    /**
     * This method to get drug name
     */
    public static function getDrugName($id)
    {
      $results = \DB::table('mas_ivfluid')
               ->select('name')
               ->where('id',$id)
               ->first();
      return $results;
    }

    /**
     * This method to compare the master and fhirformatedvalue
     */
    public static function drugComparsion($drug_library) {
      return \DB::table('mas_ivfluid')
              ->select('name')
              ->where('name', 'ilike', '%'.ucfirst(strtolower($drug_library)).'%')
              ->first();
    }

    /**
     * This method to get master id.
     */
    public static function getDrugID($meanvalue) {
      return \DB::table('mas_ivfluid')
              ->select('id')
              ->where('name',$meanvalue)
              ->first();
    }

    /**
     * This method to get drug name
     */
    public static function getPharmacologicalName($id)
    {
      $results = \DB::table('mas_ivfluid')
               ->select('pharmacological_name')
               ->where('id',$id)
               ->first();
      return $results;
    }

}
