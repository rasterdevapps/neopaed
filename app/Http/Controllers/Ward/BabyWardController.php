<?php

namespace App\Http\Controllers\Ward;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ward\Ward;
use App\Models\Masters\Ward as WardMaster;
use App\Models\Masters\Room;
use App\Models\Ward\BedLog;
use App\Models\Masters\Bed;
use Illuminate\Contracts\Auth\Guard;
use Carbon\Carbon;
use App\Models\Baby;
use App\Models\Nicu;
use App\Models\Admission;
use App\Models\Fhir\FhirFormatedValues;
use App\Models\Nurse\SyringePumpAdmisson;
use App\Http\Controllers\Nurse\NurseChartPropertyController;
use App\Http\Controllers\Fhir\FhirBackUpController;
use App\Http\Controllers\Fhir\HmsInterfacingController;
use App\Models\Nurse\NurseSheetMain;
use App\Models\Nurse\DayWisePatientBedLog;
use App\Http\Controllers\NicuDashboardController;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Events\WardEvent;
use App\Models\prescriptionDetails;
use App\Http\Controllers\Fhir\PrescriptionToMirthController;

class BabyWardController extends Controller
{

    /**
     * This instance of bed
     * @var $bed
     */
    public $ward;

    /**
     * This instance of ward
     * @var $ward_master
     */
    public $ward_master;

    /**
     * This instance of room
     * @var $room_master
     */
    public $room_master;

    /**
     * This instance of auth
     * @var $auth
     */
    public $auth;

    /**
     * This time zone settings
     * @var $auth
     */
    public $time_zone;

