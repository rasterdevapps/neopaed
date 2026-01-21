<?php

namespace App\Http\Controllers\Flow;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Models\FlowControl;
use Session;
use Carbon\Carbon;
use App\Models\Nicu;
use App\Models\Neonatal;
use App\Models\Postnatal;
use App\User;
use App\Models\Baby;
use App\Models\PostnatalDischarge;
use App\Models\Daycare;
use App\Models\PostDaycare;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Models\Calender\AppointmentDetail;
use App\Models\Op;
use App\Models\Admission;
use App\Models\IpNumber;

class FlowController extends Controller
{

   /**
	* @var $auth type object
	*/
	public $auth;

   /**
    * @var $zone type string
    */
   public $zone;

    /**
    * @var $custom_error type object
    */
    public $custom_error;



   /**
    * Constructer Method 
    *
    */	
   public function __construct(Guard $auth, ErrorLogController $custom_error)
   {
   	$this->auth         = $auth;
   	$this->zone         = env('TIME_ZONE');
   	$this->custom_error = $custom_error;

   }

   public function index(Request $request)
   {

   	$results   = FlowControl::incompletelist();

   	$user_list = User::get()->pluck('name', 'id')->toArray();

   	foreach ($results as $key => &$value) {
   		$value = (array)$value;
   		$baby  = Baby::find($results[$key]->baby_id);
   		$baby_details['babyName'] = isset($baby->BabyName) ? $baby->BabyName : '';
   		$baby_details['BMrNo']    = isset($baby->BMrNo) ? $baby->BMrNo : '';
   		$results[$key] = array_merge((array)$results[$key], $baby_details);

   	}

   	return view('flowcontrol.list', compact('results', 'user_list'));

   }

   public function updaterecord(Request $request) 
   {
   	$input = $request->all();

   	$flow_contoller = FlowControl::whereIn('fcid',$input['mark_complete'])->update(['status'=>1]);

   	if ($flow_contoller) {
   		return redirect(action('Flow\FlowController@index'))->with('Success','Records updated successfully');

   	}

   	return redirect(action('Flow\FlowController@index'))->with('error','Records failed to update');



   }

   public function nurseFlowcontrol(Request $request) 
   {

   	$input = $request->all();

   	$flow_control['is_new_patient']   = (isset($input['nurse_registration']) && $input['nurse_registration'] == 'NEW_NURSE_REGISTRATION') ? true : false ;
   	$flow_control['admission_module'] =  $input['nurse_admission'];
   	$flow_control['current_module']   =  $input['nurse_admission'];
   	$flow_control['status']           =  false;
   	$flow_control['user_id']          =  $this->auth->user()->id;
   	$flow_control['start_date']       =  Carbon::now($this->zone)->format('Y-m-d');
   	$flow_control['complted_date']    =  null;

   	$flow_control['baby_id']          =  isset($input['baby_id'])      ? $input['baby_id'] : null ;
   	$flow_control['admission_id']     =  isset($input['admission_id']) ? $input['admission_id'] : null ;
   	$flow_control['resource_id']      =  null;

   	$fcid = FlowControl::create($flow_control)->fcid;

   	Session::put('registration_start', true);
   	Session::put('admission_module', $input['nurse_admission']);
   	Session::put('current_module', $input['nurse_admission']);
   	Session::put('ficd', $fcid);
   	Session::forget('initiate-flow');

   	if (isset($input['nurse_registration']) && isset($input['nurse_admission']) && $input['nurse_registration'] != '' && $input['nurse_admission'] != '') {

   		if ($input['nurse_registration'] == 'NEW_NURSE_REGISTRATION' && $input['nurse_admission'] == 'NURSE_NICU_ADMISSION') {

   			return redirect(action('Registration\NurseMotherController@create'));

   		} elseif($input['nurse_registration'] == 'OLD_NURSE_REGISTRATION' && $input['nurse_admission'] == 'NURSE_NICU_ADMISSION'){

   			return redirect(action('Registration\NurseBabyController@babylistnurse'));

   		}

   	}

   }

