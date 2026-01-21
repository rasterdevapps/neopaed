<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * All the curd of problem base daycare goes here
 *
 * @author Manikandan M
 */
class Postnatal extends Model
{
    /**
     *@var $table string
     */
    protected $table = 'postnatal_admission';

    /**
     *@var $primaryKey string
     */
    protected $primaryKey = 'pid';

    /**
     *@var $timestamps
     */
    public $timestamps = false;

    /**
     *@var $fillable type array
     */
    public $fillable = ['BabyId', 'MotherId', 'AdmissionId', 'BMrNo', 'referredby', 'referralreason', 'admission_cg', 'admission_time_hour', 'admission_time_mins', 'admission_time_session', 'admission_date', 'typeofcare', 'ip_number', 'admission_wt', 'ageonadmissionindays', 'surgeon', 'seenby', 'admitted_from', 'major_complaints', 'ventilation', 'mode', 'pip', 'peep', 'amplitude', 'mean_airway_pressure', 'rate', 'it', 'fio2', 'flow', 'rr', 'nicu_retractions', 'nicu_airentry', 'chest_movement', 'hr', 'systolic_bp', 'diastolic_bp', 'mean_bp', 'nicu_central_pulses', 'nicu_peripheral_pulses', 'nicu_femoral_pulses', 's1s2', 'nicu_murmur', 'cft', 'nicu_color', 'temperature', 'nicu_abdomen', 'nicu_bowel_sounds', 'nicu_umbilicus', 'nicu_hepatomegaly', 'nicu_splenomegaly', 'nicu_herina', 'genitalia', 'nicu_pupils', 'nicu_anteriorfontanelle', 'nicu_activity', 'tone', 'nicu_cry', 'nicu_seizures', 'nicu_neonatalreflexes', 'skin', 'abnormalities', 'initialbloodgas', 'agetaken', 'spo2', 'ph', 'pao2', 'paco2', 'hco3', 'be', 'rbs', 'hct', 'initialxray', 'xrayfindings', 'ageofcxr', 'uac_status', 'uac_position', 'uvc_status', 'uvc_position', 'sepsisscreen', 'indications', 'ivantibiotic', 'investigations', 'fluids', 'enteral_feeding', 'differentialdiagnosis', 'additional_diagnosis', 'plan', 'parents_spoken', 'pdiscussion_hrs', 'pdiscussion_min', 'pdiscussion_session', 'matters_discussed', 'DateAdded', 'DateModified', 'UserDeleted', 'UserModified', 'UserAdded', 'IsDeleted', 'parents_addressed_by', 'admission_examination', 'nicu_pupils_findings', 'genitalia_findings', 'hospital_name', 'edited', 'edited_content', 'edited_time'];

    /**
     * This Method To Get postnatal Baby List
     *
     * @param $page type integer
     * @param $limit type integer
     * @param $search type string or number
     * @param $order type string
     *
     * @return admission list in array of object
     */
    public static function get_lists($page = 1, $limit = 50, $search = array() , $order = array() , $slug = '', $status = '')
    {
        $limitstart = (empty($page) || $page == 1) ? 0 : (($page - 1) * $limit);
        $limitend = $limit;
        $search_txt = isset($search['search_txt']) ? $search['search_txt'] : '';

        $checkdate = '';

        if (strpos($search_txt, '-') > 0)
        {
            $get_date = strtotime($search_txt);
            $checkdate = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date) : '';
            $search_txt = (!empty($checkdate)) ? '' : $search_txt;
        }

        $results = \DB::table('baby')
            ->whereIn('baby.BabyId', function ($query) use ($search_txt, $checkdate, $status) {
                $query->from('baby_admission')
                    ->select('postnatal_admission.BabyId')
                    ->join('postnatal_admission', 'postnatal_admission.BabyId', '=', 'baby_admission.BabyId')
                    ->leftjoin('postnatal_discharge', 'postnatal_discharge.posdisid', '=', 'postnatal_admission.pid')
                    ->where(function ($query) use ($status) {
                        if ($status == 'inpatient')
                        {
                            $query->where('discharge_status', 'Inpatient');
                        }
                        elseif ($status == 'discharged')
                        {
                            $query->where('discharge_status', '!=', 'Inpatient');
                        }
                    })
                    ->where('postnatal_admission.IsDeleted', 0);

                if (!empty($checkdate) && !empty($search_txt)) {
                    $query->whereIn('discharge_status', ['Inpatient']);
                }
                // ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby_admission.BabyId')
                // ->where('neonatal_proforma.transfer_status', 'Postnatal Ward')
                $query->groupby('postnatal_admission.BabyId')
                    ->get()
                    ->toArray();
            })
            ->where(function ($query) use ($search_txt, $checkdate) {

                if (!empty($search_txt) && empty($checkdate))
                {
                    $query->where('baby.BabyName', 'like', '%' . ucfirst(trim($search_txt)) . '%');
                    $query->orwhere('baby.BMrNo', $search_txt);
                }

                if (!empty($checkdate) && empty($search_txt))
                {

                    $query->whereRaw('"baby"."DOB"::date=' . $checkdate);
                }

            })
            ->where('baby.IsDeleted', 0);
            if (isset($order['sortby']) && isset($order['sortorder'])) {
                $results->orderBy($order['sortby'], $order['sortorder']);

            }

