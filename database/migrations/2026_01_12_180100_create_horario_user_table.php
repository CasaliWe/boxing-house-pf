<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Criar tabela pivot de alunos por horário.
     */
    public function up(): void
    {
        Schema::create('horario_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('horario_id')->constrained('horarios')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Futuro: aprovação de matrícula
            $table->boolean('aprovado')->default(true);
            $table->timestamps();

            $table->unique(['horario_id', 'user_id'], 'uniq_horario_user');
        });
    }

    /**
     * Reverter criação.
     */
    public function down(): void
    {
        Schema::dropIfExists('horario_user');
    }
};
