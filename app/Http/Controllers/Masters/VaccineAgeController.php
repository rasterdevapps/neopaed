<?php namespace App\Http\Controllers\Masters;

use Carbon\Carbon;
use App\Models\Masters\VaccineAge;
use App\Models\Masters\VaccineGeneric;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings\DeleteApproval;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Schema;

class VaccineAgeController extends Controller 
{

	public function __construct(Guard $auth)
	{
		$this->middleware('role:MAS_VACCINE_AGE,write', ['only'=>['store','update','edit','create','destroy']]);
		$this->middleware('role:MAS_VACCINE_AGE,read', ['only'=>['index']]);	
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
        $order['sortby']    = 'id';
        $order['sortorder'] = 'desc';   

        //set the records sorting key and order  
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {

            $order['sortby']    = \SiteHelpers::decrypt_id($request->input('sortby'));
            $order['sortorder'] = $request->input('sortorder');

        }

        //initialize search parameter 
        $search_txt = !empty($request->input('search_txt')) ? $request->input('search_txt') : '';

	    //get the VaccineAge record list form VaccineAge masters
	    $result 	= VaccineAge::list($request->input('page'), $limit, $search_txt, $order, 1);
	    $results 	= $result['result'];

	    $getTotal   = count(VaccineAge::ListData());	
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

		return view('masters.vaccine_age.list', compact('results', 'pagination', 'search_txt', 'order', 'getTotal'));
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
		return view('masters.vaccine_age.create');
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
		if (count($input['age']) > 0) {
			foreach ($input['age'] as $key => $value) {
				$check_age_exist = VaccineAge::checkAgeExist($value);
				if (!isset($check_age_exist->id) || $check_age_exist->id != 0) {
					$vaccine_age_insert	= array(
						'age' => $value,
						'status' => $input['status'][$key],
						'date_added' => date('Y-m-d H:i:s'),
						'user_added' => $this->auth->user()->id,
					);
					VaccineAge::insert($vaccine_age_insert);
				}
			}
			return redirect(action('Masters\VaccineAgeController@index'))->with('Success', 'Record added successfully');
		}
		else
		{
			return redirect()->back()->with('Warning', 'No record to insert...');
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
		$results = VaccineAge::findOrfail($id);
		return view('masters.vaccine_age.edit', compact('results'));
	}
	/**
	 * Update the specified record in storage.
	 *
	 * @param  int  $id
	 * @redirect listing page
	 */
	public function update($id, Request $request)
	{
		$results = VaccineAge::findOrfail($id);
		
		$input = $request->all();
		
		$input['date_modified'] = Carbon::now();
		$input['user_modified'] = $this->auth->user()->id;
		
		$results->update($input);
		
		return redirect(action('Masters\VaccineAgeController@index'))->with('Success', 'Record updated successfully');
	}
	/**
	* UPDATE THE RECORD AS DELETED AND CREATE THE REQUEST FOR APPROVAL
	*/
	public function destroy($id)
	{
		$results = VaccineAge::findOrfail($id);

		$user_detail = array(
			'user_deleted'	=> $this->auth->user()->id,
			'deleted_date_time'	=> Carbon::now(),
			'is_deleted'		=> '1'
		);
		$results->update($user_detail);

		$delete_data = array(
			'Name'		  	   => $results['name'],
			'ModuleController' => 'Masters\VaccineAgeController',
			'ModuleId'		   => $id,
			'ModuleName'	   => 'Vaccine Age Master',
			'UserDeleted'	   => $this->auth->user()->id,
			'DateDeleted'	   => Carbon::now()
		);
		DeleteApproval::create($delete_data);
		return redirect(action('Masters\VaccineAgeController@index'))->with('info', 'Record deleted successfully !');

	}

	public function mapWithVaccines()
	{
		$vaccines_mapped = VaccineAge::getVaccine('mapped');
		$vaccines_not_mapped = VaccineAge::getVaccine('not_mapped');
		$vaccine_age = VaccineAge::get_lists();
		return view('masters.vaccine_age.map_with_vaccine', compact('vaccines_mapped', 'vaccines_not_mapped', 'vaccine_age'));

	}

	public function storeVaccine(Request $request)
	{	
		$input = $request->all();

		if (isset($input['name']) && $input['name'] != '') {
			if (isset($input['vaccine_id']) && $input['vaccine_id'] != '') {
				$id = VaccineGeneric::where('id', $input['vaccine_id'])->update(['name'=>$input['name']]);
	            return \Response::json(['type' =>'success', 'message' => 'Vaccine added successfully', 'id'=>$id], 200);
			}
			else
			{
				$check_age_exist = VaccineAge::checkAgeExist($input['name']);
				if (!isset($check_age_exist->id) || $check_age_exist->id != 0) {
					$vaccine_age_insert	= array(
						'name' => $input['name'],
						'status' => "Active",
						'date_added' => date('Y-m-d H:i:s'),
						'user_added' => $this->auth->user()->id,
					);
					$id = VaccineGeneric::insertGetId($vaccine_age_insert);
	            	return \Response::json(['type' =>'success', 'message' => 'Vaccine added successfully', 'id'=>$id], 200);
				}
				else
				{
	            	return \Response::json(['type' =>'failure', 'message' => 'Vaccine already exist...'], 500);
				}
			}
		}
		else
		{
            return \Response::json(['type' =>'failure', 'message' => 'Name empty...'], 500);
		}
	}

	public function mapVaccines(Request $request)
	{	
		$input = $request->all();
		if (isset($input['age_id']) && $input['age_id'] != '' && isset($input['vaccine_id']) && $input['vaccine_id'] != '') {
			VaccineGeneric::where('id', $input['vaccine_id'])->update(['vaccine_age_id'=> $input['age_id']]);
            return \Response::json(['type' =>'success', 'message' => 'Vaccine mapped successfully'], 200);
		}
		else
		{
            return \Response::json(['type' =>'failure', 'message' => 'Values are empty...'], 500);
		}
	}

	public function sortVaccines(Request $request)
	{	
		$input = $request->all();
		if (count($input['sort_order']) > 0) {
			foreach ($input['sort_order'] as $key => $value) {
				if ($value != '' && $value != 0) {
					VaccineGeneric::where('id', $key)->update(['sort_order'=> $value]);
				}
			}
            return \Response::json(['type' =>'success', 'message' => 'Vaccine mapped successfully'], 200);
		}
	}

	public function deleteVaccines(Request $request)
	{	
		$input = $request->all();
		if ($input['vaccine_id'] && !empty($input['vaccine_id'])) {
			$update_vaccine = array(
				'deleted_date_time' => date('Y-m-d H:i:s'),
				'user_deleted' => $this->auth->user()->id,
				'is_deleted' => '1'
			);
			VaccineGeneric::where('id', $input['vaccine_id'])->update($update_vaccine);
        	return \Response::json(['type' =>'success', 'message' => 'Vaccine deleted successfully'], 200);
		}
        return \Response::json(['type' =>'error', 'message' => 'vaccine doesn\'t deleted'], 200);
				
	}
}
