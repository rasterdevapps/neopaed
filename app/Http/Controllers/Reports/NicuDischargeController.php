<?php namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Fluid;
use Carbon\Carbon;
use App\Models\Reports\NicuDischarge;
use App\Models\Masters\RespiratoryIndication;
use App\Models\Icd;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Settings\Settings;
use App\Models\Reports\AbbreviatedSummaryLog;
use Illuminate\Contracts\Auth\Guard;
use App\Models\IpNumber;
use App\Models\Masters\Indication;
use App\Models\DischargeSummary;
use App\Models\Masters\Vaccine;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Flow\FlowController;
use App\Models\Baby;
use App\Models\SummariesPrint\NicuDaycareSummaryPrint;
use App\Models\Masters\ProcedureMaster;

class NicuDischargeController extends Controller
{
    public function __construct(Guard $auth, FlowController $flow)
    {
        $this->middleware('role:NICU_DISCHARGE,read', ['only' => ['discharge_main_list', 'discharge_sub_list', 'index']]);
        $this->auth = $auth;
        $this->flow = $flow;
        $this->timezone = env('TIME_ZONE');

    }

    /**
     * DISPLAY THE RECORDS ACCORDING TO THE FILTERS APPLIED
     *
     */

    public function discharge_main_list(Request $request, $summary_type = '')
    {
        $limit = 10;
        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'nicu_discharge';

        if (!empty($request->input('limit')))
        {
            $request->session()->put('limit', $request->input('limit'));
            $limit = $request->session()->get('limit');
        }
        elseif ($request->session()->has('limit'))
        {
            $limit = $request->session()->get('limit');
        }

        $order['sortby'] = 'baby.BabyId';
        // $order['sortby'] = 'baby.DOB';
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
        $status = !empty($request->input('status')) ? $request->input('status') : 'discharged';

        $page = !empty($request->input('page')) ? $request->input('page') : 1;
        $page = preg_replace( '/[^0-9]/', '', $page);

        $result = NicuDischarge::get_inpatient_baby_mainlists($page , $limit, $search, $order, 1, $summary_type, $status);
        // echo "<pre>"; print_r($result); exit;
        $results = $result['result'];

        $getTotal = NicuDischarge::GetTotal($summary_type);
        $total = $result['total'];
        //$total = 10;
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

        foreach ($results as $key => $value)
        {
            // $discharge_status = NicuDischarge::getDischargeStatus($value->BabyId);
            // $discharge_status = NicuDischarge::getAdmissionStatus($value->BabyId);
            // if (isset($discharge_status->status)) {
            //     $results[$key]->status = $discharge_status->status;
            // }
            // else
            // {
            //     $results[$key]->status = '';

            // }
            // $results[$key]->rowcolor = '';
            // if (trim($results[$key]->status) != 'Inpatient')
            // {
            //     $results[$key]->rowcolor = 'success';
            // }
            // else
            // {
            //     $results[$key]->rowcolor = 'info';
            // }

            if ($summary_type == 'discharged' || $status == 'discharged')
            {
                $results[$key]->rowcolor = 'success';
            }
            else
            {
                $results[$key]->rowcolor = 'info';
            }

        }
            // exit;

        if ($this->auth->user()->RoleId == 5)
        {
            $results = $results->where('is_completed', 2);
        }
        $this->flow->clearFlow();

        return view('reports.nicu-discharge.discharge_nicu_mainlist', compact('navigate', 'order', 'limit', 'pagination', 'results', 'search', 'getTotal', 'summary_type', 'status'));
    }
    public function discharge_sub_list($id, $summary_type = '')
    {
        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'nicu_discharge';

        $babyId = \SiteHelpers::decrypt_id($id);
        $results = NicuDischarge::get_inpatient_baby_sublists($babyId, $summary_type);
        $BabyName = isset($results[0]->BabyName) ? $results[0]->BabyName : '';
        // $abbrivated_summary = AbbreviatedSummaryLog::getPatientList($babyId);
        // $abbrivated_summary = collect($abbrivated_summary);
        $discharge_list = array();

        // if ($summary_type == 'interim') {
            $dischage_summary['baby_id'] = $results[0]->BabyId;
            $dischage_summary['admission_id'] = $results[0]->AdmissionId;
            // echo "<pre>"; print_r($dischage_summary); exit;
            $abbrivated_summary = DischargeSummary::where($dischage_summary)->first();
        // }

            // echo "<pre>"; print_r($abbrivated_summary); exit;
        return view('reports.nicu-discharge.discharge_nicu_sublists', compact('results', 'BabyName', 'navigate', 'abbrivated_summary', 'summary_type'));

    }
    public function index($id, $summary_type = '', Request $request)
    {

        $navigate['main_nav'] = 'NICU Admission';
        $navigate['sub_nav'] = 'nicu-discharge-summary';
        $input = $request->all();
        $enc['babyId'] = $id;

        $editor_gen_option = false;
        $generated = false;

        $headerContent = Settings::findorfail(1);

        // echo '<pre>';print_r($headerContent);
        // exit;
        $getbaby_details = explode('-', \SiteHelpers::decrypt_id($id));

        $results = NicuDischarge::get_lists($getbaby_details['0'], $getbaby_details['1']);

        $dischage_summary['baby_id'] = $getbaby_details[0];
        $dischage_summary['admission_id'] = $getbaby_details[1];
        $dischage_summary['flag'] = 2;
        // $dischage_summary['status'] = 1;

        $dischargeSummarymodified = array();

        $dischargeSummarymodified = DischargeSummary::where($dischage_summary)->first();
        $medical_problems = NicuDischarge::get_medical_problems($dischage_summary['baby_id']);
        $medical_complications = NicuDischarge::get_medical_complications($dischage_summary['baby_id']);
        $ultrasoundfindingstemp = NicuDischarge::get_ultrasound_findings($dischage_summary['baby_id']);
        $vaccine = NicuDischarge::get_vaccines($dischage_summary['baby_id']);
        $vaccineMasterList = Vaccine::get()->pluck('Name', 'Id')
        ->toArray();

        $vaccinelist = array();
        $tempVaccinelist = json_decode($vaccine->Vaccine);
        $tempVaccinedate = json_decode($vaccine->VaccineDate);
        if (is_array($tempVaccinelist))
        {
            foreach ($tempVaccinelist as $key => $value)
            {

                $vaccinelist[] = ['vaccineName' => isset($vaccineMasterList[$value]) ? $vaccineMasterList[$value] : '', 'vaccineDate' => isset($tempVaccinedate[$key]) ? $tempVaccinedate[$key] : ''];
            }
        }

        $ultrasoundfindings = array();
        $gastations_temp = array();
        $findings_temp = array();
        for ($j = 0;$j < @count($ultrasoundfindingstemp);$j++)
        {

            if (isset($ultrasoundfindingstemp[$j]->Gestation) && \SiteHelpers::is_serialized($ultrasoundfindingstemp[$j]->Gestation))
            {
                $gastations_temp = unserialize($ultrasoundfindingstemp[$j]->Gestation);
                $findings_temp = unserialize($ultrasoundfindingstemp[$j]->Finding);

                for ($i = 0;$i < @count($gastations_temp);$i++)
                {

                    if (!empty($gastations_temp[$i]))
                    {
                        $ultrasoundfindings[] = array(
                            'gastations' => $gastations_temp[$i],
                            'findings' => $findings_temp[$i]
                        );
                    }

                }

            }
            else
            {
                $ultrasoundfindings[] = array(
                    'gastations' => $ultrasoundfindingstemp[$j]->Gestation,
                    'findings' => $ultrasoundfindingstemp[$j]->Finding
                );
            }

        }

        $discharge_medications = NicuDischarge::get_discharge_medications($getbaby_details['1'], $getbaby_details['0']);

        $ipresult = IpNumber::getCurrent_ip($getbaby_details['0'], $getbaby_details['1']);
        $ipnumber = (count($ipresult) > 0) ? $ipresult->ip_number : '';

        $result = $results[0];

        $result->DOB = isset($result->DOB) && !empty($result->DOB) ? date('d-m-Y', strtotime($result->DOB)) : null;
        $result->DischargeDate = isset($result->DischargeDate) && !empty($result->DischargeDate) ? date('d-m-Y', strtotime($result->DischargeDate)) : null;
        $result->AdmissionDate = isset($result->AdmissionDate) && !empty($result->AdmissionDate) ? date('d-m-Y', strtotime($result->AdmissionDate)) : null;

        $result->Procedures = '';
        $result->AntenatalUltrasoundScanFindings = '';
        $result->Birth = '';
        $result->RespiratorySystemExtra = '';

        $params = array(
            'BabyId' => $getbaby_details['0'],
            'AdmissionId' => $getbaby_details['1']
        );

        $current_admission_id = $getbaby_details['1'];

        $daycare_list = NicuDischarge::get_daycare_lists($params);

        $GetICD = Icd::where('ICDCode', '<>', '')->get();
        $ICD = array();
        foreach ($GetICD as $key => $value)
        {
            $ICD[$value
                ->ICDCode] = $value->ICDDescription;

            }

            $InvasiveVentilation = $InvasiveVentilationType = $NonInvasiveVentilationType = $OtherRespiratorySupport = $WithoutVentilation = $Inotropes = $PDA = $NEC = $FullEnteralFeeds = $CurrentWt = $Seizures = $Sepsiss = $Meningitis = $MeningitisIndicated = $Transfusion = $GlucoseElectrolyte = $InsulinTherapy = $echostatus = $tpn = $TherapeuticHypothermia = $echoReporttatus = $neurosonogramReportstatus = $proceduresSystem = $uvcStatus = $uacStatus = $piccStatus = $MeningitisStatus = $PeripheralCannula = $pacStatus = $NeedleThoracocentesis = $intercostalDrain = $UltrasoundAbdominal = $RenalUltrasound = $chronicLung = $pphn = $pphnTreatment = $ultraSpine = $mrictbrain_status = $eeg_cfm_status = $viral_meningitis = '';

            $InvasiveVentilationCount = $OtherRespiratorySupportCount = $NonInvasiveVentilationCount = $Dopaminedays = $Dobutaminedays = $Adrenalinedays = $nor_adrenalinedays = $Milrinonedays = $maxcrp = $minplatelete = 0;

            $FiO2 = $PIP = $OI = $Indications = $PDATreatments = $DayOfLife = $NECtreatments = $SepsisValues = $Organisms = $Organismdaylifes = $A_Antibiotics = $F_Products = $Hypoglycemia = $TSB = $NNJTreatment = $ICDs = $get_problem = $Dopamine = $Dobutamine = $Adrenaline = $nor_adrenaline = $Milrinone = $daycarereachedstatus = $daycarenotreachedstatus = $animoacid = $fat = $total_enargy = $day_ids = $echo_status = $neuro_sonogram = $proceduresSystem_temp = $RenalUltrasoundkeys = $UltrasoundAbdominalkeys = $milkVolume = $pphnTreatmenttype = $ultrasoundSpine = $mrictbrain = $eeg_cfm = $crpcount = $plateletecount = array();

            $daycaresheetscount = count($daycare_list);

            $daymilk = 1;

            foreach ($daycare_list as $key => $daycare)
            {
                $day_ids[] = $daycare->DayId;
                if ($daycare->InvasiveVentilation == 'Yes')
                {
                    $InvasiveVentilation = 'Yes';
                    $InvasiveVentilationCount += 1;
                }
                if (!empty($daycare->ModeOfVentilation) && $daycare->InvasiveVentilation == 'Yes' && $daycare->ModeOfVentilation != 'NULL')
                {
                    $InvasiveVentilationType .= $daycare->ModeOfVentilation . ', ';
                }
                elseif (!empty($daycare->NonInvasiveVentilation) && $daycare->InvasiveVentilation == 'No' && !is_null($daycare->NonInvasiveVentilation) && $daycare->NonInvasiveVentilation != 'NULL')
                {
                    $NonInvasiveVentilationType .= $daycare->NonInvasiveVentilation . ', ';
                    $NonInvasiveVentilationCount += 1;
                }
                if (!empty($daycare->OtherRespiratorySupport) && $daycare->OtherRespiratorySupport != 'NULL')
                {
                    $OtherRespiratorySupport .= $daycare->OtherRespiratorySupport . ', ';
                    $OtherRespiratorySupportCount += 1;
                }

                if (!empty($daycare->FiO2))
                {
                    $FiO2[] = $daycare->FiO2;
                }
                if (!empty($daycare->PIP))
                {
                    $PIP[] = $daycare->PIP;
                }
                if (!empty($daycare->OI))
                {
                    $OI[] = $daycare->OI;
                }
                if (!empty($daycare->Indication))
                {

                    if (\SiteHelpers::is_serialized($daycare->Indication) && is_array(unserialize($daycare->Indication)))
                    {

                        $Indications[] = array_merge(unserialize($daycare->Indication));
                    }
                }

            // Prepare the Procedure


                if (!empty(trim($daycare->Uvc)) && trim($daycare->Uvc) == 'Yes') $uvcStatus .= 'Yes';

                if (!empty(trim($daycare->Uac)) && trim($daycare->Uac) == 'Yes') $uacStatus .= 'Yes';

                if (!empty(trim($daycare->Picc)) && trim($daycare->Picc) == 'Yes') $piccStatus .= 'Yes';

                if (!empty(trim($daycare->Meningitis)) && trim($daycare->Meningitis) == 'Yes') $MeningitisStatus .= 'Yes';

                if (!empty(trim($daycare->PeripheralCannula)) && trim($daycare->PeripheralCannula) == 'Yes') $PeripheralCannula .= 'Yes';

                if (!empty(trim($daycare->Pac)) && trim($daycare->Pac) == 'Yes') $pacStatus .= 'Yes';

                if (!empty(trim($daycare->needlethoracentesis)) && trim($daycare->needlethoracentesis) == 2)
                {
                    $NeedleThoracocentesis .= 'Yes';
                }

                if (!empty(trim($daycare->chronic_lung)) && trim($daycare->chronic_lung) == 2)
                {
                    $chronicLung .= 'Yes';

                }

                if (!empty(trim($daycare->intercostaldrain)) && trim($daycare->intercostaldrain) == 2)
                {
                    $intercostalDrain .= 'Yes';
                }

                if (!empty($daycare->ultrasoundabdominal) && trim($daycare->ultrasoundabdominal) == 2)
                {
                    $UltrasoundAbdominal .= 'Yes';
                    $UltrasoundAbdominalkeys[] = ['Dateofultrasound' => date('d-m-Y', strtotime($daycare->DayDate)) , 'abdominalultrasoundkeyfindings' => str_replace(',', ' ', $daycare->ultrasoundkeyfindings) ];
                }

                if (!empty($daycare->renalultrasound) && trim($daycare->renalultrasound) == 2)
                {
                    $RenalUltrasound .= 'Yes';
                    $RenalUltrasoundkeys[] = ['Dateofultrasound' => date('d-m-Y', strtotime($daycare->DayDate)) , 'renalultrasoundkeyfindings' => str_replace(',', ' ', $daycare->renalultrasoundkeyfindings) ];
                }

            // Prepare the CardiovascularSystem Data
                if (!empty($daycare->Inotropes) && $daycare->Inotropes == 'Yes') $Inotropes .= 'Yes';

                if (!empty($daycare->PDA) && $daycare->PDA == 'Yes')
                {
                    $PDA .= 'Yes';
                    if (!empty($daycare->PDATreatment)) $PDATreatments[] = $daycare->PDATreatment;

                }

                if (!empty(trim($daycare->pphn)) && $daycare->pphn == 'Yes')
                {
                    $pphn .= 'Yes';

                    if (!empty($daycare->pphn_treatement) && $daycare->pphn_treatement == 'None')
                    {

                        $pphnTreatment .= 'Yes';
                    }
                    elseif (!empty($daycare->pphn_treatement) && $daycare->pphn_treatement != 'None')
                    {
                        $pphnTreatmenttype[] = $daycare->pphn_treatement;
                    }

                }

                if (!empty(trim($daycare->echo_status)) && trim($daycare->echo_status) == 'Yes')
                {
                    $echoReporttatus .= 'Yes';
                    $echo_status[] = array(
                        'date' => date('d-m-Y', strtotime($daycare->DayDate)) ,
                        'echo_report' => str_replace(',', ' ', $daycare->DayEcho)
                    );
                }

                if (!empty($daycare->Volume) || $daycare->directlybreastfeed == '1')
                {
                    if (!empty($daycare->DayOfLife)) $DayOfLife[] = $daycare->DayOfLife;

                }

                if (isset($daycare->Volume))
                {
                    $milkVolume[] = array(
                        'milk' => $daycare->Volume,
                        'dayoflife' => $daycare->DayOfLife
                    );
                }

                if (!empty(trim($daycare->NEC)) && trim($daycare->NEC) == 'Yes')
                {

                    $NEC .= 'Yes';
                    if (!empty($daycare->NECtreatment)) $NECtreatments[] = $daycare->NECtreatment;
                }

                if (!empty($daycare->FullEnteralFeeds) && $daycare->FullEnteralFeeds == 'Reached')
                {
                    $FullEnteralFeeds .= (empty($FullEnteralFeeds)) ? $daycare->DayOfLife : '';
                    $daycarereachedstatus[] = $daycare->DayOfLife;

                }

                if (!empty($daycare->FullEnteralFeeds) && $daycare->FullEnteralFeeds == 'Not Reached')
                {
                    $daycarenotreachedstatus[] = $daycare->DayOfLife;

                }

                if ($result->BirthWeight == $daycare->CurrentWt)
                {
                    $CurrentWt .= (empty($CurrentWt)) ? $daycare->DayOfLife : '';

                }

            // Prepare the CentralNervousSystem Data
                if (!empty($daycare->Seizures) && $daycare->Seizures == 'Yes') $Seizures .= 'Yes';

            // Prepare the Sepsis Data
                if (!empty($daycare->Sepsis) && $daycare->Sepsis != 'No sepsis')
                {
                    $Sepsiss .= 'Yes';
                    $SepsisValues[] = $daycare->Sepsis;
                }

                if (!is_null($daycare->CRP) && !empty($daycare->CRP))
                {
                    $crpcount[] = $daycare->CRP;
                }
                if (!is_null($daycare->Platelets) && !empty($daycare->Platelets))
                {
                    $plateletecount[] = $daycare->Platelets;
                }
                if (!empty($daycare->viral_meningitis) && !is_null($daycare->viral_meningitis) && $daycare->viral_meningitis == 2)
                {
                    $viral_meningitis .= 'Yes';
                }

                if (!empty($daycare->neuro_sonogram) && trim($daycare->neuro_sonogram) == 'performed')
                {
                    $neurosonogramReportstatus .= 'performed';
                    $neuro_sonogram[] = array(
                        'date' => date('d-m-Y', strtotime($daycare->DayDate)) ,
                        'Cuss' => str_replace(',', ' ', $daycare->Cuss)
                    );

                }
                if (!empty($daycare->ultrasound_spine) && trim($daycare->ultrasound_spine) == 2)
                {
                    $ultraSpine .= 'yes';
                    $ultrasoundSpine[] = ['date' => date('d-m-Y', strtotime($daycare->DayDate)) , 'spine_report' => $daycare->ultrasound_spine_report];

                }

                if (!empty($daycare->mrict_brain_status) && trim($daycare->mrict_brain_status) == 2)
                {
                    $mrictbrain_status .= 'yes';
                    $mrictbrain[] = ['date' => date('d-m-y', strtotime($daycare->DayDate)) , 'mrictbrain' => $daycare->mri_ct_brain];

                }
                if (!empty($daycare->eeg_cfm) && trim($daycare->eeg_cfm) == 2)
                {
                    $eeg_cfm_status .= 'Yes';
                    $eeg_cfm[] = ['date' => date('d-m-y', strtotime($daycare->DayDate)) , 'eeg_cfm' => $daycare->eeg_cfm_report];

                }

                if (!empty($daycare->Organism) && count(@unserialize($daycare->Organism)) > 0 && @unserialize($daycare->Organism) !== false)
                {
                    $flag_organizam = false;
                    foreach (unserialize($daycare->Organism) as $organisamValue)
                    {
                        if (!empty(trim($organisamValue)))
                        {
                            $flag_organizam = true;
                            break;
                        }

                    }
                    if ($flag_organizam)
                    {
                        $Organisms = array_merge($Organisms, unserialize($daycare->Organism));
                        $Organismdaylifes[] = $daycare->DayOfLife;
                    }
                }

                if (!empty($daycare->echo_status) && $daycare->echo_status == 'Yes')
                {
                    $echostatus .= 'Yes';
                }

                if (!empty(trim($daycare->TherapeuticHypothermia)) && trim($daycare->TherapeuticHypothermia) == 'Yes')
                {
                    $TherapeuticHypothermia .= 'Yes';
                }

            /*if(!empty($daycare->A_Antibiotic)) {
                $A_Antibiotics[] = implode(',', array_unique(json_decode($daycare->A_Antibiotic)));
            }*/
            if (!empty($daycare->Meningitis) && $daycare->Meningitis == 'Yes') $Meningitis .= 'Yes';
            elseif (!empty($daycare->Meningitis) && $daycare->Meningitis == 'LP Not Indicated') $MeningitisIndicated .= 'Indicated';

            //Hematology
            if (!empty($daycare->Transfusion) && $daycare->Transfusion == 'Yes')
            {
                $Transfusion .= 'Yes';
                $products = Fluid::where('DayId', '=', $daycare->DayId)
                ->get();
                foreach ($products as $key => $product)
                {
                    $F_Products[] = $product->Product;
                }

            }
            else
            {
                $Transfusion .= '';
            }
            if ($daycare->Hypoglycemia == '0' && $daycare->Hyperglycemia == '0' && $daycare->InsulinTherapy == '0' && $daycare->Hyponatremia == '0' && $daycare->Hypernatremia == '0' && $daycare->Hypokalemia == '0' && $daycare->Hyperglycemia == '0' && $daycare->Hyperkalemia == '0' && $daycare->Hypocalcemia == '0' && $daycare->Hypercalcemia == '0')
            {
                $GlucoseElectrolyte = 'No';
            }
            if ($daycare->Hypoglycemia == '1' || $daycare->Hyperglycemia == '1' || $daycare->InsulinTherapy == '1' || $daycare->Hyponatremia == '1' || $daycare->Hypernatremia == '1' || $daycare->Hypokalemia == '1' || $daycare->Hyperglycemia == '1' || $daycare->Hyperkalemia == '1' || $daycare->Hypocalcemia == '1' || $daycare->Hypercalcemia == '1')
            {
                if ($daycare->Hypoglycemia == '1') $Hypoglycemia[] = 'Hypoglycemia';
                if ($daycare->Hyperglycemia == '1') $Hypoglycemia[] = 'Hyperglycemia';
                if ($daycare->Hyponatremia == '1') $Hypoglycemia[] = 'Hyponatremia';
                if ($daycare->Hypernatremia == '1') $Hypoglycemia[] = 'Hypernatremia';
                if ($daycare->Hypokalemia == '1') $Hypoglycemia[] = 'Hypokalemia';
                if ($daycare->Hyperglycemia == '1') $Hypoglycemia[] = 'Hyperglycemia';
                if ($daycare->Hyperkalemia == '1') $Hypoglycemia[] = 'Hyperkalemia';
                if ($daycare->Hypocalcemia == '1') $Hypoglycemia[] = 'Hypocalcemia';
                if ($daycare->Hypercalcemia == '1') $Hypoglycemia[] = 'Hypercalcemia';
            }

            if ($daycare->Hyperglycemia == '1' && $daycare->InsulinTherapy == '1')
            {
                $InsulinTherapy = 'Yes';
            }
            if (!empty($daycare->TSB))
            {
                $TSB[$daycare
                    ->DayOfLife] = $daycare->TSB;
                }
                if (!empty($daycare->NNJTreatment) && trim($daycare->NNJTreatment) != 'None')
                {
                    $NNJTreatment[] = $daycare->NNJTreatment;
                }
                if (!empty(trim($daycare->Tpn)) && trim($daycare->Tpn) == 'Yes')
                {
                    $tpn .= 'Yes';
                    $animoacid[] = $daycare->Protein;
                    $fat[] = $daycare->Fat;
                    $total_enargy[] = $daycare->total_energy;

                }

                if (!empty($daycare->NicuICD) && count(json_decode($daycare->NicuICD)) > 0)
                {
                    $Get_Icd = json_decode($daycare->NicuICD);
                    if (is_array($Get_Icd->ResICD) && count($Get_Icd->ResICD) != 0)
                    {
                        foreach ($Get_Icd->ResICD as $key => $value)
                        {
                            $ICDs[] = $value;
                        }
                    }
                    if (is_array($Get_Icd->CarICD) && count($Get_Icd->CarICD) != 0)
                    {
                        foreach ($Get_Icd->CarICD as $key => $value)
                        {
                            $ICDs[] = $value;
                        }
                    }
                    if (is_array($Get_Icd->GasICD) && count($Get_Icd->GasICD) != 0)
                    {
                        foreach ($Get_Icd->GasICD as $key => $value)
                        {
                            $ICDs[] = $value;
                        }
                    }
                    if (is_array($Get_Icd->CenICD) && count($Get_Icd->CenICD) != 0)
                    {
                        foreach ($Get_Icd->CenICD as $key => $value)
                        {
                            $ICDs[] = $value;
                        }
                    }
                    if (is_array($Get_Icd->FluidICD) && count($Get_Icd->FluidICD) != 0)
                    {
                        foreach ($Get_Icd->FluidICD as $key => $value)
                        {
                            $ICDs[] = $value;
                        }
                    }
                    if (is_array($Get_Icd->SepsisICD) && count($Get_Icd->SepsisICD) != 0)
                    {
                        foreach ($Get_Icd->SepsisICD as $key => $value)
                        {
                            $ICDs[] = $value;
                        }
                    }
                    if (is_array($Get_Icd->SkinICD) && count($Get_Icd->SkinICD) != 0)
                    {
                        foreach ($Get_Icd->SkinICD as $key => $value)
                        {
                            $ICDs[] = $value;
                        }
                    }
                    if (is_array($Get_Icd->RopICD) && count($Get_Icd->RopICD) != 0)
                    {
                        foreach ($Get_Icd->RopICD as $key => $value)
                        {
                            $ICDs[] = $value;
                        }
                    }

                    if (!empty($daycare->Dopamine))
                    {
                        $Dopamine[] = $daycare->Dopamine;
                        $Dopaminedays += 1;
                    }
                    if (!empty($daycare->Dobutamine))
                    {
                        $Dobutamine[] = $daycare->Dobutamine;
                        $Dobutaminedays += 1;
                    }
                    if (!empty($daycare->Adrenaline))
                    {
                        $Adrenaline[] = $daycare->Adrenaline;
                        $Adrenalinedays += 1;
                    }
                    if (!empty($daycare->Noradrenaline))
                    {
                        $nor_adrenaline[] = $daycare->Noradrenaline;
                        $nor_adrenalinedays += 1;

                    }
                    if (!empty($daycare->Milrinone))
                    {
                        $Milrinone[] = $daycare->Milrinone;
                        $Milrinonedays += 1;
                    }

                    $daymilk++;

                }
            }

            $masters_antibiotic = \ValuelistHelpers::getDrugIvFluidsAntibiotic();

            $temp_antibiotic = collect(NicuDischarge::get_antibiotic($day_ids)->toArray());
            $daysofanitbiotic = $temp_antibiotic->pluck('DayOfLife')
            ->toArray();
            $antibio_days = $temp_antibiotic->groupBy('Antibiotic')
            ->toArray();

            $tmep_list_bio = array();
            foreach ($antibio_days as $biodays)
            {
                $temp_collect = collect($biodays);
                $tmep_list_bio[] = array(
                    'Antibiotic' => $temp_collect->max('Antibiotic') ,
                    'DayOfLife' => \SiteHelpers::calculate_serial_days($temp_collect->pluck('DayOfLife')
                        ->toArray()) ,
                );
            }

        // $uvcStatus = $uacStatus
            if (!empty($result->UAC) && $result->UAC == 'Yes') $uacStatus .= 'Yes';

            if (!empty($result->UVC) && $result->UVC == 'Yes') $uvcStatus .= 'Yes';

        //procedures


            if ($result->InitialXray == 'Performed' && isset($result->xrayfindings) && isset($result->AgeofCXR) && !empty(trim($result->xrayfindings)) && !empty(trim($result->AgeofCXR)))
            {

                $proceduresSystem_temp[] = '<li>Chest and abdominal X Ray</li>';

            }
            elseif ($result->InitialXray == 'Performed' && isset($result->xrayfindings) && isset($result->AgeofCXR) && !empty(trim($result->xrayfindings)) && empty(trim($result->AgeofCXR)))
            {

                $proceduresSystem_temp[] = '<li>Chest X Ray</li>';

            }
            elseif ($result->InitialXray == 'Performed' && isset($result->xrayfindings) && isset($result->AgeofCXR) && !empty(trim($result->AgeofCXR)) && empty(trim($result->xrayfindings)))
            {

                $proceduresSystem_temp[] = '<li>Abdominal X Ray</li>';
            }

            if (trim($uacStatus) !== null && !empty($uacStatus)) $proceduresSystem_temp[] = '<li>UAC</li>';

            if (trim($uvcStatus) !== null && !empty($uvcStatus)) $proceduresSystem_temp[] = '<li>UVC</li>';

            if (trim($echostatus) !== null && !empty($echostatus)) $proceduresSystem_temp[] = '<li>Echo Cardiogram</li>';

            if (trim($neurosonogramReportstatus) !== null && !empty($neurosonogramReportstatus)) $proceduresSystem_temp[] = '<li>Neuro Sonogram</li>';

            if (trim($piccStatus) !== null && !empty($piccStatus)) $proceduresSystem_temp[] = '<li>PICC</li>';

            if (trim($MeningitisStatus) !== null && !empty($MeningitisStatus)) $proceduresSystem_temp[] = '<li>Lumbar Puncture</li>';

            if (trim($PeripheralCannula) !== null && !empty($PeripheralCannula)) $proceduresSystem_temp[] = '<li> Peripheral Cannula </li>';

            if (trim($pacStatus) !== null && !empty($pacStatus)) $proceduresSystem_temp[] = '<li>Peripheral Arterial Line</li>';

            if (trim($NeedleThoracocentesis) !== null && !empty($NeedleThoracocentesis)) $proceduresSystem_temp[] = '<li>Needle Thoracocentesis</li>';

            if (trim($intercostalDrain) !== null && !empty($intercostalDrain)) $proceduresSystem_temp[] = '<li>Intercostal Drain </li>';

            if (trim($UltrasoundAbdominal) !== null && !empty($UltrasoundAbdominal)) $proceduresSystem_temp[] = '<li>Ultrasound Abdomen </li>';

            if (trim($RenalUltrasound) !== null && !empty($RenalUltrasound)) $proceduresSystem_temp[] = '<li>Renal Ultrasound </li>';


            if ($result->procedures != '') {
                $procedures = json_decode($result->procedures);
                if (count($procedures) > 0 && is_array($procedures)) {
                    $procedures = array_filter($procedures);
                }

                if (count($procedures) > 0 && is_array($procedures)) {

                    $procedures = array_filter($procedures, function($value) {
                        return ($value !== null && $value !== false && $value !== '' && $value !== 'undefined'); 
                    });

                    $procedures_list = ProcedureMaster::selectRaw('\'<li>\' ||"Name" || \'</li>\' as name')->whereIn('Id', $procedures)->pluck('name')->toArray();
                    $proceduresSystem_temp = array_merge_recursive($proceduresSystem_temp, $procedures_list);

                }
            }


            if (count($proceduresSystem_temp) !== 0)
            {

                $proceduresSystem = 'The baby underwent the following procedures. ';
                
                $proceduresSystem .= '<table class="mtb-10">';

                $k = 0;

                foreach ($proceduresSystem_temp as $procedures_value) {
                
                    if ($k % 3 == 0) {
                        $proceduresSystem .= '<tr>';
                    }
                    $proceduresSystem .= '<td><ul>' . $procedures_value . '</ul></td>';

                    $k++;
                    if ($k % 3 == 0) {
                        $proceduresSystem .= '</tr>';
                    }

                }

                $proceduresSystem .= '</table>';

            }

        // foreach ($tmep_list_bio as &$list_bio) {
        //    $tempdayoflife = '';
        //    $i = array();
        //    foreach ($list_bio['DayOfLife'] as $key => $lists_temps) {
        //            $j = $key - 1;
        //               $i[] = $lists_temps;
        //            if(isset($list_bio['DayOfLife'][$j]) && ($list_bio['DayOfLife'][$key] - $list_bio['DayOfLife'][$j]) > 1){
        //                    $tempdayoflife .=min($i).' to '.max($i);
        //                    unset($i);
        //            }
        //    }


        //    $list_bio['DayOfLife'] = $tempdayoflife;
        // }


            $maxFiO2 = (count($FiO2) != 0) ? max($FiO2) : '';
            $maxPIP = (count($PIP) != 0) ? max($PIP) : '';
            $maxOI = (count($OI) != 0) ? max($OI) : '';
            $maxTSB = (count($TSB) != 0) ? max($TSB) : '';
            $PDATreatment = (count($PDATreatments) != 0) ? implode(',', array_unique($PDATreatments)) : '';

            $maxDopamine = (count($Dopamine) != 0) ? max($Dopamine) : '';
            $maxDobutamine = (count($Dobutamine) != 0) ? max($Dobutamine) : '';
            $maxAdrenaline = (count($Adrenaline) != 0) ? max($Adrenaline) : '';
            $maxnor_adrenaline = (count($nor_adrenaline) != 0) ? max($nor_adrenaline) : '';
            $maxmilrinone = (count($Milrinone) != 0) ? max($Milrinone) : '';
            $maxcrp = (count($crpcount) != 0) ? max($crpcount) : '';
            $minplatelete = (count($plateletecount)) ? min($plateletecount) : '';

            $maxanimoacid = (count($animoacid) != 0) ? max($animoacid) : '';
            $maxfat = (count($fat) != 0) ? max($fat) : '';
            $maxtotal_enargy = (count($total_enargy) != 0) ? max($total_enargy) : '';

            $Indication = (count($Indications) != 0) ? implode(',', array_unique(array_collapse($Indications))) : '';
            $DayOfLife = (count($DayOfLife) != 0) ? min($DayOfLife) : '';
            $NECtreatment = (count($NECtreatments) != 0) ? implode(',', array_unique($NECtreatments)) : '';
            $SepsisValue = (count($SepsisValues) != 0) ? implode(',', array_unique($SepsisValues)) : '';
            $Organismdaylife = (count($Organismdaylifes) != 0) ? implode(',', array_unique($Organismdaylifes)) : '';
            $Organism = (count($Organisms) != 0) ? implode(',', array_unique($Organisms)) : '';
            $F_Product_temp = (count($F_Products) != 0) ? array_unique($F_Products) : '';
            $F_Product = null;

            if (!empty($F_Product_temp) && count($F_Product_temp) > 0)
            {
                $F_Product = '<br/> <ul>';

                foreach ($F_Product_temp as $key => $value)
                {
                    if (!empty($value))
                    {
                        $F_Product .= '<li>' . $value . '</li>';
                    }
                }
                $F_Product .= '</ul>';
            }

            $NNJTreatments = (count($NNJTreatment) != 0) ? array_unique($NNJTreatment) : $NNJTreatment;
            $Hypoglycemia = (count($Hypoglycemia) != 0) ? array_unique($Hypoglycemia) : $Hypoglycemia;
            if (count(json_decode($result->DifferentialDiagnosis)) > 0)
            {
                $ICDs = array_merge(json_decode($result->DifferentialDiagnosis) , $ICDs);
            }
            $ICDs = (count($ICDs) != 0) ? array_unique($ICDs) : array();

            $sex = ($result->Sex == 'Male') ? 'He' : 'She';
            $passsex = ($result->Sex == 'Male') ? 'His' : 'Her';

            $InvasiveVentilationType = (!empty($InvasiveVentilationType)) ? substr($InvasiveVentilationType, 0, -2) : '';
            $NonInvasiveVentilationType = (!empty($NonInvasiveVentilationType)) ? substr($NonInvasiveVentilationType, 0, -2) : '';
            $OtherRespiratorySupport = (!empty($OtherRespiratorySupport)) ? substr($OtherRespiratorySupport, 0, -2) : '';
            if (empty($InvasiveVentilationType) && empty($NonInvasiveVentilationType) && empty($OtherRespiratorySupport)) $WithoutVentilation = 'Yes';

            $NonInvasiveVentilationType = array_unique(explode(', ', $NonInvasiveVentilationType));
            $InvasiveVentilationType = array_unique(explode(', ', $InvasiveVentilationType));
            $InvasiveVentilationType = implode(',', $InvasiveVentilationType);
            $OtherRespiratorySupport = array_unique(explode(', ', $OtherRespiratorySupport));
            $OtherRespiratorySupport = implode(',', $OtherRespiratorySupport);

            $temp_ind_count = count($NonInvasiveVentilationType);
            $temp_noninvasiveventilation = '';
            $j = 0;
            foreach ($NonInvasiveVentilationType as $ventilation_type)
            {
                $j++;
                if (($temp_ind_count - $j) == 1)
                {
                    $temp_noninvasiveventilation .= $ventilation_type . ' and ';
                }
                elseif (($temp_ind_count - $j) > 1)
                {
                    $temp_noninvasiveventilation .= $ventilation_type . ' , ';
                }
                else
                {
                    $temp_noninvasiveventilation .= $ventilation_type . ' ';
                }
            }
            $NonInvasiveVentilationType = $temp_noninvasiveventilation;

        // Prepare the CardiovascularSystem Data
            $CardiovascularSystem = null;
            if (empty($Inotropes))
            {
                $CardiovascularSystem .= $passsex;
                $CardiovascularSystem .= ' blood pressure remained stable and did not require any inotropic support during ' . strtolower($passsex) . ' stay. ';
            }
            else
            {
                $CardiovascularSystem .= (empty($CardiovascularSystem)) ? $sex : $passsex;
                $CardiovascularSystem .= ' required the following inotropic support for hypotension. ';

                if (!empty($maxDopamine) || !empty($maxDobutamine) || !empty($maxAdrenaline) || !empty($maxnor_adrenaline) || !empty($maxmilrinone))
                {

                    $CardiovascularSystem .= '<table class="table mtb-10">';
                    $CardiovascularSystem .= '<tr><th>Name</th> <th>Maximum Dose Required</th><th> Total Number Of Days</th></tr>';
                    if (!empty($maxDopamine) && $maxDopamine != 0)
                    {
                        $CardiovascularSystem .= '<tr> <td> Dopamine </td> <td>' . $maxDopamine . ' (mcg/kg/min)</td><td>' . $Dopaminedays . ' days     </td></tr>';
                    }
                    if (!empty($maxDobutamine) && $maxDobutamine != 0)
                    {
                        $CardiovascularSystem .= '<tr> <td> Dobutamine </td> <td>' . $maxDobutamine . ' (mcg/kg/min)</td><td>' . $Dobutaminedays . ' days    </td></tr>';
                    }
                    if (!empty($maxAdrenaline) && $maxAdrenaline != 0)
                    {
                        $CardiovascularSystem .= '<tr> <td> Adrenaline </td> <td>' . $maxAdrenaline . ' (ng/kg/min)</td><td>' . $Adrenalinedays . ' days    </td></tr>';
                    }
                    if (!empty($maxnor_adrenaline) && $maxnor_adrenaline != 0)
                    {
                        $CardiovascularSystem .= '<tr> <td> Nor adrenaline </td> <td>' . $maxnor_adrenaline . ' (ng/kg/min)</td><td>' . $nor_adrenalinedays . ' days</td></tr>';
                    }
                    if (!empty($maxmilrinone) && $maxmilrinone != 0)
                    {
                        $CardiovascularSystem .= '<tr> <td> Milrinone </td> <td>' . $maxmilrinone . ' (mcg/kg/hour)</td><td>' . $Milrinonedays . ' days     </td></tr>';
                    }
                    $CardiovascularSystem .= '</table>';

                }
            }
            if (empty($echostatus) && empty($PDA))
            {
                $CardiovascularSystem .= 'The baby did not require an echocardiogram. ';
            }
            else
            {

                if (!empty($echostatus) && empty($PDA))
                {
                    $CardiovascularSystem .= $sex;
                    $CardiovascularSystem .= ' did not have a PDA. ';
                }
                elseif (!empty($echostatus) && !empty($PDA) && $PDATreatment == 'None' || empty($PDATreatment))
                {

                    $CardiovascularSystem .= ' A PDA was detected on echocardiogram however, it did not require treatment. ';
                }
                elseif (!empty($echostatus) && !empty($PDA) && $PDATreatment != 'None' || !empty($PDATreatment))
                {
                    $CardiovascularSystem .= 'A PDA was detected on echocardiogram. ';
                    $CardiovascularSystem .= $sex;
                    $CardiovascularSystem .= ' required ' . strtolower($PDATreatment) . ' treatment for PDA. ';
                }

            }

            if (isset($pphn) && !empty($pphn) && empty($pphnTreatment) && count($pphnTreatmenttype) == 0)
            {
                $CardiovascularSystem .= $sex . ' was diagnosed to have pulmonary hypertension. ';
            }
            elseif (isset($pphn) && !empty($pphn) && !empty($pphnTreatment) && count($pphnTreatmenttype) == 0)
            {
                $CardiovascularSystem .= $sex . ' was diagnosed to have pulmonary hypertension but did not require treatment. ';
            }
            elseif (isset($pphn) && !empty($pphn) && empty($pphnTreatment) && count($pphnTreatmenttype) > 0)
            {
                $CardiovascularSystem .= $sex . ' was diagnosed to have pulmonary hypertension ';
                $CardiovascularSystem .= 'and required ' . str_replace('_', ' ', implode(' and ', array_unique($pphnTreatmenttype))) . '. ';
            }

            if (!empty($echoReporttatus))
            {

                $CardiovascularSystem .= '<table  class=" mtb-10">';
                $CardiovascularSystem .= '<tr><th colspan="2"><h5 class="mtb-0"><b> Echo Findings</b></h5></th></tr>';
                $CardiovascularSystem .= '<tr><th>Date</th><th>Findings</th></tr>';
                foreach ($echo_status as $echosystem)
                {
                    $CardiovascularSystem .= '<tr><td>' . $echosystem['date'] . '</td><td>' . $echosystem['echo_report'] . '</td></tr>';
                }
                $CardiovascularSystem .= '</table>';

            }

            $CardiovascularSystem .= (!empty($input['CardiovascularSystem'])) ? $input['CardiovascularSystem'] : '';

        // Prepare the GastrointestinalSystem Data
            $previousdayVolume = 0;
            $reached = array();

            foreach ($milkVolume as $volumeKey => $volumeValue)
            {
                if ($volumeKey != 0)
                {
                    $diffVolume = 0;

                    $previousdayVolume = $volumeKey - 1;

                    if ((int)$milkVolume[$previousdayVolume]['milk'] > (int)$milkVolume[$volumeKey]['milk'])
                    {
                        $reached[] = $milkVolume[$volumeKey]['dayoflife'];
                    }
                }

            }

            $GastrointestinalSystem = null;
            if ($result->NBM == 'No') $GastrointestinalSystem .= $sex . ' received IV fluids following admission to the neonatal unit. ';

            if (!empty($tpn))
            {
                $GastrointestinalSystem .= $sex . ' also received parenteral nutrition. ' . $sex . ' achieved a maximum animo acid intake of ' . $maxanimoacid . ' g/kg/day and a fatty acid intake of ' . $maxfat . ' g/kg/day. ';
                $GastrointestinalSystem .= $passsex . ' maximum total energy intake was ' . $maxtotal_enargy . ' kcal/kg/day. ';
            }
            else
            {
                $GastrointestinalSystem .= $sex . ' did not receive parenteral nutrition. ';
            }

            if (!empty($DayOfLife)) $GastrointestinalSystem .= 'Milk feeds were commenced from day ' . $DayOfLife . '. This was gradually increased as tolerated. ';

            if (empty($NEC)) $GastrointestinalSystem .= $sex . ' did not develop NEC. ';
            else $GastrointestinalSystem .= $sex . ' developed NEC. ';

            if (!empty($NECtreatment)) $GastrointestinalSystem .= $sex . '  received ' . strtolower($NECtreatment) . ' treatment for NEC. ';

            sort($daycarereachedstatus);
            $feedscollection = Collect($daycarereachedstatus);

            sort($daycarenotreachedstatus);

            $feedsnotreachedcollect = Collect($daycarenotreachedstatus);

            if (count($daycarereachedstatus) > 0 && isset($daycarereachedstatus[0]))
            {
                $GastrointestinalSystem .= $sex . ' reached full feeds for the first time on day ' . strtolower($feedscollection->first()) . '. ';
            }
        // if(count($feedsnotreachedcollect) > 0 && $feedsnotreachedcollect->count() > 0 && $feedsnotreachedcollect->min() >= $feedsnotreachedcollect->min() && $feedsnotreachedcollect->min() >= $DayOfLife){
        //     $key= $feedscollection->search($feedscollection->first(),true);
        //      (!empty($key) && $feedscollection->has($key)) ? $feedscollection->forget(array($key)): '';
        //      $GastrointestinalSystem.='Due to feed intolerance/other medical reasons, milk feeds were either stopped or volume reduced on days '. \SiteHelpers::array_to_string_support($feedsnotreachedcollect->toArray()) .' '.$sex.' again reached full feeds on days '.\SiteHelpers::array_to_string_support($feedscollection->toArray()).' ';
        // }
            if (count($reached) > 0)
            {
                $GastrointestinalSystem .= 'Due to feed intolerance/other medical reasons, milk feeds were either stopped or volume reduced on days ' . \SiteHelpers::array_to_string_support(array_unique($reached)) . ' ';
            }

            if ($feedscollection->count() > 1)
            {
                $key = $feedscollection->search($feedscollection->first() , true);
                $tempfeed = $feedscollection->toArray();
                $firstDay = $tempfeed[$key];

                if (isset($tempfeed[$key]))
                {
                    unset($tempfeed[$key]);
                }
                $againreached = array();
                $tf = 0;
                foreach ($tempfeed as $feeds => $feedvalue)
                {

                    if (count($tempfeed) && $feeds != 1)
                    {
                        $tf = $feeds - 1;
                        $diffeed = $tempfeed[$feeds] - $tempfeed[$tf];

                        if ($diffeed > 1)
                        {
                            $againreached[] = $tempfeed[$feeds];
                        }
                    }
                    elseif (count($tempfeed) == 1 && ($tempfeed[$feeds] - $firstDay) > 1)
                    {
                        $againreached[] = $tempfeed[$feeds];
                    }

                }
                if (count($againreached) > 0)
                {
                    $GastrointestinalSystem .= $sex . ' again reached full feeds on days ' . \SiteHelpers::array_to_string_support($againreached) . '. ';
                }
            }

            if (!empty($CurrentWt)) $GastrointestinalSystem .= $sex . ' regained birth weight on day ' . strtolower($CurrentWt) . '. ';

            if (!empty($result->FeedingAtDischarge) && trim($result->FeedingAtDischarge) != 'Not applicable')
            {
                if (!empty($result->FeedingAtDischarge) && trim($result->FeedingAtDischarge) == 'Not applicable')
                {
                    $GastrointestinalSystem .= 'At discharge, ' . strtolower($sex) . ' is ' . strtolower($result->FeedingAtDischarge) . '. ';
                }
                elseif (!empty($result->FeedingAtDischarge) && trim($result->FeedingAtDischarge) == 'Fed DBF + EBM Top up')
                {
                    $GastrointestinalSystem .= 'At discharge, ' . strtolower($sex) . ' is breast fed also receives expressed breast milk top up. ';
                }
                elseif (!empty($result->FeedingAtDischarge) && trim($result->FeedingAtDischarge) == 'Fed DBF + Formula Top up')
                {
                    $GastrointestinalSystem .= 'At discharge, ' . strtolower($sex) . ' is breast fed also receives formula top up. ';
                }
                elseif (!empty($result->FeedingAtDischarge) && trim($result->FeedingAtDischarge) == 'Fed DBF + EBM/Formula Top up')
                {
                    $GastrointestinalSystem .= 'At discharge, ' . strtolower($sex) . ' is breast fed also receives formula/expressed breast milk top up. ';
                }
                elseif (!empty($result->FeedingAtDischarge) && trim($result->FeedingAtDischarge) == 'Spoon Fed with EBM')
                {
                    $GastrointestinalSystem .= 'At discharge, ' . strtolower($sex) . ' is paladai/spoon fed with expressed breast milk. ';
                }
                elseif (!empty($result->FeedingAtDischarge) && trim($result->FeedingAtDischarge) == 'Spoon Fed with Formula')
                {
                    $GastrointestinalSystem .= 'At discharge, ' . strtolower($sex) . ' is paladai/spoon fed with formula milk. ';
                }
            }

            $GastrointestinalSystem .= (!empty($input['GastrointestinalSystem'])) ? $input['GastrointestinalSystem'] : '';

        // Prepare the CentralNervousSystem Data
            $CentralNervousSystem = null;

            if (!empty($TherapeuticHypothermia)) $CentralNervousSystem .= $sex . ' received therapeutic hypothermia for delayed perinatal adaptation. A target temperature between 33.2 &#8451; to 33.8 &#8451; was achieved. ';

            if ($result->discharge_cuss == 'Normal' || $result->discharge_cuss == 'Abnormal') $CentralNervousSystem .= $passsex . ' cranial ultrasound scans performed were ' . strtolower($result->discharge_cuss) . '. ';
            elseif ($result->discharge_cuss == 'Not Indicated') $CentralNervousSystem .= ' There were no indications to perform a cranial ultrasound scan. ';

            if (empty($Seizures)) $CentralNervousSystem .= $sex . ' did not have any seizures. ';
            else $CentralNervousSystem .= $sex . ' developed seizures during neonatal stay. ';

            if (!empty($Meningitis)) $CentralNervousSystem .= $sex . ' was treated for meningitis. ';

            if (!empty($neurosonogramReportstatus))
            {

                $CentralNervousSystem .= '<br/><b>NeuroSonogram Findings</b><br/>';
                $CentralNervousSystem .= '<table class="mtb-10">';
                $CentralNervousSystem .= '<tr><th>Date</th><th>Findings</th><tr>';
                foreach ($neuro_sonogram as $neurosonogram_system)
                {

                    $CentralNervousSystem .= '<tr><td>' . $neurosonogram_system['date'] . '</td><td>' . $neurosonogram_system['Cuss'] . '</td></tr>';

                }
                $CentralNervousSystem .= '</table>';

            }

            if (!empty($ultraSpine))
            {

                $CentralNervousSystem .= '<br/><b>Ultrasound Spine Findings</b><br/>';
                $CentralNervousSystem .= '<table class="mtb-10">';
                $CentralNervousSystem .= '<tr><th>Date</th><th>Findings</th><tr>';
                foreach ($ultrasoundSpine as $ultrasound_spine_system)
                {

                    $CentralNervousSystem .= '<tr><td>' . $ultrasound_spine_system['date'] . '</td><td>' . $ultrasound_spine_system['spine_report'] . '</td></tr>';

                }
                $CentralNervousSystem .= '</table>';

            }
            if (!empty($mrictbrain_status))
            {

                $CentralNervousSystem .= '<br/><b>MRI/CT Findings</b><br/>';
                $CentralNervousSystem .= '<table class="mtb-10">';
                $CentralNervousSystem .= '<tr><th>Date</th><th>Findings</th><tr>';
                foreach ($mrictbrain as $mrict_system)
                {

                    $CentralNervousSystem .= '<tr><td>' . $mrict_system['date'] . '</td><td>' . $mrict_system['mrictbrain'] . '</td></tr>';

                }
                $CentralNervousSystem .= '</table>';

            }

            if (!empty($eeg_cfm_status))
            {

                $CentralNervousSystem .= '<br/><b>EEG/CFM Findings</b><br/>';
                $CentralNervousSystem .= '<table class="mtb-10">';
                $CentralNervousSystem .= '<tr><th>Date</th><th>Findings</th><tr>';
                foreach ($eeg_cfm as $eeg_cfm_system)
                {

                    $CentralNervousSystem .= '<tr><td>' . $eeg_cfm_system['date'] . '</td><td>' . $eeg_cfm_system['eeg_cfm'] . '</td></tr>';

                }
                $CentralNervousSystem .= '</table>';

            }

            if (!empty($result->NeurologicalStatus)) $CentralNervousSystem .= $passsex . ' discharge neurological status is ' . strtolower($result->NeurologicalStatus) . '. ';

            $CentralNervousSystem .= (!empty($input['CentralNervousSystem'])) ? $input['CentralNervousSystem'] : '';

        // Prepare the Sepsis Data
            $Sepsis = null;

            if (empty($Sepsiss)) $Sepsis .= $sex . ' did not develop sepsis. ';
            else $Sepsis .= $sex . ' was treated for ' . strtolower($SepsisValue) . ' sepsis. ';

            if (!empty($Sepsiss) && !empty($maxcrp))
            {

                $Sepsis .= $passsex . ' maximum CRP was ' . $maxcrp . ' mg/l. ';

            }

            if (!empty($Sepsiss) && !empty($minplatelete))
            {
                $Sepsis .= $passsex . ' minimum platelet count was ' . $minplatelete . ' cells. ';
            }

            if (!empty($Organismdaylife))
            {
                $Sepsis .= $sex . ' grew ' . $Organism . '  in blood culture on day ' . $Organismdaylife . '. ';
            }

            if (!empty($Meningitis)) $Sepsis .= $sex . ' was treated for meningitis. ';
            elseif (!empty($MeningitisIndicated)) $Sepsis .= ' There were no indications to perform a lumbar puncture. ';
            elseif (empty($Meningitis)) $Sepsis .= $sex . ' did not develop meningitis. ';

            if (!empty($viral_meningitis))
            {

                $Sepsis .= $sex . ' was treated for probable viral meningitis/encephalitis. ';

            }

            if (is_array($tmep_list_bio) && count($tmep_list_bio) > 0)
            {
                $Sepsis .= $sex . ' received the following antibiotics';
                $Sepsis .= '<table class="mtb-10"><tr><th> Antibiotics </th><th> Day Of Life </th></tr>';
                foreach ($tmep_list_bio as $value)
                {
                    if (!empty($value['Antibiotic']) && isset($masters_antibiotic[$value['Antibiotic']]))
                    {
                        $Sepsis .= '<tr><td>' . $masters_antibiotic[$value['Antibiotic']] . '</td><td>' . implode(',', array_unique($value['DayOfLife'])) . '</td></tr>';
                    }
                }
                $Sepsis .= '</table>';
            }

            if (is_array($daysofanitbiotic))
            {
                $daysofanitbiotic = array_unique($daysofanitbiotic);
                sort($daysofanitbiotic);

                $daysofanitbiotic = \SiteHelpers::calculate_serial_days($daysofanitbiotic, 1);

                foreach ($daysofanitbiotic as $keys => $value)
                {

                    if ($keys == 0)
                    {
                        $k = (is_array($value) && count($value) == 2) ? 1 : 0;
                        $Sepsis .= 'Antibiotic were stopped on day ' . $value[$k] . '. ';
                    }
                    elseif ($keys != 0 && count($value) == 2)
                    {
                        $Sepsis .= 'Antibiotic were restarted again on day ' . $value[0] . ' and stopped on day ' . $value[1] . '. ';
                    }
                    elseif ($keys != 0 && count($value) <> 0)
                    {
                        $Sepsis .= 'Antibiotic were restarted again on day ' . $value[0] . ' and stopped on day ' . $value[0] . '. ';

                    }

                }

            }

            $Sepsis .= (!empty($input['Sepsis'])) ? $input['Sepsis'] : '';

            $Ophthalmology = null;
            if (!empty($result->RopScreening) && $result->RopScreening == 'Not Indicated') $Ophthalmology .= 'An ROP assessment is not indicated. ';
            elseif (!empty($result->RopScreening) && $result->RopScreening == 'To be performed as outpatient') $Ophthalmology .= 'ROP screen to be done as an outpatient. ';
            elseif (!empty($result->RopScreening) && $result->RopScreening == 'Performed') $Ophthalmology .= $sex . ' underwent ROP screening and was found to have ' . $result->Rop . '. ';
            if (!empty($result->ROPTreatment) && $result->RopScreening == 'Performed' && $result->ROPTreatment == 'Yes')
            {
                $Ophthalmology .= $sex . 'underwent the following treatment for ROP';
                if (!empty($result->TypeofTreatmen) && is_array(json_decode($result->TypeofTreatmen)))
                {
                    $Ophthalmology .= '<br/> <ul>';
                    foreach (json_decode($result->TypeofTreatmen) as $value)
                    {
                        $Ophthalmology .= '<li>' . $value . '</li>';
                    }
                    $Ophthalmology .= '</ul>';
                }
            }
            elseif (!empty($result->ROPTreatment) && $result->RopScreening == 'Performed' && $result->ROPTreatment == 'No')
            {
                $Ophthalmology .= 'The baby did not require any treatment for ROP. ';
            }

            if (!empty($result->RopScreening) && $result->RopScreening == 'Performed' && $result->rop_follow_up == '1')
            {
                $Ophthalmology .= $sex . ' will not require follow up for ROP. ';
            }
            elseif (!empty($result->RopScreening) && $result->RopScreening == 'Performed' && $result->rop_follow_up == '2')
            {
                $Ophthalmology .= $sex . ' will be reviewed in ROP clinic. ';
            }

            $Ophthalmology .= (!empty($input['Ophthalmology'])) ? $input['Ophthalmology'] : '';

            $Hematology = null;

            if (empty($Transfusion)) $Hematology .= $sex . ' did not receive any blood products. ';
            else $Hematology .= $sex . ' received the following blood products transfusion as clinically indicated, ' . $F_Product . ' ';

            if (($GlucoseElectrolyte == 'No' && count($Hypoglycemia) == 0)) $Hematology .= $sex . ' did not have any episodes of significant hypo or hyperglycaemia/hypo or hypercalcemia/hypo or hypernatremia/hypo or hyperkalemia. ';

            $InsulinTherapytext = (!empty($InsulinTherapy)) ? $passsex . ' hyperglycemia was managed as per our unit guideline with insulin therapy. ' : '';

            if (!empty($maxTSB))
            {
                $getTSB = array();
                foreach ($TSB as $key => $value)
                {
                    if ($value == $maxTSB) $getTSB[] = $key;
                }
                $fetchTSB = (count($getTSB) != 0) ? implode(',', $getTSB) : '';
                $InsulinTherapytext .= $passsex . ' maximum serum bilirubin was ' . $maxTSB . '  mg/dl  on day ' . $fetchTSB . ' of life. ';
            }

            $Hematologytext = (!empty($result->DischargeTSB)) ? 'Discharge bilirubin was ' . $result->DischargeTSB . ' mg/dl. ' : '';
            $Hematologytext .= (!empty($input['Hematology'])) ? $input['Hematology'] : '';

            $NewbornScreening = '';
            if (!empty($result->NicuNewBornScreen) && ($result->NicuNewBornScreen == 'Not Sent')) $NewbornScreening = 'Newborn screening has not been sent. ';
            elseif (!empty($result->NicuNewBornScreen) && ($result->NicuNewBornScreen == 'Sent')) $NewbornScreening = 'Newborn screen result awaited. ';
            else $NewbornScreening = 'The result of the newborn screen is ' . strtolower($result->NicuNewBornScreen) . '. ';

            $NewbornScreening .= (!empty($input['NewbornScreening'])) ? $input['NewbornScreening'] : '';

            $Communicationwithparents = (!empty($input['Communicationwithparents'])) ? $input['Communicationwithparents'] : '';

            $Investigations = (!empty($input['Investigations'])) ? $input['Investigations'] : '';

            $DischargeInstructions = (!empty($input['DischargeInstructions'])) ? $input['DischargeInstructions'] : '';

            $Followup = (!empty($input['Followup'])) ? $input['Followup'] : '';

            foreach ($ICDs as $key => $value)
            {
                $get_problem[] = $ICD[$value];
            }
            if (count(json_decode($result->additional_diagnosis)) > 0)
            {
                $result->additional_diagnosis = json_decode($result->additional_diagnosis);
                foreach ($result->additional_diagnosis as $temp_diagnosis)
                {
                    $get_problem[] = $temp_diagnosis;
                }
            }
            $Problems_text = (!empty($input['Problems'])) ? $input['Problems'] : '';
            $MasIndication = Indication::getFieldvalue();
            $MasRespiratoryIndication = RespiratoryIndication::getFieldvalue();

            // $result->neonatal_consultant = \SiteHelpers::formating_consultant_signature($result->neonatal_consultant, false, $result->hospital_name, true);
            $result->neonatal_consultant = \ValuelistHelpers::signatureFormat($result->neonatal_consultant, 1);
            $result->Gestation = \SiteHelpers::decode_gestation($result->Gestation);
            $result->corrected_gestation = \SiteHelpers::decode_gestation($result->corrected_gestation);

            $temp_indication = json_decode($result->Indication);
            $temp_ind_count = count($temp_indication);
            $j = 0;

            $result->Indication = 'Indication : ';

            if (!empty($temp_indication) && count($temp_indication) > 0)
            {
                foreach ($temp_indication as $Indication_neo)
                {

                    $j++;
                    if (isset($MasIndication[$Indication_neo]))
                    {
                        if (($temp_ind_count - $j) == 1)
                        {
                            $result->Indication .= $MasIndication[$Indication_neo] . ' and ';
                        }
                        elseif (($temp_ind_count - $j) > 1)
                        {
                            $result->Indication .= $MasIndication[$Indication_neo] . ', ';
                        }
                        else
                        {
                            $result->Indication .= $MasIndication[$Indication_neo] . '. ';
                        }
                    }
                }
            }
            if (!empty(trim($Indication)))
            {

                $temp_resp = explode(',', $Indication);
                unset($Indication);
                $Indication = '';
                $temp_ind_count = count($temp_resp);
                $j = 0;
                foreach ($temp_resp as $Indication_neo)
                {
                    $j++;
                    if (($temp_ind_count - $j) == 1)
                    {
                        $Indication .= $MasRespiratoryIndication[$Indication_neo] . ' and ';
                    }
                    elseif (($temp_ind_count - $j) > 1)
                    {
                        $Indication .= $MasRespiratoryIndication[$Indication_neo] . ', ';
                    }
                    else
                    {
                        $Indication .= $MasRespiratoryIndication[$Indication_neo] . '. ';
                    }

                }
            }

        // $closewinlink=url('nicu-discharge-main-list');
            if ($summary_type == 'interim')
            {
                $closewinlink = url('nicu-discharge-main-list') . '/interim';
            }
            else
            {

                $closewinlink = url('nicu-discharge-main-list');
            }

            $dischargewinlink = action('Admission\NicuController@dischargeedit',\SiteHelpers::encrypt_id($results[0]->NicuId));
            // $abbrivated_summary = AbbreviatedSummaryLog::where(['baby_id' => $getbaby_details['0'], 'admission_id' => $getbaby_details['1']])->count();


            // if ($summary_type == 'interim') {
                // $editor_gen_option = count($dischargeSummarymodified) > 0 ? 1 : null;
                $interim_summary['baby_id'] = $getbaby_details[0];
                $interim_summary['admission_id'] = $getbaby_details[1];
                $interim_summary_status = DischargeSummary::where($interim_summary)->first();
                if (isset($interim_summary_status->interim_summary_content) && !is_null($interim_summary_status->interim_summary_content)  && $summary_type == 'interim') {
                    $editor_gen_option =  0;
                }
                elseif (isset($interim_summary_status->edited_content) && !is_null($interim_summary_status->edited_content)) {
                    $editor_gen_option =  0;
                }
                else{
                    $editor_gen_option = 1;
                }
            // } else {

            //     $editor_gen_option = $abbrivated_summary > 0 ? 0 : 1;
            // }
                
            $editor_gen = false;
            if (\Session::has('discharge-editor'))
            {
                \Session::forget('discharge-editor');
                $editor_gen = true;
                return view('reports.nicu-discharge.print', compact('result', 'closewinlink', 'intercostalDrain', 'chronicLung', 'NeedleThoracocentesis', 'navigate', 'InvasiveVentilation', 'InvasiveVentilationType', 'sex', 'NonInvasiveVentilationType', 'OtherRespiratorySupport', 'WithoutVentilation', 'InvasiveVentilationCount', 'NonInvasiveVentilationCount', 'OtherRespiratorySupportCount', 'maxFiO2', 'passsex', 'maxPIP', 'maxOI', 'Indication', 'CardiovascularSystem', 'GastrointestinalSystem', 'CentralNervousSystem', 'Sepsis', 'Ophthalmology', 'Hematology', 'Hypoglycemia', 'Hematologytext', 'InsulinTherapytext', 'NNJTreatments', 'NewbornScreening', 'Communicationwithparents', 'Investigations', 'discharge_medications', 'DischargeInstructions', 'ipnumber', 'Followup', 'Problems_text', 'get_problem', 'MasIndication', 'enc', 'dischargeSummarymodified', 'daycaresheetscount', 'medical_problems', 'medical_complications', 'ultrasoundfindings', 'proceduresSystem', 'RenalUltrasound', 'RenalUltrasoundkeys', 'UltrasoundAbdominalkeys', 'UltrasoundAbdominal', 'headerContent', 'vaccinelist', 'editor_gen', 'editor_gen_option', 'summary_type', 'dischargewinlink', 'current_admission_id'))->renderSections();
            }

            if (\Session::has('generate_doc'))
            {
                \Session::forget('generate_doc');
                $docs = true;
                $response = view('reports.nicu-discharge.print-docs', compact('result', 'closewinlink', 'navigate', 'intercostalDrain', 'chronicLung', 'InvasiveVentilation', 'NeedleThoracocentesis', 'InvasiveVentilationType', 'sex', 'NonInvasiveVentilationType', 'OtherRespiratorySupport', 'WithoutVentilation', 'InvasiveVentilationCount', 'NonInvasiveVentilationCount', 'OtherRespiratorySupportCount', 'maxFiO2', 'passsex', 'maxPIP', 'maxOI', 'Indication', 'CardiovascularSystem', 'GastrointestinalSystem', 'CentralNervousSystem', 'Sepsis', 'Ophthalmology', 'Hematology', 'Hypoglycemia', 'Hematologytext', 'InsulinTherapytext', 'NNJTreatments', 'NewbornScreening', 'Communicationwithparents', 'Investigations', 'discharge_medications', 'DischargeInstructions', 'ipnumber', 'Followup', 'Problems_text', 'get_problem', 'MasIndication', 'enc', 'dischargeSummarymodified', 'daycaresheetscount', 'medical_problems', 'medical_complications', 'ultrasoundfindings', 'proceduresSystem', 'RenalUltrasound', 'RenalUltrasoundkeys', 'UltrasoundAbdominalkeys', 'UltrasoundAbdominal', 'headerContent', 'vaccinelist', 'docs','summary_type', 'current_admission_id'))->renderSections() ['content'];
                $path = public_path() . "/NICU_Discharge_Summary";
                if (!file_exists($path))
                {
                    mkdir($path, 0777, true);
                }
                \PDF::loadHTML($response)->setOptions(['tempDir' => public_path() , 'chroot' => public_path() , ])
                ->save($path . '/NICU_Discharge_Summary.pdf');

                return $response;
            }

            if ($request->ajax())
            {
                $discharge_summary = view('reports.nicu-discharge.print', compact('result', 'closewinlink', 'navigate', 'intercostalDrain', 'chronicLung', 'InvasiveVentilation', 'NeedleThoracocentesis', 'InvasiveVentilationType', 'sex', 'NonInvasiveVentilationType', 'OtherRespiratorySupport', 'WithoutVentilation', 'InvasiveVentilationCount', 'NonInvasiveVentilationCount', 'OtherRespiratorySupportCount', 'maxFiO2', 'passsex', 'maxPIP', 'maxOI', 'Indication', 'CardiovascularSystem', 'GastrointestinalSystem', 'CentralNervousSystem', 'Sepsis', 'Ophthalmology', 'Hematology', 'Hypoglycemia', 'Hematologytext', 'InsulinTherapytext', 'NNJTreatments', 'NewbornScreening', 'Communicationwithparents', 'Investigations', 'discharge_medications', 'DischargeInstructions', 'ipnumber', 'Followup', 'Problems_text', 'get_problem', 'MasIndication', 'enc', 'dischargeSummarymodified', 'daycaresheetscount', 'medical_problems', 'medical_complications', 'ultrasoundfindings', 'proceduresSystem', 'RenalUltrasound', 'RenalUltrasoundkeys', 'UltrasoundAbdominalkeys', 'UltrasoundAbdominal', 'headerContent', 'vaccinelist', 'editor_gen_option', 'summary_type', 'generated', 'current_admission_id'))->render();
                return \Response::json(['discharge_summary' => $discharge_summary, 'babyName' => $result->BabyName . ' - ' . $result->BMrNo], 200);
            }

            if (isset($getbaby_details[2])) {
                $generated = true;
            }

            $old_print_sheet_count = NicuDaycareSummaryPrint::getPrintedContentCount($dischage_summary['baby_id'], $dischage_summary['admission_id']);

            return view('reports.nicu-discharge.print', compact('result', 'closewinlink', 'navigate', 'intercostalDrain', 'chronicLung', 'InvasiveVentilation', 'NeedleThoracocentesis', 'InvasiveVentilationType', 'sex', 'NonInvasiveVentilationType', 'OtherRespiratorySupport', 'WithoutVentilation', 'InvasiveVentilationCount', 'NonInvasiveVentilationCount', 'OtherRespiratorySupportCount', 'maxFiO2', 'passsex', 'maxPIP', 'maxOI', 'Indication', 'CardiovascularSystem', 'GastrointestinalSystem', 'CentralNervousSystem', 'Sepsis', 'Ophthalmology', 'Hematology', 'Hypoglycemia', 'Hematologytext', 'InsulinTherapytext', 'NNJTreatments', 'NewbornScreening', 'Communicationwithparents', 'Investigations', 'discharge_medications', 'DischargeInstructions', 'ipnumber', 'Followup', 'Problems_text', 'get_problem', 'MasIndication', 'enc', 'dischargeSummarymodified', 'daycaresheetscount', 'medical_problems', 'medical_complications', 'ultrasoundfindings', 'proceduresSystem', 'RenalUltrasound', 'RenalUltrasoundkeys', 'UltrasoundAbdominalkeys', 'UltrasoundAbdominal', 'headerContent', 'vaccinelist', 'editor_gen_option', 'summary_type', 'generated', 'old_print_sheet_count', 'dischargewinlink', 'current_admission_id'));
        }

