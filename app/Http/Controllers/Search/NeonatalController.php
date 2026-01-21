<?php

namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Search\SearchNeonatal;
use App\Models\Masters\Indication;
use App\Models\Masters\MediprobsMaster;
use App\Models\Masters\Complications as ComplicationMaster;
use Carbon\Carbon;
use App\Models\Neonatal;
use App\Models\Usg;
use App\Models\Problems;
use App\Models\Delivery;
use App\Models\Complication;
use App\Http\Controllers\Excel\ExportExcelController;
use Illuminate\Support\Str;
use App\Models\Search\SearchQueryLog;

class NeonatalController extends Controller
{
    public function __construct(SearchNeonatal $SearchNeonatal, ExportExcelController $export)
    {
        $this->SearchNeonatal  = $SearchNeonatal;
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
        $order['sortby'] = 'NeonatalId';
        $order['sortorder'] = 'desc';
        $last = false;
        if ($page == 1 && isset($input['query_log_id']) && empty($input['query_log_id']))
        {
            $tempResults = $this->SearchNeonatal->getList($page, $limit, $input, $order);
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
            $tempResults['count'] = $input['neonatal_count'];
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
            return redirect(action('Search\NeonatalController@create'))->with('Success', 'No record found');
        }
        $neonatal_ids = $tempResults->unique('NeonatalId')->pluck('NeonatalId')->toArray();

        if ($last) {
            $neonatal_ids_count = count($neonatal_ids)-1;
            $current_id = isset($neonatal_ids[$neonatal_ids_count]) ? $neonatal_ids[$neonatal_ids_count] : 0;
        } else {
            $current_id = isset($neonatal_ids[0]) ? $neonatal_ids[0] : 0;
        }

        $neonatal_last = $this->setPrevnext($neonatal_ids, $current_id, json_encode($neonatal_ids), $count, $query_log_id, $page, $very_first, $very_last);

        return redirect(action('Search\NeonatalController@searchview', \SiteHelpers::encrypt_id($current_id)) . '?neonatal_ids=' . json_encode($neonatal_ids) . '&neonatal_count=' . $count . '&query_log_id=' . $query_log_id  . '&page=' . $page . '&very_first=' . $very_first . '&very_last=' . $very_last.'&last='.$last.'&last_id='.$current_id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id type integer
     * @return Response
     */
    public function create(Request $request) 
    {
        $navigate['main_nav'] = 'neo_proforma';
        $navigate['sub_nav']  = 'neonatal';

        $results          = array();
        $delivery_indications = Indication::getFieldvalue();

        $medicalproblems      = MediprobsMaster::get_lists()->pluck('Name', 'Id')->toArray();
        $medicalproblems['']   = 'N/A';

        $complications        = ComplicationMaster::all()->pluck('Name', 'Id')->toArray();
        $complications['']     = 'N/A'; 

        $timeList       = \SiteHelpers::prepare_time();
        $tob['time']    = $timeList['time'];
        $tob['mins']    = $timeList['mins'];
        $tob['session'] = $timeList['session'];
        $results = (object)[];
        $neonatallist = array();

        $probs = MediprobsMaster::get_lists()->pluck('Name', 'Id')->toArray();

        return view('search.neonatal.search', compact('complications','navigate', 'results', 'medicalproblems','tob', 'SavedhereText', 'delivery_indications', 'results', 'probs', 'neonatallist'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id type integer
     * @return Response
     */
    public function searchview(Request $request,  $id = 0) 
    {
        $input = $request->all();

        $id = \SiteHelpers::decrypt_id($id);

        // All the masters are going here 
        $navigate['main_nav'] = 'neo_proforma';
        $navigate['sub_nav']  = 'neonatal';

        $results          = array();
        $delivery_indications = Indication::getFieldvalue();

        $medicalproblems      = MediprobsMaster::get_lists()->pluck('Name', 'Id')->toArray();
        $medicalproblems[0]   = 'N/A';

        $complications        = ComplicationMaster::all()->pluck('Name', 'Id')->toArray();
        $complications[0]     = 'N/A'; 

        $timeList       = \SiteHelpers::prepare_time();
        $tob['time']    = $timeList['time'];
        $tob['mins']    = $timeList['mins'];
        $tob['session'] = $timeList['session'];

        $times = date('g:i:A', strtotime(Carbon::now(env('TIME_ZONE'))));
        $test_time = explode(':', $times);

        $results = array();
        $results      = $this->SearchNeonatal->getData($id);
        $current_id = $id;
        if (!isset($input['neonatal_ids']))
        {
            return redirect(action('Search\NeonatalController@create'));
        }
        $neonatal_ids = json_decode($input['neonatal_ids']);
        $count = isset($input['neonatal_count']) ? $input['neonatal_count'] : 0;

        $query_log_id = isset($input['query_log_id']) ? $input['query_log_id'] : 0;

        $current_page = isset($input['page']) ? $input['page'] : 1;

        $very_first = isset($input['very_first']) ? $input['very_first'] : null;

        $very_last = isset($input['very_last']) ? $input['very_last'] : null;

        $last_id = isset($input['last_id']) ? $input['last_id'] : null;

        $neonatal_last = $this->setPrevnext($neonatal_ids, $current_id, json_encode($neonatal_ids), $count, $query_log_id, $current_page, $very_first, $very_last);

        $tempResults = $this->SearchNeonatal->getNeonatalList($neonatal_ids);
        $neonatallist = collect($tempResults)->toArray();

        if (isset($results) & count($results) > 0) {

            $ob_medicalproblem = Problems::where('BabyId', $results->BabyId)->get()->toArray();
            $ob_delivery       = Delivery::where('MotherId', $results->MotherId)->get()->toArray();
            $complication      = Complication::where('BabyId', $results->BabyId)->where('flags', 1)->get()->toArray();

            $datingScan  = Usg::where('type', 1)->where('flags', 1)->where('BabyId',$results->BabyId)->first();
            $analogScan  = Usg::where('type', 2)->where('flags', 1)->where('BabyId',$results->BabyId)->first();
            $otherScan   = Usg::where('type', 3)->where('flags', 1)->where('BabyId',$results->BabyId)->get()->toArray();
            $dopplerScan = Usg::where('type', 4)->where('flags', 1)->where('BabyId',$results->BabyId)->get()->toArray();

            $datingScan = (count($datingScan) > 0) ? $datingScan->toArray() : array();
            $analogScan = (count($analogScan) > 0) ? $analogScan->toArray() : array();
        }

        $results->DOB      = !is_null($results->DOB) ? date('d-m-Y', strtotime($results->DOB)) : '';
        $results->TestDate = !is_null($results->TestDate) ? date('d-m-Y', strtotime($results->TestDate)) : '';

        $results->LMP        = ($results->LMP != '' && !is_null($results->LMP)) ? date('d-m-Y', strtotime($results->LMP)) : '';
        $results->EDDbyUSG   = ($results->EDDbyUSG != '' && !is_null($results->EDDbyUSG)) ? date('d-m-Y', strtotime($results->EDDbyUSG)) : '';
        $results->EDDbyDates = ($results->EDDbyDates != '' && !is_null($results->EDDbyDates)) ? date('d-m-Y', strtotime($results->EDDbyDates)) : '';

        $results->TEST_TIME     = strlen($results->TEST_TIME) == 2 ?  $results->TEST_TIME : '0'. $results->TEST_TIME;
        $results->TEST_MINS     = strlen($results->TEST_MINS) == 2 ?  $results->TEST_MINS : '0'. $results->TEST_MINS;
        $results->entry_time    = $results->TEST_TIME.':'.$results->TEST_MINS.':'.$results->TEST_AM;

        $results->TOB_TIME      = strlen($results->TOB_TIME) == 2 ?  $results->TOB_TIME : '0'. $results->TOB_TIME;
        $results->TOB_MINS      = strlen($results->TOB_MINS) == 2 ?  $results->TOB_MINS : '0'. $results->TOB_MINS;
        $results->time_of_birth = $results->TOB_TIME.':'.$results->TOB_MINS.':'.$results->TOB_AM;

        $results->sepsis_in_mother_type = (isset($results->sepsis_in_mother_type) && !is_null($results->sepsis_in_mother_type)) ? json_decode($results->sepsis_in_mother_type) : array();

        $results->MotherDOB  = isset($results->MotherDOB) ? date('d-m-Y', strtotime($results->MotherDOB)) : '';
        $results->PartnerDOB = isset($results->PartnerDOB) ? date('d-m-Y', strtotime($results->PartnerDOB)) : '';

        $results->Scalp      = explode(',', $results->Scalp);

        $probs = MediprobsMaster::get_lists()->pluck('Name', 'Id')->toArray();

        $pbm_data = Problems::where('BabyId', '=', $results->BabyId)->get();
        $delivery_details = Delivery::where('MotherId', '=', $results->MotherId)->get();
        $maternalantibiotics = (!empty($results->MaternalAntibiotics)) ? json_decode($results->MaternalAntibiotics) : array();

        return view('search.neonatal.search', compact('neonatal_last','datingScan', 'analogScan', 'otherScan', 'dopplerScan','complications','complication','ob_delivery','neonatal_list','dopplerScan','otherScan','analogScan','datingScan','medicalproblems', 'navigate', 'results', 'tob', 'delivery_indications', 'ob_medicalproblem','complication', 'probs', 'neonatallist', 'very_first', 'very_last','current_page', 'count', 'query_log_id', 'last_id', 'neonatal_ids', 'pbm_data', 'delivery_details', 'maternalantibiotics'));
    }

    /**
     * This method to get previous 
     * next url
     *
     * @param $neonatal_ids type array
     *
     * @param $current_id type id
     * @return array or void
     */
    public function setPrevnext($neonatal_list, $current_id, $neonatal_ids, $count, $query_log_id, $current_page, $very_first, $very_last)
    {
        if (is_array($neonatal_list) && !empty($current_id))
        {
            $key = array_search($current_id, $neonatal_list);
            $prev = $key - 1;
            $next = $key + 1;
            $neonatalpages[0] = (array_key_exists($prev, $neonatal_list)) ? $neonatal_list[$prev] : '';
            $neonatalpages[1] = (array_key_exists($next, $neonatal_list)) ? $neonatal_list[$next] : '';

            $next_page = $current_page + 1;
            $prev_page = $current_page - 1;

            $one_page_last = false;

            if ($neonatal_list[0] == $current_id) {
                $one_page_last = true;
            }

            $neonatalpages[0] = !empty($neonatalpages[0]) ? action('Search\NeonatalController@searchview', \SiteHelpers::encrypt_id($neonatalpages[0]) . '?neonatal_ids=' . $neonatal_ids . '&neonatal_count=' . $count.'&page='.$current_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last) : action('Search\NeonatalController@index', \SiteHelpers::encrypt_id($neonatalpages[1]) . '&neonatal_count=' . $count.'&page='.$prev_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last . '&one_page_last=' . $one_page_last);
            
            $neonatalpages[1] = !empty($neonatalpages[1]) ? action('Search\NeonatalController@searchview', \SiteHelpers::encrypt_id($neonatalpages[1]) . '?neonatal_ids=' . $neonatal_ids . '&neonatal_count=' . $count.'&page='.$current_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last) : action('Search\NeonatalController@index', \SiteHelpers::encrypt_id($neonatalpages[1]) . '&neonatal_count=' . $count.'&page='.$next_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last);

            return $neonatalpages;
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

        $tempHeading = Config('exportfields.neonatal_proforma');        

        $last_query = SearchQueryLog::findOrfail($input['query_log_id']);

        $last_query['bindings'] = explode(',', $last_query['bindings']);

        $length = count($last_query['bindings']);
        $old_limit = 'limit ' . str_replace("'", "", $last_query['bindings'][$length - 2]);
        $old_offset = 'offset ' . str_replace("'", "", $last_query['bindings'][$length - 1]);

        $last_query['query'] = str_replace($old_limit, '', $last_query['query']);
        $last_query['query'] = str_replace($old_offset, '', $last_query['query']);

        $temp = Str::replaceArray('?', $last_query['bindings'], $last_query['query']);
        $results = \DB::select($temp);

        $neonatalId = collect($results)->pluck('NeonatalId')->toArray();

        $results = $this->SearchNeonatal->getNeonatalList($neonatalId);

        $results = \SiteHelpers::convert_obj_to_array($results->toArray());

        foreach ($results as $result_key => $result_value) {

            $ob_medicalproblem = Problems::where('BabyId', $result_value['BabyId'])->get()->toArray();
            $ob_delivery       = Delivery::where('MotherId', $result_value['MotherId'])->get()->toArray();
            $complication      = Complication::where('BabyId', $result_value['BabyId'])->where('flags', 1)->get()->toArray();

            $datingScan  = Usg::where('type', 1)->where('flags', 1)->where('BabyId',$result_value['BabyId'])->get()->toArray();
            $analogScan  = Usg::where('type', 2)->where('flags', 1)->where('BabyId',$result_value['BabyId'])->get()->toArray();
            $otherScan   = Usg::where('type', 3)->where('flags', 1)->where('BabyId',$result_value['BabyId'])->get()->toArray();
            $dopplerScan = Usg::where('type', 4)->where('flags', 1)->where('BabyId',$result_value['BabyId'])->get()->toArray();

            $result = array();

            foreach ($ob_medicalproblem as $keys => $value) {
                $temp_medication = MediprobsMaster::getName($value['Problem']);
                $result['Problem'][$keys]    = isset($temp_medication->Name) ? $temp_medication->Name : null;
                $result['Medication'][$keys] = $value['Medication'];
            }
            if (count($result) > 0) {
                $results[$result_key]['Problems']    = implode(',', $result['Problem']);
                $results[$result_key]['Medications'] = implode(',', $result['Medication']);
            }
            foreach ($ob_delivery as $keys => $value) {
                $result['Year'][$keys]          = $value['Year'];
                $result['Place'][$keys]         = $value['Place'];
                $result['Delivery'][$keys]      = $value['Delivery'];
                $result['Complications'][$keys] = $value['Complications'];
                $result['Gender'][$keys]        = $value['Gender'];
                $result['GA'][$keys]            = $value['GA'];
                $result['BW'][$keys]            = $value['BW'];
                $result['Health'][$keys]        = $value['Health'];
                $result['details'][$keys]       = $value['details'];
            }
            if (count($result) > 0) {
                $results[$result_key]['Year']          = isset($result['Year']) ? implode(',', $result['Year']) : '' ;
                $results[$result_key]['Place']         = isset($result['Place']) ? implode(',', $result['Place']) : '';
                $results[$result_key]['Delivery']      = isset($result['Delivery']) ? implode(',', $result['Delivery']) : '';
                $results[$result_key]['Complications'] = isset($result['Complications']) ? implode(',', $result['Complications']) : '';;
                $results[$result_key]['Gender']        = isset($result['Gender']) ? implode(',', $result['Gender']) : '';
                $results[$result_key]['GA']            = isset($result['GA']) ? implode(',', $result['GA']) : '';
                $results[$result_key]['BW']            = isset($result['BW']) ? implode(',', $result['BW']) : '';
                $results[$result_key]['Health']        = isset($result['Health']) ? implode(',', $result['Health']) : '';
                $results[$result_key]['details']       = isset($result['details']) ? implode(',', $result['details']) : '';
            }

            foreach ($complication as $keys => $value) {
                $result['Complication'][$keys]      = isset(ComplicationMaster::getName($value['Complication'])->Name) ? ComplicationMaster::getName($value['Complication'])->Name : $value['Complication'];
                $result['Treatments'][$keys]        = $value['Treatment'];
                $result['duration_in_weeks'][$keys] = $value['duration_in_weeks'];
                $result['duration_unit'][$keys]     = $value['duration_unit'];
            }
            if (isset($result['Complication'])) {
                $results[$result_key]['Complication']      = implode(',', $result['Complication']);
                $results[$result_key]['Treatments']        = implode(',', $result['Treatments']);
                $results[$result_key]['duration_in_weeks'] = implode(',', $result['duration_in_weeks']);
                $results[$result_key]['duration_unit']     = implode(',', $result['duration_unit']);
            } else {
                $results[$result_key]['Complication']      = null;
                $results[$result_key]['Treatments']        = null;
                $results[$result_key]['duration_in_weeks'] = null;
                $results[$result_key]['duration_unit']     = null;
            }

            foreach ($datingScan as $keys => $value) {
                if (isset($value['Gestation'])) {
                    $result['datinggestations'][$keys] = $value['Gestation'];
                }
                if (isset($value['Finding'])) {
                    $result['datingfindings'][$keys]   = $value['Finding'];
                }
            }
            if (isset($result['datinggestations']) && count($result['datingfindings']) > 0) {
                $results[$result_key]['datinggestations'] = implode(',', $result['datinggestations']);
                $results[$result_key]['datingfindings']   = implode(',', $result['datingfindings']);
            }

            foreach ($analogScan as $keys => $value) {
                if (isset($value['Gestation'])) {
                    $result['analoggestations'][$keys] = $value['Gestation'];
                }
                if (isset($value['Finding'])) {
                    $result['analogfindings'][$keys]   = $value['Finding'];
                }
            }

            if (isset($result['analoggestations']) && count($result['analogfindings']) > 0) {
                $results[$result_key]['analoggestations'] = implode(',', $result['analoggestations']);
                $results[$result_key]['analogfindings']   = implode(',', $result['analogfindings']) ;
            }

            foreach ($otherScan as $keys => $value) {
                $result['othergestations'][$keys] = isset($value['Gestation']) ? $value['Gestation'] : null;
                $result['otherfindings'][$keys]   = isset($value['Finding']) ? $value['Finding'] : null;
            }
            if (isset($result['othergestations']) && count($result['otherfindings']) > 0) {
                $results[$result_key]['othergestations'] = implode(',', $result['othergestations']);
                $results[$result_key]['otherfindings']   = implode(',', $result['otherfindings']);
            }

            foreach ($dopplerScan as $keys => $value) {
                $result['dopplergestations'][$keys] = isset($value['Gestation']) ? $value['Gestation'] : null;
                $result['dopplerfindings'][$keys]   = isset($value['Finding']) ? $value['Finding'] : null;
            }
            if (isset($result['dopplergestations']) && count($result['dopplerfindings']) > 0) {
                $results[$result_key]['dopplergestations'] = implode(',', $result['dopplergestations']);
                $results[$result_key]['dopplerfindings']   = implode(',', $result['dopplerfindings']);
            }

            if (isset($result_value['Indication']) && count(json_decode($result_value['Indication'])) > 0) {
                foreach (json_decode($result_value['Indication']) as $keys => $indication) {
                    if (strlen($indication) > 0 && $indication != 'N/A' && $indication != '' && $indication != ' ' && $indication != 'undefined') {
                        $indications[$keys] = isset(Indication::getName($indication)->indication_name) ? Indication::getName($indication)->indication_name : $indication;
                    } 
                }
                if (isset($indications)) {
                    $results[$result_key]['Indication'] = implode(',', $indications);
                }
            }

            if (isset($result_value['sepsis_in_mother_type']) && count(json_decode($result_value['sepsis_in_mother_type'])) > 0) {
                foreach (json_decode($result_value['sepsis_in_mother_type']) as $keys => $sepsis) {
                    switch ($sepsis) {
                        case 1:
                        $result['sepsis_in_mother_type'][$keys] = '"chorioamnionitis"';
                        break;
                        
                        case 2:
                        $result['sepsis_in_mother_type'][$keys] = '"Unclean vaginal examination / > 3 PV examination"';
                        break;
                        
                        case 3:
                        $result['sepsis_in_mother_type'][$keys] = '"Leaking PV > 18hours / pPROM"';
                        break;
                        
                        case 4:
                        $result['sepsis_in_mother_type'][$keys] = '"GBS in maternal recto-vaginal swab"';
                        break;
                        
                        case 5:
                        $result['sepsis_in_mother_type'][$keys] = '"UTI in mother"';
                        break;
                        
                        case 6:
                        $result['sepsis_in_mother_type'][$keys] = '"Maternal fever"';
                        break;
                    }
                } 
                if (isset($result['sepsis_in_mother_type'])) {
                    $results[$result_key]['sepsis_in_mother_type'] = implode(',', $result['sepsis_in_mother_type']);
                }
            }

            if (isset($result_value['TOB_TIME'])) {
                foreach ($result_value as $key => $value) {

                    $result_value['TOB_TIME'] = strlen($result_value['TOB_TIME']) == 2 ?  $result_value['TOB_TIME'] : '0'. $result_value['TOB_TIME'];
                    $result_value['TOB_MINS'] = strlen($result_value['TOB_MINS']) == 2 ?  $result_value['TOB_MINS'] : '0'. $result_value['TOB_MINS'];

                    $results[$result_key]['TOB'] = $result_value['TOB_TIME'] . ':' . $result_value['TOB_MINS'] . ' ' . $result_value['TOB_AM'];
                }
            }

            if (isset($result_value['TEST_TIME'])) {
                $results[$result_key]['date_entry_time'] = $result_value['TEST_TIME'] . ':' . $result_value['TEST_MINS'] . ' ' . $result_value['TEST_AM'];
            }

            if (isset($result_value['TestDate'])) {
                $results[$result_key]['TestDate'] = strtotime($result_value['TestDate']) ? date('d-m-Y', strtotime($result_value['TestDate'])) : null;
            }

            if (isset($result_value['DOB'])) {
                $results[$result_key]['DOB'] = strtotime($result_value['DOB']) ? date('d-m-Y', strtotime($result_value['DOB'])) : null;
            }

            if (isset($result_value['MotherDOB'])) {
                $results[$result_key]['MotherDOB'] = strtotime($result_value['MotherDOB']) ? date('d-m-Y', strtotime($result_value['MotherDOB'])) : null;
            }

            if (isset($result_value['PartnerDOB'])) {
                $results[$result_key]['PartnerDOB'] = strtotime($result_value['PartnerDOB']) ? date('d-m-Y', strtotime($result_value['PartnerDOB'])) : null;
            }

            if (isset($result_value['LMP'])) {
                $results[$result_key]['LMP'] = strtotime($result_value['LMP']) ? date('d-m-Y', strtotime($result_value['LMP'])) : null;
            }

            if (isset($result_value['EDDbyUSG'])) {
                $results[$result_key]['EDDbyUSG'] = strtotime($result_value['EDDbyUSG']) ? date('d-m-Y', strtotime($result_value['EDDbyUSG'])) : null;
            }

            if (isset($result_value['EDDbyDates'])) {
                $results[$result_key]['EDDbyDates'] = strtotime($result_value['EDDbyDates']) ? date('d-m-Y', strtotime($result_value['EDDbyDates'])) : null;
            }

            if (isset($result_value['MaternalAntibiotics']))
            {
                $antibiotic_list = json_decode($result_value['MaternalAntibiotics']);
                if (is_array($antibiotic_list) && count($antibiotic_list) > 0) {
                    $results[$result_key]['MaternalAntibiotics'] = implode(',', $antibiotic_list);
                }
            }

            unset($result);
        }

        $dataList = array();

        $export_list = $input['neonatal_export_list'];
        $export_list = json_decode($export_list);
        krsort($export_list);
        $fields = $export_list;

        foreach ($results as $List) {

            $tempFields = array();

            foreach ($fields as $record) {

                if (!isset($List[$record])) {

                    $List[$record] = "";

                    $tempFields[$record] = $List[$record];

                } elseif (in_array($record, Config('exportfields.neonatalFieldmodifier.toggleType'))) {                        

                    $tempFields[$record] = $List[$record] == 2 ? 'Yes' : 'No' ;

                } elseif (in_array($record, Config('exportfields.neonatalFieldmodifier.toggleType1'))) {                        

                    $tempFields[$record] = $List[$record] == 1 ? 'known' : 'Unknown';

                }  elseif (in_array($record, Config('exportfields.neonatalFieldmodifier.differentType'))) {                        

                    switch ($record) {
                        case 'Syntocinon':
                        if ( $List[$record] == 1 ) {
                            $tempFields[$record] = 'Given';
                        } else if ( $List[$record] == 2 ) {
                            $tempFields[$record] = 'Not Given';
                        } else if ( $List[$record] == 3 ) {
                            $tempFields[$record] = 'Not known';
                        }
                        break;
                        case 'adjustedtrisomies':
                        $tempFields[$record] = $List[$record] == 2 ? 'Yes' : 'No' ;
                        break;
                    }
                } else {
                    $List[$record] = trim(strip_tags(preg_replace('/[\n\r\t]/', ' ', $List[$record])));

                    $tempFields[$record] = $List[$record];
                }
            }

            $dataList[] = $tempFields;
        }

        $headingList = array();

        foreach ($fields as $fieldsValue) {
            $headingList[] = $tempHeading[$fieldsValue];
        }

        $this->export->setFilename($input['file_name']);
        $this->export->setFileformat($input['file_format']);

        return $this->export->exportFile($dataList, $headingList);
        
    }


}
