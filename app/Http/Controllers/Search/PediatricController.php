<?php
namespace App\Http\Controllers\Search;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\Drug;
use App\Models\Masters\ProcedureMaster;
use App\Models\Search\Pediatric;
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

class PediatricController extends Controller
{
    public function __construct(Pediatric $search, ExportExcelController $export)
    {
        $this->search = $search;
        $this->export = $export;
        $this->yes_or_no = ['0'=>'N/A','1' => "Yes","2"=>"No"];

        $this->eye_opening_options = [1=>'1 - No eye opening',2=>'2 - Eyes open to pain (not applied to face)',3=>'3 - Eyes open to verbal command, speech or shout',4=>'4 - Eyes open spontaneously'];
        $this->verbal_options = [1=>'1 - No verbal response',2=>'2 - Incomprehensible sounds or speech',3=>'3 - Inappropriate responses, words discernible',4=>'4 - Confused conversation, but able to answer questions',5=>'5 - Oriented'];
        $this->motor_options = [1=>'1 - No motor response',2=>'2 - Extensor (rigid) response, decerebrate posture',3=>'3 - Abnormal (spastic) flexion, decorticate posture',4=>'4 - Withdraws from pain',5=>'5 - Purposeful movement to painful stimulus',6=>'6 - Obeys commands for movement'];
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
        $order['sortby'] = 'id';
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
            $tempResults['count'] = $input['pediatric_count'];
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
            return redirect(action('Search\PediatricController@create').'?module='.$input['module'])->with('Success', 'No record found');
        }
        $pediatric_ids = $tempResults->unique('id')->pluck('id')->toArray();

        if ($last) {
            $pediatric_ids_count = count($pediatric_ids)-1;
            $current_id = isset($pediatric_ids[$pediatric_ids_count]) ? $pediatric_ids[$pediatric_ids_count] : 0;
        } else {
            $current_id = isset($pediatric_ids[0]) ? $pediatric_ids[0] : 0;
        }

        $pediatric_last = $this->setPrevnext($pediatric_ids, $current_id, json_encode($pediatric_ids), $count, $query_log_id, $page, $very_first, $very_last);

        return redirect(action('Search\PediatricController@searchview', \SiteHelpers::encrypt_id($current_id)) . '?pediatric_ids=' . json_encode($pediatric_ids) . '&pediatric_count=' . $count . '&query_log_id=' . $query_log_id  . '&page=' . $page . '&very_first=' . $very_first . '&very_last=' . $very_last.'&last='.$last.'&last_id='.$current_id.'&module='.$input['module']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $navigate['main_nav'] = 'pediatric';
        $module = $request->get('module');
        $navigate['sub_nav'] = $module == 'admission' ? 'pediatric_admission' : 'pediatric_discharge';

        $admission = \SiteHelpers::prepare_time();
        $pediatricList = array();
        $results = (object)[];

        $yes_or_no = $this->yes_or_no;

        return view('search.pediatric.search', compact('navigate', 'admission', 'pediatricList', 'results', 'yes_or_no', 'module'));
    }

