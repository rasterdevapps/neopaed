<?php
namespace App\Http\library;

use Illuminate\Support\Facades\DB;

/**
 * This Helper will support generate the forms dynamicaly  
 * This class has global access can access any where in the application 
 * better way of use is call by self method .
 *
 * @author Manikandan M
 */
class FormHelpers 
{
	/**
     * This will generate the form  header label.
     *
     * @param  $fieldsPropertice type array of object  
     * @param  $groupElement type string 
     * @return html label  tag
     */
	public static function generateHeader($fieldsPropertice, $groupElement) 
	{

		return '<label for="'.$fieldsPropertice->para_name.'" style="font-size:'.$fieldsPropertice->para_fontsize.'px !important" class="show-label">'.$fieldsPropertice->para_label.'</label>';
	}
    
    /**
     * This will generate the form  label.
     *
     * @param  $labelName type string 
     * @return html label  tag
     */
	public static function generateLabel($labelName) 
	{

	   return '<label for="'.$labelName.'" class="show-label">'.$labelName.'</label>';
	}

	/**
     * This will generate the form  textbox.
     *
     * @param  $fieldsPropertice type array of object  
     * @param  $groupElement type integer
     * @return  html text tag 
     */
	public static function generateTextcomponent($fieldsPropertice, $groupElement) 
	{

	  $textBox    = self::generateLabel($fieldsPropertice->para_label);
	  $textBox   .='<input name="'.$fieldsPropertice->para_name.'" value="'.@$fieldsPropertice->para_default.'" class="form-control show-input" placeholder ="'.$fieldsPropertice->para_placeholder.'" type="text">'; 
	  return $textBox;  

	}

    /**
     * This will generate the form  decimal box.
     *
     * @param  $fieldsPropertice type array of object  
     * @param  $groupElement type integer
     * @return  html decimalnumber tag 
     */
	public static function generateDecimalcomponent($fieldsPropertice, $groupElement) 
	{

	   $decimalBox  = self::generateLabel($fieldsPropertice->para_label);
	   $decimalBox .='<input name="'.$fieldsPropertice->para_name.'" value="'.@$fieldsPropertice->para_default.'" class="form-control show-input" placeholder ="'.$fieldsPropertice->para_placeholder.'" type="number">'; 
	   return $decimalBox;  

	}


	/**
    * This will generate the form  number box.
    *
    * @param  $fieldsPropertice type array of object 
    * @param  $groupElement type integer
    * @return  html decimalnumber tag 
    */
	public static function generateNumbercomponent($fieldsPropertice, $groupElement) 
	{

	   $numberBox  = self::generateLabel($fieldsPropertice->para_label);
	   $numberBox .='<input name="'.$fieldsPropertice->para_name.'" value="'.@$fieldsPropertice->para_default.'" class="form-control show-input" placeholder ="'.$fieldsPropertice->para_placeholder.'" type="number">'; 
	   return $numberBox;  

	}

	/**
    * This will generate the form  text area box.
    *
    * @param  $fieldsPropertice type array of object  
    * @param  $groupElement type integer    
    * @return  html decimalnumber tag 
    */
	public static function generateTextareacomponent($fieldsPropertice, $groupElement) 
	{
	   $textAreaBox  = self::generateLabel($fieldsPropertice->para_label);
	   $textAreaBox .='<textarea name="'.$fieldsPropertice->para_name.'" rows="'.$fieldsPropertice->para_row.'" cols="'.$fieldsPropertice->para_column.'" value="" class="form-control show-input">'.@$fieldsPropertice->para_default.'</textarea>'; 
	   return $textAreaBox;  

	}
    
    /**
    * This will generate the form  drop down box.
    *
    * @param  $fieldsPropertice type array of object 
    * @param  $groupElement type integer     
    * @return  html select tag 
    */
	public static function generateDropboxcomponent($fieldsPropertice, $groupElement) 
	{

	   $selectBox    = self::generateLabel($fieldsPropertice->para_label);
	   $optionName   = json_decode($fieldsPropertice->para_option_name);
	   $optionValues = json_decode($fieldsPropertice->para_option_value);


	    $selectBox  .= '<select name="'.$fieldsPropertice->para_name.'" class="form-control">';

	    for ($len=0; $len < count($optionName); $len++) { 

          if (isset($optionValues[$len])) {

	    	$values = ($fieldsPropertice->para_default == $optionValues[$len]) ? "selected" : "" ;
	        $selectBox .='<option '.$values.' value="'.$optionValues[$len].'">'.$optionName[$len].'</option>';

          }  

	    }

	   $selectBox  .= '</select>';
    
	   return $selectBox;  

	}

