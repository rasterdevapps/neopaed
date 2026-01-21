<?php namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CultureReport extends Model 
{
	/**
	* GENERATE RESULTS ACCORDING TO THE FILTER OPTIONS CHOOSEN IN THE CULTURE REPORT FILTER FORM.
	*/	
	public static function  get_lists($datas)
	{
		$result = DB::table('culture_registry')
            ->join('baby', 'culture_registry.BabyId', '=', 'baby.BabyId')
            ->select('baby.BabyName', 'baby.BMrNo', 'baby.DOB', 'baby.Sex', 'baby.BirthWeight', 'baby.Gestation', 'culture_registry.CollectionDate', 'culture_registry.Specimen', 'culture_registry.Isolate');
		if (isset($datas['StartDate']) && $datas['StartDate']) {
			$result = $result->where('culture_registry.CollectionDate', '>=', date('Y-m-d', strtotime($datas['StartDate'])));
		}
		if (isset($datas['EndDate']) && $datas['EndDate']) {
			$result = $result->where('culture_registry.CollectionDate', '<=', date('Y-m-d', strtotime($datas['EndDate'])));
		}
		if (isset($datas['Sex']) && $datas['Sex']!='') {
			$result = $result->where('baby.Sex', '=', $datas['Sex']);
		}
		if (isset($datas['Isolate']) && $datas['Isolate']!='') {
			$result = $result->where('culture_registry.Isolate', '=', $datas['Isolate']);
		}		
		if (isset($datas['Specimen']) && $datas['Specimen']!='') {
			$result = $result->where('culture_registry.Specimen', '=', $datas['Specimen']);
		}					
        $results = $result->get();		
		return $results;
	}
}
