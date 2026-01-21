<?php

namespace App\Http\Controllers\Nurse;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Requests\NicuNurseDaycareRequest;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Baby;
use App\Models\Antibiotic;
use App\Models\DaycareQuestions;
use App\Models\Fluid;
use App\Models\Admission;
use App\Models\Daycare;
use App\Models\Nurse\NicuNurseDaycare;
use App\Http\Controllers\Flow\FlowController;

class NicuNurseDaycareController extends Controller
{

    public function __construct(Guard $auth, FlowController $flow) 
    {
        $this->middleware('role:NICU_NURSE_DAY,write', ['only'=>['store','update','edit','create','destory']]);
        $this->middleware('role:NICU_NURSE_DAY,read', ['only'=>['index','show']]);
        $this->auth = $auth;
        $this->nicuNursedaycare = new NicuNurseDaycare();
        $this->flow = $flow;

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
        $order['sortby']    = 'baby.BMrNo';
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

        //setting the navigation bar 
        $navigate['main_nav'] = 'nicu_nurse_day';
        $navigate['sub_nav'] = '';

        //get the mother record list form mother module
        $result     = $this->nicuNursedaycare->getMainlist($request->input('page'), $limit, $search, $order, 1);

        $total      = $result[0];

        $results    = $result[1];

        $getTotal   = $this->nicuNursedaycare->GetTotal();  

        $page                   = !empty($request->input('page')) ? $request->input('page') : 1;
        $pagecount              = ceil($total/$limit);
        $pagination['total']    = $total;
        $pagination['start']    = (($page-2) < 1) ? 1 : ($page-2);
        $pagination['end']      = ($pagecount < ($page+3)) ? $pagecount :   ($page+3);
        $pagestart              = $total != 0 ? ($page <= 1) ? $page : ($page-1)*$limit + 1 : 0;
        $pagerecords            = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page*$limit;
        $pagination['limit']    = array($pagestart, $pagerecords);
        $pagination['limits']   = $limit;
        $pagination['previous'] = (($page-1) < 1) ? 1 : ($page-1);
        $pagination['next']     = ($pagecount < ($page+1)) ? $pagecount :   ($page+1);

        $this->flow->clearFlow();
        return view('nurse_nicu.daycare_mainlist', compact('results', 'navigate', 'pagination', 'search', 'order', 'getTotal'));
    }

    public function nicuDaycarebabySublist(Request $request, $id)
    {
        $navigate['main_nav']='nicu_nurse_day';
        $navigate['sub_nav'] ='';
        $BabyId    =  \SiteHelpers::decrypt_id($id);
        $results   =  $this->nicuNursedaycare->getSublist($BabyId);
        $baby_name =  isset($results[0]->BabyName) ? $results[0]->BabyName :'';

        return view('nurse_nicu.daycare_sublist', compact('results', 'baby_name', 'navigate'));

    }

