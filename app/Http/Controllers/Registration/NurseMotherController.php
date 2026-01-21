<?php 
namespace App\Http\Controllers\Registration;

use Carbon\Carbon;
use App\Models\Mother;
use App\Models\Settings\Settings;
use App\Http\Controllers\Controller;
use App\Http\Requests\MotherRequest;
use App\Models\Settings\DeleteApproval;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Http\Controllers\Sockets\SocketController;
use App\Http\Controllers\Flow\FlowController;


class NurseMotherController extends Controller 
{   


   /**
	* checking the permission and authorization.
	*
	* @param Guard  object for authorize
	*/
	public function __construct(Guard $auth, FlowController $flow)
	{

		$this->middleware('role:MOTHER_REG,write', ['only'=>['store','update','edit','create','destory']]);
		$this->middleware('role:MOTHER_REG,read', ['only'=>['index','show']]);		
	 	$this->auth = $auth;
	 	$this->flow = $flow;

	}
	
   /**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index(Request $request) 
	{

        //Initialize the record  limit  with 50
        $limit = 50;

        //set the limit as per the request
        if (!empty($request->input('limit'))) {

            $request->session()->put('limit', $request->input('limit'));
            $limit =  $request->session()->get('limit');

        } elseif ($request->session()->has('limit')) {

            $limit =  $request->session()->get('limit');

        }

        //Initialize the record sorting key and order  
        $order['sortby']    = 'DateAdded';
        $order['sortorder'] = 'desc';   

        //set the records sorting key and order  
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {

              $order['sortby']     = \SiteHelpers::decrypt_id($request->input('sortby'));
              $order['sortorder']  = $request->input('sortorder');

        }

        //initialize search parameter array 
        $search = array();
        $search['search_txt']='';
        if (!empty($request->input('search_txt'))) {

           $search['search_txt'] = $request->input('search_txt');

        }

        //setting the navigation bar 
        $navigate['main_nav'] = 'register';
	    $navigate['sub_nav'] = 'mother';

	    //get the mother record list form mother module
	    $result  = Mother::ListDatawithSearch($request->input('page'), $limit, $search, $order, 1);
	    $results = $result['result'];

	     foreach ($results as &$value) {
	     	$baby_details   = Mother::GetMotherDependency($value->MotherId);
	     	$value->hasBaby = (count($baby_details) > 0) ? true : false;
	     		     	
	     }
	    $getTotal = Mother::GetTotal();	
	    $total    = $result['total'];	

		//custom pagination 	
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
		
		$this->flow->clearFlow();

		return view('nurse_registration.mothers_list', compact('results', 'navigate', 'pagination', 'search', 'order', 'getTotal'));
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		//setting the navigation bar
		$navigate['main_nav'] = 'register';
		$navigate['sub_nav']  = 'mother';

		/*If MRN number is alreadu available then go to baby admission page*/
		if (isset($_COOKIE["babyMrn"]) && !empty($_COOKIE["babyMrn"])) {
			$baby_details = \DB::table('baby')->where('BMrNo', $_COOKIE['babyMrn'])->where('IsDeleted', '0')->first();
			if (count($baby_details) != 0 && isset($baby_details->BabyId)) {
				return redirect(action('Registration\NurseBabyController@edit', \SiteHelpers::encrypt_id($baby_details->BabyId)));
			}
		}

		//get the settings for setting model 
        $sitesetting = Settings::get_record();
        $sitesetting = $sitesetting[0];

	    $mmrno = '';

