<?php

namespace Leroy\Listeners;

use Leroy\Events\DocumentStoredEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DocumentStoredListener
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
     * @param  DocumentStoredEvent  $event
     * @return void
     */
    public function handle(DocumentStoredEvent $event)
    {
        //
    }
}
