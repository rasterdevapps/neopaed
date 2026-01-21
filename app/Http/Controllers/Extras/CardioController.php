<?php namespace App\Http\Controllers\extras;

use Carbon\Carbon;
use App\Models\Cardio;
use App\Models\Baby;
use App\Models\Mother;
use App\Models\Settings\DeleteApproval;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Requests;
use App\Http\Requests\Tests\EchoRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CardioController extends Controller 
{
	public function __construct(Guard $auth)
	{
		$this->middleware('role:TEST_ECHO,write', ['only'=>['store','update','edit','create','show','destory']]);
		$this->middleware('role:TEST_ECHO,read', ['only'=>['index','printData']]);	
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
		$navigate['sub_nav'] = 'cardio';

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

        $result                 = Cardio::get_lists($request->input('page'), $limit, $search_txt, $order); 
	    $results 				= $result['result'];
        $getTotal               = Cardio::GetTotalCount();
	    $total   				= $result['total'];	

        // Set page
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

		return view('cardio.list', compact('results', 'navigate', 'pagination', 'order', 'search_txt', 'getTotal'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() 
	{
		$navigate['main_nav'] = 'tests';
		$navigate['sub_nav'] = 'cardio';

		$baby = Baby::babyListData();
        $babies = \ValuelistHelpers::select2DataFormater($baby);
		$SubmitButtonText  = "Start";

		return view('cardio.select_patient', compact('SubmitButtonText', 'babies', 'navigate'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(EchoRequest $request)
	{
		$input = $request->all();
		$print_flag = isset($input['print_flag'])?$input['print_flag']:0;
		unset($input['print_flag']);
		$input['AdmissionId'] = 0 ;
		$input['DateAdded'] = Carbon::now();
		$input['DateModified'] = Carbon::now();
		
		$input['TestDate'] = date('Y-m-d', strtotime($input['TestDate']));

		$data = Cardio::create($input);
		
		if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'Echocardiography details created successfully !', 'list_url' => action('Extras\CardioController@index'), 'print_url'=>action('Extras\CardioController@printData', \SiteHelpers::encrypt_id($data->EchoId))], 200);
        }

		if ($print_flag==1) {
			return redirect(action('Extras\CardioController@printData', \SiteHelpers::encrypt_id($data->EchoId)))->with('Success', 'Record added successfully');
		} else {
			return redirect(action('Extras\CardioController@index'))->with('Success', 'Record added successfully');
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
		$navigate['sub_nav'] = 'cardio';

		$baby_result = Baby::findOrfail($id);
		$baby = $baby_result;
		
		$SubmitButtonText  = "Save";

		if (isset($baby->DOB)) {
        	$age = \SiteHelpers::dateDifferents($baby->DOB);
	        $baby->age_year  = $age['Year'];
			$baby->age_month = $age['Month'];
			$baby->age_days  = $age['Day'];
        }


        $baby->DOB = date('d-m-Y', strtotime($baby->DOB));
		$temp    = json_decode($baby_result['Gestation']);
        $temp    = is_array($temp) ? $temp : (array)$temp;

        $baby_result->g_weeks =  isset($temp['g_weeks']) ? $temp['g_weeks'] : 0;
        $baby_result->g_days  =  isset($temp['g_days']) ? $temp['g_days'] : 0; 


		return view('cardio.create', compact('SubmitButtonText', 'baby', 'navigate'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$id = \SiteHelpers::decrypt_id($id);

		$navigate['main_nav'] = 'tests';
		$navigate['sub_nav'] = 'cardio';
		$result = Cardio::get_record($id);
		$results = $result[0];
		$results->DOB = date('d-m-Y', strtotime($results->DOB));
		$results->TestDate = date('d-m-Y', strtotime($results->TestDate));

		$temp    = json_decode($results->Gestation);
        $temp    = is_array($temp) ? $temp : (array)$temp;
        $results->g_weeks =  !empty($temp['g_weeks']) ? $temp['g_weeks'] : null;  
        $results->g_days  =  !empty($temp['g_days']) ? $temp['g_days'] : null; 

		$SubmitButtonText  = "Update";
		return view('cardio.edit', compact('results', 'SubmitButtonText', 'navigate'));
	}

	public function printData($id)
	{

		$id = \SiteHelpers::decrypt_id($id);

		$result = Cardio::get_record($id);
		$results = $result[0];
		$closewinlink = url('echocardiography');
		$temp =  (array)json_decode($results->Gestation); 
        $temp['g_weeks'] =  isset($temp['g_weeks']) && !empty($temp['g_weeks']) ? $temp['g_weeks'] : 0;  
        $temp['g_days']  =  isset($temp['g_days']) && !empty($temp['g_days']) ? $temp['g_days'] : 0; 
		$results->Gestation = $temp['g_weeks'].'+'.$temp['g_days']; 
		return view('cardio.print', compact('results', 'closewinlink'));
	}

	public function getData($id)
	{
		$result = Cardio::get_record($id);
		$results = (array)$result[0];
		$results['DOB'] = date('d-m-Y', strtotime($results['DOB']));
		$results['TestDate'] = date('d-m-Y', strtotime($results['TestDate']));
		return json_encode($results);
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, EchoRequest $request)
	{
		$input = $request->all();
		$print_flag = isset($input['print_flag'])?$input['print_flag']:0;
		unset($input['print_flag']);
		$input['TestDate'] = date('Y-m-d', strtotime($input['TestDate']));		
		$input['DateModified'] = Carbon::now();
		$input['UserModified'] = $this->auth->user->id();
		$input['AdmissionId'] = 0 ;

		$results1 = Cardio::findOrfail($id);
	
		$results1->update($input);

		if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'Echocardiography details created successfully !', 'list_url' => action('Extras\CardioController@index'), 'print_url'=>action('Extras\CardioController@printData', \SiteHelpers::encrypt_id($id))], 200);
        }

		if ($print_flag==1) {
			return redirect(action('Extras\CardioController@printData', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully');
		} else {
			return redirect(action('Extras\CardioController@index'))->with('Success', 'Record updated successfully');
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
		$results = Cardio::findOrfail($id);
		$user_detail = array(
			'UserDeleted'	=> $this->auth->user()->id,
			'DateModified'	=> Carbon::now(),
			'IsDeleted'		=> '1'
		);
		$results->update($user_detail);
		$result =  Cardio::get_record($id);
		$res = $result[0];
		
		$delete_data = array(
			'Name'		  	   => $res->BabyName,
			'AdmissionDate'	   => $results['TestDate'],
			'ModuleController' => 'Extras\CardioController',
			'ModuleId'		   => $id,
			'ModuleName'	   => 'Echocardiography',
			'UserDeleted'	   => $this->auth->user()->id,
			'DateDeleted'	   => Carbon::now()
		);
		DeleteApproval::create($delete_data);
		return redirect(action('Extras\CardioController@index'))->with('info', 'Record deleted successfully !');
	}

}
