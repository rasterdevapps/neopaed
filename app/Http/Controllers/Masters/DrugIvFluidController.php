<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Masters\DrugIvFluidMaster;
use Carbon\Carbon;
use App\Models\Settings\DeleteApproval;
use App\Models\Masters\PrescriptionTypeMaster;

class DrugIvFluidController extends Controller
{
    /**
     * constructor method
     *
     */
    public function __construct(Guard $auth)
    {
        $this->middleware('role:MAS_DRUG_IVFLUID,write', ['only'=>['store','update','edit','create','destory']]);
        $this->middleware('role:MAS_DRUG_IVFLUID,read', ['only'=>['index']]);  
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
        $order['sortby']    = 'mas_drugivfluid.id';
        $order['sortorder'] = 'desc';   

        //set the records sorting key and order  
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {

            $order['sortby']    = \SiteHelpers::decrypt_id($request->input('sortby'));
            $order['sortorder'] = $request->input('sortorder');

        }

        //initialize search parameter 
        $search_txt = !empty($request->input('search_txt')) ? $request->input('search_txt') : '';

        //get the frequency record list form frequency masters
        $result     = DrugIvFluidMaster::list($request->input('page'), $limit, $search_txt, $order, 1);
        $results    = $result['result'];

        $getTotal   = DrugIvFluidMaster::GetTotal();  
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

        return view('masters.drug_iv_fluid.list', compact('results', 'pagination', 'search_txt', 'order', 'getTotal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prescription_type     = PrescriptionTypeMaster::getPrescriptionType();
        $role_id = $this->auth->user()->RoleId;
        return view('masters.drug_iv_fluid.create', compact('prescription_type', 'role_id'));
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
        if ($request->ajax()) {
            if (empty($input['brand_name']) || empty($input['generic_pharmacological_name']) || empty($input['value']) || empty($input['type'])) {
                return \Response::json(['messageType'=>'error','message'=>'Please fill the all the fields']);
            } else {    
                $post['brand_name']                   = $input['brand_name'];
                $post['generic_pharmacological_name'] = $input['generic_pharmacological_name'];
                $post['value']                        = $input['value'];
                $post['type']                         = $input['type'];
                $post['anti_status']                  = isset($input['anti_status']) && $input['anti_status'] == 'on' ? 1 : 0;
                $post['status']                       = $input['status'];
                $post['usage_type']                   = isset($input['usage_type']) ? $input['usage_type'] : 'OP';
                $post['date_added']                   = Carbon::now();
                $post['user_added']                   = $this->auth->user()->id;
                $id = DrugIvFluidMaster::create($post)->id; 
            }
        } else {
            if (!isset($input['brand_name']) || empty($input['brand_name'])) {
                return redirect()->back()->with('error', 'Error occurred');
            }            

            foreach ($input['brand_name'] as $key => $value) {
                $post['brand_name']                   = $input['brand_name'][$key];
                $post['generic_pharmacological_name'] = $input['generic_pharmacological_name'][$key];
                $post['value']                        = $input['value'][$key];
                $post['anti_status']                  = (isset($input['anti_status']) && isset($input['anti_status'][$key]) && $input['anti_status'][$key] == 'on') ? 1 : 0;
                $post['type']                         = $input['type'][$key];
                $post['status']                       = $input['status'][$key];
                $post['usage_type']                   = (isset($input['usage_type']) && isset($input['usage_type'][$key])) ? $input['usage_type'][$key] : 'OP';
                $post['date_added']                   = Carbon::now();
                $post['user_added']                   = $this->auth->user()->id;
                if ($input['type'][$key] == 'IVDI') {                    
                    $post['dose']           = (isset($input['dose']) && !empty($input['dose'])) ? $input['dose'] : 0;
                    $post['dose_range']     = (isset($input['dose_range']) && !empty($input['dose_range'])) ? $input['dose_range'] : 0;
                    $post['dose_units']     = (isset($input['dose_units']) && !empty($input['dose_units'])) ? $input['dose_units'] : 0;
                    $post['dose_duration']  = (isset($input['dose_duration']) && !empty($input['dose_duration'])) ? $input['dose_duration'] : 0;
                    $post['quantity']       = (isset($input['quantity']) && !empty($input['quantity'])) ? $input['quantity'] : 0;
                    $post['quantity_units'] = (isset($input['quantity_units']) && !empty($input['quantity_units'])) ? $input['quantity_units'] : 0;
                    $post['syringe_size']   = (isset($input['syringe_size']) && !empty($input['syringe_size'])) ? $input['syringe_size'] : 0;
                    $post['rate']           = (isset($input['rate']) && !empty($input['rate'])) ? $input['rate'] : 0;
                    $post['instruction']    = isset($input['instruction']) ? $input['instruction'] : '';
                    $post['added_drug']     = isset($input['added_drug']) ? $input['added_drug'] : '';
                    $post['added_dose']     = isset($input['added_dose']) ? $input['added_dose']  : '';
                } else if ($input['type'][$key] == 'OIVD') {                    
                    $post['dose']           = (isset($input['dose']) && !empty($input['dose'])) ? $input['dose'] : 0;
                    $post['dose_range']     = (isset($input['dose_range']) && !empty($input['dose_range'])) ? $input['dose_range'] : 0;
                    $post['dose_alt']       = (isset($input['dose_alt']) && !empty($input['dose_alt'])) ? $input['dose_alt'] : 0;
                    $post['dose_alt_range'] = (isset($input['dose_alt_range']) && !empty($input['dose_alt_range'])) ? $input['dose_alt_range'] : 0;
                    $post['frequency']      = isset($input['frequency']) ? $input['frequency'] : '';
                    $post['syringe_size']   = (isset($input['syringe_size']) && !empty($input['syringe_size'])) ? $input['syringe_size'] : 0;
                    $post['rate']           = (isset($input['rate']) && !empty($input['rate'])) ? $input['rate'] : 0;
                    $post['instruction']    = isset($input['instruction']) ? $input['instruction'] : '';
                }  else if ($input['type'][$key] == 'OIVI') {                    
                    $post['syringe_size']   = (isset($input['syringe_size']) && !empty($input['syringe_size'])) ? $input['syringe_size'] : 0;
                    $post['rate']           = (isset($input['rate']) && !empty($input['rate'])) ? $input['rate'] : 0;
                    $post['route']          = isset($input['route']) ? $input['route'] : '';
                    $post['instruction']    = isset($input['instruction']) ? $input['instruction'] : '';
                    $post['added_drug']     = isset($input['added_drug']) ? $input['added_drug'] : '';
                    $post['added_dose']     = isset($input['added_dose']) ? $input['added_dose'] : '';
                }   else if ($input['type'][$key] == 'ORAL') {                    
                    $post['dose']           = (isset($input['dose']) && !empty($input['dose'])) ? $input['dose'] : 0;
                    $post['dose_range']     = (isset($input['dose_range']) && !empty($input['dose_range'])) ? $input['dose_range'] : 0;
                    $post['dose_alt']       = (isset($input['dose_alt']) && !empty($input['dose_alt'])) ? $input['dose_alt'] : 0;
                    $post['dose_alt_range'] = (isset($input['dose_alt_range']) && !empty($input['dose_alt_range'])) ? $input['dose_alt_range'] : 0;
                    $post['frequency']      = isset($input['frequency']) ? $input['frequency']: '';
                    $post['route']          = isset($input['route']) ? $input['route'] : '';
                    $post['instruction']    = isset($input['instruction']) ? $input['instruction'] : '';
                } 
                $id = DrugIvFluidMaster::create($post)->id;
            }
        }

        $drugivfluid =  DrugIvFluidMaster::find($id);
        
        if ($request->ajax()) {
            return \Response::json(['messageType'=>'success','message'=>'Added succcessfully','data'=>$drugivfluid],200);
        } else {
            return redirect(action('Masters\DrugIvFluidController@index'))->with('Success', 'Record added successfully');
        }
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
        $results = DrugIvFluidMaster::findOrfail($id);
        $prescription_type     = PrescriptionTypeMaster::getPrescriptionType();
        $role_id = $this->auth->user()->RoleId;
        return view('masters.drug_iv_fluid.edit', compact('results', 'prescription_type', 'role_id'));
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
        $results = DrugIvFluidMaster::findOrfail($id);
        
        $input = $request->all();

        if ($input['type'] == 'IVDI') {                    
            $input['dose']           = (isset($input['dose']) && !empty($input['dose'])) ? $input['dose'] : 0;
            $input['dose_range']     = (isset($input['dose_range']) && !empty($input['dose_range'])) ? $input['dose_range'] : 0;
            $input['dose_units']     = (isset($input['dose_units']) && !empty($input['dose_units'])) ? $input['dose_units'] : 0;
            $input['dose_duration']  = (isset($input['dose_duration']) && !empty($input['dose_duration'])) ? $input['dose_duration'] : 0;
            $input['quantity']       = (isset($input['quantity']) && !empty($input['quantity'])) ? $input['quantity'] : 0;
            $input['quantity_units'] = (isset($input['quantity_units']) && !empty($input['quantity_units'])) ? $input['quantity_units'] : 0;
            $input['syringe_size']   = (isset($input['syringe_size']) && !empty($input['syringe_size'])) ? $input['syringe_size'] : 0;
            $input['rate']           = (isset($input['rate']) && !empty($input['rate'])) ? $input['rate'] : 0;
            $input['instruction']    = isset($input['instruction']) ? $input['instruction'] : '';
            $input['added_drug']     = isset($input['added_drug']) ? $input['added_drug'] : '';
            $input['added_dose']     = isset($input['added_dose']) ? $input['added_dose']  : '';
        } else if ($input['type'] == 'OIVD') {                    
            $input['dose']           = (isset($input['dose']) && !empty($input['dose'])) ? $input['dose'] : 0;
            $input['dose_range']     = (isset($input['dose_range']) && !empty($input['dose_range'])) ? $input['dose_range'] : 0;
            $input['dose_alt']       = (isset($input['dose_alt']) && !empty($input['dose_alt'])) ? $input['dose_alt'] : 0;
            $input['dose_alt_range'] = (isset($input['dose_alt_range']) && !empty($input['dose_alt_range'])) ? $input['dose_alt_range'] : 0;
            $input['frequency']      = isset($input['frequency']) ? $input['frequency'] : '';
            $input['syringe_size']   = (isset($input['syringe_size']) && !empty($input['syringe_size'])) ? $input['syringe_size'] : 0;
            $input['rate']           = (isset($input['rate']) && !empty($input['rate'])) ? $input['rate'] : 0;
            $input['instruction']    = isset($input['instruction']) ? $input['instruction'] : '';
        }  else if ($input['type'] == 'OIVI') {                    
            $input['syringe_size']   = (isset($input['syringe_size']) && !empty($input['syringe_size'])) ? $input['syringe_size'] : 0;
            $input['rate']           = (isset($input['rate']) && !empty($input['rate'])) ? $input['rate'] : 0;
            $input['route']          = isset($input['route']) ? $input['route'] : '';
            $input['instruction']    = isset($input['instruction']) ? $input['instruction'] : '';
            $input['added_drug']     = isset($input['added_drug']) ? $input['added_drug'] : '';
            $input['added_dose']     = isset($input['added_dose']) ? $input['added_dose'] : '';
        }   else if ($input['type'] == 'ORAL') {                    
            $input['dose']           = (isset($input['dose']) && !empty($input['dose'])) ? $input['dose'] : 0;
            $input['dose_range']     = (isset($input['dose_range']) && !empty($input['dose_range'])) ? $input['dose_range'] : 0;
            $input['dose_alt']       = (isset($input['dose_alt']) && !empty($input['dose_alt'])) ? $input['dose_alt'] : 0;
            $input['dose_alt_range'] = (isset($input['dose_alt_range']) && !empty($input['dose_alt_range'])) ? $input['dose_alt_range'] : 0;
            $input['frequency']      = isset($input['frequency']) ? $input['frequency']: '';
            $input['route']          = isset($input['route']) ? $input['route'] : '';
            $input['instruction']    = isset($input['instruction']) ? $input['instruction'] : '';
        } 

        $input['anti_status'] = isset($input['anti_status']) && $input['anti_status'] == 'on' ? 1 : 0;
        $input['usage_type'] = isset($input['usage_type']) ? $input['usage_type'] : 'OP';

        $input['date_modified'] = Carbon::now();
        $input['user_modified'] = $this->auth->user()->id;
        
        $results->update($input);
        
        return redirect(action('Masters\DrugIvFluidController@index'))->with('Success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $results = DrugIvFluidMaster::findOrfail($id);

        $user_detail = array(
            'user_deleted'  => $this->auth->user()->id,
            'date_modified' => Carbon::now(),
            'is_deleted'        => '1'
        );
        $results->update($user_detail);

        $delete_data = array(
            'Name'             => $results['brand_name'],
            'ModuleController' => 'Masters\DrugIvFluidController',
            'ModuleId'         => $id,
            'ModuleName'       => 'Frequency Master',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now()
        );
        DeleteApproval::create($delete_data);
        return redirect(action('Masters\DrugIvFluidController@index'))->with('info', 'Record deleted successfully !');
    }
}
