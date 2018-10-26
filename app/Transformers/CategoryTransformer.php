<?php

namespace Leroy\Transformers;

use League\Fractal\TransformerAbstract;
use Leroy\Entities\Category;

/**
 * Class CategoryTransformer.
 *
 * @package namespace Leroy\Transformers;
 */
class CategoryTransformer extends TransformerAbstract
{
    /**
     * Transform the Category entity.
     *
     * @param \Leroy\Entities\Category $model
     *
     * @return array
     */
    public function transform(Category $model)
    {
        return [
            'id'         => (int) $model->id,
            'name'         => (string) $model->name,
            'description'         => (int) $model->description,
            'created_at' => $model->created_at->format('Y-m-d'),           
        ];
    }
}
