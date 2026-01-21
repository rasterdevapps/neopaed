<?php
namespace App\Models\Search;

use Illuminate\Database\Eloquent\Model;

use App\Models\Search\SearchQueryLog;
use Carbon\Carbon;

class Pediatric extends Model
{
    protected $fields = ['BMrNo','BabyName','MotherName','DOB', 'Sex','referred_by','referral_reason','admission_date','admission_time','admission_time_mins','admission_time_am','type_of_care','ip_number','surgeon','pediatric_consultant','complaints','hopi','treatment_history','past_history','perinatal_history','immunization','development','family_history','stage','gpallor','ihm','cyanosis','clubby','glymphadenopathy','pedal_edema','general_examination','temperature_f','hr','rr','spo2','cft','pulse_volume','bp','vitals_content','current_weight','current_height','current_head_circumference','current_bmi','current_bsa','anthropometry_content','cvs','precordial_activity','s1s2','apical_impulse','murmur','character_of_murmur','cvs_findings','rs','chest_movement','air_entry','breath_sounds','added_sounds','character_of_added_sounds','site_of_added_sounds','rs_findings','cns_stage','eye_opening','verbal','motor','cn_meningeal_signs','cn_exam','ms_exam','ms_findings','deep_tendon','deep_tendon_findings','cns_findings','abdomen_status','skin_over_abdomen','palpation','liver','liver_palpation_value','spleen','spleen_palpation_value','external_genitalia','abdomen_findings','investigations','investigations_test','admission_entered_by','treatment','working_diagnosis','discussion_findings','treatment_findings','investigation_findings','status','status_date','status_weight','condition_at_discharge','verified_by','drug_name','dose','route','frequency','duration', 'review_details', 'discharge_findings', 'year', 'month', 'days'];

    protected $text = ['BMrNo','BabyName','MotherName','referred_by','referral_reason','ip_number','character_of_added_sounds','site_of_added_sounds'];

    protected $selecttext = ['Sex','admission_time','admission_time_mins','admission_time_am','type_of_care','surgeon','stage','gpallor','ihm','cyanosis','clubby','glymphadenopathy','pedal_edema','cft','current_weight','current_height','current_head_circumference','current_bmi','current_bsa','cvs','precordial_activity','s1s2','apical_impulse','murmur','character_of_murmur','rs','chest_movement','air_entry','breath_sounds','added_sounds','cn_meningeal_signs','cn_exam','ms_exam','deep_tendon','abdomen_status','skin_over_abdomen','palpation','liver','spleen','external_genitalia','admission_entered_by','status'];

    protected $numbers = ['temperature_f','hr','rr','spo2','pulse_volume','bp','liver_palpation_value','spleen_palpation_value','status_weight','eye_opening','verbal','motor', 'year', 'month', 'days'];

    protected $dateFields = ['DOB','admission_date','status_date'];

    protected $editor = ['complaints', 'hopi', 'treatment_history', 'past_history', 'perinatal_history', 'immunization', 'development', 'family_history', 'general_examination', 'vitals_content', 'anthropometry_content', 'cvs_findings', 'rs_findings', 'ms_findings', 'deep_tendon_findings', 'cns_findings', 'abdomen_findings', 'investigations_test', 'treatment', 'working_diagnosis', 'discussion_findings', 'treatment_findings', 'investigation_findings', 'condition_at_discharge', 'review_details', 'discharge_findings'];

    protected $boolean = ['palpation_soft', 'palpation_rigidity', 'palpation_guarding', 'palpation_tender', 'palpation_non_tender'];

    protected $jsonValues = ['pediatric_consultant', 'cns_stage', 'investigations'];

    protected $toggle = ['verified_by'];

