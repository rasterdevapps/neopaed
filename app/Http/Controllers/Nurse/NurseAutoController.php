<?php

namespace App\Http\Controllers\Nurse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Baby;
use App\Exceptions\InvalidInputException;
use App\Models\Nurse\EmrLogHeader;
use App\Models\Nurse\EmrLogDetails;
use App\Models\Nurse\NurseSheetMain;
use App\Models\Nurse\NurseHourSheet;
use Carbon\Carbon;
use App\Models\IpNumber;
use App\Http\Controllers\Errors\ErrorLogController;
// use App\Models\Masters\Drug;
use App\Models\Masters\DrugIvFluidMaster;
use App\Models\Masters\IvFluids;
use App\Models\Snomed\SnomedConcept;
use App\Models\Snomed\SnomedDescription;
use App\Models\Masters\NurseMaster;
use App\Models\Settings\Settings;
use App\Http\Controllers\Nurse\DialpadSupportProperty;
use App\Models\Fhir\FhirFormatedValues;
use App\Http\Controllers\Nurse\LabImportedController;

use App\Models\Nurse\NurseIvInfusion;
use App\Models\Nurse\NurseOtherIvDrugs;
use App\Models\Nurse\NurseOtherIvInfusion;
use App\Models\Nurse\NurseGlucoseIntake;
use App\Models\Nurse\NurseOralDrugs;
use App\Models\Machine\MachineDataFormter;

use App\Models\Admission;

class NurseAutoController extends Controller
{
    /**
    * @var $auth type object 
    */
    public $auth;

   /**
    *@var $emr_log_head type object 
    */
    public $emr_log_head;
    
   /**
    * @var $time_zone type string 
    */
    public $time_zone;

    /**
     * @var $loinc_values type array 
     */
    public $loinc_values;

    /**
     * @var $loinc_group_values type array 
     */
    public $loinc_group_values;

    /**
     * @var $time_interval type integer 
     */
    public $time_interval;

    /**
     * @var $error_log type object 
     */
    public $error_log;



    public function __construct(Guard $auth, EmrLogHeader $emr_log_head, ErrorLogController $error_log) 
    {
        $this->middleware('role:NICU_MODULE_SHEET,write', ['only'=>['store','update','edit','create','destory']]);
        $this->middleware('role:NICU_MODULE_SHEET,read', ['only'=>['index','show']]);
        $this->auth = $auth;
        $this->emr_log_head = $emr_log_head;
        $this->time_zone = env('TIME_ZONE');
        $this->loinc_values = json_decode(\SiteHelpers::getConfigSettings('LOINC_LOCAL_CODE'));
        $this->loinc_group_values = DialpadSupportProperty::LOINC_LOCAL_CODE_GROUP;
        $this->time_interval = 1;
        $this->navigate['main_nav']='nicu_nurse_sheet';
        $this->navigate['sub_nav'] ='nicu_nurse_sheet';
        $this->custom_error       = new ErrorLogController();


    }  

   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      //Initialize the record  limit  with 50
      $limit = 50;

      //set the limit as per the request
      if (!empty($request->input('limit'))) {

        $request->session()->put('limit', $request->input('limit'));
        $limit =  $request->session()->get('limit');

      } elseif ($request->session()->has('limit')) {

        $limit =  $request->session()->get('limit');

      }

      //Initialize the record sorting key and order  
      $order['sortby']    = 'BMrNo';
      $order['sortorder'] = 'desc';   

      //set the records sorting key and order  
      if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {

        $order['sortby']     = \SiteHelpers::decrypt_id($request->input('sortby'));
        $order['sortorder']  = $request->input('sortorder');

      }

      //initialize search parameter array 
      $search = array();
      $search['search_txt']='';
      if (!empty($request->input('search_txt'))) {

        $search['search_txt'] = $request->input('search_txt');

      }
       // $results  = NurseSheetMain::GetBabyLists()->toArray();
       $result  = NurseSheetMain::GetBabyLists($request->input('page'), $limit, $search, $order, 1);
       $results = $result['result'];
       $total      = $result['total']; 
       $getTotal      = NurseSheetMain::GetBabyListTotal(); 

