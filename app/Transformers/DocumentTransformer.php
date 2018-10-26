<?php

namespace Leroy\Transformers;

use League\Fractal\TransformerAbstract;
use Leroy\Entities\Document;

/**
 * Class DocumentTransformer.
 *
 * @package namespace Leroy\Transformers;
 */
class DocumentTransformer extends TransformerAbstract
{
    /**
     * Transform the Document entity.
     *
     * @param \Leroy\Entities\Document $doc
     *
     * @return array
     */
    public function transform(Document $doc)
    {
        $result = [
            'processed' => (bool)$doc->processed,
            'name' => (string)$doc->file_display,
            'progress' => (string)$doc->getProgress()
            
        ];
        
        if($doc->processed){
            $result['comment'] = $doc->timeElapsedString();
        }
        
        return $result;
        
    }
}
