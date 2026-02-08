<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $event->title }} - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-neutral-50">
    <x-public.navigation />

    <!-- Content -->
    <div class="py-16 bg-neutral-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('public.events') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium mb-8 transition group">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Voltar aos Eventos
            </a>

            <article class="bg-white rounded-2xl shadow-xl overflow-hidden border border-neutral-200">
                @if($event->image)
                <div class="h-96 bg-cover bg-center" style="background-image: url('{{ Storage::url($event->image) }}');"></div>
                @else
                <div class="h-96 bg-gradient-to-br from-gold-600 via-primary-600 to-primary-700 flex items-center justify-center">
                    <div class="text-white text-8xl">📅</div>
                </div>
                @endif

                <div class="p-8 lg:p-12">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 pb-8 border-b border-neutral-200">
                        <div>
                            <h4 class="text-sm font-semibold text-neutral-500 uppercase mb-2">Data</h4>
                            <div class="flex items-center text-neutral-900">
                                <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold">{{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }}</p>
                                    @if($event->end_date && $event->end_date != $event->start_date)
                                    <p class="text-sm text-neutral-600">até {{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if($event->location)
                        <div>
                            <h4 class="text-sm font-semibold text-neutral-500 uppercase mb-2">Local</h4>
                            <div class="flex items-start text-neutral-900">
                                <svg class="w-5 h-5 mr-2 text-primary-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <p class="font-semibold">{{ $event->location }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <h1 class="text-4xl lg:text-5xl font-extrabold text-neutral-900 mb-6 leading-tight">
                        {{ $event->title }}
                    </h1>

                    <div class="prose prose-lg max-w-none text-neutral-700 leading-relaxed">
                        {!! nl2br(e($event->description)) !!}
                    </div>

                    <div class="mt-8 pt-8 border-t border-neutral-200">
                        <a href="{{ route('public.events') }}" class="inline-flex items-center bg-gradient-to-r from-primary-600 to-primary-700 text-white hover:from-primary-700 hover:to-primary-800 px-6 py-3 rounded-lg font-semibold shadow-lg transition transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Voltar aos Eventos
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </div>

    <x-public.footer />
</body>
</html>
