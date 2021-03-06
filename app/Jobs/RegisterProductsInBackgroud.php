<?php

namespace Leroy\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Leroy\Excel\Bot\Bot as BotExcel;
use Leroy\Entities\Document;
use Prettus\Validator\Exceptions\ValidatorException;

class RegisterProductsInBackgroud implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $doc;
    private $products;
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
           $collections = (new BotExcel)->import($this->doc->path);
           $this->products = $collections->toArray();
           unset($collections);
              $progress=1;//success
           
         } catch (\Box\Spout\Common\Exception\SpoutException $e){
              $progress=2;//error
              $this->delete(); //remover trabalho da fila
         }
              unlink($this->doc->path);
              $this->doc->processed = true;
              $this->doc->progress = $progress;
              $this->doc->save();
         
         if(count($this->products)){
            \Log::info("cadastro de produtos em background");
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
                    try{
                        
                        //If the model already exists in the database we can just update our record.
                        $repository->updateOrCreate(array_only($p,['lm']),array_except($p,['lm']));
                    }catch(ValidatorException $e){
                        
                        continue;
                    }
                }
        }
    }
}
