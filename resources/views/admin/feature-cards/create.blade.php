<x-admin-layout>

    <div class="p-4 lg:p-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.feature-cards.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="space-y-6">
                            <div>
                                <label for="homepage_section_id" class="block text-sm font-medium text-gray-700">Seção da Página Inicial</label>
                                <select name="homepage_section_id" id="homepage_section_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">-- Nenhuma (posição independente) --</option>
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}" {{ old('homepage_section_id') == $section->id ? 'selected' : '' }}>
                                            {{ $section->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('homepage_section_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                <p class="mt-1 text-sm text-gray-500">Selecione uma seção para associar este card. Ele aparecerá abaixo da seção escolhida.</p>
                            </div>

                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Título *</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="Ex: Oração">
                                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Descrição *</label>
                                <textarea name="description" id="description" rows="3" required
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                          placeholder="Descreva o propósito ou significado deste card">{{ old('description') }}</textarea>
                                @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="featured_image" class="block text-sm font-medium text-gray-700">Imagem em Destaque</label>
                                <input type="file" name="featured_image" id="featured_image" accept="image/*"
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                @error('featured_image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                <p class="mt-1 text-sm text-gray-500">Imagem opcional para melhorar o visual do card (JPEG, PNG, GIF, WebP - máx. 2MB)</p>
                            </div>

                            <div>
                                <label for="icon" class="block text-sm font-medium text-gray-700">Ícone (Emoji) *</label>
                                <input type="text" name="icon" id="icon" value="{{ old('icon', '🙏') }}" required maxlength="10"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="🙏">
                                @error('icon')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                <p class="mt-1 text-sm text-gray-500">Use um emoji para representar este card (ex: 🙏, 🌍, ❤️)</p>
                            </div>

                            <!-- Color Preset Template Selector -->
                            <div class="border-t border-gray-200 pt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Paleta de Cores</label>
                                <div class="mb-4">
                                    <label for="color_preset" class="block text-sm font-medium text-gray-600 mb-2">Escolha um modelo pronto:</label>
                                    <select id="color_preset" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">-- Selecione um modelo --</option>
                                        <option value="primary" data-from="#fef5e7" data-to="#ffffff" data-border="#fdeaa3" data-text="#8b6914">Dourado Suave</option>
                                        <option value="gold" data-from="#fef3c7" data-to="#ffffff" data-border="#fcd34d" data-text="#92400e">Dourado Vibrante</option>
                                        <option value="blue" data-from="#e0f2fe" data-to="#ffffff" data-border="#bae6fd" data-text="#0c4a6e">Azul Celestial</option>
                                        <option value="green" data-from="#d1fae5" data-to="#ffffff" data-border="#a7f3d0" data-text="#065f46">Verde Esperança</option>
                                        <option value="neutral" data-from="#f5f5f4" data-to="#ffffff" data-border="#e7e5e4" data-text="#44403c">Neutro Elegante</option>
                                    </select>
                                    <p class="mt-1 text-sm text-gray-500">Ou personalize as cores manualmente abaixo</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="color_from" class="block text-sm font-medium text-gray-700 mb-2">Cor Inicial do Gradiente *</label>
                                    <div class="flex gap-2 items-center">
                                        <input 
                                            type="color" 
                                            id="color_from_picker" 
                                            value="{{ old('color_from', '#fef5e7') }}"
                                            class="h-10 w-16 rounded border border-gray-300 cursor-pointer"
                                        >
                                        <input 
                                            type="text" 
                                            name="color_from" 
                                            id="color_from" 
                                            value="{{ old('color_from', '#fef5e7') }}" 
                                            required
                                            pattern="^#[0-9A-Fa-f]{6}$"
                                            placeholder="#FFFFFF"
                                            class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 uppercase"
                                        >
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Use o seletor de cor ou digite o código hexadecimal</p>
                                    @error('color_from')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="color_to" class="block text-sm font-medium text-gray-700 mb-2">Cor Final do Gradiente *</label>
                                    <div class="flex gap-2 items-center">
                                        <input 
                                            type="color" 
                                            id="color_to_picker" 
                                            value="{{ old('color_to', '#ffffff') }}"
                                            class="h-10 w-16 rounded border border-gray-300 cursor-pointer"
                                        >
                                        <input 
                                            type="text" 
                                            name="color_to" 
                                            id="color_to" 
                                            value="{{ old('color_to', '#ffffff') }}" 
                                            required
                                            pattern="^#[0-9A-Fa-f]{6}$"
                                            placeholder="#FFFFFF"
                                            class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 uppercase"
                                        >
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Use o seletor de cor ou digite o código hexadecimal</p>
                                    @error('color_to')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="border_color" class="block text-sm font-medium text-gray-700 mb-2">Cor da Borda *</label>
                                    <div class="flex gap-2 items-center">
                                        <input 
                                            type="color" 
                                            id="border_color_picker" 
                                            value="{{ old('border_color', '#fdeaa3') }}"
                                            class="h-10 w-16 rounded border border-gray-300 cursor-pointer"
                                        >
                                        <input 
                                            type="text" 
                                            name="border_color" 
                                            id="border_color" 
                                            value="{{ old('border_color', '#fdeaa3') }}" 
                                            required
                                            pattern="^#[0-9A-Fa-f]{6}$"
                                            placeholder="#FFFFFF"
                                            class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 uppercase"
                                        >
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Use o seletor de cor ou digite o código hexadecimal</p>
                                    @error('border_color')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="text_color" class="block text-sm font-medium text-gray-700 mb-2">Cor do Texto do Título *</label>
                                    <div class="flex gap-2 items-center">
                                        <input 
                                            type="color" 
                                            id="text_color_picker" 
                                            value="{{ old('text_color', '#8b6914') }}"
                                            class="h-10 w-16 rounded border border-gray-300 cursor-pointer"
                                        >
                                        <input 
                                            type="text" 
                                            name="text_color" 
                                            id="text_color" 
                                            value="{{ old('text_color', '#8b6914') }}" 
                                            required
                                            pattern="^#[0-9A-Fa-f]{6}$"
                                            placeholder="#FFFFFF"
                                            class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 uppercase"
                                        >
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Use o seletor de cor ou digite o código hexadecimal</p>
                                    @error('text_color')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div>
                                <label for="order" class="block text-sm font-medium text-gray-700">Ordem *</label>
                                <input type="number" name="order" id="order" value="{{ old('order', 0) }}" required min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                <p class="mt-1 text-sm text-gray-500">Ordem de exibição (menor número aparece primeiro)</p>
                            </div>

                            <div>
                                <label for="display_position" class="block text-sm font-medium text-gray-700">Posição de Exibição</label>
                                <select name="display_position" id="display_position" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Exibir na posição padrão (seção de recursos)</option>
                                    @foreach(\App\Models\FeatureCard::getPositionOptions() as $key => $label)
                                        <option value="{{ $key }}" {{ old('display_position') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('display_position')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                <p class="mt-1 text-sm text-gray-500">Escolha onde este card será exibido na página inicial</p>
                            </div>

                            <div>
                                <label for="display_order" class="block text-sm font-medium text-gray-700">Ordem na Posição</label>
                                <input type="number" name="display_order" id="display_order" value="{{ old('display_order', 0) }}" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('display_order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                <p class="mt-1 text-sm text-gray-500">Ordem de exibição na posição selecionada</p>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">Ativo</label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('admin.feature-cards.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Cancelar
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Criar Card
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sync color pickers with text inputs
        function syncColorPicker(pickerId, textId) {
            const picker = document.getElementById(pickerId);
            const text = document.getElementById(textId);
            
            // Update text when picker changes
            picker.addEventListener('input', function() {
                text.value = this.value.toUpperCase();
            });
            
            // Update picker when text changes
            text.addEventListener('input', function() {
                if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
                    picker.value = this.value;
                }
            });
        }
        
        // Initialize color picker sync
        syncColorPicker('color_from_picker', 'color_from');
        syncColorPicker('color_to_picker', 'color_to');
        syncColorPicker('border_color_picker', 'border_color');
        syncColorPicker('text_color_picker', 'text_color');
        
        // Color preset selector functionality
        document.getElementById('color_preset').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                const from = selectedOption.dataset.from;
                const to = selectedOption.dataset.to;
                const border = selectedOption.dataset.border;
                const text = selectedOption.dataset.text;
                
                // Update text inputs
                document.getElementById('color_from').value = from;
                document.getElementById('color_to').value = to;
                document.getElementById('border_color').value = border;
                document.getElementById('text_color').value = text;
                
                // Update color pickers
                document.getElementById('color_from_picker').value = from;
                document.getElementById('color_to_picker').value = to;
                document.getElementById('border_color_picker').value = border;
                document.getElementById('text_color_picker').value = text;
            }
        });
    </script>
</x-admin-layout>
