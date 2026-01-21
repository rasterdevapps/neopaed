<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
   protected   $table       = 'room';
   protected   $primaryKey  = 'id';
   public      $timestamps  =  false;
   protected   $fillable    = ['number','doctorid','branchid','organizationid','active', 'createdDate', 
                               'createdBy', 'modifiedDate', 'modifiedBy', 'ward_id'];


   /**
    * This method to get 
    * bed list based on room id 
    *
    */
    public function getbedlists()
    {
      return $this->hasMany('App\Models\Masters\Bed', 'room_id', 'id');
    }

    /**
     * This method to get room list
     * based on ward select 
     *
     * @param $ward_id
     */
    public static function getroomlist($ward_id)
    {
       return \DB::table('room')
                 ->where('ward_id', $ward_id)
                 ->orderBy('id', 'asc')
                 ->get();

    }

}
