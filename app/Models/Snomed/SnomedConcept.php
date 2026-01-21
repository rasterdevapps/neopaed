<?php

namespace App\Models\Snomed;

use Illuminate\Database\Eloquent\Model;

class SnomedConcept extends Model
{

   protected $table         = 'concept_f';
   protected $primaryKey    = 'id';
   public    $timestamps    =  false;

   /**
    * This method to link snomed concept 
    * with relation ship
    *
    */
   public function conceptThroughDescription() 
   {
     return $this->hasMany('App\Models\Snomed\SnomedDescription', 'conceptid', 'id');
   }

   /**
    * This method to link snomed concept 
    * with relation ship
    *
    */
   public function getconsceptlist($limit, $definition, $status) 
   {
     return \DB::table('concept_f')
                ->where('definitionstatusid', $definition)
                ->where('active', $status)
                ->limit($limit)
                ->get();
   }

   /**
    * This method to link snomed concept 
    * with relation ship
    *
    */
   public function getmedicineList($searchText) 
   {
       $result =  \DB::table('description_f')
                     ->whereIn('conceptid', \DB::table('concept_f')->where('moduleid', '=','13941000189108')->get()->pluck('id'))
                     ->where('term', 'like', '%'.strtolower($searchText).'%')
                     ->get();

       return  $result;
   }




}
