<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Masters\DoseMaster;
use Carbon\Carbon;
use App\Models\Settings\DeleteApproval;

class DoseController extends Controller
{
    
    /**
     * constructor method
     *
     */
    public function __construct(Guard $auth)
    {
        $this->middleware('role:MAS_DOSE,write', ['only'=>['store','update','edit','create','destory']]);
        $this->middleware('role:MAS_DOSE,read', ['only'=>['index']]);  
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

        //get the dose record list form dose masters
        $result     = DoseMaster::list($request->input('page'), $limit, $search_txt, $order, 1);
        $results    = $result['result'];

        $getTotal   = DoseMaster::GetTotal();  
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

        return view('masters.dose.list', compact('results', 'pagination', 'search_txt', 'order', 'getTotal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masters.dose.create');
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

        if ($request->ajax()) {
            if (empty($input['volume'])) {
                return \Response::json(['messageType'=>'error','message'=>'Please fill the all the fields']);
            } else {        
                $post['volume']      = $input['volume'];
                $post['status']     = $input['status'];
                $post['date_added'] = Carbon::now();
                $post['user_added'] = $this->auth->user()->id;
                $id = DoseMaster::create($post)->id; 
            }
        } else {    
            if (!isset($input['volume']) || empty($input['volume'])) {
                return redirect()->back()->with('error', 'Error occurred');
            }   
            foreach ($input['volume'] as $key => $value) {
                $post['volume']      = $input['volume'][$key];
                $post['status']     = $input['status'][$key];
                $post['date_added'] = Carbon::now();
                $post['user_added'] = $this->auth->user()->id;
                $id = DoseMaster::create($post)->id; 
            }
        }

        $dose =  DoseMaster::find($id);
        if ($request->ajax()) {
            return \Response::json(['messageType'=>'success','message'=>'Added succcessfully','data'=>$dose],200);
        } else {
            return redirect(action('Masters\DoseController@index'))->with('Success', 'Record added successfully');
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
        $results = DoseMaster::findOrfail($id);

        return view('masters.dose.edit', compact('results'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $results = DoseMaster::findOrfail($id);
        
        $input = $request->all();
        
        $input['date_modified'] = Carbon::now();
        $input['user_modified'] = $this->auth->user()->id;
        
        $results->update($input);
        
        return redirect(action('Masters\DoseController@index'))->with('Success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $results = DoseMaster::findOrfail($id);

        $user_detail = array(
            'user_deleted'  => $this->auth->user()->id,
            'date_modified' => Carbon::now(),
            'is_deleted'        => '1'
        );
        $results->update($user_detail);

        $delete_data = array(
            'Name'             => $results['name'],
            'ModuleController' => 'Masters\DoseController',
            'ModuleId'         => $id,
            'ModuleName'       => 'Dose Master',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now()
        );
        DeleteApproval::create($delete_data);
        return redirect(action('Masters\DoseController@index'))->with('info', 'Record deleted successfully !');
    }
}
