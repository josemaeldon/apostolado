<x-admin-layout>

    <div class="p-4 lg:p-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Criar Nova Seção</h2>
                    
                    <form action="{{ route('admin.homepage-sections.store') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label for="key" class="block text-sm font-medium text-gray-700 mb-2">Chave (Key) *</label>
                            <input type="text" name="key" id="key" 
                                   value="{{ old('key') }}" 
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                                   placeholder="ex: hero_section, about_us"
                                   pattern="[a-z0-9_-]+"
                                   title="Use apenas letras minúsculas, números, underscores (_) e hífens (-)"
                                   required>
                            @error('key')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Identificador único da seção (sem espaços, use underscore ou hífen)</p>
                        </div>

                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                            <input type="text" name="title" id="title" 
                                   value="{{ old('title') }}" 
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                                   required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">Subtítulo</label>
                            <textarea name="subtitle" id="subtitle" rows="3" 
                                      class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('subtitle') }}</textarea>
                            @error('subtitle')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" 
                                       {{ old('is_active', true) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Seção ativa</span>
                            </label>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                                Criar Seção
                            </button>
                            <a href="{{ route('admin.homepage-sections.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg font-semibold transition">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
