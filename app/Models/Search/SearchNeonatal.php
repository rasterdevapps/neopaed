<?php
namespace App\Models\Search;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Search\SearchQueryLog;
use Carbon\Carbon;

class SearchNeonatal extends Model
{

    /**
     * This method to get neonatal
     * pro forma search data
     *
     */
    protected $allFields = ['TestDate', 'DOB', 'MotherDOB', 'PartnerDOB', 'LMP', 'EDDbyUSG', 'EDDbyDates', 'BirthWeight', 'g_weeks', 'g_days', 'Length', 'OFC', 'MothercYear', 'PartnercYear', 'BabyName', 'BabyBloodGroup', 'BirthOrder', 'Sex', 'transfer_status', 'OtherInvestigations', 'Consanguinity', 'Booked', 'Supervised', 'neonatal_proforma.MultiplePregnancy', 'PregnancyComplications', 'AntenatalSteroids', 'Labour', 'MaternalPyrexia', 'PROM', 'Resuscitation', 'FacialOxygen', 'bag_mask_ventilator', 'Intubation', 'CPR', 'Drugs', 'adjustedtrisomies', 'known_field', 'insertion_status', 'PPV', 'ppv_status', 'cpr_status', 'MotherName', 'partner_occupation_status', 'partner_education_status', 'MotherLastName', 'education_status', 'occupation_status', 'MotherInitial', 'MotherTitle', 'PartnerTitle', 'PartnerInitial', 'Email', 'Address1', 'Address2', 'Address3', 'Address4', 'Mobile', 'City', 'State', 'Country', 'PartnerName', 'PartnerContact', 'PartnerOccupation', 'LandLine', 'Occupation', 'G_Value', 'P_Value', 'L_Value', 'A_Value', 'MMrNo', 'MotherEmail', 'PartnerMobile', 'PartnerLastName', 'Postcode', 'Address5', 'FatherAddress1', 'FatherAddress2', 'MotherBloodGroup', 'FatherSpokenLanguages', 'MotherSpokenLanguages', 'Conception', 'TypeofART', 'EmbryoTransfer', 'PlaceofART', 'HIV', 'HepatitisB', 'VDRL', 'Booking', 'PlaceofSupervision', 'AdjustedRiskForTrisomy21', 'AdjustedRiskForTrisomy18', 'AdjustedRiskForTrisomy13', 'OtherInvestigations', 'antenatal_MgSO4', 'typeofsteroids', 'LastDoseDeliveryInterval', 'SteroidCourse', 'NatureofLabour', 'Syntocinon', 'CommentOnLiquor', 'sepsis_in_mother', 'DurationOfROM', 'Maternal_antibiotics_status', 'TimeofLastDose', 'ModeOfDelivery', 'Presentation', 'FoetalDistress', 'CTG', 'CTGDetails', 'CordBloodGas', 'CordpH', 'CordHCO3', 'CordBE', 'TypeofAnesthesia', 'GastricAspirate', 'delayed_cord_clamping', 'reason_dcc', 'duration_dcc', 'umbilicalcordmilking', 'cutcordmilking', 'Resuscitation', 'initial_steps', 'TimeOf1stGasp', 'RegularRespiration', 'DurationOfOxygen', 'maximum_fio2_required', 'bag_mask_ventilator_duration', 'bag_mask_ventilator_min', 'ETTSize', 'DepthOfInsertion', 'DurationOfPPV', 'duration_of_cpr', 'OtherInformation', 'VitaminK', 'DoseVitK', 'RouteVitK', 'InitialExamination', 'Malformation', 'MalformationType', 'Background', 'PLAN', 'DCT', 'Colour1', 'Colour5', 'Colour10', 'Colour15', 'Colour20', 'HR1', 'HR5', 'HR10', 'HR15', 'HR20', 'Reflex1', 'Reflex5', 'Reflex10', 'Reflex15', 'Reflex20', 'Tone1', 'Tone5', 'Tone10', 'Tone15', 'Tone20', 'Respiration1', 'Respiration5', 'Respiration10', 'Respiration15', 'Respiration20', 'Apgars1min', 'Apgars5min', 'Apgars10min', 'Apgars15min', 'Apgars20min', 'AbdomenShape', 'AddedSounds', 'AgeOfExamination', 'AirEntry', 'AnteriorFontanelle', 'Anus', 'AnyOtherAbnormality', 'other_pa_findings', 'ApicalImpulse', 'BoundingPulses', 'BreathSounds', 'CentralPulses', 'NbCFT', 'CharacterOfAddedSounds', 'CharacterofMurmur', 'NbChestMovement', 'Colour', 'Cry', 'neonatal_proforma.SeenBy', 'Diagnosis', 'Ears', 'Esophagus', 'Eyes', 'FemoralPulses', 'Flanks', 'GeneralBodyMovements', 'Genitalia', 'Hairs', 'Hepatomegaly', 'HernialOrifices', 'Hips', 'NbHR', 'Jaundice', 'LevelOfConsciousness', 'Lips', 'LiverSpan', 'LtLL', 'LtUL', 'Murmur', 'Neck', 'NeonatalReflexes', 'Nipples', 'Nose', 'Nostrils', 'Palate', 'Pallor', 'PeripheralPulses', 'PrecordialActivity', 'NbRR', 'RtLL', 'RtUL', 'S1S2', 'Seizures', 'SiteofAddedSounds', 'SiteofMurmur', 'Skin', 'Spine', 'SpleenSpan', 'Splenomegaly', 'NbSpO2', 'SpontaneousActivity', 'TemperatureF', 'NbTone', 'TypeofSeizure', 'UmbilicalCord', 'Umbilicus', 'other_cvs_findings', 'other_rs_findings', 'other_cns_findings', 'BirthStatus', 'timeofgasp_status', 'regularrespiration_status'];

