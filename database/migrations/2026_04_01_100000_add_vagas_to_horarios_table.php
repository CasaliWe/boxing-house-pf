<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adiciona campo 'vagas' na tabela horários para controle individual de vagas por turma.
     */
    public function up(): void
    {
        Schema::table('horarios', function (Blueprint $table) {
            $table->unsignedTinyInteger('vagas')->default(3)->after('hora_fim');
        });
    }

    /**
     * Reverter alteração.
     */
    public function down(): void
    {
        Schema::table('horarios', function (Blueprint $table) {
            $table->dropColumn('vagas');
        });
    }
};
