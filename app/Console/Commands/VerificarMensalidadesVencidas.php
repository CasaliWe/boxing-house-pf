<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class VerificarMensalidadesVencidas extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'mensalidade:verificar';

    /**
     * The console command description.
     */
    protected $description = 'Verifica mensalidades vencidas e torna alunos inativos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hoje = Carbon::today();
        
        // Busca alunos ativos com mensalidade vencida
        $alunosVencidos = User::where('role', 'aluno')
            ->where('status', 'ativo')
            ->whereNotNull('vencimento_at')
            ->whereDate('vencimento_at', '<', $hoje)
            ->get();

        $contador = 0;
        
        foreach ($alunosVencidos as $aluno) {
            $aluno->status = 'inativo';
            $aluno->save();
            $contador++;
            
            $this->info("Aluno {$aluno->name} ({$aluno->email}) tornado inativo - Vencimento: {$aluno->vencimento_at->format('d/m/Y')}");
        }

        $this->info("Total de alunos tornados inativos por mensalidade vencida: {$contador}");
        
        return Command::SUCCESS;
    }
}
