<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Artigos - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-neutral-50">
    <x-public.navigation />

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary-700 via-primary-600 to-primary-700 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-5xl font-extrabold text-white mb-4 drop-shadow-lg">
                Artigos e Notícias
            </h2>
            <p class="text-xl text-primary-100">
                Reflexões, notícias e conteúdos sobre fé e espiritualidade
            </p>
        </div>
    </div>

    <!-- Articles Grid -->
    <div class="py-16 bg-neutral-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($articles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($articles as $article)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition overflow-hidden border border-neutral-200 transform hover:-translate-y-1 duration-300">
                    @if($article->featured_image)
                    <div class="h-56 bg-cover bg-center" style="background-image: url('{{ Storage::url($article->featured_image) }}');"></div>
                    @else
                    <div class="h-56 bg-gradient-to-br from-primary-600 to-gold-600 flex items-center justify-center">
                        <div class="text-white text-6xl">📰</div>
                    </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            @if($article->category)
                            <span class="inline-block px-3 py-1 bg-gold-100 text-gold-800 text-xs font-bold rounded-full">
                                {{ $article->category }}
                            </span>
                            @endif
                            <span class="text-xs text-neutral-500">
                                {{ $article->published_at->format('d/m/Y') }}
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 mb-3 line-clamp-2">
                            {{ $article->title }}
                        </h3>
                        @if($article->excerpt)
                        <p class="text-neutral-600 mb-4 line-clamp-3">
                            {{ $article->excerpt }}
                        </p>
                        @endif
                        <a href="{{ route('public.article.show', $article) }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold text-sm transition group">
                            Ler mais
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
                {{ $articles->links() }}
            </div>
            @else
            <div class="text-center py-16">
                <div class="text-6xl mb-4">📰</div>
                <h3 class="text-2xl font-bold text-neutral-900 mb-2">Nenhum artigo encontrado</h3>
                <p class="text-neutral-600">Não há artigos disponíveis no momento.</p>
            </div>
            @endif
        </div>
    </div>

    <x-public.footer />
</body>
</html>
