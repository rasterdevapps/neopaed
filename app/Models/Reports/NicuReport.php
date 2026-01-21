<?php namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NicuReport extends Model 
{
	/**
	* GENERATE RESULTS ACCORDING TO THE FILTER OPTIONS CHOOSEN IN THE NICU REPORT FILTER FORM.
	*/
	public static function  get_lists($datas)
	{
		$result = DB::table('nicu_admission')
            ->join('baby', 'nicu_admission.BabyId', '=', 'baby.BabyId')
            ->select('baby.BabyName', 'baby.BirthStatus', 'baby.BMrNo', 'baby.DOB', 'baby.Sex', 'baby.TOB', 'baby.BirthWeight', 'baby.Gestation', 'nicu_admission.AdmissionDate', 'nicu_admission.DischargeDate', 'nicu_admission.DischargeWeight', 'nicu_admission.status', 'DOLatDischarge')
		    ->addSelect('nicu_admission.additional_diagnosis', 'nicu_admission.DifferentialDiagnosis');

		if (isset($datas['StartDate']) && $datas['StartDate']) {
			$result = $result->where('nicu_admission.AdmissionDate', '>=', date('Y-m-d', strtotime($datas['StartDate'])));
		}
		if (isset($datas['EndDate']) && $datas['EndDate']) {
			$result = $result->where('nicu_admission.AdmissionDate', '<=', date('Y-m-d', strtotime($datas['EndDate'])));
		}
		if (isset($datas['Sex']) && $datas['Sex']!='') {
			$result = $result->where('baby.Sex', '=', $datas['Sex']);
		}
		if (isset($datas['Status']) && $datas['Status']!='') {
			$result = $result->where('nicu_admission.status', '=', $datas['Status']);
		}		
		if (isset($datas['TypeOfCare']) && $datas['TypeOfCare']!='') {
			$result = $result->where('nicu_admission.TypeOfCare', '=', $datas['TypeOfCare']);
		}		
		if (isset($datas['SeenBy']) && $datas['SeenBy']!=0) {
			$result = $result->where('nicu_admission.SeenBy', '=', $datas['SeenBy']);
		}	
		if (isset($datas['birth_status']) && !empty($datas['birth_status'])) {
			$result = $result->where('baby.BirthStatus', '=', $datas['birth_status']);
		}	
		if (isset($datas['hospital_name']) && $datas['hospital_name']!='') {
			$result = $result->where('nicu_admission.hospital_name', '=', $datas['hospital_name']);
		}
			
         $results = $result->where('nicu_admission.IsDeleted', '=', '0')->orderBy('baby.BabyId', 'desc')->get();		

		return $results;
	}
}
