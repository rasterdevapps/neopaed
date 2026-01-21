<?php namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PediatricReport extends Model 
{
	/**
	* GENERATE RESULTS ACCORDING TO THE FILTER OPTIONS CHOOSEN IN THE PEDIATRIC REPORT FILTER FORM.
	*/	
	public static function  get_lists($datas)
	{
		$result = DB::table('pediatric_admission')
            ->join('baby', 'pediatric_admission.BabyId', '=', 'baby.BabyId')
            ->select('baby.BabyName', 'baby.BMrNo', 'baby.DOB', 'baby.Sex', 'baby.TOB', 'baby.BirthWeight', 'baby.Gestation', 'pediatric_admission.AdmissionDate', 'pediatric_admission.DischargeDate', 'pediatric_admission.DischargeWeight', 'pediatric_admission.Status', 'FinalDiagnosis', 'AgeOnAdmission');
		if (isset($datas['StartDate']) && $datas['StartDate']) {
			$result = $result->where('pediatric_admission.AdmissionDate', '>=', date('Y-m-d', strtotime($datas['StartDate'])));
		}
		if (isset($datas['EndDate']) && $datas['EndDate']) {
			$result = $result->where('pediatric_admission.AdmissionDate', '<=', date('Y-m-d', strtotime($datas['EndDate'])));
		}
		if (isset($datas['Sex']) && $datas['Sex']!='') {
			$result = $result->where('baby.Sex', '=', $datas['Sex']);
		}
		if (isset($datas['Status']) && $datas['Status']!='') {
			$result = $result->where('pediatric_admission.Status', '=', $datas['Status']);
		}		
		if (isset($datas['SeenBy']) && $datas['SeenBy']!=0) {
			$result = $result->where('pediatric_admission.SeenBy', '=', $datas['SeenBy']);
		}				
        $results = $result->get();		
		return $results;
	}
}