    /**
     * controller constructor
     *
     */
    public function __construct(Guard $auth, Ward $ward, WardMaster $ward_master, Room $room_master, SyringePumpAdmisson $pump_property, NurseChartPropertyController $chart_property)
    {
        $this->ward = $ward;
        $this->ward_master = $ward_master;
        $this->room_master = $room_master;
        $this->auth = $auth;
        $this->pump_property = $pump_property;
        $this->chart_property = $chart_property;
        $this->time_zone = env('TIME_ZONE');
        $this->db_clean = new FhirBackUpController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();

        $room_name = (isset($input['room_name']) && $input['room_name'] != '') ? $input['room_name'] : 0;

        $ward = $this->ward->getward_room($room_name);

        $ward_list = collect($ward)->unique('ward_id');
        $room_list = collect($ward)->sortBy('room_name')->groupBy('ward_name')->toArray();
        $baby = $this->ward->getbaby();
        $room_master_list = $this->room_master->all()->pluck('number', 'id');
        $room_master_list[0] = 'All';
        $room_master_list = $room_master_list->toArray();

        $admission_ids = $baby->pluck('admission_id')->toArray();
        $monitor_status = BedLog::getDeviceStatus($admission_ids, 'emr_moniter_values');
        $ventilator_status = BedLog::getDeviceStatus($admission_ids, 'emr_ventilator_values');
        $pump_admission_status = BedLog::getPumpAdmissionStatus($admission_ids);
        $pump_running_status = BedLog::getPumpRunningStatus($admission_ids);
        $navigate['main_nav'] = 'ward-dashboard';
        $navigate['sub_nav'] = 'ward_management';

        return view('ward.list', compact('ward', 'ward_list', 'room_list', 'navigate', 'baby', 'room_name', 'room_master_list', 'room_name', 'monitor_status', 'ventilator_status', 'pump_admission_status', 'pump_running_status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();

        $bedDetails['wardid'] = $input['wardId'];
        $bedDetails['roomid'] = $input['roomId'];
        $bedDetails['bedid'] = $input['bedId'];

        $baby = BedLog::bedlog_unallocated_baby()->pluck('BabyName', 'BabyId');

        if (count($baby) > 0) {
            return \Response::json(['type' => 'success', 'message' => 'Baby list loaded successfully!', 'baby_list' => $baby, 'bedDetails' => $bedDetails], 200);
        } else {
            return \Response::json(['type' => 'warning', 'message' => 'No Baby\'s found in admission!'], 201);
        }
    }

    /**
     * Update the bed transfer details.
     *
     * @return \Illuminate\Http\Response
     */
    public function getupdatebedlog(Request $request)
    {
        $input = $request->all();

        $ward = WardMaster::find($input['wardId']);
        $room = $input['roomId'];
        $bed = Bed::find($input['bedId']);

        if (!isset($ward->name)) {
            return \Response::json(['type' => 'error', 'message' => 'Issue with ward name can\'t transfer the baby!'], 500);
        }

        if (!isset($room)) {
            return \Response::json(['type' => 'error', 'message' => 'Issue with room name can\'t transfer the baby!'], 500);
        }

        if (!isset($bed->number)) {
            return \Response::json(['type' => 'error', 'message' => 'Issue with bed number can\'t transfer the baby!'], 500);
        }

        $old_bed_status = Bed::find($input['oldBedId']);
        $old_bed_status->status = null;
        $old_bed_status->save();

        $baby_bed_log['ward_id'] = $input['wardId'];
        $baby_bed_log['ward_name'] = isset($ward->name) ? $ward->name : '';

        $baby_bed_log['room_id'] = isset($room) ? $room : '';
        $baby_bed_log['room_no'] = isset($room) ? $room : '';

        $baby_bed_log['bed_id'] = $input['bedId'];
        $baby_bed_log['bed_no'] = isset($bed->number) ? $bed->number : '';

        $baby_bed_log['baby_id'] = $input['babyId'];
        $baby_bed_log['admission_id'] = $input['admissionId'];

        $baby_bed_log['DateModified'] = Carbon::now(env('TIME_ZONE'));
        $baby_bed_log['UserModified'] = $this
            ->auth
            ->user()->id;
        $baby_bed_log['status'] = 'Occupied';

        $bed->status = 'Occupied';
        $bed->save();

        $condition['baby_id'] = $input['babyId'];
        $condition['admission_id'] = $input['admissionId'];
        BedLog::where($condition)->update($baby_bed_log);

        $baby_details = Baby::find($input['babyId']);

        $syringe_pump['baby_id'] = $baby_details->BabyId;
        $syringe_pump['admission_id'] = $input['admissionId'];
        $syringe_pump['mother_id'] = $baby_details->MotherId;
        $syringe_pump['admission_stauts'] = 2;
        $syringe_pump['height'] = null;
        $syringe_pump['weight'] = $baby_details->BirthWeight;
        $syringe_pump['blood_group'] = null;
        SyringePumpAdmisson::create($syringe_pump);
        PrescriptionToMirthController::admission();

        $nurse_main_sheet = NurseSheetMain::GetNurseSheetCount($baby_details->BabyId, $input['admissionId']);
        $nurse_main_sheet_dates = collect($nurse_main_sheet)->groupBy('sheet_date');

        $current_date = Carbon::now($this->time_zone)->format('Y-m-d');

        if (isset($nurse_main_sheet[$current_date]) && isset($nurse_main_sheet[$current_date]->id)) {
            $main_sheet_id = $nurse_main_sheet->id;
        } else {
            $day_name = 'Day ' . (count($nurse_main_sheet) + 1);
            $sheet_details['day_name'] = $day_name;
            $sheet_details['sheet_date'] = $current_date;
            $sheet_details['baby_id'] = $baby_details->BabyId;
            $sheet_details['admission_id'] = $input['admissionId'];
            $main_sheet_id = NurseSheetMain::create($sheet_details)->id;
        }

        $patient_log['day_id'] = $main_sheet_id;
        $patient_log['bed_id'] = $input['bedId'];
        $patient_log['created_date_time'] = Carbon::now($this->time_zone);
        $patient_log['created_by'] = 0;

        $day_wise_patient_bed_log = DayWisePatientBedLog::create($patient_log)->id;

        $bed_details = \DB::table('bed')
            ->select('bed.id', 'bed.id as bed_id', 'room_id', 'room.number', 'pump_type', 'hms_bed_id', 'hms_room_id', 'hms_ward_id')
            ->join('room', 'room.id', '=', 'bed.room_id')
            ->join('ward', 'ward.id', '=', 'room.ward_id')
            ->where('bed.number', (int) $bed->number)
            ->first();

        $ip_numbers = \DB::table('ip_numbers')->select('ip_number')->where('baby_id', $baby_details->BabyId)->where('AdmissionId', $input['admissionId'])->orderBy('id', 'desc')->first();

        if (isset($ip_numbers->ip_number)) {

            $his_transfer['bed_mrno'] = $baby_details->BMrNo;
            $his_transfer['bed_ipnumber'] = $ip_numbers->ip_number;
            $his_transfer['hms_bed_id'] = $bed_details->hms_bed_id;
            $his_transfer['hms_room_id'] = $bed_details->hms_room_id;
            $his_transfer['hms_ward_id'] = $bed_details->hms_ward_id;
            $his_transfer_request = new Request($his_transfer);

            HmsInterfacingController::transferPatientInHMS($his_transfer_request);
        } else {
            ErrorLogController::emergencyLogStat('Error in ip number' . $baby_details->BMrNo);
        }

        $event_input['admission_id'] = $input['admissionId'];
        $event_input['status'] = 'WARD_TRANSFER';
        ErrorLogController::emergencyLogStat('Baby ward update bed log ' . json_encode($event_input));
        broadcast(new WardEvent($event_input))->toOthers();

        \SiteHelpers::updateDashboardAtFormUpdation($baby_details->BabyId, 'Bed update');

        return \Response::json(['type' => 'success', 'message' => 'Transfer success!'], 200);
    }

    public function updateView(Request $request)
    {

        if ($request->ajax()) {

            $input = $request->all();

            $baby_id = $input['babyId'];
            $admission_id = $input['admissionId'];

            $mrn = $input['mrn'];
            $ip_number = $input['ipNumber'];
            $baby_name = $input['babyName'];
            $dob = $input['dob'];
            $gender = $input['gender'];

            $ward_name = $input['wardName'];
            $ward_id = $input['wardId'];
            $room_id = $input['roomId'];
            $room_name = $input['oldroomNo'];
            $bed_id = $input['bedId'];
            $bed_no = $input['bedNo'];

            $hms_ward_id = $input['hmsWardId'];
            $hms_room_id = $input['hmsRoomId'];
            $hms_bed_id = $input['hmsBedId'];

            $old_ward_name = $input['oldwardName'];
            $old_ward_id = $input['oldwardId'];
            $old_room_id = $input['oldroomId'];
            $old_room_name = $input['oldroomNo'];
            $old_bed_id = $input['oldBedId'];
            $old_bed_no = $input['oldbedNo'];

            $old_hms_ward_id = $input['oldHmsWardId'];
            $old_hms_room_id = $input['oldHmsRoomId'];
            $old_hms_bed_id = $input['oldHmsBedId'];

            if ($gender == 'Male' || $gender == 'MALE') {
                $index = $bed_id . ':male_baby';
            } elseif ($gender == 'Female' || $gender == 'FEMALE') {
                $index = $bed_id . ':female_baby';
            } else {
                $index = $bed_id;
            }
            $new_bed_content = '<div class="card-pf card-pf-view card-pf-view-select card-pf-view-single-select">';
            $new_bed_content .= '<span class="badge badge-success ward-names" style="display: none;">' . $ward_name . '</span>';
            $new_bed_content .= '<span class="badge badge-primary">' . $bed_no . '</span>';
            $new_bed_content .= \SiteHelpers::menuList($mrn, $admission_id, "ward");
            $new_bed_content .= '<div class="card-pf-body" style="height: 283px;">';
            $new_bed_content .= '<div class="card-pf-top-element" data-bed-name="' . $bed_no . '" data-ward-id="' . $ward_id . '" data-room-id="' . $room_id . '" data-bed-id="' . $bed_id . '">';
            $new_bed_content .= '<span class="card-pf-icon-circle bed-frame" id="bed-frame-' . $bed_id . '">';
            $site_url = url('/') . '/public';

            if (isset($gender) && ($gender == 'Male' || $gender == 'MALE')) {
                $new_bed_content .= '<img src="' . $site_url . '/img/icons/baby-boy.png" alt="Male Baby" id="bed-manangement-' . $bed_id . '" data-bed-name="' . $bed_no . '" data-ward-id="' . $ward_id . '" data-room-id="' . $room_id . '" data-bed-id="' . $bed_id . '" data-room-name="' . $room_name . '" data-hms-ward-id="' . $hms_ward_id . '" data-hms-room-id="' . $hms_room_id . '" data-hms-bed-id="hms_bed_id" class="baby-warmer-icons bed-transfer" /> ';
            } elseif (isset($gender) && ($gender == 'Female' || $gender == 'FEMALE')) {
                $new_bed_content .= '<img src="' . $site_url . '/img/icons/baby-girl.png" alt="Female Baby"  id="bed-manangement-' . $bed_id . '" data-bed-name="' . $bed_no . '" data-ward-id="' . $ward_id . '" data-room-id="' . $room_id . '" data-bed-id="' . $bed_id . '" data-room-name="' . $room_name . '" data-hms-ward-id="' . $hms_ward_id . '" data-hms-room-id="' . $hms_room_id . '" data-hms-bed-id="hms_bed_id" class="baby-warmer-icons bed-transfer" />';
            } elseif (!isset($baby_id)) {
                $new_bed_content .= '<img src="' . $site_url . '/img/icons/ward-icon.png" alt="Ward Icon" width="40" height="40" class="baby-warmer-icons bed-transfer-restricted" data-bed-name="' . $bed_no . '" data-ward-id="' . $ward_id . '" data-room-id="' . $room_id . '" data-bed-id="' . $bed_id . '" data-room-name="' . $room_name . '" data-hms-ward-id="' . $hms_ward_id . '" data-hms-room-id="' . $hms_room_id . '" data-hms-bed-id="hms_bed_id" class="baby-warmer-icons bed-transfer" id="bed-manangement-' . $bed_id . '" width="40" height="40" />';
            }
            $new_bed_content .= '</span>';
            $new_bed_content .= '</div>';
            $new_bed_content .= '<div class="bed-details-text-' . $bed_id . '">';
            $new_bed_content .= '<h2 class="card-pf-title text-center details" data-baby-id="' . $baby_id . '" data-admission-id="' . $admission_id . '">';
            if (isset($mrn)) {
                if (!is_null($mrn)) {
                    $new_bed_content .= $mrn;
                }
            }

            $indication = BedLog::getMachineStatus($baby_id, $admission_id, Carbon::now($this->time_zone), Carbon::now($this->time_zone));

            $new_bed_content .= '</h2>';
            $moniter_active = (isset($indication['monitor']) && $indication['monitor'] == 'active') ? 'text-success' : 'text-normal';
            $ventilator_active = (isset($indication['ventilator']) && $indication['ventilator'] == 'active') ? 'text-success' : 'text-normal';
            $pumb_active = (isset($indication['infusion']) && $indication['infusion'] == 'active') ? 'text-success' : 'text-normal';
            $new_bed_content .= '<div class="card-pf-items text-center">';
            $new_bed_content .= '<div class="card-pf-item bs-tooltip" data-title="Monitor">';
            $new_bed_content .= '<a href="{{ url(\'list-monitor-values/\').\'/\'.SiteHelpers::encrypt_id($baby_id).\'/\'.SiteHelpers::encrypt_id($admission_id) }}">';
            $new_bed_content .= '<span class="fas fa-pager ' . $moniter_active . '"></span>';
            $new_bed_content .= '</a>';
            $new_bed_content .= '<span class="card-pf-item-text"></span>';
            $new_bed_content .= '</div>';
            $new_bed_content .= '<div class="card-pf-item bs-tooltip" data-title="Ventilator">';
            $new_bed_content .= '<a href="{{ url(\'list-vendilator-values/\').\'/\'.SiteHelpers::encrypt_id($baby_id).\'/\'.SiteHelpers::encrypt_id($admission_id) }}">';
            $new_bed_content .= '<span class="fas fa-lungs ' . $ventilator_active . '"></span>';
            $new_bed_content .= '</a>';
            $new_bed_content .= '<span class="card-pf-item-text"></span>';
            $new_bed_content .= '</div>';
            $new_bed_content .= '<div class="card-pf-item bs-tooltip" data-title="Pump">';
            $new_bed_content .= '<a href="{{ url(\'list-infusion-values/\').\'/\'.SiteHelpers::encrypt_id($baby_id).\'/\'.SiteHelpers::encrypt_id($admission_id) }}">';
            $new_bed_content .= '<span class="fas fa-syringe ' . $pumb_active . '"></span>';
            $new_bed_content .= '</a>';
            $new_bed_content .= '</div>';
            $new_bed_content .= '</div>';
            $new_bed_content .= '<p class="card-pf-info text-center text-captialize"> ';
            if (stripos($baby_name, "UNKNOWN") !== false) {
                $new_bed_content .= '<span class="text-danger call-hms" title="Get data from HMS" data-mrn="' . $mrn . '">' . $baby_name . '  <i class="fa fa-refresh"></i></span>';
            } else {
                $new_bed_content .= $baby_name;
            }
            $new_bed_content .= '</p>';
            $new_bed_content .= '<p class="card-pf-info text-center dob-span"><strong>DOB : </strong>';
            if (!is_null($dob)) {
                $new_bed_content .= date('d-m-Y', strtotime($dob));
                $new_bed_content .= '</p>';
                $new_bed_content .= '<p class="card-pf-info text-center"><strong>IP : </strong>';
                if (!is_null($ip_number)) {
                    $new_bed_content .= $ip_number;
                }
                $new_bed_content .= '</p>';
            }

            $old_bed_content = '<div class="card-pf card-pf-view card-pf-view-select card-pf-view-single-select">';
            $old_bed_content .= '<span class="badge badge-success ward-names" style="display: none;">' . $old_ward_name . '</span>';
            $old_bed_content .= '<span class="badge badge-primary">' . $old_bed_no . '</span>';
            $old_bed_content .= '<div class="card-pf-body" style="height: 283px;">';
            $old_bed_content .= '<div class="card-pf-top-element" data-bed-name="15" data-ward-id="1" data-room-id="3" data-bed-id="15">';
            $old_bed_content .= '<span class="card-pf-icon-circle bed-frame" id="bed-frame-15">';
            $old_bed_content .= '<img src="' . $site_url . '/img/icons/ward-icon.png" alt="Ward Icon" width="40" height="40" class="baby-warmer-icons bed-transfer-restricted" data-bed-name="' . $old_bed_no . '" data-ward-id="' . $old_ward_id . '" data-room-id="' . $old_room_id . '" data-bed-id="' . $old_bed_id . '" class="baby-warmer-icons bed-transfer" id="bed-manangement-' . $old_bed_id . '" width="40" height="40" />';
            $old_bed_content .= '</span>';
            $old_bed_content .= '</div>';
            $old_bed_content .= '<div class="bed-details-text-' . $old_bed_id . '">';
            $old_bed_content .= '<h2 class="card-pf-title text-center">';
            $old_bed_content .= '<a href="javascript:void(0)" class="btn btn-success add-patient" data-add-ward-id="' . $old_ward_id . '" data-add-room-id="' . $old_room_id . '" data-add-ward-name="' . $old_ward_name . '" data-add-room-name="' . $old_room_name . '" data-add-bed-id="' . $old_bed_id . '" data-add-bed-name="' . $old_bed_no . '" data-hms-ward-id="' . $old_hms_ward_id . '" data-hms-room-id="' . $old_hms_room_id . '" data-hms-bed-id="' . $old_hms_bed_id . '">';
            $old_bed_content .= 'Admit Baby';
            $old_bed_content .= '</a>';
            $old_bed_content .= '</h2>';
            $old_bed_content .= '</div>';
            $old_bed_content .= '</div>';
            $old_bed_content .= '</div>';

            return \Response::json(['new_bed' => $new_bed_content, 'old_bed' => $old_bed_content]);
        }
    }


    public function getaddbabytobed(Request $request)
    {
        $input = $request->all();

        $babyid = $input['babyid'];
        $room = Room::find($input['roomid']);
        $bed = Bed::find($input['bedid']);
        $ward = WardMaster::find($input['wardid']);
        $admission = Admission::get_baby_lists($babyid);

        $admissionid = isset($admission->AdmissionId) ? $admission->AdmissionId : '';

        if (empty($admissionid)) {
            return \Response::json(['type' => 'error', 'message' => 'There is no admission found please contact admin !'], 500);
        }

        $baby_bed_log['ward_id'] = $input['wardid'];
        $baby_bed_log['ward_name'] = isset($ward->name) ? $ward->name : '';

        $baby_bed_log['room_id'] = $input['roomid'];
        $baby_bed_log['room_no'] = isset($room->number) ? $room->number : '';

        $baby_bed_log['bed_id'] = $input['bedid'];
        $baby_bed_log['bed_no'] = isset($bed->number) ? $bed->number : '';

        $baby_bed_log['baby_id'] = $input['babyid'];
        $baby_bed_log['status'] = 'Occupied';

        $baby_bed_log['DateModified'] = Carbon::now(env('TIME_ZONE'));
        $baby_bed_log['UserModified'] = $this
            ->auth
            ->user()->id;
        $baby_bed_log['admission_id'] = $admissionid;

        $baby_bed_log['is_syringe_pump_connected'] = (isset($input['deivceList']) && in_array('MONITOR', $input['deivceList'])) ? true : false;
        $baby_bed_log['is_infusion_pump_connected'] = (isset($input['deivceList']) && in_array('SYRINGE_PUMP', $input['deivceList'])) ? true : false;
        $baby_bed_log['is_monitor_connected'] = (isset($input['deivceList']) && in_array('INFUSION_PUMP', $input['deivceList'])) ? true : false;
        $baby_bed_log['is_ventilator_connected'] = (isset($input['deivceList']) && in_array('VENTILATOR', $input['deivceList'])) ? true : false;

        $condition['baby_id'] = $input['babyid'];
        $condition['admission_id'] = $admissionid;

        $is_baby_admitted = BedLog::where($condition)->get();

        if (count($is_baby_admitted) > 0) {
            BedLog::where($condition)->update($baby_bed_log);
        } else {
            BedLog::create($baby_bed_log);
        }

        $bed = Bed::find($input['bedid']);
        $bed->status = 'Occupied';
        $bed->save();

        return \Response::json(['type' => 'success', 'message' => 'Baby added successfully !'], 200);
    }

    public function getbabyinterchange(Request $request)
    {

        $input = $request->all();

        $babyone['baby_id'] = $input['babyIdone'];
        $babyone['admission_id'] = $input['admissionIdone'];
        $babyone['ward_id'] = $input['wardIdone'];
        $babyone['room_id'] = $input['roomIdone'];
        $babyone['bed_id'] = $input['bedIdone'];
        $babyone['DateModified']    = Carbon::now($this->zone);
        $babyone['UserModified'] = $this->auth->user()->id;
        $old_bed_id_one = $input['oldBedIdone'];
        BedLog::where(['bed_id' => $old_bed_id_one, 'baby_id' => $babyone['baby_id']])->update($babyone);
        $condition['baby_id'] = $babyone['baby_id'];
        $condition['admission_id'] = $babyone['admission_id'];
        SyringePumpAdmisson::where($condition)->Update(['admission_stauts' => 2]);
        PrescriptionToMirthController::admission();

        $babytwo['baby_id'] = $input['babyIdtwo'];
        $babytwo['admission_id'] = $input['admissionIdtwo'];
        $babytwo['ward_id'] = $input['wardIdtwo'];
        $babytwo['room_id'] = $input['roomIdtwo'];
        $babytwo['bed_id'] = $input['bedIdtwo'];
        $babytwo['DateModified']    = Carbon::now($this->zone);
        $babytwo['UserModified'] = $this->auth->user()->id;
        $old_bed_id_two = $input['oldBedIdtwo'];
        BedLog::where(['bed_id' => $old_bed_id_two, 'baby_id' => $babytwo['baby_id']])->update($babytwo);
        $condition['baby_id'] = $babytwo['baby_id'];
        $condition['admission_id'] = $babytwo['admission_id'];
        SyringePumpAdmisson::where($condition)->Update(['admission_stauts' => 2]);
        PrescriptionToMirthController::admission();
        return \Response::json(['type' => 'success', 'message' => 'Baby added successfully !'], 200);
    }

    public function dischargeurl(Request $request)
    {
        $input = $request->all();
        if (isset($input['ward_id']) && $input['ward_id'] == '1') {
            $nicu_admission = Nicu::where('BabyId', $input['babyId'])->where('AdmissionId', $input['admissionId'])->orderby('NicuId', 'desc')
                ->first();
            if (!isset($nicu_admission->NicuId)) {
                return \Response::json(['type' => 'error', 'message' => 'Nicu admission need to complete'], 500);
            }
            $redirect_id = $nicu_admission->NicuId;
            \Session::put('slug-nav', 'discharge-list');
            $edit_url = action('Admission\NicuController@dischargeedit', \SiteHelpers::encrypt_id($redirect_id));
        } elseif (isset($input['ward_id']) && $input['ward_id'] == '3') {
            $postnatal_admission = \DB::table('postnatal_discharge')->where('BabyId', $input['babyId'])->where('AdmissionId', $input['admissionId'])->orderby('posdisid', 'desc')
                ->first();
            if (!isset($postnatal_admission->posdisid)) {
                return \Response::json(['type' => 'error', 'message' => 'Postnatal admission need to complete'], 500);
            }
            $redirect_id = $postnatal_admission->posdisid;
            $edit_url = action('Admission\PostnatalDischargeController@edit', \SiteHelpers::encrypt_id($redirect_id));
        }
        if (isset($edit_url) && !empty($edit_url)) {
            return \Response::json(['type' => 'success', 'url' => $edit_url], 200);
        }
        return \Response::json(['type' => 'error', 'message' => 'Nicu admission need to complete'], 500);
    }

    public function activeBabyDetails()
    {

        $start_time = Carbon::now()->subMinute(90)
            ->format('Y-m-d H:i:s');
        $end_time = Carbon::now()->format('Y-m-d H:i:s');

        $baby_details = \DB::table('patient_bed_log')->select('BMrNo as mrn', 'ip_number', 'BabyName as baby_name', 'Sex as sex', 'DOB as dob', 'ward_id', 'ward_name', 'room_id', 'room_no', 'bed_id', 'bed_no', 'patient_bed_log.status', 'ip_numbers.AdmissionId as admission_id')
            ->distinct('BMrNo', 'ip_number', 'BabyName', 'Sex', 'DOB', 'ward_id', 'ward_name', 'room_id', 'room_no', 'bed_id', 'bed_no', 'patient_bed_log.status', 'ip_numbers.AdmissionId')
            ->join('emr_log_hdr', 'patient_bed_log.admission_id', 'emr_log_hdr.admission_id')
            ->join('emr_moniter_values', 'emr_log_hdr.id', 'emr_moniter_values.log_hdr_id')
            ->join('baby', 'patient_bed_log.baby_id', 'baby.BabyId')
            ->join('ip_numbers', 'patient_bed_log.baby_id', 'ip_numbers.baby_id')
            ->whereBetween('result_date_time', array(
                $start_time,
                $end_time
            ))->where('emr_moniter_values.create_user_id', 2)
            ->where('patient_bed_log.status', 'Occupied')
            ->orderBy('ip_numbers.AdmissionId', 'desc')
            ->get();

        return json_encode($baby_details);
    }

    public function getPatientStatus(Request $request)
    {
        $baby_mrn = $request->get('baby_mrn');
        $results = BedLog::getPatientStatus($baby_mrn);
        return \Response::json(['result' => $results]);
    }

    public function pacs($mrn)
    {

        $mrn = \SiteHelpers::decrypt_id($mrn);

        return view('pacs', compact('mrn'));
    }

    public function getBabyWardMenu(Request $request)
    {
        if ($request->ajax()) {
            $menu_content = \SiteHelpers::menuList($request->get('baby_mrn'), 0, 'ward');
            return \Response::json(['menu_list' => $menu_content]);
        }
        return redirect('/');
    }

    public function wardview(Request $request)
    {

        $input = $request->all();
        $baby_id = \SiteHelpers::decrypt_id($input['baby_id']);
        $bed_no = \SiteHelpers::decrypt_id($input['bed_no']);
        $mrn = $input['mrn'];
        $admission_date = $input['admission_date'];
        $inpatient_list = $this->ward->getbaby()->groupBy('bed_no')->toArray();

        $inpatient_beds = array_keys($inpatient_list);
        sort($inpatient_beds);

        $index = array_search($bed_no, $inpatient_beds);
        $prev_url = $next_url = null;

        if ($index !== false && $index > 0) {

            $prev_data = $inpatient_list[$inpatient_beds[$index - 1]][0];

            if (isset($prev_data->BMrNo)) {
                $prev_mrn = $prev_data->BMrNo;
                $prev_admission_date = $prev_data->AdmissionDate;
                $prev_bed_no = $prev_data->bed_no;
                $prev_baby_id = $prev_data->baby_id;

                $prev_url = action('Ward\BabyWardController@wardview') . '?mrn=' . $prev_mrn . '&admission_date=' . $prev_admission_date . '&bed_no=' . \SiteHelpers::encrypt_id($prev_bed_no) . '&baby_id=' . \SiteHelpers::encrypt_id($prev_baby_id);
            }
        }
        if ($index !== false && $index < count($inpatient_beds) - 1) {
            $next_data = $inpatient_list[$inpatient_beds[$index + 1]][0];

            if (isset($next_data->BMrNo)) {
                $next_mrn = $next_data->BMrNo;
                $next_admission_date = $next_data->AdmissionDate;
                $next_bed_no = $next_data->bed_no;
                $next_baby_id = $next_data->baby_id;

                $next_url = action('Ward\BabyWardController@wardview') . '?mrn=' . $next_mrn . '&admission_date=' . $next_admission_date . '&bed_no=' . \SiteHelpers::encrypt_id($next_bed_no) . '&baby_id=' . \SiteHelpers::encrypt_id($next_baby_id);
            }
        }

        return view('ward_dashboard_view', compact('baby_id', 'bed_no', 'mrn', 'admission_date', 'prev_url', 'next_url'));
    }

    public function getPacsStudies(Request $request)
    {
        $input = $request->all();

        $username = 'neonatal';
        $password = 'Ne0natal#';

        $auth = base64_encode($username . ':' . $password);

        $mrn = $input['mrn'];
        $modality = $input['modality'];
        $admission_date = $input['admission_date'];

        $url = \SiteHelpers::pacsViewerLink(2);

        $url = str_replace('MRN', $mrn, $url);
        $url = str_replace('MODALITY', $modality, $url);
        $url = str_replace('ADMISSION_DATE', $admission_date, $url);

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => "Basic " . $auth
            ]
        ]);

