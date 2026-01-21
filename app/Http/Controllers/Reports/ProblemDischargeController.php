<?php
namespace App\Http\Controllers\Reports;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Reports\ProblemDischarge;
use App\Models\Settings\Settings;
use App\Models\Problems;
use App\Exceptions\InvalidInputException;
use App\Models\Masters\Vaccine;
use App\Models\Medications;
use App\Models\Masters\Drug;
use App\Models\Masters\AntibioticMaster;
use App\Models\Masters\DoctorMaster;
use App\Http\Controllers\Flow\FlowController;
use App\Models\ProblemDaycareEpisode;
use Carbon\Carbon;
use App\Models\NicuProblemBaseSummary;
use App\Models\DischargeSummary;
use App\Models\SummariesPrint\NicuProblemSummaryPrint;
use App\Models\Masters\DrugIvFluidMaster;

/**
 * Methods to Nicu problem based discharge summary
 * business logic
 *
 * @author Manikandan M
 */
class ProblemDischargeController extends Controller
{
    /**
     * This Method To Get Nicu Admission Baby List
     *
     * @param  $auth type object of Illuminate\Http\Request
     * @param  $flow type instance  App\Http\Controllers\Flow\flowController
     *
     * @return Response object to view
     */
    public function __construct(Guard $auth, FlowController $flow)
    {
        $this->middleware('role:NICU_PROBLEM_DISCHARGE,read', ['only' => ['dischargeBabylist', 'discharge_main_list', 'discharge_sub_list', 'index']]);
        $this->auth = $auth;
        $this->flow = $flow;
        $this->time_zone = env('TIME_ZONE');
    }

    /**
     * This Method To Get Nicu Admission Baby List
     *
     * @param $request type object of Illuminate\Http\Request
     * @return Response object to view
     */
    public function dischargeBabylist($summary_type = '',Request $request)
    {

        //Initialize the record  limit  with 50

        $limit = 50;

        //set the limit as per the request
        if (!empty($request->input('limit')))
        {

            $request->session()->put('limit', $request->input('limit'));
            $limit = $request->session()->get('limit');

        }
        elseif ($request->session()->has('limit'))
        {

            $limit = $request->session()->get('limit');

        }

        //Initialize the record sorting key and order
        $order['sortby'] = 'baby.BabyId';
        $order['sortorder'] = 'desc';
        //set the records sorting key and order
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder')))
        {
            $order['sortby'] = \SiteHelpers::decrypt_id($request->input('sortby'));
            $order['sortorder'] = $request->input('sortorder');

        }

        //initialize search parameter array
        $search = array();
        $search['search_txt'] = '';
        if (!empty($request->input('search_txt')))
        {

            $search['search_txt'] = $request->input('search_txt');

        }

        //setting the navigation bar
        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'problem_nicu_discharge';

        $status = !empty($request->input('status')) ? $request->input('status') : 'discharged';
        $page = !empty($request->input('page')) ? $request->input('page') : 1;
        $page = preg_replace( '/[^0-9]/', '', $page);

        //get the mother record list form mother module
        $result = ProblemDischarge::getList($page , $limit, $search, $order, 1, $summary_type, $status);
        
        $limitstart = ((empty($page) || $page == 1) && !is_numeric($page)) ? 1 : (($page - 1) * $limit);

        $total = $result->get()->count();

        $results = $result->limit($limit)->offset($limitstart)->get();

        $getTotal = ProblemDischarge::GetTotal();
       
        $pagecount = ceil($total / $limit);
        $pagination['total'] = $total;
        $pagination['start'] = (($page - 2) < 1) ? 1 : ($page - 2);
        $pagination['end'] = ($pagecount < ($page + 3)) ? $pagecount : ($page + 3);
        $pagestart = $total != 0 ? ($page <= 1) ? $page : ($page - 1) * $limit + 1 : 0;
        $pagerecords = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page * $limit;
        $pagination['limit'] = array(
            $pagestart,
            $pagerecords
        );
        $pagination['limits'] = $limit;
        $pagination['previous'] = (($page - 1) < 1) ? 1 : ($page - 1);
        $pagination['next'] = ($pagecount < ($page + 1)) ? $pagecount : ($page + 1);
        $this->flow->clearFlow();

        return view('reports.problem-discharge.discharge-main-list', compact('results', 'navigate', 'pagination', 'search', 'order', 'getTotal','summary_type', 'status'));
    }

