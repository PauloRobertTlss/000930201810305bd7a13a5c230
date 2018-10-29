<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Http\UploadedFile;

class ProductTest extends TestCase
{
    use DatabaseMigrations;
    
    /**
     * Testes Api de Produtos
     *
     * @return void
     */
    public function testAPiList()
    {
        $data = factory(\Leroy\Entities\Product::class,10)->create();
        
        $response = $this->get('/api/v1/products');
        $response->assertStatus(200)->assertJsonStructure(['data'=>[],'meta'=>['pagination'=>['total','count','per_page','current_page','total_pages','links'=>[]]]]);
        
        
    }
    public function testAPiViewWithoutCategory()
    {
        
        $product = factory(\Leroy\Entities\Product::class)->create();
        $response = $this->json('GET','/api/v1/products/'.$product->lm);
        $response->assertStatus(200)->assertJsonStructure(['data'=>[
            'id',
            'lm',
            'name',
            'description',
            'free_shipping',
            'price',
            'price_display',
            'created_at'
            ]]);
        
    }
    
    public function testAPiViewWithCategory()
    {
        $category = factory(\Leroy\Entities\Category::class)->create();
        $product = factory(\Leroy\Entities\Product::class)->create();
        $product->category_id = $category->id;
        $product->save();
                
        $response = $this->json('GET','/api/v1/products/'.$product->lm);
        $response->assertStatus(200)->assertJsonStructure(['data'=>[
            'id',
            'lm',
            'name',
            'description',
            'free_shipping',
            'price',
            'price_display',
            'created_at',
            'category'=>[
                'data'=>['id','name','description','created_at']
            ]
          ]]);    
    }
    
    public function testAPiProductNotFound()
    {  
        $response = $this->json('GET','/api/v1/products/1');
        $response->assertStatus(404)->assertJsonStructure(['data'=>[
            'status',
            'data',
            'message'
            ]]);    
    }
    
    public function testAPiInsert()
    {
        
        $product = factory(\Leroy\Entities\Product::class)->make();
        
        $response = $this->json('POST','/api/v1/products',$product->toArray());
        $response->assertStatus(405);
        
        
    }
    
    public function testAPiUpdate()
    {   
        $product = factory(\Leroy\Entities\Product::class)->create();
        $toUpdate = ['price'=>12.00,'free_shipping'=>1];
        
        $response = $this->json('PUT','/api/v1/products/'.$product->lm,$toUpdate);
        $response->assertStatus(200)->assertJson($toUpdate);
        
        
    }
    
    public function testAPiDelete()
    {   
        $product = factory(\Leroy\Entities\Product::class)->create();
        $response = $this->json('DELETE','/api/v1/products/'.$product->lm);
        $response->assertStatus(204);
        
        
    }
    
    public function testAPiImportExcel()
    {   
        //$data['file'] = UploadedFile::fake()       
        
        $response = $this->json('POST','/api/v1/products/import',$data);
        $response->assertStatus(200);
        
        
    }
}