	/**
    * This will generate the form  toggle box.
    *
    * @param  $fieldsPropertice type array of object  
    * @param  $groupElement type integer         
    * @return  html toggle tag 
    */
    public static function generateToggleboxcomponent($fieldsPropertice, $groupElement) 
    {

       $toggleBox  =  self::generateLabel($fieldsPropertice->para_label);

       $values = ($fieldsPropertice->para_default == 'true') ? 'checked="true"' : '';

       $toggleBox .='<input id="'.$fieldsPropertice->para_name.'"  name="'.$fieldsPropertice->para_name.'" data-on="'.$fieldsPropertice->para_toggle_on.'" data-off="'.$fieldsPropertice->para_toggle_off.'" data-toggle="toggle" '.$values.' data-width="'.$fieldsPropertice->para_toggle_width.'" data-size="small" class="form-control" type="checkbox">';

       return $toggleBox;
    }

    /**
    *This will generate the form checkbox
    *
    * @param $fieldsPropertice type array of object 
    * @param  $groupElement type integer     
    * @return  html toggle tag 
    */
    public static function generateCheckboxcompnent($fieldsPropertice, $groupElement) 
    {

    	$checkbox  = self::generateLabel($fieldsPropertice->para_label);
    	$chkName   = json_decode($fieldsPropertice->para_chkop_name);
    	$chkVale   = json_decode($fieldsPropertice->para_chkop_value); 

    	$checkbox .='<div class="checkbox-group">';

        for ($i=0; $i < count($chkName)  ; $i++) { 
	        $checkbox .='<label class="radio-inline">';
	        $checkbox .='<input name="'.$fieldsPropertice->para_name.'[]" value="'.$chkVale[$i].'"  type="checkbox"> '.$chkName[$i] ;
	        $checkbox .='</label>';
          
        } 

    	$checkbox .='</div>';

    	return $checkbox;

    }

    /**
     *This will genrate the form radio
     *
     * @param  $fieldsPropertice type array of object 
     * @param  $groupElement type integer     
     * @return html radio box
     */
    public static function generateRadiocomponent($fieldsPropertice, $groupElement) 
    {
    	$radioBox  = self::generateLabel($fieldsPropertice->para_label);
        $rdName    = json_decode($fieldsPropertice->para_rdop_name); 
        $rdValue   = json_decode($fieldsPropertice->para_rdop_value);
      
        $radioBox .='<div class="radio-group">';
        for ($i=0; $i < count($rdName)  ; $i++) { 
        	$radioBox .='<label class="radio-inline">';
        	$radioBox .='<input name="'.$fieldsPropertice->para_name.'[]" value="'.$rdValue[$i].'"  type="radio"> '.$rdName[$i];
        	$radioBox .='</label>';
        }	
    	$radioBox .= '</div>';

    	return $radioBox;


    }

    /**
     *This will genrate the form selector 
     *
     * @param $fieldsPropertice type array of object 
     * @param  $groupElement type integer     
     * @return html selector
     */
    public static function generateHorizontalSelector($fieldsPropertice, $groupElement) 
    {

    	$horzontalopname   = json_decode($fieldsPropertice->hpara_option_name);
    	$horzontalopvalue  = json_decode($fieldsPropertice->hpara_option_value);
    	$HorizontalBox     =self::generateLabel($fieldsPropertice->para_label);
    	$HorizontalBox    .= "<select data-color='".$fieldsPropertice->hpara_option_color."' id='".$fieldsPropertice->para_name."' name='".$fieldsPropertice->para_name."' class='form-control'>";
    	
    	for ($i=0; $i <count($horzontalopname) ; $i++) { 
    		
    	 $values = ($fieldsPropertice->para_default == $horzontalopvalue[$i]) ? "selected" : "" ;
         $HorizontalBox .='<option '.$values.' value="'.$horzontalopvalue[$i].'">'.$horzontalopname[$i].'</option>';
    		
    	}

    	$HorizontalBox .= '<select>';
    	return $HorizontalBox;

    }

