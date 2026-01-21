<?php 

namespace App\Http\Controllers\reports;

use Carbon\Carbon;
use App\Models\Baby;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masters\DoctorMaster;
use App\Models\Reports\InpatientReport;
use App\Http\Controllers\Flow\FlowController;


/**
 * All the curd of problem base daycare goes here
 *
 * @author Manikandan M
 */
class InpatientListController extends Controller
{
	
	public function __construct(FlowController $flow)
	{
		$this->middleware('role:REPORT_INPATIENT,read');
		$this->flow = $flow;
	}

	/**
	 * DISPLAY THE RECORDS ACCORDING TO THE FILTERS APPLIED
	 *
	 */
	public function index(Request $request)
	{
		$navigate['main_nav'] = 'report';
		$navigate['sub_nav'] = 'inpatient_report';
		$input = $request->all();
		$results = InpatientReport::get_lists($input); 
        $closewinlink  = action('HomeController@index');
        $this->flow->clearFlow();
        $hospital_name = isset($input['hospital_name']) ? $input['hospital_name'] : '';
		return view('reports.inpatient.print', compact('results', 'navigate', 'closewinlink', 'hospital_name'));
	}

	/**
	 * DISPLAY THE FILTER FORM FOR PRINT REPORT
	 * 
	 */
	public function filter()
	{
		$navigate['main_nav'] = 'report';
		$navigate['sub_nav'] = 'inpatient_report';
		$SubmitButtonText  = "Filter";
	    $doctors = DoctorMaster::ListData()->pluck('Name', 'id')->toArray();
		return view('reports.inpatient.fillter', compact('SubmitButtonText', 'navigate', 'doctors'));
	}
	
}
