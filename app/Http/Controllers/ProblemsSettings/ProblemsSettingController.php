<?php

namespace App\Http\Controllers\ProblemsSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Carbon\Carbon;
// use App\Models\Masters\Drug as Drug;
use App\Models\Masters\DrugIvFluidMaster;
use App\Models\Masters\AntibioticMaster;
use App\Http\Requests\Problemsettings\ProblemSettingRequest;
use App\Http\Controllers\ProblemsSettings\ProblemsSettingsProperty;
use App\Models\Masters\DaycareProblems;
use App\Models\Masters\DaycareProblemsPublished;
use App\Models\Settings\DeleteApproval;

/**
 * methods to retrive data from published problem settings 
 *
 * @author Manikandan M  
 */
class ProblemsSettingController extends Controller
{

    public $timezone;

    public  $problemdaycare;

    public $auth;

    public $problemproperties;  

    /**
    * constructer method.
    *
    * @param $auth object of Guard 
    *
    * @param $problemproperties object of ProblemsSettingsProperty 
    *
    * @return initialze require models object and check the permission for module 
    */
    public function __construct(Guard $auth, ProblemsSettingsProperty $problemproperties) 
    {
        $this->middleware('role:MAS_PROBLEM_SETTING,write', ['only' => ['store', 'update', 'edit', 'create', 'show', 'destroy']]);
        $this->middleware('role:MAS_PROBLEM_SETTING,read', ['only' => ['index', 'printData']]);  
        $this->auth               = $auth;
        $this->problemproperties  = $problemproperties;
        $this->timezone           = env('TIME_ZONE');
  
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DaycareProblems $daycareproblems)
    {

        $limit = 50;
        if (!empty($request->input('limit'))) {
            $request->session()->put('limit', $request->input('limit'));
            $limit = $request->session()->get('limit');
        } elseif ($request->session()->has('limit')) {
            $limit = $request->session()->get('limit');
        }

        $order['sortby']    = 'problem_id';
        $order['sortorder'] = 'desc';       
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {
          $order['sortby']     = \SiteHelpers::decrypt_id($request->input('sortby'));
          $order['sortorder']  = $request->input('sortorder');
        }   

        $search_txt='';
        if (!empty($request->input('search_txt'))) {
            $search_txt = $request->input('search_txt');
        }
        $result                 = $daycareproblems->GetList($request->input('page'), $limit, $search_txt, $order);
        $problemslist           = $result['result'];
        $getTotal               = count($daycareproblems->GetTotal());
        $total                  = $result['total']; 

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

        return view('ProblemsSettings.list', compact('problemslist', 'pagination', 'order', 'search_txt', 'getTotal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $option_masters  = \SiteHelpers::getMasterlist(); 

       return view('ProblemsSettings.create', compact('option_masters'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProblemSettingRequest $request, DaycareProblems $daycareProblems)
    {
        $input               = $request->all();
        $componentPropertice = array();


        if (isset($input['para_name'])) {

            $this->problemproperties->setPropertyList($input);
            $componentPropertice = $this->problemproperties->getPropertyList();

            $problemdaycare['problem_name']        = $input['problem_name'];
            $problemdaycare['problem_description'] = '';
            $problemdaycare['problem_fields']      = json_encode($componentPropertice);
            $problemdaycare['problem_status']      = ($input['save'] == 2) ? 1 : 0 ;
            $problemdaycare['problem_layout']      = $input['problem_layout'];
            $problemdaycare['UserAdded']           = $this->auth->user()->id;
            $problemdaycare['DateAdded']           = Carbon::now($this->timezone);
            $problemdaycare['UserModified']        = $this->auth->user()->id;
            $problemdaycare['DateModified']        = Carbon::now($this->timezone);
            $problem_id = DaycareProblems::create($problemdaycare)->problem_id;

            if ($input['save'] == 2) {
                   $problem_master = $daycareProblems->find($problem_id)->toArray();
                   DaycareProblemsPublished::create($problem_master);

            }
        } else {
            return redirect()->back()->with('error', 'Please add atleast one fields');
        }    
    
      return redirect(action('ProblemsSettings\ProblemsSettingController@edit', \SiteHelpers::encrypt_id($problem_id)))->with('Success', 'Problem added successfully!');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Masters\Problemdaycare  $problemdaycare
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Masters\Problemdaycare  $problemdaycare
     * @return \Illuminate\Http\Response
     */
    public function edit($problem_id, Request $request, DaycareProblems $daycareProblems)
    {
        $problem_id = \SiteHelpers::decrypt_id($problem_id);
        $problems        = $daycareProblems->get_record($problem_id);
        $option_masters  = \SiteHelpers::getMasterlist(); 
        $problems_list   = collect(json_decode($problems->problem_fields)); 
        $drugs      =  DrugIvFluidMaster::ListData()->pluck('brand_name', 'id')->toArray();
        // $antibiotic =  AntibioticMaster::get_lists()->pluck('Name', 'Id')->toArray();
        $antibiotic  = DrugIvFluidMaster::getDrugsList();
        return view('ProblemsSettings.edit', compact('problems_list', 'problems', 'option_masters', 'drugs', 'antibiotic'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Masters\Problemdaycare  $daycareProblems
     * @return \Illuminate\Http\Response
     */
    public function update($problem_id, ProblemSettingRequest $request, DaycareProblems $daycareProblems)
    {
        $input = $request->all();

        $problem = $daycareProblems->find($problem_id);

        if (count($problem) > 0) {

            $this->problemproperties->setPropertyList($input);
            $componentPropertice          = $this->problemproperties->getPropertyList();
            $problem->problem_name        = $input['problem_name'];
            $problem->problem_description = '';
            $problem->problem_fields      = json_encode($componentPropertice);
            $problem->problem_layout      = $input['problem_layout'];
            $problem->UserModified        = $this->auth->user()->id;
            $problem->DateModified        = Carbon::now();
            if ($input['save'] == 2) {
               $problem->problem_status   = 1;
               $problem->save();
               $problem_master = $daycareProblems->find($problem_id)->toArray();
                $problem_master['UserAdded']        = $this->auth->user()->id;
                $problem_master['DateAdded']        = Carbon::now();
                $problem_master['UserModified']        = $this->auth->user()->id;
                $problem_master['DateModified']        = Carbon::now();
               DaycareProblemsPublished::create($problem_master);

            } elseif ($input['save'] == 3) {
               $problem->problem_status    =  0;
               $problem->save();
                $problem_master['UserModified']        = $this->auth->user()->id;
                $problem_master['DateModified']        = Carbon::now();
                $problem_master['problem_status']        = 0;
               DaycareProblemsPublished::where(['problem_id'=>$problem_id])->update($problem_master);

            } else {
               $problem->save();
                $problem = $daycareProblems->find($problem_id);

            }
            return redirect(action('ProblemsSettings\ProblemsSettingController@edit', \SiteHelpers::encrypt_id($problem_id)))->with('Success', 'Problem updated successfully');

        }

      
    }

    public function getFromproperty(Request $request) 
    {

        $input            = $request->all();
        $typeofComponent  = isset($input['componentType']) ? $input['componentType'] : '';
        $baseLayout       = isset($input['baseLayout']) ? $input['baseLayout'] : '';
        $formType         = $input['formType'];
        $groupId          = isset($input['groupId']) ? $input['groupId'] : 0 ;
        $option_masters   = \SiteHelpers::getMasterlist(); 
        $componentHeading = \FormHelpers::proertyHeadings($typeofComponent);
        $Medications      =  DrugIvFluidMaster::ListData()->pluck('brand_name', 'id')->toArray();
        // $Antibiotic       = AntibioticMaster::get_lists()->pluck('Name', 'Id')->toArray();
        $Antibiotic  = DrugIvFluidMaster::getDrugsList();

        return view('ProblemsSettings.problem_properties', compact('option_masters', 'Medications', 'Antibiotic', 'formType', 'groupId', 'typeofComponent', 'baseLayout', 'componentHeading'))->render();

        
    }

    public function getDropboxoption(Request $request) 
    {

        $input          = $request->all();
        $masterName     = $input['masterName'];
        $masterId       =  \SiteHelpers::create_mas_object($masterName);
        $optionValue    = $masterId->where('IsDeleted', 0)->pluck('id')->toArray();

        return \Response::JSON(['option_value'=>$optionValue, 'option_name'=>$optionValue], 200);




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Masters\Problemdaycare  $problemdaycare
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, DaycareProblems $daycareProblems)
    {

        $results = $daycareProblems->find($id);
        $user_detail = array(
            'UserDeleted' => $this->auth->user()->id,
            'DateModified' => Carbon::now($this->timezone),
            'IsDeleted' => '1'
        );
        $results->update($user_detail);
        $result = $daycareProblems->get_record($id);
        $res = $result;

        $delete_data = array(
            'Name' => $res->problem_name,
            'AdmissionDate' => $results['DateAdded'],
            'ModuleController' => 'ProblemsSettings\ProblemsSettingController',
            'ModuleId' => $id,
            'ModuleName' => 'Problems Settings',
            'UserDeleted' => $this->auth->user()->id,
            'DateDeleted' => Carbon::now($this->timezone)
        );
        DeleteApproval::create($delete_data);

        return redirect(action('ProblemsSettings\ProblemsSettingController@index'))->with('info', 'Record deleted successfully !');

       
    }
}
