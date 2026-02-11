<x-admin-layout>

    <div class="p-4 lg:p-8">
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
                            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $article->title }}</h3>
                            @if($article->is_published)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Publicado
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Não Publicado
                                </span>
                            @endif
                            @if($article->category)
                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $article->category }}
                                </span>
                            @endif
                        </div>

                        @if($article->excerpt)
                        <div class="border-t pt-6">
                            <dt class="text-sm font-medium text-gray-500">Resumo</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $article->excerpt }}</dd>
                        </div>
                        @endif

                        <div class="border-t pt-6">
                            <dt class="text-sm font-medium text-gray-500">Conteúdo</dt>
                            <dd class="mt-1 text-sm text-gray-900 prose max-w-none">{!! $article->content !!}</dd>
                        </div>

                        @if($article->featured_image)
                        <div class="border-t pt-6">
                            <dt class="text-sm font-medium text-gray-500 mb-2">Imagem Destacada</dt>
                            <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" class="max-w-md rounded shadow">
                        </div>
                        @endif

                        <div class="border-t pt-6">
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($article->published_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Publicado em</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $article->published_at->format('d/m/Y') }}</dd>
                                </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Criado em</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $article->created_at->format('d/m/Y H:i') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-between items-center pt-6 border-t">
                        <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este artigo?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                Excluir
                            </button>
                        </form>
                        <a href="{{ route('admin.articles.edit', $article) }}" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            Editar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
