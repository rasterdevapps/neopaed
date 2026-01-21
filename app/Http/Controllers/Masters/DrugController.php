<?php namespace App\Http\Controllers\Masters;

use Carbon\Carbon;
use App\Models\Masters\Drug;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings\DeleteApproval;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Schema;

class DrugController extends Controller 
{

	public function __construct(Guard $auth)
	{
		$this->middleware('role:MAS_DRUGS,write', ['only'=>['store','update','edit','create','destroy']]);
		$this->middleware('role:MAS_DRUGS,read', ['only'=>['index']]);	
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

	    //get the drug record list form drug masters
	    $result 	= Drug::list($request->input('page'), $limit, $search_txt, $order, 1);
	    $results 	= $result['result'];

	    $getTotal   = count(Drug::ListData());	
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

		return view('masters.drug.list', compact('results', 'pagination', 'search_txt', 'order', 'getTotal'));
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
		return view('masters.drug.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return listing page.
	 */
	public function store(Request $request)
	{
		$id = null;
		$input = $request->all();

		foreach ($input['Value'] as $key => $value) {
			$post['Name']          = $input['Name'];
			$post['generic_name']  = $input['generic_name'];
			$post['Value']         = $input['Value'][$key];
			$post['Status']        = $input['Status'][$key];						
			$post['DateModified']  = Carbon::now();
			$post['DateAdded']     = Carbon::now();
			$post['UserAdded']     = \Auth::User()->id;
			$post['drug_group_id'] = $id ; 
			if ($key == 0)
				$id = Drug::create($post)->Id;
			else
				Drug::create($post);
		}
		unset($post);
		if ($id != '') {
			$results = Drug::findOrfail($id);
			$post['drug_group_id'] = $id; 
			$results->update($post);
		}

		return redirect(action('Masters\DrugController@index'))->with('Success', 'Record added successfully');
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
	 * Show the form for editing the specified record.
	 *
	 * @param  int  $id
	 
	 * @return edit forms
	 */
	public function edit($id)
	{
		$results = Drug::findOrfail($id);
		return view('masters.drug.edit', compact('results'));
	}
	/**
	 * Update the specified record in storage.
	 *
	 * @param  int  $id
	 * @redirect listing page
	 */
	public function update($id, Request $request)
	{
		$results = Drug::findOrfail($id);
		
		$input = $request->all();
		
		$input['DateModified'] = Carbon::now();
		
		$results->update($input);
		
		return redirect(action('Masters\DrugController@index'))->with('Success', 'Record updated successfully');
	}
	/**
	* UPDATE THE RECORD AS DELETED AND CREATE THE REQUEST FOR APPROVAL
	*/
	public function destroy($id)
	{
		$results = Drug::findOrfail($id);

		$user_detail = array(
			'UserDeleted'	=> $this->auth->user()->id,
			'DateModified'	=> Carbon::now(),
			'IsDeleted'		=> '1'
		);
		$results->update($user_detail);

		$delete_data = array(
			'Name'		  	   => $results['Name'],
			'ModuleController' => 'Masters\DrugController',
			'ModuleId'		   => $id,
			'ModuleName'	   => 'Drug Master',
			'UserDeleted'	   => $this->auth->user()->id,
			'DateDeleted'	   => Carbon::now()
		);
		DeleteApproval::create($delete_data);
		return redirect(action('Masters\DrugController@index'))->with('info', 'Record deleted successfully !');

	}
	/**
	 * This method to get drug strength
	 * 
	 */
	public function get_drung_strength($id)
	{
		$results = Drug::get_strength_drung($id);
		$response['data']= $results;
		if (count($results)>0)
			return \Response::json($response['data'], 200) ;
		else
		    return \Response::json($response, 404);	
		
	}
	/**
	 * This method to get drug strength
	 * @param $request Request response 
	 *
	 */
	public function getUpdateMaster(Request $request)
	{
		$input = $request->all();
		$id=null;
		$input = $request->all();
		$length = sizeof($input['Status']);
		for ($i=0; $i<$length; $i++) {
			if ($input['Name'][$i] !='') {
				$post['Name'] = $input['Name'];
				$post['generic_name'] = $input['generic_name'];
				$post['Value'] = $input['Value'][$i];
				$post['Status'] = $input['Status'][$i];						
				$post['DateModified'] = Carbon::now();
				$post['DateAdded'] = Carbon::now();
				$post['UserAdded'] = \Auth::User()->id;
				$post['drug_group_id']= $id ; 

				if ($i==0)
				$id=Drug::create($post)->Id;
			    else
			    	Drug::create($post);
			}
		}
		unset($post);
		$results= Drug::findOrfail($id);
		$post['drug_group_id']= $id ; 
		$results->update($post);
		return \Response::json(['messageType'=>'success','message'=>'Added succcessfully', 'data'=>$results],200);

	}

}
