<?php namespace App\Http\Controllers\calculators;

use Carbon\Carbon;
use App\Models\Baby;
use App\Models\Calculators\Ballard;
use App\Models\Settings\DeleteApproval;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BallardController extends Controller 
{

	public function __construct(Guard $auth)
	{
		$this->middleware('role:CALCULATOR,write', ['except'=>['index']]);
		$this->middleware('role:CALCULATOR,read', ['only'=>['index']]);
		$this->auth  = $auth;
	}

	/**
	 * Display a listing of the ballard scores.
	 *
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
        $order['sortby']    = 'baby.BabyId';
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
        $navigate['main_nav'] = 'calc';
		$navigate['sub_nav'] = 'ballard_calc';

	    //get the mother record list form mother module
	    $result 	= Ballard::get_lists($request->input('page'), $limit, $search, $order, 1);

	    $limitstart = (empty($request->input('page')) || $request->input('page') == 1) ? 0 : (($request->input('page')-1)*$limit);

	    $total   	= $result->get()->count();

	    $results 	= $result->limit($limit)->offset($limitstart)->get();

	    $getTotal   = Ballard::GetTotal();	

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
        		
		return view('calculators.ballard.list', compact('results', 'navigate', 'pagination', 'search', 'order', 'getTotal'));

	}

	/**
	 * Form to choose the baby for score calculation
	 *
	 */
	public function create()
	{
		$navigate['main_nav'] = 'calc';
		$navigate['sub_nav'] = 'ballard_calc';		

		$baby = Baby::babyListData();
        $babies = \ValuelistHelpers::select2DataFormater($baby, false, true);
		$SubmitButtonText  = "Start";

		return view('calculators.ballard.select_patient', compact('SubmitButtonText', 'babies', 'navigate'));
	}

	/**
	 * Store a newly created record in storage.
	 *
	 * @return to listing page
	 */
	public function store(Request $request)
	{
		$input = $request->all();
		$input['DateModified'] = Carbon::now();
		$input['DateAdded'] = Carbon::now();
		$input['UserAdded'] = $this->auth->user()->id;
		$input['TestTime'] = Carbon::now();

		if(!empty($input["TestDate"])) {
			$input['TestDate'] = date('Y-m-d', strtotime($input["TestDate"]));
		} else {
		   $input['TestDate'] = date('Y-m-d', time());
		}

    	// $input["NeuromuscularScore"] = is_array($input["NeuromuscularScore"]) ? $input["NeuromuscularScore"] : 0;
    	// $input["PhysicalScore"] = is_array($input["PhysicalScore"]) ? $input["PhysicalScore"] : 0;
    	// $input["TotalScore"] = is_array($input["TotalScore"]) ? $input["TotalScore"] : 0;
    	// $input["AssessedGestationalAge"]  = is_array($input["AssessedGestationalAge"] ) ? $input["AssessedGestationalAge"]  : 0;
    	// $input["Weeks"]  = is_array($input["Weeks"] ) ? $input["Weeks"]  : 0;
    	// $input["Days"] = is_array($input["Days"]) ? $input["Days"] : 0;

		$id = Ballard::create($input)->BallardId;

		return redirect(action('Calculators\BallardController@edit', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record saved successfully');
	}

	/**
	 * Display the creation form
	 *
	 * @param  int  $id
	 */
	public function show($id)
	{
		$id = \SiteHelpers::decrypt_id($id);
		$navigate['main_nav'] = 'calc';
		$navigate['sub_nav'] = 'ballard_calc';
		$check_exist = Ballard::where('BabyId', $id)->first();
		if (count($check_exist) != 0) {
			return redirect(action('Calculators\BallardController@edit', $check_exist->BallardId))->with('Success', 'Record saved successfully');
		}
		$baby_result = Ballard::get_baby($id);
		$baby = $baby_result[0];
		$baby->DOB = date('d-m-Y', strtotime($baby->DOB));
		$baby->TestDate = date('d-m-Y');
		$baby->TestTime = date('H:i:s');
		$SubmitButtonText  = "Save";
        $doctor_master = \ValuelistHelpers::mas_doctors_list();
        
        if (isset($this->auth->user()->mas_id) && !empty($this->auth->user()->mas_id)) {
            $baby->Examiner = $this->auth->user()->mas_id;
        }
        
		return view('calculators.ballard.create', compact('SubmitButtonText', 'baby', 'navigate', 'doctor_master'));

	}

	/**
	 * Show the form for editing the specified record
	 *
	 * @param  int  $id
	 * 
	 */
	public function edit($id)
	{
		$id = \SiteHelpers::decrypt_id($id);
		
		$navigate['main_nav'] = 'calc';
		$navigate['sub_nav'] = 'ballard_calc';		

		$result = Ballard::get_record($id);
		$results = $result[0];
		$results->TestDate = date('d-m-Y', strtotime($results->TestDate));
		$results->DOB      = date('d-m-Y', strtotime($results->DOB));
		$gestation = $results->Gestation != "" ? json_decode($results->Gestation) : (object)["g_weeks"=>null,"g_days"=>null];
		$SubmitButtonText = "Update";
        $doctor_master = \ValuelistHelpers::mas_doctors_list();
		return view('calculators.ballard.edit', compact('results', 'SubmitButtonText', 'navigate', 'gestation', 'doctor_master'));
	}

	public function print($id, Request $request)
	{
		$id = \SiteHelpers::decrypt_id($id);
		$closewinlink = $request->get('closewinlink');
		
		$navigate['main_nav'] = 'calc';
		$navigate['sub_nav'] = 'ballard_calc';		

		$result = Ballard::get_record($id);
		$results = $result[0];

		if ($closewinlink == 'list') {
        	$closewinlink = action('Calculators\BallardController@index');
		} else {
        	$closewinlink = action('Calculators\BallardController@edit', \SiteHelpers::encrypt_id($id));			
		}
        $doctor_master = \ValuelistHelpers::mas_doctors_list();

		return view('calculators.ballard.print', compact('results', 'closewinlink', 'doctor_master'));
	}
	
	/**
	 * Update the specified record.
	 *
	 * @param  int  $id
	 * @return to listing page
	 */
	public function update($id, Request $request)
	{
		$input = $request->all();

		$input['DateModified'] = Carbon::now();
		$input['UserModified'] = $this->auth->user()->id;
		$input['TestTime'] = Carbon::now();

		$input['Gestation'] = $input['g_weeks'].'+'.$input['g_days'];

		if(!empty($input["TestDate"])) {
			$input['TestDate'] = date('Y-m-d', strtotime($input["TestDate"]));
		} else {
		   $input['TestDate'] = date('Y-m-d', time());
		}
		
		$results1 = Ballard::findOrfail($id);

	
		$results1->update($input);

		$newborn = Ballard::find($input['BabyId']);
		if ($newborn) {
			$newborn->update($input);	
		}

        if ($request->ajax())
        {
            return \Response::json(['type' => 'success', 'message' => 'Record updated successfully !', 'edit_url' => action('Calculators\BallardController@edit', \SiteHelpers::encrypt_id($id)) , 'list_url' => action('Calculators\BallardController@index'), 'print_url' => action('Calculators\BallardController@print', \SiteHelpers::encrypt_id($id)) ], 200);
        }

        if ($print_flag == 1)
        {
            return redirect(action('Calculators\BallardController@edit', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record saved successfully !');
        }
        elseif ($print_flag == 2)
        {
            return redirect(action('Calculators\BallardController@print', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record saved successfully !');
        }
        else
        {
            return redirect(action('Calculators\BallardController@index'));
        }

		return redirect(action('Calculators\BallardController@index'))->with('Success', 'Record updated successfully ');
	}
	/**
	 * UPDATE THE RECORD AS DELETED AND CREATE THE REQUEST FOR APPROVAL
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		$results = Ballard::findOrfail($id);
		$user_detail = array(
			'UserDeleted'	=> $this->auth->user()->id,
			'DateModified'	=> Carbon::now(),
			'IsDeleted'		=> '1'
		);
		$results->update($user_detail);
		$result =  Ballard::get_record($id);
		$res = $result[0];
		
		$delete_data = array(
			'Name'		  	   => $res->BabyName,
			'AdmissionDate'	   => $results['TestDate'],
			'ModuleController' => 'Calculators\BallardController',
			'ModuleId'		   => $id,
			'ModuleName'	   => 'Ballard Score',
			'UserDeleted'	   => $this->auth->user()->id,
			'DateDeleted'	   => Carbon::now()
		);
		DeleteApproval::create($delete_data);
		return redirect(action('Calculators\BallardController@index'))->with('info', 'Record deleted successfully ');
	}
}
