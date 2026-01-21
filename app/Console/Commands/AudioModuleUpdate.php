<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AudioModuleUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recorder:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the recorder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    
            $recorder_list = \DB::table('recorded_audio_history')
                                 ->whereNull('module_id')
                                 ->where('module_slug','OP_MODULE')
                                 ->get();
             foreach ($recorder_list as $recorder_key => $recorder_value) {


                $op_details = \DB::table('op_details')
                                  ->where('BabyId',$recorder_value->baby_id)
                                  ->where('OpDate',date('Y-m-d' ,strtotime($recorder_value->DateAdded)))
                                  ->where('IsDeleted', 0)
                                  ->first();

                    if (count($op_details) > 0) {
                            \DB::table('recorded_audio_history')
                                ->where('id',$recorder_value->id)
                                ->update(['module_id'=>$op_details->OpId]);

                    }

            }
    }
}
