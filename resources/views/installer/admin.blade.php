@extends('installer.layout')

@section('content')
<div class="bg-white shadow-xl rounded-lg overflow-hidden">
    <!-- Progress Bar -->
    <div class="bg-gray-50 px-8 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between text-sm">
            <span class="text-indigo-600 font-semibold">Passo 4 de 4</span>
            <span class="text-gray-600">Configuração do Administrador</span>
        </div>
        <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
            <div class="bg-indigo-600 h-2 rounded-full" style="width: 100%"></div>
        </div>
    </div>

    <div class="px-8 py-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">
            Criar Administrador do Sistema
        </h2>

        <p class="text-gray-600 mb-6">
            Crie a conta do administrador que terá acesso total ao sistema:
        </p>

        <form id="adminForm" class="space-y-4">
            @csrf

            <!-- Site Name -->
            <div>
                <label for="site_name" class="block text-sm font-medium text-gray-700 mb-1">
                    Nome do Site
                </label>
                <input type="text" id="site_name" name="site_name" value="Apostolado da Oração" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <p class="mt-1 text-xs text-gray-500">Este nome aparecerá no site e emails</p>
            </div>

            <div class="border-t border-gray-200 my-6"></div>

            <!-- Admin Name -->
            <div>
                <label for="admin_name" class="block text-sm font-medium text-gray-700 mb-1">
                    Nome Completo do Administrador
                </label>
                <input type="text" id="admin_name" name="admin_name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Admin Email -->
            <div>
                <label for="admin_email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email do Administrador
                </label>
                <input type="email" id="admin_email" name="admin_email" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <p class="mt-1 text-xs text-gray-500">Use este email para fazer login</p>
            </div>

            <!-- Admin Password -->
            <div>
                <label for="admin_password" class="block text-sm font-medium text-gray-700 mb-1">
                    Senha
                </label>
                <input type="password" id="admin_password" name="admin_password" required minlength="8"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <p class="mt-1 text-xs text-gray-500">Mínimo de 8 caracteres</p>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="admin_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                    Confirmar Senha
                </label>
                <input type="password" id="admin_password_confirmation" name="admin_password_confirmation" required minlength="8"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Message area -->
            <div id="messageArea" class="hidden"></div>

            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="h-5 w-5 text-blue-600 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="text-sm text-blue-800 font-semibold">O que acontecerá ao concluir:</p>
                        <ul class="text-sm text-blue-700 mt-2 space-y-1 list-disc list-inside">
                            <li>As configurações serão salvas no arquivo .env</li>
                            <li>As tabelas do banco de dados serão criadas automaticamente (migrations)</li>
                            <li>A conta de administrador será criada</li>
                            <li>O sistema será marcado como instalado</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Install Button -->
            <div class="pt-4">
                <button type="submit" id="installButton"
                    class="w-full bg-green-600 text-white hover:bg-green-700 px-6 py-3 rounded-lg font-medium inline-flex items-center justify-center text-lg">
                    <svg class="mr-2 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Concluir Instalação
                </button>
            </div>
        </form>

        <div class="mt-8 flex justify-between">
            <a href="{{ route('installer.database') }}" class="bg-gray-200 text-gray-700 hover:bg-gray-300 px-6 py-3 rounded-lg font-medium inline-flex items-center">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                </svg>
                Voltar
            </a>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div id="loadingModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
        <div class="text-center">
            <svg class="animate-spin h-12 w-12 text-indigo-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Instalando o Sistema</h3>
            <p class="text-gray-600 mb-4">Por favor, aguarde...</p>
            <div class="text-left bg-gray-50 rounded-lg p-4 text-sm">
                <p id="installStep" class="text-gray-700">Iniciando instalação...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('adminForm');
    const installButton = document.getElementById('installButton');
    const messageArea = document.getElementById('messageArea');
    const loadingModal = document.getElementById('loadingModal');
    const installStep = document.getElementById('installStep');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Validate passwords match
        const password = document.getElementById('admin_password').value;
        const confirmPassword = document.getElementById('admin_password_confirmation').value;

        if (password !== confirmPassword) {
            showMessage('error', 'As senhas não coincidem!');
            return;
        }

        // Show loading modal
        loadingModal.classList.remove('hidden');
        installButton.disabled = true;

        const formData = new FormData(form);

        try {
            // Step 1: Saving configuration
            installStep.textContent = '1/3 - Salvando configurações...';
            await new Promise(resolve => setTimeout(resolve, 500));

            // Step 2: Running migrations
            installStep.textContent = '2/3 - Criando tabelas do banco de dados...';
            await new Promise(resolve => setTimeout(resolve, 500));

            // Step 3: Creating admin user
            installStep.textContent = '3/3 - Criando usuário administrador...';

            const response = await fetch('{{ route("installer.install") }}', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                installStep.textContent = '✓ Instalação concluída com sucesso!';
                
                await new Promise(resolve => setTimeout(resolve, 1000));
                
                // Redirect to login
                window.location.href = data.redirect;
            } else {
                loadingModal.classList.add('hidden');
                showMessage('error', data.message);
                installButton.disabled = false;
            }
        } catch (error) {
            loadingModal.classList.add('hidden');
            showMessage('error', 'Erro durante a instalação: ' + error.message);
            installButton.disabled = false;
        }
    });

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
});
</script>
@endpush
