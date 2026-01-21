<?php

namespace App\Http\Controllers\infusion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Baby;
use App\Models\Nurse\SyringePumpAdmisson;
use App\Models\Ward\BedLog;
use App\Models\IpNumber;
use App\Models\Fhir\FhirFormatedValues;
use App\Http\Controllers\Fhir\PrescriptionToMirthController;

class InfusionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

          $snomed_code['DRUG_NAME']       = \SiteHelpers::getConfigSettings('DRUG_NAME_SNOMED_CT');
          $snomed_code['INFUSED']         = \SiteHelpers::getConfigSettings('INFUSED_SNOMED_CT');
          $snomed_code['REMAINING']       = \SiteHelpers::getConfigSettings('REMAINING_SNOMED_CT');
          $snomed_code['VTBI']            = \SiteHelpers::getConfigSettings('VTBI_SNOMED_CT');
          $snomed_code['RATE']            = \SiteHelpers::getConfigSettings('RATE_SNOMED_CT');
          $snomed_code['RUNNING']         = \SiteHelpers::getConfigSettings('RUNNING_PRESSURE_SNOMED_CT');
          $snomed_code['PROGRAMME']       = \SiteHelpers::getConfigSettings('PROGRAMME_PRESSURE_SNOMED_CT');
          $resource['programme_pressure'] = FhirFormatedValues::getRunningInfusionPump($babylist->BMrNo, $ip_number->ip_number);

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

        $baby_deitals = Baby::find($input['babyId']);
        $infusion_pump['baby_id']          = $input['babyId'];
        $infusion_pump['mother_id']        = isset($baby_deitals->MotherId) ? $baby_deitals->MotherId : null;
        $infusion_pump['admission_id']     = $input['admissionId'];
        $infusion_pump['admission_stauts'] = 4;
        SyringePumpAdmisson::create($infusion_pump);
        PrescriptionToMirthController::admission();
        
        $infusion_pump_conditon['baby_id']      = $input['babyId'];
        $infusion_pump_conditon['admission_id'] = $input['admissionId'];
        $infusion_pump_update['is_infusion_pump_connected'] = false;
        BedLog::where($infusion_pump_conditon)->Update($infusion_pump_update);

        return \Response::json(['type'=>'success', 'message'=>'baby disconnected from pump'], 200);
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
