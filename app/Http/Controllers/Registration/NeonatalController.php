<?php
namespace App\Http\Controllers\Registration;

use Carbon\Carbon;
use App\Models\Neonatal;
use App\Models\Baby;
use App\Models\Mother;
use App\Models\Settings\Settings;
use App\Models\Problems;
use App\Models\Complication;
use App\Models\Delivery;
use App\Models\Usg;
use App\Models\Nicu;
use App\Models\Admission;
use App\Models\Newborn;
use App\Models\Settings\DeleteApproval;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Masters\MediprobsMaster as MediprobsMaster;
use App\Models\Masters\Complications as ComplicationMaster;
// use App\Models\Masters\Drug as DrugMaster;
use App\Models\Masters\DrugIvFluidMaster;
use App\Models\Masters\Indication;
use App\Models\Medications;
use Illuminate\Http\Request;
use App\Http\Requests\NeonatalRequest;
use App\Http\Controllers\Controller;
use App\Models\PostnatalDischarge;
use App\Http\Controllers\Flow\FlowController;
use App\Models\FlowControl;
use App\Models\Postnatal;
use App\Models\Ward\BedLog;
use App\Models\Masters\Bed;
use App\Models\Masters\Ward;

class NeonatalController extends Controller
{
    /**
     * This used for usg flage to sperate from nicu
     * module
     * @var $usg_flags type integer
     */
    public $usg_flags;

    /**
     * This used to taging the text area fields
     *
     * @var $auto_tag_fields  type array
     */
    public $auto_tag_fields;

    /**
     * This used to define the multiple pregancy common values
     *
     * @var $common_mp_fields type array
     */
    public $common_mp_fields;

    /**
     * This used to define the
     * Guard intance
     * @var $auth
     */
    public $auth;

    /**
     * construct method
     * Method to initialize the global variable &
     * checking the permission for module
     * @param $auth type instance of Guard
     *
     */
    public function __construct(Guard $auth, FlowController $flow)
    {
        $this->middleware('role:NEONATAL,write', ['only' => ['store', 'update', 'edit', 'create', 'destory']]);
        $this->middleware('role:NEONATAL,read', ['only' => ['index', 'show']]);
        $this->auth = $auth;
        $this->usg_flags = 1;
        $this->auto_tag_fields = array(
            'OtherInformation',
            'OtherInvestigations',
            'InitialExamination',
            'MalformationType',
            'Background',
            'PLAN',
            'AnyOtherAbnormality'
        );
        $this->common_mp_fields = array(
            'TestDate',
            'TEST_TIME',
            'TEST_MINS',
            'TEST_AM',
            'MotherName',
            'MotherLastName',
            'MotherInitial',
            'MotherTitle',
            'PartnerTitle',
            'PartnerInitial',
            'Email',
            'Address1',
            'Address2',
            'Address3',
            'Address4',
            'Mobile',
            'MotherDOB',
            'City',
            'State',
            'Country',
            'PartnerName',
            'PartnerContact',
            'PartnerDOB',
            'PartnerOccupation',
            'LandLine',
            'Occupation',
            'G_Value',
            'P_Value',
            'L_Value',
            'A_Value',
            'G_sequence',
            'MMrNo',
            'UserAdded',
            'DateAdded',
            'DateModified',
            'UserDeleted',
            'IsDeleted',
            'MothercYear',
            'MotherEmail',
            'PartnerMobile',
            'PartnercYear',
            'PartnerLastName',
            'Postcode',
            'Address5',
            'FatherAddress1',
            'FatherAddress2',
            'MotherBloodGroup',
            'FatherSpokenLanguages',
            'MotherSpokenLanguages',
            'Conception',
            'LMP',
            'EDDbyUSG',
            'EDDbyDates',
            'MotherBloodGroup',
            'HIV',
            'HepatitisB',
            'VDRL',
            'Booked',
            'Booking',
            'Supervised',
            'PlaceofSupervision',
            'MultiplePregnancy',
            'PregnancyComplications',
            'AntenatalSteroids',
            'LastDoseDeliveryInterval',
            'TypeofAnesthesia',
            'TypeofART',
            'EmbryoTransfer',
            'PlaceofART'
        );
        $this->flow = $flow;
        $this->time_zone = env('TIME_ZONE');
    }

    /**
     * Display a listing of the baby resource.
     *
     * @param Illuminate\Http\Request
     * @return Response
     */
    public function index(Request $request)
    {
        if (\Session::has('NeonatalDichargeList'))
        {
            \Session::forget('NeonatalDichargeList');
        }
        $navigate['main_nav'] = 'neo_proforma';
        $navigate['sub_nav'] = 'neo_admission_proforma';
        $this
            ->flow
            ->clearFlow();

        return $this->common_list($request, $navigate);
    }

    /**
     * Display a listing of the resource.
     * @param Illuminate\Http\Request
     * @return Response
     */
    public function neonatalDichargelist(Request $request)
    {

        \Session::put('NeonatalDichargeList', 'Neonatal-Dicharge-List');
        $navigate['main_nav'] = 'postnatal';
        $navigate['sub_nav'] = 'neo_discharge_proforma';
        return $this->common_list($request, $navigate);
    }

