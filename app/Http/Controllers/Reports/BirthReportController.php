<?php namespace App\Http\Controllers\reports;

use Carbon\Carbon;
use App\Models\Reports\BirthReport;
use App\Models\Baby;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masters\DoctorMaster;


class BirthReportController extends Controller 
{
	public function __construct()
	{
		$this->middleware('role:REPORT_BIRTH,read');
	}

	/**
	 * DISPLAY THE RECORDS ACCORDING TO THE FILTERS APPLIED
	 *
	 */
	public function index(Request $request)
	{
		$navigate['main_nav'] = 'report';
		$navigate['sub_nav'] = 'birth_report';
		$input = $request->all();
		$results = BirthReport::get_lists($input); 

        $hospital_name = isset($input['hospital_name']) ? $input['hospital_name'] : '';

		$closewinlink = action('Reports\BirthReportController@index');

		return view('reports.birth.print', compact('results', 'navigate', 'closewinlink', 'hospital_name'));
	}
	/**
	 * DISPLAY THE FILTER FORM FOR PRINT REPORT
	 * 
	 */
	public function filter()
	{
		$navigate['main_nav'] = 'report';
		$navigate['sub_nav'] = 'birth_report';
		$SubmitButtonText  = "Filter";
		$doctors = DoctorMaster::get_lists()->pluck('Name', 'id')->toArray();

		return view('reports.birth.filter', compact('SubmitButtonText', 'navigate', 'doctors'));
	}
}
