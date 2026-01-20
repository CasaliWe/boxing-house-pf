@extends('layouts.app')

@section('title', 'Gerenciar Mensalidades')

@section('content')
<div class="space-y-8">
    <!-- Cabeçalho -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="w-full sm:w-auto">
            <h1 class="text-2xl md:text-3xl font-bold text-blue-400">💳 Gerenciar Mensalidades</h1>
            <p class="text-gray-400 text-sm md:text-base">Reative alunos após confirmação de pagamento.</p>
        </div>
        <button onclick="executarComando()" class="bg-yellow-600 hover:bg-yellow-700 text-white px-5 py-3 rounded-lg font-medium transition-colors w-full sm:w-auto text-center">
            🔄 Verificar Mensalidades
        </button>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        @if($alunosInativos->isEmpty())
            <div class="text-center py-12 text-gray-300">
                <div class="text-4xl mb-4">✅</div>
                <p>Nenhum aluno inativo por mensalidade vencida.</p>
            </div>
        @else
            <div class="space-y-6">
                @foreach($alunosInativos as $aluno)
                    <div class="bg-gray-800 border border-red-600/50 rounded-lg p-6">
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-white mb-2">{{ $aluno->name }}</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                                    <div>
                                        <span class="text-gray-400">E-mail:</span>
                                        <span class="text-gray-200 block">{{ $aluno->email }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-400">WhatsApp:</span>
                                        <span class="text-gray-200 block">{{ $aluno->whatsapp ?: '-' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-400">Venceu em:</span>
                                        <span class="text-red-400 font-semibold block">{{ $aluno->vencimento_at ? $aluno->vencimento_at->format('d/m/Y') : '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                                <button onclick="abrirModalReativar({{ $aluno->id }}, '{{ $aluno->name }}')" 
                                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded font-medium transition-colors">
                                    ✅ Reativar
                                </button>
                                @if($aluno->whatsapp)
                                    <a href="https://wa.me/55{{ preg_replace('/\D/', '', $aluno->whatsapp) }}?text=Olá {{ $aluno->name }}! Sua mensalidade está em atraso. Para reativar seu acesso, realize o pagamento e envie o comprovante." 
                                       target="_blank"
                                       class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded font-medium transition-colors text-center">
                                        💬 WhatsApp
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginação -->
            <div class="mt-6">
                {{ $alunosInativos->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Reativar -->
<div id="modalReativar" class="fixed inset-0 z-50 hidden bg-black/60">
    <div class="absolute inset-0 flex items-center justify-center p-4" onclick="fecharModal()">
        <div class="bg-gray-900 border border-gray-700 rounded-xl shadow-lg w-full max-w-md" onclick="event.stopPropagation();">
            <div class="flex items-center justify-between p-6 pb-4">
                <h3 id="modalTitulo" class="text-xl font-bold text-white">Reativar Aluno</h3>
                <button class="text-gray-300 hover:text-white" onclick="fecharModal()">✕</button>
            </div>
            <form id="formReativar" method="POST" class="px-6 pb-6">
                @csrf
                <div class="space-y-4">
                    <p id="modalTexto" class="text-gray-300"></p>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Nova data de vencimento</label>
                        <input type="date" name="novo_vencimento" 
                               min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}"
                               value="{{ \Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}"
                               class="w-full bg-gray-800 border border-gray-600 rounded-lg p-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" 
                               required>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="fecharModal()" class="px-4 py-2 border border-gray-600 text-gray-200 rounded-lg hover:bg-gray-700">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">
                        Reativar Aluno
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function abrirModalReativar(id, nome) {
        const modal = document.getElementById('modalReativar');
        const form = document.getElementById('formReativar');
        const titulo = document.getElementById('modalTitulo');
        const texto = document.getElementById('modalTexto');
        
        titulo.textContent = 'Reativar Aluno';
        texto.textContent = `Confirma a reativação de ${nome}?`;
        form.action = `/professor/mensalidades/${id}/reativar`;
        
        modal.classList.remove('hidden');
    }
    
    function fecharModal() {
        document.getElementById('modalReativar').classList.add('hidden');
    }
    
    function executarComando() {
        if (confirm('Executar verificação de mensalidades vencidas? Isso tornará inativos os alunos com mensalidade em atraso.')) {
            fetch('/professor/mensalidades/verificar', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Erro: ' + (data.message || 'Erro desconhecido'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erro ao executar verificação');
            });
        }
    }
</script>
@endsection