    /**
     * Display a listing of the resource.
     * @param Illuminate\Http\Request
     * @param $navigate type array
     * @return Response
     */
    private function common_list($request, $navigate)
    {
        $limit = 50;
        if (!empty($request->input('limit')))
        {
            $request->session()->put('limit', $request->input('limit'));
            $limit = $request->session()->get('limit');
        }
        elseif ($request->session()->has('limit'))
        {
            $limit = $request->session()->get('limit');
        }

        $order['sortby'] = 'NeonatalId';
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
        
        $search['status'] = '';
        if (!empty($request->input('status')))
        {
            $search['status'] = $request->input('status');
        }

        $result = Neonatal::get_lists($request->input('page') , $limit, $search, $order, 1); //Baby->mothers()->get->toArray();
        $results = $result['result'];

        foreach ($results as & $value)
        {

            $value->hasAdmission = false;

            $nicu_admission_check = Neonatal::getNeonatalDependancy($value->BabyId, 1);
            $postanatal_admission_check = Neonatal::getNeonatalDependancy($value->BabyId, 2);

            if (count($nicu_admission_check) > 0 || count($postanatal_admission_check) > 0)
            {

                $value->hasAdmission = true;

            }

        }

        $getTotal = Neonatal::GetTotal();
        $total = $result['total'];

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

        return view('registration.neonatal.neonatal_list', compact('results', 'navigate', 'pagination', 'order', 'search', 'getTotal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id type integer
     * @return Response
     */
    public function create($id = 0, Request $request)
    {
        $id = \SiteHelpers::decrypt_id($id);
        $check_proforma = Neonatal::checkNeonatal($id)->last();
        if (count($check_proforma) > 0) {
            return redirect(action('Registration\NeonatalController@edit', \SiteHelpers::encrypt_id($check_proforma->NeonatalId)));
        }
        $flow_wise_register = $request->get('flow');
        $navigate['main_nav'] = 'neo_proforma';
        $navigate['sub_nav'] = 'neonatal';
        $SubmitButtonText = "Save & Close";
        $SavedhereText = "Save";
        if ($id != 0)
        {
            $baby_detail1 = Baby::get_data($id);
            $baby_detail = $baby_detail1[0];

            if (date('Y', strtotime($baby_detail->DOB)) > 1980) $baby_detail->DOB = date('d-m-Y', strtotime($baby_detail->DOB));
            else $baby_detail->DOB = '';

            if (!is_null($baby_detail->PartnerDOB))
            {
                $baby_detail->PartnerDOB = date('d-m-Y', strtotime($baby_detail->PartnerDOB));
            }
            else
            {
                $baby_detail->PartnerDOB = '';
            }

            if (!is_null($baby_detail->MotherDOB))
            {
                $baby_detail->MotherDOB = date('d-m-Y', strtotime($baby_detail->MotherDOB));
            }
            else
            {
                $baby_detail->MotherDOB = '';
            }

            $baby_detail->BirthWeight = !empty($baby_detail->BirthWeight) ? $baby_detail->BirthWeight : 0;
            $baby_detail->BirthWeight_in_kilo = !empty($baby_detail->BirthWeight) ? $baby_detail->BirthWeight / 1000 : 0;
        }
        else $baby_detail = array();

        $delivery_indications = Indication::getFieldvalue();

        $Probs = MediprobsMaster::get_lists();
        $Complications = ComplicationMaster::get_lists();

        $probs[0] = 'N/A';
        foreach ($Probs as $vac)
        {
            $probs[$vac
                ->Id] = $vac->Name;
        }

        foreach ($Complications as $drug)
        {
            $complication_master[$drug
                ->Id] = $drug->Name;
        }
        $current_date = date('d-m-Y');
        $tob['time'] = array();
        for ($i = 1;$i <= 12;$i++)
        {
            $tob['time'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
        }
        $tob['mins'] = array();
        for ($i = 0;$i <= 59;$i++)
        {
            $tob['mins'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
        }

        $times = date('g:i:A', strtotime(Carbon::now(env('TIME_ZONE'))));
        $test_time = explode(':', $times);

        $baby_detail->TEST_TIME = $test_time['0'];
        $baby_detail->TEST_MINS = $test_time['1'];
        $baby_detail->TEST_AM = $test_time['2'];
        $baby_detail->HIV = 'Non-reactive';
        $baby_detail->HepatitisB = 'Negative';
        $baby_detail->VDRL = 'Non-reactive';

        $pbm_data = $complication = $delivery_details = array();

        if (isset($baby_detail->MotherId)) {
            $silbing_baby_details = Baby::multiple_baby_check($baby_detail->MotherId)->where('BabyId', '<>', $baby_detail->BabyId);         
            if (count($silbing_baby_details) > 0) {
                $silbing_baby_details = $silbing_baby_details->first();
                $silbing_dob = date('Y-m-d', strtotime($silbing_baby_details->DOB));
                $current_dob = date('Y-m-d', strtotime($baby_detail->DOB));
                $silbing_dob = Carbon::createFromFormat('Y-m-d', $silbing_dob);
                $current_dob = Carbon::createFromFormat('Y-m-d', $current_dob)->subDay();
                $date_diff = $silbing_dob->diffInDays($current_dob);

                if ($date_diff <= 1) {
                    $baby_detail->Baby_group_id = $silbing_baby_details->BabyId;
                }
            }

        }

        if (isset($baby_detail->Baby_group_id) && !empty($baby_detail->Baby_group_id))
        {
            $silbings_data = (array)Neonatal::getSlibingsdata($baby_detail->Baby_group_id);
            $baby_detail = (array)$baby_detail;
            foreach ($this->common_mp_fields as $value)
            {
                if (isset($silbings_data[$value]))
                {
                    $baby_detail[$value] = $silbings_data[$value];
                }
            }
            $pbm_data_temp = Problems::where('BabyId', '=', $baby_detail['Baby_group_id'])->get();

            foreach ($pbm_data_temp as $pb)
            {
                $pbm_data[] = array(
                    'Medication' => $pb->Medication,
                    'Problem' => $pb->Problem
                );
            }
            $complication_temp = Complication::where('BabyId', '=', $baby_detail['Baby_group_id'])->get();

            foreach ($complication_temp as $com)
            {
                $complication[] = array(
                    'Complication' => $com->Complication,
                    'Treatment' => $com->Treatment
                );
            }
            $temp_delivery = Delivery::where('MotherId', '=', $baby_detail['MotherId'])->get();

            foreach ($temp_delivery as $deliverys)
            {
                $delivery_details[] = array(
                    'Year' => $deliverys->Year,
                    'Place' => $deliverys->Place,
                    'Delivery' => $deliverys->Delivery,
                    'Complications' => $deliverys->Complications,
                    'Gender' => $deliverys->Gender,
                    'GA' => $deliverys->GA,
                    'BW' => $deliverys->BW,
                    'Health' => $deliverys->Health,
                    'MotherId' => $deliverys->Moth,
                );
            }
            $baby_detail = (object)$baby_detail;
        }

        $temp = json_decode($baby_detail->Gestation);
        $temp = is_array($temp) ? $temp : (array)$temp;
        $baby_detail->g_weeks = (isset($temp['g_weeks'])) ? $temp['g_weeks'] : '';
        $baby_detail->g_days = (isset($temp['g_days'])) ? $temp['g_days'] : '';
        $saveNext = 'Next';

        if (\Session::has('registration_start') && \Session::has('admission_module') && \Session::get('admission_module') == 'NICU_ADMISSION')
        {
            $baby_detail->transfer_status = 'NICU';
            $ward_name = 'NICU';
        }
        elseif (\Session::has('registration_start') && \Session::has('admission_module') && \Session::get('admission_module') == 'POSTNATAL_ADMISSION')
        {
            $baby_detail->transfer_status = 'Postnatal Ward';
            $ward_name = 'Postnatal';
        }

        // $bed_logs = BedLog::where('baby_id', $id)->where('status', 'Occupied')->orderBy('id', 'desc')->first();
        
        // if (count($bed_logs) != 0) {
        //     $bed_logs = $bed_logs->toArray();
        // }

        // $room_list = \DB::table('room')
        //             ->select('room.id', 'room.number')
        //             ->join('bed', 'bed.room_id', '=', 'room.id')
        //             ->join('ward', 'ward.id', '=', 'room.ward_id');
        //             if (isset($ward_name) && $ward_name != '') {
        //                 $room_list->where('ward.name', $ward_name);
        //             }
        // $room_list = $room_list->orderBy('room.number', 'asc')
        //             ->pluck('number', 'id')
        //             ->toArray();

        // $table = 'neonatal_proforma';
        // $column_name = 'BabyId';
        // $primary_column_name = 'NeonatalId';

        // $result = \DB::table($table)->select($primary_column_name)->where($column_name, $id)->orderby($primary_column_name)->first();

        // if (isset($result->NeonatalId) && !empty($result->NeonatalId) && $result->NeonatalId != null) {
        //     return redirect(action('Registration\NeonatalController@edit', \SiteHelpers::encrypt_id($result->NeonatalId)));
        // }

        // return view('registration.neonatal.neonatal_create', compact('SubmitButtonText', 'complication_master', 'probs', 'navigate', 'baby_detail', 'current_date', 'tob', 'SavedhereText', 'delivery_indications', 'pbm_data', 'complication', 'delivery_details', 'saveNext','room_list', 'bed_logs'));
        $get_nicu_id = \DB::table('nicu_admission')->select('NicuId')->where('BabyId', $baby_detail->BabyId)->where('status', 'Inpatient')->orderBy('AdmissionDate', 'desc')->first();
        $current_nicu_id = 0;
        if (isset($get_nicu_id->NicuId) && !empty($get_nicu_id->NicuId)) {
            $current_nicu_id = $get_nicu_id->NicuId;
        }
        return view('registration.neonatal.neonatal_create', compact('SubmitButtonText', 'complication_master', 'probs', 'navigate', 'baby_detail', 'current_date', 'tob', 'SavedhereText', 'delivery_indications', 'pbm_data', 'complication', 'delivery_details', 'saveNext', 'flow_wise_register', 'current_nicu_id'));
    }

    /**
     * Store a newly created entry.
     *
     * @return Response
     */
    public function store(NeonatalRequest $request)
    {

        $input = $request->all();
        // if (isset($input['transfer_status']) && $input['transfer_status'] == 'NICU') {
        //     $validated = $request->validate([
        //         'room_no' => 'required',
        //         'bed_no' => 'required',
        //     ]);
        //     if (!$validated) {
        //         return Redirect::back()->withErrors(['msg', 'Please fill room and bed no']);
        //     }
        // }
        $print_flag = isset($input['print_flag']) ? $input['print_flag'] : 0;

        unset($input['print_flag']);

        //   $tags=AutoTagMasters::auto_key_support($this->auto_tag_fields,$input);
        $input['MotherDOB'] = (!empty($input['MotherDOB'])) ? date('Y-m-d', strtotime($input['MotherDOB'])) : null;
        $input['PartnerDOB'] = (!empty($input['PartnerDOB'])) ? date('Y-m-d', strtotime($input['PartnerDOB'])) : null;

        $input['sepsis_in_mother_type'] = isset($input['sepsis_in_mother_type']) ? json_encode($input['sepsis_in_mother_type']) : null;

        $input['DOB'] = date('Y-m-d', strtotime($input['DOB']));

        $input['indication_of_admission'] = isset($input['indication_of_admission']) ? json_encode($input['indication_of_admission']) : null;

        $input['DateOfDischarge'] = (!empty($input['DateOfDischarge'])) ? date('Y-m-d', strtotime($input['DateOfDischarge'])) : '';
        $input['OpAppointment'] = (!empty($input['OpAppointment'])) ? date('Y-m-d', strtotime($input['OpAppointment'])) : '';
        $input['TestDate'] = date('Y-m-d', strtotime($input['TestDate']));

        $input['LMP'] = (!empty($input['LMP'])) ? date('Y-m-d', strtotime($input['LMP'])) : null;
        $input['EDDbyUSG'] = (!empty($input['EDDbyUSG'])) ? date('Y-m-d', strtotime($input['EDDbyUSG'])) : null;
        $input['EDDbyDates'] = (!empty($input['EDDbyDates'])) ? date('Y-m-d', strtotime($input['EDDbyDates'])) : null;

        $input['Vaccine'] = (isset($input['Vaccine']) && count($input['Vaccine']) != 0) ? serialize($input['Vaccine']) : '';
        $input['VaccineDate'] = (isset($input['VaccineDate']) && count($input['VaccineDate']) != 0) ? serialize($input['VaccineDate']) : '';
        if (isset($input['gestations']))
        {
            $input['gestations'] = (count($input['gestations']) != 0) ? serialize($input['gestations']) : serialize(array());
            $input['findings'] = (count($input['findings']) != 0) ? serialize($input['findings']) : serialize(array());
        }

        $input['MaternalAntibiotics'] = (isset($input['MaternalAntibiotics']) && count($input['MaternalAntibiotics']) != 0 && !empty($input['MaternalAntibiotics'][0])) ? json_encode($input['MaternalAntibiotics']) : '';
        $input['BirthStatus'] = (isset($input['BirthStatus']) && $input['BirthStatus'] == 'on') ? 'Inborn' : 'Outborn';
        $input['Booked'] = (isset($input['Booked']) && $input['Booked'] == 'on') ? 'Yes' : 'No';
        $input['Supervised'] = (isset($input['Supervised']) && $input['Supervised'] == 'on') ? 'Yes' : 'No';

        $input['delivery_room_cpap'] = (isset($input['delivery_room_cpap']) && $input['delivery_room_cpap'] == 'on') ? 'Yes' : 'No';
        $input['bag_mask_ventilator'] = (isset($input['bag_mask_ventilator']) && $input['bag_mask_ventilator'] == 'on') ? 'Yes' : 'No';
        $input['bag_mask_ventilator_duration'] = (isset($input['bag_mask_ventilator_duration']) && $input['bag_mask_ventilator_duration'] == 'on') ? 'known' : 'Unknown';

        $input['MultiplePregnancy'] = (isset($input['MultiplePregnancy']) && $input['MultiplePregnancy'] == 'on') ? 'Yes' : 'No';
        $input['Consanguinity'] = (isset($input['Consanguinity']) && $input['Consanguinity'] == 'on') ? 'Yes' : 'No';
        $input['PregnancyComplications'] = (isset($input['PregnancyComplications']) && $input['PregnancyComplications'] == 'on') ? 'Yes' : 'No';
        $input['AntenatalSteroids'] = (isset($input['AntenatalSteroids']) && $input['AntenatalSteroids'] == 'on') ? 'Yes' : 'No';
        $input['Labour'] = (isset($input['Labour']) && $input['Labour'] == 'on') ? 'Yes' : 'No';
        $input['MaternalPyrexia'] = (isset($input['MaternalPyrexia']) && $input['MaternalPyrexia'] == 'on') ? 'Yes' : 'No';
        $input['maternal_pyrexia_celsius'] = (isset($input['maternal_pyrexia_celsius'])) ? $input['maternal_pyrexia_celsius'] : 0;
        $input['maternal_pyrexia_fahrenheit'] = (isset($input['maternal_pyrexia_fahrenheit'])) ? $input['maternal_pyrexia_fahrenheit'] : 0;
        $input['PROM'] = (isset($input['PROM']) && $input['PROM'] == 'on') ? 'Yes' : 'No';

        $input['FacialOxygen'] = (isset($input['FacialOxygen']) && $input['FacialOxygen'] == 'on') ? 'Yes' : 'No';
        $input['Intubation'] = (isset($input['Intubation']) && $input['Intubation'] == 'on') ? 'Yes' : 'No';
        $input['PPV'] = (isset($input['PPV']) && $input['PPV'] == 'on') ? 'Yes' : 'No';
        $input['CPR'] = (isset($input['CPR']) && $input['CPR'] == 'on') ? 'Yes' : 'No';
        $input['Drugs'] = (isset($input['Drugs']) && $input['Drugs'] == 'on') ? 'Yes' : 'No';
        $input['Resuscitation'] = (isset($input['Resuscitation']) && $input['Resuscitation'] == 'on') ? 'Yes' : 'No';
        $input['timeofgasp_status'] = (isset($input['timeofgasp_status']) && $input['timeofgasp_status'] == 'on') ? true : false;
        $input['regularrespiration_status'] = (isset($input['regularrespiration_status']) && $input['regularrespiration_status'] == 'on') ? true : false;
        $input['insertion_status'] = (isset($input['insertion_status']) && $input['insertion_status'] == 'on') ? true : false;
        $input['ppv_status'] = (isset($input['ppv_status']) && $input['ppv_status'] == 'on') ? true : false;
        $input['cpr_status'] = (isset($input['cpr_status']) && $input['cpr_status'] == 'on') ? true : false;

        $input['Gestation'] = json_encode(array(
            'g_weeks' => $input['g_weeks'],
            'g_days' => $input['g_days']
        ));
        $input['known_field'] = (isset($input['known_field']) && $input['known_field'] == 'on') ? 1 : 2;
        $input['Indication'] = isset($input['Indication']) ? json_encode($input['Indication']) : json_encode(array());
        $input['adjustedtrisomies'] = (isset($input['adjustedtrisomies']) && $input['adjustedtrisomies'] == 'on') ? 2 : 1;

        $input['newbornStatus'] = (isset($input['newbornStatus']) && $input['newbornStatus'] == 'on') ? 2 : 1;

        $input['g_weeks'] = empty($input['g_weeks']) ? null : trim($input['g_weeks']);
        $input['g_days'] = empty($input['g_days']) ? null : trim($input['g_days']);
        $input['Scalp'] = isset($input['Scalp']) ? implode(',', $input['Scalp']) : '';
        $input['maximum_fio2_required'] = isset($input['maximum_fio2_required']) && !empty($input['maximum_fio2_required']) ? $input['maximum_fio2_required'] : null;
        $input['duration_of_cpr'] = isset($input['duration_of_cpr']) && !empty($input['duration_of_cpr']) ? $input['duration_of_cpr'] : null;

        $input['resusciatation_drugs'] = isset($input['resusciatation_drugs']) ? json_encode($input['resusciatation_drugs']) : json_encode(array());

        $input['discharge_length'] = isset($input['discharge_length']) && !empty($input['discharge_length']) ? $input['discharge_length'] : null;
        $input['discharge_ofc'] = isset($input['discharge_ofc']) && !empty($input['discharge_ofc']) ? $input['discharge_ofc'] : null;

        if ($input['MotherId'] != '' && $input['MotherId'] != 0)
        {
            $mother = Mother::findOrfail($input['MotherId']);
            $input['MotherId'] = $mother->MotherId;
            // $mother->update($input);
        }
        else
        {
            $mrno = rand(100000000000, 999999999999);
            /* GENERATE UNIQUE MrNo FOR MOTHER */
            do
            {
                $mrno = Settings::GenerateMMR();
            }
            while (Settings::ValidateMMR($mrno));
            $input['MMrNo'] = $mrno;

            // $mother = Mother::create($input);
            $input['MotherId'] = $mother->MotherId;
        }
        if ($input['BabyId'] != '' && $input['BabyId'] != 0)
        {
            $baby = Baby::findOrfail($input['BabyId']);
            $input['BMrNo'] = $baby->BMrNo;
            $baby->update($input);
        }
        else
        {
            $mrno = rand(100000000000, 999999999999);
            /* GENERATE UNIQUE MrNo FOR BABY */
            do
            {
                $mrno = Settings::GenerateBMR();
            }
            while (Settings::ValidateBMR($mrno));
            $input['BMrNo'] = $mrno;
            $baby = Baby::create($input);
            $input['BabyId'] = $baby->BabyId;
        }
        $flowControl = FlowControl::find(\Session::get('ficd'));
        $is_new_patient = (isset($flowControl->is_new_patient) && \Session::has('registration_start')) ? $flowControl->is_new_patient : true;
        $admission_module = \Session::has('registration_start') ? \Session::get('admission_module') : 'POSTNATAL_ADMISSION';

        if (isset($input['transfer_status']) && $input['transfer_status'] == "Postnatal Ward" && !\Session::has('registration_start'))
        {
            $episodes = Admission::where('BabyId', $input['BabyId'])->count();
            $episodes += 1;
            $admission_data = array(
                'BabyId' => $input['BabyId'],
                'BMrNo' => $input['BMrNo'],
                'MotherId' => $input['MotherId'],
                'AdmissionDate' => $input['TestDate'],
                'AdmissionTime' => $input['TEST_TIME'] . ':' . $input['TEST_MINS'] . ':' . $input['TEST_AM'],
                'InOrOut' => 'In',
                'AdmissionType' => 'Post',
                'Status' => "Inpatient",
                'UserAdded' => $this->auth->user()->id,
                'DateAdded' => date('Y-m-d H:i:s'),
                'DateModified' => date('Y-m-d H:i:s'),
                'UserModified' => $this->auth->user()->id,
                'episodes' => 'Admission ' . $episodes,
            );
            $prev_admission_status = Admission::select('AdmissionId')->where('BabyId', $input['BabyId'])->where('Status', 'Inpatient')
                ->first();
            if (count($prev_admission_status) != 0)
            {
                $admission = $prev_admission_status;
            }
            else
            {
                $admission = Admission::create($admission_data);
            }
            $admission_data['AdmissionId'] = $input['AdmissionId'] = $admission->AdmissionId;
            $admission_data['discharge_status'] = 'Inpatient';
            Postnatal::create($admission_data);
            PostnatalDischarge::create($admission_data);
        }

        if (isset($input['transfer_status']) && ($input['transfer_status'] == "NICU" || $input['transfer_status'] == "HDU" || $input['transfer_status'] == "SCBU" || $input['transfer_status'] == "Nursery" || $input['transfer_status'] == "Postnatal Ward") && !\Session::has('registration_start'))
        {
            $episodes = Admission::where('BabyId', $input['BabyId'])->count();
            $episodes += 1;
            $admission_data = array(
                'BabyId' => $input['BabyId'],
                'BMrNo' => $input['BMrNo'],
                'MotherId' => $input['MotherId'],
                'AdmissionDate' => $input['TestDate'],
                'AdmissionTime' => $input['TEST_TIME'] . ':' . $input['TEST_MINS'] . ':' . $input['TEST_AM'],
                'InOrOut' => 'In',
                'AdmissionType' => 'NICU',
                'Status' => "Inpatient",
                'UserAdded' => $this
                    ->auth
                    ->user()->id,
                'DateAdded' => date('Y-m-d H:i:s'),
                'DateModified' => date('Y-m-d H:i:s'),
                'UserModified' => $this
                    ->auth
                    ->user()->id,
                'episodes' => 'Admission ' . $episodes,
            );
            $prev_admission_status = Admission::select('AdmissionId')->where('BabyId', $input['BabyId'])->where('Status', 'Inpatient')
                ->first();
            if (count($prev_admission_status) != 0)
            {
                $admission = $prev_admission_status;
            }
            else
            {
                $admission = Admission::create($admission_data);
            }
            $admission_id = $admission->AdmissionId;

            $baby_gestation = array();
            $baby_gestation['CorrectedGestation'] = json_encode(array(
                'cg_weeks' => '',
                'cg_days' => ''
            ));

            if (!empty($baby->DOB))
            {
                $baby_gestation['DayOfLife'] = \SiteHelpers::calculate_day_of_life($baby->DOB);
            }
            if (!empty($baby->Gestation))
            {
                $baby_gestation['Gestation'] = \SiteHelpers::convert_gestation_days($baby->Gestation);
            }

            if (isset($baby_gestation['DayOfLife']) && !empty($baby_gestation['DayOfLife']) && isset($baby_gestation['Gestation']) && !empty($baby_gestation['Gestation']))
            {
                $baby->CGA = \SiteHelpers::calculate_corrected_gestation($baby_gestation['Gestation'], $baby_gestation['DayOfLife']);

                $baby_gestation['CorrectedGestation'] = json_encode(array(
                    'cg_weeks' => (int)$baby->CGA[0],
                    'cg_days' => (int)$baby->CGA[1]
                ));
            }

            $nicu_data = array(
                'BabyId' => $input['BabyId'],
                'BMrNo' => $input['BMrNo'],
                'MotherId' => $input['MotherId'],
                'AdmissionId' => $admission_id,
                'AdmissionDate' => $input['TestDate'],
                'AdmissionTime' => $input['TEST_TIME'] . ':' . $input['TEST_MINS'] . ':' . $input['TEST_AM'],
                'Status' => "Inpatient",
                'AdmittedFrom' => "Postnatal",
                'CorrectedGestation' => $baby_gestation['CorrectedGestation'],
                'UserAdded' => $this
                    ->auth
                    ->user()->id,
                'status' => 'Inpatient',
                'DateAdded' => date('Y-m-d H:i:s'),
                'DateModified' => date('Y-m-d H:i:s'),
                'UserModified' => $this
                    ->auth
                    ->user()->id,
                'DescriptionOfResuscitation' => $input['OtherInformation'],
            );
            $input['AdmissionId'] = $admission->AdmissionId;

            $prev_nicu_admission = Nicu::where('status', 'Inpatient')->where('BabyId', $input['BabyId'])->orderBy('AdmissionId', 'desc')
                ->first();
            if (count($prev_nicu_admission) == 0)
            {
                Nicu::create($nicu_data);
            }

        }
        // if (isset($input['transfer_status']) && isset($input['room_id']) && isset($input['bed_id']) && $input['transfer_status'] == 'NICU')
        // {

        //     $check_bed_log = BedLog::where(['baby_id' => $input['BabyId'], 'status' => 'Occupied'])->get();
        //     // $ward['ward_id'] = 1;
        //     $ward['ward_id'] = \SiteHelpers::getWardIdByName($input['transfer_status']);
        //     $ward['ward_name'] = \SiteHelpers::gettable_values('ward', 'name', 'id', $ward['ward_id']);
        //     $ward['room_id'] = $input['room_id'];
        //     $ward['room_no'] = \SiteHelpers::gettable_values('room', 'number', 'id', $input['room_id']);
        //     $ward['bed_id'] = $input['bed_id'];
        //     $ward['bed_no'] = \SiteHelpers::gettable_values('bed', 'number', 'id', $input['bed_id']);
        //     $ward['baby_id'] = $input['BabyId'];
        //     $ward['admission_id'] = (isset($admission_id) ? $admission_id : 0);
        //     $ward['DateAdded'] = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
        //     $ward['UserAdded'] = $this->auth->user()->id;
        //     $ward['DateModified'] = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
        //     $ward['UserModified'] = $this->auth->user()->id;
        //     $ward['IsDeleted'] = 0;
        //     Bed::where('id', $input['bed_id'])->update(['status' => 'Occupied']);
        //     $ward['status'] = 'Occupied';

        //     if (count($check_bed_log) == 0)
        //     {
        //         $patient_bed_log = BedLog::create($ward);
        //     }
        //     else
        //     {
        //         BedLog::where(['baby_id' => $input['BabyId'], 'status' => 'Occupied'])->Update($ward);
        //     }

        // }
        $input['form_status'] = 1;
        $check_proforma = Neonatal::checkNeonatal($input['BabyId'])->last();

        if ($check_proforma) {
            $input['DateModified'] = Carbon::now();
            $input['UserModified'] = $this->auth->user()->id;

            $neo = Neonatal::findOrfail($check_proforma->NeonatalId)->update($input);
            $id = $check_proforma->NeonatalId;
        } else {
            $input['DateAdded'] = Carbon::now();
            $input['UserAdded'] = $this->auth->user()->id;
            $input['DateModified'] = Carbon::now();
            $input['UserModified'] = $this->auth->user()->id;
            $neo = Neonatal::create($input);
            $id = $neo->NeonatalId;
        }
        /* New Born Update or Create */
        $newborn = Newborn::find($input['BabyId']);
        if ($newborn)
        {
            $input['DateModified'] = Carbon::now();
            $input['UserModified'] = $this->auth->user()->id;

            $newborn->update($input);
        }
        else
        {
            $input['DateAdded'] = Carbon::now();
            $input['UserAdded'] = $this->auth->user()->id;
            $input['DateModified'] = Carbon::now();
            $input['UserModified'] = $this->auth->user()->id;
            Newborn::create($input);
        }

        //create usg and findings for dating scan
        $usg_parameters['BabyId'] = $input['BabyId'];
        $usg_parameters['MotherId'] = $input['MotherId'];
        $usg_parameters['flags'] = $this->usg_flags;
        $usg_parameters['type'] = 1;
        Usg::where($usg_parameters)->delete();
        if ((isset($input['datingdate']) && !empty($input['datingdate'])) || (isset($input['datinggestations']) && !empty($input['datinggestations']))) {
            $usg_parameters['date'] = !empty($input['datingdate']) ? date('Y-m-d', strtotime($input['datingdate'])) : null;
            $usg_parameters['Gestation'] = $input['datinggestations'];
            $usg_parameters['Finding'] = $input['datingfindings'];
            Usg::create($usg_parameters);
        }
        unset($usg_parameters);

        //creating usg adn findings for anolog scan
        $usg_parameters['BabyId'] = $input['BabyId'];
        $usg_parameters['MotherId'] = $input['MotherId'];
        $usg_parameters['flags'] = $this->usg_flags;
        $usg_parameters['type'] = 2;
        Usg::where($usg_parameters)->delete();
        if ((isset($input['analogdate']) && !empty($input['analogdate'])) || (isset($input['analoggestations']) && !empty($input['analoggestations']))) {
            $usg_parameters['date'] = !empty($input['analogdate']) ? date('Y-m-d', strtotime($input['analogdate'])) : null;
            $usg_parameters['Gestation'] = $input['analoggestations'];
            $usg_parameters['Finding'] = $input['analogfindings'];
            Usg::create($usg_parameters);
        }
        unset($usg_parameters);

        //creating usg adn findings for other scan
        $usg_parameters['BabyId'] = $input['BabyId'];
        $usg_parameters['MotherId'] = $input['MotherId'];
        $usg_parameters['flags'] = $this->usg_flags;
        $usg_parameters['type'] = 3;
        Usg::where($usg_parameters)->delete();

        if (isset($input['otherdate']) || isset($input['othergestations']))
        {

            for ($i = 0;$i < count($input['othergestations']);$i++)
            {

                if ((isset($input['otherdate'][$i]) && !empty($input['otherdate'][$i])) || (isset($input['othergestations'][$i]) && !empty($input['othergestations'][$i])))
                {
                    $usg = array(
                        'date' => !empty($input['otherdate'][$i]) ? date('Y-m-d', strtotime($input['otherdate'][$i])) : null,
                        'Gestation' => $input['othergestations'][$i],
                        'Finding' => $input['otherfindings'][$i],
                        'MotherId' => $input['MotherId'],
                        'BabyId' => $input['BabyId'],
                        'flags' => $this->usg_flags,
                        'type' => 3,
                    );
                    Usg::create($usg);
                }
            }
        }

        //creating usg adn findings for doppler scan
        $usg_parameters['BabyId'] = $input['BabyId'];
        $usg_parameters['MotherId'] = $input['MotherId'];
        $usg_parameters['flags'] = $this->usg_flags;
        $usg_parameters['type'] = 4;
        Usg::where($usg_parameters)->delete();

        if (isset($input['dopplerdate']) || isset($input['dopplergestations']))
        {

            for ($i = 0;$i < count($input['dopplergestations']);$i++)
            {

                if ((isset($input['dopplerdate'][$i]) && !empty($input['dopplerdate'][$i])) || (isset($input['dopplergestations'][$i]) && !empty($input['dopplergestations'][$i])))
                {
                    $usg = array(
                        'date' => !empty($input['dopplerdate'][$i]) ? date('Y-m-d', strtotime($input['dopplerdate'][$i])) : null,
                        'Gestation' => $input['dopplergestations'][$i],
                        'Finding' => $input['dopplerfindings'][$i],
                        'MotherId' => $input['MotherId'],
                        'BabyId' => $input['BabyId'],
                        'flags' => $this->usg_flags,
                        'type' => 4,
                    );

                    Usg::create($usg);
                }
            }
        }

        if (isset($input['brand_name']))
        {
            for ($i = 0;$i < sizeof($input['brand_name']);$i++)
            {
                $discharge_medications = array(
                    'Medication' => empty($input['formulation'][$i]) ? $input['brand_name'][$i] : $input['formulation'][$i],
                    'Dose' => $input['dose'][$i],
                    'Frequency' => $input['frequency'][$i],
                    'Duration' => $input['duration'][$i],
                    'genericname' => $input['generic_name'][$i],
                    'formulation' => $input['formulation'][$i],
                    'AdmissionId' => (!empty($input['AdmissionId'])) ? $input['AdmissionId'] : 0,
                    'BabyId' => $input['BabyId'],
                    'flag' => 1,
                    'source_id' => 0
                );
                Medications::create($discharge_medications);
            }
        }

        Complication::where('BabyId', '=', $input['BabyId'])->delete();
        if (isset($input['Complication']))
        {
            $com_length = sizeof($input['Complication']);
            for ($i = 0;$i < $com_length;$i++)
            {
                $input['duration_in_weeks'][$i] = empty($input['duration_in_weeks'][$i]) ? null : $input['duration_in_weeks'][$i];
                $input['duration_unit'][$i] = empty($input['duration_unit'][$i]) ? null : $input['duration_unit'][$i];

                if ($input['Complication'][$i] != '' && $input['Complication'][$i] != 0)
                {
                    $comps = array(
                        'Complication' => $input['Complication'][$i],
                        'Treatment' => $input['Treatments'][$i],
                        'duration_in_weeks' => $input['duration_in_weeks'][$i],
                        'duration_unit' => $input['duration_unit'][$i],
                        'AdmissionId' => 1,
                        'BabyId' => $input['BabyId'],
                        'flags' => $this->usg_flags,
                    );
                    Complication::create($comps);
                }
            }
        }
        Problems::where('BabyId', '=', $input['BabyId'])->delete();
        if (isset($input['Problems']))
        {
            $pbm_length = sizeof($input['Problems']);
            for ($i = 0;$i < $pbm_length;$i++)
            {
                if ($input['Problems'][$i] != '' && $input['Problems'][$i] != 0)
                {
                    $pbms = array(
                        'Problem' => $input['Problems'][$i],
                        'Medication' => $input['Medications'][$i],
                        'MotherId' => $mother->MotherId,
                        'BabyId' => $input['BabyId']
                    );
                    Problems::create($pbms);
                }
            }
        }

        if (isset($input['Year']))
        {
            $delivery_length = sizeof($input['Year']);
            for ($i = 0;$i < $delivery_length;$i++)
            {
                $deli_data = array(
                    'Year' => $input['Year'][$i],
                    'Place' => $input['Place'][$i],
                    'Delivery' => $input['Delivery'][$i],
                    'Complications' => $input['Complications'][$i],
                    'Gender' => $input['Gender'][$i],
                    'GA' => $input['GA'][$i],
                    'BW' => $input['BW'][$i],
                    'Health' => $input['Health'][$i],
                    'MotherId' => $input['MotherId'],
                    'details' => $input['details'][$i]
                );
                Delivery::create($deli_data);
            }
        }
        \SiteHelpers::clearBedCookies();
         // Nicu dashboard data updating call
        \SiteHelpers::updateDashboardAtFormUpdation($input['BabyId'], 'Neonatal Proforma');
        if(isset($input['nicu_id']) && !empty($input['nicu_id']))
        {
            $create_nicu_url = action('Admission\NicuController@edit', \SiteHelpers::encrypt_id($input['nicu_id']));
        }
        else
        {
            $create_nicu_url = action('Admission\NicuController@create', \SiteHelpers::encrypt_id($input['BabyId']));
        }

        if (isset($input['flow_wise_register']) && $input['flow_wise_register'] == 'from-dashboard') {
            $edit_proforma_url_with_flow = action('Registration\NeonatalController@edit', \SiteHelpers::encrypt_id($id)).'?flow=from-dashboard#obform'; 
            $edit_proforma_url = action('Registration\NeonatalController@edit', \SiteHelpers::encrypt_id($id)).'?flow=from-dashboard'; 
            $create_nicu_url .= '?flow=from-dashboard';
        }
        else
        {
            $edit_proforma_url_with_flow = action('Registration\NeonatalController@edit', \SiteHelpers::encrypt_id($id)); 
            $edit_proforma_url = action('Registration\NeonatalController@edit', \SiteHelpers::encrypt_id($id)); 
        }

        if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'Neonatal proforma created successfully !', 'id' => $id, 'edit_url' => $edit_proforma_url, 'edit_next_url' => $edit_proforma_url_with_flow, 'create_nicu_url' => $create_nicu_url, 'list_url' => action('Registration\NeonatalController@index'), 'create_postnatal_url' => action('Admission\PostnatalController@show', \SiteHelpers::encrypt_id($input['BabyId'])), 'tag_print_url' => action('Reports\BabyReportController@babyTagprint', $input['BabyId'])], 200);
        }

        if (\Session::has('registration_start'))
        {
            $this->flow->flowlog('NEONATAL', $input['BabyId'], $input['MotherId'], null, false, 'babyform');
        }

        if ($print_flag == 0)
        {

            if (!\Session::has('NeonatalDichargeList')) return redirect(action('Registration\NeonatalController@index'))->with('Success', 'Record saved successfully ');
            else return redirect(action('Registration\NeonatalController@neonatalDichargelist'))
                ->with('Success', 'Record saved successfully ');
        }
        elseif ($print_flag == 1)
        {

            return redirect(action('Registration\NeonatalController@edit', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record saved successfully ');
        }
        elseif ($print_flag == 2)
        {

            return redirect(action('Reports\BabyReportController@babyTagprint', $input['BabyId']));

        }
        elseif ($print_flag == 4)
        {
            return redirect(action('Admission\NicuController@create', \SiteHelpers::encrypt_id($input['BabyId'])))->with('Success', 'Record saved successfully ');
        }
        elseif ($print_flag == 5)
        {

            return redirect(action('Admission\PostnatalController@show', \SiteHelpers::encrypt_id($input['BabyId'])))->with('Success', 'Record saved successfully ');

        }
    }

    /**
     * FUNCTION USED TO PRINT THE DATA
     *
     * @param  int  $id
     */
    public function show($id, Request $request)
    {

        $id = \SiteHelpers::decrypt_id($id);
        $flow_wise_register = $request->get('flow');
        $editor_gen_option = false;

        $result = Neonatal::get_record($id);
        $results = $result[0];

        if (date('Y', strtotime($results->DOB)) > 1980) $results->DOB = date('d-m-Y', strtotime($results->DOB));
        else $results->DOB = '';

        if (date('Y', strtotime($results->TestDate)) > 1980) $results->TestDate = date('d-m-Y', strtotime($results->TestDate));
        else $results->TestDate = '';

        if (!is_null($results->PartnerDOB))
        {
            $results->PartnerDOB = date('d-m-Y', strtotime($results->PartnerDOB));
        }
        else
        {
            $results->PartnerDOB = '';
        }

        if (!is_null($results->MotherDOB))
        {
            $results->MotherDOB = date('d-m-Y', strtotime($results->MotherDOB));
        }
        else
        {
            $results->MotherDOB = '';
        }

        if (date('Y', strtotime($results->DateOfDischarge)) > 1980) $results->DateOfDischarge = date('d-m-Y', strtotime($results->DateOfDischarge));
        else $results->DateOfDischarge = '';

        if (date('Y', strtotime($results->LMP)) > 1980) $results->LMP = date('d-m-Y', strtotime($results->LMP));
        else $results->LMP = '';

        if (date('Y', strtotime($results->EDDbyUSG)) > 1980) $results->EDDbyUSG = date('d-m-Y', strtotime($results->EDDbyUSG));
        else $results->EDDbyUSG = '';

        if (date('Y', strtotime($results->EDDbyDates)) > 1980) $results->EDDbyDates = date('d-m-Y', strtotime($results->EDDbyDates));
        else $results->EDDbyDates = '';

        if (date('Y', strtotime($results->OpAppointment)) > 1980) $results->OpAppointment = date('d-m-Y', strtotime($results->OpAppointment));
        else $results->OpAppointment = '';

        $results->DischargeWeight = ($results->DischargeWeight == 0) ? '' : $results->DischargeWeight;

        $Probs = MediprobsMaster::get_lists();
        $Complications = ComplicationMaster::get_lists();
        $Indication = Indication::ListData();

        $mas_indication = array();
        foreach ($Indication as $indicate)
        {
            $mas_indication[$indicate->Id] = $indicate->indication_name;
        }

        $probs = array();
        foreach ($Probs as $vac)
        {
            $probs[$vac
                ->Id] = $vac->Name;
        }
        $complication_master = array();
        foreach ($Complications as $drug)
        {
            $complication_master[$drug
                ->Id] = $drug->Name;
        }

        $complication = Complication::where('BabyId', '=', $results->BabyId)
            ->where('flags', $this->usg_flags)
            ->get();
        $pbm_data = Problems::where('BabyId', '=', $results->BabyId)
            ->get();
        $delivery_details = Delivery::where('MotherId', '=', $results->MotherId)
            ->get();

        $vaccine = (!empty($results->Vaccine)) ? unserialize($results->Vaccine) : array();
        $vaccine_date = (!empty($results->VaccineDate)) ? unserialize($results->VaccineDate) : array();

        $usg_findings = Usg::where('MotherId', '=', $results->MotherId)
            ->where('BabyId', '=', $results->BabyId)
            ->where('flags', '=', $this->usg_flags)
            ->first();

        $neonatalChild = Neonatal::find($id);
        $datingScan = $neonatalChild
            ->usg_findings
            ->where('type', 1)
            ->where('flags', $this->usg_flags)
            ->first();
        $datingScan = is_null($datingScan) ? [] : $datingScan->toArray();
        $analogScan = $neonatalChild
            ->usg_findings
            ->where('type', 2)
            ->where('flags', $this->usg_flags)
            ->first();
        $analogScan = is_null($analogScan) ? [] : $analogScan->toArray();
        $otherScan = $neonatalChild
            ->usg_findings
            ->where('type', 3)
            ->where('flags', $this->usg_flags)
            ->toArray();
        $dopplerScan = $neonatalChild
            ->usg_findings
            ->where('type', 4)
            ->where('flags', $this->usg_flags)
            ->toArray();

        $usg_scaning = array();
        if (isset($datingScan) && count($datingScan) > 0)
        {

            if ((isset($datingScan['date']) && !empty($datingScan['date'])) || (isset($datingScan['Gestation']) && !empty($datingScan['Gestation'])))
            {

                $usg_scaning[] = array(
                    'date' => $datingScan['date'],
                    'gestation' => $datingScan['Gestation'],
                    'findings' => $datingScan['Finding']
                );

            }

        }

        if (isset($analogScan) && count($analogScan) > 0)
        {

            if ((isset($analogScan['date']) && !empty($analogScan['date'])) && (isset($analogScan['Gestation']) && !empty($analogScan['Gestation'])))
            {

                $usg_scaning[] = array(
                    'date' => $analogScan['date'],
                    'gestation' => $analogScan['Gestation'],
                    'findings' => $analogScan['Finding']
                );

            }

        }

        if (isset($otherScan) && count($otherScan) > 0)
        {

            foreach ($otherScan as $otherScankey => $otherScanvalue)
            {

                $usg_scaning[] = array(
                    'date' => $otherScanvalue['date'],
                    'gestation' => $otherScanvalue['Gestation'],
                    'findings' => $otherScanvalue['Finding']
                );

            }

        }

        if (isset($dopplerScan) && count($dopplerScan) > 0)
        {

            foreach ($dopplerScan as $dopplerScankey => $dopplerScanvalue)
            {

                $usg_scaning[] = array(
                    'date' => $dopplerScanvalue['date'],
                    'gestation' => $dopplerScanvalue['Gestation'],
                    'findings' => $dopplerScanvalue['Finding']
                );

            }

        }

        $maternalantibiotics = (!empty($results->MaternalAntibiotics)) ? json_decode($results->MaternalAntibiotics) : array();

        $closewinlink = url('/neonatal');

        $editor_gen_option = $results->edited_content == NULL ? 1 : 0;
        
        foreach ($results as & $value)
        {
            $value = ($value == '' && !is_array($value)) ? 'N/A' : $value;
        }

        $results = (object)\SiteHelpers::formate_tags($this->auto_tag_fields, (array)$results);
        $results->Gestation = \SiteHelpers::decode_gestation($results->Gestation);
        $results->Indication = \SiteHelpers::get_master_formated_value($results->Indication, 'Indication', 'indication_name');

        // $results->neonatal_consultant = ($results->neonatal_consultant == 'N/A') ? null : $results->neonatal_consultant;
        $results->temp_neonatal_consultant = \SiteHelpers::formating_consultant_signature($results->neonatal_consultant);
        $results->neonatal_consultant = \ValuelistHelpers::signatureFormat($results->neonatal_consultant);
        
        $editor_gen = false;
        if (\Session::has('neonatal-editor'))
        {
            \Session::forget('neonatal-editor');
            $editor_gen = true;
            return view('registration.neonatal.print', compact('results', 'usg_scaning', 'complication', 'pbm_data', 'delivery_details', 'usg_findings', 'complication_master', 'probs', 'navigate', 'findings', 'gestation', 'mas_indication', 'closewinlink', 'editor_gen', 'editor_gen_option'))
                ->renderSections();

        }
        return view('registration.neonatal.print', compact('results', 'usg_scaning', 'complication', 'pbm_data', 'delivery_details', 'usg_findings', 'complication_master', 'probs', 'navigate', 'findings', 'gestation', 'mas_indication', 'closewinlink', 'editor_gen_option', 'flow_wise_register'));
    }
    /**
     * Show the form for editing the record.
     *
     * @param  int  $id
     */
    public function edit($id, $search_data = '', Request $request)
    {

        $navigate['main_nav'] = 'neo_proforma';

        $navigate['sub_nav'] = (\Session::has('NeonatalDichargeList')) ? 'neo_discharge_proforma' : 'neo_admission_proforma';

        $id = \SiteHelpers::decrypt_id($id);
        $result = Neonatal::get_record($id);
        $admission_details = Admission::getBaby($id);
        $flow_wise_register = $request->get('flow');
        if (isset($admission_details->AdmissionId))
        {

            $result[0]->AdmissionId = $admission_details->AdmissionId;
        }

        $neonatalChild = Neonatal::find($id);

        $results = $result[0];
        if (date('Y', strtotime($results->DOB)) > 1980) $results->DOB = date('d-m-Y', strtotime($results->DOB));
        else $results->DOB = '';

        if (date('Y', strtotime($results->TestDate)) > 1980) $results->TestDate = date('d-m-Y', strtotime($results->TestDate));
        else $results->TestDate = '';

        if (!is_null($results->PartnerDOB))
        {
            $results->PartnerDOB = date('d-m-Y', strtotime($results->PartnerDOB));
        }
        else
        {
            $results->PartnerDOB = '';
        }

        if (!is_null($results->MotherDOB))
        {
            $results->MotherDOB = date('d-m-Y', strtotime($results->MotherDOB));
        }
        else
        {
            $results->MotherDOB = '';
        }

        if (date('Y', strtotime($results->DateOfDischarge)) > 1980) $results->DateOfDischarge = date('d-m-Y', strtotime($results->DateOfDischarge));
        else $results->DateOfDischarge = '';

        if (date('Y', strtotime($results->LMP)) > 1980) $results->LMP = date('d-m-Y', strtotime($results->LMP));
        else $results->LMP = '';

        if (date('Y', strtotime($results->EDDbyUSG)) > 1980) $results->EDDbyUSG = date('d-m-Y', strtotime($results->EDDbyUSG));
        else $results->EDDbyUSG = '';

        if (date('Y', strtotime($results->EDDbyDates)) > 1980) $results->EDDbyDates = date('d-m-Y', strtotime($results->EDDbyDates));
        else $results->EDDbyDates = '';

        if (date('Y', strtotime($results->OpAppointment)) > 1980) $results->OpAppointment = date('d-m-Y', strtotime($results->OpAppointment));
        else $results->OpAppointment = '';

        $results->DischargeWeight = ($results->DischargeWeight == 0) ? '' : $results->DischargeWeight;
        $Probs = MediprobsMaster::get_lists();
        $probs[0] = 'N/A';
        foreach ($Probs as $vac)
        {
            $probs[$vac
                ->Id] = $vac->Name;
        }

        $complication = Complication::where('BabyId', '=', $results->BabyId)->where('flags', $this->usg_flags)->get();
        $pbm_data = Problems::where('BabyId', '=', $results->BabyId)->get();
        $delivery_details = Delivery::where('MotherId', '=', $results->MotherId)->get();
        $usg_findings = Usg::where('MotherId', '=', $results->MotherId)
            ->where('BabyId', '=', $results->BabyId)
            ->where('flags', '=', $this->usg_flags)
            ->get();
        $delivery_indications = Indication::getFieldvalue();

        $vaccine = (!empty($results->Vaccine)) ? unserialize($results->Vaccine) : array(
            "0" => ""
        );
        $vaccine_date = (!empty($results->VaccineDate)) ? unserialize($results->VaccineDate) : array( "0" => "" );

        //  $findings            = (count($usg_findings) > 0) ?  json_decode($usg_findings['Finding']): array("0"=>"");
        // $gestations          = (count($usg_findings) > 0) ? json_decode($usg_findings['Gestation']): array("0"=>"");
        $maternalantibiotics = (!empty($results->MaternalAntibiotics) && is_array(json_decode($results->MaternalAntibiotics))) ? json_decode($results->MaternalAntibiotics) : unserialize($results->MaternalAntibiotics);

        $known_field = (!empty($results->known_field)) ? $results->known_field : 2;

        $discharge_medication_master = array(
                                            '' => 'N/A'
                                        );
        $discharge_medication_temp = DrugIvFluidMaster::getOralDrug();
        foreach ($discharge_medication_temp as $value)
        {
            $discharge_medication_master[$value->Id] = $value->Name;
        }

        $drags = DrugIvFluidMaster::where('is_deleted', 0)->where('type', 'ORAL')->get();
        $drugnew_data[0] = 'N/A';
        $drugnew_strgnth[0] = 'N/A';
        foreach ($drags as $drug)
        {
            $drugnew_data[$drug->Id] = $drug->Name;
            $drugnew_strgnth[$drug->Id] = $drug->Value;
        }

        $discharge_medicine_temp = Medications::get_medicines_lists($results->BabyId, 1);
        $discharge_medicines = array();
        foreach ($discharge_medicine_temp as $medicines)
        {
            $drugs = \DB::table('mas_drugivfluid')->where('id', $medicines->Medication)
                ->pluck('id')
                ->toArray();
            $medicines->values = \DB::table('mas_drugivfluid')
                ->whereIn('id', $drugs)->pluck('value', 'id')
                ->toArray();
            $discharge_medicines[] = $medicines;
        }

        $SubmitButtonText = "Update & Close";
        $SavedhereText = "Update";
        $saveNext = "Next";
        $tob = \SiteHelpers::prepare_time();

        $datingScan = $neonatalChild
            ->usg_findings
            ->where('type', 1)
            ->where('flags', $this->usg_flags)
            ->first();
        $analogScan = $neonatalChild
            ->usg_findings
            ->where('type', 2)
            ->where('flags', $this->usg_flags)
            ->first();
        $otherScan = $neonatalChild
            ->usg_findings
            ->where('type', 3)
            ->where('flags', $this->usg_flags)
            ->toArray();
        $dopplerScan = $neonatalChild
            ->usg_findings
            ->where('type', 4)
            ->where('flags', $this->usg_flags)
            ->toArray();

        $datingScan = (count($datingScan) > 0) ? $datingScan->toArray() : array();
        $analogScan = (count($analogScan) > 0) ? $analogScan->toArray() : array();

        $displaystyle = ($results->Seizures == 'No') ? 'style = "display:none"' : '';

        $displaystyleConception = ($results->Conception == 'Spontaneous') ? 'style = "display:none"' : '';
        // $displaystyleConception = ($results->Conception == 'Spontaneous') ? 'style = "display:none"' : '';
        $temp = json_decode($results->Gestation);
        $temp = is_array($temp) ? $temp : (array)$temp;
        $results->g_weeks = isset($temp['g_weeks']) ? $temp['g_weeks'] : null;
        $results->g_days = isset($temp['g_days']) ? $temp['g_days'] : null;

        $results->Indication = json_decode($results->Indication);

        $results->resusciatation_drugs = is_null($results->resusciatation_drugs) ? array() : json_decode($results->resusciatation_drugs);

        $results->Scalp = explode(',', $results->Scalp);

        $results->DischargeWeight = isset($results->DischargeWeight) && !empty($results->DischargeWeight) ? $results->DischargeWeight : 0;

        $results->sepsis_in_mother_type = (isset($results->sepsis_in_mother_type) && !is_null($results->sepsis_in_mother_type)) ? json_decode($results->sepsis_in_mother_type) : array();

        $ward_list = Ward::admission_ward_list()->pluck('name', 'id')->toArray();
        // $bed_logs = BedLog::where('baby_id', $results->BabyId)->orderBy('id', 'desc')->first();
        // if (isset($bed_logs->ward_name)) {
        //     if ($bed_logs->ward_name == 'NICU') {
        //         $room_list = \DB::table('room')
        //                     ->select('id', 'number')
        //                     ->where('ward_id', '1')
        //                     ->orderBy('number', 'asc')
        //                     ->pluck('number', 'id')
        //                     ->toArray();
        //     }
        //     else
        //     {
        //         /*POSTNATAL WARD ROOM LIST*/
        //         $room_list = \DB::table('room')
        //                     ->select('id', 'number')
        //                     ->where('ward_id', '3')
        //                     ->orderBy('number', 'asc')
        //                     ->pluck('number', 'id')
        //                     ->toArray();
        //     }
        // }
        // else
        // {
        //     $ward_list = Ward::admission_ward_list()->pluck('name', 'id')->toArray();
        //     $room_list = \DB::table('room')->select('id', 'number')->orderBy('number', 'asc')->pluck('number', 'id')->toArray();
        // }
        // if (isset($bed_logs->room_id)) {
        //     $bed_list = \DB::table('bed')->select('id', 'number')->where('room_id', $bed_logs->room_id)->orderBy('number', 'asc')->pluck('number', 'id')->toArray();
        // }
        // else
        // {
        //     $bed_list = array();
        // }
        // return view('registration.neonatal.neonatal_edit', compact('results', 'saveNext', 'drugnew_data', 'dopplerScan', 'otherScan', 'datingScan', 'analogScan', 'SubmitButtonText', 'complication_master', 'complication', 'pbm_data', 'delivery_details', 'usg_findings', 'probs', 'navigate', 'search_data', 'tob', 'vaccine', 'vaccine_date', 'maternalantibiotics', 'SavedhereText', 'known_field', 'displaystyle', 'displaystyleConception', 'delivery_indications', 'discharge_medication_master', 'discharge_medicines', 'bed_logs', 'ward_list', 'room_list', 'bed_list', 'flow_wise_register'));
        $get_nicu_id = \DB::table('nicu_admission')->select('NicuId')->where('BabyId', $results->BabyId)->where('status', 'Inpatient')->orderBy('AdmissionDate', 'desc')->first();
        $current_nicu_id = 0;
        if (isset($get_nicu_id->NicuId) && !empty($get_nicu_id->NicuId)) {
            $current_nicu_id = $get_nicu_id->NicuId;
        }
        return view('registration.neonatal.neonatal_edit', compact('results', 'saveNext', 'drugnew_data', 'dopplerScan', 'otherScan', 'datingScan', 'analogScan', 'SubmitButtonText', 'complication_master', 'complication', 'pbm_data', 'delivery_details', 'usg_findings', 'probs', 'navigate', 'search_data', 'tob', 'vaccine', 'vaccine_date', 'maternalantibiotics', 'SavedhereText', 'known_field', 'displaystyle', 'displaystyleConception', 'delivery_indications', 'discharge_medication_master', 'discharge_medicines', 'flow_wise_register', 'current_nicu_id'));
    }

    /**
     * UPDATE THE EXISTING RECORD.
     *
     * @param  int  $id
     */
    public function update($id, NeonatalRequest $request)
    {
        $input = $request->all();
        // if (isset($input['transfer_status']) && $input['transfer_status'] == 'NICU') {
        //     $validated = $request->validate([
        //         'room_no' => 'required',
        //         'bed_no' => 'required',
        //     ]);
        // }
        // $tags      = AutoTagMasters::auto_key_support($this->auto_tag_fields,$input);
        $mp_babies = Neonatal::getNeonatalmp($input['MotherId'], $id);

        $print_flag = isset($input['print_flag']) ? $input['print_flag'] : 0;

        unset($input['print_flag']);
        if (isset($input['set_active'])) {
            \Session::put('neonatal_form', $input['set_active']);
        }
        $input['sepsis_in_mother_type'] = isset($input['sepsis_in_mother_type']) ? json_encode($input['sepsis_in_mother_type']) : null;

        $input['MotherDOB'] = !empty($input['MotherDOB']) ? date('Y-m-d', strtotime($input['MotherDOB'])) : null;
        $input['PartnerDOB'] = !empty($input['PartnerDOB']) ? date('Y-m-d', strtotime($input['PartnerDOB'])) : null;

        $input['delivery_room_cpap'] = (isset($input['delivery_room_cpap']) && $input['delivery_room_cpap'] == 'on') ? 'Yes' : 'No';
        $input['bag_mask_ventilator'] = (isset($input['bag_mask_ventilator']) && $input['bag_mask_ventilator'] == 'on') ? 'Yes' : 'No';
        $input['bag_mask_ventilator_duration'] = (isset($input['bag_mask_ventilator_duration']) && $input['bag_mask_ventilator_duration'] == 'on') ? 'known' : 'Unknown';
        $input['indication_of_admission'] = isset($input['indication_of_admission']) ? json_encode($input['indication_of_admission']) : null;

        $input['DOB'] = date('Y-m-d', strtotime($input['DOB']));
        $input['TestDate'] = date('Y-m-d', strtotime($input['TestDate']));
        $input['UserModified'] = $this->auth->user()->id;
        $input['DateModified'] = Carbon::now();

        $input['g_weeks'] = empty($input['g_weeks']) ? null : trim($input['g_weeks']);
        $input['g_days'] = empty($input['g_days']) ? 0 : trim($input['g_days']);

        $input['Vaccine'] = (isset($input['Vaccine']) && count($input['Vaccine']) != 0) ? serialize($input['Vaccine']) : '';
        $input['VaccineDate'] = (isset($input['VaccineDate']) && count($input['VaccineDate']) != 0) ? serialize($input['VaccineDate']) : '';

        $input['BirthStatus'] = (isset($input['BirthStatus']) && $input['BirthStatus'] == 'on') ? 'Inborn' : 'Outborn';
        $input['Booked'] = (isset($input['Booked']) && $input['Booked'] == 'on') ? 'Yes' : 'No';
        $input['Supervised'] = (isset($input['Supervised']) && $input['Supervised'] == 'on') ? 'Yes' : 'No';
        $input['MultiplePregnancy'] = (isset($input['MultiplePregnancy']) && $input['MultiplePregnancy'] == 'on') ? 'Yes' : 'No';
        $input['Consanguinity'] = (isset($input['Consanguinity']) && $input['Consanguinity'] == 'on') ? 'Yes' : 'No';
        $input['PregnancyComplications'] = (isset($input['PregnancyComplications']) && $input['PregnancyComplications'] == 'on') ? 'Yes' : 'No';
        $input['AntenatalSteroids'] = (isset($input['AntenatalSteroids']) && $input['AntenatalSteroids'] == 'on') ? 'Yes' : 'No';
        $input['Labour'] = (isset($input['Labour']) && $input['Labour'] == 'on') ? 'Yes' : 'No';
        $input['MaternalPyrexia'] = (isset($input['MaternalPyrexia']) && $input['MaternalPyrexia'] == 'on') ? 'Yes' : 'No';
        $input['maternal_pyrexia_celsius'] = (isset($input['maternal_pyrexia_celsius'])) ? $input['maternal_pyrexia_celsius'] : 0;
        $input['maternal_pyrexia_fahrenheit'] = (isset($input['maternal_pyrexia_fahrenheit'])) ? $input['maternal_pyrexia_fahrenheit'] : 0;
        $input['PROM'] = (isset($input['PROM']) && $input['PROM'] == 'on') ? 'Yes' : 'No';
        $input['FacialOxygen'] = (isset($input['FacialOxygen']) && $input['FacialOxygen'] == 'on') ? 'Yes' : 'No';
        $input['Intubation'] = (isset($input['Intubation']) && $input['Intubation'] == 'on') ? 'Yes' : 'No';
        $input['PPV'] = (isset($input['PPV']) && $input['PPV'] == 'on') ? 'Yes' : 'No';
        $input['CPR'] = (isset($input['CPR']) && $input['CPR'] == 'on') ? 'Yes' : 'No';
        $input['Drugs'] = (isset($input['Drugs']) && $input['Drugs'] == 'on') ? 'Yes' : 'No';
        $input['Resuscitation'] = (isset($input['Resuscitation']) && $input['Resuscitation'] == 'on') ? 'Yes' : 'No';

        $input['timeofgasp_status'] = (isset($input['timeofgasp_status']) && $input['timeofgasp_status'] == 'on') ? true : false;
        $input['regularrespiration_status'] = (isset($input['regularrespiration_status']) && $input['regularrespiration_status'] == 'on') ? true : false;
        $input['insertion_status'] = (isset($input['insertion_status']) && $input['insertion_status'] == 'on') ? true : false;

        $input['ppv_status'] = (isset($input['ppv_status']) && $input['ppv_status'] == 'on') ? true : false;
        $input['cpr_status'] = (isset($input['cpr_status']) && $input['cpr_status'] == 'on') ? true : false;

        $input['Gestation'] = json_encode(array(
            'g_weeks' => $input['g_weeks'],
            'g_days' => $input['g_days']
        ));

        $input['known_field'] = (isset($input['known_field']) && $input['known_field'] == 'on') ? 1 : 2;
        $input['Indication'] = isset($input['Indication']) ? json_encode($input['Indication']) : json_encode(array());
        $input['newbornStatus'] = (isset($input['newbornStatus']) && $input['newbornStatus'] == 'on') ? 2 : 1;
        $input['adjustedtrisomies'] = (isset($input['adjustedtrisomies']) && $input['adjustedtrisomies'] == 'on') ? 2 : 1;
        $input['Scalp'] = isset($input['Scalp']) ? implode(',', $input['Scalp']) : '';
        $input['resusciatation_drugs'] = isset($input['resusciatation_drugs']) ? json_encode($input['resusciatation_drugs']) : json_encode(array());
        $input['maximum_fio2_required'] = isset($input['maximum_fio2_required']) && !empty($input['maximum_fio2_required']) ? $input['maximum_fio2_required'] : null;

        $input['duration_of_cpr'] = isset($input['duration_of_cpr']) && !empty($input['duration_of_cpr']) ? $input['duration_of_cpr'] : null;

        $input['discharge_length'] = isset($input['discharge_length']) && !empty($input['discharge_length']) ? $input['discharge_length'] : null;
        $input['discharge_ofc'] = isset($input['discharge_ofc']) && !empty($input['discharge_ofc']) ? $input['discharge_ofc'] : null;

        $input['MaternalAntibiotics'] = (isset($input['MaternalAntibiotics']) && count($input['MaternalAntibiotics']) != 0 && !empty($input['MaternalAntibiotics'][0])) ? json_encode($input['MaternalAntibiotics']) : '';
        
        // if ($input['Status'] != "Postnatal Stay" && $input['Status'] != "NICU Transfer" && !empty($input['Status']))
        // {
        //     $admission_data = array(
        //         'Status' => $input['Status'],
        //         'DateModified' => $input['DateModified'],
        //     );
        //     if ($input['AdmissionId'] != 0)
        //     {
        //         $results_ad = Admission::findOrfail($input['AdmissionId']);

        //         if (count($results_ad) > 0)
        //         {
        //             $results_ad->update($admission_data);
        //         }
        //         // else
        //         // {
        //         //     $admission_data['BabyId'] = $input['BabyId'];
        //         //     $admission_data['BMrNo'] = $input['BMrNo'];
        //         //     $admission_data['MotherId'] = $input['MotherId'];
        //         //     $admission_data['TestDate'] = $input['TestDate'];
        //         //     $admission_data['InOrOut'] = 'In';
        //         //     $admission_data['AdmissionType'] = 'In';
        //         // }
                
        //     }
        // }

        //Updating parents details
        $parentDetails = Mother::findOrfail($input['MotherId']);
        $parentDetails->update($input);

        //Updating baby details
        $babyDetails = Baby::findOrfail($input['BabyId']);
        $babyDetails->update($input);

        $BMrNo = $babyDetails->BMrNo;

        // if (isset($input['transfer_status']) && $input['transfer_status'] == "NICU") {
        //     $admission_data1 = array(
        //         'Status' => $input['Status'],
        //         'DateModified' => $input['DateModified'],
        //     );
        

        //     if ($input['AdmissionId'] != 0) {
        //         $results_ad = Admission::find($input['AdmissionId']);
        //         if (count($results_ad) > 0) {
        //             $results_ad->update($admission_data1);
        //         }
        //     } else {
        //         $admission_data = array(
        //             'BabyId' => $input['BabyId'],
        //             'BMrNo' => $BMrNo,
        //             'MotherId' => $input['MotherId'],
        //             'AdmissionDate' => $input['TestDate'],
        //             'AdmissionTime' => $input['TEST_TIME'] . ':' . $input['TEST_MINS'] . ':' . $input['TEST_AM'],
        //             'InOrOut' => 'In',
        //             'AdmissionType' => 'NICU',
        //             'Status' => "Inpatient",
        //             'UserAdded' => $this->auth->user()->id,
        //             'DateAdded' => date('Y-m-d H:i:s'),
        //             'DateModified' => date('Y-m-d H:i:s'),
        //         );
        //         $admission = Admission::create($admission_data);
        //         $admission_id = $admission->AdmissionId;
        //         $nicu_data = array(
        //             'BabyId' => $input['BabyId'],
        //             'BMrNo' => $BMrNo,
        //             'MotherId' => $input['MotherId'],
        //             'AdmissionId' => $admission_id,
        //             'AdmissionDate' => $input['TestDate'],
        //             'AdmissionTime' => $input['TEST_TIME'] . ':' . $input['TEST_MINS'] . ':' . $input['TEST_AM'],
        //             'Status' => "Inpatient",
        //             'AdmittedFrom' => "Postnatal",
        //             'UserAdded' => $this->auth->user()->id,
        //             'DateAdded' => date('Y-m-d H:i:s'),
        //             'DateModified' => $input['DateModified'],
        //             'DateOfDischarge' => date('Y-m-d', strtotime($input['DateOfDischarge'])),
        //             'OpAppointment' => date('Y-m-d', strtotime($input['OpAppointment']))
        //         );
        //         Nicu::create($nicu_data);
        //         $input['AdmissionId'] = $admission_id;
        //     }
        // }
        $results1 = Neonatal::findOrfail($id);
        // $input['DateOfDischarge'] = date('Y-m-d', strtotime($input['DateOfDischarge']));
        // $input['OpAppointment'] = date('Y-m-d', strtotime($input['OpAppointment']));
        $input['LMP'] = (!empty($input['LMP'])) ? date('Y-m-d', strtotime($input['LMP'])) : null;
        $input['EDDbyUSG'] = (!empty($input['EDDbyUSG'])) ? date('Y-m-d', strtotime($input['EDDbyUSG'])) : null;
        $input['EDDbyDates'] = (!empty($input['EDDbyDates'])) ? date('Y-m-d', strtotime($input['EDDbyDates'])) : null;
        if ($results1['form_status'] != 2) {
            $input['form_status'] = !isset($input['formstatus']) ? 1 : $input['formstatus'];
        }
        $input['mp_common_status'] = 1;

        $results1->update($input);

        //this for update resuscitation
        // $nicu_admission_id = Admission::get_baby_lists($input['BabyId']);
        // if (isset($nicu_admission_id->AdmissionId) && !empty($nicu_admission_id->AdmissionId))
        // {

        //     $nicu_admission_details = Nicu::where(['BabyId' => $input['BabyId'], 'AdmissionId' => $nicu_admission_id->AdmissionId, 'IsDeleted' => 0])->first();

        //     if (isset($results1->OtherInformation) && isset($nicu_admission_details->DescriptionOfResuscitation))
        //     {

        //         $auto_update['DescriptionOfResuscitation'] = $results1->OtherInformation . str_replace($results1->OtherInformation, '', $nicu_admission_details->DescriptionOfResuscitation);

        //         Nicu::where(['BabyId' => $input['BabyId'], 'AdmissionId' => $nicu_admission_id->AdmissionId, 'IsDeleted' => 0])
        //             ->update($auto_update);
        //     }
        // }

        Complication::where('BabyId', '=', $input['BabyId'])->where('flags', $this->usg_flags)->delete();
        if (isset($input['Complication']))
        {
            $com_length = sizeof($input['Complication']);
            foreach ($input['Complication'] as $key => $value) {
                if (!empty($input['Complication'][$key]))
                {
                    $input['duration_in_weeks'][$key] = empty($input['duration_in_weeks'][$key]) ? null : $input['duration_in_weeks'][$key];
                    $input['duration_unit'][$key] = empty($input['duration_unit'][$key]) ? null : $input['duration_unit'][$key];

                    $comps = array(
                        'Complication' => $input['Complication'][$key],
                        'Treatment' => !empty($input['Treatments'][$key]) ? $input['Treatments'][$key] : null,
                        'duration_in_weeks' => !empty($input['duration_in_weeks'][$key]) ? $input['duration_in_weeks'][$key] : null,
                        'duration_unit' => $input['duration_unit'][$key],
                        'AdmissionId' => 1,
                        'BabyId' => $input['BabyId'],
                        'flags' => $this->usg_flags,
                    );
                    Complication::create($comps);
                }
            }
        }

        // $discharge_medications = Medications::where('BabyId', '=', $input['BabyId'])->where('AdmissionId', '=', $results1->AdmissionId)
        //     ->where('flag', '=', 1)
        //     ->delete();
        // if (isset($input['brand_name']))
        // {
        //     for ($i = 0;$i < sizeof($input['brand_name']);$i++)
        //     {
        //         if (!empty($input['brand_name'][$i]))
        //         {
        //             $discharge_medications = array(
        //                 'Medication' => empty($input['formulation'][$i]) ? $input['brand_name'][$i] : $input['formulation'][$i],
        //                 'Dose' => $input['dose'][$i],
        //                 'Frequency' => $input['frequency'][$i],
        //                 'Duration' => $input['duration'][$i],
        //                 'genericname' => $input['generic_name'][$i],
        //                 'formulation' => $input['formulation'][$i],
        //                 'AdmissionId' => $results1->AdmissionId,
        //                 'BabyId' => $input['BabyId'],
        //                 'flag' => 1,
        //                 'source_id' => 0
        //             );
        //             Medications::create($discharge_medications);
        //         }
        //     }
        // }

        Problems::where('BabyId', '=', $input['BabyId'])->delete();
        if (isset($input['Problems']))
        {
            $pbm_length = sizeof($input['Problems']);

            foreach ($input['Problems'] as $key => $value) {
                if (!empty($input['Problems'][$key]) && $input['Problems'][$key] != 0)
                {
                    $pbms = array(
                        'Problem' => $input['Problems'][$key],
                        'Medication' => $input['Medications'][$key],
                        'MotherId' => $input['MotherId'],
                        'BabyId' => $input['BabyId']
                    );
                    Problems::create($pbms);
                }
            }
        }

        Delivery::where('MotherId', '=', $input['MotherId'])->delete();
        if (isset($input['Year']))
        {
            $delivery_length = sizeof($input['Year']);

            foreach ($input['Year'] as $key => $value) {
                $deli_data = array(
                    'Year' => $input['Year'][$key],
                    'Place' => $input['Place'][$key],
                    'Delivery' => $input['Delivery'][$key],
                    'Complications' => $input['Complications'][$key],
                    'Gender' => $input['Gender'][$key],
                    'GA' => $input['GA'][$key],
                    'BW' => $input['BW'][$key],
                    'Health' => $input['Health'][$key],
                    'details' => $input['details'][$key],
                );

                if (array_filter($deli_data)) {
                    $deli_data['MotherId'] = $input['MotherId'];
                    Delivery::create($deli_data);
                }
            }
        }


        //create usg and findings for dating scan
        $usg_parameters['BabyId'] = $input['BabyId'];
        $usg_parameters['MotherId'] = $input['MotherId'];
        $usg_parameters['flags'] = $this->usg_flags;
        $usg_parameters['type'] = 1;
        Usg::where($usg_parameters)->delete();
        if ((isset($input['datingdate']) && !empty($input['datingdate'])) || (isset($input['datinggestations']) && !empty($input['datinggestations']))) {
            $usg_parameters['date'] = !empty($input['datingdate']) ? date('Y-m-d', strtotime($input['datingdate'])) : null;
            $usg_parameters['Gestation'] = $input['datinggestations'];
            $usg_parameters['Finding'] = $input['datingfindings'];
            Usg::insert($usg_parameters);
        }
        unset($usg_parameters);

        //creating usg adn findings for anolog scan
        $usg_parameters['BabyId'] = $input['BabyId'];
        $usg_parameters['MotherId'] = $input['MotherId'];
        $usg_parameters['flags'] = $this->usg_flags;
        $usg_parameters['type'] = 2;
        Usg::where($usg_parameters)->delete();
        if ((isset($input['analogdate']) && !empty($input['analogdate'])) || (isset($input['analoggestations']) && !empty($input['analoggestations']))) {
            $usg_parameters['date'] = !empty($input['analogdate']) ? date('Y-m-d', strtotime($input['analogdate'])) : null;
            $usg_parameters['Gestation'] = $input['analoggestations'];
            $usg_parameters['Finding'] = $input['analogfindings'];
            Usg::insert($usg_parameters);
        }
        unset($usg_parameters);

        //creating usg adn findings for other scan
        $usg_parameters['BabyId'] = $input['BabyId'];
        $usg_parameters['MotherId'] = $input['MotherId'];
        $usg_parameters['flags'] = $this->usg_flags;
        $usg_parameters['type'] = 3;
        Usg::where($usg_parameters)->delete();

        if (isset($input['otherdate']) || isset($input['othergestations']))
        {

            foreach ($input['othergestations'] as $key => $value) {

                if ((isset($input['otherdate'][$key]) && !empty($input['otherdate'][$key])) || (isset($input['othergestations'][$key]) && !empty($input['othergestations'][$key])))
                {
                    $usg = array(
                        'date' => !empty($input['otherdate'][$key]) ? date('Y-m-d', strtotime($input['otherdate'][$key])) : null,
                        'Gestation' => $input['othergestations'][$key],
                        'Finding' => $input['otherfindings'][$key],
                        'MotherId' => $input['MotherId'],
                        'BabyId' => $input['BabyId'],
                        'flags' => $this->usg_flags,
                        'type' => 3,
                    );
                    Usg::insert($usg);
                }
            }
        }

        //creating usg adn findings for doppler scan
        $usg_parameters['BabyId'] = $input['BabyId'];
        $usg_parameters['MotherId'] = $input['MotherId'];
        $usg_parameters['flags'] = $this->usg_flags;
        $usg_parameters['type'] = 4;
        Usg::where($usg_parameters)->delete();

        if (isset($input['dopplerdate']) || isset($input['dopplergestations']))
        {
            foreach ($input['dopplergestations'] as $key => $value) {

                if ((isset($input['dopplerdate'][$key]) && !empty($input['dopplerdate'][$key])) || (isset($input['dopplergestations'][$key]) && !empty($input['dopplergestations'][$key])))
                {
                    $usg = array(
                        'date' => !empty($input['dopplerdate'][$key]) ? date('Y-m-d', strtotime($input['dopplerdate'][$key])) : null,
                        'Gestation' => $input['dopplergestations'][$key],
                        'Finding' => $input['dopplerfindings'][$key],
                        'MotherId' => $input['MotherId'],
                        'BabyId' => $input['BabyId'],
                        'flags' => $this->usg_flags,
                        'type' => 4,
                    );

                    Usg::insert($usg);
                }
            }
        }

        /* New Born Update or Create */
        $input['BMrNo'] = $babyDetails['BMrNo'];
        $input['MotherId'] = $babyDetails['MotherId'];

        $newborn = Newborn::find($input['BabyId']);
        if ($newborn)
        {
            $input['DateModified'] = Carbon::now();
            $input['UserModified'] = $this->auth->user()->id;
            $newborn->update($input);
        }
        else
        {
            $input['DateAdded'] = Carbon::now();
            $input['UserAdded'] = $this->auth->user()->id;
            $input['DateModified'] = Carbon::now();
            $input['UserModified'] = $this->auth->user()->id;
            Newborn::create($input);
        }

        // if (isset($input['transfer_status']) && isset($input['room_id']) && isset($input['bed_id']) && $input['transfer_status'] == 'NICU')
        // {
        //     $check_bed_log = BedLog::where(['baby_id' => $input['BabyId'], 'status' => 'Occupied'])->first();
        //     // $ward['ward_id'] = 1;
        //     $ward['ward_id'] = \SiteHelpers::getWardIdByName($input['transfer_status']);
        //     $ward['ward_name'] = \SiteHelpers::gettable_values('ward', 'name', 'id', $ward['ward_id']);
        //     $ward['room_id'] = $input['room_id'];
        //     $ward['room_no'] = \SiteHelpers::gettable_values('room', 'number', 'id', $input['room_id']);
        //     $ward['bed_id'] = $input['bed_id'];
        //     if ($input['bed_id'] != '' && !is_null($input['bed_id'])) {
        //         $ward['bed_no'] = \SiteHelpers::gettable_values('bed', 'number', 'id', $input['bed_id']);
        //     }
        //     else
        //     {

        //     }
        //     $ward['baby_id'] = $input['BabyId'];
        //     $ward['admission_id'] = $input['AdmissionId'];
        //     $ward['DateAdded'] = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
        //     $ward['UserAdded'] = $this->auth->user()->id;
        //     $ward['DateModified'] = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
        //     $ward['UserModified'] = $this->auth->user()->id;
        //     $ward['IsDeleted'] = 0;
        //     $ward['status'] = 'Occupied';
        //     if (count($check_bed_log) == 0)
        //     {
        //         $patient_bed_log = BedLog::create($ward);
        //         Bed::where('id', $input['bed_id'])->update(['status' => 'Occupied']);
        //     }
        //     else
        //     {
        //         BedLog::where(['baby_id' => $input['BabyId'], 'status' => 'Occupied'])->Update($ward);
                
        //         Bed::where('id', $check_bed_log->bed_id)->update(['status' => NULL]);

        //         Bed::where('id', $input['bed_id'])->update(['status' => 'Occupied']);   
        //     }
        // }


        if (\Session::has('registration_start'))
        {
            $cookie = isset($_COOKIE['neonatenext']) ? $_COOKIE['neonatenext'] : null;
            $this->flow->flowlog('NEONATAL', $input['BabyId'], $input['MotherId'], null, false, $cookie);
        }
        \SiteHelpers::clearBedCookies();
         // Nicu dashboard data updating call
        \SiteHelpers::updateDashboardAtFormUpdation($input['BabyId'], 'Neonatal Proforma');

        if(isset($input['nicu_id']) && !empty($input['nicu_id']))
        {
            $create_nicu_url = action('Admission\NicuController@edit', \SiteHelpers::encrypt_id($input['nicu_id']));
        }
        else
        {
            $create_nicu_url = action('Admission\NicuController@create', \SiteHelpers::encrypt_id($input['BabyId']));
        }
        if (isset($input['flow']) && $input['flow'] == 'from-dashboard') {
            $create_nicu_url .= '?flow=from-dashboard';
            $check_nicu_admission = Nicu::getNicuAdmission($input['AdmissionId'], $input['BabyId']);
            if (isset($check_nicu_admission->NicuId) && !empty($check_nicu_admission->NicuId)) {
                $create_nicu_url = action('Admission\NicuController@edit', \SiteHelpers::encrypt_id($check_nicu_admission->NicuId)).'?flow=from-dashboard';
            }
        }
        if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'Neonatal proforma created successfully !', 'id' => $id, 'edit_url' => action('Registration\NeonatalController@edit', \SiteHelpers::encrypt_id($id)), 'create_nicu_url' => $create_nicu_url, 'list_url' => action('Registration\NeonatalController@index'), 'create_postnatal_url' => action('Admission\PostnatalController@show', \SiteHelpers::encrypt_id($input['BabyId'])), 'tag_print_url' => action('Reports\BabyReportController@babyTagprint', $input['BabyId'])], 200);
        }
        if ($print_flag == 0)
        {

            if (!\Session::has('NeonatalDichargeList')) return redirect(action('Registration\NeonatalController@index'))->with('Success', 'Record updated successfully ');
            else return redirect(action('Registration\NeonatalController@neonatalDichargelist'))
                ->with('Success', 'Record updated successfully ');
        }
        elseif ($print_flag == 1)
        {

            return redirect(action('Registration\NeonatalController@edit', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully');

        }
        elseif ($print_flag == 2)
        {

            return redirect(action('Reports\BabyReportController@babyTagprint', $input['BabyId']));

        }
        elseif ($print_flag == 4)
        {

            if (\Session::has('already_register_nurse'))
            {

                $admission_id = \SiteHelpers::encrypt_id($input['BabyId'] . '-' . $nicu_admission_id->AdmissionId);

                return redirect(action('Admission\NicuController@create', \SiteHelpers::encrypt_id($admission_id)))->with('Success', 'Record updated successfully ');

            }
            else
            {

                \Session::has('slug-nav') ? \Session::forget('slug-nav') : '';
                return redirect(action('Admission\NicuController@create', \SiteHelpers::encrypt_id($input['BabyId'])))->with('Success', 'Record updated successfully ');
            }

        }
        elseif ($print_flag == 5)
        {

            return redirect(action('Admission\PostnatalController@show', \SiteHelpers::encrypt_id($input['BabyId'])))->with('Success', 'Record saved successfully ');

        }

    }

    /**
     * UPDATE THE RECORD AS DELETED AND CREATE A APPROVAL REQUEST
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $results = Neonatal::findOrfail($id);
        $user_detail = array(
            'UserDeleted' => $this->auth->user()->id,
            'DateModified' => Carbon::now() ,
            'IsDeleted' => '1'
        );
        $results->update($user_detail);
        $result = Neonatal::get_record($id);
        $res = $result[0];

        $delete_data = array(
            'Name' => $res->BabyName,
            'AdmissionDate' => $results['TestDate'],
            'ModuleController' => 'Registration\NeonatalController',
            'ModuleId' => $id,
            'ModuleName' => 'Neonatal Proforma',
            'UserDeleted' => $this
                ->auth
                ->user()->id,
            'DateDeleted' => Carbon::now()
        );
        DeleteApproval::create($delete_data);
        return redirect(action('Registration\NeonatalController@index'))->with('info', 'Record deleted successfully !');
    }

    /* BABY SELECTION PROCESS
     *  IF NONE SELECTED NEW BABY RECORD WILL BE CREATED
     *  ELSE ONLY NEONATAL RECORD WILL BE CREATED FOR THE EXISTING BABY
    */

    public function chooseBaby()
    {
        $navigate['main_nav'] = 'neo_proforma';
        $navigate['sub_nav'] = 'neo_admission_proforma';
        $baby = Baby::baby_list_neonatal();
        $babies = \ValuelistHelpers::select2DataFormater($baby);

        $SubmitButtonText = "Start";

        return view('registration.neonatal.select_patient', compact('SubmitButtonText', 'babies', 'navigate'));
    }

    /* FOR VIEW POPUP */

    public function getData($id)
    {
        $id = \SiteHelpers::decrypt_id($id);
        $result = Neonatal::get_record($id);
        $results = (array)$result[0];
        $results['Gestation'] = \SiteHelpers::decode_gestation($results['Gestation']);
        $results['TestDate'] = date('d-m-Y', strtotime($results['TestDate']));
        $results['TEST_TIME'] = (strlen($results['TEST_TIME']) == 1) ? ('0' . $results['TEST_TIME']) : $results['TEST_TIME'];
        $results['TEST_MINS'] = (strlen($results['TEST_MINS']) == 1) ? ('0' . $results['TEST_MINS']) : $results['TEST_MINS'];
        $results['TestTime'] = $results['TEST_TIME'] . ':' . $results['TEST_MINS'] . ' ' . $results['TEST_AM'];
        $results['DOB'] = date('d-m-Y', strtotime($results['DOB']));
        $results['TOB_TIME'] = (strlen($results['TOB_TIME']) == 1) ? ('0' . $results['TOB_TIME']) : $results['TOB_TIME'];
        $results['TOB_MINS'] = (strlen($results['TOB_MINS']) == 1) ? ('0' . $results['TOB_MINS']) : $results['TOB_MINS'];

        $results['TOB'] = $results['TOB_TIME'] . ':' . $results['TOB_MINS'] . ' ' . $results['TOB_AM'];

        return json_encode($results);
    }

    /* FOR SEARCH FILTER */

    public function searchData(Request $request)
    {
        $data = $request->get('data1');
        $results = Neonatal::GetSearchDatas($data);
        return json_encode($results);
    }

    /**
     * update common fields for multiple preganacy
     *
     * @param  $input_values type array
     * @param  $baby_id type int
     * @return type boolean
     */
    public function getCommonfeilds($input_values, $baby_id)
    {
        $common = array();
        foreach ($this->common_mp_fields as $value)
        {
            if (isset($input_values[$value]))
            {
                $common[$value] = $input_values[$value];
            }
        }
        $common['mp_common_status'] = 1;
        $mp_baby = Neonatal::findOrfail($baby_id);
        $mp_baby->update($common);
        return true;
    }

    /**
     * update medical problem for multiple preganacy
     *
     * @param  $input_values type array
     * @param  $baby_id type int
     * @return type boolean
     */
    public function saveProblems($input_values, $baby_id)
    {

        Problems::where('BabyId', '=', $baby_id)->delete();
        if (isset($input_values['Problems']))
        { //
            $pbm_length = sizeof($input_values['Problems']);

            for ($i = 0;$i < $pbm_length;$i++)
            {
                if (!empty($input_values['Problems'][$i]) && $input_values['Problems'][$i] != 0)
                {
                    $pbms = array(
                        'Problem' => $input_values['Problems'][$i],
                        'Medication' => $input_values['Medications'][$i],
                        'MotherId' => $input_values['MotherId'],
                        'BabyId' => $baby_id
                    );
                    Problems::create($pbms);
                }
            }
        }

        return true;
    }

    /**
     * update complication for multiple preganacy
     *
     * @param  $input_values type array
     * @param  $baby_id type int
     * @return type boolean
     */
    public function saveComplications($input_values, $baby_id)
    {

        Complication::where('BabyId', '=', $input_values['BabyId'])->delete();
        if (isset($input_values['Complication']))
        {
            $com_length = sizeof($input_values['Complication']);
            for ($i = 0;$i < $com_length;$i++)
            {
                if ($input_values['Complication'][$i] != '' && $input_values['Complication'][$i] != 0)
                {
                    $comps = array(
                        'Complication' => $input_values['Complication'][$i],
                        'Treatment' => $input_values['Treatments'][$i],
                        'AdmissionId' => 1,
                        'BabyId' => $baby_id,
                        'flags' => $this->flags,
                    );
                    Complication::create($comps);
                }
            }
        }
        return true;
    }

    /**
     * OPEN DISCHARGE REPORT WITH FULL EDITOR
     *
     */

    public function getfullEditor(Request $request)
    {
        $input = $request->all();
        \Session::put('neonatal-editor', true);
        return \Response::json(['dataUrl' => $input['dataUrl'], 'neonatal_id' => $input['neonatal_id']], 200);

    }

    /**
     * OPEN DISCHARGE REPORT WITH FULL EDITOR
     *
     */
    public function saveFullEditor(Request $request)
    {
        // assign inputs to variable
        $input = $request->all();
        $baby_id = $input['baby_id'];

        //get the baby details
        $baby = Baby::get_data($baby_id);

        $neonatal = Neonatal::findOrfail($input['neonatal_id']);

        $neonatal->update(['edited' => true, 'edited_content' => $input['neonatal_report'], 'edited_time' => Carbon::now($this->time_zone) ]);

        // create slug for updated
        $slug = $input['baby_id'];
        $neonatal_id = $input['neonatal_id'];

        if ($request->ajax()) {
            return \Response::json(['type'=>'success','msg' => 'Record Updated Successfully']);
        } else {
            return redirect(action('Registration\NeonatalController@getAbbreviatedsummaryShow', \SiteHelpers::encrypt_id($slug) . '?id=' . $neonatal_id))->with('success', 'Record updated successfully');
        }
    }

    public function getAbbreviatedsummaryShow(Request $request, $id)
    {
        //decrypt the id
        $id_list = \SiteHelpers::decrypt_id($id);

        $dischargeSummarymodified = array();

        // check  baby and adnmission ids
        if (isset($id_list) && !empty($id_list) && isset($_GET['id']))
        {

            $dischage_summary['baby_id'] = $baby_id = $id_list;
            $dischage_summary['neonatal_id'] = $neonatal_id = $_GET['id'];

        }
        else
        {

            return redirect(url('/'))->with('error', 'Invalid record');

        }

        $neonatal = Neonatal::findOrfail($_GET['id']);
        
        \Session::put('neonatal-editor', true);

        $id = \SiteHelpers::encrypt_id($_GET['id']);


        if (count($neonatal) > 0 && !empty($neonatal['edited_content'])) {
            $discharge_details['content'] = $neonatal['edited_content'];
        } else {
            $discharge_details = $this->show($id);
        }

        $editor_gen = false;
        \Session::forget('neonatal-editor');
        return view('registration.neonatal.editor', compact('discharge_details', 'dischargeSummarymodified', 'dischage_summary'));
    }

}

