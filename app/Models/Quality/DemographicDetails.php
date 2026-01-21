<?php

namespace App\Models\Quality;

use Illuminate\Database\Eloquent\Model;

class DemographicDetails extends Model
{
    protected $table = 'demo_details';
	protected $primaryKey = 'id';
	public    $timestamps  =  false;
	protected $fillable = ['sno', 'institute_number', 'mr_number', 'name', 'maternal_age', 
                        	'married_for', 'hwbstatus', 'height', 'weight', 'bmi', 'gravida', 'para', 'live', 'abortions', 'gender', 'birth_weight', 
                        	'admission_weight', 'dob', 'tob','age_at_admission_method', 'intramural_extramural', 'sga', 'gestation',
                            'mode_of_delivery', 'iflscs', 'maternalcause', 'fetalcause','antenatalMgSO4', 'antenatalsteriods', 'steriod_last_dose', 'dexa_beta', 'sepsisinmother', 'sepsis_in_mother_type',
                            'resuscitationatbirth', 'initialsteps', 'ffo2', 'bmv', 'bmv_duration', 'btv', 'btv_duration',
                            'cc', 'cc_duration', 'medications', 'medication_details', 'apgar_1_min', 'apgar_5_min', 
                            'apgar_10_min', 'apgar_15_min', 'apgar_20_min', 'apgar_extended_min', 'severeperinatalasphyxia', 'delayedcordclamping', 'umbilicalcordmilking',
                            'cutcordmilking', 'indication_of_admission', 'indication_of_admission_other', 'respiratorydistressat_birth',
                            'surfactantgiven', 'surfactant_type', 'age_first', 'age_second', 'age_third', 'age_fourth', 'total_number_of_doses',
                            'user_added', 'married_years','married_month', 'date_added', 'user_modified', 'date_modified', 'group_id', 'apgarstatus', 'cord_blood_gas', 'ph', 'base_deficit',
                            'age_at_admission_h', 'age_at_admission_d','babyId', 'gestation_weeks', 'gestation_days'];

