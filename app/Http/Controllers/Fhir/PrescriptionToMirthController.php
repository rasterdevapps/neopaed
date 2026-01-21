<?php

namespace App\Http\Controllers\Fhir;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Nurse\SyringePumpAdmisson;
use App\Models\Ward\Ward;
use App\Models\Baby;
use App\Http\Controllers\Adtmessage\AdtMessagePropertyController;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Models\prescriptionHeader;
use App\Models\prescriptionDetails;
use App\Http\Controllers\prescription\PrescriptionController;
use Carbon\Carbon;

class PrescriptionToMirthController extends Controller
{

    public static function admission()
    {
        $message = '';

        $adt_property = new AdtMessagePropertyController;

            //new admission
        $admission_details = SyringePumpAdmisson::where('admission_stauts', 0)->orderby('id', 'desc')
        ->first();

        if ($admission_details != '' && count($admission_details) > 0)
        {

            $ip_details = SyringePumpAdmisson::getAdmissionSyirangePump($admission_details->baby_id, $admission_details->admission_id);
            $bed_details = Ward::getbabyadmission($admission_details->baby_id, $admission_details->admission_id, 'check-admission-id');
            $baby = Baby::find($admission_details->baby_id);
            $baby->DOB = str_replace('-', '', $baby->DOB);
            $baby->Sex = ($baby->Sex == 'Male') ? 'M' : 'F';
            $admission_details->weight = (isset($admission_details->weight) && is_integer($admission_details->weight)) ? $admission_details->weight / 1000 : 0;

            $bed_ward_name = isset($bed_details->ward_name) ? $bed_details->ward_name : null;
            $bed_room_no = isset($bed_details->room_no) ? $bed_details->room_no : null;
            $bed_bed_no = isset($bed_details->bed_no) ? $bed_details->bed_no : null;
            $ip_number = isset($ip_details->ip_number) ? $ip_details->ip_number : null;

            if (!str_contains($ip_number, 'IP/')) {
                $ip_number = 'IP/' . $ip_number;
            }

            $message = $baby->BMrNo . '||' . $ip_number . '||' . $baby->BabyName . '||' . $baby->BabyName;
            $message = $message . '||' . $baby->BabyName . '||' . $baby->DOB . '||' . $baby->Sex . '||' . $adt_property->syringe_pump_admission;
            $message = $message . '||' . $bed_ward_name . '||' . $bed_room_no . '||' . $bed_bed_no . '||' . $admission_details->height;
            $message = $message . '||' . $admission_details->weight . '||' . $admission_details->blood_group;

            if (isset($bed_details->pump_type)) {
                $message .= '||' . $bed_details->pump_type;
            }

            SyringePumpAdmisson::where('id', $admission_details->id)->update(['admission_stauts' => 1]);
        }
            //transfer admission
        $transfer_details = SyringePumpAdmisson::where('admission_stauts', 2)->first();

        if ($transfer_details != '' && count($transfer_details) > 0)
        {

            $ip_details = SyringePumpAdmisson::getAdmissionSyirangePump($transfer_details->baby_id, $transfer_details->admission_id);
            $bed_details = Ward::getbabyadmission($transfer_details->baby_id, $transfer_details->admission_id);
            $baby = Baby::find($transfer_details->baby_id);
            $baby->DOB = str_replace('-', '', $baby->DOB);
            $baby->Sex = ($baby->Sex == 'Male') ? 'M' : 'F';
            $admission_details_weight = isset($admission_details->weight) ? $admission_details->weight / 1000 : 0;
            $admission_details_height = isset($admission_details->height) ? $admission_details->height : 0;
            $admission_details_blood_group = isset($admission_details->blood_group) ? $admission_details->blood_group : null;

            $bed_details_ward_name = isset($bed_details->ward_name) ? $bed_details->ward_name : null;
            $bed_details_room_no = isset($bed_details->room_no) ? $bed_details->room_no : null;
            $bed_details_bed_no = isset($bed_details->bed_no) ? $bed_details->bed_no : null;
            $ip_number = isset($ip_details->ip_number) ? $ip_details->ip_number : null;

            if (!str_contains($ip_number, 'IP/')) {
                $ip_number = 'IP/' . $ip_number;
            }

            $message = $baby->BMrNo . '||' . $ip_number . '||' . $baby->BabyName . '||' . $baby->BabyName;
            $message = $message . '||' . $baby->BabyName . '||' . $baby->DOB . '||' . $baby->Sex . '||' . $adt_property->syringe_pump_transfer;
            $message = $message . '||' . $bed_details_ward_name . '||' . $bed_details_room_no . '||' . $bed_details_bed_no;
            $message = $message . '||' . $admission_details_height . '||' . $admission_details_weight . '||' . $admission_details_blood_group;

            if (isset($bed_details->pump_type)) {
                $message .= '||' . $bed_details->pump_type;
            }

            SyringePumpAdmisson::where('id', $transfer_details->id)->update(['admission_stauts' => 3]);
        }

            //discharge admission
        $discharge_details = SyringePumpAdmisson::where('admission_stauts', 4)->first();
        if ($discharge_details != '' && count($discharge_details) > 0)
        {
            $ip_details = SyringePumpAdmisson::getAdmissionSyirangePump($discharge_details->baby_id, $discharge_details->admission_id);
            $bed_details = Ward::getbabyadmission($discharge_details->baby_id, $discharge_details->admission_id);

            $baby = Baby::find($discharge_details->baby_id);
            $baby->DOB = str_replace('-', '', $baby->DOB);
            $baby->Sex = ($baby->Sex == 'Male') ? 'M' : 'F';
            $admission_details_weight = isset($admission_details->weight) ? $admission_details->weight / 1000 : 0;
            $admission_details_height = isset($admission_details->height) ? $admission_details->height : 0;
            $admission_details_blood_group = isset($admission_details->blood_group) ? $admission_details->blood_group : null;

            $bed_details_ward_name = isset($bed_details->ward_name) ? $bed_details->ward_name : null;
            $bed_details_room_no = isset($bed_details->room_no) ? $bed_details->room_no : null;
            $bed_details_bed_no = isset($bed_details->bed_no) ? $bed_details->bed_no : null;
            $ip_number = isset($ip_details->ip_number) ? $ip_details->ip_number : null;

            if (!str_contains($ip_number, 'IP/')) {
                $ip_number = 'IP/' . $ip_number;
            }

            $message = $baby->BMrNo . '||' . $ip_number . '||' . $baby->BabyName . '||' . $baby->BabyName;
            $message = $message . '||' . $baby->BabyName . '||' . $baby->DOB . '||' . $baby->Sex . '||' . $adt_property->syringe_pump_discharge;
            $message = $message . '||' . $bed_details_ward_name . '||' . $bed_details_room_no . '||' . $bed_details_bed_no;
            $message = $message . '||' . $admission_details_height . '||' . $admission_details_weight . '||' . $admission_details_blood_group;

            if (isset($bed_details->pump_type)) {
                $message .= '||' . $bed_details->pump_type;
            }

            SyringePumpAdmisson::where('id', $discharge_details->id)->update(['admission_stauts' => 5]);
        }

            // update patient details
        $patient_details = SyringePumpAdmisson::where('admission_stauts', 8)->first();
        if ($patient_details != '' && count($patient_details) > 0) {
            $ip_details = SyringePumpAdmisson::getAdmissionSyirangePump($patient_details->baby_id, $patient_details->admission_id);
            $bed_details = Ward::getbabyadmission($patient_details->baby_id, $patient_details->admission_id);

            $baby = Baby::find($patient_details->baby_id);
            $baby->DOB = str_replace('-', '', $baby->DOB);
            $baby->Sex = ($baby->Sex == 'Male') ? 'M' : 'F';
            $admission_details_weight = isset($admission_details->weight) ? $admission_details->weight / 1000 : 0;
            $admission_details_height = isset($admission_details->height) ? $admission_details->height : 0;
            $admission_details_blood_group = isset($admission_details->blood_group) ? $admission_details->blood_group : null;

            $bed_details_ward_name = isset($bed_details->ward_name) ? $bed_details->ward_name : null;
            $bed_details_room_no = isset($bed_details->room_no) ? $bed_details->room_no : null;
            $bed_details_bed_no = isset($bed_details->bed_no) ? $bed_details->bed_no : null;
            $ip_number = isset($ip_details->ip_number) ? $ip_details->ip_number : null;

            if (!str_contains($ip_number, 'IP/')) {
                $ip_number = 'IP/' . $ip_number;
            }

            $message = $baby->BMrNo . '||' . $ip_number . '||' . $baby->BabyName . '||' . $baby->BabyName;
            $message = $message . '||' . $baby->BabyName . '||' . $baby->DOB . '||' . $baby->Sex . '||' . $adt_property->patient_details_update;
            $message = $message . '||' . $bed_details_ward_name . '||' . $bed_details_room_no . '||' . $bed_details_bed_no;
            $message = $message . '||' . $admission_details_height . '||' . $admission_details_weight . '||' . $admission_details_blood_group;

            if (isset($bed_details->pump_type)) {
                $message .= '||' . $bed_details->pump_type;
            }
            SyringePumpAdmisson::where('id', $patient_details->id)->update(['admission_stauts' => 9]);
        }

        ErrorLogController::emergencyLogStat($message);

        $prescription_post_url = env('PRESCRIPTION_POST');
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $prescription_post_url, [
            'json' => [
                'type' => 'ADMISSION',
                'content' => $message
            ]
        ]);        

