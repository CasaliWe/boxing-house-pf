@extends('layouts.app')

@section('title', 'Alunos')
@section('content')
<div class="space-y-8">
    <!-- Cabeçalho -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="w-full sm:w-auto">
            <h1 class="text-2xl md:text-3xl font-bold text-blue-400">👥 Alunos</h1>
            <p class="text-gray-400 text-sm md:text-base">Gerencie os alunos, ajuste horários e atualize senhas.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('professor.alunos.index') }}" class="px-3 py-2 rounded {{ !$status ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-200' }}">Todos</a>
            <a href="{{ route('professor.alunos.index', ['status' => 'ativo']) }}" class="px-3 py-2 rounded {{ $status==='ativo' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-200' }}">Ativos</a>
            <a href="{{ route('professor.alunos.index', ['status' => 'inativo']) }}" class="px-3 py-2 rounded {{ $status==='inativo' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-200' }}">Inativos</a>
            <a href="{{ route('professor.alunos.index', ['status' => 'pendente']) }}" class="px-3 py-2 rounded {{ $status==='pendente' ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-200' }}">Pendentes</a>
        </div>
    </div>

    <!-- Lista em cards no mesmo padrão de Aprovações -->
    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        @if($alunos->isEmpty())
            <div class="text-center py-12 text-gray-300">Nenhum aluno encontrado.</div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($alunos as $u)
                    @php
                        $selecionadosIds = $u->horarios->pluck('id')->toArray();
                        $st = App\Http\Controllers\Professor\AlunoController::vencimentoStatus($u->vencimento_at);
                        $badgeClass = match($st){
                            'ok' => 'bg-green-700 text-white',
                            'vencendo' => 'bg-yellow-600 text-white',
                            'vencida' => 'bg-red-700 text-white',
                            default => 'bg-gray-600 text-white',
                        };
                    @endphp
                    <div class="border border-gray-600 rounded-lg p-5 bg-gray-800/40 flex flex-col gap-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="text-white font-semibold break-words whitespace-normal">{{ $u->name }}</div>
                                <div class="text-gray-400 text-sm break-words whitespace-normal">{{ $u->email }}</div>
                            </div>
                            <div class="text-right text-sm flex-shrink-0">
                                <div class="text-gray-400">Plano</div>
                                <div class="text-blue-400 font-bold">{{ $u->plano_vezes ? $u->plano_vezes.'x/semana' : '-' }}</div>
                                <div class="mt-1 text-gray-400">Vencimento</div>
                                <div class="inline-block mt-1 px-2 py-0.5 rounded text-xs {{ $badgeClass }}">
                                    {{ $u->vencimento_at ? \Illuminate\Support\Carbon::parse($u->vencimento_at)->format('d/m') : '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <div class="text-gray-400">WhatsApp</div>
                                <div class="text-gray-200 break-words">{{ $u->whatsapp ?: '-' }}</div>
                            </div>
                            <div>
                                <div class="text-gray-400">Instagram</div>
                                <div class="text-gray-200 break-words">{{ $u->instagram ?: '-' }}</div>
                            </div>
                        </div>

                        <div>
                            <div class="text-gray-400 text-sm mb-1">Horários selecionados</div>
                            @if($u->horarios->isEmpty())
                                <div class="text-gray-400 text-sm">Nenhum</div>
                            @else
                                <ul class="space-y-1">
                                    @foreach($u->horarios as $h)
                                        @php $temVaga = $h->vagas_disponiveis > 0; @endphp
                                        <li class="flex items-center justify-between gap-2 text-gray-200">
                                            <span class="whitespace-nowrap">{{ $h->dia_semana_label }} - {{ \Illuminate\Support\Carbon::parse($h->hora_inicio)->format('H:i') }}</span>
                                            <span class="text-xs px-2 py-0.5 rounded {{ $temVaga ? 'bg-green-700 text-white' : 'bg-red-700 text-white' }}">{{ $temVaga ? 'Vaga' : 'FULL' }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        <div class="flex flex-col gap-2">
                            <!-- Ações principais empilhadas (um abaixo do outro) -->
                            <div class="flex flex-col gap-2">
                                <button type="button"
                                    class="w-full px-3 py-2 h-10 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-sm"
                                    data-user="{{ $u->id }}"
                                    data-plano="{{ (int)($u->plano_vezes ?? 0) }}"
                                    data-selecionados='@json($selecionadosIds)'
                                    onclick="abrirModalHorarios(this)">
                                    Atualizar
                                </button>
                                <button type="button"
                                    class="w-full px-3 py-2 h-10 rounded-md bg-gray-700 hover:bg-gray-600 text-white text-sm"
                                    data-detail-id="detail-{{ $u->id }}"
                                    onclick="abrirModalDetalhes(this)">
                                    Detalhes
                                </button>
                                <button type="button"
                                    class="w-full px-3 py-2 h-10 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm"
                                    data-user="{{ $u->id }}"
                                    onclick="abrirModalSenha(this)">
                                    Senha
                                </button>
                            </div>
                            <form method="POST" action="{{ route('professor.alunos.destroy', $u) }}" onsubmit="return confirm('Confirma remover este aluno?');" class="flex">
                                @csrf
                                @method('DELETE')
                                <button class="w-full h-10 px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded text-sm">Excluir</button>
                            </form>
                        </div>

                        <!-- Template escondido para modal de detalhes -->
                        <div id="detail-{{ $u->id }}" class="hidden">
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <div class="text-gray-400 text-sm">E-mail</div>
                                        <div class="text-white">{{ $u->email }}</div>
                                    </div>
                                    <div>
                                        <div class="text-gray-400 text-sm">WhatsApp</div>
                                        <div class="text-white">{{ $u->whatsapp ?: '-' }}</div>
                                    </div>
                                    <div>
                                        <div class="text-gray-400 text-sm">Instagram</div>
                                        <div class="text-white">{{ $u->instagram ?: '-' }}</div>
                                    </div>
                                    <div>
                                        <div class="text-gray-400 text-sm">Endereço</div>
                                        <div class="text-white">{{ $u->endereco ?: '-' }}</div>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <div class="text-gray-400 text-sm">Contato Emergência</div>
                                        <div class="text-white">{{ $u->contato_emergencia_nome ?: '-' }} | {{ $u->contato_emergencia_whatsapp ?: '-' }}</div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div>
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
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">{{ $alunos->links() }}</div>
        @endif
    </div>
</div>

<!-- Modal de Atualização de Horários (mesmo padrão da página Aprovações) -->
<div id="modalHorarios" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="absolute inset-0 bg-black/60" onclick="fecharModalHorarios()"></div>
    <div class="relative max-w-2xl mx-auto my-16 bg-gray-900 border border-gray-700 rounded-xl shadow-lg p-6 max-h-[85vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-white">Atualizar Horários do Aluno</h2>
            <button class="text-gray-300 hover:text-white" onclick="fecharModalHorarios()">✕</button>
        </div>
        <form id="formModalHorarios" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($horarios as $h)
                    @php $temVaga = $h->vagas_disponiveis > 0; @endphp
                    <label class="border border-gray-600 rounded-lg p-4 bg-gray-800/40 flex items-center gap-3 {{ $temVaga ? 'cursor-pointer hover:border-blue-500' : 'cursor-not-allowed opacity-70' }}">
                        <input type="checkbox" name="horarios[]" value="{{ $h->id }}" {{ $temVaga ? '' : 'disabled' }} class="text-blue-500">
                        <div>
                            <div class="text-white font-semibold flex items-center gap-2">
                                <span>{{ $h->dia_semana_label }}</span>
                                <span class="text-xs px-2 py-0.5 rounded {{ $temVaga ? 'bg-green-700 text-white' : 'bg-red-700 text-white' }}">{{ $temVaga ? ($h->vagas_disponiveis.' vaga(s)') : 'FULL' }}</span>
                            </div>
                            <div class="text-gray-300">{{ \Illuminate\Support\Carbon::parse($h->hora_inicio)->format('H:i') }} - {{ \Illuminate\Support\Carbon::parse($h->hora_fim)->format('H:i') }}</div>
                        </div>
                    </label>
                @endforeach
            </div>
            <p id="limiteInfo" class="text-xs text-gray-400 mt-2">Selecione até <span id="limiteNum">0</span> horário(s).</p>
            <div class="mt-6 flex items-center justify-end gap-2">
                <button type="button" class="px-4 py-2 rounded-md border border-gray-600 text-gray-200 hover:bg-gray-700" onclick="fecharModalHorarios()">Cancelar</button>
                <button type="submit" class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white">Atualizar</button>
            </div>
        </form>
    </div>
    </div>

<script>
let modalForm, limitePlano = 0;
const baseAction = '{{ url('/professor/alunos') }}';
function abrirModalHorarios(btn){
    const modal = document.getElementById('modalHorarios');
    modal.classList.remove('hidden');
    modalForm = document.getElementById('formModalHorarios');
    const userId = btn.dataset.user;
    limitePlano = parseInt(btn.dataset.plano||'0');
    const selecionados = JSON.parse(btn.dataset.selecionados||'[]');

    // Ajusta action do form para o aluno correto
    modalForm.action = baseAction + '/' + userId + '/horarios';

    // Preseleciona os horários e aplica limite
    const checks = Array.from(modalForm.querySelectorAll('input[type="checkbox"][name="horarios[]"]'));
    checks.forEach(c=>{
        const val = parseInt(c.value);
        c.checked = selecionados.includes(val);
        c.dataset.tempDisabled = '';
        // Se está selecionado e é FULL (veio desabilitado), habilita para permitir desmarcar
        if(c.checked && c.disabled){ c.disabled = false; c.dataset.fullSelected = '1'; }
    });
    document.getElementById('limiteNum').textContent = limitePlano || selecionados.length || 0;
    aplicarLimite(checks);

    // Bind change uma vez
    checks.forEach(c=>{ c.onchange = ()=>aplicarLimite(checks); });
}
function fecharModalHorarios(){
    const modal = document.getElementById('modalHorarios');
    modal.classList.add('hidden');
}

// Modal de Detalhes
function abrirModalDetalhes(btn){
    const tplId = btn.getAttribute('data-detail-id');
    const tpl = document.getElementById(tplId);
    if(!tpl) return;
    const containerId = 'modalDetalhes';
    let modal = document.getElementById(containerId);
    if(!modal){
        // cria modal (uma vez) com mesmo padrão
        const wrapper = document.createElement('div');
        wrapper.id = containerId;
        wrapper.className = 'fixed inset-0 z-50 hidden overflow-y-auto';
        wrapper.innerHTML = `
            <div class="absolute inset-0 bg-black/60" data-close></div>
            <div class="relative max-w-2xl mx-auto my-16 bg-gray-900 border border-gray-700 rounded-xl shadow-lg p-6 max-h-[85vh] overflow-y-auto">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-white">Detalhes do Aluno</h2>
                    <button class="text-gray-300 hover:text-white" data-close>✕</button>
                </div>
                <div id="detalhesConteudo" class="space-y-4"></div>
            </div>`;
        document.body.appendChild(wrapper);
        modal = wrapper;
        modal.addEventListener('click', (e)=>{ if(e.target.hasAttribute('data-close')) modal.classList.add('hidden'); });
    }
    const content = modal.querySelector('#detalhesConteudo');
    content.innerHTML = tpl.innerHTML;
    modal.classList.remove('hidden');
}

// Modal de Senha
function abrirModalSenha(btn){
    const userId = btn.dataset.user;
    const containerId = 'modalSenha';
    let modal = document.getElementById(containerId);
    if(!modal){
        const wrapper = document.createElement('div');
        wrapper.id = containerId;
        wrapper.className = 'fixed inset-0 z-50 hidden overflow-y-auto';
        wrapper.innerHTML = `
            <div class="absolute inset-0 bg-black/60" data-close></div>
            <div class="relative max-w-md mx-auto my-16 bg-gray-900 border border-gray-700 rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-white">Atualizar Senha</h2>
                    <button class="text-gray-300 hover:text-white" data-close>✕</button>
                </div>
                <form id="formSenha" method="POST" class="space-y-4" onsubmit="btnLoading(this)">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="POST">
                    <div class="space-y-2">
                        <label class="block text-sm text-gray-300">Nova senha</label>
                        <input type="password" name="password" class="w-full bg-gray-900 border border-gray-700 rounded p-2 text-white" required>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm text-gray-300">Confirmar senha</label>
                        <input type="password" name="password_confirmation" class="w-full bg-gray-900 border border-gray-700 rounded p-2 text-white" required>
                    </div>
                    <div class="flex items-center justify-end gap-2">
                        <button type="button" class="px-4 py-2 rounded-md border border-gray-600 text-gray-200 hover:bg-gray-700" data-close>Cancelar</button>
                        <button type="submit" class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white">
                            <span class="btn-spin hidden w-4 h-4 border-2 border-white/60 border-t-transparent rounded-full animate-spin"></span>
                            <span class="btn-text">Atualizar</span>
                        </button>
                    </div>
                </form>
            </div>`;
        document.body.appendChild(wrapper);
        modal = wrapper;
        modal.addEventListener('click', (e)=>{ if(e.target.hasAttribute('data-close')) modal.classList.add('hidden'); });
    }
    const form = modal.querySelector('#formSenha');
    form.action = `${baseAction}/${userId}/senha`;
    modal.classList.remove('hidden');
}
// Validação de submissão do modal: bloqueia envios inválidos
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formModalHorarios');
    if (!form) return;
    form.addEventListener('submit', (e) => {
        const selecionados = Array.from(form.querySelectorAll('input[name="horarios[]"]:checked'));
        const info = document.getElementById('limiteInfo');
        let erro = '';
        if (limitePlano && selecionados.length > limitePlano) {
            erro = `Você selecionou ${selecionados.length} e o limite é ${limitePlano}.`;
        } else if (limitePlano && selecionados.length === 0) {
            erro = `Selecione ao menos 1 até o limite de ${limitePlano}.`;
        }
        if (erro) {
            e.preventDefault();
            if (info) {
                info.classList.remove('text-gray-400');
                info.classList.add('text-red-400');
                info.textContent = erro;
            }
            return false;
        }
        if (info) {
            info.classList.remove('text-red-400');
            info.classList.add('text-gray-400');
        }
    });
});
function aplicarLimite(checks){
    if(!limitePlano){ // sem plano definido, não limita
        // Apenas não reabilitar os FULL
        checks.forEach(c=>{
            const label = c.closest('label');
            if(!label) return;
            const isFull = c.hasAttribute('disabled');
            if(!isFull){ label.classList.remove('opacity-70','cursor-not-allowed'); label.classList.add('cursor-pointer'); }
            // Se estava marcado e era FULL selecionado, e desmarcou, volta a desabilitar
            if(!c.checked && c.dataset.fullSelected==='1'){ c.disabled = true; label.classList.add('opacity-70','cursor-not-allowed'); }
        });
        return;
    }
    const marcados = checks.filter(c=>c.checked);
    const disponiveis = checks.filter(c=>!c.checked && !c.disabled);
    if(marcados.length >= limitePlano){
        disponiveis.forEach(c=>{ c.disabled = true; c.dataset.tempDisabled = '1'; c.closest('label')?.classList.add('opacity-70','cursor-not-allowed'); });
    } else {
        checks.forEach(c=>{
            const label = c.closest('label');
            if(!label) return;
            const isTemp = c.dataset.tempDisabled === '1';
            if(isTemp && !c.checked){ c.disabled = false; c.dataset.tempDisabled = ''; label.classList.remove('opacity-70','cursor-not-allowed'); label.classList.add('cursor-pointer'); }
            // Se era FULL selecionado e desmarcou, volta a desabilitar
            if(!c.checked && c.dataset.fullSelected==='1'){ c.disabled = true; label.classList.add('opacity-70','cursor-not-allowed'); }
        });
    }
}

function btnLoading(form){
    if(!form) return;
    const btn = form.querySelector('button[type="submit"]');
    if(!btn) return;
    const txt = btn.querySelector('.btn-text');
    const spn = btn.querySelector('.btn-spin');
    btn.disabled = true;
    btn.classList.add('opacity-70','cursor-not-allowed');
    if(txt) txt.textContent = 'Carregando...';
    if(spn) spn.classList.remove('hidden');
}
</script>
@endsection