    public function searchview(Request $request, $id = 0)
    {
        $input = $request->all();
        $id = \SiteHelpers::decrypt_id($id);
        $navigate['main_nav'] = 'pediatric';
        $module = $input['module'];
        $navigate['sub_nav'] = $module == 'admission' ? 'pediatric_admission' : 'pediatric_discharge';
        $admission = \SiteHelpers::prepare_time();
        
        $results = array();
        $results = $this->search->getData($id);
        $current_id = $id;
        if (!isset($input['pediatric_ids']))
        {
            return redirect(action('Search\PediatricController@create'));
        }
        $pediatric_ids = json_decode($input['pediatric_ids']);
        $count = isset($input['pediatric_count']) ? $input['pediatric_count'] : 0;

        $query_log_id = isset($input['query_log_id']) ? $input['query_log_id'] : 0;

        $current_page = isset($input['page']) ? $input['page'] : 1;

        $very_first = isset($input['very_first']) ? $input['very_first'] : null;

        $very_last = isset($input['very_last']) ? $input['very_last'] : null;

        $last_id = isset($input['last_id']) ? $input['last_id'] : null;

        $pediatric_last = $this->setPrevnext($pediatric_ids, $current_id, json_encode($pediatric_ids), $count, $query_log_id, $current_page, $very_first, $very_last);
        $tempResults = $this->search->getListbyPediatric($pediatric_ids);

        $pediatricList = collect($tempResults)->toArray();

        $baby_detail = (object)[];

        if (count($results) > 0) {
            $results->DOB = !is_null($results->DOB) ? date('d-m-Y', strtotime($results->DOB)) : '';
            $results->admission_date = !is_null($results->admission_date) ? date('d-m-Y', strtotime($results->admission_date)) : '';
            $results->status_date = !is_null($results->status_date) ? date('d-m-Y', strtotime($results->status_date)) : '';
            $results->investigations = json_decode($results->investigations);
            $results->pediatric_consultant = json_decode($results->pediatric_consultant);

            $results->eye_opening = !empty($results->eye_opening) ? $this->eye_opening_options[$results->eye_opening] : null;
            $results->verbal = !empty($results->verbal) ? $this->verbal_options[$results->verbal] : null;
            $results->motor = !empty($results->motor) ? $this->motor_options[$results->motor] : null;
            $results->complaints = html_entity_decode($results->complaints);

            $results->complaints = strip_tags($results->complaints);
            $results->hopi = strip_tags($results->hopi);
            $results->treatment_history = strip_tags($results->treatment_history);
            $results->past_history = strip_tags($results->past_history);
            $results->perinatal_history = strip_tags($results->perinatal_history);
            $results->immunization = strip_tags($results->immunization);
            $results->development = strip_tags($results->development);
            $results->family_history = strip_tags($results->family_history);
            $results->general_examination = strip_tags($results->general_examination);
            $results->vitals_content = strip_tags($results->vitals_content);
            $results->anthropometry_content = strip_tags($results->anthropometry_content);
            $results->cvs_findings = strip_tags($results->cvs_findings);
            $results->rs_findings = strip_tags($results->rs_findings);
            $results->ms_findings = strip_tags($results->ms_findings);
            $results->deep_tendon_findings = strip_tags($results->deep_tendon_findings);
            $results->cns_findings = strip_tags($results->cns_findings);
            $results->abdomen_findings = strip_tags($results->abdomen_findings);
            $results->investigations_test = strip_tags($results->investigations_test);
            $results->treatment = strip_tags($results->treatment);
            $results->working_diagnosis = strip_tags($results->working_diagnosis);
            $results->discussion_findings = strip_tags($results->discussion_findings);
            $results->treatment_findings = strip_tags($results->treatment_findings);
            $results->condition_at_discharge = strip_tags($results->condition_at_discharge);
            $results->review_details = strip_tags($results->review_details);
            $results->discharge_findings = strip_tags($results->discharge_findings);
        }

        $yes_or_no = $this->yes_or_no;

        return view('search.pediatric.search', compact('results', 'type_treatment', 'medications', 'antibiotic', 'additional_diagnosis', 'differential_diagnosis', 'dopplerScan', 'otherScan', 'analogScan', 'datingScan', 'time_list', 'icd_code', 'pediatric_ids', 'doctor_master', 'neonatal_complication', 'pbm_data', 'tempResults', 'pediatricList', 'pediatric_last', 'SubmitButtonText', 'drug_master', 'vaccine_master', 'ICD', 'admission', 'admissionmode_master', 'medi_probs_master', 'complication_master', 'SavedhereText', 'navigate', 'vaccine', 'vaccine_date', 'procedure_master', 'count', 'query_log_id', 'current_page', 'very_first', 'very_last', 'last_id', 'antibiotic_master', 'drug_value', 'yes_or_no', 'baby_detail', 'module'));
    }

