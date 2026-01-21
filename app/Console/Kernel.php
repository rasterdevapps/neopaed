<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Fhir\FhirFormatedValues;
use App\Models\Nurse\ImportFhir;

class Kernel extends ConsoleKernel
{
     /**
     * @var $fhir_formate instance of FhirFormateController
     */
	 public $fhir_formate;

	/**
     * @var $import_values instance of ImportFhirController
     */
	 public $import_values;

	/**
	 * @var $machine_data instance of machine data
	 */
     public $machine_data;

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		// 'App\Console\Commands\Inspire',
		// 'App\Console\Commands\MonthlyReportGenearater',
		// 'App\Console\Commands\AudioModuleUpdate',
		// 'App\Console\Commands\AudioZipFile',
		// 'App\Console\Commands\MachineDataBackup',
		// 'App\Console\Commands\FhirFormater',

		// 'App\Console\Commands\fhirformater\InfusionFormater',
		// 'App\Console\Commands\fhirformater\MonitorFormater',
		// 'App\Console\Commands\fhirformater\SyringeFormater',
		// 'App\Console\Commands\fhirformater\VendilatorFormater',
		// 'App\Console\Commands\InstallPackage',
		// 'App\Console\Commands\DatabaseBackup',
		'App\Console\Commands\PatientDataBackUp',
		// 'App\Console\Commands\repeatPrescription',
		'App\Console\Commands\LabResult',
		'App\Console\Commands\NicuDashboardResult',
		'App\Console\Commands\HmsToken',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		
		//This method to running infusion formater  
		//$schedule->command('run:infusionformater')->everyMinute();
		//This method to running monitor formater  
		//$schedule->command('run:monitorformater')->everyMinute();
		//This method to running syringe formater 
		//$schedule->command('run:syringeformater')->everyMinute();
		//This method to running vendilator formater 
		///$schedule->command('run:vendilatorformater')->everyMinute();

		//This method to generate fhirvalues  
		// $schedule->command('generate:fhirvalues')->everyMinute();

		//This method to generate inspire  
		//$schedule->command('inspire')->hourly();
		
		//This method to generate report   
		//$schedule->command('generate:report')->everyMinute();
		
		//This method to update recorder row the module id  report 
		//$schedule->command('recorder:update')->everyMinute();
		
		//This method to update zip audio files  
		//$schedule->command('generate:zipaudio')->everyFiveMinutes();
		
		//$schedule->command('generate:machinebackup')->everyMinute();

		//$schedule->command('generate:dbbackup')->hourly();
		// $schedule->command('generate:dbbackup')->daily();
		// $schedule->command('generate:patientdatabackup')->dailyAt('00:20');
		$schedule->command('generate:patientdatabackup')->everyMinute();
		// $schedule->command('generate:prescription')->dailyAt('00:00');
		$schedule->command('generate:labresult')->everyTenMinutes();
		$schedule->command('generate:nicudashboardresult')->dailyAt('00:00');
		$schedule->command('generate:hmstoken')->cron('0 */6 * * *');
	
	}

}

