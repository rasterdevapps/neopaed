<?php 
namespace App\Http\Controllers\admission;

use Carbon\Carbon;
use App\Models\PostDaycare;
use App\Models\Baby;
use App\Models\Neonatal;
use App\Models\Masters\AutoTagMasters;
use App\Models\Settings\DeleteApproval;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Requests;
use App\Models\Admission;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admissions\PostdayRequest;
use Illuminate\Http\Request;
use App\Models\Postnatal;
use App\Models\Icd;
use App\Http\Controllers\Flow\FlowController;
use App\Models\Reports\NicuDischarge;
use App\Models\IpNumber;

class PostnatalDaycareController extends Controller 
{
	/**
	 * This for auth instance 
	 *
	 * @var $auth
	 */
	public $auth;

	/**
	 * This for flow instance
	 *
	 * @var $flow
	 */
	 public $flow;

	/**
	 * This for auto suggestion values
	 * 
	 * @var $auto_tag_fields
	 */
	public  $auto_tag_fields;

	/**
	 * This for time zone
	 *
	 * @var $time_zone
	 */
	 public $time_zone;
     
     /**
      * This method class constructor
      * 
      * @param instance of $auth
      *
      * @param instance of $flow
      *
      */
	 public function __construct(Guard $auth, FlowController $flow)
	 {
		$this->middleware('role:POST_DAY,write', ['only'=>['store','update','edit','create','show','destroy']]);
		$this->middleware('role:POST_DAY,read', ['only'=>['index','printData']]);	
		$this->auth            = $auth;
		$this->auto_tag_fields = array('Background','CurrentProblems','PreviousProblems','Notes','Plan','OtherFindings');
	  	$this->post_daycare    = new PostDaycare(); 
	   $this->flow            = $flow;
	   $this->time_zone       = env('TIME_ZONE');

	}
	/**
	 * List the daycare data
	 *
	 * @param $request instance of Request Class
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{

		$input = $request->all();
		$limit = isset($input['limit']) ? $input['limit'] : 10;

        $page = !empty($request->input('page')) ? $request->input('page') : 1;
        $page = preg_replace( '/[^0-9]/', '', $page);

		 $navigate['main_nav'] = 'postnatal';
		$navigate['sub_nav'] = 'post_daycare';

      $order['sortby']    = isset($input['sortby'])    ? \SiteHelpers::decrypt_id($input['sortby'])   : 'BMrNo';
      $order['sortorder'] = isset($input['sortorder']) ? $input['sortorder'] : 'desc';

      $search['search_txt'] = isset($input['search_txt']) ? $input['search_txt'] : '';

        $status = !empty($request->input('status')) ? $request->input('status') : 'inpatient';
		$result   = PostDaycare::get_lists($page, $limit, $search, $order, 1, $status); 
	   $results  = $result['result'];

      $getTotal = PostDaycare::getTotal();
	   $total    = $result['total'];	

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

		return view('postnatal_daycare.list', compact('results', 'navigate', 'pagination', 'order', 'search', 'getTotal'));
	}

	/**
	 * List the daycare sub list 
	 *
	 * @param $id baby id 
	 *
	 * @return Response
	 */
	public function postnatalSublist($id)
	{
		 $BabyId = \SiteHelpers::decrypt_id($id);
		 $navigate['main_nav'] = 'postnatal';
		 $navigate['sub_nav'] = 'post_daycare';
		 $results = $this->post_daycare->get_postanatal_sublist($BabyId);
		 $baby_name = isset($results[0]->BabyName) ? $results[0]->BabyName : '';
         return view('postnatal_daycare.admission_lists', compact('results', 'navigate', 'baby_name'));

	}

