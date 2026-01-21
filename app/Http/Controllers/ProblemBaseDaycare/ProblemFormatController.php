<?php
namespace App\Http\Controllers\ProblemBaseDaycare;

use App\Http\Controllers\Controller;
use App\Models\Masters\DaycareProblemsPublished;

/**
 * methods to map the input values with problem master settings
 *
 * @author Manikandan M  
 */
class ProblemFormatController extends Controller
{
  
  /**
   * @var $problemFormat object
   */
   public $problemFormat;

   /**
   * @var $problemProperty array of object
   */
   public $problemProperty;

   /**
   * @var $problemSettings array of object
   */
   public $problemSettings;

   /**
   * @var $problemSettings array of object
   */
   public $problemPropertynames;

  /**
   * @var $problemSettings array
   */
   public $problemFormatresults;

   /**
   * @var $problemMedicineProperty array
   */
   public $problemMedicineProperty;


   
  /**
   * Initate required instance.
   *
   * @param $problemFormat instance App\Models\Masters\DaycareProblemsPublished  
   *
   * @return Initate required instance and values 
   */
   public function __construct(DaycareProblemsPublished $problemFormat) 
   {

      $this->problemFormat = $problemFormat;

   }   

   /**
   * create problem format.
   *
   * @param $problem_id int 
   *
   * @param $input array 
   *
   * @return array of problems set
   */
   public function ProblemFormate($problem_id, $input)
   {

        $temp_property = [];
       $this->SetProblemSettings($problem_id);

       foreach ($this->fieldsProperty as $value) {  


            if (isset($input[str_replace('[]', '', $value->para_name)])) {
              switch ($value->para_type) {
                case 'type-drugs':
                    $medicineName     = str_replace('[]', '', $value->para_name);
                    $medicineDuration = $medicineName.'duration';
                    $medicineDose     = $medicineName.'does';             
                    foreach ($input[$medicineName] as $episodenumber => $inputValue) {

                       foreach ($inputValue as $numberofvalues => $values) {
                         $episodeMedicine[$medicineName]     = $input[$medicineName][$episodenumber][$numberofvalues];
                         $episodeMedicine[$medicineDuration] = $input[$medicineDuration][$episodenumber][$numberofvalues];
                         $episodeMedicine[$medicineDose]     = $input[$medicineDose][$episodenumber][$numberofvalues];                
//                         $temp_property[$episodenumber-1][$medicineName][] = $episodeMedicine;
$temp_property[$episodenumber][$medicineName][] = $episodeMedicine;

                        }
                    }
                
                break;
                case 'type-antibiotic':
                
                    $antibioticName     = str_replace('[]', '', $value->para_name);
                    $antibioticDuration = $antibioticName.'duration';

                  foreach ($input[$antibioticName] as $episodenumber => $inputValue) {

                       foreach ($inputValue as $numberofvalues => $values) {

                          $episodeAntibiotic[$antibioticName]     = $input[$antibioticName][$episodenumber][$numberofvalues];
                          $episodeAntibiotic[$antibioticDuration] = $input[$antibioticDuration][$episodenumber][$numberofvalues];
//                          $temp_property[$episodenumber-1][$antibioticName][] = $episodeAntibiotic;
$temp_property[$episodenumber][$antibioticName][] = $episodeAntibiotic;

                        }

                    }
                
                break;
                case 'type-select':
                  if (isset($value->para_addmore) && $value->para_addmore == 1) {
                     foreach ($input[$value->para_name] as $episodenumber => $inputValue) {
//                        $temp_property[$episodenumber-1][$value->para_name] = $inputValue;
$temp_property[$episodenumber][$value->para_name] = $inputValue;
                      } 
                  } else {
                     $key = 0;
                     foreach ($input[$value->para_name] as $inputValue) {
                      $temp_property[$key][$value->para_name] = $this->ProblemPropertyMap($value->para_type, $inputValue);
                      $key++;
                     }
                  } 
                break;
                case 'type-check-box':
                 foreach ($input[$value->para_name] as $episodenumber => $inputValue) {

//                        $temp_property[$episodenumber-1][$value->para_name] = json_encode($inputValue);
$temp_property[$episodenumber][$value->para_name] = json_encode($inputValue);
                  } 
                break;
              
                default:
                    $key = 0;
                    foreach ($input[$value->para_name] as $inputVal => $inputValue) {
                        $temp_property[$inputVal][$value->para_name] = $this->ProblemPropertyMap($value->para_type, $inputValue);
                      $key++;
                    }
                break;
              }
            }  
        }


        if (isset($temp_property) && is_array($temp_property) && count($temp_property) > 0) {
       foreach ($temp_property as $temp_property_index => $property) {

          $keyValues  = array_keys($temp_property[$temp_property_index]);
          $tempValues = $this->fieldsProperty->whereNotIn('para_name', $keyValues)->whereNotIn('para_type', ['type-drugs','type-antibiotic']);

          if (count($tempValues) > 0) {

             foreach ($tempValues as $values) {

               $temp_property[$temp_property_index][$values->para_name] =  $this->EmptyProblemPropertyMap($values->para_type, ''); 
             }
          }
 
       }
   }

       $this->problemFormatresults = $temp_property;

     return  $this->problemFormatresults;

   }

