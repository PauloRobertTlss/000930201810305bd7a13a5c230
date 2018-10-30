<?php

namespace Leroy\Providers;

use Illuminate\Support\ServiceProvider;
use Leroy\Entities\Document;
use ChatPool\Observers\DocumentObserver;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Document::observe(DocumentObserver::class); //gerar custom_uid
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
