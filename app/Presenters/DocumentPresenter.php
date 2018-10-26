<?php

namespace Leroy\Presenters;

use Leroy\Transformers\DocumentTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DocumentPresenter.
 *
 * @package namespace Leroy\Presenters;
 */
class DocumentPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DocumentTransformer();
    }
}
