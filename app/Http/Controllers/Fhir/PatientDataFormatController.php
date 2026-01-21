<?php

namespace App\Http\Controllers\Fhir;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\DischargeLog;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Http\Controllers\NicuDashboardController;

class PatientDataFormatController extends Controller
{
    /**
     * controller constructor
     *
     */
    public function __construct()
    {
        $this->time_zone          = env('TIME_ZONE');
        $this->custom_error = new ErrorLogController();
    }

    /**
     * Backup table for emr_log_values
     *
     */
    public function update_discharged_log()
    {
        $this->custom_error->emergencyLog('Patient Backup data runs at : ' .Carbon::now($this->time_zone));
        $results = DischargeLog::getDischargeList()->toArray();

        if (count($results) > 0) {

            $moniter_backup_array = $ventilator_backup_array = $lab_backup_array = $prescription_hdr_array = $prescription_dtl_array = $prescription_backup_array = $prescription_calculation_backup_array = $moniter_ids = $ventilator_ids = $lab_ids = $prescription_hdr_ids = $prescription_dtl_ids = $prescription_ids = $prescription_calculation_ids =  $updated_discharge_ids = $prescription_timed_ids = $manual_backup_arrray = $manual_ids = $manual_results = array();

            foreach ($results as $key => $value) {
                $value = (object)$value;
                $baby_id = $value->baby_id;
                $admission_id = $value->admission_id;

                $header_ids = \DB::table('emr_log_hdr')->where('baby_id', $baby_id)->where('admission_id', $admission_id)->pluck('id')->toArray();
            
                $this->custom_error->emergencyLog('=========================Baby id : ' .$baby_id.' Admission id: '.$admission_id.'=========================');

                /*GET MONITER VALUES AND IDS TO INSERT BACKUP*/
                $moniter_values = \DB::table('emr_moniter_values')->whereIn('log_hdr_id', $header_ids)->get();
                $moniter_id = $moniter_values->pluck('id')->toArray();
                $moniter_values = $moniter_values->toArray();
                $moniter_values = array_map(function($moniter_items){
                    unset($moniter_items->id);
                    return $moniter_items;
                }, $moniter_values);

                $this->custom_error->emergencyLog('Monitor Data Total Count: '.count($moniter_values));

                /*GET VENTILATOR VALUES AND IDS TO INSERT BACKUP*/
                $ventilator_values = \DB::table('emr_ventilator_values')->whereIn('log_hdr_id', $header_ids)->get();
                $ventilator_id = $ventilator_values->pluck('id')->toArray();
                $ventilator_values = $ventilator_values->toArray();
                $ventilator_values = array_map(function($ventilator_items){
                    unset($ventilator_items->id);
                    return $ventilator_items;
                }, $ventilator_values);

                $this->custom_error->emergencyLog('Ventilator Data Total Count: '.count($ventilator_values));

                /*GET LAB VALUES AND IDS TO INSERT BACKUP*/
                $lab_values = \DB::table('emr_lab_values')->whereIn('log_hdr_id', $header_ids)->get();
                $lab_id = $lab_values->pluck('id')->toArray();
                $lab_values = $lab_values->toArray();
                $lab_values = array_map(function($lab_items){
                    unset($lab_items->id);
                    return $lab_items;
                }, $lab_values);

                $this->custom_error->emergencyLog('Lab Data Total Count: '.count($lab_values));


                /*GET NURSE MANUAL VALUES AND IDS TO INSERT BACKUP*/
                $manual_results = \DB::table('emr_nurse_manual_values')->whereIn('log_hdr_id', $header_ids)->get();
                $manual_id = $manual_results->pluck('id')->toArray();
                $manual_results = $manual_results->toArray();
                $manual_results = array_map(function($manual_items){
                    unset($manual_items->id);
                    return $manual_items;
                }, $manual_results);

                $this->custom_error->emergencyLog('Nurse Manual Data Total Count: '.count($manual_results));

                /*GET PRESCRIPTION VALUES AND IDS TO INSERT BACKUP*/
                $prescription_hdr_values = $prescription_hdr_id = array();
                $pres_hdr_ids = \DB::table('prescription_hdr')->where('baby_id', $baby_id)->where('admission_id', $admission_id)->pluck('id')->toArray();

                $prescription_dtl_values = $prescription_dtl_id = $prescription_timed_ids = array();

                if (count($pres_hdr_ids) > 0) {
                    $pres_hdr_ids = array_unique($pres_hdr_ids);
                    $prescription_dtl_values = \DB::table('prescription_dtl')->whereIn('pres_hdr_id', $pres_hdr_ids)->get();
                    $prescription_dtl_id = $prescription_dtl_values->pluck('id')->toArray();
                    $prescription_dtl_values = $prescription_dtl_values->toArray();

                    $prescription_dtl_values = array_map(function($prescription_dtl_items){
                        unset($prescription_dtl_items->id);
                        return $prescription_dtl_items;
                    }, $prescription_dtl_values);

                    $prescription_timed_ids = array_map(function($dtl_items){
                        return $dtl_items->prescription_id;
                    }, $prescription_dtl_values);
                }
                $this->custom_error->emergencyLog('Prescription Details Data Total Count: '.count($prescription_timed_ids));
                $prescription_values = $prescription_id = array();
                if (count($prescription_timed_ids) > 0) {
                    $prescription_timed_ids = array_unique($prescription_timed_ids);
                    $prescription_values = \DB::table('prescription')->whereIn('prescription_id', $prescription_timed_ids)->get();
                    $prescription_id = $prescription_values->pluck('id')->toArray();
                    $prescription_values = $prescription_values->toArray();

                    $prescription_values = array_map(function($prescription_items){
                        unset($prescription_items->id);
                        return $prescription_items;
                    }, $prescription_values);
                }
                $this->custom_error->emergencyLog('Prescription Data Total Count: '.count($prescription_values));

                $prescription_calculation_values = $prescription_calculation_id = array();
                if (count($prescription_timed_ids) > 0) {
                    $prescription_timed_ids = array_unique($prescription_timed_ids);
                    $prescription_calculation_values = \DB::table('prescription_infused_calculation')->whereIn('prescription_id', $prescription_timed_ids)->get();
                    $prescription_calculation_id = $prescription_calculation_values->pluck('id')->toArray();
                    $prescription_calculation_values = $prescription_calculation_values->toArray();

                    $prescription_calculation_values = array_map(function($prescription_items){
                        unset($prescription_items->id);
                        return $prescription_items;
                    }, $prescription_calculation_values);
                }
                $this->custom_error->emergencyLog('Prescription infused calculation Data Total Count: '.count($prescription_calculation_values));

                $moniter_backup_array = array_merge($moniter_backup_array, $moniter_values);
                $moniter_ids = array_merge($moniter_ids, $moniter_id);

                $ventilator_backup_array = array_merge($ventilator_backup_array, $ventilator_values);
                $ventilator_ids = array_merge($ventilator_ids, $ventilator_id);                

                $lab_backup_array = array_merge($lab_backup_array, $lab_values);
                $lab_ids = array_merge($lab_ids, $lab_id);

                $manual_backup_arrray = array_merge($manual_backup_arrray, $manual_results);
                $manual_ids = array_merge($manual_ids, $manual_id);

                $prescription_dtl_array = array_merge($prescription_dtl_array, $prescription_dtl_values);
                $prescription_dtl_ids = array_merge($prescription_dtl_ids, $prescription_dtl_id);

                $prescription_backup_array = array_merge($prescription_backup_array, $prescription_values);
                $prescription_ids = array_merge($prescription_ids, $prescription_id);

                $prescription_calculation_backup_array = array_merge($prescription_calculation_backup_array, $prescription_calculation_values);
                $prescription_calculation_ids = array_merge($prescription_calculation_ids, $prescription_calculation_id);

                array_push($updated_discharge_ids, $admission_id);
            }

            if (count($moniter_backup_array) > 0) {
                try {
                    $moniter_res = $this->backupData($moniter_backup_array, 'emr_moniter_values_discharged');
                    if ($moniter_res === true) {
                        if (count($moniter_ids) > 65000) {
                            $start = 0;
                            while ($start < count($moniter_ids)) {
                                $deleted_array = array_slice($moniter_ids, $start, 65000);
                                \DB::table('emr_moniter_values')->whereIn('id', $deleted_array)->delete();
                                $start += 65000;
                            }

                        } else {
                            \DB::table('emr_moniter_values')->whereIn('id', $moniter_ids)->delete();
                        }
                    }
                    $this->custom_error->emergencyLog('Moniter Backup success');
                } catch (\Exception $e) {
                    $this->custom_error->emergencyLog('Moniter Backup Failed: '.json_encode($moniter_ids).' Error: '.$e);
                }
            }

            if (count($ventilator_backup_array) > 0) {
                try {
                    $ven_res = $this->backupData($ventilator_backup_array, 'emr_ventilator_values_discharged');
                    if ($ven_res === true) {
                        if (count($ventilator_ids) > 65000) {
                            $start = 0;
                            while ($start < count($ventilator_ids)) {
                                $deleted_array = array_slice($ventilator_ids, $start, 65000);
                                \DB::table('emr_ventilator_values')->whereIn('id', $deleted_array)->delete();
                                $start += 65000;
                            }

                        } else {
                            \DB::table('emr_ventilator_values')->whereIn('id', $ventilator_ids)->delete();
                        }
                    }
                    $this->custom_error->emergencyLog('Ventilator Backup success');
                } catch (\Exception $e) {
                    $this->custom_error->emergencyLog('Ventilator Backup Failed: '.json_encode($ventilator_ids).' Error: '.$e);
                }
            }

            if (count($lab_backup_array) > 0) {
                try {
                    $lab_res = $this->backupData($lab_backup_array, 'emr_lab_values_discharged');
                    if ($lab_res === true) {
                        if (count($lab_ids) > 65000) {
                            $start = 0;
                            while ($start < count($lab_ids)) {
                                $deleted_array = array_slice($lab_ids, $start, 65000);
                                \DB::table('emr_lab_values')->whereIn('id', $deleted_array)->delete();
                                $start += 65000;
                            }

                        } else {
                            \DB::table('emr_lab_values')->whereIn('id', $lab_ids)->delete();
                        }
                    }
                    $this->custom_error->emergencyLog('Lab Backup success');
                } catch (\Exception $e) {
                    $this->custom_error->emergencyLog('Lab Backup Failed: '.json_encode($lab_ids).' Error: '.$e);
                }
            }

            if (count($manual_backup_arrray) > 0) {
                try {
                    $manual_res = $this->backupData($manual_backup_arrray, 'emr_nurse_manual_values_discharged');
                    if ($manual_res === true) {
                        if (count($manual_ids) > 65000) {
                            $start = 0;
                            while ($start < count($manual_ids)) {
                                $deleted_array = array_slice($manual_ids, $start, 65000);
                                \DB::table('emr_nurse_manual_values')->whereIn('id', $deleted_array)->delete();
                                $start += 65000;
                            }

                        } else {
                            \DB::table('emr_nurse_manual_values')->whereIn('id', $manual_ids)->delete();
                        }
                    }
                    $this->custom_error->emergencyLog('Nurse Manual Backup success');
                } catch (\Exception $e) {
                    $this->custom_error->emergencyLog('Nurse Manual Backup Failed: '.json_encode($manual_ids).' Error: '.$e);
                }
            }

            if (count($prescription_dtl_array) > 0) {
                try {
                    $prescription_dtl_res = $this->backupData($prescription_dtl_array, 'prescription_dtl_discharged');
                    if ($prescription_dtl_res === true) {
                        if (count($prescription_dtl_ids) > 65000) {
                            $start = 0;
                            while ($start < count($prescription_dtl_ids)) {
                                $deleted_array = array_slice($prescription_dtl_ids, $start, 65000);
                                \DB::table('prescription_dtl')->whereIn('id', $deleted_array)->delete();
                                $start += 65000;
                            }

                        } else {
                            \DB::table('prescription_dtl')->whereIn('id', $prescription_dtl_ids)->delete();
                        }
                    }
                    $this->custom_error->emergencyLog('Prescription Detail Backup success');
                } catch (\Exception $e) {
                    $this->custom_error->emergencyLog('Prescription Detail Backup Failed: '.json_encode($prescription_dtl_ids).' Error: '.$e);
                }
            }

            if (count($prescription_backup_array) > 0) {
                try {
                    $pres_res = $this->backupData($prescription_backup_array, 'prescription_discharged');
                    if ($pres_res === true) {
                        if (count($prescription_ids) > 65000) {
                            $start = 0;
                            while ($start < count($prescription_ids)) {
                                $deleted_array = array_slice($prescription_ids, $start, 65000);
                                \DB::table('prescription')->whereIn('id', $deleted_array)->delete();
                                $start += 65000;
                            }

                        } else {
                            \DB::table('prescription')->whereIn('id', $prescription_ids)->delete();
                        }
                    }
                    $this->custom_error->emergencyLog('Prescription Backup success');
                } catch (\Exception $e) {
                    $this->custom_error->emergencyLog('Prescription Backup Failed: '.json_encode($prescription_ids).' Error: '.$e);
                }
            }

            if (count($prescription_calculation_backup_array) > 0) {
                try {
                    $cal_res = $this->backupData($prescription_calculation_backup_array, 'prescription_infused_calculation_discharged');
                    if ($cal_res === true) {
                        if (count($prescription_calculation_ids) > 65000) {
                            $start = 0;
                            while ($start < count($prescription_calculation_ids)) {
                                $deleted_array = array_slice($prescription_calculation_ids, $start, 65000);
                                \DB::table('prescription_infused_calculation')->whereIn('id', $deleted_array)->delete();
                                $start += 65000;
                            }

                        } else {
                            \DB::table('prescription_infused_calculation')->whereIn('id', $prescription_calculation_ids)->delete();
                        }
                    }
                    $this->custom_error->emergencyLog('Prescription calculation Backup success');
                } catch (\Exception $e) {
                    $this->custom_error->emergencyLog('Prescription calculation Backup Failed: '.json_encode($prescription_calculation_ids).' Error: '.$e);
                }
            }

            if (count($updated_discharge_ids) != 0) {
                $this->custom_error->emergencyLog('=========================Backup Admission Ids========================='.json_encode($updated_discharge_ids));
                $updated_log = DischargeLog::updateDischargeList($updated_discharge_ids);
            }

        }

    }