    /**
     * This method to get neonatal
     * pro forma search data
     *
     */
    protected $dateFields = ['TestDate', 'DOB', 'MotherDOB', 'PartnerDOB', 'LMP', 'EDDbyUSG', 'EDDbyDates'];

    /**
     * This method to get neonatal
     * pro forma search data
     *
     */
    protected $numberFields = ['BirthWeight', 'g_weeks', 'g_days', 'Length', 'OFC', 'MothercYear', 'PartnercYear', 'G_Value', 'P_Value', 'L_Value', 'A_Value', 'TimeOf1stGasp', 'RegularRespiration', 'DurationOfOxygen', 'DepthOfInsertion', 'duration_of_cpr', 'Colour1', 'Colour5', 'Colour10', 'Colour15', 'Colour20', 'HR1', 'HR5', 'HR10', 'HR15', 'HR20', 'Reflex1', 'Reflex5', 'Reflex10', 'Reflex15', 'Reflex20', 'Tone1', 'Tone5', 'Tone10', 'Tone15', 'Tone20', 'Respiration1', 'Respiration5', 'Respiration10', 'Respiration15', 'Respiration20', 'Apgars1min', 'Apgars5min', 'Apgars10min', 'Apgars15min', 'Apgars20min', 'NbHR', 'NbRR', 'TemperatureF', 'NbSpO2', 'maximum_fio2_required', 'bag_mask_ventilator_min', 'DurationOfPPV', 'CordpH', 'CordHCO3', 'CordBE', 'duration_dcc'];

    /**
     * This method to get neonatal
     * pro forma search data
     *
     */
    protected $textFields = ['BabyName', 'BabyBloodGroup', 'BirthOrder', 'Sex', 'transfer_status', 'OtherInvestigations', 'MotherName', 'partner_occupation_status', 'partner_education_status', 'MotherLastName', 'education_status', 'occupation_status', 'MotherInitial', 'MotherTitle', 'PartnerTitle', 'PartnerInitial', 'Email', 'Address1', 'Address2', 'Address3', 'Address4', 'Mobile', 'City', 'State', 'Country', 'PartnerName', 'PartnerContact', 'PartnerOccupation', 'LandLine', 'Occupation', 'MMrNo', 'MotherEmail', 'PartnerMobile', 'PartnerLastName', 'Postcode', 'Address5', 'FatherAddress1', 'FatherAddress2', 'MotherBloodGroup', 'FatherSpokenLanguages', 'MotherSpokenLanguages', 'Conception', 'TypeofART', 'EmbryoTransfer', 'PlaceofART', 'HIV', 'HepatitisB', 'VDRL', 'Booking', 'PlaceofSupervision', 'AdjustedRiskForTrisomy21', 'AdjustedRiskForTrisomy18', 'AdjustedRiskForTrisomy13', 'OtherInvestigations', 'antenatal_MgSO4', 'typeofsteroids', 'LastDoseDeliveryInterval', 'SteroidCourse', 'NatureofLabour', 'Syntocinon', 'CommentOnLiquor', 'sepsis_in_mother', 'DurationOfROM', 'Maternal_antibiotics_status', 'TimeofLastDose', 'ModeOfDelivery', 'Presentation', 'FoetalDistress', 'CTG', 'CTGDetails', 'CordBloodGas', 'TypeofAnesthesia', 'GastricAspirate', 'delayed_cord_clamping', 'reason_dcc', 'umbilicalcordmilking', 'cutcordmilking', 'Resuscitation', 'initial_steps', 'bag_mask_ventilator_duration', 'ETTSize', 'OtherInformation', 'VitaminK', 'DoseVitK', 'RouteVitK', 'InitialExamination', 'Malformation', 'MalformationType', 'Background', 'PLAN', 'DCT', 'AbdomenShape', 'AddedSounds', 'AgeOfExamination', 'AirEntry', 'AnteriorFontanelle', 'Anus', 'AnyOtherAbnormality', 'other_pa_findings', 'ApicalImpulse', 'BoundingPulses', 'BreathSounds', 'CentralPulses', 'NbCFT', 'CharacterOfAddedSounds', 'CharacterofMurmur', 'NbChestMovement', 'Colour', 'Cry', 'SeenBy', 'Diagnosis', 'Ears', 'Esophagus', 'Eyes', 'FemoralPulses', 'Flanks', 'GeneralBodyMovements', 'Genitalia', 'Hairs', 'Hepatomegaly', 'HernialOrifices', 'Hips', 'Jaundice', 'LevelOfConsciousness', 'Lips', 'LiverSpan', 'LtLL', 'LtUL', 'Murmur', 'Neck', 'NeonatalReflexes', 'Nipples', 'Nose', 'Nostrils', 'Palate', 'Pallor', 'PeripheralPulses', 'PrecordialActivity', 'RtLL', 'RtUL', 'S1S2', 'Seizures', 'SiteofAddedSounds', 'SiteofMurmur', 'Skin', 'Spine', 'SpleenSpan', 'Splenomegaly', 'SpontaneousActivity', 'NbTone', 'TypeofSeizure', 'UmbilicalCord', 'Umbilicus', 'other_cvs_findings', 'other_rs_findings', 'other_cns_findings', 'BirthStatus'];

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
    protected $pregnancyComplication = ['Complication', 'Treatment', 'duration_in_weeks', 'duration_unit'];

    /**
     * This method to get array
     * of search for delivery
     *
     * @var $deliveryDetails
     */
    protected $deliveryDetails = ['Year', 'Place', 'Delivery', 'Complications', 'Gender', 'GA', 'BW', 'Health', 'details'];

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
     * @var $jsonValues
     */
    protected $jsonValues = ['resusciatation_drugs', 'Indication', 'sepsis_in_mother_type'];

