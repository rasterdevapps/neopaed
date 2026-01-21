<?php
namespace App\Models\Search;

use Illuminate\Database\Eloquent\Model;

use App\Models\Search\SearchQueryLog;
use Carbon\Carbon;

class Neuro extends Model
{
    protected $fields = ['BMrNo','BabyName','MotherName','DOB', 'BirthWeight', 'head_circumference', 'BirthStatus', 'g_weeks', 'g_days', 'chronological_year', 'chronological_month', 'chronological_days', 'corrected_year', 'corrected_month', 'corrected_days', 'total_chronological_weeks', 'total_chronological_days', 'total_corrected_weeks', 'total_corrected_days', 'visit_date', 'visit_time', 'visit_min', 'visit_session', 'BabyBloodGroup', 'Sex', 'current_weight_g', 'current_ofc', 'current_length', 'baby_background', 'seen_by', 'birth_weight_gestation_is_lesser', 'birth_weight_gestation_is_greater', 'intrauterine_growth', 'meningitis', 'mechanical_ventilation', 'encephalopathy_stage_2_more', 'major_malformation', 'inborn_errors', 'symptomatic_hypoglycemia', 'symptomatic_polycythemia', 'retrovirus_positive_mother', 'hyperbilirubinemia_transfusion_rh', 'abnormal_neuro_exam', 'major_morbidities', 'other_specify_is_present', 'general_checkup', 'other_specify', 'rop_date', 'rop_right_hand_side', 'rop_left_hand_side', 'rop_remarks', 'hearing_screen_aabr_date', 'hearing_screen_aabr_right_hand_side', 'hearing_screen_aabr_left_hand_side', 'hearing_screen_aabr_remarks', 'hearing_screen_oae_date', 'hearing_screen_oae_right_hand_side', 'hearing_screen_oae_left_hand_side', 'hearing_screen_oae_remarks', 'diagnostic_abr_date', 'diagnostic_abr_right_hand_side', 'diagnostic_abr_left_hand_side', 'diagnostic_abr_remarks', 'diagnostic_cpa_date', 'diagnostic_cpa_right_hand_side', 'diagnostic_cpa_left_hand_side', 'diagnostic_cpa_remarks', 'ct_date', 'ct_imperssion', 'usg_date', 'usg_imperssion', 'mri_date', 'mri_imperssion', 'date_of_assessment_0_3', 'pna_ca_assessment_0_3', 'adductor_as_assessed_left_0_3','adductor_as_assessed_right_0_3', 'popliteal_as_assessed_left_0_3', 'popliteal_as_assessed_right_0_3', 'dorsiflexion_as_assessed_left_0_3', 'dorsiflexion_as_assessed_right_0_3', 'elbow_not_cross_midline_left_0_3', 'elbow_not_cross_midline_right_0_3', 'elbow_cross_midline_left_0_3', 'elbow_cross_midline_right_0_3', 'elbow_goes_beyond_axillary_line_left_0_3', 'elbow_goes_beyond_axillary_line_right_0_3', 'date_of_assessment_4_6', 'pna_ca_assessment_4_6', 'adductor_as_assessed_left_4_6', 'adductor_as_assessed_right_4_6', 'popliteal_as_assessed_left_4_6', 'popliteal_as_assessed_right_4_6', 'dorsiflexion_as_assessed_left_4_6', 'dorsiflexion_as_assessed_right_4_6', 'elbow_not_cross_midline_left_4_6', 'elbow_not_cross_midline_right_4_6', 'elbow_cross_midline_left_4_6', 'elbow_cross_midline_right_4_6', 'elbow_goes_beyond_axillary_line_left_4_6', 'elbow_goes_beyond_axillary_line_right_4_6', 'date_of_assessment_7_9', 'pna_ca_assessment_7_9', 'adductor_as_assessed_left_7_9', 'adductor_as_assessed_right_7_9', 'popliteal_as_assessed_left_7_9', 'popliteal_as_assessed_right_7_9', 'dorsiflexion_as_assessed_left_7_9', 'dorsiflexion_as_assessed_right_7_9', 'elbow_not_cross_midline_left_7_9', 'elbow_not_cross_midline_right_7_9', 'elbow_cross_midline_left_7_9', 'elbow_cross_midline_right_7_9', 'elbow_goes_beyond_axillary_line_left_7_9', 'elbow_goes_beyond_axillary_line_right_7_9', 'date_of_assessment_10_12', 'pna_ca_assessment_10_12', 'adductor_as_assessed_left_10_12', 'adductor_as_assessed_right_10_12', 'popliteal_as_assessed_left_10_12', 'popliteal_as_assessed_right_10_12', 'dorsiflexion_as_assessed_left_10_12', 'dorsiflexion_as_assessed_right_10_12', 'elbow_not_cross_midline_left_10_12', 'elbow_not_cross_midline_right_10_12', 'elbow_cross_midline_left_10_12', 'elbow_cross_midline_right_10_12', 'elbow_goes_beyond_axillary_line_left_10_12', 'elbow_goes_beyond_axillary_line_right_10_12', 'tone_type', 'others', 'others_asymmetric', 'baby_behavior', 'confidential_background_details', 'recommendation', 'referral_status', 'referral_to', 'appointment_type', 'review', 'review_time', 'review_min', 'review_session', 'fee_status', 'no_fee_reason', 'fee_amount', 'total_hnne_score', 'total_hine_score', 'm_chat_r_total', 'm_chat_followup_total', 'mental_development_quotient', 'motor_development_quotient', 'ddst_interpretation_status', 'cbcl_interpretation_status'];