    public function getList($page = 1, $limit = 5, $data = array(), $order = array())
    {
        $limitstart    = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend      = $limit;

        $otherFields = $filteredField  = [];
        $jsonvalue = $time_values = [];

        unset($data["pediatric_consultant_temp"]);
        unset($data["registrar_temp"]);

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

        $text = $this->text;

        $numbers = $this->numbers;

        $selecttext = $this->selecttext;

        $dateFields = $this->dateFields;

        $time_fields = $this->timevalues;

        $editor = $this->editor;

        $boolean = $this->boolean;

        $toggle = $this->toggle;

        $results = array();

        if (count($filteredFields) > 0 || count($otherFields) > 0 || count($jsonvalue) > 0  ||  count($time_values) > 0) {

            \DB::enableQueryLog();

            $result = \DB::table('pediatric_admission')
            ->leftjoin('baby', 'baby.BabyId', 'pediatric_admission.baby_id')
            ->leftjoin('baby_admission', 'baby_admission.AdmissionId', 'pediatric_admission.admission_id')
            ->where(['baby.IsDeleted' => '0', 'pediatric_admission.is_deleted' => 0])
            ->where(function ($query) use ($text, $numbers, $dateFields, $selecttext, $time_fields, $filteredFields, $otherFields, $jsonvalue, $time_values, $editor, $boolean, $toggle)
            {

                foreach ($filteredFields as $field => $fieldValue)
                {

                    if (in_array($field, $text))
                    {
                        $condition = preg_replace('/[A-Z,a-z,0-9,\/,_,-]/', '', trim($fieldValue));
                        $formatedText = str_replace(trim($condition) , '', $fieldValue);
                        $query = $this->textsearch($field, $condition, $formatedText, $query, $fieldValue);
                    }
                    elseif (in_array($field, $selecttext))
                    {
                        $condition = preg_replace('/[A-Z,a-z,0-9,\/,-]/', '', trim($fieldValue));
                        $formatedText = str_replace(trim($condition) , '', $fieldValue);
                        $query = $this->textsearch($field, $condition, $formatedText, $query, $fieldValue);

                    }
                    elseif (in_array($field, $numbers))
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
                    elseif (in_array($field, $editor))
                    {
                        $fieldValue = strip_tags($fieldValue);
                        $condition = preg_replace('/[A-Z,a-z,0-9,\/,_,-]/', '', trim($fieldValue));
                        $formatedText = str_replace(trim($condition) , '', $fieldValue);
                        $query = $this->textsearch($field, $condition, $formatedText, $query, $fieldValue);
                    }
                    elseif (in_array($field, $boolean))
                    {
                        $fieldValue = !empty($fieldValue) ? true : null;
                        $query->where($field, $fieldValue);
                    }
                    elseif (in_array($field, $toggle))
                    {
                        if ($fieldValue == 'on') {
                            $query->whereNotNull($field);
                            $query->where($field,'>',0);
                        }
                    }

                }

                if (count($otherFields) > 0)
                {
                    foreach ($otherFields as $field => $fieldValue)
                    {
                        if ($field == 'drug_name' || $field == 'dose' || $field == 'route' || $field == 'frequency' || $field == 'duration')
                        {
                            if ($fieldValue != 'drug_name' && $fieldValue != 'dose' && $fieldValue != 'route' && $fieldValue != 'frequency' && $fieldValue != 'duration')
                            {
                                foreach ($fieldValue as $drugs_key => $drugs_value)
                                {
                                    $query->whereRaw('trim(lower("discharge_medications")) like ' . "'%" . trim(strtolower($drugs_value)) . "%'");
                                }
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
                            $query->where($jsonvalue_key, 'like', '%"' . $drugs_value . '"%');

                        }
                        $query->whereNotNull($jsonvalue_key);
                    }
                }

            })
            ->orderBy('pediatric_admission.id', 'desc');

            $temp_result = $result->get();

            $results['count'] = $temp_result->count();
            $results['very_first'] = isset($temp_result[0]) ? $temp_result[0]->id : 0;
            $results['very_last'] = isset($temp_result[$results['count']-1]->id) ? $temp_result[$results['count']-1]->id : 0;

            $results['data'] = $result->limit($limitend)
            ->offset($limitstart)
            ->get();

            $query_log = \DB::getQueryLog();

            $last_log = end($query_log);
            $last_log['bindings'][] = $limitend;
            $last_log['bindings'][] = $limitstart;

            $last_log['bindings'] = "'".implode("','", $last_log['bindings'])."'";
            $last_log['search_module'] = 5;
            $results['query_log_id'] = SearchQueryLog::create($last_log)->id;
            \DB::flushQueryLog();

        }
        return $results;

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
                    if ($time_entry_value != 'DiscussionTime') $query->where($time_entry_value, $value);
                    else $query->where($time_entry_value, 'like', '%' . $value . '%');
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

        }

        return $query;

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
                if ($column == 'BMrNo')
                {
                    $query->where('baby.BMrNo', 'like', '%' . $value . '%');
                }
                else
                {
                    $query->whereRaw('rtrim(lower("' . $column . '")) like ' . "'% " . rtrim(strtolower($value)) . " %'");
                    // $query->orWhereRaw('rtrim(lower("' . $column . '")) like ' . "'" . rtrim(strtolower($value)) . " %'");
                    // $query->orWhereRaw('rtrim(lower("' . $column . '")) like ' . "'% " . rtrim(strtolower($value)) . "'");
                    // $query->orWhereRaw('trim(lower("' . $column . '")) = ' . "'" . trim(strtolower($value)) . "'");
                }
                break;

                case '==':
                if ($column == 'BMrNo')
                {
                    $query->where('baby.BMrNo', $value);
                }
                else
                {
                    $query->whereRaw('rtrim(lower("' . $column . '")) = ' . "'" . rtrim(strtolower($value)) . "'");
                }
                break;

                case '""':
                if ($column == 'BMrNo')
                {
                    $query->where('baby.BMrNo', 'like', '%' . $value . '%');
                }
                else
                {
                    $query->whereRaw('rtrim(lower("' . $column . '")) like ' . "'% " . rtrim(strtolower($value)) . "%'");
                    $query->whereRaw('rtrim(lower("' . $column . '")) like ' . "'" . rtrim(strtolower($value)) . " %'");
                    $query->whereRaw('trim(lower("' . $column . '")) = ' . "'" . trim(strtolower($value)) . "'");

                }
                break;

                case '*""':
                if ($column == 'BMrNo')
                {
                    $query->whereRaw('rtrim(lower("baby"."BMrNo")) like ' . "'%" . rtrim(strtolower($value)) . "%'");
                }
                else
                {
                    $query->whereRaw('rtrim(lower("' . $column . '")) like ' . "'%" . rtrim(strtolower($value)) . "%'");
                }

                break;

                case '@':
                if ($column == 'BMrNo')
                {
                    $charater_details = str_split($value);
                    foreach ($charater_details as $character_key => $character_value)
                    {
                        $query->whereRaw('lower("baby"."BMrNo") like ' . "'%" . strtolower($character_value) . "%'");
                    }
                }
                else
                {
                    $charater_details = str_split($value);
                    foreach ($charater_details as $character_key => $character_value)
                    {
                        $query->whereRaw('lower("' . $column . '") like ' . "'%" . strtolower($character_value) . "%'");
                    }
                }

                break;

                case '!':
                if ($column == 'BMrNo')
                {
                    $query->whereRaw('"baby"."BMrNo" like ' . "'" . $value . "%'");
                }
                else
                {
                    $query->whereRaw('"' . $column . '" like ' . "'" . $value . "%'");
                }
                break;

                default:
                if ($column == 'BMrNo')
                {
                    $query->whereRaw('trim(lower("baby"."' . $column . '")) = ' . "'" . trim(strtolower($un_splited_value)) . "'");
                }
                elseif ($column == 'Sex')
                {
                    $query->whereRaw('trim(lower("' . $column . '")) = ' . "'" . trim(strtolower($value)) . "'");
                }
                elseif ($column == 'status')
                {
                    $query->whereRaw('lower("pediatric_admission"."status") like ' . "'%" . strtolower($value) . "%'");
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
                if ($column == 'Gestation')
                {
                    $query->where('usg_finding.' . $column, $value);
                }
                elseif ($column == 'g_weeks')
                {
                    $query->whereRaw("CAST(" . '"' . $column . '"' . "as text) like '%" . $value . "%'");
                }
                elseif ($column == 'Dose')
                {
                    $query->where('pediatric_admission.' . $column, $value);
                }
                elseif ($column == 'air_flow' || $column == 'oxgen_flow')
                {
                    $query->where($column, $value);
                }
                else
                {
                    $query->where($column, 'like', "'%" . $value . "%'");
                }
                break;
                case '==':
                if ($column == 'Gestation')
                {
                    $query->where('usg_finding.' . $column, $value);
                }
                elseif ($column == 'Dose')
                {
                    $query->where('pediatric_admission.' . $column, $value);
                }
                else
                {
                    $query->where($column, $value);
                }
                break;
                case '<':
                if ($column != 'g_weeks' && $column != 'g_days' && $column != 'cg_weeks' && $column != 'cg_days' && $column != 'dcg_weeks' && $column != 'dcg_days' && $column != 'Dose' && $column != 'air_flow' && $column != 'oxgen_flow' && $column != 'diastolic_bp')
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
                elseif ($column == 'Dose')
                {
                    $table = 'pediatric_admission';
                    $query->whereRaw('CAST (NULLIF("' . $table . '"."' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                }
                else
                {
                    $query->whereRaw("CAST(" . '"' . $column . '"' . "as text) " . $operator . "'" . $value . "'");
                }
                break;
                case '<=':
                if ($column != 'g_weeks' && $column != 'g_days' && $column != 'cg_weeks' && $column != 'cg_days' && $column != 'dcg_weeks' && $column != 'dcg_days' && $column != 'Dose' && $column != 'air_flow' && $column != 'oxgen_flow' && $column != 'diastolic_bp')
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
                elseif ($column == 'Dose')
                {
                    $table = 'pediatric_admission';
                    $query->whereRaw('CAST (NULLIF("' . $table . '"."' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                }
                else
                {
                    $query->whereRaw("CAST(" . '"' . $column . '"' . "as text) " . $operator . "'" . $value . "'");
                }
                break;
                case '>':
                if ($table != '' && $column != 'g_weeks' && $column != 'g_days' && $column != 'cg_weeks' && $column != 'cg_days' && $column != 'dcg_weeks' && $column != 'dcg_days' && $column != 'Dose')
                {
                    $query->whereRaw('CAST (NULLIF("' . $table . '"."' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                }
                elseif ($table == '' && $column != 'g_weeks' && $column != 'g_days' && $column != 'cg_weeks' && $column != 'cg_days' && $column != 'dcg_weeks' && $column != 'dcg_days' && $column != 'Dose' && $column != 'air_flow' && $column != 'oxgen_flow' && $column != 'diastolic_bp')
                {
                    $query->whereRaw('CAST (NULLIF("' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                }
                elseif ($table == '' && $column == 'g_weeks' || $column == 'g_days' && $column == 'cg_weeks' && $column == 'cg_days' && $column != 'dcg_weeks' && $column != 'dcg_days')
                {
                    $query->where($column, $operator, $value);
                }
                elseif ($column == 'Dose')
                {
                    $table = 'pediatric_admission';
                    $query->whereRaw('CAST (NULLIF("' . $table . '"."' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                }
                else
                {
                    $query->where($column, $operator, $value);
                }
                break;
                case '>=':
                if ($column != 'g_weeks' && $column != 'g_days' && $column != 'cg_weeks' && $column != 'cg_days' && $column != 'dcg_weeks' && $column != 'dcg_days' && $column != 'Dose' && $column != 'air_flow' && $column != 'oxgen_flow' && $column != 'diastolic_bp')
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
                elseif ($column == 'Dose')
                {
                    $table = 'pediatric_admission';
                    $query->whereRaw('CAST (NULLIF("' . $table . '"."' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                }
                else
                {
                    $query->whereRaw("CAST(" . '"' . $column . '"' . "as text) " . $operator . "'" . $value . "'");
                }
                break;
                case '#':

                $value_list = array();

                if (in_array($column, ['g_weeks', 'g_days', 'BirthWeight']))
                {
                    $number_list = \DB::table('baby')->where('IsDeleted', '0')
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
                elseif (in_array($column, ['MothercYear', 'PartnercYear']))
                {
                    $number_list = \DB::table('mother')->where('IsDeleted', 0)
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
                elseif (in_array($column, ['duration_in_weeks']))
                {
                    $number_list = \DB::table('complications')->get();
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
                elseif (in_array($column, ['AdmissionWt', 'AgeOnAdmissioninDays', 'AgeOnAdmissionhour', 'Dose', 'AgeAfterBirth', 'air_flow', 'oxgen_flow', 'TransferFiO2', 'Pip', 'PEEP', 'mean_airway_pressure', 'Rate', 'IT', 'Fio2', 'Flow_l_min', 'RR', 'HR', 'BP', 'diastolic_bp', 'MeanBP', 'Temperature', 'AgeTaken', 'SpO2', 'pH', 'PaO2', 'PaCo2', 'HCO3', 'BE', 'RBS', 'Hct', 'SexBirthWtGestation', 'TemperatureAtAdmission', 'BaseExcess', 'TotalCRIB2Score', 'amplitude_delta', 'Fluids', 'TotalSNAP2Score', 'TotalSNAPPE2Score', 'DischargeWeight', 'OFC', 'Length', 'PostductalSaturation', 'DischargeHb', 'DischargePCV', 'NicuDCT', 'DischargeTSB', 'direct_bilirubin', 'DischargeSerumCa', 'DischargeSerumPo4', 'DischargeSerumALP', 'DischargeSerumNa', 'cg_weeks', 'cg_days', 'dcg_weeks', 'dcg_days', 'DOLatDischarge']))
                {
                    $number_list = \DB::table('pediatric_admission')->get();
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
                    $column = 'pediatric_admission.' . $column;
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
                $query->whereIn($column, $valueList);
                break;
                case '...':
                $valueList = explode($operator, $un_splited_value);
                if ($column == 'Gestation')
                {
                    $query->whereBetween('usg_finding.' . $column, $valueList);
                }
                elseif ($column == 'Dose')
                {
                    $query->whereBetween('pediatric_admission.' . $column, $valueList);
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

                    $query->whereBetween('pediatric_admission.AdmissionDate', [$startDate, $endDate]);
                }
                else
                {
                    $query->whereBetween($column, [$startDate, $endDate]);
                }
                break;

                case '?':
                $today = null;
                $today = date('Y-m-d', strtotime($today));
                $query->where($column, $today);
                break;

                case '#':
                $value = (strlen($value) == 1 && $value < 10 && $value > 0) ? '0' . $value : $value;
                $date_list = array();

                if ($column == 'DOB')
                {

                    $dob_list = \DB::table('baby')->where('IsDeleted', '0')
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

                    $dob_list = \DB::table('pediatric_admission')->select($column)->where($column, '<>', null)->where('IsDeleted', 0)
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
                    $column = 'pediatric_admission.' . $column;
                }

                $query->whereIn($column, $date_list);
                break;

                default:
                if ($column == 'AdmissionDate')
                {
                    $query->where('pediatric_admission.AdmissionDate', date('Y-m-d', strtotime($value)));
                }
                else
                {
                    $query->where($column, date('Y-m-d', strtotime($value)));
                }
                break;
            }

            return $query;

        }

        public function getData($pediatric_id)
        {

            return \DB::table('pediatric_admission')
            ->select('pediatric_admission.* as na', 'baby_admission.* as ba', 'baby.* as bab')
            ->addSelect('pediatric_admission.id as pediatric_id', 'baby.BMrNo as baby_mr', 'pediatric_admission.status as patientStatus', 'MotherName')
            ->leftjoin('baby', 'baby.BabyId', 'pediatric_admission.baby_id')
            ->leftjoin('baby_admission', 'baby_admission.AdmissionId', 'pediatric_admission.admission_id')
            ->leftjoin('mother', 'baby.MotherId', 'mother.MotherId')
            ->where(['baby.IsDeleted' => '0', 'pediatric_admission.is_deleted' => 0])
            ->where('pediatric_admission.id', $pediatric_id)
            ->first();

        }

        public function getListbyPediatric($pediatric_id)
        {
            return \DB::table('pediatric_admission')
            ->select('pediatric_admission.* as na', 'baby_admission.* as ba', 'baby.* as bab')
            ->addSelect('pediatric_admission.id as pediatric_id', 'baby.BMrNo as baby_mr')
            ->leftjoin('baby', 'baby.BabyId', 'pediatric_admission.baby_id')
            ->leftjoin('baby_admission', 'baby_admission.AdmissionId', 'pediatric_admission.admission_id')
            ->where(['baby.IsDeleted' => '0', 'pediatric_admission.is_deleted' => 0])
            ->whereIn('pediatric_admission.id', $pediatric_id)
            ->orderBy('pediatric_admission.id', 'desc')
            ->get();

        }

        /**
         * This method get all the neonatal proforma
         * list
         *
         * @param $neonatal_ids type array
         */
        public function getPediatricSearchList($id)
        {
            return \DB::table('pediatric_admission')
            ->select(\DB::raw('DISTINCT ON("pediatric_admission"."id") "pediatric_admission"."id"'))
            ->select('baby.*', 'mother.*', 'pediatric_admission.*')
            ->leftjoin('baby', 'baby.BabyId', 'pediatric_admission.baby_id')
            ->leftjoin('mother', 'mother.MotherId', 'baby.MotherId')
            ->leftjoin('baby_admission', 'baby_admission.AdmissionId', 'pediatric_admission.admission_id')
            ->whereIn('pediatric_admission.id', $id)
            ->where(['baby.IsDeleted' => '0', 'pediatric_admission.is_deleted' => 0])            
            ->orderby('id', 'desc')
            ->get();
        }
    }

