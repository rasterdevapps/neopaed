<?php

namespace App\Http\Controllers\Registration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Carbon\Carbon;
use App\Models\Masters\BayleyScaleMaster;
use App\Models\BayleyScale;
use App\Models\BayleyScaleScore;
use App\Models\Baby;
use App\Models\Mother;
use App\Models\Settings\Settings;
use App\Models\Settings\DeleteApproval;

class BayleyScaleController extends Controller
{
    protected $category;
    protected $time_zone;
    protected $auth;
    protected $default_bayley_seen_by;
    protected $seen_by;

    public function __construct(Guard $auth) {
        $this->middleware('role:BAYLEY_SCALE,write', ['only' => ['store', 'update', 'edit', 'create', 'destory']]);
        $this->middleware('role:BAYLEY_SCALE,read', ['only' => ['index', 'show']]);
        $this->category = [1=>'Cognitive (CG)',2=>'Receptive Communication (RC)',3=>'Expressive Communication (EC)',4=>'Fine Motor (FM)',5=>'Gross Motor (GM)'];        
        $this->time_zone = env('TIME_ZONE');
        $this->auth = $auth;
        $this->default_bayley_seen_by = 52;
        $this->seen_by = ["7","52"];
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

        $navigate['main_nav'] = 'op';
        $navigate['sub_nav'] = 'bayley';
        $result = BayleyScale::get_lists($request->input('page') , $limit, $search, $order, 1);
        $results = $result['result'];
        $getTotal = BayleyScale::GetTotal();
        $total = $result['total'];

        $page = !empty($request->input('page')) ? $request->input('page') : 1;
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

        return view('registration.bayley.list', compact('results', 'navigate', 'pagination', 'search', 'getTotal', 'order'));
    }

    public function chooseBaby()
    {
        $navigate['main_nav'] = 'registration';
        $navigate['sub_nav'] = 'neuro';
        $baby = Baby::baby_list_op();
        $babies = \ValuelistHelpers::select2DataFormater($baby, true);

        $SubmitButtonText = "Start";

        return view('registration.bayley.select_patient', compact('SubmitButtonText', 'babies', 'navigate'));
    }

    /**
     * show the visite list for a baby
     *
     * @param baby_id encrypted hash value
     */
    public function subList(Request $request, $baby_id)
    {
        // decrypt the baby id
        $baby_id = \SiteHelpers::decrypt_id($baby_id);

        //get the visite list 
        $visite_list = BayleyScale::getVisitList($baby_id)->toArray();

        return view('registration.bayley.visite_list', compact('visite_list', 'baby_id'));

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
            if (isset($baby_detail->BMrNo)) {
                $baby_detail->baby_background = NeuroController::getBabyBackgroundDetails($baby_detail->BMrNo)->original['baby_background'];
            }
        }
        $time = \SiteHelpers::prepare_time();

        $current_date = date('d-m-Y');
        $current_time = [];
        $current_time['hours'] = (int)date("h", strtotime(Carbon::now($this->time_zone)));
        $current_time['mins'] = (int)date("i", strtotime(Carbon::now($this->time_zone)));
        $current_time['am'] = date("A", strtotime(Carbon::now($this->time_zone)));

        $bayley_master = BayleyScaleMaster::getData()->groupBy(['category', 'question_no'])->toArray();
        $category_options = $this->category;
        $baby_detail->examiner = $this->default_bayley_seen_by;

        $results->seen_by = json_encode($this->seen_by);

        return view('registration.bayley.create', compact('baby_detail', 'time', 'current_date', 'current_time', 'category_options', 'bayley_master', 'results'));
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

        $input['MotherName'] = (isset($input['MotherName']) && !empty($input['MotherName'])) ? $input['MotherName'] : null;

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

        $input['DOB'] = (isset($input['DOB']) && !empty($input['DOB'])) ? date('Y-m-d', strtotime($input['DOB'])) : null;
        $input['BirthStatus'] = (isset($input['BirthStatus']) && $input['BirthStatus'] == 'on') ? 'Inborn' : 'Outborn';

        $input['g_weeks'] = (isset($input['g_weeks']) && !empty($input['g_weeks'])) ? $input['g_weeks'] : null;
        $input['g_days'] = (isset($input['g_days']) && !empty($input['g_days'])) ? $input['g_days'] : null;

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

