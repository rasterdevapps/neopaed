<?php
namespace App\Http\Controllers\Search;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\DrugIvFluidMaster;
use App\Models\Masters\ProcedureMaster;
use App\Models\Search\SearchNicuadmission;
use App\Http\Controllers\Excel\ExportExcelController;
use App\Models\Masters\Vaccine;
use App\Models\Search\SearchQueryLog;
use Illuminate\Support\Str;
use App\Models\Masters\DoctorMaster;
use App\Models\Masters\MediprobsMaster as MediprobsMaster;
use App\Models\Masters\Complications as ComplicationMaster;
use App\Models\Masters\Admissionmode as AdmissionmodeMaster;
use App\Models\Masters\AntibioticMaster as AntibioticMaster;
use App\Models\Problems;
use App\Models\Complication;
use App\Models\Icd;
use App\Models\Usg;

class NicuController extends Controller
{
    public function __construct(SearchNicuadmission $search, ExportExcelController $export)
    {
        $this->search = $search;
        $this->export = $export;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id = 0)
    {
        $input = $request->all();
        $page = !empty($request->input('page')) ? $request->input('page') : 1;
        $limit = 10;
        $order['sortby'] = 'NicuId';
        $order['sortorder'] = 'desc';
        $last = false;
        if ($page == 1 && isset($input['query_log_id']) && empty($input['query_log_id']))
        {
            $tempResults = $this->search->getList($page, $limit, $input, $order);
        }
        else
        {
            $last_query = SearchQueryLog::findOrfail($input['query_log_id']);

            $last_query['bindings'] = explode(',', $last_query['bindings']);

            $length = count($last_query['bindings']);
            $old_limit = 'limit ' . str_replace("'", "", $last_query['bindings'][$length - 2]);
            $old_offset = 'offset ' . str_replace("'", "", $last_query['bindings'][$length - 1]);

            $current_offset = (empty($page) || $page == 1) ? 0 : (($page - 1) * $limit);

            $current_limit = 'limit ' . $limit;
            $current_offset = 'offset ' . $current_offset;

            $last_query['query'] = str_replace($old_limit, $current_limit, $last_query['query']);
            $last_query['query'] = str_replace($old_offset, $current_offset, $last_query['query']);

            $temp = Str::replaceArray('?', $last_query['bindings'], $last_query['query']);
            $tempResults['data'] = \DB::select($temp);
            $tempResults['count'] = $input['nicu_count'];
            $tempResults['query_log_id'] = $input['query_log_id'];
            $tempResults['very_first'] = $input['very_first'];
            $tempResults['very_last'] = $input['very_last'];
            $last = (isset($input['last']) && ($input['last'] == 1 || $input['last'])) ? 'true' : false;
            if (!$last) {
                $last = (isset($input['one_page_last']) && ($input['one_page_last'] == 1 || $input['one_page_last'])) ? 'true' : false;
            }
        }
        $tempResults['count'] = isset($tempResults['count']) ? $tempResults['count'] : 0;
        $tempResults['data'] = isset($tempResults['data']) ? $tempResults['data'] : [];
        $query_log_id = isset($tempResults['query_log_id']) ? $tempResults['query_log_id'] : 0;
        $very_first = isset($tempResults['very_first']) ? $tempResults['very_first'] : null;
        $very_last = isset($tempResults['very_last']) ? $tempResults['very_last'] : null;

        $count = $tempResults['count'];
        $tempResults = $tempResults['data'];
        $tempResults = collect($tempResults);
        $results = $tempResults->first();
        if ($tempResults->count() == 0)
        {
            return redirect(action('Search\NicuController@create').'?module='.$input['module'])->with('Success', 'No record found');
        }
        $nicu_ids = $tempResults->unique('NicuId')->pluck('NicuId')->toArray();

        if ($last) {
            $nicu_ids_count = count($nicu_ids)-1;
            $current_id = isset($nicu_ids[$nicu_ids_count]) ? $nicu_ids[$nicu_ids_count] : 0;
        } else {
            $current_id = isset($nicu_ids[0]) ? $nicu_ids[0] : 0;
        }

        $nicu_last = $this->setPrevnext($nicu_ids, $current_id, json_encode($nicu_ids), $count, $query_log_id, $page, $very_first, $very_last);

        return redirect(action('Search\NicuController@searchview', \SiteHelpers::encrypt_id($current_id)) . '?nicu_ids=' . json_encode($nicu_ids) . '&nicu_count=' . $count . '&query_log_id=' . $query_log_id  . '&page=' . $page . '&very_first=' . $very_first . '&very_last=' . $very_last.'&last='.$last.'&last_id='.$current_id.'&module='.$input['module']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $navigate['main_nav'] = 'nicu';
        $module = $request->get('module');
        $navigate['sub_nav'] = $module == 'admission' ? 'nicu_proforma' : 'discharge-list';

        $NAT['time'] = array();
        $NAT['time'][''] = 'N/A';
        for ($i = 1;$i <= 12;$i++)
        {
            $NAT['time'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
        }
        $NAT['mins'] = array();
        $NAT['mins'][''] = 'N/A';
        for ($i = 0;$i <= 59;$i++)
        {
            $NAT['mins'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
        }
        $drug_master            = DrugIvFluidMaster::getOralDrug()->pluck('Name', 'Id')->toArray();
        $procedure_temp = ProcedureMaster::ListData();
        $procedure_master[0] = 'N/A';
        foreach ($procedure_temp as $data)
        {
            $procedure_master[$data->Id] = $data->Name;
        }
        $nicuList = array();
        $results = (object)[];
        $doctor_master          = DoctorMaster::ListData()->pluck('Name', 'id')->toArray();
        $medi_probs_master      = MediprobsMaster::get_lists()->pluck('Name', 'Id')->toArray();
        $complication_master    = ComplicationMaster::get_lists()->pluck('Name', 'Id')->toArray();
        $admissionmode_master   = AdmissionmodeMaster::ListData();
        $antibiotic_master      = AntibioticMaster::get_lists()->pluck('Name', 'Id')->toArray();
        $GetICD                 = Icd::where('ICDCode', '<>', '')->get();

        $ICD = array();
        foreach ($GetICD as $key => $value) {
            $ICD[$value->ICDCode] = $value->ICDDescription . '-' . $value->ICDCode;
        }

        return view('search.nicu.search', compact('navigate', 'NAT', 'drug_master', 'drug_value', 'results', 'procedure_master', 'nicuList', 'doctor_master', 'medi_probs_master', 'complication_master', 'admissionmode_master', 'antibiotic_master', 'ICD', 'module'));
    }

    public function searchview(Request $request, $id = 0)
    {
        $input = $request->all();
        $id = \SiteHelpers::decrypt_id($id);
        $navigate['main_nav'] = 'nicu';
        $module = $input['module'];
        $navigate['sub_nav'] = $module == 'admission' ? 'nicu_proforma' : 'discharge-list';
        $navigate['sub_nav'] = 'nicu_proforma';
        $SubmitButtonText = 'Search';
        $SavedhereText = "Cancel";
        $admission = \SiteHelpers::prepare_time();
        $results = array();
        $drug_master            = DrugIvFluidMaster::getOralDrug()->pluck('Name', 'Id')->toArray();
        $vaccine_master = Vaccine::get_lists()->pluck('Name', 'Id')->toArray();
        $time_list = \SiteHelpers::prepare_time();

        $results = $this->search->getData($id);
        $current_id = $id;
        if (!isset($input['nicu_ids']))
        {
            return redirect(action('Search\NicuController@create'));
        }
        $nicu_ids = json_decode($input['nicu_ids']);
        $count = isset($input['nicu_count']) ? $input['nicu_count'] : 0;

        $query_log_id = isset($input['query_log_id']) ? $input['query_log_id'] : 0;

        $current_page = isset($input['page']) ? $input['page'] : 1;

        $very_first = isset($input['very_first']) ? $input['very_first'] : null;

        $very_last = isset($input['very_last']) ? $input['very_last'] : null;

        $last_id = isset($input['last_id']) ? $input['last_id'] : null;

        $nicu_last = $this->setPrevnext($nicu_ids, $current_id, json_encode($nicu_ids), $count, $query_log_id, $current_page, $very_first, $very_last);
        $tempResults = $this->search->getListbyNicu($nicu_ids);
        $nicuList = collect($tempResults)->toArray();

        if (count($results) > 0)
        {
            $results->DOB = !is_null($results->DOB) ? date('d-m-Y', strtotime($results->DOB)) : '';
            $results->DischargeDate = !is_null($results->DischargeDate) ? date('d-m-Y', strtotime($results->DischargeDate)) : '';
            $results->AdmissionDate = !is_null($results->AdmissionDate) ? date('d-m-Y', strtotime($results->AdmissionDate)) : '';
            $results->DateofAdministration = !is_null($results->DateofAdministration) ? date('d-m-Y', strtotime($results->DateofAdministration)) : '';
            $results->NextAppointment = !is_null($results->NextAppointment) ? date('d-m-Y', strtotime($results->NextAppointment)) : '';
            $results->diedTime = strlen($results->diedTime) > 1 ? $results->diedTime : '0' . $results->diedTime;
            $results->diedMins = strlen($results->diedMins) > 1 ? $results->diedMins : '0' . $results->diedMins;
            $results->died_time = $results->diedTime . ':' . $results->diedMins . ':' . $results->diedAm;
            $results->NAT_TIME = strlen($results->NAT_TIME) > 1 ? $results->NAT_TIME : '0' . $results->NAT_TIME;
            $results->NAT_MINS = strlen($results->NAT_MINS) > 1 ? $results->NAT_MINS : '0' . $results->NAT_MINS;
            $results->time_of_adminstration = $results->TimeOfAdministration . ':' . $results->TimeOfAdministration_MINS . ':' . $results->TimeOfAdministration_AM;
            $results->next_time_appoinment = $results->NAT_TIME . ':' . $results->NAT_MINS . ':' . $results->NAT_AM;
            $vaccine = !empty($results->Vaccine) ? json_decode($results->Vaccine) : [];
            $vaccine_date = (!empty($results->VaccineDate)) ? json_decode($results->VaccineDate) : [];
            $medications = $this->search->getMedication($results->BabyId, $results->AdmissionId)->toArray();

            if (isset($results->DiscussionTime)) {
               $temp_baby=explode(':', $results->DiscussionTime);
               if (count($temp_baby)>0) {
                $results->TimeOfDiscussion      = (int)$temp_baby[0];
                $results->TimeOfDiscussion_MINS = (int)$temp_baby[1];
                $results->TimeOfDiscussion_AM   = $temp_baby[2];
            }
        }
        $age_taken = explode(':', $results->AgeTaken);

        $results->age_hours = (isset($age_taken[0]) && !empty($age_taken[0])) ? $age_taken[0] : 0;
        $results->age_mins = (isset($age_taken[1]) && !empty($age_taken[1])) ? $age_taken[1] : 0;

    }
    $procedure_master = ProcedureMaster::ListData()->pluck('Name', 'Id')->toArray();
    $doctor_master          = DoctorMaster::ListData()->pluck('Name', 'id')->toArray();
    $medi_probs_master      = MediprobsMaster::get_lists()->pluck('Name', 'Id')->toArray();
    $complication_master    = ComplicationMaster::get_lists()->pluck('Name', 'Id')->toArray();
    $admissionmode_master   = AdmissionmodeMaster::ListData();
    $antibiotic_master      = AntibioticMaster::get_lists()->pluck('Name', 'Id')->toArray();
    $neonatal_complication  = Complication::where('BabyId', $results->BabyId)->whereIn('flags', [1, 2])->get(); 

    $GetICD                 = Icd::where('ICDCode', '<>', '')->get();

    $ICD = array();
    foreach ($GetICD as $key => $value) {
        $ICD[$value->ICDCode] = $value->ICDDescription . '-' . $value->ICDCode;
    }

    $pbm_data = Problems::where('BabyId', '=', $results->BabyId)->get();

    $datingScan  = Usg::where('BabyId', $results->BabyId)->where('type', 1)->whereIn('flags', [1, 2])->first();
    $analogScan  = Usg::where('BabyId', $results->BabyId)->where('type', 2)->whereIn('flags', [1, 2])->first();
    $otherScan   = Usg::where('BabyId', $results->BabyId)->where('type', 3)->whereIn('flags', [1, 2])->get()->toArray();
    $dopplerScan = Usg::where('BabyId', $results->BabyId)->where('type', 4)->whereIn('flags', [1, 2])->get()->toArray();
    $results->IVAntibiotic =(!empty($results->IVAntibiotic))?json_decode($results->IVAntibiotic)  : [];
    $results->DifferentialDiagnosis =(!empty($results->DifferentialDiagnosis))?json_decode($results->DifferentialDiagnosis)  : [];
    $results->admission_time = date('h:i:A', strtotime($results->admission_time_hr . ':' . $results->AdmissionTime_MINS . ' ' .  $results->AdmissionTime_AM));
    $results->discussion_time = isset($results->DiscussionTime) ? $results->DiscussionTime : '';
    $CorrectedGestation = json_decode($results->CorrectedGestation);
    $results->cg_weeks = isset($CorrectedGestation->cg_weeks) ? $CorrectedGestation->cg_weeks : '';
    $results->cg_days = isset($CorrectedGestation->cg_days) ? $CorrectedGestation->cg_days : '';

    $NAT['time'] = array();
    $NAT['time'][''] = 'N/A';
    for ($i = 1;$i <= 12;$i++)
    {
        $NAT['time'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
    }
    $NAT['mins'] = array();
    $NAT['mins'][''] = 'N/A';
    for ($i = 0;$i <= 59;$i++)
    {
        $NAT['mins'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
    }

    return view('search.nicu.search', compact('results', 'type_treatment', 'medications', 'antibiotic', 'additional_diagnosis', 'differential_diagnosis', 'dopplerScan', 'otherScan', 'analogScan', 'datingScan', 'time_list', 'icd_code', 'nicu_ids', 'doctor_master', 'neonatal_complication', 'pbm_data', 'tempResults', 'nicuList', 'nicu_last', 'SubmitButtonText', 'drug_master', 'vaccine_master', 'ICD', 'admission', 'admissionmode_master', 'medi_probs_master', 'complication_master', 'SavedhereText', 'navigate', 'vaccine', 'vaccine_date', 'procedure_master', 'count', 'query_log_id', 'current_page', 'very_first', 'very_last', 'last_id', 'antibiotic_master', 'module', 'drug_value', 'NAT'));
}

    /**
     * This method get previous and next method
     *
     *@param $nicu_list type array of object
     *@param $current_id type integer
     *@return $nicupages or 0
     */
    public function setPrevnext($nicu_list, $current_id, $nicu_ids, $count, $query_log_id, $current_page, $very_first, $very_last)
    {
        if (is_array($nicu_list) && !empty($current_id))
        {
            $key = array_search($current_id, $nicu_list);
            $prev = $key - 1;
            $next = $key + 1;
            $nicupages[0] = (array_key_exists($prev, $nicu_list)) ? $nicu_list[$prev] : '';
            $nicupages[1] = (array_key_exists($next, $nicu_list)) ? $nicu_list[$next] : '';

            $next_page = $current_page + 1;
            $prev_page = $current_page - 1;

            $one_page_last = false;

            if ($nicu_list[0] == $current_id) {
                $one_page_last = true;
            }

            $nicupages[0] = !empty($nicupages[0]) ? action('Search\NicuController@searchview', \SiteHelpers::encrypt_id($nicupages[0]) . '?nicu_ids=' . $nicu_ids . '&nicu_count=' . $count.'&page='.$current_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last) : action('Search\NicuController@index', \SiteHelpers::encrypt_id($nicupages[1]) . '&nicu_count=' . $count.'&page='.$prev_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last . '&one_page_last=' . $one_page_last);
            
            $nicupages[1] = !empty($nicupages[1]) ? action('Search\NicuController@searchview', \SiteHelpers::encrypt_id($nicupages[1]) . '?nicu_ids=' . $nicu_ids . '&nicu_count=' . $count.'&page='.$current_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last) : action('Search\NicuController@index', \SiteHelpers::encrypt_id($nicupages[1]) . '&nicu_count=' . $count.'&page='.$next_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last);

            return $nicupages;
        }
        return 0;
    }

    /**
     * This method to export
     *
     */
    public function download(Request $request)
    {
        $input = $request->all();
        // $nicuId = json_decode($input['nicu_id']);
        $tempHeading = Config('exportfields.nicu');

        $last_query = SearchQueryLog::findOrfail($input['query_log_id']);

        $last_query['bindings'] = explode(',', $last_query['bindings']);

        $length = count($last_query['bindings']);
        $old_limit = 'limit ' . str_replace("'", "", $last_query['bindings'][$length - 2]);
        $old_offset = 'offset ' . str_replace("'", "", $last_query['bindings'][$length - 1]);

        $last_query['query'] = str_replace($old_limit, '', $last_query['query']);
        $last_query['query'] = str_replace($old_offset, '', $last_query['query']);

        $temp = Str::replaceArray('?', $last_query['bindings'], $last_query['query']);
        $results = \DB::select($temp);

        $nicuId = collect($results)->pluck('NicuId')->toArray();
        $results = $this->search->getNicuSearchList($nicuId);
        $doctor_master          = DoctorMaster::ListData()->pluck('Name', 'id')->toArray();

        $vaccine = \ValuelistHelpers::Vaccine();
        $procedure = ProcedureMaster::ListData()->pluck('Name', 'Id');
        
        $icd = Icd::where('ICDCode', '<>', '')->get()->pluck('ICDDescription', 'ICDCode');
        $vaccine_master = Vaccine::get_lists()->pluck('Name', 'Id')->toArray();

        $results = \SiteHelpers::convert_obj_to_array($results->toArray());
        foreach ($results as $result_key => $result_value)
        {
            $result = array();
            $dataList = array();

            $export_list = $request->input('nicu_export_list');
            $export_list = json_decode($export_list);
            krsort($export_list);
            $fields = $export_list;
            $medications = $this->search->getMedication($result_value['BabyId'], $result_value['AdmissionId']);
            foreach ($medications as $keys => $value)
            {
                $temp_medication = DrugIvFluidMaster::getDrugFluidName($value->Medication);
                $result['Medication'][$keys] = isset($temp_medication->brand_name) ? $temp_medication->brand_name : null;
                $result['genericname'][$keys] = isset($value->genericname) ? $value->genericname : null;
                $result['formulation'][$keys] = isset($temp_medication->formulation) ? $temp_medication->formulation : null;
                $result['Dose'][$keys] = isset($value->Dose) ? $value->Dose : null;
                $result['Frequency'][$keys] = isset($value->Frequency) ? $value->Frequency : null;
                $result['Duration'][$keys] = isset($value->Duration) ? $value->Duration : null;
                $result['additional_instruction'][$keys] = isset($value->additional_instruction) ? $value->additional_instruction : null;
            }

            if (count($result) > 0)
            {
                $results[$result_key]['M_Drugs'] = implode(',', $result['Medication']);
                $results[$result_key]['m_generic_name'] = implode(',', $result['genericname']);
                $results[$result_key]['formulation'] = implode(',', $result['formulation']);
                $results[$result_key]['M_Dose'] = implode(',', $result['Dose']);
                $results[$result_key]['M_Frequency'] = implode(',', $result['Frequency']);
                $results[$result_key]['M_Duration'] = implode(',', $result['Duration']);
                $results[$result_key]['additional_instruction'] = implode(',', $result['additional_instruction']);
            }
            $pbm_data = \DB::table('medical_problems')->leftjoin('mas_medical_problems', 'medical_problems.Problem', 'mas_medical_problems.Id')->where('BabyId', '=', $result_value['BabyId'])->orderBy('medical_problems.Id', 'asc')->get();

            $Medication = $pbm_data->pluck('Medication')->toArray();
            $Problem = $pbm_data->pluck('Name')->toArray();
            
            $results[$result_key]['Medications'] = implode(',', $Medication);
            $results[$result_key]['Problems'] = implode(',', $Problem);

            $complication_data = \DB::table('complications')->leftjoin('mas_complication', 'complications.Complication', 'mas_complication.Id')->where('BabyId', '=', $result_value['BabyId'])->orderBy('complications.Id', 'asc')->get();

            $Treatment = $complication_data->pluck('Treatment')->toArray();
            $Complication = $complication_data->pluck('Name')->toArray();

            $results[$result_key]['Complication'] = implode(',', $Complication);
            $results[$result_key]['Treatments'] = implode(',', $Treatment);

            $datingScan  = Usg::where('BabyId', $result_value['BabyId'])->where('type', 1)->whereIn('flags', [1, 2])->first();

            $results[$result_key]['datingdate'] = isset($datingScan->date) ? date('d-m-Y', strtotime($datingScan->date)) : null;
            $results[$result_key]['datinggestations'] = isset($datingScan->Gestation) ? $datingScan->Gestation : null;
            $results[$result_key]['datingfindings'] = isset($datingScan->Finding) ? $datingScan->Finding : null;

            $analogScan  = Usg::where('BabyId', $result_value['BabyId'])->where('type', 2)->whereIn('flags', [1, 2])->first();

            $results[$result_key]['analogdate'] = isset($analogScan->date) ? date('d-m-Y', strtotime($datingScan->date)) : null;
            $results[$result_key]['analoggestations'] = isset($analogScan->Gestation) ? $analogScan->Gestation : null;
            $results[$result_key]['analogfindings'] = isset($analogScan->Finding) ? $analogScan->Finding : null;

            $otherScan   = Usg::where('BabyId', $result_value['BabyId'])->where('type', 3)->whereIn('flags', [1, 2])->get();
            $otherScanGestation   = $otherScan->pluck('Gestation')->toArray();
            $otherScanFinding   = $otherScan->pluck('Finding')->toArray();
            $otherScanDate   = $otherScan->pluck('date')->toArray();

            $scantemp = [];
            foreach ($otherScanDate as $value) {
                $scantemp[] = date('d-m-Y', strtotime($value));
            }
            $results[$result_key]['otherdate'] = implode(',', $scantemp);
            $results[$result_key]['othergestations'] = implode(',', $otherScanGestation);
            $results[$result_key]['otherfindings'] = implode(',', $otherScanFinding);

            $dopplerScan = Usg::where('BabyId', $result_value['BabyId'])->where('type', 4)->whereIn('flags', [1, 2])->get();

            $dopplerScanGestation   = $dopplerScan->pluck('Gestation')->toArray();
            $dopplerScanFinding   = $dopplerScan->pluck('Finding')->toArray();
            $dopplerScanDate   = $dopplerScan->pluck('date')->toArray();

            $dopplerscantemp = [];
            foreach ($dopplerScanDate as $value) {
                $dopplerscantemp[] = date('d-m-Y', strtotime($value));
            }
            $results[$result_key]['dopplerdate'] = implode(',', $dopplerscantemp);
            $results[$result_key]['dopplergestations'] = implode(',', $dopplerScanGestation);
            $results[$result_key]['dopplerfindings'] = implode(',', $dopplerScanFinding);

            foreach ($results as $List)
            {
                $tempFields = array();
                foreach ($fields as $record)
                {
                    if (isset($List[$record])) {
                        if ($record != 'Vaccine' && $record != 'VaccineDate' && $record != 'procedures' && $record != 'DOB' && $record != 'AdmissionDate' && $record != 'DischargeDate' && $record != 'NextAppointment' && $record != 'DateofAdministration' && $record != 'SeenBy' && $record != 'cg_weeks' && $record != 'cg_days' && $record != 'AdmissionTime' && $record != 'Mode' && $record != 'IVAntibiotic' && $record != 'DifferentialDiagnosis' && $record != 'Plan' && $record != 'rop_follow_up' && $record != 'Surgeon')
                        {
                            $tempFields[$record] = $List[$record];
                        }
                        else if ($record == 'Vaccine')
                        {
                            $temp_data = $List[$record];
                            $temp_data = json_decode($temp_data);
                            if (empty($temp_data)) {
                                $temp_data = unserialize($List[$record]);
                            }
                            $temp_array = [];
                            if (is_array($temp_data))
                            {
                                foreach ($temp_data as $temp_key => $temp_value)
                                {
                                    $temp_array[$temp_key] = isset($vaccine[$temp_value]) ? $vaccine[$temp_value] : '';
                                }
                            }
                            $temp_json = json_encode($temp_array);
                            $tempFields[$record] = $temp_json;
                        }
                        else if ($record == 'VaccineDate')
                        {
                            $temp_data = $List[$record];
                            $temp_data = json_decode($temp_data);
                            if (empty($temp_data)) {
                                $temp_data = unserialize($List[$record]);
                            }
                            $temp_array = [];
                            if (is_array($temp_data))
                            {
                                foreach ($temp_data as $temp_key => $temp_value)
                                {
                                    $temp_array[$temp_key] = strtotime($temp_value) ? date('d-m-Y', strtotime($temp_value)) : '';
                                }
                            }
                            $temp_json = json_encode($temp_array);
                            $tempFields[$record] = $temp_json;
                        }
                        else if ($record == 'procedures')
                        {
                            $temp_data = $List[$record];
                            $temp_data = json_decode($temp_data);
                            $temp_array = [];
                            if (is_array($temp_data))
                            {
                                foreach ($temp_data as $temp_key => $temp_value)
                                {
                                    $temp_array[$temp_key] = isset($procedure[$temp_value]) ? $procedure[$temp_value] : '';
                                }
                            }
                            $temp_json = json_encode($temp_array);
                            $tempFields[$record] = $temp_json;
                        }
                        else if ($record == 'DOB' || $record == 'AdmissionDate' || $record == 'DischargeDate' || $record == 'NextAppointment' || $record == 'DateofAdministration')
                        {
                            $List[$record] = strtotime($List[$record]) ? date('d-m-Y', strtotime($List[$record])) : null;
                            $List[$record] = trim(strip_tags(preg_replace('/[\n\r\t]/', ' ', $List[$record])));
                            $tempFields[$record] = $List[$record];
                        }
                        else if ($record == 'Surgeon')
                        {
                            $tempFields[$record] = isset($doctor_master[$List[$record]]) ? $doctor_master[$List[$record]] : null;
                        }
                        else if ($record == 'SeenBy')
                        {
                            $temp_doctor = json_decode($List[$record]);
                            $doctors = [];
                            if (is_array($temp_doctor)) {
                                foreach ($temp_doctor as $value) {
                                    $doctors[] = isset($doctor_master[$value]) ? $doctor_master[$value] : null;
                                }
                            }
                            $tempFields[$record] = implode(',', $doctors);
                        }
                        else if ($record == 'SeenBy')
                        {
                            $temp_doctor = json_decode($List[$record]);
                            $doctors = [];
                            if (is_array($temp_doctor)) {
                                foreach ($temp_doctor as $value) {
                                    $doctors[] = isset($doctor_master[$List[$record]]) ? $doctor_master[$List[$record]] : null;
                                }
                            }
                            $tempFields[$record] = implode(',', $doctors);
                        }
                        else if ($record == 'AdmissionTime')
                        {
                            $tempFields[$record] = isset($List['admission_time']) ? $List['admission_time'] : null;
                        }
                        else if ($record == 'Mode')
                        {
                            if ($List[$record] != '' && $List[$record] != 'undefined') {
                                $temp = AdmissionmodeMaster::where('Id', $List[$record])->first();
                            }
                            $tempFields[$record] = isset($temp->Mode_name) ? $temp->Mode_name : null;
                        }
                        else if ($record == 'IVAntibiotic')
                        {
                            $antibiotic_values = json_decode($List[$record]);
                            $antibiotics = [];
                            if (is_array($antibiotic_values)) {
                                $iv_antibiotic = array_filter($antibiotic_values);
                                if (count($iv_antibiotic) > 0) {
                                    $temp_iv = json_decode($result_value['IVAntibiotic']);
                                    if (is_array($temp_iv))
                                    foreach ($temp_iv as $keys => $antibiotic) {
                                        if ($antibiotic != '') {
                                            $antibiotics[$keys] = !is_null(DrugIvFluidMaster::getDrugName($antibiotic)) ? DrugIvFluidMaster::getDrugName($antibiotic)->generic_pharmacological_name : '';
                                        }
                                    }
                                }
                                $tempFields[$record] = implode(',', $antibiotics);
                            }
                        }
                        else if ($record == 'DifferentialDiagnosis')
                        {
                            $temp = [];
                            $diagnosis_data = json_decode($List[$record]);
                            if (is_array($diagnosis_data)) {
                                foreach ($diagnosis_data as $dkey => $dvalue) {
                                    $temp[] = isset($icd[$dvalue]) ? $icd[$dvalue].'-'.$dvalue : $dvalue;
                                }
                            }
                            $tempFields[$record] = implode(',', $temp);
                        }
                        else if ($record == 'Plan')
                        {
                            $tempFields[$record] = trim(preg_replace('/\s\s+/', ' ', $List[$record]));
                        }
                        else if ($record == 'rop_follow_up')
                        {
                            if ($List[$record] == 2) {
                                $tempFields[$record] = 'Yes';
                            } else if ($List[$record] == 1) {
                                $tempFields[$record] = 'No';
                            } else {
                                $tempFields[$record] = '';                                
                            }
                        }
                    } else {
                        if ($record == 'cg_weeks')
                        {
                            $tempFields[$record] = (isset($List['CorrectedGestation']) && isset(json_decode($List['CorrectedGestation'])->cg_weeks)) ? json_decode($List['CorrectedGestation'])->cg_weeks : null;
                        }
                        else if ($record == 'cg_days')
                        {
                            $tempFields[$record] = (isset($List['CorrectedGestation']) && isset(json_decode($List['CorrectedGestation'])->cg_days)) ? json_decode($List['CorrectedGestation'])->cg_days : null;
                        } else {
                            $tempFields[$record] = null;
                        }
                    }
                }
                $dataList[] = $tempFields;
            }
            $headingList = array();
            foreach ($fields as $fieldsValue)
            {
                $headingList[] = $tempHeading[$fieldsValue];
            }
            $this->export->setFilename($input['file_name']);
            $this->export->setFileformat($input['file_format']);
            return $this->export->exportFile($dataList, $headingList);
        }
    }

}

