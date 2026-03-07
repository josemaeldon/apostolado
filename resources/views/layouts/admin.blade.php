<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
    <x-site-favicon />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <div x-data="{ sidebarOpen: $persist(true).as('admin-sidebar-open') }" class="flex h-screen overflow-y-hidden overflow-x-visible">
                <!-- Sidebar -->
                <aside 
                    :class="sidebarOpen ? 'w-64' : 'w-20'"
                    class="relative z-40 bg-white border-r border-gray-200 transition-all duration-300 ease-in-out overflow-visible flex-shrink-0"
                    role="navigation"
                    aria-label="Menu lateral principal">
                    
                    <!-- Toggle Button -->
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        @php
                            $settings = \App\Models\SiteSetting::getMultiple(
                                ['site_name', 'site_logo', 'use_logo'],
                                ['site_name' => config('app.name', 'Apostolado'), 'use_logo' => '0']
                            );
                            $hasLogo = $settings['use_logo'] == '1' && !empty($settings['site_logo']);
                            $logoUrl = $hasLogo ? \App\Helpers\ImageHelper::storageUrl($settings['site_logo']) : null;
                        @endphp
                        
                        @if($hasLogo)
                            <div x-show="sidebarOpen" class="transition-opacity duration-300">
                                <img src="{{ $logoUrl }}" alt="{{ $settings['site_name'] }}" class="h-8 object-contain">
                            </div>
                            <div x-show="!sidebarOpen" class="w-0" x-cloak></div>
                        @else
                            <h2 x-show="sidebarOpen" class="font-semibold text-xl text-gray-800 transition-opacity duration-300">
                                {{ $settings['site_name'] }}
                            </h2>
                            <div x-show="!sidebarOpen" class="w-0" x-cloak></div>
                        @endif
                        
                        <button @click="sidebarOpen = !sidebarOpen" 
                            class="relative p-2 rounded-md text-gray-600 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                :class="sidebarOpen ? '' : 'mx-auto'"
                                :aria-label="sidebarOpen ? 'Recolher menu lateral' : 'Expandir menu lateral'"
                                :aria-expanded="sidebarOpen">
                            <svg x-show="sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      :d="sidebarOpen ? 'M11 19l-7-7 7-7m8 14l-7-7 7-7' : 'M13 5l7 7-7 7M5 5l7 7-7 7'"></path>
                            </svg>
                            @if($hasLogo)
                                <img x-show="!sidebarOpen" x-cloak src="{{ $logoUrl }}" alt="{{ $settings['site_name'] }}"
                                     class="h-7 w-auto max-w-8 object-contain mx-auto">
                            @else
                                <span x-show="!sidebarOpen" x-cloak class="text-sm font-semibold text-gray-800" title="{{ $settings['site_name'] }}">
                                    {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($settings['site_name'], 0, 1)) }}
                                </span>
                            @endif

                            <span x-show="!sidebarOpen" x-cloak
                                  class="absolute -right-1 -bottom-1 inline-flex h-4 w-4 items-center justify-center rounded-full bg-blue-600 text-white shadow-sm"
                                  aria-hidden="true"
                                  title="Clique para expandir">
                                <svg class="h-2.5 w-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                    
                    <div class="p-4 space-y-2 overflow-y-auto overflow-x-visible" style="max-height: calc(100vh - 73px);" x-data="{
                        cadastrosOpen: {{ request()->routeIs('admin.member-registrations.*') || request()->routeIs('admin.registration-tokens.*') ? 'true' : 'false' }},
                        cadastrosHover: false,
                        cadastrosTimer: null,
                        cadastrosTop: 0,
                        cadastrosLeft: 0,
                        configuracoesOpen: {{ request()->routeIs('profile.edit') || request()->routeIs('admin.site-settings.*') || request()->routeIs('admin.storage-settings.*') || request()->routeIs('admin.api-settings.*') || request()->routeIs('admin.users.*') ? 'true' : 'false' }},
                        configuracoesHover: false,
                        configuracoesTimer: null,
                        configuracoesTop: 0,
                        configuracoesLeft: 0,
                        openCadastrosFlyout(triggerEl) {
                            const rect = triggerEl.getBoundingClientRect();
                            const margin = 8;
                            const panelWidth = 224;

                            let left = rect.right + margin;
                            if (left + panelWidth > window.innerWidth - margin) {
                                left = Math.max(margin, rect.left - panelWidth - margin);
                            }

                            this.cadastrosLeft = left;
                            this.cadastrosTop = rect.top;

                            this.$nextTick(() => {
                                const panel = this.$refs.cadastrosFlyout;
                                if (!panel) return;

                                const panelHeight = panel.offsetHeight;
                                const maxTop = Math.max(margin, window.innerHeight - panelHeight - margin);
                                this.cadastrosTop = Math.min(Math.max(margin, rect.top), maxTop);
                            });
                        },
                        openConfiguracoesFlyout(triggerEl) {
                            const rect = triggerEl.getBoundingClientRect();
                            const margin = 8;
                            const panelWidth = 224;

                            let left = rect.right + margin;
                            if (left + panelWidth > window.innerWidth - margin) {
                                left = Math.max(margin, rect.left - panelWidth - margin);
                            }

                            this.configuracoesLeft = left;
                            this.configuracoesTop = rect.top;

                            this.$nextTick(() => {
                                const panel = this.$refs.configuracoesFlyout;
                                if (!panel) return;

                                const panelHeight = panel.offsetHeight;
                                const maxTop = Math.max(margin, window.innerHeight - panelHeight - margin);
                                this.configuracoesTop = Math.min(Math.max(margin, rect.top), maxTop);
                            });
                        }
                    }"
                    @resize.window="if (!sidebarOpen && (cadastrosOpen || cadastrosHover) && $refs.cadastrosTrigger) openCadastrosFlyout($refs.cadastrosTrigger); if (!sidebarOpen && (configuracoesOpen || configuracoesHover) && $refs.configuracoesTrigger) openConfiguracoesFlyout($refs.configuracoesTrigger);">
                        <!-- Sidebar Items -->
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : '' }}"
                                    :class="sidebarOpen ? '' : 'justify-center px-0'"
                           aria-label="Dashboard"
                           :title="!sidebarOpen ? 'Dashboard' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">🏠</span>
                            <span x-show="sidebarOpen" class="font-medium">Dashboard</span>
                        </a>
                        
                        @if(auth()->user()->isAdmin())
                        <!-- Página Inicial (Seções + Cartões) - Admin only -->
                        <a href="{{ route('admin.homepage-sections.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.homepage-sections.*') || request()->routeIs('admin.feature-cards.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                                    :class="sidebarOpen ? '' : 'justify-center px-0'"
                           :aria-label="!sidebarOpen ? 'Página Inicial' : ''"
                           :title="!sidebarOpen ? 'Página Inicial' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">🎨</span>
                            <span x-show="sidebarOpen" class="font-medium">Página Inicial</span>
                        </a>
                        @endif
                        
                        <a href="{{ route('admin.pages.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.pages.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                                    :class="sidebarOpen ? '' : 'justify-center px-0'"
                           aria-label="Páginas"
                           :title="!sidebarOpen ? 'Páginas' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">📄</span>
                            <span x-show="sidebarOpen" class="font-medium">Páginas</span>
                        </a>
                        
                        <a href="{{ route('admin.articles.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.articles.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                                    :class="sidebarOpen ? '' : 'justify-center px-0'"
                           aria-label="Artigos"
                           :title="!sidebarOpen ? 'Artigos' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">📰</span>
                            <span x-show="sidebarOpen" class="font-medium">Artigos</span>
                        </a>
                        
                        <a href="{{ route('admin.prayer-intentions.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.prayer-intentions.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                                    :class="sidebarOpen ? '' : 'justify-center px-0'"
                           aria-label="Intenções de Oração"
                           :title="!sidebarOpen ? 'Intenções' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">🙏</span>
                            <span x-show="sidebarOpen" class="font-medium">Intenções</span>
                        </a>
                        
                        <a href="{{ route('admin.events.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.events.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                                    :class="sidebarOpen ? '' : 'justify-center px-0'"
                           aria-label="Eventos"
                           :title="!sidebarOpen ? 'Eventos' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">📅</span>
                            <span x-show="sidebarOpen" class="font-medium">Eventos</span>
                        </a>
                        
                        <a href="{{ route('admin.media-gallery.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.media-gallery.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                                    :class="sidebarOpen ? '' : 'justify-center px-0'"
                           aria-label="Galeria de Mídia"
                           :title="!sidebarOpen ? 'Galeria' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">🖼️</span>
                            <span x-show="sidebarOpen" class="font-medium">Galeria</span>
                        </a>
                        
                        @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.sliders.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.sliders.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                                    :class="sidebarOpen ? '' : 'justify-center px-0'"
                           aria-label="Sliders"
                           :title="!sidebarOpen ? 'Sliders' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">🎭</span>
                            <span x-show="sidebarOpen" class="font-medium">Sliders</span>
                        </a>
                        @endif
                        
                        <a href="{{ route('admin.categories.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                                    :class="sidebarOpen ? '' : 'justify-center px-0'"
                           aria-label="Categorias"
                           :title="!sidebarOpen ? 'Categorias' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">📑</span>
                            <span x-show="sidebarOpen" class="font-medium">Categorias</span>
                        </a>
                        
                        <!-- Cadastros with submenu -->
                                <div class="relative"
                                    x-ref="cadastrosTrigger"
                                    @mouseenter="if (!sidebarOpen) { openCadastrosFlyout($el); clearTimeout(cadastrosTimer); cadastrosHover = true }"
                                @mouseleave="if (!sidebarOpen) { clearTimeout(cadastrosTimer); cadastrosTimer = setTimeout(() => { cadastrosHover = false }, 180) }"
                             @click.outside="if (!sidebarOpen) cadastrosOpen = false">
                                   <button @click="if (sidebarOpen) { cadastrosOpen = !cadastrosOpen } else { openCadastrosFlyout($el.parentElement); cadastrosOpen = !cadastrosOpen }" 
                               class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.member-registrations.*') || request()->routeIs('admin.registration-tokens.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                                         :class="sidebarOpen ? '' : 'justify-center px-0'"
                               :aria-label="!sidebarOpen ? 'Cadastros' : ''"
                               :title="!sidebarOpen ? 'Cadastros' : ''">
                                <div class="flex items-center">
                                    <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">👥</span>
                                    <span x-show="sidebarOpen" class="font-medium">Cadastros</span>
                                </div>
                                <svg x-show="sidebarOpen" :class="cadastrosOpen ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>

                                <span x-show="!sidebarOpen" x-cloak
                                      class="absolute right-2 bottom-2 inline-flex h-4 w-4 items-center justify-center rounded-full bg-blue-600 text-white"
                                      aria-hidden="true">
                                    <svg class="h-2.5 w-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                                    </svg>
                                </span>
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

                                                           <div x-show="!sidebarOpen && (cadastrosOpen || cadastrosHover)"
                                                               x-ref="cadastrosFlyout"
                                 x-cloak
                                                                 @mouseenter="clearTimeout(cadastrosTimer); cadastrosHover = true"
                                                                 @mouseleave="clearTimeout(cadastrosTimer); cadastrosTimer = setTimeout(() => { cadastrosHover = false }, 180)"
                                                               :style="`top:${cadastrosTop}px; left:${cadastrosLeft}px;`"
                                                               class="fixed w-56 max-h-[calc(100vh-16px)] overflow-y-auto bg-white border border-gray-200 rounded-lg shadow-xl z-[90] p-2 space-y-1">
                                <a href="{{ route('admin.member-registrations.index') }}"
                                   class="flex items-center px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.member-registrations.*') ? 'bg-blue-100 text-blue-700 font-medium' : '' }}">
                                    Membros
                                </a>
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.registration-tokens.index') }}"
                                   class="flex items-center px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.registration-tokens.*') ? 'bg-blue-100 text-blue-700 font-medium' : '' }}">
                                    Tokens de Cadastro
                                </a>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Configurações with submenu -->
                                <div class="relative"
                                    x-ref="configuracoesTrigger"
                                    @mouseenter="if (!sidebarOpen) { openConfiguracoesFlyout($el); clearTimeout(configuracoesTimer); configuracoesHover = true }"
                                @mouseleave="if (!sidebarOpen) { clearTimeout(configuracoesTimer); configuracoesTimer = setTimeout(() => { configuracoesHover = false }, 180) }"
                             @click.outside="if (!sidebarOpen) configuracoesOpen = false">
                                   <button @click="if (sidebarOpen) { configuracoesOpen = !configuracoesOpen } else { openConfiguracoesFlyout($el.parentElement); configuracoesOpen = !configuracoesOpen }" 
                               class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('profile.edit') || request()->routeIs('admin.site-settings.*') || request()->routeIs('admin.storage-settings.*') || request()->routeIs('admin.api-settings.*') || request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                                         :class="sidebarOpen ? '' : 'justify-center px-0'"
                               :aria-label="!sidebarOpen ? 'Configurações' : ''"
                               :title="!sidebarOpen ? 'Configurações' : ''">
                                <div class="flex items-center">
                                    <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">⚙️</span>
                                    <span x-show="sidebarOpen" class="font-medium">Configurações</span>
                                </div>
                                <svg x-show="sidebarOpen" :class="configuracoesOpen ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>

                                <span x-show="!sidebarOpen" x-cloak
                                      class="absolute right-2 bottom-2 inline-flex h-4 w-4 items-center justify-center rounded-full bg-blue-600 text-white"
                                      aria-hidden="true">
                                    <svg class="h-2.5 w-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                                    </svg>
                                </span>
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

                                                           <div x-show="!sidebarOpen && (configuracoesOpen || configuracoesHover)"
                                                               x-ref="configuracoesFlyout"
                                 x-cloak
                                                                 @mouseenter="clearTimeout(configuracoesTimer); configuracoesHover = true"
                                                                 @mouseleave="clearTimeout(configuracoesTimer); configuracoesTimer = setTimeout(() => { configuracoesHover = false }, 180)"
                                                               :style="`top:${configuracoesTop}px; left:${configuracoesLeft}px;`"
                                                               class="fixed w-56 max-h-[calc(100vh-16px)] overflow-y-auto bg-white border border-gray-200 rounded-lg shadow-xl z-[90] p-2 space-y-1">
                                <a href="{{ route('profile.edit') }}"
                                   class="flex items-center px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('profile.edit') ? 'bg-blue-100 text-blue-700 font-medium' : '' }}">
                                    Perfil
                                </a>
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.site-settings.index') }}"
                                   class="flex items-center px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.site-settings.*') ? 'bg-blue-100 text-blue-700 font-medium' : '' }}">
                                    Site
                                </a>
                                <a href="{{ route('admin.storage-settings.index') }}"
                                   class="flex items-center px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.storage-settings.*') ? 'bg-blue-100 text-blue-700 font-medium' : '' }}">
                                    Armazenamento
                                </a>
                                <a href="{{ route('admin.api-settings.index') }}"
                                   class="flex items-center px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.api-settings.*') ? 'bg-blue-100 text-blue-700 font-medium' : '' }}">
                                    API REST
                                </a>
                                <a href="{{ route('admin.users.index') }}"
                                   class="flex items-center px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-700 font-medium' : '' }}">
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
                                    :class="sidebarOpen ? '' : 'justify-center px-0'"
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
