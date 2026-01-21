<?php 
namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InpatientReport extends Model 
{
	/**
	* GENERATE RECORDS ACCORDING TO THE FILTER OPTIONS CHOOSEN IN THE FILTER PAGE OF LIVE BIRTH REPORT
	*/
	public static function  get_lists($datas)
	{
		$hospital_name = isset($datas['hospital_name']) ? $datas['hospital_name'] : '';

		$result = DB::table('baby')
		            ->join('mother', 'mother.MotherId', '=', 'baby.MotherId')
		            ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
		            ->leftjoin('nicu_admission', 'baby.BabyId', 'nicu_admission.BabyId')
		            ->leftjoin('postnatal_admission', 'baby.BabyId', 'postnatal_admission.BabyId')
		            ->leftjoin('postnatal_discharge', 'baby.BabyId', 'postnatal_discharge.BabyId')
		            ->leftjoin('pediatric_admission', 'baby.BabyId', 'pediatric_admission.baby_id')
				    ->select('baby.BabyName', 'baby.BMrNo', 'baby.Gestation', 'baby.BirthWeight', 'baby.Sex', 'nicu_admission.hospital_name as nicu_hospital_name', 'postnatal_admission.hospital_name as post_hospital_name', 'pediatric_admission.hospital_name as pediatric_hospital_name')
		           ->addSelect('baby.DOB', 'baby.TOB_TIME', 'baby.TOB_MINS', 'baby.TOB_AM', 'baby.TOB', 'baby.BabyBloodGroup', 'mother.MotherBloodGroup')
		           ->addSelect('neonatal_proforma.ModeOfDelivery', 'neonatal_proforma.DischargeWeight')
		           ->addSelect('neonatal_proforma.Conception')
		            ->whereIn('neonatal_proforma.BabyId', function ($query) {
		               $query->select('BabyId')
		                      ->from('neonatal_proforma')
		                      ->whereIn('neonatal_proforma.Status', ['Inpatient',''])
		                      ->where('IsDeleted', 0)
		                      ->get();
		            })
		            ->where(function ($query)
		            {
		             $query->orwhere('nicu_admission.status', 'Inpatient')
		             ->orwhere('postnatal_discharge.discharge_status', 'Inpatient')
		             ->orwhere('pediatric_admission.status', 'Inpatient');
		         })
		            // ->orwhereIn('neonatal_proforma.BabyId', function ($query) {
		            //    $query->select('BabyId')
		            //           ->from('nicu_admission')
		            //           ->where('nicu_admission.status', 'Inpatient')
		            //           ->where('IsDeleted', 0)
		            //           ->get();
		            // })  
		            ->where(function ($query) use ($hospital_name)
		            {
		                if (!empty($hospital_name)) {
		                    $query->orwhere('nicu_admission.hospital_name', $hospital_name)
		                            ->orwhere('postnatal_admission.hospital_name', $hospital_name)
		                            ->orwhere('pediatric_admission.hospital_name', $hospital_name);
		                }
		            })
		            ->where('neonatal_proforma.IsDeleted', 0)
		            ->orderby('baby.BabyId', 'desc');


		        $results = $result->get()->toArray();	
		        // $results = \SiteHelpers::convert_obj_to_array($results);    
		        // $results = \SiteHelpers::unique_multidim_array($results, 'BMrNo');   
		        // $results = \SiteHelpers::convert_array_to_object($results);    
 
				return $results;
	}
}
