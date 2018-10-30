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
        //pre-processamento com Eloquent
        $document->hash_endpoing = bin2hex(openssl_random_pseudo_bytes(8)).".".uniqid(date('HisYmd'));
        \Log::info("creating Document $hashEndPoint");
    }
    
    public function deleting(Document $document)
    {
    
    }

    public function updating(Document $document)
    {
        
    }

}