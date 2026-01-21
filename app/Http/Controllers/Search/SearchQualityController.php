<?php

namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Search\SearchQuality;
use App\Http\Controllers\Excel\ExportExcelController;
use App\Http\Library\QualityHelpers;

class SearchQualityController extends Controller
{
    /**
     * This method class construct
     *
     *@param $searchQuality
     */
    public function __construct(SearchQuality $searchQuality, ExportExcelController $export)
    {
        $this->searchQuality = $searchQuality;
        $this->export        = $export;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $input         =  $request->all();

        if (count($input) > 1) {
            (\Session::has('qualitysearchdata')) ?   \ Session::forget('qualitysearchdata') :  '';
            \Session::put('qualitysearchdata', $input);
        } else {
            $input = \Session::get('qualitysearchdata');
        }

        (\Session::has('qualitycurrentpage')) ?  \Session::forget('qualitycurrentpage') :  '';
        $page = !empty($request->input('page')) ? $request->input('page') : 1;
        \Session::put('qualitycurrentpage', $page);

        (\Session::has('quality_ids'))    ?   \Session::forget('quality_ids')     :  '' ;
        (\Session::has('quality_recod')) ?   \ Session::forget('quality_recod') :  '';
        (\Session::has('quality_count')) ?   \ Session::forget('quality_count') :  '';

        $limit = 10;
        $order['sortby'] = 'id';
        $order['sortorder'] = 'desc';

        $tempResults  = $this->searchQuality->getList($page, $limit, $input, $order);

        $tempResults['count'] = isset($tempResults['count']) ? $tempResults['count'] : 0;
        $tempResults['data'] = isset($tempResults['data']) ? $tempResults['data'] : [];
        
        \Session::put('quality_count', $tempResults['count']);
        $tempResults  =  $tempResults['data'];

        $tempResults  = collect($tempResults);

        // $tempResults  = collect($this->searchQuality->getList($input))->unique("id"); 
        // $tempResults  = collect($tempResults);

        $results      = $tempResults->first();

        if ($tempResults->count() == 0) {
            return redirect(action('Search\SearchQualityController@create'))
                       ->withInput()->with('Success', 'No record found');
        }

        $tempResults       = $tempResults->sort();
             
        $baby              = $tempResults->first();

        $current_id        = isset($baby->id) ? $baby->id : 0 ;

        $quality_ids       = $tempResults->pluck('id')->toArray(); 

        \Session::put('quality_ids', serialize($quality_ids));

       return redirect(action('Search\SearchQualityController@qualitysearchview', \SiteHelpers::encrypt_id($current_id)));
    }