    protected $text = ['BMrNo','BabyName','MotherName', 'other_specify', 'rop_right_hand_side', 'rop_left_hand_side', 'rop_remarks', 'hearing_screen_aabr_remarks', 'hearing_screen_oae_remarks', 'diagnostic_abr_right_hand_side', 'diagnostic_abr_left_hand_side', 'diagnostic_abr_remarks', 'diagnostic_cpa_remarks', 'ct_imperssion', 'usg_imperssion', 'mri_imperssion', 'pna_ca_assessment_0_3', 'pna_ca_assessment_4_6', 'pna_ca_assessment_7_9', 'pna_ca_assessment_10_12', 'others_asymmetric', 'referral_to', 'no_fee_reason'];

    protected $selecttext = ['BirthStatus', 'visit_time', 'visit_min', 'visit_session', 'BabyBloodGroup', 'Sex', 'seen_by', 'hearing_screen_aabr_right_hand_side', 'hearing_screen_aabr_left_hand_side', 'hearing_screen_oae_right_hand_side', 'hearing_screen_oae_left_hand_side', 'diagnostic_cpa_right_hand_side', 'diagnostic_cpa_left_hand_side', 'tone_type', 'others', 'referral_status', 'appointment_type', 'review_time', 'review_min', 'review_session', 'fee_status', 'ddst_interpretation_status', 'cbcl_interpretation_status'];

