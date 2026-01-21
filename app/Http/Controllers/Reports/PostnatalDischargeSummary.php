<?php
namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Reports\PostProblemDischargeSummary;
use App\Exceptions\InvalidInputException;
use App\Models\Settings\Settings;
use App\Models\Masters\Vaccine;
use App\Models\Masters\DoctorMaster;
use App\Models\Masters\Indication;
use App\Http\Controllers\Flow\FlowController;
use App\Models\Masters\AntibioticMaster as AntibioticMaster;
use App\Models\Masters\Drug;
use App\Models\Baby;
use App\Models\PostnatalDischarge;
use App\Models\Masters\DrugIvFluidMaster;
use App\Models\SummariesPrint\PostnatalSummaryPrint;

class PostnatalDischargeSummary extends Controller
{

    /**
     * Initialize Gaurd instance
     * @var $auth type instance
     */
    public $auth;

    /**
     * Initialize navigation title
     * @var $navigate type array
     */
    public $navigate;

    /**
     * Constructor Method.
     *
     * @param $auth instance of Illuminate\Contracts\Auth\Guard
     *
     */
    public function __construct(Guard $auth, FlowController $flow)
    {
        $this->middleware('role:POST_DISCHARGE,read', ['only' => ['index', 'show']]);

        $this->auth = $auth;
        $this->navigate['main_nav'] = 'postnatal';
        $this->navigate['sub_nav'] = 'post_problem_discharge';
        $this->navigate['module_name'] = 'Postnatal Problem Base Systems Discharge Summary';
        $this->module['module_controller'] = 'Reports\PostnatalDischargeSummary';
        $this->flow = $flow;
        $this->time_zone = env('TIME_ZONE');

    }

    /**
     * Display a listing of the resource.
     *
     * @param $request instance of Illuminate\Http\Request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $input = $request->all();
        //Initialize the record  limit  with 50
        $limit = 10;

        //set the limit as per the request
        if (!empty($request->input('limit')))
        {

            $request->session()
                ->put('limit', $request->input('limit'));
            $limit = $request->session()
                ->get('limit');

        }
        elseif ($request->session()
            ->has('limit'))
        {

            $limit = $request->session()
                ->get('limit');

        }
        $page = !empty($request->input('page')) ? $request->input('page') : 1;
        $page = preg_replace( '/[^0-9]/', '', $page);

        $navigate = $this->navigate;

        $order['sortby'] = isset($input['sortby']) ? \SiteHelpers::decrypt_id($input['sortby']) : 'BMrNo';
        $order['sortorder'] = isset($input['sortorder']) ? $input['sortorder'] : 'desc';

        $search['search_txt'] = isset($input['search_txt']) ? $input['search_txt'] : '';

        $status = !empty($request->input('status')) ? $request->input('status') : 'discharged';

        $result = PostProblemDischargeSummary::getBabylist($page, $limit, $search, $order, 1, $status);
        $results = $result['result'];

        $getTotal = PostProblemDischargeSummary::getTotal();
        $total = $result['total'];

        $pagecount = (!empty($search['search_txt'])) ? ceil($total / $limit) : ceil($total / $limit);
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

        $this
            ->flow
            ->clearFlow();
        return view('reports.neonatal-summary.baby_list', compact('results', 'navigate', 'pagination', 'order', 'search', 'getTotal', 'status'));

    }

    /**
     * Display a admission listing to resource
     *
     * @param $request instance of I
     *
     */
    public function postnatalSublist($baby_id, Request $request)
    {
        $baby_id = \SiteHelpers::decrypt_id($baby_id);
        $admissionList = PostProblemDischargeSummary::getAdmissionList($baby_id);
        $navigate = $this->navigate;

        $babyName = '';

        if (isset($admissionList[0]) && isset($admissionList[0]->BabyName))
        {
            $babyName = $admissionList[0]->BabyName . ' - ' . $admissionList[0]->BMrNo;
        }

        return view('reports.neonatal-summary.admissionlist', compact('admissionList', 'babyName', 'navigate'));
    }

