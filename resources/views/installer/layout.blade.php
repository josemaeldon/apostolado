<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Instalador - Apostolado da Oração</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-b from-indigo-50 to-white">
    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full space-y-8">
            <!-- Logo/Header -->
            <div class="text-center">
                <h1 class="text-4xl font-extrabold text-gray-900">
                    Apostolado da Oração
                </h1>
                <p class="mt-2 text-lg text-gray-600">
                    Assistente de Instalação
                </p>
            </div>

            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
