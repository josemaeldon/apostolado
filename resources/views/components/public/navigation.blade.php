<nav class="bg-white shadow-md border-b border-neutral-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                @php
                    $siteName = \App\Models\SiteSetting::get('site_name', 'Apostolado da Oração');
                    $siteLogo = \App\Models\SiteSetting::get('site_logo');
                    $useLogo = \App\Models\SiteSetting::get('use_logo', '0');
                @endphp
                
                <a href="{{ route('home') }}" class="flex items-center">
                    @if($useLogo == '1' && $siteLogo)
                        <img src="{{ Storage::url($siteLogo) }}" alt="{{ $siteName }}" class="h-12 object-contain">
                    @else
                        <h1 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-primary-700 to-primary-900 bg-clip-text text-transparent">
                            {{ $siteName }}
                        </h1>
                    @endif
                </a>
            </div>
            
            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-6">
                <a href="{{ route('home') }}" class="text-neutral-700 hover:text-primary-700 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('home') ? 'text-primary-700 border-b-2 border-primary-700' : '' }}">
                    Home
                </a>
                <a href="{{ route('public.prayer-intentions') }}" class="text-neutral-700 hover:text-primary-700 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('public.prayer-intentions*') ? 'text-primary-700 border-b-2 border-primary-700' : '' }}">
                    Intenções de Oração
                </a>
                <a href="{{ route('public.articles') }}" class="text-neutral-700 hover:text-primary-700 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('public.articles*') || request()->routeIs('public.article.*') ? 'text-primary-700 border-b-2 border-primary-700' : '' }}">
                    Artigos
                </a>
                <a href="{{ route('public.events') }}" class="text-neutral-700 hover:text-primary-700 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('public.events*') || request()->routeIs('public.event.*') ? 'text-primary-700 border-b-2 border-primary-700' : '' }}">
                    Eventos
                </a>
                <a href="{{ route('public.media-gallery') }}" class="text-neutral-700 hover:text-primary-700 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('public.media-gallery') ? 'text-primary-700 border-b-2 border-primary-700' : '' }}">
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
            <a href="{{ route('home') }}" class="block text-neutral-700 hover:text-primary-700 hover:bg-neutral-50 px-3 py-2 rounded-md text-base font-medium transition {{ request()->routeIs('home') ? 'text-primary-700 bg-neutral-50' : '' }}">
                Home
            </a>
            <a href="{{ route('public.prayer-intentions') }}" class="block text-neutral-700 hover:text-primary-700 hover:bg-neutral-50 px-3 py-2 rounded-md text-base font-medium transition {{ request()->routeIs('public.prayer-intentions*') ? 'text-primary-700 bg-neutral-50' : '' }}">
                Intenções de Oração
            </a>
            <a href="{{ route('public.articles') }}" class="block text-neutral-700 hover:text-primary-700 hover:bg-neutral-50 px-3 py-2 rounded-md text-base font-medium transition {{ request()->routeIs('public.articles*') || request()->routeIs('public.article.*') ? 'text-primary-700 bg-neutral-50' : '' }}">
                Artigos
            </a>
            <a href="{{ route('public.events') }}" class="block text-neutral-700 hover:text-primary-700 hover:bg-neutral-50 px-3 py-2 rounded-md text-base font-medium transition {{ request()->routeIs('public.events*') || request()->routeIs('public.event.*') ? 'text-primary-700 bg-neutral-50' : '' }}">
                Eventos
            </a>
            <a href="{{ route('public.media-gallery') }}" class="block text-neutral-700 hover:text-primary-700 hover:bg-neutral-50 px-3 py-2 rounded-md text-base font-medium transition {{ request()->routeIs('public.media-gallery') ? 'text-primary-700 bg-neutral-50' : '' }}">
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

<script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIconOpen = document.getElementById('menu-icon-open');
        const menuIconClose = document.getElementById('menu-icon-close');

        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                menuIconOpen.classList.toggle('hidden');
                menuIconClose.classList.toggle('hidden');
            });
        }
    });
</script>
