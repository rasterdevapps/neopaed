<?php
namespace App\Http\library;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
/**
 * This Helper will support generate the forms dynamicaly  
 * This class has global access can access any where in the application 
 * better way of use is call by self method .
 *
 * @author Manikandan M
 */
class DeviceHelpers 
{
  /**
   * This method to get message 
   * type
   *
   * @param $id type integer
   *
   */
   public static function transferStatus($id = '')
   {
   	   $transfer_status = array('0'=>'Baby Admit',
   	   	                      '1'=>'Baby Transfer',
   	   	                      '2'=>'Update Information',
   	   	                      '3'=>'Baby Discharge');
   	   return  !empty($id) ? $transfer_status[$id] : $transfer_status;
   	
   }	
  
  /**
   * This method to get message 
   * type
   *
   * @param $messageType
   *
   */
   public static function messageType($id = '')
   {
      $messageType = array(  '0'=>'A01',
      	                    '1'=>'A02',
      	                    '2'=>'A02',
      	                    '3'=>'A03');
      return !empty($id) ? $messageType[$id] : $messageType;

   }
  
  /**
   * This method to get message 
   * type
   *
   * @param $ward_id
   * @param $room_id
   * @param $bed_id
   */
   public static function getbindBaby($ward_id, $room_id, $bed_id, $request_id)
   {
        $baby_details = \DB::table('patient_bed_log')
                            ->where(['ward_id'=> $ward_id, 'room_id'=>$room_id , 'bed_id'=>$bed_id])
                            ->orderby('id', 'desc')
                            ->first();
         $baby_details = (array) $baby_details;                   


     return isset($baby_details[$request_id]) ? $baby_details[$request_id] : null;
   }

   /**
    * This data to get 
    * deivce list
    *
    */
    public static function getdeviceList($id = '')
    {
      $device = array('MONITOR'       => 'Monitor', 
                      'SYRINGE_PUMP'  => 'Syringe Pump', 
                      'INFUSION_PUMP' => 'Infusion Pump', 
                      'VENTILATOR'    => 'Vendilator');
      return !empty($id) ? $device[$id] : $device;  
    }
    
    /**
     * This method to get device 
     * name based status 
     * @param $babyMrn type number
     * @param $visitNumber type number
     *
     * @return array
     */
    public static function getMachineStatus($babyMrn, $visitNumber)
    {
      $results = \DB::table('interface_machine_status')
                     ->where('mrn', $babyMrn)
                     ->where('visit_number', $visitNumber)
                     ->whereBetween('date_time', [Carbon::now()->subMinutes(10), Carbon::now()])
                     ->get();
      return $results;                  

    }

    /**
     * This method to get device 
     * name based status 
     * @param $mode_snomed_ct type number
     *
     * @return array
     */
    public static function getVendilationMode($id, $machineName = 'SLE6000')
    {
        $mode   = array();
        if ($machineName == 'SLE6000'){
          $mode["0"]   = "CPAP";
          $mode["1"]   = "CMV";
          $mode["2"]   = "PTV";
          $mode["3"]   = "SIMV";
          $mode["4"]   = "HFOV";
          $mode["5"]   = "HFOV + CMV"; 
          $mode["7"]   = "PSV";
          $mode["9"]  = "nCPAP (D)";
          $mode["10"]  = "NIPPV (D)";
          $mode["11"]  = "NIPPV Tr";
          $mode["12"]  = "NHFOV (D)";
          $mode["13"]  = "NCPAP (S)"; 
          $mode["14"]  = "DUOPAP";
          $mode["16"]  = "High Flow O2"; 
          $mode["17"]  = "Standby"; 
          $mode["30"]  = ""; 
        } elseif($machineName == 'SLE5000') {
          $mode["0"]  = "CPAP";
          $mode["1"]  = "CMV";
          $mode["3"]  = "SIMV";
          $mode["4"]  = "HFOV";
          $mode["30"]  = "Ventilation OFF"; 
          $mode["31"] = "PTV";
          $mode["32"] = "PSV";
      }
      return (isset($mode[$id])) ? $mode[$id] : $mode; 
    }

    /**
     * This method to get device 
     * name based status 
     *
     * @return array
     */
    public static function getVTVStatus($code) {

       return ($code == '255') ? true :false;
    }

