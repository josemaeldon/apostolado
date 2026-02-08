<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('auth-custom.dashboard') }}
            </h2>
            <!-- Mobile menu button -->
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-md text-gray-600 hover:text-gray-800 hover:bg-gray-100 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </x-slot>

    <div x-data="{ sidebarOpen: false }" class="flex h-[calc(100vh-8rem)]">
        <!-- Sidebar -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed lg:static inset-y-0 left-0 z-30 w-64 bg-white border-r border-gray-200 transform transition-transform duration-300 ease-in-out overflow-y-auto mt-16 lg:mt-0">
            
            <div class="p-4 space-y-2">
                <!-- Sidebar Items -->
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('profile.edit') ? 'bg-blue-50 text-blue-700' : '' }}">
                    <span class="text-2xl mr-3">🔐</span>
                    <span class="font-medium">Perfil</span>
                </a>
                
                <a href="{{ route('admin.homepage-sections.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.homepage-sections.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                    <span class="text-2xl mr-3">📝</span>
                    <span class="font-medium">Seções</span>
                </a>
                
                <a href="{{ route('admin.pages.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.pages.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                    <span class="text-2xl mr-3">📄</span>
                    <span class="font-medium">Páginas</span>
                </a>
                
                <a href="{{ route('admin.articles.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.articles.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                    <span class="text-2xl mr-3">📰</span>
                    <span class="font-medium">Artigos</span>
                </a>
                
                <a href="{{ route('admin.prayer-intentions.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.prayer-intentions.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                    <span class="text-2xl mr-3">🙏</span>
                    <span class="font-medium">Intenções</span>
                </a>
                
                <a href="{{ route('admin.events.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.events.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                    <span class="text-2xl mr-3">📅</span>
                    <span class="font-medium">Eventos</span>
                </a>
                
                <a href="{{ route('admin.media-gallery.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.media-gallery.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                    <span class="text-2xl mr-3">🖼️</span>
                    <span class="font-medium">Galeria</span>
                </a>
                
                <a href="{{ route('admin.sliders.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.sliders.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                    <span class="text-2xl mr-3">🎭</span>
                    <span class="font-medium">Sliders</span>
                </a>
                
                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                    <span class="text-2xl mr-3">📑</span>
                    <span class="font-medium">Categorias</span>
                </a>
                
                <a href="{{ route('admin.member-registrations.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.member-registrations.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                    <span class="text-2xl mr-3">👥</span>
                    <span class="font-medium">Cadastros</span>
                </a>
                
                <a href="{{ route('admin.storage-settings.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('admin.storage-settings.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                    <span class="text-2xl mr-3">🗄️</span>
                    <span class="font-medium">Armazenamento</span>
                </a>
            </div>
        </aside>

        <!-- Overlay for mobile -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-50 lg:hidden z-20"
             style="display: none;">
        </div>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-4 lg:p-8">
            <div class="max-w-5xl">
                <!-- Welcome Message -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 lg:p-8 mb-6 text-white">
                    <h3 class="text-2xl lg:text-3xl font-bold mb-2">{{ __('auth-custom.welcome_message') }}</h3>
                    <p class="text-blue-100">{{ __("auth-custom.you_are_logged_in") }}</p>
                </div>

                <!-- Quick Stats or Info Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
                    <!-- You can add statistics or quick info here -->
                    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Sistema Ativo</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">✓</p>
                            </div>
                            <div class="text-3xl">🚀</div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Bem-vindo</p>
                                <p class="text-lg font-bold text-gray-900 mt-1 truncate">{{ Auth::user()->name }}</p>
                            </div>
                            <div class="text-3xl">👤</div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-purple-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Acesso Completo</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">Admin</p>
                            </div>
                            <div class="text-3xl">⚡</div>
                        </div>
                    </div>
                </div>

                <!-- Help Section -->
                <div class="mt-6 bg-white rounded-xl shadow p-6">
                    <h4 class="text-lg font-bold text-gray-900 mb-3">💡 Dica</h4>
                    <p class="text-gray-600">
                        Use o menu lateral para navegar entre as diferentes seções do painel administrativo. 
                        Em dispositivos móveis, toque no ícone do menu no topo para abrir a navegação.
                    </p>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
