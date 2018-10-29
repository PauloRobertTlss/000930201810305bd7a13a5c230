<p align="center"><img src="https://cdn.leroymerlin.com.br/assets/lizard/images/logo-leroy.svg"></p>

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Sobre o Projeto

O Projeto disponibiliza uma maneira conveniente de cadastro e atualização de Produtos através de Planilhas (.xlsx),[baixe aqui o modelo](https://s3.us-east-2.amazonaws.com/eaadk4yfoubad0tmoq3cert/certificados/products_teste_webdev_leroy.xlsx), e fornecer um endpoint para acompanhar o status de sua planilha. Após o upload do arquivo será verificado a integridade do seu documento, caso a validação seja confirmada sua planilha entrara na fila de processamento e receba um novo status após esse processo.

## AUTENTICAÇÃO

O Projeto tem o propósito de apresentação, não foi criada uma camada de autenticação [JWT](https://jwt.io/) ou [OAUTH2](https://github.com/thephpleague/oauth2-server) e o uso das API é livre.

## JSON RESPONSE

As APIs por padrão usam o formato JSON em suas resposta. Todas as respostas serão interceptadas pela camada de apresentação [Model–view–presenter (MVP)](https://pt.wikipedia.org/wiki/Model-view-presenter)

## DOCUMENTAÇÃO 

Documentação completa. [visualizar](https://s3.us-east-2.amazonaws.com/eaadk4yfoubad0tmoq3cert/certificados/products_teste_webdev_leroy.xlsx)

## LISTA DE API

1. Ist Item  
First item with having index value 1
1. 2nd Item  
Second item having index value 2, beside we gave it 1, which indicates that markdown parser does not break the list.
1. **3rd Item:**  
&nbsp;&nbsp;&nbsp;&nbsp;If you want to do something fancy with your list

```php
public function test() {
  
}
```
## LISTA DE TESTES

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