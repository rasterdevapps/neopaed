<?php

namespace App\Http\Controllers\Excel;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Excel;

/**
 * This cotanins the method to extract the data 
 * data to spreed sheet 
 *
 *@author Manikandan M
 */

class ExportExcelController extends Controller
{

    /**
     * To define the file name 
     * @var $fileName
     */
     public $fileName = 'neonatal';

    /**
     * To download file format
     * @var $fileFormat
     */
     public $fileFormat = 'xls';


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


}
