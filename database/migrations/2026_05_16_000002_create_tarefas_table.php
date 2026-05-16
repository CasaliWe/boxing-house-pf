<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela de tarefas (TODO de 3 estados: fazer / fazendo / feito).
     */
    public function up(): void
    {
        Schema::create('tarefas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            // Estado da tarefa: 'fazer', 'fazendo' ou 'feito'
            $table->string('status', 10)->default('fazer');
            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Reverte a criação da tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarefas');
    }
};
