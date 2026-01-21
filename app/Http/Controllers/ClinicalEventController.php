<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Baby;
use App\Models\Mother;
use App\Models\ClinicalEvents;
use App\Models\Settings\DeleteApproval;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admission;
use App\Models\Icd;

class ClinicalEventController extends Controller 
{
	
	public function __construct(Guard $auth)
	{
		$this->middleware('role:CLINICAL_EVENT,write', ['only'=>['store', 'update', 'edit', 'create', 'show', 'destroy']]);
		$this->middleware('role:CLINICAL_EVENT,read', ['only'=>['index', 'print']]);	
		$this->auth = $auth;
	}
	/**
	 * Listing of pediatric admission.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		
	}

	/**
	 * Show the form for creating a new record.
	 *
	 */
	public function create()
	{
		$navigate['main_nav'] = 'Events';
        $navigate['sub_nav'] = 'Clinical Event';

        $baby = Baby::baby_list_daycare();

        $babies = \ValuelistHelpers::select2DataFormater($baby);
		$SubmitButtonText = 'Start';
		return view('event.clinical.select', compact('babies', 'SubmitButtonText', 'navigate'));
	}

	/**
	 * Show the form for select a record.
	 *
	 */
    public function select(Request $request) {

        $result = $request->all();

        $ids = \SiteHelpers::encrypt_id(\SiteHelpers::decrypt_id($result['baby_id']) . '-' . $result['admission_id']);

        return \Response::json(['type' => 'success', 'message' => 'Clinical Event', 'url' => action('ClinicalEventController@show', $ids)], 200);

    }

	/**
	 * Store a newly created record in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$input = $request->all();
		if (isset($input['id']) && !empty($input['id'])) {
			$id = $input['id'];
			$input['modified_user_id'] = $this->auth->user()->id;
			$input['modified_date_time'] = date('Y-m-d H:i:s');
			ClinicalEvents::where('id', $id)->update($input);
			return \Response::json(['type' => 'success', 'id' => $id, ], 200);
		}
		else
		{
			$input['created_user_id'] = $this->auth->user()->id;
			$input['created_date_time'] = date('Y-m-d H:i:s');
			$id = ClinicalEvents::insertGetId($input);
			return \Response::json(['type' => 'success', 'id' => $id, ], 200);
			// if (isset($input['diagnosis']) && !empty($input['diagnosis'])) {
			// 	$check_diagnosis = ClinicalEvents::select('id')->where('diagnosis', $input['diagnosis'])->where('baby_id', $input['baby_id'])->where('admission_id', $input['admission_id'])->first();
			// 	if(isset($check_diagnosis->id) && $check_diagnosis->id != '')
			// 	{
			// 		$id = $check_diagnosis->id;
			// 		$input['modified_user_id'] = $this->auth->user()->id;
			// 		$input['modified_date_time'] = date('Y-m-d H:i:s');
			// 		ClinicalEvents::where('id', $check_diagnosis->id)->update($input);
			// 	}
			// 	else
			// 	{
			// 		$input['created_user_id'] = $this->auth->user()->id;
			// 		$input['created_date_time'] = date('Y-m-d H:i:s');
			// 		$id = ClinicalEvents::insertGetId($input);
			// 	}
			// 	return \Response::json(['type' => 'success', 'id' => $id, ], 200);
			// }
			// elseif(isset($input['other_diagnosis']) && !empty($input['other_diagnosis']))
			// {
			// 	$check_diagnosis = ClinicalEvents::select('id')->where('other_diagnosis', $input['other_diagnosis'])->where('baby_id', $input['baby_id'])->where('admission_id', $input['admission_id'])->first();
			// 	if(isset($check_diagnosis->id) && $check_diagnosis->id != '')
			// 	{
			// 		$id = $check_diagnosis->id;
			// 		$input['modified_user_id'] = $this->auth->user()->id;
			// 		$input['modified_date_time'] = date('Y-m-d H:i:s');
			// 		ClinicalEvents::where('id', $check_diagnosis->id)->update($input);
			// 	}
			// 	else
			// 	{
			// 		$input['created_user_id'] = $this->auth->user()->id;
			// 		$input['created_date_time'] = date('Y-m-d H:i:s');
			// 		$id = ClinicalEvents::insertGetId($input);
			// 	}
			// }
			// else
			// {
			// 	return \Response::json(['type' => 'error', 'message' => 'Diagnosis is empty...!'], 500);
			// }
		}
	}

	/**
	 * FUNCTION TO SELECT THE BABY FOR PEDIATRIC ADMISISON.
	 *
	 * @param  int  $id
	 */
	public function show($id)
	{

		$navigate['main_nav'] = 'Events';
        $navigate['sub_nav'] = 'Clinical Event';

		$id = explode('-', \SiteHelpers::decrypt_id($id));
		$baby_id = $id[0];
		$admission_id = $id[1];
		$clinical_events = ClinicalEvents::select('clinical_event_details.*', 'icd.ICDDescription')
							->leftJoin('icd', function($join) {
	                            $join->on('clinical_event_details.diagnosis', '=', 'icd.ICDCode');
								$join->where('icd.is_deleted', false);
	                         })
							->where('baby_id', $baby_id)
							->where('admission_id', $admission_id)
							->where('clinical_event_details.is_deleted', false)
							->get();

		if (empty($id) && $id == 0) {
			$baby = [];
		} else {

			$baby = Baby::FindorFail($baby_id);

			$baby->Gestation = \SiteHelpers::decode_gestation($baby->Gestation);
			$baby->DOB       = date('d-m-Y', strtotime($baby->DOB));
		}

		$GetICD = Icd::where('ICDCode', '<>', '')->where('is_deleted', false)->get();
		
		$ICD = array(''=>'');
		foreach ($GetICD as $key => $value)
		{
			$ICD[$value->ICDCode] = $value->ICDDescription . '-' . $value->ICDCode;
		}
		$time   = \SiteHelpers::prepare_time();

		return view('event.clinical.show', compact('baby', 'navigate', 'baby_id', 'admission_id', 'ICD', 'time', 'clinical_events'));
	}

