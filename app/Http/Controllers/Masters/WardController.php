<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Models\Masters\Block;
use App\Models\Masters\WardGroup;
use App\Models\Masters\Ward;
use Carbon\Carbon;


class WardController extends Controller
{

    /**
     *Class constructor 
     *
     */
    public function  __construct(Guard $auth, ErrorLogController $custom_error)
    {
        $this->middleware('role:WARD_MANAGEMENT,write', ['only' => ['store', 'update', 'edit', 'create', 'destory']]);
        $this->middleware('role:WARD_MANAGEMENT,read', ['only' => ['index', 'show']]);
        $this->auth = $auth; 
        $this->custom_error = $custom_error;

   
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

        //get the ward record list form ward masters
        $result     = Block::listData($request->input('page'), $limit, $search_txt, $order, 1);
        $block_list = $result['result'];

        $getTotal   = count(Block::getwardgrouplist()); 
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
           
        return view('masters.ward.list', compact('block_list', 'pagination', 'search_txt', 'order', 'getTotal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masters.ward.create');
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

            \DB::beginTransaction();

         try {

                $block['name']         = $input['block'];
                $block['active']       = true;
                $block['createdDate']  = Carbon::now();
                $block['createdBy']    = $this->auth->user()->id;
                $block['modifiedDate'] = Carbon::now();
                $block['modifiedBy']   = $this->auth->user()->id;
                $block_id = Block::create($block)->id;

                foreach ($input['wardgroup'] as $key => $value) {
                   $ward_group['name']         = $value;
                   $ward_group['createdDate']  = Carbon::now();
                   $ward_group['createdBy']    = $this->auth->user()->id;
                   $ward_group['modifiedDate'] = Carbon::now();
                   $ward_group['modifiedBy']   = $this->auth->user()->id;
                   $ward_group['blcok_id']     = $block_id;
                   $ward_group_id = WardGroup::create($ward_group)->id;
                   
                   $ward_group_name = 'ward'.$key;

                   foreach ($input[$ward_group_name] as $key1 => $value1) {

                        $ward['name']          =  $value1;
                        $ward['createdDate']   = Carbon::now();
                        $ward['createdBy']     = $this->auth->user()->id;
                        $ward['modifiedDate']  = Carbon::now();
                        $ward['modifiedBy']    = $this->auth->user()->id;
                        $ward['blcok_id']      = $block_id;
                        $ward['ward_group_id'] = $ward_group_id;
                        Ward::create($ward);

                    } 
                  
                }
                
         } catch (Exception $e) {
                 
            \DB::rollback();
         } 

            \DB::commit();

        return redirect(action('Masters\WardController@index'))->with('Success','Records saved !');


        
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
        
        $block_details = array();
        $block         = Block::find($id);
        $ward_group    = $block->getwardgroup->sortBy('id')->pluck('id');

        $ward_group_details = array();

        foreach ($ward_group as $ward_group_key => $ward_group_value) {
            $ward_group_details[] = WardGroup::find($ward_group_value);
           
        }



        return view('masters.ward.edit', compact('block', 'ward_group', 'ward_group_details', 'id'));

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

        try {

             $block_details       =   Block::find($id);
             $block_details->name =   $input['block'];
             $block_details->save();

             WardGroup::where('blcok_id', $id)
                       ->whereNotIn('id', array_keys($input['wardgroup']))
                       ->delete();
            
            for ($i = $input['len']; $i < $input['data_len']; $i++) { 

                if (isset($input['wardgroup'][$i])) {
                    $ward_group = WardGroup::find($i);
                    if (count($ward_group) > 0) {

                        $ward_group->name          = $input['wardgroup'][$i];
                        $ward_group->modifiedDate  = Carbon::now();
                        $ward_group->modifiedBy    = $this->auth->user()->id;
                        $ward_group->blcok_id      = $id;
                        $ward_group_id             = $i;
                        $ward_group->save();

                    } else {
                        
                        $ward_group['name']         = $input['wardgroup'][$i];
                        $ward_group['createdDate']  = Carbon::now();
                        $ward_group['createdBy']    = $this->auth->user()->id;
                        $ward_group['modifiedDate'] = Carbon::now();
                        $ward_group['modifiedBy']   = $this->auth->user()->id;
                        $ward_group['blcok_id']     = $id;
                        $ward_group_id = WardGroup::create($ward_group)->id;

                    }
                }

                $ward_group_name = 'ward'.$i;

                if (isset($input[$ward_group_name])) {

                    foreach ($input[$ward_group_name] as $key1 => $value1) {
                            
                        if (count(explode('-', $key1)) > 1) {
                                
                            $ids = explode('-', $key1);
                            
                            $ward['name']          = $value1;
                            $ward['createdDate']   = Carbon::now();
                            $ward['createdBy']     = $this->auth->user()->id;
                            $ward['modifiedDate']  = Carbon::now();
                            $ward['modifiedBy']    = $this->auth->user()->id;
                            $ward['ward_group_id'] = $ward_group_id;
                            $ward['active']        = (isset($input['status'.$i][$key1]) && $input['status'.$i][$key1] == '1') ? true : false;

                            Ward::where('ward_group_id',$ids[0])
                                ->where('id',$ids[1])
                                ->update($ward);

                        } else {

                            $ward['name']          =  $value1;
                            $ward['createdDate']   = Carbon::now();
                            $ward['createdBy']     = $this->auth->user()->id;
                            $ward['modifiedDate']  = Carbon::now();
                            $ward['modifiedBy']    = $this->auth->user()->id;
                            $ward['ward_group_id'] = $ward_group_id;
                            $ward['active']        = (isset($input['status'.$i][$key1]) && $input['status'.$i][$key1] == '1') ? true : false;
                            
                            Ward::create($ward);

                        }  

                    } 

                }
            }

        } catch (Exception $e) {
                 
            \DB::rollback();
        } 

            \DB::commit();   

        return redirect(action('Masters\WardController@index'))->with('Success','Block & Ward updated successfully !');

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
