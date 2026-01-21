<?php

namespace App\Http\Controllers\fhirformate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Machine\MachineData;
use App\Models\Fhir\FhirFormatedValues;
use App\Models\Fhir\FhirJsonSchema;
use App\Models\Baby;
/**
 * This controller to formate 
 * the monitor data 
 * @author Manikandan M
 */
class MonitorFormatController extends Controller
{
    
    /**
     * This for machine data instance 
     *
     *@var $machine_data 
     */
	  public $machine_data;

	/**
	 * 
	 * @var $machine_name 
	 *
	 */ 
	private $machine_name = 'MINDRAY_N-SERIES';

    /**
     * This for prescription key id 
     *
     * @var $prescription_key_id 
     */  
    public $prescription_key_id = array(0=>"IVDI",
                                          1=>"OIVD",
                                          2=>"OIVI",
                                          3=>"GI");

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->machine_data        = new MachineData(); 

	}

    /**
     * This method to get formate  
     *
     * @param  $input type array 
     *
     * @return type bool
     */
     public function getformatfhir()
     {

        $patient_details = array();
        $received        = $this->machine_data->where('is_parsed', false)
                                              ->where('device_type', $this->machine_name)
        									  ->limit(10000)->get();
        $resource_data   = array();

        foreach ($received as $received_key => $received_value) {

           // $received_data = json_decode($received_value->received)->data;
            $received_data = json_decode($received_value->received);
            //$received_data = json_decode($received_data[0]);

            foreach ($received_data->entry as $entry_key => $entry_value) {


                if ($entry_value->resource->resourceType == 'Patient') {
                    $resource_data['patient'] = $this->patientFormat($entry_value->resource, $entry_value->resource->resourceType);
                }

                if ($entry_value->resource->resourceType == 'Location') {

                    $resource_data['location'] = $this->locationFormat($entry_value->resource);
                }

                if ($entry_value->resource->resourceType == 'Device') {

                    $resource_data['device'] = $this->deviceFormat($entry_value->resource);
                }

                if ($entry_value->resource->resourceType == 'Observation') {
                    $resource_data['observation'] = $this->observationFormat($entry_value->resource);
                    $resource_data1  =  collect($resource_data)->collapse()->toArray();
                    
                    FhirFormatedValues::create($resource_data1)->id;

                    $prescription_key_id = \SiteHelpers::prescriptionKeyId();

                    if (strpos($resource_data1['mean'], 'infusing')) {

                        $other_iv_durgs['is_send'] = 5;

                        $unqiueId = $this->prescription_key_id[0];
                        $resource_id = substr($resource_data1['advice_id'], 0, strlen($unqiueId));
                        if ($resource_id == $unqiueId) {
                            $id = substr($resource_data1['advice_id'], strlen($unqiueId));
                            \DB::table('nurse_iv_infusion')->where('id', $id)->update($other_iv_durgs);
                        }

                        $unqiueId = $this->prescription_key_id[1];
                        $resource_id = substr($resource_data1['advice_id'], 0, strlen($unqiueId));
                        if ($resource_id == $unqiueId) {
                            $id = substr($resource_data1['advice_id'], strlen($unqiueId));
                            \DB::table('nurse_other_iv_drugs')->where('id', $id)->update($other_iv_durgs);
                        }

                        $unqiueId = $this->prescription_key_id[2];
                        $resource_id = substr($resource_data1['advice_id'], 0, strlen($unqiueId));
                        if ($resource_id == $unqiueId) {
                            $id = substr($resource_data1['advice_id'], strlen($unqiueId));
                            \DB::table('nurse_other_iv_infusion')->where('id', $id)->update($other_iv_durgs);
                        }

                        $unqiueId = $this->prescription_key_id[3];
                        $resource_id = substr($resource_data1['advice_id'], 0, strlen($unqiueId));
                        if ($resource_id == $unqiueId) {
                            $id = substr($resource_data1['advice_id'], strlen($unqiueId));
                            \DB::table('nurse_glucose_intake')->where('id', $id)->update($other_iv_durgs);
                        }
                    }

                    if (strpos($resource_data1['mean'], 'pause')) {

                        $other_iv_durgs['is_send'] = 4;

                        $unqiueId = $this->prescription_key_id[0];
                        $resource_id = substr($resource_data1['advice_id'], 0, strlen($unqiueId));
                        if ($resource_id == $unqiueId) {
                            $id = substr($resource_data1['advice_id'], strlen($unqiueId));
                            \DB::table('nurse_iv_infusion')->where('id', $id)->update($other_iv_durgs);
                        }

                        $unqiueId = $this->prescription_key_id[1];
                        $resource_id = substr($resource_data1['advice_id'], 0, strlen($unqiueId));
                        if ($resource_id == $unqiueId) {
                            $id = substr($resource_data1['advice_id'], strlen($unqiueId));
                            \DB::table('nurse_other_iv_drugs')->where('id', $id)->update($other_iv_durgs);
                        }

                        $unqiueId = $this->prescription_key_id[2];
                        $resource_id = substr($resource_data1['advice_id'], 0, strlen($unqiueId));
                        if ($resource_id == $unqiueId) {
                            $id = substr($resource_data1['advice_id'], strlen($unqiueId));
                            \DB::table('nurse_other_iv_infusion')->where('id', $id)->update($other_iv_durgs);
                        }

                        $unqiueId = $this->prescription_key_id[3];
                        $resource_id = substr($resource_data1['advice_id'], 0, strlen($unqiueId));
                        if ($resource_id == $unqiueId) {
                            $id = substr($resource_data1['advice_id'], strlen($unqiueId));
                            \DB::table('nurse_glucose_intake')->where('id', $id)->update($other_iv_durgs);
                        }
                    }

                    if (strpos($resource_data1['mean'], 'KVO')) {

                        $other_iv_durgs['is_send'] = 7;

                        $unqiueId =$this->prescription_key_id[0];
                        $resource_id = substr($resource_data1['advice_id'], 0, strlen($unqiueId));
                        if ($resource_id == $unqiueId) {
                            $id = substr($resource_data1['advice_id'], strlen($unqiueId));
                            \DB::table('nurse_iv_infusion')->where('id', $id)->update($other_iv_durgs);
                        }

                        $unqiueId = $this->prescription_key_id[1];
                        $resource_id = substr($resource_data1['advice_id'], 0, strlen($unqiueId));
                        if ($resource_id == $unqiueId) {
                            $id = substr($resource_data1['advice_id'], strlen($unqiueId));
                            \DB::table('nurse_other_iv_drugs')->where('id', $id)->update($other_iv_durgs);
                        }

                        $unqiueId = $this->prescription_key_id[2];
                        $resource_id = substr($resource_data1['advice_id'], 0, strlen($unqiueId));
                        if ($resource_id == $unqiueId) {
                            $id = substr($resource_data1['advice_id'], strlen($unqiueId));
                            \DB::table('nurse_other_iv_infusion')->where('id', $id)->update($other_iv_durgs);
                        }

                        $unqiueId = $this->prescription_key_id[3];
                        $resource_id = substr($resource_data1['advice_id'], 0, strlen($unqiueId));
                        if ($resource_id == $unqiueId) {
                            $id = substr($resource_data1['advice_id'], strlen($unqiueId));
                            \DB::table('nurse_glucose_intake')->where('id', $id)->update($other_iv_durgs);
                        }
                    }

                }
                
            }

           $machine_log = $this->machine_data->find($received_value->id);
           $machine_log->is_parsed = true;
           $machine_log->save();

        }

        return true;
    } 

    /**
     * This method to get formate  
     *
     * @param  $patient_details type array 
     *
     * @return type array
     */
    public function patientFormat($patient_details, $resourceType)
    {


        $patient = array();

        if (isset($patient_details->name)) {
            $temp_name = '';
            foreach ($patient_details->name as $name_key => $name_value) {

                $temp_given      = isset($name_value->given) ?   $temp_name.' '.implode(' ', $name_value->given)  : ''; 
                $temp_family     = isset($name_value->family) ?  $temp_name.' '.implode(' ', $name_value->family) : ''; 
                $temp_suffix     = isset($name_value->suffix) ?  $temp_name.' '.implode(' ', $name_value->suffix) : ''; 
                $patient['name'] = $temp_given.' '.$temp_family;
                
            }
        }

        if (isset($patient_details->gender)) {

          $patient['gender'] = null;
          if(trim($patient_details->gender) == 'M') {
            $patient['gender'] = 'Male';
          } elseif(trim($patient_details->gender) == 'F') {
            $patient['gender'] = 'Female';
          }

        }

        $pattern = $this->patternFormate('date');
        if (isset($patient_details->birthDate) && preg_match($pattern, $patient_details->birthDate)) {
            $patient['birthdate'] = trim($patient_details->birthDate);

        }

        if (isset($patient_details->identifier)) {

            foreach ($patient_details->identifier as $identifier_key => $identifier_value) {
                $patient['mrn']= $identifier_value->value;
            }
        }

        return $patient;

    }

    /**
     * This method to get formate  
     *
     * @param  $patient_details type array 
     *
     * @return type array
     */
    public function locationFormat($location_details)
    {
        $location  = array();

        if (isset($location_details->identifier)) {

            foreach ($location_details->identifier as $identifier_key => $identifier_value) {

                if ($identifier_value->system == 'VisitType') {
                    $location['visit_type'] = $identifier_value->value;
                }
                
                if ($identifier_value->system == 'Date') {
                    $location['date'] = $identifier_value->value;
                }

                if ($identifier_value->system == 'Visit Number') {
                    $location['ip_number'] = $identifier_value->value;
                }

                if ($identifier_value->system == 'Ward') {
                    $location['ward'] = $identifier_value->value;
                }

                if ($identifier_value->system == 'Room') {
                    $location['room'] = $identifier_value->value;
                }

                if ($identifier_value->system == 'Bed') {
                    $location['bed'] = $identifier_value->value;
                }
            }

        }

        return $location;

    }

    /**
     * This method to get formate  
     *
     * @param  $patient_details type array 
     *
     * @return type array
     */
    public function deviceFormat($device_details)
    {
        $device  = array();


        $device['model']        = isset($device_details->model) ? $device_details->model : '';
        $device['owner']        = isset($device_details->owner->reference) ? $device_details->owner->reference : '';
        $device['patient']      = isset($device_details->patient->reference) ? $device_details->patient->reference : '';
        $device['manufacturer'] = isset($device_details->manufacturer) ? $device_details->manufacturer : '';
        $device['asset_number'] =  $device['start_time'] =  $device['end_time'] = $device['from_id'] =  $device['to_id'] = '';

        if (isset($device_details->identifier)) {

            $asset_number = explode(':', collect($device_details->identifier)->where('system', 'AssetNumber')->pluck('value')->first());
           $device['asset_number'] =  $asset_number[0];
           $device['start_time']   =  collect($device_details->identifier)->where('system', 'messageAppResponseStartTime')->pluck('value')->first();
           $device['end_time']     =  collect($device_details->identifier)->where('system', 'messageAppResponseEndTime')->pluck('value')->first();
           $device['from_id']      =  collect($device_details->identifier)->where('system', 'messageEventStartId')->pluck('value')->first();
           $device['to_id']        =  collect($device_details->identifier)->where('system', 'messageEventGroupProcessId')->pluck('value')->first();
           $device['advice_id']    = isset($asset_number[1]) ? $asset_number[1] : null ;
        }

        return $device;

    }

    /**
     * This method to get device identifier
     * 
     * @param $identifier type 
     *
     * @return type array 
     */


    /**
     * This method to get formate  
     *
     * @param  $patient_details type array 
     *
     * @return type array
     */
    public function observationFormat($observation_details)
    {
        $observation = array();

        foreach ($observation_details as $observation_details_key => $observation_details_value) {

            if ($observation_details_key == 'identifier') {
                foreach ($observation_details_value as $details_key => $details_value) {
                
                    if (isset($details_value->system) && $details_value->system == 'LOW') {
                        $observation['low'] = $details_value->value;
                    }

                    if (isset($details_value->system) && $details_value->system == 'FIRST_QUARTILE') {
                        $observation['first_quartile'] = $details_value->value;
                    }

                    if (isset($details_value->system) && $details_value->system == 'MEAN') {
                        $observation['mean'] = $details_value->value;
                    }

                    if (isset($details_value->system) && $details_value->system == 'LAST_QUARTILE') {
                        $observation['last_quartile'] = $details_value->value;
                    }

                    if (isset($details_value->system) && $details_value->system == 'HIGH') {
                        $observation['close'] = $details_value->value;
                    }

                    if (isset($details_value->system) && $details_value->system == 'PUMP_VALUE') {
                        $observation['mean'] = $details_value->value;
                    }
                    
                }

            }

            if ($observation_details_key == 'code') {

                foreach ($observation_details_value->coding as $coding_key => $coding_value) {

                    $observation['loinc_code']  = isset($coding_value->code) ? str_replace(';', '|', $coding_value->code) : '';
                    $observation['display']     = isset($coding_value->display) ?  $coding_value->display : '';
                    $observation['snomed_ct']   = isset($coding_value->code) ?  preg_replace('/[;]/','|',trim($coding_value->display)) : '';
                    $observation['snomed_ct']   = isset($observation['snomed_ct']) ?  preg_replace('/[\s]/','',trim($observation['snomed_ct'])) : '';
                    $observation['snomed_code'] = isset($coding_value->code) ?  preg_replace('/[A-Z,a-z,\s,\/,|,%,-,;,(,)]/', '', trim($coding_value->display)) : '';

                }

            }

            if ($observation_details_key == 'valueQuantity') {

                $observation['value_quality_unit']  = isset($observation_details_value->unit) ? $observation_details_value->unit : '';
            }


            if ($observation_details_key == 'status') {
                $observation['status']  =  $observation_details_value;

            }

            if ($observation_details_key == 'issued') {
                $observation['issued']  = $observation_details_value;
            }
        

        }

        return $observation;

    }

    /**
     * This method to get pattern 
     * formate 
     * @param $patternType 
     *
     * @return string
     */
    public function patternFormate($patternType) 
    {
        $fhir_date = FhirJsonSchema::get_resource_schema($patternType);
        $pattern = '/'.$fhir_date->pattern.'/';
        $pattern = str_replace('#', '$', $pattern);
        return $pattern;

    }

    /**
     * This method to update prescription status
     */
    public function prescriptionStatus($advice_id, $prescription, $other_iv_durgs)
    {
        foreach ($prescription as $key => $unqiueId) {
            $resource_id = substr($advice_id, 0, strlen($unqiueId));
            if ($resource_id == $unqiueId) {
                $id = substr($advice_id, strlen($unqiueId));
                \DB::table($key)->where('id', $id)->update($other_iv_durgs);
            }
        }
    }

    /**
     * This method to list monitor 
     * values
     *
     * @param $babyId  type integer
     * @param $admissionId type integer  
     * 
     */
    public function getMonitordetails($babyId, $admissionId, Request $request)
    {
      $babyId = \SiteHelpers::decrypt_id($babyId);
      $admissionId = \SiteHelpers::decrypt_id($admissionId);

      $baby_details   = Baby::find($babyId);
  
      $limit = 50;
      
      if (!empty($request->input('limit'))) {
        $request->session()->put('limit', $request->input('limit'));
        $limit =  $request->session()->get('limit');
      } elseif ($request->session()->has('limit')) {
        $limit =  $request->session()->get('limit');
      }

      $search_txt = '';
      if (!empty($request->input('search_txt'))) {
        $search_txt = $request->input('search_txt');
      }

      //Initialize the record sorting key and order  
      $order['sortby']    = 'result_date_time';
      $order['sortorder'] = 'desc';

      //set the records sorting key and order  
      if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {
        $order['sortby']     = \SiteHelpers::decrypt_id($request->input('sortby'));
        $order['sortorder']  = $request->input('sortorder');
      }

      $observation        = FhirFormatedValues::montiorData($babyId, $admissionId, $request->input('page'), $limit, $search_txt, $order);
      $monitorObservation = $observation['result'];

      $getTotal   = $observation['getTotal'];   
      $total      = $observation['total'];

      $page                   = !empty($request->input('page')) ? $request->input('page') : 1;
      $pagecount              = (!empty($search_txt)) ? ceil($total/$limit) : ceil($total/$limit);
      $pagination['total']    = $total;
      $pagination['start']    = (($page-2) < 1) ? 1 : ($page-2);
      $pagination['end']      = ($pagecount < ($page+3)) ? $pagecount :   ($page+3);
      $pagestart              = $total != 0 ? ($page <= 1) ? $page : ($page-1)*$limit + 1 : 0;
      $pagerecords            = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page*$limit;
      $pagination['limit']    = array($pagestart, $pagerecords);
      $pagination['limits']   = $limit;
      $pagination['previous'] = (($page-1) < 1) ? 1 : ($page-1);
      $pagination['next']     = ($pagecount < ($page+1)) ? $pagecount :   ($page+1);

      $navigate['main_nav'] = 'ward_management';
      $navigate['sub_nav']  = 'ward_management';

      return view('ward.monitor_list',compact('monitorObservation','baby_details', 'pagination', 'babyId', 'admissionId', 'search_txt', 'getTotal', 'order', 'navigate'));               
    }
}
