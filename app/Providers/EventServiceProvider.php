<?php namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\FhirParseEvent;


class EventServiceProvider extends ServiceProvider 
{

	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		'Illuminate\Auth\Events\Login' => [
			'App\Listeners\LogUserRole',
		],
		// 'App\Events\FhirParseEvent' => [
		// 	'App\Listeners\FhirParseListener',
		// ],
		// 'App\Events\NurseSheetUpdateEvent' => [
		// 	'App\Listeners\NurseSheetUpdateListener',
		// ],
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot()
	{
		parent::boot();

		  // $mirth_data= new SocketController();
    //       $mirth_data->run_listner();

	}

}
