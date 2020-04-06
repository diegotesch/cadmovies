<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\Resource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\CategoryService', 'App\Services\impl\CategoryServiceImpl');
        $this->app->bind('App\Services\AthorService', 'App\Services\impl\AthorServiceImpl');
        $this->app->bind('App\Services\MovieService', 'App\Services\impl\MovieServiceImpl');
        $this->app->bind('App\Services\CastService', 'App\Services\impl\CastServiceImpl');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Resource::withoutWrapping();
    }
}
