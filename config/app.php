<?php

return [

	 /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */
    'name' => env('APP_NAME', 'Neonatal'),
    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    */
    'env' => env('APP_ENV','production'),
    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */
    'debug' => env('APP_DEBUG'),
    /*
    |--------------------------------------------------------------------------
    | Application URL32
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */
    'url' => env('APP_URL'),
    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */
    'timezone' => 'Asia/Kolkata',
    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */
    'locale' => 'en',
    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */
    'fallback_locale' => 'en',
    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */
    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-CBC',
    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

	'providers' => [

		/*
		 * Laravel Framework Service Providers...
		 */
		Illuminate\Foundation\Providers\ArtisanServiceProvider::class,
		Illuminate\Auth\AuthServiceProvider::class,
		Illuminate\Cache\CacheServiceProvider::class,
		Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
		Illuminate\Cookie\CookieServiceProvider::class,
		Illuminate\Database\DatabaseServiceProvider::class,
		Illuminate\Encryption\EncryptionServiceProvider::class,
		Illuminate\Filesystem\FilesystemServiceProvider::class,
		Illuminate\Foundation\Providers\FoundationServiceProvider::class,
		Illuminate\Hashing\HashServiceProvider::class,
		Illuminate\Mail\MailServiceProvider::class,
		Illuminate\Pagination\PaginationServiceProvider::class,
		Illuminate\Pipeline\PipelineServiceProvider::class,
		Illuminate\Queue\QueueServiceProvider::class,
		Illuminate\Redis\RedisServiceProvider::class,
		Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
		Illuminate\Session\SessionServiceProvider::class,
		Illuminate\Translation\TranslationServiceProvider::class,
		Illuminate\Validation\ValidationServiceProvider::class,
		Illuminate\View\ViewServiceProvider::class,
		Illuminate\Broadcasting\BroadcastServiceProvider::class,
		Way\Generators\GeneratorsServiceProvider::class,
		Xethron\MigrationsGenerator\MigrationsGeneratorServiceProvider::class,
		Intervention\Image\ImageServiceProvider::class,
		Collective\Html\HtmlServiceProvider::class,
		Orangehill\Iseed\IseedServiceProvider::class,
		Illuminate\Notifications\NotificationServiceProvider::class,

		//'Collective\Bus\BusServiceProvider',
		
		/*
		 * Application Service Providers...
		 */
		App\Providers\AppServiceProvider::class,
		//'App\Providers\BusServiceProvider',
		App\Providers\ConfigServiceProvider::class,
		App\Providers\EventServiceProvider::class,
		App\Providers\RouteServiceProvider::class,
	    App\Providers\BroadcastServiceProvider::class,
        Collective\Remote\RemoteServiceProvider::class,
        Milon\Barcode\BarcodeServiceProvider::class,
        Bmatovu\LaravelXml\LaravelXmlServiceProvider::class,
        ZanySoft\Zip\ZipServiceProvider::class,
        Devfactory\Minify\MinifyServiceProvider::class
	],

	/*
	|--------------------------------------------------------------------------
	| Class Aliases
	|--------------------------------------------------------------------------
	|
	| This array of class aliases will be registered when this application
	| is started. However, feel free to register as many as you wish as
	| the aliases are "lazy" loaded so they don't hinder performance.
	|
	*/

	'aliases' => [

		'App'       => Illuminate\Support\Facades\App::class,
		'Artisan'   => Illuminate\Support\Facades\Artisan::class,
		'Auth'      => Illuminate\Support\Facades\Auth::class,
		'Blade'     => Illuminate\Support\Facades\Blade::class,
		'Bus'       => Illuminate\Support\Facades\Bus::class,
		'Cache'     => Illuminate\Support\Facades\Cache::class,
		'Config'    => Illuminate\Support\Facades\Config::class,
		'Cookie'    => Illuminate\Support\Facades\Cookie::class,
		'Crypt'     => Illuminate\Support\Facades\Crypt::class,
		'DB'        => Illuminate\Support\Facades\DB::class,
		'Eloquent'  => Illuminate\Database\Eloquent\Model::class,
		'Event'     => Illuminate\Support\Facades\Event::class,
		'File'      => Illuminate\Support\Facades\File::class,
		'Hash'      => Illuminate\Support\Facades\Hash::class,
		'Input'     => Illuminate\Support\Facades\Input::class,
		'Inspiring' => Illuminate\Foundation\Inspiring::class,
		'Lang'      => Illuminate\Support\Facades\Lang::class,
		'Log'       => Illuminate\Support\Facades\Log::class,
		'Mail'      => Illuminate\Support\Facades\Mail::class,
		'Password'  => Illuminate\Support\Facades\Password::class,
		'Queue'     => Illuminate\Support\Facades\Queue::class,
		'Redirect'  => Illuminate\Support\Facades\Redirect::class,
		'Redis'     => Illuminate\Support\Facades\Redis::class,
		'Request'   => Illuminate\Support\Facades\Request::class,
		'Response'  => Illuminate\Support\Facades\Response::class,
		'Route'     => Illuminate\Support\Facades\Route::class,
		'Schema'    => Illuminate\Support\Facades\Schema::class,
		'Session'   => Illuminate\Support\Facades\Session::class,
		'Storage'   => Illuminate\Support\Facades\Storage::class,
		'URL'       => Illuminate\Support\Facades\URL::class,
		'Validator' => Illuminate\Support\Facades\Validator::class,
		'View'      => Illuminate\Support\Facades\View::class,
		'Form'      => Collective\Html\FormFacade::class,
		'Html'      => Collective\Html\HtmlFacade::class,
	    'Notification' => Illuminate\Support\Facades\Notification::class,
		'SiteHelpers'	   => App\Http\library\SiteHelpers::class,	
		'ValuelistHelpers' => App\Http\library\ValuelistHelpers::class,
        'FormHelpers'      => App\Http\library\FormHelpers::class,
        'ProblemBaseHelpers'=>App\Http\library\ProblemBaseHelpers::class,
        'QualityHelpers'    =>App\Http\library\QualityHelpers::class,
        'DeviceHelpers'     =>App\Http\library\DeviceHelpers::class,

		'DNS1D'            => Milon\Barcode\Facades\DNS1DFacade::class,
        'DNS2D'            => Milon\Barcode\Facades\DNS2DFacade::class,
        'Image'            => Intervention\Image\Facades\Image::class,
        'SSH'              => Collective\Remote\RemoteFacade::class,
        'DNS1D' => Milon\Barcode\Facades\DNS1DFacade::class,
        'DNS2D' => Milon\Barcode\Facades\DNS2DFacade::class,
        'Xml' => Bmatovu\LaravelXml\LaravelXml::class,
        'Zip' => ZanySoft\Zip\ZipFacade::class,
        'Minify' => Devfactory\Minify\Facades\MinifyFacade::class,
        'PDF' => Barryvdh\DomPDF\Facade::class,
	],

    'debug_blacklist' => [
        '_ENV' => [
            'APP_ENV',
            'APP_DEBUG',
            'APP_KEY',
            'APP_NAME',
            'DB_HOST',
            'DB_DATABASE',  
            'DB_USERNAME',
            'DB_PASSWORD',
            'LOG_CHANNEL',
            'CACHE_DRIVER',
            'SESSION_DRIVER',
            'MIRTH_SERVER_IP',
            'MIRTH_PORT',
            'MIRTH_LISTENER_IP',
            'MIRTH_LISTENER_PORT',
            'SMSLOGINID',
            'SMSPASSWORD',
            'SMSSENDERID',
            'SMSURI',
            'REPORT_LOGO',
            'LOGO_TYPE',
            'TIME_ZONE',
            'LOCATION',
            'LICENCE',
            'GOOGLE_APPLICATION_CREDENTIALS',
            'PACS',
        ],
        '_SERVER' => [
            'APP_ENV',
            'APP_DEBUG',
            'APP_KEY',
            'APP_NAME',
            'DB_HOST',
            'DB_DATABASE',  
            'DB_USERNAME',
            'DB_PASSWORD',
            'LOG_CHANNEL',
            'CACHE_DRIVER',
            'SESSION_DRIVER',
            'MIRTH_SERVER_IP',
            'MIRTH_PORT',
            'MIRTH_LISTENER_IP',
            'MIRTH_LISTENER_PORT',
            'SMSLOGINID',
            'SMSPASSWORD',
            'SMSSENDERID',
            'SMSURI',
            'REPORT_LOGO',
            'LOGO_TYPE',
            'TIME_ZONE',
            'LOCATION',
            'LICENCE',
            'GOOGLE_APPLICATION_CREDENTIALS',
            'REDIS_PASSWORD',
            'MAIL_PASSWORD',
            'PUSHER_APP_KEY',
            'PUSHER_APP_SECRET',
            'REQUEST_URI',
            'QUERY_STRING',
            'HTTP_HOST',
            'HTTP_USER_AGENT',     
            'HTTP_ACCEPT',     
            'HTTP_ACCEPT_LANGUAGE',    
            'HTTP_ACCEPT_ENCODING',    
            'HTTP_CONNECTION',     
            'HTTP_COOKIE',     
            'HTTP_UPGRADE_INSECURE_REQUESTS',  
            'PATH',    
            'DYLD_LIBRARY_PATH',   
            'SERVER_SIGNATURE',    
            'SERVER_SOFTWARE',     
            'SERVER_NAME',     
            'SERVER_ADDR',     
            'SERVER_PORT',     
            'REMOTE_ADDR',     
            'DOCUMENT_ROOT',   
            'REQUEST_SCHEME',  
            'CONTEXT_PREFIX',  
            'CONTEXT_DOCUMENT_ROOT',   
            'SERVER_ADMIN',    
            'SCRIPT_FILENAME',     
            'REMOTE_PORT',     
            'REDIRECT_URL',    
            'REDIRECT_QUERY_STRING',   
            'GATEWAY_INTERFACE',   
            'SERVER_PROTOCOL',     
            'REQUEST_METHOD',
            'SCRIPT_NAME',
            'PHP_SELF',

        ],
        '_POST' => [
            'password',
        ],
        '_GET' => [
            'apikey',
        ],


    ],

];
