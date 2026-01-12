<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Criar tabela de regras e aceites.
     */
    public function up(): void
    {
        Schema::create('regras', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 120);
            $table->text('conteudo');
            $table->boolean('ativo')->default(true);
            $table->unsignedInteger('ordem')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverter criação.
     */
    public function down(): void
    {
        Schema::dropIfExists('regras');
    }
};
