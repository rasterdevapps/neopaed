<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Baby;
use App\Models\Daycare;
use Illuminate\Http\Request;
use App\Models\Mother;
use App\Models\Admission;
use Carbon\Carbon;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Models\Settings\Settings;
use App\Models\Problems;
use App\Models\Complication;
use App\Models\Delivery;
use App\Models\Usg;
use App\Models\Op;
use App\Models\NeuroEligibility;
use App\Models\Masters\DrugIvFluidMaster;
use App\Models\Medications;
use App\Http\Controllers\Registration\OpController;
use App\Models\IpNumber;
use App\Models\Nicu;
use App\Models\Nurse\SyringePumpAdmisson;
use App\Http\Controllers\Fhir\PrescriptionToMirthController;
use App\Models\Ward\BedLog;
use App\Models\Masters\Bed;
use App\Models\DeviceStatusNotification;
use App\Events\WardEvent;
use App\Models\PostnatalDischarge;
use App\Models\Neonatal;
use App\Models\NicuNewborn;
use App\Models\DaycareQuestions;
use App\Http\Controllers\Flow\FlowController;

class TranscribtionIntegrationController extends Controller
{


    public $usg_flags;
    public $user_id;
    /**
     * Initiate the required instance.
     *
     * @param $auth instance of  Illuminate\Contracts\Auth\Guard
     *
     * @return Response
     */
    public function __construct()
    {
        $this->zone = env('TIME_ZONE');
        $this->transcription_user = 7;
        $this->custom_error = new ErrorLogController();
        $this->usg_flags = 1;
        $this->user_id = '00';
    }

    public function storeTranscribedDaycareData(Request $request)
    {
        $input = $request->all();
        $uhid = $input['uhid'] ?? ($input['baby']['uhid'] ?? null);
        if (!$uhid) {
            return \Response::json(['type' => 'failure', 'message' => 'UHID is missing'], 500);
        }

        $baby_details = Baby::where('BMrNo', $uhid)->where('IsDeleted', '0')->first();
        if (!$baby_details) {
            return \Response::json(['type' => 'failure', 'message' => 'Baby details not found'], 500);
        }

        $baby_id = $baby_details->BabyId;
        $mother_id = $baby_details->MotherId;

        $admission_details = Admission::where('BabyId', $baby_id)->where('Status', 'Inpatient')->orderBy('AdmissionDate', 'desc')->first();
        if (!$admission_details) {
            return \Response::json(['type' => 'failure', 'message' => 'Admission details not found'], 500);
        }

        $admission_id = $admission_details->AdmissionId;
        $day_dtl = $input['dailyLog'] ?? [];
        $day_date = !empty($day_dtl['date']) ? date('Y-m-d', strtotime($day_dtl['date'])) : date('Y-m-d');

        $daycare_record = Daycare::where('BabyId', $baby_id)
            ->where('AdmissionId', $admission_id)
            ->where('DayDate', $day_date)
            ->where('IsDeleted', '0')
            ->first();

        $data = array();

        // Day Info
        if (isset($day_dtl['time'])) {
            $time = strtotime($day_dtl['time']);
            $data['DayTime'] = date('h', $time);
            $data['DayTime_MINS'] = date('i', $time);
            $data['DayTime_AM'] = date('A', $time);
        } else {
            $data['DayTime'] = date('h');
            $data['DayTime_MINS'] = date('i');
            $data['DayTime_AM'] = date('A');
        }
        $data['DayOfLife'] = $day_dtl['dayOfLife'] ?? null;
        $data['Care'] = $day_dtl['careType'] ?? null;
        $data['seenby'] = isset($day_dtl['seenBy']) ? (is_array($day_dtl['seenBy']) ? serialize($day_dtl['seenBy']) : $day_dtl['seenBy']) : '';
        $data['Background'] = $day_dtl['background'] ?? null;

        // Problems - stored as || delimited strings in DB
        $currentProblems = $day_dtl['problems']['current'] ?? null;
        $data['CurrentProblems'] = is_array($currentProblems) ? implode('||', $currentProblems) : $currentProblems;
        $previousProblems = $day_dtl['problems']['previous'] ?? null;
        $data['PreviousProblems'] = is_array($previousProblems) ? implode('||', $previousProblems) : $previousProblems;

        // Vitals
        $vitals = $day_dtl['vitals'] ?? $day_dtl['examination']['vitals'] ?? [];
        $data['HR'] = $vitals['hr'] ?? null;
        $data['RR'] = $vitals['rr'] ?? null;
        $data['systolic_bp'] = $vitals['bp']['systolic'] ?? ($vitals['systolicBp'] ?? null);
        $data['diastolic_bp'] = $vitals['bp']['diastolic'] ?? ($vitals['diastolicBp'] ?? null);
        $data['MeanBP'] = $vitals['bp']['mean'] ?? ($vitals['meanBP'] ?? null);
        $data['CFT'] = $vitals['crt'] ?? ($vitals['cft'] ?? null);
        $data['CentralTemperature'] = $vitals['temperature'] ?? ($vitals['centralTemperature'] ?? null);
        $data['PeripheralTemperature'] = $vitals['peripheralTemperature'] ?? null;
        $data['SaO2PostDuctal'] = $vitals['spO2'] ?? ($vitals['spo2'] ?? null);

        // Respiratory
        $respiratory = $day_dtl['respiratory'] ?? [];
        $data['ModeOfVentilation'] = $respiratory['support'] ?? null;
        $data['Ventilation_choose'] = $respiratory['ventOption'] ?? null;
        $data['fio2_set'] = $respiratory['fiO2'] ?? null;
        $data['fio2_delivered'] = $respiratory['fiO2Delivered'] ?? null;
        $data['PEEP'] = $respiratory['peep'] ?? null;
        $data['pip_set'] = $respiratory['pip'] ?? null;
        $data['pip_delivered'] = $respiratory['pipDelivered'] ?? null;
        $data['MAP'] = $respiratory['map'] ?? null;
        $data['frequency_rep'] = $respiratory['frequency'] ?? null;
        $data['i_e_ratio'] = $respiratory['ieRatio'] ?? null;
        $data['amplitude'] = $respiratory['amplitude'] ?? null;
        $data['claco'] = ($respiratory['claco'] ?? false) ? 1 : 0;
        $data['volume_targeting'] = ($respiratory['volumeTargeting'] ?? false) ? 1 : 0;
        $data['AirEntry'] = $respiratory['airEntry'] ?? null;
        $data['Retractions'] = $respiratory['retractions'] ?? null;
        $data['ChestMovement'] = $respiratory['chestMovement'] ?? null;
        $data['AddedSounds'] = $respiratory['addedSounds'] ?? null;
        $data['RSFindings'] = $respiratory['findings'] ?? null;
        $data['Surfactant_therapy_nicu'] = ($respiratory['surfactantTherapy'] ?? 'No') == 'Yes' ? 'Yes' : 'No';
        $data['surfactant_indication'] = serialize($respiratory['surfactantIndication'] ?? []);
        $data['Indication'] = serialize($respiratory['indication'] ?? []);
        $data['chronic_lung'] = ($respiratory['chronicLungDisease'] ?? 'No') == 'Yes' ? 2 : 1;
        $data['additional_res_icd'] = is_array($respiratory['additionalIcd'] ?? null) ? implode(', ', $respiratory['additionalIcd']) : ($respiratory['additionalIcd'] ?? null);

        // New Respiratory fields V2
        $data['day_of_ventilation'] = $respiratory['dayOfVentilation'] ?? null;
        $data['Spontaneouslyventilating'] = ($respiratory['spontaneouslyVentilating'] ?? false) ? 1 : 0;
        $data['EtTube'] = $respiratory['etTube'] ?? null;
        $data['Size'] = $respiratory['size'] ?? null;
        $data['Lips'] = $respiratory['lips'] ?? null;
        $data['Flow'] = $respiratory['flow'] ?? null;
        $data['IT'] = $respiratory['it'] ?? null;
        $data['AaDO2'] = $respiratory['aaDO2'] ?? null;

        // Blood Gas
        $bg = $respiratory['bloodGas'] ?? [];
        $data['Ph'] = $bg['ph'] ?? null;
        $data['PaO2'] = $bg['paO2'] ?? null;
        $data['PaCo2'] = $bg['paCo2'] ?? null;
        $data['HCO3'] = $bg['hco3'] ?? null;
        $data['BE'] = $bg['be'] ?? null;
        $data['Lactate'] = $bg['lactate'] ?? null;

        // CVS
        $cvs = $day_dtl['cvs'] ?? [];
        $data['HR'] = $cvs['hr'] ?? $data['HR']; // Override vitals HR if CVS HR provided
        $data['systolic_bp'] = $cvs['systolicBp'] ?? $data['systolic_bp'];
        $data['diastolic_bp'] = $cvs['diastolicBp'] ?? $data['diastolic_bp'];
        $data['MeanBP'] = $cvs['meanBP'] ?? $data['MeanBP'];
        $data['PeripheralPulses'] = $cvs['peripheralPulses'] ?? ($cvs['pulses'] ?? null);
        $data['CentralPulses'] = $cvs['centralPulses'] ?? null;
        $data['FemoralPulses'] = $cvs['femoralPulses'] ?? null;
        $data['PrecordialActivity'] = $cvs['precordialActivity'] ?? null;
        $data['S1S2'] = $cvs['s1s2'] ?? null;
        $data['Murmur'] = $cvs['murmur'] ?? null;
        $data['CharacterOfMurmur'] = $cvs['murmurCharacter'] ?? null;
        $data['PulsePressure'] = $cvs['pulsePressure'] ?? null;
        $data['DayEcho'] = $cvs['echo']['status'] ?? ($cvs['echo'] ?? null);
        $data['echo_status'] = $cvs['echo']['status'] ?? null;
        $data['PDA'] = $cvs['pda'] ?? null;
        $data['PDATreatment'] = $cvs['pdaTreatment'] ?? null;
        $data['pphn'] = $cvs['pah'] ?? null;
        $data['pphn_treatement'] = $cvs['pahTreatment'] ?? null;
        $data['CVSFindings'] = $cvs['findings'] ?? null;
        $data['CFT'] = $cvs['cft'] ?? $data['CFT'];
        $data['CentralTemperature'] = $cvs['centralTemperature'] ?? $data['CentralTemperature'];
        $data['PeripheralTemperature'] = $cvs['peripheralTemperature'] ?? $data['PeripheralTemperature'];
        $data['Color'] = $cvs['color'] ?? null;
        $data['additional_car_icd'] = is_array($cvs['additionalIcd'] ?? null) ? implode(', ', $cvs['additionalIcd']) : ($cvs['additionalIcd'] ?? null);

        // Inotropes
        $inotropes = $day_dtl['inotropes'] ?? $cvs['inotropes'] ?? [];
        $data['Inotropes'] = $inotropes['status'] ?? 'No';
        $data['Dopamine'] = $inotropes['dopamine'] ?? null;
        $data['Dobutamine'] = $inotropes['dobutamine'] ?? null;
        $data['Adrenaline'] = $inotropes['adrenaline'] ?? null;
        $data['Noradrenaline'] = $inotropes['noradrenaline'] ?? null;
        $data['Milrinone'] = $inotropes['milrinone'] ?? null;

        // GI
        $gi = $day_dtl['gi'] ?? [];
        $nutrition = $gi['nutrition'] ?? [];
        $data['PAFindings'] = $gi['findings'] ?? null;
        $data['Feeds'] = $nutrition['feeds'] ?? ($gi['feeds']['type'] ?? null);
        $data['TypeofFeeds'] = $nutrition['feeds'] ?? ($gi['feeds']['type'] ?? null);
        $data['Frequency'] = $nutrition['frequency'] ?? ($gi['feeds']['frequency'] ?? null);
        $data['Volume'] = $nutrition['volume'] ?? ($gi['feeds']['mlKgD'] ?? null);
        $data['FullEnteralFeeds'] = $nutrition['fullEnteralFeeds'] ?? ($gi['feeds']['fullEnteral'] ?? null);
        $data['Ivf'] = $nutrition['ivFluids'] ?? ($gi['fluids']['iv'] ?? null);
        $data['AspirateVolume'] = $gi['aspirateVolume'] ?? ($gi['aspirate']['volume'] ?? null);
        $data['AspirateNature'] = $gi['aspirateNature'] ?? ($gi['aspirate']['nature'] ?? null);
        $data['Stools'] = ($gi['stools'] ?? ($gi['stools']['passed'] ?? false)) ? 'Bowels opened' : 'Bowels not opened';
        $data['StoolNature'] = $gi['stoolNature'] ?? ($gi['stools']['nature'] ?? null);
        $data['BowelSounds'] = $gi['bowelSounds'] ?? ($gi['examination']['bowelSounds'] ?? null);
        $data['AbdominalGirth'] = $gi['girth'] ?? ($gi['examination']['girth'] ?? null);
        $data['Abdomen'] = $gi['abdomen'] ?? ($gi['examination']['abdomen'] ?? null);
        $data['Umbilicus'] = $gi['umbilicus'] ?? ($gi['examination']['umbilicus'] ?? null);
        $data['Hepatomegaly'] = $gi['liver']['status'] ?? ($gi['examination']['hMegal'] ?? null);
        $data['LiverSpan'] = $gi['liver']['span'] ?? null;
        $data['Splenomegaly'] = $gi['spleen']['status'] ?? ($gi['examination']['sMegal'] ?? null);
        $data['SpleenSpan'] = $gi['spleen']['span'] ?? null;
        $data['Herina'] = $gi['hernia'] ?? ($gi['examination']['hernia'] ?? null);
        $data['Genitalia'] = $gi['genitalia'] ?? ($gi['examination']['genitalia'] ?? null);
        $data['NEC'] = $gi['nec']['status'] ?? ($gi['nec'] ?? null);
        if (is_array($data['NEC'])) {
            $data['NEC'] = $data['NEC']['status'] ?? serialize($data['NEC']);
        }
        $data['NECtreatment'] = $gi['necTreatment'] ?? ($gi['nec']['treatment'] ?? null);
        if (is_array($data['NECtreatment'])) {
            $data['NECtreatment'] = $data['NECtreatment']['treatment'] ?? serialize($data['NECtreatment']);
        }
        $data['TSB'] = $gi['nnj']['tsb'] ?? ($gi['jaundice']['tsb'] ?? null);
        $data['NNJTreatment'] = $gi['nnj']['treatment'] ?? ($gi['jaundice']['treatment'] ?? null);
        $data['AxrFindings'] = $gi['investigations']['axr'] ?? null;
        $data['additional_gas_icd'] = is_array($gi['additionalIcd'] ?? null) ? implode(', ', $gi['additionalIcd']) : ($gi['additionalIcd'] ?? null);
        $data['Immunoglobulins'] = $gi['immunoglobulins'] ?? null;

        // CNS
        $cns = $day_dtl['cns'] ?? [];
        $data['CnsFindings'] = $cns['findings'] ?? null;
        $data['TherapeuticHypothermia'] = $cns['therapeuticHypothermia'] ?? ($cns['hypothermia'] ?? null);
        $data['AnteriorFontanelle'] = $cns['anteriorFontanelle'] ?? ($cns['fontanelle'] ?? null);
        $data['head_circumference'] = $cns['headCircumference'] ?? ($cns['ofc'] ?? null);
        $data['Activity'] = $cns['activity'] ?? null;
        $data['Tone'] = $cns['tone'] ?? null;
        $data['Cry'] = $cns['cry'] ?? null;
        $data['Seizures'] = $cns['seizures']['status'] ?? ($cns['seizures'] ?? null);
        if (is_array($data['Seizures'])) {
            $data['Seizures'] = $data['Seizures']['status'] ?? serialize($data['Seizures']);
        }
        $data['TypeOfSeizures'] = $cns['typeOfSeizures'] ?? ($cns['seizures']['type'] ?? null);
        if (is_array($data['TypeOfSeizures'])) {
            $data['TypeOfSeizures'] = $data['TypeOfSeizures']['type'] ?? serialize($data['TypeOfSeizures']);
        }
        $data['NeonatalReflexes'] = $cns['reflexes'] ?? null;
        $data['Pupils'] = $cns['pupils'] ?? null;
        $data['Cuss'] = $cns['eegCfm']['report'] ?? ($cns['neuroSonogram'] ?? ($cns['imaging']['nsReport'] ?? null));
        $data['additional_cen_icd'] = is_array($cns['additionalIcd'] ?? null) ? implode(', ', $cns['additionalIcd']) : ($cns['additionalIcd'] ?? null);

        // Renal & Metabolic
        $renal = $day_dtl['renalMetabolic'] ?? $day_dtl['renal'] ?? [];
        $data['TotalFluid'] = $renal['totalFluid'] ?? null;
        $data['PreviousWt'] = $renal['previousWeight'] ?? null;
        $data['CurrentWt'] = $renal['currentWeight'] ?? null;
        $data['WtChange'] = $renal['weightChange'] ?? null;
        $data['PercentageChange'] = $renal['percentageChange'] ?? null;
        $data['length'] = $renal['length'] ?? null;
        $data['UrineOutput'] = $renal['urineOutput'] ?? null;
        $data['UO'] = $renal['uo'] ?? null;
        $data['BloodOut'] = $renal['bloodOut'] ?? null;
        $data['DrainOutput'] = $renal['drainOutput'] ?? null;
        $data['additional_fluid_icd'] = is_array($renal['additionalIcd'] ?? null) ? implode(', ', $renal['additionalIcd']) : ($renal['additionalIcd'] ?? null);

        // Metabolic Details
        $data['RBS'] = $renal['rbs'] ?? ($day_dtl['metabolic']['rbs'] ?? null);
        $data['SerumNa'] = $renal['serumNa'] ?? ($day_dtl['metabolic']['serumNa'] ?? null);
        $data['SerumK'] = $renal['serumK'] ?? ($day_dtl['metabolic']['serumK'] ?? null);

        $abn = $day_dtl['metabolic']['abnormalities'] ?? [];
        $data['Hypoglycemia'] = ($abn['hypoglycemia'] ?? false) ? 1 : 0;
        $data['Hyperglycemia'] = ($abn['hyperglycemia'] ?? false) ? 1 : 0;
        $data['InsulinTherapy'] = ($abn['insulinTherapy'] ?? false) ? 1 : 0;
        $data['Hyponatremia'] = ($abn['hyponatremia'] ?? false) ? 1 : 0;
        $data['Hypernatremia'] = ($abn['hypernatremia'] ?? false) ? 1 : 0;
        $data['Hypokalemia'] = ($abn['hypokalemia'] ?? false) ? 1 : 0;
        $data['Hyperkalemia'] = ($abn['hyperkalemia'] ?? false) ? 1 : 0;
        $data['Hypocalcemia'] = ($abn['hypocalcemia'] ?? false) ? 1 : 0;
        $data['Hypercalcemia'] = ($abn['hypercalcemia'] ?? false) ? 1 : 0;

        // Sepsis
        $sepsis = $day_dtl['sepsis'] ?? [];
        $data['Sepsis'] = $sepsis['status'] ?? null;
        $data['CRP'] = $sepsis['crp'] ?? ($sepsis['investigations']['crp'] ?? null);
        $data['TLC'] = $sepsis['investigations']['tlc'] ?? null;
        $data['Percentage'] = $sepsis['investigations']['percentageN'] ?? null;
        $data['ANC'] = $sepsis['investigations']['anc'] ?? null;
        $data['Platelets'] = $sepsis['investigations']['platelets'] ?? null;
        $data['OtherDrugs'] = is_array($sepsis['otherDrugs'] ?? null) ? serialize($sepsis['otherDrugs']) : serialize([]);
        $data['BloodCulture'] = $sepsis['culture']['blood'] ?? null;
        $data['Organism'] = is_array($sepsis['organisms'] ?? null) ? serialize($sepsis['organisms']) : (is_array($sepsis['culture']['organism'] ?? null) ? serialize($sepsis['culture']['organism']) : serialize([]));
        $data['PositiveBlood'] = $sepsis['culture']['positiveDol'] ?? null;
        $data['Meningitis'] = $sepsis['meningitis']['status'] ?? null;
        $data['additional_spesis_icd'] = is_array($sepsis['additionalIcd'] ?? null) ? implode(', ', $sepsis['additionalIcd']) : ($sepsis['additionalIcd'] ?? null);

        // Transfusion
        $transfusion = $day_dtl['transfusion'] ?? [];
        $data['Transfusion'] = $transfusion['status'] ?? null;

        // Skin & ROP
        $data['Skin'] = $day_dtl['skin']['findings'] ?? null;
        $data['additional_skin_icd'] = is_array($day_dtl['skin']['additionalIcd'] ?? null) ? implode(', ', $day_dtl['skin']['additionalIcd']) : ($day_dtl['skin']['additionalIcd'] ?? null);
        $data['Rop'] = $day_dtl['rop']['findings'] ?? null;
        $data['additional_rop_icd'] = is_array($day_dtl['rop']['additionalIcd'] ?? null) ? implode(', ', $day_dtl['rop']['additionalIcd']) : ($day_dtl['rop']['additionalIcd'] ?? null);
        $data['Plan'] = $day_dtl['plan'] ?? null;
        $data['Notes'] = $day_dtl['notes'] ?? null;

        // Invasive Lines V2
        $lines = $day_dtl['invasiveLines'] ?? [];
        if (!empty($lines)) {
            $data['pvc_number'] = $lines['pvc']['number'] ?? null;
            $data['PvcSites'] = $lines['pvc']['site'] ?? null;
            $data['PvcDay'] = $lines['pvc']['day'] ?? null;
            $data['DayChange'] = ($lines['pvc']['dayChange'] ?? false) ? 'Yes' : 'No';
            $data['PvcComplication'] = $lines['pvc']['complication'] ?? null;

            $data['PiccSite'] = $lines['picc']['site'] ?? null;
            $data['PiccDay'] = $lines['picc']['day'] ?? null;
            $data['PiccComplication'] = $lines['picc']['complication'] ?? null;

            $data['UvcPosition'] = $lines['uvc']['position'] ?? null;
            $data['UvcDay'] = $lines['uvc']['day'] ?? null;
            $data['UvcComplication'] = $lines['uvc']['complication'] ?? null;

            $data['UacPosition'] = $lines['uac']['position'] ?? null;
            $data['UacDay'] = $lines['uac']['day'] ?? null;
            $data['UacComplication'] = $lines['uac']['complication'] ?? null;

            $data['PacSite'] = $lines['pac']['site'] ?? null;
            $data['PacDay'] = $lines['pac']['day'] ?? null;
            $data['PacComplication'] = $lines['pac']['complication'] ?? null;
        }

        // ICD Array JSON
        $nicu_icd = [
            'ResICD' => $respiratory['icd'] ?? $respiratory['additionalIcd'] ?? [],
            'CarICD' => $cvs['icd'] ?? $cvs['additionalIcd'] ?? [],
            'GasICD' => $gi['icd'] ?? $gi['additionalIcd'] ?? [],
            'CenICD' => $cns['icd'] ?? $cns['additionalIcd'] ?? [],
            'FluidICD' => $renal['icd'] ?? $renal['additionalIcd'] ?? [],
            'SepsisICD' => $sepsis['icd'] ?? $sepsis['additionalIcd'] ?? [],
            'SkinICD' => $day_dtl['skin']['icd'] ?? $day_dtl['skin']['additionalIcd'] ?? [],
            'RopICD' => $day_dtl['rop']['icd'] ?? $day_dtl['rop']['additionalIcd'] ?? []
        ];
        $data['NicuICD'] = json_encode($nicu_icd);

        // Core fields
        if ($daycare_record) {
            $data['DateModified'] = Carbon::now($this->zone);
            $data['UserModified'] = $this->transcription_user;
            $daycare_record->update($data);
            $dayId = $daycare_record->DayId;
        } else {
            $data['BabyId'] = $baby_id;
            $data['MotherId'] = $mother_id;
            $data['AdmissionId'] = $admission_id;
            $data['DayDate'] = $day_date;
            $data['DateAdded'] = Carbon::now($this->zone);
            $data['UserAdded'] = $this->transcription_user;
            $day_name_count = Daycare::where(['BabyId' => $baby_id, 'AdmissionId' => $admission_id, 'IsDeleted' => 0])->count();
            $data['day_name'] = 'Day ' . ($day_name_count + 1);
            $daycare_record = Daycare::create($data);
            $dayId = $daycare_record->DayId;
        }

        if ($dayId) {
            // DaycareQuestions
            $q = $day_dtl['questions'] ?? [];
            $questions_data = array(
                'DayId' => $dayId,
                'BabyId' => $baby_id,
                'AdmissionId' => $admission_id,
                'UserAdded' => $this->transcription_user,
                'DateAdded' => Carbon::now($this->zone),
                'respiratory_problem' => is_array($day_dtl['problems']['respiratory'] ?? null) ? implode(', ', $day_dtl['problems']['respiratory']) : ($day_dtl['respiratory_problem'] ?? ($day_dtl['problems']['respiratory'] ?? '')),
                'Cardiovascular_problem' => is_array($day_dtl['problems']['cardiovascular'] ?? null) ? implode(', ', $day_dtl['problems']['cardiovascular']) : ($day_dtl['Cardiovascular_problem'] ?? ($day_dtl['problems']['cardiovascular'] ?? '')),
                'central_problem' => is_array($day_dtl['problems']['central'] ?? null) ? implode(', ', $day_dtl['problems']['central']) : ($day_dtl['central_problem'] ?? ($day_dtl['problems']['central'] ?? '')),
                'gastrointestinal_problem' => is_array($day_dtl['problems']['gi'] ?? null) ? implode(', ', $day_dtl['problems']['gi']) : ($day_dtl['gastrointestinal_problem'] ?? ($day_dtl['problems']['gi'] ?? '')),
                'directlybreastfeed' => ($nutrition['feeds'] == 'Breastfeeding' || ($gi['feeds']['breastfeeding'] ?? false)) ? 1 : 0,
                'othertypefeed' => ($nutrition['feeds'] != 'Breastfeeding' || ($gi['feeds']['otherType'] ?? false)) ? 1 : 0,
                'workingWeight' => $nutrition['workingWeight'] ?? ($gi['workingWeight'] ?? 0),
                'iv_fluids' => $nutrition['ivFluids'] ?? ($gi['fluids']['iv'] ?? ''),
                'iv_fluids_ml_day' => $nutrition['ivFluidsMlDay'] ?? ($gi['fluids']['ivMlDay'] ?? 0),
                'Protein' => $nutrition['protein'] ?? ($gi['fluids']['protein'] ?? 0),
                'Fat' => $nutrition['fat'] ?? ($gi['fluids']['fat'] ?? 0),
                'Carbohydrates' => $nutrition['carbohydrates'] ?? ($gi['fluids']['carbohydrates'] ?? 0),
                'total_energy' => $nutrition['totalEnergy'] ?? ($gi['fluids']['totalEnergy'] ?? 0),
                'drug_infusions' => $nutrition['drugInfusions'] ?? ($gi['fluids']['drugInfusions'] ?? 0),
                'drug_infusions_ml_day' => $nutrition['drugInfusionsMlDay'] ?? ($gi['fluids']['drugInfusionsMlDay'] ?? 0),
                'sedation_paralysis' => ($cns['sedationParalysis'] ?? 'No') == 'Yes' ? 1 : 0,
                'Pupils' => $cns['pupils'] ?? '',
                'urine_output_day' => $renal['urineOutput24h'] ?? ($renal['urineOutput'] ?? 0),
                'neuro_sonogram' => is_array($cns['neuroSonogram'] ?? ($cns['imaging']['ns'] ?? null)) ? serialize($cns['neuroSonogram'] ?? $cns['imaging']['ns']) : ($cns['neuroSonogram'] ?? ($cns['imaging']['ns'] ?? '')),
                'gir' => $renal['gir'] ?? ($abn['gir'] ?? 0),
                'needlethoracentesis' => ($day_dtl['needleThoracentesis'] ?? 'No') == 'Yes' ? 2 : 1,
                'intercostaldrain' => ($day_dtl['intercostalDrain'] ?? 'No') == 'Yes' ? 2 : 1,
                'ultrasoundabdominal' => ($gi['investigations']['ultrasound'] ?? 'No') != 'No' ? 2 : 1,
                'ultrasoundkeyfindings' => $gi['investigations']['ultrasoundFindings'] ?? '',
                'renalultrasound' => ($renal['investigations']['ultrasound'] ?? ($renal['ultrasound'] ?? 'No')) != 'No' ? 2 : 1,
                'renalultrasoundkeyfindings' => $renal['investigations']['ultrasoundFindings'] ?? ($renal['ultrasoundFindings'] ?? ''),
                'mrict_brain_status' => ($cns['imaging']['mriCtStatus'] ?? 'No') != 'No' ? 2 : 1,
                'mri_ct_brain' => $cns['mriCtBrain'] ?? ($cns['imaging']['mriCtFindings'] ?? ''),
                'viral_meningitis' => ($sepsis['viralMeningitis'] ?? ($sepsis['meningitis']['viral'] ?? 'No')) == 'Yes' ? 2 : 1,
                'lumbar_puncture' => $sepsis['lumbarPuncture'] ?? ($sepsis['meningitis']['lumbarPuncture'] ?? ''),
                'ultrasound_spine' => ($cns['ultrasoundSpine'] ?? ($cns['imaging']['usSpine'] ?? 'No')) != 'No' ? 2 : 1,
                'ultrasound_spine_report' => $cns['ultrasoundSpineReport'] ?? ($cns['imaging']['usSpineReport'] ?? ''),
                'eeg_cfm' => ($cns['eegCfm']['status'] ?? ($cns['imaging']['eegCfm'] ?? 'No')) != 'No' ? 2 : 1,
                'eeg_cfm_report' => $cns['eegCfm']['report'] ?? ($cns['imaging']['eegCfmReport'] ?? ''),
                'dilution_exchange' => ($renal['dilutionExchange'] ?? ($abn['dilutionExchange'] ?? false)) ? 2 : 1,
            );
            $exists = \DB::table('daycare_questions')->where('DayId', $dayId)->count();
            if ($exists > 0) {
                \DB::table('daycare_questions')->where('DayId', $dayId)->update($questions_data);
            } else {
                \DB::table('daycare_questions')->insert($questions_data);
            }

            // Antibiotics
            \App\Models\Antibiotic::where('DayId', $dayId)->delete();
            foreach ($input['antibiotics'] ?? ($sepsis['antibiotics'] ?? []) as $ab) {
                \App\Models\Antibiotic::create([
                    'Antibiotic' => $ab['antibiotic'] ?? ($ab['drugId'] ?? null),
                    'Day' => $ab['day'] ?? ($ab['dose'] ?? null), // Warning: mapping mismatch in original code maybe?
                    'DayId' => $dayId,
                    'BabyId' => $baby_id,
                    'AdmissionId' => $admission_id
                ]);
            }

            // Transfusion Fluids
            \App\Models\Fluid::where('DayId', $dayId)->delete();
            foreach ($input['transfusions'] ?? ($transfusion['products'] ?? []) as $fl) {
                \App\Models\Fluid::create([
                    'Product' => $fl['product'],
                    'Volume' => $fl['volume'],
                    'DayId' => $dayId,
                    'BabyId' => $baby_id,
                    'AdmissionId' => $admission_id
                ]);
            }
        }
        \SiteHelpers::updateDashboardAtFormUpdation($baby_id, 'Daycare Sheet');

        return \Response::json(['type' => 'success', 'message' => 'Daycare details updated'], 200);
    }