     /**
     * This method to get list of babies
     *
     * @param $group_id
     * @return array of object 
     */
    public static function GetList($page = 1, $limit = 50, $condition, $order=array(), $slug = '') 
    {
        $limitstart    = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend      = $limit;
        $search_txt = isset($condition) ? $condition : '';
        $checkdate  = '';
        if (strpos($search_txt, '-') > 0) {
            if(strpos($search_txt, 'QCA')) {
                $checkdate  = '';
            }
            else {
                $get_date      = strtotime($search_txt);
                $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
                $search_txt    = '';
            }            
        }
        $results = \DB::table('demo_details')
                        ->select('demo_details.id','demo_details.sno','demo_details.mr_number','demo_details.name','demo_details.dob','demo_details.birth_weight','demo_details.user_added','demo_details.user_modified', 'demo_details.babyId')
                        ->where(function ($query) use ($search_txt,$checkdate) 
                        {
                            if (!empty($search_txt) && empty($checkdate)) {
                                $query->whereRaw('LOWER("demo_details"."name") like' . "'%" . strtolower($search_txt) . "%'")
                                        ->orwhere('demo_details.sno', 'LIKE', '%' . $search_txt . '%')
                                        ->orwhere('demo_details.mr_number', 'LIKE', '%' .$search_txt . '%')
                                        ->orwhere('demo_details.birth_weight', 'LIKE', '%' . $search_txt . '%');
                            }        
                            if (!empty($checkdate) && empty($search_txt)) {
                                $query->whereRaw('"demo_details"."dob"::date='.$checkdate);  
                            }
                        });

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
     * This method to get all details 
     *
     * @param $baby_id type integer
     * @return the array of object 
     */
    public static function GetBabyDetails($baby_id)
    {
        return \DB::table('demo_details')
                   ->leftjoin('res_details', 'res_details.baby_id', '=', 'demo_details.babyId')
                   ->leftjoin('spesis_details','spesis_details.baby_id', '=', 'demo_details.babyId')
                   ->leftjoin('feeding','feeding.baby_id', '=', 'demo_details.babyId')
                   ->leftjoin('outcomes','outcomes.baby_id', '=', 'demo_details.babyId')
                   ->where('demo_details.id', $baby_id)
                   ->first();
    }

    /**
     * This method to get all baby details 
     *
     * 
     * @return the array of object 
     */
    public static function GetBabyList()
    {
        return \DB::table('baby')
                  ->select('baby.BabyId', 'baby.BabyName', 'baby.BMrNo')
                 // ->join('demo_details', 'demo_details.babyId', '!=', 'baby.BabyId')
                  // ->whereNotIn('BabyId',function($query) {
                  //   $query->table('demo_details')->get()->pluck('babyId')->toArray();
                  // })
                  ->where('IsDeleted', '0')
                  ->orderBy('BabyId', 'desc')
                  ->get();
    }



    /**
     * This method to get Respiratory details 
     *
     *
     * @return the array of object 
     */
    public function GetRespiratoryDetails()
    {
        return $this->hasOne('App\Models\Quality\RespiratoryDetails','baby_id','babyId');
    }

    /**
     * This method to get Spesis details 
     *
     *
     * @return the array of object 
     */
    public function GetSpesisDetails()
    {
        return $this->hasOne('App\Models\Quality\SpesisDetails','baby_id','babyId');
    }

    /**
     * This method to get Feedings details 
     *
     *
     * @return the array of object 
     */
    public function GetFeedingDetails()
    {
        return $this->hasOne('App\Models\Quality\FeedingDetails','baby_id','babyId');
    }

     /**
     * This method to get Outcome details 
     *
     *
     * @return the array of object 
     */
    public function GetOutcomeDetails()
    {
        return $this->hasOne('App\Models\Quality\OutcomeDetails','baby_id','babyId');
    }

     /**
     * This method to get all details for search
     *
     * @param $selectlist type array
     * @return the array of object 
     */
    public static function GetBabySearch($selectlist)
    {
        return \DB::table('demo_details')
                   ->select($selectlist)
                   ->leftjoin('res_details', 'res_details.baby_id', '=', 'demo_details.id')
                   ->leftjoin('spesis_details','spesis_details.baby_id', '=', 'demo_details.id')
                   ->leftjoin('feeding','feeding.baby_id', '=', 'demo_details.id')
                   ->leftjoin('outcomes','outcomes.baby_id', '=', 'demo_details.id')
                   ->get();
    }

    /**
     * This method to get all details for search
     *
     * @param $baby_id type integer
     * @return the array of object 
     */
    public static function GetNicuBaby($baby_id)
    {
        return \DB::table('baby')
                   ->join('mother','mother.MotherId', '=', 'baby.MotherId')
                   ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
                   ->join('baby_admission', 'baby_admission.BabyId', '=', 'baby.BabyId')
                   ->join('nicu_admission','nicu_admission.AdmissionId','=','baby_admission.AdmissionId')
                   ->where('baby.BabyId', $baby_id)
                   ->first();


       
    }

    /**
     * This method to get res_details 
     * form nurse hour wise sheet
     *
     */
    public static function GetNurseSheetDetails($baby_id)
    {
          return \DB::table('nurse_main_sheet')
                     ->join('emr_log_hdr','emr_log_hdr.day_id', '=', 'nurse_main_sheet.id')
                     //->join('emr_log_dtl', 'emr_log_dtl.log_hdr_id', '=', 'emr_log_hdr.id')
                     ->where('nurse_main_sheet.baby_id',$baby_id)
                     ->get();


    }

    /**
     * This method to get res_details max value 
     * form nurse hour wise sheet
     *
     * @param $baby_id 
     * @param $intf_value
     * @param $local_code
     */
    public static function GetRespiratoryValues($baby_id, $intf_value, $local_code)
    {
        return \DB::table('emr_log_dtl')
                   ->select("emr_log_dtl.intf_ref_value")
                   ->whereIn('emr_log_dtl.log_hdr_id',function($query) use ($baby_id, $intf_value)  {
                          $query->select('emr_log_dtl.log_hdr_id')
                                ->from('emr_log_dtl')
                                ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_log_dtl.log_hdr_id')
                                ->where('emr_log_hdr.baby_id', $baby_id)
                                ->where('emr_log_dtl.intf_ref_value', $intf_value);


                   })
                   ->whereIn('emr_log_dtl.loinc_local_map_id', function($local_code_query) use ($local_code) {
                        $local_code_query->select('id')
                                         ->from('local_code_group')
                                         ->where('local_code', $local_code);

                   })
                   ->get()->max();
    }
    /**
     * This method to get max value of ventilator  
     * parameter
     *
     * @param $baby_id
     * @param $intf_value
     * @param $local_code
     *
     * @return type integer
     */
     public static function GetVentilatorMaxValues($baby_id, $intf_value, $local_code)
     {

       return \DB::select('select * from get_max_value(:baby_id, :intf_value, :local_code)',['baby_id' => $baby_id, 'intf_value' => $intf_value, 'local_code' => $local_code]);

     }

    /**
     * This method to get primary respiratory 
     * support required 
     *
     * @param $baby_id
     * @param $intf_value
     * @param $local_code 
     */
    public static function GetPrimaryRespiratory($baby_id, $local_code) 
    {
        return \DB::table('emr_log_hdr')
                   ->select('emr_log_hdr.sender_time', 'emr_log_dtl.loinc_local_map_id', 'emr_log_dtl.intf_ref_value', 'emr_log_hdr.id')
                   ->join('emr_log_dtl', 'emr_log_dtl.log_hdr_id', '=', 'emr_log_hdr.id')
                   ->where('emr_log_hdr.baby_id', $baby_id)
                   ->whereIn('emr_log_dtl.loinc_local_map_id', function($query) use ($local_code) {
                       $query->select('id')
                             ->from('local_code_group')
                             ->where('local_code', $local_code);

                   })
                   ->orderBy('emr_log_hdr.sender_time', 'asc')
                   ->get();

    }

    /**
     * This method to get the max value for
     * nasal hfov
     * 
     * @param $header_ids type array
     *
     */
     public static function GetPrimaryHFOV($header_ids)
     {
        $results = \DB::table('emr_log_dtl')
                     ->selectRaw('max(intf_ref_value)')
                     ->join('local_code_group', 'local_code_group.id', '=', 'emr_log_dtl.loinc_local_map_id')
                     ->whereIn('log_hdr_id',$header_ids)
                     ->whereIn('local_code', ['p_amplitude', 'map', 'fio2','frequency'])
                     ->get();


        
     }

     
        public static function GetTotal() 
        {
            $result = \DB::table('demo_details')
                        ->get()->count();
            return $result;
        }


    /**
     * This method to get all details 
     *
     * @param $baby_id type integer
     * @return the array of object 
     */
    public static function GetBabyDetailsPrint($baby_id)
    {
        return \DB::table('demo_details')
                   ->leftjoin('res_details', 'res_details.baby_id', '=', 'demo_details.babyId')
                   ->leftjoin('spesis_details','spesis_details.baby_id', '=', 'demo_details.babyId')
                   ->leftjoin('feeding','feeding.baby_id', '=', 'demo_details.babyId')
                   ->leftjoin('outcomes','outcomes.baby_id', '=', 'demo_details.babyId')
                   ->where('demo_details.babyId', $baby_id)
                   ->first();
    }


                       

}
