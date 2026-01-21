<?php

namespace App\Http\Controllers\Registration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Feeding;
use App\Models\Baby;
use App\Models\Mother;
use Carbon\Carbon;
use App\Models\DischargeSummary;
use App\Models\Postnatal;
use App\Models\Nicu;
use App\Models\Op;
use App\Models\PostDaycare;
use App\Models\Reports\PostProblemDischargeSummary;
use App\Models\Daycare;
use App\Models\Icd;
use App\Models\Reports\ProblemDischarge;
use Illuminate\Contracts\Auth\Guard;
use App\Models\PostnatalDischarge;
use App\Models\Pediatric;
use App\Models\Settings\Settings;

class FeedingController extends Controller
{
    public function __construct(Guard $auth)
    {
        $this->middleware('role:FEEDING,write', ['only' => ['store', 'update', 'edit', 'create', 'destory']]);
        $this->middleware('role:FEEDING,read', ['only' => ['index', 'show']]);
        $this->time_zone = env('TIME_ZONE');
        $this->auth = $auth;
        $this->seen_by = [48];
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

        $navigate['main_nav'] = 'registration';
        $navigate['sub_nav'] = 'feeding';
        $result = Feeding::get_lists($request->input('page') , $limit, $search, $order, 1);
        $results = $result['result'];
        $getTotal = Feeding::GetTotal();
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

        return view('registration.feeding.list', compact('results', 'navigate', 'pagination', 'search', 'getTotal', 'order'));
    }

    public function chooseBaby()
    {
        $navigate['main_nav'] = 'registration';
        $navigate['sub_nav'] = 'feeding';
        $baby = Baby::baby_list_op();
        $babies = \ValuelistHelpers::select2DataFormater($baby, true, true, 'Create New Registration');

        $SubmitButtonText = "Start";

        $type = 1;

        return view('registration.feeding.select_patient', compact('SubmitButtonText', 'babies', 'navigate', 'type'));
    }

