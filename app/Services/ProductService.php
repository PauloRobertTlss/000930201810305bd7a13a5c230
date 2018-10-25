<?php
namespace Leroy\Services;

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
        $this->productRepository->skipPresenter(true);
    }
    
    public function update(int $id,array $data){
        
        
    }
    
    public function destroy(int $id){
        
        
    }
    
    public function importExcel(int $id){
        
        
    }
    

}