<?php
namespace App\Http\Controllers\Admission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Masters\DoctorMaster;
use App\Models\Masters\Admissionmode as AdmissionmodeMaster;
// use App\Models\Masters\AntibioticMaster as AntibioticMaster;
use App\Models\Icd;
use App\Models\Postnatal;
use App\Models\Baby;
use App\Exceptions\InvalidInputException;
use Carbon\Carbon;
use App\Models\Admission;
use App\Models\PostnatalDischarge;
use App\Models\Problems;
use App\Models\Masters\MediprobsMaster;
use App\Models\Masters\Complications;
use App\Models\Complication;
use App\Models\IpNumber;
use App\Models\Delivery;
use App\Models\Usg;
use App\Models\Masters\Indication;
use App\Http\Controllers\Flow\FlowController;
use App\Models\Settings\DeleteApproval;
use App\Models\FlowControl;
use App\Models\Neonatal;

/**
 * All the curd of problem base daycare goes here
 *
 * @author Manikandan M
 */
class PostnatalController extends Controller
{

    public function __construct(Guard $auth, FlowController $flow)
    {
        $this->middleware('role:POST_FORM,write', ['only' => ['store', 'update', 'edit', 'create', 'show', 'destroy']]);
        $this->middleware('role:POST_FORM,read', ['only' => ['index', 'printData']]);
        $this->auth = $auth;
        $this->zone = env('TIME_ZONE');
        $this->flow = $flow;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = 50;
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

        $order['sortby'] = 'baby.BabyId';
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

        $navigate['main_nav'] = 'postnatal';
        $navigate['sub_nav'] = 'postnatal_proforma';

        $status = !empty($request->input('status')) ? $request->input('status') : 'inpatient';

        $page = !empty($request->input('page')) ? $request->input('page') : 1;
        $page = preg_replace( '/[^0-9]/', '', $page);

        $result = Postnatal::get_lists($page , $limit, $search, $order, 1, $status);
        $results = $result['result'];

        $getTotal = Postnatal::GetTotal();
        $total = $result['total'];

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

        $this
            ->flow
            ->clearFlow();

        return view('admission.postnatal.babylist', compact('results', 'navigate', 'pagination', 'order', 'search', 'getTotal'));

    }