    /**
     * DISPLAY THE FILTER FORM FOR PRINT REPORT
     *
     */
    public function filter()
    {
        $navigate['main_nav'] = 'NICU Admission';
        $navigate['sub_nav'] = 'nicu-discharge-summary';
        $SubmitButtonText = "Preview";
        $SaveButton = "Save";
        $baby = NicuDischarge::get_inpatient_baby_lists();
        $babies = array();
        $babies[] = 'Select from List';
        foreach ($baby as $data)
        {
            $babies[\SiteHelpers::encrypt_id($data->BabyId . '-' . $data->AdmissionId) ] = $data->BabyName . ' - ' . $data->BMrNo;
        }
        return view('reports.nicu-discharge.filter', compact('SubmitButtonText', 'SaveButton', 'navigate', 'babies'));
    }
    /**
     * STORE THE FILTER ADDITIONAL DEATAIL  & DISCHARGE REPORT
     *
     */

    public function store(Request $request)
    {
        $input = $request->all();
        
        $getbaby_details = explode('-', \SiteHelpers::decrypt_id($input['BabyId']));
        //set values for add values
        $get_data['admission_id'] = $input['admission_id'] = $getbaby_details[1];
        $get_data['baby_id'] = $input['baby_id'] = $getbaby_details[0];
        $get_data['flag'] = $input['flag'];
        //set values for changes
        $discharge_details = DischargeSummary::where($get_data)->first();
        $input['is_completed'] = (isset($input['is_completed']) && $input['is_completed'] == 'on') ? 2 : 1;
        $input['is_send'] = (isset($input['is_send']) && $input['is_send'] == 'on') ? 2 : 1;

        $input['newdiagnosis'] = isset($input['newdiagnosis']) ? $input['newdiagnosis'] : '';
        
        if (isset($input['newdiagnosis']) && !empty($input['newdiagnosis'])) {
            $newly_added_diagnosis = array();
            $diag = explode('++', $input['newdiagnosis']);
            if (count($diag) != 0) {
                foreach ($diag as $diag_key => $diag_value) {
                    if (trim($diag_value) != '') {
                        $serialize_array = explode('||', $diag_value);
                        if (count($serialize_array) > 0 && isset($serialize_array[0]) && isset($serialize_array[1]) ) {
                            $array_diag = array(
                                'dependency' => $serialize_array[0],
                                'add_diagnosis' => $serialize_array[1],
                            );
                            $newly_added_diagnosis[] = $array_diag;
                        }
                    }
                }
            }
            $input['newdiagnosis'] = serialize($newly_added_diagnosis);
        }

        if ($input['is_completed'] == 2 && $input['is_send'] == 2)
        {
            $this->generatePdf($input['BabyId'], $request, $input['summary_mail']);
        }
        if (count($discharge_details) > 0)
        {

            $input['DateModified'] = Carbon::now();
            $input['UserModified'] = \Auth::user()->id;
            $result = $discharge_details->update($input);

        }
        else
        {

            $result = DischargeSummary::create($input);

        }

        if ($request->ajax())
        {

            if ($result)
            {

                return \Response::json(['message' => 'Record saved', 'code' => 200], 200);

            }
            else
            {

                return \Response::json(['message' => 'Record not saved', 'code' => 201], 201);

            }

        }
        else
        {

            if ($result)
            {

                return redirect(action('Reports\NicuDischargeController@index', $input['BabyId']))->withInput(\Input::except('_token'))
                ->with('Success', 'Record saved successfully ');

            }
            else
            {

                return redirect(action('Reports\NicuDischargeController@index', $input['BabyId']))->withInput(\Input::except('_token'))
                ->with('error', 'Record not saved properly');
            }

        }

    }

