<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Controllers\Fhir\FhirFormateController;
use App\Http\Controllers\Fhir\ImportFhirController;
use App\Http\Controllers\Fhir\LabFhirFormateController;
use App\Http\Controllers\Lab\LabRequestController;
use App\Http\Controllers\Fhir\FhirBackUpController;

class FhirFormater extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:fhirvalues';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interface to fhir';

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
     * The instance of lab fhir format.
     *
     * @var object
     */
    public $lab_fhir_formate;
    /**
     * The instance of lab fhir format.
     *
     * @var object
     */
    public $lab_request;

    /**
     * The instance of lab fhir format.
     *
     * @var object
     */
    public $db_clean;



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
        $this->fhir_formate  = new FhirFormateController();
        // $this->import_values = new ImportFhirController();
        // $this->lab_fhir_formate = new LabFhirFormateController(); 
        // $this->lab_request    = new LabRequestController();
        // $this->db_clean       = new FhirBackUpController();

        
        
        $this->fhir_formate->getformatfhir();
        // $this->import_values->creatensursesheet();
        // $this->import_values->updateOxygenIndex();
        // $this->lab_fhir_formate->getlabformatfhir();
        // $this->lab_request->getSendRequest();
        // $this->db_clean->fhirInterfaceClean();
        
    }
}
