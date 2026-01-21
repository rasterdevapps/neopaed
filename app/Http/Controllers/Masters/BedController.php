<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Models\Masters\Ward;
use App\Models\Masters\Room;
use App\Models\Masters\Bed;
use Carbon\Carbon;


class BedController extends Controller
{

    /**
     *Class constructor 
     *
     */
    public function  __construct(Guard $auth, ErrorLogController $custom_error)
    {
        $this->middleware('role:MAS_BED,write', ['only' => ['store', 'update', 'edit', 'create', 'destory']]);
        $this->middleware('role:MAS_BED,read', ['only' => ['index', 'show']]);
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
        $order['sortby']    = 'bed.id';
        $order['sortorder'] = 'desc';   

        //set the records sorting key and order  
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {

            $order['sortby']    = \SiteHelpers::decrypt_id($request->input('sortby'));
            $order['sortorder'] = $request->input('sortorder');

        }

        //initialize search parameter 
        $search_txt = !empty($request->input('search_txt')) ? $request->input('search_txt') : '';

        //get the bed record list form bed masters
        $result     = Bed::listData($request->input('page'), $limit, $search_txt, $order, 1);
        $bed_list   = $result['result'];

        $getTotal   = count(Bed::getbedlist()); 
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

        return view('masters.bed.list', compact('bed_list', 'pagination', 'search_txt', 'order', 'getTotal'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ward  = Ward::ward_list()->pluck('name', 'id')->toArray();


        return view('masters.bed.create', compact('ward'));
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

         $room_number['number']       = $input['roomnumber']; 
         $room_number['ward_id']      = $input['ward']; 
         $room_number['createdDate']  = Carbon::now();
         $room_number['createdBy']    = $this->auth->user()->id;
         $room_number['modifiedDate'] = Carbon::now();
         $room_number['modifiedBy']   = $this->auth->user()->id;
         $room_id = Room::create($room_number)->id;

         foreach ($input['bednumber'] as $key => $value) {

             $bednumber['number']       = $value; 
             $bednumber['status']       = $input['status'][$key]; 
             $bednumber['pump_type']    = $input['pump_type'][$key]; 
             $bednumber['room_id']      = $room_id; 
             $bednumber['createdDate']  = Carbon::now();
             $bednumber['createdBy']    = $this->auth->user()->id;
             $bednumber['modifiedDate'] = Carbon::now();
             $bednumber['modifiedBy']   = $this->auth->user()->id;
             Bed::create($bednumber);

         }

        return redirect(action('Masters\BedController@index'))->with('Success','Records saved !');


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
        $room_details = Room::find($id);
        $bed_details  = $room_details->getbedlists->sortBy('number');  

        $ward         = Ward::ward_list()->pluck('name', 'id')->toArray();
      
        return view('masters.bed.edit', compact('room_details', 'bed_details', 'ward'));

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
        $input                      =  $request->all();
        $room_details               =  Room::find($id);
        $room_details->number       =  $input['roomnumber'];
        $room_details->modifiedDate = Carbon::now();
        $room_details->modifiedBy   = $this->auth->user()->id;
        $room_details->save();

            $delete_bed = array_filter($input['bednumber'], function($bed) {

                return is_int($bed) ?? $bed;

            }, ARRAY_FILTER_USE_KEY);


         $bed_delete = Bed::where('room_id', $id)
                           ->whereNotIn('id',array_keys($delete_bed))
                           ->delete();

         foreach ($input['bednumber'] as $key => $value) {

            $bed_old_numbers  = Bed::find($key);

            // if (count(explode('-', $key)) == 2) {
            if (!is_object($bed_old_numbers)) {

                 $bed_new_numbers['number']       = $value; 
                 $bed_new_numbers['status']       = $input['status'][$key]; 
                 $bed_new_numbers['pump_type']    = $input['pump_type'][$key]; 
                 $bed_new_numbers['room_id']      = $id; 
                 $bed_new_numbers['createdDate']  = Carbon::now();
                 $bed_new_numbers['createdBy']    = $this->auth->user()->id;
                 $bed_new_numbers['modifiedDate'] = Carbon::now();
                 $bed_new_numbers['modifiedBy']   = $this->auth->user()->id;
                 Bed::create($bed_new_numbers);

            } else {

                 $bed_old_numbers->number       = $value; 
                 $bed_old_numbers->status       = $input['status'][$key]; 
                 $bed_old_numbers->pump_type    = $input['pump_type'][$key]; 
                 $bed_old_numbers->room_id      = $id; 
                 $bed_old_numbers->save();
            }

         }

       return redirect(action('Masters\BedController@index'))->with('Success','Records updated !');

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
