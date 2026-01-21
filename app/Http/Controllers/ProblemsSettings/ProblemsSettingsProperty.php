<?php

namespace App\Http\Controllers\ProblemsSettings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * methods to format the input components  
 *
 * @author Manikandan M  
 */
class ProblemsSettingsProperty extends Controller  
{

   /**
   *Declare the variable for input
   *
   *@var type array  $componentValues
   */
   public $componentValues;

   /**
   *Declare the variable for formated property 
   *
   *@var type array  $propertyValues
   */
   public $propertyValues;

   /**
    * Set the input components values  to this class property .
    *
    * @param  $componentValues type array 	
    * @return components values.
    */
   public function setPropertyList($componentValues) 
   {

   	return $this->componentValues = $componentValues;

   }

   /**
    * Set the components values based on the parameter.
    *
    * @param  $param_name type  string 	
    * @return $propertyValues .
    */
   public function setCommanProperty($param_name) 
   {

       foreach ($this->componentValues[$param_name] as $key => $value) {

             $this->propertyValues[$key][$param_name] = $value;
       
       }

   }

  /**
   * Set the single line text  parameter to the property values.
   *
   * @return $propertyValues 
   */
   public function setSinglelinetextBox()
   {
    
      $SinglelineTextbox    = collect($this->propertyValues)->whereIn('para_type', ['type-text'])->keys();


       for ($i=0; $i < count($SinglelineTextbox); $i++) { 
          $this->propertyValues[$SinglelineTextbox[$i]]['para_placeholder'] = $this->componentValues['para_placeholder'][$i];
          $this->propertyValues[$SinglelineTextbox[$i]]['para_required']    = $this->componentValues['para_required'][$i];
          $this->propertyValues[$SinglelineTextbox[$i]]['para_addmore']     = $this->componentValues['para_addmore'][$i];
          $this->propertyValues[$SinglelineTextbox[$i]]['para_discharge']   = isset($this->componentValues['para_discharge'][$SinglelineTextbox[$i]]) ? $this->componentValues['para_discharge'][$SinglelineTextbox[$i]] : 0;

 
       }
       
   }

  /**
   * Set the Digits parameter to the property values.
   *
   * @return $propertyValues 
   */
   public function setDigitsBox()
   {
    
      
       $DigitsBox    = collect($this->propertyValues)->whereIn('para_type', ['type-number'])->keys();

       for ($i=0; $i < count($DigitsBox); $i++) { 

          $this->propertyValues[$DigitsBox[$i]]['para_placeholder'] = $this->componentValues['para_placeholder'][$i];
          $this->propertyValues[$DigitsBox[$i]]['para_required']    = $this->componentValues['para_required'][$i];
          $this->propertyValues[$DigitsBox[$i]]['para_discharge']   = isset($this->componentValues['para_discharge'][$DigitsBox[$i]]) ? $this->componentValues['para_discharge'][$DigitsBox[$i]] : 0 ;

          if (isset($this->componentValues['para_digit_dependancy'][$i])) {
            $this->propertyValues[$DigitsBox[$i]]['para_digit_dependancy'] = urldecode($this->componentValues['para_digit_dependancy'][$i]);
          }

       }
       
   }

  /**
   * Set the Decimal parameter to the property values.
   *
   * @return $propertyValues 
   */
   public function setDecimalBox()
   {
    
      
       $DecimalBox    = collect($this->propertyValues)->whereIn('para_type', ['type-decimal'])->keys();

       for ($i=0; $i < count($DecimalBox); $i++) { 

          $this->propertyValues[$DecimalBox[$i]]['para_placeholder'] = $this->componentValues['para_placeholder'][$i];
          $this->propertyValues[$DecimalBox[$i]]['para_required']    = $this->componentValues['para_required'][$i];
          $this->propertyValues[$DecimalBox[$i]]['para_discharge']   = isset($this->componentValues['para_discharge'][$DecimalBox[$i]]) ? $this->componentValues['para_discharge'][$DecimalBox[$i]] : 0 ;
  
          if (isset($this->componentValues['para_decimal_dependancy'][$i])) {
            $this->propertyValues[$DecimalBox[$i]]['para_decimal_dependancy'] = urldecode($this->componentValues['para_decimal_dependancy'][$i]);
          }

       }
       
   }
   /**
    *set the decimal and digit box min max value 
    *
    */
   public function setMaxMIn() {
          $DigitsBox    = collect($this->propertyValues)->whereIn('para_type', ['type-number','type-decimal'])->keys();
          for ($i=0; $i < count($DigitsBox); $i++) { 
            $this->propertyValues[$DigitsBox[$i]]['para_min']         = $this->componentValues['para_min'][$i];
            $this->propertyValues[$DigitsBox[$i]]['para_max']         = $this->componentValues['para_max'][$i];
        }
   }