     /**
     * This will generate the form  form group.
     *
     * @param  $fieldTag type string contain html elements
     * @param  $hiddenParameter type string  contain html elements
     * @param  $groupId type string  
     * @param  $groupnumber type integer          
     * @return  html form group div tag 
     */
	public static function generateComponentgroup($fieldTag, $hiddenParameter, $groupId, $groupnumber)
	{
	   
	   return '<div draggable="true" data-param-number="'.$groupnumber.'" id="'.$groupId.'" class="form-group form-part"><span class="fa fa-remove remove-component pull-right"></span>'.$fieldTag.$hiddenParameter.'</div>';
	}


    public static function generateDrugset($fieldsPropertice, $groupElement, $drugs) 
    {
        $options   = '';
        $durgSet   = self::generateLabel($fieldsPropertice->para_label);
        $durgSet  .= '<div class="form-group">';
        $durgSet  .= '<table class="table drug-maseter-problem">';
        $durgSet  .= '<thead>';
        $durgSet  .= '<tr>';
        $durgSet  .= '<th><label>Drug</label></th>';
        $durgSet  .= '<th><label>Duration</label></th>';
        $durgSet  .= '<th><label>Dose</label></th>';
        $durgSet  .= '<th></th>';
        $durgSet  .= '</tr>';
        $durgSet  .= '</thead>';
        $durgSet  .= '</tbody>';
        $durgSet  .= '<tr>';

        foreach ($drugs as $key => $value) {
          $options .= '<option value="'.$key.'" >'.$value.'</option>';
        }

        $durgSet  .= '<td> <select class="form-control" name="'.$fieldsPropertice->para_name.'">'.$options.'</select> </td>';  
        $durgSet  .= '<td> <input class="form-control" type="text" name="'.str_replace('[]', '', $fieldsPropertice->para_name).'duration[]"></td>';  
        $durgSet  .= '<td> <input class="form-control" type="text" name="'.str_replace('[]', '', $fieldsPropertice->para_name).'does[]"></td>';  
        $durgSet  .= '<td>';
        $durgSet  .= '<a href="javascript:void(0)" class="btn remove-medicine"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
        $durgSet  .= '</tr>';
        $durgSet  .= '</tbody>';
        $durgSet  .= '</table>';
        $durgSet  .= '</div>';
 
       return $durgSet;
    }

    public static function generateAntiboiticset($fieldsPropertice, $groupElement, $antibiotic) 
    {
        $options   ='';
        $antibioticSet   = self::generateLabel($fieldsPropertice->para_label);
        $antibioticSet  .= '<div class="form-group">';
        $antibioticSet  .= '<table class="table drug-maseter-problem">';
        $antibioticSet  .= '<thead>';
        $antibioticSet  .= '<tr>';
        $antibioticSet  .= '<th><label>Antibiotic</label></th>';
        $antibioticSet  .= '<th><label>Duration</label></th>';
        $antibioticSet  .= '<th></th>';
        $antibioticSet  .= '</tr>';
        $antibioticSet  .= '</thead>';
        $antibioticSet  .= '</tbody>';
        $antibioticSet  .= '<tr>';

        foreach ($antibiotic as $key => $value) {
          $options .= '<option value="'.$key.'" >'.$value.'</option>';
        }

        $antibioticSet  .= '<td> <select class="form-control" name="'.$fieldsPropertice->para_name.'">'.$options.'</select> </td>';  
        $antibioticSet  .= '<td> <input class="form-control" type="text" name="'.str_replace('[]', '', $fieldsPropertice->para_name).'duration[]"></td>';  
        $antibioticSet  .= '<td>';
        $antibioticSet  .= '<a href="javascript:void(0)" class="btn remove-medicine"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
        $antibioticSet  .= '</tr>';
        $antibioticSet  .= '</tbody>';
        $antibioticSet  .='</table>';
        $antibioticSet  .= '</div>';
 
       return $antibioticSet;
    }

