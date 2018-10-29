<?php

namespace Leroy\Events;

use Leroy\Entities\Document;

class DocumentStoredEvent
{
    private $document;
    
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * @return Document
     */
    public function getModel()
    {
        return $this->document;
    }
}
