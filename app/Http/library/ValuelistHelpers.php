<?php
namespace App\Http\library;

use Illuminate\Support\Facades\DB;
use App\Models\Masters\Complications as ComplicationMaster;
use App\Http\Controllers\Errors\ErrorLogController;

/*
This Helper will support to manage
form select option list and values  

This class has global access can access any where in the application 
better way of use is call by self method .
*/
class ValuelistHelpers
{

    /**
     * This method will give the hours : minus : session
     * to all the time fields in view blade
     *
     * @return array
     */
    public static function timeEngine()
    {

        $timeengine['period'] = array(
            'AM' => 'AM',
            'PM' => 'PM'
        );

        for ($i = 1;$i <= 12;$i++)
        {
            $hour = (strlen($i) == 1) ? '0' . $i : $i;
            $timeengine['time'][$hour] = $hour;
        }

        for ($i = 0;$i <= 59;$i++)
        {
            $min = (strlen($i) == 1) ? '0' . $i : $i;
            $timeengine['mins'][$min] = $min;
        }

        return $timeengine;

    }

    /**
     * This method will give list of
     * NICU admission/Admission proforma/Check-list/ROP treatment
     *
     * @return array
     */
    public static function commonValues()
    {

        $common_values = array(
            'No' => 'No',
            'Yes' => 'Yes',

        );

        return (!empty($id)) ? $common_values[$id] : $common_values;
    }

    /**
     * This method format the empty values
     *
     *@param  array
     *@return array
     */
    public static function formating_values($dataValues = array())
    {

        $results = array_where($dataValues, function ($index, $value)
        {
            if (!empty(trim($value))) return trim($value);
        });

        return $results;

    }

    /**
     * This method will give list of blood groups
     * to view blade
     *if the id is empty return the list
     *else return the name based on id
     *
     *@param  id string
     *@return array or string
     */
    public static function Blood_groups($id = '')
    {

        $blood_groups = array(
            'Not Known' => 'Not Known',
            'A Positive' => 'A Positive',
            'A1 Positive' => 'A1 Positive',
            'A2 Positive' => 'A2 Positive',
            'A Negative' => 'A Negative',
            'A1 Negative' => 'A1 Negative',
            'A2 Negative' => 'A2 Negative',
            'B Positive' => 'B Positive',
            'B Negative' => 'B Negative',
            'O Positive' => 'O Positive',
            'O Negative' => 'O Negative',
            'AB Positive' => 'AB Positive',
            'A1B Positive' => 'A1B Positive',
            'A2B Positive' => 'A2B Positive',
            'AB Negative' => 'AB Negative',
            'A1B Negative' => 'A1B Negative',
            'A2B Negative' => 'A2B Negative'
        );

        return (!empty($id)) ? $blood_groups[$id] : $blood_groups;

    }

    /**
     * This method will give list of discharge status
     * nicu-admission / admission performa/ discharge details /status to view blade
     *if the id is empty return the list
     *else return the name based on id
     *
     *@param  id string
     *@return array or string
     */
    public static function Discharge_Status($id = '')
    {

        $discharge_status = array(
            "Inpatient" => "Inpatient",
            "Discharged" => "Discharged",
            "Discharge at Request" => "Discharge at Request",
            "Leaving against medical advice" => "Leaving against medical advice",
            "Transferred" => "Transferred",
            "Died" => "Died",
            "Died (OCNR)" => "Died (OCNR)",
            "Abscond" => "Abscond"
        );

        return (!empty($id)) ? $discharge_status[$id] : $discharge_status;

    }

    /**
     * This method will give list of Gastric aspirate
     * Neonatal Proforma/Delivery/Gastric aspirate  to view blade
     *if the id is empty return the list
     *else return the name based on id
     *
     *@param  id string
     *@return array or string
     */
    public static function GastricAspirate($id = '')
    {

        $gastric_aspirate = array(
            "Not done" => "Not done",
            "Clear" => "Clear",
            "Meconium Stained" => "Meconium Stained",
            "Blood Stained" => "Blood Stained",
            "Bilious" => "Bilious",
            "Nil" => "Nil"
        );

        return (!empty($id)) ? $gastric_aspirate[$id] : $gastric_aspirate;
    }

    /**
     * This method will give list of Dct
     * Neonatal Proforma/Essential details/DCT to view blade
     *if the id is empty return the list
     *else return the name based on id
     *
     *@param  id string
     *@return array or string
     */
    public static function Dct($id = '')
    {

        $dct = array(
            'Not done' => 'Not done',
            'Positive' => 'Positive',
            'Negative' => 'Negative',
            'Not indicated' => 'Not indicated',
        );

        return (!empty($id)) ? $dct[$id] : $dct;

    }

    /**
     * This method will give list of Ict
     * Neonatal Proforma/Essential details/ICT to view blade
     *if the id is empty return the list
     *else return the name based on id
     *
     *@param  id string
     *@return array or string
     */
    public static function Ict($id = '')
    {

        $ict = array(
            'Not done' => 'Not done',
            'Positive' => 'Positive',
            'Negative' => 'Negative',
            'Not indicated' => 'Not indicated',
        );

        return (!empty($id)) ? $ict[$id] : $ict;

    }

    /**
     * This method will give list of Gender
     *if the id is empty return the list
     *else return the name based on id
     *
     *@param  id string
     *@return array or string
     */
    public static function Gender($id = '')
    {

        $gender = array(
            'Male' => 'Male',
            'Female' => 'Female',
            'Indeterminate' => 'Indeterminate',
        );

        return (!empty($id)) ? $gender[$id] : $gender;

    }

    /**
     *This method will give list of Indications
     *NICU Admission/Daycare/Respiratory System/Indication to view blade
     *if the id is empty return the list
     *else return the name based on id
     *
     *@param  id string
     *@return array or string
     */
    public static function Indications($id = '')
    {

        $Indication = \DB::table('mas_respiratoryindication')->where(['respiratory_status' => '1', 'IsDeleted' => '0'])
            ->orderby('respiratory_name', 'asc')
            ->pluck('respiratory_name', 'id')
            ->toArray();
        return (!empty($id)) ? $Indication[$id] : $Indication;

    }

    /**
     *This method will give list of surfactant indications
     *NICU Admission/Daycare/Respiratory System/surfactant indications to view blade
     *if the id is empty return the list
     *else return the name based on id
     *
     *@param  id string
     *@return array or string
     */
    public static function surfactant_indications($id = '')
    {

        $Indication = \DB::table('mas_respiratoryindication')->whereIn('id', ['7', '3', '15', '17'])
            ->where(['respiratory_status' => '1', 'IsDeleted' => '0'])
            ->orderby('respiratory_name', 'asc')
            ->pluck('respiratory_name', 'id');
        return (!empty($id)) ? $Indication[$id] : $Indication;

    }

    /**
     * This method will give list of Cry
     * NICU admission/Day care/Central Nervous System/Cry to view blade
     * if the id is empty return the list
     * else return the name based on id
     *
     * @param  id string
     * @return array or string
     */
    public static function cryValues($id = '')
    {

        $cry = array(
            "N/A" => "N/A",
            //  "Not applicable"=>"Not applicable",
            "Normal consolable" => "Normal consolable",
            "Abnormal Inconsolable" => "Abnormal Inconsolable",
            "High pitched cry" => "High pitched cry",
            "Weak Cry" => "Weak Cry",
            "Sedated/Paralysed" => "Sedated/Paralysed",
        );

        return (!empty($id)) ? $cry[$id] : $cry;

    }

    /**
     *This method will give list of Vaccine
     *NICU Admission/Admission Proforma/Discharge Details/Vaccine to view blade
     *if the id is empty return the list
     *else return the name based on id
     *
     *@param  id string
     *@param  flag boolean
     *@return array or string
     */
    public static function Vaccine($id = '', $flag = false)
    {

        $results = \DB::table('mas_vaccine');

        if ($flag == true)
        {

            $results->where(['Status' => 'Active', 'IsDeleted' => '0']);

        }

        $Vaccinetemp = $results->orderby('Name', 'asc')
            ->where(['Status' => 'Active', 'IsDeleted' => '0'])
            ->pluck('Name', 'Id')
            ->toArray();

        $Vaccine = self::formating_values($Vaccinetemp);

        return (!empty($id)) ? $Vaccine[$id] : $Vaccine;

    }

    /**
     *This method will give list of ROP Screening
     *NICU admission/Admission proforma/Check-list/ROP Screening to view blade
     *if the id is empty return the list
     *else return the name based on id
     *
     *@param  id string
     *@return array or string
     */
    public static function RopScreening($id = '')
    {

        $rop = array(
            '' => 'N/A',
            'No ROP, Immature Retina' => 'No ROP, Immature Retina',
            'No ROP, Mature Retina' => 'No ROP, Mature Retina',
            'Stage1 ROP' => 'Stage1 ROP',
            'Stage2 ROP' => 'Stage2 ROP',
            'Stage3 ROP' => 'Stage3 ROP',
            'Stage4 ROP' => 'Stage4 ROP',
            'Aggressive Posterior ROP' => 'Aggressive Posterior ROP',
            'Plus disease' => 'Plus disease'

        );

        return (!empty($id)) ? $rop[$id] : $rop;

    }

    /**
     *This method will give list of feed at discharge
     *Nicu admission /Admission proforma / Check-list/ feed at discharge to view blade
     *if the id is empty return the list
     *else return the name based on id
     *
     *@param  id string
     *@return array or string
     */
    public static function feedingDischarge($id = '')
    {

        $feeding_discharge = array(
            '' => 'N/A',
            'Not applicable' => 'Not applicable',
            'Directly Breast Fed' => 'Directly Breast Fed',
            'Fed DBF + EBM Top up' => 'Fed DBF + EBM Top up',
            'Fed DBF + Formula Top up' => 'Fed DBF + Formula Top up',
            'Fed DBF + EBM/Formula Top up' => 'Fed DBF + EBM/Formula Top up',
            'Spoon Fed with EBM' => 'Spoon Fed with EBM',
            'Spoon Fed with Formula' => 'Spoon Fed with Formula',
            'Paladai Fed with EBM' => 'Paladai Fed with EBM',
            'Paladai Fed with Formula' => 'Paladai Fed with Formula',
            'Bottle Fed' => 'Bottle Fed',
        );
        return (!empty($id)) ? $feeding_discharge[$id] : $feeding_discharge;

    }

    /**
     *This method will give list of doctors
     *from DB table to view blade
     *if the id is empty return the list
     *else return the name based on id
     *
     *@param  id string
     *@return array or string
     */
    public static function mas_doctors_list($id = "")
    {
        $doctors_temp = \DB::table('mas_doctors')
            ->select('Name', 'id')
            ->selectRaw('CASE WHEN length("Qualification") > 0 THEN "Name" || \', \' || "Qualification" ELSE "Name" END as name_qualification')
            ->where(['status' => 1, 'IsDeleted' => 0])
            ->orderby('sort_order', 'asc')
            ->pluck('name_qualification', 'id')
            ->toArray();
        $doctors = self::formating_values($doctors_temp);
        return (!empty($id)) ? @$doctors[$id] : $doctors;
    }

    public static function mas_doctors_list1($id = "")
    {
        $doctors_temp1 = \DB::table('mas_doctors')
            ->select('Name', 'id', 'register_no', 'job_title', 'Qualification', 'userId')
            ->selectRaw('CASE WHEN length("Qualification") > 0 THEN "Name" || \', \' || "Qualification" ELSE "Name" END as name_qualification')
            ->where(['status' => 1, 'IsDeleted' => 0])
            ->orderby('sort_order', 'asc')
            ->get();
            foreach ($doctors_temp1 as $value) {
                $registerNo = (trim($value->register_no) !== '0000' && !empty(trim($value->register_no))) ? 'Reg. No: ' . $value->register_no : '';

                // $doctors_temp[$value->id] =  $value->name_qualification . '* Reg. No:' . $value->register_no. '*' . $value->job_title;
                $doctors_temp[$value->id] =  $value->Name . '*' . $value->Qualification . '*' . $registerNo. '*' . $value->job_title. '^' . $value->userId;
            }
        $doctors = self::formating_values($doctors_temp);
        return (!empty($id)) ? @$doctors[$id] : $doctors;
    }