        $response_data = $response->getBody();
        $response_data = $response_data->getContents();

        $content_type = 'image/png';
        // $rows = '1024';
        $rows = 100;
        $image_list = [];
        $image_url = '';

        $response_data = json_decode($response_data);
        if (isset($response_data->studyList)) {
            $studies = collect($response_data->studyList)->toArray();
            $i = 0;
            foreach ($studies as $study_list) {
                $temp_study_list = collect($study_list)->toArray();
                $study_list = $temp_study_list['seriesList'];
                foreach ($study_list as $series_list) {
                    $temp_series_list = collect($series_list)->toArray();
                    $series_list = $temp_series_list['instanceList'];
                    foreach ($series_list as $value) {
                        $image_list[$i]['patient_name'] = explode('^', $response_data->patientName)[0] . ' / ' . $response_data->patientGender;
                        $image_list[$i]['study_id'] = $temp_study_list['studyIUID'];
                        $image_list[$i]['temp_study_date_time'] = date('Y-m-d H:i:s', strtotime($temp_study_list['studyDateTime']));
                        $image_list[$i]['study_date_time'] = date('d-m-Y h:i A', strtotime($temp_study_list['studyDateTime']));
                        $image_list[$i]['modality'] = $temp_series_list['modality'];
                        $image_list[$i]['series_id'] = $temp_series_list['seriesIUID'];
                        $image_list[$i]['series_description'] = $temp_series_list['seriesDesc'];
                        $image_list[$i]['instance_id'] = $value->instanceId;
                        $image_list[$i]['content_type'] = $content_type;
                        $image_list[$i]['rows'] = $rows;
                        $i++;
                    }
                }
            }
            $image_url = \SiteHelpers::pacsViewerLink(3);
        }
        return \Response::json(['image_list' => $image_list, 'image_url' => $image_url]);
    }

    public function wardDashboardViewUpdate(Request $request)
    {
        $input = $request->all();
        $baby_id = $input['baby_id'];
        $page_no = $input['page_no'];
        $module_name = 'NICU Ward Dashboard';
        $bed_details = \DB::table('patient_bed_log')->where('baby_id', $baby_id)->orderBy('id', 'desc')->first();
        if (isset($bed_details->bed_no)) {
            $check_exist = \DB::table('nicu_dashboard_results')->where('bed', $bed_details->bed_no)->first();

            if (count($check_exist) > 0) {
                ErrorLogController::emergencyLogStat('NICU Dashboard - updated at ' . date('Y-m-d H:i:s') . ' (' . $baby_id . ' * ' . $module_name . ')');
                $input['modify_tstamp'] = date('Y-m-d H:i:s');
                $input['modify_user_id'] = $this->auth->user()->id;
                $check_exist = \DB::table('nicu_dashboard_results')->where('id', $check_exist->id)->update(['need_data' => true, 'modify_tstamp' => Carbon::now(), 'modify_user_id' => $this->auth->user()->id, 'page_no' => $page_no]);
                NicuDashboardController::updateDashboardData();
            }
        }
    }

    public static function getBabyBedDetails(Request $request)
    {
        $input = $request->all();
        $admission_id = $input['admission_id'];
        $bed_details = BedLog::getBedDetails($admission_id);


        if (!isset($bed_details['baby_id'])) {
            ErrorLogController::emergencyLogStat('ERROR: Admission ' . $admission_id);
        }

        $bed_details['en_baby_id'] = \SiteHelpers::encrypt_id($bed_details['baby_id']);
        $bed_details['en_admission_id'] = \SiteHelpers::encrypt_id($admission_id);

        $bed_details['menu_list'] = \SiteHelpers::menuList($bed_details['BMrNo'], $admission_id, "ward");
        $indication = BedLog::getMachineStatus($bed_details['baby_id'], $admission_id, Carbon::now(), Carbon::now());

        $bed_details['moniter_active'] = (isset($indication['monitor']) && $indication['monitor'] == 'active') ? 'text-success' : 'text-normal';
        $bed_details['ventilator_active'] = (isset($indication['ventilator']) && $indication['ventilator'] == 'active') ? 'text-success' : 'text-normal';
        $bed_details['pumb_active'] = (isset($indication['infusion']) && $indication['infusion'] == 'active') ? 'text-success' : 'text-normal';
        // $bed_details = (object)$bed_details;
        return json_encode($bed_details);
    }

    public static function getBedList()
    {
        $list = \SiteHelpers::getNicuFreeBeds(true);
        return json_encode($list);
    }


    public static function getNICUInpatientList()
    {
        // echo "<pre>"; print_r(BedLog::getNicuInpatientBabyList()); echo "</pre>"; exit;
        return json_encode(BedLog::getNicuInpatientBabyList());
    }
}