	/**
	 * This method postnatal daywise list 
	 * 
	 * @param $id encrypted string 
	 *
	 * @return Response 
	 */
	public function postnatalDaywiselist($id)
	{
		$navigate['main_nav'] = 'postnatal';
		$navigate['sub_nav'] = 'post_daycare';

		$ids = \SiteHelpers::decrypt_id($id);

		if (stripos($ids, '-') > 0) {

			$get_ids=explode('-', $ids);
			$admission_id = $get_ids[0];
			$baby_Id      = $get_ids[1];
			// $baby_details = Admission::getBabyMrn($admission_id);
			$baby_details = PostDaycare::getBabyDetails($admission_id);
			$results      = $this->post_daycare->get_postanatal_day_list($admission_id, $baby_Id);
			

			// $baby_name = isset($results[0]->BabyName) ? $results[0]->BabyName : '';
			// $admission = isset($results[0]->episodes) ? $results[0]->episodes : '';
			// $baby_id = isset($results[0]->BabyId) ? $results[0]->BabyId : '';

			$baby_name = $baby_details->BabyName;
			$admission = $baby_details->episodes;
			$baby_id = $baby_details->BabyId;
            
            return view('postnatal_daycare.postanatal_day_wise_lists', compact('results', 'baby_name', 'navigate', 'admission', 'baby_id', 'baby_details')); 

         }
	}

	/**
	 * This method create view 
	 * 
	 * @return Response to view 
	 */
	public function create()
	{
		$navigate['main_nav'] = 'postnatal';
		$navigate['sub_nav'] = 'post_daycare';

				
		$baby =  Neonatal::getInpatients();
		$babies = array();
		foreach ($baby as $data) {
			$data->BMrNo = empty($data->BMrNo) ? $data->BMrNo : '-'.$data->BMrNo;
			$babies[\SiteHelpers::encrypt_id($data->NeonatalId)] = $data->BabyName.$data->BMrNo;
		}
		$SubmitButtonText  = "Start";

		return view('postnatal_daycare.select_patient', compact('SubmitButtonText', 'babies', 'navigate'));
	}

	/**
	 * This method get admission  
	 * 
	 * @return Response via json 
	 */
	public function get_admissions($id)
	{

		$NeonatalId    = \SiteHelpers::decrypt_id($id);
		$results       = Baby::getBabyadmissionList($NeonatalId);
        $admissionlist = array();
		if (count($results)>0) {
		  foreach ($results as $key => $value) {
			  	if (!empty($value->AdmissionId) && !empty($value->BabyId)) {
					$admissionlist[\SiteHelpers::encrypt_id($NeonatalId.'-'.$value->AdmissionId.'-'.$value->BabyId)] = $value->episodes;
            }
	      }
			return \Response::json(['data'=>$admissionlist], 200);
		}

		return \Response::json(['data'=>''], 200);
	}



