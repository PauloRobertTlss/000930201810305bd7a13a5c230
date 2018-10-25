<?php

namespace Leroy\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Leroy\Http\Controllers\Controller;
use Leroy\Repositories\Interfaces\ProductRepository;
use Services\ProductService;

/**
 * Class ProductsController.
 *
 * @package namespace Leroy\Controllers\Api\V1;
 */
class ProductsController extends Controller
{
    /**
     *
     * @var type 
     */
    private $repository;
    private $services;
    

    public function __construct(ProductRepository $repository,ProductService $services)
    {
       $this->repository = $repository;s
       $this->services = $services;
    }
    
    public function index(Request $request){
        $this->repository->pushCriteria(app(RequestCriteria::class));
        return $this->repository->all();
    }
    
    
}
