<?php 
namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Antibiotic;
use App\Models\Search\SearchQueryLog;


class NicuDischarge extends Model 
{
	/**
	* GENERATE RESULTS ACCORDING TO THE FILTER OPTIONS CHOOSEN IN THE NICU REPORT FILTER FORM.
	*/
	public static function  get_lists($data, $AdmissionId)
	{
		$result = DB::table('nicu_admission')
            ->join('baby', 'nicu_admission.BabyId', '=', 'baby.BabyId')
			->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
			->join('mother', 'mother.MotherId', '=', 'baby.MotherId')
            ->select('baby.*', 'nicu_admission.*', 'nicu_admission.OFC AS nicu_ofc', 'nicu_admission.Length as nicu_Length', 'neonatal_proforma.*', 'mother.*', 'nicu_admission.DischargeWeight as nicuDischargeWeight', 'nicu_admission.status as Discharge_status', 'baby.BMrNo as babymr', 'nicu_admission.AdmissionId as nicu_admission_id')
			// ->where('nicu_admission.status', '<>', 'Inpatient')
			->where('nicu_admission.AdmissionId', '=', $AdmissionId)
			->where('baby.IsDeleted', '=', 0)
			->where('neonatal_proforma.IsDeleted', '=', 0)
			->where('nicu_admission.IsDeleted', '=', 0);
    
			$result = $result->where('baby.BabyId', '=', $data)->orderBy('nicu_admission.AdmissionId', 'desc');

						
        $results = $result->get();		
		return $results;
	}
	public static function  get_daycare_lists($data)
	{
		$result = DB::table('daycare')
                  ->select('daycare.*', 'daycare_questions.*')
                  ->leftjoin('daycare_questions', 'daycare_questions.DayId', '=', 'daycare.DayId')
				  ->where('daycare.AdmissionId', '=', $data['AdmissionId'])
			      ->where('daycare.BabyId', '=', $data['BabyId'])
			      ->where('daycare.IsDeleted', '=', 0)
			      ->orderBy('daycare.DayId', 'asc');

					
        $results = $result->get();	
		return $results;
	}
	//old list
	public static function  get_inpatient_baby_lists()
	{
		$result = DB::table('nicu_admission')
            ->join('baby', 'nicu_admission.BabyId', '=', 'baby.BabyId')
            ->select('baby.BabyId', 'baby.BMrNo', 'baby.BabyName', 'nicu_admission.AdmissionId')
			->where('nicu_admission.status', '<>', 'Inpatient')
			->orderBy('nicu_admission.AdmissionId', 'desc');
					
        $results = $result->get();	

    
		return $results;
	}

