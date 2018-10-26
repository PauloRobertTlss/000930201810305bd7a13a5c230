<?php
namespace Leroy\Services;

use Leroy\Repositories\Interfaces\ProductRepository;
use Leroy\Excel\Bot\Bot as BotExcel;
use Illuminate\Http\UploadedFile;
use Leroy\Jobs\RegisterProductsInBackgroud;

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
    
    public function importExcel(array $data)
    {
        
        $file = $data["file"];
        if (is_a($file, UploadedFile::class) and $file->isValid()) {
        
        $file_name_temp = bin2hex(openssl_random_pseudo_bytes(8)).'.'.$file->getClientOriginalExtension();
        $file->move(sys_get_temp_dir(),$file_name_temp);
        $tmpFile = sys_get_temp_dir().DIRECTORY_SEPARATOR.$file_name_temp;
        
        \Log::info("movendo upload para pasta temporatia do sistema ".$tmpFile);
        
         try{
            $collection = (new BotExcel)->import($tmpFile);
         } catch (\Box\Spout\Common\Exception\SpoutException $e){
               return response()->json(['error'=>true,'message'=>'Planilha não formatada'],422);
         }
         
         if($collection->count()){
            $job = (new RegisterProductsInBackgroud($collection->toArray()));
            dispatch($job);
         }
         
         return response()->json(['message'=>'excel! success','rows' => $collection->count()],200);
        
        }
        
        return response()->json(['error'=>true,'message'=>'Planilha não encontrada'],422);
        
    }
    

}