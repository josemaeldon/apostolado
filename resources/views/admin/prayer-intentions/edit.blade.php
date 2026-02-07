<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🙏 Editar Intenção de Oração
            </h2>
            <a href="{{ route('admin.prayer-intentions.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                ← Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.prayer-intentions.update', $prayerIntention) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Título *</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $prayerIntention->title) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Descrição *</label>
                                <textarea name="description" id="description" rows="5" required
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $prayerIntention->description) }}</textarea>
                                @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="month" class="block text-sm font-medium text-gray-700">Mês *</label>
                                    <select name="month" id="month" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Selecione o mês</option>
                                        <option value="Janeiro" {{ old('month', $prayerIntention->month) == 'Janeiro' ? 'selected' : '' }}>Janeiro</option>
                                        <option value="Fevereiro" {{ old('month', $prayerIntention->month) == 'Fevereiro' ? 'selected' : '' }}>Fevereiro</option>
                                        <option value="Março" {{ old('month', $prayerIntention->month) == 'Março' ? 'selected' : '' }}>Março</option>
                                        <option value="Abril" {{ old('month', $prayerIntention->month) == 'Abril' ? 'selected' : '' }}>Abril</option>
                                        <option value="Maio" {{ old('month', $prayerIntention->month) == 'Maio' ? 'selected' : '' }}>Maio</option>
                                        <option value="Junho" {{ old('month', $prayerIntention->month) == 'Junho' ? 'selected' : '' }}>Junho</option>
                                        <option value="Julho" {{ old('month', $prayerIntention->month) == 'Julho' ? 'selected' : '' }}>Julho</option>
                                        <option value="Agosto" {{ old('month', $prayerIntention->month) == 'Agosto' ? 'selected' : '' }}>Agosto</option>
                                        <option value="Setembro" {{ old('month', $prayerIntention->month) == 'Setembro' ? 'selected' : '' }}>Setembro</option>
                                        <option value="Outubro" {{ old('month', $prayerIntention->month) == 'Outubro' ? 'selected' : '' }}>Outubro</option>
                                        <option value="Novembro" {{ old('month', $prayerIntention->month) == 'Novembro' ? 'selected' : '' }}>Novembro</option>
                                        <option value="Dezembro" {{ old('month', $prayerIntention->month) == 'Dezembro' ? 'selected' : '' }}>Dezembro</option>
                                    </select>
                                    @error('month')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="year" class="block text-sm font-medium text-gray-700">Ano *</label>
                                    <input type="number" name="year" id="year" value="{{ old('year', $prayerIntention->year) }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('year')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700">Nova Imagem (deixe em branco para manter a atual)</label>
                                @if($prayerIntention->image)
                                    <img src="{{ Storage::url($prayerIntention->image) }}" alt="{{ $prayerIntention->title }}" class="mt-2 h-32 rounded">
                                @endif
                                <input type="file" name="image" id="image" accept="image/*"
                                       class="mt-1 block w-full">
                                @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="video_url" class="block text-sm font-medium text-gray-700">URL do Vídeo</label>
                                <input type="text" name="video_url" id="video_url" value="{{ old('video_url', $prayerIntention->video_url) }}"
                                       placeholder="https://www.youtube.com/watch?v=..."
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('video_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $prayerIntention->is_published) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_published" class="ml-2 block text-sm text-gray-900">Publicado</label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('admin.prayer-intentions.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Cancelar
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Atualizar Intenção
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
