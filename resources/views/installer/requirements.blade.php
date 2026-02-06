@extends('installer.layout')

@section('content')
<div class="bg-white shadow-xl rounded-lg overflow-hidden">
    <!-- Progress Bar -->
    <div class="bg-gray-50 px-8 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between text-sm">
            <span class="text-indigo-600 font-semibold">Passo 1 de 4</span>
            <span class="text-gray-600">Requisitos do Sistema</span>
        </div>
        <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
            <div class="bg-indigo-600 h-2 rounded-full" style="width: 25%"></div>
        </div>
    </div>

    <div class="px-8 py-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">
            Requisitos do Sistema
        </h2>

        <!-- PHP Version -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Versão do PHP</h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-700">{{ $requirements['php']['name'] }}</span>
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600 mr-3">{{ $requirements['php']['version'] }}</span>
                        @if($requirements['php']['status'])
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @else
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- PHP Extensions -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Extensões PHP Necessárias</h3>
            <div class="space-y-2">
                @foreach($requirements['extensions'] as $ext)
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">{{ $ext['name'] }}</span>
                        @if($ext['status'])
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @else
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @php
            $allRequirementsMet = $requirements['php']['status'] && 
                                  !in_array(false, array_column($requirements['extensions'], 'status'));
        @endphp

        @if(!$allRequirementsMet)
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <div class="flex">
                <svg class="h-5 w-5 text-red-600 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="text-sm text-red-800 font-semibold">Requisitos não atendidos</p>
                    <p class="text-sm text-red-700">
                        Alguns requisitos do sistema não foram atendidos. Por favor, instale as extensões faltantes antes de continuar.
                    </p>
                </div>
            </div>
        </div>
        @endif

        <div class="mt-8 flex justify-between">
            <a href="{{ route('installer.welcome') }}" class="bg-gray-200 text-gray-700 hover:bg-gray-300 px-6 py-3 rounded-lg font-medium inline-flex items-center">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                </svg>
                Voltar
            </a>
            
            @if($allRequirementsMet)
            <a href="{{ route('installer.permissions') }}" class="bg-indigo-600 text-white hover:bg-indigo-700 px-6 py-3 rounded-lg font-medium inline-flex items-center">
                Próximo
                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
            @else
            <button disabled class="bg-gray-400 text-white px-6 py-3 rounded-lg font-medium cursor-not-allowed inline-flex items-center">
                Próximo
                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </button>
            @endif
        </div>
    </div>
</div>
@endsection
