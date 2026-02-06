<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\CheckInstallation::class,
        ]);
        
        // Trust proxies for handling X-Forwarded-* headers
        // Configure specific proxy IPs via TRUSTED_PROXIES env variable
        $middleware->trustProxies(at: config('app.trusted_proxies', '*'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
