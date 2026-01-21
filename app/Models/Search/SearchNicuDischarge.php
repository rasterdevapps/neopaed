<?php
namespace App\Models\Search;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SearchNicuDischarge extends Model
{
    protected $nicu_fields = ['status', 'DischargeDate', 'diedTime', 'diedMins', 'diedAm', 'DOLatDischarge', 'g_weeks', 'g_days', 'dcg_weeks', 'dcg_days', 'DischargeWeight', 'OFC', 'Length', 'Immunization', 'Schedule', 'Vaccine', 'VaccineDate', 'additional_information', 'Eyes', 'cardiacmurmur', 'PostductalSaturation', 'discharge_femoral_pulses', 'Hips', 'gentila', 'gentila_findings', 'nicu_malformation', 'nicu_malformation_details', 'FeedingAtDischarge', 'NeurologicalStatus', 'NextAppointmentStatus', 'NextAppointment', 'NAT_TIME', 'NAT_MINS', 'NAT_AM', 'M_Drugs', 'm_generic_name', 'formulation', 'M_Dose', 'M_Frequency', 'M_Duration', 'DischargeHb', 'DischargePCV', 'NicuDCT', 'DischargeTSB', 'direct_bilirubin', 'DischargeSerumCa', 'DischargeSerumPo4', 'DischargeSerumALP', 'DischargeSerumNa', 'HomeOxygen', 'discharge_cuss', 'cranial_ultrasound', 'echocardiography_status', 'echocardiography', 'NicuNewBornScreen', 'HearingScreening', 'oae_left', 'oae_right', 'abr_left', 'abr_right', 'RopScreening', 'result_rop_left', 'result_rop_right', 'ROPTreatment', 'typeoftreatment_left', 'typeoftreatment_right', 'rop_follow_up', 'procedures', 'advice', 'plan_follow_up'];

    protected $nicuText = ['additional_information', 'gentila_findings', 'nicu_malformation_details', 'cranial_ultrasound', 'echocardiography', 'advice', 'plan_follow_up', 'NicuDCT'];

    protected $nicuSelecttext = ['status', 'Immunization', 'Schedule', 'Eyes', 'cardiacmurmur', 'discharge_femoral_pulses', 'nicu_malformation', 'FeedingAtDischarge', 'NeurologicalStatus', 'NextAppointmentStatus', 'HomeOxygen', 'discharge_cuss', 'echocardiography_status', 'NicuNewBornScreen', 'HearingScreening', 'oae_left', 'oae_right', 'abr_left', 'abr_right', 'RopScreening', 'result_rop_left', 'result_rop_right', 'ROPTreatment', 'Hips', 'gentila'];

    protected $nicuNumbers = ['DOLatDischarge', 'g_weeks', 'g_days', 'dcg_weeks', 'dcg_days', 'DischargeWeight', 'OFC', 'Length', 'PostductalSaturation', 'DischargeHb', 'DischargePCV', 'DischargeTSB', 'direct_bilirubin', 'DischargeSerumCa', 'DischargeSerumPo4', 'DischargeSerumALP', 'DischargeSerumNa', 'rop_follow_up'];

    protected $dateFields = ['DischargeDate', 'NextAppointment'];

