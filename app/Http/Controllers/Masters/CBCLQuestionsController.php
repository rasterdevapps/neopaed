<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Masters\CBCLquestionsMaster;
use Carbon\Carbon;
use App\Models\Settings\DeleteApproval;

class CBCLQuestionsController extends Controller
{
    /**
     * constructor method
     *
     */
    public function __construct(Guard $auth)
    {
        $this->middleware('role:MAS_CBCL_QUESTIONS,write', ['only'=>['store','update','edit','create','destory']]);
        $this->middleware('role:MAS_CBCL_QUESTIONS,read', ['only'=>['index']]);  
        $this->auth = $auth;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //get the frequency record list form frequency masters
        $results     = CBCLquestionsMaster::list();

        return view('masters.cbcl_questions.list', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masters.cbcl_questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        if (!isset($input['question']) || empty($input['question'])) {
            return redirect()->back()->with('error', 'Error occurred');
        }

        foreach ($input['question'] as $key => $value) {
            if (isset($input['question']) && $input['question'] != '') {
                $cbcl_question['question']     = $input['question'][$key];
                $cbcl_question['category']     = $input['category'][$key];
                $cbcl_question['describe']     = (isset($input['describe'][$key]) && $input['describe'][$key] == 'on') ? true : false;
                $cbcl_question['status']       = $input['status'][$key] == 1 ? true : false;
                $cbcl_question['created_date_time'] = Carbon::now();
                $cbcl_question['created_user_id'] = $this->auth->user()->id;
                CBCLquestionsMaster::insert($cbcl_question); 
            }
        }
        
        return redirect(action('Masters\CBCLQuestionsController@index'))->with('Success', 'Record added successfully');
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
        $id = \SiteHelpers::decrypt_id($id);

        $results = CBCLquestionsMaster::findOrfail($id);

        return view('masters.cbcl_questions.edit', compact('results'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = 0)
    {
        $input = $request->all();

        $id = $input['id'];
        $questions['question'] = $input['question'];
        $questions['category'] = $input['category'];
        $questions['describe'] = (isset($input['describe']) && $input['describe'] == 'on') ? true : false;
        $questions['status'] = $input['status'] == 1 ? true : false;
        $questions['modified_date_time'] = Carbon::now();
        $questions['modified_user_id'] = $this->auth->user()->id;

        $results = CBCLquestionsMaster::findOrfail($id);
        $results->update($questions);

        return redirect(action('Masters\CBCLQuestionsController@index'))->with('Success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $results = CBCLquestionsMaster::findOrfail($id);

        $user_detail = array(
            'deleted_user_id'   => $this->auth->user()->id,
            'deleted_date_time' => Carbon::now(),
            'is_deleted'        => 1
        );
        $results->update($user_detail);
        $results = CBCLquestionsMaster::findOrfail($id);

        $delete_data = array(
            'Name'             => $results->id,
            'ModuleController' => 'Masters\CBCLQuestionsController',
            'ModuleId'         => $id,
            'ModuleName'       => 'CBCL Questions Master',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now()
        );
        DeleteApproval::create($delete_data);

        return redirect(action('Masters\CBCLQuestionsController@index'))->with('info', 'Record deleted successfully !');
    }
}
