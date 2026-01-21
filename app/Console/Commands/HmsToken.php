<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Fhir\HmsInterfacingController;
use App\Models\Settings\Settings;

class HmsToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:hmstoken';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get hms token';

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
        $request  = new HmsInterfacingController($settings);
        $request->getHMSToken();
    }
}
