<?php

namespace Leroy\Events;

use Leroy\Entities\Document;

class DocumentStoredEvent
{
    private $document;
    
    public function __construct(Document $document)
    {
        $this->bank = $document;
    }

    /**
     * @return Document
     */
    public function getDocument()
    {
        return $this->document;
    }
}
