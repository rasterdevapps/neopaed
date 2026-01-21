<?php namespace App\Http\Controllers\reports;

use Carbon\Carbon;
use App\Models\Baby;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Neonatal;

class BabyReportController extends Controller 
{
	public function __construct()
	{
		$this->middleware('role:REPORT_BABY,read');
	}

	/**
	 * DISPLAY THE BABY LIST FOR PRINT SELECTION
	 *
	 */
	public function index(Request $request) 
	{
        $limit = 50;
        if (!empty($request->input('limit'))) {

            $request->session()->put('limit', $request->input('limit'));
            $limit =  $request->session()->get('limit');

        } elseif ($request->session()->has('limit')) {
            $limit =  $request->session()->get('limit');
        }


        $search = array();
        $search['search_txt']='';
        if (!empty($request->input('search_txt'))) {
            $search['search_txt'] = $request->input('search_txt');
        }

        //Initialize the record sorting key and order  
        $order['sortby']    = 'BabyId';
        $order['sortorder'] = 'desc';   

        //set the records sorting key and order  
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {

              $order['sortby']     = \SiteHelpers::decrypt_id($request->input('sortby'));
              $order['sortorder']  = $request->input('sortorder');

        }   

        $hospital_name = '';
        if ($request->input('hospital_name') && !empty($request->input('hospital_name'))) {
        	$hospital_name = $request->input('hospital_name');
        }

		$navigate['main_nav'] = 'baby_tag_print';
		$navigate['sub_nav'] = 'baby_tag_print';

        $result 	= Baby::ListDataTag($request->input('page'), $limit, $search, $order, 1, $hospital_name);
	    $results 	= $result['result'];

        $getTotal  	= Baby::GetTotal();
	    $total   	= $result['total'];	

	    $page                   = !empty($request->input('page')) ? $request->input('page') : 1;
	    $pagecount              = (!empty($search['search_txt'])) ? ceil($total/$limit) : ceil($total/$limit);
	    $pagination['total']    = $total;
	    $pagination['start']    = (($page-2) < 1) ? 1 : ($page-2);
	    $pagination['end']      = ($pagecount < ($page+3)) ? $pagecount :   ($page+3);
	    $pagestart              = $total != 0 ? ($page <= 1) ? $page : ($page-1)*$limit + 1 : 0;
	    $pagerecords            = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page*$limit;
	    $pagination['limit']    = array($pagestart, $pagerecords);
	    $pagination['limits']   = $limit;
	    $pagination['previous'] = (($page-1) < 1) ? 1 : ($page-1);
	    $pagination['next']     = ($pagecount < ($page+1)) ? $pagecount :   ($page+1);
	    
		return view('reports.baby.list', compact('results', 'navigate', 'pagination', 'search', 'getTotal', 'order'));
	}

	/**
	 * DISPLAY THE RECORDS ACCORDING TO THE FILTERS APPLIED
	 *
	 */
	public function filter(Request $request) 
	{
		$input                = $request->all();
		$navigate['main_nav'] = 'baby_tag_print';
		$navigate['sub_nav']  = 'baby_tag_print';

		$baby_list    = false;
		$closewinlink = action('Reports\BabyReportController@index');

		if (isset($input['baby_list'])) { 
			$baby_list = $input['baby_list'];
		}

		$results = Baby::GetData($baby_list);	
		return view('reports.baby.print', compact('results', 'navigate', 'closewinlink'));
	}

	/**
	 * DISPLAY THE TAG PRINT FOR SINGLE BABY RECORDS
	 *
	 */

	public function babyTagprint($BabyId) 
	{
		
		$navigate['main_nav'] = 'baby_tag_print';
		$navigate['sub_nav']  = 'baby_tag_print';

		$baby_list    = false;

		if (\Session::has('registration_start')) {
		  $neonatal = Neonatal::where("BabyId", $BabyId)->where("IsDeleted", 0)->first();
		  $closewinlink = action('Registration\NeonatalController@edit', \SiteHelpers::encrypt_id($neonatal->NeonatalId));
		} else {
		  $closewinlink = action('Reports\BabyReportController@index');
		} 


		if (isset($BabyId)) { 
			$baby_list = array($BabyId);
		}

		$results = Baby::GetData($baby_list);

		return view('reports.baby.print', compact('results', 'navigate', 'closewinlink'));
	}


}