    /**
     *This method will give list of surgeons
     *from DB table to view blade
     *if the id is empty return the list
     *else return the name based on id
     *
     *@param  id string
     *@return array or string
     */
    public static function get_surgeons_lists($id = '')
    {
        $surgeons_temp = \DB::table('mas_doctors')
        // ->where(['status'=>1, 'IsDeleted'=>0, 'type'=>2])
        ->where(['status' => 1, 'IsDeleted' => 0])
            ->orderby('sort_order', 'asc')
            ->pluck('Name', 'id')
            ->toArray();
        $surgeons = self::formating_values($surgeons_temp);
        if (!empty($id) && isset($surgeons[$id]))
        {
            return $surgeons[$id];
        }
        elseif (!empty($id) && !isset($surgeons[$id]))
        {
            return 'None';
        }
        else
        {
            return (count($surgeons) > 0) ? $surgeons : array();
        }
    }

    /**
     *This method will give list of options
     *if the id is empty return the list
     *else return the name based on id
     *
     *@param  id string
     *@return array or string
     */
    public static function get_comman_options($id = '')
    {

        $comman_options = array(
            "No" => "No",
            "Yes" => "Yes",
            "Unknown" => "Unknown"
        );

        return (!empty($id)) ? $comman_options[$id] : $comman_options;
    }

    /**
     *This method will give list of meningitis
     *if the id is empty return the list
     *else return the name based on id
     *
     *@param  id string
     *@return array or string
     */
    public static function meningitisValue($id = "")
    {

        $Meningitis = array(
            '' => 'N/A',
            "No" => "No",
            "Yes" => "Yes",
            "Sespected Meningitis" => "Sespected Meningitis",
        );

        return (!empty($id)) ? $Meningitis[$id] : $Meningitis;

    }

    /**
     *This method will give list of nurse daycare stools nature
     *if the id is empty return the list
     *else return the name based on id
     *
     *@param  id string
     *@return array or string
     */
    public static function stoolNature($id = "")
    {

        $stoolNature = array(
            '' => 'N/A',
            'Meconium' => 'Meconium',
            'Changing stool pattern' => 'Changing pattern',
            'Formed yellow stools' => 'Formed &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; yellow',
            'Semi-solid yellow stools' => 'Semi-solid yellow',
            'Pale white stools' => 'Pale white',
            'Green stools' => 'Green',
            'Loose stools' => 'Loose',
            'Diarrhoea' => 'Diarrhoea'
        );

        return (!empty($id)) ? $stoolNature[$id] : $stoolNature;
    }

    /**
     *This method will give list of auto suggestion for all the text area
     *if the id is empty return the list
     *else return the name based on id
     *
     *@return json
     */

    public static function autoSuggestionvalue()
    {

        $Suggestionvalue = DB::table('auto_tags_values')->where('IsDeleted', 0)
            ->pluck('value')
            ->toArray();
        $Suggestionvalue = array_unique($Suggestionvalue);
        return json_encode($Suggestionvalue);
    }

    /**
     *This method  form color setting in all the dot select
     *
     *
     *@return json
     */

    public static function setColorvalue($id = '', $slug = 1)
    {

        switch ($slug)
        {
            case 1:
                $selectorvalue = self::setDaycarecolor();
            break;
            case 2:
                $selectorvalue = self::setNicuadmissioncolor();
            break;
            case 3:
                $selectorvalue = self::setPostnataldaycare();
            break;
            case 4:
                $selectorvalue = self::setNeonatalcolor();
            break;
            case 5:
                $selectorvalue = self::setNursedaycarecolor();
            break;
            case 6:
                $selectorvalue = self::setPediatricColor();
            break;
        }
        return (!empty($id) && isset($selectorvalue[$id])) ? json_encode($selectorvalue[$id]) : '';
    }

    public static function setNursedaycarecolor()
    {
        $selectorvalue = array(
            'stool_nature' => array(
                '#555533',
                'orange',
                '#FFFF00',
                'gold',
                '#FFDEAD',
                'Green'
            ) ,
            'urine_output' => array(
                '',
                'green',
                'red',
                'orange'
            ) ,
            'care' => array(
                '',
                'red',
                'green',
                'orange',
                'blue'
            ) ,
            'feed_frequency' => array(
                '',
                'orange',
                'green',
                'red',
                '#555533',
                'blue',
                '#d66d72',
                '#7c090f'
            ) ,
            'AspirateNature' => array(
                '',
                '',
                '#d3cdab',
                '#ead00d',
                '#c2db97',
                '#59870c',
                '#d66d72',
                '#7c090f'
            ) ,
            'NNJTreatment' => array(
                '',
                'green',
                'red',
                'orange'
            ) ,
        );
        return $selectorvalue;

    }

    //please refer setColor value function in this class
    public static function setNeonatalcolor()
    {
        $selectorvalue = array(
            'reactive' => array(
                'green',
                'red',
                'orange'
            ) ,
            'LastDoseDeliveryInterval' => array(
                '',
                'green',
                'red'
            ) ,
            'default' => array(
                '',
                'red',
                'green'
            ) ,
            'normal' => array(
                '',
                'green',
                'red'
            ) ,
            'Delayedcord' => array(
                'red',
                'green',
                'orange'
            ) ,
            'vitamin_k' => array(
                'orange',
                'red',
                'green'
            ) ,
            'dct' => array(
                '',
                'red',
                'green',
                'orange'
            ) ,
            'ict' => array(
                '',
                'red',
                'green',
                'orange'
            ) ,
        );

        return $selectorvalue;
    }

    //please refer setColor value function in this class
    

    public static function setPostnataldaycare()
    {
        $selectorvalue = array(
            'AnteriorFontanelle' => array(
                '',
                'green',
                'orange',
                'red'
            ) ,
            'Cephalhematoma' => array(
                '',
                'green',
                'red'
            ) ,
            'default' => array(
                '',
                'red',
                'green'
            ) ,
            'normal' => array(
                '',
                'green',
                'red'
            ) ,
            'colour' => array(
                'pink',
                '',
                'blue',
                ''
            ) ,
        );

        return $selectorvalue;
    }
    //please refer setColor value function in this class
    public static function setNicuadmissioncolor()
    {

        $selectorvalue = array(
            'Immunization' => array(
                '',
                'red',
                'green'
            ) ,
            'NicuNewBornScreen' => array(
                '',
                'orange',
                'blue',
                'green',
                'red'
            ) ,
            'HearingScreening' => array(
                '',
                'red',
                'green'
            ) ,
            'HomeOxygen' => array(
                '',
                'green',
                'red'
            ) ,
            'DischargeCUSS' => array(
                '',
                'green',
                'red',
                'orange'
            ) ,
            'ROPTreatment' => array(
                'green',
                'red',
                'blue',
                'orange'
            ) ,
            'NeurologicalStatus' => array(
                '',
                'green',
                'orange',
                'red'
            ) ,
            'TypeofTreatmen' => array(
                '',
                'red',
                'orange',
                'blue'
            ) ,
            'rop_follow' => array(
                'red',
                'green'
            ) ,
            'gentila' => array(
                'green',
                'red'
            )
        );

        return $selectorvalue;

    }

    //please refer setColor value function in this class
    public static function setDaycarecolor()
    {
        $selectorvalue = array(
            'default' => array(
                '',
                'red',
                'green'
            ) ,
            'default_normal' => array(
                '',
                'green',
                'red'
            ) ,
            'Retractions' => array(
                '',
                'green',
                '#e8bd68',
                'orange',
                'red'
            ) ,
            'ChestMovement' => array(
                '',
                'green',
                'red'
            ) ,
            'AddedSounds' => array(
                '',
                'red',
                'green'
            ) ,
            'Care' => array(
                '',
                'red',
                'orange',
                'green'
            ) ,
            'InvasiveVentilation' => array(
                '',
                'red',
                'green'
            ) ,
            'AirEntry' => array(
                '',
                'green',
                'red',
                'red',
                'red'
            ) ,
            'PulsePressure' => array(
                '',
                'green',
                'red'
            ) ,
            'PeripheralPulses' => array(
                '',
                'green',
                'orange',
                'red'
            ) ,
            'Color' => array(
                '',
                '#EEC5B7',
                'pink',
                '#F18267',
                '#A3778E'
            ) ,
            'PDATreatment' => array(
                '',
                'green',
                'orange',
                'red'
            ) ,
            'FullEnteralFeeds' => array(
                '',
                'green',
                'red'
            ) ,
            'Abdomen' => array(
                '',
                'green',
                'orange',
                'red'
            ) ,
            'BowelSounds' => array(
                '',
                'green',
                '#e8bd68',
                'orange',
                'red'
            ) ,
            'AnteriorFontanelle' => array(
                '',
                'green',
                'orange',
                'red'
            ) ,
            'Tone' => array(
                '',
                'green',
                'orange',
                'red'
            ) ,
            'NeonatalReflexes' => array(
                '',
                'green',
                'blue',
                'orange',
                'red'
            ) ,
            'UrineOutput' => array(
                '',
                'green',
                'red',
                'orange'
            ) ,
            'SEPSIS' => array(
                '',
                'green',
                'orange',
                'blue',
                '',
                'red'
            ) ,
            'BloodCulture' => array(
                '',
                'blue',
                'orange',
                'green',
                'red'
            ) ,
            'Meningitis' => array(
                '',
                'green',
                'red',
                'orange'
            ) ,
            'sp_ven' => array(
                '',
                'green',
                'red'
            ) ,
            'Transfusion' => array(
                '',
                'green',
                'red'
            ) ,
            'NNJTreatment' => array(
                '',
                'green',
                'orange',
                'red'
            ) ,
            'Inotropes' => array(
                '',
                'green',
                'red'
            )

        );
        return $selectorvalue;
    }
    // This values used on daycare sheet Gasterointestinal Systems.
    public static function frequencyList($id = '')
    {
        $frequency = array(
            " " => "N/A",
            "1" => "Hourly",
            "2" => "2 hourly",
            "2.5" => "2 1/2 hourly",
            "3" => "3 hourly",
            "4" => "4 hourly",
            "5" => "Demand feeds",

        );
        return !empty($id) ? $frequency[$id] : $frequency;

    }
    public static function getAntibiotic($id = '')
    {
        $antibiotic = \DB::table('mas_antibiotic')->where('Status', 'Active')
            ->where('IsDeleted', '0')
            ->orderby('Name', 'asc')
            ->pluck('Name', 'Id')
            ->toArray();
        $antibiotic = array_unique($antibiotic);

        return !empty($id) ? $antibiotic[$id] : $antibiotic;

    }

    public static function getPreganancytype($id = '')
    {
        $multiple_preganancy = array(
            'Twins' => 'Twins',
            'Triplets' => 'Triplets',
            'Quadruplets' => 'Quadruplets',
            'Quintuplets' => 'Quintuplets',
            'Sextuplets' => 'Sextuplets',
            'Septuplets' => 'Septuplets',
            'Octuplets' => 'Octuplets'
        );

        return !empty($id) ? $multiple_preganancy[$id] : $multiple_preganancy;
    }

    public static function mptypeNobabies($mp_type)
    {
        $preganancy_types = ['Singleton', 'Twin', 'Triplet', 'Quadruplet', 'Quintuplet', 'Sextuplet', 'Septuplet', 'Octuplet'];

        switch ($mp_type)
        {
            case 'Singleton':
                $preganancytype = self::numbers_serials('Singleton', 1);
            break;
            case 'Twins':
                $preganancytype = self::numbers_serials('Twin', 2);
            break;
            case 'Triplets':
                $preganancytype = self::numbers_serials('Triplet', 3);
            break;
            case 'Quadruplets':
                $preganancytype = self::numbers_serials('Quadruplet', 4);
            break;
            case 'Quintuplets':
                $preganancytype = self::numbers_serials('Quintuplet', 5);
            break;
            case 'Sextuplets':
                $preganancytype = self::numbers_serials('Sextuplet', 6);
            break;
            case 'Septuplets':
                $preganancytype = self::numbers_serials('Septuplet', 7);
            break;
            case 'Octuplets':
                $preganancytype = self::numbers_serials('Octuplet', 8);
            break;

            default:
                $preganancytype = self::numbers_serials('Singleton', 1);
            break;

            case 'All':
                $j = 0;
                $preganancytype = array();

                for ($i = 2;$i < 9;$i++)
                {
                    if (isset($preganancy_types[$j]))
                    {
                        $preganancytype = array_merge($preganancytype, self::numbers_serials($preganancy_types[$j], $i));
                    }
                    $j++;
                }
            break;

        }

        return $preganancytype;

    }

