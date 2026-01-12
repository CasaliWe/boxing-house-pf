@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-2xl font-semibold text-white mb-6">Alunos</h1>

    <div class="mb-4 flex items-center gap-2">
        <a href="{{ route('professor.alunos.index') }}" class="px-3 py-2 rounded {{ !$status ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-200' }}">Todos</a>
        <a href="{{ route('professor.alunos.index', ['status' => 'ativo']) }}" class="px-3 py-2 rounded {{ $status==='ativo' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-200' }}">Ativos</a>
        <a href="{{ route('professor.alunos.index', ['status' => 'inativo']) }}" class="px-3 py-2 rounded {{ $status==='inativo' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-200' }}">Inativos</a>
        <a href="{{ route('professor.alunos.index', ['status' => 'pendente']) }}" class="px-3 py-2 rounded {{ $status==='pendente' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-200' }}">Pendentes</a>
    </div>

    <div class="bg-gray-800 rounded-lg shadow p-4 overflow-x-auto">
        <table class="min-w-full text-left text-gray-200">
            <thead>
                <tr>
                    <th class="py-3 px-4">Aluno</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Vencimento</th>
                    <th class="py-3 px-4">Ações</th>
                </tr>
            </thead>
            <tbody>
            @forelse($alunos as $u)
                @php
                    $st = App\Http\Controllers\Professor\AlunoController::vencimentoStatus($u->vencimento_at);
                    $badgeClass = match($st){
                        'ok' => 'bg-green-700 text-white',
                        'vencendo' => 'bg-yellow-600 text-white',
                        'vencida' => 'bg-red-700 text-white',
                        default => 'bg-gray-600 text-white',
                    };
                @endphp
                <tr class="border-t border-gray-700">
                    <td class="py-3 px-4">
                        <div class="font-semibold">{{ $u->name }}</div>
                        <div class="text-sm text-gray-400">{{ $u->email }}</div>
                    </td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 rounded bg-gray-700 text-gray-200">{{ ucfirst($u->status) }}</span>
                    </td>
                    <td class="py-3 px-4">
                        @if($u->vencimento_at)
                            <span class="px-2 py-1 rounded {{ $badgeClass }}">{{ \Illuminate\Support\Carbon::parse($u->vencimento_at)->format('d/m/Y') }}</span>
                        @else
                            <span class="px-2 py-1 rounded bg-gray-600 text-white">-</span>
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-2">
                            <form method="POST" action="{{ route('professor.alunos.senha', $u) }}" class="flex items-center gap-2">
                                @csrf
                                <input type="password" name="password" placeholder="Nova senha" class="bg-gray-900 border border-gray-700 rounded p-2 text-white" required>
                                <input type="password" name="password_confirmation" placeholder="Confirmar" class="bg-gray-900 border border-gray-700 rounded p-2 text-white" required>
                                <button class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">Alterar senha</button>
                            </form>
                            <form method="POST" action="{{ route('professor.alunos.destroy', $u) }}" onsubmit="return confirm('Confirma remover este aluno?');">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded">Excluir</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="py-6 text-center text-gray-400">Nenhum aluno encontrado.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $alunos->links() }}</div>
    </div>
</div>
@endsection