    /**
     * This Method To Get Nicu Admission List of single baby
     *
     * @param $request type object of Illuminate\Http\Request
     * @param $id  type encrypted integer
     * @return Response object to view
     */
    public function dischargeAdmissionlist(Request $request, $id, $summary_type = '')
    {

        $id = \SiteHelpers::decrypt_id($id);
        $results = ProblemDischarge::getAdmissionlist($id)->unique('ip_number');

        $BabyName = isset($results[0]->BabyName) ? $results[0]->BabyName : '';

        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'problem_nicu_discharge';

        return view('reports.problem-discharge.discharge-admission-list', compact('results', 'BabyName', 'navigate', 'summary_type'));
    }

    public function dischargeSummary(Request $request, $id, $summary_type = '')
    {

        $editor_gen_option = false;
        $id = \SiteHelpers::decrypt_id($id);
        if (count(explode('-', $id)) == 2)
        {
            $baby_id = explode('-', $id) [0];
            $admission_id = explode('-', $id) [1];
        }
        else
        {
            throw new InvalidInputException(\SiteHelpers::getUserExceptionMessage(7017) , 7017);
        }

        //fetch the data for header
        $headerContent = Settings::findorfail(1);

        $neonatalDetails = [];
        //fetch the data for newborn
        $neonatalDetails = ProblemDischarge::getNewbornDetails($baby_id);

        //fetch the data for admission and discharge details
        $nicuDetails = ProblemDischarge::getAdmissionDetails($baby_id, $admission_id);

        //fetch the data for diaganosis and neonatalproblems
        $problems = ProblemDischarge::getNeonatalProblems($baby_id, $admission_id);
        $neonatalProblems = $problems->pluck('problem_name')->unique();

        //fetch drugs form master
        // $drug_master = Drug::ListData()->pluck('Name', 'Id')->toArray();
        $drug_master = DrugIvFluidMaster::where(['is_deleted' => '0', 'status' => 1])
        ->select('id')
        ->selectRaw('(CASE WHEN char_length(brand_name) > 0 THEN brand_name|| \' / \' ||generic_pharmacological_name ELSE generic_pharmacological_name END) AS name')
        ->where(function($query) {
            $query->where('type', 'ORAL')
                ->orWhereNull('type')
                ->orWhere('type', '');
        })
        // ->where('brand_name', '!=', '')
        ->orderby('id', 'asc')
        ->pluck('name', 'id')
        ->toArray();

        //fetch antibiotic master
        // $AntibioticMaster = AntibioticMaster::get()->pluck('Name', 'Id')->toArray();
        $AntibioticMaster = DrugIvFluidMaster::where(['is_deleted' => '0', 'status' => 1])
        ->select('id')
        ->selectRaw('(CASE WHEN char_length(brand_name) > 0 THEN brand_name|| \' / \' ||generic_pharmacological_name ELSE generic_pharmacological_name END) AS name')
        ->where(function($query) {
            $query->where('type', '<>', 'ORAL')
                ->orWhereNull('type')
                ->orWhere('type', '');
        })
        // ->where('brand_name', '!=', '')
        ->orderby('id', 'asc')
        ->pluck('name', 'id')
        ->toArray();
        //fetch the data for DETAILED SUMMARY
        $problems_ids = $problems->sortBy('pb_day_id')
            ->pluck('problem_id')
            ->unique()
            ->toArray();
        $episodes = array();
        foreach ($problems_ids as $problems_id)
        {
            $episodes[$problems_id] = $problems->where('problem_id', $problems_id)->sortBy('episode_id');
        }

        //Doctors master list
        $doctor_master = DoctorMaster::ListData();

        $mMedicalproblems = ProblemDischarge::getMotherMedicalProblems($baby_id);

        $pregnancyComplications = ProblemDischarge::getMotherPregnancyComplications($baby_id);
        $usgFinding = ProblemDischarge::getUsgFindings($baby_id);

        $Vaccine = Vaccine::pluck('Name', 'Id')->toArray();
        $discharge_medications = ProblemDischarge::getDischargeMedications($baby_id, $admission_id, 2);

        $VaccineDetails = isset($neonatalDetails) && !empty($neonatalDetails) ? collect([json_decode($neonatalDetails->Vaccine) , json_decode($nicuDetails->Vaccine) ]) : [];
        $VaccineDetails = count($VaccineDetails) > 0 ? $VaccineDetails->collapse()->toArray() : [];
        $VaccineDate = isset($neonatalDetails) && !empty($neonatalDetails) ? collect([json_decode($neonatalDetails->VaccineDate) , json_decode($nicuDetails->VaccineDate) ]) : [];
        $VaccineDate = count($VaccineDetails) > 0 ? $VaccineDate->collapse()->toArray() : [];

        //formating nicu admission and discharge values
        $nicuDetails->admission_cga = isset($nicuDetails->admission_cga) ? \SiteHelpers::decode_gestation($nicuDetails->admission_cga) : 'N/A';
        $nicuDetails->discharge_cga = isset($nicuDetails->discharge_cga) ? \SiteHelpers::decode_gestation($nicuDetails->discharge_cga) : 'N/A';

        // formating the discharge weight, discharge length and discharge ofc
        // formating performad based on admissions

        $neonatalDetails->discharge_wt = isset($nicuDetails->discharge_wt) ? $nicuDetails->discharge_wt : $neonatalDetails->discharge_wt;
        $neonatalDetails->discharge_length = isset($nicuDetails->discharge_ofc) ? $nicuDetails->discharge_length : $neonatalDetails->discharge_length;
        $neonatalDetails->discharge_ofc = isset($nicuDetails->discharge_ofc) ? $nicuDetails->discharge_ofc : $neonatalDetails->discharge_ofc;

        $neonatalDetails->Indication = json_decode($neonatalDetails->Indication);
        foreach ($neonatalDetails->Indication as $key => $value)
        {
            if ($value == '')
            {
                unset($neonatalDetails->Indication[$key]);
            } else if ($value == 'N\/A') {
                unset($neonatalDetails->Indication[$key]);

            } else if ($value == 'undefined') {
                unset($neonatalDetails->Indication[$key]);
                
            } else if ($value == 'N/A') {
                unset($neonatalDetails->Indication[$key]);
                
            }
        }
        $neonatalDetails->Indication = json_encode($neonatalDetails->Indication);
        if (isset($neonatalDetails->Indication) && $neonatalDetails->Indication != '["N\/A"]' && $neonatalDetails->Indication != '["undefined"]')
        {
            $neonatalDetails->Indication = ProblemDischarge::getDeliveryIndication($neonatalDetails->Indication);

        }
        $nicuDetails->procedures = ProblemDischarge::getProcedureList($nicuDetails->procedures);

        $closewinlink = action('Reports\ProblemDischargeController@dischargeAdmissionlist', \SiteHelpers::encrypt_id($baby_id));
        
        $editor_gen_option_val = NicuProblemBaseSummary::where(['baby_id'=>$baby_id, 'admission_id'=>$admission_id])->orderBy('id','desc')->first();
        if ($summary_type == 'interim' && isset($editor_gen_option_val->interim_summary_content) && !is_null($editor_gen_option_val->interim_summary_content)) {
            $editor_gen_option = 0;
        }
        elseif ($summary_type == '' && isset($editor_gen_option_val->edited_content) && !is_null($editor_gen_option_val->edited_content)) {
            $editor_gen_option = 0;
        }
        else
        {
            $editor_gen_option = 1;
        }

        // $neonatalDetails->neonatal_consultant = \SiteHelpers::formating_consultant_signature($neonatalDetails->neonatal_consultant, false, $nicuDetails->hospital_name, true);
        $neonatalDetails->neonatal_consultant = \ValuelistHelpers::signatureFormat($neonatalDetails->neonatal_consultant, 1);
        
        $discharge_details = DischargeSummary::where(['baby_id' => $baby_id, 'admission_id' => $admission_id])->select('newproblem')->first();

        $editor_gen = false;
        if (\Session::has('nicu-pblm-disch-editor'))
        {
            \Session::forget('nicu-pblm-disch-editor');
            $editor_gen = true;
            return view('reports.problem-discharge.print', compact('neonatalDetails', 'closewinlink', 'doctor_master', 'headerContent', 'nicuDetails', 'mMedicalproblems', 'pregnancyComplications', 'usgFinding', 'Vaccine', 'VaccineDetails', 'VaccineDate', 'discharge_medications', 'neonatalProblems', 'episodes', 'drug_master', 'AntibioticMaster', 'editor_gen', 'editor_gen_option', 'summary_type'))->renderSections();
        }

        $old_print_sheet_count = NicuProblemSummaryPrint::getPrintedContentCount($baby_id, $admission_id);

        return view('reports.problem-discharge.print', compact('neonatalDetails', 'closewinlink', 'doctor_master', 'headerContent', 'nicuDetails', 'mMedicalproblems', 'pregnancyComplications', 'usgFinding', 'Vaccine', 'VaccineDetails', 'VaccineDate', 'discharge_medications', 'neonatalProblems', 'episodes', 'drug_master', 'AntibioticMaster', 'editor_gen_option', 'summary_type' , 'discharge_details', 'old_print_sheet_count'));

    }

