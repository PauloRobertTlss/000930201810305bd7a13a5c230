<?php

namespace Leroy\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Leroy\Http\Controllers\Controller;
use Leroy\Repositories\Interfaces\ProductRepository;
use Leroy\Services\ProductService;
use Leroy\Http\Requests\ProductImportExcel;

/**
 * Class ProductsController.
 *
 * @package namespace Leroy\Controllers\Api\V1;
 */
class ProductsController extends Controller
{
    /**
     * Repository Products
     * 
     * @var ProductRepository
     */
    private $repository;
    
    /**
     * Service Layer for Business rules
     * 
     * @var ProductService
     */
    private $services;
    
    /**
     * Dependency Injection  Laravel
     * @param ProductRepository $repository
     * @param ProductService $services
     */
    public function __construct(ProductRepository $repository,ProductService $services)
    {
       $this->repository = $repository;
       $this->services = $services;
    }
    
    /**
     * Retrieve a lists Products,paginated.
     * 
     * @param  int limit The number of models to return for pagination.
     * @param  int page The number current page.
     * @return mixed
     */
    public function index(Request $request){
        $limitTo = $request->query->get('limit',50);
        $this->repository->pushCriteria(app(RequestCriteria::class));
        //including meta date of pagination
        return $this->repository->paginate($limitTo);
    }
    
    /**
     * Find Product by one values in one field
     *
     * @param  $id
     * @return mixed
     */
    public function show($id){
       // Through the method we can verify that the product exists.
       $p = $this->repository->findCustomByField($this->repository::PRIMARY_KEY_COLUMN,$id);
       return !is_null($p) ? $p : response()->json(['status' => 'failed', 'data' => null, 'message' => 'Product not found'],404);

    }
    
    /**
     * Update a entity Product
     * 
     * @param Request $request
     * @param type $id
     * @return mixed
     */
    public function update(Request $request,$id){
       $data = $request->all();
       //Rules for upgrading the service layey
        return $this->services->update($data,$id);
    }
    
     /**
     * Delete a entity Product
     * 
     * @param Request $request
     * @param type $id
     * @return mixed
     */
    public function destroy($id){
        //Rules for Deleting the service layey
        return $this->services->delete($id);
    }
    
    /**
     * Import File
     * 
     * @param ProductImportExcel $request
     * @return mixed
     */
    public function import(ProductImportExcel $request)
    {
        $data = $request->all();
        //Rules for import file in service layey
        return $this->services->importExcel($data);
    }
    
}
