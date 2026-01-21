<?php

namespace App\Http\Controllers\Syringepump;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Baby;
use App\Models\Nurse\SyringePumpAdmisson;
use App\Models\Ward\BedLog;
use App\Models\IpNumber;
use App\Models\Masters\Bed;
use App\Models\Fhir\FhirFormatedValues;
use Carbon\Carbon;
use App\Events\WardEvent;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Http\Controllers\Fhir\PrescriptionToMirthController;

class SyrangePumpController extends Controller
{

    /**
     * controller constructor
     *
     */
    public function __construct()
    {
        $this->time_zone = env('TIME_ZONE');
    }
   

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('syringepump.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $list = Baby::ListData();
        $baby_list = array();

        foreach ($list as $key => $value) {
          if($value->BMrNo != '') {
            $baby_list[$value->BMrNo] = $value->BabyName.'-'.$value->BMrNo;
          }
        }

         $transfer_status = \DeviceHelpers::transferStatus();
         $syringepumpCreate = view('syringepump.create', compact('baby_list', 'transfer_status'))->render();
         return \Response::json(['syringepumpCreate'=>$syringepumpCreate], 200);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(count(explode('-',$id)) == 2) {
             $id            = explode('-', $id);
             $baby_id       = $id[0]; 
             $admission_id  = $id[0];
        } else {
            return Response::json(['message'=>'Invalid id passed'],200);
        }
        $babylist  = Baby::find($baby_id);
        $ip_number = IpNumber::where('baby_id',$baby_id)->orderby('id','desc')->first();    


        if (isset($babylist->BMrNo) && isset($ip_number->ip_number)) {
            //getting snomed code with help of slug
          $snomed_code['DRUG_NAME']       = \SiteHelpers::getConfigSettings('DRUG_NAME_SNOMED_CT');
          $snomed_code['INFUSED']         = \SiteHelpers::getConfigSettings('INFUSED_SNOMED_CT');
          $snomed_code['REMAINING']       = \SiteHelpers::getConfigSettings('REMAINING_SNOMED_CT');
          $snomed_code['VTBI']            = \SiteHelpers::getConfigSettings('VTBI_SNOMED_CT');
          $snomed_code['RATE']            = \SiteHelpers::getConfigSettings('RATE_SNOMED_CT');
          $snomed_code['RUNNING']         = \SiteHelpers::getConfigSettings('RUNNING_PRESSURE_SNOMED_CT');
          $snomed_code['PROGRAMME']       = \SiteHelpers::getConfigSettings('PROGRAMME_PRESSURE_SNOMED_CT');
          $resource['programme_pressure'] = FhirFormatedValues::getRunningSyringePump($babylist->BMrNo, $ip_number->ip_number);

          $list_drug_name       = $resource['programme_pressure']->where('snomed_code',$snomed_code['DRUG_NAME'])->toArray();
          $list_infused         = $resource['programme_pressure']->where('snomed_code',$snomed_code['INFUSED'] )->toArray();
          $list_drug_remaining  = $resource['programme_pressure']->where('snomed_code',$snomed_code['REMAINING'])->toArray();
          $list_drug_vtbi       = $resource['programme_pressure']->where('snomed_code',$snomed_code['VTBI'])->toArray();
          $list_drug_running    = $resource['programme_pressure']->where('snomed_code',$snomed_code['RUNNING'])->toArray();
          $list_drug_programe   = $resource['programme_pressure']->where('snomed_code',$snomed_code['PROGRAMME'])->toArray();

           $list_drug_name      = \SiteHelpers::re_arrange_array($list_drug_name);
           $list_infused        = \SiteHelpers::re_arrange_array($list_infused);
           $list_drug_remaining = \SiteHelpers::re_arrange_array($list_drug_remaining);
           $list_drug_vtbi      = \SiteHelpers::re_arrange_array($list_drug_vtbi);
           $list_drug_running   = \SiteHelpers::re_arrange_array($list_drug_running);
           $list_drug_programe  = \SiteHelpers::re_arrange_array($list_drug_programe);

           $drug_table = view('ward.syringe_pump', compact('list_drug_name','list_infused','list_drug_remaining','list_drug_vtbi','list_drug_running','list_drug_programe'))->render();
           return \Response::json(['data'=>$drug_table],200);
   
        } else {
          return \Response::json(['message'=>'Invalid id passed'],200);
   
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        if($input['slug']=='REMOVE_PUMP') {

            $baby_deitals = Baby::find($input['babyId']);
            $syringepump['baby_id']          = $input['babyId'];
            $syringepump['mother_id']        = isset($baby_deitals->MotherId) ? $baby_deitals->MotherId : null;
            $syringepump['admission_id']     = $input['admissionId'];
            $syringepump['admission_stauts'] = 4;
            SyringePumpAdmisson::create($syringepump);
            PrescriptionToMirthController::admission();

            $pump_condition['baby_id']      = $input['babyId'];
            $pump_condition['admission_id'] = $input['admissionId'];
            $pump_update['is_syringe_pump_connected'] = false;
            BedLog::where($pump_condition)->Update($pump_update);

            $event_input['admission_id'] = $input['admissionId'];
            $event_input['status'] = 'INDICATION';
            $event_input['indication_no'] = 3;
            $event_input['active'] = false;
            ErrorLogController::emergencyLogStat('Remove pump ' . json_encode($event_input));
            broadcast(new WardEvent($event_input))->toOthers();

        } elseif($input['slug']=='REMOVE_BED_PUMP') {

            $baby_deitals = Baby::find($input['babyId']);
            $syringepump['baby_id']          = $input['babyId'];
            $syringepump['mother_id']        = isset($baby_deitals->MotherId) ? $baby_deitals->MotherId : null;
            $syringepump['admission_id']     = $input['admissionId'];
            $syringepump['admission_stauts'] = 4;
            SyringePumpAdmisson::create($syringepump);
            PrescriptionToMirthController::admission();

            $pump_condition['baby_id']      = $input['babyId'];
            //$pump_condition['admission_id'] = $input['admissionId'];
            $pump_update['is_syringe_pump_connected'] = false;
            $pump_update['status'] = 'discharged';
            $pump_update['DateModified']    = Carbon::now($this->zone);
            $patient_log_status = BedLog::where($pump_condition)->get();
            if (count($patient_log_status) > 0) {
                BedLog::where($pump_condition)->Update($pump_update);
                $bed_log = BedLog::where($pump_condition)->orderby('id','desc')->first();
                Bed::where('id', $input['bedId'])->Update(['status'=>null]);  
            }else {

                $pump['baby_id']        = $input['babyId']; 
                $pump['admission_id']   = $input['admissionId'];
                $pump['status']         = 'discharged';
                $pump['DateModified']    = Carbon::now($this->zone);
                $pump['is_syringe_pump_connected'] = false;
                BedLog::create($pump);
                Bed::where('id', $input['bedId'])->Update(['status'=>null]);  
            }
            $discharged_log = array();
            $discharged_log['baby_id'] = $input['babyId'];
            $discharged_log['admission_id'] = $input['admissionId'];
            $discharged_log['discharged_at'] = Carbon::now($this->time_zone);

            \DB::table('discharged_log')->insert($discharged_log);  
           

        } elseif($input['slug'] == 'CONNECT_PUMP') {

            $baby_deitals = Baby::find($input['babyId']);
            $syringepump['baby_id']          = $input['babyId'];
            $syringepump['mother_id']        = isset($baby_deitals->MotherId) ? $baby_deitals->MotherId : null;
            $syringepump['admission_id']     = $input['admissionId'];
            $syringepump['admission_stauts'] = 0;
            SyringePumpAdmisson::create($syringepump);
            PrescriptionToMirthController::admission();

            $pump_condition['baby_id']      = $input['babyId'];
            $pump_condition['admission_id'] = $input['admissionId'];
            $pump_update['is_syringe_pump_connected'] = true;
            $pump_update['status'] = 'Occupied';
            $pump_update['DateModified'] = Carbon::now();
            BedLog::where($pump_condition)->Update($pump_update);
            $bed_log = BedLog::where($pump_condition)->orderby('id','desc')->first();
            Bed::where('id', $input['bedId'])->Update(['status'=>'Occupied']);

            $event_input['admission_id'] = $input['admissionId'];
            $event_input['status'] = 'INDICATION';
            $event_input['indication_no'] = 3;
            $event_input['active'] = true;
            ErrorLogController::emergencyLogStat('Connect pump ' . json_encode($event_input));
            broadcast(new WardEvent($event_input))->toOthers();

        }

       

        return \Response::json(['type'=>'success', 'message'=>'Baby disconnected from pump'], 200);

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
