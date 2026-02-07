<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Intenções de Oração - {{ config('app.name') }}</title>
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

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary-700 via-primary-600 to-primary-700 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-5xl font-extrabold text-white mb-4 drop-shadow-lg">
                Intenções de Oração
            </h2>
            <p class="text-xl text-primary-100">
                Conheça as intenções mensais do Papa Francisco
            </p>
        </div>
    </div>

    <!-- Filters -->
    @if(request()->has('year') || request()->has('month'))
    <div class="bg-white border-b border-neutral-200 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    @if(request()->has('year'))
                    <span class="inline-flex items-center px-4 py-2 bg-primary-100 text-primary-800 rounded-full text-sm font-medium">
                        Ano: {{ request('year') }}
                        <a href="{{ route('public.prayer-intentions', array_diff_key(request()->all(), ['year' => ''])) }}" class="ml-2 text-primary-600 hover:text-primary-800">×</a>
                    </span>
                    @endif
                    @if(request()->has('month'))
                    <span class="inline-flex items-center px-4 py-2 bg-primary-100 text-primary-800 rounded-full text-sm font-medium">
                        Mês: {{ \Carbon\Carbon::create()->month(request('month'))->locale('pt_BR')->translatedFormat('F') }}
                        <a href="{{ route('public.prayer-intentions', array_diff_key(request()->all(), ['month' => ''])) }}" class="ml-2 text-primary-600 hover:text-primary-800">×</a>
                    </span>
                    @endif
                </div>
                <a href="{{ route('public.prayer-intentions') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                    Limpar filtros
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Prayer Intentions Grid -->
    <div class="py-16 bg-neutral-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($prayerIntentions->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($prayerIntentions as $intention)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition overflow-hidden border border-neutral-200 transform hover:-translate-y-1 duration-300">
                    @if($intention->image)
                    <div class="h-56 bg-cover bg-center" style="background-image: url('{{ Storage::url($intention->image) }}');"></div>
                    @else
                    <div class="h-56 bg-gradient-to-br from-primary-600 via-primary-700 to-gold-600 flex items-center justify-center">
                        <div class="text-center text-white">
                            <div class="text-6xl mb-2">🙏</div>
                        </div>
                    </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center space-x-2 mb-3">
                            <span class="inline-block px-3 py-1 bg-gold-100 text-gold-800 text-xs font-bold rounded-full">
                                {{ \Carbon\Carbon::create($intention->year, $intention->month)->locale('pt_BR')->translatedFormat('F') }}
                            </span>
                            <span class="inline-block px-3 py-1 bg-primary-100 text-primary-800 text-xs font-bold rounded-full">
                                {{ $intention->year }}
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 mb-3 line-clamp-2">
                            {{ $intention->title }}
                        </h3>
                        <p class="text-neutral-600 mb-4 line-clamp-3">
                            {{ Str::limit($intention->description, 150) }}
                        </p>
                        <a href="{{ route('public.prayer-intention.show', $intention) }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold text-sm transition group">
                            Ler mais
                            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $prayerIntentions->links() }}
            </div>
            @else
            <div class="text-center py-16">
                <div class="text-6xl mb-4">🙏</div>
                <h3 class="text-2xl font-bold text-neutral-900 mb-2">Nenhuma intenção encontrada</h3>
                <p class="text-neutral-600">Não há intenções de oração disponíveis no momento.</p>
            </div>
            @endif
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
