<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Audio\Recorder;
use Zip;

class AudioZipFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:zipaudio';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'zip the audio file!';


    /**
     * The audio file path.
     *
     * @var string
     */
    protected $audio_base_path;

    /**
     * This set the audio zip file base path
     * 
     * @var $zip_base_path
     */
    public $zip_base_path;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->audio_base_path = \SiteHelpers::getAudioPath('AUDIO_FILE_PATH', 1);
        $this->zip_base_path   = \SiteHelpers::getAudioPath('AUDIO_ZIPPED_PATH', 2);

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

            $files = Recorder::select('baby_id')
                             ->whereNotNull('module_id')->get()
                             ->unique('baby_id')->pluck('baby_id')->toArray();

            foreach ($files as $files_key => $files_value) {

                $zip_files = Recorder::where('baby_id', $files_value)->where('file_opened', null)->get();


                if (count($zip_files) > 0) {

                    $baby_id   =  $zip_files->first()->baby_id;

                    $module_id =  $zip_files->first()->module_id;

                    $zip_name = $baby_id.'_'.$module_id.'.zip';

                    $zip = Zip::create($this->zip_base_path.$zip_name);

                    $files_list = $zip_files->pluck('audio_file')->toArray();

                    foreach ($files_list as $file_key => $file_value) {

                       $zip->add($this->audio_base_path.$file_value);
                       
                    }
                       
                    $zip->close();

                    Recorder::where(['baby_id'=>$baby_id, 'module_id'=>$module_id])
                            ->Update(['files_zipped'=>true]);

                    
                 } 

                    foreach ($files_list as $key => $value) {

                        \File::delete($this->audio_base_path.$value);
                                       
                    }                
                    
            }


            echo "zip audio file created !";
    }
}
