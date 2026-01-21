<?php

namespace App\Http\Controllers\Registration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Oppediatric;
use App\Models\Baby;
use App\Models\Mother;
use App\Models\Medications;
use Carbon\Carbon;
use App\Models\Masters\DrugIvFluidMaster;
use App\Models\Masters\Vaccine as Vaccine;
use App\Models\Settings\Settings;
use App\Models\OpPrintPageConfig;
use App\Models\Settings\DeleteApproval;
use App\Models\Op;
use App\Http\Controllers\Registration\OpController;
use App\Http\Controllers\Flow\FlowController;

class PediatricOpController extends Controller
{
	public function __construct(Guard $auth, OpController $op)
	{

		$this->middleware('role:PEDIATRICS_OP_REG,write', ['only'=>['store','update','edit','create','destory']]);
		$this->middleware('role:PEDIATRICS_OP_REG,read', ['only'=>['index','show']]);	
		$this->auth = $auth;
        $this->op = $op;
		$this->time_zone = env('TIME_ZONE');

	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$limit = 50;
    	if (!empty($request->input('limit'))) {
    		$request->session()->put('limit', $request->input('limit'));
    		$limit =  $request->session()->get('limit');
    	}  elseif ($request->session()->has('limit')) {
    		$limit =  $request->session()->get('limit');
    	}

        //Initialize the record sorting key and order  
    	$order['sortby']    = 'op_date';
    	$order['sortorder'] = 'desc';   

        //set the records sorting key and order  
    	if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {

    		$order['sortby']     = \SiteHelpers::decrypt_id($request->input('sortby'));
    		$order['sortorder']  = $request->input('sortorder');
    	}

    	$search = array();
    	$search['search_txt']='';
    	if (!empty($request->input('search_txt'))) {
    		$search['search_txt'] = $request->input('search_txt');
    	}

    	$navigate['main_nav'] = 'op';
    	$navigate['sub_nav']  = 'pediatric';
		$result 	= Oppediatric::get_lists($request->input('page'), $limit, $search, $order, 1); //DB::table('op_details')->get();
		$results 	= $result['result'];
		$getTotal   = Oppediatric::GetTotal();
		$total   	= $result['total'];	

		$page                   = !empty($request->input('page')) ? $request->input('page') : 1;
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

		$results = collect($results)->sortByDesc('op_date');

		return view('registration.pediatric.list', compact('results', 'navigate', 'pagination', 'search', 'getTotal', 'order'));
	}

