<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pediatric extends Model 
{
	protected $table = 'pediatric_admission';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	
	protected $fillable = ['baby_id', 'admission_id', 'referred_by', 'referral_reason', 'admission_date', 'admission_time', 'admission_time_mins', 'admission_time_am', 'type_of_care', 'ip_number', 'admission_weight', 'surgeon', 'pediatric_consultant', 'complaints', 'hopi', 'treatment_history', 'past_history', 'perinatal_history', 'immunization', 'development', 'family_history', 'general_examination', 'hr', 'rr', 'spo2', 'colour', 'cft', 'bp', 'temperature_f', 'central_pulses', 'peripheral_pulses', 'vitals_content', 'current_weight', 'current_height', 'current_ofc', 'anthropometry_content', 'cns', 'level_of_consciousness', 'seizures', 'type_of_seizure', 'general_body_movements', 'spontaneous_activity', 'cry', 'neonatal_reflexes', 'dtrs', 'cranial_nerves', 'motor_system', 'sensory_system', 'meningeal_signs', 'cerebellar_signs', 'spine_cranium', 'cns_findings', 'rs', 'chest_movement', 'breath_sounds', 'air_entry', 'added_sounds', 'character_of_added_sounds', 'site_of_added_sounds', 'rs_findings', 'cvs', 'precordial_activity', 's1s2', 'apical_impulse', 'bounding_pulses', 'murmur', 'character_of_murmur', 'site_of_murmur', 'cvs_findings', 'pallor', 'scalp', 'eyes', 'ears', 'nose', 'nostrils', 'lips', 'palate', 'neck', 'nipples', 'lymphadenopathy', 'umbilicus', 'edema', 'anterior_fontanelle', 'jaundice', 'hernial_orifices', 'femoral_pulses', 'genitalia', 'hips', 'anus', 'spine', 'rt_ul', 'rt_ll', 'lt_ul', 'lt_ll', 'skin', 'hairs', 'any_other_abnormality', 'treatment', 'inm', 'discussion_findings', 'treatment_findings', 'discharge_findings', 'created_by', 'created_date_time', 'modified_by', 'modified_date_time', 'deleted_by', 'is_deleted', 'investigations', 'investigations_test', 'status', 'status_date', 'status_time', 'admission_height', 'status_weight', 'seen_by', 'verified_by', 'stage', 'gpallor', 'ihm', 'cyanosis', 'clubby', 'glymphadenopathy', 'pedal_edema', 'pulse_volume',  'abdomen_findings', 'cns_stage', 'cn_meningeal_signs', 'cn_exam', 'ms_exam', 'ms_findings', 'deep_tendon', 'deep_tendon_findings', 'eye_opening', 'verbal', 'motor', 'hospital_name', 'discharge_medications', 'treatment_medications', 'working_diagnosis', 'admission_entered_by', 'current_head_circumference', 'current_bmi', 'current_bsa', 'abdomen_status', 'skin_over_abdomen', 'palpation_soft', 'palpation_rigidity', 'palpation_guarding', 'palpation_tender', 'palpation_non_tender', 'liver', 'liver_palpation_value', 'spleen', 'spleen_palpation_value', 'external_genitalia', 'approved_by', 'condition_at_discharge', 'review_details', 'specialist', 'nutrition_history', 'allergy_contact_history', 'surgery_date', 'anaesthetist', 'surgery_notes', 'surgery', 'treatment_specialist', 'biohazard','age_year','age_month','age_days','pupils_right_length','pupils_left_length','pupils_right_screening','pupils_left_screening', 'assessment_time', 'assessment_time_mins', 'assessment_time_am', 'issued_to', 'issued_to_relationship', 'issued_date_time', 'issued_by', 'issued_marked_date_time'];

	/**
	* GET NON DELETED RECORDS FOR LISTINGS
	*/
	public static function  get_lists($page=1, $limit=50, $search = array(), $order=array(), $slug = '')
	{
        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend = $limit;

        $search_txt = isset($search['search_txt']) ? $search['search_txt'] : '';

        $checkdate  = '';

        if (strpos($search_txt, '-') > 0) {
            $get_date      = strtotime($search_txt);
            $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
            $search_txt    = (!empty($checkdate)) ? '' : $search_txt;
        }

		$results = DB::table('pediatric_admission')
            ->join('baby', 'pediatric_admission.baby_id', '=', 'baby.BabyId')
            ->select('baby.BabyName', 'baby.BMrNo', 'pediatric_admission.admission_date', 'pediatric_admission.id', 'baby.BabyId', 'baby.DOB')
            ->where('pediatric_admission.is_deleted', 0)
            ->where(function ($query) use ($search_txt, $checkdate)
            {
                if (!empty($search_txt) && empty($checkdate)) {
                    $query->orwhere('baby.BMrNo', $search_txt)
                    	  ->orwhereRaw('LOWER("baby"."BabyName") like' . "'%" . strtolower(trim($search_txt)) . "%'");
                }
                if (!empty($checkdate) && empty($search_txt)) {
                    $query->whereRaw('"admission_date"::date='.$checkdate);
                }

            });
            if (isset($order['sortby']) && isset($order['sortorder'])) {
            	$results->orderBy($order['sortby'], $order['sortorder']);  
            }

        if ($slug) {
          $result_set = $results->get()->unique('BabyId')->toArray();
	      $result['total'] = count($result_set);  
	      $result['result'] = array_slice($result_set, $limitstart, $limitend); 
        } else {
          $result = $results->limit($limitend)->offset($limitstart)->get(); 
          $result = \SiteHelpers::convert_obj_to_array($result->toArray());
          $result = \SiteHelpers::unique_multidim_array($result, 'BabyId');
          $result = \SiteHelpers::convert_array_to_object($result);
        }


		return $result;
	}
    public static function GetTotal() 
    {
        $result = DB::table('pediatric_admission')
            ->join('baby', 'pediatric_admission.id', '=', 'baby.BabyId')
            ->select('baby.BabyName', 'baby.BMrNo', 'pediatric_admission.admission_date', 'pediatric_admission.id')->where('pediatric_admission.is_deleted', 0)
            ->get()->count();
        return $result;
    }
	/**
	* GET DATA FOR PEDIATRIC ADMISSION EDIT FORM
	*/
	public static function  get_record($id)
	{
		$results = DB::table('pediatric_admission')
            ->join('baby', 'pediatric_admission.baby_id', '=', 'baby.BabyId')
            ->join('mother', 'baby.MotherId', '=', 'mother.MotherId')
            ->where('id', $id)->get();		
		return $results;
	}


	public static function get_admission($baby_mr) 
	{

		return DB::table('pediatric_admission')
		        ->select('pediatric_admission.admission_date', 'baby.BMrNo', 'baby_admission.episodes')
				->join('baby_admission', 'baby_admission.AdmissionId', '=', 'pediatric_admission.admission_id')
		        ->join('baby', 'baby.BabyId', '=', 'baby_admission.BabyId')
		        ->where('pediatric_admission.is_deleted', 0)
		        ->whereIn('baby.BMrNo', $baby_mr)
		        ->get();
	
	}
	public static function getBabywiseList($id)
	{

		$result = DB::table('pediatric_admission')
            ->join('baby', 'pediatric_admission.baby_id', '=', 'baby.BabyId')
            ->join('baby_admission', function ($join) {
            	 $join->on('baby_admission.AdmissionId', '=', 'pediatric_admission.admission_id');
            	 $join->where('pediatric_admission.is_deleted', '=', 0);
            })
            ->leftjoin('ip_numbers', function ($join)
				{
   					 $join->on('pediatric_admission.admission_id', '=', 'ip_numbers.AdmissionId');
   					 $join->on('pediatric_admission.baby_id', '=', 'ip_numbers.baby_id');
				})
            ->leftjoin('users', 'issued_by', 'users.id')
            ->select(\DB::raw('DISTINCT ON("baby_admission"."AdmissionId") "baby_admission"."AdmissionId"'),'baby.BabyName', 'baby.BabyId', 'baby.BMrNo', 'pediatric_admission.admission_id', 'pediatric_admission.admission_date', 'pediatric_admission.id', 'pediatric_admission.type_of_care', 'pediatric_admission.ip_number', 'baby_admission.episodes', 'issued_to', 'issued_to_relationship', 'issued_date_time', 'issued_by', 'issued_marked_date_time', 'users.name as user_name')
            ->where('pediatric_admission.is_deleted', '0')
            ->where('baby.BabyId', $id)
            ->get();

        // $results=\SiteHelpers::convert_obj_to_array($results->toArray());
        // $results=\SiteHelpers::unique_multidim_array($results, 'AdmissionId');
        $results['result']= collect($result);      
        $results['total'] = count($results['result']);      

        return $results;   

	}

	/**
	 *To get admission record based on op id 
	 *
	 *@param id  integer
	 *@return admission record in array of objects
	 */
	public static function getAllPreviousAdmission($baby_id) 
	{
		return \DB::table('pediatric_admission')
				->select('admission_date', 'current_weight', \DB::raw("(regexp_matches(current_height, '[0-9]+\.?[0-9]*'))[1]::numeric AS current_height"),  \DB::raw("(regexp_matches(current_head_circumference, '[0-9]+\.?[0-9]*'))[1]::numeric AS current_head_circumference"))
                ->where(['is_deleted'=>0, 'baby_id'=>$baby_id])
                ->orderBy('admission_date', 'desc')
                ->get();

	}

	/**
	 *To get discharge record based on op id 
	 *
	 *@param id  integer
	 *@return discharge record in array of objects
	 */
	public static function getAllPreviousDischarge($baby_id) 
	{
		return \DB::table('pediatric_admission')
				->select('status_date', \DB::raw("(regexp_matches(status_weight, '[0-9]+\.?[0-9]*'))[1]::numeric AS status_weight"))
                ->where(['is_deleted'=>0, 'baby_id'=>$baby_id])
                ->where('status', '<>', 'Inpatient')
                ->orderBy('status_date', 'desc')
                ->get();

	}
    
    public static function  getDischargeMedications($baby_id, $admission_id)
	{
		$result = DB::table('discharge_medications')
            ->select('*', 'mas_drugivfluid.brand_name', 'mas_drugivfluid.brand_name as Name')
			->join('mas_drugivfluid', 'discharge_medications.Medication', '=', 'mas_drugivfluid.id')
			->where('AdmissionId', '=', $admission_id)
			->where('BabyId', '=', $baby_id)->where('flag', 5);
					
        $results = $result->get();		
		return $results;
	}

	public static function  getTreamentMedications($baby_id, $admission_id)
	{
		$result = DB::table('discharge_medications')
            ->select('*', 'mas_drugivfluid.brand_name', 'mas_drugivfluid.brand_name as Name')
			->join('mas_drugivfluid', 'discharge_medications.Medication', '=', 'mas_drugivfluid.id')
			->where('AdmissionId', '=', $admission_id)
			->where('BabyId', '=', $baby_id)->where('flag', 6);
					
        $results = $result->get();		
		return $results;
	}

}