		return view('nurse_registration.mothers_create', compact('results', 'navigate', 'mmrno', 'sitesetting'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(MotherRequest $request)
	{

		$input = $request->all();


		$input['DateModified'] = Carbon::now();
		$input['UserModified']    = $this->auth->user()->id;

		$input['MotherDOB']    = (!empty($input['MotherDOB']))  ? date('Y-m-d', strtotime($input['MotherDOB']))  : null;
		$input['PartnerDOB']   = (!empty($input['PartnerDOB'])) ? date('Y-m-d', strtotime($input['PartnerDOB'])) : null;

		$input['MothercYear']  = empty(trim($input['MothercYear']))  ?  null : $input['MothercYear'];
		$input['PartnercYear'] = empty(trim($input['PartnercYear'])) ?  null : $input['PartnercYear'];
		$input['UserModified'] = $this->auth->user()->id;

		$mother = Mother::where('MMrNo',$input['MMrNo'])->where('IsDeleted', 0)->first();


		if ($input['MotherId'] == 0 && count($mother)==0) {
			unset($input['MotherId']);
			$input['DateAdded'] = Carbon::now();
			$input['UserAdded']    = $this->auth->user()->id;
			$id = Mother::create($input)->MotherId;

		} else if(count($mother)==0){

			$results = Mother::findOrfail($input['MotherId']);
			$results->update($input);
            $id = $input['MotherId'];
		} else {
			if (!empty($input['MMrNo'])) {
		      $mother = Mother::where('MMrNo',$input['MMrNo'])->where('IsDeleted', 0)->first();
              $id = $mother->MotherId;
			}else {
				$input['DateAdded'] = Carbon::now();
				$input['UserAdded']    = $this->auth->user()->id;
			    $id = Mother::create($input)->MotherId;
			}
		}

		if (\Session::has('nurse_entry_registration_start')) {
              $this->flow->flowlog('NURSE_MOTHER_REG', null, $id, null, false, null);
        } 
      
        return redirect(url('baby-registration-nurse/create/'. \SiteHelpers::encrypt_id($id)))->with('Success', 'Mother record saved successfully !');
         
	}

	
	/**
	 * Show the form for editing the mother data
	 *
	 * @param  int  $id
	 
	 * @return edit forms
	 */
	public function edit($id)
	{
		$navigate['main_nav'] = 'register';
		$navigate['sub_nav'] = 'mother';
		$results = Mother::findOrfail($id);

		if (!is_null($results['MotherDOB'])) {
			$results['MotherDOB'] = date('d-m-Y', strtotime($results['MotherDOB']));
		} else {
			$results['MotherDOB'] = '';
		}
			
		if (!is_null($results['PartnerDOB'])) {
			$results['PartnerDOB'] = date('d-m-Y', strtotime($results['PartnerDOB']));
		} else {
			$results['PartnerDOB'] = '';
		}
        $sitesetting = Settings::get_record();
        $sitesetting = $sitesetting[0];
		$mmrno = $results['MMrNo'];
		return view('nurse_registration.mothers_edit', compact('results', 'navigate', 'mmrno', 'sitesetting'));
	}

	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @redirect listing page
	 */
	public function update($id, MotherRequest $request)
	{

		$results = Mother::findOrfail($id);
		$input = $request->all();
		$input['MotherDOB']    = (!empty($input['MotherDOB']))  ? date('Y-m-d', strtotime($input['MotherDOB']))  : null;
		$input['PartnerDOB']   = (!empty($input['PartnerDOB'])) ? date('Y-m-d', strtotime($input['PartnerDOB'])) : null;

		$input['UserModified']    = $this->auth->user()->id;
		$input['DateModified']    = Carbon::now();
		
		$results->update($input);

		if (\Session::has('registration_start')) {
		   $this->flow->flowlog('NURSE_BABY_REGISTRATION', null, $id, null, false, null);
        }
        if (isset($_COOKIE['babyCurrentWard']) && !empty($_COOKIE['babyCurrentWard']) && isset($_COOKIE['babyNurseUpdate']) && !empty($_COOKIE['babyNurseUpdate'])) {
        	
        	return redirect(action('Registration\NurseBabyController@edit', \SiteHelpers::encrypt_id($_COOKIE['babyNurseUpdate'])));
        }

        return redirect(action('Registration\NurseBabyController@create',\SiteHelpers::encrypt_id($id)))->with('Success', 'Mother record updated successfully !');

		
	}

	
	

  
	

}
