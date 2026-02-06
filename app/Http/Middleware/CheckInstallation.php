<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckInstallation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar se o sistema já foi instalado
        $installed = file_exists(storage_path('installed'));
        
        // Se não está instalado e não está na rota de instalação
        if (!$installed && !$request->is('install*')) {
            return redirect()->route('installer.welcome');
        }
        
        // Se já está instalado e está tentando acessar o instalador
        if ($installed && $request->is('install*')) {
            return redirect('/');
        }
        
        return $next($request);
    }
}
