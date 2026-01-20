<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Criar tabela de módulos de vídeos para sistema EAD.
     */
    public function up(): void
    {
        Schema::create('video_modulos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->enum('tema', [
                'ataque', 
                'combinacoes', 
                'deslocamento', 
                'guarda', 
                'equipamentos',
                'fundamentos',
                'avancado',
                'outros'
            ]);
            $table->integer('aula_minima_acesso')->default(1);
            $table->boolean('ativo')->default(true);
            $table->integer('ordem')->default(0);
            $table->timestamps();

            // Indexes
            $table->index(['ativo', 'ordem']);
            $table->index('tema');
            $table->index('aula_minima_acesso');
        });
    }

    /**
     * Dropar tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_modulos');
    }
};