<?php  namespace App\Http\Controllers\Settings;

use App\Models\Nicu;
use App\Models\Baby;
use App\Models\Mother;
use App\Models\Pediatric;
use App\Models\Cardio;
use App\Models\Ultra;	
use App\Models\Culture;	
use App\Models\Op;	
use App\Models\Calculators\Ballard;	
use App\Models\PostDaycare;
use App\Models\Daycare;
use App\Models\Neonatal;
// use App\Models\Masters\Drug as Drug;
use App\Models\Masters\DrugIvFluidMaster;
use App\Models\Masters\Vaccine as Vaccine;
use App\Models\Masters\MediprobsMaster as MediprobsMaster;
use App\Models\Masters\Complications as ComplicationMaster;
use App\Models\Masters\AntibioticMaster as AntibioticMaster;
use App\Models\Masters\ProcedureMaster as ProcedureMaster;
use App\Models\Masters\ProblemMaster as ProblemMaster;
use App\Models\Masters\RespiratoryIndication;
use App\Models\Masters\Admissionmode;
use App\Models\Masters\DoctorMaster;
use App\Models\Masters\Indication;
use App\Models\Masters\Surgeon;
use App\Models\Masters\StaffMaster;
use App\Models\Masters\BookingPlace;
use App\Models\Masters\DaycareProblems;
use App\Models\ProblemDaycareList;
use App\Models\Postnatal;
use App\Models\PostnatalDischarge;
// use App\Models\Masters\IvFluids;
use App\Models\Settings\DeleteApproval;
use Illuminate\Contracts\Auth\Guard;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masters\NurseMaster;

use App\Models\Nurse\NurseIvInfusion;
use App\Models\Nurse\NurseOtherIvDrugs;
use App\Models\Nurse\NurseOtherIvInfusion;
use App\Models\Nurse\NurseGlucoseIntake;
use App\Models\Nurse\NurseOralDrugs;

 use App\Models\Masters\CollectionSites;
use App\Models\lab\LabRequest;
use App\Models\Masters\CollectionMethod;

