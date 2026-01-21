<?php
namespace App\Http\Controllers\Search;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Excel\ExportExcelController;
use App\Models\Search\SearchQueryLog;
use Illuminate\Support\Str;
use App\Models\Search\Neuro;
use App\Models\Masters\MchatquestionsMaster;
use App\Models\Masters\MchatquestionsfollowupMaster;
use App\Models\Masters\DasiiquestionsMaster;
use App\Models\Masters\CBCLquestionsMaster;
use App\Models\Op;

class NeuroController extends Controller
{
    public function __construct(Neuro $search, ExportExcelController $export)
    {
        $this->search = $search;
        $this->export = $export;
        $this->left_options = ['' => 'N/A', 1 => 'Pass', 2 => 'Refer'];
        $this->right_options = ['' => 'N/A', 1 => 'Pass', 2 => 'Refer'];
        $this->ddst_interpretation_result = [0 => 'Normal', 1 => 'Suspect', 2 => 'Untestable'];
        $this->hnne_hine_interpretation_options = ['N/A', 'Normal response for the age', 'Normal response for the corrected age', 'Weak response for the age', 'Weak response for the corrected age', 'Mild response for the age', 'Mild response for the corrected age'];
        $this->m_chat_interpretation_options = ['N/A', 'No risk for ASD', 'Mild risk for ASD', 'High risk for ASD'];
        $this->ddst_interpretation_options = ['N/A', 'Normal development in all the domains for the age', 'Normal development in all the domains for the corrected age', 'Suspect for developmental delay in all the domains for the age', 'Suspect for developmental delay in all the domains for the corrected age', 'Suspect for developmental delay in gross motor domain and normal development in rest of the domains for the age', 'Suspect for developmental delay in gross motor domain and normal development in rest of the domains for the corrected age', 'Suspect for developmental delay in fine motor domain and normal development in the rest of the domains for the age', 'Suspect for developmental delay in fine motor domain and normal development in the rest of the domains for the corrected age', 'Suspect for developmental delay in language domain and normal development in the rest of the domains for the age', 'Suspect for developmental delay in language domain and normal development in the rest of the domains for the corrected age', 'Suspect for developmental delay in personal social domain and normal development in the rest of the domains for the age', 'Suspect for developmental delay in personal social domain and normal development in the rest of the domains for the corrected age', 'Suspect for developmental delay in gross and fine motor domains; normal development in the rest of the domains for the age', 'Suspect for developmental delay in gross and fine motor domains; normal development in the rest of the domains for the corrected age', 'Suspect for developmental delay in gross motor and language domains; normal development in the rest of the domains for the age', 'Suspect for developmental delay in gross motor and language domains; normal development in the rest of the domains for the corrected age', 'Suspect for developmental delay in gross motor and personal social domains; normal development in the rest of the domains for the age', 'Suspect for developmental delay in gross motor and personal social domains; normal development in the rest of the domains for the corrected age', 'Suspect for developmental delay in fine motor and language domains; normal development in the rest of the domains for the age', 'Suspect for developmental delay in fine motor and language domains; normal development in the rest of the domains for the corrected age', 'Suspect for developmental delay in fine motor and personal social domains; normal development in the rest of the domains for the age', 'Suspect for developmental delay in fine motor and personal social domains; normal development in the rest of the domains for the corrected age', 'Suspect for developmental delay in the language and personal social domains; normal development in the rest of the domains for the age', 'Suspect for developmental delay in the language and personal social domains; normal development in the rest of the domains for the corrected age', 'Untestable'];
        $this->tone = [''=>'N/A',1=>'Normal',2=>'Hypotonia',3=>'Hypertonia',4=>'Within normal limits'];
        $this->others = [''=>'N/A',1=>'Symmetric',2=>'Asymmetric'];
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
            $tempResults['count'] = $input['neuro_count'];
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
            return redirect(action('Search\NeuroController@create'))->with('Success', 'No record found');
        }
        $neuro_ids = $tempResults->unique('neuro_id')->pluck('neuro_id')->toArray();

        if ($last) {
            $neuro_ids_count = count($neuro_ids)-1;
            $current_id = isset($neuro_ids[$neuro_ids_count]) ? $neuro_ids[$neuro_ids_count] : 0;
        } else {
            $current_id = isset($neuro_ids[0]) ? $neuro_ids[0] : 0;
        }

