<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Criar tabela de horários disponíveis.
     */
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            // 1=Segunda ... 7=Domingo
            $table->unsignedTinyInteger('dia_semana');
            $table->time('hora_inicio');
            $table->time('hora_fim');
            $table->timestamps();

            $table->unique(['dia_semana', 'hora_inicio', 'hora_fim'], 'uniq_horario_dia_inicio_fim');
        });
    }

    /**
     * Reverter criação.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