      $page                   = !empty($request->input('page')) ? $request->input('page') : 1;
      $pagecount              = (!empty($search['search_txt'])) ? ceil($total/$limit) : ceil($total/$limit);
      $pagination['total']    = $total;
      $pagination['start']    = (($page-2) < 1) ? 1 : ($page-2);
      $pagination['end']      = ($pagecount < ($page+3)) ? $pagecount :   ($page+3);
      $pagestart              = $total != 0 ? ($page <= 1) ? $page : ($page-1)*$limit + 1 : 0;
      $pagerecords            = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page*$limit;
      $pagination['limit']    = array($pagestart, $pagerecords);
      $pagination['limits']   = $limit;
      $pagination['previous'] = (($page-1) < 1) ? 1 : ($page-1);
      $pagination['next']     = ($pagecount < ($page+1)) ? $pagecount :   ($page+1);
       // echo "<pre>";
       // print_r($results);
       // exit;
       $navigate = $this->navigate;
       return view('nurse-automatic.list', compact('results', 'navigate', 'total','pagination', 'search', 'order', 'getTotal'));
    }

    /**
     * Display a admission listing of the resource
     *
     *@param $baby_id type integer
     *@return \Illuminate\Http\Response
     */
    public function GetAdmissionlist($baby_id)
    {

       $baby_id        =  \SiteHelpers::decrypt_id($baby_id);
       $admission_list =  NurseSheetMain::GetAdmissionLists($baby_id);
       $navigate       =  $this->navigate;
       $baby_details   =  Baby::find($baby_id);
       $baby_mrno      = $baby_details->BMrNo;
       //$baby_mrno      = '275176';

       return view('nurse-automatic.admission_list', compact('admission_list','navigate', 'baby_mrno','baby_details'));

    }

    /**
     * Display a daylist listing of the resource
     *
     *@param $baby_id type integer
     *@return \Illuminate\Http\Response
     */
    public function GetDaylist($admission_id)
    {

       $admission_id =  \SiteHelpers::decrypt_id($admission_id);
       $day_list = NurseSheetMain::GetDayLists($admission_id);
       $navigate = $this->navigate;
       $baby_details =  array();
       $day_list =  $day_list->sortBy('id');
       if (isset($day_list[0]->BabyId)) {
        $baby_details =  Baby::find($day_list[0]->BabyId);
       }

       return view('nurse-automatic.daylist', compact('day_list','navigate', 'baby_details'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $babies_list = array();
        $baby     =  Baby::baby_list_daycare();
        $babies   =  array('0'=>'Select patient');

        foreach ($baby as $babyvalue) {
            $babies_list[$babyvalue->BabyId] = $babyvalue->BabyName.'-'.$babyvalue->BMrNo; 
        }

        krsort($babies_list); 
        foreach ($babies_list as $babykey => $babyvalue) {

            $babies[\SiteHelpers::encrypt_id($babykey)] = $babyvalue; 
        }


        $SubmitButtonText ='Start';
        $time_master = \SiteHelpers::prepare_time();

        $currrent_time['today']   = Carbon::now($this->time_zone)->format('d-m-Y');
        $currrent_time['hour']    = (int)Carbon::now($this->time_zone)->format('h');
        $currrent_time['mins']    = (int)Carbon::now($this->time_zone)->format('i');
        $currrent_time['session'] = Carbon::now($this->time_zone)->format('A');
        $navigate = $this->navigate;

        return view('nurse-automatic.select',  compact('babies', 'SubmitButtonText', 'time_master', 'currrent_time', 'navigate'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input   = $request->all();


        $input['time_hour'] = strlen($input['time_hour']) == 1 ? '0'.$input['time_hour'] : $input['time_hour'];
        $input['time_min']  = strlen($input['time_min']) == 1 ? '0'.$input['time_min'] : $input['time_min'];

        $time = $input['sheet_date'].' '.$input['time_hour'].':'.$input['time_min'].' '.$input['time_session'];

        //checks time sheet exists 
        $sheets = NurseSheetMain::GetEmrHeaderChecks($input['sheet_date'], $input['BabyId'],$input['AdmissionId'],date('Y-m-d H:i:s', strtotime($time)));
 
        // throw the response if sheets exists
        if (count($sheets) > 0 && $request->ajax()) {

            $emr_log_head_id['id'] = $sheets->id;
            // EmrLogDetails::where(['log_hdr_id'=>$sheets->id])->delete();
            // NurseHourSheet::where(['log_header_id'=>$sheets->id])->delete();           

        }  elseif (count($sheets) > 0 && !$request->ajax()) {

            $emr_log_head_id['id'] = $sheets->id;
            // EmrLogDetails::where(['log_hdr_id'=>$sheets->id])->delete();
            // NurseHourSheet::where(['log_header_id'=>$sheets->id])->delete();

        } else {

           $sheet_details  =  NurseSheetMain::GetNurseSheet($input['sheet_date'], $input['BabyId'],$input['AdmissionId']);

            if (count($sheet_details) > 0) {
                $sheet_id = $sheet_details->id;
            } else {

                $dayCount = count(NurseSheetMain::GetNurseSheetCount($input['BabyId'],$input['AdmissionId']));

                $sheet_details['day_name']     = 'Day '.($dayCount + 1);
                $sheet_details['sheet_date']   = date('Y-m-d', strtotime($input['sheet_date']));
                $sheet_details['baby_id']      = $input['BabyId'];
                $sheet_details['admission_id'] = $input['AdmissionId'];
                $sheet_details['dcp']          = $input['dcp'];
                $sheet_details['hemolysis']    = $input['hemolysis'];

                $sheet_id =  NurseSheetMain::create($sheet_details)->id;
            }

            $baby_details = Baby::find($input['BabyId']);

            $main_sheet['sender']         = env('APP_NAME');  
            $main_sheet['gender']         = $baby_details->Sex;
            $main_sheet['sender_time']    = date('Y-m-d H:i:s', strtotime($time));
            $main_sheet['visit_date']     = date('Y-m-d H:i:s', strtotime($input['sheet_date']));
            $main_sheet['loinc_version']  = 2.63;
            $main_sheet['active_flag']    = 'Y';
            $main_sheet['create_user_id'] = $this->auth->user()->name;
            $main_sheet['create_tstamp']  = date('Y-m-d H:i:s', time());
            $main_sheet['modify_user_id'] = $this->auth->user()->name;
            $main_sheet['modify_tstamp']  = date('Y-m-d H:i:s', time());
            $main_sheet['day_id']         = isset($sheet_id) ? $sheet_id : null;
            $main_sheet['baby_id']        = isset($input['BabyId']) ? $input['BabyId'] : null;
            $main_sheet['mother_id']      = isset($baby_details->MotherId) ? $baby_details->MotherId : null;
            $main_sheet['admission_id']   = isset($input['AdmissionId']) ? $input['AdmissionId'] : null;
            $main_sheet['added_nurse']    = isset($input['added_nurse']) ? $input['added_nurse'] : null;
            $emr_log_head_id              = EmrLogHeader::create($main_sheet);
       

        } 


        //master loinc set 
        $loinc_reference = EmrLogHeader::get_details_all();

        foreach ($this->loinc_values as $key => $value) {
        
            $result  = (array) $loinc_reference->where('local_code',$value)->first();

            if (count($result) > 0 && isset($input[$value]) && $input[$value] != '') {

                $result  = collect($result)->toArray();
                $sub_sheet_values["log_hdr_id"]         = $emr_log_head_id['id'];
                $sub_sheet_values["loinc_local_map_id"] = $result['ref_loc_master_id'];
                $sub_sheet_values["loinc_code"]         = $result['loinc_code']; 
                $sub_sheet_values["loinc_version"]      = $result['loinc_version'];  
                $sub_sheet_values["intf_ref_name"]      = 'None'; 
                $sub_sheet_values["intf_ref_value"]     = $input[$value];  
                $sub_sheet_values["component"]          = $result['component']; 
                $sub_sheet_values["property"]           = $result['property']; 
                $sub_sheet_values["time"]               = date('H:i:s', time());
                $sub_sheet_values["system"]             = $result["system"];
                $sub_sheet_values["scale"]              = $result["scale_typ"];
                $sub_sheet_values["method"]             = $result["method_typ"];
                $sub_sheet_values["classtype"]          = $result["classtype"];
                $sub_sheet_values["active_flag"]        = $result["active_flag"];
                $sub_sheet_values["create_user_id"]     = $this->auth->user()->name;
                $sub_sheet_values["create_tstamp"]      = date('Y-m-d H:i:s', time());
                $sub_sheet_values["modify_user_id"]     = $this->auth->user()->name;
                $sub_sheet_values["modify_tstamp"]      = date('Y-m-d H:i:s', time());

                $log_deatails_condition["log_hdr_id"]          = $emr_log_head_id['id'];
                $log_deatails_condition["loinc_local_map_id"]  = $result['ref_loc_master_id'];

                $log_details = EmrLogDetails::where($log_deatails_condition)->first();

                if(count($log_details) > 0) {
                    $emr_logs = EmrLogDetails::find($log_details->id);                    
                    // $emr_logs->intf_ref_value = $input[$value];
                    $emr_logs->Update(["intf_ref_value"=>$input[$value]]);
                }else {
                   EmrLogDetails::create($sub_sheet_values);
                }

            }    

       }
       $input['phototherapy'] = isset($input['phototherapy']) ? $input['phototherapy'] : null;
       $input['phototherapy_eyes'] = isset($input['phototherapy_eyes']) && !empty($input['phototherapy_eyes']) ? $input['phototherapy_eyes'] : null;
       $this->addmultiple_replacement($emr_log_head_id['id'], $input['phototherapy'],'phototherapy', '0');
       $this->addmultiple_replacement($emr_log_head_id['id'], $input['phototherapy_eyes'],'phototherapy_eyes', '0');
       $this->addmultiple_replacement($emr_log_head_id['id'], $input['replacement_fluids_status'],'replacement_fluids_status', '0');

       

       // replacement fluids store 
        if (isset($input['replacement_fluids_solution']) && isset($input['replacement_fluids_rate']) && isset($input['replacement_fluids_total'])) {

             for ($i=0; $i < count($input['replacement_fluids_solution']); $i++) { 
                if ($input['replacement_fluids_solution'][$i] != '') {
                   $observation_type_id = 0;
                   $observation_type_id =  $this->addmultiple_replacement($emr_log_head_id['id'], $input['replacement_fluids_solution'][$i],'replacement_fluids_solution', $observation_type_id);
                   $this->addmultiple_replacement($emr_log_head_id['id'], $input['replacement_fluids_rate'][$i],'replacement_fluids_rate', $observation_type_id);
                   $this->addmultiple_replacement($emr_log_head_id['id'], $input['replacement_fluids_total'][$i], 'replacement_fluids_total', $observation_type_id);
                }
             }
        }

       // blood product store 
      if (isset($input['F_Product']) && isset($input['F_Volume'])) {

           $result   =   $loinc_reference->where('local_code','F_Product')->first();
           $result1  =   $loinc_reference->where('local_code','F_Volume')->first();

         for ($i=0; $i < count($input['F_Product']); $i++) { 

            if ($input['F_Product'][$i] != '') {
               $observation_type_id = 0;
               $observation_type_id =  $this->addmultiplelist($emr_log_head_id['id'], $input['F_Product'][$i], $result, $observation_type_id);
               $this->addmultiplelist($emr_log_head_id['id'], $input['F_Volume'][$i], $result1, $observation_type_id);
            }
            
         }

      }

      // IV Fluids, Parenteral Nutrition And Drug Infusion
      if (isset($input['drug_solution']) && isset($input['drug_rate']) && isset($input['drug_total'])) {

           $drug_solution   =    $loinc_reference->where('local_code','drug_solution')->first();
           $drug_rate       =    $loinc_reference->where('local_code','drug_rate')->first();
           $drug_total      =    $loinc_reference->where('local_code','drug_total')->first();

         for ($i=0; $i < count($input['drug_solution']); $i++) { 

            if ($input['drug_solution'][$i] != '') {
              $drug_solutions[$i] = IvFluids::getDrugName($input['drug_solution'][$i])->name;
              $values = [$drug_solutions[$i], $input['drug_rate'][$i], $input['drug_total'][$i]];  
              $today_start   = Carbon::now($this->time_zone)->format('Y-m-d 00:00:00');
              $today_current = Carbon::now($this->time_zone)->format('Y-m-d H:i:s');

              $is_exist_fhir = EmrLogDetails::compareFhirPrescribeddata(DialpadSupportProperty::PRESCRIBED_DRUG_FLUIDS, $input['BabyId'], $input['AdmissionId'], $today_start, $today_current, $values);

              if (count($is_exist_fhir) == 0) {
                if ($input['drug_solution'][$i] != '') {
                  $observation_type_id = 0;
                  $observation_type_id =  $this->addmultiplelist($emr_log_head_id['id'], $input['drug_solution'][$i], $drug_solution, $observation_type_id);
                  $this->addmultiplelist($emr_log_head_id['id'], $input['drug_rate'][$i], $drug_rate, $observation_type_id);
                  $this->addmultiplelist($emr_log_head_id['id'], $input['drug_total'][$i], $drug_total, $observation_type_id);
                }
              }  
            } 
         }
      }


      if (isset($input['A_Antibiotic']) && isset($input['A_Day'])) {

           $a_antibiotic   =    $loinc_reference->where('local_code','A_Antibiotic')->first();
           $a_day          =    $loinc_reference->where('local_code','A_Day')->first();

         for ($i=0; $i < count($input['A_Antibiotic']); $i++) { 
           if ($input['A_Antibiotic'][$i] != '') {

               $observation_type_id = 0;
               $observation_type_id =  $this->addmultiplelist($emr_log_head_id['id'], $input['A_Antibiotic'][$i], $a_antibiotic, $observation_type_id);
               $this->addmultiplelist($emr_log_head_id['id'], $input['A_Day'][$i], $a_day, $observation_type_id);
            }
         }
      }


       //other drugs store
       if (isset($input['drugs'])) {
           $drug_solution          =    $loinc_reference->where('local_code','drugs')->first();
         for ($i=0; $i < count($input['drugs']); $i++) { 
           if ($input['drugs'][$i] != '') {
             $observation_type_id = 0;
             $this->addmultiplelist($emr_log_head_id['id'], $input['drugs'][$i], $drug_solution, $observation_type_id);
           }
         }
       }

       
        $baby_details  = Baby::find($input['BabyId']);

        $time_master   = \SiteHelpers::prepare_time();
        $currrent_time['today'] = Carbon::now($this->time_zone)->format('d-m-Y');
        $currrent_time['hour']    = (int)Carbon::now($this->time_zone)->format('h');
        $currrent_time['mins']    = (int)Carbon::now($this->time_zone)->format('i');
        $currrent_time['session'] = Carbon::now($this->time_zone)->format('A');

         if ($request->ajax()) {
             return \Response::json(['type'=>'success','message'=>'Time sheet added successfully !'],200 );
         }

        if ($input['print_flag'] == 2) {       
            return redirect(action('Nurse\NurseAutoController@GetDaylist', \SiteHelpers::encrypt_id($input['AdmissionId'])))->with('Success', 'Time sheet added successfully!');
        }
        return redirect(action('Nurse\NurseAutoController@edit', $sheet_id))->with('Success', 'Time sheet added successfully!');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = 0)
    {

      $navigate['main_nav']='nicu_nurse_sheet';
      $navigate['sub_nav'] ='nicu_nurse_sheet';

       $id  = \SiteHelpers::decrypt_id($id);


       $basic_details = $output_details = $replacement_fluids = array();
      
        if (count(explode('-', $id)) == 2) {

            $id = explode('-', $id);
            $admission_id =  $id[0];
            $baby_id      =  $id[1];

        } else {
             throw new InvalidInputException(\SiteHelpers::getUserExceptionMessage('7005'), 7005);
        }



        $baby_details = Baby::find($baby_id);
        $time_master  = \SiteHelpers::prepare_time();

        $yesterday_date = Carbon::yesterday()->format('Y-m-d');
        $current_date   = Carbon::now()->format('Y-m-d');


        $today_day                 =  NurseSheetMain::GetPrevousDayNurse($baby_id, $admission_id, $current_date);
        $yester_day                =  NurseSheetMain::GetPrevousDayNurse($baby_id, $admission_id, $yesterday_date);

        if (count($today_day) > 0) {
          $previous_day = $today_day; 
        } else {
           $previous_day = $yester_day; 
        }

        if (isset($previous_day->id)){
           $replacement_fluids          = NurseHourSheet::Getpreviousdata($previous_day->id, [DialpadSupportProperty::REPLACMENT_FLUIDS_STATUS])->first();

        }
        $iv_fluids_previous_fihr     = array();
        // $milk_feeds                  = $this->getPreviousMilkVolume($baby_id, $admission_id, $previous_day);
        $iv_fluids_previous_manual   = (array)$this->getPreviousIvfluids($baby_id, $admission_id, $previous_day);
        //$iv_fluids_previous_fihr     = $this->getUpdateToDateFluids($baby_id, $admission_id);
        $replacement_previous_fluids = $this->getPreviousReplacementfluids($baby_id, $admission_id, $previous_day);
        $antibiotic_previous         = $this->getPreviousantibiotic($baby_id, $admission_id, $previous_day);
        $other_drugs_previous        = $this->getOtherdrugs($baby_id, $admission_id, $previous_day);
       
        $iv_drug_infusion_pn         = $this->getivdrugsinfusion($baby_id, $admission_id, $previous_day);
        $special_iv_fluid_list       = $this->getivspecialfluids($baby_id, $admission_id, $previous_day);
        $other_iv_infusion_list      = $this->getotherivinfusion($baby_id, $admission_id, $previous_day);
        $other_iv_drug_list          = $this->getotherivdrugs($baby_id, $admission_id, $previous_day);
        $oral_rectal_drug_list       = $this->getoraldrugs($baby_id, $admission_id, $previous_day);

        $iv_fluids_previous          = array_merge($iv_fluids_previous_manual, $iv_fluids_previous_fihr);

       if (count($previous_day) > 0) {

          $basic_details        = EmrLogDetails::Getpreviousbasic(json_decode(\SiteHelpers::getConfigSettings('BASIC_DETAILS')))->pluck('intf_ref_value','local_code')->toArray();
          $output_details       = EmrLogDetails::Getpreviousdata($previous_day->id, json_decode(\SiteHelpers::getConfigSettings('OUTPUT_GROUPS')))->pluck('intf_ref_value','local_code')->toArray();
          $milk_feeds           = EmrLogDetails::Getpreviousdata($previous_day->id, json_decode(\SiteHelpers::getConfigSettings('MILK_FEEDS')))->pluck('intf_ref_value','local_code')->toArray();
          $output               = EmrLogDetails::Getoutputrunning(json_decode(\SiteHelpers::getConfigSettings('OUTPUT_RUNNING_TOTAL')), $previous_day->day_id);

       }
     

       $output_temp = array();

       if (isset($output) && count($output) > 0) {
          foreach (DialpadSupportProperty::OUTPUT_RUNNING_TOTAL as $key => $value) {
           $output_temp[$value]  = $output->where('local_code', $value)->pluck('intf_ref_value')->sum();
          }
       }

        $currrent_time['today']   = Carbon::now($this->time_zone)->format('d-m-Y');
        $currrent_time['hour']    = (int)Carbon::now($this->time_zone)->format('h');
        $currrent_time['mins']    = (int)Carbon::now($this->time_zone)->format('i');
        $currrent_time['session'] = Carbon::now($this->time_zone)->format('A');

        $dial_pade = DialpadSupportProperty::DAILPAD_PROPERTY;

        $ip_details = IpNumber::getCurrent_ip($baby_id, $admission_id);

        $gestation_days       =  \SiteHelpers::convert_gestation_days($baby_details->Gestation);
        $dayoflife            =  \SiteHelpers::calculate_day_of_life($baby_details->DOB);
        $corrected_gestation  =  \SiteHelpers::calculate_corrected_gestation($gestation_days, $dayoflife);
        $corrected_gestation  =  \SiteHelpers::decode_gestation(json_encode($corrected_gestation)); 

        $drugs                =  DrugIvFluidMaster::where(['is_deleted'=>'0','status'=>1])->where('type', 'ORAL')->orderby('id', 'asc')->where('brand_name','!=', '')->pluck('brand_name','id')->toArray();
        $drugs['']            = '--Select--'; 
        ksort($drugs);
        
        $drugs_gen            =  DrugIvFluidMaster::where(['is_deleted'=>'0','status'=>1])->where('type', 'ORAL')->orderby('id', 'asc')->where('generic_pharmacological_name','!=', '')->pluck('generic_pharmacological_name','id')->toArray();
        $drugs_gen['']        = '--Select--'; 
        ksort($drugs_gen);

        $ivfluids             = IvFluids::where(['IsDeleted'=>'0','status'=>'1'])->where('name','!=','')->pluck('name', 'id')->toArray();
        $ivfluids['']         = '--Select--';
        ksort($ivfluids);
        $sheet_date           = date('d-m-Y');

        $ivfluids_gen         =  IvFluids::where(['IsDeleted'=>'0','status'=>'1'])->where('pharmacological_name','!=','')->pluck('pharmacological_name', 'id')->toArray();
        $ivfluids_gen['']     = '--Select--';
        ksort($ivfluids_gen);
        $nurse_master     =  NurseMaster::where(['IsDeleted'=>'0','status'=>'Active'])->pluck('name', 'id')->toArray();
        
        $machine_status = MachineDataFormter::getMachineStatus($baby_details->BMrNo ,Carbon::now(), Carbon::now());

        $navigate = $this->navigate;

       return view('nurse-automatic.create', compact('baby_details', 'machine_status','nurse_master', 'milk_feeds','ivfluids_gen','other_iv_drug_list', 'oral_rectal_drug_list','iv_drug_infusion_pn','other_iv_infusion_list','special_iv_fluid_list','output_temp','milk_feeds','oral_drugs','iv_drugs_previous','iv_drug_infusion','replacement_fluids','output_details', 'sheet_date', 'basic_details','admission_id','other_drugs_previous','drugs_gen', 'replacement_previous_fluids','antibiotic_previous','iv_fluids_previous', 'previous_antibiotic','replacement_previous_fluids','ivfluids','drugs','ip_details','time_master', 'corrected_gestation', 'currrent_time', 'baby_id', 'dial_pade','admission_id', 'navigate'));
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function edit($id)
    {

      $navigate['main_nav']='nicu_nurse_sheet';
      $navigate['sub_nav'] ='nicu_nurse_sheet';

        $nurse_details_sheet   = NurseSheetMain::find($id);

        // $nurse_header_list  = $nurse_details_sheet->GetEmrHeaderDetails;

        $result = array(); 

        $sheet_date          = date('d-m-Y', strtotime($nurse_details_sheet->sheet_date));

        $working_time = Settings::getPeriod()->period;
        $start_time   = date('Y-m-d H:i:s', strtotime($sheet_date . ' '. $working_time));
        $end_time     = Carbon::createFromFormat('Y-m-d H:i:s', $start_time)->addDay()->addHour();
        
        $nurse_header_list = collect(EmrLogHeader::getEmrLogHdr($nurse_details_sheet->baby_id, $nurse_details_sheet->admission_id, $start_time, $end_time))->unique('sender_time');

        foreach ($nurse_header_list as $header_id => $header_value) {
            $timevalue = date('d:H:i', strtotime($header_value->sender_time));

            $time_sheet = explode(':', $timevalue)[0] . ':' . explode(':', $timevalue)[1] . ':00';

            $nurse_header_details = EmrLogHeader::find($header_value->id);
            $loinc_code_details = $nurse_header_details->GetEmrLogDetails;
            $added_nurse[$time_sheet]['time_sheet'] = $nurse_header_details->added_nurse;
            $added_nurse[$time_sheet]['header_id']  = $header_value->id;

            foreach ($loinc_code_details  as $code_details_key => $code_details_value) {


                $local_code    = EmrLogDetails::find($code_details_value->id);
                $get_code_bind       = $local_code->GetLocalCodeBind->toArray();
                $local_code_details  = $local_code->toArray();
                $result[$time_sheet][$code_details_key]                   = $local_code_details;
                $result[$time_sheet][$code_details_key]['local_code']     = $result[$time_sheet][$code_details_key]['get_local_code_bind']['local_code'];
                unset($result[$time_sheet][$code_details_key]['get_local_code_bind']);

            }

            $non_loinc_values[$time_sheet] = NurseHourSheet::where('log_header_id', $header_value->id)->get()->toArray();

        }

        $replacement_fluids = array();

        foreach ($non_loinc_values as $non_loinc_values_key => $replacment_temp) {


            $replacment_drugs = collect($replacment_temp)->where('local_code', 'replacement_fluids_solution');
            if (count($replacment_drugs) > 0) {
                foreach ($replacment_drugs as  $replacment_temp_value) {
                    $replacment_rate      = collect($replacment_temp)->where('observe_id',  $replacment_temp_value['id'])->where('local_code', 'replacement_fluids_rate')->first();
                    $replacment_total     = collect($replacment_temp)->where('observe_id',  $replacment_temp_value['id'])->where('local_code', 'replacement_fluids_total')->first();
                    
                    $replacement_fluids[$non_loinc_values_key][] = [ 'solution_id'   =>$replacment_temp_value['id'],
                                                                     'solution_name' =>$replacment_temp_value['value'],
                                                                     'rate_id'       =>$replacment_rate['id'],
                                                                     'rate_name'     =>$replacment_rate['value'],
                                                                     'total_id'      =>$replacment_total['id'],
                                                                     'total_name'    =>$replacment_total['value']];

                }
            }
            
            $phototherapy_temp = collect($replacment_temp)->where('local_code', 'phototherapy')->first();
            if (count($phototherapy_temp) > 0) {
                 $phototherapy[$non_loinc_values_key][$phototherapy_temp['id']] = $phototherapy_temp['value'];

            }

            $phototherapy_eyes_temp = collect($replacment_temp)->where('local_code', 'phototherapy_eyes')->first();

            if (count($phototherapy_eyes_temp) > 0) {
                 $phototherapy_eyes[$non_loinc_values_key][$phototherapy_eyes_temp['id']] = $phototherapy_eyes_temp['value'];

            }

           
        }




        $blood_tranfusion = array();

        $blood_product_header = null;

        foreach ($result as $bloodproductkey => $bloodproductvalue) {
          

            $last_batch_blood  = collect($bloodproductvalue)->where('local_code', 'F_Product')->toArray();
            $blood_volumes     = collect($bloodproductvalue)->where('local_code', 'F_Volume')->toArray();


            foreach ($last_batch_blood as $key => $value) {

                $last_batch_volume = collect($blood_volumes)->where('observation_type_id', $value['id'])->first();
         
                $blood_tranfusion[] = [ 'product_id'=> $value['id'],
                                        'product_name'=>$value['intf_ref_value'],
                                        'product_volid'=>$last_batch_volume['id'],
                                        'product_volume'=>$last_batch_volume['intf_ref_value']];

               $blood_product_header = $value['log_hdr_id'];                         
            }

            $transfusion[] = collect($bloodproductvalue)->where('local_code', 'Transfusion')->where('intf_ref_value', 'Yes')->first();
           
        } 

        $transfusion = collect($transfusion)->where('intf_ref_value', 'Yes')->first();

        $blood_tranfusion = collect($blood_tranfusion)->unique('product_name')->toArray();

        $time_with_header = $nurse_header_list->pluck('sender_time', 'id'); 

        $time_slots_temp  = $nurse_header_list->pluck('sender_time');

        $drugs_list = $other_drugs_list = $antibiotic_list = $basic_details = $detail = array();

        foreach ($result as $result_key => $result_value) {
             if (!env('INTERFACE_MACHINE')) {
              $fluids_prescription[$result_key] = collect($result[$result_key])->whereIn('local_code', DialpadSupportProperty::DRUG_FLUIDS)->groupBy('time');;
             } else {
              $fluids_prescription[$result_key] = collect($result[$result_key])->whereIn('local_code', DialpadSupportProperty::PRESCRIBED_DRUG_FLUIDS)->groupBy('time');;
             }


            $other_temp_drug = collect($result_value)->where('local_code', 'drugs');
            $other_header_id = null;

            if (count($other_temp_drug) > 0) {

                foreach ($other_temp_drug as $otherdrug_key => $otherdrug_value) {

                       $other_drugs_list[] = [ 'drug_id'=> $otherdrug_value['id'],
                                               'drug_name'=>$otherdrug_value['intf_ref_value']];

                       $other_header_id = $otherdrug_value['log_hdr_id'];
                   
                }
            }

             $temp_antibiotic      = collect($result_value)->where('local_code',DialpadSupportProperty::A_ANTIBIOTIC);
             $temp_antibiotic_header = null;

             if (count($temp_antibiotic) > 0) {

                foreach ($temp_antibiotic as $antibiotic_key => $antibiotic_value) {
                    $temp_day = collect($result_value)->where('observation_type_id',$antibiotic_value['id'])->where('local_code','A_Day')->last();

                    $antibiotic_list[] = [ 'antibiotic_id'   => $antibiotic_value['id'],
                                           'antibiotic_name' => $antibiotic_value['intf_ref_value'],
                                           'antibiotic_day_id'  => $temp_day['id'], 
                                           'antibiotic_day_name'  => $temp_day['intf_ref_value'] ];

                     $temp_antibiotic_header = $antibiotic_value['log_hdr_id'];   
                }
            }


            $intravenous_fluids[] =  collect($result_value)->where('local_code', DialpadSupportProperty::INTRAVENOUS_FLUIDS)->first();
            $oral_fluids[]        =  collect($result_value)->where('local_code', DialpadSupportProperty::ORAL_FLUIDS)->first();
            $other_drugs[]        =  collect($result_value)->where('local_code', DialpadSupportProperty::ORAL_DRUGS)->first();
            $total_intake_ml[]    =  collect($result_value)->where('local_code', DialpadSupportProperty::TOTAL_INTAKE_ML)->first();
            $total_intake_kg[]    =  collect($result_value)->where('local_code', DialpadSupportProperty::TOTAL_INTAKE_KG)->first();
          
            $aspirate_ml[]        =  collect($result_value)->where('local_code', DialpadSupportProperty::ASPIRATE_ML)->first();
            $drains_ml[]          =  collect($result_value)->where('local_code', DialpadSupportProperty::DRAINS_ML)->first();
            $urine_total[]        =  collect($result_value)->where('local_code', DialpadSupportProperty::URINE_TOTAL)->first();
            $urine_total_ml_kg[]  =  collect($result_value)->where('local_code', DialpadSupportProperty::URINE_TOTAL_ML_KG)->first();
            $blood_out_total[]    =  collect($result_value)->where('local_code', DialpadSupportProperty::BLOOD_OUT_TOTAL)->first();

            $stoma_output[]       =  collect($result_value)->where('local_code', DialpadSupportProperty::STOMA_OUTPUT)->first();
            $stools_frequency[]   =  collect($result_value)->where('local_code', DialpadSupportProperty::STOOLS_FREQUENCY)->first();
            $i_o_balance[]        =  collect($result_value)->where('local_code', DialpadSupportProperty::I_O_BALANCE)->first();
            $i_o_balance_ml_kg[]  =  collect($result_value)->where('local_code', DialpadSupportProperty::I_O_BALANCE_ML_KG)->first();
            
            foreach (DialpadSupportProperty::BASIC_DETAILS as $key => $value) {
                $basic_detail =  collect($result_value)->whereIn('local_code', DialpadSupportProperty::BASIC_DETAILS[$key])->first();      
                
                if (count($basic_detail) > 0) {
                    $detail[$key] = $basic_detail;
                }
            }
            $basic_details = collect($detail);
        }
        
        if (!env('INTERFACE_MACHINE')) {
          foreach ($fluids_prescription as $prescription_pn_key => $prescription_pn_value) {
            foreach ($prescription_pn_value as $prescription_key => $prescription_value) {
              foreach ($prescription_value as $key => $value) {
                if ($value['local_code'] == 'drug_solution') {                
                  $temp_fluid['drug_id'] = $value['id'];
                  if (is_numeric($value['intf_ref_value'])) {
                    $temp_fluid['drug_name'] = $value['intf_ref_value'];
                  } else {
                    $temp_drug_name = IvFluids::getDrugID($value['intf_ref_value']);
                    $temp_fluid['drug_name'] = is_object($temp_drug_name) ? $temp_drug_name->id : null;
                  }
                }
                if ($value['local_code'] == 'drug_rate') {
                  $temp_fluid['drug_rate_id'] = $value['id'];
                  $temp_fluid['drug_rate'] = $value['intf_ref_value'];
                }
                if ($value['local_code'] == 'drug_total') {
                  $temp_fluid['drug_total_id'] = $value['id'];
                  $temp_fluid['drug_total'] = $value['intf_ref_value'];
                }
              } 
            $drugs_list[$prescription_pn_key][$temp_fluid['drug_name']] = $temp_fluid;
            } 
          }
        } else {
          foreach ($fluids_prescription as $prescription_pn_key => $prescription_pn_value) {
            foreach ($prescription_pn_value as $prescription_key => $prescription_value) {
              foreach ($prescription_value as $key => $value) {
                if ($value['local_code'] == 'drug_name') {                
                  $temp_fluid['drug_id'] = $value['id'];
                  if (is_numeric($value['intf_ref_value'])) {
                    $temp_fluid['drug_name'] = $value['intf_ref_value'];
                  } else {
                    $temp_drug_name = IvFluids::getDrugID($value['intf_ref_value']);
                    $temp_fluid['drug_name'] = is_object($temp_drug_name) ? $temp_drug_name->id : null;
                  }
                }
                if ($value['local_code'] == 'running_rate') {
                  $temp_fluid['drug_rate_id'] = $value['id'];
                  $temp_fluid['drug_rate'] = $value['intf_ref_value'];
                }
                if ($value['local_code'] == 'total_volume') {
                  $temp_fluid['drug_total_id'] = $value['id'];
                  $temp_fluid['drug_total'] = $value['intf_ref_value'];
                }
              } 
            $drugs_list[$prescription_pn_key][$temp_fluid['drug_name']] = $temp_fluid;
            } 
          }
        }

            $other_drugs_list = collect($other_drugs_list)->unique('drug_name')->toArray();
            $antibiotic_list  = collect($antibiotic_list)->unique('antibiotic_name')->toArray();



            $inout_totals[DialpadSupportProperty::INTRAVENOUS_FLUIDS] = collect($intravenous_fluids)->max();
            $inout_totals[DialpadSupportProperty::ORAL_FLUIDS]        = collect($oral_fluids)->max();
            $inout_totals[DialpadSupportProperty::ORAL_DRUGS]         = collect($other_drugs)->max();
            $inout_totals[DialpadSupportProperty::TOTAL_INTAKE_ML]    = collect($total_intake_ml)->max();
            $inout_totals[DialpadSupportProperty::TOTAL_INTAKE_KG]    = collect($total_intake_kg)->max();
            $inout_totals[DialpadSupportProperty::ASPIRATE_ML]        = collect($aspirate_ml)->max();
            $inout_totals[DialpadSupportProperty::DRAINS_ML]          = collect($drains_ml)->max();
            $inout_totals[DialpadSupportProperty::URINE_TOTAL]        = collect($urine_total)->max();
            $inout_totals[DialpadSupportProperty::URINE_TOTAL_ML_KG]  = collect($urine_total_ml_kg)->max();
            $inout_totals[DialpadSupportProperty::BLOOD_OUT_TOTAL]    = collect($blood_out_total)->max();
            $inout_totals[DialpadSupportProperty::STOMA_OUTPUT]       = collect($stoma_output)->max();
            $inout_totals[DialpadSupportProperty::STOOLS_FREQUENCY]   =  collect($stools_frequency)->max();
            $inout_totals[DialpadSupportProperty::I_O_BALANCE]        = collect($i_o_balance)->max();
            $inout_totals[DialpadSupportProperty::I_O_BALANCE_ML_KG]  = collect($i_o_balance_ml_kg)->max();


        $time_slots = array();
        // foreach ($time_slots_temp as $key => $value) {
        //    $time_slots[] = date('H:i', strtotime($value));
        // }
        foreach ($time_slots_temp as $key => $value) {
           $time_slots[] =date('d:H:i', strtotime($value));
        }

        $temp_time_slot = isset($time_slots) ? $time_slots : [];
        unset($time_slots);
        $time_part1 = $time_part2 = array();

        $start_date  = explode('-', $nurse_details_sheet->sheet_date)[2];
        $end_time    = Carbon::createFromFormat('Y-m-d', $nurse_details_sheet->sheet_date)->addDay();
        $end_date    = explode(' ', explode('-', $end_time)[2])[0];

        for ($i = explode(':', $working_time)[0]; $i <= 23; $i++) {
          $time_part1[] = strlen($i) == 2 ? $start_date . ':' . $i : $start_date . ':' . '0'.$i;
        }
        for ($i = 0; $i <= explode(':', $working_time)[0]; $i++) {
          $time_part2[] = strlen($i) == 2 ? $end_date . ':' . $i : $end_date . ':' . '0'.$i;
        }
        $time = array_merge($time_part1, $time_part2);

        foreach ($time as $key => $value) {
          unset($flag);
          foreach ($temp_time_slot as $key => $temp_slot) {
            $values = explode(':', $value)[0] . ':' . explode(':', $value)[1];
            $slots  = explode(':', $temp_slot)[0] . ':' . explode(':', $temp_slot)[1];
            if ($values == $slots) {
              $time_slots[] = explode(':', $value)[0] . ':' . explode(':', $temp_slot)[1] .':00';
              $flag = 1;
            } 
          }
          if (!isset($flag))
            $time_slots[] = $value.':00';
        }

        $temp_time_slots = collect($time_slots)->unique()->toArray();
        unset($time_slots);

        $k = 0;
        foreach ($temp_time_slots as $key => $value) {
          $time_slots[$k] = $value;
          $k++;
        }
        ksort($time_slots);

        $time_header  = array();
        foreach ($time_with_header as $key => $value) {
          $time_header[$key] = date('d:H:i', strtotime($value));
        }
        $temp_time_header = isset($time_header) ? $time_header : [];
        unset($time_header);

        foreach ($time as $key => $value) {
          unset($flag);
          foreach ($temp_time_header as $key1 => $temp_slot) {
            $values = explode(':', $value)[0] . ':' . explode(':', $value)[1];
            $slots  = explode(':', $temp_slot)[0] . ':' . explode(':', $temp_slot)[1];
            if ($values == $slots) {
              $time_header[$key1] = explode(':', $value)[0] . ':' . explode(':', $temp_slot)[1] .':00';
              $flag = 1;
            } 
          }
          if (!isset($flag))
            $time_header[] = $value.':00';
        }

        $last_header = array_keys($time_header);
        rsort($last_header);
        $last_header = $last_header[0];


        $result = collect($result);

        $baby_details = Baby::find($nurse_details_sheet->baby_id);

        $sheet_date  = !is_null($nurse_details_sheet->sheet_date) ? date('d-m-Y', strtotime($nurse_details_sheet->sheet_date)) : '';
        $time_master = \SiteHelpers::prepare_time();

        $currrent_time['today']   = Carbon::now($this->time_zone)->format('d-m-Y');
        $currrent_time['hour']    = (int)Carbon::now($this->time_zone)->format('h');
        $currrent_time['mins']    = (int)Carbon::now($this->time_zone)->format('i');
        $currrent_time['session'] = Carbon::now($this->time_zone)->format('A');
        $time_interval   =  $this->time_interval;

        $ip_details           =  IpNumber::getCurrent_ip($nurse_details_sheet->baby_id, $nurse_details_sheet->admission_id);
        $gestation_days       =  \SiteHelpers::convert_gestation_days($baby_details->Gestation);
        $dayoflife            =  \SiteHelpers::calculate_day_of_life($baby_details->DOB);
        $corrected_gestation  =  \SiteHelpers::calculate_corrected_gestation($gestation_days, $dayoflife);
        $corrected_gestation  =  \SiteHelpers::decode_gestation(json_encode($corrected_gestation));   
        $master_drugs         =  DrugIvFluidMaster::where(['is_deleted'=>'0','status'=>1])->where('type', 'ORAL')->pluck('brand_name','id')->toArray();
        $master_drugs['']     = '--Select--'; 
        ksort($master_drugs);

        $ivfluids             =  IvFluids::where(['IsDeleted'=>'0','status'=>'1'])->where('name','!=', '')->pluck('name', 'id')->toArray();
        $ivfluids['']         = '--Select--';
        ksort($ivfluids);

        $drugs_gen            =  DrugIvFluidMaster::where(['is_deleted'=>'0','status'=>1])->where('type', 'ORAL')->orderby('id', 'asc')->where('generic_pharmacological_name','!=', '')->pluck('generic_pharmacological_name','id')->toArray();
        $drugs_gen['']        = '--Select--'; 
        ksort($drugs_gen);

        $drugs                =  DrugIvFluidMaster::where(['is_deleted'=>'0','status'=>1])->where('type', 'ORAL')->orderby('id', 'asc')->where('brand_name','!=', '')->pluck('brand_name','id')->toArray();
        $drugs['']            = '--Select--'; 
        ksort($drugs);


        $ivfluids_gen         =  IvFluids::where(['IsDeleted'=>'0','status'=>'1'])->where('pharmacological_name','!=', '')->pluck('pharmacological_name', 'id')->toArray();
        $ivfluids_gen['']         = '--Select--';
        ksort($ivfluids_gen);
        $nurse_master     =  NurseMaster::where(['IsDeleted'=>'0','status'=>'Active'])->pluck('name', 'id')->toArray();


       return view('nurse-automatic.edit', compact('baby_details', 'basic_details','nurse_master','added_nurse','ivfluids_gen','last_header','rectal_list','other_iv_list','otheriv_infustion_list','blood_product_header','other_header_id','temp_antibiotic_header','time_header','drugs','drugs_gen','ivfluids','phototherapy', 'phototherapy_eyes','replacement_fluids','antibiotic_list', 'inout_totals', 'master_drugs', 'sheet_date','oraldrugs_list','special_iv_list','infusion_drugs_list','transfusion','time_master', 'other_drugs_list', 'blood_tranfusion', 'drugs_list', 'corrected_gestation', 'ip_details', 'result', 'nurse_details_sheet', 'time_interval','time_slots', 'id', 'navigate'));
    
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
        
        $input   = $request->all();

        unset($input['_method']); unset($input['_token']); unset($input['temp_time_hour']); 
        unset($input['temp_time_min']); unset($input['temp_time_session']); 

        $nurse_sheet_detail   = NurseSheetMain::findOrfail($id);

        $nurse_sheet_input['dcp'] = $input['dcp'];
        $nurse_sheet_input['hemolysis'] = $input['hemolysis'];
        
        $nurse_sheet_detail->update($nurse_sheet_input);

        $non_loinc = NurseHourSheet::gethourwisesheet($id);

        $loinc_reference = EmrLogHeader::get_details_all();

        $baby_details = Baby::find($input['BabyId']);

        $admission_id = Admission::get_baby_list($input['BabyId'], $baby_details["MotherId"])->AdmissionId;

        if (isset($input[DialpadSupportProperty::PHOTOTHERAPY])) {
            $phototherapy = $input[DialpadSupportProperty::PHOTOTHERAPY];              

            $nurse_phototherapy = $non_loinc->where('local_code', DialpadSupportProperty::PHOTOTHERAPY)->toArray();
            foreach ($nurse_phototherapy as $phototherapy_id => $value) {
                $local_value['value'] = (isset($phototherapy[$value->id]) && $phototherapy[$value->id] == 'on') ? $phototherapy[$value->id] : null ;
                NurseHourSheet::where('id',$value->id)->Update($local_value);
                $local_value = null;
                unset($phototherapy[$value->id]);
            }
            $phototherapy = $nurse_phototherapy = null;
        } else {

            $sheet_header = NurseHourSheet::gethourwisesheet($id);

            $local_value_photo = $sheet_header->where('local_code', DialpadSupportProperty::PHOTOTHERAPY)->pluck('id')->toArray();

            NurseHourSheet::whereIn('id', $local_value_photo)->Update(['value'=>'off']);

        }

        if (isset($input[DialpadSupportProperty::PHOTOTHERAPY_EYES])) {

            $phototherapy_eyes = $input[DialpadSupportProperty::PHOTOTHERAPY_EYES];
            $nurse_phototherapy_eyes = $non_loinc->where('local_code', DialpadSupportProperty::PHOTOTHERAPY_EYES)->toArray();

            foreach ($nurse_phototherapy_eyes as $phototherapy_id => $value) {

                // $local_value['value'] = (isset($phototherapy_eyes[$value->id]) && $phototherapy_eyes[$value->id] == 'on') ? $phototherapy_eyes[$value->id] : null ;
                if(isset($phototherapy_eyes[$value->id]) && !empty($phototherapy_eyes[$value->id]))
                {
                  $local_value['value'] = $phototherapy_eyes[$value->id];
                }
                else
                {
                  $local_value['value'] = null;
                }
                NurseHourSheet::where('id',$value->id)->Update($local_value);
                $local_value = null;
                unset($phototherapy_eyes[$value->id]);

            }

        } else {

            $sheet_header = NurseHourSheet::gethourwisesheet($id);

            $local_value_eye   = $sheet_header->where('local_code', DialpadSupportProperty::PHOTOTHERAPY_EYES)->pluck('id')->toArray();

            NurseHourSheet::whereIn('id', $local_value_eye)->Update(['value'=> 'off']);

        }

        foreach (DialpadSupportProperty::REPLACMENT_FLUIDS as $replacement_key => $replacement_value) {

            if (isset($input[$replacement_value])) {
                $temp_replace = $input[$replacement_value];
                $fluids_value = $non_loinc->where('local_code', $replacement_value)->toArray();

                foreach ($fluids_value as $temp_key => $temp_value) {

                    if (array_key_exists($temp_value->id, $temp_replace)) {

                        $local_value['value'] = $temp_replace[$temp_value->id]; 
                        NurseHourSheet::where('id',$temp_value->id)->Update($local_value);
                        unset($temp_replace[$temp_value->id]);

                    } elseif (!array_key_exists($temp_value->id, $temp_replace) && !is_string($temp_value->id)) {

                        NurseHourSheet::where('id',$temp_value->id)->delete();

                    } 

                } 

            } 


            if (isset($temp_replace) && count($temp_replace) > 0 && $replacement_value == DialpadSupportProperty::REPLACMENT_FLUIDS_SOLUTION) {

                foreach ($temp_replace as $temp_key => $temp_value) {
                    $value_ids  =  explode('_', $temp_key);

                    if (count($value_ids) == 3) {
                        $fluids_time = explode(':', $value_ids[2]);
                        $temp_time = $fluids_time[1].':'.$fluids_time[2];
                        $date_time = explode('-', $input['sheet_date']);

                        if ($fluids_time[0] == $date_time[0]) {
                            $time = $input['sheet_date'] .' '. $temp_time;
                        } else {
                            $date = explode(' ', Carbon::createFromFormat('d-m-Y', $input['sheet_date'])->addDay())[0];
                            $time = $date .' '. $fluids_time1;
                        }

                        $start_sender_time = date('Y-m-d H:i:s', strtotime($time));

                        $end_sender_time = Carbon::createFromFormat('Y-m-d H:i:s', $start_sender_time)->addHour();

                        $check_log = EmrLogDetails::checkLogIsExist($start_sender_time, $end_sender_time, $input["BabyId"], $admission_id, $baby_details["MotherId"]);

                        $emr_log_head_id = 0;

                        if (count($check_log) != 0) {  
                            $emr_log_head_id = $check_log->id;
                        } else {

                            $added_nurse  = isset($input['added_nurse'][$value_ids[2]]) ? $input['added_nurse'][$value_ids[2]] : null;

                            $emr_log_head_id = $this->addemrlog($id, $baby_details, $start_sender_time, $input, $admission_id, $added_nurse);
                        }

                        if (is_string($temp_key) && isset($value_ids[1]) && isset($value_ids[2])) {

                            $refluids = $temp_key;
                            $rerate   = 'rerate_'.$value_ids[1].'_'.$value_ids[2];
                            $retotal   = 'retotal_'.$value_ids[1].'_'.$value_ids[2];

                            $observation_type_id =0;
                            $observation_type_id = $this->addmultiple_replacement($emr_log_head_id, $temp_value, DialpadSupportProperty::REPLACMENT_FLUIDS_SOLUTION, $observation_type_id);
                            $this->addmultiple_replacement($emr_log_head_id, $input[DialpadSupportProperty::REPLACMENT_FLUIDS_RATE][$rerate], DialpadSupportProperty::REPLACMENT_FLUIDS_RATE, $observation_type_id);
                            $this->addmultiple_replacement($emr_log_head_id, $input[DialpadSupportProperty::REPLACMENT_FLUIDS_TOTAL][$retotal], DialpadSupportProperty::REPLACMENT_FLUIDS_TOTAL, $observation_type_id);

                        }
                        
                    }

                }

            }  

        }


        //pn drugs and iv fluids 
        $log_ids= array();

        foreach (DialpadSupportProperty::DRUG_FLUIDS as $drug_fluids_property_name) {
            if (isset($input[$drug_fluids_property_name])) {
                $log_ids = array_merge($log_ids, array_keys($input[$drug_fluids_property_name]));
            }
        }

        //deleting remved drugs
        $log_ids = array_filter($log_ids, 'is_int');

        $emr_details = EmrLogDetails::getremovedetails($id, $log_ids, DialpadSupportProperty::DRUG_FLUIDS);
        //deleting remved drugs

        foreach (DialpadSupportProperty::DRUG_FLUIDS as $drug_fluids_property_name) {

            if (isset($input[$drug_fluids_property_name])) {

                $ivdrugsinfusion[$drug_fluids_property_name] = $input[$drug_fluids_property_name];

                unset($input[$drug_fluids_property_name]);

                foreach ($ivdrugsinfusion as $ivdrugsinfusion_key => $ivdrugsinfusion_value) {

                    foreach ($ivdrugsinfusion_value as $ivinfusion_id => $ivinfusion_value) {

                        $emr_log_details = array();

                        $fluids_temp  = explode('_', $ivinfusion_id);

                        if (!is_string($ivinfusion_id) && count($fluids_temp) < 3) {
                            $emr_log_details = EmrLogDetails::find($ivinfusion_id);
                        } 

                        if (count($emr_log_details) > 0 && count($fluids_temp) < 3) {
                            $emr_log_details->Update([DialpadSupportProperty::INTF_REF_VALUE=>$ivinfusion_value]);
                            unset($ivdrugsinfusion[$ivdrugsinfusion_key][$ivinfusion_id]);
                        } else {
                            if ($drug_fluids_property_name == 'drug_solution') {

                                $fluids_time = explode(':', $fluids_temp[2]);
                                $fluids_time1 = $fluids_time[1].':'.$fluids_time[2];
                                $date_time = explode('-', $input['sheet_date']);

                                if ($fluids_time[0] == $date_time[0]) {
                                    $time = $input['sheet_date'] .' '. $fluids_time1;
                                } else {
                                    $date = explode(' ', Carbon::createFromFormat('d-m-Y', $input['sheet_date'])->addDay())[0];
                                    $time = $date .' '. $fluids_time1;
                                }

                                $start_sender_time = date('Y-m-d H:i:s', strtotime($time));

                                $end_sender_time = Carbon::createFromFormat('Y-m-d H:i:s', $start_sender_time)->addHour();

                                $check_log = EmrLogDetails::checkLogIsExist($start_sender_time, $end_sender_time, $input["BabyId"], $admission_id, $baby_details["MotherId"]);

                                $emr_log_head_id = 0;

                                if (count($check_log) != 0) {  
                                    $emr_log_head_id = $check_log->id;
                                } else {

                                    $added_nurse = isset($input['added_nurse'][$fluids_temp[2]]) ? $input['added_nurse'][$fluids_temp[2]] : null;

                                    $emr_log_head_id = $this->addemrlog($id, $baby_details, $start_sender_time, $input, $admission_id, $added_nurse);
                                } 

                                $local_code  = (array) $loinc_reference->where('local_code',$drug_fluids_property_name)->first();

                                $observation_type_id = 0;
                                $observation_type_id = $this->addmultiplelist($emr_log_head_id, $ivdrugsinfusion[$drug_fluids_property_name][$ivinfusion_id], $local_code, $observation_type_id);
                                unset($ivdrugsinfusion[$drug_fluids_property_name][$ivinfusion_id]);

                                if ($observation_type_id != 0) {                                        
                                    $fluids_rate  = 'iv-rate_'.$fluids_temp[1].'_'.$fluids_temp[2];
                                    $local_rate   = (array) $loinc_reference->where('local_code','drug_rate')->first();
                                    $this->addmultiplelist($emr_log_head_id, $input['drug_rate'][$fluids_rate], $local_rate, $observation_type_id);
                                    unset($input['drug_rate'][$fluids_rate]);

                                    $fluids_total = 'iv-total_'.$fluids_temp[1].'_'.$fluids_temp[2];
                                    $local_total  = (array) $loinc_reference->where('local_code','drug_total')->first();
                                    $this->addmultiplelist($emr_log_head_id, $input['drug_total'][$fluids_total], $local_total, $observation_type_id);                                         
                                    unset($input['drug_total'][$fluids_total]);                                    
                                }

                            }

                        }
                    }
                }
            }  
        }

        // toggle value started

        $inputToggle = array(); 
        foreach (DialpadSupportProperty::TOGGLE_VALUSE as $toggle_value) {

            if (isset($input[$toggle_value])) {
                $inputToggle[] = $input[$toggle_value];
            }

        }


        $inputToggle = collect($inputToggle)->collapse()->toArray();


        $emr_toggles = EmrLogDetails::GetToggleValues($id, DialpadSupportProperty::TOGGLE_VALUSE);

        foreach ($emr_toggles as $ktoggles => $vtoggles) {

            $slug = $vtoggles->log_hdr.'-'.$vtoggles->log_dtl_id;

            if (!array_key_exists($slug, $inputToggle) && !isset($input[$vtoggles->local_code][$slug])) {

                $emr_log_details = EmrLogDetails::find($vtoggles->log_dtl_id);

                if (count($emr_log_details) > 0) {

                    $temp_emr[DialpadSupportProperty::INTF_REF_VALUE] = 'off'; 
                    $emr_log_details->Update($temp_emr);
                    unset($temp_emr);
                }
            }

        } 

        //toggle value ended  

        if (isset($input[DialpadSupportProperty::OTHER_DRUGS])) {

            $other_drugs[DialpadSupportProperty::OTHER_DRUGS] = $input[DialpadSupportProperty::OTHER_DRUGS];
            unset($input[DialpadSupportProperty::OTHER_DRUGS]);

            $other_drugs_local =  EmrLogHeader::get_details(DialpadSupportProperty::OTHER_DRUGS);
            $other_drugs_id    =  array_filter(array_keys($other_drugs[DialpadSupportProperty::OTHER_DRUGS]), 'is_int');

            $other_drugs_local =  EmrLogHeader::get_remove_drugs($id, $other_drugs_local->ref_loc_master_id,$other_drugs_id);

            foreach ($other_drugs as $other_drugs_id => $other_drugs_value) {

                foreach ($other_drugs_value as $other_drugs_value_id => $other_drugs_value_value) {

                    $emr_log_details = array();

                    if (!is_string($other_drugs_value_id)) {
                        $emr_log_details = EmrLogDetails::find($other_drugs_value_id);
                    }
                    if (count($emr_log_details) > 0) {
                        $emr_log_details->Update([DialpadSupportProperty::INTF_REF_VALUE=>$other_drugs_value_value]);
                        unset($other_drugs[$other_drugs_id][$other_drugs_value_id]);
                    } else {

                        $start_sender_time = date('Y-m-d H:i:s', strtotime($input['sheet_date']));

                        $date = Carbon::createFromFormat('d-m-Y', $input['sheet_date'])->addDay();

                        $end_sender_time = date('Y-m-d', strtotime($date));

                        $check_log = EmrLogDetails::checkLogIsExist($start_sender_time, $end_sender_time, $input["BabyId"], $admission_id, $baby_details["MotherId"]);

                        $observation_type_id = 0;

                        $local_drug  = (array) $loinc_reference->where('local_code', DialpadSupportProperty::OTHER_DRUGS)->first();

                        $this->addmultiplelist($check_log->id, $other_drugs[DialpadSupportProperty::OTHER_DRUGS][$other_drugs_value_id], $local_drug, $observation_type_id);

                        unset($other_drugs[$other_drugs_id][$other_drugs_value_id]);

                    }
                }
            }
        }

        if (isset($input[DialpadSupportProperty::A_ANTIBIOTIC])) {

            foreach (DialpadSupportProperty::A_ANTIBIOTIC_GROUP as $antibio_property_name) {

                $antibio[$antibio_property_name] = $input[$antibio_property_name];
                unset($input[$antibio_property_name]);

                $antibio_local =  EmrLogHeader::get_details($antibio_property_name);
                $antibio_filterd_ids  = array_filter(array_keys($antibio[$antibio_property_name]), 'is_int'); 
                $antibio_local =  EmrLogHeader::get_remove_drugs($id, $antibio_local->ref_loc_master_id, $antibio_filterd_ids);

                foreach ($antibio as $antibio_key => $antibio_values) {
                    foreach ($antibio_values as $antibio_id => $antibio_value) {

                        $emr_log_details = array();

                        if (!is_string($antibio_id)) {
                            $emr_log_details = EmrLogDetails::find($antibio_id);
                        }

                        if (count($emr_log_details) > 0) {
                            $emr_log_details->Update([DialpadSupportProperty::INTF_REF_VALUE=>$antibio_value]);
                            unset($antibio[$antibio_key][$antibio_id]);
                        } else {

                            if (DialpadSupportProperty::A_ANTIBIOTIC == $antibio_property_name && is_string($antibio_id)) {

                                $temp_ids = explode('_', $antibio_id);

                                if (isset($temp_ids[1]) && isset($temp_ids[2])) {
                                    $anibio_name = $antibio_id;
                                    $anibio_day  = 'antiday_'.$temp_ids[1].'_'.$temp_ids[2];
                                    $observation_type_id = 0;

                                    $local_antibio = (array) $loinc_reference->where('local_code', DialpadSupportProperty::A_ANTIBIOTIC)->first();
                                    $local_day  = (array) $loinc_reference->where('local_code', DialpadSupportProperty::A_DAY)->first();

                                    $observation_type_id =  $this->addmultiplelist($temp_ids[2], $antibio[DialpadSupportProperty::A_ANTIBIOTIC][$anibio_name], $local_antibio, $observation_type_id);
                                    $this->addmultiplelist($temp_ids[2], $input[DialpadSupportProperty::A_DAY][$anibio_day], $local_day, $observation_type_id);

                                }

                            }

                        }
                    }
                }
            }

        }


        $blood_products_details = array();
        $iv_property_name = null;

        foreach (DialpadSupportProperty::BLOOD_PRODUCT_GROUP as $iv_property_name) {
            if (isset($input[$iv_property_name])) {
                $blood_products_details= array_merge($blood_products_details, array_keys($input[$iv_property_name]));
            }
        }

        $blood_products_details = array_filter($blood_products_details, 'is_int');
        $emr_details = EmrLogDetails::getremovedetails($id, $blood_products_details, DialpadSupportProperty::BLOOD_PRODUCT_GROUP);


        if (isset($input[DialpadSupportProperty::F_PRODUCT])) {

            foreach (DialpadSupportProperty::BLOOD_PRODUCT_GROUP as $blood_product_name) {

                $blood_product[$blood_product_name] = $input[$blood_product_name];

                unset($input[$blood_product_name]);

                foreach ($blood_product as $blood_product_key => $blood_product_value) {
                    foreach ($blood_product_value as $blood_product_id => $blood_value) {

                        $emr_log_details = null;

                        if (!is_string($blood_product_id)) {
                            $emr_log_details = EmrLogDetails::find($blood_product_id);
                        }

                        if (count($emr_log_details) > 0) {
                            $emr_log_details->Update([DialpadSupportProperty::INTF_REF_VALUE=>$blood_value]);
                            unset($blood_product[$blood_product_key][$blood_product_id]);
                        } else {
                            if (DialpadSupportProperty::F_PRODUCT == $blood_product_name) {

                                $blood_product_id = explode('_', $blood_product_id)[1];

                                $start_sender_time = date('Y-m-d H:i:s', strtotime($input['sheet_date']));

                                $date = Carbon::createFromFormat('d-m-Y', $input['sheet_date'])->addDay();

                                $end_sender_time = date('Y-m-d', strtotime($date));

                                $check_log = EmrLogDetails::checkLogIsExist($start_sender_time, $end_sender_time, $input["BabyId"], $admission_id, $baby_details["MotherId"]);

                                $observation_type_id = 0;

                                $local_blood  = (array) $loinc_reference->where('local_code', DialpadSupportProperty::F_PRODUCT)->first();
                                $local_volume = (array) $loinc_reference->where('local_code', DialpadSupportProperty::F_VOLUME)->first();
                                $blood_productid = 'blood-product_' . $blood_product_id;
                                $observation_type_id =  $this->addmultiplelist($check_log->id, $blood_product[DialpadSupportProperty::F_PRODUCT][$blood_productid], $local_blood, $observation_type_id);
                                unset($blood_product[$blood_product_key][$blood_productid]);
                                $volume_product = 'blood-volume_'.$blood_product_id;
                                $this->addmultiplelist($check_log->id, $input[DialpadSupportProperty::F_VOLUME][$volume_product], $local_volume, $observation_type_id);
                                unset($blood_product[$blood_product_key][$volume_product]);

                            }
                        }
                    }
                }

            }
        }

        foreach ($input as $key_name => $value_set) {

            if(!in_array($key_name, $this->loinc_group_values) && $key_name != 'added_nurse') {  

                if (is_array($value_set)) {
                    foreach ($value_set as $key_id => $value_id) {

                        $added_nurse  = isset($input['added_nurse'][$key_id]) ? $input['added_nurse'][$key_id] : null;

                        $ids = explode('-',$key_id);                      
                        $ids1 = explode(':', $key_id);

                            if (count($ids) == 2 && count($ids1) != 3) {

                                $emr_log_head_id = $ids[0];
                                $emr_log_id = $ids[1];

                                $emr_log_details = ($emr_log_id != '') ? EmrLogDetails::find($emr_log_id) : array();

                                if (count($emr_log_details) > 0) {
                                    // update the existing values 
                                    $emr_log_value['intf_ref_value'] = $value_id;
                                    $emr_log_details->Update($emr_log_value);

                                } else {
                                    // Add the new values 
                                    $loinc_details  = EmrLogHeader::get_details($key_name);

                                    if (count($loinc_details) > 0) {

                                        $loinc_detail  = collect($key_id)->toArray();

                                        if (count($loinc_detail) == 1) {
                                            $loinc_details  = collect($loinc_details)->toArray();
                                        } else {
                                            $loinc_details  = $loinc_detail;
                                        }

                                        $this->addmultiplelist($emr_log_head_id, $value_id, $loinc_details);
                                    }    

                                }
                            } elseif (count($ids1) == 3 && $value_id != "") {

                                $time_hour = strlen($ids1[1]) == 1 ? '0'.$ids1[1] : $ids1[1];
                                $time_min  = strlen($ids1[2]) == 1 ? '0'.$ids1[2] : $ids1[2];

                                $sheet_date = explode('-',$input['sheet_date']);    

                                if ($sheet_date[0] == $ids1[0]) {
                                    $date = $input['sheet_date'];
                                } else {
                                    $date = explode(' ',Carbon::createFromFormat('d-m-Y', $input['sheet_date'])->addDay())[0];
                                }

                                $time = $date.' '.$time_hour.':'.$time_min.':00';

                                $start_sender_time = date('Y-m-d H:i:s', strtotime($time));

                                $end_sender_time     = Carbon::createFromFormat('Y-m-d H:i:s', $start_sender_time)->addHour();

                                $check_log = EmrLogDetails::checkLogIsExist($start_sender_time, $end_sender_time, $input["BabyId"], $admission_id, $baby_details["MotherId"]);

                                if (count($check_log) != 0) {  
                                    $emr_log_head_id = $check_log->id;
                                }
                                else {
                                    $emr_log_head_id = $this->addemrlog($id, $baby_details, $start_sender_time, $input, $admission_id, $added_nurse);
                                }  

                                $loinc_reference = EmrLogHeader::get_details_all();

                                $result  = (array) $loinc_reference->where('local_code',$key_name)->first();

                                if (count($result) > 0 && isset($emr_log_head_id)) {
                                    $result  = collect($result)->toArray();
                                    $trtdg = $this->addmultiplelist($emr_log_head_id, $value_id, $result);
                                    unset($input[$key_name][$key_id]);
                                } elseif (isset($emr_log_head_id)) { 
                                    $emr_hrd_id = $emr_log_head_id;
                                    $this->addmultiple_replacement($emr_hrd_id, $input[$key_name][$key_id],$key_name, '0');
                                    unset($input[$key_name][$key_id]);
                                } 
                            } elseif ($value_id != "") {
                                $start_sender_time = date('Y-m-d H:i:s', strtotime($input['sheet_date']));

                                $end_sender_time = explode(' ', Carbon::createFromFormat('d-m-Y', $input['sheet_date'])->addDay())[0] . ' 00:00:00';

                                $check_log = EmrLogDetails::checkLogIsExist($start_sender_time, $end_sender_time, $input["BabyId"], $admission_id, $baby_details["MotherId"]);

                                if (count($check_log) != 0) {  
                                    $emr_log_head_id = $check_log->id;
                                }
                                else {
                                    $emr_log_head_id = $this->addemrlog($id, $baby_details, $start_sender_time, $input, $admission_id, $added_nurse);
                                }

                                $loinc_reference = EmrLogHeader::get_details_all();

                                $result  = (array) $loinc_reference->where('local_code',$key_name)->first();

                                if (count($result) > 0 && isset($emr_log_head_id)) {
                                    $emr_details = \DB::table('emr_log_dtl')
                                                        ->where('log_hdr_id',$emr_log_head_id)
                                                        ->where('loinc_code',$result['loinc_code'])
                                                        ->orderby('id', 'desc')
                                                        ->first();

                                    if (count($emr_details) > 1) {
                                        $emr_details = EmrLogDetails::find($emr_details->id);
                                        $emr_log_value['intf_ref_value'] = $value_id;
                                        $emr_details->Update($emr_log_value);
                                    } else {
                                        $result  = collect($result)->toArray();
                                        $this->addmultiplelist($emr_log_head_id, $value_id, $result);
                                        unset($input[$key_name][$key_id]);
                                    }
                                }
                            }
                    }
                }
            } else {
                foreach ($value_set as $key_id => $value_id) {

                    $emr_header_id = explode(':', $key_id);  

                    if (count($emr_header_id) > 1) {

                        $sheet_date = explode('-',$input['sheet_date']);    

                        if ($sheet_date[0] == $emr_header_id[0]) {
                            $date = $input['sheet_date'];
                        } else {
                            $date = explode(' ',Carbon::createFromFormat('d-m-Y', $input['sheet_date'])->addDay())[0];
                        }

                        $time_hour = strlen($emr_header_id[1]) == 1 ? '0'.$emr_header_id[1] : $emr_header_id[1];

                        $time = $date .' '. $time_hour.  ':00:00';

                        $start_sender_time = date('Y-m-d H:i:s', strtotime($time));

                        $end_sender_time   = Carbon::createFromFormat('Y-m-d H:i:s', $start_sender_time)->addHour();

                        $check_log = EmrLogDetails::checkLogIsExist($start_sender_time, $end_sender_time, $input["BabyId"], $admission_id, $baby_details["MotherId"]);

                        if (count($check_log) != 0) {  
                            $emr_log_head_id = $check_log->id;
                            $emr_header = EmrLogHeader::find($emr_log_head_id);
                            $emr_header_value['added_nurse'] = $value_id;
                            $emr_header->Update($emr_header_value);
                        }
                        else {
                            $added_nurse  = isset($input['added_nurse'][$key_id]) ? $input['added_nurse'][$key_id] : null;
                            $emr_log_head_id = $this->addemrlog($id, $baby_details, $start_sender_time, $input, $admission_id, $added_nurse);
                        }  

                    } else {
                        $emr_header = EmrLogHeader::find($key_id);
                        $emr_header_value['added_nurse'] = $value_id;
                        $emr_header->Update($emr_header_value);                        
                    }
                }
            }
        }
        // $admission_id = NurseSheetMain::find($id)->admission_id;

        if( isset($input['print_flag']) && $input['print_flag'] == 1) {
            return redirect(action('Nurse\NurseAutoController@edit', $id))->with('Success', 'Time sheet updated successfully');
        } elseif ( isset($input['print_flag']) && $input['print_flag'] == 2) {
            return redirect(action('Nurse\NurseAutoController@GetDaylist', \SiteHelpers::encrypt_id($admission_id)))->with('Success', 'Time sheet updated successfully');
        } elseif ( isset($input['print_flag']) && $input['print_flag'] == 3) {
            return redirect(action('Nurse\NurseAutoController@print', $id))->with('Success', 'Time sheet updated successfully');
        } else {
            return redirect(action('Nurse\NurseAutoController@print', $id))->with('Success', 'Time sheet updated successfully');
        }

    
    }

   /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        $nurse_details_sheet = NurseSheetMain::find($id);

        $baby                = Baby::find($nurse_details_sheet->baby_id);
        $ip_details          = IpNumber::getCurrent_ip($nurse_details_sheet->baby_id, $nurse_details_sheet->admission_id);

        $gestation_days      = \SiteHelpers::convert_gestation_days($baby->Gestation);
        $dayoflife           = \SiteHelpers::calculate_day_of_life_two($baby->DOB, $nurse_details_sheet->sheet_date);
        $corrected_gestation = \SiteHelpers::calculate_corrected_gestation($gestation_days, $dayoflife);
        $corrected_gestation = \SiteHelpers::decode_gestation(json_encode($corrected_gestation));
        $sheet_date          = date('d-m-Y', strtotime($nurse_details_sheet->sheet_date));

        $ivfluids = $pn_fluids  = $replacement_fluids = $temp_antibio_groups = $temp_otherdrugs_groups =  array();

        $result = $nurse_replacement_fluids = $milk_feeds = array();

        $addNurseList = array(); 

        $working_time = Settings::getPeriod()->period;

        $start_time   = date('Y-m-d H:i:s', strtotime($sheet_date . ' '. $working_time));

        $start_time   = Carbon::createFromFormat('Y-m-d H:i:s', $start_time)->subHour();

        $end_time     = Carbon::createFromFormat('Y-m-d H:i:s', $start_time)->addDay()->addHours(3);

        $start_working_time = Carbon::createFromFormat('Y-m-d H:i:s', $start_time)->addHour()->format('H');
        $end_working_time   = Carbon::createFromFormat('Y-m-d H:i:s', $start_time)->addHours(2)->format('H');

        $nurse_header_list = collect(EmrLogHeader::getEmrLogHdr($nurse_details_sheet->baby_id, $nurse_details_sheet->admission_id, $start_time, $end_time))->unique('sender_time');

        foreach ($nurse_header_list as $header_id => $header_value) {

            $time_sheet = date('d:H:i', strtotime($header_value->sender_time));

            $timevalue = explode(':', $time_sheet)[0] . ':' . explode(':', $time_sheet)[1] . ':00';

            $nurse_header_details = EmrLogHeader::find($header_value->id);

            $starttime   = strtotime(Carbon::createFromFormat('Y-m-d H:i:s', $start_time)->addHour());
            $endtime     = strtotime(Carbon::createFromFormat('Y-m-d H:i:s', $start_time)->addDay()->addHour());

            if ($nurse_header_details->added_nurse != '' && (strtotime($header_value->sender_time) >= $starttime) && (strtotime($header_value->sender_time) <= $endtime)) {
              $addNurseList[$timevalue]['nurse']= $nurse_header_details->added_nurse;
              $addNurseList[$timevalue]['time'] = $time_sheet;
            }
            
            $loinc_code_details = $nurse_header_details->GetEmrLogDetails;
            $nurse_replacement_fluids[$timevalue] = NurseHourSheet::GetData($header_value->id);

            foreach ($loinc_code_details  as $code_details_key => $code_details_value) {

                $local_code          = EmrLogDetails::find($code_details_value->id);
                $get_code_bind       = $local_code->GetLocalCodeBind->toArray();
                $local_code_details  = $local_code->toArray();
                $result[$timevalue][$code_details_key]                   = $local_code_details;
                $result[$timevalue][$code_details_key]['local_code']     = $result[$timevalue][$code_details_key]['get_local_code_bind']['local_code'];
                unset($result[$timevalue][$code_details_key]['get_local_code_bind']);
               
            }           
        }

        $baby_observe         = DialpadSupportProperty::BABY_OBSERVATIONS;
        $respiratorty_support = DialpadSupportProperty::RESPIRATORY_SUPPORT;
        $milk_feeds           = DialpadSupportProperty::MILK_FEEDS;
        $output_groups        = DialpadSupportProperty::OUTPUT_GROUPS;
        $code_phototherapy      = DialpadSupportProperty::PHOTOTHERAPY;
        $code_phototherapy_eyes = DialpadSupportProperty::PHOTOTHERAPY_EYES;

        $temp_pn_fluids    =  $temp_replacement_fluids = null;

        $pn_fluids  = $replacement_fluids = $prescription_pn_fluid = $prescription_fluid = $fluid = $fluid_name_base = $fluid_volume_base = $fluid_total_base = $prescription_fluids = $time_slots = array();        

        $time_slots_temp   = $nurse_header_list->pluck('sender_time');

        foreach ($time_slots_temp as $key => $value) {
          $temp_slots = date('d:H', strtotime($value)). ":00";
          if (!in_array($temp_slots, $time_slots)) {
            $time_slots[] = $temp_slots;
          }
        }

        if (isset($time_slots)) {
          foreach ($time_slots as $time_key => $time_value) {
            $temp_pn_fluids[$time_value]          = collect($result[$time_value])->whereIn('local_code', DialpadSupportProperty::DRUG_FLUIDS)->sortBy('id');
            // $pn_fluids                            = array_merge($pn_fluids, collect($result[$time_value])->whereIn('local_code', DialpadSupportProperty::DRUG_FLUIDS)->pluck('intf_ref_value')->toArray());
            $temp_replacement_fluids[$time_value] = collect($nurse_replacement_fluids[$time_value])->whereIn('local_code', DialpadSupportProperty::REPLACMENT_FLUIDS);
            $replacement_fluids                   = array_merge($replacement_fluids, collect($nurse_replacement_fluids[$time_value])->whereIn('local_code', DialpadSupportProperty::REPLACMENT_FLUIDS_SOLUTION)->pluck('value')->toArray());
            $temp_milk_feeds[$time_value]         = collect($result[$time_value])->whereIn('local_code', DialpadSupportProperty::MILK_FEEDS);
            $temp_output_groups[$time_value]      = collect($result[$time_value])->whereIn('local_code', DialpadSupportProperty::OUTPUT_GROUPS);
            $temp_antibio_groups[$time_value]     = collect($result[$time_value])->whereIn('local_code', DialpadSupportProperty::A_ANTIBIOTIC_GROUP);
            $temp_otherdrugs_groups[$time_value]  = collect($result[$time_value])->whereIn('local_code', DialpadSupportProperty::OTHER_DRUGS);
            $temp_infusion_drug[$time_value]      = collect($result[$time_value])->whereIn('local_code', DialpadSupportProperty::INFUSION_GROUP);
            $oral_drugs[$time_value]              = collect($result[$time_value])->whereIn('local_code', DialpadSupportProperty::ORALDRUG_GROUP);
            $phototherapy[$time_value]            = collect($nurse_replacement_fluids[$time_value])->whereIn('local_code', DialpadSupportProperty::PHOTOTHERAPY)->pluck('value')->toArray();
            $phototherapy_eyes[$time_value]       = collect($nurse_replacement_fluids[$time_value])->whereIn('local_code', DialpadSupportProperty::PHOTOTHERAPY_EYES)->pluck('value')->toArray();
            $prescription_pn_fluid[$time_value]   = collect($result[$time_value])->whereIn('local_code', DialpadSupportProperty::PRESCRIBED_DRUG_FLUIDS)->groupBy('time');
          }
        }

        foreach ($temp_pn_fluids as $key => $value) {
          unset($drug_name);
          foreach ($value as $key1 => $value1) {
            if ($value1['local_code'] == 'drug_solution') {
              $drug_name = IvFluids::getDrugName($value1['intf_ref_value'])->name;
            }
            if (isset($drug_name)) {
              $pn_fluids[$drug_name][$key][$value1['local_code']] = $value1['intf_ref_value'];
            }
          }
        }

        $snomed_code  = ['DRUG_NAME_SNOMED_CT', 'PROGRAMME_PRESSURE_SNOMED_CT', 'INFUSED_SNOMED_CT', 'RATE_SNOMED_CT', 'REMAINING_SNOMED_CT'];

        $snomed_value = ['drug_name', 'initial_drug_vol','total_volume', 'running_rate', 'remaining_vol'];

        foreach ($snomed_code as $key => $value) {
          $snomed_code[$snomed_value[$key]]       = \SiteHelpers::getConfigSettings($value);
          $ip_number = !empty($ip_details) ? $ip_details->ip_number : 0;
          $resource  = FhirFormatedValues::getTpnDrugs($baby->BMrNo, $ip_number, $snomed_code[$snomed_value[$key]], $start_time, $end_time)->groupBy('advice_id');

          foreach ($resource as $key1 => $value1) {     

            $prescription_start_time    = FhirFormatedValues::drugStarttime($key1)->date;
            $prescription_started_time  = date('d:H:i', strtotime($prescription_start_time));
            $prescription_started_time1 = explode(':', $prescription_started_time)[0] . ':' . explode(':', $prescription_started_time)[1] . ':00';

            foreach ($value1 as $key2 => $value2) {     
              $snomed_end_time  = date('d:H:i', strtotime($value2->end_time));
              $snomed_end_time1 = explode(':', $snomed_end_time)[0] . ':' . explode(':', $snomed_end_time)[1] . ':00';
                
              // if ($prescription_started_time1 == $snomed_end_time1 && $snomed_value[$key] == 'running_rate') {
              //   $value2->mean = 0.00;
              // }

              $prescription_fluids[$key1][$snomed_end_time1][$snomed_value[$key]] = $value2->mean;              

              if ($snomed_value[$key] == 'remaining_vol' && !array_key_exists('tot_rem_vol', $prescription_fluids[$key1][$snomed_end_time1])) {
                $prescription_fluids[$key1][$snomed_end_time1]['tot_rem_vol'] = $value2->mean;
              }

            }

          }
        }

        $temp_total_vol = array();

        foreach ($prescription_fluids as $key => $value) {
          $prescriptionfluid[$key] = collect($value)->groupBy('drug_name')->toArray();
          $drug_name = array_keys($prescriptionfluid[$key])[0];
          if (array_key_exists($drug_name, $prescription_fluid)) {
            $prescription_fluid[$drug_name] = array_merge($prescription_fluid[$drug_name], $value);
          } else {
            $prescription_fluid[$drug_name] = $value;
          }
        }

        $last_sheet = collect($result)->last();
        $last_sheet = collect($last_sheet)->whereIn('local_code',DialpadSupportProperty::BASIC_DETAILS)->toArray();
        $temp_weight = collect($result)->collapse();
        $current_weight = collect($temp_weight)->where('local_code', 'current_weight')->pluck('intf_ref_value')->last();
        $working_weight = collect($temp_weight)->where('local_code', 'working_weight')->pluck('intf_ref_value')->last();

        $ivfluids               = IvFluids::getFieldvalue();
        $pn_fluids              = collect($pn_fluids)->unique()->toArray();
        $replacement_fluids     = collect($replacement_fluids)->unique()->toArray();
        $temp_antibio_groups    = collect($temp_antibio_groups)->collapse();
        $temp_otherdrugs_groups = collect($temp_otherdrugs_groups)->collapse()->unique('intf_ref_value');
        $master_drugs           = DrugIvFluidMaster::where(['is_deleted'=>'0','status'=>1])->where('type', 'ORAL')->pluck('brand_name','id')->toArray();
        $closewinlink           = action('Nurse\NurseAutoController@GetDaylist',\SiteHelpers::encrypt_id($nurse_details_sheet->admission_id));
        $drugs_gen              = DrugIvFluidMaster::where(['is_deleted'=>'0','status'=>1])->where('type', 'ORAL')->orderby('id', 'asc')->pluck('generic_pharmacological_name','id')->toArray();

        ksort($addNurseList);
        $unique_nurse  = collect($addNurseList)->unique('nurse')->pluck('nurse')->toArray();
        $nurse_entered = array();

        foreach ($unique_nurse as $value) {
          $nurse_start           =  collect($addNurseList)->where('nurse', $value)->min('time');
          $nurse_end             =  collect($addNurseList)->where('nurse', $value)->max('time');
          $nurse_entered[$value] =  date('h:i a', strtotime($nurse_start)).' - '.date('h:i a', strtotime($nurse_end));          
        }

        $nurse_master  =  NurseMaster::get()->pluck('name', 'id')->toArray();

        $temp_time_slot = isset($time_slots) ? $time_slots : [];

        unset($time_slots);
        $time_part1 = $time_part2 = array();

        $start_date  = explode('-', $nurse_details_sheet->sheet_date)[2];
        $end_time    = Carbon::createFromFormat('Y-m-d', $nurse_details_sheet->sheet_date)->addDay();
        $end_date    = explode(' ', explode('-', $end_time)[2])[0];

        for ($i = $start_working_time; $i <= 23; $i++) {
          $time_part1[] = strlen($i) == 2 ? $start_date . ':' . $i : $start_date . ':' . '0'.$i;
        }
        for ($i = 0; $i <= $end_working_time; $i++) {
          $time_part2[] = strlen($i) == 2 ? $end_date . ':' . $i : $end_date . ':' . '0'.$i;
        }
        $time = array_merge($time_part1, $time_part2);

        foreach ($time as $key => $value) {
          unset($flag);
          foreach ($temp_time_slot as $key => $temp_slot) {
            $values = explode(':', $value)[0] . ':' . explode(':', $value)[1];
            $slots  = explode(':', $temp_slot)[0] . ':' . explode(':', $temp_slot)[1];
            if ($values == $slots) {
              $time_slots[] = explode(':', $value)[0] . ':' . explode(':', $temp_slot)[1] .':00';
              $flag = 1;
            } 
          }
          if (!isset($flag))
            $time_slots[] = $value.':00';
        }

       return view('nurse-automatic.print', compact('time_slots', 'nurse_master','nurse_entered','working_weight', 'sheet_date', 'current_weight','corrected_gestation','ip_details','baby','oral_drugs','drugs_gen','temp_iv_drugs','output_groups', 'temp_infusion_drug','master_drugs','temp_otherdrugs_groups','temp_antibio_groups', 'temp_output_groups','milk_feeds','temp_milk_feeds','replacement_fluids', 'temp_replacement_fluids','temp_pn_fluids', 'closewinlink','ivfluids','pn_fluids','result', 'baby_observe', 'respiratorty_support', 'phototherapy', 'phototherapy_eyes', 'code_phototherapy', 'code_phototherapy_eyes', 'prescription_fluid', 'time', 'drugs_list', 'start_working_time'));
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

    public function addmultiple_replacement($emr_log_head_id, $input_value, $value_name,$observation_type_id = 0) 
    {
            $sub_sheet_values["local_code"]         = $value_name;
            $sub_sheet_values["value"]              = $input_value;
            $sub_sheet_values["log_header_id"]      = $emr_log_head_id; 
            $sub_sheet_values["observe_id"]         = $observation_type_id;  
        
            $emr_log_id =  NurseHourSheet::create($sub_sheet_values)->id;
            return $emr_log_id;

    }

    public function addemrlog($id, $baby_details, $sender_time, $input, $admission_id, $added_nurse) {
        $main_sheet['sender']         = env('APP_NAME');  
        $main_sheet['gender']         = $baby_details->Sex;
        $main_sheet['sender_time']    = $sender_time;
        $main_sheet['visit_date']     = date('Y-m-d H:i:s', strtotime($input['sheet_date']));
        $main_sheet['loinc_version']  = 2.63;
        $main_sheet['active_flag']    = 'Y';
        $main_sheet['create_user_id'] = $this->auth->user()->name;
        $main_sheet['create_tstamp']  = date('Y-m-d H:i:s', time());
        $main_sheet['modify_user_id'] = $this->auth->user()->name;
        $main_sheet['modify_tstamp']  = date('Y-m-d H:i:s', time());
        $main_sheet['day_id']         = isset($id) ? $id : null;
        $main_sheet['baby_id']        = isset($input['BabyId']) ? $input['BabyId'] : null;
        $main_sheet['mother_id']      = isset($baby_details->MotherId) ? $baby_details->MotherId : null;
        $main_sheet['admission_id']   = isset($admission_id) ? $admission_id : null;
        $main_sheet['added_nurse']    = $added_nurse;
        $emr_log_head_id              = EmrLogHeader::create($main_sheet)->id;
        return $emr_log_head_id;
    }

    /**
     * This method to get the previous day ivfluids
     *
     * @param $baby_id type integer 
     * @param $admission_id type integer 
     * @param $previous_day type array of object of previous day data 
     *
     * @return type array with previous day iv fluids 
     */

    public function getPreviousIvfluids($baby_id, $admission_id, $previous_day)
    {
        $iv_fluids_previous = null;

        $previous_day = isset($previous_day) ? $previous_day : [];

        if (count($previous_day) > 0) {

          $old_drug = EmrLogDetails::Getpreviousdata($previous_day->id, DialpadSupportProperty::DRUG_FLUIDS);

          $old_drug_solution = $old_drug->where('local_code', DialpadSupportProperty::DRUG_FLUIDS_SOLUTION);

           foreach ($old_drug_solution as $old_drug_key => $old_drug_value) {
             $temp_iv_fluids = null;
             $temp_iv_fluids[DialpadSupportProperty::DRUG_FLUIDS_SOLUTION] = $old_drug_value->intf_ref_value;
             $temp_iv_fluids[DialpadSupportProperty::DRUG_FLUIDS_RATE]     = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::DRUG_FLUIDS_RATE)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::DRUG_FLUIDS_TOTAL]    = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::DRUG_FLUIDS_TOTAL)->pluck('intf_ref_value')->first();
             $iv_fluids_previous[] = $temp_iv_fluids;            
           }
        }

        return $iv_fluids_previous;
    }

    public function getUpdateToDateFluids($baby_id, $admission_id) 
    {
      $iv_fluids_previous = $old_drugs = array();

      for ($i = 0; $i < 24; $i++) { 
        $i = strlen($i) == 1 ? '0'.$i : $i;
        $today_start   = Carbon::now($this->time_zone)->format('Y-m-d '.$i.':00:00');
        $today_current = Carbon::now($this->time_zone)->format('Y-m-d '.$i.':59:59');      
        $old_drug[$i]  = array_slice(EmrLogDetails::GetFhirPrescribeddata(DialpadSupportProperty::PRESCRIBED_DRUG_FLUIDS, $baby_id, $admission_id, $today_start, $today_current), 0, 3);
       
        $old_drugs =  array_merge($old_drugs, $old_drug[$i]);
      }

      $old_drug_solution = collect($old_drugs)->where('local_code', DialpadSupportProperty::PRESCRIBED_DRUG_SOLUTION);

      $slug = 0;

      foreach ($old_drug_solution as $old_drug_key => $old_drug_value) {
        $temp_iv_fluids = null;

        if(isset($temp_iv_fluids[DialpadSupportProperty::DRUG_FLUIDS_SOLUTION])){

          $temp_iv_fluids[DialpadSupportProperty::DRUG_FLUIDS_SOLUTION] = is_numeric($old_drug_value->intf_ref_value) ? $old_drug_value->intf_ref_value : IvFluids::getDrugID($old_drug_value->intf_ref_value)->id;

          if (count(collect($old_drugs)->where('local_code', DialpadSupportProperty::PRESCRIBED_DRUGS_RATE)->pluck('intf_ref_value')) > 0)
            $temp_iv_fluids[DialpadSupportProperty::DRUG_FLUIDS_RATE]     = collect($old_drugs)->where('local_code', DialpadSupportProperty::PRESCRIBED_DRUGS_RATE)->pluck('intf_ref_value')[$slug];
          else
            $temp_iv_fluids[DialpadSupportProperty::DRUG_FLUIDS_RATE]     = '';

          if (count(collect($old_drugs)->where('local_code', DialpadSupportProperty::PRESCRIBED_DRUG_TOTAL)->pluck('intf_ref_value')) > 0)
            $temp_iv_fluids[DialpadSupportProperty::DRUG_FLUIDS_TOTAL]    = collect($old_drugs)->where('local_code', DialpadSupportProperty::PRESCRIBED_DRUG_TOTAL)->pluck('intf_ref_value')[$slug];
          else
            $temp_iv_fluids[DialpadSupportProperty::DRUG_FLUIDS_TOTAL]    = '';

          $iv_fluids_previous[] = $temp_iv_fluids;
          $slug++;      
        }  
      }

      return $iv_fluids_previous;
    }
    /**
     * This method to get the previous day ivfluids
     *
     * @param $baby_id type integer 
     * @param $admission_id type integer 
     * @param $previous_day type array of object of previous day data 
     *
     * @return type array with previous day iv fluids 
     */

    public function getPreviousReplacementfluids($baby_id, $admission_id, $previous_day)
    {
        $replacement_previous_fluids = null;

        if (count($previous_day) > 0) {

          $old_drug = NurseHourSheet::Getpreviousdata($previous_day->id, DialpadSupportProperty::REPLACMENT_FLUIDS);
          $old_drug_solution = $old_drug->where('local_code', DialpadSupportProperty::REPLACMENT_FLUIDS_SOLUTION);

           foreach ($old_drug_solution as $old_drug_key => $old_drug_value) {
             $temp_replacement_fluids = null;
             $temp_replacement_fluids[DialpadSupportProperty::REPLACMENT_FLUIDS_SOLUTION] = $old_drug_value->value;
             $temp_replacement_fluids[DialpadSupportProperty::REPLACMENT_FLUIDS_RATE]     = $old_drug->where('observe_id', $old_drug_value->id)->where('local_code', DialpadSupportProperty::REPLACMENT_FLUIDS_RATE)->pluck('value')->first();
             $temp_replacement_fluids[DialpadSupportProperty::REPLACMENT_FLUIDS_TOTAL]    = $old_drug->where('observe_id', $old_drug_value->id)->where('local_code', DialpadSupportProperty::REPLACMENT_FLUIDS_TOTAL)->pluck('value')->first();
             $replacement_previous_fluids[] = $temp_replacement_fluids;            
           
           }
        }

        return $replacement_previous_fluids;

    }

    /**
     * This method to get the previous day ivfluids
     *
     * @param $baby_id type integer 
     * @param $admission_id type integer 
     * @param $previous_day type array of object of previous day data 
     *
     * @return type array with previous day iv fluids 
     */

    public function getPreviousantibiotic($baby_id, $admission_id, $previous_day)
    {
        $antibiotic_previous = null;

        if (count($previous_day) > 0) {

          $old_antibiotic = EmrLogDetails::Getpreviousdata($previous_day->id, DialpadSupportProperty::A_ANTIBIOTIC_GROUP);

          $old_antibiotic_solution = $old_antibiotic->where('local_code', DialpadSupportProperty::A_ANTIBIOTIC);

           foreach ($old_antibiotic_solution as $old_antibiotic_key => $old_antibiotic_value) {
             $temp_antibiotic_fluids = null;
             $temp_antibiotic_fluids[DialpadSupportProperty::A_ANTIBIOTIC] = $old_antibiotic_value->intf_ref_value;
             $temp_antibiotic_fluids[DialpadSupportProperty::A_DAY]        = $old_antibiotic->where('observation_type_id', $old_antibiotic_value->log_id)->where('local_code', DialpadSupportProperty::A_DAY)->pluck('intf_ref_value')->first();
             $antibiotic_previous[] = $temp_antibiotic_fluids;            
           }
        }

        return $antibiotic_previous;

    }

    
   
    /**
     * This method to get the previous day ivfluids
     *
     * @param $baby_id type integer 
     * @param $admission_id type integer 
     * @param $previous_day type array of object of previous day data 
     *
     * @return type array with previous day iv fluids 
     */
    public function getOtherdrugs($baby_id, $admission_id, $previous_day)
    {
        $other_drugs_previous = null;

        if (count($previous_day) > 0) {

          $old_drugs_solution = EmrLogDetails::Getpreviousdata($previous_day->id, [DialpadSupportProperty::OTHER_DRUGS]);
           

           foreach ($old_drugs_solution as $old_drugs_key => $old_drugs_value) {
             $temp_drugs_fluids = null;
             $temp_drugs_fluids[DialpadSupportProperty::OTHER_DRUGS] = $old_drugs_value->intf_ref_value;
             $other_drugs_previous[] = $temp_drugs_fluids;            
           }
        }

        return $other_drugs_previous;

    }
    public function getPreviousMilkVolume($baby_id, $admission_id, $previous_day) {

      $milk_feeds = collect(EmrLogDetails::Getpreviousdata($previous_day->id, ['milk_volume_total'])->first())->toArray();
      $milk_feeds = isset($milk_feeds['intf_ref_value']) ? $milk_feeds['intf_ref_value'] : 0;
      return $milk_feeds;
    }

    /**
     * This method to get running total of the fluids 
     *
     * @param $baby_id type integer
     * @param $admission_id type integer 
     * @param $date type date 
     * @param $time
     * @param $fluidsids 
     */
    public function calculaterunningtotal(Request $request)
    {
        $input =  $request->all();

        $nurse = NurseSheetMain::GetNurseSheet($input['sheetDate'], $input['babyId'], $input['admissionId']);

        $drug_name = str_replace('[]', '', $input['drugName']);

         if (count($nurse) == 0) {
             return \Response::json(['total'=>$input['drugRate']], 200);
         } 

         switch ($drug_name) {
            case 'drug_solution':
              $log_dtl = NurseSheetMain::getrunningfluids($nurse->id, $drug_name, $input['drugId'])->pluck('id')->toArray();
              $rate    = NurseSheetMain::getfluidsrate($log_dtl, 'drug_rate')->pluck('intf_ref_value')->toArray();
            break;
            case 'replacement_fluids_solution':
              $log_dtl = NurseSheetMain::getreplacementrunningfluids($nurse->id, $drug_name, $input['drugId'])->pluck('id')->toArray(); 
              $rate    = NurseSheetMain::getreplacementfluidsrate($log_dtl, 'replacement_fluids_rate')->pluck('value')->toArray();
            break;
           default:
              $rate = NurseSheetMain::getrunningoutput($nurse->id, $drug_name)->pluck('intf_ref_value')->toArray(); 
             break;
         }

         $total = 0;

         if ($drug_name != 'bowels') {
           foreach ($rate as $rate_value) {
              if ($rate_value != '') {
                  $total = $total + $rate_value;
              }
           }
           $input['drugRate'] = ($input['drugRate'] != '') ? $input['drugRate'] : 0;
           $total = $total + $input['drugRate'];

         } elseif($drug_name == 'bowels') {
            foreach ($rate as $rate_value) {
              if ($rate_value != '' && $rate_value == 'on') {
                  $total = $total + 1;
              }                    
            }

            $input['drugRate'] = ($input['drugRate'] == 'true') ? 1 : 0; 

            $total = $total + $input['drugRate'];            
              
         }
         
        return \Response::json(['total'=>$total], 200);
    }

    /**
     * This method to get running total of the fluids 
     *
     * @param $baby_id type integer
     * @param $admission_id type integer 
     * @param $date type date 
     * @param $time
     * @param $fluidsids 
     */

     public function getsporturinetotal(Request $request) 
     {
          $input =  $request->all();
          $nurse = NurseSheetMain::getspoturineoutput($input['sheetDate'], $input['babyId'], $input['admissionId'],'urine_output');
          $input['timeHour']    = strlen($input['timeHour']) > 1 ? $input['timeHour']: '0'.$input['timeHour'];
          $input['timeMiniuts'] = strlen($input['timeMiniuts']) > 1 ? $input['timeMiniuts']: '0'.$input['timeMiniuts'];
          $time_sheet =  $input['sheetDate'].' '.$input['timeHour'].':'.$input['timeMiniuts'].' '.$input['timeSession'];

          $time_sheet      = date('Y-m-d h:i a' ,strtotime($time_sheet));
          $site_settings   = Settings::get();

          $input_time      = date('H', strtotime($time_sheet));
          $nurse_start     = date('H', strtotime($site_settings[0]->nurse_entry_start));

          $adjustable_time = Carbon::createFromFormat('h:i a', $site_settings[0]->nurse_entry_start)->subHour(3);
          $adjustable_time = date('H', strtotime($adjustable_time));

          $urine_total = '';
          if ($input_time > $adjustable_time && $input_time < $nurse_start) {
            $urine_total = NurseSheetMain::getspoturineoutput($input['sheetDate'], $input['babyId'], $input['admissionId'],'urine_total');
            $urine_total = $input['currentUrine'] + $urine_total->intf_ref_value;
          }

         
          if (count($nurse) > 0) {
                $current_time_sheet_hour = Carbon::createFromFormat('Y-m-d h:i a', $time_sheet);
                $nurse->sender_time      = date('Y-m-d h:i a' ,strtotime($nurse->sender_time));
                $last_time_sheet_hour    = Carbon::createFromFormat('Y-m-d h:i a', $nurse->sender_time);
                $differentHours = $current_time_sheet_hour->diffInHours($last_time_sheet_hour);

                if ($differentHours != '' && $differentHours != 0) {
                    $urine_spot =   ($input['currentUrine'] - $nurse->intf_ref_value) / $differentHours; 
                } else {
                    $urine_spot =   ($input['currentUrine'] - $nurse->intf_ref_value);
                }
  
          } else {

              $urine_spot =  '' ;
          }
           $urine_spot = number_format($urine_spot, 2);

           return \Response::json(['result'=>$urine_spot,'urineTotal'=>$urine_total],200);

     }

 public function addmultiplelist($emr_log_head_id, $input_value, $result, $observation_type_id = 0) 
 {
            $result  = collect($result)->toArray();
            $sub_sheet_values["log_hdr_id"]         = $emr_log_head_id;
            $sub_sheet_values["loinc_local_map_id"] = $result['ref_loc_master_id'];
            $sub_sheet_values["loinc_code"]         = $result['loinc_code']; 
            $sub_sheet_values["loinc_version"]      = $result['loinc_version'];  
            $sub_sheet_values["intf_ref_name"]      = 'None'; 
            $sub_sheet_values["intf_ref_value"]     = $input_value;  
            $sub_sheet_values["component"]          = $result['component']; 
            $sub_sheet_values["property"]           = $result['property']; 
            $sub_sheet_values["time"]               = Carbon::now($this->time_zone)->format('H:i:s');
            $sub_sheet_values["system"]             = $result["system"];
            $sub_sheet_values["scale"]              = $result["scale_typ"];
            $sub_sheet_values["method"]             = $result["method_typ"];
            $sub_sheet_values["classtype"]          = $result["classtype"];
            $sub_sheet_values["active_flag"]        = $result["active_flag"];
            $sub_sheet_values["create_user_id"]     = $this->auth->user()->name;
            $sub_sheet_values["create_tstamp"]      = date('Y-m-d H:i:s', time());
            $sub_sheet_values["modify_user_id"]     = $this->auth->user()->name;
            $sub_sheet_values["modify_tstamp"]      = date('Y-m-d H:i:s', time());
            $sub_sheet_values['observation_type_id'] = $observation_type_id;
            $emr_log_id =  EmrLogDetails::create($sub_sheet_values)->id;
            return $emr_log_id;

    }
 
    /**
     * This method to get the previous day ivfluids
     *
     * @param $baby_id type integer 
     * @param $admission_id type integer 
     * @param $previous_day type array of object of previous day data 
     *
     * @return type array with previous day iv fluids 
     */
    public function getivdrugsinfusion($baby_id, $admission_id, $previous_day)
    { 
       $iv_fluids_infusion = null;

        if (count($previous_day) > 0) {

          $old_drug = EmrLogDetails::Getpreviousdata($previous_day->id, DialpadSupportProperty::INFUSION_GROUP);

          $old_drug_solution = $old_drug->where('local_code', DialpadSupportProperty::INFUSION_DAY);

           foreach ($old_drug_solution as $old_drug_key => $old_drug_value) {
             $temp_iv_fluids = null;
             $temp_iv_fluids[DialpadSupportProperty::INFUSION_DAY]             = $old_drug_value->intf_ref_value;
             $temp_iv_fluids[DialpadSupportProperty::INFUSION_BRANDNAME]       = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::INFUSION_BRANDNAME)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::INFUSION_PHARMACOLOGICAL] = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::INFUSION_PHARMACOLOGICAL)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::INFUSION_DOSE]            = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::INFUSION_DOSE)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::INFUSION_DOSE_UNITS]      = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::INFUSION_DOSE_UNITS)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::INFUSION_QUANTITY]        = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::INFUSION_QUANTITY)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::INFUSION_QUANTITY_UNITS]  = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::INFUSION_QUANTITY_UNITS)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::INFUSION_SYRINGE]         = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::INFUSION_SYRINGE)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::INFUSION_RATE]            = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::INFUSION_RATE)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::INFUSION_INSTRUCTION]     = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::INFUSION_INSTRUCTION)->pluck('intf_ref_value')->first();

             $temp_iv_fluids[DialpadSupportProperty::INFUSION_DATE_PRESCRIBED]  = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::INFUSION_DATE_PRESCRIBED)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::INFUSION_TIME_PRESCRIBED]  = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::INFUSION_TIME_PRESCRIBED)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::INFUSION_DATE_STOPPED]     = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::INFUSION_DATE_STOPPED)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::INFUSION_TIME_STOPPED]     = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::INFUSION_TIME_STOPPED)->pluck('intf_ref_value')->first();

             $iv_fluids_infusion[] = $temp_iv_fluids;            
           }
        }
        return $iv_fluids_infusion;

    }

    /**
     * This method to get the previous day ivfluids
     *
     * @param $baby_id type integer 
     * @param $admission_id type integer 
     * @param $previous_day type array of object of previous day data 
     *
     * @return type array with previous day iv fluids 
     */
    public function getivspecialfluids($baby_id, $admission_id, $previous_day)
    { 
       $iv_drugs = null;

        if (count($previous_day) > 0) {

          $old_drug = EmrLogDetails::Getpreviousdata($previous_day->id, DialpadSupportProperty::SPEICAL_IV_GROUP);

          $old_drug_solution = $old_drug->where('local_code', DialpadSupportProperty::SPEICAL_IV_DAY);

           foreach ($old_drug_solution as $old_drug_key => $old_drug_value) {
             $temp_iv_fluids = null;
             $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_DAY]         = $old_drug_value->intf_ref_value;
             $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_NAME_ONE]    = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::SPEICAL_IV_NAME_ONE)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_NAME_TWO]    = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::SPEICAL_IV_NAME_TWO)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_VOL_ONE]     = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::SPEICAL_IV_VOL_ONE)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_VOL_TWO]     = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::SPEICAL_IV_VOL_TWO)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_SYRINGE]     = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::SPEICAL_IV_SYRINGE)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_DEXTROSE]    = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::SPEICAL_IV_DEXTROSE)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_GLUCOSE]     = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::SPEICAL_IV_GLUCOSE)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_RATE]        = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::SPEICAL_IV_RATE)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_INSTRUCTION] = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::SPEICAL_IV_INSTRUCTION)->pluck('intf_ref_value')->first();

             $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_DATE_PRESCRIBED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::SPEICAL_IV_DATE_PRESCRIBED)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_TIME_PRESCRIBED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::SPEICAL_IV_TIME_PRESCRIBED)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_DATE_STOPPED]    = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::SPEICAL_IV_DATE_STOPPED)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_TIME_STOPPED]    = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::SPEICAL_IV_TIME_STOPPED)->pluck('intf_ref_value')->first();

             $iv_drugs[] = $temp_iv_fluids;            
           }
        }


        return $iv_drugs;
    }

    /**
     * This method to get the previous day other iv infusions 
     *
     * @param $baby_id type integer 
     * @param $admission_id type integer 
     * @param $previous_day type array of object of previous day data 
     *
     * @return type array with previous day iv fluids 
     */
    public function getotherivinfusion($baby_id, $admission_id, $previous_day)
    { 
       $iv_drugs = null;

        if (count($previous_day) > 0) {

          $old_drug = EmrLogDetails::Getpreviousdata($previous_day->id, DialpadSupportProperty::OTHER_INFUTION_GROUP);

          $old_drug_solution = $old_drug->where('local_code', DialpadSupportProperty::OTHER_IV_INFU_DAY);

           foreach ($old_drug_solution as $old_drug_key => $old_drug_value) {
             $temp_iv_fluids = null;
             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_INFU_DAY]         = $old_drug_value->intf_ref_value;
             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_INFU_PHARAM]      = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::OTHER_IV_INFU_PHARAM)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_INFU_VOL]         = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::OTHER_IV_INFU_VOL)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_INFU_DURATION]    = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::OTHER_IV_INFU_DURATION)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_INFU_DURA_METHOD] = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::OTHER_IV_INFU_DURA_METHOD)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_INFU_RATE]        = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::OTHER_IV_INFU_RATE)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_INSTRUCTION]      = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::OTHER_IV_INSTRUCTION)->pluck('intf_ref_value')->first();

             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DATE_PRESCRIBED]   = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::OTHER_IV_DATE_PRESCRIBED)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_TIME_PRESCRIBED]   = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::OTHER_IV_TIME_PRESCRIBED)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DATE_STOPPED]      = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::OTHER_IV_DATE_STOPPED)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_TIME_STOPPED]      = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::OTHER_IV_TIME_STOPPED)->pluck('intf_ref_value')->first();

             $iv_drugs[] = $temp_iv_fluids;            
           }
        }

        return $iv_drugs;

    }

    /**
     * This method to get the previous day other iv drugs 
     *
     * @param $baby_id type integer 
     * @param $admission_id type integer 
     * @param $previous_day type array of object of previous day data 
     *
     * @return type array with previous day iv fluids 
     */
    public function getotherivdrugs($baby_id, $admission_id, $previous_day)
    { 
       $iv_drugs = null;

        if (count($previous_day) > 0) {

          $old_drug = EmrLogDetails::Getpreviousdata($previous_day->id, DialpadSupportProperty::OTHER_IV_DRUGS_GROUP);

          $old_drug_solution = $old_drug->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_DAY);

           foreach ($old_drug_solution as $old_drug_key => $old_drug_value) {
             $temp_iv_fluids = null;
             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_DAY]           = $old_drug_value->intf_ref_value;
             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_BARAND]        = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_BARAND)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_PHARAM]        = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_PHARAM)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_DOSE_REQUIRED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_DOSE_REQUIRED)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_FREQUENCY]     = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_FREQUENCY)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_VOL_DOSE]      = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_VOL_DOSE)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_ADDITIONAL]    = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_ADDITIONAL)->pluck('intf_ref_value')->first();

             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_DATE_PRESCRIBED]    = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_DATE_PRESCRIBED)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_TIME_PRESCRIBED]    = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_TIME_PRESCRIBED)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_DATE_STOPPED]       = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_DATE_STOPPED)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_TIME_STOPPED]       = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_TIME_STOPPED)->pluck('intf_ref_value')->first();
          

             $iv_drugs[] = $temp_iv_fluids;            
           }
        }

        return $iv_drugs;

    }

    /**
     * This method to get the previous day ivfluids
     *
     * @param $baby_id type integer 
     * @param $admission_id type integer 
     * @param $previous_day type array of object of previous day data 
     *
     * @return type array with previous day iv fluids 
     */
    public function getoraldrugs($baby_id, $admission_id, $previous_day)
    { 
       $oral_drugs = null;

        if (count($previous_day) > 0) {

          $old_drug = EmrLogDetails::Getpreviousdata($previous_day->id, DialpadSupportProperty::ORALDRUG_GROUP);

          $old_drug_solution = $old_drug->where('local_code', DialpadSupportProperty::ORALDRUG_DAY);

           foreach ($old_drug_solution as $old_drug_key => $old_drug_value) {
             $temp_iv_fluids = null;
             $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_DAY]           = $old_drug_value->intf_ref_value;
             $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_BRANDNAME]     = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::ORALDRUG_BRANDNAME)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_GENERICNAME]   = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::ORALDRUG_GENERICNAME)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_DOSE]          = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::ORALDRUG_DOSE)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_FREQUENCY]     = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::ORALDRUG_FREQUENCY)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_ROUTE]          = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::ORALDRUG_ROUTE)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_ADDITIONAL]     = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::ORALDRUG_ADDITIONAL)->pluck('intf_ref_value')->first();

             $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_DATE_PRESCRIBED]  = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::ORALDRUG_DATE_PRESCRIBED)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_TIME_PRESCRIBED]  = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::ORALDRUG_TIME_PRESCRIBED)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_DATE_STOPPED]     = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::ORALDRUG_DATE_STOPPED)->pluck('intf_ref_value')->first();
             $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_TIME_STOPPED]     = $old_drug->where('observation_type_id', $old_drug_value->log_id)->where('local_code', DialpadSupportProperty::ORALDRUG_TIME_STOPPED)->pluck('intf_ref_value')->first();

             $oral_drugs[] = $temp_iv_fluids;            
           }
        }

        return $oral_drugs;

    }

}
