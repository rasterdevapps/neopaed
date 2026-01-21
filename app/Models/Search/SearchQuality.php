<?php

namespace App\Models\Search;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SearchQuality extends Model
{
  protected $qualityFelds   = ["mr_number", "name", "indication_of_admission_other", "mode_of_delivery",
  "medication_details", "res_support_type", "gram_positive_culture1",
  "gram_negative_culture1", "fungus_culture1", "gram_positive_culture2",
  "gram_negative_culture2", "fungus_culture2", "gram_positive_culture3",
  "gram_negative_culture3", "fungus_culture3","outcome_result",
  "max_grade_rt", "max_grade_lt", "nec_max_stage", "hwbstatus",
  "gender", "age_at_admission_method", "intramural_extramural",
  "sga", "iflscs", "maternalcause", "fetalcause", "antenatalMgSO4",
  "antenatalsteriods", "dexa_beta", "sepsisinmother", "resuscitationatbirth",
  "initialsteps", "ffo2", "bmv", "btv", "cc", "medications", "apgarstatus",
  "cord_blood_gas", "severeperinatalasphyxia", "delayedcordclamping",
  "umbilicalcordmilking", "cutcordmilking", "respiratorydistressat_birth",
  "surfactantgiven", "primary_res_support", "hhhnfc_failure", "cpap_failure",
  "nippv_failure", "nasal_hfov_pfailure", "nasal_hfov_sfailure", "mechanical_cfailure",
  "mechanical_pressurefailure", "mechanical_pfailure", "mechanical_rcfailure",
  "oxygen_prongs_failure", "sepsis", "sclerema", "meningitis", "developedshock",
  "postnatalsteriodused", "steriod_type", "ext_spectrum", "carbapenems",
  "aminoglycosides", "fluoroquinolones", "piperacillin_tazobactam",
  "tetracycline", "eonsclinicalsepsis", "eonssuspectsepsis", "eonsculturepositive_sepsis",
  "lonsclinical_sepsis", "lonssuspect_sepsis", "lonsculture_sepsis",
  "anti_prophylaxis", "probiotics", "brand_name", "total_pn", "hyperbilirubinemia",
  "dvet", "seizures", "anticonvulsants", "patent_ductus_arteriosus", "pda_medicine",
  "surgical_ligation", "centeralline", "hearing_screen_done", "hearscreen_result",
  "caffeine_use", "received_prbc", "receivedplatelet", "freshfrozenplasma",
  "eugr", "congenital_heart_disease", "rds", "pneumothorax", "pphn",
  "intar_hommorrhage", "nec", "ppd", "surgery", "congenital_pneumonia",
  "pulmonary_hemorrahge", "rop", "rop_treatment_required", "pventricular_leukomalacia",
  "cystic_pvl", "bronchopulmonary_dysplasia", "dysplasia_stage", "acute_renal_failure",
  "vap", "osteopenia_prematurity", "sepsis_in_mother_type",
  "indication_of_admission", "surfactant_type", "spesis_type", "central_line_type",
  "case_death", "maternal_age", "married_month", "married_years", "height", "weight",
  "bmi", "gravida", "para", "live", "live", "abortions", "birth_weight",
  "admission_weight", "age_at_admission_h", "age_at_admission_d",
  "gestation_weeks", "gestation_days", "steriod_last_dose", "apgar_1_min",
  "apgar_5_min", "apgar_10_min", "apgar_15_min", "apgar_20_min", "ph",
  "base_deficit", "age_first", "age_second", "age_third", "age_fourth",
  "total_number_of_doses", "hhhnfc_settings_liter", "hhhnfc_settings_fio2",
  "hhhnfc_duration", "cpap_settings_peep", "cpap_settings_fio2",
  "cpap_duration", "nippv_settings", "nippv_duration", "nasal_hfov_pduration_map",
  "nasal_hfov_pduration_fio2", "nasal_hfov_pduration_amp", "nasal_hfov_pduration_hz",
  "nasal_hfov_pduration", "nasal_hfov_ssettings_map", "nasal_hfov_ssettings_fio2",
  "nasal_hfov_ssettings_amp", "nasal_hfov_ssettings_hz", "nasal_hfov_sduration",
  "mechanical_csettings_vol", "nmechanical_csettings_fio2", "mechanical_cduration",
  "mechanical_pressure_map", "mechanical_csettings_fio2", "mechanical_psettings_amp",
  "mechanical_psettings_hz", "mechanical_pduration", "mechanical_rcsettings_map",
  "mechanical_rcsettings_fio2", "mechanical_rcsettings_amp", "mechanical_rcsettings_hz",
  "mechanical_rcduration", "oxygen_prongs_settings_fio2", "oxygen_prongs_duration",
  "mvc_total", "hfov_total", "hfov_mc_total", "non_invasive_total",
  "max_cumulative_dose", "first_antibotics", "second_antibotics", "third_antibotics",
  "total_antibiotics_days", "cumulative_antibiotic", "feeding_start_hours",
  "feeding_start_dof", "feeding_amount_start", "full_feed_time", "expired_prior_event_full_feed",
  "regain_birth_weight", "expired_prior_event_regain_weight", "probiotics_usage",
  "probiotics_stopped", "total_pn_duration", "phototherapy_hours", "max_bilirubin",
  "seizures_duration", "total_duration_of_line", "caffeine_use_val", "total_prbc_transfusions",
  "hospital_stay", "rt_eye_grade", "lt_eye_grade", "dysplasia_details", "dob", "tob", "bmv_duration",
  "btv_duration", "cc_duration", "mechanical_pressureduration", "mechanical_psettings_map",
  "mechanical_psettings_fio2", "others_case_death"
];

protected $textSearch     = ["mr_number", "name", "indication_of_admission_other", "others_case_death"];

protected $selectSearch   = ["mode_of_delivery", "medication_details", "res_support_type", "gram_positive_culture1",
"gram_negative_culture1", "fungus_culture1", "gram_positive_culture2",
"gram_negative_culture2", "fungus_culture2", "gram_positive_culture3",
"gram_negative_culture3", "fungus_culture3","outcome_result",
"max_grade_rt", "max_grade_lt", "nec_max_stage"
];

protected $radioSearch    = ["hwbstatus", "gender", "age_at_admission_method", "intramural_extramural",
"sga", "iflscs", "maternalcause", "fetalcause", "antenatalMgSO4",
"antenatalsteriods", "dexa_beta", "sepsisinmother", "resuscitationatbirth",
"initialsteps", "ffo2", "bmv", "btv", "cc", "medications", "apgarstatus",
"cord_blood_gas", "severeperinatalasphyxia", "delayedcordclamping",
"umbilicalcordmilking", "cutcordmilking", "respiratorydistressat_birth",
"surfactantgiven", "primary_res_support", "hhhnfc_failure", "cpap_failure",
"nippv_failure", "nasal_hfov_pfailure", "nasal_hfov_sfailure", "mechanical_cfailure",
"mechanical_pressurefailure", "mechanical_pfailure", "mechanical_rcfailure",
"oxygen_prongs_failure", "sepsis", "sclerema", "meningitis", "developedshock",
"postnatalsteriodused", "steriod_type", "ext_spectrum", "carbapenems",
"aminoglycosides", "fluoroquinolones", "piperacillin_tazobactam",
"tetracycline", "eonsclinicalsepsis", "eonssuspectsepsis", "eonsculturepositive_sepsis",
"lonsclinical_sepsis", "lonssuspect_sepsis", "lonsculture_sepsis",
"anti_prophylaxis", "probiotics", "brand_name", "total_pn", "hyperbilirubinemia",
"dvet", "seizures", "anticonvulsants", "patent_ductus_arteriosus", "pda_medicine",
"surgical_ligation", "centeralline", "hearing_screen_done", "hearscreen_result",
"caffeine_use", "received_prbc", "receivedplatelet", "freshfrozenplasma",
"eugr", "congenital_heart_disease", "rds", "pneumothorax", "pphn",
"intar_hommorrhage", "nec", "ppd", "surgery", "congenital_pneumonia",
"pulmonary_hemorrahge", "rop", "rop_treatment_required", "pventricular_leukomalacia",
"cystic_pvl", "bronchopulmonary_dysplasia", "dysplasia_stage", "acute_renal_failure",
"vap", "osteopenia_prematurity"
];

protected $checkboxSearch = ["sepsis_in_mother_type", "indication_of_admission", "surfactant_type",
"spesis_type", "central_line_type", "case_death"
];

protected $numberSearch   = ["maternal_age", "married_month", "married_years", "height", "weight",
"bmi", "gravida", "para", "live", "live", "abortions", "birth_weight",
"admission_weight", "age_at_admission_h", "age_at_admission_d",
"gestation_weeks", "gestation_days", "steriod_last_dose", "apgar_1_min",
"apgar_5_min", "apgar_10_min", "apgar_15_min", "apgar_20_min", "ph",
"base_deficit", "age_first", "age_second", "age_third", "age_fourth",
"total_number_of_doses", "hhhnfc_settings_liter", "hhhnfc_settings_fio2",
"hhhnfc_duration", "cpap_settings_peep", "cpap_settings_fio2",
"cpap_duration", "nippv_settings", "nippv_duration", "nasal_hfov_pduration_map",
"nasal_hfov_pduration_fio2", "nasal_hfov_pduration_amp", "nasal_hfov_pduration_hz",
"nasal_hfov_pduration", "nasal_hfov_ssettings_map", "nasal_hfov_ssettings_fio2",
"nasal_hfov_ssettings_amp", "nasal_hfov_ssettings_hz", "nasal_hfov_sduration",
"mechanical_csettings_vol", "nmechanical_csettings_fio2", "mechanical_cduration",
"mechanical_pressure_map", "mechanical_csettings_fio2", "mechanical_psettings_amp",
"mechanical_psettings_hz", "mechanical_pduration", "mechanical_rcsettings_map",
"mechanical_rcsettings_fio2", "mechanical_rcsettings_amp", "mechanical_rcsettings_hz",
"mechanical_rcduration", "oxygen_prongs_settings_fio2", "oxygen_prongs_duration",
"mvc_total", "hfov_total", "hfov_mc_total", "non_invasive_total",
"max_cumulative_dose", "first_antibotics", "second_antibotics", "third_antibotics",
"total_antibiotics_days", "cumulative_antibiotic", "feeding_start_hours",
"feeding_start_dof", "feeding_amount_start", "full_feed_time", "expired_prior_event_full_feed",
"regain_birth_weight", "expired_prior_event_regain_weight", "probiotics_usage",
"probiotics_stopped", "total_pn_duration", "phototherapy_hours", "max_bilirubin",
"seizures_duration", "total_duration_of_line", "caffeine_use_val", "total_prbc_transfusions",
"hospital_stay", "rt_eye_grade", "lt_eye_grade", "dysplasia_details", "bmv_duration",
"btv_duration", "cc_duration", "mechanical_pressureduration", "mechanical_psettings_map",
"mechanical_psettings_fio2"
];

protected $dateSearch     = ["dob"];

protected $timeSearch     = ["tob"];