        $neuro_last = $this->setPrevnext($neuro_ids, $current_id, json_encode($neuro_ids), $count, $query_log_id, $page, $very_first, $very_last);

        return redirect(action('Search\NeuroController@searchview', \SiteHelpers::encrypt_id($current_id)) . '?neuro_ids=' . json_encode($neuro_ids) . '&neuro_count=' . $count . '&query_log_id=' . $query_log_id  . '&page=' . $page . '&very_first=' . $very_first . '&very_last=' . $very_last.'&last='.$last.'&last_id='.$current_id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $navigate['main_nav'] = 'neuro';
        $navigate['sub_nav'] = 'neuro_discharge';

        $neuroList = array();
        $results = (object)[];

        $time = \SiteHelpers::prepare_time();
        $left_options = $this->left_options;
        $right_options = $this->right_options;
        $ddst_interpretation_result = $this->ddst_interpretation_result;
        $hnne_hine_interpretation_options = $this->hnne_hine_interpretation_options;
        $m_chat_interpretation_options = $this->m_chat_interpretation_options;
        $ddst_interpretation_options = $this->ddst_interpretation_options;
        $tone = $this->tone;
        $others = $this->others;
        $m_chat_questions = MchatquestionsMaster::getQuestions();
        $m_chat_followup_questions = MchatquestionsfollowupMaster::getQuestions();
        $mas_dasii_questions = DasiiquestionsMaster::getQuestions();
        $dasii_motor_questions = $mas_dasii_questions->where('question_type', 'motor')->sortBy('question_number')->toArray();
        $dasii_mental_questions = $mas_dasii_questions->where('question_type', 'mental')->sortBy('question_number')->toArray();
        $hnne_details = (object)[];
        $hine_details = (object)[];
        $ddst_setting = \DB::table('ddst_settings')->orderBy('id', 'asc')->get();
        $ddst_settings = [];
        $ddst_array = 0;
        foreach ($ddst_setting as $value) {
            $color = '#7ED2E5';
            $fill = $value->fill == '#7ED2E5' ? $color : $value->fill;
            $stroke = $value->stroke != null ? $color : $value->stroke;
            $temp_settings['taskid'] = $value->task_id;
            $temp_settings['task'] = $value->name;
            $temp_settings['value'] = $value->x_value;
            $temp_settings['endValue'] = $value->x_end_value;
            $temp_settings['yvalue'] = $value->y_value;
            $temp_settings['yendValue'] = $value->y_end_value;
            $temp_settings['columnSettings'] =  ["fill" => $fill, "stroke" => $stroke];
            $temp_settings['siblings'] = $value->siblings;
            $temp_settings['nofill'] = $value->nofill;
            $temp_settings['rowsize'] = $value->rowsize;
            $temp_settings['rrposition'] = $value->rrposition;
            $temp_settings['rbposition'] = $value->rbposition;
            $temp_settings['countno'] = $value->countno;
            $temp_settings['ctposition'] = $value->ctposition;
            $temp_settings['crposition'] = $value->crposition;
            $temp_settings['taskalign'] = $value->align;
            $temp_settings['percentage'] = $value->percentage;
            $temp_settings['percentage_align'] = $value->percentage_align;
            $temp_settings['array_id'] = $ddst_array;
            $ddst_settings[] = $temp_settings;
            unset($temp_settings);
            $ddst_array++;
        }
        $cbcl_question = CBCLquestionsMaster::list();

        return view('search.neuro.search', compact('navigate', 'neuroList', 'results', 'time', 'left_options', 'right_options', 'ddst_interpretation_result', 'hnne_details', 'hnne_hine_interpretation_options', 'hine_details', 'm_chat_questions', 'm_chat_interpretation_options', 'm_chat_followup_questions', 'dasii_mental_questions', 'dasii_motor_questions', 'ddst_settings', 'ddst_interpretation_options', 'cbcl_question', 'tone', 'others'));
    }

