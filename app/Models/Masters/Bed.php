<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
   protected   $table       = 'bed';
   protected   $primaryKey  = 'id';
   public      $timestamps  =  false;
   protected   $fillable    = ['number','status','assetid','branchid','organizationid', 'room_id', 'event_code', 'event_status', 'event_time', 'event_status_flag', 'pump_type'];
 
   /**
    * This method to get bed list
    *
    * 
    * @return type array 
    */
    public static function getbedlist()
    {
    	$results =  \DB::table('room')
                     ->select('room.id as room_id', 'room.number as room_number')
                     ->addSelect('ward.name as ward_name')
                     ->addSelect('bed.number as bed_number')
                     ->join('ward','ward.id','=','room.ward_id')
                     ->join('bed','bed.room_id','=','room.id')
        	           ->get();

     return $results;
    }

    /**
    * This method to get bed list
    *
    * 
    * @return type array 
    */
    public static function getbeddetails($room_id, $type='')
    {
        if ($type == 'all') {
            
          return \DB::table('bed')
                     ->where('room_id', $room_id)
                     ->orderBy('id', 'asc')
                     ->get();
        }

        return \DB::table('bed')
                 ->where('room_id', $room_id)
                 ->whereNull('status')
                 ->orderBy('id', 'asc')
                 ->get();

    }

    /**
    * This method to get bed list
    *
    * 
    * @return type array 
    */
    public static function getBedDetailsEdit($room_id)
    {
      return \DB::table('bed')
                 ->where('room_id', $room_id)
                 //->whereNull('status')
                 ->get();

    }

    /**
     * Method to fetch the list 
     *
     * @param $page type integer
     * @param $limit type integer 
     * @param $condition type string 
     * @param $order type array 
     * @param $slug type integer 
     * @return bed site list in array of object 
     */
    public static function listData($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
    {
        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt =  isset($condition) ? trim($condition) : '';
        
        $results    = \DB::table('room')
                         ->select('room.id as room_id', 'room.number as room_number')
                         ->addSelect('ward.name as ward_name')
                         ->addSelect('bed.number as bed_number')
                         ->join('ward','ward.id','=','room.ward_id')
                         ->join('bed','bed.room_id','=','room.id')
                         ->where(function ($query) use ($search_txt) {
                            if ($search_txt) {
                                $query->where('ward.name', 'ilike', '%'.$search_txt.'%');
                                $query->orwhere('room.number', $search_txt);
                                $query->orwhere('bed.number', $search_txt);
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
    * This method to get bed list
    *
    * 
    * @return type array 
    */
    public static function getallbeddetails($room_id)
    {
      return \DB::table('bed')
                 ->where('room_id', $room_id)
                 ->get();

    }

    /**
    * This method to get bed list
    *
    * 
    * @return type array of objects 
    */
    public static function getRoomByBed($bed_id)
    {
      return \DB::table('bed')
                 ->where('id', $bed_id)
                 ->first();

    }

}