    protected $numbers = ['BirthWeight', 'head_circumference', 'g_weeks', 'g_days', 'chronological_year', 'chronological_month', 'chronological_days', 'corrected_year', 'corrected_month', 'corrected_days', 'total_chronological_weeks', 'total_chronological_days', 'total_corrected_weeks', 'total_corrected_days', 'current_weight_g', 'current_ofc', 'current_length', 'adductor_as_assessed_left_0_3','adductor_as_assessed_right_0_3', 'popliteal_as_assessed_left_0_3', 'popliteal_as_assessed_right_0_3', 'dorsiflexion_as_assessed_left_0_3', 'dorsiflexion_as_assessed_right_0_3', 'adductor_as_assessed_left_4_6', 'adductor_as_assessed_right_4_6', 'popliteal_as_assessed_left_4_6', 'popliteal_as_assessed_right_4_6', 'dorsiflexion_as_assessed_left_4_6', 'dorsiflexion_as_assessed_right_4_6', 'adductor_as_assessed_left_7_9', 'adductor_as_assessed_right_7_9', 'popliteal_as_assessed_left_7_9', 'popliteal_as_assessed_right_7_9', 'dorsiflexion_as_assessed_left_7_9', 'dorsiflexion_as_assessed_right_7_9', 'adductor_as_assessed_left_10_12', 'adductor_as_assessed_right_10_12', 'popliteal_as_assessed_left_10_12', 'popliteal_as_assessed_right_10_12', 'dorsiflexion_as_assessed_left_10_12', 'dorsiflexion_as_assessed_right_10_12', 'fee_amount', 'total_hnne_score', 'total_hine_score', 'm_chat_r_total', 'm_chat_followup_total', 'mental_development_quotient', 'motor_development_quotient'];

    protected $dateFields = ['DOB', 'visit_date', 'rop_date', 'hearing_screen_aabr_date', 'hearing_screen_oae_date', 'diagnostic_abr_date', 'diagnostic_cpa_date', 'ct_date', 'usg_date', 'mri_date', 'date_of_assessment_0_3', 'date_of_assessment_4_6', 'date_of_assessment_7_9', 'date_of_assessment_10_12', 'review'];

    protected $editor = ['baby_background', 'baby_behavior', 'confidential_background_details', 'recommendation'];

    protected $boolean = ['birth_weight_gestation_is_lesser', 'birth_weight_gestation_is_greater', 'intrauterine_growth', 'meningitis', 'mechanical_ventilation', 'encephalopathy_stage_2_more', 'major_malformation', 'inborn_errors', 'symptomatic_hypoglycemia', 'symptomatic_polycythemia', 'retrovirus_positive_mother', 'hyperbilirubinemia_transfusion_rh', 'abnormal_neuro_exam', 'major_morbidities', 'other_specify_is_present', 'general_checkup'];

    protected $jsonValues = ['neuro_consultant', 'cns_stage', 'investigations'];

    protected $toggle = ['elbow_not_cross_midline_left_0_3', 'elbow_not_cross_midline_right_0_3', 'elbow_cross_midline_left_0_3', 'elbow_cross_midline_right_0_3', 'elbow_goes_beyond_axillary_line_left_0_3', 'elbow_goes_beyond_axillary_line_right_0_3', 'elbow_not_cross_midline_left_4_6', 'elbow_not_cross_midline_right_4_6', 'elbow_cross_midline_left_4_6', 'elbow_cross_midline_right_4_6', 'elbow_goes_beyond_axillary_line_left_4_6', 'elbow_goes_beyond_axillary_line_right_4_6', 'elbow_not_cross_midline_left_7_9', 'elbow_not_cross_midline_right_7_9', 'elbow_cross_midline_left_7_9', 'elbow_cross_midline_right_7_9', 'elbow_goes_beyond_axillary_line_left_7_9', 'elbow_goes_beyond_axillary_line_right_7_9', 'elbow_not_cross_midline_left_10_12', 'elbow_not_cross_midline_right_10_12', 'elbow_cross_midline_left_10_12', 'elbow_cross_midline_right_10_12', 'elbow_goes_beyond_axillary_line_left_10_12', 'elbow_goes_beyond_axillary_line_right_10_12'];

