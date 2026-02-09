<x-admin-layout>
    <div class="p-4 lg:p-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('auth-custom.dashboard') }}</h1>
            <p class="text-gray-600 mt-2">Bem-vindo, {{ Auth::user()->name }}!</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Sistema Ativo</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">✓</p>
                    </div>
                    <div class="text-3xl">🚀</div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Bem-vindo</p>
                        <p class="text-lg font-bold text-gray-900 mt-1 truncate">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="text-3xl">👤</div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Acesso Completo</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">Admin</p>
                    </div>
                    <div class="text-3xl">⚡</div>
                </div>
            </div>
        </div>

        <!-- Quick Access Links -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('admin.homepage-sections.index') }}" class="bg-white rounded-xl shadow p-6 hover:shadow-lg transition-shadow duration-300 block">
                <div class="flex items-start">
                    <div class="text-4xl mr-4">🏠</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Gerenciar Página Inicial</h3>
                        <p class="text-gray-600">Configure seções e cards de destaque da página inicial</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.articles.index') }}" class="bg-white rounded-xl shadow p-6 hover:shadow-lg transition-shadow duration-300 block">
                <div class="flex items-start">
                    <div class="text-4xl mr-4">📰</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Artigos</h3>
                        <p class="text-gray-600">Criar e gerenciar artigos do site</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.events.index') }}" class="bg-white rounded-xl shadow p-6 hover:shadow-lg transition-shadow duration-300 block">
                <div class="flex items-start">
                    <div class="text-4xl mr-4">📅</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Eventos</h3>
                        <p class="text-gray-600">Gerenciar eventos e atividades</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.pages.index') }}" class="bg-white rounded-xl shadow p-6 hover:shadow-lg transition-shadow duration-300 block">
                <div class="flex items-start">
                    <div class="text-4xl mr-4">📄</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Páginas</h3>
                        <p class="text-gray-600">Criar e gerenciar páginas personalizadas</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-white rounded-xl shadow p-6">
            <h4 class="text-lg font-bold text-gray-900 mb-3">💡 Dica</h4>
            <p class="text-gray-600">
                Use o menu lateral para navegar entre as diferentes seções do painel administrativo. 
                Clique no botão de seta para recolher ou expandir o menu lateral.
            </p>
        </div>
    </div>
</x-admin-layout>
