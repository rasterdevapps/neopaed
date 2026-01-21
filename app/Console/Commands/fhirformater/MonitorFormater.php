<?php

namespace App\Console\Commands\fhirformater;

use Illuminate\Console\Command;

use App\Http\Controllers\fhirformate\MonitorFormatController;
use App\Http\Controllers\Fhir\ImportFhirController;

class MonitorFormater extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:monitorformater';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * The instance of FhirFormateController
     *
     * @var object
     */
    public $fhir_formate;

    /**
     * The instance of ImportFhirController.
     *
     * @var object
     */
    public $import_values;

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
        $this->fhir_formate  = new MonitorFormatController();
       // $this->import_values = new ImportFhirController();
        $this->fhir_formate->getformatfhir();
       // $this->import_values->creatensursesheet();
    }
}
