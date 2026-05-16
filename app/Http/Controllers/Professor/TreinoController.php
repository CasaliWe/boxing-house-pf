<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Treino;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TreinoController extends Controller
{
    /**
     * Lista treinos.
     */
    public function index()
    {
        $treinos = Treino::withCount('alunos')->orderByDesc('data')->paginate(12);
        return view('professor.treinos.index', compact('treinos'));
    }

    /**
     * Form criar.
     */
    public function create()
    {
        $alunos = User::query()
            ->where('role', 'aluno')
            ->where('status', 'ativo')
            ->orderBy('name')
            ->get();
        return view('professor.treinos.create', compact('alunos'));
    }

    /**
     * Salvar novo treino.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'data' => ['required', 'date'],
            'foto' => ['required', 'image', 'max:4096'],
            'especial' => ['nullable', 'boolean'],
            'alunos' => ['nullable', 'array'],
            'alunos.*' => ['exists:users,id'],
        ]);

        $arquivo = $request->file('foto');
        $nomeArquivo = 'treino-' . time() . '-' . uniqid() . '.' . $arquivo->getClientOriginalExtension();
        
        // Criar diretório se não existir
        $diretorio = public_path('uploads/treinos');
        if (!file_exists($diretorio)) {
            mkdir($diretorio, 0755, true);
        }
        
        // Mover arquivo para public
        $arquivo->move($diretorio, $nomeArquivo);
        $path = 'uploads/treinos/' . $nomeArquivo;

        $treino = Treino::create([
            'data' => $dados['data'],
            'foto_path' => $path,
            'especial' => (bool)($dados['especial'] ?? false),
        ]);

        $alunos = $dados['alunos'] ?? [];
        $treino->alunos()->sync($alunos);
        $this->descontarAulas($alunos, $treino);

        return redirect()->route('professor.treinos.index')
            ->with('success', 'Treino criado com sucesso.');
    }

    /**
     * Visualizar treino.
     */
    public function show(Treino $treino)
    {
        $treino->load('alunos');
        return view('professor.treinos.show', compact('treino'));
    }

    /**
     * Form editar.
     */
    public function edit(Treino $treino)
    {
        $alunos = User::query()
            ->where('role', 'aluno')
            ->where('status', 'ativo')
            ->orderBy('name')
            ->get();
        $treino->load('alunos');
        return view('professor.treinos.edit', compact('treino', 'alunos'));
    }

    /**
     * Atualizar treino.
     */
    public function update(Request $request, Treino $treino)
    {
        $alunosAntes = $treino->alunos()->pluck('users.id')->all();

        $dados = $request->validate([
            'data' => ['required', 'date'],
            'foto' => ['nullable', 'image', 'max:4096'],
            'especial' => ['nullable', 'boolean'],
            'alunos' => ['nullable', 'array'],
            'alunos.*' => ['exists:users,id'],
        ]);

        $update = [
            'data' => $dados['data'],
            'especial' => (bool)($dados['especial'] ?? false),
        ];

        if ($request->hasFile('foto')) {
            // Apagar foto antiga e salvar nova
            if ($treino->foto_path) {
                $caminhoAntigo = public_path($treino->foto_path);
                if (file_exists($caminhoAntigo)) {
                    unlink($caminhoAntigo);
                }
            }
            
            $arquivo = $request->file('foto');
            $nomeArquivo = 'treino-' . time() . '-' . uniqid() . '.' . $arquivo->getClientOriginalExtension();
            
            // Criar diretório se não existir
            $diretorio = public_path('uploads/treinos');
            if (!file_exists($diretorio)) {
                mkdir($diretorio, 0755, true);
            }
            
            // Mover arquivo para public
            $arquivo->move($diretorio, $nomeArquivo);
            $update['foto_path'] = 'uploads/treinos/' . $nomeArquivo;
        }

        $treino->update($update);

        $alunosDepois = $dados['alunos'] ?? [];
        $treino->alunos()->sync($alunosDepois);
        $this->sincronizarSaldoAulas($alunosAntes, $alunosDepois, $treino);

        return redirect()->route('professor.treinos.index')
            ->with('success', 'Treino atualizado com sucesso.');
    }

    /**
     * Excluir treino.
     */
    public function destroy(Treino $treino)
    {
        $alunosAntes = $treino->alunos()->pluck('users.id')->all();

        // Remove foto
        if ($treino->foto_path) {
            $caminhoArquivo = public_path($treino->foto_path);
            if (file_exists($caminhoArquivo)) {
                unlink($caminhoArquivo);
            }
        }

        $treino->delete();
        $this->devolverAulas($alunosAntes);
        return redirect()->route('professor.treinos.index')
            ->with('success', 'Treino excluído com sucesso.');
    }

    /**
     * Ajusta saldo conforme inclusao/remocao de presencas.
     */
    private function sincronizarSaldoAulas(array $alunosAntes, array $alunosDepois, Treino $treino): void
    {
        $antes = collect($alunosAntes)->map(fn ($id) => (int) $id)->unique();
        $depois = collect($alunosDepois)->map(fn ($id) => (int) $id)->unique();

        $this->descontarAulas($depois->diff($antes)->all(), $treino);
        $this->devolverAulas($antes->diff($depois)->all());
    }

    private function descontarAulas(array $alunosIds, Treino $treino): void
    {
        User::whereIn('id', $alunosIds)->where('role', 'aluno')->get()->each(function (User $aluno) use ($treino) {
            $aluno->consumirAulas();
            $aluno->refresh();
            $this->enviarNotificacaoTreinoSalvo($aluno, $treino);
        });
    }

    private function devolverAulas(array $alunosIds): void
    {
        User::whereIn('id', $alunosIds)->where('role', 'aluno')->get()->each(function (User $aluno) {
            $aluno->devolverAulas();
        });
    }

    private function enviarNotificacaoTreinoSalvo(User $aluno, Treino $treino): void
    {
        if (empty($aluno->whatsapp)) {
            return;
        }

        try {
            $tipoTreino = $treino->especial ? 'treino especial' : 'treino';
            $dataTreino = $treino->data?->format('d/m/Y') ?? now()->format('d/m/Y');
            $aulasRestantes = (int) ($aluno->aulas_restantes ?? 0);
            $linkSistema = route('aluno.treinos');

            $mensagem = "🥊 *BOXING HOUSE PF* 🥊\n\n" .
                "Olá {$aluno->name}! Seu {$tipoTreino} do dia {$dataTreino} foi salvo no sistema.\n\n" .
                "📌 *Aulas restantes:* {$aulasRestantes}\n\n" .
                "Acesse o sistema para ver a aula cadastrada:\n{$linkSistema}\n\n" .
                "_Mensagem enviada automaticamente pelo sistema_";

            $resultado = app(WhatsAppService::class)->enviarMensagem($aluno->whatsapp, $mensagem);

            if ($resultado !== true) {
                Log::error('Falha ao enviar WhatsApp de treino salvo', [
                    'aluno_id' => $aluno->id,
                    'treino_id' => $treino->id,
                    'erro' => $resultado,
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Excecao ao enviar WhatsApp de treino salvo', [
                'aluno_id' => $aluno->id,
                'treino_id' => $treino->id,
                'erro' => $e->getMessage(),
            ]);
        }
    }
}
