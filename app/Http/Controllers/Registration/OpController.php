<?php namespace App\Http\Controllers\Registration;

use Carbon\Carbon;
use App\Models\Op;
use App\Models\Baby;
use App\Models\Mother;
use App\Models\Medications;
use App\Models\Settings\DeleteApproval;
// use App\Models\Masters\Drug as Drug;
use App\Models\Masters\DrugIvFluidMaster;
use App\Models\Masters\Vaccine as Vaccine;
use App\Models\AutoCompleteWords;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\OpRequest;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;
use App\Models\Settings\Settings;
use App\Models\Neonatal;
use App\Models\DischargeSummary;
use App\Http\Controllers\Flow\FlowController;
use App\Models\PostDaycare;
use App\Models\Postnatal;
use App\Models\Icd;
use App\Models\Reports\PostProblemDischargeSummary;
use App\Models\Nicu;
use App\Models\Daycare;
use App\Models\Reports\ProblemDischarge;
use App\Models\OpPrintPageConfig;
use App\Models\Oppediatric;
use App\Models\Masters\DasiiquestionsMaster;
use App\Models\FileUpload;
use App\Models\NeuroEligibility;
use App\Models\NeuroVisit;
use App\Http\Controllers\Registration\NeuroController;

class OpController extends Controller 
{

	public function __construct(Guard $auth, FlowController $flow)
	{

		$this->middleware('role:OP_REG,write', ['only'=>['store','update','edit','create','destory']]);
		$this->middleware('role:OP_REG,read', ['only'=>['index','show']]);	
		$this->auth = $auth;
		$this->flow = $flow;
		$this->time_zone = env('TIME_ZONE');

	}

	/**
	 * Display listing of OP Registration
	 *
	 * @return Response
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
		$order['sortby']    = 'OpId';
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
		$navigate['sub_nav']  = 'neo';
		$result 	= Op::get_lists($request->input('page'), $limit, $search, $order, 1); //DB::table('op_details')->get();
		$results 	= $result['result'];
		$getTotal   = Op::GetTotal();
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

		$this->flow->clearFlow();
		$results = collect($results)->sortByDesc('OpDate');

 		// echo '<pre>';print_r($results);exit;

		return view('registration.op_list', compact('results', 'navigate', 'pagination', 'search', 'getTotal', 'order'));

	}

	/**
	* show the visite list for a baby
	*
	*@param baby_id encrypted hash value 
	*/

