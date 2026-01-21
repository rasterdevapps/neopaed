<?php

namespace App\Models\Loinc;

use Illuminate\Database\Eloquent\Model;

class LoincMaster extends Model
{
   protected $table         = 'loinc';
   protected $primaryKey    = 'loinc_id';
   public    $timestamps    =  false;
   
   
}