    /**
     * This method get machine
     * data
     *
     * @param $baby_mrn
     * @param $baby_visite
     * 
     */
     public static function getAssetDetails($baby_id, $baby_visite) 
     {


        // $result =  \DB::table('fihr_formated_values')
        //                ->where('mrn',$baby_mrn)
        //                ->where('model', '!=', 'MINDRAY_N-SERIES')
        //                ->where('model', '!=', 'MONITOR')
        //                ->where('model', 'not like', '%pump-type%')
        //                ->where('model','!=', '')
        //                ->where('model', '!=', 'Manual Calculation')
        //                ->orwhere('model', 'SLE6000')
        //                ->orwhere('model', 'SLE5000')
        //                ->orderby('id', 'desc')
        //                ->first();


        $result =  \DB::table('emr_ventilator_values')
                       ->select('emr_ventilator_values.*')
                       ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_ventilator_values.log_hdr_id')
                       ->where('emr_log_hdr.baby_id',$baby_id)
                       ->orderby('id', 'desc')
                       ->first();
        if(isset($result->device_id)) {                

              $assetNumber = explode(':', $result->device_id);
            if (count($assetNumber) == 4) {

              $vtvStatus   = self::getVTVStatus($assetNumber[3]);

              if (isset($result->model)) {

                if (($result->model == 'SLE6000' || $result->model == 'SLE5000') && isset($assetNumber[2]) && $vtvStatus == true) {
                    $vendilationMode = self::getVendilationMode($assetNumber[2], $result->model);

                    if($vendilationMode != 'High Flow O2') {

                       return $vendilationMode.'+'.'VTV'; 
                    }else{

                       return $vendilationMode; 
                    }

                } elseif(($result->model == 'SLE6000' || $result->model == 'SLE5000')  && isset($assetNumber[2]) && $vtvStatus==false) {

                    $vendilationMode = self::getVendilationMode($assetNumber[2], $result->model);
                    return $vendilationMode;
                }  

              }
              
            }
        }
        return false;           
       
     }

/**
      *  This method to get mode lists
      *
      * @param $baby_mrn
      * @param $baby_visite
      * @return array of object
      */
     public static function getModeList($baby_id, $baby_visite)
     {
        $modeList = array();

        // $result1 =  \DB::table('fihr_formated_values')
        //                 ->select('asset_number', 'model', 'issued')
        //                 ->where('mrn',$baby_mrn)
        //                 ->where('model', 'SLE5000')
        //                 ->orderby('issued', 'desc')
        //                 ->get()->toArray();

        // $result2 =  \DB::table('fihr_formated_values')
        //                 ->select('asset_number', 'model','issued','display')
        //                 ->where('mrn',$baby_mrn)
        //                 ->where('model', 'SLE6000')
        //                 ->orderby('issued', 'desc')
        //                 ->get()->toArray();
        $result =  \DB::table('emr_ventilator_values')
                       ->select('emr_ventilator_values.*')
                       ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_ventilator_values.log_hdr_id')
                       ->where('emr_log_hdr.baby_id',$baby_id)
                       ->orderby('result_date_time', 'desc')
                       ->get()->toArray(); 

        // $result = array_merge($result1, $result2); 



        foreach ($result as $key => $value) {
            if($value->device_id != '') { 
               $assetNumber = explode(':', $value->device_id);
               $vendilationMode = self::getVendilationMode($assetNumber[2], trim($value->device_model)); 
               if(!is_array($vendilationMode)) {
                 $vtvStatis = self::getVTVStatus($assetNumber[3]);
                if($vtvStatis == true) {
                    if($vendilationMode != 'High Flow O2') {
                      $modeList[$key]['mode']   = self::getVendilationMode($assetNumber[2], trim($value->device_model)).'+vtv';
                    } else {
                      $modeList[$key]['mode']   = self::getVendilationMode($assetNumber[2], trim($value->device_model));
                    }
                }else {
                  $modeList[$key]['mode']   = self::getVendilationMode($assetNumber[2], trim($value->device_model));

                }
                $modeList[$key]['issued']   = $value->result_date_time;

               }
            }          
        }

        $modeResult = array();
        $tempmodeList = collect($modeList)->unique('mode')->pluck('mode','mode');
        $modeList = collect($modeList);
        // $mode_poninter = 1;
        $mode_poninter = 0;
        foreach ($tempmodeList as $key => $value) {
            $startDate = $modeList->where('mode',$value)->first();
            $endDate   = $modeList->where('mode',$value)->last();
            $startDate = date('d-m-Y H:i',strtotime($startDate['issued']));
            $endDate   = date('d-m-Y H:i',strtotime($endDate['issued']));
            $value1    = self::customizedModeName($value); 
            // if(count($tempmodeList) == $mode_poninter && self::getVentilatorModeStatus($baby_mrn) == true) {
            //   $modeResult[$value]=$value1.' ('.$endDate.' To till now)';
            // } else {
            //   $modeResult[$value]=$value1.' ('.$endDate.' To '.$startDate.')';
            // }
            if($mode_poninter == 0 && self::getVentilatorModeStatus($baby_id) == true) {
              $modeResult[$value]=$value1.' ('.$endDate.' To till now)';
            } else {
              $modeResult[$value]=$value1.' ('.$endDate.' To '.$startDate.')';
            }
            $mode_poninter++;
        }
         return $modeResult;
     }
    

