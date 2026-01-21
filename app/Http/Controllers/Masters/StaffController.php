<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Masters\StaffMaster;
use App\Models\Settings\DeleteApproval;
use Illuminate\Contracts\Auth\Guard;

class StaffController extends Controller
{

    public function __construct(Guard $auth)
    {
        $this->middleware('role:MAS_STAFF,write', ['only'=>['store','update','edit','create','destory']]);
        $this->middleware('role:MAS_STAFF,read', ['only'=>['index','show']]);
        $this->auth = $auth;

    }    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

            $input = $request->all();
           
            $pagination['limits'] = (isset($input['limit']))? $input['limit']:10;
            $order['sortby']      = 'staff_id';
            $order['sortorder']   = 'desc';       
       
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {

            $order['sortby']     = \SiteHelpers::decrypt_id($request->input('sortby'));
            $order['sortorder']  = $request->input('sortorder');

        }    
            $search              = array();
            $search['search_txt']='';

       if (!empty($request->input('search_txt'))) {

            $search['search_txt'] = $request->input('search_txt');

       }

       $results = StaffMaster::GetList($pagination['limits'], $search, $order);


       return view('masters.staff.list', compact('results', 'pagination', 'order', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masters.staff.create');
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

        $length = sizeof($input['name']);
        for ($i=0; $i<$length; $i++) {
            if ($input['name'][$i] !='') {
                $post['name']          = $input['name'][$i];
                $post['qualification'] = $input['qualification'][$i];  
                $post['designation']   = $input['designation'][$i];
                $post['status']        = $input['status'][$i];
                $post['DateModified']  = Carbon::now();
                $post['DateAdded']     = Carbon::now();
                $post['UserAdded']     = $this->auth->user()->id;
                $post['UserModified']  = $this->auth->user()->id;

                StaffMaster::create($post);
            }
        }
        return redirect(action('Masters\StaffController@index'))->with('Success', 'Record added successfully');
       
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
        $results = StaffMaster::findOrfail($id);
        return view('masters.staff.edit', compact('results'));
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
       $results = StaffMaster::findOrfail($id);
        
        $input = $request->all();
        
        $input['DateModified'] = Carbon::now();
        
        $results->update($input);
        
        return redirect(action('Masters\StaffController@index'))->with('Success', 'Record updated successfully ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $results = StaffMaster::findOrfail($id);

        $user_detail = array(
            'UserDeleted'   => $this->auth->user()->id,
            'DateModified'  => Carbon::now(),
            'IsDeleted'     => 1
        );
        $results->update($user_detail);

        $delete_data = array(
            'Name'             => $results['name'],
            'ModuleController' => 'Masters\StaffController',
            'ModuleId'         => $id,
            'ModuleName'       => 'Staff',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now()
        );
        DeleteApproval::create($delete_data);
        return redirect(action('Masters\StaffController@index'))->with('info', 'Record deleted successfully ');
    }
    

    
}