	public function OpsubList(Request $request, $baby_id)
	{
        // decrypt the baby id  
		$baby_id     = \SiteHelpers::decrypt_id($baby_id);
		
		//get the visite list 
		$neonatal_visite_list = Op::GetOpvisitList($baby_id)->toArray();

		$neuro_visite_list = NeuroVisit::GetNeuroVisitList($baby_id)->toArray();

		$temp_visite_list = array_merge($neonatal_visite_list, $neuro_visite_list);

		$list = collect($temp_visite_list)->groupBy('type')->toArray();

		$neonatal_visit = isset($list['neonatal']) ? collect($list['neonatal'])->pluck('OpDate')->toArray() : [];
		$neuro_visit = isset($list['neuro']) ? collect($list['neuro'])->pluck('visit_date')->toArray() : [];

		$temp = [];
		foreach ($neuro_visit as $value) {
			if (!in_array($value, $neonatal_visit) || in_array($value, $temp)) {
				$neonatal_visit[] = $value;
			} else {
				$temp[] = $value;
			}
		}

		$visite_list['count'] = count($neonatal_visit);

        $temp_visite_list = collect($temp_visite_list)->sortByDesc('visit_date');
		$visite_list['lists'] = collect($temp_visite_list)->groupBy(['visit_date', 'type'])->toArray();

        krsort($visite_list['lists']);
        //get Baby name
		$baby_name   = isset($neonatal_visite_list[0]->BabyName) ? $neonatal_visite_list[0]->BabyName.' - '.$neonatal_visite_list[0]->BMrNo : '';
		$baby_mrn   = isset($neonatal_visite_list[0]->BMrNo) ? $neonatal_visite_list[0]->BMrNo : '';
		$navigate['main_nav'] = 'op';
		$navigate['sub_nav']  = 'neo';

        $visit_ids = collect($neonatal_visite_list)->pluck('OpId');

        $file_list = FileUpload::getList($visit_ids, 1);

        return view('registration.op_visite_list', compact('visite_list', 'baby_name','navigate', 'file_list', 'baby_id', 'baby_mrn'));

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 */
	public function create($id = 0) 
	{

		$baby_detail          = array();
		$navigate['main_nav'] = 'op';
		$navigate['sub_nav']  = 'neo';		
		$SubmitButtonText     = "Save & Close";
		$SavedhereText        = "Save";
		$drugs                = DrugIvFluidMaster::getOralDrug();
		$Vaccines             = Vaccine::get_lists();
		$medications          = array();
		$growth_chart_weight  = array();
		$neonatal_details     = array(); 
		$id = \SiteHelpers::decrypt_id($id);
		if ($id!=0) {
			$baby_detail_list = Baby::get_data($id);
			$baby_detail      = $baby_detail_list[0];

			if (date('Y', strtotime($baby_detail->DOB)) > 1970) {
				$baby_detail->DOB = date('d-m-Y', strtotime($baby_detail->DOB));
			} else {
				$baby_detail->DOB = '';
			}

			$baby_detail->PartnerDOB = (!is_null($baby_detail->PartnerDOB)) ? date('d-m-Y', strtotime($baby_detail->PartnerDOB)) : '';

			$baby_detail->MotherDOB  = (!is_null($baby_detail->MotherDOB))  ? date('d-m-Y', strtotime($baby_detail->MotherDOB)) : '';

			
            //Get Registered baby & neonatal performa details 
			$neonatal_list                    =  Op::GetBabyNeonatalList($id);
			$baby_detail->BirthWeight         =  isset($neonatal_list->BirthWeight) ? $neonatal_list->BirthWeight : '' ; 
			$baby_detail->HeadCircumference   =  isset($neonatal_list->OFC) ? $neonatal_list->OFC : ''; 
			$baby_detail->MotherBloodGroup    =  isset($baby_detail->MotherBloodGroup) ? $baby_detail->MotherBloodGroup  : '';

            //Get Registered baby & nicu  performa details 
			$nicu_admission  = Op::GetBabyNicuList($id);

			if (isset($nicu_admission->NicuId)) {

				$medications     = Medications::get_medicines_lists($id, 2, $nicu_admission->AdmissionId);
			}

             //get previous op details 
			$previous_op                      = Op::GetPreviousopRecord($id);
			$baby_detail->MotherBloodGroup    = isset($previous_op->mother_blood_group) ? $previous_op->mother_blood_group : $baby_detail->MotherBloodGroup;
			$discharge_summary_backgroud      = DischargeSummary::getSummaryCompleted($id);
			$baby_detail->baby_background     = '';


			$postanatalAdmission              = Postnatal::where('BabyId', $id)->where('IsDeleted', 0)->orderBy('AdmissionId','desc')->first();

			$nicuAdmission              = Nicu::where('BabyId', $id)->where('IsDeleted', 0)->orderBy('AdmissionId','desc')->first();

			if (is_array($discharge_summary_backgroud) && count($discharge_summary_backgroud) > 0) {

				foreach ($discharge_summary_backgroud as $discharge_value) {

					// $baby_detail->baby_background .= strip_tags($discharge_value);	
					$baby_detail->baby_background .= $discharge_value;	

				}

			}
			elseif (count($postanatalAdmission) > 0) {

				$postanatalProblem = PostDaycare::where('BabyId', $postanatalAdmission->BabyId)
				->where('AdmissionId', $postanatalAdmission->AdmissionId)
				->where('IsDeleted', 0)
				->orderBy('AdmissionId','desc')
				->get();
				$differentialdiagnosis = array();

				$temp_differentialdiagnosis = $postanatalProblem->pluck('differentialdiagnosis');
				$temp_additional_diagnosis  = $postanatalProblem->pluck('additional_diagnosis');

				foreach ($temp_differentialdiagnosis as $diagnosiskey => $diagnosisvalue) {
					$differentialdiagnosis[] = json_decode($diagnosisvalue);   
				}

				foreach ($temp_additional_diagnosis as $diagnosiskey => $diagnosisvalue) {
					$additional_diagnosis[] = json_decode($diagnosisvalue);   
				} 

				if(count($differentialdiagnosis) > 0)  {

					$differentialdiagnosis = collect($differentialdiagnosis);
					$differentialdiagnosis = $differentialdiagnosis->collapse()->unique();

					$additional_diagnosis = collect($additional_diagnosis);
					$additional_diagnosis = $additional_diagnosis->collapse()->unique();

					$differentialdiagnosis = Icd::whereIn('ICDCode', $differentialdiagnosis)->get()->pluck('ICDDescription')->toArray();
					$differentialdiagnosis = $additional_diagnosis->merge($differentialdiagnosis)->toArray();

					$baby_detail->baby_background = implode(', ', $differentialdiagnosis);
				}

				$problems     = PostProblemDischargeSummary::getNeonatalProblems($postanatalAdmission->BabyId, $postanatalAdmission->AdmissionId);
				if(count($problems) > 0)  {
					$postProblems = $problems->pluck('problem_name')->unique()->toArray();
					if (!empty($baby_detail->baby_background)) {
						$baby_detail->baby_background .= ', ' . implode(', ', $postProblems);
					} else {
						$baby_detail->baby_background = implode(', ', $postProblems);
					}
				}

			} elseif (count($nicuAdmission) > 0) {

				$nicuProblem = Daycare::where('BabyId', $nicuAdmission->BabyId)
				->where('AdmissionId', $nicuAdmission->AdmissionId)
				->where('IsDeleted', 0)
				->orderBy('AdmissionId','desc')
				->pluck('NicuICD');
				$differentialdiagnosis = array();                            

				foreach ($nicuProblem as $diagnosiskey => $diagnosisvalue) {
					$differentialdiagnosis[] = json_decode($diagnosisvalue);   
				}

				$diagnosis = array();
				if(count($differentialdiagnosis) > 0)  {

					$differentialdiagnosis = collect($differentialdiagnosis);

					foreach ($differentialdiagnosis as $diagnosiskey => $diagnosisvalue) {
						foreach ($diagnosisvalue as $key => $value) {
							$diagnosis = array_merge(Icd::whereIn('ICDCode', $value)->get()->pluck('ICDDescription')->toArray(), $diagnosis) ;
						}
					}
					$baby_detail->baby_background = implode(', ', $diagnosis);
				}

				$problems               = ProblemDischarge::getNeonatalProblems($nicuAdmission->BabyId, $nicuAdmission->AdmissionId);
				if(count($problems) > 0)  {
					$postProblems = $problems->pluck('problem_name')->unique()->toArray();
					if (!empty($baby_detail->baby_background)) {
						$baby_detail->baby_background .= ', ' . implode(', ', $postProblems);
					} else {
						$baby_detail->baby_background = implode(', ', $postProblems);
					}
				}

			} else {

				// $baby_detail->baby_background = strip_tags($baby_detail->Background);
				$baby_detail->baby_background = $baby_detail->Background;
			}

			if (isset($previous_op->OpId) && !empty($previous_op->OpId)) {		

				$medications                      = Medications::where(['BabyId'=>$id, 'AdmissionId'=>0, 'source_id'=>$previous_op->OpId, 'flag'=>3])->get();

				$growth_chart_weight              = isset($previous_op->growth_gestation) ? json_decode($previous_op->growth_gestation) : array();

				$baby_detail->HeadCircumference   = isset($previous_op->HeadCircumference) ? $previous_op->HeadCircumference : ''; 

				$baby_detail->baby_background  = (isset($previous_op->baby_background) && !empty($previous_op->baby_background)) ? $previous_op->baby_background : $baby_detail->baby_background ;
			}
			

			$baby_detail->BirthWeight = (isset($baby_detail->BirthWeight) && !empty($baby_detail->BirthWeight)) ? $baby_detail->BirthWeight : 0;
			$baby_detail->TOB_MINS = isset($baby_detail->TOB_MINS) ? (int)$baby_detail->TOB_MINS : '';

		}
       //gestation update 
		if (isset($baby_detail->Gestation)) {

			if (count((array)json_decode($baby_detail->Gestation)) == 2) {
				$babyGestation = json_decode($baby_detail->Gestation);

				$baby_detail->g_weeks = $babyGestation->g_weeks;
				$baby_detail->g_days  = $babyGestation->g_days; 
			}

		}
		if (isset($baby_detail->HeadCircumference) && $baby_detail->HeadCircumference == '') {
			$performa_details = Neonatal::select('OFC')->where('BabyId', $baby_detail->BabyId)->first();
			$baby_detail->HeadCircumference = isset($performa_details->OFC) ? $performa_details->OFC : 0;
		}


		$auto_complete = AutoCompleteWords::getList();
		$auto_complete = collect($auto_complete);

		$ac_current_status = $auto_complete->where('flag', 1)->pluck('statement')->toArray();  
		$ac_development    = $auto_complete->where('flag', 2)->pluck('statement')->toArray();
		$ac_examination    = $auto_complete->where('flag', 3)->pluck('statement')->toArray();  
		$ac_diagnosis      = $auto_complete->where('flag', 4)->pluck('statement')->toArray();
		$ac_advice         = $auto_complete->where('flag', 5)->pluck('statement')->toArray();


		$vaccine[0]    = 'Select';
		foreach ($Vaccines as $vac) {
			$vaccine[$vac->Id] = $vac->Name;
		}

		$drug_data[0]   = 'Select';
		$drug_strgnth[0] = 'N/A';
		foreach ($drugs as $drug) {
			$drug_data[$drug->Id]    = $drug->Name;
			$drug_strgnth[$drug->Id] = $drug->Value;

		}

        //creating time source 
		$time   = \SiteHelpers::prepare_time();

		$current_date = date('d-m-Y');
		$current_time = [];
		$current_time['hours']  = (int)date("h", strtotime(Carbon::now(env('TIME_ZONE'))));
		$current_time['mins']   = (int)date("i", strtotime(Carbon::now(env('TIME_ZONE'))));
		$current_time['am']     = date("A", strtotime(Carbon::now(env('TIME_ZONE'))));
		$age = (!empty($baby_detail->DOB)) ? (strtotime($current_date) - strtotime($baby_detail->DOB)) / (60 * 60 * 24) : 0;


		/*VACCINE CHART DETAILS START*/
		$baby_vaccine_chart_details = Op::getBabyVaccineChart($id);
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

		$pediatric_today_visit = '';

		if (isset($baby_detail->BabyId)) {
			$pediatric_today_visit = Oppediatric::where('baby_id', $baby_detail->BabyId)->where('op_date', date('Y-m-d'))->orderBy('id', 'desc')->first();
            $previous_eligibility = NeuroController::getPreviousEligibilityDetails($baby_detail->BMrNo);
            $previous_eligibility = collect($previous_eligibility)->toArray();
            $baby_detail = collect($baby_detail)->toArray();
            $baby_detail = array_merge($baby_detail, $previous_eligibility);
            $baby_detail = (object)$baby_detail;
		}

		$current_chart_age = null;
		$current_age = null;

		if (isset($baby_detail->DOB) && isset($baby_detail->g_weeks) && isset($baby_detail->g_days)) {

			$DOB = date('Y-m-d', strtotime($baby_detail->DOB));
			$OpDate = date('Y-m-d');
			$current_age = \SiteHelpers::getChronologicalage($DOB, $OpDate);

			if ($baby_detail->g_weeks < 37 && !empty($baby_detail->g_weeks)) {
				
				$baby_corrected_age = \SiteHelpers::calculateCorrectedGestation($baby_detail->g_weeks, $baby_detail->g_days, $baby_detail->DOB, date('Y-m-d'));

				$current_chart_age = $baby_corrected_age['corrected_age_weeks'] + number_format(($baby_corrected_age['corrected_age_days'] / 7) , 1);
			}	

		}				
		return view('registration.op_create', compact('SubmitButtonText', 'neonatal_list', 'drug_strgnth', 'ac_advice', 'ac_current_status', 'ac_development', 'ac_examination', 'ac_diagnosis', 'medications', 'SavedhereText', 'vaccine', 'time', 'drug_data', 'vaccine', 'navigate', 'baby_detail', 'current_date', 'current_time', 'age', 'id', 'mas_vaccine_chart', 'mas_vaccine_age', 'baby_vaccine_chart', 'user_sign', 'pediatric_today_visit', 'current_age', 'current_chart_age'));
	}

	/**
	 * Store a newly created data.
	 *
	 */
	public function store(OpRequest $request) 
	{
		$input      = $request->all();
		$print_flag = isset($input['print_flag'])?$input['print_flag'] : 0 ;
		unset($input['print_flag']);

		$input['MotherDOB']     = (!is_null($input['MotherDOB']) && !empty($input['MotherDOB'])) ?  date('Y-m-d', strtotime($input['MotherDOB'])) : null;
		$input['PartnerDOB']    = (!is_null($input['PartnerDOB']) && !empty($input['PartnerDOB'])) ?  date('Y-m-d', strtotime($input['PartnerDOB'])) : null;

		$input['DOB']          = date('Y-m-d', strtotime($input['DOB']));
		$input['Review']       = !empty($input['Review']) ? date('Y-m-d', strtotime($input['Review'])) : null;
		$input['OpDate']       = date('Y-m-d', strtotime($input['OpDate']));	

		$input['g_weeks']              = (isset($input['g_weeks']) && $input['g_weeks'] !== "") ? $input['g_weeks'] : 0;
		$input['g_days']               = (isset($input['g_days'])  && $input['g_days'] !== "") ? $input['g_days']   : 0;     

		$input['TOB_TIME']             = (isset($input['TOB_TIME']) && !empty($input['TOB_TIME']) && $input['TOB_TIME'] !== " ") ? $input['TOB_TIME'] : 00; 
		$input['TOB_MINS']             = (isset($input['TOB_MINS']) && !empty($input['TOB_MINS']) && $input['TOB_MINS'] !== " ") ? $input['TOB_MINS'] : 00;


		$input['chronological_days']   = (!empty($input['chronological_days']))   ?  $input['chronological_days']  : null;
		$input['chronological_month']  = (!empty($input['chronological_month']))  ?  $input['chronological_month'] : null;
		$input['chronological_weeks']  = (!empty($input['chronological_weeks']))  ?  $input['chronological_weeks'] : null;
		$input['chronological_year']   = (!empty($input['chronological_year']))   ?  $input['chronological_year']  : null;

		$input['corrected_days']       = (!empty($input['corrected_days']))   ?  $input['corrected_days']  : null;
		$input['corrected_month']      = (!empty($input['corrected_month']))  ?  $input['corrected_month'] : null;
		$input['corrected_weeks']      = (!empty($input['corrected_weeks']))  ?  $input['corrected_weeks'] : null;
		$input['corrected_year']       = (!empty($input['corrected_year']))   ?  $input['corrected_year']  : null;

		$input['total_chronological_weeks'] = (!empty($input['total_chronological_weeks'])) ? $input['total_chronological_weeks'] : null;
		$input['total_chronological_days']  = (!empty($input['total_chronological_days']))  ? $input['total_chronological_days'] : null;   
		$input['total_corrected_weeks']     = (!empty($input['total_corrected_weeks']))     ? $input['total_corrected_weeks'] : null;
		$input['total_corrected_days']      = (!empty($input['total_corrected_days']))      ? $input['total_corrected_days'] : null;


		$input['HeadCircumference']    = (!empty($input['HeadCircumference'])) ? $input['HeadCircumference'] : null;
		$input['CurrentWt']            = (!empty($input['CurrentWt'])) ? $input['CurrentWt'] : null;
		$input['CurrentOFC']           = (!empty($input['CurrentOFC'])) ? $input['CurrentOFC'] : null; 
		$input['CurrentLength']        = (!empty($input['CurrentLength'])) ? $input['CurrentLength'] : null;

		$input['neurosonogram']         = isset($input['neurosonogram'])  ? 2 : 1 ;
		$input['echocardiogram']        = isset($input['echocardiogram']) ? 2 : 1 ;
		$input['fee_status']            = isset($input['fee_status']) ? 1 : 0;
		$input['fee_amount']            = (isset($input['fee_amount']) && !empty(trim($input['fee_amount']))) ? $input['fee_amount'] : null;

		$input['Vaccine']           = (isset($input['Vaccine'])) ? json_encode($input['Vaccine']) : json_encode(array());  

		$input['Gestation']         = json_encode(['g_weeks'=>$input['g_weeks'], 'g_days'=>$input['g_days']]);

		$input['need_neuro']            = isset($input['need_neuro']) ? 1 : 0;

		$input['IsDeleted']         = 0;

		if (isset($input['MotherId']) && $input['MotherId'] != '' && $input['MotherId'] != 0) {

			$input['UserModified']	= $this->auth->user()->id; 	
			$input['DateModified']  = Carbon::now();        
			$mother                 = Mother::findOrfail($input['MotherId']);
			$mother->update($input);

		} else {

			$input['DateAdded'] = Carbon::now();	
			$input['UserAdded']	= $this->auth->user()->id; 	
			$mother             = Mother::create($input);
			$input['MotherId']  = $mother->MotherId;		

		}		

		if (isset($input['BabyId']) && $input['BabyId'] != '' && $input['BabyId'] != 0) {

			$input['UserModified']	= $this->auth->user()->id; 	
			$input['DateModified']  = Carbon::now();  	
			$baby                   = Baby::findOrfail($input['BabyId']);
			$baby->update($input);

		} else {

			$input['DOB'] = (isset($input['DOB']) && !empty($input['DOB'])) ? date('Y-m-d', strtotime($input['DOB'])) : null;
			$input['DateAdded'] = Carbon::now();	
			$input['UserAdded']	= $this->auth->user()->id; 	
			$baby               = Baby::create($input);
			$input['BabyId'] = $baby->BabyId;	

		}	

		$this->storeVaccineChart($input['vaccine_chart_input'], $input['BabyId']);
        //set number of visite 
		$old_op_visite_count = Op::where(['BabyId'=>$input['BabyId'], 'IsDeleted'=>0])->count();

		$old_op_visite_count = 1 + $old_op_visite_count;

		if (strlen($old_op_visite_count) == 1) {

			$old_op_visite_count = '00'.$old_op_visite_count;

		} elseif (strlen($old_op_visite_count) == 2) {

			$old_op_visite_count = '0'.$old_op_visite_count;

		}

		$input['op_visite'] = 'Visit-'.$old_op_visite_count;

		$input['DateAdded'] = Carbon::now();
		$input['UserAdded']	= $this->auth->user()->id; 	
		$op = Op::create($input);

		$this->storeEligibility($input, $op->OpId, $input['BabyId'], $input['OpDate']);

		$this->makeAppointment($input, $op->OpId);

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
					'flag'          => 3,								
					'AdmissionId'	=> 0,
					'BabyId'     	=> $input['BabyId'],
					'source_id'     => $op->OpId,
					'standard_dose' => $standard_dose[$input['M_Drugs'][$key]] > 1 ? 1 : 0

				);
				Medications::create($discharge_medications);
			}

		}

		if ($request->ajax()) {
			return \Response::json(['type' => 'success', 'message' => 'Postnatal daycare details created successfully !', 'edit_url' => action('Registration\OpController@edit', \SiteHelpers::encrypt_id($op->OpId)), 'list_url' => action('Registration\OpController@index'), 'print_url'=>action('Registration\OpController@show', \SiteHelpers::encrypt_id($op->OpId)), 'neuro_print_url'=>action('Registration\OpController@printNeuroDevelopmentReport', \SiteHelpers::encrypt_id($op->OpId))], 200);
		}

		if ($print_flag == 1) {
			return redirect(action('Registration\OpController@index'))->with('Success', 'Record saved successfully !');
		} elseif ($print_flag == 2) {

			$op_next = isset($_COOKIE['op-next']) ?  $_COOKIE['op-next'] : '';
			$this->flow->flowlog('OP_REG', $input['BabyId'], $input['MotherId'], null, false, $op_next,$op->OpId);

			return redirect(action('Registration\OpController@edit', \SiteHelpers::encrypt_id($op->OpId)))->with('Success', 'Record saved successfully !');
		} elseif ($print_flag == 3) {
			return redirect(action('Registration\OpController@show', \SiteHelpers::encrypt_id($op->OpId)))->with('Success', 'Record saved successfully !');
		} elseif ($print_flag == 4) {
			return redirect(action('Registration\OpController@printNeuroDevelopmentReport', \SiteHelpers::encrypt_id($op->OpId)))->with('Success', 'Record saved successfully !');
		} elseif ($print_flag == 5) {
			return redirect(action('Growthchart\GrowthChartController@growthwhochartzerotofiveyears', \SiteHelpers::encrypt_id($input['BabyId'])));
		} elseif ($print_flag == 6) {
			return redirect(action('Growthchart\GrowthChartController@GenearateGrowthChart', \SiteHelpers::encrypt_id($input['BabyId'])));
		} else {
			return redirect(action('Registration\OpController@index'))->with('Success', 'Record saved successfully !');
		} 
	}

	/**
	 * PRINT DISPLAY
	 *
	 * @param  int  $id
	 */
	public function show($id, Request $request) 
	{
		$id = \SiteHelpers::decrypt_id($id);

		$result = Op::get_oprecord($id);
		$results = $result[0];
		$headerContent = Settings::findorfail(1);
		$editor_gen_option = false;

		$drugs                = DrugIvFluidMaster::getOralDrug();
		$Vaccines             = Vaccine::get_lists();

		$drug_data[0] = 'Select';

		foreach ($drugs as $drug) {

			$drug_data[$drug->Id] = $drug->Name . '/' . $drug->generic_name;

		}

		$vaccine[0] = 'Select';
		foreach ($Vaccines as $vac) {
			$vaccine[$vac->Id] = $vac->Name;
		}

		if ($request->get('closewinlink') == 'neuro-op-list-view') {
			$closewinlink = action('Registration\NeuroController@NeuroSubList', \SiteHelpers::encrypt_id($results->BabyId));
		} else {
			$closewinlink = action('Registration\OpController@OpsubList', \SiteHelpers::encrypt_id($results->BabyId));			
		}
		
		$results->Vaccine   = json_decode($results->Vaccine);
		$medications        = Medications::select('discharge_medications.*', 'mas_drugivfluid.value as Value')
		->join('mas_drugivfluid', 'mas_drugivfluid.id', '=', 'discharge_medications.Medication')
		->where(['discharge_medications.BabyId'=>$results->BabyId,'discharge_medications.AdmissionId'=>0,'discharge_medications.source_id'=>$id,'discharge_medications.flag'=>3])
		->orderBy('discharge_medications.Id', 'asc')
		->get();
		$results->Gestation = \SiteHelpers::decode_gestation($results->Gestation);

		$results->review_time = strlen($results->review_time) == 1 ? '0'.$results->review_time : $results->review_time ;
		$results->review_min  = strlen($results->review_min) == 1 ? '0'.$results->review_min : $results->review_min ;
		$doctors = \ValuelistHelpers::mas_doctors_list();

		if ($request->ajax()) {

			$op_report = view('registration.op_print', compact('results', 'medications', 'headerContent', 'vaccine', 'drug_data', 'closewinlink','doctors'))->render();
			return \Response::json(['op_report'=>$op_report, 'babyName'=>$results->BabyName.' - '.$results->BMrNo], 200);
		}

		$editor_gen_option = $results->edited_content == NULL ? 1 : 0;
		$editor_gen = false;
		if (\Session::has('op-editor'))
		{
			\Session::forget('op-editor');

			$editor_gen = true;
			return view('registration.op_print', compact('results', 'medications', 'headerContent', 'vaccine', 'drug_data', 'closewinlink','doctors','editor_gen', 'editor_gen_option'))->renderSections();
		}

		$current_user = $this->auth->user()->id;
		$current_ip = \Request::ip();

		$user_config = $page_config = OpPrintPageConfig::getUserConfigProperty($current_user);

		$ip_config = OpPrintPageConfig::getIpConfigProperty($current_ip);

		if (!(count($user_config) > 0)) {
			$page_config = $ip_config;
		}

		return view('registration.op_print', compact('results', 'medications', 'headerContent', 'vaccine', 'drug_data', 'closewinlink','doctors', 'editor_gen_option', 'page_config', 'user_config', 'ip_config'));
	}
	/* SELECT BABY FORM TO SELECT THE EXISTING BABY FOR REPEATED VISIT. 
	   OR SELECT CREATE NEW OPTION TO CREATE A NEW BABY RECORD
	
	*/
	   public function chooseBaby() 
	   {

	   	$navigate['main_nav'] = 'registration';
	   	$navigate['sub_nav']  = 'neo';		
	   	$baby                 = Baby::baby_list_op();
        $babies = \ValuelistHelpers::select2DataFormater($baby, true);

	   	$SubmitButtonText  = "Start";

	   	return view('registration.select_patient', compact('SubmitButtonText', 'babies', 'navigate'));	
	   }
	/**
	 * Show the form for editing.
	 *
	 * @param  int  $id
	 */
	public function edit($id, $search_data='') 
	{
		$id = \SiteHelpers::decrypt_id($id);

		$navigate['main_nav'] = 'op';
		$navigate['sub_nav']  = 'neo';
		$result = Op::get_oprecord($id);	

		$results = $result[0];
		if (date('Y', strtotime($results->DOB)) > 1980)
			$results->DOB = date('d-m-Y', strtotime($results->DOB));
		else
			$results->DOB = '';

		if (date('Y', strtotime($results->OpDate)) > 1980)
			$results->OpDate = date('d-m-Y', strtotime($results->OpDate));
		else
			$results->OpDate = '';

		$results->PartnerDOB = (!is_null($results->PartnerDOB)) ? date('d-m-Y', strtotime($results->PartnerDOB)) : '';	
		$results->MotherDOB  = (!is_null($results->MotherDOB)) ?  date('d-m-Y', strtotime($results->MotherDOB)) : '';	
		
		if (date('Y', strtotime($results->Review)) > 1980)
			$results->Review = date('d-m-Y', strtotime($results->Review));
		else
			$results->Review = '';		

		$medications = Medications::where(['BabyId'=>$results->BabyId, 'AdmissionId'=>0, 'flag'=>3, 'source_id'=>$id])->orderBy('Id', 'asc')->get();
		
		$drugs     =  DrugIvFluidMaster::getOralDrug();
		$Vaccines  =  Vaccine::get_lists();
		$vaccine[0] = 'N/A';
		foreach ($Vaccines as $vac) {
			$vaccine[$vac->Id] = $vac->Name;
		}
		$drug_data[0]   = 'N/A';
		$drug_strgnth[0] = 'N/A';
		foreach ($drugs as $drug) {
			$drug_data[$drug->Id]    = $drug->Name;
			$drug_strgnth[$drug->Id] = $drug->Value;

		}

		$time   = \SiteHelpers::prepare_time();

		if ($id!=0) {
			$baby_detail1 = Baby::get_data($results->BabyId);
			$baby_detail = $baby_detail1[0];
		} else { 
			$baby_detail = array();
		}	

		$SubmitButtonText = "Update & Close";
		$SavedhereText = 'Update';

		$results->Vaccine = json_decode($results->Vaccine);

		$auto_complete = AutoCompleteWords::getList();
		$auto_complete = collect($auto_complete);
		// foreach ($auto_complete as $key => $value) {
		// 	if($value->flag ==1) {
		// 		$test[]=$value->flag;
		// 	}
		// }


		$ac_current_status = $auto_complete->where('flag', 1)->pluck('statement')->toArray();  
		$ac_development    = $auto_complete->where('flag', 2)->pluck('statement')->toArray();
		$ac_examination    = $auto_complete->where('flag', 3)->pluck('statement')->toArray();  
		$ac_diagnosis      = $auto_complete->where('flag', 4)->pluck('statement')->toArray();
		$ac_advice         = $auto_complete->where('flag', 5)->pluck('statement')->toArray();

		if (isset($results->Gestation) && count(json_decode($results->Gestation)) > 0) {
			$gestation_op     = json_decode($results->Gestation);
			$results->g_weeks = isset($results->g_weeks) ? $results->g_weeks : '';
			$results->g_days  = isset($results->g_days) ? $results->g_days : '';
		}

		/*VACCINE CHART DETAILS START*/
		$baby_vaccine_chart_details = Op::getBabyVaccineChart($results->BabyId);
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
		$DOB = date('Y-m-d', strtotime($results->DOB));
		$OpDate = date('Y-m-d', strtotime($results->OpDate));
		$current_age = \SiteHelpers::getChronologicalage($DOB, $OpDate);

		$current_chart_age = 0;
		if ($results->g_weeks < 37 && !empty($results->g_weeks)) {
			
			$baby_corrected_age = \SiteHelpers::calculateCorrectedGestation($results->g_weeks, $results->g_days, $results->DOB, $results->OpDate);

			$current_chart_age = $baby_corrected_age['corrected_age_weeks'] + number_format(($baby_corrected_age['corrected_age_days'] / 7) , 1);
		}					

		if (isset($results->BabyId)) {
			$pediatric_today_visit = Oppediatric::where('baby_id', $results->BabyId)->where('op_date', date('Y-m-d'))->orderBy('id', 'desc')->first();
		}

		$result = (array)$results;
		$neuro_eligibility_result = (array)NeuroEligibility::getNeuroEligibilityData($id);

		$results = (object)array_merge($result, $neuro_eligibility_result);

        $navigation_ids = $this->getPrevNextIds($results->BabyId, $id);	

        $prev_id = isset($navigation_ids['prev_id']) ? $navigation_ids['prev_id'] : null;
        $next_id = isset($navigation_ids['next_id']) ? $navigation_ids['next_id'] : null;

		return view('registration.op_edit', compact('results', 'drug_strgnth', 'SubmitButtonText', 'ac_current_status', 'ac_development', 'ac_examination', 'ac_examination', 'ac_diagnosis', 'ac_advice', 'time', 'vaccine', 'SavedhereText', 'medications', 'drug_data', 'vaccine', 'search_data', 'navigate', 'tob', 'baby_detail', 'current_chart_age','mas_vaccine_chart', 'mas_vaccine_age', 'baby_vaccine_chart', 'user_sign', 'current_age', 'pediatric_today_visit', 'id', 'prev_id', 'next_id'))->with('Success', 'Record updated successfully !');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @redirect listing page
	 */
	public function update($id, OpRequest $request)
	{

		$input = $request->all();
		$print_flag = isset($input['print_flag'])?$input['print_flag']:0;
		unset($input['print_flag']);
		$this->storeVaccineChart($input['vaccine_chart_input'], $input['BabyId']);
		$input['MotherDOB']     = (!is_null($input['MotherDOB']) && !empty($input['MotherDOB'])) ?  date('Y-m-d', strtotime($input['MotherDOB'])) : null;
		$input['PartnerDOB']    = (!is_null($input['PartnerDOB']) && !empty($input['PartnerDOB'])) ?  date('Y-m-d', strtotime($input['PartnerDOB'])) : null;

		$input['DOB']          = date('Y-m-d', strtotime($input['DOB']));
		$input['OpDate']       = date('Y-m-d', strtotime($input['OpDate']));
		$input['Review']       = !empty($input['Review']) ? date('Y-m-d', strtotime($input['Review'])) : null;
		$input['DateModified'] = Carbon::now(env('TIME_ZONE'));
		$input['UserModified'] = $this->auth->user()->id;

		$input['g_weeks']           = (isset($input['g_weeks']) && $input['g_weeks'] !== "") ? $input['g_weeks'] : 0;
		$input['g_days']            = (isset($input['g_days'])  && $input['g_days'] !== "") ? $input['g_days']   : 0;     
		$input['TOB_TIME']          = (isset($input['TOB_TIME']) && $input['TOB_TIME'] !== "") ? $input['TOB_TIME'] : null; 
		$input['TOB_MINS']          = (isset($input['TOB_MINS']) && $input['TOB_MINS'] != '') ? $input['TOB_MINS'] : null;
		$input['Gestation']         = json_encode(['g_weeks'=>$input['g_weeks'],'g_days'=>$input['g_days']]);


		$input['chronological_days']   = (!empty($input['chronological_days']))   ?  $input['chronological_days']  : null;
		$input['chronological_month']  = (!empty($input['chronological_month']))  ?  $input['chronological_month'] : null;
		$input['chronological_weeks']  = (!empty($input['chronological_weeks']))  ?  $input['chronological_weeks'] : null;
		$input['chronological_year']   = (!empty($input['chronological_year']))   ?  $input['chronological_year']  : null;

		$input['corrected_days']       = (!empty($input['corrected_days']))   ?  $input['corrected_days']  : null;
		$input['corrected_month']      = (!empty($input['corrected_month']))  ?  $input['corrected_month'] : null;
		$input['corrected_weeks']      = (!empty($input['corrected_weeks']))  ?  $input['corrected_weeks'] : null;
		$input['corrected_year']       = (!empty($input['corrected_year']))   ?  $input['corrected_year']  : null;
		
		$input['HeadCircumference']    = (!empty($input['HeadCircumference'])) ? $input['HeadCircumference'] : null;
		$input['CurrentWt']            = (!empty($input['CurrentWt'])) ? $input['CurrentWt'] : null;
		$input['CurrentOFC']           = (!empty($input['CurrentOFC'])) ? $input['CurrentOFC'] : null; 
		$input['CurrentLength']        = (!empty($input['CurrentLength'])) ? $input['CurrentLength'] : null;
		
		$input['total_chronological_weeks'] = (!empty($input['total_chronological_weeks'])) ? $input['total_chronological_weeks'] : null;
		$input['total_chronological_days']  = (!empty($input['total_chronological_days']))  ? $input['total_chronological_days'] : null;   
		$input['total_corrected_weeks']     = (!empty($input['total_corrected_weeks']))     ? $input['total_corrected_weeks'] : null;
		$input['total_corrected_days']      = (!empty($input['total_corrected_days']))      ? $input['total_corrected_days'] : null;

		$input['neurosonogram']         = isset($input['neurosonogram'])  ? 2 : 1 ;
		$input['echocardiogram']        = isset($input['echocardiogram']) ? 2 : 1 ;
		$input['fee_status']            = isset($input['fee_status']) ? 1 : 0;
		$input['fee_amount']            = (isset($input['fee_amount']) && !empty(trim($input['fee_amount']))) ? $input['fee_amount'] : null;

		$input['need_neuro']            = isset($input['need_neuro']) ? 1 : 0;

		$this->makeAppointment($input, $id);

		$input['Vaccine']           = (isset($input['Vaccine'])) ? json_encode($input['Vaccine']) : json_encode(array());  

		$results3 = Baby::findOrfail($input['BabyId']);


		$results3->update($input);
		
		$results1 = Op::findOrfail($id);

		$growth_chart = null;

		if (isset($input['chart_gestation'])) {

			foreach ($input['chart_gestation'] as $key => $value) {

				if (!empty($input['chart_gestation'][$key])) {

					$growth_chart[] = array('chart_gestation' => $input['chart_gestation'][$key],
						'chart_date'      => $input['chart_date'][$key],
						'chart_weigth'    => $input['chart_weigth'][$key]);			  
				}

			}
		}

		//$input['growth_gestation'] = json_encode($growth_chart);

		$results1->update($input);

		$results2 = Mother::findOrfail($input['MotherId']);
		
		$results2->update($input);

		$medication_old_list = Medications::where(['BabyId'=>$input['BabyId'], 'AdmissionId'=>0, 'flag'=>3, 'source_id'=>$id])->orderBy('Id', 'asc')->get();
		$medication_old_list = collect($medication_old_list)->pluck('Id');

		foreach ($medication_old_list as $key => $value) {

			if (isset($input['M_Drugs']) && isset($input['M_Drugs'][$value])) {
				$discharge_medications = array(
					'Medication'	=> (isset($input['M_Drugs'][$value]) && !empty($input['M_Drugs'][$value])) ? $input['M_Drugs'][$value] : null,
					'genericname'   => (isset($input['m_generic_name'][$value]) && !empty($input['m_generic_name'][$value])) ? $input['m_generic_name'][$value] : null,
					'formulation'   => (isset($input['formulation'][$value]) && !empty($input['formulation'][$value])) ? $input['formulation'][$value] : null,
					'route'         => (isset($input['M_Route'][$value]) && !empty($input['M_Route'][$value])) ? $input['M_Route'][$value] : null,
					'Dose'          => (isset($input['M_Dose'][$value]) && !empty($input['M_Dose'][$value])) ? $input['M_Dose'][$value] : null,
					'Frequency'     => (isset($input['M_Frequency'][$value]) && !empty($input['M_Frequency'][$value])) ? $input['M_Frequency'][$value] : null,
					'Duration'      => (isset($input['M_Duration'][$value]) && !empty($input['M_Duration'][$value])) ? $input['M_Duration'][$value] : null
				);
				
				Medications::where('Id', $value)->update($discharge_medications);
				unset($input['M_Drugs'][$value]);
				unset($input['m_generic_name'][$value]);
				unset($input['formulation'][$value]);
				unset($input['M_Route'][$value]);
				unset($input['M_Dose'][$value]);
				unset($input['M_Frequency'][$value]);
				unset($input['M_Duration'][$value]);
				unset($medication_old_list[$key]);
			}
		}

		Medications::whereIn('Id', $medication_old_list)->delete();
		$medication_id = [];

		if (isset($input['M_Drugs']) && is_array($input['M_Drugs']) && count($input['M_Drugs']) > 0) {

			$standard_dose = array_count_values($input['M_Drugs']);

			foreach ($input['M_Drugs'] as $key => $value) {

				$discharge_medications = array(
					'Medication'	=> (isset($input['M_Drugs'][$key]) && !empty($input['M_Drugs'][$key])) ? $input['M_Drugs'][$key] : null,
					'genericname'   => (isset($input['m_generic_name'][$key]) && !empty($input['m_generic_name'][$key])) ? $input['m_generic_name'][$key] : null,
					'formulation'   => (isset($input['formulation'][$key]) && !empty($input['formulation'][$key])) ? $input['formulation'][$key] : null,
					'route'         => (isset($input['M_Route'][$key]) && !empty($input['M_Route'][$key])) ? $input['M_Route'][$key] : null,
					'Dose'          => (isset($input['M_Dose'][$key]) && !empty($input['M_Dose'][$key])) ? $input['M_Dose'][$key] : null,
					'Frequency'     => (isset($input['M_Frequency'][$key]) && !empty($input['M_Frequency'][$key])) ? $input['M_Frequency'][$key] : null,
					'Duration'      => (isset($input['M_Duration'][$key]) && !empty($input['M_Duration'][$key])) ? $input['M_Duration'][$key] : null,
					'flag'          => 3,								
					'AdmissionId'	=> 0,
					'BabyId'     	=> $input['BabyId'],
					'source_id'     => $id,
					'standard_dose' => $standard_dose[$input['M_Drugs'][$key]] > 1 ? 1 : 0

				);
				$medication_id[$key] = Medications::create($discharge_medications)->Id;
			}

		}	
		$this->storeEligibility($input, $id, $input['BabyId'], $input['Review']);

		if ($request->ajax()) {
			return \Response::json(['type' => 'success', 'message' => 'Postnatal daycare details created successfully !', 'edit_url' => action('Registration\OpController@edit', \SiteHelpers::encrypt_id($id)), 'list_url' => action('Registration\OpController@index'), 'print_url'=>action('Registration\OpController@show', \SiteHelpers::encrypt_id($id)), 'neuro_print_url'=>action('Registration\OpController@printNeuroDevelopmentReport', \SiteHelpers::encrypt_id($id)), 'medication_id'=>$medication_id], 200);
		}

		if ($print_flag == 1) {
			return redirect(action('Registration\OpController@index'))->with('Success', 'Record updated successfully !');
		} elseif ($print_flag == 2) {
			$op_next = isset($_COOKIE['op-next']) ?  $_COOKIE['op-next'] : '';
			$this->flow->flowlog('OP_REG', $input['BabyId'], $input['MotherId'], null, false, $op_next);
			return redirect(action('Registration\OpController@edit', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully !');
		} elseif ($print_flag == 3) {
			return redirect(action('Registration\OpController@show', \SiteHelpers::encrypt_id($id)));
		} elseif ($print_flag == 4) {
			return redirect(action('Registration\OpController@printNeuroDevelopmentReport', \SiteHelpers::encrypt_id($op->OpId)))->with('Success', 'Record saved successfully !');
		} elseif ($print_flag == 5) {
			return redirect(action('Growthchart\GrowthChartController@growthwhochartzerotofiveyears', \SiteHelpers::encrypt_id($input['BabyId'])));
		} elseif ($print_flag == 6) {
			return redirect(action('Growthchart\GrowthChartController@GenearateGrowthChart', \SiteHelpers::encrypt_id($input['BabyId'])));
		} else {

			$this->flow->flowlog('OP_REG', $input['BabyId'], $input['MotherId'], null, true);
			(\Session::has('registration_start')) ? \Session::forget('registration_start') : '';
			(\Session::has('admission_module'))   ? \Session::forget('admission_module')   : '';
			(\Session::has('current_module'))     ? \Session::forget('current_module')     : '';
			(\Session::has('ficd'))  ? \Session::forget('ficd') : '';

			isset($_COOKIE['op-next']) ? setcookie("op-next", "", time() - 3600) : '';
			return redirect(action('Registration\OpController@index'))->with('Success', 'Record updated successfully !');
		} 
	}

	/**
	 * UPDATE THE RECORD AS DELETED AND CREATE THE APPROVAL REQUEST
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		$results = Op::findOrfail($id);

		$user_detail = array(
			'UserDeleted'	=> $this->auth->user()->id,
			'DateModified'	=> Carbon::now(),
			'IsDeleted'		=> '1'
		);
		$results->update($user_detail);
		$result = Op::get_oprecord($id);
		$op_res = $result[0];
		$delete_data = array(
			'Name'		  	   => $op_res->BabyName,
			'AdmissionDate'	   => $results['OpDate'],
			'ModuleController' => 'Registration\OpController',
			'ModuleId'		   => $id,
			'ModuleName'	   => 'OP Registration',
			'UserDeleted'	   => $this->auth->user()->id,
			'DateDeleted'	   => Carbon::now()
		);
		DeleteApproval::create($delete_data);

		return redirect(action('Registration\OpController@index'))->with('info', 'Record deleted successfully !');
	}
	/*
		RETRIEVE THE DATA FOR VIEW POPUP
	*/
		public function getData($id)
		{
			$result = Op::get_oprecord($id);
			$results = (array)$result[0];

			$results['DOB']    = (date('Y', strtotime($results['DOB'])) > 1980) ? date('d-m-Y', strtotime($results['DOB'])) : '' ;
			$results['OpDate'] = (date('Y', strtotime($results['OpDate'])) > 1980) ? date('d-m-Y', strtotime($results['OpDate'])) : '' ;

			$results['TOB']       = date('h:i a', strtotime($results['TOB']));
			$results['OpTime']    = date('h:i a', strtotime($results['OpTime']));			
			$results['Gestation'] = \SiteHelpers::decode_gestation($results['Gestation']);	

			return json_encode($results);
		}

	/*
		RETRIEVE THE DATA FOR SEARCH FILTER 
	*/	
		public function searchData(Request $request)
		{
			$data = $request->get('data1');
			$results = Op::GetSearchDatas($data);
			return json_encode($results);
		}

	/*
		RETRIEVE THE DATA FOR SEARCH FILTER 
	*/	
		public function getReviewDate($days) 
		{
			$date = Carbon::now(env('TIME_ZONE'));
			$next_review = $date->addDays($days)->format('D');

			if ($next_review == 'Sun') {

				$next_review =  $date->addDays(1)->format('d-m-Y'); 
			} else {
				$next_review =  $date->format('d-m-Y'); 
			}

			return \Response::json(['next_review'=>$next_review]);

		}


		public function getoplisner() 
		{

			// set some variables 
			$host = '127.0.0.1'; 
			$port = 5000; 

		// don't timeout! 
			set_time_limit(0); 

		// create socket 
			$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n"); 

		// bind socket to port 
			$result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n"); 

		// start listening for connections 
			$result = socket_listen($socket, 3) or die("Could not set up socket listener\n"); 

		// accept incoming connections 
		// spawn another socket to handle communication 
		// $client = socket_accept($socket) or die("Could not accept incoming connection\n"); 

			do {
				if (($msgsock = socket_accept($socket)) === false) {
					echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
					break;
				}
				/* Send instructions. */
				$msg = "\nWelcome to the PHP Test Server. \n" .
				"To quit, type 'quit'. To shut down the server type 'shutdown'.\n";
				socket_write($msgsock, $msg, strlen($msg));

				do {
					if (false === ($buf = socket_read($msgsock, 2048, PHP_NORMAL_READ))) {
						echo "socket_read() failed: reason: " . socket_strerror(socket_last_error($msgsock)) . "\n";
						break 2;
					}
					if (!$buf = trim($buf)) {
						continue;
					}
					if ($buf == 'quit') {
						break;
					}
					if ($buf == 'shutdown') {
						socket_close($msgsock);
						break 2;
					}
					$talkback = "PHP: You said '$buf'.\n";
					socket_write($msgsock, $talkback, strlen($talkback));
					echo "$buf\n";
				} while (true);
				socket_close($msgsock);
			} while (true);

  //       //display information about the client who is connected
  //       if (socket_getpeername($client, $address, $port)) {
  //           //Fetch  the output from client
  //           $input =socket_read($client, 1024000);
  //           $response = $message;
  //           // Display output  back to client
  //           socket_write($client, $response);
  //           socket_close($client); 
  //           socket_close($sockreceive);
  //       }    

		// // read client input 
		// $input = socket_read($spawn, 1024) or die("Could not read input\n"); 

		// // clean up input string 
		// $input = trim($input); 

		// // echo input back 
		// $output = $input . "\n"; 
		// socket_write($spawn, $output, strlen ($output)) or die("Could not write output\n"); 

		// // close sockets 
		// //socket_close($spawn); 


		}    

    /**
     * OPEN REPORT WITH FULL EDITOR
     *
     */
    public function getfullEditor(Request $request)
    {
    	$input = $request->all();
    	\Session::put('op-editor', true);
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

    	$op = Op::findOrfail($input['op_id']);

    	$op->update(['edited' => true, 'edited_content' => $input['op_report'], 'edited_time' => Carbon::now($this->time_zone) ]);

        // create slug for updated
    	$op_id = $input['op_id'];

    	if ($request->ajax()) {
    		return \Response::json(['type'=>'success','msg' => 'Record updated successfully']);
    	} else {
    		return redirect(action('Registration\OpController@getAbbreviatedsummaryShow', $op_id))->with('success', 'Record updated successfully');
    	}

    }

    public function getAbbreviatedsummaryShow(Request $request, $id)
    {
    	$id_list = $id;

    	$dischargeSummarymodified = array();

    	if (isset($id_list) && !empty($id_list))
    	{
    		$dischage_summary['op_id'] = $nicu_id = $id_list;
    	}
    	else
    	{
    		return redirect(url('/'))->with('error', 'Invalid record');
    	}

    	$op = Op::findOrfail($id_list);

        // $completed = false;

    	\Session::put('op-editor', true);

    	if (count($op) > 0 && !empty($op['edited_content'])) {
    		$discharge_details['content'] = $op['edited_content'];
            // $completed = $op['edited'];
    	} else {        	
    		$discharge_details = $this->show($id, $request);
    	}

    	return view('registration.op_editor', compact('discharge_details', 'dischargeSummarymodified', 'dischage_summary'));
    }

    public function barcode()
    {
    	return view('registration.check_bar_code');
    }

    public function storeVaccineChart($vaccine_chart_input, $baby_id)
    {
    	
    	$check_vaccine_chart = Op::getBabyVaccineChart($baby_id);
    	
    	/*If baby has no vaccine chart yet*/
    	foreach ($vaccine_chart_input['age_id'] as $chart_key => $chart_value) {
    		$vaccine_medicine_details = array();
    		if (isset($vaccine_chart_input['vaccine_brand_name'][$chart_key]) && isset($vaccine_chart_input['vaccine_barcode'][$chart_key])) {
    			foreach ($vaccine_chart_input['vaccine_brand_name'][$chart_key] as $vaccine_chart_key => $vaccine_value) {
    				$vaccine_medicine_details['vaccine'] = $vaccine_chart_input['vaccine_brand_name'][$chart_key];
    				$vaccine_medicine_details['bar_code'] = $vaccine_chart_input['vaccine_barcode'][$chart_key];
    			}
    		}
    		if (isset($vaccine_chart_input['user_given'][$chart_key]) && !empty($vaccine_chart_input['user_given'][$chart_key]) && $vaccine_chart_input['user_given'][$chart_key] != 0) {
    			$user_given = $vaccine_chart_input['user_given'][$chart_key];
    		}
    		elseif(isset($vaccine_chart_input['is_given'][$chart_key]) && !empty($vaccine_chart_input['is_given'][$chart_key]))
    		{
    			$user_given = $this->auth->user()->id;
    		}
    		else
    		{
    			$user_given = 0;	
    		}

    		$vaccine_details[] = array(
    			'age_id' => $chart_value,
    			'vaccine_generic_id' => $chart_key,
    			'baby_id' => $baby_id,
    			'age_sort_order' => isset($vaccine_chart_input['age_sort_order'][$chart_key]) && !empty($vaccine_chart_input['age_sort_order'][$chart_key]) ? $vaccine_chart_input['age_sort_order'][$chart_key] : '',
    			'vaccine_sort_order' => isset($vaccine_chart_input['vaccine_sort_order'][$chart_key]) && !empty($vaccine_chart_input['vaccine_sort_order'][$chart_key]) ? $vaccine_chart_input['vaccine_sort_order'][$chart_key]: '',
    			'date_due' => isset($vaccine_chart_input['date_due'][$chart_key]) && !empty($vaccine_chart_input['date_due'][$chart_key]) ? date('Y-m-d', strtotime($vaccine_chart_input['date_due'][$chart_key])) : null,
    			'date_given' => isset($vaccine_chart_input['date_given'][$chart_key]) && !empty($vaccine_chart_input['date_given'][$chart_key]) ? date('Y-m-d', strtotime($vaccine_chart_input['date_given'][$chart_key])) : null,
    			'is_given' => isset($vaccine_chart_input['is_given'][$chart_key]) && !empty($vaccine_chart_input['is_given'][$chart_key]) ? true : false,
    			'vaccine_details' => json_encode($vaccine_medicine_details),
    			'user_given' =>  $user_given,
    			'user_added' => $this->auth->user()->id,
    			'date_added' => date('Y-m-d H:i:s'),
    			'comments' => isset($vaccine_chart_input['comments'][$chart_value]) && !empty($vaccine_chart_input['comments'][$chart_value]) ? $vaccine_chart_input['comments'][$chart_value] : '',
    		);

    	}
    	if (count($check_vaccine_chart) == 0) {
    		\DB::table('baby_vaccine_details')->insert($vaccine_details);
    	}
    	else
    	{
    		foreach ($vaccine_details as $chart_key => $chart_val) {
    			$update_details = $chart_val;
    			unset($update_details['user_added']);
    			unset($update_details['date_added']);
    			$update_details['user_modified'] = $this->auth->user()->id;
    			$update_details['date_modified'] = date('Y-m-d H:i:s');
    			\DB::table('baby_vaccine_details')->where('baby_id', $baby_id)->where('age_id', $update_details['age_id'])->where('vaccine_generic_id', $update_details['vaccine_generic_id'])->update($update_details);
    		}
    	}
    	return true;
    }

    public function storeEligibility($input, $visit_id, $baby_id, $visit_date) {

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

        	if (isset($input['neuro_eligibility_id']) && !empty($input['neuro_eligibility_id'])) {

        		$neuro_eligibility_result = NeuroEligibility::where('id', $input['neuro_eligibility_id'])->first();

        		$eligibility['visit_date'] = $visit_date;

        		$eligibility['modified_date_time'] = Carbon::now(env('TIME_ZONE'));
        		$eligibility['modified_user'] = $this->auth->user()->id;

        		$neuro_eligibility_result->update($eligibility);

        	} else {
				$eligibility['baby_id'] = $baby_id;
				$eligibility['neuro_visit_id'] = $visit_id;
	            $eligibility['visit_date'] = $visit_date;
	            $eligibility['op_type'] = 2; // 1 - Neuro, 2 - Neonatal
	            $eligibility['created_date_time'] = Carbon::now(env('TIME_ZONE'));
	            $eligibility['created_user'] = $this->auth->user()->id;

	            NeuroEligibility::create($eligibility)->id;
        	}

        }

    }

	/*
		This method is used to store vaccine data for baby at print button click function
	*/
		public function saveVaccinePatientData(Request $request)
		{
			$input = $request->all();
			$this->storeVaccineChart($input['vaccine_chart_input'], $input['BabyId']);
			return \Response::json(['type'=>'success','message' => 'Vaccine chart updated successfully...'], 200);
		}
	/*
	This method is use to get the vaccine chart print page
	*/
	public function vaccineChartPrint($id)
	{
		$id = \SiteHelpers::decrypt_id($id);

		$Vaccines             = Vaccine::get_lists();
		$vaccine[0] = 'Select';
		foreach ($Vaccines as $vac) {
			$vaccine[$vac->Id] = $vac->Name;
		}

		$results = Baby::get_data($id)->first();
		/*VACCINE CHART DETAILS START*/
		$baby_vaccine_chart_details = Op::getBabyVaccineChart($id);
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

		if (isset($_GET['module']) && $_GET['module'] == 'pediatric') {
			$closewinlink = action('Registration\PediatricOpController@OpsubList', \SiteHelpers::encrypt_id($id));
		} else {
			$closewinlink = action('Registration\OpController@OpsubList', \SiteHelpers::encrypt_id($id));
		}
		$is_print = 'print';
		$headerContent = Settings::findorfail(1);

		$current_user = $this->auth->user()->id;
		$current_ip = \Request::ip();

		$user_config = $page_config = OpPrintPageConfig::getUserConfigProperty($current_user);

		$ip_config = OpPrintPageConfig::getIpConfigProperty($current_ip);

		if (!(count($page_config) > 0)) {
			$page_config = $ip_config;
		}

		return view('registration.vaccine_chart_print', compact('mas_vaccine_chart', 'mas_vaccine_age', 'baby_vaccine_chart', 'user_sign', 'closewinlink', 'is_print', 'headerContent', 'results', 'vaccine', 'user_config', 'ip_config', 'page_config'));

	}
    /*
    This method is use to get the vaccine chart print page
    */
    public function vaccineChart($id)
    {
    	$id = \SiteHelpers::decrypt_id($id);

    	$Vaccines = Vaccine::get_lists();
    	$vaccine[0] = 'Select';
    	foreach ($Vaccines as $vac)
    	{
    		$vaccine[$vac
    			->Id] = $vac->Name;
    		}

    		$results = Baby::get_data($id)->first();
    		/*VACCINE CHART DETAILS START*/
    		$baby_vaccine_chart_details = Op::getBabyVaccineChart($id);
    		$baby_vaccine_chart = $baby_vaccine_chart_details->groupBy('age_id')->map(function ($item, $value)
    		{
    			return $item->sortBy('age_sort_order');
    		})
    		->toArray();;
    		$mas_vaccine = Op::getVaccineChart();

    		$mas_vaccine_chart = $mas_vaccine->groupBy('vaccine_age_id')->map(function ($item, $value)
    		{
    			return $item->sortBy('sort_order');
    		})
    		->toArray();

    		$user_sign = json_encode(\ValuelistHelpers::getUserSign());
    		if (count($baby_vaccine_chart) > 0)
    		{

    			$mas_vaccine_age = $baby_vaccine_chart_details->pluck('age', 'age_id')
    			->toArray();
    		}
    		else
    		{
    			$mas_vaccine_age = $mas_vaccine->pluck('age', 'vaccine_age_id')
    			->toArray();
    		}
    		/*VACCINE CHART DETAILS END*/

    		if (isset($_GET['module']) && $_GET['module'] == 'pediatric')
    		{
    			$closewinlink = action('Registration\PediatricOpController@OpsubList', \SiteHelpers::encrypt_id($id));
    		}
    		else
    		{
    			$closewinlink = action('Registration\OpController@OpsubList', \SiteHelpers::encrypt_id($id));
    		}
            
    		$current_user = $this
    		->auth
    		->user()->id;
    		$current_ip = \Request::ip();

    		$user_config = $page_config = OpPrintPageConfig::getUserConfigProperty($current_user);

    		$ip_config = OpPrintPageConfig::getIpConfigProperty($current_ip);

    		if (!(count($page_config) > 0))
    		{
    			$page_config = $ip_config;
    		}

    		return view('registration.vaccine_chart_view', compact('mas_vaccine_chart', 'mas_vaccine_age', 'baby_vaccine_chart', 'user_sign', 'closewinlink', 'results', 'vaccine', 'user_config', 'ip_config', 'page_config'));

    	}

    public function getPhysicalGrowth(Request $request)
    {
        $input = $request->all();

        $mrn = $input['mrn'];
        $visit_date = date('Y-m-d', strtotime($input['visit_date']));

        if ($input['requested_from'] == 'Neuro') {
	        $op_details = Op::getTodayPhysicalDetails($mrn, $visit_date);
	    } else {
        	$op_details = NeuroVisit::getTodayPhysicalDetails($mrn, $visit_date);
	    }

        return $op_details;        
    }

    /**
	 * Store a newly created appointment.
	 *
	 */
    public function makeAppointment($input, $id = 0)
    {
    	
		if ($input['need_neuro'] && !is_null($input['Review']) && !empty($input['Review']) && $id != 0) {

			$seen_by = env('DEFAULT_NEURO_SEEN_BY');

        	$appointment_details = new Request([
				'category'   => $input['AppointmentType'],
				'date'       => $input['Review'],
				'time'       => $input['review_time'],
				'mins'       => $input['review_min'],
				'session'    => $input['review_session'],
				'consultant' => $seen_by,
				'patient'    => $input['BabyId'],
				'ref_id'     => $id,
				'from'     	 => 1
			]);
			FlowController::patientDetailUpdate($appointment_details, 0);
		}

		if (!is_null($input['Review']) && !empty($input['Review']) && $id != 0) {
        	$appointment_details = new Request([
				'category'   => $input['AppointmentType'],
				'date'       => $input['Review'],
				'time'       => $input['review_time'],
				'mins'       => $input['review_min'],
				'session'    => $input['review_session'],
				'consultant' => $input['SeenBy'],
				'patient'    => $input['BabyId'],
				'ref_id'     => $id,
				'from'     	 => 1
			]);
			FlowController::patientDetailUpdate($appointment_details, 0);
		}

    }

    // Check the OP visit is exist for the selected date
    public function checkSameDateIsNeonatalOPExist(Request $request)
    {
    	$input = $request->all();

    	$result = Op::where('BabyId', $input['baby_id'])->where('OpDate', date('Y-m-d', strtotime($input['op_date'])))->where('IsDeleted', 0)->first();
    	
    	return isset($result->OpId) ? action('Registration\OpController@edit', \SiteHelpers::encrypt_id($result->OpId)) : null;

    }

    // To get the previous and next day sheet id for the currently selected data
    public function getPrevNextIds($baby_id, $id)
    {
        
        $navigation_ids = Op::getPrevNextIds($baby_id)->pluck('OpId')->toArray();

        $index = array_search($id, $navigation_ids);

        $prev_id = $next_id = null;

        if($index !== false && $index > 0 ) 
        {
            $prev_id = $navigation_ids[$index - 1] . '||' . (($index - 1) + 1);
        }
        if($index !== false && $index < count($navigation_ids) - 1) 
        {
            $next_id = $navigation_ids[$index + 1] . '||' . (($index + 1) + 1);
        }

        return ['prev_id'=>$prev_id, 'next_id'=>$next_id];

    }

}
