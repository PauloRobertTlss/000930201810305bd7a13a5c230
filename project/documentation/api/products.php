<?php


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
             *       },
             *       {
             *           "id": 29,
             *           "lm": 1004,
             *           "name": "Furadeira X",
             *           "description": "Furadeira eficiente X",
             *           "free_shipping": 0,
             *           "price": "100.02",
             *           "price_display": "R$ 100.02",
             *           "created_at": "2018-10-26"
             *       },
             *       {
             *           "id": 30,
             *           "lm": 1005,
             *           "name": "Furadeira Y",
             *           "description": "Furadeira super eficiente Y",
             *           "free_shipping": 1,
             *           "price": "140.02",
             *           "price_display": "R$ 140.02",
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


/**
 * @api {get} /products/:lm
 * @apiName /products/:lm
            * @apiExample {curl} Examplo de uso:
            * curl -i --header "Content-Type: application/json;Accept:application/json" --request GET http://localhost:8000/api/v1/products/30
            * @apiGroup Detalhes
            * @apiVersion 0.1.0
            * @apiDescription Detalhes do Produto
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
            * @apiParam (Parametros) {Number} lm <code>obrigatório</code> Informe um número.
            * @apiParam (Parametros) {String} name Name do produto.
            * @apiParam (Parametros) {String} description Descrição e detalhes do produto.
            * @apiParam (Parametros) {Number} free_shipping Frete Grátis.
            * @apiParam (Parametros) {Number} price Preço do Produto.
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
            *            "lm": [
            *                "O código único lm* é obrigatório"
            *            ],
            *            "name": [
            *                "O name é obrigatório"
            *            ],
            *            "price": [
            *                "O preço é obrigatório"
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

/**
 * @api {post} /products/import
 * @apiName /products/import
            * @apiExample {curl} Examplo de uso:
            * curl --header "Accept:application/json" --request POST http://localhost:8000/api/v1/products/import -F 'file=@path/to/file.xlsx''
            * @apiGroup Import do Excel
            * @apiVersion 0.1.0
            * @apiDescription O registro de novos produtos além da atualização pode acontecer atraves de uma planilha. <strong style="font-size:1.3rem;color:blue;">faça o download do modelo</strong>.
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
