<?php
namespace App\Models\Fhir;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Fhir\ImportFhirController;
use App\Events\NurseSheetUpdateEvent;

use App\Models\Fhir\FhirFormatedValues;
use App\Http\Controllers\Errors\ErrorLogController;
use Illuminate\Contracts\Auth\Guard;

class FhirFormatedValues extends Model
{
    protected $table = 'fihr_formated_values';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'gender', 'birthdate', 'mrn', 'visit_type', 'date', 'ip_number', 'ward', 'room', 'bed', 'model', 'owner', 'patient', 'manufacturer', 'loinc_code', 'display', 'issued', 'status', 'low', 'first_quartile', 'mean', 'last_quartile', 'close', 'value_quality_unit', 'is_completed', 'asset_number', 'start_time', 'end_time', 'from_id', 'to_id', 'snomed_ct', 'snomed_code', 'advice_id', 'lab_number', 'lab_sample_number', 'range_low', 'range_high', 'is_calculated'];

    // public static function boot() {
    //     parent::boot();
    //     static::created(function() {
    //       $fhir_format_values = new FhirFormatedValues();
    //       $custom_error       = new ErrorLogController();
    //          $import_fhir = new ImportFhirController($fhir_format_values,$custom_error);
    //       event(new NurseSheetUpdateEvent($import_fhir));
    //     });
    // }
    

    public static function monitor_get_list($page = 1, $limit = 50, $order = array() , $search)
    {

        $limitstart = (empty($page) || $page == 1) ? 0 : (($page - 1) * $limit);
        $limitend = $limit;
        $checkdate = '';

        $moniter_values = \DB::table('baby')->select('emr_moniter_values.*', 'emr_moniter_values.id as moniter_id', 'emr_log_hdr.admission_id', 'emr_log_hdr.baby_id', 'baby.BabyName as name', 'baby.DOB', 'baby.BMrNo as mrn', 'ip_numbers.ip_number', 'emr_moniter_values.device_model as model', 'emr_moniter_values.result_date_time as issued', 'local_code_group.*')
            ->addSelect(\DB::raw("'inpatient' as status"))
            ->join('emr_log_hdr', 'baby.BabyId', 'emr_log_hdr.baby_id')
            ->join('emr_moniter_values', 'emr_log_hdr.id', '=', 'emr_moniter_values.log_hdr_id')
            ->join('ip_numbers', 'ip_numbers.AdmissionId', '=', 'emr_log_hdr.admission_id')
            ->join('local_code_group', 'emr_moniter_values.loinc_local_map_id', '=', 'local_code_group.id')
            ->where('emr_moniter_values.create_user_id', 2)
            ->where('baby.BMrNo', $search['mrno'])->where(function ($query) use ($search)
        {
            if (!empty($search) && is_array($search))
            {
                if (!empty($search['ipnumber']))
                {
                    $query->whereRaw('"ip_numbers"."ip_number" ilike ' . "'%" . strtolower(trim($search['ipnumber'])) . "%'");
                }
                if (!empty($search['devicename']) && $search['devicename'] != 'N/A')
                {
                    $query->whereRaw('"emr_moniter_values"."device_model" ilike ' . "'%" . strtolower(trim($search['devicename'])) . "%'");
                }
                if (!empty($search['receivetime']))
                {
                    $query->whereRaw("emr_moniter_values.result_date_time::text ilike '%" . date('Y-m-d H', strtotime(rtrim($search['receivetime']))) . "%'");
                }
                if (!empty($search['low']))
                {
                    $query->whereRaw('emr_moniter_values.low ilike ' . "'%" . trim($search['low']) . "%'");
                }
                if (!empty($search['firstquartile']))
                {
                    $query->whereRaw('emr_moniter_values.first_quartile ilike ' . "'%" . trim($search['firstquartile']) . "%'");
                }
                if (!empty($search['mean']))
                {
                    $query->whereRaw('emr_moniter_values.mean ilike ' . "'%" . trim($search['mean']) . "%'");
                }
                if (!empty($search['lastquartile']))
                {
                    $query->whereRaw('emr_moniter_values.last_quartile ilike ' . "'%" . trim($search['lastquartile']) . "%'");
                }
                if (!empty($search['close']))
                {
                    $query->whereRaw('emr_moniter_values.close ilike ' . "'%" . trim($search['close']) . "%'");
                }
            }
        });

        $moniter_values_discharged = \DB::table('baby')->select('emr_moniter_values_discharged.*', 'emr_moniter_values_discharged.id as moniter_id', 'emr_log_hdr.admission_id', 'emr_log_hdr.baby_id', 'baby.BabyName as name', 'baby.DOB', 'baby.BMrNo as mrn', 'ip_numbers.ip_number', 'emr_moniter_values_discharged.device_model as model', 'emr_moniter_values_discharged.result_date_time as issued', 'local_code_group.*')
            ->addSelect(\DB::raw("'discharged' as status"))
            ->join('emr_log_hdr', 'baby.BabyId', 'emr_log_hdr.baby_id')
            ->join('emr_moniter_values_discharged', 'emr_log_hdr.id', '=', 'emr_moniter_values_discharged.log_hdr_id')
            ->join('ip_numbers', 'ip_numbers.AdmissionId', '=', 'emr_log_hdr.admission_id')
            ->join('local_code_group', 'emr_moniter_values_discharged.loinc_local_map_id', '=', 'local_code_group.id')
            ->where('emr_moniter_values_discharged.create_user_id', 2)
            ->where('baby.BMrNo', $search['mrno'])->where(function ($query) use ($search)
        {
            if (!empty($search) && is_array($search))
            {
                if (!empty($search['ipnumber']))
                {
                    $query->whereRaw('"ip_numbers"."ip_number" ilike ' . "'%" . strtolower(trim($search['ipnumber'])) . "%'");
                }
                if (!empty($search['devicename']) && $search['devicename'] != 'N/A')
                {
                    $query->whereRaw('"emr_moniter_values_discharged"."device_model" ilike ' . "'%" . strtolower(trim($search['devicename'])) . "%'");
                }
                if (!empty($search['receivetime']))
                {
                    $query->whereRaw("emr_moniter_values_discharged.result_date_time::text ilike '%" . date('Y-m-d H', strtotime(rtrim($search['receivetime']))) . "%'");
                }
                if (!empty($search['low']))
                {
                    $query->whereRaw('emr_moniter_values_discharged.low ilike ' . "'%" . trim($search['low']) . "%'");
                }
                if (!empty($search['firstquartile']))
                {
                    $query->whereRaw('emr_moniter_values_discharged.first_quartile ilike ' . "'%" . trim($search['firstquartile']) . "%'");
                }
                if (!empty($search['mean']))
                {
                    $query->whereRaw('emr_moniter_values_discharged.mean ilike ' . "'%" . trim($search['mean']) . "%'");
                }
                if (!empty($search['lastquartile']))
                {
                    $query->whereRaw('emr_moniter_values_discharged.last_quartile ilike ' . "'%" . trim($search['lastquartile']) . "%'");
                }
                if (!empty($search['close']))
                {
                    $query->whereRaw('emr_moniter_values_discharged.close ilike ' . "'%" . trim($search['close']) . "%'");
                }
            }
        });

        $moniter_results = $moniter_values_discharged->union($moniter_values);
        if (isset($order['sortby']) && isset($order['sortorder']))
        {
            $moniter_results->orderBy($order['sortby'], $order['sortorder']);
        }

        $result['total'] = $moniter_results->get()
            ->count();
        $result['result'] = $moniter_results->limit($limitend)->offset($limitstart)->get();

        return $result;

    }

    public static function ventilator_get_list($page = 1, $limit = 50, $order = array() , $search)
    {

        $limitstart = (empty($page) || $page == 1) ? 0 : (($page - 1) * $limit);
        $limitend = $limit;

        $ventilator_values = \DB::table('baby')->select('emr_ventilator_values.*', 'emr_ventilator_values.id as ventilator_id', 'emr_log_hdr.admission_id', 'emr_log_hdr.baby_id', 'baby.BabyName as name', 'baby.DOB as birthdate', 'baby.BMrNo as mrn', 'ip_numbers.ip_number', 'emr_ventilator_values.device_model as model', 'emr_ventilator_values.create_tstamp as issued', 'local_code_group.*')
            ->addSelect(\DB::raw("'inpatient' as status"))
            ->join('emr_log_hdr', 'baby.BabyId', 'emr_log_hdr.baby_id')
            ->join('emr_ventilator_values', 'emr_log_hdr.id', '=', 'emr_ventilator_values.log_hdr_id')
            ->join('ip_numbers', 'ip_numbers.AdmissionId', '=', 'emr_log_hdr.admission_id')
            ->join('local_code_group', 'emr_ventilator_values.loinc_local_map_id', '=', 'local_code_group.id')
            ->where('emr_ventilator_values.create_user_id', 3)
            ->where('baby.BMrNo', $search['mrno'])->where(function ($query) use ($search)
        {
            if (!empty($search) && is_array($search))
            {
                if (!empty($search['ipnumber']))
                {
                    $query->whereRaw('"ip_numbers"."ip_number" ilike ' . "'%" . strtolower(trim($search['ipnumber'])) . "%'");
                }
                if (!empty($search['devicename']) && $search['devicename'] != 'N/A')
                {
                    $query->whereRaw('"emr_ventilator_values"."device_model" ilike ' . "'%" . strtolower(trim($search['devicename'])) . "%'");
                }
                if (!empty($search['receivetime']))
                {
                    $query->whereRaw("emr_ventilator_values.result_date_time::text ilike '%" . date('Y-m-d H', strtotime(rtrim($search['receivetime']))) . "%'");
                }
                if (!empty($search['low']))
                {
                    $query->whereRaw('emr_ventilator_values.low ilike ' . "'%" . trim($search['low']) . "%'");
                }
                if (!empty($search['firstquartile']))
                {
                    $query->whereRaw('emr_ventilator_values.first_quartile ilike ' . "'%" . trim($search['firstquartile']) . "%'");
                }
                if (!empty($search['mean']))
                {
                    $query->whereRaw('emr_ventilator_values.mean ilike ' . "'%" . trim($search['mean']) . "%'");
                }
                if (!empty($search['lastquartile']))
                {
                    $query->whereRaw('emr_ventilator_values.last_quartile ilike ' . "'%" . trim($search['lastquartile']) . "%'");
                }
                if (!empty($search['close']))
                {
                    $query->whereRaw('emr_ventilator_values.close ilike ' . "'%" . trim($search['close']) . "%'");
                }
            }
        });

        $ventilator_values_discharged = \DB::table('baby')->select('emr_ventilator_values_discharged.*', 'emr_ventilator_values_discharged.id as ventilator_id', 'emr_log_hdr.admission_id', 'emr_log_hdr.baby_id', 'baby.BabyName as name', 'baby.DOB as birthdate', 'baby.BMrNo as mrn', 'ip_numbers.ip_number', 'emr_ventilator_values_discharged.device_model as model', 'emr_ventilator_values_discharged.create_tstamp as issued', 'local_code_group.*')
            ->addSelect(\DB::raw("'discharged' as status"))
            ->join('emr_log_hdr', 'baby.BabyId', 'emr_log_hdr.baby_id')
            ->join('emr_ventilator_values_discharged', 'emr_log_hdr.id', '=', 'emr_ventilator_values_discharged.log_hdr_id')
            ->join('ip_numbers', 'ip_numbers.AdmissionId', '=', 'emr_log_hdr.admission_id')
            ->join('local_code_group', 'emr_ventilator_values_discharged.loinc_local_map_id', '=', 'local_code_group.id')
            ->where('emr_ventilator_values_discharged.create_user_id', 3)
            ->where('baby.BMrNo', $search['mrno'])->where(function ($query) use ($search)
        {
            if (!empty($search) && is_array($search))
            {
                if (!empty($search['ipnumber']))
                {
                    $query->whereRaw('"ip_numbers"."ip_number" ilike ' . "'%" . strtolower(trim($search['ipnumber'])) . "%'");
                }
                if (!empty($search['devicename']) && $search['devicename'] != 'N/A')
                {
                    $query->whereRaw('"emr_ventilator_values_discharged"."device_model" ilike ' . "'%" . strtolower(trim($search['devicename'])) . "%'");
                }
                if (!empty($search['receivetime']))
                {
                    $query->whereRaw("emr_ventilator_values_discharged.result_date_time::text ilike '%" . date('Y-m-d H', strtotime(rtrim($search['receivetime']))) . "%'");
                }
                if (!empty($search['low']))
                {
                    $query->whereRaw('emr_ventilator_values_discharged.low ilike ' . "'%" . trim($search['low']) . "%'");
                }
                if (!empty($search['firstquartile']))
                {
                    $query->whereRaw('emr_ventilator_values_discharged.first_quartile ilike ' . "'%" . trim($search['firstquartile']) . "%'");
                }
                if (!empty($search['mean']))
                {
                    $query->whereRaw('emr_ventilator_values_discharged.mean ilike ' . "'%" . trim($search['mean']) . "%'");
                }
                if (!empty($search['lastquartile']))
                {
                    $query->whereRaw('emr_ventilator_values_discharged.last_quartile ilike ' . "'%" . trim($search['lastquartile']) . "%'");
                }
                if (!empty($search['close']))
                {
                    $query->whereRaw('emr_ventilator_values_discharged.close ilike ' . "'%" . trim($search['close']) . "%'");
                }
            }
        });

        $ventilator_results = $ventilator_values_discharged->union($ventilator_values);
        if (isset($order['sortby']) && isset($order['sortorder']))
        {
            $ventilator_results->orderBy($order['sortby'], $order['sortorder']);
        }

        $result['total'] = $ventilator_results->get()
            ->count();
        $result['result'] = $ventilator_results->limit($limitend)->offset($limitstart)->get();

        return $result;

    }

    public static function pump_get_list($page = 1, $limit = 50, $order = array() , $search)
    {

        $limitstart = (empty($page) || $page == 1) ? 0 : (($page - 1) * $limit);
        $limitend = $limit;

        $results1 = \DB::table('baby')->select('prescription.*', 'prescription.id as prescription_table_id', 'prescription.rate as prescription_rate', 'prescription_dtl.prescription_id', 'prescription_hdr.baby_id', 'prescription_hdr.admission_id', 'mas_drugivfluid.*', 'mas_drugivfluid.brand_name as brandname', 'baby.*', 'ip_numbers.*')
            ->addSelect(\DB::raw("'inpatient' as status"))
            ->join('prescription_hdr', 'baby.BabyId', 'prescription_hdr.baby_id')
            ->join('prescription_dtl', 'prescription_hdr.id', 'prescription_dtl.pres_hdr_id')
            ->join('prescription', 'prescription_dtl.prescription_id', 'prescription.prescription_id')
            ->join('mas_drugivfluid', 'mas_drugivfluid.id', 'prescription_hdr.brand_name')
            ->where('baby.BMrNo', $search['mrno'])->join('ip_numbers', function ($join)
        {
            $join->on('prescription_hdr.baby_id', '=', 'ip_numbers.baby_id')
                ->on('prescription_hdr.admission_id', '=', 'ip_numbers.AdmissionId');
        })->where(function ($query) use ($search)
        {
            if (!empty($search) && is_array($search))
            {
                if (!empty($search['ipnumber']))
                {
                    $query->whereRaw('"ip_numbers"."ip_number" ilike ' . "'%" . strtolower(trim($search['ipnumber'])) . "%'");
                }
                if (!empty($search['receivetime']))
                {
                    $query->whereRaw("prescription.result_time::text ilike '%" . date('Y-m-d H', strtotime(rtrim($search['receivetime']))) . "%'");
                }
            }
        });

        $results2 = \DB::table('baby')->select('prescription_discharged.*', 'prescription_discharged.id as prescription_table_id', 'prescription_discharged.rate as prescription_rate', 'prescription_dtl_discharged.prescription_id', 'prescription_hdr.baby_id', 'prescription_hdr.admission_id', 'mas_drugivfluid.*', 'mas_drugivfluid.brand_name as brandname', 'baby.*', 'ip_numbers.*')
            ->addSelect(\DB::raw("'discharged' as status"))
            ->join('prescription_hdr', 'baby.BabyId', 'prescription_hdr.baby_id')
            ->join('prescription_dtl_discharged', 'prescription_hdr.id', 'prescription_dtl_discharged.pres_hdr_id')
            ->join('prescription_discharged', 'prescription_dtl_discharged.prescription_id', 'prescription_discharged.prescription_id')
            ->join('mas_drugivfluid', 'mas_drugivfluid.id', 'prescription_hdr.brand_name')
            ->where('baby.BMrNo', $search['mrno'])->join('ip_numbers', function ($join)
        {
            $join->on('prescription_hdr.baby_id', '=', 'ip_numbers.baby_id')
                ->on('prescription_hdr.admission_id', '=', 'ip_numbers.AdmissionId');
        })->where(function ($query) use ($search)
        {
            if (!empty($search) && is_array($search))
            {
                if (!empty($search['ipnumber']))
                {
                    $query->whereRaw('"ip_numbers"."ip_number" ilike ' . "'%" . strtolower(trim($search['ipnumber'])) . "%'");
                }
                if (!empty($search['receivetime']))
                {
                    $query->whereRaw("prescription_discharged.result_time::text ilike '%" . date('Y-m-d H', strtotime(rtrim($search['receivetime']))) . "%'");
                }
            }
        });

        $results = $results2->union($results1);

        if (isset($order['sortby']) && isset($order['sortorder']))
        {
            $results->orderBy($order['sortby'], $order['sortorder']);
        }

        $result['total'] = $results->get()
            ->count();
        $result['result'] = $results->limit($limitend)->offset($limitstart)->get();

        return $result;
    }

    /**
     * This method to get the detail of the prescribed drug
     */
    public static function getPrescriptionLogValues($id, $bmrno, $snomed_code)
    {

      $resource = \DB::table('fihr_formated_values')->addSelect('end_time', 'mean')
      ->where('advice_id', $id)->where('mrn', $bmrno)->where('snomed_ct', 'ilike', '%' . $snomed_code . '%')->orderby('id', 'desc')
      ->get();
      return $resource;
    }

    /**
     * Get drug name from mean value
     *
     * @param $drug_code string
     *
     * @return array
     */
    public static function getDrugs($drug_code)
    {
      return \DB::table('fihr_formated_values')->select('mean')
      ->where('snomed_ct', $drug_code)->orderby('id', 'desc')
      ->first();
    }

    /**
     * Get the working weight
     *
     *  @param $prescribedtable string
     *
     *  @param $baby_id integer
     *
     *  @param $admission_id integer
     *
     *  @return array
     */
    public static function getPrescriptionWorkingWeight($prescribedtable, $baby_id, $admission_id)
    {
      return \DB::table($prescribedtable)->select('*')
      ->orderby('id', 'desc')
      ->where('working_weight', '<>', null)
      ->where('baby_id', $baby_id)->where('admission_id', $admission_id)->first();
    }

    /**
     * This method get monitor data
     * based on mrn and snomed code
     *
     * @param $baby_mrn
     * @param $snomed_ct
     *
     */
    public static function montiorData($baby_id, $admission_id, $page = 1, $limit = 50, $condition, $order = array())
    {
      $limitstart = (empty($page) || $page == 1) ? 0 : (($page - 1) * $limit);
      $limitend = $limit;
      $search_txt = isset($condition) ? trim($condition) : '';
      $checkdate = '';

      if (strpos($search_txt, '-') > 0)
      {
        $get_date = strtotime($search_txt);
        $checkdate = (!empty($get_date)) ? date('Y-m-d', $get_date) : '';
        $search_txt = '';
      }

      $result['getTotal'] = \DB::table('emr_moniter_values')
      ->join('emr_log_hdr', 'emr_moniter_values.log_hdr_id', 'emr_log_hdr.id')
      ->where('baby_id', $baby_id)
      ->where('admission_id', $admission_id)
      ->get()
      ->count();

      $results = \DB::table('emr_moniter_values')
      ->join('emr_log_hdr', 'emr_moniter_values.log_hdr_id', 'emr_log_hdr.id')
      ->join('local_code_group', 'emr_moniter_values.loinc_local_map_id', '=', 'local_code_group.id')
      ->where('baby_id', $baby_id)
      ->where('admission_id', $admission_id)
      ->where(function ($query) use ($search_txt, $checkdate)
      {
        if (!empty($search_txt) && empty($checkdate))
        {
          $query->whereRaw('trim("local_description") ilike ' . "'%" . trim($search_txt) . "%'");
          $query->orWhereRaw('trim("device_model") ilike ' . "'%" . trim($search_txt) . "%'");
          $query->orWhere('close', 'ilike', '%' . $search_txt . '%');
          $query->orWhere('first_quartile', 'ilike', '%' . $search_txt . '%');
          $query->orWhere('mean', 'ilike', '%' . $search_txt . '%');
          $query->orWhere('low', 'ilike', '%' . $search_txt . '%');
          $query->orWhere('last_quartile', 'ilike', '%' . $search_txt . '%');
        }

        if (!empty($checkdate) && empty($search_txt))
        {
          $query->whereRaw("DATE_TRUNC('day', result_date_time) = '" . $checkdate . "'");
        }
      });

      if (isset($order['sortby']) && isset($order['sortorder']))
      {
        $results->orderBy($order['sortby'], $order['sortorder']);
      }

      $result['total'] = $results->get()->count();
      $result['result'] = $results->limit($limitend)->offset($limitstart)->get();

      return $result;

    }

    /**
     * This method get infusion data
     *
     * @param $baby_mrn
     * @param $snomed_ct
     *
     */
    public static function infusionData($baby_id, $admission_id, $page = 1, $limit = 50, $condition, $order = array())
    {

      $limitstart = (empty($page) || $page == 1) ? 0 : (($page - 1) * $limit);
      $limitend = $limit;
      $search_txt = isset($condition) ? trim($condition) : '';
      $checkdate = $whole_txt = $alpha_txt = '';

      if (strpos($search_txt, '-') > 0)
      {
        $get_date = strtotime($search_txt);
        $checkdate = (!empty($get_date)) ? date('Y-m-d', $get_date) : '';
        $search_txt = '';
      }

      if (preg_match('/[a-zA-Z]/', $search_txt))
      {
        $alpha_txt = $search_txt;
        $search_txt = '';
      }

      if (!preg_match('/[.]/', $search_txt) && strlen($search_txt) < 5)
      {
        $whole_txt = $search_txt;
        $search_txt = '';
      }

      $prescription_key_id = \SiteHelpers::prescriptionKeyId();
      $results = \DB::table('prescription')
      ->select('prescription.*', 'prescription.id as prescription_table_id', 'prescription.rate as prescription_rate', 'prescription_dtl.prescription_id', 'prescription_hdr.baby_id', 'prescription_hdr.admission_id', 'mas_drugivfluid.*', 'mas_drugivfluid.brand_name as brandname')
      ->join('prescription_dtl', 'prescription.prescription_id', 'prescription_dtl.prescription_id')
      ->join('prescription_hdr', 'prescription_dtl.pres_hdr_id', 'prescription_hdr.id')
      ->join('mas_drugivfluid', 'prescription_hdr.brand_name', 'mas_drugivfluid.id')
      ->where('prescription_hdr.baby_id', $baby_id)
      ->where('prescription_hdr.admission_id', $admission_id);
      $result['getTotal'] = $results->count();

      $results = $results->where(function ($query) use ($search_txt, $checkdate, $alpha_txt, $whole_txt)
      {
        if (!empty($search_txt) && empty($checkdate) && empty($alpha_txt) && empty($whole_txt))
        {
          $query->orWhere('prescription.infused', 'ilike', '%' . $search_txt . '%');
          $query->orWhere('prescription.rate', 'ilike', '%' . $search_txt . '%');
          $query->orWhere('prescription.remain_volume', 'ilike', '%' . $search_txt . '%');
          $query->orWhere('prescription.remain_time', 'ilike', '%' . $search_txt . '%');
        }

        if (!empty($checkdate) && empty($search_txt) && empty($alpha_txt) && empty($whole_txt))
        {
          $query->whereRaw("DATE_TRUNC('day', prescription.result_time) = '" . $checkdate . "'");
        }

        if (!empty($alpha_txt) && empty($checkdate) && empty($search_txt) && empty($whole_txt))
        {
          $query->orWhereRaw('trim("generic_pharmacological_name") ilike ' . "'%" . trim($alpha_txt) . "%'");
        }

        if (!empty($whole_txt) && empty($alpha_txt) && empty($checkdate) && empty($search_txt))
        {

          $query->orWhere('prescription.pressure', $whole_txt);
          $query->orWhere('prescription.pressure_level', $whole_txt);
        }

      });

      if (isset($order['sortby']) && isset($order['sortorder']))
      {
        $results->orderBy($order['sortby'], $order['sortorder']);
      }

      $result['total'] = $results->get()
      ->count();
      $result['result'] = $results->limit($limitend)->offset($limitstart)->get();

      return $result;

    }

    /**
     * This method to get vendilator
     * data
     *
     * @param $baby_mrn
     * @param $snomed_ct
     */
    public static function vendilatorData($baby_id, $admission_id, $page = 1, $limit = 50, $condition, $order = array())
    {
      $limitstart = (empty($page) || $page == 1) ? 0 : (($page - 1) * $limit);
      $limitend = $limit;
      $search_txt = isset($condition) ? trim($condition) : '';
      $checkdate = '';

      if (strpos($search_txt, '-') > 0)
      {
        $get_date = strtotime($search_txt);
        $checkdate = (!empty($get_date)) ? date('Y-m-d', $get_date) : '';
        $search_txt = '';
      }


      $result['getTotal'] = \DB::table('emr_ventilator_values')
      ->join('emr_log_hdr', 'emr_ventilator_values.log_hdr_id', 'emr_log_hdr.id')
      ->where('baby_id', $baby_id)
      ->where('admission_id', $admission_id)
      ->get()
      ->count();

      $results = \DB::table('emr_ventilator_values')
      ->join('emr_log_hdr', 'emr_ventilator_values.log_hdr_id', 'emr_log_hdr.id')
      ->join('local_code_group', 'emr_ventilator_values.loinc_local_map_id', '=', 'local_code_group.id')
      ->where('baby_id', $baby_id)
      ->where('admission_id', $admission_id)
      ->where(function ($query) use ($search_txt, $checkdate)
      {
        if (!empty($search_txt) && empty($checkdate))
        {
          $query->whereRaw('trim("local_description") ilike ' . "'%" . trim($search_txt) . "%'");
          $query->orWhereRaw('trim("device_model") ilike ' . "'%" . trim($search_txt) . "%'");
          $query->orWhere('close', 'ilike', '%' . $search_txt . '%');
          $query->orWhere('first_quartile', 'ilike', '%' . $search_txt . '%');
          $query->orWhere('mean', 'ilike', '%' . $search_txt . '%');
          $query->orWhere('low', 'ilike', '%' . $search_txt . '%');
          $query->orWhere('last_quartile', 'ilike', '%' . $search_txt . '%');
        }

        if (!empty($checkdate) && empty($search_txt))
        {
                // $query->whereRaw('result_date_time::date='.$checkdate);
          $query->whereRaw("DATE_TRUNC('day', result_date_time) = '" . $checkdate . "'");
        }
      });

      if (isset($order['sortby']) && isset($order['sortorder']))
      {
        $results->orderBy($order['sortby'], $order['sortorder']);
      }

      $result['total'] = $results->get()
      ->count();
      $result['result'] = $results->limit($limitend)->offset($limitstart)->get();

      return $result;

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
    public static function pumpInfusingTime($drug_type, $result)
    {
      return \DB::table('fihr_formated_values')->where('advice_id', $drug_type . $result)->where('snomed_code', '430033006+263490005')
      ->orderBy('id', 'asc')
      ->where('mean', 'ilike', '%infusing%')
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
    public static function pumpStopTime($drug_type, $result)
    {
      return \DB::table('fihr_formated_values')->where('advice_id', $drug_type . $result)->where('snomed_code', '430033006+263490005')
      ->where('mean', 'ilike', '%stop%')
      ->orderBy('id', 'asc')
      ->first();
    }

    /**
     * This method to get completed time of the drug
     *
     * @param $drug_type is slug
     *
     * @param $result is integer
     *
     * @return array of object
     */
    public static function pumpCompleteTime($drug_type, $result)
    {
      return \DB::table('fihr_formated_values')->where('advice_id', $drug_type . $result)->where('snomed_code', '430033006+263490005')
      ->where('mean', 'ilike', '%KVO%')
      ->orderBy('id', 'asc')
      ->first();
    }

    /**
     * This method to get the Tpn drugs
     */
    public static function getTpnDrugs($bmrno, $ip_number, $snomed_code, $start_time, $end_time)
    {

      $resource = \DB::table('fihr_formated_values')->addSelect('end_time', 'mean', 'advice_id')
      ->where('mrn', $bmrno)
        //->where('ip_number', $ip_number)
      ->where('snomed_ct', 'ilike', '%' . $snomed_code . '%')->where('mean', '<>', 'None')
      ->where('mean', '>', 0)
      ->where('mean', '<>', '0.00')
      ->where('end_time', '>=', date('Y-m-d H:i:s', strtotime($start_time)))->where('end_time', '<=', date('Y-m-d H:i:s', strtotime($end_time)))->orderby('id', 'desc')
      ->get();
      return $resource;
    }

    /**
     * Get The total records count
     *
     * @return list count
     */
    public static function getTotal()
    {
      return \DB::table('fihr_formated_values')->get()
      ->count();
    }

    /**
     * Get The total records count
     *
     * @return list count
     */
    public static function get_monitor_total()
    {
        $monitor_values_count = \DB::table('emr_moniter_values')->select(\DB::raw('count(*) as total'));
        $monitor_values_discharged_count = \DB::table('emr_moniter_values_discharged')->select(\DB::raw('count(*) as total'));

        $count = $monitor_values_discharged_count->union($monitor_values_count)->get()
            ->pluck('total')
            ->toArray();
        $count = array_sum($count);

        return $count;
    }

    /**
     * Get The total records count
     *
     * @return list count
     */
    public static function get_ventilator_total()
    {
        $ventilator_values_count = \DB::table('emr_ventilator_values')->select(\DB::raw('count(*) as total'));
        $ventilator_values_discharged_count = \DB::table('emr_ventilator_values_discharged')->select(\DB::raw('count(*) as total'));

        $count = $ventilator_values_discharged_count->union($ventilator_values_count)->get()
            ->pluck('total')
            ->toArray();
        $count = array_sum($count);

        return $count;
    }

    /**
     * Get The total records count
     *
     * @return list count
     */
    public static function get_pump_total()
    {
      return \DB::table('prescription')->get()
      ->count();
    }

    /**
     * This method to get prescribed drug starting time
     */
    public static function drugStarttime($advice_id)
    {

      $result = \DB::table('fihr_formated_values')->select('date')
      ->where('advice_id', $advice_id)->orderby('id', 'asc')
      ->first();
      return $result;
    }

    /**
     * This method to get fhir valuse
     * based on mrn and snomed code
     *
     * @param $baby_mrn type number
     * @param $snomed_code type array
     */
    public static function getListChart($baby_mrn, $snomed_code)
    {

      $result = \DB::table('fihr_formated_values')->where('mrn', $baby_mrn)->where('snomed_code', $snomed_code)->orderby('date', 'asc')
      ->get();

      return $result;

    }

    /**
     * This method to get fhir valuse
     * based on mrn
     *
     */
    public static function getListChartdata($baby_mrn, $snomed_ct, $visit)
    {
      $result = \DB::table('fihr_formated_values')->select('date', 'mean as ' . $visit)->where('mrn', $baby_mrn)->limit('2')
      ->get();

      return $result;

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
    public static function pumpInfusingNow($drug_type, $result, $date, $mrn)
    {
      return \DB::table('fihr_formated_values')->where('mrn', $mrn)->where('advice_id', $drug_type . $result)->where('snomed_code', '430033006+263490005')
      ->where('mean', 'ilike', '%infusing%')
      ->whereRaw('issued ilike ' . "'%" . $date . "%'")->orderBy('id', 'desc')
      ->first();
    }
    /**
     * This method to get currently running of the drug
     *
     * @param $id is slug
     *
     * @param $type is integer
     */
    public static function getFhirData($id, $type)
    {
        $type = explode(':', $type);

        if ($type[0] == 'monitor')
        {
            $table_name = 'emr_moniter_values';
            if ($type[1] == 'discharged')
            {
                $table_name = 'emr_moniter_values_discharged';
            }
            $result = \DB::table($table_name)->select($table_name . '.*', 'emr_log_hdr.admission_id', 'emr_log_hdr.baby_id', 'baby.BabyName as name', 'baby.DOB as birthdate', 'baby.BMrNo as mrn', 'ip_numbers.ip_number', $table_name . '.device_model as model', $table_name . '.create_tstamp as issued', 'local_code_group.*')->join('emr_log_hdr', 'emr_log_hdr.id', '=', $table_name . '.log_hdr_id')->join('baby', 'baby.BabyId', '=', 'emr_log_hdr.baby_id')
                ->join('ip_numbers', 'ip_numbers.AdmissionId', '=', 'emr_log_hdr.admission_id')
                ->join('local_code_group', $table_name . '.loinc_local_map_id', '=', 'local_code_group.id')->where($table_name . '.id', $id)->first();

        }
        elseif ($type[0] == 'ventilator')
        {
            $table_name = 'emr_ventilator_values';
            if ($type[1] == 'discharged')
            {
                $table_name = 'emr_ventilator_values_discharged';
            }
            $result = \DB::table($table_name)->select($table_name . '.*', 'emr_log_hdr.admission_id', 'emr_log_hdr.baby_id', 'baby.BabyName as name', 'baby.DOB as birthdate', 'baby.BMrNo as mrn', 'ip_numbers.ip_number', $table_name . '.device_model as model', $table_name . '.create_tstamp as issued', 'local_code_group.*')->join('emr_log_hdr', 'emr_log_hdr.id', '=', $table_name . '.log_hdr_id')->join('baby', 'baby.BabyId', '=', 'emr_log_hdr.baby_id')
                ->join('ip_numbers', 'ip_numbers.AdmissionId', '=', 'emr_log_hdr.admission_id')
                ->join('local_code_group', $table_name . '.loinc_local_map_id', '=', 'local_code_group.id')->where($table_name . '.id', $id)->first();
        }
        elseif ($type[0] == 'pump')
        {
            $table_name1 = 'prescription';
            $table_name2 = 'prescription_dtl';
            if ($type[1] == 'discharged')
            {
                $table_name1 = 'prescription_discharged';
                $table_name2 = 'prescription_dtl_discharged';
            }
            $result = \DB::table($table_name1)->select($table_name1.'.*', $table_name1.'.rate as pump_rate', 'prescription_hdr.baby_id', 'prescription_hdr.admission_id', 'mas_drugivfluid.*', 'mas_drugivfluid.brand_name as brandname', 'baby.*', 'ip_numbers.*')
                ->leftjoin($table_name2, $table_name2.'.prescription_id', $table_name1.'.prescription_id')
                ->leftjoin('prescription_hdr', 'prescription_hdr.id', $table_name2.'.pres_hdr_id')
                ->leftjoin('mas_drugivfluid', 'mas_drugivfluid.id', 'prescription_hdr.brand_name')
                ->leftjoin('baby', 'baby.BabyId', '=', 'prescription_hdr.baby_id')
                ->leftjoin('baby_admission', 'baby_admission.BabyId', 'prescription_hdr.baby_id')
                ->leftjoin('ip_numbers', 'ip_numbers.AdmissionId', '=', 'prescription_hdr.admission_id')
                ->where($table_name1.'.id', $id)->first();
        }
        return $result;
    }

  }

