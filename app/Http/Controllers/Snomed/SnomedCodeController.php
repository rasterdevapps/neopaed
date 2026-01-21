<?php

namespace App\Http\Controllers\Snomed;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Snomed\SnomedMapLocal;
use Illuminate\Contracts\Auth\Guard;
use Carbon\Carbon;
use App\Models\Settings\DeleteApproval;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Schema;

class SnomedCodeController extends Controller
{
    function __construct(Guard $auth)
    {
        $this->middleware('role:SNOMED_CODE,write', ['only'=>['store','update','edit','create','destory']]);
        $this->middleware('role:SNOMED_CODE,read', ['only'=>['index','show']]);
        $this->auth = $auth;
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

        $navigate['main_nav'] = 'snomed_map_local_column';
        $navigate['sub_nav']  = 'snomed_map_local_column';    
        $order['sortby']      = 'snomed_map_local_column.snomed_code';
        $order['sortorder']   = 'desc';

        if (!empty($input['sortby']) && !empty($input['sortorder'])) {
            $order['sortby'] = \SiteHelpers::decrypt_id($input['sortby']);
            $order['sortorder'] = $input['sortorder'];
        }

        $search_txt = '';

        if (!empty($request->input('search_txt'))) {
            $search_txt = $request->input('search_txt');
        }

        $result                 = SnomedMapLocal::GetList($request->input('page'), $limit, $search_txt, $order);
        $lists                  = $result['result'];
        $getTotal               = SnomedMapLocal::GetTotal();
        $total                  = $result['total']; 

        $page                   = !empty($request->input('page')) ? $request->input('page') : 1;
        $pagecount              = (!empty($search_txt)) ? ceil($total/$limit) : ceil($total/$limit);
        $pagination['total']    = $total;
        $pagination['start']    = (($page-2) < 1) ? 1 : ($page-2);
        $pagination['end']      = ($pagecount < ($page+3)) ? $pagecount :   ($page+3);
        $pagestart              = $total != 0 ? ($page <= 1) ? $page : ($page-1)*$limit + 1 : 0;
        $pagerecords            = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page*$limit;
        $pagination['limit']    = array($pagestart, $pagerecords);
        $pagination['limits']   = $limit;
        $pagination['previous'] = (($page-1) < 1) ? 1 : ($page-1);
        $pagination['next']     = ($pagecount < ($page+1)) ? $pagecount :   ($page+1);
        

        return view('snomed.list', compact('navigate', 'pagination', 'search_txt', 'lists', 'order', 'getTotal'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('snomed.create');
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

        $columnfilter = \DB::table('snomed_map_local_column')
                            ->select('column_name')
                            ->where('column_name', $input['column_name'])
                            ->get();

        $tablefilter = Schema::hasColumn($input['table_name'], $input['column_name']);

        $validator = Validator::make($input, [
                'column_name' => 'unique:snomed_map_local_column'
        ]); 

        if ($validator->fails()) {
            throw new ValidationException($validator);
        } else {
            if($tablefilter){
                SnomedMapLocal::create($input);
            } else {
               return \Redirect::back()->withInput($request->input())->withErrors(['The column name does not exists in "'.$input['table_name'].'" table.']);
            }
        }
        return redirect(action('Snomed\SnomedCodeController@index'))->with('Success','Record saved successfully!');
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
        $results = SnomedMapLocal::findOrfail($id);
        return view('snomed.edit', compact('results'));
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
        $results = SnomedMapLocal::findOrfail($id);
        
        $input = $request->all();        

        $recordfilter = \DB::table('snomed_map_local_column')
                            ->select('column_name')
                            ->where('column_name', $input['column_name'])
                            ->get();

        $columnfilter = \DB::table('snomed_map_local_column')
                            ->select('column_name')
                            ->where('id', $id)
                            ->where('column_name', $input['column_name'])
                            ->get();

        $tablefilter = Schema::hasColumn($input['table_name'], $input['column_name']);


        if ((count($recordfilter) == 0 || count($columnfilter) != 0) && $tablefilter) {
            $results->update($input);
        } else {
            $validator = Validator::make($input, [
                'column_name' => 'unique:snomed_map_local_column'
            ]);                
            if ($validator->fails()) {
                throw new ValidationException($validator);
            } else {
                return \Redirect::back()->withInput($request->input())->withErrors(['The column name does not exists in "'.$input['table_name'].'" table.']);
            }
        }

        return redirect(action('Snomed\SnomedCodeController@index'))->with('Success','Record updated successfully!');;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $results = SnomedMapLocal::findOrfail($id);

        $user_detail = array(
            'UserDeleted'   => $this->auth->user()->id,
            'DateModified'  => Carbon::now(),
            'IsDeleted'     => '1'
        );
        $results->update($user_detail);

        $delete_data = array(
            'Name'             => $results['column_name'],
            'ModuleController' => 'Snomed\SnomedCodeController',
            'ModuleId'         => $id,
            'ModuleName'       => 'Snomed Map Local',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now()
        );
        DeleteApproval::create($delete_data);

        $results->delete();

        return redirect(action('Snomed\SnomedCodeController@index'))->with('info','Record deleted successfully!');
    }
}