        $bayley['baby_id'] = $baby_id = $input['baby_id'] = $input['BabyId'];
        $bayley['user_added'] = $this->auth->user()->id;
        $bayley['date_added'] = date('Y-m-d H:i:s');
        $bayley['baby_background'] = $input['baby_background'];
        $bayley['visit_date'] = date('Y-m-d', strtotime($input['visit_date']));
        $bayley['visit_time'] = isset($input['visit_time']) ? $input['visit_time'] : null;
        $bayley['visit_min'] = isset($input['visit_min']) ? $input['visit_min'] : null;
        $bayley['visit_session'] = isset($input['visit_session']) ? $input['visit_session'] : null;
        $bayley['seen_by'] = isset($input['seen_by']) ? json_encode($input['seen_by']) : null;
        $bayley['examiner'] = isset($input['examiner']) ? $input['examiner'] : null;
        $bayley['chronological_year'] = isset($input['chronological_year']) ? $input['chronological_year'] : null;
        $bayley['chronological_month'] = isset($input['chronological_month']) ? $input['chronological_month'] : null;
        $bayley['chronological_days'] = isset($input['chronological_days']) ? $input['chronological_days'] : null;
        $bayley['corrected_year'] = isset($input['corrected_year']) ? $input['corrected_year'] : null;
        $bayley['corrected_month'] = isset($input['corrected_month']) ? $input['corrected_month'] : null;
        $bayley['corrected_days'] = isset($input['corrected_days']) ? $input['corrected_days'] : null;
        $bayley['chronological_weeks'] = isset($input['chronological_weeks']) ? $input['chronological_weeks'] : null;
        $bayley['chronological_day'] = isset($input['chronological_day']) ? $input['chronological_day'] : null;
        $bayley['corrected_weeks'] = isset($input['corrected_weeks']) ? $input['corrected_weeks'] : null;
        $bayley['corrected_day'] = isset($input['corrected_day']) ? $input['corrected_day'] : null;
        $bayley['current_weight_g'] = isset($input['current_weight_g']) ? $input['current_weight_g'] : null;
        $bayley['current_ofc'] = isset($input['current_ofc']) ? $input['current_ofc'] : null;
        $bayley['current_length'] = isset($input['current_length']) ? $input['current_length'] : null;
        $bayley['start_point'] = isset($input['start_point']) ? $input['start_point'] : null;
        $bayley['reason_referral'] = isset($input['reason_referral']) ? $input['reason_referral'] : null;
        $bayley['caregiver_name'] = isset($input['caregiver_name']) ? $input['caregiver_name'] : null;
        $bayley['primary_caregiver_education'] = isset($input['primary_caregiver_education']) ? $input['primary_caregiver_education'] : null;
        $bayley['hour_of_intervention'] = isset($input['hour_of_intervention']) ? $input['hour_of_intervention'] : null;
        $bayley['relationship_to_child'] = isset($input['relationship_to_child']) ? $input['relationship_to_child'] : null;
        $bayley['cg'] = isset($input['cg']) ? $input['cg'] : null;
        $bayley['rc'] = isset($input['rc']) ? $input['rc'] : null;
        $bayley['ec'] = isset($input['ec']) ? $input['ec'] : null;
        $bayley['fm'] = isset($input['fm']) ? $input['fm'] : null;
        $bayley['gm'] = isset($input['gm']) ? $input['gm'] : null;
        $bayley['cg_scaled_score'] = isset($input['cg_scaled_score']) ? $input['cg_scaled_score'] : null;
        $bayley['rc_scaled_score'] = isset($input['rc_scaled_score']) ? $input['rc_scaled_score'] : null;
        $bayley['ec_scaled_score'] = isset($input['ec_scaled_score']) ? $input['ec_scaled_score'] : null;
        $bayley['fm_scaled_score'] = isset($input['fm_scaled_score']) ? $input['fm_scaled_score'] : null;
        $bayley['gm_scaled_score'] = isset($input['gm_scaled_score']) ? $input['gm_scaled_score'] : null;
        $bayley['cg_age_equivalent'] = isset($input['cg_age_equivalent']) ? $input['cg_age_equivalent'] : null;
        $bayley['rc_age_equivalent'] = isset($input['rc_age_equivalent']) ? $input['rc_age_equivalent'] : null;
        $bayley['ec_age_equivalent'] = isset($input['ec_age_equivalent']) ? $input['ec_age_equivalent'] : null;
        $bayley['fm_age_equivalent'] = isset($input['fm_age_equivalent']) ? $input['fm_age_equivalent'] : null;
        $bayley['gm_age_equivalent'] = isset($input['gm_age_equivalent']) ? $input['gm_age_equivalent'] : null;
        $bayley['cg_growth_scale'] = isset($input['cg_growth_scale']) ? $input['cg_growth_scale'] : null;
        $bayley['rc_growth_scale'] = isset($input['rc_growth_scale']) ? $input['rc_growth_scale'] : null;
        $bayley['ec_growth_scale'] = isset($input['ec_growth_scale']) ? $input['ec_growth_scale'] : null;
        $bayley['fm_growth_scale'] = isset($input['fm_growth_scale']) ? $input['fm_growth_scale'] : null;
        $bayley['gm_growth_scale'] = isset($input['gm_growth_scale']) ? $input['gm_growth_scale'] : null;
        $bayley['lang_scaled_score'] = isset($input['lang_scaled_score']) ? $input['lang_scaled_score'] : null;
        $bayley['mot_scaled_score'] = isset($input['mot_scaled_score']) ? $input['mot_scaled_score'] : null;
        $bayley['confidence_interval'] = isset($input['confidence_interval']) ? $input['confidence_interval'] : null;
        $bayley['cog_standard_score'] = isset($input['cog_standard_score']) ? $input['cog_standard_score'] : null;
        $bayley['lang_standard_score'] = isset($input['lang_standard_score']) ? $input['lang_standard_score'] : null;
        $bayley['mot_standard_score'] = isset($input['mot_standard_score']) ? $input['mot_standard_score'] : null;
        $bayley['cog_percentile_rank'] = isset($input['cog_percentile_rank']) ? $input['cog_percentile_rank'] : null;
        $bayley['lang_percentile_rank'] = isset($input['lang_percentile_rank']) ? $input['lang_percentile_rank'] : null;
        $bayley['mot_percentile_rank'] = isset($input['mot_percentile_rank']) ? $input['mot_percentile_rank'] : null;
        $bayley['cog_confidence_interval_start'] = isset($input['cog_confidence_interval_start']) ? $input['cog_confidence_interval_start'] : null;
        $bayley['cog_confidence_interval_end'] = isset($input['cog_confidence_interval_end']) ? $input['cog_confidence_interval_end'] : null;
        $bayley['lang_confidence_interval_start'] = isset($input['lang_confidence_interval_start']) ? $input['lang_confidence_interval_start'] : null;
        $bayley['lang_confidence_interval_end'] = isset($input['lang_confidence_interval_end']) ? $input['lang_confidence_interval_end'] : null;
        $bayley['mot_confidence_interval_start'] = isset($input['mot_confidence_interval_start']) ? $input['mot_confidence_interval_start'] : null;
        $bayley['mot_confidence_interval_end'] = isset($input['mot_confidence_interval_end']) ? $input['mot_confidence_interval_end'] : null;
        $bayley['se_raw_score'] = isset($input['se_raw_score']) ? $input['se_raw_score'] : null;
        $bayley['se_scaled_score'] = isset($input['se_scaled_score']) ? $input['se_scaled_score'] : null;
        $bayley['rec_raw_score'] = isset($input['rec_raw_score']) ? $input['rec_raw_score'] : null;
        $bayley['rec_scaled_score'] = isset($input['rec_scaled_score']) ? $input['rec_scaled_score'] : null;
        $bayley['exp_raw_score'] = isset($input['exp_raw_score']) ? $input['exp_raw_score'] : null;
        $bayley['exp_scaled_score'] = isset($input['exp_scaled_score']) ? $input['exp_scaled_score'] : null;
        $bayley['per_raw_score'] = isset($input['per_raw_score']) ? $input['per_raw_score'] : null;
        $bayley['per_scaled_score'] = isset($input['per_scaled_score']) ? $input['per_scaled_score'] : null;
        $bayley['ipr_raw_score'] = isset($input['ipr_raw_score']) ? $input['ipr_raw_score'] : null;
        $bayley['ipr_scaled_score'] = isset($input['ipr_scaled_score']) ? $input['ipr_scaled_score'] : null;
        $bayley['pla_raw_score'] = isset($input['pla_raw_score']) ? $input['pla_raw_score'] : null;
        $bayley['pla_scaled_score'] = isset($input['pla_scaled_score']) ? $input['pla_scaled_score'] : null;
        $bayley['visit_number'] = isset($input['visit_number']) ? $input['visit_number'] : null;

