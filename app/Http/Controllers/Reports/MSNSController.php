<?php

namespace App\Http\Controllers\Reports;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use App\Models\Baby;
use App\Models\Daycare;
use App\Models\Neonatal;
use App\Models\Nicu;
use App\Models\Admission;

class MSNSController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:MSNS,read');
    }

    /**
     * DISPLAY THE RECORDS ACCORDING TO THE FILTERS APPLIED
     *
     */
    public function index(Request $request)
    {
        $baby_id = $request->baby_id;
        if (!empty($baby_id)) {
            // Re-encrypt it to ensure it matches the keys in $babies array (just in case it was modified or raw)
            $baby_id = \SiteHelpers::encrypt_id(\SiteHelpers::decrypt_id($baby_id));
        } else {
            $baby_id = 'N/A';
        }
        $navigate['main_nav'] = '';
        $navigate['sub_nav'] = '';

        $babies = Baby::babyListData()->mapWithKeys(function ($item) {
            return [\SiteHelpers::encrypt_id($item->BabyId) => $item->baby_name_mrn];
        })->toArray();

        return view('reports.msns.view', compact('babies', 'navigate', 'baby_id'));
    }

    public function show(Request $request)
    {
        $baby_id = \SiteHelpers::decrypt_id($request->baby_id);
        $admission_id = $request->id;

        // Get Admission Details
        if (!empty($admission_id)) {
            $admission = \App\Models\Admission::find($admission_id);
        } else {
            $admission = \App\Models\Admission::get_existing_admission($baby_id);
            if (!$admission) {
                $admission = \DB::table('baby_admission')->where('BabyId', $baby_id)->orderBy('AdmissionId', 'desc')->first();
            }
        }

        if (!$admission) {
            return response()->json(['error' => 'No admission found'], 404);
        }

        $baby_id = $admission->BabyId; // Ensure we have the correct baby_id from admission

        // New Logic: Admission Time is the first value occurred in emr_log_hdr table
        $firstLogTs = \DB::table('emr_log_hdr')
            ->where('baby_id', $baby_id)
            ->orderBy('sender_time', 'asc')
            ->value('sender_time');

        if ($firstLogTs) {
            $admissionTimestamp = Carbon::parse($firstLogTs);
        } else {
            // Fallback to nicu_admission table only if no logs exist
            $admissionDate = $admission->AdmissionDate;
            $admissionTime = $admission->AdmissionTime;

            // Normalize time: if it's just '8' or '8:00', make it '08:00:00'
            if ($admissionTime) {
                if (strpos($admissionTime, ':') === false) {
                    $admissionTime = sprintf('%02d:00:00', (int) $admissionTime);
                } elseif (substr_count($admissionTime, ':') == 1) {
                    $admissionTime .= ':00';
                }
            } else {
                $admissionTime = '00:00:00';
            }

            try {
                $admissionTimestamp = Carbon::parse($admissionDate . ' ' . $admissionTime);
            } catch (\Exception $e) {
                $admissionTimestamp = Carbon::parse($admissionDate . ' 00:00:00');
            }
        }
        // Get Discharge Details
        $nicuAdmission = \App\Models\Nicu::where('AdmissionId', $admission->AdmissionId)->first();
        $dischargeTimestamp = null;
        $los = 'N/A';

        if ($nicuAdmission && $nicuAdmission->DischargeDate) {
            // New logic: Redefine discharge time as the last SpO2 (ID 44) timestamp from monitor
            $ts_live = \DB::table('emr_moniter_values')
                ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_moniter_values.log_hdr_id')
                ->where('emr_log_hdr.baby_id', $baby_id)
                ->where('loinc_local_map_id', 44)
                ->whereNotNull('intf_ref_value')
                ->where('intf_ref_value', '<>', '')
                ->orderBy('result_date_time', 'desc')
                ->value('result_date_time');

            $ts_discharged = \DB::table('emr_moniter_values_discharged')
                ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_moniter_values_discharged.log_hdr_id')
                ->where('emr_log_hdr.baby_id', $baby_id)
                ->where('loinc_local_map_id', 44)
                ->whereNotNull('intf_ref_value')
                ->where('intf_ref_value', '<>', '')
                ->orderBy('result_date_time', 'desc')
                ->value('result_date_time');

            $last_spo2_timestamp = null;
            if ($ts_live && $ts_discharged) {
                $last_spo2_timestamp = (Carbon::parse($ts_live)->gt(Carbon::parse($ts_discharged))) ? $ts_live : $ts_discharged;
            } else {
                $last_spo2_timestamp = $ts_live ?: $ts_discharged;
            }

            if ($last_spo2_timestamp) {
                $dischargeTimestamp = Carbon::parse($last_spo2_timestamp);
            } else {
                $dischargeTime = $nicuAdmission->DischargeTransferedTime ?? '23:59:59';
                // Normalize discharge time
                if ($dischargeTime) {
                    if (strpos($dischargeTime, ':') === false) {
                        $dischargeTime = sprintf('%02d:00:00', (int) $dischargeTime);
                    } elseif (substr_count($dischargeTime, ':') == 1) {
                        $dischargeTime .= ':00';
                    }
                } else {
                    $dischargeTime = '23:59:59';
                }
                $dischargeTimestamp = Carbon::parse($nicuAdmission->DischargeDate . ' ' . $dischargeTime);
            }

            // Calculate LoS in hours
            $diffInHours = $admissionTimestamp->diffInHours($dischargeTimestamp);
            $days = floor($diffInHours / 24);
            $hours = $diffInHours % 24;
            $los = "{$days}d {$hours}h";
        } else {
            // If not discharged, LoS is from admission to now
            $diffInHours = $admissionTimestamp->diffInHours(Carbon::now());
            $days = floor($diffInHours / 24);
            $hours = $diffInHours % 24;
            $los = "{$days}d {$hours}h (Current)";
        }

        // Get Baby DOB
        $baby = Baby::find($baby_id);
        $dob = $baby ? date('d-m-Y', strtotime($baby->DOB)) : 'N/A';

        // Time Points
        $times = [
            'admission' => $admissionTimestamp->copy(),
            '24h' => $admissionTimestamp->copy()->addHours(24),
            '72h' => $admissionTimestamp->copy()->addHours(72)
        ];

        $scores = [];
        $formatted_times = [];

        foreach ($times as $key => $timestamp) {
            $date = $timestamp->format('Y-m-d');
            $hour = $timestamp->format('H');

            // Generate formatted string for header
            $formatted_times[$key] = $timestamp->format('d-m-Y H:i');

            // Only calculate if time is in the past (or present)
            if ($timestamp->isPast()) {
                $scores[$key] = $this->calculateScore($baby_id, $date, $hour);
            } else {
                $scores[$key] = null; // Future time
            }
        }

        return response()->json([
            'dob' => $dob,
            'los' => $los,
            'scores' => $scores,
            'formatted_times' => $formatted_times
        ]);
    }

    public function getAdmissions($baby_id)
    {
        $baby_id = \SiteHelpers::decrypt_id($baby_id);
        $baby_admission = \App\Models\Admission::where('BabyId', $baby_id)->get()
            ->pluck('episodes', 'AdmissionId')->toArray();

        ksort($baby_admission);
        $formatted_admissions = [];
        foreach ($baby_admission as $id => $ep) {
            $formatted_admissions[] = [
                'id' => $id,
                'episodes' => $ep
            ];
        }
        return response()->json(['data' => $formatted_admissions], 200);
    }

    private function calculateScore($baby_id, $selected_date, $selected_hour)
    {
        $starting_time = $selected_date . ' ' . $selected_hour . ':00:00';
        $ending_time = $selected_date . ' ' . $selected_hour . ':59:59';

        $mode = $rr = $hr = $temp = $rbs = $os = null;

        $baby_basic_dtl = Baby::select('BirthWeight', 'g_weeks')->where('BabyId', $baby_id)->where('IsDeleted', '0')->first();

        $birth_wt = null;
        if (isset($baby_basic_dtl->BirthWeight)) {
            $birth_wt = $baby_basic_dtl->BirthWeight;
            $birth_wt = $birth_wt / 1000; // KG
            $birth_wt = number_format($birth_wt, 2);
        }
        $g_weeks = isset($baby_basic_dtl->g_weeks) ? $baby_basic_dtl->g_weeks : null;

        $cft = null;
        $neonatal_cft = Neonatal::select('NbCFT')->leftJoin('newborn_examination', 'neonatal_proforma.BabyId', 'newborn_examination.BabyId')->where('neonatal_proforma.BabyId', $baby_id)->where('TestDate', $selected_date)->where('IsDeleted', '0')->first();

        if ($neonatal_cft) {
            $cft = $neonatal_cft->NbCFT;
        }

        if (is_null($cft)) {
            $nicu_cft = Nicu::select('CFT')->whereNotNull('CFT')->where('CFT', '<>', '')->where('BabyId', $baby_id)->where('AdmissionDate', $selected_date)->where('IsDeleted', '0')->first();
            if (isset($nicu_cft['CFT'])) {
                $cft = $nicu_cft['CFT'];
            } else {
                $daycare_dtl = Daycare::select('CFT')->whereNotNull('CFT')->where('CFT', '<>', '')->where('BabyId', $baby_id)->where('DayDate', $selected_date)->where('IsDeleted', '0')->first();
                if (isset($daycare_dtl['CFT'])) {
                    $cft = $daycare_dtl['CFT'];
                }
            }
        }

        $respiratory_rate = 36;
        $manual_respiratory_rate = 312;
        $hr_rate = 35;
        $peripheral_temp = 34;
        $preductal_sao2 = 44;
        $blood_sugar = 76;
        $interface_blood_gas_blood_sugar = 309;
        $mode_of_ventilation = 47;
        $mode_of_ventilation_invasive = 225;

        // Fetch Ventilator Data
        $ventilator_data = $this->fetchEmrData($baby_id, $starting_time, $ending_time, [$respiratory_rate, $mode_of_ventilation, $mode_of_ventilation_invasive], 'emr_ventilator_values');

        if (isset($ventilator_data[$mode_of_ventilation])) {
            $mode = $ventilator_data[$mode_of_ventilation];
        }
        if (is_null($mode) && isset($ventilator_data[$mode_of_ventilation_invasive])) {
            $mode = $ventilator_data[$mode_of_ventilation_invasive];
        }

        // Fetch Monitor Data
        $monitor_data = $this->fetchEmrData($baby_id, $starting_time, $ending_time, [$respiratory_rate, $hr_rate, $peripheral_temp, $preductal_sao2], 'emr_moniter_values');

        $rr_vent = $ventilator_data[$respiratory_rate] ?? null;
        $rr_monitor = $monitor_data[$respiratory_rate] ?? null;
        $rr_manual = null;

        // Hierarchy: Ventilator > Monitor > Manual
        // Fallback if null OR 0
        if (!is_null($rr_vent) && $rr_vent > 0) {
            $rr = $rr_vent;
        } elseif (!is_null($rr_monitor) && $rr_monitor > 0) {
            $rr = $rr_monitor;
        } else {
            // Fetch the most recent manual RR with lookback using manual_respiratory_rate (312)
            $manual_rr_record = \DB::table('emr_nurse_manual_values')
                ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_nurse_manual_values.log_hdr_id')
                ->where('emr_log_hdr.baby_id', $baby_id)
                ->where('loinc_local_map_id', $manual_respiratory_rate)
                ->where('result_date_time', '<=', $ending_time)
                ->whereNotNull('intf_ref_value')
                ->where('intf_ref_value', '<>', '')
                ->where('intf_ref_value', '<>', '0') // Also skip 0 in manual
                ->orderBy('result_date_time', 'desc')
                ->first();

            if (!$manual_rr_record) {
                $manual_rr_record = \DB::table('emr_nurse_manual_values_discharged')
                    ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_nurse_manual_values_discharged.log_hdr_id')
                    ->where('emr_log_hdr.baby_id', $baby_id)
                    ->where('loinc_local_map_id', $manual_respiratory_rate)
                    ->where('result_date_time', '<=', $ending_time)
                    ->whereNotNull('intf_ref_value')
                    ->where('intf_ref_value', '<>', '')
                    ->where('intf_ref_value', '<>', '0') // Also skip 0 in manual
                    ->orderBy('result_date_time', 'desc')
                    ->first();
            }
            $rr = $manual_rr_record->intf_ref_value ?? null;
        }

        $hr = $monitor_data[$hr_rate] ?? null;
        $os = $monitor_data[$preductal_sao2] ?? null;

        if (isset($monitor_data[$peripheral_temp])) {
            $temp = $monitor_data[$peripheral_temp];
            $temp = 5 / 9 * ($temp - 32);
            $temp = number_format($temp, 2);
        }

        // Fetch Lab Data
        $lab_data = $this->fetchEmrData($baby_id, $starting_time, $ending_time, [$blood_sugar, $interface_blood_gas_blood_sugar], 'emr_lab_values', true);

        $rbs = $lab_data[$blood_sugar] ?? ($lab_data[$interface_blood_gas_blood_sugar] ?? null);

        // Calculate Score
        $total_score = 0;
        $breakdown = [];

        // RR Score
        $rr_score = 0;
        if (!is_null($rr)) {
            if ($rr > 60)
                $rr_score = 1;
            elseif ($rr >= 40 && $rr <= 60)
                $rr_score = 2;
            else
                $rr_score = 0;
            $breakdown['rr'] = ['value' => $rr, 'score' => $rr_score];
        } elseif (!is_null($mode)) {
            $rr_score = 0; // Apnoea/grunt or Assisted
            $breakdown['rr'] = ['value' => $mode, 'score' => 0];
        } else {
            $breakdown['rr'] = ['value' => 'N/A', 'score' => 0];
        }
        $total_score += $rr_score;

        // HR Score
        $hr_score = 0;
        if (!is_null($hr)) {
            if ($hr < 100)
                $hr_score = 0;
            elseif ($hr > 160)
                $hr_score = 1;
            elseif ($hr >= 100 && $hr <= 160)
                $hr_score = 2;
            $breakdown['hr'] = ['value' => $hr, 'score' => $hr_score];
        } else {
            $breakdown['hr'] = ['value' => 'N/A', 'score' => 0];
        }
        $total_score += $hr_score;

        // Temp Score
        $temp_score = 0;
        if (!is_null($temp)) {
            if ($temp < 36)
                $temp_score = 0;
            elseif ($temp >= 36 && $temp <= 36.4)
                $temp_score = 1;
            elseif ($temp >= 36.5 && $temp <= 37.5)
                $temp_score = 2;
            $breakdown['temp'] = ['value' => $temp, 'score' => $temp_score];
        } else {
            $breakdown['temp'] = ['value' => 'N/A', 'score' => 0];
        }
        $total_score += $temp_score;

        // CFT Score
        $cbt_score = 0;
        if (!is_null($cft)) {
            // Logic from JS: >5 Seconds -> 0, 3-5 Seconds -> 1, < 3 Seconds -> 2
            if ($cft == '>5 Seconds')
                $cbt_score = 0;
            elseif ($cft == '3-5 Seconds')
                $cbt_score = 1;
            elseif ($cft == '< 3 Seconds')
                $cbt_score = 2;
            $breakdown['cft'] = ['value' => $cft, 'score' => $cbt_score];
        } else {
            $breakdown['cft'] = ['value' => 'N/A', 'score' => 0];
        }
        $total_score += $cbt_score;

        // RBS Score
        $rbs_score = 0;
        if (!is_null($rbs)) {
            if ($rbs < 40)
                $rbs_score = 0;
            elseif ($rbs >= 40 && $rbs <= 60)
                $rbs_score = 1;
            elseif ($rbs > 60)
                $rbs_score = 2;
            $breakdown['rbs'] = ['value' => $rbs, 'score' => $rbs_score];
        } else {
            $breakdown['rbs'] = ['value' => 'N/A', 'score' => 0];
        }
        $total_score += $rbs_score;

        // OS Score
        $os_score = 0;
        if (!is_null($os)) {
            if ($os < 85)
                $os_score = 0;
            elseif ($os >= 85 && $os <= 92)
                $os_score = 1;
            elseif ($os > 92)
                $os_score = 2;
            $breakdown['os'] = ['value' => $os, 'score' => $os_score];
        } else {
            $breakdown['os'] = ['value' => 'N/A', 'score' => 0];
        }
        $total_score += $os_score;

        // GA Score
        $ga_score = 0;
        if (!is_null($g_weeks)) {
            if ($g_weeks < 32)
                $ga_score = 0;
            elseif ($g_weeks >= 32 && $g_weeks <= 36)
                $ga_score = 1;
            elseif ($g_weeks >= 37)
                $ga_score = 2; // Assuming >= 37 is 2 based on logic "32-36 is 1, <32 is 0"? JS said: <32 (0), 32-36 (1), >=37 (2).
            $breakdown['ga'] = ['value' => $g_weeks, 'score' => $ga_score];
        } else {
            $breakdown['ga'] = ['value' => 'N/A', 'score' => 0];
        }
        $total_score += $ga_score;

        // Birth Weight Score
        $bw_score = 0;
        if (!is_null($birth_wt)) {
            if ($birth_wt < 1.5)
                $bw_score = 0;
            elseif ($birth_wt >= 1.5 && $birth_wt <= 2.49)
                $bw_score = 1;
            elseif ($birth_wt >= 2.5)
                $bw_score = 2;
            $breakdown['bw'] = ['value' => $birth_wt, 'score' => $bw_score];
        } else {
            $breakdown['bw'] = ['value' => 'N/A', 'score' => 0];
        }
        $total_score += $bw_score;

        return ['total_score' => $total_score, 'breakdown' => $breakdown];
    }

    private function fetchEmrData($baby_id, $start, $end, $ids, $table, $isLab = false)
    {
        $inpatient = \DB::table('emr_log_hdr')
            ->select('loinc_local_map_id', 'intf_ref_value', 'result_date_time')
            ->leftJoin($table, 'emr_log_hdr.id', 'log_hdr_id')
            ->whereBetween('sender_time', [$start, $end])
            ->whereIn('loinc_local_map_id', $ids)
            ->where('baby_id', $baby_id)
            ->where('intf_ref_value', '<>', '')
            ->where('intf_ref_value', '<>', '0');

        if ($isLab) {
            $inpatient->where('result_status', 'final');
        }

        $data = $inpatient->orderBy('result_date_time', 'asc')->get()->toArray();

        $dischargeTable = $table . '_discharged';

        $discharged = \DB::table('emr_log_hdr')
            ->select('loinc_local_map_id', 'intf_ref_value', 'result_date_time')
            ->leftJoin($dischargeTable, 'emr_log_hdr.id', 'log_hdr_id')
            ->whereBetween('sender_time', [$start, $end])
            ->whereIn('loinc_local_map_id', $ids)
            ->where('baby_id', $baby_id)
            ->where('intf_ref_value', '<>', '')
            ->where('intf_ref_value', '<>', '0');

        if ($isLab) {
            $discharged->where('result_status', 'final');
        }

        $dischargedData = $discharged->orderBy('result_date_time', 'asc')->get()->toArray();

        $merged = array_merge($data, $dischargedData);
        return collect($merged)->pluck('intf_ref_value', 'loinc_local_map_id');
    }
}
