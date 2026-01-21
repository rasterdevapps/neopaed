<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Masters\ShortcodeMaster;
use App\Models\Settings\DeleteApproval;
use Illuminate\Contracts\Auth\Guard;

class ShortcodeController extends Controller
{

    public function __construct(Guard $auth)
    {
        $this->middleware('role:MAS_SHORTCODE,write', ['only'=>['store','update','edit','create','destroy']]);
        $this->middleware('role:MAS_SHORTCODE,read', ['only'=>['index']]);   
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
        $result     = ShortcodeMaster::list($request->input('page'), $limit, $search_txt, $order, 1);
        $results    = $result['result'];

        $getTotal   = count(ShortcodeMaster::get_lists()); 
        $total      = $result['total']; 

        //echo "<pre>"; print_r($results); exit;

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

        return view('masters.Shortcode.list', compact('results', 'pagination', 'search_txt', 'order', 'getTotal'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masters.Shortcode.create');
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
        // echo "<pre>"; print_r($input); exit;

        if (!isset($input['short_code']) || empty($input['short_code'])) {
            return redirect()->back()->with('error', 'Error occurred');
        }
        
        $post['short_code'] = $input['short_code'];
        $post['description'] = $input['description'];
        $post['active'] = $input['active'];
        $post['created_date_time'] = Carbon::now();
        $post['created_user'] = $this->auth->user()->id;
        ShortcodeMaster::create($post);
        
        return redirect(action('Masters\ShortcodeController@index'))->with('Success', 'Record added successfully');
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
        $results = ShortcodeMaster::findOrfail($id);
       // $results->Name = isset($results->Name) ? str_replace('Dr', ' ', $results->Name) : '' ;
        return view('masters.Shortcode.edit', compact('results'));
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
        $results = ShortcodeMaster::findOrfail($id);
        //echo "<pre>"; print_r($results); exit;
        $input                 = $request->all();
       // $input['Name']         = $input['name_prefix'].' '. trim($input['Name']) ;        
        $input['modified_date_time'] = Carbon::now();
        $input['UserModified'] = $this->auth->user()->id;                    
        $results->update($input);

        return redirect(action('Masters\ShortcodeController@index'))->with('Success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $results = ShortcodeMaster::findOrfail($id);

        $user_detail = array(
            'UserDeleted'   => $this->auth->user()->id,
            'modified_date_time'  => Carbon::now(),
            'is_deleted'     => '1'
        );
        $results->update($user_detail);

        $delete_data = array(
            'short_code'             => $results['short_code'],
            'ModuleController' => 'Masters\ShortcodeController',
            'ModuleId'         => $id,
            'ModuleName'       => 'Shortcode Master',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now()
        );
        DeleteApproval::create($delete_data);
        return redirect(action('Masters\ShortcodeController@index'))->with('info', 'Record deleted successfully ');
    }
       
    public function fetchDescription(Request $request){ 


		$shortcode = $request->input('shortcode');

		$description = ShortcodeMaster::where('short_code', $shortcode)->value('description');

		if ($description) {
			return response()->json(['success' => true, 'description' => $description]);
		} else {
			return response()->json(['success' => false, 'message' => 'No matching shortcode found.']);
		}
	}

   
}
