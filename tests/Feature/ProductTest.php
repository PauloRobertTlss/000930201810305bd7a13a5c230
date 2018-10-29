<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductTest extends TestCase
{
    use DatabaseMigrations;
    
    /**
 * @api {get} /products
 * @apiName /products/
            * @apiExample {curl} Examplo de uso:
            * curl -i --header "Content-Type: application/json;Accept:application/json" --request GET http://localhost:8000/api/v1/products?limit=50&page=2
            * @apiGroup Produtos
            * @apiVersion 0.1.0
            * @apiDescription Listagem de Produtos.
            * @apiParam (QueryString) {Number} limit<code>Opcional</code> Limite de registros por pagina.
            * @apiParam (QueryString) {Number} page<code>Opcional</code> Número da pagina
            * @apiSuccessExample {json} Sucesso:
            *     HTTP/1.1 200 OK
            *    {
             *   "data": [
             *       {
             *           "id": 28,
             *           "lm": 1003,
             *           "name": "Luvas de Proteção",
             *           "description": "Luva de proteção básica",
             *           "free_shipping": 1,
             *           "price": "5.61",
             *           "price_display": "R$ 5.61",
             *           "created_at": "2018-10-26"
             *       }
             *   ],
             *   "meta": {
             *       "pagination": {
             *           "total": 576,
             *           "count": 3,
             *           "per_page": 3,
             *           "current_page": 10,
             *           "total_pages": 192,
             *           "links": {
             *               "previous": "http://localhost:8000:8000/api/v1/products?limit=3&page=9",
             *               "next": "http://localhost:8000:8000/api/v1/products?limit=3&page=11"
             *           }
             *       }
             *   }
             *   }
            */
    public function testAPiList()
    {
        $data = factory(\Leroy\Entities\Product::class,10)->create();
        
        $response = $this->get('/api/v1/products');
        $response->assertStatus(200)->assertJsonStructure(['data'=>[],'meta'=>['pagination'=>['total','count','per_page','current_page','total_pages','links'=>[]]]]);
    }
    
 /**
 * @api {get} /products/:lm
 * @apiName /products/:lm
            * @apiExample {curl} Examplo de uso:
            * curl -i --header "Content-Type: application/json;Accept:application/json" --request GET http://localhost:8000/api/v1/products/30
            * @apiGroup Detalhes
            * @apiVersion 0.1.0
            * @apiDescription Detalhes do Produto com Categoria
            * @apiParam (Paramentro) {Number} lm* Código Único.
            * @apiSuccessExample {json} Sucesso:
            *     HTTP/1.1 200 OK
            *    {
             *   "data": 
             *       {
             *           "id": 28,
             *           "lm": 1020,
             *           "name": "Luvas de Proteção",
             *           "description": "Luva de proteção básica",
             *           "free_shipping": 1,
             *           "price": "5.61",
             *           "price_display": "R$ 5.61",
             *           "created_at": "2018-10-26"
             *       }
            * @apiErrorExample {json} Error-Response:
            *     HTTP/1.1 404 Not Found
            *     {
            *        "status": "failed",
            *        "data": null,
            *        "message": "Product not found"
            *    }
            */
    
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
    /**
 * @api {get} /products/:lm
 * @apiName /products/:lm
            * @apiExample {curl} Examplo de uso:
            * curl -i --header "Content-Type: application/json;Accept:application/json" --request GET http://localhost:8000/api/v1/products/30
            * @apiGroup Detalhes
            * @apiVersion 0.1.0
            * @apiDescription Detalhes do Produto com Categoria
            * @apiParam (Paramentro) {Number} lm* Código Único.
            * @apiSuccessExample {json} Sucesso:
            *     HTTP/1.1 200 OK
            *    {
            *   "data": 
            *       {
            *           "id": 28,
            *           "lm": 1020,
            *           "name": "Luvas de Proteção",
            *           "description": "Luva de proteção básica",
            *           "free_shipping": 1,
            *           "price": "5.61",
            *           "price_display": "R$ 5.61",
            *           "created_at": "2018-10-26",
            *           "category": {
            *                "data": {
            *                   "id": 1,
            *                   "name": "category_1",
            *                   "description": 0,
            *                   "created_at": "2018-10-29"
            *               }
            *           }
            *}
            * @apiErrorExample {json} Error-Response:
            *     HTTP/1.1 404 Not Found
            *     {
            *        "status": "failed",
            *        "data": null,
            *        "message": "Product not found"
            *    }
            */
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
    
 /**
 * @api {put} /products/:lm
 * @apiName /products/:lm
            * @apiExample {curl} Examplo de uso:
            * curl -i --header "Content-Type: application/json;Accept:application/json" --request PUT http://localhost:8000/api/v1/products/30 -d '{
             *           "lm": 1020,
             *           "name": "Luvas de Proteção",
             *           "description": "Luva de proteção básica",
             *           "free_shipping": 1,
             *           "price": "5.61",
             *           "created_at": "2018-10-26"
             *       }'
            * @apiGroup Editar
            * @apiVersion 0.1.0
            * @apiDescription Atualização do Produto
            * @apiParam (Parametros) {String} name <code>obrigatório</code> Nome o Produto.
            * @apiSuccessExample {json} Sucesso:
            *     HTTP/1.1 200 OK
            *    {
            *   "data": 
            *       {
            *           "status": "success",
            *           "message": "Product updated"
            *       }
            * @apiErrorExample {json} Campos Obrigatórios:
            *     HTTP/1.1 400 Bad Request
            *     {
            *        "status": "failed",
            *        "error": true,
            *        "message": {
            *            "name": [
            *                "O name é obrigatório"
            *            ]
            *        }
            *    }
            * @apiErrorExample {json} Error-Response:
            *     HTTP/1.1 404 Not Found
            *     {
            *        "status": "failed",
            *        "data": null,
            *        "message": "Product not found"
            *    }
            */
    public function testAPiUpdate()
    {
        $product = factory(\Leroy\Entities\Product::class)->create();
        $toUpdate = ['name'=>'Furadeira CVAF','price'=>12.00,'free_shipping'=>1];
        
        $response = $this->json('PUT','/api/v1/products/'.$product->lm,$toUpdate);
        $response->assertStatus(200)->assertJsonStructure([
            'status',
            'data'=>['data'=>['id','lm','name','free_shipping','price']],
            'message'
        ]);
    }
    
    public function testAPiUpdateEmptyAttributes()
    {
        $product = factory(\Leroy\Entities\Product::class)->create();
        $toUpdate = [];
        
        $response = $this->json('PUT','/api/v1/products/'.$product->lm,$toUpdate);
        $response->assertStatus(422)->assertJsonStructure([
            'status',
            'data',
            'message'
        ]);
    }
    
    public function testAPiUpdatepNotFound()
    {
       $toUpdate = ['price'=>12.00,'free_shipping'=>1];
       $response = $this->json('PUT','/api/v1/products/1',$toUpdate);
        $response->assertStatus(404)->assertJsonStructure(['data'=>[
            'status',
            'data',
            'message'
            ]]); 
    }
    
    public function testAPiUpdateRequiredFields()
    {
        $product = factory(\Leroy\Entities\Product::class)->create();
        $toUpdate = ['price'=>12.00,'free_shipping'=>1];
        
        $response = $this->json('PUT','/api/v1/products/'.$product->lm,$toUpdate);
        $response->assertStatus(400)->assertJsonStructure([
            'status',
            'error',
            'message'=>['name']
        ]);
    }
    
    /**
* @api {delete} /products/:lm
* @apiName /products/:lm
* @apiExample {curl} Examplo de uso:
* curl -i --header "Content-Type: application/json;Accept:application/json;Origin:http://localhost:8000" --request DELETE http://localhost:8000/api/v1/products/30
* @apiGroup Deletar
* @apiVersion 0.1.0
            * @apiDescription Remover Produto
            * @apiParam (Parametros) {Number} lm* Código Único.
            * @apiSuccessExample {json} Sucesso:
            *     HTTP/1.1 204 No Content
            *    
            *
            * @apiErrorExample {json} Error-Response:
            *     HTTP/1.1 404 Not Found
            *     {
            *        "status": "failed",
            *        "data": null,
            *        "message": "Product not found"
            *    }
            */
    public function testAPiDelete()
    {   
        $product = factory(\Leroy\Entities\Product::class)->create();
        $response = $this->json('DELETE','/api/v1/products/'.$product->lm);
        $response->assertStatus(204);
        
        
    }
    
 /**
 * @api {post} /products/import
 * @apiName /products/import
            * @apiExample {curl} Examplo de uso:
            * curl --header "Accept:application/json" --request POST http://localhost:8000/api/v1/products/import -F 'file=@path/to/file.xlsx''
            * @apiGroup Import do Excel
            * @apiVersion 0.1.0
            * @apiDescription O registro de novos produtos além da atualização pode acontecer atraves de planilhas. <strong style="font-size:1.3rem;color:blue;">faça o download do modelo</strong>.
            * @apiParam (Paramentro) {File} file <code>obrigatório</code>
            * @apiSuccessExample {json} Sucesso:
            *     HTTP/1.1 200 OK
            *    {
            *   "data": 
            *       {
            *           "message": "document dispatch",
            *           "endpoint": "http://localhost:8000:8000/api/webhook/processed/41417e683bcfcf05.xlsx.153ebbfa98a92f85"
            *        }
            * @apiErrorExample {json} Campo Obrigatório:
            *     HTTP/1.1 422 Unprocessable Entity
            *            "file": [
            *                "The file field is required."
            *            ],
            */
    public function testAPiImportExcel()
    {   
       $file_path = __DIR__.DIRECTORY_SEPARATOR.'products_teste_webdev_leroy.xlsx';
       $file = $this->prepareFileUpload($file_path);
       
       $data['file'] = UploadedFile::createFromBase($file,true);
       $response = $this->json('POST','/api/v1/products/import',$data);
       $response->assertStatus(200);
        
    }
    public function testAPiImportTestWithImage()
    {   
       $data['file'] = UploadedFile::fake()->image('test.png');
       $response = $this->json('POST','/api/v1/products/import',$data);
       $response->assertStatus(422);
    }
    
    private function prepareFileUpload($path)
    {
        TestCase::assertFileExists($path);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $path);
        return new \Symfony\Component\HttpFoundation\File\UploadedFile(
            $path, 'products_teste_webdev_leroy.xlsx', $mime, 13071, null, true
       );
    }
}
