<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->title }} - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-neutral-50">
    <x-public.navigation />

    <!-- Content -->
    <div class="py-16 bg-neutral-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium mb-8 transition group">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Voltar
            </a>

            <article class="bg-white rounded-2xl shadow-xl overflow-hidden border border-neutral-200">
                @if($page->featured_image)
                <div class="h-96 bg-cover bg-center" style="background-image: url('{{ Storage::url($page->featured_image) }}');"></div>
                @endif

                <div class="p-8 lg:p-12">
                    <h1 class="text-4xl lg:text-5xl font-extrabold text-neutral-900 mb-8 leading-tight">
                        {{ $page->title }}
                    </h1>

                    <div class="prose prose-lg max-w-none text-neutral-700 leading-relaxed">
                        {!! $page->content !!}
                    </div>

                    <div class="mt-8 pt-8 border-t border-neutral-200">
                        <a href="{{ route('home') }}" class="inline-flex items-center bg-gradient-to-r from-primary-600 to-primary-700 text-white hover:from-primary-700 hover:to-primary-800 px-6 py-3 rounded-lg font-semibold shadow-lg transition transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Voltar
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </div>

    <x-public.footer />
</body>
</html>
