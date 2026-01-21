<?php
namespace App\Models\Search;

use Illuminate\Database\Schema\Builder as Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Searchdaycare extends Model
{

    protected $daycareFields = ['directlybreastfeed', 'othertypefeed', 'ResICD', 'systolic_bp', 'diastolic_bp', 'cg_weeks', 'cg_days', 'workingWeight', 'iv_fluids', 'drug_infusions', 'other_drugs', 'Carbohydrates', 'Protein', 'Fat', 'Pupils', 'sedation_paralysis', 'urine_output_day', 'drug_infusions_ml_day', 'iv_fluids_ml_day', 'total_energy', 'neuro_sonogram', 'gir', 'needlethoracentesis', 'intercostaldrain', 'chronic_lung', 'ultrasoundabdominal', 'ultrasoundkeyfindings', 'renalultrasound', 'renalultrasoundkeyfindings', 'mri_ct_brain', 'mrict_brain_status', 'viral_meningitis', 'lumbar_puncture', 'ultrasound_spine', 'ultrasound_spine_report', 'eeg_cfm_report', 'dilution_exchange', 'BabyName', 'Sex', 'DOB', 'DayDate', 'Background', 'BabyBloodGroup', 'baby.BMrNo', 'Notes', 'DayOfLife', 'Care', 'PreviousProblems', 'CurrentProblems', 'Rop', 'Plan', 'Skin', 'PeripheralCannula', 'PvcComplication', 'Picc', 'PiccSite', 'PiccDay', 'PiccComplication', 'Uvc', 'UvcPosition', 'UvcDay', 'UvcComplication', 'Uac', 'UacPosition', 'UacDay', 'UacComplication', 'Pac', 'PacSite', 'PacDay', 'PacComplication', 'Cuss', 'Sepsis', 'BloodCulture', 'PositiveBlood', 'Meningitis', 'CRP', 'TLC', 'Percentage', 'ANC', 'Platelets', 'TotalFluid', 'PreviousWt', 'CurrentWt', 'WtChange', 'PercentageChange', 'UrineOutput', 'UO', 'BloodOut', 'DrainOutput', 'RBS', 'Transfusion', 'AnteriorFontanelle', 'Activity', 'Tone', 'Cry', 'Seizures', 'TypeOfSeizures', 'NeonatalReflexes', 'CnsFindings', 'Feeds', 'Volume', 'Frequency', 'Ivf', 'Tpn', 'AspirateVolume', 'AspirateNature', 'StoolNature', 'Abdomen', 'BowelSounds', 'AbdominalGirth', 'PAFindings', 'AxrFindings', 'Umbilicus', 'Hepatomegaly', 'LiverSpan', 'Splenomegaly', 'SpleenSpan', 'Herina', 'Genitalia', 'TSB', 'NNJTreatment', 'HR', 'MeanBP', 'PulsePressure', 'CentralPulses', 'PeripheralPulses', 'FemoralPulses', 'PrecordialActivity', 'S1S2', 'Murmur', 'CharacterOfMurmur', 'CVSFindings', 'CFT', 'CentralTemperature', 'PeripheralTemperature', 'Color', 'Inotropes', 'Dopamine', 'Dobutamine', 'Adrenaline', 'DayEcho', 'ModeOfVentilation', 'RR', 'Retractions', 'AirEntry', 'ChestMovement', 'AddedSounds', 'DayCharacter', 'CXRFindings', 'RSFindings', 'PIP', 'PEEP', 'MAP', 'FiO2', 'Rate', 'IT', 'TypeOfBloodGas', 'Ph', 'PaO2', 'PaCo2', 'HCO3', 'BE', 'Lactate', 'EtTube', 'Size', 'Lips', 'SaO2PostDuctal', 'AaDO2', 'OI', 'PDA', 'PDATreatment', 'InvasiveVentilation', 'NonInvasiveVentilation', 'OtherRespiratorySupport', 'FullEnteralFeeds', 'TypeofFeeds', 'NECtreatment', 'NEC', 'Hypoglycemia', 'Hyperglycemia', 'InsulinTherapy', 'Hyponatremia', 'Hypernatremia', 'Hypokalemia', 'Hyperkalemia', 'Hypocalcemia', 'Hypercalcemia', 'NicuICD', 'Immunoglobulins', 'Noradrenaline', 'Milrinone', 'TherapeuticHypothermia', 'frequency_rep', 'Flow', 'Surfactant_therapy_nicu', 'Spontaneouslyventilating', 'Ventilation_choose', 'day_name', 'echo_status', 'pphn', 'pphn_treatement', 'surfactant_indication', 'CarICD', 'GasICD', 'Stools', 'MotherBloodGroup', 'CenICD', 'FluidICD', 'SepsisICD', 'SkinICD', 'RopICD', 'SeenBy', 'eeg_cfm', 'Day_Time', 'LastBG'];
    protected $daycareDates = ['DOB', 'DayDate'];
    protected $daycareText = ['BabyName', 'baby.BMrNo', 'CurrentProblems', 'PreviousProblems', 'Background', 'DayCharacter', 'CXRFindings', 'RSFindings', 'CharacterOfMurmur', 'CVSFindings', 'DayEcho', 'PAFindings', 'AxrFindings', 'ultrasoundkeyfindings', 'Pupils', 'TypeOfSeizures', 'CnsFindings', 'Cuss', 'mri_ct_brain', 'renalultrasoundkeyfindings', 'PvcComplication', 'PiccComplication', 'UvcComplication', 'UacComplication', 'PacComplication', 'Skin', 'Rop', 'Plan', 'Notes', 'eeg_cfm_report', 'ultrasound_spine_report'];
    protected $daycareNumber = ['cg_weeks', 'cg_days', 'PIP', 'PEEP', 'MAP', 'FiO2', 'Rate', 'frequency_rep', 'RR', 'SaO2PostDuctal', 'systolic_bp', 'diastolic_bp', 'MeanBP', 'LiverSpan', 'SpleenSpan', 'PiccDay', 'UvcDay', 'UacDay', 'PacDay', 'HR', 'TLC', 'Platelets'];
    protected $daycareSelect = ['Care', 'Sex', 'InvasiveVentilation', 'Ventilation_choose', 'ModeOfVentilation', 'NonInvasiveVentilation', 'OtherRespiratorySupport', 'Spontaneouslyventilating', 'Retractions', 'AirEntry', 'ChestMovement', 'AddedSounds', 'TypeOfBloodGas', 'EtTube', 'Size', 'PulsePressure', 'CentralPulses', 'PeripheralPulses', 'FemoralPulses', 'PrecordialActivity', 'S1S2', 'Murmur', 'CFT', 'Color', 'Inotropes', 'echo_status', 'PDA', 'PDATreatment', 'pphn', 'pphn_treatement', 'Frequency', 'FullEnteralFeeds', 'TypeofFeeds', 'Tpn', 'AspirateNature', 'StoolNature', 'Abdomen', 'BowelSounds', 'NEC', 'NECtreatment', 'Umbilicus', 'Hepatomegaly', 'Splenomegaly', 'Herina', 'NNJTreatment', 'Immunoglobulins', 'BabyBloodGroup', 'MotherBloodGroup', 'OtherRespiratorySupport', 'EtTube', 'Size', 'TherapeuticHypothermia', 'AnteriorFontanelle', 'Activity', 'Tone', 'Cry', 'Seizures', 'NeonatalReflexes', 'UrineOutput', 'Transfusion', 'Sepsis', 'BloodCulture', 'Meningitis', 'PeripheralCannula', 'Picc', 'PiccSite', 'Uvc', 'UvcPosition', 'Uac', 'UacPosition', 'Pac', 'PacSite', 'daycare.SeenBy', 'lumbar_puncture'];
    protected $radioValues = ['Hypoglycemia', 'Hyperglycemia', 'InsulinTherapy', 'Hyponatremia', 'Hypernatremia', 'Hypokalemia', 'Hyperkalemia', 'Hypocalcemia', 'Hypercalcemia', 'directlybreastfeed', 'othertypefeed'];
    protected $toggleValues = ['Surfactant_therapy_nicu', 'needlethoracentesis', 'intercostaldrain', 'chronic_lung', 'ultrasoundabdominal', 'renalultrasound', 'mrict_brain_status', 'ultrasound_spine', 'eeg_cfm', 'viral_meningitis', 'dilution_exchange', 'Stools', 'neuro_sonogram'];
    protected $castsValues = ['DayOfLife', 'Flow', 'PositiveBlood', 'RBS', 'DrainOutput', 'Rate', 'MeanBP', 'CurrentWt', 'WtChange', 'workingWeight', 'Dopamine', 'Noradrenaline', 'Milrinone', 'Dobutamine', 'Adrenaline', 'IT', 'PaO2', 'frequency_rep', 'PEEP', 'PIP', 'MAP', 'FiO2'];
    protected $unformated = [];
    protected $dotValues = ['Ivf', 'ANC', 'AbdominalGirth', 'Percentage', 'TotalFluid', 'total_energy', 'TSB', 'AspirateVolume', 'Fat', 'Protein', 'Carbohydrates', 'other_drugs', 'drug_infusions_ml_day', 'drug_infusions', 'iv_fluids_ml_day', 'iv_fluids', 'Feeds', 'Volume', 'PeripheralTemperature', 'OI', 'CentralTemperature', 'BE', 'PercentageChange', 'CRP', 'Flow', 'HCO3', 'PaCo2', 'Ph', 'Lactate', 'Lips', 'AaDO2', 'Genitalia', 'UO', 'PreviousWt', 'urine_output_day', 'BloodOut', 'gir'];
    protected $daycareJson = ['NicuICD'];
    protected $daycareToggle = ['Surfactant_therapy_nicu'];
    protected $stoolsToggle = ['Stools'];
    protected $daycareMultiSelect = ['F_Product', 'F_Volume', 'A_Antibiotic', 'A_Day', 'drugs'];
    protected $timevalues = ['Day_Time', 'LastBG'];
    protected $time_entry = ['DayTime', 'DayTime_MINS', 'DayTime_AM'];

    public function getList($page = 1, $limit = 5, $data = array(), $order = array())
    {
        $limitstart    = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend      = $limit;

        $daycareFields = array();

        $daycareJson = array();

        $time_values = [];

        if (!isset($data['BMrNo']))
        {
            $data['BMrNo'] = '';
        }

        foreach ($this->daycareFields as $daycareFieldsKey => $daycareFieldsValue)
        {

            // assign all the values to array
            if (isset($data[$daycareFieldsValue]) && !is_array($data[$daycareFieldsValue]) && !empty(trim($data[$daycareFieldsValue])) && trim($data[$daycareFieldsValue]) != 'N/A')
            {

                $daycareFields[$daycareFieldsValue] = trim($data[$daycareFieldsValue]);

            }
            elseif (isset($data[$daycareFieldsValue]) && is_array($data[$daycareFieldsValue]))
            {

                $daycareJson[$daycareFieldsValue] = $data[$daycareFieldsValue];

            }
            elseif ($daycareFieldsValue == 'baby.BMrNo' && !empty($data['BMrNo']))
            {

                $daycareFields[$daycareFieldsValue] = $data['BMrNo'];

            }

        }

        foreach ($daycareFields as $datakey => $dataValue)
        {

            if (in_array($datakey, $this->radioValues))
            {

                $daycareFields[$datakey] = 1;

            }

            if (in_array($datakey, $this->toggleValues))
            {

                $daycareFields[$datakey] = 2;

            }
            if (in_array($datakey, $this->daycareToggle))
            {

                $daycareFields[$datakey] = 'Yes';

            }
            if (in_array($datakey, $this->stoolsToggle))
            {

                $daycareFields[$datakey] = 'Bowels opened';

            }
        }

        if (isset($daycareFields['neuro_sonogram']))
        {
            $daycareFields['neuro_sonogram'] = 'performed';
        }

        foreach ($this->daycareJson as $daycareJson_key => $daycareJson_value)
        {
            if (isset($data[$daycareJson_value]))
            {
                $daycareJson[] = $data[$daycareJson_value];
            }
        }

        $daycare_multi_select = array();
        foreach ($this->daycareMultiSelect as $key => $value)
        {
            if (isset($data[$value]) && is_array($data[$value]))
            {
                foreach ($data[$value] as $selectValue)
                {
                	if (!empty($selectValue)) {
	                    if ($value == 'F_Product')
	                    {
	                        $temp_array['Product'] = $selectValue;
	                    }
	                    elseif ($value == 'F_Volume')
	                    {
	                        $temp_array['blood_products.Volume'] = $selectValue;
	                    }
	                    elseif ($value == 'A_Antibiotic')
	                    {
	                        $temp_array['Antibiotic'] = $selectValue;
	                    }
	                    elseif ($value == 'A_Day')
	                    {
	                        $temp_array['Day'] = $selectValue;
	                    }
	                }
                }
                if (isset($temp_array))
                {
                    $daycare_multi_select[$value] = $temp_array;
                }
                unset($temp_array);
            }
        }

        foreach ($this->timevalues as $timevalues_key => $timevalues_value)
        {
            if (isset($data[$timevalues_value]) && $data[$timevalues_value] != '' && !empty($timevalues_value))
            {

                $time_values[$timevalues_value] = $data[$timevalues_value];
            }
        }

        $daycareText = $this->daycareText;
        $daycareNumber = $this->daycareNumber;
        $daycareDates = $this->daycareDates;
        $castsValues = $this->castsValues;
        $unformated = $this->unformated;
        $dotValues = $this->dotValues;
        $daycareSelect = $this->daycareSelect;
        $toggleValues = $this->toggleValues;
        $radioValues = $this->radioValues;
        $time_fields = $this->timevalues;

        $results = array();

        if (count($daycareFields) > 0 || count($daycareJson) > 0 || count($daycare_multi_select) > 0 || count($time_values) > 0) {

            \DB::enableQueryLog();

        	$result = \DB::table('daycare')
            ->select(\DB::raw('DISTINCT ON("daycare"."DayId") "daycare"."DayId"'))
            // ->select('baby.*', 'daycare.*', 'daycare_questions.*', 'baby_admission.*', 'mother.MotherBloodGroup', 'blood_products.*', 'antibiotics.*')
	            			// ->addselect('daycare.DayId as day_id', 'daycare.BabyId as baby_id', 'baby.BMrNo as baby_mrno')
				            // ->addselect('blood_products.*')
				            ->join('baby', 'baby.BabyId', '=', 'daycare.BabyId')
				            ->join('baby_admission', 'baby_admission.AdmissionId', '=', 'daycare.AdmissionId')
				            ->leftjoin('daycare_questions', 'daycare_questions.DayId', '=', 'daycare.DayId')
				            ->leftjoin('mother', 'mother.MotherId', '=', 'baby.MotherId')
				            ->leftjoin('blood_products', 'blood_products.BabyId', '=', 'baby.BabyId')
				            ->leftjoin('antibiotics', 'antibiotics.BabyId', '=', 'baby.BabyId')
				            ->where(['baby.IsDeleted' => '0', 'daycare.IsDeleted' => 0])
					        // ->where(['baby.IsDeleted'=>'0', 'daycare.IsDeleted'=>0, 'baby_admission.AdmissionType'=>'NICU', 'baby_admission.Status'=>'Inpatient'])
					        ->where(function ($query) use ($daycareDates, $castsValues, $unformated, $dotValues, $daycareText, $daycareNumber, $daycareSelect, $toggleValues, $radioValues, $time_values, $time_fields, $daycareFields, $daycareJson, $daycare_multi_select)
					        {

					            if (count($daycareFields) > 0)
					            {

					                foreach ($daycareFields as $key => $value)
					                {

					                    if (in_array($key, $daycareText))
					                    {

					                        if ($key == 'baby.BMrNo')
					                        {

					                            $key = 'baby".' . '"BMrNo';

					                        }

					                        if (preg_replace('/[\/]/', '', trim(preg_replace('/[A-Z,a-z,0-9]/', '', $value))) == '@')
					                        {

					                            $formatedValues = str_split(trim(preg_replace('/[@]/', '', $value)));

					                            foreach ($formatedValues as $singleLetters)
					                            {

					                                if (!empty($singleLetters))
					                                // $query->orwhere($key, 'like', '%'.$singleLetters.'%');
					                                $query->whereRaw('lower("' . $key . '") like ' . "'%" . strtolower($singleLetters) . "%'");
					                            }

					                        }
					                        elseif (trim(preg_replace('/[A-Z,a-z,0-9,\/,:,_,-]/', '', $value)) == '=')
					                        {

					                            $formatedValues = trim(preg_replace('/[=]/', '', $value));
					                            // $query->where($key, 'like', '%'.$formatedValues.'%');
					                            $query->whereRaw('rtrim(lower("' . $key . '")) like ' . "'% " . rtrim(strtolower($formatedValues)) . " %'");
					                            $query->orWhereRaw('rtrim(lower("' . $key . '")) like ' . "'" . rtrim(strtolower($formatedValues)) . " %'");
					                            $query->orWhereRaw('rtrim(lower("' . $key . '")) like ' . "'% " . rtrim(strtolower($formatedValues)) . "'");
					                            $query->orWhereRaw('trim(lower("' . $key . '")) = ' . "'" . trim(strtolower($formatedValues)) . "'");

					                        }
					                        elseif (preg_replace('/[\/]/', '', trim(preg_replace('/[A-Z,a-z,0-9,\/,:,_,-]/', '', $value))) == '==')
					                        {

					                            $formatedValues = str_replace('==', '', $value);

					                            // $key  = 'baby.'.'BMrNo';
					                            // $query->where($key, $formatedValues);
					                            $query->whereRaw('rtrim(lower("' . $key . '")) = ' . "'" . rtrim(strtolower($formatedValues)) . "'");

					                        }
					                        elseif (trim(preg_replace('/[A-Z,a-z,0-9,\/,:,_,-]/', '', $value)) == '""')
					                        {

					                            $formatedValues = str_replace('""', '', $value);

					                            $query->orWhereRaw('rtrim(lower("' . $key . '")) like ' . "'% " . rtrim(strtolower($formatedValues)) . "%'");
					                            $query->orWhereRaw('rtrim(lower("' . $key . '")) like ' . "'" . rtrim(strtolower($formatedValues)) . " %'");
					                            $query->orWhereRaw('trim(lower("' . $key . '")) = ' . "'" . trim(strtolower($formatedValues)) . "'");

					                        }
					                        elseif (preg_replace('/[\/]/', '', trim(preg_replace('/[A-Z,a-z,0-9,\/,:,_,-]/', '', $value))) == '*""')
					                        {

					                            $formatedValues = str_replace('*""', '', $value);

					                            $query->whereRaw('rtrim(lower("' . $key . '")) like ' . "'%" . rtrim(strtolower($formatedValues)) . "%'");

					                        }
					                        elseif (preg_replace('/[\/]/', '', trim(preg_replace('/[A-Z,a-z,0-9,\/,:,_,-]/', '', $value))) == '!')
					                        {

					                            $formatedValues = str_replace('!', '', $value);

					                            $query->orwhereRaw('trim(lower("' . $key . '")) like ' . "'" . trim(strtolower($formatedValues)) . "'");

					                        }
					                        else
					                        {

					                            $query->whereRaw('rtrim(lower("' . $key . '")) like ' . "'%" . rtrim(strtolower($value)) . "%'");

					                        }

					                    }
					                    elseif (in_array($key, $daycareNumber))
					                    {

					                        if (trim(preg_replace('/[0-9]/', '', $value)) == '<')
					                        {

					                            $formatedValues = trim(preg_replace('/[<]/', '', $value));

					                            $query->where($key, '<', $formatedValues);

					                        }
					                        elseif (trim(preg_replace('/[0-9]/', '', $value)) == '<=')
					                        {

					                            $formatedValues = trim(preg_replace('/[<=]/', '', $value));

					                            $query->where($key, '<=', $formatedValues);

					                        }
					                        elseif (trim(preg_replace('/[0-9]/', '', $value)) == '>')
					                        {

					                            $formatedValues = trim(preg_replace('/[>]/', '', $value));

					                            $query->where($key, '>', $formatedValues);

					                        }
					                        elseif (trim(preg_replace('/[0-9]/', '', $value)) == '>=')
					                        {

					                            $formatedValues = trim(preg_replace('/[>=]/', '', $value));

					                            $query->where($key, '>=', $formatedValues);

					                        }
					                        elseif (trim(preg_replace('/[0-9]/', '', $value)) == '...')
					                        {

					                            $formatedValues = explode('...', $value);

					                            $query->whereBetween($key, $formatedValues);

					                        }
					                        elseif (trim(preg_replace('/[0-9]/', '', $value)) == '#')
					                        {

					                            $formatedValues = trim(preg_replace('/[#]/', '', $value));

					                            // $query->whereRaw($key, 'like', '%'.$formatedValues.'%');
					                            if (in_array($key, ['cg_weeks', 'cg_days', 'systolic_bp', 'diastolic_bp']))
					                            {

					                                $query = $this->singdigitSearch('daycare', $key, $formatedValues, $query);

					                            }

					                        }
					                        elseif (trim(preg_replace('/[0-9]/', '', $value)) == '=')
					                        {

					                            $formatedValues = trim(preg_replace('/[=]/', '', $value));

					                            // $query->where($key, 'like', '%'.$formatedValues.'%');
					                            $query->where($key, $formatedValues);

					                        }
					                        elseif (trim(preg_replace('/[0-9]/', '', $value)) == '==')
					                        {

					                            $formatedValues = trim(str_replace('==', '', $value));

					                            $query->where($key, $formatedValues);

					                        }
					                        else
					                        {

					                            $query->where($key, $value);

					                        }

					                    }
					                    elseif (in_array($key, $daycareDates))
					                    {

					                        $condition = preg_replace('/[0-9]/', '', preg_replace('/[-]/', '', $value));

					                        switch ($condition)
					                        {
					                            case '...':
					                                $formatedValues = explode('...', $value);

					                                $formatedValues[0] = isset($formatedValues[0]) ? date('Y-m-d', strtotime($formatedValues[0])) : '';

					                                $formatedValues[1] = isset($formatedValues[1]) ? date('Y-m-d', strtotime($formatedValues[1])) : '';

					                                $query->whereBetween($key, $formatedValues);

					                            break;
					                            case '//':

					                                $query->whereDate($key, '=', date('Y-m-d'));

					                            break;

					                            case '?':
					                                $invalid_date = null;
					                                $invalid_date = date('Y-m-d', strtotime($invalid_date));
					                                $query->where($key, '=', '1970-01-01');
					                            break;

					                            case '!':
					                                $dublicate_values = \DB::table('baby')->selectRaw('DISTINCT "DOB"')
					                                    ->where('IsDeleted', 0)
					                                    ->get()
					                                    ->pluck('DOB')
					                                    ->toArray();
					                                $query->whereNotIn($key, $dublicate_values);
					                            break;

					                            case '#':
					                                $formatedValues = explode('#', $value) [1];

					                                $value = (strlen($formatedValues) == 1 && $formatedValues < 10 && $formatedValues > 0) ? '0' . $formatedValues : $formatedValues;
					                                $date_list = array();

					                                if ($key == 'DOB')
					                                {
					                                    $dob_list = \DB::table('baby')->where('IsDeleted', 0)
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
					                                elseif ($key == 'DayDate')
					                                {
					                                    $daydate_list = \DB::table('daycare')->where('IsDeleted', 0)
					                                        ->get();
					                                    foreach ($daydate_list as $daydate_key => $daydate_value)
					                                    {
					                                        $daydate_content = explode('-', $daydate_value->DayDate);
					                                        if (in_array($value, $daydate_content))
					                                        {
					                                            $date_list[] = $daydate_value->DayDate;
					                                        }
					                                    }
					                                }
					                                $query->whereIn($key, $date_list);
					                            break;

					                            default:
					                                $query->whereDate($key, '=', date('Y-m-d', strtotime($value)));
					                            break;
					                        }

					                    }
					                    elseif (in_array($key, $castsValues))
					                    {

					                        $condition = trim(preg_replace('/[0-9]/', '', $value));

					                        $formatedValues = (!empty($condition)) ? (int)trim(str_replace($condition, '', $value)) : (int)$value;

					                        switch ($condition)
					                        {

					                            case '=':
					                                $query->where($key, 'like', '%' . $formatedValues . '%');
					                                // $query->whereRaw('CAST (NULLIF("'.$key.'",'."''".') as FLOAT) ='.$formatedValues);
					                                
					                            break;
					                            case '<':

					                                $query->whereRaw('CAST (NULLIF("' . $key . '",' . "''" . ') as FLOAT) <' . $formatedValues);

					                            break;
					                            case '<=':

					                                $query->whereRaw('CAST (NULLIF("' . $key . '",' . "''" . ') as FLOAT) <=' . $formatedValues);

					                            break;
					                            case '>':

					                                $query->whereRaw('CAST (NULLIF("' . $key . '",' . "''" . ') as FLOAT) >' . $formatedValues);

					                            break;
					                            case '>=':

					                                $query->whereRaw('CAST (NULLIF("' . $key . '",' . "''" . ') as FLOAT) >=' . $formatedValues);

					                            break;
					                            case '...':

					                                $formatedValues = explode('...', $value);

					                                $query->whereRaw('CAST (NULLIF("' . $key . '",' . "''" . ') as FLOAT) between ' . $formatedValues[0] . ' and ' . $formatedValues[1]);

					                            break;
					                            case '#':

					                                $query->where($key, 'like', '%' . $formatedValues . '%');

					                            break;
					                            default:

					                                $query->whereRaw('CAST (NULLIF("' . $key . '",' . "''" . ') as FLOAT) =' . $formatedValues);

					                            break;
					                        }

					                    }
					                    elseif (in_array($key, $unformated))
					                    {

					                        $formatedValues = trim(preg_replace('/[#,<,<=,>,>=,...,=,==]/', '', $value));

					                        $query->where($key, 'like', '%' . $formatedValues . '%');

					                    }
					                    elseif (in_array($key, $dotValues))
					                    {

					                        $condition = preg_match_all('/[.]/', $value);

					                        if ($condition == 1)
					                        {
					                            $condition = trim(preg_replace('/[0-9,.]/', '', $value));
					                        }
					                        else
					                        {
					                            $condition = trim(preg_replace('/[0-9]/', '', $value));
					                        }

					                        $formatedValues = trim(str_replace($condition, '', $value));

					                        switch ($condition)
					                        {

					                            case '=':
					                                $query->where($key, 'like', '%' . $formatedValues . '%');
					                                // $query->whereRaw('CAST(NULLIF("'.$key.'",'."''".') as FLOAT) = '.$formatedValues);
					                                
					                            break;
					                            case '<':

					                                $query->whereRaw('CAST(NULLIF("' . $key . '",' . "''" . ') as FLOAT) < ' . $formatedValues);

					                            break;
					                            case '<=':

					                                $query->whereRaw('CAST(NULLIF("' . $key . '",' . "''" . ') as FLOAT) <= ' . $formatedValues);

					                            break;
					                            case '>':

					                                $query->whereRaw('CAST(NULLIF("' . $key . '",' . "''" . ') as DOUBLE PRECISION) > ' . $formatedValues);

					                            break;
					                            case '>=':

					                                $query->whereRaw('CAST(NULLIF("' . $key . '",' . "''" . ') as FLOAT) >= ' . $formatedValues);

					                            break;
					                            case '...':

					                                $formatedValues = explode('...', $value);

					                                if (isset($formatedValues[0]) && isset($formatedValues[1])) $query->whereRaw('CAST(NULLIF("' . $key . '",' . "''" . ') as FLOAT) >= ' . $formatedValues[0] . 'and CAST(NULLIF("' . $key . '",' . "''" . ') as FLOAT) <=' . $formatedValues[1]);

					                                break;
					                            case '..':
					                                $formatedValues = explode('..', $value);

					                                // $query->whereRaw('(CAST (NULLIF("'.$key.'",'."''".') as INTEGER)'.$formatedValues[0].' and '.$formatedValues[1]);
					                                $query->whereBetween($key, $formatedValues);

					                                break;
					                            case '#':

					                                $query->where($key, 'like', '%' . $formatedValues . '%');

					                                break;
					                            default:

					                                $query->whereRaw('CAST(NULLIF("' . $key . '",' . "''" . ') as FLOAT) = ' . $formatedValues);

					                                break;
					                            }

					                    }
					                    elseif (in_array($key, $daycareSelect))
					                    {

					                        if ($value != 'N/A')
					                        {
					                            $query->where($key, 'like', '%' . $value . '%');
					                        }

					                    }
					                    elseif (in_array($key, $toggleValues))
					                    {

					                        $query->where($key, $value);

					                    }
					                    elseif (in_array($key, $radioValues))
					                    {

					                        $query->where($key, $value);

					                    }
					                }
					            }

					            if (count($daycareJson) > 0)
					            {
					                foreach ($daycareJson as $jsonvalue_key => $jsonvalue_value)
					                {
					                    foreach ($jsonvalue_value as $drugs_key => $drugs_value)
					                    {
					                        $query->where('NicuICD', 'like', '%' . $drugs_value . '%');
					                    }
					                }
					            }
					            // $query->whereRaw('json_array_elements(CAST ("NicuICD" as JSON)->'."'ResICD'".') IN ('.$daycareJson['ResICD'].')');
					            if (count($daycare_multi_select) > 0)
					            {
					                foreach ($daycare_multi_select as $multi_select_key => $multi_select_value)
					                {
					                    foreach ($multi_select_value as $key => $value)
					                    {
					                        if ($value != '')
					                        {
					                            $query->orWhere($key, $value);
					                        }
					                    }
					                }
					            }

					            if (count($time_values) > 0)
					            {
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
					            }

					        })
				            ->orderBy('daycare.DayId', 'desc');

            $temp_result = $result->get();

            $results['count'] = $temp_result->count();

            $results['very_first'] = isset($temp_result[0]) ? $temp_result[0]->DayId : 0;
            $results['very_last'] = isset($temp_result[$results['count']-1]->DayId) ? $temp_result[$results['count']-1]->DayId : 0;

            $results['data'] = $result->limit($limitend)
            ->offset($limitstart)
            ->get();

            $query_log = \DB::getQueryLog();

            $last_log = end($query_log);
            $last_log['bindings'][] = $limitend;
            $last_log['bindings'][] = $limitstart;

            $last_log['bindings'] = "'". implode("','", $last_log['bindings']) . "'";
            $last_log['search_module'] = 5;
            $results['query_log_id'] = SearchQueryLog::create($last_log)->id;
            \DB::flushQueryLog();
        
		
		}

        return $results;

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

                if ($column == 'Day_Time')
                {

                    $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');

                    $query->orWhereRaw('("DayTime" ||\':\'|| "DayTime_MINS" ||\':\'|| "DayTime_AM")::time ' . $operator . '\'' . $value . '\'');

                }
                else
                {

                    $query->orWhere($column, strtoupper($value));

                }

            break;
            case '==':

                if ($column == 'Day_Time')
                {

                    $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');

                    $operator = '=';

                    $query->orWhereRaw('("DayTime" ||\':\'|| "DayTime_MINS" ||\':\'|| "DayTime_AM")::time ' . $operator . '\'' . $value . '\'');

                }
                else
                {

                    $query->orWhere($column, strtoupper($value));

                }

            break;
            case '<':

                if ($column == 'Day_Time')
                {

                    $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');

                    $query->orWhereRaw('("DayTime" ||\':\'|| "DayTime_MINS" ||\':\'|| "DayTime_AM")::time ' . $operator . '\'' . $value . '\'');

                }
                else
                {

                    $query->orWhere($column, '<', strtoupper($value));

                }

            break;
            case '<=':

                if ($column == 'Day_Time')
                {

                    $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');

                    $query->orWhereRaw('("DayTime" ||\':\'|| "DayTime_MINS" ||\':\'|| "DayTime_AM")::time ' . $operator . '\'' . $value . '\'');

                }
                else
                {

                    $query->orWhere($column, '<=', strtoupper($value));

                }

            break;
            case '>':

                if ($column == 'Day_Time')
                {

                    $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');

                    $query->orWhereRaw('("DayTime" ||\':\'|| "DayTime_MINS" ||\':\'|| "DayTime_AM")::time ' . $operator . '\'' . $value . '\'');

                }
                else
                {

                    $query->orWhere($column, '>', strtoupper($value));

                }

            break;
            case '>=':

                if ($column == 'Day_Time')
                {

                    $value = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');

                    $query->orWhereRaw('("DayTime" ||\':\'|| "DayTime_MINS" ||\':\'|| "DayTime_AM")::time ' . $operator . '\'' . $value . '\'');

                }
                else
                {

                    $query->orWhere($column, '>=', strtoupper($value));

                }

            break;
            case '#':

                if ($column == 'Day_Time')
                {

                    $value_list = array();

                    foreach ($this->time_entry as $time_entry => $time_entry_value)
                    {

                        if (in_array($time_entry_value, ['DayTime', 'DayTime_MINS', 'DayTime_AM']))
                        {

                            $query = $this->singdigitSearch('daycare', $time_entry_value, strtoupper($value) , $query);

                        }

                    }

                }
                else
                {

                    if (in_array($column, ['LastBG']))
                    {

                        $query = $this->singdigitSearch('daycare', $column, strtoupper($value) , $query);

                    }
                }

            break;
            case '...':

                if ($column == 'Day_Time')
                {

                    $valueList = explode($operator, $un_splited_value);

                    if (isset($valueList[0]) && isset($valueList[1]))
                    {

                        $valueList[0] = Carbon::createFromFormat('h:i a', $valueList[0])->format('H:i:s');
                        $valueList[1] = Carbon::createFromFormat('h:i a', $valueList[1])->format('H:i:s');
                        sort($valueList);
                        $query->orWhereRaw('("DayTime" ||\':\'|| "DayTime_MINS" ||\':\'|| "DayTime_AM")::time between' . '\'' . $valueList[0] . '\' and ' . '\'' . $valueList[1] . '\'');
                    }

                }
                else
                {

                    $formatedValues = explode('...', $un_splited_value);

                    $query->orWhereBetween($column, $formatedValues);

                }

            break;
            default:

                if ($column == 'Day_Time')
                {

                    $operator = '=';

                    $query->orWhereRaw('("DayTime" ||\':\'|| "DayTime_MINS" ||\':\'|| "DayTime_AM")::time ' . $operator . '\'' . $value . '\'');

                }
                else
                {

                    $query->orWhere($column, strtoupper($value));

                }

            break;

        }

        return $query;

    }

    public function getBabydetails($dayId)
    {

        return \DB::table('daycare')->select('baby.*', 'daycare.*', 'daycare_questions.*', 'baby_admission.*', 'mother.MotherBloodGroup', 'blood_products.*', 'nicu_admission.SeenBy')
            ->addselect('daycare.DayId as day_id', 'daycare.BabyId as baby_id', 'baby.BMrNo as baby_mrno')
            ->addselect('blood_products.Volume as blood_volume', 'blood_products.Product as blood_product')
            ->join('baby', 'baby.BabyId', '=', 'daycare.BabyId')
            ->leftjoin('baby_admission', 'baby_admission.AdmissionId', '=', 'daycare.AdmissionId')
            ->leftjoin('daycare_questions', 'daycare_questions.DayId', '=', 'daycare.DayId')
            ->leftjoin('mother', 'mother.MotherId', '=', 'baby.MotherId')
            ->leftjoin('blood_products', 'blood_products.BabyId', '=', 'baby.BabyId')
            ->leftjoin('nicu_admission', 'nicu_admission.BabyId', '=', 'baby.BabyId')
            ->where('daycare.DayId', $dayId)->where(['baby.IsDeleted' => '0', 'daycare.IsDeleted' => 0])
        // ->where(['baby.IsDeleted'=>'0', 'daycare.IsDeleted'=>0, 'baby_admission.AdmissionType'=>'NICU', 'baby_admission.Status'=>'Inpatient'])
        
            ->orderBy('daycare.DayId', 'desc')
            ->first();

    }

    /**
     * This method get babydetails by $dayid
     * @param $dayId type integer
     *
     * @return array of object
     */
    public function getdaycareList($dayIds)
    {

        return \DB::table('daycare')
        ->select('baby.BabyId', 'daycare.DayId', 'BabyName', 'baby.BMrNo', 'episodes', 'day_name')
        // ->select('baby.*', 'daycare.*', 'daycare_questions.*', 'baby_admission.*', 'mother.MotherBloodGroup')
            // ->addselect('daycare.DayId as day_id', 'daycare.BabyId as baby_id', 'baby.BMrNo as baby_mrno')
        // ->addselect('blood_products.Volume as blood_volume', 'blood_products.Product as blood_product')
        
            ->join('baby', 'baby.BabyId', '=', 'daycare.BabyId')
            ->leftjoin('baby_admission', 'baby_admission.AdmissionId', '=', 'daycare.AdmissionId')
            ->leftjoin('daycare_questions', 'daycare_questions.DayId', '=', 'daycare.DayId')
            ->leftjoin('mother', 'mother.MotherId', '=', 'baby.MotherId')
        // ->leftjoin('blood_products', 'blood_products.BabyId', '=', 'baby.BabyId')
        
            ->whereIn('daycare.DayId', $dayIds)->where(['baby.IsDeleted' => '0', 'daycare.IsDeleted' => 0])
        // ->where(['baby.IsDeleted'=>'0', 'daycare.IsDeleted'=>'0', 'baby_admission.AdmissionType'=>'NICU', 'baby_admission.Status'=>'Inpatient'])
        
            ->orderBy('daycare.DayId', 'desc')
            ->get();
    }

    /**
     * This method get babydetails by $dayid
     * @param $dayId type integer
     *
     * @return array of object
     */
    public function getdaycareDownloadList($dayIds)
    {

        return \DB::table('daycare')->select('baby.*', 'daycare.*', 'daycare_questions.*', 'baby_admission.*', 'mother.MotherBloodGroup')
            ->addselect('daycare.DayId as day_id', 'daycare.BabyId as baby_id', 'baby.BMrNo as baby_mrno')
        // ->addselect('blood_products.Volume as blood_volume', 'blood_products.Product as blood_product')
        
            ->join('baby', 'baby.BabyId', '=', 'daycare.BabyId')
            ->leftjoin('baby_admission', 'baby_admission.AdmissionId', '=', 'daycare.AdmissionId')
            ->leftjoin('daycare_questions', 'daycare_questions.DayId', '=', 'daycare.DayId')
            ->leftjoin('mother', 'mother.MotherId', '=', 'baby.MotherId')
        // ->leftjoin('blood_products', 'blood_products.BabyId', '=', 'baby.BabyId')
        
            ->whereIn('daycare.DayId', $dayIds)->where(['baby.IsDeleted' => '0', 'daycare.IsDeleted' => 0])
        // ->where(['baby.IsDeleted'=>'0', 'daycare.IsDeleted'=>'0', 'baby_admission.AdmissionType'=>'NICU', 'baby_admission.Status'=>'Inpatient'])
        
            ->orderBy('daycare.DayId', 'desc')
            ->get();
    }

    /**
     * This method get babydetails by $dayid
     * @param $dayId type integer
     *
     * @return array of object
     */
    public function getdaycareListview($dayIds)
    {

        return \DB::table('daycare')->select('baby.*', 'daycare.*', 'daycare_questions.*', 'baby_admission.*', 'mother.MotherBloodGroup')
            ->addselect('daycare.DayId as day_id', 'daycare.BabyId as baby_id', 'baby.BMrNo as baby_mrno')
            ->join('baby', 'baby.BabyId', '=', 'daycare.BabyId')
            ->leftjoin('baby_admission', 'baby_admission.AdmissionId', '=', 'daycare.AdmissionId')
            ->leftjoin('daycare_questions', 'daycare_questions.DayId', '=', 'daycare.DayId')
            ->leftjoin('mother', 'mother.MotherId', '=', 'baby.MotherId')
            ->whereIn('daycare.DayId', $dayIds)->where(['baby.IsDeleted' => '0', 'daycare.IsDeleted' => 0])
            ->orderBy('daycare.DayId', 'desc')
            ->paginate(2);
    }

    public function getProduct($BabyId, $AdmissionId)
    {

        return \DB::table('blood_products')->select('Product', 'Volume')
            ->where('BabyId', $BabyId)->where('AdmissionId', $AdmissionId)->get();
    }

    public function getAntibiotics($BabyId, $AdmissionId)
    {

        return \DB::table('antibiotics')->select('Antibiotic', 'Day')
            ->where('BabyId', $BabyId)->where('AdmissionId', $AdmissionId)->where('Antibiotic', '<>', '')
            ->get();

    }

}