    /**
     * this method get quality search 
     *
     * @param $input type array 
     * @return array of object 
     */
    public function getList($page = 1, $limit = 5, $data = array(), $order = array())
    {
      $limitstart    = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
      $limitend      = $limit;

      $textSearch     = $this->textSearch;
      $selectSearch   = $this->selectSearch;
      $radioSearch    = $this->radioSearch;
      $checkboxSearch = $this->checkboxSearch;
      $numberSearch   = $this->numberSearch;
      $dateSearch     = $this->dateSearch;
      $timeSearch     = $this->timeSearch;

      $qualityFelds   = array();

      foreach ($this->qualityFelds as $key => $value) {
        if(isset($data[$value]) && !is_array($data[$value]) && !empty(trim($data[$value])) && $data[$value]!= 'N/A') {     
          $qualityFelds[$value] = $data[$value];
        } elseif(isset($data[$value]) && is_array($data[$value]))  {
          $qualityFelds[$value] = $data[$value];                
        }
      }

      $results = array();

      if(count($qualityFelds) > 0) {

        \DB::enableQueryLog();

        $result = \DB::table('demo_details')
        ->select(\DB::raw('DISTINCT ON("demo_details"."id") "demo_details"."id"'))
        ->leftjoin('res_details', 'res_details.baby_id', '=', 'demo_details.babyId')
        ->leftjoin('spesis_details','spesis_details.baby_id', '=', 'demo_details.babyId')
        ->leftjoin('feeding','feeding.baby_id', '=', 'demo_details.babyId')
        ->leftjoin('outcomes','outcomes.baby_id', '=', 'demo_details.babyId')
        ->where(function ($query) use ($qualityFelds, $textSearch, $selectSearch,
         $radioSearch, $checkboxSearch, $numberSearch,
         $dateSearch, $timeSearch) {
          foreach ($qualityFelds as $key => $value) {
            if(in_array($key, $textSearch)) {
              $query = $this->textSearch($query, $key, $value);
            }
            if(in_array($key, $selectSearch)) {
              $query = $this->selectSearch($query, $key, $value);
            }
            if(in_array($key, $radioSearch)) {
              $query = $this->radioSearch($query, $key, $value);
            }
            if(in_array($key, $checkboxSearch)) {
              $query = $this->checkboxSearch($query, $key, $value);
            }
            if(in_array($key, $numberSearch)) {
              $query = $this->numberSearch($query, $key, $value);
            }
            if(in_array($key, $dateSearch)) {
              $value            = str_replace('//', '%', $value);
              $operator         = preg_replace('/[0-9,-,\/]/', '', trim($value));
              $un_splited_value = $value;
              $operator         = str_replace('%', '//', $operator);
              $value            = str_replace('%', '//', $value);
              $value            = trim(str_replace($operator, '', $value));
              $query            = $this->datesearch($key, $operator, $value, $query, $un_splited_value);
            }
            if (in_array($key, $timeSearch)) {
              $operator         =  preg_replace('/[A-Z,a-z,0-9,:]/', '', trim($value));
              $un_splited_value =  trim($value);
              $value            =  str_replace(trim($operator), '', trim($value));
              $this->timesearch($key, $operator, $value, $query, $un_splited_value); 
            }
          }
        })
        ->orderBy('demo_details.id', 'desc');

        $results['count'] = $result->get()->count();
        $results['data'] = $result->limit($limitend)->offset($limitstart)->get();

        $query_log = \DB::getQueryLog();
        $last_log = end($query_log);
        $last_log['bindings'] = implode(', ', $last_log['bindings']);
        $last_log['search_module'] = 5;
        SearchQueryLog::create($last_log);
        \DB::flushQueryLog();

      }

      return $results;
    }