   /**
	* Initiate the flow control and settings 
	*
	*/
	public function flowControl(Request $request) 
	{ 
		$input = $request->all();

		if (!isset($input['admission'])) {
			return redirect(action('HomeController@index'))->with('error','Error in admission');
		}

		$flow_control['is_new_patient']   = (isset($input['registration']) && $input['registration'] == 'NEW_REGISTRATION') ? true : false ;
		$flow_control['admission_module'] =  $input['admission'];
		$flow_control['current_module']   =  $input['admission'];
		$flow_control['status']           =  false;
		$flow_control['user_id']          =  $this->auth->user()->id;
		$flow_control['start_date']       =  Carbon::now($this->zone)->format('Y-m-d');
		$flow_control['complted_date']    =  null;

		$flow_control['baby_id']          =  isset($input['baby_id'])      ? $input['baby_id'] : null ;
		$flow_control['admission_id']     =  isset($input['admission_id']) ? $input['admission_id'] : null ;
		$flow_control['resource_id']      =  null;

		$fcid = FlowControl::create($flow_control)->fcid;
		Session::put('registration_start', true);
		Session::put('admission_module', $input['admission']);
		Session::put('current_module', $input['admission']);
		Session::put('ficd', $fcid);
		Session::forget('initiate-flow');


		if ($input['registration'] == 'NEW_REGISTRATION'  && ($input['admission'] == 'NICU_ADMISSION' || $input['admission'] == 'POSTNATAL_ADMISSION')) {

			\Session::put('nicuform', 'basicform');
			\Session::forget('already_register_nurse');
			return redirect(action('Registration\MotherController@create'));

		} else if ($input['registration'] == 'ALREADY_REGISTRATER_NURSE'  && $input['admission'] == 'NICU_ADMISSION') {

			\Session::put('registration_start', false);
			\Session::put('already_register_nurse', true);
			return redirect(action('Registration\NeonatalController@chooseBaby'));

		} elseif ($input['registration'] == 'NEW_REGISTRATION' && $input['admission'] == 'PEDIATRIC_ADMISSION') {

			return redirect(url('pediatric-admission/'.\SiteHelpers::encrypt_id(0).'/create')); 

		} elseif ($input['registration'] == 'NEW_REGISTRATION' && $input['admission'] == 'OP_REGISTARATION') {

			return redirect(url('out-patient/create/'.\SiteHelpers::encrypt_id(0))); 

		} elseif ($input['registration'] == 'NEW_REGISTRATION' && $input['admission'] == 'PEDIATRIC_OP_REGISTARATION') {

			return redirect(url('pediatric-out-patient/create/'.\SiteHelpers::encrypt_id(0).'?closewinlink=flow')); 

		} elseif ($input['registration'] == 'NEW_REGISTRATION' && $input['admission'] == 'NEURO_OP_REGISTARATION') {

			return redirect(url('neuro-develop/create/'.\SiteHelpers::encrypt_id(0).'?closewinlink=flow')); 

		} elseif ($input['registration'] == 'OLD_REGISTRATION' && $input['admission'] == 'NICU_ADMISSION') {

			\Session::has('slug-nav') ? \Session::forget('slug-nav') : '';
			\Session::put('nicuform', 'basicform');
			return redirect(action('Admission\NicuController@chooseBaby'));

		} elseif ($input['registration'] == 'OLD_REGISTRATION' && $input['admission'] == 'POSTNATAL_ADMISSION') {

			return redirect(action('Admission\PostnatalController@create'));    

		} elseif ($input['registration'] == 'OLD_REGISTRATION' && $input['admission'] == 'PEDIATRIC_ADMISSION') {

			return redirect(url('pediatric-admission/'.\SiteHelpers::encrypt_id(0).'/create')); 

		} elseif ($input['registration'] == 'OLD_REGISTRATION' && $input['admission'] == 'OP_REGISTARATION') {

			return redirect(url('out-patient/select')); 

		}  elseif ($input['registration'] == 'OLD_REGISTRATION' && $input['admission'] == 'PEDIATRIC_OP_REGISTARATION') {

			return redirect(url('pediatric-out-patient/select')); 

		} elseif ($input['registration'] == 'OLD_REGISTRATION' && $input['admission'] == 'NEURO_OP_REGISTARATION') {

			return redirect(url('neuro-develop/select?closewinlink=flow')); 

		} elseif ($input['registration'] == 'OLD_REGISTRATION' && $input['admission'] == 'NICU_DISCHARGE') {

			$nicu_admission = Nicu::getNicuAdmission($input['admission_id'], $input['baby_id']);
          	    //  \Session::put('nicuform','dischargeform');
          	    //  \Session::put('slug-nav',true);
			return redirect(action('Admission\NicuController@dischargeedit',\SiteHelpers::encrypt_id($nicu_admission->NicuId) )); 

		} elseif ($input['registration'] == 'OLD_REGISTRATION' && $input['admission'] == 'POSTNATAL_DISCHARGE') {

			$postnatal_admission = PostnatalDischarge::getPostanatalDischargeeDetails($input['baby_id'],$input['admission_id']);
			return redirect(action('Admission\PostnatalDischargeController@edit',\SiteHelpers::encrypt_id($postnatal_admission->posdisid))); 

		} elseif ($input['registration'] == 'OLD_REGISTRATION' && $input['admission'] == 'NICU_DAILY_CARE') {

			return redirect(action('Admission\DaycareController@create'));

		}	elseif($input['registration'] == 'OLD_REGISTRATION' && $input['admission'] == 'POSTNATAL_DAILY_CARE') {

			return redirect(action('Admission\PostnatalDaycareController@create'));

		} elseif($input['registration'] == 'OLD_REGISTRATION' && $input['admission'] == 'NICU_TRANSFER_DISCHARGE') {
	          // nicu to postnatal transfer
	          	//     $nicu_admission           = Nicu::getNicuAdmission($input['admission_id'], $input['baby_id']);
	          	//     $nicu_discharge['status'] = 'Transferred';
	          	//     $nicu_discharge['DischargeDate'] = Carbon::now()->format('Y-m-d');
	          	//     $nicu_discharge_status = Nicu::find($nicu_admission->NicuId);
	          	//     $nicu_discharge  = (array)$nicu_discharge;

	          	//     $baby           = Admission::getBabyAdmission($input['admission_id'], $input['baby_id']);
	          	//     $baby_admission['Status'] = 'Transferred';
	          	//     $baby_admission_status = Admission::find($baby->AdmissionId);

	          	//     $baby_admission  = (array)$baby_admission;

	          	//     if (count($nicu_discharge_status) > 0) {
	          	//     	$nicu_discharge_status->Update($nicu_discharge);
	          	//     	$baby_admission_status->Update($baby_admission);
	          	//     } else {
	          	//     	$this->custom_error->emergencyLog('nicu to postnatal transfer issuse with admissionid ='.$input['admission_id'].' baby id '.$input['baby_id'].' on user id '.$this->auth->user()->email);
	          	//     	throw new \InvalidInputException("Invalid admission found");
	          	//     }

	          	//     $slug = $input['baby_id'].'-'.$input['admission_id'];

	          	// return redirect(action('Admission\PostnatalController@show',\SiteHelpers::encrypt_id($slug))); 


			$nicu_admission = Nicu::getNicuAdmission($input['admission_id'], $input['baby_id']);
			return redirect(action('Admission\NicuController@dischargeedit',\SiteHelpers::encrypt_id($nicu_admission->NicuId)).'?module=transfertopostnatal'); 

		} elseif($input['registration'] == 'OLD_REGISTRATION' && $input['admission'] == 'POSTNATAL_TRANSFER_DISCHARGE') {
     //      	    $postnatal_admission = PostnatalDischarge::getPostanatalDischargeeDetails($input['baby_id'],$input['admission_id']);

     //            $postnatal_discharge['discharge_status'] = 'Transferred';
	    //       	$postnatal_discharge['discharge_date']   = Carbon::now()->format('Y-m-d');
	    //       	$postnatal_discharge_status = PostnatalDischarge::find($postnatal_admission->posdisid);
	    //       	$postnatal_discharge  = (array)$postnatal_discharge;

	    //       	$baby           = Admission::getBabyAdmission($input['admission_id'], $input['baby_id']);
	    //       	$baby_admission_post['Status'] = 'Transferred';
	    //       	$baby_admission_status = Admission::find($baby->AdmissionId);
	    //       	$baby_admission_post  = (array)$baby_admission_post;

	    //       	$check_postnatal_bed_log = \DB::table('patient_bed_log')
     //                            ->where('baby_id', $input['baby_id'])
     //                            ->where('admission_id', $input['admission_id'])
     //                            ->where('ward_name', 'Postnatal')
     //                            ->where('status', 'Occupied')
     //                            ->first();

	    //         if (count($check_postnatal_bed_log) != 0 && isset($check_postnatal_bed_log->id)) {
	    //             \DB::table('patient_bed_log')->where('id', $check_postnatal_bed_log->id)->update(['status' => 'discharged']);
	    //             \DB::table('bed')->where('id', $check_postnatal_bed_log->bed_id)->update(['status' => null]);
	    //         }

	    //       	if (isset($input['nicu_bed']) && !empty($input['nicu_bed'])) {
	    //       		$check_bed_log = \DB::table('patient_bed_log')
	    //       						->where('baby_id', $input['baby_id'])
	    //       						->where('status', 'Occupied')
	    //       						->first();
	    //       		if (count($check_bed_log) != 0 && isset($check_bed_log->id)) {
	    //       			if ($check_bed_log->bed_id == $input['nicu_bed']) {
	    //       				\DB::table('patient_bed_log')->where('id', $check_bed_log->id)->update(['status' => 'Occupied']);
	    //       				\DB::table('bed')->where('id', $check_bed_log->bed_id)->update(['status' => 'Occupied']);
	    //       			}
	    //       			else
	    //       			{
	    //       				$get_bed_details = \DB::table('bed')
	    //       					->select('room.id as room_id','room.number as room_no','ward.name as ward_name', 'ward.id as ward_id', 'bed.id as bed_id', 'bed.number as bed_no')
	    //                         ->join('room', 'room.id', '=', 'bed.room_id')
	    //                         ->join('ward', 'ward.id', '=', 'room.ward_id')
	    //                         ->where('bed.id', $input['nicu_bed'])
	    //                         ->first();
	    //                     $bed_update = array(
	    //                     	'bed_id' => $input['nicu_bed'],
	    //                     	'bed_no' => $get_bed_details->bed_no,
	    //                     	'ward_name' => $get_bed_details->ward_name,
	    //                     	'ward_id' => $get_bed_details->ward_id,
	    //                     	'room_id' => $get_bed_details->room_id,
	    //                     	'room_no' => $get_bed_details->room_no,
	    //                     	'status' => 'Occupied',
	    //                     	'admission_id' => $input['admission_id']

	    //                     );
	    //                     \DB::table('patient_bed_log')->where('id', $check_bed_log->id)->update($bed_update);
	    //       				\DB::table('bed')->where('id', $check_bed_log->bed_id)->update(['status' => 'Occupied']);
	    //       			}
	    //       		}
	    //       		else
	    //       		{
	    //       			$get_bed_details = \DB::table('bed')
	    //       					->select('room.id as room_id','room.number as room_no','ward.name as ward_name', 'ward.id as ward_id', 'bed.id as bed_id', 'bed.number as bed_no')
	    //                         ->join('room', 'room.id', '=', 'bed.room_id')
	    //                         ->join('ward', 'ward.id', '=', 'room.ward_id')
	    //                         ->where('bed.id', $input['nicu_bed'])
	    //                         ->first();
	    //       			$bed_insert = array(
     //                    	'bed_id' => $input['nicu_bed'],
     //                    	'bed_no' => $get_bed_details->bed_no,
     //                    	'ward_name' => $get_bed_details->ward_name,
     //                    	'ward_id' => $get_bed_details->ward_id,
     //                    	'room_id' => $get_bed_details->room_id,
     //                    	'room_no' => $get_bed_details->room_no,
     //                    	'status' => 'Occupied',
     //                    	'baby_id' => $input['baby_id'],
     //                    	'admission_id' => $input['admission_id'],
     //                    	'DateAdded' => date('Y-m-d H:i:s'),
     //                    	'DateModified' => date('Y-m-d H:i:s'),
     //                    	'UserAdded' => \Auth::user()->id,
     //                    	'UserModified' => \Auth::user()->id
     //                    );
     //                    \DB::table('patient_bed_log')->insert($bed_insert);
     //      				\DB::table('bed')->where('id', $input['nicu_bed'])->update(['status' => 'Occupied']);
	    //       		}
	    //       	}
	    //       	 if (count($postnatal_discharge_status) > 0) {
	    //       	    $postnatal_discharge_status->Update($postnatal_discharge);
	    //       	    // $baby_admission_status->Update($baby_admission_post);

	    //       	 } else {
	    //       	    $this->custom_error->emergencyLog('postnatal to nicu transfer issuse with admissionid ='.$input['admission_id'].' baby id '.$input['baby_id'].' on user id '.$this->auth->user()->email);
	    //       	    throw new \InvalidInputException("Invalid admission found");
	    //       	 }
     //                \Session::put('nicuform','basicform');
					// \Session::forget('slug-nav');

	    //       	$slug = $input['baby_id'].'-'.$input['admission_id'];
	    //       	return redirect(action('Admission\NicuController@create',\SiteHelpers::encrypt_id($slug))); 

			$postnatal_admission = PostnatalDischarge::getPostanatalDischargeeDetails($input['baby_id'],$input['admission_id']);
			return redirect(action('Admission\PostnatalDischargeController@edit',\SiteHelpers::encrypt_id($postnatal_admission->posdisid)).'?module=transfertonicu&bed_id='.$input['nicu_bed']); 

		} 

	}


