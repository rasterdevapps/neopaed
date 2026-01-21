<?php
namespace App\Models\Search;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SearchPostnatal extends Model
{
    protected $post_fields = ['BabyName', 'BMrNo', 'DOB', 'BirthWeight', 'BirthStatus', 'g_weeks', 'g_days', 'BabyBloodGroup', 'Sex', 'referredby', 'referralreason', 'cg_weeks', 'cg_days', 'admission_time', 'admission_date', 'typeofcare', 'ip_number', 'admission_wt', 'ageonadmissionindays', 'surgeon', 'seenby', 'admission_examination', 'admitted_from', 'major_complaints', 'ventilation', 'mode', 'pip', 'peep', 'amplitude', 'mean_airway_pressure', 'rate', 'it', 'fio2', 'flow', 'rr', 'nicu_retractions', 'nicu_airentry', 'chest_movement', 'hr', 'systolic_bp', 'diastolic_bp', 'mean_bp', 'nicu_central_pulses', 'nicu_peripheral_pulses', 'nicu_femoral_pulses', 's1s2', 'nicu_murmur', 'cft', 'nicu_color', 'temperature', 'nicu_abdomen', 'nicu_bowel_sounds', 'nicu_umbilicus', 'nicu_hepatomegaly', 'nicu_splenomegaly', 'nicu_herina', 'genitalia', 'genitalia_findings', 'nicu_pupils', 'nicu_pupils_findings', 'nicu_anteriorfontanelle', 'nicu_activity', 'tone', 'nicu_cry', 'nicu_seizures', 'nicu_neonatalreflexes', 'skin', 'abnormalities', 'initialbloodgas', 'agetaken', 'spo2', 'ph', 'pao2', 'paco2', 'hco3', 'be', 'rbs', 'hct', 'initialxray', 'xrayfindings', 'ageofcxr', 'uac_status', 'uac_position', 'uvc_status', 'uvc_position', 'sepsisscreen', 'indications', 'ivantibiotic', 'investigations', 'enteral_feeding', 'fluids', 'differentialdiagnosis', 'additional_diagnosis', 'plan', 'parents_spoken', 'pdiscussion', 'matters_discussed', 'parents_addressed_by', 'discharge_status', 'discharge_date', 'diedTime', 'diedMins', 'diedAm', 'discharge_dol', 'g_weeks', 'g_days', 'discharge_wt', 'discharge_ofc', 'discharge_length', 'discharge_immunization', 'schedule', 'vaccine', 'diagnosis', 'additional_information', 'discharge_eyes', 'discharge_cardiac_murmur', 'postductal_spo2', 'discharge_femorals', 'discharge_hips', 'discharge_gentila', 'discharge_gentila_findings', 'discharge_malinformation', 'malinformation_details', 'feeding_at_discharge', 'neourological_status', 'appoinment_status', 'appoinment_date', 'appoinment_hrs', 'appoinment_min', 'appoinment_session', 'M_Drugs', 'm_generic_name', 'formulation', 'M_Dose', 'M_Frequency', 'M_Duration', 'discharge_hb', 'discharge_pcv', 'discharge_dct', 'discharge_tsb', 'direct_bilirubin', 'dischargeserum_ca', 'dischargeserum_po4', 'dischargeserum_alp', 'dischargeserum_na', 'discharge_home_oxygen', 'discharge_cuss', 'cranial_ultrasound', 'echocardiography_status', 'echocardiography', 'background', 'discharge_new_born', 'discharge_hearing_screen', 'oae_left', 'oae_right', 'abr_left', 'abr_right', 'rop_screening_status', 'left_rop_left', 'left_rop_right', 'rop_treatment', 'typeoftreatment_left', 'typeoftreatment_right', 'rop_follow_up', 'procedures', 'advice', 'plan_follow_up'];

    protected $postText = ['BabyName', 'BMrNo', 'referredby', 'referralreason', 'ip_number', 'admission_examination', 'major_complaints', 'genitalia_findings', 'nicu_pupils_findings', 'skin', 'abnormalities', 'initialbloodgas', 'agetaken', 'xrayfindings', 'ageofcxr', 'uac_position', 'uvc_position', 'indications', 'investigations', 'fluids', 'differentialdiagnosis', 'plan', 'matters_discussed', 'parents_addressed_by', 'diagnosis', 'additional_information', 'discharge_gentila_findings', 'malinformation_details', 'cranial_ultrasound', 'echocardiography', 'background', 'advice', 'plan_follow_up', 'discharge_dct'];

    protected $postSelecttext = ['BirthStatus', 'BabyBloodGroup', 'Sex', 'admission_time_hour', 'admission_time_mins', 'admission_time_session', 'typeofcare', 'surgeon', 'seenby', 'admitted_from', 'ventilation', 'mode', 'nicu_retractions', 'nicu_airentry', 'chest_movement', 'nicu_central_pulses', 'nicu_peripheral_pulses', 'nicu_femoral_pulses', 's1s2', 'nicu_murmur', 'cft', 'nicu_color', 'nicu_abdomen', 'nicu_bowel_sounds', 'nicu_umbilicus', 'nicu_hepatomegaly', 'nicu_splenomegaly', 'nicu_herina', 'genitalia', 'nicu_pupils', 'nicu_anteriorfontanelle', 'nicu_activity', 'tone', 'nicu_cry', 'nicu_seizures', 'nicu_neonatalreflexes', 'initialxray', 'uac_status', 'uvc_status', 'sepsisscreen', 'ivantibiotic', 'enteral_feeding', 'parents_spoken', 'pdiscussion_hrs', 'pdiscussion_min', 'pdiscussion_session', 'discharge_status', 'discharge_immunization', 'schedule', 'discharge_eyes', 'discharge_cardiac_murmur', 'discharge_femorals', 'discharge_malinformation', 'feeding_at_discharge', 'neourological_status', 'appoinment_status', 'discharge_home_oxygen', 'discharge_cuss', 'echocardiography_status', 'discharge_new_born', 'discharge_hearing_screen', 'oae_left', 'oae_right', 'abr_left', 'abr_right', 'rop_screening_status', 'left_rop_left', 'left_rop_right', 'rop_treatment', 'discharge_hips', 'discharge_gentila'];