    /**
     * Disch
     *
     *
     */
    public function show($id, Request $request)
    {
        $id = \SiteHelpers::decrypt_id($id);
        $editor_gen_option = false;
        if (count(explode('-', $id)) == 2)
        {

            $babyid = explode('-', $id) [0];
            $admissionid = explode('-', $id) [1];

        }
        else
        {
            throw new InvalidInputException(\SiteHelpers::getUserExceptionMessage(7016) , 7016);
        }

        $headerContent = Settings::find(1);

        $backgorund = Baby::find($babyid);
        $postanatal_details = PostnatalDischarge::getPostanatalDischargeeDetails($babyid, $admissionid);
        // try
        // {
            if (count($postanatal_details) > 0) {
                $postanatal_details->diagnosis = (empty($postanatal_details->diagnosis)) ? $backgorund->Background : $postanatal_details->diagnosis;
            }
            

            
            $neonatalDetails = PostProblemDischargeSummary::getNewbornDetails($babyid);
            $postnatalDetails = PostProblemDischargeSummary::getAdmissionDetails($babyid, $admissionid);
            $problems = PostProblemDischargeSummary::getNeonatalProblems($babyid, $admissionid);

            $neonatalProblems = $problems->pluck('problem_name')
                ->unique();
            $mMedicalproblems = PostProblemDischargeSummary::getMotherMedicalProblems($babyid);
            $usgFinding = PostProblemDischargeSummary::getUsgFindings($babyid);
            $pregnancyComplications = PostProblemDischargeSummary::getMotherPregnancyComplications($babyid);
            $problems_ids = $problems->sortBy('problem_id')
                ->pluck('problem_id')
                ->unique()
                ->toArray();

            $episodes = array();
            foreach ($problems_ids as $problems_id)
            {

                $episodes[$problems_id] = $problems->where('problem_id', $problems_id)->sortBy('episode_id');

            }

            $doctor_master = DoctorMaster::ListData();

            $Vaccine = Vaccine::get()->pluck('Name', 'Id')
                ->toArray();

                
            $VaccineDetails = collect([unserialize($neonatalDetails->Vaccine) , collect(json_decode($postnatalDetails->vaccine))
                ->pluck('vaccine') ]);
            $VaccineDetails = $VaccineDetails->collapse()
                ->toArray();
            $VaccineDate = collect([unserialize($neonatalDetails->VaccineDate) , collect(json_decode($postnatalDetails->vaccine))
                ->pluck('vaccinedate') ]);
            $VaccineDate = $VaccineDate->collapse()
                ->toArray();
        
        $postnatalDetails->procedures = PostProblemDischargeSummary::getProcedureList($postnatalDetails->procedures);

            $discharge_medications = PostProblemDischargeSummary::getDischargeMedications($babyid, $admissionid, 1);

            $neonatalDetails->Indication = (isset($neonatalDetails->Indication) && !is_null($neonatalDetails->Indication)) ? json_decode($neonatalDetails->Indication) : null;

            foreach ($neonatalDetails as $key => & $value)
            {

                if ($value == '' && $key != 'G_Value' && $key != 'P_Value' && $key != 'L_Value' && $key != 'A_Value')
                {
                    $value = 'N/A';
                }
            }

            //echo '<pre>';print_r($neonatalDetails);exit;
            $postnatalDetails->vaccine = !is_null($postnatalDetails->vaccine) ? json_decode($postnatalDetails->vaccine) : null;
            foreach ($VaccineDetails as $key => $value)
            {

                if ($VaccineDetails[$key] == '' && $VaccineDate[$key] == '')
                {

                    unset($VaccineDetails[$key]);
                    unset($VaccineDate[$key]);
                }

            }
            $closewinlink = action('Reports\PostnatalDischargeSummary@index');

            $indicationMaster = Indication::getFieldvalue();

            $AntibioticMaster = AntibioticMaster::all()->pluck('Id', 'Name');

            $drug_master = DrugIvFluidMaster::ListData()->pluck('Name', 'Id')
                ->toArray();

            $editor_gen_option = $postanatal_details->edited_content == NULL ? 1 : 0;
            $editor_gen = false;
        // }
        // catch(\Exception $e)
        // {
        //     return back()->with('warning', 'Please fill baby details to see the summary');
        // }
        // $neonatalDetails->neonatal_consultant = \SiteHelpers::formating_consultant_signature($neonatalDetails->neonatal_consultant, false, $postnatalDetails->hospital_name, true);
        $neonatalDetails->neonatal_consultant = \ValuelistHelpers::signatureFormat($neonatalDetails->neonatal_consultant, 1);

        if (\Session::has('postnatal-summary-editor'))
        {
            \Session::forget('postnatal-summary-editor');
            $editor_gen = true;
            return view('reports.neonatal-summary.printsummary', compact('headerContent', 'postanatal_details', 'AntibioticMaster', 'closewinlink', 'indicationMaster', 'neonatalDetails', 'postnatalDetails', 'neonatalProblems', 'mMedicalproblems', 'usgFinding', 'pregnancyComplications', 'episodes', 'VaccineDetails', 'VaccineDate', 'Vaccine', 'discharge_medications', 'doctor_master', 'drug_master', 'backgorund', 'editor_gen', 'editor_gen_option'))->renderSections();
        }

        $old_print_sheet_count = PostnatalSummaryPrint::getPrintedContentCount($babyid, $admissionid);

        return view('reports.neonatal-summary.printsummary', compact('headerContent', 'postanatal_details', 'AntibioticMaster', 'closewinlink', 'indicationMaster', 'neonatalDetails', 'postnatalDetails', 'neonatalProblems', 'mMedicalproblems', 'usgFinding', 'pregnancyComplications', 'episodes', 'VaccineDetails', 'VaccineDate', 'Vaccine', 'discharge_medications', 'doctor_master', 'drug_master', 'backgorund', 'editor_gen_option', 'old_print_sheet_count'));
    }

