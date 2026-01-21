<?php

namespace App\Http\Controllers\Snomed;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SnomedConstants extends Controller
{

	const PRIMITIVE            = '900000000000074008';

	const SUFFICIENTLY_DEFINED = '900000000000073002';

  const SYNONYM              = '900000000000013009';

  const FSN                  = '900000000000003001';

   
   /**
    * this method to return defined constant 
    * 
    * @param $constants  
    *
    * @return string
    */
   public static function GetConstants($id) 
   {
   	   $current_object    = new \ReflectionClass(__CLASS__);
   	   $current_constants = $current_object->getConstants();
   	   
   	   return isset($current_constants[strtoupper($id)]) ? $current_constants[strtoupper($id)] : null;
   }
}
