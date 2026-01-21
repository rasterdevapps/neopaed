<?php

namespace App\Listeners;

use App\Events\NurseSheetUpdateEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NurseSheetUpdateListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NurseSheetUpdateEvent  $event
     * @return void
     */
    public function handle(NurseSheetUpdateEvent $event)
    {
       $event->nurse_sheet_update->creatensursesheet();
    }
}
