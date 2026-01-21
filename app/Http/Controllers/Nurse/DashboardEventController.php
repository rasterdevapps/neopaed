<?php
namespace App\Http\Controllers\Nurse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Settings\Settings;
use Carbon\Carbon;
use App\Models\DashboardEvent;
use App\Events\CareEventMarker;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Models\Nicu;
use App\Models\Baby;

class DashboardEventController extends Controller {

	/**
	 * This for site settings instance 
	 * 
	 * @var $site_settings
	 */
	public $site_settings;

	function __construct(Settings $site_settings)
	{
		$this->site_settings = $site_settings;
		$this->time_zone     = env('TIME_ZONE');
		$this->custom_error = new ErrorLogController();
	}

	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function getDashboardEventResult(Request $request) {

		$dashboard_result = (array)json_decode(file_get_contents('php://input'));
		$secure_user  = false;

		if (isset($dashboard_result['securityLabel'])) {

			$check_auth    = $dashboard_result['securityLabel'];

			$api_key       = \SiteHelpers::decrypt_id($check_auth->api_key);
			$user_password = \SiteHelpers::decrypt_id($check_auth->user_password);

			$settings               = $this->site_settings->find(1);
			$settings_api_key       = \SiteHelpers::decrypt_id($settings->api_key);
			$settings_user_name     =  $settings->api_user_name;
			$settings_user_password = \SiteHelpers::decrypt_id($settings->api_password);

			if (($api_key == $settings_api_key) && ($check_auth->user_name == $settings_user_name) &&  ($user_password == $settings_user_password)) {
				$secure_user = true;
			}

		}

		if ($secure_user) {

			if (isset($dashboard_result['results'])) {

				$results = $dashboard_result['results'];
				$this->custom_error->emergencyLog('IOMT REQUEST for EVENT values '.json_encode($results));

				$event = $results->event;

				if (isset($results->event_status) && $results->event_status == 'ABORT') {
					DashboardEvent::where('event_code', $event->event_code)->where('mrn', $results->mrn)->where('event_status', "START")->orderBy('event_date_time', 'desc')->limit(1)->delete();
					$this->custom_error->emergencyLog('EVENT ABORTED EVENT_CODE'.$event->event_code. ' AND MRN ===='.$results->mrn);
		            return \Response::json(['status'=>'success','message'=>'Aborted Successfully'], 200);
				} else{
					$result_set['nurse_id'] = null;
					if ($results->event_status == 'STOP') {
						if (isset($results->employee_id) && !empty($results->employee_id)) {
							$get_nurse_id = \DB::table('mas_nures')->select('id')->where('register_no', $results->employee_id)->where('status', 'Active')->first();
							if (isset($get_nurse_id->id) && !empty($get_nurse_id)) {
								$result_set['nurse_id'] = $get_nurse_id->id;
							}
						}
						$this->custom_error->emergencyLog('EVENT STOPPED EVENT_CODE '.$event->event_code. ' AND MRN ===='.$results->mrn);
					}
					$result_set['mrn'] = $results->mrn;
		            $result_set['event'] = $event->value;
		            $result_set['event_code'] = $event->event_code;
		            $result_set['snomed_code'] = $event->snomed_code;
		            $result_set['event_status'] = $results->event_status;
		            $result_set['event_date_time'] = $results->event_date_time;
		            $result_set['request_from_imot'] = true;
		            $result_set['created_date_time'] = Carbon::now($this->time_zone);
		            DashboardEvent::insert($result_set);
		            if (isset($results->bed) && !empty($results->bed)) {
						$update_bed['event_code'] 	= $event->event_code; 
						$update_bed['event_status'] = $results->event_status; 
						$update_bed['event_time'] 	= $results->event_date_time;
						$update_bed['event_status_flag']= 2;
						\DB::table('bed')->where('number', $results->bed)->update($update_bed);
					}
					$this->custom_error->emergencyLog('EVENT DETAILS UPDATED FROM IoMT '.$result_set['event']. ' ==========='.$result_set['event_status'].' ============= '.$result_set['event_date_time']. ' =========='.$result_set['mrn']);
		            return \Response::json(['status'=>'success','message'=>'Added Successfully'], 200);
		        }
			
			} else {
            
            	return \Response::json(['status'=>'failure','message'=>'Invalid result set.'], 401);
			}

		} else {

            return \Response::json(['status'=>'failure','message'=>'Invalid api key or credentials !'], 401);

		}

	}

