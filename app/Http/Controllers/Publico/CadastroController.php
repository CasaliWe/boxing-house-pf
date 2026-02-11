<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ValorPlano;
use App\Models\Horario;
use App\Models\Regra;
use App\Models\Configuracao;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

        $dados['saude_problema'] = (bool)($dados['saude_problema'] ?? false);
        $dados['restricao_medica'] = (bool)($dados['restricao_medica'] ?? false);
        $dados['objetivos'] = array_values(array_unique($dados['objetivos'] ?? []));

        session(['cadastro' => array_merge(session('cadastro', []), $dados)]);
        return redirect()->route('cadastro.step2');
    }

    public function step2()
    {
        $valores = ValorPlano::orderBy('vezes_semana')->get();
        $horarios = Horario::orderBy('dia_semana')->orderBy('hora_inicio')->get();
        $data = session('cadastro', []);
        return view('public.cadastro.step2', compact('valores', 'horarios', 'data'));
    }

    public function postStep2(Request $request)
    {
        $dados = $request->validate([
            'plano_vezes' => ['required', 'integer', 'between:1,5'],
            'horarios' => ['required', 'array'],
            'horarios.*' => ['integer', 'exists:horarios,id'],
        ], [
            'plano_vezes.required' => 'Selecione um plano (vezes por semana).',
            'horarios.required' => 'Selecione os horários desejados.',
        ]);

        // Garantir quantidade de horários igual ao plano escolhido
        $quant = (int)$dados['plano_vezes'];
        $selecionados = $dados['horarios'];
        if (count($selecionados) !== $quant) {
            return back()->withErrors(['horarios' => 'Selecione exatamente ' . $quant . ' horário(s).'])->withInput();
        }

        // Impedir seleção de horários FULL (sem vagas aprovadas)
        $semVaga = [];
        foreach (\App\Models\Horario::whereIn('id', $selecionados)->get() as $h) {
            if ($h->vagas_disponiveis <= 0) {
                $semVaga[] = $h->dia_semana_label.' '.\Illuminate\Support\Carbon::parse($h->hora_inicio)->format('H:i');
            }
        }
        if (!empty($semVaga)) {
            return back()->withErrors(['horarios' => 'Os seguintes horários estão FULL e não podem ser selecionados: '.implode(', ', $semVaga)])->withInput();
        }

        session(['cadastro' => array_merge(session('cadastro', []), [
            'plano_vezes' => $quant,
            'horarios' => $selecionados,
        ])]);

        return redirect()->route('cadastro.step3');
    }

    public function step3()
    {
        $regras = Regra::where('titulo', 'Regras')->where('ativo', true)->orderByRaw('COALESCE(ordem, 99999) ASC')->get();
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

        $request->validate($rules, ['accepted' => 'Você deve aceitar esta regra.']);

        // Persistir usuário como pendente
        $cad = session('cadastro', []);
        if (empty($cad) || empty($cad['email'])) {
            return redirect()->route('cadastro.step1')->with('error', 'Sessão expirada. Preencha novamente.');
        }

        $user = new User();
        $user->name = $cad['name'];
        $user->email = $cad['email'];
        $user->password = Hash::make(Str::random(12));
        $user->role = 'aluno';
        $user->status = 'pendente';
        $user->vencimento_at = Carbon::now()->addDays(30)->toDateString();

        $user->idade = $cad['idade'] ?? null;
        $user->peso = isset($cad['peso']) ? number_format((float)$cad['peso'], 2, '.', '') : null;
        $user->whatsapp = $cad['whatsapp'] ?? null;
        $user->instagram = $cad['instagram'] ?? null;
        $user->endereco = $cad['endereco'] ?? null;
        $user->contato_emergencia_nome = $cad['contato_emergencia_nome'] ?? null;
        $user->contato_emergencia_whatsapp = $cad['contato_emergencia_whatsapp'] ?? null;
        $user->data_nascimento = $cad['data_nascimento'] ?? null;
        $user->saude_problema = (bool)($cad['saude_problema'] ?? false);
        $user->saude_descricao = $cad['saude_descricao'] ?? null;
        $user->restricao_medica = (bool)($cad['restricao_medica'] ?? false);
        $user->restricao_descricao = $cad['restricao_descricao'] ?? null;
        $user->plano_vezes = $cad['plano_vezes'] ?? null;
        $user->objetivos = $cad['objetivos'] ?? [];

        $user->save();

        // Enviar notificação para Weslei sobre novo cadastro
        $this->enviarNotificacaoNovoCadastro($user);

        // Vincular horários escolhidos com aprovado=false
        $horariosIds = $cad['horarios'] ?? [];
        if (!empty($horariosIds)) {
            $pivotData = [];
            foreach ($horariosIds as $hid) {
                $pivotData[$hid] = ['aprovado' => false];
            }
            $user->horarios()->syncWithoutDetaching($pivotData);
        }

        // Limpa sessão e exibe confirmação
        session()->forget('cadastro');
        return redirect()->route('cadastro.final')->with('success', 'Cadastro enviado! Aguardando o pagamento via PIX. Envie o comprovante pelo WhatsApp.');
    }

    public function final()
    {
        $config = Configuracao::first();
        return view('public.cadastro.final', compact('config'));
    }

    /**
     * Envia notificação WhatsApp para Weslei sobre novo cadastro
     */
    private function enviarNotificacaoNovoCadastro(User $novoAluno)
    {
        try {
            // Número do Weslei (hardcoded)
            $numeroWeslei = '5554991538488';
            
            $mensagem = "🥊 *BOXING HOUSE PF* - Novo Cadastro\n\n" .
                       "Olá Weslei! 👋\n\n" .
                       "🎆 *Novo aluno se cadastrou no sistema!*\n\n" .
                       "👤 *Nome:* {$novoAluno->name}\n" .
                       "📞 *WhatsApp:* {$novoAluno->whatsapp}\n" .
                       "📧 *Email:* {$novoAluno->email}\n\n" .
                       "📅 *Status:* Pendente de aprovação\n" .
                       "💳 *Plano:* {$novoAluno->plano_vezes}x por semana\n\n" .
                       "📈 Acesse o painel administrativo para aprovar o cadastro e enviar as credenciais.\n\n" .
                       "_Notificação automática do sistema_";
            
            $resultado = $this->whatsAppService->enviarMensagem($numeroWeslei, $mensagem);
            
            if ($resultado === true) {
                Log::info('Notificação de novo cadastro enviada', [
                    'novo_aluno' => $novoAluno->name,
                    'email' => $novoAluno->email
                ]);
            } else {
                Log::error('Falha ao enviar notificação de novo cadastro', [
                    'novo_aluno' => $novoAluno->name,
                    'erro' => is_array($resultado) ? $resultado['erro'] : 'Erro desconhecido'
                ]);
            }
            
        } catch (\Exception $e) {
            Log::error('Exceção ao enviar notificação de novo cadastro', [
                'novo_aluno' => $novoAluno->name ?? 'Desconhecido',
                'erro' => $e->getMessage()
            ]);
        }
    }
}
