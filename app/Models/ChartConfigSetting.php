<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartConfigSetting extends Model
{
	/**
	 * This method to get congfig settings of  
	 *
	 * @param $slug 
	 */
    public static function getConfigSettings($slug)
    {
    	return \DB::table('config_settings')
                  ->select('code_values')
                  ->where('slug_code', $slug)
                 ->first();
    }

    /**
	 * This method to get observation values
	 *
	 * @param $mrn 
	 * @param $snomed_code
	 */
    public static function getFhirObservation($mrn, $snomed_code)
    {
    	return \DB::table('fihr_formated_values')
                   ->where('mrn', $mrn)
                   ->where('snomed_code',$snomed_code)
                   ->get();
    }
}
