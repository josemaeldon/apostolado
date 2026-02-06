<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro de Membro - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-neutral-50">
    <!-- Header/Navigation -->
    <nav class="bg-white shadow-md border-b border-neutral-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ route('home') }}">
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-primary-700 to-primary-900 bg-clip-text text-transparent">
                            Apostolado da Oração
                        </h1>
                    </a>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-neutral-700 hover:text-primary-700 px-3 py-2 rounded-md text-sm font-medium transition">
                        Voltar ao Início
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-10">
                <h1 class="text-4xl font-extrabold text-neutral-900 mb-4">
                    Cadastro de Membro
                </h1>
                <p class="text-lg text-neutral-600">
                    Preencha o formulário abaixo para se tornar um membro do Apostolado da Oração
                </p>
            </div>

            @if(session('success'))
            <div class="mb-8 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('member.store') }}" class="bg-white shadow-xl rounded-2xl overflow-hidden">
                @csrf

                <div class="p-8 space-y-8">
                    <!-- Paróquia -->
                    <div class="border-b border-neutral-200 pb-6">
                        <h3 class="text-2xl font-bold text-primary-800 mb-4">Paróquia</h3>
                        <div>
                            <label for="parish" class="block text-sm font-medium text-neutral-700 mb-2">
                                Nome da Paróquia <span class="text-primary-600">*</span>
                            </label>
                            <input type="text" name="parish" id="parish" value="{{ old('parish') }}" required
                                   class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                            @error('parish')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Dados Pessoais -->
                    <div class="border-b border-neutral-200 pb-6">
                        <h3 class="text-2xl font-bold text-primary-800 mb-6">Dados Pessoais</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="full_name" class="block text-sm font-medium text-neutral-700 mb-2">
                                    Nome Completo <span class="text-primary-600">*</span>
                                </label>
                                <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" required
                                       class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                                @error('full_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-neutral-700 mb-2">
                                    Endereço <span class="text-primary-600">*</span>
                                </label>
                                <textarea name="address" id="address" rows="3" required
                                          class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-neutral-700 mb-2">
                                    Telefone/WhatsApp <span class="text-primary-600">*</span>
                                </label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                                       class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-neutral-700 mb-2">
                                    E-mail <span class="text-primary-600">*</span>
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                       class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-neutral-700 mb-2">
                                    Data de Nascimento <span class="text-primary-600">*</span>
                                </label>
                                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" required
                                       class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                                @error('birth_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="marital_status" class="block text-sm font-medium text-neutral-700 mb-2">
                                    Estado Civil <span class="text-primary-600">*</span>
                                </label>
                                <select name="marital_status" id="marital_status" required
                                        class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                                    <option value="">Selecione...</option>
                                    <option value="Solteiro(a)" {{ old('marital_status') == 'Solteiro(a)' ? 'selected' : '' }}>Solteiro(a)</option>
                                    <option value="Casado(a)" {{ old('marital_status') == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                                    <option value="Divorciado(a)" {{ old('marital_status') == 'Divorciado(a)' ? 'selected' : '' }}>Divorciado(a)</option>
                                    <option value="Viúvo(a)" {{ old('marital_status') == 'Viúvo(a)' ? 'selected' : '' }}>Viúvo(a)</option>
                                </select>
                                @error('marital_status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="profession" class="block text-sm font-medium text-neutral-700 mb-2">
                                    Profissão <span class="text-primary-600">*</span>
                                </label>
                                <input type="text" name="profession" id="profession" value="{{ old('profession') }}" required
                                       class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                                @error('profession')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Dados Paroquiais -->
                    <div class="border-b border-neutral-200 pb-6">
                        <h3 class="text-2xl font-bold text-primary-800 mb-6">Dados Paroquiais</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="member_city" class="block text-sm font-medium text-neutral-700 mb-2">
                                    Cidade do Membro <span class="text-primary-600">*</span>
                                </label>
                                <input type="text" name="member_city" id="member_city" value="{{ old('member_city') }}" required
                                       class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                                @error('member_city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="member_parish" class="block text-sm font-medium text-neutral-700 mb-2">
                                    Paróquia do Membro <span class="text-primary-600">*</span>
                                </label>
                                <input type="text" name="member_parish" id="member_parish" value="{{ old('member_parish') }}" required
                                       class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                                @error('member_parish')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="baptism_date" class="block text-sm font-medium text-neutral-700 mb-2">
                                    Data de Batismo
                                </label>
                                <input type="date" name="baptism_date" id="baptism_date" value="{{ old('baptism_date') }}"
                                       class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                                @error('baptism_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Compromissos do Membro -->
                    <div class="border-b border-neutral-200 pb-6">
                        <h3 class="text-2xl font-bold text-primary-800 mb-4">Compromissos do Membro</h3>
                        <p class="text-neutral-600 mb-6">Marque os compromissos que você assume como membro do Apostolado da Oração:</p>
                        
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <input type="checkbox" name="commitment_1" id="commitment_1" value="1" {{ old('commitment_1') ? 'checked' : '' }}
                                       class="mt-1 h-5 w-5 text-primary-600 border-neutral-300 rounded focus:ring-primary-500">
                                <label for="commitment_1" class="ml-3 text-neutral-700">
                                    Oferecer diariamente a vida, as orações, as obras e os sofrimentos em união com o Coração de Jesus.
                                </label>
                            </div>

                            <div class="flex items-start">
                                <input type="checkbox" name="commitment_2" id="commitment_2" value="1" {{ old('commitment_2') ? 'checked' : '' }}
                                       class="mt-1 h-5 w-5 text-primary-600 border-neutral-300 rounded focus:ring-primary-500">
                                <label for="commitment_2" class="ml-3 text-neutral-700">
                                    Rezar pelas intenções de oração mensais do Papa.
                                </label>
                            </div>

                            <div class="flex items-start">
                                <input type="checkbox" name="commitment_3" id="commitment_3" value="1" {{ old('commitment_3') ? 'checked' : '' }}
                                       class="mt-1 h-5 w-5 text-primary-600 border-neutral-300 rounded focus:ring-primary-500">
                                <label for="commitment_3" class="ml-3 text-neutral-700">
                                    Participar das reuniões mensais do Apostolado da Oração.
                                </label>
                            </div>

                            <div class="flex items-start">
                                <input type="checkbox" name="commitment_4" id="commitment_4" value="1" {{ old('commitment_4') ? 'checked' : '' }}
                                       class="mt-1 h-5 w-5 text-primary-600 border-neutral-300 rounded focus:ring-primary-500">
                                <label for="commitment_4" class="ml-3 text-neutral-700">
                                    Dedicar-se à adoração ao Santíssimo Sacramento, especialmente nas primeiras sextas-feiras do mês, sempre que possível.
                                </label>
                            </div>

                            <div class="flex items-start">
                                <input type="checkbox" name="commitment_5" id="commitment_5" value="1" {{ old('commitment_5') ? 'checked' : '' }}
                                       class="mt-1 h-5 w-5 text-primary-600 border-neutral-300 rounded focus:ring-primary-500">
                                <label for="commitment_5" class="ml-3 text-neutral-700">
                                    Participar ativamente das missas do Sagrado Coração de Jesus.
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Informações Adicionais -->
                    <div>
                        <h3 class="text-2xl font-bold text-primary-800 mb-6">Informações Adicionais</h3>
                        <div class="space-y-6">
                            <div>
                                <label for="how_met" class="block text-sm font-medium text-neutral-700 mb-2">
                                    Como conheceu o Apostolado da Oração?
                                </label>
                                <textarea name="how_met" id="how_met" rows="4"
                                          class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">{{ old('how_met') }}</textarea>
                                @error('how_met')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="why_join" class="block text-sm font-medium text-neutral-700 mb-2">
                                    Por que deseja ingressar no Apostolado?
                                </label>
                                <textarea name="why_join" id="why_join" rows="4"
                                          class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">{{ old('why_join') }}</textarea>
                                @error('why_join')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="bg-neutral-100 px-8 py-6 border-t border-neutral-200">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('home') }}" class="text-neutral-600 hover:text-neutral-900 font-medium transition">
                            ← Voltar
                        </a>
                        <button type="submit" class="bg-gradient-to-r from-primary-600 to-primary-700 text-white hover:from-primary-700 hover:to-primary-800 px-8 py-3 rounded-lg font-bold shadow-lg transition transform hover:scale-105">
                            Enviar Cadastro
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-neutral-900 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-neutral-400">&copy; {{ date('Y') }} Apostolado da Oração. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>
