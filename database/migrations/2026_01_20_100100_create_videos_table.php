<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Criar tabela de vídeos dentro dos módulos EAD.
     */
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_modulo_id')->constrained('video_modulos')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->string('arquivo_path');
            $table->integer('duracao_segundos')->default(0);
            $table->boolean('ativo')->default(true);
            $table->integer('ordem')->default(0);
            $table->timestamps();

            // Indexes
            $table->index(['video_modulo_id', 'ativo', 'ordem']);
            $table->index('ativo');
        });
    }

    /**
     * Dropar tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};