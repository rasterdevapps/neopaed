<?php

namespace App\Http\Controllers\Fhir;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Fhir\FhirFormatedValues;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Baby;
use App\Models\DischargeLog;
use Excel;

class FhirFormattedValuesController extends Controller
{
    public function __construct(Guard $auth)
    {
        $this->middleware('role:WARD_MANAGEMENT,write', ['only' => ['store', 'update', 'edit', 'create', 'show', 'destroy']]);
        $this->middleware('role:WARD_MANAGEMENT,read', ['only' => ['index', 'printData']]);
        $this->middleware('auth');
        $this->auth = $auth;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
    }

    /** 
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id , $value_type)
    {
        $id = \SiteHelpers::decrypt_id($id);
        
        $fhirdata = FhirFormatedValues::getFhirData($id, trim($value_type));
        // $fhirdata = FhirFormatedValues::find($id);
        return view('fihr.show', compact('fhirdata', 'value_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function monitordata(Request $request)
    {
        $input = $request->all();

        $limit = 10;

        if (!empty($request->input('limit')))
        {
            $request->session()->put('limit', $request->input('limit'));
            $limit = $request->session()->get('limit');
        }
        elseif ($request->session()->has('limit'))
        {
            $limit = $request->session()->get('limit');
        }

        $order['sortby'] = 'result_date_time';
        $order['sortorder'] = 'desc';  

        if (!empty($input['sortby']) && !empty($input['sortorder'])) {
            $order['sortby'] = \SiteHelpers::decrypt_id($input['sortby']);
            $order['sortorder'] = $input['sortorder'];
        }

        $navigate['main_nav'] = 'interface_log';
        $navigate['sub_nav']  = 'interface_monitor';

        //initialize search parameter array 
        $search = array();        

        $input['page'] = isset($input['page']) ? (int)$input['page'] : 1;

        $search['mrno']          = isset($input['mrno']) && !empty($input['mrno']) ? $input['mrno'] : null;
        $search['ipnumber']      = isset($input['ipnumber']) && !empty($input['ipnumber']) ? $input['ipnumber'] : null;
        $search['devicename']    = isset($input['devicename']) && !empty($input['devicename']) && $input['devicename'] != 'N/A' ? $input['devicename'] : null;
        $search['receivetime']   = isset($input['receivetime']) && !empty($input['receivetime']) ? $input['receivetime'] : null;
        $search['low']           = isset($input['low']) && !empty($input['low']) ? $input['low'] : null;
        $search['firstquartile'] = isset($input['firstquartile']) && !empty($input['firstquartile']) ? $input['firstquartile'] : null;
        $search['mean']          = isset($input['mean']) && !empty($input['mean']) ? $input['mean'] : null;
        $search['lastquartile']  = isset($input['lastquartile']) && !empty($input['lastquartile']) ? $input['lastquartile'] : null;
        $search['close']         = isset($input['close']) && !empty($input['close']) ? $input['close'] : null;

        $total = 0;
        $lists = [];

        if ($search['mrno'] != null) {

            $list     = FhirFormatedValues::monitor_get_list($input['page'], $limit, $order, $search);
            $lists    = $list['result'];
            
            $getTotal = FhirFormatedValues::get_monitor_total();
            $total    = $list['total'];

        }

        $page                   = !empty($request->input('page')) ? (int) $request->input('page') : 1;
        $pagecount              = $total > 0 ? ceil($total/$limit) : 0;
        $pagination['total']    = $total;
        $pagination['start']    = (($page-2) < 1) ? 1 : ($page-2);
        $pagination['end']      = ($pagecount < ($page+3)) ? $pagecount :   ($page+3);
        $pagestart              = $total != 0 ? ($page <= 1) ? $page : ($page-1)*$limit + 1 : 0;
        $pagerecords            = ($page == $pagination['end'] || $pagination['total'] <= 0) ? $pagination['total'] : $page*$limit;
        $pagination['limit']    = array($pagestart, $pagerecords);
        $pagination['limits']   = $limit;
        $pagination['previous'] = (($page-1) < 1) ? 1 : ($page-1);
        $pagination['next']     = ($pagecount < ($page+1)) ? $pagecount :   ($page+1);
        
        $pagination['limits'] = $limit;

        return view('fihr.monitor_list',compact('navigate','lists','pagination','search_txt','order', 'search', 'count', 'getTotal'));
    }

    public function ventilatordata(Request $request)
    {
        $input = $request->all();

        $limit = 10;

        if (!empty($request->input('limit')))
        {
            $request->session()->put('limit', $request->input('limit'));
            $limit = $request->session()->get('limit');
        }
        elseif ($request->session()->has('limit'))
        {
            $limit = $request->session()->get('limit');
        }
        $order['sortby'] = 'result_date_time';
        $order['sortorder'] = 'desc';  

        if (!empty($input['sortby']) && !empty($input['sortorder'])) {
            $order['sortby'] = \SiteHelpers::decrypt_id($input['sortby']);
            $order['sortorder'] = $input['sortorder'];
        }

        $navigate['main_nav'] = 'interface_log';
        $navigate['sub_nav']  = 'interface_ventilator';

        //initialize search parameter array 
        $search = array();        

        $input['page'] = isset($input['page']) ? (int)$input['page'] : 1;

        $search['mrno']          = isset($input['mrno']) && !empty($input['mrno']) ? $input['mrno'] : null;
        $search['ipnumber']      = isset($input['ipnumber']) && !empty($input['ipnumber']) ? $input['ipnumber'] : null;
        $search['devicename']    = isset($input['devicename']) && !empty($input['devicename']) && $input['devicename'] != 'N/A' ? $input['devicename'] : null;
        $search['receivetime']   = isset($input['receivetime']) && !empty($input['receivetime']) ? $input['receivetime'] : null;
        $search['low']           = isset($input['low']) && !empty($input['low']) ? $input['low'] : null;
        $search['firstquartile'] = isset($input['firstquartile']) && !empty($input['firstquartile']) ? $input['firstquartile'] : null;
        $search['mean']          = isset($input['mean']) && !empty($input['mean']) ? $input['mean'] : null;
        $search['lastquartile']  = isset($input['lastquartile']) && !empty($input['lastquartile']) ? $input['lastquartile'] : null;
        $search['close']         = isset($input['close']) && !empty($input['close']) ? $input['close'] : null;

        $total = 0;
        $lists = [];

        if ($search['mrno'] != null) {

            $list     = FhirFormatedValues::ventilator_get_list($input['page'], $limit, $order, $search);
            $lists    = $list['result'];

            $getTotal = FhirFormatedValues::get_ventilator_total();
            $total    = $list['total'];

        }

        $page                   = !empty($request->input('page')) ? (int) $request->input('page') : 1;
        $pagecount              = $total > 0 ? ceil($total/$limit) : 0;
        $pagination['total']    = $total;
        $pagination['start']    = (($page-2) < 1) ? 1 : ($page-2);
        $pagination['end']      = ($pagecount < ($page+3)) ? $pagecount :   ($page+3);
        $pagestart              = $total != 0 ? ($page <= 1) ? $page : ($page-1)*$limit + 1 : 0;
        $pagerecords            = ($page == $pagination['end'] || $pagination['total'] <= 0) ? $pagination['total'] : $page*$limit;
        $pagination['limit']    = array($pagestart, $pagerecords);
        $pagination['limits']   = $limit;
        $pagination['previous'] = (($page-1) < 1) ? 1 : ($page-1);
        $pagination['next']     = ($pagecount < ($page+1)) ? $pagecount :   ($page+1);
        
        $pagination['limits'] = $limit;

        return view('fihr.ventilator_list',compact('navigate','lists','pagination','search_txt','order', 'search', 'count', 'getTotal'));
    }

    public function pumpdata(Request $request)
    {
        $input = $request->all();

        $limit = 10;

        if (!empty($request->input('limit')))
        {
            $request->session()->put('limit', $request->input('limit'));
            $limit = $request->session()->get('limit');
        }
        elseif ($request->session()->has('limit'))
        {
            $limit = $request->session()->get('limit');
        }

        $navigate['main_nav'] = 'interface_log';
        $navigate['sub_nav']  = 'interface_prescription';

        $order['sortby'] = 'result_time';
        $order['sortorder'] = 'desc';  

        if (!empty($input['sortby']) && !empty($input['sortorder'])) {
            $order['sortby'] = \SiteHelpers::decrypt_id($input['sortby']);
            $order['sortorder'] = $input['sortorder'];
        }

        //initialize search parameter array 
        $search = array();        

        $input['page'] = isset($input['page']) ? (int)$input['page'] : 1;

        $search['mrno']          = isset($input['mrno']) && !empty($input['mrno']) ? $input['mrno'] : null;
        $search['ipnumber']      = isset($input['ipnumber']) && !empty($input['ipnumber']) ? $input['ipnumber'] : null;
        $search['receivetime']   = isset($input['receivetime']) && !empty($input['receivetime']) ? $input['receivetime'] : null;

        $total = 0;
        $lists = [];

        if ($search['mrno'] != null) {

            $list     = FhirFormatedValues::pump_get_list($input['page'], $limit, $order, $search);
            $lists    = $list['result'];

            $getTotal = FhirFormatedValues::get_pump_total();
            $total    = $list['total'];

        }

        $page                   = !empty($request->input('page')) ? (int) $request->input('page') : 1;
        $pagecount              = $total > 0 ? ceil($total/$limit) : 0;
        $pagination['total']    = $total;
        $pagination['start']    = (($page-2) < 1) ? 1 : ($page-2);
        $pagination['end']      = ($pagecount < ($page+3)) ? $pagecount :   ($page+3);
        $pagestart              = $total != 0 ? ($page <= 1) ? $page : ($page-1)*$limit + 1 : 0;
        $pagerecords            = ($page == $pagination['end'] || $pagination['total'] <= 0) ? $pagination['total'] : $page*$limit;
        $pagination['limit']    = array($pagestart, $pagerecords);
        $pagination['limits']   = $limit;
        $pagination['previous'] = (($page-1) < 1) ? 1 : ($page-1);
        $pagination['next']     = ($pagecount < ($page+1)) ? $pagecount :   ($page+1);
        
        $pagination['limits'] = $limit;

        return view('fihr.pump_list',compact('navigate','lists','pagination','search_txt','order', 'search', 'count', 'getTotal'));
    }

    public static function oraldrugs(Request $request)
    {
        $input = $request->all();
        $baby_mrn = $input['mrn'];
        $ipnumber = $input['ipnumber'];

        $baby_id = Baby::where('BMrNo', $baby_mrn)->first()->BabyId;
        $admission_id = \DB::table('ip_numbers')->where('ip_number', $ipnumber)->first()->AdmissionId;

        $patient_status = DischargeLog::getDischargeDetail($baby_id, $admission_id);

        $prescription_drugs_table = 'prescription_hdr';

        if (count($patient_status) <= 0)
        {
            $prescription_dtl = 'prescription_dtl';
        }
        else
        {
            $prescription_dtl = 'prescription_dtl_discharged';
        }

        if ($input['type'] == 'oral') {

            $temp_result = \DB::table($prescription_drugs_table)
            ->select(\DB::raw('mas_drugivfluid.brand_name|| \' / \' ||mas_drugivfluid.generic_pharmacological_name as drug_name'), \DB::raw('(CASE WHEN char_length(modified_started_date::text) > 0 THEN modified_started_date ELSE started_date END) AS started_date'), \DB::raw('(CASE WHEN "dose_units_g" != \'1\' THEN '. $prescription_drugs_table.'.dose WHEN "alt_dose_units_g" != \'1\' THEN alt_dose ELSE '. $prescription_drugs_table.'.dose END)|| \' \' ||(CASE WHEN "dose_units_g" != \'1\' THEN (CASE dose_units_g WHEN \'1\' THEN \'ml\' WHEN \'2\' THEN \'g\' WHEN \'3\' THEN \'mg\' WHEN \'4\' THEN \'mcg\' WHEN \'5\' THEN \'nanog\' WHEN \'6\' THEN \'units\' WHEN \'7\' THEN \'topical\' WHEN \'8\' THEN \'tab\' WHEN \'9\' THEN \'cap\' WHEN \'10\' THEN \'sachet\' WHEN \'12\' THEN \'drops\' ELSE dose_units_g END) WHEN "alt_dose_units_g" != \'1\' THEN (CASE alt_dose_units_g WHEN \'1\' THEN \'ml\' WHEN \'2\' THEN \'g\' WHEN \'3\' THEN \'mg\' WHEN \'4\' THEN \'mcg\' WHEN \'5\' THEN \'nanog\' WHEN \'6\' THEN \'units\' WHEN \'7\' THEN \'topical\' WHEN \'8\' THEN \'tab\' WHEN \'9\' THEN \'cap\' WHEN \'10\' THEN \'sachet\' WHEN \'12\' THEN \'drops\' ELSE alt_dose_units_g END) ELSE \'ml\' END) as dose'), 'prescription_id')
            ->join('mas_drugivfluid', $prescription_drugs_table.'.brand_name', 'mas_drugivfluid.id')
            ->join($prescription_dtl, $prescription_drugs_table.'.id', $prescription_dtl.'.pres_hdr_id')
            ->whereNotNull('started_date')
            ->where('type', 'ORAL')
            ->where('baby_id', $baby_id)
            ->where('admission_id', $admission_id)
            ->orderBy('started_date')
            ->get()
            ->toArray();

            $filename = 'Oral Drugs';

            $heading = ['Drug Name', 'Result Time', 'Dose', 'Prescription Id'];

        } else {

            $temp_result = \DB::table($prescription_drugs_table)
            ->select(\DB::raw('mas_drugivfluid.brand_name|| \' / \' ||mas_drugivfluid.generic_pharmacological_name as drug_name'), \DB::raw('(CASE type WHEN \'IVDI\' THEN '.$prescription_drugs_table.'.dose|| \' \' ||(CASE dose_units_g WHEN \'1\' THEN \'g\' WHEN \'2\' THEN \'mg\' WHEN \'3\' THEN \'ml\' WHEN \'4\' THEN \'mcg\' WHEN \'5\' THEN \'nanog\' WHEN \'6\' THEN \'units\' ELSE dose_units_g END)|| \' / \' ||(CASE dose_units_kg WHEN \'1\' THEN \'kg\' ELSE dose_units_kg END)|| \' / \' ||(CASE dose_units_time WHEN \'1\' THEN \'min\' WHEN \'2\' THEN \'hr\' WHEN \'3\' THEN \'day\' ELSE dose_units_time END) WHEN \'OIVD\' THEN (CASE WHEN "dose_units_g" != \'3\' OR char_length(alt_dose::text) = 0 OR "alt_dose" = \'0\' THEN '. $prescription_drugs_table.'.dose WHEN "alt_dose_units_g" != \'3\' OR char_length('.$prescription_drugs_table.'.dose::text) = 0 OR '.$prescription_drugs_table.'.dose = \'0\' THEN alt_dose ELSE '. $prescription_drugs_table.'.dose END)|| \' \' ||(CASE WHEN "dose_units_g" != \'3\' OR char_length(alt_dose::text) = 0 OR "alt_dose" = \'0\' THEN (CASE dose_units_g WHEN \'1\' THEN \'g\' WHEN \'2\' THEN \'mg\' WHEN \'3\' THEN \'ml\' WHEN \'4\' THEN \'mcg\' WHEN \'5\' THEN \'nanog\' WHEN \'6\' THEN \'units\' ELSE dose_units_g END) WHEN "alt_dose_units_g" != \'3\' OR char_length('.$prescription_drugs_table.'.dose::text) = 0 OR '. $prescription_drugs_table.'.dose = \'0\' THEN (CASE alt_dose_units_g WHEN \'1\' THEN \'g\' WHEN \'2\' THEN \'mg\' WHEN \'3\' THEN \'ml\' WHEN \'4\' THEN \'mcg\' WHEN \'5\' THEN \'nanog\' WHEN \'6\' THEN \'units\' ELSE alt_dose_units_g END) ELSE \'ml\' END) WHEN \'OIVI\' THEN volume|| \' ml\' ELSE type END) AS dose'), 'prescription_id')
            ->join('mas_drugivfluid', $prescription_drugs_table.'.brand_name', 'mas_drugivfluid.id')
            ->join($prescription_dtl, $prescription_drugs_table.'.id', $prescription_dtl.'.pres_hdr_id')
            ->where('type', '<>', 'ORAL')
            ->where('baby_id', $baby_id)
            ->where('admission_id', $admission_id)
            ->orderBy($prescription_dtl.'.id')
            ->get();

            $filename = 'Non-Oral Drugs';

            $heading = ['Drug Name', 'Dose', 'Prescription Id'];

        }

        $result = json_decode(json_encode($temp_result), true);

        Excel::create($filename.'(' . $baby_mrn . '-' . $ipnumber . ')', function ($excel) use ($result, $heading)
        {

            $excel->sheet('Excel sheet', function ($sheet) use ($result, $heading)
            {

                $sheet->fromArray($result, null, 'A1', false, false, false);
                $sheet->prependRow(1, $heading);
                $sheet->setOrientation('landscape');

            });

        })
            ->export('xls')
            ->download();
    }
}
