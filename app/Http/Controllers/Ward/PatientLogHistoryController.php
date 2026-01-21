<?php

namespace App\Http\Controllers\Ward;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Flow\FlowController;
use App\Http\Controllers\Errors\ErrorLogController;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Ward\BedLog;
use App\Models\Masters\Ward;
use App\Models\Masters\Room;
use App\Models\Masters\Bed;
use App\Models\Nurse\SyringePumpAdmisson;
use App\Models\Baby;
use App\Http\Controllers\Fhir\PrescriptionToMirthController;

class PatientLogHistoryController extends Controller
{
    public function  __construct(Guard $auth, FlowController $flow, ErrorLogController $custom_error)
    {
        $this->middleware('role:BABY_REG,write', ['only' => ['store', 'update', 'edit', 'create', 'destory']]);
        $this->middleware('role:BABY_REG,read', ['only' => ['index', 'show']]);
        $this->auth = $auth; 
        $this->flow = $flow; 
        $this->custom_error = $custom_error;
   
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $limit = 50; // Assign the Page limitation
        if (!empty($request->input('limit'))) {
            $request->session()->put('limit', $request->input('limit'));
            $limit = $request->session()->get('limit');
        } elseif ($request->session()->has('limit')) {
            $limit = $request->session()->get('limit');
        }
         

        $order['sortby']    = 'baby.DateAdded';
        $order['sortorder'] = 'desc';

        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {
            $order['sortby']     =\SiteHelpers::decrypt_id($request->input('sortby'));
            $order['sortorder']  = $request->input('sortorder');
        }

        $search_txt = '';
        if (!empty($request->input('search_txt'))) {
            $search_txt = $request->input('search_txt');
        }
        // Assing Menu section
        $navigate['main_nav'] = 'patient_log';
        $navigate['sub_nav']  = 'patient_log';

        // Get Baby list using Baby models
        $result   = BedLog::ListDatawithSearch($request->input('page'), $limit, $search_txt, $order);
        $results  = $result['result'];

        // $results = $results->unique('BabyName');
        // Get Total For baby list.
        $getTotal = BedLog::GetTotals();
        $total    = $result['total']; 

        // Set page       
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
        // Assing data to View & define the blade file
        $this->flow->clearFlow();

        return view('ward.patient_log',compact('pagination', 'order', 'results', 'getTotal', 'search_txt', 'navigate'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

       $results = BedLog::getPatinetLog($id);
       $ward    = Ward::get()->pluck('name','id')->toArray();
       $room    = room::get()->pluck('number','id')->toArray();
       $bed     = bed::get()->pluck('number','id')->toArray();
       if($request->ajax()) {
        $results = view('ward.patient_log_edit',compact('results', 'ward', 'room', 'bed','id'))->render();
        return \Response::json(['type'=>'success','results'=>$results]);
       }

          return view('ward.patient_log_edit',compact('results', 'ward', 'room', 'bed','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param   int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $ward    = Ward::get()->pluck('name','id')->toArray();
        $room    = room::get()->pluck('number','id')->toArray();
        $bed     = bed::get()->pluck('number','id')->toArray();

        $patient_log = BedLog::find($id);

        $patient_log->ward_id   = $input['ward_name'];  
        $patient_log->room_id   = $input['room_no'];
        $patient_log->bed_id    = $input['bed_no'];
        $patient_log->ward_name = $ward[$input['ward_name']];
        $patient_log->room_no   = $room[$input['room_no']];
        $patient_log->bed_no    = $bed[$input['bed_no']];
        $patient_log->save();
        if($request->ajax()) {
        return \Response::json(['type'=>'success','message'=>'Record updated successfully','results'=>$patient_log]);
        }

        return redirect(action('Ward\PatientLogHistoryController@edit', $id))
                      ->with('success','Record updated successfully');
    }

    /**
     * This method to get bed no
     *
     *
     */
     public function getBedDetails($room_id)
     {
        $bed = Bed::getbeddetails($room_id, 'all')->where('status', '<>', 'Occupied')
                  ->pluck('number','id')
                  ->toArray();

         return \Response::json(['bed_list'=>$bed]);         
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
     * This method update resource
     *
     *
     */
    public function updateBedDetails($id) 
    {
        $patient_log = BedLog::find($id);
        $bed         = bed::find($patient_log->bed_id);
        $baby        = Baby::find($patient_log->baby_id);
        if($bed->status == null &&  $patient_log->status != 'Occupied') {

        $patient_log->status = 'Occupied';
        $patient_log->save();
        $syringe_pump['baby_id']          = $patient_log->baby_id;
        $syringe_pump['admission_id']     = $patient_log->admission_id;
        $syringe_pump['admission_stauts'] = '0';
        $syringe_pump['mother_id']        = $baby->MotherId;
        SyringePumpAdmisson::create($syringe_pump);
        PrescriptionToMirthController::admission();
        $bed->status =  'Occupied';
        $bed->save(); 
          return \Response::json(['type'=>'success','message'=>'Record update successfully'],200);
        }else {
          return \Response::json(['type'=>'error','message'=>'Already baby exists'],200);
        }
        


    }


}