   /**
    *fetch the problem settings from model and set to the variable
    *
    * @param $problem_id int 
    *
    * @return array  
    */
   public function SetProblemSettings($problem_id) 
   {
       $this->problemSettings = $this->problemFormat->GetRecord($problem_id);
       $this->InitiateProperties();


       return  $this->problemSettings;
   }

   /**
    *Initiate all the property methods
    *
    * @return array  
    */
   public function InitiateProperties() 
   {

      $this->SetProblemProperty();
      $this->SetProblemPropertyNames();

   }

   
   /**
    *set the problem property to the varibale
    *
    * @return array  
    */
   public function SetProblemProperty() 
   {

       $this->fieldsProperty  = collect(json_decode($this->problemSettings->problem_fields));  
       return  $this->fieldsProperty;

   }

   /**
    *set the problem property to the varibale
    *
    * @return array  
    */
   public function SetProblemPropertyNames() 
   {

       $this->problemPropertynames  = $this->fieldsProperty->pluck('para_name');  
       return  $this->problemPropertynames;

   }

   /**
    *To map the problem property with input values
    *
    * @param $propertyType string  
    *
    * @param $inputValue int or string or float
    *
    * @return array  
    */
   public function ProblemPropertyMap($propertyType, $inputValue) 
   {
      if (!empty($propertyType)) {

            switch ($propertyType) {
                case 'type-number':

                    return $inputValue;
                  
                break;
                case 'type-textarea':

                    return $inputValue;
                  
                break;
                case 'type-text':

                    return $inputValue;
                  
                break;
                case 'type-horizontal-selector':

                    return $inputValue;
                  
                break;
                case 'type-decimal':

                     return $inputValue;

                break;
                case 'type-toggle':
                     return ($inputValue=='on') ? true : false ;

                break;
                case 'type-select':

                     return $inputValue;

                break;
                case 'type-radio':

                     return $inputValue;

                break;
             
            }
      } else {
           throw new \Exception("Property type is not set in problem formate Controller", 1);
           
      }      

   }

   /**
    *To map the problem property with input values
    *
    * @param $propertyType string  
    *
    * @param $inputValue int or string or float
    *
    * @return array  
    */
   public function EmptyProblemPropertyMap($propertyType, $inputValue) 
   {

      if (!empty($propertyType)) {

            switch ($propertyType) {
                case 'type-number':

                    return $inputValue;
                  
                break;
                case 'type-textarea':

                    return $inputValue;
                  
                break;
                case 'type-text':

                    return $inputValue;
                  
                break;
                case 'type-horizontal-selector':

                    return $inputValue;
                  
                break;
                case 'type-decimal':

                     return $inputValue;

                break;
                case 'type-toggle':

                     return false ;

                break;
                case 'type-select':

                     return $inputValue;

                break;
                case 'type-radio':

                     return $inputValue;

                break;
             
            }
      } else {
           throw new \Exception("Property type is not set in problem formate Controller", 1);
           
      }      

   }




















    
}