   /**
	* Method To Log flow admission
	*
	* @param $currentModule type string 
	*
	* @param $baby_id type integer
    *
    * @param $mother_id type integer 
    *
    * @param $admission_id type integer
    *
    * @param $status type boolean
	*/
	public function flowlog($currentModule, $baby_id = null, $mother_id = null, $admission_id = null, $status = false, $menu = null, $resource_id = null, $multiple_pregnancy = null)
	{


		if (Session::has('registration_start')) {

			Session::put('current_module', $currentModule);
			$flow_control['admission_module']   =  Session::get('admission_module');
			$flow_control['current_module']     =  Session::get('current_module');
			$flow_control['status']             =  $status;
			$flow_control['user_id']            =  $this->auth->user()->id;
			$flow_control['baby_id']            =  $baby_id;
			$flow_control['mother_id']          =  $mother_id;
			$flow_control['admission_id']       =  $admission_id;
			$flow_control['complted_date']      =  $status ?  Carbon::now($this->zone)->format('Y-m-d') : null;
			$flow_control['menu_name']          =  $menu; 
			$flow_control['resource_id']        =  $resource_id;
			$flow_control['multiple_pregnancy'] =  $multiple_pregnancy;


			$flow = FlowControl::find(Session::get('ficd'));
			if (count($flow) > 0) {
				$flow->Update($flow_control);
			}


		}


		return true;
	}

