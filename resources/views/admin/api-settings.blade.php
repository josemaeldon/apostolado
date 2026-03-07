<x-admin-layout>
    <div class="p-4 lg:p-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Configurações da API</h1>
            <p class="text-gray-600 mt-2">Visão completa das funções do site, endpoints REST e rotas disponíveis.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">URL Base da API</h2>
                <div class="space-y-2 text-sm font-mono">
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                        <span class="text-gray-500">Geral:</span>
                        <code class="text-blue-600">{{ $apiBaseUrl }}</code>
                    </div>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                        <span class="text-gray-500">Admin API:</span>
                        <code class="text-blue-600">{{ $adminApiBaseUrl }}</code>
                    </div>
                </div>
                <p class="text-sm text-gray-600 mt-3">
                    <strong>Autenticação:</strong> sessão web (cookie de login).
                </p>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Resumo</h2>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-blue-700">{{ $apiRoutes->count() }}</div>
                        <div class="text-blue-900">Rotas API</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-green-700">{{ $siteRoutes->count() }}</div>
                        <div class="text-green-900">Rotas do Site</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Funções Disponíveis no Sistema</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($availableFunctions as $functionGroup)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="font-bold text-gray-900 mb-2">{{ $functionGroup['group'] }}</h3>
                        <ul class="space-y-2 text-sm text-gray-700">
                            @foreach($functionGroup['items'] as $item)
                                <li class="flex items-start gap-2">
                                    <span class="text-blue-600 mt-0.5">•</span>
                                    <span>{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="space-y-6">
            @foreach($endpoints as $endpoint)
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-white">{{ $endpoint['name'] }}</h3>
                            <span class="px-3 py-1 text-xs font-bold rounded
                                @if($endpoint['method'] === 'GET') bg-green-500
                                @elseif($endpoint['method'] === 'POST') bg-blue-500
                                @elseif($endpoint['method'] === 'PUT/PATCH') bg-yellow-500
                                @elseif($endpoint['method'] === 'DELETE') bg-red-500
                                @endif text-white">
                                {{ $endpoint['method'] }}
                            </span>
                        </div>
                        <div class="mt-2 font-mono text-sm text-blue-100">
                            {{ $adminApiBaseUrl }}{{ $endpoint['endpoint'] }}
                        </div>
                    </div>

                    <div class="p-6">
                        <p class="text-gray-700 mb-4">{{ $endpoint['description'] }}</p>
                        @if(count($endpoint['parameters']) > 0)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="text-sm font-bold text-gray-900 mb-2">Parâmetros</h4>
                                <table class="min-w-full">
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($endpoint['parameters'] as $param => $description)
                                            <tr>
                                                <td class="py-2 pr-4 text-sm font-mono text-blue-600">{{ $param }}</td>
                                                <td class="py-2 text-sm text-gray-700">{{ $description }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        <div class="mt-4 bg-gray-900 rounded-lg p-4 overflow-x-auto">
<pre class="text-green-400 text-xs font-mono"><code>curl -X {{ explode('/', $endpoint['method'])[0] }} \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  --cookie "laravel_session=..." \
  {{ $adminApiBaseUrl }}{{ $endpoint['endpoint'] }}</code></pre>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Inventário de Rotas API</h2>
            <p class="text-sm text-gray-600 mb-4">Lista dinâmica das rotas em <code>/api</code>.</p>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Método</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">URI</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Nome</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Controller/Ação</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Middlewares</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($apiRoutes as $route)
                            <tr>
                                <td class="px-4 py-2 font-mono text-blue-700">{{ implode('|', $route['methods']) }}</td>
                                <td class="px-4 py-2 font-mono text-gray-800">{{ $route['uri'] }}</td>
                                <td class="px-4 py-2 text-gray-700">{{ $route['name'] }}</td>
                                <td class="px-4 py-2 text-gray-700">{{ $route['action'] }}</td>
                                <td class="px-4 py-2 text-gray-500">{{ $route['middleware'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Inventário de Rotas do Site</h2>
            <p class="text-sm text-gray-600 mb-4">Rotas web e funções acessíveis do sistema (público e admin).</p>
            <div class="overflow-x-auto max-h-[28rem] border border-gray-200 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 sticky top-0">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Método</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">URI</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Nome</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Controller/Ação</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Middlewares</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($siteRoutes as $route)
                            <tr>
                                <td class="px-4 py-2 font-mono text-indigo-700">{{ implode('|', $route['methods']) }}</td>
                                <td class="px-4 py-2 font-mono text-gray-800">{{ $route['uri'] }}</td>
                                <td class="px-4 py-2 text-gray-700">{{ $route['name'] }}</td>
                                <td class="px-4 py-2 text-gray-700">{{ $route['action'] }}</td>
                                <td class="px-4 py-2 text-gray-500">{{ $route['middleware'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 bg-yellow-50 border-l-4 border-yellow-500 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Como Testar</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>Você pode testar com Postman/Insomnia, curl ou fetch() no navegador autenticado.</p>
                        <p class="mt-1"><strong>Importante:</strong> inclua cookies de sessão nas chamadas da API admin.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
