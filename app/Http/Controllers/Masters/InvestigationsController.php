<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Masters\InvestigationsPackageMaster;
use App\Models\Masters\InvestigationsTestMaster;
use Carbon\Carbon;
use App\Models\Settings\DeleteApproval;

class InvestigationsController extends Controller
{
    /**
     * constructor method
     *
     */
    public function __construct(Guard $auth)
    {
        $this->middleware('role:MAS_INVESTIGATIONS,write', ['only'=>['store','update','edit','create','destory']]);
        $this->middleware('role:MAS_INVESTIGATIONS,read', ['only'=>['index']]);  
        $this->auth = $auth;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //Initialize the record  limit  with 50
        $limit = 50;

        //set the limit as per the request
        if (!empty($request->input('limit'))) {

            $request->session()->put('limit', $request->input('limit'));
            $limit = $request->session()->get('limit');

        } elseif ($request->session()->has('limit')) {

            $limit = $request->session()->get('limit');

        }

        //Initialize the record sorting key and order  
        $order['sortby']    = 'id';
        $order['sortorder'] = 'asc';   

        //set the records sorting key and order  
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {

            $order['sortby']    = \SiteHelpers::decrypt_id($request->input('sortby'));
            $order['sortorder'] = $request->input('sortorder');

        }

        //initialize search parameter 
        $search_txt = !empty($request->input('search_txt')) ? $request->input('search_txt') : '';

        //get the frequency record list form frequency masters
        $result     = InvestigationsPackageMaster::list($request->input('page'), $limit, $search_txt, $order, 1);
        $results    = $result['result'];

        $getTotal   = InvestigationsPackageMaster::GetTotal();  
        $total      = $result['total']; 

        // Set page
        $page                   = !empty($request->input('page')) ? $request->input('page') : 1;
        $pagecount              = (!empty($search['search_txt'])) ? ceil($total/$limit) : ceil($total/$limit);
        $pagination['total']    = $total;
        $pagination['start']    = (($page-2) < 1) ? 1 : ($page-2);
        $pagination['end']      = ($pagecount < ($page+3)) ? $pagecount : ($page+3);
        $pagestart              = $total != 0 ? ($page <= 1) ? $page : ($page-1)*$limit + 1 : 0;
        $pagerecords            = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page*$limit;
        $pagination['limit']    = array($pagestart, $pagerecords);
        $pagination['limits']   = $limit;
        $pagination['previous'] = (($page-1) < 1) ? 1 : ($page-1);
        $pagination['next']     = ($pagecount < ($page+1)) ? $pagecount : ($page+1);

        return view('masters.investigations.list', compact('results', 'pagination', 'search_txt', 'order', 'getTotal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masters.investigations.create');
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
        if (!isset($input['package_name']) || empty($input['package_name'])) {
            return redirect()->back()->with('error', 'Error occurred');
        }
        $package_post['package_name']   = $input['package_name'];
        $package_post['package_status'] = $input['package_status'];
        $package_post['created_date_time'] = Carbon::now();
        $package_post['created_user_id']   = $this->auth->user()->id;
        $id = InvestigationsPackageMaster::create($package_post)->id; 

        $test_post['package_id']        = $id;
        $test_post['created_date_time'] = Carbon::now();
        $test_post['created_user_id']   = $this->auth->user()->id;
        foreach ($input['test_name'] as $key => $value) {
            $test_post['test_name']         = $input['test_name'][$key];
            $test_post['test_status']       = $input['test_status'][$key];
            InvestigationsTestMaster::insert($test_post); 
        }
        
        return redirect(action('Masters\InvestigationsController@index'))->with('Success', 'Record added successfully');
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

        $results = InvestigationsPackageMaster::findOrfail($id);

        return view('masters.investigations.edit', compact('results'));
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

        $id = $input['package_id'];
        $package_post['package_name'] = $input['package_name'];
        $package_post['package_status'] = $input['package_status'];
        $package_post['modified_date_time'] = Carbon::now();
        $package_post['modified_user_id'] = $this->auth->user()->id;

        $results = InvestigationsPackageMaster::findOrfail($id);
        $results->update($package_post);

        $old_test_list = InvestigationsTestMaster::getTestList($id)->pluck('id', 'id');
        
        foreach ($input['test_name'] as $key => $value) {

            if (!isset($input['test_id'][$key])){     
                $post['package_id']        = $input['package_id'];
                $post['test_name']         = $input['test_name'][$key];
                $post['test_status']       = $input['test_status'][$key];
                $post['created_date_time'] = Carbon::now();
                $post['created_user_id']   = $this->auth->user()->id;
                InvestigationsTestMaster::insert($post); 
            } else { 

                $id = $input['test_id'][$key];

                $results = InvestigationsTestMaster::findOrfail($id);

                $post['test_name'] = $value;
                $post['test_status'] = $input['test_status'][$key];
                $post['modified_date_time'] = Carbon::now();
                $post['modified_user_id'] = $this->auth->user()->id;

                $results->update($post);

                unset($old_test_list[$id]);
            }
        }    

        foreach ($old_test_list as $key => $value) {
            $results = InvestigationsTestMaster::findOrfail($value);
            
            $post['is_deleted'] = true;
            $post['deleted_user_id'] = $this->auth->user()->id;
            
            $results->update($post);
        }    
        
        return redirect(action('Masters\InvestigationsController@index'))->with('Success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $test_list = \ValuelistHelpers::get_test_investigations_master($id);

        foreach ($test_list as $key => $value) {

            $results = InvestigationsTestMaster::findOrfail($value->id);

            $user_detail = array(
                'deleted_user_id'    => $this->auth->user()->id,
                'modified_date_time' => Carbon::now(),
                'is_deleted'         => '1'
            );
            $results->update($user_detail);

            $delete_data = array(
                'Name'             => $results->test_name,
                'ModuleController' => 'Masters\InvestigationsController',
                'ModuleId'         => $value->id,
                'ModuleName'       => 'Investigations Test Master',
                'UserDeleted'      => $this->auth->user()->id,
                'DateDeleted'      => Carbon::now()
            );
            DeleteApproval::create($delete_data);

        }

        $results = InvestigationsPackageMaster::findOrfail($id);

        $user_detail = array(
            'deleted_user_id'    => $this->auth->user()->id,
            'modified_date_time' => Carbon::now(),
            'is_deleted'         => '1'
        );
        $results->update($user_detail);

        $delete_data = array(
            'Name'             => $results->package_name,
            'ModuleController' => 'Masters\InvestigationsController',
            'ModuleId'         => $id,
            'ModuleName'       => 'Investigations Package Master',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now()
        );
        DeleteApproval::create($delete_data);

        return redirect(action('Masters\InvestigationsController@index'))->with('info', 'Record deleted successfully !');
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
