<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use App\Models\DeviceStatusNotification;

class DSNotificationController extends Controller
{
    /**
     * Time zone type 
     *  
     * @var $time_zone
     */
    protected $time_zone;

    /**
     * Authandication Details
     *
     * @var $auth
     */
    protected $auth;

    function __construct(Guard $auth)
    {
        $this->time_zone     = env('TIME_ZONE');
        $this->auth          = $auth;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getDsnStatusData(Request $request)
    {
        
        $input = $request->all();

        foreach ($input['details'] as $key => $value) {

            if ($value['notification_status'] == 'open') {

                $value['notification_start_time'] = isset($value['notification_start_time']) ? $value['notification_start_time'] : Carbon::now($this->time_zone);

                $open_count = \DB::table('dsn_status')
                                ->where(['baby_mrn'=> $value['mrn'], 'device_type'=> $value['device'], 'notification_start_tstamp'=> $value['notification_start_time']])
                                ->count();

                if ($open_count > 0) {
                    // return "Already Opened!";
                } else {
                    $insert_data['baby_mrn']                  = $value['mrn'];
                    $insert_data['device_type']               = $value['device'];
                    $insert_data['notification_start_tstamp'] = $value['notification_start_time'];
                    $insert_data['status']                    = $value['notification_status'] == 'open' ? 1 : 0;
                    $insert_data['create_tstamp']             = Carbon::now($this->time_zone);
                    $insert_data['create_user_id']            = 0;

                    \DB::table('dsn_status')->insert($insert_data);

                    // return "Successfully Opened!";
                }

            } else if ($value['notification_status'] == 'close') {
                
                $closed_id = \DB::table('dsn_status')
                                ->where(['baby_mrn'=> $value['mrn'], 'device_type'=> $value['device'], 'status'=> true])
                                ->get()
                                ->pluck('id')
                                ->toArray();

                if (count($closed_id) > 0) {
                    $update_data['status']                       = $value['notification_status'] == 'open' ? 1 : 0;
                    $update_data['notification_end_tstamp']      = isset($value['notification_end_time']) ? $value['notification_end_time'] : Carbon::now($this->time_zone);
                    $update_data['notification_stopped_reason']  = isset($value['reason']) ? $value['reason'] : 'Disconnected';
                    $update_data['notification_stopped_user_id'] = 0;
                    $update_data['modify_tstamp']                = Carbon::now($this->time_zone);
                    $update_data['modify_user_id']               = 0;

                    \DB::table('dsn_status')->whereIn('id', $closed_id)->update($update_data);
                    
                    // return "Successfully Closed!";
                } else {
                    // return "Already Closed!";
                } 

            }
        }
        return "Successfully!";
    }

    public function getDeviceNotification(Request $request) {

        $input = $request->all();
        $result_arr = array();
        foreach ($input['details'] as $key => $value) {
            $mrn = $result_arr[$key]['mrn']    =  $value['mrn'];
            $device =  $result_arr[$key]['device'] = $value['device'];
            $result_arr[$key]['bed'] = $value['bed_id'];
            $notification_start_time = $value['notification_start_time'];
            if ($notification_start_time != '') {
                $result = \DB::table('dsn_status')
                                ->where(['baby_mrn'=> $mrn, 'device_type'=> $device, 'notification_start_tstamp' => $notification_start_time, 'status'=> false])
                                ->count();

                $result_arr[$key]['status'] = $result > 0 ? 'close' : 'open';
            }
            else
            {
                $result_arr[$key]['status'] = 'open';

            }
        }

        return \Response::json(['result' => $result_arr], 200);

    }

    public function getDsnCurrentStatus(Request $request) {

        if ($request->ajax()) {
            $result = \DB::table('dsn_status')
                        ->select('dsn_status.*', 'baby.*', 'baby_admission.*', 'patient_bed_log.*', 'dsn_status.id as dsn_status_id')
                        ->join('baby', 'baby.BMrNo', 'dsn_status.baby_mrn')
                        ->join('baby_admission', 'baby.BabyId', 'baby_admission.BabyId')
                        ->join('patient_bed_log', 'patient_bed_log.baby_id', 'baby.BabyId')
                        ->where('dsn_status.status', true)
                        ->where('patient_bed_log.status', 'Occupied')
                        ->orderBy('bed_no')
                        ->get()
                        ->unique('baby_mrn')
                        ->toArray();

            return \Response::json(['result' => $result], 200);
        } else {
            return redirect('/');
        }

    }

    public function disconnectStatusUpdate(Request $request) {

        $input       = $request->all();

        $mrn         = $input['mrn'];
        $device_name = $input['device_name'];

        $update_data['status']                       = false;
        $update_data['notification_end_tstamp']      = Carbon::now($this->time_zone);;
        $update_data['notification_stopped_reason']  = 'Manual Disconnect';
        $update_data['notification_stopped_user_id'] = $this->auth->user() ['id'];
        $update_data['modify_tstamp']                = Carbon::now($this->time_zone);
        $update_data['modify_user_id']               = $this->auth->user() ['id'];


        \DB::table('dsn_status')->where(['baby_mrn'=> $mrn, 'device_type'=> $device_name, 'status'=> true])->update($update_data);

        return \Response::json(['messageType' => 'success', 'message' => 'Updated successfully!'], 200);

    }

    public function getConnectedDevice(Request $request) {

        $input = $request->all();

        $mrn   = $input['mrn'];

        if ($request->ajax()) {
            $result = \DB::table('dsn_status')
                        ->where('dsn_status.baby_mrn', $mrn)
                        ->where('status', true)
                        ->orderBy('notification_start_tstamp')
                        ->get()
                        ->unique('device_type')
                        ->pluck('device_type')
                        ->toArray();
            return \Response::json(['result' => $result], 200);
        } else {
            return redirect('/');
        }

    }

}
