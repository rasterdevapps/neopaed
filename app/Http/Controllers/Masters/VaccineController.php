<?php namespace App\Http\Controllers\Masters;

use Carbon\Carbon;
use App\Models\Masters\Vaccine;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings\DeleteApproval;
use Illuminate\Contracts\Auth\Guard;

class VaccineController extends Controller 
{

	public function __construct(Guard $auth)
	{
		$this->middleware('role:MAS_VACCINE,write', ['only'=>['store','update','edit','create','destroy']]);
		$this->middleware('role:MAS_VACCINE,read', ['only'=>['index']]);	
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
            $limit = $request->session()->get('limit');

        } elseif ($request->session()->has('limit')) {

            $limit = $request->session()->get('limit');

        }

        //Initialize the record sorting key and order  
        $order['sortby']    = 'Id';
        $order['sortorder'] = 'desc';   

        //set the records sorting key and order  
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {

            $order['sortby']    = \SiteHelpers::decrypt_id($request->input('sortby'));
            $order['sortorder'] = $request->input('sortorder');

        }

        //initialize search parameter 
        $search_txt = !empty($request->input('search_txt')) ? $request->input('search_txt') : '';

	    //get the vaccine record list form vaccine masters
	    $result 	= Vaccine::list($request->input('page'), $limit, $search_txt, $order, 1);
	    $results 	= $result['result'];

	    $getTotal   = Vaccine::getCount();	
	    $total   	= $result['total'];	

	    // Set page
	    $page                   = !empty($request->input('page')) ? $request->input('page') : 1;
	    $pagecount              = (!empty($search['search_txt'])) ? ceil($total/$limit) : ceil($total/$limit);
	    $pagination['total']    = $total;
	    $pagination['start']    = (($page-2) < 1) ? 1 : ($page-2);
	    $pagination['end']      = ($pagecount < ($page+3)) ? $pagecount : ($page+3);
	    $pagestart              = $total != 0 ? ($page <= 1) ? $page : ($page-1)*$limit + 1 : 0;
	    $pagerecords            = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page*$limit;
	    $pagination['limit']    = array($pagestart, $pagerecords);
	    $pagination['limits']   = $limit;
	    $pagination['previous'] = (($page-1) < 1) ? 1 : ($page-1);
	    $pagination['next']     = ($pagecount < ($page+1)) ? $pagecount : ($page+1);

		return view('masters.vaccine.list', compact('results', 'pagination', 'search_txt', 'order', 'getTotal'));
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return view('masters.vaccine.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		
		$input = $request->all();

		if (!isset($input['Name']) || empty($input['Name'])) {
			return redirect()->back()->with('error', 'Error occurred');
		}
		
		foreach ($input['Name'] as $key => $value) {
			$post['Name']         = $input['Name'][$key];
			$post['Value']        = $input['Value'][$key];
			$post['Status']       = $input['Status'][$key];						
			$post['DateModified'] = Carbon::now();
			$post['DateAdded']    = Carbon::now();
			Vaccine::create($post);
		}
		return redirect(action('Masters\VaccineController@index'))->with('Success', 'Record added successfully');
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 
	 * @return edit forms
	 */
	public function edit($id)
	{
		$id = \SiteHelpers::decrypt_id($id);
		$results = Vaccine::findOrfail($id);
		return view('masters.vaccine.edit', compact('results'));
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @redirect listing page
	 */
	public function update($id, Request $request)
	{
		$results = Vaccine::findOrfail($id);
		
		$input = $request->all();
		
		$input['DateModified'] = Carbon::now();
		
		$results->update($input);
		
		return redirect(action('Masters\VaccineController@index'))->with('Success', 'Record updated successfully');
	}
	/**
	* UPDATE THE RECORD AS DELETED AND CREATE THE REQUEST FOR APPROVAL
	*/
	public function destroy($id)
	{
		$results = Vaccine::findOrfail($id);

		$user_detail = array(
			'UserDeleted'	=> $this->auth->user()->id,
			'DateModified'	=> Carbon::now(),
			'IsDeleted'		=> '1'
		);
		$results->update($user_detail);

		$delete_data = array(
			'Name'		  	   => $results['Name'],
			'ModuleController' => 'Masters\VaccineController',
			'ModuleId'		   => $id,
			'ModuleName'	   => 'Vaccine Master',
			'UserDeleted'	   => $this->auth->user()->id,
			'DateDeleted'	   => Carbon::now()
		);
		DeleteApproval::create($delete_data);
		return redirect(action('Masters\VaccineController@index'))->with('info', 'Record deleted successfully !');
	}

}
