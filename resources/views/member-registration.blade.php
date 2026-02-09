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
    <x-public.navigation />

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

            <!-- CPF Search Box -->
            <div class="mb-8 bg-blue-50 border border-blue-200 rounded-2xl overflow-hidden shadow-md">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Verificar Cadastro Existente
                    </h2>
                    <p class="text-blue-100 text-sm mt-1">
                        Pesquise seu CPF para verificar se você já possui cadastro
                    </p>
                </div>
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <label for="search_cpf" class="block text-sm font-medium text-neutral-700 mb-2">
                                CPF
                            </label>
                            <input type="text" 
                                   id="search_cpf" 
                                   placeholder="000.000.000-00"
                                   maxlength="14"
                                   class="w-full rounded-lg border-neutral-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="sm:pt-7">
                            <button type="button" 
                                    id="check_cpf_btn"
                                    class="w-full sm:w-auto px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-md hover:shadow-lg flex items-center justify-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Verificar
                            </button>
                        </div>
                    </div>
                    
                    <!-- Search Result -->
                    <div id="cpf_search_result" class="mt-4 hidden"></div>
                </div>
            </div>

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
                            <select name="parish" id="parish" required
                                    class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                                <option value="">Selecione uma paróquia...</option>
                                <option value="Cristo Crucificado" {{ old('parish') == 'Cristo Crucificado' ? 'selected' : '' }}>Cristo Crucificado</option>
                                <option value="Imaculada Conceição" {{ old('parish') == 'Imaculada Conceição' ? 'selected' : '' }}>Imaculada Conceição</option>
                                <option value="Nossa Senhora Aparecida" {{ old('parish') == 'Nossa Senhora Aparecida' ? 'selected' : '' }}>Nossa Senhora Aparecida</option>
                                <option value="Nossa Senhora da Divina Providência" {{ old('parish') == 'Nossa Senhora da Divina Providência' ? 'selected' : '' }}>Nossa Senhora da Divina Providência</option>
                                <option value="Nossa Senhora da Piedade" {{ old('parish') == 'Nossa Senhora da Piedade' ? 'selected' : '' }}>Nossa Senhora da Piedade</option>
                                <option value="Nossa Senhora de Nazaré" {{ old('parish') == 'Nossa Senhora de Nazaré' ? 'selected' : '' }}>Nossa Senhora de Nazaré</option>
                                <option value="Nossa Senhora do Perpétuo Socorro" {{ old('parish') == 'Nossa Senhora do Perpétuo Socorro' ? 'selected' : '' }}>Nossa Senhora do Perpétuo Socorro</option>
                                <option value="Nossa Senhora do Rosário" {{ old('parish') == 'Nossa Senhora do Rosário' ? 'selected' : '' }}>Nossa Senhora do Rosário</option>
                                <option value="Sagrado Coração de Jesus" {{ old('parish') == 'Sagrado Coração de Jesus' ? 'selected' : '' }}>Sagrado Coração de Jesus</option>
                                <option value="Santa Luzia" {{ old('parish') == 'Santa Luzia' ? 'selected' : '' }}>Santa Luzia</option>
                                <option value="Santa Teresinha do Menino Jesus" {{ old('parish') == 'Santa Teresinha do Menino Jesus' ? 'selected' : '' }}>Santa Teresinha do Menino Jesus</option>
                                <option value="Santo Antônio Maria Zaccaria" {{ old('parish') == 'Santo Antônio Maria Zaccaria' ? 'selected' : '' }}>Santo Antônio Maria Zaccaria</option>
                                <option value="São Francisco de Assis" {{ old('parish') == 'São Francisco de Assis' ? 'selected' : '' }}>São Francisco de Assis</option>
                                <option value="São João Batista" {{ old('parish') == 'São João Batista' ? 'selected' : '' }}>São João Batista</option>
                                <option value="São José" {{ old('parish') == 'São José' ? 'selected' : '' }}>São José</option>
                                <option value="São Miguel Arcanjo" {{ old('parish') == 'São Miguel Arcanjo' ? 'selected' : '' }}>São Miguel Arcanjo</option>
                                <option value="São Pedro Apóstolo" {{ old('parish') == 'São Pedro Apóstolo' ? 'selected' : '' }}>São Pedro Apóstolo</option>
                                <option value="São Raimundo Nonato" {{ old('parish') == 'São Raimundo Nonato' ? 'selected' : '' }}>São Raimundo Nonato</option>
                                <option value="São Sebastião" {{ old('parish') == 'São Sebastião' ? 'selected' : '' }}>São Sebastião</option>
                            </select>
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

                            <div>
                                <label for="cpf" class="block text-sm font-medium text-neutral-700 mb-2">
                                    CPF <span class="text-primary-600">*</span>
                                </label>
                                <input type="text" name="cpf" id="cpf" value="{{ old('cpf') }}" required maxlength="14"
                                       placeholder="000.000.000-00"
                                       class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                                @error('cpf')
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
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required maxlength="14"
                                       placeholder="(00)99999-9999"
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

                            <div>
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

                    <!-- Dados Religiosos -->
                    <div class="border-b border-neutral-200 pb-6">
                        <h3 class="text-2xl font-bold text-primary-800 mb-6">Dados Religiosos</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="member_city" class="block text-sm font-medium text-neutral-700 mb-2">
                                    Cidade do Membro <span class="text-primary-600">*</span>
                                </label>
                                <select name="member_city" id="member_city" required
                                        class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                                    <option value="">Selecione uma cidade...</option>
                                    <option value="Augusto Corrêa" {{ old('member_city') == 'Augusto Corrêa' ? 'selected' : '' }}>Augusto Corrêa</option>
                                    <option value="Aurora do Pará" {{ old('member_city') == 'Aurora do Pará' ? 'selected' : '' }}>Aurora do Pará</option>
                                    <option value="Bonito" {{ old('member_city') == 'Bonito' ? 'selected' : '' }}>Bonito</option>
                                    <option value="Bragança do Pará" {{ old('member_city') == 'Bragança do Pará' ? 'selected' : '' }}>Bragança do Pará</option>
                                    <option value="Cachoeira do Piriá" {{ old('member_city') == 'Cachoeira do Piriá' ? 'selected' : '' }}>Cachoeira do Piriá</option>
                                    <option value="Capitão Poço" {{ old('member_city') == 'Capitão Poço' ? 'selected' : '' }}>Capitão Poço</option>
                                    <option value="Dom Eliseu" {{ old('member_city') == 'Dom Eliseu' ? 'selected' : '' }}>Dom Eliseu</option>
                                    <option value="Garrafão do Norte" {{ old('member_city') == 'Garrafão do Norte' ? 'selected' : '' }}>Garrafão do Norte</option>
                                    <option value="Ipixuna do Pará" {{ old('member_city') == 'Ipixuna do Pará' ? 'selected' : '' }}>Ipixuna do Pará</option>
                                    <option value="Irituia" {{ old('member_city') == 'Irituia' ? 'selected' : '' }}>Irituia</option>
                                    <option value="Mãe do Rio" {{ old('member_city') == 'Mãe do Rio' ? 'selected' : '' }}>Mãe do Rio</option>
                                    <option value="Nova Esperança do Piriá" {{ old('member_city') == 'Nova Esperança do Piriá' ? 'selected' : '' }}>Nova Esperança do Piriá</option>
                                    <option value="Ourém" {{ old('member_city') == 'Ourém' ? 'selected' : '' }}>Ourém</option>
                                    <option value="Paragominas" {{ old('member_city') == 'Paragominas' ? 'selected' : '' }}>Paragominas</option>
                                    <option value="Rondon do Pará" {{ old('member_city') == 'Rondon do Pará' ? 'selected' : '' }}>Rondon do Pará</option>
                                    <option value="Santa Luzia do Pará" {{ old('member_city') == 'Santa Luzia do Pará' ? 'selected' : '' }}>Santa Luzia do Pará</option>
                                    <option value="São Miguel do Guamá" {{ old('member_city') == 'São Miguel do Guamá' ? 'selected' : '' }}>São Miguel do Guamá</option>
                                    <option value="Tracuateua" {{ old('member_city') == 'Tracuateua' ? 'selected' : '' }}>Tracuateua</option>
                                    <option value="Ulianópolis" {{ old('member_city') == 'Ulianópolis' ? 'selected' : '' }}>Ulianópolis</option>
                                    <option value="Viseu" {{ old('member_city') == 'Viseu' ? 'selected' : '' }}>Viseu</option>
                                </select>
                                @error('member_city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="member_parish" class="block text-sm font-medium text-neutral-700 mb-2">
                                    Paróquia do Membro <span class="text-primary-600">*</span>
                                </label>
                                <select name="member_parish" id="member_parish" required
                                        class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                                    <option value="">Selecione uma paróquia...</option>
                                    <option value="Cristo Crucificado" {{ old('member_parish') == 'Cristo Crucificado' ? 'selected' : '' }}>Cristo Crucificado</option>
                                    <option value="Imaculada Conceição" {{ old('member_parish') == 'Imaculada Conceição' ? 'selected' : '' }}>Imaculada Conceição</option>
                                    <option value="Nossa Senhora Aparecida" {{ old('member_parish') == 'Nossa Senhora Aparecida' ? 'selected' : '' }}>Nossa Senhora Aparecida</option>
                                    <option value="Nossa Senhora da Divina Providência" {{ old('member_parish') == 'Nossa Senhora da Divina Providência' ? 'selected' : '' }}>Nossa Senhora da Divina Providência</option>
                                    <option value="Nossa Senhora da Piedade" {{ old('member_parish') == 'Nossa Senhora da Piedade' ? 'selected' : '' }}>Nossa Senhora da Piedade</option>
                                    <option value="Nossa Senhora de Nazaré" {{ old('member_parish') == 'Nossa Senhora de Nazaré' ? 'selected' : '' }}>Nossa Senhora de Nazaré</option>
                                    <option value="Nossa Senhora do Perpétuo Socorro" {{ old('member_parish') == 'Nossa Senhora do Perpétuo Socorro' ? 'selected' : '' }}>Nossa Senhora do Perpétuo Socorro</option>
                                    <option value="Nossa Senhora do Rosário" {{ old('member_parish') == 'Nossa Senhora do Rosário' ? 'selected' : '' }}>Nossa Senhora do Rosário</option>
                                    <option value="Sagrado Coração de Jesus" {{ old('member_parish') == 'Sagrado Coração de Jesus' ? 'selected' : '' }}>Sagrado Coração de Jesus</option>
                                    <option value="Santa Luzia" {{ old('member_parish') == 'Santa Luzia' ? 'selected' : '' }}>Santa Luzia</option>
                                    <option value="Santa Teresinha do Menino Jesus" {{ old('member_parish') == 'Santa Teresinha do Menino Jesus' ? 'selected' : '' }}>Santa Teresinha do Menino Jesus</option>
                                    <option value="Santo Antônio Maria Zaccaria" {{ old('member_parish') == 'Santo Antônio Maria Zaccaria' ? 'selected' : '' }}>Santo Antônio Maria Zaccaria</option>
                                    <option value="São Francisco de Assis" {{ old('member_parish') == 'São Francisco de Assis' ? 'selected' : '' }}>São Francisco de Assis</option>
                                    <option value="São João Batista" {{ old('member_parish') == 'São João Batista' ? 'selected' : '' }}>São João Batista</option>
                                    <option value="São José" {{ old('member_parish') == 'São José' ? 'selected' : '' }}>São José</option>
                                    <option value="São Miguel Arcanjo" {{ old('member_parish') == 'São Miguel Arcanjo' ? 'selected' : '' }}>São Miguel Arcanjo</option>
                                    <option value="São Pedro Apóstolo" {{ old('member_parish') == 'São Pedro Apóstolo' ? 'selected' : '' }}>São Pedro Apóstolo</option>
                                    <option value="São Raimundo Nonato" {{ old('member_parish') == 'São Raimundo Nonato' ? 'selected' : '' }}>São Raimundo Nonato</option>
                                    <option value="São Sebastião" {{ old('member_parish') == 'São Sebastião' ? 'selected' : '' }}>São Sebastião</option>
                                </select>
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
                        <h3 class="text-2xl font-bold text-primary-800 mb-2">Compromissos do Membro *</h3>
                        <p class="text-sm text-red-600 font-semibold mb-2">⚠️ Todos os compromissos são obrigatórios</p>
                        <p class="text-neutral-600 mb-6">Para se tornar membro do Apostolado da Oração, você deve aceitar e assumir todos os compromissos abaixo:</p>
                        
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <input type="checkbox" name="commitment_1" id="commitment_1" value="1" {{ old('commitment_1') ? 'checked' : '' }}
                                       required
                                       class="mt-1 h-5 w-5 text-primary-600 border-neutral-300 rounded focus:ring-primary-500">
                                <label for="commitment_1" class="ml-3 text-neutral-700">
                                    <span class="font-semibold">*</span> Oferecer diariamente a vida, as orações, as obras e os sofrimentos em união com o Coração de Jesus.
                                </label>
                            </div>
                            @error('commitment_1')
                                <p class="ml-8 mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <div class="flex items-start">
                                <input type="checkbox" name="commitment_2" id="commitment_2" value="1" {{ old('commitment_2') ? 'checked' : '' }}
                                       required
                                       class="mt-1 h-5 w-5 text-primary-600 border-neutral-300 rounded focus:ring-primary-500">
                                <label for="commitment_2" class="ml-3 text-neutral-700">
                                    <span class="font-semibold">*</span> Rezar pelas intenções de oração mensais do Papa.
                                </label>
                            </div>
                            @error('commitment_2')
                                <p class="ml-8 mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <div class="flex items-start">
                                <input type="checkbox" name="commitment_3" id="commitment_3" value="1" {{ old('commitment_3') ? 'checked' : '' }}
                                       required
                                       class="mt-1 h-5 w-5 text-primary-600 border-neutral-300 rounded focus:ring-primary-500">
                                <label for="commitment_3" class="ml-3 text-neutral-700">
                                    <span class="font-semibold">*</span> Participar das reuniões mensais do Apostolado da Oração.
                                </label>
                            </div>
                            @error('commitment_3')
                                <p class="ml-8 mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <div class="flex items-start">
                                <input type="checkbox" name="commitment_4" id="commitment_4" value="1" {{ old('commitment_4') ? 'checked' : '' }}
                                       required
                                       class="mt-1 h-5 w-5 text-primary-600 border-neutral-300 rounded focus:ring-primary-500">
                                <label for="commitment_4" class="ml-3 text-neutral-700">
                                    <span class="font-semibold">*</span> Dedicar-se à adoração ao Santíssimo Sacramento, especialmente nas primeiras sextas-feiras do mês, sempre que possível.
                                </label>
                            </div>
                            @error('commitment_4')
                                <p class="ml-8 mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <div class="flex items-start">
                                <input type="checkbox" name="commitment_5" id="commitment_5" value="1" {{ old('commitment_5') ? 'checked' : '' }}
                                       required
                                       class="mt-1 h-5 w-5 text-primary-600 border-neutral-300 rounded focus:ring-primary-500">
                                <label for="commitment_5" class="ml-3 text-neutral-700">
                                    <span class="font-semibold">*</span> Participar ativamente das missas do Sagrado Coração de Jesus.
                                </label>
                            </div>
                            @error('commitment_5')
                                <p class="ml-8 mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
    <x-public.footer />

    <script>
        // CPF Formatting
        document.getElementById('cpf').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
            
            if (value.length <= 11) {
                // Format as: 000.000.000-00
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            } else {
                value = value.substring(0, 11);
                value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            }
            
            e.target.value = value;
        });

        // Phone Formatting  
        document.getElementById('phone').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
            
            if (value.length <= 11) {
                // Format as: (00)99999-9999
                value = value.replace(/(\d{2})(\d)/, '($1)$2');
                value = value.replace(/(\d{5})(\d)/, '$1-$2');
            } else {
                value = value.substring(0, 11);
                value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1)$2-$3');
            }
            
            e.target.value = value;
        });

        // CPF Search Formatting
        document.getElementById('search_cpf').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            } else {
                value = value.substring(0, 11);
                value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            }
            e.target.value = value;
        });

        // CPF Search
        document.getElementById('check_cpf_btn').addEventListener('click', function() {
            const cpf = document.getElementById('search_cpf').value;
            const resultDiv = document.getElementById('cpf_search_result');
            const btn = this;
            
            if (!cpf || cpf.length !== 14) {
                resultDiv.innerHTML = `
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <p class="text-sm font-medium text-red-800">
                            Por favor, insira um CPF válido no formato 000.000.000-00
                        </p>
                    </div>
                `;
                resultDiv.classList.remove('hidden');
                return;
            }

            // Show loading
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Verificando...
            `;

            // Make AJAX request
            fetch('{{ route('member.check-cpf') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ cpf: cpf })
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    const statusText = data.data.status === 'pending' ? 'Pendente' : 
                                     data.data.status === 'approved' ? 'Aprovado' : 'Rejeitado';
                    
                    let bgColor, borderColor, textColor, btnColor, btnHoverColor;
                    if (data.data.status === 'pending') {
                        bgColor = 'bg-yellow-50';
                        borderColor = 'border-yellow-500';
                        textColor = 'text-yellow-800';
                        btnColor = 'bg-yellow-600';
                        btnHoverColor = 'hover:bg-yellow-700';
                    } else if (data.data.status === 'approved') {
                        bgColor = 'bg-green-50';
                        borderColor = 'border-green-500';
                        textColor = 'text-green-800';
                        btnColor = 'bg-green-600';
                        btnHoverColor = 'hover:bg-green-700';
                    } else {
                        bgColor = 'bg-red-50';
                        borderColor = 'border-red-500';
                        textColor = 'text-red-800';
                        btnColor = 'bg-red-600';
                        btnHoverColor = 'hover:bg-red-700';
                    }
                    
                    resultDiv.innerHTML = `
                        <div class="${bgColor} border-l-4 ${borderColor} p-4 rounded">
                            <div class="flex items-start">
                                <svg class="h-6 w-6 ${textColor.replace('800', '600')} mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div class="flex-1">
                                    <h3 class="text-sm font-bold ${textColor.replace('800', '900')} mb-2">
                                        Cadastro Encontrado!
                                    </h3>
                                    <div class="text-sm ${textColor} space-y-1">
                                        <p><strong>Nome:</strong> ${data.data.full_name}</p>
                                        <p><strong>Email:</strong> ${data.data.email}</p>
                                        <p><strong>Paróquia:</strong> ${data.data.parish}</p>
                                        <p><strong>Status:</strong> <span class="font-semibold">${statusText}</span></p>
                                        <p><strong>Data do Cadastro:</strong> ${data.data.created_at}</p>
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ route('member.download-pdf', '') }}/${data.data.id}" 
                                           class="inline-flex items-center px-4 py-2 ${btnColor} ${btnHoverColor} text-white text-sm font-semibold rounded transition">
                                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Baixar Comprovante
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    resultDiv.innerHTML = `
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                            <div class="flex items-start">
                                <svg class="h-6 w-6 text-blue-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-blue-800">
                                        ${data.message}
                                    </p>
                                    <p class="text-sm text-blue-700 mt-1">
                                        Você pode preencher o formulário abaixo para realizar o cadastro.
                                    </p>
                                </div>
                            </div>
                        </div>
                    `;
                }
                resultDiv.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                resultDiv.innerHTML = `
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <p class="text-sm font-medium text-red-800">
                            Ocorreu um erro ao verificar o CPF. Por favor, tente novamente.
                        </p>
                    </div>
                `;
                resultDiv.classList.remove('hidden');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = `
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Verificar
                `;
            });
        });
    </script>
</body>
</html>
