<?php
namespace App\Models\Search;

use Illuminate\Database\Eloquent\Model;

use App\Http\Controllers\Search\SearchNicuadmissionSupport;
use App\Models\Search\SearchQueryLog;
use Carbon\Carbon;

class SearchNicuadmission extends Model
{
    protected $nicu_fields = ['BabyName', 'BMrNo', 'DOB', 'BirthWeight', 'BirthStatus', 'g_weeks', 'g_days', 'BabyBloodGroup', 'Sex', 'ReferredBy', 'ReferralReason', 'cg_weeks', 'cg_days', 'AdmissionDate', 'nicu_admission.AdmissionTime', 'nicu_admission.AdmissionTime_MINS', 'nicu_admission.AdmissionTime_AM', 'TypeOfCare', 'ip_number', 'AdmissionWt', 'AgeOnAdmissioninDays', 'AgeOnAdmissionhour', 'Surgeon', 'SeenBy', 'Smoking', 'Alcohol', 'Tobacco', 'DescriptionOfResuscitation', 'VentilationRequired', 'SurfactantGiven', 'SurfactantType', 'delivery_cpap', 'AdmittedFrom', 'MajorComplaints', 'Ventilation', 'Mode', 'nicu_retractions', 'nicu_airentry', 'ChestMovement', 'nicu_central_pulses', 'nicu_peripheral_pulses', 'nicu_femoral_pulses', 'nicu_s1s2', 'nicu_murmur', 'CFT', 'nicu_color', 'nicu_abdomen', 'nicu_bowel_sounds', 'nicu_umbilicus', 'nicu_hepatomegaly', 'nicu_splenomegaly', 'nicu_herina', 'nicu_genitalia', 'nicu_genitalia_findings', 'nicu_pupils', 'nicu_pupils_findings', 'nicu_anteriorfontanelle', 'nicu_activity', 'Tone', 'nicu_cry', 'nicu_seizures', 'nicu_neonatalreflexes', 'Skin', 'Abnormalities', 'InitialBloodGas', 'InitialXray', 'xrayfindings', 'AgeofCXR', 'UAC', 'UACPosition', 'UVC', 'UVCPosition', 'SepsisScreen', 'Indications', 'Investigations', 'NBM', 'Plan', 'ParentsSpokenTo', 'MattersDiscussed', 'ParentsAddressedBy', 'indication_of_admission_other', 'status', 'Immunization', 'Schedule', 'additional_information', 'Eyes', 'cardiacmurmur', 'discharge_femoral_pulses', 'Hips', 'gentila', 'gentila_findings', 'nicu_malformation', 'nicu_malformation_details', 'FeedingAtDischarge', 'NeurologicalStatus', 'NextAppointmentStatus', 'HomeOxygen', 'discharge_cuss', 'RopScreening', 'Rop', 'ROPTreatment', 'rop_follow_up', 'NeurologicalStatus', 'FeedingAtDischarge', 'Dose', 'AgeAfterBirth', 'air_flow', 'oxgen_flow', 'TransferFiO2', 'Pip', 'PEEP', 'amplitude_delta', 'mean_airway_pressure', 'Rate', 'IT', 'Fio2', 'Flow_l_min', 'RR', 'HR', 'BP', 'diastolic_bp', 'MeanBP', 'Temperature', 'AgeTaken', 'SpO2', 'pH', 'PaO2', 'PaCo2', 'HCO3', 'BE', 'RBS', 'Hct', 'SexBirthWtGestation', 'TemperatureAtAdmission', 'BaseExcess', 'TotalCRIB2Score', 'MBP', 'LowestTemperature', 'Po2Fio2Ratio', 'LowestSerumPh', 'MultipleSeizures', 'UrineOutput', 'BWeight', 'SgaLessThan3rdPercentile', 'Apgar5Mins', 'TotalSNAP2Score', 'TotalSNAPPE2Score', 'DateofAdministration', 'Fluids', 'DOLatDischarge', 'DischargeWeight', 'OFC', 'Length', 'PostductalSaturation', 'NextAppointment', 'DischargeHb', 'DischargePCV', 'NicuDCT', 'DischargeTSB', 'direct_bilirubin', 'DischargeSerumCa', 'DischargeSerumPo4', 'DischargeSerumALP', 'DischargeSerumNa', 'cranial_ultrasound', 'echocardiography_status', 'echocardiography', 'NicuNewBornScreen', 'HearingScreening', 'oae_left', 'oae_right', 'abr_left', 'abr_right', 'result_rop_left', 'result_rop_right', 'advice', 'plan_follow_up', 'dcg_weeks', 'dcg_days'];

    protected $nicuText = ['BabyName', 'BMrNo', 'ReferredBy', 'ReferralReason', 'ip_number', 'DescriptionOfResuscitation', 'MajorComplaints', 'Mode', 'nicu_genitalia_findings', 'nicu_pupils_findings', 'Skin', 'Abnormalities', 'xrayfindings', 'AgeofCXR', 'Indications', 'Investigations', 'Plan', 'MattersDiscussed', 'ParentsAddressedBy', 'indication_of_admission_other', 'additional_information', 'gentila_findings', 'nicu_malformation_details', 'SeenBy', 'UACPosition', 'UVCPosition', 'cranial_ultrasound', 'echocardiography', 'advice', 'plan_follow_up'];

    protected $nicuSelecttext = ['BabyBloodGroup', 'TypeOfCare', 'Sex', 'BirthStatus', 'Smoking', 'Alcohol', 'Tobacco', 'VentilationRequired', 'SurfactantGiven', 'SurfactantType', 'delivery_cpap', 'AdmittedFrom', 'Ventilation', 'nicu_retractions', 'nicu_airentry', 'ChestMovement', 'nicu_central_pulses', 'nicu_peripheral_pulses', 'nicu_s1s2', 'nicu_murmur', 'CFT', 'nicu_color', 'nicu_abdomen', 'nicu_bowel_sounds', 'nicu_umbilicus', 'nicu_hepatomegaly', 'nicu_splenomegaly', 'nicu_herina', 'nicu_genitalia', 'nicu_pupils', 'nicu_anteriorfontanelle', 'nicu_activity', 'Tone', 'nicu_cry', 'nicu_seizures', 'nicu_neonatalreflexes', 'InitialBloodGas', 'InitialXray', 'UAC', 'UVC', 'SepsisScreen', 'NBM', 'ParentsSpokenTo', 'status', 'Immunization', 'Schedule', 'Eyes', 'cardiacmurmur', 'nicu_femoral_pulses', 'Hips', 'gentila', 'nicu_malformation', 'FeedingAtDischarge', 'NeurologicalStatus', 'NextAppointmentStatus', 'HomeOxygen', 'discharge_cuss', 'RopScreening', 'Rop', 'ROPTreatment', 'NeurologicalStatus', 'FeedingAtDischarge', 'MBP', 'LowestTemperature', 'Po2Fio2Ratio', 'LowestSerumPh', 'MultipleSeizures', 'UrineOutput', 'BWeight', 'SgaLessThan3rdPercentile', 'Apgar5Mins', 'echocardiography_status', 'NicuNewBornScreen', 'HearingScreening', 'oae_left', 'oae_right', 'abr_left', 'abr_right', 'result_rop_left', 'result_rop_right', 'discharge_femoral_pulses'];

    protected $nicuNumbers = ['BirthWeight', 'g_weeks', 'g_days', 'cg_weeks', 'cg_days', 'AdmissionWt', 'AgeOnAdmissioninDays', 'AgeOnAdmissionhour', 'Dose', 'AgeAfterBirth', 'air_flow', 'oxgen_flow', 'TransferFiO2', 'Pip', 'PEEP', 'amplitude_delta', 'mean_airway_pressure', 'Rate', 'IT', 'Fio2', 'Flow_l_min', 'RR', 'HR', 'BP', 'diastolic_bp', 'MeanBP', 'Temperature', 'AgeTaken', 'SpO2', 'pH', 'PaO2', 'PaCo2', 'HCO3', 'BE', 'RBS', 'Hct', 'SexBirthWtGestation', 'TemperatureAtAdmission', 'BaseExcess', 'TotalCRIB2Score', 'TotalSNAP2Score', 'TotalSNAPPE2Score', 'Fluids', 'DOLatDischarge', 'DischargeWeight', 'OFC', 'Length', 'PostductalSaturation', 'DischargeHb', 'DischargePCV', 'NicuDCT', 'DischargeTSB', 'direct_bilirubin', 'DischargeSerumCa', 'DischargeSerumPo4', 'DischargeSerumALP', 'DischargeSerumNa', 'rop_follow_up', 'dcg_weeks', 'dcg_days'];

