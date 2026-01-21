<?php namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Errors\QueryLogController;
use DB;
class AppServiceProvider extends ServiceProvider 
{

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// $query_log = new QueryLogController();
		// DB::listen(function($query) use ($query_log){
		//     $query_log->infoLog($query->sql.'-'.implode(', ',$query->bindings).' '.$query->time);
  //       });

	
	   
		  
		Blade::withoutDoubleEncoding();
		Paginator::useBootstrapThree();

		  
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('Illuminate\Contracts\Auth\Registrar', 'App\Services\Registrar');
		$this->app->bind('Illuminate\Contracts\Bus\Dispatcher', 'Illuminate\Bus\Dispatcher');
	}

}
