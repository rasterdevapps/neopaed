<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Machine\MachineData;

class InterfaceMachineController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();

        $limit = 10;

        if (!empty($input['limit'])) {
            $request->session()->put('limit', $input['limit']);
            $limit = $request->session()->get('limit');
        } elseif ($request->session()->has('limit')) {
            $limit = $request->session()->get('limit');
        }

        $navigate['main_nav'] = 'interface_log';
        $navigate['sub_nav']  = 'interface_machine';    
 
        $order['sortby'] = 'interface_machine.received_date';
        $order['sortorder'] = 'desc';

        if (!empty($input['sortby']) && !empty($input['sortorder'])) {
            $order['sortby'] = \SiteHelpers::decrypt_id($input['sortby']);
            $order['sortorder'] = $input['sortorder'];
        }

        $search_txt = '';

        if (!empty($request->input('search_txt'))) {
            $search_txt = $request->input('search_txt');
        }

        $input['page'] = 1;
        
        $lists = MachineData::get_list($input['page'], $limit, $search_txt, $order);

        $pagination['limits'] = $limit;        

        return view('interface_machine.list', compact('navigate','pagination','lists','search_txt')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $machinedata = MachineData::find($id);

        return view('interface_machine.show', compact('machinedata')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