    protected $postNumbers = ['BirthWeight', 'g_weeks', 'g_days', 'cg_weeks', 'cg_days', 'admission_wt', 'ageonadmissionindays', 'pip', 'peep', 'amplitude', 'mean_airway_pressure', 'rate', 'it', 'fio2', 'flow', 'rr', 'hr', 'systolic_bp', 'diastolic_bp', 'mean_bp', 'temperature', 'spo2', 'ph', 'pao2', 'paco2', 'hco3', 'be', 'rbs', 'hct','discharge_dol', 'g_weeks', 'g_days', 'discharge_wt', 'discharge_ofc', 'discharge_length', 'postductal_spo2', 'discharge_hb', 'discharge_pcv', 'discharge_tsb', 'direct_bilirubin', 'dischargeserum_ca', 'dischargeserum_po4', 'dischargeserum_alp', 'dischargeserum_na', 'rop_follow_up'];

    protected $dateFields = ['DOB', 'admission_date', 'discharge_date', 'appoinment_date'];

    /**
     * This method to get array
     * of search for antenatal
     * ultrasound findings doppler Scan
     *
     * @var $ultrasound_doppler_scan
     */
    protected $jsonValues = ['vaccine', 'procedures', 'typeoftreatment_left', 'typeoftreatment_right'];

    /**
     * This method to get array
     * of search for antenatal
     * ultrasound findings doppler Scan
     *
     * @var $ultrasound_doppler_scan
     */
    protected $medication = ['M_Drugs', 'm_generic_name', 'formulation', 'M_Dose', 'M_Frequency', 'M_Duration'];

    /**
     * This method to get neonatal
     * pro forma search data
     *  1 or 2
     */
    protected $timevalues = ['died_time', 'next_time_appoinment'];
    /**
     * This method to get neonatal
     * pro forma search data
     *  1 or 2
     */
    protected $time_setting = ['died_time' => ['diedTime', 'diedMins', 'diedAm'], 'next_time_appoinment' => ['appoinment_hrs', 'appoinment_min', 'appoinment_session']];

