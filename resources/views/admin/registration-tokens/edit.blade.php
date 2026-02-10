<x-admin-layout>

    <div class="p-4 lg:p-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Editar Token de Cadastro</h3>
                        <a href="{{ route('admin.registration-tokens.index') }}" class="text-gray-600 hover:text-gray-900">← Voltar</a>
                    </div>

                    <div class="mb-6 p-4 bg-gray-50 rounded-md">
                        <p class="text-sm text-gray-700"><strong>Token:</strong> <code class="px-2 py-1 bg-gray-200 rounded font-mono text-lg font-bold">{{ $registrationToken->token }}</code></p>
                        <p class="text-sm text-gray-700 mt-2"><strong>Criado em:</strong> {{ $registrationToken->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <form action="{{ route('admin.registration-tokens.update', $registrationToken) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Descrição
                            </label>
                            <input type="text" name="description" value="{{ old('description', $registrationToken->description) }}" 
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Ex: Token para evento especial">
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <input type="checkbox" name="is_active" value="1" class="rounded" {{ old('is_active', $registrationToken->is_active) ? 'checked' : '' }}>
                                Token ativo
                            </label>
                            @error('is_active')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Número máximo de usos (deixe em branco para ilimitado)
                            </label>
                            <input type="number" name="max_uses" value="{{ old('max_uses', $registrationToken->max_uses) }}" min="1"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Ex: 100">
                            <p class="mt-1 text-sm text-gray-500">Usos atuais: {{ $registrationToken->used_count }}</p>
                            @error('max_uses')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Data de expiração (opcional)
                            </label>
                            <input type="datetime-local" name="expires_at" 
                                   value="{{ old('expires_at', $registrationToken->expires_at ? $registrationToken->expires_at->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('expires_at')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.registration-tokens.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>