    /**
     * This method to get neonatal
     * pro forma search data for doggle
     * Yes or No
     */
    protected $toggleValues = ['Consanguinity', 'Booked', 'Supervised', 'MultiplePregnancy', 'PregnancyComplications', 'AntenatalSteroids', 'Labour', 'MaternalPyrexia', 'PROM', 'Resuscitation', 'FacialOxygen', 'bag_mask_ventilator', 'Intubation', 'CPR', 'Drugs'];
    /**
     * This method to get neonatal
     * pro forma search data
     *  1 or 2
     */
    protected $toggleValuesNumber = ['adjustedtrisomies', 'known_field'];

    /**
     * This method to get neonatal
     * pro forma search data
     *  1 or 2
     */
    protected $timevalues = ['entry_time', 'time_of_birth'];

    /**
     * This method to get neonatal
     * pro forma search data
     *  true or false
     */
    protected $toggleValuesBool = ['timeofgasp_status', 'regularrespiration_status', 'insertion_status', 'PPV', 'ppv_status', 'cpr_status'];

    /**
     * This method to get neonatal
     * pro forma search data
     *  1 or 2
     */
    protected $time_entry = ['TEST_TIME', 'TEST_MINS', 'TEST_AM'];

    /**
     * This method to get neonatal
     * pro forma search data
     *  1 or 2
     */
    protected $dob_entry = ['TOB_TIME', 'TOB_MINS', 'TOB_AM'];

    /**
     * This method to get array
     * of search for new born examination
     *
     * @var $newborn_examination
     */
    protected $newborn_examination = ['Scalp'];

