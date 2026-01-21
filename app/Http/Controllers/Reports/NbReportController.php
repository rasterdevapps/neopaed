<?php namespace App\Http\Controllers\reports;

use Carbon\Carbon;
use App\Models\Reports\NbReport;
use App\Models\Baby;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NbReportController extends Controller 
{
	public function __construct()
	{
		$this->middleware('role:REPORT_NEWBORN,read');
	}

	/**
	 * DISPLAY THE RECORDS ACCORDING TO THE FILTERS APPLIED
	 *
	 */
	public function index(Request $request)
	{
		$navigate['main_nav'] = 'report';
		$navigate['sub_nav'] = 'newborn_report';
		$input = $request->all();
		$results = NbReport::get_lists($input);
        foreach ($results as $key => $value) {

        	$nicu_screening      = NbReport::get_nicu_screen($results[$key]->BabyId);
        	$postnatal_screening = NbReport::get_postnatal_screen($results[$key]->BabyId);

        	if (isset($postnatal_screening->discharge_new_born)) {

				$results[$key]->NewBornScreen = $postnatal_screening->discharge_new_born;

        	} elseif (isset($nicu_screening->NicuNewBornScreen)) {

				$results[$key]->NewBornScreen = $nicu_screening->NicuNewBornScreen;
        	} else {
        		$results[$key]->NewBornScreen = '';
        	}

        }

        $closewinlink = action('Reports\NbReportController@index');

        $hospital_name = isset($input['hospital_name']) ? $input['hospital_name'] : '';

		return view('reports.nb.print', compact('results', 'navigate', 'closewinlink', 'hospital_name'));
	}
	/**
	 * DISPLAY THE FILTER FORM FOR PRINT REPORT
	 * 
	 */
	public function filter()
	{
		$navigate['main_nav'] = 'report';
		$navigate['sub_nav'] = 'newborn_report';
		$SubmitButtonText  = "Filter";
		return view('reports.nb.filter', compact('SubmitButtonText', 'navigate'));
	}



}
