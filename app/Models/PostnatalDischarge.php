<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * All the curd of problem base daycare goes here
 *
 * @author Manikandan M
 */
class PostnatalDischarge extends Model
{
    /**
    *@var $table string
    */
    protected $table = 'postnatal_discharge';

   /**
    *@var $primaryKey string  
    */
    protected $primaryKey = 'posdisid';

   /**
    *@var $timestamps 
    */
    public $timestamps  =  false;

    /**
    *@var $timestamps 
    */
    public $fillable   = ['BabyId', 'MotherId', 'AdmissionId', 'BMrNo', 'discharge_status', 
                          'discharge_date', 'discharge_wt', 'discharge_dol', 'discharge_ofc', 
                          'discharge_length', 'discharge_immunization', 'schedule', 'vaccine', 'cgd', 
                          'discharge_eyes', 'discharge_femorals', 'discharge_hips', 'postductal_spo2', 
                          'discharge_gentila', 'discharge_cardiac_murmur', 'discharge_malinformation', 
                          'malinformation_details', 'feeding_at_discharge', 'neourological_status', 
                          'appoinment_status', 'appoinment_date', 'appoinment_hrs', 'appoinment_min', 
                          'appoinment_session', 'discharge_hb', 'discharge_pcv', 'discharge_dct', 
                          'discharge_tsb', 'direct_bilirubin', 'dischargeserum_ca', 'dischargeserum_po4', 
                          'dischargeserum_alp', 'dischargeserum_na', 'discharge_home_oxygen', 
                          'discharge_cuss', 'discharge_new_born', 'discharge_hearing_screen', 'oae_left', 
                          'oae_right', 'abr_left', 'abr_right', 'rop_screening_status', 'left_rop_left', 
                          'left_rop_right', 'rop_treatment', 'typeoftreatment_left', 
                          'typeoftreatment_right', 'rop_follow_up', 'cranial_ultrasound', 
                          'echocardiography', 'advice', 'additional_information', 'plan_follow_up',
                           'DateAdded', 'DateModified', 'procedures', 
                          'UserDeleted', 'UserModified', 'UserAdded', 'IsDeleted', 'echocardiography_status', 
                          'discharge_gentila_findings', 'background', 'diagnosis', 'edited', 'edited_content', 'edited_time', 'newproblem', 
                          'diedTime', 'diedMins', 'diedAm'];


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
    public static function get_lists($page, $limit, $search, $order, $slug = '', $status = '') 
    {
        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt = isset($search['search_txt']) ? $search['search_txt'] : '';

        $checkdate  = '';
        if (strpos($search_txt, '-') > 0) {
            $get_date      = strtotime($search_txt);
            $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
            $search_txt    = '';
        }

        $results = \DB::table('baby')
                     ->whereIn('baby.BabyId', function ($query) use ($status) {
                         $query->from('postnatal_discharge')
                               ->select('postnatal_discharge.BabyId');
                if ($status == 'inpatient') {
                    $query->where('discharge_status', 'Inpatient');
                }
                elseif ($status == 'discharged') {
                    $query->where('discharge_status', '!=', 'Inpatient');
                }
                              $query->where('postnatal_discharge.IsDeleted', 0)
                               ->groupby('postnatal_discharge.BabyId')
                               ->get()
                               ->toArray();

                     })
                    ->where(function ($query) use ($search_txt, $checkdate) {


                        if (!empty($search_txt) && empty($checkdate)) {
                            $query->where('baby.BabyName', 'like', '%'.ucfirst(trim($search_txt)).'%');
                            $query->orwhere('baby.BMrNo', $search_txt);
                        }

                        if (!empty($checkdate) && empty($search_txt)) {

                            $query->whereRaw('"baby"."DOB"::date='.$checkdate);  
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
          
        // return \DB::table('postnatal_discharge')->where('postnatal_discharge.IsDeleted', 0)->get();
         
        return $result;


    }

    /**
     * This Method To Get Baby Admission count 
     *
     * @return baby admission count 
     */
    public static function GetTotal() 
    {

       return \DB::table('baby')
                     ->whereIn('baby.BabyId', function ($query) {
                         
                         $query->from('postnatal_discharge')
                               ->select('postnatal_discharge.BabyId')
                               ->where('postnatal_discharge.IsDeleted', 0)
                               ->groupby('postnatal_discharge.BabyId')
                               ->get()
                               ->toArray();

                     })->get()->count();

    }

    /**
     * This Method to get postnatal discharge details 
     *
     *
     * @return dischargelist 
     */
    public static function GetDischargelist($baby_id) 
    {
    	$results =  \DB::table('baby')
    	               ->select('baby.BabyId', 'baby.BabyName', 'baby.BMrNo', 'baby_admission.episodes', 'ip_numbers.ip_number', 'baby_admission.AdmissionDate', 'baby_admission.AdmissionId', 'postnatal_discharge.posdisid','postnatal_discharge.discharge_date')
    	               ->join('baby_admission', 'baby_admission.BabyId', '=', 'baby.BabyId')
                     ->join('postnatal_discharge', 'postnatal_discharge.AdmissionId', '=', 'baby_admission.AdmissionId')
                     ->leftjoin('ip_numbers', 'ip_numbers.AdmissionId', '=', 'baby_admission.AdmissionId')
                     ->where('postnatal_discharge.IsDeleted', 0)
                     ->where('baby.BabyId', $baby_id)
                     ->where('baby.IsDeleted', 0)
                     ->get();

        return $results;

    }

    /**
     * This Method to get postnatal discharge status 
     *
     * @param $baby_id
     * @return discharge status 
     */
    public static function GetDischareStatus($baby_id) 
    {

       return \DB::table('postnatal_discharge')
                  ->select('discharge_status')
                  ->where('postnatal_discharge.IsDeleted', 0)
                  ->where('postnatal_discharge.BabyId', $baby_id)
                  ->orderBy('postnatal_discharge.posdisid', 'desc')
                  ->first();
 

    }

     /**
     * This Method to get postnatal discharge status 
     *
     * @param $baby_id
     * @return discharge status 
     */
     public static function getPostanatalDischarge($baby_id)
     {
          $results =  \DB::table('baby')
                          ->join('baby_admission', 'baby_admission.BabyId', '=', 'baby.BabyId')
                          ->join('postnatal_discharge', 'postnatal_discharge.BabyId', '=', 'baby.BabyId')
                          ->where('postnatal_discharge.IsDeleted', 0)
                          ->where('baby.BabyId',$baby_id)
                          ->where('postnatal_discharge.discharge_status','!=','Discharged')
                          ->get();

         // return  $results->unique('AdmissionId')
         //          ->pluck('episodes', 'AdmissionId') 
         //          ->toArray(); 
         return  $results->pluck('episodes', 'AdmissionId') 
                  ->toArray(); 
     }

    /**
     * This Method to get postnatal discharge status 
     *
     * @param $baby_id
     * @return discharge status 
     */
     public static function getPostanatalDischargeeDetails($baby_id, $admission_id)
     {

         return \DB::table('postnatal_discharge')
                     ->where('postnatal_discharge.BabyId', $baby_id)
                     ->where('postnatal_discharge.AdmissionId', $admission_id)
                     ->where('postnatal_discharge.IsDeleted', 0)
                     ->orderBy('posdisid', 'desc')
                     ->first();


     }


     /**
     * This Method to get postnatal discharge details 
     *
     * @param $baby_id
     *
     * @return dischargelist 
     */
    public static function Dischargelist_delete_approval($baby_id) 
    {
      $results =  \DB::table('baby')
                     ->select('baby.BabyName', 'baby.BMrNo', 'baby_admission.episodes', 'ip_numbers.ip_number', 'baby_admission.AdmissionDate', 'postnatal_discharge.posdisid')
                     ->join('baby_admission', 'baby_admission.BabyId', '=', 'baby.BabyId')
                     ->join('postnatal_discharge', 'postnatal_discharge.AdmissionId', '=', 'baby_admission.AdmissionId')
                     ->leftjoin('ip_numbers', 'ip_numbers.AdmissionId', '=', 'baby_admission.AdmissionId')
                     ->where('baby.BabyId', $baby_id)
                     ->get();
        return $results;

    }


    /**
     * This Method to get postnatal discharge details 
     *
     * @return dischargelist 
     */
    public static function postnatal_delete($id) 
    {
      $result =  \DB::table('postnatal_discharge')
                    ->join('postnatal_admission', 'postnatal_admission.AdmissionId', '=', 'postnatal_discharge.AdmissionId')
                    ->leftjoin('delete_approval', 'delete_approval.ModuleId', '=', 'postnatal_discharge.posdisid')                    
                    ->where('postnatal_admission.pid', $id)
                    ->where('delete_approval.ModuleName', 'Postnatal Discharge')
                    ->orderby('delete_approval.Id','desc')
                    ->first();
    return $result;

    }

}
