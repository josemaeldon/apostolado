<x-admin-layout>

    <div class="p-4 lg:p-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Status Update Form -->
                    <div class="mb-6 pb-6 border-b">
                        <form action="{{ route('admin.member-registrations.update', $memberRegistration) }}" method="POST" class="flex items-center gap-4">
                            @csrf
                            @method('PUT')
                            <label for="status" class="text-sm font-medium text-gray-700">Status:</label>
                            <select name="status" id="status" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="pending" {{ $memberRegistration->status == 'pending' ? 'selected' : '' }}>Pendente</option>
                                <option value="approved" {{ $memberRegistration->status == 'approved' ? 'selected' : '' }}>Aprovado</option>
                                <option value="rejected" {{ $memberRegistration->status == 'rejected' ? 'selected' : '' }}>Rejeitado</option>
                            </select>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                                Atualizar Status
                            </button>
                        </form>
                    </div>

                    <!-- Registration Details -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Paróquia</h3>
                            <p class="text-gray-700">{{ $memberRegistration->parish }}</p>
                        </div>

                        <div class="border-t pt-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Dados Pessoais</h3>
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nome Completo</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $memberRegistration->full_name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">CPF</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $memberRegistration->cpf ?? 'Não informado' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $memberRegistration->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Telefone/WhatsApp</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $memberRegistration->phone }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Data de Nascimento</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $memberRegistration->birth_date->format('d/m/Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Estado Civil</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $memberRegistration->marital_status }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Profissão</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $memberRegistration->profession }}</dd>
                                </div>
                                <div class="md:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Endereço</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $memberRegistration->address }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="border-t pt-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Dados Paroquiais</h3>
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Cidade</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $memberRegistration->member_city }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Paróquia</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $memberRegistration->member_parish }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Data de Batismo</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $memberRegistration->baptism_date ? $memberRegistration->baptism_date->format('d/m/Y') : 'Não informado' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="border-t pt-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Compromissos Assumidos</h3>
                            <ul class="space-y-2">
                                @if($memberRegistration->commitment_1)
                                    <li class="flex items-center text-sm text-gray-700">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Oferecer diariamente a vida, as orações, as obras e os sofrimentos
                                    </li>
                                @endif
                                @if($memberRegistration->commitment_2)
                                    <li class="flex items-center text-sm text-gray-700">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Rezar pelas intenções de oração mensais do Papa
                                    </li>
                                @endif
                                @if($memberRegistration->commitment_3)
                                    <li class="flex items-center text-sm text-gray-700">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Participar das reuniões mensais do Apostolado da Oração
                                    </li>
                                @endif
                                @if($memberRegistration->commitment_4)
                                    <li class="flex items-center text-sm text-gray-700">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Dedicar-se à adoração ao Santíssimo Sacramento
                                    </li>
                                @endif
                                @if($memberRegistration->commitment_5)
                                    <li class="flex items-center text-sm text-gray-700">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Participar ativamente das missas do Sagrado Coração de Jesus
                                    </li>
                                @endif
                            </ul>
                        </div>

                        @if($memberRegistration->how_met || $memberRegistration->why_join)
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Informações Adicionais</h3>
                            @if($memberRegistration->how_met)
                            <div class="mb-4">
                                <dt class="text-sm font-medium text-gray-500">Como conheceu o Apostolado?</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $memberRegistration->how_met }}</dd>
                            </div>
                            @endif
                            @if($memberRegistration->why_join)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Por que deseja ingressar?</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $memberRegistration->why_join }}</dd>
                            </div>
                            @endif
                        </div>
                        @endif

                        <div class="border-t pt-6">
                            <p class="text-xs text-gray-500">Cadastro recebido em {{ $memberRegistration->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
