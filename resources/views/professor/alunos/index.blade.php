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
                        <button type="button" class="font-semibold text-blue-400 hover:text-blue-300 underline" data-detail-id="student-detail-{{ $u->id }}">{{ $u->name }}</button>
                        <div class="text-sm text-gray-400">{{ $u->email }}</div>
                        <div id="student-detail-{{ $u->id }}" class="hidden">
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <div class="text-gray-400 text-sm">E-mail</div>
                                        <div class="text-white">{{ $u->email }}</div>
                                    </div>
                                    <div>
                                        <div class="text-gray-400 text-sm">WhatsApp</div>
                                        <div class="text-white">{{ $u->whatsapp }}</div>
                                    </div>
                                    <div>
                                        <div class="text-gray-400 text-sm">Instagram</div>
                                        <div class="text-white">{{ $u->instagram ?: '-' }}</div>
                                    </div>
                                    <div>
                                        <div class="text-gray-400 text-sm">Endereço</div>
                                        <div class="text-white">{{ $u->endereco ?: '-' }}</div>
                                    </div>
                                    <div>
                                        <div class="text-gray-400 text-sm">Contato Emergência</div>
                                        <div class="text-white">{{ $u->contato_emergencia_nome ?: '-' }} | {{ $u->contato_emergencia_whatsapp ?: '-' }}</div>
                                    </div>
                                    <div>
                                        <div class="text-red-400 text-sm hidden" data-limit-warning></div>
                                        <div class="text-gray-400 text-sm">Nascimento</div>
                                        <div class="text-white">{{ $u->data_nascimento ? \Illuminate\Support\Carbon::parse($u->data_nascimento)->format('d/m/Y') : '-' }}</div>
                                    </div>
                                    <div>
                                        <div class="text-gray-400 text-sm">Idade</div>
                                        <div class="text-white">{{ $u->idade ?: '-' }}</div>
                                    </div>
                                    <div>
                                        <div class="text-gray-400 text-sm">Peso</div>
                                        <div class="text-white">{{ $u->peso ?: '-' }}</div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <div class="text-gray-400 text-sm">Problema de saúde?</div>
                                        <div class="text-white">{{ $u->saude_problema ? 'Sim' : 'Não' }}</div>
                                        @if($u->saude_problema)
                                            <div class="text-gray-300 mt-2 whitespace-pre-line">{{ $u->saude_descricao }}</div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-gray-400 text-sm">Restrição médica/física?</div>
                                        <div class="text-white">{{ $u->restricao_medica ? 'Sim' : 'Não' }}</div>
                                        @if($u->restricao_medica)
                                            <div class="text-gray-300 mt-2 whitespace-pre-line">{{ $u->restricao_descricao }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <div class="text-gray-400 text-sm">Plano</div>
                                        <div class="text-white">{{ $u->plano_vezes ? $u->plano_vezes.'x/semana' : '-' }}</div>
                                    </div>
                                    <div>
                                        <div class="text-gray-400 text-sm">Vencimento</div>
                                        <div class="text-white">{{ $u->vencimento_at ? \Illuminate\Support\Carbon::parse($u->vencimento_at)->format('d/m/Y') : '-' }}</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-gray-400 text-sm mb-2">Horários selecionados</div>
                                    @if($u->horarios->isEmpty())
                                        <div class="text-gray-300">Nenhum</div>
                                    @else
                                        <ul class="list-disc pl-6 text-gray-200">
                                            @foreach($u->horarios as $h)
                                                <li>{{ $h->dia_semana_label }} - {{ \Illuminate\Support\Carbon::parse($h->hora_inicio)->format('H:i') }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>

                                <div class="mt-6">
                                    <div class="text-gray-400 text-sm mb-2">Editar horários</div>
                                    <form method="POST" action="{{ route('professor.alunos.horarios', $u) }}" class="space-y-4" data-max="{{ (int)($u->plano_vezes ?? 0) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            @php
                                                $selecionados = $u->horarios->pluck('id')->all();
                                            @endphp
                                            @foreach($horarios as $h)
                                                @php
                                                    $temVaga = $h->vagas_disponiveis > 0;
                                                    $jaSelecionado = in_array($h->id, $selecionados);
                                                @endphp
                                                <label class="flex items-center gap-2 bg-gray-800 border border-gray-700 rounded p-2">
                                                    <input type="checkbox" name="horarios[]" value="{{ $h->id }}" class="rounded"
                                                        {{ $jaSelecionado ? 'checked' : '' }}
                                                        {{ !$temVaga && !$jaSelecionado ? 'disabled' : '' }}
                                                        data-initial-disabled="{{ (!$temVaga && !$jaSelecionado) ? '1' : '0' }}">
                                                    <span class="text-gray-200">
                                                        {{ $h->dia_semana_label }} - {{ \Illuminate\Support\Carbon::parse($h->hora_inicio)->format('H:i') }}
                                                        <span class="ml-2 text-xs px-2 py-0.5 rounded {{ $temVaga ? 'bg-green-700 text-white' : 'bg-red-700 text-white' }}">
                                                            {{ $temVaga ? ($h->vagas_disponiveis.' vaga(s)') : 'Sem vagas' }}
                                                        </span>
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                        <div class="text-red-400 text-sm hidden" data-limit-warning></div>
                                        <div class="text-xs text-gray-400" data-counter></div>
                                        <div class="text-xs text-gray-400">Dica: respeite o plano do aluno ({{ $u->plano_vezes ?: '-' }}x/semana).</div>
                                        <div>
                                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">Salvar horários</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
<div id="studentModal" class="fixed inset-0 z-50 hidden">
    <div id="studentModalOverlay" class="absolute inset-0 bg-black/70"></div>
    <div class="relative w-full max-w-3xl mx-auto mt-16 bg-gray-900 border border-gray-700 rounded-xl text-gray-200 shadow-lg flex flex-col">
        <div class="sticky top-0 flex justify-between items-center px-6 py-4 border-b border-gray-700 bg-gray-900 rounded-t-xl">
            <h2 class="text-xl font-semibold">Detalhes do Aluno</h2>
            <button id="closeStudentModal" class="px-3 py-2 bg-gray-700 hover:bg-gray-600 rounded">Fechar</button>
        </div>
        <div id="studentModalContent" class="px-6 py-4 space-y-4 max-h-[70vh] overflow-y-auto"></div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function(){
    const modal = document.getElementById('studentModal');
    const content = document.getElementById('studentModalContent');
    const closeBtn = document.getElementById('closeStudentModal');
    const overlay = document.getElementById('studentModalOverlay');
    document.querySelectorAll('[data-detail-id]').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-detail-id');
            const tpl = document.getElementById(id);
            if(!tpl) return;
            content.innerHTML = tpl.innerHTML;
            modal.classList.remove('hidden');

            // Limitar seleção de horários pelo plano do aluno
            const form = content.querySelector('form[data-max]');
            if (form) {
                const max = parseInt(form.dataset.max, 10);
                const warn = form.querySelector('[data-limit-warning]');
                const counter = form.querySelector('[data-counter]');
                const boxes = Array.from(form.querySelectorAll('input[name="horarios[]"]'));
                const showWarn = (msg) => {
                    if (warn) { warn.textContent = msg; warn.classList.remove('hidden'); }
                };
                const hideWarn = () => {
                    if (warn) { warn.classList.add('hidden'); }
                };
                const updateState = () => {
                    const checkedCount = boxes.filter(b => b.checked).length;
                    if (counter) {
                        if (Number.isFinite(max) && max > 0) {
                            counter.textContent = `Selecionados: ${checkedCount} de ${max}`;
                        } else {
                            counter.textContent = '';
                        }
                    }
                    hideWarn();
                    if (Number.isFinite(max) && max > 0) {
                        const limitReached = checkedCount >= max;
                        boxes.forEach(b => {
                            if (!b.checked) {
                                const initiallyDisabled = b.dataset.initialDisabled === '1';
                                b.disabled = limitReached ? true : (initiallyDisabled ? true : false);
                            }
                        });
                    }
                };
                boxes.forEach(box => {
                    box.addEventListener('change', () => {
                        const checkedCount = boxes.filter(b => b.checked).length;
                        if (Number.isFinite(max) && max > 0 && checkedCount > max) {
                            box.checked = false;
                            showWarn(`Você só pode selecionar ${max} horário(s) conforme o plano.`);
                        }
                        updateState();
                    });
                });
                updateState();
            }
        });
    });
    closeBtn.addEventListener('click', ()=> modal.classList.add('hidden'));
    overlay.addEventListener('click', ()=> modal.classList.add('hidden'));
});
</script>
@endsection
