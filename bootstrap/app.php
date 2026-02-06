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
        $proxies = env('TRUSTED_PROXIES', '*');
        // Handle null, empty string, or wildcard
        if ($proxies === null || $proxies === '' || $proxies === '*') {
            $trustedProxies = '*';
        } else {
            // Parse comma-separated values and filter out only empty strings
            $parsed = array_filter(
                array_map('trim', explode(',', (string) $proxies)),
                fn($v) => $v !== ''
            );
            // Return array or fallback to wildcard if parsing resulted in empty array
            $trustedProxies = !empty($parsed) ? $parsed : '*';
        }
        $middleware->trustProxies(at: $trustedProxies);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
