<?php
namespace App\Http\Controllers\ProblemBaseDaycare;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Response;
use Carbon\Carbon;
use App\Exceptions\InvalidInputException;
use App\Models\Masters\DaycareProblemsPublished;
use App\Http\Controllers\ProblemBaseDaycare\ProblemFormatController;
use App\Http\Controllers\Controller;
use App\Models\Baby;
use App\Models\ProblemPostnatalEpisode;
use App\Models\ProblemPostnatalList;
// use App\Models\Masters\Drug;
use App\Models\Masters\DrugIvFluidMaster;
use App\Models\Masters\AntibioticMaster;
use App\Models\Settings\DeleteApproval;
use App\Http\Controllers\Flow\FlowController;

/**
 * methods to map the input values with problem master settings
 *
 * @author Manikandan M  
 */
class ProblemPostnatalController extends Controller
{
    /**
     * Initialize Guard instance
     * @var $auth type object
     */
     public $auth;

    /**
     * Initialize time zone
     *@var $time_zone type string
     */
     public $time_zone;

    /**
     * Initialize the navigation content
     * @var  $navigate type array 
     */
    public $navigate;

    /**
     * This Comman module property 
     * @var $module type array 
     */
    public $module;

    /**
    * constructor method.
    *
    * @param $auth object of Guard 
    *
    * @param $problemdaycarepublished instance of App\Models\Masters\DaycareProblemsPublished
    *
    * @return initialize require models object and check the permission for module 
    */
    public function __construct(Guard $auth, DaycareProblemsPublished $problemdaycarepublished, FlowController $flow)
    {
        $this->middleware('role:POST_PROBLEM_SYSTEM,write', ['only' => ['store', 'update', 'edit', 'create', 'show', 'destroy']]);
        $this->middleware('role:POST_PROBLEM_SYSTEM,read', ['only' => ['index', 'printData']]);
        $this->auth           = $auth;
        $this->time_zone      = env('TIME_ZONE');
        
        $this->navigate['main_nav']        = 'postnatal';
        $this->navigate['sub_nav']         = 'post_problem_system';
        $this->module['module_name']       = 'Postnatal Problem Base Systems';
        $this->module['module_controller'] = 'ProblemBaseDaycare\ProblemPostnatalController';
        $this->flow           = $flow;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ProblemPostnatalList $postnatalList)
    {

        $limit = 50;
        if (!empty($request->input('limit'))) {
            $request->session()->put('limit', $request->input('limit'));
            $limit = $request->session()->get('limit');
        }

        elseif ($request->session()->has('limit')) {
            $limit = $request->session()->get('limit');
        }

        $order['sortby']    = 'baby.BabyId';
        $order['sortorder'] = 'desc';

        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {
            $order['sortby']     = \SiteHelpers::decrypt_id($request->input('sortby'));
            $order['sortorder']  = $request->input('sortorder');
        }

        $search = array();
        $search['search_txt']='';
        if (!empty($request->input('search_txt'))) {
            $search['search_txt'] = $request->input('search_txt');
        }

        $navigate['main_nav']     = $this->navigate['main_nav'];
        $navigate['sub_nav']      = $this->navigate['sub_nav'];
        $navigate['module_name']  = $this->module['module_name'];

        $status = !empty($request->input('status')) ? $request->input('status') : 'inpatient';

        $page = !empty($request->input('page')) ? $request->input('page') : 1;
        $page = preg_replace( '/[^0-9]/', '', $page);

        $result    = $postnatalList->GetList($page, $limit, $search, $order, 1, $status);
        $results   = $result['result'];

        $getTotal  = $postnatalList->GetTotal();
        $total     = $result['total'];

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

        $this->flow->clearFlow(); 

      return view('postnatal_problem.list', compact('results', 'pagination', 'order', 'search', 'navigate', 'getTotal'));
    }

   /**
    * Display the admission list based on baby id 
    *
    * @param $request instance of Illuminate\Http\Request
    *
    * @param $baby_id integer 
    *
    * @param $postnatalList instance of App\Models\ProblemPostnatalList
    * 
    * @return \Illuminate\Http\Response
    *
    */
    public function admissionlist(Request $request, $baby_id, ProblemPostnatalList $postnatalList) 
    {
        $baby_id = \SiteHelpers::decrypt_id($baby_id);

        $navigate['main_nav'] = $this->navigate['main_nav'];
        $navigate['sub_nav']  = $this->navigate['sub_nav'];
        $navigate['module_name']  = $this->module['module_name'];

        $admissionList =  $postnatalList->GetAdmissionList($baby_id);

        $babyName = '';

        if (isset($admissionList[0])) {
              $babyName      = $admissionList[0]->BabyName.' - '.$admissionList[0]->BMrNo;  
        }
        return view('postnatal_problem.admissionlist', compact('admissionList', 'babyName', 'navigate'));    
    }

