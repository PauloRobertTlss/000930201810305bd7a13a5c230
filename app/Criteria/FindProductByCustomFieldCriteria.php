<?php

namespace Leroy\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindProductByCustomFieldCriteria.
 *
 * @package namespace Leroy\Criteria;
 */
class FindProductByCustomFieldCriteria implements CriteriaInterface
{
    
     private $field;
     private $search;


    public function __construct(string $field,string $search) {
        $this->field = $field;
        $this->search = $search;
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
        return $model->selectRaw('products.*')
                ->where("products.$this->field",$this->search)->take(1);
    }
}
