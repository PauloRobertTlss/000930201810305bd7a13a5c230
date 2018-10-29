<?php
namespace Leroy\Services;

use Leroy\Repositories\Interfaces\ProductRepository;
use Leroy\Repositories\Interfaces\CategoryRepository;
use Leroy\Repositories\Interfaces\DocumentRepository;

use Illuminate\Http\UploadedFile;
use Leroy\Jobs\RegisterProductsInBackgroud;
use Leroy\Validators\ProductValidator;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class ProductService.
 * 
 * Service Layer of Products
 *
 * @package namespace Leroy\Services;
 */
class ProductService
{
    /**
     * 
     * @var type ProductRepository
     */
    private $productRepository;
    /**
     * 
     * @var type ProductRepository
     */
    private $documentRepository;
    
    /**
     * 
     * @var type CategoryRepository
     */
    private $categoryRepository;
    /**
     * Rules the RULE_UPDATE and RULE_CREATED
     * @var type ProductValidator
     */
    private $productValidator;
    
    /**
     * Dependency Injection Laravel
     * @param ProductRepository $productRepository
     * @param ProductValidator $validator
     * @param CategoryRepository $categoryRepository
     * @param DocumentRepository $documentRepository
     */
    public function __construct(ProductRepository $productRepository,ProductValidator $validator,CategoryRepository $categoryRepository,DocumentRepository $documentRepository)
    {
        $this->productValidator = $validator;
        $this->documentRepository = $documentRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        //remove presentation
        $this->productRepository->skipPresenter(); 
        $this->categoryRepository->skipPresenter();
        $this->productRepository->skipPresenter();
    }
   
    /**
     * Check attributes attached, or exit.
     * Check the model from the database, or exit.
     * Check Validators for updateding
     * Check Category for updateding
     * @param array $data
     * @param int $id
     * @return type
     */
    public function update(array $data, $id){
        
        //exit update due to lack of attributes
        if(!count($data)){
            return response()->json(['status' => 'failed', 'data' => $data, 'message' => 'attributes not attached'],422);
        }
        
        $p = $this->find($id);
        if(is_null($p)){
           //exit process if product does not exist
           return response()->json(['status' => 'failed', 'data' => null, 'message' => 'Product not found'],404);
        }
        
        try{
          //validation of required fields
          $this->productValidator->with($data)->passesOrFail(ProductValidator::RULE_UPDATE);
            //check existing category
           if(isset($data['category_id'])){
                  $category = $this->categoryRepository->findByField('id',$data['category_id'])->first();
                  $data['category_id'] = !empty($category) ? $category->id : null;
           }

           if(isset($data['price'])){
              //check 
              $data['price'] = str_replace(',','.', $data['price']);
           }
           
           $p = $this->productRepository->skipPresenter(false)->update($data, $p->id);
           return response()->json(['status' => 'success','data'=>$p,'message' => 'Product updated'],200);
        }
        catch (ValidatorException $e){
            $data = ['status' => 'failed','error' => true,'message' => $e->getMessageBag()];
             return response()->json($data,400);
         }
         
    }
    
    /**
     * Check and Delete the model from the database.
     * @param int $id
     * @return type
     */
    public function delete(int $id){
            
          if(!is_null($p = $this->find($id))){
              $this->productRepository->delete($p->id);
              return response()->json([],204);
          }
          
          return response()->json(['status' => 'failed', 'data' => null, 'message' => 'Product not found'],404);
    }
    
    /**
     * Check file object UploadedFile, or exit.
     * Generate new entity document.
     * The document will be dispatched to a processing queue.
     * The endpoint will be available to track the progress or final situation of this document.
     * 
     * @param array $data
     * @return mixed
     */
    
    public function importExcel(array $data)
    {
        
        $file = $data["file"];
        if (is_a($file, UploadedFile::class) and $file->isValid()) {
            
            //Ensure single document name
            //Move document to temporary system folder
            $file_name_temp = bin2hex(openssl_random_pseudo_bytes(8)).'.'.$file->getClientOriginalExtension();
            $file->move(sys_get_temp_dir(),$file_name_temp);
            
            //full path of document
            $tmpFile = sys_get_temp_dir().DIRECTORY_SEPARATOR.$file_name_temp;
            
            //the endpoint will be returned with the only generated
            $hashEndPoint = bin2hex(openssl_random_pseudo_bytes(8)).".".$file->getClientOriginalExtension().".".bin2hex(openssl_random_pseudo_bytes(8));
            //Save a new entity Document
            $document = $this->documentRepository->skipPresenter()->create(['name'=>$file_name_temp,'path'=>$tmpFile,'file_display'=>$file->getClientOriginalName(),'hash_endpoing'=>$hashEndPoint]);
             
            $job = (new RegisterProductsInBackgroud($document));
            dispatch($job);
            unset($hashEndPoint);
            unset($file);
         return response()->json(['message'=>'document dispatch','endpoint' => $document->url_endpoint],200);
        }
        
        return response()->json(['status' => 'failed', 'data' => null, 'message' => 'Excel not found'],422);
    }
    
    /**
     * Find entity through the primary column of this repository
     * 
     * @param string $search
     * @return type
     */
     private function find(string $search){
        return $this->productRepository->findCustomByField($this->productRepository::PRIMARY_KEY_COLUMN,$search);
    }
}