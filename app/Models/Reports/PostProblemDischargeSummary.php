<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;

class PostProblemDischargeSummary extends Model
{

  /**
   * This method to get postnatal discharge list  
   * 
   * @return list in array of objects 
   */
   public static function getBabylist($page = 1, $limit = 10, $condition, $order = array(), $slug = '', $status = '')
   {

   	     $limitstart   = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
         $limitend     = $limit;
         $search_txt   = isset($condition['search_txt']) ? $condition['search_txt'] : '';
         $checkdate    ='';
         
        if (strpos($search_txt, '-') > 0) {
            $get_date      = strtotime($search_txt);
            $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date) : '';
            $search_txt    = '';
        }

   	    $results = \DB::table('baby')
   	                ->whereIn('baby.BabyId', function ($query) use ($status) {

   	             	        $query->select('BabyId')
		   	             	      ->from('postnatal_discharge');
                            
                if ($status == 'inpatient') {
                    $query->where('discharge_status', 'Inpatient');
                }
                elseif ($status == 'discharged') {
                    $query->where('discharge_status', '!=', 'Inpatient');
                }
		   	             	     $query->where(['IsDeleted'=>0])
		   	             	      ->where('discharge_status', '<>', 'Inpatient')
		   	             	      ->groupby('BabyId')
		   	             	      ->get()
		   	             	      ->toArray();

   	                 })
                
