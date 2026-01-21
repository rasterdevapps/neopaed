<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LocalCodeGroup;
use Illuminate\Contracts\Auth\Guard;
use Carbon\Carbon;

class LocalCodeGroupController extends Controller
{
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = LocalCodeGroup::list();
        return view('fihr.local_code_group_list',compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$results = LocalCodeGroup::findOrfail($id);

    	$input = $request->all();
		
        $input['chart_type'] = $input['chart_type'] == 'Box' ? 1 : 0;
		$input['modify_user_id'] = $this->auth->user()->id;
		$input['modify_tstamp'] = Carbon::now();
		
		$results->update($input);
		
        return \Response::json(['messageType' => 'success', 'message' => 'Succcessfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