    public static function numbers_serials($type, $counts)
    {
        $comman = [];
        for ($i = 1;$i <= $counts;$i++)
        {
            ($type == 'Singleton') ? $comman[$type] = $type : $comman[$type . '-' . $i] = $type . '-' . $i;
        }

        return $comman;

    }

    public static function getMastercomplications($id = '')
    {
        $Complications = ComplicationMaster::get_lists();
        $complication_master['0'] = 'N/A';
        foreach ($Complications as $drug)
        {
            $complication_master[$drug
                ->Id] = $drug->Name;
        }

        return (!empty($id)) ? $complication_master[$id] : $complication_master;
    }

    // This values for neonatal performa labour Syntocinon
    public static function getSyntocinon($id = '')
    {
        $Syntocinon = array(
            1 => 'Given',
            2 => 'Not Given',
            3 => 'Not known'
        );

        return (!empty($id)) ? $Syntocinon[$id] : $Syntocinon;

    }

    // This values for neonatal performa labour Syntocinon
    public static function getPphntreatement($id = '')
    {
        $pphn = array(
            "" => "N/A",
            "None" => "None",
            "sildenafil_therapy" => "Sildenafil Therapy",
            "nitric_oxide_therapy" => "Nitric Oxide Therapy"
        );

        return (!empty($id) && !is_null($id) && $id != 'NULL') ? $pphn[$id] : $pphn;

    }

    public static function printPagelogo($hospital_name = 'SKS Hospital')
    {
        $results = \DB::table('site_settings')->first();
        if ($hospital_name == 'Sudha Hospital')
        {
            return url('public/img/sudhalogo.png');
        }
        elseif ($hospital_name == 'Saraswathi Nursing Home')
        {
            return url('public/img/saraswathi.png');
        }
        else
        {
            return url('public/img/' . $results->PrintLogo);
        }

        return url('public/img/noimage.png');
    }

    public static function organizam($id = '')
    {

        $organizam = array(
            '' => 'N/A',
            "E.coli" => "E.coli",
            "Klebsiella" => "Klebsiella",
            "Pseudomonas" => "Pseudomonas",
            "Enterobacter" => "Enterobacter",
            "Citrobacter" => "Citrobacter",
            "Acinetobacter" => "Acinetobacter",
            "CONS" => "CONS",
            "MSSA" => "MSSA",
            "MRSA" => "MRSA",
            "VRSA" => "VRSA",
            "Streptococcus" => "Streptococcus",
            "Enterococcus" => "Enterococcus",
            "Yeast" => "Yeast",
            "NLFGNB" => "NLFGNB",
            "NFGNB" => "NFGNB",
            "Burkholderia" => "Burkholderia"
        );

        return (!empty($id)) ? $organizam[$id] : $organizam;

    }

    public static function formateGestation($gestation)
    {

        $result = '';
        $g = 1;

        if (!empty($gestation) && count((array)json_decode($gestation)) == 2)
        {

            foreach (json_decode($gestation) as $key => $value)
            {

                if ($g == 1)
                {
                    $result .= $value;
                }
                else
                {
                    if (!empty($value))
                    {
                        $result .= '+' . $value;
                    }
                }

                $g++;

            }

        }
        return $result;

    }

    public static function getValuebykey($list, $key, $id, $value)
    {

        // $keyGroup = $list->where($key, $value)->pluck($id)->toArray();
        // foreach ($keyGroup as $keyGroupvalue) {
        //   if (!empty(trim($keyGroupvalue))) {
        //     return $keyGroupvalue;
        //   }
        // }
        

        foreach ($list as $list_key => $list_value)
        {
            $list_value = (array)$list_value;
            if ($list_value[$key] == $value && isset($list_value[$id]))
            {

                return $list_value[$id];
            }
        }

        return 'None';

    }

    public static function geticdValues($icd)
    {

        $tempIcd = array();

        $resultIcd = \DB::table('icd')->pluck('ICDDescription', 'ICDCode');
        if (isset($icd) && !empty($icd) && count(json_decode($icd)) > 0)
        {

            $icd = array_collapse(json_decode($icd));

            foreach ($icd as $value)
            {

                $tempIcd[] = $resultIcd[$value];

            }
            return implode(',', $tempIcd);
        }

        return 'None';

    }

    /**
     * This method will give value list for education stauts
     * in mother registration
     * @param  string  $id
     * @return if id present sent single value form list else sent array
     */

    public static function getEducationstatus($id = '')
    {

        $educations = array(
            " " => "N/A",
            "Uneducated" => "Uneducated",
            "Primary School" => "Primary School",
            "Secondary school" => "Secondary school",
            "Graduate" => "Graduate",
            "Postgraduate" => "Postgraduate"
        );

        return empty($id) ? $educations : $educations[$id];

    }

    /**
     * This method will give value list for occupation stauts
     * in mother registration
     * @param  string  $id
     * @return if id present sent single value form list else sent array
     */

    public static function getOccupationstatus($id = '')
    {

        $occupation = array(
            " " => "N/A",
            "Currently employed" => "Currently employed",
            "Previously employed but currently not employed" => "Previously employed but currently not employed",
            "Never employed" => "Never employed",
        );

        return empty($id) ? $occupation : $occupation[$id];
    }

    /**
     * This method will give value list for transfer stauts
     * in neonatal performa
     * @param  string  $id
     * @return if id present sent single value form list else sent array
     */

    public static function getTransferstatus($id = '')
    {

        $transferStatus = array(
            '' => 'N/A',
            'NICU' => 'NICU',
            'HDU' => 'HDU',
            'SCBU' => 'SCBU',
            'Postnatal Ward' => 'Postnatal Ward',
            'Nursery' => 'Nursery',
        );

        return empty($id) ? $transferStatus : $transferStatus[$id];

    }

    public static function getOldinputproperties($id = '')
    {

        switch ($id)
        {
            case 'nicu-admission':

                $properties = ['VaccineDate', 'Medications', 'Complication', 'Treatments', 'othergestations', 'otherfindings', 'dopplergestations', 'dopplerfindings', 'IVAntibiotic', 'additional_diagnosis', 'Vaccine', 'm_generic_name', 'formulation', 'M_Dose', 'M_Frequency', 'M_Duration'];
            break;

            case 'nicu-daycare':
                $properties = ["ResICD", "Indication", "surfactant_indication", "CarICD", "GasICD", "CenICD", "FluidICD", "F_Product", "F_Volume", "SepsisICD", "A_Day", "drugs", "Organism", "SkinICD", "RopICD"];
            break;

            default:
                $properties = array();
            break;
        }

        return $properties;

    }

    public static function setOldinputs($id = '')
    {

        $properties = self::getOldinputproperties($id);

        foreach ($properties as $value)
        {
            $name = '_old_input.' . $value;
            \Session::forget($name);

        }

        return true;

    }

    /**
     * This method will give value list for formulation strength based in medicine cheoose
     * in discharge medication
     * @param  string  $id
     * @return if id present sent single value form list else sent array
     */
    public static function formulationStrength($id = 0)
    {
        $formulation['0'] = 'N/A';

        if (!empty($id))
        {

            $drugs = SiteHelpers::create_mas_object('DrugIvFluidMaster');
            $drugs_id = $drugs->where('id', $id)->select('id')
                ->first();

            if (isset($drugs_id->id) && !empty($drugs_id->id))
            {

                $results = \DB::table('mas_drugivfluid')->where('id', $drugs_id->id)
                    ->pluck('value', 'id');

                foreach ($results as $key => $value)
                {
                    $formulation[$key] = $value;
                }
            }

        } else {

            $formulation = \DB::table('mas_drugivfluid')
                    ->pluck('value', 'id')
                    ->toArray();

             

        }
        return $formulation;

    }
    /**
     * This method will give value list
     * for product in daycare sheet bloods tab
     * @param  string  $id
     * @return if id present sent single value form list else sent array
     */
    public static function BloodProducts($id = '')
    {

        $products = ['' => 'N/A', 'Packed RBC' => 'Packed RBC', 'Whole Blood' => 'Whole Blood', 'Platelet Concentrate' => 'Platelet Concentrate', 'Fresh Frozen Plasma' => 'Fresh Frozen Plasma', 'Cryoprecipitate' => 'Cryoprecipitate', 'Washed maternal platelets' => 'Washed maternal platelets', 'NAIT - special platelets' => 'NAIT - special platelets', 'Immunoglobulin' => 'Immunoglobulin'];

        return !empty($id) ? $products[$id] : $products;

    }

    /**
     * This method will give value list for medicine duration
     * in discharge medicine
     * @param  string  $id
     * @return if id present sent single value form list else sent array
     */

    public static function medicationDuration($id = '')
    {

        $duration = array(
            "" => "N/A",
            "1 year" => "1 year",
            "2 years" => "2 years",
            "1 day" => "1 day",
            "2 days" => "2 days",
            "3 days" => "3 days",
            "4 days" => "4 days",
            "5 days" => "5 days",
            "6 days" => "6 days",
            "7 days" => "7 days",
            "10 days" => "10 days",
            "1 week" => "1 week",
            "2 weeks" => "2 weeks",
            "3 weeks" => "3 weeks",
            "4 weeks" => "4 weeks",
            "1 month" => "1 month",
            "2 months" => "2 months",
            "3 months" => "3 months",
            "4 months" => "4 months",
            "5 months" => "5 months",
            "6 months" => "6 months",
            "to continue" => "to continue",
            "SOS" => "SOS",
            "As adviced" => "As adviced"

        );

        return empty($id) ? $duration : $duration[$id];

    }

    /**
     * This method will give value list op appointment type
     *
     * @param  string  $id
     * @return if id present sent single value form list else sent array
     */

    public static function appointmentType($id = '')
    {

        $appointment = array(
            'New Appointment' => 'New Appointment',
            'Review Appointment' => 'Review Appointment',
            'Emergency Appointment' => 'Emergency Appointment',
            'Out of Appointment' => 'Out of Appointment',
            'Immunization' => 'Immunization',
            'Weaning Appointment' => 'Weaning Appointment',
            'Neurodevelopmental Screening' => 'Neurodevelopmental Screening',
            'Neurodevelopmental Assessment' => 'Neurodevelopmental Assessment',
            'Cardiac Appointment' => 'Cardiac Appointment',
            'Antenatal Counseling' => 'Antenatal Counseling',
            'Bereavement Appointment' => 'Bereavement Appointment',
            'Video Consultation' => 'Video Consultation'
        );
        return empty($id) ? $appointment : $appointment[$id];

    }

    /**
     * This method will give value list op outcome
     *
     * @param  string  $id
     * @return if id present sent single value form list else sent array
     */

    public static function outcome($id = '')
    {

        $outcome = array(
            'Sent Home' => 'Sent Home',
            'Admitted' => 'Admitted',
            'Discharge Against Medical Advice' => 'Discharge Against Medical Advice',
            'Awaiting results' => 'Awaiting results'
        );

        return empty($id) ? $outcome : $outcome[$id];

    }

    /**
     *This Method to get frequency for medication
     *
     *
     * @return  return array of frequency
     */
    public static function frequency($id = '')
    {
        $frequency = array(
            "Once daily" => "Once daily",
            "Twice daily" => "Twice daily",
            "3 times daily" => "3 times daily",
            "4 times daily" => "4 times daily",
            "5 times daily" => "5 times daily",
            "6 times daily" => "6 times daily",
            "Only once" => "Only once",
            "Stat" => "Stat",
            "As required" => "As required",
            "SOS" => "SOS",
            "Before Nappy Change" => "Before Nappy Change",
            "Alternate Days" => "Alternate Days",
            "Per loose stool" => "Per loose stool",
            "Once daily HS" => "Once daily HS",
            "Once weekly" => "Once weekly",
            "Twice weekly" => "Twice weekly",
            "3 times weekly" => "3 times weekly",
            "If fever/pain" => "If fever/pain",
            "If temp. > 100.4 F" => "If temp. > 100.4 F",
            "With each feed" => "With each feed",
            "As explained" => "As explained"
        );

        return empty($id) ? $frequency : $frequency[$id];
    }