    // public function store(Request $request)
    // {
    //     $input = $request->all();

    //     //set values for add values
    //     $get_data['baby_id'] = \SiteHelpers::decrypt_id($input['BabyId']);
    //     $get_data['admission_id'] = \SiteHelpers::decrypt_id($input['AdmissionId']);
    //     // $get_data['flag']         = !($input['flag'] > 0) ? true : false;
    //     //set values for changes
    //     foreach ($input as $key => $value)
    //     {
    //         if (is_numeric(preg_replace('/[A-Za-z,-]/', '', $key)))
    //         {
    //             $get_data['episode_id'] = preg_replace('/[A-Za-z,-]/', '', $key);
    //             $discharge_details = ProblemDaycareEpisode::where($get_data)->first();
    //             if (count($discharge_details) > 0)
    //             {

    //                 $input['DateModified'] = Carbon::now();
    //                 $input['UserModified'] = \Auth::user()->id;
    //                 $result = $discharge_details->update(['problem_edit' => $input[$key]]);

    //             }
    //             else
    //             {

    //                 $result = ProblemDaycareEpisode::create($input);

    //             }
    //         }
    //     }

    //     if ($request->ajax())
    //     {

    //         if ($result)
    //         {

    //             return \Response::json(['message' => 'Record saved', 'code' => 200], 200);

