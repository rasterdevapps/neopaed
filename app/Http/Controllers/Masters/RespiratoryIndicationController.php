<?php
namespace App\Http\Controllers\Masters;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Masters\RespiratoryIndication;
use App\Models\Settings\DeleteApproval;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class RespiratoryIndicationController extends Controller
{
     public function __construct(Guard $auth)
    {
        $this->middleware('role:MAS_RESPIRATORYINDICATION,write', ['only' => ['store', 'update', 'edit', 'create', 'destory']]);
        $this->middleware('role:MAS_RESPIRATORYINDICATION,read', ['only' => ['index']]);
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

        //get the respiratory indication record list form respiratory indication masters
        $result     = RespiratoryIndication::list($request->input('page'), $limit, $search_txt, $order, 1);
        $results    = $result['result'];

        $getTotal   = count(RespiratoryIndication::ListData()); 
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

        return view('masters.Respiratoryindication.list', compact('results', 'pagination', 'search_txt', 'order', 'getTotal'));
              
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $data_view['baby']=array();
       return view('masters.Respiratoryindication.create', $data_view);
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

        if (!isset($input['respiratory_name']) || empty($input['respiratory_name'])) {
            return redirect()->back()->with('error', 'Error occurred');
        }

        foreach ($input['respiratory_name'] as $key => $value) {
            //$post                      = new Indication();
            $post['respiratory_name']    = $input['respiratory_name'][$key];
            $post['respiratory_status']  = $input['respiratory_status'][$key];
            $post['DateAdded']           = Carbon::now();
            $post['UserAdded']           = \Auth::user()->id;
            RespiratoryIndication::create($post);
        }

     return redirect(action('Masters\RespiratoryIndicationController@index'))->with('Success', 'Record added successfully');
       
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
        $view_data['results']=RespiratoryIndication::findOrfail($id);     
        return view('masters.Respiratoryindication.edit', $view_data);

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
        $results = RespiratoryIndication::findOrfail($id);

        $input = $request->all();

        $input['DateModified'] = Carbon::now();
        $input['UserModified'] = \Auth::user()->id;

        $results->update($input);

        return redirect(action('Masters\RespiratoryIndicationController@index'))->with('Success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $results = RespiratoryIndication::findOrfail($id);

        $user_detail = array(
            'UserDeleted' => \Auth::user()->id,
            'DateModified' => Carbon::now(),
            'IsDeleted' => '1'
        );
        $results->update($user_detail);

        $delete_data = array(
            'Name' => $results['respiratory_name'],
            'ModuleController' => 'Masters\RespiratoryIndicationController',
            'ModuleId' => $id,
            'ModuleName' => 'Respiratory Indication Master',
            'UserDeleted' => \Auth::user()->id,
            'DateDeleted' => Carbon::now()
        );

        DeleteApproval::create($delete_data);
        return redirect(action('Masters\RespiratoryIndicationController@index'))->with('info', 'Record deleted successfully ');
        
    }
}
