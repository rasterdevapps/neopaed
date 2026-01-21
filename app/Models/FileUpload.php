<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FileUpload extends Model 
{
	protected $table = 'file_upload';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	protected $fillable = ['visit_id', 'file_name', 'file_size', 'file_type', 'uploaded_by', 'uploaded_at', 'deleted_by', 'deleted_at', 'module_name'];

    public static function getList($visit_ids, $module_id) {

        $file_list = FileUpload::select('file_type', 'visit_id')
        ->whereIn('visit_id', $visit_ids)
        ->where('module_name', $module_id)
        ->where('deleted_by', 0)
        ->whereNotNull('file_type')
        ->get()
        ->groupBy('visit_id')
        ->map(function($value)
        {
            $result = [
                'Image' => $value->where('file_type', 'Image')->count(),
                'Document' => $value->where('file_type', 'Document')->count(),
                'pdf' => $value->where('file_type', 'pdf')->count(),
                'Excel' => $value->where('file_type', 'Excel')->count(),
                'Video' => $value->where('file_type', 'Video')->count(),
                'Audio' => $value->where('file_type', 'Audio')->count(),
            ];
            return array_filter($result);
        });

        return $file_list;

    }
}
