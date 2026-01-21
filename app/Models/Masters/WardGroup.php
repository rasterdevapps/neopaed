<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class WardGroup extends Model
{
   protected   $table       = 'ward_group';
   protected   $primaryKey  = 'id';
   public      $timestamps  =  false;
   protected   $fillable    = ['name','code','branchid','organizationid','active', 'createdDate', 
                               'createdBy', 'modifiedDate', 'modifiedBy', 'blcok_id'];


   /**
    * This method to define
    * Releationship between ward group and ward 
    *
    */
   public function getward()
   {
      return $this->hasMany('App\Models\Masters\Ward', 'ward_group_id', 'id');

   }


}