    public function getList($page = 1, $limit = 5, $data = array() , $order = array())
    {
        $limitstart = (empty($page) || $page == 1) ? 0 : (($page - 1) * $limit);
        $limitend = $limit;

        $otherFields = $filteredFields = [];
        $jsonvalue = $discharge_medication = $time_values = [];

        unset($data['temp_Vaccine']);
        unset($data['temp_drugs']);
        unset($data['temp_frequency']);
        unset($data['temp_does']);
        unset($data['temp_duration']);
        unset($data['temp_procedures']);

        foreach ($data as $key => $value)
        {
            if (isset($data[$key]) && !is_array($data[$key]) && !empty(trim($data[$key])))
            {
                $filteredFields[$key] = $value;
            }
            elseif (isset($data[$key]) && is_array($data[$key]))
            {
                foreach ($value as $key1 => $value1)
                {
                    if (!empty($value1) && $value1 != 'N/A')
                    {
                        $otherFields[$key][] = $value1;
                    }
                }
            }
        }

        foreach ($this->medication as $medication_key => $medication_value)
        {
            $temp_array = [];
            if (isset($data[$medication_value]) && is_array($data[$medication_value]))
            {
                for ($medicationIndex = 0;$medicationIndex < count($data[$medication_value]);$medicationIndex++)
                {
                    if (!empty(trim($data[$medication_value][$medicationIndex])) && $data[$medication_value][$medicationIndex] != "N/A" && $data[$medication_value][$medicationIndex] != 0)
                    {
                        $temp_array['discharge_medications.Medication'] = (int)$data['M_Drugs'][$medicationIndex];
                        $temp_array['discharge_medications.genericname'] = isset($data['m_generic_name'][$medicationIndex]) ? $data['m_generic_name'][$medicationIndex] : '';
                        $temp_array['discharge_medications.formulation'] = (isset($data['formulation'][$medicationIndex]) && $data['formulation'][$medicationIndex] != '' && $data['formulation'][$medicationIndex] != 0) ? $data['formulation'][$medicationIndex] : '';
                        $temp_array['discharge_medications.Dose'] = (isset($data['M_Dose'][$medicationIndex]) && $data['M_Dose'][$medicationIndex] != '') ? $data['M_Dose'][$medicationIndex] : '';
                        $temp_array['discharge_medications.Frequency'] = (isset($data['M_Frequency'][$medicationIndex]) && $data['M_Frequency'][$medicationIndex] != '') ? $data['M_Frequency'][$medicationIndex] : '';
                        $temp_array['discharge_medications.Duration'] = (isset($data['M_Duration'][$medicationIndex]) && $data['M_Duration'][$medicationIndex] != '') ? $data['M_Duration'][$medicationIndex] : '';
                        $discharge_medication[] = $temp_array;
                    }
                }
            }
        }

        //This for json values
        foreach ($this->jsonValues as $jsonValues_key => $jsonValues_value)
        {
            if (isset($data[$jsonValues_value]))
            {
                foreach ($data[$jsonValues_value] as $json_drugs)
                {
                    if (!empty($json_drugs) && $json_drugs != '' && $json_drugs != 'N/A')
                    {
                        $jsonvalue[$jsonValues_value][] = $json_drugs;
                    }
                }
            }
        }

        foreach ($this->timevalues as $timevalues_key => $timevalues_value)
        {
            if (isset($data[$timevalues_value]) && $data[$timevalues_value] != '' && !empty($timevalues_value))
            {
                $time_values[$timevalues_value] = $data[$timevalues_value];
            }
        }

        $postText = $this->postText;

        $postNumbers = $this->postNumbers;

        $postSelecttext = $this->postSelecttext;

        $dateFields = $this->dateFields;

        $time_fields = $this->timevalues;

        $results = array();

        if (count($filteredFields) > 0 || count($otherFields) > 0 || count($discharge_medication) > 0 || count($jsonvalue) > 0 || count($time_values) > 0)
        {

            \DB::enableQueryLog();

            $result = \DB::table('postnatal_discharge')
            ->select(\DB::raw('DISTINCT ON("postnatal_discharge"."posdisid") "postnatal_discharge"."posdisid"'))
            ->leftjoin('postnatal_admission', 'postnatal_discharge.posdisid', 'postnatal_admission.pid')
            ->leftjoin('baby', 'baby.BabyId', '=', 'postnatal_discharge.BabyId')
            ->leftjoin('baby_admission', 'baby_admission.AdmissionId', '=', 'postnatal_discharge.AdmissionId')
            ->leftjoin('discharge_medications', function ($join) {
                $join->orOn('postnatal_discharge.AdmissionId', '=', 'discharge_medications.AdmissionId');
            })
            ->where(['baby.IsDeleted' => 0, 'postnatal_discharge.IsDeleted' => 0, 'baby_admission.AdmissionType' => 'Post'])
            ->where(function ($query) use ($postText, $postNumbers, $dateFields, $postSelecttext, $time_fields, $filteredFields, $otherFields, $discharge_medication, $jsonvalue, $time_values) {
                foreach ($filteredFields as $field => $fieldValue)
                {
                    if (in_array($field, $postText))
                    {
                        if ($field == 'BMrNo') {
                            $field = 'postnatal_discharge.BMrNo';
                        }
                        $condition = preg_replace('/[A-Z,a-z,0-9,\/,_,-]/', '', trim($fieldValue));
                        $formatedText = str_replace(trim($condition) , '', $fieldValue);
                        $query = $this->textsearch($field, $condition, $formatedText, $query, $fieldValue);
                    }
                    elseif (in_array($field, $postSelecttext))
                    {
                        $condition = preg_replace('/[A-Z,a-z,0-9,\/,-]/', '', trim($fieldValue));
                        $formatedText = str_replace(trim($condition) , '', $fieldValue);
                        $query = $this->textsearch($field, $condition, $formatedText, $query, $fieldValue);
                    }
                    elseif (in_array($field, $postNumbers))
                    {
                        $condition = preg_replace('/[0-9,-]/', '', trim($fieldValue));
                        $formatedText = str_replace(trim($condition) , '', $fieldValue);
                        $query = $this->numbersearch($field, $condition, $formatedText, $query, $fieldValue);
                    }
                    elseif (in_array($field, $dateFields))
                    {
                        $condition = preg_replace('/[0-9,-,\/,:]/', '', trim($fieldValue));
                        $formatedText = str_replace(trim($condition) , '', $fieldValue);
                        $query = $this->datesearch($field, $condition, $formatedText, $query, $fieldValue);
                    }
                }

                if (count($discharge_medication) > 0)
                {
                    foreach ($discharge_medication as $discharge_medication_key => $discharge_medication_value)
                    {
                        foreach ($discharge_medication_value as $discharge_medication_value_key => $discharge_medication_value_values)
                        {
                            $operator = preg_replace('/[A-Z,a-z,0-9,-,\/,:,.]/', '', trim($discharge_medication_value_values));
                            $un_splited_value = $discharge_medication_value_values;
                            $discharge_medication_value_values = str_replace(trim($operator) , '', $discharge_medication_value_values);

                            if ($discharge_medication_value_key == 'discharge_medications.genericname' && trim($discharge_medication_value_values) != '')
                            {
                                $query = $this->textsearch($discharge_medication_value_key, $operator, $discharge_medication_value_values, $query);
                            }
                            elseif (trim($discharge_medication_value_values) != '' && trim($discharge_medication_value_values) != 0)
                            {
                                $query->where($discharge_medication_value_key, $discharge_medication_value_values);
                            }
                        }
                    }
                }

                if (count($jsonvalue) > 0)
                {
                    foreach ($jsonvalue as $jsonvalue_key => $jsonvalue_value)
                    {
                        foreach ($jsonvalue_value as $drugs_key => $drugs_value)
                        {
                            if ($jsonvalue_key == 'procedures' || $jsonvalue_key == 'typeoftreatment_left' || $jsonvalue_key == 'typeoftreatment_right')
                            {
                                $query->whereJsonContains($jsonvalue_key, $drugs_value);
                            }
                            else
                            {
                                $query->where($jsonvalue_key, 'like', '%"' . $drugs_value . '"%');
                            }
                        }
                        $query->whereNotNull($jsonvalue_key);
                    }
                }

                foreach ($time_values as $time_values_key => $time_values_time)
                {
                    if (in_array($time_values_key, $time_fields))
                    {
                        $operator = preg_replace('/[A-Z,a-z,0-9,:]/', '', trim($time_values_time));
                        $un_splited_value = trim($time_values_time);
                        $time_values_time = str_replace($operator, '', trim($time_values_time));

                        $time_values_time = explode(':', $time_values_time);

                        $time_values_time[0] = ltrim($time_values_time[0], "0");
                        $time_values_time[1] = ltrim($time_values_time[1], "0");

                        $time_values_time = implode(':', $time_values_time);

                        if ($time_values_key != 'admission_time')
                        {
                            $this->timesearch($time_values_key, $operator, $time_values_time, $query, $un_splited_value);
                        }
                    }
                }

            })
            ->orderBy('postnatal_discharge.posdisid', 'desc');

            $temp_result = $result->get();

            $results['count'] = $temp_result->count();

            $results['very_first'] = isset($temp_result[0]) ? $temp_result[0]->posdisid : 0;
            $results['very_last'] = isset($temp_result[$results['count']-1]->posdisid) ? $temp_result[$results['count']-1]->posdisid : 0;

            $results['data'] = $result->limit($limitend)->offset($limitstart)->get();

            $query_log = \DB::getQueryLog();

            $last_log = end($query_log);
            $last_log['bindings'][] = $limitend;
            $last_log['bindings'][] = $limitstart;

            $last_log['bindings'] = "'" . implode("','", $last_log['bindings']) . "'";
            $last_log['search_module'] = 7;
            $results['query_log_id'] = SearchQueryLog::create($last_log)->id;
            \DB::flushQueryLog();

        }

        return $results;

    }

