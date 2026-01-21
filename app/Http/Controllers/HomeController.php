<?php namespace App\Http\Controllers;

use Illuminate\Html\HtmlFacade  as HTML;
use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use Session;
use Auth;
use Excel;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Mother;
use App\Models\Baby;
use App\Models\Neonatal;
use App\Models\Admission;
use App\Models\Nicu;
use App\Models\Usg;
use App\Models\Daycare;
use App\Models\Op;
use App\Models\Pediatric;
use App\Models\Complication;
use App\Models\DischargeSummary;
use App\Models\Medications;
use App\Models\Problems;
use App\Models\Delivery;
use App\Models\Ultra;
use App\Models\Cardio;
use App\Models\Newborn;
use App\Models\DaycareQuestions;
use App\Models\AutoCompleteWords;
use App\Models\Postnatal;
use App\Models\Masters\AutoTagMasters;
use App\Models\Masters\AntibioticMaster;
// use App\Models\Masters\Drug;
use App\Models\Masters\DoctorMaster;
use App\Models\Masters\MediprobsMaster;
use App\Models\Masters\Complications;
use App\Models\Masters\Vaccine;
use App\Models\Masters\Admissionmode;
use App\Models\Masters\Indication;
use App\Models\Reports\NicuDischarge;
use App\Models\Reports\PostProblemDischargeSummary;
use App\Models\FlowControl;
use App\Models\PostDaycare;
use App\Models\PostnatalDischarge;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Models\SummaryDictionary;
use App\Models\Fhir\FhirJsonSchema;
use App\Models\Machine\MachineData;
use App\Models\Calender\AppointmentDetail;
use App\Models\Masters\DrugAndInfusion;
use Illuminate\Support\Facades\Schema;
use App\Models\Oppediatric;
use App\Models\Culture;
use App\Models\NeuroVisit;

// $path = base_path().'/vendor/dcarbone/php-fhir/output/PHPFHIRGenerated/PHPFHIRResponseParser.php';
// require $path;

