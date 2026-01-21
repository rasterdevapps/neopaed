<?php

namespace App\Http\Controllers\Masters;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Settings\DeleteApproval;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Models\Masters\Surgeon;

class SurgeonController extends Controller
{
     public function __construct(Guard $auth)
    {
        $this->middleware('role:MAS_SURGEON,write', ['only' => ['store', 'update', 'edit', 'create', 'destory']]);
        $this->middleware('role:MAS_SURGEON,read', ['only' => ['index']]);
        $this->auth = $auth;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $limit = 50;
        if (!empty($request->input('limit'))) {
            $request->session()->put('limit', $request->input('limit'));
            $limit = $request->session()->get('limit');
        } elseif ($request->session()->has('limit')) {
            $limit = $request->session()->get('limit');
        }
        $pagination['limit']=$limit;

        $order['sortby']    = 'id';
        $order['sortorder'] = 'desc';       
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {
          $order['sortby']     = \SiteHelpers::decrypt_id($request->input('sortby'));
          $order['sortorder']  = $request->input('sortorder');
        }    
         $search = array();
         $search['search_txt']='';
        if (!empty($request->input('search_txt')))
            $search['search_txt'] = $request->input('search_txt');

        $results=Surgeon::ListData($order, $limit, $search);

        return view('masters.Surgeon.list', compact('results', 'pagination', 'order', 'search'));

      
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $data_view['baby']=array();
       return view('masters.Surgeon.create', $data_view);
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
         $length = sizeof($input['surgeon_name']);


        for ($i = 0; $i < $length; $i++) {
            if ($input['surgeon_name'][$i] != '') {
                //$post                      = new Indication();
                $post['surgeon_name']     = $input['surgeon_name'][$i];
                $post['status']   = $input['status'][$i];
                $post['DateModified']        = Carbon::now();
                $post['DateAdded']           = Carbon::now();
                $post['UserAdded']           = \Auth::user()->id;
                Surgeon::create($post);
            }
        }

     return redirect(action('Masters\SurgeonController@index'))->with('Success', 'Record saved successfully');
       
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

      $view_data['results']=Surgeon::findOrfail($id);  


     
       return view('masters.Surgeon.edit', $view_data);

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
        $results = Surgeon::findOrfail($id);

        $input = $request->all();


        $input['DateModified'] = Carbon::now();

        $results->update($input);

        return redirect(action('Masters\SurgeonController@index'))->with('Success', 'Record updated successfully ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $results = Surgeon::findOrfail($id);

        $user_detail = array(
            'UserDeleted' => \Auth::user()->id,
            'DateModified' => Carbon::now(),
            'IsDeleted' => '1'
        );
        $results->update($user_detail);

        $delete_data = array(
            'Name' => $results['surgeon_name'],
            'ModuleController' => 'Masters\SurgeonController',
            'ModuleId' => $id,
            'ModuleName' => 'Surgeon Master',
            'UserDeleted' => \Auth::user()->id,
            'DateDeleted' => Carbon::now()
        );

        DeleteApproval::create($delete_data);
        return redirect(action('Masters\SurgeonController@index'))->with('info', 'Record deleted successfully ');
        
    }
}
