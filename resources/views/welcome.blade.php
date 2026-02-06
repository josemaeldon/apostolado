<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Header/Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-indigo-600">Apostolado da Oração</h1>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                            Painel
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                            Entrar
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-indigo-600 text-white hover:bg-indigo-700 px-4 py-2 rounded-md text-sm font-medium">
                                Registrar
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-gradient-to-b from-indigo-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h2 class="text-4xl font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                    Bem-vindo ao<br>
                    <span class="text-indigo-600">Apostolado da Oração</span>
                </h2>
                <p class="mt-6 max-w-2xl mx-auto text-xl text-gray-500">
                    Unindo-nos em oração pelas intenções do Papa Francisco e pelas necessidades do mundo.
                </p>
                <div class="mt-10 flex justify-center gap-4">
                    <a href="#intencoes" class="bg-indigo-600 text-white hover:bg-indigo-700 px-8 py-3 rounded-lg text-lg font-medium shadow-lg">
                        Ver Intenções de Oração
                    </a>
                    <a href="#sobre" class="bg-white text-indigo-600 hover:bg-gray-50 border border-indigo-600 px-8 py-3 rounded-lg text-lg font-medium shadow-lg">
                        Saiba Mais
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="sobre" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h3 class="text-3xl font-extrabold text-gray-900">
                    O que é o Apostolado da Oração?
                </h3>
                <p class="mt-4 text-lg text-gray-500">
                    Uma rede mundial de oração unida ao Coração de Jesus
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-50 p-8 rounded-lg">
                    <div class="text-indigo-600 text-4xl mb-4">🙏</div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Oração</h4>
                    <p class="text-gray-600">
                        Rezamos mensalmente pelas intenções do Papa Francisco, unindo nossos corações em oração.
                    </p>
                </div>
                <div class="bg-gray-50 p-8 rounded-lg">
                    <div class="text-indigo-600 text-4xl mb-4">🌍</div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Missão</h4>
                    <p class="text-gray-600">
                        Colaboramos na missão evangelizadora da Igreja, levando o amor de Cristo ao mundo.
                    </p>
                </div>
                <div class="bg-gray-50 p-8 rounded-lg">
                    <div class="text-indigo-600 text-4xl mb-4">❤️</div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Coração de Jesus</h4>
                    <p class="text-gray-600">
                        Vivemos nossa espiritualidade centrada no Sagrado Coração de Jesus.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Prayer Intentions Section -->
    <div id="intencoes" class="py-24 bg-indigo-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h3 class="text-3xl font-extrabold text-gray-900">
                    Intenções de Oração do Papa
                </h3>
                <p class="mt-4 text-lg text-gray-500">
                    {{ date('F Y') }}
                </p>
            </div>
            <div class="bg-white rounded-lg shadow-xl p-8 md:p-12 max-w-3xl mx-auto">
                <p class="text-lg text-gray-600 text-center italic">
                    "Rezemos para que todos os batizados sejam comprometidos com a evangelização, 
                    disponíveis para a missão, através do testemunho de vida conforme ao Evangelho."
                </p>
                <p class="text-center mt-6 text-indigo-600 font-semibold">
                    - Papa Francisco
                </p>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="py-16 bg-indigo-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-3xl font-extrabold text-white">
                Junte-se a Nós em Oração
            </h3>
            <p class="mt-4 text-xl text-indigo-100">
                Faça parte desta rede mundial de oração
            </p>
            <div class="mt-8">
                @guest
                    <a href="{{ route('register') }}" class="bg-white text-indigo-600 hover:bg-indigo-50 px-8 py-3 rounded-lg text-lg font-medium shadow-lg inline-block">
                        Cadastre-se Agora
                    </a>
                @else
                    <a href="{{ url('/dashboard') }}" class="bg-white text-indigo-600 hover:bg-indigo-50 px-8 py-3 rounded-lg text-lg font-medium shadow-lg inline-block">
                        Ir para o Painel
                    </a>
                @endguest
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h4 class="text-lg font-bold mb-4">Apostolado da Oração</h4>
                    <p class="text-gray-400">
                        Rede Mundial de Oração do Papa
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">Sobre Nós</a></li>
                        <li><a href="#" class="hover:text-white">Intenções</a></li>
                        <li><a href="#" class="hover:text-white">Notícias</a></li>
                        <li><a href="#" class="hover:text-white">Contato</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Contato</h4>
                    <p class="text-gray-400">
                        Email: contato@apostoladodaoracao.org.br<br>
                        Tel: (11) 1234-5678
                    </p>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-800 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Apostolado da Oração. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html>