    protected $subFields = [];

    protected $dateFields = ['AdmissionDate', 'DOB', 'DateofAdministration', 'DischargeDate', 'NextAppointment'];

    protected $onoffFields = [];

    /**
     * This method to get array
     * of search for medical problem
     *
     * @var $medicalProblems
     */
    protected $medicalProblems = ['Problems', 'Medications'];

    /**
     * This method to get array
     * of search for Pregnancy Complication
     *
     * @var $pregnancyComplication
     */
    protected $pregnancyComplication = ['Complication', 'Treatments'];

    /**
     * This method to get array
     * of search for antenatal
     * ultrasound findings dating scan
     *
     * @var $ultrasound_dating_scan
     */
    protected $ultrasound_dating_scan = ['Gestation' => 'datinggestations', 'Finding' => 'datingfindings'];

    /**
     * This method to get array
     * of search for antenatal
     * ultrasound findings Anomaly Scan
     *
     * @var $ultrasound_anomaly_scan
     */
    protected $ultrasound_anomaly_scan = ['Gestation' => 'analoggestations', 'Finding' => 'analogfindings'];

    /**
     * This method to get array
     * of search for antenatal
     * ultrasound findings Anomaly Scan
     *
     * @var $ultrasound_anomaly_scan
     */
    protected $ultrasound_further_scan = ['Gestation' => 'othergestations', 'Finding' => 'otherfindings'];

    /**
     * This method to get array
     * of search for antenatal
     * ultrasound findings doppler Scan
     *
     * @var $ultrasound_doppler_scan
     */
    protected $ultrasound_doppler_scan = ['Gestation' => 'dopplergestations', 'Finding' => 'dopplerfindings'];

    /**
     * This method to get array
     * of search for antenatal
     * ultrasound findings doppler Scan
     *
     * @var $ultrasound_doppler_scan
     */
    protected $jsonValues = ['IVAntibiotic', 'DifferentialDiagnosis', 'additional_diagnosis', 'vaccine', 'TypeofTreatmen', 'indication_of_admission', 'Vaccine', 'VaccineDate', 'procedures', 'typeoftreatment_left', 'typeoftreatment_right'];

    /**
     * This method to get array
     * of search for antenatal
     * ultrasound findings doppler Scan
     *
     * @var $ultrasound_doppler_scan
     */
    protected $medication = ['M_Drugs', 'm_generic_name', 'formulation', 'M_Dose', 'M_Frequency', 'M_Duration'];

    /**
     * This method to get neonatal
     * pro forma search data
     *  1 or 2
     */
    protected $timevalues = ['admission_time', 'time_of_adminstration', 'discussion_time', 'died_time', 'next_time_appoinment'];
    // protected $timevalues = ['admission_time', 'time_of_adminstration', 'died_time', 'next_time_appoinment'];
    

    
    /**
     * This method to get neonatal
     * pro forma search data
     *  1 or 2
     */
    protected $time_setting = ['admission_time' => ['nicu_admission.AdmissionTime', 'nicu_admission.AdmissionTime_MINS', 'nicu_admission.AdmissionTime_AM'], 'time_of_adminstration' => ['TimeOfAdministration', 'TimeOfAdministration_MINS', 'TimeOfAdministration_AM'], 'DiscussionTime' => ['discussion_time'], 'died_time' => ['diedTime', 'diedMins', 'diedAm'], 'next_time_appoinment' => ['NAT_TIME', 'NAT_MINS', 'NAT_AM']];

