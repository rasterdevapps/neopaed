<?php

namespace App\Http\Controllers\Quality;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Baby;
use App\Models\Quality\DemographicDetails;
use App\Models\Quality\RespiratoryDetails;
use App\Models\Quality\SpesisDetails;
use App\Models\Quality\FeedingDetails;
use App\Models\Quality\OutcomeDetails;
use Illuminate\Contracts\Auth\Guard;
use App\User;
use App\Http\Controllers\Quality\QualityExportController;
use App\Models\Snomed\SnomedDescription;

class QualityController extends Controller
{

    /**
     *Class constructor 
     *
     */
    public function  __construct(Guard $auth, QualityExportController $export_excel)
    {
        $this->middleware('role:QUALITY_INDICATORS,write', ['only' => ['store', 'update', 'edit', 'create', 'destory']]);
        $this->middleware('role:QUALITY_INDICATORS,read', ['only' => ['index', 'show']]);
        $this->auth = $auth;

        $this->export_excel = $export_excel;


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

        $search_txt='';

        if (!empty($request->input('search_txt'))) {
            $search_txt = $request->input('search_txt');
        }

         //Initialize the record sorting key and order  
        $order['sortby']    = 'dob';
        $order['sortorder'] = 'desc';   

        //set the records sorting key and order  
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {

              $order['sortby']     = \SiteHelpers::decrypt_id($request->input('sortby'));
              $order['sortorder']  = $request->input('sortorder');

        }

        $result    = DemographicDetails::GetList($request->input('page'), $limit, $search_txt, $order, 1);
        $baby_list = $result['result'];

        $user_list =  User::all()->pluck('name','id')->toArray();

        $navigate['main_nav'] = 'quality_indicator';
        $navigate['sub_nav']  = 'quality_indicator';
        $quality_list = $this->export_excel->getSourceList();

        $getTotal = DemographicDetails::GetTotal();
        $total    = $result['total']; 

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

       return view('quality.list', compact('baby_list','user_list', 'quality_list','pagination','search_txt', 'navigate', 'getTotal', 'order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $navigate['main_nav'] = 'quality_indicator';
        $navigate['sub_nav']  = 'quality_indicator';
        $baby =  DemographicDetails::GetBabyList();
        $baby_list = \ValuelistHelpers::select2DataFormater($baby);
        
        $SubmitButtonText = "Start";
        return view('quality.select', compact('baby_list', 'SubmitButtonText', 'navigate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->all();
        
       

        \DB::beginTransaction();
         try {


                //demographics
                $baby_basic                           = $input;
                $baby_basic['dob']                    = (isset($input['dob']) && !empty($input['dob'])) ? date('Y-m-d',strtotime($input['dob'])) : null;
                $baby_basic['tob']                    = (isset($input['tob']) && !empty($input['tob'])) ? date('h:i:s A',strtotime($input['tob'])) : null; 
                $baby_basic['sepsis_in_mother_type']  = isset($input['sepsis_in_mother_type']) ? json_encode($input['sepsis_in_mother_type']) : null;
                //resuscitation
                $baby_basic['surfactant_type']         = isset($input['surfactant_type']) ? json_encode($input['surfactant_type']) : null;
                $baby_basic['indication_of_admission'] = isset($input['indication_of_admission']) ? json_encode($input['indication_of_admission']) : null;
                
                $baby_basic['gestation']               = json_encode(['g_weeks'=>$input['gestation_weeks'], 'g_days'=>$input['gestation_days']]); 
                $baby_basic['gestation_weeks']         =  $input['gestation_weeks'];
                $baby_basic['gestation_days']          =  $input['gestation_days'];
               
                $baby_basic['user_added']              = $this->auth->user()->id; 
                $baby_basic['date_added']              = date('Y-m-d h:i:s A', time()); 
                $baby_basic['user_modified']           = $this->auth->user()->id; 
                $baby_basic['date_modified']           = date('Y-m-d h:i:s A', time()); 
                $baby_basic['group_id']                = $this->auth->user()->RoleId; 
                $baby_basic['babyId']                  = $input['babyId'];

                $baby_id                              = DemographicDetails::create($baby_basic)->id;

                $res_detail                           = $input;
                $res_detail['primary_res_support']    = isset($input['primary_res_support']) ? $input['primary_res_support'] : null;
                $res_detail['group_id']               = $this->auth->user()->RoleId; 
                $res_detail['baby_id']                = $input['babyId'];
                RespiratoryDetails::create($res_detail);

                $spesis_details                           = $input;
                $spesis_details['spesis_type']            = isset($input['spesis_type']) ? json_encode($input['spesis_type']) : null;
                $spesis_details['group_id']               = $this->auth->user()->RoleId; 
                $spesis_details['baby_id']                = $input['babyId'];
                SpesisDetails::create($spesis_details);

                $feeding_details                           = $input;
                $feeding_details['central_line_type']      = isset($input['central_line_type']) ? json_encode($input['central_line_type']) : null;
                $feeding_details['group_id']               = $this->auth->user()->RoleId; 
                $feeding_details['baby_id']                = $input['babyId'];
                FeedingDetails::create($feeding_details);

                $outcome_details                           = $input;
                $outcome_details['case_death']             = isset($input['case_death']) ? json_encode($input['case_death']) : null;
                $outcome_details['group_id']               = $this->auth->user()->RoleId; 
                $outcome_details['baby_id']                = $input['babyId'];
                OutcomeDetails::create($outcome_details);

                \DB::commit();

         } catch(\Exception $e) {
                \DB::rollback();
            return back()->withInput()->with('error', $e->getMessage());
                
         }




        if ($input['save_flag'] == 0) {
            \Cache::forever('next_menu', $input['save_next']);

            return redirect(action('Quality\QualityController@edit', \SiteHelpers::encrypt_id($baby_id)))->with('Success', 'Record added successfully');
        }

        return redirect(action('Quality\QualityController@index'))->with('Success', 'Record added successfully');

      
       
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
      $baby_details = Baby::find($id);
      
      if (!isset($baby_details->BabyId)) {
        return redirect()->back()->with('error', 'Please check with baby registeration whether baby is exists!');
      }


      if (is_null($baby_details->BabyId)) {
        return redirect()->back()->with('error', 'Please check with baby registeration whether baby is exists!'); 
      }

        $navigate['main_nav'] = 'quality_indicator';
        $navigate['sub_nav']  = 'quality_indicator';    
      
      return view('quality.create', compact('baby_details', 'navigate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = \SiteHelpers::decrypt_id($id);

       $baby_basic      = DemographicDetails::GetBabyDetails($id);

       $baby_basic->dob = !is_null($baby_basic->dob) ? date('d-m-Y', strtotime($baby_basic->dob)) : null;
       $baby_basic->tob = !is_null($baby_basic->tob) ? date('h:i a', strtotime($baby_basic->tob)) : null;
       
       $gestation = (isset($baby_basic->gestation) && !is_null($baby_basic->gestation)) ? json_decode($baby_basic->gestation) : array();

       $baby_basic->gestation_weeks =  isset($gestation->g_weeks) ? $gestation->g_weeks: null; 
       $baby_basic->gestation_days  =  isset($gestation->g_days) ? $gestation->g_days   : null; 

       $menu = \Cache::get('next_menu');


       $menu = empty($menu) ? '#form-1' : $menu;

       $navigate['main_nav'] = 'quality_indicator';
       $navigate['sub_nav']  = 'quality_indicator';

       return view('quality.edit', compact('baby_basic','id', 'active', 'menu', 'navigate'));

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

        $input['dob']                     = (isset($input['dob']) && !empty($input['dob'])) ? date('Y-m-d',strtotime($input['dob'])) : null;
        $input['tob']                     = (isset($input['tob']) && !empty($input['tob'])) ? date('h:i:s A',strtotime($input['tob'])) : null; 
        $input['sepsis_in_mother_type']   = isset($input['sepsis_in_mother_type']) ? json_encode($input['sepsis_in_mother_type']) : null;
        $input['surfactant_type']         = isset($input['surfactant_type']) ? json_encode($input['surfactant_type']) : null;
        $input['indication_of_admission'] = isset($input['indication_of_admission']) ? json_encode($input['indication_of_admission']) : null;
        $input['gestation']               = json_encode(['g_weeks'=>$input['gestation_weeks'], 'g_days'=>$input['gestation_days']]); 
        $input['gestation_weeks']         = $input['gestation_weeks'];
        $input['gestation_days']          = $input['gestation_days'];

        $input['user_modified']          = $this->auth->user()->id; 
        $input['date_modified']          = date('Y-m-d h:i:s A', time()); 
        $input['group_id']               = $this->auth->user()->RoleId; 
        $baby_details                    = DemographicDetails::find($id);
        $baby_details->Update($input);
        $input['baby_id']               = $baby_details->babyId;   

        $input['primary_res_support']    = isset($input['primary_res_support']) ? $input['primary_res_support'] : null;
        $res_details                     = $baby_details->GetRespiratoryDetails;
        (count($baby_details->GetRespiratoryDetails) > 0) ? $res_details->Update($input) : RespiratoryDetails::create($input);

        
        $input['spesis_type']            = isset($input['spesis_type']) ? json_encode($input['spesis_type']) : null;
        $spesis_details                  = $baby_details->GetSpesisDetails;

        (count($baby_details->GetSpesisDetails) > 0) ? $spesis_details->Update($input) : SpesisDetails::create($input);
                    
        
        $input['central_line_type']      = isset($input['central_line_type']) ? json_encode($input['central_line_type']) : null;
        $feeding_details                 = $baby_details->GetFeedingDetails;
        (count($baby_details->GetFeedingDetails) > 0) ? $feeding_details->Update($input) : FeedingDetails::create($input);

        $input['case_death']             = isset($input['case_death']) ? json_encode($input['case_death']) : null;
        $outcome_details                 = $baby_details->GetOutcomeDetails;
        (count($baby_details->GetOutcomeDetails) > 0) ? $outcome_details->Update($input) : OutcomeDetails::create($input);


        if ($input['save_flag'] == 0) {
            \Cache::forever('next_menu', $input['save_next']);

            return redirect(action('Quality\QualityController@edit', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully!');
        }

        return redirect(action('Quality\QualityController@index'))->with('Success','Record updated successfully!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function exportbaby(Request $request)
     {
        $input        = $request->all();

        $export_list = $request->input('quality_export_list');
        $export_list = json_decode($export_list);
        krsort($export_list);
        $selectlist = $export_list;
        
        $quality_list = $this->export_excel->getSourceList();
        $baby_list    = DemographicDetails::GetBabySearch($selectlist)->toArray();
        $datalist = [];

        foreach ($baby_list as $baby_key => $baby_value) {

            $tmep_baby = collect($baby_value)->toArray();

            foreach ($tmep_baby as $key => $value) {

               $tmep_baby[$key]= $this->export_excel->formatValues($key, $value);
                
            }

            $datalist[]= $tmep_baby;
        
        }


        foreach ($selectlist as &$value) {

            $value = isset($quality_list[$value]) ? $quality_list[$value] : $value;
           
        }

        $this->export_excel->setFilename($input['file_name']); 
        $this->export_excel->setFileformat($input['file_format']);  

       return $this->export_excel->exportFile($datalist, $selectlist);

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

    /**
     * This method to get print sheet
     *
     * @param $baby_id is integer
     */
    public function print($baby_id)
    {
        $baby_id = \SiteHelpers::decrypt_id($baby_id);

        $baby_detail =  DemographicDetails::GetBabyDetailsPrint($baby_id);

        $closewinlink = action('Quality\QualityController@index');

        return view('quality.print', compact('baby_detail', 'closewinlink'));
    }

}

