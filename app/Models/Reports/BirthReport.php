<?php namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BirthReport extends Model 
{
	/**
	* GENERATE RECORDS ACCORDING TO THE FILTER OPTIONS CHOOSEN IN THE FILTER PAGE OF LIVE BIRTH REPORT
	*/
	public static function  get_lists($datas) 
	{

	$result = DB::table('neonatal_proforma')
            ->join('baby', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
            ->select('baby.BabyName', 'baby.TOB_TIME', 'baby.TOB_MINS', 'baby.TOB_AM', 'baby.BMrNo', 'baby.BirthStatus', 'baby.DOB', 'baby.Sex', 'baby.TOB', 'baby.BirthWeight', 'baby.Gestation', 'neonatal_proforma.ModeOfDelivery', 'neonatal_proforma.DateOfDischarge', 'neonatal_proforma.DischargeWeight', 'neonatal_proforma.Status', 'neonatal_proforma.Conception')
		->leftjoin('nicu_admission', 'baby.BabyId', 'nicu_admission.BabyId')
		->leftjoin('postnatal_admission', 'baby.BabyId', 'postnatal_admission.BabyId')
		->where(function ($query) use ($datas)
		{
			if (!empty($datas['hospital_name'])) {
				$query->orwhere('nicu_admission.hospital_name', $datas['hospital_name'])
				->orwhere('postnatal_admission.hospital_name', $datas['hospital_name']);
			}
		});
		
		if (isset($datas['StartDate']) && $datas['StartDate']) {
			$result = $result->where('baby.DOB', '>=', date('Y-m-d', strtotime($datas['StartDate'])));
		}

		if (isset($datas['EndDate']) && $datas['EndDate']) {
			$result = $result->where('baby.DOB', '<=', date('Y-m-d', strtotime($datas['EndDate'])));
		}

		if (isset($datas['Sex']) && $datas['Sex'] != '') {
			$result = $result->where('baby.Sex', '=', $datas['Sex']);
		}

		if (isset($datas['birth_status']) && $datas['birth_status'] != '') {
			$result = $result->where('baby.BirthStatus', '=', $datas['birth_status']);
		}

		if (isset($datas['Status']) && $datas['Status'] != '') {
			$result = $result->where('neonatal_proforma.Status', '=', $datas['Status']);
		}

		if (isset($datas['SeenBy']) && $datas['SeenBy'] != 0) {
			$result = $result->where('neonatal_proforma.SeenBy', '=', $datas['SeenBy']);
		}	

		$result = $result->where('baby.IsDeleted','=',0)->where('neonatal_proforma.IsDeleted','=',0);

        $results = $result->orderBy('baby.BabyId', 'desc')->get();	

		return $results;
	}
}
