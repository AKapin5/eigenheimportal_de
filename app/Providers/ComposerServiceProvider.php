<?php

namespace App\Providers;

use App\Models\Menu;
use App\Repositories\BlogRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function(View $view) {
            $view->with([
                'languages' => supportedLocales(),
            ]);
        });
        view()->composer('partials.header', function(View $view) {
            $view->with([
                'menuItems' => Menu::getItems(),
            ]);
        });
        view()->composer('partials.footer', function(View $view) {
            $view->with([
                'menuItems' => Menu::getItems(),
                'topBlogs' => $this->app->get(BlogRepository::class)->getTop(),
            ]);
        });
    }
}