            if ($slug) {
                $result['total'] = $results->get()->count();
                $result['result'] = $results->limit($limitend)->offset($limitstart)->get();
            } else {
                $result = $results->limit($limitend)->offset($limitstart)->get();
            }
        
        return $result;

    }

    /**
     * This Method To Get Baby Admission count
     *
     * @return baby admission count
     */
    public static function GetTotal()
    {

        return \DB::table('baby')->whereIn('baby.BabyId', function ($query)
        {
            $query->from('baby_admission')
                ->select('postnatal_admission.BabyId')
                ->join('postnatal_admission', 'postnatal_admission.BabyId', '=', 'baby_admission.BabyId')
                ->where('postnatal_admission.IsDeleted', 0)
                ->groupby('postnatal_admission.BabyId')
                ->get()
                ->toArray();
        })
            ->get()
            ->count();

    }

    /**
     * This Method To Get postnatal Baby List
     *
     * @param $baby_id type integer
     *
     * @return admission list in array of object
     */
    public static function postnatalAdmissionList($baby_id)
    {
        $results = \DB::table('baby')->select('*')
            ->addSelect('postnatal_admission.AdmissionId as postnatal_admission_id')
            ->join('baby_admission', 'baby_admission.BabyId', '=', 'baby.BabyId')
            ->join('postnatal_admission', 'postnatal_admission.AdmissionId', '=', 'baby_admission.AdmissionId')
            ->leftjoin('ip_numbers', 'ip_numbers.AdmissionId', '=', 'baby_admission.AdmissionId')
            ->where('baby.IsDeleted', 0)
            ->where('postnatal_admission.IsDeleted', 0)
            ->where('postnatal_admission.BabyId', $baby_id)->orderBy('postnatal_admission.pid', 'desc')
            ->get();

        // $results=\SiteHelpers::convert_obj_to_array($results->toArray());
        // $results=\SiteHelpers::unique_multidim_array($results, 'AdmissionId');
        // $results=\SiteHelpers::convert_array_to_object($results);
        return $results;

    }

    /**
     * This Method To Get Baby Admission List
     *
     * @param $baby_id type integer
     * @return admission list in array of object
     */
    public static function GetAdmissionList($baby_id)
    {
        $results = \DB::table('baby')->SelectRaw('"baby_admission"."BabyId" || \' - \' || "baby_admission"."AdmissionId" as create_id')
            ->addSelect('baby_admission.episodes')
            ->join('baby_admission', 'baby_admission.BabyId', '=', 'baby.BabyId')->whereIn('baby_admission.AdmissionId', function ($query) use ($baby_id)
        {
            $query->from('nicu_admission')
                ->select('nicu_admission.AdmissionId')
                ->whereIn('nicu_admission.status', ['Inpatient', 'Transferred'])
                ->where('nicu_admission.IsDeleted', 0)
                ->where('nicu_admission.BabyId', $baby_id)->get()
                ->toArray();

        })->orwhereIn('baby_admission.AdmissionId', function ($query) use ($baby_id)
        {
            $query->from('postnatal_discharge')
                ->select('postnatal_discharge.AdmissionId')
                ->whereIn('postnatal_discharge.discharge_status', ['Inpatient', 'Transferred'])
                ->where('postnatal_discharge.IsDeleted', 0)
                ->where('postnatal_discharge.BabyId', $baby_id)->get()
                ->toArray();

        })
            ->whereNotNull('baby_admission.BabyId')
            ->whereNotNull('baby_admission.AdmissionId')
            ->where('baby.BabyId', $baby_id)->get();
        return $results;
    }

    /**
     * This Method to get table column type by name
     *
     * @param  type $columnName
     */
    public function getColumnTypeUp($columnName)
    {
        if ($this->getConnection()
            ->getSchemaBuilder()
            ->hasColumn($this->getTable() , $columnName) != false)
        {
            return $this->getConnection()
                ->getSchemaBuilder()
                ->getColumnType($this->getTable() , $columnName);
        }

        return false;

    }

    /**
     * This Method To Set the relation betweenn admission and postnatal
     *
     */
    public static function getBabydetalis($pid)
    {
        $results = \DB::table('baby')->select('baby.*', 'postnatal_admission.*', 'baby_admission.*', 'ip_numbers.*', 'baby_admission.AdmissionId as admissionid')
            ->join('postnatal_admission', 'postnatal_admission.BabyId', '=', 'baby.BabyId')
            ->join('baby_admission', 'baby_admission.AdmissionId', '=', 'postnatal_admission.AdmissionId')
            ->leftjoin('ip_numbers', 'ip_numbers.AdmissionId', '=', 'baby_admission.AdmissionId')
            ->where('postnatal_admission.IsDeleted', 0)
            ->where('pid', $pid)->first();
        return $results;
    }

    /**
     * This Method to get discharge details
     *
     * @param $babyId type integer
     */
    public static function getDischargeStatus($baby_id)
    {
        $results = \DB::table('baby_admission')->join('postnatal_discharge', 'postnatal_discharge.AdmissionId', '=', 'baby_admission.AdmissionId')
            ->where('baby_admission.BabyId', $baby_id)->where('IsDeleted', 0)
            ->whereIn('postnatal_discharge.discharge_status', ['Inpatient', 'Transferred'])
            ->orderBy('baby_admission.AdmissionId', 'desc')
            ->first();
        return $results;
    }

    /**
     * This method to get postnatal admission
     * print view
     *
     * @param $pid type integer postnatal id
     * @return array of objects
     */
    public static function getAdmissionprint($pid)
    {
        $results = \DB::table('postnatal_admission')->select('postnatal_admission.*', 'neonatal_proforma.*', 'baby.*', 'mother.*', 'postnatal_admission.edited as post_edited', 'postnatal_admission.edited_content as post_content')
            ->addSelect('postnatal_admission.AdmissionId as admission_id')
            ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'postnatal_admission.BabyId')
            ->join('baby', 'baby.BabyId', '=', 'postnatal_admission.BabyId')
            ->join('mother', 'mother.MotherId', '=', 'baby.MotherId')
            ->where('postnatal_admission.pid', $pid)->first();

        return $results;
    }

    /**
     * This method to get recent admission
     * in postnatal ward
     *
     * @return type array of object
     */
    public static function getRecentAdmission($limit)
    {

        $results = \DB::table('baby')->select('baby.BabyName', 'baby.BMrNo', 'postnatal_admission.pid')
            ->join('baby_admission', 'baby_admission.BabyId', '=', 'baby.BabyId')
            ->join('postnatal_admission', 'postnatal_admission.AdmissionId', '=', 'baby_admission.AdmissionId')
            ->where('baby.IsDeleted', 0)
            ->where('postnatal_admission.IsDeleted', 0)
            ->orderBy('postnatal_admission.pid', 'desc')
            ->limit($limit)->get();
        return $results;

    }

    /**
     * This method to get postnatal admission for daycare print
     * in postnatal ward
     *
     * @param  $baby_id type integer
     * @param  $admission_id type integer
     * @return type array of object
     */
    public static function getAdmissionDailyCare($baby_id, $admission_id)
    {
        return \DB::table('postnatal_admission')->where('AdmissionId', $admission_id)->where('BabyId', $baby_id)->where('IsDeleted', 0)
            ->orderBy('pid', 'desc')
            ->first();

    }

    /**
     * This method to check postnatal daycare
     *
     * @param $baby_id type integer
     * @param $admission_id type integer
     * @return type array of object
     */
    public static function getPostanatalDependancy($baby_id, $admission_id)
    {
        return \DB::table('postnatal_daycare')->where('BabyId', $baby_id)->where('AdmissionId', $admission_id)->where('IsDeleted', '0')
            ->get();

    }

    /**
     * This method used to fetch all postnatal record
     *
     * @param $baby_id type integer
     *
     * @return array of objects
     */
    public static function postnatal_delete_approval($baby_id)
    {
        $results = \DB::table('postnatal_admission')->join('baby_admission', 'baby_admission.AdmissionId', '=', 'postnatal_admission.AdmissionId')
            ->leftjoin('baby', 'postnatal_admission.BabyId', '=', 'baby.BabyId')
            ->select('postnatal_admission.BabyId', 'postnatal_admission.AdmissionId', 'baby_admission.episodes', 'postnatal_admission.pid')
            ->where('postnatal_admission.BabyId', $baby_id)->get();
        return $results;
    }

    /**
     * This method to check whether the postnatal_admission is deleted or not.
     *
     * @param $baby_id type integer
     *
     * @return array of objects
     */
    public static function postnatal_delete($baby_id)
    {
        $results = \DB::table('postnatal_admission')->leftjoin('delete_approval', 'delete_approval.ModuleId', '=', 'postnatal_admission.BabyId')->where(function ($query) use ($baby_id)
        {
            $query->where('BabyId', $baby_id)->orWhere('postnatal_admission.IsDeleted', 1);
        })
            ->get();
        return $results;
    }

    /** This method to check whether the postnatal_admission is deleted or not.
     *
     * @param $baby_id type integer
     *
     * @return array of objects
     */
    public static function neonatal_delete($id)
    {
        $results = \DB::table('postnatal_admission')->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'postnatal_admission.BabyId')
            ->leftjoin('delete_approval', 'delete_approval.ModuleId', '=', 'postnatal_admission.pid')
            ->where('delete_approval.Status', 'Approved')
            ->where('delete_approval.ModuleName', 'Postnatal Admission')
            ->where('postnatal_admission.pid', $id)->orderBy('delete_approval.Id', 'desc')
            ->first();
        return $results;
    }
}

