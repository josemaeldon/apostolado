<x-admin-layout>

    <div class="p-4 lg:p-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
            @endif

            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Gerenciar Página Inicial</h1>
                <p class="text-gray-600 mt-2">Configure as seções e cards de destaque da página inicial</p>
            </div>

            <!-- Homepage Sections Management -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-900">Seções da Página Inicial</h2>
                    <a href="{{ route('admin.homepage-sections.create') }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                        + Nova Seção
                    </a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @if($sections->count() > 0)
                            <div class="space-y-4">
                                @foreach($sections as $section)
                                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $section->title }}</h3>
                                                @if($section->subtitle)
                                                    <p class="text-gray-600 mb-3">{{ $section->subtitle }}</p>
                                                @endif
                                                <div class="flex items-center space-x-3">
                                                    <span class="text-xs font-semibold text-gray-500 uppercase">Chave: {{ $section->key }}</span>
                                                    @if($section->is_active)
                                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Ativo</span>
                                                    @else
                                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">Inativo</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex gap-2">
                                                <a href="{{ route('admin.homepage-sections.edit', $section) }}" 
                                                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                                    Editar
                                                </a>
                                                <form action="{{ route('admin.homepage-sections.destroy', $section) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta seção?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                                        Excluir
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="text-6xl mb-4">📝</div>
                                <p class="text-gray-500 mb-4">Nenhuma seção configurada ainda.</p>
                                <a href="{{ route('admin.homepage-sections.create') }}" 
                                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                                    Criar Primeira Seção
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
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
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @if($featureCards->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($featureCards as $card)
                                    @php
                                        $classes = $card->getCssClasses();
                                    @endphp
                                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                                        <div class="p-6 {{ $classes['gradient'] }} border-l-4 {{ $classes['border'] }}">
                                            <div class="text-4xl mb-3">{{ $card->icon }}</div>
                                            <h3 class="text-xl font-bold {{ $classes['text'] }} mb-2">{{ $card->title }}</h3>
                                            <p class="text-sm text-neutral-700">{{ Str::limit($card->description, 100) }}</p>
                                        </div>
                                        <div class="p-4 bg-gray-50 border-t flex items-center justify-between">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-xs font-semibold text-gray-600">Ordem: {{ $card->order }}</span>
                                                @if($card->is_active)
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Ativo</span>
                                                @else
                                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">Inativo</span>
                                                @endif
                                            </div>
                                            <div class="flex gap-2">
                                                <a href="{{ route('admin.feature-cards.edit', $card) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    Editar
                                                </a>
                                                <form action="{{ route('admin.feature-cards.destroy', $card) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este card?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                        Excluir
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="text-6xl mb-4">🎨</div>
                                <p class="text-gray-500 mb-4">Nenhum card configurado ainda.</p>
                                <a href="{{ route('admin.feature-cards.create') }}" 
                                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                                    Criar Primeiro Card
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
