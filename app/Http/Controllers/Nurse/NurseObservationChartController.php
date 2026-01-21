<?php

namespace App\Http\Controllers\Nurse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Baby;
use App\Http\Controllers\Nurse\NurseChartPropertyController;
use App\Models\ChartConfigSetting;

/**
 * This controller create nurse chart 
 * details
 * @author Manikandan M  
 */

class NurseObservationChartController extends Controller 
{
    /**
     * @var $chartProperty
     *
     */
    public $chartProperty;

    /**
     * this class constrcutor
     *
     */
    public function __construct() 
    {
      
        $this->chartProperty = new NurseChartPropertyController();

    } 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
         
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
        $baby_details        =  Baby::find($id);
        $venitlator_details  =  ChartConfigSetting::getConfigSettings('VENTILATOR_PARAMETERS');
        $vitals_details      =  ChartConfigSetting::getConfigSettings('VITALS_PARAMETERS');

        $vitals_details      = collect(json_decode($vitals_details->code_values));       
        $venitlator_details  = collect(json_decode($venitlator_details->code_values));

        $vitals_details      = $vitals_details->chunk(3);       
        $venitlator_details  = $venitlator_details->chunk(4);

        return view('nurse_sheet.nurse_observation_chart', compact('baby_details','venitlator_details','vitals_details'));
    }

    /**
     * This method to get 
     * chart data 
     *
     *
     */
    public function getChartValues($mrn, $snomed_code, $ip_number ='', $key_name)
    {

        $temp_value          = ChartConfigSetting::getFhirObservation($mrn,$snomed_code);
        $venitlator_details  = ChartConfigSetting::getConfigSettings('VENTILATOR_PARAMETERS');
        $venitlator_details  = collect(json_decode($venitlator_details->code_values));
        $venitlator_detail   = $venitlator_details->where('parameter',$key_name)->toArray();


       
        if(count($temp_value) > 0) {
           foreach ($temp_value as $key => $value) {
            $temp_detils[$key_name] = $value->mean;
            $temp_detils['date']    = date('d-m-Y H:m',strtotime($value->issued));
            $result_value[]=$temp_detils;               
           }      
        }

        if(isset($result_value) &&count($result_value) > 0)  {
           return  \Response::json(['result'=>$result_value],200);
        } else {
           return  \Response::json(['message'=>'No result'],200);
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
        //
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
