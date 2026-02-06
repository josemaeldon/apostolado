<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS URLs when the request is over HTTPS
        // This handles both direct HTTPS connections and proxied connections
        if ($this->app->bound('request') && $this->app['request']->isSecure()) {
            URL::forceScheme('https');
        }
    }
}