    /**
     * This method will give value list op dose
     * in discharge medicine
     * @param  string  $id
     * @return if id present sent single value form list else sent array
     */
    public static function dose($id = '')
    {       

        $dose_list = \DB::table('mas_dose')
            ->where(['is_deleted' => 0, 'status' => 1])
            ->where('volume', '!=', '')
            ->orderBy('id', 'asc')
            ->pluck('volume', 'volume')
            ->toArray();
        return $dose_list;

    }

    /**
     * This method will give value list op route
     * in discharge medicine
     * @param  string  $id
     * @return if id present sent single value form list else sent array
     */
    public static function route($id = '')
    {
        $route = ['N/A','Oral','Rectal','IM','IV','S/C','Nasal drops','Eye drops','Ear drops','Topical','Inhaler','Nebuliser'];

        return empty($id) ? $route : $route[$id];

    }


    /**
     * This method will give value list
     * for PiccSite in daycare sheet bloods invesive lines
     * @param  string  $id
     * @return if id present sent single value form list else sent array
     */
    public static function PiccSite($id = '')
    {

        $piccsite = ['' => 'N/A', "Rt Cubital" => "Rt Cubital", "Lt Cubital" => "Lt Cubital", "Rt Subclavian" => "Rt Subclavian", "Lt Subclavian" => "Lt Subclavian", "Rt Saphenous" => "Rt Saphenous", "Lt Saphenous" => "Lt Saphenous", "Rt Femoral" => "Rt Femoral", "Lt Femoral" => "Lt Femoral", "Rt External Jugular" => "Rt External Jugular", "Lt External Jugular" => "Lt External Jugular"];

        return !empty($id) ? $piccsite[$id] : $piccsite;

    }

    /**
     * This method will give value list
     * for PiccSite in daycare sheet bloods invesive lines
     * @param  string  $id
     * @return if id present sent single value form list else sent array
     */
    public static function PacSite($id = '')
    {

        $pacsite = ['' => 'N/A', "Rt Radial" => "Rt Radial", "Lt Radial" => "Lt Radial", "Rt Ulnar" => "Rt Ulnar", "Lt Ulnar" => "Lt Ulnar", "Rt Posterior Tibial" => "Rt Posterior Tibial", "Lt Posterior Tibial" => "Lt Posterior Tibial", "Rt Dorsalis Pedis" => "Rt Dorsalis Pedis", "Lt Dorsalis Pedis" => "Lt Dorsalis Pedis"];

        return !empty($id) ? $pacsite[$id] : $pacsite;

    }
    /**
     * This method to get medicine from op
     *
     */
    public static function getOpMedicinelist($baby_id, $op_id)
    {
        $medicine = \DB::table('discharge_medications')->select('*', 'mas_drugivfluid.brand_name as Name')
            ->join('mas_drugivfluid', 'mas_drugivfluid.id', '=', 'discharge_medications.Medication')
            ->where(['BabyId' => $baby_id, 'AdmissionId' => 0, 'flag' => 3, 'source_id' => $op_id])->get()
            ->pluck('Name')
            ->toArray();

        return is_array($medicine) ? implode(',', $medicine) : 'N/A';
    }
    /**
     * This method to get apgar score
     *
     * @param $property type integer
     * @return type array
     */

    public static function getApgarScore($property)
    {

        switch ($property)
        {

            case 'colour':
                $score = [0 => '0 - Blue / Pale', 1 => '1 - Acrocyanosis', 2 => '2 - Completely Pink'];
                return $score;
            break;
            case 'hr':
                $score = [0 => '0 - Absent', 1 => '1 - < 100', 2 => '2 - > 100'];
                return $score;
            break;
            case 'reflex':
                $score = [0 => '0 - No response', 1 => '1 - grimace', 2 => '2 - Cry or Active withdrawal'];
                return $score;
            break;
            case 'tone':
                $score = [0 => '0 - Limp', 1 => '1 - Some flexion', 2 => '2 - Active Motion'];
                return $score;
            break;
            case 'respiration':
                $score = [0 => '0 - Absent', 1 => '1 - Week Cry/Hypoventilation', 2 => '2 - Good Cry'];
                return $score;
            break;

            default:
            break;
        }
    }

    /**
     * This method to get Pupils values
     *
     * @param $property type integer
     * @return type array  or single value
     */
    public static function getPupils($id = '')
    {
        $pupils = ['Not Examined' => 'Not Examined', "Equal and reacting to light" => "Equal and reacting to light", "Abnormal" => "Abnormal"];

        return !empty($id) ? $pupils[$id] : $pupils;

    }

    /**
     * This method to get Pupils values
     *
     * @param $property type integer
     * @return type array  or single value
     */
    public static function getHospitals($id = '')
    {
        $hoipitals = ['SKS Hospital' => 'SKS Hospital', "Sudha Hospital" => "Sudha Hospital", "Saraswathi Nursing Home" => "Saraswathi Nursing Home"];

        return !empty($id) ? $hoipitals[$id] : $hoipitals;

    }

    /** 
     * This method to get gentila
     * @param $id type string
     *
     * @return type array or string
     */
    public static function getGentila($id = '')
    {
        $gentila = array(
            'Normal' => 'Normal',
            'Abnormal' => 'Abnormal'
        );

        return !empty($id) ? $gentila[$id] : $gentila;
    }

    /** 
     * This method to get gentila
     * @param $id type string
     *
     * @return type array or string
     */
    public static function getdurationUnit($id = '')
    {
        $unit = array(
            ' ' => 'N/A',
            'days' => 'days',
            'weeks' => 'weeks',
            'month' => 'month'
        );

        return !empty($id) ? $unit[$id] : $unit;
    }

    /**
     * This method to get type care
     * nurse daily care
     *
     * @param $id type string
     * @return type array or string
     */
    public static function gettypeofcate($id = '')
    {
        $care = array(
            'N/A' => 'N/A',
            'Intensive Care' => 'Intensive Care',
            'High Dependancy Care' => 'High Dependancy Care',
            'Special Care' => 'Special Care'
        );

        return !empty($id) ? $care[$id] : $care;
    }

    /**
     * This method to get work of breathing
     * nurse daily care
     *
     *@param $id type string
     *@return type array or string
     */
    public static function workofbreathing($id = '')
    {
        $workofbreathing = array(
            'N/A' => 'N/A',
            'Improved' => 'Improved',
            'Deteriorated' => 'Deteriorated',
            'Stable' => 'Stable'
        );

        return !empty($id) ? $workofbreathing[$id] : $workofbreathing;

    }
    /**
     * This method to get mode of ventilation
     * nurse daily care
     *
     *@param $id type string
     *@return type array or string
     */
    public static function modeofventilation($id = '')
    {
        $modeofventilation = array(
            '' => 'N/A',
            'CMV' => 'CMV',
            'IMV' => 'IMV',
            'SIMV' => 'SIMV',
            'PSV' => 'PSV',
            'PTV' => 'PTV',
            'HFO' => 'HFO'
        );
        return !empty($id) ? $modeofventilation[$id] : $modeofventilation;

    }

    /**
     * This method to get mode of ventilation for invasive
     * nurse daily care
     *
     *@param $id type string
     *@return type array or string
     */
    public static function modeofinvasiveventilation($id = '')
    {
        $modeofventilation = array(
            '' => 'N/A',
            'HHHFNC' => 'HHHFNC',
            'CPAP' => 'CPAP',
            'BiPAP' => 'BiPAP',
            'NIPPV' => 'NIPPV',
            'Nasal HFOV' => 'Nasal HFOV',
            'HBO2' => 'HBO2',
            'NPO2' => 'NPO2',
            'Incubator O2' => 'Incubator O2',
            'SV' => 'SV (in air)',
            'nCPAP (D)' => 'nCPAP (D)'
        );
        return !empty($id) ? $modeofventilation[$id] : $modeofventilation;

    }

    /**
     * This method to get activity
     * nurse daily care
     *
     * @param $id type string
     * @return type array or string
     */
    public static function activityoption($id = '')
    {
        $activity = array(
            'N/A' => 'N/A',
            'sleep' => 'Sleep',
            'normal' => 'Normal',
            'lethargic' => 'Lethargic',
            'comatosed' => 'Comatosed',
            'Sedated / paralysed' => 'Sedated / paralysed'
        );

        return !empty($id) ? $activity[$id] : $activity;
    }

    /**
     * This method to get position
     * nurse daily care
     *
     * @param $id type string
     * @return type array or string
     */
    public static function positionoptions($id = '')
    {
        $position = array(
            'N/A' => 'N/A',
            'supine' => 'Supine',
            'prone' => 'Prone',
            'lateral' => 'Lateral'
        );

        return !empty($id) ? $position[$id] : $position;

    }

    /**
     * This method to get type of feeds
     * nurse daily care
     *
     * @param $id type string
     * @return type array or string
     */
    public static function typeoffeeds($id = '')
    {
        $typeoffeeds = array(
            '' => 'N/A',
            // 'NPO'=>'NPO',
            'MEBM' => 'MEBM',
            'DEBM' => 'DEBM',
            'MEBM + DEBM' => 'MEBM + DEBM',
            'FF' => 'FF',
            'MEBM + FF' => 'MEBM + FF'
        );

        return !empty($id) ? $typeoffeeds[$id] : $typeoffeeds;

    }

    /**
     * This Method to get type of BP
     * nurse daily care
     *
     * @param $id type string
     * @return type array or string
     */
    public static function bpmethod($id = '')
    {
        $bp_method = array(
            'Cuff' => 'Cuff',
            'Arterial' => 'Arterial',
            'Cuff & Arterial' => 'Cuff & Arterial'
        );

        return !empty($id) ? $bp_method[$id] : $bp_method;

    }
    /**
     * This Method to get gastric aspirate
     * nurse daily care
     *
     * @param $id type string
     * @return type array or string
     */
    public static function babygastricaspirate($id = '')
    {
        $gastric_aspirate = array(
            "" => "N/A",
            "Nil" => "Nil",
            "Milky" => "Milky",
            "Yellow" => "Yellow",
            "Light green" => "Light green",
            "Dark green" => "Dark green",
            "Bloody" => "Bloody",
            "Altered brown" => "Altered brown",
            "Clear" => "Clear"
        );

        return !empty($id) ? $gastric_aspirate[$id] : $gastric_aspirate;

    }

    /**
     * This Method to get  cpap interface
     * nurse daily cpap
     *
     * @param $id type string
     * @return type array or string
     */
    public static function cpapinterface($id = '')
    {
        $cpapinterface = ['' => 'N/A', 'mask' => 'Mask', 'prong' => 'Prong'];

        return !empty($id) ? $cpapinterface[$id] : $cpapinterface;
    }

    /**
     * This Method to get  air entry
     * nurse daily cpap
     *
     * @param $id type string
     * @return type array or string
     */
    public static function nurssheeteairentry($id = '')
    {
        $nurssheeteairentry = ['' => 'N/A', 'Equal' => 'Equal', 'Unequal' => 'Unequal'];

        return !empty($id) ? $nurssheeteairentry[$id] : $nurssheeteairentry;
    }

    /**
     * This Method to get loinc value form array list
     *
     * @param $results type array
     * @param $local_code type string
     * @param $return_value type string
     * @return empty or string or int
     */
    public static function fetchloincvalue($results, $local_code, $return_value, $index = 0)
    {

        $local_value = collect($results)->where('local_code', $local_code)->pluck($return_value)->toArray();

        if ($return_value == 'id')
        {

            if (count($local_value) > 0)
            {
                $header_id = collect($results)->where('local_code', $local_code)->pluck('log_hdr_id')
                    ->toArray();
                return isset($local_value[0]) ? $header_id[0] . '-' . $local_value[0] : null;
            }
            else
            {
                $header_id = collect($results)->pluck('log_hdr_id');
                return isset($header_id[0]) ? $header_id[0] . '-' . $index : $index;

            }
        }
        else
        {
            return isset($local_value[0]) ? $local_value[0] : null;
        }

    }

