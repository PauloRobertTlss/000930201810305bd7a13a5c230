<?php
namespace Services;

use Leroy\Repositories\Interfaces\ProductRepository;

class ProductService
{
    /**
     * 
     * @var type 
     */
    private $productRepository;
    
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    

}