    public function searchview(Request $request, $id = 0)
    {
        $input = $request->all();
        $id = \SiteHelpers::decrypt_id($id);
        $navigate['main_nav'] = 'neuro';
        $navigate['sub_nav'] = 'neuro_discharge';
        $time = \SiteHelpers::prepare_time();
        $left_options = $this->left_options;
        $right_options = $this->right_options;
        $ddst_interpretation_result = $this->ddst_interpretation_result;
        $hnne_hine_interpretation_options = $this->hnne_hine_interpretation_options;
        $m_chat_interpretation_options = $this->m_chat_interpretation_options;
        $ddst_interpretation_options = $this->ddst_interpretation_options;
        $tone = $this->tone;
        $others = $this->others;
        $m_chat_questions = MchatquestionsMaster::getQuestions();
        $m_chat_followup_questions = MchatquestionsfollowupMaster::getQuestions();
        $mas_dasii_questions = DasiiquestionsMaster::getQuestions();
        $dasii_motor_questions = $mas_dasii_questions->where('question_type', 'motor')->sortBy('question_number')->toArray();
        $dasii_mental_questions = $mas_dasii_questions->where('question_type', 'mental')->sortBy('question_number')->toArray();
        $hnne_details = (object)[];
        $hine_details = (object)[];
        $ddst_setting = \DB::table('ddst_settings')->orderBy('id', 'asc')->get();
        $ddst_settings = [];
        $ddst_array = 0;
        foreach ($ddst_setting as $value) {
            $color = '#7ED2E5';
            $fill = $value->fill == '#7ED2E5' ? $color : $value->fill;
            $stroke = $value->stroke != null ? $color : $value->stroke;
            $temp_settings['taskid'] = $value->task_id;
            $temp_settings['task'] = $value->name;
            $temp_settings['value'] = $value->x_value;
            $temp_settings['endValue'] = $value->x_end_value;
            $temp_settings['yvalue'] = $value->y_value;
            $temp_settings['yendValue'] = $value->y_end_value;
            $temp_settings['columnSettings'] =  ["fill" => $fill, "stroke" => $stroke];
            $temp_settings['siblings'] = $value->siblings;
            $temp_settings['nofill'] = $value->nofill;
            $temp_settings['rowsize'] = $value->rowsize;
            $temp_settings['rrposition'] = $value->rrposition;
            $temp_settings['rbposition'] = $value->rbposition;
            $temp_settings['countno'] = $value->countno;
            $temp_settings['ctposition'] = $value->ctposition;
            $temp_settings['crposition'] = $value->crposition;
            $temp_settings['taskalign'] = $value->align;
            $temp_settings['percentage'] = $value->percentage;
            $temp_settings['percentage_align'] = $value->percentage_align;
            $temp_settings['array_id'] = $ddst_array;
            $ddst_settings[] = $temp_settings;
            unset($temp_settings);
            $ddst_array++;
        }
        $cbcl_question = CBCLquestionsMaster::list();
        
        $results = array();
        $results = $this->search->getData($id);
        $current_id = $id;
        if (!isset($input['neuro_ids']))
        {
            return redirect(action('Search\NeuroController@create'));
        }
        $neuro_ids = json_decode($input['neuro_ids']);
        $count = isset($input['neuro_count']) ? $input['neuro_count'] : 0;

        $query_log_id = isset($input['query_log_id']) ? $input['query_log_id'] : 0;

        $current_page = isset($input['page']) ? $input['page'] : 1;

        $very_first = isset($input['very_first']) ? $input['very_first'] : null;

        $very_last = isset($input['very_last']) ? $input['very_last'] : null;

        $last_id = isset($input['last_id']) ? $input['last_id'] : null;

        $neuro_last = $this->setPrevnext($neuro_ids, $current_id, json_encode($neuro_ids), $count, $query_log_id, $current_page, $very_first, $very_last);

        $tempResults = $this->search->getListbyNeuro($neuro_ids);

        $neuroList = collect($tempResults)->toArray();

        if (count($results) > 0)
        {
            $results->DOB = !is_null($results->DOB) ? date('d-m-Y', strtotime($results->DOB)) : '';            
            $results->visit_date = !is_null($results->visit_date) ? date('d-m-Y', strtotime($results->visit_date)) : '';            
            $results->rop_date = !is_null($results->rop_date) ? date('d-m-Y', strtotime($results->rop_date)) : '';            
            $results->hearing_screen_aabr_date = !is_null($results->hearing_screen_aabr_date) ? date('d-m-Y', strtotime($results->hearing_screen_aabr_date)) : '';            
            $results->hearing_screen_oae_date = !is_null($results->hearing_screen_oae_date) ? date('d-m-Y', strtotime($results->hearing_screen_oae_date)) : '';            
            $results->diagnostic_abr_date = !is_null($results->diagnostic_abr_date) ? date('d-m-Y', strtotime($results->diagnostic_abr_date)) : '';            
            $results->diagnostic_cpa_date = !is_null($results->diagnostic_cpa_date) ? date('d-m-Y', strtotime($results->diagnostic_cpa_date)) : '';            
            $results->ct_date = !is_null($results->ct_date) ? date('d-m-Y', strtotime($results->ct_date)) : '';            
            $results->usg_date = !is_null($results->usg_date) ? date('d-m-Y', strtotime($results->usg_date)) : '';            
            $results->mri_date = !is_null($results->mri_date) ? date('d-m-Y', strtotime($results->mri_date)) : '';            
            $results->date_of_assessment_0_3 = !is_null($results->date_of_assessment_0_3) ? date('d-m-Y', strtotime($results->date_of_assessment_0_3)) : '';            
            $results->date_of_assessment_4_6 = !is_null($results->date_of_assessment_4_6) ? date('d-m-Y', strtotime($results->date_of_assessment_4_6)) : '';            
            $results->date_of_assessment_7_9 = !is_null($results->date_of_assessment_7_9) ? date('d-m-Y', strtotime($results->date_of_assessment_7_9)) : '';            
            $results->date_of_assessment_10_12 = !is_null($results->date_of_assessment_10_12) ? date('d-m-Y', strtotime($results->date_of_assessment_10_12)) : '';            
            $results->review = !is_null($results->review) ? date('d-m-Y', strtotime($results->review)) : '';           
            $result_hnne_details = \DB::table('hnne_details')->where('neuro_visit_id', $id)->first();
            if (isset($result_hnne_details->id)) {
                $hnne_details = $result_hnne_details;
            }

            $result_hine_details = \DB::table('hine_details')->where('neuro_visit_id', $id)->first();
            if (isset($result_hine_details->id)) {
                $hine_details = $result_hine_details;
            }

            $m_chat_results = Op::getMChatResults($results->baby_id)->where('type', false)
                ->pluck('answer', 'question_id')
                ->toArray();
            $m_chat_followup_results = Op::getMChatResults($results->baby_id)->where('type', true)
                ->pluck('answer', 'question_id')
                ->toArray();
            $m_chat_followup_results_description = Op::getMChatResults($results->baby_id)->where('type', true)
                ->pluck('description', 'question_id')
                ->toArray();
            $m_chat_followup_results_final_answer = Op::getMChatResults($results->baby_id)->where('type', true)
                ->pluck('final_answer', 'question_id')
                ->toArray();

            $result_mental_motor_details = \DB::table('dasii_mental_motor_screening')->where('neuro_visit_id', $id)->get()->groupby('type')->toArray();

            if (isset($result_mental_motor_details[1])) {
                $results->mentalanswer = collect($result_mental_motor_details[1])->pluck('answer', 'question_id');
            }
            if (isset($result_mental_motor_details[2])) {
                $results->motoranswer = collect($result_mental_motor_details[2])->pluck('answer', 'question_id');
            }

            $ddst_setting = \DB::table('ddst_settings')->orderBy('id', 'asc')->get();

            $ddst_settings = [];
            $ddst_array = 0;

            $ddst_result = \DB::table('ddst_details')->where('neuro_visit_id', $id)->pluck('status', 'task_id');
            foreach ($ddst_setting as $value) {

                $color = '#7ED2E5';

                if (isset($ddst_result[$value->task_id])) {
                    if ($ddst_result[$value->task_id] == 1) {
                        $color = '#47a447';
                    } elseif ($ddst_result[$value->task_id] == 2) {
                        $color = '#d2322d';
                    } elseif ($ddst_result[$value->task_id] == 3) {
                        $color = '#3968c6';
                    } elseif ($ddst_result[$value->task_id] == 4) {
                        $color = '#ed9c28';
                    }
                }

                $fill = $value->fill == '#7ED2E5' ? $color : $value->fill;
                $stroke = $value->stroke != null ? $color : $value->stroke;

                $temp_settings['taskid'] = $value->task_id;
                $temp_settings['task'] = $value->name;
                $temp_settings['value'] = $value->x_value;
                $temp_settings['endValue'] = $value->x_end_value;
                $temp_settings['yvalue'] = $value->y_value;
                $temp_settings['yendValue'] = $value->y_end_value;
                $temp_settings['columnSettings'] =  ["fill" => $fill, "stroke" => $stroke];
                $temp_settings['siblings'] = $value->siblings;
                $temp_settings['nofill'] = $value->nofill;
                $temp_settings['rowsize'] = $value->rowsize;
                $temp_settings['rrposition'] = $value->rrposition;
                $temp_settings['rbposition'] = $value->rbposition;
                $temp_settings['countno'] = $value->countno;
                $temp_settings['ctposition'] = $value->ctposition;
                $temp_settings['crposition'] = $value->crposition;
                $temp_settings['taskalign'] = $value->align;
                $temp_settings['percentage'] = $value->percentage;
                $temp_settings['percentage_align'] = $value->percentage_align;
                $temp_settings['array_id'] = $ddst_array;

                $ddst_settings[] = $temp_settings;
                unset($temp_settings);
                $ddst_array++;
            }

            $cbcl_question = CBCLquestionsMaster::list();

            $cbcl_result = \DB::table('neuro_cbcl_screening')->where('neuro_visit_id', $id)->get()->keyBy('question_id');            
 
        }

        return view('search.neuro.search', compact('results','tempResults', 'neuroList', 'neuro_last', 'count', 'query_log_id', 'current_page', 'very_first', 'very_last', 'last_id', 'time', 'left_options', 'right_options', 'ddst_interpretation_result', 'hnne_details', 'hnne_hine_interpretation_options', 'hine_details', 'm_chat_questions', 'm_chat_interpretation_options', 'm_chat_followup_questions', 'dasii_mental_questions', 'dasii_motor_questions', 'ddst_result', 'ddst_settings', 'ddst_interpretation_options', 'cbcl_question', 'cbcl_result', 'neuro_ids', 'm_chat_results', 'm_chat_followup_results', 'm_chat_followup_results_description', 'm_chat_followup_results_final_answer', 'tone', 'others'));
    }

