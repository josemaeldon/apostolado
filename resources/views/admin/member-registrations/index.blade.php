<x-admin-layout>

    <div class="p-4 lg:p-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <p class="font-semibold mb-1">Existem erros no envio:</p>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                        <h3 class="text-lg font-semibold">Gestao de Cadastros de Membros</h3>
                        <button type="button" id="toggle-create-form" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition">
                            + Novo Cadastro
                        </button>
                    </div>

                    <div id="create-form-wrapper" class="hidden border border-red-200 rounded-lg p-4 mb-6 bg-red-50">
                        <h4 class="text-base font-semibold text-red-800 mb-4">Cadastrar Novo Membro</h4>
                        <form action="{{ route('admin.member-registrations.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div>
                                    <label for="create_status" class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                                    <select name="status" id="create_status" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                        <option value="pending">Pendente</option>
                                        <option value="approved">Aprovado</option>
                                        <option value="rejected">Rejeitado</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="create_full_name" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo *</label>
                                    <input type="text" name="full_name" id="create_full_name" value="{{ old('full_name') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label for="create_cpf" class="block text-sm font-medium text-gray-700 mb-1">CPF *</label>
                                    <input type="text" name="cpf" id="create_cpf" value="{{ old('cpf') }}" required maxlength="14" placeholder="000.000.000-00" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label for="create_email" class="block text-sm font-medium text-gray-700 mb-1">Email (Opcional)</label>
                                    <input type="email" name="email" id="create_email" value="{{ old('email') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label for="create_phone" class="block text-sm font-medium text-gray-700 mb-1">Telefone *</label>
                                    <input type="text" name="phone" id="create_phone" value="{{ old('phone') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label for="create_birth_date" class="block text-sm font-medium text-gray-700 mb-1">Data de Nascimento *</label>
                                    <input type="date" name="birth_date" id="create_birth_date" value="{{ old('birth_date') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label for="create_marital_status" class="block text-sm font-medium text-gray-700 mb-1">Estado Civil *</label>
                                    <select name="marital_status" id="create_marital_status" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                        <option value="">Selecione</option>
                                        <option value="Solteiro(a)">Solteiro(a)</option>
                                        <option value="Casado(a)">Casado(a)</option>
                                        <option value="Divorciado(a)">Divorciado(a)</option>
                                        <option value="Viúvo(a)">Viúvo(a)</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="create_profession" class="block text-sm font-medium text-gray-700 mb-1">Profissao *</label>
                                    <input type="text" name="profession" id="create_profession" value="{{ old('profession') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label for="create_parish" class="block text-sm font-medium text-gray-700 mb-1">Paroquia *</label>
                                    <input type="text" name="parish" id="create_parish" value="{{ old('parish') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label for="create_member_city" class="block text-sm font-medium text-gray-700 mb-1">Cidade *</label>
                                    <input type="text" name="member_city" id="create_member_city" value="{{ old('member_city') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label for="create_member_parish" class="block text-sm font-medium text-gray-700 mb-1">Paroquia do Membro</label>
                                    <input type="text" name="member_parish" id="create_member_parish" value="{{ old('member_parish') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label for="create_baptism_date" class="block text-sm font-medium text-gray-700 mb-1">Data de Batismo</label>
                                    <input type="date" name="baptism_date" id="create_baptism_date" value="{{ old('baptism_date') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                </div>
                            </div>

                            <div>
                                <label for="create_address" class="block text-sm font-medium text-gray-700 mb-1">Endereco *</label>
                                <textarea name="address" id="create_address" rows="2" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">{{ old('address') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="create_how_met" class="block text-sm font-medium text-gray-700 mb-1">Como conheceu o Apostolado?</label>
                                    <textarea name="how_met" id="create_how_met" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">{{ old('how_met') }}</textarea>
                                </div>
                                <div>
                                    <label for="create_why_join" class="block text-sm font-medium text-gray-700 mb-1">Por que deseja participar?</label>
                                    <textarea name="why_join" id="create_why_join" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">{{ old('why_join') }}</textarea>
                                </div>
                            </div>

                            <div>
                                <label for="create_profile_image" class="block text-sm font-medium text-gray-700 mb-1">Foto de Perfil</label>
                                <input type="file" name="profile_image" id="create_profile_image" accept="image/*" class="w-full text-sm text-gray-600">
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF ate 2MB</p>
                            </div>

                            <div class="flex justify-end gap-2">
                                <button type="button" id="cancel-create-form" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition">Cancelar</button>
                                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition">Salvar Cadastro</button>
                            </div>
                        </form>
                    </div>

                    <h3 class="text-lg font-semibold mb-4">Filtros de Busca</h3>
                    <form method="GET" action="{{ route('admin.member-registrations.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Buscar por nome..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            </div>

                            <div>
                                <label for="parish" class="block text-sm font-medium text-gray-700 mb-1">Paroquia</label>
                                <select name="parish" id="parish" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                    <option value="">Todas as paroquias</option>
                                    @foreach($parishes as $parish)
                                        <option value="{{ $parish }}" {{ request('parish') == $parish ? 'selected' : '' }}>{{ $parish }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                    <option value="">Todos os status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendente</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Aprovado</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejeitado</option>
                                </select>
                            </div>

                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Cidade</label>
                                <select name="city" id="city" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                    <option value="">Todas as cidades</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Data Inicial</label>
                                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            </div>

                            <div>
                                <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Data Final</label>
                                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium transition">Filtrar</button>
                            <a href="{{ route('admin.member-registrations.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-medium transition">Limpar Filtros</a>
                        </div>
                    </form>

                    @if($registrations->total() > 0)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <form method="GET" action="{{ route('admin.member-registrations.export-pdf') }}" class="flex items-center gap-3">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="parish" value="{{ request('parish') }}">
                            <input type="hidden" name="status" value="{{ request('status') }}">
                            <input type="hidden" name="city" value="{{ request('city') }}">
                            <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                            <input type="hidden" name="date_to" value="{{ request('date_to') }}">

                            <button type="submit" class="flex items-center gap-2 bg-red-700 hover:bg-red-800 text-white px-6 py-2 rounded-lg font-medium transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                                </svg>
                                Exportar PDF
                            </button>
                            <span class="text-sm text-gray-600">
                                ({{ $registrations->total() }} cadastro{{ $registrations->total() != 1 ? 's' : '' }} sera{{ $registrations->total() != 1 ? 'o' : '' }} exportado{{ $registrations->total() != 1 ? 's' : '' }})
                            </span>
                        </form>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Lista de Cadastros</h3>

                    @if($registrations->count() > 0)
                        <form id="bulk-action-form" method="POST" action="{{ route('admin.member-registrations.bulk-action') }}">
                            @csrf
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="parish" value="{{ request('parish') }}">
                            <input type="hidden" name="filter_status" value="{{ request('status') }}">
                            <input type="hidden" name="city" value="{{ request('city') }}">
                            <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                            <input type="hidden" name="date_to" value="{{ request('date_to') }}">
                            <input type="hidden" name="action" id="bulk-action-input" value="">

                            <div class="mb-4 p-4 bg-gray-50 border border-gray-200 rounded-lg flex flex-col lg:flex-row gap-3 lg:items-center lg:justify-between">
                                <div class="flex flex-wrap gap-2 items-center">
                                    <span class="text-sm text-gray-700">Selecionados: <strong id="selected-count">0</strong></span>
                                    <select name="status" id="bulk-status" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                        <option value="">Selecione o novo status</option>
                                        <option value="pending">Pendente</option>
                                        <option value="approved">Aprovado</option>
                                        <option value="rejected">Rejeitado</option>
                                    </select>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    <button type="submit" id="bulk-status-btn" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg font-medium transition">
                                        Atualizar Status em Lote
                                    </button>
                                    <button type="submit" id="bulk-delete-btn" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition">
                                        Excluir Selecionados
                                    </button>
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left">
                                                <input type="checkbox" id="select-all" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paroquia</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acoes</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($registrations as $registration)
                                            <tr>
                                                <td class="px-4 py-4">
                                                    <input type="checkbox" name="selected_ids[]" value="{{ $registration->id }}" class="row-checkbox rounded border-gray-300 text-red-600 focus:ring-red-500">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $registration->full_name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $registration->email ?: 'Nao informado' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $registration->parish }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                        {{ $registration->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                        {{ $registration->status == 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                                        {{ $registration->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                                        @if($registration->status == 'pending') Pendente
                                                        @elseif($registration->status == 'approved') Aprovado
                                                        @elseif($registration->status == 'rejected') Rejeitado
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $registration->created_at->format('d/m/Y') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('admin.member-registrations.show', $registration) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                                                    <a href="{{ route('admin.member-registrations.edit', $registration) }}" class="text-green-600 hover:text-green-900 mr-3">Editar</a>
                                                    <button
                                                        type="button"
                                                        class="text-red-600 hover:text-red-900 single-delete-btn"
                                                        data-url="{{ route('admin.member-registrations.destroy', $registration) }}"
                                                    >
                                                        Excluir
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <div class="mt-4">
                            {{ $registrations->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">Nenhum cadastro encontrado.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const toggleCreateFormBtn = document.getElementById('toggle-create-form');
            const cancelCreateFormBtn = document.getElementById('cancel-create-form');
            const createFormWrapper = document.getElementById('create-form-wrapper');
            const selectAllCheckbox = document.getElementById('select-all');
            const rowCheckboxes = Array.from(document.querySelectorAll('.row-checkbox'));
            const selectedCount = document.getElementById('selected-count');
            const bulkActionInput = document.getElementById('bulk-action-input');
            const bulkStatusButton = document.getElementById('bulk-status-btn');
            const bulkDeleteButton = document.getElementById('bulk-delete-btn');
            const bulkStatus = document.getElementById('bulk-status');
            const singleDeleteButtons = Array.from(document.querySelectorAll('.single-delete-btn'));

            function updateSelectedCount() {
                const checked = rowCheckboxes.filter((checkbox) => checkbox.checked).length;
                selectedCount.textContent = String(checked);
            }

            if (toggleCreateFormBtn && createFormWrapper) {
                toggleCreateFormBtn.addEventListener('click', function () {
                    createFormWrapper.classList.toggle('hidden');
                });
            }

            if (cancelCreateFormBtn && createFormWrapper) {
                cancelCreateFormBtn.addEventListener('click', function () {
                    createFormWrapper.classList.add('hidden');
                });
            }

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function () {
                    rowCheckboxes.forEach((checkbox) => {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                    updateSelectedCount();
                });
            }

            rowCheckboxes.forEach((checkbox) => {
                checkbox.addEventListener('change', function () {
                    if (!checkbox.checked && selectAllCheckbox) {
                        selectAllCheckbox.checked = false;
                    }

                    if (selectAllCheckbox && rowCheckboxes.every((item) => item.checked)) {
                        selectAllCheckbox.checked = true;
                    }

                    updateSelectedCount();
                });
            });

            if (bulkStatusButton) {
                bulkStatusButton.addEventListener('click', function (event) {
                    bulkActionInput.value = 'update_status';

                    if (!bulkStatus.value) {
                        event.preventDefault();
                        alert('Selecione um status para aplicar em lote.');
                        return;
                    }

                    if (!rowCheckboxes.some((checkbox) => checkbox.checked)) {
                        event.preventDefault();
                        alert('Selecione ao menos um cadastro.');
                    }
                });
            }

            if (bulkDeleteButton) {
                bulkDeleteButton.addEventListener('click', function (event) {
                    bulkActionInput.value = 'delete';

                    if (!rowCheckboxes.some((checkbox) => checkbox.checked)) {
                        event.preventDefault();
                        alert('Selecione ao menos um cadastro.');
                        return;
                    }

                    if (!confirm('Tem certeza que deseja excluir os cadastros selecionados?')) {
                        event.preventDefault();
                    }
                });
            }

            singleDeleteButtons.forEach((button) => {
                button.addEventListener('click', function () {
                    if (!confirm('Tem certeza que deseja excluir este cadastro?')) {
                        return;
                    }

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = button.dataset.url;

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';

                    form.appendChild(csrfInput);
                    form.appendChild(methodInput);
                    document.body.appendChild(form);
                    form.submit();
                });
            });
        })();
    </script>
</x-admin-layout>
