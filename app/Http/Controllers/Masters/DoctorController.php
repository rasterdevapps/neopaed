<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Masters\DoctorMaster;
use App\Models\Settings\DeleteApproval;
use Illuminate\Contracts\Auth\Guard;

class DoctorController extends Controller
{

    public function __construct(Guard $auth)
    {
        $this->middleware('role:MAS_DOCTORS,write', ['only'=>['store','update','edit','create','destroy']]);
        $this->middleware('role:MAS_DOCTORS,read', ['only'=>['index']]);   
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

        //get the doctors record list form doctors masters
        $result     = DoctorMaster::list($request->input('page'), $limit, $search_txt, $order, 1);
        $results    = $result['result'];

        $getTotal   = count(DoctorMaster::get_lists()); 
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

        return view('masters.Doctors.list', compact('results', 'pagination', 'search_txt', 'order', 'getTotal'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masters.Doctors.create');
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

        if (!isset($input['Name']) || empty($input['Name'])) {
            return redirect()->back()->with('error', 'Error occurred');
        }
        
        foreach ($input['Name'] as $key => $value) {
            $post['Name']          = $input['name_prefix'][$key].' '.$input['Name'][$key];
            $post['type']          = $input['type'][$key];
            $post['status']        = $input['status'][$key];  
            $post['Qualification'] = $input['Qualification'][$key];
            $post['job_title']     = $input['job_title'][$key];
            $post['register_no']   = $input['register_no'][$key];
            $post['DateAdded']     = Carbon::now();
            $post['UserAdded']     = $this->auth->user()->id;                  
            DoctorMaster::create($post);
        }
        
        return redirect(action('Masters\DoctorController@index'))->with('Success', 'Record added successfully');
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
        $results = DoctorMaster::findOrfail($id);
        $results->Name = isset($results->Name) ? str_replace('Dr', ' ', $results->Name) : '' ;
        return view('masters.Doctors.edit', compact('results'));
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
        $results = DoctorMaster::findOrfail($id);
        $input                 = $request->all();
        $input['Name']         = $input['name_prefix'].' '. trim($input['Name']) ;        
        $input['DateModified'] = Carbon::now();
        $input['UserModified'] = $this->auth->user()->id;                    
        $results->update($input);

        return redirect(action('Masters\DoctorController@index'))->with('Success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $results = DoctorMaster::findOrfail($id);

        $user_detail = array(
            'UserDeleted'   => $this->auth->user()->id,
            'DateModified'  => Carbon::now(),
            'IsDeleted'     => '1'
        );
        $results->update($user_detail);

        $delete_data = array(
            'Name'             => $results['Name'],
            'ModuleController' => 'Masters\DoctorController',
            'ModuleId'         => $id,
            'ModuleName'       => 'Doctor Master',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now()
        );
        DeleteApproval::create($delete_data);
        return redirect(action('Masters\DoctorController@index'))->with('info', 'Record deleted successfully ');
    }

    public function getUpdateDoctors(Request $request)
     {
        $input = $request->all();             
        $length = sizeof($input['Name']);
        

        for ($i=0; $i<$length; $i++) {
            if ($input['Name'][$i] !='') {
                $post['Name'] = $input['name_prefix'][$i].' '.$input['Name'][$i];
                $post['type'] = $input['type'][$i];
                $post['status'] = $input['status'][$i];  
                $post['Qualification'] = $input['Qualification'][$i];
                $post['UserAdded'] = $this->auth->user()->id;
                $post['UserModified'] =$this->auth->user()->id;                    
                $post['DateModified'] = Carbon::now();
                $post['DateAdded'] = Carbon::now();
                $id = DoctorMaster::create($post)->id;
                $results=DoctorMaster::find($id);
            }
        }
        return \Response::json(['messageType'=>'success','message'=>'Added succcessfully', 'data'=>$results],200);
     }
}
