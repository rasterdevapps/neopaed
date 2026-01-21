<?php namespace App\Http\Controllers\reports;

use Carbon\Carbon;
use App\Models\Reports\NicuReport;
use App\Models\Baby;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masters\DoctorMaster;
use App\Models\Icd;
use App\Http\Controllers\Flow\FlowController;

class NicuReportController extends Controller 
{
	public function __construct(FlowController $flow)
	{
		$this->middleware('role:REPORT_NICU,read');
		$this->flow = $flow;

	}
	/**
	 * DISPLAY THE RECORDS ACCORDING TO THE FILTERS APPLIED
	 *
	 */
	public function index(Request $request)
	{
		$navigate['main_nav'] = 'report';
		$navigate['sub_nav']  = 'nicu_report';
		$input = $request->all();
		$results = NicuReport::get_lists($input); 
		$Icd     = Icd::GetList()->pluck('ICDDescription', 'ICDCode')->toArray();


		foreach ($results as &$diagnosis) {
			$diagnosis->additional_diagnosis = (isset($diagnosis->additional_diagnosis) && $diagnosis->additional_diagnosis !== '') ? implode(',', json_decode($diagnosis->additional_diagnosis)) : '' ;
			$diagnosis->DifferentialDiagnosis = (isset($diagnosis->DifferentialDiagnosis) && $diagnosis->DifferentialDiagnosis !== '') ? json_decode($diagnosis->DifferentialDiagnosis) : '' ;
		    if (is_array($diagnosis->DifferentialDiagnosis)) {
                $temp_diagnosis = '';
	            foreach ($diagnosis->DifferentialDiagnosis as $differential_diagnosis) {
	            	$temp_diagnosis .= $Icd[$differential_diagnosis].',';

	            }
	          $diagnosis->DifferentialDiagnosis = $temp_diagnosis ; 
	        }    
		}

		$closewinlink  = action('Reports\NicuReportController@filter');
		$hospital_name = isset($input['hospital_name']) ? $input['hospital_name'] : '';

		return view('reports.nicu.print', compact('results', 'navigate', 'closewinlink', 'hospital_name'));
	}
	/**
	 * DISPLAY THE FILTER FORM FOR PRINT REPORT
	 * 
	 */
	public function filter()
	{
		$navigate['main_nav'] = 'report';
		$navigate['sub_nav'] = 'nicu_report';
		$SubmitButtonText  = "Filter";
		$doctors = DoctorMaster::get_lists()->pluck('Name', 'id')->toArray();
        $this->flow->clearFlow();

		return view('reports.nicu.filter', compact('SubmitButtonText', 'navigate', 'doctors'));
	}
}