	 /**
     * This will add the hidden parameter for component.
     *
     * @param  $fieldsPropertice type array of object  
     * @param  $groupElement type integer          
     * @return  html hidden group 
     */
	public static function addhiddenFields($fieldsPropertice, $groupElement)
    {

        $parameters  = '<input type="hidden" name="para_name[]" value="'.$fieldsPropertice->para_name.'" id="para_name'.$groupElement.'">';
        $parameters .= '<input type="hidden" name="para_label[]" value="'.$fieldsPropertice->para_label.'" id="para_label'.$groupElement.'">';
        $parameters .= '<input type="hidden" name="para_type[]" value="'.$fieldsPropertice->para_type.'" id="para_type'.$groupElement.'">';
        $parameters .= '<input type="hidden" name="para_position[]" value="'.$fieldsPropertice->para_position.'" id="para_position'.$groupElement.'">';
        $parameters .= '<input type="hidden" name="para_order[]" value="'.@$fieldsPropertice->para_order.'" id="para_order'.$groupElement.'">';
        $parameters .= '<input type="hidden" name="para_default[]" value="'.@$fieldsPropertice->para_default.'" id="para_default'.$groupElement.'" >';

          switch ($fieldsPropertice->para_type) {

            case 'type-text':
             $fieldsPropertice->para_size = (isset($fieldsPropertice->para_size) && !empty($fieldsPropertice->para_size)) ? $fieldsPropertice->para_size : 'input-full-width';
             $parameters .= '<input type="hidden" name="para_placeholder[]" value="'.$fieldsPropertice->para_placeholder.'" id="para_placeholder'.$groupElement.'">';
             $parameters .= '<input type="hidden" name="para_required[]" value="'.@$fieldsPropertice->para_required.'" id="para_required'.$groupElement.'" >';
             $parameters .= '<input type="hidden" name="para_addmore[]" value="'.@$fieldsPropertice->para_addmore.'" id="para_addmore'.$groupElement.'" >';
             $parameters .= '<input type="hidden" name="para_discharge[]" value="'.@$fieldsPropertice->para_discharge.'" id="para_discharge'.$groupElement.'" >';

            break;

            case 'type-decimal':
             $fieldsPropertice->para_size = (isset($fieldsPropertice->para_size) && !empty($fieldsPropertice->para_size)) ? $fieldsPropertice->para_size : 'input-full-width';
             $parameters .= '<input type="hidden" name="para_placeholder[]" value="'.$fieldsPropertice->para_placeholder.'" id="para_placeholder'.$groupElement.'">';
             $parameters .= '<input type="hidden" name="para_min[]" value="'.@$fieldsPropertice->para_min.'" id="para_min'.$groupElement.'" >';
             $parameters .= '<input type="hidden" name="para_max[]" value="'.@$fieldsPropertice->para_max.'" id="para_max'.$groupElement.'" >';
             $parameters .= '<input type="hidden" name="para_required[]" value="'.@$fieldsPropertice->para_required.'" id="para_required'.$groupElement.'" >';
             $parameters .= '<input type="hidden" name="para_discharge[]" value="'.@$fieldsPropertice->para_discharge.'" id="para_discharge'.$groupElement.'" >';
             if (isset($fieldsPropertice->para_decimal_dependancy)) {
               $parameters .= '<input type="hidden" name="para_decimal_dependancy[]" value="'.urlencode($fieldsPropertice->para_decimal_dependancy).'" id="para_decimal_dependancy'.$groupElement.'">';    
             } else {
               $parameters .= '<input type="hidden" name="para_decimal_dependancy[]" id="para_decimal_dependancy'.$groupElement.'">';                    
             }
            break;

            case 'type-number':
             $fieldsPropertice->para_size = (isset($fieldsPropertice->para_size) && !empty($fieldsPropertice->para_size)) ? $fieldsPropertice->para_size : 'input-full-width';
             $parameters .= '<input type="hidden" name="para_placeholder[]" value="'.$fieldsPropertice->para_placeholder.'" id="para_placeholder'.$groupElement.'">';
             $parameters .= '<input type="hidden" name="para_min[]" value="'.@$fieldsPropertice->para_min.'" id="para_min'.$groupElement.'" >';
             $parameters .= '<input type="hidden" name="para_max[]" value="'.@$fieldsPropertice->para_max.'" id="para_max'.$groupElement.'" >';
             $parameters .= '<input type="hidden" name="para_required[]" value="'.@$fieldsPropertice->para_required.'" id="para_required'.$groupElement.'" >';
             $parameters .= '<input type="hidden" name="para_discharge[]" value="'.@$fieldsPropertice->para_discharge.'" id="para_discharge'.$groupElement.'" >';
             if (isset($fieldsPropertice->para_digit_dependancy)) {
               $parameters .= '<input type="hidden" name="para_digit_dependancy[]" value="'.urlencode($fieldsPropertice->para_digit_dependancy).'" id="para_digit_dependancy'.$groupElement.'">';    
             } else {
               $parameters .= '<input type="hidden" name="para_digit_dependancy[]" id="para_digit_dependancy'.$groupElement.'">';                    
             }
            break;

            case 'type-textarea':
             $parameters .= '<input type="hidden" name="para_row[]" value="'.$fieldsPropertice->para_row.'" id="para_row'.$groupElement.'">';
             $parameters .= '<input type="hidden" name="para_column[]" value="'.$fieldsPropertice->para_column.'" id="para_column'.$groupElement.'">';
             $parameters .= '<input type="hidden" name="para_required[]" value="'.@$fieldsPropertice->para_required.'" id="para_required'.$groupElement.'" >';
             $parameters .= '<input type="hidden" name="para_discharge[]" value="'.@$fieldsPropertice->para_discharge.'" id="para_discharge'.$groupElement.'" >';
            
            break;

            case 'type-select':
            //echo '<pre>';print_r($fieldsPropertice);exit;
             $parameters .= '<input type="hidden" name="para_option_name[]" value="'.urlencode($fieldsPropertice->para_option_name).'" id="para_option_name'.$groupElement.'">';
             $parameters .= '<input type="hidden" name="para_option_value[]" value="'.urlencode($fieldsPropertice->para_option_value).'" id="para_option_value'.$groupElement.'">'; 
             $parameters .= '<input type="hidden" name="para_addmore[]" value="'.@$fieldsPropertice->para_addmore.'" id="para_addmore'.$groupElement.'" >';
             $parameters .= '<input type="hidden" name="para_discharge[]" value="'.@$fieldsPropertice->para_discharge.'" id="para_discharge'.$groupElement.'" >';

            break;

            case 'type-toggle':
             $parameters .= '<input type="hidden" name="para_toggle_on[]" value="'.$fieldsPropertice->para_toggle_on.'" id="para_toggle_on'.$groupElement.'">';
             $parameters .= '<input type="hidden" name="para_toggle_off[]" value="'.$fieldsPropertice->para_toggle_off.'" id="para_toggle_off'.$groupElement.'">';  
             $parameters .= '<input type="hidden" name="para_toggle_width[]" value="'.$fieldsPropertice->para_toggle_width.'" id="para_toggle_width'.$groupElement.'">';    
             if (isset($fieldsPropertice->para_toggle_dependancy)) {
               $parameters .= '<input type="hidden" name="para_toggle_dependancy[]" value="'.urlencode($fieldsPropertice->para_toggle_dependancy).'" id="para_toggle_dependancy'.$groupElement.'">';    
             }
              $parameters .= '<input type="hidden" name="para_discharge[]" value="'.@$fieldsPropertice->para_discharge.'" id="para_discharge'.$groupElement.'" >';
            
            break;

            case 'type-check-box':
              $parameters .= '<input type="hidden" name="para_chkop_name[]" value="'.urlencode($fieldsPropertice->para_chkop_name).'" id="para_chkop_name'.$groupElement.'">';
              $parameters .= '<input type="hidden" name="para_chkop_value[]" value="'.urlencode($fieldsPropertice->para_chkop_value).'" id="para_chkop_value'.$groupElement.'">';   
              $parameters .= '<input type="hidden" name="para_discharge[]" value="'.@$fieldsPropertice->para_discharge.'" id="para_discharge'.$groupElement.'" >';

            break;

            case 'type-radio':
              $parameters .= '<input type="hidden" name="para_rdop_name[]" value="'.urlencode($fieldsPropertice->para_rdop_name).'" id="para_rdop_name'.$groupElement.'">';
              $parameters .= '<input type="hidden" name="para_rdop_value[]" value="'.urlencode($fieldsPropertice->para_rdop_value).'" id="para_rdop_value'.$groupElement.'">';  
              $parameters .= '<input type="hidden" name="para_discharge[]" value="'.@$fieldsPropertice->para_discharge.'" id="para_discharge'.$groupElement.'" >';
            
            break;

            case 'type-horizontal-selector':
               $parameters .= '<input type="hidden" name="hpara_option_name[]" value="'.urlencode($fieldsPropertice->hpara_option_name).'" id="hpara_option_name'.$groupElement.'">';
               $parameters .= '<input type="hidden" name="hpara_option_color[]" value="'.urlencode($fieldsPropertice->hpara_option_color).'" id="hpara_option_color'.$groupElement.'">';        
               $parameters .= '<input type="hidden" name="hpara_option_value[]" value="'.urlencode($fieldsPropertice->hpara_option_value).'" id="hpara_option_value'.$groupElement.'">';        
               $parameters .= '<input type="hidden" name="para_discharge[]" value="'.@$fieldsPropertice->para_discharge.'" id="para_discharge'.$groupElement.'" >';

            break;

            case 'type-label':
               $parameters .= '<input type="hidden" name="para_fontsize[]" value="'.@$fieldsPropertice->para_fontsize.'" id="para_fontsize'.$groupElement.'">';
               $parameters .= '<input type="hidden" name="para_discharge[]" value="'.@$fieldsPropertice->para_discharge.'" id="para_discharge'.$groupElement.'" >';

            break;

            case 'type-antibiotic':
                $parameters .= '<input type="hidden" name="para_discharge[]" value="'.@$fieldsPropertice->para_discharge.'" id="para_discharge'.$groupElement.'" >';
            break;

            case 'type-drugs':
                $parameters .= '<input type="hidden" name="para_discharge[]" value="'.@$fieldsPropertice->para_discharge.'" id="para_discharge'.$groupElement.'" >';
            break;
            default:

            break;
          }
      
        return $parameters;
    } 

   
     /**
     * This will genearate final component group.
     *
     * @param  $fieldsPropertice type array of object  
     * @param  $groupId type integer          
     * @return html entire component group 
     */
	public static function constructGroup($fieldsPropertice, $groupId, $drugs = array(), $antibiotic = array())
	{

	  if (!is_object($fieldsPropertice)) {

	    throw new \Exception("In Valid argument passed to form group");
	    
	  }



	     $groupElement = 'part'.$groupId;
	       switch ($fieldsPropertice->para_type) {

	       	    case 'type-label':
	       	        $label             = self::generateHeader($fieldsPropertice, $groupElement);
	       			$hiddenParameter    = self::addhiddenFields($fieldsPropertice, $groupId);
	                return  self::generateComponentgroup($label, $hiddenParameter, $groupElement, $groupId); 
	       	    break; 

	            case 'type-text':
	                $textBox            = self::generateTextcomponent($fieldsPropertice, $groupElement);
	                $hiddenParameter    = self::addhiddenFields($fieldsPropertice, $groupId);
	                return  self::generateComponentgroup($textBox, $hiddenParameter, $groupElement, $groupId); 
	            break;

	            case 'type-decimal':
	                $decimalBox         = self::generateDecimalcomponent($fieldsPropertice, $groupElement);
	                $hiddenParameter    = self::addhiddenFields($fieldsPropertice, $groupId);
	                return  self::generateComponentgroup($decimalBox, $hiddenParameter, $groupElement, $groupId); 
	            break;
 
	            case 'type-number':
	                $numberBox          = self::generateNumbercomponent($fieldsPropertice, $groupElement);
	                $hiddenParameter    = self::addhiddenFields($fieldsPropertice, $groupId);
	                return  self::generateComponentgroup($numberBox, $hiddenParameter, $groupElement, $groupId); 
	            break; 

	            case 'type-textarea':
	                $textAreaBox        = self::generateTextareacomponent($fieldsPropertice, $groupElement);
	                $hiddenParameter    = self::addhiddenFields($fieldsPropertice, $groupId);
	                return  self::generateComponentgroup($textAreaBox, $hiddenParameter, $groupElement, $groupId); 
	            break;  

	            case 'type-select':
	                $dropBox            = self::generateDropboxcomponent($fieldsPropertice, $groupElement); 
	                $hiddenParameter    = self::addhiddenFields($fieldsPropertice, $groupId);
	                return  self::generateComponentgroup($dropBox, $hiddenParameter, $groupElement, $groupId); 
	            break;

	            case 'type-toggle':
	            	$toggleBox          = self::generateToggleboxcomponent($fieldsPropertice, $groupElement); 
	                $hiddenParameter    = self::addhiddenFields($fieldsPropertice, $groupId);
	                return  self::generateComponentgroup($toggleBox, $hiddenParameter, $groupElement, $groupId); 

	            break; 
	            case 'type-check-box':
                    $checkbox           = self::generateCheckboxcompnent($fieldsPropertice, $groupElement);
                    $hiddenParameter    = self::addhiddenFields($fieldsPropertice, $groupId);
                    return  self::generateComponentgroup($checkbox, $hiddenParameter, $groupElement, $groupId); 	        	
	            break; 
	            case 'type-radio':
                    $radiobox           = self::generateRadiocomponent($fieldsPropertice, $groupElement);
                    $hiddenParameter    = self::addhiddenFields($fieldsPropertice, $groupId);
                    return  self::generateComponentgroup($radiobox, $hiddenParameter, $groupElement, $groupId); 	        	
	            break;
               
                case 'type-horizontal-selector':
               	    $horizontalbox      = self::generateHorizontalSelector($fieldsPropertice, $groupElement);
               	    $hiddenParameter    = self::addhiddenFields($fieldsPropertice, $groupId);
                    return  self::generateComponentgroup($horizontalbox, $hiddenParameter, $groupElement, $groupId); 	        	
                break;
                case 'type-drugs':
                    $drugbox            = self::generateDrugset($fieldsPropertice, $groupElement, $drugs);
                    $hiddenParameter    = self::addhiddenFields($fieldsPropertice, $groupId);
                    return  self::generateComponentgroup($drugbox, $hiddenParameter, $groupElement, $groupId);               
                break;
                case 'type-antibiotic':
                    $drugbox            = self::generateAntiboiticset($fieldsPropertice, $groupElement, $antibiotic);
                    $hiddenParameter    = self::addhiddenFields($fieldsPropertice, $groupId);
                    return  self::generateComponentgroup($drugbox, $hiddenParameter, $groupElement, $groupId);               
                break;


	           default:
	              
	            break;
	      }


	}