	public static function  get_inpatient_baby_mainlists($page = 1, $limit = 50, $search = array(), $order=array(), $slug = '', $summary_type = '', $status = '')
	{
		$limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend = $limit;
        $search_txt = isset($search['search_txt']) ? $search['search_txt'] : '';

         $checkdate     ='';
         if (strpos($search_txt, '-') > 0) {
            $get_date      = strtotime($search_txt);
            $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
            $search_txt    = '';
          }

		$result = DB::table('baby')
            ->select('baby.BabyId', 'baby.BMrNo', 'baby.BabyName', 'baby.DOB', 'neonatal_proforma.NeonatalId')
            ->leftjoin('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
            ->whereIn('baby.BabyId', function ($query) use ($summary_type, $status)
        {
            $query->select('BabyId')
                ->from('nicu_admission')
                ->where('IsDeleted', '0');
            if ($summary_type != '')
            {
                if ($summary_type == 'interim')
                {
                    $query->where('status', '=', 'Inpatient');
                }
                else
                {
                    $query->where('status', '<>', 'Inpatient');

                }
            }
            if ($status == 'inpatient')
            {
                $query->where('status', 'Inpatient');
            }
            elseif ($status == 'discharged')
            {
                $query->where('status', '!=', 'Inpatient');
            }
            $query->groupby('BabyId')
                ->get()
                ->toArray();
        })
            ->where('neonatal_proforma.IsDeleted', 0)
            ->where('baby.IsDeleted', 0)
	        ->where(function ($query) use ($search_txt, $checkdate) {

               if (!empty($search_txt) && empty($checkdate)) {
                    $query->where('baby.BabyName', 'ilike', '%'.trim($search_txt).'%');
                    $query->orwhere('baby.BMrNo', $search_txt);
                }

                if (!empty($checkdate) && empty($search_txt)) {

                    $query->whereRaw('"baby"."DOB"::date='.$checkdate);  
                }
            });

           if (isset($order['sortby']) && isset($order['sortorder'])) {
              $result->orderBy($order['sortby'], $order['sortorder']);
            }
             // $result->groupBy(['AdmissionDate', 'baby.BabyId']);

        if ($slug) {
	        $results['total']  = $result->count();  
	        $results['result'] = $result->limit($limitend)->offset($limitstart)->get();
        } else {
	        $results = $result->limit($limitend)->offset($limitstart)->get();
        }
        // echo "<pre>"; print_r($results); exit;
		return $results;
	}

	public static function getDischargeStatus($baby_id) 
	{
        $results = \DB::table('discharge_summary')
                    ->select('is_completed')
	                ->where('baby_id', $baby_id)
	                ->where('IsDeleted', 0)
	                ->orderBy('admission_id', 'desc')
	                ->first();
        return isset($results->is_completed) ? $results->is_completed : '';
	}

	public static function GetTotal($summary_type = '')
	{

		$query = DB::table('nicu_admission')
            ->join('baby', 'nicu_admission.BabyId', '=', 'baby.BabyId')
            ->select('baby.BabyId', 'baby.BMrNo', 'baby.BabyName', 'nicu_admission.AdmissionId', 'baby.DOB');
            if ($summary_type == 'discharged') {
				$query->where('nicu_admission.status', '<>', 'Inpatient');
            }
            else
            {
				$query->where('nicu_admission.status', '=', 'Inpatient');
            }
			$query->where('nicu_admission.IsDeleted', '=', '0')
			->orderBy('nicu_admission.AdmissionId', 'desc')
	        ->groupby('baby.BabyId', 'nicu_admission.AdmissionId', 'nicu_admission.BabyId');
	     $result = $query->get();
       return count($result);
	}

	public static function get_inpatient_baby_sublists($baby_id, $summary_type = '')
	{
		$results= DB::table('nicu_admission')
		          ->select('nicu_admission.NicuId','nicu_admission.AdmissionId', 'baby_admission.episodes', 'ip_numbers.ip_number', 'nicu_admission.AdmissionDate', 'nicu_admission.DischargeDate', 'baby.BabyName', 'baby.BabyId')
		          ->leftjoin('baby', 'nicu_admission.BabyId', '=', 'baby.BabyId')
		          ->leftjoin('baby_admission', 'baby_admission.AdmissionId', '=', 'nicu_admission.AdmissionId')
		          ->leftjoin('ip_numbers', 'ip_numbers.AdmissionId', '=', 'nicu_admission.AdmissionId');

		// if ($summary_type == 'interim') {
		// 	$results->where('nicu_admission.status', '=', 'Inpatient');
		// }
		// else{
		// 	$results->where('nicu_admission.status', '<>', 'Inpatient');
		// }
		$results->where('nicu_admission.IsDeleted', '=', '0')
		          ->where('nicu_admission.BabyId', $baby_id)
		          ->orderBy('baby_admission.AdmissionId', 'desc');
		$result = $results->get()->unique('AdmissionDate')->toArray(); 
	   return $result ;          


	}



	public static function  get_discharge_medications($AdmissionId, $BabyId)
	{
		$result = DB::table('discharge_medications')
            ->select('*', 'mas_drugivfluid.brand_name', 'mas_drugivfluid.brand_name as Name')
			->join('mas_drugivfluid', 'discharge_medications.Medication', '=', 'mas_drugivfluid.id')
			->where('AdmissionId', '=', $AdmissionId)
			->where('BabyId', '=', $BabyId);
					
        $results = $result->get();		
		return $results;
	}
	public static function get_medical_problems($baby_id)
	{

		$results = DB::table('medical_problems') 
		           ->select('mas_medical_problems.Name', 'medical_problems.Medication')
		           ->join('mas_medical_problems', 'mas_medical_problems.Id', '=', 'medical_problems.Problem') 
		           ->where('BabyId', $baby_id)
		           ->get(); 
		return $results;           

	}

	public static function get_medical_complications($baby_id)
	{

		$results = DB::table('complications')
		           ->select('mas_complication.Name', 'complications.Treatment')
		           ->join('mas_complication', 'mas_complication.Id', '=', 'complications.Complication')
		           ->where('complications.BabyId', $baby_id)
		           ->get();
		return $results ;           

	}

	public static function get_ultrasound_findings($baby_id)
	{
		$results=  DB::table('usg_finding')
                   ->where(['BabyId'=>$baby_id])
                   ->get();
                 
           
      return $results;

	}

	public static function get_vaccines($baby_id) 
	{

       return DB::table('nicu_admission')
              ->select('Vaccine', 'VaccineDate')
              ->where(['BabyId'=>$baby_id, 'IsDeleted'=>'0'])
              ->first();
	}

	public static function get_antibiotic($day_ids)
	{

        return Antibiotic::select('antibiotics.Antibiotic', 'antibiotics.Day', 'daycare.DayOfLife')
               ->leftjoin('daycare', 'daycare.DayId', '=', 'antibiotics.DayId')
               ->whereIn('antibiotics.DayId', $day_ids)
               ->get();
	}

	public static function getBabyadmission($baby_id, $admission_id)
	{

		return DB::table('baby')
		       ->join('baby_admission', 'baby_admission.BabyId', '=', 'baby.BabyId')
		       ->where(['baby.BabyId'=>$baby_id, 'baby_admission.AdmissionId'=>$admission_id])
		       ->first();

	}

	public static function getadvancedsearch($page = 1, $limit = 5, $search) 
	{
        $limitstart    = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend      = $limit;

		 $summary = ['NameoftheConsultant','Birth','Problems','RespiratorySystem','CardiovascularSystem','GastrointestinalSystem',
		             'Communicationwithparents','Investigations','DischargeInstructions','Procedures','Summarybirth','AntenatalUltrasoundScanFindings',
		             'CentralNervousSystem','Sepsis','Ophthalmology','Hematology','NewbornScreening','vaccine','Followup', 'DischargeMedications'];
         

         $search    =  preg_replace('/[:,-,_,+,(,),\t\n\r,%,<,>,=,?,˜,@,#,$,ˆ,*]/', '', trim($search,"\x7f..\xff\x0..\x1f"));
         $search    =  preg_replace('/[:,-,_,+,(,),\t\n\r,%,<,>,=,?,˜,@,#,$,ˆ,*]/', '', trim($search));

		 // $search    =  preg_replace('/[\0xe\0x8\0x4]/', '', $search);

		
         // $search    = (count(explode(' ', $search)) > 1) ? explode(' ', trim($search)) : $search;
         $ad_search = $search;

         // if (count($search) > 1) {
         // 	$start = 0; $end  = count($search); 
         // 	foreach ($search as $ad_key => $ad_value) {
         // 		$start++;
         // 		if ($start != $end && $ad_value != '') {

         // 		  $trimed_value =  preg_replace('/[:,-,_,+,(,),\t\n\r,%]/', '', trim($ad_value));
         //          $ad_search    = $ad_search.$trimed_value.' & ';

         // 		} else {
         //          $ad_search = $ad_search.$ad_value;
         // 		}           	          	 
         // 	}
         // } else {
         // 	$ad_search = $search;
         // }

     DB::enableQueryLog();

         
         $results = DB::table('discharge_summary')
                       ->select('baby_id', 'admission_id', 'BabyName', 'DOB', 'BMrNo')
                       ->join('baby','baby.BabyId', '=', 'discharge_summary.baby_id')
                       ->where(function($query) use ($summary, $ad_search) {
                       	  foreach ($summary as $summary_key => $summary_value) {

                       	  	$query->orWhereRaw('to_tsvector("'.$summary_value.'") @@ to_tsquery('."'".$ad_search."'".')');

                       	  }

                       })
                       ->limit($limitend)
					   ->offset($limitstart)
                       ->get();

                $query_log                 = DB::getQueryLog();
                $last_log                  = end($query_log);
                $last_log['bindings']      = implode(', ', $last_log['bindings']);
                $last_log['search_module'] = 2;
                SearchQueryLog::create($last_log);
                DB::flushQueryLog();

        return $results;
     
	}


	public static function getAdmissionStatus($baby_id) 
	{

       return DB::table('nicu_admission')
              ->select('status')
              ->where(['BabyId'=>$baby_id, 'IsDeleted'=>'0'])
              ->orderBy('NicuId', 'desc')
              ->first();
	}
	
}










