<?php

namespace App\Http\Controllers\Reports;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use App\Models\Baby;
use App\Models\Settings\Settings;
use App\Models\Nurse\NurseSheetMain;
use App\Models\prescription;
use Excel;

class NutritionChartController extends Controller
{
    public function __construct() {
        $this->middleware('role:NUTRITION_CHART,read');
    }
    
    public function index(Request $request) {
        $babies = Baby::babyListData()->pluck('baby_name_mrn', 'BabyId')->toArray();
        return view('reports.nutrition_chart.list',compact('babies'));
    }
    
    public function getNutritionData(Request $request) {
        $input = $request->all();
        $baby_id = null;
        
        if (isset($input['baby'])) {
            $baby_id = $input['baby'];
            
            $data_set = $this->processData($baby_id);
            $drug_infused = $data_set['drug_infused'];
            $day_wise_milk_volume = $data_set['day_wise_milk_volume'];
            $sheet_date_list = $data_set['sheet_date_list'];
        }
        $babies = Baby::babyListData()->pluck('baby_name_mrn', 'BabyId')->toArray();
        return view('reports.nutrition_chart.list', compact('drug_infused', 'day_wise_milk_volume', 'baby_id', 'sheet_date_list', "babies"));
    }

    function processData($baby_id) {
        $sheet_date_list = NurseSheetMain::select('sheet_date')->where('baby_id', $baby_id)->orderBy('sheet_date', 'asc')->get()->pluck('sheet_date');
        // Initial load only needs the first day's data
        $day_result = [];
        if (count($sheet_date_list) > 0) {
             $day_result = $this->getNutritionDataByDateAndBabyId($sheet_date_list[0], $baby_id);
        }

        // Structure the data to be keyed by date to match the view's expectation
        $drug_infused = [];
        $day_wise_milk_volume = [];
        
        if (!empty($day_result)) {
            $date = $sheet_date_list[0];
            $drug_infused[$date] = $day_result['drug_infused'];
            $day_wise_milk_volume[$date] = $day_result['day_wise_milk_volume'];
        }

        return ['drug_infused' => $drug_infused, 'day_wise_milk_volume' => $day_wise_milk_volume, 'sheet_date_list' => $sheet_date_list, 'baby_id' => $baby_id];
    }
    
    function getNutritionDataByDateWise(Request $request) {
        $input = $request->all();
        if (isset($input['date']) && !empty($input['date']) && isset($input['baby_id']) && !empty($input['baby_id'])) {
             $sheet_date = $input['date'];
             $baby_id = $input['baby_id'];
             
             $result = $this->getNutritionDataByDateAndBabyId($sheet_date, $baby_id);
             $drug_infused[$sheet_date] = $result['drug_infused'];
             $day_wise_milk_volume[$sheet_date] = $result['day_wise_milk_volume'];
             
             $html = view('reports.nutrition_chart._table', compact('sheet_date', 'drug_infused', 'day_wise_milk_volume'))->render();
             
             return response()->json(['html' => $html]);
        }
        return response()->json(['html' => '<tr><td colspan="8" class="text-center text-danger">Invalid Request</td></tr>'], 400);
    }

