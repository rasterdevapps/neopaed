<?php
namespace App\Http\Controllers\Nurse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Baby;
use App\Exceptions\InvalidInputException;
use App\Models\Nurse\EmrLogHeader;
use App\Models\Nurse\EmrLogDetails;
use App\Models\Nurse\NurseSheetMain;
use App\Models\Nurse\NurseHourSheet;
use App\Models\Ward\BedLog;
use Carbon\Carbon;
use App\Models\IpNumber;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Models\Snomed\SnomedConcept;
use App\Models\Snomed\SnomedDescription;
use App\Models\Masters\NurseMaster;
use App\Models\Settings\Settings;
use App\Http\Controllers\Nurse\DialpadSupportProperty;
use App\Models\Fhir\FhirFormatedValues;
use App\Http\Controllers\Nurse\LabImportedController;

use App\Models\Nurse\NurseIvInfusion;
use App\Models\Nurse\NurseOtherIvDrugs;
use App\Models\Nurse\NurseOtherIvInfusion;
use App\Models\Nurse\NurseGlucoseIntake;
use App\Models\Nurse\NurseOralDrugs;
use App\Models\Admission;
use App\Models\DischargeLog;
use Excel;

use App\Models\Nurse\EmrMoniterValues;
use App\Models\Masters\DrugIvFluidMaster;
use App\Models\prescription;
use App\Models\Machine\MachineDataFormter;
use App\Http\Controllers\InterfaceData\InterfaceDataController;
use App\Models\DashboardEvent;
use App\Models\Nicu;
use App\Models\Nurse\DayWisePatientBedLog;
use App\Models\FileUpload;
use App\Events\PrescriptionEvent;

class NurseSheetController extends Controller
{
    /**
     * @var $auth type object
     */
    public $auth;

    /**
     *@var $emr_log_head type object
     */
    public $emr_log_head;

    /**
     * @var $time_zone type string
     */
    public $time_zone;

    /**
     * @var $loinc_values type array
     */
    public $loinc_values;

    /**
     * @var $loinc_group_values type array
     */
    public $loinc_group_values;

    /**
     * @var $time_interval type integer
     */
    public $time_interval;

    /**
     * @var $error_log type object
     */
    public $error_log;

    /**
     * @var $interface_data type object
     */
    public $interface_data;

    public function __construct(Guard $auth, EmrLogHeader $emr_log_head, ErrorLogController $error_log, InterfaceDataController $interface_data)
    {
        $this->middleware('role:NICU_MODULE_SHEET,write', ['only' => ['store', 'update', 'edit', 'create', 'destory']]);
        $this->middleware('role:NICU_MODULE_SHEET,read', ['only' => ['index', 'show']]);
        $this->auth = $auth;
        $this->emr_log_head = $emr_log_head;
        $this->time_zone = env('TIME_ZONE');
        $this->loinc_values = json_decode(\SiteHelpers::getConfigSettings('LOINC_LOCAL_CODE'));
        $this->loinc_group_values = DialpadSupportProperty::LOINC_LOCAL_CODE_GROUP;
        $this->time_interval = 1;
        $this->navigate['main_nav'] = 'nicu_nurse_sheet';
        $this->navigate['sub_nav'] = 'nicu_nurse_sheet';
        $this->custom_error = new ErrorLogController();
        $this->interface_data = new InterfaceDataController();   
        $this->monitor_user = 2;
        $this->ventilator_user = 3;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $limit = 50;

        //set the limit as per the request
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
        $order['sortby'] = '';
        $order['sortorder'] = '';
        //set the records sorting key and order
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder')))
        {
            $order['sortby'] = \SiteHelpers::decrypt_id($request->input('sortby'));
            $order['sortorder'] = $request->input('sortorder');

        }

        //initialize search parameter array
        $search = array();
        $search['search_txt'] = '';
        if (!empty($request->input('search_txt')))
        {

            $search['search_txt'] = $request->input('search_txt');

        }
        // $results  = NurseSheetMain::GetBabyLists()->toArray();
        $result = NurseSheetMain::GetBabyLists($request->input('page') , $limit, $search, $order, 1);
        $results = $result['result'];
        $total = $result['total'];
        $getTotal = NurseSheetMain::GetBabyListTotal();

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

        $navigate = $this->navigate;
        return view('nurse_sheet.list', compact('results', 'navigate', 'total', 'pagination', 'search', 'order', 'getTotal'));
    }

    /**
     * Display a admission listing of the resource
     *
     *@param $baby_id type integer
     *@return \Illuminate\Http\Response
     */
    public function GetAdmissionlist($baby_id)
    {

        $baby_id = \SiteHelpers::decrypt_id($baby_id);
        $admission_list = NurseSheetMain::GetAdmissionLists($baby_id);
        $navigate = $this->navigate;
        $baby_details = Baby::find($baby_id);
        $baby_mrno = $baby_details->BMrNo;

        return view('nurse_sheet.admission_list', compact('admission_list', 'navigate', 'baby_mrno', 'baby_details'));
    }

