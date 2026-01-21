<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
   protected   $table       = 'block';
   protected   $primaryKey  = 'id';
   public      $timestamps  =  false;
   protected   $fillable    = ['name', 'code','default','departmentids','specialityids','branchid','organizationid',
                               'active','createdDate','createdBy','modifiedDate','modifiedBy'];
   

   /**
    * This method to define
    * Releationship between block and ward group
    *
    */
   public function getwardgroup()
   {
      return $this->hasMany('App\Models\Masters\WardGroup', 'blcok_id', 'id');

   }

   /**
    * This method to get block details 
    * 
    * @return array of object
    */
   public static function getwardgrouplist()
   {
      
       return \DB::table('block')
                  ->select('id', 'name as block_name')
                  ->get();
                  // ->select('block.name as block_name', 'ward_group.name as ward_group_name', 'ward.name as ward_name')
                  // ->addSelect('block.id as block_id')
                  // ->join('ward_group', 'ward_group.blcok_id', '=', 'block.id')
                  // ->join('ward', 'ward.ward_group_id', '=', 'ward_group.id')
                  // ->orderby('ward.id', 'asc')
                  // ->get();

   }

    /**
     * Method to fetch the list 
     *
     * @param $page type integer
     * @param $limit type integer 
     * @param $condition type string 
     * @param $order type array 
     * @param $slug type integer 
     * @return block list in array of object 
     */
    public static function listData($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
    {
        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt = isset($condition) ? trim($condition) : '';
        
        $results    = \DB::table('block')
                      ->select('id', 'name as block_name')
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


}