   	                ->where(function ($query) use ($search_txt, $checkdate) {

		                if (!empty($search_txt) && empty($checkdate)) {

		                    $query->where('baby.BabyName', 'ilike', '%'.trim($search_txt).'%');
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

	      return $result;

   }

   /**
    * This Method used to get baby list count
    *
    * @return  integer
    */
    public static function getTotal() 
    {
    	$results = \DB::table('baby')
    	            ->whereIn('baby.BabyId', function ($query) {

    	            	$query->select('BabyId')
    	            	      ->from('postnatal_discharge')
    	            	      ->where('IsDeleted', 0) 
    	            	      ->where('discharge_status', '<>', 'Inpatient')
    	            	      ->groupby('BabyId')
    	            	      ->get()
    	            	      ->toArray();

    	            })
    	            ->get();
    	 return count($results);           
    }

    /**
     * This Method to get postnatal discharge list 
     * based on Admission 
     *
     * @param $baby_id type integer 
     * @return array of object 
     */
    public static function getAdmissionList($baby_id)
    {
        $results = \DB::table('baby')
                    ->select('baby.BabyId', 'baby.BabyName', 'baby.BMrNo')
                    ->addSelect('postnatal_discharge.BabyId', 'postnatal_discharge.AdmissionId', 'postnatal_discharge.edited')
                    ->addSelect('baby_admission.AdmissionDate', 'baby_admission.episodes')
                    ->addSelect('ip_numbers.ip_number')
                    ->join('baby_admission', 'baby_admission.BabyId', '=', 'baby.BabyId')
                    ->join('postnatal_discharge', 'postnatal_discharge.AdmissionId', '=', 'baby_admission.AdmissionId')
                    ->leftjoin('ip_numbers', 'ip_numbers.AdmissionId', '=', 'postnatal_discharge.AdmissionId')
                    ->where('postnatal_discharge.IsDeleted', 0)
                    // ->where('postnatal_discharge.discharge_status', '<>', 'Inpatient')
                    ->where('baby.IsDeleted', 0)
                    ->where('baby.BabyId', $baby_id)
                    ->orderBy('baby_admission.AdmissionId', 'desc')
                    ->get();

         return $results;

    }

   /**
   * This Method to retrive the discharge summary 
   *
   * @param $baby_id type integer  
   *
   * @return baby details in array of object 
   */
   public static function getNewbornDetails($baby_id)
   {
        $results = \DB::table('baby')
                   ->selectRaw('case when char_length("TOB_TIME"::text) = 1 then \'0\'|| "TOB_TIME"::text
                                     when char_length("TOB_TIME"::text) = 2 then "TOB_TIME"::text
                                end 
                                || \':\' ||
                                case when char_length("TOB_MINS"::text) = 1 then \'0\'|| "TOB_MINS"::text
                                     when char_length("TOB_MINS"::text) = 2 then "TOB_MINS"::text
                                end     
                               || \':\' || "TOB_AM"::text as tob, to_char("DOB", \'DD-MM-YYYY \') as dateofbirth')

                    ->addSelect('baby.BMrNo as mr_no', 'baby.BabyName', 'baby.Gestation', 'baby.Sex', 'baby.BirthWeight', 'baby.BabyBloodGroup')
                    ->addSelect('baby.neonatal_consultant')
                    ->addSelect('baby.Background')
                    ->addSelect('neonatal_proforma.ModeOfDelivery', 'baby.BirthOrder', 'baby.BirthStatus', 'mother.MotherBloodGroup')
                    ->addSelect('neonatal_proforma.Apgars1min', 'neonatal_proforma.Apgars5min', 'neonatal_proforma.Apgars10min')
                    ->addSelect('neonatal_proforma.DischargeWeight as discharge_wt', 'neonatal_proforma.discharge_length', 'neonatal_proforma.discharge_ofc')
                    ->addSelect('neonatal_proforma.*', 'mother.*')
                    ->addSelect('neonatal_proforma.Indication')
                    ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
                    ->join('mother', 'mother.MotherId', '=', 'baby.MotherId')
                    ->where(['baby.IsDeleted'=>'0', 'neonatal_proforma.IsDeleted'=>'0'])
                    ->where(['baby.BabyId'=>$baby_id])
                    ->first();
        

       return $results;
   }

    /**
    * This Method to retrive the admission details for summary
    *
    * @param $baby_id type integer
    *
    * @param $admission_id type integer
    *
    * @return baby admission details in array of object
    */
   public static function getAdmissionDetails($baby_id, $admission_id) 
   {


      $checking_admission = \DB::table('baby_admission')
                                ->join('postnatal_admission', 'postnatal_admission.AdmissionId', '=', 'baby_admission.AdmissionId')
                                ->where(['postnatal_admission.BabyId'=>$baby_id, 'postnatal_admission.AdmissionId'=>$admission_id])
                                ->orderBy('postnatal_admission.pid', 'desc')
                                ->first();

      $results = \DB::table('baby')
                      ->select('postnatal_discharge.discharge_date as discharge_date')
                      ->addSelect('postnatal_discharge.cgd as discharge_cga')
                      ->addSelect('postnatal_discharge.discharge_wt as DischargeWeight')
                      ->addSelect('postnatal_discharge.discharge_dol as  DOLatDischarge')
                      ->addSelect('postnatal_discharge.discharge_ofc')
                      ->addSelect('postnatal_discharge.discharge_length')
                      ->addSelect('postnatal_discharge.*')
                      ->addSelect('ip_numbers.ip_number as visit_number')
                      ->join('baby_admission', 'baby_admission.BabyId', '=', 'baby.BabyId');


            if (count($checking_admission) > 0) {

              $results = $results->addSelect('postnatal_admission.*')
                                 ->addSelect('postnatal_admission.admission_cg as admission_cga')
                                 ->addSelect('postnatal_admission.admission_date as admission_date')
                                 ->addSelect('postnatal_admission.admission_wt as AdmissionWt')
                                 ->addselect('postnatal_admission.ageonadmissionindays as AgeOnAdmissioninDays')
                                 ->join('postnatal_admission', 'postnatal_admission.AdmissionId', '=', 'baby_admission.AdmissionId')
                                 ->where(['postnatal_admission.IsDeleted'=>'0']);

            } else {


              $results = $results->addSelect('neonatal_proforma.*')
                                 ->addSelect('baby.Gestation as admission_cga')
                                 ->addSelect('baby.BirthWeight as AdmissionWt')
                                 ->addSelect('baby.Gestation as AgeOnAdmissioninDays')
                                 ->addSelect('neonatal_proforma.TestDate as admission_date')
                                 ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby_admission.BabyId');
                 
            }   
                
              $results = $results->join('postnatal_discharge', 'postnatal_discharge.AdmissionId', '=', 'baby_admission.AdmissionId')
                                 ->leftjoin('ip_numbers', 'ip_numbers.AdmissionId', '=', 'baby_admission.AdmissionId')
                                 ->where(['baby.BabyId'=>$baby_id, 'baby_admission.AdmissionId'=>$admission_id])
                                 ->where(['baby.IsDeleted'=>'0'])
                                 ->orderBy('postnatal_discharge.posdisid', 'desc')
                                 ->first();

      return $results;            

   }

    /**
    *This method to retrive the problems form problem based system
    *
    * @param $baby_id  
    * @param $admission_id
    * @return problem in array 
    */
   public static function getNeonatalProblems($baby_id, $admission_id)
   {

      $results = \DB::table('pb_postnatal_list as ppl')
                     ->join('pb_postnatal_episode as ppe', 'ppe.pb_postnatal_id', '=', 'ppl.pb_postnatal_id')
                     ->join('pd_published', function($join)
                       {
                         $join->on('pd_published.published_id', '=', 'ppe.pp_id')
                              ->on('pd_published.problem_id', '=', 'ppe.problem_id');

                       })
                     ->where('ppl.IsDeleted', 0)
                     ->where('ppe.IsDeleted', 0)
                     ->where(['ppl.baby_id'=> $baby_id, 'ppl.admission_id'=> $admission_id])
                     ->get();

      return $results; 

   }

    /**
    * This method procedure list  
    *
    * @param $procedures type json 
    * @return procedure list 
    */
    public static function getProcedureList($procedures)
    {
        $results = '';
        if (count(json_decode($procedures)) > 0 && json_decode($procedures)[0] != '') {

            $results = \DB::table('mas_procedures')
                        ->whereIn('Id', json_decode($procedures))
                        ->get()
                        ->pluck('Name')
                        ->toArray();
        }                
        return  $results;

    }

   /**
   * This Method to retrive the mother's medical problems
   * 
   * @param $baby_id type integer
   *
   * @return medical problems in array 
   */ 
   public static function getMotherMedicalProblems($baby_id) 
   {
      $results = \DB::table('medical_problems')
                  ->join('mas_medical_problems', 'mas_medical_problems.Id', '=', 'medical_problems.Problem')
                  ->where('medical_problems.BabyId', $baby_id)
                  ->get()->pluck('Name')->toArray();
       return $results;           
   }

   /**
   * This Method to retrive the usg findings
   *
   * @param $baby_id type integer
   *
   * @return usg findings in array 
   */
   public static function getUsgFindings($baby_id) 
   {
     $results = \DB::table('usg_finding')
                ->where('BabyId', $baby_id)
                ->get(); 
      return $results;          

   }

  /**
  * This Method to retrive the pregnancy complications
  *
  * @param $baby_id type integer
  *
  * @return pregnancy complications in array 
  */
  public static function getMotherPregnancyComplications($baby_id)
  {
     $results = \DB::table('complications')
                ->join('mas_complication', 'mas_complication.Id', '=', 'complications.Complication')
                ->where('complications.BabyId', $baby_id)
                ->get()->pluck('Name')->toArray();

      return $results;          


  }

  /**
    *This method to retrive the discharge medications 
    * 
    * @param $baby_id
    * @param $admission_id
    * @return discharge medications based on admission in array 
    */
   public static function getDischargeMedications($baby_id, $admission_id, $flag) 
   {
      $results = \DB::table('discharge_medications')
                     ->select('mas_drugivfluid.brand_name as Name', 'discharge_medications.genericname', 'discharge_medications.Dose', 'additional_instruction')
                     ->addSelect('discharge_medications.Frequency', 'discharge_medications.Duration', 'mas_drugivfluid.value as Value')
                     ->join('mas_drugivfluid', 'mas_drugivfluid.id', '=', 'discharge_medications.Medication')
                     ->where(['discharge_medications.BabyId' => $baby_id, 'discharge_medications.AdmissionId' => $admission_id])
                     ->where('discharge_medications.flag', $flag)
                     ->get();
      return $results;

   }




    
}













