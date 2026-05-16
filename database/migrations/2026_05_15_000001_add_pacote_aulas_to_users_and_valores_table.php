<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adiciona o modelo de cobrança por aulas.
     */
    public function up(): void
    {
        Schema::table('valores', function (Blueprint $table) {
            if (!Schema::hasColumn('valores', 'tipo')) {
                $table->string('tipo', 20)->default('pacote')->after('id');
            }

            if (!Schema::hasColumn('valores', 'aulas_mes')) {
                $table->unsignedSmallInteger('aulas_mes')->nullable()->after('tipo');
            }

            if (!Schema::hasColumn('valores', 'valor_aula')) {
                $table->decimal('valor_aula', 8, 2)->nullable()->after('aulas_mes');
            }
        });

        // O campo antigo continua existindo por compatibilidade, mas nao pode mais limitar os pacotes.
        try {
            Schema::table('valores', function (Blueprint $table) {
                $table->dropUnique('uniq_valor_vezes_semana');
            });
        } catch (Throwable $e) {
            // Banco ja sem indice ou driver nao exige remocao explicita.
        }

        $agora = now();

        DB::table('valores')->orderBy('id')->get()->each(function ($valor) {
            $vezesSemana = (int) ($valor->vezes_semana ?? 0);
            $valorAtual = (float) ($valor->valor ?? 0);

            if ($vezesSemana === 5) {
                DB::table('valores')->where('id', $valor->id)->update([
                    'tipo' => 'experimental',
                    'aulas_mes' => null,
                    'valor_aula' => $valor->valor_aula ?? $valorAtual,
                ]);

                return;
            }

            $aulasMes = $valor->aulas_mes ?: max($vezesSemana * 4, 1);
            $valorAula = $valor->valor_aula ?: ($aulasMes > 0 ? ($valorAtual / $aulasMes) : $valorAtual);

            DB::table('valores')->where('id', $valor->id)->update([
                'tipo' => 'pacote',
                'aulas_mes' => $aulasMes,
                'valor_aula' => number_format($valorAula, 2, '.', ''),
            ]);
        });

        $pacotesPadrao = [
            ['aulas_mes' => 4, 'valor_aula' => 40],
            ['aulas_mes' => 8, 'valor_aula' => 35],
            ['aulas_mes' => 12, 'valor_aula' => 30],
        ];

        foreach ($pacotesPadrao as $pacote) {
            $existe = DB::table('valores')
                ->where('tipo', 'pacote')
                ->where('aulas_mes', $pacote['aulas_mes'])
                ->exists();

            if (!$existe) {
                DB::table('valores')->insert([
                    'tipo' => 'pacote',
                    'aulas_mes' => $pacote['aulas_mes'],
                    'valor_aula' => $pacote['valor_aula'],
                    'vezes_semana' => $pacote['aulas_mes'],
                    'valor' => $pacote['valor_aula'],
                    'created_at' => $agora,
                    'updated_at' => $agora,
                ]);
            }
        }

        if (!DB::table('valores')->where('tipo', 'experimental')->exists()) {
            DB::table('valores')->insert([
                'tipo' => 'experimental',
                'aulas_mes' => null,
                'valor_aula' => 30,
                'vezes_semana' => 0,
                'valor' => 30,
                'created_at' => $agora,
                'updated_at' => $agora,
            ]);
        }

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'aulas_contratadas')) {
                $table->unsignedSmallInteger('aulas_contratadas')->nullable()->after('plano_vezes');
            }

            if (!Schema::hasColumn('users', 'aulas_restantes')) {
                $table->integer('aulas_restantes')->default(0)->after('aulas_contratadas');
            }

            if (!Schema::hasColumn('users', 'valor_aula')) {
                $table->decimal('valor_aula', 8, 2)->nullable()->after('aulas_restantes');
            }

            if (!Schema::hasColumn('users', 'valor_total_aulas')) {
                $table->decimal('valor_total_aulas', 8, 2)->nullable()->after('valor_aula');
            }

            if (!Schema::hasColumn('users', 'aulas_pacote_at')) {
                $table->date('aulas_pacote_at')->nullable()->after('valor_total_aulas');
            }
        });

        DB::table('users')
            ->where('role', 'aluno')
            ->whereNull('aulas_contratadas')
            ->whereNotNull('plano_vezes')
            ->orderBy('id')
            ->get()
            ->each(function ($aluno) {
                $aulas = max((int) $aluno->plano_vezes * 4, 1);

                DB::table('users')->where('id', $aluno->id)->update([
                    'aulas_contratadas' => $aulas,
                    'aulas_restantes' => $aulas,
                    'aulas_pacote_at' => now()->toDateString(),
                ]);
            });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $colunas = [
                'aulas_contratadas',
                'aulas_restantes',
                'valor_aula',
                'valor_total_aulas',
                'aulas_pacote_at',
            ];

            foreach ($colunas as $coluna) {
                if (Schema::hasColumn('users', $coluna)) {
                    $table->dropColumn($coluna);
                }
            }
        });

        Schema::table('valores', function (Blueprint $table) {
            $colunas = ['tipo', 'aulas_mes', 'valor_aula'];

            foreach ($colunas as $coluna) {
                if (Schema::hasColumn('valores', $coluna)) {
                    $table->dropColumn($coluna);
                }
            }
        });
    }
};
