<p align="center"><img src="https://cdn.leroymerlin.com.br/assets/lizard/images/logo-leroy.svg"></p>

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Sobre o Projeto

O Projeto disponibiliza uma maneira conveniente de cadastro e atualização de Produtos através de Planilhas (.xlsx), além de fornecer um endpoint para acompanhar o status de sua planilha. Após o upload do arquivo será verificado a integridade do seu documento, caso a validação seja confirmada sua planilha entrara na fila de processamento e receba um novo status após esse processo.


## LAYOUT DA PLANILHA - CASO DE USO

O modelo do documento para importação. [planilha modelo](https://s3.us-east-2.amazonaws.com/eaadk4yfoubad0tmoq3cert/certificados/products_teste_webdev_leroy.xlsx),

## AUTENTICAÇÃO

O Projeto tem o propósito de apresentação, não foi criada uma camada de autenticação [JWT](https://jwt.io/) ou [OAUTH2](https://github.com/thephpleague/oauth2-server) e o uso das API é livre.

## JSON RESPONSE

As APIs por padrão usam o formato JSON em suas respostas. Todas as respostas serão interceptadas pela camada de apresentação [Model–view–presenter (MVP)](https://pt.wikipedia.org/wiki/Model-view-presenter)



## API DE PRODUTO

| API                     | Verbo  |  Geral                                     |
|-------------------------|:------:|-------------------------------------------:|
| /api/v1/products        |  GET   | Lista de produtos                          |
| /api/v1/products/{lm}   |  GET   | Detalhes do Produto                        |
| /api/v1/products/{lm}   |  PUT   | Atualização de Produto                     |
| /api/v1/products/{lm}   |  DELETE| Remover Produto                            |
| /api/v1/products/import |  POST  | Cadastrar, Atualizar Produtos com Planilha |

## API DE ENDPOINT

| API                           | Verbo  |  Geral                                     |
|-------------------------------|:------:|-------------------------------------------:|
| /api/webhook/processed/{hash} |  GET   | Verificar status de um documento           |
| /api/webhook/inProgress       |  GET   | listagem de documentos em fila             |
| /api/webhook/processed        |  GET   | listagem de documentos já processdos       |

```php
php artisan route:list
```

![Rotas](https://s3.us-east-2.amazonaws.com/eaadk4yfoubad0tmoq3cert/certificados/rotas_leroy.png)

## DOCUMENTAÇÃO API

Documentação completa. [visualizar](http://doc.tlss-cloud.com.br/)

## CORS - Not allowed in CORS policy.
 
 - Postman: Headers adicione Origin:

![Origin](https://s3.us-east-2.amazonaws.com/eaadk4yfoubad0tmoq3cert/certificados/headers.png)

 - Para sua hostedagem o arquivo config\cors.php
    ```php
        return [   
        'supportsCredentials' => false,
        'allowedOrigins' => ['http://127.0.0.1:8000',
                         'ADICIONE AQUI'
                        ],
            'allowedOriginsPatterns' => [],
            'allowedHeaders' => ['*'],
            'allowedMethods' => ['*'],
            'exposedHeaders' => [],
            'maxAge' => 0
        ];
   ```

## LISTA DE TESTES - TDD

```php
public function testAPiList(){
//listagem de produtos
}
public function testAPiViewWithCategory(){
//Detalhes do Produto com category
}
public function testAPiViewWithoutCategory(){
//Detalhes do Produto sem category
}
public function testAPiProductNotFound(){
//Produto não encontrado
}
public function testAPiInsert(){
//Tentativa de cadastro - response HTTP/1.1 405
}
public function testAPiUpdate(){
//Atualizando Produto
}
public function testAPiUpdateEmptyAttributes(){
//Tentativa de atualização com attributos vazios.
}
public function testAPiUpdatepNotFound(){
//Tentativa de atualização produto não encontrado.
}
public function testAPiUpdateRequiredFields(){
//Tentativa de atualização e validação de campos.
}
public function testAPiDelete(){
//Removendo Produto
}
public function testAPiImportExcel(){
//Upload de arquivo(.xlsx) para cadastro e atualização de Produtos
}
public function testAPiImportTestWithImage(){
//Upload de imagen. response HTTP/1.1 422
}


```