    /**
     * This Method to get loinc value form array list
     *
     * @param $id type string
     * @return empty or string or int
     */
    public static function newbornscreen($id = '')
    {
        $newbornscreen = ['' => 'N/A', 'Sent' => 'Sent', 'Not Sent' => 'Not Sent', 'Normal' => 'Normal', 'Abnormal' => 'Abnormal'];
        return empty($id) ? $newbornscreen : $newbornscreen[$id];

    }

    /**
     * This Method to get  route of feeds
     * nurse hour wise route of feeds
     *
     * @param $id type string
     * @return type array or string
     */
    public static function routeoffeed($id = '')
    {
        $routeoffeed = ['' => 'N/A', 'DBF' => 'DBF', 'Spoon Feed' => 'Spoon Feed', 'Tube Feed' => 'Tube Feed', 'Paladai Cup' => 'Paladai/Cup', 'Tube + Oral' => 'Tube + Oral'];

        return !empty($id) ? $routeoffeed[$id] : $routeoffeed;
    }

    /**
     * This Method to get  stools nature
     * nurse hour wise stools nature
     *
     * @param $id type string
     * @return type array or string
     */
    public static function nursesheetstoolsnature($id = '')
    {
        $nursesheetstoolsnature = array(
            '' => 'N/A',
            'Meconium' => 'Meconium',
            'Changing stool pattern' => 'Changing pattern',
            'Formed yellow' => 'Formed yellow',
            'Semi-solid yellow' => 'Semi-solid yellow',
            'Pale white' => 'Pale white',
            'Green' => 'Green',
            'Loose' => 'Loose',
            'Diarrhoea' => 'Diarrhoea',
            'Mucous' => 'Mucous',
            'Bloody' => 'Bloody'
        );

        return (!empty($id)) ? $nursesheetstoolsnature[$id] : $nursesheetstoolsnature;
    }

    /**
     * This Method to get  frequency
     * nurse drugs
     *
     * @param $id type string
     * @return type array or string
     */
    public static function medicinefrequencylist()
    {
        $frequency = array();

        for ($i = 1;$i <= 24;$i++)
        {

            $frequency[$i] = $i;

        }

        return $frequency;
    }

    /**
     * This method to get the units for infusion does
     *
     *
     * @param $id type integer
     * @return type array or string
     */
    public static function infusiondoesunitgrams($id = '')
    {

        $units = array(
            '1' => 'g',
            '2' => 'mg',
            '3' => 'ml',
            '4' => 'mcg',
            '5' => 'nanog',
            '6' => 'units'
        );

        return (!empty($id)) ? $units[$id] : $units;

    }

    /**
     * This method to get the units for infusion does
     *
     *
     * @param $id type integer
     * @return type array or string
     */
    public static function infusionmachinedoseunitgrams($id = '')
    {

        $units = array(
            '' => 'N/A',
            '1' => 'g',
            '2' => 'mg',
            '3' => 'ug',
            '4' => 'ng',
            '5' => 'units'
        );

        return (!empty($id)) ? $units[$id] : $units;

    }

    /**
     * This method to get the units for infusion does
     *
     *
     * @param $id type integer
     * @return type array or string
     */
    public static function infusiondoeskilograms($id = '')
    {

        $units = array(
            '1' => 'kg'
        );

        return (!empty($id)) ? $units[$id] : $units;

    }

    /**
     * This method to get the units for infusion does
     *
     *
     * @param $id type integer
     * @return type array or string
     */
    public static function infusiondoesduration($id = '')
    {

        $units = array(
            '1' => 'min',
            '2' => 'hr',
            '3' => 'day'
        );
        return (!empty($id)) ? $units[$id] : $units;

    }

    /**
     * This method to get the units for infusion drug quantity
     *
     *
     * @param $id type integer
     * @return type array or string
     */
    public static function infusionquantityunits($id = '')
    {

        $units = array(
            '1' => 'g',
            '2' => 'mg',
            '3' => 'mcg',
            '4' => 'units'
        );

        return (!empty($id)) ? $units[$id] : $units;

    }

    /**
     * This method to get the dextrose percentage
     *
     *
     * @param $id type integer
     * @return type array or string
     */
    public static function getdextrosevalue($id = '')
    {

        $units = array(
            '0' => '0',
            '5' => '5',
            '10' => '10',
            '25' => '25',
            '50' => '50'
        );

        return (!empty($id)) ? $units[$id] : $units;

    }

    /**
     * This method to get the dextrose percentage
     *
     *
     * @param $id type integer
     * @return type array or string
     */
    public static function getsyringesize($id = '')
    {

        $syringe = array(
            '5' => '5',
            '7.5' => '7.5',
            '10' => '10',
            '12.5' => '12.5',
            '15' => '15',
            '20' => '20',
            '25' => '25',
            '50' => '50',
            '100' => '100',
            '150' => '150',
            '200' => '200'
        );

        return (!empty($id)) ? $syringe[$id] : $syringe;

    }

    /**
     * Method to get resuscitation medication
     *
     * @return type string
     */

    public static function resuscitationMedication($id = '')
    {

        $resuscitationMedication = array(
            'Adrenaline' => 'Adrenaline',
            'Normal Saline' => 'Normal Saline',
            'Naloxone' => 'Naloxone',
            'Inotropes' => 'Inotropes',
            'Dextrose Bolus' => 'Dextrose Bolus',
            'Bicarbonate' => 'Bicarbonate'
        );

        return isset($resuscitationMedication[$id]) ? $resuscitationMedication[$id] : $resuscitationMedication;

    }

    /** 
     * Method to get baby list
     *
     *
     */
    public static function getAllbabies()
    {
        $result = \DB::table('baby')->selectRaw('"BabyName" || \'-\' || "BMrNo" as baby_name, "BabyId"')
            ->where('IsDeleted', 0)
            ->get()
            ->pluck('baby_name', 'BabyId')
            ->toArray();
        return $result;
    }

    /**
     * This method get room Status
     *
     * @param  $id type string
     *
     * @return array list
     */
    public static function roomStatus($id = '')
    {

        $room_status = array(
            'Available' => 'Available',
            'Reserved' => 'Reserved',
            'Semi Occupied' => 'Semi Occupied',
            'Under Maintenance' => 'Under Maintenance',
            'House Keeping' => 'House Keeping',
            'Occupied' => 'Occupied',
            'Unavailable' => 'Unavailable'
        );
        return $room_status;

    }

    /**
     * This method to get ward
     * details
     *
     * @param $id type int
     * @return array of object
     */
    public static function getward($id)
    {
        return \DB::table('ward')->where('ward_group_id', $id)->get();
    }

    /**
     * This method to get oral route
     * details
     *
     * @param $id type int
     * @return array of object
     */
    public static function getRoute()
    {
        $route = array(
            'Oral' => 'Oral',
            'Rectal' => 'Rectal',
            'IM' => 'IM',
            'Intradermal' => 'Intradermal',
            'SC' => 'SC',
            'IV' => 'IV',
            'Nebulised' => 'Nebulised',
            'Topical' => 'Topical'
        );

        return $route;
    }

    /**
     * This method to get frequency for
     * discharge medication
     *
     * @param $id string
     *
     */

    public static function frequencyData($id)
    {
        $frequency[""] = "N/A";
        $frequency["Q24H"] = "Once daily";
        $frequency["Q12H"] = "Twice daily";
        $frequency["Q8H"] = "3 times daily";
        $frequency["Q6H"] = "4 times daily";
        $frequency["Q4H"] = "6 times daily";
        $frequency["Once"] = "Stat";
        $frequency["As required"] = "As required";
        $frequency["SOS"] = "SOS";
        $frequency["Before Nappy Change"] = "Before Nappy Change";
        $frequency["Alternate Days"] = "Alternate Days";
        $frequency["Per loose stool"] = "Per loose stool";
        $frequency["Once daily HS"] = "Once daily HS";
        $frequency["Once weekly"] = "Once weekly";
        $frequency["Twice weekly"] = "Twice weekly";
        $frequency["3 times weekly"] = "3 times weekly";
        $frequency["If fever/pain"] = "If fever/pain";
        $frequency["If temp. > 100.4 F"] = "If temp. > 100.4 F";
        $frequency["With each feed"] = "With each feed";
        $frequency["As explained"] = "As explained";
        return isset($frequency[$id]) ? $frequency[$id] : $frequency;
    }

    /**
     * This method to get department
     * value to from
     *
     * @param $id
     * @return array or string
     */
    public static function getDepartment($id = '')
    {
        // $site['nicu1'] = 'Nicu 1';
        // $site['nicu2'] = 'Nicu 2';
        // $site['nicu3'] = 'Nicu 3';
        // return (!empty($id)) ? $site[$id] : $site;
        $result = \DB::table('mas_department')->where('Status', 1)
            ->get()
            ->pluck('Name', 'Id')
            ->toArray();
        return isset($result[$id]) ? $result[$id] : $result;

    }
    /**
     * This method to get investigations
     * @param $id
     *
     *
     */
    public static function getInvestigation($id = '')
    {
        $result = \DB::table('mas_investigations_package')
            ->get()
            ->pluck('package_name', 'id')
            ->toArray();
        return isset($result[$id]) ? $result[$id] : $result;

    }
    public static function setPediatricColor()
    {

        $selectorvalue = array(
            'default' => array(
                '',
                'red',
                'green'
            ) ,
            'default_normal' => array(
                '',
                'green',
                'red'
            ) ,
            'default_medium' => array(
                '',
                'green',
                'orange',
                'red'
            ) ,
            'Retractions' => array(
                '',
                'green',
                '#e8bd68',
                'orange',
                'red'
            ) ,
            'Care' => array(
                '',
                'red',
                'orange',
                'green'
            ) ,
            'AirEntry' => array(
                '',
                'green',
                'red',
                'red',
                'red'
            ) ,
            'PeripheralPulses' => array(
                '',
                'green',
                'orange',
                'red'
            ) ,
            'Color' => array(
                '',
                'pink',
                '#F18267',
                '#A3778E'
            ) ,
            'PDATreatment' => array(
                '',
                'green',
                'orange',
                'red'
            ) ,
            'Abdomen' => array(
                '',
                'green',
                'orange',
                'red'
            ) ,
            'BowelSounds' => array(
                '',
                'green',
                '#e8bd68',
                'orange',
                'red'
            ) ,
            'AnteriorFontanelle' => array(
                '',
                'green',
                'orange',
                'red'
            ) ,
            'Tone' => array(
                '',
                'green',
                'orange',
                'red'
            ) ,
            'NeonatalReflexes' => array(
                '',
                'green',
                'blue',
                'orange',
                'red'
            ) ,
            'UrineOutput' => array(
                '',
                'green',
                'red',
                'orange'
            ) ,
            'SEPSIS' => array(
                '',
                'green',
                'orange',
                'blue',
                '',
                'red'
            ) ,
            'BloodCulture' => array(
                '',
                'blue',
                'orange',
                'green',
                'red'
            ) ,
            'Meningitis' => array(
                '',
                'green',
                'red',
                'orange'
            ) ,
            'NNJTreatment' => array(
                '',
                'green',
                'orange',
                'red'
            ) ,
            'AddedSounds' => array(
                '',
                'red',
                'green'
            ) ,
            'InvasiveVentilation' => array(
                '',
                'red',
                'green'
            ) ,
            'ChestMovement' => array(
                '',
                'green',
                'red'
            ) ,
            'PulsePressure' => array(
                '',
                'green',
                'red'
            ) ,
            'FullEnteralFeeds' => array(
                '',
                'green',
                'red'
            ) ,
            'sp_ven' => array(
                '',
                'green',
                'red'
            ) ,
            'Transfusion' => array(
                '',
                'green',
                'red'
            ) ,
            'Inotropes' => array(
                '',
                'green',
                'red'
            )

        );
        return $selectorvalue;
    }