    public function getNutritionDataByDateAndBabyId($sheet_date, $baby_id){
        $working_time = Settings::getPeriod()->period;
        $working_hour = substr($working_time, 0, 2);
        $working_hour = (int)$working_hour;
        $drug_infused = $day_wise_milk_volume = $sheet_date_list = $milk_volume = [];
        $start_date_time = $sheet_date . ' '. $working_time;
        $end_date_time = date('Y-m-d H:i:s', strtotime($start_date_time . ' +1 day -1 second'));

        $inpatient_prescribed_drug_list = \DB::table('prescription_hdr')
        ->select('prescription_infused_calculation.hour_infused as infused', 'prescription_hdr.instruction', 'prescription_dtl.prescription_id', 'prescription_hdr.brand_name as code')
        ->selectRaw('mas_drugivfluid.brand_name|| \' / \' ||mas_drugivfluid.generic_pharmacological_name as drug_name')
        ->leftJoin('mas_drugivfluid', 'mas_drugivfluid.id', 'prescription_hdr.brand_name')
        ->leftJoin('prescription_dtl', 'prescription_dtl.pres_hdr_id', 'prescription_hdr.id')
        ->leftjoin('prescription_infused_calculation', function ($join) {
            $join->orOn('prescription_dtl.prescription_id', '=', 'prescription_infused_calculation.prescription_id');
        })
        ->whereIn('prescription_hdr.brand_name', [7, 8, 14, 15])
        ->where('baby_id', $baby_id)
        ->where('order_status', '<>', 'RS')
        ->where('order_status', '<>', 'EP')
        ->where(function($query) use ($start_date_time, $end_date_time) {
            $query->where('prescription_dtl.started_date', '>=', $start_date_time)
            ->orWhere('prescription_dtl.started_date', '<', $end_date_time);
        })
        ->where('prescription_infused_calculation.calculated_hour', '>=', $start_date_time)
        ->where('prescription_infused_calculation.calculated_hour', '<', $end_date_time)
        ->orderBy('prescription_dtl.id', 'asc')
        ->get()
        ->groupBy('prescription_id')
        ->map(function ($prescription_data, $prescription_id) use ($sheet_date, &$drug_infused) {
            $data = collect($prescription_data)->first();
            $drug_infused[$data->code][$prescription_id]['drug_name'] = $data->drug_name;
            $drug_infused[$data->code][$prescription_id]['instruction'] = $data->instruction;
            $drug_infused[$data->code][$prescription_id]['day_infused'] = array_sum(collect($prescription_data)->pluck('infused')->toArray());
        });

        $discharge_prescribed_drug_list = \DB::table('prescription_hdr')
        ->select('prescription_infused_calculation_discharged.hour_infused as infused', 'prescription_hdr.instruction', 'prescription_dtl_discharged.prescription_id', 'prescription_hdr.brand_name as code')
        ->selectRaw('mas_drugivfluid.brand_name|| \' / \' ||mas_drugivfluid.generic_pharmacological_name as drug_name')
        ->leftJoin('mas_drugivfluid', 'mas_drugivfluid.id', 'prescription_hdr.brand_name')
        ->leftJoin('prescription_dtl_discharged', 'prescription_dtl_discharged.pres_hdr_id', 'prescription_hdr.id')
        ->leftjoin('prescription_infused_calculation_discharged', function ($join) {
            $join->orOn('prescription_dtl_discharged.prescription_id', '=', 'prescription_infused_calculation_discharged.prescription_id');
        })
        ->whereIn('prescription_hdr.brand_name', [7, 8, 14, 15])
        ->where('baby_id', $baby_id)
        ->where('order_status', '<>', 'RS')
        ->where('order_status', '<>', 'EP')
        ->where(function($query) use ($start_date_time, $end_date_time) {
            $query->where('prescription_dtl_discharged.started_date', '>=', $start_date_time)
            ->orWhere('prescription_dtl_discharged.started_date', '<', $end_date_time);
        })
        ->where('prescription_infused_calculation_discharged.calculated_hour', '>=', $start_date_time)
        ->where('prescription_infused_calculation_discharged.calculated_hour', '<', $end_date_time)
        ->orderBy('prescription_dtl_discharged.id', 'asc')
        ->get() // Fixed typo here
        ->groupBy('prescription_id')
        ->map(function ($prescription_data, $prescription_id) use ($sheet_date, &$drug_infused) {
            $data = collect($prescription_data)->first();
            $drug_infused[$data->code][$prescription_id]['drug_name'] = $data->drug_name;
            $drug_infused[$data->code][$prescription_id]['instruction'] = $data->instruction;
            $drug_infused[$data->code][$prescription_id]['day_infused'] = array_sum(collect($prescription_data)->pluck('infused')->toArray());
        });          

        $inpatient_milk_list = \DB::table('emr_log_hdr')
        ->select('sender_time', 'intf_ref_value', 'loinc_local_map_id')
        ->leftJoin('emr_nurse_manual_values', 'emr_nurse_manual_values.log_hdr_id', 'emr_log_hdr.id')
        ->whereIn('loinc_local_map_id', [28, 84])
        ->where('baby_id', $baby_id)
        ->where(function($query) use ($start_date_time, $end_date_time) {
            $query->where('sender_time', '>=', $start_date_time)
            ->where('sender_time', '<', $end_date_time);
        })
        ->whereNotNull('intf_ref_value')
        ->where('intf_ref_value', '<>', '')
        ->orderBy('emr_nurse_manual_values.id', 'asc')
        ->get()
        ->groupBy(['sender_time', 'loinc_local_map_id'])
        ->map(function ($data, $id) use ($sheet_date, &$milk_volume) {
            $type = null;
            $vol = 0;
            if (isset($data[28]) && isset($data[28][0]) && $data[28][0]->intf_ref_value) {
                $type = $data[28][0]->intf_ref_value;
            }
            if (isset($data[84]) && isset($data[84][0]) && $data[84][0]->intf_ref_value) {
                $vol = $data[84][0]->intf_ref_value;
            }
            if (!isset($milk_volume)) {
                $milk_volume = [];
            }
            $milk_volume[$type][] = $vol;
        });

        $inpatient_milk_list = \DB::table('emr_log_hdr')
        ->select('sender_time', 'intf_ref_value', 'loinc_local_map_id')
        ->leftJoin('emr_nurse_manual_values_discharged', 'emr_nurse_manual_values_discharged.log_hdr_id', 'emr_log_hdr.id')
        ->whereIn('loinc_local_map_id', [28, 84])
        ->where('baby_id', $baby_id)
        ->where(function($query) use ($start_date_time, $end_date_time) {
            $query->where('sender_time', '>=', $start_date_time)
            ->where('sender_time', '<', $end_date_time);
        })
        ->whereNotNull('intf_ref_value')
        ->where('intf_ref_value', '<>', '')
        ->orderBy('emr_nurse_manual_values_discharged.id', 'asc')
        ->get()
        ->groupBy(['sender_time', 'loinc_local_map_id'])
        ->map(function ($data, $id) use ($sheet_date, &$milk_volume) {
            $type = null;
            $vol = 0;
            if (isset($data[28]) && isset($data[28][0]) && $data[28][0]->intf_ref_value) {
                $type = $data[28][0]->intf_ref_value;
            }
            if (isset($data[84]) && isset($data[84][0]) && $data[84][0]->intf_ref_value) {
                $vol = $data[84][0]->intf_ref_value;
            }
            if (!isset($milk_volume)) {
                $milk_volume = [];
            }
            $milk_volume[$type][] = $vol;
        });
        foreach ($milk_volume as $type => $volumes) {
            if (is_array($volumes)) {
                $day_wise_milk_volume[$type] = array_sum($volumes);
            }
        }
        return ['drug_infused'=> $drug_infused, 'day_wise_milk_volume' => $day_wise_milk_volume];
    }

