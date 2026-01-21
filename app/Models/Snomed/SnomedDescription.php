<?php

namespace App\Models\Snomed;

use Illuminate\Database\Eloquent\Model;

class SnomedDescription extends Model
{
   protected $table         = 'description_f';
   protected $primaryKey    = 'term';
   public    $timestamps    =  false;

   /**
    * This method to link snomed concept 
    * with relation ship
    *
    */
   public function descriptionThroughConcept() 
   {
     return $this->BelongsTo('App\Models\Snomed\SnomedConcept', 'conceptid','id');
   }

    /**
    * This method to link snomed concept 
    * with relation ship
    *
    */
   public function descriptionThroughRelationshipSource() 
   {
     return $this->hasMany('App\Models\Snomed\SnomedRelationship', 'sourceid','conceptid');
   }

   public function getdescription($term, $status, $type, $limit) 
   {
       $result =  \DB::table('description_f')
                  ->where('active', $status)
                  ->whereRaw("lower(term) like '".strtolower($term)."%'")
                  ->where('typeid', $type);
        if ($limit == false) {
       
            $result  = $result->limit($limit);
       
        } 
        $result->get();            
       return $result;
                  
   }



  
}