    private function mapNeonatalInput($input)
    {
        if (empty($input))
            return [];
        $mapped = [];

        // Support for flat payload structure as fallback/primary
        $maternal_source = $input['maternal'] ?? $input;
        $delivery_source = $input['delivery'] ?? $input;
        $birth_source = $input['birthDetails'] ?? $input;

        // Maternal
        $mapped['consanguinity'] = $maternal_source['consanguinity'] ?? ($input['consanguinity'] ?? null);
        $mapped['LMP'] = $maternal_source['lmp'] ?? ($input['lmp'] ?? ($input['LMP'] ?? null));
        $mapped['EDDByUSG'] = $maternal_source['edd']['byUsg'] ?? ($input['EDDByUSG'] ?? null);
        $mapped['EDDByDate'] = $maternal_source['edd']['byDate'] ?? ($input['EDDByDate'] ?? null);

        $h = $maternal_source['history'] ?? $input;
        $mapped['booked'] = $h['booked'] ?? ($input['booked'] ?? null);
        $mapped['bookedPlace'] = $h['bookedPlace'] ?? ($input['bookedPlace'] ?? null);
        $mapped['supervised'] = $h['supervised'] ?? ($input['supervised'] ?? null);
        $mapped['pleaceOfSupervision'] = $h['placeOfSupervision'] ?? ($input['pleaceOfSupervision'] ?? null);
        $mapped['antenatalSteroids'] = $h['antenatalSteroids'] ?? ($input['antenatalSteroids'] ?? null);
        $mapped['typeOfSteriods'] = $h['steroidType'] ?? ($input['typeOfSteriods'] ?? null);
        $mapped['lastDoseDeliveryInterval'] = $h['lastDoseInterval'] ?? ($input['lastDoseDeliveryInterval'] ?? null);
        $mapped['steroidCourse'] = $h['steroidCourse'] ?? ($input['steroidCourse'] ?? null);
        $mapped['antenatalMgSO4ForNeuroprotection'] = $h['antenatalMgso4'] ?? ($input['antenatalMgSO4ForNeuroprotection'] ?? null);
        $mapped['thyroidStatus'] = $h['thyroidStatus'] ?? ($input['thyroidStatus'] ?? null);
        $mapped['HIV'] = $h['hiv'] ?? ($input['HIV'] ?? null);
        $mapped['HepatitisB'] = $h['hepatitisB'] ?? ($input['HepatitisB'] ?? null);
        $mapped['VDRL'] = $h['vdrl'] ?? ($input['VDRL'] ?? null);
        $mapped['maternalPyrexia'] = $h['pyrexia'] ?? ($input['maternalPyrexia'] ?? null);
        $mapped['maternalPyrexiaTemperatureFahrenheit'] = $h['pyrexiaFahrenheit'] ?? ($input['maternalPyrexiaTemperatureFahrenheit'] ?? null);
        $mapped['maternalAntibiotics'] = $h['antibiotics'] ?? ($input['maternalAntibiotics'] ?? ($input['Maternal_antibiotics_status'] ?? null));
        $mapped['maternalAntibioticsDetails'] = $h['antibioticsDetails'] ?? ($input['maternalAntibioticsDetails'] ?? []);
        $mapped['timeOfLastDose'] = $h['timeOfLastDose'] ?? ($input['timeOfLastDose'] ?? null);
        $mapped['medicalProblem'] = $h['medicalProblems'] ?? ($input['medicalProblem'] ?? []);
        $mapped['hbAg'] = $h['hbAg'] ?? ($input['hbAg'] ?? null);

        $mapped['pregnancyComplications'] = $maternal_source['pregnancyComplications'] ?? ($input['pregnancyComplications'] ?? []);
        $mapped['pregnancyComplicationsDetails'] = $maternal_source['pregnancyComplicationsDetails'] ?? ($input['pregnancyComplicationsDetails'] ?? []);

        // Conception & ART
        $mapped['conception'] = $maternal_source['conception'] ?? ($input['conception'] ?? null);
        $mapped['artType'] = $maternal_source['artType'] ?? ($input['artType'] ?? null);
        $mapped['embryoTransfer'] = $maternal_source['embryoTransfer'] ?? ($input['embryoTransfer'] ?? null);
        $mapped['artPlace'] = $maternal_source['artPlace'] ?? ($input['artPlace'] ?? null);
        $mapped['multiplePregnancy'] = $maternal_source['multiplePregnancy'] ?? ($input['multiplePregnancy'] ?? null);

        // Scans
        $mapped['datingScanDetails'] = $maternal_source['datingScan'] ?? ($input['datingScanDetails'] ?? null);
        $mapped['anomalyScanDetails'] = $maternal_source['anomalyScan'] ?? ($input['anomalyScanDetails'] ?? null);
        $mapped['otherScanDetails'] = $maternal_source['otherScan'] ?? ($input['otherScanDetails'] ?? []);
        $mapped['dopplerScanDetails'] = $maternal_source['dopplerScan'] ?? ($input['dopplerScanDetails'] ?? []);

        // Labour
        $l = $maternal_source['labour'] ?? $input;
        $mapped['labour'] = $l['status'] ?? ($input['labour'] ?? ($input['Labour'] ?? null));
        $mapped['natureofLabour'] = $l['nature'] ?? ($input['natureofLabour'] ?? null);
        $mapped['Syntocinon'] = $l['syntocinon'] ?? ($input['Syntocinon'] ?? null);
        $mapped['riskFactorsForSepsisInMothers'] = $l['riskFactorsForSepsis'] ?? ($input['riskFactorsForSepsisInMothers'] ?? null);
        $mapped['riskFactors'] = $l['riskFactorDetails'] ?? ($input['riskFactors'] ?? []);

        // Delivery
        $mapped['modeOfDelivery'] = $delivery_source['mode'] ?? ($input['modeOfDelivery'] ?? null);
        $mapped['indication'] = $delivery_source['indication'] ?? ($input['indication'] ?? []);
        $mapped['presentation'] = $delivery_source['presentation'] ?? ($input['presentation'] ?? null);
        $mapped['fetalDistress'] = $delivery_source['fetalDistress'] ?? ($input['fetalDistress'] ?? null);
        $mapped['CTG'] = $delivery_source['ctg'] ?? ($input['CTG'] ?? null);
        $mapped['CTGDetails'] = $delivery_source['ctgDetails'] ?? ($input['CTGDetails'] ?? null);
        $mapped['typeOfAnesthesia'] = $delivery_source['anesthesiaType'] ?? ($input['typeofAnesthesia'] ?? null);
        $mapped['gastricAspirate'] = $delivery_source['gastricAspirate'] ?? ($input['gastricAspirate'] ?? null);
        $mapped['delayedCordClamping'] = $delivery_source['delayedCordClamping'] ?? ($input['delayedCordClamping'] ?? null);
        $mapped['reasonForNoDCC'] = $delivery_source['noDccReason'] ?? ($input['reasonForNoDCC'] ?? null);
        $mapped['delayedCordClampingduration'] = $delivery_source['dccDuration'] ?? ($input['delayedCordClampingduration'] ?? null);
        $mapped['umbilicalCordMilking'] = $delivery_source['umbilicalCordMilking'] ?? ($input['umbilicalCordMilking'] ?? null);
        $mapped['cutCordMilking'] = $delivery_source['cutCordMilking'] ?? ($input['cutCordMilking'] ?? null);

        // Cord Blood
        $cb = $delivery_source['cordBlood'] ?? $input;
        $mapped['cordBloodGas'] = $cb['status'] ?? ($input['cordBloodGas'] ?? null);
        $mapped['cordPH'] = $cb['ph'] ?? ($input['cordPH'] ?? null);
        $mapped['cordHCO3'] = $cb['hco3'] ?? ($input['cordHCO3'] ?? null);
        $mapped['cordBE'] = $cb['be'] ?? ($input['cordBE'] ?? null);

        $mapped['commentOnLiquor'] = $delivery_source['liquor']['status'] ?? ($input['commentOnLiquor'] ?? null);
        $mapped['PROM'] = $delivery_source['liquor']['prom'] ?? ($input['PROM'] ?? null);
        $mapped['durationOfPROM'] = $delivery_source['liquor']['romDuration'] ?? ($input['durationOfPROM'] ?? null);

        // Birth Details & Apgar
        $mapped['uhid'] = $input['uhid'] ?? (($input['baby']['uhid'] ?? null) ?? ($birth_source['uhid'] ?? null));
        $mapped['dateTime'] = $birth_source['dateTime'] ?? ($input['dateTime'] ?? (($input['dob'] ?? null) ? ($input['dob'] . ' ' . ($input['tob'] ?? date('H:i:s'))) : date('Y-m-d H:i:s')));
        $mapped['birthLength'] = $birth_source['length'] ?? ($input['birthLength'] ?? ($input['length'] ?? ($input['baby']['length'] ?? null)));
        $mapped['birthHeadCircunference'] = $birth_source['ofc'] ?? ($input['birthHeadCircunference'] ?? ($input['ofc'] ?? ($input['baby']['ofc'] ?? null)));

        // Extract time components for AdmissionTime logic
        $ts = strtotime($mapped['dateTime']);
        $mapped['TEST_TIME'] = date('h', $ts);
        $mapped['TEST_MINS'] = date('i', $ts);
        $mapped['TEST_AM'] = date('A', $ts);

        // Apgar
        $ap = $birth_source['apgar'] ?? ($input['apgar'] ?? []);
        if (isset($ap['status'])) {
            $mapped['known_field'] = ($ap['status'] == 'Yes' || $ap['status'] == 'known') ? 2 : 1;
        }

        $ap_matrix = $ap['matrix'] ?? $ap; // support flat minutes or nested matrix
        foreach (['1', '5', '10', '15', '20'] as $min) {
            $m_key = 'min' . $min;
            $minute_key = 'minute' . $min;
            $mx = $ap_matrix[$m_key] ?? ($ap_matrix[$minute_key] ?? null);
            if ($mx) {
                $mapped['Colour' . $min] = $mx['colour'] ?? ($mx['color'] ?? null);
                $mapped['HR' . $min] = $mx['hr'] ?? ($mx['heartRate'] ?? null);
                $mapped['Reflex' . $min] = $mx['reflex'] ?? null;
                $mapped['Tone' . $min] = $mx['tone'] ?? null;
                $mapped['Respiration' . $min] = $mx['respiration'] ?? null;
                $mapped['Apgars' . $min . 'min'] = $mx['total'] ?? null;
            }
        }

        if (isset($birth_source['vitaminK']) || isset($input['vitaminK'])) {
            $vk = $birth_source['vitaminK'] ?? $input;
            $mapped['vitaminK'] = $vk['status'] ?? ($input['vitaminK'] ?? null);
            $mapped['vitaminKDose'] = $vk['dose'] ?? ($input['vitaminKDose'] ?? null);
            $mapped['vitaminKRoute'] = $vk['route'] ?? ($input['vitaminKRoute'] ?? null);
        }

        // Resuscitation
        $resus = $birth_source['resuscitation'] ?? $input;
        $mapped['resuscitation'] = $resus['required'] ?? ($input['resuscitation'] ?? null);
        $rd = $resus['details'] ?? $input;
        $mapped['facialOxygen'] = $rd['facialOxygen'] ?? ($input['facialOxygen'] ?? null);
        $mapped['durationOfFacialOxygen'] = $rd['facialOxygenDuration'] ?? ($input['durationOfFacialOxygen'] ?? null);
        $mapped['maximumFio2Rquired'] = $rd['maxFio2'] ?? ($input['maximumFio2Rquired'] ?? null);
        $mapped['initialSteps'] = $rd['initialSteps'] ?? ($input['initialSteps'] ?? null);
        $mapped['timeOf1stGasp'] = $rd['firstGaspKnown'] ?? ($input['timeOf1stGasp'] ?? null);
        $mapped['timeOf1stGaspInMinutes'] = $rd['firstGaspMin'] ?? ($input['timeOf1stGaspInMinutes'] ?? null);
        $mapped['regularRespiration'] = $rd['regularRespirationKnown'] ?? ($input['regularRespiration'] ?? null);
        $mapped['regularRespirationMinutes'] = $rd['regularRespirationMin'] ?? ($input['regularRespirationMinutes'] ?? null);
        $mapped['deliveryRoomCPAP'] = $rd['deliveryRoomCpap'] ?? ($input['deliveryRoomCPAP'] ?? null);
        $mapped['bagMaskVentilation'] = $rd['bagMaskVentilation'] ?? ($input['bagMaskVentilation'] ?? null);
        $mapped['bagMaskVentilationDuration'] = $rd['bmvDurationKnown'] ?? ($input['bagMaskVentilationDuration'] ?? null);
        $mapped['bagMaskVentilationDurationMin'] = $rd['bmvMin'] ?? ($input['bagMaskVentilationDurationMin'] ?? null);
        $mapped['intubation'] = $rd['intubation'] ?? ($input['intubation'] ?? null);
        $mapped['ETTSizeInMM'] = $rd['ettSize'] ?? ($input['ETTSizeInMM'] ?? null);
        $mapped['depthOfInsertion'] = $rd['depthInsertionKnown'] ?? ($input['depthOfInsertion'] ?? null);
        $mapped['depthOfInsertionLengthInCM'] = $rd['depthInsertionCm'] ?? ($input['depthOfInsertionLengthInCM'] ?? null);
        $mapped['PPV'] = $rd['ppv'] ?? ($input['PPV'] ?? null);
        $mapped['durationOfPTV'] = $rd['ppvDurationMin'] ?? ($input['durationOfPTV'] ?? null);
        $mapped['CPR'] = $rd['cpr'] ?? ($input['CPR'] ?? null);
        $mapped['durationOfCPR'] = $rd['cprDurationMin'] ?? ($input['durationOfCPR'] ?? null);
        $mapped['drugs'] = $rd['drugsAdministered'] ?? ($input['drugs'] ?? null);
        $mapped['drugDetails'] = $rd['resuscitationDrugs'] ?? ($input['drugDetails'] ?? []);
        $mapped['OtherInformation'] = $rd['resuscitationDetails'] ?? ($input['OtherInformation'] ?? null);

        // Essential Details
        $ed = $input['essentialDetails'] ?? $input;
        $mapped['initialExaminationSummary'] = $ed['initialExaminationSummary'] ?? ($input['initialExaminationSummary'] ?? null);
        $mapped['malformation'] = $ed['malformation'] ?? ($input['malformation'] ?? null);
        $mapped['malformationType'] = $ed['malformationType'] ?? ($input['malformationType'] ?? null);
        $mapped['ICT'] = $ed['ict'] ?? ($input['ICT'] ?? null);
        $mapped['DCT'] = $ed['dct'] ?? ($input['DCT'] ?? null);
        $mapped['backgroundDetails'] = $ed['background'] ?? ($input['backgroundDetails'] ?? null);
        $mapped['plan'] = $ed['plan'] ?? ($input['plan'] ?? null);
        $mapped['transferStatus'] = $ed['transferStatus'] ?? ($input['transferStatus'] ?? null);

        // Examination
        $e = $input['examination'] ?? $input;
        // General
        $eg = $e['general'] ?? $input;
        $mapped['Pallor'] = $eg['pallor'] ?? ($input['Pallor'] ?? null);
        $mapped['Jaundice'] = $eg['jaundice'] ?? ($input['Jaundice'] ?? null);
        $mapped['Cyanosis'] = $eg['cyanosis'] ?? ($input['Cyanosis'] ?? null);
        $mapped['Edema'] = $eg['edema'] ?? ($input['Edema'] ?? null);
        $mapped['Skin'] = $eg['skin'] ?? ($input['Skin'] ?? null);
        $mapped['Temperature'] = $eg['temperature'] ?? ($input['Temperature'] ?? null);

        // Vitals
        $ev = $e['vitals'] ?? $input;
        $mapped['NbHR'] = $ev['hr'] ?? ($input['NbHR'] ?? null);
        $mapped['NbRR'] = $ev['rr'] ?? ($input['NbRR'] ?? null);
        $mapped['NbSpO2'] = $ev['spo2'] ?? ($input['NbSpO2'] ?? null);
        $mapped['NbCFT'] = $ev['cft'] ?? ($input['NbCFT'] ?? null);
        $mapped['BP'] = $ev['bp'] ?? ($input['BP'] ?? null);

        // Respiratory
        $er = $e['respiratory'] ?? $input;
        $mapped['AirEntry'] = $er['airEntry'] ?? ($input['AirEntry'] ?? null);
        $mapped['Retractions'] = $er['retractions'] ?? ($input['Retractions'] ?? null);
        $mapped['NbChestMovement'] = $er['chestMovement'] ?? ($input['NbChestMovement'] ?? null);
        $mapped['AddedSounds'] = $er['sounds'] ?? ($input['AddedSounds'] ?? null);

        // Cardiovascular
        $ec = $e['cardiovascular'] ?? $input;
        $mapped['S1S2'] = $ec['heartSounds'] ?? ($input['S1S2'] ?? null);
        $mapped['Murmur'] = $ec['murmur'] ?? ($input['Murmur'] ?? null);
        $mapped['FemoralPulses'] = $ec['femoralPulses'] ?? ($input['FemoralPulses'] ?? null);
        $mapped['PeripheralPulses'] = $ec['peripheralPulses'] ?? ($input['PeripheralPulses'] ?? null);

        // Abdomen
        $ea = $e['abdomen'] ?? $input;
        $mapped['AbdomenShape'] = $ea['shape'] ?? ($input['AbdomenShape'] ?? null);
        $mapped['LiverSpan'] = $ea['liver'] ?? ($input['LiverSpan'] ?? null);
        $mapped['Splenomegaly'] = $ea['spleen'] ?? ($input['Splenomegaly'] ?? null);
        $mapped['Umbilicus'] = $ea['umbilicus'] ?? ($input['Umbilicus'] ?? null);

        // CNS
        $en = $e['cns'] ?? $input;
        $mapped['NbTone'] = $en['tone'] ?? ($input['NbTone'] ?? null);
        $mapped['SpontaneousActivity'] = $en['activity'] ?? ($input['SpontaneousActivity'] ?? null);
        $mapped['AnteriorFontanelle'] = $en['fontanelle'] ?? ($input['AnteriorFontanelle'] ?? null);
        $mapped['NeonatalReflexes'] = $en['reflexes'] ?? ($input['NeonatalReflexes'] ?? null);

        // Features
        $ef = $e['features'] ?? $input;
        $mapped['Head'] = $ef['head'] ?? ($input['Head'] ?? null);
        $mapped['Eyes'] = $ef['eyes'] ?? ($input['Eyes'] ?? null);
        $mapped['Ears'] = $ef['ears'] ?? ($input['Ears'] ?? null);
        $mapped['Mouth'] = $ef['mouth'] ?? ($input['Mouth'] ?? null);
        $mapped['Neck'] = $ef['neck'] ?? ($input['Neck'] ?? null);
        $mapped['Spine'] = $ef['spine'] ?? ($input['Spine'] ?? null);
        $mapped['Hips'] = $ef['hips'] ?? ($input['Hips'] ?? null);
        $mapped['Genitalia'] = $ef['genitalia'] ?? ($input['Genitalia'] ?? null);
        $mapped['Anus'] = $ef['anus'] ?? ($input['Anus'] ?? null);

        // Baby Details (Parent level)
        $mapped['baby'] = $input['baby'] ?? [];
        $mapped['mother'] = $input['mother'] ?? [];
        if (isset($input['baby'])) {
            $mapped['birthOrder'] = $input['baby']['birthOrder'] ?? ($input['birthOrder'] ?? null);
            $mapped['babyName'] = $input['baby']['name'] ?? ($input['babyName'] ?? null);
            $mapped['dob'] = $input['baby']['dob'] ?? ($input['dob'] ?? null);
            $mapped['sex'] = $input['baby']['sex'] ?? ($input['sex'] ?? null);
        }

        return array_merge($input, $mapped);
    }

