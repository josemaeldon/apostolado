<x-admin-layout>

    <div class="p-4 lg:p-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Título *</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Categoria</label>
                                <input type="text" name="category" id="category" value="{{ old('category', $article->category) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('category')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="excerpt" class="block text-sm font-medium text-gray-700">Resumo</label>
                                <textarea name="excerpt" id="excerpt" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('excerpt', $article->excerpt) }}</textarea>
                                @error('excerpt')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="content" class="block text-sm font-medium text-gray-700">Conteúdo *</label>
                                <textarea name="content" id="content" rows="10" required
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('content', $article->content) }}</textarea>
                                @error('content')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="featured_image" class="block text-sm font-medium text-gray-700">Nova Imagem Destacada (deixe em branco para manter a atual)</label>
                                @if($article->featured_image)
                                    <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" class="mt-2 h-32 rounded">
                                @endif
                                <input type="file" name="featured_image" id="featured_image" accept="image/*"
                                       class="mt-1 block w-full">
                                @error('featured_image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="published_at" class="block text-sm font-medium text-gray-700">Data de Publicação</label>
                                <input type="date" name="published_at" id="published_at" value="{{ old('published_at', $article->published_at?->format('Y-m-d')) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('published_at')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $article->is_published) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_published" class="ml-2 block text-sm text-gray-900">Publicado</label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('admin.articles.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Cancelar
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Atualizar Artigo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quill Editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <style>
        #editor-container {
            height: 500px;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hide the original textarea
            var textarea = document.querySelector('#content');
            textarea.style.display = 'none';
            
            // Create a container for the editor
            var editorContainer = document.createElement('div');
            editorContainer.id = 'editor-container';
            textarea.parentNode.insertBefore(editorContainer, textarea);
            
            // Initialize Quill
            var quill = new Quill('#editor-container', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'align': [] }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['blockquote', 'code-block'],
                        ['link', 'image'],
                        ['clean']
                    ]
                }
            });
            
            // Set initial content using clipboard API for safer HTML handling
            if (textarea.value) {
                try {
                    var delta = quill.clipboard.convert({ html: textarea.value });
                    quill.setContents(delta);
                } catch (e) {
                    console.error('Error loading editor content:', e);
                }
            }
            
            // Update textarea when content changes
            quill.on('text-change', function() {
                textarea.value = quill.root.innerHTML;
            });
        });
    </script>
</x-admin-layout>
