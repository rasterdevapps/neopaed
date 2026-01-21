<?php
namespace App\Http\library;

use Illuminate\Support\Facades\DB;

/* This Helper will support generate the forms dynamicaly
   for problem based daycare 


This class has global access can access any where in the application 
better way of use is call by self method .
*/

/**
 * All the curd of problem base daycare goes here
 *
 * @author Manikandan M
 */
class ProblemBaseHelpers
{

    /**
     * create the form  label.
     *
     * @param  $properties type array of object
     * @return html label  tag
     */
    public static function createLabel($properties)
    {

        return '<label for="' . $properties->para_name . '">' . $properties->para_label . '</label>';
    }

    /**
     * create the form label.
     *
     * @param  $properties type array of object
     * @return html label  tag
     */
    public static function createHeader($properties)
    {

        return '<label for="' . $properties->para_name . '" style="font-size:' . $properties->para_fontsize . 'px !important ">' . $properties->para_label . '</label>';
    }

    /**
     * create the form single line textbox.
     *
     * @param  $properties    type array of object
     * @param  $uniqueId      type string
     * @param  $param_values  type array
     * @return  html text tag
     */
    public static function createTextcomponent($properties, $uniqueId, $param_values)
    {
        if (count($param_values) > 0)
        {
            $value = isset($param_values[$properties->para_name]) ? $param_values[$properties->para_name] : '';
        }
        else
        {
            $value = isset($properties->para_default) ? $properties->para_default : '';
        }

        $required = ($properties->para_required == 1) ? 'required' : '';

        $episodeNumber = isset(explode('-', $uniqueId) [2]) ? explode('-', $uniqueId) [2] - 1 : '';
        

        if (isset($properties->para_addmore) && $properties->para_addmore == 1)
        {

            $textBox = '<table class="add-more-textbox' . $properties->para_name . '-' . $episodeNumber . ' table">';
            $textBox .= '<thead><tr><th></th><th></th></tr></thead>';
            $textBox .= '<tbody>';
            if (isset($param_values[$properties->para_name]) && is_array($param_values[$properties->para_name]) && count($param_values[$properties->para_name]) > 0)
            {
                foreach ($param_values[$properties->para_name] as $key => $paramValues)
                {
                    $textBox .= '<tr>';
                    $textBox .= '<td>' . '<input name="' . $properties->para_name . '[' . $episodeNumber . ']['.$key.']" value="' . $paramValues . '" class="form-control" id="' . $properties->para_name . $uniqueId . '" ' . $required . ' placeholder ="' . $properties->para_placeholder . '" type="text">' . '</td>';
                    $textBox .= '<td><a href="javascript:void(0);" class="remove-text btn" data-source-id="' . $uniqueId . '"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
                    $textBox .= '</tr>';
                }

            }
            else
            {

                $textBox .= '<tr>';
                // $textBox .= '<td>' . '<input name="' . $properties->para_name . '[' . $episodeNumber . '][]" value="' . $value . '" class="form-control" id="' . $properties->para_name . $uniqueId . '" ' . $required . ' placeholder ="' . $properties->para_placeholder . '" type="text">' . '</td>';
                // $textBox .= '<td><a href="javascript:void(0);" class="remove-text btn" data-source-id="' . $uniqueId . '"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
                $textBox .= '</tr>';

            }

            $textBox .= '</tbody>';
            $textBox .= '</table>';
            $textBox .= '<div class="form-group">';
            $textBox .= '<a href="javascript:void(0)" data-table-name="' . $properties->para_name . '" data-source-textname="' . $properties->para_name . '[' . $episodeNumber . '][]" data-source-id="' . $episodeNumber . '" class="pull-right save-button-shadow  btn add-text-box btn-info">';
            $textBox .= '<i class="fa fa-plus" aria-hidden="true">&nbspAdd More</i></a></div><br/>';
            return $textBox;

        }
        else
        {

            return '<input name="' . $properties->para_name . '[]" value="' . $value . '" class="form-control" id="' . $properties->para_name . $uniqueId . '" ' . $required . ' placeholder ="' . $properties->para_placeholder . '" type="text">';

        }

    }