	/**
	 * Store a newly created record
	 *
	 */
	public function store(PostdayRequest $request)
	{
		$input = $request->all();
		$print_flag = isset($input['print_flag'])?$input['print_flag']:0;
		unset($input['print_flag']);


		$input['SeenBy'] = (!empty($input['SeenBy']) && !is_null($input['SeenBy']))  ?  $input['SeenBy']  :  null;
		$input['DayOfLife'] = (!empty($input['DayOfLife']) && !is_null($input['DayOfLife'])) ? $input['DayOfLife'] : null;


		AutoTagMasters::auto_key_support($this->auto_tag_fields, $input);

		$input['differentialdiagnosis'] = (isset($input['differentialdiagnosis']) && count($input['differentialdiagnosis']) > 0 ) ?  json_encode($input['differentialdiagnosis']) : null;
		$input['additional_diagnosis']  = (isset($input['additional_diagnosis']) && count($input['additional_diagnosis']) > 0 )  ?  json_encode($input['additional_diagnosis'])  : null;

		$input['Dayhours'] = (isset($input['Dayhours']) && strlen($input['Dayhours'])==1) ? '0'.$input['Dayhours'] : $input['Dayhours'] ;
		$input['Daymins']  = (isset($input['Daymins']) && strlen($input['Daymins'])==1) ? '0'.$input['Daymins'] : $input['Daymins'] ;
		$input['DayTime']  = $input['Dayhours'].':'.$input['Daymins'].' '.$input['Dayam_pm'];
		$input['DayTime']  = (string)$input['DayTime'];
		unset($input['Dayhours']);
		unset($input['Daymins']);
		unset($input['Dayam_pm']);
		$input['examination_normal'] = (isset($input['examination_normal']) &&  $input['examination_normal'] =='on') ? true :false;



		$input['DOB'] = (isset($input['DOB']) && $input['DOB'] != '') ? date('Y-m-d', strtotime($input['DOB'])) : null;

		$input['UserModified']      =  $this->auth->user()->id;
		$input['DateModified']      =  Carbon::now($this->time_zone);

		$baby = Baby::findOrfail($input['BabyId']);

		$baby_details = $input;

		unset($baby_details['Background']);

		$baby->update($baby_details);

		if ($input['AdmissionId'] == 0) {
			  $admissions= \DB::table('baby_admission')->where('BabyId', $input['BabyId'])->count();
			  $admission_details['BabyId']		   =  $input['BabyId'];
			  $admission_details['BMrNo']  		   =  $baby['BMrNo'];
			  $admission_details['MotherId']       =  $baby['MotherId'];
			  $admission_details['AdmissionTime']  =  $input['DayTime'];
			  $admission_details['AdmissionDate']  =  Carbon::now($this->time_zone);
			  $admission_details['InOrOut']        =  'Out';
			  $admission_details['AdmissionType']  =  'Postnatalstay';
			  $admission_details['Status']         =  'Outpatient';
			  $admission_details['UserAdded']      =  $this->auth->user()->id;
			  $admission_details['DateAdded']      =  Carbon::now($this->time_zone);
			  $admission_details['episodes']       =  'Admission '.($admissions+1);
			  $admission_details['DateModified']   =  Carbon::now($this->time_zone);
			  $input['AdmissionId'] = Admission::create($admission_details)->AdmissionId;
		}


		if (isset($input['postnatal_antiboitic']) && count($input['postnatal_antiboitic']) > 0) {

		$postnatal_antiboitic = array(); 
		foreach ($input['postnatal_antiboitic'] as $key => $value) {
	      if (isset($input['postnatal_antiboitic'][$key]) && !empty($input['postnatal_antiboitic'][$key])) {
	         $postnatal_antiboitic[$key]['postnatal_antiboitic']     = $input['postnatal_antiboitic'][$key];
	 	  		$postnatal_antiboitic[$key]['postnatal_antiboitic_day'] = $input['postnatal_antiboitic_day'][$key]; 
	      }
		}
		$input['postnatal_antiboitic'] = json_encode($postnatal_antiboitic);

		} 
		else {
		   $input['postnatal_antiboitic'] = null;
		}


		$input['postnatal_other_drugs'] = (isset($input['postnatal_other_drugs']) && count($input['postnatal_other_drugs']) > 0) ? json_encode($input['postnatal_other_drugs']) : null;

		$input['postnatal_organism'] = (isset($input['postnatal_organism']) && count($input['postnatal_organism']) > 0) ? json_encode($input['postnatal_organism']) : null; 
		$input['DayDate'] = date('Y-m-d', strtotime($input['DayDate']));

        $prev_daycare_status = PostDaycare::where(['BabyId' => $input['BabyId'], 'AdmissionId' => $input['AdmissionId'], 'IsDeleted' => 0, 'DayDate' => $input['DayDate']])->first();

        if (count($prev_daycare_status) > 0) {
            $prev_daycare_status->update($input);
            $daycare = $prev_daycare_status;
        } else {
			$input['UserAdded'] = $this->auth->user()->id;
			$input['DateAdded'] = Carbon::now($this->time_zone);
			$daycare = PostDaycare::create($input);
        }

		$module =  \Session::has('admission_module') ? \Session::get('admission_module') : 'POSTNATAL_DAILY_CARE';
		$menu   =  isset($_COOKIE['postnataldaycare']) ? $_COOKIE['postnataldaycare'] : 'generalform';

		if ($request->ajax()) {
		   return \Response::json(['type' => 'success', 'message' => 'Postnatal daycare details created successfully !', 'edit_url' => action('Admission\PostnatalDaycareController@edit', \SiteHelpers::encrypt_id($daycare->PDayId)), 'list_url' => action('Admission\PostnatalDaycareController@postnatalDaywiselist', \SiteHelpers::encrypt_id($input['AdmissionId'].'-'.$input['BabyId'])), 'print_url'=> action('Admission\PostnatalDaycareController@printData', \SiteHelpers::encrypt_id($daycare->PDayId))], 200);
		}

		if ($print_flag == 0) {

			$this->flow->flowlog($module, $input['BabyId'], $baby['MotherId'], $input['AdmissionId'], false, $menu, $daycare->PDayId);
			return redirect(action('Admission\PostnatalDaycareController@edit', \SiteHelpers::encrypt_id($daycare->PDayId)))->with('Success', 'Record saved successfully');
		
		} elseif ($print_flag == 1) {

			$this->flow->flowlog($module, $input['BabyId'], $baby['MotherId'], $input['AdmissionId'], true, $menu, $daycare->PDayId);
			return redirect(action('Admission\PostnatalDaycareController@postnatalSublist', \SiteHelpers::encrypt_id($daycare->BabyId)))->with('Success', 'Record saved successfully');

		} elseif ($print_flag == 2) {

			$this->flow->flowlog($module, $input['BabyId'], $baby['MotherId'], $input['AdmissionId'], false, $menu, $daycare->PDayId);
			return redirect(action('Admission\PostnatalDaycareController@printData', \SiteHelpers::encrypt_id($daycare->PDayId)))->with('Success', 'Record saved successfully');

		} else {

			$this->flow->flowlog($module, $input['BabyId'], $baby['MotherId'], $input['AdmissionId'], true, $menu, $daycare->PDayId);
			return redirect(action('Admission\PostnatalDaycareController@postnatalDaywiselist', \SiteHelpers::encrypt_id($input['AdmissionId'].'-'.$input['BabyId'])))->with('Success', 'Record saved successfully');
		}
	}

