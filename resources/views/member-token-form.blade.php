<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Token de Cadastro - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-neutral-50">
    <!-- Header/Navigation -->
    <x-public.navigation />

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Cadastro de Membro
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Digite seu token de cadastro para continuar
                </p>
            </div>

            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                {{ session('error') }}
            </div>
            @endif

            <form class="mt-8 space-y-6" action="{{ route('member.validate-token') }}" method="POST">
                @csrf
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="token" class="sr-only">Token</label>
                        <input id="token" name="token" type="text" required 
                               maxlength="5"
                               pattern="[A-Za-z]{3}\d{2}"
                               class="appearance-none rounded-md relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-primary-500 focus:border-primary-500 focus:z-10 sm:text-lg text-center font-mono font-bold uppercase"
                               placeholder="ABC12"
                               value="{{ old('token') }}"
                               style="letter-spacing: 0.2em;">
                        @error('token')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                    <p class="text-sm text-blue-800">
                        <strong>Formato do token:</strong> 3 letras maiúsculas seguidas de 2 números<br>
                        <strong>Exemplo:</strong> ABC12, XYZ99
                    </p>
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition">
                        Continuar para o Cadastro
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('home') }}" class="text-sm text-primary-600 hover:text-primary-700">
                        ← Voltar para a página inicial
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-neutral-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-neutral-500">
                <p>&copy; {{ date('Y') }} Apostolado da Oração. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        // Convert to uppercase as user types
        document.getElementById('token').addEventListener('input', function(e) {
            e.target.value = e.target.value.toUpperCase();
        });
    </script>
</body>
</html>
