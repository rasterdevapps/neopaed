<?php namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NbReport extends Model 
{
	/**
	* GENERATE RESULTS ACCORDING TO THE FILTER OPTIONS CHOOSEN IN THE NEWBORN REPORT FILTER FORM.
	*/
	public static function  get_lists($datas)
	{
		$result = DB::table('baby')
		->select('baby.BabyName', 'baby.BMrNo', 'baby.Gestation', 'baby.BirthWeight')
		->addSelect('baby.Sex','baby.DOB', 'neonatal_proforma.NewBornScreen','baby.BabyId')
		->addSelect('nicu_admission.hospital_name as nicu_hospital_name', 'postnatal_admission.hospital_name as post_hospital_name')
		->leftjoin('nicu_admission', 'baby.BabyId', 'nicu_admission.BabyId')
		->leftjoin('postnatal_admission', 'baby.BabyId', 'postnatal_admission.BabyId')
		->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
		->where('baby.IsDeleted','0')
		->where('neonatal_proforma.IsDeleted','0')
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

		if (isset($datas['Sex']) && $datas['Sex']!='') {

			$result = $result->where('baby.Sex', '=', $datas['Sex']);
		}	

		if (isset($datas['SeenBy']) && $datas['SeenBy']!=0) {

			$result = $result->where('neonatal_proforma.SeenBy', '=', $datas['SeenBy']);
		}	

		$results = $result->orderBy('baby.BabyId', 'desc')->get();	

				// return $results->unique('BabyId');
		return $results;
	}

   /**
	* This method to get nicu screen status
	* 
	* @param $baby_id type integer 
	* @return array of object
	*/
	public static function get_nicu_screen($baby_id) 
	{
		return \DB::table('nicu_admission')
		->where('BabyId', $baby_id)
		->where('IsDeleted', '0')
		->orderby('NicuId','desc')
		->first();

	}

	/**
	 * This method to get postnatal screen status 
	 *
	 * @param $baby_id type integer 
	 * @return array of object
	 */
	public static function get_postnatal_screen($baby_id)
	{
		return \DB::table('postnatal_admission')
		->select('discharge_new_born')
		->join('postnatal_discharge', 'postnatal_discharge.AdmissionId', '=', 'postnatal_admission.AdmissionId')
		->where('postnatal_admission.BabyId', $baby_id)
		->where('postnatal_admission.IsDeleted', '0')
		->where('postnatal_discharge.IsDeleted', '0')
		->orderby('pid','desc')
		->first();

	}
}
