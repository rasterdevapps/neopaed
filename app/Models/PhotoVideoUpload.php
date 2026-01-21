<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoVideoUpload extends Model
{
    protected $table = 'photo_video_upload';
	protected $primaryKey = 'Id';
	public $timestamps  =  false;
	protected $fillable = ['BMrNo','UploadType','Photo','Video','created_at','update_at', 'description'];

	/**
     * This Method To Get uploaded files
     * 
     * @return uploaded files in array of object 
     */
	public static function get_lists() {
		$results = \DB::table('photo_video_upload')
						->leftjoin('baby','baby.BMrNo','photo_video_upload.BMrNo')
			            ->select('photo_video_upload.*','baby.BabyName')
			            ->orderBy('Id', 'desc')
			            ->get();		
		return $results;
	}
}
