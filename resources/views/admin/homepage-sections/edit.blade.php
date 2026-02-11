<x-admin-layout>

    <div class="p-4 lg:p-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
            @endif

            <!-- Section Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Editar Seção da Página Inicial</h2>
                    <form action="{{ route('admin.homepage-sections.update', $homepageSection) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                            <input type="text" name="title" id="title" 
                                   value="{{ old('title', $homepageSection->title) }}" 
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                                   required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">Subtítulo</label>
                            <textarea name="subtitle" id="subtitle" rows="3" 
                                      class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('subtitle', $homepageSection->subtitle) }}</textarea>
                            @error('subtitle')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="background_color" class="block text-sm font-medium text-gray-700 mb-2">Cor de Fundo</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="background_color" id="background_color" 
                                       value="{{ old('background_color', $homepageSection->background_color ?? '#f0f5ff') }}" 
                                       class="h-10 w-20 rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500 cursor-pointer">
                                <input type="text" id="background_color_hex" 
                                       value="{{ old('background_color', $homepageSection->background_color ?? '#f0f5ff') }}" 
                                       class="w-32 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 font-mono text-sm"
                                       placeholder="#FFFFFF"
                                       pattern="^#[0-9A-Fa-f]{6}$"
                                       maxlength="7">
                            </div>
                            @error('background_color')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Escolha a cor de fundo para a seção na página inicial</p>
                        </div>

                        <div class="mb-6">
                            <label for="display_position" class="block text-sm font-medium text-gray-700 mb-2">Posição de Exibição</label>
                            <select name="display_position" id="display_position" 
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Não exibir na página inicial</option>
                                @foreach(\App\Models\HomepageSection::getPositionOptions() as $key => $label)
                                    <option value="{{ $key }}" {{ old('display_position', $homepageSection->display_position) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('display_position')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Escolha onde esta seção será exibida na página inicial</p>
                        </div>

                        <div class="mb-6">
                            <label for="display_order" class="block text-sm font-medium text-gray-700 mb-2">Ordem de Exibição</label>
                            <input type="number" name="display_order" id="display_order" 
                                   value="{{ old('display_order', $homepageSection->display_order) }}" 
                                   min="0"
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @error('display_order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Ordem de exibição na posição selecionada (menor número aparece primeiro)</p>
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" 
                                       {{ old('is_active', $homepageSection->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Seção ativa</span>
                            </label>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                                Salvar Alterações
                            </button>
                            <a href="{{ route('admin.homepage-sections.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg font-semibold transition">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Feature Cards Management -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Cards de Destaque</h2>
                            <p class="text-sm text-gray-600 mt-1">Gerencie os cards que aparecem nesta seção</p>
                        </div>
                        <button type="button" onclick="openAddCardModal()" 
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                            + Adicionar Card
                        </button>
                    </div>

                    @if($homepageSection->featureCards->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($homepageSection->featureCards as $card)
                                @php
                                    $classes = $card->getCssClasses();
                                @endphp
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <div class="p-6 {{ $classes['gradient'] }} {{ $classes['border'] }}" style="{{ $classes['style'] ?? '' }}">
                                        <div class="text-4xl mb-3">{{ $card->icon }}</div>
                                        <h3 class="text-xl font-bold {{ $classes['text'] }} mb-2" style="{{ $classes['text_style'] ?? '' }}">{{ $card->title }}</h3>
                                        <p class="text-sm text-neutral-700">{{ Str::limit($card->description, 100) }}</p>
                                    </div>
                                    <div class="p-4 bg-gray-50 border-t flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs font-semibold text-gray-600">Ordem: {{ $card->order }}</span>
                                            @if($card->is_active)
                                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Ativo</span>
                                            @else
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">Inativo</span>
                                            @endif
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="button" onclick="openEditCardModal({{ $card->id }})" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                Editar
                                            </button>
                                            <form action="{{ route('admin.feature-cards.destroy', $card) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este card?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                    Excluir
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">🎨</div>
                            <p class="text-gray-500 mb-4">Nenhum card configurado ainda para esta seção.</p>
                            <button type="button" onclick="openAddCardModal()" 
                                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                                Criar Primeiro Card
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Card Modal -->
    <div id="cardModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 id="modalTitle" class="text-lg font-bold text-gray-900">Adicionar Card</h3>
                <button type="button" onclick="closeCardModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="cardForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="cardMethod" name="_method" value="POST">
                <input type="hidden" name="homepage_section_id" value="{{ $homepageSection->id }}">
                
                <div class="space-y-4 max-h-96 overflow-y-auto px-1">
                    <div>
                        <label for="card_title" class="block text-sm font-medium text-gray-700">Título *</label>
                        <input type="text" name="title" id="card_title" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Ex: Oração">
                    </div>

                    <div>
                        <label for="card_description" class="block text-sm font-medium text-gray-700">Descrição *</label>
                        <textarea name="description" id="card_description" rows="3" required
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Descreva o propósito ou significado deste card"></textarea>
                    </div>

                    <div>
                        <label for="card_icon" class="block text-sm font-medium text-gray-700">Ícone (Emoji) *</label>
                        <input type="text" name="icon" id="card_icon" required maxlength="10"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="🙏">
                        <p class="mt-1 text-sm text-gray-500">Use um emoji para representar este card (ex: 🙏, 🌍, ❤️)</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="card_color_from" class="block text-sm font-medium text-gray-700">Cor Inicial do Gradiente *</label>
                            <div class="mt-1 flex items-center gap-2">
                                <input type="color" id="card_color_from_picker" value="#f0f5ff"
                                       class="h-10 w-16 rounded border-gray-300 cursor-pointer">
                                <input type="text" name="color_from" id="card_color_from" required
                                       value="#f0f5ff"
                                       class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-mono text-sm"
                                       placeholder="#F0F5FF"
                                       pattern="^#[0-9A-Fa-f]{6}$"
                                       maxlength="7">
                            </div>
                        </div>

                        <div>
                            <label for="card_color_to" class="block text-sm font-medium text-gray-700">Cor Final do Gradiente *</label>
                            <div class="mt-1 flex items-center gap-2">
                                <input type="color" id="card_color_to_picker" value="#ffffff"
                                       class="h-10 w-16 rounded border-gray-300 cursor-pointer">
                                <input type="text" name="color_to" id="card_color_to" required
                                       value="#ffffff"
                                       class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-mono text-sm"
                                       placeholder="#FFFFFF"
                                       pattern="^#[0-9A-Fa-f]{6}$"
                                       maxlength="7">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="card_border_color" class="block text-sm font-medium text-gray-700">Cor da Borda *</label>
                            <div class="mt-1 flex items-center gap-2">
                                <input type="color" id="card_border_color_picker" value="#dbeafe"
                                       class="h-10 w-16 rounded border-gray-300 cursor-pointer">
                                <input type="text" name="border_color" id="card_border_color" required
                                       value="#dbeafe"
                                       class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-mono text-sm"
                                       placeholder="#DBEAFE"
                                       pattern="^#[0-9A-Fa-f]{6}$"
                                       maxlength="7">
                            </div>
                        </div>

                        <div>
                            <label for="card_text_color" class="block text-sm font-medium text-gray-700">Cor do Texto *</label>
                            <div class="mt-1 flex items-center gap-2">
                                <input type="color" id="card_text_color_picker" value="#1e40af"
                                       class="h-10 w-16 rounded border-gray-300 cursor-pointer">
                                <input type="text" name="text_color" id="card_text_color" required
                                       value="#1e40af"
                                       class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-mono text-sm"
                                       placeholder="#1E40AF"
                                       pattern="^#[0-9A-Fa-f]{6}$"
                                       maxlength="7">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="card_order" class="block text-sm font-medium text-gray-700">Ordem *</label>
                        <input type="number" name="order" id="card_order" required min="0" value="0"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <p class="mt-1 text-sm text-gray-500">Ordem de exibição (menor número aparece primeiro)</p>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="card_is_active" value="1" checked
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="card_is_active" class="ml-2 block text-sm text-gray-900">Ativo</label>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeCardModal()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        Salvar Card
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function() {
            const cardsData = @json($homepageSection->featureCards);
            
            // Synchronize background color picker and hex input
            const colorInput = document.getElementById('background_color');
            const hexInput = document.getElementById('background_color_hex');
            
            if (colorInput && hexInput) {
                colorInput.addEventListener('input', function() {
                    hexInput.value = this.value.toUpperCase();
                });
                
                hexInput.addEventListener('input', function() {
                    const value = this.value;
                    if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
                        colorInput.value = value;
                    }
                });
            }
            
            window.openAddCardModal = function() {
                document.getElementById('modalTitle').textContent = 'Adicionar Card';
                document.getElementById('cardForm').action = '{{ route('admin.feature-cards.store') }}';
                document.getElementById('cardMethod').value = 'POST';
                
                // Reset form
                document.getElementById('cardForm').reset();
                document.getElementById('card_is_active').checked = true;
                
                // Set default colors
                document.getElementById('card_color_from').value = '#f0f5ff';
                document.getElementById('card_color_from_picker').value = '#f0f5ff';
                document.getElementById('card_color_to').value = '#ffffff';
                document.getElementById('card_color_to_picker').value = '#ffffff';
                document.getElementById('card_border_color').value = '#dbeafe';
                document.getElementById('card_border_color_picker').value = '#dbeafe';
                document.getElementById('card_text_color').value = '#1e40af';
                document.getElementById('card_text_color_picker').value = '#1e40af';
                
                document.getElementById('cardModal').classList.remove('hidden');
            };
            
            window.openEditCardModal = function(cardId) {
                const card = cardsData.find(c => c.id === cardId);
                if (!card) {
                    console.error('Card not found:', cardId);
                    alert('Erro: Card não encontrado. Por favor, recarregue a página e tente novamente.');
                    return;
                }
                
                document.getElementById('modalTitle').textContent = 'Editar Card';
                // Use the update route passed from the controller
                document.getElementById('cardForm').action = card.update_route;
                document.getElementById('cardMethod').value = 'PUT';
                
                // Fill form with card data
                document.getElementById('card_title').value = card.title;
                document.getElementById('card_description').value = card.description;
                document.getElementById('card_icon').value = card.icon;
                document.getElementById('card_color_from').value = card.color_from;
                document.getElementById('card_color_from_picker').value = card.color_from;
                document.getElementById('card_color_to').value = card.color_to;
                document.getElementById('card_color_to_picker').value = card.color_to;
                document.getElementById('card_border_color').value = card.border_color;
                document.getElementById('card_border_color_picker').value = card.border_color;
                document.getElementById('card_text_color').value = card.text_color;
                document.getElementById('card_text_color_picker').value = card.text_color;
                document.getElementById('card_order').value = card.order;
                document.getElementById('card_is_active').checked = card.is_active;
                
                document.getElementById('cardModal').classList.remove('hidden');
            };
            
            window.closeCardModal = function() {
                document.getElementById('cardModal').classList.add('hidden');
            };
            
            // Synchronize card color pickers with text inputs
            const cardColorPairs = [
                ['card_color_from_picker', 'card_color_from'],
                ['card_color_to_picker', 'card_color_to'],
                ['card_border_color_picker', 'card_border_color'],
                ['card_text_color_picker', 'card_text_color']
            ];
            
            cardColorPairs.forEach(([pickerId, inputId]) => {
                const picker = document.getElementById(pickerId);
                const input = document.getElementById(inputId);
                
                if (picker && input) {
                    picker.addEventListener('input', function() {
                        input.value = this.value.toUpperCase();
                    });
                    
                    input.addEventListener('input', function() {
                        const value = this.value;
                        if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
                            picker.value = value;
                        }
                    });
                }
            });
            
            // Close modal on outside click
            document.getElementById('cardModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    window.closeCardModal();
                }
            });
        })();
    </script>
</x-admin-layout>