    /**
     * create the form multiple line textbox.
     *
     * @param  $properties   type array of object
     * @param  $uniqueId     type string
     * @param  $param_values type array
     * @return  html textarea tag
     */
    public static function createTextareacomponent($properties, $uniqueId, $param_values)
    {
        if (count($param_values) > 0)
        {
            $value = isset($param_values[$properties->para_name]) ? $param_values[$properties->para_name] : '';
        }
        else
        {
            $value = isset($properties->para_default) ? $properties->para_default : '';
        }
        return '<textarea style="resize: none;" rows="' . $properties->para_row . '" cols="' . $properties->para_column . '" name="' . $properties->para_name . '[]" value="" id="' . $properties->para_name . $uniqueId . '" class="form-control"> ' . $value . ' </textarea>';

    }

    /**
     * create the form number box.
     *
     * @param   $properties  type array of object
     * @param   $uniqueId    type string
     * @param   $param_values type array
     * @return  html number tag
     */
    public static function createNumbercomponent($properties, $uniqueId, $param_values)
    {

        if (count($param_values) > 0)
        {
            $value = isset($param_values[$properties->para_name]) ? $param_values[$properties->para_name] : '';
        }
        else
        {
            $value = isset($properties->para_default) ? $properties->para_default : '';
        }
        $required = ($properties->para_required == 1) ? 'required' : '';

        $properties->para_digit_dependancy = isset($properties->para_digit_dependancy) ? $properties->para_digit_dependancy : "";

        return '<input name="' . $properties->para_name . '[]" value="' . $value . '" " ' . $required . ' min="' . $properties->para_min . '" numbers-only="numbers-only" max="' . $properties->para_max . '"  class="form-control show-input" id="' . $properties->para_name . $uniqueId . '" placeholder ="' . $properties->para_placeholder . '"  data-dependancy="' . urlencode($properties->para_digit_dependancy) . '" type="number">';

    }

    /**
     * create the form  decimal box.
     *
     * @param  $properties   type array of object
     * @param  $uniqueId     type string
     * @param  $param_values type array
     * @return html decimalnumber tag
     */
    public static function createDecimalcomponent($properties, $uniqueId, $param_values)
    {
        if (count($param_values) > 0)
        {
            $value = isset($param_values[$properties->para_name]) ? $param_values[$properties->para_name] : '';
        }
        else
        {
            $value = isset($properties->para_default) ? $properties->para_default : '';
        }

        $properties->para_decimal_dependancy = isset($properties->para_decimal_dependancy) ? $properties->para_decimal_dependancy : "";

        return '<input name="' . $properties->para_name . '[]" value="' . $value . '" class="form-control show-input"  id="' . $properties->para_name . $uniqueId . '" placeholder ="' . $properties->para_placeholder . '" data-dependancy="' . urlencode($properties->para_decimal_dependancy) . '" type="number">';

    }

