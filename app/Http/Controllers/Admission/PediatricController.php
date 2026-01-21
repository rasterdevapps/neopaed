<?php namespace App\Http\Controllers\Admission;

use Carbon\Carbon;

use App\Models\Pediatric;
use App\Models\Baby;
use App\Models\Mother;
use App\Models\Settings\DeleteApproval;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admissions\PediatricRequest;
use Illuminate\Http\Request;
use App\Models\Masters\DoctorMaster;
use App\Models\Admission;
use App\Models\IpNumber;
use App\Models\Settings\Settings;
use App\Models\FileUpload;
use App\Models\Masters\DrugIvFluidMaster;
use App\Models\Medications;
use App\Models\PediatricDischargeSummary;
use App\Models\PediatricSummaryPrint;
use App\User;

class PediatricController extends Controller 
{
	
	public function __construct(Guard $auth)
	{
		$this->middleware('role:PEDI_FORM,write', ['only'=>['store', 'update', 'edit', 'create', 'show', 'destroy']]);
		$this->middleware('role:PEDI_FORM,read', ['only'=>['index', 'print']]);	
		$this->auth = $auth;
		$this->yes_or_no = ['0'=>'N/A','1' => "Yes","2"=>"No"];
	}
	/**
	 * Listing of pediatric admission.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$limit = 50;
		if (!empty($request->input('limit'))) {
			$request->session()->put('limit', $request->input('limit'));
			$limit =  $request->session()->get('limit');
		} elseif ($request->session()->has('limit')) {
			$limit =  $request->session()->get('limit');
		}

        //Initialize the record sorting key and order  
		$order['sortby']    = 'id';
		$order['sortorder'] = 'desc';   

        //set the records sorting key and order  
		if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {

			$order['sortby']     = \SiteHelpers::decrypt_id($request->input('sortby'));
			$order['sortorder']  = $request->input('sortorder');

		}

		$search 			  = array();
		$search['search_txt'] = '';
		if (!empty($request->input('search_txt')))
			$search['search_txt'] = $request->input('search_txt');

		$navigate['main_nav'] = 'pediatric';
		$navigate['sub_nav'] = 'pediatric_proforma';

		$result 	= Pediatric::get_lists($request->input('page'), $limit, $search, $order, 1);
		$results 	= $result['result'];

		$getTotal   = Pediatric::GetTotal();
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

		$mr_no = collect($results)->pluck('BMrNo')->toArray();
		$admission_date = Pediatric::get_admission($mr_no); 

		foreach ($admission_date as $key => $value) {
			$AdmissionDatelist[$value->BMrNo][] = $value;
		} 

		$admission_date_list = isset($AdmissionDatelist) ? collect($AdmissionDatelist) : collect(array()) ;

		return view('admission.pediatric.list', compact('results', 'navigate', 'pagination', 'search', 'getTotal', 'order', 'admission_date_list'));
	}

	/**
	 * Show the form for creating a new record.
	 *
	 */
	public function create()
	{
		$navigate['main_nav'] = 'pediatric';
		$navigate['sub_nav'] = 'pediatric_proforma';

		$baby = Baby::ListData();
		$babies = array();
		$babies[\SiteHelpers::encrypt_id(0)] = '- - Create New Baby Registration - -';
		foreach ($baby as $data) {
			$babies[\SiteHelpers::encrypt_id($data->BabyId)] = $data->BabyName.' - '.$data->BMrNo;
		}

		$SubmitButtonText  = "Start";
		return view('admission.pediatric.select_patient', compact('SubmitButtonText', 'babies', 'navigate'));
	}

	/**
	 * Store a newly created record in storage.
	 *
	 * @return Response
	 */
    public function store(Request $request)

