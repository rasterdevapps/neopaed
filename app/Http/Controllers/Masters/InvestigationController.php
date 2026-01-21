<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Masters\InvestigationMaster;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Settings\DeleteApproval;

class InvestigationController extends Controller
{
    /**
     * Time zone type 
     *  
     * @var $time_zone
     */
    protected $time_zone;

    function __construct(Guard $auth)
    {
        $this->time_zone = env('TIME_ZONE');
        $this->auth      = $auth;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = InvestigationMaster::getInvestigationList();

        return view('masters.investigation.list', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masters.investigation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input  = $request->all();
        $length = sizeof($input['Name']);

        for ($i = 0; $i < $length; $i++) { 
            if ($input['Name'][$i] != '') {
                $post['Name']         = $input['Name'][$i];
                $post['Status']       = $input['Status'][$i];
                $post['DateAdded']    = Carbon::now($this->time_zone);
                $post['DateModified'] = Carbon::now($this->time_zone);
                $post['UserAdded']    = $this->auth->user()->id;
                InvestigationMaster::create($post);
            }
        }
        return redirect(action('Masters\InvestigationController@index'))->with('Success', 'Record added successfully');
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
        $results = InvestigationMaster::find($id);

        return view('masters.investigation.edit', compact('results'));
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
        $results = InvestigationMaster::findOrfail($id);

        $input   = $request->all();

        $input['UserModified'] = $this->auth->user()->id;
        $input['DateModified'] = Carbon::now($this->time_zone);

        $results->update($input);

        return redirect(action('Masters\InvestigationController@index'))->with('Success', 'Record updated successfully ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $results = InvestigationMaster::findOrfail($id);

        $user_detail = array(
            'UserDeleted' => $this->auth->user()->id,
            'DateModified'=> Carbon::now($this->time_zone),
            'IsDeleted'   =>  '1'
        );

        $results->update($user_detail);

        $delete_data = array(
            'Name'             => $results['Name'],
            'ModuleController' => 'Masters\InvestigationController',
            'ModuleId'         => $id,
            'ModuleName'       => 'Investigation Master',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now($this->time_zone)
        );
        DeleteApproval::create($delete_data);

        return redirect(action('Masters\InvestigationController@index'))->with('info', 'Record deleted successfully ');
    }
}
