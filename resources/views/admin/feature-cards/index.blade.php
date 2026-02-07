<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🎨 Cards da Página Inicial
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.feature-cards.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                    + Novo Card
                </a>
                <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:text-blue-800 px-4 py-2">
                    ← Voltar ao Painel
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
            @endif

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
                            <a href="{{ route('admin.feature-cards.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                                Criar Primeiro Card
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