    /**
     * create the form  dropdown box.
     *
     * @param   $properties type array of object
     * @param   $uniqueId   type string
     * @param   $param_values
     * @return  html select tag
     */
    public static function createDropdowncomponent($properties, $uniqueId, $param_values)
    {

        $options = '';
        $options .= '<option value="N/A">N/A</option>';
        $option_name = json_decode($properties->para_option_name);
        $option_value = json_decode($properties->para_option_value);

        if (count($param_values) > 0)
        {
            $values = isset($param_values[$properties->para_name]) ? $param_values[$properties->para_name] : '';
        }
        else
        {
            $values = isset($properties->para_default) ? $properties->para_default : '';
        }

        foreach ($option_name as $key => $value)
        {

            $selected = ($values == $option_value[$key]) ? "selected" : "";

            $options .= '<option ' . $selected . ' value="' . $option_value[$key] . '"> ' . $value . '</option>';

        }
        // $episodeNumber = isset(explode('-', $uniqueId) [2]) ? explode('-', $uniqueId) [2] : '';
        $episodeNumber = isset(explode('-', $uniqueId) [2]) ? explode('-', $uniqueId) [2] - 1 : '';

        if (isset($properties->para_addmore) && $properties->para_addmore == 1)
        {

            $dropBox = '<table class="table add-more-dropbox-' . $properties->para_name . '-' . $episodeNumber . '">';
            $dropBox .= '<thead>';
            $dropBox .= '<tr><th></th><th></th></tr>';
            $dropBox .= '<thead>';
            $dropBox .= '<tbody>';
            if (count($param_values) > 0 && isset($param_values[$properties->para_name]) && !empty($param_values[$properties->para_name]) && is_array($param_values[$properties->para_name]))
            {
                // echo "<pre>"; print_r($param_values);
                // echo "<pre>"; print_r($properties); exit;
                $param_array = $param_values[$properties->para_name];
                foreach ($param_array as $selectKey => $selectValue)
                {

                    $options = '';
                    $options .= '<option value="N/A">N/A</option>';
                    foreach ($option_name as $key => $value)
                    {

                        $selected = ($option_value[$key] == $selectValue) ? "selected" : "";

                        $options .= '<option ' . $selected . ' value="' . $option_value[$key] . '"> ' . $value . '</option>';

                    }
                    if (isset($param_values[$properties->para_name]) && $param_values[$properties->para_name] != '')
                    {
                        $dropBox .= '<tr>';
                        $dropBox .= '<td><select name="' . $properties->para_name . '[' . $episodeNumber . ']['.$selectKey.']" id="' . $properties->para_name . $uniqueId . '" class="form-control input-width-xlarge">';
                        $dropBox .= $options;
                        $dropBox .= '</select></td>';
                        $dropBox .= '<td><a href="javascript:void(0);" class="remove-drop-down btn" data-source-id="' . $uniqueId . '"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
                        $dropBox .= '</tr>';
                    }
                }
            }
            else
            {

                $dropBox .= '<tr>';
                // $dropBox .= '<td><select name="' . $properties->para_name . '[' . $episodeNumber . '][]" id="' . $properties->para_name . $uniqueId . '" class="form-control input-width-xlarge">';
                // $dropBox .= $options;
                // $dropBox .= '</select></td>';
                // $dropBox .= '<td><a href="javascript:void(0);" class="remove-drop-down btn" data-source-id="' . $uniqueId . '"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
                $dropBox .= '</tr>';
            }

            $dropBox .= '</tbody>';
            $dropBox .= '</table>';
            $dropBox .= '<div class="form-group"><a href="javascript:void(0)" data-table-name ="' . $properties->para_name . '" data-option-name="' . $properties->para_name . '-temp" data-source-dropbox="' . $properties->para_name . '[' . $episodeNumber . '][]" data-source-id="' . $episodeNumber . '" class="pull-right save-button-shadow   btn  add-drop-box btn-info"><i class="fa fa-plus" aria-hidden="true">&nbspAdd More</i></a></div><br/>';
            $dropBox .= '<div class="hidden">';
            $dropBox .= '<select name="' . $properties->para_name . '-temp">';
            $dropBox .= $options;
            $dropBox .= '</select>';
            $dropBox .= '</div>';

        }
        else
        {

            $dropBox = '<select name="' . $properties->para_name . '[]" id="' . $properties->para_name . $uniqueId . '" class="form-control">';
            $dropBox .= $options;
            $dropBox .= '</select>';

        }

        return $dropBox;

    }

