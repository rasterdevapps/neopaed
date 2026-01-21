<?php
namespace App\Listeners;

use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogUserRole
{
    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
		$this->auth = $auth;
        //
    }
    /**
     * Handle the event.
     * THE LOGGED IN USER PERMISSIONS ARE FETCHED AND STORED IN THE SESSION FOR USING IN MENUS AND ACCESS CHECK IN VARIOUS FUNCTIONS
     * @return void
     */	 
    public function handle()
    {
		$results = User::getRoles($this->auth->user()->RoleId);
		$read_permission = isset($results['read_permission'])? array_keys($results['read_permission']):array();
        $write_permission = isset($results['write_permission'])? array_keys($results['write_permission']):array();
		$delete_permission = isset($results['delete_permission'])? array_keys($results['delete_permission']):array();
		session(['read_permission'=> $read_permission]);
        session(['write_permission'=> $write_permission]);  
		session(['delete_permission'=> $delete_permission]);	
		session(['menu_permission'=> array_merge($read_permission, $write_permission)]);
        //
    }
}
