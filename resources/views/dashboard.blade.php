<x-admin-layout>
    <div class="p-4 lg:p-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('auth-custom.dashboard') }}</h1>
            <p class="text-gray-600 mt-2">Bem-vindo, {{ Auth::user()->name }}!</p>
        </div>

        <!-- Seções da Página Inicial -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-900">Seções da Página Inicial</h2>
                <a href="{{ route('admin.homepage-sections.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition-colors duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Adicionar Nova Seção
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card: Oração -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white">
                        <div class="text-4xl mb-3">🙏</div>
                        <h3 class="text-2xl font-bold">Oração</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 leading-relaxed">
                            Rezamos mensalmente pelas intenções do Papa Francisco, unindo nossos corações em oração.
                        </p>
                    </div>
                </div>

                <!-- Card: Missão -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 text-white">
                        <div class="text-4xl mb-3">✝️</div>
                        <h3 class="text-2xl font-bold">Missão</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 leading-relaxed">
                            Colaboramos na missão evangelizadora da Igreja, levando o amor de Cristo ao mundo.
                        </p>
                    </div>
                </div>

                <!-- Card: Coração de Jesus -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="bg-gradient-to-r from-red-500 to-red-600 p-6 text-white">
                        <div class="text-4xl mb-3">❤️</div>
                        <h3 class="text-2xl font-bold">Coração de Jesus</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 leading-relaxed">
                            Vivemos nossa espiritualidade centrada no Sagrado Coração de Jesus.
                        </p>
                    </div>
                </div>
            </div>
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

        <!-- Help Section -->
        <div class="mt-6 bg-white rounded-xl shadow p-6">
            <h4 class="text-lg font-bold text-gray-900 mb-3">💡 Dica</h4>
            <p class="text-gray-600">
                Use o menu lateral para navegar entre as diferentes seções do painel administrativo. 
                Clique no botão de seta para recolher ou expandir o menu lateral.
            </p>
        </div>
    </div>
</x-admin-layout>
