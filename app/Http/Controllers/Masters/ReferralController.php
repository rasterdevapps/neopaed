<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Masters\ReferralMaster;
use Carbon\Carbon;
use App\Models\Settings\DeleteApproval;

class ReferralController extends Controller
{
    /**
     * constructor method
     *
     */
    public function __construct(Guard $auth)
    {
        $this->middleware('role:MAS_REFERRAL,write', ['only'=>['store','update','edit','create','destory']]);
        $this->middleware('role:MAS_REFERRAL,read', ['only'=>['index']]);  
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
        $order['sortorder'] = 'desc';   

        //set the records sorting key and order  
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {

            $order['sortby']    = \SiteHelpers::decrypt_id($request->input('sortby'));
            $order['sortorder'] = $request->input('sortorder');

        }

        //initialize search parameter 
        $search_txt = !empty($request->input('search_txt')) ? $request->input('search_txt') : '';

        //get the frequency record list form frequency masters
        $result     = ReferralMaster::list($request->input('page'), $limit, $search_txt, $order, 1);
        $results    = $result['result'];

        $getTotal   = ReferralMaster::GetTotal();  
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

        return view('masters.referral.list', compact('results', 'pagination', 'search_txt', 'order', 'getTotal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masters.referral.create');
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
        
        if (!isset($input['doctor_name']) || empty($input['doctor_name'])) {
            return redirect()->back()->with('error', 'Error occurred');
        }

        foreach ($input['doctor_name'] as $key => $value) {
            $post['doctor_name']     = isset($input['doctor_name'][$key]) ? $input['doctor_name'][$key] : '';
            $post['hospital_name']   = isset($input['hospital_name'][$key]) ? $input['hospital_name'][$key] : '';
            $post['hospital_number'] = isset($input['hospital_number'][$key]) ? $input['hospital_number'][$key] : '';
            $post['hospital_email']  = isset($input['hospital_email'][$key]) ? $input['hospital_email'][$key] : '';
            $post['status']      = $input['status'][$key];
            $post['date_added']  = Carbon::now();
            $post['user_added']  = $this->auth->user()->id;
            $id = ReferralMaster::create($post)->id; 
        }

        $ref =  ReferralMaster::find($id);
        if ($request->ajax()) {
            return \Response::json(['messageType'=>'success','message'=>'Added succcessfully','data'=>$ref],200);
        } else {
            return redirect(action('Masters\ReferralController@index'))->with('Success', 'Record added successfully');
        }
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
        $results = ReferralMaster::findOrfail($id);
        return view('masters.referral.edit', compact('results'));
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
        $results = ReferralMaster::findOrfail($id);
        
        $input = $request->all();
        
        $input['date_modified'] = Carbon::now();
        $input['user_modified'] = $this->auth->user()->id;
        
        $results->update($input);
        
        return redirect(action('Masters\ReferralController@index'))->with('Success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $results = ReferralMaster::findOrfail($id);

        $user_detail = array(
            'user_deleted'  => $this->auth->user()->id,
            'date_modified' => Carbon::now(),
            'is_deleted'        => '1'
        );
        $results->update($user_detail);

        $delete_data = array(
            'Name'             => $results['name'],
            'ModuleController' => 'Masters\ReferralController',
            'ModuleId'         => $id,
            'ModuleName'       => 'Referral Master',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now()
        );
        DeleteApproval::create($delete_data);
        return redirect(action('Masters\ReferralController@index'))->with('info', 'Record deleted successfully !');
    }
}
