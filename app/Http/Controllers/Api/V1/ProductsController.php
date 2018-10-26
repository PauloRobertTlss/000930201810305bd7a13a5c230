<?php

namespace Leroy\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Leroy\Http\Controllers\Controller;
use Leroy\Repositories\Interfaces\ProductRepository;
use Leroy\Services\ProductService;
use Illuminate\Http\UploadedFile;
use Leroy\Http\Requests\ProductImportExcel;

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
        return $this->services->destroy($id);
    }
    /**
     * 
     */
    public function import(ProductImportExcel $request)
    {
        
        $data = $request->all();
        $file = $data["file"];
            
            if (is_a($file, UploadedFile::class) and $file->isValid()) {
                $data['extension'] = $file->getClientOriginalExtension();
                unset($file);
                return $this->services->importExcel($data);
            }
        
        return response()->json(['error'   => true,'message' => "Arquivo não encontrado"],422);
        
    }
    
}
