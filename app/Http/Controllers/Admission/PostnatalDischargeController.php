<?php

namespace App\Http\Controllers\Admission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
// use App\Models\Masters\Drug;
use App\Models\Masters\DrugIvFluidMaster;
use App\Models\PostnatalDischarge;
use App\Models\Medications;
use App\Models\Masters\ProcedureMaster;
use App\Models\Baby;
use App\Http\Controllers\Flow\FlowController;
use App\Models\Admission;
use App\Models\Nicu;
use Carbon\Carbon;
use App\Models\PostDaycare;
use App\Models\Postnatal;

/**
 * All the curd of problem base daycare goes here
 *
 * @author Manikandan M
 */
class PostnatalDischargeController extends Controller
{
    /**
     * Initalize authorization object
     * @var $auth type object 
     */
     public $auth;

    /**
     * Initalize flowcontrol object
     * @var $flow type object 
     */
     public $flow;
     
    /** 
     * Initalize time zone
     * @var $zone
     */
     public $zone;


    /**
     * Constructor Method
     *
     * Initiate the module 
     *
     */
    public function __construct(Guard $auth, FlowController $flow)
    {

        $this->middleware('role:POST_DISCHARGE,write', ['only' => ['store', 'update', 'edit', 'create', 'show', 'destroy']]);
        $this->middleware('role:POST_DISCHARGE,read', ['only' => ['index', 'printData']]);
        $this->auth = $auth;
        $this->flow = $flow;
        $this->zone = env('TIME_ZONE');
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $limit = 50;
        if (!empty($request->input('limit'))) {
            $request->session()->put('limit', $request->input('limit'));
            $limit = $request->session()->get('limit');
        } elseif ($request->session()->has('limit')) {
            $limit = $request->session()->get('limit');
        }


        $order['sortby']    = 'baby.BabyId';
        $order['sortorder'] = 'desc';  

        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {
          $order['sortby']     = \SiteHelpers::decrypt_id($request->input('sortby'));
          $order['sortorder']  = $request->input('sortorder');
        }    

        $search = array();
        $search['search_txt'] = '';

        if (!empty($request->input('search_txt'))) {
            $search['search_txt'] = $request->input('search_txt');
        }

        $navigate['main_nav'] = 'postnatal';
        $navigate['sub_nav']  = 'post_discharge';

        $status = !empty($request->input('status')) ? $request->input('status') : 'inpatient';

        $page = !empty($request->input('page')) ? $request->input('page') : 1;
        $page = preg_replace( '/[^0-9]/', '', $page);

        $result     = PostnatalDischarge::get_lists($page, $limit, $search, $order, 1, $status);
        $results    = $result['result'];

        $getTotal   = PostnatalDischarge::GetTotal();
        $total      = $result['total']; 

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

        foreach ($results as $key => $value) {
             $discharge_details = PostnatalDischarge::GetDischareStatus($value->BabyId);
             if (isset($discharge_details->discharge_status) && $discharge_details->discharge_status == 'Inpatient') {
                $results[$key]->discharge_status = 'info';
             } else {
                $results[$key]->discharge_status = 'success';
 
             }

        }
        $this->flow->clearFlow();

       return view('discharge.postnatal.babylist', compact('results', 'navigate', 'pagination', 'order', 'search', 'getTotal'));

      
    }