    /**
     * create the form  toggle box.
     *
     * @param  $properties type array of object
     * @param  $uniqueId  type string
     * @param  $param_values type array
     * @return html check box tag with toggle addon
     */
    public static function createTogglecomponent($properties, $uniqueId, $param_values)
    {
        if (count($param_values) > 0)
        {
            $values = (isset($param_values[$properties->para_name]) && $param_values[$properties->para_name] == 'true') ? 'checked' : '';
        }
        else
        {
            $values = (isset($properties->para_default) && $properties->para_default == 'true') ? 'checked' : '';
        }

        $episode_count = explode('-', $uniqueId);
        $episode_count = end($episode_count) - 1;

        return '<input name="' . $properties->para_name . '['.$episode_count.']" data-on="' . $properties->para_toggle_on . '" id="' . $properties->para_name . $uniqueId . '" data-off="' . $properties->para_toggle_off . '" data-toggle="toggle" data-width="' . $properties->para_toggle_width . '" data-size="small" ' . $values . ' class="form-control initialze-toggle" data-dependancy="' . urlencode($properties->para_toggle_dependancy) . '" type="checkbox" data-toggle-id="'.$episode_count.'">';

    }

    /**
     * create the form  horizontal selector box.
     *
     * @param  $properties type array of object
     * @param  $uniqueId type string
     * @param  $param_values type array
     * @return html horizontal selector tag
     */
    public static function createHorizontalselector($properties, $uniqueId, $param_values)
    {

        $options = '';
        $option_name = json_decode($properties->hpara_option_name);
        $option_value = json_decode($properties->hpara_option_value);
        $option_color = $properties->hpara_option_color;

        if (count($param_values) > 0)
        {
            $values = isset($param_values[$properties->para_name]) ? $param_values[$properties->para_name] : '';
        }
        else
        {
            $values = isset($properties->para_default) ? $properties->para_default : '';
        }

        foreach ($option_name as $key => $value)
        {
            $selected = ($values == $option_value[$key]) ? 'selected' : '';
            $options .= '<option value="' . $option_value[$key] . '" ' . $selected . '> ' . $value . '</option>';

        }
        $dropBox = "<select name='" . $properties->para_name . "[]' id='" . $properties->para_name . $uniqueId . "' class='form-control horizontal' data-color='" . $option_color . "'>";

        $dropBox .= $options;

        $dropBox .= '</select>';

        return $dropBox;

    }

    /**
     * create the form  check box.
     *
     * @param   $properties type array of object
     * @param   $uniqueId type string
     * @param   $param_values type array
     * @return  html check box tag
     */
    public static function createCheckboxcomponent($properties, $uniqueId, $param_values)
    {

        $checkbox = '<div class="checkbox-group">';

        $optionName = json_decode($properties->para_chkop_name);
        $optionValue = json_decode($properties->para_chkop_value);
        // $episodeNumber = isset(explode('-', $uniqueId) [2]) ? explode('-', $uniqueId) [2] : '';
        $episodeNumber = isset(explode('-', $uniqueId) [2]) ? explode('-', $uniqueId) [2] - 1 : '';
        $checkedValues = array_keys($optionValue);
        if (count($param_values) > 0)
        {
            $selectedValues = json_decode($param_values[$properties->para_name]);
            $selectedmaster = json_decode($properties->para_chkop_value);

            foreach ($selectedmaster as $key => $value)
            {

                if (is_array($selectedValues) && in_array($value, $selectedValues))
                {
                    $checkedValues[$key] = 'checked';
                }

            }

        }
        else
        {
            $values = isset($properties->para_default) ? $properties->para_default : '';
        }
        foreach ($optionName as $key => $value)
        {

            $checked = isset($checkedValues[$key]) ? $checkedValues[$key] : '';
            $checkbox .= '<label class="radio-inline"><input name="' . $properties->para_name . '[' . $episodeNumber . ']' . '[]" id="' . $properties->para_name . $uniqueId . $key . '" value="' . $optionValue[$key] . '" ' . $checked . ' type="checkbox"> ' . $value . '</label>';
        }

        $checkbox .= '</div>';
        return $checkbox;

    }

