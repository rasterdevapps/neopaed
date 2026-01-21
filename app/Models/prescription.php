<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class prescription extends Model
{
    protected $table = 'prescription';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['id', 'prescription_id', 'result_time','infused', 'infused_snomed_code', 'rate', 'rate_snomed_code', 'remain_volume', 'remain_volume_snomed_code', 'remain_time', 'remain_time_snomed_code', 'pressure', 'pressure_snomed_code', 'pressure_level', 'pressure_level_snomed_code', 'status', 'status_snomed_code', 'created_date_time', 'created_user', 'is_approved', 'approved_by', 'approved_date_time', 'edited_by', 'edited_date_time', 'edited_reason', 'original_infused'];

    /**
     * This Method To Get Prescribed Drug Information
     *
     * @param $id type integer 
     * 
     * @return array of object 
     */
    public static function getPrescription($id) {
        $results = \DB::table('prescription')
                        ->select('*')
                        ->where('prescription_id', $id)
                        ->orderBy('result_time', 'desc')
                        ->get();
        return $results;

    }

    /**
     * This method to get starting time of the drug
     *
     * @param $drug_type is slug
     *
     * @param $result is integer
     *
     * @return array of object
     */
    public static function pumpInfusingTime($drug_type, $result) {
        return \DB::table('prescription')
                    ->where('prescription_id', $drug_type.$result)
                    ->where('status', 0)
                    ->orderBy('result_time','asc')
                    ->first();
    }

    /**
     * This method to get stopped time of the drug
     *
     * @param $drug_type is slug
     *
     * @param $result is integer
     *
     * @return array of object
     */
    public static function pumpStopTime($drug_type, $result) {
        return \DB::table('prescription')
                    ->where('prescription_id', $drug_type.$result)
                    ->where('status', 3)
                    ->orderBy('result_time','asc')
                    ->first();
    }

    /**
     * This method to get currently running of the drug
     *
     * @param $drug_type is slug
     *
     * @param $result is integer
     *
     * @return $date is string
     */
    public static function pumpInfusingNow($drug_type, $result, $date) {
        return \DB::table('prescription')
                    ->where('prescription_id', $drug_type.$result)
                    ->whereRaw("CAST(result_time as text) like '%".$date."%'")
                    ->orderBy('result_time', 'desc')
                    ->first();
    }
    
    public static function getInterfacingData($baby_id, $admission_id, $start_time, $end_time) {
        $prescription_result = \DB::table('prescription')
                            ->select('prescription.infused', 'prescription.prescription_id', 'result_time')
                            ->join('prescription_dtl', 'prescription_dtl.prescription_id', '=', 'prescription.prescription_id')
                            ->join('prescription_hdr', 'prescription_hdr.id', '=', 'prescription_dtl.pres_hdr_id')
                            ->where('baby_id', $baby_id)
                            ->where('admission_id', $admission_id);
        if ($start_time != '' && $end_time != '') {
            $prescription_result =  $prescription_result->whereBetween('result_time', [$start_time, $end_time]);
        }
        $prescription_result = $prescription_result->orderBy('result_time', 'desc')
                            ->get();

        return $prescription_result;

    }

    public static function getPumpData($input, $prescription_hdr, $prescription_dtl = 'prescription_dtl', $prescription_table = 'prescription_infused_calculation', $start_time, $end_time) {
        $prescribed_drug_list = \DB::table($prescription_hdr)
            ->select('mas_drugivfluid.brand_name', $prescription_hdr.'.brand_name as drug_id', $prescription_table.'.calculated_hour as result_time', $prescription_table.'.hour_infused as infused', 
                $prescription_table.'.hour_rate as rate', $prescription_table.'.id as pres_pump_id', $prescription_dtl.'.prescription_id', 'original_hour_infused as original_infused', $prescription_dtl.'.started_date', 'is_approved', 'edited_by', 'edited_reason', \DB::raw("TO_CHAR(calculated_hour,'DD:HH24:00') as temp_result_date_time"), \DB::raw("TO_CHAR(calculated_hour,'YYYY-MM-DD') as resulted_hour"), \DB::raw("TO_CHAR(calculated_hour,'YYYY-MM-DD_HH24') as resulted_hour1"), $prescription_dtl.'.id')
            ->selectRaw('mas_drugivfluid.brand_name|| \' / \' ||mas_drugivfluid.generic_pharmacological_name as drug_name')
            // ->selectRaw($prescription_hdr.'.brand_name|| \':\' ||'.$prescription_table.'.prescription_id|| \':\' ||mas_drugivfluid.brand_name|| \' / \' ||mas_drugivfluid.generic_pharmacological_name as drugname')
            ->selectRaw($prescription_dtl.'.id|| \':\' ||mas_drugivfluid.brand_name|| \' / \' ||mas_drugivfluid.generic_pharmacological_name as drug_name')
            ->selectRaw('TO_CHAR(calculated_hour,\'YYYYMMDDHH2400\') as timetostr')
            ->addSelect('is_approved as approval_status', $prescription_table.'.hour_rate as drug_rate', $prescription_table.'.hour_infused as drug_total')
            ->leftjoin($prescription_dtl, $prescription_dtl.".pres_hdr_id", $prescription_hdr.'.id')
            ->leftjoin('baby_admission', 'baby_admission.BabyId', $prescription_hdr.'.baby_id')
            ->leftjoin('mas_drugivfluid', 'mas_drugivfluid.id', $prescription_hdr.'.brand_name')
            ->leftjoin($prescription_table, function ($join) use ($prescription_dtl, $prescription_table, $start_time, $end_time) {
                $join->orOn($prescription_dtl.'.prescription_id', '=', $prescription_table.'.prescription_id');
            })
            ->where('baby_admission.BabyId', $input['baby_id'])
            ->where('baby_admission.AdmissionId', $input['admission_id'])
            // ->where('is_cancel', false)
            // ->where('is_send', '<>', 3)
            // ->where('is_send', '<>', 99)
            ->where('order_status', '<>', 'RS')
            ->where('order_status', '<>', 'EP')
            // ->where('is_approved', null)
            ->where(function($query) use ($prescription_dtl, $start_time, $end_time) {
                $query->where($prescription_dtl.'.started_date', '>=', $start_time)
                ->orWhere($prescription_dtl.'.started_date', '<', $end_time);
            })
            ->where($prescription_table.'.calculated_hour', '>=', $start_time)
            ->where($prescription_table.'.calculated_hour', '<', $end_time)
            // ->orderBy($prescription_table.'.calculated_hour', 'asc')
            ->orderBy($prescription_dtl.'.id', 'asc')
            ->get();
        return $prescribed_drug_list;
    }

}
