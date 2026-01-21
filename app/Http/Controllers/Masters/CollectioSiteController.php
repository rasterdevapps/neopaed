<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Carbon\Carbon;
use App\Models\Masters\CollectionSites;
use App\Models\Settings\DeleteApproval;

class CollectioSiteController extends Controller
{
    /**
     * controller constructor
     */
    public function __construct(Guard $auth)
    {
        $this->middleware('role:MAS_COLLECTION_SITE,write', ['only'=>['store','update','edit','create','destroy']]);
        $this->middleware('role:MAS_COLLECTION_SITE,read', ['only'=>['index']]);   
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

        //get the collection site list form collection site module
        $result     = CollectionSites::list($request->input('page'), $limit, $search_txt, $order, 1);
        $results    = $result['result'];

        $getTotal   = CollectionSites::getCount(); 
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

        return view('masters.collectionsite.list', compact('results', 'pagination', 'search_txt', 'order', 'getTotal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masters.collectionsite.create');
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
        
        foreach ($input['Name'] as $key => $value) {
            $post['name']         = $input['Name'][$key];
            $post['status']       = ($input['Status'][$key] == 'Active') ? 1 : 0;                     
            $post['DateModified'] = Carbon::now();
            $post['DateAdded']    = Carbon::now();
            CollectionSites::create($post);
        }
        return redirect(action('Masters\CollectioSiteController@index'))->with('Success', 'Record added successfully');
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
        $results = CollectionSites::findOrfail($id);
        $SubmitButtonText = 'Update';
        ($results['status'] == 'true') ? $results['status'] = 'Active' : $results['status'] = 'Inactive'; 
        return view('masters.collectionsite.edit', compact('results', 'SubmitButtonText'));
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
        $results = CollectionSites::findOrfail($id);
        $input   = $request->all();
        $data['name']         =  $input['name']; 
        $data['status']       = ($input['status'] == 'Active') ? 1 : 0;                     
        $data['DateModified'] = Carbon::now();
        $results->update($data);
        
        return redirect(action('Masters\CollectioSiteController@index'))->with('Success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $results = CollectionSites::findOrfail($id);
        $user_detail = array(
            'UserDeleted'   => $this->auth->user()->id,
            'DateModified'  => Carbon::now(),
            'IsDeleted'     => '1'
        );
        $results->update($user_detail);
        $delete_data = array(
            'Name'             => $results['Name'],
            'ModuleController' => 'Masters\CollectioSiteController',
            'ModuleId'         => $id,
            'ModuleName'       => 'Collection Site Master',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now()
        );
        DeleteApproval::create($delete_data); 
       return redirect(action('Masters\CollectioSiteController@index'))->with('info', 'Record deleted successfully !');
   
    }

    /**
     * add resource to master
     *
     */
    public function getUpdateCollectionSite(Request $request)
    {
        $input = $request->all();
        $length = sizeof($input['Name']);

        for ($i=0; $i<$length; $i++) {
            if ($input['Name'][$i] !='') {
                $post['name'] = $input['Name'][$i];
                $post['status'] = ($input['Status'][$i] == 'Active') ? 1 : 0;                     
                $post['DateModified'] = Carbon::now();
                $post['DateAdded'] = Carbon::now();
                $id = CollectionSites::create($post)->id;
                $results = CollectionSites::find($id);

            }
        }
        return \Response::json(['messageType'=>'success','message'=>'Added Succcessfully', 'data'=>$results],200);

    }
}
