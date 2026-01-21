<?php

namespace App\Http\Controllers\Fhir;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\DoctorMaster;
use App\Models\Masters\DepartmentMaster;
use App\Models\Masters\InvestigationMaster;

class MasterSyncController extends Controller
{
    /**
     * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		

	}


	public function getDoctorMaster(Request $request)
	{	
	    $input = $request->all();
        $machine_data['received'] = file_get_contents('php://input');
        $machine_entry = (array)json_decode($machine_data['received']);
        foreach ($machine_entry as $key => $value) {
        	$doctor['Name']    = $value->name; 
        	$doctor['type']    = '1';
        	$doctor['status']  = '1';
        	$doctor['code']    = $value->code;
        	$doctor['hms_key'] = null;
            $doctor_mas = DoctorMaster::where('hms_key', $doctor['hms_key'])->get();
            if (count($doctor_mas) < 1) {
                DoctorMaster::create($doctor);
            } else{

            } 

        }
        return \Response::json(['message'=>'doctors added successfully'],200);

	}         

	public function getDepartmentMaster(Request $request)
	{
        $machine_data['received'] = file_get_contents('php://input');
        $machine_entry = (array)json_decode($machine_data['received']);
         foreach ($machine_entry as $key => $value) {
        	$department['Name']    = $value->name; 
        	$department['Status']  = '1';
        	$department['code']    = $value->code;
        	$department['hms_key'] = $value->id;
            $department_mas = DepartmentMaster::where('hms_key',$department['hms_key'])->get();

            if (count($department_mas) < 1) {
               DepartmentMaster::create($department);
            }else {
                DepartmentMaster::where('hms_key', $department['hms_key'])
                                 ->Update($department);
            }

        }
        
        return \Response::json(['message'=>'department added successfully'],200);


	}

	public function getInvestigationMaster(Request $request)
	{
         $machine_data['received'] = file_get_contents('php://input');
         $machine_entry = (array)json_decode($machine_data['received']);
         foreach ($machine_entry as $key => $value) {
            $investigation['Name']    = $value->name; 
            $investigation['Status']  = "Active";
            $investigation['code']    = $value->code;
            $investigation['hms_key'] = null;
            $investigation_mas  = InvestigationMaster::where('hms_key', $investigation['hms_key'])->get(); 
            
            if(count($investigation_mas) < 1) {
               InvestigationMaster::create($investigation);
            }else {
                InvestigationMaster::where('hms_key', $investigation['hms_key'])
                                    ->Update($investigation);
            }

        }
        return \Response::json(['message'=>'Investigation added successfully'],200);

	}

}