    // public function storeTranscribedNeonatalProformaData(Request $request)
    // {
    //     $input = $request->all();
    //     $input = $this->mapNeonatalInput($input);
    //     $baby_details = $this->createUpdateBabyDetails($input);
    //     if ($this->createUpdateNeonatalProforma($input, $baby_details)) {
    //         return \Response::json(['type' => 'success', 'message' => 'Neonatal Proforma details updated'], 200);
    //     } else {
    //         return \Response::json(['type' => 'success', 'message' => 'error while store the neonatal proforma details'], 500);
    //     }

    // }
    public function createUpdateNeonatalProforma($input, $baby_data)
    {

        $input['Consanguinity'] = (isset($input['consanguinity']) && !empty($input['consanguinity'])) ? $input['consanguinity'] : null;

        Problems::where('BabyId', '=', $baby_data->BabyId)->delete();
        if (isset($input['medicalProblem'])) {
            $pbm_length = sizeof($input['medicalProblem']);
            for ($i = 0; $i < $pbm_length; $i++) {
                if ($input['medicalProblem'][$i] != '' && $input['medicalProblem'][$i] != 0) {
                    $pbms = array(
                        'Problem' => $input['medicalProblem'][$i]["problem"] ?? null,
                        'Medication' => $input['medicalProblem'][$i]["medication"] ?? null,
                        'MotherId' => $baby_data->MotherId,
                        'BabyId' => $baby_data->BabyId
                    );
                    if ($pbms['Problem']) {
                        Problems::create($pbms);
                    }
                }
            }
        }

        Delivery::where('MotherId', '=', $baby_data->MotherId)->delete();
        if (isset($input['liveBirthBabyDetails'])) {
            $delivery_length = sizeof($input['liveBirthBabyDetails']);
            for ($i = 0; $i < $delivery_length; $i++) {
                if (empty($input['liveBirthBabyDetails'][$i]))
                    continue;
                $deli_data = array(
                    'Year' => $input['liveBirthBabyDetails'][$i]["birthYear"] ?? null,
                    'Place' => $input['liveBirthBabyDetails'][$i]["place"] ?? null,
                    'Delivery' => $input['liveBirthBabyDetails'][$i]["typeOfDelivery"] ?? null,
                    'Complications' => $input['liveBirthBabyDetails'][$i]["complications"] ?? null,
                    'Gender' => $input['liveBirthBabyDetails'][$i]["gender"] ?? null,
                    'GA' => $input['liveBirthBabyDetails'][$i]["gestation"] ?? null,
                    'BW' => $input['liveBirthBabyDetails'][$i]["birthWeight"] ?? null,
                    'Health' => $input['liveBirthBabyDetails'][$i]["health"] ?? null,
                    'MotherId' => $baby_data->MotherId,
                    'details' => $input['liveBirthBabyDetails'][$i]["details"] ?? null
                );
                Delivery::create($deli_data);
            }
        }

        $proforma = [];
        $proforma['Consanguinity'] = (isset($input['consanguinity']) && !empty($input['consanguinity'])) ? $input['consanguinity'] : null;
        // Fix for undefined index 'dateTime'
        $dateTime = isset($input['dateTime']) ? $input['dateTime'] : (isset($input['birthDetails']['dateTime']) ? $input['birthDetails']['dateTime'] : date('Y-m-d H:i:s'));
        $proforma['TestDate'] = date('Y-m-d', strtotime($dateTime));
        $proforma['LMP'] = (!empty($input['LMP'])) ? date('Y-m-d', strtotime($input['LMP'])) : null;
        $proforma['EDDbyUSG'] = (!empty($input['EDDByUSG'])) ? date('Y-m-d', strtotime($input['EDDByUSG'])) : null;
        $proforma['EDDbyDates'] = (!empty($input['EDDByDate'])) ? date('Y-m-d', strtotime($input['EDDByDate'])) : null;
        $proforma['HIV'] = (isset($input['HIV']) && !empty($input['HIV'])) ? $input['HIV'] : null;
        $proforma['HepatitisB'] = (isset($input['HepatitisB']) && !empty($input['HepatitisB'])) ? $input['HepatitisB'] : null;
        $proforma['VDRL'] = (isset($input['VDRL']) && !empty($input['VDRL'])) ? $input['VDRL'] : null;
        $proforma['Booked'] = (isset($input['booked']) && !empty($input['booked'])) ? $input['booked'] : null;
        $proforma['Booking'] = (isset($input['bookedPlace']) && !empty($input['bookedPlace'])) ? $input['bookedPlace'] : null;
        $proforma['Supervised'] = (isset($input['supervised']) && !empty($input['supervised'])) ? $input['supervised'] : null;
        $proforma['PlaceofSupervision'] = (isset($input['pleaceOfSupervision']) && !empty($input['pleaceOfSupervision'])) ? $input['pleaceOfSupervision'] : null;
        $proforma['Supervised'] = (isset($input['supervised']) && !empty($input['supervised'])) ? $input['supervised'] : null;
        $proforma['adjustedtrisomies'] = (isset($input['adjustedRiskForTrisomiesAvailable']) && $input['adjustedRiskForTrisomiesAvailable'] == 'Yes') ? 2 : 1;
        $proforma['AdjustedRiskForTrisomy21'] = (isset($input['adjustedRiskForTrisomy21']) && !empty($input['adjustedRiskForTrisomy21'])) ? $input['adjustedRiskForTrisomy21'] : null;
        $proforma['AdjustedRiskForTrisomy18'] = (isset($input['adjustedRiskForTrisomy18']) && !empty($input['adjustedRiskForTrisomy18'])) ? $input['adjustedRiskForTrisomy18'] : null;
        $proforma['AdjustedRiskForTrisomy13'] = (isset($input['adjustedRiskForTrisomy13']) && !empty($input['adjustedRiskForTrisomy13'])) ? $input['adjustedRiskForTrisomy13'] : null;
        $proforma['otherInvestigations'] = (isset($input['otherInvestigations']) && !empty($input['otherInvestigations'])) ? $input['otherInvestigations'] : null;
        $proforma['pregnancyComplications'] = (isset($input['pregnancyComplications']) && !empty($input['pregnancyComplications'])) ? $input['pregnancyComplications'] : null;
        $proforma['pregnancyComplications'] = (isset($input['pregnancyComplications']) && !empty($input['pregnancyComplications'])) ? $input['pregnancyComplications'] : null;

        Complication::where('BabyId', '=', $baby_data->BabyId)->delete();
        if (isset($input['pregnancyComplicationsDetails']) && is_array($input['pregnancyComplicationsDetails'])) {
            $com_length = sizeof($input['pregnancyComplicationsDetails']);
            for ($i = 0; $i < $com_length; $i++) {
                $comp_item = $input['pregnancyComplicationsDetails'][$i];
                if (isset($comp_item['complication']) && $comp_item['complication'] != '' && $comp_item['complication'] != 0) {
                    $comps = array(
                        'Complication' => $comp_item['complication'],
                        'Treatment' => $comp_item['treatment'] ?? null,
                        'duration_in_weeks' => $comp_item['duration'] ?? null,
                        'duration_unit' => $comp_item['durationType'] ?? null,
                        'AdmissionId' => 0,
                        'BabyId' => $baby_data->BabyId,
                        'flags' => $this->usg_flags,
                    );
                    Complication::create($comps);
                }
            }
        }

        $usg_parameters['BabyId'] = $baby_data->BabyId;
        $usg_parameters['MotherId'] = $baby_data->MotherId;
        $usg_parameters['flags'] = $this->usg_flags;
        $usg_parameters['type'] = 1;
        Usg::where($usg_parameters)->delete();
        if (isset($input['datingScanDetails']) && !empty($input['datingScanDetails'])) {
            $usg_parameters['date'] = !empty($input['datingScanDetails']['date']) ? date('Y-m-d', strtotime($input['datingScanDetails']['date'])) : null;
            $usg_parameters['Gestation'] = $input['datingScanDetails']['gestation'] ?? null;
            $usg_parameters['Finding'] = $input['datingScanDetails']['findings'] ?? null;
            Usg::create($usg_parameters);
        }
        unset($usg_parameters);

        //creating usg adn findings for anolog scan
        $usg_parameters['BabyId'] = $baby_data->BabyId;
        $usg_parameters['MotherId'] = $baby_data->MotherId;
        $usg_parameters['flags'] = $this->usg_flags;
        $usg_parameters['type'] = 2;
        Usg::where($usg_parameters)->delete();
        if (isset($input['anomalyScanDetails']) && !empty($input['anomalyScanDetails'])) {
            $usg_parameters['date'] = !empty($input['anomalyScanDetails']['date']) ? date('Y-m-d', strtotime($input['anomalyScanDetails']['date'])) : null;
            $usg_parameters['Gestation'] = $input['anomalyScanDetails']['gestation'] ?? null;
            $usg_parameters['Finding'] = $input['anomalyScanDetails']['findings'] ?? null;
            Usg::create($usg_parameters);
        }
        unset($usg_parameters);

        //creating usg adn findings for other scan
        $usg_parameters['BabyId'] = $baby_data->BabyId;
        $usg_parameters['MotherId'] = $baby_data->MotherId;
        $usg_parameters['flags'] = $this->usg_flags;
        $usg_parameters['type'] = 3;
        Usg::where($usg_parameters)->delete();

        if (isset($input['otherScanDetails']) && is_array($input['otherScanDetails'])) {

            for ($i = 0; $i < count($input['otherScanDetails']); $i++) {
                $scan_item = $input['otherScanDetails'][$i];
                if (empty($scan_item))
                    continue;
                $usg = array(
                    'date' => isset($scan_item["date"]) && !empty($scan_item["date"]) ? date('Y-m-d', strtotime($scan_item["date"])) : null,
                    'Gestation' => $scan_item["gestation"] ?? null,
                    'Finding' => $scan_item["findings"] ?? null,
                    'MotherId' => $baby_data->MotherId,
                    'BabyId' => $baby_data->BabyId,
                    'flags' => $this->usg_flags,
                    'type' => 3,
                );
                Usg::create($usg);
            }
        }

        $usg_parameters['BabyId'] = $baby_data->BabyId;
        $usg_parameters['MotherId'] = $baby_data->MotherId;
        $usg_parameters['flags'] = $this->usg_flags;
        $usg_parameters['type'] = 4;
        Usg::where($usg_parameters)->delete();

        if (isset($input['dopplerScanDetails']) && is_array($input['dopplerScanDetails'])) {

            for ($i = 0; $i < count($input['dopplerScanDetails']); $i++) {
                $scan_item = $input['dopplerScanDetails'][$i];
                if (empty($scan_item))
                    continue;
                $usg = array(
                    'date' => isset($scan_item["date"]) && !empty($scan_item["date"]) ? date('Y-m-d', strtotime($scan_item["date"])) : null,
                    'Gestation' => $scan_item["gestation"] ?? null,
                    'Finding' => $scan_item["findings"] ?? null,
                    'MotherId' => $baby_data->MotherId,
                    'BabyId' => $baby_data->BabyId,
                    'flags' => $this->usg_flags,
                    'type' => 4,
                );
                Usg::create($usg);
            }
        }
        $proforma['MultiplePregnancy'] = isset($input['multiplePregnancy']) && !empty($input['multiplePregnancy']) ? $input['multiplePregnancy'] : null;
        $proforma['AntenatalSteroids'] = isset($input['antenatalSteroids']) && !empty($input['antenatalSteroids']) ? $input['antenatalSteroids'] : null;
        $proforma['typeofsteroids'] = isset($input['typeOfSteriods']) && !empty($input['typeOfSteriods']) ? $input['typeOfSteriods'] : null;
        $proforma['LastDoseDeliveryInterval'] = isset($input['lastDoseDeliveryInterval']) && !empty($input['lastDoseDeliveryInterval']) ? $input['lastDoseDeliveryInterval'] : null;
        $proforma['antenatal_MgSO4'] = isset($input['antenatalMgSO4ForNeuroprotection']) && !empty($input['antenatalMgSO4ForNeuroprotection']) ? $input['antenatalMgSO4ForNeuroprotection'] : null;
        $proforma['SteroidCourse'] = isset($input['steroidCourse']) && !empty($input['steroidCourse']) ? $input['steroidCourse'] : null;
        $proforma['Labour'] = isset($input['labour']) && !empty($input['labour']) ? $input['labour'] : null;
        $proforma['NatureofLabour'] = isset($input['natureofLabour']) && !empty($input['natureofLabour']) ? $input['natureofLabour'] : null;
        $proforma['CommentOnLiquor'] = isset($input['commentOnLiquor']) && !empty($input['commentOnLiquor']) ? $input['commentOnLiquor'] : null;
        $proforma['sepsis_in_mother'] = isset($input['riskFactorsForSepsisInMothers']) && !empty($input['riskFactorsForSepsisInMothers']) ? $input['riskFactorsForSepsisInMothers'] : null;
        $proforma['sepsis_in_mother_type'] = isset($input['riskFactors']) ? json_encode($input['riskFactors']) : null;
        $proforma['MaternalPyrexia'] = isset($input['maternalPyrexia']) && !empty($input['maternalPyrexia']) ? $input['maternalPyrexia'] : null;
        $proforma['maternal_pyrexia_fahrenheit'] = isset($input['maternalPyrexiaTemperatureFahrenheit']) && !empty($input['maternalPyrexiaTemperatureFahrenheit']) ? $input['maternalPyrexiaTemperatureFahrenheit'] : null;
        $proforma['PROM'] = isset($input['PROM']) && !empty($input['PROM']) ? $input['PROM'] : null;
        $proforma['DurationOfROM'] = isset($input['durationOfPROM']) && !empty($input['durationOfPROM']) ? $input['durationOfPROM'] : null;
        $proforma['Maternal_antibiotics_status'] = isset($input['maternalAntibiotics']) && !empty($input['maternalAntibiotics']) ? $input['maternalAntibiotics'] : null;
        $proforma['MaternalAntibiotics'] = (isset($input['maternalAntibioticsDetails']) && count($input['maternalAntibioticsDetails']) != 0 && !empty($input['maternalAntibioticsDetails'][0])) ? json_encode($input['maternalAntibioticsDetails']) : '';
        $proforma['TimeofLastDose'] = isset($input['timeOfLastDose']) && !empty($input['timeOfLastDose']) ? $input['timeOfLastDose'] : null;
        $proforma['ModeOfDelivery'] = isset($input['modeOfDelivery']) && !empty($input['modeOfDelivery']) ? $input['modeOfDelivery'] : null;
        $proforma['Indication'] = isset($input['indication']) ? json_encode($input['indication']) : json_encode(array());
        $proforma['Presentation'] = isset($input['presentation']) && !empty($input['presentation']) ? $input['presentation'] : null;
        $proforma['FoetalDistress'] = isset($input['fetalDistress']) && !empty($input['fetalDistress']) ? $input['fetalDistress'] : null;
        $proforma['CTG'] = isset($input['CTG']) && !empty($input['CTG']) ? $input['CTG'] : null;
        $proforma['CTGDetails'] = isset($input['CTGDetails']) && !empty($input['CTGDetails']) ? $input['CTGDetails'] : null;
        $proforma['CordBloodGas'] = isset($input['cordBloodGas']) && !empty($input['cordBloodGas']) ? $input['cordBloodGas'] : null;
        $proforma['CordpH'] = isset($input['cordPH']) && !empty($input['cordPH']) ? $input['cordPH'] : null;
        $proforma['CordHCO3'] = isset($input['cordHCO3']) && !empty($input['cordHCO3']) ? $input['cordHCO3'] : null;
        $proforma['CordBE'] = isset($input['cordBE']) && !empty($input['cordBE']) ? $input['cordBE'] : null;
        $proforma['TypeofAnesthesia'] = isset($input['typeofAnesthesia']) && !empty($input['typeofAnesthesia']) ? $input['typeofAnesthesia'] : null;
        $proforma['GastricAspirate'] = isset($input['gastricAspirate']) && !empty($input['gastricAspirate']) ? $input['gastricAspirate'] : null;
        $proforma['delayed_cord_clamping'] = isset($input['delayedCordClamping']) && !empty($input['delayedCordClamping']) ? $input['delayedCordClamping'] : null;
        $proforma['reason_dcc'] = isset($input['reasonForNoDCC']) && !empty($input['reasonForNoDCC']) ? $input['reasonForNoDCC'] : null;
        $proforma['duration_dcc'] = isset($input['delayedCordClampingduration']) && !empty($input['delayedCordClampingduration']) ? $input['delayedCordClampingduration'] : null;
        $proforma['umbilicalcordmilking'] = isset($input['umbilicalCordMilking']) && !empty($input['umbilicalCordMilking']) ? $input['umbilicalCordMilking'] : null;
        $proforma['cutcordmilking'] = isset($input['cutCordMilking']) && !empty($input['cutCordMilking']) ? $input['cutCordMilking'] : null;

        // Resuscitation Details
        $proforma['Resuscitation'] = isset($input['resuscitation']) && !empty($input['resuscitation']) ? $input['resuscitation'] : null;
        $proforma['PPV'] = isset($input['PPV']) && !empty($input['PPV']) ? $input['PPV'] : null;
        $proforma['CPR'] = isset($input['CPR']) && !empty($input['CPR']) ? $input['CPR'] : null;
        $proforma['Intubation'] = isset($input['intubation']) && !empty($input['intubation']) ? $input['intubation'] : null;
        $proforma['bag_mask_ventilator'] = isset($input['bagMaskVentilation']) && !empty($input['bagMaskVentilation']) ? $input['bagMaskVentilation'] : null;
        $proforma['FacialOxygen'] = isset($input['facialOxygen']) && !empty($input['facialOxygen']) ? $input['facialOxygen'] : null;
        $proforma['delivery_room_cpap'] = isset($input['deliveryRoomCPAP']) && !empty($input['deliveryRoomCPAP']) ? $input['deliveryRoomCPAP'] : null;
        $proforma['Drugs'] = isset($input['drugs']) && !empty($input['drugs']) ? $input['drugs'] : null;
        $proforma['resusciatation_drugs'] = isset($input['drugDetails']) ? json_encode($input['drugDetails']) : null;

        // Resuscitation Timing & Duration
        $proforma['initial_steps'] = isset($input['initialSteps']) && !empty($input['initialSteps']) ? $input['initialSteps'] : null;
        $proforma['TimeOf1stGasp'] = isset($input['timeOf1stGaspInMinutes']) && !empty($input['timeOf1stGaspInMinutes']) ? $input['timeOf1stGaspInMinutes'] : ($input['timeOf1stGasp'] ?? null);
        $proforma['timeofgasp_status'] = !empty($proforma['TimeOf1stGasp']) ? 1 : null;
        $proforma['RegularRespiration'] = isset($input['regularRespirationMinutes']) && !empty($input['regularRespirationMinutes']) ? $input['regularRespirationMinutes'] : ($input['regularRespiration'] ?? null);
        $proforma['regularrespiration_status'] = !empty($proforma['RegularRespiration']) ? 1 : null;
        $proforma['duration_of_cpr'] = isset($input['durationOfCPR']) && !empty($input['durationOfCPR']) ? $input['durationOfCPR'] : null;
        $proforma['DurationOfPPV'] = isset($input['durationOfPTV']) && !empty($input['durationOfPTV']) ? $input['durationOfPTV'] : null;
        $proforma['DurationOfOxygen'] = isset($input['durationOfFacialOxygen']) && !empty($input['durationOfFacialOxygen']) ? $input['durationOfFacialOxygen'] : null;
        $proforma['bag_mask_ventilator_duration'] = isset($input['bagMaskVentilationDurationMin']) && !empty($input['bagMaskVentilationDurationMin']) ? $input['bagMaskVentilationDurationMin'] : ($input['bagMaskVentilationDuration'] ?? null);
        $proforma['bag_mask_ventilator_min'] = !empty($proforma['bag_mask_ventilator_duration']) ? 1 : null;
        $proforma['maximum_fio2_required'] = isset($input['maximumFio2Rquired']) && !empty($input['maximumFio2Rquired']) ? $input['maximumFio2Rquired'] : null;

        // Intubation Details
        $proforma['ETTSize'] = isset($input['ETTSizeInMM']) && !empty($input['ETTSizeInMM']) ? $input['ETTSizeInMM'] : null;
        $proforma['DepthOfInsertion'] = isset($input['depthOfInsertion']) && !empty($input['depthOfInsertion']) ? $input['depthOfInsertion'] : null;
        $proforma['insertion_status'] = isset($input['depthOfInsertionLengthInCM']) && !empty($input['depthOfInsertionLengthInCM']) ? $input['depthOfInsertionLengthInCM'] : null;

        // Vitamin K Administration
        $proforma['VitaminK'] = isset($input['vitaminK']) && !empty($input['vitaminK']) ? $input['vitaminK'] : null;
        $proforma['DoseVitK'] = isset($input['vitaminKDose']) && !empty($input['vitaminKDose']) ? $input['vitaminKDose'] : null;
        $proforma['RouteVitK'] = isset($input['vitaminKRoute']) && !empty($input['vitaminKRoute']) ? $input['vitaminKRoute'] : null;

        // Transfer & Status
        $proforma['transfer_status'] = isset($input['transferStatus']) && !empty($input['transferStatus']) ? $input['transferStatus'] : null;
        $proforma['PLAN'] = isset($input['plan']) && !empty($input['plan']) ? $input['plan'] : null;

        // Examination & Background
        $proforma['InitialExamination'] = isset($input['initialExaminationSummary']) && !empty($input['initialExaminationSummary']) ? $input['initialExaminationSummary'] : null;
        $proforma['AdditionalDetails'] = isset($input['backgroundDetails']) && !empty($input['backgroundDetails']) ? $input['backgroundDetails'] : null;

        // Baby Measurements
        $proforma['Length'] = isset($input['birthLength']) && !empty($input['birthLength']) ? $input['birthLength'] : null;
        $proforma['OFC'] = isset($input['birthHeadCircunference']) && !empty($input['birthHeadCircunference']) ? $input['birthHeadCircunference'] : null;

        // Mother Details (additional)
        $proforma['PlaceofSupervision'] = isset($input['pleaceOfSupervision']) && !empty($input['pleaceOfSupervision']) ? $input['pleaceOfSupervision'] : null;

        // Malformation
        $proforma['Malformation'] = isset($input['malformation']) && !empty($input['malformation']) ? $input['malformation'] : null;

        // Conception
        $proforma['Conception'] = isset($input['conception']) && !empty($input['conception']) ? $input['conception'] : null;

        // Lab Tests (Additional)
        $proforma['DCT'] = isset($input['DCT']) && !empty($input['DCT']) ? $input['DCT'] : null;
        $proforma['ict'] = isset($input['ICT']) && !empty($input['ICT']) ? $input['ICT'] : null;

        if (isset($input['apgar']) && !empty($input['apgar'])) {
            $proforma['known_field'] = (isset($input['apgar']["status"]) && $input['apgar']["status"] == 'Yes') ? 2 : 1;
        }


        // Merge processed proforma data into input
        $input = array_merge($input, $proforma);
        $input['BabyId'] = $baby_data->BabyId;
        $input['MotherId'] = $baby_data->MotherId;
        $input['BMrNo'] = $baby_data->BMrNo ?? ($input['uhid'] ?? $input['BMrNo'] ?? null);

        if (isset($input['transfer_status']) && $input['transfer_status'] == "Postnatal Ward" && !\Session::has('registration_start')) {
            $episodes = Admission::where('BabyId', $input['BabyId'])->count();
            $episodes += 1;
            $admission_data = array(
                'BabyId' => $baby_data->BabyId,
                'BMrNo' => $input['uhid'],
                'MotherId' => $baby_data->MotherId,
                'AdmissionDate' => $input['TestDate'],
                'AdmissionTime' => $input['TEST_TIME'] . ':' . $input['TEST_MINS'] . ':' . $input['TEST_AM'],
                'InOrOut' => 'In',
                'AdmissionType' => 'Post',
                'Status' => "Inpatient",
                'UserAdded' => $this->user_id,
                'DateAdded' => date('Y-m-d H:i:s'),
                'DateModified' => date('Y-m-d H:i:s'),
                'UserModified' => $this->user_id,
                'episodes' => 'Admission ' . $episodes,
            );
            $prev_admission_status = Admission::select('AdmissionId')->where('BabyId', $baby_data->BabyId)->where('Status', 'Inpatient')
                ->first();
            if ($prev_admission_status) {
                $admission = $prev_admission_status;
            } else {
                $admission = Admission::create($admission_data);
            }
            $admission_data['AdmissionId'] = $input['AdmissionId'] = $admission->AdmissionId;
            $admission_data['discharge_status'] = 'Inpatient';
            Postnatal::create($admission_data);
            PostnatalDischarge::create($admission_data);
        }

        if (isset($input['transfer_status']) && ($input['transfer_status'] == "NICU" || $input['transfer_status'] == "HDU" || $input['transfer_status'] == "SCBU" || $input['transfer_status'] == "Nursery" || $input['transfer_status'] == "Postnatal Ward") && !\Session::has('registration_start')) {
            $episodes = Admission::where('BabyId', $input['BabyId'])->count();
            $episodes += 1;
            $admission_data = array(
                'BabyId' => $input['BabyId'],
                'BMrNo' => $input['BMrNo'],
                'MotherId' => $input['MotherId'],
                'AdmissionDate' => $input['TestDate'],
                'AdmissionTime' => $input['TEST_TIME'] . ':' . $input['TEST_MINS'] . ':' . $input['TEST_AM'],
                'InOrOut' => 'In',
                'AdmissionType' => 'NICU',
                'Status' => "Inpatient",
                'UserAdded' => $this->transcription_user,
                'DateAdded' => date('Y-m-d H:i:s'),
                'DateModified' => date('Y-m-d H:i:s'),
                'UserModified' => $this->transcription_user,
                'episodes' => 'Admission ' . $episodes,
            );
            $prev_admission_status = Admission::select('AdmissionId')->where('BabyId', $baby_data->BabyId)->where('Status', 'Inpatient')
                ->first();
            if ($prev_admission_status) {
                $admission = $prev_admission_status;
            } else {
                $admission = Admission::create($admission_data);
            }
            $admission_id = $admission->AdmissionId;

            $baby_gestation = array();
            $baby_gestation['CorrectedGestation'] = json_encode(array(
                'cg_weeks' => '',
                'cg_days' => ''
            ));

            if (!empty($baby->DOB)) {
                $baby_gestation['DayOfLife'] = \SiteHelpers::calculate_day_of_life($baby->DOB);
            }
            if (!empty($baby->Gestation)) {
                $baby_gestation['Gestation'] = \SiteHelpers::convert_gestation_days($baby->Gestation);
            }

            if (isset($baby_gestation['DayOfLife']) && !empty($baby_gestation['DayOfLife']) && isset($baby_gestation['Gestation']) && !empty($baby_gestation['Gestation'])) {
                $baby->CGA = \SiteHelpers::calculate_corrected_gestation($baby_gestation['Gestation'], $baby_gestation['DayOfLife']);

                $baby_gestation['CorrectedGestation'] = json_encode(array(
                    'cg_weeks' => (int) $baby->CGA[0],
                    'cg_days' => (int) $baby->CGA[1]
                ));
            }

            $nicu_data = array(
                'BabyId' => $baby_data->BabyId,
                'BMrNo' => $input['uhid'],
                'MotherId' => $baby_data->MotherId,
                'AdmissionId' => $admission_id,
                'AdmissionDate' => $input['TestDate'],
                'AdmissionTime' => $input['TEST_TIME'] . ':' . $input['TEST_MINS'] . ':' . $input['TEST_AM'],
                'Status' => "Inpatient",
                'AdmittedFrom' => "Postnatal",
                'CorrectedGestation' => $baby_gestation['CorrectedGestation'],
                'UserAdded' => $this->transcription_user,
                'status' => 'Inpatient',
                'DateAdded' => date('Y-m-d H:i:s'),
                'DateModified' => date('Y-m-d H:i:s'),
                'UserModified' => $this->transcription_user,
                'DescriptionOfResuscitation' => $input['OtherInformation'],
            );
            $input['AdmissionId'] = $admission->AdmissionId;

            $prev_nicu_admission = Nicu::where('status', 'Inpatient')->where('BabyId', $baby_data->BabyId)->orderBy('AdmissionId', 'desc')
                ->first();
            if (!$prev_nicu_admission) {
                Nicu::create($nicu_data);
            }
        }


        $input['form_status'] = 1;
        $check_proforma = Neonatal::checkNeonatal($baby_data->BabyId)->last();

        if ($check_proforma) {
            $input['DateModified'] = Carbon::now($this->zone);
            $input['UserModified'] = $this->user_id;

            $neo = Neonatal::findOrfail($check_proforma->NeonatalId)->update($input);
            $id = $check_proforma->NeonatalId;
        } else {
            $input['DateAdded'] = Carbon::now($this->zone);
            $input['UserAdded'] = $this->user_id;
            $input['DateModified'] = Carbon::now($this->zone);
            $input['UserModified'] = $this->user_id;
            $neo = Neonatal::create($input);
            $id = $neo->NeonatalId;
        }
        /* New Born Update or Create */
        //        $newborn = Newborn::find($input['BabyId']);
        //        if ($newborn)
        //        {
        //            $input['DateModified'] = Carbon::now($this->zone);
        //            $input['UserModified'] = $this->user_id;
        //
        //            $newborn->update($input);
        //        }
        //        else
        //        {
        //            $input['DateAdded'] = Carbon::now($this->zone);
        //            $input['UserAdded'] = $this->user_id;
        //            $input['DateModified'] = Carbon::now($this->zone);
        //            $input['UserModified'] = $this->user_id;
        //            Newborn::create($input);
        //        }

        //        if (isset($input['brand_name']))
        //        {
        //            for ($i = 0;$i < sizeof($input['brand_name']);$i++)
        //            {
        //                $discharge_medications = array(
        //                    'Medication' => empty($input['formulation'][$i]) ? $input['brand_name'][$i] : $input['formulation'][$i],
        //                    'Dose' => $input['dose'][$i],
        //                    'Frequency' => $input['frequency'][$i],
        //                    'Duration' => $input['duration'][$i],
        //                    'genericname' => $input['generic_name'][$i],
        //                    'formulation' => $input['formulation'][$i],
        //                    'AdmissionId' => (!empty($input['AdmissionId'])) ? $input['AdmissionId'] : 0,
        //                    'BabyId' => $input['BabyId'],
        //                    'flag' => 1,
        //                    'source_id' => 0
        //                );
        //                Medications::create($discharge_medications);
        //            }
        //        }
        return \Response::json(['type' => 'success', 'message' => 'Neonatal proforma details updated'], 200);
    }
    public function createUpdateBabyDetails($data)
    {
        // die("START: createUpdateBabyDetails");
        $babyIsExist = Baby::where('BMrNo', trim($data['uhid']))->where('IsDeleted', '0')->first();
        if ($babyIsExist) {
            return $babyIsExist;
        } else {
            $get_baby_details_from_his = \SiteHelpers::getConfigSettings('GET_PATIENT_INFO_FROM_HIS');
            $patient_response = null;
            try {
                $client = new \GuzzleHttp\Client();

                $settings = Settings::find(1);
                $token = $settings ? $settings->hms_token : '';
                $header_content = [
                    'Content-Type' => 'application/json',
                    'token' => $token,
                ];

                if (!empty($get_baby_details_from_his)) {
                    $response = $client->get($get_baby_details_from_his, [
                        'headers' => $header_content,
                        'query' => ['uhid' => trim($data['uhid'])],
                        'http_errors' => false
                    ]);

                    $patient_response = $response->getBody();
                    $patient_response = $patient_response->getContents();
                }
            } catch (\Exception $e) {
                $this->custom_error->emergencyLog('HIS API Error: ' . $e->getMessage());
            }

            $should_use_fallback = empty($patient_response);
            if (!$should_use_fallback) {
                $decoded_check = json_decode($patient_response, true);
                if (!isset($decoded_check['data'])) {
                    $should_use_fallback = true;
                }
            }

            if ($should_use_fallback) {
                $fallback_data = [
                    'data' => [
                        'patient_name' => $data['baby']['name'] ?? 'Unknown',
                        'surname' => $data['baby']['name'] ?? '',
                        'birth_date' => $data['baby']['dob'] ?? date('Y-m-d'),
                        'mobile' => $data['mother']['mobile'] ?? '',
                        'address1' => '',
                        'address2' => '',
                        'address3' => '',
                        'city' => '',
                        'pincode' => '',
                        'mrn' => $data['uhid'],
                        'salutation' => 'Baby',
                        'sex' => $data['baby']['sex'] ?? 'Unknown',
                        'education' => '',
                        'occupation' => '',
                        'spouse_name' => '',
                        'spouse_mobile' => ''
                    ]
                ];
                $patient_response = json_encode($fallback_data);
            }

            $baby_data = $data['baby'];
            $mother_data = $data['mother'];

            // $mother['MotherName'] = 'M/O' . $mother_data['name']['first']; // Unsafe access, removed.
            $this->custom_error->emergencyLog('Patient response==================================' . $patient_response);
            $patient_response = collect(json_decode($patient_response))->toArray();
            if (isset($patient_response['data']) && !empty($patient_response['data'])) {
                $patient_data = $patient_response['data'];
                $name_aray = explode(' ', $patient_data->patient_name);
                $partial_mother_name = '';

                if (isset($name_aray[0])) {
                    $partial_mother_name = $name_aray[0];
                }
                $collect_baby_count = 0;
                if (!is_null($patient_data->mobile) && $patient_data->mobile != '') {

                    $check_mulitiple_preg = \DB::table('baby')->join('mother', 'mother.MotherId', '=', 'baby.MotherId')->where('baby.DOB', $patient_data->birth_date)->where('mother.Mobile', $patient_data->mobile)->get()->toArray();
                    $collect_baby_count = count($check_mulitiple_preg);
                }


                if ($collect_baby_count > 0 && !is_null($patient_data->mobile) && $patient_data->mobile != '') {

                    $currently_baby_count = $collect_baby_count + 1;

                    $preganancy_types = array(2 => 'Twins', 3 => 'Triplets', 4 => 'Quadruplets', 5 => 'Quintuplets', 6 => 'Sextuplets', 7 => 'Septuplets', 8 => 'Octuplets');

                    $mother_id = $check_mulitiple_preg[0]->MotherId;
                    $baby['MultiplePregnancy'] = 'Yes';
                    $baby['MultiplePregnancyType'] = $preganancy_types[$currently_baby_count];
                    $baby['Noofbabies'] = $currently_baby_count;
                    $this->updateTwinBaby($mother_id, $patient_data->birth_date, $preganancy_types[$currently_baby_count], $currently_baby_count);
                } else {
                    $mother['MotherName'] = ucfirst(strtolower($patient_data->patient_name));
                    $mother['PartnerName'] = ucfirst(strtolower(str_replace(["S/O.", "S/O", "D/O.", "D/O"], "", $patient_data->surname)));
                    $mother['UserAdded'] = $this->transcription_user;
                    $mother['UserModified'] = $this->transcription_user;
                    $mother['DateAdded'] = Carbon::now($this->zone);
                    $mother['IsDeleted'] = '0';
                    $mother['Address1'] = $patient_data->address1;
                    $mother['Address2'] = $patient_data->address2;
                    $mother['Address3'] = $patient_data->address3;
                    $mother['City'] = $patient_data->city;
                    $mother['Address4'] = $patient_data->pincode;
                    $mother['Mobile'] = $patient_data->mobile;
                    if (isset($mother_data['gravida']) && !empty($mother_data['gravida'])) {
                        $mother['G_Value'] = $mother_data['gravida'];
                    }
                    if (isset($mother_data['para']) && !empty($mother_data['para'])) {
                        $mother['P_Value'] = $mother_data['para'];
                    }
                    if (isset($mother_data['liveBirth']) && !empty($mother_data['liveBirth'])) {
                        $mother['L_Value'] = $mother_data['liveBirth'];
                    }
                    if (isset($mother_data['abortion']) && !empty($mother_data['abortion'])) {
                        $mother['A_Value'] = $mother_data['abortion'];
                    }
                    if (isset($mother_data['bloodGroup']) && !empty($mother_data['bloodGroup'])) {
                        $mother['MotherBloodGroup'] = $mother_data['bloodGroup'];
                    }
                    $mother_id = Mother::create($mother)->MotherId;
                    $baby['MultiplePregnancy'] = 'No';
                    $baby['BirthOrder'] = $baby['MultiplePregnancyType'] = 'Singleton';
                }

                $baby['MotherId'] = $mother_id;
                $baby['BMrNo'] = trim($patient_data->mrn);
                $salutation = $patient_data->salutation;
                if ($salutation == 'BABY OF.') {
                    $salutation = 'B/O';
                }
                $baby['BabyName'] = $salutation . ' ' . ucfirst(strtolower($patient_data->patient_name)) . ' ' . ucfirst(strtolower(str_replace(["S/O.", "S/O", "D/O.", "D/O"], "", $patient_data->surname)));
                $baby['DOB'] = $patient_data->birth_date;
                if (isset($baby_data['birthWeight']) && !empty($baby_data['birthWeight'])) {
                    $baby['BirthWeight'] = $baby_data['birthWeight'];
                }

                if (isset($baby_data['gestation']) && !empty($baby_data['gestation'])) {
                    $gestation = $baby_data['gestation'];
                    $baby['Gestation'] = json_encode($gestation);
                    $baby['g_weeks'] = $gestation['weeks'] ?? null;
                    $baby['g_days'] = $gestation['days'] ?? null;
                }
                if (isset($baby_data['bloodGroup']) && !empty($baby_data['bloodGroup'])) {
                    $baby['BabyBloodGroup'] = $baby_data['bloodGroup'];
                }
                if (isset($baby_data['birthOrder']) && !empty($baby_data['birthOrder'])) {
                    $baby['BirthOrder'] = $baby_data['birthOrder'];
                }
                if (isset($baby_data['birthStatus']) && !empty($baby_data['birthStatus'])) {
                    $baby['BirthStatus'] = $baby_data['birthStatus'];
                }
                if (isset($baby_data['tob']) && !empty($baby_data['tob'])) {
                    $timestamp = strtotime($baby_data['tob']);
                    $baby['TOB_TIME'] = date("h", $timestamp);
                    $baby['TOB_MINS'] = date("i", $timestamp);
                    $baby['TOB_AM'] = strtoupper(date("a", $timestamp));
                }
                $baby['Sex'] = ucfirst(strtolower($baby_data['sex'] ?? $patient_data->sex ?? 'Unknown'));
                $baby['UserAdded'] = $this->transcription_user;
                $baby['DateAdded'] = Carbon::now($this->zone);
                $baby['IsDeleted'] = '0';
                $baby['neonatal_consultant'] = env('DEFAULT_NEONATAL_CONSULTANTS');
                $babyDetails = Baby::create($baby);
                return $babyDetails;
            } else {
                $this->custom_error->emergencyLog('Transcripion data error: Unable to get patient information from WEB HIS for UHID:' . $data['uhid'] . ' at : ' . Carbon::now($this->zone));
                return false;
            }
        }
    }