    /**
     * DELET ADDITIONAL DEATAIL  & DISCHARGE REPORT
     *
     */

    public function destroy(Request $request)
    {
        $input = $request->all();
        $getbaby_details = explode('-', \SiteHelpers::decrypt_id($input['babyId']));
        $filterpage['baby_id'] = $getbaby_details[0];
        $filterpage['admission_id'] = $getbaby_details[1];
        $changeDefault = $filterpage;
        $changeDefault['flag'] = 2;
        $dischargesummary = DischargeSummary::where($changeDefault)->delete();

        if ($dischargesummary)
        {
            return \Response::json(['message' => "Record deleted successfully ", 'code' => 200], 200);
        }
        return \Response::json(['message' => 'Record not updated, Try after some time !', 'code' => 400], 400);

    }

    /**
     * DELET ADDITIONAL DEATAIL  & DISCHARGE REPORT
     *
     */

    public function getSavedefaulte(Request $request)
    {
        $input = $request->all();
        $getbaby_details = explode('-', \SiteHelpers::decrypt_id($input['babyId']));
        $get_data['baby_id'] = $input['baby_id'] = $getbaby_details[0];
        $get_data['admission_id'] = $input['admission_id'] = $getbaby_details[1];
        $get_data['flag'] = $input['flag'] = 3;
        foreach (json_decode($input['Reports']) as $value)
        {
            foreach ($value as $key => $index)
            {
                $input[$key] = $index;
            }
        }
        unset($input['babyId']);
        unset($input['Reports']);
        $Notes = DischargeSummary::where($get_data)->first();
        if (!count($Notes) > 0)
        {
            DischargeSummary::create($input);
        }
        else
        {
            $input['DateModified'] = Carbon::now();
            $input['UserModified'] = \Auth::user()->id;
            DischargeSummary::where($get_data)->update($input);
        }
        return \Response::json(['message' => 'Record saved', 'code' => 200], 200);

    }