	/**
	 * Method to resume the flow 
	 *
	 *@param $id type integer resource id 
	 */
	public function resumeFlow($id) 
	{
		$flow = FlowControl::find($id);

		Session::put('registration_start', true);
		Session::put('admission_module', $flow->admission_module);
		Session::put('current_module', $flow->current_module);
		Session::put('ficd', $flow->fcid);

		switch ($flow->current_module) {

			case 'NURSE_NICU_ADMISSION':
			return redirect(action('Registration\NurseMotherController@create'));
			break;

			case 'NURSE_MOTHER_REG':
			return redirect(action('Registration\NurseMotherController@edit', $flow->mother_id));
			break;
			case 'NURSE_BABY_REGISTRATION':
			return redirect(action('Registration\NurseBabyController@create',$flow->mother_id));
			break;
			case 'NURSE_BABY_REG':
			return redirect(action('Registration\NurseBabyController@edit',$flow->baby_id));
			break;

			case 'MOTHER_REG':
			return redirect(action('Registration\MotherController@edit', \SiteHelpers::encrypt_id($flow->mother_id)));
			break;
			case 'BABY_REG':
			return redirect(action('Registration\BabyController@edit', \SiteHelpers::encrypt_id($flow->baby_id)));
			break;
			case 'NEONATAL': 
			$neonatal = Neonatal::where('BabyId', $flow->baby_id)
			->select('NeonatalId')
			->first();
			$flow->menu_name = (!is_null($flow->menu_name)) ? $flow->menu_name : 'babyform';               
			setcookie('neonatenext', $flow->menu_name, 0, '/');
			return redirect(action('Registration\NeonatalController@edit', \SiteHelpers::encrypt_id($neonatal->NeonatalId)));
			break;
			case 'NICU_FORM':
			$nicu =  Nicu::where('BabyId', $flow->baby_id)
			->where('MotherId', $flow->mother_id)
			->where('AdmissionId', $flow->admission_id)
			->select('NicuId')
			->first();
			$flow->menu_name = (!is_null($flow->menu_name)) ? $flow->menu_name : 'basicform';               
			setcookie('nicu-next', $flow->menu_name, 0, '/');               
			return redirect(action('Admission\NicuController@edit', \SiteHelpers::encrypt_id($nicu->NicuId)));
			break;
			case 'NICU_ADMISSION':

			if ($flow->is_new_patient == true) {
				return redirect(action('Registration\MotherController@create'));	
			}else {
				isset($_COOKIE['nicu-next']) ? setcookie("nicu-next", "", time() - 3600) : '';
				return redirect(action('Admission\NicuController@chooseBaby'));
			}

			break;
			case 'POSTNATAL_ADMISSION':
			if ($flow->is_new_patient == true) {
				return redirect(action('Registration\MotherController@create'));	
			}else {
				return redirect(action('Admission\PostnatalController@create'));
			}

			break;
			case 'POST_FORM':
			$postnatal = Postnatal::where('BabyId', $flow->baby_id)
			->where('MotherId', $flow->mother_id)
			->where('AdmissionId', $flow->admission_id)
			->select('pid')
			->first();

			return  redirect(action('Admission\PostnatalController@edit', \SiteHelpers::encrypt_id($postnatal->pid)));           
			break;
			case 'OP_REGISTARATION':

			if ($flow->is_new_patient == true) {
				$flow->menu_name = (!is_null($flow->menu_name)) ? $flow->menu_name : 'babyform';               
				setcookie('op-next', $flow->menu_name, 0, '/'); 

				return redirect(action('Registration\OpController@create'));	
			} else {
				return redirect(action('Registration\OpController@chooseBaby'));	
			}		

			break;
			case 'NICU_DAILY_CARE':
			if (isset($flow->resource_id) && !empty($flow->resource_id)) {
				return redirect(action('Admission\DaycareController@edit', \SiteHelpers::encrypt_id($flow->resource_id)));
			} 
			if (isset($flow->baby_id) && !empty($flow->baby_id) && isset($flow->admission_id) && !empty($flow->admission_id)) {
				$dayid = Daycare::getDaydetails($flow->baby_id, $flow->admission_id);
				return redirect(action('Admission\DaycareController@edit', \SiteHelpers::encrypt_id($dayid->DayId)));
			}

			return redirect(action('Admission\DaycareController@create'));
			break;
			case 'POSTNATAL_DAILY_CARE':

			if(isset($flow->resource_id) && !empty($flow->resource_id)) {
				return redirect(action('Admission\PostnatalDaycareController@edit', \SiteHelpers::encrypt_id($flow->resource_id)));
			}

			if(isset($flow->baby_id) && !empty($flow->baby_id) && isset($flow->admission_id) && !empty($flow->admission_id)) {
				$pday_id = PostDaycare::getPostnataldailydetails($flow->baby_id, $flow->admission_id);
				return redirect(action('Admission\PostnatalDaycareController@edit', \SiteHelpers::encrypt_id($pday_id->PDayId)));
			}

			return redirect(action('Admission\PostnatalDaycareController@create'));
			break;
			case 'NICU_DISCHARGE':
			$nicu_admission = Nicu::getNicuAdmission($flow->admission_id, $flow->baby_id);
			\Session::put('nicuform','dischargeform');
			\Session::put('slug-nav',true);
			return redirect(action('Admission\NicuController@dischargeedit',\SiteHelpers::encrypt_id($nicu_admission->NicuId ))); 
			break;
			case 'POSTNATAL_DISCHARGE':
			$postnatalDischarge = PostnatalDischarge::where('BabyId', $flow->baby_id)
			->where('AdmissionId', $flow->admission_id)
			->select('posdisid')
			->first();
			return  redirect(action('Admission\PostnatalDischargeController@edit', \SiteHelpers::encrypt_id($postnatalDischarge->posdisid)));
			break;
			case 'OP_REG':
			if ($flow->is_new_patient == true && $flow->resource_id != '') {

				$flow->menu_name = (!is_null($flow->menu_name)) ? $flow->menu_name : 'babyform';               
				setcookie('op-next', $flow->menu_name, 0, '/'); 
				return redirect(action('Registration\OpController@edit', \SiteHelpers::encrypt_id($flow->resource_id)));	

			} elseif($flow->is_new_patient != true && $flow->resource_id != '') {

				$flow->menu_name = (!is_null($flow->menu_name)) ? $flow->menu_name : 'babyform';               
				setcookie('op-next', $flow->menu_name, 0, '/'); 
				return redirect(action('Registration\OpController@edit', \SiteHelpers::encrypt_id($flow->resource_id)));	

			} else {
				return redirect(action('Registration\OpController@chooseBaby'));	
			}


			break;

			default:
			return view('errors.406');
			break;
		}


	}

