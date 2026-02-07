<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📄 Detalhes da Página
            </h2>
            <a href="{{ route('admin.pages.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                ← Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $page->title }}</h3>
                            @if($page->is_published)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Publicado
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Não Publicado
                                </span>
                            @endif
                        </div>

                        @if($page->excerpt)
                        <div class="border-t pt-6">
                            <dt class="text-sm font-medium text-gray-500">Resumo</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $page->excerpt }}</dd>
                        </div>
                        @endif

                        <div class="border-t pt-6">
                            <dt class="text-sm font-medium text-gray-500">Conteúdo</dt>
                            <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $page->content }}</dd>
                        </div>

                        @if($page->featured_image)
                        <div class="border-t pt-6">
                            <dt class="text-sm font-medium text-gray-500 mb-2">Imagem Destacada</dt>
                            <img src="{{ Storage::url($page->featured_image) }}" alt="{{ $page->title }}" class="max-w-md rounded shadow">
                        </div>
                        @endif

                        <div class="border-t pt-6">
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Ordem</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $page->order }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Criado em</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $page->created_at->format('d/m/Y H:i') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-between items-center pt-6 border-t">
                        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta página?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                Excluir
                            </button>
                        </form>
                        <a href="{{ route('admin.pages.edit', $page) }}" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            Editar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
