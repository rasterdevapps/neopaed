<?php namespace App\Http\Controllers\calculators;

use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GlucoseController extends Controller 
{
	public function __construct()
	{
		$this->middleware('role:CALCULATOR,read');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$navigate['main_nav'] = 'calc';
		$navigate['sub_nav'] = 'glucose_calc';		

		return view('calculators.glucose.form', compact('navigate'));
	}
}
