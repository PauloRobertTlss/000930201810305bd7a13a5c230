<?php

namespace Leroy\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
        $this->app->bind(\Leroy\Repositories\Interfaces\CategoryRepository::class, \Leroy\Repositories\CategoryRepositoryEloquent::class);
        $this->app->bind(\Leroy\Repositories\Interfaces\ProductRepository::class, \Leroy\Repositories\ProductRepositoryEloquent::class);
        $this->app->bind(\Leroy\Repositories\Interfaces\DocumentRepository::class, \Leroy\Repositories\DocumentRepositoryEloquent::class);
        //:end-bindings:
    }
}
