<?php

namespace App\Models\Snomed;

use Illuminate\Database\Eloquent\Model;

class SnomedRelationship extends Model
{
     protected $table         = 'relationship_f';
     protected $primaryKey    = 'id';
     public    $timestamps    =  false;

    /**
    * This method to link snomed concept 
    * with relation ship
    *
    */
    public function descriptionBelongsToRelationshipSource() 
    {
     return $this->BelongsTo('App\Models\Snomed\SnomedDescription', 'conceptid','sourceid');
    }
}
