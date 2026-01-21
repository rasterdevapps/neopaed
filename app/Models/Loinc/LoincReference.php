<?php

namespace App\Models\Loinc;

use Illuminate\Database\Eloquent\Model;

class LoincReference extends Model
{
    protected $table         = 'loinc_reference';
    protected $primaryKey    = 'loinc_reference_id';
    public    $timestamps    =  false;

    public function loincMaster() 
    {
    	return $this->hasOne('App\Models\Loinc\LoincMaster', 'loinc_id','loinc_source_id');
    }
   
}