class DeleteApprovalController extends Controller 
{
    /**
     * This for auth instance
     * @var $auth
     */
     public $auth;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->middleware('role:DELETE_ACCESS,write');
		$this->auth  = $auth;
	}

	/**
	 * List the delete approval requests
	 * 
	 * 
	 */
	 public function index(Request $request)
	 {
        //Initialize the record  limit  with 50
        $limit = 50;

        //set the limit as per the request
        if (!empty($request->input('limit'))) {

            $request->session()->put('limit', $request->input('limit'));
            $limit =  $request->session()->get('limit');

        } elseif ($request->session()->has('limit')) {

            $limit =  $request->session()->get('limit');

        }

        //Initialize the record sorting key and order  
        $order['sortby']    = 'AdmissionDate';
        $order['sortorder'] = 'desc';   

        //set the records sorting key and order  
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {

              $order['sortby']     = \SiteHelpers::decrypt_id($request->input('sortby'));
              $order['sortorder']  = $request->input('sortorder');

        }

        //initialize search parameter array 
        $search = array();
        $search['search_txt']='';
        if (!empty($request->input('search_txt'))) {

           $search['search_txt'] = $request->input('search_txt');

        }

        //setting the navigation bar 
        $navigate['main_nav'] = 'delete_access';
	    $navigate['sub_nav'] = 'delete_access';

	    $user_id = $this->auth->user()->id;
		$role_id = $this->auth->user()->RoleId;

	    //get the records
	    $result 	= DeleteApproval::ListData($request->input('page'), $limit, $search, $order, 1);

	    $limitstart = (empty($request->input('page')) || $request->input('page') == 1) ? 0 : (($request->input('page')-1)*$limit);

	    $total   	= $result->get()->count();

	    $results 	= $result->limit($limit)->offset($limitstart)->get();

	    $getTotal   = DeleteApproval::GetTotal();	

	    $page                	= !empty($request->input('page')) ? $request->input('page') : 1;
        $pagecount           	= ceil($total/$limit);
        $pagination['total'] 	= $total;
        $pagination['start'] 	= (($page-2) < 1) ? 1 : ($page-2);
        $pagination['end']   	= ($pagecount < ($page+3)) ? $pagecount :   ($page+3);
        $pagestart              = $total != 0 ? ($page <= 1) ? $page : ($page-1)*$limit + 1 : 0;
        $pagerecords            = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page*$limit;
        $pagination['limit']    = array($pagestart, $pagerecords);
        $pagination['limits']   = $limit;
        $pagination['previous'] = (($page-1) < 1) ? 1 : ($page-1);
        $pagination['next']     = ($pagecount < ($page+1)) ? $pagecount :   ($page+1);
        		
		return view('settings.approvals.list', compact('results', 'navigate', 'pagination', 'search', 'order', 'getTotal'));
	 }

    /**
     * @param  Request  $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getprocess(Request $request, $id)
	{
		$input = $request->all();
		$id = (int)$id;

		if ($id === 1 && isset($input['approve_ids']) && count(json_decode($input['approve_ids'])) > 0) {

            foreach (json_decode($input['approve_ids']) as $record_id) {
            	$results = DeleteApproval::findOrfail($record_id);
            	$user_detail = array(
					'UserApproved'	=> $this->auth->user()->id,
					'DateApproved'	=> Carbon::now(),
					'Status'		=> 'Approved'
				);
		    	$results->update($user_detail);
            }

            return redirect(action('Settings\DeleteApprovalController@index'))->with('success', 'Your approvals has been updated!');

		} elseif($id === 2 && isset($input['approve_ids']) && count(json_decode($input['approve_ids'])) > 0) {


			foreach (json_decode($input['approve_ids']) as $record_id) {
            	$results = DeleteApproval::findOrfail($record_id);
            	$user_detail = array(
					'UserApproved'	=> $this->auth->user()->id,
					'DateApproved'	=> Carbon::now(),
					'Status'		=> 'Restored'
				);
		    	$results->update($user_detail);

		    	$this->GetModule($results); 
            }
			
			return redirect(action('Settings\DeleteApprovalController@index'))->with('success', 'Your undo has been updated!');

		}



	} 
	/**
	* UPDATE THE REQUESTS ACCORDING TO THE OPTIONS SELECTED
	*/
	public function process($id, $option)
	{
		$navigate['main_nav'] = 'delete_access';
		$navigate['sub_nav'] = 'delete_access';			
		$results = DeleteApproval::findOrfail($id);
		if ($option == 1) {
			$user_detail = array(
				'UserApproved'	=> $this->auth->user()->id,
				'DateApproved'	=> Carbon::now(),
				'Status'		=> 'Approved'
			);
			$results->update($user_detail);
			return redirect(action('Settings\DeleteApprovalController@index'))->with('Success', 'Your approvals has been updated!');
		} elseif ($option==2) {
			$user_detail = array(
				'UserApproved'	=> $this->auth->user()->id,
				'DateApproved'	=> Carbon::now(),
				'Status'		=> 'Restored'
			);
		    	$results->update($user_detail);	
		    	$this->GetModule($results);	
			
			return redirect(action('Settings\DeleteApprovalController@index'))->with('Success', 'Your undo has been updated!');
		}
		
	}	

	public function GetModule($results) 
	{
		    $data = array();

			switch ($results['ModuleController']) {

				case "Registration\BabyController":
					$data = Baby::findOrfail($results['ModuleId']);
				break;
				case "Registration\MotherController":
					$data = Mother::findOrfail($results['ModuleId']);
				break;				
				case "Registration\OpController":
					$data = Op::findOrfail($results['ModuleId']);
				break;				
				case "Registration\NeonatalController":
					$data = Neonatal::findOrfail($results['ModuleId']);
				break;
				case "Admission\NicuController":
					$data = Nicu::findOrfail($results['ModuleId']);
				break;				
				case "Admission\PediatricController":
					$data = Pediatric::findOrfail($results['ModuleId']);	
				break;				
				case "Admission\PostnatalDaycareController":
					$data = PostDaycare::findOrfail($results['ModuleId']);
				break;	
				case "Admission\DaycareController":
					$data = Daycare::findOrfail($results['ModuleId']);
				break;				
				case "Calculators\BallardController":
					$data = Ballard::findOrfail($results['ModuleId']);
				break;	
				case "Extras\CardioController":
					$data = Cardio::findOrfail($results['ModuleId']);
				break;	
				case "Extras\CultureController":
					$data = Culture::findOrfail($results['ModuleId']);
				break;	
				case "Extras\UltraController":
					$data = Ultra::findOrfail($results['ModuleId']);
				break;		
				case "Masters\AntibioticController":
					$data = AntibioticMaster::findOrfail($results['ModuleId']);
				break;
				case "Masters\ComplicationController":
					$data = ComplicationMaster::findOrfail($results['ModuleId']);
				break;
				// case "Masters\DrugController":
				// 	$data = Drug::findOrfail($results['ModuleId']);
				// break;
				case "Masters\DrugIvFluidController":
					$data = DrugIvFluidMaster::findOrfail($results['ModuleId']);
				break;
				case "Masters\MediprobsController":
					$data = MediprobsMaster::findOrfail($results['ModuleId']);
				break;
				case "Masters\ProblemController":
					$data = ProblemMaster::findOrfail($results['ModuleId']);
				break;
				case "Masters\ProcedureController":
					$data = ProcedureMaster::findOrfail($results['ModuleId']);
				break;
				case "Masters\VaccineController":
					$data = Vaccine::findOrfail($results['ModuleId']);
				break;	
				case 'Masters\RespiratoryIndicationController':
					$data = RespiratoryIndication::findOrfail($results['ModuleId']);
				break;	
				case 'Masters\AdmissionmodeController':
					$data = Admissionmode::findOrfail($results['ModuleId']);
				break;	
				case 'Masters\DoctorController':
					$data = DoctorMaster::findOrfail($results['ModuleId']);
				break;	
				case 'Masters\IndicationController':
					$data = Indication::findOrfail($results['ModuleId']);
				break;	
				case 'Masters\SurgeonController':
					$data = Surgeon::findOrfail($results['ModuleId']);
				break;	
				case 'Masters\StaffController':
					$data = StaffMaster::findOrfail($results['ModuleId']);
				break;	
				case 'Masters\BookingPlaceController':
				    $data = BookingPlace::findOrfail($results['ModuleId']);
				break;
				case 'ProblemsSettings\ProblemsSettingController':
				    $data = DaycareProblems::findOrfail($results['ModuleId']);
				break;
				case 'ProblemBaseDaycare\ProblemDaycareController':
				    $data = ProblemDaycareList::findOrfail($results['ModuleId']);
				break;    
				case 'Admission\PostnatalController':
				    $data = Postnatal::findOrfail($results['ModuleId']);
				    $discharge = PostnatalDischarge::findOrfail($results['SubModuleId']);
				    $user_data = array('IsDeleted'		=>  0, 'DateModified'	=>  Carbon::now());							   
                    $discharge->update($user_data);
				break; 
				// case 'Masters\IvFluidsController':
				//     $data = IvFluids::findOrfail($results['ModuleId']);
			 //    break;  
			    case 'Masters\NurseController':
				    $data = NurseMaster::findOrfail($results['ModuleId']);
			    break; 
			    case 'Prescription\NurseIvInfusion':
			        $data = NurseIvInfusion::findOrfail($results['ModuleId']);
			    break;
			    case 'Prescription\NurseOtherIvDrugs':
			        $data = NurseOtherIvDrugs::findOrfail($results['ModuleId']);   
			    break;  
			    case 'Prescription\NurseOtherIvInfusion':
                    $data = NurseOtherIvInfusion::findOrfail($results['ModuleId']);
			    break;     
			    case 'Prescription\NurseGlucoseIntake':
			    	$data = NurseGlucoseIntake::findOrfail($results['ModuleId']);
			    break;
			    case 'Prescription\NurseOralDrugs':
			    	$data = NurseOralDrugs::findOrfail($results['ModuleId']);
			    break;
			    case 'Masters\CollectioMethodController':
			    	$data = CollectionMethod::findOrfail($results['ModuleId']);
			    break;
			    case 'Lab\LabRequestController':
			    	$data = LabRequest::findOrfail($results['ModuleId']);
			    break;
				default:
					$flag = false;
				break; 
			}
			if (!isset($flag)) {
				$user_data = array(
					'IsDeleted'		=>  0,
					'DateModified'	=>  Carbon::now(),
				);
			   $data->update($user_data);
			}
	    return;		
	} 
}
