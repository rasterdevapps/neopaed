<?php
namespace App\Http\library;

use Carbon\Carbon;
use Crypt;
use Illuminate\Support\Collection;
use App\Http\Controllers\NicuDashboardController;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Events\DashboardEvent;

class SiteHelpers
{

    /**
     * Encrypt the id.
     *
     * @param $q integer
     *
     * @throws \InvalidPayloadException
     *
     * @return encrypted string
     */

    public static function encrypt_id($q)
    {
        return Crypt::encrypt($q);
    }

    /**
     * decrypt the string to id.
     *
     * @param $q string
     *
     * @throws \InvalidPayloadException
     *
     * @return decrypted integer
     */

    public static function decrypt_id($q)
    {
        return Crypt::decrypt($q);
    }

    /**
     * create the alert message container.
     *
     * @param $type string
     *
     * @param $message string
     *
     * @return alert container
     */
    public static function alert($type = 'default', $message)
    {

        switch ($type) {
            case 'success':
                $message = '<div class="alert alert-success alert-dismissible" role="alert">' . $message . '</div>';
                break;
            case 'error':
                $message = '<div class="alert alert-danger alert-dismissible" role="alert" style="text-align: center;">' . $message . '
            </div>';
                break;
            case 'dismissible':
                $message = '<div class="alert alert-warning alert-dismissible" role="alert">' . $message . '</div>';
                break;
            default:
                $message = '<div class="alert alert-info alert-dismissible" role="alert">' . $message . '</div>';
                break;
        }

        return $message;

    }

    /**
     * check the data is serialized.
     *
     * @param $data string
     *
     * @param $strict boolean
     *
     * @return boolean
     */
    public static function is_serialized($data, $strict = true)
    {
        // if it isn't a string, it isn't serialized.
        if (!is_string($data)) {
            return false;
        }
        $data = trim($data);
        if ('N;' == $data) {
            return true;
        }
        if (strlen($data) < 4) {
            return false;
        }
        if (':' !== $data[1]) {
            return false;
        }
        if ($strict) {
            $lastc = substr($data, -1);
            if (';' !== $lastc && '}' !== $lastc) {
                return false;
            }
        } else {
            $semicolon = strpos($data, ';');
            $brace = strpos($data, '}');
            // Either ; or } must exist.
            if (false === $semicolon && false === $brace)
                return false;
            // But neither must be in the first X characters.
            if (false !== $semicolon && $semicolon < 3)
                return false;
            if (false !== $brace && $brace < 4)
                return false;
        }
        $token = $data[0];
        switch ($token) {
            case 's':
                if ($strict) {
                    if ('"' !== substr($data, -2, 1)) {
                        return false;
                    }
                } elseif (false === strpos($data, '"')) {
                    return false;
                }
            // or else fall through

            case 'a':
            case 'O':
                return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
            case 'b':
            case 'i':
            case 'd':
                $end = $strict ? '$' : '';
                return (bool) preg_match("/^{$token}:[0-9.E-]+;$end/", $data);
        }
        return false;
    }

    /**
     * converting array of object to array .
     *
     * @param $results array of object collection
     *
     * @return array collection
     */
    public static function convert_obj_to_array($results)
    {

        $arrayvalues = array_map(
            function ($values) {
                return (array) $values;
            }
            ,
            $results
        );
        return $arrayvalues;

    }

    /**
     * converting array to array of object .
     *
     * @param $results array collection
     *
     * @return array of object collection
     */
    public static function convert_array_to_object($results)
    {

        $arrayvalues = array_map(
            function ($values) {
                return (object) $values;
            }
            ,
            $results
        );

        return $arrayvalues;

    }

