<?php
 namespace App\Http\Controllers;

use Illuminate\Html\HtmlFacade  as HTML;
use Auth;
use Excel;
use App\Models\Baby;
use App\Models\Admission;
use App\Models\Masters\MediprobsMaster as MediprobsMaster;
// use App\Models\Masters\Drug as DrugMaster;
use App\Models\Masters\DrugIvFluidMaster;
use App\Models\Masters\Vaccine as VaccineMaster;
use App\Models\Vaccine;
use App\Models\Op;
use App\Models\Medications;
use App\Models\Problems;
use App\Models\Pediatric;
use App\Models\Nicu;
use App\Models\Mother;
use App\Models\Neonatal;
use App\Models\Complication;
use App\Models\Usg;
use App\Http\Requests;
use Illuminate\Http\Request;

class ImportController extends Controller 
{

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{

	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$navigate['main_nav'] = 'dashboard';
		$navigate['sub_nav'] = '';
	}
	public function nicu_import()
	{

		$results = Excel::load('public/imports/admission.xls', function ($reader) {
			// ->all() is a wrapper for ->get() and will work the same
			$results = $reader->all();
		})->all();	

		foreach ($results as $result) {
			$data = array();
			$data['BMrNo'] 	= $result['mr_no']?$result['mr_no']:'';
			$baby_data1 = Baby::Where(['BMrNo'=>$data['BMrNo']])->get();
			$baby_data = $baby_data1[0];
			if ($baby_data && isset($baby_data->BabyId)) {

			$babyid	= $baby_data->BabyId;
			$motherid = $baby_data->MotherId;
			
			$data['FatherSpokenLanguages']	= $result['spoken_languages_f']?$result['spoken_languages_f']:'';
			$data['MotherSpokenLanguages']	= $result['spoken_languages_m']?$result['spoken_languages_m']:'';
			$data['Mobile'] 				= $result['phone_no_m']?$result['phone_no_m']:'';
			$data['FatherContact'] 			= $result['phone_no_f']?$result['phone_no_f']:'';
			$data['PartnerContact'] 		= $result['phone_no_f']?$result['phone_no_f']:'';
			$baby = Baby::findorfail($babyid);
			$baby->update($data);
			
			$mother = Mother::findorfail($motherid);
			$mother->update($data);
			$data['BabyId']			= $babyid;
			$data['MotherId']		= $motherid;
			$data['AdmissionType'] 	= $result['admission_type']?$result['admission_type']:'';
			$data['AdmissionWt'] 	= $result['admission_wt']?$result['admission_wt']:'';
			$data['AgeOnAdmissioninDays'] 	= $result['age_on_admission_in_days']?$result['age_on_admission_in_days']:'';
			$data['BaseExcess'] 			= $result['base_excess']?$result['base_excess']:'';
			$data['CorrectedGestation'] 	= $result['corrected_gestation']?$result['corrected_gestation']:'';
			$data['AdmissionDate'] 			= $result['date_of_admission']?$result['date_of_admission']:'';
			$data['Readmission'] 			= $result['readmission']?$result['readmission']:'';
			$data['ReferralReason'] 		= $result['reason_for_referral']?$result['reason_for_referral']:'';
			$data['ReferredBy'] 			= $result['referred_by']?$result['referred_by']:'';
			$data['SexBirthWtGestation'] 	= $result['sex_birth_wt_gestation']?$result['sex_birth_wt_gestation']:'';
			$data['Surgeon'] 				= $result['surgeon']?$result['surgeon']:'';
			$data['TemperatureAtAdmission'] = $result['temperature_at_admission']?$result['temperature_at_admission']:'';
			$data['AdmissionTime'] 	  = $result['time']?$result['time']:'';
			$data['TotalCRIB2Score']  = $result['total_crib_ii_score']?$result['total_crib_ii_score']:'';
			$data['TypeOfCare'] 	  = $result['type_of_care']?$result['type_of_care']:'';
			$data['discharge_cuss']   = $result['discharge_cuss']?$result['discharge_cuss']:'';
			$data['DischargeHb'] 	  = $result['discharge_hb']?$result['discharge_hb']:'';
			$data['DischargePCV'] 		= $result['discharge_pcv']?$result['discharge_pcv']:'';
			$data['DischargeSerumALP'] 	= $result['discharge_serum_alp']?$result['discharge_serum_alp']:'';
			$data['DischargeSerumCa'] 	= $result['discharge_serum_ca']?$result['discharge_serum_ca']:'';
			$data['DischargeSerumNa'] 	= $result['discharge_serum_na']?$result['discharge_serum_na']:'';
			$data['DischargeSerumPo4'] 	= $result['discharge_serum_po4']?$result['discharge_serum_po4']:'';
			$data['DischargeTSB'] 		= $result['discharge_tsb']?$result['discharge_tsb']:'';
			$data['FeedingAtDischarge'] 	= $result['feeding_at_discharge']?$result['feeding_at_discharge']:'';
			$data['NeurologicalStatus']		= $result['neurological_status']?$result['neurological_status']:'';
			$data['Notes'] 					= $result['notes']?$result['notes']:'';
			$data['Rop'] 					= $result['rop_check']?$result['rop_check']:'';

			$data['Smoking'] 					= $result['smoking']?$result['smoking']:'';
			$data['Alcohol'] 					= $result['alcohol']?$result['alcohol']:'';
			$data['Tobacco'] 					= $result['tobacco']?$result['tobacco']:'';
			$data['PregnancyComplications']	= $result['pregnancy_complications']?$result['pregnancy_complications']:'';
			$data['SurfactantGiven']			= $result['surfactant_given']?$result['surfactant_given']:'';
			$data['SurfactantType'] 			= $result['surfactant_type']?$result['surfactant_type']:'';																		
			$data['Dose'] 					= $result['dose']?$result['dose']:'';																								
			$data['TimeOfAdministration'] 	= $result['time_of_administration']?$result['time_of_administration']:'';																					
			$data['AgeAfterBirth'] 			= $result['age_after_birth']?$result['age_after_birth']:'';																		
			$data['DescriptionOfResuscitation'] = $result['description_of_resuscitation']?$result['description_of_resuscitation']:'';																		
			$data['TransferTime'] 			= $result['time_of_transfer_to_nicu']?$result['time_of_transfer_to_nicu']:'';																		
			$data['AgeOfTransferToNICU'] 	= $result['age_of_transfer_to_nicu']?$result['age_of_transfer_to_nicu']:'';																		
			$data['VentilationRequired'] 	= $result['ventilation_required']?$result['ventilation_required']:'';																																																	
			$data['TransferFiO2'] 			= $result['transfer_fio2']?$result['transfer_fio2']:'';																																																	
			$data['AdmittedFrom'] 			= $result['admitted_from']?$result['admitted_from']:'';																																																	
			$data['AdmissionTime'] 			= $result['time_of_admission']?$result['time_of_admission']:'';																																																	
			$data['Age'] 					= $result['age']?$result['age']:'';																																																	
			$data['HR'] 					= $result['hr_in_bpm']?$result['hr_in_bpm']:'';																																																	
			$data['RR'] 					= $result['rr']?$result['rr']:'';																																																	
			$data['BP'] 					= $result['bp']?$result['bp']:'';																																																	
			$data['MeanBP'] 				= $result['mean_bp']?$result['mean_bp']:'';																																																	
			$data['Temperature'] 			= $result['temperature']?$result['temperature']:'';																																																	
			$data['SpO2'] 					= $result['spo2']?$result['spo2']:'';																																																	
			$data['Fio2'] 					= $result['fio2']?$result['fio2']:'';																																																	
			$data['Ventilation'] 			= $result['ventilation']?$result['ventilation']:'';																																																	
			$data['Mode'] 					= $result['mode']?$result['mode']:'';																																																	
			$data['Pip'] 					= $result['pip']?$result['pip']:'';																																																																																										
			$data['PEEP'] 					= $result['peep']?$result['peep']:'';																																																																																										
			$data['Rate'] 					= $result['rate']?$result['rate']:'';																																																																																										
			$data['IT'] 					= $result['it']?$result['it']:'';																																																																																										
			$data['ChestMovement'] 			= $result['chest_movement']?$result['chest_movement']:'';																																																																																										
			$data['Skin'] 					= $result['skin']?$result['skin']:'';																																																																																										
			$data['Tone'] 					= $result['tone']?$result['tone']:'';																																																																																										
			$data['Abnormalities'] 			= $result['abnormalities']?$result['abnormalities']:'';																																																																																										
			$data['InitialBloodGas'] 		= $result['initial_blood_gas']?$result['initial_blood_gas']:'';																																																																																										
			$data['AgeTaken'] 				= $result['age_taken']?$result['age_taken']:'';																																																																																										
			$data['pH'] 					= $result['ph']?$result['ph']:'';																																																																																										
			$data['PaO2'] 					= $result['pao2']?$result['pao2']:'';																																																																																										
			$data['PaCo2'] 					= $result['paco2']?$result['paco2']:'';																																																																																										
			$data['HCO3'] 					= $result['hco3']?$result['hco3']:'';																																																																																																																																	
			$data['BE'] 					= $result['be']?$result['be']:'';																																																																																																																																	
			$data['RBS'] 					= $result['rbs']?$result['rbs']:'';																																																																																																																																	
			$data['Hct'] 					= $result['hct']?$result['hct']:'';																																																																																																																																	
			$data['RInitialCXRFindingop'] 	= $result['initial_cxr_finding']?$result['initial_cxr_finding']:'';																																																																																																																																	
			$data['AgeofCXR'] 				= $result['age_of_cxr']?$result['age_of_cxr']:'';																																																																																																																																	
			$data['UAC'] 					= $result['uac']?$result['uac']:'';																																																																																																																																	
			$data['UACPosition']			= $result['uac_position']?$result['uac_position']:'';																																																																																																																																	
			$data['UVC'] 					= $result['uvc']?$result['uvc']:'';																																																																																																																																	
			$data['UVCPosition']			= $result['uvc_position']?$result['uvc_position']:'';																																																																																																																																	
			$data['AlteredLinePosition'] 	= $result['altered_line_position']?$result['altered_line_position']:'';																																																																																																																																	
			$data['SepsisScreen'] 			= $result['sepsis_screen']?$result['sepsis_screen']:'';																																																																																																																																	
			$data['Indications']			= $result['indications']?$result['indications']:'';																																																																																																																																	
			$iv_antibiotic[]				= $result['iv_antibiotic_1']?$result['iv_antibiotic_1']:'';																																																																																																																																	
			$iv_antibiotic[] 				= $result['iv_antibiotic_2']?$result['iv_antibiotic_2']:'';																																																																																																																																	
			$iv_antibiotic[]				= $result['iv_antibiotic_3']?$result['iv_antibiotic_3']:'';																																																																																																																																	
			$iv_antibiotic[] 				= $result['iv_antibiotic_4']?$result['iv_antibiotic_4']:'';	
			$data['IVAntibiotic'] 			= serialize($iv_antibiotic);																																																																																																																															
			$data['Investigations']			= $result['investigations']?$result['investigations']:'';																																																																																																																																	
			$data['Fluids']					= $result['fluids_mlkgd']?$result['fluids_mlkgd']:'';																																																																																																																																	
			$data['NBM'] 					= $result['nbm']?$result['nbm']:'';																																																																																																																																																																																										
			$data['DifferentialDiagnosis']	= $result['differential_diagnosis']?$result['differential_diagnosis']:'';																																																																																																																																																																																										
			$data['Plan'] 					= $result['plan']?$result['plan']:'';																																																																																																																																																																																										
			$data['ParentsSpokenTo']		= $result['parents_spoken_to']?$result['parents_spoken_to']:'';																																																																																																																																																																																										
			$data['DiscussionTime']			= $result['time_of_discussion']?$result['time_of_discussion']:'';																																																																																																																																																																																										
			$data['MattersDiscussed']		= $result['matters_discussed']?$result['matters_discussed']:'';																																																																																																																																																																																										
			$data['ParentsAddressedBy']		= $result['parents_addressed_by']?$result['parents_addressed_by']:'';																																																																																																																																																																																										
			$data['CFT'] 					= $result['cft']?$result['cft']:'';																																																																																																																																																																																										
			$data['Status']					= $result['status']?$result['status']:'';																																																																																																																																																																																										
			$data['DischargeDate']			= $result['date_of_discharge']?$result['date_of_discharge']:'';																																																																																																																																																																																										
			$data['DischargeWeight']		= $result['discharge_weight_in_gm']?$result['discharge_weight_in_gm']:'';																																																																																																																																																																																										
			$data['FinalDiagnosis']			= $result['final_diagnosis']?$result['final_diagnosis']:'';																																																																																																																																																																																										
			$data['OFC'] 					= $result['ofc_in_cm']?$result['ofc_in_cm']:'';																																																																																																																																																																																										
			$data['Immunization']			= $result['immunization']?$result['immunization']:'';																																																																																																																																																																																										
			$data['Schedule'] 				= $result['schedule']?$result['schedule']:'';																																																																																																																																																																																										
			$data['NextAppointment']		= $result['next_appointment']?$result['next_appointment']:'';		
			$data['Advice'] 				= $result['advice']?$result['advice']:'';																																																																																																																																																																																										
			$data['Length'] 				= $result['length_in_cm']?$result['length_in_cm']:'';																																																																																																																																																																																										
			$data['MBP'] 					= $result['mbp']?$result['mbp']:'';																																																																																																																																																																																																																																																																																																												
			$data['LowestTemperature']		= $result['lowest_temperature']?$result['lowest_temperature']:'';																																																																																																																																																																																																																																																																																																												
			$data['Po2Fio2Ratio']			= $result['po2_fio2_ratio']?$result['po2_fio2_ratio']:'';																																																																																																																																																																																																																																																																																																												
			$data['LowestSerumPh']			= $result['lowest_serum_ph']?$result['lowest_serum_ph']:'';																																																																																																																																																																																																																																																																																																												
			$data['MultipleSeizures']		= $result['multiple_seizures']?$result['multiple_seizures']:'';																																																																																																																																																																																																																																																																																																												
			$data['UrineOutput']			= $result['urine_output']?$result['urine_output']:'';																																																																																																																																																																																																																																																																																																												
			$data['BWeight'] 				= $result['b_weight']?$result['b_weight']:'';																																																																																																																																																																																																																																																																																																												
			$data['SgaLessThan3rdPercentile'] = $result['sga_less_than_3rd_percentile']?$result['sga_less_than_3rd_percentile']:'';																																																																																																																																																																																																																																																																																																												
			$data['Apgar5Mins']				= $result['apgar_score_at_5_mins']?$result['apgar_score_at_5_mins']:'';																																																																																																																																																																																																																																																																																																												
			$data['TotalSNAPPE2Score']		= $result['total_snappe_ii_score']?$result['total_snappe_ii_score']:'';																																																																																																																																																																																																																																																																																																												
			$data['TotalSNAP2Score']		= $result['total_snap_ii_score']?$result['total_snap_ii_score']:'';		
																																																																																																																																																																																																																																																																																																													
			$data['RopScreening']			= $result['rop_screening']?$result['rop_screening']:'';																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																													
			$data['HearingScreening']		= $result['hearing_screening']?$result['hearing_screening']:'';																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																													
			$data['NewBornScreen']			= $result['newborn_screen']?$result['newborn_screen']:'';																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																			
			$data['MajorComplaints']		= $result['major_complaints']?$result['major_complaints']:'';																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																
			$data['DOLatDischarge']			= $result['dol_at_discharge']?$result['dol_at_discharge']:'';																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																
			$data['CGAatDischarge']			= $result['cga_at_discharge']?$result['cga_at_discharge']:'';																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																
			$data['Problem']				= $result['problem']?$result['problem']:'';																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																									
			$data['PbmProcedure'] 			= $result['procedure']?$result['procedure']:'';			
			
			$admission_data 	= array(
				'BMrNo'			=>  $baby_data->BMrNo,
				'MotherId'		=>  $baby_data->MotherId,
				'BabyId'		=>  $baby_data->BabyId,
				'AdmissionDate'	=> $data['AdmissionDate'] ,
				'AdmissionTime'	=> $data['AdmissionTime'] ,
				'InOrOut'		=> 'In',
				'AdmissionType'	=> '',
				'Status'		=> $data['Status'],
				'DateAdded'		=> date('y-m-d H:i:s')
			);
			
			$admission = Admission::create($admission_data);
			$data['AdmissionId'] = $admission_id = $admission->AdmissionId;
			
			$nicu = Nicu::create($data);
			
			$problem[] 						= $result['med_prob_3']?$result['med_prob_3']:'';
			$problem[]						= $result['med_prob_4']?$result['med_prob_4']:'';	
			$problem[] 						= $result['med_prob_5']?$result['med_prob_5']:'';														
			$medication[]					= $result['medication3']?$result['medication3']:'';														
			$medication[] 					= $result['medication4']?$result['medication4']:'';														
			$medication[] 					= $result['medication5']?$result['medication5']:'';				
			for ($i=0; $i<3; $i++) {
				if (isset($problem[$i]) && $problem[$i]!='') {
					$problems[] = array(
						'BabyId'		=> 	$babyid,
						'MotherId'		=>  $motherid,
						'Problem'		=>  $problem[$i],
						'Medication'	=>  $medication[$i],
					);
					
					$medications = MediprobsMaster::Where(['Name'=>$problem[$i]])->get();
					if (!isset($medications[0])) {
						$medication_master  =  array(
							'Name'		=> $problem[$i],
							'Status'	=> 'Active',
							'DateAdded'	=> date('Y-m-d H:i:s'),
							'DateModified'	=> date('Y-m-d H:i:s')						
						);
						MediprobsMaster::create($medication_master);
					}
					Problems::create($problems);
				}
			}							
			$discharge_medication 			= array();	
			$discharge_medication[]			= $result['discharge_medications_1']?$result['discharge_medications_1']:'';																																																																																																																																																																																										
			$discharge_medication[]			= $result['discharge_medications_2']?$result['discharge_medications_2']:'';																																																																																																																																																																																										
			$discharge_medication[]			= $result['discharge_medications_3']?$result['discharge_medications_3']:'';																																																																																																																																																																																										
			$discharge_medication[]			= $result['discharge_medications_4']?$result['discharge_medications_4']:'';																																																																																																																																																																																										
			$discharge_medication[]			= $result['discharge_medications_5']?$result['discharge_medications_5']:'';	
			
			$dose							= array();																																																																																																																																																																																										
			$dose[]							= $result['dose_1']?$result['dose_1']:'';																																																																																																																																																																																										
			$dose[]		 					= $result['dose_2']?$result['dose_2']:'';																																																																																																																																																																																										
			$dose[]		 					= $result['dose_3']?$result['dose_3']:'';																																																																																																																																																																																										
			$dose[]		 					= $result['dose_4']?$result['dose_4']:'';																																																																																																																																																																																										
			$dose[]		 					= $result['dose_5']?$result['dose_5']:'';	
			
			$duration = array();																																																																																																																																																																																											
			$duration[] 					= $result['duration_1']?$result['duration_1']:'';																																																																																																																																																																																										
			$duration[] 					= $result['duration_2']?$result['duration_2']:'';																																																																																																																																																																																										
			$duration[] 					= $result['duration_3']?$result['duration_3']:'';																																																																																																																																																																																										
			$duration[] 					= $result['duration_4']?$result['duration_4']:'';																																																																																																																																																																																										
			$duration[] 					= $result['duration_5']?$result['duration_5']:'';	
			
			$frequency = array();																																																																																																																																																																																									
			$frequency[] 					= $result['frequency_1']?$result['frequency_1']:'';																																																																																																																																																																																										
			$frequency[] 					= $result['frequency_2']?$result['frequency_2']:'';																																																																																																																																																																																										
			$frequency[] 					= $result['frequency_3']?$result['frequency_3']:'';																																																																																																																																																																																										
			$frequency[] 					= $result['frequency_4']?$result['frequency_4']:'';																																																																																																																																																																																										
			$frequency[] 					= $result['frequency_5']?$result['frequency_5']:'';	
		
			$vaccine = array();
			$vaccine[] 						= $result['vaccine1']?$result['vaccine1']:'';																																																																																																																																																																																																																																																																																																												
			$vaccine[] 						= $result['vaccine2']?$result['vaccine2']:'';																																																																																																																																																																																																																																																																																																																																																
			$vaccine[] 						= $result['vaccine3']?$result['vaccine3']:'';																																																																																																																																																																																																																																																																																																																																																
			$vaccine[] 						= $result['vaccine4']?$result['vaccine4']:'';	
			
			$dates = array();																																																																																																																																																																																																																																																																																																																																															
			$dates[] 						= $result['date1']?$result['date1']:'';					
			$dates[]  						= $result['date2']?$result['date2']:'';																																																																																																																																																																																																																																																																																																																																																
			$dates[]  						= $result['date3']?$result['date3']:'';																																																																																																																																																																																																																																																																																																																																																
			$dates[] 						= $result['date4']?$result['date4']:'';	
						
			for ($i=0; $i<5; $i++) {
				$medications = array();
				if (isset($discharge_medication[$i]) && $discharge_medication[$i]!='') {
					$medications = array(
						'BabyId'		=> 	$babyid,
						'AdmissionId'	=>  $admission_id,
						'Medication'	=>  $discharge_medication[$i],
						'Dose'			=>  $dose[$i],
						'Frequency'		=>  $frequency[$i],
						'Duration'		=>  $duration[$i]
					);
					
					$medication_data = DrugIvFluidMaster::Where(['brand_name'=>$discharge_medication[$i], 'type'=>'ORAL'])->get();
					if (!isset($medication_data[0])) {
						$medication_master  =  array(
							'brand_name'	=> $discharge_medication[$i],
							'status'		=> 'Active',
							'DateAdded'		=> date('Y-m-d H:i:s'),
							'DateModified'	=> date('Y-m-d H:i:s')						
						);
						DrugIvFluidMaster::create($medication_master);
					}
						Medications::create($medications);					
				}
			}	
			for ($i=0; $i<4; $i++) {
				$vaccine_array= array();
				if (isset($vaccine[$i]) && $vaccine[$i]!='') {
					$vaccine_array = array(
						'AdmissionId'	=> $admission_id,
						'Vaccine'		=>  $vaccine[$i],
						'VaccineDate'	=>  $dates[$i],
						'BabyId'		=> 	$babyid
					);
					$vaccine_data = VaccineMaster::Where(['Name'=>$vaccine[$i]])->get();
					if (!isset($vaccine_data[0])) {
						$medication_master  =  array(
							'Name'			=> $vaccine[$i],
							'Status'		=> 'Active',
							'DateAdded'		=> date('Y-m-d H:i:s'),
							'DateModified'	=> date('Y-m-d H:i:s')						
						);
						VaccineMaster::create($medication_master);
					}
					Vaccine::create($vaccine_array);	
				}
			}
		}
		}
	}
	public function op_import()
	{
		$results = Excel::load('public/imports/op.xls', function ($reader) {
			// ->all() is a wrapper for ->get() and will work the same
			$results = $reader->all();
		})->all();	

		foreach ($results as $result) {
			$data = array();
			$data['BMrNo'] 	= $result['mr_no']?$result['mr_no']:'';
			$baby_data1 = Baby::Where(['BMrNo'=>$data['BMrNo']])->get();
			$baby_data = isset($baby_data1[0])?$baby_data1[0]:false;
			if ($baby_data && isset($baby_data->BabyId)) {

				$babyid	= $baby_data->BabyId;
				$motherid = $baby_data->MotherId;
				
				$data['Background']	= $result['backround']?$result['backround']:($result['neonatal_proformabackground']?$result['neonatal_proformabackground']:'');
				$data['ConfidentialBackgroundDetails']	= $result['neonatal_proformaconfidential_background_details']?$result['neonatal_proformaconfidential_background_details']:'';
				
				$data['Complaints']	= $result['complaints']?$result['complaints']:'';
				$data['HPI']	= $result['hpi']?$result['hpi']:'';
				$data['Development']	= $result['development']?$result['development']:'';
				$data['AllergyHistory']	= $result['allergy_history']?$result['allergy_history']:'';
				$data['FamilyHistory']	= $result['family_history']?$result['family_history']:'';
				$data['Examination']	= $result['examination']?$result['examination']:'';
				$data['Diagnosis']	= $result['diagnosis']?$result['diagnosis']:'';
				$data['Review']	= $result['review']?$result['review']:'';
				$data['AppointmentType']	= $result['appointment_type']?$result['appointment_type']:'';
				$data['fee']	= $result['fee']?$result['fee']:'';
				$data['OpTime']	=  $result['time']?date('H:i:s', strtotime($result['time'])):'';
				$data['OpDate']	= $result['date']?date('Y-m-d', strtotime($result['date'])):'';
/*				$data['city']	= $result['city']?$result['city']:($result['neonatal_proformacity']?$result['neonatal_proformacity']:'');
				$data['birth_weight_gms']	= $result['birth_weight_gms']?$result['birth_weight_gms']:($result['neonatal_proformabirth_weight']?$result['neonatal_proformabirth_weight']:'');																																								
				$data['gestation']	= $result['gestation']?$result['gestation']:($result['neonatal_proformagestation']?$result['neonatal_proformagestation']:'');	
				$data['birth_status']	= $result['birth_status']?$result['birth_status']:($result['neonatal_proformabirth_status']?$result['neonatal_proformabirth_status']:'');	
*/																																										
				$data['CurrentWt']	= $result['current_wt_gms']?$result['current_wt_gms']:'';																																								
				$data['CurrentOFC']	= $result['current_ofc_cm']?$result['current_ofc_cm']:'';																																																				
				$data['CurrentLength']	= $result['current_length_cm']?$result['current_length_cm']:'';																																																				
				$data['DayOfLife']	= $result['day_of_life']?$result['day_of_life']:'';																																																				
				$data['TreatmentHistory']	= $result['treatment_history']?$result['treatment_history']:'';																																																				
				$data['Advice']	= $result['advice']?$result['advice']:'';	
				$data['Immunization']	= $result['immunization']?$result['immunization']:'';	
				$data['Schedule']	= $result['schedule']?$result['schedule']:'';	
				$data['Outcome']	= $result['outcome']?$result['outcome']:'';	
				$data['BabyId']			= $babyid;

				$admission_data 	= array(
					'BMrNo'			=>  $baby_data->BMrNo,
					'MotherId'		=>  $baby_data->MotherId,
					'BabyId'		=>  $baby_data->BabyId,
					'AdmissionDate'	=> $data['OpDate'] ,
					'AdmissionTime'	=> $data['OpTime'] ,
					'InOrOut'		=> 'Out',
					'AdmissionType'	=> 'OP',
					'Status'		=> $data['Outcome'],
					'DateAdded'		=> date('y-m-d H:i:s')
				);
				
				$admission = Admission::create($admission_data);
				$data['AdmissionId'] = $admission_id = $admission->AdmissionId;
				
				$nicu = Op::create($data);				

				$vaccine = array();
				$vaccine[] 						= $result['vaccine_1']?$result['vaccine_1']:'';																																																																																																																																																																																																																																																																																																												
				$vaccine[] 						= $result['vaccine_2']?$result['vaccine_2']:'';																																																																																																																																																																																																																																																																																																																																																
				$vaccine[] 						= $result['vaccine_3']?$result['vaccine_3']:'';																																																																																																																																																																																																																																																																																																																																																
				$vaccine[] 						= $result['vaccine_4']?$result['vaccine_4']:'';	
							
				$data['Vaccine']	= serialize($vaccine);	
				

				
				$discharge_medication 			= array();	
				$discharge_medication[]			= $result['drug_name_1']?$result['drug_name_1']:'';																																																																																																																																																																																										
				$discharge_medication[]			= $result['drug_name_2']?$result['drug_name_2']:'';																																																																																																																																																																																										
				$discharge_medication[]			= $result['drug_name_3']?$result['drug_name_3']:'';																																																																																																																																																																																										
				$discharge_medication[]			= $result['drug_name_4']?$result['drug_name_4']:'';																																																																																																																																																																																										
				$discharge_medication[]			= $result['drug_name_5']?$result['drug_name_5']:'';	
				$discharge_medication[]			= $result['drug_name_6']?$result['drug_name_6']:'';																																																																																																																																																																																										
				$discharge_medication[]			= $result['drug_name_7']?$result['drug_name_7']:'';				
				
				$dose							= array();																																																																																																																																																																																										
				$dose[]							= $result['dose_1']?$result['dose_1']:'';																																																																																																																																																																																										
				$dose[]		 					= $result['dose_2']?$result['dose_2']:'';																																																																																																																																																																																										
				$dose[]		 					= $result['dose_3']?$result['dose_3']:'';																																																																																																																																																																																										
				$dose[]		 					= $result['dose_4']?$result['dose_4']:'';																																																																																																																																																																																										
				$dose[]		 					= $result['dose_5']?$result['dose_5']:'';
				$dose[]		 					= $result['dose_6']?$result['dose_6']:'';																																																																																																																																																																																										
				$dose[]		 					= $result['dose_7']?$result['dose_7']:'';				
				
				$duration = array();																																																																																																																																																																																											
				$duration[] 					= $result['duration_1']?$result['duration_1']:'';																																																																																																																																																																																										
				$duration[] 					= $result['duration_2']?$result['duration_2']:'';																																																																																																																																																																																										
				$duration[] 					= $result['duration_3']?$result['duration_3']:'';																																																																																																																																																																																										
				$duration[] 					= $result['duration_4']?$result['duration_4']:'';																																																																																																																																																																																										
				$duration[] 					= $result['duration_5']?$result['duration_5']:'';	
				$duration[] 					= $result['duration_6']?$result['duration_6']:'';																																																																																																																																																																																										
				$duration[] 					= $result['duration_7']?$result['duration_7']:'';				
				
				$frequency = array();																																																																																																																																																																																									
				$frequency[] 					= $result['frequency_1']?$result['frequency_1']:'';																																																																																																																																																																																										
				$frequency[] 					= $result['frequency_2']?$result['frequency_2']:'';																																																																																																																																																																																										
				$frequency[] 					= $result['frequency_3']?$result['frequency_3']:'';																																																																																																																																																																																										
				$frequency[] 					= $result['frequency_4']?$result['frequency_4']:'';																																																																																																																																																																																										
				$frequency[] 					= $result['frequency_5']?$result['frequency_5']:'';	
				$frequency[] 					= $result['frequency_6']?$result['frequency_6']:'';																																																																																																																																																																																										
				$frequency[] 					= $result['frequency_7']?$result['frequency_7']:'';				
		


						
			for ($i=0; $i<7; $i++) {
				$medications = array();
				if (isset($discharge_medication[$i]) && $discharge_medication[$i]!='') {
					$medications = array(
						'BabyId'		=> 	$babyid,
						'AdmissionId'	=>  $admission_id,
						'Medication'	=>  $discharge_medication[$i],
						'Dose'			=>  $dose[$i],
						'Frequency'		=>  $frequency[$i],
						'Duration'		=>  $duration[$i]
					);
					
					$medication_data = DrugIvFluidMaster::Where(['brand_name'=>$discharge_medication[$i], 'type'=>'ORAL'])->get();
					if (!isset($medication_data[0])) {
						$medication_master  =  array(
							'brand_name'	=> $discharge_medication[$i],
							'status'		=> 'InActive',
							'DateAdded'		=> date('Y-m-d H:i:s'),
							'DateModified'	=> date('Y-m-d H:i:s')						
						);
						DrugIvFluidMaster::create($medication_master);
					}
						Medications::create($medications);					
				}
			}	
			for ($i=0; $i<4; $i++) {
				$vaccine_array= array();
				if (isset($vaccine[$i]) && $vaccine[$i]!='') {
					$vaccine_data = VaccineMaster::Where(['Name'=>$vaccine[$i]])->get();
					if (!isset($vaccine_data[0])) {
						$medication_master  =  array(
							'Name'			=> $vaccine[$i],
							'Status'		=> 'InActive',
							'DateAdded'		=> date('Y-m-d H:i:s'),
							'DateModified'	=> date('Y-m-d H:i:s')						
						);
						VaccineMaster::create($medication_master);
					}
				}
			}														
			}
		}
		echo "Success";
	}
	public function pediatric_import()
	{
	
		$results = Excel::load('public/imports/pediatric_admission.xls', function ($reader) {
			// ->all() is a wrapper for ->get() and will work the same
			$results = $reader->all();
		})->all();	

		foreach ($results as $result) {
			$data = array();
			$data['BMrNo'] 	= $result['mr_no']?$result['mr_no']:'';
			$baby_data1 = Baby::Where(['BMrNo'=>$data['BMrNo']])->get();
			$baby_data = isset($baby_data1[0])?$baby_data1[0]:false;
			
			if ($baby_data && isset($baby_data->BabyId)) {

				$babyid	= $baby_data->BabyId;
				$motherid = $baby_data->MotherId;
				
				
				$data['AdmissionTime']	=  $result['time']?date('H:i:s', strtotime($result['time'])):'';
				$data['AdmissionDate']	= $result['date']?date('Y-m-d', strtotime($result['date'])):'';
								
				$data['AgeOnAdmission']		= $result['age_on_admission']?$result['age_on_admission']:'';
				$data['SeenBy']	= $result['attending_consultant']?$result['attending_consultant']:'';
				$data['Surgeon']	= $result['surgeon']?$result['surgeon']:'';
				$data['ReferredBy']	= $result['referred_by']?$result['referred_by']:'';
				$data['ReasonForReferral']	= $result['reason_for_referral']?$result['reason_for_referral']:'';
				$data['Complaints']		= $result['complaints']?$result['complaints']:'';
				$data['HPI']			= $result['hpi']?$result['hpi']:'';
				$data['TreatmentHistory']	= $result['treatment_history']?$result['treatment_history']:'';
				$data['FamilyHistory']			= $result['family_history']?$result['family_history']:'';

				$data['AllergyHistory']		= $result['allergy_history']?$result['allergy_history']:'';																																								
				$data['Development']		= $result['development']?$result['development']:'';																																																				
				$data['ImmunisationStatus']	= $result['immunisation_status']?$result['immunisation_status']:'';																																																				
				$data['PastHistory']		= $result['past_history']?$result['past_history']:'';																																																				
				$data['HR']	= $result['hr']?$result['hr']:'';																																																				
				$data['RR']			= $result['rr']?$result['rr']:'';	
				$data['SpO2']	= $result['spo2']?$result['spo2']:'';	
				$data['CFT']	= $result['cft']?$result['cft']:'';	
				$data['BP']	= $result['bp']?$result['bp']:'';	
				$data['Colour']	= $result['colour']?$result['colour']:'';	
				$data['Temperature']	= $result['temperature']?$result['temperature']:'';	
				$data['CentralPulses']	= $result['central_pulses']?$result['central_pulses']:'';	
				$data['PeripheralPulses']	= $result['peripheral_pulses']?$result['peripheral_pulses']:'';	
				$data['FemoralPulses']	= $result['femoral_pulses']?$result['femoral_pulses']:'';	
				$data['CurrentWt']	= $result['current_wt']?$result['current_wt']:'';	
				$data['CurrentLength']	= $result['current_length']?$result['current_length']:'';	
				$data['CurrentOFC']	= $result['current_ofc']?$result['current_ofc']:'';	
				$data['Pallor']	= $result['pallor']?$result['pallor']:'';	
				$data['Jaundice']	= $result['jaundice']?$result['jaundice']:'';	
				$data['Edema']	= $result['edema']?$result['edema']:'';	
				$data['Lymphadenopathy']	= $result['lymphadenopathy']?$result['lymphadenopathy']:'';	
				$data['CVS']	= $result['cvs']?$result['cvs']:'';	
				$data['RS']	= $result['rs']?$result['rs']:'';	
				$data['Abdomen']	= $result['abdomen']?$result['abdomen']:'';	
				$data['CNS']	= $result['cns']?$result['cns']:'';	
				$data['Scalp']	= $result['scalp']?$result['scalp']:'';	
				$data['Hairs']	= $result['hairs']?$result['hairs']:'';	
				$data['AnteriorFontanelle']	= $result['anterior_fontanelle']?$result['anterior_fontanelle']:'';	
				$data['Eyes']	= $result['eyes']?$result['eyes']:'';	
				$data['Ears']	= $result['ears']?$result['ears']:'';	
				$data['Nose']	= $result['nose']?$result['nose']:'';	
				$data['Lips']	= $result['lips']?$result['lips']:'';	
				$data['Palate']	= $result['palate']?$result['palate']:'';	
				$data['Neck']	= $result['neck']?$result['neck']:'';	
				$data['Nipples']	= $result['nipples']?$result['nipples']:'';	
				$data['Nostrils']	= $result['nostrils']?$result['nostrils']:'';	
				$data['Umbilicus']	= $result['umbilicus']?$result['umbilicus']:'';	
				$data['HernialOrifices']	= $result['hernial_orifices']?$result['hernial_orifices']:'';	
				$data['Genitalia']	= $result['genitalia']?$result['genitalia']:'';	
				$data['Hips']	= $result['hips']?$result['hips']:'';	
				$data['RtUL']	= $result['rt_ul']?$result['rt_ul']:'';	
				$data['LtUL']	= $result['lt_ul']?$result['lt_ul']:'';	
				$data['RtLL']	= $result['rt_ll']?$result['rt_ll']:'';		
				$data['LtLL']	= $result['lt_ll']?$result['lt_ll']:'';		
				$data['Anus']	= $result['anus']?$result['anus']:'';		
				$data['Spine']	= $result['spine']?$result['spine']:'';		
				$data['Skin']	= $result['skin']?$result['skin']:'';		
				$data['OtherAbnormality']	= $result['any_other_abnormality']?$result['any_other_abnormality']:'';		
				$data['ApicalImpulse']	= $result['apical_impulse']?$result['apical_impulse']:'';		
				$data['PrecordialActivity']	= $result['precordial_activity']?$result['precordial_activity']:'';		
				$data['S1S2']	= $result['s1s2']?$result['s1s2']:'';		
				$data['Murmur']	= $result['murmur']?$result['murmur']:'';		
				$data['CharacterOfMurmur']	= $result['character_of_murmur']?$result['character_of_murmur']:'';		
				$data['SiteOfMurmur']	= $result['site_of_murmur']?$result['site_of_murmur']:'';		
				$data['BoundingPulses']	= $result['bounding_pulses']?$result['bounding_pulses']:'';		
				$data['ChestMovement']	= $result['chest_movement']?$result['chest_movement']:'';		
				$data['BreathSounds']	= $result['breath_sounds']?$result['breath_sounds']:'';		
				$data['AirEntry']	= $result['air_entry']?$result['air_entry']:'';		
				$data['AddedSounds']	= $result['added_sounds']?$result['added_sounds']:'';		
				$data['CharacterOfAddedSounds']	= $result['character_of_added_sounds']?$result['character_of_added_sounds']:'';		
				$data['SiteOfAddedSounds']	= $result['site_of_added_sounds']?$result['site_of_added_sounds']:'';		
				$data['AbdomenShape']	= $result['abdomen_shape']?$result['abdomen_shape']:'';		
				$data['Hepatomegaly']	= $result['hepatomegaly']?$result['hepatomegaly']:'';		
				$data['LiverSpan']	= $result['liver_span']?$result['liver_span']:'';																																																																																																																																																					
				$data['Splenomegaly']	= $result['splenomegaly']?$result['splenomegaly']:'';																																																																																																																																																					
				$data['SpleenSpan']	= $result['spleen_span']?$result['spleen_span']:'';																																																																																																																																																					
				$data['Flanks']	= $result['flanks']?$result['flanks']:'';																																																																																																																																																					
				$data['OtherMass']	= $result['any_other_mass']?$result['any_other_mass']:'';																																																																																																																																																					
				$data['LevelOfConsciousness']	= $result['level_of_consciousness']?$result['level_of_consciousness']:'';																																																																																																																																																					
				$data['Seizures']	= $result['seizures']?$result['seizures']:'';																																																																																																																																																					
				$data['TypeOfSeizure']	= $result['type_of_seizure']?$result['type_of_seizure']:'';																																																																																																																																																					
				$data['Cry']	= $result['cry']?$result['cry']:'';																																																																																																																																																					
				$data['GeneralBodyMovements']	= $result['general_body_movements']?$result['general_body_movements']:'';																																																																																																																																																					
				$data['SpontaneousActivity']	= $result['spontaneous_activity']?$result['spontaneous_activity']:'';																																																																																																																																																					
				$data['NeonatalReflexes']	= $result['neonatal_reflexes']?$result['neonatal_reflexes']:'';																																																																																																																																																					
				$data['DifferentialDiagnosis']	= $result['differential_diagnosis']?$result['differential_diagnosis']:'';																																																																																																																																																					
				$data['Plan']	= $result['plan']?$result['plan']:'';																																																																																																																																																					
				$data['CVSFindings']	= $result['other_cvs_findings']?$result['other_cvs_findings']:'';																																																																																																																																																					
				$data['RSFindings']	= $result['other_rs_findings']?$result['other_rs_findings']:'';																																																																																																																																																					
				$data['PAFindings']	= $result['other_pa_findings']?$result['other_pa_findings']:'';																																																																																																																																																					
				$data['CNSFindings']	= $result['other_cns_findings']?$result['other_cns_findings']:'';																																																																																																																																																					
				$data['CranialNerves']	= $result['cranial_nerves']?$result['cranial_nerves']:'';																																																																																																																																																					
				$data['MotorSystem']	= $result['motor_system']?$result['motor_system']:'';																																																																																																																																																					
				$data['SensorySystem']	= $result['sensory_system']?$result['sensory_system']:'';																																																																																																																																																					
				$data['MeningealSigns']	= $result['meningeal_signs']?$result['meningeal_signs']:'';																																																																																																																																																					
				$data['CerebellarSigns']	= $result['cerebellar_signs']?$result['cerebellar_signs']:'';																																																																																																																																																					
				$data['SpineCranium']	= $result['spine_cranium']?$result['spine_cranium']:'';																																																																																																																																																																																																					
				$data['DTRs']	= $result['dtrs']?$result['dtrs']:'';																																																																																																																																																																																																					
				$data['Status']	= $result['status']?$result['status']:'';																																																																																																																																																																																																					
				$data['DischargeDate']	= $result['date_of_discharge']?$result['date_of_discharge']:'';																																																																																																																																																																																																					
				$data['DischargeWeight']	= $result['discharge_weight']?$result['discharge_weight']:'';																																																																																																																																																																																																					
				$data['Advice']	= $result['advice']?$result['advice']:'';																																																																																																																																																																																																					
				$data['Course']	= $result['course']?$result['course']:'';																																																																																																																																																																																																					
				$data['Investigations']	= $result['investigations']?$result['investigations']:'';																																																																																																																																																																																																					
				$data['FinalDiagnosis']	= $result['final_diagnosis']?$result['final_diagnosis']:'';																																																																																																																																																																																																					
				$data['NextAppointment']	= $result['next_appointment']?$result['next_appointment']:'';	
																																																																																																																																																																																																								
				// $data['Outcome']	= $result['entered_by']?$result['entered_by']:'';																																																																																																																																																																																																																																													
																																																																												
				$data['BabyId']			= $babyid;
				$data['MotherId']		= $motherid;
				$admission_data 	= array(
					'BMrNo'			=>  $baby_data->BMrNo,
					'MotherId'		=>  $baby_data->MotherId,
					'BabyId'		=>  $baby_data->BabyId,
					'AdmissionDate'	=> $data['AdmissionDate'] ,
					'AdmissionTime'	=> $data['AdmissionTime'] ,
					'InOrOut'		=> 'In',
					'AdmissionType'	=> 'Pediatric',
					'Status'		=> $data['Status'],
					'DateAdded'		=> date('y-m-d H:i:s')
				);
				
				$admission = Admission::create($admission_data);
				$data['AdmissionId'] = $admission_id = $admission->AdmissionId;
				
				$nicu = Pediatric::create($data);				

				
				$discharge_medication 			= array();	
				$discharge_medication[]			= $result['drug_name_1']?$result['drug_name_1']:'';																																																																																																																																																																																										
				$discharge_medication[]			= $result['drug_name_2']?$result['drug_name_2']:'';																																																																																																																																																																																										
				$discharge_medication[]			= $result['drug_name_3']?$result['drug_name_3']:'';																																																																																																																																																																																										
				$discharge_medication[]			= $result['drug_name_4']?$result['drug_name_4']:'';																																																																																																																																																																																										
				$discharge_medication[]			= $result['drug_name_5']?$result['drug_name_5']:'';	
				$discharge_medication[]			= $result['drug_name_6']?$result['drug_name_6']:'';																																																																																																																																																																																												
				
				$dose							= array();																																																																																																																																																																																										
				$dose[]							= $result['dose_1']?$result['dose_1']:'';																																																																																																																																																																																										
				$dose[]		 					= $result['dose_2']?$result['dose_2']:'';																																																																																																																																																																																										
				$dose[]		 					= $result['dose_3']?$result['dose_3']:'';																																																																																																																																																																																										
				$dose[]		 					= $result['dose_4']?$result['dose_4']:'';																																																																																																																																																																																										
				$dose[]		 					= $result['dose_5']?$result['dose_5']:'';
				$dose[]		 					= $result['dose_6']?$result['dose_6']:'';																																																																																																																																																																																										
				
				$duration = array();																																																																																																																																																																																											
				$duration[] 					= $result['duration_1']?$result['duration_1']:'';																																																																																																																																																																																										
				$duration[] 					= $result['duration_2']?$result['duration_2']:'';																																																																																																																																																																																										
				$duration[] 					= $result['duration_3']?$result['duration_3']:'';																																																																																																																																																																																										
				$duration[] 					= $result['duration_4']?$result['duration_4']:'';																																																																																																																																																																																										
				$duration[] 					= $result['duration_5']?$result['duration_5']:'';	
				$duration[] 					= $result['duration_6']?$result['duration_6']:'';																																																																																																																																																																																										
				
				$frequency = array();																																																																																																																																																																																									
				$frequency[] 					= $result['frequency_1']?$result['frequency_1']:'';																																																																																																																																																																																										
				$frequency[] 					= $result['frequency_2']?$result['frequency_2']:'';																																																																																																																																																																																										
				$frequency[] 					= $result['frequency_3']?$result['frequency_3']:'';																																																																																																																																																																																										
				$frequency[] 					= $result['frequency_4']?$result['frequency_4']:'';																																																																																																																																																																																										
				$frequency[] 					= $result['frequency_5']?$result['frequency_5']:'';	
				$frequency[] 					= $result['frequency_6']?$result['frequency_6']:'';																																																																																																																																																																																										
						
			for ($i=0; $i<6; $i++) {
				$medications = array();
				if (isset($discharge_medication[$i]) && $discharge_medication[$i]!='') {
					$medications = array(
						'BabyId'		=> 	$babyid,
						'AdmissionId'	=>  $admission_id,
						'Medication'	=>  $discharge_medication[$i],
						'Dose'			=>  $dose[$i],
						'Frequency'		=>  $frequency[$i],
						'Duration'		=>  $duration[$i]
					);
					
					$medication_data = DrugIvFluidMaster::Where(['brand_name'=>$discharge_medication[$i], 'type'=>'ORAL'])->get();
					if (!isset($medication_data[0])) {
						$medication_master  =  array(
							'brand_name'	=> $discharge_medication[$i],
							'Status'		=> 'InActive',
							'DateAdded'		=> date('Y-m-d H:i:s'),
							'DateModified'	=> date('Y-m-d H:i:s')						
						);
						DrugIvFluidMaster::create($medication_master);
					}
						Medications::create($medications);					
				}
				}														
			}
		}
		echo "Success";
}
}

