<?php


namespace ChatPool\Observers;

use Leroy\Entities\Document;

class DocumentObserver
{
    public function created(Document $document)
    {
        //consolidado
    }
    public function creating(Document $document)
    {
        //pre-processamento
    }
    
    public function deleting(Document $document)
    {
    
    }

    public function updating(Document $document)
    {
        
    }

}