    public function storeTranscribedOpNeonatalData(Request $request)
    {

        $input = $request->all();
        if ((!isset($input['uhid']) || empty($input['uhid'])) && isset($input['baby']['uhid'])) {
            $input['uhid'] = $input['baby']['uhid'];
        }

        if (!isset($input['uhid']) || empty($input['uhid'])) {
            return \Response::json(['type' => 'success', 'message' => 'UHID is missing'], 500);
        }
        if (!isset($input['opDateTime'])) {
            return \Response::json(['type' => 'success', 'message' => 'OP date & time is missing'], 500);
        }

        $baby_details = $this->createUpdateBabyDetails($input);

        if ($this->createUpdateOpNeonatal($input, $baby_details)) {
            return \Response::json(['type' => 'success', 'message' => 'OP Neonatal details updated'], 200);
        } else {
            return \Response::json(['type' => 'success', 'message' => 'error while store the op neonatal details'], 500);
        }
    }

    public function createUpdateOpNeonatal($input, $baby_data)
    {

        $uhid = $input['uhid'];
        $baby_details = $input['baby'] ?? [];
        $mother_details = $input['mother'] ?? [];
        $partner_details = $input['partner'] ?? [];
        $eligibility = $input['eligibility'] ?? [];
        $medical_history = $input['medicalHistory'] ?? [];
        $follow_up = $input['followUp'] ?? [];
        $medications = $input['medications'] ?? [];
        $immunization = $input['immunization'] ?? [];

        $mother = [];
        $mother['MMrNo'] = $mother_details['uhid'] ?? null;
        if (isset($mother_details['title'])) {
            $mother['MotherTitle'] = $mother_details['title'] ?? null;
        }
        $mother['MotherInitial'] = $mother_details['name']['initial'] ?? null;
        $mother['MotherName'] = $mother_details['name']['first'] ?? null;
        $mother['MotherLastName'] = $mother_details['name']['last'] ?? null;
        if (isset($mother_details['dob']) && strtotime($mother_details['dob'])) {
            $mother['MotherDOB'] = date('Y-m-d', strtotime($mother_details['dob']));
        } else {
            $mother['MotherDOB'] = null;
        }
        $mother['MothercYear'] = $mother_details['age'] ?? null;
        $mother['education_status'] = $mother_details['education'] ?? null;
        $mother['Occupation'] = $mother_details['occupation']['type'] ?? null;
        $mother['occupation_status'] = $mother_details['occupation']['status'] ?? null;
        $mother['Mobile'] = $mother_details['contact']['primary'] ?? null;
        $mother['LandLine'] = $mother_details['contact']['secondary'] ?? null;
        $mother['MotherEmail'] = $mother_details['contact']['email'] ?? null;
        $mother['MotherSpokenLanguages'] = $mother_details['language'] ?? null;
        $mother['Address1'] = $mother_details['address']['doorNo'] ?? null;
        $mother['Address2'] = $mother_details['address']['street'] ?? null;
        $mother['Address3'] = $mother_details['address']['city'] ?? null;
        $mother['Address4'] = $mother_details['address']['pinCode'] ?? null;
        $mother['Address5'] = $mother_details['address']['country'] ?? null;
        $mother['MotherBloodGroup'] = $baby_details['bloodGroup'] ?? null;
        $mother['PartnerTitle'] = $partner_details['title'] ?? null;
        $mother['PartnerInitial'] = $partner_details['name']['initial'] ?? null;
        $mother['PartnerName'] = $partner_details['name']['first'] ?? null;
        $mother['PartnerLastName'] = $partner_details['name']['last'] ?? null;
        if (isset($partner_details['dob']) && strtotime($partner_details['dob'])) {
            $mother['PartnerDOB'] = date('Y-m-d', strtotime($partner_details['dob']));
        } else {
            $mother['PartnerDOB'] = null;
        }
        $mother['PartnercYear'] = $partner_details['age'] ?? null;
        $mother['partner_education_status'] = $partner_details['education'] ?? null;
        $mother['PartnerOccupation'] = $partner_details['occupation']['type'] ?? null;
        $mother['partner_occupation_status'] = $partner_details['occupation']['status'] ?? null;
        if (isset($partner_details['sameAsMotherDetails']) && !empty($partner_details['sameAsMotherDetails'])) {
            $mother['PartnerContact'] = $mother_details['contact']['primary'] ?? null;
            $mother['PartnerMobile'] = $mother_details['contact']['secondary'] ?? null;
            $mother['Email'] = $mother_details['contact']['email'] ?? null;
            $mother['FatherSpokenLanguages'] = $mother_details['language'] ?? null;
        } else {
            $mother['PartnerContact'] = $partner_details['contact']['primary'] ?? null;
            $mother['PartnerMobile'] = $partner_details['contact']['secondary'] ?? null;
            $mother['Email'] = $partner_details['contact']['email'] ?? null;
            $mother['FatherSpokenLanguages'] = $partner_details['language'] ?? null;
        }
        if (isset($partner_details['sameAsAddress']) && !empty($partner_details['sameAsAddress'])) {
            $mother['FatherAddress1'] = $mother_details['address']['doorNo'] ?? null;
            $mother['FatherAddress2'] = $mother_details['address']['street'] ?? null;
            $mother['City'] = $mother_details['address']['city'] ?? null;
            $mother['Postcode'] = $mother_details['address']['pinCode'] ?? null;
            $mother['Country'] = $mother_details['address']['country'] ?? null;
        } else {
            $mother['FatherAddress1'] = $partner_details['address']['doorNo'] ?? null;
            $mother['FatherAddress2'] = $partner_details['address']['street'] ?? null;
            $mother['City'] = $partner_details['address']['city'] ?? null;
            $mother['Postcode'] = $partner_details['address']['pinCode'] ?? null;
            $mother['Country'] = $partner_details['address']['country'] ?? null;
        }

        // if (isset($baby_data->MotherId) && $baby_data->MotherId != '' && $baby_data->MotherId != 0) {
        //     $mother_id = $baby_data->MotherId;
        //     $mother['UserModified'] = $this->user_id;
        //     $mother['DateModified'] = Carbon::now($this->zone);
        //     $mother_result = Mother::findOrfail($mother_id);
        //     $mother_result->update($mother);
        // } else {
        //     $mother['DateAdded'] = Carbon::now($this->zone);
        //     $mother['UserAdded'] = $this->user_id;
        //     $mother_result = Mother::create($mother);
        //     $mother_id = $mother_result->MotherId;
        // }

        $baby = [];
        // $baby['BabyName'] = $baby_details['name'] ?? null;
        if (isset($baby_details['dob']) && strtotime($baby_details['dob'])) {
            $baby['DOB'] = date('Y-m-d', strtotime($baby_details['dob']));
        }
        if (isset($baby_details['tob']) && strtotime($baby_details['tob'])) {
            $baby['TOB'] = date('H:i', strtotime($baby_details['tob']));
            $tob_string = strtotime($baby_details['tob']);
            $baby['TOB_TIME'] = date('h', $tob_string);
            $baby['TOB_MINS'] = date('i', $tob_string);
            $baby['TOB_AM'] = date('A', $tob_string);
        }
        if (isset($baby_details['sex']) && !empty(trim($baby_details['sex']))) {
            $baby['Sex'] = $baby_details['sex'];
        }
        if (isset($baby_details['birthStatus']) && !empty(trim($baby_details['birthStatus']))) {
            $baby['BirthStatus'] = $baby_details['birthStatus'];
        }
        if (isset($baby_details['birthOrder']) && !empty(trim($baby_details['birthOrder']))) {
            $baby['BirthOrder'] = $baby_details['birthOrder'];
        }
        if (isset($baby_details['bloodGroup']) && !empty(trim($baby_details['bloodGroup']))) {
            $baby['BabyBloodGroup'] = $baby_details['bloodGroup'];
        }
        if (isset($baby_details['birthWeight']) && !empty(trim($baby_details['birthWeight']))) {
            $baby['BirthWeight'] = $baby_details['birthWeight'];
        }
        if (isset($baby_details['gestation']) && !empty(trim($baby_details['gestation']))) {
            $gestation = $baby_details['gestation'];
            $baby['Gestation'] = json_encode($gestation);
            if (isset($gestation['weeks']) && !empty(trim($gestation['weeks']))) {
                $baby['g_weeks'] = $gestation['weeks'];
            }
            if (isset($gestation['days']) && !empty(trim($gestation['days']))) {
                $baby['g_days'] = $gestation['days'];
            }
        }


        if (isset($baby_data->BabyId) && $baby_data->BabyId != '' && $baby_data->BabyId != 0) {
            $baby_id = $baby_data->BabyId;
            $baby['DateModified'] = Carbon::now($this->zone);
            $baby['UserModified'] = $this->user_id;
            $baby_result = Baby::findOrfail($baby_id);
            $baby_result->update($baby);
        } else {
            $baby['BMrNo'] = $uhid;
            $baby['MotherId'] = $mother_id;
            $baby['DateAdded'] = Carbon::now($this->zone);
            $baby['UserAdded'] = $this->user_id;
            $baby_result = Baby::create($baby);
            $baby_id = $baby_result->BabyId;
        }

        $op = [];
        $op['BabyId'] = $baby_id;
        $op['BMrNo'] = $uhid;
        $op['HeadCircumference'] = $baby_details['birthHeadCircumference'] ?? null;
        $op['CurrentWt'] = $baby_details['currentWeight'] ?? null;
        $op['CurrentOFC'] = $baby_details['currentHeadCircumference'] ?? null;
        $op['CurrentLength'] = $baby_details['currentLength'] ?? null;
        $chronological_age = $baby_details['chronologicalAge'] ?? null;

        $op['chronological_year'] = $chronological_age['yearMonthDays']['years'] ?? null;
        $op['chronological_month'] = $chronological_age['yearMonthDays']['months'] ?? null;
        $op['chronological_days'] = $chronological_age['yearMonthDays']['days'] ?? null;
        $op['total_chronological_weeks'] = $chronological_age['weeksDays']['weeks'] ?? null;
        $op['total_chronological_days'] = $chronological_age['weeksDays']['days'] ?? null;

        $corrected_age = $baby_details['correctedAge'] ?? null;
        $op['corrected_year'] = $corrected_age['yearMonthDays']['years'] ?? null;
        $op['corrected_month'] = $corrected_age['yearMonthDays']['months'] ?? null;
        $op['corrected_days'] = $corrected_age['yearMonthDays']['days'] ?? null;
        $op['total_corrected_weeks'] = $corrected_age['weeksDays']['weeks'] ?? null;
        $op['total_corrected_days'] = $corrected_age['weeksDays']['days'] ?? null;

        $op['baby_background'] = $medical_history['babyBackground'] ?? null;
        $op['ConfidentialBackgroundDetails'] = $medical_history['confidentialDetails'] ?? null;
        $op['Complaints'] = $medical_history['complaints'] ?? null;
        $op['HPI'] = $medical_history['hpi'] ?? null;
        $op['AllergyHistory'] = $medical_history['allergy'] ?? null;
        $op['FamilyHistory'] = $medical_history['familyHistory'] ?? null;
        $op['TreatmentHistory'] = $medical_history['treatmentHistory'] ?? null;
        $op['Development'] = $medical_history['development'] ?? null;
        $op['Examination'] = $medical_history['examination'] ?? null;
        $op['neurosonogram'] = $medical_history['neurosonogram'] ?? null;
        $op['echocardiogram'] = $medical_history['echocardiogram'] ?? null;
        $op['Diagnosis'] = $medical_history['diagnosis'] ?? null;
        $op['Advice'] = $medical_history['advice'] ?? null;
        $op['investigations'] = $medical_history['investigations'] ?? null;

        $op['AppointmentType'] = $follow_up['appointmentType'] ?? null;
        if (isset($follow_up['reviewDateTime']) && strtotime($follow_up['reviewDateTime'])) {
            $review_time_string = strtotime($follow_up['reviewDateTime']);
            $op['Review'] = date('Y-m-d', $review_time_string);
            $op['review_time'] = date('h', $review_time_string);
            $op['review_min'] = date('i', $review_time_string);
            $op['review_session'] = date('A', $review_time_string);
        }

        $op['nextreviewindication'] = $follow_up['nextReviewIndication'] ?? null;
        $op['need_neuro'] = $follow_up['needNeuro'] ?? null;
        $op['Outcome'] = $follow_up['outcome'] ?? null;
        $op['SeenBy'] = $follow_up['seenBy'] ?? null;
        $op['fee_status'] = $follow_up['fee']['status'] ?? null;
        $op['fee_amount'] = $follow_up['fee']['amount'] ?? null;
        $op['fee_reason'] = $follow_up['fee']['reason'] ?? null;
        $op['Immunization'] = $immunization['status'] ?? null;
        $op['Schedule'] = $immunization['schedule'] ?? null;
        $vaccine_list = $immunization['vaccineList'] ?? [];
        $vaccine = collect($vaccine_list)->pluck('vaccineId')->map(function ($v) {
            return (string) $v;
        })->toArray();
        $op['Vaccine'] = json_encode($vaccine);

        if (isset($input['opDateTime']) && strtotime($input['opDateTime'])) {
            $op_time_string = strtotime($input['opDateTime']);
            $op['OpDate'] = date('Y-m-d', $op_time_string);
            $op['OpTime'] = date('h', $op_time_string);
            $op['OpTime_MINS'] = date('i', $op_time_string);
            $op['OpTime_AM'] = date('A', $op_time_string);
        }

        //set number of visite 

        $old_op_visite_count = Op::where(['BabyId' => $baby_id, 'IsDeleted' => 0])->count();

        $old_op_visite_count = 1 + $old_op_visite_count;
        if (strlen($old_op_visite_count) == 1) {
            $old_op_visite_count = '00' . $old_op_visite_count;
        } elseif (strlen($old_op_visite_count) == 2) {
            $old_op_visite_count = '0' . $old_op_visite_count;
        }
        $op['op_visite'] = 'Visit-' . $old_op_visite_count;

        $op_results = Op::where('BabyId', $baby_id)->where('OpDate', $op['OpDate'])->first();

        $op = array_filter($op);

        if (isset($op_results->OpId) && $op_results->OpId > 0) {
            $op['DateModified'] = Carbon::now($this->zone);
            $op['UserModified'] = $this->user_id;
            $op_results = Op::findOrfail($op_results->OpId);
            $op_results->update($op);
        } else {
            $op['DateAdded'] = Carbon::now($this->zone);
            $op['UserAdded'] = $this->user_id;
            $op_results = Op::create($op);
        }

        $op_id = $op_results->OpId;

        $eligibility_data = [];
        $eligibility_data['birth_weight_gestation_is_lesser'] = $eligibility['birthWeightGestationIsLesser'] ?? null;
        $eligibility_data['birth_weight_gestation_is_greater'] = $eligibility['birthWeightGestationIsGreater'] ?? null;
        $eligibility_data['intrauterine_growth'] = $eligibility['intrauterineGrowth'] ?? null;
        $eligibility_data['meningitis'] = $eligibility['meningitis'] ?? null;
        $eligibility_data['mechanical_ventilation'] = $eligibility['mechanicalVentilation'] ?? null;
        $eligibility_data['encephalopathy_stage_2_more'] = $eligibility['encephalopathyStage2OrMore'] ?? null;
        $eligibility_data['major_malformation'] = $eligibility['majorMalformation'] ?? null;
        $eligibility_data['inborn_errors'] = $eligibility['inbornErrors'] ?? null;
        $eligibility_data['symptomatic_hypoglycemia'] = $eligibility['symptomaticHypoglycemia'] ?? null;
        $eligibility_data['symptomatic_polycythemia'] = $eligibility['symptomaticPolycythemia'] ?? null;
        $eligibility_data['retrovirus_positive_mother'] = $eligibility['retrovirusPositiveMother'] ?? null;
        $eligibility_data['hyperbilirubinemia_transfusion_rh'] = $eligibility['hyperbilirubinemiaTransfusionRh'] ?? null;
        $eligibility_data['abnormal_neuro_exam'] = $eligibility['abnormalNeuroExam'] ?? null;
        $eligibility_data['major_morbidities'] = $eligibility['majorMorbidities'] ?? null;
        $eligibility_data['other_specify_is_present'] = $eligibility['otherSpecifyIsPresent'] ?? null;
        $eligibility_data['other_specify'] = $eligibility['otherSpecify'] ?? null;
        $eligibility_data['general_checkup'] = $eligibility['generalCheckup'] ?? null;

        $eligibility_result = NeuroEligibility::where('neuro_visit_id', $op_id)->first();

        if (isset($eligibility_result->id) && !empty($eligibility_result->id)) {
            $eligibility_data['op_date'] = $op['OpDate'];
            $eligibility_data['modified_date_time'] = Carbon::now($this->zone);
            $eligibility_data['modified_user'] = $this->user_id;
            $eligibility_result->update($eligibility_data);
        } else {
            $eligibility_data['baby_id'] = $baby_id;
            $eligibility_data['neuro_visit_id'] = $op_id;
            $eligibility_data['op_date'] = $op['OpDate'];
            $eligibility_data['op_type'] = 2;
            $eligibility_data['created_date_time'] = Carbon::now($this->zone);
            $eligibility_data['created_user'] = $this->user_id;
            NeuroEligibility::create($eligibility_data)->id;
        }

        if (is_array($medications) && count($medications) > 0) {
            $drug_counts = array_count_values(array_column($medications, 'drugId'));
            $existing_list = Medications::select('Id')->where('BabyId', $baby_id)->where('source_id', $op_id)->get()->pluck('Id')->toArray();
            // echo "<pre>";
            // print_r($existing_list);
            foreach ($medications as $value) {
                $dosage = $value['dosage'];
                foreach ($dosage as $dosage_value) {
                    $drug_id = $value['drugId'];
                    $drug_result = DrugIvFluidMaster::findOrfail($drug_id);

                    $existing = Medications::where([
                        'Medication' => $drug_result->id,
                        'route' => $value['route'],
                        'Dose' => $dosage_value['dose'],
                        'Frequency' => $dosage_value['frequency'],
                        'Duration' => $dosage_value['duration'],
                        'BabyId' => $baby_id,
                        'source_id' => $op_id,
                        'flag' => 3
                    ])->first();
                    if ($existing) {
                        $exist_key = array_search($existing->Id, $existing_list);
                        // echo "<pre>";
                        // print_r($exist_key);
                        if ($exist_key !== false) {
                            unset($existing_list[$exist_key]);
                        }
                        continue;
                    }
                    //echo "<pre>"; print_r($drug_result); exit;
                    $discharge_medications = array(
                        'Medication' => $drug_result->id,
                        'genericname' => $drug_result->generic_pharmacological_name,
                        'formulation' => $drug_result->id,
                        'route' => $value['route'],
                        'Dose' => $dosage_value['dose'],
                        'Frequency' => $dosage_value['frequency'],
                        'Duration' => $dosage_value['duration'],
                        'flag' => 3,
                        'AdmissionId' => 0,
                        'BabyId' => $baby_id,
                        'source_id' => $op_id,
                        'standard_dose' => ($drug_counts[$value['drugId']] > 1) ? 1 : 0

                    );

                    Medications::create($discharge_medications);
                }
            }
            if (!empty($existing_list)) {
                Medications::whereIn('Id', $existing_list)->delete();
            }

        }

        if (isset($op['need_neuro']) && isset($op['AppointmentType']) && isset($op['Review']) && isset($op['review_time']) && isset($op['review_min']) && isset($op['review_session']) && isset($op['SeenBy'])) {

            $appointment = new Request([
                'need_neuro' => $op['need_neuro'],
                'AppointmentType' => $op['AppointmentType'],
                'Review' => $op['Review'],
                'review_time' => $op['review_time'],
                'review_min' => $op['review_min'],
                'review_session' => $op['review_session'],
                'SeenBy' => $op['SeenBy'],
                'BabyId' => $baby_id,
            ]);

            OpController::makeAppointment($appointment->all(), $op_id);
        }

        return true;
    }