        $response_data = $response->getBody();
        $response_data = $response_data->getContents();

        $response_data = json_decode($response_data);

        ErrorLogController::emergencyLogStat($response_data);

        return empty($message) ? 'Admission Notfound' : $message;
    }

    public static function prescription()
    {

        ErrorLogController::emergencyLogStat('PRESCRIPTION POST');

        $to_pump = prescriptionHeader::getDrugToPump();
        $to_cancel = prescriptionHeader::getDrugToCancel();
        $to_complete = prescriptionHeader::getDrugToComplete();

        $start_time = Carbon::now(env('TIME_ZONE'))->addMinutes(5)->format('YmdHis');

        if ($to_cancel != '' && count($to_cancel) > 0)
        {

            $baby_details = Baby::find($to_cancel->baby_id);

            $baby_id = $to_cancel->baby_id;
            $admission_id = $to_cancel->admission_id;

            $master_drugs = \DB::table('mas_drugivfluid')->where(['is_deleted' => 0, 'status' => 1])
            ->pluck('generic_pharmacological_name', 'id')
            ->toArray();

            $drug_name = $master_drugs[$to_cancel->pharmacological_name];
            $sequence = $to_cancel->prescription_id;

            $prescription_format = preg_replace('/[0-9]/', '', $sequence);

            switch ($prescription_format)
            {
                case 'IVDI':
                $quantity = $to_cancel->quantity;

                $does = $to_cancel->dose;

                $quantity_unit = \ValuelistHelpers::infusionquantityunits($to_cancel->quantity_units);
                $does_unit_g = \ValuelistHelpers::infusiondoesunitgrams($to_cancel->dose_units_g);
                $does_unit_kg = \ValuelistHelpers::infusiondoeskilograms($to_cancel->dose_units_kg);
                $does_unit_time = \ValuelistHelpers::infusiondoesduration($to_cancel->dose_units_time);

                if (!is_array($does_unit_g) && !is_array($does_unit_kg) && !is_array($does_unit_time))
                {
                    $does_unit = $does_unit_g . '/' . $does_unit_kg . '/' . $does_unit_time;

                }
                else
                {
                    $does_unit = '';
                }

                $syringe_size = $to_cancel->syringe_size;
                $syringe_unit = 'ml';
                $pump_type = 'IV';
                $order_type = $to_cancel->order_status;
                $infusion_rate = $to_cancel->rate;
                $repeat_pattern = '';
                $event_time = date('YmdHis', strtotime($to_cancel->event_time));

                $is_send = '8';
                if ($to_cancel->order_pump_type == 'e-n-series') {
                    $message = $baby_details->BMrNo . '||' . $sequence . '||manually-completed||' . $to_cancel->is_send;
                } else {
                    $message = $baby_details->BMrNo . '||' . $drug_name . '||' . $sequence . '||' . $quantity . '||' . $quantity_unit . '||' . $does . '||' . $does_unit . '||' . $syringe_size . '||' . $start_time . '||' . $pump_type . '||' . $order_type . '||' . $to_cancel->instruction . '||' . $repeat_pattern . '||' . $start_time . '||' . $infusion_rate. '||' . $to_cancel->order_pump_type. '||' . $to_cancel->order_pump_device_id. '||' . $event_time;
                }

                prescriptionDetails::where('id', $to_cancel->dtl_id)->update(['is_send' => $is_send, 'is_cancel' => true]);

                break;
                case 'OIVD':
                $does = $to_cancel->dose;

                $does_unit_g = \ValuelistHelpers::infusiondoesunitgrams($to_cancel->dose_units_g);

                $dose_units = $does_unit_g;
                $frequency = $to_cancel->frequency;
                $syringe = $to_cancel->syringe_size;
                $rate = $to_cancel->rate;
                $order_status = $to_cancel->order_status;
                $pump_type = $to_cancel->infusion_type;
                $syringe_size = $to_cancel->syringe_size;
                $order_type = $to_cancel->order_status;
                $infusion_rate = $to_cancel->rate;
                $repeat_pattern = '';
                $event_time = date('YmdHis', strtotime($to_cancel->event_time));

                $is_send = '8';
                if ($to_cancel->order_pump_type == 'e-n-series') {
                    $message = $baby_details->BMrNo . '||' . $sequence . '||manually-completed||' . $to_cancel->is_send;
                } else {
                    $message = $baby_details->BMrNo . '||' . $drug_name . '||' . $sequence . '||' . $does . '||' . $dose_units . '||' . null . '||' . null . '||' . $syringe_size . '||' . $start_time . '||' . $pump_type . '||' . $order_type . '||' . $to_cancel->instruction . '||' . $repeat_pattern . '||' . $start_time . '||' . $infusion_rate. '||' . $to_cancel->order_pump_type. '||' . $to_cancel->order_pump_device_id. '||' . $event_time;
                }

                prescriptionDetails::where('id', $to_cancel->dtl_id)->update(['is_send' => $is_send, 'is_cancel' => true]);

                break;
                case 'OIVI':
                $does = $to_cancel->volume;
                $frequency = $to_cancel->duration . '' . $to_cancel->duration_time;
                $rate = $to_cancel->rate;
                $volume_does = 'ml';
                $order_status = $to_cancel->order_status;
                $pump_type = $to_cancel->infusion_type;
                $order_type = $to_cancel->order_status;
                $infusion_rate = $to_cancel->rate;

                $repeat_pattern = '';
                $event_time = date('YmdHis', strtotime($to_cancel->event_time));

                $is_send = '8';
                if ($to_cancel->order_pump_type == 'e-n-series') {
                    $message = $baby_details->BMrNo . '||' . $sequence . '||manually-completed||' . $to_cancel->is_send;
                } else {
                    $message = $baby_details->BMrNo . '||' . $drug_name . '||' . $sequence . '||' . $does . '||' . $volume_does . '||' . null . '||' . null . '||' . $does . '||' . $start_time . '||' . $pump_type . '||' . $order_type . '||' . $to_cancel->instruction . '||' . $repeat_pattern . '||' . $start_time . '||' . $infusion_rate. '||' . $to_cancel->order_pump_type. '||' . $to_cancel->order_pump_device_id. '||' . $event_time;
                }

                prescriptionDetails::where('id', $to_cancel->dtl_id)
                ->update(['is_send' => $is_send, 'is_cancel' => true]);

                break;
            }

            self::prescriptionPosting($message);
        }

        if ($to_pump != '' && count($to_pump) > 0)
        {

            $baby_details = Baby::find($to_pump->baby_id);

            $baby_id = $to_pump->baby_id;
            $admission_id = $to_pump->admission_id;

            $master_drugs = \DB::table('mas_drugivfluid')->where(['is_deleted' => '0', 'status' => '1'])
            ->pluck('generic_pharmacological_name', 'id')
            ->toArray();

            $drug_name = $master_drugs[$to_pump->pharmacological_name];

            $sequence = ($to_pump != '' && count($to_pump) > 0) ? $to_pump->prescription_id : '';

            $prescription_format = preg_replace('/[0-9]/', '', $sequence);

            switch ($prescription_format)
            {
                case 'IVDI':
                $quantity = $to_pump->quantity;

                $does = $to_pump->dose;

                $quantity_unit = \ValuelistHelpers::infusionquantityunits($to_pump->quantity_units);
                $does_unit_g = \ValuelistHelpers::infusiondoesunitgrams($to_pump->dose_units_g);
                $does_unit_kg = \ValuelistHelpers::infusiondoeskilograms($to_pump->dose_units_kg);
                $does_unit_time = \ValuelistHelpers::infusiondoesduration($to_pump->dose_units_time);

                $does_unit = '';
                if (!is_array($does_unit_g) && !is_array($does_unit_kg) && !is_array($does_unit_time))
                {
                    $does_unit = $does_unit_g . '/' . $does_unit_kg . '/' . $does_unit_time;
                }

                $syringe_size = $to_pump->syringe_size;
                $syringe_unit = 'ml';
                $event_time = date('YmdHis', strtotime($to_pump->event_time));
                $pump_type = 'IV';
                $order_type = $to_pump->order_status;
                $infusion_rate = $to_pump->rate;
                $repeat_pattern = '';

                $message = $baby_details->BMrNo . '||' . $drug_name . '||' . $sequence . '||' . $quantity . '||' . $quantity_unit . '||' . $does . '||' . $does_unit . '||' . $syringe_size . '||' . $start_time . '||' . $pump_type . '||' . $order_type . '||' . $to_pump->instruction . '||' . $repeat_pattern . '||' . $start_time . '||' . $infusion_rate. '||' . $to_pump->order_pump_type. '||' . $to_pump->order_pump_device_id. '||' . $event_time;

                prescriptionDetails::where('id', $to_pump->dtl_id)->update(['is_send' => '9']);

                break;
                case 'OIVD':
                $does = $to_pump->dose;

                $does_unit_g = \ValuelistHelpers::infusiondoesunitgrams($to_pump->dose_units_g);

                $dose_units = $does_unit_g;
                $frequency = $to_pump->frequency;
                $syringe = $to_pump->syringe_size;
                $rate = $to_pump->rate;
                $order_status = $to_pump->order_status;
                $pump_type = $to_pump->infusion_type;
                $syringe_size = $to_pump->syringe_size;
                $order_type = $to_pump->order_status;
                $infusion_rate = $to_pump->rate;
                $event_time = date('YmdHis', strtotime($to_pump->event_time));

                $message = $baby_details->BMrNo . '||' . $drug_name . '||' . $sequence . '||' . $does . '||' . $dose_units . '||' . null . '||' . null . '||' . $syringe_size . '||' . $start_time . '||' . $pump_type . '||' . $order_type . '||' . $to_pump->instruction . '||' . null . '||' . $start_time . '||' . $infusion_rate . '||' . $to_pump->order_pump_type. '||' . $to_pump->order_pump_device_id. '||' . $event_time;

                prescriptionDetails::where('id', $to_pump->dtl_id)->update(['is_send' => '9']);

                break;
                case 'OIVI':
                $does = $to_pump->volume;
                $frequency = $to_pump->duration . '' . $to_pump->duration_time;
                $rate = $to_pump->rate;
                $volume_does = 'ml';
                $order_status = $to_pump->order_status;
                $pump_type = $to_pump->infusion_type;
                $order_type = $to_pump->order_status;
                $infusion_rate = $to_pump->rate;
                $event_time = date('YmdHis', strtotime($to_pump->event_time));

                $repeat_pattern = '';

                $message = $baby_details->BMrNo . '||' . $drug_name . '||' . $sequence . '||' . $does . '||' . $volume_does . '||' . null . '||' . null . '||' . $does . '||' . $start_time . '||' . $pump_type . '||' . $order_type . '||' . $to_pump->instruction . '||' . $repeat_pattern . '||' . $start_time . '||' . $infusion_rate . '||' . $to_pump->order_pump_type. '||' . $to_pump->order_pump_device_id. '||' . $event_time;

                prescriptionDetails::where('id', $to_pump->dtl_id)->update(['is_send' => '9']);

                break;
            }

            $post['id'] = $to_pump->id;
            $post['is_send'] = 9;
            $post['admission_id'] = $to_pump->admission_id;
            $post['prescription_from'] = 1;
            $post['started_date'] = $to_pump->started_date;
            $post['started_user'] = $to_pump->started_user;
            $post['prescription_id'] = $to_pump->prescription_id;
            $post['pres_hdr_id'] = $to_pump->pres_hdr_id;

            $post['active_id'] = prescriptionDetails::getGivenPrescription($to_pump->pres_hdr_id);

            PrescriptionController::prescriptionSendToUser($post);

            ErrorLogController::emergencyLogStat('PRESCRIPTION REQUESTED SERVER POST =========== '.json_encode($post));
            ErrorLogController::emergencyLogStat('PRESCRIPTION MESSAGE =========== '.$message);

            self::prescriptionPosting($message);

        }

        if ($to_complete != '' && count($to_complete) > 0)
        {

            $baby_details = Baby::find($to_complete->baby_id);

            $sequence = ($to_complete != '' && count($to_complete) > 0) ? $to_complete->prescription_id : '';

            $message = $baby_details->BMrNo . '||' . $sequence . '||manually-completed';

            prescriptionDetails::where('prescription_id', $sequence)->update(['is_send' => '20']);

            self::prescriptionPosting($message);
        }

        return 'Not found';

    }

    public static function prescriptionPosting($message)
    {

        $prescription_post_url = env('PRESCRIPTION_POST');
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $prescription_post_url, [
            'json' => [
                'type' => 'PRESCRIPTION',
                'content' => $message
            ]
        ]);        

        $response_data = $response->getBody();
        $response_data = $response_data->getContents();

        $response_data = json_decode($response_data);


        ErrorLogController::emergencyLogStat($response_data);

        return $message;

    }
}