    public static function getPrescription($value)
    {
        $results = \DB::table('mas_prescription_type')->select('name')
            ->where('is_deleted', 0)
            ->where('value', $value)->where('status', 1)
            ->orderby('pres_id', 'desc')
            ->first();

        $results = isset($results->name) ? $results->name : '';

        return $results;

    }

    public static function getBrandName()
    {
        $results = \DB::table('mas_drugivfluid')->select('id', 'brand_name', 'generic_pharmacological_name')
            ->get()
            ->groupBy('id');

        return $results;

    }
    /**
     * This method to get the units for infusion does
     *
     *
     * @param $id type integer
     * @return type array or string
     */
    public static function oraldoesunitgrams($id = '')
    {

        $units = array(
            '1' => 'ml',
            '2' => 'g',
            '3' => 'mg',
            '4' => 'mcg',
            '5' => 'nanog',
            '6' => 'units',
            '7' => 'topical',
            '8' => 'tab',
            '9' => 'cap',
            '10' => 'sachet',
            '11' => 'drops'
        );

        return (!empty($id)) ? $units[$id] : $units;

    }

    /**
     * This method to get the units for infusion does
     *
     *
     * @param $id type integer
     * @return type array or string
     */
    public static function getUserInitial($id = '')
    {

        $user_initial = \DB::table('users')->get()
            ->pluck('initial', 'id')
            ->toArray();

        return (!empty($id)) ? $user_initial[$id] : $user_initial;

    }

    public static function getUserSign($id = '')
    {

        $user_sign = \DB::table('users')->get()
            ->pluck('signature', 'id')
            ->toArray();

        return (!empty($id)) ? (isset($user_sign[$id]) ? $user_sign[$id] : '') : $user_sign;

    }

    public static function getUserName($id = '')
    {

        $user_sign = \DB::table('users')->get()
            ->pluck('name', 'id')
            ->toArray();

        return (!empty($id)) ? $user_sign[$id] : $user_sign;

    }

    public static function getUserBasedDetails($id = '')
    {

        $doctor_user = \DB::table('users')->select('users.id', \DB::raw('(CASE WHEN char_length(name_prefix::text) > 0 THEN name_prefix ELSE \'\' END) || name AS name'))
            ->get()
            ->pluck('name', 'id')
            ->toArray();

        return (!empty($id)) ? $doctor_user[$id] : $doctor_user;

    }

    public static function drugFrequencyList()
    {

        $frequency_list = \DB::table('mas_frequency')->where(['is_deleted' => 0, 'status' => 1])
            ->where('name', '!=', '')
            ->orderBy('freq_id', 'asc')
            ->pluck('name', 'value')
            ->toArray();
        return $frequency_list;
    }

    public static function getDrugIvFluidsAntibiotic($id = '')
    {
        $antibiotic = \DB::table('mas_drugivfluid')
            ->select('id', \DB::raw('(CASE WHEN char_length(brand_name::text) > 0 AND char_length(generic_pharmacological_name::text) > 0 THEN brand_name|| \' / \' ||generic_pharmacological_name WHEN char_length(brand_name::text) > 0 THEN brand_name WHEN char_length(generic_pharmacological_name::text) > 0 THEN generic_pharmacological_name END) AS generic_pharmacological_name'))
            ->where('anti_status', 1)
            ->where('is_deleted', 0)
            ->orderby('generic_pharmacological_name', 'asc')
            ->pluck('generic_pharmacological_name', 'id')
            ->toArray();
        return !empty($id) ? $antibiotic[$id] : $antibiotic;

    }

    public static function getDrugIvFluidsNonAntibiotic($id = '')
    {
        $antibiotic = \DB::table('mas_drugivfluid')
            ->select('id', \DB::raw('(CASE WHEN char_length(brand_name::text) > 0 AND char_length(generic_pharmacological_name::text) > 0 THEN brand_name|| \' / \' ||generic_pharmacological_name WHEN char_length(brand_name::text) > 0 THEN brand_name WHEN char_length(generic_pharmacological_name::text) > 0 THEN generic_pharmacological_name END) AS generic_pharmacological_name'))
            ->where('anti_status', 0)
            ->where('is_deleted', 0)
            ->orderby('id', 'asc')
            ->pluck('generic_pharmacological_name', 'id')
            ->toArray();
        $antibiotic = array_unique($antibiotic);

        return !empty($id) ? $antibiotic[$id] : $antibiotic;

    }
    public static function typesOfBasicScreening()
    {
        $screening_names = ['Head CT/USG', 'ROP', '(AABR)', '(OAE)', 'Diagnostic ABR', 'Conditioning Play Audiometery'];
        return $screening_names;
    }

    public static function muscleTomeNormsAge()
    {
        $age_in_month = ['0-3', '4-6', '7-9', '10-12'];
        return $age_in_month;
    }

    public static function muscleTomeNormsAdductorAngle()
    {
        $adductor_angle = ['40°-80°', '70°-110°', '110°-140°', '140°-160°'];
        return $adductor_angle;
    }

    public static function muscleTomeNormsPoplitealAngle()
    {
        $popliteal_angle = ['80°-100°', '90°-120°', '110°-160°', '150°-170°'];
        return $popliteal_angle;
    }

    public static function muscleTomeNormsDorsiflexionAngle()
    {
        $dorsiflexion_angle = ['60°-70°', '60°-70°', '60°-70°', '60°-70°'];
        return $dorsiflexion_angle;
    }

    public static function muscleTomeNormsScarfSign()
    {
        $scarf_sign = ['Elbow does not cross midline', 'Elbow crosses midline', 'Elbow goes beyond axillary line', ''];
        return $scarf_sign;
    }

    public static function formalDevelopmentalCorrectedAge()
    {
        $corrected_age_and_due_date = ['3 mo', '6 mo', '12 mo', '18 mo', 'Later if required'];
        return $corrected_age_and_due_date;
    }

    public static function getOpAge($id = '')
    {

        $age = array(
            'term_corrected' => 'Term Corrected',
            '3m' => '3 Months',
            '6m' => '6 Months',
            '9m' => '9 Months',
            '12m' => '12 Months',
            '18m' => '18 Months',
            '2y' => '2 Years',
            '3y' => '3 Years',
            '4y' => '4 Years'
        );

        return (!empty($id)) ? $age[$id] : $age;

    }

    public static function getDdstOnObservationFields()
    {
        $result_array = array(
            'personal-social' => ['regard_face',
            'smile_responsively',
            'simle_spantaneously',
            'regard_own_hand',
            'work_for_toy',
            'feed_self',
            'play_pat_a_cake',
            'indicate_wants',
            'wave_bye_bye',
            'play_ball_with_examiner',
            'imitate_activities',
            'drink_from_cup',
            'help_in_house',
            'use_spoon_fork',
            'remove_garment',
            'feed_doll',
            'put_on_clothing',
            'brush_teeth_with_help',
            'wash_dry_hands',
            'name_friend',
            'put_on_t_shirt',
            'dreff_no_help',
            'play_board_card_games',
            'brush_teeth_no_help',
            'prepare_cereal',
            ],
            'fine motor-adaptive' => ['follow_to_midline',
            'follow_past_midline',
            'grasp_rattle',
            'hands_together',
            'follow_180_deg',
            'regard_raisin',
            'reaches',
            'look_for_yarn',
            'rake_raisin',
            'pass_cube',
            'take_2_cubes',
            'thumb_finger_grasp',
            'bang_2_cubes_held_in_hands',
            'put_block_in_cup',
            'scribbles',
            'dump_raisin_demonstrated',
            'tower_of_2_cubes',
            'tower_of_4_cubes',
            'tower_of_6_cubes',
            'imitate_vertical_line',
            'tower_of_8_cubes',
            'thumb_wiggle',
            'copy_circle',
            'draw_person_3_pts',
            'copy_plus',
            'pick_longer_line',
            'copy_square_demonstr',
            'draw_person_6_pts',
            'copy_square',
            ],
            'language' => ['respond_to_bell',
            'vocalizes',
            'ooo_aah',
            'laughes',
            'squeals',
            'trun_to_rattling_sound',
            'trun_to_voice',
            'single_syllables',
            'imitate_speech_sounds',
            'dada_mama_non_specific',
            'common_syllables',
            'jabbers',
            'dada_mama_specific',
            'one_word',
            'two_words',
            'three_words',
            'six_words',
            'point_2_pictures',
            'combine_words',
            'name_1_picture',
            'body_parts_6',
            'point_4_picutres',
            'speech_half_understandable',
            'name_4_picutres',
            'know_2_actions',
            'know_2_adjectives',
            'name_1_color',
            'use_of_2_objects',
            'count_1_block',
            'use_of_3_objects',
            'know_4_actions',
            'speech_all_understandable',
            'understand_4_prepositions',
            'name_4_colors',
            'define_5_words',
            'know_3_adjectives',
            'count_5_blocks',
            'opposites_2',
            'define_7_words',
            ],
            'gross motor' => ['equal_movements',
            'lift_head',
            'head_up_45_deg',
            'head_up_90_deg',
            'sit_head_steady',
            'bear_weight_on_legs',
            'chest_up_arm_support',
            'roll_over',
            'pull_to_sit_no_head_lag',
            'sit_no_support',
            'stand_holding_on',
            'pull_to_stand',
            'get_to_sitting',
            'stand_2_seconds',
            'stand_alone',
            'stoop_and_recover',
            'walk_well',
            'walk_backwards',
            'runs',
            'walk_up_steps',
            'kick_ball_forward',
            'jump_up',
            'throw_ball_overhead',
            'board_jump',
            'balance_each_food_1_second',
            'balance_each_food_2_seconds',
            'hops',
            'balance_each_food_3_seconds',
            'balance_each_food_4_seconds',
            'balance_each_food_5_seconds',
            'hell_to_toe_walk',
            'balance_each_food_6_seconds',
            ]
        );
        return $result_array;
    }