    public function storeTranscribedNicuDischargeData(Request $request)
    {
        $input = $request->all();
        if (!isset($input['uhid'])) {
            return \Response::json(['type' => 'success', 'message' => 'UHID is missing'], 500);
        }
        if (!isset($input['visitNumber'])) {
            return \Response::json(['type' => 'success', 'message' => 'Visit number is missing'], 500);
        }
        if ($this->createUpdateNicuDischarge($input)) {
            return \Response::json(['type' => 'success', 'message' => 'NICU discharge details updated'], 200);
        } else {
            return \Response::json(['type' => 'success', 'message' => 'error while store the NICU discharge details'], 500);
        }
    }

    public function createUpdateNicuDischarge($input)
    {
        $uhid = $input['uhid'];
        $visit_number = $input['visitNumber'];
        $discharge_dtl = $input['discharge'] ?? [];
        $bed_id = $input['bedId'] ?? null;
        $room_id = $input['roomId'] ?? null;

        if (is_array($discharge_dtl) && count($discharge_dtl) > 0) {
            $baby_dtl = Baby::select('BabyId', 'MotherId')->where('BMrNo', $uhid)->where('IsDeleted', false)->orderBy('BabyId', 'desc')->first();

            if (isset($baby_dtl->BabyId)) {
                $baby_id = $baby_dtl->BabyId;

                $mother_id = $baby_dtl->MotherId ?? null;

                $visit_dtl = IpNumber::select('AdmissionId')->where('baby_id', $baby_id)->where('ip_number', $visit_number)->orderBy('id', 'desc')->first();

                if (isset($visit_dtl->AdmissionId)) {

                    $admission_id = $visit_dtl->AdmissionId;

                    $nicu_dtl = Nicu::where('BabyId', $baby_id)->where('AdmissionId', $admission_id)->where('BMrNo', $uhid)->orderBy('NicuId', 'desc')->first();

                    if (isset($nicu_dtl->NicuId)) {

                        $nicu_id = $nicu_dtl->NicuId;

                        $nicu['status'] = $discharge_dtl['status'] ?? null;

                        if ($nicu['status'] != null) {
                            if ($nicu['status'] != 'Inpatient') {

                                $syringepump['baby_id'] = $baby_id;
                                $syringepump['mother_id'] = $mother_id;
                                $syringepump['admission_id'] = $admission_id;
                                $syringepump['admission_stauts'] = 4;
                                SyringePumpAdmisson::create($syringepump);
                                PrescriptionToMirthController::admission();

                                $pump_condition['baby_id'] = $baby_id;
                                $pump_update['is_syringe_pump_connected'] = false;
                                $pump_update['status'] = 'discharged';
                                $pump_update['DateModified'] = Carbon::now($this->zone);
                                $pump_update['UserModified'] = $this->user_id;

                                $patient_log_status = BedLog::where($pump_condition)->get();
                                if (count($patient_log_status) > 0) {
                                    BedLog::where($pump_condition)->Update($pump_update);
                                    $bed_log = BedLog::where($pump_condition)->orderby('id', 'desc')->first();
                                    Bed::where('id', $bed_log->bed_id)->Update(['status' => null]);
                                    DeviceStatusNotification::where('baby_mrn', $uhid)->Update(['status' => false]);
                                } else {

                                    $pump['baby_id'] = $baby_id;
                                    $pump['admission_id'] = $admission_id;
                                    $pump['status'] = 'discharged';
                                    $pump['is_syringe_pump_connected'] = false;
                                    $pump['DateAdded'] = Carbon::now($this->zone);
                                    $pump['UserAdded'] = $this->user_id;
                                    $pump['DateModified'] = Carbon::now($this->zone);
                                    $pump['UserModified'] = $this->user_id;
                                    BedLog::create($pump);
                                    if ($bed_id > 0) {
                                        Bed::where('id', $bed_id)->Update(['status' => null]);
                                    }
                                }
                                $discharged_log = array();
                                $discharged_log['baby_id'] = $baby_id;
                                $discharged_log['admission_id'] = $admission_id;
                                $discharged_log['discharged_at'] = Carbon::now($this->zone);

                                \DB::table('discharged_log')->insert($discharged_log);

                                Admission::where('AdmissionId', $admission_id)->update(['Status' => $nicu['status']]);

                                $event_input['status'] = 'DISCHARGE';
                                if ($nicu['status'] == 'Transferred') {
                                    $event_input['status'] = 'TRANSFER';
                                    if (isset($patient_log_status->bed_no) && isset($patient_log_status->room_no)) {
                                        $bed_number = $patient_log_status->bed_no;
                                        $room_number = $patient_log_status->room_no;
                                        \SiteHelpers::emptyDashboardData($bed_number, $room_number);
                                    }
                                }

                                $event_input['admission_id'] = $admission_id;
                                ErrorLogController::emergencyLogStat('NICU Discharged - ' . json_encode($event_input));
                                broadcast(new WardEvent($event_input))->toOthers();

                            } else {
                                if ($room_id > 0 && $bed_id > 0) {

                                    $check_bed_log = BedLog::where(['baby_id' => $baby_id, 'status' => 'Occupied'])->first();
                                    $ward['ward_id'] = 1;
                                    $ward['ward_name'] = \SiteHelpers::gettable_values('ward', 'name', 'id', 1);
                                    $ward['room_id'] = $room_id;
                                    $ward['room_no'] = \SiteHelpers::gettable_values('room', 'number', 'id', $room_id);
                                    $ward['bed_id'] = $bed_id;
                                    if ($bed_id != '' && !is_null($bed_id)) {
                                        $ward['bed_no'] = \SiteHelpers::gettable_values('bed', 'number', 'id', $bed_id);
                                    }
                                    $ward['baby_id'] = $baby_id;
                                    $ward['admission_id'] = $admission_id;
                                    $ward['DateAdded'] = Carbon::now($this->zone)->format('Y-m-d h:i a');
                                    $ward['UserAdded'] = $this->user_id;
                                    $ward['DateModified'] = Carbon::now($this->zone)->format('Y-m-d h:i a');
                                    $ward['UserModified'] = $this->user_id;
                                    $ward['IsDeleted'] = 0;
                                    $ward['status'] = 'Occupied';
                                    if (!$check_bed_log) {
                                        $patient_bed_log = BedLog::create($ward);
                                        Bed::where('id', $bed_id)->update(['status' => 'Occupied']);
                                    } else {
                                        BedLog::where(['baby_id' => $baby_id, 'status' => 'Occupied'])->Update($ward);

                                        Bed::where('id', $check_bed_log->bed_id)->update(['status' => NULL]);

                                        Bed::where('id', $bed_id)->update(['status' => 'Occupied']);
                                    }
                                } else {
                                    $ward['status'] = 'Occupied';
                                    $ward['DateModified'] = Carbon::now($this->zone);
                                    $ward['UserModified'] = $this->user_id;
                                    BedLog::where('admission_id', $admission_id)->Update($ward);
                                }
                            }
                        }

                        if (isset($discharge_dtl['date']) && strtotime($discharge_dtl['date'])) {
                            $nicu['DischargeDate'] = date('Y-m-d', strtotime($discharge_dtl['date']));
                        }
                        if (isset($discharge_dtl['diedTime']) && strtotime($discharge_dtl['diedTime'])) {
                            $died_time = strtotime($discharge_dtl['diedTime']);
                            $nicu['diedTime'] = date('h', $died_time);
                            $nicu['diedMins'] = date('i', $died_time);
                            $nicu['diedAm'] = date('A', $died_time);
                        }
                        $nicu['DischargeWeight'] = $discharge_dtl['weight'] ?? null;
                        $nicu['OFC'] = $discharge_dtl['ofc'] ?? null;
                        $nicu['Length'] = $discharge_dtl['length'] ?? null;
                        $immunization = $discharge_dtl['immunization'] ?? null;
                        $nicu['Immunization'] = $immunization['status'] ?? null;
                        $nicu['Schedule'] = $immunization['schedule'] ?? null;
                        $vaccine_list = $immunization['vaccineList'] ?? [];
                        $vaccine_array = [];
                        $vaccine_date_array = [];
                        $i = 0;
                        foreach ($vaccine_list as $vaccine_value) {
                            $vaccine = $vaccine_value['vaccineId'];
                            $vaccine_date = null;
                            if (isset($vaccine_value['date']) && strtotime($vaccine_value['date'])) {
                                $vaccine_date = date('d-m-Y', strtotime($vaccine_value['date']));
                            }
                            $vaccine_array[$i] = $vaccine;
                            $vaccine_date_array[$i] = $vaccine_date;
                            $i++;
                        }
                        $nicu['Vaccine'] = count($vaccine_array) > 0 ? json_encode($vaccine_array) : null;
                        $nicu['VaccineDate'] = count($vaccine_date_array) > 0 ? json_encode($vaccine_date_array) : null;
                        $nicu['additional_information'] = $discharge_dtl['additionalInformation'] ?? null;
                        $nicu['Eyes'] = $discharge_dtl['eyes'] ?? null;
                        $nicu['cardiacmurmur'] = $discharge_dtl['cardiacMurmur'] ?? null;
                        $nicu['PostductalSaturation'] = $discharge_dtl['postductalSaturation'] ?? null;
                        $nicu['discharge_femoral_pulses'] = $discharge_dtl['femoralPulses'] ?? null;
                        $nicu['Hips'] = $discharge_dtl['hips'] ?? null;
                        $nicu['gentila'] = $discharge_dtl['genitalia'] ?? null;
                        $nicu['gentila_findings'] = $discharge_dtl['genitaliaFindings'] ?? null;
                        $nicu['nicu_malformation'] = $discharge_dtl['malformation'] ?? null;
                        $nicu['nicu_malformation_details'] = $discharge_dtl['malformationDetails'] ?? null;
                        $nicu['FeedingAtDischarge'] = $discharge_dtl['feeding'] ?? null;
                        $nicu['NeurologicalStatus'] = $discharge_dtl['neurologicalStatus'] ?? null;
                        $next_appointment = $discharge_dtl['nextAppointment'] ?? null;
                        $nicu['NextAppointmentStatus'] = $next_appointment['status'] ?? null;
                        if (isset($next_appointment['dateTime']) && strtotime($next_appointment['dateTime'])) {
                            $next_appointment_time = strtotime($next_appointment['dateTime']);
                            $nicu['NextAppointment'] = date('Y-m-d', $next_appointment_time);
                            $nicu['NAT_TIME'] = (int) date('h', $next_appointment_time);
                            $nicu['NAT_MINS'] = (int) date('i', $next_appointment_time);
                            $nicu['NAT_AM'] = date('A', $next_appointment_time);
                        }
                        $medications = $discharge_dtl['medications'] ?? [];
                        if (is_array($medications) && count($medications) > 0) {
                            $existing_list = Medications::select('Id')->where('AdmissionId', $admission_id)->get()->pluck('Id')->toArray();
                            foreach ($medications as $value) {
                                $dosage = $value['dosage'];
                                foreach ($dosage as $dosage_value) {
                                    $drug_id = $value['drugId'];
                                    $drug_result = DrugIvFluidMaster::findOrfail($drug_id);

                                    $existing = Medications::where([
                                        'Medication' => $drug_result->id,
                                        'route' => $value['route'],
                                        'Dose' => $dosage_value['dose'],
                                        'Frequency' => $dosage_value['frequency'],
                                        'Duration' => $dosage_value['duration'],
                                        'AdmissionId' => $admission_id,
                                        'BabyId' => $baby_id,
                                        'flag' => 2
                                    ])->first();

                                    if ($existing) {
                                        $exist_key = array_search($existing->Id, $existing_list);
                                        if ($exist_key !== false) {
                                            unset($existing_list[$exist_key]);
                                        }
                                        continue;
                                    }

                                    $discharge_medications = array(
                                        'Medication' => $drug_result->id,
                                        'genericname' => $drug_result->generic_pharmacological_name,
                                        'formulation' => (isset($drug_result->id) && !empty($drug_result->id)) ? $drug_result->id : null,
                                        // 'route'         => $value['route'],
                                        'Dose' => $dosage_value['dose'],
                                        'Frequency' => $dosage_value['frequency'],
                                        'Duration' => $dosage_value['duration'],
                                        'flag' => 2,
                                        'AdmissionId' => $admission_id,
                                        'BabyId' => $baby_id,
                                        'source_id' => 0,
                                        'additional_instruction' => $dosage_value['additionalInstruction']
                                    );
                                    Medications::create($discharge_medications);
                                }
                            }
                            Medications::whereIn('Id', $existing_list)->delete();
                        }
                        $checklist = $discharge_dtl['checklist'] ?? null;
                        $blood_test = $checklist['bloodTest'] ?? null;
                        $nicu['DischargeHb'] = $blood_test['hb'] ?? null;
                        $nicu['DischargePCV'] = $blood_test['pcv'] ?? null;
                        $nicu['NicuDCT'] = $blood_test['dct'] ?? null;
                        $nicu['DischargeTSB'] = $blood_test['tsb'] ?? null;
                        $nicu['direct_bilirubin'] = $blood_test['directBilirubin'] ?? null;
                        $nicu['DischargeSerumCa'] = $blood_test['serumCa'] ?? null;
                        $nicu['DischargeSerumPo4'] = $blood_test['serumPo4'] ?? null;
                        $nicu['DischargeSerumALP'] = $blood_test['serumALP'] ?? null;
                        $nicu['DischargeSerumNa'] = $blood_test['serumNa'] ?? null;
                        $nicu['HomeOxygen'] = $blood_test['homeOxygen'] ?? null;
                        $cranial_ultrasound = $blood_test['cranialUltrasound'] ?? null;
                        $nicu['discharge_cuss'] = $cranial_ultrasound['status'] ?? null;
                        $nicu['cranial_ultrasound'] = $cranial_ultrasound['condition'] ?? null;
                        $echo_cardiography = $blood_test['echoCardiography'] ?? null;
                        $nicu['echocardiography_status'] = $echo_cardiography['status'] ?? null;
                        $nicu['echocardiography'] = $echo_cardiography['condition'] ?? null;
                        $nicu['NicuNewBornScreen'] = $checklist['newBornScreen'] ?? null;
                        $hearing_screening = $checklist['hearingScreening'] ?? null;
                        $nicu['HearingScreening'] = $hearing_screening['status'] ?? null;
                        $nicu['oae_left'] = $hearing_screening['oae']['left'] ?? null;
                        $nicu['oae_right'] = $hearing_screening['oae']['right'] ?? null;
                        $nicu['abr_left'] = $hearing_screening['abr']['left'] ?? null;
                        $nicu['abr_right'] = $hearing_screening['abr']['right'] ?? null;
                        $rop_screening = $checklist['ropScreening'] ?? null;
                        $nicu['RopScreening'] = $rop_screening['status'] ?? null;
                        $rop_result = $rop_screening['result'] ?? null;
                        $nicu['result_rop_left'] = $rop_result['left'] ?? null;
                        $nicu['result_rop_right'] = $rop_result['right'] ?? null;
                        $rop_treatment = $checklist['ropTreatment'] ?? null;
                        $nicu['ROPTreatment'] = $rop_treatment['status'] ?? null;
                        $rop_treatment_type = $rop_treatment['type'] ?? null;
                        $rop_treatment_type_left = $rop_treatment_type['left'] ?? null;
                        if (is_array($rop_treatment_type_left)) {
                            $rop_treatment_type_left_list = collect($rop_treatment_type_left)->pluck('treatment')->toArray();
                            $nicu['typeoftreatment_left'] = json_encode($rop_treatment_type_left_list);
                        }
                        $rop_treatment_type_right = $rop_treatment_type['right'] ?? null;
                        if (is_array($rop_treatment_type_right)) {
                            $rop_treatment_type_right_list = collect($rop_treatment_type_right)->pluck('treatment')->toArray();
                            $nicu['typeoftreatment_right'] = json_encode($rop_treatment_type_right_list);
                        }
                        $nicu['rop_follow_up'] = $checklist['ropFollowUp'] ?? null;
                        $procedures = $checklist['procedures'] ?? [];
                        if (is_array($procedures)) {
                            $procedures_list = collect($procedures)->pluck('name')->toArray();
                            $nicu['procedures'] = json_encode($procedures_list);
                        }
                        $nicu['hospital_acquired_infection'] = $checklist['hospitalAcquiredInfection'] ?? null;
                        $nicu['ventilator_associated_pneumonia'] = $checklist['ventilatorAssociatedPneumonia'] ?? null;
                        $nicu['blood_stream_infections'] = $checklist['bloodStreamInfections'] ?? null;
                        $nicu['advice'] = $checklist['advice'] ?? null;
                        $nicu['plan_follow_up'] = $checklist['planFollowUp'] ?? null;
                        $nicu['DateModified'] = Carbon::now($this->zone);
                        $nicu['UserModified'] = $this->user_id;
                        $results1 = Nicu::findOrfail($nicu_id);
                        $results1->update($nicu);

                        if (isset($nicu['NextAppointmentStatus']) && $nicu['NextAppointmentStatus'] == true && (isset($nicu['NextAppointment']) && !is_null($nicu['NextAppointment']) && !empty($nicu['NextAppointment'])) && $nicu_id != 0) {
                            $appointment_details = new Request([
                                'category' => 'Review Appointment',
                                'date' => $nicu['NextAppointment'],
                                'time' => $nicu['NAT_TIME'],
                                'mins' => $nicu['NAT_MINS'],
                                'session' => $nicu['NAT_AM'],
                                'patient' => $baby_id,
                                'ref_id' => $nicu_id,
                                'from' => 4
                            ]);
                            FlowController::patientDetailUpdate($appointment_details, 0);
                        }

                        $baby_admission = Admission::getBaby($baby_id);

                        if ($baby_admission->Status == 'Transferred' && $results1->status == 'Transferred') {
                            $baby_admission->Status = 'Transferred';
                            $nicu_discharge_status = Admission::find($baby_admission->AdmissionId);
                            $baby_admission = (array) $baby_admission;
                            $nicu_discharge_status->Update($baby_admission);
                        } elseif ($results1->status == 'Discharged') {
                            $baby_admission->Status = 'Discharged';
                            $nicu_discharge_status = Admission::find($baby_admission->AdmissionId);
                            $baby_admission = (array) $baby_admission;
                            $nicu_discharge_status->Update($baby_admission);
                        }

                        if ($nicu['status'] != 'Inpatient' && $nicu['status'] != 'Transferred') {
                            $postnatalStatus['discharge_status'] = $nicu['status'];
                            $postnatalDischarge = PostnatalDischarge::where('BabyId', $baby_id)
                                ->where('AdmissionId', $results1->AdmissionId)
                                ->Update($postnatalStatus);
                            $neonatalDischarge['Status'] = $nicu['status'];
                            $neonatalDischarge['DateModified'] = Carbon::now($this->zone);
                            $neonatalDischarge['UserModified'] = $this->user_id;
                            Neonatal::where('BabyId', $baby_id)->Update($neonatalDischarge);
                        }

                        $newborn_data['BabyId'] = $baby_id;
                        $newborn_data['MotherId'] = $mother_id;
                        $newborn_data['Eyes'] = $nicu['Eyes'];
                        $newborn_data['Hips'] = $nicu['Hips'];

                        $newborn = NicuNewborn::find($baby_id);
                        if ($newborn) {
                            $newborn_data['DateModified'] = Carbon::now($this->zone)->format('Y-m-d h:i a');
                            $newborn_data['UserModified'] = $this->user_id;
                            $newborn->update($newborn_data);
                        } else {
                            $newborn_data['DateAdded'] = Carbon::now($this->zone)->format('Y-m-d h:i a');
                            $newborn_data['UserAdded'] = $this->user_id;
                            NicuNewborn::create($newborn_data);
                        }

                        $ip_number_old = IpNumber::getCurrent_ip($baby_id, $results1->AdmissionId);
                        $ip_data['baby_id'] = $baby_id;
                        $ip_data['ip_number'] = $visit_number;
                        $ip_data['status'] = 1;
                        $ip_data['AdmissionId'] = $results1->AdmissionId;
                        if (count($ip_number_old) > 0) {
                            $ip_data['DateModified'] = Carbon::now($this->zone);
                            $update_ip = IpNumber::findOrfail($ip_number_old->id);
                            $update_ip->update($ip_data);
                        } else {
                            $ip_data['DateAdded'] = Carbon::now($this->zone);
                            $ip_data['DateModified'] = Carbon::now($this->zone);
                            if ($visit_number != '' && !is_null($visit_number)) {
                                IpNumber::create($ip_data);
                            }
                        }

                        \SiteHelpers::updateDashboardAtFormUpdation($baby_id, 'NICU Discharge Form');


                    } else {
                        return \Response::json(['type' => 'failure', 'message' => 'No NICU admission found'], 500);
                    }

                } else {
                    return \Response::json(['type' => 'failure', 'message' => 'No admission found'], 500);
                }

            }
            return true;
        }
        return false;
    }

