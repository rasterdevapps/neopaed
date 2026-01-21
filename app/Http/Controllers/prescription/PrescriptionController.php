<?php
namespace App\Http\Controllers\prescription;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;
use App\Models\Baby;
use App\Models\Admission;
use App\Models\Nurse\NurseIvInfusion;
use App\Models\Nurse\NurseOtherIvDrugs;
use App\Models\Nurse\NurseOtherIvInfusion;
use App\Models\Nurse\NurseGlucoseIntake;
use App\Models\Nurse\NurseOralDrugs;
use App\Models\Nurse\SyringePumpAdmisson;
use App\Models\Settings\DeleteApproval;
use Carbon\Carbon;
use App\Models\Ward\Ward;
use App\Models\Nicu;
use App\Http\Controllers\Adtmessage\AdtMessagePropertyController;
use App\Models\Fhir\FhirFormatedValues;
use App\Http\library\ValuelistHelpers;
use App\Models\IpNumber;
use App\Models\Ward\BedLog;
use App\Models\Masters\DrugAndInfusion;
use Excel;
use App\Models\prescriptionHeader;
use App\Models\prescriptionDetails;
use App\Models\DischargeLog;
use App\Models\Masters\FrequencyMaster;
use App\Models\Masters\DrugIvFluidMaster;
use App\Models\Masters\PrescriptionTypeMaster;
use App\Models\Nurse\ImportFhir;
use App\Models\Nurse\NurseSheetMain;
use App\Models\Nurse\EmrLogHeader;
use App\Models\prescription;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Http\Controllers\prescription\prescriptionFormatController;
use App\Http\Controllers\Fhir\FhirFormateController;
use App\Events\PrescriptionEvent;
use App\Http\Controllers\Fhir\PrescriptionToMirthController;


class PrescriptionController extends Controller
{

    /**
     * Time zone type
     *
     * @var $time_zone
     */
    protected $time_zone;

    /**
     * Authandication Details
     *
     * @var $auth
     */
    protected $auth;

    /**
     * Iv Infusion Interval Time
     * It's Must be In Mins.
     *
     * @var $interval_time
     */
    protected $interval_time;

    /**
     * ward instance details
     *
     * @var $ward
     */
    protected $ward;

    /**
     * Reorder the status
     *
     * @var $send_status
     */
    protected $send_status;

    public function __construct(Guard $auth, Ward $ward, AdtMessagePropertyController $adt_property)
    {
        $this->middleware('role:PRESCRIPTION,write', ['only' => ['store', 'update', 'edit', 'create', 'show', 'destroy']]);
        $this->middleware('role:PRESCRIPTION,read', ['only' => ['index', 'printData', 'print']]);

        $this->time_zone = env('TIME_ZONE');
        $this->auth = $auth;
        $this->interval_time = env('IV_INFUSION_INTERVAL');
        $this->ward = $ward;
        $this->adt_property = $adt_property;
        $this->prescription_freq = ['frequency_start_time_num', '#4D77CC', false, false, false];
        $this->prescription_date = [['prescribed_date_num', '#4D77CC', false, false, false]];
        $this->prescription_dial = [['dose_num', '#4D77CC', false, false, false], ['qty_num', '#4D77CC', false, false, false], ['rate_num', '#4D77CC', false, false, false]];

        $this->custom_error = new ErrorLogController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $navigate['main_nav'] = 'prescription';
        $navigate['sub_nav'] = 'prescription';

        $baby = Baby::baby_list_daycare();

        $babies = \ValuelistHelpers::select2DataFormater($baby);

        $SubmitButtonText = 'Start';
        return view('prescription.select', compact('babies', 'SubmitButtonText', 'navigate'));
    }

