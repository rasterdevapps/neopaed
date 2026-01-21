<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Masters\BayleyScaleMaster;
use App\Models\Masters\BayleyScaleSubMaster;
use Carbon\Carbon;
use App\Models\Settings\DeleteApproval;

class BayleyScaleController extends Controller
{
    /**
     * constructor method
     *
     */
    protected $auth;
    protected $category;
    protected $time_zone;
    public function __construct(Guard $auth)
    {
        $this->middleware('role:MAS_BAYLEY_SCALE,write', ['only'=>['store','update','edit','create','destory']]);
        $this->middleware('role:MAS_BAYLEY_SCALE,read', ['only'=>['index']]);  
        $this->auth = $auth;
        $this->category = [1=>'Cognitive (CG)', 2=>'Receptive Communication (RC)', 3=>'Expressive Communication (EC)', 4=>'Fine Motor (FM)', 5=>'Gross Motor (GM)', 6=>'Social Emotional (SE)', 7=>'Adaptive Behavior (AB) - Receptive', 8=>'Adaptive Behavior (AB) - Expressive', 9=>'Adaptive Behavior (AB) - Personal', 10=>'Adaptive Behavior (AB) - Interpersonal Relationships', 11=>'Adaptive Behavior (AB) - Play and Leisure'];
        $this->type = [1=>'Question',2=>'Textarea',3=>'Checkbox',4=>'Text'];
        $this->time_zone = env('TIME_ZONE');
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
        $order['sortorder'] = 'asc';   

        //set the records sorting key and order  
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {

            $order['sortby']    = \SiteHelpers::decrypt_id($request->input('sortby'));
            $order['sortorder'] = $request->input('sortorder');

        }

        //initialize search parameter 
        $search_txt = !empty($request->input('search_txt')) ? $request->input('search_txt') : '';

        //get the frequency record list form frequency masters
        $result     = BayleyScaleMaster::list($request->input('page'), $limit, $search_txt, $order, 1);
        $results    = $result['result'];

        $getTotal   = BayleyScaleMaster::GetTotal();  
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

        $category = $this->category;

        return view('masters.bayley.list', compact('results', 'pagination', 'search_txt', 'order', 'getTotal', 'category'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = $this->category;
        $type = $this->type;
        return view('masters.bayley.create', compact('category', 'type'));
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

        $post['start_point'] = $input['start_point'];
        $post['question_no'] = $input['question_no'];
        $post['category'] = $input['category'];
        $post['item'] = $input['item'];
        $post['materials'] = $input['materials'];
        $post['user_added'] = $this->auth->user()['id'];
        $post['date_added'] = Carbon::now($this->time_zone);
        $bayley_hdr_id = BayleyScaleMaster::create($post)->id;

        if (is_array($input['title'])) {
            foreach ($input['title'] as $key => $value) {
                $post_sub['title'] = $value;
                $post_sub['score'] = $input['score'][$key];
                $post_sub['type'] = $input['type'][$key];
                $post_sub['bayley_id'] = $bayley_hdr_id;
                BayleyScaleSubMaster::create($post_sub);
            }
        }

        return redirect(action('Masters\BayleyScaleController@index'))->with('Success','Records saved !');
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
        $bayley = BayleyScaleMaster::find($id);
        $sub_list = BayleyScaleSubMaster::getList($id);
        $category = $this->category;
        $type = $this->type;

        return view('masters.bayley.edit', compact('bayley', 'sub_list', 'category', 'type'));
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
        $input = $request->all();

        $post['start_point'] = $input['start_point'];
        $post['question_no'] = $input['question_no'];
        $post['category'] = $input['category'];
        $post['item'] = $input['item'];
        $post['materials'] = $input['materials'];
        $post['user_modified'] = $this->auth->user()['id'];
        $post['date_modified'] = Carbon::now($this->time_zone);
        $bayley = BayleyScaleMaster::find($id);
        $bayley->update($post);

        if (is_array($input['title'])) {
            foreach ($input['title'] as $key => $value) {
                $post_sub['title'] = $value;
                $post_sub['score'] = $input['score'][$key];
                $post_sub['type'] = $input['type'][$key];
                $post_sub['bayley_id'] = $id;
                if (isset($input['sub_id'][$key])) {         
                    $bayley_sub = BayleyScaleSubMaster::find($input['sub_id'][$key]);
                    $bayley_sub->update($post_sub);
                } else {
                    BayleyScaleSubMaster::create($post_sub);
                }
            }
        }

       return redirect(action('Masters\BayleyScaleController@index'))->with('Success','Records updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $results = BayleyScaleMaster::findOrfail($id);

        $user_detail = array(
            'user_deleted'   => $this->auth->user()->id,
            'is_deleted'     => '1'
        );
        $results->update($user_detail);

        $delete_data = array(
            'Name'             => $results['item'],
            'ModuleController' => 'Masters\BayleyScaleController',
            'ModuleId'         => $id,
            'ModuleName'       => 'Bayley Scale Master',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now()
        );
        DeleteApproval::create($delete_data);
        return redirect(action('Masters\BayleyScaleController@index'))->with('info', 'Record deleted successfully !');
    }
}
