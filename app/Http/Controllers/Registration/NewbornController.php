<?php namespace App\Http\Controllers\Registration;

use Carbon\Carbon;
use App\Models\Newborn;
use App\Models\Baby;
use App\Models\Mother;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewbornController extends Controller 
{
    /**
     * This used to define the
     * Guard intance
     * @var $auth
     */
    public $auth;

	public function __construct(Guard $auth)
	{
		$this->middleware('auth');
        $this->auth = $auth;
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		$results = Newborn::get_lists(); 
		return view('registration.newborn.nb_list', compact('results'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$baby = Baby::ListData();
		$babies = array();
		foreach ($baby as $data) {
			$babies[$data->BabyId] = $data->BabyName;
		}
		$SubmitButtonText  = "Save";
		
		return view('registration.newborn.nb_create', compact('babies', 'SubmitButtonText'));

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$input = $request->all();
		$baby = Baby::FindorFail($input['BabyId']);
		$input['BMrNo'] = $baby['BMrNo'];
		$input['MotherId'] = $baby['MotherId'];		
        $input['DateAdded'] = Carbon::now();
        $input['UserAdded'] = $this->auth->user()->id;
        $input['DateModified'] = Carbon::now();
        $input['UserModified'] = $this->auth->user()->id;

		Newborn::create($input);
		
		return redirect('newborn')->with('Success', 'Record saved successfully');

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
	 * @return Response
	 */
	public function edit($id)
	{
		$result = Newborn::get_record($id);
		$results = $result[0];
		$SubmitButtonText = "Update";
		return view('registration.newborn.nb_edit', compact('results', 'SubmitButtonText'));

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$input = $request->all();
		
		$input['DateModified'] = Carbon::now();

		$results1 = Newborn::findOrfail($id);
		
        $input['DateModified'] = Carbon::now();
        $input['UserModified'] = $this->auth->user()->id;
	
		$results1->update($input);

		
		return redirect('newborn')->with('Success', 'Record updated successfully');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