    public static function ddstReportDesignElements()
    {
        $result_array = array(
            'prepare_cereal' => ['margin' => '75.2',
            'clear-div' => 'yes'],
            'brush_teeth_no_help' => ['margin' => '71.8',
            'clear-div' => 'yes'],
            'play_board_card_games' => ['margin' => '73.1',
            'clear-div' => 'yes'],
            'dreff_no_help' => ['margin' => '74.9',
            'clear-div' => 'yes'],
            'put_on_t_shirt' => ['margin' => '69',
            'clear-div' => 'yes'],
            'name_friend' => ['margin' => '68.8',
            'clear-div' => ''],
            'copy_square' => ['margin' => '11.6',
            'clear-div' => 'yes'],
            'wash_dry_hands' => ['margin' => '60.5',
            'clear-div' => ''],
            'draw_person_6_pts' => ['margin' => '14',
            'clear-div' => 'yes'],
            'brush_teeth_with_help' => ['margin' => '53.8',
            'clear-div' => ''],
            'copy_square_demonstr' => ['margin' => '16.6',
            'clear-div' => 'yes'],
            'put_on_clothing' => ['margin' => '62.1',
            'clear-div' => ''],
            'pick_longer_line' => ['margin' => '3',
            'clear-div' => 'yes'],
            'feed_doll' => ['margin' => '50.5',
            'clear-div' => ''],
            'copy_plus' => ['margin' => '20.4',
            'clear-div' => 'yes'],
            'remove_garment' => ['margin' => '46',
            'clear-div' => ''],
            'draw_person_3_pts' => ['margin' => '22.2',
            'clear-div' => 'yes'],
            'use_spoon_fork' => ['margin' => '44.8',
            'clear-div' => ''],
            'copy_circle' => ['margin' => '21.8',
            'clear-div' => 'yes'],
            'help_in_house' => ['margin' => '44',
            'clear-div' => ''],
            'thumb_wiggle' => ['margin' => '18.7',
            'clear-div' => ''],
            'define_7_words' => ['margin' => '3',
            'clear-div' => 'yes'],
            'drink_from_cup' => ['margin' => '34.5',
            'clear-div' => ''],
            'tower_of_8_cubes' => ['margin' => '23',
            'clear-div' => ''],
            'opposites_2' => ['margin' => '3.5',
            'clear-div' => 'yes'],
            'imitate_activities' => ['margin' => '36.5',
            'clear-div' => ''],
            'imitate_vertical_line' => ['margin' => '19.3',
            'clear-div' => ''],
            'count_5_blocks' => ['margin' => '3.5',
            'clear-div' => 'yes'],
            'play_ball_with_examiner' => ['margin' => '36',
            'clear-div' => ''],
            'tower_of_6_cubes' => ['margin' => '11',
            'clear-div' => ''],
            'know_3_adjectives' => ['margin' => '3.2',
            'clear-div' => 'yes'],
            'wave_bye_bye' => ['margin' => '28.4',
            'clear-div' => ''],
            'tower_of_4_cubes' => ['margin' => '18.2',
            'clear-div' => ''],
            'define_5_words' => ['margin' => '12.3',
            'clear-div' => 'yes'],
            'indicate_wants' => ['margin' => '30',
            'clear-div' => ''],
            'tower_of_2_cubes' => ['margin' => '7.4',
            'clear-div' => ''],
            'name_4_colors' => ['margin' => '18',
            'clear-div' => 'yes'],
            'play_pat_a_cake' => ['margin' => '29.3',
            'clear-div' => ''],
            'dump_raisin_demonstrated' => ['margin' => '6.3',
            'clear-div' => ''],
            'understand_4_prepositions' => ['margin' => '13',
            'clear-div' => 'yes'],
            'feed_self' => ['margin' => '21.5',
            'clear-div' => ''],
            'scribbles' => ['margin' => '8.2',
            'clear-div' => ''],
            'speech_all_understandable' => ['margin' => '16.8',
            'clear-div' => 'yes'],
            'work_for_toy' => ['margin' => '18.5',
            'clear-div' => ''],
            'put_block_in_cup' => ['margin' => '10',
            'clear-div' => ''],
            'know_4_actions' => ['margin' => '24.3',
            'clear-div' => 'yes'],
            'regard_own_hand' => ['margin' => '5.2',
            'clear-div' => ''],
            'bang_2_cubes_held_in_hands' => ['margin' => '13.2',
            'clear-div' => ''],
            'use_of_3_objects' => ['margin' => '30.1',
            'clear-div' => 'yes'],
            'simle_spantaneously' => ['margin' => '2.2',
            'clear-div' => ''],
            'thumb_finger_grasp' => ['margin' => '15.4',
            'clear-div' => ''],
            'count_1_block' => ['margin' => '32.3',
            'clear-div' => 'yes'],
            'smile_responsively' => ['margin' => '4',
            'clear-div' => ''],
            'take_2_cubes' => ['margin' => '9.4',
            'clear-div' => ''],
            'use_of_2_objects' => ['margin' => '38.2',
            'clear-div' => 'yes'],
            'regard_face' => ['margin' => '2.2',
            'clear-div' => ''],
            'pass_cube' => ['margin' => '12.7',
            'clear-div' => ''],
            'name_1_color' => ['margin' => '40.3',
            'clear-div' => 'yes'],
            'rake_raisin' => ['margin' => '24.8',
            'clear-div' => ''],
            'know_2_adjectives' => ['margin' => '38.4',
            'clear-div' => 'yes'],
            'look_for_yarn' => ['margin' => '22.3',
            'clear-div' => ''],
            'know_2_actions' => ['margin' => '35.4',
            'clear-div' => ''],
            'balance_each_food_6_seconds' => ['margin' => '9',
            'clear-div' => 'yes'],
            'reaches' => ['margin' => '19.7',
            'clear-div' => ''],
            'name_4_picutres' => ['margin' => '40.9',
            'clear-div' => ''],
            'hell_to_toe_walk' => ['margin' => '6.5',
            'clear-div' => 'yes'],
            'regard_raisin' => ['margin' => '13.5',
            'clear-div' => ''],
            'speech_half_understandable' => ['margin' => '34',
            'clear-div' => ''],
            'balance_each_food_5_seconds' => ['margin' => '8.7',
            'clear-div' => 'yes'],
            'follow_180_deg' => ['margin' => '11',
            'clear-div' => ''],
            'point_4_picutres' => ['margin' => '42.6',
            'clear-div' => ''],
            'balance_each_food_4_seconds' => ['margin' => '6.7',
            'clear-div' => 'yes'],
            'hands_together' => ['margin' => '10.9',
            'clear-div' => ''],
            'body_parts_6' => ['margin' => '38.8',
            'clear-div' => ''],
            'balance_each_food_3_seconds' => ['margin' => '5.5',
            'clear-div' => 'yes'],
            'grasp_rattle' => ['margin' => '12.4',
            'clear-div' => ''],
            'name_1_picture' => ['margin' => '38.2',
            'clear-div' => ''],
            'hops' => ['margin' => '8.4',
            'clear-div' => 'yes'],
            'follow_past_midline' => ['margin' => '5',
            'clear-div' => ''],
            'combine_words' => ['margin' => '39.5',
            'clear-div' => ''],
            'balance_each_food_2_seconds' => ['margin' => '5.8',
            'clear-div' => 'yes'],
            'follow_to_midline' => ['margin' => '2.2',
            'clear-div' => ''],
            'point_2_pictures' => ['margin' => '43.8',
            'clear-div' => ''],
            'balance_each_food_1_second' => ['margin' => '1.7',
            'clear-div' => 'yes'],
            'six_words' => ['margin' => '47.3',
            'clear-div' => ''],
            'board_jump' => ['margin' => '9.8',
            'clear-div' => 'yes'],
            'three_words' => ['margin' => '41',
            'clear-div' => ''],
            'throw_ball_overhead' => ['margin' => '7.5',
            'clear-div' => 'yes'],
            'two_words' => ['margin' => '39',
            'clear-div' => ''],
            'jump_up' => ['margin' => '17.2',
            'clear-div' => 'yes'],
            'one_word' => ['margin' => '36.7',
            'clear-div' => ''],
            'kick_ball_forward' => ['margin' => '10',
            'clear-div' => 'yes'],
            'dada_mama_specific' => ['margin' => '29',
            'clear-div' => ''],
            'walk_up_steps' => ['margin' => '7.5',
            'clear-div' => 'yes'],
            'jabbers' => ['margin' => '25.3',
            'clear-div' => ''],
            'runs' => ['margin' => '15.8',
            'clear-div' => 'yes'],
            'common_syllables' => ['margin' => '25.5',
            'clear-div' => ''],
            'walk_backwards' => ['margin' => '7.6',
            'clear-div' => 'yes'],
            'dada_mama_non_specific' => ['margin' => '25.3',
            'clear-div' => ''],
            'walk_well' => ['margin' => '1.5',
            'clear-div' => 'yes'],
            'imitate_speech_sounds' => ['margin' => '14',
            'clear-div' => ''],
            'stoop_and_recover' => ['margin' => '7',
            'clear-div' => 'yes'],
            'single_syllables' => ['margin' => '21',
            'clear-div' => ''],
            'stand_alone' => ['margin' => '6.3',
            'clear-div' => 'yes'],
            'trun_to_voice' => ['margin' => '16.5',
            'clear-div' => ''],
            'stand_2_seconds' => ['margin' => '10.5',
            'clear-div' => 'yes'],
            'trun_to_rattling_sound' => ['margin' => '13.5',
            'clear-div' => ''],
            'get_to_sitting' => ['margin' => '3.8',
            'clear-div' => 'yes'],
            'squeals' => ['margin' => '6.7',
            'clear-div' => ''],
            'pull_to_stand' => ['margin' => '12.7',
            'clear-div' => 'yes'],
            'laughes' => ['margin' => '6.9',
            'clear-div' => ''],
            'stand_holding_on' => ['margin' => '14.7',
            'clear-div' => 'yes'],
            'ooo_aah' => ['margin' => '5',
            'clear-div' => ''],
            'sit_no_support' => ['margin' => '13',
            'clear-div' => 'yes'],
            'vocalizes' => ['margin' => '2.2',
            'clear-div' => ''],
            'pull_to_sit_no_head_lag' => ['margin' => '4.2',
            'clear-div' => 'yes'],
            'respond_to_bell' => ['margin' => '2.2',
            'clear-div' => ''],
            'roll_over' => ['margin' => '-1.6',
            'clear-div' => 'yes'],
            'chest_up_arm_support' => ['margin' => '12.8',
            'clear-div' => 'yes'],
            'bear_weight_on_legs' => ['margin' => '8.7',
            'clear-div' => 'yes'],
            'sit_head_steady' => ['margin' => '8.5',
            'clear-div' => 'yes'],
            'head_up_90_deg' => ['margin' => '8',
            'clear-div' => 'yes'],
            'head_up_45_deg' => ['margin' => '2.2',
            'clear-div' => 'yes'],
            'lift_head' => ['margin' => '2.2',
            'clear-div' => 'yes'],
            'equal_movements' => ['margin' => '2.2',
            'clear-div' => 'yes'],
        );
        return $result_array;
    }

    /**
     *This method will give list of referral
     *from DB table to view blade
     *if the id is empty return the list
     *else return the name based on id
     *
     *@param  id string
     *@return array or string
     */
    public static function mas_referral_list($id = "")
    {
        $referral_temp = \DB::table('mas_referral')
        ->select('*')
            ->selectRaw('CASE WHEN length(doctor_name) > 0 AND length(hospital_name) > 0 THEN doctor_name|| \', \' ||hospital_name WHEN length(doctor_name) > 0 AND length(hospital_name) = 0 THEN doctor_name ELSE hospital_name END as doctor_name')
            ->where(['status' => 1, 'is_deleted' => 0])
            ->orderby('id', 'asc')
            ->pluck('doctor_name', 'id')
            ->toArray();
        $referral = self::formating_values($referral_temp);

        return (!empty($id)) ? @$referral[$id] : $referral;
    }

    public static function get_package_investigations_master($id = "")
    {
        $investigations_temp = \DB::table('mas_investigations_package')->where(['package_status' => 1, 'is_deleted' => 0]);
        if ($id != '')
        {
            $investigations_temp = $investigations_temp->where('id', $id)->get();
        }
        else
        {
            $investigations_temp = $investigations_temp->get()
                ->pluck('package_name', 'id')
                ->toArray();
        }
        return $investigations_temp;

    }

    public static function get_test_investigations_master($package_id = "")
    {
        $investigations_temp = \DB::table('mas_investigations_test')->where(['test_status' => 1, 'is_deleted' => 0]);
        if ($package_id != '')
        {
            $investigations_temp = $investigations_temp->where('package_id', $package_id)->get();
        }
        else
        {
            $investigations_temp = $investigations_temp->get();
        }
        return $investigations_temp;

    }

    public static function getRoom($admission_type)
    {
        $room_list = [];

        $room_list = \DB::table('room')
                    ->select('id', 'number')
                    ->where('ward_id', $admission_type)
                    ->orderBy('number', 'asc')
                    ->pluck('number', 'id')
                    ->toArray();
        return $room_list;
    }

    public static function getBed($admission_type)
    {
        $bed_list = [];

        // $bed_list = \DB::table('patient_bed_log')
        //             ->whereIn('patient_bed_log.bed_id', function ($query) use ($admission_type) {

        //               $query->from('bed')
        //                     ->select('bed.id')
        //                     ->where('bed.room_id', $admission_type)
        //                     ->where('bed.status', '!=', 'Occupied')
        //                     ->orWhereNull('bed.status')
        //                     ->get()
        //                     ->toArray();


        //            })
                    
        //             ->where('patient_bed_log.status', '!=', 'Occupied')

        //             ->orderBy('patient_bed_log.id', 'asc')
        //             ->get();

        $bed_list = \DB::table('bed')
                    ->select('bed.id', 'bed.number', 'bed.room_id', 'bed.status')
                    ->whereNotIn('bed.id', function ($query) use ($admission_type) {
                      $query->from('patient_bed_log')
                            ->select('patient_bed_log.bed_id')
                            ->where('patient_bed_log.ward_id', $admission_type)
                            ->where('status', 'Occupied')
                            ->orderBy('id', 'desc')
                            ->get()
                            ->toArray();
                    })                    
                    ->orderBy('bed.id', 'asc')
                    ->get()
                    ->groupBy('room_id');
                    // ->pluck('bed.number', 'bed.id')
                    // ->toArray();
        return $bed_list;
    }

