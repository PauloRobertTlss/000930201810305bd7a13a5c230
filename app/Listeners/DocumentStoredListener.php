<?php

namespace Leroy\Listeners;

use Leroy\Events\DocumentStoredEvent;
use Leroy\Jobs\RegisterProductsInBackgroud;

class DocumentStoredListener
{
  
    /**
     * Handle the event.
     *
     * @param  DocumentStoredEvent  $event
     * @return void
     */
    public function handle(DocumentStoredEvent $event)
    {
        $model = $event->getModel(); //model em questão
        \Log::info("iniciando fila");
         $job = (new RegisterProductsInBackgroud($model));
         dispatch($job);
        
    }
}
