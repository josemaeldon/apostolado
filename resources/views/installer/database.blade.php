@extends('installer.layout')

@section('content')
<div class="bg-white shadow-xl rounded-lg overflow-hidden">
    <!-- Progress Bar -->
    <div class="bg-gray-50 px-8 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between text-sm">
            <span class="text-indigo-600 font-semibold">Passo 3 de 4</span>
            <span class="text-gray-600">Configuração do Banco de Dados</span>
        </div>
        <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
            <div class="bg-indigo-600 h-2 rounded-full" style="width: 75%"></div>
        </div>
    </div>

    <div class="px-8 py-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">
            Configuração do Banco de Dados
        </h2>

        <p class="text-gray-600 mb-6">
            Insira as credenciais de acesso ao seu banco de dados PostgreSQL:
        </p>

        <form id="databaseForm" class="space-y-4">
            @csrf

            <div>
                <label for="db_host" class="block text-sm font-medium text-gray-700 mb-1">
                    Host do Banco de Dados
                </label>
                <input type="text" id="db_host" name="db_host" value="127.0.0.1" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <p class="mt-1 text-xs text-gray-500">Geralmente: 127.0.0.1 ou localhost</p>
            </div>

            <div>
                <label for="db_port" class="block text-sm font-medium text-gray-700 mb-1">
                    Porta
                </label>
                <input type="number" id="db_port" name="db_port" value="5432" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <p class="mt-1 text-xs text-gray-500">Porta padrão do PostgreSQL: 5432</p>
            </div>

            <div>
                <label for="db_name" class="block text-sm font-medium text-gray-700 mb-1">
                    Nome do Banco de Dados
                </label>
                <input type="text" id="db_name" name="db_name" value="apostolado" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <p class="mt-1 text-xs text-gray-500">O banco de dados já deve existir</p>
            </div>

            <div>
                <label for="db_username" class="block text-sm font-medium text-gray-700 mb-1">
                    Usuário
                </label>
                <input type="text" id="db_username" name="db_username" value="postgres" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="db_password" class="block text-sm font-medium text-gray-700 mb-1">
                    Senha
                </label>
                <input type="password" id="db_password" name="db_password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <p class="mt-1 text-xs text-gray-500">Deixe em branco se não houver senha</p>
            </div>

            <!-- Message area -->
            <div id="messageArea" class="hidden"></div>

            <!-- Test Connection Button -->
            <div class="pt-4">
                <button type="button" id="testConnection" 
                    class="w-full bg-yellow-500 text-white hover:bg-yellow-600 px-6 py-3 rounded-lg font-medium inline-flex items-center justify-center">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Testar Conexão
                </button>
            </div>
        </form>

        <div class="mt-8 flex justify-between">
            <a href="{{ route('installer.permissions') }}" class="bg-gray-200 text-gray-700 hover:bg-gray-300 px-6 py-3 rounded-lg font-medium inline-flex items-center">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                </svg>
                Voltar
            </a>
            
            <button id="nextButton" disabled
                class="bg-gray-400 text-white px-6 py-3 rounded-lg font-medium cursor-not-allowed inline-flex items-center">
                Próximo
                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const testBtn = document.getElementById('testConnection');
    const nextBtn = document.getElementById('nextButton');
    const messageArea = document.getElementById('messageArea');
    const form = document.getElementById('databaseForm');
    
    let connectionTested = false;

    testBtn.addEventListener('click', async function() {
        const formData = new FormData(form);
        
        testBtn.disabled = true;
        testBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Testando...';

        try {
            const response = await fetch('{{ route("installer.test-database") }}', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                showMessage('success', data.message);
                connectionTested = true;
                
                // Save database config
                await saveDatabase(formData);
            } else {
                showMessage('error', data.message);
                connectionTested = false;
            }
        } catch (error) {
            showMessage('error', 'Erro ao testar conexão: ' + error.message);
            connectionTested = false;
        }
        
        testBtn.disabled = false;
        testBtn.innerHTML = '<svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg> Testar Conexão';
        
        updateNextButton();
    });

    async function saveDatabase(formData) {
        try {
            const response = await fetch('{{ route("installer.save-database") }}', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (!data.success) {
                console.error('Erro ao salvar configurações:', data.message);
            }
        } catch (error) {
            console.error('Erro ao salvar configurações:', error);
        }
    }

    function showMessage(type, message) {
        messageArea.classList.remove('hidden');
        
        if (type === 'success') {
            messageArea.className = 'bg-green-50 border border-green-200 rounded-lg p-4';
            messageArea.innerHTML = `
                <div class="flex">
                    <svg class="h-5 w-5 text-green-600 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="text-sm text-green-800 font-semibold">Sucesso!</p>
                        <p class="text-sm text-green-700">${message}</p>
                    </div>
                </div>
            `;
        } else {
            messageArea.className = 'bg-red-50 border border-red-200 rounded-lg p-4';
            messageArea.innerHTML = `
                <div class="flex">
                    <svg class="h-5 w-5 text-red-600 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="text-sm text-red-800 font-semibold">Erro</p>
                        <p class="text-sm text-red-700">${message}</p>
                    </div>
                </div>
            `;
        }
    }

    function updateNextButton() {
        if (connectionTested) {
            nextBtn.disabled = false;
            nextBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
            nextBtn.classList.add('bg-indigo-600', 'hover:bg-indigo-700', 'cursor-pointer');
            nextBtn.onclick = function() {
                window.location.href = '{{ route("installer.admin") }}';
            };
        }
    }
});
</script>
@endpush