	/* SELECT BABY FORM TO SELECT THE EXISTING BABY FOR REPEATED VISIT. 
	OR SELECT CREATE NEW OPTION TO CREATE A NEW BABY RECORD */
	public function chooseBaby()  {

		$navigate['main_nav'] = 'registration';
		$navigate['sub_nav']  = 'pediatric';		
		$baby                 = Baby::baby_list_op();
        $babies = \ValuelistHelpers::select2DataFormater($baby, true);

		$SubmitButtonText  = "Start";

		return view('registration.pediatric.select_patient', compact('SubmitButtonText', 'babies', 'navigate'));	
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = 0)
    {
    	$id = \SiteHelpers::decrypt_id($id);

    	$baby_detail = Baby::get_data($id)->first();

    	$current_date = date('d-m-Y');

    	$time   = \SiteHelpers::prepare_time();
    	$current_time = [];
    	$current_time['hours']  = (int)date("h", strtotime(Carbon::now(env('TIME_ZONE'))));
    	$current_time['mins']   = (int)date("i", strtotime(Carbon::now(env('TIME_ZONE'))));
    	$current_time['am']     = date("A", strtotime(Carbon::now(env('TIME_ZONE'))));

    	$drugs                = DrugIvFluidMaster::getOralDrug();

    	$drug_data[0]   = 'Select';
    	foreach ($drugs as $drug) {
    		$drug_data[$drug->Id]    = $drug->Name;

    	}

    	$Vaccines             = Vaccine::get_lists();

    	$vaccine[0]    = 'Select';
    	foreach ($Vaccines as $vac) {
    		$vaccine[$vac->Id] = $vac->Name;
    	}

        /*VACCINE CHART DETAILS START*/

        $mas_vaccine = Op::getVaccineChart();
        
        $mas_vaccine_chart = $mas_vaccine->groupBy('vaccine_age_id')->map(function($item, $value)
        {
            return $item->sortBy('sort_order');
        })->toArray();

        $user_sign = json_encode(\ValuelistHelpers::getUserSign());

        if (isset($baby_detail->BabyId)) {
            $baby_vaccine_chart_details = Op::getBabyVaccineChart($baby_detail->BabyId);
            $baby_vaccine_chart = $baby_vaccine_chart_details->groupBy('age_id')->map(function($item, $value)
            {
                return $item->sortBy('age_sort_order');
            })->toArray();
        }
        if (isset($baby_vaccine_chart) && count($baby_vaccine_chart) > 0) {
            
            $mas_vaccine_age = $baby_vaccine_chart_details->pluck('age', 'age_id')->toArray();
        }
        else
        {
            $mas_vaccine_age = $mas_vaccine->pluck('age', 'vaccine_age_id')->toArray();
        }
        /*VACCINE CHART DETAILS END*/

        if (isset($baby_detail->BabyId)) {
            $neonatal_today_visit = Op::where('BabyId', $baby_detail->BabyId)->where('OpDate', date('Y-m-d'))->orderBy('OpId', 'desc')->first();
        }

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

    	return view('registration.pediatric.op_create', compact('baby_detail', 'id', 'current_date', 'time', 'current_time', 'drug_data', 'vaccine', 'mas_vaccine_age', 'baby_vaccine_chart', 'user_sign', 'mas_vaccine_chart', 'neonatal_today_visit', 'current_age', 'current_chart_age'));
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

    	$print_flag = isset($input['print_flag'])?$input['print_flag']:0;
    	unset($input['print_flag']);

    	if (isset($input['mother_id']) && $input['mother_id'] != '' && $input['mother_id'] != 0) {
            $mother_details['MotherName'] = isset($input['mother_name']) ? $input['mother_name'] : null;
    		$mother_details['UserModified']	= $this->auth->user()->id; 	
    		$mother_details['DateModified']  = Carbon::now();        
    		$mother_id              = $input['mother_id'];
    		$mother                 = Mother::findOrfail($mother_id);
    		$mother->update($mother_details);
    	} else {
            $mother_details['MotherName'] = isset($input['mother_name']) ? $input['mother_name'] : null;
            $mother_details['PartnerName'] = isset($input['parter_name']) ? $input['parter_name'] : null;
            $mother_details['Mobile'] = isset($input['mobile']) ? $input['mobile'] : null;
            $mother_details['Address1'] = isset($input['address1']) ? $input['address1'] : null;
            $mother_details['Address2'] = isset($input['address2']) ? $input['address2'] : null;
            $mother_details['Address3'] = isset($input['city']) ? $input['city'] : null;
            $mother_details['Address4'] = isset($input['pincode']) ? $input['pincode'] : null;
            $mother_details['DateAdded'] = Carbon::now();
    		$mother_details['UserAdded']	= $this->auth->user()->id; 	
    		$mother_id  = Mother::create($mother_details)->MotherId;	
    	}		

    	if (isset($input['baby_id']) && $input['baby_id'] != '' && $input['baby_id'] != 0) {
    		$baby_details['BMrNo'] 	= $input['mrno'];
            $baby_details['BabyName'] = (isset($input['BabyName']) && !empty($input['BabyName'])) ? $input['BabyName'] : null;
            $baby_details['DOB'] = (isset($input['DOB']) && !empty($input['DOB'])) ? date('Y-m-d', strtotime($input['DOB'])) : null;
            $baby_details['Sex'] = (isset($input['Sex']) && !empty($input['Sex'])) ? $input['Sex'] : null;
            $baby_details['allegries'] = (isset($input['allegries']) && !empty($input['allegries'])) ? $input['allegries'] : null;
    		$baby_details['DateModified']  = Carbon::now();  	
    		$baby_details['UserModified']	= $this->auth->user()->id; 	
    		$baby                   = Baby::findOrfail($input['baby_id']);
    		$baby_id = $input['baby_id'];
    		$baby->update($baby_details);
    	} else {
            $baby_details['BMrNo']    = $input['mrno'];
    		$baby_details['BabyName'] = (isset($input['BabyName']) && !empty($input['BabyName'])) ? $input['BabyName'] : null;
    		$baby_details['DOB'] = (isset($input['DOB']) && !empty($input['DOB'])) ? date('Y-m-d', strtotime($input['DOB'])) : null;
    		$baby_details['Sex'] = (isset($input['Sex']) && !empty($input['Sex'])) ? $input['Sex'] : null;
    		$baby_details['MotherId'] = $mother_id;
    		$baby_details['DateAdded'] = Carbon::now();
    		$baby_details['UserAdded']	= $this->auth->user()->id; 
    		$baby_id = Baby::create($baby_details)->BabyId;
    	}
        $this->op->storeVaccineChart($input['vaccine_chart_input'], $baby_id);

    	if (isset($baby_id)) {
    		$pediatric_details['baby_id'] = $baby_id;
    		$pediatric_details['mother_id'] = $mother_id;
    		$pediatric_details['op_date'] = (isset($input['op_date']) && !empty($input['op_date'])) ? date('Y-m-d', strtotime($input['op_date'])) : null;
    		$pediatric_details['op_hours'] = (isset($input['op_hours']) && !empty($input['op_hours'])) ? $input['op_hours'] : null;
    		$pediatric_details['op_mins'] = (isset($input['op_mins']) && !empty($input['op_mins'])) ? $input['op_mins'] : null;
            $pediatric_details['op_session'] = (isset($input['op_session']) && !empty($input['op_session'])) ? $input['op_session'] : null;
            $pediatric_details['age_year'] = (isset($input['chronological_year']) && !empty($input['chronological_year'])) ? $input['chronological_year'] : null;
            $pediatric_details['age_month'] = (isset($input['chronological_month']) && !empty($input['chronological_month'])) ? $input['chronological_month'] : null;
    		$pediatric_details['age_days'] = (isset($input['chronological_days']) && !empty($input['chronological_days'])) ? $input['chronological_days'] : null;
    		$pediatric_details['current_weight'] = (isset($input['current_weight']) && !empty($input['current_weight'])) ? $input['current_weight'] : null;
    		$pediatric_details['current_ofc'] =  (isset($input['current_ofc']) && !empty($input['current_ofc'])) ? $input['current_ofc'] : null;
    		$pediatric_details['current_length'] = (isset($input['current_length']) && !empty($input['current_length'])) ? $input['current_length'] : null;
    		$pediatric_details['current_bmi'] = (isset($input['current_bmi']) && !empty($input['current_bmi'])) ? $input['current_bmi'] : null;
    		$pediatric_details['hospital_name'] = (isset($input['hospital_name']) && !empty($input['hospital_name'])) ? $input['hospital_name'] : null;
    		$pediatric_details['seen_by'] = (isset($input['seen_by']) && !empty($input['seen_by'])) ? $input['seen_by'] : null;
    		$pediatric_details['review'] = (isset($input['review']) && !empty($input['review'])) ? date('Y-m-d', strtotime($input['review'])) : null;
    		$pediatric_details['review_days'] = (isset($input['review_days']) && !empty($input['review_days'])) ? $input['review_days'] : null;
    		$pediatric_details['review_time'] = (isset($input['review_time']) && !empty($input['review_time'])) ? $input['review_time'] : null;
    		$pediatric_details['review_min'] = (isset($input['review_min']) && !empty($input['review_min'])) ? $input['review_min'] : null;
    		$pediatric_details['review_session'] = (isset($input['review_session']) && !empty($input['review_session'])) ? $input['review_session'] : null;
    		$pediatric_details['current_status'] = (isset($input['current_status']) && !empty($input['current_status'])) ? $input['current_status'] : null;
    		$pediatric_details['hopi'] = (isset($input['hopi']) && !empty($input['hopi'])) ? $input['hopi'] : null;
    		$pediatric_details['development'] = (isset($input['development']) && !empty($input['development'])) ? $input['development'] : null;
    		$pediatric_details['immunization_content'] = (isset($input['immunization_content']) && !empty($input['immunization_content'])) ? $input['immunization_content'] : null;
    		$pediatric_details['examination'] = (isset($input['examination']) && !empty($input['examination'])) ? $input['examination'] : null;
    		$pediatric_details['impression'] = (isset($input['impression']) && !empty($input['impression'])) ? $input['impression'] : null;
    		$pediatric_details['advice'] =  (isset($input['advice']) && !empty($input['advice'])) ? $input['advice'] : null;
    		$pediatric_details['immunization'] = (isset($input['immunization']) && !empty($input['immunization'])) ? $input['immunization'] : null;
    		$pediatric_details['schedule'] = (isset($input['schedule']) && !empty($input['schedule'])) ? $input['schedule'] : null;
    		$pediatric_details['vaccine'] = (isset($input['Vaccine']) && !empty($input['Vaccine'])) ? json_encode($input['Vaccine']) : json_encode(array());  
    		$pediatric_details['created_by'] = $this->auth->user()->id;
    		$pediatric_details['created_date_time'] = Carbon::now();

    		$pediatric_id = Oppediatric::create($pediatric_details)->id;

            $this->makeAppointment($input, $pediatric_id);

    		if (isset($input['M_Drugs'])) {

    			$standard_dose = array_count_values($input['M_Drugs']);

    			foreach ($input['M_Drugs'] as $key => $value) {

    				$discharge_medications = array(
    					'Medication'	=> $input['M_Drugs'][$key],
    					'Dose'          => $input['M_Dose'][$key],
    					'route'         => $input['M_Route'][$key],
    					'Frequency'     => $input['M_Frequency'][$key],
    					'Duration'      => $input['M_Duration'][$key],
    					'genericname'   => $input['m_generic_name'][$key],
    					'formulation'   => $input['formulation'][$key],
    					'flag'          => 4,								
    					'AdmissionId'	=> 00,
    					'BabyId'     	=> $baby_id,
    					'source_id'     => $pediatric_id,
    					'standard_dose' => $standard_dose[$input['M_Drugs'][$key]] > 1 ? 1 : 0

    				);
    				Medications::create($discharge_medications);
    			}

    		}
    	}

    	if ($print_flag == 1) {
    		return redirect(action('Registration\PediatricOpController@index'))->with('Success', 'Record saved successfully !');
    	} elseif ($print_flag == 2) {
    		return redirect(action('Registration\PediatricOpController@edit', \SiteHelpers::encrypt_id($pediatric_id)))->with('Success', 'Record saved successfully !');
    	} elseif ($print_flag == 3) {
    		return redirect(action('Registration\PediatricOpController@show', \SiteHelpers::encrypt_id($pediatric_id)))->with('Success', 'Record saved successfully !');
    	} else {
    		return redirect(action('Registration\PediatricOpController@index'))->with('Success', 'Record saved successfully !');
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
    	$pediatric_details = Oppediatric::findOrfail($id)->toArray();

    	$baby_details = (array)Baby::get_data($pediatric_details['baby_id'])->first();

    	$baby_detail = (object)array_merge($pediatric_details, $baby_details);
		
		$headerContent = Settings::findorfail(1);

		$medications        = Medications::select('discharge_medications.*', 'mas_drugivfluid.value as Value')
		->join('mas_drugivfluid', 'mas_drugivfluid.id', '=', 'discharge_medications.Medication')
		->where(['discharge_medications.BabyId'=>$baby_detail->BabyId,'discharge_medications.AdmissionId'=>0,'source_id'=>$id,'discharge_medications.flag'=>4])
		->orderBy('Id', 'asc')
		->get();

		$drugs                = DrugIvFluidMaster::getOralDrug();

		$drug_data[0] = 'Select';

		foreach ($drugs as $drug) {
			$drug_data[$drug->Id] = $drug->Name . '/' . $drug->generic_name;
		}

		$Vaccines             = Vaccine::get_lists();

		$vaccine[0] = 'Select';
		foreach ($Vaccines as $vac) {
			$vaccine[$vac->Id] = $vac->Name;
		}

		$doctors = \ValuelistHelpers::mas_doctors_list();
		
		$baby_detail->vaccine = json_decode($baby_detail->vaccine);

		$closewinlink = action('Registration\PediatricOpController@OpsubList', \SiteHelpers::encrypt_id($baby_detail->BabyId));

		$current_user = $this->auth->user()->id;
		$current_ip = \Request::ip();

		$user_config = $page_config = OpPrintPageConfig::getUserConfigProperty($current_user);

		$ip_config = OpPrintPageConfig::getIpConfigProperty($current_ip);

		if (!(count($user_config) > 0)) {
			$page_config = $ip_config;
		}

		return view('registration.pediatric.print', compact('baby_detail', 'headerContent', 'medications', 'drug_data', 'doctors', 'closewinlink', 'vaccine', 'page_config', 'user_config', 'ip_config'));
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
    	$pediatric_details = Oppediatric::findOrfail($id)->toArray();
        $pediatric_details['review'] = strtotime($pediatric_details['review']) ? date('d-m-Y', strtotime($pediatric_details['review'])) : null;

    	$baby_details = (array)Baby::get_data($pediatric_details['baby_id'])->first();

    	$baby_detail = (object)array_merge($pediatric_details, $baby_details);

    	$time   = \SiteHelpers::prepare_time();

    	$drugs                = DrugIvFluidMaster::getOralDrug();

    	$drug_data[0]   = 'Select';
    	foreach ($drugs as $drug) {
    		$drug_data[$drug->Id]    = $drug->Name;

    	}

    	$Vaccines             = Vaccine::get_lists();

    	$vaccine[0]    = 'Select';
    	foreach ($Vaccines as $vac) {
    		$vaccine[$vac->Id] = $vac->Name;
    	}
		$medications = Medications::where(['BabyId'=>$baby_detail->BabyId, 'AdmissionId'=>0, 'flag'=>4, 'source_id'=>$id])->orderBy('Id', 'asc')->get();
		
		$baby_detail->vaccine = json_decode($baby_detail->vaccine);

        /*VACCINE CHART DETAILS START*/
        $baby_vaccine_chart_details = Op::getBabyVaccineChart($baby_detail->BabyId);
        $baby_vaccine_chart = $baby_vaccine_chart_details->groupBy('age_id')->map(function($item, $value)
        {
            return $item->sortBy('age_sort_order');
        })->toArray();;
        $mas_vaccine = Op::getVaccineChart();
        
        $mas_vaccine_chart = $mas_vaccine->groupBy('vaccine_age_id')->map(function($item, $value)
        {
            return $item->sortBy('sort_order');
        })->toArray();

        $user_sign = json_encode(\ValuelistHelpers::getUserSign());
        if (count($baby_vaccine_chart) > 0) {
            
            $mas_vaccine_age = $baby_vaccine_chart_details->pluck('age', 'age_id')->toArray();
        }
        else
        {
            $mas_vaccine_age = $mas_vaccine->pluck('age', 'vaccine_age_id')->toArray();
        }
        /*VACCINE CHART DETAILS END*/

        $current_chart_age = 0;
        if ($baby_detail->g_weeks < 37 && !empty($baby_detail->g_weeks)) {
            $baby_corrected_age = \SiteHelpers::calculateCorrectedGestation($baby_detail->g_weeks, $baby_detail->g_days, $baby_detail->DOB, $baby_detail->op_date);
            $current_chart_age = $baby_corrected_age['corrected_age_weeks'];
        }
        $current_age = \SiteHelpers::getChronologicalage($baby_detail->DOB, $baby_detail->op_date);
        if (isset($baby_detail->BabyId)) {
            $neonatal_today_visit = Op::where('BabyId', $baby_detail->BabyId)->where('OpDate', date('Y-m-d'))->orderBy('OpId', 'desc')->first();
        }

    	return view('registration.pediatric.op_edit', compact('baby_detail', 'time', 'drug_data', 'vaccine', 'id', 'medications', 'mas_vaccine_chart', 'mas_vaccine_age', 'baby_vaccine_chart', 'user_sign', 'current_chart_age', 'current_age', 'neonatal_today_visit'));
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

    	$print_flag = isset($input['print_flag'])?$input['print_flag']:0;
    	unset($input['print_flag']);

    	$baby_id = $input['BabyId'];
        $baby_details['allegries'] = (isset($input['allegries']) && !empty($input['allegries'])) ? $input['allegries'] : null;
        $baby_details['Sex'] = (isset($input['Sex']) && !empty($input['Sex'])) ? $input['Sex'] : null;
        $baby_details['DateModified'] = Carbon::now();     
        $baby_details['UserModified'] = $this->auth->user()->id;  
        $baby_details['BMrNo'] = $input['mrno'];
        $baby = Baby::findOrfail($baby_id);
        $baby->update($baby_details);
        
        $this->op->storeVaccineChart($input['vaccine_chart_input'], $baby_id);

    	$pediatric_details['op_date'] = (isset($input['op_date']) && !empty($input['op_date'])) ? date('Y-m-d', strtotime($input['op_date'])) : null;
    	$pediatric_details['op_hours'] = (isset($input['op_hours']) && !empty($input['op_hours'])) ? $input['op_hours'] : null;
    	$pediatric_details['op_mins'] = (isset($input['op_mins']) && !empty($input['op_mins'])) ? $input['op_mins'] : null;
    	$pediatric_details['op_session'] = (isset($input['op_session']) && !empty($input['op_session'])) ? $input['op_session'] : null;
        $pediatric_details['age_year'] = (isset($input['chronological_year']) && !empty($input['chronological_year'])) ? $input['chronological_year'] : null;
        $pediatric_details['age_month'] = (isset($input['chronological_month']) && !empty($input['chronological_month'])) ? $input['chronological_month'] : null;
        $pediatric_details['age_days'] = (isset($input['chronological_days']) && !empty($input['chronological_days'])) ? $input['chronological_days'] : null;            
    	$pediatric_details['current_weight'] = (isset($input['current_weight']) && !empty($input['current_weight'])) ? $input['current_weight'] : null;
    	$pediatric_details['current_ofc'] =  (isset($input['current_ofc']) && !empty($input['current_ofc'])) ? $input['current_ofc'] : null;
    	$pediatric_details['current_length'] = (isset($input['current_length']) && !empty($input['current_length'])) ? $input['current_length'] : null;
    	$pediatric_details['current_bmi'] = (isset($input['current_bmi']) && !empty($input['current_bmi'])) ? $input['current_bmi'] : null;
    	$pediatric_details['hospital_name'] = (isset($input['hospital_name']) && !empty($input['hospital_name'])) ? $input['hospital_name'] : null;
    	$pediatric_details['seen_by'] = (isset($input['seen_by']) && !empty($input['seen_by'])) ? $input['seen_by'] : null;
    	$pediatric_details['review'] = (isset($input['review']) && !empty($input['review'])) ? date('Y-m-d', strtotime($input['review'])) : null;
    	$pediatric_details['review_days'] = (isset($input['review_days']) && !empty($input['review_days'])) ? $input['review_days'] : null;
    	$pediatric_details['review_time'] = (isset($input['review_time']) && !empty($input['review_time'])) ? $input['review_time'] : null;
    	$pediatric_details['review_min'] = (isset($input['review_min']) && !empty($input['review_min'])) ? $input['review_min'] : null;
    	$pediatric_details['review_session'] = (isset($input['review_session']) && !empty($input['review_session'])) ? $input['review_session'] : null;
    	$pediatric_details['current_status'] = (isset($input['current_status']) && !empty($input['current_status'])) ? $input['current_status'] : null;
    	$pediatric_details['hopi'] = (isset($input['hopi']) && !empty($input['hopi'])) ? $input['hopi'] : null;
    	$pediatric_details['development'] = (isset($input['development']) && !empty($input['development'])) ? $input['development'] : null;
    	$pediatric_details['immunization_content'] = (isset($input['immunization_content']) && !empty($input['immunization_content'])) ? $input['immunization_content'] : null;
    	$pediatric_details['examination'] = (isset($input['examination']) && !empty($input['examination'])) ? $input['examination'] : null;
    	$pediatric_details['impression'] = (isset($input['impression']) && !empty($input['impression'])) ? $input['impression'] : null;
    	$pediatric_details['advice'] =  (isset($input['advice']) && !empty($input['advice'])) ? $input['advice'] : null;
    	$pediatric_details['immunization'] = (isset($input['immunization']) && !empty($input['immunization'])) ? $input['immunization'] : null;
    	$pediatric_details['schedule'] = (isset($input['schedule']) && !empty($input['schedule'])) ? $input['schedule'] : null;
    	$pediatric_details['vaccine'] = (isset($input['Vaccine']) && !empty($input['Vaccine'])) ? json_encode($input['Vaccine']) : json_encode(array());  
    	$pediatric_details['modified_by'] = $this->auth->user()->id;
    	$pediatric_details['modified_date_time'] = Carbon::now();

    	$pediatric_results = Oppediatric::findOrfail($id);

    	$pediatric_results->update($pediatric_details);

        $this->makeAppointment($input, $id);

    	$medication_old_list = Medications::where(['BabyId'=>$baby_id, 'AdmissionId'=>0, 'flag'=>4, 'source_id'=>$id])->orderBy('Id', 'asc')->get();
        $medication_old_list = collect($medication_old_list)->pluck('Id');

        foreach ($medication_old_list as $key => $value) {

            if (isset($input['M_Drugs']) && isset($input['M_Drugs'][$value])) {
                $discharge_medications = array(
                    'Medication'    => (isset($input['M_Drugs'][$value]) && !empty($input['M_Drugs'][$value])) ? $input['M_Drugs'][$value] : null,
                    'genericname'   => (isset($input['m_generic_name'][$value]) && !empty($input['m_generic_name'][$value])) ? $input['m_generic_name'][$value] : null,
                    'formulation'   => (isset($input['formulation'][$value]) && !empty($input['formulation'][$value])) ? $input['formulation'][$value] : null,
                    'route'         => (isset($input['M_Route'][$value]) && !empty($input['M_Route'][$value])) ? $input['M_Route'][$value] : null,
                    'Dose'          => (isset($input['M_Dose'][$value]) && !empty($input['M_Dose'][$value])) ? $input['M_Dose'][$value] : null,
                    'Frequency'     => (isset($input['M_Frequency'][$value]) && !empty($input['M_Frequency'][$value])) ? $input['M_Frequency'][$value] : null,
                    'Duration'      => (isset($input['M_Duration'][$value]) && !empty($input['M_Duration'][$value])) ? $input['M_Duration'][$value] : null
                );
                
                Medications::where('Id', $value)->update($discharge_medications);
                unset($input['M_Drugs'][$value]);
                unset($medication_old_list[$key]);
            }
        }

        Medications::whereIn('Id', $medication_old_list)->delete();
        $medication_id = [];

        if (isset($input['M_Drugs'])) {

            $standard_dose = array_count_values($input['M_Drugs']);

            foreach ($input['M_Drugs'] as $key => $value) {

                $discharge_medications = array(
                    'Medication'    => (isset($input['M_Drugs'][$key]) && !empty($input['M_Drugs'][$key])) ? $input['M_Drugs'][$key] : null,
                    'genericname'   => (isset($input['m_generic_name'][$key]) && !empty($input['m_generic_name'][$key])) ? $input['m_generic_name'][$key] : null,
                    'formulation'   => (isset($input['formulation'][$key]) && !empty($input['formulation'][$key])) ? $input['formulation'][$key] : null,
                    'route'         => (isset($input['M_Route'][$key]) && !empty($input['M_Route'][$key])) ? $input['M_Route'][$key] : null,
                    'Dose'          => (isset($input['M_Dose'][$key]) && !empty($input['M_Dose'][$key])) ? $input['M_Dose'][$key] : null,
                    'Frequency'     => (isset($input['M_Frequency'][$key]) && !empty($input['M_Frequency'][$key])) ? $input['M_Frequency'][$key] : null,
                    'Duration'      => (isset($input['M_Duration'][$key]) && !empty($input['M_Duration'][$key])) ? $input['M_Duration'][$key] : null,
                    'flag'          => 4,                               
                    'AdmissionId'   => 0,
                    'BabyId'        => $input['BabyId'],
                    'source_id'     => $id,
                    'standard_dose' => $standard_dose[$input['M_Drugs'][$key]] > 1 ? 1 : 0

                );
                $medication_id[$key] = Medications::create($discharge_medications)->Id;
            }

        }   

        if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'Record updated successfully !', 'medication_id'=>$medication_id], 200);
        }

    	if ($print_flag == 1) {
    		return redirect(action('Registration\PediatricOpController@index'))->with('Success', 'Record updated successfully !');
    	} elseif ($print_flag == 2) {
    		return redirect(action('Registration\PediatricOpController@edit', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully !');
    	} elseif ($print_flag == 3) {
    		return redirect(action('Registration\PediatricOpController@show', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully !');
    	} elseif ($print_flag == 4) {
            return redirect(action('Registration\PediatricOpController@print', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully !');
        } else {
    		return redirect(action('Registration\PediatricOpController@index'))->with('Success', 'Record updated successfully !');
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
		$results = Oppediatric::findOrfail($id);

		$user_detail = array(
			'deleted_by'	     => $this->auth->user()->id,
			'modified_date_time' => Carbon::now(),
			'is_deleted'		 => 1
		);
		$results->update($user_detail);
		$result = Oppediatric::get_oprecord($id);
		$op_res = $result[0];
		$delete_data = array(
			'Name'		  	   => $op_res->BabyName,
			'AdmissionDate'	   => $results['op_date'],
			'ModuleController' => 'Registration\PediatricOpController',
			'ModuleId'		   => $id,
			'ModuleName'	   => 'Pediatric OP Registration',
			'UserDeleted'	   => $this->auth->user()->id,
			'DateDeleted'	   => Carbon::now()
		);
		DeleteApproval::create($delete_data);

		return redirect(action('Registration\PediatricOpController@index'))->with('info', 'Record deleted successfully !');
	}

	/**
	 * show the visite list for a baby
	 *
	 * @param baby_id encrypted hash value 
	 */
	public function OpsubList(Request $request, $baby_id)
	{
        // decrypt the baby id  
		$baby_id     = \SiteHelpers::decrypt_id($baby_id);

		$seen_by = $request->get('seen_by');
		if ($seen_by != '') {
			$seen_by = \SiteHelpers::decrypt_id($seen_by);
		} else {
			$seen_by = '';
		}
		
		//get the visite list 
		$temp_visite_list = Oppediatric::GetOpvisitList($baby_id);

		$visite_list = collect($temp_visite_list)->sortByDesc('op_visite')->toArray();

        //get Baby name
		$baby_name   = isset($visite_list[0]->BabyName) ? $visite_list[0]->BabyName.' - '.$visite_list[0]->BMrNo : '';
		$navigate['main_nav'] = 'op';
		$navigate['sub_nav']  = 'pediatric';

		return view('registration.pediatric.visit_list', compact('visite_list', 'baby_name','navigate', 'seen_by'));

	}
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        $id = \SiteHelpers::decrypt_id($id);
        $pediatric_details = Oppediatric::findOrfail($id)->toArray();

        $baby_details = (array)Baby::get_data($pediatric_details['baby_id'])->first();

        $baby_detail = (object)array_merge($pediatric_details, $baby_details);
        
        $headerContent = Settings::findorfail(1);

        $medications        = Medications::select('discharge_medications.*', 'mas_drugivfluid.value as Value')
        ->join('mas_drugivfluid', 'mas_drugivfluid.id', '=', 'discharge_medications.Medication')
        ->where(['BabyId'=>$baby_detail->BabyId,'AdmissionId'=>0,'source_id'=>$id,'flag'=>4])
        ->orderBy('Id', 'asc')
        ->get();

        $drugs                = DrugIvFluidMaster::getOralDrug();

        $drug_data[0] = 'Select';

        foreach ($drugs as $drug) {
            $drug_data[$drug->Id] = $drug->Name . '/' . $drug->generic_name;
        }

        $Vaccines             = Vaccine::get_lists();

        $vaccine[0] = 'Select';
        foreach ($Vaccines as $vac) {
            $vaccine[$vac->Id] = $vac->Name;
        }

        $doctors = \ValuelistHelpers::mas_doctors_list();
        
        $baby_detail->vaccine = json_decode($baby_detail->vaccine);



        $results = Baby::get_data($baby_detail->BabyId)->first();

        /*VACCINE CHART DETAILS START*/
        $baby_vaccine_chart_details = Op::getBabyVaccineChart($baby_detail->BabyId);
        $baby_vaccine_chart = $baby_vaccine_chart_details->groupBy('age_id')->map(function($item, $value)
        {
            return $item->sortBy('age_sort_order');
        })->toArray();
        $mas_vaccine = Op::getVaccineChart();
        
        $mas_vaccine_chart = $mas_vaccine->groupBy('vaccine_age_id')->map(function($item, $value)
        {
            return $item->sortBy('sort_order');
        })->toArray();

        $user_sign = json_encode(\ValuelistHelpers::getUserSign());
        if (count($baby_vaccine_chart) > 0) {
            
            $mas_vaccine_age = $baby_vaccine_chart_details->pluck('age', 'age_id')->toArray();
        }
        else
        {
            $mas_vaccine_age = $mas_vaccine->pluck('age', 'vaccine_age_id')->toArray();
        }
        /*VACCINE CHART DETAILS END*/

        $closewinlink = action('Registration\PediatricOpController@OpsubList', \SiteHelpers::encrypt_id($baby_detail->BabyId));

        $is_print = 'print';
        $headerContent = Settings::findorfail(1);

        $current_user = $this->auth->user()->id;
        $current_ip = \Request::ip();

        $user_config = $page_config = OpPrintPageConfig::getUserConfigProperty($current_user);

        $ip_config = OpPrintPageConfig::getIpConfigProperty($current_ip);

        if (!(count($page_config) > 0)) {
            $page_config = $ip_config;
        }

        return view('registration.pediatric.print_with_vaccine', compact('baby_detail', 'headerContent', 'medications', 'drug_data', 'doctors', 'closewinlink', 'vaccine', 'page_config', 'user_config', 'ip_config', 'results', 'mas_vaccine_age', 'baby_vaccine_chart', 'user_sign', 'is_print'));
    }

    /**
     * Store a newly created appointment.
     *
     */
    public function makeAppointment($input, $id = 0)
    {
        if (!is_null($input['review']) && !empty($input['review']) && $id != 0) {
            $appointment_details = new Request([
                'category'   => 'Review Appointment',
                'date'       => $input['review'],
                'time'       => $input['review_time'],
                'mins'       => $input['review_min'],
                'session'    => $input['review_session'],
                'consultant' => $input['seen_by'],
                'patient'    => $input['BabyId'],
                'ref_id'     => $id,
                'from'       => 3
            ]);
            FlowController::patientDetailUpdate($appointment_details, 0);
        }

    }
}
