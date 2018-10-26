<?php

namespace Leroy\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Leroy\Http\Controllers\Controller;
use Leroy\Repositories\Interfaces\ProductRepository;
use Leroy\Services\ProductService;
use Leroy\Http\Requests\ProductImportExcel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $limitTo = $request->query->get('limit',50);
        $this->repository->pushCriteria(app(RequestCriteria::class));
        return $this->repository->paginate($limitTo);
    }
    
    public function show($id){
        try{
            return $this->repository->find($id);
        }catch(ModelNotFoundException $e)
        {
            return response()->json(['status' => 'failed', 'data' => null, 'message' => 'Product not found'],404);
        }
    }
    
    public function update(Request $request,$id){
       $data = $request->all();
        return $this->services->update($data,$id);
    }
    
    public function destroy($id){
        return $this->services->delete($id);
    }
    
    /**
     * 
     */
    public function import(ProductImportExcel $request)
    {
        $data = $request->all();
        return $this->services->importExcel($data);
    }
    
}
