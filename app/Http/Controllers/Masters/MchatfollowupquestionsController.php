<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Masters\MchatquestionsfollowupMaster;
use Carbon\Carbon;
use App\Models\Settings\DeleteApproval;

class MchatfollowupquestionsController extends Controller
{
    /**
     * constructor method
     *
     */
    public function __construct(Guard $auth)
    {
        $this->middleware('role:MAS_M_CHAT_R_QUESTIONS,write', ['only'=>['store','update','edit','create','destory']]);
        $this->middleware('role:MAS_M_CHAT_R_QUESTIONS,read', ['only'=>['index']]);  
        $this->auth = $auth;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $results     = MchatquestionsfollowupMaster::list();

        return view('masters.m_chat_questions_followup.list', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $questions = MchatquestionsfollowupMaster::getQuestions();
        return view('masters.m_chat_questions_followup.create', compact('questions'));
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
        if (isset($input['question']) && $input['question'] != '' && isset($input['correct_answer']) && $input['correct_answer']) {
            $insert['question']             = $input['question'];
            $insert['correct_answer']       = $input['correct_answer'];
            $insert['answer_based_type']    = isset($input['question_type']) && !empty($input['question_type']) ? $input['question_type'] : null;
            $insert['created_time']         = Carbon::now();
            $insert['created_by']           = $this->auth->user()->id;
            $id = MchatquestionsfollowupMaster::insertGetId($insert);
            return \Response::json(['message'=> 'Question inserted successfully', 'question_id' => $id], 200);
        }
        else
        {
            return \Response::json(['message'=> 'Failed'], 500);
        }
        return redirect(action('Masters\MchatfollowupquestionsController@index'))->with('Success', 'Record added successfully');
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

        $results = MchatquestionsfollowupMaster::findOrfail($id);

        return view('masters.m_chat_questions_followup.edit', compact('results'));
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
        unset($input['id']);
        $input['correct_answer'] = isset($input['correct_answer']) && $input['correct_answer'] == 'on' ? 'Yes' : 'No';
        $input['answer_based_type'] = isset($input['answer_based_type']) && $input['answer_based_type'] == 'on' ? 'Yes' : 'No';
        $input['modified_time'] = Carbon::now();
        $input['modified_by'] = $this->auth->user()->id;

        $results = MchatquestionsfollowupMaster::findOrfail($id);
        $results->update($input);
        if ($request->ajax()) {
            return \Response::json(['message'=> 'success'], 200);
        }
        else
        {
            return redirect(action('Masters\MchatfollowupquestionsController@index'))->with('success', 'Question updated successfully !');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateParent(Request $request, $id = 0)
    {
        $input = $request->all();

        $id = $input['id'];
        unset($input['id']);
        $input['modified_time'] = Carbon::now();
        $input['modified_by'] = $this->auth->user()->id;

        $results = MchatquestionsfollowupMaster::findOrfail($id);
        $results->update($input);
        return \Response::json(['message'=> 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $results = MchatquestionsfollowupMaster::findOrfail($id);

        $user_detail = array(
            'deleted_by'    => $this->auth->user()->id,
            'modified_time' => Carbon::now(),
            'is_deleted'    => '1'
        );
        $results->update($user_detail);

        $delete_data = array(
            'Name'             => $results->id,
            'ModuleController' => 'Masters\MchatfollowupquestionsController',
            'ModuleId'         => $id,
            'ModuleName'       => 'M-CHAT-R Questions Master',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now()
        );
        DeleteApproval::create($delete_data);

        return redirect(action('Masters\MchatfollowupquestionsController@index'))->with('info', 'Record deleted successfully !');
    }

    /**
     * Method to get the test list by package selection.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getTestList(Request $request)
    {
        $package_id = $request->input('package_id');

        $results = [];

        if (!empty($package_id)) {
            $results = InvestigationsTestMaster::getTestList($package_id)->groupBy('package_id');
        }

        return \Response::json(['results'=>$results]);
    }
}
