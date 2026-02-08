<x-admin-layout>

    <div class="p-4 lg:p-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
            @endif

            <!-- Current Status -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Status Atual do Armazenamento</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Sistema de Armazenamento Ativo:</p>
                            <p class="text-lg font-bold">{{ strtoupper($currentDisk) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status da Conexão:</p>
                            <div class="flex items-center">
                                @if($connectionStatus['success'])
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                        ✓ Conectado
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">
                                        ✗ Erro
                                    </span>
                                @endif
                            </div>
                            @if(!$connectionStatus['success'])
                                <p class="text-sm text-red-600 mt-2">{{ $connectionStatus['message'] }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuration Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-6">Configurar Armazenamento</h3>

                    <form method="POST" action="{{ route('admin.storage-settings.update') }}">
                        @csrf
                        @method('PUT')

                        <!-- Filesystem Disk -->
                        <div class="mb-6">
                            <label for="filesystem_disk" class="block text-sm font-medium text-gray-700 mb-2">
                                Sistema de Armazenamento
                            </label>
                            <select name="filesystem_disk" id="filesystem_disk" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" onchange="toggleMinioFields()">
                                <option value="public" {{ $currentDisk === 'public' ? 'selected' : '' }}>Local (Public)</option>
                                <option value="local" {{ $currentDisk === 'local' ? 'selected' : '' }}>Local (Private)</option>
                                <option value="minio" {{ $currentDisk === 'minio' ? 'selected' : '' }}>MinIO</option>
                                <option value="s3" {{ $currentDisk === 's3' ? 'selected' : '' }}>Amazon S3</option>
                            </select>
                            <p class="mt-1 text-sm text-gray-500">
                                Selecione o sistema de armazenamento de arquivos
                            </p>
                        </div>

                        <!-- MinIO Configuration (only shown when MinIO is selected) -->
                        <div id="minio-config" class="{{ $currentDisk !== 'minio' ? 'hidden' : '' }}">
                            <div class="border-t border-gray-200 pt-6 mb-6">
                                <h4 class="text-md font-semibold mb-4 text-gray-700">Configuração do MinIO</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Endpoint -->
                                    <div>
                                        <label for="minio_endpoint" class="block text-sm font-medium text-gray-700 mb-2">
                                            Endpoint do MinIO
                                        </label>
                                        <input type="text" name="minio_endpoint" id="minio_endpoint" 
                                            value="{{ config('filesystems.disks.minio.endpoint', 'http://minio:9000') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="http://minio:9000">
                                        <p class="mt-1 text-xs text-gray-500">URL do servidor MinIO</p>
                                    </div>

                                    <!-- Bucket -->
                                    <div>
                                        <label for="minio_bucket" class="block text-sm font-medium text-gray-700 mb-2">
                                            Bucket
                                        </label>
                                        <input type="text" name="minio_bucket" id="minio_bucket" 
                                            value="{{ config('filesystems.disks.minio.bucket', 'apostolado') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="apostolado">
                                        <p class="mt-1 text-xs text-gray-500">Nome do bucket</p>
                                    </div>

                                    <!-- Access Key -->
                                    <div>
                                        <label for="minio_access_key" class="block text-sm font-medium text-gray-700 mb-2">
                                            Access Key
                                        </label>
                                        <input type="text" name="minio_access_key" id="minio_access_key" 
                                            value="{{ config('filesystems.disks.minio.key', '') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="minioadmin">
                                        <p class="mt-1 text-xs text-gray-500">Chave de acesso do MinIO</p>
                                    </div>

                                    <!-- Secret Key -->
                                    <div>
                                        <label for="minio_secret_key" class="block text-sm font-medium text-gray-700 mb-2">
                                            Secret Key
                                        </label>
                                        <input type="password" name="minio_secret_key" id="minio_secret_key" 
                                            value="{{ config('filesystems.disks.minio.secret', '') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="••••••••">
                                        <p class="mt-1 text-xs text-gray-500">Chave secreta do MinIO</p>
                                    </div>

                                    <!-- Region -->
                                    <div>
                                        <label for="minio_region" class="block text-sm font-medium text-gray-700 mb-2">
                                            Região
                                        </label>
                                        <input type="text" name="minio_region" id="minio_region" 
                                            value="{{ config('filesystems.disks.minio.region', 'us-east-1') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="us-east-1">
                                        <p class="mt-1 text-xs text-gray-500">Região do MinIO</p>
                                    </div>

                                    <!-- Public URL -->
                                    <div>
                                        <label for="minio_url" class="block text-sm font-medium text-gray-700 mb-2">
                                            URL Pública
                                        </label>
                                        <input type="text" name="minio_url" id="minio_url" 
                                            value="{{ config('filesystems.disks.minio.url', 'http://localhost:9000/apostolado') }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="http://localhost:9000/apostolado">
                                        <p class="mt-1 text-xs text-gray-500">URL pública para acessar os arquivos</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Information Alert -->
                        <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded">
                            <p class="text-sm">
                                <strong>⚠️ Importante:</strong> Após salvar as configurações, será necessário reiniciar a aplicação para que as mudanças tenham efeito.
                            </p>
                        </div>

                        <!-- Documentation Link -->
                        <div class="mb-6 bg-gray-50 border border-gray-200 px-4 py-3 rounded">
                            <p class="text-sm text-gray-700">
                                📚 Para instruções detalhadas sobre como configurar o MinIO, consulte o arquivo 
                                <a href="https://github.com/josemaeldon/apostolado/blob/main/MINIO-SETUP.md" target="_blank" class="text-blue-600 hover:text-blue-800 underline">
                                    MINIO-SETUP.md
                                </a>
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between">
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-800">
                                Cancelar
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Salvar Configurações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleMinioFields() {
            const disk = document.getElementById('filesystem_disk').value;
            const minioConfig = document.getElementById('minio-config');
            
            if (disk === 'minio') {
                minioConfig.classList.remove('hidden');
            } else {
                minioConfig.classList.add('hidden');
            }
        }
    </script>
</x-admin-layout>
