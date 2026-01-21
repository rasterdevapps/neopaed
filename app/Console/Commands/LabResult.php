<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Fhir\LabFhirFormateController;
use App\Models\Settings\Settings;


class LabResult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:labresult';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get lab results for a baby using visit number';

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
    public function handle(Settings $settings)
    {
        $this->lab_request  = new LabFhirFormateController($settings);
        $this->lab_request->getlabformatfhir();
        // $this->lab_culture_request  = new LabCultureImportController($settings);
        // $this->lab_culture_request->getlabformatfhir();

    }
}
