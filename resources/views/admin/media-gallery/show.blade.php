<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🎨 Detalhes da Mídia
            </h2>
            <a href="{{ route('admin.media-gallery.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
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
                            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $mediaGallery->title }}</h3>
                            @if($mediaGallery->is_published)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Publicado
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Não Publicado
                                </span>
                            @endif
                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst($mediaGallery->type) }}
                            </span>
                        </div>

                        @if($mediaGallery->description)
                        <div class="border-t pt-6">
                            <dt class="text-sm font-medium text-gray-500">Descrição</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $mediaGallery->description }}</dd>
                        </div>
                        @endif

                        @if($mediaGallery->file_path)
                        <div class="border-t pt-6">
                            <dt class="text-sm font-medium text-gray-500 mb-2">Arquivo</dt>
                            @if($mediaGallery->type === 'image')
                                <img src="{{ Storage::url($mediaGallery->file_path) }}" alt="{{ $mediaGallery->title }}" class="max-w-md rounded shadow">
                            @elseif($mediaGallery->type === 'video')
                                <video controls class="max-w-md rounded shadow">
                                    <source src="{{ Storage::url($mediaGallery->file_path) }}" type="video/mp4">
                                    Seu navegador não suporta o elemento de vídeo.
                                </video>
                            @endif
                        </div>
                        @endif

                        @if($mediaGallery->url)
                        <div class="border-t pt-6">
                            <dt class="text-sm font-medium text-gray-500">URL</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="{{ $mediaGallery->url }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                    {{ $mediaGallery->url }}
                                </a>
                            </dd>
                        </div>
                        @endif

                        @if($mediaGallery->thumbnail)
                        <div class="border-t pt-6">
                            <dt class="text-sm font-medium text-gray-500 mb-2">Miniatura</dt>
                            <img src="{{ $mediaGallery->thumbnail }}" alt="Miniatura" class="h-24 rounded">
                        </div>
                        @endif

                        <div class="border-t pt-6">
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Ordem</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $mediaGallery->order }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Criado em</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $mediaGallery->created_at->format('d/m/Y H:i') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-between items-center pt-6 border-t">
                        <form action="{{ route('admin.media-gallery.destroy', $mediaGallery) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta mídia?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                Excluir
                            </button>
                        </form>
                        <a href="{{ route('admin.media-gallery.edit', $mediaGallery) }}" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            Editar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
