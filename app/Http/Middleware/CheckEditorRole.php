<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEditorRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $resource = null): Response
    {
        if (!$request->user() || !$request->user()->isAdminOrEditor()) {
            abort(403, 'Acesso negado. Você não tem permissão para acessar esta página.');
        }

        // If a specific resource is provided, check if the user can access it
        if ($resource && !$request->user()->canAccess($resource)) {
            abort(403, 'Acesso negado. Você não tem permissão para acessar este recurso.');
        }

        return $next($request);
    }
}
