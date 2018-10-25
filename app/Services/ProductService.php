<?php
namespace Services;

use LaVuCRM\Repositories\Interfaces\ProductRepository;


class RoleService
{
    
    private $productRepository;
    
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    

}