	/**
     * Get event page for a baby.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function getBabyEvents($mrn, $bed_id) {
		
		$mrn  = \SiteHelpers::decrypt_id($mrn);
		$baby_details = DashboardEvent::getBabyInfo($mrn);
		$running_events_details = DashboardEvent::getEventdetails($mrn, 'running_events');
		$stop_event_details = DashboardEvent::getEventdetails($mrn);
		$event_list = DashboardEvent::getEvents();
		$nurse_list = DashboardEvent::getNurseList();
		$closewinlink = action('Ward\BabyWardController@index');

		return view('event.show', compact('baby_details', 'event_list', 'stop_event_details', 'running_events_details', 'closewinlink', 'bed_id', 'nurse_list'));
	}

	/**
     * Get event results for a baby.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function getEventResult(Request $request) {
		$input = $request->all();
		$get_bed_event_details = DashboardEvent::getBedBasedEvent($input['bed_id']);
		$result = array();
		if (isset($input['current_event']) && !empty($input['current_event'])) {

			if (isset($get_bed_event_details->event_code) && $input['current_event'] == $get_bed_event_details->event_code) {
				if (isset($input['event_status']) && !empty($input['event_status']) && $input['event_status'] == $get_bed_event_details->event_status) {
					$result['status'] = 'same event with same status';
				}
				else
				{
					$result['status'] = 'event status modified';
					$result['event_status'] = $get_bed_event_details->event_status;
					$result['event_code'] = $get_bed_event_details->event_code;
					$result['event_name'] = $get_bed_event_details->event_name;
					$result['event_time'] = $get_bed_event_details->event_time;
				}
			}
			elseif(isset($get_bed_event_details->event_code) && $input['current_event'] != $get_bed_event_details->event_code)
			{
				$result['status'] = 'another event updated';
				$result['event_status'] = $get_bed_event_details->event_status;
				$result['event_name'] = $get_bed_event_details->event_name;
				$result['event_time'] = $get_bed_event_details->event_time;
				$result['event_code'] = $get_bed_event_details->event_code;
			}

		}
		else
		{
			if (isset($get_bed_event_details->event_code)) {
				$result['status'] = 'new event started';
				$result['event_status'] = $get_bed_event_details->event_status;
				$result['event_name'] = $get_bed_event_details->event_name;
				$result['event_time'] = $get_bed_event_details->event_time;
				$result['event_code'] = $get_bed_event_details->event_code;
			}
			else
			{
				$result['status'] = 'no event started yet';
			}
		}

		// $running_events_details = DashboardEvent::getEventdetails($mrn, 'running_events');
		// $stop_event_details = DashboardEvent::getEventdetails($mrn);
		// return \Response::json(['running'=>$running_events_details,'stop'=>$stop_event_details]);
		return \Response::json(['result'=>$result]);

	}

	/**
     * Store event for baby from dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function storeDashboardEvents(Request $request) {
		
		$input = $request->all();
		if (isset($input['mrn'])) {
			// $check_event_status_exist = DashboardEvent::checkEventStatus($input['mrn'], $input['event'], $input['status']);
			// if (!isset($check_event_status_exist->id)) {
				$insert_event['event'] 				= $input['event']; 
				$insert_event['event_code'] 		= $input['event_code']; 
				$insert_event['event_status'] 		= $input['status']; 
				$insert_event['event_date_time'] 	= date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $input['event_time']))); 
				$insert_event['mrn'] 				= $input['mrn']; 
				$insert_event['nurse_id'] 			= isset($input['nurse_id']) && !empty($input['nurse_id']) ? $input['nurse_id'] : 0; 
				$insert_event['created_date_time'] 	= date('Y-m-d H:i:s'); 
				$insert_event['snomed_code'] 		= '';
				DashboardEvent::insert($insert_event);
				broadcast(new CareEventMarker($insert_event))->toOthers();
				if (isset($input['bed_id']) && !empty($input['bed_id'])) {
					$update_bed['event_code'] 		= $input['event_code']; 
					$update_bed['event_status'] 	= $input['status']; 
					$update_bed['event_time'] 	= date('Y-m-d H:i:s', strtotime($input['event_time']));
					$update_bed['event_status_flag']= 1;
					\DB::table('bed')->where('id', $input['bed_id'])->update($update_bed);
				}
			// }
			return \Response::json(['status'=>'success','message'=>'Added Successfully'], 200);
		}
		else
		{
			return \Response::json(['status'=>'failure','message'=>'Invalid result set.'], 401);
		}
	}

	/**
     * Send event for baby from dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function postStopStatus(Request $request) {
		
		$input = $request->all();
		if (isset($input['mrn'])) {
			$broadcast_data['mrn'] = $input['mrn'];
			$broadcast_data['event_status'] = 'Temperory Stopped';
			$broadcast_data['event_date_time'] = date('Y-m-d H:i:s');
			$broadcast_data['event_code'] = $input['event_code'];
			broadcast(new CareEventMarker($broadcast_data))->toOthers();
		}
		else
		{
			return \Response::json(['status'=>'failure','message'=>'Invalid result set.'], 401);
		}
	}

	public function getCharts()
	{
		return view('event.chart');
	}

	/**
     * Get event page for a baby.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function index(Request $request) {

        $limit = 50; // Assign the Page limitation
        if (!empty($request->input('limit')))
        {
            $request->session()
                ->put('limit', $request->input('limit'));
            $limit = $request->session()
                ->get('limit');
        }
        elseif ($request->session()
            ->has('limit'))
        {
            $limit = $request->session()
                ->get('limit');
        }

        $order['sortby'] = 'nicu_admission.NicuId';
        $order['sortorder'] = 'desc';

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
        // Assing Menu section
        $navigate['main_nav'] = 'Events';
        $navigate['sub_nav'] = 'Care Event';

        // Get Baby list using Baby models
        $result = Nicu::get_lists($request->input('page'), $limit, $search, $order, 1);
        $results = $result['result'];

        $results  = $result['result'];
        $getTotal = count($result['result']);
        
        $total    = $result['total']; 

        // Set page
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
        
        return view('event.list', compact('results', 'navigate', 'pagination', 'search', 'order', 'getTotal'));
	}

	public function chart(Request $request)
	{
        $input = $request->all();
        $mrn = \SiteHelpers::decrypt_id($input['mrn']);
        $baby_details = Baby::get_baby_by_mrn($mrn);
        $ids = Nicu::get_sub_lists($baby_details->BabyId);
        $i = 1;
        foreach ($ids as $key => $value) {
        	$admission_id = $value->AdmissionId;
        	$admission_date = $value->AdmissionDate;
        	$discharge_date = $value->DischargeDate;
        	$admission_ids[$admission_id] = 'Admission ' . $i;
        	$date[$admission_id] = $admission_date . ':' . $discharge_date;
        	$i++;
        }

        krsort($admission_ids);
        krsort($date);

		return view('event.event_chart', compact('baby_details', 'admission_ids', 'date'));
	}

	public function getChartDetails(Request $request)
	{
        $input = $request->all();
        $mrn = $input['mrn'];
        $from_date = $input['from_date'] . ' 00:00:00';
        $to_date = $input['to_date'] . ' 23:59:59';

        $event = DashboardEvent::getEventCount($mrn, $from_date, $to_date);
        $total = array_sum(collect($event)->pluck('count')->toArray());

		return \Response::json(['event'=>$event, 'total'=>$total]);
	}

}
