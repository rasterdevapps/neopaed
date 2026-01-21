<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Masters\Admissionmode;
use Illuminate\Contracts\Auth\Guard;
use Carbon\Carbon;
use App\Models\Settings\DeleteApproval;

class AdmissionmodeController extends Controller
{

    public function __construct(Guard $auth)
    {
        $this->middleware('role:MAS_ADMISSIONMODE,write', ['only'=>['store','update','edit','create','destory']]);
        $this->middleware('role:MAS_ADMISSIONMODE,read', ['only'=>['index','show']]);
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
        $order['sortby']    = 'Id';
        $order['sortorder'] = 'desc';   

        //set the records sorting key and order  
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {

            $order['sortby']    = \SiteHelpers::decrypt_id($request->input('sortby'));
            $order['sortorder'] = $request->input('sortorder');

        }

        //initialize search parameter 
        $search_txt = !empty($request->input('search_txt')) ? $request->input('search_txt') : '';

        //get the admission mode record list form admission mode masters
        $result     = Admissionmode::list($request->input('page'), $limit, $search_txt, $order, 1);
        $results    = $result['result'];

        $getTotal   = count(Admissionmode::GetList()); 
        $total      = $result['total']; 

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

        return view('masters.admissionmode.list', compact('results', 'pagination', 'search_txt', 'order', 'getTotal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('masters.admissionmode.create');
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
        
        if (!isset($input['Mode_name']) || empty($input['Mode_name'])) {
            return redirect()->back()->with('error', 'Error occurred');
        }

        foreach ($input['Mode_name'] as $key => $value) {
            $post['Mode_name']    = $input['Mode_name'][$key];
            $post['Status']       = $input['Status'][$key];                     
            $post['DateAdded']    = Carbon::now();
            $post['UserAdded']    = $this->auth->user()->id;
            $post['DateModified'] = Carbon::now();
            $post['UserModified'] = $this->auth->user()->id;
            Admissionmode::create($post);
        }
        return redirect(action('Masters\AdmissionmodeController@index'))->with('Success', 'Record added successfully');
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
        $results = Admissionmode::findOrfail($id);
        return view('masters.admissionmode.edit', compact('results'));
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
       $results = Admissionmode::findOrfail($id);
        
        $input = $request->all();
        
        $input['DateModified'] = Carbon::now();
        $input['UserModified'] = $this->auth->user()->id;
        
        $results->update($input);
        
        return redirect(action('Masters\AdmissionmodeController@index'))->with('Success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $results = Admissionmode::findOrfail($id);

        $user_detail = array(
            'UserDeleted'   => $this->auth->user()->id,
            'DateModified'  => Carbon::now(),
            'IsDeleted'     => '1'
        );
        $results->update($user_detail);

        $delete_data = array(
            'Name'             => $results['Name'],
            'ModuleController' => 'Masters\AdmissionmodeController',
            'ModuleId'         => $id,
            'ModuleName'       => 'Admission Mode',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now()
        );
        DeleteApproval::create($delete_data);
        return redirect(action('Masters\AdmissionmodeController@index'))->with('info', 'Record deleted successfully');
    }
}