    /**
     * This method to get array
     * of search for antenatal
     * ultrasound findings doppler Scan
     *
     * @var $ultrasound_doppler_scan
     */
    protected $jsonValues = ['Vaccine', 'VaccineDate', 'procedures', 'typeoftreatment_left', 'typeoftreatment_right'];

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
    protected $time_setting = ['died_time' => ['diedTime', 'diedMins', 'diedAm'], 'next_time_appoinment' => ['NAT_TIME', 'NAT_MINS', 'NAT_AM']];

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
            if ($data[$timevalues_value] != '' && !empty($timevalues_value))
            {
                $time_values[$timevalues_value] = $data[$timevalues_value];
            }
        }

        $nicuText = $this->nicuText;

        $nicuNumbers = $this->nicuNumbers;

        $nicuSelecttext = $this->nicuSelecttext;

        $dateFields = $this->dateFields;

        $time_fields = $this->timevalues;

        $results = array();

        if (count($filteredFields) > 0 || count($otherFields) > 0 || count($discharge_medication) > 0 || count($jsonvalue) > 0 || count($time_values) > 0)
        {

            \DB::enableQueryLog();

            $result = \DB::table('nicu_admission')
                ->select(\DB::raw('DISTINCT ON("nicu_admission"."NicuId") "nicu_admission"."NicuId"'))
                ->join('baby', 'baby.BabyId', '=', 'nicu_admission.BabyId')
                ->join('baby_admission', 'baby_admission.AdmissionId', '=', 'nicu_admission.AdmissionId')
                ->leftjoin('discharge_medications', function ($join)
            {
                $join->orOn('nicu_admission.AdmissionId', '=', 'discharge_medications.AdmissionId');
            })->where(['baby.IsDeleted' => 0, 'nicu_admission.IsDeleted' => 0, 'baby_admission.AdmissionType' => 'NICU'])
            ->where(function ($query) use ($nicuText, $nicuNumbers, $dateFields, $nicuSelecttext, $time_fields, $filteredFields, $otherFields, $discharge_medication, $jsonvalue, $time_values)
            {

                foreach ($filteredFields as $field => $fieldValue)
                {
                    if (in_array($field, $nicuText))
                    {
                        $condition = preg_replace('/[A-Z,a-z,0-9,\/,_,-]/', '', trim($fieldValue));
                        $formatedText = str_replace(trim($condition) , '', $fieldValue);
                        $query = $this->textsearch($field, $condition, $formatedText, $query, $fieldValue);
                    }
                    elseif (in_array($field, $nicuSelecttext))
                    {
                        $condition = preg_replace('/[A-Z,a-z,0-9,\/,-]/', '', trim($fieldValue));
                        $formatedText = str_replace(trim($condition) , '', $fieldValue);
                        $query = $this->textsearch($field, $condition, $formatedText, $query, $fieldValue);
                    }
                    elseif (in_array($field, $nicuNumbers))
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
            ->orderBy('nicu_admission.NicuId', 'desc');

            $temp_result = $result->get();

            $results['count'] = $temp_result->count();

            $results['very_first'] = isset($temp_result[0]) ? $temp_result[0]->NicuId : 0;
            $results['very_last'] = isset($temp_result[$results['count']-1]->NicuId) ? $temp_result[$results['count']-1]->NicuId : 0;

            $results['data'] = $result->limit($limitend)
            ->offset($limitstart)
            ->get();

            $query_log = \DB::getQueryLog();

            $last_log = end($query_log);
            $last_log['bindings'][] = $limitend;
            $last_log['bindings'][] = $limitstart;

            $last_log['bindings'] = "'".implode("','", $last_log['bindings'])."'";
            $last_log['search_module'] = 6;
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
                elseif ($column == 'status')
                {
                    $query->orWhereRaw('lower("nicu_admission"."status") like ' . "'%" . strtolower($value) . "%'");
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
                    $query->whereRaw('"'.$column .'" like \'%' . $value . '%\'');
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
                if ($column != 'g_weeks' && $column != 'g_days' && $column != 'dcg_weeks' && $column != 'dcg_days')
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
                if ($column != 'g_weeks' && $column != 'g_days' && $column != 'dcg_weeks' && $column != 'dcg_days')
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
                if ($table != '' && $column != 'g_weeks' && $column != 'g_days' && $column != 'dcg_weeks' && $column != 'dcg_days')
                {
                    $query->whereRaw('CAST (NULLIF("' . $table . '"."' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                }
                elseif ($table == '' && $column != 'g_weeks' && $column != 'g_days' && $column != 'dcg_weeks' && $column != 'dcg_days' && $column != 'PostductalSaturation' && $column != 'DischargeTSB' && $column != 'DischargeSerumCa' && $column != 'DischargeSerumPo4' && $column != 'DischargeSerumALP')
                {
                    $query->whereRaw('CAST (NULLIF("' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                }
                elseif ($table == '' && $column == 'g_weeks' || $column == 'g_days' && $column != 'dcg_weeks' && $column != 'dcg_days')
                {
                    $query->where($column, $operator, $value);
                }
                else
                {
                    $query->where($column, $operator, $value);
                }
            break;
            case '>=':
                if ($column != 'g_weeks' && $column != 'g_days' && $column != 'dcg_weeks' && $column != 'dcg_days')
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
                elseif (in_array($column, ['DischargeWeight', 'OFC', 'Length', 'PostductalSaturation', 'DischargeHb', 'DischargePCV', 'NicuDCT', 'DischargeTSB', 'direct_bilirubin', 'DischargeSerumCa', 'DischargeSerumPo4', 'DischargeSerumALP', 'DischargeSerumNa', 'dcg_weeks', 'dcg_days', 'DOLatDischarge']))
                {
                    $number_list = \DB::table('nicu_admission')->get();
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
                    $column = 'nicu_admission.' . $column;
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

                    $query->whereBetween('nicu_admission.AdmissionDate', [$startDate, $endDate]);
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
                elseif (in_array($column, ['AdmissionDate', 'DateofAdministration', 'NextAppointment', 'DischargeDate']))
                {

                    $dob_list = \DB::table('nicu_admission')->select($column)->where($column, '<>', null)->where('IsDeleted', 0)
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
                    $column = 'nicu_admission.' . $column;
                }

                $query->whereIn($column, $date_list);
            break;

            default:
                if ($column == 'AdmissionDate')
                {
                    $query->where('nicu_admission.AdmissionDate', date('Y-m-d', strtotime($value)));
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

        public function getListbyNicu($nicu_id)
        {
            return \DB::table('nicu_admission')->select('nicu_admission.* as na', 'baby_admission.* as ba', 'baby.* as bab')
                ->addSelect('nicu_admission.NicuId as nicu_id', 'baby.BMrNo as baby_mr')
                ->leftjoin('baby', 'baby.BabyId', '=', 'nicu_admission.BabyId')
                ->leftjoin('baby_admission', 'baby_admission.AdmissionId', '=', 'nicu_admission.AdmissionId')
                ->where(['baby.IsDeleted' => 0, 'nicu_admission.IsDeleted' => 0, 'baby_admission.AdmissionType' => 'NICU'])
                ->whereIn('nicu_admission.NicuId', $nicu_id)->orderBy('nicu_admission.NicuId', 'desc')
                ->get();

        }


        public function getData($nicu_id)
        {

            return \DB::table('nicu_admission')->select('nicu_admission.* as na', 'baby_admission.* as ba', 'baby.* as bab')
                ->addSelect('nicu_admission.NicuId as nicu_id', 'baby.BMrNo as baby_mr', 'nicu_admission.AdmissionTime as admission_time_hr', 'nicu_admission.status as patientStatus')
                ->join('baby', 'baby.BabyId', '=', 'nicu_admission.BabyId')
                ->join('baby_admission', 'baby_admission.AdmissionId', '=', 'nicu_admission.AdmissionId')
                ->where(['baby.IsDeleted' => 0, 'nicu_admission.IsDeleted' => 0, 'baby_admission.AdmissionType' => 'NICU'])
                ->where('nicu_admission.NicuId', $nicu_id)->first();

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
        public function getNicuSearchList($nicuId)
        {
            return \DB::table('nicu_admission')
                ->select(\DB::raw('DISTINCT ON("nicu_admission"."NicuId") "nicu_admission"."NicuId"'))
                ->addSelect('baby.*', 'mother.*', 'ip_numbers.ip_number', 'nicu_admission.status', 'DischargeDate', 'diedTime', 'diedMins', 'diedAm', 'DOLatDischarge', 'g_weeks', 'g_days', 'dcg_weeks', 'dcg_days', 'DischargeWeight', 'OFC', 'Length', 'Immunization', 'Schedule', 'Vaccine', 'VaccineDate', 'additional_information', 'Eyes', 'cardiacmurmur', 'PostductalSaturation', 'discharge_femoral_pulses', 'Hips', 'gentila', 'gentila_findings', 'nicu_malformation', 'nicu_malformation_details', 'FeedingAtDischarge', 'NeurologicalStatus', 'NextAppointmentStatus', 'NextAppointment', 'NAT_TIME', 'NAT_MINS', 'NAT_AM', 'DischargeHb', 'DischargePCV', 'NicuDCT', 'DischargeTSB', 'direct_bilirubin', 'DischargeSerumCa', 'DischargeSerumPo4', 'DischargeSerumALP', 'DischargeSerumNa', 'HomeOxygen', 'discharge_cuss', 'cranial_ultrasound', 'echocardiography_status', 'echocardiography', 'NicuNewBornScreen', 'HearingScreening', 'oae_left', 'oae_right', 'abr_left', 'abr_right', 'RopScreening', 'result_rop_left', 'result_rop_right', 'ROPTreatment', 'typeoftreatment_left', 'typeoftreatment_right', 'rop_follow_up', 'procedures', 'advice', 'plan_follow_up', 'nicu_admission.AdmissionId')
                ->leftjoin('baby', 'baby.BabyId', '=', 'nicu_admission.BabyId')
                ->leftjoin('mother', 'mother.MotherId', '=', 'baby.MotherId')
                ->leftjoin('baby_admission', 'baby_admission.AdmissionId', '=', 'nicu_admission.AdmissionId')
                ->leftjoin('ip_numbers', function ($join) {
                    $join->orOn('baby.BabyId', '=', 'ip_numbers.baby_id');
                })
                ->whereIn('nicu_admission.NicuId', $nicuId)
                ->orderby('NicuId', 'desc')
                ->get();
        }

}

