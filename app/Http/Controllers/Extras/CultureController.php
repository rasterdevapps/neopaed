<?php namespace App\Http\Controllers\extras;

use Carbon\Carbon;
use App\Models\Culture;
use App\Models\Baby;
use App\Models\Settings\DeleteApproval;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tests\CultureRequest;
use Illuminate\Http\Request;

class CultureController extends Controller 
{
	public function __construct(Guard $auth)
	{
		$this->middleware('role:TEST_CULTURE,write', ['only'=>['store','update','edit','create','show','destory']]);
		$this->middleware('role:TEST_CULTURE,read', ['only'=>['index','printData']]);	
		$this->auth = $auth;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
        //Initialize the record  limit  with 50
        $limit = 50;

        //set the limit as per the request
        if (!empty($request->input('limit'))) {

            $request->session()->put('limit', $request->input('limit'));
            $limit =  $request->session()->get('limit');

        } elseif ($request->session()->has('limit')) {

            $limit =  $request->session()->get('limit');

        }

        //Initialize the record sorting key and order  
        $order['sortby']    = 'EntryDate';
        $order['sortorder'] = 'desc';   

        //set the records sorting key and order  
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {

              $order['sortby']     = \SiteHelpers::decrypt_id($request->input('sortby'));
              $order['sortorder']  = $request->input('sortorder');

        }

        //initialize search parameter array 
        $search = array();
        $search['search_txt']='';
        if (!empty($request->input('search_txt'))) {

           $search['search_txt'] = $request->input('search_txt');

        }

        //setting the navigation bar 
        $navigate['main_nav'] = 'tests';
	    $navigate['sub_nav'] = 'culture';

	    //get the mother record list form mother module
	    $result 	= Culture::get_lists($request->input('page'), $limit, $search, $order, 1);

	    $limitstart = (empty($request->input('page')) || $request->input('page') == 1) ? 0 : (($request->input('page')-1)*$limit);

	    $total   	= $result->get()->count();

	    $results 	= $result->limit($limit)->offset($limitstart)->get();

	    $getTotal   = Culture::GetTotal();	

	    $page                	= !empty($request->input('page')) ? $request->input('page') : 1;
        $pagecount           	= ceil($total/$limit);
        $pagination['total'] 	= $total;
        $pagination['start'] 	= (($page-2) < 1) ? 1 : ($page-2);
        $pagination['end']   	= ($pagecount < ($page+3)) ? $pagecount :   ($page+3);
        $pagestart              = $total != 0 ? ($page <= 1) ? $page : ($page-1)*$limit + 1 : 0;
        $pagerecords            = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page*$limit;
        $pagination['limit']    = array($pagestart, $pagerecords);
        $pagination['limits']   = $limit;
        $pagination['previous'] = (($page-1) < 1) ? 1 : ($page-1);
        $pagination['next']     = ($pagecount < ($page+1)) ? $pagecount :   ($page+1);
        		
		return view('culture.list', compact('results', 'navigate', 'pagination', 'search', 'order', 'getTotal'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$navigate['main_nav'] = 'tests';
		$navigate['sub_nav'] = 'culture';

		$baby = Baby::babyListData();
        $babies = \ValuelistHelpers::select2DataFormater($baby);
		$SubmitButtonText  = "Start";

		return view('culture.select_patient', compact('SubmitButtonText', 'babies', 'navigate'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CultureRequest $request)
	{
		$input = $request->all();
		$input['DateAdded'] = Carbon::now();
		$input['DateModified'] = Carbon::now();

		$input['EntryDate'] = date('Y-m-d', strtotime($input['EntryDate']));
		$input['CollectionDate'] = isset($input['CollectionDate']) && !empty($input['CollectionDate']) ? date('Y-m-d', strtotime($input['CollectionDate'])) : null;

		$data = Culture::create($input);
		$print_flag = isset($input['print_flag'])?$input['print_flag']:0;
		unset($input['print_flag']);
	

		if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'Culture registry details created successfully !', 'list_url' => action('Extras\CultureController@index'), 'print_url'=>action('Extras\CultureController@printData', \SiteHelpers::encrypt_id($data->CultureId))], 200);
        }

		if ($print_flag==1) {
			return redirect(action('Extras\CultureController@printData', \SiteHelpers::encrypt_id($data->CultureId)))->with('Success', 'Record added successfully');
		} else {
			return redirect(action('Extras\CultureController@index'))->with('Success', 'Record added successfully');
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
		$navigate['sub_nav'] = 'culture';

		$baby_result = Baby::findOrfail($id);
		$baby = $baby_result;
		if (isset($baby->DOB) && !empty($baby->DOB)) {
			$baby->DOB = date('d-m-Y', strtotime($baby->DOB));
		}
							
		$SubmitButtonText  = "Save";
		return view('culture.create', compact('SubmitButtonText', 'baby', 'navigate'));
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
		$navigate['sub_nav'] = 'culture';

		$result = Culture::get_record($id);
		$results = $result[0];

		$results->DOB = date('d-m-Y', strtotime($results->DOB));
		$results->EntryDate = date('d-m-Y', strtotime($results->EntryDate));
		
		$results->CollectionDate = date('d-m-Y', strtotime($results->CollectionDate));		

		$SubmitButtonText  = "Update";
		return view('culture.edit', compact('results', 'SubmitButtonText', 'navigate'));
	}

	public function printData($id)
	{
		$id = \SiteHelpers::decrypt_id($id);

		$result = Culture::get_record($id);
		$results = $result[0];
		$closewinlink = url('culture-registry');

		return view('culture.print', compact('results', 'closewinlink'));

	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, CultureRequest $request)
	{
		$input = $request->all();
		
		$input['DateModified'] = Carbon::now();
		$input['UserModified'] = $this->auth->user()->id;

		$input['EntryDate'] = date('Y-m-d', strtotime($input['EntryDate']));
		$input['CollectionDate'] = isset($input['CollectionDate']) && !empty($input['CollectionDate']) ? date('Y-m-d', strtotime($input['CollectionDate'])) : null;

		$results1 = Culture::findOrfail($id);
	
		$results1->update($input);
		$print_flag = isset($input['print_flag'])?$input['print_flag']:0;
		unset($input['print_flag']);


		if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'Culture registry details created successfully !', 'list_url' => action('Extras\CultureController@index'), 'print_url'=>action('Extras\CultureController@printData', \SiteHelpers::encrypt_id($id))], 200);
        }

