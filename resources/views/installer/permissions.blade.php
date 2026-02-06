@extends('installer.layout')

@section('content')
<div class="bg-white shadow-xl rounded-lg overflow-hidden">
    <!-- Progress Bar -->
    <div class="bg-gray-50 px-8 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between text-sm">
            <span class="text-indigo-600 font-semibold">Passo 2 de 4</span>
            <span class="text-gray-600">Permissões de Pastas</span>
        </div>
        <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
            <div class="bg-indigo-600 h-2 rounded-full" style="width: 50%"></div>
        </div>
    </div>

    <div class="px-8 py-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">
            Permissões de Pastas
        </h2>

        <p class="text-gray-600 mb-6">
            Verifique se as seguintes pastas têm permissão de escrita:
        </p>

        <div class="space-y-2 mb-6">
            @foreach($permissions as $folder => $writable)
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <span class="text-gray-700 font-mono text-sm">{{ $folder }}</span>
                        @if($writable)
                            <p class="text-xs text-green-600 mt-1">Permissão de escrita: OK</p>
                        @else
                            <p class="text-xs text-red-600 mt-1">Sem permissão de escrita</p>
                            @if($folder === '.env')
                                <p class="text-xs text-red-600 mt-1">O instalador precisa escrever no arquivo .env para salvar as configurações</p>
                            @endif
                        @endif
                    </div>
                    @if($writable)
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @else
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @php
            $allPermissionsOk = !in_array(false, $permissions);
        @endphp

        @if(!$allPermissionsOk)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <div class="flex">
                <svg class="h-5 w-5 text-yellow-600 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="text-sm text-yellow-800 font-semibold">Ação necessária</p>
                    <p class="text-sm text-yellow-700 mb-2">
                        Alguns arquivos/pastas não têm permissão de escrita. Execute os seguintes comandos:
                    </p>
                    <pre class="bg-gray-900 text-gray-100 p-3 rounded text-xs overflow-x-auto">chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod 664 .env
chown www-data:www-data .env</pre>
                    <p class="text-sm text-yellow-700 mt-2">
                        <strong>Nota para Docker:</strong> Se estiver usando Docker, certifique-se de que o arquivo .env seja gravável pelo usuário do container.
                    </p>
                </div>
            </div>
        </div>
        @endif

        <div class="mt-8 flex justify-between">
            <a href="{{ route('installer.requirements') }}" class="bg-gray-200 text-gray-700 hover:bg-gray-300 px-6 py-3 rounded-lg font-medium inline-flex items-center">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                </svg>
                Voltar
            </a>
            
            @if($allPermissionsOk)
            <a href="{{ route('installer.database') }}" class="bg-indigo-600 text-white hover:bg-indigo-700 px-6 py-3 rounded-lg font-medium inline-flex items-center">
                Próximo
                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
            @else
            <button onclick="window.location.reload()" class="bg-yellow-600 text-white hover:bg-yellow-700 px-6 py-3 rounded-lg font-medium inline-flex items-center">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Verificar Novamente
            </button>
            @endif
        </div>
    </div>
</div>
@endsection
