<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use  App\Models\Masters\CollectionMethod;
use App\Models\Settings\DeleteApproval;

use Carbon\Carbon;


 /**
  * This Controller for 
  *@author Manikandan M
  *
  */
class CollectioMethodController extends Controller
{
    /**
     * controller constructor
     */
    public function __construct(Guard $auth)
    {
        $this->middleware('role:MAS_COLLECTION_METHOD,write', ['only'=>['store','update','edit','create','destroy']]);
        $this->middleware('role:MAS_COLLECTION_METHOD,read', ['only'=>['index']]);   
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

        //get the collection method list form collection method module
        $result     = CollectionMethod::list($request->input('page'), $limit, $search_txt, $order, 1);
        $results    = $result['result'];

        $getTotal   = CollectionMethod::getCount(); 
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

        return view('masters.collectionmethod.list', compact('results', 'pagination', 'search_txt', 'order', 'getTotal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('masters.collectionmethod.create');
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
            CollectionMethod::create($post);
        }
        return redirect(action('Masters\CollectioMethodController@index'))->with('Success', 'Record added successfully');
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
        $results = CollectionMethod::findOrfail($id);
        ($results['status'] == 'true') ? $results['status'] = 'Active' : $results['status'] = 'Inactive'; 
        $SubmitButtonText = 'Update';
        return view('masters.collectionmethod.edit', compact('results', 'SubmitButtonText'));
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
        $results = CollectionMethod::findOrfail($id);
        $input   = $request->all();
        $data['name']         =  $input['name']; 
        $data['status']       = ($input['status'] == 'Active') ? 1 : 0;                     
        $data['DateModified'] = Carbon::now();
        $results->update($data);
        
        return redirect(action('Masters\CollectioMethodController@index'))->with('Success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $results = CollectionMethod::findOrfail($id);
        $user_detail = array(
            'UserDeleted'   => $this->auth->user()->id,
            'DateModified'  => Carbon::now(),
            'IsDeleted'     => '1'
        );
        $results->update($user_detail);
        $delete_data = array(
            'Name'             => $results['Name'],
            'ModuleController' => 'Masters\CollectioMethodController',
            'ModuleId'         => $id,
            'ModuleName'       => 'Collection Method Master',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now()
        );
        DeleteApproval::create($delete_data);   
       return redirect(action('Masters\CollectioMethodController@index'))->with('info', 'Record deleted successfully !');
 
    }

    /**
     * This mehod to update add resource to master
     *
     */
     public function getUpdateCollectionMethod(Request $request)
     {
         $input = $request->all();
        $length = sizeof($input['Name']);
        for ($i=0; $i<$length; $i++) {
            if ($input['Name'][$i] !='') {
                $post['name'] = $input['Name'][$i];
                $post['status'] = ($input['Status'][$i] == 'Active') ? 1 : 0;                     
                $post['DateModified'] = Carbon::now();
                $post['DateAdded'] = Carbon::now();
                $id = CollectionMethod::create($post)->id;
                $results = CollectionMethod::find($id);

            }
        }
       return \Response::json(['messageType'=>'success','message'=>'Added Succcessfully', 'data'=>$results],200);

     }
}