   /**
	* Method To Clear the session 
	*/
	public function clearFlow() 
	{
		Session::has('registration_start')  ? Session::forget('registration_start') : '' ;
		Session::has('admission_module')    ? Session::forget('admission_module')   : '' ;
		Session::has('current_module')      ? Session::forget('current_module')     : '' ;
		Session::has('ficd')                ? Session::forget('ficd')               : '' ;
		Session::has('initiate-flow')       ? Session::forget('initiate-flow')      : '' ;

		Session::has('multiple_pregnancy')  ? Session::forget('multiple_pregnancy') : '' ;
		Session::has('no_of_babies')        ? Session::forget('no_of_babies')       : '' ;
		Session::has('baby_group_id')       ? Session::forget('baby_group_id')      : '' ;

		return \Response::json(['status'=>true], 200);

	}

	/**
	* Method To Clear the session 
	*/
	public function completeflow()
	{
		$flow_control['status']           =  true;
		$flow_control['complted_date']    = Carbon::now($this->zone)->format('Y-m-d');
		$flow = FlowControl::find(Session::get('ficd'));
		if (count($flow) > 0) {
			$flow->Update($flow_control);
		}  

		Session::has('registration_start')  ? Session::forget('registration_start') : '' ;
		Session::has('admission_module')    ? Session::forget('admission_module')   : '' ;
		Session::has('current_module')      ? Session::forget('current_module')     : '' ;
		Session::has('ficd')                ? Session::forget('ficd')               : '' ;
		Session::has('initiate-flow')       ? Session::forget('initiate-flow')      : '' ;

		return \Response::json(['status'=>true], 200);
	}

