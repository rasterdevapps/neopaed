<?php
namespace App\Http\Controllers\Registration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Carbon\Carbon;
use App\Models\AutoCompleteWords;
use App\Models\Baby;
use App\Models\Mother;
use App\Models\Op;
use App\Models\Settings\Settings;
use App\Models\Settings\DeleteApproval;
use App\Models\DischargeSummary;
use App\Models\Postnatal;
use App\Models\Nicu;
use App\Models\NeuroEligibility;
use App\Models\NeuroVisit;
use App\Models\NeuroScreening;
use App\Models\NeuroMuscleToneNorms;
use App\Models\Masters\MchatquestionsMaster;
use App\Models\Masters\MchatquestionsfollowupMaster;
use App\Models\Masters\Mchatscreenings;
use App\Models\Masters\DasiiquestionsMaster;
use App\Models\Daycare;
use App\Models\PostDaycare;
use App\Models\Reports\ProblemDischarge;
use App\Models\Masters\CBCLquestionsMaster;
use App\Models\Icd;
use App\Models\Reports\PostProblemDischargeSummary;
use App\Models\FileUpload;
use App\Http\Controllers\Flow\FlowController;
use App\Models\Masters\BayleyScaleMaster;
use App\Models\BayleyScale;
use App\Models\BayleyScaleScore;
use App\Models\Issa;
use App\Models\Cars;
use App\Models\Masters\ISSAquestionsMaster;
use App\Http\Controllers\Errors\ErrorLogController;