    /**
     * Split backup record to insert table
     *
     * @param  $data type array
     * @param  $table_name type string
     * return true
     */
    public function backupData($data = array(), $table_name)
    {
        $initialCount = count((array) $data[0]);
        $insertCount = round(65000 / $initialCount);
        $totalCount = count($data);
        if ($totalCount < $insertCount) {
            $this->insertRecord($data, $table_name);
            return true;
        }
        else
        {
            $completedCount = 0;
            while ($completedCount <= $totalCount) {
                $insertArray = array_slice($data, $completedCount, $insertCount);
                $this->insertRecord($insertArray, $table_name);
                $completedCount += $insertCount;
            }
            return true;
        }
    }

    /**
     * Insert backup record into table
     *
     * @param  $insertArray type array
     * @param  $table_name type string
     * return true
     */
    public function insertRecord($insertArray = array(), $table_name)
    {
        if (count($insertArray) > 0) {
            $insertArray = \SiteHelpers::convert_obj_to_array($insertArray);
            $res = \DB::table($table_name)->insert($insertArray);
            return true;

        }
    }

    /**
     * Update NICU dashboard json
     *
     */
    public function update_nicu_dashboard() {
        $bed_details = \DB::table('nicu_dashboard_results')->update(['need_data'=>true]);
        NicuDashboardController::updateDashboardData();
    }

    public function record_tracker() {
        $log = \DB::table('discharged_log')
        ->select('admission_id')
        ->where('is_backuped', false)
        ->get()->unique()
        ->pluck('admission_id')
        ->toArray();

        foreach ($log as $key => $value) {
            $hdr = \DB::table('emr_log_hdr')
            ->select('sender_time')
            ->where('admission_id', $value)
            ->orderBy('sender_time', 'desc')
            ->first();

            if (isset($hdr->sender_time)) {
                \DB::table('discharged_log')->where('admission_id', $value)->update(['discharged_at' => $hdr->sender_time]);
            }
        }

    }

}
