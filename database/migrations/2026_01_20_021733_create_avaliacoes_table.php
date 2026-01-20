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
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('foto_avaliacao')->nullable()->comment('Caminho da foto para a avaliação');
            $table->text('comentario')->comment('Comentário/depoimento do aluno');
            $table->boolean('ativo')->default(false)->comment('Avaliação aprovada pelo professor');
            $table->boolean('exibir_landing')->default(true)->comment('Exibir na landing page');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacoes');
    }
};
