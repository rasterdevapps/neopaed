<?php namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Icd;
use Illuminate\Http\Request;

class IcdController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:REPORT_NICU,read');
    }

    /**
     * DISPLAY THE RECORDS ACCORDING TO THE FILTERS APPLIED
     *
     */
    public function index(Request $request)
    {

        //Initialize the record  limit  with 50
        $limit = 50;

        //set the limit as per the request
        if (!empty($request->input('limit'))) {

            $request->session()->put('limit', $request->input('limit'));
            $limit = $request->session()->get('limit');

        } elseif ($request->session()->has('limit')) {

            $limit = $request->session()->get('limit');

        }

        //Initialize the record sorting key and order  
        $order['sortby']    = 'id';
        $order['sortorder'] = 'desc';   

        //set the records sorting key and order  
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {

            $order['sortby']    = \SiteHelpers::decrypt_id($request->input('sortby'));
            $order['sortorder'] = $request->input('sortorder');

        }

        //initialize search parameter 
        $search_txt = !empty($request->input('search_txt')) ? $request->input('search_txt') : '';

        //get the icd record list form icd module
        $result     = Icd::ListData($request->input('page'), $limit, $search_txt, $order, 1);
        $results    = $result['result'];

        $getTotal   = Icd::GetTotal(); 
        $total      = $result['total']; 

        // Set page
        $page                   = !empty($request->input('page')) ? $request->input('page') : 1;
        $pagecount              = (!empty($search_txt)) ? ceil($total/$limit) : ceil($total/$limit);
        $pagination['total']    = $total;
        $pagination['start']    = (($page-2) < 1) ? 1 : ($page-2);
        $pagination['end']      = ($pagecount < ($page+3)) ? $pagecount : ($page+3);
        $pagestart              = $total != 0 ? ($page <= 1) ? $page : ($page-1)*$limit + 1 : 0;
        $pagerecords            = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page*$limit;
        $pagination['limit']    = array($pagestart, $pagerecords);
        $pagination['limits']   = $limit;
        $pagination['previous'] = (($page-1) < 1) ? 1 : ($page-1);
        $pagination['next']     = ($pagecount < ($page+1)) ? $pagecount : ($page+1);

        return view('admission.lcd.list', compact('results', 'pagination', 'search_txt', 'order', 'getTotal'));

    }
	/**
     * Store a newly created ICD.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $id = Icd::create($input)->id;

        return redirect(action('Admission\IcdController@index'))->with('Success', 'Record added successfully');
    }
	/**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admission.lcd.create');
    }
    /**
     *
     *
     *
     */
     public function getUpdateIcd(Request $request)
     {
        $input = $request->all();
        $id = Icd::create($input)->id;
        $results = Icd::find($id);
        return \Response::json(['messageType'=>'success','message'=>'Added succcessfully', 'data'=>$results],200);


     }   
}
