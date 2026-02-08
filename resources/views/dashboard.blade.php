<x-admin-layout>
    <div class="p-4 lg:p-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('auth-custom.dashboard') }}</h1>
            <p class="text-gray-600 mt-2">Bem-vindo, {{ Auth::user()->name }}!</p>
        </div>

        <!-- Homepage Sections Management -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-900">Seções da Página Inicial</h2>
            </div>
            
            @if($homepageSections && $homepageSections->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($homepageSections as $section)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="text-xl font-bold text-gray-900">{{ $section->title }}</h3>
                                    @if($section->is_active)
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Ativo</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">Inativo</span>
                                    @endif
                                </div>
                                @if($section->subtitle)
                                    <p class="text-gray-600 mb-4">{{ $section->subtitle }}</p>
                                @endif
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-semibold text-gray-500 uppercase">{{ $section->key }}</span>
                                    <a href="{{ route('admin.homepage-sections.edit', $section) }}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                        Editar
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl shadow p-6 text-center">
                    <p class="text-gray-500">Nenhuma seção configurada ainda.</p>
                </div>
            @endif
        </div>

        <!-- Feature Cards Management -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-900">Cards de Destaque da Home</h2>
                <a href="{{ route('admin.feature-cards.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                    + Novo Card
                </a>
            </div>
            
            @if($featureCards && $featureCards->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($featureCards as $card)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <div class="bg-gradient-to-r from-gray-100 to-gray-50 p-6">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="text-4xl">{{ $card->icon }}</div>
                                    @if($card->is_active)
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Ativo</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">Inativo</span>
                                    @endif
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $card->title }}</h3>
                            </div>
                            <div class="p-6">
                                <p class="text-gray-700 leading-relaxed mb-4">{{ Str::limit($card->description, 100) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-semibold text-gray-500">Ordem: {{ $card->order }}</span>
                                    <a href="{{ route('admin.feature-cards.edit', $card) }}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                        Editar
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl shadow p-6 text-center">
                    <p class="text-gray-500">Nenhum card configurado ainda.</p>
                    <a href="{{ route('admin.feature-cards.create') }}" 
                       class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-semibold transition">
                        Criar Primeiro Card
                    </a>
                </div>
            @endif
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