    public function postnatalDischargelist(Request $request, $baby_id)
    {
         $baby_id = \SiteHelpers::decrypt_id($baby_id);
         $admissionList = PostnatalDischarge::GetDischargelist($baby_id);

         $baby_name = '';
         if (isset($admissionList[0])) {
            $baby_name = $admissionList[0]->BabyName.' - '.$admissionList[0]->BMrNo;
 
         }
         
        $navigate['main_nav'] = 'postnatal';
        $navigate['sub_nav']  = 'post_discharge';


        return view('discharge.postnatal.admission_list', compact('baby_name', 'admissionList', 'navigate'));
        
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $input = $request->all();

        $id               =  \SiteHelpers::decrypt_id($id);
        $timeList         =  \SiteHelpers::prepare_time();
        $drungList        =   DrugIvFluidMaster::ListData()->where('status', 1)->pluck('brand_name', 'id')->toArray();
        $drungList1       =   DrugIvFluidMaster::all()->where('type', 'ORAL')->where('status', 1)->pluck('brand_name', 'id')->toArray();
        $dischargeList    =   PostnatalDischarge::find($id);
        $background_details = Baby::find($dischargeList->BabyId); 

        $baby             =   Baby::find($dischargeList->BabyId);
        $baby->Gestation  =  \SiteHelpers::convert_gestation_days($baby->Gestation);
        $temp_acive_menu  = isset($input['temp_acive_menu']) ? $input['temp_acive_menu'] : 'dischargeform';
        $SubmitButtonText = 'Update';
        $navigate['main_nav'] = 'postnatal';
        $navigate['sub_nav'] = 'post_discharge';
        $medications      = Medications::get_medicines_details($dischargeList->BabyId, $dischargeList->AdmissionId, 1);
        $medications      = (count($medications) > 0) ? \SiteHelpers::convert_obj_to_array($medications) : null;
        $vaccine          = json_decode($dischargeList->vaccine);
        $vaccine          = (count($vaccine) > 0) ? \SiteHelpers::convert_obj_to_array($vaccine) : null;

        $dischargeList->appoinment_date =  !is_null($dischargeList->appoinment_date) ?  date('d-m-Y', strtotime($dischargeList->appoinment_date)) : '';
        $dischargeList['dcg_weeks']     = isset(json_decode($dischargeList['cgd'])->dcg_weeks) ? json_decode($dischargeList['cgd'])->dcg_weeks : '';
        $dischargeList['dcg_days']      = isset(json_decode($dischargeList['cgd'])->dcg_days) ? json_decode($dischargeList['cgd'])->dcg_days : '';
        
         $procedure_temp = ProcedureMaster::ListData()->where('Status', 'Active')->toArray();

         $procedure_master[0] = 'N/A';

         foreach ($procedure_temp as $data) {

                $procedure_master[$data->Id] = $data->Name;
         }

         $dischargeList['procedures'] = (isset($dischargeList['procedures']) && count(json_decode($dischargeList['procedures'])) > 0) ?  json_decode($dischargeList['procedures']) : array();
         $dischargeList->discharge_date = !is_null($dischargeList->discharge_date) ?  date('d-m-Y', strtotime($dischargeList->discharge_date)) : null;

        $summaryLink = action('Reports\PostnatalDischargeSummary@show', \SiteHelpers::encrypt_id($dischargeList->BabyId.'-'.$dischargeList->AdmissionId));

        $admission_list     = Admission::find($dischargeList->AdmissionId);

        $babyIdentification = 'Postnatal History of '.$baby->BabyName.' - '.$baby->BMrNo.'-'.$admission_list->episodes;

        $daycare_diagnosis = PostDaycare::get_previous_daycare($dischargeList->AdmissionId);

        if (isset($daycare_diagnosis->Background)) {
            $background_details->Background = $daycare_diagnosis->Background;
        }

        $dischargeList['diagnosis'] = (empty($dischargeList['diagnosis'])) ? $background_details->Background : $dischargeList['diagnosis']; 

        $bed_id  = isset($input['bed_id']) ? $input['bed_id'] : '';
        $next_module  = isset($input['next_module']) ? $input['next_module'] : isset($input['module']) ? $input['module'] : '';

        $admissionList    =   Postnatal::find($id);
        $hospital_name = isset($admissionList->hospital_name) ? $admissionList->hospital_name : null;
        
       return view('discharge.postnatal.edit', compact('timeList', 'id', 'babyIdentification', 'summaryLink','drungList1', 'temp_acive_menu','baby','drungList', 'procedure_master', 'dischargeList', 'navigate', 'SubmitButtonText', 'medications', 'vaccine', 'bed_id', 'next_module', 'hospital_name')); 
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
        $print_flag = isset($input['print_flag']) ? $input['print_flag'] : 0;

        unset($input['print_flag']);

         $input['AdmissionId']  = (isset($input['AdmissionId']) && !empty($input['AdmissionId'])) ?  $input['AdmissionId'] : null; 
         $input["discharge_date"] = (isset($input['discharge_date']) && !empty($input['discharge_date'])) ? date('Y-m-d', strtotime($input['discharge_date'])) : null;   
         $input["diedTime"] = (isset($input['diedTime']) && !empty($input['diedTime'])) ? $input['diedTime'] : null;   
         $input["diedMins"] = (isset($input['diedMins']) && !empty($input['diedMins'])) ? $input['diedMins'] : null;   
         $input["discharge_dol"] = (isset($input['discharge_dol']) && !empty($input['discharge_dol'])) ? $input['discharge_dol'] : null;   

         if (isset($input['dcg_weeks']) && isset($input['dcg_days'])) {
            $input["cgd"]    = json_encode(['dcg_weeks'=>$input['dcg_weeks'], 'dcg_days'=>$input['dcg_days']]);
         }

         $input["discharge_wt"] = (isset($input['discharge_wt']) && !empty($input['discharge_wt'])) ? $input['discharge_wt'] : null;   
         $input["discharge_ofc"] = (isset($input['discharge_ofc']) && !empty($input['discharge_ofc'])) ? $input['discharge_ofc'] : null;   
         $input["discharge_length"] = (isset($input['discharge_length']) && !empty($input['discharge_length'])) ? $input['discharge_length'] : null;   

         if (isset($input["Vaccine"])) {
            foreach ($input["Vaccine"] as $key => $value) {

                if (isset($input["Vaccine"][$key]) && isset($input["VaccineDate"][$key])) {

                     $tempVaccine["vaccine"] = $input["Vaccine"][$key];
                     $tempVaccine["vaccinedate"] = $input["VaccineDate"][$key]; 
                     $input["vaccine"][]  = $tempVaccine;

                }  
          }
      }

          $input["vaccine"] = (isset($input["vaccine"]) && $input["vaccine"] != '') ? json_encode($input["vaccine"]) : null;
          $input["postductal_spo2"]   = (isset($input["postductal_spo2"]) && !empty($input["postductal_spo2"])) ? $input["postductal_spo2"] : null;
          $input["appoinment_status"] = (isset($input["appoinment_status"]) && $input["appoinment_status"] == 'on') ? true : false ;
          $input["appoinment_date"]   = (isset($input['appoinment_date']) && !empty($input['appoinment_date'])) ? date('Y-m-d', strtotime($input['appoinment_date'])) : null;   
          $input["appoinment_hrs"]    = (isset($input['appoinment_hrs']) && !empty($input['appoinment_hrs']))  ?  $input['appoinment_hrs'] : null;  
          $input["appoinment_min"]    = (isset($input['appoinment_min']) && $input['appoinment_min']!= '')  ?  $input['appoinment_min'] : null;  
          $input["discharge_hb"]       = (isset($input['discharge_hb']) && !empty($input['discharge_hb']))  ?  $input['discharge_hb'] : null;  
          $input["discharge_pcv"]      = (isset($input['discharge_pcv']) && !empty($input['discharge_pcv']))  ?  $input['discharge_pcv'] : null;  
          $input["discharge_tsb"]      = (isset($input['discharge_tsb']) && !empty($input['discharge_tsb']))  ?  $input['discharge_tsb'] : null;  
          $input["direct_bilirubin"]   = (isset($input['direct_bilirubin']) && !empty($input['direct_bilirubin']))  ?  $input['direct_bilirubin'] : null;  
          $input["dischargeserum_ca"]  = (isset($input['dischargeserum_ca']) && !empty($input['dischargeserum_ca']))  ?  $input['dischargeserum_ca'] : null;  
          $input["dischargeserum_po4"] = (isset($input['dischargeserum_po4']) && !empty($input['dischargeserum_po4']))  ?  $input['dischargeserum_po4'] : null;  
          $input["dischargeserum_alp"] = (isset($input['dischargeserum_alp']) && !empty($input['dischargeserum_alp']))  ?  $input['dischargeserum_alp'] : null;  
          
          $input["typeoftreatment_left"]  = ($input["typeoftreatment_left"] != '') ? json_encode($input["typeoftreatment_left"])  : null;
          $input["typeoftreatment_right"] = ($input["typeoftreatment_right"] != '') ? json_encode($input["typeoftreatment_right"])  : null;

          $input['procedures']            = (isset($input['procedures']) && is_array($input['procedures'])) ? json_encode($input['procedures']) : json_encode(array()); 
          $input["dischargeserum_na"] = (isset($input['dischargeserum_na']) && !empty($input['dischargeserum_na'])) ? $input['dischargeserum_na'] : null;

            $input['UserModified']    = $this->auth->user()->id;
            $input['DateModified']    = Carbon::now($this->zone); 
                

          $postnatalDischarge = PostnatalDischarge::find($id);

          $postnatalDischarge->update($input);

          $this->makeAppointment($input, $id);
          
          if (isset($input['discharge_status']) && !empty($input['discharge_status']) && $input['discharge_status'] != 'Inpatient') {
                $check_bed_details = \DB::table('patient_bed_log')
                                    ->where('baby_id', $input['BabyId'])
                                    ->where('status', 'Occupied')
                                    ->orderBy('id', 'desc')
                                    ->first();
                if (count($check_bed_details) > 0) {
                    \DB::table('patient_bed_log')->where('id', $check_bed_details->id)->update(['status' => 'discharged', 'DateModified' => Carbon::now($this->zone), 'UserModified' => $this->auth->user()->id]);
                    \DB::table('bed')->where('id', $check_bed_details->bed_id)->update(['status' => null]);
                }
                 
          }

          $baby_admission = Admission::getBabyAdmission($input['AdmissionId'], $input['BabyId']);

        if (!empty($baby_admission)) {  
            if ($baby_admission->Status == 'Transferred') {
                $NicuId = Nicu::getNicuAdmission($input['AdmissionId'], $input['BabyId']);
                $Nicu_status = Nicu::find($NicuId->NicuId);
                $status['status'] = $input['discharge_status'];
                $status['DateModified']= Carbon::now();
                $status['UserModified']= $this->auth->user()->id;
                $Nicu_status->update($status);

                $baby_admission_status = Admission::find($baby_admission->AdmissionId);            
                $baby_admission->Status = $input['discharge_status'];    
                $baby_admission = (array)$baby_admission;
                $baby_admission_status->update($baby_admission);

            } elseif ($postnatalDischarge->discharge_status != 'Inpatient') {

                $baby_admission_status = Admission::find($baby_admission->AdmissionId);            
                $baby_admission->Status = $input['discharge_status'];    
                $baby_admission = (array)$baby_admission;
                $baby_admission_status->update($baby_admission);
            }
        } 

           
           if (count($postnatalDischarge) > 0) {

                $discharge_medications = Medications::where('BabyId', '=', $postnatalDischarge->BabyId)
                        ->where('AdmissionId', '=', $postnatalDischarge->AdmissionId)
                        ->where('flag', '=', 1)
                        ->delete();
                if (isset($input['M_Drugs'])) {

                    foreach ($input['M_Drugs'] as $key => $value) {

                        if ($input['M_Drugs'][$key] != 'N/A') {

                        $discharge_medications = array(

                                'Medication'    => $input['M_Drugs'][$key],
                                'Dose'          => $input['M_Dose'][$key],
                                'Frequency'     => $input['M_Frequency'][$key],
                                'Duration'      => $input['M_Duration'][$key],
                                'genericname'   => $input['m_generic_name'][$key],
                                'formulation'   => isset($input['formulation'][$key]) && !empty($input['formulation'][$key]) ? $input['formulation'][$key] : '',
                                'flag'          => 1,                               
                                'AdmissionId'   => $postnatalDischarge->AdmissionId,
                                'BabyId'        => $postnatalDischarge->BabyId,
                                'source_id'     => $id,
                                'additional_instruction'     => $input['additional_instruction'][$key],

                            );
                            Medications::create($discharge_medications);

                        }
                        
                    }
                    
                }    
            }

         $module          =  (\Session::has('admission_module')) ? \Session::get('admission_module') : 'POSTNATAL_DISCHARGE';

         $menu = $temp_acive_menu = isset($input['temp_acive_menu']) ? $input['temp_acive_menu'] : 'dischargeform';
         // \Session::put('discharge_menu', $temp_acive_menu);

        if ($input['discharge_status'] != 'Inpatient') {
             $postnatal_bed_log = \DB::table('patient_bed_log')
                                ->where('baby_id', $input['BabyId'])
                                ->where('status', 'Occupied')
                                ->orderBy('id', 'desc')
                                ->first();
        
            if (isset($postnatal_bed_log->id) && isset($postnatal_bed_log->bed_id)) {
                  
                \DB::table('patient_bed_log')
                    ->where('id', $postnatal_bed_log->id)
                    ->update(['status'=>'discharged', 'DateModified' => Carbon::now($this->zone), 'UserModified' => $this->auth->user()->id]);

                \DB::table('bed')
                    ->where('id', $postnatal_bed_log->bed_id)
                    ->update(['status'=>null]);
            }
        }                        

        if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'Postnatal daycare details created successfully !', 'edit_url' => action('Admission\PostnatalDischargeController@edit', \SiteHelpers::encrypt_id($id)), 'list_url' => action('Admission\PostnatalDischargeController@index')], 200);
        }

        if ($print_flag == 1) {

            if (\Session::has('registration_start')) {
              $this->flow->flowlog($module, $input['BabyId'], $input['MotherId'], $postnatalDischarge->AdmissionId, false, $menu);   
            }

            if ($input['next_module'] == 'transfertonicu') {
                return redirect(action('Admission\PostnatalDischargeController@edit', \SiteHelpers::encrypt_id($id)).'?module='.$input['next_module'].'&bed_id='.$input['bed_id'].'&temp_acive_menu='.$temp_acive_menu)->with('Success', 'Record updated successfully !'); 
            } else {
                return redirect(action('Admission\PostnatalDischargeController@edit', \SiteHelpers::encrypt_id($id)).'?temp_acive_menu='.$temp_acive_menu)->with('Success', 'Record updated successfully !'); 
            }
        
        } elseif ($print_flag == 2) {
           
            if (\Session::has('registration_start')) {
                 \Session::forget('discharge_menu');
                $this->flow->flowlog($module, $input['BabyId'], $input['MotherId'], $postnatalDischarge->AdmissionId, true, $menu);
              
            }
            return redirect(action('Admission\PostnatalDischargeController@index'))->with('Success', 'Record updated successfully !'); 

        }  elseif ($print_flag == 20) {
           
           $slug = $input['BabyId'].'-'.$postnatalDischarge->AdmissionId;
                 return redirect(action('Admission\NicuController@create',\SiteHelpers::encrypt_id($slug)).'?bed_id='.$input['bed_id']); 

        } else {
             return redirect(action('Admission\PostnatalDischargeController@index'))->with('Success', 'Record updated successfully !'); 
        }  


    }

    public function postanatalDischarge($baby_id)
    {

        if (empty($baby_id)) {
            throw new InvalidInputException(\SiteHelpers::getUserExceptionMessage('7003'), 7003);
        }
        $results = PostnatalDischarge::getPostanatalDischarge($baby_id);
        return    \Response::json(['status'=>true,'results'=> $results], 200);


    }

    /**
     * Store a newly created appointment.
     *
     */
    public function makeAppointment($input, $id = 0)
    {
        if ($input['appoinment_status'] && (!is_null($input['appoinment_date']) && !empty($input['appoinment_date'])) && $id != 0) {
            $appointment_details = new Request([
                'category'   => 'Review Appointment',
                'date'       => $input['appoinment_date'],
                'time'       => $input['appoinment_hrs'],
                'mins'       => $input['appoinment_min'],
                'session'    => $input['appoinment_session'],
                'patient'    => $input['BabyId'],
                'ref_id'     => $id,
                'from'       => 5
            ]);
            FlowController::patientDetailUpdate($appointment_details, 0);
        }
    }

}