    /**
     * create the form radio box.
     *
     * @param  $properties type array of object
     * @param  $uniqueId type string
     * @param  $param_values type array
     * @return html radio box tag
     */
    public static function createRadiocomponent($properties, $uniqueId, $param_values)
    {

        $radiobox = '<div class="radio-group">';

        if (count($param_values) > 0)
        {
            $values = (isset($param_values[$properties->para_name]) && $param_values[$properties->para_name] == true) ? $param_values[$properties->para_name] : '';
        }
        else
        {
            $values = isset($properties->para_default) ? $properties->para_default : '';
        }

        $optionName = json_decode($properties->para_rdop_name);
        $optionValue = json_decode($properties->para_rdop_value);

        foreach ($optionName as $key => $value)
        {
            $checked = ($values == $optionValue[$key]) ? 'checked' : '';

            $radiobox .= '<label class="radio-inline"><input name="' . $properties->para_name . '[]" value="' . $optionValue[$key] . '" id="' . $properties->para_name . $uniqueId . $key . '" ' . $checked . ' type="radio"> ' . $value . '</label>';
        }

        $radiobox .= '</div>';
        return $radiobox;

    }

    /**
     * create the form drug group's set.
     *
     * @param  $properties type array of object
     * @param  $uniqueId type string
     * @param  $param_values type array
     * @param  $drugs type array
     * @return html drug group's set
     */
    public static function createDrugset($properties, $uniqueId, $param_values, $drugs)
    {

        $propertyName = str_replace('[]', '', $properties->para_name);
        $durationName = $propertyName . 'duration';
        $doesName = $propertyName . 'does';

        // $episodeNumber = isset(explode('-', $uniqueId) [2]) ? explode('-', $uniqueId) [2] : '';
        $episodeNumber = isset(explode('-', $uniqueId) [2]) ? explode('-', $uniqueId) [2] - 1 : '';
        $options = '';
        $durgSet = '<table class="table drug-module-depentancy add-more-drugs' . $episodeNumber . '">';
        $durgSet .= '<thead>';
        $durgSet .= '<tr>';
        $durgSet .= '<th><label>Drug</label> <a href="javascript:void(0)" class="add_master_data" data-modal_header="Drugs & Iv Fluids" data-destination_elements="elements_id" data-option_value="id" data-option_text="brand_name" data-mas_table="mas_drugivfluid" data-type="drug" data-drug_type="oral"><i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Drugs & Iv Fluids"></i></a></th>';
        $durgSet .= '<th><label>Duration</label></th>';
        $durgSet .= '<th><label>Dose</label></th>';
        $durgSet .= '<th></th>';
        $durgSet .= '</tr>';
        $durgSet .= '</thead>';
        $durgSet .= '<tbody>';

        $input_names = '';

        if (isset($param_values[$propertyName]) && count($param_values[$propertyName]) > 0)
        {
            foreach ($param_values[$propertyName] as $medicineIndex => $medicineValue)
            {
                $medicineValue = (array)$medicineValue;
                $options = '';
                $options .= '<option value="N/A">N/A</option>';
                foreach ($drugs as $key => $value)
                {
                    $selected = ($medicineValue[$propertyName] == $key) ? 'selected' : '';
                    $options .= '<option ' . $selected . ' value="' . $key . '" >' . $value . '</option>';
                }

                $durgSet .= '<tr>';
                $durgSet .= '<td class="input-width-xlarge"> <select class="form-control ' . $propertyName . '" name="' . $propertyName . '[' . $episodeNumber . ']['.$medicineIndex.']">' . $options . '</select> </td>';
                $durgSet .= '<td class="input-width-xlarge"> <input class="form-control" type="text" value="' . $medicineValue[$durationName] . '" name="' . $durationName . '[' . $episodeNumber . ']['.$medicineIndex.']"></td>';
                $durgSet .= '<td class="input-width-xlarge"> <input class="form-control" type="text" value="' . $medicineValue[$doesName] . '" name="' . $doesName . '[' . $episodeNumber . ']['.$medicineIndex.']"></td>';
                $durgSet .= '<td>';
                $durgSet .= '<a href="javascript:void(0)" class="btn remove-medicine"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
                $durgSet .= '</tr>';

            }

        }
        else
        {
            $options .= '<option value="N/A">N/A</option>';
            foreach ($drugs as $key => $value)
            {
                $options .= '<option value="' . $key . '" >' . $value . '</option>';
            }
            $durgSet .= '<tr>';
            $durgSet .= '<td class="input-width-xlarge"> <select class="form-control ' . $propertyName . '" name="' . $propertyName . '[' . $episodeNumber . '][]">' . $options . '</select> </td>';
            $durgSet .= '<td class="input-width-xlarge"> <input class="form-control" type="text" name="' . $durationName . '[' . $episodeNumber . '][]"></td>';
            $durgSet .= '<td class="input-width-xlarge"> <input class="form-control" type="text" name="' . $doesName . '[' . $episodeNumber . '][]"></td>';
            $durgSet .= '<td>';
            $durgSet .= '<a href="javascript:void(0)" class="btn remove-medicine"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
            $durgSet .= '</tr>';
        }

        $durgSet .= '</tbody>';
        $durgSet .= '</table>';
        $durgSet .= '<div class="form-group"><a href="javascript:void(0);" data-source-medicineduration="' . $durationName . '[' . $episodeNumber . '][]" data-source-medicinedose="' . $doesName . '[' . $episodeNumber . '][]" data-source-medicinename="' . $propertyName . '[' . $episodeNumber . '][]" data-source-drug="' . $episodeNumber . '" class="pull-right save-button-shadow   btn  add-medicine btn-info"><i class="fa fa-plus" aria-hidden="true">&nbspAdd More</i></a></div><br/>';
        
        $input_names = '^'.$propertyName;

        $durgSet = str_replace('elements_id', $input_names, $durgSet);

        return $durgSet;

    }

