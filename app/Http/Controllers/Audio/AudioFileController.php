<?php

namespace App\Http\Controllers\Audio;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GoogleApis\GoogleSpeechApiController;
use App\Models\Audio\Recorder;
use Carbon\Carbon;
use App\Models\Baby;
use Zip;
/**
 * This controller for create audio  
 * file for speech to text 
 *
 */
class AudioFileController extends Controller
{   
    /**
     * This for auth instance 
     * 
     * @var $auth 
     */
     public $auth;

    /**
     * This set file name
     * 
     * @var $filename 
     */
     public $filename;

    /**
     * This set google api instance 
     * 
     * @var $filename 
     */
     public $googleApi;

    /**
     * This set the audio file base path
     * 
     *@var $audio_base_path
     */
    public $audio_base_path;

    /**
     * This set the audio zip file base path
     * 
     * @var $zip_base_path
     */
    public $zip_base_path;


    /** 
     * class constructor 
     * 
     * @param $auth Guard instance
     *
     */
	public function __construct(Guard $auth, GoogleSpeechApiController $googleApi)
	{
		$this->auth            = $auth;
		$this->filename        = $this->getfilename();
        $this->googleApi       = $googleApi;
        $this->audio_base_path = \SiteHelpers::getAudioPath('AUDIO_FILE_PATH', 1);
        $this->zip_base_path   = \SiteHelpers::getAudioPath('AUDIO_ZIPPED_PATH', 2);
	}

    /**
     * This method to get list view
     *  
     * @param $request Request instance
     *
     * @return response object to view
     */
    public function index(Request $request)
    {


        //scandir(pucn)
        $input   = $request->all();
        $limit   = 50;

        if (!empty($request->input('limit'))) {

            $request->session()->put('limit', $request->input('limit'));
            $limit = $request->session()->get('limit');

        } elseif ($request->session()->has('limit')) {

            $limit = $request->session()->get('limit');

        }

        $order = array();

        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {
          $order['sortby']     = \SiteHelpers::decrypt_id($request->input('sortby'));
          $order['sortorder']  = $request->input('sortorder');
        }    

        $search = array();
        $search['search_txt'] = '';

        if (!empty($request->input('search_txt'))) {
            $search['search_txt'] = $request->input('search_txt');
        }

        $search               = isset($input['search_txt']) ? $input['search_txt'] : ''; 
        $pagination['limits'] = $limit;
        $results              =  Recorder::getlist($request->input('page'), $limit, $search, $order);

        $total = Recorder::GetTotal();
        $page  = !empty($request->input('page')) ? $request->input('page') : 1;
        $pagecount = ceil($total / $limit);

        $pagination['total']    = $total;
        $pagination['start']    = (($page - 2) < 1) ? 1 : ($page - 2);
        $pagination['end']      = ($pagecount < ($page + 3)) ? $pagecount : ($page + 3);
        $pagestart              = ($page <= 1) ? $page : ($page-1)*$limit;
        $pagination['limit']    = array($pagestart, $page * $limit);
        $pagination['limits']   = $limit;
        $pagination['previous'] = (($page - 1) < 1) ? 1 : ($page - 1);
        $pagination['next']     = ($pagecount < ($page + 1)) ? $pagecount : ($page + 1);


        $navigate['main_nav']   = 'audio_logs';
        $navigate['sub_nav']    = 'audio_logs';



       return view('audio.view', compact('results', 'pagination', 'navigate'));



    }