  /**
   * Set the muliple line parameter to the property values.
   *
   * @return $propertyValues 
   */
   public function setMultipletextBox()
   {

   	 $MultipletextBox    = collect($this->propertyValues)->where('para_type', 'type-textarea')->keys();

   	   for ($i=0; $i < count($MultipletextBox); $i++) { 

	   	   	$this->propertyValues[$MultipletextBox[$i]]['para_row']       = $this->componentValues['para_row'][$i];
	   	   	$this->propertyValues[$MultipletextBox[$i]]['para_column']    = $this->componentValues['para_column'][$i];
          $this->propertyValues[$MultipletextBox[$i]]['para_required']  = $this->componentValues['para_required'][$i];
          $this->propertyValues[$MultipletextBox[$i]]['para_discharge'] = isset($this->componentValues['para_discharge'][$MultipletextBox[$i]]) ? $this->componentValues['para_discharge'][$MultipletextBox[$i]] : 0;

   	   }

   }



   /**
    * Set the drop box parameter to the property values.
    *
    * @return $propertyValues 
    */
   public function setDropbox()
   {

   	  $Dropbox = collect($this->propertyValues)->whereIn('para_type', ['type-select'])->keys();

        for ($i=0; $i < count($Dropbox); $i++) { 

	   	   	$this->propertyValues[$Dropbox[$i]]['para_option_name']  = urldecode($this->componentValues['para_option_name'][$i]);
	   	   	$this->propertyValues[$Dropbox[$i]]['para_option_value'] = urldecode($this->componentValues['para_option_value'][$i]);
          $this->propertyValues[$Dropbox[$i]]['para_discharge']    = isset($this->componentValues['para_discharge'][$Dropbox[$i]]) ? $this->componentValues['para_discharge'][$Dropbox[$i]] : 0;

          if (isset($this->componentValues['para_option_type'][$i]) && $this->propertyValues[$Dropbox[$i]]['para_type'] == 'type-select') {
            $this->propertyValues[$Dropbox[$i]]['para_option_type'] = $this->componentValues['para_option_type'][$i];
          }
            $this->propertyValues[$Dropbox[$i]]['para_addmore']    =  $this->componentValues['para_addmore'][$i];

   	    }

   }


   /**
    * Set the drop box parameter to the property values.
    *
    * @return $propertyValues 
    */
   public function setHorizontalbox()
   {

      $Horizontalbox = collect($this->propertyValues)->whereIn('para_type', ['type-horizontal-selector'])->keys();

        for ($i=0; $i < count($Horizontalbox); $i++) { 

          $this->propertyValues[$Horizontalbox[$i]]['hpara_option_name']  = urldecode($this->componentValues['hpara_option_name'][$i]);
          $this->propertyValues[$Horizontalbox[$i]]['hpara_option_value'] = urldecode($this->componentValues['hpara_option_value'][$i]);
          $this->propertyValues[$Horizontalbox[$i]]['para_discharge']    = isset($this->componentValues['para_discharge'][$Horizontalbox[$i]]) ? $this->componentValues['para_discharge'][$Horizontalbox[$i]] : 0;
          
          if (isset($this->componentValues['hpara_option_color'][$i]) &&  $this->propertyValues[$Horizontalbox[$i]]['para_type'] == 'type-horizontal-selector') {
              $this->propertyValues[$Horizontalbox[$i]]['hpara_option_color'] = urldecode($this->componentValues['hpara_option_color'][$i]);
          }

        }
       
   }



   /**
    * Set the togglebox  parameter to the property values.
    *
    * @return $propertyValues 
    */
   public function setTogglebox() 
   {

   	 $toggleBox = collect($this->propertyValues)->whereIn('para_type', ['type-toggle'])->keys();
     
     for ($i=0; $i < count($toggleBox); $i++) { 

	   	   	$this->propertyValues[$toggleBox[$i]]['para_toggle_on']         = $this->componentValues['para_toggle_on'][$i];
	   	   	$this->propertyValues[$toggleBox[$i]]['para_toggle_off']        = $this->componentValues['para_toggle_off'][$i];
	   	   	$this->propertyValues[$toggleBox[$i]]['para_toggle_width']      = $this->componentValues['para_toggle_width'][$i];
          $this->propertyValues[$toggleBox[$i]]['para_discharge'] = isset($this->componentValues['para_discharge'][$toggleBox[$i]]) ? $this->componentValues['para_discharge'][$toggleBox[$i]] : 0;
         
          if (isset($this->componentValues['para_toggle_dependancy'][$i])) {
            $this->propertyValues[$toggleBox[$i]]['para_toggle_dependancy'] = urldecode($this->componentValues['para_toggle_dependancy'][$i]);
          } 
     }

   }

