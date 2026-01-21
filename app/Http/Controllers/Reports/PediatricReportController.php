<?php namespace App\Http\Controllers\reports;

use Carbon\Carbon;
use App\Models\Reports\PediatricReport;
use App\Models\Baby;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PediatricReportController extends Controller 
{
	public function __construct()
	{
		$this->middleware('role:REPORT_PEDI,read');
	}
	/**
	 * DISPLAY THE RECORDS ACCORDING TO THE FILTERS APPLIED
	 *
	 */
	public function index(Request $request)
	{
		$navigate['main_nav'] = 'report';
		$navigate['sub_nav'] = 'pediatric_report';
		
		$input = $request->all();
		
		$results = pediareport::get_lists($input); 
		
		return view('reports.pediatric.print', compact('results', 'navigate'));
	}
	/**
	 * DISPLAYS THE FILTER FORM FOR PEDIATRIC REPORT
	 *
	 */
	public function filter()
	{
		$navigate['main_nav'] = 'report';
		$navigate['sub_nav'] = 'pediatric_report';

		$SubmitButtonText  = "Filter";

		return view('reports.pediatric.filter', compact('SubmitButtonText', 'navigate'));
	}



}
