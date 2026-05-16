<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\Configuracao;
use App\Models\Horario;
use App\Models\Regra;
use App\Models\User;
use App\Models\ValorPlano;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CadastroController extends Controller
{
    protected WhatsAppService $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    public function step1()
    {
        $data = session('cadastro', []);

        return view('public.cadastro.step1', ['data' => $data]);
    }

    public function postStep1(Request $request)
    {
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'idade' => ['nullable', 'integer', 'min:1', 'max:120'],
            'peso' => ['nullable', 'numeric', 'min:0'],
            'whatsapp' => ['required', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'endereco' => ['required', 'string', 'max:255'],
            'contato_emergencia_nome' => ['required', 'string', 'max:255'],
            'contato_emergencia_whatsapp' => ['required', 'string', 'max:255'],
            'data_nascimento' => ['required', 'date'],
            'objetivos' => ['nullable', 'array'],
            'objetivos.*' => ['string', 'in:Perder peso,Condicionamento físico,Parte técnica,Diversão,Competir'],
            'saude_problema' => ['nullable', 'boolean'],
            'saude_descricao' => ['nullable', 'string', 'max:1000', 'required_if:saude_problema,1'],
            'restricao_medica' => ['nullable', 'boolean'],
            'restricao_descricao' => ['nullable', 'string', 'max:1000', 'required_if:restricao_medica,1'],
        ]);

        $dados['saude_problema'] = (bool) ($dados['saude_problema'] ?? false);
        $dados['restricao_medica'] = (bool) ($dados['restricao_medica'] ?? false);
        $dados['objetivos'] = array_values(array_unique($dados['objetivos'] ?? []));

        session(['cadastro' => array_merge(session('cadastro', []), $dados)]);

        return redirect()->route('cadastro.step2');
    }

    public function step2()
    {
        $valores = ValorPlano::pacotes()->orderBy('aulas_mes')->get();
        $valorExperimental = ValorPlano::experimental()->first();
        $horarios = Horario::orderBy('dia_semana')->orderBy('hora_inicio')->get();
        $data = session('cadastro', []);

        return view('public.cadastro.step2', compact('valores', 'valorExperimental', 'horarios', 'data'));
    }

    public function postStep2(Request $request)
    {
        $maximoAulas = (int) (ValorPlano::pacotes()->max('aulas_mes') ?: 12);

        $dados = $request->validate([
            'aulas_mes' => ['required', 'integer', 'min:1', 'max:' . $maximoAulas],
            'horarios' => ['required', 'array'],
            'horarios.*' => ['integer', 'exists:horarios,id'],
        ], [
            'aulas_mes.required' => 'Informe quantas aulas voce quer no mes.',
            'aulas_mes.max' => 'A quantidade maxima cadastrada hoje e de ' . $maximoAulas . ' aulas.',
            'horarios.required' => 'Selecione os horarios desejados.',
        ]);

        $quantidadeAulas = (int) $dados['aulas_mes'];
        $pacote = ValorPlano::pacoteParaQuantidade($quantidadeAulas);

        if (!$pacote) {
            return back()->withErrors(['aulas_mes' => 'Nenhum valor por aula cadastrado para esta quantidade.'])->withInput();
        }

        $limiteHorarios = max(1, (int) ceil($quantidadeAulas / 4));
        $selecionados = array_values(array_unique($dados['horarios']));

        if (count($selecionados) !== $limiteHorarios) {
            return back()->withErrors([
                'horarios' => 'Selecione exatamente ' . $limiteHorarios . ' horario(s) fixo(s) para ' . $quantidadeAulas . ' aula(s) no mes.',
            ])->withInput();
        }

        $semVaga = [];
        foreach (Horario::whereIn('id', $selecionados)->get() as $horario) {
            if ($horario->vagas_disponiveis <= 0) {
                $semVaga[] = $horario->dia_semana_label . ' ' . \Illuminate\Support\Carbon::parse($horario->hora_inicio)->format('H:i');
            }
        }

        if (!empty($semVaga)) {
            return back()->withErrors([
                'horarios' => 'Os seguintes horarios estao FULL e nao podem ser selecionados: ' . implode(', ', $semVaga),
            ])->withInput();
        }

        $valorAula = (float) $pacote->valor_aula;

        session(['cadastro' => array_merge(session('cadastro', []), [
            'plano_vezes' => $limiteHorarios,
            'aulas_mes' => $quantidadeAulas,
            'valor_aula' => $valorAula,
            'valor_total_aulas' => $quantidadeAulas * $valorAula,
            'horarios' => $selecionados,
        ])]);

        return redirect()->route('cadastro.step3');
    }

    public function step3()
    {
        $regras = Regra::where('titulo', 'Regras')
            ->where('ativo', true)
            ->orderByRaw('COALESCE(ordem, 99999) ASC')
            ->get();
        $data = session('cadastro', []);

        return view('public.cadastro.step3', compact('regras', 'data'));
    }

    public function postStep3(Request $request)
    {
        $regras = Regra::where('titulo', 'Regras')->where('ativo', true)->get();
        $rules = [];

        foreach ($regras as $regra) {
            $rules['regras.' . $regra->id] = ['accepted'];
        }

        $request->validate($rules, ['accepted' => 'Voce deve aceitar esta regra.']);

        $cadastro = session('cadastro', []);
        if (empty($cadastro) || empty($cadastro['email'])) {
            return redirect()->route('cadastro.step1')->with('error', 'Sessao expirada. Preencha novamente.');
        }

        $user = new User();
        $user->name = $cadastro['name'];
        $user->email = $cadastro['email'];
        $user->password = Hash::make(Str::random(12));
        $user->role = 'aluno';
        $user->status = 'pendente';
        $user->vencimento_at = null;

        $user->idade = $cadastro['idade'] ?? null;
        $user->peso = isset($cadastro['peso']) ? number_format((float) $cadastro['peso'], 2, '.', '') : null;
        $user->whatsapp = $cadastro['whatsapp'] ?? null;
        $user->instagram = $cadastro['instagram'] ?? null;
        $user->endereco = $cadastro['endereco'] ?? null;
        $user->contato_emergencia_nome = $cadastro['contato_emergencia_nome'] ?? null;
        $user->contato_emergencia_whatsapp = $cadastro['contato_emergencia_whatsapp'] ?? null;
        $user->data_nascimento = $cadastro['data_nascimento'] ?? null;
        $user->saude_problema = (bool) ($cadastro['saude_problema'] ?? false);
        $user->saude_descricao = $cadastro['saude_descricao'] ?? null;
        $user->restricao_medica = (bool) ($cadastro['restricao_medica'] ?? false);
        $user->restricao_descricao = $cadastro['restricao_descricao'] ?? null;
        $user->plano_vezes = $cadastro['plano_vezes'] ?? null;
        $user->aulas_contratadas = $cadastro['aulas_mes'] ?? null;
        $user->aulas_restantes = $cadastro['aulas_mes'] ?? 0;
        $user->valor_aula = isset($cadastro['valor_aula']) ? number_format((float) $cadastro['valor_aula'], 2, '.', '') : null;
        $user->valor_total_aulas = isset($cadastro['valor_total_aulas']) ? number_format((float) $cadastro['valor_total_aulas'], 2, '.', '') : null;
        $user->aulas_pacote_at = now()->toDateString();
        $user->objetivos = $cadastro['objetivos'] ?? [];
        $user->save();

        $this->enviarNotificacaoNovoCadastro($user);

        $horariosIds = $cadastro['horarios'] ?? [];
        if (!empty($horariosIds)) {
            $pivotData = [];
            foreach ($horariosIds as $horarioId) {
                $pivotData[$horarioId] = ['aprovado' => false];
            }

            $user->horarios()->syncWithoutDetaching($pivotData);
        }

        session()->forget('cadastro');

        return redirect()->route('cadastro.final')->with('success', 'Cadastro enviado! Aguardando o pagamento via PIX. Envie o comprovante pelo WhatsApp.');
    }

    public function final()
    {
        $config = Configuracao::first();

        return view('public.cadastro.final', compact('config'));
    }

    /**
     * Envia notificacao WhatsApp para Weslei sobre novo cadastro.
     */
    private function enviarNotificacaoNovoCadastro(User $novoAluno): void
    {
        try {
            $numeroWeslei = '5554991538488';
            $valorAula = $novoAluno->valor_aula ? number_format((float) $novoAluno->valor_aula, 2, ',', '.') : '-';
            $valorTotal = $novoAluno->valor_total_aulas ? number_format((float) $novoAluno->valor_total_aulas, 2, ',', '.') : '-';

            $mensagem = "🥊 *BOXING HOUSE PF* - Novo Cadastro\n\n" .
                "Olá Weslei! 👋\n\n" .
                "🎆 *Novo aluno se cadastrou no sistema!*\n\n" .
                "👤 *Nome:* {$novoAluno->name}\n" .
                "📞 *WhatsApp:* {$novoAluno->whatsapp}\n" .
                "📧 *Email:* {$novoAluno->email}\n\n" .
                "📅 *Status:* Pendente de aprovação\n" .
                "💳 *Pacote:* {$novoAluno->aulas_contratadas} aulas no mês\n" .
                "💰 *Valor por aula:* R$ {$valorAula}\n" .
                "💰 *Total:* R$ {$valorTotal}\n\n" .
                "📈 Acesse o painel administrativo para aprovar o cadastro e enviar as credenciais.\n\n" .
                "_Notificação automática do sistema_";

            $resultado = $this->whatsAppService->enviarMensagem($numeroWeslei, $mensagem);

            if ($resultado === true) {
                Log::info('Notificacao de novo cadastro enviada', [
                    'novo_aluno' => $novoAluno->name,
                    'email' => $novoAluno->email,
                ]);
            } else {
                Log::error('Falha ao enviar notificacao de novo cadastro', [
                    'novo_aluno' => $novoAluno->name,
                    'erro' => is_array($resultado) ? $resultado['erro'] : 'Erro desconhecido',
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Excecao ao enviar notificacao de novo cadastro', [
                'novo_aluno' => $novoAluno->name ?? 'Desconhecido',
                'erro' => $e->getMessage(),
            ]);
        }
    }
}