    /**
     * OPEN DISCHARGE REPORT WITH FULL EDITOR
     *
     */

    public function getfullEditor(Request $request)
    {

        $input['dataUrl'] = $request->all();
        \Session::put('discharge-editor', true);
        return \Response::json(['dataUrl' => $input['dataUrl']], 200);

    }

    /**
     * OPEN DISCHARGE REPORT WITH FULL EDITOR
     *
     */
    public function saveFullEditor(Request $request, $summary_type = '')
    {

        // assign inputs to variable
        $input = $request->all();
        $baby_id = $input['baby_id'];
        $admission_id = $input['admission_id'];
        if ($summary_type == 'interim') {
            $summary_log['interim_summary_content'] = $input['discharge_summary'];
            $summary_log['admission_id'] = $admission_id;
            $summary_log['baby_id'] = $baby_id;
            $summary_log['interim_updated_at'] = Carbon::now($this->timezone);

            $check_summary = \DB::table('discharge_summary')->where(['baby_id' => $baby_id, 'admission_id'=> $admission_id])->first();
            
            if (count($check_summary) > 0) {
                \DB::table('discharge_summary')->where(['baby_id' => $baby_id, 'admission_id'=> $admission_id])->update($summary_log);
            }
            else
            {
                \DB::table('discharge_summary')->insert($summary_log);
            }

            $slug = $input['baby_id'] . '-' . $input['admission_id'];
            if ($request->ajax()) {
                return \Response::json(['type'=>'success','msg' => 'Record Updated Successfully']);
            } else {
                return redirect(action('Reports\NicuDischargeController@getAbbrivatedsummaryShow', [\SiteHelpers::encrypt_id($slug), 'interim']))->with('success', 'Record updated successfully');
            }
        }

        //get the baby details
        $baby = NicuDischarge::getBabyadmission($baby_id, $admission_id);

        $summary_log['edited_content'] = $input['discharge_summary'];
        $summary_log['edited_time'] = Carbon::now($this->timezone);

        $summary_update = DischargeSummary::where(['baby_id' => $baby_id, 'admission_id' => $admission_id])->Update($summary_log);

        // create slug for updated
        $slug = $input['baby_id'] . '-' . $input['admission_id'];

        $flag = 'success';
        $message = 'Record updated successfully';

        if ($request->ajax()) {
            return \Response::json(['type'=>'success','msg' => 'Record updated successfully']);
        } else {
            return redirect(action('Reports\NicuDischargeController@getAbbrivatedsummaryShow', \SiteHelpers::encrypt_id($slug)))->with($flag, $message);
        }
    }

