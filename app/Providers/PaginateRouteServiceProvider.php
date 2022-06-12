<?php

namespace App\Providers;

use App\Helpers\PaginateRoute;

class PaginateRouteServiceProvider extends \MichalOravec\PaginateRoute\PaginateRouteServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        \PaginateRoute::registerMacros();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('paginateroute', PaginateRoute::class);
    }
}
