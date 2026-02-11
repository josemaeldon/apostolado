<x-admin-layout>
    <div class="p-6">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Configurações do Site</h1>
                <p class="mt-2 text-sm text-gray-600">
                    Configure o nome e logo do seu site. O logo será exibido na página inicial e no painel administrativo.
                </p>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Settings Form -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <form action="{{ route('admin.site-settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-6 space-y-6">
                        <!-- Site Name -->
                        <div>
                            <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nome do Site
                            </label>
                            <input 
                                type="text" 
                                name="site_name" 
                                id="site_name" 
                                value="{{ old('site_name', $siteName) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required
                            >
                            @error('site_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Use Logo Toggle -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Exibir Logo
                            </label>
                            <div class="flex items-center space-x-4">
                                <label class="inline-flex items-center">
                                    <input 
                                        type="radio" 
                                        name="use_logo" 
                                        value="0" 
                                        {{ old('use_logo', $useLogo) == '0' ? 'checked' : '' }}
                                        class="form-radio text-blue-600"
                                    >
                                    <span class="ml-2">Usar Nome do Site</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input 
                                        type="radio" 
                                        name="use_logo" 
                                        value="1" 
                                        {{ old('use_logo', $useLogo) == '1' ? 'checked' : '' }}
                                        class="form-radio text-blue-600"
                                    >
                                    <span class="ml-2">Usar Logo (Imagem)</span>
                                </label>
                            </div>
                            @error('use_logo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Logo Position -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Posição do Logo
                            </label>
                            <div class="flex items-center space-x-4">
                                <label class="inline-flex items-center">
                                    <input 
                                        type="radio" 
                                        name="logo_position" 
                                        value="left" 
                                        {{ old('logo_position', $logoPosition) == 'left' ? 'checked' : '' }}
                                        class="form-radio text-blue-600"
                                    >
                                    <span class="ml-2">Esquerda</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input 
                                        type="radio" 
                                        name="logo_position" 
                                        value="center" 
                                        {{ old('logo_position', $logoPosition) == 'center' ? 'checked' : '' }}
                                        class="form-radio text-blue-600"
                                    >
                                    <span class="ml-2">Centro</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input 
                                        type="radio" 
                                        name="logo_position" 
                                        value="right" 
                                        {{ old('logo_position', $logoPosition) == 'right' ? 'checked' : '' }}
                                        class="form-radio text-blue-600"
                                    >
                                    <span class="ml-2">Direita</span>
                                </label>
                            </div>
                            @error('logo_position')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Logo -->
                        @if($siteLogo)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Logo Atual
                                </label>
                                <div class="flex items-center space-x-4">
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                        <img 
                                            src="{{ Storage::url($siteLogo) }}" 
                                            alt="Logo Atual" 
                                            class="h-16 object-contain"
                                        >
                                    </div>
                                    <form action="{{ route('admin.site-settings.delete-logo') }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover a logo?');">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium"
                                        >
                                            Remover Logo
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        <!-- Upload New Logo -->
                        <div>
                            <label for="site_logo" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $siteLogo ? 'Substituir Logo' : 'Upload Logo' }}
                            </label>
                            <input 
                                type="file" 
                                name="site_logo" 
                                id="site_logo" 
                                accept="image/*"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            >
                            <p class="mt-1 text-sm text-gray-500">
                                Formatos aceitos: JPEG, PNG, JPG, GIF, SVG. Tamanho máximo: 2MB. Recomendado: altura de 40-60px para melhor visualização.
                            </p>
                            @error('site_logo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Favicon -->
                        @if($favicon)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Favicon Atual
                                </label>
                                <div class="flex items-center space-x-4">
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                        <img 
                                            src="{{ Storage::url($favicon) }}" 
                                            alt="Favicon Atual" 
                                            class="h-8 w-8 object-contain"
                                        >
                                    </div>
                                    <form action="{{ route('admin.site-settings.delete-favicon') }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover o favicon?');">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium"
                                        >
                                            Remover Favicon
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        <!-- Upload New Favicon -->
                        <div>
                            <label for="favicon" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $favicon ? 'Substituir Favicon' : 'Upload Favicon' }}
                            </label>
                            <input 
                                type="file" 
                                name="favicon" 
                                id="favicon" 
                                accept=".ico,.png,.jpg,.jpeg,.gif"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            >
                            <p class="mt-1 text-sm text-gray-500">
                                Formatos aceitos: ICO, PNG, JPG, GIF. Tamanho máximo: 1MB. Recomendado: 32x32px ou 16x16px.
                            </p>
                            @error('favicon')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                        <a 
                            href="{{ route('dashboard') }}" 
                            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition font-medium"
                        >
                            Cancelar
                        </a>
                        <button 
                            type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium"
                        >
                            Salvar Configurações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
