<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\NicuDashboardController;

class NicuDashboardResult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:nicudashboardresult';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get nicu dashboard results based on bed no';

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
        \DB::table('nicu_dashboard_results')->update(['need_data'=> true]);
        $nicudashboard = new NicuDashboardController();
        $nicudashboard->updateDashboardData();
    }
}
