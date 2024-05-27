<?php

namespace App\Providers;

use App\Helpers\CategoryLinks;
use App\Repositories\ApartmentRepository;
use App\Repositories\BlogRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ApartmentRepository::class, ApartmentRepository::class);
        $this->app->singleton(BlogRepository::class, BlogRepository::class);
        $this->app->singleton(CategoryLinks::class, CategoryLinks::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
