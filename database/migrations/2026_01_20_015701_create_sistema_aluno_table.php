<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sistema_aluno', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->default('Sistema do Aluno');
            $table->text('descricao')->nullable()->comment('Descrição abaixo do título');
            $table->json('resumo_items')->nullable()->comment('Array de itens do resumo');
            $table->text('detalhes')->nullable()->comment('Texto dos detalhes');
            $table->json('imagens')->nullable()->comment('Array de imagens do sistema');
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sistema_aluno');
    }
};
