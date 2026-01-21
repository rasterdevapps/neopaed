<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\DrugAndInfusion;
use Illuminate\Contracts\Auth\Guard;


class DrugAndInfusionController extends Controller
{
	public function __construct(Guard $auth)
	{
		$this->middleware('role:MAS_DRUGS_AND_INFUSION,write', ['only'=>['store','update','edit','create','destroy']]);
		$this->middleware('role:MAS_DRUGS_AND_INFUSION,read', ['only'=>['index']]);	
		$this->auth = $auth;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{
		//
		$results = DrugAndInfusion::ListData();

		return view('masters.drug_and_infusion.list', compact('results'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
		return view('masters.drug_and_infusion.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return listing page.
	 */
	public function store(Request $request)
	{
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
				$id=DrugAndInfusion::create($post)->Id;
			    else
			    	DrugAndInfusion::create($post);
			}
		}
		unset($post);
		$results= DrugAndInfusion::findOrfail($id);
		$post['drug_group_id']= $id ; 
		$results->update($post);

		return redirect(action('Masters\DrugAndInfusionController@index'))->with('Success', 'Record added successfully');
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
		$results = DrugAndInfusion::findOrfail($id);
		return view('masters.drug_and_infusion.edit', compact('results'));
	}
	/**
	 * Update the specified record in storage.
	 *
	 * @param  int  $id
	 * @redirect listing page
	 */
	public function update($id, Request $request)
	{
		$results = DrugAndInfusion::findOrfail($id);
		
		$input = $request->all();
		
		$input['DateModified'] = Carbon::now();
		
		$results->update($input);
		
		return redirect(action('Masters\DrugAndInfusionController@index'))->with('Success', 'Record updated successfully ');
	}
	/**
	* UPDATE THE RECORD AS DELETED AND CREATE THE REQUEST FOR APPROVAL
	*/
	public function destroy($id)
	{
		$results = DrugAndInfusion::findOrfail($id);

		$user_detail = array(
			'UserDeleted'	=> $this->auth->user()->id,
			'DateModified'	=> Carbon::now(),
			'IsDeleted'		=> '1'
		);
		$results->update($user_detail);

		$delete_data = array(
			'Name'		  	   => $results['Name'],
			'ModuleController' => 'Masters\DrugAndInfusionController',
			'ModuleId'		   => $id,
			'ModuleName'	   => 'Drug Master',
			'UserDeleted'	   => $this->auth->user()->id,
			'DateDeleted'	   => Carbon::now()
		);
		DeleteApproval::create($delete_data);
		return redirect(action('Masters\DrugAndInfusionController@index'))->with('info', 'Record deleted successfully ');

	}

    /**
     * get barand Name.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getBrandName($conceptID)
    {

        $drugMasterBrand    = DrugAndInfusion::getBrandList($conceptID);

        return \Response::json(['status'=>'successs','drugs'=>$drugMasterBrand], 200);

    }

    /**
     * get barand Name.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getGenericName()
    {
    	 $drugMaster         = DrugAndInfusion::getDrugList();
        return \Response::json(['status'=>'successs','drugs'=>$drugMaster], 200);

    }
    public function getprescription() 
    {
       $drugMaster         = DrugAndInfusion::getDrugList();


      return view('masters.drug_and_infusion.test', compact('drugMaster'));
    }
}
