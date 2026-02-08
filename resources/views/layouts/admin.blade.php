<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

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
                        <h2 x-show="sidebarOpen" class="font-semibold text-xl text-gray-800 transition-opacity duration-300">
                            {{ config('app.name', 'Apostolado') }}
                        </h2>
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
                    
                    <div class="p-4 space-y-2">
                        <!-- Sidebar Items -->
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : '' }}"
                           aria-label="Dashboard"
                           :title="!sidebarOpen ? 'Dashboard' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">🏠</span>
                            <span x-show="sidebarOpen" class="font-medium">Dashboard</span>
                        </a>
                        
                        <a href="{{ route('profile.edit') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('profile.edit') ? 'bg-blue-50 text-blue-700' : '' }}"
                           aria-label="Perfil"
                           :title="!sidebarOpen ? 'Perfil' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">🔐</span>
                            <span x-show="sidebarOpen" class="font-medium">Perfil</span>
                        </a>
                        
                        <a href="{{ route('admin.homepage-sections.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.homepage-sections.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                           aria-label="Seções"
                           :title="!sidebarOpen ? 'Seções' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">📝</span>
                            <span x-show="sidebarOpen" class="font-medium">Seções</span>
                        </a>
                        
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
                        
                        <a href="{{ route('admin.sliders.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.sliders.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                           aria-label="Sliders"
                           :title="!sidebarOpen ? 'Sliders' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">🎭</span>
                            <span x-show="sidebarOpen" class="font-medium">Sliders</span>
                        </a>
                        
                        <a href="{{ route('admin.categories.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                           aria-label="Categorias"
                           :title="!sidebarOpen ? 'Categorias' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">📑</span>
                            <span x-show="sidebarOpen" class="font-medium">Categorias</span>
                        </a>
                        
                        <a href="{{ route('admin.member-registrations.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.member-registrations.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                           aria-label="Cadastros de Membros"
                           :title="!sidebarOpen ? 'Cadastros' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">👥</span>
                            <span x-show="sidebarOpen" class="font-medium">Cadastros</span>
                        </a>
                        
                        <a href="{{ route('admin.storage-settings.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.storage-settings.*') ? 'bg-blue-50 text-blue-700' : '' }}"
                           aria-label="Configurações de Armazenamento"
                           :title="!sidebarOpen ? 'Armazenamento' : ''">
                            <span class="text-2xl" :class="sidebarOpen ? 'mr-3' : 'mx-auto'" aria-hidden="true">🗄️</span>
                            <span x-show="sidebarOpen" class="font-medium">Armazenamento</span>
                        </a>
                        
                        <!-- Logout -->
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
