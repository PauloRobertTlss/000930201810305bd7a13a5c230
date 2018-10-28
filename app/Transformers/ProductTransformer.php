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
    
    protected $defaultIncludes = ['category'];
    /**
     * Transform the Product entity.
     *
     * @param \Leroy\Entities\Product $product
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'id'         => (int) $product->id,
            'lm'         =>  $product->lm,
            'name'         => (string) $product->name,
            'description'       => (string) $product->description,
            'free_shipping'     => (int) $product->free_shipping,
            'price'             => $product->price,
            'price_display'             => $product->getPriceDisplay(),
            'created_at' => $product->created_at->format('Y-m-d')
        ];
    }
    
     public function includeCategory(Product $product){
         if($product->category_id !== null){
            return $this->item($product->category, new CategoryTransformer());
         }
         return null;
    }
}