    public function storeTranscribedNicuAdmissionData(Request $request)
    {
        $input = $request->all();
        if (!isset($input['baby']['uhid']) && !isset($input['uhid'])) {
            return \Response::json(['type' => 'success', 'message' => 'UHID is missing'], 500);
        }
        if ($this->createUpdateNicuAdmission($input)) {
            return \Response::json(['type' => 'success', 'message' => 'NICU admission details updated'], 200);
        } else {
            return \Response::json(['type' => 'success', 'message' => 'error while store the NICU admission details'], 500);
        }
    }

    public function createUpdateNicuAdmission($input)
    {
        $baby_data_input = $input['baby'] ?? [];
        $referred_by = $input['referredBy'] ?? null;
        $referral_reason = $input['referralReason'] ?? null;
        $admission_input = $input['admission'] ?? [];
        $medical_history = $input['medicalHistory'] ?? [];
        $pregnancy = $input['pregnancy'] ?? [];
        $baby_details = $input['babyDetails'] ?? [];
        $admission_details = $input['admissionDetails'] ?? [];
        $procedures = $input['procedures'] ?? [];
        $crib_2 = $input['crib_2'] ?? [];
        $snappe_2 = $input['snappe_2'] ?? [];
        $diagnosis = $input['diagnosis'] ?? [];

        $uhid = $baby_data_input['uhid'] ?? $input['uhid'];
        $baby_details_params = $input;
        $baby_details_params['uhid'] = $uhid;
        $baby_results = $this->createUpdateBabyDetails($baby_details_params);

        if ($baby_results) {
            $baby_id = $baby_results->BabyId;
            $mother_id = $baby_results->MotherId;

            // Update Baby details
            $baby_upd['BabyName'] = $baby_data_input['name'] ?? $baby_results->BabyName;
            $baby_upd['DOB'] = !empty($baby_data_input['dob']) ? date('Y-m-d', strtotime($baby_data_input['dob'])) : $baby_results->DOB;
            $baby_upd['BirthWeight'] = $baby_data_input['birthWeight'] ?? $baby_results->BirthWeight;
            $baby_upd['BirthStatus'] = $baby_data_input['birthStatus'] ?? $baby_results->BirthStatus;
            $gestation = $baby_data_input['gestation'] ?? null;
            if ($gestation) {
                $baby_upd['Gestation'] = json_encode(array('g_weeks' => $gestation['weeks'], 'g_days' => $gestation['days']));
            }
            $baby_upd['BabyBloodGroup'] = $baby_data_input['bloodGroup'] ?? $baby_results->BabyBloodGroup;
            $baby_upd['Sex'] = $baby_data_input['sex'] ?? $baby_results->Sex;
            $baby_upd['DateModified'] = Carbon::now($this->zone);
            $baby_upd['UserModified'] = $this->user_id;
            Baby::where('BabyId', $baby_id)->update($baby_upd);

            // Admission Record (episodes)
            $visit_number = $admission_input['visitNumber'] ?? null;
            $admission_date = !empty($admission_input['admissionDate']) ? Carbon::parse($admission_input['admissionDate']) : Carbon::now($this->zone);

            $existing_admission = Admission::where('BabyId', $baby_id)->where('Status', 'Inpatient')->orderBy('AdmissionId', 'desc')->first();

            if (!$existing_admission) {
                $episodes = Admission::where('BabyId', $baby_id)->count() + 1;
                $admission_data_record = array(
                    'BabyId' => $baby_id,
                    'BMrNo' => $uhid,
                    'MotherId' => $mother_id,
                    'AdmissionDate' => $admission_date,
                    'AdmissionTime' => $admission_date->format('g:i:A'),
                    'InOrOut' => ($baby_upd['BirthStatus'] == 'Inborn') ? 'In' : 'Out',
                    'AdmissionType' => 'NICU',
                    'Status' => "Inpatient",
                    'UserAdded' => $this->user_id,
                    'DateAdded' => Carbon::now($this->zone),
                    'DateModified' => Carbon::now($this->zone),
                    'episodes' => 'Admission ' . $episodes,
                );
                $existing_admission = Admission::create($admission_data_record);
            } else {
                $existing_admission->update(['AdmissionType' => 'NICU', 'Status' => 'Inpatient']);
            }
            $admission_id = $existing_admission->AdmissionId;

            // IP Number
            if ($visit_number) {
                $ip_number_old = IpNumber::getCurrent_ip($baby_id, $admission_id);
                $ip_data['baby_id'] = $baby_id;
                $ip_data['ip_number'] = $visit_number;
                $ip_data['status'] = 1;
                $ip_data['AdmissionId'] = $admission_id;
                if ($ip_number_old) {
                    \App\Models\IpNumber::where('id', $ip_number_old->id)->update($ip_data);
                } else {
                    $ip_data['DateAdded'] = Carbon::now($this->zone);
                    $ip_data['DateModified'] = Carbon::now($this->zone);
                    IpNumber::create($ip_data);
                }
            }

            // NICU Admission record
            $nicu_data = array();
            $nicu_data['BabyId'] = $baby_id;
            $nicu_data['MotherId'] = $mother_id;
            $nicu_data['BMrNo'] = $uhid;
            $nicu_data['AdmissionId'] = $admission_id;
            $nicu_data['AdmissionDate'] = $admission_date->format('Y-m-d');
            $nicu_data['AdmissionTime'] = $admission_date->format('g:i:A');
            $nicu_data['TypeOfCare'] = $admission_input['typeOfCare'] ?? null;
            $nicu_data['AdmissionWt'] = $admission_input['admissionWt'] ?? null;
            $nicu_data['Surgeon'] = $admission_input['surgeon'] ?? null;
            $nicu_data['hospital_name'] = $admission_input['hospitalName'] ?? null;
            $seen_by = $admission_input['seenBy'] ?? null;
            if (is_array($seen_by)) {
                $nicu_data['SeenBy'] = json_encode(collect($seen_by)->pluck('id')->toArray());
            }

            $nicu_data['ReferredBy'] = $referred_by;
            $nicu_data['ReferralReason'] = $referral_reason;

            $nicu_data['Smoking'] = $medical_history['smoking'] ?? 'No';
            $nicu_data['Alcohol'] = $medical_history['alcohol'] ?? 'No';
            $nicu_data['Tobacco'] = $medical_history['tobacco'] ?? 'No';

            $nicu_data['DescriptionOfResuscitation'] = $baby_details['descriptionOfResuscitation'] ?? null;
            $nicu_data['VentilationRequired'] = $baby_details['ventilationRequired'] ?? 'No';
            $nicu_data['SurfactantGiven'] = $baby_details['surfactantGiven'] ?? 'No';
            $nicu_data['SurfactantType'] = $baby_details['surfactantType'] ?? null;
            $nicu_data['Dose'] = $baby_details['dose'] ?? null;
            $nicu_data['DateofAdministration'] = !empty($baby_details['dateofAdministration']) ? date('Y-m-d', strtotime($baby_details['dateofAdministration'])) : null;
            $nicu_data['AgeAfterBirth'] = $baby_details['ageAfterBirth'] ?? null;
            $nicu_data['delivery_cpap'] = $baby_details['deliveryCpap'] ?? 'No';
            $nicu_data['air_flow'] = $baby_details['airFlow'] ?? null;
            $nicu_data['oxgen_flow'] = $baby_details['oxgenFlow'] ?? null;
            $nicu_data['TransferFiO2'] = $baby_details['transferFiO2'] ?? null;

            $nicu_data['AdmittedFrom'] = $admission_details['admittedFrom'] ?? null;
            $nicu_data['MajorComplaints'] = $admission_details['majorComplaints'] ?? null;
            $nicu_data['Ventilation'] = $admission_details['ventilation'] ?? 'No';
            $nicu_data['Mode'] = $admission_details['mode'] ?? null;
            $nicu_data['nicu_retractions'] = $admission_details['retractions'] ?? null;
            $nicu_data['nicu_airentry'] = $admission_details['airEntry'] ?? null;
            $nicu_data['ChestMovement'] = $admission_details['chestMovement'] ?? null;
            $nicu_data['HR'] = $admission_details['hr'] ?? null;
            $nicu_data['systolic_bp'] = $admission_details['systolicBp'] ?? null;
            $nicu_data['diastolic_bp'] = $admission_details['diastolic_bp'] ?? null;
            $nicu_data['MeanBP'] = $admission_details['meanBP'] ?? null;
            $nicu_data['nicu_central_pulses'] = $admission_details['centralPulses'] ?? null;
            $nicu_data['nicu_peripheral_pulses'] = $admission_details['peripheralPulses'] ?? null;
            $nicu_data['nicu_femoral_pulses'] = $admission_details['femoralPulses'] ?? null;
            $nicu_data['nicu_s1s2'] = $admission_details['s1s2'] ?? null;
            $nicu_data['nicu_murmur'] = $admission_details['murmur'] ?? null;
            $nicu_data['CFT'] = $admission_details['cft'] ?? null;
            $nicu_data['nicu_color'] = $admission_details['color'] ?? null;
            $nicu_data['Temperature'] = $admission_details['temperature'] ?? null;
            $nicu_data['nicu_abdomen'] = $admission_details['abdomen'] ?? null;
            $nicu_data['nicu_bowel_sounds'] = $admission_details['bowelSounds'] ?? null;
            $nicu_data['nicu_umbilicus'] = $admission_details['umbilicus'] ?? null;
            $nicu_data['nicu_hepatomegaly'] = $admission_details['hepatomegaly'] ?? null;
            $nicu_data['nicu_splenomegaly'] = $admission_details['splenomegaly'] ?? null;
            $nicu_data['nicu_herina'] = $admission_details['herina'] ?? null;
            $nicu_data['nicu_genitalia'] = $admission_details['genitalia'] ?? null;
            $nicu_data['nicu_pupils'] = $admission_details['pupils'] ?? null;
            $nicu_data['nicu_anteriorfontanelle'] = $admission_details['anteriorFontanelle'] ?? null;
            $nicu_data['nicu_activity'] = $admission_details['activity'] ?? null;
            $nicu_data['nicu_cry'] = $admission_details['cry'] ?? null;
            $nicu_data['nicu_seizures'] = $admission_details['seizures'] ?? null;
            $nicu_data['nicu_neonatalreflexes'] = $admission_details['neonatalReflexes'] ?? null;
            $nicu_data['Abnormalities'] = $admission_details['abnormalities'] ?? null;
            $nicu_data['InitialBloodGas'] = $admission_details['initialBloodGas'] ?? null;
            $nicu_data['AgeTaken'] = $admission_details['ageTime'] ?? null;
            $nicu_data['SpO2'] = $admission_details['spo2'] ?? null;
            $nicu_data['BE'] = $admission_details['lactate'] ?? null; // Mapping lactate to BE as a POC? Usually Base Excess
            $nicu_data['RBS'] = $admission_details['rbs'] ?? null;
            $nicu_data['initial_assessment_completed_date'] = !empty($admission_details['initialAssessmentCompletedDateTime']) ? date('Y-m-d', strtotime($admission_details['initialAssessmentCompletedDateTime'])) : null;

            // Blood Gas Values
            $nicu_data['pH'] = $admission_details['ph'] ?? null;
            $nicu_data['PaO2'] = $admission_details['paO2'] ?? null;
            $nicu_data['PaCo2'] = $admission_details['paCo2'] ?? null;
            $nicu_data['HCO3'] = $admission_details['hco3'] ?? null;
            $nicu_data['Hct'] = $admission_details['hct'] ?? null;

            // Respiratory Settings
            $respiratory = $admission_details['respiratorySettings'] ?? [];
            $nicu_data['Pip'] = $respiratory['pip'] ?? null;
            $nicu_data['pip_set'] = $respiratory['pipSet'] ?? null;
            $nicu_data['PEEP'] = $respiratory['peep'] ?? null;
            $nicu_data['amplitude_delta'] = $respiratory['amplitudeDelta'] ?? null;
            $nicu_data['mean_airway_pressure'] = $respiratory['meanAirwayPressure'] ?? null;
            $nicu_data['map'] = $respiratory['map'] ?? null;
            $nicu_data['Fio2'] = $respiratory['fiO2'] ?? null;
            $nicu_data['fio2_set'] = $respiratory['fiO2Set'] ?? null;
            $nicu_data['Rate'] = $respiratory['rate'] ?? null;
            $nicu_data['frequency'] = $respiratory['frequency'] ?? null;
            $nicu_data['IT'] = $respiratory['it'] ?? null;
            $nicu_data['Flow_l_min'] = $respiratory['flowLMin'] ?? null;
            $nicu_data['RR'] = $respiratory['rr'] ?? null;
            $nicu_data['ratio'] = $respiratory['ratio'] ?? null;

            $nicu_data['InitialXray'] = $procedures['initialxray'] ?? null;
            $nicu_data['UAC'] = $procedures['uac']['status'] ?? 'No';
            $nicu_data['UACPosition'] = $procedures['uac']['position'] ?? null;
            $nicu_data['UVC'] = $procedures['uvc']['status'] ?? 'No';
            $nicu_data['UVCPosition'] = $procedures['uvc']['position'] ?? null;
            $nicu_data['SepsisScreen'] = $procedures['sepsisScreen'] ?? 'No';
            $nicu_data['Indications'] = $procedures['indications'] ?? null;
            $nicu_data['investigations_test'] = $procedures['investigationsTest'] ?? null;
            $nicu_data['Investigations'] = $procedures['investigations'] ?? null;
            $nicu_data['NBM'] = ($procedures['enteralFeeding'] ?? 'No') == 'Yes' ? 'No' : 'Yes';
            $nicu_data['Fluids'] = $procedures['fluids'] ?? null;

            $nicu_data['SexBirthWtGestation'] = $crib_2['sexBirthWtGestation'] ?? null;
            $nicu_data['BaseExcess'] = $crib_2['baseExcess'] ?? null;

            $nicu_data['MBP'] = $snappe_2['mbp'] ?? null;
            $nicu_data['LowestTemperature'] = $snappe_2['lowestTemperature'] ?? null;
            $nicu_data['Po2Fio2Ratio'] = $snappe_2['po2Fio2Ratio'] ?? null;
            $nicu_data['LowestSerumPh'] = $snappe_2['lowestSerumPh'] ?? null;
            $nicu_data['MultipleSeizures'] = $snappe_2['multipleSeizures'] ?? null;
            $nicu_data['UrineOutput'] = $snappe_2['urineOutput'] ?? null;
            $nicu_data['BWeight'] = $snappe_2['bWeight'] ?? null;
            $nicu_data['SgaLessThan3rdPercentile'] = $snappe_2['smallForGestationalAge'] ?? null;
            $nicu_data['Apgar5Mins'] = $snappe_2['apgar5Mins'] ?? null;

            $nicu_data['DifferentialDiagnosis'] = json_encode($diagnosis['differentialDiagnosis'] ?? []);
            $nicu_data['additional_diagnosis'] = json_encode($diagnosis['additionalDiagnosis'] ?? []);
            $nicu_data['Plan'] = $diagnosis['plan'] ?? null;
            $nicu_data['ParentsSpokenTo'] = $diagnosis['parentsSpokenTo'] ?? 'No';
            $nicu_data['DiscussionTime'] = $diagnosis['timeOfDiscussion'] ?? null;
            $nicu_data['MattersDiscussed'] = $diagnosis['mattersDiscussed'] ?? null;
            $nicu_data['ParentsAddressedBy'] = $diagnosis['parentsAddressedBy'] ?? null;
            $nicu_data['indication_of_admission'] = json_encode($diagnosis['indicationOfAdmission'] ?? []);
            $nicu_data['indication_of_admission_other'] = $diagnosis['indicationOfAdmissionOther'] ?? null;

            $nicu_data['Vaccine'] = isset($admission_details['vaccine']) ? json_encode(collect($admission_details['vaccine'])->pluck('name')->toArray()) : null;
            $nicu_data['VaccineDate'] = isset($admission_details['vaccine']) ? json_encode(collect($admission_details['vaccine'])->pluck('date')->toArray()) : null;
            $nicu_data['rop_follow_up'] = $admission_details['ropFollowUp'] ?? null;
            $nicu_data['NextAppointmentStatus'] = $admission_details['nextAppointmentStatus'] ?? 'No';
            $nicu_data['NextAppointment'] = !empty($admission_details['nextAppointment']) ? date('Y-m-d', strtotime($admission_details['nextAppointment'])) : null;
            $nicu_data['diedTime'] = $admission_details['diedTime'] ?? null;
            $nicu_data['diedMins'] = $admission_details['diedMins'] ?? null;
            $nicu_data['TypeofTreatmen'] = json_encode($procedures['treatmentType'] ?? []);
            $nicu_data['typeoftreatment_left'] = json_encode($procedures['treatmentTypeLeft'] ?? []);
            $nicu_data['typeoftreatment_right'] = json_encode($procedures['treatmentTypeRight'] ?? []);

            $nicu_data['status'] = 'Inpatient';
            $nicu_data['form_status'] = 1;
            $nicu_data['DateModified'] = Carbon::now($this->zone);
            $nicu_data['UserModified'] = $this->user_id;

            $prev_nicu_admission = Nicu::where('status', 'Inpatient')->where('IsDeleted', 0)->where('BabyId', $baby_id)->orderBy('NicuId', 'desc')->first();

            if (!$prev_nicu_admission) {
                $nicu_data['DateAdded'] = Carbon::now($this->zone);
                $nicu_data['UserAdded'] = $this->user_id;
                $nicu = Nicu::create($nicu_data);
            } else {
                $prev_nicu_admission->update($nicu_data);
                $nicu = $prev_nicu_admission;
            }

            // Newborn Examination
            $newborn_data = $nicu_data;
            unset($newborn_data['AdmissionId']);
            $newborn = NicuNewborn::find($baby_id);
            if ($newborn) {
                $newborn->update($newborn_data);
            } else {
                $newborn_data['DateAdded'] = Carbon::now($this->zone);
                $newborn_data['UserAdded'] = $this->user_id;
                NicuNewborn::create($newborn_data);
            }

            // Problems
            $problems = $medical_history['medicalProblems'] ?? [];
            Problems::where('BabyId', $baby_id)->delete();
            foreach ($problems as $p) {
                Problems::create([
                    'Problem' => $p['problemsId'],
                    'Medication' => $p['medications'],
                    'MotherId' => $mother_id,
                    'BabyId' => $baby_id
                ]);
            }

            // Complications
            $complications = $pregnancy['complication'] ?? [];
            Complication::where('BabyId', $baby_id)->delete();
            foreach ($complications as $c) {
                Complication::create([
                    'Complication' => $c['complicationId'],
                    'Treatment' => $c['treatment'],
                    'AdmissionId' => $admission_id,
                    'BabyId' => $baby_id,
                    'flags' => 2
                ]);
            }

            // USG Scans
            Usg::where('BabyId', $baby_id)->delete();
            // Dating Scan
            if ($pregnancy['datingScanDetails'] ?? null) {
                $ds = $pregnancy['datingScanDetails'];
                Usg::create([
                    'date' => !empty($ds['date']) ? date('Y-m-d', strtotime($ds['date'])) : null,
                    'Gestation' => $ds['gestation'],
                    'Finding' => $ds['findings'],
                    'MotherId' => $mother_id,
                    'BabyId' => $baby_id,
                    'flags' => 1,
                    'type' => 1
                ]);
            }
            // Anomaly Scan
            if ($pregnancy['anomalyScanDetails'] ?? null) {
                $as = $pregnancy['anomalyScanDetails'];
                Usg::create([
                    'date' => !empty($as['date']) ? date('Y-m-d', strtotime($as['date'])) : null,
                    'Gestation' => $as['gestation'],
                    'Finding' => $as['findings'],
                    'MotherId' => $mother_id,
                    'BabyId' => $baby_id,
                    'flags' => 1,
                    'type' => 2
                ]);
            }
            // Other Scans
            foreach ($pregnancy['otherScanDetails'] ?? [] as $os) {
                Usg::create([
                    'date' => !empty($os['date']) ? date('Y-m-d', strtotime($os['date'])) : null,
                    'Gestation' => $os['gestation'],
                    'Finding' => $os['findings'],
                    'MotherId' => $mother_id,
                    'BabyId' => $baby_id,
                    'flags' => 2,
                    'type' => 3
                ]);
            }
            // Doppler Scans
            foreach ($pregnancy['dopplerScanDetails'] ?? [] as $dop) {
                Usg::create([
                    'date' => !empty($dop['date']) ? date('Y-m-d', strtotime($dop['date'])) : null,
                    'Gestation' => $dop['gestation'],
                    'Finding' => $dop['findings'],
                    'MotherId' => $mother_id,
                    'BabyId' => $baby_id,
                    'flags' => 2,
                    'type' => 4
                ]);
            }

            // Bed Log
            $room_id = $admission_input['roomId'] ?? null;
            $bed_id = $admission_input['bedId'] ?? null;
            if ($room_id && $bed_id) {
                $check_bed_log = BedLog::where(['baby_id' => $baby_id, 'status' => 'Occupied'])->first();
                $ward = [
                    'ward_id' => 1,
                    'ward_name' => \SiteHelpers::gettable_values('ward', 'name', 'id', 1),
                    'room_id' => $room_id,
                    'room_no' => \SiteHelpers::gettable_values('room', 'number', 'id', $room_id),
                    'bed_id' => $bed_id,
                    'bed_no' => \SiteHelpers::gettable_values('bed', 'number', 'id', $bed_id),
                    'baby_id' => $baby_id,
                    'admission_id' => $admission_id,
                    'status' => 'Occupied',
                    'DateModified' => Carbon::now($this->zone),
                    'UserModified' => $this->user_id,
                    'IsDeleted' => 0
                ];
                Bed::where('id', $bed_id)->update(['status' => 'Occupied']);
                if (!$check_bed_log) {
                    $ward['DateAdded'] = Carbon::now($this->zone);
                    $ward['UserAdded'] = $this->user_id;
                    BedLog::create($ward);
                } else {
                    $check_bed_log->update($ward);
                }
            }

            // Antibiotics (IV Antibiotic field in Nicu Admission)
            $iv_antibiotics = $procedures['ivAntibiotic'] ?? [];
            if (is_array($iv_antibiotics)) {
                $nicu->update(['IVAntibiotic' => json_encode(collect($iv_antibiotics)->pluck('antibiotic')->toArray())]);
            }

            \SiteHelpers::updateDashboardAtFormUpdation($baby_id, 'NICU Admission');

            return true;
        }

        return false;
    }
    public function getNicuInpatientList()
    {
        return \Response::json(BedLog::getNicuInpatientBabyList(), 200);
    }

    public function getTodayOpBabyList()
    {
        $today = Carbon::now($this->zone)->format('Y-m-d');
        $results = Op::where('op_details.OpDate', $today)
            ->where('op_details.IsDeleted', 0)
            ->join('baby', 'op_details.BabyId', '=', 'baby.BabyId')
            ->select(
                'baby.BMrNo as uhid',
                'baby.BabyName as babyName',
                'baby.Sex as gender',
                'baby.DOB as birthDate',
                'op_details.OpId as visitId'
            )
            ->selectRaw("
                CASE 
                    WHEN g_weeks IS NOT NULL 
                    THEN CONCAT(g_weeks, ' + ', COALESCE(g_days, 0)) 
                    ELSE NULL 
                END as gestation
            ")
            ->orderBy('op_details.OpId', 'desc')
            ->get();

        return \Response::json($results, 200);
    }
    public function updateTwinBaby($mother_id, $dob, $type, $count)
    {
        Baby::where('MotherId', $mother_id)
            ->where('DOB', $dob)
            ->update([
                'MultiplePregnancy' => 'Yes',
                'MultiplePregnancyType' => $type,
                'Noofbabies' => $count
            ]);
    }
}
