<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reports\OpReport;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Excel;
use App\Exceptions\InvalidInputException;


class MonthlyReportGenearater extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Monthly Reports';

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
          $input['StartDate'] = $endDate   =  Carbon::now();
          $input['EndDate'] = $startDate =  $endDate->startOfMonth();
          $results = OpReport::get_lists($input);

          $heading = isset($results[0]) ? collect($results[0])->keys()->toArray(): array() ;
          $data = array();
          foreach ($results as $key => $value) {
              $temp   = array_values((array)$results[$key]);
              $data[] = $temp;

          }
          

          if (count($heading) > 0 && count($data) > 0) {

              Excel::create('opreport'.strtotime(Carbon::now()), function ($excel) use ($data,$heading) {
            
                            $excel->sheet('Excel sheet', function ($sheet) use ($data,$heading) {

                                       $sheet->fromArray($data, null, 'A1', false, false, false);
                                       $sheet->prependRow(1, $heading);
                                       $sheet->setOrientation('landscape');



                            });

               })->store('xls', storage_path('reports'));

            return  $this->comment(PHP_EOL.'Please find the excel on storage/reports folder '.PHP_EOL);  

          } else {

             throw new InvalidInputException("Invalid input on report generate artisan command", 1);
             
          } 
         

    }
}
