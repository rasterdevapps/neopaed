<?php
namespace App\Http\Controllers\Search;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\DrugIvFluidMaster;
use App\Models\Masters\ProcedureMaster;
use App\Models\Search\SearchPostnatal;
use App\Http\Controllers\Excel\ExportExcelController;
use App\Models\Masters\Vaccine;
use App\Models\Search\SearchQueryLog;
use Illuminate\Support\Str;
use App\Models\Masters\DoctorMaster;
use App\Models\Masters\Admissionmode as AdmissionmodeMaster;
use App\Models\Masters\AntibioticMaster;
use App\Models\Icd;

class PostnatalController extends Controller
{
    public function __construct(SearchPostnatal $search, ExportExcelController $export)
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
        $order['sortby'] = 'posdisid';
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
            $tempResults['count'] = $input['post_count'];
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
            return redirect(action('Search\PostnatalController@create').'?module='.$input['module'])->with('Success', 'No record found');
        }
        $post_ids = $tempResults->unique('posdisid')->pluck('posdisid')->toArray();
        if ($last) {
            $post_ids_count = count($post_ids)-1;
            $current_id = isset($post_ids[$post_ids_count]) ? $post_ids[$post_ids_count] : 0;

        } else {

            $current_id = isset($post_ids[0]) ? $post_ids[0] : 0;
        }
        $post_last = $this->setPrevnext($post_ids, $current_id, json_encode($post_ids) , $count, $query_log_id, $page, $very_first, $very_last);
        return redirect(action('Search\PostnatalController@searchview', \SiteHelpers::encrypt_id($current_id)) . '?post_ids=' . json_encode($post_ids) . '&post_count=' . $count . '&query_log_id=' . $query_log_id . '&page=' . $page . '&very_first=' . $very_first . '&very_last=' . $very_last.'&last='.$last.'&last_id='.$current_id.'&module='.$input['module']);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $navigate['main_nav'] = 'postnatal';
        $module = $request->get('module');

        $navigate['sub_nav'] = $module == 'admission' ? 'postnatal_proforma' : 'post_discharge';

        $timeList         =  \SiteHelpers::prepare_time();
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
            $procedure_master[$data->Id] = $data->Name;
        }
        $postntallist = array();
        $results = (object)[];

        $doctorsList = DoctorMaster::ListData()->pluck('Name', 'id')->toArray();
        $admissionmodeList = AdmissionmodeMaster::ListData();
        $antibioticList = AntibioticMaster::get_lists()->pluck('Name', 'Id')->toArray();
        $icdList = Icd::GetList()->pluck('icdcode', 'id')->toArray();

        $drungList        =   DrugIvFluidMaster::ListData()->where('status', 1)->pluck('brand_name', 'id')->toArray();
        $drungList1       =   DrugIvFluidMaster::all()->where('type', 'ORAL')->where('status', 1)->pluck('brand_name', 'id')->toArray();

        return view('search.postnatal.search', compact('navigate', 'timeList', 'drug_master', 'drug_value', 'results', 'procedure_master', 'postntallist', 'module', 'doctorsList', 'admissionmodeList', 'antibioticList', 'icdList', 'drungList', 'drungList1'));
    }

    public function searchview(Request $request, $id = 0)
    {
        $input = $request->all();
        $id = \SiteHelpers::decrypt_id($id);

        $navigate['main_nav'] = 'postnatal';
        $module = $input['module'];
        $navigate['sub_nav'] = $module == 'admission' ? 'postnatal_proforma' : 'post_discharge';
  
        $admission = \SiteHelpers::prepare_time();
        $results = array();
        $drugs = DrugIvFluidMaster::getOralDrug();
        $drug_master[0] = 'N/A';
        foreach ($drugs as $drug)
        {
            $drug_master[$drug
                ->Id] = $drug->Name;
        }

        $vaccine_master = Vaccine::get_lists()->pluck('Name', 'Id')->toArray();
        $time_list = \SiteHelpers::prepare_time();

        $results = $this->search->getData($id);
        $current_id = $id;
        if (!isset($input['post_ids']))
        {
            return redirect(action('Search\PostnatalController@create'));
        }
        $post_ids = json_decode($input['post_ids']);
        $count = isset($input['post_count']) ? $input['post_count'] : 0;

        $query_log_id = isset($input['query_log_id']) ? $input['query_log_id'] : 0;

        $current_page = isset($input['page']) ? $input['page'] : 1;

        $very_first = isset($input['very_first']) ? $input['very_first'] : null;

        $very_last = isset($input['very_last']) ? $input['very_last'] : null;

        $last_id = isset($input['last_id']) ? $input['last_id'] : null;

        $post_last = $this->setPrevnext($post_ids, $current_id, json_encode($post_ids) , $count, $query_log_id, $current_page, $very_first, $very_last);
        $tempResults = $this->search->getListbyPost($post_ids);
        if (count($results) > 0)
        {
            $results->DOB = !is_null($results->DOB) ? date('d-m-Y', strtotime($results->DOB)) : '';
            $results->admission_date = !is_null($results->admission_date) ? date('d-m-Y', strtotime($results->admission_date)) : '';
            $results->cg_weeks = isset($results->admission_cg) ? json_decode($results->admission_cg)->cg_weeks : '';
            $results->cg_days = isset($results->admission_cg) ? json_decode($results->admission_cg)->cg_days : '';
            $results->discharge_date = !is_null($results->discharge_date) ? date('d-m-Y', strtotime($results->discharge_date)) : '';
            $results->appoinment_date = !is_null($results->appoinment_date) ? date('d-m-Y', strtotime($results->appoinment_date)) : '';
            $postntallist = collect($tempResults)->toArray();
            $results->diedTime = strlen($results->diedTime) > 1 ? $results->diedTime : '0' . $results->diedTime;
            $results->diedMins = strlen($results->diedMins) > 1 ? $results->diedMins : '0' . $results->diedMins;
            $results->died_time = $results->diedTime . ':' . $results->diedMins . ':' . $results->diedAm;            
            $results->appoinment_hrs = strlen($results->appoinment_hrs) > 1 ? $results->appoinment_hrs : '0' . $results->appoinment_hrs;
            $results->appoinment_min = strlen($results->appoinment_min) > 1 ? $results->appoinment_min : '0' . $results->appoinment_min;
            $results->next_time_appoinment = $results->appoinment_hrs . ':' . $results->appoinment_min . ':' . $results->appoinment_session;
            $results->dcg_weeks = isset($results->cgd) ? json_decode($results->cgd)->dcg_weeks : '';
            $results->dcg_days = isset($results->cgd) ? json_decode($results->cgd)->dcg_days : '';
            $vaccine = (!empty($results->Vaccine)) ? json_decode($results->Vaccine) : [];
            $vaccine_date = (!empty($results->VaccineDate)) ? json_decode($results->VaccineDate) : [];
            $medications = $this->search->getMedication($results->BabyId, $results->AdmissionId)->toArray();
            $results->differentialdiagnosis = isset($results->differentialdiagnosis) ? json_decode($results->differentialdiagnosis) : [];
        }

        $procedure_master = ProcedureMaster::ListData()->pluck('Name', 'Id')->toArray();
        $timeList         =  \SiteHelpers::prepare_time();
        $doctorsList = DoctorMaster::ListData()->pluck('Name', 'id')->toArray();
        $admissionmodeList = AdmissionmodeMaster::ListData();
        $antibioticList = AntibioticMaster::get_lists()->pluck('Name', 'Id')->toArray();
        $icdList = Icd::GetList()->pluck('icdcode', 'id')->toArray();

        $drungList        =   DrugIvFluidMaster::ListData()->where('status', 1)->pluck('brand_name', 'id')->toArray();
        $drungList1       =   DrugIvFluidMaster::all()->where('type', 'ORAL')->where('status', 1)->pluck('brand_name', 'id')->toArray();

        return view('search.postnatal.search', compact('results', 'type_treatment', 'medications', 'antibiotic', 'additional_diagnosis', 'differential_diagnosis', 'doppler_scan', 'further_scan', 'anomaly_scan', 'dating_scan', 'time_list', 'icd_code', 'post_ids', 'doctor_master', 'neonatal_complication', 'pbm_data', 'tempResults', 'postntallist', 'post_last', 'SubmitButtonText', 'drug_master', 'vaccine_master', 'ICD', 'admission', 'admissionmode_master', 'medi_probs_master', 'complication_master', 'SavedhereText', 'navigate', 'vaccine', 'vaccine_date', 'procedure_master', 'count', 'query_log_id', 'current_page', 'very_first', 'very_last', 'last_id', 'timeList', 'module', 'doctorsList', 'admissionmodeList', 'antibioticList', 'icdList', 'drungList', 'drungList1'));
    }

    /**
     * This method get previous and next method
     *
     *@param $post_list type array of object
     *@param $current_id type integer
     *@return $postpages or 0
     */
    public function setPrevnext($post_list, $current_id, $post_ids, $count, $query_log_id, $current_page, $very_first, $very_last)
    {
        if (is_array($post_list) && !empty($current_id))
        {
            $key = array_search($current_id, $post_list);
            $prev = $key - 1;
            $next = $key + 1;
            $postpages[0] = (array_key_exists($prev, $post_list)) ? $post_list[$prev] : '';
            $postpages[1] = (array_key_exists($next, $post_list)) ? $post_list[$next] : '';

            $next_page = $current_page + 1;
            $prev_page = $current_page - 1;

            $one_page_last = false;

            if ($post_list[0] == $current_id) {
                $one_page_last = true;
            }

            $postpages[0] = !empty($postpages[0]) ? action('Search\PostnatalController@searchview', \SiteHelpers::encrypt_id($postpages[0]) . '?post_ids=' . $post_ids . '&post_count=' . $count.'&page='.$current_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last) : action('Search\PostnatalController@index', \SiteHelpers::encrypt_id($postpages[1]) . '&post_count=' . $count.'&page='.$prev_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last . '&one_page_last=' . $one_page_last);

            $postpages[1] = !empty($postpages[1]) ? action('Search\PostnatalController@searchview', \SiteHelpers::encrypt_id($postpages[1]) . '?post_ids=' . $post_ids . '&post_count=' . $count.'&page='.$current_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last) : action('Search\PostnatalController@index', \SiteHelpers::encrypt_id($postpages[1]) . '&post_count=' . $count.'&page='.$next_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last);

            return $postpages;
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
        $tempHeading = Config('exportfields.post');

        $last_query = SearchQueryLog::findOrfail($input['query_log_id']);

        $last_query['bindings'] = explode(',', $last_query['bindings']);

        $length = count($last_query['bindings']);
        $old_limit = 'limit ' . str_replace("'", "", $last_query['bindings'][$length - 2]);
        $old_offset = 'offset ' . str_replace("'", "", $last_query['bindings'][$length - 1]);

        $last_query['query'] = str_replace($old_limit, '', $last_query['query']);
        $last_query['query'] = str_replace($old_offset, '', $last_query['query']);

        $temp = Str::replaceArray('?', $last_query['bindings'], $last_query['query']);
        $results = \DB::select($temp);
        $postId = collect($results)->pluck('posdisid')->toArray();
        $results = $this->search->getPostSearchList($postId);
        $results = \SiteHelpers::convert_obj_to_array($results->toArray());
        $doctorsList = DoctorMaster::ListData()->pluck('Name', 'id')->toArray();
        $surgeon = \ValuelistHelpers::get_surgeons_lists();
        $admissionmodeList = AdmissionmodeMaster::ListData();
        foreach ($results as $result_key => $result_value)
        {
            $result = array();
            $dataList = array();
            $export_list = $request->input('post_export_list');
            $export_list = json_decode($export_list);
            krsort($export_list);
            $fields = $export_list;
            $medications = $this->search->getMedication($result_value['BabyId'], $result_value['AdmissionId']);
            $vaccine = \ValuelistHelpers::Vaccine();
            $procedure = ProcedureMaster::ListData()->pluck('Name', 'Id');

            foreach ($medications as $keys => $value)
            {
                $temp_medication = DrugIvFluidMaster::getDrugFluidName($value->Medication);

                $result['Medication'][$keys] = isset($temp_medication->brand_name) ? $temp_medication->brand_name : null;
                $result['genericname'][$keys] = isset($value->genericname) ? $value->genericname : null;
                $result['formulation'][$keys] = isset($value->formulation) ? $value->formulation : null;
                $result['Dose'][$keys] = isset($value->Dose) ? $value->Dose : null;
                $result['Frequency'][$keys] = isset($value->Frequency) ? $value->Frequency : null;
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
                    if (!isset($List[$record]))
                    {
                        if ($record == 'dcg_weeks')
                        {
                            $tempFields[$record] = (isset($List['cgd']) && isset(json_decode($List['cgd'])->dcg_weeks)) ? json_decode($List['cgd'])->dcg_weeks : null;
                        }
                        else if ($record == 'dcg_days')
                        {
                            $tempFields[$record] = (isset($List['cgd']) && isset(json_decode($List['cgd'])->dcg_days)) ? json_decode($List['cgd'])->dcg_days : null;
                        } 
                        else if ($record == 'cg_weeks')
                        {
                            $tempFields[$record] = (isset($List['admission_cg']) && isset(json_decode($List['admission_cg'])->cg_weeks)) ? json_decode($List['admission_cg'])->cg_weeks : null;
                        }
                        else if ($record == 'cg_days')
                        {
                            $tempFields[$record] = (isset($List['admission_cg']) && isset(json_decode($List['admission_cg'])->cg_days)) ? json_decode($List['admission_cg'])->cg_days : null;
                        } 
                        else if ($record == 'Vaccine' || $record == 'VaccineDate')
                        {
                            $temp_data = $List['vaccine'];
                            $temp_data = json_decode($temp_data);
                            $temp_array = [];
                            if (is_array($temp_data))
                            {
                                foreach ($temp_data as $temp_key => $temp_value)
                                {
                                    $temp_array['Vaccine'][$temp_key] = isset($vaccine[$temp_value->vaccine]) ? $vaccine[$temp_value->vaccine] : '';
                                    $temp_array['VaccineDate'][$temp_key] = strtotime($temp_value->vaccinedate) ? date('d-m-Y', strtotime($temp_value->vaccinedate)) : null;
                                }
                            }
                            $temp_json_vaccine = isset($temp_array['Vaccine']) ? json_encode($temp_array['Vaccine']) : [];
                            $temp_json_vaccine_date = isset($temp_array['VaccineDate']) ? json_encode($temp_array['VaccineDate']) : [];
                            $tempFields['Vaccine'] = $temp_json_vaccine;
                            $tempFields['VaccineDate'] = $temp_json_vaccine_date;
                        }
                        else if ($record == 'NextAppointment')
                        {
                            $tempFields[$record] = isset($List['appoinment_date']) ? date('d-m-Y', strtotime($List['appoinment_date'])) : null;
                        } 
                        else if ($record == 'next_time_appoinment')
                        {
                            $tempFields[$record] = (isset($List['appoinment_hrs']) && isset($List['appoinment_min']) && isset($List['appoinment_session'])) ? ($List['appoinment_hrs'] . ':' . $List['appoinment_min'] . ' ' . $List['appoinment_session']) : null;
                        } 
                        else if ($record == 'TypeofTreatmentemp')
                        {
                            $tempFields[$record] = isset($List['rop_treatment']) ? $List['rop_treatment'] : null;
                        }  
                        else if ($record == 'admission_time')
                        {
                            $tempFields[$record] = (isset($List['admission_time_hour']) && isset($List['admission_time_mins']) && isset($List['admission_time_session'])) ? ($List['admission_time_hour'] . ':' . $List['admission_time_mins'] . ' ' . $List['admission_time_session']) : null;
                        } 
                        else if ($record == 'pdiscussion')
                        {
                            $tempFields[$record] = (isset($List['pdiscussion_hrs']) && isset($List['pdiscussion_min']) && isset($List['pdiscussion_session'])) ? ($List['pdiscussion_hrs'] . ':' . $List['pdiscussion_min'] . ' ' . $List['pdiscussion_session']) : null;
                        } 
                        else 
                        {
                            $List[$record] = "";
                            $tempFields[$record] = $List[$record];
                        }
                    } 
                    else 
                    {
                        if ($record == 'procedures')
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
                        else if ($record == 'DOB' || $record == 'discharge_date' || $record == 'appoinment_date' || $record == 'admission_date')
                        {
                            $List[$record] = strtotime($List[$record]) ? date('d-m-Y', strtotime($List[$record])) : null;
                            $List[$record] = trim(strip_tags(preg_replace('/[\n\r\t]/', ' ', $List[$record])));
                            $tempFields[$record] = $List[$record];
                        }
                        else if ($record == 'diagnosis' || $record == 'additional_information' || $record == 'malinformation_details' || $record == 'cranial_ultrasound' || $record == 'echocardiography' || $record == 'advice' || $record == 'plan_follow_up')
                        {
                            $tempFields[$record] = trim(preg_replace('/\s\s+/', ' ', $List[$record]));
                        } 
                        else if ($record == 'appoinment_status' || $record == 'rop_follow_up' || $record == 'ventilation' || $record == 'uac_status' || $record == 'uvc_status' || $record == 'parents_spoken')
                        {
                            if ($List[$record] == 2) {
                                $tempFields[$record] = 'Yes';
                            } else if ($List[$record] == 1) {
                                $tempFields[$record] = 'No';
                            } else {
                                $tempFields[$record] = '';                                
                            }
                        }
                        else if ($record == 'surgeon')
                        {
                            $tempFields[$record] = $surgeon[$List[$record]];                                
                        }
                        else if ($record == 'seenby')
                        {
                            $tempFields[$record] = $doctorsList[$List[$record]];                                
                        }
                        else if ($record == 'mode')
                        {
                            $tempFields[$record] = $admissionmodeList[$List[$record]];                                
                        }
                        else if ($record == 'ivantibiotic')
                        {
                            $antibiotic_values = json_decode($List[$record]);
                            $antibiotic_list = AntibioticMaster::whereIn('Id', $antibiotic_values)->get()->pluck('Name')->toArray();
                            $tempFields[$record] = implode(',', $antibiotic_list);
                        }
                        else if ($record == 'differentialdiagnosis')
                        {
                            $temp = [];
                            foreach (json_decode($List[$record]) as $dkey => $dvalue) {
                                $temp[] = isset($icd[$dvalue]) ? $icd[$dvalue].'-'.$dvalue : $dvalue;
                            }
                            $tempFields[$record] = implode(',', $temp);
                        }
                        else 
                        {
                            $tempFields[$record] = $List[$record];                            
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