    public function getList($page = 1, $limit = 5, $data = array(), $order = array())
    {
        $limitstart    = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend      = $limit;

        $otherFields = $filteredFields = $medical_problem = $pregnancy_complication = [];
        $ultrasound_dating_scan = $ultrasound_anomaly_scan = $ultrasound_further_scan = $ultrasound_doppler_scan = [];
        $jsonvalue = $discharge_medication = $time_values = [];
        //this for split the single value column
        unset($data["temp_Vaccine"]);
        unset($data["temp_drugs"]);

        foreach ($data as $key => $value)
        {

            if (isset($data[$key]) && !is_array($data[$key]) && !empty(trim($data[$key])))
            {

                $filteredFields[$key] = $value;

            }
            elseif (isset($data[$key]) && is_array($data[$key]))
            {
                foreach ($value as $key1 => $value1)
                {
                    if (!empty($value1) && $value1 != 'N/A')
                    {
                        $otherFields[$key][] = $value1;
                    }
                }

            }

        }

        // this for split the medical problems
        foreach ($this->medicalProblems as $key => $value)
        {
            if (isset($data[$value]) && is_array($data[$value]))
            {
                for ($problemIndex = 0;$problemIndex < count($data[$value]);$problemIndex++)
                {
                    if (!empty(trim($data[$value][$problemIndex])))
                    {
                        $temp_array['Problems'] = !empty($data['Problems'][$problemIndex]) ? $data['Problems'][$problemIndex] : 0;
                        $temp_array['Medications'] = isset($data['Medications'][$problemIndex]) ? $data['Medications'][$problemIndex] : '';
                        $medical_problem[] = $temp_array;
                    }
                }
            }
        }

        // This for pregnancy complications
        foreach ($this->pregnancyComplication as $complication_key => $complication_value)
        {
            if (isset($data[$complication_value]) && is_array($data[$complication_value]))
            {
                for ($complicationIndex = 0;$complicationIndex < count($data[$value]);$complicationIndex++)
                {
                    if (!empty(trim($data[$complication_value][$complicationIndex])))
                    {
                        $temp_array['Complication'] = (int)$data[$complication_value][$complicationIndex];
                        $temp_array['Treatment'] = isset($data['Treatments'][$complicationIndex]) ? $data['Treatments'][$complicationIndex] : '';
                        $temp_array['duration_in_weeks'] = (isset($data['duration_in_weeks'][$complicationIndex]) && $data['duration_in_weeks'][$complicationIndex] != '') ? $data['duration_in_weeks'][$complicationIndex] : '';
                        $temp_array['duration_unit'] = isset($data['duration_unit'][$complicationIndex]) ? $data['duration_unit'][$complicationIndex] : '';
                        $temp_array['complications.flags'] = 1;
                        $pregnancy_complication[] = $temp_array;
                    }
                }
            }
        }

        foreach ($this->medication as $medication_key => $medication_value)
        {
            $temp_array = [];
            if (isset($data[$medication_value]) && is_array($data[$medication_value]))
            {

                for ($medicationIndex = 0;$medicationIndex < count($data[$medication_value]);$medicationIndex++)
                {

                    if (!empty(trim($data[$medication_value][$medicationIndex])) && $data[$medication_value][$medicationIndex] != "N/A")
                    {
                        $temp_array['discharge_medications.Medication'] = (int)$data['M_Drugs'][$medicationIndex];
                        $temp_array['discharge_medications.genericname'] = isset($data['m_generic_name'][$medicationIndex]) ? $data['m_generic_name'][$medicationIndex] : '';
                        $temp_array['discharge_medications.formulation'] = (isset($data['formulation'][$medicationIndex]) && $data['formulation'][$medicationIndex] != '' && $data['formulation'][$medicationIndex] != 0) ? $data['formulation'][$medicationIndex] : '';
                        $temp_array['discharge_medications.Dose'] = (isset($data['M_Dose'][$medicationIndex]) && $data['M_Dose'][$medicationIndex] != '') ? $data['M_Dose'][$medicationIndex] : '';
                        $temp_array['discharge_medications.Frequency'] = (isset($data['M_Frequency'][$medicationIndex]) && $data['M_Frequency'][$medicationIndex] != '') ? $data['M_Frequency'][$medicationIndex] : '';
                        $temp_array['discharge_medications.Duration'] = (isset($data['M_Duration'][$medicationIndex]) && $data['M_Duration'][$medicationIndex] != '') ? $data['M_Duration'][$medicationIndex] : '';
                        $discharge_medication[] = $temp_array;
                    }
                }
            }
        }

        //This for ultra sound dating scan
        foreach ($this->ultrasound_dating_scan as $ultrasound_dating_key => $ultrasound_dating_value)
        {
            if (!empty($data[$ultrasound_dating_value]) && $data[$ultrasound_dating_value] != '')
            {
                $ultrasound_dating_scan[$ultrasound_dating_key] = $data[$ultrasound_dating_value];
            }
        }

        //This for ultra sound anomaly scan
        foreach ($this->ultrasound_anomaly_scan as $ultrasound_anomaly_key => $ultrasound_anomaly_value)
        {
            if (!empty($data[$ultrasound_anomaly_value]) && $data[$ultrasound_anomaly_value] != '')
            {
                $ultrasound_anomaly_scan[$ultrasound_anomaly_key] = $data[$ultrasound_anomaly_value];
            }
        }

        //This for ultra sound further scan
        foreach ($this->ultrasound_further_scan as $ultrasound_further_key => $ultrasound_further_value)
        {
            if (isset($data[$ultrasound_further_value]) && is_array($data[$ultrasound_further_value])) {
                foreach ($data[$ultrasound_further_value] as $scan_value)
                {
                    if (!empty($scan_value) && $scan_value != '')
                    {
                        $ultrasound_further_scan[$ultrasound_further_key][] = $scan_value;
                    }
                }
            }
        }

        //This for ultra sound doppler scan
        foreach ($this->ultrasound_doppler_scan as $ultrasound_doppler_key => $ultrasound_doppeler_value)
        {
            if (isset($data[$ultrasound_doppeler_value]) && is_array($data[$ultrasound_doppeler_value])) {
                foreach ($data[$ultrasound_doppeler_value] as $doppler_scan)
                {
                    if (!empty($doppler_scan) && $doppler_scan != '') $ultrasound_doppler_scan[$ultrasound_doppler_key][] = $doppler_scan;
                }
            }

        }

        //This for json values
        foreach ($this->jsonValues as $jsonValues_key => $jsonValues_value)
        {
            if (isset($data[$jsonValues_value]))
            {
                foreach ($data[$jsonValues_value] as $json_drugs)
                {
                    if (!empty($json_drugs) && $json_drugs != '' && $json_drugs != 'N/A')
                    {
                        $jsonvalue[$jsonValues_value][] = $json_drugs;
                    }
                }
            }
        }

        foreach ($this->timevalues as $timevalues_key => $timevalues_value)
        {
            if (isset($data[$timevalues_value]) && $data[$timevalues_value] != '' && !empty($timevalues_value))
            {

                $time_values[$timevalues_value] = $data[$timevalues_value];
            }

        }

        $nicuText = $this->nicuText;

        $nicuNumbers = $this->nicuNumbers;

        $subFields = array_keys($this->subFields);

        $nicuSelecttext = $this->nicuSelecttext;

        $dateFields = $this->dateFields;

        $onoffFields = array_keys($this->onoffFields);

        $time_fields = $this->timevalues;

        $results = array();
        
        if (count($filteredFields) > 0 || count($otherFields) > 0 || count($medical_problem) > 0 || count($pregnancy_complication) > 0 || count($ultrasound_dating_scan) > 0 || count($ultrasound_anomaly_scan) > 0 || count($ultrasound_further_scan) > 0 || count($ultrasound_doppler_scan) > 0 || count($discharge_medication) > 0 || count($jsonvalue) > 0 || count($medical_problem) > 0 || count($pregnancy_complication) > 0 ||  count($time_values) > 0) {

            \DB::enableQueryLog();

            $result = \DB::table('nicu_admission')
            ->select(\DB::raw('DISTINCT ON("nicu_admission"."NicuId") "nicu_admission"."NicuId"'))
            ->leftjoin('baby', 'baby.BabyId', '=', 'nicu_admission.BabyId')
            ->leftjoin('baby_admission', 'baby_admission.AdmissionId', '=', 'nicu_admission.AdmissionId')
            ->leftjoin('medical_problems', function ($join) {
                $join->orOn('baby.BabyId', '=', 'medical_problems.BabyId');
            })
            ->leftjoin('complications', function ($join) {
                $join->orOn('baby.BabyId', '=', 'complications.BabyId');
            })
            ->leftjoin('usg_finding', function ($join) {
                $join->orOn('baby.BabyId', '=', 'usg_finding.BabyId');
            })
            ->leftjoin('discharge_medications', function ($join) {
                $join->orOn('baby.BabyId', '=', 'discharge_medications.BabyId');
            })
            ->leftjoin('ip_numbers', function ($join) {
                $join->orOn('baby.BabyId', '=', 'ip_numbers.baby_id');
            })
            ->where(['baby.IsDeleted' => '0', 'nicu_admission.IsDeleted' => 0, 'baby_admission.AdmissionType' => 'NICU'])
            ->where(function ($query) use ($nicuText, $nicuNumbers, $dateFields, $onoffFields, $subFields, $nicuSelecttext, $time_fields, $filteredFields, $otherFields, $medical_problem, $ultrasound_dating_scan, $ultrasound_anomaly_scan, $ultrasound_further_scan, $ultrasound_doppler_scan, $discharge_medication, $jsonvalue, $pregnancy_complication, $time_values)
            {

                foreach ($filteredFields as $field => $fieldValue)
                {

                    if (in_array($field, $nicuText))
                    {
                        $condition = preg_replace('/[A-Z,a-z,0-9,\/,_,-]/', '', trim($fieldValue));
                        $formatedText = str_replace(trim($condition) , '', $fieldValue);
                        $query = $this->textsearch($field, $condition, $formatedText, $query, $fieldValue);
                    }
                    elseif (in_array($field, $nicuSelecttext))
                    {
                        $condition = preg_replace('/[A-Z,a-z,0-9,\/,-]/', '', trim($fieldValue));
                        $formatedText = str_replace(trim($condition) , '', $fieldValue);
                        $query = $this->textsearch($field, $condition, $formatedText, $query, $fieldValue);

                    }
                    elseif (in_array($field, $nicuNumbers))
                    {
                        $condition = preg_replace('/[0-9,-]/', '', trim($fieldValue));
                        $formatedText = str_replace(trim($condition) , '', $fieldValue);
                        $query = $this->numbersearch($field, $condition, $formatedText, $query, $fieldValue);

                    }
                    elseif (in_array($field, $dateFields))
                    {
                        $condition = preg_replace('/[0-9,-,\/,:]/', '', trim($fieldValue));
                        $formatedText = str_replace(trim($condition) , '', $fieldValue);
                        $query = $this->datesearch($field, $condition, $formatedText, $query, $fieldValue);

                    }

                }

                    //medical problems
                if (count($medical_problem) > 0)
                {
                    foreach ($medical_problem as $medical_problem_key => $medical_problem_value)
                    {
                            // $medical_problem_index = 0;
                        foreach ($medical_problem_value as $list_key => $list_value)
                        {
                            $operator = preg_replace('/[A-Z,a-z,0-9,-,\/,:]/', '', trim($list_value));
                            $un_splited_value = $list_value;
                            $list_value = str_replace(trim($operator) , '', $list_value);
                            if ($list_key == 'Problems' && trim($list_value) != '')
                            {

                                $list_key = 'medical_problems.Problem';
                                $query->where($list_key, $list_value);

                            }
                            elseif ($list_key == 'Medications' && $list_value != "")
                            {

                                $list_key = 'medical_problems.Medication';
                                $query = $this->textsearch($list_key, $operator, $list_value, $query, $un_splited_value);

                            }
                        }
                    }
                }

                    //pregnanacy complication
                if (count($pregnancy_complication) > 0)
                {
                    foreach ($pregnancy_complication as $complication_key => $complication_value)
                    {
                        foreach ($complication_value as $complication_value_key => $complication_value_values)
                        {

                            $operator = preg_replace('/[A-Z,a-z,0-9,-,\/,:]/', '', trim($complication_value_values));
                            $un_splited_value = $complication_value_values;
                            $complication_value_values = str_replace(trim($operator) , '', $complication_value_values);

                            if ($complication_value_key == 'Treatment' && trim($complication_value_values) != '')
                            {

                                $query = $this->textsearch($complication_value_key, $operator, $complication_value_values, $query, $un_splited_value);

                            }
                            elseif (trim($complication_value_values) == 'complications.flags')
                            {

                                $query->where($complication_value_key, $complication_value_values);

                            }
                            elseif ($complication_value_key != 'complications.flags' && trim($complication_value_values) != '')
                            {

                                $query->orWhere($complication_value_key, $complication_value_values);

                            }

                        }
                    }
                }

                if (count($discharge_medication) > 0)
                {
                    foreach ($discharge_medication as $discharge_medication_key => $discharge_medication_value)
                    {
                        foreach ($discharge_medication_value as $discharge_medication_value_key => $discharge_medication_value_values)
                        {

                            $operator = preg_replace('/[A-Z,a-z,0-9,-,\/,:,.]/', '', trim($discharge_medication_value_values));
                            $un_splited_value = $discharge_medication_value_values;
                            $discharge_medication_value_values = str_replace(trim($operator) , '', $discharge_medication_value_values);

                            if ($discharge_medication_value_key == 'discharge_medications.genericname' && trim($discharge_medication_value_values) != '')
                            {
                                $query = $this->textsearch($discharge_medication_value_key, $operator, $discharge_medication_value_values, $query);

                            }
                            elseif (trim($discharge_medication_value_values) != '' && trim($discharge_medication_value_values) != 0)
                            {
                                $query->where($discharge_medication_value_key, $discharge_medication_value_values);
                            }

                        }
                    }
                }

                if (count($ultrasound_dating_scan) > 0)
                {
                    foreach ($ultrasound_dating_scan as $ultrasound_dating_scan_key => $ultrasound_dating_scan_value)
                    {
                        $operator = preg_replace('/[A-Z,a-z,0-9,-,\/,:]/', '', trim($ultrasound_dating_scan_value));
                        $un_splited_value = $ultrasound_dating_scan_value;
                        $ultrasound_dating_scan_value = str_replace(trim($operator) , '', $ultrasound_dating_scan_value);
                        if ($ultrasound_dating_scan_key == 'Gestation' && trim($ultrasound_dating_scan_value) != '')
                        {
                            $query = $this->numbersearch('Gestation', $operator, $ultrasound_dating_scan_value, $query, $un_splited_value, 'usg_finding');

                        }
                        elseif ($ultrasound_dating_scan_key == 'Finding' && trim($ultrasound_dating_scan_value) != '')
                        {

                            $query = $this->textsearch('Finding', $operator, $ultrasound_dating_scan_value, $query, 'usg_finding');

                        }

                    }
                    $query->where('usg_finding.type', 1);
                }

                if (count($ultrasound_anomaly_scan) > 0)
                {
                    foreach ($ultrasound_anomaly_scan as $ultrasound_anomaly_scan_key => $ultrasound_anomaly_scan_value)
                    {
                        $operator = preg_replace('/[A-Z,a-z,0-9,-,\/,:]/', '', trim($ultrasound_anomaly_scan_value));
                        $un_splited_value = $ultrasound_anomaly_scan_value;
                        $ultrasound_anomaly_scan_value = str_replace(trim($operator) , '', $ultrasound_anomaly_scan_value);

                        if ($ultrasound_anomaly_scan_key == 'Gestation' && trim($ultrasound_anomaly_scan_value) != '')
                        {

                            $query = $this->numbersearch('Gestation', $operator, $ultrasound_anomaly_scan_value, $query, $un_splited_value, 'usg_finding');

                        }
                        elseif ($ultrasound_anomaly_scan_key == 'Finding' && trim($ultrasound_anomaly_scan_value) != '')
                        {

                            $query = $this->textsearch('Finding', $operator, $ultrasound_anomaly_scan_value, $query, 'usg_finding');

                        }

                    }
                    $query->where('usg_finding.type', 2);

                }

                if (count($ultrasound_further_scan) > 0)
                {
                    foreach ($ultrasound_further_scan as $ultrasound_further_scan_key => $ultrasound_further_scan_value)
                    {
                        foreach ($ultrasound_further_scan_value as $value)
                        {

                            $operator = preg_replace('/[A-Z,a-z,0-9,-,\/,:]/', '', trim($value));
                            $un_splited_value = $value;
                            $value = str_replace(trim($operator) , '', $value);

                            if ($ultrasound_further_scan_key == 'Gestation' && trim($value) != '')
                            {

                                $query = $this->numbersearch('Gestation', $operator, $value, $query, $un_splited_value, 'usg_finding');

                            }
                            elseif ($ultrasound_further_scan_key == 'Finding' && trim($value) != '')
                            {

                                $query = $this->textsearch('Finding', $operator, $value, $query, 'usg_finding');

                            }
                        }
                    }
                    $query->where('usg_finding.type', 3);

                }

                if (count($ultrasound_doppler_scan) > 0)
                {
                    foreach ($ultrasound_doppler_scan as $ultrasound_doppler_key => $ultrasound_doppler_value)
                    {
                        foreach ($ultrasound_doppler_value as $value)
                        {

                            $operator = preg_replace('/[A-Z,a-z,0-9,-,\/,:]/', '', trim($value));
                            $un_splited_value = trim($value);
                            $value = str_replace(trim($operator) , '', trim($value));

                            if ($ultrasound_doppler_key == 'Gestation' && trim($value) != '')
                            {

                                $query = $this->numbersearch('Gestation', $operator, $value, $query, $un_splited_value, 'usg_finding');

                            }
                            elseif ($ultrasound_doppler_key == 'Finding' && trim($value) != '')
                            {

                                $query = $this->textsearch('Finding', $operator, $value, $query, 'usg_finding');

                            }
                        }

                    }
                    $query->where('usg_finding.type', 4);

                }

                if (count($jsonvalue) > 0)
                {
                    foreach ($jsonvalue as $jsonvalue_key => $jsonvalue_value)
                    {
                        foreach ($jsonvalue_value as $drugs_key => $drugs_value)
                        {

                            if ($jsonvalue_key == 'additional_diagnosis' || $jsonvalue_key == 'procedures' || $jsonvalue_key == 'typeoftreatment_left' || $jsonvalue_key == 'typeoftreatment_right')
                            {
                                $query->whereJsonContains($jsonvalue_key, $drugs_value);
                            }
                            else
                            {
                                $query->where($jsonvalue_key, 'like', '%"' . $drugs_value . '"%');

                            }

                        }
                        $query->whereNotNull($jsonvalue_key);
                    }
                }

                foreach ($time_values as $time_values_key => $time_values_time)
                {

                    if (in_array($time_values_key, $time_fields))
                    {
                        $operator = preg_replace('/[A-Z,a-z,0-9,:]/', '', trim($time_values_time));
                        $un_splited_value = trim($time_values_time);
                        $time_values_time = str_replace($operator, '', trim($time_values_time));

                        if ($time_values_key == 'admission_time')
                        {
                            $this->timesearch($time_values_key, $operator, $time_values_time, $query, $un_splited_value, 'nicu_admission');
                        }
                        else
                        {
                            $this->timesearch($time_values_key, $operator, $time_values_time, $query, $un_splited_value);
                        }

                    }
                }

            })
            ->orderBy('nicu_admission.NicuId', 'desc');

            $temp_result = $result->get();
            $results['count'] = $temp_result->count();

            $results['very_first'] = isset($temp_result[0]) ? $temp_result[0]->NicuId : 0;
            $results['very_last'] = isset($temp_result[$results['count']-1]->NicuId) ? $temp_result[$results['count']-1]->NicuId : 0;

            $results['data'] = $result->limit($limitend)
            ->offset($limitstart)
            ->get();

            $query_log = \DB::getQueryLog();

            $last_log = end($query_log);
            $last_log['bindings'][] = $limitend;
            $last_log['bindings'][] = $limitstart;

            $last_log['bindings'] = "'".implode("','", $last_log['bindings'])."'";
            $last_log['search_module'] = 3;
            $results['query_log_id'] = SearchQueryLog::create($last_log)->id;
            \DB::flushQueryLog();

        }
        return $results;

    }