    public function getList($page = 1, $limit = 5, $data = array(), $order = array())
    {
        $limitstart    = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend      = $limit;

        $otherFields = $filteredFields  = [];

        foreach ($data as $key => $value)
        {

            if (isset($data[$key]) && !is_array($data[$key]) && strlen(trim($data[$key])) > 0)
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

        $text = $this->text;

        $numbers = $this->numbers;

        $selecttext = $this->selecttext;

        $dateFields = $this->dateFields;

        $time_fields = $this->timevalues;

        $editor = $this->editor;

        $boolean = $this->boolean;

        $toggle = $this->toggle;

        $results = array();

        if (count($filteredFields) > 0 || count($otherFields) > 0) {

            \DB::enableQueryLog();

            $result = \DB::table('neuro_visit_details')
            ->select('neuro_visit_details.id as neuro_id')
            ->leftjoin('baby', 'neuro_visit_details.baby_id', 'baby.BabyId')
            ->leftjoin('mother', 'baby.MotherId', 'mother.MotherId')
            ->leftjoin('neuro_eligibility', 'neuro_visit_details.id', 'neuro_eligibility.neuro_visit_id')
            ->leftjoin('neuro_screening', 'neuro_visit_details.id', 'neuro_screening.neuro_visit_id')
            ->leftjoin('neuro_muscle_tone_norms', 'neuro_visit_details.id', 'neuro_muscle_tone_norms.neuro_visit_id')
            ->leftjoin('hnne_details', 'neuro_visit_details.id', 'hnne_details.neuro_visit_id')
            ->leftjoin('hine_details', 'neuro_visit_details.id', 'hine_details.neuro_visit_id')
            ->where(['baby.IsDeleted' => '0', 'neuro_visit_details.is_deleted' => 0])
            ->where(function ($query) use ($text, $numbers, $dateFields, $selecttext, $time_fields, $filteredFields, $otherFields, $editor, $boolean, $toggle)
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
                        if ($field == 'visit_date') {
                            $field = 'neuro_visit_details.visit_date';
                        }
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

            })
            ->orderBy('neuro_visit_details.id', 'desc');

            $temp_result = $result->get();

            $results['count'] = $temp_result->count();
            $results['very_first'] = isset($temp_result[0]) ? $temp_result[0]->neuro_id : 0;
            $results['very_last'] = isset($temp_result[$results['count']-1]->neuro_id) ? $temp_result[$results['count']-1]->neuro_id : 0;

            $results['data'] = $result->limit($limitend)
            ->offset($limitstart)
            ->get();

            $query_log = \DB::getQueryLog();

            $last_log = end($query_log);
            $last_log['bindings'][] = $limitend;
            $last_log['bindings'][] = $limitstart;

            $last_log['bindings'] = "'".implode("','", $last_log['bindings'])."'";
            $last_log['search_module'] = 8;
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
                    // $query->orWhereRaw('rtrim(lower("' . $column . '")) like ' . "'" . rtrim(strtolower($value)) . " %'");
                    // $query->orWhereRaw('trim(lower("' . $column . '")) = ' . "'" . trim(strtolower($value)) . "'");

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
                    $query->where($column, 'like', "'%" . $value . "%'");
                break;
                case '==':
                    $query->where($column, $value);
                break;
                case '<':
                    $query->whereRaw("CAST(" . '"' . $column . '"' . "as text) " . $operator . "'" . $value . "'");
                break;
                case '<=':
                    $query->whereRaw("CAST(" . '"' . $column . '"' . "as text) " . $operator . "'" . $value . "'");
                break;
                case '>':
                    $query->where($column, $operator, $value);
                break;
                case '>=':
                    $query->whereRaw("CAST(" . '"' . $column . '"' . "as text) " . $operator . "'" . $value . "'");
                break;
                case '#':

                $value_list = array();
                $query->whereIn($column, $valueList);
                break;
                case '...':
                $valueList = explode($operator, $un_splited_value);
                    $query->whereBetween($column, $valueList);
                break;
                default:
                    $query->where($column, $value);
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
                    $query->whereBetween($column, [$startDate, $endDate]);
                break;

                case '?':
                $today = null;
                $today = date('Y-m-d', strtotime($today));
                $query->where($column, $today);
                break;

                case '#':
                $query->whereIn($column, $date_list);
                break;

                default:
                    $query->where($column, date('Y-m-d', strtotime($value)));
                break;
            }

            return $query;

        }

