<x-admin-layout>

    <div class="p-4 lg:p-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.feature-cards.update', $featureCard) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Título *</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $featureCard->title) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="Ex: Oração">
                                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Descrição *</label>
                                <textarea name="description" id="description" rows="3" required
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                          placeholder="Descreva o propósito ou significado deste card">{{ old('description', $featureCard->description) }}</textarea>
                                @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="icon" class="block text-sm font-medium text-gray-700">Ícone (Emoji) *</label>
                                <input type="text" name="icon" id="icon" value="{{ old('icon', $featureCard->icon) }}" required maxlength="10"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="🙏">
                                @error('icon')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                <p class="mt-1 text-sm text-gray-500">Use um emoji para representar este card (ex: 🙏, 🌍, ❤️)</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="color_from" class="block text-sm font-medium text-gray-700">Cor Inicial do Gradiente *</label>
                                    <select name="color_from" id="color_from" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="primary-50" {{ old('color_from', $featureCard->color_from) == 'primary-50' ? 'selected' : '' }}>Primary 50</option>
                                        <option value="gold-50" {{ old('color_from', $featureCard->color_from) == 'gold-50' ? 'selected' : '' }}>Gold 50</option>
                                        <option value="neutral-50" {{ old('color_from', $featureCard->color_from) == 'neutral-50' ? 'selected' : '' }}>Neutral 50</option>
                                        <option value="blue-50" {{ old('color_from', $featureCard->color_from) == 'blue-50' ? 'selected' : '' }}>Blue 50</option>
                                        <option value="green-50" {{ old('color_from', $featureCard->color_from) == 'green-50' ? 'selected' : '' }}>Green 50</option>
                                    </select>
                                    @error('color_from')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="color_to" class="block text-sm font-medium text-gray-700">Cor Final do Gradiente *</label>
                                    <select name="color_to" id="color_to" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="white" {{ old('color_to', $featureCard->color_to) == 'white' ? 'selected' : '' }}>Branco</option>
                                        <option value="primary-100" {{ old('color_to', $featureCard->color_to) == 'primary-100' ? 'selected' : '' }}>Primary 100</option>
                                        <option value="gold-100" {{ old('color_to', $featureCard->color_to) == 'gold-100' ? 'selected' : '' }}>Gold 100</option>
                                    </select>
                                    @error('color_to')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="border_color" class="block text-sm font-medium text-gray-700">Cor da Borda *</label>
                                    <select name="border_color" id="border_color" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="primary-100" {{ old('border_color', $featureCard->border_color) == 'primary-100' ? 'selected' : '' }}>Primary 100</option>
                                        <option value="gold-100" {{ old('border_color', $featureCard->border_color) == 'gold-100' ? 'selected' : '' }}>Gold 100</option>
                                        <option value="neutral-200" {{ old('border_color', $featureCard->border_color) == 'neutral-200' ? 'selected' : '' }}>Neutral 200</option>
                                    </select>
                                    @error('border_color')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="text_color" class="block text-sm font-medium text-gray-700">Cor do Texto do Título *</label>
                                    <select name="text_color" id="text_color" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="primary-800" {{ old('text_color', $featureCard->text_color) == 'primary-800' ? 'selected' : '' }}>Primary 800</option>
                                        <option value="gold-800" {{ old('text_color', $featureCard->text_color) == 'gold-800' ? 'selected' : '' }}>Gold 800</option>
                                        <option value="neutral-900" {{ old('text_color', $featureCard->text_color) == 'neutral-900' ? 'selected' : '' }}>Neutral 900</option>
                                    </select>
                                    @error('text_color')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div>
                                <label for="order" class="block text-sm font-medium text-gray-700">Ordem *</label>
                                <input type="number" name="order" id="order" value="{{ old('order', $featureCard->order) }}" required min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                <p class="mt-1 text-sm text-gray-500">Ordem de exibição (menor número aparece primeiro)</p>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $featureCard->is_active) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">Ativo</label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('admin.feature-cards.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Cancelar
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Atualizar Card
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