    /**
     * This method get previous and next method
     *
     *@param $neuro_list type array of object
     *@param $current_id type integer
     *@return $neuropages or 0
     */
    public function setPrevnext($neuro_list, $current_id, $neuro_ids, $count, $query_log_id, $current_page, $very_first, $very_last)
    {
        if (is_array($neuro_list) && !empty($current_id))
        {
            $key = array_search($current_id, $neuro_list);
            $prev = $key - 1;
            $next = $key + 1;
            $neuropages[0] = (array_key_exists($prev, $neuro_list)) ? $neuro_list[$prev] : '';
            $neuropages[1] = (array_key_exists($next, $neuro_list)) ? $neuro_list[$next] : '';

            $next_page = $current_page + 1;
            $prev_page = $current_page - 1;

            $one_page_last = false;

            if ($neuro_list[0] == $current_id) {
                $one_page_last = true;
            }

            $neuropages[0] = !empty($neuropages[0]) ? action('Search\NeuroController@searchview', \SiteHelpers::encrypt_id($neuropages[0]) . '?neuro_ids=' . $neuro_ids . '&neuro_count=' . $count.'&page='.$current_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last) : action('Search\NeuroController@index', \SiteHelpers::encrypt_id($neuropages[1]) . '&neuro_count=' . $count.'&page='.$prev_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last . '&one_page_last=' . $one_page_last);
            
            $neuropages[1] = !empty($neuropages[1]) ? action('Search\NeuroController@searchview', \SiteHelpers::encrypt_id($neuropages[1]) . '?neuro_ids=' . $neuro_ids . '&neuro_count=' . $count.'&page='.$current_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last) : action('Search\NeuroController@index', \SiteHelpers::encrypt_id($neuropages[1]) . '&neuro_count=' . $count.'&page='.$next_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last);

            return $neuropages;
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

        $tempHeading = Config('exportfields.neuro');

        $last_query = SearchQueryLog::findOrfail($input['query_log_id']);

        $last_query['bindings'] = explode(',', $last_query['bindings']);

        $length = count($last_query['bindings']);
        $old_limit = 'limit ' . str_replace("'", "", $last_query['bindings'][$length - 2]);
        $old_offset = 'offset ' . str_replace("'", "", $last_query['bindings'][$length - 1]);

        $last_query['query'] = str_replace($old_limit, '', $last_query['query']);
        $last_query['query'] = str_replace($old_offset, '', $last_query['query']);

        $temp = Str::replaceArray('?', $last_query['bindings'], $last_query['query']);
        $results = \DB::select($temp);

        $id = collect($results)->pluck('neuro_id')->toArray();
        $results = $this->search->getNeuroSearchList($id);
        $results = \SiteHelpers::convert_obj_to_array($results->toArray());

        $mas_doctors = \ValuelistHelpers::mas_doctors_list();
        $right_options = $this->right_options;
        $left_options = $this->left_options;
        $tone = $this->tone;
        $others = $this->others;

        foreach ($results as $result_key => $result_value)
        {
            $result = array();
            $dataList = array();

            $export_list = $request->input('neuro_export_list');
            $export_list = json_decode($export_list);
            krsort($export_list);
            $fields = $export_list;

            foreach ($results as $List)
            {
                $tempFields = array();
                foreach ($fields as $record)
                {
                    if (isset($List[$record])) {
                        if ($record == 'DOB' || $record == 'visit_date' || $record == 'rop_date' || $record == 'hearing_screen_aabr_date' || $record == 'hearing_screen_oae_date' || $record == 'diagnostic_abr_date' || $record == 'diagnostic_cpa_date' || $record == 'ct_date' || $record == 'usg_date' || $record == 'mri_date' || $record == 'date_of_assessment_0_3' || $record == 'date_of_assessment_4_6' || $record == 'date_of_assessment_7_9' || $record == 'date_of_assessment_10_12' || $record == 'review')
                        {
                            $List[$record] = strtotime($List[$record]) ? date('d-m-Y', strtotime($List[$record])) : null;
                            $List[$record] = trim(strip_tags(preg_replace('/[\n\r\t]/', ' ', $List[$record])));
                            $tempFields[$record] = $List[$record];
                            if ($record == 'visit_date') {
                                $tempFields[$record] = $tempFields[$record] . ' ' . $List['visit_time'] . ':' . $List['visit_min'] . ' '. $List['visit_session'];
                            } else if ($record == 'review') {
                                $tempFields[$record] = $tempFields[$record] . ' ' . $List['review_time'] . ':' . $List['review_min'] . ' '. $List['review_session'];
                            }
                        }
                        else if ($record == 'seen_by')
                        {
                            $tempFields[$record] = isset($mas_doctors[$List[$record]]) ? $mas_doctors[$List[$record]] : null;
                        } 
                        else if ($record == 'baby_background' || $record == 'baby_behavior' || $record == 'confidential_background_details' || $record == 'recommendation') 
                        {
                            $tempFields[$record] = strip_tags($List[$record]);
                        } else if ($record == 'hearing_screen_aabr_right_hand_side' || $record == 'hearing_screen_oae_right_hand_side' || $record == 'diagnostic_cpa_right_hand_side') {
                            $tempFields[$record] = isset($right_options[$List[$record]]) ? $right_options[$List[$record]] : null;
                        } else if ($record == 'hearing_screen_aabr_left_hand_side' || $record == 'hearing_screen_oae_left_hand_side' || $record == 'diagnostic_cpa_left_hand_side') {
                            $tempFields[$record] = isset($left_options[$List[$record]]) ? $left_options[$List[$record]] : null;
                        } else if ($record == 'elbow_not_cross_midline_left_0_3' || $record == 'elbow_not_cross_midline_right_0_3' || $record == 'elbow_cross_midline_left_0_3' || $record == 'elbow_cross_midline_right_0_3' || $record == 'elbow_goes_beyond_axillary_line_left_0_3' || $record == 'elbow_goes_beyond_axillary_line_right_0_3' || $record == 'elbow_not_cross_midline_left_4_6' || $record == 'elbow_not_cross_midline_right_4_6' || $record == 'elbow_cross_midline_left_4_6' || $record == 'elbow_cross_midline_right_4_6' || $record == 'elbow_goes_beyond_axillary_line_left_4_6' || $record == 'elbow_goes_beyond_axillary_line_right_4_6' || $record == 'elbow_not_cross_midline_left_7_9' || $record == 'elbow_not_cross_midline_right_7_9' || $record == 'elbow_cross_midline_left_7_9' || $record == 'elbow_cross_midline_right_7_9' || $record == 'elbow_goes_beyond_axillary_line_left_7_9' || $record == 'elbow_goes_beyond_axillary_line_right_7_9' || $record == 'elbow_not_cross_midline_left_10_12' || $record == 'elbow_not_cross_midline_right_10_12' || $record == 'elbow_cross_midline_left_10_12' || $record == 'elbow_cross_midline_right_10_12' || $record == 'elbow_goes_beyond_axillary_line_left_10_12' || $record == 'elbow_goes_beyond_axillary_line_right_10_12') {
                            $tempFields[$record] = ($List[$record] == 1 || $List[$record] == 'on') ? 'true' : 'false';
                        } else if ($record == 'tone_type') {
                            $tempFields[$record] = isset($tone[$List[$record]]) ? $tone[$List[$record]] : null;
                        } else if ($record == 'others') {
                            $tempFields[$record] = isset($other[$List[$record]]) ? $other[$List[$record]] : null;
                        } else if ($record == 'referral_status') {
                            if ($List[$record] == 0) {
                                $tempFields[$record] = 'No';
                            } else if ($List[$record] == 1) {
                                $tempFields[$record] = 'Yes';
                            } else {
                                $tempFields[$record] = null;
                            }
                        } else if ($record == 'fee_status') {
                            if ($List[$record] == 0) {
                                $tempFields[$record] = 'No';
                            } else if ($List[$record] == 1) {
                                $tempFields[$record] = 'Yes';
                            } else {
                                $tempFields[$record] = null;
                            }
                        } else {
                            $tempFields[$record] = $List[$record];                            
                        }
                    } else {
                        if ($record == 'eligibility') {
                            $eligibility_list = [];
                            if ($List['birth_weight_gestation_is_lesser']) {
                                $eligibility_list[] = '1. Birth weight <1500 grams';
                                $eligibility_list[] = '2. Gestation <32weeks';
                            } else if ($List['birth_weight_gestation_is_greater']) {
                                $eligibility_list[] = '3. Infants with BW ≥ 1500 gm OR gestation ≥ 32 week AND';
                            } else if ($List['intrauterine_growth']) {
                                $eligibility_list[] = 'a. Intrauterine growth centile <3rd centile';
                            } else if ($List['meningitis']) {
                                $eligibility_list[] = 'b. Meningitis';
                            } else if ($List['mechanical_ventilation']) {
                                $eligibility_list[] = 'c. Received mechanical ventilation for 48 hours or more';
                            } else if ($List['encephalopathy_stage_2_more']) {
                                $eligibility_list[] = 'd. Hypoxic ischemic encephalopathy stage 2 or higher';
                            } else if ($List['major_malformation']) {
                                $eligibility_list[] = 'e. Major malformation';
                            } else if ($List['inborn_errors']) {
                                $eligibility_list[] = 'f. Inborn error of metabolism/chromosomal or genetic disorders/intrauterine infections';
                            } else if ($List['symptomatic_hypoglycemia']) {
                                $eligibility_list[] = 'g. Symptomatic hypoglycemia';
                            } else if ($List['symptomatic_polycythemia']) {
                                $eligibility_list[] = 'h. Symptomatic polycythemia';
                            } else if ($List['retrovirus_positive_mother']) {
                                $eligibility_list[] = 'i. Retrovirus positive mother';
                            } else if ($List['hyperbilirubinemia_transfusion_rh']) {
                                $eligibility_list[] = 'j. Hyperbilirubinemia requiring exchange transfusion OR Rh isoimmunization/cholestasis';
                            } else if ($List['abnormal_neuro_exam']) {
                                $eligibility_list[] = 'k. Abnormal neurological examination at discharge/seizures';
                            } else if ($List['major_morbidities']) {
                                $eligibility_list[] = 'l. Major morbidities such as chronic lung disease, IVH grade III or more (Papile\'s classification) and periventricular leucomalacia';
                            } else if ($List['other_specify_is_present']) {
                                if (!empty($List['other_specify'])) {
                                    $temp = $List['other_specify'];
                                }
                                $eligibility_list[] = '4. Other Specify' . $temp;
                            } else if ($List['general_checkup']) {
                                $eligibility_list[] = '5. General Developmental Checkup';
                            }
                            $tempFields[$record] = implode(',', $eligibility_list);
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