    /**
     * This method to get
     * seprate the oprator form text
     *
     * @param $value type string
     *
     * @param $query type object
     *
     * @param $column type string
     *
     * @return type array
     */
    public function timesearch($column, $operator = ':', $value, $query, $un_splited_value = '', $table = '')
    {
        $operator = trim($operator);

        switch ($operator)
        {
            case '=':
            $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');
            if (isset($this->time_setting[$column]))
            {
                if ($table != '')
                {
                    for ($i = 0;$i < count($this->time_setting[$column]);$i++)
                    {
                        $this->time_setting[$column][$i] = str_replace($table . '.', '', $this->time_setting[$column][$i]);
                    }
                    $query->whereRaw('("' . $table . '"."' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                elseif ($column == 'discussion_time')
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                else
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');

                }
            }

            break;
            case '==':

            $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');

            if (isset($this->time_setting[$column]))
            {
                if ($table != '')
                {
                    for ($i = 0;$i < count($this->time_setting[$column]);$i++)
                    {
                        $this->time_setting[$column][$i] = str_replace($table . '.', '', $this->time_setting[$column][$i]);
                    }
                    $query->whereRaw('("' . $table . '"."' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][2] . '")::time ' . '=' . '\'' . $value . '\'');
                }
                else
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $this->time_setting[$column][2] . '")::time ' . '=' . '\'' . $value . '\'');

                }
            }
            break;
            case '<':
            $value = str_replace('<', '', $value);
            $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');