    public function export(Request $request)
    {
        $input = $request->all();

        $mrn = null;

        if (isset($input['mrn'])) {
            $mrn = $input['mrn'];
            
            // Re-using logic to get full date list
             $sheet_date_list = NurseSheetMain::select('sheet_date')->where('baby_id', $mrn)->orderBy('sheet_date', 'asc')->get()->pluck('sheet_date');

            // Need to fetch data for ALL dates for export
            $drug_infused = [];
            $day_wise_milk_volume = [];
            
            foreach($sheet_date_list as $date) {
                 $day_result = $this->getNutritionDataByDateAndBabyId($date, $mrn);
                 if (isset($day_result['drug_infused'])) {
                     $drug_infused[$date] = $day_result['drug_infused'];
                 }
                 if (isset($day_result['day_wise_milk_volume'])) {
                     $day_wise_milk_volume[$date] = $day_result['day_wise_milk_volume'];
                 }
            }

            $file_name = $mrn . '_nutrition_chart';

            Excel::create($file_name, function($excel) use ($mrn, $drug_infused, $file_name, $day_wise_milk_volume, $sheet_date_list) {

                if (count($sheet_date_list) === 0) {
                    $excel->sheet('No_Data', function($sheet) {
                        $sheet->row(1, ['No nutrition data available.']);
                    });
                    return;
                }

                $z = 1;

                foreach ($sheet_date_list as $index => $sheet_date) {

                    $drug_dtl = $dextrose10 = $isolytep = $aminoven = $lipids = $data_set = [];

                    if (isset($drug_infused[$sheet_date])) {
                        $drug_dtl = $drug_infused[$sheet_date];
                        $dextrose10 = isset($drug_dtl[7]) ? $drug_dtl[7] : [];
                        $isolytep = isset($drug_dtl[8]) ? $drug_dtl[8] : [];
                        $aminoven = isset($drug_dtl[14]) ? $drug_dtl[14] : [];
                        $lipids = isset($drug_dtl[15]) ? $drug_dtl[15] : [];
                    }

                    if (is_array($dextrose10) && count($dextrose10) > 0) {
                        $i = 0;
                        foreach($dextrose10 as $item) {
                            $data_set[$i][0] = $item['day_infused'];
                            $data_set[$i][1] = $item['instruction'];
                            $i++;
                        }
                    }

                    if (is_array($isolytep) && count($isolytep) > 0) {
                        $k = 0;
                        foreach($isolytep as $item) {
                            $data_set[$k][2] = $item['day_infused'];
                            $data_set[$k][3] = $item['instruction'];
                            $k++;
                        }
                    }

                    if (is_array($aminoven) && count($aminoven) > 0) {
                        $m = 0;
                        foreach($aminoven as $item) {
                            $data_set[$m][4] = $item['day_infused'];
                            $m++;
                        }
                    }

                    if (is_array($lipids) && count($lipids) > 0) {
                        $n = 0;
                        foreach($lipids as $item) {
                            $data_set[$n][5] = $item['day_infused'];
                            $n++;
                        }
                    }

                    if (isset($day_wise_milk_volume[$sheet_date])) {
                        $o = 0;
                        foreach($day_wise_milk_volume[$sheet_date] as $type => $vol) {
                            $data_set[$o][6] = $vol;
                            $data_set[$o][7] = $type;
                            $o++;
                        }
                    }

                    $excel->sheet('Day ' . $z . ' (' . date('d_m_Y', strtotime($sheet_date)) . ')', function($sheet) use ($mrn, $drug_infused, $file_name, $day_wise_milk_volume, $sheet_date, $data_set) {

                        $sheet->row(1, ['10% dextrose', '10% dextrose instruction', 'Isolyte P', 'Isolyte P instruction', 'Aminoven', 'Lipids', 'Milk', 'Type of milk']);

                        $k = 2;

                        for ($i = 0; $i < count($data_set); $i++) {
                            $row_content = [];
                            for ($j = 0; $j < 8; $j++) {
                                if (isset($data_set[$i][$j]) && !empty($data_set[$i][$j])) {
                                    $row_content[] = $data_set[$i][$j];
                                } else {
                                    $row_content[] = '-';
                                }
                            }
                            $sheet->row($k, $row_content);
                            $k++;
                        }

                    });
                    $z++;
                }

            })->download('xls');

        }

        return view('reports.nutrition_chart.export', compact('drug_infused', 'day_wise_milk_volume', 'mrn', 'sheet_date_list'));

    }
}
