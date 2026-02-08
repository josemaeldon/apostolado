<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                👥 Cadastros de Membros
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:text-blue-800">
                ← Voltar ao Painel
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">🔍 Filtros de Busca</h3>
                    <form method="GET" action="{{ route('admin.member-registrations.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Name Search -->
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                       placeholder="Buscar por nome..."
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- Parish Filter -->
                            <div>
                                <label for="parish" class="block text-sm font-medium text-gray-700 mb-1">Paróquia</label>
                                <select name="parish" id="parish" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Todas as paróquias</option>
                                    @foreach($parishes as $parish)
                                        <option value="{{ $parish }}" {{ request('parish') == $parish ? 'selected' : '' }}>{{ $parish }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Todos os status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendente</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Aprovado</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejeitado</option>
                                </select>
                            </div>

                            <!-- City Filter -->
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Cidade</label>
                                <select name="city" id="city" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Todas as cidades</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date From -->
                            <div>
                                <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Data Inicial</label>
                                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- Date To -->
                            <div>
                                <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Data Final</label>
                                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        <!-- Filter Buttons -->
                        <div class="flex gap-2">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition">
                                Filtrar
                            </button>
                            <a href="{{ route('admin.member-registrations.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-medium transition">
                                Limpar Filtros
                            </a>
                        </div>
                    </form>
                    
                    <!-- Export PDF Button -->
                    @if($registrations->total() > 0)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <form method="GET" action="{{ route('admin.member-registrations.export-pdf') }}" class="flex items-center gap-3">
                            <!-- Pass all current filter parameters -->
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="parish" value="{{ request('parish') }}">
                            <input type="hidden" name="status" value="{{ request('status') }}">
                            <input type="hidden" name="city" value="{{ request('city') }}">
                            <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                            <input type="hidden" name="date_to" value="{{ request('date_to') }}">
                            
                            <button type="submit" class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                                </svg>
                                Exportar PDF
                            </button>
                            <span class="text-sm text-gray-600">
                                ({{ $registrations->total() }} cadastro{{ $registrations->total() != 1 ? 's' : '' }} será{{ $registrations->total() != 1 ? 'ão' : '' }} exportado{{ $registrations->total() != 1 ? 's' : '' }})
                            </span>
                        </form>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-6">Lista de Cadastros</h3>

                    @if($registrations->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paróquia</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($registrations as $registration)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $registration->full_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $registration->email }}</td>
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
                                                <form action="{{ route('admin.member-registrations.destroy', $registration) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este cadastro?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
</x-app-layout>
