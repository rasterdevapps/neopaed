<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Nicu extends Model 
{
	protected $table = 'nicu_admission';
	protected $primaryKey = 'NicuId';
	public $timestamps  =  false;
	
	protected $fillable = ['BMrNo','diastolic_bp','AdmissionId','air_flow','oxgen_flow','delivery_cpap',
	                       'BabyId','MotherId','Abnormalities','AdmissionType','AdmissionWt','AdmittedFrom',
	                       'Advice','Age','AgeAfterBirth','AgeofCXR','AgeOfTransferToNICU',
	                       'AgeOnAdmissioninDays','AgeTaken','Alcohol','Apgar5Mins','BWeight','BaseExcess',
	                       'BE','BP','CFT','CGAatDischarge','ChestMovement','CorrectedGestation',
	                       'AdmissionDate','DischargeDate','DescriptionOfResuscitation','DifferentialDiagnosis',
	                       'discharge_cuss','DischargeHb','DischargePCV','DischargeSerumALP','DischargeSerumCa',
	                       'DischargeSerumNa','DischargeSerumPo4','DischargeTSB','DischargeWeight',
	                       'DOLatDischarge','Dose','FeedingAtDischarge','FinalDiagnosis','Fio2','Fluids','HCO3',
	                       'Hct','HearingScreening','HR','Immunization','Indications','InitialBloodGas',
	                       'InitialXray','Investigations','IT','IVAntibiotic','Length','LowestSerumPh',
	                       'LowestTemperature','MajorComplaints','MattersDiscussed','MBP','MeanBP','Mode',
	                       'MultipleSeizures','NBM','NeurologicalStatus','NicuNewBornScreen','NextAppointment',
	                       'OFC','PaCo2','PaO2','ParentsAddressedBy','ParentsSpokenTo','PEEP','pH','Pip','Plan',
	                       'Po2Fio2Ratio','PregnancyComplications','Problem','PbmProcedure','Rate','RBS',
	                       'Readmission','ReferralReason','ReferredBy','Rop','RopScreening','RR','Schedule',
	                       'SepsisScreen','SexBirthWtGestation','SgaLessThan3rdPercentile','Skin','Smoking',
	                       'SpO2','status','SurfactantGiven','SurfactantType','Surgeon','Temperature',
	                       'TemperatureAtAdmission','TimeOfAdministration','DiscussionTime','TransferTime',
	                       'Tobacco','Tone','TotalCRIB2Score','TotalSNAP2Score','TotalSNAPPE2Score',
	                       'TransferFiO2','TypeOfCare','UAC','UACPosition','UrineOutput','UVC','UVCPosition',
	                       'Ventilation','VentilationRequired','AdmissionTime','SeenBy','UserAdded','UserDeleted',
	                       'IsDeleted','DateAdded','DateModified','HomeOxygen','NAT_TIME','NAT_MINS','NAT_AM',
	                       'AdmissionTime_MINS','AdmissionTime_AM','TransferTime_MINS','TransferTime_AM',
	                       'TransferDate','ROPTreatment','TypeofTreatmen','DateofAdministration',
	                       'TimeOfAdministration_MINS','TimeOfAdministration_AM','Vaccine','VaccineDate',
	                       'NicuDCT','xrayfindings','Flow_l_min','amplitude_delta','mean_airway_pressure',
	                       'NextAppointmentStatus','AdmissionNo','additional_diagnosis','corrected_gestation',
	                       'direct_bilirubin','rop_follow_up','diedTime','diedMins','diedAm',
	                       'nicu_retractions','nicu_airentry','nicu_central_pulses','nicu_peripheral_pulses',
	                       'nicu_femoral_pulses','nicu_s1s2','nicu_murmur', 'nicu_color','nicu_abdomen',
	                       'nicu_bowel_sounds','nicu_umbilicus','nicu_hepatomegaly','nicu_splenomegaly',
	                       'nicu_herina','nicu_genitalia','nicu_pupils','nicu_anteriorfontanelle','nicu_activity',
	                       'nicu_cry','nicu_seizures','nicu_neonatalreflexes', 'additional_information', 'oae_left', 
	                       'oae_right', 'abr_left', 'abr_right', 'result_rop_left','result_rop_right', 'typeoftreatment_left', 
	                       'typeoftreatment_right', 'cranial_ultrasound', 'echocardiography', 'advice', 'plan_follow_up', 
	                       'cardiacmurmur', 'Eyes','PostductalSaturation', 'gentila', 'procedures', 'Hips','nicu_malformation', 
	                       'nicu_malformation_details','echocardiography_status', 'nicu_pupils_findings', 'gentila_findings',
	                       'nicu_genitalia_findings', 'AgeOnAdmissionhour', 'indication_of_admission', 'indication_of_admission_other',
	                       'cg_weeks', 'cg_days', 'dcg_weeks', 'dcg_days', 'discharge_femoral_pulses', 'hospital_name', 'edited', 
	                       'edited_content', 'edited_time', 'investigations_test', 'form_status', 'pip_set', 'map', 'fio2_set', 
	                       'frequency', 'ratio', 'UserModified', 'hospital_acquired_infection', 'ventilator_associated_pneumonia', 'blood_stream_infections', 'initial_assessment_completed_date', 'initial_assessment_completed_hr', 'initial_assessment_completed_min', 'initial_assessment_completed_session', 'DischargeTransferedTime', 'DischargeTransferedTime_MINS', 'DischargeTransferedTime_AM'
						];
	/**
	* GET NON DELETED RECORDS FOR LISTING
	*/
	public static function  get_lists($page=1, $limit=50, $condition = array(), $order=array(), $slug = '', $status='')
	{
        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend = $limit;
        $search_txt = isset($condition['search_txt']) ? $condition['search_txt'] : '';
        
         $checkdate     ='';
         if (strpos($search_txt, '-') > 0) {
            $get_date      = strtotime($search_txt);
            $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
            $search_txt    = '';
          }

		$results = DB::table('nicu_admission')
            ->select('baby.BabyName', 'baby.BabyId', 'baby.BMrNo', 'nicu_admission.AdmissionId', 'nicu_admission.AdmissionDate', 'nicu_admission.NicuId', 'nicu_admission.TypeOfCare', 'nicu_admission.status', 'baby.DOB', 'neonatal_proforma.NeonatalId')
            ->join('baby', 'nicu_admission.BabyId', '=', 'baby.BabyId')
            ->leftjoin('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'nicu_admission.BabyId')
            ->where('nicu_admission.IsDeleted', 0)
            ->where('baby.IsDeleted', 0)
            ->where(function ($query) use ($status)
            {
            	if ($status == 'inpatient') {
                    $query->where('nicu_admission.status', 'Inpatient');
                }
                elseif ($status == 'discharged') {
                    $query->whereNotNull('nicu_admission.status')
		                    ->where('nicu_admission.status', '<>', 'NULL')
		                    ->where('nicu_admission.status', '<>', '')
		                    ->where('nicu_admission.status', '!=', 'Inpatient');
                }
            })
            ->where(function ($query) use ($search_txt, $checkdate)
            {
                if (!empty($search_txt) && empty($checkdate)) {
                    $query->where('baby.BabyName', 'ilike', "%".ucfirst(trim($search_txt))."%");                    	
                    $query->orwhere('baby.BMrNo', $search_txt);
                }

                if (!empty($checkdate) && empty($search_txt)) {
                    $query->whereRaw('"baby"."DOB"::date='.$checkdate);  
                }

            });
           if (isset($order['sortby']) && isset($order['sortorder'])) {
              $results->orderBy($order['sortby'], $order['sortorder']);
            } else{
              $results->orderBy('NicuId', 'desc');            	
            }
        if ($slug) {
          // $result['total'] = count($results->get()->unique('BabyId'));
          $result_set = $results->get()->unique('BabyId')->toArray();
	      $result['total'] = count($result_set);  
	      $result['result'] = array_slice($result_set, $limitstart, $limitend); 
          // $result['result'] = $results->limit($limitend)->offset($limitstart)->get(); 
          // $result['result']=\SiteHelpers::convert_obj_to_array($result['result']->toArray());
          // $result['result']=\SiteHelpers::unique_multidim_array($result['result'], 'BabyId');
          // $result['result']=\SiteHelpers::convert_array_to_object($result['result']);
        } else {
          $result = $results->limit($limitend)->offset($limitstart)->get(); 
          $result = \SiteHelpers::convert_obj_to_array($result->toArray());
          $result = \SiteHelpers::unique_multidim_array($result, 'BabyId');
          $result = \SiteHelpers::convert_array_to_object($result);
        }

           // $result = $results->limit($limitend)->offset($limitstart)
           //           ->get();
		return $result;
	}

	public static function get_admission($baby_mr_nos) 
	{

		return DB::table('nicu_admission')
		        ->select('nicu_admission.AdmissionDate', 'nicu_admission.BMrNo', 'baby_admission.episodes')
				->join('baby_admission', 'baby_admission.AdmissionId', '=', 'nicu_admission.AdmissionId')
		        ->join('baby', 'baby.BabyId', '=', 'baby_admission.BabyId')
		        ->where('nicu_admission.IsDeleted', 0)
		        ->whereIn('baby.BMrNo', $baby_mr_nos)
		        ->get();
	
	}
	public static function get_sub_lists($baby_id)
	{


		$results = DB::table('nicu_admission')
				    ->join('baby_admission', 'baby_admission.AdmissionId', '=', 'nicu_admission.AdmissionId')
				    ->leftjoin('ip_numbers', 'ip_numbers.AdmissionId', '=', 'nicu_admission.AdmissionId')
		            ->leftjoin('baby', 'nicu_admission.BabyId', '=', 'baby.BabyId')
		            ->select(\DB::raw('DISTINCT ON("baby_admission"."AdmissionId") "baby_admission"."AdmissionId"'),'baby.BabyName', 'baby.BabyId', 'baby.BMrNo', 'nicu_admission.AdmissionId', 'nicu_admission.AdmissionDate', 'nicu_admission.DischargeDate', 'nicu_admission.NicuId', 'nicu_admission.TypeOfCare', 'baby.DOB', 'baby_admission.episodes', 'ip_numbers.ip_number')
		            ->where('nicu_admission.IsDeleted', 0)
		            ->where('baby.BabyId', $baby_id)
		            // ->orderby('nicu_admission.AdmissionDate', 'asc')
		            ->get();

		 if (count($results) > 0) {
		 	$results = $results->sortby('AdmissionDate');
		 }

        return $results;


	}
	public static function getBabywiseList($id)
	{

		$result = DB::table('nicu_admission')
            ->join('baby', 'nicu_admission.BabyId', '=', 'baby.BabyId')
            ->join('baby_admission', function ($join) {
            	 $join->on('baby_admission.AdmissionId', '=', 'nicu_admission.AdmissionId');
            	 $join->where('nicu_admission.IsDeleted', '=', 0);
            })
            ->leftjoin('ip_numbers', function ($join)
				{
   					 $join->on('nicu_admission.AdmissionId', '=', 'ip_numbers.AdmissionId');
   					 $join->on('nicu_admission.BabyId', '=', 'ip_numbers.baby_id');
				})
            ->select(\DB::raw('DISTINCT ON("baby_admission"."AdmissionId") "baby_admission"."AdmissionId"'),'baby.BabyName', 'baby.BabyId', 'baby.BMrNo', 'nicu_admission.AdmissionId', 'nicu_admission.AdmissionDate', 'nicu_admission.DischargeDate', 'nicu_admission.NicuId', 'nicu_admission.TypeOfCare', 'nicu_admission.edited', 'ip_numbers.ip_number', 'baby_admission.episodes')
            ->where('nicu_admission.IsDeleted', '0')
            ->where('baby.BabyId', $id)
            ->get();

                
         // $results=\SiteHelpers::convert_obj_to_array($results->toArray());
         // $results=\SiteHelpers::unique_multidim_array($results, 'AdmissionId');
         $results['result']= collect($result);      
         $results['total'] = count($results['result']);      

         return $results;   

	}
    public static function GetTotal() 
    {
        $result = DB::table('nicu_admission')
            ->join('baby', 'nicu_admission.BabyId', '=', 'baby.BabyId')
            ->select('nicu_admission.BabyId')
            ->where('nicu_admission.IsDeleted', 0)
            ->where('baby.IsDeleted', 0)
            // ->groupBy('nicu_admission.BabyId')
            ->get()->unique('BabyId');
            
        return count($result);
    }
	/**
	* FETCH INFORMATION FOR EDIT FORM
	*/
	public static function  get_record($id)
	{
		$results = DB::table('nicu_admission')
            ->leftjoin('nicu_newborn_examination', 'nicu_newborn_examination.BabyId', '=', 'nicu_admission.BabyId')								
            ->leftjoin('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'nicu_admission.BabyId')								
            ->join('baby', 'nicu_admission.BabyId', '=', 'baby.BabyId')
            // ->join('mother', 'baby.MotherId', '=', 'mother.MotherId')
            ->select('neonatal_proforma.*', 'nicu_newborn_examination.*',  'baby.*', 'baby.BMrNo as baby_mr_no', 'nicu_admission.*')			
            ->where('NicuId', $id)->orderBy('neonatal_proforma.DateModified', 'desc')->get();	
		return $results;
	}
	/**
	* GET NEWBORN RECORD FOR THE BABY IF EXISTS 
	*/
	public static function  get_newborn($id)
	{
		$results = DB::table('baby')
            ->leftjoin('newborn_examination', 'newborn_examination.BabyId', '=', 'baby.BabyId')	
			->select('newborn_examination.*', 'baby.*')						
            ->where('baby.BabyId', $id)->get();		
		return $results;
	}
	/**
	* GET last admission ID 
	*/
	public static function  GetLastAdmissionId()
	{
		$results = DB::table('nicu_admission')
			->select('nicu_admission.AdmissionNo')						
           	->orderBy('NicuId', 'desc')
			->limit(1)
			->get();
					
		return $results;
	}

	/**
	* FETCH RECORDS FOR SEARCH FORM RESULTS
	*/	
	public static function GetSearchDatas($value)
	{
		$fillable = ['nicu_admission.BMrNo','Abnormalities','AdmissionType','AdmissionWt','AdmittedFrom','Advice','Age','AgeAfterBirth','AgeofCXR','AgeOfTransferToNICU','AgeOnAdmissioninDays','AgeTaken','Alcohol','AlteredLinePosition','Apgar5Mins','BWeight','BaseExcess','BE','BP','CFT','CGAatDischarge','ChestMovement','CorrectedGestation','AdmissionDate','DischargeDate','DescriptionOfResuscitation','DifferentialDiagnosis','discharge_cuss','DischargeHb','DischargePCV','DischargeSerumALP','DischargeSerumCa','DischargeSerumNa','DischargeSerumPo4','DischargeTSB','DischargeWeight','DOLatDischarge','Dose','FeedingAtDischarge','Fio2','Fluids','HCO3','Hct','HearingScreening','HR','Immunization','Indications','InitialBloodGas','InitialXray','Investigations','IT','IVAntibiotic','Length','LowestSerumPh','LowestTemperature','MajorComplaints','MattersDiscussed','MBP','MeanBP','Mode','MultipleSeizures','NBM','NeurologicalStatus','NicuNewBornScreen','NextAppointment','OFC','PaCo2','lab_lactate','PaO2','ParentsAddressedBy','ParentsSpokenTo','PEEP','pH','Pip','Plan','Po2Fio2Ratio','PregnancyComplications','Problem','PbmProcedure','Rate','RBS','Readmission','ReferralReason','ReferredBy','Rop','RopScreening','RR','Schedule','SepsisScreen','SexBirthWtGestation','SgaLessThan3rdPercentile','Skin','Smoking','SpO2','status','SurfactantGiven','SurfactantType','Surgeon','Temperature','TemperatureAtAdmission','TimeOfAdministration','DiscussionTime','TransferTime','Tobacco','Tone','TotalCRIB2Score','TotalSNAP2Score','TotalSNAPPE2Score','TransferFiO2','TypeOfCare','UAC','UACPosition','UrineOutput','UVC','UVCPosition','Ventilation','VentilationRequired','AdmissionTime','HomeOxygen','xrayfindings','Flow_l_min','amplitude_delta','mean_airway_pressure','NextAppointmentStatus'];		
		
		$query = DB::table('nicu_admission')->join('baby', 'nicu_admission.BabyId', '=', 'baby.BabyId')->select('*')->where('nicu_admission.IsDeleted', 0);
		
		foreach ($fillable as $column) {
		  $query->orWhere($column, 'like', '%'.$value.'%');
		}
		
		$models = $query->get();		

		return $models;
		
	}

	public static function getBabyadmissonIds($baby_id)
	{

		

		 $result =  DB::table('baby')
		           ->select('baby_admission.*')
			       ->leftjoin('baby_admission', 'baby_admission.BabyId', '=', 'baby.BabyId')
			       ->whereIn('baby_admission.AdmissionId', function ($query) use ($baby_id) {

			       	  $query->from('nicu_admission')
			       			->select('nicu_admission.AdmissionId')
		                    ->whereIn('nicu_admission.status', ['Inpatient', 'Transferred'])
		                    ->where('nicu_admission.IsDeleted', 0)
		                    ->where('nicu_admission.BabyId', $baby_id)
		                    ->get()
		                    ->toArray();


			       })
			       ->orwhereIn('baby_admission.AdmissionId', function ($query) use ($baby_id) {
			       	  $query->from('postnatal_discharge')
			       	        ->select('postnatal_discharge.AdmissionId')  
			       	        ->whereIn('postnatal_discharge.discharge_status', ['Inpatient', 'Transferred'])
		                    ->where('postnatal_discharge.IsDeleted', 0)
		                    ->where('postnatal_discharge.BabyId', $baby_id)
		                    ->get()
		                    ->toArray();

			       	
			       })

			       ->where(['baby.IsDeleted'=>0, 'baby.BabyId'=>$baby_id])
			       ->get();

		return 	$result;       

	}
	
	public static function getSlibingsdata($baby_id)
	{
		return DB::table('baby')
		       ->select('nicu_admission.*')  
		       ->join('nicu_admission', 'nicu_admission.BabyId', '=', 'baby.BabyId')
		       ->where('baby.BabyId', $baby_id)
		       ->first();
	}

	public function getUsg()
	{

	       return $this->hasMany('App\Models\Usg', 'BabyId', 'BabyId');

	}

	public static function getNicuDischarge($baby_id)
	{
		$results =  DB::table('baby')
			           ->select('baby_admission.*')
				       ->join('baby_admission', 'baby_admission.BabyId', '=', 'baby.BabyId')
				       ->join('nicu_admission', 'nicu_admission.AdmissionId', '=', 'baby_admission.AdmissionId')
				       ->join('patient_bed_log', 'patient_bed_log.admission_id', '=', 'baby_admission.AdmissionId')
				       ->where('patient_bed_log.status', '=', 'Occupied')
				       ->where('baby.BabyId', '=', $baby_id)
				       ->orderBy('baby_admission.AdmissionId', 'asc')
				       ->get();

		// $results = $results->unique('AdmissionId')
		//                    ->pluck('episodes', 'AdmissionId')	
		//                    ->toArray();	      
		$results = $results->pluck('episodes', 'AdmissionId')	
		                   ->toArray();	       

	     return $results;


	}

    public static function getNicuAdmission($admission_id, $baby_id) 
    {

    	 return   DB::table('nicu_admission')
    	              ->select('NicuId')
			    	  ->where('AdmissionId', '=', $admission_id)
			          ->where('BabyId', '=', $baby_id)
			          ->where('IsDeleted', '=', 0)
			          ->orderBy('NicuId', 'desc')
			          ->first();

    }

    /**
     * This method to check admission has
     * daycare in nicu
     *
     * @param $baby_id type integer
     * @param $admisssion_id type integer 
     * 
     * @return type array of object 
     */
    public static function getNicuadmissionDependancy($baby_id, $admisssion_id) 
    {
    	return DB::table('daycare')
    	           ->where('daycare.BabyId', $baby_id)
    	           ->where('daycare.AdmissionId', $admisssion_id)
                   ->where('daycare.IsDeleted', '0')
                   ->get();
    }

    /**
	  * This method used to fetch all nicu record 
	  * 
	  * @param $id type integer
	  *
	  * @return array of objects
	  */
	public static function nicu_delete_approval($baby_id)
    {
        $results = DB::table('nicu_admission')
        			->join('baby_admission', 'baby_admission.AdmissionId', '=', 'nicu_admission.AdmissionId')
                    ->leftjoin('baby', 'nicu_admission.BabyId', '=', 'baby.BabyId')		            
                    ->select('nicu_admission.BabyId', 'nicu_admission.AdmissionId', 'baby_admission.episodes', 'nicu_admission.NicuId')                 
                    ->where('nicu_admission.BabyId', $baby_id)
                    ->get();
        return $results;
    }
    
     /**
	  * This method to check whether the nicu_admission is deleted or not.
	  * 
	  * @param $baby_id type integer
	  *
	  * @return array of objects
	  */
	public static function neonatal_delete($nicu_id)
    {
        $result =  DB::table('nicu_admission')
                    ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'nicu_admission.BabyId')
                    ->leftjoin('delete_approval', 'delete_approval.ModuleId', '=', 'nicu_admission.NicuId')                    
                    ->where('delete_approval.Status', 'Approved')
                    ->where('delete_approval.ModuleName', 'NICU Admission')
                    ->where('nicu_admission.NicuId', $nicu_id)
                    ->orderby('delete_approval.Id','desc')
                    ->first();
    	return $result;
    }

	/**
	  * This method to get the admission weight
	  * 
	  * @param $baby_id type integer
	  * 
	  * @param $baby_id type integer
	  *
	  * @return array of objects
	  */
	public static function getAdmissionWeight($baby_id, $admission_id)
    {
        $working_weight = \DB::table('nicu_admission')
			                  ->select('AdmissionWt')
			                  ->where('BabyId', $baby_id)
			                  ->where('AdmissionId', $admission_id)
			                  ->first();
    	return $working_weight;
    }
}
