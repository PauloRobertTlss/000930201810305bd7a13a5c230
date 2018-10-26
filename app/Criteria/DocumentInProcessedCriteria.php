<?php

namespace Leroy\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class DocumentInProcessedCriteria.
 *
 * @package namespace Leroy\Criteria;
 */
class DocumentInProcessedCriteria implements CriteriaInterface
{
    private $processed;


    public function __construct(bool $processed) {
        $this->processed = $processed;
    }

    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->selectRaw('documents.*')
                ->where('documents.processed',$this->processed);
    }
}
