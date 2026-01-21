<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Daycare extends Model
{
    protected $table = 'daycare';
    protected $primaryKey = 'DayId';
    public $timestamps = false;
    protected $gaurded = ['DayId'];
    protected $fillable = ['DateAdded', 'pvc_number', 'AdmissionId', 'BabyId', 'MotherId', 'DateModified', 'Notes', 'cg_weeks', 'cg_days', 'DayDate', 'DayTime', 'DayOfLife', 'CGA', 'Care', 'PreviousProblems', 'CurrentProblems', 'Rop', 'Plan', 'Skin', 'PeripheralCannula', 'PvcSites', 'PvcDay', 'DayChange', 'PvcComplication', 'Picc', 'PiccSite', 'PiccDay', 'PiccComplication', 'Uvc', 'UvcPosition', 'UvcDay', 'UvcComplication', 'Uac', 'UacPosition', 'UacDay', 'UacComplication', 'Pac', 'PacSite', 'PacDay', 'PacComplication', 'Cuss', 'Sepsis', 'BloodCulture', 'Organism', 'PositiveBlood', 'Meningitis', 'OtherDrugs', 'CRP', 'TLC', 'Percentage', 'ANC', 'Platelets', 'TotalFluid', 'PreviousWt', 'CurrentWt', 'WtChange', 'PercentageChange', 'UrineOutput', 'UO', 'BloodOut', 'DrainOutput', 'RBS', 'SerumNa', 'SerumK', 'Transfusion', 'AnteriorFontanelle', 'Activity', 'Tone', 'Cry', 'Seizures', 'TypeOfSeizures', 'NeonatalReflexes', 'CnsFindings', 'Feeds', 'Volume', 'Frequency', 'Ivf', 'Tpn', 'AspirateVolume', 'AspirateNature', 'Stools', 'StoolNature', 'Abdomen', 'BowelSounds', 'AbdominalGirth', 'PAFindings', 'AxrFindings', 'Umbilicus', 'Hepatomegaly', 'LiverSpan', 'Splenomegaly', 'SpleenSpan', 'Herina', 'Genitalia', 'TSB', 'NNJTreatment', 'HR', 'systolic_bp', 'diastolic_bp', 'MeanBP', 'PulsePressure', 'CentralPulses', 'PeripheralPulses', 'FemoralPulses', 'PrecordialActivity', 'S1S2', 'Murmur', 'CharacterOfMurmur', 'CVSFindings', 'CFT', 'CentralTemperature', 'PeripheralTemperature', 'Color', 'Inotropes', 'Dopamine', 'Dobutamine', 'Adrenaline', 'DayEcho', 'ModeOfVentilation', 'RR', 'Retractions', 'AirEntry', 'ChestMovement', 'AddedSounds', 'DayCharacter', 'CXRFindings', 'RSFindings', 'Indication', 'pip_set', 'pip_delivered', 'PEEP', 'MAP', 'fio2_set', 'fio2_delivered', 'Rate', 'IT', 'LastBG', 'TypeOfBloodGas', 'Ph', 'PaO2', 'PaCo2', 'HCO3', 'BE', 'Lactate', 'EtTube', 'Size', 'Lips', 'SaO2PostDuctal', 'AaDO2', 'OI', 'UserAdded', 'UserDeleted', 'IsDeleted', 'PDA', 'PDATreatment', 'InvasiveVentilation', 'DayTime_MINS', 'DayTime_AM', 'NonInvasiveVentilation', 'OtherRespiratorySupport', 'FullEnteralFeeds', 'TypeofFeeds', 'NECtreatment', 'NEC', 'Hypoglycemia', 'Hyperglycemia', 'InsulinTherapy', 'Hyponatremia', 'Hypernatremia', 'Hypokalemia', 'Hyperkalemia', 'Hypocalcemia', 'Hypercalcemia', 'NicuICD', 'Immunoglobulins', 'Noradrenaline', 'Milrinone', 'TherapeuticHypothermia', 'frequency_rep', 'Flow', 'Surfactant_therapy_nicu', 'Spontaneouslyventilating', 'Ventilation_choose', 'day_name', 'echo_status', 'pphn', 'pphn_treatement', 'chronic_lung', 'surfactant_indication', 'seenby', 'Background', 'edited', 'edited_content', 'edited_time', 'length', 'head_circumference', 'amplitude', 'additional_res_icd', 'additional_car_icd', 'additional_gas_icd', 'additional_cen_icd', 'additional_fluid_icd', 'additional_spesis_icd', 'additional_skin_icd', 'additional_rop_icd', 'i_e_ratio', 'volume_targeting', 'claco', 'form_status', 'UserModified'];
    /**
     * FETCH NON DELETED RECORDS FOR LISTING
     */

    public static function get_lists($page = 1, $limit = 50, $condition = array() , $order = array() , $slug = '', $status = '')
    {

        $limitstart = (empty($page) || $page == 1) ? 0 : (($page - 1) * $limit);
        $limitend = $limit;
        $search_txt = isset($condition['search_txt']) ? $condition['search_txt'] : '';

        $checkdate = '';
        if (strpos($search_txt, '-') > 0)
        {
            $get_date = strtotime($search_txt);
            $checkdate = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date) : '';
            $search_txt = '';
        }

        $results = DB::table('daycare')->select('baby.BabyName', 'baby.BabyId', 'baby.DOB', 'baby.BMrNo', 'nicu_admission.status', 'neonatal_proforma.NeonatalId')
            ->join('baby', 'daycare.BabyId', '=', 'baby.BabyId')
            ->join('nicu_admission', 'nicu_admission.BabyId', '=', 'baby.BabyId')
            ->where(function ($query) use ($status)
            {
                if ($status == 'inpatient') {
                    $query->where('status', 'Inpatient');
                }
                elseif ($status == 'discharged') {
                    $query->where('status', '!=', 'Inpatient');
                }
            })
            ->where(function ($query) use ($search_txt, $checkdate)
        {
            if (!empty($search_txt) && empty($checkdate))
            {
                $query->where('baby.BabyName', 'like', '%' . ucwords(trim($search_txt)) . '%');
                $query->orwhere('baby.BMrNo', $search_txt);
            }

            if (!empty($checkdate) && empty($search_txt))
            {

                $query->whereRaw('"baby"."DOB"::date=' . $checkdate);
            }

            // if (empty($checkdate) && empty($search_txt))
            // {

            //     $query->whereIn('status', ['Inpatient']);
            // }

        })
            ->leftjoin('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'nicu_admission.BabyId')
            ->where('baby.IsDeleted', 0)
            ->where('daycare.IsDeleted', 0)
            ->where('neonatal_proforma.IsDeleted', 0)
            ->where('nicu_admission.IsDeleted', 0);
        // ->where('nicu_admission.status', 'Inpatient')
        if (isset($order['sortby']) && isset($order['sortorder']))
        {
            $results->orderBy($order['sortby'], $order['sortorder']);
        }

        if ($slug)
        {
            $result['total'] = $results->groupby('baby.BabyId', 'nicu_admission.status', 'neonatal_proforma.NeonatalId')
                ->get()
                ->count();
            $result['result'] = $results->groupby('baby.BabyId', 'nicu_admission.status', 'neonatal_proforma.NeonatalId')
                ->limit($limitend)->offset($limitstart)->get();
        }
        else
        {
            $result = $results->groupby('baby.BabyId', 'nicu_admission.status')
                ->limit($limitend)->offset($limitstart)->get();
        }

        return $result;
    }
    public static function GetTotal()
    {
        $results = DB::table('daycare')->join('baby', 'baby.BabyId', '=', 'daycare.BabyId')
            ->join('nicu_admission', 'nicu_admission.BabyId', '=', 'baby.BabyId')
            ->select('baby.BabyId')
            ->where('daycare.IsDeleted', 0)
            ->where('nicu_admission.IsDeleted', 0)
            ->groupby('baby.BabyId', 'nicu_admission.status')
            ->get();

        return count($results);

    }

    public static function get_baby_list($id)
    {
        $results = DB::table('daycare')
            ->select(\DB::raw('DISTINCT ON("baby_admission"."AdmissionId") "baby_admission"."AdmissionId"') , 'baby.BabyName', 'baby.BabyId', 'baby.DOB', 'baby.BMrNo', 'daycare.DayDate', 'daycare.AdmissionId', 'daycare.DayId', 'daycare.Care', 'ip_numbers.ip_number', 'baby_admission.episodes', 'nicu_admission.AdmissionDate', 'nicu_admission.DischargeDate')
            ->join('baby', 'daycare.BabyId', '=', 'baby.BabyId')
            ->join('baby_admission', 'baby_admission.AdmissionId', '=', 'daycare.AdmissionId')
            ->join('nicu_admission', 'nicu_admission.AdmissionId', '=', 'daycare.AdmissionId')
            ->where('daycare.IsDeleted', 0)->leftjoin('ip_numbers', function ($join)
            {
                $join->on('daycare.AdmissionId', '=', 'ip_numbers.AdmissionId');
                $join->on('daycare.BabyId', '=', 'ip_numbers.baby_id');
            })
            ->where('baby.BabyId', $id)
            // ->orderBy('daycare.DayId', 'desc')
            ->get();

        // $results=\SiteHelpers::convert_obj_to_array($results->toArray());
        // $results=\SiteHelpers::unique_multidim_array($results, 'AdmissionId');
        // $results=\SiteHelpers::convert_array_to_object($results);
        

        return $results;

    }

    public static function get_admission_list($id)
    {

        $results = DB::table('daycare')
            ->join('baby', 'daycare.BabyId', '=', 'baby.BabyId')
            ->select('baby.BabyName', 'baby.BabyId', 'baby.DOB', 'baby.BMrNo', 'daycare.DayDate', 'daycare.AdmissionId', 'daycare.DayId', 'daycare.Care', 'ip_numbers.ip_number', 'baby_admission.episodes', 'daycare.edited', 'daycare.form_status')
            ->where('daycare.IsDeleted', 0)
            ->leftjoin('baby_admission', 'baby_admission.AdmissionId', '=', 'daycare.AdmissionId')
            ->leftjoin('ip_numbers', function ($join)
            {
                $join->on('daycare.AdmissionId', '=', 'ip_numbers.AdmissionId');
                $join->on('daycare.BabyId', '=', 'ip_numbers.baby_id');
            })
            ->where('daycare.AdmissionId', $id)->orderBy('daycare.DayDate', 'desc')
            ->get()
            ->unique('DayDate');

        if (count($results) != 0)
        {
            // $results = $results->sortby('DayId');
            
        }

        return $results;

    }

    public static function get_pervious_daycare($baby_id, $admission_id)
    {

        return DB::table('daycare')
            ->select('daycare.*')
            ->join('baby', 'daycare.BabyId', '=', 'baby.BabyId')
            ->leftjoin('daycare_questions', 'daycare_questions.DayId', '=', 'daycare.DayId')
            ->leftjoin('antibiotics', 'antibiotics.DayId', '=', 'daycare.DayId')
            ->where(['baby.BabyId' => $baby_id, 'daycare.AdmissionId' => $admission_id])
            ->where('daycare.IsDeleted', 0)
            ->orderBy('daycare.DayId', 'desc')
            ->first();
    }

    public static function getBabyDates($baby_id, $admission_id)
    {

        return DB::table('daycare')->select('DayDate')
            ->where(['BabyId' => $baby_id, 'AdmissionId' => $admission_id])->where('daycare.IsDeleted', 0)
            ->pluck('DayDate')
            ->unique()
            ->toArray();
    }

    public static function get_daycare_antibiotic($dayId)
    {
        return DB::table('antibiotics')->where('DayId', $dayId)->get();
    }

    /**
     * FETCH DATA FOR EDIT FORM
     */
    public static function get_record($id)
    {
        $results = DB::table('daycare')
        ->select('baby.*', 'daycare.*')
        ->addSelect('baby.Background as baby_background')
            ->join('baby', 'daycare.BabyId', '=', 'baby.BabyId')
            ->where('daycare.IsDeleted', 0)
            ->where('DayId', $id)->get();
        return $results;
    }
    /**
     * GET last admission ID
     */
    public static function GetAdmissionId($id)
    {
        $results = DB::table('nicu_admission')->select('nicu_admission.AdmissionId')
            ->where('Status', 'Inpatient')
            ->where('BabyId', $id)->orderBy('NicuId', 'desc')

            ->limit(1)
            ->get();

        return $results;
    }
    /*
     *  FETCH THE DATA FOR SEARCH FILTER
    */
    public static function GetSearchDatas($value)
    {
        $fillable = ['Notes', 'DayDate', 'DayTime', 'DayOfLife', 'CGA', 'Care', 'PreviousProblems', 'CurrentProblems', 'Rop', 'Plan', 'Skin', 'PeripheralCannula', 'PvcSites', 'PvcDay', 'DayChange', 'PvcComplication', 'Picc', 'PiccSite', 'PiccDay', 'PiccComplication', 'Uvc', 'UvcPosition', 'UvcDay', 'UvcComplication', 'Uac', 'UacPosition', 'UacDay', 'UacComplication', 'Pac', 'PacSite', 'PacDay', 'PacComplication', 'Cuss', 'Sepsis', 'BloodCulture', 'Organism', 'PositiveBlood', 'Meningitis', 'OtherDrugs', 'CRP', 'TLC', 'Percentage', 'ANC', 'Platelets', 'TotalFluid', 'PreviousWt', 'CurrentWt', 'WtChange', 'PercentageChange', 'UrineOutput', 'UO', 'BloodOut', 'DrainOutput', 'RBS', 'SerumNa', 'SerumK', 'Transfusion', 'AnteriorFontanelle', 'Activity', 'Tone', 'Cry', 'Seizures', 'TypeOfSeizures', 'NeonatalReflexes', 'CnsFindings', 'Feeds', 'Volume', 'Frequency', 'Ivf', 'Tpn', 'AspirateVolume', 'AspirateNature', 'Stools', 'StoolNature', 'Abdomen', 'BowelSounds', 'AbdominalGirth', 'PAFindings', 'AxrFindings', 'Umbilicus', 'Hepatomegaly', 'LiverSpan', 'Splenomegaly', 'SpleenSpan', 'Herina', 'Genitalia', 'TSB', 'NNJTreatment', 'HR', 'BP', 'MeanBP', 'PulsePressure', 'CentralPulses', 'PeripheralPulses', 'FemoralPulses', 'PrecordialActivity', 'S1S2', 'Murmur', 'CharacterOfMurmur', 'CVSFindings', 'CFT', 'CentralTemperature', 'PeripheralTemperature', 'Color', 'Inotropes', 'Dopamine', 'Dobutamine', 'Adrenaline', 'DayEcho', 'ModeOfVentilation', 'RR', 'Retractions', 'AirEntry', 'ChestMovement', 'AddedSounds', 'DayCharacter', 'CXRFindings', 'RSFindings', 'Indication', 'PIP', 'PEEP', 'MAP', 'FiO2', 'Rate', 'IT', 'DayOfVentilation', 'LastBG', 'TypeOfBloodGas', 'Ph', 'PaO2', 'PaCo2', 'HCO3', 'BE', 'Lactate', 'EtTube', 'Size', 'Lips', 'SaO2PostDuctal', 'AaDO2', 'OI', 'Noradrenaline', 'Milrinone', 'TherapeuticHypothermia', 'frequency_rep', 'Flow', 'Surfactant_therapy_nicu', 'Spontaneouslyventilating', 'Ventilation_choose', 'day_name'];

        $query = DB::table('daycare')->join('baby', 'daycare.BabyId', '=', 'baby.BabyId')
            ->select('*');

        foreach ($fillable as $column)
        {
            $query->orWhere($column, 'like', '%' . $value . '%');
        }

        $models = $query->get();

        return $models;

    }
    public static function getSilabingsday($baby_id, $admission_id)
    {

        return self::where(['BabyId' => $baby_id, 'AdmissionId' => $admission_id])->orderBy('DayOfLife', 'asc')
            ->where('IsDeleted', 0)
            ->pluck('DayId')
            ->toArray();

    }

    public function getReassessmentData()
    {

        return $this->hasMany('App\Models\DaycareReassessmentSheets', 'day_id', 'DayId')
            ->orderBy('id', 'asc');
    }

    public function getBabyRecord()
    {

        return $this->belongsTo('App\Models\Baby', 'BabyId');
    }

    public static function getDaydetails($baby_id, $admission_id)
    {
        return self::where(['BabyId' => $baby_id, 'AdmissionId' => $admission_id])->where('IsDeleted', 0)
            ->orderBy('DayId', 'desc')
            ->first();
    }

    /**
     * FETCH ALL DATA BASED ON Day ID
     *
     * @param $id type integer
     *
     * @return array of objects
     */
    public static function getrecord($id)
    {
        $results = DB::table('daycare')->join('baby', 'daycare.BabyId', '=', 'baby.BabyId')
            ->where('DayId', $id)->get();
        return $results;
    }

    /**
     * This method used to fetch all daycare record
     *
     * @param $baby_id type integer
     *
     * @return array of objects
     */
    public static function daycare_delete_approval($baby_id)
    {
        $result = DB::table('daycare')->join('baby_admission', 'baby_admission.AdmissionId', '=', 'daycare.AdmissionId')
            ->where('daycare.BabyId', $baby_id)->select('baby_admission.episodes')
            ->addSelect('daycare.BabyId', 'daycare.AdmissionId', 'daycare.DayId', 'daycare.day_name')
            ->orderby('baby_admission.episodes', 'asc')
            ->orderby('daycare.day_name', 'asc')
            ->get();

        return $result;
    }

    /**
     * This method to check whether the daycare entry is deleted or not.
     *
     * @param $babyid type integer
     *
     * @return array of objects
     */
    public static function daycare_delete($nicuId, $dayId)
    {
        $result = DB::table('daycare')->join('nicu_admission', 'nicu_admission.AdmissionId', '=', 'daycare.AdmissionId')
            ->leftjoin('delete_approval', 'delete_approval.ModuleId', '=', 'daycare.DayId')
            ->where('nicu_admission.NicuId', $nicuId)->where('daycare.DayId', $dayId)->where('delete_approval.ModuleName', 'Daycare Sheet')
            ->orderby('delete_approval.Id', 'desc')
            ->first();
        return $result;
    }

    /**
     * This will get the all the baby details to daycare create .
     *
     * @return array of object baby details.
     */
    public static function baby_list_daycare()
    {
        // $results = DB::table('baby')
        //               ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
        //               ->join('nicu_admission', 'nicu_admission.BabyId', '=', 'baby.BabyId')
        //               ->orderby('nicu_admission.BabyId','desc')
        //               ->get();
        // $results = \SiteHelpers::convert_obj_to_array($results->toArray());
        // $results = \SiteHelpers::unique_multidim_array($results, 'BabyId');
        // $results = \SiteHelpers::convert_array_to_object($results);
        $results = DB::table('baby')
        ->select('BabyName', 'nicu_admission.BMrNo', 'nicu_admission.BabyId')
        ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
            ->join('nicu_admission', 'nicu_admission.BabyId', '=', 'baby.BabyId')
            ->where('nicu_admission.status', 'Inpatient')
            ->orderby('nicu_admission.BabyId', 'desc')
            ->get()
            ->unique('BabyId')
            ->toArray();
        // echo "<pre>"; print_r($results); exit;
        return $results;
    }
}