    //         }
    //         else
    //         {

    //             return \Response::json(['message' => 'Record not saved', 'code' => 201], 201);

    //         }

    //     }
    //     else
    //     {
    //         $input['baby_id'] = \SiteHelpers::encrypt_id($input['BabyId']);
    //         $input['admission_id'] = \SiteHelpers::encrypt_id($input['AdmissionId']);

    //         if ($result)
    //         {

    //             // return redirect(action('Reports\ProblemDischargeController@dischargeSummary', $input['baby_id'].'-'.$input['admission_id']))->withInput(\Input::except('_token'))
    //                 // ->with('Success', 'Record saved Successfully ');

    //         }
    //         else
    //         {

    //             // return redirect(action('Reports\ProblemDischargeController@dischargeSummary', $input['baby_id'].'-'.$input['admission_id']))->withInput(\Input::except('_token'))
    //             //     ->with('error', 'Record Not Saved Properly');
    //         }

    //     }

    // }

    /**
     * OPEN DISCHARGE REPORT WITH FULL EDITOR
     *
     */

    public function getfullEditor(Request $request, $summary_type = '')
    {
        $input = $request->all();
        \Session::put('nicu-pblm-disch-editor', true);
        return \Response::json(['dataUrl' => $input['dataUrl']], 200);

    }

    /**
     * OPEN DISCHARGE REPORT WITH FULL EDITOR
     *
     */
    public function saveFullEditor(Request $request, $summary_type = '')
    {

        // assign inputs to variable
        $input = $request->all();
        $baby_id = $input['baby_id'];
        $admission_id = $input['admission_id'];
        $check_exist_summary = NicuProblemBaseSummary::where(['baby_id'=>$baby_id, 'admission_id'=>$admission_id])->first();
        $summary_array = array(
            'baby_id' => $baby_id,
            'admission_id' => $admission_id,
        );
        if ($summary_type == 'interim') {
            $summary_array['interim_summary_content'] = $input['daycare_summary'];
            $summary_array['interim_updated_at'] = Carbon::now($this->time_zone);
        }
        else
        {
            $summary_array['edited_content'] = $input['daycare_summary'];
            $summary_array['edited_time'] = Carbon::now($this->time_zone);
            $summary_array['edited'] = true;
        }
        if (isset($check_exist_summary->id)) {
            NicuProblemBaseSummary::where('id', $check_exist_summary->id)->update($summary_array);
        }
        else
        {
            NicuProblemBaseSummary::insert($summary_array);
        }

        // create slug for updated
        $summary_id = \SiteHelpers::encrypt_id($input['baby_id'].'-'.$input['admission_id']);

        if ($request->ajax()) {
            return \Response::json(['type'=>'success','msg' => 'Record Updated Successfully']);
        } else {
            return redirect(action('Reports\ProblemDischargeController@getAbbreviatedsummaryShow', [$summary_id, 'interim']))->with('success', 'Record updated successfully');
        }
    }

