<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Baby;
use Response;
use App\Models\PhotoVideoUpload;
use Carbon\Carbon;

class PhotoVideoUploadController extends Controller
{
    /**
     * Time zone type 
     *  
     * @var $time_zone
     */
     protected $time_zone;
    function __construct()
    {
        $this->path        = base_path();
        $this->folder_name = basename($this->path);
        $this->photo_path  = 'public/upload/photo/';
        $this->video_path  = 'public/upload/video/';
        $this->time_zone   = env('TIME_ZONE');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $uploads = PhotoVideoUpload::get_lists()->unique('BMrNo');
        return view('photo_video_upload.list',compact('uploads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $babymrno = Baby::ListData()->pluck('BMrNo','BMrNo')->toArray();
        return view('photo_video_upload.create', compact('babymrno'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $createdPhoto = $createdVideo = '';

        if ($input['uploadtype'] == 'photo') {

            $photos = glob(base_path().'/public/temp/photo/'.$input['babymrno'].'/*');

            foreach ($photos as $photo) {
                if (is_file($photo)) {
                    $temp_photo = $photo;
                }
            }

            $photo_path = base_path().'/public/upload/photo/'.$input['babymrno'].'/';

            if (!is_dir($photo_path)) {
                mkdir($photo_path, 0777, true);
            }

            $createdPhoto = strtotime("now");

            copy($temp_photo, $photo_path.$createdPhoto);

            unlink($temp_photo);


        } elseif ($input['uploadtype'] == 'video') {

          $videos = glob(base_path().'/public/temp/video/'.$input['babymrno'].'/*');

            foreach ($videos as $video) {
                if (is_file($video)) {
                    $temp_video = $video;
                }
            }

            $video_path = base_path().'/public/upload/video/'.$input['babymrno'].'/';

            if (!is_dir($video_path)) {
                mkdir($video_path, 0777, true);
            }             

            $createdVideo = strtotime("now");

            copy($temp_video, $video_path.$createdVideo);  

            unlink($temp_video);
            
        }  

        if (empty($input['photo']))  {
            $input['photo'] = '';
        } 
        if (empty($input['video'])) {
            $input['video'] = '';            
        }

        $uploadval = array(
            'BMrNo' => $input['babymrno'],
            'UploadType' => $input['uploadtype'],
            'Photo' => $createdPhoto,
            'Video' => $createdVideo,
            'created_at' => Carbon::now($this->time_zone),
            'description' => $input['description']
        );

        $upload = PhotoVideoUpload::create($uploadval)->Id;

        return redirect(action('PhotoVideoUploadController@edit',$upload));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $upload = PhotoVideoUpload::find($id);
        $photo_path = $this->photo_path;
        $video_path = $this->video_path;
        $folder_name = $this->folder_name;
        $babymrno = Baby::ListData()->pluck('BMrNo','BMrNo')->toArray();

        return view('photo_video_upload.edit',compact('babymrno','upload','photo_path','video_path','img_path','folder_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Upload a newly created photo in storage path.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadPhoto(Request $request)
    {      
        $input = $request->all();

        $photos = glob(base_path().'/public/temp/photo/'.$input['babymrno'].'/*');
        foreach ($photos as $photo) {
            if (is_file($photo)) {
                unlink($photo);
            }
        }

        $photo = $request->file('photo');

        if (file_exists($photo)) {

            $temp_photo_path = base_path()."/public/temp/photo/".$input['babymrno'];

            if (!is_dir($temp_photo_path)) {
                mkdir($temp_photo_path, 0777, true);
            }
          
            $photo->move($temp_photo_path);

            $info = 'Success';
        } else {
            $info = 'Failed';            
        }

        $photoname = $request->file('photo')->getClientOriginalName();

        return Response::json(['photoname' => $photoname, 'info' => $info]);
    }

    /**
     * Upload a newly created video in storage path.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadVideo(Request $request)
    {      
        $input = $request->all();

        $videos = glob(base_path().'/public/temp/video/'.$input['babymrno'].'/*');
        foreach ($videos as $video) {
            if (is_file($video)) {
                unlink($video);
            }
        }

        $video = $request->file('video');

        if (file_exists($video)) {

            $temp_video_path = base_path()."/public/temp/video/".$input['babymrno'];

            if (!is_dir($temp_video_path)) {
                mkdir($temp_video_path, 0777, true);
            }
          
            $video->move($temp_video_path);

            $info = 'Success';
        } else {
            $info = 'Failed';            
        }

        $videoname = $request->file('video')->getClientOriginalName();

        return Response::json(['videoname' => $videoname, 'info' => $info]);
    }

    /**
     * Delete a photo in storage path.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deletePhoto(Request $request) {

      $input = $request->all();

      $photoDelete = PhotoVideoUpload::find($input['id']);

      $photoDelete->delete();

      unlink($this->path.'/'.$input['photo']);

      return redirect(action('PhotoVideoUploadController@index'))->with('Success', 'Record deleted successfully!');

    }


    /**
     * Delete a video in storage path.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteVideo(Request $request) {

      $input = $request->all();

      $photoDelete = PhotoVideoUpload::find($input['id']);

      $photoDelete->delete();

      unlink($this->path.'/'.$input['video']);

      return redirect(action('PhotoVideoUploadController@index'))->with('Success', 'Record deleted successfully!');
      
    }
}