    public function getAbbrivatedsummaryShow(Request $request, $id, $summary_type = '')
    {

        //decrypt the id
        $id_list = \SiteHelpers::decrypt_id($id);

        // splite the baby id and admission id
        $dischage_summary = explode('-', $id_list);

        $dischargeSummarymodified = array();

        // check  baby and adnmission ids
        if (isset($dischage_summary[0]) && !empty($dischage_summary[0]) && isset($dischage_summary[1]) && !empty($dischage_summary[1]))
        {

            $dischage_summary['baby_id'] = $baby_id = $dischage_summary[0];
            $dischage_summary['admission_id'] = $admission_id = $dischage_summary[1];

        }
        else
        {

            return redirect(url('/'))->with('error', 'Invalid record');

        }
        
        $summary_content = \DB::table('discharge_summary')->where('baby_id', $dischage_summary['baby_id'])->where('admission_id', $dischage_summary['admission_id'])->first();

        \Session::put('discharge-editor', true);
        $discharge_details = $this->index($id, $summary_type, $request);
        $interim = false;

        if (!empty($summary_content->edited_content)) {
            $discharge_details['content'] = $summary_content->edited_content;
            
        }        
        
        if (isset($summary_content->interim_summary_content) && !is_null($summary_content->interim_summary_content)) {
            if (($summary_type == 'interim' || $summary_type == 'interimiframe') && !empty($summary_content->interim_summary_content)) {
                $discharge_details['content'] = $summary_content->interim_summary_content;
            }
            $interim = true;
        }

        $editor_gen = false;
        \Session::forget('discharge-editor');
        return view('reports.nicu-discharge.editor', compact('discharge_details', 'dischargeSummarymodified', 'dischage_summary', 'summary_type', 'interim'));

    }
    /**
     * The advanced Search
     *
     *
     */
    public function DischargeSummarySearch(Request $request)
    {
        $input = $request->all();

        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'nicu_discharge';

        $list_details = array();

        $search_statement = '';
        $search_query = '';
        $baby_name = '';

        if (isset($input['advanced_search']))
        {
            for ($searchIndex = 0;$searchIndex < count($input['advanced_search']);$searchIndex++)
            {

                if (isset($input['advanced_search'][$searchIndex]) && isset($input['search_operator'][$searchIndex]))
                {

                    $temp_statement = $input['advanced_search'][$searchIndex];
                    if ($temp_statement[0] == '"' && $temp_statement[strlen($temp_statement) - 1] == '"')
                    {
                        $input['advanced_search'][$searchIndex] = str_replace(' ', '&', trim($input['advanced_search'][$searchIndex]));
                    }
                    else
                    {
                        $input['advanced_search'][$searchIndex] = str_replace(' ', '|', trim($input['advanced_search'][$searchIndex]));
                    }

                    $search_statement = $search_statement . $input['advanced_search'][$searchIndex] . '' . $this->operatorbuilder($input['search_operator'][$searchIndex]);
                    $search_query = $search_query . $input['advanced_search'][$searchIndex] . ' ' . $input['search_operator'][$searchIndex] . ' ';

                }
                elseif (isset($input['advanced_search'][$searchIndex]) && !isset($input['search_operator'][$searchIndex]))
                {

                    $temp_statement = $input['advanced_search'][$searchIndex];
                    if (isset($temp_statement[0]) && $temp_statement[0] == '"' && $temp_statement[strlen($temp_statement) - 1] == '"')
                    {
                        $input['advanced_search'][$searchIndex] = str_replace(' ', '&', trim($input['advanced_search'][$searchIndex]));
                    }
                    else
                    {
                        $input['advanced_search'][$searchIndex] = str_replace(' ', '|', trim($input['advanced_search'][$searchIndex]));

                    }

                    $search_statement = $search_statement . $input['advanced_search'][$searchIndex];
                    $search_query = $search_query . $input['advanced_search'][$searchIndex];

                }
            }
        }

        if (isset($search_statement) && strlen($search_statement) > 0)
        {

            $search_statement = ($search_statement[strlen($search_statement) - 1] == '&') ? substr($search_statement, 0, (strlen($search_statement) - 1)) : $search_statement;
            $search_statement = ($search_statement[strlen($search_statement) - 1] == '|') ? substr($search_statement, 0, (strlen($search_statement) - 1)) : $search_statement;
            $search_statement = ($search_statement[strlen($search_statement) - 1] == '!') ? substr($search_statement, 0, (strlen($search_statement) - 2)) : $search_statement;

        }

        $search_txt = (isset($search_statement) && $search_statement != '') ? $search_statement : '';
        $search_status = false;

        $page = !empty($request->input('page')) ? $request->input('page') : 1;

        if (isset($search_txt) && !empty($search_txt))
        {
            $limit = 10;

            $list_details = NicuDischarge::getadvancedsearch($page, $limit, $search_txt);
            $search_status = true;
        }

        if (count($list_details) > 0)
        {
            $baby_name = $list_details->first()->BabyName . ' - ' . $list_details->first()->BMrNo;
        }

        $search_txt = str_replace('"', '', $search_statement);

        $search_txt_temp = preg_replace('/[&,|,!]/', ' ', trim($search_txt));

        return view('search.nicusummary.search', compact('list_details', 'search_txt', 'search_status', 'baby_name', 'search_txt_temp', 'navigate', 'page'));

    }

