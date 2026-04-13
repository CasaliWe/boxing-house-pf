<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Permitir avaliações públicas (sem user logado).
     * Adiciona campo nome_publico e torna user_id nullable.
     */
    public function up(): void
    {
        Schema::table('avaliacoes', function (Blueprint $table) {
            $table->string('nome_publico')->nullable()->after('user_id')->comment('Nome do avaliador quando não é aluno cadastrado');
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('avaliacoes', function (Blueprint $table) {
            $table->dropColumn('nome_publico');
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
