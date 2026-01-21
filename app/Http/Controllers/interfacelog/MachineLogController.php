<?php

namespace App\Http\Controllers\interfacelog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Machine\MachineDataFormter;
use App\Models\Settings\Settings;
use Carbon\Carbon;


class MachineLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Settings $site_settings)
    {
        $this->site_settings       = $site_settings;  
    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMachineStatus(Request $request)
    {

        $machine_data                         = json_decode(file_get_contents('php://input'));
           

         if (!$this->checkAuthentication($machine_data)) {
          \Response::json(['messsage'=>'Invalid username or password ']);

         }

         $machine_details['mrn']               = isset($machine_data->mrn) ? $machine_data->mrn : null;
         $machine_details['visit_number']      = isset($machine_data->visit_number) ? $machine_data->visit_number : null;
         $machine_details['baby_name']         = isset($machine_data->baby_name) ? $machine_data->baby_name : null;
         $machine_details['hospital_name']     = isset($machine_data->hospital_name) ? $machine_data->hospital_name : null;
         $machine_details['date_time']         = ($machine_data->date_time == '') ? null: $machine_data->date_time;
         $machine_details['device_name']       = isset($machine_data->device_name) ? $machine_data->device_name : null;
         $machine_details['issued_date_time']  = ($machine_data->date_time == '') ? null: $machine_data->date_time;

         $machine_details['request_ip_number'] = $request->ip();
         MachineDataFormter::create($machine_details);


        return \Response::json(['messsage'=>'Data Added Successfully']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function checkAuthentication($input) 
    {
        //input apikey
        $input->apikey       = \SiteHelpers::decrypt_id($input->apikey);
        $input->user_name    = $input->user_name;
        $input->api_password = \SiteHelpers::decrypt_id($input->api_password);
        
        //input apikey
        $settings            = $this->site_settings->find(1);
        $api_key             = \SiteHelpers::decrypt_id($settings->api_key);
        $user_name           = $settings->api_user_name;
        $user_password       = \SiteHelpers::decrypt_id($settings->api_password);

        if (($input->apikey == $api_key) && ($input->user_name == $user_name) &&  ($input->api_password == $user_password)) {
             return true;
        } else {
             return false;
        }


    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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
