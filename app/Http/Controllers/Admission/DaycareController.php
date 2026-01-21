<?php
namespace App\Http\Controllers\admission;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\Admissions\NicudayRequest;
use App\Models\Antibiotic;
use App\Models\Baby;
use App\Models\Daycare;
use App\Models\DaycareQuestions;
use App\Models\Fluid;
use App\Models\Icd;
use App\Models\Settings\DeleteApproval;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Models\Mother;
use App\Models\Masters\DoctorMaster;
use App\Models\Masters\AutoTagMasters;
use App\Models\Masters\RespiratoryIndication;
use App\Models\ReferalSmsDoc;
use App\Http\Controllers\Sms\SmsController;
use App\Models\DaycareReassessmentSheets;
use App\Http\Controllers\Flow\FlowController;
use App\Models\Nicu;
use App\Models\Admission;
use App\Models\Nurse\EmrLogHeader;
use App\Models\Nurse\EmrMoniterValues;
use App\Models\Nurse\EmrVentilatorValues;
use App\Models\prescription;
use App\Http\Controllers\Nurse\DialpadSupportProperty;
use App\Models\FileUpload;
use App\Models\IpNumber;
use App\Models\Nurse\NurseSheetMain;

class DaycareController extends Controller
{
    /**
     *@var $auto_tag_fields
     */
    public $auto_tag_fields;

    /**
     *@var $sms
     */
    public $sms;

    /**
     * Initiate the required instance.
     *
     * @param $auth instance of  Illuminate\Contracts\Auth\Guard
     *
     * @return Response
     */
    public function __construct(Guard $auth, FlowController $flow)
    {
        $this->middleware('role:NICU_DAY,write', ['only' => ['store', 'update', 'edit', 'create', 'show', 'destroy']]);
        $this->middleware('role:NICU_DAY,read', ['only' => ['index', 'printData']]);
        $this->auth = $auth;
        $this->auto_tag_fields = array(
            'mri_ct_brain',
            'Background',
            'RSFindings',
            'CXRFindings',
            'DayEcho',
            'CVSFindings',
            'CnsFindings',
            'Cuss',
            'Skin',
            'Rop',
            'Plan',
            'Notes',
            'ultrasoundkeyfindings',
            'renalultrasoundkeyfindings'
        );
        $this->sms = new SmsController();
        $this->flow = $flow;
        $this->zone = env('TIME_ZONE');
        $this->file_path = url('/') . '/public/img/nicu_daycare/upload/';
    }

    /**
     * Display a listing of daycare sheets.
     *
     * @return Response
     */
    public function index(Request $request)
    {

        $limit = 50;
        if (!empty($request->input('limit'))) {
            $request->session()
                ->put('limit', $request->input('limit'));
            $limit = $request->session()
                ->get('limit');
        } elseif (
            $request->session()
                ->has('limit')
        ) {
            $limit = $request->session()
                ->get('limit');
        }

        $order['sortby'] = 'baby.BabyId';
        $order['sortorder'] = 'desc';
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {
            $order['sortby'] = \SiteHelpers::decrypt_id($request->input('sortby'));
            $order['sortorder'] = $request->input('sortorder');
        }

        $search = array();
        $search['search_txt'] = '';
        if (!empty($request->input('search_txt'))) {
            $search['search_txt'] = $request->input('search_txt');
        }

        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'nicu_daycare';

        $status = !empty($request->input('status')) ? $request->input('status') : 'inpatient';

        $page = !empty($request->input('page')) ? $request->input('page') : 1;
        $page = preg_replace('/[^0-9]/', '', $page);

        $result = Daycare::get_lists($page, $limit, $search, $order, 1, $status);
        $results = $result['result'];

        $getTotal = Daycare::GetTotal();
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

        foreach ($results as $key => $value) {
            $results[$key]->rowcolor = '';
            if (trim($results[$key]->status) == 'Inpatient') {
                $results[$key]->rowcolor = 'info';
            } else {
                $results[$key]->rowcolor = 'success';
            }

        }
        $this
            ->flow
            ->clearFlow();

        return view('daycare.list', compact('results', 'navigate', 'pagination', 'order', 'search', 'getTotal'));
    }

    //Admission list
    public function daycareBabysubList($id)
    {
        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'nicu_daycare';
        $BabyId = \SiteHelpers::decrypt_id($id);
        $results = Daycare::get_baby_list($BabyId);
        $total = Daycare::GetTotal();
        $babyName = isset($results[0]->BabyName) ? $results[0]->BabyName : '';
        $babyId = isset($results[0]->BabyId) ? $results[0]->BabyId : '0';
        $bmrno = isset($results[0]->BMrNo) ? $results[0]->BMrNo : '0';

        return view('daycare.daycare_baby_sublist', compact('results', 'navigate', 'babyName', 'babyId', 'bmrno'));
    }

    //daywise lists
    public function daycareAdmissionDaylist($id, Request $request)
    {
        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'nicu_daycare';
        $flow_wise_register = $request->get('flow');
        $admission_id = \SiteHelpers::decrypt_id($id);
        $results = Daycare::get_admission_list($admission_id);
        $total = Daycare::GetTotal();
        $baby_details = Admission::getBabyMrn($admission_id);

        $babyName = isset($baby_details->BabyName) ? $baby_details->BabyName : '';
        $babyId = isset($baby_details->BabyId) ? $baby_details->BabyId : '0';
        $episodes = isset($results[0]->episodes) ? $results[0]->episodes : '';
        $bmrno = isset($results[0]->BMrNo) ? $results[0]->BMrNo : '0';
        $visit_ids = $results->pluck('DayId');
        $file_list = FileUpload::getList($visit_ids, 4);
        return view('daycare.daycare_admission_daylist', compact('results', 'bmrno', 'navigate', 'babyName', 'admission_id', 'babyId', 'episodes', 'flow_wise_register', 'file_list'));

    }

    /**
     * Display the admitted babies for daycare creation
     *
     */
    public function create($module_type = '')
    {
        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'nicu_daycare';
        $daycareSlug = \Session::get('daycare-create-slug');
        $daycarebabyid = (\Session::has('daycare-baby-id')) ? \Session::get('daycare-baby-id') : '0';

        $baby = Daycare::baby_list_daycare();

        if (($baby) > 0) {
            $babies = array(
                '0' => '- - Please select the baby - -'
            );
            foreach ($baby as $data) {
                $babies[\SiteHelpers::encrypt_id($data->BabyId)] = $data->BabyName . '-' . $data->BMrNo;
            }
        } else {

            $babies = array(
                '0' => 'No Record Found'
            );
        }

        $SubmitButtonText = "Start";

        return view('daycare.select_patient', compact('SubmitButtonText', 'babies', 'navigate', 'module_type'));
    }