    public function postnatalAdmissionlist(Request $request, $baby_id)
    {
        $baby_id = \SiteHelpers::decrypt_id($baby_id);
        $admissionList = Postnatal::postnatalAdmissionList($baby_id);
        $baby_name = '';

        if (isset($admissionList[0]))
        {
            $baby_name = $admissionList[0]->BabyName . ' - ' . $admissionList[0]->BMrNo;

        }

        foreach ($admissionList as & $value)
        {
            $postnatal_daycare = Postnatal::getPostanatalDependancy($value->BabyId, $value->postnatal_admission_id);
            $value->hasAdmission = count($postnatal_daycare) > 0 ? true : false;
        }

        $neonatal = Neonatal::where('BabyId', $baby_id)->where('IsDeleted', 0)
            ->first();

        $navigate['main_nav'] = 'postnatal';
        $navigate['sub_nav'] = 'postnatal_proforma';

        return view('admission.postnatal.admission_list', compact('baby_name', 'neonatal', 'admissionList', 'navigate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->ajax())
        {
            $input = $request->all();

            $babies = Baby::getPostnatalBabyList($input['search'])->pluck('baby_name', 'BabyId')
                ->toArray();
                
            $babies[0] = '---Select---';
            // krsort($babies);

            if (count($babies) > 0)
            {
                return \Response::json(['status' => true, 'message' => $babies], 200);
            }
            else
            {
                return \Response::json(['status' => false, 'message' => $babies], 200);
            }

        }
        else
        {
            $navigate['main_nav'] = 'postnatal';
            $navigate['sub_nav'] = 'postnatal_proforma';
            $temp_babies = Baby::getPostnatalBabyList();
            $babies = \ValuelistHelpers::select2DataFormater($temp_babies);
            $SubmitButtonText = "Start";
        }

        return view('admission.postnatal.select_patient', compact('SubmitButtonText', 'babies', 'navigate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Postnatal $postnatal)
    {
        $input = $request->all();

        $print_flag = isset($input['print_flag']) ? $input['print_flag'] : 0;
        unset($input['print_flag']);

        $input['BirthStatus'] = (isset($input['BirthStatus']) && $input['BirthStatus'] == 'on') ? 'Outborn' : 'Inborn';

        foreach (array_keys($input) as $columnkey => $columnName)
        {

            $columnType = $postnatal->getColumnTypeUp($columnName);

            if ($columnType != false && $columnType == 'integer')
            {

                $input[$columnName] = (isset($input[$columnName]) && !empty($input[$columnName])) ? $input[$columnName] : null;

            }
            elseif ($columnType != false && $columnType == 'decimal')
            {

                $input[$columnName] = (isset($input[$columnName]) && !empty($input[$columnName])) ? $input[$columnName] : null;
            }

        }

        $input['g_weeks'] = (!empty($input['g_weeks'])) ? $input['g_weeks'] : null;
        $input['g_days'] = (!empty($input['g_days'])) ? $input['g_days'] : null;

        $input['DifferentialDiagnosis'] = !empty($input['DifferentialDiagnosis']) ? json_encode($input['DifferentialDiagnosis']) : '';

        $input['cg_weeks'] = (isset($input['cg_weeks']) && !empty($input['cg_weeks'])) ? $input['cg_weeks'] : 0;
        $input['cg_days'] = (isset($input['cg_days']) && !empty($input['cg_days'])) ? $input['cg_days'] : 0;

        $input['admission_cg'] = json_encode(['cg_weeks' => $input['cg_weeks'], 'cg_days' => $input['cg_days']]);
        $input['admission_date'] = date('Y-m-d', strtotime($input['admission_date']));
        $input['ventilation'] = (isset($input['ventilation']) && $input['ventilation'] == 'on') ? true : false;
        $input['uac_status'] = (isset($input['uac_status']) && $input['uac_status'] == 'on') ? true : false;
        $input['uvc_status'] = (isset($input['uvc_status']) && $input['uvc_status'] == 'on') ? true : false;
        $input['ivantibiotic'] = isset($input['ivantibiotic']) ? json_encode($input['ivantibiotic']) : json_encode(array());
        $input['differentialdiagnosis'] = isset($input['differentialdiagnosis']) ? json_encode($input['differentialdiagnosis']) : json_encode(array());
        $input['additional_diagnosis'] = isset($input['additional_diagnosis']) ? json_encode($input['additional_diagnosis']) : json_encode(array());
        $input['parents_spoken'] = (isset($input['parents_spoken']) && $input['parents_spoken'] == 'on') ? true : false;
        $input['DOB'] = date('Y-m-d', strtotime($input['DOB']));

        $current = Carbon::now($this->zone);

        $input['DateAdded'] = $current->format('Y-m-d H:i:s');
        $input['UserAdded'] = $this
            ->auth
            ->user()->id;

        if (isset($input['BabyId']))
        {
            $baby = Baby::find($input['BabyId']);
            $baby->update($input);
        }

        $discharge_details['AdmissionId'] = $input['AdmissionId'];
        $discharge_details['MotherId'] = $input['MotherId'];
        $discharge_details['BabyId'] = $input['BabyId'];
        $discharge_details['BMrNo'] = $baby['BMrNo'];
        $discharge_details['discharge_date'] = null;
        $discharge_details['appoinment_date'] = null;
        $discharge_details['discharge_status'] = 'Inpatient';

        // start tracking database transaction
        \DB::beginTransaction();

        try
        {

            if ($input['AdmissionId'] == 0)
            {

                $episodes = Admission::where('BabyId', $input['BabyId'])->count();
                $episodes += 1;
                $admission_data = array(
                    'BabyId' => $input['BabyId'],
                    'BMrNo' => $baby['BMrNo'],
                    'MotherId' => $input['MotherId'],
                    'AdmissionDate' => $input['admission_date'],
                    'AdmissionTime' => $input['admission_time_hour'] . ':' . $input['admission_time_mins'] . ':' . $input['admission_time_session'],
                    'InOrOut' => 'In',
                    'AdmissionType' => 'Post',
                    'Status' => "Inpatient",
                    'UserAdded' => $this
                        ->auth
                        ->user()->id,
                    'DateAdded' => $current,
                    'DateModified' => $current,
                    'episodes' => 'Admission ' . $episodes,

                );

                $prev_admission_status = Admission::select('AdmissionId')
                                        ->where('BabyId', $input['BabyId'])
                                        ->where('Status', 'Inpatient')
                                        ->orderBy('AdmissionId', 'desc')
                                        ->first();
                if (count($prev_admission_status) != 0)
                {
                    $admission = $prev_admission_status;
                }
                else
                {
                    $admission = Admission::create($admission_data);
                }

                $discharge_details['AdmissionId'] = $input['AdmissionId'] = $admission->AdmissionId;

                $ipnumber['ip_number'] = $input['ip_number'];
                $ipnumber['AdmissionId'] = $input['AdmissionId'];
                $ipnumber['baby_id'] = $input['BabyId'];
                $ipnumber['status'] = 1;

                if (isset($input['ip_number']) && $input['ip_number'] != '' && !is_null($input['ip_number']))
                {
                    $prev_ip_status = IpNumber::where('ip_number', $input['ip_number'])->orderBy('id', 'desc')->first();
                    if (count($prev_ip_status) > 0) {
                        $ipnumber['DateModified'] =  Carbon::now();
                        $prev_ip_status->update($ipnumber);
                    } else {
                        $ipnumber['DateAdded'] =  Carbon::now();
                        IpNumber::create($ipnumber);
                    }
                }

                $post_detail = Postnatal::where('AdmissionId',$admission->AdmissionId)->where('IsDeleted', 0)->orderBy('pid', 'desc')->first();
                $post_discharge_detail = PostnatalDischarge::where('AdmissionId',$admission->AdmissionId)->where('IsDeleted', 0)->orderBy('posdisid', 'desc')->first();

                if (count($admission) > 0 && count($post_detail) > 0 && count($post_discharge_detail) > 0) {
                    $input['DateModified'] = $current->format('Y-m-d H:i:s');
                    $input['UserModified'] = $this
                        ->auth
                        ->user()->id;
                    $post_detail->update($input);
                    $post_discharge_detail->update($discharge_details);
                    $pid = $post_detail->pid;
                } else {
                    $pid = Postnatal::create($input)->pid;
                    PostnatalDischarge::create($discharge_details);
                }

            }
            else
            {

                $discharge_details['AdmissionId'] = $input['AdmissionId'];

                Admission::where('AdmissionId', $input['AdmissionId'])->update(['AdmissionType'=>'Post', 'Status'=>'Inpatient','DateModified' => $current]);

                $post_detail = Postnatal::where('AdmissionId', $input['AdmissionId'])->where('IsDeleted', 0)->orderBy('pid', 'desc')->first();
                $post_discharge_detail = PostnatalDischarge::where('AdmissionId', $input['AdmissionId'])->where('IsDeleted', 0)->orderBy('posdisid', 'desc')->first();

                if (count($post_detail) > 0 && count($post_discharge_detail) > 0) {
                    $input['DateModified'] = $current->format('Y-m-d H:i:s');
                    $input['UserModified'] = $this
                        ->auth
                        ->user()->id;
                    $post_detail->update($input);
                    $post_discharge_detail->update($discharge_details);
                    $pid = $post_detail->pid;
                } else {
                    $pid = Postnatal::create($input)->pid;
                    PostnatalDischarge::create($discharge_details);
                }
                $ipnumber['ip_number'] = $input['ip_number'];
                $ipnumber['DateModified'] = Carbon::now();

                IpNumber::where('AdmissionId', $input['AdmissionId'])->where('baby_id', $input['BabyId'])->update($ipnumber);
            }

            if (\Session::has('registration_start'))
            {
                $this->flow->flowlog('POST_FORM', $input['BabyId'], $input['MotherId'], $input['AdmissionId'], false);
            }

            $check_nicu_bed_log = \DB::table('patient_bed_log')
                                ->where('baby_id', $input['BabyId'])
                                ->where('admission_id', $input['AdmissionId'])
                                ->where('ward_name', 'NICU')
                                ->where('status', 'Occupied')
                                ->first();
            if (count($check_nicu_bed_log) != 0 && isset($check_nicu_bed_log->id)) {
                \DB::table('patient_bed_log')->where('id', $check_nicu_bed_log->id)->update(['status' => 'discharged', 'DateModified' => Carbon::now($this->zone), 'UserModified' => $this->auth->user()->id]);
                \DB::table('bed')->where('id', $check_nicu_bed_log->bed_id)->update(['status' => null]);
            }
            
            $check_bed_log = \DB::table('patient_bed_log')
                            ->where('baby_id', $input['BabyId'])
                            ->where('status', 'Occupied')
                            ->orderBy('id', 'desc')
                            ->first();
            if (count($check_bed_log) > 0) {
                // $ward_details['admission_id'] = $input['AdmissionId'];
                \DB::table('patient_bed_log')->where('id', $check_bed_log->id)->update(['admission_id' => $input['AdmissionId'], 'DateModified' => Carbon::now($this->zone), 'UserModified' => $this->auth->user()->id]);
            }

        }
        catch(Exception $e)
        {

            \DB::rollback();
        }

        \DB::commit();

        if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'Postnatal admission created successfully !', 'edit_url' => action('Admission\PostnatalController@edit', \SiteHelpers::encrypt_id($pid)), 'list_url' => action('Admission\PostnatalController@postnatalAdmissionlist', \SiteHelpers::encrypt_id($input['BabyId'])), 'print_url'=> action('Admission\PostnatalController@printData', \SiteHelpers::encrypt_id($pid))], 200);
        }

        if ($print_flag == 3)
        {
            $this->flow->flowlog('POST_FORM', $input['BabyId'], $input['MotherId'], $input['AdmissionId'], true);

            (\Session::has('registration_start')) ? \Session::forget('registration_start') : '';
            (\Session::has('admission_module')) ? \Session::forget('admission_module') : '';
            (\Session::has('current_module')) ? \Session::forget('current_module') : '';
            (\Session::has('ficd')) ? \Session::forget('ficd') : '';
            return redirect(action('Admission\PostnatalController@postnatalAdmissionlist', \SiteHelpers::encrypt_id($input['BabyId'])))->with('Success', 'Record updated successfully !');

        }
        elseif ($print_flag == 8 && isset($input['admission_tag']))
        {

            $admission_tag = ($input['admission_tag'] == 'NICU_MULTIPLE_PREGANANCY') ? 'NICU_ADMISSION' : 'POSTNATAL_ADMISSION';
            \Session::put('admission_module', $admission_tag);
            \Session::put('current_module', 'BABY_REG');
            $this
                ->flow
                ->flowlog('BABY_REG', 0, $input['MotherId'], 0, true, '');
            return redirect(action('Registration\BabyController@create', \Session::put('mother_id')))->with('Success', 'Record saved successfully !');

        }
        elseif ($print_flag == 5 || $print_flag == 4)
        {
            return redirect(action('Admission\PostnatalController@index'))->with('Success', 'Record saved successfully !');
        }
        elseif ($print_flag == 1)
        {
            return redirect(action('Admission\PostnatalController@printData', \SiteHelpers::encrypt_id($pid)))->with('Success', 'Record saved successfully !');
        }
        else
        {
            return redirect(action('Admission\PostnatalController@edit', \SiteHelpers::encrypt_id($pid)))->with('Success', 'Record saved successfully !');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id, Postnatal $postnatal)
    {
        if (($id != '0' || $id != 0) && $id !== 'undefined') {
            $id = \SiteHelpers::decrypt_id($id);
        } 
        else {
            return redirect()->back()
                    ->with('error', 'Please choose the baby');
        }

        if (count(explode('-', $id)) == 2)
        {
            $baby_id = explode('-', $id) [0];
            $admission_id = explode('-', $id) [1];

        }
        elseif ($id != 0)
        {
            $baby_id = $id;
            $admission_id = 0;

        }
        else
        {
            // throw new InvalidInputException(\SiteHelpers::getUserExceptionMessage('7002'), 7002);
            return redirect()->back()
                ->with('error', 'Please choose the baby');
        }

        $navigate['main_nav'] = 'postnatal';
        $navigate['sub_nav'] = 'postnatal_proforma';

        $baby_detais = Baby::find($baby_id);
        $currentTime = Carbon::now($this->zone);
        $baby_detais->admission_time_hour = (int)$currentTime->format('h');
        $baby_detais->admission_time_mins = (int)$currentTime->format('i');
        $baby_detais->admission_time_session = $currentTime->format('A');
        $baby_detais->admission_date = $currentTime->format('d-m-Y');

        if (count($baby_detais) > 0)
        {

            $dayoflife = \SiteHelpers::calculate_day_of_life($baby_detais->DOB);
            $gestationdays = \SiteHelpers::convert_gestation_days($baby_detais->Gestation);
            $correctedGestation = \SiteHelpers::calculate_corrected_gestation($gestationdays, $dayoflife);
            $baby_detais->cg_weeks = isset($correctedGestation[0]) ? $correctedGestation[0] : '';
            $baby_detais->cg_days = isset($correctedGestation[1]) ? $correctedGestation[1] : '';

        }

        $baby_admission = $baby_detais
            ->getBabyAdmisison
            ->where('AdmissionId', $admission_id)->toArray();
        $ip_number = IpNumber::where('AdmissionId', $admission_id)->select('ip_number')
            ->first();

        $baby_detais->ip_number = isset($ip_number->ip_number) ? $ip_number->ip_number : null;
        $timeList = \SiteHelpers::prepare_time();
        $doctorsList = DoctorMaster::ListData()->pluck('Name', 'id')
            ->toArray();
        $admissionmodeList = AdmissionmodeMaster::ListData();
        // $antibioticList = AntibioticMaster::get_lists()->pluck('Name', 'Id')
            // ->toArray();
        $icdList = Icd::GetList()->pluck('icdcode', 'id')
            ->toArray();
        $SubmitButtonText = 'Save & Close';
        $baby_detais->DOB = isset($baby_detais->DOB) ? date('d-m-Y', strtotime($baby_detais->DOB)) : '';
        $AdmissionId = $admission_id;
        $is_new_patient = false;
        if (\Session::has('ficd'))
        {
            $flowControl = FlowControl::find(\Session::get('ficd'));
            $is_new_patient = (isset($flowControl->is_new_patient)) ? $flowControl->is_new_patient : false;

        }
        elseif (count($baby_admission) == 0)
        {
            $is_new_patient  = true;
        }
        
        if (isset($this->auth->user()->mas_id) && !empty($this->auth->user()->mas_id)) {
            $baby_detais->seenby = $this->auth->user()->mas_id;
        }

        // return view('admission.postnatal.create', compact('timeList', 'navigate', 'doctorsList', 'is_new_patient', 'admissionmodeList', 'antibioticList', 'icdList', 'SubmitButtonText', 'baby_detais', 'baby_admission', 'AdmissionId'));
        return view('admission.postnatal.create', compact('timeList', 'navigate', 'doctorsList', 'is_new_patient', 'admissionmodeList', 'icdList', 'SubmitButtonText', 'baby_detais', 'baby_admission', 'AdmissionId'));
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

        $navigate['main_nav'] = 'postnatal';
        $navigate['sub_nav'] = 'postnatal_proforma';

        $postnatal = Postnatal::getBabydetalis($id);
        $timeList = \SiteHelpers::prepare_time();
        $doctorsList = DoctorMaster::ListData()->pluck('Name', 'id')
            ->toArray();
        $admissionmodeList = AdmissionmodeMaster::ListData();
        // $antibioticList = AntibioticMaster::get_lists()->pluck('Name', 'Id')
        //     ->toArray();
        $icdList = Icd::GetList()->pluck('icdcode', 'id')
            ->toArray();
        $SubmitButtonText = 'Update & Close';

        $postnatal->cg_weeks = isset(json_decode($postnatal->admission_cg)
            ->cg_weeks) ? json_decode($postnatal->admission_cg)->cg_weeks : '';
        $postnatal->cg_days = isset(json_decode($postnatal->admission_cg)
            ->cg_days) ? json_decode($postnatal->admission_cg)->cg_days : '';
        $postnatal->differentialdiagnosis = isset($postnatal->differentialdiagnosis) ? json_decode($postnatal->differentialdiagnosis) : '';
        $is_new_patient = false;

        if ($postnatal->episodes == 'Admission 1') {
            $is_new_patient = true;
        }
        if (\Session::has('ficd'))
        {
            $flowControl = FlowControl::find(\Session::get('ficd'));
            $is_new_patient = (isset($flowControl->is_new_patient)) ? $flowControl->is_new_patient : false;
        }
        $postnatal->DOB = (isset($postnatal->DOB) && !empty($postnatal->DOB)) ? date('d-m-Y', strtotime($postnatal->DOB)) : $postnatal->DOB;
        $postnatal->admission_date = (isset($postnatal->admission_date) && !empty($postnatal->admission_date)) ? date('d-m-Y', strtotime($postnatal->admission_date)) : $postnatal->admission_date;

        // return view('admission.postnatal.edit', compact('postnatal', 'timeList', 'is_new_patient', 'navigate', 'doctorsList', 'admissionmodeList', 'antibioticList', 'icdList', 'SubmitButtonText'));
        return view('admission.postnatal.edit', compact('postnatal', 'timeList', 'is_new_patient', 'navigate', 'doctorsList', 'admissionmodeList', 'icdList', 'SubmitButtonText'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Postnatal $postnatal)
    {
        $input = $request->all();
        $print_flag = $input['print_flag'];

        $types = array();
        foreach (array_keys($input) as $columnkey => $columnName)
        {

            $columnType = $postnatal->getColumnTypeUp($columnName);

            if ($columnType != false && $columnType == 'integer')
            {
                $types[] = $columnName;
                $input[$columnName] = (isset($input[$columnName]) && !empty($input[$columnName])) ? $input[$columnName] : null;

            }
            elseif ($columnType != false && $columnType == 'decimal')
            {

                $input[$columnName] = (isset($input[$columnName]) && !empty($input[$columnName])) ? $input[$columnName] : null;
            }

        }
        $input['g_weeks'] = (!empty($input['g_weeks'])) ? $input['g_weeks'] : null;
        $input['g_days'] = (!empty($input['g_days'])) ? $input['g_days'] : null;

        $input['DOB'] = (isset($input['DOB']) && !empty($input['DOB'])) ? date('Y-m-d', strtotime($input['DOB'])) : null;

        $input['cg_weeks'] = (!empty($input['cg_weeks'])) ? $input['cg_weeks'] : 0;
        $input['cg_days'] = (!empty($input['cg_days'])) ? $input['cg_days'] : 0;

        $input['admission_cg'] = json_encode(['cg_weeks' => $input['cg_weeks'], 'cg_days' => $input['cg_days']]);
        $input['DifferentialDiagnosis'] = !empty($input['DifferentialDiagnosis']) ? json_encode($input['DifferentialDiagnosis']) : '';

        $input['admission_date'] = date('Y-m-d', strtotime($input['admission_date']));
        $input['ventilation'] = (isset($input['ventilation']) && $input['ventilation'] == 'on') ? true : false;
        $input['uac_status'] = (isset($input['uac_status']) && $input['uac_status'] == 'on') ? true : false;
        $input['uvc_status'] = (isset($input['uvc_status']) && $input['uvc_status'] == 'on') ? true : false;
        $input['admission_time_hour'] = (!isset($input['admission_time_hour']) || empty($input['admission_time_hour'])) ? null : $input['admission_time_hour'];
        $input['admission_time_mins'] = (!isset($input['admission_time_mins']) || empty($input['admission_time_mins'])) ? null : $input['admission_time_mins'];
        $input['admission_time_session'] = (!isset($input['admission_time_session']) || empty($input['admission_time_session'])) ? null : $input['admission_time_session'];

        $input['ivantibiotic'] = isset($input['ivantibiotic']) ? json_encode($input['ivantibiotic']) : json_encode(array());
        $input['differentialdiagnosis'] = isset($input['differentialdiagnosis']) ? json_encode($input['differentialdiagnosis']) : json_encode(array());
        $input['additional_diagnosis'] = isset($input['additional_diagnosis']) ? json_encode($input['additional_diagnosis']) : json_encode(array());
        $input['parents_spoken'] = (isset($input['parents_spoken']) && $input['parents_spoken'] == 'on') ? true : false;

        $current = Carbon::now($this->zone);

        $input['DateModified'] = $current;
        $input['UserModified'] = $this
            ->auth
            ->user()->id;

        if (isset($input['BabyId']))
        {
            $baby = Baby::find($input['BabyId']);
            $baby->update($input);
        }

        $postnatalAdmission = Postnatal::find($id);

        if (count($postnatalAdmission) > 0)
        {

            $postnatalAdmission->update($input);
        }

        $babyAdmisson = Admission::find($input['AdmissionId']);

        $Ipnumber = IpNumber::where('AdmissionId', $input['AdmissionId'])->first();

        if (count($Ipnumber) > 0)
        {

            $ipnumber['ip_number'] = $input['ip_number'];
            $ipnumber['DateModified'] =  Carbon::now();
            IpNumber::where('AdmissionId', $input['AdmissionId'])->update($ipnumber);

        }
        else
        {

            $ipnumber['ip_number'] = $input['ip_number'];
            $ipnumber['AdmissionId'] = $input['AdmissionId'];
            $ipnumber['baby_id'] = $input['BabyId'];
            $ipnumber['status'] = 1;
            $ipnumber['DateAdded'] =  Carbon::now();
            if (isset($input['ip_number']) && $input['ip_number'] != '' && !is_null($input['ip_number']))
            {
                IpNumber::create($ipnumber);
            }

        }

        if (count($babyAdmisson) > 0)
        {
            if (!is_null($input['admission_time_hour']))
            {
                $admissionTime = $input['admission_time_hour'] . ':' . $input['admission_time_mins'] . ':' . $input['admission_time_session'];
            }
            else
            {
                $admissionTime = null;
            }
            $admission_data = array(
                'BMrNo' => $baby['BMrNo'],
                'AdmissionDate' => $input['admission_date'],
                'AdmissionTime' => $admissionTime,
                'DateModified' => $current,
            );
            $babyAdmisson->Update($admission_data);
        }

        $neonatal_id = Neonatal::where('BabyId', $input['BabyId'])->select('NeonatalId')
            ->where('IsDeleted', 0)
            ->first();

        if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'Postnatal admission created successfully !', 'edit_url' => action('Admission\PostnatalController@edit', \SiteHelpers::encrypt_id($id)), 'list_url' =>action('Admission\PostnatalController@postnatalAdmissionlist', \SiteHelpers::encrypt_id($input['BabyId'])), 'print_url'=> action('Admission\PostnatalController@printData', \SiteHelpers::encrypt_id($id))], 200);
        }
        if ($print_flag == 1)
        {

            $this
                ->flow
                ->flowlog('POST_FORM', $input['BabyId'], $input['MotherId'], $input['AdmissionId'], true);

            (\Session::has('registration_start')) ? \Session::forget('registration_start') : '';
            (\Session::has('admission_module')) ? \Session::forget('admission_module') : '';
            (\Session::has('current_module')) ? \Session::forget('current_module') : '';
            (\Session::has('ficd')) ? \Session::forget('ficd') : '';

            return redirect(action('Admission\PostnatalController@postnatalAdmissionlist', \SiteHelpers::encrypt_id($input['BabyId'])))->with('Success', 'Record updated successfully !');

        }
        elseif ($print_flag == 2)
        {
            return redirect(action('Admission\PostnatalController@edit', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully !');
        }
        elseif ($print_flag == 3)
        {
            if (isset($babyAdmisson->episodes) && $babyAdmisson->episodes == 'Admission 1')
            {
                return redirect(action('Registration\NeonatalController@show', \SiteHelpers::encrypt_id($neonatal_id->NeonatalId)))
                    ->with('Success', 'Record updated successfully !');
            }
            else
            {
                return redirect(action('Admission\PostnatalController@printData', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully !');
            }

        }
        elseif ($print_flag == 8 && isset($input['admission_tag']))
        {

            $admission_tag = ($input['admission_tag'] == 'NICU_MULTIPLE_PREGANANCY') ? 'NICU_ADMISSION' : 'POSTNATAL_ADMISSION';
            \Session::put('admission_module', $admission_tag);
            \Session::put('current_module', 'BABY_REG');
            $this
                ->flow
                ->flowlog('BABY_REG', 0, $input['MotherId'], 0, true, '');
            return redirect(action('Registration\BabyController@create', \Session::put('mother_id')))->with('Success', 'Record updated successfully !');

        }

        return redirect(action('Admission\PostnatalController@edit', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully !');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $results = Postnatal::findOrfail($id);
        $discharge_details = PostnatalDischarge::where('BabyId', $results->BabyId)
            ->where('MotherId', $results->MotherId)
            ->where('AdmissionId', $results->AdmissionId)
            ->where('IsDeleted', 0)
            ->first();

        $user_detail = array(
            'UserDeleted' => $this
                ->auth
                ->user()->id,
            'DateModified' => Carbon::now($this->zone) ,
            'IsDeleted' => '1'
        );

        $baby = Baby::find($results->BabyId);

        if (isset($discharge_details->posdisid))
        {
            $discharge_results = PostnatalDischarge::findOrfail($discharge_details->posdisid);
            $discharge_results->update($user_detail);

        }
        $delete_data = array(
            'Name' => $baby['BabyName'],
            'ModuleController' => 'Admission\PostnatalController',
            'ModuleId' => $id,
            'ModuleName' => 'Postnatal Admission',
            'UserDeleted' => $this
                ->auth
                ->user()->id,
            'DateDeleted' => Carbon::now($this->zone) ,
            'SubModuleId' => $discharge_details->posdisid
        );
        $results->update($user_detail);
        DeleteApproval::create($delete_data);

        return redirect(action('Admission\PostnatalController@index'))->with('info', 'Record deleted successfully !');

    }

    public function printData($id)
    {
        $id = \SiteHelpers::decrypt_id($id);
        
        $postnatalAdmission = Postnatal::getAdmissionprint($id);
        $editor_gen_option = false;
        if (isset($postnatalAdmission->BabyId) && isset($postnatalAdmission->MotherId))
        {

            $matarnalHistory = Problems::getProblems($postnatalAdmission->BabyId)
                ->toArray();
            $matarnalProblemmaster = MediprobsMaster::ListData()->pluck('Name', 'id')
                ->toArray();
            $delivery_details = Delivery::GetList($postnatalAdmission->MotherId);
            $ultrascanGestation = Usg::GetList($postnatalAdmission->BabyId, $postnatalAdmission->MotherId);
            $complicationMaster = Complications::ListData()->pluck('Name', 'Id')
                ->toArray();
            $preganancyComplication = Complication::GetList($postnatalAdmission->BabyId);
            $doctorsList = DoctorMaster::ListData()->pluck('Name', 'id')
                ->toArray();
            $icd_master = Icd::GetList()->pluck('ICDDescription', 'id');

            $indication = array();
            $indication_id = array();

            foreach (json_decode($postnatalAdmission->Indication) as $key => $value)
            {
                if (!empty($value) && $value != 'N/A')
                {
                    $indication_id[] = $value;
                }

            }
            if (count($indication_id) > 0 && !in_array('N/A', $indication_id) && !in_array('undefined', $indication_id) && !in_array(' ', $indication_id))
            {
                $indication = Indication::whereIn('Id', $indication_id)->pluck('indication_name')
                    ->toArray();
            }

        }
        else
        {
            throw new InvalidInputException(\SiteHelpers::getUserExceptionMessage(7012) , 7012);
        }
        $closewinlink = action('Admission\PostnatalController@index');

        $editor_gen_option = $postnatalAdmission->post_content == NULL ? 1 : 0;
        $editor_gen = false;

        $ip_details = IpNumber::getCurrent_ip($postnatalAdmission->BabyId, $postnatalAdmission->admission_id);

        // $postnatalAdmission->neonatal_consultant = \SiteHelpers::formating_consultant_signature($postnatalAdmission->neonatal_consultant, false, $postnatalAdmission->hospital_name);
        $postnatalAdmission->neonatal_consultant = \ValuelistHelpers::signatureFormat($postnatalAdmission->neonatal_consultant);
        
        if (\Session::has('post-adm-editor'))
        {
            \Session::forget('post-adm-editor');
            $editor_gen = true;
            return view('admission.postnatal.print', compact('postnatalAdmission', 'closewinlink', 'icd_master', 'matarnalHistory', 'doctorsList', 'matarnalProblemmaster', 'delivery_details', 'ultrascanGestation', 'complicationMaster', 'preganancyComplication', 'indication', 'editor_gen', 'editor_gen_option', 'ip_details'))->renderSections();
        }
        return view('admission.postnatal.print', compact('postnatalAdmission', 'closewinlink', 'icd_master', 'matarnalHistory', 'doctorsList', 'matarnalProblemmaster', 'delivery_details', 'ultrascanGestation', 'complicationMaster', 'preganancyComplication', 'indication', 'editor_gen_option', 'ip_details'));
    }

    /**
     * return the admission list .
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function postnatalBabyadmission($baby_id)
    {
        $baby_id = \SiteHelpers::decrypt_id($baby_id);

        $temp_admissionList = Postnatal::GetAdmissionList($baby_id)->pluck('episodes', 'create_id')
        ->toArray();
        foreach ($temp_admissionList as $key => $value) {
            $admissionList[\SiteHelpers::encrypt_id($key)] = $value;
        }
        $admissionList[\SiteHelpers::encrypt_id($baby_id)] = 0;
        if (count($admissionList) > 0)
        {
            return \Response::json(['status' => true, 'message' => $admissionList], 200);
        }
        else
        {
            return \Response::json(['status' => false, 'message' => $admissionList], 200);
        }
    }

    /**
     * OPEN REPORT WITH FULL EDITOR
     *
     */
    public function getfullEditor(Request $request)
    {
        $input = $request->all();
        \Session::put('post-adm-editor', true);
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

        $post = Postnatal::findOrfail($input['post_id']);

        $post->update(['edited' => true, 'edited_content' => $input['post_report'], 'edited_time' => Carbon::now($this->zone) ]);

        // create slug for updated
        $post_id = $input['post_id'];

        if ($request->ajax())
        {
            return \Response::json(['type' => 'success', 'msg' => 'Record Updated Successfully']);
        }
        else
        {
            return redirect(action('Admission\PostnatalController@getAbbreviatedsummaryShow', $post_id))->with('success', 'Record updated successfully');
        }

    }

    public function getAbbreviatedsummaryShow(Request $request, $id)
    {
        $id_list = $id;

        $dischargeSummarymodified = array();

        if (isset($id_list) && !empty($id_list))
        {

            $dischage_summary['post_id'] = $post_id = $id_list;

        }
        else
        {

            return redirect(url('/'))->with('error', 'Invalid record');

        }

        $post = Postnatal::findOrfail($id_list);

        // $completed = false;
        \Session::put('post-adm-editor', true);

        if (count($post) > 0 && !empty($post['edited_content']))
        {
            $discharge_details['content'] = $post['edited_content'];
            // $completed = $post['edited'];
            
        }
        else
        {
            $discharge_details = $this->printData($id);
        }

        $editor_gen = false;
        \Session::forget('post-adm-editor');

        return view('admission.postnatal.editor', compact('discharge_details', 'dischargeSummarymodified', 'dischage_summary'));
    }

}