    /**
    * Display the episodes list based on baby id  and admission 
    *
    * @param $request instance of Illuminate\Http\Request
    *
    * @param $id encrypted integer
    *
    * @param $daycareList instance of App\Models\ProblemDaycareList
    * 
    * @return \Illuminate\Http\Response
    *
    */
    public function episodeslist(Request $request, $id, ProblemPostnatalList $postnatalList)
    {

        $navigate['main_nav'] = $this->navigate['main_nav'];
        $navigate['sub_nav']  = $this->navigate['sub_nav'];
        $navigate['module_name']  = $this->module['module_name'];

        $input = $request->all();

        $id = \SiteHelpers::decrypt_id($id);

        if (count(explode('-', $id)) == 2) {

           $id           = explode('-', $id);
           $baby_id      = isset($id[0]) ? $id[0] : 0 ;
           $admissionid  = isset($id[1]) ? $id[1] : 0 ; 

        } else {

           throw new InvalidInputException(\SiteHelpers::getUserExceptionMessage(7010), 7010);
            
        }

        $babyDetails =  Baby::find($baby_id);
        $episodelist =  $postnatalList->GetEpisodesList($baby_id, $admissionid);
        $babyName    = '';

        if (count($babyDetails) > 0) {
         $babyName    =  $babyDetails->BabyName.' - '.$babyDetails->BMrNo ;  
        }
       
        $babyadmission = \SiteHelpers::encrypt_id($baby_id.'-'.$admissionid);

        return view('postnatal_problem.episodelist', compact('episodelist', 'babyName', 'admissionid', 'baby_id', 'babyadmission', 'navigate'));    

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id, Request $request, ProblemPostnatalList $postnatalList)
    {
    
        $problemLists['0'] = 'N/A';  
        $SubmitButtonText = 'Add';


        $id = \SiteHelpers::decrypt_id($id);

        if (count(explode('-', $id)) == 2) {

           $id           = explode('-', $id);
           $baby_id      = isset($id[0]) ? $id[0] : 0 ;
           $admissionid  = isset($id[1]) ? $id[1] : 0 ; 

        } else {

           throw new InvalidInputException(\SiteHelpers::getUserExceptionMessage(7011), 7011);
            
        }

        $problemList = $postnatalList->GetProblemList($baby_id, $admissionid);

        foreach ($problemList as $problem) {

            $problemLists[\SiteHelpers::encrypt_id($problem->problem_id)] = $problem->problem_name;
        }

        $id = \SiteHelpers::encrypt_id(implode('-', $id));

        $response = view('postnatal_problem.create_new', compact('problemLists', 'SubmitButtonText', 'id'))->render(); 

        return \Response::json(['list'=>$response, 'message'=>'success'], 200); 
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DaycareProblemsPublished $problemdaycarepublished, ProblemFormatController $problemFormat, ProblemPostnatalList $postnatalList)
    {
        $input = $request->all();

        if (isset($input['problem_id_encrypt'])) {

            $input['problem_id'] = \SiteHelpers::decrypt_id($input['problem_id_encrypt']);

            $problemValues['baby_id']      = $input['baby_id'];
            $problemValues['admission_id'] = $input['admission_id'];
            $problemValues['mother_id']    = $input['mother_id'];
            $problemValues['problem_id']   = $input['problem_id'];
            $problemValues['pp_id']        = $input['published_id'];
            
             
              $problem_id = $postnatalList->GetProblemGroup($problemValues['baby_id'], $problemValues['admission_id'], $problemValues['problem_id']);
              
              if (count($problem_id) > 0) {

                $pb_postnatal_id = $problem_id->pb_postnatal_id;

              } else {
                $pb_postnatal_id = ProblemPostnatalList::create($problemValues)->pb_postnatal_id;
              }

             $problems     =   $problemFormat->ProblemFormate($problemValues['problem_id'], $input);
           
             foreach ($problems as $key => $problemjvalue) {

               $problemValues['pb_postnatal_id']     = $pb_postnatal_id;
               $problemValues['pp_id']               = $input['published_id'][$key];
               $problemValues['episode_name']        = 'Episode '.($key+1);
               $problemValues['problems_parameters'] = json_encode($problemjvalue);
               $problemValues['start_date']          = (is_null($input['start_date'][$key]) || empty($input['start_date'][$key]))? null : date('Y-m-d', strtotime($input['start_date'][$key]));
               $problemValues['end_date']            = (is_null($input['end_date'][$key]) || empty($input['end_date'][$key])) ? null : date('Y-m-d', strtotime($input['end_date'][$key]));
                $problemValues['UserAdded']    = $this->auth->user()->id;
                $problemValues['DateAdded']    = Carbon::now($this->time_zone); 
                
                ProblemPostnatalEpisode::create($problemValues);
             }

          

        } else {

            throw new \InvalidInputException(\SiteHelpers::getUserExceptionMessage(7012), 7012);
            
        }

        if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'Postnatal daycare details created successfully !', 'edit_url' => action('ProblemBaseDaycare\ProblemPostnatalController@edit', \SiteHelpers::encrypt_id($pb_postnatal_id))], 200);
        }

        return redirect(action('ProblemBaseDaycare\ProblemPostnatalController@edit', \SiteHelpers::encrypt_id($pb_postnatal_id)))->with('Success', 'Record saved successfully');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id, DaycareProblemsPublished $problemdaycarepublished, ProblemPostnatalList $postnatalList)
    {
        $input = $request->all();

        $id = \SiteHelpers::decrypt_id($id);

        $navigate['main_nav'] = $this->navigate['main_nav'];
        $navigate['sub_nav']  = $this->navigate['sub_nav'];
        $navigate['module_name']  = $this->module['module_name'];

        $problem_id = \SiteHelpers::decrypt_id($input['problem_id']);
        if (count(explode('-', $id)) == 2) {
           $id          = explode('-', $id);
           $baby_id     = isset($id[0]) ? $id[0] : 0 ;
           $admissionid = isset($id[1]) ? $id[1] : 0 ; 
        } else {
            return redirect()->back()->with('error', 'Baby or Admission may not be selected !');
        }

    
        $check = $postnatalList->CheckAdmission($baby_id, $admissionid, $problem_id);


         if (count($check) > 0) {
            \Session::put('create-episode', 1);
            return redirect(action('ProblemBaseDaycare\ProblemPostnatalController@edit', \SiteHelpers::encrypt_id($check->pb_day_id)));

         }
       
        $baby            = Baby::where(['BabyId'=>$baby_id,'IsDeleted'=>'0'])->first();
        $problem_list    = $problemdaycarepublished->GetProblemList();
        
        if (count($baby) > 0) {

            $baby->Gestation = (array)json_decode($baby->Gestation); 
            $baby->g_weeks   = isset($baby->Gestation['g_weeks']) ? $baby->Gestation['g_weeks'] : '';
            $baby->g_days    = isset($baby->Gestation['g_days']) ? $baby->Gestation['g_days'] : '';
            $baby->DOB       = (date('Y', strtotime($baby->DOB)) > 1970) ? date('d-m-Y', strtotime($baby->DOB)) : '';
        }
         
        

        $uniqueId ='problem-'.$problem_id.'-1';

        $problems =  $problemdaycarepublished->GetRecord($problem_id);


        $single_column_param = $left_column_param = $right_column_param = $param_values = array();
        $episode_id = 0 ;

        if (count($problems) > 0) {

            $problem_parameter = collect(json_decode($problems->problem_fields));
            $problem_layout    = $problems->problem_layout;
            $problem_title     = $problems->problem_name.' Episode Lists';
            
            if ($problem_layout == 1) {

               $single_column_param = $problem_parameter->where('para_position', 'single-column-problem');
           
            } elseif ($problem_layout == 2) {

                $left_column_param = $problem_parameter->where('para_position', 'problem-fields-left');
                $right_column_param = $problem_parameter->where('para_position', 'problem-fields-right');

            }
            $published_id = $problems->published_id;
         } else {

              throw new InvalidInputException(\SiteHelpers::getUserExceptionMessage(7013), 7013);
         } 
         $id = \SiteHelpers::encrypt_id(implode('-', $id));

         
        $drugs      = \ValuelistHelpers::getDrugIvFluidsNonAntibiotic();
        $antibiotic  = \ValuelistHelpers::getDrugIvFluidsAntibiotic();


        return view('postnatal_problem.create', compact('problem_list', 'baby', 'drugs', 'antibiotic', 'published_id', 'admissionid', 'baby_id', 'left_column_param', 'problem_layout', 'right_column_param', 'uniqueId', 'single_column_param', 'problem_id', 'param_values', 'episode_id', 'problem_title', 'id', 'problem_parameter', 'navigate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, ProblemPostnatalList $postnatalList, DaycareProblemsPublished $problemdaycarepublished, Response $response)
    {
        $id = \SiteHelpers::decrypt_id($id);

        if ($id == 0) {
           throw new InvalidInputException(\SiteHelpers::getUserExceptionMessage(7014), 7014);
        }

        $daylist         =  $postnatalList->find($id);
        $episodes        =  $daylist->GetEpisodes;
        $baby            =  $daylist->GetBabyDetails;

        $episodes        =  collect($episodes)->sortBy('episode_id');

        $navigate['main_nav'] = $this->navigate['main_nav'];
        $navigate['sub_nav']  = $this->navigate['sub_nav'];
        $navigate['module_name']  = $this->module['module_name'];
        if (count($baby) > 0) {
        $baby->DOB       = (date('Y', strtotime($baby->DOB)) > 1970) ? date('d-m-Y', strtotime($baby->DOB)) : '';
        }
        $problems        =  $problemdaycarepublished->GetRecord($daylist->problem_id);
        $problem_title   =  $problems->problem_name.' Episode Lists';
        $ids             = \SiteHelpers::encrypt_id($daylist->baby_id.'-'.$daylist->admission_id);
        $daycare_id      = \SiteHelpers::encrypt_id($id);   
       
        $drugs      = \ValuelistHelpers::getDrugIvFluidsNonAntibiotic();
        $antibiotic  = \ValuelistHelpers::getDrugIvFluidsAntibiotic();

        return view('postnatal_problem.edit', compact('daylist', 'episodes', 'baby', 'daycare_id', 'problem_title', 'ids', 'problems', 'drugs', 'antibiotic', 'navigate'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, ProblemPostnatalList $postnatalList, ProblemPostnatalEpisode $problemEpisode, ProblemFormatController $problemFormat)
    {
        $daycare_id  = \SiteHelpers::decrypt_id($id);
        $input       =  $request->all();

        $removeList  = isset($input['remove_ids']) ? $input['remove_ids'] : array(); 

        if (isset($input['problem_id'])) {
             
            $problemValues['baby_id']      = $input['baby_id'];
            $problemValues['admission_id'] = $input['admission_id'];
            $problemValues['mother_id']    = $input['mother_id'];
            $problemValues['problem_id']   = $input['problem_id']; 
            $episode_no                    = 0; 
            $dayRecord                     = $postnatalList->find($daycare_id);
            $dayRecord->Update($input);
            $problems                      =   $problemFormat->ProblemFormate($problemValues['problem_id'], $input);
            foreach ($problems as $key => $problemjvalue) {

                $problemValues['pb_postnatal_id']     = $daycare_id;
                $problemValues['problems_parameters'] = json_encode($problemjvalue);
                $problemValues['pp_id']               = $input['published_id'][$key]; 
                $problemValues['start_date']          = (is_null($input['start_date'][$key]) || empty($input['start_date'][$key]))? null : date('Y-m-d', strtotime($input['start_date'][$key]));
                $problemValues['end_date']            = (is_null($input['end_date'][$key]) || empty($input['end_date'][$key])) ? null : date('Y-m-d', strtotime($input['end_date'][$key]));

                $episode =  $problemEpisode->find($input['episode_ids'][$episode_no]);

                if (count($episode) > 0) {
                    $problemValues['UserModified'] = $this->auth->user()->id;
                    $problemValues['DateModified'] = Carbon::now($this->time_zone); 
                    $episode->update($problemValues);

                } else {

                    $problemValues['episode_name'] = 'Episode '.($key+1);
                    $problemValues['UserAdded']    = $this->auth->user()->id;
                    $problemValues['DateAdded']    = Carbon::now($this->time_zone); 

                    ProblemPostnatalEpisode::create($problemValues);
                }

                $episode_no++;
            }

        } else {

            throw new InvalidInputException(\SiteHelpers::getUserExceptionMessage(7015), 7015);
            
        }

        if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'Postnatal daycare details created successfully !'], 200);
        }

        return redirect(action('ProblemBaseDaycare\ProblemPostnatalController@edit', \SiteHelpers::encrypt_id($daycare_id)))->with('Success', 'Record updated successfully');

    }

    /**
     * get the admission list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  encrypted int  $id
     * @return \Illuminate\Http\Response
     */
    public function getadmission($id, ProblemPostnatalList $postnatalList)
    {

       $id = \SiteHelpers::decrypt_id($id);

       $baby = $postnatalList->GetAdmissionDetails($id);

       $babies =array();

        foreach ($baby as $babyvalue) {
           $babies[\SiteHelpers::encrypt_id($babyvalue->AdmissionId.'-'.$babyvalue->BabyId)] = $babyvalue->episodes;
        }

            return \Response::json(['message'=>$babies]); 


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  encrypted int  $problem_id
     * @param  
     * @return \Illuminate\Http\Response
     */

    public function getProblemfields(Request $request, $problem_id, DaycareProblemsPublished $problemdaycarepublished) 
    {
        $input = $request->all();

        $problem_id = \SiteHelpers::decrypt_id($problem_id);

        $uniqueId ='problem-'.$problem_id.'-'.$input['episodeCount'];

        $problems =  $problemdaycarepublished->GetRecord($problem_id);

        $single_column_param = $left_column_param = $right_column_param = $param_values = array();
        $episode_id = 0 ;
        $drugs      = \ValuelistHelpers::getDrugIvFluidsNonAntibiotic();
        $antibiotic  = \ValuelistHelpers::getDrugIvFluidsAntibiotic();


        if (count($problems) > 0) {

            $problem_parameter = collect(json_decode($problems->problem_fields));
            $problem_layout    = $problems->problem_layout;
            
            if ($problem_layout == 1) {

               $single_column_param = $problem_parameter->where('para_position', 'single-column-problem');
           
            } elseif ($problem_layout == 2) {

                $left_column_param = $problem_parameter->where('para_position', 'problem-fields-left');
                $right_column_param = $problem_parameter->where('para_position', 'problem-fields-right');

            }
           $published_id  = $problems->published_id; 
           $form_contents = view('postnatal_problem.problem_form', compact('left_column_param', 'problem_layout', 'right_column_param', 'uniqueId', 'single_column_param', 'problem_id', 'param_values', 'episode_id', 'published_id', 'drugs', 'antibiotic'))->render();
           
            return response()->json(['problemForm'=>$form_contents, 'status'=>'success', 'message'=>'Problem episode added !'], 200);

        } else {

            return response()->json(['status'=>'error', 'message'=>'Problem not found'], 404);

        }


    }

    public function getRemoveEpisode($episodeId, ProblemPostnatalEpisode $ProblemPostnatalEpisode)
    {

        if ($episodeId) {

             $problemValues['UserDeleted'] = $this->auth->user()->id;
             $problemValues['DateDeleted'] = Carbon::now($this->time_zone);
             $problemValues['IsDeleted']   = 1;
             $results =  $ProblemPostnatalEpisode->where('episode_id', $episodeId)->update($problemValues);

             if ($results) {
                 return response()->json(['status'=>'success', 'message'=>'Problem episode removed !'], 200);
             } else {
                 return response()->json(['status'=>'error', 'message'=>'Faild to remove!'], 422);
             } 

        } else {

            return response()->json(['status'=>'error','message'=>'Episods not found'], 404);
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
      $results = ProblemPostnatalList::findOrfail($id);
      $baby    = Baby::where(['IsDeleted'=>0,'BabyId'=>$results->baby_id])->first();

        $delete_data = array(
            'Name'             => $baby->BabyName,
            'ModuleController' => $this->module['module_controller'],
            'ModuleId'         => $id,
            'ModuleName'       => $this->module['module_name'],
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now($this->time_zone)
        );
        
        DeleteApproval::create($delete_data);
        $user_detail = array(
            'UserDeleted'   => $this->auth->user()->id,
            'DateModified'  => Carbon::now($this->time_zone),
            'IsDeleted'     => 1
        );
        $results->update($user_detail);
        return redirect(action('ProblemBaseDaycare\ProblemPostnatalController@index'))->with('info', 'Record deleted successfully !');
      
    }



}
