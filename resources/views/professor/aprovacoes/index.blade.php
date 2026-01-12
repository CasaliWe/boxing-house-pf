@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-semibold text-white mb-6">Aprovações de Cadastro</h1>

    <div class="bg-gray-800 rounded-lg shadow p-4">
        <table class="min-w-full text-left text-gray-200">
            <thead>
                <tr>
                    <th class="py-3 px-4">Aluno</th>
                    <th class="py-3 px-4">Contato</th>
                    <th class="py-3 px-4">Plano</th>
                    <th class="py-3 px-4">Horários</th>
                    <th class="py-3 px-4">Ação</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendentes as $u)
                    <tr class="border-t border-gray-700">
                        <td class="py-3 px-4">{{ $u->name }}<br><span class="text-sm text-gray-400">{{ $u->email }}</span></td>
                        <td class="py-3 px-4">
                            <div>WhatsApp: {{ $u->whatsapp }}</div>
                            @if($u->instagram)
                                <div>IG: {{ $u->instagram }}</div>
                            @endif
                        </td>
                        <td class="py-3 px-4">{{ $u->plano_vezes ? $u->plano_vezes.'x/semana' : '-' }}</td>
                        <td class="py-3 px-4">
                            @if($u->horarios->isEmpty())
                                <span class="text-gray-400">Nenhum selecionado</span>
                            @else
                                <ul class="list-disc pl-6">
                                    @foreach($u->horarios as $h)
                                        <li>{{ $h->dia_semana_label }} - {{ \Illuminate\Support\Carbon::parse($h->hora_inicio)->format('H:i') }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <form method="POST" action="{{ route('professor.aprovacoes.aprovar', $u) }}">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">Aprovar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-400">Nenhum cadastro pendente.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $pendentes->links() }}</div>
    </div>
</div>
@endsection
