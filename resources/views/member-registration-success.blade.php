<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro Concluído - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-neutral-50">
    <!-- Header/Navigation -->
    <x-public.navigation />

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Success Message -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-8 py-12 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full mb-4">
                        <svg class="h-12 w-12 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-extrabold text-white mb-2">
                        Cadastro Concluído com Sucesso!
                    </h1>
                    <p class="text-green-50 text-lg">
                        Bem-vindo(a) ao Apostolado da Oração
                    </p>
                </div>

                <div class="px-8 py-8">
                    <div class="space-y-6">
                        <!-- Registration Info -->
                        <div class="border-l-4 border-primary-500 pl-4 py-2 bg-primary-50 rounded-r">
                            <p class="text-sm font-medium text-neutral-700">Número do Cadastro</p>
                            <p class="text-2xl font-bold text-primary-800">#{{ $registration->id }}</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-neutral-600">Nome</p>
                                <p class="text-lg font-semibold text-neutral-900">{{ $registration->full_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-neutral-600">Email</p>
                                <p class="text-lg font-semibold text-neutral-900">{{ $registration->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-neutral-600">Paróquia</p>
                                <p class="text-lg font-semibold text-neutral-900">{{ $registration->parish }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-neutral-600">Data do Cadastro</p>
                                <p class="text-lg font-semibold text-neutral-900">{{ $registration->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <!-- Download PDF Button -->
                        <div class="bg-gradient-to-r from-blue-50 to-primary-50 rounded-lg p-6 border border-blue-200">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h3 class="text-lg font-bold text-neutral-900 mb-2">
                                        Comprovante de Cadastro
                                    </h3>
                                    <p class="text-sm text-neutral-600 mb-4">
                                        Baixe o comprovante do seu cadastro em formato PDF para seus registros.
                                    </p>
                                    <a href="{{ route('member.download-pdf', $registration->id) }}" 
                                       class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition shadow-md hover:shadow-lg transform hover:scale-105">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Baixar Comprovante (PDF)
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Next Steps -->
                        <div class="bg-neutral-50 rounded-lg p-6">
                            <h3 class="text-lg font-bold text-neutral-900 mb-3">Próximos Passos</h3>
                            <ul class="space-y-2 text-neutral-700">
                                <li class="flex items-start">
                                    <svg class="h-6 w-6 text-primary-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Entraremos em contato em breve através do email ou telefone informado.</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-6 w-6 text-primary-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Seu cadastro será analisado pela coordenação do Apostolado da Oração.</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-6 w-6 text-primary-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Você será informado sobre as próximas reuniões e atividades.</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            <a href="{{ route('home') }}" 
                               class="flex-1 text-center px-6 py-3 bg-neutral-200 hover:bg-neutral-300 text-neutral-800 font-semibold rounded-lg transition">
                                Voltar à Página Inicial
                            </a>
                            <a href="{{ route('public.prayer-intentions') }}" 
                               class="flex-1 text-center px-6 py-3 bg-gold-600 hover:bg-gold-700 text-white font-semibold rounded-lg transition">
                                Ver Intenções de Oração
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <x-public.footer />
</body>
</html>
