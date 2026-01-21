<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\prescriptionDetails;
use App\Http\Controllers\Errors\ErrorLogController;

class repeatPrescription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:prescription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recreation prescription';

    /**
     * Time zone type
     *
     * @var $time_zone
     */
    protected $time_zone;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->time_zone     = env('TIME_ZONE');
        $this->custom_error = new ErrorLogController();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $repeat_prescription = \DB::table('prescription_hdr')
            ->leftjoin('baby_admission', 'baby_admission.BabyId', 'prescription_hdr.baby_id')
            ->where('Status', 'Inpatient')
            ->whereNotNull('frequency')
            ->whereNull('terminate')
            ->get();

        foreach ($repeat_prescription as $key => $value) {
            
            $frequency_count = preg_replace('/[A-Za-z]/', '',$value->frequency);

            if ($frequency_count != '') {

                $start_date = \DB::table('prescription_dtl')
                ->select('event_time')
                ->where('pres_hdr_id', $value->id)
                ->orderBy('id','desc')
                ->first()
                ->event_time;

                $frequency_grap = 24 / $frequency_count;
                
                for ($i = 0; $i < $frequency_grap; $i++) {  

                    $prescribed_dtl['pres_hdr_id']     = $value->id;
                    $prescribed_dtl['day']             = null;
                    $prescribed_dtl['created_date']    = Carbon::now($this->time_zone);
                    $prescribed_dtl['created_user']    = 0;

                    $start_date = $prescribed_dtl['event_time'] = Carbon::createFromFormat('Y-m-d H:i:s', $start_date)->addHours($frequency_count);                        

                    $prescribed_dtl['pres_value'] = prescriptionDetails::create($prescribed_dtl)->id;

                    if (empty($value->oral_route)) {
                        prescriptionDetails::where('id', $prescribed_dtl['pres_value'])->update(['prescription_id' => 'OIVD'.$prescribed_dtl['pres_value'].round(microtime(true) * 1000)]);
                    } else {
                        prescriptionDetails::where('id', $prescribed_dtl['pres_value'])->update(['prescription_id' => 'ORAL'.$prescribed_dtl['pres_value'].round(microtime(true) * 1000)]);                    
                    }

                }

                $this->custom_error->infoLog('Prescription is executed successfully - Header Id:'.$value->id);

            }
                
        }        

        $this->custom_error->infoLog('Daily Prescription Successfully Generated.');

    }
}
