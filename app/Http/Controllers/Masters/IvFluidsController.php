<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Masters\IvFluids;
use Illuminate\Contracts\Auth\Guard;
use Carbon\Carbon;
use App\Models\Settings\DeleteApproval;

class IvFluidsController extends Controller
{


    public function __construct(Guard $auth)
    {
        $this->middleware('role:MAS_IVFLUIDS,write', ['only'=>['store','update','edit','create','destroy']]);
        $this->middleware('role:MAS_IVFLUIDS,read', ['only'=>['index']]);   
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

        //get the mother record list form mother masters
        $result     = IvFluids::list($request->input('page'), $limit, $search_txt, $order, 1);
        $results    = $result['result'];

        $getTotal   = count(IvFluids::get_lists()); 
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

        return view('masters.ivfluids.list', compact('results', 'pagination', 'search_txt', 'order', 'getTotal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

       return view('masters.ivfluids.create');
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
         $id    = null;


        foreach ($input['name'] as $key => $value) {
            $ivfluids['name']                 = $input['name'][$key];
            $ivfluids['status']               = ($input['status'][$key] == 'Active') ? 1 : 0;
            $ivfluids['UserAdded']            = $this->auth->user()->id;
            $ivfluids['DateAdded']            = Carbon::now();
            $ivfluids['DateModified']         = Carbon::now();
            $ivfluids['IsDeleted']            = '0';
            $ivfluids['pharmacological_name'] = $input['pharmacological_name'][0]; 
            $ivfluids['group_id']             = $id;

            if ($key == 0) {
                $id = IvFluids::create($ivfluids)->id;     
            } else {
                IvFluids::create($ivfluids);
            }

            $ivfluids_group =  IvFluids::find($id);
            $ivfluids_group_id['group_id'] =  $id ;
            $ivfluids_group->Update($ivfluids_group_id);
        }


         return redirect(action('Masters\IvFluidsController@index'))->with('Success','Record added successfully'); 
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
        // $results =  IvFluids::where('group_id', $id)->get();
        $results = IvFluids::findOrfail($id);

        return view('masters.ivfluids.edit',compact('results'));
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
         $input   = $request->all();

        foreach ($input['name'] as $key => $value) {
            $ids = explode('-', $key);

            $status =  $key;

            if (count($ids) == 2) {
                $status =$ids[0].'-status';  
            }
            
            $iv_fluids['name']                  = $input['name'][$key];
            $iv_fluids['status']                = ($input['status'][$status] == 'Active') ? '1' : '0' ;
            $iv_fluids['DateModified']          = Carbon::now();
            $iv_fluids['UserModified']          = $this->auth->user()->id;
            $iv_fluids['pharmacological_name']  = $input['pharmacological_name'];        
            $iv_fluids['group_id']              = $id; 
               
            if (count($ids) == 2) {
                $results =  IvFluids::find($ids[0]);
                $results->Update($iv_fluids);
            } else {
                
                 IvFluids::create($iv_fluids);
            }
            
        }
         
         return redirect(action('Masters\IvFluidsController@index'))->with('Success','Record updated successfully'); 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $results = IvFluids::findOrfail($id);

        $user_detail = array(
            'UserDeleted'   => $this->auth->user()->id,
            'DateModified'  => Carbon::now(),
            'IsDeleted'     => '1'
        );
        $results->update($user_detail);

        $delete_data = array(
            'Name'             => $results['name'],
            'ModuleController' => 'Masters\IvFluidsController',
            'ModuleId'         => $id,
            'ModuleName'       => 'IvFluids Master',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now()
        );
        DeleteApproval::create($delete_data);
        return redirect(action('Masters\IvFluidsController@index'))->with('info', 'Record deleted successfully !');


       
    }
    /**
     * This method to get update medicines
     *
     */
    public function getUpdateMaster(Request $request)
    {
        $input = $request->all();
         $id  =  null;

        for ($i=0; $i < count($input['name']); $i++) { 

            $ivfluids['name']                 = $input['name'][$i];
            $ivfluids['status']               = ($input['status'][$i] == 'Active') ? 1 : 0;
            $ivfluids['UserAdded']            = $this->auth->user()->id;
            $ivfluids['DateAdded']            = Carbon::now();
            $ivfluids['DateModified']         = Carbon::now();
            $ivfluids['IsDeleted']            = '0';
            $ivfluids['pharmacological_name'] = $input['pharmacological_name'][0]; 
            $ivfluids['group_id']             =  $id;

            if ($i == 0) {
               $id = IvFluids::create($ivfluids)->id;     
            } else {
               IvFluids::create($ivfluids);
            }

            $ivfluids_group =  IvFluids::find($id);
            $ivfluids_group_id['group_id'] =  $id ;
            $ivfluids_group->Update($ivfluids_group_id);


        }

       return \Response::json(['messageType'=>'success','message'=>'Added succcessfully','data'=>$ivfluids_group],200);

    }
}
