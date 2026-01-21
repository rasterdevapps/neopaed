<?php

namespace App\Http\Controllers\Fhir;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Machine\MachineDataFormter;
use Carbon\Carbon;


class FhirBackUpController extends Controller
{
    public function fhirInterfaceClean()
    {
    	$end_date     = Carbon::now(env('TIME_ZONE'))->subDay();
    	$start_date   = Carbon::now(env('TIME_ZONE'))->subMonth(2);
    	$result       = MachineDataFormter::whereRaw("received_datetime::date BETWEEN '".date('Y-m-d',strtotime($start_date))."' AND '".date('Y-m-d', strtotime($end_date))."'")
    				                      ->delete();	
    	return \Response::json(['message'=>'success'],200);			                      

    }
}