class HomeController extends Controller 
{

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth   = $auth;
		$this->zone   = env('TIME_ZONE');
	}

	/**
	 * DISPLAY THE DASHBOARD OF THE APPLICATION
	 *
	 */
	public function index(Request $request)
	{
		$navigate['main_nav'] = 'dashboard';
		$navigate['sub_nav']  = '';
		$results['baby']      = Baby::orderBy('DateAdded', 'desc')
		->where('IsDeleted', '0')
		->take(5)
		->get();
		$results['op']        = Op::GetDashboardList();

		$results['nicu']      = Nicu::get_lists('', 5, '');

		$results['babylist']  = Baby::getHomeBabyList();

		krsort($results['babylist']);

		$active_baby_list = Baby::baby_list_delete();

		$results['postnatal'] = Postnatal::getRecentAdmission(5);

		$role_id = $this->auth->user()->RoleId;	

		$comparse_year_wise_baby_reg = Baby::comparse_year_wise_count();

		$year_wise_baby_reg = Baby::comparse_year_wise_count_2();

		$ward_wise_reg = Baby::ward_wise_count();

		return view('home', compact('results', 'navigate', 'result', 'active_baby_list', 'role_id', 'year_wise_baby_reg', 'ward_wise_reg', 'comparse_year_wise_baby_reg'));
	}
     /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
     public function search(Request $request)
     {
     	$input = $request->all();

     	if (isset($input['baby_id']) && $input['baby_id'] == '0') {
     		return redirect()
     		->back()
     		->with('error', 'Baby is empty...!');
     	} 

     	$temp_baby_id = isset($input['baby_id']) ? $input['baby_id'] : '';
     	$baby_id = empty($temp_baby_id) ? '' : \SiteHelpers::decrypt_id($temp_baby_id);

     	$navigate['main_nav']   = 'dashboard';

     	$navigate['sub_nav']     = '';

     	$results = [];

     	$temp_babylist     = Baby::getHomeBabyList();

     	$current_baby = isset($temp_babylist[$baby_id]) ? $temp_babylist[$baby_id] : '';

     	$temp_babylist = array_flip($temp_babylist);

     	$results_babylist     = collect($temp_babylist)->map(function($value) {
     		return \SiteHelpers::encrypt_id($value);
     	})->toArray();

     	$results['babylist'] = array_flip($results_babylist);

     	if ($baby_id != '') {

     		$results['baby']         = Baby::orderBy('DateAdded', 'desc')->where('IsDeleted', '0')->take(5)->get();

     		$results['op']           = Op::GetDashboardList();

     		$results['nicu']         = Nicu::get_lists('', 5, '');

     		$results['pediatric']    = Pediatric::get_lists('', 5, '');  

     		$active_baby_list = Baby::baby_list_delete();

     		$results['baby_details']        = Baby::where('BabyId', $baby_id)->first();

     		$results['motherrecord']        = Mother::where('MotherId', $results['baby_details']->MotherId)->first();

     		$results['neonatal_list']       = Neonatal::getSinglebabyList($baby_id);

     		$results['nicuadmission']       =  Nicu::get_sub_lists($baby_id)->toArray();

     		krsort($results['nicuadmission']);

     		$daycare_list                  = Daycare::where('IsDeleted', 0)
     		->select('baby_admission.episodes')
     		->addSelect('daycare.BabyId', 'daycare.AdmissionId', 'daycare.DayId')
     		->addSelect('daycare.day_name')
     		->join('baby_admission', 'baby_admission.AdmissionId', '=', 'daycare.AdmissionId')
     		->where('daycare.BabyId', $baby_id)
     		->orderBy('DayId', 'desc')
     		->get();

     		$results['daycare_list']  	    = $daycare_list->unique('AdmissionId')
     		->pluck('episodes', 'AdmissionId')
     		->toArray();

     		foreach ($results['daycare_list'] as $key => $admissionid) {

     			$results['daycare_list'][$admissionid] = $daycare_list->where('AdmissionId', $key)->toArray();

     			unset($results['daycare_list'][$key]);
     		}	

     		$results['nicu_summary_daycare'] = NicuDischarge::get_inpatient_baby_sublists($baby_id); 

     		$results['postnatal_admmission'] = Postnatal::postnatalAdmissionList($baby_id);

     		$postnatal_daycare_list          = PostDaycare::where('postnatal_daycare.IsDeleted', 0)
     		->select('baby_admission.episodes')
     		->addSelect('postnatal_daycare.PDayId', 'postnatal_daycare.AdmissionId', 'postnatal_daycare.BabyId')
     		->join('baby_admission', 'baby_admission.AdmissionId', '=', 'postnatal_daycare.AdmissionId')
     		->where(['postnatal_daycare.BabyId' => $baby_id])
     		->get();

     		$results['postnatal_daycare'] = $postnatal_daycare_list->unique('AdmissionId')
     		->pluck('episodes', 'AdmissionId')
     		->toArray();

     		foreach ($results['postnatal_daycare'] as $key => $admissionid) {

     			$results['postnatal_daycare'][$admissionid] = $postnatal_daycare_list->where('AdmissionId', $key)->toArray();

     			unset($results['postnatal_daycare'][$key]);
     		}	

     		$results['postnatal_discharge'] =  PostnatalDischarge::GetDischargelist($baby_id);

     		$results['postnatal_summary']    = PostProblemDischargeSummary::getAdmissionList($baby_id);

     		$results['neonatal_op_visite']            = Op::GetOpvisitList($baby_id);

     		$results['pediatric_op_visite']            = Oppediatric::GetOpvisitList($baby_id);

     		$results['echocardiogram']       = Cardio::where('BabyId', $baby_id)
     		->where('IsDeleted', 0)
     		->orderby('TestDate', 'desc')
     		->get();
     		$results['ultra']         = Ultra::where('BabyId', $baby_id)
     		->where('IsDeleted', 0)
     		->orderby('TestDate', 'desc')
     		->get() ; 
     		$results['culture']         = Culture::where('BabyId', $baby_id)
     		->where('IsDeleted', 0)
     		->orderby('EntryDate', 'desc')
     		->get() ;       

     		$results['pediatric_summary'] = Pediatric::getBabywiseList($baby_id);

     		$results['pediatric_summary'] = collect($results['pediatric_summary']['result'])->toArray();

     		krsort($results['pediatric_summary']);

     		$results['neuro_visit'] = NeuroVisit::GetNeuroVisitList($baby_id);

     		$results['nurse_sheet'] = \DB::table('nurse_main_sheet')->where('baby_id', $baby_id)->orderBy('sheet_date', 'desc')->get();

     		$results['prescription'] = collect($results['nurse_sheet'])->pluck('baby_id', 'admission_id');

     		$results['nurse_sheet'] = $results['nurse_sheet']->groupBy('admission_id');

     	}

     	$baby_id = isset($results_babylist[$current_baby]) ? $results_babylist[$current_baby] : '';

     	return view('search.over_all_report', compact('results', 'navigate', 'baby_id'));

     }

     /**
	 * create calendar.
	 *
	 * @return void
	 */
     public function calendar(Request $request) 
     {
     	$auth_user_id = $this->auth->user()->id;
     	$auth_user_role = $this->auth->user()->RoleId;
     	$auth_user_master_id = $this->auth->user()->mas_id;

     	if ($request->ajax())
     	{

     		$input = $request->all();

     		$start_at = date('Y-m-d', strtotime($input['start_at']));
     		$end_at = date('Y-m-d', strtotime($input['end_at']));

     		$appointment_detail = AppointmentDetail::userFilter($start_at, $end_at);

     		$patient_review_appointments   = array();
     		foreach ($appointment_detail as $key => $value) {	
     			$review_time = (!is_null($value->modified_appointment_time) && !empty($value->modified_appointment_time)) ? $value->modified_appointment_time : $value->appointment_time;
     			$review_min  = (!is_null($value->modified_appointment_min) && !empty($value->modified_appointment_min)) ? $value->modified_appointment_min : $value->appointment_min;
     			$review_session = (!is_null($value->modified_appointment_session) && !empty($value->modified_appointment_session)) ? $value->modified_appointment_session : $value->appointment_session;
     			$date 		 = (!is_null($value->modified_appointment_date) && !empty($value->modified_appointment_date)) ? $value->modified_appointment_date : $value->appointment_date;

     			$review_time = strlen($review_time) > 1 ? $review_time : '0'.$review_time;
     			$review_min  = strlen($review_min) > 1 ? $review_min : '0'.$review_min;

     			$patient_appointment = $date.' '.$review_time.':'.$review_min.' '.$review_session;
     			$patient_appointment = date('Y-m-d h:i a', strtotime($patient_appointment));

     			$patient_appointment_start   = Carbon::createFromFormat('Y-m-d h:i a', $patient_appointment)->format('d-m-Y H:i');
     			$patient_appointment_end     = Carbon::createFromFormat('Y-m-d h:i a', $patient_appointment)->addMinutes(30)->format('d-m-Y H:i');

     			$baby_details = Baby::get_record($value->patient);

     			$value->reason = isset($value->reason) ? $value->reason : null;

     			$patient_data["identifier"]               =  $value->id;
     			$patient_data["isAllDay"]                 =  false;
     			$patient_data["start"]                    =  $patient_appointment_start;
     			$patient_data["end"]                      =  $patient_appointment_end;
     			$patient_data["calendar"]                 =  "Review";
     			$patient_data["tag"]                      =  $value->category;
     			$short_code = '';
     			if (isset($value->seen_by)) {
     				if ($value->seen_by == 7) {
     					$short_code = '[RKS]';
     				} else if ($value->seen_by == 8) {
     					$short_code = '[DVS]';
     				}
     			}
     			if ($value->baby_name_mrn == '') {
     				$value->baby_name_mrn = $value->baby_name;
     			}
     			$patient_data["title"]                    = $short_code . ' ' . $value->baby_name_mrn;
     			$patient_data["url"]                      =  "";
     			$patient_data["color"]                    =  "FFFFFF";
     			if ($value->seen_by == env('DEFAULT_NEURO_SEEN_BY')) {
     				$patient_data["singleColor"]          =  "16A085";
     			} else {
     				unset($patient_data["singleColor"]);
     			}
     			$patient_data["borderColor"]              =  "000000";
     			$patient_data["textColor"]                =  "000000";
     			$patient_data["nonAllDayEventsTextColor"] =  "000000";
     			$patient_data["isDragNDropInMonthView"]   =  true;
     			$patient_data["isDragNDropInDetailView"]  =  true;
     			$patient_data["isResizeInDetailView"]     =  true;
     			$patient_data["baby_id"]     			  =  $value->baby_id;
     			$patient_data["event_id"]     	          =  $value->id;
     			$patient_data["date"][$patient_appointment_start . "||" . $patient_appointment_end] = "false".$value->id;
     			$patient_data["reason"] 				  = $value->reason;
     			$patient_review_appointments[]			  =  $patient_data;

     			unset($patient_data["date"][$patient_appointment_start . "||" . $patient_appointment_end]);
     		}   
     		$review_appointments 	= json_encode($patient_review_appointments);

     		return $review_appointments;
     	}
     	$title = "Calendar & Appointment";
     	$baby_list = Baby::babyCustomDetails();
     	$baby_list = \ValuelistHelpers::select2DataFormater($baby_list, false, false);

     	$auth_user = (in_array($auth_user_role, [env('SUPER_ADMIN_ROLE')]) || ($auth_user_master_id == env('DEFAULT_NEURO_SEEN_BY'))  || ($auth_user_id == env('CALENDAR_SEEN_BY_ID')));

     	return view('calendar', compact('title', 'baby_list', 'auth_user'));

     }

	 /**
	 * Get baby phone numbers
	 *
	 * @return Respones 
	 */
	 public function getContactNumbers(Request $request)
	 {          
	 	$baby_id = $request->get('baby_id');
	 	$data = collect(AppointmentDetail::getContactDetails($baby_id))->toArray();
	 	$data = array_filter($data);
	 	$data = implode(', ', $data);
        return \Response::json(['data' => $data]);
	 }

	 /**
	 * coming soon records
	 *
	 * @return Respones 
	 */
	 public function comingsoon()
	 {          
	 	return view('comingsoon');
	 }

    /**
	 * Create getAutosuggestionTag.
	 *
	 * @return Respones
	 */
    public function getAutosuggestionTag() 
    {

    	$nicu_admission  = \DB::table('nicu_admission')
    	->whereBetween('AdmissionDate', ['2020-06-01', '2020-06-30'])	
    	->where('IsDeleted', '0')
    	->get();
    	echo "<table>";
    	foreach ($nicu_admission as $key => $value) {
    		$baby_name = Baby::find($value->BabyId)->BabyName;
    		$daycare   = \DB::table('daycare')
    		->where('IsDeleted', '0')
    		->where('BabyId', $value->BabyId)
    		->count();


    		echo "<tr><td>".$baby_name."</td><td>".$daycare."</td></tr>";

    	}	
    	echo "</table>";
    	exit;	
    	$test = Nicu::get();
		// $result =  \DB::table('baby')
		//     ->select("baby.BMrNo","baby.BabyName", "baby.DOB", "discharge_summary.Problems", "baby.DateAdded")
		//     ->join('discharge_summary', 'discharge_summary.baby_id', '=', 'baby.BabyId')
		//     ->whereBetween('baby.DateAdded', ['2019-01-01', '2019-12-31'])
		//     ->get();
		//     echo "<table>";
		//     foreach ($result as $key => $value) {
		//     echo "<tr>";
		//     echo "<td>".date('d-m-Y', strtotime($value->DateAdded))."</td>";
		//     echo "<td>".$value->BMrNo."</td>";
		//     echo "<td>".$value->BabyName."</td>";
		//     echo "<td>".date('d-m-Y', strtotime($value->DOB))."</td>";
		//     echo "<td>".$value->Problems."</td>";

		//     echo "</tr>";			

		//     }
		//     echo "</table>";
	 // exit;	    
		// return view('test_style');

    	return \Response::json(['test'=>$test], 200);

    }
    public function storeScreenSize(Request $request)
    {
    	$input = $request->all();
    	if (isset($input['size'])) {
    		Session::put('screen_width', $input['size']);
    		return 'success';
    	}
    	return 'fail';
    }
    public function testlog()
    {
    	return view('testlog');
    }

    public function getTimelinePage(){
    	return view('time_line');
    }

    public function checkAuthLogin()
    {
    	if (Auth::check()) {
    		return \Response::json(['type'=>'succcess', 'message'=>'User logged in'], 200);
    	}
    	else
    	{
    		return \Response::json(['type'=>'failure', 'message'=>'User logged out'], 200);
    	}
    }

    public function checkLoginUser(Request $request)
    {
    	$input = $request->all();
    	$current_user = \Auth::user();

    	$checkUserExist = \DB::table('users')->where('email', $input['user_name'])->first();

    	if (isset($checkUserExist->id)) {
    		if (\Hash::check($input['password'], $checkUserExist->password)) {
    			if (isset($current_user->id) && $current_user->id == $checkUserExist->id) {
    				return \Response::json(['type'=>'success', 'message'=>'Same user logged again...'], 200);
    			}
    			else
    			{
    				if (Auth::attempt(['email' => $input['user_name'], 'password' => $input['password']]))
    				{
    					return \Response::json(['type'=>'anotherUser', 'message'=>'Another user trying to log in...'], 200);
    				}
    				else
    				{
    					return \Response::json(['type'=>'failure', 'message'=>'Invalid credentials...'], 200);
    				}
    			}
    		}
    		else
    		{
    			return \Response::json(['type'=>'failure', 'message'=>'Password doesn\'t match...'], 200);
    		}
    	}
    	else
    	{
    		return \Response::json(['type'=>'failure', 'message'=>'User name not exist...'], 200);
    	}
    }

    public function getNICUTimelinePage(){
    	$data['2018/08/11'] = 'SLE5000';
    	// $data['2024/12/20'] = 'SLE6000';
    	// $data['2024/11/21'] = 'SLE6000';
    	// $data['2022/12/05'] = 'SLE6000';
    	// $data['2022/01/05'] = 'SLE6000';
    	// $data['2021/11/25'] = 'SLE6000';
    	// $data['2020/10/10'] = 'SLE6000';
    	// $data['2019/10/01'] = 'SLE6000';
    	$data['2019/01/25'] = 'SLE6000';
    	// $data['2020/10/10'] = 'SLE3600 INO Machine';
    	$data['2019/06/04'] = 'SLE3600 INO Machine';
    	// $data['2024/04/20'] = 'SENTEC PCO2 Monitor';
    	// $data['2022/09/28'] = 'SENTEC PCO2 Monitor';
    	$data['2021/03/12'] = 'SENTEC PCO2 Monitor';
    	// $data['2021/03/24'] = 'SENTEC PCO2 Monitor';
    	// $data['2022/09/16'] = 'ICON Cardiac Monitor';
    	// $data['2022/09/12'] = 'ICON Cardiac Monitor';
    	// $data['2020/08/17'] = 'ICON Cardiac Monitor';
    	$data['2020/08/12'] = 'ICON Cardiac Monitor';
    	$data['2020/10/17'] = 'NIRS Monitor';
    	// $data['2023/01/19'] = 'CFM';
    	$data['2019/03/09'] = 'CFM';
    	// $data['2021/02/09'] = 'Criticool Machine';
    	$data['2019/09/30'] = 'Criticool Machine';
    	$data['2022/12/27'] = 'MIRA Cradle';
    	$data['2022/12/27'] = 'Neoport Transport Unit';
    	ksort($data);
    	return view('nicu_time_line', compact('data'));
    }
}
