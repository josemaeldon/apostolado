<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('auth-custom.dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-2">{{ __('auth-custom.welcome_message') }}</h3>
                    <p class="text-gray-600">{{ __("auth-custom.you_are_logged_in") }}</p>
                </div>
            </div>

            <!-- Management Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Authentication System -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="text-4xl mr-4">🔐</div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800">{{ __('auth-custom.authentication_system') }}</h4>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4 text-sm">{{ __('auth-custom.authentication_desc') }}</p>
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('auth-custom.manage') }}
                        </a>
                    </div>
                </div>

                <!-- Dynamic Pages -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="text-4xl mr-4">📄</div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800">{{ __('auth-custom.dynamic_pages') }}</h4>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4 text-sm">{{ __('auth-custom.dynamic_pages_desc') }}</p>
                        <a href="{{ route('admin.pages.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('auth-custom.manage') }}
                        </a>
                    </div>
                </div>

                <!-- Prayer Intentions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="text-4xl mr-4">🙏</div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800">{{ __('auth-custom.prayer_intentions') }}</h4>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4 text-sm">{{ __('auth-custom.prayer_intentions_desc') }}</p>
                        <a href="{{ route('admin.prayer-intentions.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('auth-custom.manage') }}
                        </a>
                    </div>
                </div>

                <!-- News and Articles -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="text-4xl mr-4">📰</div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800">{{ __('auth-custom.news_articles') }}</h4>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4 text-sm">{{ __('auth-custom.news_articles_desc') }}</p>
                        <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('auth-custom.manage') }}
                        </a>
                    </div>
                </div>

                <!-- Event Calendar -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="text-4xl mr-4">📅</div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800">{{ __('auth-custom.event_calendar') }}</h4>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4 text-sm">{{ __('auth-custom.event_calendar_desc') }}</p>
                        <a href="{{ route('admin.events.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('auth-custom.manage') }}
                        </a>
                    </div>
                </div>

                <!-- Media Gallery -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="text-4xl mr-4">🖼️</div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800">{{ __('auth-custom.media_gallery') }}</h4>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4 text-sm">{{ __('auth-custom.media_gallery_desc') }}</p>
                        <a href="{{ route('admin.media-gallery.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('auth-custom.manage') }}
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
