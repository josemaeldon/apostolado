<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eventos - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-neutral-50">
    <x-public.navigation />

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary-700 via-primary-600 to-primary-700 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-5xl font-extrabold text-white mb-4 drop-shadow-lg">
                Eventos
            </h2>
            <p class="text-xl text-primary-100">
                Participe de nossos encontros e celebrações
            </p>
        </div>
    </div>

    <!-- Events Grid -->
    <div class="py-16 bg-neutral-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($events as $event)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition overflow-hidden border border-neutral-200 transform hover:-translate-y-1 duration-300">
                    @if($event->image)
                    <div class="h-56 bg-cover bg-center" style="background-image: url('{{ Storage::url($event->image) }}');"></div>
                    @else
                    <div class="h-56 bg-gradient-to-br from-gold-600 via-primary-600 to-primary-700 flex items-center justify-center">
                        <div class="text-white text-6xl">📅</div>
                    </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center space-x-2 mb-3">
                            <span class="inline-block px-3 py-1 bg-primary-100 text-primary-800 text-xs font-bold rounded-full">
                                {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }}
                            </span>
                            @if($event->end_date && $event->end_date != $event->start_date)
                            <span class="text-xs text-neutral-500">até</span>
                            <span class="inline-block px-3 py-1 bg-primary-100 text-primary-800 text-xs font-bold rounded-full">
                                {{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y') }}
                            </span>
                            @endif
                        </div>
                        @if($event->location)
                        <div class="flex items-center text-sm text-neutral-600 mb-3">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ Str::limit($event->location, 40) }}
                        </div>
                        @endif
                        <h3 class="text-xl font-bold text-neutral-900 mb-3 line-clamp-2">
                            {{ $event->title }}
                        </h3>
                        <p class="text-neutral-600 mb-4 line-clamp-3">
                            {{ Str::limit($event->description, 120) }}
                        </p>
                        <a href="{{ route('public.event.show', $event) }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold text-sm transition group">
                            Ver detalhes
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
                {{ $events->links() }}
            </div>
            @else
            <div class="text-center py-16">
                <div class="text-6xl mb-4">📅</div>
                <h3 class="text-2xl font-bold text-neutral-900 mb-2">Nenhum evento encontrado</h3>
                <p class="text-neutral-600">Não há eventos disponíveis no momento.</p>
            </div>
            @endif
        </div>
    </div>

    <x-public.footer />
</body>
</html>
