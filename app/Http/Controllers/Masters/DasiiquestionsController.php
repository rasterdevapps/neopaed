<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Masters\DasiiquestionsMaster;
use Carbon\Carbon;
use App\Models\Settings\DeleteApproval;

class DasiiquestionsController extends Controller
{
    /**
     * constructor method
     *
     */
    public function __construct(Guard $auth)
    {
        $this->middleware('role:MAS_DASII_QUESTIONS,write', ['only'=>['store','update','edit','create','destory']]);
        $this->middleware('role:MAS_DASII_QUESTIONS,read', ['only'=>['index']]);  
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
        $results     = DasiiquestionsMaster::list();

        return view('masters.dasii_questions.list', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masters.dasii_questions.create');
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
                $dasii_question['question']          = $input['question'][$key];
                $dasii_question['question_type']    = isset($input['question_type'][$key]) && !empty($input['question_type'][$key]) ? $input['question_type'][$key] : '';
                $dasii_question['fiftieth_percentile']    = isset($input['fiftieth_percentile'][$key]) && !empty($input['fiftieth_percentile'][$key]) ? $input['fiftieth_percentile'][$key] : '';
                $dasii_question['third_percentile']    = isset($input['third_percentile'][$key]) && !empty($input['third_percentile'][$key]) ? $input['third_percentile'][$key] : '';
                $dasii_question['ninety_seventh_percentile']    = isset($input['ninety_seventh_percentile'][$key]) && !empty($input['ninety_seventh_percentile'][$key]) ? $input['ninety_seventh_percentile'][$key] : '';
                $dasii_question['content_cluster']    = isset($input['content_cluster'][$key]) && !empty($input['content_cluster'][$key]) ? $input['content_cluster'][$key] : '';
                $dasii_question['status']            = isset($input['status'][$key]) && $input['status'][$key] == '1' ? true : false;
                $dasii_question['created_date']      = Carbon::now();
                $dasii_question['created_user']        = $this->auth->user()->id;
                if (empty($dasii_question['question_type'])) {
                    $dasii_question['question_type'] = 'motor';
                }
                DasiiquestionsMaster::insert($dasii_question); 
            }
        }
        
        return redirect(action('Masters\DasiiquestionsController@index'))->with('Success', 'Record added successfully');
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

        $results = DasiiquestionsMaster::findOrfail($id);

        return view('masters.dasii_questions.edit', compact('results'));
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
        $questions['question_type']    = isset($input['question_type'][$key]) && !empty($input['question_type'][$key]) ? $input['question_type'][$key] : '';
        $questions['fiftieth_percentile']    = isset($input['fiftieth_percentile'][$key]) && !empty($input['fiftieth_percentile'][$key]) ? $input['fiftieth_percentile'][$key] : '';
        $questions['third_percentile']    = isset($input['third_percentile'][$key]) && !empty($input['third_percentile'][$key]) ? $input['third_percentile'][$key] : '';
        $questions['ninety_seventh_percentile']    = isset($input['ninety_seventh_percentile'][$key]) && !empty($input['ninety_seventh_percentile'][$key]) ? $input['ninety_seventh_percentile'][$key] : '';
        $questions['content_cluster']    = isset($input['content_cluster'][$key]) && !empty($input['content_cluster'][$key]) ? $input['content_cluster'][$key] : '';
        $questions['status'] = isset($input['status'][$key]) && $input['status'][$key] == '1' ? true : false;
        $questions['modified_date'] = Carbon::now();
        $questions['modified_user'] = $this->auth->user()->id;

        $results = DasiiquestionsMaster::findOrfail($id);
        $results->update($questions);

        return redirect(action('Masters\DasiiquestionsController@index'))->with('Success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $results = DasiiquestionsMaster::findOrfail($id);

        $user_detail = array(
            'deleted_by'    => $this->auth->user()->id,
            'modified_time' => Carbon::now(),
            'is_deleted'    => '1'
        );
        $results->update($user_detail);

        $delete_data = array(
            'Name'             => $results->id,
            'ModuleController' => 'Masters\DasiiquestionsController',
            'ModuleId'         => $id,
            'ModuleName'       => 'DASII Questions Master',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now()
        );
        DeleteApproval::create($delete_data);

        return redirect(action('Masters\DasiiquestionsController@index'))->with('info', 'Record deleted successfully !');
    }
}