    /**
     * filter the unique array based on key .
     *
     * @param $array array collection
     *
     * @param $key string
     *
     * @return array collection
     */
    public static function unique_multidim_array($array, $key)
    {

        $temp_array = array();
        $i = 0;
        $key_array = array();
        $j = 0;

        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$j] = $val;
                $j++;
            }
            $i++;
        }
        return $temp_array;

    }

    /**
     * create hours , minutes and session
     *
     * @return array
     */
    public static function prepare_time()
    {

        $tob['time'] = array();
        // $tob['time']['']='N/A';
        for ($i = 1; $i <= 12; $i++) {

            $tob['time'][$i] = (strlen($i) == 1) ? '0' . $i : $i;

        }

        $tob['mins'] = array();
        // $tob['mins']['']='N/A';
        for ($i = 0; $i <= 59; $i++) {

            $tob['mins'][$i] = (strlen($i) == 1) ? '0' . $i : $i;

        }

        $tob['session'] = ['AM' => 'AM', 'PM' => 'PM'];

        return $tob;

    }

    /**
     * Calculate the day of life based on dob .
     *
     * @param $babyDob date
     *
     * @return integer
     */
    public static function calculate_day_of_life($babyDob = '')
    {

        if (!empty($babyDob)) {

            $date1 = Carbon::createFromFormat('Y-m-d', $babyDob);
            $date2 = Carbon::now();

            return $dayOflife = $date1->diffInDays($date2);
        }
        return 0;

    }

    /**
     * Calculate the days between two days .
     *
     * @param $start date
     *
     * @param $end date
     *
     * @return integer
     */
    public static function calculate_day_of_life_two($start = '', $end = '', $slug = false)
    {

        if (!empty($start)) {

            $date1 = Carbon::createFromFormat('Y-m-d', $start);
            $date2 = Carbon::createFromFormat('Y-m-d', $end);

            if ($slug) {
                $dayOflife = $date1->diff($date2);
                $day_of_life = '';
                if ($dayOflife->y > 0) {
                    $day_of_life .= $dayOflife->y . ' Y ';
                }
                if ($dayOflife->m > 0) {
                    $day_of_life .= $dayOflife->m . ' M ';
                }
                if ($dayOflife->d > 0) {
                    $day_of_life .= $dayOflife->d . ' D';
                }
                return $day_of_life;
            }
            return $date1->diffInDays($date2);
        }
        return 0;

    }

    /**
     * Convert the gestation weeks and days to days.
     *
     * @param $gestation json
     *
     * @return integer
     */
    public static function convert_gestation_days($gestation = '')
    {

        if (!empty($gestation)) {

            if (is_array($gestation)) {
                // Already an array
            } else {
                $decoded = json_decode($gestation, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $gestation = $decoded;
                } else {
                    // Fallback for non-json or objects
                    $gestation = (array) json_decode($gestation);
                }
            }

            $keys = array_keys($gestation);
            if (count($keys) >= 2) {
                $gestation[$keys[0]] = empty($gestation[$keys[0]]) ? 0 : $gestation[$keys[0]];
                $gestation[$keys[1]] = empty($gestation[$keys[1]]) ? 0 : $gestation[$keys[1]];

                $gestation = ($gestation[$keys[0]] * 7) + (int) $gestation[$keys[1]];
            } else {
                $gestation = 0;
            }
        }
        return $gestation;

    }

    /**
     * Convert days to gestation weeks and days.
     *
     * @param $dayOflife integer
     *
     * @return array
     */
    public static function calculate_gestation_dayoflife($dayOflife = '')
    {

        if (!empty($dayOflife)) {
            if ($dayOflife < 6) {
                $g_week = ((int) $dayOflife) / 7;
                $g_day = ((int) $dayOflife) % 7;
                $gestations[0] = $g_week;
                $gestations[1] = $g_day;
            } else {
                $gestations[0] = 0;
                $gestations[1] = $dayOflife;
            }
            return $gestations;
        }
        return 0;

    }

    /**
     * Calculate the corrected gestational age with gestation and dayoflife.
     *
     * @param $gestation integer
     *
     * @param $dayOflife integer
     *
     * @return array
     */
    public static function calculate_corrected_gestation($gestation = '', $dayOflife = '')
    {

        if ($gestation !== '' && $dayOflife !== '') {

            $g_week = (int) (((int) $gestation + (int) $dayOflife) / 7);
            $g_day = (int) (((int) $gestation + (int) $dayOflife) % 7);
            $gestations[0] = $g_week;
            $gestations[1] = $g_day;
            return $gestations;
        }
        return 0;
    }

    /**
     * Converting the gestation from json to string.
     *
     * @param $gestation json
     *
     * @return string
     */
    public static function decode_gestation($gestation = '')
    {

        $results = '';

        if (!empty($gestation) && count(json_decode($gestation)) > 0) {
            $temp_g = json_decode($gestation);
            $temp_g = is_array($temp_g) ? $temp_g : (array) $temp_g;
            $keys = array_keys($temp_g);
            $results = (!empty($temp_g[$keys[1]])) ? $temp_g[$keys[0]] . '+' . $temp_g[$keys[1]] : $temp_g[$keys[0]];

        }
        return $results;

    }

    /**
     * Converting the consultants from serialzed to string.
     *
     * @param $consultant serialzed
     *
     * @param $flag boolean
     *
     * @return string  or html
     */
    public static function formating_consultant($consultant, $flag = false)
    {

        $result = '';
        if (!is_null($consultant) && count(@unserialize($consultant)) > 0) {
            $neon_con = unserialize($consultant);
            for ($i = 0; $i < count($neon_con); $i++) {
                if (!empty($neon_con[$i]) && count($neon_con) - 1 != $i) {
                    if ($flag) {
                        $result .= '<li>' . \ValuelistHelpers::mas_doctors_list($neon_con[$i]) . ', </li>';
                    } else {
                        $result .= \ValuelistHelpers::mas_doctors_list($neon_con[$i]) . ', ';
                    }
                } else {
                    if ($flag) {
                        $result .= '<li>' . \ValuelistHelpers::mas_doctors_list($neon_con[$i]) . '</li>';
                    } else {
                        $result .= !empty($neon_con[$i]) ? \ValuelistHelpers::mas_doctors_list($neon_con[$i]) : '';
                    }
                }
            }
        }

        return $result;

    }

    /**
     * Formate the tags to string .
     *
     * @param $auto_tags_fields array
     *
     * @param $auto_tags_values array
     *
     * @return array
     */
    public static function formate_tags($auto_tags_fields, $auto_tags_values)
    {

        foreach ($auto_tags_fields as $tags_index) {
            $auto_tags_values[$tags_index] = isset($auto_tags_values[$tags_index]) ? str_replace(',', ' ', $auto_tags_values[$tags_index]) : '';

            $auto_tags_values[$tags_index] = isset($auto_tags_values[$tags_index]) ? str_replace('#', ', ', $auto_tags_values[$tags_index]) : '';
        }
        return $auto_tags_values;
    }

    /**
     * Create sentance from values array lists.
     *
     * @param $valueCollection array
     *
     * @param $valuelist array
     *
     * @return string
     */
    public static function create_sentance_by_value($valueCollection, $valuelist)
    {
        $results = '';

        if (is_array($valuelist)) {

            $temp_ind_count = count($valuelist);

            $j = 0;

            foreach ($valueCollection as $key => $value) {

                $j++;

                if (($temp_ind_count - $j) == 1) {

                    $results .= $valueCollection[$key] . ' and ';

                } elseif (($temp_ind_count - $j) > 1) {

                    $results .= $valueCollection[$key] . ', ';

                } else {

                    $results .= $valueCollection[$key] . '.';

                }
            }
        }

        return $results;

    }

    /**
     * Create sentance from values list from master.
     *
     * @param $value_list array
     *
     * @param $master_class string
     *
     * @param $name string
     *
     * @param $type integer
     *
     * @return string
     */
    public static function get_master_formated_value($value_list, $master_class, $name = 'Name', $type = 1)
    {

        $master_obj = self::create_mas_object($master_class);

        $temp_master = $master_obj->where('IsDeleted', '0')
            ->pluck($name, 'Id')->toArray();

        $value_list = ($type === 1) ? json_decode($value_list) : unserialize($value_list);

        $value_count = count($value_list);

        $master_str = '';

        if (is_array($value_list)) {

            $s = 0;

            foreach ($value_list as $key => $values) {
                $s++;

                if (isset($temp_master[$values])) {
                    if (($value_count - $s) == 1) {

                        $master_str .= $temp_master[$values] . ' and ';

                    } elseif (($value_count - $s) > 1) {

                        $master_str .= $temp_master[$values] . ', ';

                    } else {

                        $master_str .= $temp_master[$values] . '.';

                    }
                }

            }
        }

        return $master_str;
    }

    /**
     * Create object for masters class.
     *
     * @param $type string
     *
     * @return object
     */
    public static function create_mas_object($type)
    {
        $path = '\App\Models\Masters\\';
        $path .= $type;
        return (new $path);
    }

    /**
     * Create sentance with consultant names.
     *
     * @param $neonatal_consultant array
     *
     * @return string
     */
    public static function get_doctors_name($neonatal_consultant)
    {

        $dr_obj = self::create_mas_object('DoctorMaster');
        $dr_data = $dr_obj->where('IsDeleted', '0')
            ->pluck('Name', 'id')
            ->toArray();
        $master_str = '';
        $neonatal_consultant = unserialize($neonatal_consultant);

        $value_count = count($neonatal_consultant);

        if (is_array($neonatal_consultant)) {
            $s = 0;
            foreach ($neonatal_consultant as $key => $values) {
                $s++;
                if (($value_count - $s) == 1) {
                    $master_str .= $dr_data[$values] . ' and ';
                } elseif (($value_count - $s) > 1) {
                    $master_str .= @$dr_data[$values] . ', ';
                } else {
                    $master_str .= @$dr_data[$values] . '.';
                }

            }
        }

        return $master_str;
    }

    /**
     * Create sentance with given array lists.
     *
     * @param $value_array array
     *
     * @return string
     */
    public static function array_to_string_support($value_array)
    {

        $value_count = count($value_array);
        $array_of_string = '';
        if (is_array($value_array)) {

            $s = 0;

            foreach ($value_array as $key => $values) {
                $s++;

                if (($value_count - $s) == 1) {

                    $array_of_string .= $values . ' and ';

                } elseif (($value_count - $s) > 1) {

                    $array_of_string .= $values . ', ';

                } else {

                    $array_of_string .= $values . '.';

                }

            }
        }

        return $array_of_string;

    }

    /**
     * Create ordering the dayoflife .
     *
     * @param $dayoflife array
     *
     * @param $flag boolean
     *
     * @return array
     */
    public static function calculate_serial_days($dayoflife, $flag = 0)
    {
        sort($dayoflife);
        $dayoflifelists = $temp_days = $startStopdays = array();

        for ($i = 0; $i < count($dayoflife); $i++) {
            $j = $i + 1;
            if (isset($dayoflife[$j]) && (is_numeric($dayoflife[$j]) && is_numeric($dayoflife[$i]) && ($dayoflife[$j] - $dayoflife[$i]) == 1)) {
                $temp_days[] = $dayoflife[$i];
            } else {
                $temp_days[] = $dayoflife[$i];
                $temp_days_collect = collect($temp_days);
                $dayoflifelists[] = ($temp_days_collect->min() == $temp_days_collect->max()) ? ' Day ' . $temp_days_collect->min() : 'Day ' . $temp_days_collect->min() . ' to Day ' . $temp_days_collect->max() . ' ';
                $startStopdays[] = ($temp_days_collect->min() == $temp_days_collect->max()) ? [$temp_days_collect->min()] : [$temp_days_collect->min(), $temp_days_collect->max()];
                $temp_days = array();
            }

        }

        return $flag == 0 ? (array) $dayoflifelists : (array) $startStopdays;

    }

    /**
     * Create mixed column chart parameters .
     *
     * @param $titles array
     *
     * @return array
     */
    public static function mixedChartparam($titles, $flag = true)
    {
        $chartparam = array();
        $sympols = ($flag) ? '%' : '';

        foreach ($titles as $key => $value) {

            $chartparam[] = ["balloonText" => "<b>[[title]]</b><br><span>[[category]]: <b>[[value]]</b></span>", "fillAlphas" => 0.8, "labelText" => "[[value]] " . $sympols . "", "lineAlpha" => 0.3, "title" => $value['title'], "type" => "column", "color" => "#000000", "valueField" => $value['value']];

        }

        return $chartparam;

    }

    /**
     * Create mixed column chart parameters .
     *
     * @param $titles array
     *
     * @return array
     */
    public static function multipleChartparam($titles, $flag = true)
    {

        $chartparam = array();

        $sympols = ($flag) ? '%' : '';

        foreach ($titles as $key => $value) {
            $chartparam[] = ["balloonText" => "[[title]]:[[value]]", "fillAlphas" => 0.8, "lineAlpha" => 0.2, "title" => $value['title'], "type" => "column", "valueField" => $value['value']];
        }
        return $chartparam;
    }

    /**
     * Create chart property.
     *
     * @param $keyList array
     *
     * @return array
     */
    public static function chartProperty($keyList)
    {

        $property = array();

        foreach ($keyList as $value) {

            $property[] = ['title' => str_replace('_', ' ', $value), 'value' => $value];

        }

        return $property;

    }

    /**
     * Create master list array .
     *
     * @return array
     */
    public static function getMasterlist()
    {

        return [
            "Vaccine" => "Vaccine",
            "Surgeon" => "Surgeon",
            "StaffMaster" => "StaffMaster",
            "RespiratoryIndication" => "RespiratoryIndication",
            "ProcedureMaster" => "ProcedureMaster",
            "Problemdaycare" => "Problemdaycare",
            "ProblemMaster" => "ProblemMaster",
            "MediprobsMaster" => "MediprobsMaster",
            "Indication" => "Indication",
            "Drug" => "Drug",
            "DoctorMaster" => "DoctorMaster",
            "Complications" => "Complications",
            "BookingPlace" => "BookingPlace",
            "AutoTagMasters" => "AutoTagMasters",
            "AntibioticMaster" => "AntibioticMaster",
            "Admissionmode" => "Admissionmode",

        ];

    }

    /**
     * Calculate age in years,month and days.
     *
     * @param $startDate date
     *
     * @return array
     */
    public static function dateDifferents($startDate)
    {

        $startDate = Carbon::createFromFormat('Y-m-d', $startDate);

        $differents = explode(',', $startDate->diff(Carbon::now())->format('%y,%m,%d'));
        $age = array();

        if (is_array($differents) && count($differents) == 3) {
            $age['Year'] = $differents[0];
            $age['Month'] = $differents[1];
            $age['Day'] = $differents[2];

        } else {
            $age = array(
                'Year' => '',
                'Month' => '',
                'Day' => ''
            );
        }

        return $age;
    }

    /**
     * get the current time .
     *
     * @throws time zone not set error
     *
     * @return time string
     */
    public static function getCurrenttime()
    {

        if (env('TIME_ZONE') !== null && empty(env('TIME_ZONE'))) {

            throw new \Exception("Time zone not set in env file", 1);
        }

        return Carbon::now(env('TIME_ZONE'));

    }
    /**
     * Method to get check flow
     *
     *
     */
    public static function getFlownotification()
    {

        $results = \DB::table('flow_control')
            // ->selectRaw('case when is_new_patient = true then \'New patient of \' || admission_module || \' -  \' ||current_module
            //                   else \'Registered patient of \' || admission_module || \' -  \' || current_module
            //              end as module')
            ->leftjoin('baby', 'baby.BabyId', '=', 'flow_control.baby_id')
            ->select('admission_module as module')
            ->addSelect('fcid', 'is_new_patient', 'baby.BabyName as baby_name', 'baby.BMrNo as mr_no')
            ->where('status', false)
            ->get();
        return $results;

    }

    /**
     * Method to get the module name
     *
     * @return type string
     */

    public static function ModuleList($id)
    {

        $moduleList = array(
            'NICU_ADMISSION' => 'Nicu Admission',
            'NICU_FORM' => 'Nicu Form',
            'POSTNATAL_ADMISSION' => 'Postanatal Admission',
            'OP_REGISTARATION' => 'OP Registaration',
            'NEONATAL' => 'Neonatal Performa',
            'NICU_DAILY_CARE' => 'Nicu Daily Care'
        );

        return isset($moduleList[$id]) ? $moduleList[$id] : 'Module Unkown';

    }

    /**
     * Method to get Nicu discharge baby
     *
     * @return type array list
     */
    public static function getNicuBabyies()
    {
        $results = \DB::table('baby')
            ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
            ->join('nicu_admission', 'nicu_admission.BabyId', '=', 'baby.BabyId')
            ->join('patient_bed_log', 'patient_bed_log.admission_id', '=', 'nicu_admission.AdmissionId')
            ->where('patient_bed_log.status', 'Occupied')
            ->where('baby.IsDeleted', 0)
            ->where('nicu_admission.IsDeleted', 0)
            ->orderBy('nicu_admission.BabyId', 'desc')
            ->get();
        $results = $results->unique('BabyId')
            ->pluck('BabyName', 'BabyId')
            ->toArray();

        return $results;
    }

    /**
     * Method to get Postnatal discharge baby
     *
     * @return type array list
     */
    public static function getPostnatalBabyies()
    {
        $results = \DB::table('baby')->join('postnatal_admission', 'postnatal_admission.BabyId', '=', 'baby.BabyId')
            ->join('postnatal_discharge', 'postnatal_discharge.AdmissionId', '=', 'postnatal_admission.AdmissionId')
            // ->where('discharge_status', '!=', 'Discharged')
            ->where('discharge_status', 'Inpatient')
            ->where('baby.IsDeleted', 0)
            ->where('postnatal_admission.IsDeleted', 0)
            ->where('postnatal_discharge.IsDeleted', 0)
            ->orderBy('baby.BabyId', 'desc')
            ->get();
        $results = $results->unique('BabyId')
            ->pluck('BabyName', 'BabyId')
            ->toArray();

        return $results;
    }

    /**
     * Method to constant config values
     *
     * @param $slug constant identifier
     * @return string
     */
    public static function getConfigSettings($slug)
    {

        $result = \DB::table('config_settings')->select('code_values')
            ->where('slug_code', trim($slug))->first();
        return isset($result->code_values) ? trim($result->code_values) : null;

    }

    /**
     * Method to destory the old login of the current user.
     *
     */
    public static function session_reset()
    {
        foreach (glob(config('session.files') . '/*') as $filename) {
            $unserial = unserialize(file_get_contents($filename));
            if (sizeof(array_keys($unserial)) > 4) {
                foreach ($unserial as $key => $value) {
                    $user_id = strpos($key, 'login_web_');
                    if ($user_id !== false && $value == \Auth::user()->id) {
                        unlink($filename);
                    }
                }
            }
        }
    }

    /**
     * This method to serve the exception message for user
     * @param $error_code  type integer
     *
     * @param $message_type type integer
     *
     * @return string type
     */
    public static function getUserExceptionMessage($messge_code, $message_type = 1)
    {
        switch ($message_type) {
            case '1':
                $key = 'errorlog.' . $messge_code;
                return \Lang::get($key);
                break;
            case '2':
                $key = 'error_message.' . $messge_code;
                return \Lang::get($key);
                break;

        }

    }

    /**
     * This method to get audio path
     *
     * @param $slug type string
     *
     * @param $type type integer
     */
    public static function getAudioPath($path_slug, $path_type = 1)
    {
        $path = self::getConfigSettings($path_slug);

        if ((empty($path) || !is_dir($path)) && $path_type == 1) {

            $code_values['code_values'] = public_path('audio/');

            \DB::table('config_settings')->where('slug_code', $path_slug)->update($code_values);

            return self::getConfigSettings($path_slug);

        } elseif (!empty($path) && is_dir($path) && $path_type == 1) {

            return $path;
        }

        if ((empty($path) || !is_dir($path)) && $path_type == 2) {

            $code_values['code_values'] = public_path('audio/zip_files/');

            \DB::table('config_settings')->where('slug_code', $path_slug)->update($code_values);

            return self::getConfigSettings($path_slug);

        } elseif (!empty($path) && is_dir($path) && $path_type == 2) {

            return $path;
        }

    }

    /**
     * Calculate the hours between two times .
     *
     * @param $start date and time
     *
     * @param $end date and time
     *
     * @return integer
     */
    public static function calculate_hours_difference_two($start = '', $end = '')
    {

        if (!empty($start)) {

            $date1 = Carbon::createFromFormat('Y-m-d H:i:s', $start);
            $date2 = Carbon::createFromFormat('Y-m-d H:i:s', $end);

            return $duration = $date1->diffInHours($date2);
        }
        return 0;

    }

    /**
     * This method to get delete the unziped
     * file's while  logout
     *
     * @param $baby_id
     *
     */
    public static function remove_unziped_files($user_id)
    {

        $unzippedFile = \DB::table('recorded_audio_history')->where('file_opened', true)
            ->where('file_opened_by', $user_id)->get();
        $path = self::getAudioPath('AUDIO_FILE_PATH', 1);

        foreach ($unzippedFile as $key => $value) {
            \File::delete($path . $value->audio_file_name);
            \DB::table('recorded_audio_history')
                ->where('id', $value->id)
                ->update(['file_opened_by' => null]);

        }

        return 0;

    }
    /**
     * This method to get column
     * based on table
     *
     * @param $table  type string
     * @param $column type string
     * @param $where_class_name string
     * @param $id
     */
    public static function gettable_values($table, $column, $where_class_name, $id)
    {

        if ($id != 'N/A' && $id != 'undefined') {
            $results_name = \DB::table($table)->select($column)->where($where_class_name, $id)->first();
            $results_name = (array) $results_name;
        }

        return isset($results_name[$column]) ? $results_name[$column] : 'N/A';

    }

    /**
     * Method to get all baby
     *
     * @param  $id type integer
     * @return type array list
     */
    public static function Status($id, $modulename)
    {
        $results = \DB::table('delete_approval')->where('ModuleId', $id)->where('ModuleName', $modulename)->whereNotNull('Id')
            ->select('Status')
            ->orderby('Id', 'desc')
            ->first();
        return $results;
    }

    /**
     * Method To Get Vital Parameter
     *
     * @return type array lists
     */
    public static function getvitals_param()
    {

        $vitals = ['0' => 'core_temp', '1' => 'peripheral_temp', '2' => 'T1_T2', '3' => 'hr_rate', '4' => 'respiratory_rate', '5' => 'cuff_systalic_bp', '6' => 'cuff_diastolic_bp', '7' => 'cuff_mean_bp', '8' => 'arterial_systalic_bp', '9' => 'arterial_diastolic_bp', '10' => 'arterial_mean_bp'];
        return $vitals;

    }

    /**
     * Method To Check Action Url Exists
     *
     * @param  $action type string
     * @param  $parameter type string or integer
     * @return type boolean true or false
     */
    public static function action_exists($action, $parameter = null)
    {

        try {
            if (is_null($parameter)) {
                action($action);
            } elseif (!is_null($parameter)) {
                action($action, $parameter);
            }

        } catch (\Exception $e) {

            return false;
        }

        return true;
    }

    /**
     * method to get prescription status
     *
     * @param  $id type integer
     *
     * @return type array or string
     */
    public static function get_medicheinestatus($id = null)
    {
        $status = array(
            '0' => 'Waiting for conformation',
            '1' => 'Send to pump',
            '2' => 'Executing'
        );

        return (!is_null($id) && isset($status[$id])) ? $status[$id] : $status;

    }

    /**
     * This method to set prescription id
     *
     * @return array
     */
    public static function prescriptionKeyId()
    {

        return array(
            0 => "IVDI",
            1 => "OIVD",
            2 => "OIVI",
            3 => "GI"
        );
    }

    /**
     * This method to re arrange array
     *
     * @param array list $array_list
     *
     * @return array $result
     */
    public static function re_arrange_array($array_list)
    {
        $result = [];
        foreach ($array_list as $key => $value) {
            $result[] = $value;

        }
        return $result;
    }

    /**
     * This method to get investigation
     * from hms applcation
     *
     * @return array
     */
    public static function getInvestigations()
    {
        $investigations_master_url = self::getConfigSettings('GET_HMS_INVESTIGATIONS');
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $investigations_master_url . '3');
        $master_investigations = $response->getBody();
        $master_investigations = $master_investigations->getContents();
        return $master_investigations = collect(json_decode($master_investigations)->data)
            ->pluck('name', 'id')
            ->toArray();

    }

    /**
     * This method to get array to string
     * convertion
     *
     * @param $ids
     * @return string
     */
    public static function getArraytoString($ids)
    {
        $list = '';
        foreach ($ids as $key => $value) {
            if ((count($ids) - 1) != $key) {
                $list .= $value[0] . ',';
            } else {
                $list .= $value[0];
            }

        }
        return $list;

    }

    /**
     * Method to get toastr custom options
     *
     * @return type array list
     */
    public static function toastrOptions()
    {
        $results = \DB::table('site_settings')->select('custom_toastr')
            ->first();
        return $results;
    }

    /**
     * Method to get pagination custom value
     *
     * @return type array list
     */
    public static function paginationLimit()
    {
        $results = \DB::table('site_settings')->select('pagenation_limit_options')
            ->first();

        $results = json_decode($results->pagenation_limit_options);

        return $results;
    }

    /**
     * This method to get logo url
     * for nicu admission
     */
    public static function getNicuLogo($id = 0)
    {
        $result = \DB::table('nicu_admission')->where('NicuId', $id)->first();
        $logo = \DB::table('site_settings')->first();
        if (count($result) > 0) {
            if (isset($result->hospital_name) && !is_null($result->hospital_name) && !empty($result->hospital_name)) {
                if ($result->hospital_name == 'Sudha Hospital') {
                    return url('public/img/sudhalogo.png');
                } elseif ($result->hospital_name == 'Saraswathi Nursing Home') {
                    return url('public/img/saraswathi.png');
                } elseif ($result->hospital_name == 'SKS Hospital') {
                    return url('public/img/' . $logo->PrintLogo);
                } else {
                    return url('public/img/' . $logo->PrintLogo);
                }
            } else {
                return url('public/img/' . $logo->PrintLogo);
            }

        } else {
            $image_path = public_path() . '/img/' . $logo->PrintLogo;
            if (file_exists($image_path)) {
                return url('public/img/' . $logo->PrintLogo);
            } else {
                return url('public/img/noimage.png');
            }
        }

    }
    /**
     * This method to get logo url
     * for postnatal admission
     */
    public static function getPostnatalLogo($id = '')
    {
        $result = \DB::table('postnatal_admission')->where('pid', $id)->first();
        $logo = \DB::table('site_settings')->first();
        if (count($result) > 0) {
            if (isset($result->hospital_name) && !is_null($result->hospital_name) && !empty($result->hospital_name)) {
                if ($result->hospital_name == 'Sudha Hospital') {
                    return url('public/img/sudhalogo.png');
                } elseif ($result->hospital_name == 'Saraswathi Nursing Home') {
                    return url('public/img/saraswathi.png');
                } elseif ($result->hospital_name == 'SKS Hospital') {
                    return url('public/img/' . $logo->PrintLogo);
                } else {
                    return url('public/img/' . $logo->PrintLogo);
                }
            } else {
                return url('public/img/' . $logo->PrintLogo);
            }

        } else {
            $image_path = public_path() . '/img/' . $logo->PrintLogo;
            if (file_exists($image_path)) {
                return url('public/img/' . $logo->PrintLogo);
            } else {
                return url('public/img/noimage.png');
            }
        }

    }

    /**
     * This method to get logo url
     * for postnatal admission
     */
    public static function getOpLogo($id = null)
    {
        $result = \DB::table('op_details')->where('OpId', $id)->first();
        $logo = \DB::table('site_settings')->first();
        if (count($result) > 0) {
            if (!is_null($result->hospital_name) && !empty($result->hospital_name)) {
                if ($result->hospital_name == 'Sudha Hospital') {
                    return url('public/img/sudhalogo.png');
                } elseif ($result->hospital_name == 'Saraswathi Nursing Home') {
                    return url('public/img/saraswathi.png');
                } elseif ($result->hospital_name == 'SKS Hospital') {
                    return url('public/img/' . $logo->PrintLogo);
                } else {
                    return url('public/img/' . $logo->PrintLogo);
                }
            } else {
                return url('public/img/' . $logo->PrintLogo);
            }

        } else {
            $image_path = public_path() . '/img/' . $logo->PrintLogo;
            if (file_exists($image_path)) {
                return url('public/img/' . $logo->PrintLogo);
            } else {
                return url('public/img/noimage.png');
            }
        }

    }

    /**
     * This method to get logo url
     * for nicu admission
     */
    public static function getNicuLogoDocs($id = '')
    {
        $result = \DB::table('nicu_admission')->where('NicuId', $id)->first();
        $logo = \DB::table('site_settings')->first();
        if (count($result) > 0) {
            if (!is_null($result->hospital_name) && !empty($result->hospital_name)) {
                if ($result->hospital_name == 'Sudha Hospital') {
                    return public_path('img/sudhalogo.png');
                } elseif ($result->hospital_name == 'Saraswathi Nursing Home') {
                    return url('public/img/saraswathi.png');
                } elseif ($result->hospital_name == 'SKS Hospital') {
                    return public_path('img/' . $logo->PrintLogo);
                } else {
                    return public_path('img/' . $logo->PrintLogo);
                }
            } else {
                return public_path('img/' . $logo->PrintLogo);
            }

        } else {
            $image_path = public_path() . '/img/' . $logo->PrintLogo;
            if (file_exists($image_path)) {
                return public_path('img/' . $logo->PrintLogo);
            } else {
                return public_path('img/noimage.png');
            }
        }

    }
    /**
     * @param $id problem id type integer
     * @param $baby_id baby id type integer
     *
     * @return type strings
     */
    public static function getProblemStatus($id = '', $baby_id = '')
    {
        $results = \DB::table('pb_episodes_list')->where('problem_id', $id)->where('baby_id', $baby_id)->where('IsDeleted', 0)
            ->get();
        $status = '';
        if (count($results) > 0) {
            foreach ($results as $key => $value) {
                if (isset($value->start_date) && !is_null($value->start_date) && isset($value->end_date) && !is_null($value->end_date)) {
                    $status = 'completed';
                } else {
                    $status = 'incomplete';
                    return $status;
                }
            }
        }
        return $status;
    }
    /**
     * @param $baby_id baby id type integer
     *
     * @return type strings
     */
    public static function checkPerforma($baby_id)
    {
        $results = \DB::table('neonatal_proforma')->select('NeonatalId')
            ->where('BabyId', $baby_id)->first();
        if (isset($results->NeonatalId)) {
            return $results->NeonatalId;
        } else {
            return 0;
        }
    }
    /**
     * @param $mother_id type integer
     *
     * @return type strings
     */
    public static function getBabiesCount($mother_id)
    {
        return \DB::table('baby')->where('MotherId', $mother_id)->count();
    }

    /**
     * Method to get highlight the text field
     *
     * Based on the module
     *
     * @return type array list
     */
    public static function highLight()
    {
        $results = \DB::table('site_settings')->select('neonatal_highlight', 'nicu_highlight', 'nicu_daycare_highlight', 'daycare_summary_highlight', 'prblm_summary_highlight', 'post_adm_highlight', 'post_daycare_adm_highlight', 'post_summary_highlight', 'op_highlight')
            ->first();
        return $results;
    }

    /**
     * Method to get day list for Growth Chart
     *
     * Based on the module
     *
     * @return type array list
     */
    public static function getDaysForChart()
    {
        $results = \DB::table('site_settings')->select('daycare_dates_for_chart')
            ->first();
        if (isset($results->daycare_dates_for_chart) && !empty($results->daycare_dates_for_chart)) {
            return unserialize($results->daycare_dates_for_chart);
        }
        return array();
    }

    /**
     * Method to get Neonatal Id by Baby Id
     *
     * @param $baby_id type int
     *
     * Based on the module
     *
     * @return type array list
     */
    public static function getNeonatal($baby_id)
    {
        $results = \DB::table('neonatal_proforma')->select('NeonatalId')
            ->where('BabyId', $baby_id)
            ->where('IsDeleted', 0)
            ->first();
        return (isset($results->NeonatalId)) ? $results->NeonatalId : '';
    }

    public static function menuname()
    {
        return [
            "card_admission_registration" => "Registration / Admission",
            "card_daily_entry" => "Doctor’s Daily Entry",
            "card_registartion_by_nurse" => "Registration By Nurse",
            "card_nurse_daily_entry" => "Nurse Daily Entry",
            "card_nurse_hour_wise" => "Nurse Hourly Entry",
            "card_problem_sheet" => "Doctor’s Problem Entry Sheet",
            "card_discharge_transfer" => "Discharge / Transfer",
            "card_home_calendar" => "Calendar",
            "card_ballard_score" => "Ballard Score",
            "card_glucose_rate" => "Glucose Rate Calculators",
            "card_age_calculator" => "Age Calculators",
            "card_remove_record" => "Remove Record",
            "card_ward_mangagement" => "Ward Management",
            "card_hero" => "HeRo",
            "card_nsofa_score" => "nSOFA Score",
            "card_msns_score" => "MSNS Score",
            "card_nutrition_chart" => "Nutrition Chart",
            "card_msns_score" => "MSNS Score",
            "card_nutrition_chart" => "Nutrition Chart",
            "card_nicu_time_line" => "NICU Journey",
            "card_lab_request" => "Lab Request",
            "side_menu_registartion" => "Registration",
            "side_menu_mother_registartion" => "Mothers",
            "side_menu_baby_registartion" => "Babies",
            "side_menu_neonatal_proforma" => "Neonate - Basic Details",
            "side_menu_nicu_admission" => "NICU Admission",
            "side_menu_nicu_admission_proforma" => "Admission Form",
            "side_menu_nicu_daycare" => "Doctor’s Daily Entry",
            "side_menu_problem_base_daycare" => "Doctor’s Problem Entry Sheet",
            "side_menu_nicu_discharge_details" => "NICU Discharge Details",
            "side_menu_nicu_discharge_summary" => "Summary (Doctor’s Daily Entry)",
            "side_menu_nicu_problem_summary" => "Discharge Summary (Doctor’s Problem Entry Sheet)",
            "side_menu_nurse_daycare" => "Nurse Daily Entry Form",
            "side_menu_nurse_hourly_sheet" => "Nurse’s Hourly Entry",
            "side_menu_postnatal_admission" => "Postnatal Admission",
            "side_menu_postnatal_admission_form" => "Admission Form",
            "side_menu_postnatal_daycare" => "Doctor’s Daily Entry",
            "side_menu_postnatal_problem" => "Doctor’s Problem Entry Sheet",
            "side_menu_postnatal_details" => "Postnatal Discharge Details",
            "side_menu_postnatal_summary" => "Postnatal Discharge Summary",
            "side_menu_reports" => "Reports",
            "side_menu_inpatient_report" => "Inpatient List",
            "side_menu_nicu_report" => "NICU Report",
            "side_menu_op_report" => "OP Report",
            "side_menu_pediatric_report" => "Pediatric Report",
            "side_menu_newborn_report" => "Newborn Report",
            "side_menu_culture_report" => "Culture Report",
            "side_menu_live_birth_report" => "Live Birth Report",
            "side_menu_echo_report" => "Echo Report",
            "side_menu_cranial_report" => "Cranial Report",
            "side_menu_op_activity_report" => "OP Activity Report",
            "side_menu_baby_tag_print" => "Baby Tag Printing",
            "side_menu_annual_reports" => "Annual Report",
            "side_menu_nnf" => "NNF",
            "side_menu_op_registration" => "Outpatient Clinics",
            "side_menu_neo_op_registration" => "Neonatal",
            "side_menu_neuro" => "Neuro",
            "side_menu_bayley_scale" => "Bayley Scale",
            "side_menu_tests" => "Tests",
            "side_menu_test_echocardiography" => "Echocardiography",
            "side_menu_test_cranial_ultrasonography" => "Cranial Ultrasonography",
            "side_menu_test_culture_registry" => "Culture Registry",
            "side_menu_growth_chart" => "Growth Chart",
            "side_menu_quality_indicator" => "Quality Indicators",
            "side_menu_prescription" => "Prescription",
            "side_menu_interface_data" => "Interface Data",
            "side_menu_monitor" => "Monitor",
            "side_menu_ventilator" => "Ventilator",
            "side_menu_pump" => "Pump",
            "side_menu_calculators" => "Calculators",
            "side_menu_ballard_score" => "Ballard Score",
            "side_menu_glucose_rate_calculator" => "Glucose Rate Calculator",
            "side_menu_age_calculator" => "Age Calculator",
            "side_menu_delete_approvals" => "Delete Approvals",
            "side_menu_pediatrics_op_registration" => "Pediatric",
            "top_menu_masters" => "Masters",
            "top_menu_antibiotics" => "Antibiotics",
            "top_menu_complications" => "Complications",
            "top_menu_medical_problems" => "Medical Problems",
            "top_menu_procedures" => "Procedures",
            "top_menu_problems" => "Problems",
            "top_menu_vaccines" => "Vaccines",
            "top_menu_icd_10" => "ICD 10",
            "top_menu_indication" => "Indication",
            "top_menu_doctors_surgeons" => "Doctors & Surgeons",
            "top_menu_admission_mode" => "Admission Mode",
            "top_menu_respiratory_indication" => "Respiratory Indication",
            "top_menu_nurse_master" => "Nurse Master",
            "top_menu_referral" => "Referral",
            "top_menu_ward" => "Ward",
            "top_menu_bed" => "Bed",
            "top_menu_freq" => "Frequency",
            "top_menu_dose" => "Dose",
            "top_menu_drugivfluid" => "Drugs & Iv Fluids",
            "top_menu_prescriptiontype" => "Prescription Type",
            "top_menu_investigations" => "Investigations",
            "top_menu_settings" => "Settings",
            "top_menu_usergroups" => "Usergroups",
            "top_menu_users" => "Users",
            "top_menu_site_settings" => "Site Settings",
            "top_menu_psite_settings" => "Problems Settings",
            "top_menu_my_profile" => "My Profile",
            "top_menu_log_out" => "Log Out",
            "top_menu_m_chat_r_questions" => "M-Chat-R Questions",
            "top_menu_m_chat_r_followup_questions" => "M-Chat-R Followup Questions",
            "top_menu_vaccine_age" => "Vaccination Schedule",
            "top_menu_vaccine_generic_name" => "Vaccine Generic Name",
            "side_menu_nicu_clinical_events" => "Clinical Events",
            "side_menu_nicu_care_events" => "Care Events",
            "top_menu_dasii_questions" => "DASII Questions",
            "top_menu_ddst_questions" => "DDST Settings",
            "top_menu_cbcl_questions" => "CBCL Questions",
            "top_menu_issa_questions" => "ISSA Questions",
            "side_menu_pediatric_admission" => "Pediatric Admission",
            "side_menu_usage_tracker" => "Usage Statistics",
            "side_menu_tpn_calculator" => "TPN Calculator",
            "top_menu_bayley_scale" => "BAYLEY Scale",
            "side_menu_feeding" => "Feeding",
            "side_menu_hnne" => "HNNE",
            "side_menu_hine" => "HINE",
            "side_menu_m_chat" => "M_CHAT",
            "side_menu_dasii" => "DASII",
            "side_menu_ddst" => "DDST II",
            "side_menu_cbcl" => "CBCL",
            "side_menu_bayley" => "BAYLEY",
            "side_menu_issa" => "ISSA",
            "side_menu_cars" => "CARS",
            "side_menu_infants" => "INFANTS",
            "side_menu_preschoolers" => "PRESCHOOLERS",
            "side_menu_pep3" => "PEP 3",
            "side_menu_neuro_basic" => "Neuro Basic Details",
            "side_menu_neuro_screening" => "Screening Assessment",
            "side_menu_op_neonatal" => "Neonatal",
            "side_menu_op" => "Out Patient",
            "top_menu_shortcode" => "Shortcode Settings",
        ];
    }
    /**
     * Method to Bed Date
     *
     * @param $table_name type string
     *
     * @param $id type int
     *
     * Based on the module
     *
     * @return type array list
     */
    public static function getWardData($table_name = '', $id)
    {
        $results = \DB::table($table_name)->where('id', $id)->first();
        if (isset($results->id)) {
            return array($results->id => $results->number);
        } else {
            return array();
        }
    }

    /**
     * Method to ward data
     *
     * @param $ward_name type name
     *
     * Based on the module
     *
     * @return type array list
     */
    public static function getWardIdByName($ward_name)
    {
        if ($ward_name == 'Postnatal Ward') {
            $ward_name = 'Postnatal';
        }
        $results = \DB::table('ward')->select('id')->where('name', $ward_name)->first();
        if (isset($results->id)) {
            return $results->id;
        } else {
            return '';
        }
    } /**
      * Method to ward data
      *
      * @param $ward_name type name
      *
      * Based on the module
      *
      * @return type array list
      */
    public static function getBabyNicuAdmission($baby_id, $admission_id)
    {

        return \DB::table('nicu_admission')
            ->select('NicuId', 'status', 'form_status')
            ->where('AdmissionId', '=', $admission_id)
            ->where('BabyId', '=', $baby_id)
            ->where('IsDeleted', '=', 0)
            ->orderBy('NicuId', 'desc')
            ->first();
    }
    /**
     * To clear ward dashboard related cookies
     *
     *
     * @return type boolean
     */
    public static function clearBedCookies()
    {
        if (isset($_COOKIE['motherMrn'])) {
            unset($_COOKIE['motherMrn']);
        }
        if (isset($_COOKIE['babyMrn'])) {
            unset($_COOKIE['babyMrn']);
        }
        if (isset($_COOKIE['babyCurrentWard'])) {
            unset($_COOKIE['babyCurrentWard']);
        }
        if (isset($_COOKIE['babyCurrentRoom'])) {
            unset($_COOKIE['babyCurrentRoom']);
        }
        if (isset($_COOKIE['babyCurrentBed'])) {
            unset($_COOKIE['babyCurrentBed']);
        }
        if (isset($_COOKIE['add_ward_id'])) {
            unset($_COOKIE['add_ward_id']);
        }
        if (isset($_COOKIE['add_room_id'])) {
            unset($_COOKIE['add_room_id']);
        }
        if (isset($_COOKIE['add_bed_id'])) {
            unset($_COOKIE['add_bed_id']);
        }
        // if (isset($_COOKIE['babyIpNumber'])) {
        //     unset($_COOKIE['babyIpNumber']);
        // }
        if (isset($_COOKIE['babyNurseUpdate'])) {
            unset($_COOKIE['babyNurseUpdate']);
        }
        return true;
    }

    public static function getNicuFreeBeds($slug = false)
    {
        if ($slug) {
            return \DB::table('bed')
                ->join('room', 'room.id', '=', 'bed.room_id')
                ->join('ward', 'ward.id', '=', 'room.ward_id')
                ->select('bed.id', 'bed.number', 'hms_ward_id', 'hms_room_id', 'hms_bed_id', 'room_id', 'ward_id')
                ->where('status', '<>', 'Occupied')
                ->orWhereNull('status')
                ->where('ward.name', 'NICU')
                ->orderBy('bed.id', 'asc')
                ->get()
                ->toArray();
        } else {
            return \DB::table('bed')
                ->join('room', 'room.id', '=', 'bed.room_id')
                ->join('ward', 'ward.id', '=', 'room.ward_id')
                ->select('bed.id', 'bed.number')
                ->where('status', '<>', 'Occupied')
                ->orWhereNull('status')
                ->where('ward.name', 'NICU')
                ->orderBy('bed.id', 'asc')
                ->pluck('bed.number', 'bed.id')
                ->toArray();
        }
    }


    public static function formateWeeklyValue($result_array, $date, $time_period, $code = '', $secondary_array = array())
    {

        $start_date_time = $date . ' ' . $time_period;
        $end_date_time = date('Y-m-d H:i:s', strtotime($start_date_time) + 60 * 60 * 24);
        if ($code == 'bowels') {
            $bowels_total_val = 0;
            $bowels_content = '<td>-</td>';
            do {
                $end_date_time = date('Y-m-d H:i:s', strtotime($end_date_time) - 60 * 60 * 1);
                $end_date_time_index = date('Y-m-d_H', strtotime($end_date_time));

                if (isset($result_array[$end_date_time_index]) && $result_array[$end_date_time_index] == 'on') {
                    $bowels_total_val += 1;
                }
                if ($bowels_total_val > 0) {
                    $bowels_content = '<td>Opened (' . $bowels_total_val . ')</td>';
                }

                // if (isset($result_array[$end_date_time_index]) && $result_array[$end_date_time_index] == 'on') {
                //     $bowels_total_val = isset($secondary_array[$end_date_time_index]) ? $secondary_array[$end_date_time_index] : 0;

                //     $bowels_content = '<td>Opened ('.$bowels_total_val.')</td>';
                //     return $bowels_content;
                // }
            } while (strtotime($end_date_time) > strtotime($start_date_time));
            return $bowels_content;
        } elseif ($code == 'stools') {
            do {
                $end_date_time = date('Y-m-d H:i:s', strtotime($end_date_time) - 60 * 60 * 1);
                $end_date_time_index = date('Y-m-d_H', strtotime($end_date_time));
                if (isset($result_array[$end_date_time_index]) && $result_array[$end_date_time_index] == 'on') {
                    $bowels_total_val = isset($secondary_array[$end_date_time_index]) ? $secondary_array[$end_date_time_index] : '-';

                    if ($bowels_total_val == 'Pale white' || $bowels_total_val == 'Loose' || $bowels_total_val == 'Mucous' || $bowels_total_val == 'Bloody') {
                        $bowels_content = '<td>' . $bowels_total_val . '</td>';
                    } else {
                        $bowels_content = '<td>N/A</td>';
                    }

                    return $bowels_content;
                }
            } while (strtotime($end_date_time) > strtotime($start_date_time));
            return '<td>-</td>';
        } else {

            do {
                $end_date_time = date('Y-m-d H:i:s', strtotime($end_date_time) - 60 * 60 * 1);
                $end_date_time_index = date('Y-m-d_H', strtotime($end_date_time));
                if (isset($result_array[$end_date_time_index])) {
                    return $result_array[$end_date_time_index];
                }
            } while (strtotime($end_date_time) > strtotime($start_date_time));
        }

        return 0;
    }

    public static function temperatureOrder()
    {
        $change_order = true;
        return $change_order;
    }

    /**
     * Converting the consultants from serialzed to string.
     *
     * @param $consultant serialzed
     *
     * @param $flag boolean
     *
     * @return string  or html
     */
    public static function formating_consultant_signature($consultant, $flag = false, $hospital_name = '', $from_summary = false)
    {

        $result = '';
        $neon_con = [];
        if (!is_null($consultant) && @unserialize($consultant) !== false && count(@unserialize($consultant)) > 0) {
            $neon_con = unserialize($consultant);
        } else {
            // $neon_con = json_decode($consultant);
            $neon_con = collect(json_decode($consultant))->toArray();
        }

        $i = 1;
        if (count($neon_con) > 0) {
            if ($hospital_name == 'Saraswathi Nursing Home') {
                $deleted_consultant = array_search(7, $neon_con);
                if ($deleted_consultant > 0) {
                    unset($neon_con[$deleted_consultant]);
                }
            }
            foreach ($neon_con as $value) {

                if (count($neon_con) == $i) {

                    if ($flag) {
                        $result .= '<li>' . \ValuelistHelpers::mas_doctors_list($value) . '</li>';
                    } else {
                        if ($from_summary) {
                            $result .= \ValuelistHelpers::mas_doctors_user_id($value) . '||' . \ValuelistHelpers::mas_doctors_list($value);
                        } else {
                            $result .= \ValuelistHelpers::mas_doctors_list($value);
                        }
                    }

                } else {

                    if ($flag) {
                        $result .= '<li>' . \ValuelistHelpers::mas_doctors_list($value) . '~ </li>';
                    } else {
                        if ($from_summary) {
                            $result .= \ValuelistHelpers::mas_doctors_user_id($value) . '||' . \ValuelistHelpers::mas_doctors_list($value) . '~ ';
                        } else {
                            $result .= \ValuelistHelpers::mas_doctors_list($value) . '~ ';
                        }
                    }

                }
                $i++;
            }
        }

        return $result;

    }

    public static function test()
    {
        echo '<pre>';
        print_r('hi!');
        exit;
    }

    public static function menuList($mrn, $admission_id = 0, $module = '')
    {

        if ($module == 'mother_registration') {
            $baby_details = \DB::table('mother')
                ->join('baby', 'mother.MotherId', 'baby.MotherId')
                ->where('mother.MotherId', $mrn)
                ->orderBy('BabyId', 'desc')
                ->first();
            if (count($baby_details) > 0) {
                $mrn = $baby_details->BMrNo;
            } else {
                $mrn = '';
            }
        }

        $details = \DB::table('baby')
            ->where('BMrNo', $mrn)
            ->where('IsDeleted', 0)
            ->orderBy('BabyId', 'desc')
            ->first();

        $write_permission = session('write_permission');
        $read_permission = session('read_permission');

        $menu_items = ' <ul class="nav navbar-nav pull-right">
        </ul>';

        if (!empty($mrn) && is_array($write_permission) && isset($details->BabyId)) {

            $baby_id = $details->BabyId;
            $mother_id = $details->MotherId;
            $g_weeks = $details->g_weeks;

            $site_url = url('/') . '/';

            if ($module == 'ward') {

                $admission_details = \DB::table('patient_bed_log')
                    ->join('baby_admission', 'patient_bed_log.admission_id', '=', 'baby_admission.AdmissionId')
                    ->join('ip_numbers', 'patient_bed_log.admission_id', '=', 'ip_numbers.AdmissionId')
                    ->where('baby_admission.BabyId', $baby_id)
                    ->where('baby_admission.BMrNo', $mrn)
                    ->where('baby_admission.MotherId', $mother_id)
                    ->where('baby_admission.Status', 'Inpatient')
                    ->orderBy('baby_admission.AdmissionId', 'desc')
                    ->orderBy('patient_bed_log.id', 'desc')
                    ->first();

                $neonatal_id = SiteHelpers::getNeonatal($baby_id);
                $admission_id = isset($admission_details->AdmissionId) ? $admission_details->AdmissionId : '';
                $admission_date = isset($admission_details->AdmissionDate) ? $admission_details->AdmissionDate : '';


                if (!empty($baby_id) && !empty($admission_id)) {

                    $nicu = SiteHelpers::getBabyNicuAdmission($baby_id, $admission_id);
                    $baby_admission_encrypt = SiteHelpers::encrypt_id($baby_id . '-' . $admission_id);

                    $ward_id = $admission_details->ward_id;
                    $ward_name = $admission_details->ward_name;
                    $room_id = $admission_details->room_id;
                    $room_name = $admission_details->room_no;
                    $bed_id = $admission_details->bed_id;
                    $bed_name = $admission_details->bed_no;
                    $ip_number = isset($admission_details->ip_number) ? $admission_details->ip_number : null;

                    $closewinlink = 'ward-dashboard';

                    $mother_details_link = $site_url . 'mother-registration/' . SiteHelpers::encrypt_id($mother_id) . '/edit?flow=from-dashboard&baby=' . base64_encode($baby_id);
                    $baby_details_link = $site_url . 'baby-registration/' . SiteHelpers::encrypt_id($baby_id) . '/edit?flow=from-dashboard';
                    $neonatal_proforma_edit_link = $site_url . 'neonatal/' . SiteHelpers::encrypt_id($neonatal_id) . '/edit?flow=from-dashboard';
                    $neonatal_proforma_create_link = $site_url . 'neonatal/create/' . SiteHelpers::encrypt_id($baby_id) . '?flow=from-dashboard';

                    $menu_items = '<ul class="nav navbar-nav pull-right nicu-ward-menu">
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <ul class="dropdown-menu">';

                    if ($ward_name == 'NICU' || $ward_name == '4F_NICU') {

                        $menu_items .= SiteHelpers::nicumenu($mrn, $baby_id, $admission_id, $neonatal_id, $baby_admission_encrypt, $mother_details_link, $baby_details_link, $neonatal_proforma_create_link, $neonatal_proforma_edit_link, $ward_id, $ward_name, $room_id, $room_name, $bed_id, $bed_name, $module, $site_url, $write_permission, $read_permission, $closewinlink, $g_weeks, $ip_number, $admission_date);

                    } else if ($ward_name == 'Postnatal') {

                        $menu_items .= SiteHelpers::postnatalmenu($baby_id, $admission_id, $neonatal_id, $neonatal_proforma_create_link, $neonatal_proforma_edit_link, $ward_id, $ward_name, $room_id, $room_name, $bed_id, $bed_name, $site_url, $write_permission);

                    }

                    $menu_items .= '</ul>
                    </li>
                    </ul>';
                } else {

                    $menu_items = ' <ul class="nav navbar-nav pull-right">
                    </ul>';
                }
            } else {

                if ($admission_id > 0) {

                    $admission_details = \DB::table('patient_bed_log')
                        ->join('baby_admission', 'patient_bed_log.admission_id', '=', 'baby_admission.AdmissionId')
                        ->where('patient_bed_log.admission_id', $admission_id)
                        ->orderBy('patient_bed_log.id', 'desc')
                        ->first();

                } else {

                    $admission_details = \DB::table('patient_bed_log')
                        ->join('baby_admission', 'patient_bed_log.admission_id', '=', 'baby_admission.AdmissionId')
                        ->where('baby_admission.BabyId', $baby_id)
                        ->where('baby_admission.BMrNo', $mrn)
                        ->where('baby_admission.MotherId', $mother_id)
                        ->orderBy('patient_bed_log.id', 'desc')
                        ->first();

                }
                $admission_date = isset($admission_details->AdmissionDate) ? $admission_details->AdmissionDate : '';

                if ((isset($baby_id) && !empty($baby_id)) && (isset($mother_id) && !empty($mother_id))) {

                    $neonatal_id = SiteHelpers::getNeonatal($baby_id);
                    $mother_details_link = $site_url . 'mother-registration/' . SiteHelpers::encrypt_id($mother_id) . '/edit?flow=from-dashboard&baby=' . base64_encode($baby_id);
                    $baby_details_link = $site_url . 'baby-registration/' . SiteHelpers::encrypt_id($baby_id) . '/edit?flow=from-dashboard';
                    $neonatal_proforma_create_link = $site_url . 'neonatal/create/' . SiteHelpers::encrypt_id($baby_id) . '?flow=from-dashboard';

                    if (isset($neonatal_id) && !empty($neonatal_id)) {
                        $neonatal_proforma_edit_link = $site_url . 'neonatal/' . SiteHelpers::encrypt_id($neonatal_id) . '/edit?flow=from-dashboard';
                    } else {
                        $neonatal_proforma_edit_link = '';
                    }

                }

                if (count($admission_details) > 0) {
                    $value = $admission_details;
                    $admission_id = $value->AdmissionId;
                    if (!empty($baby_id) && !empty($admission_id)) {

                        $baby_admission_encrypt = SiteHelpers::encrypt_id($baby_id . '-' . $admission_id);

                        $ward_id = $value->ward_id;
                        $ward_name = $value->ward_name;
                        $room_id = $value->room_id;
                        $room_name = $value->room_no;
                        $bed_id = $value->bed_id;
                        $bed_name = $value->bed_no;
                        $ip_number = isset($admission_details->ip_number) ? $admission_details->ip_number : null;

                        $closewinlink = 'ward-dashboard';


                        $menu_items = '<ul class="nav navbar-nav pull-right nicu-ward-menu">
                        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <ul class="dropdown-menu">';

                        if ($ward_name == 'NICU' || $ward_name == '4F_NICU') {

                            $menu_items .= SiteHelpers::nicumenu($mrn, $baby_id, $admission_id, $neonatal_id, $baby_admission_encrypt, $mother_details_link, $baby_details_link, $neonatal_proforma_create_link, $neonatal_proforma_edit_link, $ward_id, $ward_name, $room_id, $room_name, $bed_id, $bed_name, $module, $site_url, $write_permission, $read_permission, $closewinlink, $g_weeks, $ip_number, $admission_date);

                        } else if ($ward_name == 'Postnatal') {

                            $menu_items .= SiteHelpers::postnatalmenu($baby_id, $admission_id, $neonatal_id, $neonatal_proforma_create_link, $neonatal_proforma_edit_link, $ward_id, $ward_name, $room_id, $room_name, $bed_id, $bed_name, $site_url, $write_permission);

                        }
                        $menu_items .= '</ul>
                        </li>
                        </ul>';
                    } else {

                        $menu_items = ' <ul class="nav navbar-nav pull-right">
                        </ul>';
                    }

                } else {

                    $menu_items = '<ul class="nav navbar-nav pull-right nicu-ward-menu">
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <ul class="dropdown-menu">';
                    if (is_array($write_permission) && in_array('MOTHER_REG', $write_permission) && $module != 'mother_registration') {

                        $menu_items .= '<li>
                        <a href="' . $mother_details_link . '" class="btn-edit-baby" title="Edit Mother Details">
                        <i class="fa fa-female"></i>
                        Edit Mother Details
                        </a>
                        </li>';

                    }

                    if (is_array($write_permission) && in_array('BABY_REG', $write_permission) && $module != 'baby_registration') {

                        $menu_items .= '<li>
                        <a href="' . $baby_details_link . '" class="btn-edit-baby" title="Edit Baby Details">
                        <i class="fas fa-baby-carriage"></i>
                        Edit Baby Details
                        </a>
                        </li>';

                    }

                    $started = '';
                    $partial = '';
                    $completed = '';

                    if (is_array($write_permission) && in_array('NEONATAL', $write_permission) && $module != 'neonatal_proforma') {

                        $menu_items .= '<li>';

                        if ($neonatal_id != '') {

                            $neonatal_status = \DB::table('neonatal_proforma')
                                ->select('form_status')
                                ->where('NeonatalId', $neonatal_id)
                                ->first();

                            $neonatal_status = (isset($neonatal_status->form_status)) ? $neonatal_status->form_status : 0;

                            if ($neonatal_status == 0) {
                                $started = 'active';
                            } else if ($neonatal_status == 1) {
                                $partial = 'active';
                            } else {
                                $completed = 'active';
                            }

                            $menu_items .= '<a href="' . $neonatal_proforma_edit_link . '" class="create-neonatal" data-placement="right" data-title="Neonatal Proforma">
                            <i class="fas fa-baby"></i>
                            Edit Neonatal Proforma';

                            $menu_items .= '<span class="status-container"><strong class="not-started ' . $started . '"></strong>';
                            $menu_items .= '<strong class="partial ' . $partial . '"></strong>';
                            $menu_items .= '<strong class="completed ' . $completed . '"></strong></span>';
                            $menu_items .= '</a>';

                        } else {

                            $menu_items .= '<a href="' . $neonatal_proforma_create_link . '" class="" data-placement="right" data-title="Neonatal Proforma">
                            <i class="fas fa-baby"></i>
                            Create Neonatal Proforma';

                            $started = 'active';

                            $menu_items .= '<span class="status-container"><strong class="not-started ' . $started . '"></strong>';
                            $menu_items .= '<strong class="partial ' . $partial . '"></strong>';
                            $menu_items .= '<strong class="completed ' . $completed . '"></strong></span>';
                            $menu_items .= '</a>';

                        }

                        $menu_items .= '</li>';
                    }

                    $menu_items .= '</ul>
                    </li>
                    </ul>';

                }
            }

        } else {

            $menu_items = ' <ul class="nav navbar-nav pull-right">
            </ul>';

        }

        return $menu_items;
    }

    public static function nicumenu($mrn, $baby_id, $admission_id, $neonatal_id, $baby_admission_encrypt, $mother_details_link, $baby_details_link, $neonatal_proforma_create_link, $neonatal_proforma_edit_link, $ward_id, $ward_name, $room_id, $room_name, $bed_id, $bed_name, $module, $site_url, $write_permission, $read_permission, $closewinlink, $g_weeks, $ip_number, $admission_date)
    {

        $menu_items = '';

        if (is_array($read_permission) && in_array('NICU_MODULE_SHEET', $read_permission) && ($module != 'nurse_sheet_edit' && $module != 'nurse_sheet_day_list')) {

            $nurse_sheet_link = $site_url . 'nicu-nurse-sheet-day/' . SiteHelpers::encrypt_id($admission_id) . '/' . $closewinlink;

            $menu_items .= '<li>
            <a href="' . $nurse_sheet_link . '" class="nurse-menu-highlighter" data-placement="right" data-title="Nurse Sheet">
            <i class="fas fa-user-nurse"></i>
            Create / Edit Nurse Sheet
            </a>
            </li>';
        }

        if (is_array($write_permission) && in_array('PRESCRIPTION', $write_permission) && $module != 'prescription') {

            $prescription_link = $site_url . 'prescription/' . $baby_admission_encrypt;

            $menu_items .= '<li>
            <a href="' . $prescription_link . '" class="prscription-list prescription-menu-highlighter">
            <i class="fas fa-prescription"></i>
            Create / Edit Prescription
            </a>
            </li>';

        }
        if (is_array($read_permission) && in_array('NICU_MODULE_SHEET', $read_permission) && ($module != 'nurse_sheet_edit' && $module != 'nurse_sheet_day_list' && $module != 'lab_report')) {

            $temp_module = ($module == 'ward') ? 'ward-dashboard' : $module;
            $menu_items .= '<li>
            <a href="' . url('lab-value-print') . '?mrn=' . self::encrypt_id($mrn) . '&closewinlink=' . $temp_module . '&admission_id=' . $admission_id . '" class="lab-menu-highlighter" data-placement="right" data-title="Lab Report">
            <i class="fa fa-flask"></i>
            Lab Report
            </a>
            </li>';
        }

        $nicu = SiteHelpers::getBabyNicuAdmission($baby_id, $admission_id);

        if (isset($nicu->status) && $nicu->status == 'Inpatient' && $module != 'nicu_dashboard') {

            $ward_dashboard = $site_url . 'ward-dashboard-view' . '?mrn=' . $mrn . '&admission_date=' . $admission_date . '&bed_no=' . SiteHelpers::encrypt_id($bed_name) . '&baby_id=' . SiteHelpers::encrypt_id($baby_id);

            $menu_items .= '<li>
            <a href="' . $ward_dashboard . '" class="nicu-dashboard-highlighter">
            <i class="fas fa-desktop fa-rotate-90"></i>
            NICU dashboard
            </a>
            </li>';
        }

        if (in_array('CALCULATOR', $write_permission)) {

            $temp_module = ($module == 'ward') ? 'ward-dashboard' : $module;
            $menu_items .= '<li>
            <a href="' . url('tpn-calculator') . '?baby_id=' . \SiteHelpers::encrypt_id($baby_id) . '&closewinlink=' . $temp_module . '" class="tpn-menu-highlighter" data-placement="right" data-title="TPN Calculator">
            <i class="fas fa-balance-scale"></i>
            TPN Calculator
            </a>
            </li>';
        }

        $pacs_link = self::pacsViewerLink();

        $pacs_link = str_replace('MRN', $mrn, $pacs_link);

        // $menu_items .= '<li>
        // <a href="'.$pacs_link.'" target="_blank" class="pacs-menu-highlighter">
        // <i class="fas fa-x-ray"></i>
        // Radiology / PACS
        // </a>
        // </li>';

        $pacs_link = url('get-pacs-viewer') . '/' . $mrn;
        $menu_items .= '<li>
        <a href="' . $pacs_link . '" target="_blank" class="pacs-menu-highlighter">
        <i class="fas fa-x-ray"></i>
        Radiology / PACS
        </a>
        </li>';

        // $menu_items .= '<li>
        // <a href="'.url('pacs/'.\SiteHelpers::encrypt_id($mrn)).'" target="_blank" class="pacs-menu-highlighter">
        // <i class="fas fa-x-ray"></i>
        // Radiology / PACS
        // </a>
        // </li>';

        if (is_array($write_permission) && in_array('CLINICAL_EVENT', $write_permission) && $module != 'care_event_marker') {
            $menu_items .= '<li>
            <a href="' . $site_url . 'get-events/' . \SiteHelpers::encrypt_id($mrn) . '/' . $bed_id . '" class="event-marker-menu-highlighter">
            <i class="fa fa-thumb-tack" aria-hidden="true" style="transform: rotate(45deg);"></i>
            Care Event Marker
            </a>
            </li>';
        }

        if (is_array($write_permission) && in_array('CLINICAL_EVENT', $write_permission) && (\Auth::user()->RoleId == env('ADMIN_ROLE') || \Auth::user()->RoleId == env('SUPER_ADMIN_ROLE')) && $module != 'care_event_chart') {
            $menu_items .= '<li>
            <a href="' . $site_url . 'care-event-chart?mrn=' . \SiteHelpers::encrypt_id($mrn) . '" class="care-event-chart-menu-highlighter">
            <i class="fa fa-bar-chart" aria-hidden="true"></i>
            Care Event Chart
            </a>
            </li>';
        }

        if (is_array($write_permission) && in_array('CLINICAL_EVENT', $write_permission) && $module != 'clinical_event_markers') {

            $temp_module = ($module == 'ward') ? 'ward-dashboard' : $module;
            $menu_items .= '<li>
            <a href="' . url('clinical-events/' . \SiteHelpers::encrypt_id($baby_id . '-' . $admission_id)) . '?closewinlink=' . $temp_module . '" class="clinical-event-menu-highlighter" data-placement="right" data-title="Clinical Event Marker">
            <i class="fas fa-first-aid"></i>
            Clinical Event Marker
            </a>
            </li>';
        }

        if (isset($g_weeks) && $g_weeks < 37) {
            $menu_items .= '<li>
            <a href="' . $site_url . 'inter-growth-chart?baby_id=' . SiteHelpers::encrypt_id($baby_id) . '&closewinlink=ward-dashboard"  class="growth-chart-menu-highlighter" title="Intergrowth 21st Century Chart">
            <i class="fa fa-sort-amount-asc" aria-hidden="true" style="transform: rotate(180deg);"></i>
            Growth Chart
            </a>
            </li>';
        } else {
            $menu_items .= '<li>
            <a href="' . $site_url . 'who-growth-chart?baby_id=' . SiteHelpers::encrypt_id($baby_id) . '&closewinlink=ward-dashboard" class="growth-chart-menu-highlighter" title="WHO Growth Chart">
            <i class="fa fa-sort-amount-asc" aria-hidden="true" style="transform: rotate(180deg);"></i>
            Growth Chart
            </a>
            </li>';
        }

        if (is_array($write_permission) && in_array('MOTHER_REG', $write_permission) && $module != 'mother_registration') {

            $menu_items .= '<li>
            <a href="' . $mother_details_link . '" class="btn-edit-baby" title="Edit Mother Details">
            <i class="fa fa-female"></i>
            Edit Mother Details
            </a>
            </li>';

        }

        if (is_array($write_permission) && in_array('BABY_REG', $write_permission) && $module != 'baby_registration') {

            $menu_items .= '<li>
            <a href="' . $baby_details_link . '" class="btn-edit-baby" title="Edit Baby Details">
            <i class="fas fa-baby-carriage"></i>
            Edit Baby Details
            </a>
            </li>';

        }

        $started = '';
        $partial = '';
        $completed = '';

        if (is_array($write_permission) && in_array('NEONATAL', $write_permission) && $module != 'neonatal_proforma') {

            $menu_items .= '<li>';

            if ($neonatal_id != '') {

                $neonatal_status = \DB::table('neonatal_proforma')
                    ->select('form_status')
                    ->where('NeonatalId', $neonatal_id)
                    ->first();

                $neonatal_status = (isset($neonatal_status->form_status)) ? $neonatal_status->form_status : 0;

                if ($neonatal_status == 0) {
                    $started = 'active';
                } else if ($neonatal_status == 1) {
                    $partial = 'active';
                } else {
                    $completed = 'active';
                }

                $menu_items .= '<a href="' . $neonatal_proforma_edit_link . '" class="create-neonatal" data-placement="right" data-title="Neonatal Proforma">
                <i class="fas fa-baby"></i>
                Edit Neonatal Proforma';

                $menu_items .= '<span class="status-container"><strong class="not-started ' . $started . '"></strong>';
                $menu_items .= '<strong class="partial ' . $partial . '"></strong>';
                $menu_items .= '<strong class="completed ' . $completed . '"></strong></span>';
                $menu_items .= '</a>';

            } else {

                $menu_items .= '<a href="' . $neonatal_proforma_create_link . '" class="" data-placement="right" data-title="Neonatal Proforma">
                <i class="fas fa-baby"></i>
                Create Neonatal Proforma';

                $started = 'active';

                $menu_items .= '<span class="status-container"><strong class="not-started ' . $started . '"></strong>';
                $menu_items .= '<strong class="partial ' . $partial . '"></strong>';
                $menu_items .= '<strong class="completed ' . $completed . '"></strong></span>';
                $menu_items .= '</a>';

            }

            $menu_items .= '</li>';
        }

        $nicu_started = '';
        $nicu_partial = '';
        $nicu_completed = '';

        if (is_array($write_permission) && in_array('NICU_FORM', $write_permission) && $module != 'nicu_admission') {

            if (isset($nicu->NicuId)) {

                $nicu_edit_link = $site_url . 'nicu-admission/' . SiteHelpers::encrypt_id($nicu->NicuId) . '/edit/editmodule?flow=from-dashboard';

                $menu_items .= '<li>
                <a href="' . $nicu_edit_link . '" data-placement="right" data-title="Edit Nicu Admission Details" class="edit-nicu-details">
                <i class="fa fa-pencil-square-o"></i>
                Edit NICU Admission Details';

                $nicu_status = (isset($nicu->form_status)) ? $nicu->form_status : 0;
                if ($nicu_status == 0) {
                    $nicu_started = 'active';
                } else if ($nicu_status == 1) {
                    $nicu_partial = 'active';
                } else {
                    $nicu_completed = 'active';
                }

                $menu_items .= '<span class="status-container"><strong class="not-started ' . $nicu_started . '"></strong>';
                $menu_items .= '<strong class="partial ' . $nicu_partial . '"></strong>';
                $menu_items .= '<strong class="completed ' . $nicu_completed . '"></strong></span>';
                $menu_items .= '</a>';
                $menu_items .= '</li>';

            } else {

                $nicu_create_link = $site_url . 'nicu-admission/create/' . SiteHelpers::encrypt_id($baby_id . '-' . $admission_id);

                $menu_items .= '<li>
                <a href="' . $nicu_create_link . '" data-placement="right" data-title="Create Nicu Admission Details" class="create-nicu-details">
                <i class="fa fa-pencil-square-o"></i>
                Create NICU Admission Details';

                $nicu_started = 'active';
                $menu_items .= '<span class="status-container"><strong class="not-started ' . $nicu_started . '"></strong>';
                $menu_items .= '<strong class="partial ' . $nicu_partial . '"></strong>';
                $menu_items .= '<strong class="completed ' . $nicu_completed . '"></strong></span>';
                $menu_items .= '</a>';
                $menu_items .= '</li>';

            }
        }

        if (is_array($write_permission) && in_array('NICU_DAY', $write_permission) && ($module != 'daycare_edit' && $module != 'daycare_list')) {

            $daycare_link = $site_url . 'daycare-admission/daycare-admission-daylist/' . SiteHelpers::encrypt_id($admission_id) . '?flow=from-dashboard';

            $today_daycare_status = \DB::table('daycare')
                ->where('BabyId', $baby_id)
                ->where('AdmissionId', $admission_id)
                ->where('DayDate', date('Y-m-d'))
                ->first();

            $today_daycare_started = '';
            $today_daycare_partial = '';
            $today_daycare_completed = '';

            $today_daycare_status = (isset($today_daycare_status->form_status)) ? $today_daycare_status->form_status : 0;
            if ($today_daycare_status == 0) {
                $today_daycare_started = 'active';
            } else if ($today_daycare_status == 1) {
                $today_daycare_partial = 'active';
            } else {
                $today_daycare_completed = 'active';
            }

            $menu_items .= '<li>
            <a href="' . $daycare_link . '" data-placement="right" data-title="Doctor\'s Daily Entry">
            <i class="fas fa-user-md"></i>
            Doctor\'s Daily Entry';
            $menu_items .= '<span class="status-container"><strong class="not-started ' . $today_daycare_started . '"></strong>';
            $menu_items .= '<strong class="partial ' . $today_daycare_partial . '"></strong>';
            $menu_items .= '<strong class="completed ' . $today_daycare_completed . '"></strong></span>';
            $menu_items .= '</a>    
            </li>';

        }

        // if(is_array($write_permission) && in_array('NICU_PROBLEM_DAY',$write_permission)) {

        //     $problem_based_daycare_link = $site_url.'problem-systems-episodes/'.SiteHelpers::encrypt_id($baby_id.'-'.$admission_id);

        //     $menu_items .= '<li>
        //     <a href="'.$problem_based_daycare_link.'" class="" data-placement="right" data-title="Problem Based Entry">
        //     <i class="fas fa-notes-medical"></i>
        //     Problem Based Entry
        //     </a>
        //     </li>';

        // }

        if (is_array($write_permission) && in_array('NICU_DISCHARGE', $write_permission) && $neonatal_id != '' && $module == 'ward') {

            $menu_items .= '
        <li>
        <a href="javascript:void(0);" id="discharge-home" class="' . $module . '" data-placement="right" data-baby-id="' . $baby_id . '" data-admission-id="' . $admission_id . '" data-add-ward-id="' . $ward_id . '" data-add-ward-name="' . $ward_name . '" data-add-room-id="' . $room_id . '" data-add-room-name="' . $room_name . '" data-add-bed-id="' . $bed_id . '" data-add-bed-name="' . $bed_name . '" data-baby-mrn="' . $mrn . '" data-ip-number="' . $ip_number . '" data-neonatal-found=' . ($neonatal_id != '' ? "false" : "true") . '>
        <i class="fas fa-clinic-medical fa-2x"></i>
        Discharge / Transfer
        </a>
        </li>';

        }

        if (is_array($read_permission) && in_array('NICU_DISCHARGE', $read_permission) && $neonatal_id != '' && ($module != 'problem_base_daycare' && $module != 'problem_base_daycare_list')) {

            $daycare_summary_link = $site_url . 'nicu-discharge-summary/' . SiteHelpers::encrypt_id($baby_id . '-' . $admission_id);

            $problem_based_summary_link = $site_url . 'problems-discharge-summary/' . SiteHelpers::encrypt_id($baby_id . '-' . $admission_id);

            $menu_items .= '<li>
            <a href="' . $daycare_summary_link . '" class="" data-placement="right" data-title="Daycare Summary">
            <i class="fas fa-briefcase-medical"></i>
            View Interim Summary
            </a>
            </li>';
            // <li>

            // <a href="'.$problem_based_summary_link.'" class="" data-placement="right" data-title="Problem Based Summary">
            // <i class="fa fa-list-alt"></i>
            // View Problem Based Summary
            // </a>
            // </li>

        }

        if ((isset($nicu->status) && $nicu->status == 'Inpatient') && (env("INTERFACE_MACHINE") || env("MONITOR_INTERFACE") || env("VENTILATOR_MACHINE") || env("PUMP_INTERFACE")) && $module != 'live_chart') {
            $live_chart_link = $site_url . 'live-chart?baby_id=' . SiteHelpers::encrypt_id($baby_id) . '&admission_id=' . SiteHelpers::encrypt_id($admission_id);

            $menu_items .= '<li>
            <a href="javascript:void(0);" id="live-chart-link" data-url="' . $live_chart_link . '">
            <i class="fa fa-line-chart" aria-hidden="true"></i>
            Live Chart
            </a>
            </li>';
        }

        // if ((isset($nicu->status) && $nicu->status == 'Inpatient') && (env("INTERFACE_MACHINE") || env("MONITOR_INTERFACE") || env("VENTILATOR_MACHINE") || env("PUMP_INTERFACE")) && $module != 'range_chart') {
        if ((env("INTERFACE_MACHINE") || env("MONITOR_INTERFACE") || env("VENTILATOR_MACHINE") || env("PUMP_INTERFACE")) && $module != 'range_chart') {
            $comparison_chart_link = $site_url . 'comparison-charts?baby_id=' . SiteHelpers::encrypt_id($baby_id) . '&admission_date=' . SiteHelpers::encrypt_id($admission_date);

            $menu_items .= '<li>
            <a href="' . $comparison_chart_link . '" id="range-chart">
            <i class="fa fa-bar-chart" aria-hidden="true"></i>
            Range Comparison Chart
            </a>
            </li>';
        }

        // if ((isset($nicu->status) && $nicu->status == 'Inpatient') && $module != 'fio2_chart' && (\Auth::user()->RoleId == 1 || \Auth::user()->RoleId == 4)) {
        $role_id = \Auth::user()->RoleId;
        if ($module != 'fio2_chart' && ($role_id == 1 || $role_id == 2 || $role_id == 4)) {
            $chart_link = $site_url . 'fio2-charts?baby_id=' . SiteHelpers::encrypt_id($baby_id) . '&admission_date=' . SiteHelpers::encrypt_id($admission_date);

            $menu_items .= '<li>
            <a href="' . $chart_link . '" id="fio2-chart">
            <i class="fa fa-bar-chart" aria-hidden="true"></i>
            Fio2 Chart
            </a>
            </li>';
        }

        return $menu_items;
    }

    public static function postnatalmenu($baby_id, $admission_id, $neonatal_id, $neonatal_proforma_create_link, $neonatal_proforma_edit_link, $ward_id, $ward_name, $room_id, $room_name, $bed_id, $bed_name, $site_url, $write_permission)
    {

        if (is_array($write_permission) && (in_array('MOTHER_REG', $write_permission) || in_array('BABY_REG', $write_permission))) {
            $menu_items .= '<li>
            <a href="' . $baby_details_link . '" class="btn-edit-baby" title="Edit Baby Details">
            <i class="fa fa-pencil"></i>
            Edit Baby Details
            </a>
            </li>';
        }

        $started = '';
        $partial = '';
        $completed = '';

        if (is_array($write_permission) && in_array('NEONATAL', $write_permission) && $module != 'neonatal_proforma') {

            $menu_items .= '<li>';

            if ($neonatal_id != '') {

                $neonatal_status = \DB::table('neonatal_proforma')
                    ->select('form_status')
                    ->where('NeonatalId', $neonatal_id)
                    ->first();

                $neonatal_status = (isset($neonatal_status->form_status)) ? $neonatal_status->form_status : 0;

                if ($neonatal_status == 0) {
                    $started = 'active';
                } else if ($neonatal_status == 1) {
                    $partial = 'active';
                } else {
                    $completed = 'active';
                }

                $menu_items .= '<a href="' . $neonatal_proforma_edit_link . '" class="create-neonatal" data-placement="right" data-title="Neonatal Proforma">
                <i class="fas fa-baby"></i>
                Edit Neonatal Proforma';

                $menu_items .= '<span class="status-container"><strong class="not-started ' . $started . '"></strong>';
                $menu_items .= '<strong class="partial ' . $partial . '"></strong>';
                $menu_items .= '<strong class="completed ' . $completed . '"></strong></span>';
                $menu_items .= '</a>';

            } else {

                $menu_items .= '<a href="' . $neonatal_proforma_create_link . '" class="" data-placement="right" data-title="Neonatal Proforma">
                <i class="fas fa-baby"></i>
                Create Neonatal Proforma';

                $started = 'active';
                $menu_items .= '<span class="status-container"><strong class="not-started ' . $started . '"></strong>';
                $menu_items .= '<strong class="partial ' . $partial . '"></strong>';
                $menu_items .= '<strong class="completed ' . $completed . '"></strong></span>';
                $menu_items .= '</a>';

            }

            $menu_items .= '</li>';
        }

        if (is_array($write_permission) && in_array('POST_DAY', $write_permission) && $neonatal_id != '') {

            $postnatal_daycare = $site_url . 'postnatal-daycare-daywiselist/' . SiteHelpers::encrypt_id($admission_id . '-' . $baby_id);

            $menu_items .= '<li>
            <a href="' . $postnatal_daycare . '" class="" data-placement="right" data-title="Postnatal Doctor\'s Daily Entry">
            <i class="fas fa-user-md"></i>
            Postnatal Doctor\'s Daily Entry
            </a>
            </li>';

        }

        if (is_array($write_permission) && in_array('POST_PROBLEM_SYSTEM', $write_permission) && $neonatal_id != '') {

            $postnatal_problem_based_daycare = $site_url . 'postproblem-systems-episodes/' . SiteHelpers::encrypt_id($baby_id . '-' . $admission_id);

            $menu_items .= '<li>
            <a href="' . $postnatal_problem_based_daycare . '" class="" data-placement="right" data-title="Postnatal Problem Based Entry">
            <i class="fas fa-notes-medical"></i>
            Postnatal Problem Based Entry
            </a>
            </li>';

        }

        if (is_array($write_permission) && in_array('POST_DISCHARGE', $write_permission) && $neonatal_id != '') {

            $postnatal_problem_based_symmary = $site_url . 'postproblem-systems-summary/' . SiteHelpers::encrypt_id($baby_id . '-' . $admission_id);

            $menu_items .= '<li>
            <a href="' . $postnatal_problem_based_symmary . '" class="" data-placement="right" data-title="Postnatal Summary">
            <i class="fas fa-briefcase-medical"></i>
            View Postnatal Summary
            </a>
            </li>';

        }

        if (is_array($write_permission) && in_array('POST_DISCHARGE', $write_permission) && $ward_id != '' && $ward_name != '' && $room_id != '' && $room_name != '' && $bed_id != '' && $bed_name != '') {

            $menu_items .= '<li>
            <li>
            <a href="javascript:void(0)" class="discharge-patient" data-placement="right" data-title="Nurse Sheet" data-add-admission-id="' . $admission_id . '" data-add-baby-id="' . $baby_id . '" data-add-ward-id="' . $ward_id . '" data-add-room-id="' . $room_id . '" data-add-bed-id="' . $bed_id . '">
            <i class="fas fa-user-clock" aria-hidden="true"></i>
            Discharge Patient
            </a>
            </li>
            <li>
            <a href="javascript:void(0)" id="transfer-patient" data-baby-id="' . $baby_id . '" data-admission-id="' . $admission_id . '" data-add-ward-id="' . $ward_id . '" data-add-ward-name="' . $ward_name . '" data-add-room-id="' . $room_id . '" data-add-room-name="' . $room_name . '" data-add-bed-id="' . $bed_id . '" data-add-bed-name="' . $bed_name . '">
            <i class="fas fa-bed" aria-hidden="true"></i>
            Transfer Patient
            </a>
            </li>';

        }
    }

    /**
     * This method to calulate the corrected age in weeks and days
     * between birth to given date
     *
     * @param $gestation_weeks type date
     * @param $gestation_days type date
     *
     * @return type array
     */

    public static function calculateCorrectedAge($gestation_weeks, $gestation_days, $dob, $calculate_date)
    {
        if ($gestation_weeks != '' && $dob != '' && $calculate_date != '') {
            $dob = strtotime($dob); // or your date as well
            $current_date = strtotime($calculate_date);
            $datediff = $current_date - $dob;
            $chronological_age_days = $datediff / (60 * 60 * 24);
            $corrected_age = $chronological_age_days - (((40 - $gestation_weeks) * 7) + $gestation_days);
            if ($corrected_age > 0) {
                return array(
                    'corrected_age_weeks' => intval($corrected_age / 7),
                    'corrected_age_days' => $corrected_age % 7,
                );
            } else {
                return array(
                    'corrected_age_weeks' => 0,
                    'corrected_age_days' => 0,
                );
            }
        } else {
            return array(
                'corrected_age_weeks' => 0,
                'corrected_age_days' => 0,
            );
        }

    }

    public static function calculateCorrectedGestation($gestation_weeks, $gestation_days, $dob, $calculate_date)
    {
        if ($gestation_weeks != '' && $dob != '' && $calculate_date != '') {
            $gestation_days = !empty($gestation_days) ? $gestation_days : 0;

            $dob = strtotime($dob); // or your date as well
            $current_date = strtotime($calculate_date);
            $datediff = $current_date - $dob;
            $chronological_age_days = $datediff / (60 * 60 * 24);
            $corrected_age = $chronological_age_days + ($gestation_weeks * 7) + $gestation_days;

            if ($corrected_age > 0) {
                return array(
                    'corrected_age_weeks' => intval($corrected_age / 7),
                    'corrected_age_days' => $corrected_age % 7,
                );
            } else {
                return array(
                    'corrected_age_weeks' => 0,
                    'corrected_age_days' => 0,
                );
            }
        } else {
            return array(
                'corrected_age_weeks' => 0,
                'corrected_age_days' => 0,
            );
        }

    }


    public static function getRoomBybed($bed_id)
    {
        $result = \DB::table('bed')->where('id', $bed_id)->first();
        return $result;
    }

    /**
     * This method to calulate the chronological age in months
     * between birth to given date
     *
     * @param $start_date type date
     * @param $end_date type date
     *
     * @return type decimal or integer
     */
    public static function getChronologicalage($start_date, $end_date)
    {
        $baby_dob = Carbon::createFromFormat('Y-m-d', $start_date);
        $day_date = Carbon::createFromFormat('Y-m-d', $end_date);

        $diffinmonths_day = $baby_dob->diff($day_date)->format('%y,%m,%d');

        $diffinmonths_day = explode(',', $diffinmonths_day);
        $diffinmonths_year = $diffinmonths_day[0] * 12;

        $years = $diffinmonths_day[0];

        return $years;

    }

    /**
     * This method to update the nicu dashboard data
     *
     * @param $baby_id type integer
     * @param $module_name type string
     *
     */
    public static function updateDashboardAtFormUpdation($baby_id, $module_name)
    {

        $bed_details = \DB::table('patient_bed_log')->where('baby_id', $baby_id)->orderBy('id', 'desc')->first();

        if (isset($bed_details->bed_id)) {
            $check_exist = \DB::table('nicu_dashboard_results')->where('bed', $bed_details->bed_no)->first();

            if (count($check_exist) > 0) {
                $input['modify_tstamp'] = date('Y-m-d H:i:s');
                $input['modify_user_id'] = 0;
                $check_exist = \DB::table('nicu_dashboard_results')->where('id', $check_exist->id)->update(['need_data' => true, 'modify_tstamp' => $input['modify_tstamp'], 'modify_user_id' => $input['modify_user_id']]);
                NicuDashboardController::updateDashboardData();
            }

        }

    }

    /**
     * This method to update the nicu dashboard data for empty results
     *
     * @param $bed_number type integer
     * @param $room_number type integer
     *
     */
    public static function emptyDashboardData($bed_number, $room_number)
    {

        $empty_result = [["cotId" => $bed_number, "pageNo" => 1, "roomId" => $room_number, "patient" => ["mrn" => "", "ipNo" => "", "gender" => "", "weight" => ["atBirth" => "", "current" => "", "working" => ""], "babyName" => "", "pageInfo" => ["medications" => ["currentMedications" => [], "regularMedications" => ["date" => [], "items" => []], "infusionMedications" => [], "requiredMedications" => []], "respSupport" => ["tcpInfo" => [], "tfcInfo" => [], "respInfo" => ["respSupport" => ""], "intakeInfo" => [], "outputInfo" => [], "inhaledInfo" => []], "labAndScanInfo" => ["mri" => [], "xray" => [], "ctScan" => [], "abgInfo" => [], "labInvestigation" => []]], "admitDate" => "", "admitTime" => "", "ageInDays" => "", "birthDate" => "", "birthTime" => "", "bloodInfo" => ["dct" => "", "baby" => "", "mother" => "", "haemolysis" => ""], "corrected" => "", "gestation" => "", "tableInfo" => ["values" => [["label" => "High"], ["label" => "Median"], ["label" => "Low"]], "headers" => ["HR", "RR", "SpO2(%)", "BP (mmHg)", "Temp(&#8457;)"]], "ageOnadmission" => "", "currentProblems" => [], "previousProblems" => []], "currentDateTime" => ""]];

        $nicu_dashboard_results = \DB::table('nicu_dashboard_results')->where('bed', $bed_number)->first();

        if (isset($nicu_dashboard_results->bed)) {
            \DB::table('nicu_dashboard_results')->where('id', $nicu_dashboard_results->id)->update(['result_data' => json_encode($empty_result), 'modify_tstamp' => date('Y-m-d H:i:s'), 'modify_user_id' => '0']);
            broadcast(new DashboardEvent($empty_result))->toOthers();
        }

    }

    public static function arrayKeyConversion($array_list)
    {

        $array_list = (array) $array_list;

        $array_keys = array_keys($array_list);
        $array_values = array_values($array_list);

        $array_intKeys = array_map('intval', $array_keys);

        return array_combine($array_intKeys, $array_values);

    }

    public static function pacsViewerLink($type = 1)
    {

        // $path = '/ripacs2/viewer.html?patientID=MRN&preview=true';
        $path = '/';
        if ($type == 2) {
            // $path = '/telerad/StudyListApi.do?patientID=MRN&modality=MODALITY&admissionDate=ADMISSION_DATE';
            $path = '/telerad/StudyListApi.do?patientID=MRN&modality=MODALITY';
        } else if ($type == 3) {
            $path = '/telerad/WadoImage.do?studyId=STUDY_ID&seriesId=SERIES_ID&instanceId=INSTANCE_ID&rows=SIZE&contentType=CONTENT_TYPE';
        }

        // if (env('LOCAL_ADDRESS') == $_SERVER['HTTP_HOST'] || env('LOCAL_HOSTNAME') == $_SERVER['HTTP_HOST']) {
        //     $pacs_link = env('PACS_LOCAL_URL');
        // } else if (env('PUBLIC_ADDRESS') == $_SERVER['HTTP_HOST'] || env('PUBLIC_HOSTNAME') == $_SERVER['HTTP_HOST']) {
        //     $pacs_link = env('PACS_PUBLIC_URL');
        // } else {
        //     $pacs_link = env('PACS_PUBLIC_URL');
        // }

        $address = $_SERVER['REMOTE_ADDR'];
        $address = explode('.', $address);

        if (isset($address[0]) && $address[0] == 172) {
            $pacs_link = env('PACS_LOCAL_URL');
        } else {
            $pacs_link = env('PACS_PUBLIC_URL');
        }

        return $pacs_link . $path;

    }

    public static function ventilatorAutoO2TargetRange($range = '0')
    {
        if ($range == 1) {
            return '90-94';
        } else if ($range == 2) {
            return '91-95';
        } else if ($range == 3) {
            return '92-96';
        } else if ($range == 4) {
            return '94-98';
        } else {
            return [1 => '90-94', 2 => '91-95', 3 => '92-96', 4 => '94-98'];
        }
    }

    public static function checkCarolinaCurriculumGetColor($baby_result, $mainIndex, $objectIndex, $type = '', $class = '')
    {
        $visitColors = [
            0 => 'red',       // Fourth visit
            1 => 'green',      // Second visit
            2 => 'blue',    // Third visit
            3 => 'orange',     // First visit
        ];

        if (count($baby_result) > 0) {

            $overall_baby_result = array_map(function ($jsonString) {
                if (empty($jsonString)) {
                    return null;
                }

                $decoded = json_decode($jsonString, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    return null;
                }

                return $decoded;
            }, $baby_result);
            $last_results = array_key_last($baby_result);
            $response = '';
            $already_has_value = false;
            $total_value_for_the_cell = 0;
            foreach ($overall_baby_result as $key => $value) {
                if (isset($value) && !empty($value)) {
                    if (isset($value[$mainIndex][$objectIndex]) && $value[$mainIndex][$objectIndex] == 0.5 && $key != $last_results) {
                        $already_has_value = true;
                    }
                }
                if ($type == 'getClickEvent' && $key == $last_results) {
                    if ($total_value_for_the_cell == 0.5) {
                        return 2;
                    }
                    return 1;
                } else if ($type == 'getClickEvent' && $key != $last_results) {
                    if (isset($value) && !empty($value)) {
                        if (isset($value[$mainIndex][$objectIndex]) && $value[$mainIndex][$objectIndex] == 0.5) {
                            if ($total_value_for_the_cell == 0) {
                                $total_value_for_the_cell += $value[$mainIndex][$objectIndex];
                                continue;
                            } else if ($total_value_for_the_cell == 0.5) {
                                return 0;
                            } else {
                                return 2;
                            }
                        } else if (isset($value[$mainIndex][$objectIndex]) && $value[$mainIndex][$objectIndex] == 1) {
                            return 0;
                        }
                    }
                } else {
                    if (isset($value) && !empty($value)) {

                        if (isset($value[$mainIndex][$objectIndex]) && $value[$mainIndex][$objectIndex] == 1) {
                            if ($key == $last_results) {
                                return $visitColors[$key] . ' full-mark';
                            } else {
                                return $visitColors[$key] . ' full-mark not-score';
                            }
                        } else if (isset($value[$mainIndex][$objectIndex]) && $value[$mainIndex][$objectIndex] == 0.5) {

                            if ($key == $last_results) {
                                if ($already_has_value) {
                                    if ($response != '') {
                                        return $response . ' ' . $visitColors[$key] . '-second-half-current';
                                    } else {
                                        return $visitColors[$key] . ' half-mark';
                                    }
                                } else {
                                    return $visitColors[$key] . ' half-mark';
                                }

                            } else {
                                if ($already_has_value) {
                                    if ($response != '') {
                                        return $response . ' ' . $visitColors[$key] . '-second-half';
                                    } else {
                                        $response .= $visitColors[$key] . ' half-mark ';
                                        continue;
                                    }
                                } else {
                                    return $visitColors[$key] . ' half-mark previous-half';
                                }
                            }
                        }
                    }
                }
            }
            return $response;
        } else {
            return 1;
        }
    }

}

