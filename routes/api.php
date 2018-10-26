<?php


Route::group(['middleware'=>'cors'], function (){
    
    Route::get('webhook/processed/{hash}','Api\DocumentsController@show');
    Route::get('webhook/inProgress','Api\DocumentsController@inProgress');
    Route::get('webhook/processed','Api\DocumentsController@processed');
    
    Route::prefix('v1')
        ->namespace('Api\V1')
        ->group(function () {
        /**
         * Produtos
        */
        Route::group(['prefix' => 'products'], function () {
            Route::post('/import','ProductsController@import');
            
        });
        Route::resource('products', 'ProductsController',['except' => ['edit', 'create','delete','store']]);
            
        
        });
});