    /**
     * create the form antibiotic group's set.
     *
     * @param  $properties type array of object
     * @param  $uniqueId type string
     * @param  $param_values type array
     * @param  $antibiotic type array
     * @return html antibiotic group's set
     */
    public static function createAntibioticset($properties, $uniqueId, $param_values, $antibiotic)
    {

        $propertyName = str_replace('[]', '', $properties->para_name);
        $durationName = $propertyName . 'duration';
        // $episodeNumber = isset(explode('-', $uniqueId) [2]) ? explode('-', $uniqueId) [2] : '';
        $episodeNumber = isset(explode('-', $uniqueId) [2]) ? explode('-', $uniqueId) [2] - 1 : '';

        $antibioticSet = '<table class="table antibiotic-module-depentancy add-more-antibiotic-' . $episodeNumber . '">';
        $antibioticSet .= '<thead>';
        $antibioticSet .= '<tr><th>Antibiotic <a href="javascript:void(0)" class="add_master_data" data-modal_header="Drugs & Iv Fluids" data-destination_elements="elements_id" data-option_value="id" data-option_text="generic_pharmacological_name" data-mas_table="mas_drugivfluid" data-type="antibiotic" data-drug_type="antibiotic">
                                <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Drugs & Iv Fluids"></i>
                            </a></th><th>Duration</th><th></th></tr>';
        $antibioticSet .= '</thead>';
        $antibioticSet .= '<tbody>';
        $options = '';

        $input_names = '';

        if (isset($param_values[$propertyName]) && count($param_values[$propertyName]) > 0)
        {
            foreach ($param_values[$propertyName] as $antibiotickey => $antibioticvalue)
            {
                $antibioticvalue = (array)$antibioticvalue;
                $options = '';
                $options .= '<option value="N/A">N/A</option>';
                foreach ($antibiotic as $key => $value)
                {

                    $selected = ($antibioticvalue[$propertyName] == $key) ? 'selected' : '';
                    $options .= '<option ' . $selected . ' value="' . $key . '" >' . $value . '</option>';
                }
                $antibioticSet .= '<tr>';
                $antibioticSet .= '<td class="input-width-xlarge"> <select class="form-control ' . $propertyName . '" name="' . $propertyName . '[' . $episodeNumber . ']['.$antibiotickey.']">' . $options . '</select> </td>';
                $antibioticSet .= '<td class="input-width-xlarge"> <input class="form-control" value="' . $antibioticvalue[$durationName] . '" type="text" name="' . $durationName . '[' . $episodeNumber . ']['.$antibiotickey.']"></td>';
                $antibioticSet .= '<td>';
                $antibioticSet .= '<a href="javascript:void(0)" class="btn remove-antibiotic"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
                $antibioticSet .= '</tr>';

            }

        }
        else
        {
            $options .= '<option value="N/A">N/A</option>';
            foreach ($antibiotic as $key => $value)
            {
                $options .= '<option value="' . $key . '" >' . $value . '</option>';
            }
            $antibioticSet .= '<tr>';
            $antibioticSet .= '<td class="input-width-xlarge"> <select class="form-control ' . $propertyName . '" name="' . $propertyName . '[' . $episodeNumber . '][]">' . $options . '</select> </td>';
            $antibioticSet .= '<td class="input-width-xlarge"> <input class="form-control" type="text" name="' . $durationName . '[' . $episodeNumber . '][]"></td>';
            $antibioticSet .= '<td>';
            $antibioticSet .= '<a href="javascript:void(0)" class="btn remove-antibiotic"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
            $antibioticSet .= '</tr>';
        }

        $antibioticSet .= '</tbody>';
        $antibioticSet .= '</table>';
        $antibioticSet .= '<div class="form-group"><a href="javascript:void(0)" data-antibioticduration="' . $durationName . '[' . $episodeNumber . '][]" data-antibioticname="' . $propertyName . '[' . $episodeNumber . '][]" data-antibioticid="' . $episodeNumber . '" class="pull-right save-button-shadow   btn  add-antibiotic btn-info"><i class="fa fa-plus" aria-hidden="true">&nbspAdd More</i></a></div><br/>';
        
        $input_names = '^'.$propertyName;

        $antibioticSet = str_replace('elements_id', $input_names, $antibioticSet);

        return $antibioticSet;

    }

    /**
     * This will return the published problem
     * based on the published id
     *
     * @param $published_id type integer
     * @return problem in array of object
     */
    public static function getProblemProperty($published_id)
    {

        return \DB::table('pd_published')->where('published_id', $published_id)->orderby('DateModified', 'desc')
            ->first();
    }

    /**
     * This will group the array for select
     * elements
     *
     * @param $option_values type json
     * @param $option_label  type json
     */
    public static function getGroupoption($option_values, $option_label)
    {
        $option_values = json_decode($option_values);
        $option_label = json_decode($option_label);
        $group_values = array();

        if (count($option_values) != 0 && count($option_label) != 0)
        {
            for ($i = 0;$i < count($option_values);$i++)
            {

                if (isset($option_label[$i]))
                {
                    $group_values[$option_values[$i]] = $option_label[$i];
                }

            }
        }

        return $group_values;

    }

    /**
     * This will return the published problem
     * based on the problem id
     *
     * @param $problem_id type integer
     * @return array of problem_name and problem_id with order by date of modified
     */
    public static function getProblem($problem_id)
    {

        return \DB::table('pd_published')->where('problem_id', $problem_id)->orderby('DateModified', 'desc')
            ->first();
    }

}