    /**
     * This method get module  details
     *
     * @param $baby_id type integer
     *
     *  @return response object to view
     */
    public function getModuleList($baby_id)
    {

        $rest = \SiteHelpers::remove_unziped_files($this->auth->user()->id);


        $results      = Recorder::getmodulelist($baby_id);
        $baby_details = Baby::find($baby_id);

        $navigate['main_nav'] = 'audio_logs';
        $navigate['sub_nav']  = 'audio_logs';

        $seprator   = !empty($baby_details->BMrNo) ? '-': ''; 
        $baby_name  = $baby_details->BabyName.$seprator.$baby_details->BMrNo; 
        $module_id_group = $results->unique('module_id')->pluck('module_id')->toArray();

        if (count(Recorder::getcompressstatus($baby_id)) > 0) {
            Recorder::where('baby_id', $baby_id)->update(['file_opened'=>true, 'file_opened_by'=>$this->auth->user()->id]);

        
            foreach ($module_id_group as $module_id) {

                $file_name = $baby_id.'_'.$module_id.'.zip';

                if (file_exists($this->zip_base_path.$file_name)) {

                    $zip = Zip::open($this->zip_base_path.$file_name);
                    $zip->extract($this->audio_base_path);

                }

            }
        }   

       return view('audio.module_list', compact('results', 'navigate', 'baby_name'));

       
    }

	/**
	 * This method to create audio file 
	 *
     * @param $baby_id integer
	 *
     * @param $module_id integer
     *
     * @param $admission_id integer
     *
     * @param $field_id integer
     *
     * @param $module_slug string
     *
     * @param $request Request instance
     *
     * @return Response json
	 */
	public function createaudio($baby_id , $module_id, $admission_id, $field_id, $module_slug, Request $request)
	{
		    $file     = $request->file('file');


	    if ($file) {

            $file->move(public_path('audio'), $this->filename);
            $audio_details['baby_id']          =  $baby_id;
            $audio_details['module_id']        =  is_string($module_id) ? null : $module_id;
            $audio_details['admission_id']     =  is_string($admission_id) ? null : $admission_id;
            $audio_details['audio_file']       =  $this->filename;
            $audio_details['audio_file_name']  =  $this->filename;
            $audio_details['field_id']         =  $field_id;
            $audio_details['module_slug']      =  $module_slug;
            $audio_details['UserAdded']        =  $this->auth->user()->id;
            $audio_details['DateAdded']        =  Carbon::now(env('TIME_ZONE'));

            $id = Recorder::create($audio_details)->id;
            $converted_text = 'with out google';

            $rate = $this->getAudiodetails($this->audio_base_path.$this->filename);

           // $converted_text = $this->googleApi->index($this->audio_base_path.$this->filename, $rate);

            //echo '<pre>';print_r($converted_text);exit;

            Recorder::where(['id'=>$id])->update(['converted_text'=>$converted_text]);

            return \Response::json(['message'=>$converted_text], 200);

        } else {

            return \Response::json(['message'=>'Audio Is Not Clear !'], 500);

        }

	     

	}

    /**
     * This method to get audio details
     *
     * @param $path string
     *
     * @return array
     */
     private function getAudiodetails($path)
     {

       $file_open  = $resource = $data = $format = $bit = $chn ="0"; 

       $file_open = fopen($path, 'r'); 
             
             fseek($file_open, 20);
                  
        $resource = fread($file_open, 18);

        $data = unpack('vfmt/vch/Vsr/Vdr/vbs/vbis/vext', $resource); 

        $format = array(0x0001 => 'PCM',0x0003 => 'IEEE Float',0x0006 => 'A-LAW',0x0007 => 'MuLAW',0xFFFE => 'Extensible',);
               
        $bit = rtrim($data['sr'],"0") * rtrim($data['dr'],"0");  

        $chn = ($data['ch'] = 1) ? "Mono" : "Stereo"; 
        
        fclose($file_open); 

        return $data['sr'];

       // return  "{$format[$data['fmt']]} {$data['sr']} Hz {$bit} bit {$chn}";
     }

    /**
     * This method create opfilename
     *
     */
     private function getfilename()
     {

        $fileName = rand().'.wav';

        if (file_exists($this->audio_base_path.$fileName)) {
            $this->getfilename();
        }
        return $fileName;

     }


   
}