	/**
	 * Method to edit the appointments
	 */
	public function patientDetailEdit($id)	{

        	$detail = AppointmentDetail::getAppDetails($id);

        	if (isset($detail['Mobile']) || isset($detail['LandLine']) || isset($detail['PartnerContact']) || isset($detail['PartnerMobile'])) {
	        	$numbers['Mobile'] = $detail['Mobile'];
	        	$numbers['LandLine'] = $detail['LandLine'];
	        	$numbers['PartnerContact'] = $detail['PartnerContact'];
	        	$numbers['PartnerMobile'] = $detail['PartnerMobile'];
	        	$numbers = array_filter($numbers);
	        	$detail['numbers'] = implode(', ', $numbers);
	        }

	        if (isset($detail['appointment_date'])) {
        	$detail['appointmentDate'] = date('d-m-Y', strtotime($detail['appointment_date']));
        }

        return \Response::json(['status' => 'Success','appointment_detail' => $detail]);
	}
	
	/**
	 * Method to update the appointments
	 */
	public static function patientDetailUpdate(Request $request, $id)
	{
			$input = $request->all();
			if (isset($input['from']) && $id == 0) {
				if (isset($input['consultant'])) {
					$detail = AppointmentDetail::checkAppointment($input['ref_id'], $input['from'], $input['consultant']);
				} else {
					$detail = AppointmentDetail::checkAppointment($input['ref_id'], $input['from']);					
				}
				$id = isset($detail->id) ? $detail->id : $id;  
			}
			$detail = AppointmentDetail::find($id);  

			if (isset($input['category']) && !empty($input['category'])) {
				$patientdetail['category'] = $input['category'];
			}			
			if (isset($input['date']) && !empty($input['date'])) {
				$patientdetail['appointment_date'] = date('Y-m-d', strtotime($input['date']));
			}
			if (isset($input['time']) && !empty($input['time'])) {
				$patientdetail['appointment_time'] = $input['time'];
			}
			if (isset($input['mins'])) {
				$patientdetail['appointment_min'] = $input['mins'];
			}
			if (isset($input['session']) && !empty($input['session'])) {
				$patientdetail['appointment_session'] = $input['session'];
			}
			if (isset($input['from']) && !empty($input['from'])) {
				$patientdetail['module_id'] = $input['from'];
			}
			if (isset($input['ref_id']) && !empty($input['ref_id'])) {
				$patientdetail['ref_id'] = $input['ref_id'];
			}
			if (isset($input['patient']) && !empty($input['patient'])) {
				if (is_numeric($input['patient'])) {
					$patientdetail['baby_id'] = $input['patient'];
				} else {
					$patientdetail['baby_name'] = $input['patient'];
				}
			}
			if (isset($input['consultant']) && !empty($input['consultant'])) {
				$patientdetail['seen_by'] = $input['consultant'];
			}
			if (!isset($input['cancel'])) {
				if (isset($input['reason']) && !empty($input['reason'])) {
					$patientdetail['reason'] = $input['reason'];
				}
				if (isset($input['appointmentDate'])) {
					$patientdetail['modified_appointment_date'] = date('Y-m-d', strtotime($input['appointmentDate']));
				}
				if (isset($input['newTime'])) {
					$patientdetail['modified_appointment_time'] = $input['newTime'];
				}
				if (isset($input['newMins'])) {
					$patientdetail['modified_appointment_min'] = $input['newMins'];
				}
				if (isset($input['newSession'])) {
					$patientdetail['modified_appointment_session'] = $input['newSession'];
				}
			}
			if (isset($input['cancel'])) {
				$patientdetail['is_cancel'] = true;
			}

			if(isset($detail->id)) {
				$patientdetail['modified_date_time'] = Carbon::now();
				$patientdetail['modified_user_id'] = \Auth::user()->id;
				$detail->update($patientdetail);
				return \Response::json(['success' => 'Appointment Updated Successfully']);        			
			} else {
				$patientdetail['created_date_time'] = Carbon::now();
				$patientdetail['created_user_id'] = \Auth::user()->id;
				AppointmentDetail::create($patientdetail);        
				return \Response::json(['success' => 'Appointment Created Successfully']);
			}
	}

	/**
	 * Method to register baby in NICU ward
	 */
	public function wardBasicReg(Request $request) {
		$input = $request->all();

		$baby_mrn = $input['baby_mrn'];
		$baby_id = $input['baby_id'];
		$mother_mrn = $input['mother_mrn'];
		$mother_id = $input['mother_id'];
		$ip_number = $input['baby_ip_number'];

		setcookie('motherMrn', $mother_mrn, 0, '/');
		setcookie('motherId', $mother_id, 0, '/');
		setcookie('babyMrn', $baby_mrn, 0, '/');
		setcookie('babyIpNumber', $ip_number, 0, '/');
		setcookie('babyNurseUpdate', $baby_id, 0, '/');

		return action('Registration\NurseMotherController@edit', $mother_id);

	}

}
