<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-neutral-50">
    <!-- Header/Navigation -->
    <nav class="bg-white shadow-md border-b border-neutral-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <h1 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-primary-700 to-primary-900 bg-clip-text text-transparent">
                        Apostolado da Oração
                    </h1>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-neutral-700 hover:text-primary-700 px-3 py-2 rounded-md text-sm font-medium transition">
                        Home
                    </a>
                    <a href="{{ route('public.prayer-intentions') }}" class="text-neutral-700 hover:text-primary-700 px-3 py-2 rounded-md text-sm font-medium transition">
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

                <!-- Mobile menu button -->
                <div class="flex items-center lg:hidden">
                    <button type="button" id="mobile-menu-button" class="text-neutral-700 hover:text-primary-700 focus:outline-none focus:text-primary-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path id="menu-icon-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path id="menu-icon-close" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden bg-white border-t border-neutral-200">
            <div class="px-4 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block text-neutral-700 hover:text-primary-700 hover:bg-neutral-50 px-3 py-2 rounded-md text-base font-medium transition">
                    Home
                </a>
                <a href="{{ route('public.prayer-intentions') }}" class="block text-neutral-700 hover:text-primary-700 hover:bg-neutral-50 px-3 py-2 rounded-md text-base font-medium transition">
                    Intenções de Oração
                </a>
                <a href="{{ route('public.articles') }}" class="block text-neutral-700 hover:text-primary-700 hover:bg-neutral-50 px-3 py-2 rounded-md text-base font-medium transition">
                    Artigos
                </a>
                <a href="{{ route('public.events') }}" class="block text-neutral-700 hover:text-primary-700 hover:bg-neutral-50 px-3 py-2 rounded-md text-base font-medium transition">
                    Eventos
                </a>
                <a href="{{ route('public.media-gallery') }}" class="block text-neutral-700 hover:text-primary-700 hover:bg-neutral-50 px-3 py-2 rounded-md text-base font-medium transition">
                    Galeria
                </a>
                <a href="{{ route('member.register') }}" class="block bg-gradient-to-r from-primary-600 to-primary-700 text-white hover:from-primary-700 hover:to-primary-800 px-3 py-2 rounded-lg text-base font-semibold shadow-lg transition text-center">
                    Cadastrar-se
                </a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="block text-neutral-700 hover:text-primary-700 hover:bg-neutral-50 px-3 py-2 rounded-md text-base font-medium transition">
                        Painel
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block text-neutral-700 hover:text-primary-700 hover:bg-neutral-50 px-3 py-2 rounded-md text-base font-medium transition">
                        Entrar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Slider Section -->
    @if($sliders->count() > 0)
    <div class="relative overflow-hidden bg-neutral-900 h-[400px] sm:h-[500px] lg:h-[600px]">
        <div class="slider-container relative h-full">
            @foreach($sliders as $index => $slider)
            <div class="slider-item absolute inset-0 transition-opacity duration-1000 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" data-slide="{{ $index }}">
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ Storage::url($slider->image) }}');">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
                </div>
                <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center">
                    <div class="max-w-2xl">
                        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white mb-4 sm:mb-6 drop-shadow-2xl">
                            {{ $slider->title }}
                        </h2>
                        @if($slider->description)
                        <p class="text-base sm:text-lg lg:text-xl text-white/90 mb-6 sm:mb-8 drop-shadow-lg">
                            {{ $slider->description }}
                        </p>
                        @endif
                        @if($slider->button_text && $slider->button_link)
                        <a href="{{ $slider->button_link }}" class="inline-block bg-gradient-to-r from-gold-500 to-gold-600 text-white hover:from-gold-600 hover:to-gold-700 px-6 sm:px-8 py-3 sm:py-4 rounded-lg text-base sm:text-lg font-bold shadow-2xl transition transform hover:scale-105">
                            {{ $slider->button_text }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Slider Controls -->
        @if($sliders->count() > 1)
        <div class="absolute bottom-4 sm:bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-2 sm:space-x-3">
            @foreach($sliders as $index => $slider)
            <button onclick="goToSlide({{ $index }})" class="slider-dot w-2 h-2 sm:w-3 sm:h-3 rounded-full {{ $index === 0 ? 'bg-gold-500' : 'bg-white/50' }} hover:bg-gold-500 transition"></button>
            @endforeach
        </div>
        <button onclick="prevSlide()" class="absolute left-2 sm:left-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white p-2 sm:p-3 rounded-full backdrop-blur-sm transition">
            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <button onclick="nextSlide()" class="absolute right-2 sm:right-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white p-2 sm:p-3 rounded-full backdrop-blur-sm transition">
            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
        @endif
    </div>
    @endif

    <!-- Features Section -->
    <div class="py-12 sm:py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-16">
                <h3 class="text-3xl sm:text-4xl font-extrabold text-neutral-900 mb-4">
                    O que é o Apostolado da Oração?
                </h3>
                <p class="text-base sm:text-lg text-neutral-600">
                    Uma rede mundial de oração unida ao Coração de Jesus
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                <div class="bg-gradient-to-br from-primary-50 to-white p-6 sm:p-8 rounded-2xl shadow-lg hover:shadow-xl transition border border-primary-100">
                    <div class="text-4xl sm:text-5xl mb-4">🙏</div>
                    <h4 class="text-xl sm:text-2xl font-bold text-primary-800 mb-3">Oração</h4>
                    <p class="text-sm sm:text-base text-neutral-700">
                        Rezamos mensalmente pelas intenções do Papa Francisco, unindo nossos corações em oração.
                    </p>
                </div>
                <div class="bg-gradient-to-br from-gold-50 to-white p-6 sm:p-8 rounded-2xl shadow-lg hover:shadow-xl transition border border-gold-100">
                    <div class="text-4xl sm:text-5xl mb-4">🌍</div>
                    <h4 class="text-xl sm:text-2xl font-bold text-gold-800 mb-3">Missão</h4>
                    <p class="text-sm sm:text-base text-neutral-700">
                        Colaboramos na missão evangelizadora da Igreja, levando o amor de Cristo ao mundo.
                    </p>
                </div>
                <div class="bg-gradient-to-br from-primary-50 to-white p-6 sm:p-8 rounded-2xl shadow-lg hover:shadow-xl transition border border-primary-100">
                    <div class="text-4xl sm:text-5xl mb-4">❤️</div>
                    <h4 class="text-xl sm:text-2xl font-bold text-primary-800 mb-3">Coração de Jesus</h4>
                    <p class="text-sm sm:text-base text-neutral-700">
                        Vivemos nossa espiritualidade centrada no Sagrado Coração de Jesus.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- News/Articles Section -->
    @if($articles->count() > 0)
    <div id="noticias" class="py-12 sm:py-16 lg:py-24 bg-neutral-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-16">
                <h3 class="text-3xl sm:text-4xl font-extrabold text-neutral-900 mb-4">
                    Notícias e Artigos
                </h3>
                <p class="text-base sm:text-lg text-neutral-600">
                    Acompanhe as novidades e reflexões
                </p>
            </div>
            
            <div class="news-slider-container relative">
                <div class="overflow-hidden">
                    <div class="news-slider flex transition-transform duration-500 ease-in-out" style="transform: translateX(0)">
                        @foreach($articles as $article)
                        <div class="news-slide flex-shrink-0 w-full md:w-1/2 lg:w-1/3 px-2 sm:px-3">
                            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition overflow-hidden h-full border border-neutral-200">
                                @if($article->featured_image)
                                <div class="h-40 sm:h-48 bg-cover bg-center" style="background-image: url('{{ Storage::url($article->featured_image) }}');"></div>
                                @else
                                <div class="h-40 sm:h-48 bg-gradient-to-br from-primary-600 to-primary-800"></div>
                                @endif
                                <div class="p-4 sm:p-6">
                                    @if($article->category)
                                    <span class="inline-block px-2 sm:px-3 py-1 bg-gold-100 text-gold-800 text-xs font-semibold rounded-full mb-2 sm:mb-3">
                                        {{ $article->category }}
                                    </span>
                                    @endif
                                    <h4 class="text-lg sm:text-xl font-bold text-neutral-900 mb-2 sm:mb-3 line-clamp-2">
                                        {{ $article->title }}
                                    </h4>
                                    @if($article->excerpt)
                                    <p class="text-sm sm:text-base text-neutral-600 mb-3 sm:mb-4 line-clamp-3">
                                        {{ $article->excerpt }}
                                    </p>
                                    @endif
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs sm:text-sm text-neutral-500">
                                            {{ $article->published_at->format('d/m/Y') }}
                                        </span>
                                        <a href="{{ route('public.article.show', $article) }}" class="text-primary-600 hover:text-primary-700 font-semibold text-xs sm:text-sm transition">
                                            Ler mais →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                @if($articles->count() > 3)
                <button onclick="prevNews()" class="absolute left-0 top-1/2 transform -translate-y-1/2 -translate-x-2 sm:-translate-x-4 bg-white hover:bg-neutral-100 text-neutral-800 p-2 sm:p-3 rounded-full shadow-xl transition z-10">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button onclick="nextNews()" class="absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-2 sm:translate-x-4 bg-white hover:bg-neutral-100 text-neutral-800 p-2 sm:p-3 rounded-full shadow-xl transition z-10">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                @endif
            </div>

            <div class="text-center mt-8 sm:mt-12">
                <a href="{{ route('public.articles') }}" class="inline-block bg-gradient-to-r from-primary-600 to-primary-700 text-white hover:from-primary-700 hover:to-primary-800 px-6 sm:px-8 py-3 sm:py-4 rounded-lg text-base sm:text-lg font-bold shadow-xl transition transform hover:scale-105">
                    Ver Todos os Artigos
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Call to Action -->
    <div class="py-12 sm:py-16 lg:py-20 bg-gradient-to-r from-primary-700 via-primary-600 to-primary-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">
                Junte-se a Nós em Oração
            </h3>
            <p class="text-lg sm:text-xl text-primary-100 mb-6 sm:mb-8">
                Faça parte desta rede mundial de oração
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-3 sm:gap-4">
                <a href="{{ route('member.register') }}" class="bg-gold-500 text-white hover:bg-gold-600 px-6 sm:px-8 py-3 sm:py-4 rounded-lg text-base sm:text-lg font-bold shadow-2xl transition transform hover:scale-105">
                    Cadastre-se Agora
                </a>
                @guest
                    <a href="{{ route('login') }}" class="bg-white text-primary-700 hover:bg-neutral-100 px-6 sm:px-8 py-3 sm:py-4 rounded-lg text-base sm:text-lg font-bold shadow-2xl transition transform hover:scale-105">
                        Já é Membro? Entrar
                    </a>
                @else
                    <a href="{{ url('/dashboard') }}" class="bg-white text-primary-700 hover:bg-neutral-100 px-6 sm:px-8 py-3 sm:py-4 rounded-lg text-base sm:text-lg font-bold shadow-2xl transition transform hover:scale-105">
                        Ir para o Painel
                    </a>
                @endguest
            </div>
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

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIconOpen = document.getElementById('menu-icon-open');
        const menuIconClose = document.getElementById('menu-icon-close');

        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            menuIconOpen.classList.toggle('hidden');
            menuIconClose.classList.toggle('hidden');
        });

        // Hero Slider
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slider-item');
        const dots = document.querySelectorAll('.slider-dot');
        const totalSlides = slides.length;

        function showSlide(n) {
            slides.forEach((slide, index) => {
                slide.classList.remove('opacity-100');
                slide.classList.add('opacity-0');
                if (dots[index]) {
                    dots[index].classList.remove('bg-gold-500');
                    dots[index].classList.add('bg-white/50');
                }
            });

            currentSlide = (n + totalSlides) % totalSlides;
            slides[currentSlide].classList.remove('opacity-0');
            slides[currentSlide].classList.add('opacity-100');
            if (dots[currentSlide]) {
                dots[currentSlide].classList.remove('bg-white/50');
                dots[currentSlide].classList.add('bg-gold-500');
            }
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

        function prevSlide() {
            showSlide(currentSlide - 1);
        }

        function goToSlide(n) {
            showSlide(n);
        }

        // Auto-advance slides
        if (totalSlides > 1) {
            setInterval(nextSlide, 5000);
        }

        // News Slider
        let currentNewsSlide = 0;
        const newsSlider = document.querySelector('.news-slider');
        const newsSlides = document.querySelectorAll('.news-slide');
        const totalNewsSlides = newsSlides.length;
        let slidesToShow = window.innerWidth >= 1024 ? 3 : window.innerWidth >= 768 ? 2 : 1;

        function updateNewsSlider() {
            const slideWidth = 100 / slidesToShow;
            newsSlider.style.transform = `translateX(-${currentNewsSlide * slideWidth}%)`;
        }

        function nextNews() {
            if (currentNewsSlide < totalNewsSlides - slidesToShow) {
                currentNewsSlide++;
                updateNewsSlider();
            }
        }

        function prevNews() {
            if (currentNewsSlide > 0) {
                currentNewsSlide--;
                updateNewsSlider();
            }
        }

        // Update slides to show on resize
        window.addEventListener('resize', () => {
            slidesToShow = window.innerWidth >= 1024 ? 3 : window.innerWidth >= 768 ? 2 : 1;
            currentNewsSlide = Math.min(currentNewsSlide, Math.max(0, totalNewsSlides - slidesToShow));
            updateNewsSlider();
        });
    </script>
</body>
</html>