    public static function bookingPlace($id = '')
    {
        if ($id == 'N/A') {
            return '';
        }
        $result = \DB::table('booking_place')
                    ->select('hospital_name', 'id')
                    ->where('status', 1)
                    ->where('IsDeleted', 0);

        if ($id != '') {
            $result = $result->where('id', $id);
        }

        $result = $result->orderBy('id', 'desc')
            ->pluck('hospital_name', 'id')
            ->toArray();

        $result = (!empty($id)) ? $result[$id] : $result;

        return $result;
    }

    public static function pumptype()
    {
        return array(
            'cs5' => 'CS5',
            'e-n-series' => 'E & N series'
        );
    }

    public static function toneoption() {

        return ['N/A','Normal','Hypotonia','Hypertonia', 'Within normal limits'];

    }

    public static function otheroption() {

        return ['N/A','Symmetric','Asymmetric'];

    }

    public static function dasiiQuestionTypes() {

        return ['motor'=>'Motor', 'mental'=>'Mental'];

    }

    public static function cbclQuestionTypes() {

        return ['N/A', 'Affective', 'Anxiety', 'Pervasive developmental', 'Attention deficit hyperactivity', 'Oppositional defiant'];

    }

    public static function issaQuestionTypes() {

        return ['N/A', 'Social relationship and reciprocity', 'Emotional responsiveness', 'Speech-language and communication', 'Behaviour patterns', 'Sensory aspects', 'Cognitive component'];

    }

    public static function getContentCluster() {

        return array(
            'I'     => 'I',
            'II'    => 'II',
            'III'   => 'III',
            'IV'    => 'IV',
            'V'     => 'V',
            'VI'    => 'VI',
            'VII'   => 'VII',
            'VIII'  => 'VIII',
            'IX'  => 'IX',
            'X'  => 'X'
        );

    }

    /**
     * This method to get hospital details
     */
    public static function getHospitalsDetails($hospital_name = '', $headerContent =  [])
    {
        if ($hospital_name == 'Sudha Hospital')
        {
            // return 'Sudha Hospitals PHONE : 9786065454, 6384047007';
            return 'Phone : 9786065454, 6384047007';
        }
        elseif ($hospital_name == 'Saraswathi Nursing Home')
        {
            // return 'Saraswathi Nursing Home PHONE : 0427 - 2314775, 0427 - 2316416';
            return 'Phone : 0427 - 2314775, 0427 - 2316416';
        }
        else
        {
            // return $headerContent['hospital_name'] . ' PHONE : ' . $headerContent['hospital_contact'];
            return 'Phone : ' . $headerContent['hospital_contact'];
        }

    }

    /**
     * This method to get hospital consultant details
     */
    public static function headerContent($hospital_name, $headerContent) {

        if ($hospital_name == 'Saraswathi Nursing Home')
        {
            return str_replace(\Config::get("constants.REMOVE_CONTENT_DISCHARGE_REPORT"), '', $headerContent['discharge_report_left']);
        }
        else
        {
            return $headerContent['discharge_report_left'];
        }

    }

    /**
     * This method to get hospital consultant details
     */
    public static function summaryFooter($hospital_name, $headerContent) {

        if ($hospital_name != 'Saraswathi Nursing Home')
        {
            return $headerContent['discharge_summary_footer'];
        }
        return '';

    }

    /**
     *This method will give list of doctors user ids
     *from DB table to view blade
     *if the id is empty return the list
     *else return the name based on id
     *
     *@param  id string
     *@return array or string
     */
    public static function mas_doctors_user_id($id = "")
    {
        $doctors_temp = \DB::table('mas_doctors')
            ->select('userId', 'id')
            ->whereNotNull('userId')
            ->where(['status' => 1, 'IsDeleted' => 0])
            ->orderby('sort_order', 'asc')
            ->pluck('userId', 'id')
            ->toArray();
        $doctors = self::formating_values($doctors_temp);

        return (!empty($id)) ? @$doctors[$id] : $doctors;
    }

    /**
     * This method will give list of doctors signatures
     * from DB table to view blade
     *
     * @return array or string
     */
    public static function getDoctorsSignature()
    {
        $doctors_sign_list = \DB::table('mas_doctors')
            ->leftjoin('users', 'mas_doctors.id', 'users.mas_id')
            ->select('signature', 'mas_doctors.id')
            ->whereNotNull('mas_id')
            ->where('signature', '<>', '')
            ->where('RoleId', '<>', '3')
            ->where(['mas_doctors.status' => 1])
            ->pluck('signature', 'id')
            ->toArray();

        return $doctors_sign_list;
    }

    public static function select2DataFormater($data, $options = false, $encrypt = true)
    {
        $results = collect($data)->map(function($value) use ($encrypt) {
            if (isset($value->BabyName)) {
                $mrno = (!empty($value->BMrNo))? ' - '. $value->BMrNo : '';
                if ($encrypt) {
                    return \SiteHelpers::encrypt_id($value->BabyId) . '||' . $value->BabyName.$mrno;
                } else {
                    return $value->BabyId . '||' . $value->BabyName.$mrno;                    
                }
            } else {
                $mrno = (!empty($value->MMrNo))? ' - ' . $value->MMrNo : '';
                return \SiteHelpers::encrypt_id($value->MotherId) . '||' . $value->MotherName . ' ' . $value->MotherLastName.$mrno;
            }
        })->toArray();
        if ($options) {
            $temp[] = \SiteHelpers::encrypt_id(0) . '||- - Create New Baby Registration - -';
            $results = array_merge($temp, $results);
        }
        return json_encode($results);
    }

    public static function urineOutputHour($admission_id, $current_weight)
    {
        $urine_output_values = \DB::table('emr_nurse_manual_values')
        ->select('emr_nurse_manual_values.id', \DB::raw("regexp_replace(intf_ref_value, '[^0-9.]','','g') AS intf_ref_value"), 'result_date_time')
        ->join('emr_log_hdr', 'emr_log_hdr.id', '=', 'emr_nurse_manual_values.log_hdr_id')
        ->where("loinc_local_map_id", 64)
        ->where("intf_ref_value", '<>', '')
        ->whereRaw("regexp_replace(intf_ref_value, '[^0-9.]','','g') <> ''")
        ->whereNotNull("intf_ref_value")
        ->where('emr_log_hdr.admission_id', $admission_id)
        ->orderBy("loinc_local_map_id", 'desc')
        ->orderBy("result_date_time", 'desc')
        ->limit(2)
        ->get();

        $recent_result = $urine_output_values->first();
        $urine_hour_difference = 1;
        $urine_value_difference = $recent_result_value = (isset($recent_result->intf_ref_value) && !empty($recent_result->intf_ref_value)) ? $recent_result->intf_ref_value : 0;
        if (count($urine_output_values) > 1) {
            $previous_result = $urine_output_values->last();
            $date1 = date_create($recent_result->result_date_time);
            $date2 = date_create($previous_result->result_date_time);
            $urine_hour_difference = date_diff($date1, $date2)->h;
            $previous_result_value = (isset($previous_result->intf_ref_value) && !empty($previous_result->intf_ref_value)) ? $previous_result->intf_ref_value : 0;
            $urine_value_difference = $recent_result_value - $previous_result_value;

            $urine_output_hour = '';

            if ((is_numeric($current_weight) && $current_weight > 0) && is_numeric($urine_value_difference) && $urine_hour_difference > 0) {
                $current_weight = (float)$current_weight;

                ErrorLogController::emergencyLogStat('current_weight='.$current_weight.'=urine_hour_difference='.$urine_hour_difference.'=urine_value_difference='.$urine_value_difference);

                $urine_output_hour = $urine_value_difference / ($urine_hour_difference * ($current_weight / 1000));

                ErrorLogController::emergencyLogStat('urine_output_hour='.$urine_output_hour);

                $urine_output_hour = number_format($urine_output_hour, 1);

                return $urine_output_hour;
            }
        }

        return '';
    }

    public static function signatureFormat($consultant, $slug = 0, $approved_by_list = [])
    {

        if (\SiteHelpers::is_serialized($consultant) && is_array(unserialize($consultant))) {
            $consultant = unserialize($consultant);
        } else {
            if (is_string($consultant)) {
                $consultant = json_decode($consultant);
            }
        }
        if (!is_array($consultant)) {
            $consultant = (array)$consultant;
        }
        $template = '<div class="col-xs-12 col-sm-12 col-md-12 text-center signature-block">';
        $template .= '<table class="full-width">';
        $template .= '<tbody>';
        $i = 0;
        foreach($consultant as $doctors) {

            if(!empty($doctors)) {
                $doc = ValuelistHelpers::mas_doctors_list1($doctors);
                
                $docs = explode('^', $doc);
                if (count($docs) > 1) {
                    $doc = explode('*', $docs[0]);
                    $docs = $docs[1];
                    if ($i % 2 == 0) {
                        $template .= '<tr>';
                    }
                    $template .= '<td>';
                    $template .= '<div class="' . (count($consultant) == 1 ? 'single' : '') . '">';
                    if (isset($doc[0]) && !empty($doc[0])) {
                        if (isset($docs) && !empty($docs) && $slug > 0) {
                            if ($slug == 1) {
                                $template .= '<span class="signature-tag hide" id="doctor-' . $docs . '"></span>';
                            } elseif ($slug == 2 && in_array($docs, $approved_by_list)) {
                                $template .= '<span class="signature-tag" id="doctor-' . $docs . '"><img src="' . url('/') . '/public/img/users/' . \ValuelistHelpers::getUserSign($docs) .  '"></span>';
                            } elseif($slug == 3) {
                                $template .= '<span class="signature-tag" id="doctor-' . $docs . '"><img src="' . url('/') . '/public/img/users/' . \ValuelistHelpers::getUserSign($docs) .  '"></span>';
                            }else {
                                $template .= '<span class="signature-tag" id="doctor-' . $docs . '"></span>';
                            }
                        } else {
                            $template .= '<p style="height: 50px;"></p>';
                        }
                        $template .= '<p class="mtb-0" style="height: 20px;"> <b>' . $doc[0] . '</b></p>';
                    }
                    if (isset($doc[1]) && !empty($doc[1])) {
                        $template .= '<p class="mtb-0 avoid-wrap">' . $doc[1] . '</p>';
                    } else {
                        $template .= '<p class="mtb-0 avoid-wrap">&nbsp</p>';
                    }
                    if (isset($doc[2]) && !empty($doc[2]) && strlen($doc[2]) > 8) {
                        $template .= '<p class="mtb-0">' . $doc[2] . '</p>';
                    } else {
                        $template .= '<p class="mtb-0 avoid-wrap">&nbsp</p>';
                    }
                    if (isset($doc[3]) && !empty($doc[3])) {
                        $template .= '<p class="mtb-0">' . $doc[3] . '</p>';
                    } else {
                        $template .= '<p class="mtb-0 avoid-wrap">&nbsp</p>';
                    }
                    $template .= '</div>';
                    $template .= '</td>';
                    $i++;
                    if ($i % 2 == 0) {
                        $template .= '</tr>';
                    }
                }
            }
        }
        $template .= '</tbody>';
        $template .= '</table>';
        $template .= '</div>';
        return $template;
    }
    public static function mas_surgeon_list($id = "")
    {
        // echo "dsgg";exit;
        $doctors = \DB::table('mas_doctors')
            ->select('Name', 'id')
            ->selectRaw('CASE WHEN length("Qualification") > 0 THEN "Name" || \', \' || "Qualification" ELSE "Name" END as name_qualification')
            ->where(['status' => 1, 'IsDeleted' => 0])
            ->orderby('sort_order', 'asc')
            ->pluck('name_qualification', 'id')
            ->toArray();

             return (!empty($id) && isset($doctors[$id])) ? $doctors[$id] : $doctors;

            
        // $doctors = self::formating_values($doctors_temp);

        // return (!empty($id)) ? @$doctors[$id] : $doctors;
        // return $doctors;
    }


}

