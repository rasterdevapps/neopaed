<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;

class EchoReports extends Model
{
  
  public static function get_lists($input) 
  {


    $results = \DB::table('baby')
                  ->select('baby.BMrNo', 'baby.BabyName', 'baby.Gestation', 'baby.BirthWeight')
                  ->addSelect('baby.Sex', 'baby.DOB')
                  ->addSelect('echo_cardio.TestDate', 'echo_cardio.Outcome', 'echo_cardio.SeenBy')
                  ->join('echo_cardio', 'baby.BabyId', '=', 'echo_cardio.BabyId')
                  ->where('baby.IsDeleted', 0)
                  ->where('echo_cardio.IsDeleted', 0);

	                if (isset($input['StartDate']) && $input['StartDate']) {
					  $results = $results->where('echo_cardio.TestDate', '>=', date('Y-m-d', strtotime($input['StartDate'])));
				    }

			        if (isset($input['EndDate']) && $input['EndDate']) {
				    	$results = $results->where('echo_cardio.TestDate', '<=', date('Y-m-d', strtotime($input['EndDate'])));
				    }

				    if (isset($input['Sex']) && $input['Sex']) {
				    	$results = $results->where('baby.Sex', $input['Sex']);
				    }

				    if (isset($input['birth_status']) && $input['birth_status']) {
	                    $results = $results->where('baby.BirthStatus', $input['birth_status']);
				    }

				    if (isset($input['SeenBy']) && $input['SeenBy']) {
				    	 $results = $results->where('echo_cardio.SeenBy', $input['SeenBy']);
				    }

                $results = $results->orderBy('baby.BabyId', 'desc')->get();

     return $results;
  }
}
