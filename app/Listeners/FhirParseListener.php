<?php

namespace App\Listeners;

use App\Events\FhirParseEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Fhir\FhirFormatedValues;

class FhirParseListener
{


    /**
     * Handle the event.
     *
     * @param  FhirParseEvent  $event
     * @return void
     */
    public function handle(FhirParseEvent $event)
    {
        $event->parse_fhir->getformatfhir();

    }

    
}
