<?php

namespace App\Http\Controllers\Quality;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Quality\QualityExportController;
use Excel;

class QualityExportController extends Controller
{
   /**
     * To define the file name 
     * @var $fileName
     */
     public $fileName = 'Quality Indicator';

    /**
     * To download file format
     * @var $fileFormat
     */
     public $fileFormat = 'xls';

    /**
     * To download source list 
     * @var $sourceList
     */
     public $sourceList =  array();
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {
        $this->setSourceList(ExportResource::EXPORT_LIST);
     }


    /**
     * To set the file name 
     * 
     * @param $fileName type string  default neonatal
     * @return string 
     */
    public function setFilename($fileName = 'neonatal')
    {

        return $this->fileName = $fileName;

    }
    
    /**
     * To get the file name 
     * 
     * @return string 
     */
    public function getFilename()
    {

        return $this->fileName;
    }

    /**
     * To set the source list
     * 
     * @param $sourceList type array 
     * @return array 
     */
    public function setSourceList($sourceList)
    {

        return $this->sourceList = $sourceList;

    }

    /**
     * To get the source list
     * 
     * @return array  
     */
    public function getSourceList()
    {

        return $this->sourceList;

    }

    /**
     * To Set The File Formate 
     * 
     * @param $fileFormat type string  default xls
     * @return string 
     */
    public function setFileformat($fileFormat = 'xls') 
    {

        return $this->fileFormat = $fileFormat;

    }

     /**
      * To get the file formate 
      * 
      * @return string 
      */
     public function getFilefomate()
     {

        return $this->fileFormat;
     }

    /**
     * write the data into excel file
     * 
     * @param $data type array 
     * @param $heading type array 
     * @return downloadable file 
     */
    public function exportFile($data, $heading)
    {

        Excel::create($this->getFilename(), function ($excel) use ($data, $heading) {
    
                    $excel->sheet('Excel sheet', function ($sheet) use ($data, $heading) {
                        
                               $sheet->fromArray($data, null, 'A1', false, false, false);
                               $sheet->prependRow(1, $heading);
                               $sheet->setOrientation('landscape');



                    });

       })->export($this->getFilefomate())->download();



    }

     /**
      * Formating value to format for excel
      *
      *@param $key  
      *@param $value
      */

     public function formatValues($key, $value)
     {
        $result = '';

            switch ($key) {
                case 'gestation':
                   $result  = (!is_null($value)) ? \QualityHelpers::decodeGestation($value) : $value;
                   break;
                case 'sepsis_in_mother_type':
                   $result  = (!is_null($value)) ? \QualityHelpers::decodeRiskfactors($value) : $value;
                   break;
                case 'dob':
                    $result = (!is_null($value)) ? date('d-m-Y',strtotime($value)) : $value;
                   break; 
                case 'tob':
                    $result = (!is_null($value)) ? date('h:i a',strtotime($value)) : $value;
                   break;  
                case 'indication_of_admission':
                    $result = (!is_null($value)) ? \QualityHelpers::decodeIndication($value) : $value;
                   break;  
                case 'surfactant_type':
                    $result = (!is_null($value)) ? \QualityHelpers::decodeSurfactant($value) : $value;
                   break;   
                case 'case_death':
                    $result = (!is_null($value)) ? \QualityHelpers::decodeDeathCase($value) : $value;
                                 
                   break;              
                default:
                  $result = $value;
                   break;
            }


        return $result;

     }
}