    /**
     * Get Admission based on
     *
     * @return \Illuminate\Http\Response json
     */
    public function getprescriptionadmission($baby_id)
    {
        $baby_id = \SiteHelpers::decrypt_id($baby_id);
        $baby_admission = Admission::where('BabyId', $baby_id)->get()
            ->pluck('episodes', 'AdmissionId')->toArray();
        $baby_admission[0] = '-- Select Admission --';
        ksort($baby_admission);
        return \Response::json(['data' => $baby_admission], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $prescribed_hdr = array();

        $prescribed_hdr['baby_id'] = $input['baby_id'];
        $prescribed_hdr['admission_id'] = $input['admission_id'];
        $prescribed_hdr['mother_id'] = $input['mother_id'];
        $prescribed_hdr['working_weight'] = $input['working_weight'];
        $prescribed_hdr['brand_name'] = explode(':', $input['brandname']) [1];
        $prescribed_hdr['pharmacological_name'] = explode(':', $input['brandname']) [1];
        $prescribed_hdr['created_date'] = Carbon::now($this->time_zone);
        $prescribed_hdr['created_user'] = $this->auth->user() ['id'];
        $prescribed_hdr['modified_date'] = Carbon::now($this->time_zone);
        $prescribed_hdr['modified_user'] = $this->auth->user() ['id'];
        $prescribed_hdr['prescription_type'] = isset($input['prescription_type']) ? (int)$input['prescription_type'] : 3;
        $prescribed_hdr['prescribed_by'] = (isset($input['prescribed_by']) && !empty($input['prescribed_by'])) ? $input['prescribed_by'] : 0;

        $input['prescribed_hours'] = strlen($input['prescribed_hours']) == 2 ? $input['prescribed_hours'] : '0' . $input['prescribed_hours'];
        $input['prescribed_mins'] = strlen($input['prescribed_mins']) == 2 ? $input['prescribed_mins'] : '0' . $input['prescribed_mins'];

        $input['prescribed_date'] = $input['prescribed_date'] . ' ' . $input['prescribed_hours'] . ':' . $input['prescribed_mins'] . ' ' . $input['prescribed_session'];

        $prescribed_hdr['prescription_date'] = isset($input['prescribed_date']) ? date('Y-m-d H:i:s', strtotime($input['prescribed_date'])) : null;

        $prescription_type = explode(':', $input['brandname']) [0];

        if ($prescription_type == 'IVDI')
        {
            if (empty($input['start_date']))
            {
                return \Response::json(['messageType' => 'error', 'message' => 'Please fill the starting hour']);
            }
            else
            {
                $prescribed_hdr['dose'] = (isset($input['infusion_dose']) && !empty($input['infusion_dose'])) ? $input['infusion_dose'] : 0;
                $prescribed_hdr['dose_units_g'] = isset($input['infusion_dose_units_g']) ? $input['infusion_dose_units_g'] : null;
                $prescribed_hdr['dose_units_kg'] = isset($input['infusion_dose_units_kg']) ? $input['infusion_dose_units_kg'] : null;
                $prescribed_hdr['dose_units_time'] = isset($input['infusion_dose_units_time']) ? $input['infusion_dose_units_time'] : null;
                $prescribed_hdr['quantity'] = (isset($input['infusion_quantity']) && !empty($input['infusion_quantity'])) ? $input['infusion_quantity'] : 0;
                $prescribed_hdr['quantity_units'] = isset($input['quantity_units']) ? $input['quantity_units'] : null;
                $prescribed_hdr['syringe_size'] = (isset($input['infusion_syringe']) && !empty($input['infusion_syringe'])) ? $input['infusion_syringe'] : 0;
                $prescribed_hdr['rate'] = (isset($input['infusion_rate']) && !empty($input['infusion_rate'])) ? $input['infusion_rate'] : 0;
                $prescribed_hdr['infusion_type'] = 'IV';
                $prescribed_hdr['glucose_infusion_rate'] = (isset($input['glucose_infusion_rate']) && !empty($input['glucose_infusion_rate'])) ? $input['glucose_infusion_rate'] : null;
                $prescribed_hdr['glucose_concentration'] = (isset($input['glucose_concentration']) && !empty($input['glucose_concentration'])) ? $input['glucose_concentration'] : null;
                $prescribed_hdr['instruction'] = isset($input['infusion_instruction']) ? $input['infusion_instruction'] : null;
                $prescribed_hdr['drug_added'] = isset($input['infusion_drug_added']) ? $input['infusion_drug_added'] : null;
                $prescribed_hdr['dose_feq_addition'] = isset($input['infusion_feq_addition']) ? $input['infusion_feq_addition'] : null;
                $prescribed_hdr['batch_no'] = isset($input['infusion_batch_no']) ? $input['infusion_batch_no'] : null;

                $input['start_hours'] = strlen($input['start_hours']) == 2 ? $input['start_hours'] : '0' . $input['start_hours'];
                $input['start_mins'] = strlen($input['start_mins']) == 2 ? $input['start_mins'] : '0' . $input['start_mins'];

                $input['start_date'] = $input['start_date'] . ' ' . $input['start_hours'] . ':' . $input['start_mins'] . ' ' . $input['start_session'];

                $prescribed_hdr['start_date'] = isset($input['start_date']) ? date('Y-m-d H:i:s', strtotime($input['start_date'])) : null;

                $prescribed_hdr['pres_hdr'] = prescriptionHeader::create($prescribed_hdr)->id;

                $prescribed_dtl['pres_hdr_id'] = $prescribed_hdr['pres_hdr'];
                $prescribed_dtl['day'] = empty($input['day']) ? null : $input['day'];
                $prescribed_dtl['created_date'] = Carbon::now($this->time_zone);
                $prescribed_dtl['created_user'] = $this->auth->user() ['id'];
                $prescribed_dtl['modified_date'] = Carbon::now($this->time_zone);
                $prescribed_dtl['modified_user'] = $this->auth->user() ['id'];
                $prescribed_dtl['event_time'] = date('Y-m-d H:i:s', strtotime($input['start_date']));

                $prescribed_dtl['pres_value'] = prescriptionDetails::create($prescribed_dtl)->id;

                prescriptionDetails::where('id', $prescribed_dtl['pres_value'])->update(['order_id' => $prescribed_dtl['pres_value'], 'prescription_id' => 'IVDI' . $prescribed_dtl['pres_value'] . round(microtime(true) * 1000) ]);

            }
        } else if ($prescription_type == 'OIVD')
        {

            if (empty($input['start_date']) || (!isset($input['frequency_start_time']) || empty($input['frequency_start_time'])) || (!isset($input['starthour']) || empty($input['starthour'])))
            {
                return \Response::json(['messageType' => 'error', 'message' => 'Please fill the starting hour']);
            }
            else
            {
                if ($input['frequency_start_time'] == 12 && $input["starthour"] == "am")
                {
                    $frequency_start_time = 0;
                }
                elseif ($input['frequency_start_time'] == 12 && $input["starthour"] == "pm")
                {
                    $frequency_start_time = 12;
                }
                else
                {
                    $frequency_start_time = $input['frequency_start_time'] + ($input["starthour"] == "am" ? 0 : 12);
                }

                $prescribed_hdr['start_date'] = isset($input['start_date']) ? date('Y-m-d', strtotime($input['start_date'])) . ' ' . $frequency_start_time . ':00:00' : null;
                $prescribed_hdr['review_date'] = isset($input['other_iv_drugs_review_date']) ? date('Y-m-d', strtotime($input['other_iv_drugs_review_date'])) : null;
                $prescribed_hdr['dose'] = (isset($input['other_iv_drugs_dose_required']) && !empty($input['other_iv_drugs_dose_required'])) ? $input['other_iv_drugs_dose_required'] : 0;
                $prescribed_hdr['dose_units_g'] = isset($input['drugs_dose_units']) ? $input['drugs_dose_units'] : null;
                $prescribed_hdr['alt_dose'] = (isset($input['other_iv_drugs_alt_dose']) && !empty($input['other_iv_drugs_alt_dose'])) ? $input['other_iv_drugs_alt_dose'] : 0;
                $prescribed_hdr['alt_dose_units_g'] = isset($input['drugs_alt_dose_units']) ? $input['drugs_alt_dose_units'] : null;
                $prescribed_hdr['frequency'] = isset($input['other_iv_drugs_frequency']) ? $input['other_iv_drugs_frequency'] : null;
                $prescribed_hdr['syringe_size'] = (isset($input['other_iv_drugs_syringe']) && !empty($input['other_iv_drugs_syringe'])) ? $input['other_iv_drugs_syringe'] : 0;
                $prescribed_hdr['rate'] = (isset($input['other_iv_drugs_rate']) && !empty($input['other_iv_drugs_rate'])) ? $input['other_iv_drugs_rate'] : 0;
                $prescribed_hdr['infusion_type'] = 'IV';
                $prescribed_hdr['instruction'] = isset($input['other_iv_drugs_additional']) ? $input['other_iv_drugs_additional'] : null;
                $review_date = $prescribed_hdr['review_date'] . ' 23:59:59';

                $prescribed_hdr['pres_hdr'] = prescriptionHeader::create($prescribed_hdr)->id;

                $frequency_count = preg_replace('/[Q,H]/', '', $prescribed_hdr['frequency']);

                $date1 = date_create($prescribed_hdr['start_date']);
                $date2 = date_create($review_date);
                $diff = date_diff($date1, $date2);
                $diff_days = $diff->days;
                $diff_hours = $diff->h;

                $diff = ($diff_days * 24) + $diff_hours;
                
                $frequency_grap = 0;
                
                if ($diff > 0 && is_numeric($frequency_count) && $frequency_count > 0)
                {
                    $frequency_grap = $diff / $frequency_count;
                }

                if (isset($frequency_count) && is_numeric($frequency_count) && isset($frequency_grap) && $frequency_grap > 0)
                {

                    for ($i = 0;$i <= $frequency_grap;$i++)
                    {

                        $prescribed_dtl['pres_hdr_id'] = $prescribed_hdr['pres_hdr'];
                        $prescribed_dtl['day'] = empty($input['day']) ? null : $input['day'];
                        $prescribed_dtl['created_date'] = Carbon::now($this->time_zone);
                        $prescribed_dtl['created_user'] = $this->auth->user() ['id'];
                        $prescribed_dtl['modified_date'] = Carbon::now($this->time_zone);
                        $prescribed_dtl['modified_user'] = $this->auth->user() ['id'];
                        if ($i == 0)
                        {
                            $prescribed_dtl['event_time'] = $prescribed_hdr['start_date'];
                        }
                        else
                        {
                            $prescribed_hdr['start_date'] = $prescribed_dtl['event_time'] = Carbon::createFromFormat('Y-m-d H:i:s', $prescribed_hdr['start_date'])->addHours($frequency_count);
                        }

                        $prescribed_dtl['pres_value'] = prescriptionDetails::create($prescribed_dtl)->id;

                        prescriptionDetails::where('id', $prescribed_dtl['pres_value'])->update(['order_id' => $prescribed_dtl['pres_value'], 'prescription_id' => 'OIVD' . $prescribed_dtl['pres_value'] . round(microtime(true) * 1000) ]);

                    }

                }
                else
                {

                    $prescribed_dtl['pres_hdr_id'] = $prescribed_hdr['pres_hdr'];
                    $prescribed_dtl['day'] = empty($input['day']) ? null : $input['day'];
                    $prescribed_dtl['created_date'] = Carbon::now($this->time_zone);
                    $prescribed_dtl['created_user'] = $this->auth->user() ['id'];
                    $prescribed_dtl['modified_date'] = Carbon::now($this->time_zone);
                    $prescribed_dtl['modified_user'] = $this->auth->user() ['id'];
                    $prescribed_dtl['event_time'] = date('Y-m-d H:i:s', strtotime($prescribed_hdr['start_date']));

                    $prescribed_dtl['pres_value'] = prescriptionDetails::create($prescribed_dtl)->id;

                    prescriptionDetails::where('id', $prescribed_dtl['pres_value'])->update(['order_id' => $prescribed_dtl['pres_value'], 'prescription_id' => 'OIVD' . $prescribed_dtl['pres_value'] . round(microtime(true) * 1000) ]);

                }

            }
        } else if ($prescription_type == 'OIVI')
        {
            if (empty($input['start_date']))
            {
                return \Response::json(['messageType' => 'error', 'message' => 'Please fill the starting hour']);
            }
            else
            {
                $prescribed_hdr['volume'] = (isset($input['other_infusions_volume']) && !empty($input['other_infusions_volume'])) ? $input['other_infusions_volume'] : 0;
                $prescribed_hdr['duration'] = (isset($input['other_infusions_duration']) && !empty($input['other_infusions_duration'])) ? $input['other_infusions_duration'] : 0;
                $prescribed_hdr['duration_time'] = isset($input['other_infusions_durametnod']) ? $input['other_infusions_durametnod'] : null;
                $prescribed_hdr['rate'] = (isset($input['other_infusions_rate']) && !empty($input['other_infusions_rate'])) ? $input['other_infusions_rate'] : 0;
                $prescribed_hdr['infusion_type'] = isset($input['other_infusions_pump_type']) ? $input['other_infusions_pump_type'] : null;
                $prescribed_hdr['glucose_infusion_rate'] = (isset($input['glucose_infusion_rate']) && !empty($input['glucose_infusion_rate'])) ? $input['glucose_infusion_rate'] : null;
                $prescribed_hdr['glucose_concentration'] = (isset($input['glucose_concentration']) && !empty($input['glucose_concentration'])) ? $input['glucose_concentration'] : null;
                $prescribed_hdr['instruction'] = isset($input['other_infusions_instruction']) ? $input['other_infusions_instruction'] : null;
                $prescribed_hdr['drug_added'] = isset($input['other_infusions_drug_added']) ? $input['other_infusions_drug_added'] : null;
                $prescribed_hdr['dose_feq_addition'] = isset($input['other_infusions_dose_feq_addition']) ? $input['other_infusions_dose_feq_addition'] : null;
                $prescribed_hdr['batch_no'] = isset($input['other_infusions_batch_no']) ? $input['other_infusions_batch_no'] : null;

                $input['start_hours'] = strlen($input['start_hours']) == 2 ? $input['start_hours'] : '0' . $input['start_hours'];
                $input['start_mins'] = strlen($input['start_mins']) == 2 ? $input['start_mins'] : '0' . $input['start_mins'];

                $input['start_date'] = $input['start_date'] . ' ' . $input['start_hours'] . ':' . $input['start_mins'] . ' ' . $input['start_session'];

                $prescribed_hdr['start_date'] = isset($input['start_date']) ? date('Y-m-d H:i:s', strtotime($input['start_date'])) : null;

                $prescribed_hdr['pres_hdr'] = prescriptionHeader::create($prescribed_hdr)->id;

                $prescribed_dtl['pres_hdr_id'] = $prescribed_hdr['pres_hdr'];
                $prescribed_dtl['day'] = empty($input['day']) ? null : $input['day'];
                $prescribed_dtl['created_date'] = Carbon::now($this->time_zone);
                $prescribed_dtl['created_user'] = $this->auth->user() ['id'];
                $prescribed_dtl['modified_date'] = Carbon::now($this->time_zone);
                $prescribed_dtl['modified_user'] = $this->auth->user() ['id'];
                $prescribed_dtl['event_time'] = $prescribed_dtl['created_date'];

                $prescribed_dtl['pres_value'] = prescriptionDetails::create($prescribed_dtl)->id;

                prescriptionDetails::where('id', $prescribed_dtl['pres_value'])->update(['order_id' => $prescribed_dtl['pres_value'], 'prescription_id' => 'OIVI' . $prescribed_dtl['pres_value'] . round(microtime(true) * 1000) ]);

            }
        } else if ($prescription_type == 'ORAL')
        {
            if (empty($input['start_date']) || (!isset($input['frequency_start_time']) || empty($input['frequency_start_time'])) || (!isset($input['starthour']) || empty($input['starthour'])))
            {
                return \Response::json(['messageType' => 'error', 'message' => 'Please fill the starting hour']);
            }
            else
            {
                if ($input['frequency_start_time'] == 12 && $input["starthour"] == "am")
                {
                    $frequency_start_time = 0;
                }
                elseif ($input['frequency_start_time'] == 12 && $input["starthour"] == "pm")
                {
                    $frequency_start_time = 12;
                }
                else
                {
                    $frequency_start_time = $input['frequency_start_time'] + ($input["starthour"] == "am" ? 0 : 12);
                }

                $prescribed_hdr['start_date'] = isset($input['start_date']) ? date('Y-m-d', strtotime($input['start_date'])) . ' ' . $frequency_start_time . ':00:00' : null;
                $prescribed_hdr['review_date'] = isset($input['oral_review_date']) ? date('Y-m-d', strtotime($input['oral_review_date'])) : null;
                $prescribed_hdr['dose'] = (isset($input['oral_dose_required']) && !empty($input['oral_dose_required'])) ? $input['oral_dose_required'] : 0;
                $prescribed_hdr['dose_units_g'] = isset($input['drugs_dose_units']) ? $input['drugs_dose_units'] : null;
                $prescribed_hdr['alt_dose'] = (isset($input['oral_alt_dose_required']) && !empty($input['oral_alt_dose_required'])) ? $input['oral_alt_dose_required'] : 0;
                $prescribed_hdr['alt_dose_units_g'] = isset($input['drugs_alt_dose_units']) ? $input['drugs_alt_dose_units'] : null;
                $prescribed_hdr['frequency'] = isset($input['oral_frequency']) ? $input['oral_frequency'] : null;
                $prescribed_hdr['oral_route'] = isset($input['oral_route']) ? $input['oral_route'] : null;
                $prescribed_hdr['instruction'] = isset($input['oral_additional']) ? $input['oral_additional'] : null;
                $review_date = $prescribed_hdr['review_date'] . ' 23:59:59';

                $prescribed_hdr['pres_hdr'] = prescriptionHeader::create($prescribed_hdr)->id;

                $frequency_count = preg_replace('/[Q,H]/', '', $prescribed_hdr['frequency']);

                $date1 = date_create($prescribed_hdr['start_date']);
                $date2 = date_create($review_date);
                $diff = date_diff($date1, $date2);
                $diff_days = $diff->days;
                $diff_hours = $diff->h;

                $diff = ($diff_days * 24) + $diff_hours;
                
                $frequency_grap = 0;

                if ($diff > 0 && ($frequency_count > 0 && is_numeric($frequency_count)))
                {
                    $frequency_grap = $diff / $frequency_count;
                }

                if (isset($frequency_count) && is_numeric($frequency_count) && isset($frequency_grap) && $frequency_grap > 0)
                {

                    for ($i = 0;$i <= $frequency_grap;$i++)
                    {

                        $prescribed_dtl['pres_hdr_id'] = $prescribed_hdr['pres_hdr'];
                        $prescribed_dtl['day'] = empty($input['day']) ? null : $input['day'];
                        $prescribed_dtl['created_date'] = Carbon::now($this->time_zone);
                        $prescribed_dtl['created_user'] = $this->auth->user() ['id'];
                        $prescribed_dtl['modified_date'] = Carbon::now($this->time_zone);
                        $prescribed_dtl['modified_user'] = $this->auth->user() ['id'];
                        if ($i == 0)
                        {
                            $prescribed_dtl['event_time'] = $prescribed_hdr['start_date'];
                        }
                        else
                        {
                            $prescribed_hdr['start_date'] = $prescribed_dtl['event_time'] = Carbon::createFromFormat('Y-m-d H:i:s', $prescribed_hdr['start_date'])->addHours($frequency_count);
                        }

                        $prescribed_dtl['pres_value'] = prescriptionDetails::create($prescribed_dtl)->id;

                        prescriptionDetails::where('id', $prescribed_dtl['pres_value'])->update(['order_id' => $prescribed_dtl['pres_value'], 'prescription_id' => 'ORAL' . $prescribed_dtl['pres_value'] . round(microtime(true) * 1000) ]);

                    }

                }
                else
                {

                    $prescribed_dtl['pres_hdr_id'] = $prescribed_hdr['pres_hdr'];
                    $prescribed_dtl['day'] = empty($input['day']) ? null : $input['day'];
                    $prescribed_dtl['created_date'] = Carbon::now($this->time_zone);
                    $prescribed_dtl['created_user'] = $this->auth->user() ['id'];
                    $prescribed_dtl['modified_date'] = Carbon::now($this->time_zone);
                    $prescribed_dtl['modified_user'] = $this->auth->user() ['id'];
                    $prescribed_dtl['event_time'] = date('Y-m-d H:i:s', strtotime($prescribed_hdr['start_date']));

                    $prescribed_dtl['pres_value'] = prescriptionDetails::create($prescribed_dtl)->id;

                    prescriptionDetails::where('id', $prescribed_dtl['pres_value'])->update(['order_id' => $prescribed_dtl['pres_value'], 'prescription_id' => 'ORAL' . $prescribed_dtl['pres_value'] . round(microtime(true) * 1000) ]);

                }
            }
        }

        $post['baby_id'] = $prescribed_hdr['baby_id'];
        $post['admission_id'] = $prescribed_hdr['admission_id'];
        $post['prescription_type'] = $prescribed_hdr['prescription_type'];
        $post['prescription_from'] = 5;

        $this->prescriptionSendToUser($post);

        \SiteHelpers::updateDashboardAtFormUpdation($input['baby_id'], 'Prescription - Create');

        return \Response::json(['messageType' => 'success', 'message' => 'Added Succcessfully', 'data' => $post], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $closewinlink = '')
    {

        $navigate['main_nav'] = 'prescription';
        $navigate['sub_nav'] = 'prescription';

        $id = \SiteHelpers::decrypt_id($id);

        if (count(explode('-', $id)) == 2)
        {
            $ids = explode('-', $id);
        }
        else
        {
            return redirect()->back()
            ->with('Success', 'Record Saved Successfully');
        }
        $nurse_sheet_back = $ids[1] . '-' . $ids[0];

        $baby_id = $ids[0];
        $admission_id = $ids[1];

        $nurse_sheet_back = \SiteHelpers::encrypt_id($nurse_sheet_back);

        $baby_details = Baby::find($baby_id);
        $mother_id = $baby_details->MotherId;

        $ip_details = IpNumber::getCurrent_ip($baby_id, $admission_id);

        $patient_detail_table = DischargeLog::getDischargeDetail($baby_id, $admission_id);

        $time_master = \SiteHelpers::prepare_time();

        $prescription_key_id = \SiteHelpers::prescriptionKeyId();

        $post_data = new Request([
            'baby_id' => $baby_id,
            'admission_id' => $admission_id,
        ]);

        $prescription_record = $this->prescriptionData($post_data);

        $prescription_list = $prescription_record['prescription_list'];
        $intravenous_prescription_list = $prescription_record['intravenous_prescription_list'];
        $prescribed_date_list = $prescription_record['prescribed_date_list'];

        if (count($patient_detail_table) > 0)
        {

            $is_discharged = true;

        }
        else
        {

            $is_discharged = false;

        }

        $drug_iv_fluid_name = \DB::table('mas_drugivfluid')->select('*')
        ->selectRaw('name|| \':\' ||mas_prescription_type.value as namevalue')
        ->leftjoin('mas_prescription_type', 'mas_prescription_type.value', 'type')
        ->where(['mas_drugivfluid.is_deleted' => 0, 'mas_drugivfluid.status' => 1, 'mas_prescription_type.is_deleted' => 0])
        ->where('brand_name', '!=', '')
        ->orderBy('pres_id')
        ->get()
        ->groupBy('namevalue')->map(function ($group)
        {
            return $group->pluck('brand_name', 'id');
        });

        $drug_iv_fluid_phar_gen = \DB::table('mas_drugivfluid')->select('*')
        ->selectRaw('name|| \':\' ||mas_prescription_type.value as namevalue')
        ->leftjoin('mas_prescription_type', 'mas_prescription_type.value', 'type')
        ->where(['mas_drugivfluid.is_deleted' => 0, 'mas_drugivfluid.status' => 1, 'mas_prescription_type.is_deleted' => 0])
            // ->where('generic_pharmacological_name', '!=', '')
        ->orderBy('pres_id')
        ->get()
        ->groupBy('namevalue')->map(function ($group)
        {
            return $group->pluck('generic_pharmacological_name', 'id');
        });

        $drug_iv_fluid_attributes = \DB::table('mas_drugivfluid')->select('id', 'is_glucose_infusion_rate_required', 'is_glucose_concentration_required')
        ->where(['is_deleted' => 0, 'status' => 1])
        ->get()
        ->keyBy('id')
        ->map(function ($item) {
             return [
                 'is_gir' => $item->is_glucose_infusion_rate_required ? 'true' : 'false',
                 'is_gc' => $item->is_glucose_concentration_required ? 'true' : 'false'
             ];
        });

        // $frequency_list = FrequencyMaster::where(['is_deleted' => 0, 'status' => 1])->where('name', '!=', '')
        //     ->orderBy('freq_id', 'asc')
        //     ->pluck('name', 'value')
        //     ->toArray();

        $id = \SiteHelpers::encrypt_id($id);

        $working_weight = $this->getWorkingWeight($baby_id, $admission_id);

        $syringe_pump = SyringePumpAdmisson::getSyirangePumpDetails($baby_id, $admission_id, false);
        $bed_logs = BedLog::getBedDeatails($baby_id, $admission_id);

        $bed_id = isset($bed_logs->bed_id) ? $bed_logs->bed_id : null;
        $pump_type = isset($bed_logs->pump_type) ? $bed_logs->pump_type : null;
        $room_no = isset($bed_logs->room_no) ? $bed_logs->room_no : null;
        $bed_no = isset($bed_logs->bed_no) ? $bed_logs->bed_no : null;

        $prescription_type = PrescriptionTypeMaster::getPrescriptionType();

        $prescription_freq_dialpad = $this->prescription_freq;
        $prescription_date_dialpad = $this->prescription_date;
        $prescription_dialpad = $this->prescription_dial;

        $user_role = $this->auth->user() ['RoleId'];

        if ($closewinlink == 'nicu-nurse-sheets' || $closewinlink == 'ward-dashboard')
        {
            $closelink = action('Nurse\NurseSheetController@GetDaylist', \SiteHelpers::encrypt_id($admission_id)) . '/' . $closewinlink;
        }
        else
        {
            $closewinlink = '';
            $closelink = url('ward-dashboard');
        }

        $doctor_id = $this->auth->user() ['mas_id'];

        return view('prescription.prescription_create', compact('bed_id', 'syringe_pump', 'id', 'baby_id', 'mother_id', 'admission_id', 'nurse_sheet_back', 'baby_details', 'time_master', 'working_weight', 'ip_details', 'navigate', 'is_discharged', 'drug_iv_fluid_name', 'drug_iv_fluid_phar_gen', 'prescription_list', 'prescription_type', 'prescription_freq_dialpad', 'prescribed_date_list', 'user_role', 'prescription_date_dialpad', 'prescription_dialpad', 'closelink', 'closewinlink', 'pump_type', 'doctor_id', 'bed_no', 'room_no', 'intravenous_prescription_list', 'drug_iv_fluid_attributes'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editPrescription(Request $request)
    {
        $id = $request->all() ['hdr_id'];

        $result_hdr = prescriptionHeader::findOrfail($id);

        $result_dtl = prescriptionDetails::where('pres_hdr_id', $id)->orderBy('id', 'desc')->first();

        return \Response::json(['messageType' => 'success', 'message' => 'Added Succcessfully', 'result_hdr' => $result_hdr, 'result_dtl' => $result_dtl], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $result_hdr = prescriptionHeader::findOrfail($input['pres_id']);

        $prescribed_hdr['working_weight'] = $input['working_weight'];
        $prescribed_hdr['modified_date'] = Carbon::now($this->time_zone);
        $prescribed_hdr['modified_user'] = $this->auth->user() ['id'];
        $prescribed_hdr['prescription_type'] = isset($input['prescription_type']) ? (int)$input['prescription_type'] : 3;
        $prescribed_hdr['prescribed_by'] = (isset($input['prescribed_by']) && !empty($input['prescribed_by'])) ? $input['prescribed_by'] : 0;

        if (isset($input['infusion_rate']))
        {
            $prescribed_hdr['dose'] = (isset($input['infusion_dose']) && !empty($input['infusion_dose'])) ? $input['infusion_dose'] : 0;
            $prescribed_hdr['dose_units_g'] = isset($input['infusion_dose_units_g']) ? $input['infusion_dose_units_g'] : null;
            $prescribed_hdr['dose_units_kg'] = isset($input['infusion_dose_units_kg']) ? $input['infusion_dose_units_kg'] : null;
            $prescribed_hdr['dose_units_time'] = isset($input['infusion_dose_units_time']) ? $input['infusion_dose_units_time'] : null;
            $prescribed_hdr['quantity'] = (isset($input['infusion_quantity']) && !empty($input['infusion_quantity'])) ? $input['infusion_quantity'] : 0;
            $prescribed_hdr['quantity_units'] = isset($input['quantity_units']) ? $input['quantity_units'] : null;
            $prescribed_hdr['syringe_size'] = (isset($input['infusion_syringe']) && !empty($input['infusion_syringe'])) ? $input['infusion_syringe'] : 0;
            $prescribed_hdr['rate'] = (isset($input['infusion_rate']) && !empty($input['infusion_rate'])) ? $input['infusion_rate'] : 0;
            $prescribed_hdr['infusion_type'] = 'IV';
            $prescribed_hdr['glucose_infusion_rate'] = (isset($input['glucose_infusion_rate']) && !empty($input['glucose_infusion_rate'])) ? $input['glucose_infusion_rate'] : null;
            $prescribed_hdr['glucose_concentration'] = (isset($input['glucose_concentration']) && !empty($input['glucose_concentration'])) ? $input['glucose_concentration'] : null;
            $prescribed_hdr['instruction'] = isset($input['infusion_instruction']) ? $input['infusion_instruction'] : null;
            $prescribed_hdr['drug_added'] = isset($input['infusion_drug_added']) ? $input['infusion_drug_added'] : null;
            $prescribed_hdr['dose_feq_addition'] = isset($input['infusion_feq_addition']) ? $input['infusion_feq_addition'] : null;
            $prescribed_hdr['batch_no'] = isset($input['infusion_batch_no']) ? $input['infusion_batch_no'] : null;

            $input['start_hours'] = strlen($input['start_hours']) == 2 ? $input['start_hours'] : '0' . $input['start_hours'];
            $input['start_mins'] = strlen($input['start_mins']) == 2 ? $input['start_mins'] : '0' . $input['start_mins'];

            $input['start_date'] = $input['start_date'] . ' ' . $input['start_hours'] . ':' . $input['start_mins'] . ' ' . $input['start_session'];
            $prescribed_hdr['start_date'] = isset($input['start_date']) ? date('Y-m-d H:i:s', strtotime($input['start_date'])) : null;

            $result_hdr->update($prescribed_hdr);

            $prescribed_dtl['event_time'] = $prescribed_hdr['start_date'];
            $prescribed_dtl['modified_date'] = Carbon::now($this->time_zone);
            $prescribed_dtl['modified_user'] = $this->auth->user() ['id'];

            prescriptionDetails::where('pres_hdr_id', $input['pres_id'])->update($prescribed_dtl);

        }

        if (isset($input['other_iv_drugs_syringe']))
        {
            if (!isset($input['frequency_start_time']) || empty($input['frequency_start_time']))
            {
                return \Response::json(['messageType' => 'error', 'message' => 'Please fill the starting hour']);
            }
            else
            {
                if ($input['frequency_start_time'] == 12 && $input["starthour"] == "am")
                {
                    $frequency_start_time = 0;
                }
                elseif ($input['frequency_start_time'] == 12 && $input["starthour"] == "pm")
                {
                    $frequency_start_time = 12;
                }
                else
                {
                    $frequency_start_time = $input['frequency_start_time'] + ($input["starthour"] == "am" ? 0 : 12);
                }

                $prescribed_hdr['dose'] = (isset($input['other_iv_drugs_dose_required']) && !empty($input['other_iv_drugs_dose_required'])) ? $input['other_iv_drugs_dose_required'] : 0;
                $prescribed_hdr['dose_units_g'] = isset($input['drugs_dose_units']) ? $input['drugs_dose_units'] : null;
                $prescribed_hdr['alt_dose'] = (isset($input['other_iv_drugs_alt_dose']) && !empty($input['other_iv_drugs_alt_dose'])) ? $input['other_iv_drugs_alt_dose'] : 0;
                $prescribed_hdr['alt_dose_units_g'] = isset($input['drugs_alt_dose_units']) ? $input['drugs_alt_dose_units'] : null;
                $prescribed_hdr['syringe_size'] = (isset($input['other_iv_drugs_syringe']) && !empty($input['other_iv_drugs_syringe'])) ? $input['other_iv_drugs_syringe'] : 0;
                $prescribed_hdr['rate'] = (isset($input['other_iv_drugs_rate']) && !empty($input['other_iv_drugs_rate'])) ? $input['other_iv_drugs_rate'] : 0;
                $prescribed_hdr['infusion_type'] = 'IV';
                $prescribed_hdr['instruction'] = isset($input['other_iv_drugs_additional']) ? $input['other_iv_drugs_additional'] : null;
                $prescribed_hdr['frequency'] = isset($input['other_iv_drugs_frequency']) ? $input['other_iv_drugs_frequency'] : null;
                $prescribed_hdr['start_date'] = isset($input['start_date']) ? date('Y-m-d', strtotime($input['start_date'])) . ' ' . $frequency_start_time . ':00:00' : null;
                $prescribed_hdr['review_date'] = isset($input['other_iv_drugs_review_date']) ? date('Y-m-d', strtotime($input['other_iv_drugs_review_date'])) : null;
                $review_date = $prescribed_hdr['review_date'] . ' 23:59:59';

                $result_hdr->update($prescribed_hdr);

                if (($input['frequency_old'] != $input['other_iv_drugs_frequency']) || ($input['start_date_old'] != $input['start_date']) || ($input['start_hours_old'] != $input['frequency_start_time']) || ($input['start_session_old'] != $input['starthour']) || $input['review_date_old'] != $input['other_iv_drugs_review_date'])
                {

                    $prescribed_dtl['is_send'] = '99';
                    $prescribed_dtl['order_status'] = 'EP'; // Edit Prescription
                    $prescribed_dtl['modified_date'] = Carbon::now($this->time_zone);
                    $prescribed_dtl['modified_user'] = $this->auth->user() ['id'];

                    prescriptionDetails::where('pres_hdr_id', $input['pres_id'])->update($prescribed_dtl);

                    $prescribed_dtl = array();

                    $frequency_count = preg_replace('/[Q,H]/', '', $prescribed_hdr['frequency']);

                    $date1 = date_create($prescribed_hdr['start_date']);
                    $date2 = date_create($review_date);
                    $diff = date_diff($date1, $date2);
                    $diff_days = $diff->days;
                    $diff_hours = $diff->h;

                    $diff = ($diff_days * 24) + $diff_hours;

                    if ($diff > 0 && is_numeric($frequency_count))
                    {
                        $frequency_grap = $diff / $frequency_count;
                    }

                    if (isset($frequency_count) && is_numeric($frequency_count) && isset($frequency_grap) && $frequency_grap > 0)
                    {

                        for ($i = 0;$i <= $frequency_grap;$i++)
                        {

                            $prescribed_dtl['pres_hdr_id'] = $input['pres_id'];
                            $prescribed_dtl['day'] = empty($input['day']) ? null : $input['day'];
                            $prescribed_dtl['created_date'] = Carbon::now($this->time_zone);
                            $prescribed_dtl['created_user'] = $this->auth->user() ['id'];
                            $prescribed_dtl['modified_date'] = Carbon::now($this->time_zone);
                            $prescribed_dtl['modified_user'] = $this->auth->user() ['id'];
                            if ($i == 0)
                            {
                                $prescribed_dtl['event_time'] = $prescribed_hdr['start_date'];
                            }
                            else
                            {
                                $prescribed_hdr['start_date'] = $prescribed_dtl['event_time'] = Carbon::createFromFormat('Y-m-d H:i:s', $prescribed_hdr['start_date'])->addHours($frequency_count);
                            }

                            $prescribed_dtl['pres_value'] = prescriptionDetails::create($prescribed_dtl)->id;

                            prescriptionDetails::where('id', $prescribed_dtl['pres_value'])->update(['order_id' => $prescribed_dtl['pres_value'], 'prescription_id' => 'OIVD' . $prescribed_dtl['pres_value'] . round(microtime(true) * 1000) ]);

                        }

                    }
                    else
                    {

                        $prescribed_dtl['pres_hdr_id'] = $input['pres_id'];
                        $prescribed_dtl['day'] = empty($input['day']) ? null : $input['day'];
                        $prescribed_dtl['created_date'] = Carbon::now($this->time_zone);
                        $prescribed_dtl['created_user'] = $this->auth->user() ['id'];
                        $prescribed_dtl['modified_date'] = Carbon::now($this->time_zone);
                        $prescribed_dtl['modified_user'] = $this->auth->user() ['id'];
                        $prescribed_dtl['event_time'] = date('Y-m-d H:i:s', strtotime($prescribed_hdr['start_date']));

                        $prescribed_dtl['pres_value'] = prescriptionDetails::create($prescribed_dtl)->id;

                        prescriptionDetails::where('id', $prescribed_dtl['pres_value'])->update(['order_id' => $prescribed_dtl['pres_value'], 'prescription_id' => 'OIVD' . $prescribed_dtl['pres_value'] . round(microtime(true) * 1000) ]);

                    }

                }

            }
        }

        if (isset($input['other_infusions_pump_type']))
        {
            $prescribed_hdr['volume'] = (isset($input['other_infusions_volume']) && !empty($input['other_infusions_volume'])) ? $input['other_infusions_volume'] : 0;
            $prescribed_hdr['duration'] = (isset($input['other_infusions_duration']) && !empty($input['other_infusions_duration'])) ? $input['other_infusions_duration'] : 0;
            $prescribed_hdr['duration_time'] = isset($input['other_infusions_durametnod']) ? $input['other_infusions_durametnod'] : null;
            $prescribed_hdr['rate'] = (isset($input['other_infusions_rate']) && !empty($input['other_infusions_rate'])) ? $input['other_infusions_rate'] : 0;
            $prescribed_hdr['infusion_type'] = isset($input['other_infusions_pump_type']) ? $input['other_infusions_pump_type'] : null;
            $prescribed_hdr['glucose_infusion_rate'] = (isset($input['glucose_infusion_rate']) && !empty($input['glucose_infusion_rate'])) ? $input['glucose_infusion_rate'] : null;
            $prescribed_hdr['glucose_concentration'] = (isset($input['glucose_concentration']) && !empty($input['glucose_concentration'])) ? $input['glucose_concentration'] : null;
            $prescribed_hdr['instruction'] = isset($input['other_infusions_instruction']) ? $input['other_infusions_instruction'] : null;
            $prescribed_hdr['drug_added'] = isset($input['other_infusions_drug_added']) ? $input['other_infusions_drug_added'] : null;
            $prescribed_hdr['dose_feq_addition'] = isset($input['other_infusions_dose_feq_addition']) ? $input['other_infusions_dose_feq_addition'] : null;
            $prescribed_hdr['batch_no'] = isset($input['other_infusions_batch_no']) ? $input['other_infusions_batch_no'] : null;

            $input['start_hours'] = strlen($input['start_hours']) == 2 ? $input['start_hours'] : '0' . $input['start_hours'];
            $input['start_mins'] = strlen($input['start_mins']) == 2 ? $input['start_mins'] : '0' . $input['start_mins'];

            $input['start_date'] = $input['start_date'] . ' ' . $input['start_hours'] . ':' . $input['start_mins'] . ' ' . $input['start_session'];
            $prescribed_hdr['start_date'] = isset($input['start_date']) ? date('Y-m-d H:i:s', strtotime($input['start_date'])) : null;

            $result_hdr->update($prescribed_hdr);

            $prescribed_dtl['event_time'] = $prescribed_hdr['start_date'];
            $prescribed_dtl['modified_date'] = Carbon::now($this->time_zone);
            $prescribed_dtl['modified_user'] = $this->auth->user() ['id'];

            prescriptionDetails::where('pres_hdr_id', $input['pres_id'])->update($prescribed_dtl);

        }

        if (isset($input['oral_route']))
        {

            if (!isset($input['frequency_start_time']) || empty($input['frequency_start_time']))
            {
                return \Response::json(['messageType' => 'error', 'message' => 'Please fill the starting hour']);
            }
            else
            {
                if ($input['frequency_start_time'] == 12 && $input["starthour"] == "am")
                {
                    $frequency_start_time = 0;
                }
                elseif ($input['frequency_start_time'] == 12 && $input["starthour"] == "pm")
                {
                    $frequency_start_time = 12;
                }
                else
                {
                    $frequency_start_time = $input['frequency_start_time'] + ($input["starthour"] == "am" ? 0 : 12);
                }

                $prescribed_hdr['dose'] = (isset($input['oral_dose_required']) && !empty($input['oral_dose_required'])) ? $input['oral_dose_required'] : 0;
                $prescribed_hdr['dose_units_g'] = isset($input['drugs_dose_units']) ? $input['drugs_dose_units'] : null;
                $prescribed_hdr['alt_dose'] = (isset($input['oral_alt_dose_required']) && !empty($input['oral_alt_dose_required'])) ? $input['oral_alt_dose_required'] : 0;
                $prescribed_hdr['alt_dose_units_g'] = isset($input['drugs_alt_dose_units']) ? $input['drugs_alt_dose_units'] : null;
                $prescribed_hdr['oral_route'] = isset($input['oral_route']) ? $input['oral_route'] : null;
                $prescribed_hdr['instruction'] = isset($input['oral_additional']) ? $input['oral_additional'] : null;
                $prescribed_hdr['start_date'] = isset($input['start_date']) ? date('Y-m-d', strtotime($input['start_date'])) . ' ' . $frequency_start_time . ':00:00' : null;
                $prescribed_hdr['review_date'] = isset($input['oral_review_date']) ? date('Y-m-d', strtotime($input['oral_review_date'])) : null;
                $prescribed_hdr['frequency'] = isset($input['oral_frequency']) ? $input['oral_frequency'] : null;
                $review_date = $prescribed_hdr['review_date'] . ' 23:59:59';

                $result_hdr->update($prescribed_hdr);

                if (($input['frequency_old'] != $input['oral_frequency']) || ($input['start_date_old'] != $input['start_date']) || ($input['start_hours_old'] != $input['frequency_start_time']) || ($input['start_session_old'] != $input['starthour']) || $input['review_date_old'] != $input['oral_review_date'])
                {

                    $prescribed_dtl['is_send'] = '99';
                    $prescribed_dtl['order_status'] = 'EP'; // Edit Prescription
                    $prescribed_dtl['modified_date'] = Carbon::now($this->time_zone);
                    $prescribed_dtl['modified_user'] = $this->auth->user() ['id'];

                    prescriptionDetails::where('pres_hdr_id', $input['pres_id'])->update($prescribed_dtl);

                    $prescribed_dtl = array();

                    $frequency_count = preg_replace('/[Q,H]/', '', $prescribed_hdr['frequency']);

                    $date1 = date_create($prescribed_hdr['start_date']);
                    $date2 = date_create($review_date);
                    $diff = date_diff($date1, $date2);
                    $diff_days = $diff->days;
                    $diff_hours = $diff->h;

                    $diff = ($diff_days * 24) + $diff_hours;

                    if ($diff > 0 && is_numeric($frequency_count))
                    {
                        $frequency_grap = $diff / $frequency_count;
                    }

                    if (isset($frequency_count) && is_numeric($frequency_count) && isset($frequency_grap) && $frequency_grap > 0)
                    {

                        for ($i = 0;$i <= $frequency_grap;$i++)
                        {

                            $prescribed_dtl['pres_hdr_id'] = $input['pres_id'];
                            $prescribed_dtl['day'] = empty($input['day']) ? null : $input['day'];
                            $prescribed_dtl['created_date'] = Carbon::now($this->time_zone);
                            $prescribed_dtl['created_user'] = $this->auth->user() ['id'];
                            $prescribed_dtl['modified_date'] = Carbon::now($this->time_zone);
                            $prescribed_dtl['modified_user'] = $this->auth->user() ['id'];
                            if ($i == 0)
                            {
                                $prescribed_dtl['event_time'] = $prescribed_hdr['start_date'];
                            }
                            else
                            {
                                $prescribed_hdr['start_date'] = $prescribed_dtl['event_time'] = Carbon::createFromFormat('Y-m-d H:i:s', $prescribed_hdr['start_date'])->addHours($frequency_count);
                            }

                            $prescribed_dtl['pres_value'] = prescriptionDetails::create($prescribed_dtl)->id;

                            prescriptionDetails::where('id', $prescribed_dtl['pres_value'])->update(['order_id' => $prescribed_dtl['pres_value'], 'prescription_id' => 'ORAL' . $prescribed_dtl['pres_value'] . round(microtime(true) * 1000) ]);

                        }

                    }
                    else
                    {

                        $prescribed_dtl['pres_hdr_id'] = $input['pres_id'];
                        $prescribed_dtl['day'] = empty($input['day']) ? null : $input['day'];
                        $prescribed_dtl['created_date'] = Carbon::now($this->time_zone);
                        $prescribed_dtl['created_user'] = $this->auth->user() ['id'];
                        $prescribed_dtl['modified_date'] = Carbon::now($this->time_zone);
                        $prescribed_dtl['modified_user'] = $this->auth->user() ['id'];
                        $prescribed_dtl['event_time'] = date('Y-m-d H:i:s', strtotime($prescribed_hdr['start_date']));

                        $prescribed_dtl['pres_value'] = prescriptionDetails::create($prescribed_dtl)->id;

                        prescriptionDetails::where('id', $prescribed_dtl['pres_value'])->update(['order_id' => $prescribed_dtl['pres_value'], 'prescription_id' => 'ORAL' . $prescribed_dtl['pres_value'] . round(microtime(true) * 1000) ]);

                    }

                }

            }

        }

        $post['baby_id'] = $input['baby_id'];
        $post['admission_id'] = $input['admission_id'];
        $post['hdr_id'] = $input['pres_id'];
        $post['prescription_type'] = $prescribed_hdr['prescription_type'];
        $post['prescription_from'] = 3;
        $post['old_prescription_type'] = $input['old_prescription_type'];
        $post['edit_modal_id'] = $input['edit_modal_id'];

        \SiteHelpers::updateDashboardAtFormUpdation($input['baby_id'], 'Prescription - Edit');

        $this->prescriptionSendToUser($post);

        return \Response::json(['messageType' => 'success', 'message' => 'Update Succcessfully', 'data' => $post], 200);
    }

    public function print ($baby_id, $admission_id, $date, $closewinlink = '')
    {
        $baby_id = \SiteHelpers::decrypt_id($baby_id);
        $admission_id = \SiteHelpers::decrypt_id($admission_id);

        $baby = Baby::find($baby_id);
        $ip_numbers = '';
        $corrected_gestation = '';

        if ($closewinlink != '')
        {
            if ($closewinlink == 'search-view') {
                $closewinlink = url('search-reports') . '?baby_id=' . \SiteHelpers::encrypt_id($baby_id);
            } elseif ($closewinlink == 'nicu-nurse-sheets') {
                $closewinlink = url('nicu-nurse-sheet-day') . '/'. \SiteHelpers::encrypt_id($admission_id).'/'.$closewinlink;
            } else {
                $closewinlink = url('prescription') . '/' . \SiteHelpers::encrypt_id($baby_id . '-' . $admission_id) . '/' . $closewinlink;
            }
        }
        else
        {
            $closewinlink = url('prescription') . '/' . \SiteHelpers::encrypt_id($baby_id . '-' . $admission_id);
        }

        $patient_bed_log = BedLog::where(['baby_id' => $baby_id, 'admission_id' => $admission_id])->first();

        $ip_details = \DB::table('ip_numbers')->where(['baby_id' => $baby_id, 'AdmissionId' => $admission_id])->first();

        $nicu = Nicu::where('BabyId', $baby_id)->where('AdmissionId', $admission_id)->first();

        $hospital_name = isset($nicu->hospital_name) ? $nicu->hospital_name : '';

        return view('prescription.prescription_print', compact('baby', 'patient_bed_log', 'closewinlink', 'ip_numbers', 'corrected_gestation', 'admission_id', 'ip_details', 'date', 'hospital_name'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

    }

    /**
     * update  the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function prescriptionForm($baby_id, $admission_id, $id, $slug)
    {
        $drug_detail = PrescriptionValues::find($id);
        $i = $id;

        $fluids = \DB::table('mas_drugivfluid')->select('*')
        ->where(['is_deleted' => 0, 'status' => 1])
        ->where('brand_name', '!=', '')
        ->where('type', '<>', 'ORAL')
        ->get()
        ->pluck('brand_name', 'id');

        $fluids_gen = \DB::table('mas_drugivfluid')->select('*')
        ->where(['is_deleted' => 0, 'status' => 1])
        ->where('generic_pharmacological_name', '!=', '')
        ->where('type', '<>', 'ORAL')
        ->get()
        ->pluck('generic_pharmacological_name', 'id');

        $drugs = \DB::table('mas_drugivfluid')->select('*')
        ->where(['is_deleted' => 0, 'status' => 1])
        ->where('brand_name', '!=', '')
        ->where('type', 'ORAL')
        ->get()
        ->pluck('brand_name', 'id');

        $drugs_gen = \DB::table('mas_drugivfluid')->select('*')
        ->where(['is_deleted' => 0, 'status' => 1])
        ->where('generic_pharmacological_name', '!=', '')
        ->where('type', 'ORAL')
        ->get()
        ->pluck('generic_pharmacological_name', 'id');

        $frequency_list = FrequencyMaster::where(['is_deleted' => 0, 'status' => 1])->where('name', '!=', '')
        ->orderBy('freq_id', 'asc')
        ->pluck('name', 'value')
        ->toArray();

        $type = $slug;
        $slug = $slug . '_FORM';

        $drugs_view = view('prescription.form', compact('drugs', 'slug', 'drugs_gen', 'fluids_gen', 'fluids', 'drug_detail', 'id', 'i', 'frequency_list', 'type'))->render();

        return \Response::json(['drugs_details' => $drugs_view], 200);
    }

    /**
     * remove the specified resource from storage
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function getPrescriptionRemove(Request $request)
    {
        $input = $request->all();

        if (!isset($input['id']) && !isset($input['slug']))
        {
            return \Response::json(['message' => 'Please Contact Admin Drug Not Found!', 'messageType' => 'error'], 500);
        }
        $id = $input['id'];
        $results = PrescriptionValues::findOrfail($id);
        $prescription_date = $results->date_prescribed;
        $moduleModel = 'Prescription';

        $user_detail = array(
            'is_deleted' => '1'
        );
        $results->update($user_detail);
        $baby = Baby::find($results->baby_id);

        $delete_data = array(
            'Name' => $baby->BabyName,
            'AdmissionDate' => $prescription_date,
            'ModuleController' => $moduleModel,
            'ModuleId' => $id,
            'ModuleName' => 'Nicu Prescription',
            'UserDeleted' => $this
            ->auth
            ->user()->id,
            'DateDeleted' => Carbon::now()
        );
        DeleteApproval::create($delete_data);

        return \Response::json(['message' => 'Drugs removed Successfully', 'messageType' => 'success'], 200);

    }

    /**
     * remove the specified resource from storage
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function getPrescriptionStatusChange(Request $request)
    {
        $input = $request->all();

        $result = [];
        $prescription_list = [];

        $baby_id = isset($input['baby_id']) ? $input['baby_id'] : null;

        $is_send = '';
        $prescription_dtl_id = [];

        $post['prescription_from'] = 1;

        if (isset($input['drug_list']))
        {
            $prescribed = explode(':', $input['drug_list']);
            $this->custom_error->emergencyLog('Prescription - DRUG : ' . json_encode($prescribed). '====type====' . $input['status_type']);

            $drug_type = $prescribed[1];
            $post['id'] = $pres_dtl_id = $prescribed[0];

            $pres_dtl = prescriptionDetails::find($post['id'])->toArray();

            $pres_hdr = prescriptionHeader::find($pres_dtl['pres_hdr_id'])->toArray();

            $baby_id = $pres_hdr['baby_id'];

            if ($input['status_type'] == 'SENDTOPUMP')
            {

                if ($drug_type != "ORAL" && (isset($input['order_pump_type']) && $input['order_pump_type'] == 'e-n-series') && (!isset($input['order_pump_device_id']) || empty($input['order_pump_device_id']) || is_null($input['order_pump_device_id']))) {
                    return \Response::json(['type' => 'error', 'message' => 'Please select the pump']);
                }

                $post['is_send'] = 1;

                $started_date = date('Y-m-d', strtotime($input['confirm_datetime']));

                $input['confirm_time'] = strlen($input['confirm_time']) == 2 ? $input['confirm_time'] : '0' . $input['confirm_time'];
                $input['confirm_mins'] = strlen($input['confirm_mins']) == 2 ? $input['confirm_mins'] : '0' . $input['confirm_mins'];

                $confirm_time = $input['confirm_time'] . ":" . $input['confirm_mins'] . " " . $input['confirm_session'];

                $confirm_time = date('H:i', strtotime($confirm_time));

                $post['started_date'] = $started_date . ' ' . $confirm_time;

                $post['started_user'] = $this->auth->user() ['id'];

                if ($drug_type != "ORAL")
                {
                    $admission_details['babyId'] = $pres_hdr['baby_id'];
                    $admission_details['motherId'] = $pres_hdr['mother_id'];
                    $admission_details['admissionId'] = $pres_hdr['admission_id'];
                    $this->createAdmission($admission_details);
                }
                $post['prescription_id'] = $pres_dtl['prescription_id'];
                $post['pres_hdr_id'] = $pres_dtl['pres_hdr_id'];

                if (isset($input['order_pump_device_id'])) {
                    $to_update = ['is_send' => $post['is_send'], 'started_user' => $post['started_user'], 'started_date' => $post['started_date'], 'original_started_date' => Carbon::now($this->time_zone), 'order_pump_type' => $input['order_pump_type'], 'order_pump_device_id' => $input['order_pump_device_id']];
                } else {                        
                    $to_update = ['is_send' => $post['is_send'], 'started_user' => $post['started_user'], 'started_date' => $post['started_date'], 'original_started_date' => Carbon::now($this->time_zone)];
                }


            }

            if ($input['status_type'] == 'CANCEL_ORDER')
            {
                $cancel_date = date('Y-m-d', strtotime($input['cancel_datetime']));

                $input['cancel_time'] = strlen($input['cancel_time']) == 2 ? $input['cancel_time'] : '0' . $input['cancel_time'];
                $input['cancel_mins'] = strlen($input['cancel_mins']) == 2 ? $input['cancel_mins'] : '0' . $input['cancel_mins'];

                $cancel_time = $input['cancel_time'] . ":" . $input['cancel_mins'] . " " . $input['cancel_session'];

                $cancel_time = date('H:i', strtotime($cancel_time));

                $post['cancel_datetime'] = $cancel_date . ' ' . $cancel_time;

                $post['cancelled_user'] = $this->auth->user() ['id'];

                $post['cancel_reason'] = $input['cancel_reason'];

                $post['started_date'] = $pres_dtl['started_date'];
                $post['modified_started_date'] = $pres_dtl['modified_started_date'];
                $post['started_user'] = $pres_dtl['started_user'];
                $post['modified_started_user'] = $pres_dtl['modified_started_user'];

                $post['prescription_id'] = $pres_dtl['prescription_id'];
                $post['pres_hdr_id'] = $pres_dtl['pres_hdr_id'];

                $check_status = $pres_dtl['is_send'];

                if ($check_status == 0)
                {
                    $post['is_send'] = 10;
                    $to_update = ['order_status' => 'FN', 'is_send' => $post['is_send'], 'cancelled_user' => $post['cancelled_user'], 'cancel_datetime' => $post['cancel_datetime'], 'cancel_reason' => $post['cancel_reason'], 'original_cancel_date' => Carbon::now($this->time_zone)];
                }
                else
                {
                    $post['is_send'] = 3;
                    $to_update = ['order_status' => 'FN', 'is_send' => $post['is_send'], 'cancel_datetime' => Carbon::now($this->time_zone) , 'cancelled_user' => $post['cancelled_user'], 'cancel_datetime' => $post['cancel_datetime'], 'cancel_reason' => $post['cancel_reason'], 'original_cancel_date' => Carbon::now($this->time_zone)];
                }

            }

            if ($input['status_type'] == 'STOP_ORDER')
            {

                if (empty($input['total_ml']) || empty($input['total_type']))
                {
                    return \Response::json(['messageType' => 'error', 'message' => 'Please fill the all the fields']);
                }
                else
                {
                    $drug_status = '20';
                    if ($drug_type != "ORAL") {
                        $drug_status = '21';
                    }

                    $stop_date = date('Y-m-d', strtotime($input['stop_datetime']));

                    $input['stop_time'] = strlen($input['stop_time']) == 2 ? $input['stop_time'] : '0' . $input['stop_time'];
                    $input['stop_mins'] = strlen($input['stop_mins']) == 2 ? $input['stop_mins'] : '0' . $input['stop_mins'];

                    $stop_time = $input['stop_time'] . ":" . $input['stop_mins'] . " " . $input['stop_session'];

                    $stop_time = date('H:i', strtotime($stop_time));

                    $post['stopped_date'] = $stop_date . ' ' . $stop_time;

                    $post['stop_reason'] = $input['stop_reason'];

                    $post['total_infused'] = $input['total_ml'] . ' ' . $input['total_type'];

                    $post['stopped_user'] = $this->auth->user() ['id'];

                    $post['is_send'] = $drug_status;

                    $post['started_date'] = $pres_dtl['started_date'];
                    $post['modified_started_date'] = $pres_dtl['modified_started_date'];
                    $post['started_user'] = $pres_dtl['started_user'];
                    $post['modified_started_user'] = $pres_dtl['modified_started_user'];

                    $post['prescription_id'] = $pres_dtl['prescription_id'];
                    $post['pres_hdr_id'] = $pres_dtl['pres_hdr_id'];

                    $to_update = ['order_status' => 'SN', 'is_send' => $post['is_send'], 'stopped_user' => $post['stopped_user'], 'stopped_date' => $post['stopped_date'], 'stop_reason' => $post['stop_reason'], 'total_infused' => $post['total_infused'], 'original_stopped_date' => Carbon::now($this->time_zone)];

                }
            }

            if (isset($to_update)) {
                prescriptionDetails::where('id', $post['id'])->update($to_update);
            }

            $post['active_id'] = prescriptionDetails::getGivenPrescription($pres_dtl['pres_hdr_id']);
            $post['admission_id'] = $pres_hdr['admission_id'];
            $post['modal_id'] = $input['modal_id'];

            $this->prescriptionSendToUser($post);

        }

        if ($baby_id != null) {
            $this->custom_error->emergencyLog('Prescription - order baby id : ' . $baby_id);
            \SiteHelpers::updateDashboardAtFormUpdation($baby_id, 'Prescription - Action (' . $input['status_type'] . ')');
        }

        return \Response::json(['type' => 'success', 'message' => 'Status Changed Successfully', 'data' => $post], 200);

    }

    /**
     * This method to create admission
     * for syringe pump
     * @param $admission_details type array
     *
     * @return type array
     */
    public static function createAdmission($admission_details = array())
    {

        $condition['baby_id'] = $admission_details['babyId'];
        $condition['mother_id'] = $admission_details['motherId'];
        $condition['admission_id'] = $admission_details['admissionId'];
        $condition['is_admission_closed'] = false;

        $nicu_admission = Nicu::where(['BabyId' => $condition['baby_id'], 'AdmissionId' => $admission_details['admissionId']])->first();
        $syringe_pump = $condition;
        $syringe_pump['weight'] = isset($nicu_admission->AdmissionWt) ? $nicu_admission->AdmissionWt : null;
        $syringe_pump['workingWeight'] = isset($admission_details['workingWeight']) ? $admission_details['workingWeight'] : null;
        $pump_status = SyringePumpAdmisson::where($condition)->orderby('id', 'desc')
        ->first();

        if (count($pump_status) <= 0)
        {
            SyringePumpAdmisson::create($syringe_pump);
            PrescriptionToMirthController::admission();
        }
        return true;
    }

    /**
     * This method to get the status of the prescribed drug
     */
    public function getPrescriptionLog(Request $request)
    {

        $input = $request->all();
        $id = $input['advice_id'];
        $bmrno = $input['BMrNo'];
        $ip_number = $input['ip_number'];
        $baby_id = $input['baby_id'];
        $admission_id = $input['admission_id'];

        $patient_status = DischargeLog::getDischargeDetail($baby_id, $admission_id);
        $prescribed_drugs_table = 'prescription_hdr';

        if (count($patient_status) > 0)
        {
            $prescription_table = 'prescription_discharged';
            $prescribed_drugs_sub = 'prescription_dtl_discharged';
        }
        else
        {
            $prescription_table = 'prescription';
            $prescribed_drugs_sub = 'prescription_dtl';
        }

        $resource = $this->prescriptionLogDetails($id, $bmrno, $ip_number, $prescription_table, $prescribed_drugs_table, $prescribed_drugs_sub, $admission_id);

        return \Response::json(['resource' => $resource]);

    }

    /**
     * Get the latest working weight
     *
     * @param $baby_id integer
     *
     * @param $admission_id integer
     *
     * @return integer
     */
    public function getWorkingWeight($baby_id, $admission_id)
    {
    	$prescription_hdr = 'prescription_hdr';

        $prescription = \DB::table($prescription_hdr)->select('working_weight')
        ->where(['baby_id' => $baby_id, 'admission_id' => $admission_id])->where('working_weight', '<>', null)->where('working_weight', '<>', '')
        ->orderBy('id', 'desc')
        ->first();

        $weight_val = (object)array();

        if (isset($prescription) && isset($prescription->working_weight))
        {
            $weight_val = $prescription->working_weight;
        }
        elseif (!isset($working_weight))
        {
            $weight = Nicu::getAdmissionWeight($baby_id, $admission_id);
            if (isset($weight) && isset($weight->AdmissionWt))
            {
                $weight_val = $weight->AdmissionWt;
            }
            else
            {
                $weight_val = '';
            }
        }

        return $weight_val;

        //$sheet_details = NurseSheetMain::GetNurseSheetCount($baby_id, $admission_id)->pluck('working_weight', 'sheet_date')->toArray();
        //krsort($sheet_details);
        //$working_weight = collect($sheet_details)->first();
        //$working_weight = $working_weight > 0 ? $working_weight : '';

        //return $working_weight;
    }

    /**
     * Get the prescribed drug & volume
     *
     * @param $id integer
     *
     * @param $bmrno integer
     *
     * @param $ip_number integer
     *
     * @return array
     */
    public function prescriptionLogDetails($id, $bmrno, $ip_number = '', $prescription_table = '', $prescribed_drugs_table = '', $prescribed_drugs_sub = '', $admission_id = '')
    {

        $temp_prescriptionList = array();

        $temp_prescriptionList = \DB::table($prescription_table)->select('result_time', 'infused', 'remain_volume', 'rate', 'pressure')
        ->where('prescription_id', $id)->orderBy('result_time', 'asc')
        ->get();

        $prescriptioncount = count($temp_prescriptionList);

        $data = $temp_prescriptionList->groupBy(function ($item, $key)
        {
            return date('d-m-Y H', strtotime($item->result_time));
        })
        ->toArray();

        $prescribed_list = \DB::table($prescribed_drugs_table)->select("*")
        ->leftjoin($prescribed_drugs_sub, $prescribed_drugs_sub . '.pres_hdr_id', $prescribed_drugs_table . '.id')->where(['prescription_id' => $id, 'admission_id' => $admission_id])->first();

        $temp_prescription_data = $data;

        $drug_id = $prescribed_list->pharmacological_name;

        $prescriptionList['count'] = $prescriptioncount;
        $prescriptionList['count_hour'] = count($temp_prescription_data);

        $prescriptionList['vtbi'] = empty($prescribed_list->syringe_size) ? '' : $prescribed_list->syringe_size;

        $prescriptionList['drug_name'] = empty(DrugIvFluidMaster::getDrugName($drug_id)) ? '' : DrugIvFluidMaster::getDrugName($drug_id)->generic_pharmacological_name;

        $collect_count = count($temp_prescription_data);

        $temp_count = 1;
        foreach ($temp_prescription_data as $key => $value) {
            $first_value = $value[0];
            if ($collect_count == $temp_count) {
                $last_value = $value[count($value) - 1];
            } else {
                $last = next($temp_prescription_data);
                $last_value = $last[0];
            }

            $prescription_first_index = $first_value->result_time;
            $prescription_last_index = $last_value->result_time;

            $prescriptionList['data'][$prescription_first_index] = (array)$first_value;
            $prescriptionList['data'][$prescription_last_index] = (array)$last_value;

            $temp_count++;
        }

        return $prescriptionList;

    }

    /**
     *
     *
     */
    public function getDownloadPumpData($baby_mrn, $base_id, $baby_id, $admission_id)
    {

        $baby_details = Baby::where('BMrNo', $baby_mrn)->first();
        $patient_status = DischargeLog::getDischargeDetail($baby_id, $admission_id);
        $prescription_drugs_table = 'prescription_hdr';

        if (count($patient_status) == 0)
        {
            $prescription_table = 'prescription';
            $prescription_dtl = 'prescription_dtl';
        }
        else
        {
            $prescription_table = 'prescription_discharged';
            $prescription_dtl = 'prescription_dtl_discharged';
        }
        $pump_data = $this->prescriptionLogDetails($base_id, $baby_mrn, '', $prescription_table, $prescription_drugs_table, $prescription_dtl, $admission_id);

        $count_hour = $pump_data['count_hour'];
        $drug_name = $pump_data['drug_name'];

        $heading1_content = $drug_name;

        $pump_actual_data = $pump_data['data'];

        $heading = ['Date', 'Infused', 'Remaining', 'Rate', 'Pressure'];
        $heading1 = [$heading1_content];

        Excel::create('pump_data (' . $baby_details->BabyName . '/' . $baby_details->BMrNo . ')', function ($excel) use ($pump_actual_data, $heading, $heading1)
        {

            $excel->sheet('Excel sheet', function ($sheet) use ($pump_actual_data, $heading, $heading1)
            {
                $sheet->fromArray($pump_actual_data, null, 'A1', false, false, false);
                $sheet->prependRow(1, $heading1);
                $sheet->prependRow(2, $heading);
                $sheet->mergeCells('A1:E1');
                $sheet->setOrientation('landscape');
                $sheet->cells('A1:E1', function ($cells) {
                    $cells->setBackground('#000000');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setFontWeight();
                    $cells->setAlignment('center');
                });
                $sheet->cells('A2:E2', function ($cells) {
                    $cells->setFontColor('#ff0000');
                });
            });

        })
        ->export('xls')
        ->download();

    }

    function pump_data_process($value_last = '')
    {
        $rate = $value_last->rate;
        $infused = $value_last->infused;

        $temp_data['date_time'] = isset($value_last->result_time) ? date('d-m-Y H:i', strtotime($value_last->result_time)) : null;
        $temp_data['drug_name'] = isset($drug_name) ? $drug_name : null;
        $temp_data['infused'] = isset($value_last->infused) ? $value_last->infused : null;
        $temp_data['remaining'] = isset($value_last->remain_volume) ? $value_last->remain_volume : null;
        $temp_data['vtbi'] = isset($pump_data['vtbi']) ? $pump_data['vtbi'] : null;
        $temp_data['rate'] = isset($value_last->rate) ? $value_last->rate : null;
        $temp_data['pressure'] = isset($value_last->pressure) ? $value_last->pressure : null;
        return $temp_data;
    }

    /**
     * Get the prescription drug by date
     *
     * @param $baby_id integer
     *
     * @param $admission_id integer
     *
     * @param $date integer
     *
     * @return \Illuminate\Http\Response
     */
    public function printFilteredByDate($baby_id, $admission_id, $fromdate = null, $todate = null)
    {

        if ($fromdate == null || $todate == null)
        {
            $prescribed = $this->prescriptionPrintData($baby_id, $admission_id);
        }
        else
        {
            $prescribed = $this->prescriptionPrintData($baby_id, $admission_id, $fromdate, $todate);
        }

        $basic_val = $this->getWorkingWeight($baby_id, $admission_id);

        return \Response::json(['prescribed' => $prescribed, 'basic_val' => $basic_val]);

    }

    /**
     * This method to resend the
     * prescription
     *
     * @param $drug_id type int
     * @return Response json
     */
    public function resendPrescription(Request $request)
    {
        $input = $request->all();

        $drug_id= $input['resend_id'];
        $prescribed_old = prescriptionDetails::findOrfail($input['resend_id']);
        
        if (preg_replace('/[0-9]/', '', $prescribed_old['prescription_id']) != "ORAL" && $input['order_pump_type'] == 'e-n-series' && (!isset($input['order_pump_device_id']) || empty($input['order_pump_device_id']) || is_null($input['order_pump_device_id']))) {
            return \Response::json(['type' => 'error', 'message' => 'Please select the pump']);
        }

        if ($prescribed_old['is_send'] == 0 || $prescribed_old['is_send'] == 1 || $prescribed_old['is_send'] == 2 || $prescribed_old['is_send'] == 9)
        {

            if (isset($input['resend_datetime'])) {
                $started_date = date('Y-m-d', strtotime($input['resend_datetime']));
                $input['resend_time'] = strlen($input['resend_time']) == 2 ? $input['resend_time'] : '0' . $input['resend_time'];
                $input['resend_mins'] = strlen($input['resend_mins']) == 2 ? $input['resend_mins'] : '0' . $input['resend_mins'];
                $resend_time = $input['resend_time'] . ":" . $input['resend_mins'] . " " . $input['resend_session'];
                $resend_time = date('H:i', strtotime($resend_time));
                $prescribed_dtl['started_date'] = $started_date . ' ' . $resend_time;
            } else {
                $prescribed_dtl['started_date'] = Carbon::now($this->time_zone);
            }

            $prescribed_dtl['pres_hdr_id'] = $prescribed_old['pres_hdr_id'];
            $prescribed_dtl['order_pump_type'] = $input['order_pump_type'];
            $prescribed_dtl['order_pump_device_id'] = $input['order_pump_device_id'];
            $prescribed_dtl['day'] = null;
            $prescribed_dtl['started_user'] = $this->auth->user() ['id'];
            $prescribed_dtl['created_date'] = Carbon::now($this->time_zone);
            $prescribed_dtl['created_user'] = $this->auth->user() ['id'];
            $prescribed_dtl['modified_date'] = Carbon::now($this->time_zone);
            $prescribed_dtl['modified_user'] = $this->auth->user() ['id'];
            $prescribed_dtl['event_time'] = $prescribed_old['event_time'];

            $prescribed = prescriptionDetails::create($prescribed_dtl)->id;

            $advice_id = preg_replace('/[0-9]/', '', $prescribed_old['prescription_id']) . $prescribed . round(microtime(true) * 1000);

            $prescribed_new = prescriptionDetails::findOrfail($prescribed);

            if ($prescribed_old['id'] != $prescribed_old['order_id'])
            {
                $drug_id = $prescribed_old['order_id'];
            }

            if (count($prescribed_new) > 0)
            {
                $prescribed_old_update['is_send'] = 3;
                $prescribed_old_update['order_status'] = 'RS'; //Resend
                $prescribed_old_update['cancel_datetime'] = Carbon::now($this->time_zone);
                $prescribed_old_update['cancelled_user'] = $this->auth->user() ['id'];
                $prescribed_old_update['cancel_reason'] = 'Resend Prescription.';
                $prescribed_old_update['original_cancel_date'] = Carbon::now($this->time_zone);
                $prescribed_old->update($prescribed_old_update);

                $prescribed_new_update['prescription_id'] = $advice_id;
                $prescribed_new_update['is_send'] = 1;
                $prescribed_new_update['order_id'] = $drug_id;
                $prescribed_new_update['original_started_date'] = Carbon::now($this->time_zone);
                $prescribed_new->update($prescribed_new_update);

                $prescribed_hdr = prescriptionHeader::findOrfail($prescribed_old['pres_hdr_id']);

                $post['baby_id'] = $prescribed_hdr['baby_id'];
                $post['admission_id'] = $prescribed_hdr['admission_id'];
                $post['prescription_type'] = $prescribed_hdr['prescription_type'];
                $post['prescription_from'] = 7;
                $post['old_id'] = $prescribed_old['id'];
                $post['new_id'] = $prescribed;
                $post['advice_id'] = $advice_id;
                $post['order_pump_type'] = $prescribed_old['order_pump_type'];
                $post['order_pump_device_id'] = $prescribed_old['order_pump_device_id'];

                $this->prescriptionSendToUser($post);

                return \Response::json(['type' => 'success', 'message' => 'Prescription Send Successfully', 'old_id' => $prescribed_old['id'], 'new_id' => $prescribed, 'advice_id' => $advice_id, 'order_pump_type' => $prescribed_old['order_pump_type'], 'order_pump_device_id' => $prescribed_old['order_pump_device_id']], 200);
            }
        }
        else
        {
            return \Response::json(['type' => 'error', 'message' => 'Prescription resending is failed.']);
        }
        return \Response::json(['type' => 'warning', 'message' => 'Prescription failed to Send']);

    }

    /**
     * This method to update the
     * prescription status on stop
     *
     * @param $table_name type string
     * @param $drug_list type array
     * @param $adviceid type string
     * @return array
     */
    public function prescriptionCurrentStatus($table_name, $drug_list, $adviceid, $prescription_table)
    {

        $queue = $infusion = $pause = $stop = array();

        foreach ($drug_list as $key => $value)
        {
            $advice_id = $adviceid . $value->prescription_id;
            $check_status = \DB::table($prescription_table)->select('status', 'remain_volume')
            ->where('prescription_id', $advice_id)->orderBy('result_time', 'desc')
            ->first();
            if (isset($check_status->status))
            {
                $drug_list[$key]->is_status = true;
            }
            else
            {
                $drug_list[$key]->is_status = false;
            }
            $drug_list[$key]->date = date('Y-m-d', strtotime($value->date_prescribed));
        }

        return $drug_list;

    }

    /**
     * This method to get the
     * prescription status
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function prescriptionStatusList(Request $request)
    {
        if ($request->ajax())
        {
            $input = $request->all();
            $baby_id = $input['baby_id'];
            $admission_id = $input['admission_id'];

            $patient_status = DischargeLog::getDischargeDetail($baby_id, $admission_id);

            $drug_list = (object)[];

            $prescription_hdr = 'prescription_hdr';
            $prescription_table = 'prescription';
            $prescription_dtl = 'prescription_dtl';

            if (count($patient_status) > 0) {
                $prescription_table = 'prescription_discharged';
                $prescription_dtl = 'prescription_dtl_discharged';
            }

            $drug_list = \DB::table($prescription_hdr)
            ->select(['pres_hdr_id', $prescription_dtl . '.id', 'is_send', \DB::raw("(SELECT infused FROM " . $prescription_table . " WHERE " . $prescription_table . ".prescription_id = " . $prescription_dtl . ".prescription_id ORDER BY result_time desc LIMIT 1) as infused") , 'started_date', 'started_user', 'modified_started_date', 'modified_started_user', 'stopped_date', 'stopped_user', 'stop_reason', 'total_infused', 'modified_stopped_date', 'modified_stopped_user', 'modified_stop_reason', 'modified_total_infused', 'cancel_datetime', 'cancelled_user', 'cancel_reason', 'modified_cancel_datetime', 'modified_cancelled_user', 'modified_cancel_reason', 'terminate', 'event_time', 'order_pump_type', 'order_pump_device_id' ,\DB::raw('(CASE WHEN terminate > event_time THEN 0 ELSE 1 END) AS running') , 'prescription_id', 'order_id'])
            ->leftjoin($prescription_dtl, $prescription_dtl . '.pres_hdr_id', $prescription_hdr . '.id')
            ->where(['baby_id' => $baby_id, 'admission_id' => $admission_id])
            ->where('order_status', '<>', 'RS')
            ->where('order_status', '<>', 'EP')
            ->orderBy($prescription_dtl . '.order_id', 'asc')
            ->get()
            ->groupBy('pres_hdr_id', 'id');
            return $drug_list;
        }
        else
        {
            $input = $request->all();

            if (isset($input['baby_id']) && isset($input['admission_id']))
            {
                $baby_id = $input['baby_id'];
                $admission_id = $input['admission_id'];
                $ids = \SiteHelpers::encrypt_id($baby_id . '-' . $admission_id);

                return redirect('prescription/' . $ids);
            }
            else
            {
                return redirect('/');
            }
        }

    }

    public function updatePrescriptionVerifier($id)
    {

        $drug_list = \DB::table('prescribed_drugs')->where('pres_drug_id', $id)->update(['verify_user_id' => $this->auth->user() ['id']]);
        return \Response::json(['type' => 'success', 'message' => 'Successfully', 'username' => $this->auth->user() ['name']]);
    }

    public function prescriptionData(Request $request)
    {
        $input = $request->all();

        $baby_id = isset($input['baby_id']) ? $input['baby_id'] : '';
        $admission_id = isset($input['admission_id']) ? $input['admission_id'] : '';
        $pres_hdr = isset($input['pres_hdr']) ? $input['pres_hdr'] : '';
        $prescription_type = isset($input['prescription_type']) ? $input['prescription_type'] : '';
        $from_date = isset($input['from_date']) ? $input['from_date'] : '';
        $to_date = isset($input['to_date']) ? $input['to_date'] : '';

        $patient_status = DischargeLog::getDischargeDetail($baby_id, $admission_id);

        $prescription_hdr = 'prescription_hdr';
        $prescription_dtl = 'prescription_dtl';
        $prescription_table = 'prescription';

        if (count($patient_status) > 0) {
            $prescription_table = 'prescription_discharged';
            $prescription_dtl = 'prescription_dtl_discharged';
        }

        $prescription_hdr_list = \DB::table($prescription_hdr)
        ->leftjoin('mas_drugivfluid', 'mas_drugivfluid.id', $prescription_hdr . '.brand_name')
        ->select([$prescription_hdr . '.*', 'mas_drugivfluid.brand_name', 'mas_drugivfluid.generic_pharmacological_name', 'mas_drugivfluid.type as drug_type'])
        ->addSelect($prescription_hdr.'.id as hdr_id', $prescription_hdr.'.created_date as hdr_created_date', $prescription_hdr.'.modified_date as hdr_modified_date', $prescription_hdr.'.created_user as hdr_created_user', $prescription_hdr.'.modified_user as hdr_modified_user')
        ->where(['baby_id' => $baby_id, 'admission_id' => $admission_id])        
        ->where(function ($query) use ($pres_hdr, $prescription_hdr, $prescription_type) {
            if (!empty($pres_hdr)) {
                // $query->where($prescription_hdr . '.id', $pres_hdr);
            }
            if (!empty($prescription_type)) {
                $query->where($prescription_hdr . '.prescription_type', $prescription_type);
            }
        })
        ->where(['mas_drugivfluid.is_deleted' => 0, 'mas_drugivfluid.status' => 1, 'stop' => null])
        ->orderBy($prescription_hdr . '.modified_date', 'desc')
        ->get();

        $prescription_id = array_keys($prescription_hdr_list->groupBy('id')->toArray());

        $prescription_list2 = \DB::table($prescription_dtl)
        ->select($prescription_dtl . '.*', 'users.initial')
        ->addSelect(\DB::raw("(SELECT infused FROM " . $prescription_table . " WHERE " . $prescription_table . ".prescription_id = " . $prescription_dtl . ".prescription_id ORDER BY result_time desc LIMIT 1) as infused"))
        ->addSelect($prescription_dtl.'.id as dtl_id', $prescription_dtl.'.created_date as dtl_created_date', $prescription_dtl.'.modified_date as dtl_modified_date', $prescription_dtl.'.created_user as dtl_created_user', $prescription_dtl.'.modified_user as dtl_modified_user')
        ->selectRaw('CASE WHEN char_length(event_time::text) > 0 THEN to_char(event_time, \'HH24\') END AS event_hour')
        ->leftjoin('users', 'users.id', $prescription_dtl . '.modified_user')
        ->whereIn('pres_hdr_id', $prescription_id)
        ->where('order_status', '<>', 'RS')
        ->where('order_status', '<>', 'EP')
        ->where('is_deleted', 0)
        ->orderBy('event_time')
        ->get();

        $prescribed_date_list = date('m-d-Y', strtotime($prescription_list2->max('event_time')));

        $prescription_list = array();
        $prescription_list_2 = array();

        $prescription_list1 = collect($prescription_hdr_list)->whereIn('prescription_type', [1, 2, 4]);

        $prescription_list1->map(function ($pres_list, $key) use ($prescription_list2, $prescription_list1) {
            $pres_list->is_terminate = is_null($prescription_list1[$key]->terminate) ? false : true;
            $pres_dtl = collect($prescription_list2)->where('pres_hdr_id', $pres_list->id);
            $active_id = null;
            
            $event_time = $pres_dtl->where('is_send', '<>', 20)->where('is_send', '<>', 21)->where('is_send', '<>', 3)
            ->where('is_send', '<>', 8)->where('is_send', '<>', 10)->where('is_send', '<>', 11)->min('event_time');
            
            $active_id = $pres_dtl->where('event_time', $event_time)->first();
            $active_id = isset($active_id->id) ? $active_id->id : null;

            $pres_list->pres_dtl = $pres_dtl
            ->groupBy(function ($item, $key) {
                return date('d-m-Y', strtotime($item->event_time));
            })
            ->map(function ($items) {
                return $items->groupBy(function ($list) {
                    return date('H', strtotime($list->event_time));
                });
            })
            ->toArray();
            $pres_list->events_hour = $pres_dtl->pluck('event_hour')->unique()->toArray();
            $pres_list->active_id = $active_id;
            sort($pres_list->events_hour);

            if (!(count($pres_list->pres_dtl) > 0)) {
                unset($prescription_list1[$key]);
            }

        });
        
        $prescription_list = $prescription_list1->groupBy(['prescription_type', 'is_terminate'])->toArray();

        $prescription_list_2 = collect($prescription_hdr_list)->where('prescription_type', 3);
        $prescription_list_2->map(function ($pres_list, $key) use ($prescription_list2, &$prescription_list_2) {
            $pres_dtl = collect($prescription_list2)->where('pres_hdr_id', $pres_list->id)->last();
            $pres_dtl = collect($pres_dtl)->toArray();
            $pres_list1 = collect($pres_list)->toArray();
            if (count($pres_dtl) > 0) {
                $pres_list1 = array_merge($pres_list1, $pres_dtl);
                $prescription_list_2[$key] = collect($pres_list1);
            } else {
                unset($prescription_list_2[$key]);
            }
        });
        $prescription_list_2 = $prescription_list_2->toArray();

        $status_order = [2, 9, 5, 4, 7, 1, 0, 20, 21, 3, 8, 11, 10];

        usort($prescription_list_2, function ($a, $b) use ($status_order) {
            $pos_a = array_search($a['is_send'], $status_order);
            $pos_b = array_search($b['is_send'], $status_order);
            return $pos_a - $pos_b;
        });

        return ['prescription_list' => $prescription_list, 'intravenous_prescription_list' => $prescription_list_2, 'prescribed_date_list' => $prescribed_date_list];
    }

    public function prescriptionPrintData($baby_id, $admission_id, $fromdate = '', $todate = '')
    {

        $patient_status = DischargeLog::getDischargeDetail($baby_id, $admission_id);
        $prescription_hdr = 'prescription_hdr';

        if (count($patient_status) == 0)
        {
            $prescription_table = 'prescription';
            $prescription_dtl = 'prescription_dtl';
        }
        else
        {
            $prescription_table = 'prescription_discharged';
            $prescription_dtl = 'prescription_dtl_discharged';
        }

        $prescription_list1 = \DB::table($prescription_hdr)
        ->leftjoin('mas_drugivfluid', 'mas_drugivfluid.id', $prescription_hdr . '.brand_name')
        ->select([$prescription_hdr . '.*', 'mas_drugivfluid.brand_name', 'mas_drugivfluid.generic_pharmacological_name', 'mas_drugivfluid.type as drug_type'])
        ->addSelect($prescription_hdr.'.id as hdr_id', $prescription_hdr.'.created_date as hdr_created_date', $prescription_hdr.'.modified_date as hdr_modified_date', $prescription_hdr.'.created_user as hdr_created_user', $prescription_hdr.'.modified_user as hdr_modified_user')
        ->where(['baby_id' => $baby_id, 'admission_id' => $admission_id, 'mas_drugivfluid.is_deleted' => 0, 'mas_drugivfluid.status' => 1, 'stop' => null])
        ->orderBy($prescription_hdr . '.modified_date', 'asc')
        ->get();

        $prescription_id = array_keys($prescription_list1->groupBy('id')
            ->toArray());

        $prescription_list2 = \DB::table($prescription_dtl)
        ->select([$prescription_dtl . '.*', 'users.initial'])
        ->addSelect($prescription_dtl.'.id as dtl_id', $prescription_dtl.'.created_date as dtl_created_date', $prescription_dtl.'.modified_date as dtl_modified_date', $prescription_dtl.'.created_user as dtl_created_user', $prescription_dtl.'.modified_user as dtl_modified_user')
        ->leftjoin('users', 'users.id', $prescription_dtl . '.modified_user')
        ->whereIn('pres_hdr_id', $prescription_id)
        ->where(function ($query) use ($fromdate, $todate) {
            if ($fromdate != '' && $todate != '') {
                $todate = date('Y-m-d', strtotime($todate));
                $todate = Carbon::createFromFormat('Y-m-d', $todate)->addDay();
                $query->whereBetween('event_time', [$fromdate, $todate]);
            }
        })
        ->where('order_status', '<>', 'RS')
        ->where('order_status', '<>', 'EP')
        ->where('is_deleted', 0)
        ->orderBy('event_time')
        ->get();

        $prescribed_date_list = collect($prescription_list2)->where('event_time', '<>', '')
        ->groupBy('id')
        ->map(function ($group) {
            $group[0]->event = date('m-d-Y', strtotime($group[0]->event_time));
            return $group[0];
        })
        ->unique('event')
        ->pluck('event')
        ->toArray();

        $prescription_list = array();

        $prescription_list1->map(function ($pres_list, $key) use ($prescription_list2, $prescription_list1) {
            $pres_list->pres_dtl = collect($prescription_list2)->where('pres_hdr_id', $pres_list->id)
            ->groupBy(function ($item, $key) {
                return date('d-m-Y', strtotime($item->event_time));
            })
            ->map(function ($items) {
                return $items->groupBy(function ($list) {
                    return date('H', strtotime($list->event_time));
                });
            })
            ->toArray();

            if (!(count($pres_list->pres_dtl) > 0)) {
                unset($prescription_list1[$key]);
            }
        });

        $prescription_list = $prescription_list1->groupBy('prescription_type')->toArray();

        return ['prescription_list' => $prescription_list, 'prescribed_date_list' => $prescribed_date_list];
    }

    public function getTerminatePrescription(Request $request)
    {

        $input = $request->all();

        $result_hdr = prescriptionHeader::findOrfail($input['drug_id']);

        $terminate_date = date('Y-m-d', strtotime($input['terminate_datetime']));

        $input['terminate_time'] = strlen($input['terminate_time']) == 2 ? $input['terminate_time'] : '0' . $input['terminate_time'];
        $input['terminate_mins'] = strlen($input['terminate_mins']) == 2 ? $input['terminate_mins'] : '0' . $input['terminate_mins'];

        $terminate_time = $input['terminate_time'] . ":" . $input['terminate_mins'] . " " . $input['terminate_session'];

        $terminate_time = date('H:i', strtotime($terminate_time));

        $terminate_date = $terminate_date . ' ' . $terminate_time;

        $prescribed_hdr['terminate'] = $terminate_date;
        $prescribed_hdr['terminate_reason'] = $input["terminate_reason"];

        $result_hdr->update($prescribed_hdr);

        \SiteHelpers::updateDashboardAtFormUpdation($result_hdr['baby_id'], 'Prescription - Terminate');  

        $post['baby_id'] = $result_hdr['baby_id'];
        $post['admission_id'] = $result_hdr['admission_id'];
        $post['prescription_type'] = $result_hdr['prescription_type'];
        $post['prescription_from'] = 4;
        $post['terminate_modal_id'] = $input['terminate_modal_id'];

        $this->prescriptionSendToUser($post);

        return \Response::json(['type' => 'success', 'message' => 'Status Changed Successfully', 'data' => $post], 200);
    }

    public function updateReviewDate(Request $request)
    {

        $input = $request->all();

        $result_hdr = prescriptionHeader::findOrfail($input['prescription_hdr_id']);

        $prescription_dtl_old = \DB::table('prescription_dtl')
        ->where('pres_hdr_id', $result_hdr['id'])
        ->where('order_status', '<>', 'RS')
        ->where('order_status', '<>', 'EP')
        ->orderBy('event_time', 'desc')
        ->first();
        $last_entry = $prescription_dtl_old->event_time;

        $review_date = date('Y-m-d', strtotime($input['review_date']));
        $prescribed_hdr['review_date'] = $review_date;

        $result_hdr->update($prescribed_hdr);

        $prescription_type = preg_replace('/[0-9]/', '', $prescription_dtl_old->prescription_id);

        $frequency_count = preg_replace('/[Q,H]/', '', $result_hdr['frequency']);

        $date1 = date_create(str_replace('/', '-', $last_entry));
        $date2 = date_create($input['review_date'] . ' 23:59:59');
        $diff = date_diff($date1, $date2);
        $diff_days = $diff->days;
        $diff_hours = $diff->h;

        $diff = ($diff_days * 24) + $diff_hours;

        if ($diff > 0 && is_numeric($frequency_count) && $frequency_count > 0)
        {
            $frequency_grap = (int)($diff / $frequency_count);
        }

        if (isset($frequency_count) && is_numeric($frequency_count) && isset($frequency_grap) && $frequency_grap > 0)
        {

            for ($i = 0;$i < $frequency_grap;$i++)
            {

                $prescribed_dtl['pres_hdr_id'] = $result_hdr['id'];
                $prescribed_dtl['day'] = null;
                $prescribed_dtl['created_date'] = Carbon::now($this->time_zone);
                $prescribed_dtl['created_user'] = $this->auth->user() ['id'];
                $prescribed_dtl['modified_date'] = Carbon::now($this->time_zone);
                $prescribed_dtl['modified_user'] = $this->auth->user() ['id'];
                $last_entry = $prescribed_dtl['event_time'] = Carbon::createFromFormat('Y-m-d H:i:s', $last_entry)->addHours($frequency_count);

                $prescribed_dtl['pres_value'] = prescriptionDetails::create($prescribed_dtl)->id;

                prescriptionDetails::where('id', $prescribed_dtl['pres_value'])->update(['order_id' => $prescribed_dtl['pres_value'], 'prescription_id' => $prescription_type . $prescribed_dtl['pres_value'] . round(microtime(true) * 1000) ]);

            }

        }

        $post['baby_id'] = $result_hdr['baby_id'];
        $post['admission_id'] = $result_hdr['admission_id'];
        $post['hdr_id'] = $result_hdr['id'];
        $post['prescription_type'] = $result_hdr['prescription_type'];
        $post['prescription_from'] = 3;
        $post['review_modal_id'] = $input['review_modal_id'];

        \SiteHelpers::updateDashboardAtFormUpdation($result_hdr['baby_id'], 'Prescription - Review date update');

        $this->prescriptionSendToUser($post);

        return \Response::json(['messageType' => 'success', 'message' => 'Added Succcessfully', 'data' => $post], 200);

    }

    public function updatePrescriptionTime(Request $request)
    {
        $input = $request->all();

        $prescription_dtl = prescriptionDetails::findOrfail($input['pres_id']);

        $pres_id = $input['pres_id'];
        $post['prescription_from'] = 2;

        if (isset($input['confirm_datetime']))
        {

            $started_date = date('Y-m-d', strtotime($input['confirm_datetime']));

            $input['confirm_time'] = strlen($input['confirm_time']) == 2 ? $input['confirm_time'] : '0' . $input['confirm_time'];
            if (isset($input['confirm_mins'])) {
                $input['confirm_mins'] = strlen($input['confirm_mins']) == 2 ? $input['confirm_mins'] : '0' . $input['confirm_mins'];
            } else {
                $input['confirm_mins'] = '00';
            }

            $confirm_time = $input['confirm_time'] . ":" . $input['confirm_mins'] . " " . $input['confirm_session'];

            $confirm_time = date('H:i', strtotime($confirm_time));

            $pres_update['modified_started_date'] = $started_date . ' ' . $confirm_time;

            $pres_update['modified_started_user'] = $this->auth->user() ['id'];

            $prescription_dtl->update($pres_update);

            $pres_update['confirm_time'] = $confirm_time;

            $post['dtl_id'] = $prescription_dtl['id'];
            $post['modified_started_date'] = $input['confirm_datetime'];
            $post['modified_started_24hour'] = $confirm_time;
            $post['modified_started_hour'] = ltrim($input['confirm_time'], '0');
            $post['modified_started_min'] = ltrim($input['confirm_mins'], '0');
            $post['modified_started_session'] = $input['confirm_session'];
            $post['modified_started_user'] = $pres_update['modified_started_user'];
            $post['stage'] = 1;

        }
        else if (isset($input['stop_datetime']))
        {

            if (!isset($input['total_ml']) || empty($input['total_ml']) || !isset($input['total_type']) || empty($input['total_type']))
            {
                return \Response::json(['messageType' => 'error', 'message' => 'Please fill the all the fields']);
            }
            else
            {

                $stop_date = date('Y-m-d', strtotime($input['stop_datetime']));

                $input['stop_time'] = isset($input['stop_time']) ? (strlen($input['stop_time']) == 2 ? $input['stop_time'] : '0' . $input['stop_time']) : 0;
                $input['stop_mins'] = isset($input['stop_mins']) ? (strlen($input['stop_mins']) == 2 ? $input['stop_mins'] : '0' . $input['stop_mins']) : 0;

                $stop_time = $input['stop_time'] . ":" . $input['stop_mins'] . " " . $input['stop_session'];

                $stop_time = date('H:i', strtotime($stop_time));

                $pres_update['modified_stopped_date'] = $stop_date . ' ' . $stop_time;

                $pres_update['modified_stop_reason'] = $input['stop_reason'];

                $pres_update['modified_total_infused'] = $input['total_ml'] . ' ' . $input['total_type'];

                $pres_update['modified_stopped_user'] = $this->auth->user() ['id'];

                $prescription_dtl->update($pres_update);

                $pres_update['stop_time'] = $stop_time;

                $post['dtl_id'] = $prescription_dtl['id'];
                $post['modified_stopped_date'] = $input['stop_datetime'];
                $post['modified_stopped_24hour'] = $stop_time;
                $post['modified_stopped_hour'] = ltrim($input['stop_time'], '0');
                $post['modified_stopped_min'] = ltrim($input['stop_mins'], '0');
                $post['modified_stopped_session'] = $input['stop_session'];
                $post['modified_stopped_user'] = $pres_update['modified_stopped_user'];
                $post['modified_stop_reason'] = $pres_update['modified_stop_reason'];
                $post['modified_total_infused'] = $pres_update['modified_total_infused'];
                $post['stage'] = 3;

            }

        }
        else if (isset($input['cancel_datetime']))
        {

            $cancel_date = date('Y-m-d', strtotime($input['cancel_datetime']));

            $input['cancel_time'] = strlen($input['cancel_time']) == 2 ? $input['cancel_time'] : '0' . $input['cancel_time'];
            $input['cancel_mins'] = strlen($input['cancel_mins']) == 2 ? $input['cancel_mins'] : '0' . $input['cancel_mins'];

            $cancel_time = $input['cancel_time'] . ":" . $input['cancel_mins'] . " " . $input['cancel_session'];

            $cancel_time = date('H:i', strtotime($cancel_time));

            $pres_update['modified_cancel_datetime'] = $cancel_date . ' ' . $cancel_time;

            $pres_update['modified_cancel_reason'] = $input['cancel_reason'];

            $pres_update['modified_cancelled_user'] = $this->auth->user() ['id'];

            $prescription_dtl->update($pres_update);

            $pres_update['cancel_time'] = $cancel_time;

            $post['dtl_id'] = $prescription_dtl['id'];
            $post['modified_cancel_datetime'] = $input['cancel_datetime'];
            $post['modified_cancel_24hour'] = $cancel_time;
            $post['modified_cancel_hour'] = ltrim($input['cancel_time'], '0');
            $post['modified_cancel_min'] = ltrim($input['cancel_mins'], '0');
            $post['modified_cancel_session'] = $input['cancel_session'];
            $post['modified_cancelled_user'] = $pres_update['modified_cancelled_user'];
            $post['modified_cancel_reason'] = $pres_update['modified_cancel_reason'];
            $post['stage'] = 2;

        }

        $post['admission_id'] = $input['admission_id'];
        
        $this->prescriptionSendToUser($post);

        return \Response::json(['type' => 'success', 'message' => 'Date Updated Successfully', 'data' => $post], 200);

    }

    /**
     * Update the working weight in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return Response
     */
    public function storeWorkingWeight(Request $request)
    {
        $input = $request->all();
        $baby_id = $input['baby_id'];
        $admission_id = $input['admission_id'];
        $working_weight = $input['working_weight'];

        $hdr_id = prescriptionHeader::where(['baby_id' => $baby_id, 'admission_id' => $admission_id])->orderBy('id', ' desc')->first();

        if (isset($hdr_id->id))  {
            $temp_hdr_id = $hdr_id->id;
            prescriptionHeader::where(['baby_id' => $baby_id, 'admission_id' => $admission_id, 'id' => $temp_hdr_id])->update(['working_weight' => $working_weight]);
        }

        /*To store Nurse Sheet working weight*/
        $sheet_time = date('Y-m-d H:i:s');
        $sheet_date = date('Y-m-d');
        $day_sheet_id = ImportFhir::get_nurse_sheet_check($sheet_date, $baby_id, $admission_id);

        if (count($day_sheet_id) != 0 && isset($day_sheet_id->id))
        {
            $day_id = $day_sheet_id->id;
        }
        else
        {
            $dayCount = count(ImportFhir::get_nurse_sheet_count($baby_id, $admission_id));
            $sheet_details['day_name'] = 'Day ' . ($dayCount + 1);
            $sheet_details['sheet_date'] = date('Y-m-d');
            $sheet_details['baby_id'] = $baby_id;
            $sheet_details['admission_id'] = $admission_id;
            $sheet_id = NurseSheetMain::create($sheet_details)->id;
            $day_id = $sheet_id;
            FhirFormateController::dayWiseBedLog($sheet_id, $baby_id, $admission_id);
        }

        $emr_header_check = ImportFhir::get_emr_header_checks($sheet_date, $baby_id, $admission_id, $sheet_time);
        if (count($emr_header_check) != 0 && isset($emr_header_check->id))
        {
            $emr_header_id = $emr_header_check->id;
        }
        else
        {
            $baby_details = Baby::find($baby_id);
            $main_sheet['sender'] = env('APP_NAME');
            $main_sheet['gender'] = $baby_details->Sex;
            $main_sheet['sender_time'] = date('Y-m-d H:i:s');
            $main_sheet['visit_date'] = date('Y-m-d H:i:s');
            $main_sheet['loinc_version'] = 2.63;
            $main_sheet['active_flag'] = 'Y';
            $main_sheet['create_user_id'] = $this->auth->user() ['id'];
            $main_sheet['create_tstamp'] = date('Y-m-d H:i:s');
            $main_sheet['modify_user_id'] = $this->auth->user() ['id'];
            $main_sheet['modify_tstamp'] = date('Y-m-d H:i:s');
            $main_sheet['day_id'] = isset($day_id) ? $day_id : null;
            $main_sheet['baby_id'] = isset($baby_id) ? $baby_id : null;
            $main_sheet['mother_id'] = isset($baby_details->MotherId) ? $baby_details->MotherId : null;
            $main_sheet['admission_id'] = isset($admission_id) ? $admission_id : null;
            $main_sheet['added_nurse'] = null;
            $emr_header_id = EmrLogHeader::create($main_sheet)->id;
        }

        $sheet_details = NurseSheetMain::GetNurseSheet($sheet_date, $baby_id, $admission_id);

        if (count($sheet_details) > 0)
        {
            $sheet_id = $sheet_details->id;
            if($sheet_details->working_weight != $working_weight) {
                NurseSheetMain::where('id', $sheet_id)->Update(['working_weight' => $working_weight]);
            }
        }
        
        $post['admission_id'] = $admission_id;
        $post['working_weight'] = $input['working_weight'];

        broadcast(new PrescriptionEvent($post))->toOthers();
        
        if (isset($hdr_id->id))  {
            return \Response::json(['message' => 'Working Weight Updated Successfully', 'type' => 'success'], 200);
        }
        return \Response::json(['message' => 'Nurse sheet working weight Saved Successfully', 'type' => 'success'], 200);
    }

    public function createprescription()
    {

        $drug_iv_fluid_name = \DB::table('mas_drugivfluid')->select('*')
        ->selectRaw('name|| \':\' ||mas_prescription_type.value as namevalue')
        ->leftjoin('mas_prescription_type', 'mas_prescription_type.value', 'type')
        ->where(['mas_drugivfluid.is_deleted' => 0, 'mas_drugivfluid.status' => 1, 'mas_prescription_type.is_deleted' => 0])
        ->where('brand_name', '!=', '')
        ->get()
        ->groupBy('namevalue')->map(function ($group)
        {
            return $group->pluck('brand_name', 'id');
        });

        $drug_iv_fluid_phar_gen = \DB::table('mas_drugivfluid')->select('*')
        ->selectRaw('name|| \':\' ||mas_prescription_type.value as namevalue')
        ->leftjoin('mas_prescription_type', 'mas_prescription_type.value', 'type')
        ->where(['mas_drugivfluid.is_deleted' => 0, 'mas_drugivfluid.status' => 1, 'mas_prescription_type.is_deleted' => 0])
        ->where('generic_pharmacological_name', '!=', '')
        ->get()
        ->groupBy('namevalue')->map(function ($group)
        {
            return $group->pluck('generic_pharmacological_name', 'id');
        });

        $frequency_list = FrequencyMaster::where(['is_deleted' => 0, 'status' => 1])->where('name', '!=', '')
        ->orderBy('freq_id', 'asc')
        ->pluck('name', 'value')
        ->toArray();

        $prescription_freq_dialpad = $this->prescription_freq;

        return view('prescription.prescription_generate', compact('drug_iv_fluid_name', 'drug_iv_fluid_phar_gen', 'prescription_freq_dialpad', 'frequency_list'));
    }

    public function recentlyprescribe(Request $request)
    {
        $input = $request->all() ['brandid'];

        $hdr_dtl = prescriptionHeader::where('brand_name', $input)->orderBy('id', ' desc')
        ->limit(5)
        ->get();

        return \Response::json(['hdr_dtl' => $hdr_dtl], 200);

    }

    public function getLastResultTime(Request $request)
    {

        $bed_id = $request->input('bed_id');

        $result_time = 'NoDataFound!';

        $result = \DB::table('prescription_hdr')->select('result_time')
        ->join('patient_bed_log', 'patient_bed_log.admission_id', 'prescription_hdr.admission_id')
        ->join('prescription_dtl', 'prescription_dtl.pres_hdr_id', 'prescription_hdr.id')
        ->join('prescription', 'prescription.prescription_id', 'prescription_dtl.prescription_id')
        ->where(['patient_bed_log.bed_id' => $bed_id, 'patient_bed_log.status' => 'Occupied'])->orderBy('prescription.result_time', 'desc')
        ->first();

        if (isset($result->result_time) && !empty($result->result_time))
        {
            $result_time = $result->result_time;
        }

        return $result_time;
    }

    public function prescriptionDateFilter(Request $request)
    {
        $input = $request->all();

        $baby_id = $input['baby_id'];
        $admission_id = $input['admission_id'];
        $from_date = date('Y-m-d', strtotime($input['from_date']));
        $to_date = date('Y-m-d', strtotime($input['to_date']));

        $post_data = new Request([
            'baby_id' => $baby_id,
            'admission_id' => $admission_id,
            'from_date' => $from_date,
            'to_date' => $to_date
        ]);

        $filtered_prescription = $this->prescriptionData($post_data);

        $prescription_list = json_encode($filtered_prescription['prescription_list']);
        $prescribed_date_list = json_encode($filtered_prescription['prescribed_date_list']);

        $post_data = new Request([
            'baby_id' => $baby_id,
            'admission_id' => $admission_id
        ]);
        $filtered_prescription = $this->prescriptionData($post_data);
        $prescription_list_id = json_encode($filtered_prescription['prescription_list_id']);

        return \Response::json(['prescription_list' => $prescription_list, 'prescribed_date_list' => $prescribed_date_list, 'prescription_list_id' => $prescription_list_id], 200);

    }

    public function fetchDefaultValue(Request $request) {
        $input = $request->all();
        $drugid = $input['drugid'];
        $type = $input['type'];

        $result = \DB::table('mas_drugivfluid')
        ->select('*')
        ->where('type', $type)
        ->where('id', $drugid)
        ->first();

        return \Response::json(['messageType'=>'success','result' => $result], 200);

    }

    public function selectPrescription(Request $request) {
        $result = $request->all();

        $result['baby_id'] = \SiteHelpers::decrypt_id($result['baby_id']);

        $ids = \SiteHelpers::encrypt_id($result['baby_id'] . '-' . $result['admission_id']);

        return \Response::json(['type' => 'success', 'message' => 'Create prescription', 'url' => action('prescription\PrescriptionController@index').'/'.$ids], 200);

    }

    public static function prescriptionSendToUser($input)
    {
        $post['prescription_from'] = $input['prescription_from'];
        $post['modal_id'] = isset($input['modal_id']) ? $input['modal_id'] : null;
        $post['review_modal_id'] = isset($input['review_modal_id']) ? $input['review_modal_id'] : null;
        $post['edit_modal_id'] = isset($input['edit_modal_id']) ? $input['edit_modal_id'] : null;
        $post['terminate_modal_id'] = isset($input['terminate_modal_id']) ? $input['terminate_modal_id'] : null;

        switch ($post['prescription_from']) {
            case 1:
            $temp_post = self::mappingPrescriptionData($input);
            $post = $temp_post;
            $post['prescription_from'] = 1;
            $post['modal_id'] = isset($input['modal_id']) ? $input['modal_id'] : null;
            break;
            case 2:
            $post['dtl_id'] = $input['dtl_id'];
            if (isset($input['modified_started_date']) && isset($input['modified_started_user'])) {
                $post['modified_started_date'] = $input['modified_started_date'];
                $post['modified_started_24hour'] = $input['modified_started_24hour'];
                $post['modified_started_hour'] = $input['modified_started_hour'];
                $post['modified_started_min'] = $input['modified_started_min'];
                $post['modified_started_session'] = $input['modified_started_session'];
                $post['modified_started_user'] = $input['modified_started_user'];
                $post['stage'] = $input['stage'];
            }

            if (isset($input['modified_cancel_datetime']) && isset($input['modified_cancelled_user']) && isset($input['modified_cancel_reason'])) {
                $post['modified_cancel_date'] = $input['modified_cancel_datetime'];
                $post['modified_cancel_24hour'] = $input['modified_cancel_24hour'];
                $post['modified_cancel_hour'] = $input['modified_cancel_hour'];
                $post['modified_cancel_min'] = $input['modified_cancel_min'];
                $post['modified_cancel_session'] = $input['modified_cancel_session'];
                $post['modified_cancelled_user'] = $input['modified_cancelled_user'];
                $post['modified_cancel_reason'] = $input['modified_cancel_reason'];
                $post['stage'] = $input['stage'];
            }

            if (isset($input['modified_stopped_date']) && isset($input['modified_stopped_user']) && isset($input['modified_stop_reason']) && isset($input['modified_total_infused'])) {
                $post['modified_stopped_date'] = $input['modified_stopped_date'];
                $post['modified_stopped_24hour'] = $input['modified_stopped_24hour'];
                $post['modified_stopped_hour'] = $input['modified_stopped_hour'];
                $post['modified_stopped_min'] = $input['modified_stopped_min'];
                $post['modified_stopped_session'] = $input['modified_stopped_session'];                
                $post['modified_stopped_user'] = $input['modified_stopped_user'];
                $post['modified_stop_reason'] = $input['modified_stop_reason'];
                $post['modified_total_infused'] = $input['modified_total_infused'];
                $post['stage'] = $input['stage'];
            }
            break;
            case 3:
            $post = $input;
            break;  
            case 4:
            $post = $input;
            break;   
            case 5:
            $post = $input;
            break;    
            case 6:
            $temp_post = prescriptionDetails::where('prescription_id', $input['prescription_id'])->first();
            $post = self::mappingPrescriptionData($temp_post);
            $post['prescription_from'] = 1;
            $post['modal_id'] = null;
            break;     
            case 7:
            $post = $input;
            break;           
            default:
                // code...
            break;
        }
        $post['admission_id'] = isset($input['admission_id']) ? $input['admission_id'] : null;
        
        PrescriptionToMirthController::prescription();

        broadcast(new PrescriptionEvent($post))->toOthers();
    }

    public static function mappingPrescriptionData($input)
    {
        $post['id'] = $input['id'];
        $post['is_send'] = $input['is_send'];
        $post['prescription_id'] = $input['prescription_id'];
        $post['started_date'] = $input['started_date'];
        $post['started_user'] = $input['started_user'];
        $post['modified_started_date'] = isset($input['modified_started_date']) ? $input['modified_started_date'] : null;
        $post['modified_started_user'] = isset($input['modified_started_user']) ? $input['modified_started_user'] : null;
        $hdr_id = $input['pres_hdr_id'];
        $post['active_id'] = prescriptionDetails::getGivenPrescription($hdr_id);
        if ($input['is_send'] == 3 || $input['is_send'] == 8 || $input['is_send'] == 10 || $input['is_send'] == 11) {
            $post['cancel_datetime'] = $input['cancel_datetime'];
            $post['cancelled_user'] = $input['cancelled_user'];
            $post['cancel_reason'] = $input['cancel_reason'];
        } else if ($input['is_send'] == 20 || $input['is_send'] == 21) {
            $post['stopped_date'] = $input['stopped_date'];
            $post['stopped_user'] = $input['stopped_user'];
            $post['stop_reason'] = $input['stop_reason'];
            $post['total_infused'] = $input['total_infused'];
        } else if ($input['is_send'] == 7) {
            $post['stopped_date'] = $input['stopped_date'];
            $post['stopped_user'] = $input['stopped_user'];
            $post['stop_reason'] = $input['stop_reason'];
            $result = \DB::table('prescription')
            ->select('infused')
            ->where('prescription_id', $input['prescription_id'])
            ->orderBy('result_time', 'desc')
            ->first();
            $post['infused'] = isset($result->infused) ? $result->infused : '';
        }
        return $post;
    }

}

