<?php namespace App\Http\Controllers\Settings;

use Illuminate\Html\HtmlFacade  as HTML;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Settings\Usergroups;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class UsergroupController extends Controller 
{
	public function __construct(Guard $auth)
	{
		$this->middleware('auth');
		$this->auth = $auth;
	}

	public function index(Request $request)
	{
		// $results = Usergroups::get_list($current_id);
		// return view('settings.usergroups.list', compact('results'));

        //Initialize the record  limit  with 50
        $limit = 50;

        //set the limit as per the request
        if (!empty($request->input('limit'))) {

            $request->session()->put('limit', $request->input('limit'));
            $limit =  $request->session()->get('limit');

        } elseif ($request->session()->has('limit')) {

            $limit =  $request->session()->get('limit');

        }

        //Initialize the record sorting key and order  
        $order['sortby']    = 'RoleId';
        $order['sortorder'] = 'desc';   

        //set the records sorting key and order  
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {

              $order['sortby']     = \SiteHelpers::decrypt_id($request->input('sortby'));
              $order['sortorder']  = $request->input('sortorder');

        }

        //initialize search parameter array 
        $search = array();
        $search['search_txt']='';
        if (!empty($request->input('search_txt'))) {

           $search['search_txt'] = $request->input('search_txt');

        }

	    //get the mother record list form mother module
		$current_id = $this->auth->user()->RoleId;
		
	    $result 	= Usergroups::get_list($current_id, $request->input('page'), $limit, $search, $order, 1);

	    $limitstart = (empty($request->input('page')) || $request->input('page') == 1) ? 0 : (($request->input('page')-1)*$limit);

	    $total   	= $result->get()->count();

	    $results 	= $result->limit($limit)->offset($limitstart)->get();

	    $getTotal   = Usergroups::GetTotal($current_id);	

	    $page                	= !empty($request->input('page')) ? $request->input('page') : 1;
        $pagecount           	= ceil($total/$limit);
        $pagination['total'] 	= $total;
        $pagination['start'] 	= (($page-2) < 1) ? 1 : ($page-2);
        $pagination['end']   	= ($pagecount < ($page+3)) ? $pagecount :   ($page+3);
        $pagestart              = $total != 0 ? ($page <= 1) ? $page : ($page-1)*$limit + 1 : 0;
        $pagerecords            = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page*$limit;
        $pagination['limit']    = array($pagestart, $pagerecords);
        $pagination['limits']   = $limit;
        $pagination['previous'] = (($page-1) < 1) ? 1 : ($page-1);
        $pagination['next']     = ($pagecount < ($page+1)) ? $pagecount :   ($page+1);
        		
		return view('settings.usergroups.list', compact('results', 'pagination', 'search', 'order', 'getTotal'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('settings.usergroups.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$input = $request->all();
		$array['write_permission'] = isset($input['write_permission'])?$input['write_permission']:array();
		$array['read_permission'] =  isset($input['read_permission'])?$input['read_permission']:array();		
		$array['delete_permission'] =  isset($input['delete_permission'])?$input['delete_permission']:array();		
		$permissions = serialize($array);
		$post['RoleName'] = $input['RoleName'];
		$post['Permissions'] = $permissions;
		$post['Status'] = $input['Status'];
		$post['DateAdded'] = Carbon::now();
		$post['UserAdded'] = $this->auth->user()->id;
		Usergroups::create($post);
		return redirect(action('Settings\UsergroupController@index'))->with('Success', 'Record added successfully');
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$groups = Usergroups::find($id);
		$groups->delete();
		return redirect()->back()->with('info', 'Record deleted successfully');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 
	 * @return edit forms
	 */
	public function edit($id)
	{
		$id = \SiteHelpers::decrypt_id($id);
		$results = Usergroups::get_record($id);
		$result = (array)$results[0];
		$permission = unserialize($result['Permissions']);
		$read_permission = $permission['read_permission'];
		$write_permission = $permission['write_permission'];	
		$delete_permission = isset($permission['delete_permission']) ? $permission['delete_permission'] : [];	
		return view('settings.usergroups.edit', compact('result', 'write_permission', 'read_permission', 'delete_permission'));
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @redirect listing page
	 */
	public function update($id, Request $request)
	{
		$results = Usergroups::findOrfail($id);
		$input = $request->all();
		$array['write_permission'] = isset($input['write_permission'])?$input['write_permission']:array();
		$array['read_permission'] =  isset($input['read_permission'])?$input['read_permission']:array();		
		$array['delete_permission'] =  isset($input['delete_permission'])?$input['delete_permission']:array();		
		$permissions = serialize($array);
		
		$post['RoleName'] = $input['RoleName'];
		$post['Permissions'] = $permissions;
		$post['Status'] = $input['Status'];
		$post['DateModified'] = Carbon::now();
		$post['UserModified'] = $this->auth->user()->id;
				
		$results->update($post);
		
		return redirect(action('Settings\UsergroupController@index'))->with('Success', 'Record updated successfully');
	}
	public function destroy($id)
	{

	}
}
