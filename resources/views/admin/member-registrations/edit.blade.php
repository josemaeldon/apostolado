<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ✏️ Editar Cadastro de Membro
            </h2>
            <a href="{{ route('admin.member-registrations.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                ← Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.member-registrations.update', $memberRegistration) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                                <select name="status" id="status" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="pending" {{ $memberRegistration->status == 'pending' ? 'selected' : '' }}>Pendente</option>
                                    <option value="approved" {{ $memberRegistration->status == 'approved' ? 'selected' : '' }}>Aprovado</option>
                                    <option value="rejected" {{ $memberRegistration->status == 'rejected' ? 'selected' : '' }}>Rejeitado</option>
                                </select>
                                @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Full Name -->
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-gray-700">Nome Completo *</label>
                                <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $memberRegistration->full_name) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('full_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $memberRegistration->email) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Telefone *</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $memberRegistration->phone) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Endereço *</label>
                                <input type="text" name="address" id="address" value="{{ old('address', $memberRegistration->address) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('address')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Birth Date -->
                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700">Data de Nascimento *</label>
                                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $memberRegistration->birth_date?->format('Y-m-d')) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('birth_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Marital Status -->
                            <div>
                                <label for="marital_status" class="block text-sm font-medium text-gray-700">Estado Civil *</label>
                                <select name="marital_status" id="marital_status" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Selecione</option>
                                    <option value="single" {{ old('marital_status', $memberRegistration->marital_status) == 'single' ? 'selected' : '' }}>Solteiro(a)</option>
                                    <option value="married" {{ old('marital_status', $memberRegistration->marital_status) == 'married' ? 'selected' : '' }}>Casado(a)</option>
                                    <option value="divorced" {{ old('marital_status', $memberRegistration->marital_status) == 'divorced' ? 'selected' : '' }}>Divorciado(a)</option>
                                    <option value="widowed" {{ old('marital_status', $memberRegistration->marital_status) == 'widowed' ? 'selected' : '' }}>Viúvo(a)</option>
                                </select>
                                @error('marital_status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Profession -->
                            <div>
                                <label for="profession" class="block text-sm font-medium text-gray-700">Profissão *</label>
                                <input type="text" name="profession" id="profession" value="{{ old('profession', $memberRegistration->profession) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('profession')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Parish -->
                            <div>
                                <label for="parish" class="block text-sm font-medium text-gray-700">Paróquia *</label>
                                <input type="text" name="parish" id="parish" value="{{ old('parish', $memberRegistration->parish) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('parish')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Member City -->
                            <div>
                                <label for="member_city" class="block text-sm font-medium text-gray-700">Cidade *</label>
                                <input type="text" name="member_city" id="member_city" value="{{ old('member_city', $memberRegistration->member_city) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('member_city')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Member Parish -->
                            <div>
                                <label for="member_parish" class="block text-sm font-medium text-gray-700">Paróquia do Membro</label>
                                <input type="text" name="member_parish" id="member_parish" value="{{ old('member_parish', $memberRegistration->member_parish) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('member_parish')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Baptism Date -->
                            <div>
                                <label for="baptism_date" class="block text-sm font-medium text-gray-700">Data de Batismo</label>
                                <input type="date" name="baptism_date" id="baptism_date" value="{{ old('baptism_date', $memberRegistration->baptism_date?->format('Y-m-d')) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('baptism_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- How Met -->
                            <div>
                                <label for="how_met" class="block text-sm font-medium text-gray-700">Como conheceu o Apostolado?</label>
                                <textarea name="how_met" id="how_met" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('how_met', $memberRegistration->how_met) }}</textarea>
                                @error('how_met')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Why Join -->
                            <div>
                                <label for="why_join" class="block text-sm font-medium text-gray-700">Por que deseja participar?</label>
                                <textarea name="why_join" id="why_join" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('why_join', $memberRegistration->why_join) }}</textarea>
                                @error('why_join')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('admin.member-registrations.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Cancelar
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Atualizar Cadastro
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
