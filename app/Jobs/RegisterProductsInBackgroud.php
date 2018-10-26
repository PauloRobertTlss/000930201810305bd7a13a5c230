<?php

namespace Leroy\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Leroy\Excel\Bot\Bot as BotExcel;
use Leroy\Entities\Document;

class RegisterProductsInBackgroud implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $doc;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Document $doc)
    {
        $this->doc = $doc;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    
    public function handle()
    {
        
         try{
           /**
           * Gerar uma coleção: Como regra de Negócio(esboço) a planilha será carregada apenas uma vez e depois descartada. O Job aguarda um @array.
           */
            $collection = (new BotExcel)->import($this->path_file_temp);
         } catch (\Box\Spout\Common\Exception\SpoutException $e){
               unlink($tmpFile);
               return response()->json(['error'=>true,'message'=>'Planilha com erros'],422);
         }
         
        \Log::info("cadatro de produtos em background");
        $repository = app(\Leroy\Repositories\Interfaces\ProductRepository::class);
        $repositoryCategory = app(\Leroy\Repositories\Interfaces\CategoryRepository::class);
        $repository->skipPresenter(true);
        $repositoryCategory->skipPresenter(true);
        $checkCategory=false;
        
        $first_product = array_first($this->products);
        if(isset($first_product['category_id'])){
            $category = $repositoryCategory->findByField('id',$first_product['category_id'])->first();
            $checkCategory = !empty($category);
            unset($category);
        }
        
        unset($first_product);
            foreach ($this->products as $p){
                $p = $checkCategory ? $p : array_except($p,'category_id');
                $repository->create($p);
            }
    }
}
