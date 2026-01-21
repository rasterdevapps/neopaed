<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Masters\FrequencyMaster;
use Carbon\Carbon;
use App\Models\Settings\DeleteApproval;

class FrequencyController extends Controller
{
    
    /**
     * constructor method
     *
     */
	public function __construct(Guard $auth)
	{
		$this->middleware('role:MAS_FREQUENCY,write', ['only'=>['store','update','edit','create','destory']]);
		$this->middleware('role:MAS_FREQUENCY,read', ['only'=>['index']]);	
		$this->auth = $auth;
	}
	
   /**
	* Display a listing of the data.
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
        $order['sortby']    = 'freq_id';
        $order['sortorder'] = 'desc';   

        //set the records sorting key and order  
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {

            $order['sortby']    = \SiteHelpers::decrypt_id($request->input('sortby'));
            $order['sortorder'] = $request->input('sortorder');

        }

        //initialize search parameter 
        $search_txt = !empty($request->input('search_txt')) ? $request->input('search_txt') : '';

	    //get the frequency record list form frequency masters
	    $result 	= FrequencyMaster::list($request->input('page'), $limit, $search_txt, $order, 1);
	    $results 	= $result['result'];

	    $getTotal   = FrequencyMaster::GetTotal();	
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

		return view('masters.frequency.list', compact('results', 'pagination', 'search_txt', 'order', 'getTotal'));
	}

	/**
	 * Show the form for creating a new frequency.
	 *
	 * @return Response
	 */
	public function create()
	{
        $role_id = $this->auth->user()->RoleId;
		return view('masters.frequency.create', compact('role_id'));
	}

	/**
	 * Store a newly created record
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$input = $request->all();

		if ($request->ajax()) {
            if (empty($input['name']) || empty($input['value'])) {
                return \Response::json(['messageType'=>'error','message'=>'Please fill the all the fields']);
            } else {        
				$post['name']       = $input['name'];
				$post['value']      = $input['value'];
                $post['usage_type'] = isset($input['usage_type']) ? $input['usage_type'] : 'OP';
				$post['status']     = $input['status'];
				$post['date_added'] = Carbon::now();
				$post['user_added'] = $this->auth->user()->id;
				$id = FrequencyMaster::create($post)->freq_id; 
            }
        } else {	
	        if (!isset($input['name']) || empty($input['name'])) {
				return redirect()->back()->with('error', 'Error occurred');
			}	
			foreach ($input['name'] as $key => $value) {
				$post['name']       = $input['name'][$key];
				$post['value']      = $input['value'][$key];
				$post['usage_type'] = (isset($input['usage_type']) && isset($input['usage_type'][$key])) ? $input['usage_type'][$key] : 'OP';
				$post['status']     = $input['status'][$key];
				$post['date_added'] = Carbon::now();
				$post['user_added'] = $this->auth->user()->id;
				$id = FrequencyMaster::create($post)->freq_id; 
			}
		}

        $frequency =  FrequencyMaster::find($id);
		if ($request->ajax()) {
       		return \Response::json(['messageType'=>'success','message'=>'Added succcessfully','data'=>$frequency],200);
       	} else {
			return redirect(action('Masters\FrequencyController@index'))->with('Success', 'Record added successfully');
		}
	}

	/**
	 * Display the specified record.
	 *
	 * @param  int  $id
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified record.
	 *
	 * @param  int  $id
	 
	 * @return edit forms
	 */
	public function edit($id)
	{
		$id = \SiteHelpers::decrypt_id($id);
		$results = FrequencyMaster::findOrfail($id);
        $role_id = $this->auth->user()->RoleId;
		return view('masters.frequency.edit', compact('results', 'role_id'));
	}

	/**
	 * Update the specified record.
	 *
	 * @param  int  $id
	 * @redirect listing page
	 */
	public function update($id, Request $request)
	{
		$results = FrequencyMaster::findOrfail($id);
		
		$input = $request->all();
		
        $input['usage_type'] = isset($input['usage_type']) ? $input['usage_type'] : 'OP';
		$input['date_modified'] = Carbon::now();
		$input['user_modified'] = $this->auth->user()->id;
		
		$results->update($input);
		
		return redirect(action('Masters\FrequencyController@index'))->with('Success', 'Record updated successfully');
	}
	
	/**
	* UPDATE THE RECORD AS DELETED AND CREATE THE REQUEST FOR APPROVAL
	*/
	public function destroy($id)
	{
		$results = FrequencyMaster::findOrfail($id);

		$user_detail = array(
			'user_deleted'	=> $this->auth->user()->id,
			'date_modified'	=> Carbon::now(),
			'is_deleted'		=> '1'
		);
		$results->update($user_detail);

		$delete_data = array(
			'Name'		  	   => $results['name'],
			'ModuleController' => 'Masters\FrequencyController',
			'ModuleId'		   => $id,
			'ModuleName'	   => 'Frequency Master',
			'UserDeleted'	   => $this->auth->user()->id,
			'DateDeleted'	   => Carbon::now()
		);
		DeleteApproval::create($delete_data);
		return redirect(action('Masters\FrequencyController@index'))->with('info', 'Record deleted successfully !');
	}

}