            if (isset($this->time_setting[$column]))
            {
                if ($table != '')
                {
                    for ($i = 0;$i < count($this->time_setting[$column]);$i++)
                    {
                        $this->time_setting[$column][$i] = str_replace($table . '.', '', $this->time_setting[$column][$i]);
                    }
                    $query->whereRaw('("' . $table . '"."' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                elseif ($column == 'DiscussionTime')
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                else
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');

                }
            }

            break;
            case '<=':
            $value = str_replace('<=', '', $value);
            $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');

            if (isset($this->time_setting[$column]))
            {
                if ($table != '')
                {
                    for ($i = 0;$i < count($this->time_setting[$column]);$i++)
                    {
                        $this->time_setting[$column][$i] = str_replace($table . '.', '', $this->time_setting[$column][$i]);
                    }
                    $query->whereRaw('("' . $table . '"."' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                elseif ($column == 'DiscussionTime')
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                else
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');

                }
            }

            break;
            case '>':

            $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');

            if (isset($this->time_setting[$column]))
            {
                if ($table != '')
                {
                    for ($i = 0;$i < count($this->time_setting[$column]);$i++)
                    {
                        $this->time_setting[$column][$i] = str_replace($table . '.', '', $this->time_setting[$column][$i]);
                    }
                    $query->whereRaw('("' . $table . '"."' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                elseif ($column == 'DiscussionTime')
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                else
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');

                }
            }

            break;
            case '>=':
            $value = str_replace('>=', '', $value);
            $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');

            if (isset($this->time_setting[$column]))
            {
                if ($table != '')
                {
                    for ($i = 0;$i < count($this->time_setting[$column]);$i++)
                    {
                        $this->time_setting[$column][$i] = str_replace($table . '.', '', $this->time_setting[$column][$i]);
                    }
                    $query->whereRaw('("' . $table . '"."' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                elseif ($column == 'DiscussionTime')
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                else
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');

                }
            }

            break;
            case '#':
            if (isset($this->time_setting[$column]))
            {
                foreach ($this->time_setting[$column] as $time_entry => $time_entry_value)
                {
                    if ($time_entry_value != 'DiscussionTime') $query->orWhere($time_entry_value, $value);
                    else $query->orWhere($time_entry_value, 'like', '%' . $value . '%');
                }
            }

            break;
            case '...':

            if (isset($this->time_setting[$column]))
            {

                $valueList = explode($operator, $un_splited_value);

                if (isset($valueList[0]) && isset($valueList[1]))
                {

                    $valueList[0] = Carbon::createFromFormat('h:i a', $valueList[0])->format('H:i:s');
                    $valueList[1] = Carbon::createFromFormat('h:i a', $valueList[1])->format('H:i:s');
                    sort($valueList);

                    if ($table != '')
                    {
                        for ($i = 0;$i < count($this->time_setting[$column]);$i++)
                        {
                            $this->time_setting[$column][$i] = str_replace($table . '.', '', $this->time_setting[$column][$i]);
                        }
                        $query->whereRaw('("' . $table . '"."' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][2] . '")::time between' . '\'' . $valueList[0] . '\' and ' . '\'' . $valueList[1] . '\'');
                    }
                    elseif ($column == 'DiscussionTime')
                    {
                        $query->whereRaw('("' . $this->time_setting[$column][0] . '")::time between' . '\'' . $valueList[0] . '\' and ' . '\'' . $valueList[1] . '\'');
                    }
                    else
                    {
                        $query->whereRaw('("' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $this->time_setting[$column][2] . '")::time between' . '\'' . $valueList[0] . '\' and ' . '\'' . $valueList[1] . '\'');
                    }
                }

            }

            break;
            default:
            $operator = '=';
            $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');
            if (isset($this->time_setting[$column]))
            {
                if ($table != '')
                {
                    for ($i = 0;$i < count($this->time_setting[$column]);$i++)
                    {
                        $this->time_setting[$column][$i] = str_replace($table . '.', '', $this->time_setting[$column][$i]);
                    }
                    $query->whereRaw('("' . $table . '"."' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $table . '"."' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                elseif ($column == 'DiscussionTime')
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '")::time ' . $operator . '\'' . $value . '\'');
                }
                else
                {
                    $query->whereRaw('("' . $this->time_setting[$column][0] . '" ||\':\'|| "' . $this->time_setting[$column][1] . '" ||\':\'|| "' . $this->time_setting[$column][2] . '")::time ' . $operator . '\'' . $value . '\'');

                }
            }
            break;

        }

        return $query;

    }

        /**
         * This method to get text
         * search
         *
         * @param $column type text
         *
         * @param $operator type text
         *
         * @param $value type text
         *
         * @param $query type object
         *
         * @param $un_splited_value text
         *
         * @return object of query builder
         */
        public function textsearch($column, $operator, $value, $query, $un_splited_value = '')
        {
            $operator = trim($operator);
            $column = trim($column);

            switch ($operator)
            {
                case '=':
                if ($column == 'BMrNo')
                {
                    $query->where('baby.BMrNo', 'like', '%' . $value . '%');
                } 
                elseif ($column == 'discharge_medications.genericname' || $column == 'medical_problems.Medication')
                {
                    $column1 = explode('.', $column);
                    $query->orWhereRaw('rtrim(lower("' . $column1[0] . '"."' . $column1[1] . '")) like ' . "'%" . rtrim(strtolower($value)) . "%'");
                }
                else
                {
                        // $query->orWhereRaw('rtrim(lower("'.$column.'")) like '."'%".rtrim(strtolower($value))."%'");
                    $query->whereRaw('rtrim(lower("' . $column . '")) like ' . "'% " . rtrim(strtolower($value)) . " %'");
                    $query->orWhereRaw('rtrim(lower("' . $column . '")) like ' . "'" . rtrim(strtolower($value)) . " %'");
                    $query->orWhereRaw('rtrim(lower("' . $column . '")) like ' . "'% " . rtrim(strtolower($value)) . "'");
                    $query->orWhereRaw('trim(lower("' . $column . '")) = ' . "'" . trim(strtolower($value)) . "'");
                }
                break;

                case '==':
                if ($column == 'BMrNo')
                {
                    $query->where('baby.BMrNo', $value);
                }
                elseif ($column == 'discharge_medications.genericname' || $column == 'medical_problems.Medication')
                {
                    $column1 = explode('.', $column);
                        // $query->orWhereRaw('lower("'.$column1[0].'"."'.$column1[1].'") like '."'%".strtolower($value)."%'");
                    $query->whereRaw('rtrim(lower("' . $column1[0] . '"."' . $column1[1] . '")) = ' . "'" . rtrim(strtolower($value)) . "'");
                }
                else
                {
                        // $query->orWhereRaw('lower("'.$column.'") like '."'%".strtolower($value)."%'");
                    $query->whereRaw('rtrim(lower("' . $column . '")) = ' . "'" . rtrim(strtolower($value)) . "'");
                }
                break;

                case '""':
                if ($column == 'BMrNo')
                {
                    $query->where('baby.BMrNo', 'like', '%' . $value . '%');
                }
                elseif ($column == 'discharge_medications.genericname' || $column == 'medical_problems.Medication')
                {
                    $column1 = explode('.', $column);
                    $query->orWhereRaw('rtrim(lower("' . $column1[0] . '"."' . $column1[1] . '")) like ' . "'%" . rtrim(strtolower($value)) . "%'");
                }
                else
                {
                    $query->whereRaw('rtrim(lower("' . $column . '")) like ' . "'% " . rtrim(strtolower($value)) . "%'");
                    $query->orWhereRaw('rtrim(lower("' . $column . '")) like ' . "'" . rtrim(strtolower($value)) . " %'");
                    $query->orWhereRaw('trim(lower("' . $column . '")) = ' . "'" . trim(strtolower($value)) . "'");
                        // $query->orWhereRaw($column, 'like', '%'.$value.'%');

                }
                break;

                case '*""':
                if ($column == 'BMrNo')
                {
                        // $query->whereRaw('to_tsvector("baby"."BMrNo") @@ to_tsquery('."'".$value."'".')');
                    $query->whereRaw('rtrim(lower("baby"."BMrNo")) like ' . "'%" . rtrim(strtolower($value)) . "%'");
                }
                elseif ($column == 'discharge_medications.genericname' || $column == 'medical_problems.Medication')
                {
                    $column1 = explode('.', $column);
                        // $query->whereRaw('to_tsvector("'.$column1[0].'"."'.$column1[1].'") @@ to_tsquery('."'".$value."'".')');
                    $query->whereRaw('rtrim(lower("' . $column1[0] . '"."' . $column1[1] . '")) like ' . "'%" . rtrim(strtolower($value)) . "%'");
                }
                else
                {
                        // $value = str_replace(' ', '|', trim($value));
                        // $query->whereRaw('to_tsvector(rtrim("'.$column.'")) @@ to_tsquery(rtrim('."'".$value."'".'))');
                    $query->whereRaw('rtrim(lower("' . $column . '")) like ' . "'%" . rtrim(strtolower($value)) . "%'");
                }

                break;

                case '@':
                if ($column == 'BMrNo')
                {
                    $charater_details = str_split($value);
                    foreach ($charater_details as $character_key => $character_value)
                    {
                        $query->orWhereRaw('lower("baby"."BMrNo") like ' . "'%" . strtolower($character_value) . "%'");
                    }
                }
                elseif ($column == 'discharge_medications.genericname' || $column == 'medical_problems.Medication')
                {
                    $column1 = explode('.', $column);
                    $charater_details = str_split($value);
                    foreach ($charater_details as $character_key => $character_value)
                    {
                        $query->orWhereRaw('lower("' . $column1[0] . '"."' . $column1[1] . '") like ' . "'%" . strtolower($character_value) . "%'");
                    }
                }
                else
                {
                    $charater_details = str_split($value);
                    foreach ($charater_details as $character_key => $character_value)
                    {
                        $query->orWhereRaw('lower("' . $column . '") like ' . "'%" . strtolower($character_value) . "%'");
                    }
                }

                break;

                case '!':
                if ($column == 'BMrNo')
                {
                    $query->whereRaw('"baby"."BMrNo" like ' . "'" . $value . "%'");
                }
                elseif ($column == 'discharge_medications.genericname' || $column == 'medical_problems.Medication')
                {
                    $column1 = explode('.', $column);
                    $query->orWhereRaw('"' . $column1[0] . '"."' . $column1[1] . '" like ' . "'" . $value . "%'");
                }
                else
                {
                    $query->orWhereRaw('"' . $column . '" like ' . "'" . $value . "%'");
                }
                break;

                default:
                if ($column == 'BMrNo')
                {
                    $query->whereRaw('trim(lower("baby"."' . $column . '")) = ' . "'" . trim(strtolower($un_splited_value)) . "'");
                }
                elseif ($column == 'Sex')
                {
                    $query->whereRaw('trim(lower("' . $column . '")) = ' . "'" . trim(strtolower($value)) . "'");
                }
                elseif ($column == 'nicu_genitalia')
                {
                    $query->orWhere($column, $value);
                }
                elseif ($column == 'discharge_medications.genericname' || $column == 'medical_problems.Medication')
                {
                    $column1 = explode('.', $column);
                    $query->orWhereRaw('lower("' . $column1[0] . '"."' . $column1[1] . '") like ' . "'%" . strtolower($value) . "%'");
                }
                elseif ($column == 'status')
                {
                    $query->orWhereRaw('lower("nicu_admission"."status") like ' . "'%" . strtolower($value) . "%'");
                }
                else
                {
                    $query->orWhereRaw('lower("' . $column . '") like ' . "'%" . strtolower($value) . "%'");
                }

                break;
            }

            return $query;

        }

        /**
         * This method to get
         * seprate the oprator form text
         *
         * @param $value type string
         *
         * @param $query type object
         *
         * @param $column type string
         *
         * @return type array
         */
        public function numbersearch($column, $operator, $value, $query, $un_splited_value = '', $table = '')
        {

            $operator = trim($operator);

            switch ($operator)
            {
                case '=':
                if ($column == 'Gestation')
                {
                    $query->where('usg_finding.' . $column, $value);
                }
                elseif ($column == 'g_weeks')
                {
                    $query->whereRaw("CAST(" . '"' . $column . '"' . "as text) like '%" . $value . "%'");
                }
                elseif ($column == 'Dose')
                {
                    $query->where('nicu_admission.' . $column, $value);
                }
                elseif ($column == 'air_flow' || $column == 'oxgen_flow')
                {
                    $query->where($column, $value);
                }
                else
                {
                    $query->where($column, 'like', "'%" . $value . "%'");
                }
                break;
                case '==':
                if ($column == 'Gestation')
                {
                    $query->where('usg_finding.' . $column, $value);
                }
                elseif ($column == 'Dose')
                {
                    $query->where('nicu_admission.' . $column, $value);
                }
                else
                {
                    $query->where($column, $value);
                }
                break;
                case '<':
                if ($column != 'g_weeks' && $column != 'g_days' && $column != 'cg_weeks' && $column != 'cg_days' && $column != 'dcg_weeks' && $column != 'dcg_days' && $column != 'Dose' && $column != 'air_flow' && $column != 'oxgen_flow' && $column != 'diastolic_bp')
                {
                    if ($table != '')
                    {
                        $query->whereRaw('CAST (NULLIF("' . $table . '"."' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                    }
                    else
                    {
                        $query->whereRaw('CAST (NULLIF("' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                    }
                }
                elseif ($column == 'Dose')
                {
                    $table = 'nicu_admission';
                    $query->whereRaw('CAST (NULLIF("' . $table . '"."' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                }
                else
                {
                    $query->whereRaw("CAST(" . '"' . $column . '"' . "as text) " . $operator . "'" . $value . "'");
                }
                break;
                case '<=':
                if ($column != 'g_weeks' && $column != 'g_days' && $column != 'cg_weeks' && $column != 'cg_days' && $column != 'dcg_weeks' && $column != 'dcg_days' && $column != 'Dose' && $column != 'air_flow' && $column != 'oxgen_flow' && $column != 'diastolic_bp')
                {
                    if ($table != '')
                    {
                        $query->whereRaw('CAST (NULLIF("' . $table . '"."' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                    }
                    else
                    {
                        $query->whereRaw('CAST (NULLIF("' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                    }
                }
                elseif ($column == 'Dose')
                {
                    $table = 'nicu_admission';
                    $query->whereRaw('CAST (NULLIF("' . $table . '"."' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                }
                else
                {
                    $query->whereRaw("CAST(" . '"' . $column . '"' . "as text) " . $operator . "'" . $value . "'");
                }
                break;
                case '>':
                if ($table != '' && $column != 'g_weeks' && $column != 'g_days' && $column != 'cg_weeks' && $column != 'cg_days' && $column != 'dcg_weeks' && $column != 'dcg_days' && $column != 'Dose')
                {
                    $query->whereRaw('CAST (NULLIF("' . $table . '"."' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                }
                elseif ($table == '' && $column != 'g_weeks' && $column != 'g_days' && $column != 'cg_weeks' && $column != 'cg_days' && $column != 'dcg_weeks' && $column != 'dcg_days' && $column != 'Dose' && $column != 'air_flow' && $column != 'oxgen_flow' && $column != 'diastolic_bp')
                {
                    $query->whereRaw('CAST (NULLIF("' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                }
                elseif ($table == '' && $column == 'g_weeks' || $column == 'g_days' && $column == 'cg_weeks' && $column == 'cg_days' && $column != 'dcg_weeks' && $column != 'dcg_days')
                {
                    $query->where($column, $operator, $value);
                }
                elseif ($column == 'Dose')
                {
                    $table = 'nicu_admission';
                    $query->whereRaw('CAST (NULLIF("' . $table . '"."' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                }
                else
                {
                    $query->where($column, $operator, $value);
                }
                break;
                case '>=':
                if ($column != 'g_weeks' && $column != 'g_days' && $column != 'cg_weeks' && $column != 'cg_days' && $column != 'dcg_weeks' && $column != 'dcg_days' && $column != 'Dose' && $column != 'air_flow' && $column != 'oxgen_flow' && $column != 'diastolic_bp')
                {
                    if ($table != '')
                    {
                        $query->whereRaw('CAST (NULLIF("' . $table . '"."' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                    }
                    else
                    {
                        $query->whereRaw('CAST (NULLIF("' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                    }
                }
                elseif ($column == 'Dose')
                {
                    $table = 'nicu_admission';
                    $query->whereRaw('CAST (NULLIF("' . $table . '"."' . $column . '",' . "''" . ') as float) ' . $operator . $value);
                }
                else
                {
                    $query->whereRaw("CAST(" . '"' . $column . '"' . "as text) " . $operator . "'" . $value . "'");
                }
                break;
                case '#':

                $value_list = array();

                if (in_array($column, ['g_weeks', 'g_days', 'BirthWeight']))
                {
                    $number_list = \DB::table('baby')->where('IsDeleted', '0')
                    ->get();
                    foreach ($number_list as $number_list_key => $number_list_value)
                    {
                        $temp_values = (array)$number_list_value;
                        $numbers = preg_split('//', $temp_values[$column], -1, PREG_SPLIT_NO_EMPTY);
                        $input_numbers = preg_split('//', $value, -1, PREG_SPLIT_NO_EMPTY);
                        foreach ($input_numbers as $input_numbers_key => $input_numbers_value)
                        {
                            if (in_array($input_numbers_value, $numbers))
                            {
                                $value_list[] = $temp_values[$column];
                            }
                        }
                    }
                }
                elseif (in_array($column, ['MothercYear', 'PartnercYear']))
                {
                    $number_list = \DB::table('mother')->where('IsDeleted', 0)
                    ->get();
                    foreach ($number_list as $number_list_key => $number_list_value)
                    {
                        $temp_values = (array)$number_list_value;
                        $numbers = preg_split('//', $temp_values[$column], -1, PREG_SPLIT_NO_EMPTY);
                        $input_numbers = preg_split('//', $value, -1, PREG_SPLIT_NO_EMPTY);
                        foreach ($input_numbers as $input_numbers_key => $input_numbers_value)
                        {
                            if (in_array($input_numbers_value, $numbers))
                            {
                                $value_list[] = $temp_values[$column];
                            }
                        }
                    }
                }
                elseif (in_array($column, ['duration_in_weeks']))
                {
                    $number_list = \DB::table('complications')->get();
                    foreach ($number_list as $number_list_key => $number_list_value)
                    {
                        $temp_values = (array)$number_list_value;
                        $numbers = preg_split('//', $temp_values[$column], -1, PREG_SPLIT_NO_EMPTY);
                        $input_numbers = preg_split('//', $value, -1, PREG_SPLIT_NO_EMPTY);
                        foreach ($input_numbers as $input_numbers_key => $input_numbers_value)
                        {
                            if (in_array($input_numbers_value, $numbers))
                            {
                                $value_list[] = $temp_values[$column];
                            }
                        }
                    }
                }
                elseif (in_array($column, ['AdmissionWt', 'AgeOnAdmissioninDays', 'AgeOnAdmissionhour', 'Dose', 'AgeAfterBirth', 'air_flow', 'oxgen_flow', 'TransferFiO2', 'Pip', 'PEEP', 'mean_airway_pressure', 'Rate', 'IT', 'Fio2', 'Flow_l_min', 'RR', 'HR', 'BP', 'diastolic_bp', 'MeanBP', 'Temperature', 'AgeTaken', 'SpO2', 'pH', 'PaO2', 'PaCo2', 'HCO3', 'BE', 'RBS', 'Hct', 'SexBirthWtGestation', 'TemperatureAtAdmission', 'BaseExcess', 'TotalCRIB2Score', 'amplitude_delta', 'Fluids', 'TotalSNAP2Score', 'TotalSNAPPE2Score', 'DischargeWeight', 'OFC', 'Length', 'PostductalSaturation', 'DischargeHb', 'DischargePCV', 'NicuDCT', 'DischargeTSB', 'direct_bilirubin', 'DischargeSerumCa', 'DischargeSerumPo4', 'DischargeSerumALP', 'DischargeSerumNa', 'cg_weeks', 'cg_days', 'dcg_weeks', 'dcg_days', 'DOLatDischarge']))
                {
                    $number_list = \DB::table('nicu_admission')->get();
                    foreach ($number_list as $number_list_key => $number_list_value)
                    {
                        $temp_values = (array)$number_list_value;
                        $numbers = preg_split('//', $temp_values[$column], -1, PREG_SPLIT_NO_EMPTY);
                        $input_numbers = preg_split('//', $value, -1, PREG_SPLIT_NO_EMPTY);
                        foreach ($input_numbers as $input_numbers_key => $input_numbers_value)
                        {
                            if (in_array($input_numbers_value, $numbers))
                            {
                                $value_list[] = $temp_values[$column];
                            }
                        }
                    }
                    $column = 'nicu_admission.' . $column;
                }
                elseif (in_array($column, ['Gestation', 'Finding']))
                {
                    $number_list = \DB::table('usg_finding')->where('flags', 1)
                    ->get();
                    foreach ($number_list as $number_list_key => $number_list_value)
                    {
                        $temp_values = (array)$number_list_value;
                        $numbers = preg_split('//', $temp_values[$column], -1, PREG_SPLIT_NO_EMPTY);
                        $input_numbers = preg_split('//', $value, -1, PREG_SPLIT_NO_EMPTY);
                        foreach ($input_numbers as $input_numbers_key => $input_numbers_value)
                        {
                            if (in_array($input_numbers_value, $numbers))
                            {
                                $value_list[] = $temp_values[$column];
                            }
                        }
                    }
                    $column = 'usg_finding.' . $column;
                }
                    // $valueList = array_unique($value_list);
                $query->whereIn($column, $valueList);
                break;
                case '...':
                $valueList = explode($operator, $un_splited_value);
                if ($column == 'Gestation')
                {
                    $query->whereBetween('usg_finding.' . $column, $valueList);
                }
                elseif ($column == 'Dose')
                {
                    $query->whereBetween('nicu_admission.' . $column, $valueList);
                }
                else
                {
                    $query->whereBetween($column, $valueList);
                }
                break;
                default:
                if ($column == 'Gestation')
                {
                    $query->where('usg_finding.' . $column, $value);
                }
                else
                {
                    $query->where($column, $value);
                }

                break;

            }

            return $query;

        }

        /**
         * This method to get date search
         *
         * @param $column type text
         *
         * @param $operator type text
         *
         * @param $value type date
         *
         * @param $query type object
         *
         * @param $un_splited_value type text
         *
         * @return $query object of query builder
         */
        public function datesearch($column, $operator, $value, $query, $un_splited_value = '')
        {
            $value = str_replace('/', '-', $value);
            $operator = str_replace('-', '', $operator);
            $value = str_replace($operator, '', $value);
            if ($column == 'AdmissionDate') {
                $column = 'nicu_admission.AdmissionDate';
            }
            switch ($operator)
            {
                case '=':
                if (!empty($value))
                {
                    $query->where($column, date('Y-m-d', strtotime($value)));
                }
                else
                {
                    $query->whereNull($column);
                }
                break;

                case '==':
                $query->whereDate($column, date('Y-m-d', strtotime($value)));
                break;

                case '//':
                $query->whereDate($column, date('Y-m-d'));
                break;

                case '>':
                $query->where($column, '>', date('Y-m-d', strtotime($value)));
                break;

                case '>=':
                $query->where($column, '>=', date('Y-m-d', strtotime($value)));
                break;

                case '<':
                $query->where($column, '<', date('Y-m-d', strtotime($value)));
                break;

                case '<=':
                $query->where($column, '<', date('Y-m-d', strtotime($value)));
                break;

                case '...':

                $un_splited_value = explode('...', $un_splited_value);
                $startDate = date('Y-m-d', strtotime($un_splited_value[0]));
                $endDate = date('Y-m-d', strtotime($un_splited_value[1]));
                if ($column == 'AdmissionDate')
                {

                    $query->whereBetween('nicu_admission.AdmissionDate', [$startDate, $endDate]);
                }
                else
                {
                    $query->whereBetween($column, [$startDate, $endDate]);
                }
                break;

                case '?':
                $today = null;
                $today = date('Y-m-d', strtotime($today));
                $query->where($column, '=', $today);
                break;

                case '#':
                $value = (strlen($value) == 1 && $value < 10 && $value > 0) ? '0' . $value : $value;
                $date_list = array();

                if ($column == 'DOB')
                {

                    $dob_list = \DB::table('baby')->where('IsDeleted', '0')
                    ->get();
                    foreach ($dob_list as $dob_key => $dob_value)
                    {
                        $dob_content = explode('-', $dob_value->DOB);
                        if (in_array($value, $dob_content))
                        {
                            $date_list[] = $dob_value->DOB;
                        }
                    }

                }
                elseif (in_array($column, ['TestDate', 'LMP', 'EDDbyUSG', 'EDDbyDates']))
                {

                    $dob_list = \DB::table('neonatal_proforma')->where('IsDeleted', 0)
                    ->get();
                    foreach ($dob_list as $dob_key => $dob_value)
                    {
                        $temp_dates = (array)$dob_value;
                        $dob_content = explode('-', $temp_dates[$column]);
                        if (in_array($value, $dob_content))
                        {
                            $date_list[] = $temp_dates[$column];
                        }
                    }

                }
                elseif (in_array($column, ['PartnerDOB', 'MotherDOB']))
                {

                    $dob_list = \DB::table('mother')->where('IsDeleted', 0)
                    ->get();
                    foreach ($dob_list as $dob_key => $dob_value)
                    {
                        $temp_dates = (array)$dob_value;
                        $dob_content = explode('-', $temp_dates[$column]);
                        if (in_array($value, $dob_content))
                        {
                            $date_list[] = $temp_dates[$column];
                        }
                    }
                }
                elseif (in_array($column, ['AdmissionDate', 'DateofAdministration', 'NextAppointment', 'DischargeDate']))
                {

                    $dob_list = \DB::table('nicu_admission')->select($column)->where($column, '<>', null)->where('IsDeleted', 0)
                    ->get();

                    foreach ($dob_list as $dob_key => $dob_value)
                    {
                        $temp_dates = (array)$dob_value;
                        $dob_content = explode('-', $temp_dates[$column]);
                        if (in_array($value, $dob_content))
                        {
                            $date_list[] = $temp_dates[$column];
                        }
                    }
                    $column = 'nicu_admission.' . $column;
                }

                $query->whereIn($column, $date_list);
                break;

                default:
                if ($column == 'AdmissionDate')
                {
                    $query->where('nicu_admission.AdmissionDate', date('Y-m-d', strtotime($value)));
                }
                else
                {
                    $query->where($column, date('Y-m-d', strtotime($value)));
                }
                break;
            }

            return $query;

        }

        public function getData($nicu_id)
        {

            return \DB::table('nicu_admission')->select('nicu_admission.* as na', 'baby_admission.* as ba', 'baby.* as bab', 'ip_numbers.*')
            ->addSelect('nicu_admission.NicuId as nicu_id', 'baby.BMrNo as baby_mr', 'nicu_admission.AdmissionTime as admission_time_hr', 'nicu_admission.AdmissionDate as AdmissionDate', 'nicu_admission.status as patientStatus')
            ->leftjoin('baby', 'baby.BabyId', '=', 'nicu_admission.BabyId')
            ->leftjoin('baby_admission', 'baby_admission.AdmissionId', '=', 'nicu_admission.AdmissionId')
            ->leftjoin('ip_numbers', 'ip_numbers.baby_id', '=', 'baby.BabyId')
            ->where(['baby.IsDeleted' => '0', 'nicu_admission.IsDeleted' => 0, 'baby_admission.AdmissionType' => 'NICU'])
            ->where('nicu_admission.NicuId', $nicu_id)->first();

        }

        public function getListbyNicu($nicu_id)
        {
            return \DB::table('nicu_admission')->select('nicu_admission.* as na', 'baby_admission.* as ba', 'baby.* as bab')
            ->addSelect('nicu_admission.NicuId as nicu_id', 'baby.BMrNo as baby_mr')
            ->leftjoin('baby', 'baby.BabyId', '=', 'nicu_admission.BabyId')
            ->leftjoin('baby_admission', 'baby_admission.AdmissionId', '=', 'nicu_admission.AdmissionId')
            ->where(['baby.IsDeleted' => '0', 'nicu_admission.IsDeleted' => 0, 'baby_admission.AdmissionType' => 'NICU'])
            ->whereIn('nicu_admission.NicuId', $nicu_id)->orderBy('nicu_admission.NicuId', 'desc')
            ->get();

        }

        public function getNiculist($groupName = 'nicuadmission')
        {

            return $this->NicuFields[$groupName];
        }

        public function getMedicalproblems($BabyId)
        {

            return \DB::table('medical_problems')->where('BabyId', $BabyId)->get();
        }

        public function getComplications($BabyId)
        {

            return \DB::table('complications')->where('BabyId', $BabyId)->get();
        }

        public function getultrasound($BabyId, $type)
        {
            return \DB::table('usg_finding')->where('BabyId', $BabyId)->where('type', $type)->get();

        }

        public function getMedication($baby_id, $admission_id)
        {
            return \DB::table('discharge_medications')->where('BabyId', $baby_id)->where('AdmissionId', $admission_id)->get();

        }

        /**
         * This method get all the neonatal proforma
         * list
         *
         * @param $neonatal_ids type array
         */
        public function getNicuSearchList($nicuId)
        {
            return \DB::table('nicu_admission')
            ->select(\DB::raw('DISTINCT ON("nicu_admission"."NicuId") "nicu_admission"."NicuId"'))
            ->select('baby.*', 'mother.*', 'nicu_admission.*', 'ip_numbers.ip_number')
            ->selectRaw('"nicu_admission"."AdmissionTime"|| \':\' ||"AdmissionTime_MINS"|| \' \' ||"AdmissionTime_AM" as "admission_time"')
            ->selectRaw('"nicu_admission"."TimeOfAdministration"|| \':\' ||"TimeOfAdministration_MINS"|| \' \' ||"TimeOfAdministration_AM" as "TimeOfAdministration"')
            ->selectRaw('"NAT_TIME"|| \':\' ||"NAT_MINS"|| \' \' ||"NAT_AM" as "next_time_appoinment"')
            ->leftjoin('baby', 'baby.BabyId', '=', 'nicu_admission.BabyId')
            ->leftjoin('mother', 'mother.MotherId', '=', 'baby.MotherId')
            ->leftjoin('baby_admission', 'baby_admission.AdmissionId', '=', 'nicu_admission.AdmissionId')
            ->leftjoin('ip_numbers', function ($join) {
                $join->orOn('baby.BabyId', '=', 'ip_numbers.baby_id');
            })
            ->whereIn('nicu_admission.NicuId', $nicuId)
            ->where(['baby.IsDeleted' => '0', 'nicu_admission.IsDeleted' => 0, 'baby_admission.AdmissionType' => 'NICU'])            
            ->orderby('NicuId', 'desc')
            ->get();
        }
    }

