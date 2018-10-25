<?php

namespace Leroy\Transformers;

use League\Fractal\TransformerAbstract;
use Leroy\Entities\Product;

/**
 * Class ProductTransformer.
 *
 * @package namespace Leroy\Transformers;
 */
class ProductTransformer extends TransformerAbstract
{
    /**
     * Transform the Product entity.
     *
     * @param \Leroy\Entities\Product $model
     *
     * @return array
     */
    public function transform(Product $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
