<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class VentilatorTempProcessController extends Controller
{
    public function index(Request $request)
    {
        $input = $request->all();

        $mrn = $input['mrn'];
        $result_time = date('Y-m-d H', strtotime($input['result_time']));
        $result_time_start = $result_time . ':00:00';
        $result_time_end = $result_time . ':59:59';

        $table_name = 'mrn_' . $mrn;

        $local_code_id = [55,295,56,49,296,60,0,50,52,141,225,47,51,82,48,281,113,81,53,54,58,36,111,57,59,110,279,280];
        $snomed_code = ['260915005','250874002','250819002:118582008','250819002','118241009:7771000','11824100924028007','706180003=703421000','250876000','243155002+86290005','250854009','250817000','243155002+698821009+40885006','27913002','410658008+258734002','405609003','250774007','250849000','258104002+250819002','711347008','698821009','86290005','27913002+258104002','336590007','258104002+250774007','397814002'];

        $map  = [58 => '260915005', 82 => '250874002', 55 => '250819002:118582008', 57 => '250819002', 111 => '118241009:7771000', 110 => '11824100924028007', 60 => '706180003=703421000', 54 => '250876000', 56 => '243155002+86290005', 50 => '250854009', 81 => '250817000', 48 => '243155002+698821009+40885006', 49 => '27913002', 281 => '410658008+258734002', 113 => '405609003', 52 => '250774007', 53 => '250849000', 279 => '258104002+250819002', 59 => '711347008', 51 => '698821009', 36 => '86290005', 141 => '27913002+258104002', 295 => '336590007', 296 => '258104002+250774007', 47 => '397814002'];


        $data = \DB::connection('mirth_db')
        ->table($table_name)
        ->select('result_date_time', 'result_value', 'snomed_code', 'machine_model', 'machine_details')
        ->where('machine_model', 'ilike', '%SLE%')
        ->where('result_value', '<>', '-')
        ->whereBetween('result_date_time', [$result_time_start, $result_time_end])
        ->whereIn('snomed_code', ['260915005','250874002','250819002:118582008','250819002','118241009:7771000','11824100924028007','706180003=703421000','250876000','243155002+86290005','250854009','250817000','243155002+698821009+40885006','27913002','410658008+258734002','405609003','250774007','250849000','258104002+250819002','711347008','698821009','86290005','27913002+258104002','336590007','258104002+250774007','397814002'])
        ->whereIn('snomed_code', ['336590007'])
        ->orderBy('result_date_time', 'desc')
        ->get()->groupby('snomed_code');

        $log_id = \DB::table('emr_log_hdr')
        ->leftjoin('baby', 'emr_log_hdr.baby_id', 'baby.BabyId')
        ->where('BMrNo', $mrn)
        ->whereBetween('sender_time', [$result_time_start, $result_time_end])
        ->orderBy('id', 'desc')
        ->first();

        $created_user_id = 3;
        foreach ($data as $key => $value) {
            $key = (string)$key;
            $loinc_local_map_id = array_search($key, $map);
            $final_value =  $value[0];

            if ($key == '405609003') {
                $asset_number = explode(':', $final_value->machine_details);
                $final_value->result_value = ($asset_number[3] == '255') ? 'on' : null;
            }


            $post['log_hdr_id'] = $log_id->id;
            $post['loinc_local_map_id'] = $loinc_local_map_id;
            $post['intf_ref_value'] = $final_value->result_value;
            $post['original_intf_ref_value'] = $final_value->result_value;
            $post['result_date_time'] = $final_value->result_date_time;
            $post['create_user_id'] = $created_user_id;
            $post['create_tstamp'] = Carbon::now();
            $post['device_model'] = $final_value->machine_model;
            $post['device_id'] = $final_value->machine_details;

            \DB::table('emr_ventilator_values')->insert($post);
// echo '<pre>';print_r($post);
        }
// exit;

        if (isset($final_value)) {
            if ($final_value->machine_details != '' && count(explode(':', $final_value->machine_details)) == 5)
            {
                $asset_number = explode(':', $final_value->machine_details);
                $final_value->result_value = \DeviceHelpers::getVendilationMode($asset_number[2], $final_value->machine_model);
                $loinc_local_map_id = 47;
            }
            elseif ($final_value->machine_details != '' && count(explode(':', $final_value->machine_details)) == 4)
            {
                $asset_number = explode(':', $final_value->machine_details);
                $final_value->result_value = \DeviceHelpers::getVendilationMode($asset_number[2], $final_value->machine_model);
                $loinc_local_map_id = 47;
            }

            $post['log_hdr_id'] = $log_id->id;
            $post['loinc_local_map_id'] = $loinc_local_map_id;
            $post['intf_ref_value'] = $final_value->result_value;
            $post['original_intf_ref_value'] = $final_value->result_value;
            $post['result_date_time'] = $final_value->result_date_time;
            $post['create_user_id'] = $created_user_id;
            $post['create_tstamp'] = Carbon::now();
            $post['device_model'] = $final_value->machine_model;
            $post['device_id'] = $final_value->machine_details;
            $post['is_approved'] = false;

            \DB::table('emr_ventilator_values')->insert($post);
        }
        exit;
    }
}
