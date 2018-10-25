<?php

namespace Leroy\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Leroy\Http\Controllers\Controller;
use Leroy\Repositories\Interfaces\ProductRepository;
use Leroy\Services\ProductService;

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
       $this->repository = $repository;
       $this->services = $services;
    }
    
    public function index(Request $request){
        $this->repository->pushCriteria(app(RequestCriteria::class));
        return $this->repository->all();
    }
    
    public function show($id){
        return $this->repository->find($id);
    }
    
    public function update($id, Request $request){
       $data = $request->all();
        return $this->service->update($id,$data);
    }
    
    public function destroy($id){
        return $this->repository->find($id);
    }
    
    public function import(Request $request)
    {
        return $this->service->importExcel();
    }
    
}