        $bayley_id = BayleyScale::insertGetId($bayley);

        $bayley_sub = [];
        $bayley_sub_1 = [];
        $bayley_sub_2 = [];
        $i = 0;
        if (isset($input['score']) && is_array($input['score'])) {
            foreach ($input['score'] as $category_id => $questions) {
                foreach ($questions as $question_id => $value) {
                    if (!empty($input['score_sub_id'][$category_id][$question_id])) {
                        $bayley_sub[$i]['hdr_id'] = $bayley_id;
                        $bayley_sub[$i]['category_id'] = $category_id;
                        $bayley_sub[$i]['question_id'] = $question_id;
                        $bayley_sub[$i]['sub_question_id'] = $input['score_sub_id'][$category_id][$question_id];
                        $bayley_sub[$i]['is_manual'] = isset($input['is_manual'][$category_id][$question_id]) ? $input['is_manual'][$category_id][$question_id] : false;
                        $bayley_sub[$i]['value'] = $value;
                        $bayley_sub[$i]['user_added'] = $this->auth->user()->id;
                        $bayley_sub[$i]['date_added'] = date('Y-m-d H:i:s');                    
                        $i++;
                    }
                }
            }
        }
        BayleyScaleScore::insert($bayley_sub);

        if (isset($input['note']) && is_array($input['note'])) {
            foreach ($input['note'] as $category_id => $questions) {
                foreach ($questions as $question_id => $sub_question) {
                    foreach ($sub_question as $sub_id => $value) {
                        $bayley_sub_1[$i]['hdr_id'] = $bayley_id;
                        $bayley_sub_1[$i]['category_id'] = $category_id;
                        $bayley_sub_1[$i]['question_id'] = $question_id;
                        $bayley_sub_1[$i]['sub_question_id'] = $sub_id;
                        $bayley_sub_1[$i]['value'] = $value;
                        $bayley_sub_1[$i]['user_added'] = $this->auth->user()->id;
                        $bayley_sub_1[$i]['date_added'] = date('Y-m-d H:i:s'); 
                        $i++;
                    }
                }
            }
        }
        BayleyScaleScore::insert($bayley_sub_1);

        if (isset($input['correct']) && is_array($input['correct'])) {
            foreach ($input['correct'] as $category_id => $questions) {
                foreach ($questions as $question_id => $sub_question) {
                    foreach ($sub_question as $sub_id => $value) {
                        $bayley_sub_2[$i]['hdr_id'] = $bayley_id;
                        $bayley_sub_2[$i]['category_id'] = $category_id;
                        $bayley_sub_2[$i]['question_id'] = $question_id;
                        $bayley_sub_2[$i]['sub_question_id'] = $sub_id;
                        $bayley_sub_2[$i]['value'] = $value == 'on' ? 1 : 0; 
                        $bayley_sub_2[$i]['user_added'] = $this->auth->user()->id;
                        $bayley_sub_2[$i]['date_added'] = date('Y-m-d H:i:s'); 
                        $i++;
                    }
                }
            }
        }
        BayleyScaleScore::insert($bayley_sub_2);

