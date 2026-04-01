<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Criar tabela de aulas experimentais.
     */
    public function up(): void
    {
        Schema::create('aulas_exp', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('data');
            $table->unsignedTinyInteger('dia_semana'); // 1=Segunda ... 7=Domingo
            $table->time('horario');
            $table->string('numero')->nullable(); // telefone de contato
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverter criação.
     */
    public function down(): void
    {
        Schema::dropIfExists('aulas_exp');
    }
};
