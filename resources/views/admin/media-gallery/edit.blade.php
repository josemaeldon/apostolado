<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🎨 Editar Mídia
            </h2>
            <a href="{{ route('admin.media-gallery.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                ← Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.media-gallery.update', $mediaGallery) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Título *</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $mediaGallery->title) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                                <textarea name="description" id="description" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $mediaGallery->description) }}</textarea>
                                @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Tipo *</label>
                                <select name="type" id="type" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Selecione o tipo</option>
                                    <option value="image" {{ old('type', $mediaGallery->type) == 'image' ? 'selected' : '' }}>Imagem</option>
                                    <option value="video" {{ old('type', $mediaGallery->type) == 'video' ? 'selected' : '' }}>Vídeo</option>
                                </select>
                                @error('type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="file_path" class="block text-sm font-medium text-gray-700">Novo Arquivo (deixe em branco para manter o atual)</label>
                                @if($mediaGallery->file_path)
                                    @if($mediaGallery->type === 'image')
                                        <img src="{{ Storage::url($mediaGallery->file_path) }}" alt="{{ $mediaGallery->title }}" class="mt-2 h-32 rounded">
                                    @else
                                        <p class="mt-2 text-sm text-gray-600">Arquivo atual: {{ basename($mediaGallery->file_path) }}</p>
                                    @endif
                                @endif
                                <input type="file" name="file_path" id="file_path" accept="image/*,video/*"
                                       class="mt-1 block w-full">
                                @error('file_path')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="url" class="block text-sm font-medium text-gray-700">URL (alternativa ao arquivo)</label>
                                <input type="text" name="url" id="url" value="{{ old('url', $mediaGallery->url) }}"
                                       placeholder="https://www.youtube.com/watch?v=... ou URL direta do arquivo"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="thumbnail" class="block text-sm font-medium text-gray-700">Miniatura (URL ou caminho)</label>
                                <input type="text" name="thumbnail" id="thumbnail" value="{{ old('thumbnail', $mediaGallery->thumbnail) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('thumbnail')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="order" class="block text-sm font-medium text-gray-700">Ordem *</label>
                                <input type="number" name="order" id="order" value="{{ old('order', $mediaGallery->order) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $mediaGallery->is_published) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_published" class="ml-2 block text-sm text-gray-900">Publicado</label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('admin.media-gallery.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Cancelar
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Atualizar Mídia
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