    /**
     * This method to get search 
     *
     * @param $query instance of query builder 
     * @param $key type string 
     * @param $value type string
     * @return $query instance of query builder 
     */
    public function textSearch($query, $key, $value) 
    {
      $operator = preg_replace('/[[A-Z,a-z,0-9,\/,:,_,-]/', '', trim($value));
      $value =  str_replace(trim($operator), '', $value);
      $operator = trim($operator);

      switch ($operator) {
        case '=':
                // $query->where($key, '=', $value);
        $query->whereRaw('rtrim(lower("'.$key.'")) like '."'% ".rtrim(strtolower($value))." %'");
        $query->orWhereRaw('rtrim(lower("'.$key.'")) like '."'".rtrim(strtolower($value))." %'");
        $query->orWhereRaw('rtrim(lower("'.$key.'")) like '."'% ".rtrim(strtolower($value))."'");
        $query->orWhereRaw('trim(lower("'.$key.'")) = '."'".trim(strtolower($value))."'");
        break;
        case '==':
                // $query->where($key, '=', $value);
        $query->whereRaw('trim(lower("'.$key.'")) = '."'".trim(strtolower($value))."'");
        break;
        case '""':
        $query->whereRaw('rtrim(lower("'.$key.'")) like '."'% ".rtrim(strtolower($value))."%'");
        $query->orWhereRaw('rtrim(lower("'.$key.'")) like '."'".rtrim(strtolower($value))." %'");
        $query->orWhereRaw('trim(lower("'.$key.'")) = '."'".trim(strtolower($value))."'");
        break;
        case '*""':
        $query->whereRaw('rtrim(lower("'.$key.'")) like '."'%".rtrim(strtolower($value))."%'");
        break;
        case '@':
        $value = str_split($value);
        foreach ($value as $strkey => $strvalue) {
          $query->whereRaw('lower("'.$key.'") like '."'%".strtolower($strvalue)."%'");
        }
        break;
        case '!':
        $query->whereRaw('trim("'.$key.'") = '."'".trim($value)."'");
        break;
        default:
        $query->whereRaw('rtrim(lower("'.$key.'")) like '."'%".rtrim(strtolower($value))."%'");
        break;
      }
      return $query;
    }