    /**
     * This method get previous and next method
     *
     *@param $pediatric_list type array of object
     *@param $current_id type integer
     *@return $pediatricpages or 0
     */
    public function setPrevnext($pediatric_list, $current_id, $pediatric_ids, $count, $query_log_id, $current_page, $very_first, $very_last)
    {
        if (is_array($pediatric_list) && !empty($current_id))
        {
            $key = array_search($current_id, $pediatric_list);
            $prev = $key - 1;
            $next = $key + 1;
            $pediatricpages[0] = (array_key_exists($prev, $pediatric_list)) ? $pediatric_list[$prev] : '';
            $pediatricpages[1] = (array_key_exists($next, $pediatric_list)) ? $pediatric_list[$next] : '';

            $next_page = $current_page + 1;
            $prev_page = $current_page - 1;

            $one_page_last = false;

            if ($pediatric_list[0] == $current_id) {
                $one_page_last = true;
            }

            $pediatricpages[0] = !empty($pediatricpages[0]) ? action('Search\PediatricController@searchview', \SiteHelpers::encrypt_id($pediatricpages[0]) . '?pediatric_ids=' . $pediatric_ids . '&pediatric_count=' . $count.'&page='.$current_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last) : action('Search\PediatricController@index', \SiteHelpers::encrypt_id($pediatricpages[1]) . '&pediatric_count=' . $count.'&page='.$prev_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last . '&one_page_last=' . $one_page_last);
            
            $pediatricpages[1] = !empty($pediatricpages[1]) ? action('Search\PediatricController@searchview', \SiteHelpers::encrypt_id($pediatricpages[1]) . '?pediatric_ids=' . $pediatric_ids . '&pediatric_count=' . $count.'&page='.$current_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last) : action('Search\PediatricController@index', \SiteHelpers::encrypt_id($pediatricpages[1]) . '&pediatric_count=' . $count.'&page='.$next_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last);

            return $pediatricpages;
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

        $tempHeading = Config('exportfields.pediatric');

        $last_query = SearchQueryLog::findOrfail($input['query_log_id']);

        $last_query['bindings'] = explode(',', $last_query['bindings']);

        $length = count($last_query['bindings']);
        $old_limit = 'limit ' . str_replace("'", "", $last_query['bindings'][$length - 2]);
        $old_offset = 'offset ' . str_replace("'", "", $last_query['bindings'][$length - 1]);

        $last_query['query'] = str_replace($old_limit, '', $last_query['query']);
        $last_query['query'] = str_replace($old_offset, '', $last_query['query']);

        $temp = Str::replaceArray('?', $last_query['bindings'], $last_query['query']);
        $results = \DB::select($temp);

        $id = collect($results)->pluck('id')->toArray();
        $results = $this->search->getPediatricSearchList($id);
        $results = \SiteHelpers::convert_obj_to_array($results->toArray());

        $mas_surgeons = \ValuelistHelpers::get_surgeons_lists();
        $mas_doctors = \ValuelistHelpers::mas_doctors_list();
        $mas_investigation = \ValuelistHelpers::get_package_investigations_master();

        foreach ($results as $result_key => $result_value)
        {
            $result = array();
            $dataList = array();

            $export_list = $request->input('pediatric_export_list');
            $export_list = json_decode($export_list);
            krsort($export_list);
            $fields = $export_list;

            foreach ($results as $List)
            {
                $tempFields = array();
                foreach ($fields as $record)
                {
                    if (isset($List[$record])) {
                        if ($record == 'DOB' || $record == 'admission_date' || $record == 'status_date')
                        {
                            $List[$record] = strtotime($List[$record]) ? date('d-m-Y', strtotime($List[$record])) : null;
                            $List[$record] = trim(strip_tags(preg_replace('/[\n\r\t]/', ' ', $List[$record])));
                            $tempFields[$record] = $List[$record];
                        }
                        else if ($record == 'surgeon')
                        {
                            $tempFields[$record] = isset($mas_surgeons[$List[$record]]) ? $mas_surgeons[$List[$record]] : null;
                        }
                        else if ($record == 'pediatric_consultant')
                        {
                            $consultant_values = json_decode($List[$record]);
                            $temp = [];
                            foreach ($consultant_values as $value) {
                                $temp[] = isset($mas_doctors[$value]) ? $mas_doctors[$value] : null;
                            }

                            $tempFields[$record] = implode(',', $temp);
                        }
                        else if ($record == 'registrar')
                        {
                            $registrar_values = json_decode($List[$record]);
                            $temp = [];
                            foreach ($registrar_values as $value) {
                                $temp[] = isset($mas_doctors[$value]) ? $mas_doctors[$value] : null;
                            }

                            $tempFields[$record] = implode(',', $temp);
                        }
                        else if ($record == 'seen_by')
                        {
                            $tempFields[$record] = isset($mas_doctors[$List[$record]]) ? $mas_doctors[$List[$record]] : null;
                        } 
                        else if ($record == 'complaints' || $record == 'hopi' || $record == 'treatment_history' || $record == 'past_history' || $record == 'perinatal_history' || $record == 'immunization' || $record == 'development' || $record == 'family_history' || $record == 'general_examination' || $record == 'vitals_content' || $record == 'anthropometry_content' || $record == 'cvs_findings' || $record == 'rs_findings' || $record == 'ms_findings' || $record == 'deep_tendon_findings' || $record == 'cns_findings' || $record == 'abdomen_findings' || $record == 'investigations_test' || $record == 'treatment' || $record == 'working_diagnosis' || $record == 'discussion_findings' || $record == 'treatment_findings' || $record == 'investigation_findings' || $record == 'condition_at_discharge' || $record == 'review_details' || $record == 'discharge_findings') 
                        {
                            $tempFields[$record] = strip_tags($List[$record]);
                        }
                        else if ($record == 'stage')
                        {
                            if ($List[$record] == 1) {
                                $tempFields[$record] = 'Alert';
                            } else if ($List[$record] == 2) {
                                $tempFields[$record] = 'Awake';
                            } else {
                                $tempFields[$record] = null;             
                            }
                        } 
                        else if ($record == 'gpallor' || $record == 'ihm' || $record == 'cyanosis' || $record == 'clubby' || $record == 'glymphadenopathy' || $record == 'pedal_edema' || $record == 'cn_meningeal_signs')
                        {
                            if ($List[$record] == 1) {
                                $tempFields[$record] = 'Yes';
                            } else if ($List[$record] == 2) {
                                $tempFields[$record] = 'No';
                            } else {
                                $tempFields[$record] = null;                               
                            }
                        } 
                        else if ($record == 'eye_opening')
                        {
                            $tempFields[$record] = !empty($List[$record]) ? $this->eye_opening_options[$List[$record]] : null;
                        } 
                        else if ($record == 'verbal')
                        {
                            $tempFields[$record] = !empty($List[$record]) ? $this->verbal_options[$List[$record]] : null;
                        } 
                        else if ($record == 'motor')
                        {
                            $tempFields[$record] = !empty($List[$record]) ? $this->motor_options[$List[$record]] : null;
                        } 
                        else if ($record == 'cn_exam' || $record == 'ms_exam' || $record == 'deep_tendon' || $record == 'external_genitalia')
                        {
                            if ($List[$record] == 1) {
                                $tempFields[$record] = 'Normal';
                            } else if ($List[$record] == 2) {
                                $tempFields[$record] = 'Abnormal';
                            } else {
                                $tempFields[$record] = null;                               
                            }
                        } 
                        else if ($record == 'abdomen_status')
                        {
                            if ($List[$record] == 1) {
                                $tempFields[$record] = 'Distended';
                            } else if ($List[$record] == 2) {
                                $tempFields[$record] = 'Not Distended';
                            } else {
                                $tempFields[$record] = null;                               
                            }
                        } 
                        else if ($record == 'skin_over_abdomen')
                        {
                            if ($List[$record] == 1) {
                                $tempFields[$record] = 'Normal';
                            } else if ($List[$record] == 2) {
                                $tempFields[$record] = 'Visible Gastric Pinstalims';
                            } else if ($List[$record] == 3) {
                                $tempFields[$record] = 'Umbilicus - Normal';
                            } else {
                                $tempFields[$record] = null;                               
                            }
                        } 
                        else if ($record == 'liver' || $record == 'spleen')
                        {
                            if ($List[$record] == 1) {
                                $tempFields[$record] = 'Palpable';
                            } else if ($List[$record] == 2) {
                                $tempFields[$record] = 'Non-Palpable';
                            } else {
                                $tempFields[$record] = null;                               
                            }
                        } 
                        else if ($record == 'admission_entered_by')
                        {
                            $tempFields[$record] = isset($mas_doctors[$List[$record]]) ? $mas_doctors[$List[$record]] : null;
                        } 
                        else if ($record == 'investigations')
                        {
                            $investigation_values = json_decode($List[$record]);
                            $temp = [];
                            foreach ($investigation_values as $value) {
                                $temp[] = $mas_investigation[$value];
                            }

                            $tempFields[$record] = implode(',', $temp);
                        }
                        else if ($record == 'verified_by')
                        {
                            $tempFields[$record] = $List[$record] > 0 ? true : false;
                        }
                        else 
                        {
                            $tempFields[$record] = $List[$record];
                        }
                    } else {
                        if ($record == 'palpation')
                        {
                            $temp = [];
                            if ($List['palpation_soft']) {
                                $temp[] = 'Soft';
                            } else if ($List['palpation_rigidity']) {
                                $temp[] = 'Rigidity';                               
                            } else if ($List['palpation_guarding']) {
                                $temp[] = 'Guarding';                               
                            } else {
                                $temp[] = null;                               
                            }
                            if ($List['palpation_tender']) {
                                $temp[] = 'Tender';
                            } else if ($List['palpation_non_tender']) {
                                $temp[] = 'Non Tender';
                            } else {
                                $temp[] = null;                               
                            }
                            $tempFields[$record] = implode(',', $temp);
                        } 
                        else if ($record == 'drug_name')
                        {
                            $medications = json_decode($List['discharge_medications']);
                            $temp_list = [];
                            if (is_array($medications)) {
                                foreach ($medications as $key => $value) {
                                    $temp_list['drug_name'][] = $value->drug_name;
                                    $temp_list['dose'][] = $value->dose;
                                    $temp_list['route'][] = $value->route;
                                    $temp_list['frequency'][] = $value->frequency;
                                    $temp_list['duration'][] = $value->duration;
                                }
                                $tempFields['drug_name'] = implode(',', $temp_list['drug_name']);
                                $tempFields['dose'] = implode(',', $temp_list['dose']);
                                $tempFields['route'] = implode(',', $temp_list['route']);
                                $tempFields['frequency'] = implode(',', $temp_list['frequency']);
                                $tempFields['duration'] = implode(',', $temp_list['duration']);
                            }
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