    /**
     * This method to get
     * condition
     *
     */
    private function operatorbuilder($operator)
    {
        $operatorSet = ['AND' => '&', 'OR' => '|', 'NOT' => '&!'];

        return isset($operatorSet[$operator]) ? $operatorSet[$operator] : '';

    }

    public function generatePdf($id, Request $request, $mail_id)
    {
        #send mail starts
        \Session::put('generate_doc', true);
        $data = $this->index($id, '', $request);

        $id = \SiteHelpers::decrypt_id($id);
        $id = explode('-', $id);
        $baby = Baby::find($id['0']);

        \Mail::send("pdf.invoice", compact('baby') , function ($message) use ($baby, $mail_id)
        {
            $message->from('neopaed@raster.in');
            $message->subject('Discharge Summary Report ' . $baby->BabyName . ' - ' . $baby->BMrNo);
            $message->attach(public_path() . '/NICU_Discharge_Summary/NICU_Discharge_Summary.pdf');
            $message->to($mail_id);
        });

    }

    public function savePrintedContent(Request $request)
    {
        $input = $request->all();

        $baby_details = explode('-', \SiteHelpers::decrypt_id($input['baby_id']));
        
        $input['baby_id'] = $baby_details[0];
        $input['admission_id'] = $baby_details[1];
        $input['printed_date_time'] = Carbon::now();
        $input['printed_user_id'] = \Auth::user()->id;

        NicuDaycareSummaryPrint::insert($input);

        return \Response::json(['message'=>'Success', 'massage_type'=>'Success'], 200);

    }