    /**
     * Store a newly created record in storage.
     *
     * @return Response
     */
    public function store(NicudayRequest $request)
    {
        $input = $request->all();
        $print_flag = isset($input['print_flag']) ? $input['print_flag'] : 0;
        unset($input['print_flag']);
        unset($input['central_temp_farenheit']);
        unset($input['peripheral_fahrenheit']);

        $input['Surfactant_therapy_nicu'] = (isset($input['Surfactant_therapy_nicu']) && $input['Surfactant_therapy_nicu'] == 'on') ? 'Yes' : 'No';

        $input['directlybreastfeed'] = (isset($input['directlybreastfeed']) && $input['directlybreastfeed'] == 'on') ? 1 : 0;

        $input['othertypefeed'] = (isset($input['othertypefeed']) && $input['othertypefeed'] == 'on') ? 1 : 0;

        $input['Stools'] = (isset($input['Stools']) && $input['Stools'] == 'on') ? 'Bowels opened' : 'Bowels not opened';

        $input['needlethoracentesis'] = (isset($input['needlethoracentesis']) && $input['needlethoracentesis'] == 'on') ? 2 : 1;

        $input['intercostaldrain'] = (isset($input['intercostaldrain']) && $input['intercostaldrain'] == 'on') ? 2 : 1;

        $input['ultrasoundabdominal'] = (isset($input['ultrasoundabdominal']) && $input['ultrasoundabdominal'] == 'on') ? 2 : 1;

        $input['chronic_lung'] = (isset($input['chronic_lung']) && $input['chronic_lung'] == 'on') ? 2 : 1;

        $input['renalultrasound'] = (isset($input['renalultrasound']) && $input['renalultrasound'] == 'on') ? 2 : 1;

        $input['surfactant_indication'] = (isset($input['surfactant_indication'])) ? serialize($input['surfactant_indication']) : serialize(array());

        $input['cg_weeks'] = (isset($input['cg_weeks']) && $input['cg_weeks'] != '') ? $input['cg_weeks'] : 0;
        $input['cg_days'] = (isset($input['cg_days']) && $input['cg_days'] != '') ? $input['cg_days'] : 0;

        $input['CGA'] = json_encode(array(
            'cg_weeks' => $input['cg_weeks'],
            'cg_days' => $input['cg_days']
        ));

        $input['diastolic_bp'] = (isset($input['diastolic_bp']) && !empty($input['diastolic_bp'])) ? $input['diastolic_bp'] : null;

        $input['systolic_bp'] = (isset($input['systolic_bp']) && !empty($input['systolic_bp'])) ? $input['systolic_bp'] : null;

        AutoTagMasters::auto_key_support($this->auto_tag_fields, $input);

        $input['DayDate'] = date('Y-m-d', strtotime($input['DayDate']));

        $input['OtherDrugs'] = (isset($input['drugs'])) ? serialize($input['drugs']) : serialize(array());

        $setNicuICD = array();

        $setNicuICD['ResICD'] = !empty($input['ResICD']) ? $input['ResICD'] : array();

        $setNicuICD['CarICD'] = !empty($input['CarICD']) ? $input['CarICD'] : array();

        $setNicuICD['GasICD'] = !empty($input['GasICD']) ? $input['GasICD'] : array();

        $setNicuICD['CenICD'] = !empty($input['CenICD']) ? $input['CenICD'] : array();

        $setNicuICD['FluidICD'] = !empty($input['FluidICD']) ? $input['FluidICD'] : array();

        $setNicuICD['SepsisICD'] = !empty($input['SepsisICD']) ? $input['SepsisICD'] : array();

        $setNicuICD['SkinICD'] = !empty($input['SkinICD']) ? $input['SkinICD'] : array();

        $setNicuICD['RopICD'] = !empty($input['RopICD']) ? $input['RopICD'] : array();

        $input['NicuICD'] = json_encode($setNicuICD);

        $input['Indication'] = (isset($input['Indication'])) ? serialize($input['Indication']) : serialize(array());

        $input['LastBG_Time'] = (strlen($input['LastBG_Time']) == 1) ? '0' . $input['LastBG_Time'] : $input['LastBG_Time'];

        $input['LastBG_Time_MINS'] = (strlen($input['LastBG_Time_MINS']) == 1) ? '0' . $input['LastBG_Time_MINS'] : $input['LastBG_Time_MINS'];

        $input['LastBG'] = $input['LastBG_Time'] . ':' . $input['LastBG_Time_MINS'] . ':' . $input['LastBG_Time_AM'];

        $input['neuro_sonogram'] = (isset($input['neuro_sonogram']) && $input['neuro_sonogram'] == 'on') ? 'performed' : 'Not performed';

        $input['mrict_brain_status'] = (isset($input['mrict_brain_status']) && $input['mrict_brain_status'] == 'on') ? 2 : 1;

        $input['viral_meningitis'] = (isset($input['viral_meningitis']) && $input['viral_meningitis'] == 'on') ? 2 : 1;

        //$input['lumbar_puncture']    = ((isset($input['lumbar_puncture']) && $input['lumbar_puncture']) == 'on') ? 2 : 1 ;
        $input['ultrasound_spine'] = (isset($input['ultrasound_spine']) && $input['ultrasound_spine'] == 'on') ? 2 : 1;

        $input['eeg_cfm'] = (isset($input['eeg_cfm']) && $input['eeg_cfm'] == 'on') ? 2 : 1;

        $input['eeg_cfm_report'] = isset($input['eeg_cfm_report']) ? $input['eeg_cfm_report'] : '';

        $input['dilution_exchange'] = (isset($input['dilution_exchange']) && $input['dilution_exchange'] == 'on') ? 2 : 1;

        $input['pvc_number'] = empty($input['pvc_number']) ? null : $input['pvc_number'];

        $day_name = Daycare::where(['BabyId' => $input['BabyId'], 'AdmissionId' => $input['AdmissionId'], 'IsDeleted' => 0])->count();

        $input['Carbohydrates'] = isset($input['Carbohydrates']) ? $input['Carbohydrates'] : '';

        $input['Protein'] = isset($input['Protein']) ? $input['Protein'] : '';

        $input['Fat'] = isset($input['Fat']) ? $input['Fat'] : '';

        $input['total_energy'] = isset($input['total_energy']) ? $input['total_energy'] : '';

        $input['ultrasoundkeyfindings'] = isset($input['ultrasoundkeyfindings']) ? $input['ultrasoundkeyfindings'] : '';

        $input['renalultrasoundkeyfindings'] = isset($input['renalultrasoundkeyfindings']) ? $input['renalultrasoundkeyfindings'] : '';
        $input['mri_ct_brain'] = isset($input['mri_ct_brain']) ? $input['mri_ct_brain'] : '';

        $input['Organism'] = isset($input['Organism']) ? serialize($input['Organism']) : serialize(array());

        $input['day_name'] = 'Day ' . ($day_name + 1);

        $input['MeanBP'] = !empty($input['MeanBP']) ? $input['MeanBP'] : null;
        $input['pip_set'] = !empty($input['pip_set']) ? $input['pip_set'] : null;
        $input['pip_delivered'] = !empty($input['pip_delivered']) ? $input['pip_delivered'] : null;
        $input['PEEP'] = !empty($input['PEEP']) ? $input['PEEP'] : null;
        $input['MAP'] = !empty($input['MAP']) ? $input['MAP'] : null;
        $input['fio2_set'] = !empty($input['fio2_set']) ? $input['fio2_set'] : null;
        $input['fio2_delivered'] = !empty($input['fio2_delivered']) ? $input['fio2_delivered'] : null;
        $input['Rate'] = !empty($input['Rate']) ? $input['Rate'] : null;
        $input['frequency_rep'] = !empty($input['frequency_rep']) ? $input['frequency_rep'] : null;
        $input['RR'] = !empty($input['RR']) ? $input['RR'] : null;
        $input['SaO2PostDuctal'] = !empty($input['SaO2PostDuctal']) ? $input['SaO2PostDuctal'] : null;
        $input['Feeds'] = !empty($input['Feeds']) ? $input['Feeds'] : null;
        $input['urine_output_day'] = !empty($input['urine_output_day']) ? $input['urine_output_day'] : '';
        $input['UO'] = !empty($input['UO']) ? $input['UO'] : null;
        $input['BloodOut'] = !empty($input['BloodOut']) ? $input['BloodOut'] : null;
        $input['gir'] = !empty($input['gir']) ? $input['gir'] : null;
        $input['seenby'] = isset($input['seenby']) ? json_encode($input['seenby']) : null;
        $input['Care'] = isset($input['Care']) && !empty($input['Care']) ? $input['Care'] : null;
        $input['head_circumference'] = isset($input['head_circumference']) && !empty($input['head_circumference']) ? $input['head_circumference'] : null;
        $input['length'] = isset($input['length']) && !empty($input['length']) ? $input['length'] : null;
        $input['amplitude'] = isset($input['amplitude']) && !empty($input['amplitude']) ? $input['amplitude'] : null;

        $prev_daycare_status = Daycare::where(['BabyId' => $input['BabyId'], 'AdmissionId' => $input['AdmissionId'], 'IsDeleted' => 0, 'DayDate' => $input['DayDate']])->first();

        $input['Hypoglycemia'] = (isset($input['Hypoglycemia']) && $input['Hypoglycemia'] == 'on') ? 1 : 0;

        $input['DateModified'] = Carbon::now();
        $input['UserModified'] = $this->auth->user()->id;
        $daycare = (object) [];
        if (count($prev_daycare_status) > 0) {
            $prev_daycare_status->update($input);
            $daycare->DayId = $prev_daycare_status->DayId;
        } else {
            $input['DateAdded'] = Carbon::now();
            $input['UserAdded'] = $this->auth->user()->id;
            $daycare = Daycare::create($input);
        }
        $result = Daycare::get_record($daycare->DayId);

        $results = $result[0];

        $day_question = array(
            'respiratory_problem' => $input['respiratory_problem'],
            'Cardiovascular_problem' => $input['Cardiovascular_problem'],
            'directlybreastfeed' => $input['directlybreastfeed'],
            'othertypefeed' => $input['othertypefeed'],
            'workingWeight' => $input['workingWeight'],
            'iv_fluids' => isset($input['iv_fluids']) ? $input['iv_fluids'] : null,
            'drug_infusions' => isset($input['drug_infusions']) ? $input['drug_infusions'] : 0,
            'other_drugs' => $input['other_drugs'],
            'Carbohydrates' => $input['Carbohydrates'],
            'Protein' => $input['Protein'],
            'Fat' => $input['Fat'],
            'sedation_paralysis' => $input['sedation_paralysis'],
            'central_problem' => $input['central_problem'],
            'UserAdded' => $this
                ->auth
                ->user()->id,
            'DateAdded' => Carbon::now(),
            'DayId' => $daycare->DayId,
            'MotherId' => $results->MotherId,
            'Pupils' => $input['Pupils'],
            'iv_fluids_ml_day' => isset($input['iv_fluids_ml_day']) ? $input['iv_fluids_ml_day'] : null,
            'drug_infusions_ml_day' => isset($input['drug_infusions_ml_day']) ? $input['drug_infusions_ml_day'] : null,
            'urine_output_day' => $input['urine_output_day'],
            'total_energy' => $input['total_energy'],
            'neuro_sonogram' => $input['neuro_sonogram'],
            'gir' => $input['gir'],
            'needlethoracentesis' => $input['needlethoracentesis'],
            'intercostaldrain' => $input['intercostaldrain'],
            'ultrasoundabdominal' => $input['ultrasoundabdominal'],
            'ultrasoundkeyfindings' => $input['ultrasoundkeyfindings'],
            'renalultrasound' => $input['renalultrasound'],
            'renalultrasoundkeyfindings' => $input['renalultrasoundkeyfindings'],
            'mrict_brain_status' => $input['mrict_brain_status'],
            'mri_ct_brain' => $input['mri_ct_brain'],
            'viral_meningitis' => $input['viral_meningitis'],
            'lumbar_puncture' => $input['lumbar_puncture'],
            'ultrasound_spine' => $input['ultrasound_spine'],
            'ultrasound_spine_report' => isset($input['ultrasound_spine_report']) ? $input['ultrasound_spine_report'] : '',
            'eeg_cfm' => $input['eeg_cfm'],
            'eeg_cfm_report' => $input['eeg_cfm_report'],
            'dilution_exchange' => $input['dilution_exchange'],
            'AdmissionId' => $results->AdmissionId
        );
        DaycareQuestions::Create($day_question);

        if (isset($input['A_Antibiotic'])) {

            $length = count($input['A_Antibiotic']);

            for ($i = 0; $i < $length; $i++) {

                if (!empty($input['A_Antibiotic'][$i])) {

                    $pbms = array(
                        'Antibiotic' => $input['A_Antibiotic'][$i],
                        'Day' => $input['A_Day'][$i],
                        'DayId' => $daycare->DayId,
                        'BabyId' => $input['BabyId'],
                        'AdmissionId' => $results->AdmissionId
                    );

                    Antibiotic::create($pbms);
                }

            }
        }
        if (isset($input['F_Product'])) {

            $length1 = count($input['F_Product']);

            for ($i = 0; $i < $length1; $i++) {

                $pbms1 = array(
                    'Product' => $input['F_Product'][$i],
                    'Volume' => $input['F_Volume'][$i],
                    'DayId' => $daycare->DayId,
                    'BabyId' => $input['BabyId'],
                    'AdmissionId' => $results->AdmissionId
                );

                Fluid::create($pbms1);
            }
        }

        $module = \Session::has('admission_module') ? \Session::get('admission_module') : 'NICU_DAILY_CARE';
        $menu = isset($_COOKIE['daycare']) ? $_COOKIE['daycare'] : 'generalform';
        $daycare_edit_url = '';
        if (isset($input['flow_wise_register']) && $input['flow_wise_register'] == 'from-dashboard') {
            $daycare_edit_url = action('Admission\DaycareController@edit', \SiteHelpers::encrypt_id($daycare->DayId)) . '?flow=from-dashboard';
            $daycare_edit_next_url = action('Admission\DaycareController@edit', \SiteHelpers::encrypt_id($daycare->DayId)) . '?flow=from-dashboard#resform';
        } else {
            $daycare_edit_url = action('Admission\DaycareController@edit', \SiteHelpers::encrypt_id($daycare->DayId));
            $daycare_edit_next_url = action('Admission\DaycareController@edit', \SiteHelpers::encrypt_id($daycare->DayId)) . '#resform';
        }

        // Nicu dashboard data updating call
        \SiteHelpers::updateDashboardAtFormUpdation($input['BabyId'], 'NICU Daycare');

        if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'Daycare details created successfully !', 'edit_url' => $daycare_edit_url, 'list_url' => action('Admission\DaycareController@daycareAdmissionDaylist', \SiteHelpers::encrypt_id($results->AdmissionId)), 'print_url' => action('Admission\DaycareController@printData', \SiteHelpers::encrypt_id($daycare->DayId)), 'ward_dashboard_url' => url('ward-dashboard'), 'daycare_edit_next_url' => $daycare_edit_next_url], 200);
        }

        if ($print_flag == 1) {

            $this
                ->flow
                ->flowlog($module, $results->BabyId, $results->MotherId, $results->AdmissionId, false, $menu, $daycare->DayId);
            return redirect(action('Admission\DaycareController@printData', \SiteHelpers::encrypt_id($daycare->DayId)))
                ->with('Success', 'Record saved successfully');

        } elseif ($print_flag == 2) {

            $this
                ->flow
                ->flowlog($module, $results->BabyId, $results->MotherId, $results->AdmissionId, false, $menu, $daycare->DayId);
            return redirect(action('Admission\DaycareController@edit', \SiteHelpers::encrypt_id($daycare->DayId)))
                ->with('Success', 'Record saved successfully');

        } else {

            $this
                ->flow
                ->flowlog($module, $results->BabyId, $results->MotherId, $results->AdmissionId, true, $menu, $daycare->DayId);
            $this
                ->flow
                ->clearFlow();
            return redirect(action('Admission\DaycareController@daycareAdmissionDaylist', \SiteHelpers::encrypt_id($results->AdmissionId)))
                ->with('Success', 'Record saved successfully');

        }
    }

    /**
     * Display the daycare sheet form of the choosen baby.
     *
     * @param  integer $id
     */
    public function show($id, Request $request)
    {
        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'nicu_daycare';

        $flow_wise_register = $request->get('flow');
        $id = \SiteHelpers::decrypt_id($id);
        if ($id == 0) {
            return redirect()->back();
        }

        if (strrpos($id, '-') > 0) {
            $data_ids = explode('-', $id);
            $id = $data_ids[1];
            $AdmissionId = $data_ids[0];
        } else {

            return redirect()->back();
        }

        $baby = Baby::find($id);
        $previous_daycare = Daycare::get_pervious_daycare($id, $AdmissionId);
        $already_filled_days = Daycare::getBabyDates($id, $AdmissionId);

        $antibiotic = array();
        if (count($previous_daycare) > 0) {

            $baby->Indication = unserialize($previous_daycare->Indication);
            if (!empty($previous_daycare->Gestation) && count(json_decode($previous_daycare->Gestation)) > 0) {
                $gestation = json_decode($previous_daycare->Gestation);

                if ($gestation->g_weeks < 34 || $previous_daycare->BirthWeight < 1750) {

                    $baby->Rop = "Rop Screening to be performed between day of life 14 to 28";

                }

            }

            $baby->Sepsis = $previous_daycare->Sepsis;

            $antibiotic_temp = Daycare::get_daycare_antibiotic($previous_daycare->DayId);

            foreach ($antibiotic_temp as $value) {
                $antibiotic[] = (array) $value;
            }

            $antibiotic = \SiteHelpers::unique_multidim_array($antibiotic, 'Antibiotic');

            $drugs = (\SiteHelpers::is_serialized($previous_daycare->OtherDrugs)) ? unserialize($previous_daycare->OtherDrugs) : array();

            $baby->PreviousProblems = (isset($previous_daycare->PreviousProblems)) ? $previous_daycare->PreviousProblems : '';
            $baby->CurrentProblems = (isset($previous_daycare->CurrentProblems)) ? $previous_daycare->CurrentProblems : '';
            $baby->workingWeight = (isset($previous_daycare->workingWeight) && !empty($previous_daycare->workingWeight)) ? $previous_daycare->workingWeight : $baby->BirthWeight;
            $baby->PreviousWt = (isset($previous_daycare->CurrentWt) && !empty($previous_daycare->CurrentWt)) ? $previous_daycare->CurrentWt : null;
            $baby->Background = (isset($previous_daycare->Background) && !empty($previous_daycare->Background)) ? $previous_daycare->Background : $baby->Background;
        } else {
            $nicu_module = Nicu::where(['BabyId' => $id, 'AdmissionId' => $AdmissionId])->where('IsDeleted', 0)
                ->first();

            // if (count($nicu_module) > 0 && isset($nicu_module->SepsisScreen) && $nicu_module->SepsisScreen == 'Yes') {
            //     $baby->Sepsis = 'Suspect';
            //     $antibiotic = unserialize($nicu_module->IVAntibiotic);
            // }

        }

        if (!empty($baby->Gestation) && count(json_decode($baby->Gestation)) > 0) {
            $gestation = json_decode($baby->Gestation);
            $baby->cg_weeks = $gestation->g_weeks;
            $baby->cg_days = !is_null($gestation->g_days) ? $gestation->g_days : 0;
        }

        if (!empty($baby->DOB)) {

            $baby->DayOfLife = \SiteHelpers::calculate_day_of_life($baby->DOB);
        }
        if (!empty($baby->Gestation)) {
            $baby->Gestation = \SiteHelpers::convert_gestation_days($baby->Gestation);
        }

        if (isset($baby->DayOfLife) && $baby->DayOfLife != '') {
            $baby->CGA = \SiteHelpers::calculate_corrected_gestation($baby->Gestation, $baby->DayOfLife);
            $baby->cg_weeks = (int) $baby->CGA[0];
            $baby->cg_days = (int) $baby->CGA[1];
        }

        $baby->DayDate = in_array(date('Y-m-d', strtotime(Carbon::now())), $already_filled_days) ? '' : date('d-m-Y', strtotime(Carbon::now()));

        $currentTime = Carbon::now($this->zone);
        $baby->time_hour = (int) $currentTime->format('h');
        $baby->time_mins = (int) $currentTime->format('i');
        $baby->time_session = $currentTime->format('A');
        $baby->DOB = (date('Y', strtotime($baby->DOB)) > 1970) ? date('d-m-Y', strtotime($baby->DOB)) : date('d-m-Y');

        $mother = Mother::find($baby['MotherId']);
        $results = array();

        $SubmitButtonText = "Save & Close";
        $admission = \SiteHelpers::prepare_time();

        $GetICD = Icd::where('ICDCode', '<>', '')->get();
        $ICD = array();
        foreach ($GetICD as $key => $value) {
            $ICD[$value->ICDCode] = $value->ICDDescription . '-' . $value->ICDCode;
        }

        $Doctorslist = DoctorMaster::get_lists();
        $DoctorMaster = array('' => 'N/A');
        foreach ($Doctorslist as $doctor) {
            $DoctorMaster[$doctor->id] = $doctor->Name;
        }

        return view('daycare.create', compact('SubmitButtonText', 'antibiotic', 'baby', 'navigate', 'admission', 'mother', 'AdmissionId', 'ICD', 'DoctorMaster', 'daycare_create_slug', 'drugs', 'already_filled_days', 'nurse_sheet_val', 'flow_wise_register'));
    }

    /**
     * Show the form for editing the specified record.
     *
     * @param  int $id
     */
    public function edit($id, $search_data = '', Request $request)
    {
        $id = \SiteHelpers::decrypt_id($id);

        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'nicu_daycare';
        $flow_wise_register = $request->get('flow');
        $result = Daycare::get_record($id);
        $daycare_record = Daycare::findOrfail($id);
        $daycare_reassessment = $daycare_record
            ->getReassessmentData
            ->toArray();

        $results = $result[0];

        $silabings = Daycare::getSilabingsday($results->BabyId, $results->AdmissionId);
        $silabingsdays = $this->setPrevnext($silabings, $id);

        $NicuICD = !empty($results->NicuICD) ? json_decode($results->NicuICD) : array();
        //$results->GenICD = !empty($NicuICD->GenICD) ? $NicuICD->GenICD : array();
        $results->ResICD = !empty($NicuICD->ResICD) ? $NicuICD->ResICD : array();
        $results->CarICD = !empty($NicuICD->CarICD) ? $NicuICD->CarICD : array();
        $results->GasICD = !empty($NicuICD->GasICD) ? $NicuICD->GasICD : array();
        $results->CenICD = !empty($NicuICD->CenICD) ? $NicuICD->CenICD : array();
        $results->FluidICD = !empty($NicuICD->FluidICD) ? $NicuICD->FluidICD : array();
        $results->SepsisICD = !empty($NicuICD->SepsisICD) ? $NicuICD->SepsisICD : array();
        $results->SkinICD = !empty($NicuICD->SkinICD) ? $NicuICD->SkinICD : array();
        $results->RopICD = !empty($NicuICD->RopICD) ? $NicuICD->RopICD : array();

        if (date('Y', strtotime($results->DOB)) > 1980)
            $results->DOB = date('d-m-Y', strtotime($results->DOB));
        else
            $results->DOB = '';
        $results_date = $results->DayDate;
        if (date('Y', strtotime($results->DayDate)) > 1980)
            $results->DayDate = date('d-m-Y', strtotime($results->DayDate));
        else
            $results->DayDate = '';

        $drugs = unserialize($results->OtherDrugs);
        $sites = @unserialize($results->PvcSites);
        $mother = Mother::find($results->MotherId);

        $antibiotics = Antibiotic::where('BabyId', '=', $results->BabyId)
            ->where('DayId', '=', $results->DayId)
            ->where('Antibiotic', '<>', '')
            ->get();
        $products = Fluid::where('BabyId', '=', $results->BabyId)
            ->where('DayId', '=', $results->DayId)
            ->get();
        $SubmitButtonText = "Update & Close";
        $admission = \SiteHelpers::prepare_time();

        $displaystyle = ($results->NEC == 'No') ? 'style = "display:none"' : '';

        $GetICD = Icd::where('ICDCode', '<>', '')->get();
        $ICD = array();
        foreach ($GetICD as $key => $value) {
            $ICD[$value->ICDCode] = $value->ICDDescription . '-' . $value->ICDCode;

        }
        $Doctorslist = DoctorMaster::get_lists();
        $DoctorMaster = array('' => 'N/A');
        foreach ($Doctorslist as $doctor) {
            $DoctorMaster[$doctor->id] = $doctor->Name;
        }

        $results->LastBG = (!empty($results->LastBG)) ? explode(':', $results->LastBG) : array();
        $results->LastBG_Time = (isset($results->LastBG[0])) ? $results->LastBG[0] : '';
        $results->LastBG_Time_MINS = (isset($results->LastBG[1])) ? $results->LastBG[1] : '';
        $results->LastBG_Time_AM = (isset($results->LastBG[2])) ? $results->LastBG[2] : '';

        $daycare_questions = DaycareQuestions::get_record($id);

        $daycare_questions = (array) $daycare_questions;
        if (count($daycare_questions) > 0) {
            unset($daycare_questions['BabyId']);
            unset($daycare_questions['DayId']);
        }

        $results = (object) array_merge((array) $results, $daycare_questions);

        $results->Indication = (!empty($results->Indication)) ? @unserialize($results->Indication) : '';
        $results->surfactant_indication = (!empty($results->surfactant_indication)) ? @unserialize($results->surfactant_indication) : '';

        $temp = json_decode($results->CGA);
        $temp = is_array($temp) ? $temp : (array) $temp;
        if (isset($temp['cg_weeks']) && !empty($temp['cg_weeks'])) {
            $results->cg_weeks = $temp['cg_weeks'];
            $results->cg_days = $temp['cg_days'];
        } else {
            $results->cg_weeks = '';
            $results->cg_days = '';
        }
        unset($temp);
        $results->Organism = (isset($results->Organism) && $results->Organism !== 'NULL') ? unserialize($results->Organism) : array();

        $results->Immunoglobulins = isset($results->Immunoglobulins) ? trim($results->Immunoglobulins) : '';
        $results->mrict_brain_status = isset($results->mrict_brain_status) ? trim($results->mrict_brain_status) : '';
        $results->neuro_sonogram = isset($results->neuro_sonogram) ? trim($results->neuro_sonogram) : '';
        $already_filled_days = Daycare::getBabyDates($results->BabyId, $results->AdmissionId);
        if (!empty($already_filled_days) && count($already_filled_days) > 0) {
            if (($key = array_search($results_date, $already_filled_days)) !== false) {
                unset($already_filled_days[$key]);
            }
        }

        return view('daycare.edit', compact('results', 'daycare_reassessment', 'SubmitButtonText', 'products', 'antibiotics', 'drugs', 'search_data', 'sites', 'navigate', 'admission', 'displaystyle', 'ICD', 'mother', 'DoctorMaster', 'silabingsdays', 'already_filled_days', 'flow_wise_register', 'id'));
    }

    /**
     * Update the specified recorde     *
     * @param  int $id
     */
    public function update($id, NicudayRequest $request)
    {
        $input = $request->all();
        $print_flag = isset($input['print_flag']) ? $input['print_flag'] : 0;
        unset($input['print_flag']);
        unset($input['central_temp_farenheit']);
        unset($input['peripheral_fahrenheit']);

        // auto tags register
        //AutoTagMasters::auto_key_support($this->auto_tag_fields,$input);
        $input['Surfactant_therapy_nicu'] = (isset($input['Surfactant_therapy_nicu']) && $input['Surfactant_therapy_nicu'] == 'on') ? 'Yes' : 'No';
        $input['Hypoglycemia'] = (isset($input['Hypoglycemia']) && $input['Hypoglycemia'] == 'on') ? 1 : 0;
        $input['Hyperglycemia'] = (isset($input['Hyperglycemia']) && $input['Hyperglycemia'] == 'on') ? 1 : 0;
        $input['InsulinTherapy'] = (isset($input['InsulinTherapy']) && $input['InsulinTherapy'] == 'on') ? 1 : 0;
        $input['Hyponatremia'] = (isset($input['Hyponatremia']) && $input['Hyponatremia'] == 'on') ? 1 : 0;
        $input['Hypernatremia'] = (isset($input['Hypernatremia']) && $input['Hypernatremia'] == 'on') ? 1 : 0;
        $input['Hypokalemia'] = (isset($input['Hypokalemia']) && $input['Hypokalemia'] == 'on') ? 1 : 0;
        $input['Hyperkalemia'] = (isset($input['Hyperkalemia']) && $input['Hyperkalemia'] == 'on') ? 1 : 0;
        $input['Hypocalcemia'] = (isset($input['Hypocalcemia']) && $input['Hypocalcemia'] == 'on') ? 1 : 0;
        $input['Hypercalcemia'] = (isset($input['Hypercalcemia']) && $input['Hypercalcemia'] == 'on') ? 1 : 0;
        $input['chronic_lung'] = (isset($input['chronic_lung']) && $input['chronic_lung'] == 'on') ? 2 : 1;

        $input['directlybreastfeed'] = (isset($input['directlybreastfeed']) && $input['directlybreastfeed'] == 'on') ? 1 : 0;
        $input['othertypefeed'] = (isset($input['othertypefeed']) && $input['othertypefeed'] == 'on') ? 1 : 0;
        $input['Stools'] = (isset($input['Stools']) && $input['Stools'] == 'on') ? 'Bowels opened' : 'Bowels not opened';

        $input['cg_weeks'] = (!empty($input['cg_weeks'])) ? $input['cg_weeks'] : 0;
        $input['cg_days'] = (!empty($input['cg_days'])) ? $input['cg_days'] : 0;

        $input['CGA'] = json_encode(array(
            'cg_weeks' => $input['cg_weeks'],
            'cg_days' => $input['cg_days']
        ));

        $input['LastBG_Time'] = (strlen($input['LastBG_Time']) == 1) ? '0' . $input['LastBG_Time'] : $input['LastBG_Time'];
        $input['LastBG_Time_MINS'] = (strlen($input['LastBG_Time_MINS']) == 1) ? '0' . $input['LastBG_Time_MINS'] : $input['LastBG_Time_MINS'];
        $input['LastBG'] = $input['LastBG_Time'] . ':' . $input['LastBG_Time_MINS'] . ':' . $input['LastBG_Time_AM'];

        $input['needlethoracentesis'] = (isset($input['needlethoracentesis']) && $input['needlethoracentesis'] == 'on') ? 2 : 1;
        $input['intercostaldrain'] = (isset($input['intercostaldrain']) && $input['intercostaldrain'] == 'on') ? 2 : 1;
        $input['ultrasoundabdominal'] = (isset($input['ultrasoundabdominal']) && $input['ultrasoundabdominal'] == 'on') ? 2 : 1;
        $input['renalultrasound'] = (isset($input['renalultrasound']) && $input['renalultrasound'] == 'on') ? 2 : 1;
        $input['neuro_sonogram'] = (isset($input['neuro_sonogram']) && $input['neuro_sonogram'] == 'on') ? 'performed' : 'Not performed';
        $input['mrict_brain_status'] = (isset($input['mrict_brain_status']) && $input['mrict_brain_status'] == 'on') ? 2 : 1;
        // $input['lumbar_puncture']        = (isset($input['lumbar_puncture']) && $input['lumbar_puncture'] == 'on') ? 2 : 1 ;
        $input['ultrasound_spine'] = (isset($input['ultrasound_spine']) && $input['ultrasound_spine'] == 'on') ? 2 : 1;

        $input['eeg_cfm'] = (isset($input['eeg_cfm']) && $input['eeg_cfm'] == 'on') ? 2 : 1;
        $input['eeg_cfm_report'] = isset($input['eeg_cfm_report']) ? $input['eeg_cfm_report'] : '';
        $input['viral_meningitis'] = (isset($input['viral_meningitis']) && $input['viral_meningitis'] == 'on') ? 2 : 1;
        $input['dilution_exchange'] = (isset($input['dilution_exchange']) && $input['dilution_exchange'] == 'on') ? 2 : 1;

        $input['diastolic_bp'] = (isset($input['diastolic_bp']) && !empty($input['diastolic_bp'])) ? $input['diastolic_bp'] : null;
        $input['systolic_bp'] = (isset($input['systolic_bp']) && !empty($input['systolic_bp'])) ? $input['systolic_bp'] : null;

        $input['cg_weeks'] = (isset($input['cg_weeks']) && $input['cg_weeks'] != '') ? $input['cg_weeks'] : null;
        $input['cg_days'] = (isset($input['cg_days']) && $input['cg_days'] != '') ? $input['cg_days'] : null;

        $input['cg_weeks'] = (isset($input['cg_weeks']) && !empty($input['cg_weeks'])) ? $input['cg_weeks'] : null;
        $input['cg_days'] = (isset($input['cg_days']) && !empty($input['cg_days'])) ? $input['cg_days'] : null;

        $input['DateModified'] = Carbon::now();
        $input['pvc_number'] = empty($input['pvc_number']) ? null : $input['pvc_number'];
        $input['DayDate'] = date('Y-m-d', strtotime($input['DayDate']));
        $input['seenby'] = isset($input['seenby']) ? json_encode($input['seenby']) : null;
        $input['Care'] = isset($input['Care']) && !empty($input['Care']) ? $input['Care'] : null;
        $input['Background'] = isset($input['Background']) && !empty($input['Background']) ? $input['Background'] : null;

        $input['head_circumference'] = isset($input['head_circumference']) && !empty($input['head_circumference']) ? $input['head_circumference'] : null;
        $input['length'] = isset($input['length']) && !empty($input['length']) ? $input['length'] : null;
        $input['Ivf'] = isset($input['Ivf']) && !empty($input['Ivf']) ? $input['Ivf'] : null;

        $results1 = Daycare::findOrfail($id);

        $result = Daycare::get_record($id);

        $get_daycare_details = $result[0];

        $input['Organism'] = isset($input['Organism']) ? serialize($input['Organism']) : serialize(array());
        $input['OtherDrugs'] = (isset($input['drugs'])) ? serialize($input['drugs']) : serialize(array());
        $input['Indication'] = (isset($input['Indication'])) ? serialize($input['Indication']) : serialize(array());
        $input['surfactant_indication'] = (isset($input['surfactant_indication'])) ? serialize($input['surfactant_indication']) : serialize(array());

        $setNicuICD = array();
        //$setNicuICD['GenICD'] = !empty($input['GenICD']) ? $input['GenICD'] : array();
        $setNicuICD['ResICD'] = !empty($input['ResICD']) ? $input['ResICD'] : array();
        $setNicuICD['CarICD'] = !empty($input['CarICD']) ? $input['CarICD'] : array();
        $setNicuICD['GasICD'] = !empty($input['GasICD']) ? $input['GasICD'] : array();
        $setNicuICD['CenICD'] = !empty($input['CenICD']) ? $input['CenICD'] : array();
        $setNicuICD['FluidICD'] = !empty($input['FluidICD']) ? $input['FluidICD'] : array();
        $setNicuICD['SepsisICD'] = !empty($input['SepsisICD']) ? $input['SepsisICD'] : array();
        $setNicuICD['SkinICD'] = !empty($input['SkinICD']) ? $input['SkinICD'] : array();
        $setNicuICD['RopICD'] = !empty($input['RopICD']) ? $input['RopICD'] : array();

        $input['NicuICD'] = json_encode($setNicuICD);

        $input['Carbohydrates'] = isset($input['Carbohydrates']) ? $input['Carbohydrates'] : '';
        $input['Protein'] = isset($input['Protein']) ? $input['Protein'] : '';
        $input['Fat'] = isset($input['Fat']) ? $input['Fat'] : '';
        $input['total_energy'] = isset($input['total_energy']) ? $input['total_energy'] : '';
        $input['ultrasoundkeyfindings'] = isset($input['ultrasoundkeyfindings']) ? $input['ultrasoundkeyfindings'] : '';
        $input['renalultrasoundkeyfindings'] = isset($input['renalultrasoundkeyfindings']) ? $input['renalultrasoundkeyfindings'] : '';
        $input['mri_ct_brain'] = isset($input['mri_ct_brain']) ? $input['mri_ct_brain'] : '';
        $input['ultrasound_spine_report'] = isset($input['ultrasound_spine_report']) ? $input['ultrasound_spine_report'] : '';

        $input['amplitude'] = isset($input['amplitude']) && !empty($input['amplitude']) ? $input['amplitude'] : null;

        $input['volume_targeting'] = (isset($input['volume_targeting']) && $input['volume_targeting'] == 'on') ? 1 : 0;
        $input['claco'] = (isset($input['claco']) && $input['claco'] == 'on') ? 1 : 0;

        if ($results1['form_status'] != 2) {
            $input['form_status'] = !isset($input['formstatus']) ? 1 : $input['formstatus'];
        }

        $input['UserModified'] = $this->auth->user()->id;
        $input['DateModified'] = Carbon::now();

        $results1->update($input);

        $day_questions = DaycareQuestions::where('DayId', $id)->first();
        if (count($day_questions) > 0) {
            $day_questions['respiratory_problem'] = $input['respiratory_problem'];
            $day_questions['Cardiovascular_problem'] = $input['Cardiovascular_problem'];
            $day_questions['directlybreastfeed'] = $input['directlybreastfeed'];
            $day_questions['othertypefeed'] = $input['othertypefeed'];
            $day_questions['workingWeight'] = isset($input['workingWeight']) ? $input['workingWeight'] : null;
            $day_questions['iv_fluids'] = isset($input['iv_fluids']) ? $input['iv_fluids'] : null;
            $day_questions['drug_infusions'] = isset($input['drug_infusions']) ? $input['drug_infusions'] : 0;
            $day_questions['other_drugs'] = $input['other_drugs'];
            $day_questions['Carbohydrates'] = $input['Carbohydrates'];
            $day_questions['Protein'] = $input['Protein'];
            $day_questions['Fat'] = $input['Fat'];
            $day_questions['gastrointestinal_problem'] = $input['gastrointestinal_problem'];
            $day_questions['Pupils'] = $input['Pupils'];
            $day_questions['sedation_paralysis'] = $input['sedation_paralysis'];
            $day_questions['central_problem'] = $input['central_problem'];
            $day_questions['urine_output_day'] = $input['urine_output_day'];
            $day_questions['iv_fluids_ml_day'] = isset($input['iv_fluids_ml_day']) ? $input['iv_fluids_ml_day'] : null;
            $day_questions['drug_infusions_ml_day'] = isset($input['drug_infusions_ml_day']) ? $input['drug_infusions_ml_day'] : null;
            $day_questions['total_energy'] = $input['total_energy'];
            $day_questions['UserModified'] = $this->auth->user()->id;
            $day_questions['DateModified'] = Carbon::now();
            $day_questions['neuro_sonogram'] = $input['neuro_sonogram'];
            $day_questions['gir'] = $input['gir'];
            $day_questions['needlethoracentesis'] = $input['needlethoracentesis'];
            $day_questions['intercostaldrain'] = $input['intercostaldrain'];
            $day_questions['ultrasoundabdominal'] = $input['ultrasoundabdominal'];
            $day_questions['ultrasoundkeyfindings'] = $input['ultrasoundkeyfindings'];
            $day_questions['lumbar_puncture'] = $input['lumbar_puncture'];
            $day_questions['renalultrasound'] = $input['renalultrasound'];
            $day_questions['renalultrasoundkeyfindings'] = $input['renalultrasoundkeyfindings'];
            $day_questions['ultrasound_spine'] = $input['ultrasound_spine'];
            $day_questions['ultrasound_spine_report'] = $input['ultrasound_spine_report'];
            $day_questions['eeg_cfm'] = $input['eeg_cfm'];
            $day_questions['eeg_cfm_report'] = $input['eeg_cfm_report'];
            $day_questions['mrict_brain_status'] = $input['mrict_brain_status'];
            $day_questions['mri_ct_brain'] = $input['mri_ct_brain'];
            $day_questions['viral_meningitis'] = $input['viral_meningitis'];
            $day_questions['dilution_exchange'] = $input['dilution_exchange'];
            $day_questions->update();
        } else {

            $daycarequestions = $input;
            $daycarequestions['DayId'] = $id;
            $daycarequestions['AdmissionId'] = $get_daycare_details->AdmissionId;
            $daycarequestions['BabyId'] = $get_daycare_details->BabyId;
            $daycarequestions['UserAdded'] = $this->auth->user()->id;
            $daycarequestions['DateAdded'] = Carbon::now();

            DaycareQuestions::create($daycarequestions);
        }

        if (isset($input['reassessment_id_old'])) {

            $input['reassessment_id'] = isset($input['reassessment_id']) ? $input['reassessment_id'] : [];

            $deleted_assessment = array_diff($input['reassessment_id_old'], $input['reassessment_id']);
            $remove_record = DaycareReassessmentSheets::where('day_id', $id)
                ->whereIn('id', $deleted_assessment)
                ->delete();
        }

        if (isset($input['reassessment_date'])) {
            foreach ($input['reassessment_date'] as $key => $value) {

                $daycare_assessment['day_id'] = $id;
                $daycare_assessment['reassessment_date'] = (isset($input['reassessment_date'][$key]) && !empty($input['reassessment_date'][$key])) ? date('Y-m-d', strtotime($input['reassessment_date'][$key])) : null;

                $input['reassessment_time'][$key] = (isset($input['reassessment_time'][$key]) && strlen($input['reassessment_time'][$key]) == 1) ? '0' . $input['reassessment_time'][$key] : $input['reassessment_time'][$key];
                $input['reassessment_min'][$key] = (isset($input['reassessment_min'][$key]) && strlen($input['reassessment_min'][$key]) == 1) ? '0' . $input['reassessment_min'][$key] : $input['reassessment_min'][$key];

                $daycare_assessment['reassessment_time'] = $input['reassessment_time'][$key] . ':' . $input['reassessment_min'][$key] . ':' . $input['reassessment_am'][$key];
                $daycare_assessment['reassessment_ventilater'] = $input['reassessment_ventilater'][$key];
                $daycare_assessment['reassessment_cpap'] = $input['reassessment_cpap'][$key];
                $daycare_assessment['reassessment_nc'] = $input['reassessment_nc'][$key];
                $daycare_assessment['reassesment_room_air'] = $input['reassesment_room_air'][$key];
                $daycare_assessment['reassessment_systalic_bp'] = (isset($input['reassessment_systalic_bp'][$key]) && !empty($input['reassessment_systalic_bp'][$key])) ? $input['reassessment_systalic_bp'][$key] : null;
                $daycare_assessment['reassessment_diastolic_bp'] = (isset($input['reassessment_diastolic_bp'][$key]) && !empty($input['reassessment_diastolic_bp'][$key])) ? $input['reassessment_diastolic_bp'][$key] : null;
                $daycare_assessment['reassessment_bp'] = (isset($input['reassessment_bp'][$key]) && !empty($input['reassessment_bp'][$key])) ? $input['reassessment_bp'][$key] : null;
                $daycare_assessment['reassessment_spo2'] = (isset($input['reassessment_spo2'][$key]) && !empty($input['reassessment_spo2'][$key])) ? $input['reassessment_spo2'][$key] : 0.00;
                $daycare_assessment['reassessment_hr'] = (isset($input['reassessment_hr'][$key]) && !empty($input['reassessment_hr'][$key])) ? $input['reassessment_hr'][$key] : 0.00;
                $daycare_assessment['reassemant_rs'] = $input['reassemant_rs'][$key];
                $daycare_assessment['reassessment_rr'] = (isset($input['reassessment_rr'][$key]) && !empty($input['reassessment_rr'][$key])) ? $input['reassessment_rr'][$key] : 0.00;
                $daycare_assessment['reassemant_gi'] = $input['reassemant_gi'][$key];
                $daycare_assessment['reassemant_cns'] = $input['reassemant_cns'][$key];
                $daycare_assessment['additional_assessment'] = $input['additional_assessment'][$key];
                $daycare_assessment['reassemant_cvs'] = $input['reassemant_cvs'][$key];
                $daycare_assessment['baby_id'] = $get_daycare_details->BabyId;
                $daycare_assessment['admission_id'] = $get_daycare_details->AdmissionId;
                $daycare_assessment['reassessment_seen_by'] = json_encode($input['reassessment_seen_by']);

                if (isset($input['reassessment_id'][$key])) {
                    $reassessment = DaycareReassessmentSheets::find($input['reassessment_id'][$key]);
                    if (count($reassessment) > 0) {
                        $reassessment->update($daycare_assessment);
                    }
                } else if (isset($daycare_assessment['reassessment_date']) && !empty($daycare_assessment['reassessment_date'])) {
                    if (isset($input['reassessment_date'][$key])) {
                        $reassessment = DaycareReassessmentSheets::where('reassessment_date', $daycare_assessment['reassessment_date'])
                            ->where('reassessment_time', $daycare_assessment['reassessment_time'])->first();

                        if (count($reassessment) > 0) {
                            $reassessment = DaycareReassessmentSheets::find($reassessment->id);
                            $reassessment->update($daycare_assessment);
                        } else {
                            DaycareReassessmentSheets::create($daycare_assessment);
                        }

                    }
                }
            }

        }

        Antibiotic::where('BabyId', '=', $input['BabyId'])->where('DayId', '=', $id)->where('AdmissionId', '=', $get_daycare_details->AdmissionId)->delete();
        if (isset($input['A_Antibiotic'])) {

            foreach ($input['A_Antibiotic'] as $key => $value) {
                if (!empty($input['A_Antibiotic'][$key])) {
                    $pbms = array(
                        'AdmissionId' => $get_daycare_details->AdmissionId,
                        'Antibiotic' => $input['A_Antibiotic'][$key],
                        'Day' => $input['A_Day'][$key],
                        'DayId' => $id,
                        'BabyId' => $input['BabyId']

                    );

                    Antibiotic::insert($pbms);
                }

            }
        }

        Fluid::where('BabyId', '=', $input['BabyId'])->where('DayId', '=', $id)->delete();
        if (isset($input['F_Product'])) {

            foreach ($input['F_Product'] as $key => $value) {

                $fproduct = !empty($input['F_Product'][$key]) ? $input['F_Product'][$key] : '';
                $fvolume = !empty($input['F_Volume'][$key]) ? $input['F_Volume'][$key] : '';

                $pbms1 = array(
                    'Product' => $fproduct,
                    'Volume' => $fvolume,
                    'DayId' => $id,
                    'BabyId' => $input['BabyId'],
                    'AdmissionId' => $get_daycare_details->AdmissionId

                );
                Fluid::insert($pbms1);
            }
        }

        $module = \Session::has('admission_module') ? \Session::get('admission_module') : 'NICU_DAILY_CARE';
        $menu = isset($_COOKIE['daycare']) ? $_COOKIE['daycare'] : 'generalform';

        // Nicu dashboard data updating call
        \SiteHelpers::updateDashboardAtFormUpdation($input['BabyId'], 'NICU Daycare');

        if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'Daycare details created successfully !', 'edit_url' => action('Admission\DaycareController@edit', \SiteHelpers::encrypt_id($id)), 'list_url' => action('Admission\DaycareController@daycareAdmissionDaylist', \SiteHelpers::encrypt_id($results1->AdmissionId)), 'print_url' => action('Admission\DaycareController@printData', \SiteHelpers::encrypt_id($id)), 'ward_dashboard_url' => url('ward-dashboard')], 200);
        }

        if ($print_flag == 1) {

            $this
                ->flow
                ->flowlog($module, $results1->BabyId, $results1->MotherId, $results1->AdmissionId, false, $menu, $id);
            return redirect(action('Admission\DaycareController@printData', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully ');

        } elseif ($print_flag == 2) {

            $this
                ->flow
                ->flowlog($module, $results1->BabyId, $results1->MotherId, $results1->AdmissionId, false, $menu, $id);
            return redirect(action('Admission\DaycareController@edit', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully ');

        } elseif ($print_flag == 4) {

            // $this->flow->flowlog($module, $results1->BabyId, $results1->MotherId, $results1->AdmissionId, false, $menu, $id);
            return redirect(action('Admission\DaycareController@reassessmentPrintData', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully ');

        } else {

            $this
                ->flow
                ->flowlog($module, $results1->BabyId, $results1->MotherId, $results1->AdmissionId, true, $menu, $id);
            $this
                ->flow
                ->clearFlow();
            return redirect(action('Admission\DaycareController@daycareAdmissionDaylist', \SiteHelpers::encrypt_id($get_daycare_details->AdmissionId)))
                ->with('Success', 'Record updated successfully ');
        }
    }

    /**
     * Print display of the record
     *
     * @param  int $id
     */
    public function printData($id)
    {
        $id = \SiteHelpers::decrypt_id($id);

        $result = Daycare::get_record($id);
        $editor_gen_option = false;
        $results = $result[0];
        $drugs = array();
        $Mastersrespirtory = RespiratoryIndication::getFieldvalue();
        $drugstemp = unserialize($results->OtherDrugs);
        if (!empty($drugstemp)) {
            $drugs = array_where($drugstemp, function ($index, $value) {

                if (!empty($index)) {
                    return $index;
                }
            });
        }

        $results->Indication = @json_decode($results->Indication);

        //$sites = unserialize($results->PvcSites);
        $Mother_details = Mother::find($results->MotherId);
        $antibiotics = Antibiotic::select('Antibiotic', 'Day')->where('BabyId', '=', $results->BabyId)
            ->where('DayId', '=', $results->DayId)
            ->get();
        $products = Fluid::where('BabyId', '=', $results->BabyId)
            ->where('DayId', '=', $results->DayId)
            ->get();

        $closewinlink = action('Admission\DaycareController@index');
        $results = (object) \SiteHelpers::formate_tags($this->auto_tag_fields, (array) $results);

        $editor_gen_option = $results->edited_content == NULL ? 1 : 0;

        foreach ($results as $key => &$value) {
            $value = (empty($value) && !is_array($value) && $key != 'DayTime_MINS') ? 'N/A' : $value;
        }

        $results->Gestation = \SiteHelpers::decode_gestation($results->Gestation);
        $results->CGA = \SiteHelpers::decode_gestation($results->CGA);
        // $results->rawdr = \SiteHelpers::is_serialized($results->neonatal_consultant) && is_array(unserialize($results->neonatal_consultant)) ? unserialize($results->neonatal_consultant) : [];

        // $results->neonatal_consultant = \SiteHelpers::is_serialized($results->neonatal_consultant) && is_array(unserialize($results->neonatal_consultant)) ? \SiteHelpers::get_doctors_name($results->neonatal_consultant) : [];
        $nicu_id = Nicu::where('AdmissionId', $results->AdmissionId)
            ->first();
        $ip_details = IpNumber::getCurrent_ip($results->BabyId, $results->AdmissionId);
        // $results->rawdr = \SiteHelpers::formating_consultant_signature($results->neonatal_consultant, false, $nicu_id->hospital_name);
        $results->seenby = \ValuelistHelpers::signatureFormat($results->seenby);
        $results->rawdr = \ValuelistHelpers::signatureFormat($results->neonatal_consultant);
        $nicu_id = $nicu_id->NicuId;
        $ip_number = isset($ip_details->ip_number) ? $ip_details->ip_number : null;

        $editor_gen = false;

        if (\Session::has('nicu-daycare-editor')) {
            \Session::forget('nicu-daycare-editor');

            $editor_gen = true;
            return view('daycare.print', compact('results', 'nicu_id', 'products', 'antibiotics', 'drugs', 'Mother_details', 'Mastersrespirtory', 'closewinlink', 'editor_gen', 'editor_gen_option', 'ip_number'))->renderSections();

        }

        return view('daycare.print', compact('results', 'nicu_id', 'products', 'antibiotics', 'drugs', 'Mother_details', 'Mastersrespirtory', 'closewinlink', 'editor_gen_option', 'ip_number'));

    }
    /**
     * Print display of the record
     *
     * @param  int $id
     */
    public function reassessmentPrintData($id)
    {
        $id = \SiteHelpers::decrypt_id($id);

        $result = Daycare::get_record($id);
        $editor_gen_option = false;
        $results = $result[0];

        $reassessment_result = DaycareReassessmentSheets::where('day_id', $id)->get();
        //$sites = unserialize($results->PvcSites);
        $Mother_details = Mother::find($results->MotherId);

        $closewinlink = action('Admission\DaycareController@index');
        $results = (object) \SiteHelpers::formate_tags($this->auto_tag_fields, (array) $results);

        foreach ($results as $key => &$value) {
            $value = (empty($value) && !is_array($value) && $key != 'DayTime_MINS') ? 'N/A' : $value;
        }

        $results->Gestation = \SiteHelpers::decode_gestation($results->Gestation);
        $results->CGA = \SiteHelpers::decode_gestation($results->CGA);
        // $results->neonatal_consultant = \SiteHelpers::is_serialized($results->neonatal_consultant) && is_array(unserialize($results->neonatal_consultant)) ? \SiteHelpers::get_doctors_name($results->neonatal_consultant) : [];
        $results->rawdr = \ValuelistHelpers::signatureFormat($results->neonatal_consultant);
        $nicu_id = Nicu::where('AdmissionId', $results->AdmissionId)
            ->first()->NicuId;
        return view('daycare.reassessment_print', compact('results', 'nicu_id', 'Mother_details', 'closewinlink', 'editor_gen_option', 'reassessment_result'));

    }

    /**
     * Retrieve data for view popup
     */
    public function getData($id)
    {
        $result = Daycare::get_record($id);
        $results = (array) $result[0];
        $results['DayDate'] = date('d-m-Y', strtotime($results['DayDate']));
        $results['DayTime'] = (strlen($results['DayTime']) == 1) ? ('0' . $results['DayTime']) : $results['DayTime'];
        $results['DayTime_MINS'] = (strlen($results['DayTime_MINS']) == 1) ? ('0' . $results['DayTime_MINS']) : $results['DayTime_MINS'];
        $results['DayTime'] = $results['DayTime'] . ':' . $results['DayTime_MINS'] . ' ' . $results['DayTime_AM'];
        $results['DOB'] = date('d-m-Y', strtotime($results['DOB']));

        return json_encode($results);
    }

    /**
     * Retrieve data for search filter
     */
    public function searchData(Request $request)
    {
        $data = $request->get('data1');
        $result = Daycare::GetSearchDatas($data);
        $results = (array) $result;
        return json_encode($results);
    }

    /**
     * Update the record as deleted and create request for approval
     */
    public function destroy($id)
    {
        $results = Daycare::findOrfail($id);
        $user_detail = array(
            'UserDeleted' => $this
                ->auth
                ->user()->id,
            'DateModified' => Carbon::now(),
            'IsDeleted' => '1'
        );

        $result = Daycare::get_record($id);
        $res = $result[0];
        $results->update($user_detail);

        $delete_data = array(
            'Name' => $res->BabyName,
            'AdmissionDate' => $results['DayDate'],
            'ModuleController' => 'Admission\DaycareController',
            'ModuleId' => $id,
            'ModuleName' => 'Daycare Sheet',
            'UserDeleted' => $this
                ->auth
                ->user()->id,
            'DateDeleted' => Carbon::now()
        );
        DeleteApproval::create($delete_data);

        return redirect(action('Admission\DaycareController@daycareAdmissionDaylist', \SiteHelpers::encrypt_id($results->AdmissionId)))
            ->with('info', 'Record deleted successfully ');
    }

    public function getDaycareadmission($id, $type = '')
    {

        $id = \SiteHelpers::decrypt_id($id);

        $baby = Baby::daycare_eposide_list($id);

        $babies = array();
        $babies[0] = '-- Select Admission --';
        if ($type == '') {
            foreach ($baby as $babyvalue) {
                $babies[\SiteHelpers::encrypt_id($babyvalue->AdmissionId . '-' . $babyvalue->BabyId)] = $babyvalue->episodes;
            }
        } else {
            foreach ($baby as $babyvalue) {
                $babies[\SiteHelpers::encrypt_id($babyvalue->BabyId . '-' . $babyvalue->AdmissionId)] = $babyvalue->episodes;
            }
        }
        return \Response::json(['message' => $babies]);

    }

    public function setPrevnext($daycare_list, $current_id)
    {
        sort($daycare_list);

        if (is_array($daycare_list) && !empty($current_id)) {
            $key = array_search($current_id, $daycare_list);
            $prev = $key - 1;
            $next = $key + 1;
            $daypages[0] = (array_key_exists($prev, $daycare_list)) ? $daycare_list[$prev] : '';
            $daypages[1] = (array_key_exists($next, $daycare_list)) ? $daycare_list[$next] : '';
            $daypages[0] = !empty($daypages[0]) ? action('Admission\DaycareController@edit', \SiteHelpers::encrypt_id($daypages[0])) : '';
            $daypages[1] = !empty($daypages[1]) ? action('Admission\DaycareController@edit', \SiteHelpers::encrypt_id($daypages[1])) : '';
            $daypages['first'] = !empty($daypages[0]) ? action('Admission\DaycareController@edit', \SiteHelpers::encrypt_id(collect($daycare_list)->first())) : '';
            $daypages['last'] = !empty($daypages[1]) ? action('Admission\DaycareController@edit', \SiteHelpers::encrypt_id(collect($daycare_list)->last())) : '';

            return $daypages;
        }
        return 0;

    }

    public function sentMessagereferaldoctors(Request $request)
    {
        $input = $request->all();

        if (!empty($input['to']) && !empty($input['message'])) {
            $results = $this
                ->sms
                ->sendSms($input['to'], $input['message'], 'Daycare', '1');
            $statuts = 200;
            $message = 'Success';
        } else {
            $statuts = 400;
            $message = 'error';
        }
        return \Response::json([$message], $statuts);

    }

    public function icdList(Request $request)
    {
        $input = $request->all();

    }

    /**
     * OPEN REPORT WITH FULL EDITOR
     *
     */
    public function getfullEditor(Request $request)
    {
        $input = $request->all();
        \Session::put('nicu-daycare-editor', true);
        return \Response::json(['dataUrl' => $input['dataUrl'], 'day_id' => $input['day_id']], 200);

    }

    /**
     * OPEN REPORT WITH FULL EDITOR
     *
     */
    public function saveFullEditor(Request $request)
    {

        // assign inputs to variable
        $input = $request->all();

        $daycare = Daycare::findOrfail($input['day_id']);

        $daycare->update(['edited' => true, 'edited_content' => $input['nicu_daycare_report'], 'edited_time' => Carbon::now($this->zone)]);

        // create slug for updated
        $day_id = $input['day_id'];

        if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'msg' => 'Record Updated Successfully']);
        } else {
            return redirect(action('Admission\DaycareController@getAbbreviatedsummaryShow', $day_id))->with('success', 'Record updated successfully');
        }
    }

    public function getAbbreviatedsummaryShow(Request $request, $id)
    {
        $id_list = $id;

        $dischargeSummarymodified = array();

        if (isset($id_list) && !empty($id_list)) {

            $dischage_summary['day_id'] = $day_id = $id_list;

        } else {

            return redirect(url('/'))->with('error', 'Invalid record');

        }

        $daycare = Daycare::findOrfail($id_list);

        \Session::put('nicu-daycare-editor', true);

        if (count($daycare) > 0 && !empty($daycare['edited_content'])) {
            $discharge_details['content'] = $daycare['edited_content'];
        } else {
            $discharge_details = $this->printData($id);
        }

        $editor_gen = false;
        \Session::forget('nicu-daycare-editor');

        return view('daycare.editor', compact('discharge_details', 'dischargeSummarymodified', 'dischage_summary'));
    }

    public function reassessmentCreate(Request $request)
    {
        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'nicu_daycare';
        $day_id = $request->all()['day_id'];
        $day_id = \SiteHelpers::decrypt_id($day_id);

        $daycare_record = Daycare::findOrfail($day_id);
        $daycare_reassessment = $daycare_record
            ->getReassessmentData
            ->toArray();

        return view('daycare.create_reassessment', compact('day_id', 'daycare_reassessment'));
    }
    public function reassessmentSheetStore()
    {
        if (isset($input['reassessment_date'])) {

            $remove_record = DaycareReassessmentSheets::where('baby_id', $get_daycare_details->BabyId)
                ->where('admission_id', $get_daycare_details->AdmissionId);

            if (isset($input['reassessment_id'])) {
                $remove_record->whereNotIn('id', $input['reassessment_id']);
            }
            $remove_record->delete();

            foreach ($input['reassessment_date'] as $key => $value) {

                $daycare_assessment['day_id'] = $id;
                $daycare_assessment['reassessment_date'] = (isset($input['reassessment_date'][$key]) && !empty($input['reassessment_date'][$key])) ? date('Y-m-d', strtotime($input['reassessment_date'][$key])) : null;

                $input['reassessment_time'][$key] = (isset($input['reassessment_time'][$key]) && strlen($input['reassessment_time'][$key]) == 1) ? '0' . $input['reassessment_time'][$key] : $input['reassessment_time'][$key];
                $input['reassessment_min'][$key] = (isset($input['reassessment_min'][$key]) && strlen($input['reassessment_min'][$key]) == 1) ? '0' . $input['reassessment_min'][$key] : $input['reassessment_min'][$key];

                $daycare_assessment['reassessment_time'] = $input['reassessment_time'][$key] . ':' . $input['reassessment_min'][$key] . ':' . $input['reassessment_am'][$key];
                $daycare_assessment['reassessment_ventilater'] = $input['reassessment_ventilater'][$key];
                $daycare_assessment['reassessment_cpap'] = $input['reassessment_cpap'][$key];
                $daycare_assessment['reassessment_nc'] = $input['reassessment_nc'][$key];
                $daycare_assessment['reassesment_room_air'] = $input['reassesment_room_air'][$key];
                $daycare_assessment['reassessment_systalic_bp'] = (isset($input['reassessment_systalic_bp'][$key]) && !empty($input['reassessment_systalic_bp'][$key])) ? $input['reassessment_systalic_bp'][$key] : null;
                $daycare_assessment['reassessment_diastolic_bp'] = (isset($input['reassessment_diastolic_bp'][$key]) && !empty($input['reassessment_diastolic_bp'][$key])) ? $input['reassessment_diastolic_bp'][$key] : null;
                $daycare_assessment['reassessment_bp'] = (isset($input['reassessment_bp'][$key]) && !empty($input['reassessment_bp'][$key])) ? $input['reassessment_bp'][$key] : null;
                $daycare_assessment['reassessment_spo2'] = (isset($input['reassessment_spo2'][$key]) && !empty($input['reassessment_spo2'][$key])) ? $input['reassessment_spo2'][$key] : 0.00;
                $daycare_assessment['reassessment_hr'] = (isset($input['reassessment_hr'][$key]) && !empty($input['reassessment_hr'][$key])) ? $input['reassessment_hr'][$key] : 0.00;
                $daycare_assessment['reassemant_rs'] = $input['reassemant_rs'][$key];
                $daycare_assessment['reassessment_rr'] = (isset($input['reassessment_rr'][$key]) && !empty($input['reassessment_rr'][$key])) ? $input['reassessment_rr'][$key] : 0.00;
                $daycare_assessment['reassemant_gi'] = $input['reassemant_gi'][$key];
                $daycare_assessment['reassemant_cns'] = $input['reassemant_cns'][$key];
                $daycare_assessment['additional_assessment'] = $input['additional_assessment'][$key];
                $daycare_assessment['reassemant_cvs'] = $input['reassemant_cvs'][$key];
                $daycare_assessment['baby_id'] = $get_daycare_details->BabyId;
                $daycare_assessment['reassessment_seen_by'] = json_encode($input['reassessment_seen_by']);
                $daycare_assessment['admission_id'] = $get_daycare_details->AdmissionId;

                if (isset($input['reassessment_id'][$key])) {

                    $reassessment = DaycareReassessmentSheets::find($input['reassessment_id'][$key]);
                    $reassessment->update($daycare_assessment);

                } else {

                    DaycareReassessmentSheets::create($daycare_assessment);

                }
            }

        }
    }

    public function getTodayMachineRecords(Request $request)
    {
        if ($request->ajax()) {

            $input = $request->all();

            $select_date_time = $input['select_date_time'];
            $baby_id = $input['baby_id'];
            $admission_id = $input['admission_id'];

            $startdate = date('Y-m-d', strtotime($select_date_time));
            $starttime = date('H:i:s', strtotime($select_date_time));

            $start_time = $startdate . ' 00:00:00';
            $end_time = $startdate . ' ' . $starttime;

            $result = [];

            if (isset($input['reassessment']) && $input['reassessment']) {

                $observation = DialpadSupportProperty::LOINC_LOCAL_CODE;

                $monitor_nurse_sheet_id = [$observation[8], 'oxygen_saturation_index', $observation[10], $observation[11], $observation[12], $observation[7]];

                $ventilator_nurse_sheet_id = [$observation[19]];

                $monitor_results = EmrMoniterValues::getInterfacingData($baby_id, $admission_id, $monitor_nurse_sheet_id, $start_time, $end_time);

                $ventilator_results = EmrVentilatorValues::getInterfacingData($baby_id, $admission_id, $ventilator_nurse_sheet_id, $start_time, $end_time);
                $nurse_sheet_result = collect($monitor_results)->merge($ventilator_results);

                $nurse_sheet_result = collect($nurse_sheet_result)->groupby('local_code');

                $nurse_sheet_id = [$observation[19], $observation[109], '', '', '', $observation[8], 'oxygen_saturation_index', $observation[10], $observation[11], $observation[12], $observation[7]];

                $daycare_id = ['reassessment_ventilater', 'reassessment_ventilater', 'reassessment_cpap', 'reassessment_nc', 'reassesment_room_air', 'reassessment_rr', 'reassessment_spo2', 'reassessment_systalic_bp', 'reassessment_diastolic_bp', 'reassessment_bp', 'reassessment_hr'];

                foreach ($nurse_sheet_result as $key => $value) {

                    $index = array_search($key, $nurse_sheet_id);

                    $sheet_val = (object) $value->first();

                    $daycare_key = $daycare_id[$index];

                    // if ($key == 'mode_of_ventilation') {
                    //     $mode = $sheet_val->intf_ref_value;
                    //     if (!empty($mode)) {
                    //         $result[$daycare_key] = 'Yes';
                    //         if ($mode == 'CPAP' || $mode == 'HHHFNC') {
                    //             $result[$daycare_id[1]] = 'Yes';
                    //         }
                    //         if ($mode == 'NC') {
                    //             $result[$daycare_id[2]] = 'Yes';
                    //         }
                    //         if ($mode == 'SV') {
                    //             $result[$daycare_id[3]] = 'Yes';
                    //         }
                    //     }

                    // } else 

                    if (isset($sheet_val->intf_ref_value)) {
                        $result[$daycare_key] = $sheet_val->intf_ref_value;
                    }
                }


            } else {

                $monitor_nurse_sheet_id = ['peripheral_temp', 'hr_rate', 'cuff_systalic_bp', 'arterial_systalic_bp', 'cuff_diastolic_bp', 'arterial_diastolic_bp', 'cuff_mean_bp', 'arterial_mean_bp', 'preductal_sao2', 'postductal_sao2', 'respiratory_rate'];

                $ventilator_nurse_sheet_id = ['mode_of_ventilation', 'mode_of_ventilation_invasive', 'pip_set', 'pip_delivered', 'peep', 'map', 'fio2', 'delivered_fio2', 'flow', 'rate', 'frequency', 'it_rate_secound'];

                $lab_nurse_sheet_id = ['blood_gas_ph', 'blood_gas_pao2', 'blood_gas_paco2', 'blood_gas_hco3', 'blood_gas_be', 'blood_gas_lactate', 'gluco_meter_platelets', 'gluco_meter_crp', 'gluco_meter_wbc', 'gluco_meter_dc', 'blood_sugar'];

                $manual_nurse_sheet_id = ['current_weight', 'working_weight'];

                $monitor_results = EmrMoniterValues::getInterfacingData($baby_id, $admission_id, $monitor_nurse_sheet_id, $start_time, $end_time);

                $ventilator_results = EmrVentilatorValues::getInterfacingData($baby_id, $admission_id, $ventilator_nurse_sheet_id, $start_time, $end_time);

                $lab_results = EmrLogHeader::getInterfacingData($baby_id, $admission_id, $lab_nurse_sheet_id, $start_time, $end_time);

                $bilirubin_start_time = date('Y-m-d H:i:s', strtotime('-24 hours', strtotime($end_time)));
                $bilirubin_end_time = $end_time;

                $temp_bilirubin_results['intf_ref_value'] = \DB::table('emr_lab_values')
                    ->select('emr_lab_values.intf_ref_value', 'local_code_group.local_code')
                    ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_lab_values.log_hdr_id')
                    ->join('local_code_group', 'local_code_group.id', '=', 'emr_lab_values.loinc_local_map_id')
                    ->where('baby_id', $baby_id)
                    ->where('admission_id', $admission_id)
                    ->where('intf_ref_value', '<>', '')
                    ->where('local_code_group.local_code', 'interface_blood_gas_bilirubin')
                    ->whereBetween('result_date_time', [$bilirubin_start_time, $bilirubin_end_time])
                    ->orderBy('result_date_time', 'desc')
                    ->max('intf_ref_value');
                $temp_bilirubin_results['local_code'] = 'interface_blood_gas_bilirubin';

                $bilirubin_results[0] = (object) $temp_bilirubin_results;


                $manual_results = \DB::table('emr_nurse_manual_values')
                    ->select('emr_nurse_manual_values.intf_ref_value', 'local_code_group.local_code')
                    ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_nurse_manual_values.log_hdr_id')
                    ->join('local_code_group', 'local_code_group.id', '=', 'emr_nurse_manual_values.loinc_local_map_id')
                    ->where('baby_id', $baby_id)
                    ->where('admission_id', $admission_id)
                    ->where('intf_ref_value', '<>', '')
                    ->whereIn('local_code_group.local_code', $manual_nurse_sheet_id)
                    ->whereBetween('result_date_time', [$start_time, $end_time])
                    ->orderBy('result_date_time', 'desc')
                    ->get()
                    ->unique('local_code');

                $prescription_results[0]['intf_ref_value'] = [];

                $prescriptionresults = prescription::getInterfacingData($baby_id, $admission_id, $start_time, $end_time)->groupBy('prescription_id')->map(function ($value, $index) {

                    $value = $value->toArray();
                    if (count($value) > 1) {

                        $first_key = array_key_first($value);
                        $first_value = $value[$first_key];

                        $last_key = array_key_last($value);
                        $last_value = $value[$last_key];

                        $min_value = (isset($last_value->infused) && !empty($last_value->infused) && is_numeric($last_value->infused)) ? $last_value->infused : 0;

                        $max_value = (isset($first_value->infused) && !empty($first_value->infused) && is_numeric($first_value->infused)) ? $first_value->infused : 0;
                        $total_infused = $max_value - $min_value;

                        return $total_infused;

                    }

                })->toArray();

                $prescription_results[0]['intf_ref_value'] = number_format(array_sum($prescriptionresults), 2);

                $prescription_results[0]['local_code'] = 'prescription';
                $prescription_results = (object) $prescription_results;

                $nurse_sheet_result = collect($monitor_results)->merge($ventilator_results);
                $nurse_sheet_result = collect($nurse_sheet_result)->merge($lab_results);
                $nurse_sheet_result = collect($nurse_sheet_result)->merge($manual_results);
                $nurse_sheet_result = collect($nurse_sheet_result)->merge($prescription_results);
                $nurse_sheet_result = collect($nurse_sheet_result)->merge($bilirubin_results);
                $nurse_sheet_result = $nurse_sheet_result->toArray();

                $nurse_sheet_result = collect($nurse_sheet_result)->groupby('local_code');

                $nurse_sheet_id = ['peripheral_temp', 'peripheral_temp', 'hr_rate', 'cuff_systalic_bp', 'arterial_systalic_bp', 'cuff_diastolic_bp', 'arterial_diastolic_bp', 'cuff_mean_bp', 'arterial_mean_bp', 'preductal_sao2', 'postductal_sao2', 'mode_of_ventilation', 'mode_of_ventilation_invasive', 'pip_set', 'pip_delivered', 'peep', 'map', 'fio2', 'delivered_fio2', 'flow', 'rate', 'frequency', 'it_rate_secound', 'blood_gas_ph', 'blood_gas_pao2', 'blood_gas_paco2', 'blood_gas_hco3', 'blood_gas_be', 'blood_gas_lactate', 'gluco_meter_platelets', 'gluco_meter_crp', 'prescription', 'gluco_meter_wbc', 'gluco_meter_dc', 'manual_calc_anc', 'respiratory_rate', 'current_weight', 'working_weight', 'blood_sugar', 'interface_blood_gas_bilirubin', '', ''];

                $daycare_id = ['PeripheralTemperature', 'peripheral_fahrenheit', 'HR', 'systolic_bp', 'systolic_bp', 'diastolic_bp', 'diastolic_bp', 'MeanBP', 'MeanBP', 'SaO2PostDuctal', 'SaO2PostDuctal', '', 'mode_of_ventilation_invasive', 'pip_set', 'pip_delivered', 'PEEP', 'MAP', 'fio2_set', 'fio2_delivered', 'Flow', 'Rate', 'frequency_rep', 'IT', 'Ph', 'PaO2', 'PaCo2', 'HCO3', 'BE', 'Lactate', 'Platelets', 'CRP', 'iv_fluids', 'TLC', 'Percentage', 'ANC', 'RR', 'CurrentWt', 'workingWeight', 'RBS', 'TSB', 'InvasiveVentilation', 'ModeOfVentilation', 'Ventilation_choose', 'NonInvasiveVentilation', 'WtChange', 'urine_output_day', 'temp_UO'];

                foreach ($nurse_sheet_result as $key => $value) {

                    $index = array_search($key, $nurse_sheet_id);

                    $sheet_val = (object) $value->first();
                    if ($key == 'mode_of_ventilation') {

                        if ($sheet_val->intf_ref_value != '' && $sheet_val->intf_ref_value == 'CPAP' || $sheet_val->intf_ref_value == 'NIPPV' || $sheet_val->intf_ref_value == 'HHHFNC' || $sheet_val->intf_ref_value == 'Nasal HFOV') {

                            $result['InvasiveVentilation'] = 'No';

                            $result['Ventilation_choose'] = 'NonInvasiveVentilation';

                            if ($sheet_val->intf_ref_value == 'NIPPV') {
                                $result['Ventilation_choose'] = 'NIMV/NIPPV';
                            } else if ($sheet_val->intf_ref_value == 'Nasal HFOV') {
                                $result['Ventilation_choose'] = 'nHFOV';
                            } else {
                                $result['NonInvasiveVentilation'] = $sheet_val->intf_ref_value;
                            }

                        } elseif ($sheet_val->intf_ref_value == 'NPO2' || $sheet_val->intf_ref_value == 'HBO2' || $sheet_val->intf_ref_value == 'Face mask oxygen') {

                            $result['InvasiveVentilation'] = 'No';

                            $result['Ventilation_choose'] = 'OtherRespiratorySupport';
                            $result['NonInvasiveVentilation'] = $sheet_val->intf_ref_value;

                        } elseif ($sheet_val->intf_ref_value == 'CMV' || $sheet_val->intf_ref_value == 'IMV' || $sheet_val->intf_ref_value == 'SIMV' || $sheet_val->intf_ref_value == 'PSV') {

                            $result['InvasiveVentilation'] = 'Yes';
                            $result['ModeOfVentilation'] = $sheet_val->intf_ref_value;

                        } elseif ($sheet_val->intf_ref_value == 'PTV') {

                            $result['InvasiveVentilation'] = 'Yes';
                            $result['ModeOfVentilation'] = 'A/C or PTV';

                        } elseif ($sheet_val->intf_ref_value == 'HFOV') {

                            $result['InvasiveVentilation'] = 'Yes';
                            $result['ModeOfVentilation'] = 'HFO';

                        }

                    } elseif ($key == 'peripheral_temp') {
                        $daycare_key = $daycare_id[$index];

                        if (isset($sheet_val->intf_ref_value) && $sheet_val->intf_ref_value != '') {
                            if ($sheet_val->intf_ref_value >= 32 && $sheet_val->intf_ref_value <= 42) {
                                $result['PeripheralTemperature'] = $sheet_val->intf_ref_value;
                            } else if ($sheet_val->intf_ref_value >= 92 && $sheet_val->intf_ref_value <= 102) {
                                $result['peripheral_fahrenheit'] = $sheet_val->intf_ref_value;
                            } else {
                                $result['peripheral_fahrenheit'] = '';
                                $result[$daycare_key] = '';
                            }
                        } else {
                            $result[$daycare_key] = '';
                        }
                    } else if ($key == 'gluco_meter_crp') {
                        $daycare_key = $daycare_id[$index];
                        if (isset($sheet_val->intf_ref_value)) {
                            $result[$daycare_key] = preg_replace('/[^0-9<.>]/', '', $sheet_val->intf_ref_value);
                        }
                    } else if ($key == 'postductal_sao2') {
                        $daycare_key = $daycare_id[$index];
                        if (isset($sheet_val->intf_ref_value) && !empty($sheet_val->intf_ref_value)) {
                            $result[$daycare_key] = $sheet_val->intf_ref_value;
                        }
                    } else if ($key == 'cuff_systalic_bp') {
                        $daycare_key = $daycare_id[$index];
                        if (isset($sheet_val->intf_ref_value) && !empty($sheet_val->intf_ref_value)) {
                            $result[$daycare_key] = $sheet_val->intf_ref_value;
                        }
                    } else if ($key == 'cuff_diastolic_bp') {
                        $daycare_key = $daycare_id[$index];
                        if (isset($sheet_val->intf_ref_value) && !empty($sheet_val->intf_ref_value)) {
                            $result[$daycare_key] = $sheet_val->intf_ref_value;
                        }
                    } else if ($key == 'cuff_mean_bp') {
                        $daycare_key = $daycare_id[$index];
                        if (isset($sheet_val->intf_ref_value) && !empty($sheet_val->intf_ref_value)) {
                            $result[$daycare_key] = $sheet_val->intf_ref_value;
                        }
                    } else if ($key == 'arterial_systalic_bp') {
                        $daycare_key = $daycare_id[$index];
                        if (isset($sheet_val->intf_ref_value) && !empty($sheet_val->intf_ref_value)) {
                            $result[$daycare_key] = $sheet_val->intf_ref_value;
                        }
                    } else if ($key == 'arterial_diastolic_bp') {
                        $daycare_key = $daycare_id[$index];
                        if (isset($sheet_val->intf_ref_value) && !empty($sheet_val->intf_ref_value)) {
                            $result[$daycare_key] = $sheet_val->intf_ref_value;
                        }
                    } else if ($key == 'arterial_mean_bp') {
                        $daycare_key = $daycare_id[$index];
                        if (isset($sheet_val->intf_ref_value) && !empty($sheet_val->intf_ref_value)) {
                            $result[$daycare_key] = $sheet_val->intf_ref_value;
                        }
                    } else if ($key == 'working_weight') {
                        $daycare_key = $daycare_id[$index];
                        if (isset($sheet_val->intf_ref_value) && !empty($sheet_val->intf_ref_value)) {
                            $result[$daycare_key] = $sheet_val->intf_ref_value;
                        }
                    } else {
                        $daycare_key = $daycare_id[$index];
                        if (isset($sheet_val->intf_ref_value)) {
                            $result[$daycare_key] = $sheet_val->intf_ref_value;
                        }
                    }
                }

                if (isset($nurse_sheet_result['gluco_meter_wbc'][0]->intf_ref_value) && isset($nurse_sheet_result['gluco_meter_dc'][0]->intf_ref_value)) {

                    $wbc = $nurse_sheet_result['gluco_meter_wbc'][0]->intf_ref_value;
                    $dc = $nurse_sheet_result['gluco_meter_dc'][0]->intf_ref_value;

                    $result['ANC'] = $wbc * ($dc / 100);
                }

                $previous_date = date('Y-m-d', strtotime('-1 day', strtotime($select_date_time)));

                $sheet_details = NurseSheetMain::GetNurseSheet($previous_date, $baby_id, $admission_id);

                if (isset($sheet_details->total_output)) {
                    $result['urine_output_day'] = number_format($sheet_details->total_output, 1);
                    $result['temp_UO'] = \ValuelistHelpers::urineOutputHour($admission_id, $sheet_details->current_weight);
                }


            }
            return \Response::json(['results' => $result, 'daycare_id' => $daycare_id], 200);
        }
    }
}

