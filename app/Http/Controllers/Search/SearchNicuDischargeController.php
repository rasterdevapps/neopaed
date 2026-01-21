<?php
namespace App\Http\Controllers\Search;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\DrugIvFluidMaster;
use App\Models\Masters\ProcedureMaster;
use App\Models\Search\SearchNicuDischarge;
use App\Http\Controllers\Excel\ExportExcelController;
use App\Models\Masters\Vaccine;
use App\Models\Search\SearchQueryLog;
use Illuminate\Support\Str;

class SearchNicuDischargeController extends Controller
{
    public function __construct(SearchNicuDischarge $search, ExportExcelController $export)
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
            $tempResults = $this
                ->search
                ->getList($page, $limit, $input, $order);
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
            return redirect(action('Search\SearchNicuDischargeController@create'))
                ->with('Success', 'No record found');
        }
        $nicu_ids = $tempResults->unique('NicuId')
            ->pluck('NicuId')
            ->toArray();
            if ($last) {
                $nicu_ids_count = count($nicu_ids)-1;
        $current_id = isset($nicu_ids[$nicu_ids_count]) ? $nicu_ids[$nicu_ids_count] : 0;

            } else {

        $current_id = isset($nicu_ids[0]) ? $nicu_ids[0] : 0;
            }

        $nicu_last = $this->setPrevnext($nicu_ids, $current_id, json_encode($nicu_ids), $count, $query_log_id, $page, $very_first, $very_last);

        return redirect(action('Search\SearchNicuDischargeController@searchview', \SiteHelpers::encrypt_id($current_id)) . '?nicu_ids=' . json_encode($nicu_ids) . '&nicu_count=' . $count . '&query_log_id=' . $query_log_id  . '&page=' . $page . '&very_first=' . $very_first . '&very_last=' . $very_last.'&last='.$last.'&last_id='.$current_id);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'nicu_proforma';
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
        $drugs = DrugIvFluidMaster::getOralDrug();
        $drug_master[0] = 'N/A';
        foreach ($drugs as $drug)
        {
            $drug_master[$drug
                ->Id] = $drug->Name;
        }
        $drug_value[0] = 'N/A';
        foreach ($drugs as $drugvalue)
        {
            $drug_value[$drug
                ->Id] = $drug->Value;
        }
        $procedure_temp = ProcedureMaster::ListData();
        $procedure_master[0] = 'N/A';
        foreach ($procedure_temp as $data)
        {
            $procedure_master[$data
                ->Id] = $data->Name;
        }
        $niculist = array();
        $results = (object)[];

        return view('search.nicudischarge.search', compact('navigate', 'NAT', 'drug_master', 'drug_value', 'results', 'procedure_master', 'niculist'));
    }
    public function searchview(Request $request, $id = 0)
    {
        $input = $request->all();
        $id = \SiteHelpers::decrypt_id($id);
        // All the masters are going here
        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'nicu_proforma';
        $SubmitButtonText = 'Search';
        $SavedhereText = "Cancel";
        $admission = \SiteHelpers::prepare_time();
        $results = array();
        $drugs = DrugIvFluidMaster::getOralDrug();
        $drug_master[0] = 'N/A';
        foreach ($drugs as $drug)
        {
            $drug_master[$drug
                ->Id] = $drug->Name;
        }
        $vaccine_master = Vaccine::get_lists()->pluck('Name', 'Id')
            ->toArray();
        $time_list = \SiteHelpers::prepare_time();
        
        $results = $this
            ->search
            ->getData($id);
        $current_id = $id;
        if (!isset($input['nicu_ids']))
        {
            return redirect(action('Search\SearchNicuDischargeController@create'));
        }
        $nicu_ids = json_decode($input['nicu_ids']);
        $count = isset($input['nicu_count']) ? $input['nicu_count'] : 0;

        $query_log_id = isset($input['query_log_id']) ? $input['query_log_id'] : 0;

        $current_page = isset($input['page']) ? $input['page'] : 1;

        $very_first = isset($input['very_first']) ? $input['very_first'] : null;

        $very_last = isset($input['very_last']) ? $input['very_last'] : null;

        $last_id = isset($input['last_id']) ? $input['last_id'] : null;

        $nicu_last = $this->setPrevnext($nicu_ids, $current_id, json_encode($nicu_ids), $count, $query_log_id, $current_page, $very_first, $very_last);
        $tempResults = $this
            ->search
            ->getListbyNicu($nicu_ids);
        $nicuList = collect($tempResults)->toArray();

        if (count($results) > 0)
        {
            $results->DOB = !is_null($results->DOB) ? date('d-m-Y', strtotime($results->DOB)) : '';
            $results->DischargeDate = !is_null($results->DischargeDate) ? date('d-m-Y', strtotime($results->DischargeDate)) : '';
            $results->AdmissionDate = !is_null($results->AdmissionDate) ? date('d-m-Y', strtotime($results->AdmissionDate)) : '';
            $results->NextAppointment = !is_null($results->NextAppointment) ? date('d-m-Y', strtotime($results->NextAppointment)) : '';
            $results->diedTime = strlen($results->diedTime) > 1 ? $results->diedTime : '0' . $results->diedTime;
            $results->diedMins = strlen($results->diedMins) > 1 ? $results->diedMins : '0' . $results->diedMins;
            $results->died_time = $results->diedTime . ':' . $results->diedMins . ':' . $results->diedAm;
            $results->NAT_TIME = strlen($results->NAT_TIME) > 1 ? $results->NAT_TIME : '0' . $results->NAT_TIME;
            $results->NAT_MINS = strlen($results->NAT_MINS) > 1 ? $results->NAT_MINS : '0' . $results->NAT_MINS;
            $results->next_time_appoinment = $results->NAT_TIME . ':' . $results->NAT_MINS . ':' . $results->NAT_AM;
            $results->dcg_weeks = isset($results->corrected_gestation) ? json_decode($results->corrected_gestation)->dcg_weeks : 0;
            $results->dcg_days = isset($results->corrected_gestation) ? json_decode($results->corrected_gestation)->dcg_days : 0;
            $vaccine = (!empty($results->Vaccine)) ? json_decode($results->Vaccine) : array(
                "0" => ""
            );
            $vaccine_date = (!empty($results->VaccineDate)) ? json_decode($results->VaccineDate) : array(
                "0" => ""
            );
            $medications = $this
                ->search
                ->getMedication($results->BabyId, $results->AdmissionId)
                ->toArray();
        }
        $procedure_master = ProcedureMaster::ListData()->pluck('Name', 'Id')
            ->toArray();

        return view('search.nicudischarge.search', compact('results', 'type_treatment', 'medications', 'antibiotic', 'additional_diagnosis', 'differential_diagnosis', 'doppler_scan', 'further_scan', 'anomaly_scan', 'dating_scan', 'time_list', 'icd_code', 'nicu_ids', 'doctor_master', 'neonatal_complication', 'pbm_data', 'tempResults', 'nicuList', 'nicu_last', 'SubmitButtonText', 'drug_master', 'vaccine_master', 'ICD', 'admission', 'admissionmode_master', 'medi_probs_master', 'complication_master', 'SavedhereText', 'navigate', 'vaccine', 'vaccine_date', 'procedure_master', 'count', 'query_log_id', 'current_page', 'very_first', 'very_last', 'last_id'));
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

            $nicupages[0] = !empty($nicupages[0]) ? action('Search\SearchNicuDischargeController@searchview', \SiteHelpers::encrypt_id($nicupages[0]) . '?nicu_ids=' . $nicu_ids . '&nicu_count=' . $count.'&page='.$current_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last) : action('Search\SearchNicuDischargeController@index', \SiteHelpers::encrypt_id($nicupages[1]) . '&nicu_count=' . $count.'&page='.$prev_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last . '&one_page_last=' . $one_page_last);
            
    	    $nicupages[1] = !empty($nicupages[1]) ? action('Search\SearchNicuDischargeController@searchview', \SiteHelpers::encrypt_id($nicupages[1]) . '?nicu_ids=' . $nicu_ids . '&nicu_count=' . $count.'&page='.$current_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last) : action('Search\SearchNicuDischargeController@index', \SiteHelpers::encrypt_id($nicupages[1]) . '&nicu_count=' . $count.'&page='.$next_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last);
              
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
        $tempHeading = Config('exportfields.nicu_discharge');

        $last_query = SearchQueryLog::findOrfail($input['query_log_id']);

        $last_query['bindings'] = explode(',', $last_query['bindings']);

        $length = count($last_query['bindings']);
        $old_limit = 'limit ' . str_replace("'", "", $last_query['bindings'][$length - 2]);
        $old_offset = 'offset ' . str_replace("'", "", $last_query['bindings'][$length - 1]);

        $last_query['query'] = str_replace($old_limit, '', $last_query['query']);
        $last_query['query'] = str_replace($old_offset, '', $last_query['query']);

        $temp = Str::replaceArray('?', $last_query['bindings'], $last_query['query']);
        $results = \DB::select($temp);
        $nicuId = collect($results)->pluck('NicuId')
            ->toArray();
        $results = $this
            ->search
            ->getNicuSearchList($nicuId);
        $results = \SiteHelpers::convert_obj_to_array($results->toArray());
        foreach ($results as $result_key => $result_value)
        {
            $result = array();
            $dataList = array();

            $export_list = $request->input('nicu_export_list');
            $export_list = json_decode($export_list);
            krsort($export_list);
            $fields = $export_list;
            $medications = $this
                ->search
                ->getMedication($result_value['BabyId'], $result_value['AdmissionId']);
            $frequency = \ValuelistHelpers::drugFrequencyList();
            $vaccine = \ValuelistHelpers::Vaccine();
            $procedure = ProcedureMaster::ListData()->pluck('Name', 'Id');

            foreach ($medications as $keys => $value)
            {
                $temp_medication = DrugIvFluidMaster::getDrugFluidName($value->Medication);
                $result['Medication'][$keys] = isset($temp_medication->brand_name) ? $temp_medication->brand_name : null;
                $result['genericname'][$keys] = isset($value->genericname) ? $value->genericname : null;
                $result['formulation'][$keys] = isset($value->formulation) ? $value->formulation : null;
                $result['Dose'][$keys] = isset($value->Dose) ? $value->Dose : null;
                $result['Frequency'][$keys] = (isset($value->Frequency) && isset($frequency[$value->Frequency])) ? $frequency[$value->Frequency] : null;
                $result['Duration'][$keys] = isset($value->Duration) ? $value->Duration : null;
            }

            if (count($result) > 0)
            {
                $results[$result_key]['M_Drugs'] = implode(',', $result['Medication']);
                $results[$result_key]['m_generic_name'] = implode(',', $result['genericname']);
                $results[$result_key]['formulation'] = implode(',', $result['formulation']);
                $results[$result_key]['M_Dose'] = implode(',', $result['Dose']);
                $results[$result_key]['M_Frequency'] = implode(',', $result['Frequency']);
                $results[$result_key]['M_Duration'] = implode(',', $result['Duration']);
            }

            foreach ($results as $List)
            {
                $tempFields = array();
                foreach ($fields as $record)
                {
                    if (!isset($List[$record]) && !in_array($record, Config('exportfields.nicuFieldmodifier.differentType')) && $record != 'Vaccine' && $record != 'VaccineDate' && $record != 'procedures')
                    {
                        $List[$record] = "";
                        $tempFields[$record] = $List[$record];
                    }
                    else if (isset($List[$record]) && $record == 'Vaccine')
                    {
                        $temp_data = $List[$record];
                        $temp_data = json_decode($temp_data);
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
                    else if (isset($List[$record]) && $record == 'VaccineDate')
                    {
                        $temp_data = $List[$record];
                        $temp_data = json_decode($temp_data);
                        $temp_array = [];
                        if (is_array($temp_data))
                        {
                            foreach ($temp_data as $temp_key => $temp_value)
                            {
                                $temp_array[$temp_key] = strtotime($List[$record]) ? date('d-m-Y', strtotime($List[$record])) : '';
                            }
                        }
                        $temp_json = json_encode($temp_array);
                        $tempFields[$record] = $temp_json;
                    }
                    else if (isset($List[$record]) && $record == 'procedures')
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
                    else if (isset($List[$record]) && $record != 'Vaccine' && $record != 'VaccineDate' && $record != 'procedures')
                    {
                        if ($record == 'DOB' || $record == 'DischargeDate' || $record == 'NextAppointment')
                        {
                            $List[$record] = strtotime($List[$record]) ? date('d-m-Y', strtotime($List[$record])) : null;
                        }
                        $List[$record] = trim(strip_tags(preg_replace('/[\n\r\t]/', ' ', $List[$record])));
                        $tempFields[$record] = $List[$record];
                    }
                }
                $dataList[] = $tempFields;
            }
            $headingList = array();
            foreach ($fields as $fieldsValue)
            {
                $headingList[] = $tempHeading[$fieldsValue];
            }
            $this
                ->export
                ->setFilename($input['file_name']);
            $this
                ->export
                ->setFileformat($input['file_format']);
            return $this
                ->export
                ->exportFile($dataList, $headingList);
        }
    }

}

