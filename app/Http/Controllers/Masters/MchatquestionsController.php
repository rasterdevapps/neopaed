<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Masters\MchatquestionsMaster;
use Carbon\Carbon;
use App\Models\Settings\DeleteApproval;

class MchatquestionsController extends Controller
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

        //get the frequency record list form frequency masters
        $results     = MchatquestionsMaster::list();

        return view('masters.m_chat_questions.list', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masters.m_chat_questions.create');
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
                $test_post['question']          = $input['question'][$key];
                $test_post['correct_answer']    = isset($input['answer'][$key]) && $input['answer'][$key] == 'on' ? 'Yes' : 'No';
                $test_post['status']            = isset($input['status'][$key]) ? $input['status'][$key] : false;
                $test_post['created_time']      = Carbon::now();
                $test_post['created_by']        = $this->auth->user()->id;
                MchatquestionsMaster::insert($test_post); 
            }
        }
        
        return redirect(action('Masters\MchatquestionsController@index'))->with('Success', 'Record added successfully');
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

        $results = MchatquestionsMaster::findOrfail($id);

        return view('masters.m_chat_questions.edit', compact('results'));
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
        $package_post['question'] = $input['question'];
        $package_post['correct_answer'] = isset($input['correct_answer']) && $input['correct_answer'] == 'on' ? 'Yes' : 'No';
        $package_post['status'] = isset($input['status']) ? $input['status'] : false;
        $package_post['modified_time'] = Carbon::now();
        $package_post['modified_by'] = $this->auth->user()->id;

        $results = MchatquestionsMaster::findOrfail($id);
        $results->update($package_post);

        return redirect(action('Masters\MchatquestionsController@index'))->with('Success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $results = MchatquestionsMaster::findOrfail($id);

        $user_detail = array(
            'deleted_by'    => $this->auth->user()->id,
            'modified_time' => Carbon::now(),
            'is_deleted'    => '1'
        );
        $results->update($user_detail);

        $delete_data = array(
            'Name'             => $results->id,
            'ModuleController' => 'Masters\MchatquestionsController',
            'ModuleId'         => $id,
            'ModuleName'       => 'M-CHAT-R Questions Master',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now()
        );
        DeleteApproval::create($delete_data);

        return redirect(action('Masters\MchatquestionsController@index'))->with('info', 'Record deleted successfully !');
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