    public function nicuDaycareadmissionList(Request $request, $id)
    {
        $id = \SiteHelpers::decrypt_id($id);
        $navigate['main_nav']='nicu_nurse_day';
        $navigate['sub_nav'] ='';

        if (strrpos($id, '-') > 0) {
            $get_data    = explode('-', $id);
            $BabyId      = $get_data[0];
            $AdmissionId = $get_data[1];
        } else {
            return redirect()->back()->with('error', 'Please try after sometime !');
        }
        $baby_details = Admission::getBabyMrn($AdmissionId);

        $results = $this->nicuNursedaycare->getAdmissiondayList($BabyId, $AdmissionId);
        // $baby_name = (isset($results[0]->BabyName)) ? $results[0]->BabyName : '' ;
        $BabyId  =$baby_details->BabyId;
        $baby_name  =$baby_details->BabyName;
        $admission = (isset($results[0]->episodes)) ? $results[0]->episodes : '' ;
        $BabyId =  isset($results[0]->BabyId) ? \SiteHelpers::encrypt_id($results[0]->BabyId) :'';

        return view('nurse_nicu.daycare_admissionlist', compact('results', 'baby_name', 'admission', 'BabyId', 'navigate', 'AdmissionId', 'baby_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $navigate['main_nav']='nicu_nurse_day';
        $navigate['sub_nav'] ='';
        $baby     =  Daycare::baby_list_daycare();
        $babies   =  array('0'=>'- - Select patient - -');
        foreach ($baby as $babyvalue)
        {
            $mr_no = (!empty($babyvalue->BMrNo)) ? ' - ' . $babyvalue->BMrNo : '';
            $babies[\SiteHelpers::encrypt_id($babyvalue->BabyId)] = $babyvalue->BabyName . $mr_no;
        }
        // foreach ($baby as $babyvalue) {
        //     $babies[\SiteHelpers::encrypt_id($babyvalue->BabyId)] = $babyvalue->BabyName; 
        // }

        $SubmitButtonText ='Start';
        
        return view('nurse_nicu.select_patient', compact('babies', 'SubmitButtonText', 'navigate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NicuNurseDaycareRequest $request)
    {
      $input = $request->all();

  
      $input['systolic_bp']  = (isset($input['systolic_bp'])) && (!empty($input['systolic_bp']))   ? $input['systolic_bp']  : null;
      $input['diastolic_bp'] = (isset($input['diastolic_bp'])) && (!empty($input['diastolic_bp'])) ? $input['diastolic_bp'] : null;
      $input['pvc_number']   = (isset($input['pvc_number'])) && (!empty($input['pvc_number'])) ? $input['pvc_number'] : null;

      $input['Immunoglobulins'] = trim($input['Immunoglobulins']);
      $input['OtherDrugs']   = (isset($input['drugs']))?serialize($input['drugs']):serialize(array());
      $input['DayDate']      = date('Y-m-d', strtotime($input['DayDate']));
      $input['DateModified'] = Carbon::now();
      $input['DateAdded']    = Carbon::now();
      $input['UserAdded']    = $this->auth->user()->id;
      $input['UserModified'] = $this->auth->user()->id;
      $day_name              = Daycare::where(['BabyId'=>$input['BabyId'],'AdmissionId'=>$input['AdmissionId'],'IsDeleted'=>0 ])->count();
      $input['day_name']     = 'Day '.($day_name+1); 
      $input['EtTube']       = (isset($input['EtTube']) && $input['EtTube']=='on') ? 'Yes' : 'No';
      $input['Stools']       = (isset($input['Stools']) && $input['Stools']=='on') ? 'Bowels opened' : 'Bowels not opened';
      
      $input['Surfactant_therapy_nicu']  = (isset($input['Surfactant_therapy_nicu']) && $input['Surfactant_therapy_nicu'] =='on') ? 'Yes' : 'No' ;

      $input['cg_weeks']     = (isset($input['cg_weeks'])) && (!empty($input['cg_weeks'])) ?$input['cg_weeks']:null;
      $input['cg_days']      = (isset($input['cg_days']))  && (!empty($input['cg_days'])) ?$input['cg_days']:null;  
      $input['CGA']          = json_encode(array('cg_weeks'=>$input['cg_weeks'], 'cg_days'=>$input['cg_days']));
      $daycare               = Daycare::create($input);
      $result                = Daycare::get_record($daycare->DayId);
      $input['DayId']        = $daycare->DayId; 

      $daycarequestions['workingWeight']             = $input['workingWeight'];
      $daycarequestions['iv_fluids']                 = $input['iv_fluids'];
      $daycarequestions['drug_infusions']            = $input['drug_infusions'];
      $daycarequestions['other_drugs']               = $input['other_drugs'];
      $daycarequestions['urine_output_day']          = $input['urine_output_day'];
      $daycarequestions['iv_fluids_ml_day']          = $input['iv_fluids_ml_day'];
      $daycarequestions['drug_infusions_ml_day']     = $input['drug_infusions_ml_day'];
      $daycarequestions['UserModified']              = $this->auth->user()->id;
      $daycarequestions['DateModified']              = Carbon::now();
      $daycarequestions['lumbar_puncture']           = $input['lumbar_puncture'];
      $daycarequestions['neuro_sonogram']            = isset($input['neuro_sonogram']) ? 'performed' : 'Not performed';
     
      $daycare_question =  DaycareQuestions::where('DayId', $daycare->DayId)->first();

         if (count($daycare_question) > 0) {
           $daycare_question->update($daycarequestions);    

         } else {

            $daycarequestions['DayId']       = $daycare->DayId;
            $daycarequestions['AdmissionId'] = $input['AdmissionId'];
            $daycarequestions['BabyId']      = $input['BabyId'];
            $daycarequestions['UserAdded']   = $this->auth->user()->id;
            $daycarequestions['DateAdded']   = Carbon::now();

             DaycareQuestions::create($daycarequestions);
         }

      if (isset($input['A_Antibiotic'])) {
            $length = count($input['A_Antibiotic']);
            for ($i = 0; $i < $length; $i++) {
                $pbms = array(
                    'Antibiotic' => $input['A_Antibiotic'][$i],
                    'Day' => $input['A_Day'][$i],
                    'DayId' => $daycare->DayId,
                    'BabyId' => $input['BabyId'],
                    'AdmissionId' => $input['AdmissionId']
                );
                Antibiotic::create($pbms);
            }
        }

         if (isset($input['F_Product'])) {

            for ($i = 0; $i < count($input['F_Product']); $i++) {
                if (!empty($input['F_Product'][$i])) {

                        $product = array(
                            'Product'     => $input['F_Product'][$i],
                            'Volume'      => $input['F_Volume'][$i],
                            'DayId'       => $daycare->DayId,
                            'BabyId'      => $input['BabyId'],
                            'AdmissionId' => $input['AdmissionId']
                        );
                        Fluid::create($product);

                }  
            }
        }    

      $results = $result[0];

      if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'NICU nurse daycare created successfully !', 'edit_url' => action('Nurse\NicuNurseDaycareController@edit', \SiteHelpers::encrypt_id($daycare->DayId)), 'list_url' => action('Nurse\NicuNurseDaycareController@index')], 200);
        }

      if ($input['print_flag'] == 2) {
         return redirect(action('Nurse\NicuNurseDaycareController@edit', \SiteHelpers::encrypt_id($daycare->DayId)))->with('Success', 'Record saved successfully ');
      } elseif ($input['print_flag'] == 1) {
         return redirect(action('Nurse\NicuNurseDaycareController@index'))->with('Success', 'Record saved successfully ');
      }
     
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = \SiteHelpers::decrypt_id($id);
        if (strrpos($id, '-') > 0) {
            $get_data= explode('-', $id);
            $AdmissionId = $get_data[0];
            $babi_id     = $get_data[1];
            if (!is_numeric($babi_id)) {
                $babi_id     = \SiteHelpers::decrypt_id($get_data[1]);
            }
        } else {
            return redirect()->back();
        }
        $baby = Baby::find($babi_id);
        $times = \SiteHelpers::prepare_time();

        $previous_daycare = Daycare::get_pervious_daycare($babi_id, $AdmissionId);

     if (count($previous_daycare) > 0) {



        $baby->CurrentProblems  = (isset($previous_daycare->CurrentProblems)) ? $previous_daycare->CurrentProblems : '';

        $baby->PreviousProblems = (isset($previous_daycare->PreviousProblems)) ? $previous_daycare->PreviousProblems : '';

        $baby->workingWeight    = (isset($previous_daycare->workingWeight) && !empty($previous_daycare->workingWeight)) ? $previous_daycare->workingWeight : $baby->BirthWeight;

        $baby->Sepsis           =  isset($previous_daycare->Sepsis) ? $previous_daycare->Sepsis : '' ;

        $antibiotic_temp = Daycare::get_daycare_antibiotic($previous_daycare->DayId);

        $drugs = (count(@unserialize($previous_daycare->OtherDrugs)) > 0) ? unserialize($previous_daycare->OtherDrugs) : array();

        foreach ($antibiotic_temp as $value) {
          $antibiotic[] = (array) $value ; 
        }

       }  

         if (!empty($baby->DOB)) {
           $baby->DayOfLife = \SiteHelpers::calculate_day_of_life($baby->DOB);
         }  
         if (!empty($baby->Gestation)) {
            $baby->Gestation = \SiteHelpers::convert_gestation_days($baby->Gestation);
         }

         if (isset($baby->DayOfLife) && !empty($baby->DayOfLife)) {
             $baby->CGA = \SiteHelpers::calculate_corrected_gestation($baby->Gestation, $baby->DayOfLife);
               $baby->cg_weeks =(int) $baby->CGA[0];
               $baby->cg_days  =(int) $baby->CGA[1];
         }

         $baby->DOB = date('d-m-Y', strtotime($baby->DOB));

         $baby->DayDate =date('d-m-Y');
         $time = explode(':', date('h:i:A', strtotime(Carbon::now("Asia/Calcutta"))));
         $baby->DayTime      = (int)$time[0];
         $baby->DayTime_MINS = $time[1];
         $baby->DayTime_AM   = $time[2];
      
         $baby->AdmissionId  = $AdmissionId;
        
        $SubmitButtonText="Save & Close";
        $navigate['main_nav']='nicu_nurse_day';
        $navigate['sub_nav'] ='';

        return view('nurse_nicu.create', compact('baby', 'antibiotic', 'SubmitButtonText', 'times', 'navigate', 'drugs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dayid = \SiteHelpers::decrypt_id($id); 

        $result            = Daycare::get_record($dayid); 

        $baby              = $result[0];

        $baby_details      = Baby::find($baby->BabyId);

        $baby->BabyName    = $baby_details->BabyName;

        $baby->DOB         = (isset($baby_details->DOB) && !empty($baby_details->DOB)) ? date('d-m-Y', strtotime($baby_details->DOB)) : null ;

        $daycare_question  = DaycareQuestions::where('DayId', $dayid)->first();
        
        $daycare_questions = DaycareQuestions::get_record($dayid);

        $daycare_questions = (array)$daycare_questions;
         if (count($daycare_questions) > 0) {
            unset($daycare_questions['BabyId']);
            unset($daycare_questions['DayId']) ;
         } 

        $baby = (object)array_merge((array)$baby, $daycare_questions);

        $time  = \SiteHelpers::prepare_time();

        $SubmitButtonText = 'Update & close';

        $products = \SiteHelpers::convert_obj_to_array(Fluid::GetRecordList($baby->BabyId, $dayid)); 

        $dayid =\SiteHelpers::encrypt_id($dayid);
        $navigate['main_nav']='nicu_nurse_day';
        $navigate['sub_nav'] ='';

        $baby->DayDate = date('d-m-Y', strtotime($baby->DayDate));  
        $temp    = json_decode($baby->CGA);
        $temp = is_array($temp) ? $temp : (array)$temp;
        $baby->cg_weeks =  $temp['cg_weeks'];  
        $baby->cg_days  =  $temp['cg_days'];
        unset($temp);

        $drugs = (isset($baby->OtherDrugs) && count(@unserialize($baby->OtherDrugs)) > 0) ? unserialize($baby->OtherDrugs) : array();

        return view('nurse_nicu.edit', compact('baby', 'time', 'products', 'SubmitButtonText', 'dayid', 'drugs', 'navigate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NicuNurseDaycareRequest $request, $id)
    {
        $input = $request->all();

        $print_flag = $input['print_flag'];

        unset($input['print_flag']);

        $input['systolic_bp']  = (isset($input['systolic_bp'])) && (!empty($input['systolic_bp']))   ? $input['systolic_bp']  : null;
        $input['diastolic_bp'] = (isset($input['diastolic_bp'])) && (!empty($input['diastolic_bp'])) ? $input['diastolic_bp'] : null;
        $input['pvc_number']   = (isset($input['pvc_number'])) && (!empty($input['pvc_number'])) ? $input['pvc_number'] : null;

        $input['Surfactant_therapy_nicu']  = (isset($input['Surfactant_therapy_nicu']) && $input['Surfactant_therapy_nicu'] =='on') ? 'Yes' : 'No' ;
        
        $dayid = \SiteHelpers::decrypt_id($id);

        $input['Immunoglobulins'] = trim($input['Immunoglobulins']);
        $input['EtTube']   = (isset($input['EtTube']) && $input['EtTube']=='on') ? 'Yes' : 'No';
        $input['Stools']   = (isset($input['Stools']) && $input['Stools']=='on') ? 'Bowels opened' : 'Bowels not opened'; 
        $input['cg_weeks'] = (isset($input['cg_weeks'])) && (!empty($input['cg_weeks'])) ? $input['cg_weeks']:null;
        $input['cg_days']  = (isset($input['cg_days']))  && (!empty($input['cg_days'])) ? $input['cg_days']:null;  
        $input['CGA']      = json_encode(array('cg_weeks'=>$input['cg_weeks'],'cg_days'=> $input['cg_days']));
        $input['DayDate']  = date('Y-m-d', strtotime($input['DayDate'])); 
        $input['DateModified'] = Carbon::now();
        $input['UserModified'] = $this->auth->user()->id;
        $daycare = Daycare::find($dayid);
        $daycare->update($input);



        $day_questions['workingWeight']             = $input['workingWeight'];
        $day_questions['iv_fluids']                 = $input['iv_fluids'];
        $day_questions['drug_infusions']            = $input['drug_infusions'];
        $day_questions['other_drugs']               = $input['other_drugs'];
        $day_questions['urine_output_day']          = $input['urine_output_day'];
        $day_questions['iv_fluids_ml_day']          = $input['iv_fluids_ml_day'];
        $day_questions['drug_infusions_ml_day']     = $input['drug_infusions_ml_day'];
        $day_questions['UserModified']              = $this->auth->user()->id;
        $day_questions['DateModified']              = Carbon::now();
        $day_questions['lumbar_puncture']           = $input['lumbar_puncture'];
        $day_questions['neuro_sonogram']        = isset($input['neuro_sonogram']) ? 'performed' : 'Not performed';

        $daycare_question =  DaycareQuestions::where('DayId', $dayid)->first();

         if (count($daycare_question) > 0) {

           $daycare_question->update($day_questions);    

         } else {
            $daycarequestions['DayId']       = $dayid;
            $daycarequestions['AdmissionId'] = $daycare->AdmissionId;
            $daycarequestions['BabyId']      = $input['BabyId'];
            $daycarequestions['UserAdded']   = $this->auth->user()->id;
            $daycarequestions['DateAdded']   = Carbon::now();

             DaycareQuestions::create($daycarequestions);
         }

        Fluid::where('BabyId', '=', $input['BabyId'])->where('DayId', '=', $dayid)->delete();

        if (isset($input['F_Product'])) {

            foreach ($input['F_Product'] as $key => $value) {

                if (!empty($input['F_Product'][$key])) {

                        $product = array(
                            'Product'     => $input['F_Product'][$key],
                            'Volume'      => $input['F_Volume'][$key],
                            'DayId'       => $dayid,
                            'BabyId'      => $input['BabyId'],
                            'AdmissionId' => $daycare->AdmissionId

                        );
                         Fluid::create($product);
                }  

               

            }
        }

         if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'NICU nurse daycare created successfully !', 'edit_url' => action('Nurse\NicuNurseDaycareController@edit', \SiteHelpers::encrypt_id($dayid)), 'list_url' => action('Nurse\NicuNurseDaycareController@nicuDaycareadmissionList', \SiteHelpers::encrypt_id($daycare->BabyId.'-'.$daycare->AdmissionId))], 200);
        }

        if ($print_flag == 2) {
            return redirect(action('Nurse\NicuNurseDaycareController@edit', \SiteHelpers::encrypt_id($dayid)))->with('Success', 'Record updated successfully ');
        } else {
            return redirect(action('Nurse\NicuNurseDaycareController@nicuDaycareadmissionList', \SiteHelpers::encrypt_id($daycare->BabyId.'-'.$daycare->AdmissionId)))->with('Success', 'Record updated successfully ');
        }   



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
    public function getAdmissionid($id)
    {

        $id = \SiteHelpers::decrypt_id($id);

        $baby = Baby::daycare_eposide_list($id);


        // $babies = array('0'=>'Select Admission');
        foreach ($baby as $babyvalue) {
           $babies[\SiteHelpers::encrypt_id($babyvalue->AdmissionId.'-'.$babyvalue->BabyId)] = $babyvalue->episodes;
        }
        return \Response::json(['data'=>$babies]);

    }

}