    /**
     * This method to get text
     * search
     *
     * @param $column type text
     *
     * @param $operator type text
     *
     * @param $value type text
     *
     * @param $query type object
     *
     * @param $un_splited_value text
     *
     * @return object of query builder
     */
    public function textsearch($column, $operator, $value, $query, $un_splited_value = '')
    {
        $operator = trim($operator);
        $column = trim($column);

        switch ($operator)
        {
            case '=':
            if ($column == 'discharge_medications.genericname')
            {
                $column1 = explode('.', $column);
                $query->orWhereRaw('rtrim(lower("' . $column1[0] . '"."' . $column1[1] . '")) like ' . "'%" . rtrim(strtolower($value)) . "%'");
            } 
            else
            {
                $query->whereRaw('rtrim(lower("' . $column . '")) like ' . "'% " . rtrim(strtolower($value)) . " %'");
                $query->orWhereRaw('rtrim(lower("' . $column . '")) like ' . "'" . rtrim(strtolower($value)) . " %'");
                $query->orWhereRaw('rtrim(lower("' . $column . '")) like ' . "'% " . rtrim(strtolower($value)) . "'");
                $query->orWhereRaw('trim(lower("' . $column . '")) = ' . "'" . trim(strtolower($value)) . "'");
            }
            break;

            case '==':
            if ($column == 'discharge_medications.genericname')
            {
                $column1 = explode('.', $column);
                $query->whereRaw('rtrim(lower("' . $column1[0] . '"."' . $column1[1] . '")) = ' . "'" . rtrim(strtolower($value)) . "'");
            }
            else
            {
                $query->whereRaw('rtrim(lower("' . $column . '")) = ' . "'" . rtrim(strtolower($value)) . "'");
            }
            break;

            case '""':
            if ($column == 'discharge_medications.genericname')
            {
                $column1 = explode('.', $column);
                $query->orWhereRaw('rtrim(lower("' . $column1[0] . '"."' . $column1[1] . '")) like ' . "'%" . rtrim(strtolower($value)) . "%'");
            }
            else
            {
                $query->whereRaw('rtrim(lower("' . $column . '")) like ' . "'% " . rtrim(strtolower($value)) . "%'");
                $query->orWhereRaw('rtrim(lower("' . $column . '")) like ' . "'" . rtrim(strtolower($value)) . " %'");
                $query->orWhereRaw('trim(lower("' . $column . '")) = ' . "'" . trim(strtolower($value)) . "'");
            }
            break;

            case '*""':
            if ($column == 'discharge_medications.genericname')
            {
                $column1 = explode('.', $column);
                $query->whereRaw('rtrim(lower("' . $column1[0] . '"."' . $column1[1] . '")) like ' . "'%" . rtrim(strtolower($value)) . "%'");
            }
            else
            {
                $query->whereRaw('rtrim(lower("' . $column . '")) like ' . "'%" . rtrim(strtolower($value)) . "%'");
            }

            break;

            case '@':
            if ($column == 'discharge_medications.genericname')
            {
                $column1 = explode('.', $column);
                $charater_details = str_split($value);
                foreach ($charater_details as $character_key => $character_value)
                {
                    $query->orWhereRaw('lower("' . $column1[0] . '"."' . $column1[1] . '") like ' . "'%" . strtolower($character_value) . "%'");
                }
            }
            else
            {
                $charater_details = str_split($value);
                foreach ($charater_details as $character_key => $character_value)
                {
                    $query->orWhereRaw('lower("' . $column . '") like ' . "'%" . strtolower($character_value) . "%'");
                }
            }

            break;

            case '!':
            if ($column == 'discharge_medications.genericname')
            {
                $column1 = explode('.', $column);
                $query->orWhereRaw('"' . $column1[0] . '"."' . $column1[1] . '" like ' . "'" . $value . "%'");
            }
            else
            {
                $query->orWhereRaw('"' . $column . '" like ' . "'" . $value . "%'");
            }
            break;

            default:
            if ($column == 'discharge_medications.genericname')
            {
                $column1 = explode('.', $column);
                $query->orWhereRaw('lower("' . $column1[0] . '"."' . $column1[1] . '") like ' . "'%" . strtolower($value) . "%'");
            }
            elseif ($column == 'discharge_status')
            {
                $query->orWhereRaw('lower("postnatal_discharge"."discharge_status") like ' . "'%" . strtolower($value) . "%'");
            }
            elseif ($column == 'appoinment_status')
            {
                $query->orWhere($column, $value);
            }
            elseif ($column == 'postnatal_discharge.BMrNo')
            {
                $column1 = explode('.', $column);
                $query->orWhereRaw('lower("postnatal_discharge"."BMrNo") like ' . "'%" . strtolower($value) . "%'");
            }
            else
            {
                $query->orWhereRaw('lower("' . $column . '") like ' . "'%" . strtolower($value) . "%'");
            }

            break;
        }

        return $query;

    }

