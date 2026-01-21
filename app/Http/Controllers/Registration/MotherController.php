<?php 
namespace App\Http\Controllers\Registration;

use Carbon\Carbon;
use App\Models\Mother;
use App\Models\Settings\Settings;
use App\Http\Controllers\Controller;
use App\Http\Requests\MotherRequest;
use App\Models\Settings\DeleteApproval;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Http\Controllers\Sockets\SocketController;
use App\Http\Controllers\Flow\FlowController;

class MotherController extends Controller 
{   


   /**
	* checking the permission and authorization.
	*
	* @param Guard  object for authorize
	*/
	public function __construct(Guard $auth, FlowController $flow)
	{

		$this->middleware('role:MOTHER_REG,write', ['only'=>['store','update','edit','create','destory']]);
		$this->middleware('role:MOTHER_REG,read', ['only'=>['index']]);		
	 	$this->auth = $auth;
	 	$this->flow = $flow;

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
        $order['sortby']    = 'MotherId';
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
        $navigate['main_nav'] = 'register';
	    $navigate['sub_nav'] = 'mother';

	    //get the mother record list form mother module
	    $result 	= Mother::ListDatawithSearch($request->input('page'), $limit, $search, $order, 1);
	    $results 	= $result['result'];

	     foreach ($results as &$value) {
	     	$baby_details   = Mother::GetMotherDependency($value->MotherId);
	     	$value->hasBaby = (count($baby_details) > 0) ? true : false;
	     		     	
	     }
	    $getTotal   = Mother::GetTotal();	
	    $total   	= $result['total'];	

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

		$this->flow->clearFlow();

		// echo "<pre>"; print_r($results); exit;		
		return view('registration.mothers_list', compact('results', 'navigate', 'pagination', 'search', 'order', 'getTotal'));
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		//setting the navigation bar
		$navigate['main_nav'] = 'register';
		$navigate['sub_nav'] = 'mother';

		//get the settings for setting model 
        $sitesetting = Settings::get_record();
        $sitesetting = $sitesetting[0];

	    $mmrno = '';

		return view('registration.mothers_create', compact('results', 'navigate', 'mmrno', 'sitesetting'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(MotherRequest $request)
	{

		$input = $request->all();

		$input['DateModified'] = Carbon::now();
		$input['UserModified']    = $this->auth->user()->id;

		$input['MotherDOB']    = (isset($input['MotherDOB']) && !empty($input['MotherDOB']))  ? date('Y-m-d', strtotime($input['MotherDOB']))  : null;
		$input['PartnerDOB']   = (isset($input['PartnerDOB']) && !empty($input['PartnerDOB'])) ? date('Y-m-d', strtotime($input['PartnerDOB'])) : null;

		$input['MothercYear']  = (!isset($input['MothercYear']) || empty(trim($input['MothercYear'])))  ?  null : $input['MothercYear'];
		$input['PartnercYear'] = (!isset($input['PartnercYear']) || empty(trim($input['PartnercYear']))) ?  null : $input['PartnercYear'];
		$input['UserModified'] = $this->auth->user()->id;

		$input['MotherName']   = (isset($input['MotherName']) && !empty($input['MotherName'])) ?  ucwords(strtolower($input['MotherName'])): '';
		$input['MotherLastName']   = (isset($input['MotherLastName']) && !empty($input['MotherLastName'])) ?  ucwords(strtolower($input['MotherLastName'])): '';
		
		$input['PartnerName']   = (isset($input['PartnerName']) && !empty($input['PartnerName'])) ?  ucwords(strtolower($input['PartnerName'])): '';
		$input['PartnerLastName']   = (isset($input['PartnerLastName']) && !empty($input['PartnerLastName'])) ?  ucwords(strtolower($input['PartnerLastName'])): '';

		

		if ($input['MotherId'] == 0) {
			unset($input['MotherId']);
			$input['DateAdded'] = Carbon::now();
			$input['UserAdded']    = $this->auth->user()->id;
			$id = Mother::create($input)->MotherId;

		} else {

			$results = Mother::findOrfail($input['MotherId']);
			$results->update($input);
            $id = $input['MotherId'];
		}
        if (\Session::has('registration_start')) {
        	$module_complete = (in_array('BABY_REG', \Session::get('write_permission'))) ? false : true ;
		    $this->flow->flowlog('MOTHER_REG', null, $id, null, $module_complete, null);
        } 
        if ($request->ajax())
        {
            return \Response::json(['type' => 'success', 'message' => 'Time sheet added successfully !', 'id' => $id, 'edit_url' => action('Registration\MotherController@edit', \SiteHelpers::encrypt_id($id)), 'create_baby_url' => action('Registration\BabyController@create').'/'.\SiteHelpers::encrypt_id($id), 'list_url' => action('Registration\MotherController@index')], 200);
        }

		if (!empty($input['form-flag']) &&  $input['form-flag'] == 2)  {

            return redirect(action('Registration\MotherController@edit', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record saved successfully !');
		
		} elseif (!empty($input['form-flag']) &&  $input['form-flag'] == 3) {

          if(in_array('BABY_REG', \Session::get('write_permission'))) {
          	 return redirect(action('Registration\BabyController@create').'/'.\SiteHelpers::encrypt_id($id))->with('Success', 'Mother record saved successfully !');
          } else {
          	return redirect(action('Registration\MotherController@index'))->with('Success', 'Record saved successfully !');

          }
		
		} else {
           
           return redirect(action('Registration\MotherController@index'))->with('Success', 'Record saved successfully !');
		}


	}

	
	/**
	 * Show the form for editing the mother data
	 *
	 * @param  int  $id
	 
	 * @return edit forms
	 */
	public function edit($id, Request $request)
	{
		$flow_wise_register = $request->get('flow');
		$baby_id = $request->get('baby');
		$id = \SiteHelpers::decrypt_id($id);
		$navigate['main_nav'] = 'register';
		$navigate['sub_nav'] = 'mother';
		$results = Mother::findOrfail($id);

		if (!is_null($results['MotherDOB'])) {
			$results['MotherDOB'] = date('d-m-Y', strtotime($results['MotherDOB']));
		} else {
			$results['MotherDOB'] = '';
		}
			
		if (!is_null($results['PartnerDOB'])) {
			$results['PartnerDOB'] = date('d-m-Y', strtotime($results['PartnerDOB']));
		} else {
			$results['PartnerDOB'] = '';
		}

		
        $sitesetting = Settings::get_record();
        $sitesetting = $sitesetting[0];
		$mmrno = $results['MMrNo'];
		return view('registration.mothers_edit', compact('results', 'navigate', 'mmrno', 'sitesetting', 'flow_wise_register', 'baby_id'));
	}

	/*
	* Retrieve data for search filter
	*/	
	public function searchData(Request $request)
	{
		$data = $request->get('data1');
		$results = Mother::GetSearchDatas($data);
		return json_encode($results);
	}

	/*
	* Retrieve data for view popup via ajax
	*/
	public function getData(Request $request)
	{
		$id = $request->get('id');
		$results = Mother::findOrfail($id);

		if (!is_null($results['MotherDOB'])) {
			$results['MotherDOB'] = date('d-m-Y', strtotime($results['MotherDOB']));
		} else {
			$results['MotherDOB'] = '';
		}
			
		if (!is_null($results['PartnerDOB'])) {
			$results['PartnerDOB'] = date('d-m-Y', strtotime($results['PartnerDOB']));
        } else {
			$results['PartnerDOB'] = '';
        }
		
		
		return json_encode($results);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @redirect listing page
	 */
	public function update($id, MotherRequest $request)
	{

		$results = Mother::findOrfail($id);
		$input = $request->all();
		$input['MotherDOB']    = (isset($input['MotherDOB']) && !empty($input['MotherDOB']))  ? date('Y-m-d', strtotime($input['MotherDOB']))  : null;
		$input['PartnerDOB']   = (isset($input['PartnerDOB']) &&  !empty($input['PartnerDOB'])) ? date('Y-m-d', strtotime($input['PartnerDOB'])) : null;

		$input['UserModified']    = $this->auth->user()->id;
		$input['DateModified']    = Carbon::now();

		if (\Session::has('registration_start')) {
		
			$results->update($input);
          
		   	$this->flow->flowlog('MOTHER_REG', null, $id, null, false, null);

        }

        if (isset($input['flow']) && $input['flow'] == 'from-dashboard' && isset($input['mother_based_baby_id']) && !empty($input['mother_based_baby_id'])) {
        	$create_baby_url = action('Registration\BabyController@edit', \SiteHelpers::encrypt_id($input['mother_based_baby_id'])).'?flow=from-dashboard';
        }
        else
        {
        	$create_baby_url = action('Registration\BabyController@create').'/'.\SiteHelpers::encrypt_id($id);

        }

        if ($request->ajax())
        {
			$results->update($input);
			
            return \Response::json(['type' => 'success', 'message' => 'Baby updated successfully !', 'id' => $id, 'edit_url' => action('Registration\MotherController@edit', \SiteHelpers::encrypt_id($id)), 'create_baby_url' => $create_baby_url, 'list_url' => action('Registration\MotherController@index')], 200);
        }

        if (!empty($input['savedhere']) || $input['form-flag'] == 2) {

            return redirect(action('Registration\MotherController@edit', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully !');
       
        } elseif (!empty($input['babycreate']) || $input['form-flag'] == 3) {

           return redirect(action('Registration\BabyController@create').'/'.\SiteHelpers::encrypt_id($id))->with('Success', 'Mother record updated successfully !');

		} else {
        
        	return redirect(action('Registration\MotherController@index'))->with('Success', 'Record updated successfully !');
        
        }
	}

	/*
	* Update data as deleted and create the request for approval.
	*/
	public function destroy($id)
	{
		$results = Mother::findOrfail($id);
		$delete_data = array(
			'Name'		   => $results['MotherName'],
			'ModuleController' => 'Registration\MotherController',
			'ModuleId'		   => $id,
			'ModuleName'	   => 'Mother Registration',
			'UserDeleted'	   => $this->auth->user()->id,
			'DateDeleted'	   => Carbon::now()
		);
		
		DeleteApproval::create($delete_data);
		$user_detail = array(
			'UserDeleted'	=> $this->auth->user()->id,
			'DateModified'	=> Carbon::now(),
			'IsDeleted'		=> 1
		);
		$results->update($user_detail);
		return redirect(action('Registration\MotherController@index'))->with('info', 'Record deleted successfully !');
	}

	/*
	* check for uniqe mr number.
	*/
	public function mrcheck(Request $request)
	{

		$input = $request->all();
		$mother_records= Mother::where('MMrNo', $input['MMrNo'])
		                        ->where('IsDeleted', '0')
		                        ->get();

		if (count($mother_records) > 0) {

            return \Response::json('Mr No already exists.', 200);
	         
		} else {

             return \Response::json(true, 200);
		}


	}

  
	

}