    public function qualitysearchview($id)
    {
        $id = \SiteHelpers::decrypt_id($id);

        $baby              = array();

        $SubmitButtonText  = "Search";

        $baby              = $this->searchQuality->getBabydetails($id);

        // $current_id        = $baby->id;
        $current_id        = $id;

        $quality_ids       = unserialize(\Session::get('quality_ids'));

        $tempResults       = $this->searchQuality->getQualityList($quality_ids); 

        $tempResults       = collect($tempResults);
        $tempResults       = $tempResults->sort();

        //This get current record number
        \Session::put('record', array_search($current_id, $quality_ids)+1);
        \Session::put('babyList', \Session::get('babyList'));

        if (isset($tempResults) && count($tempResults) > 0) {
                $babyList          = $this->setQualitySheet($tempResults);
                \Session::put('babyList', $babyList);
        }

        $silabingsdays =  $this->setPrevnext($quality_ids, $current_id);

        $baby->gestation_weeks = json_decode($baby->gestation)->g_weeks;
        $baby->gestation_days  = json_decode($baby->gestation)->g_days;
        $baby->dob             = isset($baby->dob) ? date('d-m-Y', strtotime($baby->dob)) : null;
        $baby->tob             = isset($baby->tob) ? date('h:i a', strtotime($baby->tob)) : null;

        $navigate['main_nav'] = 'quality_indicator';
        $navigate['sub_nav']  = 'quality_indicator';
        
        return view('search.qualitysearch.search',compact('baby', 'silabingsdays', 'navigate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $baby =array();

        \Session::forget('babyList');
        \Session::forget('record');
      
        $navigate['main_nav'] = 'quality_indicator';
        $navigate['sub_nav']  = 'quality_indicator';
        return view('search.qualitysearch.search',compact('baby', 'navigate'));
    }

    /**
     * This method get previous and next method 
     *
     * @param $quality_ids type array of object
     * @param $current_id type integer
     * @return $daypages or 0 
     */
    public function setPrevnext($quality_ids, $current_id)
    {
        if (is_array($quality_ids) && !empty($current_id)) {

            $key         = array_search($current_id, $quality_ids);
            $prev        = $key-1;
            $next        = $key+1;
            $daypages[0] = (array_key_exists($prev, $quality_ids)) ? $quality_ids[$prev] : '';
            $daypages[1] = (array_key_exists($next, $quality_ids)) ? $quality_ids[$next] : '';
            $daypages[0] = !empty($daypages[0]) ? action('Search\SearchQualityController@qualitysearchview', \SiteHelpers::encrypt_id($daypages[0])) : '' ;
            $daypages[1] = !empty($daypages[1]) ? action('Search\SearchQualityController@qualitysearchview', \SiteHelpers::encrypt_id($daypages[1])) : '' ;
            $daypages['first'] = !empty($daypages[0]) ? action('Search\SearchQualityController@qualitysearchview', \SiteHelpers::encrypt_id(collect($quality_ids)->first())) : '' ;
            $daypages['last'] = !empty($daypages[1]) ? action('Search\SearchQualityController@qualitysearchview', \SiteHelpers::encrypt_id(collect($quality_ids)->last())) : '' ;
            return $daypages;
        }
        return 0;
    }

    private function setQualitySheet($temp_results) 
    {
        $neonatal_list = array();

        foreach ($temp_results as $result_key => $result_value) {
            $temp_list['id'] = $result_value->id;
            $temp_list['baby_name']  = $result_value->name.' - '.$result_value->mr_number;
            $quality_list[]         = $temp_list;             
        }
        return  $quality_list;
    }

    public function qualityListdownload(Request $request)
    {
        $input       = $request->all();

        //Get the quality ids from sessions  
        $qualityIds  = unserialize(\Session::get('quality_ids'));

        // Get the headings from config/exportfields file
        $tempHeading = Config('exportfields.quality_export');

        // Fetch the record for daycare 
        $results     = $this->searchQuality->getQualityList($qualityIds);

        // Convert the record from array of object to array  
        $results     = \SiteHelpers::convert_obj_to_array($results->toArray());

        // Declare variable array for array of dataList
        $dataList    = array();

        // convert filtered fileld names from json to array 
        $export_list = $request->input('quality_export_list');
        $export_list = json_decode($export_list);
        krsort($export_list);
        $fields = $export_list;

        // formate and splite the daycare records based on filtered list  
        foreach ($results as $qualityList) {
            $tempFields = array();
            foreach ($fields as $record) {                     
                if (isset($qualityList[$record])) {
                    $tempFields[$record] = $qualityList[$record]; 
                    if ($record == 'fetalcause') {
                        $tempFields[$record] = QualityHelpers::GetFetalCause($qualityList[$record]);
                    } elseif ($record == 'maternalcause') {
                        $tempFields[$record] = QualityHelpers::GetMaternalCause($qualityList[$record]);
                    } elseif ($record == 'max_grade_rt' || $record == 'max_grade_lt') {
                        $tempFields[$record] = QualityHelpers::GetMaxgrade($qualityList[$record]);
                    } elseif ($record == 'nec_max_stage') {
                        $tempFields[$record] = QualityHelpers::GetMaxStage($qualityList[$record]);                   
                    } elseif ($record == 'indication_of_admission') {
                        $qualityList[$record] = isset($qualityList[$record]) ? json_decode($qualityList[$record]) : [];
                        foreach ($qualityList[$record] as $key => $value) {
                            $qualityTempList[$record][] = QualityHelpers::GetAdmissionIndication($value);
                        }
                        $tempFields[$record] = isset($qualityTempList[$record]) ? implode(',', $qualityTempList[$record]) : null;
                    } elseif ($record == 'sepsis_in_mother_type') {
                        $qualityList[$record] = isset($qualityList[$record]) ? json_decode($qualityList[$record]) : [];
                        foreach ($qualityList[$record] as $key => $value) {
                            $qualityTempList[$record][] = QualityHelpers::GetSepsisMotherType($value);
                        }
                        $tempFields[$record] = isset($qualityTempList[$record]) ? implode(',', $qualityTempList[$record]) : null;
                    }  elseif ($record == 'surfactant_type') {
                        $qualityList[$record] = isset($qualityList[$record]) ? json_decode($qualityList[$record]) : [];
                        foreach ($qualityList[$record] as $key => $value) {
                            $qualityTempList[$record][] = QualityHelpers::GetSurfactantType($value);
                        }
                        $tempFields[$record] = isset($qualityTempList[$record]) ? implode(',', $qualityTempList[$record]) : null;
                    } elseif ($record == 'spesis_type') {
                        $qualityList[$record] = isset($qualityList[$record]) ? json_decode($qualityList[$record]) : [];
                        foreach ($qualityList[$record] as $key => $value) {
                            $qualityTempList[$record][] = QualityHelpers::GetSepsisType($value);
                        }
                        $tempFields[$record] = isset($qualityTempList[$record]) ? implode(',', $qualityTempList[$record]) : null;
                    } elseif ($record == 'central_line_type') {
                        $qualityList[$record] = isset($qualityList[$record]) ? json_decode($qualityList[$record]) : [];
                        foreach ($qualityList[$record] as $key => $value) {
                            $qualityTempList[$record][] = QualityHelpers::GetCentralLine($value);
                        }
                        $tempFields[$record] = isset($qualityTempList[$record]) ? implode(',', $qualityTempList[$record]) : null;
                    } elseif ($record == 'case_death') {
                        $qualityList[$record] = isset($qualityList[$record]) ? json_decode($qualityList[$record]) : [];
                        foreach ($qualityList[$record] as $key => $value) {
                            $qualityTempList[$record][] = QualityHelpers::GetCaseofDeath($value);
                        }
                        $tempFields[$record] = isset($qualityTempList[$record]) ? implode(',', $qualityTempList[$record]) : null;
                    }
                }
            }
            $dataList[] = $tempFields;   
        }

        // Declare variable for array of headings 
        $headingList = array();

        foreach ($fields as $fieldsValue) {
            $headingList[] = $tempHeading[$fieldsValue];
        }

        $this->export->setFilename($input['file_name']); 
        $this->export->setFileformat($input['file_format']);      

        return $this->export->exportFile($dataList, $headingList);
    }

}












