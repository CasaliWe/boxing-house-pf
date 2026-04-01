<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Criar tabela de ideias de exercícios.
     */
    public function up(): void
    {
        Schema::create('ideias_exercicios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao');
            $table->string('video_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverter criação.
     */
    public function down(): void
    {
        Schema::dropIfExists('ideias_exercicios');
    }
};
