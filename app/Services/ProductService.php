<?php
namespace Leroy\Services;

use Leroy\Repositories\Interfaces\ProductRepository;
use Leroy\Repositories\Interfaces\CategoryRepository;
use Leroy\Repositories\Interfaces\DocumentRepository;

use Illuminate\Http\UploadedFile;
use Leroy\Jobs\RegisterProductsInBackgroud;
use Leroy\Validators\ProductValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class ProductService.
 * 
 * Service Layer: Centralização das regras de negócio da aplicação.
 *
 * @package namespace Leroy\Services;
 */
class ProductService
{
    /**
     * 
     * @var type 
     */
    private $productRepository;
    private $documentRepository;
    private $categoryRepository;
    private $productValidator;
    
    public function __construct(ProductRepository $productRepository,ProductValidator $validator,CategoryRepository $categoryRepository,DocumentRepository $documentRepository)
    {
        $this->productValidator = $validator;
        $this->documentRepository = $documentRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository->skipPresenter(true);
        $this->categoryRepository->skipPresenter(true);
        $this->productRepository->skipPresenter(true);
    }
    
    public function update(array $data,int $id){
        
        try{
          $this->productValidator->with($data)->passesOrFail(ProductValidator::RULE_UPDATE);
        }
        catch (ValidatorException $e){
        $data = ['status' => 'failed','error' => true,'message' => $e->getMessageBag()];
             return response()->json($data,400);
         }
         
        try{
            
            if(isset($data['category_id'])){
                $category = $this->categoryRepository->findByField('id',$data['category_id'])->first();
                $data['category_id'] = !empty($category) ? $category->id : null;
                
                /**
                 * Dependará da Regra de Négocio quando a categoria não for encontrada. Retorna 404, ou continua?
                 * return response()->json(['status' => 'failed', 'data' => null, 'message' => 'Category not found'],404);
                 */
            }
          
          $data['price'] = str_replace(',','.', $data['price']);
            
          
          $this->productRepository->update($data,$id);
        }
        catch (ModelNotFoundException $e){
            return response()->json(['status' => 'failed', 'data' => null, 'message' => 'Product not found'],404);
        }
        
        return response()->json(['status' => 'success', 'message' => 'Product updated'],200);
    }
    
    public function delete(int $id){
        
        try{
          $this->productRepository->delete($id);
        }
        catch (ModelNotFoundException $e){
            return response()->json(['status' => 'failed', 'data' => null, 'message' => 'Product not found'],404);
        }
        
        return response()->json(['status' => 'success', 'data' => null, 'message' => 'Product deleted'],204);
        
    }
    
    public function importExcel(array $data)
    {
        
        $file = $data["file"];
        if (is_a($file, UploadedFile::class) and $file->isValid()) {
        
            $file_name_temp = bin2hex(openssl_random_pseudo_bytes(8)).'.'.$file->getClientOriginalExtension();
            $file->move(sys_get_temp_dir(),$file_name_temp);
            $tmpFile = sys_get_temp_dir().DIRECTORY_SEPARATOR.$file_name_temp;
            
            $hashEndPoint = bin2hex(openssl_random_pseudo_bytes(8)).".".$file->getClientOriginalExtension().".".bin2hex(openssl_random_pseudo_bytes(8));
            $document = $this->documentRepository->create(['name'=>$file_name_temp,'path'=>$tmpFile,'file_display'=>$file->getClientOriginalName(),'hash_endpoing'=>$hashEndPoint]);
             
            //$job = (new RegisterProductsInBackgroud($document));
            //dispatch($job);
         
         return response()->json(['message'=>'excel! success','endpoint' => url('api/webhook/processed',[$hashEndPoint])],200);
        
        }
        return response()->json(['error'=>true,'message'=>'Planilha não encontrada'],422);
    }
}