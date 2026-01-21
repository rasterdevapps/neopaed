<?php

namespace App\Http\Controllers\Reports;

use Carbon\Carbon;
use App\Models\Reports\OpActivity;
use App\Models\Baby;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medications;


class OpActivityController extends Controller
{
    public function __construct()
	{
		$this->middleware('role:REPORT_OP,read');
	}

	/**
	 * DISPLAY THE RECORDS ACCORDING TO THE FILTERS APPLIED
	 *
	 */
	public function index(Request $request)
	{
		$navigate['main_nav'] = 'report';
		$navigate['sub_nav']  = 'op_activity_report';
		$input = $request->all();
		$results = OpActivity::get_lists($input); 
		$results = $results->groupby('SeenBy');
		$closewinlink = action('Reports\OpActivityController@filter');

		$hospital_name = isset($input['hospital_name']) ? $input['hospital_name'] : '';

		return view('reports.opactivity.print', compact('results', 'navigate', 'closewinlink', 'hospital_name'));
	}

	/**
	 * DISPLAY THE FILTER FORM FOR OP REPORT
	 * 
	 */
	public function filter()
	{
		$navigate['main_nav'] = 'report';
		$navigate['sub_nav'] = 'op_activity_report';

		$SubmitButtonText  = "Filter";

	    $opname_list =  Config('exportfields.op_report');
		return view('reports.opactivity.filter', compact('SubmitButtonText', 'navigate', 'opname_list'));
	}
}