    /**
     * This method to get drop down search
     *
     * @param $query instance of query builder 
     * @param $key type string database column name 
     * @param $value type string database value 
     *
     * @return 
     */
    public function selectSearch($query, $key, $value)
    {
      return $query->where($key, '=', $value);
    }

    /**
     * This method to get drop down search
     *
     * @param $query instance of query builder 
     * @param $key type string database column name 
     * @param $value type string database value 
     *
     * @return 
     */
    public function radioSearch($query, $key, $value)
    {
      return $query->where($key, '=', $value);
    }

    /**
     * This method to get drop down search
     *
     * @param $query instance of query builder 
     * @param $key type string database column name 
     * @param $value type string database value 
     *
     * @return 
     */
    public function checkboxSearch($query, $key, $value)
    {
      if (count($value) > 0) {
        foreach ($value as $field_key => $field_value) {
          $query->whereJsonContains($key, $field_value);                                       
        }
      }

      return $query;
    }

    /**
     * This method to get number search
     *
     * @param $query instance of query builder 
     * @param $key type string database column name 
     * @param $value type string database value 
     *
     * @return 
     */
    public function numberSearch($query,$key, $value)
    {
        # $operator = preg_replace('/(\d*.?\d+)/', '', trim($value));
      $operator = preg_replace('/([0-9,-].?)/', '', trim($value));
      $un_splited_value = $value;
      $value =  str_replace($operator, '', $value);
      $value = !empty($value) ? $value : 0;
      switch ($operator) {
        case '=':
        $query->whereRaw("CAST(".'"'.$key.'"'."as text) like '%".$value."%'");
                // $query->where($key, '=', $value);
        break;
        case '==':
        $operator = '=';
        $query->whereRaw('CAST (NULLIF("'.$key.'",'."''".') as float) '.$operator.$value);
                // $query->where($key, '=', $value);
        break;
        case '>':
        $query->whereRaw('CAST (NULLIF("'.$key.'",'."''".') as float) '.$operator.$value);
                // $query->where($key, '>', $value);
        break;
        case '<':
        $query->whereRaw('CAST (NULLIF("'.$key.'",'."''".') as float) '.$operator.$value);
                // $query->where($key, '<', $value);
        break;
        case '<=':
        $query->whereRaw('CAST (NULLIF("'.$key.'",'."''".') as float) '.$operator.$value);
                // $query->where($key, '<=', $value);
        break;
        case '>=':
        $query->whereRaw('CAST (NULLIF("'.$key.'",'."''".') as float) '.$operator.$value);
                // $query->where($key, '>=', $value);
        break;
        case '#':
        if(in_array($key, ['maternal_age', 'married_month', 'married_years', 'height', 'weight',
          'bmi', 'gravida', 'para', 'live', 'abortions', 'birth_weight', 'tob',
          'age_at_admission_h', 'age_at_admission_d', 'gestation_weeks',
          'gestation_days', 'steriod_last_dose', 'bmv_duration', 'btv_duration',
          'cc_duration', 'apgar_1_min', 'apgar_5_min', 'apgar_10_min', 'apgar_15_min',
          'apgar_20_min', 'ph', 'base_deficit','age_first', 'age_second',
          'age_third', 'age_fourth', 'total_number_of_doses', 'admission_weight'])) {
          $query = $this->singdigitSearch('demo_details', $key, $value, $query); 
      } elseif(in_array($key, ['hhhnfc_settings_liter', 'hhhnfc_settings_fio2', 'hhhnfc_duration',
        'cpap_settings_peep', 'cpap_settings_fio2', 'cpap_duration', 'nippv_settings',
        'nippv_duration', 'nasal_hfov_pduration_map', 'nasal_hfov_pduration_fio2',
        'nasal_hfov_pduration_amp', 'nasal_hfov_pduration_hz', 'nasal_hfov_pduration',
        'nasal_hfov_ssettings_map', 'nasal_hfov_ssettings_fio2', 'nasal_hfov_ssettings_amp',
        'nasal_hfov_ssettings_hz', 'nasal_hfov_sduration', 'mechanical_csettings_vol',
        'nmechanical_csettings_fio2', 'mechanical_cduration', 'mechanical_pressure_map',
        'mechanical_csettings_fio2', 'mechanical_pressureduration', 'mechanical_psettings_map',
        'mechanical_psettings_fio2', 'mechanical_psettings_amp', 'mechanical_psettings_hz',
        'mechanical_pduration', 'mechanical_rcsettings_map', 'mechanical_rcsettings_fio2',
        'mechanical_rcsettings_amp', 'mechanical_rcsettings_hz', 'mechanical_rcduration',
        'oxygen_prongs_settings_fio2', 'oxygen_prongs_duration', 'mvc_total', 'hfov_total',
        'hfov_mc_total', 'non_invasive_total'])) {
        $query = $this->singdigitSearch('res_details', $key, $value, $query); 
      } elseif(in_array($key, ['max_cumulative_dose', 'first_antibotics', 'second_antibotics',
        'third_antibotics', 'total_antibiotics_days', 'cumulative_antibiotic'])) {
        $query = $this->singdigitSearch('spesis_details', $key, $value, $query); 
      } elseif(in_array($key, ['feeding_start_hours', 'feeding_start_dof', 'feeding_amount_start',
        'full_feed_time', 'expired_prior_event_full_feed', 'regain_birth_weight',
        'expired_prior_event_regain_weight', 'probiotics_usage', 'probiotics_stopped',
        'total_pn_duration', 'phototherapy_hours', 'max_bilirubin', 'seizures_duration',
        'total_duration_of_line', 'caffeine_use_val', 'total_prbc_transfusions'])) {
        $query = $this->singdigitSearch('feeding', $key, $value, $query); 
      } elseif(in_array($key, ['hospital_stay', 'rt_eye_grade', 'lt_eye_grade', 'dysplasia_details'])) {
        $query = $this->singdigitSearch('outcomes', $key, $value, $query); 
      }
      break;
      case '..':
      $operator = '...';
      $valueList = explode($operator, $un_splited_value);
      sort($valueList);
      $query->whereBetween($key, $valueList);
      break;
      case '...':
      $valueList = explode($operator, $un_splited_value);
      sort($valueList);
      $query->whereBetween($key, $valueList);
      break;
      default:
      $query->where($key, '=', $value);
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
      $value    = str_replace('/', '-', $value);
      $operator    = str_replace('-', '', $operator);

      $operator = trim($operator);
      switch ($operator) {
        case '=':
        $value    = str_replace('=', '', $value);
        if(!empty($value)) {
          $query->where($column, date('Y-m-d', strtotime($value)));
        } else {
          $query->whereNull($column); 
        }
        break;
        case '==':
        $value    = str_replace('==', '', $value);
        $query->whereDate($column, date('Y-m-d', strtotime($value)));
        break;
        case '//':
        $query->whereDate($column, date('Y-m-d'));
        break;
        case '>':
        $value    = str_replace('>', '', $value);
        $query->where($column, '>' ,date('Y-m-d', strtotime($value)));
        break;
        case '>=':
        $value    = str_replace('>=', '', $value);
        $query->where($column, '>=' ,date('Y-m-d', strtotime($value)));
        break;
        case '<':
        $value    = str_replace('<', '', $value);
        $query->where($column, '<' ,date('Y-m-d', strtotime($value)));
        break;
        case '<=':
        $value    = str_replace('<=', '', $value);
        $query->where($column, '<=' ,date('Y-m-d', strtotime($value)));
        break;
        case '...':
        $un_splited_value = explode('...', $un_splited_value);
                // sort($un_splited_value);
        $un_splited_value = str_replace('/', '-', $un_splited_value);
        $startDate = date('Y-m-d', strtotime($un_splited_value[0])); 
        $endDate   = date('Y-m-d', strtotime($un_splited_value[1]));
        $query->whereBetween($column, [$startDate, $endDate]);
        break;
        case '?':
        $today  = null;
        $today  = date('Y-m-d', strtotime($today));
        $query->where($column,'=',$today);
        break;
        case '#':
        $value = (strlen($value) == 1 && $value < 10 && $value > 0) ? '0'.$value : $value; 

        if ($column == 'dob') {
          $query = $this->datequery('demo_details', $column, $value, $query);                   
        }                     
        break;
        default:
        $query->where($column, date('Y-m-d', strtotime($value)));
        break;
      }

      return $query;

    }

    /**
     * This method to get 
     * single digit search 
     *
     * @param $table type string 
     *
     * @param $column type sting 
     *
     * @param $value  type number
     *
     * @param $query type object  
     */
    public function singdigitSearch($table, $column, $value, $query) 
    {
      $value_list  = array();
      $number_list = \DB::table($table)->get();
      foreach ($number_list as $number_list_key => $number_list_value) {

        $temp_values = (array) $number_list_value;
        $numbers = preg_split('//', $temp_values[$column], -1, PREG_SPLIT_NO_EMPTY);
        $input_numbers = preg_split('//', $value, -1, PREG_SPLIT_NO_EMPTY);

        foreach ($input_numbers as $input_numbers_key => $input_numbers_value) {
         if (in_array($input_numbers_value, $numbers)) {
           $value_list[] = $temp_values[$column];
         }        
       }
     }

        // $valueList = array_unique($value_list); 
     if ($table == '') {
      $query->orWhereIn($column, $valueList);
    } else {
      $query->orWhereIn($table.'.'.$column, $valueList);            
    }
    return $query;
  }

    /**
     * This method to get 
     * single digit in date search 
     *
     * @param $table type string 
     *
     * @param $column type sting 
     *
     * @param $value  type number
     *
     * @param $query type object  
     */
    public function datequery($table, $column, $value, $query)
    {
      $date_list = [];
      $dob_list  = \DB::table($table)->get();
      foreach ($dob_list as $dob_key => $dob_value) {
       $dob_content = explode('-', $dob_value->$column);
       if (in_array($value, $dob_content)) {
        $date_list[] = $dob_value->$column;
      } 
    }
    $query->whereIn($column, $date_list);

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

      switch ($operator) {
        case '=':
        $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');
        $query->whereRaw('("'.$column.'")::time '.$operator.'\''.$value.'\'');                 
        break;
        case '==':
        $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');
        $query->whereRaw('("'.$column.'")::time '.'='.'\''.$value.'\'');    
        break;
        case '<':
        $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');
        $query->whereRaw('("'.$column.'")::time '.$operator.'\''.$value.'\'');    
        break;
        case '<=':
        $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');
        $query->whereRaw('("'.$column.'")::time '.$operator.'\''.$value.'\''); 
        break;
        case '>':
        $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');
        $query->whereRaw('("'.$column.'")::time '.$operator.'\''.$value.'\'');    
        break;
        case '>=':
        $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');
        $query->whereRaw('("'.$column.'")::time '.$operator.'\''.$value.'\'');
        break;
        case '#':
                    // $query->orWhere($column, 'like' , '%'. $value . '%');
        $query->whereRaw($column, 'like', '%'. $value. '%');
        break;
        case '...':
        $valueList = explode($operator, $un_splited_value);

        if (isset($valueList[0]) && isset($valueList[1])) {

          $valueList[0] = Carbon::createFromFormat('h:i a', $valueList[0])->format('H:i:s');
          $valueList[1] = Carbon::createFromFormat('h:i a', $valueList[1])->format('H:i:s');
          sort($valueList);

          $query->whereRaw('("'.$column.'")::time between'.'\''.$valueList[0].'\' and '.'\''.$valueList[1].'\'');    
        }

        break;
        default:
        $operator = '=';
        $value =  Carbon::createFromFormat('h:i a', $value)->format('H:i:s');
        $query->whereRaw('("'.$column.'")::time '.$operator.'\''.$value.'\'');
        break;    
      }
      return $query;
    }


    /**
     * this method to get quality single list
     *
     * @param $id
     * @return array of object one list
     */
    public function getBabydetails($id)
    {
      return \DB::table('demo_details')
      ->leftjoin('res_details', 'res_details.baby_id', '=', 'demo_details.babyId')
      ->leftjoin('spesis_details','spesis_details.baby_id', '=', 'demo_details.babyId')
      ->leftjoin('feeding','feeding.baby_id', '=', 'demo_details.babyId')
      ->leftjoin('outcomes','outcomes.baby_id', '=', 'demo_details.babyId')
      ->where('demo_details.id', $id)
      ->first();
    }

    /**
     * this method to get quality multiple list
     *
     * @param $id
     * @return array of object multiple list 
     */
    public function getQualityList($Ids)
    {
      return \DB::table('demo_details')
      ->select(\DB::raw('DISTINCT ON("demo_details"."id") "demo_details"."id", demo_details.*'))
      ->leftjoin('res_details', 'res_details.baby_id', '=', 'demo_details.babyId')
      ->leftjoin('spesis_details','spesis_details.baby_id', '=', 'demo_details.babyId')
      ->leftjoin('feeding','feeding.baby_id', '=', 'demo_details.babyId')
      ->leftjoin('outcomes','outcomes.baby_id', '=', 'demo_details.babyId')
      ->whereIn('demo_details.id', $Ids)
      ->get();
    }

  }
