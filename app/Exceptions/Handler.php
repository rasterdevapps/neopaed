<?php 
namespace App\Exceptions;


use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Exceptions\InvalidInputException;


class Handler extends ExceptionHandler
{

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		\Illuminate\Auth\AuthenticationException::class,
		\Illuminate\Auth\Access\AuthorizationException::class,
		\Symfony\Component\HttpKernel\Exception\HttpException::class,
		\Illuminate\Database\Eloquent\ModelNotFoundException::class,
		\Illuminate\Validation\ValidationException::class,
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		if ($e instanceof \Illuminate\Session\TokenMismatchException) {
			return redirect()->route('login');
		}
		if ($request->segment(1) == 'get-patient-details') {
			if ($e instanceof  \ErrorException || $e instanceof  \Exception) {
				
				if (!method_exists($e, 'errors')) {
					return \Response::json(['status'=>'error','message'=>'Internal Server Error'],500); 

				}
			}
		}

		if ($request->ajax()) {	
			
			if ($e instanceof  \ErrorException || $e instanceof  \Exception || $e instanceof InvalidInputException) {
				return \Response::json(['status'=>'error','message'=>'Internal Server Error'],500); 
			}

			if ($e instanceof  \Illuminate\Session\TokenMismatchException) {
				return \Response::json(['status'=>'error','message'=>'Your Session Has Expired.Please Try again!'],401); 
			}

			if ($e instanceof \Illuminate\Database\QueryException) {
				return \Response::json(['status'=>'error','message'=>'Information Can\'t be saved'],500); 
			}

			if ($e instanceof Illuminate\Encryption\DecryptException) {
				return \Response::json(['status'=>'error','message'=>'Something went wrong. try after some time'],500); 
			}
		} else {

			if ($e instanceof InvalidInputException) {
				$message = \SiteHelpers::getUserExceptionMessage($e->getCode(), 2);

				return redirect()->back()
				->with('error', \SiteHelpers::alert('error',$message));
			}

			if ($e instanceof  \ErrorException || $e instanceof  \Exception) {
				
				if (!method_exists($e, 'errors')) {

					return \Response::view('errors.500');

				}
			}

			if ($e instanceof \Illuminate\Database\QueryException) {
				return redirect()->back()
				->with('error',\SiteHelpers::alert('error','Information Can\'t be saved'));
			}

			if ($e instanceof  \Illuminate\Session\TokenMismatchException) {
				return redirect()->back()
				->withInput(\Input::except('VaccineDate','_token','MaternalAntibiotics'))
				->with('error',\SiteHelpers::alert('error','Your Session Has Expired.Please Try again!'));
			}

			if ($e instanceof Illuminate\Encryption\DecryptException) {
				return redirect()->back()
				->with('error',\SiteHelpers::alert('error','Something went wrong. try after some time '));
			}
		}

		return parent::render($request, $e);
	}

}









