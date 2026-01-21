<?php namespace App\Http\Controllers\reports;

use Carbon\Carbon;
use App\Models\Reports\OpReport;
use App\Models\Baby;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Flow\FlowController;

class OpReportController extends Controller 
{
	public function __construct(FlowController $flow)
	{
		$this->middleware('role:REPORT_OP,read');
		$this->flow = $flow;

	}

	/**
	 * DISPLAY THE RECORDS ACCORDING TO THE FILTERS APPLIED
	 *
	 */
	public function index(Request $request)
	{
		$navigate['main_nav'] = 'report';
		$navigate['sub_nav'] = 'op_report';
		$input = $request->all();
		$results = OpReport::get_lists($input);
		$results = $results->sortByDesc('OpDate')->groupby('SeenBy');
		$closewinlink = action('Reports\OpReportController@filter');
		$hospital_name = isset($input['hospital_name']) ? $input['hospital_name'] : '';
		return view('reports.op.print', compact('results', 'navigate', 'closewinlink', 'hospital_name'));
	}

	/**
	 * DISPLAY THE FILTER FORM FOR OP REPORT
	 * 
	 */
	public function filter()
	{
		$navigate['main_nav'] = 'report';
		$navigate['sub_nav'] = 'op_report';
		$SubmitButtonText  = "Filter";
	    $opname_list =  Config('exportfields.op_report');
	    $this->flow->clearFlow();

		return view('reports.op.filter', compact('SubmitButtonText', 'navigate', 'opname_list'));
	}



}
