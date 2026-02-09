<x-admin-layout>

    <div class="p-4 lg:p-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Título *</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                                <textarea name="description" id="description" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                                @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700">Imagem *</label>
                                <input type="file" name="image" id="image" accept="image/*" required
                                       class="mt-1 block w-full">
                                @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="button_text" class="block text-sm font-medium text-gray-700">Texto do Botão</label>
                                <input type="text" name="button_text" id="button_text" value="{{ old('button_text') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('button_text')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="link_type" class="block text-sm font-medium text-gray-700">Tipo de Link do Botão</label>
                                <select name="link_type" id="link_type"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="custom" {{ old('link_type', 'custom') == 'custom' ? 'selected' : '' }}>
                                        Link Personalizado
                                    </option>
                                    <option value="page" {{ old('link_type') == 'page' ? 'selected' : '' }}>
                                        Página Interna
                                    </option>
                                    <option value="article" {{ old('link_type') == 'article' ? 'selected' : '' }}>
                                        Artigo
                                    </option>
                                    <option value="event" {{ old('link_type') == 'event' ? 'selected' : '' }}>
                                        Evento
                                    </option>
                                </select>
                                @error('link_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div id="link_page_section" class="hidden">
                                <label for="link_id_page" class="block text-sm font-medium text-gray-700">Selecionar Página</label>
                                <select name="link_id" id="link_id_page"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">-- Selecione uma página --</option>
                                    @foreach($pages as $page)
                                        <option value="{{ $page->id }}" {{ old('link_id') == $page->id ? 'selected' : '' }}>
                                            {{ $page->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('link_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div id="link_article_section" class="hidden">
                                <label for="link_id_article" class="block text-sm font-medium text-gray-700">Selecionar Artigo</label>
                                <select name="link_id" id="link_id_article"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">-- Selecione um artigo --</option>
                                    @foreach($articles as $article)
                                        <option value="{{ $article->id }}" {{ old('link_id') == $article->id ? 'selected' : '' }}>
                                            {{ $article->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="link_event_section" class="hidden">
                                <label for="link_id_event" class="block text-sm font-medium text-gray-700">Selecionar Evento</label>
                                <select name="link_id" id="link_id_event"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">-- Selecione um evento --</option>
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}" {{ old('link_id') == $event->id ? 'selected' : '' }}>
                                            {{ $event->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="link_custom_section">
                                <label for="button_link" class="block text-sm font-medium text-gray-700">Link Personalizado do Botão</label>
                                <input type="text" name="button_link" id="button_link" value="{{ old('button_link') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="https://example.com">
                                @error('button_link')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                <p class="mt-1 text-xs text-gray-500">Use um link externo completo (com https://)</p>
                            </div>

                            <div>
                                <label for="order" class="block text-sm font-medium text-gray-700">Ordem *</label>
                                <input type="number" name="order" id="order" value="{{ old('order', 0) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">Ativo</label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('admin.sliders.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Cancelar
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Criar Slider
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const linkTypeSelect = document.getElementById('link_type');
            const pageLinkSection = document.getElementById('link_page_section');
            const articleLinkSection = document.getElementById('link_article_section');
            const eventLinkSection = document.getElementById('link_event_section');
            const customLinkSection = document.getElementById('link_custom_section');

            // Disable all link_id selects initially except the active one
            function updateLinkSelects() {
                const linkType = linkTypeSelect.value;
                
                // Hide all sections
                pageLinkSection.classList.add('hidden');
                articleLinkSection.classList.add('hidden');
                eventLinkSection.classList.add('hidden');
                customLinkSection.classList.add('hidden');
                
                // Disable all selects
                document.getElementById('link_id_page').disabled = true;
                document.getElementById('link_id_article').disabled = true;
                document.getElementById('link_id_event').disabled = true;
                document.getElementById('button_link').disabled = false;
                
                // Show and enable appropriate section
                if (linkType === 'page') {
                    pageLinkSection.classList.remove('hidden');
                    document.getElementById('link_id_page').disabled = false;
                    document.getElementById('link_id_page').name = 'link_id';
                    document.getElementById('link_id_article').name = '';
                    document.getElementById('link_id_event').name = '';
                } else if (linkType === 'article') {
                    articleLinkSection.classList.remove('hidden');
                    document.getElementById('link_id_article').disabled = false;
                    document.getElementById('link_id_page').name = '';
                    document.getElementById('link_id_article').name = 'link_id';
                    document.getElementById('link_id_event').name = '';
                } else if (linkType === 'event') {
                    eventLinkSection.classList.remove('hidden');
                    document.getElementById('link_id_event').disabled = false;
                    document.getElementById('link_id_page').name = '';
                    document.getElementById('link_id_article').name = '';
                    document.getElementById('link_id_event').name = 'link_id';
                } else {
                    customLinkSection.classList.remove('hidden');
                    document.getElementById('link_id_page').name = '';
                    document.getElementById('link_id_article').name = '';
                    document.getElementById('link_id_event').name = '';
                }
            }
            
            linkTypeSelect.addEventListener('change', updateLinkSelects);
            updateLinkSelects(); // Initialize on page load
        });
    </script>
</x-admin-layout>
