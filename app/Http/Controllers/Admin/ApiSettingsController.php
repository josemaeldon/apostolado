<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class ApiSettingsController extends Controller
{
    public function index()
    {
        $apiBaseUrl = url('/api');
        $adminApiBaseUrl = url('/api/admin');

        $apiRoutes = collect(Route::getRoutes())
            ->filter(fn ($route) => Str::startsWith($route->uri(), 'api/'))
            ->map(function ($route) {
                $methods = collect($route->methods())
                    ->reject(fn ($method) => $method === 'HEAD')
                    ->values()
                    ->all();

                return [
                    'methods' => $methods,
                    'uri' => '/' . ltrim($route->uri(), '/'),
                    'name' => $route->getName() ?: '-',
                    'action' => $this->formatActionName($route->getActionName()),
                    'middleware' => $this->formatMiddleware($route->gatherMiddleware()),
                ];
            })
            ->sortBy('uri')
            ->values();

        $siteRoutes = collect(Route::getRoutes())
            ->filter(function ($route) {
                $uri = $route->uri();
                if (Str::startsWith($uri, 'api/')) {
                    return false;
                }

                $action = $route->getActionName();
                return $action === 'Closure' || Str::startsWith($action, 'App\\Http\\Controllers\\');
            })
            ->map(function ($route) {
                $methods = collect($route->methods())
                    ->reject(fn ($method) => $method === 'HEAD')
                    ->values()
                    ->all();

                return [
                    'methods' => $methods,
                    'uri' => '/' . ltrim($route->uri(), '/'),
                    'name' => $route->getName() ?: '-',
                    'action' => $this->formatActionName($route->getActionName()),
                    'middleware' => $this->formatMiddleware($route->gatherMiddleware()),
                ];
            })
            ->sortBy('uri')
            ->values();

        $endpoints = [
            [
                'name' => 'Listar Cadastros',
                'method' => 'GET',
                'endpoint' => '/member-registrations',
                'description' => 'Lista cadastros de membros com filtros e paginação.',
                'parameters' => [
                    'search' => 'Buscar por nome (opcional)',
                    'parish' => 'Filtrar por paróquia (opcional)',
                    'status' => 'Filtrar por status: pending, approved, rejected (opcional)',
                    'city' => 'Filtrar por cidade (opcional)',
                    'date_from' => 'Data inicial (opcional)',
                    'date_to' => 'Data final (opcional)',
                    'per_page' => 'Itens por página (padrão: 15)',
                ],
            ],
            [
                'name' => 'Obter Cadastro',
                'method' => 'GET',
                'endpoint' => '/member-registrations/{id}',
                'description' => 'Retorna os detalhes de um cadastro específico',
                'parameters' => [],
            ],
            [
                'name' => 'Criar Cadastro',
                'method' => 'POST',
                'endpoint' => '/member-registrations',
                'description' => 'Cria novo cadastro de membro.',
                'parameters' => [
                    'parish' => 'Nome da paróquia (obrigatório)',
                    'full_name' => 'Nome completo (obrigatório)',
                    'cpf' => 'CPF no formato 000.000.000-00 (obrigatório)',
                    'address' => 'Endereço (obrigatório)',
                    'phone' => 'Telefone (obrigatório)',
                    'email' => 'E-mail (obrigatório)',
                    'birth_date' => 'Data de nascimento (obrigatório)',
                    'marital_status' => 'Estado civil: Solteiro(a), Casado(a), Divorciado(a), Viúvo(a)',
                    'profession' => 'Profissão (obrigatório)',
                    'member_city' => 'Cidade (obrigatório)',
                    'member_parish' => 'Paróquia do membro (opcional)',
                    'baptism_date' => 'Data de batismo (opcional)',
                    'commitment_1..5' => 'Compromissos booleanos (opcional na API)',
                    'how_met' => 'Como conheceu (opcional)',
                    'why_join' => 'Por que deseja participar (opcional)',
                    'profile_image' => 'Imagem de perfil (opcional)',
                    'status' => 'Status: pending, approved, rejected (opcional, padrão: pending)',
                ],
            ],
            [
                'name' => 'Atualizar Cadastro',
                'method' => 'PUT/PATCH',
                'endpoint' => '/member-registrations/{id}',
                'description' => 'Atualiza um cadastro existente (atualização parcial permitida)',
                'parameters' => [
                    'Campos do cadastro' => 'Todos os campos são opcionais, exceto formato/validação dos enviados',
                ],
            ],
            [
                'name' => 'Excluir Cadastro',
                'method' => 'DELETE',
                'endpoint' => '/member-registrations/{id}',
                'description' => 'Exclui um cadastro de membro',
                'parameters' => [],
            ],
        ];

        $availableFunctions = [
            [
                'group' => 'Site Público',
                'items' => [
                    'Páginas dinâmicas, artigos, eventos, galeria e intenções de oração',
                    'Cadastro de membro com token, validação e comprovante PDF',
                    'Endpoint de favicon dinâmico com fallback e cache busting',
                ],
            ],
            [
                'group' => 'Painel Administrativo',
                'items' => [
                    'Gestão de páginas, artigos, eventos, categorias e galeria',
                    'Gestão de sliders, seções da home e cartões de destaque',
                    'Gestão de cadastros de membros e tokens de cadastro',
                    'Configurações de site, armazenamento, API e usuários',
                ],
            ],
            [
                'group' => 'API REST (Sessão Web)',
                'items' => [
                    'CRUD completo de member-registrations em /api/admin/member-registrations',
                    'Filtros de busca e paginação no endpoint de listagem',
                    'Upload de foto de perfil via multipart/form-data',
                ],
            ],
        ];

        return view('admin.api-settings', compact(
            'apiBaseUrl',
            'adminApiBaseUrl',
            'endpoints',
            'apiRoutes',
            'siteRoutes',
            'availableFunctions'
        ));
    }

    private function formatActionName(string $action): string
    {
        if ($action === 'Closure') {
            return 'Closure';
        }

        return str_replace('App\\Http\\Controllers\\', '', $action);
    }

    private function formatMiddleware(array $middlewares): string
    {
        if (empty($middlewares)) {
            return '-';
        }

        return implode(', ', $middlewares);
    }
}