    /**
     * Display a daylist listing of the resource
     *
     *@param $baby_id type integer
     *@return \Illuminate\Http\Response
     */
    public function GetDaylist($admission_id, $closewinlink = '', Request $request)
    {
        $input = $request->all();
        $baby_id = 0;
        if (isset($input['list']) && $input['list']) {
            $baby_id = \SiteHelpers::decrypt_id($admission_id);
            $admission_list = NurseSheetMain::GetAdmissionLists($baby_id)->toArray();
            $final_admission = end($admission_list);
            $admission_id = \SiteHelpers::encrypt_id($final_admission->AdmissionId);            
        }

        if ($request->ajax()) {
            $admission_id = \SiteHelpers::encrypt_id($admission_id);
        }

        $admission_id = \SiteHelpers::decrypt_id($admission_id);
        $day_list = NurseSheetMain::GetDayLists($admission_id);
        $navigate = $this->navigate;
        $baby_details = array();
        $monitor_data_table_name = 'emr_moniter_values';
        $emr_details_table_name = 'emr_log_dtl';

        if ($baby_id == 0) {        
            $baby = Admission::getBabyMrn($admission_id);
            $baby_id = $baby->BabyId;
        }
        
        $patient_status = DischargeLog::getDischargeDetail($baby_id, $admission_id);

        if (count($patient_status) > 0) {
            $monitor_data_table_name = 'emr_moniter_values_discharged';
        }

        $get_monitor_entry_dates = NurseSheetMain::GetMonitorEntryDates($admission_id, $monitor_data_table_name)->pluck('sender_time')->toArray();

        if (count($get_monitor_entry_dates) == 0) {
            $get_monitor_entry_dates = NurseSheetMain::GetMonitorEntryDates($admission_id, $emr_details_table_name)->pluck('sender_time')->toArray();
        }

        $visit_ids = $day_list->pluck('id');

        $day_list = $day_list->unique('sheet_date')->sortByDesc('sheet_date')->toArray();

        if (isset($day_list[0]->BabyId))
        {
            $baby_details = Baby::find($day_list[0]->BabyId);
        }
        else
        {
            $baby_details = Admission::getBabyMrn($admission_id);
        }

        $admission_list = NurseSheetMain::GetAdmissionLists($baby_details->BabyId)->toArray();

        if (isset(end($admission_list)->AdmissionId)) {
            $latest_admission_id = end($admission_list)->AdmissionId;
        } else {
            return \Redirect::back()
            ->with('error', 'Please completed the admission process');
        }
        $file_list = FileUpload::getList($visit_ids, 2);

        $menu_list = \SiteHelpers::menuList($baby_details->BMrNo, $admission_id, 'nurse_sheet_day_list');

        if ($request->ajax()) {
            $day_list = collect($day_list)->map(function($list)
            {
                $list->encrypted_baby_id = \SiteHelpers::encrypt_id($list->BabyId);
                $list->encrypted_admission_id = \SiteHelpers::encrypt_id($list->admission_id);
                $list->encrypted_baby_admission_id = \SiteHelpers::encrypt_id($list->BabyId.'-'.$list->admission_id);
                $list->encrypted_id = \SiteHelpers::encrypt_id($list->id);
                return $list;
            })->toArray();
            return \Response::json(['type' => 'success', 'message' => 'Successfully !', 'day_list'=>$day_list, 'menu_list'=>$menu_list], 200);
        } else {
            return view('nurse_sheet.daylist', compact('day_list', 'navigate', 'baby_details', 'admission_id', 'closewinlink', 'latest_admission_id', 'file_list', 'menu_list'));            
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $babies = array();
        $baby = Baby::baby_list_daycare();

        $babies = \ValuelistHelpers::select2DataFormater($baby);

        $navigate['main_nav'] = 'nicu_nurse_sheet';
        $navigate['sub_nav'] = 'nicu_nurse_sheet';

        $SubmitButtonText = 'Start';
        $time_master = \SiteHelpers::prepare_time();

        $currrent_time['today'] = Carbon::now($this->time_zone)->format('d-m-Y');
        $currrent_time['hour'] = (int)Carbon::now($this->time_zone)->format('h');
        $currrent_time['mins'] = (int)Carbon::now($this->time_zone)->format('i');
        $currrent_time['session'] = Carbon::now($this->time_zone)->format('A');

        return view('nurse_sheet.select', compact('babies', 'SubmitButtonText', 'time_master', 'currrent_time', 'navigate'));

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

        if (!isset($input['sheet_date']) || !isset($input['time_hour']) || !isset($input['time_min']) || !isset($input['time_session'])) {
            return \Response::json(['type' => 'error', 'message' => 'Invalid date']);            
        }

        $input['time_hour'] = strlen($input['time_hour']) == 1 ? '0' . $input['time_hour'] : $input['time_hour'];
        $input['time_min'] = strlen($input['time_min']) == 1 ? '0' . $input['time_min'] : $input['time_min'];
        $input['time_session'] = isset($input['time_session']) ? $input['time_session'] : null;

        $time = $input['sheet_date'] . ' ' . $input['time_hour'] . ':' . $input['time_min'] . ' ' . $input['time_session'];
        $stored_result = array();
        //checks time sheet exists
        $sheets = NurseSheetMain::GetEmrHeaderChecks($input['sheet_date'], $input['BabyId'], $input['AdmissionId'], date('Y-m-d H:i:s', strtotime($time)));

        $total_input_calculation = false;
        if (isset($input['working_weight']) && (isset($input['milk_volume']) || isset($input['pump_drug_total']) || isset($input['drug_total']))) {
            $total_input_calculation = true;
        }

        $total_output_calculation = false;
        if (isset($input['working_weight']) && (isset($input['gastric_aspirate_volume']) || isset($input['urine_output']) || isset($input['blood_volume_out']) || isset($input['drain_output_r']) || isset($input['drain_output_l']))) {
            $total_output_calculation = true;
        }

        $sheet_basic_input['dcp'] = $input['dcp'];
        $sheet_basic_input['hemolysis'] = $input['hemolysis'];
        $sheet_basic_input['current_weight'] = isset($input['current_weight']) ? $input['current_weight'] : null;
        $sheet_basic_input['working_weight'] = isset($input['working_weight']) ? $input['working_weight'] : null;
        if (isset($input['ett_status'])) {
            $sheet_basic_input['ett_status'] = $input['ett_status'];
            $sheet_basic_input['et_size'] = isset($input['et_size']) ? $input['et_size'] : null;
            $sheet_basic_input['et_length'] = isset($input['et_length']) ? $input['et_length'] : null;
        }
        if (isset($input['ngt_status'])) {
            $sheet_basic_input['ngt_status'] = $input['ngt_status'];
            $sheet_basic_input['ngt_size'] = isset($input['ngt_size']) ? $input['ngt_size'] : null;
            $sheet_basic_input['ngt_length'] = isset($input['ngt_length']) ? $input['ngt_length'] : null;
        }

        $post['admission_id'] = $input['AdmissionId'];
        $post['working_weight'] = $input['working_weight'];

        broadcast(new PrescriptionEvent($post))->toOthers();

        // throw the response if sheets exists
        if (count($sheets) > 0 && $request->ajax())
        {
            $emr_log_head_id['id'] = $sheets->id;
            NurseSheetMain::where('id', $sheets->main_sheet_id)->update($sheet_basic_input);
            if (isset($input['added_nurse']) && !empty($input['added_nurse'])) {
                EmrLogHeader::where('id', $emr_log_head_id['id'])->update(['added_nurse' => $input['added_nurse']]);
            }

        }
        elseif (count($sheets) > 0 && !$request->ajax())
        {
            $emr_log_head_id['id'] = $sheets->id;
            if (isset($input['added_nurse']) && !empty($input['added_nurse'])) {
                EmrLogHeader::where('id', $emr_log_head_id['id'])->update(['added_nurse' => $input['added_nurse']]);
            }
        }
        else
        {
            $sheet_details = NurseSheetMain::GetNurseSheet($input['sheet_date'], $input['BabyId'], $input['AdmissionId']);

            $bed_details = BedLog::getBedDeatails($input['BabyId'], $input['AdmissionId']);
            
            if (count($sheet_details) > 0)
            {
                $sheet_id = $sheet_details->id;
                $this->updateLabFlag($sheet_id);

                $old_bed_details = DayWisePatientBedLog::where('day_id', $sheet_id)->orderBy('id', 'desc')->first();

                if (isset($bed_details->bed_id) && (!isset($old_bed_details->bed_id) || (isset($old_bed_details->bed_id) && $old_bed_details->bed_id != $bed_details->bed_id))) {
                    $patient_log['day_id'] = $sheet_id;
                    $patient_log['bed_id'] = isset($bed_details->bed_id) ? $bed_details->bed_id : 0;
                    $patient_log['created_date_time'] = Carbon::now($this->time_zone);
                    $patient_log['created_by'] = $this->auth->user()->id;

                    DayWisePatientBedLog::create($patient_log);
                }

            }
            else
            {

                $dayCount = count(NurseSheetMain::GetNurseSheetCount($input['BabyId'], $input['AdmissionId']));

                $sheet_details['day_name'] = 'Day ' . ($dayCount + 1);
                $sheet_details['sheet_date'] = date('Y-m-d', strtotime($input['sheet_date']));
                $sheet_details['baby_id'] = $input['BabyId'];
                $sheet_details['admission_id'] = $input['AdmissionId'];
                $sheet_details['added_nurse'] = $input['added_nurse'];

                $sheet_details = array_merge($sheet_details, $sheet_basic_input);

                $sheet_id = NurseSheetMain::create($sheet_details)->id;

                $patient_log['day_id'] = $sheet_id;
                $patient_log['bed_id'] = isset($bed_details->bed_id) ? $bed_details->bed_id : 0;
                $patient_log['created_date_time'] = Carbon::now($this->time_zone);
                $patient_log['created_by'] = $this->auth->user()->id;

                DayWisePatientBedLog::create($patient_log);

            }

            $baby_details = Baby::find($input['BabyId']);

            $sheet_id = isset($sheet_id) ? $sheet_id : null;

            $admission_id = isset($input['AdmissionId']) ? $input['AdmissionId'] : null;

            $emr_log_head_id['id'] = $this->addemrlog($sheet_id, $baby_details, date('Y-m-d H:i:s', strtotime($time)), $input, $admission_id);

        }
        

        //master loinc set
        $loinc_reference = EmrLogHeader::get_details_all();

        foreach ($this->loinc_values as $key => $value)
        {
            $result = (array)$loinc_reference->where('local_code', $value)->first();

            if (count($result) > 0 && isset($input[$value]))
            {

                $result = collect($result)->toArray();
                $sub_sheet_values["log_hdr_id"] = $emr_log_head_id['id'];
                $sub_sheet_values["loinc_local_map_id"] = $result['ref_loc_master_id'];
                $sub_sheet_values["intf_ref_value"] = $input[$value];
                $sub_sheet_values["property"] = $result['property'];
                $sub_sheet_values["result_date_time"] = date('Y-m-d H:i:s', strtotime($time));
                $sub_sheet_values["scale"] = $result["scale_typ"];
                $sub_sheet_values["method"] = $result["method_typ"];
                $sub_sheet_values["create_user_id"] = $this->auth->user()->id;
                $sub_sheet_values["create_tstamp"] = date('Y-m-d H:i:s', time());
                $sub_sheet_values["modify_user_id"] = $this->auth->user()->id;
                $sub_sheet_values["modify_tstamp"] = date('Y-m-d H:i:s', time());
                if ($value != 'ward_rounds_instruction') {
                    $sub_sheet_values["mean"] = $input[$value];
                }
                $sub_sheet_values["original_intf_ref_value"] = $input[$value];

                $log_deatails_condition["log_hdr_id"] = $emr_log_head_id['id'];
                $log_deatails_condition["loinc_local_map_id"] = $result['ref_loc_master_id'];
                if (in_array($value, DialpadSupportProperty::EMR_NURSE_MANUAL_VALUES))
                {
                    $current_table_name = 'emr_nurse_manual_values';
                    if (isset($sub_sheet_values["result_status"])) {
                        unset($sub_sheet_values["result_status"]);
                    }
                }
                elseif (in_array($value, DialpadSupportProperty::EMR_MONITER_VALUES))
                {
                    $current_table_name = 'emr_moniter_values';
                    $sub_sheet_values["device_model"] = 'MINDRAY_N-SERIES';
                }
                elseif (in_array($value, DialpadSupportProperty::EMR_VENTILATOR_VALUES))
                {
                    $current_table_name = 'emr_ventilator_values';
                    
                    if ($value == 'mode_of_ventilation_invasive' && empty($input['mode_of_ventilation'])) {
                        $get_invasive_ventilation_value = \DB::table('emr_ventilator_values')->where('log_hdr_id', $emr_log_head_id['id'])->where('loinc_local_map_id', '47')->orderBy('id', 'desc')->first();
                        if (count($get_invasive_ventilation_value) != 0 && isset($get_invasive_ventilation_value->id)) {
                            \DB::table('emr_ventilator_values')->where('log_hdr_id', $emr_log_head_id['id'])->where('loinc_local_map_id', '47')->update(['intf_ref_value' => null, 'mean' => null, 'original_intf_ref_value' => null]);
                        }
                    }

                    if ($value == 'mode_of_ventilation' && empty($input['mode_of_ventilation_invasive'])) {
                        $get_ventilation_value = \DB::table('emr_ventilator_values')->where('log_hdr_id', $emr_log_head_id['id'])->where('loinc_local_map_id', '225')->orderBy('id', 'desc')->first();
                        if (count($get_ventilation_value) != 0 && isset($get_ventilation_value->id)) {
                            \DB::table('emr_ventilator_values')->where('log_hdr_id', $emr_log_head_id['id'])->where('loinc_local_map_id', '225')->update(['intf_ref_value' => null, 'mean' => null, 'original_intf_ref_value' => null]);
                        }
                    }
                }
                elseif (in_array($value, DialpadSupportProperty::EMR_LAB_VALUES))
                {
                    $current_table_name = 'emr_lab_values';
                    $sub_sheet_values["result_status"] = 'final';
                }
                elseif (in_array($value, DialpadSupportProperty::EMR_NURSE_HEADER_VALUES))
                {
                    if (isset($input['added_nurse']) && !empty($input['added_nurse']))
                    {
                        EmrLogHeader::where('id', $emr_log_head_id['id'])->update(['added_nurse' => $input['added_nurse'], 'modify_tstamp' => Carbon::now($this->time_zone), 'modify_user_id' => $this->auth->user()->id]);
                    }
                }

                else
                {
                    if ($request->ajax())
                    {

                        return \Response::json(['type' => 'error', 'message' => 'Something went wrong...!'.$value], 500);
                    }
                    continue;

                }

                $log_details = \DB::table($current_table_name)->where($log_deatails_condition)->first();

                if (count($log_details) > 0)
                {
                    if ($log_details->intf_ref_value != $input[$value])
                    {
                        if ($value == 'ward_rounds_instruction') {
                            $emr_logs = \DB::table($current_table_name)->where('id', $log_details->id)->update(['intf_ref_value' => $input[$value], 'original_intf_ref_value' => $input[$value], 'modify_tstamp' => Carbon::now($this->time_zone), 'modify_user_id' => $this->auth->user()->id]);
                        } else {
                            $emr_logs = \DB::table($current_table_name)->where('id', $log_details->id)->update(['intf_ref_value' => $input[$value], 'mean' => $input[$value], 'original_intf_ref_value' => $input[$value], 'modify_tstamp' => Carbon::now($this->time_zone), 'modify_user_id' => $this->auth->user()->id]);
                        }

                    }
                    $stored_result[$value] = $input[$value];
                }
                else
                {
                    if (($current_table_name == 'emr_nurse_manual_values' || $current_table_name == 'emr_moniter_values' || $current_table_name == 'emr_ventilator_values') && isset($sub_sheet_values['result_status'])) {
                        unset($sub_sheet_values['result_status']);
                    }
                    if ($current_table_name == 'emr_lab_values' && isset($sub_sheet_values['device_model'])) {
                        unset($sub_sheet_values['device_model']);
                    }
                    \DB::table($current_table_name)->insert($sub_sheet_values);
                    $stored_result[$value] = $input[$value];
                }
            }
        }
        
        if (isset($input['phototherapy'])) {
            $input['phototherapy'] = isset($input['phototherapy']) ? $input['phototherapy'] : null;
            $this->addmultiple_replacement($emr_log_head_id['id'], $input['phototherapy'], 'phototherapy', '0');
            $stored_result['phototherapy'] = $input['phototherapy'];
        }
        if (isset($input['phototherapy_eyes'])) {
            $input['phototherapy_eyes'] = isset($input['phototherapy_eyes']) ? $input['phototherapy_eyes'] : null;
            $this->addmultiple_replacement($emr_log_head_id['id'], $input['phototherapy_eyes'], 'phototherapy_eyes', '0');
            $stored_result['phototherapy_eyes'] = $input['phototherapy_eyes'];
        }
        if (isset($input['replacement_fluids_status']) && !empty($input['replacement_fluids_status']))
        {
            $this->addmultiple_replacement($emr_log_head_id['id'], $input['replacement_fluids_status'], 'replacement_fluids_status', '0');
            $stored_result['replacement_fluids_status'] = $input['replacement_fluids_status'];
        }

        // replacement fluids store
        if (isset($input['replacement_fluids_solution']) && isset($input['replacement_fluids_rate']) && isset($input['replacement_fluids_total']))
        {

            for ($i = 0;$i < count($input['replacement_fluids_solution']);$i++)
            {
                if ($input['replacement_fluids_solution'][$i] != '')
                {
                    $observation_type_id = 0;
                    $observation_type_id = $this->addmultiple_replacement($emr_log_head_id['id'], $input['replacement_fluids_solution'][$i], 'replacement_fluids_solution', $observation_type_id);
                    $stored_result['replacement_fluids_solution'][$i] = $input['replacement_fluids_solution'][$i];

                    $this->addmultiple_replacement($emr_log_head_id['id'], $input['replacement_fluids_rate'][$i], 'replacement_fluids_rate', $observation_type_id);
                    $stored_result['replacement_fluids_rate'][$i] = $input['replacement_fluids_rate'][$i];

                    $this->addmultiple_replacement($emr_log_head_id['id'], $input['replacement_fluids_total'][$i], 'replacement_fluids_total', $observation_type_id);
                    $stored_result['replacement_fluids_total'][$i] = $input['replacement_fluids_total'][$i];
                }
            }
        }

        // blood product store
        if (isset($input['F_Product']) && isset($input['F_Volume']))
        {

            $result = $loinc_reference->where('local_code', 'F_Product')->first();
            $result1 = $loinc_reference->where('local_code', 'F_Volume')->first();

            for ($i = 0;$i < count($input['F_Product']);$i++)
            {

                if ($input['F_Product'][$i] != '')
                {
                    $observation_type_id = 0;
                    $observation_type_id = $this->addmultiplelist($emr_log_head_id['id'], $input['F_Product'][$i], $result, $observation_type_id);
                    $stored_result['F_Product'][$i] = $input['F_Product'][$i];

                    $this->addmultiplelist($emr_log_head_id['id'], $input['F_Volume'][$i], $result1, $observation_type_id);
                    $stored_result['F_Volume'][$i] = $input['F_Volume'][$i];
                }

            }

        }

        // IV Fluids, Parenteral Nutrition And Drug Infusion
        if (isset($input['drug_solution']) && isset($input['drug_rate']) && isset($input['drug_total']))
        {

            $drug_solution = $loinc_reference->where('local_code', 'drug_solution')->first();
            $drug_rate = $loinc_reference->where('local_code', 'drug_rate')->first();
            $drug_total = $loinc_reference->where('local_code', 'drug_total')->first();

            foreach ($input['drug_solution'] as $key => $value)
            {

                if (is_array($input['drug_solution'][$key]))
                {
                    $key_val = explode(':', $key)[0];
                    $values = [$key_val];
                    $today_start = Carbon::now($this->time_zone)->format('Y-m-d 00:00:00');
                    $today_current = Carbon::now($this->time_zone)->format('Y-m-d H:i:s');

                    if (is_numeric($key_val)) {
                        $is_exist_fhir = EmrLogDetails::compareFhirPrescribeddata(['log_hdr_id'], $input['BabyId'], $input['AdmissionId'], $today_start, $today_current, $values);
                    } else {
                        $is_exist_fhir = [];
                    }

                    if (count($is_exist_fhir) == 0)
                    {
                        $observation_type_id = 0;
                        $solution_key = array_key_first($input['drug_solution'][$key]);
                        $observation_type_id = $this->addmultiplelist($emr_log_head_id['id'], $input['drug_solution'][$key][$solution_key], $drug_solution, $observation_type_id);
                        $stored_result['drug_solution'][$key] = $input['drug_solution'][$key][$solution_key];

                        $rate_key = array_key_first($input['drug_rate'][$key]);
                        $this->addmultiplelist($emr_log_head_id['id'], $input['drug_rate'][$key][$rate_key], $drug_rate, $observation_type_id);
                        $stored_result['drug_rate'][$key] = $input['drug_rate'][$key][$rate_key];

                        $total_key = array_key_first($input['drug_total'][$key]);
                        $this->addmultiplelist($emr_log_head_id['id'], $input['drug_total'][$key][$total_key], $drug_total, $observation_type_id);
                        $stored_result['drug_total'][$key] = $input['drug_total'][$key][$total_key];

                    } else {

                        $key_val = explode(':', $key)[0];

                        $solution_key = array_key_first($input['drug_solution'][$key]);
                        $solution_value = $input['drug_solution'][$key][$solution_key];

                        $rate_key = array_key_first($input['drug_rate'][$key]);
                        $rate_value = $input['drug_rate'][$key][$rate_key];

                        $total_key = array_key_first($input['drug_total'][$key]);
                        $total_value = $input['drug_total'][$key][$total_key];

                        EmrLogDetails::where('id', $solution_key)->Update(['intf_ref_value' => $solution_value, 'mean' => $solution_value, 'original_intf_ref_value' => $solution_value, 'modify_tstamp' => Carbon::now($this->time_zone), 'modify_user_id' => $this->auth->user()->id]);
                        EmrLogDetails::where('id', $rate_key)->Update(['intf_ref_value' => $rate_value, 'mean' => $rate_value, 'original_intf_ref_value' => $rate_value, 'modify_tstamp' => Carbon::now($this->time_zone), 'modify_user_id' => $this->auth->user()->id]);
                        EmrLogDetails::where('id', $total_key)->Update(['intf_ref_value' => $total_value, 'mean' => $total_value, 'original_intf_ref_value' => $total_value, 'modify_tstamp' => Carbon::now($this->time_zone), 'modify_user_id' => $this->auth->user()->id]);

                    }
                }
            }
        }

        if (isset($input['A_Antibiotic']) && isset($input['A_Day']))
        {

            $a_antibiotic = $loinc_reference->where('local_code', 'A_Antibiotic')->first();
            $a_day = $loinc_reference->where('local_code', 'A_Day')->first();

            for ($i = 0;$i < count($input['A_Antibiotic']);$i++)
            {
                if ($input['A_Antibiotic'][$i] != '')
                {

                    $observation_type_id = 0;
                    $observation_type_id = $this->addmultiplelist($emr_log_head_id['id'], $input['A_Antibiotic'][$i], $a_antibiotic, $observation_type_id);
                    $stored_result['A_Antibiotic'][$i] = $input['A_Antibiotic'][$i];

                    $this->addmultiplelist($emr_log_head_id['id'], $input['A_Day'][$i], $a_day, $observation_type_id);
                    $stored_result['A_Day'][$i] = $input['A_Day'][$i];
                }
            }
        }

        //other drugs store
        if (isset($input['drugs']))
        {
            $drug_solution = $loinc_reference->where('local_code', 'drugs')
            ->first();
            for ($i = 0;$i < count($input['drugs']);$i++)
            {
                if ($input['drugs'][$i] != '')
                {
                    $observation_type_id = 0;
                    $this->addmultiplelist($emr_log_head_id['id'], $input['drugs'][$i], $drug_solution, $observation_type_id);
                    $stored_result['drugs'][$i] = $input['drugs'][$i];
                }
            }
        }

        $baby_details = Baby::find($input['BabyId']);

        $time_master = \SiteHelpers::prepare_time();
        $currrent_time['today'] = Carbon::now($this->time_zone)->format('d-m-Y');
        $currrent_time['hour'] = (int)Carbon::now($this->time_zone)->format('h');
        $currrent_time['mins'] = (int)Carbon::now($this->time_zone)->format('i');
        $currrent_time['session'] = Carbon::now($this->time_zone)->format('A');


        $bot_box_content = '<table class="table table-bordered mt-10">';
        if (count($stored_result) > 0) {
            foreach ($stored_result as $stored_key => $stored_value) {
                if ($stored_key != 'drugs' && $stored_key != 'A_Day' && $stored_key != 'A_Antibiotic' && $stored_key != 'replacement_fluids_rate' && $stored_key != 'replacement_fluids_solution' && $stored_key != 'replacement_fluids_total' && $stored_key != 'drug_total' && $stored_key != 'drug_rate' && $stored_key != 'drug_solution' && $stored_key != 'F_Volume' && $stored_key != 'F_Product') {
                    $bot_box_content .= '<tr>';
                    $bot_box_content .= '<th align="center" class="text-center">';
                    $bot_box_content .= ucfirst(str_replace('_', ' ', $stored_key));
                    $bot_box_content .= '</th>';
                    $bot_box_content .= '<td align="center">';
                    $bot_box_content .= $stored_value;
                    $bot_box_content .= '</td>';
                    $bot_box_content .= '</tr>';
                }
            }
        }
        $bot_box_content .= '</table>';

        $input['admission_id'] = isset($input['AdmissionId']) ? $input['AdmissionId'] : null;

        $input['time_hour'] = $time;
        if ($total_input_calculation) {
            $this->dayTotalInput($input);
        }

        if ($total_output_calculation) {
            $this->dayTotalOutput($input);
        }
        \SiteHelpers::updateDashboardAtFormUpdation($input['BabyId'], 'Nurse sheet - create');

        if ($request->ajax())
        {
            return \Response::json(['type' => 'success', 'message' => 'Time Sheet Added Successfully !', 'stored_content'=>$bot_box_content], 200);
        }

        if ($input['print_flag'] == 2)
        {
            return redirect(action('Nurse\NurseSheetController@GetDaylist', \SiteHelpers::encrypt_id($input['AdmissionId'])))->with('Success', 'Time Sheet Added Successfully !');
        }
        return redirect(action('Nurse\NurseSheetController@edit', $sheet_id))->with('Success', 'Time Sheet Added Successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = 0)
    {
        $navigate['main_nav'] = 'nicu_nurse_sheet';
        $navigate['sub_nav'] = 'nicu_nurse_sheet';

        $id = \SiteHelpers::decrypt_id($id);

        $basic_details = $output_details = $replacement_fluids = array();

        if (count(explode('-', $id)) == 2)
        {

            $id = explode('-', $id);
            $admission_id = $id[0];
            $baby_id = $id[1];
        }
        else
        {
            throw new InvalidInputException(\SiteHelpers::getUserExceptionMessage('7005') , 7005);
        }

        $baby_details = Baby::find($baby_id);
        $time_master = \SiteHelpers::prepare_time();

        $yesterday_date = Carbon::yesterday()->format('Y-m-d');
        $current_date = Carbon::now()->format('Y-m-d');

        $today_day = NurseSheetMain::GetPrevousDayNurse($baby_id, $admission_id, $current_date);
        $yester_day = NurseSheetMain::GetPrevousDayNurse($baby_id, $admission_id, $yesterday_date);

        $sheet_details = NurseSheetMain::GetNurseSheetCount($baby_id, $admission_id)->sortByDesc('sheet_date');
        $sheet_details = collect($sheet_details)->first();
        $sheet_details = collect($sheet_details)->toArray();

        $baby_details = collect($baby_details)->toArray();

        $baby_details = array_merge($baby_details, $sheet_details);
        $baby_details = (object)$baby_details;

        if (count($today_day) > 0)
        {
            $previous_day = $today_day;
        }
        else
        {
            $previous_day = $yester_day;
        }

        if (isset($previous_day->id))
        {
            $replacement_fluids = NurseHourSheet::Getpreviousdata($previous_day->id, [DialpadSupportProperty::REPLACMENT_FLUIDS_STATUS])
            ->first();

        }
        $iv_fluids_previous_fihr = array();
        $iv_fluids_previous_manual = (array)$this->getPreviousIvfluids($baby_id, $admission_id, $yesterday_date, $current_date);

        $sheet_date = date('d-m-Y');

        $working_time = Settings::getPeriod()->period;
        $start_time = date('Y-m-d H:i:s', strtotime($sheet_date . ' ' . $working_time));
        $start_time = Carbon::createFromFormat('Y-m-d H:i:s', $start_time)->subHour();
        $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $start_time)->addDay()->addHour();

        $iv_fluids_previous_fihr     = $this->getUpdateToDateFluids($baby_id, $admission_id, $start_time, $end_time);
        $replacement_previous_fluids = $this->getPreviousReplacementfluids($baby_id, $admission_id, $previous_day);
        $antibiotic_previous = $this->getPreviousantibiotic($baby_id, $admission_id, $previous_day);
        $other_drugs_previous = $this->getOtherdrugs($baby_id, $admission_id, $previous_day);

        $iv_drug_infusion_pn = $this->getivdrugsinfusion($baby_id, $admission_id, $previous_day);
        $special_iv_fluid_list = $this->getivspecialfluids($baby_id, $admission_id, $previous_day);
        $other_iv_infusion_list = $this->getotherivinfusion($baby_id, $admission_id, $previous_day);
        $other_iv_drug_list = $this->getotherivdrugs($baby_id, $admission_id, $previous_day);
        $oral_rectal_drug_list = $this->getoraldrugs($baby_id, $admission_id, $previous_day);

        $iv_fluids_previous = array_merge($iv_fluids_previous_manual, $iv_fluids_previous_fihr);

        if (count($previous_day) > 0)
        {

            $basic_details = EmrLogDetails::Getpreviousbasic(json_decode(\SiteHelpers::getConfigSettings('BASIC_DETAILS')), $admission_id)->pluck('intf_ref_value', 'local_code')
            ->toArray();
            $output_details = EmrLogDetails::Getpreviousdata($previous_day->id, json_decode(\SiteHelpers::getConfigSettings('OUTPUT_GROUPS')))
            ->pluck('intf_ref_value', 'local_code')
            ->toArray();
            $milk_feeds = EmrLogDetails::Getpreviousdata($previous_day->id, json_decode(\SiteHelpers::getConfigSettings('MILK_FEEDS')))
            ->pluck('intf_ref_value', 'local_code')
            ->toArray();
            $output = EmrLogDetails::Getoutputrunning(json_decode(\SiteHelpers::getConfigSettings('OUTPUT_RUNNING_TOTAL')) , $previous_day->day_id);

        }
        $output_temp = array();

        if (isset($output) && count($output) > 0)
        {
            foreach (DialpadSupportProperty::OUTPUT_RUNNING_TOTAL as $key => $value)
            {
                $output_temp[$value] = $output->where('local_code', $value)->pluck('intf_ref_value')->sum();
            }
        }

        $currrent_time['today'] = Carbon::now($this->time_zone)->format('d-m-Y');
        $currrent_time['hour'] = (int)Carbon::now($this->time_zone)->format('h');
        $currrent_time['mins'] = (int)Carbon::now($this->time_zone)->format('i');
        $currrent_time['session'] = Carbon::now($this->time_zone)->format('A');

        $dial_pade = DialpadSupportProperty::DAILPAD_PROPERTY;

        $ip_details = IpNumber::getCurrent_ip($baby_id, $admission_id);

        $gestation_days = \SiteHelpers::convert_gestation_days($baby_details->Gestation);
        $dayoflife = \SiteHelpers::calculate_day_of_life($baby_details->DOB);
        $corrected_gestation = \SiteHelpers::calculate_corrected_gestation($gestation_days, $dayoflife);
        $corrected_gestation = \SiteHelpers::decode_gestation(json_encode($corrected_gestation));

        $drugs = DrugIvFluidMaster::where(['is_deleted' => '0', 'status' => 1])->where('type', 'ORAL')
        ->where('brand_name', '!=', '')
        ->orderby('id', 'asc')
        ->pluck('brand_name', 'id')
        ->toArray();
        $drugs[''] = '--Select--';
        ksort($drugs);

        $drugs_gen = DrugIvFluidMaster::where(['is_deleted' => '0', 'status' => 1])->where('type', 'ORAL')->orderby('id', 'asc')
        ->where('generic_pharmacological_name', '!=', '')
        ->pluck('generic_pharmacological_name', 'id')
        ->toArray();
        $drugs_gen[''] = '--Select--';
        ksort($drugs_gen);

        $ivfluids = DrugIvFluidMaster::where(['is_deleted' => '0', 'status' => 1])->where('type', '<>', 'ORAL')
        ->select('id')
        ->selectRaw('brand_name|| \' / \' ||generic_pharmacological_name as brand_name')
        ->where('brand_name', '!=', '')
        ->pluck('brand_name', 'id')
        ->toArray();
        $ivfluids[''] = '--Select--';
        ksort($ivfluids);

        $ivfluids_gen = DrugIvFluidMaster::where(['is_deleted' => '0', 'status' => 1])->where('type', '<>', 'ORAL')
        ->where('generic_pharmacological_name', '!=', '')
        ->pluck('generic_pharmacological_name', 'id')
        ->toArray();
        $ivfluids_gen[''] = '--Select--';
        ksort($ivfluids_gen);
        $nurse_master = NurseMaster::select('id')
        ->selectRaw('register_no|| \' - \' ||name as name')
        ->where(['IsDeleted' => '0', 'status' => 'Active'])
        ->whereNotNull('user_id')
        ->pluck('name', 'id')
        ->toArray();

        $nurse_role = env('NURSE_ROLE');
        $role_id = $this->auth->user()->RoleId;
        $nurse_id = null;
        if ($role_id == $nurse_role) {
            $nurse_id = $this->auth->user()->mas_id;
        }

        $indication = MachineDataFormter::getMachineStatus($baby_id, $admission_id, Carbon::now($this->time_zone), Carbon::now($this->time_zone));

        $monitor = DialpadSupportProperty::EMR_MONITER_VALUES;
        $ventilator = DialpadSupportProperty::EMR_VENTILATOR_VALUES;

        return view('nurse_sheet.create', compact('baby_details', 'nurse_master', 'ivfluids_gen', 'other_iv_drug_list', 'oral_rectal_drug_list', 'iv_drug_infusion_pn', 'other_iv_infusion_list', 'special_iv_fluid_list', 'output_temp', 'milk_feeds', 'oral_drugs', 'iv_drugs_previous', 'iv_drug_infusion', 'replacement_fluids', 'output_details', 'sheet_date', 'basic_details', 'admission_id', 'other_drugs_previous', 'drugs_gen', 'replacement_previous_fluids', 'antibiotic_previous', 'iv_fluids_previous', 'previous_antibiotic', 'replacement_previous_fluids', 'ivfluids', 'drugs', 'ip_details', 'time_master', 'corrected_gestation', 'currrent_time', 'baby_id', 'dial_pade', 'admission_id', 'navigate', 'indication', 'monitor', 'ventilator', 'nurse_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {

        $navigate['main_nav'] = 'nicu_nurse_sheet';
        $navigate['sub_nav'] = 'nicu_nurse_sheet';

        $id = \SiteHelpers::decrypt_id($id);

        $nurse_details_sheet = NurseSheetMain::find($id);
        $result = $non_loinc_values = array();

        $sheet_date = date('d-m-Y', strtotime($nurse_details_sheet->sheet_date));

        $working_time = Settings::getPeriod()->period;
        $start_time = date('Y-m-d H:i:s', strtotime($sheet_date . ' ' . $working_time));
        $start_time = Carbon::createFromFormat('Y-m-d H:i:s', $start_time)->subHour();
        $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $start_time)->addDay()
        ->addHour();
        $nurse_header_list = collect(EmrLogHeader::getEmrLogHdr($nurse_details_sheet->baby_id, $nurse_details_sheet->admission_id, $start_time, $end_time))->unique('sender_time');

        /*TO CHECK PATIENT DISCHARGED*/
        $monitor_data_table_name = 'emr_moniter_values';
        $ventilator_data_table_name = 'emr_ventilator_values';
        $lab_data_table_name = 'emr_lab_values';
        $manual_data_table_name = 'emr_nurse_manual_values';
        $prescription_hdr = 'prescription_hdr';
        $prescription_dtl = 'prescription_dtl';
        // $prescription_table = 'prescription';
        $prescription_table = 'prescription_infused_calculation';

        $patient_status = DischargeLog::getDischargeDetail($nurse_details_sheet->baby_id, $nurse_details_sheet->admission_id);
        $baby_admission_id = $nurse_details_sheet->admission_id;

        if (count($patient_status) > 0) {
            $monitor_data_table_name = 'emr_moniter_values_discharged';
            $ventilator_data_table_name = 'emr_ventilator_values_discharged';
            $lab_data_table_name = 'emr_lab_values_discharged';
            $manual_data_table_name = 'emr_nurse_manual_values_discharged';
            $prescription_dtl = 'prescription_dtl_discharged';
            // $prescription_table = 'prescription_discharged';
            $prescription_table = 'prescription_infused_calculation_discharged';
        }

        foreach ($nurse_header_list as $header_id => $header_value)
        {
            $timevalue = date('d:H:i', strtotime($header_value->sender_time));

            $time_sheet = explode(':', $timevalue) [0] . ':' . explode(':', $timevalue) [1] . ':00';

            $moniter_values = EmrLogHeader::get_emr_values($header_value->id, $monitor_data_table_name);
            $ventilator_values = EmrLogHeader::get_emr_values($header_value->id, $ventilator_data_table_name);
            $emr_lab_values = EmrLogHeader::get_emr_values($header_value->id, $lab_data_table_name);
            $emr_values = EmrLogHeader::get_emr_values($header_value->id, 'emr_log_dtl');
            $emr_nurse_manual_values = EmrLogHeader::get_emr_values($header_value->id, $manual_data_table_name);
            $loinc_code_details = $moniter_values->merge($ventilator_values);
            $loinc_code_details = $loinc_code_details->merge($emr_lab_values);
            $loinc_code_details = $loinc_code_details->merge($emr_nurse_manual_values);
            $loinc_code_details = $loinc_code_details->merge($emr_values)->toArray();

            $added_nurse[$time_sheet]['time_sheet'] = $header_value->added_nurse;
            $added_nurse[$time_sheet]['header_id'] = $header_value->id;
            $loinc_code_details = json_decode(json_encode($loinc_code_details) , true);
            $result[$time_sheet] = $loinc_code_details;
            $non_loinc_values[$time_sheet] = NurseHourSheet::where('log_header_id', $header_value->id)->get()->toArray();

        }
        $replacement_fluids = array();

        foreach ($non_loinc_values as $non_loinc_values_key => $replacment_temp)
        {

            $replacment_drugs = collect($replacment_temp)->where('local_code', 'replacement_fluids_solution');
            if (count($replacment_drugs) > 0)
            {
                foreach ($replacment_drugs as $replacment_temp_value)
                {
                    $replacment_rate = collect($replacment_temp)->where('observe_id', $replacment_temp_value['id'])->where('local_code', 'replacement_fluids_rate')
                    ->first();
                    $replacment_total = collect($replacment_temp)->where('observe_id', $replacment_temp_value['id'])->where('local_code', 'replacement_fluids_total')
                    ->first();

                    $replacement_fluids[$non_loinc_values_key][] = ['solution_id' => $replacment_temp_value['id'], 'solution_name' => $replacment_temp_value['value'], 'rate_id' => $replacment_rate['id'], 'rate_name' => $replacment_rate['value'], 'total_id' => $replacment_total['id'], 'total_name' => $replacment_total['value']];

                }
            }

            $phototherapy_temp = collect($replacment_temp)->where('local_code', 'phototherapy')->first();
            if (count($phototherapy_temp) > 0)
            {
                $phototherapy[$non_loinc_values_key][$phototherapy_temp['id']] = $phototherapy_temp['value'];
            }

            $phototherapy_eyes_temp = collect($replacment_temp)->where('local_code', 'phototherapy_eyes')->first();

            if (count($phototherapy_eyes_temp) > 0)
            {
                $phototherapy_eyes[$non_loinc_values_key][$phototherapy_eyes_temp['id']] = $phototherapy_eyes_temp['value'];
            }

        }

        $blood_tranfusion = $transfusion = array();

        $blood_product_header = null;

        foreach ($result as $bloodproductkey => $bloodproductvalue)
        {

            $last_batch_blood = collect($bloodproductvalue)->where('local_code', 'F_Product')->toArray();
            $blood_volumes = collect($bloodproductvalue)->where('local_code', 'F_Volume')->toArray();

            foreach ($last_batch_blood as $key => $value)
            {

                $last_batch_volume = collect($blood_volumes)->where('observation_type_id', $value['id'])->first();

                $blood_tranfusion[] = ['product_id' => $value['id'], 'product_name' => $value['intf_ref_value'], 'product_volid' => $last_batch_volume['id'], 'product_volume' => $last_batch_volume['intf_ref_value']];
                $blood_product_header = $value['log_hdr_id'];
            }

            $transfusion[] = collect($bloodproductvalue)->where('local_code', 'Transfusion')
            ->where('intf_ref_value', 'Yes')
            ->first();

        }

        $transfusion = collect($transfusion)->where('intf_ref_value', 'Yes')
        ->first();

        $blood_tranfusion = collect($blood_tranfusion)->unique('product_name')
        ->toArray();

        $time_with_header = $nurse_header_list->pluck('sender_time', 'id');

        $time_slots_temp = $nurse_header_list->pluck('sender_time');

        $drugs_list = $other_drugs_list = $antibiotic_list = $basic_details = $detail = $fluids_prescription = $prescription_pn_fluid = $prescription_pn_fluids = $intravenous_fluids = $oral_fluids = $other_drugs = $total_intake_ml = $total_intake_kg = $aspirate_ml = $drains_ml = $urine_total = $urine_total_ml_kg = $blood_out_total = $stoma_output = $stools_frequency = $i_o_balance = $i_o_balance_ml_kg = $total_output_ml = $total_output_kg  = array();

        foreach ($result as $result_key => $result_value)
        {
            ksort($result_value);
            $temp_drugs = collect($result_value)->where('local_code', 'drug_solution');

            if (count($temp_drugs) > 0)
            {

                foreach ($temp_drugs as $temp_key => $temp_value)
                {

                    $drugs_list[$result_key][$temp_value['id']]['drug_id'] = $temp_value['id'];
                    $drugs_list[$result_key][$temp_value['id']]['drug_name'] = $temp_value['intf_ref_value'];

                    $temp_rate = collect($result_value)->where('observation_type_id', $temp_value['id'])->where('local_code', 'drug_rate')
                    ->last();

                    $drugs_list[$result_key][$temp_value['id']]['drug_rate_id'] = $temp_rate['id'];
                    $drugs_list[$result_key][$temp_value['id']]['drug_rate'] = $temp_rate['intf_ref_value'];

                    $temp_total = collect($result_value)->where('observation_type_id', $temp_value['id'])->where('local_code', 'drug_total')
                    ->last();

                    $drugs_list[$result_key][$temp_value['id']]['drug_total_id'] = $temp_total['id'];
                    $drugs_list[$result_key][$temp_value['id']]['drug_total'] = $temp_total['intf_ref_value'];
                    $drugs_list[$result_key][$temp_value['id']]['log_hdr_id'] = $temp_total['log_hdr_id'];

                }

            }

            $other_temp_drug = collect($result_value)->where('local_code', 'drugs');
            $other_header_id = null;

            if (count($other_temp_drug) > 0)
            {

                foreach ($other_temp_drug as $otherdrug_key => $otherdrug_value)
                {

                    $other_drugs_list[] = ['drug_id' => $otherdrug_value['id'], 'drug_name' => $otherdrug_value['intf_ref_value']];

                    $other_header_id = $otherdrug_value['log_hdr_id'];

                }
            }

            $temp_antibiotic = collect($result_value)->where('local_code', DialpadSupportProperty::A_ANTIBIOTIC);
            $temp_antibiotic_header = null;

            if (count($temp_antibiotic) > 0)
            {

                foreach ($temp_antibiotic as $antibiotic_key => $antibiotic_value)
                {
                    $temp_day = collect($result_value)->where('observation_type_id', $antibiotic_value['id'])->where('local_code', 'A_Day')
                    ->last();

                    $antibiotic_list[] = ['antibiotic_id' => $antibiotic_value['id'], 'antibiotic_name' => $antibiotic_value['intf_ref_value'], 'antibiotic_day_id' => $temp_day['id'], 'antibiotic_day_name' => $temp_day['intf_ref_value']];

                    $temp_antibiotic_header = $antibiotic_value['log_hdr_id'];
                }
            }

            $intravenous_fluids[] = collect($result_value)->where('local_code', DialpadSupportProperty::INTRAVENOUS_FLUIDS)
            ->first();
            $oral_fluids[] = collect($result_value)->where('local_code', DialpadSupportProperty::ORAL_FLUIDS)
            ->first();
            $other_drugs[] = collect($result_value)->where('local_code', DialpadSupportProperty::ORAL_DRUGS)
            ->first();
            $total_intake_ml[] = collect($result_value)->where('local_code', DialpadSupportProperty::TOTAL_INTAKE_ML)
            ->first();
            $total_intake_kg[] = collect($result_value)->where('local_code', DialpadSupportProperty::TOTAL_INTAKE_KG)
            ->first();
            $total_output_ml[] = collect($result_value)->where('local_code', DialpadSupportProperty::TOTAL_OUTPUT_ML)
            ->first();
            $total_output_kg[] = collect($result_value)->where('local_code', DialpadSupportProperty::TOTAL_OUTPUT_KG)
            ->first();

            $aspirate_ml[] = collect($result_value)->where('local_code', DialpadSupportProperty::ASPIRATE_ML)
            ->first();
            $drains_ml[] = collect($result_value)->where('local_code', DialpadSupportProperty::DRAINS_ML)
            ->first();
            $urine_total[] = collect($result_value)->where('local_code', DialpadSupportProperty::URINE_TOTAL)
            ->first();
            $urine_total_ml_kg[] = collect($result_value)->where('local_code', DialpadSupportProperty::URINE_TOTAL_ML_KG)
            ->first();
            $blood_out_total[] = collect($result_value)->where('local_code', DialpadSupportProperty::BLOOD_OUT_TOTAL)
            ->first();

            $stoma_output[] = collect($result_value)->where('local_code', DialpadSupportProperty::STOMA_OUTPUT)
            ->first();
            $stools_frequency[] = collect($result_value)->where('local_code', DialpadSupportProperty::STOOLS_FREQUENCY)
            ->first();
            $i_o_balance[] = collect($result_value)->where('local_code', DialpadSupportProperty::I_O_BALANCE)
            ->first();
            $i_o_balance_ml_kg[] = collect($result_value)->where('local_code', DialpadSupportProperty::I_O_BALANCE_ML_KG)
            ->first();
            $total_output_ml[] = collect($result_value)->where('local_code', DialpadSupportProperty::TOTAL_OUTPUT)
            ->first();
            $total_output_kg[] = collect($result_value)->where('local_code', DialpadSupportProperty::TOTAL_OUTPUT_ML_DAY)
            ->first();

            foreach (DialpadSupportProperty::BASIC_DETAILS as $key => $value)
            {
                $basic_detail = collect($result_value)->whereIn('local_code', DialpadSupportProperty::BASIC_DETAILS[$key])->first();

                if (count($basic_detail) > 0)
                {
                    $detail[$key] = $basic_detail;
                }
            }
            $basic_details = collect($detail);
        }
        $temp_start_time = Carbon::createFromFormat('Y-m-d H:i:s', $start_time)->addHour();
        $data_filter = new Request([
            'baby_id'   => $nurse_details_sheet->baby_id,
            'admission_id' => $nurse_details_sheet->admission_id,
            'start_time' => $temp_start_time,
            'end_time' => $end_time,
        ]);
        $temp_prescription_list = $this->getPumpData($data_filter, $prescription_dtl, $prescription_table);
        if (isset($temp_prescription_list['drugs_list'])) {

            $prescription_list = collect($temp_prescription_list['drugs_list'])->flatten(1);
            $prescription_intake = $prescription_list->groupBy(['temp_result_date_time'])
            ->map(function ($item) {
                $keys = $item->pluck('drug_name')->toArray();
                $values = collect($item)->toArray();
                $list = array_combine($keys, $values);
                return $list;
            })->toArray();
        }
        $drugs_list = array_merge_recursive($drugs_list, $prescription_intake);
        ksort($drugs_list);

        $other_drugs_list = collect($other_drugs_list)->unique('drug_name')
        ->toArray();
        $antibiotic_list = collect($antibiotic_list)->unique('antibiotic_name')
        ->toArray();

        $inout_totals[DialpadSupportProperty::INTRAVENOUS_FLUIDS] = collect($intravenous_fluids)->max();
        $inout_totals[DialpadSupportProperty::ORAL_FLUIDS] = collect($oral_fluids)->max();
        $inout_totals[DialpadSupportProperty::ORAL_DRUGS] = collect($other_drugs)->max();
        $inout_totals[DialpadSupportProperty::TOTAL_INTAKE_ML] = collect($total_intake_ml)->max();
        $inout_totals[DialpadSupportProperty::TOTAL_INTAKE_KG] = collect($total_intake_kg)->max();
        $inout_totals[DialpadSupportProperty::ASPIRATE_ML] = collect($aspirate_ml)->max();
        $inout_totals[DialpadSupportProperty::DRAINS_ML] = collect($drains_ml)->max();
        $inout_totals[DialpadSupportProperty::URINE_TOTAL] = collect($urine_total)->max();
        $inout_totals[DialpadSupportProperty::URINE_TOTAL_ML_KG] = collect($urine_total_ml_kg)->max();
        $inout_totals[DialpadSupportProperty::BLOOD_OUT_TOTAL] = collect($blood_out_total)->max();
        $inout_totals[DialpadSupportProperty::STOMA_OUTPUT] = collect($stoma_output)->max();
        $inout_totals[DialpadSupportProperty::STOOLS_FREQUENCY] = collect($stools_frequency)->max();
        $inout_totals[DialpadSupportProperty::I_O_BALANCE] = collect($i_o_balance)->max();
        $inout_totals[DialpadSupportProperty::I_O_BALANCE_ML_KG] = collect($i_o_balance_ml_kg)->max();
        $inout_totals[DialpadSupportProperty::TOTAL_OUTPUT_ML] = collect($total_output_ml)->max();
        $inout_totals[DialpadSupportProperty::TOTAL_OUTPUT_KG] = collect($total_output_kg)->max();

        $time_slots = array();

        foreach ($time_slots_temp as $key => $value)
        {
            $time_slots[] = date('d:H:i', strtotime($value));
        }

        $temp_time_slot = isset($time_slots) ? $time_slots : [];
        unset($time_slots);

        $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $start_time)->addDay();

        $working_hour = explode(':', $working_time) [0];
        $current_time = date('Y-m-d H:i:s');
        $current_time = Carbon::parse($current_time);

        $hour_diff = $current_time->diffInHours($start_time);

        if ($hour_diff > 24) {
            $hour_diff = 24;
        }
        $time = [];
        for ($i = 1; $i <= $hour_diff; $i++) {
            $time[] = Carbon::createFromFormat('Y-m-d H:i:s', $start_time)->addHours($i)->format('d:H');
        }

        $time_slots = [];

        foreach ($time as $key => $value)
        {
            unset($flag);
            foreach ($temp_time_slot as $key => $temp_slot)
            {
                $values = explode(':', $value) [0] . ':' . explode(':', $value) [1];
                $slots = explode(':', $temp_slot) [0] . ':' . explode(':', $temp_slot) [1];
                if ($values == $slots)
                {
                    $time_slots[] = explode(':', $value) [0] . ':' . explode(':', $temp_slot) [1] . ':00';
                    $flag = 1;
                }
            }
            if (!isset($flag)) $time_slots[] = $value . ':00';
        }

        if (count($time_slots) > 0) {
            $temp_time_slots = collect($time_slots)->unique()
            ->toArray();
            unset($time_slots);

            $k = 0;
            foreach ($temp_time_slots as $key => $value)
            {
                $time_slots[$k] = $value;
                $k++;
            }
            ksort($time_slots);
        }

        $time_header = array();
        foreach ($time_with_header as $key => $value)
        {
            $time_header[$key] = date('d:H:i', strtotime($value));
        }
        $temp_time_header = isset($time_header) ? $time_header : [];
        unset($time_header);

        $time_header = array();
        foreach ($time as $key => $value)
        {
            unset($flag);
            foreach ($temp_time_header as $key1 => $temp_slot)
            {
                $values = explode(':', $value) [0] . ':' . explode(':', $value) [1];
                $slots = explode(':', $temp_slot) [0] . ':' . explode(':', $temp_slot) [1];
                if ($values == $slots)
                {
                    $time_header[$key1] = explode(':', $value) [0] . ':' . explode(':', $temp_slot) [1] . ':00';
                    $flag = 1;
                }
            }
            if (!isset($flag)) $time_header[] = $value . ':00';
        }

        if (count($time_header) > 0) {
            $last_header = array_keys($time_header);
            rsort($last_header);
            $last_header = $last_header[0];
        }

        $result = collect($result);

        $baby_details = Baby::find($nurse_details_sheet->baby_id);

        $sheet_date = !is_null($nurse_details_sheet->sheet_date) ? date('d-m-Y', strtotime($nurse_details_sheet->sheet_date)) : '';
        $time_master = \SiteHelpers::prepare_time();

        $currrent_time['today'] = Carbon::now($this->time_zone)->format('d-m-Y');
        $currrent_time['hour'] = (int)Carbon::now($this->time_zone)->format('h');
        $currrent_time['mins'] = (int)Carbon::now($this->time_zone)->format('i');
        $currrent_time['session'] = Carbon::now($this->time_zone)->format('A');
        $time_interval = $this->time_interval;

        $ip_details = IpNumber::getCurrent_ip($nurse_details_sheet->baby_id, $nurse_details_sheet->admission_id);
        $gestation_days = \SiteHelpers::convert_gestation_days($baby_details->Gestation);
        $dayoflife = \SiteHelpers::calculate_day_of_life($baby_details->DOB);
        $corrected_gestation = \SiteHelpers::calculate_corrected_gestation($gestation_days, $dayoflife);
        $corrected_gestation = \SiteHelpers::decode_gestation(json_encode($corrected_gestation));
        $master_drugs = DrugIvFluidMaster::where(['is_deleted' => '0', 'status' => 1])->where('type', 'ORAL')->pluck('brand_name', 'id')
        ->toArray();
        $master_drugs[''] = '--Select--';
        ksort($master_drugs);

        $ivfluids = DrugIvFluidMaster::where(['is_deleted' => '0', 'status' => 1])
        ->select('id')
        ->selectRaw('brand_name|| \' / \' ||generic_pharmacological_name as brand_name')
        ->where('type', '<>', 'ORAL')->where('brand_name', '!=', '')
        ->pluck('brand_name', 'id')
        ->toArray();
        $ivfluids[''] = '--Select--';
        ksort($ivfluids);

        $drugs_gen = DrugIvFluidMaster::where(['is_deleted' => '0', 'status' => 1])->where('type', 'ORAL')->orderby('id', 'asc')
        ->where('generic_pharmacological_name', '!=', '')
        ->pluck('generic_pharmacological_name', 'id')
        ->toArray();
        $drugs_gen[''] = '--Select--';
        ksort($drugs_gen);

        $drugs = DrugIvFluidMaster::where(['is_deleted' => '0', 'status' => 1])->where('type', 'ORAL')->orderby('id', 'asc')
        ->where('generic_pharmacological_name', '!=', '')
        ->pluck('generic_pharmacological_name', 'id')
        ->toArray();
        $drugs[''] = '--Select--';
        ksort($drugs);

        $ivfluids_gen = DrugIvFluidMaster::where(['is_deleted' => '0', 'status' => 1])->where('type', '<>', 'ORAL')->where('generic_pharmacological_name', '!=', '')
        ->pluck('generic_pharmacological_name', 'id')
        ->toArray();
        $ivfluids_gen[''] = '--Select--';
        ksort($ivfluids_gen);
        $nurse_master = NurseMaster::select('id')
        ->selectRaw('register_no|| \' - \' ||name as name')
        ->where(['IsDeleted' => '0', 'status' => 'Active'])
        ->whereNotNull('user_id')
        ->pluck('name', 'id')
        ->toArray();

        $date = date('d/m/Y', strtotime($sheet_date)) . ' - ' . date('d/m/Y', strtotime($end_time));

        $baby_details = collect($baby_details)->toArray();
        $nurse_details_sheet = collect($nurse_details_sheet)->toArray();

        $baby_details = array_merge($baby_details, $nurse_details_sheet);
        $baby_details = (object)$baby_details;

        $navigation_ids = $this->getPrevNextIds($baby_details->admission_id, $id);

        $prev_id = isset($navigation_ids['prev_id']) ? $navigation_ids['prev_id'] : null;
        $next_id = isset($navigation_ids['next_id']) ? $navigation_ids['next_id'] : null;
        
        return view('nurse_sheet.edit', compact('baby_details', 'basic_details', 'nurse_master', 'added_nurse', 'ivfluids_gen', 'last_header', 'rectal_list', 'other_iv_list', 'otheriv_infustion_list', 'blood_product_header', 'other_header_id', 'temp_antibiotic_header', 'time_header', 'drugs', 'drugs_gen', 'ivfluids', 'phototherapy', 'phototherapy_eyes', 'replacement_fluids', 'antibiotic_list', 'inout_totals', 'master_drugs', 'sheet_date', 'oraldrugs_list', 'special_iv_list', 'infusion_drugs_list', 'transfusion', 'time_master', 'other_drugs_list', 'blood_tranfusion', 'drugs_list', 'corrected_gestation', 'ip_details', 'result', 'nurse_details_sheet', 'time_interval', 'time_slots', 'id', 'navigate', 'baby_admission_id', 'prescription_fluid', 'drugivfluid', 'date', 'prev_id', 'next_id'));
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

        $admission_id = $input['admission_id'];
        unset($input['_method']);
        unset($input['_token']);
        unset($input['temp_time_hour']);
        unset($input['temp_time_min']);
        unset($input['temp_time_session']);

        $non_loinc = NurseHourSheet::gethourwisesheet($id);

        $loinc_reference = EmrLogHeader::get_details_all();

        $baby_details = Baby::find($input['BabyId']);

        $sheet_update['dcp'] = $input['dcp'];
        $sheet_update['hemolysis'] = $input['hemolysis'];
        $sheet_update['current_weight'] = isset($input['current_weight']) ? $input['current_weight'] : null;
        $sheet_update['working_weight'] = isset($input['working_weight']) ? $input['working_weight'] : null;
        if (isset($input['ett_status'])) {
            $sheet_update['ett_status'] = $input['ett_status'];
            $sheet_update['et_size'] = isset($input['et_size']) ? $input['et_size'] : null;
            $sheet_update['et_length'] = isset($input['et_length']) ? $input['et_length'] : null;
        }
        if (isset($input['ngt_status'])) {
            $sheet_update['ngt_status'] = $input['ngt_status'];
            $sheet_update['ngt_size'] = isset($input['ngt_size']) ? $input['ngt_size'] : null;
            $sheet_update['ngt_length'] = isset($input['ngt_length']) ? $input['ngt_length'] : null;
        }
        
        $working_time = Settings::getPeriod()->period;

        $total_input_calculation = false;
        if (isset($input['working_weight']) && (isset($input['milk_volume']) || isset($input['pump_drug_total']) || isset($input['drug_total']))) {
            $total_input_calculation = true;
            $input['time_hour'] = $input['sheet_date'] . ' ' . $working_time;
            $input['time_hour'] = date('Y-m-d H:i:s', strtotime($input['time_hour'] . '+1 hour'));
        }

        $total_output_calculation = false;
        if (isset($input['working_weight']) && (isset($input['gastric_aspirate_volume']) || isset($input['urine_output']) || isset($input['blood_volume_out']) || isset($input['drain_output_r']) || isset($input['drain_output_l']))) {
            $total_output_calculation = true;
            $input['time_hour'] = $input['sheet_date'] . ' ' . $working_time;
            $input['time_hour'] = date('Y-m-d H:i:s', strtotime($input['time_hour'] . '+1 hour'));
        }

        $post['admission_id'] = $admission_id;
        $post['working_weight'] = $input['working_weight'];

        broadcast(new PrescriptionEvent($post))->toOthers();

        NurseSheetMain::where('id', $id)->update($sheet_update);

        $added_nurse = null;

        if (isset($input[DialpadSupportProperty::PHOTOTHERAPY]))
        {
            $phototherapy = $input[DialpadSupportProperty::PHOTOTHERAPY];

            $nurse_phototherapy = $non_loinc->where('local_code', DialpadSupportProperty::PHOTOTHERAPY)->toArray();

            if ($request->ajax() && count($phototherapy) != 0)
            {
                foreach ($phototherapy as $pho_key => $pho_value)
                {
                    if (is_numeric($pho_key))
                    {
                        $phototherapy_exist = collect($nurse_phototherapy)->where('id', $pho_key)->first();
                        if (isset($phototherapy_exist->id))
                        {
                            $local_value['value'] = (isset($pho_value) && $pho_value == 'on') ? 'on' : null;
                            NurseHourSheet::where('id', $pho_key)->Update($local_value);
                            return \Response::json(['type' => 'success', 'message' => 'Time sheet added successfully !'], 200);
                        }
                    }
                    elseif (count(explode(':', $pho_key)) == 3)
                    {
                        $manaual_log_head_id = $this->checkDayHeader($pho_key, $input, $baby_details);

                        $check_photo_exist = NurseHourSheet::where('local_code', 'phototherapy')->where('log_header_id', $manaual_log_head_id)->first();
                        if (count($check_photo_exist) > 0)
                        {
                            if ($check_photo_exist->value != $pho_value)
                            {
                                NurseHourSheet::where('local_code', 'phototherapy')->where('log_header_id', $manaual_log_head_id)->update(['value' => $pho_value]);
                            }
                        }
                        else
                        {
                            $pho_insert = array(
                                'log_header_id' => $manaual_log_head_id,
                                'value' => $pho_value,
                                'local_code' => 'phototherapy'
                            );
                            NurseHourSheet::insert($pho_insert);
                        }
                        return \Response::json(['type' => 'success', 'message' => 'Time sheet added successfully !'], 200);
                    }
                }
            }
            if (count($nurse_phototherapy) > 0)
            {
                foreach ($nurse_phototherapy as $phototherapy_id => $value)
                {
                    if (isset($phototherapy[$value->id]) && $request->ajax())
                    {
                        $local_value['value'] = (isset($phototherapy_eyes[$value->id]) && $phototherapy_eyes[$value->id] == 'on') ? $phototherapy_eyes[$value->id] : null;
                        NurseHourSheet::where('id', $value->id)->Update($local_value);
                        return \Response::json(['type' => 'success', 'message' => 'Time sheet added successfully !'], 200);
                    }
                    else
                    {
                        $local_value['value'] = (isset($phototherapy[$value->id]) && $phototherapy[$value->id] == 'on') ? $phototherapy[$value->id] : null;
                        NurseHourSheet::where('id', $value->id)->Update($local_value);
                        $local_value = null;
                        unset($phototherapy[$value->id]);
                    }
                }
            }
            else
            {

                foreach ($phototherapy as $phototherapy_id => $value)
                {

                    if (count(explode(':', $phototherapy_id)) == 1)
                    {
                        $local_value['value'] = (isset($phototherapy[$phototherapy_id]) && $phototherapy[$phototherapy_id] == 'on') ? $phototherapy[$phototherapy_id] : null;
                        NurseHourSheet::where('id', $phototherapy_id)->Update($local_value);
                        $local_value = null;
                        unset($phototherapy[$phototherapy_id]);
                    }
                }
            }
            $phototherapy = $nurse_phototherapy = null;
        }
        
        if (isset($input[DialpadSupportProperty::PHOTOTHERAPY_EYES]))
        {

            $phototherapy_eyes = $input[DialpadSupportProperty::PHOTOTHERAPY_EYES];
            $nurse_phototherapy_eyes = $non_loinc->where('local_code', DialpadSupportProperty::PHOTOTHERAPY_EYES)->toArray();

            if ($request->ajax() && count($phototherapy_eyes) != 0)
            {
                foreach ($phototherapy_eyes as $pho_key => $pho_value)
                {
                    if (is_numeric($pho_key))
                    {
                        $phototherapy_exist = collect($nurse_phototherapy_eyes)->where('id', $pho_key)->first();
                        if (isset($phototherapy_exist->id))
                        {
                            $local_value['value'] = (isset($pho_value)) ? $pho_value : null;
                            NurseHourSheet::where('id', $pho_key)->Update($local_value);
                            return \Response::json(['type' => 'success', 'message' => 'Time sheet added successfully !'], 200);
                        }
                    }
                    elseif (count(explode(':', $pho_key)) == 3)
                    {
                        $manaual_log_head_id = $this->checkDayHeader($pho_key, $input, $baby_details);

                        $check_photo_exist = NurseHourSheet::where('local_code', 'phototherapy_eyes')->where('log_header_id', $manaual_log_head_id)->first();
                        if (count($check_photo_exist) > 0)
                        {
                            if ($check_photo_exist->value != $pho_value)
                            {
                                NurseHourSheet::where('local_code', 'phototherapy_eyes')->where('log_header_id', $manaual_log_head_id)->update(['value' => $pho_value]);
                            }
                        }
                        else
                        {
                            $pho_insert = array(
                                'log_header_id' => $manaual_log_head_id,
                                'value' => $pho_value,
                                'local_code' => 'phototherapy_eyes'
                            );
                            NurseHourSheet::insert($pho_insert);
                        }
                        return \Response::json(['type' => 'success', 'message' => 'Time sheet added successfully !'], 200);
                    }
                }
            }

            if (count($nurse_phototherapy_eyes) > 0)
            {
                foreach ($nurse_phototherapy_eyes as $phototherapy_id => $value)
                {
                    if (isset($phototherapy_eyes[$value->id]) && $request->ajax())
                    {

                        $local_value['value'] = (isset($phototherapy_eyes[$value->id]) && $phototherapy_eyes[$value->id] == 'on') ? $phototherapy_eyes[$value->id] : null;
                        NurseHourSheet::where('id', $value->id)
                        ->Update($local_value);
                        return \Response::json(['type' => 'success', 'message' => 'Time sheet added successfully !'], 200);
                    }
                    else
                    {
                        $local_value['value'] = (isset($phototherapy_eyes[$value->id]) && $phototherapy_eyes[$value->id] == 'on') ? $phototherapy_eyes[$value->id] : null;
                        NurseHourSheet::where('id', $value->id)
                        ->Update($local_value);
                        $local_value = null;
                        unset($phototherapy_eyes[$value->id]);
                    }

                }
            }
            else
            {
                foreach ($phototherapy_eyes as $phototherapy_id => $value)
                {
                    if (count(explode(':', $phototherapy_id)) == 1)
                    {
                        $local_value['value'] = (isset($phototherapy_eyes[$phototherapy_id]) && $phototherapy_eyes[$phototherapy_id] == 'on') ? $phototherapy_eyes[$phototherapy_id] : null;
                        NurseHourSheet::where('id', $phototherapy_id)->Update($local_value);
                        $local_value = null;
                        unset($phototherapy_eyes[$phototherapy_id]);
                    }
                }
            }

        }

        foreach (DialpadSupportProperty::REPLACMENT_FLUIDS as $replacement_key => $replacement_value)
        {

            if (isset($input[$replacement_value]))
            {
                $temp_replace = $input[$replacement_value];
                $fluids_value = $non_loinc->where('local_code', $replacement_value)->toArray();

                foreach ($fluids_value as $temp_key => $temp_value)
                {

                    if (array_key_exists($temp_value->id, $temp_replace))
                    {
                        $local_value['value'] = $temp_replace[$temp_value->id];   
                        NurseHourSheet::where('id', $temp_value->id)->Update($local_value);
                        unset($temp_replace[$temp_value->id]);
                    }
                    elseif (!array_key_exists($temp_value->id, $temp_replace) && !is_string($temp_value->id))
                    {
                        NurseHourSheet::where('id', $temp_value->id)->delete();
                    }
                    
                }
                unset($input[$replacement_value]);
            }

            if (isset($temp_replace) && count($temp_replace) > 0 && $replacement_value == DialpadSupportProperty::REPLACMENT_FLUIDS_SOLUTION)
            {

                foreach ($temp_replace as $temp_key => $temp_value)
                {
                    $value_ids = explode('_', $temp_key);

                    if (count($value_ids) == 3)
                    {
                        $added_nurse = isset($input['added_nurse'][$value_ids[2]]) ? $input['added_nurse'][$value_ids[2]] : null;

                        $emr_log_head_id = $this->checkDayHeader($value_ids, $input, $baby_details, $added_nurse);

                        if (is_string($temp_key) && isset($value_ids[1]) && isset($value_ids[2]))
                        {

                            $refluids = $temp_key;
                            $rerate = 'rerate_' . $value_ids[1] . '_' . $value_ids[2];
                            $retotal = 'retotal_' . $value_ids[1] . '_' . $value_ids[2];

                            $observation_type_id = 0;
                            $observation_type_id = $this->addmultiple_replacement($emr_log_head_id, $temp_value, DialpadSupportProperty::REPLACMENT_FLUIDS_SOLUTION, $observation_type_id);
                            $this->addmultiple_replacement($emr_log_head_id, $input[DialpadSupportProperty::REPLACMENT_FLUIDS_RATE][$rerate], DialpadSupportProperty::REPLACMENT_FLUIDS_RATE, $observation_type_id);
                            $this->addmultiple_replacement($emr_log_head_id, $input[DialpadSupportProperty::REPLACMENT_FLUIDS_TOTAL][$retotal], DialpadSupportProperty::REPLACMENT_FLUIDS_TOTAL, $observation_type_id);

                        }

                    }

                }

            }
        }

        //pn drugs and iv fluids
        $log_ids = array();

        foreach (DialpadSupportProperty::DRUG_FLUIDS as $drug_fluids_property_name)
        {
            if (isset($input[$drug_fluids_property_name]))
            {
                $log_ids = array_merge($log_ids, array_keys($input[$drug_fluids_property_name]));
            }
        }

        // IV Fluids, Parenteral Nutrition And Drug Infusion

        if (isset($input['drug_solution']) && isset($input['drug_rate']) && isset($input['drug_total']))
        {

            $drug_solution = $loinc_reference->where('local_code', 'drug_solution')->first();
            $drug_rate = $loinc_reference->where('local_code', 'drug_rate')->first();
            $drug_total = $loinc_reference->where('local_code', 'drug_total')->first();

            foreach ($input['drug_solution'] as $fluids => $value) {
                $today_start = Carbon::now($this->time_zone)->format('Y-m-d 00:00:00');
                $today_current = Carbon::now($this->time_zone)->format('Y-m-d H:i:s');

                $solution_keys = array_keys($input['drug_solution']);
                $rate_keys = array_keys($input['drug_rate']);
                $total_keys = array_keys($input['drug_total']);

                if (!is_numeric($fluids)) {

                    $solution_key = $fluids;
                    $fluids_temp = explode('_', $solution_key);

                    $emr_log_head_id = $this->checkDayHeader($fluids_temp[2], $input, $baby_details, $added_nurse);

                    $observation_type_id = 0;
                    $observation_type_id = $this->addmultiplelist($emr_log_head_id, $input['drug_solution'][$solution_key], $drug_solution, $observation_type_id);
                    $stored_result['drug_solution'][$solution_key] = $input['drug_solution'][$solution_key];

                    $rate_key = str_replace('flu', 'rate', $solution_key);
                    $rate_value = $input['drug_rate'][$rate_key];
                    $this->addmultiplelist($emr_log_head_id, $rate_value, $drug_rate, $observation_type_id);

                    $total_key = str_replace('flu', 'total', $solution_key);
                    $total_value = $input['drug_total'][$total_key];
                    $this->addmultiplelist($emr_log_head_id, $total_value, $drug_total, $observation_type_id);

                    unset($input['drug_solution'][$solution_key]);
                    unset($input['drug_rate'][$rate_key]);
                    unset($input['drug_total'][$total_key]);

                }

            }

            foreach ($input['drug_solution'] as $drug_id => $drug_value) {
                EmrLogDetails::where('id', $drug_id)->Update(['intf_ref_value' => $drug_value, 'modify_tstamp' => Carbon::now($this->time_zone), 'modify_user_id' => $this->auth->user()->id]);
            }

            foreach ($input['drug_rate'] as $rate_id => $rate_ivalue) {
                EmrLogDetails::where('id', $rate_id)->Update(['intf_ref_value' => $rate_ivalue, 'modify_tstamp' => Carbon::now($this->time_zone), 'modify_user_id' => $this->auth->user()->id]);
            }

            foreach ($input['drug_total'] as $total_id => $total_value) {
                EmrLogDetails::where('id', $total_id)->Update(['intf_ref_value' => $total_value, 'modify_tstamp' => Carbon::now($this->time_zone), 'modify_user_id' => $this->auth->user()->id]);
            }

            unset($input['drug_solution']);
            unset($input['drug_rate']);
            unset($input['drug_total']);
        }
        // toggle value started
        $inputToggle = array();
        $emr_toggles = EmrLogDetails::GetToggleValues($id, DialpadSupportProperty::TOGGLE_VALUSE);

        foreach ($emr_toggles as $ktoggles => $vtoggles)
        {
            $slug = $vtoggles->log_hdr . '-' . $vtoggles->log_dtl_id;

            if (!array_key_exists($slug, $inputToggle) && !isset($input[$vtoggles->local_code][$slug]))
            {

                $emr_log_details = EmrLogDetails::find($vtoggles->log_dtl_id);

                if (count($emr_log_details) > 0)
                {

                    $temp_emr[DialpadSupportProperty::INTF_REF_VALUE] = 'off';
                    $temp_emr['modify_tstamp'] = Carbon::now($this->time_zone);
                    $temp_emr['modify_user_id'] = $this->auth->user()->id;
                    $emr_log_details->Update($temp_emr);
                    unset($temp_emr);
                }
            }

        }

        //toggle value ended
        if (isset($input[DialpadSupportProperty::OTHER_DRUGS]))
        {
            $other_drugs[DialpadSupportProperty::OTHER_DRUGS] = $input[DialpadSupportProperty::OTHER_DRUGS];
            unset($input[DialpadSupportProperty::OTHER_DRUGS]);

            $other_drugs_local = EmrLogHeader::get_details(DialpadSupportProperty::OTHER_DRUGS);
            $other_drugs_id = array_filter(array_keys($other_drugs[DialpadSupportProperty::OTHER_DRUGS]) , 'is_int');

            $other_drugs_local = EmrLogHeader::get_remove_drugs($id, $other_drugs_local->ref_loc_master_id, $other_drugs_id);

            foreach ($other_drugs as $other_drugs_id => $other_drugs_value)
            {

                foreach ($other_drugs_value as $other_drugs_value_id => $other_drugs_value_value)
                {

                    $emr_log_details = array();

                    if (!is_string($other_drugs_value_id))
                    {
                        $emr_log_details = EmrLogDetails::find($other_drugs_value_id);
                    }
                    if (count($emr_log_details) > 0)
                    {
                        $emr_log_details->Update([DialpadSupportProperty::INTF_REF_VALUE => $other_drugs_value_value, 'modify_tstamp' => Carbon::now($this->time_zone), 'modify_user_id' => $this->auth->user()->id]);
                        unset($other_drugs[$other_drugs_id][$other_drugs_value_id]);
                    }
                    else
                    {

                        $start_sender_time = date('Y-m-d H:i:s', strtotime($input['sheet_date']));

                        $date = Carbon::createFromFormat('d-m-Y', $input['sheet_date'])->addDay();

                        $end_sender_time = date('Y-m-d', strtotime($date));

                        $check_log = EmrLogDetails::checkLogIsExist($start_sender_time, $end_sender_time, $input["BabyId"], $admission_id, $baby_details["MotherId"]);

                        $observation_type_id = 0;

                        $local_drug = (array)$loinc_reference->where('local_code', DialpadSupportProperty::OTHER_DRUGS)->first();

                        $this->addmultiplelist($check_log->id, $other_drugs[DialpadSupportProperty::OTHER_DRUGS][$other_drugs_value_id], $local_drug, $observation_type_id);

                        unset($other_drugs[$other_drugs_id][$other_drugs_value_id]);
                    }
                }
            }
        }

        if (isset($input[DialpadSupportProperty::A_ANTIBIOTIC]))
        {

            foreach (DialpadSupportProperty::A_ANTIBIOTIC_GROUP as $antibio_property_name)
            {

                $antibio[$antibio_property_name] = $input[$antibio_property_name];
                unset($input[$antibio_property_name]);

                $antibio_local = EmrLogHeader::get_details($antibio_property_name);
                $antibio_filterd_ids = array_filter(array_keys($antibio[$antibio_property_name]) , 'is_int');
                $antibio_local = EmrLogHeader::get_remove_drugs($id, $antibio_local->ref_loc_master_id, $antibio_filterd_ids);

                foreach ($antibio as $antibio_key => $antibio_values)
                {
                    foreach ($antibio_values as $antibio_id => $antibio_value)
                    {
                        $emr_log_details = array();

                        if (!is_string($antibio_id))
                        {
                            $emr_log_details = EmrLogDetails::find($antibio_id);
                        }

                        if (count($emr_log_details) > 0)
                        {
                            $emr_log_details->Update([DialpadSupportProperty::INTF_REF_VALUE => $antibio_value, 'modify_tstamp' => Carbon::now($this->time_zone), 'modify_user_id' => $this->auth->user()->id]);
                            unset($antibio[$antibio_key][$antibio_id]);
                        }
                        else
                        {

                            if (DialpadSupportProperty::A_ANTIBIOTIC == $antibio_property_name && is_string($antibio_id))
                            {

                                $temp_ids = explode('_', $antibio_id);

                                if (isset($temp_ids[1]) && isset($temp_ids[2]))
                                {
                                    $anibio_name = $antibio_id;
                                    $anibio_day = 'antiday_' . $temp_ids[1] . '_' . $temp_ids[2];
                                    $observation_type_id = 0;

                                    $local_antibio = (array)$loinc_reference->where('local_code', DialpadSupportProperty::A_ANTIBIOTIC)
                                    ->first();
                                    $local_day = (array)$loinc_reference->where('local_code', DialpadSupportProperty::A_DAY)
                                    ->first();

                                    $observation_type_id = $this->addmultiplelist($temp_ids[2], $antibio[DialpadSupportProperty::A_ANTIBIOTIC][$anibio_name], $local_antibio, $observation_type_id);
                                    $this->addmultiplelist($temp_ids[2], $input[DialpadSupportProperty::A_DAY][$anibio_day], $local_day, $observation_type_id);

                                }

                            }

                        }
                    }
                }
            }

        }

        $blood_products_details = array();
        $iv_property_name = null;

        foreach (DialpadSupportProperty::BLOOD_PRODUCT_GROUP as $iv_property_name)
        {
            if (isset($input[$iv_property_name]))
            {
                $blood_products_details = array_merge($blood_products_details, array_keys($input[$iv_property_name]));
            }
        }

        $blood_products_details = array_filter($blood_products_details, 'is_int');
        $emr_details = EmrLogDetails::getremovedetails($id, $blood_products_details, DialpadSupportProperty::BLOOD_PRODUCT_GROUP);
        if (isset($input[DialpadSupportProperty::F_PRODUCT]))
        {

            foreach (DialpadSupportProperty::BLOOD_PRODUCT_GROUP as $blood_product_name)
            {

                $blood_product[$blood_product_name] = $input[$blood_product_name];

                unset($input[$blood_product_name]);

                foreach ($blood_product as $blood_product_key => $blood_product_value)
                {
                    foreach ($blood_product_value as $blood_product_id => $blood_value)
                    {

                        $emr_log_details = null;

                        if (!is_string($blood_product_id))
                        {
                            $emr_log_details = EmrLogDetails::find($blood_product_id);
                        }

                        if (count($emr_log_details) > 0)
                        {
                            $emr_log_details->Update([DialpadSupportProperty::INTF_REF_VALUE => $blood_value, 'modify_tstamp' => Carbon::now($this->time_zone), 'modify_user_id' => $this->auth->user()->id]);
                            unset($blood_product[$blood_product_key][$blood_product_id]);
                        }
                        else
                        {
                            if (DialpadSupportProperty::F_PRODUCT == $blood_product_name)
                            {

                                if (isset(explode('_', $blood_product_id) [1])) {

                                    $blood_product_id = explode('_', $blood_product_id) [1];

                                    $start_sender_time = date('Y-m-d H:i:s', strtotime($input['sheet_date']));

                                    $date = Carbon::createFromFormat('d-m-Y', $input['sheet_date'])->addDay();

                                    $end_sender_time = date('Y-m-d', strtotime($date));

                                    $check_log = EmrLogDetails::checkLogIsExist($start_sender_time, $end_sender_time, $input["BabyId"], $admission_id, $baby_details["MotherId"]);

                                    $observation_type_id = 0;

                                    $local_blood = (array)$loinc_reference->where('local_code', DialpadSupportProperty::F_PRODUCT)
                                    ->first();
                                    $local_volume = (array)$loinc_reference->where('local_code', DialpadSupportProperty::F_VOLUME)
                                    ->first();
                                    $blood_productid = 'blood-product_' . $blood_product_id;
                                    $observation_type_id = $this->addmultiplelist($check_log->id, $blood_product[DialpadSupportProperty::F_PRODUCT][$blood_productid], $local_blood, $observation_type_id);
                                    unset($blood_product[$blood_product_key][$blood_productid]);
                                    $volume_product = 'blood-volume_' . $blood_product_id;
                                    $this->addmultiplelist($check_log->id, $input[DialpadSupportProperty::F_VOLUME][$volume_product], $local_volume, $observation_type_id);
                                    unset($blood_product[$blood_product_key][$volume_product]);
                                }

                            }
                        }
                    }
                }

            }
            unset($input[DialpadSupportProperty::F_PRODUCT]);
        }

        if (isset($input['pump_drug_solution']) && (isset($input['pump_drug_rate']) || isset($input['pump_drug_total']))) {
            foreach ($input['pump_drug_solution'] as $key => $value) {
                if ($input['pump_drug_rate'][$key] != '' && $input['pump_drug_total'][$key] != '') {
                    \DB::table('prescription_infused_calculation')->where('id', $key)->update(['hour_rate' => $input['pump_drug_rate'][$key], 'hour_infused' => $input['pump_drug_total'][$key], 'edited_by' => $this->auth->user()->id, 'edited_date_time' => Carbon::now($this->time_zone)]);
                }
            }
            unset($input['pump_drug_solution']);
            unset($input['pump_drug_rate']);
            unset($input['pump_drug_total']);
        }

        $form_data = $input;
        unset($form_data['formid']);
        unset($form_data['sheet_date']);
        unset($form_data['dcp']);
        unset($form_data['hemolysis']);
        if(isset($form_data['current_weight'])) {
            unset($form_data['current_weight']);
        }
        if(isset($form_data['working_weight'])) {
            unset($form_data['working_weight']);
        }
        if(isset($form_data['ett_status'])) {
            unset($form_data['ett_status']);
        }
        if (isset($form_data['et_size'])) {
            unset($form_data['et_size']);
        }
        if (isset($form_data['et_length'])) {
            unset($form_data['et_length']);
        }
        if (isset($form_data['ngt_status'])) {
            unset($form_data['ngt_status']);
        }
        if (isset($form_data['ngt_size'])) {
            unset($form_data['ngt_size']);
        }
        if (isset($form_data['ngt_length'])) {
            unset($form_data['ngt_length']);
        }
        unset($form_data['BabyId']);
        unset($form_data['temp_time_hour']);
        unset($form_data['temp_time_min']);
        unset($form_data['temp_time_session']);
        unset($form_data['print_flag']);
        unset($form_data['admission_id']);
        if (isset($form_data['phototherapy']))
        {
            unset($form_data['phototherapy']);
        }
        if (isset($form_data['phototherapy_eyes']))
        {
            unset($form_data['phototherapy_eyes']);
        }

        if (!empty($form_data) && count($form_data) != 0)
        {
            foreach ($form_data as $key => $value)
            {
                if (is_array($value)) {
                    foreach ($value as $key1 => $value1)
                    {
                        $value_id = $key1;
                        if (in_array($key, DialpadSupportProperty::EMR_NURSE_MANUAL_VALUES))
                        {
                            $current_table_name = 'emr_nurse_manual_values';
                        }
                        elseif (in_array($key, DialpadSupportProperty::EMR_MONITER_VALUES))
                        {
                            $current_table_name = 'emr_moniter_values';
                        }
                        elseif (in_array($key, DialpadSupportProperty::EMR_VENTILATOR_VALUES))
                        {
                            $current_table_name = 'emr_ventilator_values';
                        }
                        elseif (in_array($key, DialpadSupportProperty::EMR_LAB_VALUES))
                        {
                            $current_table_name = 'emr_lab_values';
                        }
                        elseif (in_array($key, DialpadSupportProperty::EMR_NURSE_HEADER_VALUES))
                        {
                            $is_time_based_entry = explode(':', $value_id);
                            if (is_numeric($value_id))
                            {
                                $check_log_header = EmrLogHeader::where('id', $value_id)->first();
                                if (isset($check_log_header->id))
                                {
                                    EmrLogHeader::where('id', $value_id)->update(['added_nurse' => $value1, 'modify_tstamp' => Carbon::now($this->time_zone), 'modify_user_id' => $this->auth->user()->id]);
                                }
                                return \Response::json(['type' => 'success', 'message' => 'Time sheet added successfully !'], 200);
                            }
                            elseif (count($is_time_based_entry) > 1)
                            {
                                $header_id = $this->checkDayHeader($value_id, $input, $baby_details);
                                return \Response::json(['type' => 'success', 'message' => 'Time sheet added successfully !'], 200);
                            }
                        }

                        else
                        {
                            return \Response::json(['type' => 'error', 'message' => 'Something went wrong...!'.$key], 500);

                        }

                        $value_id = $key1;
                        $is_time_based_entry = explode(':', $value_id);
                        $is_id_based_value = explode('-', $value_id);

                        if (count($is_time_based_entry) > 1)
                        {

                            $header_id = $this->checkDayHeader($value_id, $input, $baby_details);

                            $check_log_details_exist = EmrLogDetails::checkLogDetailIsExist($header_id, $key, $current_table_name);

                            if (isset($check_log_details_exist->id))
                            {
                                if ($value1 != $check_log_details_exist->intf_ref_value)
                                {
                                    if ($check_log_details_exist->loinc_local_map_id == 316) {
                                        \DB::table($current_table_name)->where('id', $check_log_details_exist->id)->update(['intf_ref_value' => $value1, 'original_intf_ref_value' => $value1, 'modify_tstamp' => Carbon::now($this->time_zone), 'modify_user_id' => $this->auth->user()->id]);
                                    } else {
                                        \DB::table($current_table_name)->where('id', $check_log_details_exist->id)->update(['intf_ref_value' => $value1, 'mean' => $value1, 'original_intf_ref_value' => $value1, 'modify_tstamp' => Carbon::now($this->time_zone), 'modify_user_id' => $this->auth->user()->id]);                                        
                                    }

                                }
                            }
                            else
                            {
                                $get_local_id = \DB::table('local_code_group')->select('id')
                                ->where('local_code', $key)->first();
                                $get_header_data = EmrLogHeader::where('id', $header_id)->first();

                                if (!isset($get_local_id->id)) {
                                    $get_local_id = (object)[];
                                    $get_local_id->id = 0;
                                }
                                if ($get_local_id->id == 316) {
                                    $insert_log_data = array(
                                        'log_hdr_id' => $header_id,
                                        'intf_ref_value' => $value1,
                                        'original_intf_ref_value' => $value1,
                                        'loinc_local_map_id' => $get_local_id->id,
                                        'result_date_time' => $get_header_data->sender_time,
                                        'create_tstamp' => Carbon::now($this->time_zone) ,
                                        'create_user_id' => $this->auth->user()->id,
                                        'modify_tstamp' => Carbon::now($this->time_zone) ,
                                        'modify_user_id' => $this->auth->user()->id,
                                    );
                                } else {                                    
                                    $insert_log_data = array(
                                        'log_hdr_id' => $header_id,
                                        'intf_ref_value' => $value1,
                                        'mean' => $value1,
                                        'original_intf_ref_value' => $value1,
                                        'loinc_local_map_id' => $get_local_id->id,
                                        'result_date_time' => $get_header_data->sender_time,
                                        'create_tstamp' => Carbon::now($this->time_zone) ,
                                        'create_user_id' => $this->auth->user()->id,
                                        'modify_tstamp' => Carbon::now($this->time_zone) ,
                                        'modify_user_id' => $this->auth->user()->id,
                                    );
                                }
                                \DB::table($current_table_name)->insert($insert_log_data);
                            }
                        }
                        elseif (count($is_id_based_value) > 1)
                        {
                            if (isset($is_id_based_value[0]) && count($is_id_based_value) > 0)
                            {
                                $header_id = $is_id_based_value[0];
                                $check_log_details_exist = EmrLogDetails::checkLogDetailIsExist($header_id, $key, $current_table_name);
                                if (isset($check_log_details_exist->id))
                                {
                                    if ($value1 != $check_log_details_exist->intf_ref_value)
                                    {
                                        if ($check_log_details_exist->loinc_local_map_id == 316) {
                                            \DB::table($current_table_name)->where('id', $check_log_details_exist->id)->update(['intf_ref_value' => $value1, 'original_intf_ref_value' => $value1, 'modify_tstamp' => Carbon::now($this->time_zone), 'modify_user_id' => $this->auth->user()->id]);
                                        } else {
                                            \DB::table($current_table_name)->where('id', $check_log_details_exist->id)->update(['intf_ref_value' => $value1, 'mean' => $value1, 'original_intf_ref_value' => $value1, 'modify_tstamp' => Carbon::now($this->time_zone), 'modify_user_id' => $this->auth->user()->id]);                                        
                                        }

                                    }
                                }
                                else
                                {
                                    $get_local_id = \DB::table('local_code_group')->select('id')
                                    ->where('local_code', $key)->first();
                                    $get_header_data = EmrLogHeader::where('id', $header_id)->first();
                                    if (isset($get_local_id->id) && !empty($get_local_id->id)) {
                                        if ($get_local_id->id == 316) {
                                            $insert_log_data = array(
                                                'log_hdr_id' => $header_id,
                                                'intf_ref_value' => $value1,
                                                'original_intf_ref_value' => $value1,
                                                'loinc_local_map_id' => $get_local_id->id,
                                                'result_date_time' => $get_header_data->sender_time,
                                                'create_tstamp' => Carbon::now($this->time_zone),
                                                'create_user_id' => $this->auth->user()->id,
                                                'modify_tstamp' => Carbon::now($this->time_zone),
                                                'modify_user_id' => $this->auth->user()->id,
                                            );
                                        } else {                                    
                                            $insert_log_data = array(
                                                'log_hdr_id' => $header_id,
                                                'intf_ref_value' => $value1,
                                                'mean' => $value1,
                                                'original_intf_ref_value' => $value1,
                                                'loinc_local_map_id' => $get_local_id->id,
                                                'result_date_time' => $get_header_data->sender_time,
                                                'create_tstamp' => Carbon::now($this->time_zone),
                                                'create_user_id' => $this->auth->user()->id,
                                                'modify_tstamp' => Carbon::now($this->time_zone),
                                                'modify_user_id' => $this->auth->user()->id,
                                            );
                                        }
                                        if ($value1 != '' && trim($value1) != '')
                                        {
                                            \DB::table($current_table_name)->insert($insert_log_data);
                                        }
                                    }
                                }
                            }

                        }
                        else
                        {
                            $get_last_header_id = EmrLogHeader::where('baby_id', $input['BabyId'])->where('admission_id', $input['admission_id'])->orderBy('id', 'desc')
                            ->first();
                            $check_log_details_exist = EmrLogDetails::checkLogDetailIsExist($get_last_header_id->id, $key, $current_table_name);
                            if (isset($check_log_details_exist->id))
                            {
                                if ($value1 != $check_log_details_exist->intf_ref_value)
                                {
                                    \DB::table($current_table_name)->where('id', $check_log_details_exist->id)
                                    ->update(['intf_ref_value' => $value1, 'mean' => $value1, 'original_intf_ref_value' => $value1, 'modify_tstamp' => Carbon::now($this->time_zone), 'modify_user_id' => $this->auth->user()->id]);

                                }
                            }
                            else
                            {
                                $get_local_id = \DB::table('local_code_group')->select('id')
                                ->where('local_code', $key)->first();
                                if (isset($get_local_id->id)) {
                                    $insert_log_data = array(
                                        'log_hdr_id' => $get_last_header_id->id,
                                        'intf_ref_value' => $value1,
                                        'mean' => $value1,
                                        'original_intf_ref_value' => $value1,
                                        'loinc_local_map_id' => $get_local_id->id,
                                        'result_date_time' => $get_last_header_id->sender_time,
                                        'create_tstamp' => Carbon::now($this->time_zone) ,
                                        'create_user_id' => $this->auth->user()->id,
                                        'modify_tstamp' => Carbon::now($this->time_zone) ,
                                        'modify_user_id' => $this->auth->user()->id,
                                    );
                                }
                                if ($value1 != '' && trim($value1) != '')
                                {
                                    \DB::table($current_table_name)->insert($insert_log_data);
                                }
                            }

                        }

                    }
                }
            }
        }

        if ($total_input_calculation) {
            $this->dayTotalInput($input);
        }

        if ($total_output_calculation) {
            $this->dayTotalOutput($input);
        }

        \SiteHelpers::updateDashboardAtFormUpdation($input['BabyId'], 'Nurse sheet - update');

        if ($request->ajax())
        {
            return \Response::json(['type' => 'success', 'message' => 'Time sheet added successfully !'], 200);
        }

        if (isset($input['print_flag']) && $input['print_flag'] == 1)
        {
            return redirect(action('Nurse\NurseSheetController@edit', \SiteHelpers::encrypt_id($id)))->with('Success', 'Time sheet updated successfully');
        }
        elseif (isset($input['print_flag']) && $input['print_flag'] == 2)
        {
            return redirect(action('Nurse\NurseSheetController@GetDaylist', \SiteHelpers::encrypt_id($admission_id)))->with('Success', 'Time sheet updated successfully');
        }
        elseif (isset($input['print_flag']) && $input['print_flag'] == 3)
        {
            return redirect(action('Nurse\NurseSheetController@print', \SiteHelpers::encrypt_id($id)))->with('Success', 'Time sheet updated successfully');
        }
        else
        {
            return redirect(action('Nurse\NurseSheetController@print', \SiteHelpers::encrypt_id($id)))->with('Success', 'Time sheet updated successfully');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print ($id, $closewinlink = 'nicu-nurse-sheets')
    {
        $time1 = microtime(true);
        $id = \SiteHelpers::decrypt_id($id);

        $nurse_details_sheet = NurseSheetMain::find($id);

        $baby = Baby::find($nurse_details_sheet->baby_id);
        $ip_details = IpNumber::getCurrent_ip($nurse_details_sheet->baby_id, $nurse_details_sheet->admission_id);

        $gestation_days = \SiteHelpers::convert_gestation_days($baby->Gestation);
        $dayoflife = \SiteHelpers::calculate_day_of_life_two($baby->DOB, $nurse_details_sheet->sheet_date);
        $corrected_gestation = \SiteHelpers::calculate_corrected_gestation($gestation_days, $dayoflife);
        $corrected_gestation = \SiteHelpers::decode_gestation(json_encode($corrected_gestation));
        $sheet_date = date('d-m-Y', strtotime($nurse_details_sheet->sheet_date));
        $current_date = $nurse_details_sheet->sheet_date;

        $ivfluids = $pn_fluids = $replacement_fluids = $temp_antibio_groups = $temp_otherdrugs_groups = array();

        $result = $nurse_replacement_fluids = $milk_feeds = array();

        $addNurseList = $n_sofa_score = array();

        $actual_time = Carbon::now($this->time_zone)->format('Y-m-d') . ' 00:00:00';
        $actual_time = Carbon::parse($actual_time);

        $working_time = Settings::getPeriod()->period;

        $work_time = Carbon::now($this->time_zone)->format('Y-m-d') . ' ' . $working_time;
        $work_time = Carbon::parse($work_time);
        $last_column_span = $work_time->diffInHours($actual_time);
        $first_column_span = 24 - $last_column_span;

        $start_time = date('Y-m-d H:i:s', strtotime($sheet_date . ' ' . $working_time));

        $start_time = Carbon::createFromFormat('Y-m-d H:i:s', $start_time);

        $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $start_time)->addDay();
        $drug_end_time = Carbon::createFromFormat('Y-m-d H:i:s', $start_time)->addDay();

        $endtime = $end_time;

        $start_working_time = Carbon::createFromFormat('Y-m-d H:i:s', $start_time);
        $start_working_hour = $start_working_time->format('H');
        $end_working_time = Carbon::createFromFormat('Y-m-d H:i:s', $end_time)->subHour();
        $end_working_time1 = Carbon::createFromFormat('Y-m-d H:i:s', $end_time);
        $start_working_hour = $end_working_time1->format('H');

        $nurse_header_list = collect(EmrLogHeader::getEmrLogHdrWithNSofaScore($nurse_details_sheet->baby_id, $nurse_details_sheet->admission_id, $start_time, $end_time));
        $patient_status = DischargeLog::getDischargeDetail($nurse_details_sheet->baby_id, $nurse_details_sheet->admission_id);
        
        $monitor_data_table_name = 'emr_moniter_values';
        $ventilator_data_table_name = 'emr_ventilator_values';
        $lab_data_table_name = 'emr_lab_values';
        $manual_data_table_name = 'emr_nurse_manual_values';
        $prescription_hdr = 'prescription_hdr';
        $prescription_dtl = 'prescription_dtl';
        $prescription_table = 'prescription_infused_calculation';

        if (count($patient_status) > 0) {
            $monitor_data_table_name = 'emr_moniter_values_discharged';
            $ventilator_data_table_name = 'emr_ventilator_values_discharged';
            $lab_data_table_name = 'emr_lab_values_discharged';
            $manual_data_table_name = 'emr_nurse_manual_values_discharged';
            $prescription_dtl = 'prescription_dtl_discharged';
            // $prescription_table = 'prescription_discharged';
            $prescription_table = 'prescription_infused_calculation_discharged';
        }

        foreach ($nurse_header_list as $header_id => $header_value)
        {
            $time_sheet = date('d:H:00', strtotime($header_value->sender_time));
            $timevalue = explode(':', $time_sheet) [0] . ':' . explode(':', $time_sheet) [1] . ':00';
            if (!empty($header_value->added_nurse)) {
                $addNurseList[$timevalue]['nurse'] = $header_value->added_nurse;
                $addNurseList[$timevalue]['time'] = $time_sheet;
            }
            $n_sofa_score[$timevalue] = $header_value->total_nsofa_score;
            $moniter_values = EmrLogHeader::get_emr_values($header_value->id, $monitor_data_table_name);
            $ventilator_values = EmrLogHeader::get_emr_values($header_value->id, $ventilator_data_table_name );
            if (isset($ventilator_values) && !empty($ventilator_values))
            {
                $ventilator_values = $ventilator_values->unique('loinc_local_map_id');
                $asset_number = $ventilator_values->where('loinc_local_map_id', '47')
                ->first();

                if (isset($asset_number->device_id) && !empty($asset_number->device_id))
                {
                    $ventilation_mode = $asset_number->intf_ref_value;
                    $device_id = $asset_number->device_id;
                    $ventilator_value_filtered = \DeviceHelpers::getVentilatorvaluesByMode($ventilation_mode, $device_id);
                    $ventilator_values = $ventilator_values->whereIn('local_code', $ventilator_value_filtered)->toArray();
                }
            }
            $emr_lab_values = EmrLogHeader::get_emr_values($header_value->id, $lab_data_table_name);
            $emr_values = EmrLogHeader::get_emr_values($header_value->id, 'emr_log_dtl');
            $emr_nurse_manual_values = EmrLogHeader::get_emr_values($header_value->id, $manual_data_table_name);
            $loinc_code_details = $moniter_values->merge($ventilator_values);
            $loinc_code_details = $loinc_code_details->merge($emr_values);
            $loinc_code_details = $loinc_code_details->merge($emr_nurse_manual_values);
            $loinc_code_details = $loinc_code_details->merge($emr_lab_values)->toArray();

            $nurse_replacement_fluids[$timevalue] = NurseHourSheet::GetData($header_value->id);

            if (isset($result[$timevalue])) {
                $result_temp = collect($loinc_code_details);
                $result[$timevalue] = json_decode(json_encode(collect($result[$timevalue])->merge($result_temp)->toArray()), true);
            }
            else
            {
                $loinc_code_details = json_decode(json_encode($loinc_code_details) , true);
                $result[$timevalue] = $loinc_code_details;
            }
        }
        $baby_observe = DialpadSupportProperty::BABY_OBSERVATIONS;
        $respiratorty_support = DialpadSupportProperty::RESPIRATORY_SUPPORT;
        $milk_feeds = DialpadSupportProperty::MILK_FEEDS;
        $output_groups = DialpadSupportProperty::OUTPUT_GROUPS;
        $code_phototherapy = DialpadSupportProperty::PHOTOTHERAPY;
        $code_phototherapy_eyes = DialpadSupportProperty::PHOTOTHERAPY_EYES;
        $baby_observe[] = DialpadSupportProperty::LOINC_LOCAL_CODE[118];

        $temp_pn_fluids = $temp_replacement_fluids = null;

        $pn_fluids = $replacement_fluids = $prescription_pn_fluid = $prescription_fluid = $fluid = $fluid_name_base = $fluid_volume_base = $fluid_total_base = $prescription_fluids = $time_slots = array();
        $fluids_prescribed_iv_infusion = $fluids_prescribed_other_iv_drugs = $fluids_prescribed_other_iv_infusion = $fluids_prescribed_glucose_intake = $drug_values = $fluids_prescribed = array();
        $time_slots_temp = $nurse_header_list->pluck('sender_time');

        foreach ($time_slots_temp as $key => $value)
        {
            $temp_slots = date('d:H', strtotime($value)) . ':00';
            if (!in_array($temp_slots, $time_slots))
            {
                $time_slots[] = $temp_slots;
            }
        }

        if (isset($time_slots))
        {
            foreach ($time_slots as $time_key => $time_value)
            {
                $temp_pn_fluids[$time_value] = collect($result[$time_value])->whereIn('local_code', DialpadSupportProperty::DRUG_FLUIDS);
                $temp_replacement_fluids[$time_value] = collect($nurse_replacement_fluids[$time_value])->whereIn('local_code', DialpadSupportProperty::REPLACMENT_FLUIDS);
                $replacement_fluids = array_merge($replacement_fluids, collect($nurse_replacement_fluids[$time_value])->whereIn('local_code', DialpadSupportProperty::REPLACMENT_FLUIDS_SOLUTION)
                    ->pluck('value')
                    ->toArray());
                $temp_milk_feeds[$time_value] = collect($result[$time_value])->whereIn('local_code', DialpadSupportProperty::MILK_FEEDS);
                $temp_output_groups[$time_value] = collect($result[$time_value])->whereIn('local_code', DialpadSupportProperty::OUTPUT_GROUPS);
                $temp_antibio_groups[$time_value] = collect($result[$time_value])->whereIn('local_code', DialpadSupportProperty::A_ANTIBIOTIC_GROUP);
                $temp_otherdrugs_groups[$time_value] = collect($result[$time_value])->whereIn('local_code', DialpadSupportProperty::OTHER_DRUGS);
                $oral_drugs[$time_value] = collect($result[$time_value])->whereIn('local_code', DialpadSupportProperty::ORALDRUG_GROUP);
                $phototherapy[$time_value] = collect($nurse_replacement_fluids[$time_value])->whereIn('local_code', DialpadSupportProperty::PHOTOTHERAPY)
                ->pluck('value')
                ->toArray();
                $phototherapy_eyes[$time_value] = collect($nurse_replacement_fluids[$time_value])->whereIn('local_code', DialpadSupportProperty::PHOTOTHERAPY_EYES)
                ->pluck('value')
                ->toArray();
                $prescription_pn_fluid[$time_value] = collect($result[$time_value])->whereIn('local_code', [DialpadSupportProperty::PRESCRIBED_DRUG_FLUIDS, DialpadSupportProperty::DRUG_FLUIDS])
                ->groupBy('time');
            }
        }
        foreach ($result as $result_key => $result_value)
        {
            ksort($result_value);
            $temp_drugs = collect($result_value)->where('local_code', 'drug_solution');

            if (count($temp_drugs) > 0)
            {

                foreach ($temp_drugs as $temp_key => $temp_value)
                {
                    if ($temp_value['intf_ref_value'] > 0) {
                        $drug_name = DrugIvFluidMaster::getBrandDrugName($temp_value['intf_ref_value'])->name;

                        $temp_rate = collect($result_value)->where('observation_type_id', $temp_value['id'])->where('local_code', 'drug_rate')
                        ->last();

                        $pn_fluids[$drug_name][$result_key]['drug_rate'] = $temp_rate['intf_ref_value'];

                        $temp_total = collect($result_value)->where('observation_type_id', $temp_value['id'])->where('local_code', 'drug_total')
                        ->last();

                        $pn_fluids[$drug_name][$result_key]['drug_total'] = $temp_total['intf_ref_value'];
                    }
                }

            }
        }

        $temp_time_slot = isset($time_slots) ? $time_slots : [];

        unset($time_slots);
        $time_part1 = $time_part2 = array();

        $start_date = explode('-', $nurse_details_sheet->sheet_date) [2];
        $end_time = Carbon::createFromFormat('Y-m-d', $nurse_details_sheet->sheet_date)
        ->addDay();
        $end_date = explode(' ', explode('-', $end_time) [2]) [0];

        for ($i = $start_working_hour;$i <= 23;$i++)
        {
            $time_part1[] = strlen($i) == 2 ? $start_date . ':' . $i : $start_date . ':' . '0' . $i;
        }
        for ($i = 0;$i <= $start_working_hour;$i++)
        {
            $time_part2[] = strlen($i) == 2 ? $end_date . ':' . $i : $end_date . ':' . '0' . $i;
        }
        $time = array_merge($time_part1, $time_part2);

        foreach ($time as $key => $value)
        {
            unset($flag);
            foreach ($temp_time_slot as $key => $temp_slot)
            {
                $values = explode(':', $value) [0] . ':' . explode(':', $value) [1];
                $slots = explode(':', $temp_slot) [0] . ':' . explode(':', $temp_slot) [1];
                if ($values == $slots) {
                    $time_slots[] = explode(':', $value) [0] . ':' . explode(':', $temp_slot) [1] . ':00';
                    $flag = 1;
                }
            }
            if (!isset($flag)) $time_slots[] = $value . ':00';
        }
        $temp_result = collect($result)->collapse();
        $et_size = $nurse_details_sheet->et_size;
        $et_length = $nurse_details_sheet->et_length;
        $ngt_size = $nurse_details_sheet->ngt_size;
        $ngt_length = $nurse_details_sheet->ngt_length;
        $current_weight = $nurse_details_sheet->current_weight;
        $working_weight = $nurse_details_sheet->working_weight;

        $ivfluids = DrugIvFluidMaster::getFluidValue();
        $replacement_fluids = collect($replacement_fluids)->unique()->toArray();
        $temp_antibio_groups = collect($temp_antibio_groups)->collapse();
        $temp_otherdrugs_groups = collect($temp_otherdrugs_groups)->collapse()->unique('intf_ref_value');
        $master_drugs = DrugIvFluidMaster::where(['is_deleted' => '0', 'status' => 1])->where('type', 'ORAL')->pluck('brand_name', 'id')
        ->toArray();

        $closewinlink = action('Nurse\NurseSheetController@GetDaylist', \SiteHelpers::encrypt_id($nurse_details_sheet->admission_id)).'/'.$closewinlink;

        $drugs_gen = DrugIvFluidMaster::where(['is_deleted' => '0', 'status' => 1])->where('type', 'ORAL')->orderby('id', 'asc')
        ->pluck('generic_pharmacological_name', 'id')
        ->toArray();

        ksort($addNurseList);
        // $unique_nurse = collect($addNurseList)->unique('nurse')
        // ->pluck('nurse')
        // ->toArray();
        $nurse_entered = collect($addNurseList)->pluck('nurse', 'time')->toArray();
        // $nurse_entered = array();

        // foreach ($unique_nurse as $value)
        // {
        //     $nurse_end = collect($addNurseList)->where('nurse', $value)->max('time');
        //     $temp_nurse_end = explode(':', $nurse_end);
        //     $nurse_entered[$value] = $temp_nurse_end[0] . ':' . $temp_nurse_end[1] . ':00';
        // }
        // $nurse_entered = array_flip($nurse_entered);

        $nurse_master = NurseMaster::get()->pluck('name', 'id')->toArray();

        $time_slots_count = count($time_slots) - 1;
        unset($time_slots[$time_slots_count]);
        $non_invasive = array(
            'NCPAP (D)',
            'NCPAP (S)',
            'DUOPAP',
            'NIPPV Tr',
            'NHFOV (D)',
            'NIPPV (D)'
        );
        $milk_vol_for_time=0;

        $sheet_date =  date('d/m/Y H:00', strtotime($start_working_time)) . ' - ' . date('d/m/Y H:00', strtotime($end_working_time));

        $data_filter = new Request([
            'baby_id'   => $nurse_details_sheet->baby_id,
            'admission_id' => $nurse_details_sheet->admission_id,
            'start_time' => $start_time,
            'end_time' => $endtime,
        ]);

        $monitor_status = 0;
        $lab_status = 0;
        $pump_status = 0;
        $ventilator_status = 0;
        $monitor_data = $this->getMonitorData($data_filter, $monitor_data_table_name);
        $monitor_status = $monitor_data['approval_count'];
        $ventilator_data = $this->getVentilatorData($data_filter, $ventilator_data_table_name);
        $ventilator_status = $ventilator_data['approval_count'];
        $pump_data = $this->getPumpData($data_filter, $prescription_dtl, $prescription_table);

        $prescription_fluid = $pump_data['drugs_list'];

        $pn_fluids = array_merge_recursive($pn_fluids, $prescription_fluid);

        $pump_status = $pump_data['approval_count'];
        $approval_status = 0;

        if ($monitor_status > 0) {
            $approval_status += 1;
        }
        if ($ventilator_status > 0) {
            $approval_status += 1;
        }
        if ($pump_status > 0) {
            $approval_status += 1;
        }
        $invasive_ventilation = DialpadSupportProperty::INVASIVE_VENTILATION;
        $non_invasive_ventilation = DialpadSupportProperty::NON_INVASIVE_VENTILATION;

        // Manual ventilation mode
        $invasive_ventilation = array_merge($invasive_ventilation, ['HFO']);
        $non_invasive_ventilation = array_merge($non_invasive_ventilation, ['HHHFNC', 'CPAP', 'BiPAP', 'NIPPV', 'Nasal HFOV', 'HBO2', 'NPO2', 'Incubator O2', 'SV']);

        $ward_rounds_instruction = collect($temp_result)->where('local_code', 'ward_rounds_instruction')->pluck('intf_ref_value', 'result_date_time')->toArray();

        $nicu = Nicu::where('BabyId', $nurse_details_sheet['baby_id'])->where('AdmissionId', $nurse_details_sheet['admission_id'])->first();

        $hospital_name = isset($nicu->hospital_name) ? $nicu->hospital_name : '';

        $bed_details = DayWisePatientBedLog::getRoomDetails($id);

        $monitor_user = $this->monitor_user;
        $ventilator_user = $this->ventilator_user;

        $navigation_ids = $this->getPrevNextIds($nurse_details_sheet['admission_id'], $id);

        $prev_id = isset($navigation_ids['prev_id']) ? $navigation_ids['prev_id'] : null;
        $next_id = isset($navigation_ids['next_id']) ? $navigation_ids['next_id'] : null;

        $admission_id = $nurse_details_sheet->admission_id;
        return view('nurse_sheet.print', compact('time_slots', 'nurse_master', 'nurse_entered', 'working_weight', 'sheet_date', 'current_weight', 'corrected_gestation', 'ip_details', 'baby', 'oral_drugs', 'drugs_gen', 'temp_iv_drugs', 'output_groups', 'temp_infusion_drug', 'master_drugs', 'temp_otherdrugs_groups', 'temp_antibio_groups', 'temp_output_groups', 'milk_feeds', 'temp_milk_feeds', 'replacement_fluids', 'temp_replacement_fluids', 'temp_pn_fluids', 'closewinlink', 'ivfluids', 'pn_fluids', 'result', 'baby_observe', 'respiratorty_support', 'phototherapy', 'phototherapy_eyes', 'code_phototherapy', 'code_phototherapy_eyes', 'prescription_fluid', 'time', 'drugs_list', 'start_working_hour', 'time1', 'non_invasive','milk_vol_for_time', 'nurse_details_sheet', 'start_time', 'endtime', 'approval_status', 'invasive_ventilation', 'non_invasive_ventilation', 'et_size', 'et_length', 'ngt_size', 'ngt_length', 'ward_rounds_instruction', 'hospital_name', 'current_date', 'bed_details', 'monitor_data', 'ventilator_data', 'pump_data', 'first_column_span', 'last_column_span',  'monitor_user', 'ventilator_user', 'prev_id', 'next_id', 'admission_id', 'n_sofa_score'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function getnuresurl(Request $request)
    {
        $input = $request->all();

        if ($input['babyId'] != '' && $input['sheetDate'] != '' && $input['admissionId'] != '')
        {

            $url = url('nicu-nurse-sheet-print/' . $input['babyId'] . '/' . \SiteHelpers::encrypt_id($input['sheetDate']) . '/' . $input['admissionId']);
            return \Response::json(['type' => 'success', 'message' => $url], 200);

        }
        else
        {

            return \Response::json(['type' => 'failure', 'message' => 'Failure occured while create uri'], 500);
        }

    }
    /**
     * This method to get prescription
     * print new
     */
    public function getPrintPrescription($baby_id = null, $admission_id = null)
    {
        $baby = Baby::find($baby_id);
        $ip_numbers = '';
        $corrected_gestation = '';
        $prescription_date = '';

        $iv_drugs_infusion = NurseIvInfusion::getNurseInfusionList($baby_id, $admission_id);
        $other_iv_drugs_list = NurseOtherIvDrugs::getOtherIvDrugList($baby_id, $admission_id);
        $other_iv_infusion_lists = NurseOtherIvInfusion::getOtherIVInfusionList($baby_id, $admission_id);
        $special_fluids_list = NurseGlucoseIntake::getGlucoseIntakeList($baby_id, $admission_id);
        $oral_drugs = NurseOralDrugs::getOralDrugsList($baby_id, $admission_id);
        $drugs_brand_names = DrugIvFluidMaster::where(['is_deleted' => '0', 'status' => 1])->where('type', 'ORAL')->pluck('brand_name', 'id')
        ->toArray();
        $drugs_generic_name = DrugIvFluidMaster::where(['is_deleted' => '0', 'status' => 1])->where('type', 'ORAL')->pluck('generic_pharmacological_name', 'id')
        ->toArray();
        $ivfluids_gen = DrugIvFluidMaster::where(['is_deleted' => '0', 'status' => 1])->where('type', '<>', 'ORAL')->pluck('generic_pharmacological_name', 'id')
        ->toArray();
        $ivfluids = DrugIvFluidMaster::where(['is_deleted' => '0', 'status' => 1])->where('type', '<>', 'ORAL')->pluck('brand_name', 'id')
        ->toArray();

        return view('nurse_sheet.print_prescription', compact('iv_drugs_infusion', 'corrected_gestation', 'ivfluids', 'ivfluids_gen', 'other_iv_drugs_list', 'other_iv_infusion_lists', 'special_fluids_list', 'prescription_date', 'closewinlink', 'baby', 'ip_numbers', 'iv_drugs_list_other', 'oral_drugs', 'master_drugs', 'drugs_brand_names', 'drugs_generic_name'));

    }

    public function prescriptionprint($baby_id = null, $date = null, $admission_id = null)
    {

        $prescription_date = \SiteHelpers::decrypt_id($date);
        $prescription = EmrLogDetails::GetprescriptionDetails($baby_id, $prescription_date, $admission_id);
        $ip_numbers = IpNumber::getCurrent_ip($baby_id, $admission_id);
        $ip_numbers = isset($ip_numbers->ip_number) ? $ip_numbers->ip_number : null;
        $baby = Baby::find($baby_id);

        $gestation_days = \SiteHelpers::convert_gestation_days($baby->Gestation);
        $dayoflife = \SiteHelpers::calculate_day_of_life($baby->DOB);
        $corrected_gestation = \SiteHelpers::calculate_corrected_gestation($gestation_days, $dayoflife);
        $corrected_gestation = \SiteHelpers::decode_gestation(json_encode($corrected_gestation));

        //infustion iv drug start
        $temp_iv_drug = $prescription->whereIn('local_code', DialpadSupportProperty::INFUSION_GROUP);
        $temp_iv_drug_solution = $prescription->where('local_code', DialpadSupportProperty::INFUSION_DAY);
        $iv_drugs_infusion = $special_fluids_list = $oral_drugs = $other_iv_infusion_lists = $other_iv_drugs_list = null;
        foreach ($temp_iv_drug_solution as $infusion_key => $infusion_value)
        {

            $temp_infusions = null;
            $brand = $temp_iv_drug->where('local_code', DialpadSupportProperty::INFUSION_BRANDNAME)
            ->where('observation_type_id', $infusion_value->log_id)
            ->pluck('intf_ref_value')
            ->first();
            if ($brand != '')
            {

                $temp_infusions[DialpadSupportProperty::INFUSION_DAY] = $infusion_value->intf_ref_value;
                $temp_infusions[DialpadSupportProperty::INFUSION_BRANDNAME] = $temp_iv_drug->where('local_code', DialpadSupportProperty::INFUSION_BRANDNAME)
                ->where('observation_type_id', $infusion_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::INFUSION_PHARMACOLOGICAL] = $temp_iv_drug->where('local_code', DialpadSupportProperty::INFUSION_PHARMACOLOGICAL)
                ->where('observation_type_id', $infusion_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::INFUSION_DOSE] = $temp_iv_drug->where('local_code', DialpadSupportProperty::INFUSION_DOSE)
                ->where('observation_type_id', $infusion_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::INFUSION_DOSE_UNITS] = $temp_iv_drug->where('local_code', DialpadSupportProperty::INFUSION_DOSE_UNITS)
                ->where('observation_type_id', $infusion_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::INFUSION_QUANTITY] = $temp_iv_drug->where('local_code', DialpadSupportProperty::INFUSION_QUANTITY)
                ->where('observation_type_id', $infusion_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::INFUSION_QUANTITY_UNITS] = $temp_iv_drug->where('local_code', DialpadSupportProperty::INFUSION_QUANTITY_UNITS)
                ->where('observation_type_id', $infusion_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::INFUSION_SYRINGE] = $temp_iv_drug->where('local_code', DialpadSupportProperty::INFUSION_SYRINGE)
                ->where('observation_type_id', $infusion_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::INFUSION_RATE] = $temp_iv_drug->where('local_code', DialpadSupportProperty::INFUSION_RATE)
                ->where('observation_type_id', $infusion_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::INFUSION_INSTRUCTION] = $temp_iv_drug->where('local_code', DialpadSupportProperty::INFUSION_INSTRUCTION)
                ->where('observation_type_id', $infusion_value->log_id)
                ->pluck('intf_ref_value')
                ->first();

                $temp_infusions[DialpadSupportProperty::INFUSION_DATE_PRESCRIBED] = $temp_iv_drug->where('local_code', DialpadSupportProperty::INFUSION_DATE_PRESCRIBED)
                ->where('observation_type_id', $infusion_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::INFUSION_TIME_PRESCRIBED] = $temp_iv_drug->where('local_code', DialpadSupportProperty::INFUSION_TIME_PRESCRIBED)
                ->where('observation_type_id', $infusion_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::INFUSION_DATE_STOPPED] = $temp_iv_drug->where('local_code', DialpadSupportProperty::INFUSION_DATE_STOPPED)
                ->where('observation_type_id', $infusion_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::INFUSION_TIME_STOPPED] = $temp_iv_drug->where('local_code', DialpadSupportProperty::INFUSION_TIME_STOPPED)
                ->where('observation_type_id', $infusion_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $iv_drugs_infusion[] = $temp_infusions;

            }

        }

        $iv_drugs_infusion = collect($iv_drugs_infusion)->unique('infusion_brandname')
        ->toArray();
        //infustion iv drug end
        // GLUCOSE INTAKE drug start
        $temp_speical_fluids = $temp_speical_fluids_solution = null;
        $temp_speical_fluids = $prescription->whereIn('local_code', DialpadSupportProperty::SPEICAL_IV_GROUP);
        $temp_speical_fluids_solution = $prescription->where('local_code', DialpadSupportProperty::SPEICAL_IV_DAY);

        foreach ($temp_speical_fluids_solution as $speical_fluids_key => $speical_fluids_value)
        {
            $temp_infusions = null;
            $brand = $temp_speical_fluids->where('local_code', DialpadSupportProperty::SPEICAL_IV_NAME_ONE)
            ->where('observation_type_id', $speical_fluids_value->log_id)
            ->pluck('intf_ref_value')
            ->first();
            if ($brand != '')
            {

                $temp_infusions[DialpadSupportProperty::SPEICAL_IV_DAY] = $speical_fluids_value->intf_ref_value;
                $temp_infusions[DialpadSupportProperty::SPEICAL_IV_NAME_ONE] = $temp_speical_fluids->where('local_code', DialpadSupportProperty::SPEICAL_IV_NAME_ONE)
                ->where('observation_type_id', $speical_fluids_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::SPEICAL_IV_NAME_TWO] = $temp_speical_fluids->where('local_code', DialpadSupportProperty::SPEICAL_IV_NAME_TWO)
                ->where('observation_type_id', $speical_fluids_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::SPEICAL_IV_VOL_ONE] = $temp_speical_fluids->where('local_code', DialpadSupportProperty::SPEICAL_IV_VOL_ONE)
                ->where('observation_type_id', $speical_fluids_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::SPEICAL_IV_VOL_TWO] = $temp_speical_fluids->where('local_code', DialpadSupportProperty::SPEICAL_IV_VOL_TWO)
                ->where('observation_type_id', $speical_fluids_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::SPEICAL_IV_SYRINGE] = $temp_speical_fluids->where('local_code', DialpadSupportProperty::SPEICAL_IV_SYRINGE)
                ->where('observation_type_id', $speical_fluids_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::SPEICAL_IV_DEXTROSE] = $temp_speical_fluids->where('local_code', DialpadSupportProperty::SPEICAL_IV_DEXTROSE)
                ->where('observation_type_id', $speical_fluids_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::SPEICAL_IV_GLUCOSE] = $temp_speical_fluids->where('local_code', DialpadSupportProperty::SPEICAL_IV_GLUCOSE)
                ->where('observation_type_id', $speical_fluids_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::SPEICAL_IV_RATE] = $temp_speical_fluids->where('local_code', DialpadSupportProperty::SPEICAL_IV_RATE)
                ->where('observation_type_id', $speical_fluids_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::SPEICAL_IV_INSTRUCTION] = $temp_speical_fluids->where('local_code', DialpadSupportProperty::SPEICAL_IV_INSTRUCTION)
                ->where('observation_type_id', $speical_fluids_value->log_id)
                ->pluck('intf_ref_value')
                ->first();

                $temp_infusions[DialpadSupportProperty::SPEICAL_IV_DATE_PRESCRIBED] = $temp_speical_fluids->where('local_code', DialpadSupportProperty::SPEICAL_IV_DATE_PRESCRIBED)
                ->where('observation_type_id', $speical_fluids_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::SPEICAL_IV_TIME_PRESCRIBED] = $temp_speical_fluids->where('local_code', DialpadSupportProperty::SPEICAL_IV_TIME_PRESCRIBED)
                ->where('observation_type_id', $speical_fluids_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::SPEICAL_IV_DATE_STOPPED] = $temp_speical_fluids->where('local_code', DialpadSupportProperty::SPEICAL_IV_DATE_STOPPED)
                ->where('observation_type_id', $speical_fluids_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::SPEICAL_IV_TIME_STOPPED] = $temp_speical_fluids->where('local_code', DialpadSupportProperty::SPEICAL_IV_TIME_STOPPED)
                ->where('observation_type_id', $speical_fluids_value->log_id)
                ->pluck('intf_ref_value')
                ->first();

                $special_fluids_list[] = $temp_infusions;

            }
        }

        $special_fluids_list = collect($special_fluids_list)->unique('speical_iv_fluid_name_one')
        ->toArray();

        // GLUCOSE INTAKE drug end
        // other iv infusion start
        $temp_other_infusion = $temp_other_infusion_solution = null;
        $temp_other_infusion = $prescription->whereIn('local_code', DialpadSupportProperty::OTHER_INFUTION_GROUP);
        $temp_other_infusion_solution = $prescription->where('local_code', DialpadSupportProperty::OTHER_IV_INFU_DAY);

        foreach ($temp_other_infusion_solution as $iv_drug_key => $iv_drug_value)
        {

            $temp_other_infusions = null;
            $brand = $temp_other_infusion->where('local_code', DialpadSupportProperty::OTHER_IV_INFU_PHARAM)
            ->where('observation_type_id', $iv_drug_value->log_id)
            ->pluck('intf_ref_value')
            ->first();
            if ($brand != '')
            {

                $temp_other_infusions[DialpadSupportProperty::OTHER_IV_INFU_DAY] = $iv_drug_value->intf_ref_value;
                $temp_other_infusions[DialpadSupportProperty::OTHER_IV_INFU_PHARAM] = $temp_other_infusion->where('local_code', DialpadSupportProperty::OTHER_IV_INFU_PHARAM)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_other_infusions[DialpadSupportProperty::OTHER_IV_INFU_VOL] = $temp_other_infusion->where('local_code', DialpadSupportProperty::OTHER_IV_INFU_VOL)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_other_infusions[DialpadSupportProperty::OTHER_IV_INFU_DURATION] = $temp_other_infusion->where('local_code', DialpadSupportProperty::OTHER_IV_INFU_DURATION)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_other_infusions[DialpadSupportProperty::OTHER_IV_INFU_DURA_METHOD] = $temp_other_infusion->where('local_code', DialpadSupportProperty::OTHER_IV_INFU_DURA_METHOD)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_other_infusions[DialpadSupportProperty::OTHER_IV_INFU_RATE] = $temp_other_infusion->where('local_code', DialpadSupportProperty::OTHER_IV_INFU_RATE)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_other_infusions[DialpadSupportProperty::OTHER_IV_INSTRUCTION] = $temp_other_infusion->where('local_code', DialpadSupportProperty::OTHER_IV_INSTRUCTION)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();

                $temp_other_infusions[DialpadSupportProperty::OTHER_IV_DATE_PRESCRIBED] = $temp_other_infusion->where('local_code', DialpadSupportProperty::OTHER_IV_DATE_PRESCRIBED)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_other_infusions[DialpadSupportProperty::OTHER_IV_TIME_PRESCRIBED] = $temp_other_infusion->where('local_code', DialpadSupportProperty::OTHER_IV_TIME_PRESCRIBED)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_other_infusions[DialpadSupportProperty::OTHER_IV_DATE_STOPPED] = $temp_other_infusion->where('local_code', DialpadSupportProperty::OTHER_IV_DATE_STOPPED)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_other_infusions[DialpadSupportProperty::OTHER_IV_TIME_STOPPED] = $temp_other_infusion->where('local_code', DialpadSupportProperty::OTHER_IV_TIME_STOPPED)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();

                $other_iv_infusion_lists[] = $temp_other_infusions;

            }

        }

        $other_iv_infusion_lists = collect($other_iv_infusion_lists)->unique('other_infusions_pharmacological')
        ->toArray();

        // other iv infusion end
        //  other iv drugs start
        $temp_other_iv_drugs = $temp_other_iv_drugs_solution = null;
        $temp_other_iv_drugs = $prescription->whereIn('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_GROUP);
        $temp_other_iv_drugs_solution = $prescription->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_DAY);

        foreach ($temp_other_iv_drugs_solution as $iv_drug_key => $iv_drug_value)
        {

            $temp_other_iv_drug = null;
            $brand = $temp_other_iv_drugs->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_BARAND)
            ->where('observation_type_id', $iv_drug_value->log_id)
            ->pluck('intf_ref_value')
            ->first();
            if ($brand != '')
            {

                $temp_other_iv_drug[DialpadSupportProperty::OTHER_IV_DRUGS_DAY] = $iv_drug_value->intf_ref_value;
                $temp_other_iv_drug[DialpadSupportProperty::OTHER_IV_DRUGS_BARAND] = $temp_other_iv_drugs->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_BARAND)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_other_iv_drug[DialpadSupportProperty::OTHER_IV_DRUGS_PHARAM] = $temp_other_iv_drugs->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_PHARAM)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_other_iv_drug[DialpadSupportProperty::OTHER_IV_DRUGS_DOSE_REQUIRED] = $temp_other_iv_drugs->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_DOSE_REQUIRED)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_other_iv_drug[DialpadSupportProperty::OTHER_IV_DRUGS_FREQUENCY] = $temp_other_iv_drugs->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_FREQUENCY)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_other_iv_drug[DialpadSupportProperty::OTHER_IV_DRUGS_VOL_DOSE] = $temp_other_iv_drugs->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_VOL_DOSE)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_other_iv_drug[DialpadSupportProperty::OTHER_IV_DRUGS_ADDITIONAL] = $temp_other_iv_drugs->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_ADDITIONAL)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_other_iv_drug[DialpadSupportProperty::OTHER_IV_DRUGS_DATE_PRESCRIBED] = $temp_other_iv_drugs->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_DATE_PRESCRIBED)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_other_iv_drug[DialpadSupportProperty::OTHER_IV_DRUGS_TIME_PRESCRIBED] = $temp_other_iv_drugs->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_TIME_PRESCRIBED)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_other_iv_drug[DialpadSupportProperty::OTHER_IV_DRUGS_DATE_STOPPED] = $temp_other_iv_drugs->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_DATE_STOPPED)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_other_iv_drug[DialpadSupportProperty::OTHER_IV_DRUGS_TIME_STOPPED] = $temp_other_iv_drugs->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_TIME_STOPPED)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();

                $other_iv_drugs_list[] = $temp_other_iv_drug;

            }

        }
        $other_iv_drugs_list = collect($other_iv_drugs_list)->unique('other_iv_drugs_brandname')
        ->toArray();

        // other iv drugs end
        //oral drugs start
        $temp_iv_drug = $temp_iv_drug_solution = null;
        $temp_iv_drug = $prescription->whereIn('local_code', DialpadSupportProperty::ORALDRUG_GROUP);
        $temp_iv_drug_solution = $prescription->where('local_code', DialpadSupportProperty::ORALDRUG_DAY);

        foreach ($temp_iv_drug_solution as $iv_drug_key => $iv_drug_value)
        {

            $temp_infusions = null;
            $brand = $temp_iv_drug->where('local_code', DialpadSupportProperty::ORALDRUG_BRANDNAME)
            ->where('observation_type_id', $iv_drug_value->log_id)
            ->pluck('intf_ref_value')
            ->first();
            if ($brand != '')
            {

                $temp_infusions[DialpadSupportProperty::ORALDRUG_DAY] = $iv_drug_value->intf_ref_value;
                $temp_infusions[DialpadSupportProperty::ORALDRUG_BRANDNAME] = $temp_iv_drug->where('local_code', DialpadSupportProperty::ORALDRUG_BRANDNAME)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::ORALDRUG_GENERICNAME] = $temp_iv_drug->where('local_code', DialpadSupportProperty::ORALDRUG_GENERICNAME)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::ORALDRUG_DOSE] = $temp_iv_drug->where('local_code', DialpadSupportProperty::ORALDRUG_DOSE)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::ORALDRUG_FREQUENCY] = $temp_iv_drug->where('local_code', DialpadSupportProperty::ORALDRUG_FREQUENCY)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::ORALDRUG_ROUTE] = $temp_iv_drug->where('local_code', DialpadSupportProperty::ORALDRUG_ROUTE)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::ORALDRUG_ADDITIONAL] = $temp_iv_drug->where('local_code', DialpadSupportProperty::ORALDRUG_ADDITIONAL)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();

                $temp_infusions[DialpadSupportProperty::ORALDRUG_DATE_PRESCRIBED] = $temp_iv_drug->where('local_code', DialpadSupportProperty::ORALDRUG_DATE_PRESCRIBED)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::ORALDRUG_TIME_PRESCRIBED] = $temp_iv_drug->where('local_code', DialpadSupportProperty::ORALDRUG_TIME_PRESCRIBED)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::ORALDRUG_DATE_STOPPED] = $temp_iv_drug->where('local_code', DialpadSupportProperty::ORALDRUG_DATE_STOPPED)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();
                $temp_infusions[DialpadSupportProperty::ORALDRUG_TIME_STOPPED] = $temp_iv_drug->where('local_code', DialpadSupportProperty::ORALDRUG_TIME_STOPPED)
                ->where('observation_type_id', $iv_drug_value->log_id)
                ->pluck('intf_ref_value')
                ->first();

                $oral_drugs[] = $temp_infusions;

            }
        }

        $oral_drugs = collect($oral_drugs)->unique('oral_brandname')
        ->toArray();
        $temp_iv_drug = $temp_iv_drug_solution = null;
        // oral drugs end
        $drugs_brand_names = DrugIvFluidMaster::where(['is_deleted' => '0', 'status' => 1])->where('type', 'ORAL')->pluck('brand_name', 'id')
        ->toArray();
        $drugs_generic_name = DrugIvFluidMaster::where(['is_deleted' => '0', 'status' => 1])->where('type', 'ORAL')->pluck('generic_pharmacological_name', 'id')
        ->toArray();
        $ivfluids_gen = DrugIvFluidMaster::where(['is_deleted' => '0', 'status' => 1])->where('type', '<>', 'ORAL')->pluck('generic_pharmacological_name', 'id')
        ->toArray();
        $ivfluids = DrugIvFluidMaster::where(['is_deleted' => '0', 'status' => 1])->where('type', '<>', 'ORAL')->pluck('brand_name', 'id')
        ->toArray();

        $closewinlink = url()->previous();
        return view('nurse_sheet.prescription_print', compact('iv_drugs_infusion', 'corrected_gestation', 'ivfluids', 'ivfluids_gen', 'other_iv_drugs_list', 'other_iv_infusion_lists', 'special_fluids_list', 'prescription_date', 'closewinlink', 'baby', 'ip_numbers', 'iv_drugs_list_other', 'oral_drugs', 'master_drugs', 'drugs_brand_names', 'drugs_generic_name'));
    }

    public function addmultiplelist($emr_log_head_id, $input_value, $result, $observation_type_id = 0)
    {
        $result = collect($result)->toArray();
        $sub_sheet_values["log_hdr_id"] = $emr_log_head_id;
        $sub_sheet_values["loinc_local_map_id"] = $result['ref_loc_master_id'];
        $sub_sheet_values["loinc_code"] = $result['loinc_code'];
        $sub_sheet_values["loinc_version"] = $result['loinc_version'];
        $sub_sheet_values["intf_ref_name"] = 'None';
        $sub_sheet_values["intf_ref_value"] = $input_value;
        $sub_sheet_values["mean"] = $input_value;
        $sub_sheet_values["original_intf_ref_value"] = $input_value;
        $sub_sheet_values["component"] = $result['component'];
        $sub_sheet_values["property"] = $result['property'];
        $sub_sheet_values["time"] = Carbon::now($this->time_zone)->format('H:i:s');
        $sub_sheet_values["system"] = $result["system"];
        $sub_sheet_values["scale"] = $result["scale_typ"];
        $sub_sheet_values["method"] = $result["method_typ"];
        $sub_sheet_values["classtype"] = $result["classtype"];
        $sub_sheet_values["active_flag"] = $result["active_flag"];
        $sub_sheet_values["create_user_id"] = $this->auth->user()->id;
        $sub_sheet_values["create_tstamp"] = date('Y-m-d H:i:s', time());
        $sub_sheet_values["modify_user_id"] = $this->auth->user()->id;
        $sub_sheet_values["modify_tstamp"] = date('Y-m-d H:i:s', time());
        $sub_sheet_values['observation_type_id'] = $observation_type_id;
        $emr_log_id = EmrLogDetails::create($sub_sheet_values)->id;
        return $emr_log_id;

    }

    public function addmultiple_replacement($emr_log_head_id, $input_value, $value_name, $observation_type_id = 0)
    {
        $sub_sheet_values["local_code"] = $value_name;
        $sub_sheet_values["value"] = $input_value;
        $sub_sheet_values["log_header_id"] = $emr_log_head_id;
        $sub_sheet_values["observe_id"] = $observation_type_id;
        $check_hour_wise_sheet = NurseHourSheet::where('local_code', $value_name)->where('log_header_id', $emr_log_head_id)->first();
        if (count($check_hour_wise_sheet) == 0 || $value_name == 'replacement_fluids_solution' || $value_name == 'replacement_fluids_rate' || $value_name == 'replacement_fluids_total') {

            $emr_log_id = NurseHourSheet::create($sub_sheet_values)->id;
        }
        else
        {
            NurseHourSheet::where('id', $check_hour_wise_sheet->id)->update($sub_sheet_values);
            $emr_log_id = $check_hour_wise_sheet->id;
        }
        return $emr_log_id;

    }

    public function addemrlog($id, $baby_details, $sender_time, $input, $admission_id, $added_nurse = null)
    {
        $main_sheet['sender'] = env('APP_NAME');
        $main_sheet['gender'] = $baby_details->Sex;
        $main_sheet['sender_time'] = date('Y-m-d H:i:s', strtotime($sender_time));
        $main_sheet['visit_date'] = date('Y-m-d H:i:s', strtotime($input['sheet_date']));
        $main_sheet['loinc_version'] = 2.63;
        $main_sheet['active_flag'] = 'Y';
        $main_sheet['create_user_id'] = \Auth::user()->id;
        $main_sheet['create_tstamp'] = Carbon::now($this->time_zone);
        $main_sheet['modify_user_id'] = \Auth::user()->id;
        $main_sheet['modify_tstamp'] = Carbon::now($this->time_zone);
        $main_sheet['day_id'] = isset($id) ? $id : null;
        $main_sheet['baby_id'] = isset($input['BabyId']) ? $input['BabyId'] : null;
        $main_sheet['mother_id'] = isset($baby_details->MotherId) ? $baby_details->MotherId : null;
        $main_sheet['admission_id'] = isset($admission_id) ? $admission_id : null;
        $main_sheet['added_nurse'] = $added_nurse;
        $emr_log_head_id = EmrLogHeader::create($main_sheet)->id;
        return $emr_log_head_id;
    }

    /**
     * This Method to get IP Admission List
     *
     * @param $baby_id type integer
     * @return admission list type json
     */
    public function getipadmissionid($baby_id)
    {

        $baby_id = \SiteHelpers::decrypt_id($baby_id);
        $baby = Baby::daycare_eposide_list($baby_id);

        $babies = array(
            '0' => '-- Select Admission --'
        );
        foreach ($baby as $babyvalue)
        {
            $babies[\SiteHelpers::encrypt_id($babyvalue->AdmissionId . '-' . $babyvalue->BabyId) ] = $babyvalue->episodes;
        }
        return \Response::json(['data' => $babies], 200);

    }

    /**
     * This method to get the iv drugs
     *
     * @param $infusion_id type integer
     * @param $result type array of object
     * @param $local_code_value type strings
     * @param $type type integer
     * @return array
     */
    public function getivdrugs($infusion_id, $result, $local_code_value, $type = 1)
    {
        $infusion = collect($result)->where('observation_type_id', $infusion_id)->where('local_code', $local_code_value)->first();
        switch ($type)
        {
            case '1':
            $iv[$infusion['id']][DialpadSupportProperty::INFUSION_ID] = $infusion[DialpadSupportProperty::ID];
            $iv[$infusion['id']][DialpadSupportProperty::INFUSION_NAME] = $infusion[DialpadSupportProperty::LOCAL_CODE];
            $iv[$infusion['id']][DialpadSupportProperty::INFUSION_VAlUE] = $infusion[DialpadSupportProperty::INTF_REF_VALUE];
            break;
            case '2':
            $iv[$infusion['id']][DialpadSupportProperty::SPEICAL_ID] = $infusion[DialpadSupportProperty::ID];
            $iv[$infusion['id']][DialpadSupportProperty::SPEICAL_NAME] = $infusion[DialpadSupportProperty::LOCAL_CODE];
            $iv[$infusion['id']][DialpadSupportProperty::SPEICAL_VAlUE] = $infusion[DialpadSupportProperty::INTF_REF_VALUE];

            break;
            case '3':
            $iv[$infusion['id']][DialpadSupportProperty::OTHER_INFUTION_ID] = $infusion[DialpadSupportProperty::ID];
            $iv[$infusion['id']][DialpadSupportProperty::OTHER_INFUTION_NAME] = $infusion[DialpadSupportProperty::LOCAL_CODE];
            $iv[$infusion['id']][DialpadSupportProperty::OTHER_INFUTION_VAlUE] = $infusion[DialpadSupportProperty::INTF_REF_VALUE];
            break;

            case '4':
            $iv[$infusion['id']][DialpadSupportProperty::OTHER_IV_ID] = $infusion[DialpadSupportProperty::ID];
            $iv[$infusion['id']][DialpadSupportProperty::OTHER_IV_NAME] = $infusion[DialpadSupportProperty::LOCAL_CODE];
            $iv[$infusion['id']][DialpadSupportProperty::OTHER_IV_VAlUE] = $infusion[DialpadSupportProperty::INTF_REF_VALUE];
            break;
            case '5':
            $iv[$infusion['id']][DialpadSupportProperty::ORALDRUG_ID] = $infusion[DialpadSupportProperty::ID];
            $iv[$infusion['id']][DialpadSupportProperty::ORALDRUG_NAME] = $infusion[DialpadSupportProperty::LOCAL_CODE];
            $iv[$infusion['id']][DialpadSupportProperty::ORALDRUG_VAlUE] = $infusion[DialpadSupportProperty::INTF_REF_VALUE];
            break;

        }

        return $iv;
    }

    /**
     * This method to get the previous day ivfluids
     *
     * @param $baby_id type integer
     * @param $admission_id type integer
     * @param $previous_day type array of object of previous day data
     *
     * @return type array with previous day iv fluids
     */

    public function getPreviousIvfluids($baby_id, $admission_id, $previous_date, $current_date)
    {
        $emr_dtl = \DB::table('emr_log_hdr')
        ->select('emr_log_dtl.*', 'local_code_group.*', 'emr_log_dtl.id as log_id', \DB::raw('(CASE WHEN char_length(observation_type_id::text) > 0 AND observation_type_id != 0 THEN observation_type_id ELSE emr_log_dtl.id END) AS observation_type_id_copy'), 'local_code_group.local_code as code')
        ->join('nurse_main_sheet', 'emr_log_hdr.day_id', 'nurse_main_sheet.id')
        ->join('emr_log_dtl', 'emr_log_hdr.id', 'emr_log_dtl.log_hdr_id')
        ->join('local_code_group', 'emr_log_dtl.loinc_local_map_id', 'local_code_group.id')
        ->where('emr_log_hdr.baby_id', $baby_id)
        ->where('emr_log_hdr.admission_id', $admission_id)
        ->whereIn('local_code_group.local_code', [DialpadSupportProperty::DRUG_FLUIDS_SOLUTION])
        ->orWhere('sheet_date', $previous_date)
        ->orWhere('sheet_date', $current_date)
        ->get()
        ->groupBy(['observation_type_id_copy', 'code']);
        $iv_fluids_previous = [];
        foreach ($emr_dtl as $old_drug_key => $old_drug_value)
        {

            $temp_iv_fluids = null;
            $temp_iv_fluids[DialpadSupportProperty::DRUG_FLUIDS_SOLUTION] = isset($old_drug_value[DialpadSupportProperty::DRUG_FLUIDS_SOLUTION][0]->intf_ref_value) ? $old_drug_value[DialpadSupportProperty::DRUG_FLUIDS_SOLUTION][0]->intf_ref_value : null;
            $temp_iv_fluids[DialpadSupportProperty::DRUG_FLUIDS_SOLUTION.'_id'] = isset($old_drug_value[DialpadSupportProperty::DRUG_FLUIDS_SOLUTION][0]->log_id) ? $old_drug_value[DialpadSupportProperty::DRUG_FLUIDS_SOLUTION][0]->log_id : null;
            $temp_iv_fluids[DialpadSupportProperty::DRUG_FLUIDS_RATE] = isset($old_drug_value[DialpadSupportProperty::DRUG_FLUIDS_RATE][0]->intf_ref_value) ? $old_drug_value[DialpadSupportProperty::DRUG_FLUIDS_RATE][0]->intf_ref_value : null;
            $temp_iv_fluids[DialpadSupportProperty::DRUG_FLUIDS_RATE.'_id'] = isset($old_drug_value[DialpadSupportProperty::DRUG_FLUIDS_RATE][0]->log_id) ? $old_drug_value[DialpadSupportProperty::DRUG_FLUIDS_RATE][0]->log_id : null;
            $temp_iv_fluids[DialpadSupportProperty::DRUG_FLUIDS_TOTAL] = isset($old_drug_value[DialpadSupportProperty::DRUG_FLUIDS_TOTAL][0]->intf_ref_value) ? $old_drug_value[DialpadSupportProperty::DRUG_FLUIDS_TOTAL][0]->intf_ref_value : null;
            $temp_iv_fluids[DialpadSupportProperty::DRUG_FLUIDS_TOTAL.'_id'] = isset($old_drug_value[DialpadSupportProperty::DRUG_FLUIDS_TOTAL][0]->log_id) ? $old_drug_value[DialpadSupportProperty::DRUG_FLUIDS_TOTAL][0]->log_id : null;
            $temp_iv_fluids['log_hdr_id'] =  isset($old_drug_value[DialpadSupportProperty::DRUG_FLUIDS_SOLUTION][0]->log_hdr_id) ? $old_drug_value[DialpadSupportProperty::DRUG_FLUIDS_SOLUTION][0]->log_hdr_id : null;

            $iv_fluids_previous[] = $temp_iv_fluids;
        }

        return $iv_fluids_previous;
    }

    public function getUpdateToDateFluids($baby_id, $admission_id, $start_time, $end_time)
    {

        $patient_status = DischargeLog::getDischargeDetail($baby_id, $admission_id);

        $prescription_hdr = 'prescription_hdr';
        $prescription_dtl   = 'prescription_dtl';
        $prescription_table = 'prescription';

        if (count($patient_status) > 0) {
            $prescription_table = 'prescription_discharged';
            $prescription_dtl = 'prescription_dtl_discharged';
        } 

        $prescribed_drug_list = \DB::table($prescription_hdr)
        ->select($prescription_hdr.'.brand_name as drug_id', $prescription_table.'.result_time', $prescription_table.'.infused', 
            $prescription_table.'.rate', $prescription_table.'.id as pres_pump_id', $prescription_dtl.'.prescription_id', 'original_infused', $prescription_dtl.'.started_date')
        ->selectRaw($prescription_hdr.'.brand_name|| \':\' ||'.$prescription_table.'.prescription_id as drug_name')
        ->leftjoin($prescription_dtl, $prescription_dtl.".pres_hdr_id", $prescription_hdr.'.id')
        ->leftjoin('baby_admission', 'baby_admission.BabyId', $prescription_hdr.'.baby_id')
        ->leftjoin('mas_drugivfluid', 'mas_drugivfluid.id', $prescription_hdr.'.brand_name')
        ->leftjoin($prescription_table, function ($join) use ($prescription_dtl, $prescription_table, $start_time, $end_time) {
            $join->orOn($prescription_dtl.'.prescription_id', '=', $prescription_table.'.prescription_id');
        })
        ->where('baby_admission.BabyId', $baby_id)
        ->where('baby_admission.AdmissionId', $admission_id)
        // ->where('is_cancel', false)
        // ->where('is_send', '<>', 3)
        // ->where('is_send', '<>', 99)
        ->where('order_status', '<>', 'RS')
        ->where('order_status', '<>', 'EP')
        ->where(function($query) use ($prescription_dtl, $start_time, $end_time) {
            $query->where($prescription_dtl.'.started_date', '>=', $start_time->format('Y-m-d H:i:s'))
            ->orWhere($prescription_dtl.'.started_date', '<', $end_time->format('Y-m-d H:i:s'));
        })
        ->where($prescription_table.'.result_time', '>=', $start_time->format('Y-m-d H:i:s'))
        ->where($prescription_table.'.result_time', '<', $end_time->format('Y-m-d H:i:s'))
        ->orderBy($prescription_table.'.result_time', 'asc')
        ->orderBy($prescription_dtl.'.started_date', 'asc')
        ->get()
        ->groupBy(['drug_name', function($date) {
            if ($date->result_time == '') {
                return Carbon::parse($date->started_date)->format('d:H:00');
            } else {
                return Carbon::parse($date->result_time)->format('d:H:00');
            }
        }
    ])
        ->toArray();  

        $prescription_fluid = array();

        $temp_drug_list = [];
        foreach ($prescribed_drug_list as $prescribed_key => $prescribed_value) {
            $temp_count = 1;
            $collect_count = count($prescribed_value);
            $drug_total = 0;
            $drug_id = explode(':', $prescribed_key)[0];

            if (in_array($drug_id, $temp_drug_list)) {
                foreach ($prescribed_value as $key => $value) {
                    $first_value = $value[0];
                    if ($collect_count == $temp_count) {
                        $last_value = $value[count($value) - 1];
                    } else {
                        $last = next($prescribed_value);
                        $last_value = $last[0];
                    }

                    $drug_total = $last_value->infused - $first_value->infused;

                    $old_drug_dtl = array_search($last_value->drug_id, $temp_drug_list);
                    $old_drug_dtl = $prescription_fluid[$old_drug_dtl];
                    $old_drug_total = $old_drug_dtl['drug_total'];

                    $last_value->drug_total = $old_drug_total + $drug_total;

                    $last_value->drug_name = $old_drug_dtl['drug_name'];

                    $prescription_fluid[$last_value->drug_name] = (array)$last_value;

                    $temp_count++;
                } 
            } else {
                foreach ($prescribed_value as $key => $value) {

                    $first_value = $value[0];
                    if ($collect_count == $temp_count) {
                        $last_value = $value[count($value) - 1];
                    } else {
                        $last = next($prescribed_value);
                        $last_value = $last[0];
                    }

                    $drug_total += $last_value->infused - $first_value->infused;

                    $last_value->drug_total = $drug_total;
                    $temp_drug_list[$last_value->drug_name] = $last_value->drug_id;

                    $prescription_fluid[$last_value->drug_name] = (array)$last_value;

                    $temp_count++;
                } 

            }

        }

        return $prescription_fluid;
    }

    /**
     * This method to get the previous day ivfluids
     *
     * @param $baby_id type integer
     * @param $admission_id type integer
     * @param $previous_day type array of object of previous day data
     *
     * @return type array with previous day iv fluids
     */

    public function getPreviousReplacementfluids($baby_id, $admission_id, $previous_day)
    {
        $replacement_previous_fluids = null;

        if (count($previous_day) > 0)
        {

            $old_drug = NurseHourSheet::Getpreviousdata($previous_day->id, DialpadSupportProperty::REPLACMENT_FLUIDS);
            $old_drug_solution = $old_drug->where('local_code', DialpadSupportProperty::REPLACMENT_FLUIDS_SOLUTION);

            foreach ($old_drug_solution as $old_drug_key => $old_drug_value)
            {
                $temp_replacement_fluids = null;
                $temp_replacement_fluids[DialpadSupportProperty::REPLACMENT_FLUIDS_SOLUTION] = $old_drug_value->value;
                $temp_replacement_fluids[DialpadSupportProperty::REPLACMENT_FLUIDS_RATE] = $old_drug->where('observe_id', $old_drug_value->id)
                ->where('local_code', DialpadSupportProperty::REPLACMENT_FLUIDS_RATE)
                ->pluck('value')
                ->first();
                $temp_replacement_fluids[DialpadSupportProperty::REPLACMENT_FLUIDS_TOTAL] = $old_drug->where('observe_id', $old_drug_value->id)
                ->where('local_code', DialpadSupportProperty::REPLACMENT_FLUIDS_TOTAL)
                ->pluck('value')
                ->first();
                $replacement_previous_fluids[] = $temp_replacement_fluids;
            }
        }
        return $replacement_previous_fluids;

    }

    /**
     * This method to get the previous day ivfluids
     *
     * @param $baby_id type integer
     * @param $admission_id type integer
     * @param $previous_day type array of object of previous day data
     *
     * @return type array with previous day iv fluids
     */

    public function getPreviousantibiotic($baby_id, $admission_id, $previous_day)
    {
        $antibiotic_previous = null;

        if (count($previous_day) > 0)
        {

            $old_antibiotic = EmrLogDetails::Getpreviousdata($previous_day->id, DialpadSupportProperty::A_ANTIBIOTIC_GROUP);

            $old_antibiotic_solution = $old_antibiotic->where('local_code', DialpadSupportProperty::A_ANTIBIOTIC);

            foreach ($old_antibiotic_solution as $old_antibiotic_key => $old_antibiotic_value)
            {
                $temp_antibiotic_fluids = null;
                $temp_antibiotic_fluids[DialpadSupportProperty::A_ANTIBIOTIC] = $old_antibiotic_value->intf_ref_value;
                $temp_antibiotic_fluids[DialpadSupportProperty::A_DAY] = $old_antibiotic->where('observation_type_id', $old_antibiotic_value->log_id)
                ->where('local_code', DialpadSupportProperty::A_DAY)
                ->pluck('intf_ref_value')
                ->first();
                $antibiotic_previous[] = $temp_antibiotic_fluids;
            }
        }

        return $antibiotic_previous;

    }

    /**
     * This method to get the previous day ivfluids
     *
     * @param $baby_id type integer
     * @param $admission_id type integer
     * @param $previous_day type array of object of previous day data
     *
     * @return type array with previous day iv fluids
     */
    public function getOtherdrugs($baby_id, $admission_id, $previous_day)
    {
        $other_drugs_previous = null;

        if (count($previous_day) > 0)
        {

            $old_drugs_solution = EmrLogDetails::Getpreviousdata($previous_day->id, [DialpadSupportProperty::OTHER_DRUGS]);

            foreach ($old_drugs_solution as $old_drugs_key => $old_drugs_value)
            {
                $temp_drugs_fluids = null;
                $temp_drugs_fluids[DialpadSupportProperty::OTHER_DRUGS] = $old_drugs_value->intf_ref_value;
                $other_drugs_previous[] = $temp_drugs_fluids;
            }
        }

        return $other_drugs_previous;

    }

    /**
     * This method to get the previous day ivfluids
     *
     * @param $baby_id type integer
     * @param $admission_id type integer
     * @param $previous_day type array of object of previous day data
     *
     * @return type array with previous day iv fluids
     */
    public function getivdrugsinfusion($baby_id, $admission_id, $previous_day)
    {
        $iv_fluids_infusion = null;

        if (count($previous_day) > 0)
        {

            $old_drug = EmrLogDetails::Getpreviousdata($previous_day->id, DialpadSupportProperty::INFUSION_GROUP);

            $old_drug_solution = $old_drug->where('local_code', DialpadSupportProperty::INFUSION_DAY);

            foreach ($old_drug_solution as $old_drug_key => $old_drug_value)
            {
                $temp_iv_fluids = null;
                $temp_iv_fluids[DialpadSupportProperty::INFUSION_DAY] = $old_drug_value->intf_ref_value;
                $temp_iv_fluids[DialpadSupportProperty::INFUSION_BRANDNAME] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::INFUSION_BRANDNAME)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::INFUSION_PHARMACOLOGICAL] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::INFUSION_PHARMACOLOGICAL)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::INFUSION_DOSE] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::INFUSION_DOSE)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::INFUSION_DOSE_UNITS] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::INFUSION_DOSE_UNITS)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::INFUSION_QUANTITY] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::INFUSION_QUANTITY)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::INFUSION_QUANTITY_UNITS] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::INFUSION_QUANTITY_UNITS)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::INFUSION_SYRINGE] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::INFUSION_SYRINGE)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::INFUSION_RATE] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::INFUSION_RATE)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::INFUSION_INSTRUCTION] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::INFUSION_INSTRUCTION)
                ->pluck('intf_ref_value')
                ->first();

                $temp_iv_fluids[DialpadSupportProperty::INFUSION_DATE_PRESCRIBED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::INFUSION_DATE_PRESCRIBED)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::INFUSION_TIME_PRESCRIBED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::INFUSION_TIME_PRESCRIBED)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::INFUSION_DATE_STOPPED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::INFUSION_DATE_STOPPED)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::INFUSION_TIME_STOPPED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::INFUSION_TIME_STOPPED)
                ->pluck('intf_ref_value')
                ->first();

                $iv_fluids_infusion[] = $temp_iv_fluids;
            }
        }
        return $iv_fluids_infusion;

    }

    /**
     * This method to get the previous day ivfluids
     *
     * @param $baby_id type integer
     * @param $admission_id type integer
     * @param $previous_day type array of object of previous day data
     *
     * @return type array with previous day iv fluids
     */
    public function getivspecialfluids($baby_id, $admission_id, $previous_day)
    {
        $iv_drugs = null;

        if (count($previous_day) > 0)
        {

            $old_drug = EmrLogDetails::Getpreviousdata($previous_day->id, DialpadSupportProperty::SPEICAL_IV_GROUP);

            $old_drug_solution = $old_drug->where('local_code', DialpadSupportProperty::SPEICAL_IV_DAY);

            foreach ($old_drug_solution as $old_drug_key => $old_drug_value)
            {
                $temp_iv_fluids = null;
                $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_DAY] = $old_drug_value->intf_ref_value;
                $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_NAME_ONE] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::SPEICAL_IV_NAME_ONE)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_NAME_TWO] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::SPEICAL_IV_NAME_TWO)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_VOL_ONE] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::SPEICAL_IV_VOL_ONE)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_VOL_TWO] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::SPEICAL_IV_VOL_TWO)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_SYRINGE] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::SPEICAL_IV_SYRINGE)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_DEXTROSE] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::SPEICAL_IV_DEXTROSE)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_GLUCOSE] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::SPEICAL_IV_GLUCOSE)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_RATE] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::SPEICAL_IV_RATE)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_INSTRUCTION] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::SPEICAL_IV_INSTRUCTION)
                ->pluck('intf_ref_value')
                ->first();

                $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_DATE_PRESCRIBED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::SPEICAL_IV_DATE_PRESCRIBED)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_TIME_PRESCRIBED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::SPEICAL_IV_TIME_PRESCRIBED)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_DATE_STOPPED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::SPEICAL_IV_DATE_STOPPED)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::SPEICAL_IV_TIME_STOPPED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::SPEICAL_IV_TIME_STOPPED)
                ->pluck('intf_ref_value')
                ->first();

                $iv_drugs[] = $temp_iv_fluids;
            }
        }

        return $iv_drugs;

    }

    /**
     * This method to get the previous day other iv infusions
     *
     * @param $baby_id type integer
     * @param $admission_id type integer
     * @param $previous_day type array of object of previous day data
     *
     * @return type array with previous day iv fluids
     */
    public function getotherivinfusion($baby_id, $admission_id, $previous_day)
    {
        $iv_drugs = null;

        if (count($previous_day) > 0)
        {

            $old_drug = EmrLogDetails::Getpreviousdata($previous_day->id, DialpadSupportProperty::OTHER_INFUTION_GROUP);

            $old_drug_solution = $old_drug->where('local_code', DialpadSupportProperty::OTHER_IV_INFU_DAY);

            foreach ($old_drug_solution as $old_drug_key => $old_drug_value)
            {
                $temp_iv_fluids = null;
                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_INFU_DAY] = $old_drug_value->intf_ref_value;
                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_INFU_PHARAM] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::OTHER_IV_INFU_PHARAM)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_INFU_VOL] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::OTHER_IV_INFU_VOL)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_INFU_DURATION] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::OTHER_IV_INFU_DURATION)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_INFU_DURA_METHOD] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::OTHER_IV_INFU_DURA_METHOD)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_INFU_RATE] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::OTHER_IV_INFU_RATE)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_INSTRUCTION] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::OTHER_IV_INSTRUCTION)
                ->pluck('intf_ref_value')
                ->first();

                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DATE_PRESCRIBED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::OTHER_IV_DATE_PRESCRIBED)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_TIME_PRESCRIBED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::OTHER_IV_TIME_PRESCRIBED)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DATE_STOPPED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::OTHER_IV_DATE_STOPPED)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_TIME_STOPPED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::OTHER_IV_TIME_STOPPED)
                ->pluck('intf_ref_value')
                ->first();

                $iv_drugs[] = $temp_iv_fluids;
            }
        }

        return $iv_drugs;

    }

    /**
     * This method to get the previous day other iv drugs
     *
     * @param $baby_id type integer
     * @param $admission_id type integer
     * @param $previous_day type array of object of previous day data
     *
     * @return type array with previous day iv fluids
     */
    public function getotherivdrugs($baby_id, $admission_id, $previous_day)
    {
        $iv_drugs = null;

        if (count($previous_day) > 0)
        {

            $old_drug = EmrLogDetails::Getpreviousdata($previous_day->id, DialpadSupportProperty::OTHER_IV_DRUGS_GROUP);

            $old_drug_solution = $old_drug->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_DAY);

            foreach ($old_drug_solution as $old_drug_key => $old_drug_value)
            {
                $temp_iv_fluids = null;
                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_DAY] = $old_drug_value->intf_ref_value;
                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_BARAND] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_BARAND)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_PHARAM] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_PHARAM)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_DOSE_REQUIRED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_DOSE_REQUIRED)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_FREQUENCY] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_FREQUENCY)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_VOL_DOSE] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_VOL_DOSE)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_ADDITIONAL] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_ADDITIONAL)
                ->pluck('intf_ref_value')
                ->first();

                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_DATE_PRESCRIBED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_DATE_PRESCRIBED)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_TIME_PRESCRIBED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_TIME_PRESCRIBED)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_DATE_STOPPED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_DATE_STOPPED)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::OTHER_IV_DRUGS_TIME_STOPPED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::OTHER_IV_DRUGS_TIME_STOPPED)
                ->pluck('intf_ref_value')
                ->first();

                $iv_drugs[] = $temp_iv_fluids;
            }
        }

        return $iv_drugs;

    }

    /**
     * This method to get the previous day ivfluids
     *
     * @param $baby_id type integer
     * @param $admission_id type integer
     * @param $previous_day type array of object of previous day data
     *
     * @return type array with previous day iv fluids
     */
    public function getoraldrugs($baby_id, $admission_id, $previous_day)
    {
        $oral_drugs = null;

        if (count($previous_day) > 0)
        {

            $old_drug = EmrLogDetails::Getpreviousdata($previous_day->id, DialpadSupportProperty::ORALDRUG_GROUP);

            $old_drug_solution = $old_drug->where('local_code', DialpadSupportProperty::ORALDRUG_DAY);

            foreach ($old_drug_solution as $old_drug_key => $old_drug_value)
            {
                $temp_iv_fluids = null;
                $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_DAY] = $old_drug_value->intf_ref_value;
                $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_BRANDNAME] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::ORALDRUG_BRANDNAME)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_GENERICNAME] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::ORALDRUG_GENERICNAME)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_DOSE] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::ORALDRUG_DOSE)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_FREQUENCY] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::ORALDRUG_FREQUENCY)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_ROUTE] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::ORALDRUG_ROUTE)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_ADDITIONAL] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::ORALDRUG_ADDITIONAL)
                ->pluck('intf_ref_value')
                ->first();

                $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_DATE_PRESCRIBED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::ORALDRUG_DATE_PRESCRIBED)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_TIME_PRESCRIBED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::ORALDRUG_TIME_PRESCRIBED)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_DATE_STOPPED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::ORALDRUG_DATE_STOPPED)
                ->pluck('intf_ref_value')
                ->first();
                $temp_iv_fluids[DialpadSupportProperty::ORALDRUG_TIME_STOPPED] = $old_drug->where('observation_type_id', $old_drug_value->log_id)
                ->where('local_code', DialpadSupportProperty::ORALDRUG_TIME_STOPPED)
                ->pluck('intf_ref_value')
                ->first();

                $oral_drugs[] = $temp_iv_fluids;
            }
        }

        return $oral_drugs;

    }

    /**
     * This method to get running total of the fluids
     *
     * @param $baby_id type integer
     * @param $admission_id type integer
     * @param $date type date
     * @param $time
     * @param $fluidsids
     */
    public function calculaterunningtotal(Request $request)
    {
        $input = $request->all();

        $nurse = NurseSheetMain::GetNurseSheet($input['sheetDate'], $input['babyId'], $input['admissionId']);

        $drug_name = str_replace('[]', '', $input['drugName']);

        if (count($nurse) == 0)
        {
            return \Response::json(['total' => $input['drugRate']], 200);
        }

        switch ($drug_name)
        {
            case 'drug_solution':
            $log_dtl = NurseSheetMain::getrunningfluids($nurse->id, $drug_name, $input['drugId'])->pluck('id')
            ->toArray();
            $rate = NurseSheetMain::getfluidsrate($log_dtl, 'drug_rate')->pluck('intf_ref_value')
            ->toArray();
            break;
            case 'replacement_fluids_solution':
            $log_dtl = NurseSheetMain::getreplacementrunningfluids($nurse->id, $drug_name, $input['drugId'])->pluck('id')
            ->toArray();
            $rate = NurseSheetMain::getreplacementfluidsrate($log_dtl, 'replacement_fluids_rate')->pluck('value')
            ->toArray();
            break;
            default:
            $rate = NurseSheetMain::getrunningoutput($nurse->id, $drug_name)->pluck('intf_ref_value')
            ->toArray();
            break;
        }

        $total = 0;

        if ($drug_name != 'bowels')
        {
            foreach ($rate as $rate_value)
            {
                if ($rate_value != '' && is_numeric($rate_value))
                {
                    $total = $total + $rate_value;
                }
            }
            $input['drugRate'] = ($input['drugRate'] != '') ? $input['drugRate'] : 0;
            if (is_numeric($input['drugRate'])) {
                $total = $total + $input['drugRate'];
            }

        }
        elseif ($drug_name == 'bowels')
        {
            foreach ($rate as $rate_value)
            {
                if ($rate_value != '' && $rate_value == 'on')
                {
                    $total = $total + 1;
                }
            }

            $input['drugRate'] = ($input['drugRate'] == 'true') ? 1 : 0;

            $total = $total + $input['drugRate'];

        }

        return \Response::json(['total' => $total], 200);
    }

    /**
     * This method to get running total of the fluids
     *
     * @param $baby_id type integer
     * @param $admission_id type integer
     * @param $date type date
     * @param $time
     * @param $fluidsids
     */

    public function getsporturinetotal(Request $request)
    {
        $input = $request->all();
        $nurse = NurseSheetMain::getspoturineoutput($input['sheetDate'], $input['babyId'], $input['admissionId'], 'urine_output');
        $input['timeHour'] = strlen($input['timeHour']) > 1 ? $input['timeHour'] : '0' . $input['timeHour'];
        $input['timeMiniuts'] = strlen($input['timeMiniuts']) > 1 ? $input['timeMiniuts'] : '0' . $input['timeMiniuts'];
        $time_sheet = $input['sheetDate'] . ' ' . $input['timeHour'] . ':' . $input['timeMiniuts'] . ' ' . $input['timeSession'];

        $time_sheet = date('Y-m-d h:i a', strtotime($time_sheet));
        $site_settings = Settings::get();

        $input_time = date('H', strtotime($time_sheet));
        $nurse_start = date('H', strtotime($site_settings[0]->nurse_entry_start));

        $adjustable_time = Carbon::createFromFormat('h:i a', $site_settings[0]->nurse_entry_start)
        ->subHour(3);
        $adjustable_time = date('H', strtotime($adjustable_time));

        $urine_total = '';
        if ($input_time > $adjustable_time && $input_time < $nurse_start)
        {
            $urine_total = NurseSheetMain::getspoturineoutput($input['sheetDate'], $input['babyId'], $input['admissionId'], 'urine_total');
            if (isset($urine_total->intf_ref_value) && is_numeric($urine_total->intf_ref_value)) {
                $urine_total = $input['currentUrine'] + $urine_total->intf_ref_value;
            }
        }

        if (count($nurse) > 0)
        {
            $current_time_sheet_hour = Carbon::createFromFormat('Y-m-d h:i a', $time_sheet);
            $nurse->sender_time = date('Y-m-d h:i a', strtotime($nurse->sender_time));
            $last_time_sheet_hour = Carbon::createFromFormat('Y-m-d h:i a', $nurse->sender_time);
            $differentHours = $current_time_sheet_hour->diffInHours($last_time_sheet_hour);

            if ($differentHours != '' && $differentHours != 0)
            {
                $urine_spot = ($input['currentUrine'] - $nurse->intf_ref_value) / $differentHours;
            }
            else
            {
                if (is_numeric($nurse->intf_ref_value)) {
                    $urine_spot = ($input['currentUrine'] - $nurse->intf_ref_value);
                }
            }
        }
        else
        {
            $urine_spot = '';
        }
        if (is_numeric($urine_spot)) {
            $urine_spot = number_format($urine_spot, 2);
        }

        return \Response::json(['result' => $urine_spot, 'urineTotal' => $urine_total], 200);

    }

    /**
     * Method to print lab report values
     */
    public function labValuePrint(Request $request)
    {
        $input = $request->all();
        $baby_mrn = \SiteHelpers::decrypt_id($input['mrn']);
        $active_admission_id = $input['admission_id'];

        $baby = Baby::get_baby_by_mrn($baby_mrn);
        $baby_id = $baby->BabyId;

        $order = isset($input['order']) ? $input['order'] : '';

        if ($order != '') {
            \DB::table('users')->where('id', \Auth::user()->id)->update(['lab_result_sort_order'=>$order]);
        }

        $user_order = \DB::table('users')->select('lab_result_sort_order')->where('id', \Auth::user()->id)->first();

        if (isset($user_order->lab_result_sort_order) && $user_order->lab_result_sort_order != '') {
            $order = $user_order->lab_result_sort_order;
        } else {
            $order = 'desc';
        }

        $result = $sheet_id = $first_tab_sheet_id = $local_code = $temp = array();
        
        $admission_ids = Admission::where('BabyId', $baby_id)->pluck('AdmissionId');

        $lab_values = [];
        $second_tab_lab_values = [];
        $abg_results = [];

        $abg_test_list = DialpadSupportProperty::ABG_TEST_LIST;

        $lab_data_table_name = 'emr_lab_values';
        $inpatient_admission_id = 0;

        foreach ($admission_ids as $admission_id) {
            $patient_status = DischargeLog::getDischargeDetail($baby_id, $admission_id);
            if (count($patient_status) > 0) {
                $lab_data_table_name = 'emr_lab_values_discharged';
            } else {
                $inpatient_admission_id = $admission_id;
            }
            $temp_lab_values = EmrLogHeader::getLabValuePrint($baby->BabyId, $baby->MotherId, $order, $lab_data_table_name, ['haematology', 'biochemistry'])->toArray();
            if ($lab_data_table_name == 'emr_lab_values_discharged') {
                $temp_lab_inpatient_values = EmrLogHeader::getLabValuePrint($baby->BabyId, $baby->MotherId, $order, 'emr_lab_values', ['haematology', 'biochemistry'])->toArray();
                $lab_values = array_merge($lab_values, $temp_lab_inpatient_values);
            }
            // echo "<pre>"; print_r($temp_lab_values);
            $lab_values = array_merge($lab_values, $temp_lab_values);

            $temp_second_tab_lab_values = EmrLogHeader::getLabValuePrint($baby->BabyId, $baby->MotherId, $order, $lab_data_table_name, ['urine', 'csf', 'stool'])->toArray();
            $second_tab_lab_values = array_merge($second_tab_lab_values, $temp_second_tab_lab_values);

            $temp_abg_results = EmrLogHeader::getInterfacingData($baby->BabyId, $admission_id, $abg_test_list, '', '', $lab_data_table_name, false)->toArray();
            $abg_results = array_merge($abg_results, $temp_abg_results);
        }
        $lab_values = collect($lab_values);
        $second_tab_lab_values = collect($second_tab_lab_values);
        $abg_results = collect($abg_results);
        
        $sheet_id = $lab_values->map(function($item)
        {
            return date('Y-m-d H:i', strtotime($item->result_date_time)).":00";
        })->unique()->toArray();

        $first_tab_sheet_id = $lab_values->sortBy('result_date_time')->pluck('result_date_time', 'lab_number')->toArray();
        if ($order == 'desc') {
            $first_tab_sheet_id = array_flip($first_tab_sheet_id);
            krsort($first_tab_sheet_id);
            $first_tab_sheet_id = array_flip($first_tab_sheet_id);
        }
        $result = $lab_values->groupBy('lab_number')->toArray();
        // echo "<pre>"; print_r($result); exit;
        $material_name = $lab_values->map(function($list)
        {
            return [
                'lab_number'=> $list->lab_number,
                'material_name'=> $list->material_name
            ];
        })->groupBy(['lab_number', 'material_name'])->map(function($value, $index){
            return array_filter(array_keys($value->toArray()));
        })->toArray();
        if (count($material_name) > 0) {
            $material_name = array_filter($material_name);
        }

        $second_tab_sheet_id = $second_tab_lab_values->map(function($item)
        {
            return date('Y-m-d H:i', strtotime($item->result_date_time)).":00";
        })->unique()->toArray();

        $second_tab_result = $second_tab_lab_values->groupBy(function($list)
        {
            return date('Y-m-d H:i', strtotime($list->result_date_time)).":00";
        })->toArray();

        $microbiology_results = \DB::table('emr_microbiology_report')
        ->whereIn('admission_id', $admission_ids)
        ->orderBy('test_name')
        ->orderBy('result_collect_time')
        ->get();

        $microbiology_tests = $microbiology_results->unique('test_name')->pluck('test_name', 'test_name')->map(function($item) {
            $temp_item = str_ireplace('final', '', $item);
            $temp_item = str_ireplace('preliminary', '', $temp_item);
            $temp_item = str_replace('()', '', $temp_item);
            return $temp_item;
        })->toArray();

        $microbiology_results_id = $microbiology_results->pluck('id')->toArray();
        
        $microbiology_results_items = \DB::table('emr_microbiology_report_items')
        ->whereIn('report_id', $microbiology_results_id)
        ->where('display_status', true)
        ->get();

        if ($order == 'desc') {
            $abg_values = $abg_results->sortByDesc('result_date_time')->groupBy(['temp_result_date_time', 'local_code'])->toArray();
        } else {
            $abg_values = $abg_results->sortBy('result_date_time')->groupBy(['temp_result_date_time', 'local_code'])->toArray();            
        }

        $ip_details = IpNumber::getCurrent_ip($baby->BabyId, $inpatient_admission_id);

        $pending_results = array();
        $pending_results_count = 0;
        if (isset($ip_details->ip_number) && trim($ip_details->ip_number) != '') {

            $get_pending_req = \SiteHelpers::getConfigSettings('GET_PENDING_REQ_BILL_FROM_LIS');
            $client = new \GuzzleHttp\Client();
            $response = $client->get($get_pending_req, [
                'query' => ['visit_number' => trim($ip_details->ip_number)],
                'http_errors' => false
            ]);

            $lis_response = $response->getBody();
            $lis_response = $lis_response->getContents();
            $results = json_decode($lis_response);
            $pending_results_count = count($results);
            $pending_results = collect($results)->groupBy('number')->toArray();
        }
        
        $lab_report_observe = DialpadSupportProperty::GLUCO_METER;

        $admission_id = \SiteHelpers::encrypt_id($admission_id);

        if (isset($input['closewinlink']) && $input['closewinlink'] == 'nicu-nurse-sheet-day' && isset($input['closewinlink2'])) {
            $closewinlink = action('Nurse\NurseSheetController@GetDaylist', $admission_id).'/'.$input['closewinlink2'];
        } else if (isset($input['closewinlink']) && $input['closewinlink'] == 'ward-dashboard') {
            $closewinlink = url('ward-dashboard');
        } else {
            $closewinlink = url('lab-baby-select');
        }
        $closewinlink_temp = $input['closewinlink'];
        return view('nurse_sheet.lab_value_print', compact('result', 'sheet_id', 'lab_report_observe', 'order', 'closewinlink', 'baby', 'ip_details', 'microbiology_results_items', 'microbiology_results', 'second_tab_result', 'second_tab_sheet_id', 'microbiology_tests', 'closewinlink_temp', 'first_tab_sheet_id', 'material_name', 'pending_results', 'pending_results_count', 'abg_values', 'abg_test_list', 'active_admission_id'));
    }

    /**
     * This method to get radiology
     *
     */
    public function GetRadiology($id)
    {
        $baby_details = Baby::find($id);
        $baby_mrno = $baby_details->BMrNo;
        return view('nurse_sheet.nicu_radiology', compact('baby_mrno'));
    }

    public function getDrugDetails($baby)
    {
        $prescriptionKey = \SiteHelpers::prescriptionKeyId();
        $nurseIvInfusion = NurseIvInfusion::where('baby_id', $baby->BabyId)
        ->get();

        foreach ($nurseIvInfusion as $nurseIvInfusionkey => $nurseIvInfusionvalue)
        {
            $prescription_id = $prescriptionKey[0] . $nurseIvInfusionvalue->time_id;
            $temp_prescription[$prescription_id] = FhirFormatedValues::where('advice_id', $prescription_id)->get();
            $date_time = $temp_prescription[$prescription_id]->unique('date')
            ->pluck('date');
            foreach ($date_time as $key => $value)
            {
                $prescription[$prescription_id . $value] = FhirFormatedValues::where('advice_id', $prescription_id)->whereIn('snomed_code', ['430033006+410942007', '430033006+260507000+118565006', '430033006+118544000'])
                ->where('date', $value)->get();

            }

        }

    }

    public function getHeroScore(Request $request)
    {
        $limit = 50;

        //set the limit as per the request
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

        //Initialize the record sorting key and order
        $order['sortby'] = 'result_date_time';
        $order['sortorder'] = 'desc';

        //set the records sorting key and order
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder')))
        {
            $order['sortby'] = \SiteHelpers::decrypt_id($request->input('sortby'));
            $order['sortorder'] = $request->input('sortorder');
        }

        $input = $request->all();

        $search['mrn'] = isset($input['mrn']) ? $input['mrn'] : null;
        $search['fromdate'] = isset($input['fromdate']) ? $input['fromdate'] : null;
        $search['todate'] = isset($input['todate']) ? $input['todate'] : null;

        $total = 0;

        // if (!is_null($search['mrn']) && !is_null($search['fromdate']) && !is_null($search['todate'])) {
        if (isset($search['mrn']) && !is_null($search['mrn'])) {
            $result = EmrMoniterValues::getHeroScore($search, $request->input('page') , $limit, $order);

            $results = $result['result'];
            $total = $result['total'];
            $min = $result['min'];
            $max = $result['max'];
            $getTotal = EmrMoniterValues::getTotalHeroScore();
        }


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

        $navigate = $this->navigate;
        return view('nurse_sheet.heroscore', compact('results', 'navigate', 'total', 'pagination', 'search', 'order', 'getTotal', 'min', 'max'));
    }

    public function getDownloadHeroScore($baby_mrn, $baby_name, $baby_id, $min, $max)
    {

        $search['mrn'] = isset($baby_mrn) ? $baby_mrn : null;

        $order['sortby'] = 'result_date_time';
        $order['sortorder'] = 'asc';

        $result = EmrMoniterValues::getHeroScoreForExport($baby_mrn, $baby_name, $baby_id, $min, $max);

        $date_list = collect($result)->pluck('date')->unique()->toArray();

        $results = collect($result)->groupBy([function($reg){
            return date('H',strtotime($reg->time));
        }, 'date'])->toArray();

        $mrn = 'MRN: '. $baby_mrn;
        $babyname = 'Baby Name :'. $baby_name;

        $file_name = $baby_mrn.'_hero';

        Excel::create($file_name,function($excel) use($mrn, $babyname, $results, $file_name, $date_list) {
            $excel->sheet('mysheet', function($sheet) use($mrn, $babyname, $results, $file_name, $date_list) {
                $sheet->loadView('nurse_sheet.hero_score_export', compact('mrn', 'babyname', 'results', 'file_name', 'date_list'));
            });
        })->download('xls');

        return view('nurse_sheet.hero_score_export', compact('mrn', 'babyname', 'results', 'file_name', 'date_list'));
    }
    public function formatMultipleList($manaual_log_head_id, $input_value, $result, $observation_type_id = 0)
    {
        $result = collect($result)->toArray();
        $sub_sheet_values["log_hdr_id"] = $manaual_log_head_id;
        $sub_sheet_values["loinc_local_map_id"] = $result['ref_loc_master_id'];
        $sub_sheet_values["loinc_code"] = $result['loinc_code'];
        $sub_sheet_values["loinc_version"] = $result['loinc_version'];
        $sub_sheet_values["intf_ref_name"] = 'None';
        $sub_sheet_values["intf_ref_value"] = $input_value;
        $sub_sheet_values["mean"] = $input_value;
        $sub_sheet_values["original_intf_ref_value"] = $input_value;
        $sub_sheet_values["component"] = $result['component'];
        $sub_sheet_values["property"] = $result['property'];
        $sub_sheet_values["time"] = Carbon::now($this->time_zone)->format('H:i:s');
        $sub_sheet_values["system"] = $result["system"];
        $sub_sheet_values["scale"] = $result["scale_typ"];
        $sub_sheet_values["method"] = $result["method_typ"];
        $sub_sheet_values["classtype"] = $result["classtype"];
        $sub_sheet_values["active_flag"] = $result["active_flag"];
        $sub_sheet_values["create_user_id"] = $this->auth->user()->id;
        $sub_sheet_values["create_tstamp"] = Carbon::now($this->time_zone);
        $sub_sheet_values["modify_user_id"] = $this->auth->user()->id;
        $sub_sheet_values["modify_tstamp"] = Carbon::now($this->time_zone);
        $sub_sheet_values['observation_type_id'] = $observation_type_id;
        return $sub_sheet_values;

    }

    /**
     * Method to print patient working weight in 7 days
     */
    public static function getWeeklyObservations($admission_id, $admission_date= '', Request $request)
    {
        $input = $request->all();
        $admission_id = \SiteHelpers::decrypt_id($admission_id);
        $baby = Admission::getBabyMrn($admission_id);
        $gestation_days = \SiteHelpers::convert_gestation_days($baby->Gestation);
        $dayoflife = \SiteHelpers::calculate_day_of_life_two($baby->DOB, date('Y-m-d', strtotime($admission_date)));
        $corrected_gestation = \SiteHelpers::calculate_corrected_gestation($gestation_days, $dayoflife);
        $corrected_gestation = \SiteHelpers::decode_gestation(json_encode($corrected_gestation));
        $ip_details = IpNumber::getCurrent_ip($baby->BabyId, $admission_id);
        
        if (isset($input['fromdate']) && isset($input['todate'])) {
            $week_start_date = date('Y-m-d', strtotime($input['fromdate'])).' 00:00:00';
            $end_date = date('Y-m-d', strtotime($input['todate'])).' 23:59:59';
            $week_end_date = date('Y-m-d', strtotime($input['todate']) + 60*60*24).' 23:59:59';
        }
        else
        {
            $get_last_sheet_date = NurseSheetMain::where('admission_id', $admission_id)->orderBy('sheet_date', 'desc')->first();
            if (isset($get_last_sheet_date->sheet_date) && !empty($get_last_sheet_date->sheet_date)) {
                $today = date('d-m-Y', strtotime($get_last_sheet_date->sheet_date));
            }
            else
            {
                $today = date('d-m-Y');
            }
            $date = Carbon::createFromFormat('d-m-Y', $today);
            $week_end_date = $end_date = $date->toDateTimeString();
            $week_end_date = $end_date = date('Y-m-d', strtotime($end_date)).' 23:59:59';
            $week_start_date = $date->subDays(6)->toDateTimeString();
            $week_start_date = date('Y-m-d', strtotime($week_start_date)).' 00:00:00';
        }

        $date_periods = self::createDateRangeArray($week_start_date, $end_date);

        $time_period = Settings::getPeriod()->period;

        $week_details = NurseSheetMain::getAWeekDetails($admission_id, $week_start_date, $week_end_date);

        $current_weight = $week_details->pluck('current_weight', 'sheet_date')->toArray();
        $total_input = $week_details->pluck('total_input', 'sheet_date')->toArray();
        $total_output = $week_details->pluck('total_output', 'sheet_date')->toArray();

        $bowels_status = EmrLogHeader::getBowelsStatus($admission_id, $week_start_date, $week_end_date, 'bowels');
        $bowels_total = EmrLogHeader::getBowelsStatus($admission_id, $week_start_date, $week_end_date, 'bowels_count_total');
        $stools_status = EmrLogHeader::getBowelsStatus($admission_id, $week_start_date, $week_end_date, 'stools_nature');

        $working_weight = null;
        
        $heading_content = $weight_content = $total_input_content = $total_output_content = $bowels_content = $stools_content = $balance_content = $cumulative_balance_content = '';
        if (!isset($today) && empty($today)) {
            $today = date('d-m-Y', strtotime($input['todate']));
        }

        $to_dashboard_chart = [];

        foreach ($date_periods as $date_key => $date_value) {
            $is_selected_date = '';

            $to_dashboard_chart['date'][$date_key] = date('d-m', strtotime($date_value));

            if (date('d-m-Y', strtotime($date_value)) == $today) {
                $is_selected_date = 'current_date';
            }

            $heading_content .= '<th>'.date('d-m-Y', strtotime($date_value)).'</th>';
            if (!isset($total_input[$date_value])) {
                $total_input_content  .= '<td class='.$is_selected_date.'>-</td>';
            }
            else
            {
                $total_input_content  .= '<td class='.$is_selected_date.'>'.$total_input[$date_value].'</td>';

            }
            $to_dashboard_chart['total_input'][$date_key] = isset($total_input[$date_value]) ? $total_input[$date_value] : '-';

            if (!isset($total_output[$date_value])) {
                $total_output_content  .= '<td class='.$is_selected_date.'>-</td>';
            }
            else
            {
                $total_output_content  .= '<td class='.$is_selected_date.'>'.$total_output[$date_value].'</td>';
            }
            $to_dashboard_chart['total_output'][$date_key] = isset($total_output[$date_value]) ? $total_output[$date_value] : '-';

            if (!isset($total_input[$date_value]) && !isset($total_output[$date_value])) {
                $balance_content  .= '<td class='.$is_selected_date.'>-</td>';
            }
            else
            {
                $temp_input = $total_input[$date_value];
                $temp_input = is_numeric($temp_input) ? $temp_input : 0;
                $temp_output = $total_output[$date_value];
                $temp_output = is_numeric($temp_output) ? $temp_output : 0;
                $balance_content  .= '<td class='.$is_selected_date.'>'.($temp_input-$temp_output).'</td>';
            }

            if (!isset($current_weight[$date_value])) {
                $weight_content  .= '<td class='.$is_selected_date.'>-</td>';
            }
            else
            {
                $working_weight = $current_weight[$date_value];
                $weight_content  .= '<td class='.$is_selected_date.'>'.$current_weight[$date_value].'</td>';

            }
            $to_dashboard_chart['current_weight'][$date_key] = isset($current_weight[$date_value]) ? $current_weight[$date_value] : '-';

            $temp_bowels_content = \SiteHelpers::formateWeeklyValue($bowels_status, $date_value, $time_period, 'bowels', $bowels_total);
            $bowels_content .= $temp_bowels_content;
            $to_dashboard_chart['bowels_content'][$date_key] = strip_tags($temp_bowels_content);

            $stools_content .= \SiteHelpers::formateWeeklyValue($bowels_status, $date_value, $time_period, 'stools', $stools_status);

        }

        $total_inputs = 0;
        $total_outputs = 0;
        $balance = 0;
        $cumulative_balance = 0;
        
        $admission_date = $baby->AdmissionDate;
        $temp_admission_date = date('Y-m-d', strtotime($baby->AdmissionDate));

        if (strtotime($week_start_date) < strtotime($temp_admission_date)) {
            $temp_admission_date = $week_start_date;
        }

        $temp_date_periods = self::createDateRangeArray($temp_admission_date, $end_date);
        $week_details = NurseSheetMain::getAWeekDetails($admission_id, $temp_admission_date, $week_end_date);

        $total_input = $week_details->pluck('total_input', 'sheet_date')->toArray();
        $total_output = $week_details->pluck('total_output', 'sheet_date')->toArray();

        foreach ($temp_date_periods as $date_key => $date_value) {
            $is_selected_date = '';
            if (date('d-m-Y', strtotime($date_value)) == $today) {
                $is_selected_date = 'current_date';
            }
            if (in_array($date_value, $date_periods)) {
                if (isset($total_input[$date_value]) && isset($total_output[$date_value])) {
                    $total_inputs = is_numeric($total_input[$date_value]) ? $total_input[$date_value] : 0;
                    $total_outputs = is_numeric($total_output[$date_value]) ? $total_output[$date_value] : 0;
                    $balance = $total_inputs - $total_outputs;
                    $cumulative_balance = $cumulative_balance + $balance;
                    if (in_array($date_value, $date_periods)) {
                        $cumulative_balance_content  .= '<td class='.$is_selected_date.'>'.$cumulative_balance.'</td>';
                    }
                } else {
                    $cumulative_balance_content  .= '<td class='.$is_selected_date.'>-</td>';                
                }
            }
        }

        if (isset($input['from_dashboard']) && $input['from_dashboard']) {
            return $to_dashboard_chart;
        }

        $table_content  =  '<thead><tr><th>DATE</th>';
        $table_content .= $heading_content;
        $table_content .= '</tr></thead><tbody><tr><th>Weight</th>';
        $table_content .= $weight_content;
        $table_content .= '</tr><tr><th>Total Input</th>';
        $table_content .= $total_input_content;
        $table_content .= '</tr><tr><th>Total Output</th>';
        $table_content .= $total_output_content;
        $table_content .= '</tr><tr><th style="text-align: left;">Bowels</th>';
        $table_content .= $bowels_content;
        $table_content .= '</tr><tr><th style="text-align: left;">Pathological Stool</th>';
        $table_content .= $stools_content;
        $table_content .= '</tr><tr><th style="text-align: left;">Balance</th>';
        $table_content .= $balance_content;
        $table_content .= '</tr><tr><th style="text-align: left;">Cumulative Balance</th>';
        $table_content .= $cumulative_balance_content;
        $table_content .= '</tr></tbody>';
        if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'table_content' => $table_content], 200);
        }
        
        if (isset($input['closewinlink']) && ($input['closewinlink'] == 'nicu-nurse-sheets' || $input['closewinlink'] == 'ward-dashboard')) {
            $closewinlink = action('Nurse\NurseSheetController@GetDaylist', \SiteHelpers::encrypt_id($admission_id)).'/'.$input['closewinlink'];
        } else if (isset($input['closewinlink']) && $input['closewinlink'] == 'search-reports') {
            $closewinlink = action('HomeController@search').'?baby_id='.\SiteHelpers::encrypt_id($baby->BabyId);
        } else {
            $closewinlink = url('weekly-observation-baby-select');
        }

        $nicu = Nicu::where('BabyId', $baby->BabyId)->where('AdmissionId', $admission_id)->first();

        $hospital_name = isset($nicu->hospital_name) ? $nicu->hospital_name : '';

        return view('nurse_sheet.weekly_observation', compact('current_weight', 'corrected_gestation', 'closewinlink', 'week_start_date', 'week_end_date', 'baby', 'corrected_gestation', 'ip_details', 'admission_date', 'admission_id', 'table_content','end_date', 'hospital_name', 'working_weight'));

    }


    public static function createDateRangeArray($strDateFrom,$strDateTo)
    {

        $aryRange = [];

        $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
        $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

        if ($iDateTo >= $iDateFrom) {
            array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
            while ($iDateFrom<$iDateTo) {
                $iDateFrom += 86400; // add 24 hours
                array_push($aryRange, date('Y-m-d', $iDateFrom));
            }
        }
        return $aryRange;
    }

    public function GetAdmissionLists($baby_id, Request $request) {      

        if ($request->ajax()) {        

            $admission_list = NurseSheetMain::GetAdmissionLists($baby_id)->toArray();

            return \Response::json(['type' => 'success', 'message' => 'Successfully !', 'admission_list'=>$admission_list], 200);

        } else {
            return redirect('/');
        }

    }

    public function getMonitorData(Request $request, $table_name = 'emr_moniter_values') {

        $input = $request->all();
        $patient_status = DischargeLog::getDischargeDetail($input['baby_id'], $input['admission_id']);
        if (count($patient_status) > 0) {
            $table_name = 'emr_moniter_values_discharged';
        }

        $monitor_data_list = \DB::table('emr_log_hdr')
        ->select($table_name.'.id as monitor_id', 'intf_ref_value', 'mean', 'edited_reason', 'local_description', 'is_approved', 'result_date_time', 'original_intf_ref_value', 'edited_by', \DB::raw("TO_CHAR(result_date_time,'DD-MM-YYYY HH24:00') as temp_result_date_time"), 'approval_parameter_priority')
        ->selectRaw('TO_CHAR(result_date_time,\'YYYY-MM-DD HH24:00\')|| \'|\' ||local_code_group.id as result_local')
        ->selectRaw('TO_CHAR(result_date_time,\'YYYYMMDDHH2400\') as timetostr')
        ->join($table_name, $table_name.'.log_hdr_id', '=', 'emr_log_hdr.id')
        ->join('local_code_group', 'local_code_group.id', '=', $table_name.'.loinc_local_map_id')
        ->where('emr_log_hdr.baby_id', $input['baby_id'])
        ->where('emr_log_hdr.admission_id', $input['admission_id'])
        ->where($table_name.'.create_user_id', $this->monitor_user)
        ->whereIn('local_code', DialpadSupportProperty::EMR_MONITER_VALUES);
        if (isset($input['start_time']) && isset($input['end_time'])) {
            $monitor_data_list = $monitor_data_list->whereBetween('result_date_time', [$input['start_time'], $input['end_time']]);
        }
        $monitor_data_list = $monitor_data_list->orderBy('result_date_time', 'desc');
        
        $monitor_data_list = $monitor_data_list->get()->unique('result_local');

        $approval_count = $monitor_data_list->where('is_approved', '<>',true)->count();

        $un_apporved_time = array_values(collect($monitor_data_list)->where('is_approved', '<>',true)->sortBy('timetostr')->pluck('temp_result_date_time', 'timetostr')->unique()->toArray());

        $monitor_data_list = collect($monitor_data_list)->sortBy('approval_parameter_priority')
        ->groupBy(['approval_parameter_priority', 'temp_result_date_time'])
        ->toArray();

        if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'Success !', 'value' => $monitor_data_list, 'un_apporved_time' => $un_apporved_time, 'approval_count' => $approval_count, 'table_name' => $table_name], 200);
        } else {
            return ['value' => $monitor_data_list, 'un_apporved_time' => $un_apporved_time, 'approval_count' => $approval_count, 'table_name' => $table_name];            
        }

    }

    public function getVentilatorData(Request $request, $table_name = 'emr_ventilator_values') {

        $input = $request->all();
        $patient_status = DischargeLog::getDischargeDetail($input['baby_id'], $input['admission_id']);
        if (count($patient_status) > 0) {
            $table_name = 'emr_ventilator_values_discharged';
        }

        $ventilator_data_list = \DB::table('emr_log_hdr')
        ->select($table_name.'.id as ventilator_id', 'intf_ref_value', 'mean', 'edited_reason', 'local_description', 'is_approved', 'result_date_time', 'original_intf_ref_value', 'local_code', 'local_code_group.id as local_code_group_id', 'edited_by', \DB::raw("TO_CHAR(result_date_time,'DD-MM-YYYY HH24:00') as temp_result_date_time"), 'approval_parameter_priority', $table_name.'.device_id')
        ->selectRaw('TO_CHAR(result_date_time,\'YYYY-MM-DD HH24:00\')|| \'|\' ||local_code_group.id as result_local')
        ->selectRaw('TO_CHAR(result_date_time,\'YYYYMMDDHH2400\') as timetostr')
        ->join($table_name, $table_name.'.log_hdr_id', '=', 'emr_log_hdr.id')
        ->join('local_code_group', 'local_code_group.id', '=', $table_name.'.loinc_local_map_id')
        ->where('emr_log_hdr.baby_id', $input['baby_id'])
        ->where('emr_log_hdr.admission_id', $input['admission_id'])
        ->where($table_name.'.create_user_id', $this->ventilator_user)
        ->whereIn('local_code', DialpadSupportProperty::EMR_VENTILATOR_VALUES)
        ->where('local_code', '<>', 'respiratory_rate');
        if (isset($input['start_time']) && isset($input['end_time'])) {
            $ventilator_data_list = $ventilator_data_list->whereBetween('result_date_time', [$input['start_time'], $input['end_time']]);
        }
        $ventilator_data_list = $ventilator_data_list->orderBy('result_date_time', 'desc');        

        $ventilator_data_list = $ventilator_data_list->get()->unique('result_local');

        $ventilator_data_list = collect($ventilator_data_list)->sortBy('approval_parameter_priority')->groupBy('temp_result_date_time');

        $ventilator_array = [];
        foreach ($ventilator_data_list as $key => $value) {
            if (isset($value) && !empty($value))
            {
                $ventilator_values = $value->unique('local_code_group_id');
                $asset_number = $ventilator_values->where('local_code_group_id', '47')->first();

                if (isset($asset_number->device_id) && !empty($asset_number->device_id))
                {
                    $ventilation_mode = $asset_number->intf_ref_value;
                    $device_id = $asset_number->device_id;
                    $ventilator_value_filtered = \DeviceHelpers::getVentilatorvaluesByMode($ventilation_mode, $device_id);
                    $ventilator_values = $ventilator_values->whereIn('local_code', $ventilator_value_filtered)->toArray();
                } else {
                    $ventilator_values = [];
                }
            }
            $ventilator_array = array_merge_recursive($ventilator_array, $ventilator_values);
        }

        $un_apporved_time = array_values(collect($ventilator_array)->where('is_approved', '<>',true)->sortBy('timetostr')->pluck('temp_result_date_time', 'timetostr')->unique()->toArray());

        $approval_count = (is_array($un_apporved_time) && count($un_apporved_time) > 0) ? 1 : 0;

        $ventilator_array = collect($ventilator_array)->sortBy('approval_parameter_priority')
        ->groupBy(['approval_parameter_priority', 'temp_result_date_time'])
        ->toArray();

        if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'Success !', 'value'=>$ventilator_array, 'un_apporved_time' => $un_apporved_time, 'approval_count'=>$approval_count, 'table_name' => $table_name], 200);
        } else {
            return ['value'=>$ventilator_array, 'un_apporved_time' => $un_apporved_time, 'approval_count'=>$approval_count, 'table_name' => $table_name];            
        }

    }

    public function getPumpData(Request $request, $prescription_dtl = 'prescription_dtl', $prescription_table = 'prescription_infused_calculation') {

        $input = $request->all();

        $prescription_hdr = 'prescription_hdr';
        $start_time = $input['start_time'];
        $end_time = $input['end_time'];    

        $patient_status = DischargeLog::getDischargeDetail($input['baby_id'], $input['admission_id']);
        if (count($patient_status) > 0) {
            $prescription_dtl = 'prescription_dtl_discharged';
            $prescription_table = 'prescription_infused_calculation_discharged';
        }

        $prescribed_drug_list = Prescription::getPumpData($input, $prescription_hdr, $prescription_dtl, $prescription_table, $start_time, $end_time);        

        $approval_count = $prescribed_drug_list->where('is_approved', '<>',true)->count();

        $un_apporved_time = array_values(collect($prescribed_drug_list)->where('is_approved', '<>',true)->sortBy('timetostr')->pluck('temp_result_date_time', 'timetostr')->unique()->toArray());

        $prescribed_drug_list = collect($prescribed_drug_list)->sortBy('approval_parameter_priority')
        ->groupBy(['drug_name'])
        ->map(function ($item) {
            $keys = $item->pluck('temp_result_date_time')->toArray();
            $values = collect($item)->toArray();
            $list = array_combine($keys, $values);
            return $list;
        })
        ->toArray();
        ksort($prescribed_drug_list);

        if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'Success !', 'drugs_list'=>$prescribed_drug_list, 'approval_count'=>$approval_count, 'un_apporved_time' => $un_apporved_time, 'table_name' => $prescription_table], 200);            
        } else {
            return ['drugs_list'=>$prescribed_drug_list, 'approval_count'=>$approval_count, 'un_apporved_time' => $un_apporved_time, 'table_name' => $prescription_table];            
        }


    }

    public function getPumpData1(Request $request, $prescription_dtl = 'prescription_dtl', $prescription_table = 'prescription') {

        $input = $request->all();

        $prescription_hdr = 'prescription_hdr';
        $start_time = $input['start_time'];
        $end_time = $input['end_time'];    

        $patient_status = DischargeLog::getDischargeDetail($input['baby_id'], $input['admission_id']);
        if (count($patient_status) > 0) {
            $prescription_dtl = 'prescription_dtl_discharged';
            $prescription_table = 'prescription_discharged';
        }

        $prescribed_drug_list = \DB::table($prescription_hdr)
        ->select('mas_drugivfluid.brand_name', $prescription_hdr.'.brand_name as drug_id', $prescription_table.'.result_time', $prescription_table.'.infused', 
            $prescription_table.'.rate', $prescription_table.'.id as pres_pump_id', $prescription_dtl.'.prescription_id', 'original_infused', $prescription_dtl.'.started_date', 'is_approved', 'edited_by', 'edited_reason', \DB::raw("TO_CHAR(result_time,'DD-MM-YYYY HH24:00') as temp_result_date_time"))
        ->selectRaw('mas_drugivfluid.brand_name|| \' / \' ||mas_drugivfluid.generic_pharmacological_name as drug_name')
        ->selectRaw($prescription_hdr.'.brand_name|| \':\' ||'.$prescription_table.'.prescription_id as drugname')
        ->leftjoin($prescription_dtl, $prescription_dtl.".pres_hdr_id", $prescription_hdr.'.id')
        ->leftjoin('baby_admission', 'baby_admission.BabyId', $prescription_hdr.'.baby_id')
        ->leftjoin('mas_drugivfluid', 'mas_drugivfluid.id', $prescription_hdr.'.brand_name')
        ->leftjoin($prescription_table, function ($join) use ($prescription_dtl, $prescription_table, $start_time, $end_time) {
            $join->orOn($prescription_dtl.'.prescription_id', '=', $prescription_table.'.prescription_id');
        })
        ->where('baby_admission.BabyId', $input['baby_id'])
        ->where('baby_admission.AdmissionId', $input['admission_id'])
        // ->where('is_cancel', false)
        // ->where('is_send', '<>', 3)
        // ->where('is_send', '<>', 99)
        ->where('order_status', '<>', 'RS')
        ->where('order_status', '<>', 'EP')
        ->where(function($query) use ($prescription_dtl, $start_time, $end_time) {
            $query->where($prescription_dtl.'.started_date', '>=', $start_time)
            ->orWhere($prescription_dtl.'.started_date', '<', $end_time);
        })
        ->where($prescription_table.'.result_time', '>=', $start_time)
        ->where($prescription_table.'.result_time', '<', $end_time)
        ->orderBy($prescription_table.'.result_time', 'asc')
        ->orderBy($prescription_table.'.id', 'asc')
        ->get()
        ->groupBy(['drugname', function($date) {
            if ($date->result_time == '') {
                return Carbon::parse($date->started_date)->format('d:H:00');
            } else {
                return Carbon::parse($date->result_time)->format('d:H:00');
            }
        }
    ])
        ->toArray(); 

        $temp_prescription_fluid = array();
        $prescription_fluid = array();
        $prescription_not_approved_count = 0;

        $un_apporved_time = [];

        foreach ($prescribed_drug_list as $prescribed_key => $prescribed_value) {
            $temp_count = 1;
            $collect_count = count($prescribed_value);
            foreach ($prescribed_value as $key => $value) {
                $first_value = $value[0];
                if ($collect_count == $temp_count) {
                    $last_value = $value[count($value) - 1];
                } else {
                    $last = next($prescribed_value);
                    $last_value = $last[0];
                }

                $temp_prescription_fluid[$first_value->drugname][date('d-m-Y H:00', strtotime($first_value->result_time))] = $first_value;
                $temp_prescription_fluid[$last_value->drugname][date('d-m-Y H:00', strtotime($last_value->result_time))] = $last_value;
                if ($first_value->is_approved == null)  {
                    $un_apporved_time[] = date('d-m-Y H:00', strtotime($first_value->result_time));
                }
                $temp_count++;
                if ($first_value->is_approved != 1) {
                    $prescription_not_approved_count++;
                }
                if ($last_value->is_approved != 1) {
                    $prescription_not_approved_count++;
                }
            }
        }
        $prescription_fluid = $temp_prescription_fluid;

        $un_apporved_time = array_values(collect($un_apporved_time)->unique()->toArray());
        sort($un_apporved_time);

        return \Response::json(['type' => 'success', 'message' => 'Success !', 'drugs_list'=>$prescription_fluid, 'approval_count'=>$prescription_not_approved_count, 'un_apporved_time' => $un_apporved_time, 'table_name' => $prescription_table], 200);

    }

    public function getLabData(Request $request, $table_name = 'emr_lab_values') {

        $input = $request->all();

        $patient_status = DischargeLog::getDischargeDetail($input['baby_id'], $input['admission_id']);
        if (count($patient_status) > 0) {
            $table_name = 'emr_lab_values_discharged';
        }

        $lab_data_list = \DB::table('emr_log_hdr')
        ->select($table_name.'.id as lab_id', 'intf_ref_value', 'mean', 'edited_reason', 'local_description', 'is_approved', 'result_date_time', 'original_intf_ref_value')
        ->join($table_name, $table_name.'.log_hdr_id', '=', 'emr_log_hdr.id')
        ->join('local_code_group', 'local_code_group.id', '=', $table_name.'.loinc_local_map_id')
        ->where('emr_log_hdr.baby_id', $input['baby_id'])
        ->where('emr_log_hdr.admission_id', $input['admission_id'])
        ->where($table_name.'.create_user_id', 4)
        ->whereIn('local_code', DialpadSupportProperty::EMR_LAB_VALUES);
        if (isset($input['start_time']) && isset($input['end_time'])) {
            $lab_data_list = $lab_data_list->whereBetween('result_date_time', [$input['start_time'], $input['end_time']]);
        }
        $lab_data_list = $lab_data_list->orderBy('result_date_time', 'asc')
        ->orderBy($table_name.'.id', 'asc');
        
        $approval_count = $lab_data_list->where('is_approved', '<>',true)->count();

        $lab_data_list = $lab_data_list->get()
        ->groupBy([function($date) {
            return Carbon::parse($date->result_date_time)->format('d-m-Y H:00');
        }])
        ->toArray();

        return \Response::json(['type' => 'success', 'message' => 'Success !', 'value'=>$lab_data_list, 'approval_count'=>$approval_count], 200);

    }

    public function machineDataApproval(Request $request)
    {
        $input = $request->all();
        $id_list = $input['emr_data_id'];      
        $table_name = $input['table_name'];      
        $time_list = $input['time'];      

        foreach ($id_list as $key => $value) {
            if ($table_name[$key] == 'prescription' || $table_name[$key] == 'prescription_discharged') {
                $start_time = date('Y-m-d H:i', strtotime($time_list[$key]));
                $end_time = date('Y-m-d H:i', strtotime('+1 hour', strtotime($time_list[$key])));
                \DB::table($table_name[$key])->where('prescription_id', $value)->whereBetween('result_time', [$start_time, $end_time])->update(['is_approved' => true, 'approved_by' => $this->auth->user() ['id'], 'approved_date_time' => Carbon::now($this->time_zone)]);
            } else {
                \DB::table($table_name[$key])->where('id', $value)->update(['is_approved' => true, 'approved_by' => $this->auth->user() ['id'], 'approved_date_time' => Carbon::now($this->time_zone)]);                
            }
        }

        return \Response::json(['messageType' => 'success', 'message' => 'Succcessfully'], 200);

    }

    public function machineDataUpdate(Request $request)
    {
        $input = $request->all();
        $data_list = isset($input['data']) ? $input['data'] : [];
        $table_name = $input['table_name']; 
        $column_name = $input['column_name']; 
        $column_name_1 = $input['column_name1']; 

        $data_list = collect($data_list)->groupBy('id');

        if (isset($input['data']) && is_array($input['data'])) {
            foreach ($data_list as $key => $value) {
                $edit_val = isset($value->first()['edit_val']) ? $value->first()['edit_val'] : '';
                $edited_reason =  isset($value->last()['edited_reason']) ? $value->last()['edited_reason'] : '';

                $corrected_val = $reason = NULL;

                if (!empty($edit_val)) {
                    $corrected_val = $edit_val;
                } 
                if (!empty($edited_reason)) {
                    $reason = $edited_reason;
                }
                
                \DB::table($table_name)->where('id', $key)->update([$column_name => $corrected_val, 'edited_reason' => $reason, 'edited_by' => $this->auth->user() ['id'], 'edited_date_time' => Carbon::now($this->time_zone)]);
            }
        } else {
            $id = isset($input['id']) ? $input['id'] : '';
            $edit_val = isset($input['edit_val']) ? $input['edit_val'] : '';
            $edited_reason =  isset($input['edited_reason']) ? $input['edited_reason'] : '';

            if (empty($column_name_1)) {
                \DB::table($table_name)->where('id', $id)->update([$column_name => $edit_val, 'edited_reason' => $edited_reason, 'edited_by' => $this->auth->user() ['id'], 'edited_date_time' => Carbon::now($this->time_zone)]);
            } else {
                \DB::table($table_name)->where('id', $id)->update([$column_name_1 => $edit_val, $column_name => $edit_val, 'edited_reason' => $edited_reason, 'edited_by' => $this->auth->user() ['id'], 'edited_date_time' => Carbon::now($this->time_zone)]);
            }

        }

        return \Response::json(['messageType' => 'success', 'message' => 'Succcessfully', 'id' => $id, 'value' => $edit_val, 'reason' => $edited_reason], 200);
    }

    public function labBabySelect($type = '')
    {
        $babies = array();
        $baby = Baby::baby_list_daycare();
        if ($type == 'overall') {
            $babies = collect($baby)->map(function($value) {
                $mrno = (!empty($value->BMrNo))? ' - '.$value->BMrNo : '';
                return $value->BMrNo .'||'. $value->BabyName.$mrno;
            });
            $babies = json_encode($babies);
        } else {
            $babies = collect($baby)->map(function($value) {
                $mrno = (!empty($value->BMrNo))? ' - '.$value->BMrNo : '';
                return \SiteHelpers::encrypt_id($value->BMrNo) .'||'. $value->BabyName.$mrno;
            });
            $babies = json_encode($babies);
        }

        $navigate['main_nav'] = 'lab_reports';
        $navigate['sub_nav'] = ($type == '') ? 'lab_report' : 'lab_report_all';

        $SubmitButtonText = 'Start';

        return view('nurse_sheet.lab_baby_select', compact('babies', 'SubmitButtonText', 'navigate', 'type'));

    }

    public function weeklyObservationBabySelect()
    {
        $babies_list = array();
        $baby = Baby::baby_list_daycare();
        $babies = \ValuelistHelpers::select2DataFormater($baby);

        $navigate['main_nav'] = 'weekly_observation';
        $navigate['sub_nav'] = 'weekly_observation';

        $SubmitButtonText = 'Start';

        return view('nurse_sheet.weekly_observation_baby_select', compact('babies', 'SubmitButtonText', 'navigate'));

    }

    public function allInOneChartBabySelect()
    {
        $babies = array();
        $baby = Baby::baby_list_daycare();
        
        $babies = \ValuelistHelpers::select2DataFormater($baby);

        $navigate['main_nav'] = 'chart';
        $navigate['sub_nav'] = 'all_in_one_chart';

        $SubmitButtonText = 'Start';

        return view('nurse_sheet.all_in_one_chart_baby_select', compact('babies', 'SubmitButtonText', 'navigate'));

    }

    public function chartBabySelect()
    {
        $babies_list = array();
        $baby = Baby::baby_list_daycare();

        $babies = \ValuelistHelpers::select2DataFormater($baby);

        $navigate['main_nav'] = 'chart';
        $navigate['sub_nav'] = 'single_chart';

        $SubmitButtonText = 'Start';

        return view('nurse_sheet.chart_baby_select', compact('babies', 'SubmitButtonText', 'navigate'));

    }

    /**
     * This Method to get Admission List
     *
     * @param $baby_id type integer
     * @return admission list type json
     */
    public function getAdmissionId(Request $request)
    {
        $baby_id = $request->input('baby_id');

        $baby_id = \SiteHelpers::decrypt_id($baby_id);

        $baby = Baby::daycare_eposide_list($baby_id);

        $babies = array(
            '0' => '-- Select Admission --'
        );

        foreach ($baby as $babyvalue) {
            $babies[\SiteHelpers::encrypt_id($babyvalue->AdmissionId)] = $babyvalue->episodes;
        }

        return \Response::json(['data' => $babies], 200);

    }

    public function liveChart(Request $request)
    {
        $input = $request->all();

        $baby_id = $input['baby_id'];
        $baby_id = \SiteHelpers::decrypt_id($baby_id);
        $admission_id = $input['admission_id'];
        $admission_id = \SiteHelpers::decrypt_id($admission_id);

        if (isset($baby_id)) {
            $baby_details = Baby::find($baby_id)->toArray();
        } else {
            $baby_details = Admission::getBabyMrn($admission_id)->toArray();
        }
        $ip_details = IpNumber::getCurrent_ip($baby_id, $admission_id);
        $ip_details = (array)$ip_details;

        $baby_details = array_merge($baby_details, $ip_details);
        $baby_details = (object)$baby_details;

        $req_input = new Request();
        $req_input['mrn'] = $baby_details->BMrNo;

        $parameter_data = InterfaceDataController::getInterfaceParameter($req_input);
        $parameter_content = $parameter_data[0];
        $param = $parameter_data[1];

        $time = $this->interface_data->getStartTime($baby_details->BMrNo);

        if (count($time)) {

            $startfrom = $time->admission_date_time;

            $startfrom = Carbon::createFromFormat('Y-m-d H:i:s', $startfrom, $this->time_zone);
            $startfrom = $startfrom->setTimezone($input['client_zone']);

            $endto = Carbon::now($input['client_zone']);

            $to_time = strtotime($startfrom);
            $from_time = strtotime($endto);

            $minutes = round((abs($to_time - $from_time) / 60) / 30);

        }

        $event_list = DashboardEvent::getEvents()->pluck('event_name');
        $event_name_list = DashboardEvent::getEvents()->pluck('event_name', 'event_code');
        
        $patient_status = '';
        
        $patient_status = DischargeLog::getDischargeDetail($baby_id, $admission_id);

        if (count($patient_status) == 0) {
            $patient_status = 'Inpatient';
        }

        $event_color_list = \DB::table('mas_event_details')->whereNotNull('event_code')->pluck('bg_color', 'event_code')->toArray();


        return view('nurse_sheet.live_chart', compact('baby_details', 'param', 'minutes', 'startfrom', 'endto', 'event_list', 'parameter_content', 'patient_status', 'event_name_list', 'event_color_list'));
    }

    public static function ecgchart($mrn)
    {
        return view('nurse_sheet.live_chart_ecg');
    }

    public function updateLabFlag($day_id)
    {
        \DB::table('nurse_main_sheet')->where('id', $day_id)->update(['lab_flag'=>0]);
    }

    public function overallLabValuePrint($baby_mrn, Request $request)
    {
        $input = $request->all();

        if (is_numeric($baby_mrn)) {
            $baby = Baby::get_baby_by_mrn($baby_mrn);
        } else {
            return \Redirect::back()->with('error', 'Please enter valid UHID !');
        }
        $baby_id = isset($baby->BabyId) ? $baby->BabyId : '';
        
        $get_lis_test_id = \DB::table('local_code_group')->select('lis_test_id')->whereNotNull('lis_test_id')->pluck('lis_test_id')->toArray();

        $client = new \GuzzleHttp\Client();
        
        $lab_report_url = \SiteHelpers::getConfigSettings('GET_LIS_LAB_RESULT_BY_MRN');
        
        $response = $client->request('GET', $lab_report_url.$baby_mrn, ['http_errors' => false]);

        $status_code = $response->getStatusCode();
        if ($status_code != 200) {
            // $this->custom_error->emergencyLog('HTTP ERROR for IP number :'.$ip_number.' Baby ID : '.$lab_req_value->baby_id);
        }
        $lab_result = $response->getBody();
        $lab_result = $lab_result->getContents();
        $lab_values = collect(json_decode($lab_result))->whereIn('testId', $get_lis_test_id)
        // ->filter(function($lab_response){
        //     return $lab_response->departmentId == '1' || $lab_response->departmentId == '2' || $lab_response->departmentId == '4' || $lab_response->testId == '191'; 
        // })
                    // ->whereIn('departmentId', ['1', '2'])->orWhere('testId', '191')
        ->sortByDesc('createTime');
        
        $second_tab_lab_test_ids = ['513', '355', '354', '353', '352', '161', '166', '361', '627', '351', '357', '358', '88', '186', '178', '1062', '176', '175', '267', '200', '82', '81', '256', '87', '86', '85', '84', '83', '202', '90', '93', '786', '521', '79', '91', '89'];
        $sheet_id = $lab_values->map(function($item) use ($get_lis_test_id, $second_tab_lab_test_ids)
        {
            if (in_array($item->testId, $get_lis_test_id) && !in_array($item->testId, $second_tab_lab_test_ids) && $item->rawResult != '' && $item->rawResult != null) {
                return date('Y-m-d H:i', strtotime($item->createTime)).":00";
            }
        })->unique()->toArray();
        $sheet_id = array_filter($sheet_id);
        $result = $lab_values->groupBy(function($list)  use ($get_lis_test_id)
        {
            if (in_array($list->testId, $get_lis_test_id) && $list->rawResult != '' && $list->rawResult != null) {
                return date('Y-m-d H:i', strtotime($list->createTime)).":00";
            }
        })->toArray();
        $second_tab_lab_values = collect(json_decode($lab_result))->whereIn('testId', $second_tab_lab_test_ids)->sortByDesc('createTime');
        $second_tab_sheet_id = $second_tab_lab_values->map(function($item)
        {
            return date('Y-m-d H:i', strtotime($item->createTime)).":00";
        })->unique()->toArray();

        $second_tab_result = $second_tab_lab_values->groupBy(function($list)
        {
            return date('Y-m-d H:i', strtotime($list->createTime)).":00";
        })->toArray();

        if ($baby_id != '') {
            $lab_data_table_name = 'emr_lab_values';

            $abg_test_list = DialpadSupportProperty::ABG_TEST_LIST;
            $abg_results = [];
            $admission_ids = Admission::where('BabyId', $baby_id)->pluck('AdmissionId');

            foreach ($admission_ids as $admission_id) {
                $patient_status = DischargeLog::getDischargeDetail($baby_id, $admission_id);
                if (count($patient_status) > 0) {
                    $lab_data_table_name = 'emr_lab_values_discharged';
                }

                $temp_abg_results = EmrLogHeader::getInterfacingData($baby_id, $admission_id, $abg_test_list, '', '', $lab_data_table_name, false)->toArray();

                $abg_results = array_merge($abg_results, $temp_abg_results);

            }
            $abg_values = collect($abg_results)->groupBy(['temp_result_date_time', 'local_code'])->toArray();
        }
        $admission_date = date('Y-m-d');
        $closewinlink = url('lab-baby-select/overall');

        if (isset($input['closewinlink'])) {
            if ($input['closewinlink'] == 'neuro-visit-list') {
                $closewinlink = action('Registration\NeuroController@NeuroSubList', \SiteHelpers::encrypt_id($baby_id));
            } elseif ($input['closewinlink'] == 'neonatal-op-visit-list') {
                $closewinlink = action('Registration\OpController@OpsubList', \SiteHelpers::encrypt_id($baby_id));
            } elseif ($input['closewinlink'] == 'pediatric-op-visit-list') {
                $closewinlink = action('Registration\PediatricOpController@OpsubList', \SiteHelpers::encrypt_id($baby_id));
            } elseif ($input['closewinlink'] == 'neonatal-op-visit') {
                $closewinlink = action('Registration\OpController@edit', $input['visitid']);
            } elseif ($input['closewinlink'] == 'pediatric-op-visit') {
                $closewinlink = action('Registration\PediatricOpController@edit', $input['visitid']);
            } elseif ($input['closewinlink'] == 'neuro-op-visit') {
                $closewinlink = action('Registration\NeuroController@edit', $input['visitid']);
            } elseif ($input['closewinlink'] == 'search-reports') {
                $closewinlink = action('HomeController@search').'?baby_id='. \SiteHelpers::encrypt_id($baby_id);
            } elseif ($input['closewinlink'] == 'pediatric-visit-list') {
                $closewinlink = action('Admission\PediatricController@sublist', \SiteHelpers::encrypt_id($baby_id));
            } elseif ($input['closewinlink'] == 'pediatric-edit') {
                $closewinlink = action('Admission\PediatricController@edit', $input['visitid']);
            } 
        }

        return view('nurse_sheet.overall_lab_value_print', compact('baby', 'sheet_id', 'result', 'admission_date', 'second_tab_sheet_id', 'second_tab_result', 'closewinlink', 'abg_values', 'abg_test_list', 'baby_mrn'));

    }

    public static function dayTotalInput($input)
    {

        if (isset($input['admission_id']) && !is_null($input['admission_id'])) {

            $working_time = Settings::getPeriod()->period;

            $admission_id = $input['admission_id'];

            $sheet_time = date('H', strtotime($input['time_hour']));

            $working_hour = substr($working_time, 0, 2);
            $working_hour = (int)$working_hour;

            if ($sheet_time < $working_time) {
                $sheet_date = date('Y-m-d', strtotime($input['sheet_date'] . ' -1 day'));
            } else {                
                $sheet_date = date('Y-m-d', strtotime($input['sheet_date']));
            }

            $start_date_time = $sheet_date . ' '. $working_time;
            $end_date_time = date('Y-m-d H:i:s', strtotime($start_date_time . ' +1 day -1 second'));

            $manual_local_code = DialpadSupportProperty::EMR_NURSE_MANUAL_VALUES;
            $milk_volume = $manual_local_code[20];

            $milk_volume_total = \DB::table('emr_log_hdr')
            ->select(\DB::raw("(regexp_matches(intf_ref_value, '[0-9]+\.?[0-9]*'))[1]::numeric AS intf_ref_value"))
            ->leftJoin('emr_nurse_manual_values', 'emr_log_hdr.id', 'emr_nurse_manual_values.log_hdr_id')
            ->leftJoin('local_code_group', 'emr_nurse_manual_values.loinc_local_map_id', 'local_code_group.id')
            ->whereBetween('sender_time', [$start_date_time, $end_date_time])
            ->where('local_code_group.local_code', $milk_volume)
            ->where('admission_id', $admission_id)
            ->whereNotNull('intf_ref_value')
            ->where('intf_ref_value', '<>', '')
            ->get()
            ->sum('intf_ref_value');

            $prescription_total = \DB::table('prescription_hdr')
            ->select('hour_infused')
            ->leftJoin('prescription_dtl', 'prescription_hdr.id', 'prescription_dtl.pres_hdr_id')
            ->leftJoin('prescription_infused_calculation', 'prescription_dtl.prescription_id', 'prescription_infused_calculation.prescription_id')
            ->whereBetween('calculated_hour', [$start_date_time, $end_date_time])
            ->where('admission_id', $admission_id)
            ->whereNotNull('hour_infused')
            // ->where('is_cancel', false)
            // ->where('is_send', '<>', 3)
            // ->where('is_send', '<>', 99)
            ->where('order_status', '<>', 'RS')
            ->where('order_status', '<>', 'EP')
            ->sum('hour_infused');

            $manual_drug_total = \DB::table('emr_log_hdr')
            ->select(\DB::raw("(regexp_matches(intf_ref_value, '[0-9]+\.?[0-9]*'))[1]::numeric AS intf_ref_value"))
            ->leftJoin('emr_log_dtl', 'emr_log_hdr.id', 'emr_log_dtl.log_hdr_id')
            ->whereBetween('sender_time', [$start_date_time, $end_date_time])
            ->where('loinc_local_map_id', 108)
            ->whereNotNull('intf_ref_value')
            ->where('intf_ref_value', '<>', '')
            ->where('admission_id', $admission_id)
            ->get()
            ->sum('intf_ref_value');

            $drug_total = $manual_drug_total + $prescription_total;

            $results = NurseSheetMain::where('admission_id', $admission_id)->where('sheet_date', $sheet_date)->first();

            $total_intake = null;
            $total_input = null;

            $total_intake = $milk_volume_total + $drug_total;

            if (isset($results->working_weight) && $results->working_weight > 0 && is_numeric($results->working_weight)) {

                $working_weight = $results->working_weight / 1000;
                $total_input = $total_intake / $working_weight;
                $total_input = number_format($total_input, 2);
                $total_input = str_replace(',', '', $total_input);
            }

            $total_intake = number_format($total_intake, 2);

            if (isset($results->id)) {
                NurseSheetMain::where('id', $results->id)->update(['total_input' => $total_intake, 'total_input_ml_per_kg' => $total_input]);
            }

        }
    }

    public function dayTotalOutput($input)
    {
        if (isset($input['admission_id']) && !is_null($input['admission_id'])) {

            $working_time = Settings::getPeriod()->period;
            $admission_id = $input['admission_id'];

            $sheet_time = date('H', strtotime($input['time_hour']));

            $working_hour = substr($working_time, 0, 2);
            $working_hour = (int)$working_hour;

            if ($sheet_time < $working_time) {
                $sheet_date = date('Y-m-d', strtotime($input['sheet_date'] . ' -1 day'));
            } else {
                $sheet_date = date('Y-m-d', strtotime($input['sheet_date']));
            }

            $start_date_time = $sheet_date . ' '. $working_time;
            $end_date_time = date('Y-m-d H:i:s', strtotime($start_date_time . ' +1 day -1 second'));

            $manual_local_code = DialpadSupportProperty::EMR_NURSE_MANUAL_VALUES;
            $gastric_aspirate_volume = $manual_local_code[23];
            $urine_output = $manual_local_code[26];
            $blood_volume_out = $manual_local_code[27];
            $drain_output_r = $manual_local_code[28];
            $drain_output_l = $manual_local_code[29];

            $output = \DB::table('emr_log_hdr')
            ->select(\DB::raw("(regexp_matches(intf_ref_value, '[0-9]+\.?[0-9]*'))[1]::numeric AS intf_ref_value"))
            ->leftJoin('emr_nurse_manual_values', 'emr_log_hdr.id', 'emr_nurse_manual_values.log_hdr_id')
            ->leftJoin('local_code_group', 'emr_nurse_manual_values.loinc_local_map_id', 'local_code_group.id')
            ->whereBetween('sender_time', [$start_date_time, $end_date_time])
            ->whereIn('local_code_group.local_code', [$gastric_aspirate_volume, $urine_output, $blood_volume_out, $drain_output_r, $drain_output_l])
            ->where('admission_id', $admission_id)
            ->whereNotNull('intf_ref_value')
            ->where('intf_ref_value', '<>', '')
            ->get()
            ->sum('intf_ref_value');

            $results = NurseSheetMain::where('admission_id', $admission_id)->where('sheet_date', $sheet_date)->first();

            $output_volume = null;
            $total_output = null;

            if (isset($results->working_weight) && $results->working_weight > 0 && is_numeric($results->working_weight)) {

                $working_weight = (float)$results->working_weight / 1000;

                $total_output = $output / $working_weight;
                $total_output = number_format($total_output, 2);
                $total_output = str_replace(',', '', $total_output);

            }         

            $output_volume = number_format($output, 2);

            if (isset($results->id)) {
                NurseSheetMain::where('id', $results->id)->update(['total_output' => $output_volume, 'total_output_ml_per_kg' => $total_output]);
            }
        }

    }

    public function checkDayHeader($time_key, $input, $baby_details, $added_nurse = null)
    {
        $time_explode = explode(':', $time_key);
        $temp_time = $time_explode[1] . ':' . $time_explode[2];
        $date_time = explode('-', $input['sheet_date']);
        $diff = false;

        if ($time_explode[0] == $date_time[0])
        {
            $time = $input['sheet_date'] . ' ' . $temp_time;
        }
        else
        {
            $date = explode(' ', Carbon::createFromFormat('d-m-Y', $input['sheet_date'])->addDay()) [0];
            $time = $date . ' ' . $temp_time;
            $diff = true;
        }

        $start_sender_time = date('Y-m-d H:i:s', strtotime($time));

        $end_sender_time = Carbon::createFromFormat('Y-m-d H:i:s', $start_sender_time)->addHour();

        $check_log = EmrLogDetails::checkLogIsExist($start_sender_time, $end_sender_time, $input["BabyId"], $input['admission_id'], $baby_details["MotherId"]);

        $manaual_log_head_id = 0;

        if (count($check_log) != 0)
        {
            $manaual_log_head_id = $check_log->id;
        }
        else
        {
            if ($diff) {
                $sheet_date = date('Y-m-d', strtotime($start_sender_time));

                $sheet_details = NurseSheetMain::GetNurseSheet($sheet_date, $input['BabyId'], $input['admission_id']);
                if (count($sheet_details) > 0) {
                    $day_id = $sheet_details->id;
                } else {
                    $dayCount = count(NurseSheetMain::GetNurseSheetCount($input['BabyId'], $input['admission_id']));

                    $sheet_details['day_name'] = 'Day ' . ($dayCount + 1);
                    $sheet_details['sheet_date'] = $sheet_date;
                    $sheet_details['baby_id'] = $input['BabyId'];
                    $sheet_details['admission_id'] = $input['admission_id'];

                    $day_id = NurseSheetMain::create($sheet_details)->id;

                    $bed_details = BedLog::getBedDeatails($input['BabyId'], $input['admission_id']);

                    $patient_log['day_id'] = $day_id;
                    $patient_log['bed_id'] = isset($bed_details->bed_id) ? $bed_details->bed_id : 0;
                    $patient_log['created_date_time'] = Carbon::now($this->time_zone);
                    $patient_log['created_by'] = $this->auth->user()->id;

                    DayWisePatientBedLog::create($patient_log);
                }
            }
            $form_id = isset($day_id) ? $day_id : $input['formid'];

            $manaual_log_head_id = $this->addemrlog($form_id, $baby_details, $start_sender_time, $input, $input['admission_id'], $added_nurse);
        }

        return $manaual_log_head_id;
    }
    
    public function pacsViewer($patientUhid)
    {
        $pacs_link = \SiteHelpers::pacsViewerLink();
        $pacs_api_key = env('PACS_API_KEY');
        return view('nurse_sheet.pacs_viewer', compact('patientUhid', 'pacs_link', 'pacs_api_key'));
    }

    // To get the previous and next day sheet id for the currently selected data
    public function getPrevNextIds($admission_id, $id)
    {
        
        $navigation_ids = NurseSheetMain::getPrevNextIds($admission_id, $id)->pluck('id')->toArray();

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
