<?php namespace App\Http\Controllers\reports;

use Carbon\Carbon;
use App\Models\Reports\CultureReport;
use App\Models\Baby;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CultureReportController extends Controller 
{
	public function __construct()
	{
		$this->middleware('role:REPORT_CULTURE,read');
	}
	/**
	 * DISPLAY THE RECORDS ACCORDING TO THE FILTERS APPLIED
	 *
	 */
	public function index(Request $request)
	{
		$navigate['main_nav'] = 'report';
		$navigate['sub_nav'] = 'culture_report';
		$input = $request->all();
		$results = CultureReport::get_lists($input); 
		return view('reports.culture.print', compact('results', 'navigate'));
	}


	/**
	 * DISPLAY THE FILTER FORM FOR PRINT REPORT
	 * 
	 */
	public function filter()
	{
		$navigate['main_nav'] = 'report';
		$navigate['sub_nav'] = 'culture_report';
		$SubmitButtonText  = "Filter";
		return view('reports.culture.filter', compact('SubmitButtonText', 'navigate'));
	}



}
