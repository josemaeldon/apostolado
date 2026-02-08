<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Galeria de Mídia - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-neutral-50">
    <x-public.navigation />

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary-700 via-primary-600 to-primary-700 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-5xl font-extrabold text-white mb-4 drop-shadow-lg">
                Galeria de Mídia
            </h2>
            <p class="text-xl text-primary-100">
                Fotos e vídeos de nossos eventos e celebrações
            </p>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white border-b border-neutral-200 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center space-x-4">
                <a href="{{ route('public.media-gallery') }}" class="px-6 py-2 rounded-full font-medium transition {{ !request('type') ? 'bg-primary-600 text-white' : 'bg-neutral-200 text-neutral-700 hover:bg-neutral-300' }}">
                    Todos
                </a>
                <a href="{{ route('public.media-gallery', ['type' => 'image']) }}" class="px-6 py-2 rounded-full font-medium transition {{ request('type') === 'image' ? 'bg-primary-600 text-white' : 'bg-neutral-200 text-neutral-700 hover:bg-neutral-300' }}">
                    Imagens
                </a>
                <a href="{{ route('public.media-gallery', ['type' => 'video']) }}" class="px-6 py-2 rounded-full font-medium transition {{ request('type') === 'video' ? 'bg-primary-600 text-white' : 'bg-neutral-200 text-neutral-700 hover:bg-neutral-300' }}">
                    Vídeos
                </a>
            </div>
        </div>
    </div>

    <!-- Media Grid -->
    <div class="py-16 bg-neutral-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($mediaItems->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($mediaItems as $media)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition overflow-hidden border border-neutral-200 transform hover:-translate-y-1 duration-300 cursor-pointer" onclick="openModal('{{ $media->id }}')">
                    <div class="relative h-64">
                        @if($media->type === 'image')
                            @if($media->file_path)
                                <div class="h-full bg-cover bg-center" style="background-image: url('{{ Storage::url($media->file_path) }}');"></div>
                            @else
                                <div class="h-full bg-gradient-to-br from-neutral-300 to-neutral-400 flex items-center justify-center">
                                    <svg class="w-20 h-20 text-neutral-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                            <span class="absolute top-3 right-3 px-3 py-1 bg-primary-600 text-white text-xs font-bold rounded-full shadow-lg">
                                Imagem
                            </span>
                        @elseif($media->type === 'video')
                            @if($media->thumbnail)
                                <div class="h-full bg-cover bg-center" style="background-image: url('{{ Storage::url($media->thumbnail) }}');"></div>
                            @else
                                <div class="h-full bg-gradient-to-br from-neutral-700 to-neutral-900 flex items-center justify-center">
                                    <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
                                    </svg>
                                </div>
                            @endif
                            <span class="absolute top-3 right-3 px-3 py-1 bg-gold-600 text-white text-xs font-bold rounded-full shadow-lg">
                                Vídeo
                            </span>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="bg-white/90 rounded-full p-4 shadow-xl">
                                    <svg class="w-12 h-12 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
                                    </svg>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-neutral-900 line-clamp-1">
                            {{ $media->title }}
                        </h3>
                    </div>
                </div>

                <!-- Modal for this media item -->
                <div id="modal-{{ $media->id }}" class="fixed inset-0 bg-black/90 z-50 hidden items-center justify-center p-4" onclick="closeModal('{{ $media->id }}')">
                    <div class="max-w-6xl w-full" onclick="event.stopPropagation()">
                        <div class="flex justify-end mb-4">
                            <button onclick="closeModal('{{ $media->id }}')" class="text-white hover:text-neutral-300 transition">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        @if($media->type === 'image')
                            @if($media->file_path)
                                <img src="{{ Storage::url($media->file_path) }}" alt="{{ $media->title }}" class="w-full h-auto rounded-lg shadow-2xl">
                            @else
                                <div class="w-full h-96 bg-gradient-to-br from-neutral-300 to-neutral-400 flex items-center justify-center rounded-lg shadow-2xl">
                                    <div class="text-center">
                                        <svg class="w-32 h-32 text-neutral-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                        </svg>
                                        <p class="text-neutral-600 font-medium">Imagem não disponível</p>
                                    </div>
                                </div>
                            @endif
                        @elseif($media->type === 'video')
                            @if($media->file_path)
                                <video controls class="w-full h-auto rounded-lg shadow-2xl">
                                    <source src="{{ Storage::url($media->file_path) }}" type="video/mp4">
                                    Seu navegador não suporta a reprodução de vídeo.
                                </video>
                            @elseif($media->url && preg_match('/^https:\/\/(www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})/', $media->url, $matches))
                                @php
                                    $embedUrl = 'https://www.youtube.com/embed/' . $matches[2];
                                @endphp
                                <div class="w-full rounded-lg shadow-2xl overflow-hidden" style="aspect-ratio: 16/9;">
                                    <iframe src="{{ $embedUrl }}" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            @else
                                <div class="w-full h-96 bg-gradient-to-br from-neutral-700 to-neutral-900 flex items-center justify-center rounded-lg shadow-2xl">
                                    <div class="text-center">
                                        <svg class="w-32 h-32 text-white mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
                                        </svg>
                                        <p class="text-white font-medium">Vídeo não disponível</p>
                                    </div>
                                </div>
                            @endif
                        @endif
                        <div class="bg-white rounded-lg p-6 mt-4">
                            <h3 class="text-2xl font-bold text-neutral-900 mb-2">{{ $media->title }}</h3>
                            @if($media->description)
                            <p class="text-neutral-700">{{ $media->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $mediaItems->links() }}
            </div>
            @else
            <div class="text-center py-16">
                <div class="text-6xl mb-4">🖼️</div>
                <h3 class="text-2xl font-bold text-neutral-900 mb-2">Nenhuma mídia encontrada</h3>
                <p class="text-neutral-600">Não há itens de mídia disponíveis no momento.</p>
            </div>
            @endif
        </div>
    </div>

    <x-public.footer />

    <script>
        function openModal(id) {
            const modal = document.getElementById('modal-' + id);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            const modal = document.getElementById('modal-' + id);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
            
            const video = modal.querySelector('video');
            if (video) {
                video.pause();
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('[id^="modal-"]').forEach(modal => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    const video = modal.querySelector('video');
                    if (video) {
                        video.pause();
                    }
                });
                document.body.style.overflow = 'auto';
            }
        });
    </script>
</body>
</html>
