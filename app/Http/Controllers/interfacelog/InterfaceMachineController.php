<?php

namespace App\Http\Controllers\interfacelog;

use Illuminate\Http\Request;
use App\Models\Machine\MachineData;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;


class InterfaceMachineController extends Controller
{
    public function __construct(Guard $auth)
    {
        $this->middleware('role:INTERFACE_LOG,write', ['only' => ['store', 'update', 'edit', 'create', 'show', 'destroy']]);
        $this->middleware('role:INTERFACE_LOG,read', ['only' => ['index', 'printData']]);
        $this->middleware('auth');
        $this->auth = $auth;
        $this->navigate['main_nav']='interface_machine';
        $this->navigate['sub_nav'] ='interface_machine';
    }

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
        $navigate['sub_nav'] = 'interface_machine';    

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
        
        $results  = MachineData::get_list($request->input('page'), $limit, $search_txt, $order);
        $lists    = $results['result'];

        $getTotal = MachineData::getTotal();
        $total    = $results['total']; 

        $page                   = !empty($request->input('page')) ? $request->input('page') : 1;
        $pagecount              = (!empty($search['search_txt'])) ? ceil($total/$limit) : ceil($total/$limit);
        $pagination['total']    = $total;
        $pagination['start']    = (($page-2) < 1) ? 1 : ($page-2);
        $pagination['end']      = ($pagecount < ($page+3)) ? $pagecount :   ($page+3);
        $pagestart              = $total != 0 ? ($page <= 1) ? $page : ($page-1)*$limit + 1 : 0;
        $pagerecords            = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page*$limit;
        $pagination['limit']    = array($pagestart, $pagerecords);
        $pagination['limits']   = $limit;
        $pagination['previous'] = (($page-1) < 1) ? 1 : ($page-1);
        $pagination['next']     = ($pagecount < ($page+1)) ? $pagecount :   ($page+1);

        return view('interface_machine.list', compact('navigate','pagination','lists','search_txt', 'getTotal', 'order'));
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
        $machinedata = MachineData::get_record($id);


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
