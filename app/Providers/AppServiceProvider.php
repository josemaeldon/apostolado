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
        // We defer the check until after middleware has processed proxy headers
        if ($this->app->bound('request')) {
            $request = $this->app['request'];
            if ($request->isSecure()) {
                URL::forceScheme('https');
            }
        }
    }
}
