<?php


Route::group(['middleware'=>'cors'], function (){
    
    Route::prefix('v1')
        ->namespace('Api\V1')
        ->group(function () {
        /**
         * Produtos
        */
        Route::group(['prefix' => 'procudts'], function () {
            Route::post('/import','ProductsController@import');
            
        });
        Route::resource('products', 'ProductsController',['except' => ['edit', 'create','show']]);
            
        
        });
});