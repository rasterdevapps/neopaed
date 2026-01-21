<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUpload;
use Illuminate\Contracts\Auth\Guard;
use Carbon\Carbon;

class DocumentsUploadController extends Controller
{
    public function __construct(Guard $auth)
    {

        $this->auth = $auth;
        $this->time_zone = env('TIME_ZONE');
        $this->folders = ['', 'neonatal_op', 'nurse_sheet', 'nicu_admission', 'nicu_daycare', 'nicu_discharge', 'neuro_op', 'pediatric_admission'];
        $this->file_path = 'http://' . $_SERVER['HTTP_HOST'] . '/' . explode('/', $_SERVER['PHP_SELF'])[1] . '/public/img';

    }

    public function upload(Request $request)
    {

        $input = $request->all();
        $visit_id = $input['visit_id'];
        $module_name = $input['module_name'];
        $base_path = public_path('img/' . $this->folders[$module_name] . '/upload');
        $current_path = $base_path . '/' . $visit_id;

        if (isset($input['file'])) {
            $file_name = $input['file']->getClientOriginalName();

            $file_exe = pathinfo($file_name, PATHINFO_EXTENSION);

            if ($file_exe == 'jpg' || $file_exe == 'jpeg' || $file_exe == 'png' || $file_exe == 'svg') {
                $file_type = 'Image';
            } else if ($file_exe == 'doc' || $file_exe == 'docx') {
                $file_type = 'Document';
            } else if ($file_exe == 'pdf') {
                $file_type = 'pdf';
            } else if ($file_exe == 'xls' || $file_exe == 'xlsx' || $file_exe == 'csv') {
                $file_type = 'Excel';
            } else if ($file_exe == 'mp4' || $file_exe == 'wmv' || $file_exe == 'avi' || $file_exe == 'mkv' || $file_exe == 'webm' || $file_exe == 'mpg' || $file_exe == 'mpeg' || $file_exe == 'mov') {
                $file_type = 'Video';
            } else if ($file_exe == 'mp3' || $file_exe == 'wav') {
                $file_type = 'Audio';
            } else {
                $file_type = null;
            }

            $input['file']->move($current_path, $file_name);

            $destination_path = $current_path . '/' . $file_name;

            $file_size = filesize($destination_path);

            $is_exist = FileUpload::where('visit_id', $visit_id)->where('file_name', $file_name)->where('file_size', $file_size)->where('deleted_by', 0)->orderby('id', 'desc')->first();

            if (!isset($is_exist->id)) {
                $upload['visit_id'] = $visit_id;
                $upload['file_name'] = $file_name;
                $upload['file_size'] = $file_size;
                $upload['file_type'] = $file_type;
                $upload['module_name'] = $module_name;
                $upload['uploaded_by'] = $this->auth->user()->id;
                $upload['uploaded_at'] = Carbon::now($this->time_zone);

                FileUpload::create($upload);
            } else {
                $upload['file_name'] = $file_name;
                $upload['file_size'] = $file_size;
                $upload['file_type'] = $file_type;
                $upload['uploaded_by'] = $this->auth->user()->id;
                $upload['uploaded_at'] = Carbon::now($this->time_zone);
                FileUpload::where('id', $is_exist->id)->update($upload);
            }

            return response()->json(['uploaded' => $destination_path]);
        }
        return response()->json(['type' => 'error', 'message' => 'Unsupported file']);
    }

    public function deleteuploads(Request $request)
    {
        $input = $request->all();
        $visit_id = $input['visit_id'];
        $file_name = $input['file_name'];
        $module_name = $input['module_name'];

        $old_base_path = public_path('img/' . $this->folders[$module_name] . '/upload') . '/' . $visit_id;

        $old_file_location = $old_base_path . '/' . $file_name;

        $base_path = public_path('img/' . $this->folders[$module_name] . '/delete');

        if (!\File::isDirectory($base_path)) {
            \File::makeDirectory($base_path);
        }

        $base_path = $base_path . '/' . $visit_id;

        $destination_path = $base_path . '/' . $file_name;

        if (!\File::isDirectory($base_path)) {
            \File::makeDirectory($base_path);
        }

        $delete['deleted_by'] = $this->auth->user()->id;
        $delete['deleted_at'] = Carbon::now($this->time_zone);

        FileUpload::where('visit_id', $visit_id)->where('file_name', $file_name)->where('module_name', $module_name)->update($delete);

        \File::move($old_file_location, $destination_path);

        return response()->json(['deleted' => $destination_path]);
    }

    public function getUploadedFile(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $module_name = $input['module_name'];
        $attachment_type = $input['attachment_type'];

        $base_file_path = $this->file_path . '/' . $this->folders[$module_name] . '/upload';
        $file_path = $base_file_path . '/' . $id . '/';

        $file_results = FileUpload::select(\DB::raw("CONCAT('" . $file_path . "',file_name) AS file_path"), 'file_name', 'file_size')
            ->where('module_name', $module_name)
            ->where('visit_id', $id)
            ->where('deleted_by', 0);
        $file_count = $file_results->count();

        if ($attachment_type != 'All') {
            $file_results = $file_results->where('file_type', $attachment_type);
        }

        $files = $file_results->orderby('id', 'asc')->get();

        $file_list = $files->pluck('file_path')->toArray();
        $file_name = $files->pluck('file_name')->toArray();
        $file_size = $files->pluck('file_size', 'file_name')->toArray();

        $file_list = json_encode($file_list);
        $file_name = json_encode($file_name);
        $file_size = json_encode($file_size);


        // $path = public_path('/img/neonatal_op/upload/1081');
        // $original_path = public_path('/img/neonatal_op/upload/1081/new-result.pdf');

        // if (!\File::isDirectory($path)) {
        //     \File::makeDirectory($path);
        // }
        // \PDF::loadHTML($response)->setOptions(['tempDir' => public_path() , 'chroot' => public_path() , ])
        //     ->save($path . '/NICU_Discharge_Summary.pdf');

        // $path = public_path() . "/NICU_Discharge_Summary";
        //        if (!file_exists($path))
        //        {
        //            mkdir($path, 0777, true);
        //        }
        //        \PDF::loadFile(public_path() .  '/myGeneratefile.doc')->setOptions(['tempDir' => public_path() , 'chroot' => public_path() , ])
        //            ->save($path . '/NICU_Discharge_Summary.pdf');
// $fileContent = file_get_contents($original_path . '/Case_load_for_FNB.docx') ;
// echo '<pre>';print_r($fileContent);exit;
//  \PDF::loadFile($fileContent)->render()->stream("sample.pdf");
        // ->setOptions(['tempDir' => $original_path  , 'chroot' => $original_path  , ])
        // ->save($original_path . '/Case_load_for_FNB.pdf');


        //     /* Set the PDF Engine Renderer Path */
//         $domPdfPath = base_path('vendor/dompdf/dompdf');
//         \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
//         \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        //         //Load word file
//         $Content = \PhpOffice\PhpWord\IOFactory::load($path); 

        //         //Save it into PDF
//         $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content,'PDF');
//         $PDFWriter->save($original_path); 
//         echo 'File has been successfully converted';

        // echo '<pre>';print_r('hi!');exit;

        return \Response::json(['file_list' => $file_list, 'file_name' => $file_name, 'file_size' => $file_size, 'base_file_path' => $file_path, 'file_count' => $file_count], 200);
    }
}
