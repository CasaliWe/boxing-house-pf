<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Pivot treino_user para presenças dos alunos.
     */
    public function up(): void
    {
        Schema::create('treino_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('treino_id')->constrained('treinos')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['treino_id', 'user_id']);
        });
    }

    /**
     * Drop.
     */
    public function down(): void
    {
        Schema::dropIfExists('treino_user');
    }
};
