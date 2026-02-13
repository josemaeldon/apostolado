<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    
    <!-- Favicon -->
    @php
        $favicon = \App\Models\SiteSetting::get('favicon');
    @endphp
    @if($favicon)
        <link rel="icon" type="image/x-icon" href="{{ Storage::url($favicon) }}">
        <link rel="shortcut icon" href="{{ Storage::url($favicon) }}">
    @endif
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-neutral-50">
    <!-- Header/Navigation -->
    <x-public.navigation />

    <!-- Dynamic Content: Above Slider -->
    @if(isset($positions['above_slider']) && count($positions['above_slider']) > 0)
        @include('partials.dynamic-content', ['items' => $positions['above_slider']])
    @endif

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
                    <div class="max-w-2xl flex flex-col justify-center h-full py-8 sm:py-12">
                        <div class="space-y-4 sm:space-y-6">
                            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white drop-shadow-2xl">
                                {{ $slider->title }}
                            </h2>
                            @if($slider->description)
                            <p class="text-base sm:text-lg lg:text-xl text-white/90 drop-shadow-lg leading-relaxed">
                                {{ $slider->description }}
                            </p>
                            @endif
                        </div>
                        @if($slider->button_text && ($slider->button_link || $slider->linkable))
                        <div class="mt-6 sm:mt-8">
                            <a href="{{ $slider->effective_link }}" class="inline-block bg-gradient-to-r from-gold-500 to-gold-600 text-white hover:from-gold-600 hover:to-gold-700 px-6 sm:px-8 py-3 sm:py-4 rounded-lg text-base sm:text-lg font-bold shadow-2xl transition transform hover:scale-105">
                                {{ $slider->button_text }}
                            </a>
                        </div>
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

    <!-- Dynamic Content: Below Slider -->
    @if(isset($positions['below_slider']) && count($positions['below_slider']) > 0)
        @include('partials.dynamic-content', ['items' => $positions['below_slider']])
    @endif

    <!-- Dynamic Content: Above Features -->
    @if(isset($positions['above_features']) && count($positions['above_features']) > 0)
        @include('partials.dynamic-content', ['items' => $positions['above_features']])
    @endif

    <!-- Dynamic Content: Below Features -->
    @if(isset($positions['below_features']) && count($positions['below_features']) > 0)
        @include('partials.dynamic-content', ['items' => $positions['below_features']])
    @endif

    <!-- Dynamic Content: Above Events -->
    @if(isset($positions['above_events']) && count($positions['above_events']) > 0)
        @include('partials.dynamic-content', ['items' => $positions['above_events']])
    @endif

    <!-- Upcoming Events Section -->
    @if($events->count() > 0)
    <div class="py-12 sm:py-16 lg:py-24 bg-gradient-to-br from-primary-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-16">
                <h3 class="text-3xl sm:text-4xl font-extrabold text-neutral-900 mb-4">
                    Próximos Eventos
                </h3>
                <p class="text-base sm:text-lg text-neutral-600">
                    Participe dos nossos eventos e atividades
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($events as $event)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition overflow-hidden border border-primary-100">
                    @if($event->image)
                    <div class="h-48 bg-cover bg-center" style="background-image: url('{{ Storage::url($event->image) }}');"></div>
                    @else
                    <div class="h-48 bg-gradient-to-br from-gold-500 to-gold-700 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gold-600 font-semibold mb-3">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $event->start_date->format('d/m/Y') }}
                            @if($event->end_date && $event->end_date->format('Y-m-d') != $event->start_date->format('Y-m-d'))
                                - {{ $event->end_date->format('d/m/Y') }}
                            @endif
                        </div>
                        <h4 class="text-xl font-bold text-neutral-900 mb-3 line-clamp-2">
                            {{ $event->title }}
                        </h4>
                        @if($event->location)
                        <div class="flex items-center text-sm text-neutral-600 mb-3">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $event->location }}
                        </div>
                        @endif
                        @if($event->description)
                        <p class="text-neutral-600 mb-4 line-clamp-3 text-sm">
                            {{ Str::limit(strip_tags($event->description), 120) }}
                        </p>
                        @endif
                        <a href="{{ route('public.event.show', $event) }}" class="inline-block text-primary-600 hover:text-primary-700 font-semibold text-sm transition">
                            Ver detalhes →
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-8 sm:mt-12">
                <a href="{{ route('public.events') }}" class="inline-block bg-gradient-to-r from-gold-500 to-gold-600 text-white hover:from-gold-600 hover:to-gold-700 px-6 sm:px-8 py-3 sm:py-4 rounded-lg text-base sm:text-lg font-bold shadow-xl transition transform hover:scale-105">
                    Ver Todos os Eventos
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Dynamic Content: Below Events -->
    @if(isset($positions['below_events']) && count($positions['below_events']) > 0)
        @include('partials.dynamic-content', ['items' => $positions['below_events']])
    @endif

    <!-- Dynamic Content: Above Articles -->
    @if(isset($positions['above_articles']) && count($positions['above_articles']) > 0)
        @include('partials.dynamic-content', ['items' => $positions['above_articles']])
    @endif

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

    <!-- Dynamic Content: Below Articles -->
    @if(isset($positions['below_articles']) && count($positions['below_articles']) > 0)
        @include('partials.dynamic-content', ['items' => $positions['below_articles']])
    @endif

    <!-- Dynamic Content: Above CTA -->
    @if(isset($positions['above_cta']) && count($positions['above_cta']) > 0)
        @include('partials.dynamic-content', ['items' => $positions['above_cta']])
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

    <!-- Dynamic Content: Below CTA -->
    @if(isset($positions['below_cta']) && count($positions['below_cta']) > 0)
        @include('partials.dynamic-content', ['items' => $positions['below_cta']])
    @endif

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
        // Hero Slider
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slider-item');
        const dots = document.querySelectorAll('.slider-dot');
        const totalSlides = slides.length;
        let sliderInterval;
        let isSliderPaused = false;
        let touchStartX = 0;
        let touchEndX = 0;

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

        function startSlider() {
            if (totalSlides > 1 && !isSliderPaused) {
                sliderInterval = setInterval(nextSlide, 5000);
            }
        }

        function stopSlider() {
            if (sliderInterval) {
                clearInterval(sliderInterval);
                sliderInterval = null;
            }
        }

        // Auto-advance slides
        if (totalSlides > 1) {
            startSlider();
            
            // Pause on hover
            const sliderContainer = document.querySelector('.slider-container');
            if (sliderContainer) {
                sliderContainer.addEventListener('mouseenter', function() {
                    isSliderPaused = true;
                    stopSlider();
                });
                
                sliderContainer.addEventListener('mouseleave', function() {
                    isSliderPaused = false;
                    startSlider();
                });

                // Touch/swipe support for mobile
                sliderContainer.addEventListener('touchstart', function(e) {
                    touchStartX = e.changedTouches[0].screenX;
                }, false);

                sliderContainer.addEventListener('touchend', function(e) {
                    touchEndX = e.changedTouches[0].screenX;
                    handleSwipe();
                }, false);
            }
        }

        function handleSwipe() {
            const swipeThreshold = 50; // Minimum distance for swipe
            if (touchEndX < touchStartX - swipeThreshold) {
                // Swipe left - next slide
                nextSlide();
            }
            if (touchEndX > touchStartX + swipeThreshold) {
                // Swipe right - previous slide
                prevSlide();
            }
        }

        // News Slider
        let currentNewsSlide = 0;
        const newsSlider = document.querySelector('.news-slider');
        const newsSlides = document.querySelectorAll('.news-slide');
        const totalNewsSlides = newsSlides.length;
        let slidesToShow = window.innerWidth >= 1024 ? 3 : window.innerWidth >= 768 ? 2 : 1;
        let newsTouchStartX = 0;
        let newsTouchEndX = 0;

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

        // Touch/swipe support for news slider
        const newsSliderContainer = document.querySelector('.news-slider-container');
        if (newsSliderContainer && totalNewsSlides > 1) {
            newsSliderContainer.addEventListener('touchstart', function(e) {
                newsTouchStartX = e.changedTouches[0].screenX;
            }, false);

            newsSliderContainer.addEventListener('touchend', function(e) {
                newsTouchEndX = e.changedTouches[0].screenX;
                handleNewsSwipe();
            }, false);
        }

        function handleNewsSwipe() {
            const swipeThreshold = 50; // Minimum distance for swipe
            if (newsTouchEndX < newsTouchStartX - swipeThreshold) {
                // Swipe left - next
                nextNews();
            }
            if (newsTouchEndX > newsTouchStartX + swipeThreshold) {
                // Swipe right - previous
                prevNews();
            }
        }
    </script>
</body>
</html>