	/**
	 * Show the form for creating a new daycare of the selected baby
	 *
	 * @param  int  $id
	 */
	public function show($id)
	{
		$navigate['main_nav'] = 'postnatal';
		$navigate['sub_nav'] = 'post_daycare';

      
		

        $ids  = \SiteHelpers::decrypt_id($id);
        $discharge_medications = [];
         if (strpos($ids, '-') > 0) {
         	$get_ids= explode('-', $ids);
         	$neonatalId  =$get_ids[0];
         	$admissionId =$get_ids[1];
         	$babyId      =$get_ids[2];
         	$details = Neonatal::get_record($neonatalId);
			$discharge_medications = NicuDischarge::get_discharge_medications($admissionId, $babyId)->pluck('id')->toArray();
         } else {
         	$details = Neonatal::get_record($ids);
         }
      

		$details  = $details[0];
		if (isset($admissionId)) {
          $previousdata = PostDaycare::get_previous_daycare($admissionId);

          $details->Background = isset($previousdata->Background) ? $previousdata->Background : $details->Background;

          $details->CurrentProblems = isset($previousdata->CurrentProblems) ? $previousdata->CurrentProblems :'';
          $details->PreviousProblems = isset($previousdata->PreviousProblems) ? $previousdata->PreviousProblems :'';
          $details->PreviousWt = (isset($previousdata->CurrentWt) && !empty($previousdata->CurrentWt)) ? $previousdata->CurrentWt : '';
		  $discharge_medications = isset($previousdata->postnatal_other_drugs) ? json_decode($previousdata->postnatal_other_drugs) : [];
        }

		if (date('Y', strtotime($details->DOB)) > 1980) {
			$details->DOB = date('d-m-Y', strtotime($details->DOB));
		} else {
			$details->DOB = '';
		}

		$details->AdmissionId = isset($admissionId) ? $admissionId : 0 ; 
							
		$SubmitButtonText  = "Next";
        $prepare_time= \SiteHelpers::prepare_time();
        $currenttime['hours']  = (int) date('h', strtotime(Carbon::now(env('TIME_ZONE'))));
        $currenttime['mins']   = (int) date('i', strtotime(Carbon::now(env('TIME_ZONE'))));
        $currenttime['am-pm']  = date('A', strtotime(Carbon::now(env('TIME_ZONE'))));
	   
	   	$now   = date('d-m-Y');
	    $details->DayDate = $now;
	    $DayOfLife = '';

        if (isset($details->DOB) && $details->DOB != '') {

        	$time1 = Carbon::createFromDate(date('Y', strtotime($details->DOB)), date('m', strtotime($details->DOB)), date('d', strtotime($details->DOB)));
	        $time2 = Carbon::createFromDate(date('Y', strtotime($now)), date('m', strtotime($now)), date('d', strtotime($now)));
	        $DayOfLife = $time1->diffInDays($time2);

        }
        $already_filled_days = PostDaycare::getPostnatalBabyDates($details->BabyId, $details->AdmissionId);

        $ICD = Icd::GetList()->pluck('icdcode', 'ICDCode')->toArray();

		return view('postnatal_daycare.create', compact('SubmitButtonText', 'details', 'ICD','navigate', 'prepare_time', 'currenttime', 'DayOfLife','already_filled_days', 'discharge_medications'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 */
	public function edit($id, $search_data = '')
	{
		$navigate['main_nav'] = 'postnatal';
		$navigate['sub_nav'] = 'post_daycare';

		$id = \SiteHelpers::decrypt_id($id);
		
		$results = PostDaycare::get_record($id);
		$results_date = $results->DayDate;
		if (date('Y', strtotime($results->DOB)) > 1980) {
			$results->DOB = date('d-m-Y', strtotime($results->DOB));
		} else {
			$results->DOB = '';
		}
					
		if (date('Y', strtotime($results->DayDate)) > 1980) {
			$results->DayDate = date('d-m-Y', strtotime($results->DayDate));
		} else {
			$results->DayDate = '';		
		}
		
		$SubmitButtonText = "Update";
		$printButtontext = "Print";
		$submitcloseButtontext ="Update & Close";
		$cancelButton = "Cancel";
		$prepare_time = \SiteHelpers::prepare_time();

           $results->Dayhours  = '';
		   $results->Daymins   = '';
		   $results->Dayam_pm  = '';

         if (!empty($results->DayTime)) {
	         	$results->Dayhours  = (int)date('h', strtotime($results->DayTime));
			    $results->Daymins   = (int)date('i', strtotime($results->DayTime));
			    $results->Dayam_pm  = date('A', strtotime($results->DayTime));
         }
         $ICD = Icd::GetList()->pluck('icdcode', 'ICDCode')->toArray();
         
         $results->differentialdiagnosis = !is_null($results->differentialdiagnosis) ? json_decode($results->differentialdiagnosis) : null;

         $results->additional_diagnosis  = !is_null($results->additional_diagnosis) ?  json_decode($results->additional_diagnosis) : null;

         
        $already_filled_days = PostDaycare::getPostnatalBabyDates($results->BabyId, $results->AdmissionId);
        if (!empty($already_filled_days) && count($already_filled_days) > 0) {
            if (($key = array_search($results_date, $already_filled_days)) !== false) {
                unset($already_filled_days[$key]);
            }
        }
		return view('postnatal_daycare.edit', compact('results', 'ICD', 'SubmitButtonText', 'printButtontext', 'cancelButton', 'submitcloseButtontext', 'search_data', 'navigate', 'prepare_time', 'already_filled_days'));
	}

	/**
	 * Update the specified record
	 *
	 * @param  int  $id
	 */
	public function update($id, PostdayRequest $request)
	{

   
		$input = $request->all();

		$input['SeenBy']    = (!empty($input['SeenBy']) && !is_null($input['SeenBy']))  ?  $input['SeenBy']  :  null;
		$input['DayOfLife'] = (!empty($input['DayOfLife']) && !is_null($input['DayOfLife'])) ? $input['DayOfLife'] : null;

		$input['differentialdiagnosis'] = (isset($input['differentialdiagnosis']) && count($input['differentialdiagnosis']) > 0 ) ?  json_encode($input['differentialdiagnosis']) : null;
		$input['additional_diagnosis']  = (isset($input['additional_diagnosis']) && count($input['additional_diagnosis']) > 0 )  ?  json_encode($input['additional_diagnosis'])  : null;

		AutoTagMasters::auto_key_support($this->auto_tag_fields, $input);
		     $input['SeenBy'] = (!empty($input['SeenBy']) && !is_null($input['SeenBy']))  ?  $input['SeenBy']  :  null;


		$print_flag = isset($input['print_flag']) ? $input['print_flag'] : 0 ;
		unset($input['print_flag']);		

		$input['DateModified'] = Carbon::now($this->time_zone);
		$input['UserModified'] = $this->auth->user()->id;
		$input['DOB'] = (isset($input['DOB']) && $input['DOB'] != '') ? date('Y-m-d', strtotime($input['DOB'])) : null;

		$baby = Baby::findOrfail($input['BabyId']);

		$baby_details = $input;

		unset($baby_details['Background']);

		$baby->update($baby_details);

		$input['examination_normal'] = (isset($input['examination_normal']) &&  $input['examination_normal'] =='on') ? true :false;
		$input['DayDate'] = date('Y-m-d', strtotime($input['DayDate']));
		$input['Dayhours'] = (isset($input['Dayhours']) && strlen($input['Dayhours'])==1) ? '0'.$input['Dayhours'] : $input['Dayhours'] ;
		$input['Daymins']  = (isset($input['Daymins']) && strlen($input['Daymins'])==1) ? '0'.$input['Daymins'] : $input['Daymins'] ;
		$input['DayTime'] = $input['Dayhours'].':'.$input['Daymins'].' '.$input['Dayam_pm'];


		if (isset($input['postnatal_antiboitic']) && count($input['postnatal_antiboitic']) > 0) {
			
			$postnatal_antiboitic = array(); 
			foreach ($input['postnatal_antiboitic'] as $key => $value) {
		         if (isset($input['postnatal_antiboitic'][$key])) {
		            $postnatal_antiboitic[$key]['postnatal_antiboitic']     = $input['postnatal_antiboitic'][$key];
			 	  $postnatal_antiboitic[$key]['postnatal_antiboitic_day'] = $input['postnatal_antiboitic_day'][$key]; 
		         }
			}
			$input['postnatal_antiboitic'] = json_encode($postnatal_antiboitic);

		} 
		else {
		      $input['postnatal_antiboitic'] = null;
		}


		$input['postnatal_other_drugs'] = (isset($input['postnatal_other_drugs']) && count($input['postnatal_other_drugs']) > 0) ? json_encode($input['postnatal_other_drugs']) : null;

		$input['postnatal_organism']    = (isset($input['postnatal_organism']) && count($input['postnatal_organism']) > 0) ? json_encode($input['postnatal_organism']) : null; 


		$results1 = PostDaycare::findOrfail($id);
		$results1->update($input);

		$module =  \Session::has('admission_module') ? \Session::get('admission_module') : 'POSTNATAL_DAILY_CARE';
		  $menu   =  isset($_COOKIE['postnataldaycare']) ? $_COOKIE['postnataldaycare'] : 'generalform';
			
			if ($request->ajax()) {
		      return \Response::json(['type' => 'success', 'message' => 'Postnatal daycare details created successfully !', 'list_url' => action('Admission\PostnatalDaycareController@postnatalDaywiselist', \SiteHelpers::encrypt_id($results1['AdmissionId'].'-'.$results1['BabyId'])), 'print_url'=> action('Admission\PostnatalDaycareController@printData', \SiteHelpers::encrypt_id($id))], 200);
		  }

		if ($print_flag==1) {

			$this->flow->flowlog($module, $results1->BabyId,  $results1->MotherId, $results1->AdmissionId, false, $menu, $id);
			return redirect(action('Admission\PostnatalDaycareController@printData', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully ');

		} elseif ($print_flag==0) {
		      
		      $this->flow->flowlog($module, $results1->BabyId,$results1->MotherId, $results1->AdmissionId, false, $menu, $id);
			return redirect(action('Admission\PostnatalDaycareController@edit', \SiteHelpers::encrypt_id($id)))->with('Success', \trans('basic.success'));

		} else {
			      $this->flow->flowlog($module, $results1->BabyId,$results1->MotherId, $results1->AdmissionId, true, $menu, $id);
		            $this->flow->clearFlow();
			return redirect(action('Admission\PostnatalDaycareController@postnatalDaywiselist', \SiteHelpers::encrypt_id($results1['AdmissionId'].'-'.$results1['BabyId'])))
			 ->with('Success', 'Record updated successfully');

		}		
	}

	/**
	 * PRINT THE SPECIFIED RECORD.
	 *
	 * @param  int  $id
	 */
	public function printData($id)
	{
		$id = \SiteHelpers::decrypt_id($id);
		
		$results = PostDaycare::get_record($id);
		$editor_gen_option = false;
		$postanatal_admission = Postnatal::getAdmissionDailyCare($results->BabyId, $results->AdmissionId);

	    $results=(object)\SiteHelpers::formate_tags($this->auto_tag_fields, (array)$results);
	    $closewinlink = action('Admission\PostnatalDaycareController@index');

	    $postanatal_admission = Postnatal::where('AdmissionId', $results->AdmissionId)->first();
	    $pid = 0;
	    if (is_object($postanatal_admission)) {
		    $pid = $postanatal_admission->pid;
		}

		$editor_gen_option = $results->edited_content == NULL ? 1 : 0;
        $editor_gen = false;

        $ip_details = IpNumber::getCurrent_ip($results->BabyId, $results->AdmissionId);
        $ip_number = isset($ip_details->ip_number) ? $ip_details->ip_number : null;

        if (\Session::has('postnatal-daycare-editor'))
        {
            \Session::forget('postnatal-daycare-editor');
            $editor_gen = true;
        	return view('postnatal_daycare.print', compact('results', 'pid','closewinlink', 'postanatal_admission', 'editor_gen', 'editor_gen_option', 'ip_number'))->renderSections();
        }

        return view('postnatal_daycare.print', compact('results', 'pid','closewinlink', 'postanatal_admission', 'editor_gen_option', 'ip_number'));

	}
	/**
	* FETCH THE RECORD FOR POPUP VIEW
	*/
	public function getData($id)
	{
		$result = PostDaycare::get_record($id);
		$results = (array)$result;
		$results['DayDate'] = date('d-m-Y', strtotime($results['DayDate']));
		$results['DOB'] = date('d-m-Y', strtotime($results['DOB']));

		return json_encode($results);		
	}
	/** 
	* RETRIEVE THE DATA FOR SEARCH FILTER
	*/
	public function searchData(Request $request)
	{
		$data = $request->get('data1');
		$result = PostDaycare::GetSearchDatas($data);
		$results = (array)$result;
		return json_encode($results);
	}
	/**
	* UPDATE THE RECORD AS DELETED AND CREATE THE APPROVAL REQUEST
	*/
	public function destroy($id)
	{
		$results = PostDaycare::findOrfail($id);
		$user_detail = array(
			'UserDeleted'	=> $this->auth->user()->id,
			'DateModified'	=> Carbon::now($this->time_zone),
			'IsDeleted'		=> '1'
		);
		$results->update($user_detail);
		$result =  PostDaycare::get_record($id);
		$res = $result;
		
		$delete_data = array(
			'Name'		  	   => $res->BabyName,
			'AdmissionDate'	   => $results['DayDate'],
			'ModuleController' => 'Admission\PostnatalDaycareController',
			'ModuleId'		   => $id,
			'ModuleName'	   => 'Postnatal Daycare Sheet',
			'UserDeleted'	   => $this->auth->user()->id,
			'DateDeleted'	   => Carbon::now($this->time_zone)
		);
		DeleteApproval::create($delete_data);
		return redirect(action('Admission\PostnatalDaycareController@postnatalSublist', \SiteHelpers::encrypt_id($res->BabyId)))->with('info', 'Records deleted successfully');	
	}

    /**
     * OPEN REPORT WITH FULL EDITOR
     *
     */
    public function getfullEditor(Request $request)
    {
        $input = $request->all();
        \Session::put('postnatal-daycare-editor', true);
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

        $daycare = PostDaycare::findOrfail($input['daycare_id']);

        $daycare->update(['edited' => true, 'edited_content' => $input['post_daycare_report'], 'edited_time' => Carbon::now($this->time_zone) ]);

        // create slug for updated
        $daycare_id = $input['daycare_id'];

        if ($request->ajax()) {
            return \Response::json(['type'=>'success','msg' => 'Record updated successfully']);
        } else {
	        return redirect(action('Admission\PostnatalDaycareController@getAbbreviatedsummaryShow', $daycare_id))->with('success', 'Record updated successfully');
	    }

    }

    public function getAbbreviatedsummaryShow(Request $request, $id)
    {
		$id_list = $id;

		$dischargeSummarymodified = array();

		if (isset($id_list) && !empty($id_list))
		{

		   $dischage_summary['daycare_id'] = $daycare_id = $id_list;

		}
		else
		{

		   return redirect(url('/'))->with('error', 'Invalid record');

		}

		$daycare = PostDaycare::findOrfail($id_list);

		\Session::put('postnatal-daycare-editor', true);

		if (count($daycare) > 0 && !empty($daycare['edited_content'])) {
		   $discharge_details['content'] = $daycare['edited_content'];
		} else {
			$discharge_details = $this->printData($id);
		}

		$editor_gen = false;
		\Session::forget('postnatal-daycare-editor');

		return view('postnatal_daycare.editor', compact('discharge_details', 'dischargeSummarymodified', 'dischage_summary'));
    }
}
