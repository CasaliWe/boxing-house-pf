@extends('layouts.app')

@section('title', 'Aprovações')
@section('content')
<div class="space-y-8">
    <!-- Cabeçalho -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="w-full sm:w-auto">
            <h1 class="text-2xl md:text-3xl font-bold text-blue-400">✅ Aprovações de Cadastro</h1>
            <p class="text-gray-400 text-sm md:text-base">Revise os dados dos alunos pendentes, ajuste horários e aprove quando houver vagas.</p>
        </div>
    </div>

    <!-- Lista de Pendentes em cards -->
    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        @if($pendentes->isEmpty())
            <div class="text-center py-12 text-gray-300">Nenhum cadastro pendente.</div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($pendentes as $u)
                    @php
                        $selecionadosIds = $u->horarios->pluck('id')->toArray();
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
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <div class="text-gray-400">WhatsApp</div>
                                <div class="text-gray-200 break-words">{{ $u->whatsapp }}</div>
                            </div>
                            @if($u->instagram)
                            <div>
                                <div class="text-gray-400">Instagram</div>
                                <div class="text-gray-200 break-words">{{ $u->instagram }}</div>
                            </div>
                            @endif
                        </div>

                        <div>
                            <div class="text-gray-400 text-sm mb-1">Horários selecionados</div>
                            @if($u->horarios->isEmpty())
                                <div class="text-gray-400 text-sm">Nenhum selecionado</div>
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

                        <div class="flex items-center justify-between gap-2 mt-2">
                                <form method="POST" action="{{ route('professor.aprovacoes.aprovar', $u) }}" class="flex-1" onsubmit="btnLoading(this)">
                                    @csrf
                                    <button type="submit" class="w-full h-11 px-4 py-2 rounded-md bg-green-600 hover:bg-green-700 text-white flex items-center justify-center gap-2">
                                        <span class="btn-spin hidden w-4 h-4 border-2 border-white/60 border-t-transparent rounded-full animate-spin"></span>
                                        <span class="btn-text">Aprovar</span>
                                    </button>
                                </form>
                                <button type="button"
                                    class="flex-1 h-11 px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white"
                                    data-user="{{ $u->id }}"
                                    data-plano="{{ (int)($u->plano_vezes ?? 0) }}"
                                    data-selecionados='@json($selecionadosIds)'
                                    onclick="abrirModalHorarios(this)">
                                Atualizar
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">{{ $pendentes->links() }}</div>
        @endif
    </div>
</div>

<!-- Modal de Atualização de Horários -->
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