    /**
     * OPEN REPORT WITH FULL EDITOR
     *
     */
    public function getfullEditor(Request $request)
    {
        $input = $request->all();
        \Session::put('postnatal-summary-editor', true);
        return \Response::json(['dataUrl' => $input['dataUrl']], 200);

    }

    /**
     * OPEN REPORT WITH FULL EDITOR
     *
     */
    public function saveFullEditor(Request $request)
    {

        // assign inputs to variable
        $input = $request->all();

        $post_report = PostnatalDischarge::where(['AdmissionId' => $input['admission_id'], 'BabyId' => $input['baby_id']])->first();

        $post_report->update(['edited' => true, 'edited_content' => $input['post_summary'], 'edited_time' => Carbon::now($this->time_zone) ]);

        // create slug for updated
        $post_id = \SiteHelpers::encrypt_id($input['baby_id'] . '-' . $input['admission_id']);

        if ($request->ajax())
        {
            return \Response::json(['type' => 'success', 'msg' => 'Record Updated Successfully']);
        }
        else
        {
            return redirect(action('Reports\PostnatalDischargeSummary@getAbbreviatedsummaryShow', $post_id))->with('success', 'Record updated successfully');
        }

    }

    public function getAbbreviatedsummaryShow(Request $request, $id)
    {

        $encryt_id = \SiteHelpers::decrypt_id($id);

        if (count(explode('-', $encryt_id)) == 2)
        {

            $baby_id = explode('-', $encryt_id) [0];
            $admission_id = explode('-', $encryt_id) [1];

        }
        else
        {
            throw new InvalidInputException(\SiteHelpers::getUserExceptionMessage(7016) , 7016);
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

        $post_report = PostnatalDischarge::where(['AdmissionId' => $admission_id, 'BabyId' => $baby_id])->first();

        \Session::put('postnatal-summary-editor', true);

        if (count($post_report) > 0 && !empty($post_report['edited_content']))
        {
            $discharge_details['content'] = $post_report['edited_content'];
        }
        else
        {
            $discharge_details = $this->show($id, $request);
        }

        $editor_gen = false;
        \Session::forget('postnatal-summary-editor');

        return view('reports.neonatal-summary.editor', compact('discharge_details', 'dischargeSummarymodified', 'dischage_summary'));
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $discharge_details = PostnatalDischarge::where(['BabyId' => $input['baby_id'], 'AdmissionId' => $input['admission_id']])->first();
        $input['newproblem'] = isset($input['editor_val']) ? serialize($input['editor_val']) : '';
        $input['DateModified'] = Carbon::now();
        $input['UserModified'] = \Auth::user()->id;

        $result = $discharge_details->update($input);

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
    }

    public function savePrintedContent(Request $request)
    {
        $input = $request->all();

        if (isset($input['baby_id'])) {
            $input['baby_id'] = $input['baby_id'];
        } else {
            return \Response::json(['message'=>'error'], 500);
        }

        if (isset($input['admission_id'])) {
            $input['admission_id'] = $input['admission_id'];
        } else {
            return \Response::json(['message'=>'error'], 500);
        }

        $input['printed_date_time'] = Carbon::now();
        $input['printed_user_id'] = \Auth::user()->id;

        PostnatalSummaryPrint::insert($input);

        return \Response::json(['message'=>'Success', 'massage_type'=>'Success'], 200);

    }

    public function getPrintedContent(Request $request)
    {
        $input = $request->all();

        $baby_id = $input['baby_id'];
        $admission_id = $input['admission_id'];
        $summary_approval = $this->auth->user()->summary_approval;
        $user_id = $this->auth->user()->id;

        $get_printed_content = PostnatalSummaryPrint::getPrintedContent($baby_id, $admission_id);

        return \Response::json(['get_printed_content'=>$get_printed_content, 'summary_approval'=>$summary_approval, 'user_id'=>$user_id]);

    }

    public function getPrintedHtmlContent(Request $request)
    {
        $input = $request->input('id');

        $results = PostnatalSummaryPrint::getPrintedHtmlContent($input);
        
        $get_printed_html_content = $results->summary_text;

        return \Response::json(['get_printed_html_content'=>$get_printed_html_content]);

    }

    public function summaryApproval(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];

        $old_results = PostnatalSummaryPrint::getPrintedHtmlContent($input);

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

        $results = PostnatalSummaryPrint::findorfail($id);
        $results->update($post);

        return \Response::json(['type'=>'success','msg' => 'Summary Approved Successfully']);

    }

}