    public function getPrintedContent(Request $request)
    {
        $input = $request->all();

        $baby_details = explode('-', \SiteHelpers::decrypt_id($input['baby_id']));
        
        $baby_id = $baby_details[0];
        $admission_id = $baby_details[1];
        $summary_approval = $this->auth->user()->summary_approval;
        $user_id = $this->auth->user()->id;

        $get_printed_content = NicuDaycareSummaryPrint::getPrintedContent($baby_id, $admission_id);

        return \Response::json(['get_printed_content'=>$get_printed_content, 'summary_approval'=>$summary_approval, 'user_id'=>$user_id]);

    }

    public function getPrintedHtmlContent(Request $request)
    {
        $input = $request->input('id');

        $results = NicuDaycareSummaryPrint::getPrintedHtmlContent($input);
        
        $get_printed_html_content = $results->summary_text;

        return \Response::json(['get_printed_html_content'=>$get_printed_html_content]);

    }

    public function summaryApproval(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];

        $old_results = NicuDaycareSummaryPrint::getPrintedHtmlContent($input);

        $html_content = $old_results['summary_text'];
        $old_approved_ids = $old_results['approved_user_ids'];

        $approved_by = $this->auth->user()->id;
        $signature = $this->auth->user()->signature;

        if (!empty($old_approved_ids) && !is_null($old_approved_ids)) {
            $approved_ids = $old_approved_ids . '||' . $approved_by;
        } else {
            $approved_ids = $approved_by;
        }

        $find_text = '<span class="signature-tag hide" id="doctor-' . $approved_by . '"></span>';
        $replace_text = '<span class="signature-tag" id="doctor-' . $approved_by . '"><img src="' . url('/') . '/public/img/users/' . $signature . '"></span>';

        $edited_content = str_replace($find_text, $replace_text, $html_content);

        $post['summary_text'] = $edited_content;
        $post['approved_user_ids'] = $approved_ids;
        $post['approved_date_time'] = Carbon::now($this->timezone);

        $results = NicuDaycareSummaryPrint::findorfail($id);
        $results->update($post);

        return \Response::json(['type'=>'success','msg' => 'Summary Approved Successfully']);

    }

}