	/**
	 * Show the form for editing the specified record.
	 *
	 * @param  int  $id

	 */
	public function edit($id)
	{
		
	}

	/**
	 * Update the specified record.
	 *
	 * @param  int  $id
	 * @return to listing page.
	 */
	public function update($id, Request $request)
	{

	}
	/* PRINT DISPLAY FOR THE SPECIFIED RECORD */

	public function print($id)
	{
		
	}
	/**
	 * UPDATE THE SPECIFIED RECORD AS DELETED AND CREATE THE REQUEST FOR APPROVAL
	 *
	 * @param  int  $id
	 
	 */
	public function destroy(Request $request)
	{
	}
	/**
	 * UPDATE THE SPECIFIED RECORD AS DELETED AND CREATE THE REQUEST FOR APPROVAL
	 *
	 * @param  int  $id
	 
	 */
	public function removeEvent(Request $request)
	{
		$input = $request->all();
		if (isset($input['id']) && !empty($input['id'])) {
			$remove_event['is_deleted'] = true;
			$remove_event['deleted_user_id'] = $this->auth->user()->id;
			$remove_event['deleted_date_time'] = date('Y-m-d H:i:s');
			ClinicalEvents::where('id', $input['id'])->update($remove_event);
			return \Response::json(['type' => 'success', 'message' => 'Removed Successfully'], 200);	
		}
		return \Response::json(['type' => 'error', 'message' => 'Couldn\'t found event'], 500);	
	}

    /**
     * Get Admission based on
     *
     * @return \Illuminate\Http\Response json
     */
    public function getAdmission($baby_id)
    {
    	$baby_id = \SiteHelpers::decrypt_id($baby_id);
        $baby_admission = Admission::where('BabyId', $baby_id)->get()->pluck('episodes', 'AdmissionId')->toArray();
        $baby_admission[0] = '-- Select Admission --';
        ksort($baby_admission);
        return \Response::json(['data' => $baby_admission], 200);
    }
}
