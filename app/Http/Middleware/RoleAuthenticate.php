<?php namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class RoleAuthenticate 
{

	/**
	 * The Role implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  $module 
	 * @param  $permission 
	 * @return mixed
	 */
	public function handle($request, Closure $next, $module='', $permission='')
	{	 

		// Fetch the current logged in user role.
		if (isset($this->auth->user()->RoleId)) {
		  $role_id = $this->auth->user()->RoleId;
		} else {
			return redirect('/');
		}  

		User::getSpecialpermissions($this->auth->user()->id);

		if (!User::CheckRole($role_id, $module, $permission)) {
			return view('errors.403');
		} else {
			return $next($request);
		}


		
	}

}