  /**
   * This method to get customized mode name
   *
   * @param $modeId
   * @return type string 
   */
  public static  function customizedModeName($modeId)
  {
    $modeName["cpap"]       = "CPAP";
    $modeName["cmv"]        = "CMV";
    $modeName["ptv"]        = "PTV";
    $modeName["simv"]       = "SIMV";
    $modeName["hfov"]       = "HFOV";
    $modeName["hfov + cmv"] = "HFOV+CMV";
    $modeName["psv"]        = "PSV";
    $modeName["O2"]         = "High Flow O2";
    $modeName["simv+vtv"]   = "SIMV+VTV";
    $modeName["ptv+vtv"]    = "PTV+VTV";
    $modeName["hfov+vtv"]   = "HFOV+VTV";
    $modeName["psv+vtv"]    = "PSV+VTV";
    return (!empty($modeId) && isset($modeName[$modeId])) ? $modeName[$modeId] : $modeId; 
  }

  /**
   * This method to get deivce status
   *
   * @param $babyMrn type
   * @param $deviceName
   */
   public static function getDeviceStatus($babyMrn, $deviceName)
   {
    
     switch ($deviceName) {
       case 'VENTILATOR':
         return self::getVentilatorStatus($babyMrn);
       break;
       case 'MONITOR':
         return self::getMonitorStatus($babyMrn);
       break; 
       
     }

   }

  /**
   * This method to get vendilation status
   * based on mrn
   * @param $mrn
   * @return array of object 
   */
   public static function getVentilatorStatus($babyMrn)
   {
      $startDate = Carbon::now(env('TIME_ZONE'))->subMinutes(120)->format('Y-m-d H:i');
      $endDate   = Carbon::now(env('TIME_ZONE'))->format('Y-m-d H:i');

      $result = \DB::table("interface_machine_status")
                   ->whereBetween('received_datetime', array($startDate, $endDate))
                   ->where("mrn", $babyMrn)
                   ->whereRaw("(device_name = 'SLE6000' or device_name = 'SLE5000')")
                   ->first();
                  //echo '<pre>';print_r($result);exit;

      return (count($result) > 0) ? true : false;     
   }

   /**
   * This method to get vendilation status
   * based on mrn
   * @param $mrn
   * @return array of object 
   */
   public static function getVentilatorModeStatus($babyMrn)
   {
      $startDate = Carbon::now(env('TIME_ZONE'))->subMinutes(60)->format('Y-m-d H:i');
      $endDate   = Carbon::now(env('TIME_ZONE'))->format('Y-m-d H:i');

      $result = \DB::table("interface_machine_status")
                   ->whereBetween('received_datetime', array($startDate, $endDate))
                   ->where("mrn", $babyMrn)
                   ->whereRaw("(device_name = 'SLE6000' or device_name = 'SLE5000')")
                   ->first();
      return (count($result) > 0) ? true : false;     
   }


   /**
   * This method to get monitor status
   * based on mrn
   * @param $mrn
   * @return array of object 
   */
   public static function getMonitorStatus($babyMrn)
   {
      $startDate = Carbon::now(env('TIME_ZONE'))->subMinutes(10)->format('Y-m-d H:i');
      $endDate   = Carbon::now(env('TIME_ZONE'))->format('Y-m-d H:i');
      
      $result = \DB::table("interface_machine_status")
                   ->whereBetween('received_datetime', array($startDate, $endDate))
                   ->where("mrn", $babyMrn)
                   ->where("device_name", 'MINDRAY_N-SERIES')
                   ->first();
       
      return (count($result) > 0) ? true : false;     
   }
    
