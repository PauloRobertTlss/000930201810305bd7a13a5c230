<?php


Route::group(['middleware'=>'cors'], function (){
    
    Route::get('webhook/processed/{hash}','DocumentsController@processed');
    
    Route::prefix('v1')
        ->namespace('Api\V1')
        ->group(function () {
        /**
         * Produtos
        */
        Route::group(['prefix' => 'products'], function () {
            Route::post('/import','ProductsController@import');
            
        });
        Route::resource('products', 'ProductsController',['except' => ['edit', 'create','delete']]);
            
        
        });
});