    public function getAbbreviatedsummaryShow(Request $request, $id, $summary_type = '')
    {
        $summary_id = \SiteHelpers::decrypt_id($id);
        $discharge_details = array();
        if (count(explode('-', $summary_id)) == 2)
        {
            $baby_id = explode('-', $summary_id) [0];
            $admission_id = explode('-', $summary_id) [1];
        }
        else
        {
            throw new InvalidInputException(\SiteHelpers::getUserExceptionMessage(7017) , 7017);
        }

        $dischargeSummarymodified = array();

        if (isset($baby_id) && !empty($baby_id) && isset($admission_id) && !empty($admission_id))
        {

            $dischage_summary['baby_id'] = $baby_id;
            $dischage_summary['admission_id'] = $admission_id;

        }
        else
        {

            return redirect(url('/'))->with('error', 'Invalid record');

        }

        //fetch the data for admission and discharge details
        $summary = NicuProblemBaseSummary::where(['baby_id'=>$baby_id, 'admission_id'=>$admission_id])->orderBy('id','desc')->first();
        \Session::put('nicu-pblm-disch-editor', true);

        $interim = false;
        if (count($summary) > 0) {
            if($summary_type == '') {
                if (!empty($summary->edited_content)) {
                    $discharge_details['content'] = $summary->edited_content;
                }
                else
                {
                    $discharge_details = $this->dischargeSummary($request, $id, '');
                }
                if (!empty($summary->interim_summary_content)) {
                    $interim = true;
                }
            } 
            elseif (!empty($summary->interim_summary_content) && ($summary_type == 'interim' || $summary_type == 'interimiframe')) {
                $discharge_details['content'] = $summary->interim_summary_content;
            }
        } else {
            $discharge_details = $this->dischargeSummary($request, $id, $summary_type);
        }
        $editor_gen = false;
        \Session::forget('nicu-pblm-disch-editor');
        return view('reports.problem-discharge.editor', compact('discharge_details', 'dischargeSummarymodified', 'dischage_summary', 'completed', 'summary_type', 'interim'));
    }
    
