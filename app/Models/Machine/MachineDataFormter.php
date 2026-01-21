<?php

namespace App\Models\Machine;

use Illuminate\Database\Eloquent\Model;

class MachineDataFormter extends Model
{   
	protected $table      = 'interface_machine_status';
	protected $primaryKey = 'id';
	public $timestamps    =  false;
	protected $fillable   = ['mrn', 'visit_number', 'baby_name', 'hospital_name',
	'date_time', 'device_name', 'request_ip_number', 'issued_date_time'];						     

	/**
     * This method to get machine status
     *
     */
	public static function getMachineStatus($baby_id, $admission_id, $start_time, $end_time)
	{
		$start_time    = $start_time->subMinute(90)->format('Y-m-d H:i:s');
		$end_time      = $end_time->format('Y-m-d H:i:s');
		
        $prescription_key_id =  \SiteHelpers::prescriptionKeyId();

		$result['infusion'] = \DB::table('prescription')->select('prescription.*', 'prescription_dtl.prescription_id', 'prescription_hdr.baby_id', 'prescription_hdr.admission_id')
                                            ->leftjoin('prescription_dtl', 'prescription_dtl.prescription_id', 'prescription.prescription_id')
                                            ->leftjoin('prescription_hdr', 'prescription_hdr.id', 'prescription_dtl.pres_hdr_id')
        									->leftjoin('mas_drugivfluid', 'mas_drugivfluid.id', 'prescription_hdr.brand_name')
        									->leftjoin('baby_admission', 'baby_admission.BabyId', 'prescription_hdr.baby_id')
                                            ->where('baby_admission.BabyId', $baby_id)
                                            ->where('baby_admission.AdmissionId', $admission_id)
											->whereBetween('result_time', array($start_time, $end_time))
											->orderBy('result_time','asc')
											->first();
								
		$result['infusion'] = count($result['infusion']) > 0 ? 'active' : 'inactive';

		$results = \DB::table('emr_log_hdr')
						->where('baby_id', $baby_id)
						->where('admission_id', $admission_id)
						->pluck('id')->toArray();

		$result['monitor'] =  \DB::table('emr_moniter_values')
								->whereIn('log_hdr_id', $results)
								->whereBetween('result_date_time', array($start_time, $end_time))
								->whereIn('create_user_id', ['2', '3'])
								->orderBy('id', 'desc')						   	  				
								->first();
		$result['monitor'] = count($result['monitor']) > 0 ? 'active' : 'inactive';

		$result['ventilator'] =  \DB::table('emr_ventilator_values')
									->whereIn('log_hdr_id', $results)
									->whereBetween('result_date_time', array($start_time, $end_time))
									->orderBy('id', 'desc')
									->whereIn('create_user_id', ['2', '3'])
									->first();
		$result['ventilator'] = count($result['ventilator']) > 0 ?'active' : 'inactive';

		return $result;
	} 

}