		if ($print_flag==1) {
			return redirect(action('Extras\CultureController@printData', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully');
		} else {
			return redirect(action('Extras\CultureController@index'))->with('Success', 'Record updated successfully');
		}
	}

	public function getData($id)
	{

		$result = Culture::get_record($id);
		$results = (array)$result[0];

		$results['DOB'] = date('d-m-Y', strtotime($results['DOB']));
		$results['EntryDate'] = date('d-m-Y', strtotime($results['EntryDate']));
		$results['CollectionDate'] = date('d-m-Y', strtotime($results['CollectionDate']));		

		return json_encode($results);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$results = Culture::findOrfail($id);
		$user_detail = array(
			'UserDeleted'	=> $this->auth->user()->id,
			'DateModified'	=> Carbon::now(),
			'IsDeleted'		=> '1'
		);
		$results->update($user_detail);
		$result =  Culture::get_record($id);
		$res = $result[0];
		
		$delete_data = array(
			'Name'		  	   => $res->BabyName,
			'AdmissionDate'	   => $results['EntryDate'],
			'ModuleController' => 'Extras\CultureController',
			'ModuleId'		   => $id,
			'ModuleName'	   => 'Culture Registry',
			'UserDeleted'	   => $this->auth->user()->id,
			'DateDeleted'	   => Carbon::now()
		);
		DeleteApproval::create($delete_data);
		return redirect(action('Extras\CultureController@index'))->with('info', 'Record deleted successfully !');
	}

}
