@extends('installer.layout')

@section('content')
<div class="bg-white shadow-xl rounded-lg overflow-hidden">
    <div class="px-8 py-10">
        <div class="text-center mb-8">
            <div class="mx-auto h-16 w-16 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                <svg class="h-10 w-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">
                Bem-vindo!
            </h2>
            <p class="text-gray-600">
                Vamos configurar seu site do Apostolado da Oração em alguns passos simples.
            </p>
        </div>

        <div class="space-y-6">
            <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-indigo-900 mb-3">
                    O que você precisa:
                </h3>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Acesso ao banco de dados PostgreSQL
                    </li>
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Permissões de escrita nas pastas do sistema
                    </li>
                    <li class="flex items-start">
                        <svg class="h-6 w-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Email e senha para o administrador do site
                    </li>
                </ul>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="h-5 w-5 text-yellow-600 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="text-sm text-yellow-800 font-semibold">Importante</p>
                        <p class="text-sm text-yellow-700">
                            Certifique-se de ter um backup antes de prosseguir. A instalação irá criar tabelas no banco de dados.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-center">
            <a href="{{ route('installer.requirements') }}" class="bg-indigo-600 text-white hover:bg-indigo-700 px-8 py-3 rounded-lg text-lg font-medium shadow-lg inline-flex items-center">
                Começar Instalação
                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    </div>
</div>
@endsection
