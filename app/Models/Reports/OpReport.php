<?php namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OpReport extends Model 
{

	/**
	 * DISPLAY THE RECORDS ACCORDING TO THE FILTERS APPLIED
	 *
	 *@param array 
	 */

	public static function  get_lists($datas)
	{
		$result = DB::table('op_details')
            ->join('baby', 'op_details.BabyId', '=', 'baby.BabyId')
            ->select('baby.BabyName', 'baby.BMrNo', 'baby.DOB', 'baby.Sex', 'baby.BirthWeight', 'baby.Gestation', 'op_details.OpDate', 'op_details.CurrentOFC', 'op_details.CurrentWt', 'op_details.CurrentLength', 'op_details.AppointmentType', 'op_details.Outcome', 'op_details.fee_status', 'op_details.fee_amount', 'op_details.SeenBy', 'op_details.fee_reason')
		    ->where('op_details.IsDeleted', 0);
		if (isset($datas['StartDate']) && $datas['StartDate']) {
			$result = $result->where('op_details.OpDate', '>=', date('Y-m-d', strtotime($datas['StartDate'])));
		}
		if (isset($datas['EndDate']) && $datas['EndDate']) {
			$result = $result->where('op_details.OpDate', '<=', date('Y-m-d', strtotime($datas['EndDate'])));
		}
		if (isset($datas['Sex']) && $datas['Sex']!='') {
			$result = $result->where('baby.Sex', '=', $datas['Sex']);
		}
		if (isset($datas['AppointmentType']) && $datas['AppointmentType']!='') {
			$result = $result->where('op_details.AppointmentType', '=', $datas['AppointmentType']);
		}		
		if (isset($datas['Outcome']) && $datas['Outcome']!='') {
			$result = $result->where('op_details.Outcome', '=', $datas['Outcome']);
		}		
		if (isset($datas['SeenBy']) && $datas['SeenBy']!=0) {
			$result = $result->where('op_details.SeenBy', '=', $datas['SeenBy']);
		}			
		if (isset($datas['hospital_name']) && $datas['hospital_name']!='') {
			$result = $result->where('op_details.hospital_name', '=', $datas['hospital_name']);
		}	
        $results = $result->get();		
		return $results;
	}
}