   /**
     * This will genearate input class group.
     *
     * @param  $id type string   
     * @return array || string 
     */
	public static function inputBoxSize($id = '')
	{
        $size = [ 'input-full-width'=>'auto',
                  'input-width-mini'=>'mini',
                  'input-width-small'=>'small',
                  'input-width-medium'=>'medium',
                  'input-width-large'=>'large',
                  'input-width-xlarge'=>'xlarge'];

        return  $size ;        
     
	}

	/**
     * The method will return headings.
     *
     * @param  $componentType type string   
     * @return  string 
     */
	public static function proertyHeadings($componentType) 
	{
		switch ($componentType) {

			case 'type-label':
			      $problemHead ='Label';
			break;

			case 'type-text':
			      $problemHead ='Single Line';
			break;

			case 'type-number':
			      $problemHead ='Digits';
			break;

			case 'type-decimal':
			      $problemHead ='Decimal';
			break;

			case 'type-textarea':
			      $problemHead ='Multiple Line';
			break;

			case 'type-select':
			      $problemHead ='Dropdown';
			break;

			case 'type-toggle':
			      $problemHead ='Toggle';
			break;

			case 'type-horizontal-selector':
			      $problemHead ='Horizontal Selector';
			break;

			case 'type-check-box':
			      $problemHead ='Checkbox';
			break;

			case 'type-radio':
			      $problemHead ='Radio';
			break;

            case 'type-drugs':
                  $problemHead ='Drugs Master Group';
            break;

            case 'type-antibiotic':
                  $problemHead ='Antibiotic Master Group';
            break;

			default:
				  $problemHead = 'Problem Fields';
			break;
		}

		return $problemHead;

	}






}	
