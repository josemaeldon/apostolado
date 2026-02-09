<x-admin-layout>
    <div class="p-4 lg:p-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Configurações da API</h1>
            <p class="text-gray-600 mt-2">Documentação e configurações da API REST para Cadastro de Membros</p>
        </div>

        <!-- API Base URL -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">URL Base da API</h2>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 font-mono text-sm">
                <code class="text-blue-600">{{ $apiBaseUrl }}</code>
            </div>
            <p class="text-sm text-gray-600 mt-2">
                <strong>Autenticação:</strong> Todas as requisições requerem autenticação de sessão (cookie de login).
            </p>
        </div>

        <!-- Authentication Info -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Autenticação Necessária</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p>A API usa autenticação baseada em sessão web. Você precisa estar autenticado no sistema para fazer requisições à API.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Endpoints -->
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
                        {{ $apiBaseUrl }}{{ $endpoint['endpoint'] }}
                    </div>
                </div>
                
                <div class="p-6">
                    <p class="text-gray-700 mb-4">{{ $endpoint['description'] }}</p>
                    
                    @if(count($endpoint['parameters']) > 0)
                    <div class="mt-4">
                        <h4 class="text-sm font-bold text-gray-900 mb-2">Parâmetros:</h4>
                        <div class="bg-gray-50 rounded-lg p-4">
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
                    </div>
                    @endif
                    
                    <!-- Example Request -->
                    <div class="mt-4">
                        <h4 class="text-sm font-bold text-gray-900 mb-2">Exemplo de Requisição:</h4>
                        <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                            <pre class="text-green-400 text-xs font-mono"><code>curl -X {{ explode('/', $endpoint['method'])[0] }} \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  --cookie "laravel_session=..." \
  {{ $apiBaseUrl }}{{ $endpoint['endpoint'] }}</code></pre>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Response Format -->
        <div class="mt-8 bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Formato de Resposta</h2>
            <p class="text-gray-700 mb-4">Todas as respostas da API são retornadas em formato JSON.</p>
            
            <div class="space-y-4">
                <div>
                    <h4 class="text-sm font-bold text-gray-900 mb-2">Resposta de Sucesso (200/201):</h4>
                    <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                        <pre class="text-green-400 text-xs font-mono"><code>{
  "message": "Cadastro criado com sucesso",
  "data": {
    "id": 1,
    "parish": "Sagrado Coração de Jesus",
    "full_name": "João Silva",
    "cpf": "123.456.789-00",
    "email": "joao@example.com",
    ...
  }
}</code></pre>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-sm font-bold text-gray-900 mb-2">Resposta de Erro (422):</h4>
                    <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                        <pre class="text-red-400 text-xs font-mono"><code>{
  "message": "The given data was invalid.",
  "errors": {
    "email": [
      "The email field is required."
    ],
    "cpf": [
      "The cpf has already been taken."
    ]
  }
}</code></pre>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testing Section -->
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
                        <p>Para testar a API, você pode usar ferramentas como:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Postman</strong> ou <strong>Insomnia</strong> - Ferramentas gráficas para testar APIs</li>
                            <li><strong>curl</strong> - Ferramenta de linha de comando</li>
                            <li><strong>JavaScript fetch()</strong> - Diretamente do navegador (já autenticado)</li>
                        </ul>
                        <p class="mt-2">
                            <strong>Importante:</strong> Certifique-se de incluir os cookies de sessão nas suas requisições.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
