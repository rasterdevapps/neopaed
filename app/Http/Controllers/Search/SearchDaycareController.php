<?php

namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;
use App\Models\Masters\DoctorMaster;
use App\Models\Icd;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Search\Searchdaycare;
use App\Http\Controllers\Excel\ExportExcelController;
use App\Models\Fluid;
use App\Http\library\SiteHelpers;
use App\Models\Masters\RespiratoryIndication;
use App\Models\Search\SearchQueryLog;
use App\Models\Masters\AntibioticMaster;
use Illuminate\Support\Str;

class SearchDaycareController extends Controller
{

  public function __construct(Guard $auth, Searchdaycare $searchDaycare, ExportExcelController $export) 
  {

    $this->auth            =     $auth;
    $this->searchDaycare   =     $searchDaycare;
    $this->export          =     $export;

}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id = 0)
    {
        $input = $request->all();
        $page = !empty($input['page']) ? $input['page'] : 1;
        $limit = 10;
        $order['sortby'] = 'id';
        $order['sortorder'] = 'desc';
        $last = false;

        if ($page == 1 && isset($input['query_log_id']) && empty($input['query_log_id']))
        {
            $tempResults = $this->searchDaycare->getList($page, $limit, $input, $order);
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
            $tempResults['count'] = $input['daycare_count'];
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
            return redirect(action('Search\SearchDaycareController@create'))->with('Success', 'No record found');
        }
        $daycare_ids = $tempResults->unique('DayId')->pluck('DayId')->toArray();

        if ($last) {
            $daycare_ids_count = count($daycare_ids)-1;
            $current_id = isset($daycare_ids[$daycare_ids_count]) ? $daycare_ids[$daycare_ids_count] : 0;
        } else {
            $current_id = isset($daycare_ids[0]) ? $daycare_ids[0] : 0;
        }

        $daycare_last = $this->setPrevnext($daycare_ids, $current_id, json_encode($daycare_ids), $count, $query_log_id, $page, $very_first, $very_last);

        return redirect(action('Search\SearchDaycareController@daycareSearchview', \SiteHelpers::encrypt_id($current_id)) . '?daycare_ids=' . json_encode($daycare_ids) . '&daycare_count=' . $count . '&query_log_id=' . $query_log_id  . '&page=' . $page . '&very_first=' . $very_first . '&very_last=' . $very_last.'&last='.$last.'&last_id='.$current_id);

    }

    public function daycareSearchview(Request $request, $id = 0) 
    {
        $input = $request->all();
        $encrypt_id = $id;
        $id = \SiteHelpers::decrypt_id($id);

        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'nicu_daycare';
        $admission             = \SiteHelpers::prepare_time();

        $baby = array();
        $baby              = $this->searchDaycare->getBabydetails($id);

        $current_id = $id;

        if (!isset($input['daycare_ids']))
        {
            return redirect(action('Search\SearchDaycareController@create'));
        }

        $daycare_ids = json_decode($input['daycare_ids']);
        $daycare_ids = is_array($daycare_ids) ? $daycare_ids : [];
        $count = isset($input['daycare_count']) ? $input['daycare_count'] : 0;

        $query_log_id = isset($input['query_log_id']) ? $input['query_log_id'] : 0;

        $current_page = isset($input['page']) ? $input['page'] : 1;

        $very_first = isset($input['very_first']) ? $input['very_first'] : null;

        $very_last = isset($input['very_last']) ? $input['very_last'] : null;

        $last_id = isset($input['last_id']) ? $input['last_id'] : null;

        $daycare_last = $this->setPrevnext($daycare_ids, $current_id, json_encode($daycare_ids), $count, $query_log_id, $current_page, $very_first, $very_last);
        $tempResults = $this->searchDaycare->getdaycareList($daycare_ids);

        $daycareList = collect($tempResults)->toArray();

        $baby_detail = (object)[];

        $GetICD                = Icd::where('ICDCode', '<>', '')->get();
        $ICD                   = array();
        foreach ($GetICD as $key => $value) {
            $ICD[$value->ICDCode] = $value->ICDDescription . '-' . $value->ICDCode;
        }

        $Doctorslist            =  DoctorMaster::get_lists();
        $DoctorMaster           =  array();
        foreach ($Doctorslist as $doctor) {
            $DoctorMaster[$doctor->id] = $doctor->Name;
        }
        if (isset($baby->baby_id)) {
            $indication = isset($baby->Indication) ? unserialize($baby->Indication) :array();
            $surfactant_indication = isset($baby->surfactant_indication) ? unserialize($baby->surfactant_indication): array();
            $drugs = isset($baby->OtherDrugs) ? unserialize($baby->OtherDrugs):null;
            $NicuICD = isset($baby->NicuICD) ? json_decode($baby->NicuICD):[];
            foreach ($NicuICD as $key => $value) {
              $baby->$key = $value;
            }
            $organism = isset($baby->Organism) ? unserialize($baby->Organism):null;
            $products = $this->searchDaycare->getProduct($baby->baby_id, $baby->AdmissionId);
            $antibiotic = $this->searchDaycare->getAntibiotics($baby->baby_id, $baby->AdmissionId);
        }

        return view('search.daycaresearch.search', compact('baby', 'NicuICD','antibiotic','drugs','organism','surfactant_indication','indication','current_id', 'searchOption', 'babyList', 'tempResults', 'SubmitButtonText', 'dayIds', 'DoctorMaster', 'ICD', 'admission', 'silabingsdays', 'products', 'navigate', 'daycareList', 'id', 'very_first', 'very_last', 'current_page', 'count', 'encrypt_id', 'query_log_id', 'daycare_ids', 'daycare_last', 'last_id'));
    }

    public function daycareListview(Request $request, $id = 0)
    {
        $id = \SiteHelpers::decrypt_id($id);

        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'nicu_daycare';

        $baby = array();

        $dayIds              = unserialize(\Session::get('dayIds'));


        $daycareListheadings = Config('exportfields.daycare');

        $daycareListheadings = collect($daycareListheadings);

        $daycareListheadings = $daycareListheadings->forget(['BabyName','BMrNo'])->toArray();

        $daycareHeadclass = array_keys($daycareListheadings);

        foreach ($daycareHeadclass as $headKey => $headValue) {
            $daycareHeadclass[$headValue] = trim($headValue);
            unset($daycareHeadclass[$headKey]);
        }

        $current_id = $id;

        $daycareList         = $this->searchDaycare->getdaycareListview($dayIds);

        foreach ($daycareList as $key1 => &$daycareRecords) {

            $daycareRecords->F_Product = '';
            $daycareRecords->F_Volume = '';

            $daycareRecords->A_Antibiotic = '';
            $daycareRecords->A_Day = '';

            foreach ($daycareRecords as $key => &$daycareRecord) {

                if (!in_array($key, Config('exportfields.daycareFieldmodifier.differentType')) && !in_array($key, Config('exportfields.daycareFieldmodifier.toggleType')) && !in_array($key, Config('exportfields.daycareFieldmodifier.toggleTypesecond')) && !in_array($key, Config('exportfields.daycareFieldmodifier.differentSelect')) && !in_array($key, Config('exportfields.daycareFieldmodifier.selectMore')) && !in_array($key, Config('exportfields.daycareFieldmodifier.toggleTypeThird'))) {

                    $daycareList[$key1]->$key = trim(strip_tags(preg_replace('/[\n\r\t]/', ' ', $daycareRecord)));                        

                } elseif (in_array($key, Config('exportfields.daycareFieldmodifier.differentType'))) {

                    switch ($key) {
                        case 'DayTime':

                        $daycareRecords->DayTime_MINS = (strlen($daycareRecords->DayTime_MINS) == 1) ? '0'.$daycareRecords->DayTime_MINS : $daycareRecords->DayTime_MINS;

                        $daycareRecords->DayTime      = (strlen($daycareRecords->DayTime) == 1) ? '0'.$daycareRecords->DayTime : $daycareRecords->DayTime; 

                        $daycareList[$key1]->$key     = $daycareRecords->DayTime.':'.$daycareRecords->DayTime_MINS.':'.trim($daycareRecords->DayTime_AM); 

                        break;

                        case 'Indication':
                        $temp_indication = $daycareRecord;
                        if (\SiteHelpers::is_serialized($temp_indication)) {
                            $daycareList[$key1]->$key = "";
                            foreach (unserialize($temp_indication) as $daycare_key => $daycare_value) {
                                $respiratory_name = is_object(RespiratoryIndication::getName($daycare_value)) ? RespiratoryIndication::getName($daycare_value)->respiratory_name : '';
                                if (array_key_exists($key, (array)$daycareList[$key1]) && $daycareList[$key1]->$key != '') {
                                    $daycareList[$key1]->$key = $daycareList[$key1]->$key.', '.$respiratory_name;
                                } else {
                                    $daycareList[$key1]->$key = $respiratory_name;
                                }
                            }
                        }
                        $daycareList[$key1]->$key = isset($daycareList[$key1]->$key) ? $daycareList[$key1]->$key : '';
                        break;  

                        case 'surfactant_indication':
                        $temp_indication = $daycareRecord;
                        if (\SiteHelpers::is_serialized($temp_indication)) {
                            $daycareList[$key1]->$key = "";
                            foreach (unserialize($temp_indication) as $daycare_key => $daycare_value) {
                                $respiratory_name = is_object(RespiratoryIndication::getName($daycare_value)) ? RespiratoryIndication::getName($daycare_value)->respiratory_name : '';
                                if (array_key_exists($key, (array)$daycareList[$key1]) && $daycareList[$key1]->$key != '') {
                                    $daycareList[$key1]->$key = $daycareList[$key1]->$key.', '.$respiratory_name;
                                } else {
                                    $daycareList[$key1]->$key = $respiratory_name;
                                }
                            }
                        }
                        $daycareList[$key1]->$key = isset($daycareList[$key1]->$key) ? $daycareList[$key1]->$key : '';
                        break; 

                        case 'NicuICD':

                        $icd_temp = (array)json_decode($daycareRecord);
                        foreach ($icd_temp as $icd_key => $icd_value) {
                            foreach ($icd_value as $key => $value) {
                                if (array_key_exists($icd_key, $daycareList[$key1]) && $daycareList[$key1]->$icd_key != '') {
                                    $daycareList[$key1]->$icd_key = $daycareList[$key1]->$icd_key.', '.\DB::table('icd')->select('ICDDescription')->where('ICDCode', $value)->first()->ICDDescription;
                                } else {
                                    $daycareList[$key1]->$icd_key = \DB::table('icd')->select('ICDDescription')->where('ICDCode', $value)->first()->ICDDescription;                                      
                                }
                            }
                            $daycareList[$key1]->$icd_key = isset($daycareList[$key1]->$icd_key) ? $daycareList[$key1]->$icd_key : '';
                        }

                        break;                               

                        default:
                        $tempFields[$record] = ""; 
                        break;

                    }

                } elseif (in_array($key, Config('exportfields.daycareFieldmodifier.toggleType'))) {

                    $daycareList[$key1]->$key = $daycareRecord == 2 ? 'Yes' : 'No' ;

                } elseif (in_array($key, Config('exportfields.daycareFieldmodifier.toggleTypesecond'))) {

                    $daycareList[$key1]->$key = $daycareRecord == 1 ? 'Yes' : 'No' ;

                } elseif (in_array($key, Config('exportfields.daycareFieldmodifier.toggleTypeThird'))) {

                    $daycareList[$key1]->$key = $daycareRecord == 2 ? 'Performed' : 'Not Performed';

                }    elseif (in_array($key, Config('exportfields.daycareFieldmodifier.differentSelect'))) {

                    switch ($key) {
                        case 'Frequency':
                        $daycareList[$key1]->$key = \ValuelistHelpers::frequencyList($daycareRecord);                                    
                        break;
                        case 'pphn_treatement':
                        if (!empty($daycareRecord)) {
                            $daycareList[$key1]->$key = \ValuelistHelpers::getPphntreatement($daycareRecord);                                    
                        }
                        break;
                        case 'StoolNature':
                        if (!empty($daycareRecord)) {
                            $daycareList[$key1]->$key = \ValuelistHelpers::stoolNature($daycareRecord);
                            $daycareList[$key1]->$key = str_replace(' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ', ' ', $daycareList[$key1]->$key);
                        } else {
                            $daycareList[$key1]->$key = "";                              
                        }                                 
                        break;
                        case 'NNJTreatment':
                        $nnjtreatment = [''=>'N/A','None'=>'None','Phototherapy' => "Photo &#8478;","Exchange transfusion"=>"Exchange &#8478;"];
                        $daycareList[$key1]->$key = $nnjtreatment[$daycareRecord];
                        break;
                    }

                } elseif (in_array($key, Config('exportfields.daycareFieldmodifier.selectMore'))) {

                    switch ($key) {
                        case 'F_Product':
                        $products = $this->searchDaycare->getProduct($daycareRecords->BabyId, $daycareRecords->AdmissionId)->pluck('Product')->toArray();
                        if (count($products) > 1) {
                            $daycareList[$key1]->$key = implode(', ', $products);
                        }
                        $daycareList[$key1]->$key = isset($daycareList[$key1]->$key) ? $daycareList[$key1]->$key : '';
                        break;
                        case 'F_Volume':
                        $volume = $this->searchDaycare->getProduct($daycareRecords->BabyId, $daycareRecords->AdmissionId)->pluck('Volume')->toArray();
                        if (count($volume) > 1) {
                            $daycareList[$key1]->$key = implode(', ', $volume);
                        }
                        $daycareList[$key1]->$key = isset($daycareList[$key1]->$key) ? $daycareList[$key1]->$key : '';
                        break;
                        case 'A_Antibiotic':
                        $antibiotic = $this->searchDaycare->getAntibiotics($daycareRecords->BabyId, $daycareRecords->AdmissionId)->pluck('Antibiotic');
                        foreach ($antibiotic as $antibiotic_key => $antibiotic_value) {
                            $antibiotic_name = is_object(AntibioticMaster::getName($antibiotic_value)) ? AntibioticMaster::getName($antibiotic_value)->Name : '';
                            if (array_key_exists($key, $daycareList[$key1]) && $daycareList[$key1]->$key != '') {
                                $daycareList[$key1]->$key = $daycareList[$key1]->$key.', '.$antibiotic_name;
                            } else {
                                $daycareList[$key1]->$key = $antibiotic_name;
                            }
                        }                             
                        $daycareList[$key1]->$key = isset($daycareList[$key1]->$key) ? $daycareList[$key1]->$key : '';
                        break;
                        case 'A_Day':
                        $antibioticday = $this->searchDaycare->getAntibiotics($daycareRecords->BabyId, $daycareRecords->AdmissionId)->pluck('Day')->toArray();
                        if (count($antibioticday) > 1) {
                            $daycareList[$key1]->$key = implode(', ', $antibioticday);
                        }
                        $daycareList[$key1]->$key = isset($daycareList[$key1]->$key) ? $daycareList[$key1]->$key : '';
                        break;
                        case 'OtherDrugs':
                        if (\SiteHelpers::is_serialized($daycareRecord)) {
                            $daycareList[$key1]->$key = implode(', ', unserialize($daycareRecord));
                        }
                        $daycareList[$key1]->$key = isset($daycareList[$key1]->$key) ? $daycareList[$key1]->$key : '';
                        break;
                        case 'Organism':
                        if (\SiteHelpers::is_serialized($daycareRecord)) {
                            $daycareList[$key1]->$key = implode(', ', unserialize($daycareRecord));
                        }
                        $daycareList[$key1]->$key = isset($daycareList[$key1]->$key) ? $daycareList[$key1]->$key : '';
                        break;
                    }

                }
            }

        }

        if ($request->ajax()) {
            $tableresultssecound   = view('search.daycaresearch.searchlist', compact('daycareList', 'daycareHeadclass'))->render();
            return \Response::json(['tableresultssecond'=>$tableresultssecound], 200);

        }

        return view('search.daycaresearch.searchlistview', compact('baby', 'current_id', 'daycareListheadings', 'daycareHeadclass', 'daycareList', 'navigate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'nicu_daycare';

        $baby = array();

        (\Session::has('dayIds')) ? \Session::forget('dayIds') : '';
        (\Session::has('record')) ? \Session::forget('record') : '';
        (\Session::has('babyList')) ? \Session::forget('babyList') : '';


        $SubmitButtonText = "Search";
        $admission =\SiteHelpers::prepare_time();

        $GetICD = Icd::where('ICDCode', '<>', '')->get();

        $ICD = array();
        foreach ($GetICD as $key => $value) {
            $ICD[$value->ICDCode] = $value->ICDDescription . '-' . $value->ICDCode;

        }
        $Doctorslist=DoctorMaster::get_lists();
        $DoctorMaster=array();
        foreach ($Doctorslist as $doctor) {
            $DoctorMaster[$doctor->id]=$doctor->Name;
        }

        $searchOption = true;

        return view('search.daycaresearch.search', compact('baby', 'searchOption', 'SubmitButtonText', 'DoctorMaster', 'ICD', 'admission', 'navigate'));
    }

    /**
     * This method get previous and next method
     *
     *@param $abbreviated list type array of object
     *@param $current_id type integer
     *@return $pages or 0
     */
    public function setPrevnext($daycare_list, $current_id, $daycare_ids, $count, $query_log_id, $current_page, $very_first, $very_last)
    {
        if (is_array($daycare_list) && !empty($current_id))
        {
            $key = array_search($current_id, $daycare_list);
            $prev = $key - 1;
            $next = $key + 1;
            $daycarepages[0] = (array_key_exists($prev, $daycare_list)) ? $daycare_list[$prev] : '';
            $daycarepages[1] = (array_key_exists($next, $daycare_list)) ? $daycare_list[$next] : '';

            $next_page = $current_page + 1;
            $prev_page = $current_page - 1;

            $one_page_last = false;

            if (isset($daycare_list[0]) && $daycare_list[0] == $current_id) {
                $one_page_last = true;
            }

            $daycarepages[0] = !empty($daycarepages[0]) ? action('Search\SearchDaycareController@daycareSearchview', \SiteHelpers::encrypt_id($daycarepages[0]) . '?daycare_ids=' . $daycare_ids . '&daycare_count=' . $count.'&page='.$current_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last) : action('Search\SearchDaycareController@index', \SiteHelpers::encrypt_id($daycarepages[1]) . '?daycare_count=' . $count.'&page='.$prev_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last . '&one_page_last=' . $one_page_last);
            
            $daycarepages[1] = !empty($daycarepages[1]) ? action('Search\SearchDaycareController@daycareSearchview', \SiteHelpers::encrypt_id($daycarepages[1]) . '?daycare_ids=' . $daycare_ids . '&daycare_count=' . $count.'&page='.$current_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last) : action('Search\SearchDaycareController@index', \SiteHelpers::encrypt_id($daycarepages[1]) . '?daycare_count=' . $count.'&page='.$next_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last);
            return $daycarepages;
        }
        return 0;
    }


    private function setBabydaycare($daycareList) 
    {

        $babyList = array();


        foreach ($daycareList as $dcList) {
            $babyList[$dcList->baby_id][$dcList->AdmissionId][$dcList->DayId] = array($dcList->DayId);

        }

        return  $babyList;
    }

    public function daycareListdownload(Request $request)
    {

        $input = $request->all();


          //Get the daycare ids from sessions  

        $last_query = SearchQueryLog::findOrfail($input['query_log_id']);

        $last_query['bindings'] = explode(',', $last_query['bindings']);

        $length = count($last_query['bindings']);
        $old_limit = 'limit ' . str_replace("'", "", $last_query['bindings'][$length - 2]);
        $old_offset = 'offset ' . str_replace("'", "", $last_query['bindings'][$length - 1]);

        $last_query['query'] = str_replace($old_limit, '', $last_query['query']);
        $last_query['query'] = str_replace($old_offset, '', $last_query['query']);

        $temp = Str::replaceArray('?', $last_query['bindings'], $last_query['query']);
        $results = \DB::select($temp);
        $id = collect($results)->pluck('DayId')->toArray();


          // Get the headings from config/exportfields file
        $tempHeading = Config('exportfields.daycare');

         // Fetch the record for daycare 
        $results     = $this->searchDaycare->getdaycareDownloadList($id);

         // Convert the record from array of object to array  
        $results     = \SiteHelpers::convert_obj_to_array($results->toArray());

         // Declare variable array for array of dataList
        $dataList     = array();

        // convert filtered fileld names from json to array 

        $export_list = $request->input('daycare_export_list');
        $export_list = json_decode($export_list);
        krsort($export_list);
        $fields = $export_list;

        // formate and splite the daycare records based on filtered list  
        foreach ($results as $daycareList) {

            $tempFields = array();

            foreach ($fields as $record) {

                if (isset($daycareList[$record]) && !in_array($record, Config('exportfields.daycareFieldmodifier.differentType')) && !in_array($record, Config('exportfields.daycareFieldmodifier.toggleType')) && !in_array($record, Config('exportfields.daycareFieldmodifier.toggleTypesecond')) && !in_array($record, Config('exportfields.daycareFieldmodifier.differentSelect')) && !in_array($record, Config('exportfields.daycareFieldmodifier.selectMore')) && !in_array($record, Config('exportfields.daycareFieldmodifier.toggleTypeThird'))) {

                    $daycareList[$record] = trim(strip_tags(preg_replace('/[\n\r\t]/', ' ', $daycareList[$record])));

                    if ($record == 'DOB' || $record == 'DayDate') {
                        $tempFields[$record] = date('d-m-Y', strtotime($daycareList[$record])); 
                    } else {
                        $tempFields[$record] = $daycareList[$record]; 
                    }

                } elseif (in_array($record, Config('exportfields.daycareFieldmodifier.differentType'))) {

                    switch ($record) {
                        case 'DayTime':

                        $daycareList['DayTime_MINS'] = (strlen($daycareList['DayTime_MINS']) == 1) ? '0'.$daycareList['DayTime_MINS'] : $daycareList['DayTime_MINS'];

                        $daycareList['DayTime']      = (strlen($daycareList['DayTime']) == 1) ? '0'.$daycareList['DayTime'] : $daycareList['DayTime']; 

                        $tempFields[$record]         = $daycareList['DayTime'].':'.$daycareList['DayTime_MINS'].':'.trim($daycareList['DayTime_AM']); 

                        break;

                        case 'Indication':

                        if (\SiteHelpers::is_serialized($daycareList[$record])) {
                            foreach (unserialize($daycareList[$record]) as $key => $value) {
                                $respiratory_name = is_object(RespiratoryIndication::getName($value)) ? RespiratoryIndication::getName($value)->respiratory_name : '';
                                if (array_key_exists($record, $tempFields) && $tempFields[$record] != '') {
                                    $tempFields[$record] = $tempFields[$record].', '.$respiratory_name;
                                } else {
                                    $tempFields[$record] = $respiratory_name;
                                }
                            }
                        }

                        $tempFields[$record] = isset($tempFields[$record]) ? $tempFields[$record] : '';

                        break;  

                        case 'surfactant_indication':

                        if (\SiteHelpers::is_serialized($daycareList[$record])) {
                            foreach (unserialize($daycareList[$record]) as $key => $value) {
                                $respiratory_name = is_object(RespiratoryIndication::getName($value)) ? RespiratoryIndication::getName($value)->respiratory_name : '';
                                if (array_key_exists($record, $tempFields) && $tempFields[$record] != '') {
                                    $tempFields[$record] = $tempFields[$record].', '.$respiratory_name;
                                } else {
                                    $tempFields[$record] = $respiratory_name;
                                }
                            }
                        }

                        $tempFields[$record] = isset($tempFields[$record]) ? $tempFields[$record] : '';

                        break;  

                        case 'NicuICD':

                        $icd_temp = (array)json_decode($daycareList[$record]);
                        foreach ($icd_temp as $icd_key => $icd_value) {
                            foreach ($icd_value as $key => $value) {
                                if (array_key_exists($icd_key, $tempFields) && $tempFields[$icd_key] != '') {
                                    $tempFields[$icd_key] = $tempFields[$icd_key].', '.\DB::table('icd')->select('ICDDescription')->where('ICDCode', $value)->first()->ICDDescription;
                                } else {
                                    $tempFields[$icd_key] = \DB::table('icd')->select('ICDDescription')->where('ICDCode', $value)->first()->ICDDescription;                                      
                                }
                            }
                        }

                        break;                               

                        default:
                        $tempFields[$record] = ""; 
                        break;
                    }


                } elseif (in_array($record, Config('exportfields.daycareFieldmodifier.toggleType'))) {

                    $tempFields[$record] = $daycareList[$record] == 2 ? 'Yes' : 'No' ;

                } elseif (in_array($record, Config('exportfields.daycareFieldmodifier.toggleTypesecond'))) {

                    $tempFields[$record] = $daycareList[$record] == 1 ? 'Yes' : 'No' ;

                } elseif (in_array($record, Config('exportfields.daycareFieldmodifier.toggleTypeThird'))) {

                    $tempFields[$record] = $daycareList[$record] == 2 ? 'Performed' : 'Not Performed';

                }  elseif (in_array($record, Config('exportfields.daycareFieldmodifier.differentSelect'))) {

                    switch ($record) {
                        case 'Frequency':
                        $tempFields[$record] = \ValuelistHelpers::frequencyList($daycareList[$record]);                                    
                        break;
                        case 'pphn_treatement':
                        $tempFields[$record] = \ValuelistHelpers::getPphntreatement($daycareList[$record]);                                    
                        break;
                        case 'StoolNature':
                        if (!empty($daycareList[$record])) {
                            $tempFields[$record] = \ValuelistHelpers::stoolNature($daycareList[$record]);
                            $tempFields[$record] = str_replace(' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ', ' ', $tempFields[$record]);
                        } else {
                            $tempFields[$record] = "";                              
                        }                                 
                        break;
                        case 'NNJTreatment':
                        $nnjtreatment = [''=>'N/A','None'=>'None','Phototherapy' => "Photo &#8478;","Exchange transfusion"=>"Exchange &#8478;"];
                        $tempFields[$record] = $nnjtreatment[$daycareList[$record]];
                        break;
                    }

                } elseif (in_array($record, Config('exportfields.daycareFieldmodifier.selectMore'))) {

                    switch ($record) {
                        case 'F_Product':
                        $products = $this->searchDaycare->getProduct($daycareList['BabyId'], $daycareList['AdmissionId'])->pluck('Product')->toArray();
                        if (count($products) > 1) {
                            $tempFields[$record] = implode(', ', $products);
                        } else {
                            $tempFields[$record] = $products;                                
                        }
                        $tempFields[$record] = isset($tempFields[$record]) ? $tempFields[$record] : '';
                        break;
                        case 'F_Volume':
                        $volume = $this->searchDaycare->getProduct($daycareList['BabyId'], $daycareList['AdmissionId'])->pluck('Volume')->toArray();
                        if (count($volume) > 1) {
                            $tempFields[$record] = implode(', ', $volume);
                        } else {
                            $tempFields[$record] = $volume;                                
                        }
                        $tempFields[$record] = isset($tempFields[$record]) ? $tempFields[$record] : '';
                        break;
                        case 'A_Antibiotic':
                        $antibiotic = $this->searchDaycare->getAntibiotics($daycareList['BabyId'], $daycareList['AdmissionId'])->pluck('Antibiotic');
                        foreach ($antibiotic as $key => $value) {
                            $antibiotic_name = is_object(AntibioticMaster::getName($value)) ? AntibioticMaster::getName($value)->Name : '';
                            if (array_key_exists($record, $tempFields) && $tempFields[$record] != '') {
                                $tempFields[$record] = $tempFields[$record].', '.$antibiotic_name;
                            } else {
                                $tempFields[$record] = $antibiotic_name;
                            }
                        }                             
                        $tempFields[$record] = isset($tempFields[$record]) ? $tempFields[$record] : '';
                        break;
                        case 'A_Day':
                        $antibioticday = $this->searchDaycare->getAntibiotics($daycareList['BabyId'], $daycareList['AdmissionId'])->pluck('Day')->toArray();
                        if (count($antibioticday) > 1) {
                            $tempFields[$record] = implode(', ', $antibioticday);
                        } else {
                            $tempFields[$record] = $antibioticday;                                
                        }
                        $tempFields[$record] = isset($tempFields[$record]) ? $tempFields[$record] : '';
                        break;
                        case 'OtherDrugs':
                        if (\SiteHelpers::is_serialized($daycareList[$record])) {
                            $tempFields[$record] = array_filter(unserialize($daycareList[$record]));
                        }
                        $mas = [];
                        if (is_numeric(implode("",$tempFields[$record]))) {
                            $mas = \DB::table('mas_drugivfluid')->selectRaw('brand_name|| \'/\' ||generic_pharmacological_name as name')->whereIn('id', $tempFields[$record])->pluck('name')->toArray();
                            $tempFields[$record] = count($tempFields[$record]) > 0 ? implode(', ', $mas) : '';
                        } else {
                            $tempFields[$record] = count($tempFields[$record]) > 0 ? implode(', ', $tempFields[$record]) : '';
                        }
                        break;
                        case 'Organism':
                        if (\SiteHelpers::is_serialized($daycareList[$record])) {
                            $tempFields[$record] = implode(', ', unserialize($daycareList[$record]));
                        }
                        $tempFields[$record] = isset($tempFields[$record]) ? $tempFields[$record] : '';
                        break;
                    }

                } else {
                    $tempFields[$record] = ""; 

                }

            }

            $dataList[] = $tempFields;   

        }  

        // Declare variable for array of headings 
        $headingList = array();

        foreach ($fields as $fieldsValue) {
            if ($fieldsValue != 'NicuICD') {
                $headingList[] = $tempHeading[$fieldsValue];
            }
        }
        $this->export->setFilename($input['file_name']); 
        $this->export->setFileformat($input['file_format']);  


        return $this->export->exportFile($dataList, $headingList);

    }


}