    /**
     * This method to get
     * seprate the oprator form text
     *
     * @param $value type string
     *
     * @param $query type object
     *
     * @param $column type string
     *
     * @return type array
     */
    public function numbersearch($column, $operator, $value, $query, $un_splited_value = '', $table = '')
    {

        $operator = trim($operator);
        switch ($operator)
        {
            case '=':
            if ($column == 'g_weeks')
            {
                $query->whereRaw("CAST(" . '"' . $column . '"' . "as text) like '%" . $value . "%'");
            }
            else
            {
                $query->whereRaw('"' . $column . '" like \'%' . $value . '%\'');
            }
            break;
            case '==':
            if ($column == 'Gestation')
            {
                $query->where('usg_finding.' . $column, $value);
            }
            else
            {
                $query->where($column, $value);
            }
            break;
            case '<':
            if ($column != 'g_weeks' && $column != 'g_days')
            {
                if ($table != '')
                {
                    $query->whereRaw('CAST (NULLIF("' . $table . '"."' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                }
                else
                {
                    $query->whereRaw('CAST (NULLIF("' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                }
            }
            else
            {
                $query->whereRaw("CAST(" . '"' . $column . '"' . "as text) " . $operator . "'" . $value . "'");
            }
            break;
            case '<=':
            if ($column != 'g_weeks' && $column != 'g_days')
            {
                if ($table != '')
                {
                    $query->whereRaw('CAST (NULLIF("' . $table . '"."' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                }
                else
                {
                    $query->whereRaw('CAST (NULLIF("' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                }
            }
            else
            {
                $query->whereRaw("CAST(" . '"' . $column . '"' . "as text) " . $operator . "'" . $value . "'");
            }
            break;
            case '>':
            if ($table != '' && $column != 'g_weeks' && $column != 'g_days')
            {
                $query->whereRaw('CAST (NULLIF("' . $table . '"."' . $column . '",' . "''" . ') as float) ' . $operator . $value);
            }
            elseif ($table == '' && $column != 'g_weeks' && $column != 'g_days' && $column != 'postductal_spo2' && $column != 'discharge_tsb' && $column != 'dischargeserum_ca' && $column != 'dischargeserum_po4' && $column != 'dischargeserum_alp')
            {
                $query->whereRaw('CAST (NULLIF("' . $column . '",' . "''" . ') as float) ' . $operator . $value);
            }
            elseif ($table == '' && $column == 'g_weeks' || $column == 'g_days')
            {
                $query->where($column, $operator, $value);
            }
            else
            {
                $query->where($column, $operator, $value);
            }
            break;
            case '>=':
            if ($column != 'g_weeks' && $column != 'g_days')
            {
                if ($table != '')
                {
                    $query->whereRaw('CAST (NULLIF("' . $table . '"."' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                }
                else
                {
                    $query->whereRaw('CAST (NULLIF("' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                }
            }
            else
            {
                $query->whereRaw("CAST(" . '"' . $column . '"' . "as text) " . $operator . "'" . $value . "'");
            }
            break;
            case '#':

            $value_list = array();

            if (in_array($column, ['g_weeks', 'g_days']))
            {
                $number_list = \DB::table('baby')->where('IsDeleted', 0)
                ->get();
                foreach ($number_list as $number_list_key => $number_list_value)
                {
                    $temp_values = (array)$number_list_value;
                    $numbers = preg_split('//', $temp_values[$column], -1, PREG_SPLIT_NO_EMPTY);
                    $input_numbers = preg_split('//', $value, -1, PREG_SPLIT_NO_EMPTY);
                    foreach ($input_numbers as $input_numbers_key => $input_numbers_value)
                    {
                        if (in_array($input_numbers_value, $numbers))
                        {
                            $value_list[] = $temp_values[$column];
                        }
                    }
                }
            }
            elseif (in_array($column, ['discharge_wt', 'discharge_ofc', 'discharge_length', 'postductal_spo2', 'discharge_hb', 'discharge_pcv', 'discharge_dct', 'discharge_tsb', 'direct_bilirubin', 'dischargeserum_ca', 'dischargeserum_po4', 'dischargeserum_alp', 'dischargeserum_na', 'discharge_dol']))
            {
                $number_list = \DB::table('postnatal_discharge')->get();
                foreach ($number_list as $number_list_key => $number_list_value)
                {
                    $temp_values = (array)$number_list_value;
                    $numbers = preg_split('//', $temp_values[$column], -1, PREG_SPLIT_NO_EMPTY);
                    $input_numbers = preg_split('//', $value, -1, PREG_SPLIT_NO_EMPTY);
                    foreach ($input_numbers as $input_numbers_key => $input_numbers_value)
                    {
                        if (in_array($input_numbers_value, $numbers))
                        {
                            $value_list[] = $temp_values[$column];
                        }
                    }
                }
                $column = 'postnatal_discharge.' . $column;
            }
            elseif (in_array($column, ['Gestation', 'Finding']))
            {
                $number_list = \DB::table('usg_finding')->where('flags', 1)
                ->get();
                foreach ($number_list as $number_list_key => $number_list_value)
                {
                    $temp_values = (array)$number_list_value;
                    $numbers = preg_split('//', $temp_values[$column], -1, PREG_SPLIT_NO_EMPTY);
                    $input_numbers = preg_split('//', $value, -1, PREG_SPLIT_NO_EMPTY);
                    foreach ($input_numbers as $input_numbers_key => $input_numbers_value)
                    {
                        if (in_array($input_numbers_value, $numbers))
                        {
                            $value_list[] = $temp_values[$column];
                        }
                    }
                }
                $column = 'usg_finding.' . $column;
            }
                // $valueList = array_unique($value_list);
            $query->whereIn($column, $valueList);
            break;
            case '...':
            $valueList = explode($operator, $un_splited_value);
            if ($column == 'Gestation')
            {
                $query->whereBetween('usg_finding.' . $column, $valueList);
            }
            else
            {
                $query->whereBetween($column, $valueList);
            }
            break;
            default:
            if ($column == 'Gestation')
            {
                $query->where('usg_finding.' . $column, $value);
            }
            else
            {
                $query->where($column, $value);
            }

            break;

        }

        return $query;

    }

    /**
     * This method to get date search
     *
     * @param $column type text
     *
     * @param $operator type text
     *
     * @param $value type date
     *
     * @param $query type object
     *
     * @param $un_splited_value type text
     *
     * @return $query object of query builder
     */
    public function datesearch($column, $operator, $value, $query, $un_splited_value = '')
    {
        $value = str_replace('/', '-', $value);
        $operator = str_replace('-', '', $operator);
        switch ($operator)
        {
            case '=':
            if (!empty($value))
            {
                $query->where($column, date('Y-m-d', strtotime($value)));
            }
            else
            {
                $query->whereNull($column);
            }
            break;

            case '==':
            $query->whereDate($column, date('Y-m-d', strtotime($value)));
            break;

            case '//':
            $query->whereDate($column, date('Y-m-d'));
            break;

            case '>':
            $query->where($column, '>', date('Y-m-d', strtotime($value)));
            break;

            case '>=':
            $query->where($column, '>=', date('Y-m-d', strtotime($value)));
            break;

            case '<':
            $query->where($column, '<', date('Y-m-d', strtotime($value)));
            break;

            case '<=':
            $query->where($column, '<', date('Y-m-d', strtotime($value)));
            break;

            case '...':

            $un_splited_value = explode('...', $un_splited_value);
            $startDate = date('Y-m-d', strtotime($un_splited_value[0]));
            $endDate = date('Y-m-d', strtotime($un_splited_value[1]));
            if ($column == 'AdmissionDate')
            {

                $query->whereBetween('postnatal_discharge.AdmissionDate', [$startDate, $endDate]);
            }
            else
            {
                $query->whereBetween($column, [$startDate, $endDate]);
            }
            break;

            case '?':
            $today = null;
            $today = date('Y-m-d', strtotime($today));
            $query->where($column, '=', $today);
            break;

            case '#':
            $value = (strlen($value) == 1 && $value < 10 && $value > 0) ? '0' . $value : $value;
            $date_list = array();

            if ($column == 'DOB')
            {

                $dob_list = \DB::table('baby')->where('IsDeleted', 0)
                ->get();
                foreach ($dob_list as $dob_key => $dob_value)
                {
                    $dob_content = explode('-', $dob_value->DOB);
                    if (in_array($value, $dob_content))
                    {
                        $date_list[] = $dob_value->DOB;
                    }
                }

            }
            elseif (in_array($column, ['TestDate', 'LMP', 'EDDbyUSG', 'EDDbyDates']))
            {

                $dob_list = \DB::table('neonatal_proforma')->where('IsDeleted', 0)
                ->get();
                foreach ($dob_list as $dob_key => $dob_value)
                {
                    $temp_dates = (array)$dob_value;
                    $dob_content = explode('-', $temp_dates[$column]);
                    if (in_array($value, $dob_content))
                    {
                        $date_list[] = $temp_dates[$column];
                    }
                }

            }
            elseif (in_array($column, ['PartnerDOB', 'MotherDOB']))
            {

                $dob_list = \DB::table('mother')->where('IsDeleted', 0)
                ->get();
                foreach ($dob_list as $dob_key => $dob_value)
                {
                    $temp_dates = (array)$dob_value;
                    $dob_content = explode('-', $temp_dates[$column]);
                    if (in_array($value, $dob_content))
                    {
                        $date_list[] = $temp_dates[$column];
                    }
                }
            }
            elseif (in_array($column, ['AdmissionDate', 'DateofAdministration', 'appoinment_date', 'discharge_date']))
            {

                $dob_list = \DB::table('postnatal_discharge')->select($column)->where($column, '<>', null)->where('IsDeleted', 0)
                ->get();

                foreach ($dob_list as $dob_key => $dob_value)
                {
                    $temp_dates = (array)$dob_value;
                    $dob_content = explode('-', $temp_dates[$column]);
                    if (in_array($value, $dob_content))
                    {
                        $date_list[] = $temp_dates[$column];
                    }
                }
                $column = 'postnatal_discharge.' . $column;
            }

            $query->whereIn($column, $date_list);
            break;

            default:
            if ($column == 'AdmissionDate')
            {
                $query->where('postnatal_discharge.AdmissionDate', date('Y-m-d', strtotime($value)));
            }
            else
            {
                $query->where($column, date('Y-m-d', strtotime($value)));
            }
            break;
        }

        return $query;

    }

    /**
     * This method to get
     * seprate the oprator form text
     *
     * @param $value type string
     *
     * @param $query type object
     *
     * @param $column type string
     *
     * @return type array
     */
    public function timesearch($column, $operator = ':', $value, $query, $un_splited_value = '', $table = '')
    {
        $operator = trim($operator);

        switch ($operator)
        {
            case '=':
            $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');
            if (isset($this->time_setting[$column]))
            {
                if ($table != '')
                {
                    for ($i = 0;$i < count($this->time_setting[$column]);$i++)
                    {
                        $this->time_setting[$column][$i] = str_replace($table . '.', '', $this->time_setting[$column][$i]);
                    }
                    $query->whereRaw('("' . $table . '"."' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                elseif ($column == 'discussion_time')
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                else
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');

                }
            }

            break;
            case '==':

            $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');

            if (isset($this->time_setting[$column]))
            {
                if ($table != '')
                {
                    for ($i = 0;$i < count($this->time_setting[$column]);$i++)
                    {
                        $this->time_setting[$column][$i] = str_replace($table . '.', '', $this->time_setting[$column][$i]);
                    }
                    $query->whereRaw('("' . $table . '"."' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][2] . '")::time ' . '=' . '\'' . $value . '\'');
                }
                else
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $this->time_setting[$column][2] . '")::time ' . '=' . '\'' . $value . '\'');

                }
            }
            break;
            case '<':
            $value = str_replace('<', '', $value);
            $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');

            if (isset($this->time_setting[$column]))
            {
                if ($table != '')
                {
                    for ($i = 0;$i < count($this->time_setting[$column]);$i++)
                    {
                        $this->time_setting[$column][$i] = str_replace($table . '.', '', $this->time_setting[$column][$i]);
                    }
                    $query->whereRaw('("' . $table . '"."' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                elseif ($column == 'DiscussionTime')
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                else
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');

                }
            }

            break;
            case '<=':
            $value = str_replace('<=', '', $value);
            $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');

            if (isset($this->time_setting[$column]))
            {
                if ($table != '')
                {
                    for ($i = 0;$i < count($this->time_setting[$column]);$i++)
                    {
                        $this->time_setting[$column][$i] = str_replace($table . '.', '', $this->time_setting[$column][$i]);
                    }
                    $query->whereRaw('("' . $table . '"."' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                elseif ($column == 'DiscussionTime')
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                else
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');

                }
            }

            break;
            case '>':

            $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');

            if (isset($this->time_setting[$column]))
            {
                if ($table != '')
                {
                    for ($i = 0;$i < count($this->time_setting[$column]);$i++)
                    {
                        $this->time_setting[$column][$i] = str_replace($table . '.', '', $this->time_setting[$column][$i]);
                    }
                    $query->whereRaw('("' . $table . '"."' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                elseif ($column == 'DiscussionTime')
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                else
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');

                }
            }

            break;
            case '>=':
            $value = str_replace('>=', '', $value);
            $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');

            if (isset($this->time_setting[$column]))
            {
                if ($table != '')
                {
                    for ($i = 0;$i < count($this->time_setting[$column]);$i++)
                    {
                        $this->time_setting[$column][$i] = str_replace($table . '.', '', $this->time_setting[$column][$i]);
                    }
                    $query->whereRaw('("' . $table . '"."' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                elseif ($column == 'DiscussionTime')
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                else
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');

                }
            }

            break;
            case '#':
            if (isset($this->time_setting[$column]))
            {
                foreach ($this->time_setting[$column] as $time_entry => $time_entry_value)
                {
                    if ($time_entry_value != 'DiscussionTime') $query->orWhere($time_entry_value, $value);
                    else $query->orWhere($time_entry_value, 'like', '%' . $value . '%');
                }
            }

            break;
            case '...':

            if (isset($this->time_setting[$column]))
            {

                $valueList = explode($operator, $un_splited_value);

                if (isset($valueList[0]) && isset($valueList[1]))
                {

                    $valueList[0] = Carbon::createFromFormat('h:i a', $valueList[0])->format('H:i:s');
                    $valueList[1] = Carbon::createFromFormat('h:i a', $valueList[1])->format('H:i:s');
                    sort($valueList);

                    if ($table != '')
                    {
                        for ($i = 0;$i < count($this->time_setting[$column]);$i++)
                        {
                            $this->time_setting[$column][$i] = str_replace($table . '.', '', $this->time_setting[$column][$i]);
                        }
                        $query->whereRaw('("' . $table . '"."' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][2] . '")::time between' . '\'' . $valueList[0] . '\' and ' . '\'' . $valueList[1] . '\'');
                    }
                    elseif ($column == 'DiscussionTime')
                    {
                        $query->whereRaw('("' . $this->time_setting[$column][0] . '")::time between' . '\'' . $valueList[0] . '\' and ' . '\'' . $valueList[1] . '\'');
                    }
                    else
                    {
                        $query->whereRaw('("' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $this->time_setting[$column][2] . '")::time between' . '\'' . $valueList[0] . '\' and ' . '\'' . $valueList[1] . '\'');
                    }
                }

            }

            break;
            default:
            $operator = '=';
                // $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');
            if (isset($this->time_setting[$column]))
            {
                if ($table != '')
                {
                    for ($i = 0;$i < count($this->time_setting[$column]);$i++)
                    {
                        $this->time_setting[$column][$i] = str_replace($table . '.', '', $this->time_setting[$column][$i]);
                    }
                    $query->whereRaw('("' . $table . '"."' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                elseif ($column == 'DiscussionTime')
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                else
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $this->time_setting[$column][2] . '") ' . $operator . '\'' . $value . '\'');
                }
            }
            break;

        }
        return $query;

    }

    public function getListbyPost($post_id)
    {
        return \DB::table('postnatal_discharge')
        ->select('postnatal_discharge.* as na', 'baby_admission.* as ba', 'baby.* as bab', 'postnatal_admission.*')
        ->addSelect('postnatal_discharge.posdisid as post_id', 'baby.BMrNo as baby_mr')
        ->leftjoin('postnatal_admission', 'postnatal_discharge.posdisid', 'postnatal_admission.pid')
        ->leftjoin('baby', 'baby.BabyId', '=', 'postnatal_discharge.BabyId')
        ->leftjoin('baby_admission', 'baby_admission.AdmissionId', '=', 'postnatal_discharge.AdmissionId')
        ->where(['baby.IsDeleted' => 0, 'postnatal_discharge.IsDeleted' => 0, 'baby_admission.AdmissionType' => 'Post'])
        ->whereIn('postnatal_discharge.posdisid', $post_id)
        ->orderBy('postnatal_discharge.posdisid', 'desc')
        ->get();

    }

    public function getData($post_id)
    {

        return \DB::table('postnatal_discharge')
        ->select('postnatal_discharge.* as na', 'baby_admission.* as ba', 'baby.* as bab', 'postnatal_admission.*')
        ->addSelect('postnatal_discharge.posdisid as post_id', 'baby.BMrNo as baby_mr', 'postnatal_discharge.discharge_status as patientStatus')
        ->leftjoin('postnatal_admission', 'postnatal_discharge.posdisid', 'postnatal_admission.pid')
        ->leftjoin('baby', 'baby.BabyId', '=', 'postnatal_discharge.BabyId')
        ->leftjoin('baby_admission', 'baby_admission.AdmissionId', '=', 'postnatal_discharge.AdmissionId')
        ->where(['baby.IsDeleted' => 0, 'postnatal_discharge.IsDeleted' => 0, 'baby_admission.AdmissionType' => 'Post'])
        ->where('postnatal_discharge.posdisid', $post_id)
        ->first();

    }

    public function getMedication($baby_id, $admission_id)
    {
        return \DB::table('discharge_medications')->where('BabyId', $baby_id)->where('AdmissionId', $admission_id)->get();

    }

    /**
        * This method get all the neonatal proforma
        * list
        *
        * @param $neonatal_ids type array
        */
    public function getPostSearchList($postId)
    {
        return \DB::table('postnatal_discharge')
        ->select(\DB::raw('DISTINCT ON("postnatal_discharge"."posdisid") "postnatal_discharge"."posdisid"'))
        ->addSelect('baby.*', 'mother.*', 'ip_numbers.ip_number', 'postnatal_discharge.discharge_status', 'discharge_date', 'diedTime', 'diedMins', 'diedAm', 'discharge_dol', 'g_weeks', 'g_days', 'discharge_wt', 'discharge_ofc', 'discharge_length', 'discharge_immunization', 'schedule', 'vaccine', 'diagnosis', 'additional_information', 'discharge_eyes', 'discharge_cardiac_murmur', 'postductal_spo2', 'discharge_femorals', 'discharge_hips', 'discharge_gentila', 'discharge_gentila_findings', 'discharge_malinformation', 'malinformation_details', 'feeding_at_discharge', 'neourological_status', 'appoinment_status', 'appoinment_date', 'appoinment_hrs', 'appoinment_min', 'appoinment_session', 'discharge_hb', 'discharge_pcv', 'discharge_dct', 'discharge_tsb', 'direct_bilirubin', 'dischargeserum_ca', 'dischargeserum_po4', 'dischargeserum_alp', 'dischargeserum_na', 'discharge_home_oxygen', 'discharge_cuss', 'cranial_ultrasound', 'echocardiography_status', 'echocardiography', 'discharge_new_born', 'discharge_hearing_screen', 'oae_left', 'oae_right', 'abr_left', 'abr_right', 'rop_screening_status', 'left_rop_left', 'left_rop_right', 'rop_treatment', 'typeoftreatment_left', 'typeoftreatment_right', 'rop_follow_up', 'procedures', 'advice', 'plan_follow_up', 'postnatal_discharge.AdmissionId', 'cgd','referredby','referralreason','admission_cg','admission_time_hour','admission_time_mins','admission_time_session','admission_date','typeofcare','admission_wt','ageonadmissionindays','surgeon','seenby','admitted_from','major_complaints','ventilation','mode','pip','peep','amplitude','mean_airway_pressure','rate','it','fio2','flow','rr','nicu_retractions','nicu_airentry','chest_movement','hr','systolic_bp','diastolic_bp','mean_bp','nicu_central_pulses','nicu_peripheral_pulses','nicu_femoral_pulses','s1s2','nicu_murmur','cft','nicu_color','temperature','nicu_abdomen','nicu_bowel_sounds','nicu_umbilicus','nicu_hepatomegaly','nicu_splenomegaly','nicu_herina','genitalia_findings','nicu_pupils_findings','nicu_anteriorfontanelle','nicu_activity','tone','nicu_cry','nicu_seizures','nicu_neonatalreflexes','skin','abnormalities','initialbloodgas','agetaken','spo2','ph','pao2','paco2','hco3','be','rbs','hct','initialxray','xrayfindings','ageofcxr','uac_status','uac_position','uvc_status','uvc_position','sepsisscreen','indications','ivantibiotic','investigations','fluids','enteral_feeding','differentialdiagnosis','additional_diagnosis','plan','parents_spoken','pdiscussion_hrs','pdiscussion_min','pdiscussion_session','matters_discussed','parents_addressed_by','admission_examination','nicu_pupils','genitalia')
        ->leftjoin('postnatal_admission', 'postnatal_discharge.posdisid', 'postnatal_admission.pid')
        ->leftjoin('baby', 'baby.BabyId', '=', 'postnatal_discharge.BabyId')
        ->leftjoin('mother', 'mother.MotherId', '=', 'baby.MotherId')
        ->leftjoin('baby_admission', 'baby_admission.AdmissionId', '=', 'postnatal_discharge.AdmissionId')
        ->leftjoin('ip_numbers', function ($join)
        {
            $join->orOn('baby.BabyId', '=', 'ip_numbers.baby_id');
        })
        ->whereIn('postnatal_discharge.posdisid', $postId)
        ->orderby('posdisid', 'desc')
        ->get();
    }

}