    public function store(Request $request)
    {
        $input = $request->all();

        $getbaby_details = explode('-', \SiteHelpers::decrypt_id($input['BabyId']));
        //set values for add values
        if (is_array($getbaby_details) && count($getbaby_details) > 1) {
            $input['admission_id'] = $get_data['admission_id'] = $getbaby_details[1];
            $input['baby_id'] = $get_data['baby_id'] = $getbaby_details[0];            
        } else {            
            $input['admission_id'] = $get_data['admission_id'] = \SiteHelpers::decrypt_id($input['AdmissionId']);
            $input['baby_id'] = $get_data['baby_id'] = \SiteHelpers::decrypt_id($input['BabyId']);
        }

        $get_data['flag'] = $input['flag'];
        //set values for changes
        $discharge_details = DischargeSummary::where($get_data)->first();
        $input['is_completed'] = (isset($input['is_completed']) && $input['is_completed'] == 'on') ? 2 : 1;
        $input['is_send'] = (isset($input['is_send']) && $input['is_send'] == 'on') ? 2 : 1;

        $input['newproblem'] = isset($input['editor_val']) ? serialize($input['editor_val']) : '';
        // if (isset($input['newdiagnosis']) && !empty($input['newdiagnosis'])) {
        //     $newly_added_diagnosis = array();
        //     $diag = explode('++', $input['newdiagnosis']);
        //     if (count($diag) != 0) {
        //         foreach ($diag as $diag_key => $diag_value) {
        //             if (trim($diag_value) != '') {
        //                 $serialize_array = explode('||', $diag_value);
        //                 if (count($serialize_array) > 0 && isset($serialize_array[0]) && isset($serialize_array[1]) ) {
        //                     $array_diag = array(
        //                         'dependency' => $serialize_array[0],
        //                         'add_diagnosis' => $serialize_array[1],
        //                     );
        //                     $newly_added_diagnosis[] = $array_diag;
        //                 }
        //             }
        //         }
        //     }
        //     $input['newdiagnosis'] = serialize($newly_added_diagnosis);
        // }

        if ($input['is_completed'] == 2 && $input['is_send'] == 2)
        {
            $this->generatePdf($input['BabyId'], $request, $input['summary_mail']);
        }

        if (count($discharge_details) > 0)
        {

            $input['DateModified'] = Carbon::now();
            $input['UserModified'] = \Auth::user()->id;
            $result = $discharge_details->update($input);

        }
        else
        {
            $result = DischargeSummary::create($input);

        }

        if ($request->ajax())
        {

            if ($result)
            {

                return \Response::json(['message' => 'Record saved', 'code' => 200], 200);

            }
            else
            {

                return \Response::json(['message' => 'Record not saved', 'code' => 201], 201);

            }

        }
        else
        {

            if ($result)
            {

                return redirect(action('Reports\NicuDischargeController@index', $input['BabyId']))->withInput(\Input::except('_token'));
                // ->with('Success', 'Record saved successfully ');

            }
            else
            {

                return redirect(action('Reports\NicuDischargeController@index', $input['BabyId']))->withInput(\Input::except('_token'))
                ->with('error', 'Record not saved properly');
            }

        }

    }

    public function savePrintedContent(Request $request)
    {
        $input = $request->all();

        $input['baby_id'] = \SiteHelpers::decrypt_id($input['baby_id']);
        $input['admission_id'] = \SiteHelpers::decrypt_id($input['admission_id']);
        $input['printed_date_time'] = Carbon::now();
        $input['printed_user_id'] = \Auth::user()->id;

        NicuProblemSummaryPrint::insert($input);

        return \Response::json(['message'=>'Success', 'massage_type'=>'Success'], 200);

    }

    public function getPrintedContent(Request $request)
    {
        $input = $request->all();

        $baby_id = \SiteHelpers::decrypt_id($input['baby_id']);
        $admission_id = \SiteHelpers::decrypt_id($input['admission_id']);
        $summary_approval = $this->auth->user()->summary_approval;
        $user_id = $this->auth->user()->id;

        $get_printed_content = NicuProblemSummaryPrint::getPrintedContent($baby_id, $admission_id);

        return \Response::json(['get_printed_content'=>$get_printed_content, 'summary_approval'=>$summary_approval, 'user_id'=>$user_id]);

    }

    public function getPrintedHtmlContent(Request $request)
    {
        $input = $request->input('id');

        $results = NicuProblemSummaryPrint::getPrintedHtmlContent($input);
        
        $get_printed_html_content = $results->summary_text;

        return \Response::json(['get_printed_html_content'=>$get_printed_html_content]);

    }

    public function summaryApproval(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];

        $old_results = NicuProblemSummaryPrint::getPrintedHtmlContent($input);

        $html_content = $old_results['summary_text'];
        $old_approved_ids = $old_results['approved_user_ids'];

        $approved_by = $this->auth->user()->id;
        $signature = $this->auth->user()->signature;

        if (!empty($old_approved_ids) && !is_null($old_approved_ids)) {
            $approved_ids = $old_approved_ids . '||' . $approved_by;
        } else {
            $approved_ids = $approved_by;
        }

        $find_text = '<span class="signature-tag hide" id="doctor-' . $approved_by . '"></span>';
        $replace_text = '<span class="signature-tag" id="doctor-' . $approved_by . '"><img src="' . url('/') . '/public/img/users/' . $signature . '"></span>';

        $edited_content = str_replace($find_text, $replace_text, $html_content);

        $post['summary_text'] = $edited_content;
        $post['approved_user_ids'] = $approved_ids;
        $post['approved_date_time'] = Carbon::now($this->time_zone);

        $results = NicuProblemSummaryPrint::findorfail($id);
        $results->update($post);

        return \Response::json(['type'=>'success','msg' => 'Summary Approved Successfully']);

    }


}