    public function chooseMother()
    {
        $navigate['main_nav'] = 'registration';
        $navigate['sub_nav'] = 'feeding';
        $mother = Mother::ListData();
        $babies = \ValuelistHelpers::select2DataFormater($mother, true, true, 'Create New Registration');

        $SubmitButtonText = "Start";

        $type = 0;        

        return view('registration.feeding.select_patient', compact('SubmitButtonText', 'babies', 'navigate', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($item)
    {
        $item_formatting = explode('-$-', $item);

        $id = \SiteHelpers::decrypt_id($item_formatting[0]);

        $type = $item_formatting[1];

        if (empty($id) && $id == 0)
        {
            $results = (object)[];
        }
        else
        {
            if (!$type) {
                $results = Mother::GetData($id)[0]->toArray();
                $baby_results = Mother::where('MotherId', $results['MotherId'])->first()->toArray();
                $results = array_merge($results, $baby_results);
                $results = (object)$results;
            } else { 
                $baby_results = Baby::get_data($id)->groupBy('BabyId')->toArray();
                ksort($baby_results);
                $results = collect($baby_results)->first() [0];
                if (isset($results->BMrNo)) {
                    $results->background_details = $this->getBabyBackgroundDetails($results->BMrNo)->original['background_details'];
                }
                if (isset($results->DOB)) {
                    $results->DOB = date('d-m-Y', strtotime($results->DOB));
                }
                if (isset($results->BabyId)) {
                    $nicu_discharge = Nicu::select('DischargeDate', 'DischargeWeight')->where('BabyId', $results->BabyId)->orderBy('NicuId', 'desc')->first();
                    $postnatal_discharge = PostnatalDischarge::select('discharge_date', 'discharge_wt')->where('BabyId', $results->BabyId)->orderBy('posdisid', 'desc')->first();
                    $pediatric_discharge = Pediatric::select('status_date', 'status', 'status_weight')->where('status', '<>', 'Inpatient')->where('baby_id', $results->BabyId)->orderBy('id', 'desc')->first();
                    $discharge_list = [];
                    if (isset($nicu_discharge->DischargeDate)) {
                        $discharge_list[$nicu_discharge->DischargeDate] = $nicu_discharge->DischargeWeight;
                    }
                    if (isset($postnatal_discharge->discharge_date)) {
                        $discharge_list[$postnatal_discharge->discharge_date] = $postnatal_discharge->discharge_wt;
                    }
                    if (isset($pediatric_discharge->status_date)) {
                        $discharge_list[$pediatric_discharge->status_date] = $pediatric_discharge->status_weight;
                    }
                    if (is_array($discharge_list) && count($discharge_list) > 0) {
                        krsort($discharge_list);
                        $results->discharge_weight = collect($discharge_list)->first();
                    }
                }
            }
        }
        $current_date = date('d-m-Y');
        $time = \SiteHelpers::prepare_time();
        $current_time = [];
        $current_time['hours'] = (int)date("h", strtotime(Carbon::now(env('TIME_ZONE'))));
        $current_time['mins'] = (int)date("i", strtotime(Carbon::now(env('TIME_ZONE'))));
        $current_time['am'] = date("A", strtotime(Carbon::now(env('TIME_ZONE'))));

        $settings = Settings::find(1);
        $dvs = $settings->hms_primary_consultant_id;
        $rks = $settings->hms_secondary_consultant_id;
        $neuro_consultant_id = $settings->hms_neuro_consultant_id;
        $doctor_master = \ValuelistHelpers::mas_doctors_list();

        $results->seen_by = json_encode($this->seen_by);

        return view('registration.feeding.create', compact('results', 'current_date', 'time', 'current_time', 'background_details_details', 'id', 'type', 'dvs', 'rks', 'neuro_consultant_id', 'doctor_master'));
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

        $mother_id = $baby_id = null;

        $mother_post['MotherName'] = (isset($input['MotherName']) && !empty($input['MotherName'])) ? $input['MotherName'] : null;
        $mother_post['MMrNo'] = (isset($input['MMrNo']) && !empty($input['MMrNo'])) ? $input['MMrNo'] : null;

        if (!is_null($mother_post['MotherName'])) {
            if (isset($input['mother_id']) && $input['mother_id'] != '' && $input['mother_id'] != 0)
            {
                $mother_post['UserModified'] = $this->auth->user()->id;
                $mother_post['DateModified'] = Carbon::now();
                $mother = Mother::findOrfail($input['mother_id']);
                $mother->update($input);
                $mother_id = $input['mother_id'];
            }
            else
            {
                $mother_post['DateAdded'] = Carbon::now();
                $mother_post['UserAdded'] = $this->auth->user()->id;
                $mother = Mother::create($mother_post);
                $mother_id = $mother->MotherId;
            }
        }

        $baby_post['BabyName'] = (isset($input['BabyName']) && !empty($input['BabyName'])) ? $input['BabyName'] : null;
        $baby_post['BMrNo'] = (isset($input['BMrNo']) && !empty($input['BMrNo'])) ? $input['BMrNo'] : null;

        if (!is_null($baby_post['BabyName'])) {
            $baby_post['g_weeks'] = (isset($input['g_weeks']) && !empty($input['g_weeks'])) ? $input['g_weeks'] : null;
            $baby_post['g_days'] = (isset($input['g_days']) && !empty($input['g_days'])) ? $input['g_days'] : null;
            $baby_post['Sex'] = (isset($input['Sex']) && !empty($input['Sex'])) ? $input['Sex'] : null;
            $baby_post['DOB'] = (isset($input['DOB']) && !empty($input['DOB'])) ? $input['DOB'] : null;

            if (isset($input['baby_id']) && $input['baby_id'] != '' && $input['baby_id'] != 0)
            {
                $baby_post['UserModified'] = $this->auth->user()->id;
                $baby_post['DateModified'] = Carbon::now();
                $baby = Baby::findOrfail($input['baby_id']);
                $baby->update($baby_post);
                $baby_id = $input['baby_id'];
            }
            else
            {
                $baby_post['DateAdded'] = Carbon::now();
                $baby_post['UserAdded'] = $this->auth->user()->id;
                $baby = Baby::create($baby_post);
                $baby_id = $baby->BabyId;
            }
        }

        $feeding_post['mother_id'] = $mother_id;
        $feeding_post['baby_id'] = $baby_id;
        $feeding_post['reg_type'] = isset($input['type']) ? $input['type'] : null;
        $feeding_post['visit_date'] = date('Y-m-d', strtotime($input['visit_date']));
        $feeding_post['visit_time'] = isset($input['visit_time']) ? $input['visit_time'] : null;
        $feeding_post['visit_min'] = isset($input['visit_min']) ? $input['visit_min'] : null;
        $feeding_post['visit_session'] = isset($input['visit_session']) ? $input['visit_session'] : null;
        $feeding_post['visit_from'] = isset($input['visit_from']) ? $input['visit_from'] : null;
        // $feeding_post['visit_from_more'] = isset($input['visit_from_more']) ? $input['visit_from_more'] : null;
        $feeding_post['background_details'] = $input['background_details'];
        $feeding_post['development'] = $input['development'];
        $feeding_post['is_parent_concerns'] = (isset($input['is_parent_concerns']) && $input['is_parent_concerns'] == 'on') ? true : false;
        $feeding_post['parent_concerns'] = $input['parent_concerns'];
        $feeding_post['is_current_feeding'] = (isset($input['is_current_feeding']) && $input['is_current_feeding'] == 'on') ? true : false;
        $feeding_post['current_feeding'] = $input['current_feeding'];
        $feeding_post['is_oral_motor_assessment'] = (isset($input['is_oral_motor_assessment']) && $input['is_oral_motor_assessment'] == 'on') ? true : false;
        $feeding_post['oral_motor_assessment'] = $input['oral_motor_assessment'];
        $feeding_post['is_cranial_nerve_assesment'] = (isset($input['is_cranial_nerve_assesment']) && $input['is_cranial_nerve_assesment'] == 'on') ? true : false;
        $feeding_post['cranial_nerve_assesment'] = $input['cranial_nerve_assesment'];
        $feeding_post['is_feeding_assesment'] = (isset($input['is_feeding_assesment']) && $input['is_feeding_assesment'] == 'on') ? true : false;
        $feeding_post['feeding_assesment'] = $input['feeding_assesment'];
        $feeding_post['is_mothers_examination'] = (isset($input['is_mothers_examination']) && $input['is_mothers_examination'] == 'on') ? true : false;
        $feeding_post['mothers_examination'] = $input['mothers_examination'];
        $feeding_post['is_interpretation'] = (isset($input['is_interpretation']) && $input['is_interpretation'] == 'on') ? true : false;        
        $feeding_post['interpretation'] = $input['interpretation'];
        $feeding_post['recommendation'] = $input['recommendation'];

        $feeding_post['chronological_year'] = (isset($input['chronological_year']) && !empty($input['chronological_year'])) ? $input['chronological_year'] : 0;
        $feeding_post['chronological_month'] = (isset($input['chronological_month']) && !empty($input['chronological_month'])) ? $input['chronological_month'] : 0;
        $feeding_post['chronological_days'] = (isset($input['chronological_days']) && !empty($input['chronological_days'])) ? $input['chronological_days'] : 0;
        $feeding_post['corrected_year'] = (isset($input['corrected_year']) && !empty($input['corrected_year'])) ? $input['corrected_year'] : 0;
        $feeding_post['corrected_month'] = (isset($input['corrected_month']) && !empty($input['corrected_month'])) ? $input['corrected_month'] : 0;
        $feeding_post['corrected_days'] = (isset($input['corrected_days']) && !empty($input['corrected_days'])) ? $input['corrected_days'] : 0;

        $feeding_post['discharge_weight'] = isset($input['discharge_weight']) ? $input['discharge_weight'] : null;
        $feeding_post['current_weight'] = isset($input['current_weight']) ? $input['current_weight'] : null;
        $feeding_post['seen_by'] = isset($input['seen_by']) ? json_encode($input['seen_by']) : null;        
        $feeding_post['referred_by'] = (isset($input['referred_by']) && !empty($input['referred_by'])) ? $input['referred_by'] : '';
        $feeding_post['appointment_type'] = (isset($input['appointment_type']) && !empty($input['appointment_type'])) ? $input['appointment_type'] : '';
        $feeding_post['review'] = (isset($input['review']) && !empty($input['review'])) ? date('Y-m-d', strtotime($input['review'])) : null;
        $feeding_post['review_days'] = (isset($input['review_days']) && !empty($input['review_days'])) ? $input['review_days'] : '';
        $feeding_post['review_time'] = (isset($input['review_time']) && !empty($input['review_time'])) ? $input['review_time'] : '';
        $feeding_post['review_min'] = (isset($input['review_min']) && !empty($input['review_min'])) ? $input['review_min'] : '';
        $feeding_post['review_session'] = (isset($input['review_session']) && !empty($input['review_session'])) ? $input['review_session'] : '';
        $feeding_post['fee_status'] = (isset($input['fee_status']) && $input['fee_status'] =='Yes') ? 'Yes' : 'No';
        $feeding_post['no_fee_reason'] = (isset($input['no_fee_reason']) && !empty($input['no_fee_reason'])) ? $input['no_fee_reason'] : '';
        $feeding_post['fee_amount'] = (isset($input['fee_amount']) && !empty($input['fee_amount'])) ? $input['fee_amount'] : '';

        $feeding_post['created_at'] = date('Y-m-d H:i:s');
        $feeding_post['created_by'] = $this->auth->user()->id;

        $feeding_id = Feeding::create($feeding_post)->id;

        if ($request->ajax())
        {
            return \Response::json(['type' => 'success', 'message' => 'Record updated successfully !', 'edit_url' => action('Registration\FeedingController@edit', \SiteHelpers::encrypt_id($feeding_id)) , 'list_url' => action('Registration\FeedingController@index')], 200);
        }
        if ($print_flag == 1)
        {
            if ($input['current_tab'] != '') {
                setcookie('current_tab', $input['current_tab'], 0, '/');
            }
            return redirect(action('Registration\FeedingController@edit', \SiteHelpers::encrypt_id($feeding_id)))->with('Success', 'Record saved successfully !');
        }
        elseif ($print_flag == 2)
        {
            return redirect(action('Registration\FeedingController@index'))->with('Success', 'Record saved successfully !');
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

        $results = Feeding::findOrfail($id);
        $baby_id = $results->baby_id;
        $mother_id = $results->mother_id;

        if ($mother_id > 0) {
            $mother = Mother::findOrfail($mother_id);
        }
        if ($baby_id > 0) {
            $baby = Baby::findOrfail($baby_id);
        }

        if (isset($mother->MMrNo)) {
            $results->MMrNo = $mother->MMrNo;
        }
        if (isset($mother->MotherName)) {
            $results->MotherName = $mother->MotherName;
        }
        if (isset($baby->BMrNo)) {
            $results->BMrNo = $baby->BMrNo;
        }
        if (isset($baby->BabyName)) {
            $results->BabyName = $baby->BabyName;
        }
        if (isset($baby->g_weeks)) {
            $results->g_weeks = $baby->g_weeks;
        }
        if (isset($baby->g_days)) {
            $results->g_days = $baby->g_days;
        }
        if (isset($baby->DOB)) {
            $results->DOB = $baby->DOB;
        }
        if (isset($baby->Sex)) {
            $results->Sex = $baby->Sex;
        }
        if (isset($baby->BirthWeight)) {
            $results->BirthWeight = $baby->BirthWeight;
        }

        if (isset($results->visit_date) && !empty($results->visit_date) && !is_null($results->visit_date))
        {
            $results->visit_date = date('d-m-Y', strtotime($results->visit_date));
        }

        if ($request->get('closewinlink') == 'list-view') {
            if (!$results->reg_type) {
                $closewinlink = action('Registration\FeedingController@subList', \SiteHelpers::encrypt_id($results->mother_id)) . '?type=mother';
            } else {
                $closewinlink = action('Registration\FeedingController@subList', \SiteHelpers::encrypt_id($results->baby_id)) . '?type=baby';
            }
        } else {
            $closewinlink = action('Registration\FeedingController@edit', \SiteHelpers::encrypt_id($id));            
        }

        $headerContent = Settings::findorfail(1);
        $neuro_consultant_id = $headerContent->hms_neuro_consultant_id;

        return view('registration.feeding.print', compact('results', 'closewinlink', 'headerContent', 'neuro_consultant_id'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $id = \SiteHelpers::decrypt_id($id);

        $input = $request->all();

        $active_tab = isset($input['active_tab']) ? $input['active_tab'] : '';

        if (strlen($active_tab) == 0) {
            $active_tab = (isset($_COOKIE['current_tab']) && !empty($_COOKIE['current_tab'])) ? $_COOKIE['current_tab'] : '#babyform';
            unset($_COOKIE['current_tab']);
            setcookie("current_tab", "", 0, "/");            
        } else {
            $active_tab = $active_tab == 'form' ? '#form' : '#babyform';
        }

        $results = Feeding::findOrfail($id);
        $baby_id = $results->baby_id;
        $mother_id = $results->mother_id;

        if ($mother_id > 0) {
            $mother = Mother::findOrfail($mother_id);
        }
        if ($baby_id > 0) {
            $baby = Baby::findOrfail($baby_id);
        }

        if (isset($mother->MMrNo)) {
            $results->MMrNo = $mother->MMrNo;
        }
        if (isset($mother->MotherName)) {
            $results->MotherName = $mother->MotherName;
        }
        if (isset($baby->BMrNo)) {
            $results->BMrNo = $baby->BMrNo;
        }
        if (isset($baby->BabyName)) {
            $results->BabyName = $baby->BabyName;
        }
        if (isset($baby->g_weeks)) {
            $results->g_weeks = $baby->g_weeks;
        }
        if (isset($baby->g_days)) {
            $results->g_days = $baby->g_days;
        }
        if (isset($baby->DOB)) {
            $results->DOB = date('d-m-Y', strtotime($baby->DOB));
        }
        if (isset($baby->Sex)) {
            $results->Sex = $baby->Sex;
        }

        if (isset($results->visit_date) && !empty($results->visit_date) && !is_null($results->visit_date))
        {
            $results->visit_date = date('d-m-Y', strtotime($results->visit_date));
        }

        $type = $results->reg_type;
        $time = \SiteHelpers::prepare_time();
        $current_time = [];
        $current_time['hours'] = (int)date("h", strtotime(Carbon::now(env('TIME_ZONE'))));
        $current_time['mins'] = (int)date("i", strtotime(Carbon::now(env('TIME_ZONE'))));
        $current_time['am'] = date("A", strtotime(Carbon::now(env('TIME_ZONE'))));

        $DOB = date('Y-m-d', strtotime($results->DOB));
        $visit_date = date('Y-m-d', strtotime($results->visit_date));
        $current_age = \SiteHelpers::getChronologicalage($DOB, $visit_date);

        $current_chart_age = 0;
        if ($results->g_weeks < 37 && !empty($results->g_weeks)) {
            
            $baby_corrected_age = \SiteHelpers::calculateCorrectedGestation($results->g_weeks, $results->g_days, $results->DOB, $results->visit_date);

            $current_chart_age = $baby_corrected_age['corrected_age_weeks'] + number_format(($baby_corrected_age['corrected_age_days'] / 7) , 1);
        }       

        $settings = Settings::find(1);
        $dvs = $settings->hms_primary_consultant_id;
        $rks = $settings->hms_secondary_consultant_id;
        $neuro_consultant_id = $settings->hms_neuro_consultant_id;            
        $doctor_master = \ValuelistHelpers::mas_doctors_list();

        return view('registration.feeding.edit', compact('results', 'active_tab', 'type', 'time', 'current_age', 'current_chart_age', 'dvs', 'rks', 'neuro_consultant_id', 'doctor_master'));
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

        $mother_post['MotherName'] = (isset($input['MotherName']) && !empty($input['MotherName'])) ? $input['MotherName'] : null;
        $mother_post['MMrNo'] = (isset($input['MMrNo']) && !empty($input['MMrNo'])) ? $input['MMrNo'] : null;
        $mother_post['UserModified'] = $this->auth->user()->id;
        $mother_post['DateModified'] = Carbon::now();
        if ($input['mother_id'] > 0) {
            $mother = Mother::findOrfail($input['mother_id']);
            $mother->update($mother_post);
        }

        $baby_post['BabyName'] = (isset($input['BabyName']) && !empty($input['BabyName'])) ? $input['BabyName'] : null;
        $baby_post['BMrNo'] = (isset($input['BMrNo']) && !empty($input['BMrNo'])) ? $input['BMrNo'] : null;
        $baby_post['g_weeks'] = (isset($input['g_weeks']) && !empty($input['g_weeks'])) ? $input['g_weeks'] : null;
        $baby_post['g_days'] = (isset($input['g_days']) && !empty($input['g_days'])) ? $input['g_days'] : null;
        $baby_post['Sex'] = (isset($input['Sex']) && !empty($input['Sex'])) ? $input['Sex'] : null;
        $baby_post['DOB'] = (isset($input['DOB']) && !empty($input['DOB'])) ? $input['DOB'] : null;
        $baby_post['UserModified'] = $this->auth->user()->id;
        $baby_post['DateModified'] = Carbon::now();
        if ($input['baby_id'] > 0) {
            $baby = Baby::findOrfail($input['baby_id']);
            $baby->update($baby_post);
        }

        $feeding_post['reg_type'] = isset($input['type']) ? $input['type'] : null;
        $feeding_post['visit_date'] = date('Y-m-d', strtotime($input['visit_date']));
        $feeding_post['visit_time'] = isset($input['visit_time']) ? $input['visit_time'] : null;
        $feeding_post['visit_min'] = isset($input['visit_min']) ? $input['visit_min'] : null;
        $feeding_post['visit_session'] = isset($input['visit_session']) ? $input['visit_session'] : null;
        $feeding_post['visit_from'] = isset($input['visit_from']) ? $input['visit_from'] : null;
        $feeding_post['visit_from_more'] = isset($input['visit_from_more']) ? $input['visit_from_more'] : null;
        $feeding_post['background_details'] = $input['background_details'];
        $feeding_post['development'] = $input['development'];
        $feeding_post['is_parent_concerns'] = (isset($input['is_parent_concerns']) && $input['is_parent_concerns'] == 'on') ? true : false;
        $feeding_post['parent_concerns'] = $input['parent_concerns'];
        $feeding_post['is_current_feeding'] = (isset($input['is_current_feeding']) && $input['is_current_feeding'] == 'on') ? true : false;
        $feeding_post['current_feeding'] = $input['current_feeding'];
        $feeding_post['is_oral_motor_assessment'] = (isset($input['is_oral_motor_assessment']) && $input['is_oral_motor_assessment'] == 'on') ? true : false;
        $feeding_post['oral_motor_assessment'] = $input['oral_motor_assessment'];
        $feeding_post['is_cranial_nerve_assesment'] = (isset($input['is_cranial_nerve_assesment']) && $input['is_cranial_nerve_assesment'] == 'on') ? true : false;
        $feeding_post['cranial_nerve_assesment'] = $input['cranial_nerve_assesment'];
        $feeding_post['is_feeding_assesment'] = (isset($input['is_feeding_assesment']) && $input['is_feeding_assesment'] == 'on') ? true : false;
        $feeding_post['feeding_assesment'] = $input['feeding_assesment'];
        $feeding_post['is_mothers_examination'] = (isset($input['is_mothers_examination']) && $input['is_mothers_examination'] == 'on') ? true : false;
        $feeding_post['mothers_examination'] = $input['mothers_examination'];
        $feeding_post['is_interpretation'] = (isset($input['is_interpretation']) && $input['is_interpretation'] == 'on') ? true : false;
        $feeding_post['interpretation'] = $input['interpretation'];
        $feeding_post['recommendation'] = $input['recommendation'];

        $feeding_post['chronological_year'] = (isset($input['chronological_year']) && !empty($input['chronological_year'])) ? $input['chronological_year'] : 0;
        $feeding_post['chronological_month'] = (isset($input['chronological_month']) && !empty($input['chronological_month'])) ? $input['chronological_month'] : 0;
        $feeding_post['chronological_days'] = (isset($input['chronological_days']) && !empty($input['chronological_days'])) ? $input['chronological_days'] : 0;
        $feeding_post['corrected_year'] = (isset($input['corrected_year']) && !empty($input['corrected_year'])) ? $input['corrected_year'] : 0;
        $feeding_post['corrected_month'] = (isset($input['corrected_month']) && !empty($input['corrected_month'])) ? $input['corrected_month'] : 0;
        $feeding_post['corrected_days'] = (isset($input['corrected_days']) && !empty($input['corrected_days'])) ? $input['corrected_days'] : 0;

        $feeding_post['discharge_weight'] = isset($input['discharge_weight']) ? $input['discharge_weight'] : null;
        $feeding_post['current_weight'] = isset($input['current_weight']) ? $input['current_weight'] : null;
        $feeding_post['seen_by'] = isset($input['seen_by']) ? json_encode($input['seen_by']) : null;
        
        $feeding_post['referred_by'] = (isset($input['referred_by']) && !empty($input['referred_by'])) ? $input['referred_by'] : 0;
        $feeding_post['appointment_type'] = (isset($input['appointment_type']) && !empty($input['appointment_type'])) ? $input['appointment_type'] : '';        
        $feeding_post['review'] = (isset($input['review']) && !empty($input['review'])) ? date('Y-m-d', strtotime($input['review'])) : null;
        $feeding_post['review_days'] = (isset($input['review_days']) && !empty($input['review_days'])) ? $input['review_days'] : 0;
        $feeding_post['review_time'] = (isset($input['review_time']) && !empty($input['review_time'])) ? $input['review_time'] : 0;
        $feeding_post['review_min'] = (isset($input['review_min']) && !empty($input['review_min'])) ? $input['review_min'] : 0;
        $feeding_post['review_session'] = (isset($input['review_session']) && !empty($input['review_session'])) ? $input['review_session'] : '';
        $feeding_post['fee_status'] = (isset($input['fee_status']) && $input['fee_status'] =='Yes') ? 'Yes' : 'No';
        $feeding_post['no_fee_reason'] = (isset($input['no_fee_reason']) && !empty($input['no_fee_reason'])) ? $input['no_fee_reason'] : '';
        $feeding_post['fee_amount'] = (isset($input['fee_amount']) && !empty($input['fee_amount'])) ? $input['fee_amount'] : '';
        
        $feeding_post['modified_at'] = date('Y-m-d H:i:s');
        $feeding_post['modified_by'] = $this->auth->user()->id;

        $feeding = Feeding::findOrfail($id);
        $feeding->update($feeding_post);

        if ($request->ajax())
        {
            return \Response::json(['type' => 'success', 'message' => 'Record updated successfully !', 'edit_url' => action('Registration\FeedingController@edit', \SiteHelpers::encrypt_id($id)) , 'list_url' => action('Registration\FeedingController@index'), 'print_url' => action('Registration\FeedingController@show', \SiteHelpers::encrypt_id($id))], 200);
        }

        if ($print_flag == 1)
        {
            return redirect(action('Registration\FeedingController@edit', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record saved successfully !');
        }
        elseif ($print_flag == 2)
        {
            return redirect(action('Registration\FeedingController@index'))->with('Success', 'Record saved successfully !');
        }
        elseif ($print_flag == 3)
        {
            return redirect(action('Registration\FeedingController@show', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record saved successfully !');
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

    public static function getBabyBackgroundDetails($mrn)
    {

        $details = Baby::get_baby_by_mrn($mrn);
        if (isset($details->BabyId))
        {
            $id = $details->BabyId;
        }

        $background_details = '';

        if (isset($id))
        {

            $discharge_summary_backgroud = DischargeSummary::getSummaryCompleted($id);

            $postanatalAdmission = Postnatal::where('BabyId', $id)->where('IsDeleted', 0)->orderBy('AdmissionId', 'desc')->first();

            $nicuAdmission = Nicu::where('BabyId', $id)->where('IsDeleted', 0)->orderBy('AdmissionId', 'desc')->first();

            $previous_op = Op::GetPreviousopRecord($id);

            $previous_feeding = Feeding::GetPreviousFeedingRecord($id);

            if (is_array($discharge_summary_backgroud) && count($discharge_summary_backgroud) > 0)
            {

                foreach ($discharge_summary_backgroud as $discharge_value)
                {

                    $background_details .= $discharge_value;

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

                    $background_details = implode(', ', $differentialdiagnosis);
                }

                $problems = PostProblemDischargeSummary::getNeonatalProblems($postanatalAdmission->BabyId, $postanatalAdmission->AdmissionId);
                if (count($problems) > 0)
                {
                    $postProblems = $problems->pluck('problem_name')->unique()->toArray();
                    if (!empty($background_details))
                    {
                        $background_details .= ', ' . implode(', ', $postProblems);
                    }
                    else
                    {
                        $background_details = implode(', ', $postProblems);
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
                    $background_details = implode(', ', $diagnosis);
                }

                $problems = ProblemDischarge::getNeonatalProblems($nicuAdmission->BabyId, $nicuAdmission->AdmissionId);
                if (count($problems) > 0)
                {
                    $postProblems = $problems->pluck('problem_name')->unique()->toArray();
                    if (!empty($background_details))
                    {
                        $background_details .= ', ' . implode(', ', $postProblems);
                    }
                    else
                    {
                        $background_details = implode(', ', $postProblems);
                    }
                }

            }
            else
            {

                $background_details = $details->Background;
            }

            if (isset($previous_op->OpId) && !empty($previous_op->OpId))
            {
                $background_details = (isset($previous_op->background_details) && !empty($previous_op->background_details)) ? $previous_op->background_details : $background_details;
            }

            if (isset($previous_feeding->id) && !empty($previous_feeding->id))
            {
                $background_details = (isset($previous_feeding->background_details) && !empty($previous_feeding->background_details)) ? $previous_feeding->background_details : $background_details;
            }

        }

        return \Response::json(['background_details' => $background_details], 200);

    }

    public function subList(Request $request, $id)
    {
        $input = $request->all();
        // decrypt the id
        $mother_id = $baby_id = null;
        if (isset($input['type']) && $input['type'] == 'mother') {
            $mother_id = \SiteHelpers::decrypt_id($id);
        } else {
            $baby_id = \SiteHelpers::decrypt_id($id);
        }
        $results =  \DB::table('feeding');
        if (isset($input['type']) && $input['type'] == 'mother') {
           $results = $results
           ->select('feeding.visit_date', 'feeding.id', 'MMrNo', 'MotherName', 'mother.MotherId')
           ->join('mother', 'feeding.mother_id', '=', 'mother.MotherId')
           ->where(['feeding.is_deleted'=>0,'feeding.mother_id'=>$mother_id]);
       } else {
           $results = $results
           ->select('baby.BabyId', 'baby.BabyName', 'baby.BMrNo', 'feeding.visit_date', 'feeding.id')
           ->join('baby', 'feeding.baby_id', '=', 'baby.BabyId')
           ->where(['feeding.is_deleted'=>0,'feeding.baby_id'=>$baby_id]);
       }
       $results = $results->orderBy('feeding.id', 'desc')
       ->get();

       $visit_list = collect($results)->sortByDesc('visit_date')->toArray();

        //get name
       if (isset($input['type']) && $input['type'] == 'mother') {
           $baby_name   = isset($visit_list[0]->MotherName) ? $visit_list[0]->MotherName.' - '.$visit_list[0]->MMrNo : '';
       } else {
           $baby_name   = isset($visit_list[0]->BabyName) ? $visit_list[0]->BabyName.' - '.$visit_list[0]->BMrNo : '';
       }
       $navigate['main_nav'] = 'registration';
       $navigate['sub_nav'] = 'feeding';
       return view('registration.feeding.visit_list', compact('visit_list', 'baby_name','navigate', 'seen_by'));

   }
}