   /**
    * Set the checkbox  parameter to the property values.
    *
    * @return $propertyValues 
    */
   public function setCheckBox() 
   {
   	     $checkBox = collect($this->propertyValues)->whereIn('para_type', ['type-check-box'])->keys();
     
	     for ($i=0; $i < count($checkBox); $i++) { 

		   	$this->propertyValues[$checkBox[$i]]['para_chkop_name']    = urldecode($this->componentValues['para_chkop_name'][$i]);
		   	$this->propertyValues[$checkBox[$i]]['para_chkop_value']   = urldecode($this->componentValues['para_chkop_value'][$i]);
        $this->propertyValues[$checkBox[$i]]['para_discharge'] = isset($this->componentValues['para_discharge'][$checkBox[$i]]) ? $this->componentValues['para_discharge'][$checkBox[$i]] : 0;

	   	 }

   }

   /**
    * Set the radio box  parameter to the property values.
    *
    * @return $propertyValues 
    */
   public function setRadioBox() 
   {  

   	    $RadioBox = collect($this->propertyValues)->whereIn('para_type', ['type-radio'])->keys();
     
	    for ($i=0; $i < count($RadioBox); $i++) { 

		   	$this->propertyValues[$RadioBox[$i]]['para_rdop_name']    = urldecode($this->componentValues['para_rdop_name'][$i]);
		   	$this->propertyValues[$RadioBox[$i]]['para_rdop_value']   = urldecode($this->componentValues['para_rdop_value'][$i]);
        $this->propertyValues[$RadioBox[$i]]['para_discharge'] = isset($this->componentValues['para_discharge'][$RadioBox[$i]]) ? $this->componentValues['para_discharge'][$RadioBox[$i]] : 0;

	   	}

   }


    /**
    * Set the label box  parameter to the property values.
    *
    * @return $propertyValues 
    */
   public function setLabelBox() 
   {  

      $LabelBox = collect($this->propertyValues)->whereIn('para_type', ['type-label'])->keys();

      for ($i=0; $i < count($LabelBox); $i++) { 

        $this->propertyValues[$LabelBox[$i]]['para_fontsize']    = $this->componentValues['para_fontsize'][$i];
        $this->propertyValues[$LabelBox[$i]]['para_discharge']   = isset($this->componentValues['para_discharge'][$LabelBox[$i]]) ? $this->componentValues['para_discharge'][$LabelBox[$i]] : 0;


      }


   }
   
   /**
    * Set the drug master box  parameter to the property values.
    *
    * @return $propertyValues 
    */
   public function setDrugMasterGroup() 
   {

    $DrugMasterGroup = collect($this->propertyValues)->whereIn('para_type', ['type-drugs'])->keys();
     
      for ($i=0; $i < count($DrugMasterGroup); $i++) { 

        $this->propertyValues[$DrugMasterGroup[$i]]['para_discharge']    = isset($this->componentValues['para_discharge'][$DrugMasterGroup[$i]]) ? $this->componentValues['para_discharge'][$DrugMasterGroup[$i]] : 0;

      }

   }

   /**
    * Set the antibitic master box  parameter to the property values.
    *
    * @return $propertyValues 
    */
   public function setAntibioticGroup()
   {
     $AntibioticGroup = collect($this->propertyValues)->whereIn('para_type', ['type-antibiotic'])->keys();
     
      for ($i=0; $i < count($AntibioticGroup); $i++) { 

        $this->propertyValues[$AntibioticGroup[$i]]['para_discharge']    = isset($this->componentValues['para_discharge'][$AntibioticGroup[$i]]) ? $this->componentValues['para_discharge'][$AntibioticGroup[$i]] : 0;

     }
   }
    
    /**
    * return the entire grouped array .
    *
    * @return $propertyValues 
    */
   public function getPropertyList() 
   {
       	$this->setCommanProperty('para_name');
       	$this->setCommanProperty('para_label');
       	$this->setCommanProperty('para_type');
        $this->setCommanProperty('para_position');
        $this->setCommanProperty('para_order');
        $this->setCommanProperty('para_default');

        $this->setSinglelinetextBox();
        $this->setDigitsBox();
        $this->setDecimalBox();
        $this->setMaxMIn();
        $this->setMultipletextBox();
        $this->setDropbox();
        $this->setHorizontalbox();
        $this->setTogglebox();
        $this->setCheckBox();
        $this->setRadioBox();
        $this->setLabelBox();
        $this->setDrugMasterGroup();
        $this->setAntibioticGroup();



      return $this->propertyValues;
 

   }	


   	
}