        if ($input['bayley_current_tab'] != '') {
            setcookie('bayley_current_tab', $input['bayley_current_tab'], 0, '/');
        }
        if ($request->ajax())
        {
            return \Response::json(['type' => 'success', 'message' => 'Record updated successfully !', 'edit_url' => action('Registration\BayleyScaleController@edit', \SiteHelpers::encrypt_id($bayley_id)) , 'list_url' => action('Registration\BayleyScaleController@index')], 200);
        }

        if ($print_flag == 1)
        {
            return redirect(action('Registration\BayleyScaleController@edit', \SiteHelpers::encrypt_id($bayley_id)))->with('Success', 'Record saved successfully !');
        }
        elseif ($print_flag == 2)
        {
            return redirect(action('Registration\BayleyScaleController@index'))->with('Success', 'Record saved successfully !');
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

        $results = BayleyScale::getVisit($id);
        $headerContent = Settings::findorfail(1);
        $results->Gestation = \SiteHelpers::decode_gestation($results->Gestation);

        if ($request->get('closewinlink') == 'list-view') {
            $closewinlink = action('Registration\BayleyScaleController@subList', \SiteHelpers::encrypt_id($results->BabyId));
        } else {
            $closewinlink = action('Registration\BayleyScaleController@edit', \SiteHelpers::encrypt_id($results->id));          
        }

        return view('registration.bayley.print', compact('results', 'id', 'headerContent', 'closewinlink'));

    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function assessment($id, Request $request)
    // {
    //     $id = \SiteHelpers::decrypt_id($id);

    //     $results = BayleyScale::getVisit($id);
    //     $headerContent = Settings::findorfail(1);
    //     $results->Gestation = \SiteHelpers::decode_gestation($results->Gestation);
    //     $bayley_master = BayleyScaleMaster::getData()->groupBy(['category', 'question_no'])->toArray();

    //     $sub_results = BayleyScaleScore::getData($id);

    //     $table_id_score_cg = $sub_results->where('category_id', 1)->where('type', 1)->pluck('question_id', 'id');
    //     $table_id_score_rc = $sub_results->where('category_id', 2)->where('type', 1)->pluck('question_id', 'id');
    //     $table_id_score_ec = $sub_results->where('category_id', 3)->where('type', 1)->pluck('question_id', 'id');
    //     $table_id_score_fm = $sub_results->where('category_id', 4)->where('type', 1)->pluck('question_id', 'id');
    //     $table_id_score_gm = $sub_results->where('category_id', 5)->where('type', 1)->pluck('question_id', 'id');

    //     $table_id_other = $sub_results->where('type', '<>', 1)->pluck('sub_question_id', 'id');

    //     $score_sub_id_cg = $sub_results->where('category_id', 1)->where('type', 1)->pluck('sub_question_id', 'question_id');
    //     $score_sub_id_rc = $sub_results->where('category_id', 2)->where('type', 1)->pluck('sub_question_id', 'question_id');
    //     $score_sub_id_ec = $sub_results->where('category_id', 3)->where('type', 1)->pluck('sub_question_id', 'question_id');
    //     $score_sub_id_fm = $sub_results->where('category_id', 4)->where('type', 1)->pluck('sub_question_id', 'question_id');
    //     $score_sub_id_gm = $sub_results->where('category_id', 5)->where('type', 1)->pluck('sub_question_id', 'question_id');

    //     $score = $sub_results->where('type', 1)->pluck('value', 'sub_question_id');
    //     $note = $sub_results->whereIn('type', [2, 4])->pluck('value', 'sub_question_id');
    //     $correct = $sub_results->where('type', 3)->pluck('value', 'sub_question_id');

    //     if ($request->get('closewinlink') == 'list-view') {
    //         $closewinlink = action('Registration\BayleyScaleController@subList', \SiteHelpers::encrypt_id($results->BabyId));
    //     } else {
    //         $closewinlink = action('Registration\BayleyScaleController@edit', \SiteHelpers::encrypt_id($results->id));          
    //     }

    //     return view('registration.bayley.assessment_print', compact('results', 'id', 'headerContent', 'closewinlink', 'bayley_master', 'table_id_score_cg', 'table_id_score_rc', 'table_id_score_ec', 'table_id_score_fm', 'table_id_score_gm', 'table_id_other', 'score_sub_id_cg', 'score_sub_id_rc', 'score_sub_id_ec', 'score_sub_id_fm', 'score_sub_id_gm', 'score', 'note', 'correct'));
    
    // }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = \SiteHelpers::decrypt_id($id);

        $results = BayleyScale::getVisit($id);

        $sub_results = BayleyScaleScore::getData($id);

        $table_id_score_cg = $sub_results->where('category_id', 1)->where('type', 1)->pluck('question_id', 'id');
        $table_id_score_rc = $sub_results->where('category_id', 2)->where('type', 1)->pluck('question_id', 'id');
        $table_id_score_ec = $sub_results->where('category_id', 3)->where('type', 1)->pluck('question_id', 'id');
        $table_id_score_fm = $sub_results->where('category_id', 4)->where('type', 1)->pluck('question_id', 'id');
        $table_id_score_gm = $sub_results->where('category_id', 5)->where('type', 1)->pluck('question_id', 'id');

        $score_sub_id_cg = $sub_results->where('category_id', 1)->where('type', 1)->pluck('sub_question_id', 'question_id');
        $score_sub_id_rc = $sub_results->where('category_id', 2)->where('type', 1)->pluck('sub_question_id', 'question_id');
        $score_sub_id_ec = $sub_results->where('category_id', 3)->where('type', 1)->pluck('sub_question_id', 'question_id');
        $score_sub_id_fm = $sub_results->where('category_id', 4)->where('type', 1)->pluck('sub_question_id', 'question_id');
        $score_sub_id_gm = $sub_results->where('category_id', 5)->where('type', 1)->pluck('sub_question_id', 'question_id');

        $score_cg = $sub_results->where('category_id', 1)->where('type', 1)->pluck('value', 'question_id');
        $score_rc = $sub_results->where('category_id', 2)->where('type', 1)->pluck('value', 'question_id');
        $score_ec = $sub_results->where('category_id', 3)->where('type', 1)->pluck('value', 'question_id');
        $score_fm = $sub_results->where('category_id', 4)->where('type', 1)->pluck('value', 'question_id');
        $score_gm = $sub_results->where('category_id', 5)->where('type', 1)->pluck('value', 'question_id');

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

        $baby_id = $results->baby_id;

        if (isset($results->DOB) && !empty($results->DOB) && !is_null($results->DOB))
        {
            $results->DOB = date('d-m-Y', strtotime($results->DOB));
        }
        if (isset($results->visit_date) && !empty($results->visit_date) && !is_null($results->visit_date))
        {
            $results->visit_date = date('d-m-Y', strtotime($results->visit_date));
        }
        $time = \SiteHelpers::prepare_time();

        $current_date = date('d-m-Y');
        $current_time = [];
        $current_time['hours'] = (int)date("h", strtotime(Carbon::now($this->time_zone)));
        $current_time['mins'] = (int)date("i", strtotime(Carbon::now($this->time_zone)));
        $current_time['am'] = date("A", strtotime(Carbon::now($this->time_zone)));
        $bayley_master = BayleyScaleMaster::getData()->groupBy(['category', 'question_no'])->toArray();

        $category_options = $this->category;

        $active_tab = (isset($_COOKIE['bayley_current_tab']) && !empty($_COOKIE['bayley_current_tab'])) ? $_COOKIE['bayley_current_tab'] : '#babyform';
        unset($_COOKIE['bayley_current_tab']);
        setcookie("bayley_current_tab", "", 0, "/");

        return view('registration.bayley.edit', compact('results', 'id', 'time', 'bayley_master', 'score_cg', 'score_rc', 'score_ec', 'score_fm', 'score_gm', 'note', 'correct', 'table_id_score_cg', 'table_id_score_rc', 'table_id_score_ec', 'table_id_score_fm', 'table_id_score_gm', 'table_id_other', 'score_sub_id_cg', 'score_sub_id_rc', 'score_sub_id_ec', 'score_sub_id_fm', 'score_sub_id_gm', 'active_tab', 'manual_cg', 'manual_rc', 'manual_ec', 'manual_fm', 'manual_gm'));

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

        $input['UserModified'] = $this->auth->user()->id;
        $input['DateModified'] = Carbon::now();
        $mother = Mother::findOrfail($input['MotherId']);
        $mother->update($input);

        $input['DOB'] = (isset($input['DOB']) && !empty($input['DOB'])) ? date('Y-m-d', strtotime($input['DOB'])) : null;
        $input['visit_date'] = (isset($input['visit_date']) && !empty($input['visit_date'])) ? date('Y-m-d', strtotime($input['visit_date'])) : null;
        $input['BirthStatus'] = (isset($input['BirthStatus']) && $input['BirthStatus'] == 'on') ? 'Inborn' : 'Outborn';

        $input['g_weeks'] = (isset($input['g_weeks']) && !empty($input['g_weeks'])) ? $input['g_weeks'] : null;
        $input['g_days'] = (isset($input['g_days']) && !empty($input['g_days'])) ? $input['g_days'] : null;

        $input['UserModified'] = $this->auth->user()->id;
        $input['DateModified'] = Carbon::now();
        $baby = Baby::findOrfail($input['BabyId']);
        $baby->update($input);

        $baby_id = isset($input['BabyId']) ? $input['BabyId'] : null;
        $bayley_id = $input['id'];
        $bayley['baby_background'] = $input['baby_background'];
        $bayley['visit_date'] = date('Y-m-d', strtotime($input['visit_date']));
        $bayley['visit_time'] = isset($input['visit_time']) ? $input['visit_time'] : null;
        $bayley['visit_min'] = isset($input['visit_min']) ? $input['visit_min'] : null;
        $bayley['visit_session'] = isset($input['visit_session']) ? $input['visit_session'] : null;
        $bayley['seen_by'] = isset($input['seen_by']) ? json_encode($input['seen_by']) : null;
        $bayley['examiner'] = isset($input['examiner']) ? $input['examiner'] : null;
        $bayley['chronological_year'] = isset($input['chronological_year']) ? $input['chronological_year'] : null;
        $bayley['chronological_month'] = isset($input['chronological_month']) ? $input['chronological_month'] : null;
        $bayley['chronological_days'] = isset($input['chronological_days']) ? $input['chronological_days'] : null;
        $bayley['corrected_year'] = isset($input['corrected_year']) ? $input['corrected_year'] : null;
        $bayley['corrected_month'] = isset($input['corrected_month']) ? $input['corrected_month'] : null;
        $bayley['corrected_days'] = isset($input['corrected_days']) ? $input['corrected_days'] : null;
        $bayley['chronological_weeks'] = isset($input['chronological_weeks']) ? $input['chronological_weeks'] : null;
        $bayley['chronological_day'] = isset($input['chronological_day']) ? $input['chronological_day'] : null;
        $bayley['corrected_weeks'] = isset($input['corrected_weeks']) ? $input['corrected_weeks'] : null;
        $bayley['corrected_day'] = isset($input['corrected_day']) ? $input['corrected_day'] : null;
        $bayley['current_weight_g'] = isset($input['current_weight_g']) ? $input['current_weight_g'] : null;
        $bayley['current_ofc'] = isset($input['current_ofc']) ? $input['current_ofc'] : null;
        $bayley['current_length'] = isset($input['current_length']) ? $input['current_length'] : null;
        $bayley['start_point'] = isset($input['start_point']) ? $input['start_point'] : null;
        $bayley['reason_referral'] = isset($input['reason_referral']) ? $input['reason_referral'] : null;
        $bayley['caregiver_name'] = isset($input['caregiver_name']) ? $input['caregiver_name'] : null;
        $bayley['relationship_to_child'] = isset($input['relationship_to_child']) ? $input['relationship_to_child'] : null;
        $bayley['cg'] = isset($input['cg']) ? $input['cg'] : null;
        $bayley['rc'] = isset($input['rc']) ? $input['rc'] : null;
        $bayley['ec'] = isset($input['ec']) ? $input['ec'] : null;
        $bayley['fm'] = isset($input['fm']) ? $input['fm'] : null;
        $bayley['gm'] = isset($input['gm']) ? $input['gm'] : null;
        $bayley['cg_scaled_score'] = isset($input['cg_scaled_score']) ? $input['cg_scaled_score'] : null;
        $bayley['rc_scaled_score'] = isset($input['rc_scaled_score']) ? $input['rc_scaled_score'] : null;
        $bayley['ec_scaled_score'] = isset($input['ec_scaled_score']) ? $input['ec_scaled_score'] : null;
        $bayley['fm_scaled_score'] = isset($input['fm_scaled_score']) ? $input['fm_scaled_score'] : null;
        $bayley['gm_scaled_score'] = isset($input['gm_scaled_score']) ? $input['gm_scaled_score'] : null;
        $bayley['cg_age_equivalent'] = isset($input['cg_age_equivalent']) ? $input['cg_age_equivalent'] : null;
        $bayley['rc_age_equivalent'] = isset($input['rc_age_equivalent']) ? $input['rc_age_equivalent'] : null;
        $bayley['ec_age_equivalent'] = isset($input['ec_age_equivalent']) ? $input['ec_age_equivalent'] : null;
        $bayley['fm_age_equivalent'] = isset($input['fm_age_equivalent']) ? $input['fm_age_equivalent'] : null;
        $bayley['gm_age_equivalent'] = isset($input['gm_age_equivalent']) ? $input['gm_age_equivalent'] : null;
        $bayley['cg_growth_scale'] = isset($input['cg_growth_scale']) ? $input['cg_growth_scale'] : null;
        $bayley['rc_growth_scale'] = isset($input['rc_growth_scale']) ? $input['rc_growth_scale'] : null;
        $bayley['ec_growth_scale'] = isset($input['ec_growth_scale']) ? $input['ec_growth_scale'] : null;
        $bayley['fm_growth_scale'] = isset($input['fm_growth_scale']) ? $input['fm_growth_scale'] : null;
        $bayley['gm_growth_scale'] = isset($input['gm_growth_scale']) ? $input['gm_growth_scale'] : null;
        $bayley['lang_scaled_score'] = isset($input['lang_scaled_score']) ? $input['lang_scaled_score'] : null;
        $bayley['mot_scaled_score'] = isset($input['mot_scaled_score']) ? $input['mot_scaled_score'] : null;
        $bayley['confidence_interval'] = isset($input['confidence_interval']) ? $input['confidence_interval'] : null;
        $bayley['cog_standard_score'] = isset($input['cog_standard_score']) ? $input['cog_standard_score'] : null;
        $bayley['lang_standard_score'] = isset($input['lang_standard_score']) ? $input['lang_standard_score'] : null;
        $bayley['mot_standard_score'] = isset($input['mot_standard_score']) ? $input['mot_standard_score'] : null;
        $bayley['cog_percentile_rank'] = isset($input['cog_percentile_rank']) ? $input['cog_percentile_rank'] : null;
        $bayley['lang_percentile_rank'] = isset($input['lang_percentile_rank']) ? $input['lang_percentile_rank'] : null;
        $bayley['mot_percentile_rank'] = isset($input['mot_percentile_rank']) ? $input['mot_percentile_rank'] : null;
        $bayley['cog_confidence_interval_start'] = isset($input['cog_confidence_interval_start']) ? $input['cog_confidence_interval_start'] : null;
        $bayley['cog_confidence_interval_end'] = isset($input['cog_confidence_interval_end']) ? $input['cog_confidence_interval_end'] : null;
        $bayley['lang_confidence_interval_start'] = isset($input['lang_confidence_interval_start']) ? $input['lang_confidence_interval_start'] : null;
        $bayley['lang_confidence_interval_end'] = isset($input['lang_confidence_interval_end']) ? $input['lang_confidence_interval_end'] : null;
        $bayley['mot_confidence_interval_start'] = isset($input['mot_confidence_interval_start']) ? $input['mot_confidence_interval_start'] : null;
        $bayley['mot_confidence_interval_end'] = isset($input['mot_confidence_interval_end']) ? $input['mot_confidence_interval_end'] : null;
        $bayley['se_raw_score'] = isset($input['se_raw_score']) ? $input['se_raw_score'] : null;
        $bayley['se_scaled_score'] = isset($input['se_scaled_score']) ? $input['se_scaled_score'] : null;
        $bayley['rec_raw_score'] = isset($input['rec_raw_score']) ? $input['rec_raw_score'] : null;
        $bayley['rec_scaled_score'] = isset($input['rec_scaled_score']) ? $input['rec_scaled_score'] : null;
        $bayley['exp_raw_score'] = isset($input['exp_raw_score']) ? $input['exp_raw_score'] : null;
        $bayley['exp_scaled_score'] = isset($input['exp_scaled_score']) ? $input['exp_scaled_score'] : null;
        $bayley['per_raw_score'] = isset($input['per_raw_score']) ? $input['per_raw_score'] : null;
        $bayley['per_scaled_score'] = isset($input['per_scaled_score']) ? $input['per_scaled_score'] : null;
        $bayley['ipr_raw_score'] = isset($input['ipr_raw_score']) ? $input['ipr_raw_score'] : null;
        $bayley['ipr_scaled_score'] = isset($input['ipr_scaled_score']) ? $input['ipr_scaled_score'] : null;
        $bayley['pla_raw_score'] = isset($input['pla_raw_score']) ? $input['pla_raw_score'] : null;
        $bayley['pla_scaled_score'] = isset($input['pla_scaled_score']) ? $input['pla_scaled_score'] : null;
        $bayley['visit_number'] = isset($input['visit_number']) ? $input['visit_number'] : null;
        BayleyScale::where('id', $bayley_id)->update($bayley);

        $table_id_score_cg = json_decode($input['table_id_score_cg'], true);
        $table_id_score_rc = json_decode($input['table_id_score_rc'], true);
        $table_id_score_ec = json_decode($input['table_id_score_ec'], true);
        $table_id_score_fm = json_decode($input['table_id_score_fm'], true);
        $table_id_score_gm = json_decode($input['table_id_score_gm'], true);
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
                }
                foreach ($questions as $question_id => $value) {
                    if (in_array($question_id, $table_id_score)) {
                        $bayley_sub_update['sub_question_id'] = $input['score_sub_id'][$category_id][$question_id];
                        $bayley_sub_update['value'] = $value;
                        $bayley_sub_update['user_modified'] = $this->auth->user()->id;
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
                            $bayley_sub[$i]['user_added'] = $this->auth->user()->id;
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
                            $bayley_sub_update['user_modified'] = $this->auth->user()->id;
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
                            $bayley_sub_1[$i]['user_added'] = $this->auth->user()->id;
                            $bayley_sub_1[$i]['date_added'] = date('Y-m-d H:i:s'); 
                            $i++;
                        }
                    }
                }
            }
        }
        BayleyScaleScore::insert($bayley_sub_1);

        if (isset($input['correct']) && is_array($input['correct'])) {
            BayleyScaleScore::leftJoin('mas_bayley_scale_sub', 'sub_question_id', 'mas_bayley_scale_sub.id')->where('type', 3)->where('hdr_id', $id)->update(['value'=> 0]);
            foreach ($input['correct'] as $category_id => $questions) {
                foreach ($questions as $question_id => $sub_question) {
                    foreach ($sub_question as $sub_id => $value) {
                        if (in_array($sub_id, $table_id_other)) {
                            $bayley_sub_update['value'] = $value == 'on' ? 1 : 0; 
                            $bayley_sub_update['user_modified'] = $this->auth->user()->id;
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
                            $bayley_sub_2[$i]['user_added'] = $this->auth->user()->id;
                            $bayley_sub_2[$i]['date_added'] = date('Y-m-d H:i:s'); 
                            $i++;
                        }
                    }
                }
            }
        }
        BayleyScaleScore::insert($bayley_sub_2);

        if ($request->ajax())
        {
            return \Response::json(['type' => 'success', 'message' => 'Record updated successfully !', 'list_url' => action('Registration\BayleyScaleController@index'), 'print_url' => action('Registration\BayleyScaleController@show', \SiteHelpers::encrypt_id($bayley_id))], 200);
        }
        
        if ($print_flag == 2)
        {
            return redirect(action('Registration\BayleyScaleController@index'))->with('Success', 'Record updated successfully !');
        }
        elseif ($print_flag == 3)
        {
            return redirect(action('Registration\BayleyScaleController@show', \SiteHelpers::encrypt_id($neuro_visit_id)).'?closewinlink=edit-view')->with('Success', 'Record updated successfully !');
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

        $results = BayleyScale::getVisit($id);
        $user_detail = array(
            'user_deleted' => $this->auth->user()->id,
            'is_deleted' => '1'
        );
        BayleyScale::where('id', $id)->update($user_detail);
        $delete_data = array(
            'Name' => $results->BabyName,
            'AdmissionDate' => $results['AdmissionDate'],
            'ModuleController' => 'Registration\BayleyScaleController',
            'ModuleId' => $id,
            'ModuleName' => 'Bayley',
            'UserDeleted' => $this->auth->user()->id,
            'DateDeleted' => Carbon::now()
        );
        DeleteApproval::create($delete_data);
        return redirect(action('Registration\BayleyScaleController@index'))->with('info', 'Record deleted successfully !');
    }

    // Export Bayley scale - Only export which question has a value 2
    public function export(Request $request)
    {
        $visit_id = $request->get('id');

        $results = BayleyScale::getVisit($visit_id);

        $results_score = BayleyScaleScore::getPassData($visit_id, 2)->groupBy('category_id')->map(function($list) {
            return $list->pluck('item', 'question_id');
        })
        ->toArray();

        $results_score_1 = BayleyScaleScore::getPassData($visit_id, 1)->groupBy('category_id')->map(function($list) {
            return $list->pluck('item', 'question_id');
        })
        ->toArray();

        $mas_list = BayleyScaleMaster::getData()->where('score', 2)->groupBy('category')->map(function($list) {
            return $list->pluck('title', 'question_no');
        })
        ->toArray();

        $zero_list[1] = [];
        $zero_list[2] = [];
        $zero_list[3] = [];
        $zero_list[4] = [];
        $zero_list[5] = [];

        $results_score_0 = BayleyScaleScore::getPassData($visit_id, 0)->groupBy('category_id')->map(function($list) use (&$zero_list, $mas_list) {
            return $list->pluck('item', 'question_id');
        })
        ->toArray();

        for ($i = 1; $i <= 5; $i++) {
            if (isset($results_score_0[$i])) {
                foreach ($results_score_0[$i] as $key => $value) {
                    if (isset($zero_list[$i][$key-1]) || count($zero_list[$i]) == 0) {
                        $zero_list[$i][$key] = '<b>' . $value . '</b> - ' . $mas_list[$i][$key];
                    } else if (count($zero_list[$i]) != 5) {
                        $zero_list[$i] = [];
                        $zero_list[$i][$key] = '<b>' . $value . '</b> - ' . $mas_list[$i][$key];
                    }
                }
            }
        }

        $file_name = $results['BMrNo'] . '[' . date('dmY',strtotime($results['visit_date'])) . ']';
        $file_name = preg_replace('/[^a-zA-z0-9]/', '', $file_name) . '.docx';

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $section = $phpWord->addSection();

        $header = array('size' => 16, 'bold' => true);
        $header_main = array('size' => 16, 'bold' => true, 'text-align' => 'center');

        $section->addText(htmlspecialchars('Bayley\'s Report'), $header_main);

        $table = $section->addTable();
        $table->addRow();
        $table->addCell(1750)->addText('UHID: SNH230133');
        $table->addCell(1750)->addText('Baby Name: B/O Meera');
        $table->addCell(1750)->addText('DOB: 11-04-2023');
        $table->addCell(1750)->addText('Sex: Male');
        $table->addCell(1750)->addText('Gestation: 39+4');
        $table->addRow();
        $table->addCell(1750)->addText('Birth Weight(g): 39+4');
        $table->addCell(1750)->addText('Current Weight: 39+4');
        $table->addCell(1750)->addText('OFC (cm): 39+4');
        $table->addCell(1750)->addText('Length / Height (cm): 39+4');
        $table->addRow();
        $table->addCell(1750)->addText('Chronological Age: 39+4');
        $table->addCell(1750)->addText('Corrected Age: 39+4');
        $table->addCell(1750)->addText('Mother Blood Group: 39+4');
        $table->addCell(1750)->addText('Baby\'s Blood Group: 39+4');

        $section->addTextBreak(1);

        $title[1] = 'Cognitive (CG)';
        $title[2] = 'Receptive Communication (RC)';
        $title[3] = 'Expressive Communication (EC)';
        $title[4] = 'Fine Motor (FM)';
        $title[5] = 'Gross Motor (GM)';

        foreach ($title as $title_key => $title_value) {

            if (isset($results_score[$title_key])) {
                $section->addText(htmlspecialchars($title_value), $header);
                $section->addText(htmlspecialchars('2 - Mastery'), $header);

                foreach ($results_score[$title_key] as $key => $value) {
                    $temp = $key . '. ' . $value;
                    $section->addText($temp);
                }

                $section->addTextBreak(1);
            }

            if (isset($results_score_1[$title_key])) {
                $section->addText(htmlspecialchars('1 - Emerging'), $header);

                foreach ($results_score_1[$title_key] as $key => $value) {
                    $temp = $key . '. ' . $value;
                    $section->addText($temp);
                }

                $section->addTextBreak(1);
            }

        }
        
        $section->addText(htmlspecialchars('Home Program'), $header);

        foreach ($title as $title_key => $title_value) {
            if (isset($zero_list[$title_key])) {
                $section->addText(htmlspecialchars($title_value), $header);

                foreach ($zero_list[$title_key] as $key => $value) {
                    $temp = '<b>' . $key . '. </b>' . $value;
                    $section->addText($temp);
                }

                $section->addTextBreak(1);
            }
        }
        
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');

        try {
            $objWriter->save(storage_path($file_name));
        } catch (Exception $e) {
        }

        return response()->download(storage_path($file_name));

    }

    public function not_present($list)
    {
        if (is_array($list) && count($list) > 0) {
            // Create an array with range from array 
            // minimum to maximum.
            $new_array = range(min($list), max($list));

            // Find those elements that are present
            // in new_array but not in given list
            $diff = array_diff($new_array, $list);
            return $diff[count($diff)];
        } else {
            return [];
        }
    }
}