        public function getData($neuro_id)
        {

            return \DB::table('neuro_visit_details')
            ->select('*')
            ->addselect('neuro_visit_details.id as neuro_id')
            ->leftjoin('baby', 'neuro_visit_details.baby_id', 'baby.BabyId')
            ->leftjoin('mother', 'baby.MotherId', 'mother.MotherId')
            ->leftjoin('neuro_eligibility', 'neuro_visit_details.id', 'neuro_eligibility.neuro_visit_id')
            ->leftjoin('neuro_screening', 'neuro_visit_details.id', 'neuro_screening.neuro_visit_id')
            ->leftjoin('neuro_muscle_tone_norms', 'neuro_visit_details.id', 'neuro_muscle_tone_norms.neuro_visit_id')
            ->leftjoin('hnne_details', 'neuro_visit_details.id', 'hnne_details.neuro_visit_id')
            ->leftjoin('hine_details', 'neuro_visit_details.id', 'hine_details.neuro_visit_id')
            ->where(['baby.IsDeleted' => '0', 'neuro_visit_details.is_deleted' => 0])
            ->where('neuro_visit_details.id', $neuro_id)
            ->first();

        }

        public function getListbyNeuro($neuro_id)
        {
            return \DB::table('neuro_visit_details')
            ->select('*')
            ->addselect('neuro_visit_details.id as neuro_id')
            ->leftjoin('baby', 'neuro_visit_details.baby_id', 'baby.BabyId')
            ->leftjoin('mother', 'baby.MotherId', 'mother.MotherId')
            ->leftjoin('neuro_eligibility', 'neuro_visit_details.id', 'neuro_eligibility.neuro_visit_id')
            ->leftjoin('neuro_screening', 'neuro_visit_details.id', 'neuro_screening.neuro_visit_id')
            ->leftjoin('neuro_muscle_tone_norms', 'neuro_visit_details.id', 'neuro_muscle_tone_norms.neuro_visit_id')
            ->leftjoin('hnne_details', 'neuro_visit_details.id', 'hnne_details.neuro_visit_id')
            ->leftjoin('hine_details', 'neuro_visit_details.id', 'hine_details.neuro_visit_id')
            ->where(['baby.IsDeleted' => '0', 'neuro_visit_details.is_deleted' => 0])
            ->whereIn('neuro_visit_details.id', $neuro_id)
            ->orderBy('neuro_visit_details.id', 'desc')
            ->get();

        }

        /**
         * This method get all the neonatal proforma
         * list
         *
         * @param $neonatal_ids type array
         */
        public function getNeuroSearchList($id)
        {
            return \DB::table('neuro_visit_details')
            ->select('*')
            ->addselect('neuro_visit_details.id as neuro_id')
            ->leftjoin('baby', 'neuro_visit_details.baby_id', 'baby.BabyId')
            ->leftjoin('mother', 'baby.MotherId', 'mother.MotherId')
            ->leftjoin('neuro_eligibility', 'neuro_visit_details.id', 'neuro_eligibility.neuro_visit_id')
            ->leftjoin('neuro_screening', 'neuro_visit_details.id', 'neuro_screening.neuro_visit_id')
            ->leftjoin('neuro_muscle_tone_norms', 'neuro_visit_details.id', 'neuro_muscle_tone_norms.neuro_visit_id')
            ->leftjoin('hnne_details', 'neuro_visit_details.id', 'hnne_details.neuro_visit_id')
            ->leftjoin('hine_details', 'neuro_visit_details.id', 'hine_details.neuro_visit_id')
            ->where(['baby.IsDeleted' => '0', 'neuro_visit_details.is_deleted' => 0])
            ->whereIn('neuro_visit_details.id', $id)
            ->orderby('neuro_visit_details.id', 'desc')
            ->get();
        }
    }

