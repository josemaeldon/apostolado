<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        @php
            $favicon = \App\Models\SiteSetting::get('favicon');
        @endphp
        @if($favicon)
            <link rel="icon" type="image/x-icon" href="{{ Storage::url($favicon) }}">
            <link rel="shortcut icon" href="{{ Storage::url($favicon) }}">
        @endif

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <div x-data="{ sidebarOpen: $persist(true).as('admin-sidebar-open') }" class="flex h-screen overflow-hidden">
                <!-- Sidebar -->
                <aside 
                    :class="sidebarOpen ? 'w-64' : 'w-20'"
                    class="bg-white border-r border-gray-200 transition-all duration-300 ease-in-out overflow-y-auto flex-shrink-0"
                    role="navigation"
                    aria-label="Menu lateral principal">
                    
                    <!-- Toggle Button -->
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        @php
                            $settings = \App\Models\SiteSetting::getMultiple(
                                ['site_name', 'site_logo', 'use_logo'],
                                ['site_name' => config('app.name', 'Apostolado'), 'use_logo' => '0']
                            );
                        @endphp
                        
                        @if($settings['use_logo'] == '1' && $settings['site_logo'])
                            <div x-show="sidebarOpen" class="transition-opacity duration-300">
                                <img src="{{ Storage::url($settings['site_logo']) }}" alt="{{ $settings['site_name'] }}" class="h-8 object-contain">
                            </div>
                        @else
                            <h2 x-show="sidebarOpen" class="font-semibold text-xl text-gray-800 transition-opacity duration-300">
                                {{ $settings['site_name'] }}
                            </h2>
                        @endif
                        
                        <button @click="sidebarOpen = !sidebarOpen" 
                                class="p-2 rounded-md text-gray-600 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                :class="sidebarOpen ? '' : 'mx-auto'"
                                :aria-label="sidebarOpen ? 'Recolher menu lateral' : 'Expandir menu lateral'"
                                :aria-expanded="sidebarOpen">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      :d="sidebarOpen ? 'M11 19l-7-7 7-7m8 14l-7-7 7-7' : 'M13 5l7 7-7 7M5 5l7 7-7 7'"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="p-4 space-y-2" x-data="{ homepageOpen: {{ request()->routeIs('admin.homepage-sections.*') || request()->routeIs('admin.feature-cards.*') ? 'true' : 'false' }}, cadastrosOpen: {{ request()->routeIs('admin.member-registrations.*') || request()->routeIs('admin.registration-tokens.*') ? 'true' : 'false' }}, configuracoesOpen: {{ request()->routeIs('profile.edit') || request()->routeIs('admin.site-settings.*') || request()->routeIs('admin.storage-settings.*') || request()->routeIs('admin.api-settings.*') || request()->routeIs('admin.users.*') ? 'true' : 'false' }} }">
                        <!-- Sidebar Items -->
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : '' }}"
                           aria-label="Dashboard"
                           :title="!sidebarOpen ? 'Dashboard' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">🏠</span>
                            <span x-show="sidebarOpen" class="font-medium">Dashboard</span>
                        </a>
                        
                        @if(auth()->user()->isAdmin())
                        <!-- Página Inicial with submenu - Admin only -->
                        <div>
                            <button @click="homepageOpen = !homepageOpen" 
                               class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.homepage-sections.*') || request()->routeIs('admin.feature-cards.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                               :aria-label="!sidebarOpen ? 'Página Inicial' : ''"
                               :title="!sidebarOpen ? 'Página Inicial' : ''">
                                <div class="flex items-center">
                                    <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">🎨</span>
                                    <span x-show="sidebarOpen" class="font-medium">Página Inicial</span>
                                </div>
                                <svg x-show="sidebarOpen" :class="homepageOpen ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <!-- Submenu -->
                            <div x-show="homepageOpen && sidebarOpen" x-collapse class="ml-8 mt-1 space-y-1">
                                <a href="{{ route('admin.homepage-sections.index') }}" 
                                   class="flex items-center px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.homepage-sections.*') && !request()->routeIs('admin.feature-cards.*') ? 'bg-blue-100 text-blue-700 font-medium' : '' }}">
                                    Seções
                                </a>
                                <a href="{{ route('admin.feature-cards.index') }}" 
                                   class="flex items-center px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.feature-cards.*') ? 'bg-blue-100 text-blue-700 font-medium' : '' }}">
                                    Cartões de Recurso
                                </a>
                            </div>
                        </div>
                        @endif
                        
                        <a href="{{ route('admin.pages.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.pages.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                           aria-label="Páginas"
                           :title="!sidebarOpen ? 'Páginas' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">📄</span>
                            <span x-show="sidebarOpen" class="font-medium">Páginas</span>
                        </a>
                        
                        <a href="{{ route('admin.articles.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.articles.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                           aria-label="Artigos"
                           :title="!sidebarOpen ? 'Artigos' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">📰</span>
                            <span x-show="sidebarOpen" class="font-medium">Artigos</span>
                        </a>
                        
                        <a href="{{ route('admin.prayer-intentions.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.prayer-intentions.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                           aria-label="Intenções de Oração"
                           :title="!sidebarOpen ? 'Intenções' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">🙏</span>
                            <span x-show="sidebarOpen" class="font-medium">Intenções</span>
                        </a>
                        
                        <a href="{{ route('admin.events.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.events.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                           aria-label="Eventos"
                           :title="!sidebarOpen ? 'Eventos' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">📅</span>
                            <span x-show="sidebarOpen" class="font-medium">Eventos</span>
                        </a>
                        
                        <a href="{{ route('admin.media-gallery.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.media-gallery.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                           aria-label="Galeria de Mídia"
                           :title="!sidebarOpen ? 'Galeria' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">🖼️</span>
                            <span x-show="sidebarOpen" class="font-medium">Galeria</span>
                        </a>
                        
                        @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.sliders.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.sliders.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                           aria-label="Sliders"
                           :title="!sidebarOpen ? 'Sliders' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">🎭</span>
                            <span x-show="sidebarOpen" class="font-medium">Sliders</span>
                        </a>
                        @endif
                        
                        <a href="{{ route('admin.categories.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                           aria-label="Categorias"
                           :title="!sidebarOpen ? 'Categorias' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">📑</span>
                            <span x-show="sidebarOpen" class="font-medium">Categorias</span>
                        </a>
                        
                        <!-- Cadastros with submenu -->
                        <div>
                            <button @click="cadastrosOpen = !cadastrosOpen" 
                               class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.member-registrations.*') || request()->routeIs('admin.registration-tokens.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                               :aria-label="!sidebarOpen ? 'Cadastros' : ''"
                               :title="!sidebarOpen ? 'Cadastros' : ''">
                                <div class="flex items-center">
                                    <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">👥</span>
                                    <span x-show="sidebarOpen" class="font-medium">Cadastros</span>
                                </div>
                                <svg x-show="sidebarOpen" :class="cadastrosOpen ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <!-- Submenu -->
                            <div x-show="cadastrosOpen && sidebarOpen" x-collapse class="ml-8 mt-1 space-y-1">
                                <a href="{{ route('admin.member-registrations.index') }}" 
                                   class="flex items-center px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.member-registrations.*') ? 'bg-blue-100 text-blue-700 font-medium' : '' }}">
                                    Membros
                                </a>
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.registration-tokens.index') }}" 
                                   class="flex items-center px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.registration-tokens.*') ? 'bg-blue-100 text-blue-700 font-medium' : '' }}">
                                    Tokens de Cadastro
                                </a>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Configurações with submenu -->
                        <div>
                            <button @click="configuracoesOpen = !configuracoesOpen" 
                               class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('profile.edit') || request()->routeIs('admin.site-settings.*') || request()->routeIs('admin.storage-settings.*') || request()->routeIs('admin.api-settings.*') || request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                               :aria-label="!sidebarOpen ? 'Configurações' : ''"
                               :title="!sidebarOpen ? 'Configurações' : ''">
                                <div class="flex items-center">
                                    <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">⚙️</span>
                                    <span x-show="sidebarOpen" class="font-medium">Configurações</span>
                                </div>
                                <svg x-show="sidebarOpen" :class="configuracoesOpen ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <!-- Submenu -->
                            <div x-show="configuracoesOpen && sidebarOpen" x-collapse class="ml-8 mt-1 space-y-1">
                                <a href="{{ route('profile.edit') }}" 
                                   class="flex items-center px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('profile.edit') ? 'bg-blue-100 text-blue-700 font-medium' : '' }}">
                                    Perfil
                                </a>
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.site-settings.index') }}" 
                                   class="flex items-center px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.site-settings.*') ? 'bg-blue-100 text-blue-700 font-medium' : '' }}">
                                    Site
                                </a>
                                <a href="{{ route('admin.storage-settings.index') }}" 
                                   class="flex items-center px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.storage-settings.*') ? 'bg-blue-100 text-blue-700 font-medium' : '' }}">
                                    Armazenamento
                                </a>
                                <a href="{{ route('admin.api-settings.index') }}" 
                                   class="flex items-center px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.api-settings.*') ? 'bg-blue-100 text-blue-700 font-medium' : '' }}">
                                    API REST
                                </a>
                                <a href="{{ route('admin.users.index') }}" 
                                   class="flex items-center px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-700 font-medium' : '' }}">
                                    Usuários
                                </a>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Logout -->
                        <div class="pt-2">
                            <div class="border-t border-gray-200 mb-2"></div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-red-50 hover:text-red-700 transition-colors"
                                    aria-label="Sair do sistema"
                                    :title="!sidebarOpen ? 'Sair' : ''">
                                <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">🚪</span>
                                <span x-show="sidebarOpen" class="font-medium">Sair</span>
                            </button>
                        </form>
                    </div>
                </aside>

                <!-- Main Content -->
                <main class="flex-1 overflow-y-auto bg-gray-50">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