class NeuroController extends Controller
{
	public function __construct(Guard $auth)
	{

		$this->middleware('role:NEURO_DEVELOPMENT,write', ['only' => ['store', 'update', 'edit', 'create', 'destory']]);
		$this->middleware('role:NEURO_DEVELOPMENT,read', ['only' => ['index', 'show']]);
		$this->time_zone = env('TIME_ZONE');
		$this->auth = $auth;
		$this->hnne_hine_interpretation_options = ['N/A', 'Normal response for the age', 'Normal response for the corrected age', 'Weak response for the age', 'Weak response for the corrected age', 'Mild weak response for the age', 'Mild weak response for the corrected age'];
		$this->m_chat_interpretation_options = ['N/A', 'No risk for ASD', 'Mild risk for ASD', 'High risk for ASD'];
		$this->dasii_interpretation_options = ['N/A', 'Normal Motor & Mental Development for the age', 'Normal Motor & Mental Development for the corrected age', 'Normal Motor & Delayed Mental Development for the age', 'Normal Motor & Delayed Mental Development for the corrected age', 'Normal Mental & Delayed Motor Development for the age', 'Normal Mental & Delayed Motor Development for the corrected age', 'Development Delay for the age', 'Development Delay for the corrected age'];
		$this->left_options = [0 => 'N/A', 1 => 'Pass', 2 => 'Refer'];
		$this->right_options = [0 => 'N/A', 1 => 'Pass', 2 => 'Refer'];
		$this->ddst_interpretation_result = [0 => 'Normal', 1 => 'Suspect', 2 => 'Untestable'];
		$this->ddst_interpretation_options = ['N/A', 'Normal development in all the domains for the age', 'Normal development in all the domains for the corrected age', 'Suspect for developmental delay in all the domains for the age', 'Suspect for developmental delay in all the domains for the corrected age', 'Suspect for developmental delay in gross motor domain and normal development in rest of the domains for the age', 'Suspect for developmental delay in gross motor domain and normal development in rest of the domains for the corrected age', 'Suspect for developmental delay in fine motor domain and normal development in the rest of the domains for the age', 'Suspect for developmental delay in fine motor domain and normal development in the rest of the domains for the corrected age', 'Suspect for developmental delay in language domain and normal development in the rest of the domains for the age', 'Suspect for developmental delay in language domain and normal development in the rest of the domains for the corrected age', 'Suspect for developmental delay in personal social domain and normal development in the rest of the domains for the age', 'Suspect for developmental delay in personal social domain and normal development in the rest of the domains for the corrected age', 'Suspect for developmental delay in gross and fine motor domains; normal development in the rest of the domains for the age', 'Suspect for developmental delay in gross and fine motor domains; normal development in the rest of the domains for the corrected age', 'Suspect for developmental delay in gross motor and language domains; normal development in the rest of the domains for the age', 'Suspect for developmental delay in gross motor and language domains; normal development in the rest of the domains for the corrected age', 'Suspect for developmental delay in gross motor and personal social domains; normal development in the rest of the domains for the age', 'Suspect for developmental delay in gross motor and personal social domains; normal development in the rest of the domains for the corrected age', 'Suspect for developmental delay in fine motor and language domains; normal development in the rest of the domains for the age', 'Suspect for developmental delay in fine motor and language domains; normal development in the rest of the domains for the corrected age', 'Suspect for developmental delay in fine motor and personal social domains; normal development in the rest of the domains for the age', 'Suspect for developmental delay in fine motor and personal social domains; normal development in the rest of the domains for the corrected age', 'Suspect for developmental delay in the language and personal social domains; normal development in the rest of the domains for the age', 'Suspect for developmental delay in the language and personal social domains; normal development in the rest of the domains for the corrected age', 'Untestable'];

		$this->posture_overall_score = 10;
		$this->tone_pattern_items_overall_score = 5;
		$this->reflex_items_overall_score = 6;
		$this->movements_overall_score = 3;
		$this->abnormal_signs_overall_score = 3;
		$this->behavioural_signs_overall_score = 7;
		$this->hnne_total_score = 34;

		$this->assessment_of_cranial_overall_score = 15;
		$this->assessment_of_posture_overall_score = 18;
		$this->assessment_of_movements_overall_score = 6;
		$this->assessment_of_tone_overall_score = 24;
		$this->reflexes_and_reactions_overall_score = 15;
		$this->section_2_motor_milestones_overall_score = 39;
		$this->behaviour_overall_score = 15;

		$this->default_bayley_seen_by = 48;
		$this->seen_by = [48, 52];

		$this->category = [1=>'Cognitive (CG)',2=>'Receptive Communication (RC)',3=>'Expressive Communication (EC)',4=>'Fine Motor (FM)',5=>'Gross Motor (GM)'];        
		
		$this->write_permission = session('write_permission');
		$this->custom_error = new ErrorLogController();

	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$limit = 50;
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
    	$order['sortby'] = 'id';
    	$order['sortorder'] = 'desc';

        //set the records sorting key and order
    	if (!empty($request->input('sortby')) && !empty($request->input('sortorder')))
    	{

    		$order['sortby'] = \SiteHelpers::decrypt_id($request->input('sortby'));
    		$order['sortorder'] = $request->input('sortorder');
    	}

    	$search = array();
    	$search['search_txt'] = '';
    	if (!empty($request->input('search_txt')))
    	{
    		$search['search_txt'] = $request->input('search_txt');
    	}

    	$navigate['main_nav'] = 'neuro';
    	$navigate['sub_nav'] = 'neuro';
    	$result = NeuroVisit::get_lists($request->input('page') , $limit, $search, $order, 1);
    	$results = $result['result'];
    	$getTotal = NeuroVisit::GetTotal();
    	$total = $result['total'];

    	$page = !empty($request->input('page')) ? $request->input('page') : 1;
    	$pagecount = (!empty($search['search_txt'])) ? ceil($total / $limit) : ceil($total / $limit);
    	$pagination['total'] = $total;
    	$pagination['start'] = (($page - 2) < 1) ? 1 : ($page - 2);
    	$pagination['end'] = ($pagecount < ($page + 3)) ? $pagecount : ($page + 3);
    	$pagestart = $total != 0 ? ($page <= 1) ? $page : ($page - 1) * $limit + 1 : 0;
    	$pagerecords = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page * $limit;
    	$pagination['limit'] = array($pagestart, $pagerecords);
    	$pagination['limits'] = $limit;
    	$pagination['previous'] = (($page - 1) < 1) ? 1 : ($page - 1);
    	$pagination['next'] = ($pagecount < ($page + 1)) ? $pagecount : ($page + 1);

    	$results = collect($results)->groupBy('visit_date')->toArray();

    	return view('registration.neuro.list', compact('results', 'navigate', 'pagination', 'search', 'getTotal', 'order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
    	$id = \SiteHelpers::decrypt_id($id);
    	$results = (object)[];
    	if (empty($id) && $id == 0)
    	{
    		$baby_detail = (object)[];
    	}
    	else
    	{
    		$temp_baby_detail = Baby::get_data($id)->groupBy('BabyId')->toArray();
    		ksort($temp_baby_detail);
    		$baby_detail = collect($temp_baby_detail)->first() [0];
    		$baby_detail->DOB = (!empty($baby_detail->DOB) && !is_null($baby_detail->DOB)) ? date('d-m-Y', strtotime($baby_detail->DOB)) : date('d-m-Y');

    		$mobile_number = '';
    		if ($baby_detail->Mobile != null && $baby_detail->Mobile != '') {
    			$mobile_number = $baby_detail->Mobile;
    		}
    		if ($baby_detail->LandLine != null && $baby_detail->LandLine != '')  {
    			if ($mobile_number == '') {
    				$mobile_number = $baby_detail->LandLine;
    			} else {
    				$mobile_number = $mobile_number . ',' . $baby_detail->LandLine ;
    			}
    		} 
    		if ($baby_detail->PartnerContact != null && $baby_detail->PartnerContact != '') {
    			if ($mobile_number == '') {
    				$mobile_number = $baby_detail->PartnerContact;
    			} else {
    				$mobile_number = $mobile_number . ',' . $baby_detail->PartnerContact;
    			}
    		}
    		if ($baby_detail->PartnerMobile != null && $baby_detail->PartnerMobile != '') {
    			if ($mobile_number == '') {
    				$mobile_number = $baby_detail->PartnerMobile;
    			} else {
    				$mobile_number = $mobile_number . ',' . $baby_detail->PartnerMobile;
    			}
    		}

    		$baby_detail->contact_no = $mobile_number;
    	}
    	$m_chat_questions = MchatquestionsMaster::getQuestions();
    	$m_chat_followup_questions = MchatquestionsfollowupMaster::getQuestions();
    	$current_date = date('d-m-Y');
    	$time = \SiteHelpers::prepare_time();
    	$current_time = [];
    	$current_time['hours'] = (int)date("h", strtotime(Carbon::now(env('TIME_ZONE'))));
    	$current_time['mins'] = (int)date("i", strtotime(Carbon::now(env('TIME_ZONE'))));
    	$current_time['am'] = date("A", strtotime(Carbon::now(env('TIME_ZONE'))));
    	$baby_detail->rop_pna_ca = $baby_detail->rop_right_hand_side = $baby_detail->rop_left_hand_side = $baby_detail->rop_remarks = 'N/A';
    	$baby_detail->hearing_screen_aabr_pna_ca = $baby_detail->hearing_screen_aabr_right_hand_side = $baby_detail->hearing_screen_aabr_left_hand_side = $baby_detail->hearing_screen_aabr_remarks = 'N/A';
    	$baby_detail->hearing_screen_oae_pna_ca = $baby_detail->hearing_screen_oae_right_hand_side = $baby_detail->hearing_screen_oae_left_hand_side = $baby_detail->hearing_screen_oae_remarks = 'N/A';
    	$baby_detail->diagnostic_abr_pna_ca = $baby_detail->diagnostic_abr_right_hand_side = $baby_detail->diagnostic_abr_left_hand_side = $baby_detail->diagnostic_abr_remarks = 'N/A';
    	$baby_detail->diagnostic_cpa_pna_ca = $baby_detail->diagnostic_cpa_right_hand_side = $baby_detail->diagnostic_cpa_left_hand_side = $baby_detail->diagnostic_cpa_remarks = 'N/A';
    	$hnne_hine_interpretation_options = $this->hnne_hine_interpretation_options;
    	$m_chat_interpretation_options = $this->m_chat_interpretation_options;
    	$dasii_interpretation_options = $this->dasii_interpretation_options;
    	$left_options = $this->left_options;
    	$right_options = $this->right_options;
    	$ddst_interpretation_result = $this->ddst_interpretation_result;
    	$ddst_interpretation_options = $this->ddst_interpretation_options;
    	$hnne_details = $hine_details = (object)[];
    	$baby_detail->review_time = 9;
    	$baby_detail->review_min = 30;
    	$baby_detail->review_session = 'AM';
    	$current_age = null;
    	$current_chart_age = null;
    	if (isset($baby_detail->g_weeks) && isset($baby_detail->g_days) && isset($baby_detail->DOB)) {
    		$DOB = date('Y-m-d', strtotime($baby_detail->DOB));
    		$OpDate = date('Y-m-d');
    		$current_age = \SiteHelpers::getChronologicalage($DOB, $OpDate);
    		if ($baby_detail->g_weeks < 37 && !empty($baby_detail->g_weeks)) {
    			$baby_corrected_age = \SiteHelpers::calculateCorrectedGestation($baby_detail->g_weeks, $baby_detail->g_days, $baby_detail->DOB, date('Y-m-d'));
    			$current_chart_age = $baby_corrected_age['corrected_age_weeks'];
    		}
    	} 

    	$ddst_setting = \DB::table('ddst_settings')->orderBy('id', 'asc')->get();

    	$ddst_settings = [];
    	$ddst_array = 0;
    	foreach ($ddst_setting as $value) {

    		$color = '#7ED2E5';
    		$fill = $value->fill == '#7ED2E5' ? $color : $value->fill;
    		$stroke = $value->stroke != null ? $color : $value->stroke;

    		$temp_settings['taskid'] = $value->task_id;
    		$temp_settings['task'] = $value->name;
    		$temp_settings['value'] = $value->x_value;
    		$temp_settings['endValue'] = $value->x_end_value;
    		$temp_settings['yvalue'] = $value->y_value;
    		$temp_settings['yendValue'] = $value->y_end_value;
    		$temp_settings['columnSettings'] =  ["fill" => $fill, "stroke" => $stroke];
    		$temp_settings['siblings'] = $value->siblings;
    		$temp_settings['nofill'] = $value->nofill;
    		$temp_settings['rowsize'] = $value->rowsize;
    		$temp_settings['rrposition'] = $value->rrposition;
    		$temp_settings['rbposition'] = $value->rbposition;
    		$temp_settings['countno'] = $value->countno;
    		$temp_settings['ctposition'] = $value->ctposition;
    		$temp_settings['crposition'] = $value->crposition;
    		$temp_settings['taskalign'] = $value->align;
    		$temp_settings['percentage'] = $value->percentage;
    		$temp_settings['percentage_align'] = $value->percentage_align;
    		$temp_settings['array_id'] = $ddst_array;

    		$ddst_settings[] = $temp_settings;
    		unset($temp_settings);
    		$ddst_array++;
    	}
    	$cbcl_question = CBCLquestionsMaster::list();

    	$mas_dasii_questions = DasiiquestionsMaster::getQuestions();
    	$dasii_motor_questions = $mas_dasii_questions->where('question_type', 'motor')->sortBy('question_number')->toArray();
    	$dasii_mental_questions = $mas_dasii_questions->where('question_type', 'mental')->sortBy('question_number')->toArray();

    	if (isset($baby_detail->BMrNo)) {
    		$baby_detail->baby_background = $this->getBabyBackgroundDetails($baby_detail->BMrNo)->original['baby_background'];
    		$previous_screening = NeuroScreening::getPreviousScreeningDetails($baby_detail->BabyId);
    		$previous_eligibility = $this->getPreviousEligibilityDetails($baby_detail->BMrNo);
    		$previous_eligibility = collect($previous_eligibility)->toArray();
    		$baby_detail = collect($baby_detail)->toArray();
    		$baby_detail = array_merge($baby_detail, $previous_eligibility);
    		$baby_detail = (object)$baby_detail;
    	}

    	$settings = Settings::find(1);
    	$dvs = $settings->hms_primary_consultant_id;
    	$rks = $settings->hms_secondary_consultant_id;
    	$neuro_consultant_id = $settings->hms_neuro_consultant_id;
    	$pvs = $settings->hms_neuro_secondary_consultant_id;

    	$bayley_master = BayleyScaleMaster::getData()->groupBy(['category', 'question_no'])->toArray();        
    	$doctor_master = \ValuelistHelpers::mas_doctors_list();

    	$baby_detail->examiner = $this->default_bayley_seen_by;

    	$results->seen_by = json_encode($this->seen_by);
    	$formatted_date = date('Y-m-d');
    	$baby_neuro_visit = NeuroVisit::where('baby_id',$id)->where('visit_date','<',$formatted_date)->orderBy('visit_date', 'desc')->first();
    	if ($baby_neuro_visit && isset($baby_neuro_visit->baby_background)) {
    		$results->baby_background = $baby_neuro_visit->baby_background;
    	}  elseif(isset($baby_detail->Background) && !empty($baby_detail->Background)) {
    		$results->baby_background = $baby_detail->Background;
    	}
    	$cc_infant_details = $cc_preschoolers_details = [];

        $issa_question = ISSAquestionsMaster::list()->groupBy('category')->toArray();

    	return view('registration.neuro.create', compact('m_chat_questions', 'baby_detail', 'm_chat_followup_questions', 'current_date', 'time', 'current_time', 'baby_background_details', 'id', 'hnne_hine_interpretation_options', 'm_chat_interpretation_options', 'dasii_interpretation_options', 'left_options', 'right_options', 'hnne_details', 'hine_details', 'ddst_interpretation_result', 'ddst_interpretation_options', 'current_age', 'current_chart_age', 'ddst_settings', 'cbcl_question', 'dasii_mental_questions', 'dasii_motor_questions', 'previous_screening', 'dvs', 'rks', 'bayley_master', 'doctor_master', 'results', 'neuro_consultant_id', 'pvs', 'cc_infant_details', 'cc_preschoolers_details', 'issa_question'));
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

    	$print_flag = isset($input['print_flag']) ? $input['print_flag'] : 0;
    	unset($input['print_flag']);

    	if (in_array('NEURO_DEVELOPMENT_BASIC',$this->write_permission)) {
    		$input['MotherName'] = (isset($input['MotherName']) && !empty($input['MotherName'])) ? $input['MotherName'] : null;
		    $input['DOB'] = (isset($input['DOB']) && !empty($input['DOB'])) ? date('Y-m-d', strtotime($input['DOB'])) : null;
		    $input['BirthStatus'] = (isset($input['BirthStatus']) && $input['BirthStatus'] == 'on') ? 'Inborn' : 'Outborn';
		    $input['g_weeks'] = (isset($input['g_weeks']) && !empty($input['g_weeks'])) ? $input['g_weeks'] : null;
		    $input['g_days'] = (isset($input['g_days']) && !empty($input['g_days'])) ? $input['g_days'] : null;
		}

    	if (isset($input['MotherId']) && $input['MotherId'] != '' && $input['MotherId'] != 0)
    	{
    		$input['UserModified'] = $this->auth->user()->id;
    		$input['DateModified'] = Carbon::now();
    		$mother = Mother::findOrfail($input['MotherId']);
    		$input['MotherId'] = $input['MotherId'];
    		$mother->update($input);
    	}
    	else
    	{
    		$input['PartnerName'] = isset($input['parter_name']) ? $input['parter_name'] : null;
    		$input['Mobile'] = isset($input['mobile']) ? $input['mobile'] : null;
    		$input['Address1'] = isset($input['address1']) ? $input['address1'] : null;
    		$input['Address2'] = isset($input['address2']) ? $input['address2'] : null;
    		$input['Address3'] = isset($input['city']) ? $input['city'] : null;
    		$input['Address4'] = isset($input['pincode']) ? $input['pincode'] : null;
    		$input['DateAdded'] = Carbon::now();
    		$input['UserAdded'] = $this->auth->user()->id;
    		$mother = Mother::create($input);
    		$input['MotherId'] = $mother->MotherId;
    	}

    	if (isset($input['BabyId']) && $input['BabyId'] != '' && $input['BabyId'] != 0)
    	{
    		$input['UserModified'] = $this->auth->user()->id;
    		$input['DateModified'] = Carbon::now();
    		$baby = Baby::findOrfail($input['BabyId']);
    		$baby->update($input);
    	}
    	else
    	{
    		$input['DateAdded'] = Carbon::now();
    		$input['UserAdded'] = $this->auth->user()->id;
    		$baby = Baby::create($input);
    		$input['BabyId'] = $baby->BabyId;
    	}

    	$baby_id = $input['baby_id'] = $input['BabyId'];

    	if (isset($input['visit_date'])) {
    		$visit_date = $input['visit_date'];
    	} else {
    		return \Response::json(['type' => 'error', 'message' => 'Neuro Development visit not found !'], 500);
    	}

    	if (in_array('NEURO_DEVELOPMENT_BASIC',$this->write_permission)) {
    		$neuro_visit_id = $this->storeNeuro($input, $baby_id);
    		$this->makeAppointment($input, $neuro_visit_id);
    		$this->storeEligibility($input, $baby_id, $neuro_visit_id, $visit_date);
    		$this->storeScreening($input, $baby_id, $neuro_visit_id, $visit_date);
    		$this->storeMuscleTone($input, $baby_id, $neuro_visit_id, $visit_date);
    	}
    	if (in_array('SCREENING_HNNE',$this->write_permission)) {
    		$this->storeHnneDetails($input, $neuro_visit_id, $visit_date);
    	}
    	if (in_array('SCREENING_HINE',$this->write_permission)) {
    		$this->storeHineDetails($input, $neuro_visit_id, $visit_date);
    	}
    	if (in_array('SCREENING_M_CHAT',$this->write_permission)) {
    		$this->storeMChatAnswers($input, $neuro_visit_id);
    		$this->storeMChatFollowUpAnswers($input, $neuro_visit_id);
    	}
    	if (in_array('SCREENING_DASII',$this->write_permission)) {
    		$this->storeDasiiMentalScale($input, $neuro_visit_id);
    		$this->storeDasiiMotorScale($input, $neuro_visit_id);
    	}
    	if (in_array('SCREENING_DDST',$this->write_permission)) {
    		$this->storeDdst($input, $neuro_visit_id);
    	}
    	if (in_array('SCREENING_CBCL',$this->write_permission)) {
    		$this->storeCbcl($input, $neuro_visit_id);
    	}
    	if (in_array('SCREENING_BAYLEY',$this->write_permission)) {
    		$this->storeBayley($input, $neuro_visit_id);
    	}
    	if (in_array('SCREENING_ISSA',$this->write_permission)) {
    		$this->storeIssa($input, $neuro_visit_id);
    	}
    	if (in_array('SCREENING_CARS',$this->write_permission)) {
    		$this->storeCars($input, $neuro_visit_id);
    	}
    	if (in_array('SCREENING_INFANTS',$this->write_permission)) {
    		$this->storeInfants($input, $neuro_visit_id, $visit_date);
    	}
    	if (in_array('SCREENING_PRESCHOOLERS',$this->write_permission)) {
    		$this->storePreschoolers($input, $neuro_visit_id, $visit_date);
    	}
    	if (in_array('SCREENING_PEP3',$this->write_permission)) {
    		$this->storePep3($input, $neuro_visit_id);
    	}
    	if ($request->ajax())
    	{
    		return \Response::json(['type' => 'success', 'message' => 'Record updated successfully !', 'edit_url' => action('Registration\NeuroController@edit', \SiteHelpers::encrypt_id($neuro_visit_id)) , 'list_url' => action('Registration\NeuroController@index')], 200);
    	}
    	if ($print_flag == 1)
    	{
    		if ($input['current_tab'] != '') {
    			setcookie('current_tab', $input['current_tab'], 0, '/');
    		}
    		return redirect(action('Registration\NeuroController@edit', \SiteHelpers::encrypt_id($neuro_visit_id)))->with('Success', 'Record saved successfully !');
    	}
    	elseif ($print_flag == 2)
    	{
    		return redirect(action('Registration\NeuroController@index'))->with('Success', 'Record saved successfully !');
    	}
    	elseif ($print_flag == 4)
    	{
    		return redirect(action('Registration\NeuroController@index'));
    	}

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
    	$id = \SiteHelpers::decrypt_id($id);

    	$visit_details = NeuroVisit::findorfail($id)->toArray();

    	$baby_detail = Baby::findOrfail($visit_details['baby_id'])->toArray();

        // Eligibility for enrolment in HRC
    	$neuro_eligibility_result = collect(NeuroEligibility::getNeuroEligibilityData($id))->toArray();
        // Screening
    	$neuro_screening_result = collect(NeuroScreening::getPreviousScreeningDetails($visit_details['baby_id'], $id, true))->toArray();
    	$neuro_muscle_tone_norms_result = collect(NeuroMuscleToneNorms::getNeuroMuscleToneNormsData($id))->toArray();
    	$temp_neuro_muscle_tone_norms_result = $neuro_muscle_tone_norms_result;

    	unset($temp_neuro_muscle_tone_norms_result['id']);
    	unset($temp_neuro_muscle_tone_norms_result['baby_id']);
    	unset($temp_neuro_muscle_tone_norms_result['neuro_visit_id']);
    	unset($temp_neuro_muscle_tone_norms_result['visit_date']);
    	unset($temp_neuro_muscle_tone_norms_result['age']);
    	unset($temp_neuro_muscle_tone_norms_result['created_date_time']);
    	unset($temp_neuro_muscle_tone_norms_result['created_user']);
    	unset($temp_neuro_muscle_tone_norms_result['modified_date_time']);
    	unset($temp_neuro_muscle_tone_norms_result['is_deleted']);
    	unset($temp_neuro_muscle_tone_norms_result['deleted_user']);
    	unset($temp_neuro_muscle_tone_norms_result['modified_user']);
    	unset($temp_neuro_muscle_tone_norms_result['deleted_date_time']);
    	unset($temp_neuro_muscle_tone_norms_result['neuro_muscle_tone_norms_id']);

    	$param_count = 1;
    	$muscle_tone_norms_display_status = false;

    	array_walk($temp_neuro_muscle_tone_norms_result, function($item, $value) use ($temp_neuro_muscle_tone_norms_result, &$param_count, &$muscle_tone_norms_display_status) {

    		$range = preg_replace('/[a-z_]/', '',$value);

    		if ($value != 'date_of_assessment_0_3' && $value != 'pna_ca_assessment_0_3' && $temp_neuro_muscle_tone_norms_result['date_of_assessment_0_3'] != '' && $temp_neuro_muscle_tone_norms_result['pna_ca_assessment_0_3'] != '' && ($range == 03 && $item != 0) && $item != '' && $item != null) {
    			$muscle_tone_norms_display_status = true;
    			return $muscle_tone_norms_display_status;
    		}

    		if ($value != 'date_of_assessment_4_6' && $value != 'pna_ca_assessment_4_6' && $temp_neuro_muscle_tone_norms_result['date_of_assessment_4_6'] != '' && $temp_neuro_muscle_tone_norms_result['pna_ca_assessment_4_6'] != '' && ($range == 46 && $item != 0) && $item != '' && $item != null) {
    			$muscle_tone_norms_display_status = true;
    			return $muscle_tone_norms_display_status;
    		}

    		if ($value != 'date_of_assessment_7_9' && $value != 'pna_ca_assessment_7_9' && $temp_neuro_muscle_tone_norms_result['date_of_assessment_7_9'] != '' && $temp_neuro_muscle_tone_norms_result['pna_ca_assessment_7_9'] != '' && ($range == 79 && $item != 0) && $item != '' && $item != null) {
    			$muscle_tone_norms_display_status = true;
    			return $muscle_tone_norms_display_status;
    		}

    		if ($value != 'date_of_assessment_10_12' && $value != 'pna_ca_assessment_10_12' && $temp_neuro_muscle_tone_norms_result['date_of_assessment_10_12'] != '' && $temp_neuro_muscle_tone_norms_result['pna_ca_assessment_10_12'] != '' && ($range == 1012 && $item != 0) && $item != '' && $item != null) {
    			$muscle_tone_norms_display_status = true;
    			return $muscle_tone_norms_display_status;
    		}

    		if ($param_count == count($temp_neuro_muscle_tone_norms_result)) {
    			$muscle_tone_norms_display_status = false;
    			return $muscle_tone_norms_display_status;
    		}
    		$param_count++;

    	});

    	$visit_details['review_time'] = strlen($visit_details['review_time']) > 1 ? $visit_details['review_time'] : '0' . $visit_details['review_time'];
    	$visit_details['review_min'] = strlen($visit_details['review_min']) > 1 ? $visit_details['review_min'] : '0' . $visit_details['review_min'];
    	$results = array_merge($baby_detail, $visit_details, $neuro_eligibility_result, $neuro_muscle_tone_norms_result);
    	$results = (object)$results;

    	$results->rop_options = isset($results->rop_options) && !empty($results->rop_options) ? json_decode($results->rop_options) : array();
    	$results->hearing_screen_options = isset($results->hearing_screen_options) && !empty($results->hearing_screen_options) ? json_decode($results->hearing_screen_options) : array();
    	$results->diagnostic_abr_options = isset($results->diagnostic_abr_options) && !empty($results->diagnostic_abr_options) ? json_decode($results->diagnostic_abr_options) : array();
    	$results->head_test = isset($results->head_test) && !empty($results->head_test) ? json_decode($results->head_test) : array();
    	$headerContent = Settings::findorfail(1);

    	$hnne = \DB::table('hnne_details')->where('neuro_visit_id', $id)->first();
    	$hnne_value = isset($hnne->total_hnne_score) ? $hnne->total_hnne_score : '0-W';
    	$hnne_value = explode('-', $hnne_value);
    	$results->hnne = isset($hnne_value[0]) ? $hnne_value[0] : null;
    	$results->hnne_reponse = isset($hnne_value[1]) ? $hnne_value[1] : null;

    	if (is_object($hnne)) {

    		$hnne->posture = isset($hnne->posture) ? array_sum(array_filter(json_decode($hnne->posture))) : 0;

    		$hnne->tone_pattern_items = isset($hnne->tone_pattern_items) ? array_sum(array_filter(json_decode($hnne->tone_pattern_items))) : 0;

    		$hnne->reflex_items = isset($hnne->reflex_items) ? array_sum(array_filter(json_decode($hnne->reflex_items))) : 0;

    		$hnne->movements = isset($hnne->movements) ? array_sum(array_filter(json_decode($hnne->movements))) : 0;

    		$hnne->abnormal_signs = isset($hnne->abnormal_signs) ? array_sum(array_filter(json_decode($hnne->abnormal_signs))) : 0;

    		$hnne->behavioural_signs = isset($hnne->behavioural_signs) ? array_sum(array_filter(json_decode($hnne->behavioural_signs))) : 0;

    	}

    	$hine = \DB::table('hine_details')->where('neuro_visit_id', $id)->first();
    	$hine_value = isset($hine->total_hine_score) ? $hine->total_hine_score : '0-W';
    	$hine_value = explode('-', $hine_value);
    	$results->hine = isset($hine_value[0]) ? $hine_value[0] : null;
    	$results->hine_reponse = isset($hine_value[1]) ? $hine_value[1] : null;

    	if (is_object($hine)) {

    		$hine->assessment_of_cranial = isset($hine->assessment_of_cranial) ? array_sum(array_filter(json_decode($hine->assessment_of_cranial))) : 0;

    		$hine->assessment_of_posture = isset($hine->assessment_of_posture) ? array_sum(array_filter(json_decode($hine->assessment_of_posture))) : 0;

    		$hine->assessment_of_movements = isset($hine->assessment_of_movements) ? array_sum(array_filter(json_decode($hine->assessment_of_movements))) : 0;

    		$hine->assessment_of_tone = isset($hine->assessment_of_tone) ? array_sum(array_filter(json_decode($hine->assessment_of_tone))) : 0;

    		$hine->reflexes_and_reactions = isset($hine->reflexes_and_reactions) ? array_sum(array_filter(json_decode($hine->reflexes_and_reactions))) : 0;

    		$hine->section_2_motor_milestones = isset($hine->section_2_motor_milestones) ? array_sum(array_filter(json_decode($hine->section_2_motor_milestones))) : 0;

    		$hine->behaviour = isset($hine->behaviour) ? array_sum(array_filter(json_decode($hine->behaviour))) : 0;

    	}

    	if ($request->get('closewinlink') == 'list-view') {
    		$closewinlink = action('Registration\NeuroController@NeuroSubList', \SiteHelpers::encrypt_id($results->BabyId));
    	} elseif ($request->get('closewinlink') == 'neonatal-op-list-view') {
    		$closewinlink = action('Registration\OpController@OpsubList', \SiteHelpers::encrypt_id($results->baby_id));
    	} else {
    		$closewinlink = action('Registration\NeuroController@edit', \SiteHelpers::encrypt_id($id));            
    	}

    	$results->Gestation = \SiteHelpers::decode_gestation($results->Gestation);

    	$m_chat_results = Op::getMChatResultsByVisit($id)->where('type', false);
    	$m_chat_results_found = count($m_chat_results);

    	if ($m_chat_results_found) {
    		$m_chat_results_type_1 = $m_chat_results->where('answer', 'No')->whereNotIn('question_id', [2, 5, 12])->count();
    		$m_chat_results_type_2 = $m_chat_results->where('answer', 'Yes')->whereIn('question_id', [2, 5, 12])->count();

    		$m_chat_score = $m_chat_results_type_1 + $m_chat_results_type_2;
    	}

    	$m_chat_f_results = Op::getMChatResultsByVisit($id)->where('question_id', '>=', 1)->where('question_id', '<=', 20)->where('type', true);
    	$m_chat_f_results_found = count($m_chat_f_results);
    	if ($m_chat_f_results_found) {
    		$m_chat_f_results_type_1 = $m_chat_f_results->whereNotIn('question_id', [2, 5, 12])->where('final_answer', 1)->count();
    		$m_chat_f_results_type_2 = $m_chat_f_results->whereIn('question_id', [2, 5, 12])->where('final_answer', 0)->count();

    		$m_chat_f_score = $m_chat_f_results_type_1 + $m_chat_f_results_type_2;
    	}

    	$posture_overall_score = $this->posture_overall_score;
    	$tone_pattern_items_overall_score = $this->tone_pattern_items_overall_score;
    	$reflex_items_overall_score = $this->reflex_items_overall_score;
    	$movements_overall_score = $this->movements_overall_score;
    	$abnormal_signs_overall_score = $this->abnormal_signs_overall_score;
    	$behavioural_signs_overall_score = $this->behavioural_signs_overall_score;
    	$hnne_total_score = $this->hnne_total_score;

    	$assessment_of_cranial_overall_score = $this->assessment_of_cranial_overall_score;
    	$assessment_of_posture_overall_score = $this->assessment_of_posture_overall_score;
    	$assessment_of_movements_overall_score = $this->assessment_of_movements_overall_score;
    	$assessment_of_tone_overall_score = $this->assessment_of_tone_overall_score;
    	$reflexes_and_reactions_overall_score = $this->reflexes_and_reactions_overall_score;
    	$section_2_motor_milestones_overall_score = $this->section_2_motor_milestones_overall_score;
    	$behaviour_overall_score = $this->behaviour_overall_score;

    	$hnne_hine_interpretation_options = $this->hnne_hine_interpretation_options;
    	$m_chat_interpretation_options = $this->m_chat_interpretation_options;
    	$dasii_interpretation_options = $this->dasii_interpretation_options;
    	$left_options = $this->left_options;
    	$right_options = $this->right_options;
    	$ddst_interpretation_result = $this->ddst_interpretation_result;
    	$ddst_interpretation_options = $this->ddst_interpretation_options;

    	$cbcl_question = CBCLquestionsMaster::list();

    	$cbcl_result = \DB::table('neuro_cbcl_screening')->where('neuro_visit_id', $id)->get()->keyBy('question_id');

    	$bayley_result = BayleyScale::getVisit($id);

    	$zero_list[1] = [];
    	$zero_list[2] = [];
    	$zero_list[3] = [];
    	$zero_list[4] = [];
    	$zero_list[5] = [];

        // $mas_list = BayleyScaleMaster::getData()->where('score', 2)->groupBy('category')->map(function($list) {
        //     return $list->pluck('title', 'question_no');
        // })
        // ->toArray();

        // $results_score_0 = array();
        // if (isset($bayley_result->id)) {
        //     $results_score_0 = BayleyScaleScore::getPassData($bayley_result->id, 0)->groupBy('category_id')->map(function($list) use (&$zero_list, $mas_list) {
        //         return $list->pluck('item', 'question_id');
        //     })
        //     ->toArray();
        // }

    	$category_options = $this->category;

    	$issa_result = Issa::where('neuro_visit_id', $id)->orderBy('id', 'desc')->first();

    	$cars_result = Cars::where('neuro_visit_id', $id)->orderBy('id', 'desc')->first();

    	$neuro_consultant_id = $headerContent->hms_neuro_consultant_id;
    	$pvs = $headerContent->hms_neuro_secondary_consultant_id;
    	$cc_infant_results = \DB::table('carolina_infants_details')->where('neuro_visit_id', $id)->first();
    	$cc_preschoolers_results = \DB::table('carolina_preschoolers_details')->where('neuro_visit_id', $id)->first();

    	$pep_result = \DB::table('neuro_pep')->where('neuro_visit_id', $id)->first();

    	return view('registration.neuro.print', compact('neuro_developmental_report', 'baby_detail', 'headerContent', 'results', 'closewinlink', 'm_chat_score', 'sign', 'posture_overall_score', 'tone_pattern_items_overall_score', 'reflex_items_overall_score', 'movements_overall_score', 'abnormal_signs_overall_score', 'behavioural_signs_overall_score', 'assessment_of_cranial_overall_score', 'assessment_of_posture_overall_score', 'assessment_of_movements_overall_score', 'assessment_of_tone_overall_score', 'reflexes_and_reactions_overall_score', 'section_2_motor_milestones_overall_score', 'behaviour_overall_score', 'hnne', 'hine', 'm_chat_f_score', 'hnne_hine_interpretation_options', 'm_chat_interpretation_options', 'dasii_interpretation_options', 'left_options', 'right_options', 'ddst_interpretation_options', 'ddst_interpretation_result', 'muscle_tone_norms_display_status', 'cbcl_question', 'cbcl_result', 'neuro_screening_result', 'hnne_total_score', 'bayley_result', 'category_options', 'issa_result', 'cars_result', 'neuro_consultant_id', 'cc_infant_results', 'cc_preschoolers_results', 'pvs', 'pep_result'));
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

    	$results = NeuroVisit::getVisit($id);
    	$baby_id = $results->baby_id;

    	if (isset($results->DOB) && !empty($results->DOB) && !is_null($results->DOB))
    	{
    		$results->DOB = date('d-m-Y', strtotime($results->DOB));
    	}

    	if (isset($results->review) && !empty($results->review) && !is_null($results->review))
    	{
    		$results->review = date('d-m-Y', strtotime($results->review));
    	}

    	$visit_date = $results->visit_date;

        // Eligibility for enrolment in HRC
    	$neuro_eligibility_result = NeuroEligibility::getNeuroEligibilityData($id);
    	$neuro_eligibility_result = collect($neuro_eligibility_result)->toArray();

        // Screening
    	$neuro_screening_result = NeuroScreening::getNeuroScreeningData($id);
    	$neuro_screening_result = collect($neuro_screening_result)->toArray();

    	$neuro_screening_result['rop_options'] = isset($neuro_screening_result['rop_options']) ? json_decode($neuro_screening_result['rop_options']) : [];
    	$neuro_screening_result['hearing_screen_options'] = isset($neuro_screening_result['hearing_screen_options']) ? json_decode($neuro_screening_result['hearing_screen_options']) : [];
    	$neuro_screening_result['diagnostic_abr_options'] = isset($neuro_screening_result['diagnostic_abr_options']) ? json_decode($neuro_screening_result['diagnostic_abr_options']) : [];
    	$neuro_screening_result['head_test'] = isset($neuro_screening_result['head_test']) ? json_decode($neuro_screening_result['head_test']) : [];

        // Muscle tone norms
    	$neuro_muscle_tone_norms_result = NeuroMuscleToneNorms::getNeuroMuscleToneNormsData($id);
    	$neuro_muscle_tone_norms_result = collect($neuro_muscle_tone_norms_result)->toArray();

    	$neuro_developmental_details = Op::getNeuroDevelopmentalReport($id);

    	$hnne_details = (object)[];
    	$result_hnne_details = \DB::table('hnne_details')->where('neuro_visit_id', $id)->first();
    	if (isset($result_hnne_details->id)) {
    		$hnne_details = $result_hnne_details;
    	}

    	$hine_details = (object)[];
    	$result_hine_details = \DB::table('hine_details')->where('neuro_visit_id', $id)->first();
    	if (isset($result_hine_details->id)) {
    		$hine_details = $result_hine_details;
    	}

    	$result_mental_motor_details = \DB::table('dasii_mental_motor_screening')->where('neuro_visit_id', $id)->get()->groupby('type')->toArray();

    	if (isset($result_mental_motor_details[1])) {
    		$results['mentalanswer'] = collect($result_mental_motor_details[1])->pluck('answer', 'question_id');
    	}
    	if (isset($result_mental_motor_details[2])) {
    		$results['motoranswer'] = collect($result_mental_motor_details[2])->pluck('answer', 'question_id');
    	}

    	$m_chat_questions = MchatquestionsMaster::getQuestions();
    	$m_chat_followup_questions = MchatquestionsfollowupMaster::getQuestions();
    	$m_chat_results = Op::getMChatResultsByVisit($id)->where('type', false)->pluck('answer', 'question_id')->toArray();
    	$m_chat_followup_results = Op::getMChatResultsByVisit($id)->where('type', true)->pluck('answer', 'question_id')->toArray();
    	$m_chat_followup_results_description = Op::getMChatResultsByVisit($id)->where('type', true)->pluck('description', 'question_id')->toArray();
    	$m_chat_followup_results_final_answer = Op::getMChatResultsByVisit($id)->where('type', true)->pluck('final_answer', 'question_id')->toArray();

        // Bayley
    	$bayley_result = BayleyScale::getVisit($id);
    	$bayley_result = collect($bayley_result)->toArray();

    	$results->neuro_visit_date = isset($results->visit_date) ? $results->visit_date : null;

    	$temp_results = collect($results)->toArray();

        //ISSA
    	$issa_result = Issa::where('neuro_visit_id', $id)->orderBy('id', 'desc')->first();
    	$issa_result = collect($issa_result)->toArray();


        //CARS
    	$cars_result = Cars::where('neuro_visit_id', $id)->orderBy('id', 'desc')->first();
    	$cars_result = collect($cars_result)->toArray();
    	if (isset($cars_result['total']) && isset($cars_result['status'])) {
    		$cars_result['cars_total'] = $cars_result['total'];
    		$cars_result['cars_status'] = $cars_result['status'];
    	}

        //PEP 3
    	$pep_result = \DB::table('neuro_pep')->where('neuro_visit_id', $id)->orderBy('id', 'desc')->first();
    	$pep_result = collect($pep_result)->toArray();

    	$results = array_merge($temp_results, $neuro_eligibility_result, $neuro_screening_result, $neuro_muscle_tone_norms_result, $bayley_result, $issa_result, $cars_result, $pep_result);

    	$results = (object)$results;

    	$results->visit_date = isset($results->neuro_visit_date) ? $results->neuro_visit_date : null;

    	if (isset($results->visit_date) && !empty($results->visit_date))
    	{
    		$results->visit_date = date('d-m-Y', strtotime($results->visit_date));
    	}
    	else
    	{
    		$results->visit_date = '';
    	}
    	$time = \SiteHelpers::prepare_time();

    	$ddst_setting = \DB::table('ddst_settings')->orderBy('id', 'asc')->get();

    	$ddst_settings = [];
    	$ddst_array = 0;

    	$ddst_result = \DB::table('ddst_details')->where('neuro_visit_id', $id)->pluck('status', 'task_id');
    	foreach ($ddst_setting as $value) {

    		$color = '#7ED2E5';

    		if (isset($ddst_result[$value->task_id])) {
    			if ($ddst_result[$value->task_id] == 1) {
    				$color = '#47a447';
    			} elseif ($ddst_result[$value->task_id] == 2) {
    				$color = '#d2322d';
    			} elseif ($ddst_result[$value->task_id] == 3) {
    				$color = '#3968c6';
    			} elseif ($ddst_result[$value->task_id] == 4) {
    				$color = '#ed9c28';
    			}
    		}

    		$fill = $value->fill == '#7ED2E5' ? $color : $value->fill;
    		$stroke = $value->stroke != null ? $color : $value->stroke;

    		$temp_settings['taskid'] = $value->task_id;
    		$temp_settings['task'] = $value->name;
    		$temp_settings['value'] = $value->x_value;
    		$temp_settings['endValue'] = $value->x_end_value;
    		$temp_settings['yvalue'] = $value->y_value;
    		$temp_settings['yendValue'] = $value->y_end_value;
    		$temp_settings['columnSettings'] =  ["fill" => $fill, "stroke" => $stroke];
    		$temp_settings['siblings'] = $value->siblings;
    		$temp_settings['nofill'] = $value->nofill;
    		$temp_settings['rowsize'] = $value->rowsize;
    		$temp_settings['rrposition'] = $value->rrposition;
    		$temp_settings['rbposition'] = $value->rbposition;
    		$temp_settings['countno'] = $value->countno;
    		$temp_settings['ctposition'] = $value->ctposition;
    		$temp_settings['crposition'] = $value->crposition;
    		$temp_settings['taskalign'] = $value->align;
    		$temp_settings['percentage'] = $value->percentage;
    		$temp_settings['percentage_align'] = $value->percentage_align;
    		$temp_settings['array_id'] = $ddst_array;

    		$ddst_settings[] = $temp_settings;
    		unset($temp_settings);
    		$ddst_array++;
    	}

    	$hnne_hine_interpretation_options = $this->hnne_hine_interpretation_options;
    	$m_chat_interpretation_options = $this->m_chat_interpretation_options;
    	$dasii_interpretation_options = $this->dasii_interpretation_options;
    	if (!is_numeric($results->dasii_interpretation)) {
    		$dasii_interpretation_options = array_merge($dasii_interpretation_options, [$results->dasii_interpretation => $results->dasii_interpretation]);
    	}

    	$left_options = $this->left_options;
    	$right_options = $this->right_options;
    	$ddst_interpretation_result = $this->ddst_interpretation_result;
    	$ddst_interpretation_options = $this->ddst_interpretation_options;

    	$DOB = date('Y-m-d', strtotime($results->DOB));
    	$OpDate = date('Y-m-d', strtotime($results->visit_date));
    	$current_age = \SiteHelpers::getChronologicalage($DOB, $OpDate);
    	$current_chart_age = 0;
    	if ($results->g_weeks < 37 && !empty($results->g_weeks))
    	{
    		$baby_corrected_age = \SiteHelpers::calculateCorrectedGestation($results->g_weeks, $results->g_days, $results->DOB, $results->visit_date);
    		$current_chart_age = $baby_corrected_age['corrected_age_weeks'];
    	}

    	$active_tab = (isset($_COOKIE['current_tab']) && !empty($_COOKIE['current_tab'])) ? $_COOKIE['current_tab'] : '#babyform';
    	unset($_COOKIE['current_tab']);
    	setcookie("current_tab", "", 0, "/");

    	$mas_dasii_questions = DasiiquestionsMaster::getQuestions();
    	$dasii_motor_questions = $mas_dasii_questions->where('question_type', 'motor')->sortBy('question_number')->toArray();
    	$dasii_mental_questions = $mas_dasii_questions->where('question_type', 'mental')->sortBy('question_number')->toArray();

    	$mental_cluster = \DB::table('mas_cluster_percentiles')->where('scale_type', 1)->orderBy('id', 'desc')->get()->groupBy('month');
    	$motor_cluster = \DB::table('mas_cluster_percentiles')->where('scale_type', 2)->orderBy('id', 'desc')->get()->groupBy('month');

    	$cbcl_question = CBCLquestionsMaster::list();

    	$cbcl_result = \DB::table('neuro_cbcl_screening')->where('neuro_visit_id', $id)->get()->keyBy('question_id');

    	$previous_screening = NeuroScreening::getPreviousScreeningDetails($baby_id, $id);

    	$settings = Settings::find(1);
    	$dvs = $settings->hms_primary_consultant_id;
    	$rks = $settings->hms_secondary_consultant_id;
    	$neuro_consultant_id = $settings->hms_neuro_consultant_id;
    	$pvs = $settings->hms_neuro_secondary_consultant_id;

        // Bayley
    	$bayley_master = BayleyScaleMaster::getData()->groupBy(['category', 'question_no'])->toArray();  

    	$sub_results = BayleyScaleScore::getData($id);

    	$table_id_score_cg = $sub_results->where('category_id', 1)->where('type', 1)->pluck('question_id', 'id');
    	$table_id_score_rc = $sub_results->where('category_id', 2)->where('type', 1)->pluck('question_id', 'id');
    	$table_id_score_ec = $sub_results->where('category_id', 3)->where('type', 1)->pluck('question_id', 'id');
    	$table_id_score_fm = $sub_results->where('category_id', 4)->where('type', 1)->pluck('question_id', 'id');
    	$table_id_score_gm = $sub_results->where('category_id', 5)->where('type', 1)->pluck('question_id', 'id');
    	$table_id_score_se = $sub_results->where('category_id', 6)->where('type', 1)->pluck('question_id', 'id');

    	$table_id_score_ab_r = $sub_results->where('category_id', 7)->where('type', 1)->pluck('question_id', 'id');
    	$table_id_score_ab_e = $sub_results->where('category_id', 8)->where('type', 1)->pluck('question_id', 'id');
    	$table_id_score_ab_p = $sub_results->where('category_id', 9)->where('type', 1)->pluck('question_id', 'id');
    	$table_id_score_ab_ir = $sub_results->where('category_id', 10)->where('type', 1)->pluck('question_id', 'id');
    	$table_id_score_ab_pl = $sub_results->where('category_id', 11)->where('type', 1)->pluck('question_id', 'id');

    	$score_sub_id_cg = $sub_results->where('category_id', 1)->where('type', 1)->pluck('sub_question_id', 'question_id');
    	$score_sub_id_rc = $sub_results->where('category_id', 2)->where('type', 1)->pluck('sub_question_id', 'question_id');
    	$score_sub_id_ec = $sub_results->where('category_id', 3)->where('type', 1)->pluck('sub_question_id', 'question_id');
    	$score_sub_id_fm = $sub_results->where('category_id', 4)->where('type', 1)->pluck('sub_question_id', 'question_id');
    	$score_sub_id_gm = $sub_results->where('category_id', 5)->where('type', 1)->pluck('sub_question_id', 'question_id');
    	$score_sub_id_se = $sub_results->where('category_id', 6)->where('type', 1)->pluck('sub_question_id', 'question_id');

    	$score_sub_id_ab_r = $sub_results->where('category_id', 7)->where('type', 1)->pluck('sub_question_id', 'question_id');
    	$score_sub_id_ab_e = $sub_results->where('category_id', 8)->where('type', 1)->pluck('sub_question_id', 'question_id');
    	$score_sub_id_ab_p = $sub_results->where('category_id', 9)->where('type', 1)->pluck('sub_question_id', 'question_id');
    	$score_sub_id_ab_ir = $sub_results->where('category_id', 10)->where('type', 1)->pluck('sub_question_id', 'question_id');
    	$score_sub_id_ab_pl = $sub_results->where('category_id', 11)->where('type', 1)->pluck('sub_question_id', 'question_id');

    	$score_cg = $sub_results->where('category_id', 1)->where('type', 1)->pluck('value', 'question_id');
    	$score_rc = $sub_results->where('category_id', 2)->where('type', 1)->pluck('value', 'question_id');
    	$score_ec = $sub_results->where('category_id', 3)->where('type', 1)->pluck('value', 'question_id');
    	$score_fm = $sub_results->where('category_id', 4)->where('type', 1)->pluck('value', 'question_id');
    	$score_gm = $sub_results->where('category_id', 5)->where('type', 1)->pluck('value', 'question_id');
    	$score_se = $sub_results->where('category_id', 6)->where('type', 1)->pluck('value', 'question_id');

    	$score_ab_r = $sub_results->where('category_id', 7)->where('type', 1)->pluck('value', 'question_id');
    	$score_ab_e = $sub_results->where('category_id', 8)->where('type', 1)->pluck('value', 'question_id');
    	$score_ab_p = $sub_results->where('category_id', 9)->where('type', 1)->pluck('value', 'question_id');
    	$score_ab_ir = $sub_results->where('category_id', 10)->where('type', 1)->pluck('value', 'question_id');
    	$score_ab_pl = $sub_results->where('category_id', 11)->where('type', 1)->pluck('value', 'question_id');

    	$manual_cg = [];
    	$manual_rc = [];
    	$manual_ec = [];
    	$manual_fm = [];
    	$manual_gm = [];
    	$temp_manual_cg = $sub_results->where('category_id', 1)->where('type', 1)->toArray();
    	collect($temp_manual_cg)->map(function($item) use (&$manual_cg) {
    		$manual_cg[$item['question_id']] = $item['is_manual'] ? 'true' : 'false';
    	});
    	$temp_manual_rc = $sub_results->where('category_id', 2)->where('type', 1);
    	collect($temp_manual_rc)->map(function($item) use (&$manual_rc) {
    		$manual_rc[$item['question_id']] = $item['is_manual'] ? 'true' : 'false';
    	});        
    	$temp_manual_ec = $sub_results->where('category_id', 3)->where('type', 1);
    	collect($temp_manual_ec)->map(function($item) use (&$manual_ec) {
    		$manual_ec[$item['question_id']] = $item['is_manual'] ? 'true' : 'false';
    	});        
    	$temp_manual_fm = $sub_results->where('category_id', 4)->where('type', 1);
    	collect($temp_manual_fm)->map(function($item) use (&$manual_fm) {
    		$manual_fm[$item['question_id']] = $item['is_manual'] ? 'true' : 'false';
    	});
    	$temp_manual_gm = $sub_results->where('category_id', 5)->where('type', 1)->toArray();
    	collect($temp_manual_gm)->map(function($item) use (&$manual_gm) {
    		$manual_gm[$item['question_id']] = $item['is_manual'] ? 'true' : 'false';
    	});

    	$table_id_other = $sub_results->where('type', '<>', 1)->pluck('sub_question_id', 'id');
    	$note = $sub_results->whereIn('type', [2, 4])->pluck('value', 'sub_question_id');
    	$correct = $sub_results->where('type', 3)->pluck('value', 'sub_question_id');
    	$category_options = $this->category;

    	$doctor_master = \ValuelistHelpers::mas_doctors_list();
    	$cc_infant_details_full_data = \DB::table('carolina_infants_details')->where('baby_id', $baby_id)->where('visit_date', '<=', $OpDate)->orderBy('visit_date', 'ASC')->get();
    	$cc_infant_details = $cc_infant_details_full_data->pluck('result_data')->toArray();
    	$cc_current_infant_entry  = $cc_infant_details_full_data->where('neuro_visit_id', $id)->first();
    	$cc_previous_infant_entry  = $cc_infant_details_full_data->where('visit_date', '<', $OpDate)->sortByDesc('visit_date')->first();

    	$visitColors = [
            0 => 'red',         // First visit
            1 => 'green',       // Second visit
            2 => 'blue',     // Third visit
            3 => 'orange',      // Fourth visit
        ];

        $cc_infant_count = $cc_infant_details_full_data->count();

        if($cc_infant_count > 0 && $cc_infant_count < 4){
        	$infant_color = $visitColors[$cc_infant_count];
        } else if($cc_infant_count == 4){
        	$infant_color = $visitColors[3];
        } else{
        	$infant_color = $visitColors[0];
        }

        if (empty($cc_current_infant_entry->neuro_visit_id)) {
        	$cc_infant_details[] = [];
        }

        $cc_preschoolers_details_full_data = \DB::table('carolina_preschoolers_details')->where('baby_id', $baby_id)->where('visit_date', '<=', $OpDate)->orderBy('visit_date', 'ASC')->get();
        $cc_preschoolers_details = $cc_preschoolers_details_full_data->pluck('result_data')->toArray();

        $cc_current_preschoolers_entry  = $cc_preschoolers_details_full_data->where('neuro_visit_id', $id)->first();
        $cc_previous_preschoolers_entry  = $cc_preschoolers_details_full_data->where('visit_date', '<', $OpDate)->sortByDesc('visit_date')->first();


        if (empty($cc_current_preschoolers_entry->neuro_visit_id)) {
        	$cc_preschoolers_details[] = [];
        }

        $cc_preschoolers_count = $cc_preschoolers_details_full_data->count();

        if($cc_preschoolers_count > 0 && $cc_preschoolers_count < 4){
        	$preschoolers_color = $visitColors[$cc_preschoolers_count];
        }else{
        	$preschoolers_color = $visitColors[0];
        } 

        $doctor_master = \ValuelistHelpers::mas_doctors_list();

        $issa_question = ISSAquestionsMaster::list()->groupBy('category')->toArray();

	    $issa_answer = [];
        if (isset($results->answer)) {
	        $temp_issa_answer = json_decode($results->answer);
	        foreach ($temp_issa_answer as $key => $value) {
		        $issa_answer[$key] = $value;
	        }
        }

        return view('registration.neuro.edit', compact('results', 'neuro_developmental_details', 'ddst_details', 'ddst_form_fields', 'ddst_alignments_info', 'm_chat_questions', 'm_chat_results', 'm_chat_followup_questions', 'm_chat_followup_results', 'm_chat_followup_results_description', 'time', 'hnne_details', 'hine_details', 'm_chat_followup_results_final_answer', 'ddst_result', 'ddst_settings', 'hnne_hine_interpretation_options', 'm_chat_interpretation_options', 'dasii_interpretation_options', 'left_options', 'right_options', 'current_age', 'current_chart_age', 'active_tab', 'ddst_interpretation_result', 'ddst_interpretation_options', 'dasii_motor_questions', 'dasii_mental_questions', 'ddst_setting', 'motor_cluster', 'mental_cluster', 'cbcl_question', 'cbcl_result', 'previous_screening', 'dvs', 'rks', 'id', 'bayley_master', 'score_cg', 'score_rc', 'score_ec', 'score_fm', 'score_gm', 'note', 'correct', 'table_id_score_cg', 'table_id_score_rc', 'table_id_score_ec', 'table_id_score_fm', 'table_id_score_gm', 'table_id_other', 'score_sub_id_cg', 'score_sub_id_rc', 'score_sub_id_ec', 'score_sub_id_fm', 'score_sub_id_gm', 'manual_cg', 'manual_rc', 'manual_ec', 'manual_fm', 'manual_gm', 'doctor_master', 'table_id_score_se', 'score_se', 'score_sub_id_se', 'table_id_score_ab_r', 'table_id_score_ab_e', 'table_id_score_ab_p', 'table_id_score_ab_ir', 'table_id_score_ab_pl', 'score_sub_id_ab_r', 'score_sub_id_ab_e', 'score_sub_id_ab_p', 'score_sub_id_ab_ir', 'score_sub_id_ab_pl', 'score_ab_r', 'score_ab_e', 'score_ab_p', 'score_ab_ir', 'score_ab_pl', 'neuro_consultant_id', 'cc_infant_details','cc_preschoolers_details','preschoolers_color','infant_color','preschoolers_color',
        	'cc_current_infant_entry','cc_previous_infant_entry','cc_current_preschoolers_entry','cc_previous_preschoolers_entry', 'pvs', 'visit_date', 'issa_question', 'issa_answer'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
    	$input = $request->all();

    	$print_flag = isset($input['print_flag']) ? $input['print_flag'] : 0;
    	unset($input['print_flag']);

    	$input['UserModified'] = $this->auth->user()->id;
    	$input['DateModified'] = Carbon::now();
    	$mother = Mother::findOrfail($input['MotherId']);
    	$mother->update($input);

    	$baby_id = isset($input['BabyId']) ? $input['BabyId'] : null;

    	$neuro_visit_id = $input['id'];
    	if (isset($input['visit_date'])) {
    		$visit_date = date('Y-m-d', strtotime($input['visit_date']));
    	} elseif (isset($input['old_visit_date'])){
    		$visit_date = date('Y-m-d', strtotime($input['old_visit_date']));
    	}

    	if (in_array('NEURO_DEVELOPMENT_BASIC',$this->write_permission)) {
    		$input['DOB'] = (isset($input['DOB']) && !empty($input['DOB'])) ? date('Y-m-d', strtotime($input['DOB'])) : null;
    		$input['BirthStatus'] = (isset($input['BirthStatus']) && $input['BirthStatus'] == 'on') ? 'Inborn' : 'Outborn';
    		$input['g_weeks'] = (isset($input['g_weeks']) && !empty($input['g_weeks'])) ? $input['g_weeks'] : null;
    		$input['g_days'] = (isset($input['g_days']) && !empty($input['g_days'])) ? $input['g_days'] : null;
    		$input['UserModified'] = $this->auth->user()->id;
    		$input['DateModified'] = Carbon::now();
    		$baby = Baby::findOrfail($input['BabyId']);
    		$baby->update($input);

    		$this->storeNeuro($input, $baby_id, $neuro_visit_id);
    		$this->makeAppointment($input, $neuro_visit_id);        
    		$this->storeEligibility($input, $baby_id, $neuro_visit_id, $visit_date);
    		$this->storeScreening($input, $baby_id, $neuro_visit_id, $visit_date);
    		$this->storeMuscleTone($input, $baby_id, $neuro_visit_id, $visit_date);
    	}
    	if (in_array('SCREENING_HNNE',$this->write_permission)) {
    		$this->storeHnneDetails($input, $neuro_visit_id, $visit_date);
    	}
    	if (in_array('SCREENING_HINE',$this->write_permission)) {
    		$this->storeHineDetails($input, $neuro_visit_id, $visit_date);
    	}
    	if (in_array('SCREENING_M_CHAT',$this->write_permission)) {
    		$this->storeMChatAnswers($input, $neuro_visit_id);
    		$this->storeMChatFollowUpAnswers($input, $neuro_visit_id);
    	}
    	if (in_array('SCREENING_DASII',$this->write_permission)) {
    		$this->storeDasiiMentalScale($input, $neuro_visit_id);
    		$this->storeDasiiMotorScale($input, $neuro_visit_id);
    	}
    	if (in_array('SCREENING_DDST',$this->write_permission)) {
    		$this->storeDdst($input, $neuro_visit_id);
    	}
    	if (in_array('SCREENING_CBCL',$this->write_permission)) {
    		$this->storeCbcl($input, $neuro_visit_id);
    	}
    	if (in_array('SCREENING_BAYLEY',$this->write_permission)) {
    		$this->storeBayley($input, $neuro_visit_id);
    	}
    	if (in_array('SCREENING_ISSA',$this->write_permission)) {
    		$this->storeIssa($input, $neuro_visit_id);
    	}
    	if (in_array('SCREENING_CARS',$this->write_permission)) {
    		$this->storeCars($input, $neuro_visit_id);
    	}
    	if (in_array('SCREENING_INFANTS',$this->write_permission)) {
    		$this->storeInfants($input, $neuro_visit_id, $visit_date);
    	}
    	if (in_array('SCREENING_PRESCHOOLERS',$this->write_permission)) {
    		$this->storePreschoolers($input, $neuro_visit_id, $visit_date);
    	}
    	if (in_array('SCREENING_PEP3',$this->write_permission)) {
    		$this->storePep3($input, $neuro_visit_id);
    	}

    	if ($request->ajax())
    	{
    		return \Response::json(['type' => 'success', 'message' => 'Record updated successfully !', 'edit_url' => action('Registration\NeuroController@edit', \SiteHelpers::encrypt_id($neuro_visit_id)) , 'list_url' => action('Registration\NeuroController@index'), 'print_url' => action('Registration\NeuroController@show', \SiteHelpers::encrypt_id($neuro_visit_id)), 'assessment_print_url' => action('Registration\NeuroController@assessmentprint', \SiteHelpers::encrypt_id($neuro_visit_id)) ], 200);
    	}

    	if ($print_flag == 1)
    	{
    		return redirect(action('Registration\NeuroController@edit', \SiteHelpers::encrypt_id($neuro_visit_id)))->with('Success', 'Record saved successfully !');
    	}
    	elseif ($print_flag == 2)
    	{
    		return redirect(action('Registration\NeuroController@index'))->with('Success', 'Record saved successfully !');
    	}
    	elseif ($print_flag == 3)
    	{
    		return redirect(action('Registration\NeuroController@show', \SiteHelpers::encrypt_id($edityneuro_visit_id)).'?closewinlink=edit-view')->with('Success', 'Record saved successfully !');
    	}
    	elseif ($print_flag == 5)
    	{
    		return redirect(action('Registration\NeuroController@assessmentprint', \SiteHelpers::encrypt_id($neuro_visit_id)).'?closewinlink=edit-view')->with('Success', 'Record saved successfully !');
    	}
    	elseif ($print_flag == 4)
    	{
    		return redirect(action('Registration\NeuroController@index'));
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
    	$results = NeuroVisit::findOrfail($id);

    	$user_detail = array(
    		'user_deleted' => $this->auth->user()->id,
    		'date_modified' => Carbon::now() ,
    		'is_deleted' => '1'
    	);
    	$results->update($user_detail);

    	$baby_name = Baby::get_record($results->baby_id) [0]->BabyName;

    	$delete_data = array(
    		'Name' => $baby_name,
    		'AdmissionDate' => $results['OpDate'],
    		'ModuleController' => 'Registration\NeuroController',
    		'ModuleId' => $id,
    		'ModuleName' => 'Neuro Registration',
    		'UserDeleted' => $this->auth->user()->id,
    		'DateDeleted' => Carbon::now()
    	);
    	DeleteApproval::create($delete_data);

    	return redirect(action('Registration\NeuroController@index'))->with('info', 'Record deleted successfully !');
    }

    public function chooseBaby()
    {
    	$navigate['main_nav'] = 'registration';
    	$navigate['sub_nav'] = 'neuro';
    	$baby = Baby::baby_list_op();
    	$babies = \ValuelistHelpers::select2DataFormater($baby, true);

    	$SubmitButtonText = "Start";

    	return view('registration.neuro.select_patient', compact('SubmitButtonText', 'babies', 'navigate'));
    }

    /**
     * show the visite list for a baby
     *
     *@param baby_id encrypted hash value
     */

    public function NeuroSubList(Request $request, $baby_id)
    {
        // decrypt the baby id
    	$baby_id = \SiteHelpers::decrypt_id($baby_id);

        //get the visite list 
    	$neonatal_visite_list = Op::GetOpvisitList($baby_id)->toArray();
    	$neuro_visite_list = NeuroVisit::GetNeuroVisitList($baby_id)->toArray();

    	$temp_visite_list = array_merge($neonatal_visite_list, $neuro_visite_list);

    	$list = collect($temp_visite_list)->groupBy('type')->toArray();

    	$neonatal_visit = isset($list['neonatal']) ? collect($list['neonatal'])->pluck('OpDate')->toArray() : [];
    	$neuro_visit = isset($list['neuro']) ? collect($list['neuro'])->pluck('visit_date')->toArray() : [];

    	$temp = [];
    	foreach ($neonatal_visit as $value) {
    		if (!in_array($value, $neuro_visit) || in_array($value, $temp)) {
    			$neuro_visit[] = $value;
    		} else {
    			$temp[] = $value;
    		}
    	}
    	$visite_list['count'] = count($neuro_visit);
    	$temp_visite_list = collect($temp_visite_list)->sortByDesc('visit_date');
    	$visite_list['lists'] = collect($temp_visite_list)->groupBy(['visit_date', 'type'])->toArray();

        //get Baby name
    	$baby_name = isset($neuro_visite_list[0]['BabyName']) ? $neuro_visite_list[0]['BabyName'] . ' - ' . $neuro_visite_list[0]['BMrNo'] : '';
    	$baby_mrn = isset($neuro_visite_list[0]['BMrNo']) ? $neuro_visite_list[0]['BMrNo'] : '';
    	$navigate['main_nav'] = 'op';
    	$navigate['sub_nav'] = 'op';

    	$visit_ids = collect($neuro_visite_list)->pluck('id');

    	$file_list = FileUpload::getList($visit_ids, 6);        

    	return view('registration.neuro.visite_list', compact('visite_list', 'baby_name', 'navigate', 'baby_id', 'neonatal_visite_list', 'neuro_visite_list', 'file_list', 'baby_mrn'));

    }

    public function storeNeuro($input, $baby_id, $neuro_visit_id = '')
    {   
//        $this->custom_error->emergencyLog('baby_behavior input value ==========='.$input['baby_behavior']);
    	$neuro_visit['hnne_interpretation'] = isset($input['hnne_interpretation']) ? $input['hnne_interpretation'] : null;
    	$neuro_visit['hine_interpretation'] = isset($input['hine_interpretation']) ? $input['hine_interpretation'] : null;
    	$neuro_visit['m_chat_r_interpretation'] = isset($input['m_chat_r_interpretation']) ? $input['m_chat_r_interpretation'] : null;
    	$neuro_visit['m_chat_followup_interpretation'] = isset($input['m_chat_followup_interpretation']) ? $input['m_chat_followup_interpretation'] : null;
    	$neuro_visit['dasii_interpretation'] = isset($input['dasii_interpretation']) ? $input['dasii_interpretation'] : null;
    	$neuro_visit['mental_cluster_interpretation'] = isset($input['mental_cluster_interpretation']) ? $input['mental_cluster_interpretation'] : null;
    	$neuro_visit['motor_cluster_interpretation'] = isset($input['motor_cluster_interpretation']) ? $input['motor_cluster_interpretation'] : null;
    	$neuro_visit['ddst_interpretation_status'] = isset($input['ddst_interpretation_status']) ? $input['ddst_interpretation_status'] : null;
    	$neuro_visit['ddst_gross_motor_interpretation_status'] = isset($input['ddst_gross_motor_interpretation_status']) ? $input['ddst_gross_motor_interpretation_status'] : null;
    	$neuro_visit['ddst_language_interpretation_status'] = isset($input['ddst_language_interpretation_status']) ? $input['ddst_language_interpretation_status'] : null;
    	$neuro_visit['ddst_fine_motor_interpretation_status'] = isset($input['ddst_fine_motor_interpretation_status']) ? $input['ddst_fine_motor_interpretation_status'] : null;
    	$neuro_visit['ddst_personal_interpretation_status'] = isset($input['ddst_personal_interpretation_status']) ? $input['ddst_personal_interpretation_status'] : null;
    	$neuro_visit['ddst_interpretation'] = isset($input['ddst_interpretation']) ? $input['ddst_interpretation'] : null;
    	$neuro_visit['hnne_interpretation_others'] = isset($input['hnne_interpretation_others']) ? $input['hnne_interpretation_others'] : null;
    	$neuro_visit['hine_interpretation_others'] = isset($input['hine_interpretation_others']) ? $input['hine_interpretation_others'] : null;
    	$neuro_visit['m_chat_r_interpretation_others'] = isset($input['m_chat_r_interpretation_others']) ? $input['m_chat_r_interpretation_others'] : null;
    	$neuro_visit['m_chat_followup_interpretation_others'] = isset($input['m_chat_followup_interpretation_others']) ? $input['m_chat_followup_interpretation_others'] : null;
    	$neuro_visit['ddst_interpretation_others'] = isset($input['ddst_interpretation_others']) ? $input['ddst_interpretation_others'] : null;
    	$neuro_visit['cbcl_interpretation'] = isset($input['cbcl_interpretation']) ? $input['cbcl_interpretation'] : null;
    	$neuro_visit['cbcl_interpretation_status'] = (isset($input['cbcl_interpretation_status']) && !empty($input['cbcl_interpretation_status'])) ? $input['cbcl_interpretation_status'] : null;        
    	$neuro_visit['clusters'] = isset($input['clusters']) ? $input['clusters'] : null;
    	$neuro_visit['motor_development_quotient'] = isset($input['motor_development_quotient']) ? $input['motor_development_quotient'] : null;
    	$neuro_visit['mental_development_quotient'] = isset($input['mental_development_quotient']) ? $input['mental_development_quotient'] : null;
    	$neuro_visit['tone_type'] = (isset($input['tone_type']) && !empty($input['tone_type'])) ? $input['tone_type'] : 0;
    	$neuro_visit['others'] = (isset($input['others']) && !empty($input['others'])) ? $input['others'] : 0;
    	$neuro_visit['others_asymmetric'] = (isset($input['others_asymmetric']) && !empty($input['others_asymmetric'])) ? $input['others_asymmetric'] : null;
    	$neuro_visit['baby_behavior'] = isset($input['baby_behavior']) ? $input['baby_behavior'] : null;
    	$neuro_visit['baby_background'] = isset($input['baby_background']) ? $input['baby_background'] : null;
    	if (isset($input['visit_date'])) {
    		$neuro_visit['visit_date'] = date('Y-m-d', strtotime($input['visit_date']));
    	}
    	$neuro_visit['visit_time'] = isset($input['visit_time']) ? $input['visit_time'] : null;
    	$neuro_visit['visit_min'] = isset($input['visit_min']) ? $input['visit_min'] : null;
    	$neuro_visit['visit_session'] = isset($input['visit_session']) ? $input['visit_session'] : null;
    	$neuro_visit['mental_development_age'] = isset($input['mental_development_age']) ? $input['mental_development_age'] : null;
    	$neuro_visit['motor_development_age'] = isset($input['motor_development_age']) ? $input['motor_development_age'] : null;
    	$neuro_visit['chronological_year'] = (isset($input['chronological_year']) && !empty($input['chronological_year'])) ? $input['chronological_year'] : 0;
    	$neuro_visit['chronological_month'] = (isset($input['chronological_month']) && !empty($input['chronological_month'])) ? $input['chronological_month'] : 0;
    	$neuro_visit['chronological_days'] = (isset($input['chronological_days']) && !empty($input['chronological_days'])) ? $input['chronological_days'] : 0;
    	$neuro_visit['corrected_year'] = (isset($input['corrected_year']) && !empty($input['corrected_year'])) ? $input['corrected_year'] : 0;
    	$neuro_visit['corrected_month'] = (isset($input['corrected_month']) && !empty($input['corrected_month'])) ? $input['corrected_month'] : 0;
    	$neuro_visit['corrected_days'] = (isset($input['corrected_days']) && !empty($input['corrected_days'])) ? $input['corrected_days'] : 0;
    	$neuro_visit['recommendation'] = isset($input['recommendation']) ? $input['recommendation'] : null;
    	$neuro_visit['confidential_background_details'] = isset($input['confidential_background_details']) ? $input['confidential_background_details'] : null;
    	$neuro_visit['appointment_type'] = isset($input['appointment_type']) ? $input['appointment_type'] : null;
    	$neuro_visit['review'] = (isset($input['review']) && !empty($input['review'])) ? date('Y-m-d', strtotime($input['review'])) : null;
    	$neuro_visit['review_time'] = isset($input['review_time']) ? $input['review_time'] : null;
    	$neuro_visit['review_min'] = isset($input['review_min']) ? $input['review_min'] : null;
    	$neuro_visit['review_session'] = isset($input['review_session']) ? $input['review_session'] : null;
    	$neuro_visit['head_circumference'] = isset($input['head_circumference']) ? $input['head_circumference'] : null;
    	$neuro_visit['current_weight_g'] = isset($input['current_weight_g']) ? $input['current_weight_g'] : null;
    	$neuro_visit['current_ofc'] = isset($input['current_ofc']) ? $input['current_ofc'] : null;
    	$neuro_visit['current_length'] = isset($input['current_length']) ? $input['current_length'] : null;
    	$neuro_visit['fee_status'] = isset($input['fee_status']) ? $input['fee_status'] : 0;
    	$neuro_visit['fee_amount'] = isset($input['fee_amount']) ? $input['fee_amount'] : null;
    	$neuro_visit['no_fee_reason'] = isset($input['no_fee_reason']) ? $input['no_fee_reason'] : null;
    	$neuro_visit['referral_status'] = isset($input['referral_status']) ? $input['referral_status'] : 0;
    	$neuro_visit['referral_to'] = isset($input['referral_to']) ? $input['referral_to'] : null;
    	$neuro_visit['mental_prior_pass'] = (isset($input['mental_prior_pass']) && !empty($input['mental_prior_pass'])) ? $input['motor_prior_pass'] : 0;
    	$neuro_visit['mental_rest_fail'] = (isset($input['mental_rest_fail']) && !empty($input['mental_rest_fail'])) ? $input['mental_rest_fail'] : 0;
    	$neuro_visit['motor_prior_pass'] = (isset($input['motor_prior_pass']) && !empty($input['motor_prior_pass'])) ? $input['motor_prior_pass'] : 0;
    	$neuro_visit['motor_rest_fail'] = (isset($input['motor_rest_fail']) && !empty($input['motor_rest_fail'])) ? $input['motor_rest_fail'] : 0;

    	$neuro_visit['motor_cluster_1'] = (isset($input['motor_cluster_1']) && !empty($input['motor_cluster_1'])) ? $input['motor_cluster_1'] : 0;
    	$neuro_visit['motor_cluster_2'] = (isset($input['motor_cluster_2']) && !empty($input['motor_cluster_2'])) ? $input['motor_cluster_2'] : 0;
    	$neuro_visit['motor_cluster_3'] = (isset($input['motor_cluster_3']) && !empty($input['motor_cluster_3'])) ? $input['motor_cluster_3'] : 0;
    	$neuro_visit['motor_cluster_4'] = (isset($input['motor_cluster_4']) && !empty($input['motor_cluster_4'])) ? $input['motor_cluster_4'] : 0;
    	$neuro_visit['motor_cluster_5'] = (isset($input['motor_cluster_5']) && !empty($input['motor_cluster_5'])) ? $input['motor_cluster_5'] : 0;

    	$neuro_visit['motor_cluster_pr_1'] = (isset($input['motor_cluster_pr_1']) && !empty($input['motor_cluster_pr_1'])) ? $input['motor_cluster_pr_1'] : null;
    	$neuro_visit['motor_cluster_pr_2'] = (isset($input['motor_cluster_pr_2']) && !empty($input['motor_cluster_pr_2'])) ? $input['motor_cluster_pr_2'] : null;
    	$neuro_visit['motor_cluster_pr_3'] = (isset($input['motor_cluster_pr_3']) && !empty($input['motor_cluster_pr_3'])) ? $input['motor_cluster_pr_3'] : null;
    	$neuro_visit['motor_cluster_pr_4'] = (isset($input['motor_cluster_pr_4']) && !empty($input['motor_cluster_pr_4'])) ? $input['motor_cluster_pr_4'] : null;
    	$neuro_visit['motor_cluster_pr_5'] = (isset($input['motor_cluster_pr_5']) && !empty($input['motor_cluster_pr_5'])) ? $input['motor_cluster_pr_5'] : null;

    	$neuro_visit['motor_cluster_remarks_1'] = (isset($input['motor_cluster_remarks_1']) && !empty($input['motor_cluster_remarks_1'])) ? $input['motor_cluster_remarks_1'] : null;
    	$neuro_visit['motor_cluster_remarks_2'] = (isset($input['motor_cluster_remarks_2']) && !empty($input['motor_cluster_remarks_2'])) ? $input['motor_cluster_remarks_2'] : null;
    	$neuro_visit['motor_cluster_remarks_3'] = (isset($input['motor_cluster_remarks_3']) && !empty($input['motor_cluster_remarks_3'])) ? $input['motor_cluster_remarks_3'] : null;
    	$neuro_visit['motor_cluster_remarks_4'] = (isset($input['motor_cluster_remarks_4']) && !empty($input['motor_cluster_remarks_4'])) ? $input['motor_cluster_remarks_4'] : null;
    	$neuro_visit['motor_cluster_remarks_5'] = (isset($input['motor_cluster_remarks_5']) && !empty($input['motor_cluster_remarks_5'])) ? $input['motor_cluster_remarks_5'] : null;

    	$neuro_visit['mental_cluster_1'] = (isset($input['mental_cluster_1']) && !empty($input['mental_cluster_1'])) ? $input['mental_cluster_1'] : 0;
    	$neuro_visit['mental_cluster_2'] = (isset($input['mental_cluster_2']) && !empty($input['mental_cluster_2'])) ? $input['mental_cluster_2'] : 0;
    	$neuro_visit['mental_cluster_3'] = (isset($input['mental_cluster_3']) && !empty($input['mental_cluster_3'])) ? $input['mental_cluster_3'] : 0;
    	$neuro_visit['mental_cluster_4'] = (isset($input['mental_cluster_4']) && !empty($input['mental_cluster_4'])) ? $input['mental_cluster_4'] : 0;
    	$neuro_visit['mental_cluster_5'] = (isset($input['mental_cluster_5']) && !empty($input['mental_cluster_5'])) ? $input['mental_cluster_5'] : 0;
    	$neuro_visit['mental_cluster_6'] = (isset($input['mental_cluster_6']) && !empty($input['mental_cluster_6'])) ? $input['mental_cluster_6'] : 0;
    	$neuro_visit['mental_cluster_7'] = (isset($input['mental_cluster_7']) && !empty($input['mental_cluster_7'])) ? $input['mental_cluster_7'] : 0;
    	$neuro_visit['mental_cluster_8'] = (isset($input['mental_cluster_8']) && !empty($input['mental_cluster_8'])) ? $input['mental_cluster_8'] : 0;
    	$neuro_visit['mental_cluster_9'] = (isset($input['mental_cluster_9']) && !empty($input['mental_cluster_9'])) ? $input['mental_cluster_9'] : 0;
    	$neuro_visit['mental_cluster_10'] = (isset($input['mental_cluster_10']) && !empty($input['mental_cluster_10'])) ? $input['mental_cluster_10'] : 0;

    	$neuro_visit['mental_cluster_pr_1'] = (isset($input['mental_cluster_pr_1']) && !empty($input['mental_cluster_pr_1'])) ? $input['mental_cluster_pr_1'] : null;
    	$neuro_visit['mental_cluster_pr_2'] = (isset($input['mental_cluster_pr_2']) && !empty($input['mental_cluster_pr_2'])) ? $input['mental_cluster_pr_2'] : null;
    	$neuro_visit['mental_cluster_pr_3'] = (isset($input['mental_cluster_pr_3']) && !empty($input['mental_cluster_pr_3'])) ? $input['mental_cluster_pr_3'] : null;
    	$neuro_visit['mental_cluster_pr_4'] = (isset($input['mental_cluster_pr_4']) && !empty($input['mental_cluster_pr_4'])) ? $input['mental_cluster_pr_4'] : null;
    	$neuro_visit['mental_cluster_pr_5'] = (isset($input['mental_cluster_pr_5']) && !empty($input['mental_cluster_pr_5'])) ? $input['mental_cluster_pr_5'] : null;
    	$neuro_visit['mental_cluster_pr_6'] = (isset($input['mental_cluster_pr_6']) && !empty($input['mental_cluster_pr_6'])) ? $input['mental_cluster_pr_6'] : null;
    	$neuro_visit['mental_cluster_pr_7'] = (isset($input['mental_cluster_pr_7']) && !empty($input['mental_cluster_pr_7'])) ? $input['mental_cluster_pr_7'] : null;
    	$neuro_visit['mental_cluster_pr_8'] = (isset($input['mental_cluster_pr_8']) && !empty($input['mental_cluster_pr_8'])) ? $input['mental_cluster_pr_8'] : null;
    	$neuro_visit['mental_cluster_pr_9'] = (isset($input['mental_cluster_pr_9']) && !empty($input['mental_cluster_pr_9'])) ? $input['mental_cluster_pr_9'] : null;
    	$neuro_visit['mental_cluster_pr_10'] = (isset($input['mental_cluster_pr_10']) && !empty($input['mental_cluster_pr_10'])) ? $input['mental_cluster_pr_10'] : null;

    	$neuro_visit['mental_cluster_remarks_1'] = (isset($input['mental_cluster_remarks_1']) && !empty($input['mental_cluster_remarks_1'])) ? $input['mental_cluster_remarks_1'] : null;
    	$neuro_visit['mental_cluster_remarks_2'] = (isset($input['mental_cluster_remarks_2']) && !empty($input['mental_cluster_remarks_2'])) ? $input['mental_cluster_remarks_2'] : null;
    	$neuro_visit['mental_cluster_remarks_3'] = (isset($input['mental_cluster_remarks_3']) && !empty($input['mental_cluster_remarks_3'])) ? $input['mental_cluster_remarks_3'] : null;
    	$neuro_visit['mental_cluster_remarks_4'] = (isset($input['mental_cluster_remarks_4']) && !empty($input['mental_cluster_remarks_4'])) ? $input['mental_cluster_remarks_4'] : null;
    	$neuro_visit['mental_cluster_remarks_5'] = (isset($input['mental_cluster_remarks_5']) && !empty($input['mental_cluster_remarks_5'])) ? $input['mental_cluster_remarks_5'] : null;
    	$neuro_visit['mental_cluster_remarks_6'] = (isset($input['mental_cluster_remarks_6']) && !empty($input['mental_cluster_remarks_6'])) ? $input['mental_cluster_remarks_6'] : null;
    	$neuro_visit['mental_cluster_remarks_7'] = (isset($input['mental_cluster_remarks_7']) && !empty($input['mental_cluster_remarks_7'])) ? $input['mental_cluster_remarks_7'] : null;
    	$neuro_visit['mental_cluster_remarks_8'] = (isset($input['mental_cluster_remarks_8']) && !empty($input['mental_cluster_remarks_8'])) ? $input['mental_cluster_remarks_8'] : null;
    	$neuro_visit['mental_cluster_remarks_9'] = (isset($input['mental_cluster_remarks_9']) && !empty($input['mental_cluster_remarks_9'])) ? $input['mental_cluster_remarks_9'] : null;
    	$neuro_visit['mental_cluster_remarks_10'] = (isset($input['mental_cluster_remarks_10']) && !empty($input['mental_cluster_remarks_10'])) ? $input['mental_cluster_remarks_10'] : null;

    	$neuro_visit['affective_problem'] = !empty($input['affective_problem']) ? $input['affective_problem'] : null;
    	$neuro_visit['anxiety_problem'] = !empty($input['anxiety_problem']) ? $input['anxiety_problem'] : null;
    	$neuro_visit['pervasive_developmental_problem'] = !empty($input['pervasive_developmental_problem']) ? $input['pervasive_developmental_problem'] : null;
    	$neuro_visit['attention_deficit_hyperactivity_problem'] = !empty($input['attention_deficit_hyperactivity_problem']) ? $input['attention_deficit_hyperactivity_problem'] : null;
    	$neuro_visit['oppositional_defiant_problem'] = !empty($input['oppositional_defiant_problem']) ? $input['oppositional_defiant_problem'] : null;

    	$neuro_visit['cluster_range'] = (isset($input['cluster_range']) && !empty($input['cluster_range'])) ? $input['cluster_range'] : null;

    	$neuro_visit['visit_from'] = (isset($input['visit_from']) && !empty($input['visit_from'])) ? $input['visit_from'] : null;
    	$neuro_visit['visit_number'] = (isset($input['visit_number']) && !empty($input['visit_number'])) ? $input['visit_number'] : null;
    	$neuro_visit['seen_by'] = isset($input['seen_by']) ? json_encode($input['seen_by']) : null;

    	$neuro_visit['reason_referral'] = isset($input['reason_referral']) ? $input['reason_referral'] : null;
    	$neuro_visit['caregiver_name'] = isset($input['caregiver_name']) ? $input['caregiver_name'] : null;
        $neuro_visit['caregiver_assessment'] = isset($input['caregiver_assessment']) ? $input['caregiver_assessment'] : null;
    	$neuro_visit['primary_caregiver_education'] = isset($input['primary_caregiver_education']) ? $input['primary_caregiver_education'] : null;
    	$neuro_visit['hour_of_intervention'] = isset($input['hour_of_intervention']) ? $input['hour_of_intervention'] : null;
    	$neuro_visit['relationship_to_child'] = isset($input['relationship_to_child']) ? $input['relationship_to_child'] : null;
    	$neuro_visit['other_relationship'] = isset($input['other_relationship']) ? $input['other_relationship'] : null;
    	$neuro_visit['examiner'] = isset($input['examiner']) ? $input['examiner'] : null;
    	$neuro_visit['diagnosis'] = isset($input['diagnosis']) ? $input['diagnosis'] : null;
    	$neuro_visit['contact_no'] = isset($input['contact_no']) ? $input['contact_no'] : null;
        // $neuro_visit['cars'] = isset($input['cars']) ? $input['cars'] : null;
    	$neuro_visit['referal_doctor'] = isset($input['referal_doctor']) ? $input['referal_doctor'] : null;
    	$neuro_visit['home_program'] = isset($input['home_program']) ? $input['home_program'] : null;
        $this->custom_error->emergencyLog('Request to store neuro visit table ==========='.json_encode($neuro_visit));
    	if ($neuro_visit_id > 0)
    	{
    		$neuro_visit['user_modified'] = $this->auth->user()->id;
    		$neuro_visit['date_modified'] = Carbon::now(env('TIME_ZONE'));
    		NeuroVisit::where('id', $neuro_visit_id)->update($neuro_visit);
    	}
    	else
    	{
    		$neuro_visit['user_added'] = $this->auth->user()->id;
    		$neuro_visit['date_added'] = Carbon::now(env('TIME_ZONE'));
    		$neuro_visit['baby_id'] = $baby_id;
    		if (isset($input['BMrNo'])) {
    			$neuro_visit['mrn'] = $input['BMrNo'];
    		}
    		$neuro_visit_id = NeuroVisit::insertGetId($neuro_visit);
    	}

    	return $neuro_visit_id;

    }

    // Eligibility for enrolment in HRC
    public function storeEligibility($input, $baby_id, $neuro_visit_id, $visit_date)
    {

    	if (isset($input['birth_weight_gestation_is_lesser']) || isset($input['birth_weight_gestation_is_greater']) || isset($input['other_specify']) || isset($input['other_specify_is_present']) || isset($input['general_checkup']))
    	{

    		$eligibility['birth_weight_gestation_is_lesser'] = (isset($input['birth_weight_gestation_is_lesser']) && $input['birth_weight_gestation_is_lesser'] == 'on') ? 1 : 0;
    		$eligibility['birth_weight_gestation_is_greater'] = (isset($input['birth_weight_gestation_is_greater']) && $input['birth_weight_gestation_is_greater'] == 'on') ? 1 : 0;
    		$eligibility['intrauterine_growth'] = (isset($input['intrauterine_growth']) && $input['intrauterine_growth'] == 'on') ? 1 : 0;
    		$eligibility['meningitis'] = (isset($input['meningitis']) && $input['meningitis'] == 'on') ? 1 : 0;
    		$eligibility['mechanical_ventilation'] = (isset($input['mechanical_ventilation']) && $input['mechanical_ventilation'] == 'on') ? 1 : 0;
    		$eligibility['encephalopathy_stage_2_more'] = (isset($input['encephalopathy_stage_2_more']) && $input['encephalopathy_stage_2_more'] == 'on') ? 1 : 0;
    		$eligibility['major_malformation'] = (isset($input['major_malformation']) && $input['major_malformation'] == 'on') ? 1 : 0;
    		$eligibility['inborn_errors'] = (isset($input['inborn_errors']) && $input['inborn_errors'] == 'on') ? 1 : 0;
    		$eligibility['symptomatic_hypoglycemia'] = (isset($input['symptomatic_hypoglycemia']) && $input['symptomatic_hypoglycemia'] == 'on') ? 1 : 0;
    		$eligibility['symptomatic_polycythemia'] = (isset($input['symptomatic_polycythemia']) && $input['symptomatic_polycythemia'] == 'on') ? 1 : 0;
    		$eligibility['retrovirus_positive_mother'] = (isset($input['retrovirus_positive_mother']) && $input['retrovirus_positive_mother'] == 'on') ? 1 : 0;
    		$eligibility['hyperbilirubinemia_transfusion_rh'] = (isset($input['hyperbilirubinemia_transfusion_rh']) && $input['hyperbilirubinemia_transfusion_rh'] == 'on') ? 1 : 0;
    		$eligibility['abnormal_neuro_exam'] = (isset($input['abnormal_neuro_exam']) && $input['abnormal_neuro_exam'] == 'on') ? 1 : 0;
    		$eligibility['major_morbidities'] = (isset($input['major_morbidities']) && $input['major_morbidities'] == 'on') ? 1 : 0;
    		$eligibility['other_specify'] = isset($input['other_specify']) ? $input['other_specify'] : '';
    		$eligibility['other_specify_is_present'] = (isset($input['other_specify_is_present']) && $input['other_specify_is_present'] == 'on') ? 1 : 0;
    		$eligibility['general_checkup'] = (isset($input['general_checkup']) && $input['general_checkup'] == 'on') ? 1 : 0;

    		$check_eligibility_exist = NeuroEligibility::where('neuro_visit_id', $neuro_visit_id)->first();

    		if (count($check_eligibility_exist) > 0 && isset($check_eligibility_exist->id))
    		{
    			$eligibility['modified_date_time'] = Carbon::now(env('TIME_ZONE'));
    			$eligibility['modified_user'] = $this->auth->user()->id;
    			NeuroEligibility::where('id', $check_eligibility_exist->id)->update($eligibility);
    		}
    		else
    		{
    			$eligibility['created_date_time'] = Carbon::now(env('TIME_ZONE'));
    			$eligibility['created_user'] = $this->auth->user()->id;
    			$eligibility['neuro_visit_id'] = $neuro_visit_id;
    			$eligibility['baby_id'] = $baby_id;
    			$eligibility['visit_date'] = $visit_date;
    			NeuroEligibility::create($eligibility)->id;
    		}

    	}
    }

    // Screening
    public function storeScreening($input, $baby_id, $neuro_visit_id, $visit_date)
    {
    	if (isset($input['head_test']) || isset($input['rop_options']) || isset($input['hearing_screen_options']) || isset($input['diagnostic_abr_options'])) {
    		if (isset($input['head_test']) && is_array($input['head_test']) && count($input['head_test'])) {
    			$screening['head_test'] = isset($input['head_test']) ? json_encode($input['head_test']) : json_encode([]);
    			if (!empty($input['ct_age']) || !empty($input['ct_date']) || !empty($input['ct_imperssion'])) {
    				$screening['ct_imperssion'] = $input['ct_imperssion'];
    				$screening['ct_date'] = !empty($input['ct_date']) ? date('Y-m-d', strtotime($input['ct_date'])) : null;
    			}
    			if (!empty($input['usg_age']) || !empty($input['usg_date']) || !empty($input['usg_imperssion'])) {
    				$screening['usg_imperssion'] = $input['usg_imperssion'];
    				$screening['usg_date'] = !empty($input['usg_date']) ? date('Y-m-d', strtotime($input['usg_date'])) : null;
    			}
    			if (!empty($input['mri_age']) || !empty($input['mri_date']) || !empty($input['mri_imperssion'])) {
    				$screening['mri_imperssion'] = $input['mri_imperssion'];
    				$screening['mri_date'] = !empty($input['mri_date']) ? date('Y-m-d', strtotime($input['mri_date'])) : null;
    			}
    		}
    		if (isset($input['rop_options']) && is_array($input['rop_options']) && count($input['rop_options']) > 0) {
    			$screening['rop_options'] = isset($input['rop_options']) ? json_encode($input['rop_options']) : json_encode([]);
    			$screening['rop_date'] = (isset($input['rop_date']) && !empty($input['rop_date']) && $input['rop_date'] != 'N/A') ? date('Y-m-d', strtotime($input['rop_date'])) : null;
    			$screening['rop_pna_ca'] = isset($input['rop_pna_ca']) ? $input['rop_pna_ca'] : '';
    			$screening['rop_right_hand_side'] = isset($input['rop_right_hand_side']) ? $input['rop_right_hand_side'] : '';
    			$screening['rop_left_hand_side'] = isset($input['rop_left_hand_side']) ? $input['rop_left_hand_side'] : '';
    			$screening['rop_remarks'] = isset($input['rop_remarks']) ? $input['rop_remarks'] : '';
    		}
    		if (isset($input['hearing_screen_options']) && is_array($input['hearing_screen_options']) && count($input['hearing_screen_options']) > 0) {
    			$screening['hearing_screen_options'] = isset($input['hearing_screen_options']) ? json_encode($input['hearing_screen_options']) : json_encode([]);
    			$screening['hearing_screen_aabr_date'] = (isset($input['hearing_screen_aabr_date']) && !empty($input['hearing_screen_aabr_date']) && $input['hearing_screen_aabr_date'] != 'N/A') ? date('Y-m-d', strtotime($input['hearing_screen_aabr_date'])) : null;
    			$screening['hearing_screen_aabr_pna_ca'] = isset($input['hearing_screen_aabr_pna_ca']) ? $input['hearing_screen_aabr_pna_ca'] : '';
    			$screening['hearing_screen_aabr_right_hand_side'] = isset($input['hearing_screen_aabr_right_hand_side']) ? $input['hearing_screen_aabr_right_hand_side'] : '';
    			$screening['hearing_screen_aabr_left_hand_side'] = isset($input['hearing_screen_aabr_left_hand_side']) ? $input['hearing_screen_aabr_left_hand_side'] : '';
    			$screening['hearing_screen_aabr_remarks'] = isset($input['hearing_screen_aabr_remarks']) ? $input['hearing_screen_aabr_remarks'] : '';
    			$screening['hearing_screen_oae_date'] = (isset($input['hearing_screen_oae_date']) && !empty($input['hearing_screen_oae_date']) && $input['hearing_screen_oae_date'] != 'N/A') ? date('Y-m-d', strtotime($input['hearing_screen_oae_date'])) : null;
    			$screening['hearing_screen_oae_pna_ca'] = isset($input['hearing_screen_oae_pna_ca']) ? $input['hearing_screen_oae_pna_ca'] : '';
    			$screening['hearing_screen_oae_right_hand_side'] = isset($input['hearing_screen_oae_right_hand_side']) ? $input['hearing_screen_oae_right_hand_side'] : '';
    			$screening['hearing_screen_oae_left_hand_side'] = isset($input['hearing_screen_oae_left_hand_side']) ? $input['hearing_screen_oae_left_hand_side'] : '';
    			$screening['hearing_screen_oae_remarks'] = isset($input['hearing_screen_oae_remarks']) ? $input['hearing_screen_oae_remarks'] : '';
    		}
    		if (isset($input['diagnostic_abr_options']) && is_array($input['diagnostic_abr_options']) && count($input['diagnostic_abr_options']) > 0) {
    			$screening['diagnostic_abr_options'] = isset($input['diagnostic_abr_options']) ? json_encode($input['diagnostic_abr_options']) : json_encode([]);
    			$screening['diagnostic_abr_date'] = (isset($input['diagnostic_abr_date']) && !empty($input['diagnostic_abr_date']) && $input['diagnostic_abr_date'] != 'N/A') ? date('Y-m-d', strtotime($input['diagnostic_abr_date'])) : null;
    			$screening['diagnostic_abr_pna_ca'] = isset($input['diagnostic_abr_pna_ca']) ? $input['diagnostic_abr_pna_ca'] : '';
    			$screening['diagnostic_abr_right_hand_side'] = isset($input['diagnostic_abr_right_hand_side']) ? $input['diagnostic_abr_right_hand_side'] : '';
    			$screening['diagnostic_abr_left_hand_side'] = isset($input['diagnostic_abr_left_hand_side']) ? $input['diagnostic_abr_left_hand_side'] : '';
    			$screening['diagnostic_abr_remarks'] = isset($input['diagnostic_abr_remarks']) ? $input['diagnostic_abr_remarks'] : '';
    			$screening['diagnostic_cpa_date'] = (isset($input['diagnostic_cpa_date']) && !empty($input['diagnostic_cpa_date']) && $input['diagnostic_cpa_date'] != 'N/A') ? date('Y-m-d', strtotime($input['diagnostic_cpa_date'])) : null;
    			$screening['diagnostic_cpa_pna_ca'] = isset($input['diagnostic_cpa_pna_ca']) ? $input['diagnostic_cpa_pna_ca'] : '';
    			$screening['diagnostic_cpa_right_hand_side'] = isset($input['diagnostic_cpa_right_hand_side']) ? $input['diagnostic_cpa_right_hand_side'] : '';
    			$screening['diagnostic_cpa_left_hand_side'] = isset($input['diagnostic_cpa_left_hand_side']) ? $input['diagnostic_cpa_left_hand_side'] : '';
    			$screening['diagnostic_cpa_remarks'] = isset($input['diagnostic_cpa_remarks']) ? $input['diagnostic_cpa_remarks'] : '';
    		}

    		$check_screening_exist = NeuroScreening::where('neuro_visit_id', $neuro_visit_id)->first();

    		if (count($check_screening_exist) > 0 && isset($check_screening_exist->id))
    		{
    			$screening['modified_date_time'] = Carbon::now(env('TIME_ZONE'));
    			$screening['modified_user'] = $this->auth->user()->id;
    			NeuroScreening::where('id', $check_screening_exist->id)->update($screening);
    		}
    		else
    		{
    			$screening['created_date_time'] = Carbon::now(env('TIME_ZONE'));
    			$screening['created_user'] = $this->auth->user()->id;
    			$screening['baby_id'] = $baby_id;
    			$screening['neuro_visit_id'] = $neuro_visit_id;
    			$screening['visit_date'] = $visit_date;
    			NeuroScreening::insert($screening);
    		}

    	}
    }

    // Muscle tone norms
    public function storeMuscleTone($input, $baby_id, $neuro_visit_id, $visit_date)
    {
    	if (isset($input['date_of_assessment_0_3']) || isset($input['date_of_assessment_4_6']) || isset($input['date_of_assessment_7_9']) || isset($input['date_of_assessment_10_12']))
    	{
            $visit_date = date('Y-m-d', strtotime($visit_date));
    		$muscle_tone_norms['date_of_assessment_0_3'] = (isset($input['date_of_assessment_0_3']) && !empty($input['date_of_assessment_0_3'])) ? date('Y-m-d', strtotime($input['date_of_assessment_0_3'])) : null;
    		$muscle_tone_norms['pna_ca_assessment_0_3'] = (isset($input['pna_ca_assessment_0_3'])) ? $input['pna_ca_assessment_0_3'] : '';
    		$muscle_tone_norms['adductor_as_assessed_left_0_3'] = (isset($input['adductor_as_assessed_left_0_3'])) ? $input['adductor_as_assessed_left_0_3'] : '';
    		$muscle_tone_norms['adductor_as_assessed_right_0_3'] = (isset($input['adductor_as_assessed_right_0_3'])) ? $input['adductor_as_assessed_right_0_3'] : '';
    		$muscle_tone_norms['popliteal_as_assessed_left_0_3'] = (isset($input['popliteal_as_assessed_left_0_3'])) ? $input['popliteal_as_assessed_left_0_3'] : '';
    		$muscle_tone_norms['popliteal_as_assessed_right_0_3'] = (isset($input['popliteal_as_assessed_right_0_3'])) ? $input['popliteal_as_assessed_right_0_3'] : '';
    		$muscle_tone_norms['dorsiflexion_as_assessed_left_0_3'] = (isset($input['dorsiflexion_as_assessed_left_0_3'])) ? $input['dorsiflexion_as_assessed_left_0_3'] : '';
    		$muscle_tone_norms['dorsiflexion_as_assessed_right_0_3'] = (isset($input['dorsiflexion_as_assessed_right_0_3'])) ? $input['dorsiflexion_as_assessed_right_0_3'] : '';
    		$muscle_tone_norms['elbow_not_cross_midline_left_0_3'] = (isset($input['elbow_not_cross_midline_left_0_3'])) ? $input['elbow_not_cross_midline_left_0_3'] : 0;
    		$muscle_tone_norms['elbow_not_cross_midline_right_0_3'] = (isset($input['elbow_not_cross_midline_right_0_3'])) ? $input['elbow_not_cross_midline_right_0_3'] : 0;
    		$muscle_tone_norms['elbow_cross_midline_left_0_3'] = (isset($input['elbow_cross_midline_left_0_3'])) ? $input['elbow_cross_midline_left_0_3'] : 0;
    		$muscle_tone_norms['elbow_cross_midline_right_0_3'] = (isset($input['elbow_cross_midline_right_0_3'])) ? $input['elbow_cross_midline_right_0_3'] : 0;
    		$muscle_tone_norms['elbow_goes_beyond_axillary_line_left_0_3'] = (isset($input['elbow_goes_beyond_axillary_line_left_0_3'])) ? $input['elbow_goes_beyond_axillary_line_left_0_3'] : 0;
    		$muscle_tone_norms['elbow_goes_beyond_axillary_line_right_0_3'] = (isset($input['elbow_goes_beyond_axillary_line_right_0_3'])) ? $input['elbow_goes_beyond_axillary_line_right_0_3'] : 0;

    		$muscle_tone_norms['date_of_assessment_4_6'] = (isset($input['date_of_assessment_4_6']) && !empty($input['date_of_assessment_4_6'])) ? date('Y-m-d', strtotime($input['date_of_assessment_4_6'])) : null;
    		$muscle_tone_norms['pna_ca_assessment_4_6'] = (isset($input['pna_ca_assessment_4_6'])) ? $input['pna_ca_assessment_4_6'] : '';
    		$muscle_tone_norms['adductor_as_assessed_left_4_6'] = (isset($input['adductor_as_assessed_left_4_6'])) ? $input['adductor_as_assessed_left_4_6'] : '';
    		$muscle_tone_norms['adductor_as_assessed_right_4_6'] = (isset($input['adductor_as_assessed_right_4_6'])) ? $input['adductor_as_assessed_right_4_6'] : '';
    		$muscle_tone_norms['popliteal_as_assessed_left_4_6'] = (isset($input['popliteal_as_assessed_left_4_6'])) ? $input['popliteal_as_assessed_left_4_6'] : '';
    		$muscle_tone_norms['popliteal_as_assessed_right_4_6'] = (isset($input['popliteal_as_assessed_right_4_6'])) ? $input['popliteal_as_assessed_right_4_6'] : '';
    		$muscle_tone_norms['dorsiflexion_as_assessed_left_4_6'] = (isset($input['dorsiflexion_as_assessed_left_4_6'])) ? $input['dorsiflexion_as_assessed_left_4_6'] : '';
    		$muscle_tone_norms['dorsiflexion_as_assessed_right_4_6'] = (isset($input['dorsiflexion_as_assessed_right_4_6'])) ? $input['dorsiflexion_as_assessed_right_4_6'] : '';
    		$muscle_tone_norms['elbow_not_cross_midline_left_4_6'] = (isset($input['elbow_not_cross_midline_left_4_6'])) ? $input['elbow_not_cross_midline_left_4_6'] : 0;
    		$muscle_tone_norms['elbow_not_cross_midline_right_4_6'] = (isset($input['elbow_not_cross_midline_right_4_6'])) ? $input['elbow_not_cross_midline_right_4_6'] : 0;
    		$muscle_tone_norms['elbow_cross_midline_left_4_6'] = (isset($input['elbow_cross_midline_left_4_6'])) ? $input['elbow_cross_midline_left_4_6'] : 0;
    		$muscle_tone_norms['elbow_cross_midline_right_4_6'] = (isset($input['elbow_cross_midline_right_4_6'])) ? $input['elbow_cross_midline_right_4_6'] : 0;
    		$muscle_tone_norms['elbow_goes_beyond_axillary_line_left_4_6'] = (isset($input['elbow_goes_beyond_axillary_line_left_4_6'])) ? $input['elbow_goes_beyond_axillary_line_left_4_6'] : 0;
    		$muscle_tone_norms['elbow_goes_beyond_axillary_line_right_4_6'] = (isset($input['elbow_goes_beyond_axillary_line_right_4_6'])) ? $input['elbow_goes_beyond_axillary_line_right_4_6'] : 0;

    		$muscle_tone_norms['date_of_assessment_7_9'] = (isset($input['date_of_assessment_7_9']) && !empty($input['date_of_assessment_7_9'])) ? date('Y-m-d', strtotime($input['date_of_assessment_7_9'])) : null;
    		$muscle_tone_norms['pna_ca_assessment_7_9'] = (isset($input['pna_ca_assessment_7_9'])) ? $input['pna_ca_assessment_7_9'] : '';
    		$muscle_tone_norms['adductor_as_assessed_left_7_9'] = (isset($input['adductor_as_assessed_left_7_9'])) ? $input['adductor_as_assessed_left_7_9'] : '';
    		$muscle_tone_norms['adductor_as_assessed_right_7_9'] = (isset($input['adductor_as_assessed_right_7_9'])) ? $input['adductor_as_assessed_right_7_9'] : '';
    		$muscle_tone_norms['popliteal_as_assessed_left_7_9'] = (isset($input['popliteal_as_assessed_left_7_9'])) ? $input['popliteal_as_assessed_left_7_9'] : '';
    		$muscle_tone_norms['popliteal_as_assessed_right_7_9'] = (isset($input['popliteal_as_assessed_right_7_9'])) ? $input['popliteal_as_assessed_right_7_9'] : '';
    		$muscle_tone_norms['dorsiflexion_as_assessed_left_7_9'] = (isset($input['dorsiflexion_as_assessed_left_7_9'])) ? $input['dorsiflexion_as_assessed_left_7_9'] : '';
    		$muscle_tone_norms['dorsiflexion_as_assessed_right_7_9'] = (isset($input['dorsiflexion_as_assessed_right_7_9'])) ? $input['dorsiflexion_as_assessed_right_7_9'] : '';
    		$muscle_tone_norms['elbow_not_cross_midline_left_7_9'] = (isset($input['elbow_not_cross_midline_left_7_9'])) ? $input['elbow_not_cross_midline_left_7_9'] : 0;
    		$muscle_tone_norms['elbow_not_cross_midline_right_7_9'] = (isset($input['elbow_not_cross_midline_right_7_9'])) ? $input['elbow_not_cross_midline_right_7_9'] : 0;
    		$muscle_tone_norms['elbow_cross_midline_left_7_9'] = (isset($input['elbow_cross_midline_left_7_9'])) ? $input['elbow_cross_midline_left_7_9'] : 0;
    		$muscle_tone_norms['elbow_cross_midline_right_7_9'] = (isset($input['elbow_cross_midline_right_7_9'])) ? $input['elbow_cross_midline_right_7_9'] : 0;
    		$muscle_tone_norms['elbow_goes_beyond_axillary_line_left_7_9'] = (isset($input['elbow_goes_beyond_axillary_line_left_7_9'])) ? $input['elbow_goes_beyond_axillary_line_left_7_9'] : 0;
    		$muscle_tone_norms['elbow_goes_beyond_axillary_line_right_7_9'] = (isset($input['elbow_goes_beyond_axillary_line_right_7_9'])) ? $input['elbow_goes_beyond_axillary_line_right_7_9'] : 0;

    		$muscle_tone_norms['date_of_assessment_10_12'] = (isset($input['date_of_assessment_10_12']) && !empty($input['date_of_assessment_10_12'])) ? date('Y-m-d', strtotime($input['date_of_assessment_10_12'])) : null;
    		$muscle_tone_norms['pna_ca_assessment_10_12'] = (isset($input['pna_ca_assessment_10_12'])) ? $input['pna_ca_assessment_10_12'] : '';
    		$muscle_tone_norms['adductor_as_assessed_left_10_12'] = (isset($input['adductor_as_assessed_left_10_12'])) ? $input['adductor_as_assessed_left_10_12'] : '';
    		$muscle_tone_norms['adductor_as_assessed_right_10_12'] = (isset($input['adductor_as_assessed_right_10_12'])) ? $input['adductor_as_assessed_right_10_12'] : '';
    		$muscle_tone_norms['popliteal_as_assessed_left_10_12'] = (isset($input['popliteal_as_assessed_left_10_12'])) ? $input['popliteal_as_assessed_left_10_12'] : '';
    		$muscle_tone_norms['popliteal_as_assessed_right_10_12'] = (isset($input['popliteal_as_assessed_right_10_12'])) ? $input['popliteal_as_assessed_right_10_12'] : '';
    		$muscle_tone_norms['dorsiflexion_as_assessed_left_10_12'] = (isset($input['dorsiflexion_as_assessed_left_10_12'])) ? $input['dorsiflexion_as_assessed_left_10_12'] : '';
    		$muscle_tone_norms['dorsiflexion_as_assessed_right_10_12'] = (isset($input['dorsiflexion_as_assessed_right_10_12'])) ? $input['dorsiflexion_as_assessed_right_10_12'] : '';
    		$muscle_tone_norms['elbow_not_cross_midline_left_10_12'] = (isset($input['elbow_not_cross_midline_left_10_12'])) ? $input['elbow_not_cross_midline_left_10_12'] : 0;
    		$muscle_tone_norms['elbow_not_cross_midline_right_10_12'] = (isset($input['elbow_not_cross_midline_right_10_12'])) ? $input['elbow_not_cross_midline_right_10_12'] : 0;
    		$muscle_tone_norms['elbow_cross_midline_left_10_12'] = (isset($input['elbow_cross_midline_left_10_12'])) ? $input['elbow_cross_midline_left_10_12'] : 0;
    		$muscle_tone_norms['elbow_cross_midline_right_10_12'] = (isset($input['elbow_cross_midline_right_10_12'])) ? $input['elbow_cross_midline_right_10_12'] : 0;
    		$muscle_tone_norms['elbow_goes_beyond_axillary_line_left_10_12'] = (isset($input['elbow_goes_beyond_axillary_line_left_10_12'])) ? $input['elbow_goes_beyond_axillary_line_left_10_12'] : 0;
    		$muscle_tone_norms['elbow_goes_beyond_axillary_line_right_10_12'] = (isset($input['elbow_goes_beyond_axillary_line_right_10_12'])) ? $input['elbow_goes_beyond_axillary_line_right_10_12'] : 0;

    		$check_muscle_tone_norms_exist = NeuroMuscleToneNorms::where('neuro_visit_id', $neuro_visit_id)->first();

    		if (count($check_muscle_tone_norms_exist) > 0 && isset($check_muscle_tone_norms_exist->id))
    		{
    			$muscle_tone_norms['modified_date_time'] = Carbon::now(env('TIME_ZONE'));
    			$muscle_tone_norms['modified_user'] = $this->auth->user()->id;
    			NeuroMuscleToneNorms::where('id', $check_muscle_tone_norms_exist->id)->update($muscle_tone_norms);
    		}
    		else
    		{
    			$muscle_tone_norms['baby_id'] = $baby_id;
    			$muscle_tone_norms['neuro_visit_id'] = $neuro_visit_id;
    			$muscle_tone_norms['visit_date'] = $visit_date;
    			$muscle_tone_norms['created_date_time'] = Carbon::now(env('TIME_ZONE'));
    			$muscle_tone_norms['created_user'] = $this->auth->user()->id;
    			NeuroMuscleToneNorms::insert($muscle_tone_norms);
    			Op::where('OpId', $neuro_visit_id)->update(['screening_exist' => true]);
    		}

    	}
    }

    public function storeHnneDetails($input, $id, $op_date)
    {

    	$hnne_details['posture_score'] = !empty($input['posture_score']) ? trim($input['posture_score']) : 0;
    	$hnne_details['arm_recoil_score'] = !empty($input['arm_recoil_score']) ? trim($input['arm_recoil_score']) : 0;
    	$hnne_details['arm_traction_score'] = !empty($input['arm_traction_score']) ? trim($input['arm_traction_score']) : 0;
    	$hnne_details['leg_recoil_score'] = !empty($input['leg_recoil_score']) ? trim($input['leg_recoil_score']) : 0;
    	$hnne_details['leg_traction_score'] = !empty($input['leg_traction_score']) ? trim($input['leg_traction_score']) : 0;
    	$hnne_details['popliteal_angle_score'] = !empty($input['popliteal_angle_score']) ? trim($input['popliteal_angle_score']) : 0;
    	$hnne_details['head_control_score'] = !empty($input['head_control_score']) ? trim($input['head_control_score']) : 0;
    	$hnne_details['head_control_2_score'] = !empty($input['head_control_2_score']) ? trim($input['head_control_2_score']) : 0;
    	$hnne_details['head_lag_score'] = !empty($input['head_lag_score']) ? trim($input['head_lag_score']) : 0;
    	$hnne_details['ventral_suspension_score'] = !empty($input['ventral_suspension_score']) ? trim($input['ventral_suspension_score']) : 0;
    	$hnne_details['flexor_tone_score'] = !empty($input['flexor_tone_score']) ? trim($input['flexor_tone_score']) : 0;
    	$hnne_details['flexor_tone_resting_posture_score'] = !empty($input['flexor_tone_resting_posture_score']) ? trim($input['flexor_tone_resting_posture_score']) : 0;
    	$hnne_details['leg_tone_score'] = !empty($input['leg_tone_score']) ? trim($input['leg_tone_score']) : 0;
    	$hnne_details['head_control_sitting_score'] = !empty($input['head_control_sitting_score']) ? trim($input['head_control_sitting_score']) : 0;
    	$hnne_details['neck_axial_tone_score'] = !empty($input['neck_axial_tone_score']) ? trim($input['neck_axial_tone_score']) : 0;
    	$hnne_details['tendon_reflex_score'] = !empty($input['tendon_reflex_score']) ? trim($input['tendon_reflex_score']) : 0;
    	$hnne_details['suck_gag_score'] = !empty($input['suck_gag_score']) ? trim($input['suck_gag_score']) : 0;
    	$hnne_details['palmar_grasp_score'] = !empty($input['palmar_grasp_score']) ? trim($input['palmar_grasp_score']) : 0;
    	$hnne_details['plantar_grasp_score'] = !empty($input['plantar_grasp_score']) ? trim($input['plantar_grasp_score']) : 0;
    	$hnne_details['placing_score'] = !empty($input['placing_score']) ? trim($input['placing_score']) : 0;
    	$hnne_details['moro_reflex_score'] = !empty($input['moro_reflex_score']) ? trim($input['moro_reflex_score']) : 0;
    	$hnne_details['spontaneous_movements_score'] = !empty($input['spontaneous_movements_score']) ? trim($input['spontaneous_movements_score']) : 0;
    	$hnne_details['spontaneous_movements_quality_score'] = !empty($input['spontaneous_movements_quality_score']) ? trim($input['spontaneous_movements_quality_score']) : 0;
    	$hnne_details['head_raising_score'] = !empty($input['head_raising_score']) ? trim($input['head_raising_score']) : 0;
    	$hnne_details['abn_hand_toe_postures_score'] = !empty($input['abn_hand_toe_postures_score']) ? trim($input['abn_hand_toe_postures_score']) : 0;
    	$hnne_details['tremor_score'] = !empty($input['tremor_score']) ? trim($input['tremor_score']) : 0;
    	$hnne_details['startle_score'] = !empty($input['startle_score']) ? trim($input['startle_score']) : 0;
    	$hnne_details['eye_appearance_score'] = !empty($input['eye_appearance_score']) ? trim($input['eye_appearance_score']) : 0;
    	$hnne_details['auditory_orientation_score'] = !empty($input['auditory_orientation_score']) ? trim($input['auditory_orientation_score']) : 0;
    	$hnne_details['visual_orientation_score'] = !empty($input['visual_orientation_score']) ? trim($input['visual_orientation_score']) : 0;
    	$hnne_details['alertness_score'] = !empty($input['alertness_score']) ? trim($input['alertness_score']) : 0;
    	$hnne_details['irritability_score'] = !empty($input['irritability_score']) ? trim($input['irritability_score']) : 0;
    	$hnne_details['consolability_score'] = !empty($input['consolability_score']) ? trim($input['consolability_score']) : 0;
    	$hnne_details['cry_score'] = !empty($input['cry_score']) ? trim($input['cry_score']) : 0;
    	$hnne_details['posture_asymmetric'] = (isset($input['posture_asymmetric']) && !empty($input['posture_asymmetric'])) ? $input['posture_asymmetric'] : null;
    	$hnne_details['arm_recoil_asymmetric'] = (isset($input['arm_recoil_asymmetric']) && !empty($input['arm_recoil_asymmetric'])) ? $input['arm_recoil_asymmetric'] : null;
    	$hnne_details['arm_traction_asymmetric'] = (isset($input['arm_traction_asymmetric']) && !empty($input['arm_traction_asymmetric'])) ? $input['arm_traction_asymmetric'] : null;
    	$hnne_details['leg_recoil_asymmetric'] = (isset($input['leg_recoil_asymmetric']) && !empty($input['leg_recoil_asymmetric'])) ? $input['leg_recoil_asymmetric'] : null;
    	$hnne_details['leg_traction_asymmetric'] = (isset($input['leg_traction_asymmetric']) && !empty($input['leg_traction_asymmetric'])) ? $input['leg_traction_asymmetric'] : null;
    	$hnne_details['popliteal_angle_asymmetric'] = (isset($input['popliteal_angle_asymmetric']) && !empty($input['popliteal_angle_asymmetric'])) ? $input['popliteal_angle_asymmetric'] : null;
    	$hnne_details['head_control_asymmetric'] = (isset($input['head_control_asymmetric']) && !empty($input['head_control_asymmetric'])) ? $input['head_control_asymmetric'] : null;
    	$hnne_details['head_control_2_asymmetric'] = (isset($input['head_control_2_asymmetric']) && !empty($input['head_control_2_asymmetric'])) ? $input['head_control_2_asymmetric'] : null;
    	$hnne_details['head_lag_asymmetric'] = (isset($input['head_lag_asymmetric']) && !empty($input['head_lag_asymmetric'])) ? $input['head_lag_asymmetric'] : null;
    	$hnne_details['ventral_suspension_asymmetric'] = (isset($input['ventral_suspension_asymmetric']) && !empty($input['ventral_suspension_asymmetric'])) ? $input['ventral_suspension_asymmetric'] : null;
    	$hnne_details['flexor_tone_asymmetric'] = (isset($input['flexor_tone_asymmetric']) && !empty($input['flexor_tone_asymmetric'])) ? $input['flexor_tone_asymmetric'] : null;
    	$hnne_details['flexor_tone_resting_asymmetric'] = (isset($input['flexor_tone_resting_asymmetric']) && !empty($input['flexor_tone_resting_asymmetric'])) ? $input['flexor_tone_resting_asymmetric'] : null;
    	$hnne_details['leg_tone_asymmetric'] = (isset($input['leg_tone_asymmetric']) && !empty($input['leg_tone_asymmetric'])) ? $input['leg_tone_asymmetric'] : null;
    	$hnne_details['head_control_sitting_asymmetric'] = (isset($input['head_control_sitting_asymmetric']) && !empty($input['head_control_sitting_asymmetric'])) ? $input['head_control_sitting_asymmetric'] : null;
    	$hnne_details['neck_axial_tone_asymmetric'] = (isset($input['neck_axial_tone_asymmetric']) && !empty($input['neck_axial_tone_asymmetric'])) ? $input['neck_axial_tone_asymmetric'] : null;
    	$hnne_details['tendon_reflex_asymmetric'] = (isset($input['tendon_reflex_asymmetric']) && !empty($input['tendon_reflex_asymmetric'])) ? $input['tendon_reflex_asymmetric'] : null;
    	$hnne_details['suck_gag_asymmetric'] = (isset($input['suck_gag_asymmetric']) && !empty($input['suck_gag_asymmetric'])) ? $input['suck_gag_asymmetric'] : null;
    	$hnne_details['palmar_grasp_asymmetric'] = (isset($input['palmar_grasp_asymmetric']) && !empty($input['palmar_grasp_asymmetric'])) ? $input['palmar_grasp_asymmetric'] : null;
    	$hnne_details['plantar_grasp_asymmetric'] = (isset($input['plantar_grasp_asymmetric']) && !empty($input['plantar_grasp_asymmetric'])) ? $input['plantar_grasp_asymmetric'] : null;
    	$hnne_details['placing_asymmetric'] = (isset($input['placing_asymmetric']) && !empty($input['placing_asymmetric'])) ? $input['placing_asymmetric'] : null;
    	$hnne_details['moro_reflex_asymmetric'] = (isset($input['moro_reflex_asymmetric']) && !empty($input['moro_reflex_asymmetric'])) ? $input['moro_reflex_asymmetric'] : null;
    	$hnne_details['spontaneous_movements_asymmetric'] = (isset($input['spontaneous_movements_asymmetric']) && !empty($input['spontaneous_movements_asymmetric'])) ? $input['spontaneous_movements_asymmetric'] : null;
    	$hnne_details['spontaneous_movements_quality_asymmetric'] = (isset($input['spontaneous_movements_quality_asymmetric']) && !empty($input['spontaneous_movements_quality_asymmetric'])) ? $input['spontaneous_movements_quality_asymmetric'] : null;
    	$hnne_details['head_raising_asymmetric'] = (isset($input['head_raising_asymmetric']) && !empty($input['head_raising_asymmetric'])) ? $input['head_raising_asymmetric'] : null;
    	$hnne_details['abn_hand_toe_postures_asymmetric'] = (isset($input['abn_hand_toe_postures_asymmetric']) && !empty($input['abn_hand_toe_postures_asymmetric'])) ? $input['abn_hand_toe_postures_asymmetric'] : null;
    	$hnne_details['tremor_asymmetric'] = (isset($input['tremor_asymmetric']) && !empty($input['tremor_asymmetric'])) ? $input['tremor_asymmetric'] : null;
    	$hnne_details['startle_asymmetric'] = (isset($input['startle_asymmetric']) && !empty($input['startle_asymmetric'])) ? $input['startle_asymmetric'] : null;
    	$hnne_details['eye_appearance_asymmetric'] = (isset($input['eye_appearance_asymmetric']) && !empty($input['eye_appearance_asymmetric'])) ? $input['eye_appearance_asymmetric'] : null;
    	$hnne_details['auditory_orientation_asymmetric'] = (isset($input['auditory_orientation_asymmetric']) && !empty($input['auditory_orientation_asymmetric'])) ? $input['auditory_orientation_asymmetric'] : null;
    	$hnne_details['visual_orientation_asymmetric'] = (isset($input['visual_orientation_asymmetric']) && !empty($input['visual_orientation_asymmetric'])) ? $input['visual_orientation_asymmetric'] : null;
    	$hnne_details['alertness_asymmetric'] = (isset($input['alertness_asymmetric']) && !empty($input['alertness_asymmetric'])) ? $input['alertness_asymmetric'] : null;
    	$hnne_details['irritability_asymmetric'] = (isset($input['irritability_asymmetric']) && !empty($input['irritability_asymmetric'])) ? $input['irritability_asymmetric'] : null;
    	$hnne_details['consolability_asymmetric'] = (isset($input['consolability_asymmetric']) && !empty($input['consolability_asymmetric'])) ? $input['consolability_asymmetric'] : null;
    	$hnne_details['cry_asymmetric'] = (isset($input['cry_asymmetric']) && !empty($input['cry_asymmetric'])) ? $input['cry_asymmetric'] : null;
    	$hnne_details['posture'] = (isset($input['posture']) && is_array($input['posture'])) ? json_encode($input['posture']) : json_encode([]);
    	$hnne_details['tone_pattern_items'] = (isset($input['tone_pattern_items']) && is_array($input['tone_pattern_items'])) ? json_encode($input['tone_pattern_items']) : json_encode([]);
    	$hnne_details['reflex_items'] = (isset($input['reflex_items']) && is_array($input['reflex_items'])) ? json_encode($input['reflex_items']) : json_encode([]);
    	$hnne_details['movements'] = (isset($input['movements']) && is_array($input['movements'])) ? json_encode($input['movements']) : json_encode([]);
    	$hnne_details['abnormal_signs'] = (isset($input['abnormal_signs']) && is_array($input['abnormal_signs'])) ? json_encode($input['abnormal_signs']) : json_encode([]);
    	$hnne_details['behavioural_signs'] = (isset($input['behavioural_signs']) && is_array($input['behavioural_signs'])) ? json_encode($input['behavioural_signs']) : json_encode([]);
    	$hnne_details['modified_date_time'] = date('Y-m-d H:i:s');
    	$hnne_details['modified_user'] = \Auth::user()->id;
    	$hnne_details['total_hnne_score'] = !empty($input['total_hnne_score']) ? trim($input['total_hnne_score']) : 0;
    	$hnne_details['posture_status'] = isset($input['posture_status']) ? $input['posture_status'] : null;
    	$hnne_details['arm_recoil_status'] = isset($input['arm_recoil_status']) ? $input['arm_recoil_status'] : null;
    	$hnne_details['arm_traction_status'] = isset($input['arm_traction_status']) ? $input['arm_traction_status'] : null;
    	$hnne_details['leg_recoil_status'] = isset($input['leg_recoil_status']) ? $input['leg_recoil_status'] : null;
    	$hnne_details['leg_traction_status'] = isset($input['leg_traction_status']) ? $input['leg_traction_status'] : null;
    	$hnne_details['popliteal_angle_status'] = isset($input['popliteal_angle_status']) ? $input['popliteal_angle_status'] : null;
    	$hnne_details['head_control_status'] = isset($input['head_control_status']) ? $input['head_control_status'] : null;
    	$hnne_details['head_control_2_status'] = isset($input['head_control_2_status']) ? $input['head_control_2_status'] : null;
    	$hnne_details['head_lag_status'] = isset($input['head_lag_status']) ? $input['head_lag_status'] : null;
    	$hnne_details['ventral_suspension_status'] = isset($input['ventral_suspension_status']) ? $input['ventral_suspension_status'] : null;
    	$hnne_details['flexor_tone_status'] = isset($input['flexor_tone_status']) ? $input['flexor_tone_status'] : null;
    	$hnne_details['flexor_tone_resting_posture_status'] = isset($input['flexor_tone_resting_posture_status']) ? $input['flexor_tone_resting_posture_status'] : null;
    	$hnne_details['leg_tone_status'] = isset($input['leg_tone_status']) ? $input['leg_tone_status'] : null;
    	$hnne_details['head_control_sitting_status'] = isset($input['head_control_sitting_status']) ? $input['head_control_sitting_status'] : null;
    	$hnne_details['neck_axial_tone_status'] = isset($input['neck_axial_tone_status']) ? $input['neck_axial_tone_status'] : null;
    	$hnne_details['tendon_reflex_status'] = isset($input['tendon_reflex_status']) ? $input['tendon_reflex_status'] : null;
    	$hnne_details['suck_gag_status'] = isset($input['suck_gag_status']) ? $input['suck_gag_status'] : null;
    	$hnne_details['palmar_grasp_status'] = isset($input['palmar_grasp_status']) ? $input['palmar_grasp_status'] : null;
    	$hnne_details['plantar_grasp_status'] = isset($input['plantar_grasp_status']) ? $input['plantar_grasp_status'] : null;
    	$hnne_details['placing_status'] = isset($input['placing_status']) ? $input['placing_status'] : null;
    	$hnne_details['moro_reflex_status'] = isset($input['moro_reflex_status']) ? $input['moro_reflex_status'] : null;
    	$hnne_details['spontaneous_movements_status'] = isset($input['spontaneous_movements_status']) ? $input['spontaneous_movements_status'] : null;
    	$hnne_details['spontaneous_movements_quality_status'] = isset($input['spontaneous_movements_quality_status']) ? $input['spontaneous_movements_quality_status'] : null;
    	$hnne_details['head_raising_status'] = isset($input['head_raising_status']) ? $input['head_raising_status'] : null;
    	$hnne_details['abn_hand_toe_postures_status'] = isset($input['abn_hand_toe_postures_status']) ? $input['abn_hand_toe_postures_status'] : null;
    	$hnne_details['tremor_status'] = isset($input['tremor_status']) ? $input['tremor_status'] : null;
    	$hnne_details['startle_status'] = isset($input['startle_status']) ? $input['startle_status'] : null;
    	$hnne_details['eye_appearance_status'] = isset($input['eye_appearance_status']) ? $input['eye_appearance_status'] : null;
    	$hnne_details['auditory_orientation_status'] = isset($input['auditory_orientation_status']) ? $input['auditory_orientation_status'] : null;
    	$hnne_details['visual_orientation_status'] = isset($input['visual_orientation_status']) ? $input['visual_orientation_status'] : null;
    	$hnne_details['alertness_status'] = isset($input['alertness_status']) ? $input['alertness_status'] : null;
    	$hnne_details['irritability_status'] = isset($input['irritability_status']) ? $input['irritability_status'] : null;
    	$hnne_details['consolability_status'] = isset($input['consolability_status']) ? $input['consolability_status'] : null;
    	$hnne_details['cry_status'] = isset($input['cry_status']) ? $input['cry_status'] : nul;

    	$check_hnne_details_exist = \DB::table('hnne_details')->where('neuro_visit_id', $id)->first();
    	if (count($check_hnne_details_exist) > 0 && isset($check_hnne_details_exist->id))
    	{
    		$hnne_details['modified_date_time'] = date('Y-m-d H:i:s');
    		$hnne_details['modified_user'] = \Auth::user()->id;
    		$test = \DB::table('hnne_details')->where('id', $check_hnne_details_exist->id)->update($hnne_details);
    	}
    	else
    	{
    		$hnne_details['created_date_time'] = date('Y-m-d H:i:s');
    		$hnne_details['created_user'] = \Auth::user()->id;
    		$hnne_details['neuro_visit_id'] = $id;
    		$hnne_details['visit_date'] = date('Y-m-d', strtotime($op_date));
    		$hnne_details['baby_id'] = $input['BabyId'];

    		\DB::table('hnne_details')->insert($hnne_details);
    	}
    }

    public function storeHineDetails($input, $id, $op_date)
    {

    	$hine_details['hine_facial_appearance'] = (isset($input['hine_facial_appearance']) && !empty($input['hine_facial_appearance'])) ? $input['hine_facial_appearance'] : null;
    	$hine_details['hine_eye_movements'] = (isset($input['hine_eye_movements']) && !empty($input['hine_eye_movements'])) ? $input['hine_eye_movements'] : null;
    	$hine_details['hine_visual_response'] = (isset($input['hine_visual_response']) && !empty($input['hine_visual_response'])) ? $input['hine_visual_response'] : null;
    	$hine_details['hine_auditory_response'] = (isset($input['hine_auditory_response']) && !empty($input['hine_auditory_response'])) ? $input['hine_auditory_response'] : null;
    	$hine_details['hine_sucking_swallowing'] = (isset($input['hine_sucking_swallowing']) && !empty($input['hine_sucking_swallowing'])) ? $input['hine_sucking_swallowing'] : null;
    	$hine_details['hine_head'] = (isset($input['hine_head']) && !empty($input['hine_head'])) ? $input['hine_head'] : null;
    	$hine_details['hine_trunk'] = (isset($input['hine_trunk']) && !empty($input['hine_trunk'])) ? $input['hine_trunk'] : null;
    	$hine_details['hine_arms'] = (isset($input['hine_arms']) && !empty($input['hine_arms'])) ? $input['hine_arms'] : null;
    	$hine_details['hine_hands'] = (isset($input['hine_hands']) && !empty($input['hine_hands'])) ? $input['hine_hands'] : null;
    	$hine_details['hine_legs'] = (isset($input['hine_legs']) && !empty($input['hine_legs'])) ? $input['hine_legs'] : null;
    	$hine_details['hine_feet'] = (isset($input['hine_feet']) && !empty($input['hine_feet'])) ? $input['hine_feet'] : null;
    	$hine_details['hine_quantity'] = (isset($input['hine_quantity']) && !empty($input['hine_quantity'])) ? $input['hine_quantity'] : null;
    	$hine_details['hine_quality'] = (isset($input['hine_quality']) && !empty($input['hine_quality'])) ? $input['hine_quality'] : null;
    	$hine_details['hine_scraf_sign'] = (isset($input['hine_scraf_sign']) && !empty($input['hine_scraf_sign'])) ? $input['hine_scraf_sign'] : null;
    	$hine_details['hine_shoulder_elevation'] = (isset($input['hine_shoulder_elevation']) && !empty($input['hine_shoulder_elevation'])) ? $input['hine_shoulder_elevation'] : null;
    	$hine_details['hine_pronation_supination'] = (isset($input['hine_pronation_supination']) && !empty($input['hine_pronation_supination'])) ? $input['hine_pronation_supination'] : null;
    	$hine_details['hine_hip_adductors'] = (isset($input['hine_hip_adductors']) && !empty($input['hine_hip_adductors'])) ? $input['hine_hip_adductors'] : null;
    	$hine_details['hine_popliteal_angle'] = (isset($input['hine_popliteal_angle']) && !empty($input['hine_popliteal_angle'])) ? $input['hine_popliteal_angle'] : null;
    	$hine_details['hine_ankle_dorsiflexion'] = (isset($input['hine_ankle_dorsiflexion']) && !empty($input['hine_ankle_dorsiflexion'])) ? $input['hine_ankle_dorsiflexion'] : null;
    	$hine_details['hine_pull_to_sit'] = (isset($input['hine_pull_to_sit']) && !empty($input['hine_pull_to_sit'])) ? $input['hine_pull_to_sit'] : null;
    	$hine_details['hine_ventral_suspension'] = (isset($input['hine_ventral_suspension']) && !empty($input['hine_ventral_suspension'])) ? $input['hine_ventral_suspension'] : null;
    	$hine_details['hine_arm_production'] = (isset($input['hine_arm_production']) && !empty($input['hine_arm_production'])) ? $input['hine_arm_production'] : null;
    	$hine_details['hine_vertical_suspension'] = (isset($input['hine_vertical_suspension']) && !empty($input['hine_vertical_suspension'])) ? $input['hine_vertical_suspension'] : null;
    	$hine_details['hine_lateral_tilting'] = (isset($input['hine_lateral_tilting']) && !empty($input['hine_lateral_tilting'])) ? $input['hine_lateral_tilting'] : null;
    	$hine_details['hine_forward_parachute'] = (isset($input['hine_forward_parachute']) && !empty($input['hine_forward_parachute'])) ? $input['hine_forward_parachute'] : null;
    	$hine_details['hine_tendon_reflexes'] = (isset($input['hine_tendon_reflexes']) && !empty($input['hine_tendon_reflexes'])) ? $input['hine_tendon_reflexes'] : null;
    	$hine_details['hine_head_control'] = (isset($input['hine_head_control']) && !empty($input['hine_head_control'])) ? $input['hine_head_control'] : null;
    	$hine_details['hine_sitting'] = (isset($input['hine_sitting']) && !empty($input['hine_sitting'])) ? $input['hine_sitting'] : null;
    	$hine_details['hine_voluntary_grasp'] = (isset($input['hine_voluntary_grasp']) && !empty($input['hine_voluntary_grasp'])) ? $input['hine_voluntary_grasp'] : null;
    	$hine_details['hine_ability_to_kick'] = (isset($input['hine_ability_to_kick']) && !empty($input['hine_ability_to_kick'])) ? $input['hine_ability_to_kick'] : null;
    	$hine_details['hine_rolling'] = (isset($input['hine_rolling']) && !empty($input['hine_rolling'])) ? $input['hine_rolling'] : null;
    	$hine_details['hine_crawling'] = (isset($input['hine_crawling']) && !empty($input['hine_crawling'])) ? $input['hine_crawling'] : null;
    	$hine_details['hine_standing'] = (isset($input['hine_standing']) && !empty($input['hine_standing'])) ? $input['hine_standing'] : null;
    	$hine_details['hine_walking'] = (isset($input['hine_walking']) && !empty($input['hine_walking'])) ? $input['hine_walking'] : null;
    	$hine_details['hine_conscious_state'] = (isset($input['hine_conscious_state']) && !empty($input['hine_conscious_state'])) ? $input['hine_conscious_state'] : null;
    	$hine_details['hine_emotional_state'] = (isset($input['hine_emotional_state']) && !empty($input['hine_emotional_state'])) ? $input['hine_emotional_state'] : null;
    	$hine_details['hine_social_orientation'] = (isset($input['hine_social_orientation']) && !empty($input['hine_social_orientation'])) ? $input['hine_social_orientation'] : null;

    	$hine_details['hine_facial_asymmetric'] = (isset($input['hine_facial_asymmetric']) && !empty($input['hine_facial_asymmetric'])) ? $input['hine_facial_asymmetric'] : null;
    	$hine_details['hine_eye_asymmetric'] = (isset($input['hine_eye_asymmetric']) && !empty($input['hine_eye_asymmetric'])) ? $input['hine_eye_asymmetric'] : null;
    	$hine_details['hine_visual_asymmetric'] = (isset($input['hine_visual_asymmetric']) && !empty($input['hine_visual_asymmetric'])) ? $input['hine_visual_asymmetric'] : null;
    	$hine_details['hine_auditory_asymmetric'] = (isset($input['hine_auditory_asymmetric']) && !empty($input['hine_auditory_asymmetric'])) ? $input['hine_auditory_asymmetric'] : null;
    	$hine_details['hine_sucking_asymmetric'] = (isset($input['hine_sucking_asymmetric']) && !empty($input['hine_sucking_asymmetric'])) ? $input['hine_sucking_asymmetric'] : null;
    	$hine_details['hine_head_asymmetric'] = (isset($input['hine_head_asymmetric']) && !empty($input['hine_head_asymmetric'])) ? $input['hine_head_asymmetric'] : null;
    	$hine_details['hine_trunk_asymmetric'] = (isset($input['hine_trunk_asymmetric']) && !empty($input['hine_trunk_asymmetric'])) ? $input['hine_trunk_asymmetric'] : null;
    	$hine_details['hine_arms_asymmetric'] = (isset($input['hine_arms_asymmetric']) && !empty($input['hine_arms_asymmetric'])) ? $input['hine_arms_asymmetric'] : null;
    	$hine_details['hine_hands_asymmetric'] = (isset($input['hine_hands_asymmetric']) && !empty($input['hine_hands_asymmetric'])) ? $input['hine_hands_asymmetric'] : null;
    	$hine_details['hine_legs_asymmetric'] = (isset($input['hine_legs_asymmetric']) && !empty($input['hine_legs_asymmetric'])) ? $input['hine_legs_asymmetric'] : null;
    	$hine_details['hine_feet_asymmetric'] = (isset($input['hine_feet_asymmetric']) && !empty($input['hine_feet_asymmetric'])) ? $input['hine_feet_asymmetric'] : null;
    	$hine_details['hine_quantity_asymmetric'] = (isset($input['hine_quantity_asymmetric']) && !empty($input['hine_quantity_asymmetric'])) ? $input['hine_quantity_asymmetric'] : null;
    	$hine_details['hine_quality_asymmetric'] = (isset($input['hine_quality_asymmetric']) && !empty($input['hine_quality_asymmetric'])) ? $input['hine_quality_asymmetric'] : null;
    	$hine_details['hine_scraf_sign_asymmetric'] = (isset($input['hine_scraf_sign_asymmetric']) && !empty($input['hine_scraf_sign_asymmetric'])) ? $input['hine_scraf_sign_asymmetric'] : null;
    	$hine_details['hine_shoulder_elevation_asymmetric'] = (isset($input['hine_shoulder_elevation_asymmetric']) && !empty($input['hine_shoulder_elevation_asymmetric'])) ? $input['hine_shoulder_elevation_asymmetric'] : null;
    	$hine_details['hine_pronation_supination_asymmetric'] = (isset($input['hine_pronation_supination_asymmetric']) && !empty($input['hine_pronation_supination_asymmetric'])) ? $input['hine_pronation_supination_asymmetric'] : null;
    	$hine_details['hine_hip_adductors_asymmetric'] = (isset($input['hine_hip_adductors_asymmetric']) && !empty($input['hine_hip_adductors_asymmetric'])) ? $input['hine_hip_adductors_asymmetric'] : null;
    	$hine_details['hine_popliteal_angle_asymmetric'] = (isset($input['hine_popliteal_angle_asymmetric']) && !empty($input['hine_popliteal_angle_asymmetric'])) ? $input['hine_popliteal_angle_asymmetric'] : null;
    	$hine_details['hine_ankle_dorsiflexion_asymmetric'] = (isset($input['hine_ankle_dorsiflexion_asymmetric']) && !empty($input['hine_ankle_dorsiflexion_asymmetric'])) ? $input['hine_ankle_dorsiflexion_asymmetric'] : null;
    	$hine_details['hine_pull_to_sit_asymmetric'] = (isset($input['hine_pull_to_sit_asymmetric']) && !empty($input['hine_pull_to_sit_asymmetric'])) ? $input['hine_pull_to_sit_asymmetric'] : null;
    	$hine_details['hine_ventral_suspension_asymmetric'] = (isset($input['hine_ventral_suspension_asymmetric']) && !empty($input['hine_ventral_suspension_asymmetric'])) ? $input['hine_ventral_suspension_asymmetric'] : null;
    	$hine_details['hine_arm_production_asymmetric'] = (isset($input['hine_arm_production_asymmetric']) && !empty($input['hine_arm_production_asymmetric'])) ? $input['hine_arm_production_asymmetric'] : null;
    	$hine_details['hine_vertical_suspension_asymmetric'] = (isset($input['hine_vertical_suspension_asymmetric']) && !empty($input['hine_vertical_suspension_asymmetric'])) ? $input['hine_vertical_suspension_asymmetric'] : null;
    	$hine_details['hine_lateral_tilting_asymmetric'] = (isset($input['hine_lateral_tilting_asymmetric']) && !empty($input['hine_lateral_tilting_asymmetric'])) ? $input['hine_lateral_tilting_asymmetric'] : null;
    	$hine_details['hine_forward_parachute_asymmetric'] = (isset($input['hine_forward_parachute_asymmetric']) && !empty($input['hine_forward_parachute_asymmetric'])) ? $input['hine_forward_parachute_asymmetric'] : null;
    	$hine_details['hine_tendon_reflexes_asymmetric'] = (isset($input['hine_tendon_reflexes_asymmetric']) && !empty($input['hine_tendon_reflexes_asymmetric'])) ? $input['hine_tendon_reflexes_asymmetric'] : null;
    	$hine_details['hine_head_control_asymmetric'] = (isset($input['hine_head_control_asymmetric']) && !empty($input['hine_head_control_asymmetric'])) ? $input['hine_head_control_asymmetric'] : null;
    	$hine_details['hine_sitting_asymmetric'] = (isset($input['hine_sitting_asymmetric']) && !empty($input['hine_sitting_asymmetric'])) ? $input['hine_sitting_asymmetric'] : null;
    	$hine_details['hine_voluntary_grasp_asymmetric'] = (isset($input['hine_voluntary_grasp_asymmetric']) && !empty($input['hine_voluntary_grasp_asymmetric'])) ? $input['hine_voluntary_grasp_asymmetric'] : null;
    	$hine_details['hine_ability_to_kick_asymmetric'] = (isset($input['hine_ability_to_kick_asymmetric']) && !empty($input['hine_ability_to_kick_asymmetric'])) ? $input['hine_ability_to_kick_asymmetric'] : null;
    	$hine_details['hine_rolling_asymmetric'] = (isset($input['hine_rolling_asymmetric']) && !empty($input['hine_rolling_asymmetric'])) ? $input['hine_rolling_asymmetric'] : null;
    	$hine_details['hine_crawling_asymmetric'] = (isset($input['hine_crawling_asymmetric']) && !empty($input['hine_crawling_asymmetric'])) ? $input['hine_crawling_asymmetric'] : null;
    	$hine_details['hine_standing_asymmetric'] = (isset($input['hine_standing_asymmetric']) && !empty($input['hine_standing_asymmetric'])) ? $input['hine_standing_asymmetric'] : null;
    	$hine_details['hine_walking_asymmetric'] = (isset($input['hine_walking_asymmetric']) && !empty($input['hine_walking_asymmetric'])) ? $input['hine_walking_asymmetric'] : null;
    	$hine_details['hine_conscious_state_asymmetric'] = (isset($input['hine_conscious_state_asymmetric']) && !empty($input['hine_conscious_state_asymmetric'])) ? $input['hine_conscious_state_asymmetric'] : null;
    	$hine_details['hine_emotional_state_asymmetric'] = (isset($input['hine_emotional_state_asymmetric']) && !empty($input['hine_emotional_state_asymmetric'])) ? $input['hine_emotional_state_asymmetric'] : null;
    	$hine_details['hine_social_orientation_asymmetric'] = (isset($input['hine_social_orientation_asymmetric']) && !empty($input['hine_social_orientation_asymmetric'])) ? $input['hine_social_orientation_asymmetric'] : null;

    	if (isset($input['assessment_of_cranial']) && is_array($input['assessment_of_cranial']))
    	{
    		$hine_details['assessment_of_cranial'] = json_encode($input['assessment_of_cranial']);
    	}
    	if (isset($input['assessment_of_posture']) && is_array($input['assessment_of_posture']))
    	{
    		$hine_details['assessment_of_posture'] = json_encode($input['assessment_of_posture']);
    	}
    	if (isset($input['assessment_of_movements']) && is_array($input['assessment_of_movements']))
    	{
    		$hine_details['assessment_of_movements'] = json_encode($input['assessment_of_movements']);
    	}
    	if (isset($input['assessment_of_tone']) && is_array($input['assessment_of_tone']))
    	{
    		$hine_details['assessment_of_tone'] = json_encode($input['assessment_of_tone']);
    	}
    	if (isset($input['reflexes_and_reactions']) && is_array($input['reflexes_and_reactions']))
    	{
    		$hine_details['reflexes_and_reactions'] = json_encode($input['reflexes_and_reactions']);
    	}
    	if (isset($input['section_2_motor_milestones']) && is_array($input['section_2_motor_milestones']))
    	{
    		$hine_details['section_2_motor_milestones'] = json_encode($input['section_2_motor_milestones']);
    	}
    	if (isset($input['behaviour']) && is_array($input['behaviour']))
    	{
    		$hine_details['behaviour'] = json_encode($input['behaviour']);
    	}
    	$hine_details['total_hine_score'] = !empty($input['total_hine_score']) ? trim($input['total_hine_score']) : 0;
    	$hine_details['hine_facial_appearance_status'] = isset($input['hine_facial_appearance_status']) ? $input['hine_facial_appearance_status'] : null;
    	$hine_details['hine_eye_movements_status'] = isset($input['hine_eye_movements_status']) ? $input['hine_eye_movements_status'] : null;
    	$hine_details['hine_visual_response_status'] = isset($input['hine_visual_response_status']) ? $input['hine_visual_response_status'] : null;
    	$hine_details['hine_auditory_response_status'] = isset($input['hine_auditory_response_status']) ? $input['hine_auditory_response_status'] : null;
    	$hine_details['hine_sucking_swallowing_status'] = isset($input['hine_sucking_swallowing_status']) ? $input['hine_sucking_swallowing_status'] : null;
    	$hine_details['hine_head_status'] = isset($input['hine_head_status']) ? $input['hine_head_status'] : null;
    	$hine_details['hine_trunk_status'] = isset($input['hine_trunk_status']) ? $input['hine_trunk_status'] : null;
    	$hine_details['hine_arms_status'] = isset($input['hine_arms_status']) ? $input['hine_arms_status'] : null;
    	$hine_details['hine_hands_status'] = isset($input['hine_hands_status']) ? $input['hine_hands_status'] : null;
    	$hine_details['hine_legs_status'] = isset($input['hine_legs_status']) ? $input['hine_legs_status'] : null;
    	$hine_details['hine_feet_status'] = isset($input['hine_feet_status']) ? $input['hine_feet_status'] : null;
    	$hine_details['hine_quantity_status'] = isset($input['hine_quantity_status']) ? $input['hine_quantity_status'] : null;
    	$hine_details['hine_quality_status'] = isset($input['hine_quality_status']) ? $input['hine_quality_status'] : null;
    	$hine_details['hine_scraf_sign_status'] = isset($input['hine_scraf_sign_status']) ? $input['hine_scraf_sign_status'] : null;
    	$hine_details['hine_shoulder_elevation_status'] = isset($input['hine_shoulder_elevation_status']) ? $input['hine_shoulder_elevation_status'] : null;
    	$hine_details['hine_pronation_supination_status'] = isset($input['hine_pronation_supination_status']) ? $input['hine_pronation_supination_status'] : null;
    	$hine_details['hine_hip_adductors_status'] = isset($input['hine_hip_adductors_status']) ? $input['hine_hip_adductors_status'] : null;
    	$hine_details['hine_popliteal_angle_status'] = isset($input['hine_popliteal_angle_status']) ? $input['hine_popliteal_angle_status'] : null;
    	$hine_details['hine_ankle_dorsiflexion_status'] = isset($input['hine_ankle_dorsiflexion_status']) ? $input['hine_ankle_dorsiflexion_status'] : null;
    	$hine_details['hine_pull_to_sit_status'] = isset($input['hine_pull_to_sit_status']) ? $input['hine_pull_to_sit_status'] : null;
    	$hine_details['hine_ventral_suspension_status'] = isset($input['hine_ventral_suspension_status']) ? $input['hine_ventral_suspension_status'] : null;
    	$hine_details['hine_arm_production_status'] = isset($input['hine_arm_production_status']) ? $input['hine_arm_production_status'] : null;
    	$hine_details['hine_vertical_suspension_status'] = isset($input['hine_vertical_suspension_status']) ? $input['hine_vertical_suspension_status'] : null;
    	$hine_details['hine_lateral_tilting_status'] = isset($input['hine_lateral_tilting_status']) ? $input['hine_lateral_tilting_status'] : null;
    	$hine_details['hine_forward_parachute_status'] = isset($input['hine_forward_parachute_status']) ? $input['hine_forward_parachute_status'] : null;
    	$hine_details['hine_tendon_reflexes_status'] = isset($input['hine_tendon_reflexes_status']) ? $input['hine_tendon_reflexes_status'] : null;
    	$hine_details['hine_head_control_status'] = isset($input['hine_head_control_status']) ? $input['hine_head_control_status'] : null;
    	$hine_details['hine_sitting_status'] = isset($input['hine_sitting_status']) ? $input['hine_sitting_status'] : null;
    	$hine_details['hine_voluntary_grasp_status'] = isset($input['hine_voluntary_grasp_status']) ? $input['hine_voluntary_grasp_status'] : null;
    	$hine_details['hine_ability_to_kick_status'] = isset($input['hine_ability_to_kick_status']) ? $input['hine_ability_to_kick_status'] : null;
    	$hine_details['hine_rolling_status'] = isset($input['hine_rolling_status']) ? $input['hine_rolling_status'] : null;
    	$hine_details['hine_crawling_status'] = isset($input['hine_crawling_status']) ? $input['hine_crawling_status'] : null;
    	$hine_details['hine_standing_status'] = isset($input['hine_standing_status']) ? $input['hine_standing_status'] : null;
    	$hine_details['hine_walking_status'] = isset($input['hine_walking_status']) ? $input['hine_walking_status'] : null;
    	$hine_details['hine_conscious_state_status'] = isset($input['hine_conscious_state_status']) ? $input['hine_conscious_state_status'] : null;
    	$hine_details['hine_emotional_state_status'] = isset($input['hine_emotional_state_status']) ? $input['hine_emotional_state_status'] : null;
    	$hine_details['hine_social_orientation_status'] = isset($input['hine_social_orientation_status']) ? $input['hine_social_orientation_status'] : null;

    	$check_hine_details_exist = \DB::table('hine_details')->where('neuro_visit_id', $id)->first();

    	if (count($check_hine_details_exist) > 0 && isset($check_hine_details_exist->id))
    	{
    		$hine_details['modify_tstamp'] = date('Y-m-d H:i:s');
    		$hine_details['modify_user_id'] = \Auth::user()->id;
    		\DB::table('hine_details')->where('id', $check_hine_details_exist->id)->update($hine_details);
    	}
    	else
    	{
    		$hine_details['create_tstamp'] = date('Y-m-d H:i:s');
    		$hine_details['create_user_id'] = \Auth::user()->id;
    		$hine_details['neuro_visit_id'] = $id;
    		$hine_details['visit_date'] = date('Y-m-d', strtotime($op_date));
    		$hine_details['baby_id'] = $input['BabyId'];
    		\DB::table('hine_details')->insert($hine_details);
    	}
    }

    public function storeDdstDetails($input, $id, $op_date)
    {

    	$ddst_details = array();
    	$ddst_form_fields = \ValuelistHelpers::getDdstOnObservationFields();
    	array_walk_recursive($ddst_form_fields, function ($a) use (&$ddst_details, $input)
    	{
    		$ddst_details[$a] = isset($input[$a]) && !empty($input[$a]) ? $input[$a] : '';
    	});
    	$ddst_details['op_date'] = date('Y-m-d', strtotime($op_date));
    	$ddst_details['baby_id'] = $input['baby_id'];
    	$ddst_details['neuro_visit_id'] = $id;
    	$ddst_details['modify_tstamp'] = date('Y-m-d H:i:s');
    	$ddst_details['modify_user_id'] = \Auth::user()->id;
    	$check_ddst_details_exist = \DB::table('ddst_details')->where('neuro_visit_id', $id)->first();

    	if (count($check_ddst_details_exist) > 0 && isset($check_ddst_details_exist->id))
    	{
    		\DB::table('ddst_details')->where('neuro_visit_id', $check_ddst_details_exist->id)->update($ddst_details);
    	}
    	else
    	{
    		$ddst_details['create_tstamp'] = date('Y-m-d H:i:s');
    		$ddst_details['create_user_id'] = \Auth::user()->id;
    		\DB::table('ddst_details')->insert($ddst_details);
    	}
    	Op::where('OpId', $id)->update(['screening_exist' => true]);

    }

    public function storeMChatAnswers($input, $id)
    {
    	$m_chat_results = Op::getMChatResults($input['BabyId'])->where('type', false)->pluck('answer', 'question_id')->toArray();
    	$m_chat_answers['baby_id'] = $input['BabyId'];
    	$m_chat_answers['neuro_visit_id'] = $id;

    	$m_chat_insert_array = array();

    	if (isset($input['answer']) && count($input['answer']) > 0 && count(array_filter($input['answer'])) > 0)
    	{
    		foreach ($input['answer'] as $ans_key => $ans_value)
    		{
    			if (isset($m_chat_results[$ans_key]))
    			{
    				if ($m_chat_results[$ans_key] != $ans_value)
    				{
    					\DB::table('m_chat_r_screenings')->where('baby_id', $input['BabyId'])->where('question_id', $ans_key)->where('type', false)->update(['answer' => $ans_value]);
    				}
    				unset($m_chat_results[$ans_key]);
    			}
    			else
    			{
    				$m_chat_answers['question_id'] = $ans_key;
    				$m_chat_answers['answer'] = $ans_value;
    				$m_chat_answers['create_date_time'] = date('Y-m-d H:i:s');
    				$m_chat_answers['create_user_id'] = \Auth::user()->id;
    				$m_chat_insert_array[] = $m_chat_answers;
    			}
    		}
    	}
    	if (count($m_chat_results) > 0)
    	{
    		\DB::table('m_chat_r_screenings')->where('baby_id', $input['BabyId'])->whereIn('question_id', array_keys($m_chat_results))->update(['answer' => 'No']);
    	}
    	if (count($m_chat_insert_array) > 0)
    	{
    		\DB::table('m_chat_r_screenings')->insert($m_chat_insert_array);
    	}
    }

    public function storeMChatFollowUpAnswers($input, $id)
    {
    	$m_chat_results = Op::getMChatResults($input['BabyId'])->where('type', true)->pluck('answer', 'question_id')->toArray();
    	$m_chat_answers['baby_id'] = $input['BabyId'];
    	$m_chat_answers['neuro_visit_id'] = $id;

    	$m_chat_insert_array = array();

    	if (isset($input['followupanswer'])) {

    		$is_filled = array_slice($input['followupanswer'], 0, 20);

    		if (isset($input['followupanswer']) && count($input['followupanswer']) > 0 && count(array_filter($is_filled)) > 0)
    		{
    			foreach ($input['followupanswer'] as $ans_key => $ans_value)
    			{
    				if (isset($m_chat_results[$ans_key]))
    				{
    					$answers['answer'] = $ans_value;
    					$answers['description'] = isset($input['description'][$ans_key]) ? $input['description'][$ans_key] : null;
    					$answers['final_answer'] = isset($input['final_answer'][$ans_key]) ? $input['final_answer'][$ans_key] : null;
    					$answers['modify_date_time'] = date('Y-m-d H:i:s');
    					$answers['modify_user_id'] = \Auth::user()->id;
    					Mchatscreenings::where('baby_id', $input['BabyId'])->where('question_id', $ans_key)->where('type', true)->update($answers);
    				}
    				else
    				{
    					$m_chat_answers['question_id'] = $ans_key;
    					$m_chat_answers['answer'] = $ans_value;
    					$m_chat_answers['description'] = isset($input['description'][$ans_key]) ? $input['description'][$ans_key] : null;
    					$m_chat_answers['final_answer'] = isset($input['final_answer'][$ans_key]) ? $input['final_answer'][$ans_key] : null;
    					$m_chat_answers['create_date_time'] = date('Y-m-d H:i:s');
    					$m_chat_answers['create_user_id'] = \Auth::user()->id;
    					$m_chat_answers['type'] = 1;
    					$m_chat_insert_array[] = $m_chat_answers;
    				}
    			}
    		}

    		if (count($m_chat_insert_array) > 0)
    		{
    			Mchatscreenings::insert($m_chat_insert_array);
    		}
    	}
    }

    public function opVisit($baby_id = '')
    {
    	$baby_id = \SiteHelpers::decrypt_id($baby_id);
    	$results_temp = Op::GetOpvisitList($baby_id);
    	$visitList = array(
    		\SiteHelpers::encrypt_id($baby_id) => 0
    	);
    	if (count($results_temp) > 0)
    	{
    		foreach ($results_temp as $value)
    		{
    			if (isset($value->OpId) && !empty($value->OpId))
    			{
    				$visitList[\SiteHelpers::encrypt_id($value->OpId) ] = $value->op_visite;
    			}
    		}
    		return \Response::json(['status' => true, 'message' => $visitList], 200);
    	}
    	return \Response::json(['status' => false, 'message' => $visitList], 200);
    }

    public static function getBabyBackgroundDetails($mrn)
    {

    	$details = Baby::get_baby_by_mrn($mrn);
    	if (isset($details->BabyId))
    	{
    		$id = $details->BabyId;
    	}

    	$baby_background = '';

    	if (isset($id))
    	{

    		$discharge_summary_backgroud = DischargeSummary::getSummaryCompleted($id);

    		$postanatalAdmission = Postnatal::where('BabyId', $id)->where('IsDeleted', 0)->orderBy('AdmissionId', 'desc')->first();

    		$nicuAdmission = Nicu::where('BabyId', $id)->where('IsDeleted', 0)->orderBy('AdmissionId', 'desc')->first();

    		$previous_op = Op::GetPreviousopRecord($id);

    		if (is_array($discharge_summary_backgroud) && count($discharge_summary_backgroud) > 0)
    		{

    			foreach ($discharge_summary_backgroud as $discharge_value)
    			{

    				$baby_background .= $discharge_value;

    			}

    		}
    		elseif (count($postanatalAdmission) > 0)
    		{

    			$postanatalProblem = PostDaycare::where('BabyId', $postanatalAdmission->BabyId)->where('AdmissionId', $postanatalAdmission->AdmissionId)->where('IsDeleted', 0)->orderBy('AdmissionId', 'desc')->get();
    			$differentialdiagnosis = array();

    			$temp_differentialdiagnosis = $postanatalProblem->pluck('differentialdiagnosis');
    			$temp_additional_diagnosis = $postanatalProblem->pluck('additional_diagnosis');

    			foreach ($temp_differentialdiagnosis as $diagnosiskey => $diagnosisvalue)
    			{
    				$differentialdiagnosis[] = json_decode($diagnosisvalue);
    			}

    			foreach ($temp_additional_diagnosis as $diagnosiskey => $diagnosisvalue)
    			{
    				$additional_diagnosis[] = json_decode($diagnosisvalue);
    			}

    			if (count($differentialdiagnosis) > 0)
    			{

    				$differentialdiagnosis = collect($differentialdiagnosis);
    				$differentialdiagnosis = $differentialdiagnosis->collapse()->unique();

    				$additional_diagnosis = collect($additional_diagnosis);
    				$additional_diagnosis = $additional_diagnosis->collapse()->unique();

    				$differentialdiagnosis = Icd::whereIn('ICDCode', $differentialdiagnosis)->get()->pluck('ICDDescription')->toArray();
    				$differentialdiagnosis = $additional_diagnosis->merge($differentialdiagnosis)->toArray();

    				$baby_background = implode(', ', $differentialdiagnosis);
    			}

    			$problems = PostProblemDischargeSummary::getNeonatalProblems($postanatalAdmission->BabyId, $postanatalAdmission->AdmissionId);
    			if (count($problems) > 0)
    			{
    				$postProblems = $problems->pluck('problem_name')->unique()->toArray();
    				if (!empty($baby_background))
    				{
    					$baby_background .= ', ' . implode(', ', $postProblems);
    				}
    				else
    				{
    					$baby_background = implode(', ', $postProblems);
    				}
    			}

    		}
    		elseif (count($nicuAdmission) > 0)
    		{

    			$nicuProblem = Daycare::where('BabyId', $nicuAdmission->BabyId)->where('AdmissionId', $nicuAdmission->AdmissionId)->where('IsDeleted', 0)->orderBy('AdmissionId', 'desc')->pluck('NicuICD');
    			$differentialdiagnosis = array();

    			foreach ($nicuProblem as $diagnosiskey => $diagnosisvalue)
    			{
    				$differentialdiagnosis[] = json_decode($diagnosisvalue);
    			}

    			$diagnosis = array();
    			if (count($differentialdiagnosis) > 0)
    			{

    				$differentialdiagnosis = collect($differentialdiagnosis);

    				foreach ($differentialdiagnosis as $diagnosiskey => $diagnosisvalue)
    				{
    					foreach ($diagnosisvalue as $key => $value)
    					{
    						$diagnosis = array_merge(Icd::whereIn('ICDCode', $value)->get()->pluck('ICDDescription')->toArray() , $diagnosis);
    					}
    				}
    				$baby_background = implode(', ', $diagnosis);
    			}

    			$problems = ProblemDischarge::getNeonatalProblems($nicuAdmission->BabyId, $nicuAdmission->AdmissionId);
    			if (count($problems) > 0)
    			{
    				$postProblems = $problems->pluck('problem_name')->unique()->toArray();
    				if (!empty($baby_background))
    				{
    					$baby_background .= ', ' . implode(', ', $postProblems);
    				}
    				else
    				{
    					$baby_background = implode(', ', $postProblems);
    				}
    			}

    		}
    		else
    		{

    			$baby_background = $details->Background;
    		}

    		if (isset($previous_op->OpId) && !empty($previous_op->OpId))
    		{

    			$baby_background = (isset($previous_op->baby_background) && !empty($previous_op->baby_background)) ? $previous_op->baby_background : $baby_background;
    		}

    	}

    	return \Response::json(['baby_background' => $baby_background], 200);

    }

    public static function getPreviousEligibilityDetails($mrn)
    {
    	$results = NeuroEligibility::getPreviousDetails($mrn);
    	return $results;
    }

    public static function ddst()
    {
    	$ddst_result = \DB::table('ddst_details')->where('neuro_visit_id', 43)->pluck('status', 'task_id');

    	return view('registration.neuro.ddst_chart', compact('ddst_result'));
    }

    public static function saveddst(Request $request)
    {
    	$input = $request->all();

    	$result = \DB::table('ddst_details')->where('neuro_visit_id', $input['neuro_visit_id'])->where('task_id', $input['task_id'])->first();

    	if (isset($result->id)) {
    		if($result->status != $input['status']) {
    			$input['modify_user_id'] = \Auth::user()->id;
    			$input['modify_tstamp'] = date('Y-m-d H:i:s');
    			\DB::table('ddst_details')->where('id', $result->id)->update(['status'=>$input['status']]);
    		}
    	} else {
    		$input['create_user_id'] = \Auth::user()->id;
    		$input['create_tstamp'] = date('Y-m-d H:i:s');
    		\DB::table('ddst_details')->insert($input);
    	}

    	return \Response::json(['type' => 'success'], 200);
    }

    public static function storeDasiiMentalScale($input, $neuro_visit_id)
    {
    	if (isset($input['mentalanswer'])) {
    		$mental_answer = array_filter($input['mentalanswer']);

    		$mental_input['dasii_age'] = $input['dasii_age'];
    		if ($mental_input['dasii_age'] != '') {
    			$mental_input['type'] = 1;

    			foreach ($mental_answer as $key => $value) {        

    				$result = \DB::table('dasii_mental_motor_screening')->where('neuro_visit_id', $neuro_visit_id)->where('type', $mental_input['type'])->where('question_id', $key)->first();

    				$mental_input['question_id'] = $key;
    				$mental_input['answer'] = $value;

    				if (isset($result->id)) {
    					if($result->answer != $mental_input['answer']) {
    						$mental_input['modify_user_id'] = \Auth::user()->id;
    						$mental_input['modify_tstamp'] = date('Y-m-d H:i:s');
    						\DB::table('dasii_mental_motor_screening')->where('id', $result->id)->where('type', $mental_input['type'])->update($mental_input);
    					}
    				} else {
    					$mental_input['baby_id'] = $input['baby_id'];
    					$mental_input['neuro_visit_id'] = $neuro_visit_id;
    					$mental_input['create_user_id'] = \Auth::user()->id;
    					$mental_input['create_tstamp'] = date('Y-m-d H:i:s');
    					\DB::table('dasii_mental_motor_screening')->insert($mental_input);
    				}
    			}
    		}
    	}

    }

    public static function storeDasiiMotorScale($input, $neuro_visit_id)
    {
    	if (isset($input['motoranswer'])) {
    		$motor_answer = $input['motoranswer'];

    		$motor_input['dasii_age'] = $input['dasii_age'];
    		$motor_input['type'] = 2;       

    		if ($motor_input['dasii_age'] != '') {
    			foreach ($motor_answer as $key => $value) { 

    				$motor_input['question_id'] = $key;
    				$motor_input['answer'] = $value;

    				$result = \DB::table('dasii_mental_motor_screening')->where('neuro_visit_id', $neuro_visit_id)->where('type', $motor_input['type'])->where('question_id', $key)->first();
    				if (isset($result->id)) {
    					if($result->answer != $motor_input['answer']) {
    						$motor_input['modify_user_id'] = \Auth::user()->id;
    						$motor_input['modify_tstamp'] = date('Y-m-d H:i:s');
    						\DB::table('dasii_mental_motor_screening')->where('id', $result->id)->where('type', $motor_input['type'])->update($motor_input);
    					}
    				} else {
    					$motor_input['baby_id'] = $input['baby_id'];
    					$motor_input['neuro_visit_id'] = $neuro_visit_id;
    					$motor_input['create_user_id'] = \Auth::user()->id;
    					$motor_input['create_tstamp'] = date('Y-m-d H:i:s');
    					\DB::table('dasii_mental_motor_screening')->insert($motor_input);
    				}
    			}
    		}
    	}

    }

    public static function storeDdst($input, $neuro_visit_id)
    {
    	if (isset($input['ddst'])) {
    		$ddst_answer = $input['ddst'];
    		if (isset($input['ddst_age'])) {
    			$ddst_input['age'] = $input['ddst_age'];

    			if ($ddst_input['age'] != '') {
    				foreach ($ddst_answer as $key => $value) { 

    					if ($value != '') {
    						$ddst_input['task_id'] = $key;
    						$ddst_input['status'] = $value;

    						$result = \DB::table('ddst_details')->where('neuro_visit_id', $neuro_visit_id)->where('task_id', $key)->first();

    						if (isset($result->id)) {
    							if($result->status != $ddst_input['status']) {
    								$ddst_input['modify_user_id'] = \Auth::user()->id;
    								$ddst_input['modify_tstamp'] = date('Y-m-d H:i:s');
    								\DB::table('ddst_details')->where('id', $result->id)->update($ddst_input);
    							}
    						} else {
    							$ddst_input['baby_id'] = $input['baby_id'];
    							$ddst_input['neuro_visit_id'] = $neuro_visit_id;
    							$ddst_input['create_user_id'] = \Auth::user()->id;
    							$ddst_input['create_tstamp'] = date('Y-m-d H:i:s');
    							\DB::table('ddst_details')->insert($ddst_input);
    						}
    					}
    				}
    			}
    		}
    	}

    }

    public static function storeCbcl($input, $neuro_visit_id)
    {
    	if (isset($input['cbcl_interpretation']) && !empty($input['cbcl_interpretation'])) {

    		$cbcl_answer = $input['cbcl_answer'];

    		foreach ($cbcl_answer as $key => $value) { 

    			if ($value != '') {
    				$cbcl_input['question_id'] = $key;
    				$cbcl_input['answer'] = $value;
    				$cbcl_input['description'] = isset($input['cbcl_describe'][$key]) ? $input['cbcl_describe'][$key] : null;

    				$result = \DB::table('neuro_cbcl_screening')->where('neuro_visit_id', $neuro_visit_id)->where('question_id', $key)->first();

    				if (isset($result->id)) {
    					if($result->answer != $cbcl_input['answer'] || $result->description != $cbcl_input['description']) {
    						$cbcl_input['modify_user_id'] = \Auth::user()->id;
    						$cbcl_input['modify_date_time'] = date('Y-m-d H:i:s');
    						\DB::table('neuro_cbcl_screening')->where('id', $result->id)->update($cbcl_input);
    					}
    				} else {
    					$cbcl_input['neuro_visit_id'] = $neuro_visit_id;
    					$cbcl_input['baby_id'] = $input['baby_id'];
    					$cbcl_input['create_user_id'] = \Auth::user()->id;
    					$cbcl_input['create_date_time'] = date('Y-m-d H:i:s');
    					\DB::table('neuro_cbcl_screening')->insert($cbcl_input);
    				}
    			}
    		}
    	}

    }

    public static function storeBayley($input, $neuro_visit_id)
    {

    	if ((isset($input['start_point']) && !empty($input['start_point'])) || (isset($input['cg']) && !empty($input['cg'])) || (isset($input['rc']) && !empty($input['rc'])) || (isset($input['ec']) && !empty($input['ec'])) || (isset($input['fm']) && !empty($input['fm'])) || (isset($input['gm']) && !empty($input['gm'])) || (isset($input['cg_scaled_score']) && !empty($input['cg_scaled_score'])) || (isset($input['rc_scaled_score']) && !empty($input['rc_scaled_score'])) || (isset($input['ec_scaled_score']) && !empty($input['ec_scaled_score'])) || (isset($input['fm_scaled_score']) && !empty($input['fm_scaled_score'])) || (isset($input['gm_scaled_score']) && !empty($input['gm_scaled_score'])) || (isset($input['cg_age_equivalent']) && !empty($input['cg_age_equivalent'])) || (isset($input['rc_age_equivalent']) && !empty($input['rc_age_equivalent'])) || (isset($input['ec_age_equivalent']) && !empty($input['ec_age_equivalent'])) || (isset($input['fm_age_equivalent']) && !empty($input['fm_age_equivalent'])) || (isset($input['gm_age_equivalent']) && !empty($input['gm_age_equivalent'])) || (isset($input['cg_growth_scale']) && !empty($input['cg_growth_scale'])) || (isset($input['rc_growth_scale']) && !empty($input['rc_growth_scale'])) || (isset($input['ec_growth_scale']) && !empty($input['ec_growth_scale'])) || (isset($input['fm_growth_scale']) && !empty($input['fm_growth_scale'])) || (isset($input['gm_growth_scale']) && !empty($input['gm_growth_scale']))) {

    		$result = BayleyScale::where('neuro_visit_id', $neuro_visit_id)->first();

    		$bayley = array();

    		$bayley['start_point'] = isset($input['start_point']) ? $input['start_point'] : null;
    		$bayley['cg'] = isset($input['cg']) ? $input['cg'] : null;
    		$bayley['rc'] = isset($input['rc']) ? $input['rc'] : null;
    		$bayley['ec'] = isset($input['ec']) ? $input['ec'] : null;
    		$bayley['fm'] = isset($input['fm']) ? $input['fm'] : null;
    		$bayley['gm'] = isset($input['gm']) ? $input['gm'] : null;
    		$bayley['se_raw_score'] = isset($input['se_raw_score']) ? $input['se_raw_score'] : null;
    		$bayley['rec_raw_score'] = isset($input['rec_raw_score']) ? $input['rec_raw_score'] : null;
    		$bayley['exp_raw_score'] = isset($input['exp_raw_score']) ? $input['exp_raw_score'] : null;
    		$bayley['per_raw_score'] = isset($input['per_raw_score']) ? $input['per_raw_score'] : null;
    		$bayley['ipr_raw_score'] = isset($input['ipr_raw_score']) ? $input['ipr_raw_score'] : null;
    		$bayley['pla_raw_score'] = isset($input['pla_raw_score']) ? $input['pla_raw_score'] : null;
    		$bayley['cg_scaled_score'] = isset($input['cg_scaled_score']) ? $input['cg_scaled_score'] : null;
    		$bayley['rc_scaled_score'] = isset($input['rc_scaled_score']) ? $input['rc_scaled_score'] : null;
    		$bayley['ec_scaled_score'] = isset($input['ec_scaled_score']) ? $input['ec_scaled_score'] : null;
    		$bayley['fm_scaled_score'] = isset($input['fm_scaled_score']) ? $input['fm_scaled_score'] : null;
    		$bayley['gm_scaled_score'] = isset($input['gm_scaled_score']) ? $input['gm_scaled_score'] : null;
    		$bayley['se_scaled_score'] = isset($input['se_scaled_score']) ? $input['se_scaled_score'] : null;
    		$bayley['rec_scaled_score'] = isset($input['rec_scaled_score']) ? $input['rec_scaled_score'] : null;
    		$bayley['exp_scaled_score'] = isset($input['exp_scaled_score']) ? $input['exp_scaled_score'] : null;
    		$bayley['per_scaled_score'] = isset($input['per_scaled_score']) ? $input['per_scaled_score'] : null;
    		$bayley['ipr_scaled_score'] = isset($input['ipr_scaled_score']) ? $input['ipr_scaled_score'] : null;
    		$bayley['pla_scaled_score'] = isset($input['pla_scaled_score']) ? $input['pla_scaled_score'] : null;
    		$bayley['cg_age_equivalent'] = isset($input['cg_age_equivalent']) ? $input['cg_age_equivalent'] : null;
    		$bayley['rc_age_equivalent'] = isset($input['rc_age_equivalent']) ? $input['rc_age_equivalent'] : null;
    		$bayley['ec_age_equivalent'] = isset($input['ec_age_equivalent']) ? $input['ec_age_equivalent'] : null;
    		$bayley['fm_age_equivalent'] = isset($input['fm_age_equivalent']) ? $input['fm_age_equivalent'] : null;
    		$bayley['gm_age_equivalent'] = isset($input['gm_age_equivalent']) ? $input['gm_age_equivalent'] : null;
    		$bayley['rec_age_equivalent'] = isset($input['rec_age_equivalent']) ? $input['rec_age_equivalent'] : null;
    		$bayley['exp_age_equivalent'] = isset($input['exp_age_equivalent']) ? $input['exp_age_equivalent'] : null;
    		$bayley['per_age_equivalent'] = isset($input['per_age_equivalent']) ? $input['per_age_equivalent'] : null;
    		$bayley['ipr_age_equivalent'] = isset($input['ipr_age_equivalent']) ? $input['ipr_age_equivalent'] : null;
    		$bayley['pla_age_equivalent'] = isset($input['pla_age_equivalent']) ? $input['pla_age_equivalent'] : null;
    		$bayley['cg_growth_scale'] = isset($input['cg_growth_scale']) ? $input['cg_growth_scale'] : null;
    		$bayley['rc_growth_scale'] = isset($input['rc_growth_scale']) ? $input['rc_growth_scale'] : null;
    		$bayley['ec_growth_scale'] = isset($input['ec_growth_scale']) ? $input['ec_growth_scale'] : null;
    		$bayley['fm_growth_scale'] = isset($input['fm_growth_scale']) ? $input['fm_growth_scale'] : null;
    		$bayley['gm_growth_scale'] = isset($input['gm_growth_scale']) ? $input['gm_growth_scale'] : null;
    		$bayley['rec_growth_scale'] = isset($input['rec_growth_scale']) ? $input['rec_growth_scale'] : null;
    		$bayley['exp_growth_scale'] = isset($input['exp_growth_scale']) ? $input['exp_growth_scale'] : null;
    		$bayley['per_growth_scale'] = isset($input['per_growth_scale']) ? $input['per_growth_scale'] : null;
    		$bayley['ipr_growth_scale'] = isset($input['ipr_growth_scale']) ? $input['ipr_growth_scale'] : null;
    		$bayley['pla_growth_scale'] = isset($input['pla_growth_scale']) ? $input['pla_growth_scale'] : null;

    		$bayley['lang_scaled_score'] = isset($input['lang_scaled_score']) ? $input['lang_scaled_score'] : null;
    		$bayley['mot_scaled_score'] = isset($input['mot_scaled_score']) ? $input['mot_scaled_score'] : null;
    		$bayley['adbe_scaled_score'] = isset($input['adbe_scaled_score']) ? $input['adbe_scaled_score'] : null;

    		$bayley['confidence_interval'] = isset($input['confidence_interval']) ? $input['confidence_interval'] : null;

    		$bayley['com_scaled_score'] = isset($input['com_scaled_score']) ? $input['com_scaled_score'] : null;
    		$bayley['soc_scaled_score'] = isset($input['soc_scaled_score']) ? $input['soc_scaled_score'] : null;
    		$bayley['adbe_scaled_score'] = isset($input['adbe_scaled_score']) ? $input['adbe_scaled_score'] : null;

    		$bayley['cog_standard_score'] = isset($input['cog_standard_score']) ? $input['cog_standard_score'] : null;
    		$bayley['lang_standard_score'] = isset($input['lang_standard_score']) ? $input['lang_standard_score'] : null;
    		$bayley['mot_standard_score'] = isset($input['mot_standard_score']) ? $input['mot_standard_score'] : null;
    		$bayley['soem_standard_score'] = isset($input['soem_standard_score']) ? $input['soem_standard_score'] : null;
    		$bayley['com_standard_score'] = isset($input['com_standard_score']) ? $input['com_standard_score'] : null;
    		$bayley['dls_standard_score'] = isset($input['dls_standard_score']) ? $input['dls_standard_score'] : null;
    		$bayley['soc_standard_score'] = isset($input['soc_standard_score']) ? $input['soc_standard_score'] : null;
    		$bayley['adbe_standard_score'] = isset($input['adbe_standard_score']) ? $input['adbe_standard_score'] : null;

    		$bayley['cog_percentile_rank'] = isset($input['cog_percentile_rank']) ? $input['cog_percentile_rank'] : null;
    		$bayley['lang_percentile_rank'] = isset($input['lang_percentile_rank']) ? $input['lang_percentile_rank'] : null;
    		$bayley['mot_percentile_rank'] = isset($input['mot_percentile_rank']) ? $input['mot_percentile_rank'] : null;
    		$bayley['soem_percentile_rank'] = isset($input['soem_percentile_rank']) ? $input['soem_percentile_rank'] : null;
    		$bayley['com_percentile_rank'] = isset($input['com_percentile_rank']) ? $input['com_percentile_rank'] : null;
    		$bayley['dls_percentile_rank'] = isset($input['dls_percentile_rank']) ? $input['dls_percentile_rank'] : null;
    		$bayley['soc_percentile_rank'] = isset($input['soc_percentile_rank']) ? $input['soc_percentile_rank'] : null;
    		$bayley['adbe_percentile_rank'] = isset($input['adbe_percentile_rank']) ? $input['adbe_percentile_rank'] : null;

    		$bayley['cog_confidence_interval_start'] = isset($input['cog_confidence_interval_start']) ? $input['cog_confidence_interval_start'] : null;
    		$bayley['lang_confidence_interval_start'] = isset($input['lang_confidence_interval_start']) ? $input['lang_confidence_interval_start'] : null;
    		$bayley['mot_confidence_interval_start'] = isset($input['mot_confidence_interval_start']) ? $input['mot_confidence_interval_start'] : null;
    		$bayley['soem_confidence_interval_start'] = isset($input['soem_confidence_interval_start']) ? $input['soem_confidence_interval_start'] : null;
    		$bayley['com_confidence_interval_start'] = isset($input['com_confidence_interval_start']) ? $input['com_confidence_interval_start'] : null;
    		$bayley['dls_confidence_interval_start'] = isset($input['dls_confidence_interval_start']) ? $input['dls_confidence_interval_start'] : null;
    		$bayley['soc_confidence_interval_start'] = isset($input['soc_confidence_interval_start']) ? $input['soc_confidence_interval_start'] : null;
    		$bayley['adbe_confidence_interval_start'] = isset($input['adbe_confidence_interval_start']) ? $input['adbe_confidence_interval_start'] : null;

    		$bayley['cog_confidence_interval_end'] = isset($input['cog_confidence_interval_end']) ? $input['cog_confidence_interval_end'] : null;
    		$bayley['lang_confidence_interval_end'] = isset($input['lang_confidence_interval_end']) ? $input['lang_confidence_interval_end'] : null;
    		$bayley['mot_confidence_interval_end'] = isset($input['mot_confidence_interval_end']) ? $input['mot_confidence_interval_end'] : null;
    		$bayley['soem_confidence_interval_end'] = isset($input['soem_confidence_interval_end']) ? $input['soem_confidence_interval_end'] : null;
    		$bayley['com_confidence_interval_end'] = isset($input['com_confidence_interval_end']) ? $input['com_confidence_interval_end'] : null;
    		$bayley['dls_confidence_interval_end'] = isset($input['dls_confidence_interval_end']) ? $input['dls_confidence_interval_end'] : null;
    		$bayley['soc_confidence_interval_end'] = isset($input['soc_confidence_interval_end']) ? $input['soc_confidence_interval_end'] : null;
    		$bayley['adbe_confidence_interval_end'] = isset($input['adbe_confidence_interval_end']) ? $input['adbe_confidence_interval_end'] : null;

    		$mas_list = BayleyScaleMaster::getData()->where('score', 2)->groupBy('category')->map(function($list) {
    			return $list->pluck('title', 'question_no');
    		})
    		->toArray();

    		$title[1] = 'Cognitive (CG)';
    		$title[2] = 'Receptive Communication (RC)';
    		$title[3] = 'Expressive Communication (EC)';
    		$title[4] = 'Fine Motor (FM)';
    		$title[5] = 'Gross Motor (GM)';

    		if (isset($result->id)) {
    			$bayley['user_modified'] = \Auth::user()->id;
    			$bayley['date_modified'] = date('Y-m-d H:i:s');
    			$result->update($bayley);
    			$bayley_id = $result->id;
    		} else {
    			$bayley['baby_id'] = $input['baby_id'];
    			$bayley['neuro_visit_id'] = $neuro_visit_id;
    			$bayley['user_added'] = \Auth::user()->id;
    			$bayley['date_added'] = date('Y-m-d H:i:s'); 
    			$bayley_id = BayleyScale::insertGetId($bayley);
    		}

    		$table_id_score_cg = json_decode($input['table_id_score_cg'], true);
    		$table_id_score_rc = json_decode($input['table_id_score_rc'], true);
    		$table_id_score_ec = json_decode($input['table_id_score_ec'], true);
    		$table_id_score_fm = json_decode($input['table_id_score_fm'], true);
    		$table_id_score_gm = json_decode($input['table_id_score_gm'], true);
    		$table_id_score_se = json_decode($input['table_id_score_se'], true);

    		$table_id_score_ab_r = json_decode($input['table_id_score_ab_r'], true);
    		$table_id_score_ab_e = json_decode($input['table_id_score_ab_e'], true);
    		$table_id_score_ab_p = json_decode($input['table_id_score_ab_p'], true);
    		$table_id_score_ab_ir = json_decode($input['table_id_score_ab_ir'], true);
    		$table_id_score_ab_pl = json_decode($input['table_id_score_ab_pl'], true);
    		$table_id_other = json_decode($input['table_id_other'], true);

    		$bayley_sub = [];
    		$bayley_sub_1 = [];
    		$bayley_sub_2 = [];
    		$i = 0;

    		if (isset($input['score']) && is_array($input['score'])) {
    			foreach ($input['score'] as $category_id => $questions) {
    				if ($category_id == 1) {
    					$table_id_score = $table_id_score_cg;
    				} else if ($category_id == 2) {
    					$table_id_score = $table_id_score_rc;
    				} else if ($category_id == 3) {
    					$table_id_score = $table_id_score_ec;
    				} else if ($category_id == 4) {
    					$table_id_score = $table_id_score_fm;
    				} else if ($category_id == 5) {
    					$table_id_score = $table_id_score_gm;
    				} else if ($category_id == 6) {
    					$table_id_score = $table_id_score_se;
    				} else if ($category_id == 7) {
    					$table_id_score = $table_id_score_ab_r;
    				} else if ($category_id == 8) {
    					$table_id_score = $table_id_score_ab_e;
    				} else if ($category_id == 9) {
    					$table_id_score = $table_id_score_ab_p;
    				} else if ($category_id == 10) {
    					$table_id_score = $table_id_score_ab_ir;
    				} else if ($category_id == 11) {
    					$table_id_score = $table_id_score_ab_pl;
    				}
    				foreach ($questions as $question_id => $value) {
    					if (in_array($question_id, $table_id_score)) {
    						$bayley_sub_update['sub_question_id'] = $input['score_sub_id'][$category_id][$question_id];
    						$bayley_sub_update['value'] = $value;
    						$bayley_sub_update['user_modified'] = \Auth::user()->id;
    						$bayley_sub_update['date_modified'] = date('Y-m-d H:i:s');
    						$id = array_search($question_id, $table_id_score);
    						$sub_results = BayleyScaleScore::findOrfail($id);
    						$sub_results->update($bayley_sub_update);
    					} else {
    						if (!empty($input['score_sub_id'][$category_id][$question_id])) {
    							$bayley_sub[$i]['hdr_id'] = $bayley_id;
    							$bayley_sub[$i]['category_id'] = $category_id;
    							$bayley_sub[$i]['question_id'] = $question_id;
    							$bayley_sub[$i]['sub_question_id'] = $input['score_sub_id'][$category_id][$question_id];
    							$bayley_sub[$i]['is_manual'] = isset($input['is_manual'][$category_id][$question_id]) ? $input['is_manual'][$category_id][$question_id] : false;
    							$bayley_sub[$i]['value'] = $value;
    							$bayley_sub[$i]['user_added'] = \Auth::user()->id;
    							$bayley_sub[$i]['date_added'] = date('Y-m-d H:i:s'); 
    							$i++;
    						}
    					}
    				}
    			}
    		}
    		BayleyScaleScore::insert($bayley_sub);

    		if (isset($input['note']) && is_array($input['note'])) {
    			foreach ($input['note'] as $category_id => $questions) {
    				foreach ($questions as $question_id => $sub_question) {
    					foreach ($sub_question as $sub_id => $value) {
    						if (in_array($sub_id, $table_id_other)) {
    							$bayley_sub_update['value'] = $value;
    							$bayley_sub_update['user_modified'] = \Auth::user()->id;
    							$bayley_sub_update['date_modified'] = date('Y-m-d H:i:s');
    							$id = array_search($sub_id, $table_id_other);
    							$sub_results = BayleyScaleScore::findOrfail($id);
    							$sub_results->update($bayley_sub_update);
    						} else {
    							$bayley_sub_1[$i]['hdr_id'] = $bayley_id;
    							$bayley_sub_1[$i]['category_id'] = $category_id;
    							$bayley_sub_1[$i]['question_id'] = $question_id;
    							$bayley_sub_1[$i]['sub_question_id'] = $sub_id;
    							$bayley_sub_1[$i]['value'] = $value;
    							$bayley_sub_1[$i]['user_added'] = \Auth::user()->id;
    							$bayley_sub_1[$i]['date_added'] = date('Y-m-d H:i:s'); 
    							$i++;
    						}
    					}
    				}
    			}
    		}
    		BayleyScaleScore::insert($bayley_sub_1);

    		if (isset($input['correct']) && is_array($input['correct'])) {
    			BayleyScaleScore::leftJoin('mas_bayley_scale_sub', 'sub_question_id', 'mas_bayley_scale_sub.id')->where('type', 3)->where('hdr_id', $bayley_id)->update(['value'=> 0]);
    			foreach ($input['correct'] as $category_id => $questions) {
    				foreach ($questions as $question_id => $sub_question) {
    					foreach ($sub_question as $sub_id => $value) {
    						if (in_array($sub_id, $table_id_other)) {
    							$bayley_sub_update['value'] = $value == 'on' ? 1 : 0; 
    							$bayley_sub_update['user_modified'] = \Auth::user()->id;
    							$bayley_sub_update['date_modified'] = date('Y-m-d H:i:s');
    							$id = array_search($sub_id, $table_id_other);
    							$sub_results = BayleyScaleScore::findOrfail($id);
    							$sub_results->update($bayley_sub_update);
    						} else {
    							$bayley_sub_2[$i]['hdr_id'] = $bayley_id;
    							$bayley_sub_2[$i]['category_id'] = $category_id;
    							$bayley_sub_2[$i]['question_id'] = $question_id;
    							$bayley_sub_2[$i]['sub_question_id'] = $sub_id;
    							$bayley_sub_2[$i]['value'] = $value == 'on' ? 1 : 0; 
    							$bayley_sub_2[$i]['user_added'] = \Auth::user()->id;
    							$bayley_sub_2[$i]['date_added'] = date('Y-m-d H:i:s'); 
    							$i++;
    						}
    					}
    				}
    			}
    		}
    		BayleyScaleScore::insert($bayley_sub_2);

                // if (isset($bayley_id)) {
                //     // Editor content
                //     if (!isset($result->custom_detail) || (isset($result->custom_detail) && empty(trim(strip_tags($result->custom_detail))))) {
                //         $results_score = BayleyScaleScore::getPassData($bayley_id, 2)->groupBy('category_id')->map(function($list) {
                //             return $list->pluck('item', 'question_id');
                //         })
                //         ->toArray();

                //         $results_score_1 = BayleyScaleScore::getPassData($bayley_id, 1)->groupBy('category_id')->map(function($list) {
                //             return $list->pluck('item', 'question_id');
                //         })
                //         ->toArray();

                //         $bayley_result['custom_detail'] = '';
                //         foreach ($title as $title_key => $title_value) {
                //             if (isset($results_score[$title_key])) {
                //                 $bayley_result['custom_detail'] .= '<h3>'.$title_value.'</h3>';
                //                 $bayley_result['custom_detail'] .= '<h3>2 - Mastery</h3>';
                //                 foreach ($results_score[$title_key] as $key => $value) {
                //                     $temp = $key . '. ' . $value;
                //                     $bayley_result['custom_detail'] .= '<div>'.$temp.'</div>';
                //                 }
                //             }

                //             if (isset($results_score_1[$title_key])) {
                //                 $bayley_result['custom_detail'] .= '<h3>1 - Emerging</h3>';
                //                 foreach ($results_score_1[$title_key] as $key => $value) {
                //                     $temp = $key . '. ' . $value;
                //                     $bayley_result['custom_detail'] .= '<div>'.$temp.'</div>';
                //                 }
                //             }
                //         }
                //     } else {
                //         $bayley_result['custom_detail'] = isset($input['custom_detail']) ? $input['custom_detail'] : null;
                //     }

                //     if (!isset($result->home_program) || (isset($result->home_program) && empty(trim(strip_tags($result->home_program))))) {

                //         $zero_list[1] = [];
                //         $zero_list[2] = [];
                //         $zero_list[3] = [];
                //         $zero_list[4] = [];
                //         $zero_list[5] = [];

                //         $results_score_0 = BayleyScaleScore::getPassData($bayley_id, 0)->groupBy('category_id')->map(function($list) use (&$zero_list, $mas_list) {
                //             return $list->pluck('item', 'question_id');
                //         })
                //         ->toArray();

                //         for ($i = 1; $i <= 5; $i++) {
                //             if (isset($results_score_0[$i])) {
                //                 foreach ($results_score_0[$i] as $key => $value) {
                //                     // if (isset($zero_list[$i][$key-1]) || count($zero_list[$i]) == 0) {
                //                         // $zero_list[$i][$key] = '<b>' . $value . '</b> - ' . $mas_list[$i][$key];
                //                     // } else if (count($zero_list[$i]) != 5) {
                //                         // $zero_list[$i] = [];
                //                         $zero_list[$i][$key] = '<b>' . $value . '</b> - ' . $mas_list[$i][$key];
                //                     // }
                //                 }
                //             }
                //         }

                //         $bayley_result['home_program'] = '';

                //         // $bayley_result['home_program'] .= '<h2>Home Program</h2>';

                //         foreach ($title as $title_key => $title_value) {
                //             if (isset($zero_list[$title_key])) {
                //                 $bayley_result['home_program'] .= '<h3>'.$title_value.'</h3>';
                //                 foreach ($zero_list[$title_key] as $key => $value) {
                //                     $temp = '<b>' . $key . '. </b>' . $value;
                //                     $bayley_result['home_program'] .= '<div>'.$temp.'</div>';
                //                 }
                //             }
                //         }
                //     } else {
                //         $bayley_result['home_program'] = isset($input['home_program']) ? $input['home_program'] : null;
                //     }

                //     $bayley_result['user_modified'] = \Auth::user()->id;
                //     $bayley_result['date_modified'] = date('Y-m-d H:i:s');
                //     BayleyScale::where(['id'=> $bayley_id, 'neuro_visit_id'=> $neuro_visit_id])->update($bayley_result);
                // }

    	}

    }

    public static function storeIssa($input, $neuro_visit_id)
    {
    	$result = Issa::where('neuro_visit_id', $neuro_visit_id)->first();

    	if (isset($input['issa_answer']) && is_array($input['issa_answer']) && count($input['issa_answer']) > 0 && (isset($input['srr']) && $input['srr'] > 0) || (isset($input['er']) && $input['er'] > 0) || (isset($input['slc']) && $input['slc'] > 0) || (isset($input['bp']) && $input['bp'] > 0) || (isset($input['sa']) && $input['sa'] > 0) || (isset($input['cc']) && $input['cc'] > 0) || (isset($input['total']) && $input['total'] > 0) || (isset($input['issa_status']) && !empty($input['issa_status']))) {

    		$issa['answer'] = (isset($input['issa_answer']) && is_array($input['issa_answer']) && count($input['issa_answer']) > 0) ? json_encode($input['issa_answer']) : null;
    		$issa['srr'] = (isset($input['srr']) && $input['srr'] > 0) ? $input['srr'] : null;
    		$issa['er'] = (isset($input['er']) && $input['er'] > 0) ? $input['er'] : null;
    		$issa['slc'] = (isset($input['slc']) && $input['slc'] > 0) ? $input['slc'] : null;
    		$issa['bp'] = (isset($input['bp']) && $input['bp'] > 0) ? $input['bp'] : null;
    		$issa['sa'] = (isset($input['sa']) && $input['sa'] > 0) ? $input['sa'] : null;
    		$issa['cc'] = (isset($input['cc']) && $input['cc'] > 0) ? $input['cc'] : null;
    		$issa['total'] = (isset($input['total']) && $input['total'] > 0) ? $input['total'] : null;
    		$issa['status'] = (isset($input['issa_status']) && !empty($input['issa_status'])) ? $input['issa_status'] : null;

    		if (isset($result->id)) {
    			$issa['user_modified'] = \Auth::user()->id;
    			$issa['date_modified'] = date('Y-m-d H:i:s');
    			$result->update($issa);
    		} else {
    			$issa['neuro_visit_id'] = $neuro_visit_id;
    			$issa['user_added'] = \Auth::user()->id;
    			$issa['date_added'] = date('Y-m-d H:i:s'); 
    			Issa::create($issa);
    		}
    	}

    }

    public static function storeCars($input, $neuro_visit_id) {

    	$result = Cars::where('neuro_visit_id', $neuro_visit_id)->first();

    	if ((isset($input['relating_to_people']) && $input['relating_to_people'] > 0) || (isset($input['imitation']) && $input['imitation'] > 0) || (isset($input['emotional_response']) && $input['emotional_response'] > 0) || (isset($input['body_use']) && $input['body_use'] > 0) || (isset($input['object_use']) && $input['object_use'] > 0) || (isset($input['adaptation_to_change']) && $input['adaptation_to_change'] > 0) || (isset($input['visual_response']) && $input['visual_response'] > 0) || (isset($input['listening_response']) && $input['listening_response'] > 0) || (isset($input['tst_response_use']) && $input['tst_response_use'] > 0) || (isset($input['fear_nervous']) && $input['fear_nervous'] > 0) || (isset($input['verbal']) && $input['verbal'] > 0) || (isset($input['non_verbal']) && $input['non_verbal'] > 0) || (isset($input['activity_level']) && $input['activity_level'] > 0) || (isset($input['intellectual_response']) && $input['intellectual_response'] > 0) || (isset($input['general_imperssions']) && $input['general_imperssions'] > 0) || (isset($input['cars_total']) && $input['cars_total'] > 0) || (isset($input['cars_status']) && !empty($input['cars_status']))) {

    		$cars['relating_to_people'] = (isset($input['relating_to_people']) && $input['relating_to_people'] > 0) ? $input['relating_to_people'] : null;
    		$cars['imitation'] = (isset($input['imitation']) && $input['imitation'] > 0) ? $input['imitation'] : null;
    		$cars['emotional_response'] = (isset($input['emotional_response']) && $input['emotional_response'] > 0) ? $input['emotional_response'] : null;
    		$cars['body_use'] = (isset($input['body_use']) && $input['body_use'] > 0) ? $input['body_use'] : null;
    		$cars['object_use'] = (isset($input['object_use']) && $input['object_use'] > 0) ? $input['object_use'] : null;
    		$cars['adaptation_to_change'] = (isset($input['adaptation_to_change']) && $input['adaptation_to_change'] > 0) ? $input['adaptation_to_change'] : null;
    		$cars['visual_response'] = (isset($input['visual_response']) && $input['visual_response'] > 0) ? $input['visual_response'] : null;
    		$cars['listening_response'] = (isset($input['listening_response']) && $input['listening_response'] > 0) ? $input['listening_response'] : null;
    		$cars['tst_response_use'] = (isset($input['tst_response_use']) && $input['tst_response_use'] > 0) ? $input['tst_response_use'] : null;
    		$cars['fear_nervous'] = (isset($input['fear_nervous']) && $input['fear_nervous'] > 0) ? $input['fear_nervous'] : null;
    		$cars['verbal'] = (isset($input['verbal']) && $input['verbal'] > 0) ? $input['verbal'] : null;
    		$cars['non_verbal'] = (isset($input['non_verbal']) && $input['non_verbal'] > 0) ? $input['non_verbal'] : null;
    		$cars['activity_level'] = (isset($input['activity_level']) && $input['activity_level'] > 0) ? $input['activity_level'] : null;
    		$cars['intellectual_response'] = (isset($input['intellectual_response']) && $input['intellectual_response'] > 0) ? $input['intellectual_response'] : null;
    		$cars['general_imperssions'] = (isset($input['general_imperssions']) && $input['general_imperssions'] > 0) ? $input['general_imperssions'] : null;
    		$cars['total'] = (isset($input['cars_total']) && $input['cars_total'] > 0) ? $input['cars_total'] : null;
    		$cars['status'] = (isset($input['cars_status']) && !empty($input['cars_status'])) ? $input['cars_status'] : null;

    		if (isset($result->id)) {
    			$cars['user_modified'] = \Auth::user()->id;
    			$cars['date_modified'] = date('Y-m-d H:i:s');
    			$result->update($cars);
    		} else {
    			$cars['neuro_visit_id'] = $neuro_visit_id;
    			$cars['user_added'] = \Auth::user()->id;
    			$cars['date_added'] = date('Y-m-d H:i:s'); 
    			Cars::create($cars);
    		}
    	}
    }

    public function assessmentprint($id, Request $request) {

    	$id = \SiteHelpers::decrypt_id($id);

    	$results = NeuroVisit::findorfail($id);

    	$baby_detail = Baby::findOrfail($results->baby_id);

    	$overall_score = (object)[];
    	$overall_score->posture = $this->posture_overall_score;
    	$overall_score->tone_pattern_items = $this->tone_pattern_items_overall_score;
    	$overall_score->reflex_items = $this->reflex_items_overall_score;
    	$overall_score->movements = $this->movements_overall_score;
    	$overall_score->abnormal_signs = $this->abnormal_signs_overall_score;
    	$overall_score->behavioural_signs = $this->behavioural_signs_overall_score;

    	$overall_score->assessment_of_cranial = $this->assessment_of_cranial_overall_score;
    	$overall_score->assessment_of_posture = $this->assessment_of_posture_overall_score;
    	$overall_score->assessment_of_movements = $this->assessment_of_movements_overall_score;
    	$overall_score->assessment_of_tone = $this->assessment_of_tone_overall_score;
    	$overall_score->reflexes_and_reactions = $this->reflexes_and_reactions_overall_score;
    	$overall_score->section_2_motor_milestones = $this->section_2_motor_milestones_overall_score;
    	$overall_score->behaviour = $this->behaviour_overall_score;

    	$hnne_details = (object)[];
    	$result_hnne_details = \DB::table('hnne_details')->where('neuro_visit_id', $id)->first();
    	if (isset($result_hnne_details->id)) {
    		$hnne_details = $result_hnne_details;

    		$hnne_details->posture = isset($hnne_details->posture) ? array_sum(array_filter(json_decode($hnne_details->posture))) : 0;

    		$hnne_details->tone_pattern_items = isset($hnne_details->tone_pattern_items) ? array_sum(array_filter(json_decode($hnne_details->tone_pattern_items))) : 0;

    		$hnne_details->reflex_items = isset($hnne_details->reflex_items) ? array_sum(array_filter(json_decode($hnne_details->reflex_items))) : 0;

    		$hnne_details->movements = isset($hnne_details->movements) ? array_sum(array_filter(json_decode($hnne_details->movements))) : 0;

    		$hnne_details->abnormal_signs = isset($hnne_details->abnormal_signs) ? array_sum(array_filter(json_decode($hnne_details->abnormal_signs))) : 0;

    		$hnne_details->behavioural_signs = isset($hnne_details->behavioural_signs) ? array_sum(array_filter(json_decode($hnne_details->behavioural_signs))) : 0;


    	}
    	$hine_details = (object)[];
    	$result_hine_details = \DB::table('hine_details')->where('neuro_visit_id', $id)->first();
    	if (isset($result_hine_details->id)) {
    		$hine_details = $result_hine_details;

    		$hine_details->assessment_of_cranial = isset($hine_details->assessment_of_cranial) ? array_sum(array_filter(json_decode($hine_details->assessment_of_cranial))) : 0;

    		$hine_details->assessment_of_posture = isset($hine_details->assessment_of_posture) ? array_sum(array_filter(json_decode($hine_details->assessment_of_posture))) : 0;

    		$hine_details->assessment_of_movements = isset($hine_details->assessment_of_movements) ? array_sum(array_filter(json_decode($hine_details->assessment_of_movements))) : 0;

    		$hine_details->assessment_of_tone = isset($hine_details->assessment_of_tone) ? array_sum(array_filter(json_decode($hine_details->assessment_of_tone))) : 0;

    		$hine_details->reflexes_and_reactions = isset($hine_details->reflexes_and_reactions) ? array_sum(array_filter(json_decode($hine_details->reflexes_and_reactions))) : 0;

    		$hine_details->section_2_motor_milestones = isset($hine_details->section_2_motor_milestones) ? array_sum(array_filter(json_decode($hine_details->section_2_motor_milestones))) : 0;

    		$hine_details->behaviour = isset($hine_details->behaviour) ? array_sum(array_filter(json_decode($hine_details->behaviour))) : 0;

    	}
    	$m_chat_questions = MchatquestionsMaster::getQuestions();
    	$m_chat_followup_questions = MchatquestionsfollowupMaster::getQuestions();
    	$m_chat_followup_questions = collect($m_chat_followup_questions)->take(20);

    	$m_chat_results = Op::getMChatResults($results->baby_id)->where('type', false);

    	$m_chat_results_found = count($m_chat_results);

    	$m_chat_score = $m_chat_f_score = null;

    	if ($m_chat_results_found) {
    		$m_chat_results_type_1 = $m_chat_results->where('answer', 'No')->whereNotIn('question_id', [2, 5, 12])->count();
    		$m_chat_results_type_2 = $m_chat_results->where('answer', 'Yes')->whereIn('question_id', [2, 5, 12])->count();

    		$m_chat_score = $m_chat_results_type_1 + $m_chat_results_type_2;
    	}

    	$m_chat_results = $m_chat_results->pluck('answer', 'question_id')->toArray();

    	$m_chat_followup_results = Op::getMChatResults($results->baby_id)->where('question_id', '>=', 1)->where('question_id', '<=', 20)->where('type', true);

    	$m_chat_f_results_found = count($m_chat_followup_results);
    	if ($m_chat_f_results_found) {
    		$m_chat_f_results_type_1 = $m_chat_followup_results->whereNotIn('question_id', [2, 5, 12])->where('final_answer', 1)->count();
    		$m_chat_f_results_type_2 = $m_chat_followup_results->whereIn('question_id', [2, 5, 12])->where('final_answer', 0)->count();

    		$m_chat_f_score = $m_chat_f_results_type_1 + $m_chat_f_results_type_2;
    	}

    	$m_chat_followup_results = $m_chat_followup_results->pluck('answer', 'question_id')->toArray();

    	$mas_dasii_questions = DasiiquestionsMaster::getQuestions();
    	$dasii_motor_questions = $mas_dasii_questions->where('question_type', 'motor')->sortBy('question_number');
    	$dasii_mental_questions = $mas_dasii_questions->where('question_type', 'mental')->sortBy('question_number');

    	$result_mental_motor_details = \DB::table('dasii_mental_motor_screening')->where('neuro_visit_id', $id)->get()->groupby('type')->toArray();


    	if (isset($result_mental_motor_details[1])) {
    		$mental_answer = collect($result_mental_motor_details[1])->pluck('answer', 'question_id');
    	}
    	if (isset($result_mental_motor_details[2])) {
    		$motor_answer = collect($result_mental_motor_details[2])->pluck('answer', 'question_id');
    	}

    	$ddst_setting = \DB::table('ddst_settings')->orderBy('id', 'asc')->get();

    	$ddst_settings = [];
    	$ddst_age = 0;
    	$ddst_results = \DB::table('ddst_details')->where('neuro_visit_id', $id)->orderby('id', 'desc')->get();

    	if (count($ddst_results) > 0) {
    		$ddst_age = $ddst_results[0]->age;
    		$ddst_result = collect($ddst_results)->pluck('status', 'task_id')->toArray();
    	}

    	$ddst_array = 0;
    	foreach ($ddst_setting as $value) {

    		$color = '#7ED2E5';

    		if (isset($ddst_result[$value->task_id])) {
    			if ($ddst_result[$value->task_id] == 1) {
    				$color = '#47a447';
    			} elseif ($ddst_result[$value->task_id] == 2) {
    				$color = '#d2322d';
    			} elseif ($ddst_result[$value->task_id] == 3) {
    				$color = '#3968c6';
    			} elseif ($ddst_result[$value->task_id] == 4) {
    				$color = '#ed9c28';
    			}
    		}

    		$fill = $value->fill == '#7ED2E5' ? $color : $value->fill;
    		$stroke = $value->stroke != null ? $color : $value->stroke;

    		$temp_settings['taskid'] = $value->task_id;
    		$temp_settings['task'] = $value->name;
    		$temp_settings['value'] = $value->x_value;
    		$temp_settings['endValue'] = $value->x_end_value;
    		$temp_settings['yvalue'] = $value->y_value;
    		$temp_settings['yendValue'] = $value->y_end_value;
    		$temp_settings['columnSettings'] =  ["fill" => $fill, "stroke" => $stroke];
    		$temp_settings['siblings'] = $value->siblings;
    		$temp_settings['nofill'] = $value->nofill;
    		$temp_settings['rowsize'] = $value->rowsize;
    		$temp_settings['rrposition'] = $value->rrposition;
    		$temp_settings['rbposition'] = $value->rbposition;
    		$temp_settings['countno'] = $value->countno;
    		$temp_settings['ctposition'] = $value->ctposition;
    		$temp_settings['crposition'] = $value->crposition;
    		$temp_settings['taskalign'] = $value->align;
    		$temp_settings['percentage'] = $value->percentage;
    		$temp_settings['percentage_align'] = $value->percentage_align;
    		$temp_settings['array_id'] = $ddst_array;

    		$ddst_settings[] = $temp_settings;
    		unset($temp_settings);
    		$ddst_array++;
    	}

    	$cbcl_question = CBCLquestionsMaster::list();

    	$cbcl_result = \DB::table('neuro_cbcl_screening')->where('neuro_visit_id', $id)->get()->keyBy('question_id');

    	if ($request->get('closewinlink') == 'list-view') {
    		$closewinlink = action('Registration\NeuroController@NeuroSubList', \SiteHelpers::encrypt_id($results->baby_id));
    	} elseif ($request->get('closewinlink') == 'neonatal-op-list-view') {
    		$closewinlink = action('Registration\OpController@OpsubList', \SiteHelpers::encrypt_id($results->baby_id));
    	} else {
    		$closewinlink = action('Registration\NeuroController@edit', \SiteHelpers::encrypt_id($id));            
    	}


    	$cc_infant_results = \DB::table('carolina_infants_details')->where('baby_id', $results->baby_id)->where('visit_date', '<=', $results->visit_date)->orderBy('visit_date', 'ASC')->get()->pluck('result_data')->toArray();

    	$check_carolina_infants_details_exist = \DB::table('carolina_infants_details')->where('neuro_visit_id', $id)->first();

    	if (empty($check_carolina_infants_details_exist->neuro_visit_id)) {
    		$cc_infant_results[] = [];
    	}

    	$cc_preschoolers_results = \DB::table('carolina_preschoolers_details')->where('baby_id', $results->baby_id)->where('visit_date', '<=', $results->visit_date)->orderBy('visit_date', 'ASC')->get()->pluck('result_data')->toArray();

    	$check_carolina_preschoolers_details_exist = \DB::table('carolina_preschoolers_details')->where('neuro_visit_id', $id)->first();

    	if (empty($check_carolina_preschoolers_details_exist->neuro_visit_id)) {
    		$cc_preschoolers_results[] = [];
    	}

        //ISSA
    	$issa_result = Issa::where('neuro_visit_id', $id)->orderBy('id', 'desc')->first();

	    $issa_answer = [];
        if (isset($issa_result->answer)) {
	        $temp_issa_answer = json_decode($issa_result->answer);
	        foreach ($temp_issa_answer as $key => $value) {
		        $issa_answer[$key] = $value;
	        }

            $issa_result->answer = $issa_answer;
        }

        $issa_question = ISSAquestionsMaster::list()->groupBy('category')->toArray();

    	return view('registration.neuro.assessment_print', compact('results', 'hnne_details', 'overall_score', 'hine_details', 'm_chat_questions', 'm_chat_results', 'dasii_motor_questions', 'dasii_mental_questions', 'mental_answer', 'motor_answer', 'ddst_settings', 'ddst_age', 'm_chat_followup_questions', 'm_chat_followup_results', 'm_chat_score', 'm_chat_f_score', 'baby_detail', 'closewinlink', 'cbcl_question', 'cbcl_result', 'current_visit_infants', 'previous_visit_infants_json','current_visit_preschoolers','previous_visit_preschoolers_json','cc_infant_results','cc_preschoolers_results', 'issa_result', 'issa_question'));
    }

    /**
     * Store a newly created appointment.
     *
     */
    public function makeAppointment($input, $id = 0)
    {
    	if (isset($input['review']) && !is_null($input['review']) && !empty($input['review']) && $id != 0) {
    		$appointment_details = new Request([
    			'category'   => !empty($input['appointment_type']) ? $input['appointment_type'] : 'Review Appointment',
    			'date'       => $input['review'],
    			'time'       => $input['review_time'],
    			'mins'       => $input['review_min'],
    			'session'    => $input['review_session'],
    			'consultant' => env('DEFAULT_NEURO_SEEN_BY'),
    			'patient'    => $input['BabyId'],
    			'ref_id'     => $id,
    			'from'       => 2
    		]);
    		FlowController::patientDetailUpdate($appointment_details, 0);
    	}

    }

    // Check the OP visit is exist for the selected date
    public function checkSameDateIsNeuroOPExist(Request $request)
    {
    	$input = $request->all();

    	$result = NeuroVisit::where('baby_id', $input['baby_id'])->where('visit_date', date('Y-m-d', strtotime($input['op_date'])))->where('is_deleted', 0)->first();

    	return isset($result->id) ? action('Registration\NeuroController@edit', \SiteHelpers::encrypt_id($result->id)) : null;

    }

    // Import Bayley scale - Only import which question has a value 2
    public function import(Request $request)
    {
    	$input = $request->all();
    	$neuro_visit_id = $input['id'];
    	$field_name = $input['field'];

    	$result = BayleyScale::where('neuro_visit_id', $neuro_visit_id)->first();

    	$bayley_result = [];
    	$mas_list = BayleyScaleMaster::getData()->where('score', 2)->groupBy('category')->map(function($list) {
    		return $list->pluck('title', 'question_no');
    	})
    	->toArray();

    	$title[1] = 'Cognitive (CG)';
    	$title[2] = 'Receptive Communication (RC)';
    	$title[3] = 'Expressive Communication (EC)';
    	$title[4] = 'Fine Motor (FM)';
    	$title[5] = 'Gross Motor (GM)';

    	if ($field_name == 'baby_behavior') {
    		if (isset($result->id)) {

    			$results_score = BayleyScaleScore::getPassData($result->id, 2)->groupBy('category_id')->map(function($list) {
    				return $list->pluck('item', 'question_id');
    			})
    			->toArray();

    			$results_score_1 = BayleyScaleScore::getPassData($result->id, 1)->groupBy('category_id')->map(function($list) {
    				return $list->pluck('item', 'question_id');
    			})
    			->toArray();

    			$bayley_result['baby_behavior'] = '';
    			foreach ($title as $title_key => $title_value) {
    				if (isset($results_score[$title_key])) {
    					$bayley_result['baby_behavior'] .= '<h3>'.$title_value.'</h3>';
    					$bayley_result['baby_behavior'] .= '<h3>2 - Mastery</h3>';
    					foreach ($results_score[$title_key] as $key => $value) {
    						$temp = $key . '. ' . $value;
    						$bayley_result['baby_behavior'] .= '<div>'.$temp.'</div>';
    					}
    				}

    				if (isset($results_score_1[$title_key])) {
    					$bayley_result['baby_behavior'] .= '<h3>1 - Emerging</h3>';
    					foreach ($results_score_1[$title_key] as $key => $value) {
    						$temp = $key . '. ' . $value;
    						$bayley_result['baby_behavior'] .= '<div>'.$temp.'</div>';
    					}
    				}
    			}
    		}
    	}

    	if ($field_name == 'home_program') {
    		if (isset($result->id)) {

    			$zero_list[1] = [];
    			$zero_list[2] = [];
    			$zero_list[3] = [];
    			$zero_list[4] = [];
    			$zero_list[5] = [];

    			$results_score_0 = BayleyScaleScore::getPassData($result->id, 0)->groupBy('category_id')->map(function($list) use (&$zero_list, $mas_list) {
    				return $list->pluck('item', 'question_id');
    			})
    			->toArray();

    			for ($i = 1; $i <= 5; $i++) {
    				if (isset($results_score_0[$i])) {
    					foreach ($results_score_0[$i] as $key => $value) {
                            // if (isset($zero_list[$i][$key-1]) || count($zero_list[$i]) == 0) {
                            //     $zero_list[$i][$key] = '<b>' . $value . '</b> - ' . $mas_list[$i][$key];
                            // } else if (count($zero_list[$i]) != 5) {
                            //     $zero_list[$i] = [];
    						$zero_list[$i][$key] = '<b>' . $value . '</b> - ' . $mas_list[$i][$key];
                            // }
    					}
    				}
    			}

    			$bayley_result['home_program'] = '';

                // $bayley_result['home_program'] .= '<h2>Home Program</h2>';

    			foreach ($title as $title_key => $title_value) {
    				if (isset($zero_list[$title_key])) {
    					$bayley_result['home_program'] .= '<h3>'.$title_value.'</h3>';
    					foreach ($zero_list[$title_key] as $key => $value) {
    						$temp = '<b>' . $key . '. </b>' . $value;
    						$bayley_result['home_program'] .= '<div>'.$temp.'</div>';
    					}
    				}
    			}
    		}
    	}

    	return $bayley_result;

    }
    
    public function infantChart(Request $request)
    {
    	$input = $request->all();

    	$neuro_visit_id = $input['neuro_visit_id'];
    	if (isset($input['visit_date'])) {
    		$op_date = $input['visit_date'];
    	} elseif (isset($input['visit_date'])) {
    		$op_date = $input['old_visit_date'];
    	}
    	$main_index = $input['main_index'];
    	$object_index = $input['object_index'];
    	$value = $input['res_value'];
    	$baby_id = $input['baby_id'];

        //$data  = $input['result_data'];

    	if (!empty($object_index) && !empty($main_index)) {
    		$check_carolina_infants_details_exist = \DB::table('carolina_infants_details')->where('neuro_visit_id', $neuro_visit_id)->where('baby_id', $baby_id)->first();

    		if (isset($check_carolina_infants_details_exist->id) && !empty($check_carolina_infants_details_exist->id)) {

    			if (isset($check_carolina_infants_details_exist->result_data) && !empty($check_carolina_infants_details_exist->result_data)) {
    				$res_array = json_decode($check_carolina_infants_details_exist->result_data, true);
    			}
    			$res_array[$main_index][$object_index] = $value;
    			$carolina_infants_details['modified_date_time'] = date('Y-m-d H:i:s');
    			$carolina_infants_details['modified_user'] = \Auth::user()->id;
                if (!empty($res_array)) {
    			    $carolina_infants_details['result_data'] = json_encode($res_array);
                }
    			$result = \DB::table('carolina_infants_details')->where('id', $check_carolina_infants_details_exist->id)->update($carolina_infants_details);

    		} else {

    			$res_array[$main_index][$object_index] = $value;
    			$carolina_infants_details['created_date_time'] = date('Y-m-d H:i:s');
    			$carolina_infants_details['created_user'] = \Auth::user()->id;
    			$carolina_infants_details['neuro_visit_id'] = $neuro_visit_id;
    			$carolina_infants_details['visit_date'] = date('Y-m-d', strtotime($op_date));
    			$carolina_infants_details['baby_id'] = $baby_id;
                // $carolina_infants_details['visit_count'] = $visit_count;
                if (!empty($res_array)) {
    			    $carolina_infants_details['result_data'] = json_encode($res_array);
                }
    			$result = \DB::table('carolina_infants_details')->insert($carolina_infants_details);
    		}


    		if ($result){
    			$statusMsg = 'Data was succesfully captured';
    			return response()->json(array('msg'=> $statusMsg), 200);
    		}

    	} else {
    		return response()->json(array('msg'=> "indexes are empty"), 200);
    	}

    }

    public function preschoolersChart(Request $request)
    {

    	$input = $request->all();

    	$neuro_visit_id = $input['neuro_visit_id'];
    	if (isset($input['visit_date'])) {
    		$op_date = $input['visit_date'];
    	} elseif (isset($input['visit_date'])) {
    		$op_date = $input['old_visit_date'];
    	}
    	$main_index = $input['main_index'];
    	$object_index = $input['object_index'];
    	$value = $input['res_value'];
    	$baby_id = $input['baby_id'];

    	if (!empty($object_index) && !empty($main_index)) {
    		$check_carolina_preschoolers_details_exist = \DB::table('carolina_preschoolers_details')->where('neuro_visit_id', $neuro_visit_id)->where('baby_id', $baby_id)->first();

    		if (isset($check_carolina_preschoolers_details_exist->id) && !empty($check_carolina_preschoolers_details_exist->id)) {

    			if (isset($check_carolina_preschoolers_details_exist->result_data) && !empty($check_carolina_preschoolers_details_exist->result_data)) {
    				$res_array = json_decode($check_carolina_preschoolers_details_exist->result_data, true);
    			}
    			$res_array[$main_index][$object_index] = $value;
    			$carolina_preschoolers_details['modified_date_time'] = date('Y-m-d H:i:s');
    			$carolina_preschoolers_details['modified_user'] = \Auth::user()->id;
                if (!empty($res_array)) {
    			    $carolina_preschoolers_details['result_data'] = json_encode($res_array);
                }
    			$result = \DB::table('carolina_preschoolers_details')->where('id', $check_carolina_preschoolers_details_exist->id)->update($carolina_preschoolers_details);
    		} else {

    			$res_array[$main_index][$object_index] = $value;
    			$carolina_preschoolers_details['created_date_time'] = date('Y-m-d H:i:s');
    			$carolina_preschoolers_details['created_user'] = \Auth::user()->id;
    			$carolina_preschoolers_details['neuro_visit_id'] = $neuro_visit_id;
    			$carolina_preschoolers_details['visit_date'] = date('Y-m-d', strtotime($op_date));
    			$carolina_preschoolers_details['baby_id'] = $baby_id ;
                if (!empty($res_array)) {
    			    $carolina_preschoolers_details['result_data'] = json_encode($res_array);
                }
    			$result = \DB::table('carolina_preschoolers_details')->insert($carolina_preschoolers_details);
    		}

    		if ($result) {
    			$statusMsg = 'Data was succesfully captured';
    			return response()->json(array('msg'=> $statusMsg), 200);
    		}

    	} else {
    		return response()->json(array('msg'=> "indexes are empty"), 200);
    	}

    }

    public static function storeInfants($input, $neuro_visit_id, $visit_date) {
    	$result = \DB::table('carolina_infants_details')->where('neuro_visit_id', $neuro_visit_id)->first();

    	if (isset($input['infants_personal_social']) || isset($input['infants_cognition']) || isset($input['infants_cognition_communication'])  || isset($input['infants_fine_motor']) || isset($input['infants_gross_motor'])) {

    		$infants['infants_personal_social'] = $input['infants_personal_social'] ;
    		$infants['infants_cognition'] = $input['infants_cognition'] ;
    		$infants['infants_cognition_communication'] = $input['infants_cognition_communication'];
    		$infants['infants_fine_motor'] = $input['infants_fine_motor'] ;
    		$infants['infants_gross_motor'] = $input['infants_gross_motor'];

    		if (isset($result->id)) {
    			$infants['modified_user'] = \Auth::user()->id;
    			$infants['modified_date_time'] = date('Y-m-d H:i:s');
    			$infants['visit_date'] = $visit_date;
    			\DB::table('carolina_infants_details')->where('neuro_visit_id', $neuro_visit_id)->update($infants);
    		} else {
    			$infants['baby_id'] = $input['BabyId'];
    			$infants['visit_date'] = $visit_date;
    			$infants['neuro_visit_id'] = $neuro_visit_id;
    			$infants['created_user'] = \Auth::user()->id;
    			$infants['created_date_time'] = date('Y-m-d H:i:s'); 
    			\DB::table('carolina_infants_details')->insert($infants);
    		}
    	}
    }

    public static function storePreschoolers($input, $neuro_visit_id, $visit_date) {

    	$result = \DB::table('carolina_preschoolers_details')->where('neuro_visit_id', $neuro_visit_id)->first();

    	if (isset($input['preschoolers_personal_social'])  || isset($input['preschoolers_cognition']) || isset($input['preschoolers_cognition_communication'])    ||  isset($input['preschoolers_fine_motor'])  || isset($input['preschoolers_gross_motor'])){

    		$preschoolers['preschoolers_personal_social'] = $input['preschoolers_personal_social'];
    		$preschoolers['preschoolers_cognition'] = $input['preschoolers_cognition'];
    		$preschoolers['preschoolers_cognition_communication'] = $input['preschoolers_cognition_communication'];
    		$preschoolers['preschoolers_fine_motor'] = $input['preschoolers_fine_motor'];
    		$preschoolers['preschoolers_gross_motor'] = $input['preschoolers_gross_motor'];

    		if (isset($result->id)) {
    			$preschoolers['modified_user'] = \Auth::user()->id;
    			$preschoolers['modified_date_time'] = date('Y-m-d H:i:s');
    			$preschoolers['visit_date'] = $visit_date;
    			\DB::table('carolina_preschoolers_details')->where('neuro_visit_id', $neuro_visit_id)->update($preschoolers);
    		} else {
    			$preschoolers['baby_id'] = $input['BabyId'];
    			$preschoolers['neuro_visit_id'] = $neuro_visit_id;
    			$preschoolers['visit_date'] = $visit_date;
    			$preschoolers['created_user'] = \Auth::user()->id;
    			$preschoolers['created_date_time'] = date('Y-m-d H:i:s'); 
    			\DB::table('carolina_preschoolers_details')->insert($preschoolers);
    		}
    	}
    }

    public static function storePep3($input, $neuro_visit_id) {

    	$result = \DB::table('neuro_pep')->where('neuro_visit_id', $neuro_visit_id)->first();

    	if (isset($input['cvp_raw_score']) || isset($input['cvp_developemental_age']) || isset($input['cvp_rank']) || isset($input['cvp_development_adaptive_level']) || isset($input['el_raw_score']) || isset($input['el_developemental_age']) || isset($input['el_rank']) || isset($input['el_development_adaptive_level']) || isset($input['rl_raw_score']) || isset($input['rl_developemental_age']) || isset($input['rl_rank']) || isset($input['rl_development_adaptive_level']) || isset($input['fm_raw_score']) || isset($input['fm_developemental_age']) || isset($input['fm_rank']) || isset($input['fm_development_adaptive_level']) || isset($input['gm_raw_score']) || isset($input['gm_developemental_age']) || isset($input['gm_rank']) || isset($input['gm_development_adaptive_level']) || isset($input['vmi_raw_score']) || isset($input['vmi_developemental_age']) || isset($input['vmi_rank']) || isset($input['vmi_development_adaptive_level']) || isset($input['ae_raw_score']) || isset($input['ae_developemental_age']) || isset($input['ae_rank']) || isset($input['ae_development_adaptive_level']) || isset($input['sr_raw_score']) || isset($input['sr_developemental_age']) || isset($input['sr_rank']) || isset($input['sr_development_adaptive_level']) || isset($input['cmb_raw_score']) || isset($input['cmb_developemental_age']) || isset($input['cmb_rank']) || isset($input['cmb_development_adaptive_level']) || isset($input['cvb_raw_score']) || isset($input['cvb_developemental_age']) || isset($input['cvb_rank']) || isset($input['cvb_development_adaptive_level']) || isset($input['com_standard_score']) || isset($input['com_rank']) || isset($input['com_development_adaptive_level']) || isset($input['com_developemental_age']) || isset($input['motor_standard_score']) || isset($input['motor_rank']) || isset($input['motor_development_adaptive_level']) || isset($input['motor_developemental_age']) || isset($input['mb_standard_score']) || isset($input['mb_rank']) || isset($input['mb_development_adaptive_level']) || isset($input['mb_developemental_age'])) {

    		$pep['cvp_raw_score'] = isset($input['cvp_raw_score']) ? $input['cvp_raw_score'] : null;
			$pep['cvp_developemental_age'] = isset($input['cvp_developemental_age']) ? $input['cvp_developemental_age'] : null;
			$pep['cvp_rank'] = isset($input['cvp_rank']) ? $input['cvp_rank'] : null;
			$pep['cvp_development_adaptive_level'] = isset($input['cvp_development_adaptive_level']) ? $input['cvp_development_adaptive_level'] : null;
			$pep['el_raw_score'] = isset($input['el_raw_score']) ? $input['el_raw_score'] : null;
			$pep['el_developemental_age'] = isset($input['el_developemental_age']) ? $input['el_developemental_age'] : null;
			$pep['el_rank'] = isset($input['el_rank']) ? $input['el_rank'] : null;
			$pep['el_development_adaptive_level'] = isset($input['el_development_adaptive_level']) ? $input['el_development_adaptive_level'] : null;
			$pep['rl_raw_score'] = isset($input['rl_raw_score']) ? $input['rl_raw_score'] : null;
			$pep['rl_developemental_age'] = isset($input['rl_developemental_age']) ? $input['rl_developemental_age'] : null;
			$pep['rl_rank'] = isset($input['rl_rank']) ? $input['rl_rank'] : null;
			$pep['rl_development_adaptive_level'] = isset($input['rl_development_adaptive_level']) ? $input['rl_development_adaptive_level'] : null;
			$pep['fm_raw_score'] = isset($input['fm_raw_score']) ? $input['fm_raw_score'] : null;
			$pep['fm_developemental_age'] = isset($input['fm_developemental_age']) ? $input['fm_developemental_age'] : null;
			$pep['fm_rank'] = isset($input['fm_rank']) ? $input['fm_rank'] : null;
			$pep['fm_development_adaptive_level'] = isset($input['fm_development_adaptive_level']) ? $input['fm_development_adaptive_level'] : null;
			$pep['gm_raw_score'] = isset($input['gm_raw_score']) ? $input['gm_raw_score'] : null;
			$pep['gm_developemental_age'] = isset($input['gm_developemental_age']) ? $input['gm_developemental_age'] : null;
			$pep['gm_rank'] = isset($input['gm_rank']) ? $input['gm_rank'] : null;
			$pep['gm_development_adaptive_level'] = isset($input['gm_development_adaptive_level']) ? $input['gm_development_adaptive_level'] : null;
			$pep['vmi_raw_score'] = isset($input['vmi_raw_score']) ? $input['vmi_raw_score'] : null;
			$pep['vmi_developemental_age'] = isset($input['vmi_developemental_age']) ? $input['vmi_developemental_age'] : null;
			$pep['vmi_rank'] = isset($input['vmi_rank']) ? $input['vmi_rank'] : null;
			$pep['vmi_development_adaptive_level'] = isset($input['vmi_development_adaptive_level']) ? $input['vmi_development_adaptive_level'] : null;
			$pep['ae_raw_score'] = isset($input['ae_raw_score']) ? $input['ae_raw_score'] : null;
			$pep['ae_developemental_age'] = isset($input['ae_developemental_age']) ? $input['ae_developemental_age'] : null;
			$pep['ae_rank'] = isset($input['ae_rank']) ? $input['ae_rank'] : null;
			$pep['ae_development_adaptive_level'] = isset($input['ae_development_adaptive_level']) ? $input['ae_development_adaptive_level'] : null;
			$pep['sr_raw_score'] = isset($input['sr_raw_score']) ? $input['sr_raw_score'] : null;
			$pep['sr_developemental_age'] = isset($input['sr_developemental_age']) ? $input['sr_developemental_age'] : null;
			$pep['sr_rank'] = isset($input['sr_rank']) ? $input['sr_rank'] : null;
			$pep['sr_development_adaptive_level'] = isset($input['sr_development_adaptive_level']) ? $input['sr_development_adaptive_level'] : null;
			$pep['cmb_raw_score'] = isset($input['cmb_raw_score']) ? $input['cmb_raw_score'] : null;
			$pep['cmb_developemental_age'] = isset($input['cmb_developemental_age']) ? $input['cmb_developemental_age'] : null;
			$pep['cmb_rank'] = isset($input['cmb_rank']) ? $input['cmb_rank'] : null;
			$pep['cmb_development_adaptive_level'] = isset($input['cmb_development_adaptive_level']) ? $input['cmb_development_adaptive_level'] : null;
			$pep['cvb_raw_score'] = isset($input['cvb_raw_score']) ? $input['cvb_raw_score'] : null;
			$pep['cvb_developemental_age'] = isset($input['cvb_developemental_age']) ? $input['cvb_developemental_age'] : null;
			$pep['cvb_rank'] = isset($input['cvb_rank']) ? $input['cvb_rank'] : null;
			$pep['cvb_development_adaptive_level'] = isset($input['cvb_development_adaptive_level']) ? $input['cvb_development_adaptive_level'] : null;
			$pep['com_standard_score'] = isset($input['com_standard_score']) ? $input['com_standard_score'] : null;
			$pep['com_rank'] = isset($input['com_rank']) ? $input['com_rank'] : null;
			$pep['com_development_adaptive_level'] = isset($input['com_development_adaptive_level']) ? $input['com_development_adaptive_level'] : null;
			$pep['com_developemental_age'] = isset($input['com_developemental_age']) ? $input['com_developemental_age'] : null;
			$pep['motor_standard_score'] = isset($input['motor_standard_score']) ? $input['motor_standard_score'] : null;
			$pep['motor_rank'] = isset($input['motor_rank']) ? $input['motor_rank'] : null;
			$pep['motor_development_adaptive_level'] = isset($input['motor_development_adaptive_level']) ? $input['motor_development_adaptive_level'] : null;
			$pep['motor_developemental_age'] = isset($input['motor_developemental_age']) ? $input['motor_developemental_age'] : null;
			$pep['mb_standard_score'] = isset($input['mb_standard_score']) ? $input['mb_standard_score'] : null;
			$pep['mb_rank'] = isset($input['mb_rank']) ? $input['mb_rank'] : null;
			$pep['mb_development_adaptive_level'] = isset($input['mb_development_adaptive_level']) ? $input['mb_development_adaptive_level'] : null;
			$pep['mb_developemental_age'] = isset($input['mb_developemental_age']) ? $input['mb_developemental_age'] : null;
    		if (isset($result->id)) {
    			\DB::table('neuro_pep')->where('neuro_visit_id', $neuro_visit_id)->update($pep);
    		} else {
    			$pep['baby_id'] = $input['BabyId'];
    			$pep['neuro_visit_id'] = $neuro_visit_id;
    			\DB::table('neuro_pep')->insert($pep);
    		}
    	}
    }

}