	{
		$input = $request->all();

		$print_flag = isset($input['print_flag']) ? $input['print_flag'] : 0;
		unset($input['print_flag']);	

		$input['MotherName'] = (isset($input['MotherName']) && !empty($input['MotherName'])) ? $input['MotherName'] : null;
		$input['PartnerName'] = (isset($input['PartnerName']) && !empty($input['PartnerName'])) ? $input['PartnerName'] : null;

		if (isset($input['mother_id']) && $input['mother_id'] != '' && $input['mother_id'] != 0) {

			$input['UserModified']	= $this->auth->user()->id; 	
			$input['DateModified']  = Carbon::now();        
			$mother                 = Mother::findOrfail($input['mother_id']);
			$input['MotherId']  = $input['mother_id'];		
			$mother->update($input);

		} else {

			$input['PartnerName'] = isset($input['parter_name']) ? $input['parter_name'] : null;
			$input['Mobile'] = isset($input['mobile']) ? $input['mobile'] : null;
			$input['Address1'] = isset($input['Address1']) ? $input['Address1'] : null;
			$input['Address2'] = isset($input['Address2']) ? $input['Address2'] : null;
			$input['Address3'] = isset($input['Address3']) ? $input['Address3'] : null;
			$input['Address4'] = isset($input['Address4']) ? $input['Address4'] : null;
			$input['Address5'] = isset($input['Address5']) ? $input['Address5'] : null;
			$input['DateAdded'] = Carbon::now();	
			$input['UserAdded']	= $this->auth->user()->id; 	
			$mother             = Mother::create($input);
			$input['MotherId']  = $mother->MotherId;		

		}	

		$input['DOB'] = (isset($input['DOB']) && !empty($input['DOB'])) ? date('Y-m-d', strtotime($input['DOB'])) : null;
		$input['admission_date'] = (isset($input['admission_date']) && !empty($input['admission_date'])) ? date('Y-m-d', strtotime($input['admission_date'])) : null;
		// $input['BirthStatus']    = (isset($input['BirthStatus']) && $input['BirthStatus'] == 'on') ? 'Inborn' : 'Outborn';	

		$input['g_weeks'] = (isset($input['g_weeks']) && !empty($input['g_weeks'])) ? $input['g_weeks'] : null;
		$input['g_days'] = (isset($input['g_days']) && !empty($input['g_days'])) ? $input['g_days'] : null;

		if (isset($input['baby_id']) && $input['baby_id'] != '' && $input['baby_id'] != 0) {

			$input['UserModified']	= $this->auth->user()->id; 	
			$input['DateModified']  = Carbon::now();  	
			$baby                   = Baby::findOrfail($input['baby_id']);
			$baby->update($input);

		} else {

			$input['DateAdded'] = Carbon::now();	
			$input['UserAdded']	= $this->auth->user()->id; 	
			$baby               = Baby::create($input);
			$input['baby_id'] = $baby->BabyId;	

		}	

		$current = Carbon::now();
		if (isset($input['admission_id']) && $input['admission_id'] == '') {
			$episodes = Admission::where('BabyId', $input['baby_id'])->count();
			$episodes += 1;
			$admission_data = array(
				'BabyId'        => $input['baby_id'],
				'BMrNo'         => $baby['BMrNo'],
				'MotherId'      => $input['MotherId'],
				'AdmissionDate' => $current,
				'AdmissionTime' => $current->format('g').':'.$current->format('i').':'.$current->format('A'),
				'InOrOut'       => 'In',
				'AdmissionType' => 'Pediatric',
				'Status'        => "Inpatient",
				'UserAdded'     => $this->auth->user()->id,
				'DateAdded'     => $current,
				'DateModified'  => $current,
				'episodes'      =>'Admission '.$episodes,

			);

			$prev_admission_status = Admission::select('AdmissionId')->where('BabyId', $input['baby_id'])->where('Status', 'Inpatient')->where('AdmissionType', 'Pediatric')->orderBy('AdmissionId', 'desc')->first();
			
			if (count($prev_admission_status) != 0) {
				$admission = $prev_admission_status;
			} else {
				$admission = Admission::create($admission_data);
			}

			Admission::where('BabyId', $input['baby_id'])->where('Status', 'Inpatient')->where('AdmissionType', '!=', 'Pediatric')->update(['Status'=>'Discharged']);

			$input['admission_id'] = $admission->AdmissionId;

			$ip_data['baby_id']         =  $input['baby_id'];   
			$ip_data['ip_number']       =  (isset($input['ip_number']) && !empty($input['ip_number']))  ? $input['ip_number'] : null ;
			$ip_data['status']          =  1; 
			$ip_data['AdmissionId']     =  $input['admission_id'];
			$ip_data['DateAdded']       =  Carbon::now();
			$ip_data['DateModified']    =  Carbon::now();
			if (isset($input['ip_number']) && $input['ip_number'] != '' && !is_null($input['ip_number'])) { 
				IpNumber::create($ip_data);
			} 

		}

		$input['admission_date'] = (isset($input['admission_date']) && !empty($input['admission_date'])) ? date('Y-m-d', strtotime($input['admission_date'])) : null;
        $input['age_year'] = (isset($input['chronological_year']) && !empty($input['chronological_year'])) ? $input['chronological_year'] : null;
        $input['age_month'] = (isset($input['chronological_month']) && !empty($input['chronological_month'])) ? $input['chronological_month'] : null;
        $input['age_days'] = (isset($input['chronological_days']) && !empty($input['chronological_days'])) ? $input['chronological_days'] : null;

		$input['admission_time'] = (isset($input['admission_time']) && !empty($input['admission_time'])) ? $input['admission_time'] : null;
		$input['admission_time_mins'] = (isset($input['admission_time_mins']) && !empty($input['admission_time_mins'])) ? $input['admission_time_mins'] : null;
        $input['assessment_time'] = (isset($input['assessment_time']) && !empty($input['assessment_time'])) ? $input['assessment_time'] : null;
		$input['assessment_time_mins'] = (isset($input['assessment_time_mins']) && !empty($input['assessment_time_mins'])) ? $input['assessment_time_mins'] : null;
		$input['assessment_time_am'] = (isset($input['assessment_time_am']) && !empty($input['assessment_time_am'])) ? $input['assessment_time_am'] : null;
		$input['seen_by'] = (isset($input['seen_by']) && !empty($input['seen_by'])) ? $input['seen_by'] : null;
		$input['verified_by'] = (isset($input['verified_by']) && !empty($input['verified_by'])) ? $this->auth->user()->id : 0;
		$input['pediatric_consultant'] = (isset($input['pediatric_consultant']) && !empty($input['pediatric_consultant'])) ? json_encode($input['pediatric_consultant']) : null;		
		$input['surgeon'] = (isset($input['surgeon']) && !empty($input['surgeon'])) ? json_encode($input['surgeon']) : null;
		$input['specialist'] = (isset($input['specialist']) && !empty($input['specialist'])) ? $input['specialist'] : null;
		$input['admission_weight'] = (isset($input['admission_weight']) && !empty($input['admission_weight'])) ? $input['admission_weight'] : null;
		$input['hr'] = (isset($input['hr']) && !empty($input['hr'])) ? $input['hr'] : null;
		$input['rr'] = (isset($input['rr']) && !empty($input['rr'])) ? $input['rr'] : null;
		$input['spo2'] = (isset($input['spo2']) && !empty($input['spo2'])) ? $input['spo2'] : null;
		$input['bp'] = (isset($input['bp']) && !empty($input['bp'])) ? $input['bp'] : null;
		$input['temperature_f'] = (isset($input['temperature_f']) && !empty($input['temperature_f'])) ? $input['temperature_f'] : null;
		$input['created_by'] = $this->auth->user()->id;
		$input['created_date_time'] = Carbon::now();
		$input['investigations'] = isset($input['investigations']) && is_array($input['investigations']) ? json_encode($input['investigations']) : null;
		$temp_investigations_test = explode(',', $input['investigations_test']);
		$input['investigations_test'] = implode(', ', $temp_investigations_test);
		$input['status_date'] = (isset($input['status_date']) && !empty($input['status_date'])) ? date('Y-m-d', strtotime($input['status_date'])) : null;
        $input['status_time'] = (isset($input['status_time']) && !empty($input['status_time'])) ? $input['status_time'] : null;
		$input['murmur'] = (isset($input['murmur']) && $input['murmur'] == 'on' ) ? "yes" : 'no';
		$input['cns_stage'] = (isset($input['cns_stage']) && !empty($input['cns_stage']) && count(array_filter($input['cns_stage'])) > 0 ) ? json_encode($input['cns_stage']) : null;
		$input['surgery'] = (isset($input['surgery']) && $input['surgery'] == 'on' ) ? true : false;
		$input['treatment_specialist'] = (isset($input['treatment_specialist']) && $input['treatment_specialist'] == 'on' ) ? true : false;
		$input['biohazard'] = (isset($input['biohazard']) && $input['biohazard'] == 'on' ) ? true : false;

		$input['pupils_right_screening'] = isset($input['pupils_right_screening']) ? $input['pupils_right_screening'] : null;

		$input['pupils_left_screening'] = isset($input['pupils_left_screening']) ? $input['pupils_left_screening'] : null;

		$input['pupils_right_length'] = (isset($input['pupils_right_length']) && !empty($input['pupils_right_length'])) ? $input['pupils_right_length'] : null;

		$input['pupils_left_length'] = (isset($input['pupils_left_length']) && !empty($input['pupils_left_length'])) ? $input['pupils_left_length'] : null;

		//treament Medication

		$treatment_medications = null;

		if (isset($input['T_Drugs'])) {
			foreach ($input['T_Drugs'] as $i => $drug_value) {
		        if (isset($input['T_Drugs'][$i]) && !empty($input['T_Drugs'][$i])) {
		        	
		           	$t_medication = [
						'Medication' => isset($input['T_Drugs'][$i]) ? $input['T_Drugs'][$i]: null,
						'Dose' => isset($input['T_Dose'][$i])? $input['T_Dose'][$i] :null,
						'Frequency' => isset($input['T_Frequency'][$i])? $input['T_Frequency'][$i] :null,
						'Duration' => isset($input['T_Duration'][$i])? $input['T_Duration'][$i] : null,
						'genericname'=>issset($input['t_generic_name'][$i])? $input['t_generic_name'][$i] : null,
						'additional_instruction'=>isset($input['T_additional_instruction'][$i]) ? $input['T_additional_instruction'][$i] : null,
						'Formulation' => isset($input['t_formulation'][$i])? $input['t_formulation'][$i] :null
					];

		           $treatment_medications[] = $t_medication; // Add each medication to the array
		        }
		    }

		   
		    $input['treatment_medications'] = json_encode($treatment_medications);

		} else {
		   $input['treatment_medications'] = null;
		}

		$discharge_medications = null;

		if (isset($input['M_Drugs'])) {
		    for ($i = 0; $i < sizeof($input['M_Drugs']); $i++) {
		        if (isset($input['M_Drugs'][$i]) && !empty($input['M_Drugs'][$i])) {
		            $medication = [
		                'Medication' => isset($input['M_Drugs'][$i]) ? $input['M_Drugs'][$i]: null,
		                'Dose' => isset($input['M_Dose'][$i]) ? $input['M_Dose'][$i] : null,
		                'Frequency' => isset($input['M_Frequency'][$i]) ? $input['M_Frequency'][$i] : null,
		                'Duration' => isset($input['M_Duration'][$i]) ? $input['M_Duration'][$i] : null,
		                'GenericName' => isset($input['m_generic_name'][$i]) ? $input['m_generic_name'][$i] : null,
		                'AdditionalInstruction' => isset($input['M_additional_instruction'][$i]) ? $input['M_additional_instruction'][$i] : null,
		                'Formulation' => isset($input['m_formulation'][$i]) ? $input['m_formulation'][$i] : null
		            ];

		            $discharge_medications[] = $medication; // Add each medication to the array
		        }
		    }

		   
		    $input['discharge_medications'] = json_encode($discharge_medications);

	    }
		$input['palpation_soft'] = isset($input['palpation_soft']) ? true : false;
		$input['palpation_rigidity'] = isset($input['palpation_rigidity']) ? true : false;
		$input['palpation_guarding'] = isset($input['palpation_guarding']) ? true : false;
		$input['palpation_tender'] = isset($input['palpation_tender']) ? true : false;
		$input['palpation_non_tender'] = isset($input['palpation_non_tender']) ? true : false;

		

		$prev_pediatric_admission_status = Pediatric::select('id')->where('baby_id', $input['baby_id'])->where('status', 'Inpatient')->orderBy('id', 'desc')->first();
		if (count($prev_pediatric_admission_status) != 0) {
			$id = $prev_pediatric_admission_status->id;
			unset($input['_token']);
			unset($input['mother_id']);
			unset($input['parter_name']);
			unset($input['mobile']);
			unset($input['phone']);
			unset($input['address1']);
			unset($input['address2']);
			unset($input['address3']);
			unset($input['city']);
			unset($input['pincode']);
			unset($input['BMrNo']);
			unset($input['BabyName']);
			unset($input['MotherName']);
			unset($input['PartnerName']);
			unset($input['DOB']);
			unset($input['g_weeks']);
			unset($input['g_days']);
			unset($input['BabyBloodGroup']);
			unset($input['Sex']);
			unset($input['pediatric_consultant_temp']);
			unset($input['specialist_temp']);
			unset($input['investigation_order']);
			unset($input['BirthWeight']);
			unset($input['UserModified']);
			unset($input['DateModified']);
			unset($input['MotherId']);
			unset($input['BirthStatus']);
			Pediatric::findOrfail($id)->update($input);
		} else {
			$id = Pediatric::create($input)->id;
		}
 

		if ($print_flag == 2) {
			return redirect(action('Admission\PediatricController@edit', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record saved successfully !');
		} elseif ($print_flag == 3) {
			return redirect(action('Admission\PediatricController@show', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record saved successfully !');
		} else {
			return redirect(action('Admission\PediatricController@index'))->with('Success', 'Record saved successfully !');
		} 

	}

	/**
	 * FUNCTION TO SELECT THE BABY FOR PEDIATRIC ADMISISON.
	 *
	 * @param  int  $id
	 */
	public function show($id)
	{

		$navigate['main_nav'] = 'pediatric';
		$navigate['sub_nav'] = 'pediatric_proforma';

		$id = \SiteHelpers::decrypt_id($id);

		if (empty($id) && $id == 0) {
			$baby_detail = [];
		} else {

			$baby_detail = Baby::FindorFail($id);
			$baby_detail = collect($baby_detail)->toArray();
			$mother_detail = Mother::FindorFail($baby_detail['MotherId']);
			$mother_detail = collect($mother_detail)->toArray();
			$baby_detail = array_merge($baby_detail, $mother_detail);
			$baby_detail = (object)$baby_detail;

			$baby_detail->Gestation = \SiteHelpers::decode_gestation($baby_detail->Gestation);
			$baby_detail->DOB       = date('d-m-Y', strtotime($baby_detail->DOB));
		}

		$admission['time'] = $admission['mins'] =  $assessment_time['time'] = $assessment_time['mins'] = array();
		for ($i = 1; $i <= 12; $i++) {
			$admission['time'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
			$assessment_time['time'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
		}
		for ($i = 0; $i <= 59; $i++) {
			$admission['mins'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
			$assessment_time['mins'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
		}

		$Doctorslist = DoctorMaster::get_lists();
		$DoctorMaster = array();
		foreach ($Doctorslist as $doctor) {
			$DoctorMaster[$doctor->id]=$doctor->Name;
		}

		$yes_or_no = $this->yes_or_no;
        $drugs = DrugIvFluidMaster::getOralDrug();
		$drug_master[0] = 'N/A';
		foreach ($drugs as $drug) {
			$drug_master[$drug->Id] = $drug->Name;
		}

		$drug_value[0]='N/A';
		foreach ($drugs as $drugvalue) {
			$drug_value[$drug->Id] = $drug->Value;
		}
        $headerContent = Settings::findorfail(1);
		return view('admission.pediatric.create', compact('baby_detail', 'navigate', 'admission', 'DoctorMaster', 'id', 'yes_or_no', 'drug_master', 'drug_value', 'headerContent', 'assessment_time'));

	}

	/**
	 * Show the form for editing the specified record.
	 *
	 * @param  int  $id

	 */
	public function edit($id)
	{
		$id = \SiteHelpers::decrypt_id($id);

		$pediatric_results = Pediatric::findOrfail($id)->toArray();

		$basic_details = (array)Baby::get_data($pediatric_results['baby_id'])[0];

		$baby_detail = array_merge($pediatric_results, $basic_details);
		$baby_detail = (object)$baby_detail;

		$baby_detail->DOB = !is_null($baby_detail->DOB) ? date('d-m-Y', strtotime($baby_detail->DOB)) : null;
		$baby_detail->admission_date = !is_null($baby_detail->admission_date) ? date('d-m-Y', strtotime($baby_detail->admission_date)) : null;
		$baby_detail->status_date = !is_null($baby_detail->status_date) ? date('d-m-Y', strtotime($baby_detail->status_date)) : null;
        $baby_detail->status_time = !is_null($baby_detail->status_time) ? $baby_detail->status_time : null;
		$baby_detail->investigations = json_decode($baby_detail->investigations);
		$baby_detail->pediatric_consultant = json_decode($baby_detail->pediatric_consultant);
		$baby_detail->specialist = json_decode($baby_detail->specialist);


		$navigate['main_nav'] = 'pediatric';
		$navigate['sub_nav'] = 'pediatric_proforma';

		$admission['time'] = $admission['mins'] =  $assessment_time['time'] = $assessment_time['mins'] = array();
		for ($i = 1; $i <= 12; $i++) {
			$admission['time'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
			$assessment_time['time'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
		}
		for ($i = 0; $i <= 59; $i++) {
			$admission['mins'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
			$assessment_time['mins'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
		}

		$Doctorslist = DoctorMaster::get_lists();
		$DoctorMaster = array();
		foreach ($Doctorslist as $doctor) {
			$DoctorMaster[$doctor->id]=$doctor->Name;
		}
		$dob = date('Y-m-d', strtotime($baby_detail->DOB));
		$admission_date = date('Y-m-d', strtotime($baby_detail->admission_date));
		$current_age = \SiteHelpers::getChronologicalage($dob, $admission_date);
		$yes_or_no = $this->yes_or_no;
        $drugs = DrugIvFluidMaster::getOralDrug();
		$drug_master[0] = 'N/A';
		foreach ($drugs as $drug) {
			$drug_master[$drug->Id] = $drug->Name;
		}
       
		$drug_value[0]='N/A';
		foreach ($drugs as $drugvalue) {
			$drug_value[$drug->Id] = $drug->Value;
		}
        $discharge_medications = json_decode($baby_detail->discharge_medications,true); 
		$treatment_medications = json_decode($baby_detail->treatment_medications,true); 
        $headerContent = Settings::findorfail(1);
		return view('admission.pediatric.edit', compact('baby_detail', 'navigate', 'admission', 'DoctorMaster', 'current_age', 'yes_or_no', 'id', 'drug_master', 'drug_value', 'discharge_medications','treatment_medications', 'headerContent', 'assessment_time'));
	}

	/**
	 * Update the specified record.
	 *
	 * @param  int  $id
	 * @return to listing page.
	 */
	public function update($id, Request $request)
	{
		$input = $request->all();

		$print_flag = isset($input['print_flag']) ? $input['print_flag'] : 0;
		unset($input['print_flag']);

		$input['UserModified']	= $this->auth->user()->id; 	
		$input['DateModified']  = Carbon::now();        
		$mother                 = Mother::findOrfail($input['mother_id']);
		$input['MotherId']  = $input['mother_id'];		
		$mother->update($input);

		$input['DOB'] = (isset($input['DOB']) && !empty($input['DOB'])) ? date('Y-m-d', strtotime($input['DOB'])) : null;
		$input['admission_date'] = (isset($input['admission_date']) && !empty($input['admission_date'])) ? date('Y-m-d', strtotime($input['admission_date'])) : null;
		$input['BirthStatus']    = (isset($input['BirthStatus']) && $input['BirthStatus'] == 'on') ? 'Inborn' : 'Outborn';	

		$input['g_weeks'] = (isset($input['g_weeks']) && !empty($input['g_weeks'])) ? $input['g_weeks'] : null;
		$input['g_days'] = (isset($input['g_days']) && !empty($input['g_days'])) ? $input['g_days'] : null;

		$input['UserModified']	= $this->auth->user()->id;
		$input['DateModified']  = Carbon::now();  	
		$baby                   = Baby::findOrfail($input['baby_id']);
		$baby->update($input);	

		$input['admission_date'] = (isset($input['admission_date']) && !empty($input['admission_date'])) ? date('Y-m-d', strtotime($input['admission_date'])) : null;
        $input['assessment_time'] = (isset($input['assessment_time']) && !empty($input['assessment_time'])) ? $input['assessment_time'] : null;
		$input['assessment_time_mins'] = (isset($input['assessment_time_mins']) && !empty($input['assessment_time_mins'])) ? $input['assessment_time_mins'] : null;
		$input['assessment_time_am'] = (isset($input['assessment_time_am']) && !empty($input['assessment_time_am'])) ? $input['assessment_time_am'] : null;
        $input['age_year'] = (isset($input['chronological_year']) && !empty($input['chronological_year'])) ? $input['chronological_year'] : null;
        $input['age_month'] = (isset($input['chronological_month']) && !empty($input['chronological_month'])) ? $input['chronological_month'] : null;
        $input['age_days'] = (isset($input['chronological_days']) && !empty($input['chronological_days'])) ? $input['chronological_days'] : null;
		$input['admission_weight'] = (isset($input['admission_weight']) && !empty($input['admission_weight'])) ? $input['admission_weight'] : null;		
		$input['seen_by'] = (isset($input['seen_by']) && !empty($input['seen_by'])) ? $input['seen_by'] : null;
		$input['verified_by'] = (isset($input['verified_by']) && !empty($input['verified_by'])) ? $this->auth->user()->id : 0;
		$input['hr'] = (isset($input['hr']) && !empty($input['hr'])) ? $input['hr'] : null;
		$input['rr'] = (isset($input['rr']) && !empty($input['rr'])) ? $input['rr'] : null;
		$input['spo2'] = (isset($input['spo2']) && !empty($input['spo2'])) ? $input['spo2'] : null;
		$input['bp'] = (isset($input['bp']) && !empty($input['bp'])) ? $input['bp'] : null;
		$input['temperature_f'] = (isset($input['temperature_f']) && !empty($input['temperature_f'])) ? $input['temperature_f'] : null;
		$input['modified_by'] = $this->auth->user()->id;
		$input['modified_date_time'] = Carbon::now();
		$input['investigations'] = isset($input['investigations']) && is_array($input['investigations']) ? json_encode($input['investigations']) : null;
		$temp_investigations_test = explode(',', $input['investigations_test']);
		$input['investigations_test'] = implode(', ', $temp_investigations_test);
		$input['status_date'] = (isset($input['status_date']) && !empty($input['status_date'])) ? date('Y-m-d', strtotime($input['status_date'])) : null;
        $input['status_time'] = (isset($input['status_time']) && !empty($input['status_time'])) ? $input['status_time'] : null;
		$input['pediatric_consultant'] = (isset($input['pediatric_consultant']) && !empty($input['pediatric_consultant'])) ? json_encode($input['pediatric_consultant']) : null;
		$input['specialist'] = (isset($input['specialist']) && !empty($input['specialist'])) ? json_encode($input['specialist']) : null;
		$input['surgeon'] = (isset($input['surgeon']) && !empty($input['surgeon'])) ? json_encode($input['surgeon']) : null;
		$input['murmur'] = (isset($input['murmur']) && $input['murmur'] == 'on' ) ? "yes" : 'no';
		$input['cns_stage'] = (isset($input['cns_stage']) && !empty($input['cns_stage']) && count(array_filter($input['cns_stage'])) > 0 ) ? json_encode($input['cns_stage']) : null;
        $input['surgery'] = (isset($input['surgery']) && $input['surgery'] == 'on' ) ? true : false;
		$input['treatment_specialist'] = (isset($input['treatment_specialist']) && $input['treatment_specialist'] == 'on' ) ? true : false;
		$input['surgery_date'] = !empty($input['surgery_date']) ? date('Y-m-d', strtotime($input['surgery_date'])) : null;

		$input['pupils_right_screening'] = isset($input['pupils_right_screening']) ? $input['pupils_right_screening'] : null;
		$input['pupils_left_screening'] = isset($input['pupils_left_screening']) ? $input['pupils_left_screening'] : null;
		
		$input['pupils_right_length'] = (isset($input['pupils_right_length']) && !empty($input['pupils_right_length'])) ? $input['pupils_right_length'] : null;
		$input['pupils_left_length'] = (isset($input['pupils_left_length']) && !empty($input['pupils_left_length'])) ? $input['pupils_left_length'] : null;
        
        $treatment_medications = null;
		if (isset($input['T_Drugs'])) {
			foreach ($input['T_Drugs'] as $i => $drug_value) {
		        if (isset($input['T_Drugs'][$i]) && !empty($input['T_Drugs'][$i])) {
		        	
		           	$t_medication = [
						'Medication' => isset($input['T_Drugs'][$i]) ? $input['T_Drugs'][$i]: null,
						'Dose' => isset($input['T_Dose'][$i])? $input['T_Dose'][$i] :null,
						'Frequency' => isset($input['T_Frequency'][$i])? $input['T_Frequency'][$i] :null,
						'Duration' => isset($input['T_Duration'][$i])? $input['T_Duration'][$i] : null,
						'genericname'=>isset($input['t_generic_name'][$i])? $input['t_generic_name'][$i] : null,
						'additional_instruction'=>isset($input['T_additional_instruction'][$i]) ? $input['T_additional_instruction'][$i] : null,
						'Formulation' => isset($input['t_formulation'][$i])? $input['t_formulation'][$i] :null
					];

		           $treatment_medications[] = $t_medication; // Add each medication to the array
		        }
		    }
		    $input['treatment_medications'] = json_encode($treatment_medications);
		} else {
		   $input['treatment_medications'] = null;
		}


		$input['discharge_medications'] = null;
        $discharge_medications = [];
		if (isset($input['drug_name']) && count(array_filter($input['drug_name'])) > 0) {
			foreach ($input['drug_name'] as $drug_key => $drug_value) {
				if (!empty($drug_value)) {
					$discharge_medications[$drug_key] = [
					'drug_name' => $drug_value,
					'dose' => $input['dose'][$drug_key] ?? null,
					'frequency' => $input['frequency'][$drug_key] ?? null,
					'duration' => $input['duration'][$drug_key] ?? null,
					'generic_name'=>$input['generic_name'][$drug_key] ?? null,
					'formulation'=>$input['formulation'][$drug_key] ?? null,
					];
			    }
			}
		}
		
		if (isset($input['M_Drugs'])) {
		   foreach ($input['M_Drugs'] as $i => $drug_value) {
		        if (isset($input['M_Drugs'][$i]) && !empty($input['M_Drugs'][$i])) {
		            $medication = [
		                'Medication' => isset($input['M_Drugs'][$i]) ? $input['M_Drugs'][$i]: null,
		                'Dose' => isset($input['M_Dose'][$i]) ? $input['M_Dose'][$i] : null,
		                'Frequency' => isset($input['M_Frequency'][$i]) ? $input['M_Frequency'][$i] : null,
		                'Duration' => isset($input['M_Duration'][$i]) ? $input['M_Duration'][$i] : null,
		                'GenericName' => isset($input['m_generic_name'][$i]) ? $input['m_generic_name'][$i] : null,
		                'AdditionalInstruction' => isset($input['M_additional_instruction'][$i]) ? $input['M_additional_instruction'][$i] : null,
		                'Formulation' => isset($input['m_formulation'][$i]) ? $input['m_formulation'][$i] : null
		            ];

		            $discharge_medications[] = $medication; // Add each medication to the array
		        }
		    }

		 }
		// If discharge medications are populated, encode them into JSON
		if (!empty($discharge_medications)) {
		    $input['discharge_medications'] = json_encode($discharge_medications);
		}
		
		$input['palpation_soft'] = isset($input['palpation_soft']) ? true : false;
		$input['palpation_rigidity'] = isset($input['palpation_rigidity']) ? true : false;
		$input['palpation_guarding'] = isset($input['palpation_guarding']) ? true : false;
		$input['palpation_tender'] = isset($input['palpation_tender']) ? true : false;
		$input['palpation_non_tender'] = isset($input['palpation_non_tender']) ? true : false;
		Admission::where('AdmissionId', $input['admission_id'])->update(['Status'=>$input['status']]);
		$pediatric_results = Pediatric::findOrfail($id);
		$pediatric_results->update($input);	

		if ($request->ajax()) {
			return \Response::json(['type' => 'success', 'message' => 'Record updated successfully !', 'list_url' => action('Admission\PediatricController@index')], 200);
		}

		if ($print_flag == 3) {
			return redirect(action('Admission\PediatricController@print', \SiteHelpers::encrypt_id($id)).'?closewinlink=edit')->with('Success', 'Record saved successfully !');
		} else if ($print_flag == 4) {
			return redirect(action('Admission\PediatricController@summaryprint', \SiteHelpers::encrypt_id($id)).'?closewinlink=edit')->with('Success', 'Record saved successfully !');
		} else {
			return redirect(action('Admission\PediatricController@index'))->with('Success', 'Record saved successfully !');
		} 

	}
	/* PRINT DISPLAY FOR THE SPECIFIED RECORD */

	public function print($id, Request $request)
	{
		$id = \SiteHelpers::decrypt_id($id);
		$result = Pediatric::get_record($id);
		$results = $result[0];
		$results->DOB = !empty($results->DOB) ? date('d-m-Y', strtotime($results->DOB)) : null;
		$results->gestation = $results->g_weeks . '+' . ($results->g_days > 0 ? $results->g_days : 0);
		$results->admission_date_time = !empty($results->admission_date) ? date('d-m-Y', strtotime($results->admission_date)) . ' ' . (strlen($results->admission_time) > 1 ? $results->admission_time : '0'.$results->admission_time) . ':' . (strlen($results->admission_time_mins) > 1 ? $results->admission_time_mins : '0'.$results->admission_time_mins) . ' ' . $results->admission_time_am : null;
		$results->surgeon = $results->surgeon > 0 ? \ValuelistHelpers::mas_doctors_list($results->surgeon) : 'N/A';
		$results->admission_date = !empty($results->admission_date) ? date('d-m-Y', strtotime($results->admission_date)) : date('d-m-Y');
		$results->assessment_date_time = !empty($results->admission_date) ? date('d-m-Y', strtotime($results->admission_date)) . ' ' . (strlen($results->assessment_time) > 1 ? $results->assessment_time : '0'.$results->assessment_time) . ':' . (strlen($results->assessment_time_mins) > 1 ? $results->assessment_time_mins : '0'.$results->assessment_time_mins) . ' ' . $results->assessment_time_am : null;
		// $results->pediatric_consultant = \SiteHelpers::formating_consultant_signature($results->pediatric_consultant, false, $results->hospital_name);
        $results->pediatric_consultant = \ValuelistHelpers::signatureFormat($results->pediatric_consultant);

		$mas_doctors_list = \ValuelistHelpers::mas_doctors_list();

		$results->investigations_names = '';
		$investigation_list = \ValuelistHelpers::getInvestigation(); 

		if (count($results->investigations)) {
			foreach (json_decode($results->investigations) as $key => $value) {
				if ($key == 0) {
					$results->investigations_names = $investigation_list[$value];
				} else {
					$results->investigations_names .= ', ' . $investigation_list[$value];
				}
			}
		}

		if ($request->get('closewinlink') == 'edit') {
			$closewinlink = action('Admission\PediatricController@edit', \SiteHelpers::encrypt_id($id));
		} else {
			$closewinlink = action('Admission\PediatricController@sublist',\SiteHelpers::encrypt_id($results->BabyId));
		}

		$yes_or_no = $this->yes_or_no;

		return view('admission.pediatric.print', compact('results', 'closewinlink', 'mas_doctors_list', 'yes_or_no'));
	}

	
	/* RETRIEVE THE SPECIFIED RECORD FOR POP UP VIEW */

	public function getData($id)
	{
		$result = Pediatric::get_record($id);
		$results = (array)$result[0];
		$results['AdmissionDate'] = date('d-m-Y', strtotime($results['AdmissionDate']));
		$results['AdmissionTime'] = date('H:i a', strtotime($results['AdmissionTime'])); 		 
		$results['DOB'] = date('d-m-Y', strtotime($results['DOB']));

		return json_encode($results);		
	}
	/* RETRIEVE THE DATA FOR SEARCH OPETATION */

	public function searchData(Request $request)
	{
		$data = $request->get('data1');
		$results = Pediatric::GetSearchDatas($data);
		return json_encode($results);
	}

	/**
	 * UPDATE THE SPECIFIED RECORD AS DELETED AND CREATE THE REQUEST FOR APPROVAL
	 *
	 * @param  int  $id
	 
	 */
	public function destroy($id)
	{
		$results = Pediatric::findOrfail($id);
		$user_detail = array(
			'deleted_by'	     => $this->auth->user()->id,
			'modified_date_time' => Carbon::now(),
			'is_deleted'		 => '1'
		);
		$results->update($user_detail);
		$result =  Pediatric::get_record($id);
		$res = $result[0];
		
		$delete_data = array(
			'Name'		  	   => $res->BabyName,
			'AdmissionDate'	   => $results['admission_date'],
			'ModuleController' => 'Admission\PediatricController',
			'ModuleId'		   => $id,
			'ModuleName'	   => 'Pediatric Admission',
			'UserDeleted'	   => $this->auth->user()->id,
			'DateDeleted'	   => Carbon::now()
		);
		DeleteApproval::create($delete_data);
		return redirect(action('Admission\PediatricController@index'))->with('info', 'Record deleted successfully !');
	}


	public function sublist(Request $request, $id)
	{

		$baby_id = \SiteHelpers::decrypt_id($id);

		$navigate['main_nav'] = 'pediatric';
		$navigate['sub_nav'] = 'pediatric_proforma';
		$results   = Pediatric::getBabywiseList($baby_id);
		$total = $results['total'];
		$results = $results['result'];

		$babyName  = isset($results[0]->BabyName) ? $results[0]->BabyName :'';
		$babyMrno  = isset($results[0]->BMrNo) ? $results[0]->BMrNo : '';

        $visit_ids = collect($results)->pluck('id');

        $file_list = FileUpload::getList($visit_ids, 7);

		return view('admission.pediatric.sublist', compact('results', 'navigate', 'babyName', 'babyMrno', 'baby_id', 'file_list'));

	}

	/* PRINT DISPLAY FOR THE SPECIFIED RECORD */
	public function summaryprint($id, Request $request)
	{
		$id = \SiteHelpers::decrypt_id($id);
		$result = Pediatric::get_record($id);
		$results = $result[0];

		$results->DOB = !empty($results->DOB) ? date('d-m-Y', strtotime($results->DOB)) : null;
		$results->gestation = $results->g_weeks . '+' . ($results->g_days > 0 ? $results->g_days : 0);
		$results->admission_date_time = !empty($results->admission_date) ? date('d-m-Y', strtotime($results->admission_date)) . ' ' . (strlen($results->admission_time) > 1 ? $results->admission_time : '0'.$results->admission_time) . ':' . (strlen($results->admission_time_mins) > 1 ? $results->admission_time_mins : '0'.$results->admission_time_mins) . ' ' . $results->admission_time_am : null;


		$results->investigations_names = '';
		$investigation_list = \ValuelistHelpers::getInvestigation(); 
		$results->status_date = !empty($results->status_date) ? date('d-m-Y', strtotime($results->status_date)) : date('d-m-Y');

		if (count($results->investigations)) {
			foreach (json_decode($results->investigations) as $key => $value) {
				if ($key == 0) {
					$results->investigations_names = $investigation_list[$value];
				} else {
					$results->investigations_names .= ', ' . $investigation_list[$value];
				}
			}
		}
		
		$headerContent = Settings::findorfail(1);
        // $results->pediatric_consultant = \SiteHelpers::formating_consultant_signature($results->pediatric_consultant, false, $results->hospital_name);
		$results->pediatric_consultant = json_decode($results->pediatric_consultant);
		$mas_doctors_list = \ValuelistHelpers::mas_doctors_list();

		if ($request->get('closewinlink') == 'edit') {
			$closewinlink = action('Admission\PediatricController@edit', \SiteHelpers::encrypt_id($id));
		} else {
			$closewinlink = action('Admission\PediatricController@sublist',\SiteHelpers::encrypt_id($results->BabyId));
		}

        $summary_approval = $this->auth->user()->summary_approval;

		$yes_or_no = $this->yes_or_no;

		$user_id = $this->auth->user()->id;

		$is_approved = false;
		$approved_by_list = [];
		if (strlen($results->approved_by) > 0) {
			$approved_by_list = json_decode($results->approved_by);
			if (in_array($user_id, $approved_by_list)) {
				$is_approved = true;
			}
		}
        $editor_content = PediatricDischargeSummary::where('pediatric_id', $id)->first();

        $old_print_sheet_count = PediatricSummaryPrint::getPrintedContentCount($id);


        $medications = Pediatric::getDischargeMedications($results->baby_id, $results->admission_id);

        if (!empty($results->anaesthetist)) {
        	
			$anaesthetist_name = \ValuelistHelpers::mas_surgeon_list($results->anaesthetist);
        } else {
        	$anaesthetist_name = 'N/A';
        }
        if (!empty($results->specialist)) {
        	
			$specialist_name = \ValuelistHelpers::mas_surgeon_list($results->specialist);
        } else {
        	$specialist_name = '';
        }

        $surgeon_name = [];
        if (is_string($results->surgeon) && is_array(json_decode($results->surgeon, true))) {

             $results->surgeon = json_decode($results->surgeon, true);

               foreach ($results->surgeon as $key => $value) {
               	 if ($key == 0) {
					$surgeon_names = '';
				} else {
					$surgeon_name[] = \ValuelistHelpers::mas_surgeon_list($value);;
				}
 			     
 		     }
        }   
        $drugs = DrugIvFluidMaster::getOralDrug();
		$drug_master[0] = 'N/A';
		foreach ($drugs as $drug) {
			$drug_master[$drug->Id] = $drug->Name;
		}

		$issued = isset($results->issued_to) && !is_null($results->issued_to) ? true : false;

		if (is_null($results->issued_date_time)) {
			$issued_date = date('d-m-Y h:i A');			
		} else {
			$issued_date = date('d-m-Y h:i A', strtotime($results->issued_date_time));
		}
		$issued_date_time_splited = explode(' ', $issued_date);
		$results->issued_date = $issued_date_time_splited[0];
		$results->issued_time_session = $issued_date_time_splited[2];
		$issued_time = $issued_date_time_splited[2];
		$issued_time = explode(':', $issued_date_time_splited[1]);
		$results->issued_time = (int)$issued_time[0];
		$results->issued_time_mins = (int)$issued_time[1];
		
		return view('admission.pediatric.summary-print', compact('results', 'closewinlink', 'headerContent', 'mas_doctors_list', 'yes_or_no', 'summary_approval', 'is_approved', 'approved_by_list', 'editor_content', 'old_print_sheet_count', 'medications', 'anaesthetist_name', 'surgeon_name', 'drug_master', 'specialist_name', 'issued'));
	}

	/* Approve the summary */
	public function summaryApproval(Request $request)
	{
		$form_id = $request->get('id');
		$user_id = $this->auth->user()->id;
		$user_ids[] = $user_id;

		$results = Pediatric::findOrfail($form_id);

		$approved_by_list = $results->approved_by;

		$is_approved = false;

		if (strlen($approved_by_list) > 0) {
			$approved_by_list = json_decode($approved_by_list);
			if (!in_array($user_id, $approved_by_list)) {
				$final_approved_by_list = array_merge($approved_by_list, $user_ids);
				$results->update(['approved_by' => json_encode($final_approved_by_list)]);
			} else {
				if (($key = array_search($user_id, $approved_by_list)) !== false) {
					unset($approved_by_list[$key]);
					$results->update(['approved_by' => json_encode($approved_by_list)]);
				}
			}
		} else {        	
			$results->update(['approved_by' => json_encode($user_ids)]);
			$is_approved = true;
		}

		return \Response::json(['approved_status'=>$is_approved]);

	}

	public function issuedDetails(Request $request)
	{
		$input = $request->all();

		$id = $input['id'];
		$post['issued_to'] = $input['issued_to'];
		$post['issued_to_relationship'] = $input['issued_to_relationship'];
		$issued_date_time = $input['issued_date'] . ' ' . $input['issued_time'] . ':' . $input['issued_time_mins'] . ' ' . $input['issued_time_session'];
		$post['issued_date_time'] = date('Y-m-d H:i', strtotime($issued_date_time));
		$post['issued_by'] = $this->auth->user()->id;
		$post['issued_marked_date_time'] = Carbon::now();

		Pediatric::findOrfail($id)->update($post);

		return \Response::json(['type' => 'success', 'message' => 'Record updated successfully !'], 200);
	}

}