   /**
   * This method to filter local snomed code map key based on ventilator mode
   * based on mrn
   * @param $mode string
   * @param $vtv_status string

   * @return array 
   */
   public static function getVentilatorvaluesByMode($mode, $vtv_status)
   {
       
      $vtv_status = explode(':', $vtv_status);
      if (isset($vtv_status[3])) {
        $vtv_status = $vtv_status[3];
      }
      // echo "<pre>"; print_r($vtv_status); 
      $return = array();

      /*if mode is SIMV*/
       if ($mode == 'SIMV') {
         $return = ['rate', 'peep', 'it_rate', 'it_rate_secound', 'pip_set', 'fio2', 'volume_targeting','map', 'delivered_tidal_volume'];
          if($vtv_status == '255') {
            array_push($return, 'pip_delivered'); 
            array_push($return, 'targeted_tidal_volume'); 
         }
       }

       /*if mode is HFOV*/
       if ($mode == 'HFOV') {
         $return = ['peep', 'fio2', 'volume_targeting','map','frequency','ie_r','p_amplitude','delivered_tidal_volume'];
         if ($vtv_status == '255') {
            array_push($return, 'ie_r'); 
            array_push($return, 'targeted_tidal_volume');  
         }
       }
       /*if mode is PTV*/
       if ($mode == 'PTV') {
         $return = ['rate','peep','pip_set', 'fio2', 'volume_targeting','map','delivered_tidal_volume'];
         if ($vtv_status == '255') {
            array_push($return, 'pip_delivered');
            array_push($return, 'targeted_tidal_volume');  
         }
       }

       /*if mode is PSV*/
       if ($mode == 'PSV') {
         
         $return = ['rate','peep','pip_set', 'fio2', 'volume_targeting', 'it_rate_secound', ' it_measured','delivered_tidal_volume'];
         if ($vtv_status == '255') {
            array_push($return, 'pip_delivered'); 
            array_push($return, 'targeted_tidal_volume');
         }
       }

       /*if mode is CPAP*/
       if ($mode == 'CPAP') {
         $return = ['peep', 'fio2'];
         
       }
       /*if mode is CMV*/
       if ($mode == 'CMV') {
         
       }
       /*if mode is HFOV + CMV*/
       if ($mode == 'HFOV + CMV') {
         
       }

       /*if mode is High Flow O2*/
       if ($mode == 'High Flow O2') {
         $return = ['fio2', 'volume_targeting', 'flow'];
       }

       /*if mode is NCPAP Dual Limp*/
       if ($mode == 'NCPAP (D)') {
         $return = ['peep', 'fio2'];  
       }

       /*if mode is NCPAP Dual Limp*/
       if ($mode == 'NIPPV (D)') {
         $return = ['rate','peep', 'pip_set', 'it_rate', 'fio2' ,'trigger_count','pip_delivered','respiratory_rate'];
       }

       /*if mode is NCPAP Tr*/
       if ($mode == 'NIPPV Tr' || $mode == 'nippv tr') {
         $return = ['rate','peep', 'pip_set', 'it_rate', 'fio2', 'pip_delivered', 'trigger_count','respiratory_rate'];
       }

       /*if mode is NHFOV*/
       if ($mode == 'NHFOV (D)') {
         $return = ['peep', 'p_amplitude', 'fio2', 'map', 'frequency'];
       }

       /*if mode is NCPAP (S)*/
       if ($mode == 'NCPAP (S)') {
         $return = ['peep', 'fio2'];
       }

       /*if mode is DUOPAP*/
       if ($mode == 'DUOPAP') {
         $return = ['rate', 'peep', 'it_rate', 'pip_set', 'fio2', 'pip_delivered', 'trigger_count','respiratory_rate'];
       }

       array_push($return, 'mode_of_ventilation', 'o2_status','delivered_fio2','air_entry_left','air_entry_right','trigger_count', 'ventilator_saturation', 'set_auto_o2_target_range');
       // echo "<pre>"; print_r($return);
       return $return;
   }


    /**
     * This method get machine
     * data
     *
     * @param $baby_mrn
     * @param $baby_visite
     * 
     */
     public static function getManualAssetDetails($baby_id, $admission_id) 
     {
      
        $result =  \DB::table('manual_log_dtl')
                       ->select('manual_log_dtl.*')
                       ->join('manual_log_hdr', 'manual_log_hdr.id', '=', 'manual_log_dtl.log_hdr_id')
                       ->where('manual_log_hdr.baby_id',$baby_id)
                       ->where('manual_log_hdr.admission_id',$admission_id)
                       ->where('intf_ref_value','<>','N/A')
                       ->where('loinc_code', '20124-4')
                       ->orderby('id', 'desc')
                       ->first();
        return $result;           
       
     }

    /**
      *  This method to get mode lists
      *
      * @param $baby_mrn
      * @param $baby_visite
      * @return array of object
      */
     public static function getManualModeList($baby_id, $admission_id)
     {
        $modeList = array();

        $result =  \DB::table('manual_log_dtl')
                       ->select('manual_log_dtl.*')
                       ->join('manual_log_hdr', 'manual_log_hdr.id', '=', 'manual_log_dtl.log_hdr_id')
                       ->where('manual_log_hdr.baby_id',$baby_id)
                       ->where('manual_log_hdr.admission_id',$admission_id)
                       ->where('intf_ref_value','<>','N/A')
                       ->where('loinc_code', '20124-4')
                       ->orderby('sender_time', 'desc')
                       ->pluck('intf_ref_value', 'intf_ref_value')
                       ->toArray(); 

         return $result;                 

     }
    
}