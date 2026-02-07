<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $prayerIntention->title }} - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-neutral-50">
    <!-- Header/Navigation -->
    <nav class="bg-white shadow-md border-b border-neutral-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-primary-700 to-primary-900 bg-clip-text text-transparent">
                        Apostolado da Oração
                    </h1>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-neutral-700 hover:text-primary-700 px-3 py-2 rounded-md text-sm font-medium transition">
                        Home
                    </a>
                    <a href="{{ route('public.prayer-intentions') }}" class="text-primary-700 border-b-2 border-primary-700 px-3 py-2 text-sm font-medium">
                        Intenções de Oração
                    </a>
                    <a href="{{ route('public.articles') }}" class="text-neutral-700 hover:text-primary-700 px-3 py-2 rounded-md text-sm font-medium transition">
                        Artigos
                    </a>
                    <a href="{{ route('public.events') }}" class="text-neutral-700 hover:text-primary-700 px-3 py-2 rounded-md text-sm font-medium transition">
                        Eventos
                    </a>
                    <a href="{{ route('public.media-gallery') }}" class="text-neutral-700 hover:text-primary-700 px-3 py-2 rounded-md text-sm font-medium transition">
                        Galeria
                    </a>
                    <a href="{{ route('member.register') }}" class="bg-gradient-to-r from-primary-600 to-primary-700 text-white hover:from-primary-700 hover:to-primary-800 px-6 py-2 rounded-lg text-sm font-semibold shadow-lg transition transform hover:scale-105">
                        Cadastrar-se
                    </a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-neutral-700 hover:text-primary-700 px-3 py-2 rounded-md text-sm font-medium transition">
                            Painel
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-neutral-700 hover:text-primary-700 px-3 py-2 rounded-md text-sm font-medium transition">
                            Entrar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="py-16 bg-neutral-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('public.prayer-intentions') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium mb-8 transition group">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Voltar às Intenções
            </a>

            <article class="bg-white rounded-2xl shadow-xl overflow-hidden border border-neutral-200">
                @if($prayerIntention->image)
                <div class="h-96 bg-cover bg-center" style="background-image: url('{{ Storage::url($prayerIntention->image) }}');"></div>
                @else
                <div class="h-96 bg-gradient-to-br from-primary-600 via-primary-700 to-gold-600 flex items-center justify-center">
                    <div class="text-center text-white">
                        <div class="text-8xl mb-4">🙏</div>
                        <p class="text-2xl font-bold">Intenção de Oração</p>
                    </div>
                </div>
                @endif

                <div class="p-8 lg:p-12">
                    <div class="flex items-center space-x-2 mb-6">
                        <span class="inline-block px-4 py-2 bg-gold-100 text-gold-800 text-sm font-bold rounded-full">
                            {{ $prayerIntention->month }}
                        </span>
                        <span class="inline-block px-4 py-2 bg-primary-100 text-primary-800 text-sm font-bold rounded-full">
                            {{ $prayerIntention->year }}
                        </span>
                    </div>

                    <h1 class="text-4xl lg:text-5xl font-extrabold text-neutral-900 mb-6 leading-tight">
                        {{ $prayerIntention->title }}
                    </h1>

                    <div class="prose prose-lg max-w-none text-neutral-700 leading-relaxed">
                        {!! nl2br(e($prayerIntention->description)) !!}
                    </div>

                    @if($prayerIntention->video_url)
                    <div class="mt-8 border-t border-neutral-200 pt-8">
                        <h3 class="text-2xl font-bold text-neutral-900 mb-4">Vídeo do Papa Francisco</h3>
                        <div class="aspect-video rounded-xl overflow-hidden shadow-lg">
                            @if(Str::contains($prayerIntention->video_url, 'youtube.com') || Str::contains($prayerIntention->video_url, 'youtu.be'))
                                @php
                                    $videoId = null;
                                    if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $prayerIntention->video_url, $matches)) {
                                        $videoId = $matches[1];
                                    } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $prayerIntention->video_url, $matches)) {
                                        $videoId = $matches[1];
                                    }
                                @endphp
                                @if($videoId)
                                    <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                @else
                                    <a href="{{ $prayerIntention->video_url }}" target="_blank" class="flex items-center justify-center h-full bg-neutral-900 text-white hover:bg-neutral-800 transition">
                                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
                                        </svg>
                                    </a>
                                @endif
                            @else
                                <a href="{{ $prayerIntention->video_url }}" target="_blank" class="flex items-center justify-center h-full bg-neutral-900 text-white hover:bg-neutral-800 transition">
                                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="mt-8 pt-8 border-t border-neutral-200">
                        <a href="{{ route('public.prayer-intentions') }}" class="inline-flex items-center bg-gradient-to-r from-primary-600 to-primary-700 text-white hover:from-primary-700 hover:to-primary-800 px-6 py-3 rounded-lg font-semibold shadow-lg transition transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Voltar às Intenções
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-neutral-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h4 class="text-xl font-bold mb-4 text-gold-400">Apostolado da Oração</h4>
                    <p class="text-neutral-400">
                        Rede Mundial de Oração do Papa
                    </p>
                </div>
                <div>
                    <h4 class="text-xl font-bold mb-4 text-gold-400">Links</h4>
                    <ul class="space-y-2 text-neutral-400">
                        <li><a href="{{ route('home') }}" class="hover:text-gold-400 transition">Home</a></li>
                        <li><a href="{{ route('public.prayer-intentions') }}" class="hover:text-gold-400 transition">Intenções de Oração</a></li>
                        <li><a href="{{ route('public.articles') }}" class="hover:text-gold-400 transition">Artigos</a></li>
                        <li><a href="{{ route('public.events') }}" class="hover:text-gold-400 transition">Eventos</a></li>
                        <li><a href="{{ route('public.media-gallery') }}" class="hover:text-gold-400 transition">Galeria</a></li>
                        <li><a href="{{ route('member.register') }}" class="hover:text-gold-400 transition">Cadastrar-se</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xl font-bold mb-4 text-gold-400">Contato</h4>
                    <p class="text-neutral-400">
                        Email: contato@apostoladodaoracao.org.br<br>
                        Tel: (11) 1234-5678
                    </p>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-neutral-800 text-center text-neutral-500">
                <p>&copy; {{ date('Y') }} Apostolado da Oração. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html>
