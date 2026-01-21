<?php

namespace App\Http\Controllers\Reports;

use Carbon\Carbon;
use App\Models\Baby;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masters\DoctorMaster;
use App\Models\Reports\CranialReports;

/**
 * Method to get echo list   
 * @author Manikandan M
 */

class CranialReportController extends Controller
{
    /**
    * constructor method 
    *
    */	
    public function __construct()
	{
		$this->middleware('role:REPORT_CRANIAL,read', ['only' => ['index', 'filter']]);
	}

    /**
     * Method to get echo reports based on parameter 
     *
     * @param $request instance of Illuminate\Http\Request
     * @return echo reports list to resources
     */	
	public function index(Request $request)
	{
		$navigate['main_nav'] = 'report';
		$navigate['sub_nav'] = 'cranial_report';
		$input = $request->all();
		$results = CranialReports::get_lists($input); 

        $closewinlink  = action('Reports\CranialReportController@filter');
        $doctorsMaster = DoctorMaster::get_lists()->pluck('Name', 'id')->toArray();
		return view('reports.cranial.print', compact('results', 'navigate', 'closewinlink', 'doctorsMaster'));
	}

    /**
     * Method to get echo reports filter
     *
     * @param $request instance of Illuminate\Http\Request
     * @return list resources
     */	
	public function filter()
	{
		$navigate['main_nav'] = 'report';
		$navigate['sub_nav'] = 'cranial_report';
		$SubmitButtonText  = "Filter";
	    $doctors = DoctorMaster::ListData()->pluck('Name', 'id')->toArray();
		return view('reports.cranial.fillter', compact('SubmitButtonText', 'navigate', 'doctors'));
	}
}
