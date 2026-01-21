<?php namespace App\Http\Controllers\extras;

use Carbon\Carbon;
use App\Models\Ultra;
use App\Models\Baby;
use App\Models\Settings\DeleteApproval;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tests\CranialRequest;
use Illuminate\Http\Request;

class UltraController extends Controller 
{
	public function __construct(Guard $auth)
	{
		$this->middleware('role:TEST_ULTRA,write', ['only'=>['store','update','edit','create','show','destory']]);
		$this->middleware('role:TEST_ULTRA,read', ['only'=>['index','printData']]);	
		$this->auth = $auth;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{

		$navigate['main_nav'] = 'tests';
		$navigate['sub_nav'] = 'ultra';

		$limit = 50; // Assign the Page limitation
        if (!empty($request->input('limit'))) {
            $request->session()->put('limit', $request->input('limit'));
            $limit = $request->session()->get('limit');
        } elseif ($request->session()->has('limit')) {
            $limit = $request->session()->get('limit');
        }
         
        //Initialize the record sorting key and order  
        $order['sortby']    = 'TestDate';
        $order['sortorder'] = 'desc';   

        //set the records sorting key and order  
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {

              $order['sortby']     = \SiteHelpers::decrypt_id($request->input('sortby'));
              $order['sortorder']  = $request->input('sortorder');

        }

        $search_txt = '';
        if (!empty($request->input('search_txt'))) {
            $search_txt = $request->input('search_txt');
        }
		
		$result                 = Ultra::get_lists($request->input('page'), $limit, $search_txt, $order); 
	    $results 				= $result['result'];
        $getTotal               = Ultra::GetTotal();
	    $total   				= $result['total'];	

        $page                   = !empty($request->input('page')) ? $request->input('page') : 1;
	    $pagecount              = (!empty($search['search_txt'])) ? ceil($total/$limit) : ceil($total/$limit);
	    $pagination['total']    = $total;
	    $pagination['start']    = (($page-2) < 1) ? 1 : ($page-2);
	    $pagination['end']      = ($pagecount < ($page+3)) ? $pagecount :   ($page+3);
	    $pagestart              = $total != 0 ? ($page <= 1) ? $page : ($page-1)*$limit + 1 : 0;
	    $pagerecords            = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page*$limit;
	    $pagination['limit']    = array($pagestart, $pagerecords);
	    $pagination['limits']   = $limit;
	    $pagination['previous'] = (($page-1) < 1) ? 1 : ($page-1);
	    $pagination['next']     = ($pagecount < ($page+1)) ? $pagecount :   ($page+1);


		return view('ultra.list', compact('results', 'navigate', 'pagination', 'order', 'search_txt', 'getTotal'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$navigate['main_nav'] = 'tests';
		$navigate['sub_nav'] = 'ultra';

		$baby = Baby::babyListData();
        $babies = \ValuelistHelpers::select2DataFormater($baby);
		$SubmitButtonText  = "Start";

		return view('ultra.select_patient', compact('SubmitButtonText', 'babies', 'navigate'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CranialRequest $request)
	{
		$input = $request->all();
		$print_flag = isset($input['print_flag'])?$input['print_flag']:0;
		unset($input['print_flag']);		
		$input['DateAdded'] = Carbon::now();
		$input['DateModified'] = Carbon::now();

		$input['TestDate'] = date('Y-m-d', strtotime($input['TestDate']));

		$ultra = Ultra::create($input);
	
		if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'Echocardiography details created successfully !', 'list_url' => action('Extras\UltraController@index'), 'print_url'=>action('Extras\UltraController@printData', \SiteHelpers::encrypt_id($ultra->UltraId))], 200);
        }

		if ($print_flag==1) {
			return redirect(action('Extras\UltraController@printData', \SiteHelpers::encrypt_id($ultra->UltraId)))->with('Success', 'Record added successfully');
		} else {
			return redirect(action('Extras\UltraController@index'))->with('Success', 'Record added successfully');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$id = \SiteHelpers::decrypt_id($id);

		$navigate['main_nav'] = 'tests';
		$navigate['sub_nav'] = 'ultra';

		$baby_result = Baby::findOrfail($id);
		$baby = $baby_result;
		$SubmitButtonText  = "Save";
		$gestation = is_numeric(\SiteHelpers::convert_gestation_days($baby->Gestation)) ? \SiteHelpers::convert_gestation_days($baby->Gestation) : 0;
        $Age = \SiteHelpers::calculate_day_of_life($baby->DOB);
        $baby->Age = $gestation + $Age ;

		$baby->DOB = date('d-m-Y', strtotime($baby->DOB));
		$temp    = json_decode($baby_result['Gestation']);
        $temp    = is_array($temp) ? $temp : (array)$temp;
        $baby_result->g_weeks =  !empty($temp['g_weeks']) ? $temp['g_weeks'] : 0;
        $baby_result->g_days  =  !empty($temp['g_days']) ? $temp['g_days'] : 0;
		return view('ultra.create', compact('SubmitButtonText', 'baby', 'navigate'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		
		$navigate['main_nav'] = 'tests';
		$navigate['sub_nav'] = 'ultra';
		$id = \SiteHelpers::decrypt_id($id);

		$result = Ultra::get_record($id);
		$results = $result[0];
		$results->DOB = date('d-m-Y', strtotime($results->DOB));
		$results->TestDate = date('d-m-Y', strtotime($results->TestDate));

			$temp    = json_decode($results->Gestation);
        $temp    = is_array($temp) ? $temp : (array)$temp;
        $results->g_weeks =  !empty($temp['g_weeks']) ? $temp['g_weeks'] : 0;
        $results->g_days  =  !empty($temp['g_days']) ? $temp['g_days'] : 0;

		
		$SubmitButtonText  = "Update";
		return view('ultra.edit', compact('results', 'SubmitButtonText', 'navigate'));
	}

	public function printData($id)
	{
		$id = \SiteHelpers::decrypt_id($id);

		$result = Ultra::get_record($id);
		$results = $result[0];
        $closewinlink = url('cranialultrasound');
		$temp =  (array)json_decode($results->Gestation); 
        $temp['g_weeks'] =  !empty($temp['g_weeks']) ? $temp['g_weeks'] : 0;
        $temp['g_days']  =  !empty($temp['g_days']) ? $temp['g_days'] : 0;
		$results->Gestation = $temp['g_weeks'].'+'.$temp['g_days']; 

		return view('ultra.print', compact('results', 'closewinlink'));
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, CranialRequest $request)
	{
		$input = $request->all();
		$print_flag = isset($input['print_flag'])?$input['print_flag']:0;
		unset($input['print_flag']);		
		$input['DateModified'] = Carbon::now();
		$input['UserModified'] = $this->auth->user()->id;

		$input['TestDate'] = date('Y-m-d', strtotime($input['TestDate']));

		$results1 = Ultra::findOrfail($id);
	
		$results1->update($input);

		if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'Echocardiography details created successfully !', 'list_url' => action('Extras\UltraController@index'), 'print_url'=>action('Extras\UltraController@printData', \SiteHelpers::encrypt_id($id))], 200);
        }
		if ($print_flag==1) {
			return redirect(action('Extras\UltraController@printData', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully');
		} else {
			return redirect(action('Extras\UltraController@index'))->with('Success', 'Record updated successfully');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$results = Ultra::findOrfail($id);
		$user_detail = array(
			'UserDeleted'	=> $this->auth->user()->id,
			'DateModified'	=> Carbon::now(),
			'IsDeleted'		=> '1'
		);
		$results->update($user_detail);
		$result =  Ultra::get_record($id);
		$res = $result[0];
		
		$delete_data = array(
			'Name'		  	   => $res->BabyName,
			'AdmissionDate'	   => $results['TestDate'],
			'ModuleController' => 'Extras\UltraController',
			'ModuleId'		   => $id,
			'ModuleName'	   => 'Ultra Sound Scan',
			'UserDeleted'	   => $this->auth->user()->id,
			'DateDeleted'	   => Carbon::now()
		);
		DeleteApproval::create($delete_data);
		return redirect(action('Extras\UltraController@index'))->with('info', 'Record deleted successfully !');

	}
	public function getData($id)
	{

		$result = Ultra::get_record($id);
		$results = (array)$result[0];

		$results['DOB'] = date('d-m-Y', strtotime($results['DOB']));
		$results['TestDate'] = date('d-m-Y', strtotime($results['TestDate']));
		return json_encode($results);
	}

}
