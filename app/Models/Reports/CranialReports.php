<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CranialReports extends Model
{
   
   public static function get_lists($input) 
   {
         $results = DB::table('baby')
	        		  ->select('baby.BMrNo', 'baby.BabyName', 'baby.Gestation', 'baby.BirthWeight')
	                  ->addSelect('baby.Sex', 'baby.DOB')
	                  ->addSelect('ultra_sound.TestDate', 'ultra_sound.Impression', 'ultra_sound.SeenBy')
                      ->join('ultra_sound', 'ultra_sound.BabyId', '=', 'baby.BabyId')
                      ->where('baby.IsDeleted', 0)
                      ->where('ultra_sound.IsDeleted', 0);

                    if (isset($input['StartDate']) && $input['StartDate']) {
					  $results = $results->where('ultra_sound.TestDate', '>=', date('Y-m-d', strtotime($input['StartDate'])));
				    }

			        if (isset($input['EndDate']) && $input['EndDate']) {
				    	$results = $results->where('ultra_sound.TestDate', '<=', date('Y-m-d', strtotime($input['EndDate'])));
				    }

				    if (isset($input['Sex']) && $input['Sex']) {
				    	$results = $results->where('baby.Sex', $input['Sex']);
				    }

				    if (isset($input['birth_status']) && $input['birth_status']) {
	                    $results = $results->where('baby.BirthStatus', $input['birth_status']);
				    }

				    if (isset($input['SeenBy']) && $input['SeenBy']) {
				    	 $results = $results->where('ultra_sound.SeenBy', $input['SeenBy']);
				    }

                    $results = $results->orderBy('baby.BabyId', 'desc')->get(); 

     return $results;
       
   }	
}