    /**
     * This method get the searched data
     *
     * @param $data type array
     *
     * @return array of object
     */
    public function getList($page = 1, $limit = 5, $data = array(), $order = array())
    {
        $limitstart    = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend      = $limit;

        $data_details = $medical_problem = $pregnancy_complication = $delivery_details = $jsonvalue = $newborn_examination = [];
        $ultrasound_dating_scan = $ultrasound_anomaly_scan = $ultrasound_further_scan = $ultrasound_doppler_scan = [];
        $time_values = [];
        foreach ($this->allFields as $key => $value)
        {
            if (isset($data[$value]) && !empty(trim($data[$value])))
            {
                $data_details[$value] = $data[$value];
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
                        if (isset($data[$value]) && is_array($data[$value]) && $value == 'Problems')
                        {
                            $temp_array['Problem'] = $data['Problems'][$problemIndex];
                        }
                        else
                        {
                            $temp_array['Medication'] = isset($data['Medications'][$problemIndex]) ? $data['Medications'][$problemIndex] : '';
                        }
                        $medical_problem[] = $temp_array;
                    }
                }
            }
        }
        // This delivery settings
        foreach ($this->deliveryDetails as $delivery_key => $delivery_value)
        {
            if (isset($data[$delivery_value]) && is_array($data[$delivery_value]))
            {
                foreach ($data[$delivery_value] as $deliverykey => $deliveryvalue)
                {
                    if (!empty($deliveryvalue))
                    {
                        $delivery_details[$delivery_value] = $data[$delivery_value];
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
                        $temp_array['Complication'] = (int)$data['Complication'][$complicationIndex];
                        $temp_array['Treatment'] = isset($data['Treatment'][$complicationIndex]) ? $data['Treatment'][$complicationIndex] : '';
                        $temp_array['duration_in_weeks'] = (isset($data['duration_in_weeks'][$complicationIndex]) && $data['duration_in_weeks'][$complicationIndex] != '') ? $data['duration_in_weeks'][$complicationIndex] : '';
                        $temp_array['duration_unit'] = isset($data['duration_unit'][$complicationIndex]) ? $data['duration_unit'][$complicationIndex] : '';
                        $temp_array['flags'] = 1;
                        $pregnancy_complication[] = $temp_array;
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
            if (isset($data[$ultrasound_further_value])) {
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
            if (isset($data[$ultrasound_doppeler_value])) {
                foreach ($data[$ultrasound_doppeler_value] as $doppler_scan)
                {
                    if (!empty($doppler_scan) && $doppler_scan != '') $ultrasound_doppler_scan[$ultrasound_doppler_key][] = $doppler_scan;
                }
            }

        }

        // This for json values
        foreach ($this->jsonValues as $jsonValues_key => $jsonValues_value)
        {
            if (isset($data[$jsonValues_value])) {
                foreach ($data[$jsonValues_value] as $json_drugs)
                {
                    if (!empty($json_drugs) && $json_drugs != '' && $json_drugs != 'N/A' && $json_drugs != 0)
                    {
                        $jsonvalue[$jsonValues_value][] = $json_drugs;
                    }
                }
            }

        }

        foreach ($this->toggleValuesNumber as $toggleNumber_key => $toggleNumber_value)
        {
            if (isset($data_details[$toggleNumber_value]) && $data_details[$toggleNumber_value] == 'Yes')
            {
                $data_details[$toggleNumber_value] = '2';
            }
        }

        foreach ($this->toggleValuesBool as $toggleValuesBool_key => $toggleValuesBool_value)
        {
            if (isset($data_details[$toggleValuesBool_value]) && $data_details[$toggleValuesBool_value] == 'Known')
            {
                $data_details[$toggleValuesBool_value] = true;
            }
            elseif (isset($data_details[$toggleValuesBool_value]) && $data_details[$toggleValuesBool_value] == 'Unknown')
            {
                $data_details[$toggleValuesBool_value] = false;
            }
        }

        foreach ($this->timevalues as $timevalues_key => $timevalues_value)
        {
            if (isset($data[$timevalues_value]) && $data[$timevalues_value] != '' && !empty($timevalues_value))
            {

                $time_values[$timevalues_value] = $data[$timevalues_value];
            }
        }

        // This delivery settings
        foreach ($this->newborn_examination as $newborn_examination_key => $newborn_examination_value)
        {
            if (isset($data[$newborn_examination_value])) {
                foreach ($data[$newborn_examination_value] as $newborn_key => $newborn_value)
                {
                    if (!empty($newborn_value))
                    {
                        $newborn_examination[$newborn_examination_value] = $data[$newborn_examination_value];
                    }
                }
            }
        }

        //$this->toggleValues
        $dateFields = $this->dateFields;
        $numberFields = $this->numberFields;
        $textFields = $this->textFields;
        $medicalProblems = $this->medicalProblems;
        $time_fields = $this->timevalues;

        $toggleValues = array_merge($this->toggleValues, $this->toggleValuesNumber);
        $toggleValues = array_merge($toggleValues, $this->toggleValuesBool);
        $results = array();

        if (count($data_details) > 0 || count($medical_problem) > 0 || count($pregnancy_complication) > 0 || count($delivery_details) > 0 || count($ultrasound_dating_scan) > 0 || count($ultrasound_anomaly_scan) > 0 || count($ultrasound_further_scan) > 0 || count($ultrasound_doppler_scan) > 0 || count($jsonvalue) > 0 || count($time_values) > 0 || count($newborn_examination) > 0)
        {

            DB::enableQueryLog();

            $result = DB::table('baby')
            ->select(\DB::raw('DISTINCT ON("neonatal_proforma"."NeonatalId") "neonatal_proforma"."NeonatalId"'))
            ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
            ->join('mother', 'mother.MotherId', '=', 'baby.MotherId')
            ->leftJoin('medical_problems', 'medical_problems.BabyId', '=', 'baby.BabyId')
            ->leftJoin('complications', 'complications.BabyId', '=', 'baby.BabyId')
            ->leftJoin('delivery_history', 'delivery_history.MotherId', '=', 'baby.MotherId')
            ->leftJoin('usg_finding', 'usg_finding.BabyId', '=', 'baby.BabyId')
            ->leftJoin('newborn_examination', 'newborn_examination.BabyId', '=', 'baby.BabyId')
            ->where(function ($query) use ($dateFields, $numberFields, $textFields, $toggleValues, $medicalProblems, $time_fields, $data_details, $medical_problem, $pregnancy_complication, $delivery_details, $ultrasound_dating_scan, $ultrasound_anomaly_scan, $ultrasound_further_scan, $ultrasound_doppler_scan, $jsonvalue, $time_values, $newborn_examination)
            {

                foreach ($data_details as $data_details_skey => $data_details_value)
                {

                    if (in_array($data_details_skey, $dateFields))
                    {

                        $data_details_value = str_replace('//', '%', $data_details_value);
                        $operator = preg_replace('/[0-9,-,\/]/', '', trim($data_details_value));
                        $un_splited_value = $data_details_value;
                        $operator = str_replace('%', '//', $operator);
                        $data_details_value = str_replace('%', '//', $data_details_value);
                        $data_details_value = trim(str_replace($operator, '', $data_details_value));
                        $query = $this->datesearch($data_details_skey, $operator, $data_details_value, $query, $un_splited_value);

                    }
                    elseif (in_array($data_details_skey, $numberFields))
                    {

                        $data_details_value = str_replace('...', '###', $data_details_value);
                        $operator = preg_replace('/[0-9,-,.]/', '', trim($data_details_value));
                        $data_details_value = str_replace('###', '...', $data_details_value);
                        $operator = (strrpos($data_details_value, '...') > 0) ? '...' : $operator;

                        $un_splited_value = $data_details_value;
                        $data_details_value = trim(str_replace($operator, '', $data_details_value));
                        if ($data_details_skey == 'CordBE')
                        {
                            $query = $this->specialsearch($data_details_skey, $operator, $data_details_value, $query, $un_splited_value);
                        }
                        $query = $this->numbersearch($data_details_skey, $operator, $data_details_value, $query, $un_splited_value);

                    }
                    elseif (in_array($data_details_skey, $textFields))
                    {

                        if ($data_details_skey == 'MotherEmail' || $data_details_skey == 'Email')
                        {

                            $data_details_value_filter = str_replace('@', '', $data_details_value);
                            $data_details_value_filter = str_replace('.', '', $data_details_value_filter);

                            $value = strpos($data_details_value, "@");

                            if (is_numeric($value) && $value == 0)
                            {
                                $data_details_value_filter = '@' . $data_details_value_filter;
                            }

                            $operator = preg_replace('/[A-Z,a-z,0-9,\/,:,_,-]/', '', trim($data_details_value_filter));
                            $operator = trim(stripslashes($operator));
                            $un_splited_value = $data_details_value;

                        }
                        else
                        {

                            $operator = preg_replace('/[A-Z,a-z,0-9,\/,:,_,-]/', '', trim($data_details_value));
                            $operator = trim(stripslashes($operator));
                            $un_splited_value = $data_details_value;
                        }

                        $data_details_value = trim(str_replace($operator, '', $data_details_value));
                        $query = $this->textsearch($data_details_skey, $operator, $data_details_value, $query, $un_splited_value);

                    }
                    elseif (in_array($data_details_skey, $toggleValues))
                    {

                        if ($data_details_skey == 'MultiplePregnancy')
                        {
                            $data_details_skey = 'neonatal_proforma.MultiplePregnancy';
                        }

                        $query->where($data_details_skey, $data_details_value);
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
                                // $medical_problem_index++;
                                // if ($medical_problem_index == 2) {
                                // $query->where($list_key, $list_value);
                                // } else {
                            $query->orWhere('medical_problems.' . $list_key, $list_value);
                                // }

                        }
                    }
                }

                    //delivery details
                if (count($delivery_details) > 0)
                {
                    foreach ($delivery_details as $delivery_details_key => $delivery_details_value)
                    {
                        foreach ($delivery_details_value as $delivery_key => $delivery_value)
                        {

                            $operator = preg_replace('/[A-Z,a-z,0-9,-,\/,:]/', '', trim($delivery_value));
                            $un_splited_value = $delivery_value;
                            $delivery_value = str_replace(trim($operator) , '', $delivery_value);

                            if (in_array($delivery_details_key, ['Year', 'GA', 'BW']) && !empty($delivery_value))
                            {
                                $query = $this->numbersearch($delivery_details_key, $operator, $delivery_value, $query, $un_splited_value);
                            }
                            elseif (in_array($delivery_details_key, ['Place', 'Delivery', 'Complications', 'Gender', 'Health', 'details']) && !empty($delivery_value))
                            {
                                $query = $this->textsearch($delivery_details_key, $operator, $delivery_value, $query, $un_splited_value);
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

                            if ($complication_value_key == 'flags')
                            {

                                $query->where('complications.flags', $complication_value_values);

                            }
                            elseif ($complication_value_key == 'duration_in_weeks' && trim($complication_value_values) != '')
                            {

                                $query = $this->numbersearch($complication_value_key, $operator, $complication_value_values, $query, $un_splited_value);

                            }
                            elseif ($complication_value_key == 'Treatment' && trim($complication_value_values) != '')
                            {

                                $query = $this->textsearch($complication_value_key, $operator, $complication_value_values, $query, $complication_value_values);

                            }
                            elseif (trim($complication_value_values) != '' && $complication_value_key != 'Treatment' && $complication_value_key != 'duration_in_weeks')
                            {

                                if ($complication_value_key == 'Complication' && $complication_value_values != 0)
                                {
                                    $query->where($complication_value_key, $complication_value_values);
                                }
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

                            $query = $this->textsearch('Finding', $operator, $ultrasound_dating_scan_value, $query, $un_splited_value, 'usg_finding');

                        }

                    }
                    $query->where('usg_finding.flags', 1);
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

                            $query = $this->textsearch('Finding', $operator, $ultrasound_anomaly_scan_value, $query, $un_splited_value, 'usg_finding');

                        }

                    }
                    $query->where('usg_finding.flags', 1);
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

                                $query = $this->textsearch('Finding', $operator, $value, $query, $un_splited_value, 'usg_finding');

                            }

                        }
                    }
                    $query->where('usg_finding.flags', 1);
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

                                $query = $this->textsearch('Finding', $operator, $value, $query, $un_splited_value, 'usg_finding');

                            }

                        }
                    }
                    $query->where('usg_finding.flags', 1);
                    $query->where('usg_finding.type', 4);
                }

                if (count($jsonvalue) > 0)
                {
                    foreach ($jsonvalue as $jsonvalue_key => $jsonvalue_value)
                    {
                        foreach ($jsonvalue_value as $drugs_key => $drugs_value)
                        {
                            $query->orwhereJsonContains($jsonvalue_key, $drugs_value);
                        }
                    }
                }
                foreach ($time_values as $time_values_key => $time_values_time)
                {

                    if (in_array($time_values_key, $time_fields))
                    {
                        $operator = preg_replace('/[A-Z,a-z,0-9,:]/', '', trim($time_values_time));
                        $un_splited_value = trim($time_values_time);
                        $time_values_time = str_replace($operator, '', trim($time_values_time));
                        $this->timesearch($time_values_key, $operator, $time_values_time, $query, $un_splited_value);
                    }

                }

                if (count($newborn_examination) > 0)
                {
                    foreach ($newborn_examination as $newborn_examination_key => $newborn_examination_value)
                    {
                        foreach ($newborn_examination_value as $exam_key => $exam_value)
                        {

                            $operator = preg_replace('/[A-Z,a-z,0-9,-,\/,:]/', '', trim($delivery_value));
                            $un_splited_value = $exam_value;
                            $delivery_value = str_replace(trim($operator) , '', $delivery_value);

                            if (in_array($newborn_examination_key, ['Scalp']) && !empty($exam_value))
                            {
                                $query = $this->textsearch($newborn_examination_key, $operator, $exam_value, $query, $un_splited_value);
                            }

                        }
                    }
                }

            })
            ->where('baby.IsDeleted', 0)
            ->where('neonatal_proforma.IsDeleted', 0)
            ->where('mother.IsDeleted', 0)
            ->orderby('NeonatalId', 'desc');
            $temp_result = $result->get();

            $results['count'] = $temp_result->count();

            $results['very_first'] = isset($temp_result[0]) ? $temp_result[0]->NeonatalId : 0;
            $results['very_last'] = isset($temp_result[$results['count']-1]->NeonatalId) ? $temp_result[$results['count']-1]->NeonatalId : 0;

            $results['data'] = $result->limit($limitend)->offset($limitstart)->get();

            $query_log = \DB::getQueryLog();

            $last_log = end($query_log);
            $last_log['bindings'][] = $limitend;
            $last_log['bindings'][] = $limitstart;

            $last_log['bindings'] = "'".implode("','", $last_log['bindings'])."'";
            $last_log['search_module'] = 1;
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
    public function timesearch($column, $operator, $value, $query, $un_splited_value = '', $table = '')
    {

        $operator = trim($operator);
        switch ($operator)
        {
            case '=':

            $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');

            if ($column == 'entry_time')
            {

                $query->whereRaw('("TEST_TIME" ||\':\'|| "TEST_MINS" ||\':\'|| "TEST_AM")::time ' . $operator . '\'' . $value . '\'');

            }
            elseif ($column == 'time_of_birth')
            {

                $query->whereRaw('("TOB_TIME" ||\':\'|| "TOB_MINS" ||\':\'|| "TOB_AM")::time ' . $operator . '\'' . $value . '\'');

            }

            break;
            case '==':

            $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');
            $operator = '=';
            if ($column == 'entry_time')
            {

                $query->whereRaw('("TEST_TIME" ||\':\'|| "TEST_MINS" ||\':\'|| "TEST_AM")::time ' . $operator . '\'' . $value . '\'');

            }
            elseif ($column == 'time_of_birth')
            {

                $query->whereRaw('("TOB_TIME" ||\':\'|| "TOB_MINS" ||\':\'|| "TOB_AM")::time ' . $operator . '\'' . $value . '\'');

            }

            break;
            case '<':

            $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');

            if ($column == 'entry_time')
            {

                $query->whereRaw('("TEST_TIME" ||\':\'|| "TEST_MINS" ||\':\'|| "TEST_AM")::time ' . $operator . '\'' . $value . '\'');

            }
            elseif ($column == 'time_of_birth')
            {

                $query->whereRaw('("TOB_TIME" ||\':\'|| "TOB_MINS" ||\':\'|| "TOB_AM")::time ' . $operator . '\'' . $value . '\'');

            }

            break;
            case '<=':

            $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');

            if ($column == 'entry_time')
            {

                $query->whereRaw('("TEST_TIME" ||\':\'|| "TEST_MINS" ||\':\'|| "TEST_AM")::time ' . $operator . '\'' . $value . '\'');

            }
            elseif ($column == 'time_of_birth')
            {

                $query->whereRaw('("TOB_TIME" ||\':\'|| "TOB_MINS" ||\':\'|| "TOB_AM")::time ' . $operator . '\'' . $value . '\'');

            }

            break;
            case '>':
            $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');

            if ($column == 'entry_time')
            {

                $query->whereRaw('("TEST_TIME" ||\':\'|| "TEST_MINS" ||\':\'|| "TEST_AM")::time ' . $operator . '\'' . $value . '\'');

            }
            elseif ($column == 'time_of_birth')
            {

                $query->whereRaw('("TOB_TIME" ||\':\'|| "TOB_MINS" ||\':\'|| "TOB_AM")::time ' . $operator . '\'' . $value . '\'');

            }

            break;
            case '>=':
            $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');

            if ($column == 'entry_time')
            {

                $query->whereRaw('("TEST_TIME" ||\':\'|| "TEST_MINS" ||\':\'|| "TEST_AM")::time ' . $operator . '\'' . $value . '\'');

            }
            elseif ($column == 'time_of_birth')
            {

                $query->whereRaw('("TOB_TIME" ||\':\'|| "TOB_MINS" ||\':\'|| "TOB_AM")::time ' . $operator . '\'' . $value . '\'');

            }

            break;
            case '#':

            if ($column == 'entry_time')
            {

                foreach ($this->time_entry as $time_entry => $time_entry_value)
                {
                    $query->orWhere($time_entry_value, strtoupper($value));
                }

            }
            elseif ($column == 'time_of_birth')
            {

                foreach ($this->dob_entry as $dob_entry => $dob_entry_value)
                {
                    if ($dob_entry_value == 'TOB_TIME')
                    {
                        $time_value = is_numeric($value) ? $value : null;
                        $query->orWhere($dob_entry_value, $time_value);
                    }
                    elseif ($dob_entry_value == 'TOB_MINS')
                    {
                        $mins_value = is_numeric($value) ? $value : null;
                        $query->orWhere($dob_entry_value, $mins_value);
                    }
                    elseif ($dob_entry_value == 'TOB_AM' && !is_numeric($value))
                    {
                        $query->orWhere($dob_entry_value, strtoupper($value));
                    }
                }
            }

            break;
            case '...':

            if ($column == 'entry_time')
            {
                $valueList = explode($operator, $un_splited_value);

                if (isset($valueList[0]) && isset($valueList[1]))
                {

                    $valueList[0] = Carbon::createFromFormat('h:i a', $valueList[0])->format('H:i:s');
                    $valueList[1] = Carbon::createFromFormat('h:i a', $valueList[1])->format('H:i:s');
                    sort($valueList);
                    $query->whereRaw('("TEST_TIME" ||\':\'|| "TEST_MINS" ||\':\'|| "TEST_AM")::time between' . '\'' . $valueList[0] . '\' and ' . '\'' . $valueList[1] . '\'');
                }

            }
            elseif ($column == 'time_of_birth')
            {

                $valueList = explode($operator, $un_splited_value);
                if (isset($valueList[0]) && isset($valueList[1]))
                {

                    $valueList[0] = Carbon::createFromFormat('h:i a', $valueList[0])->format('H:i:s');
                    $valueList[1] = Carbon::createFromFormat('h:i a', $valueList[1])->format('H:i:s');
                    sort($valueList);
                    $query->whereRaw('("TOB_TIME" ||\':\'|| "TOB_MINS" ||\':\'|| "TOB_AM")::time between' . '\'' . $valueList[0] . '\' and ' . '\'' . $valueList[1] . '\'');
                }
            }

            break;
            default:
            if ($column == 'entry_time')
            {
                $operator = '=';
                $query->whereRaw('("TEST_TIME" ||\':\'|| "TEST_MINS" ||\':\'|| "TEST_AM")::time ' . $operator . '\'' . $value . '\'');

            }
            elseif ($column == 'time_of_birth')
            {
                $operator = '=';
                $query->whereRaw('("TOB_TIME" ||\':\'|| "TOB_MINS" ||\':\'|| "TOB_AM")::time ' . $operator . '\'' . $value . '\'');

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
            if ($table == '')
            {
                $query->orWhere($column, $value);
                    // $query->orWhereNull($column);

            }
            else
            {
                $query->orWhere($table . '.' . $column, $value);
            }
            break;
            case '==':
            if ($table == '')
            {
                $query->orWhere($column, $value);
            }
            else
            {
                $query->orWhere($table . '.' . $column, $value);
            }
            break;
            case '<':
            $query = $this->numberQuerys($column, $operator, $value, $query, $table);
            break;
            case '<=':
            $query = $this->numberQuerys($column, $operator, $value, $query, $table);
            break;
            case '>':
            $query = $this->numberQuerys($column, $operator, $value, $query, $table);
            break;
            case '>=':
            $query = $this->numberQuerys($column, $operator, $value, $query, $table);
            break;
            case '#':

            $value_list = array();

            if (in_array($column, ['g_weeks', 'g_days', 'BirthWeight']))
            {

                $query = $this->singdigitSearch('baby', $column, $value, $query);

            }
            elseif (in_array($column, ['Length', 'OFC', 'TimeOf1stGasp', 'RegularRespiration', 'DurationOfOxygen', 'DepthOfInsertion', 'duration_of_cpr', 'maximum_fio2_required', 'bag_mask_ventilator_min', 'DurationOfPPV', 'CordpH', 'CordHCO3', 'duration_dcc', 'Apgars1min', 'Apgars5min', 'Apgars10min', 'Apgars15min', 'Apgars20min']))
            {

                $query = $this->singdigitSearch('neonatal_proforma', $column, $value, $query);

            }
            elseif (in_array($column, ['MothercYear', 'PartnercYear', 'G_Value', 'P_Value', 'L_Value', 'A_Value']))
            {

                $query = $this->singdigitSearch('mother', $column, $value, $query);

            }
            elseif (in_array($column, ['duration_in_weeks']))
            {

                $query = $this->singdigitSearch('complications', $column, $value, $query);

            }
            elseif (in_array($column, ['Year', 'GA', 'BW']))
            {

                $query = $this->singdigitSearch('delivery_history', $column, $value, $query);

            }
            elseif (in_array($column, ['NbHR', 'NbRR', 'TemperatureF', 'NbSpO2']))
            {

                $query = $this->singdigitSearch('newborn_examination', $column, $value, $query);

            }
            elseif (in_array($column, ['CordBE']))
            {

                $query = $this->signdigitSearch($column, $value, $query);

            }
            elseif (in_array($column, ['Gestation']))
            {

                $query = $this->singdigitSearch('usg_finding', $column, $value, $query);

            }

            break;
            case '...':
            $valueList = explode($operator, $un_splited_value);
            sort($valueList);
            if ($table == '')
            {
                $query->whereBetween($column, $valueList);
            }
            else
            {
                $query->whereBetween($table . '.' . $column, $valueList);
            }
            break;
            default:
            if ($table == '')
            {
                $query->where($column, $value);
            }
            else
            {
                $query->where($table . '.' . $column, $value);
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

        switch ($operator)
        {
            case '=':
                // $query->whereRaw('lower("'.$column.'") like '."'% ".strtolower($value)."%'");
            $query->whereRaw('lower("' . $column . '") like ' . "'%" . strtolower($value) . " %'");
            $query->orwhereRaw('lower("' . $column . '") like ' . "'% " . strtolower($value) . "'");
            $query->orwhereRaw('trim(lower("' . $column . '")) = ' . "'" . trim(strtolower($value)) . "'");
            break;

            case '==':
            $query->whereRaw('trim(lower("' . $column . '")) = ' . "'" . trim(strtolower($value)) . "'");
            break;

            case '""':
                // $query->whereRaw('"'.$column.'" like '."'".$value."%'");
            $query->whereRaw('rtrim(lower("' . $column . '")) like ' . "'% " . rtrim(strtolower($value)) . "%'");
            $query->orWhereRaw('rtrim(lower("' . $column . '")) like ' . "'" . rtrim(strtolower($value)) . " %'");
            $query->orWhereRaw('trim(lower("' . $column . '")) = ' . "'" . trim(strtolower($value)) . "'");
            break;

            case '*""':
                // $value = str_replace(' ', '|', trim($value));
                // $query->whereRaw('to_tsvector("'.$column.'") @@ to_tsquery('."'".$value."'".')');
            $query->whereRaw('rtrim(lower("' . $column . '")) like ' . "'%" . rtrim(strtolower($value)) . "%'");
            break;

            case '@':
            $charater_details = str_split($value);
            foreach ($charater_details as $character_key => $character_value)
            {
                $query->whereRaw('lower("' . $column . '") like ' . "'%" . strtolower($character_value) . "%'");
            }
            break;

            case '!':
                // $query->whereRaw('"'.$column.'" like '."'".$value."%'");
            $query->orwhereRaw('trim(lower("' . $column . '")) like ' . "'" . trim(strtolower($value)) . "'");
            break;

            default:
            if (!is_numeric($un_splited_value) && $column != 'Scalp')
            {
                $query->whereRaw('lower("' . $column . '") = ' . "'" . strtolower($un_splited_value) . "'");
            }
            elseif ($column == 'Scalp')
            {
                $query->whereRaw('lower("' . $column . '") like ' . "'%" . strtolower($value) . "%'");
            }
            else
            {
                $query->where($column, $un_splited_value);
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

        $operator = trim($operator);
        switch ($operator)
        {
            case '=':
            $value = str_replace('=', '', $value);
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
            $value = str_replace('==', '', $value);
            $query->whereDate($column, date('Y-m-d', strtotime($value)));
            break;

            case '//':
            $query->whereDate($column, date('Y-m-d'));
            break;

            case '>':
            $value = str_replace('>', '', $value);
            $query->where($column, '>', date('Y-m-d', strtotime($value)));
            break;

            case '>=':
            $value = str_replace('>=', '', $value);
            $query->where($column, '>=', date('Y-m-d', strtotime($value)));
            break;

            case '<':
            $value = str_replace('<', '', $value);
            $query->where($column, '<', date('Y-m-d', strtotime($value)));
            break;

            case '<=':
            $value = str_replace('<=', '', $value);
            $query->where($column, '<=', date('Y-m-d', strtotime($value)));
            break;

            case '...':
            $un_splited_value = explode('...', $un_splited_value);
                // sort($un_splited_value);
            $un_splited_value = str_replace('/', '-', $un_splited_value);
            $startDate = date('Y-m-d', strtotime($un_splited_value[0]));
            $endDate = date('Y-m-d', strtotime($un_splited_value[1]));
            $query->whereBetween($column, [$startDate, $endDate]);
            break;

            case '?':
            $today = null;
            $today = date('Y-m-d', strtotime($today));
            $query->where($column, '=', $today);
            break;

            case '#':
            $value = (strlen($value) == 1 && $value < 10 && $value > 0) ? '0' . $value : $value;

            if ($column == 'DOB')
            {

                $query = $this->datequery('baby', $column, $value, $query);

            }
            elseif (in_array($column, ['TestDate', 'LMP', 'EDDbyUSG', 'EDDbyDates']))
            {

                $query = $this->datequery('neonatal_proforma', $column, $value, $query);

            }
            elseif (in_array($column, ['PartnerDOB', 'MotherDOB']))
            {

                $query = $this->datequery('mother', $column, $value, $query);

            }

            break;

            default:
            $query->where($column, date('Y-m-d', strtotime($value)));
            break;
        }

        return $query;

    }

    /**
     * This method to get
     * single digit in date search
     *
     * @param $table type string
     *
     * @param $column type sting
     *
     * @param $value  type number
     *
     * @param $query type object
     */

    public function datequery($table, $column, $value, $query)
    {

        $date_list = [];
        $dob_list = DB::table($table)->where('IsDeleted', '0')
        ->get();
        foreach ($dob_list as $dob_key => $dob_value)
        {
            $dob_content = explode('-', $dob_value->$column);
            if (in_array($value, $dob_content))
            {
                $date_list[] = $dob_value->$column;
            }
        }
        $query->whereIn($column, $date_list);

        return $query;
    }

    /**
     * This method to get
     * single digit search
     *
     * @param $table type string
     *
     * @param $column type sting
     *
     * @param $value  type number
     *
     * @param $query type object
     */

    public function singdigitSearch($table, $column, $value, $query)
    {
        $value_list = array();
        $number_list = DB::table($table)->get();
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

        // $valueList = array_unique($value_list);
        if ($table == '')
        {
            $query->orWhereIn($column, $valueList);
        }
        else
        {
            $query->orWhereIn($table . '.' . $column, $valueList);
        }

        return $query;
    }

    /**
     * This method to build query
     * for number search
     *
     * @param $column type text
     *
     * @param $operator type sign
     *
     * @param $value type integer
     *
     * @param $query type query object
     *
     * @param $table type string
     */
    public function numberQuerys($column, $operator, $value, $query, $table)
    {
        if (!in_array($column, ['g_weeks', 'g_days', 'maximum_fio2_required', 'duration_of_cpr']))
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
        elseif (in_array($column, ['g_weeks', 'g_days', 'BirthWeight', 'maximum_fio2_required', 'duration_of_cpr']))
        {
            $query->where($column, $operator, $value);
        }

        return $query;

    }

    /**
     * This Method To Get Baby Details
     * based on neonatal id
     *
     * @param $neonatal_id
     */
    public function getData($neonatal_id)
    {
        return DB::table('baby')->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
        ->join('mother', 'mother.MotherId', '=', 'baby.MotherId')
        ->leftJoin('newborn_examination', 'newborn_examination.BabyId', '=', 'baby.BabyId')
        ->where('neonatal_proforma.NeonatalId', $neonatal_id)->where('baby.IsDeleted', 0)
        ->where('neonatal_proforma.IsDeleted', 0)
        ->where('mother.IsDeleted', 0)
        ->orderby('NeonatalId', 'asc')
        ->first();

    }

    /**
     * This method get all the neonatal proforma
     * list
     *
     * @param $neonatal_ids type array
     */
    public function getNeonatalList($neonatal_ids)
    {
        return DB::table('baby')
        ->select(\DB::raw('DISTINCT ON("neonatal_proforma"."NeonatalId") "neonatal_proforma"."NeonatalId", baby.*, neonatal_proforma.*, mother.*, newborn_examination.*'))
        ->leftJoin('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
        ->leftJoin('mother', 'mother.MotherId', '=', 'baby.MotherId')
        ->leftJoin('newborn_examination', 'newborn_examination.BabyId', '=', 'baby.BabyId')
        ->whereIn('neonatal_proforma.NeonatalId', $neonatal_ids)->where('baby.IsDeleted', 0)
        ->where('neonatal_proforma.IsDeleted', 0)
        ->where('mother.IsDeleted', 0)
        ->orderby('NeonatalId', 'desc')
        ->get();
    }

    public function signdigitSearch($column, $value, $query)
    {

        return $query->where($column, $value);
    }
    /**
     * This method to get
     * seperate the operator form text
     *
     * @param $value type string
     *
     * @param $query type object
     *
     * @param $column type string
     *
     * @return type array
     */
    public function specialsearch($column, $operator, $value, $query, $un_splited_value = '', $table = '')
    {
        $operators = str_split($operator);
        $operator_count = count($operators) - 1;

        if ($operators[$operator_count] == '-' || $operators[$operator_count] == '+')
        {
            $operator = null;
            $value = $operators[$operator_count] . $value;
            for ($operator_index = 0;$operator_index < $operator_count;$operator_index++)
            {
                $operator .= $operators[$operator_index];
            }
        }

        return $this->numbersearch($column, $operator, $value, $query, $un_splited_value = '', $table = '');
    }
}

