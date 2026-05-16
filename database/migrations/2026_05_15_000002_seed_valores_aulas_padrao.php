<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $agora = now();
        $pacotes = [
            4 => 40,
            8 => 35,
            12 => 30,
        ];

        foreach ($pacotes as $aulasMes => $valorAula) {
            DB::table('valores')->updateOrInsert(
                ['tipo' => 'pacote', 'aulas_mes' => $aulasMes],
                [
                    'valor_aula' => $valorAula,
                    'vezes_semana' => $aulasMes,
                    'valor' => $valorAula,
                    'updated_at' => $agora,
                    'created_at' => $agora,
                ]
            );
        }

        DB::table('valores')->updateOrInsert(
            ['tipo' => 'experimental'],
            [
                'aulas_mes' => null,
                'valor_aula' => 30,
                'vezes_semana' => 0,
                'valor' => 30,
                'updated_at' => $agora,
                'created_at' => $agora,
            ]
        );
    }

    public function down(): void
    {
        // Mantem valores cadastrados pelo professor.
    }
};
