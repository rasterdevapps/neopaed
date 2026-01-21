<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
   protected   $table       = 'ward';
   protected   $primaryKey  = 'id';
   public      $timestamps  =  false;
   protected   $fillable    = ['name','code','branchid','doctorids','departmentids', 'specialityids', 
                               'branchid', 'organizationid', 'active', 'createdDate', 'createdBy', 
                               'modifiedDate', 'modifiedBy', 'ward_group_id'];


   /**
    * This method to get ward lists
    * 
    * 
    */
   public static function ward_list() 
   { 
   	  return \DB::table('ward')
   	             ->select('name', 'id') 
   	             ->get();

   }  

    /**
    * This method to get ward lists
    * 
    *
    */
   public static function wardlist_bygroup($id) 
   { 
      return \DB::table('ward')
                 ->where('ward_group_id', $id) 
                 ->get();

   }  

   /**
    * This method to get ward lists
    * 
    *
    */
   public static function admission_ward_list() 
   { 
      return \DB::table('ward')
                 ->select('ward.name', 'ward.id') 
                 ->join('ward_group', 'ward_group.id', '=', 'ward.ward_group_id')
                 ->get();

   }                                   
} 
