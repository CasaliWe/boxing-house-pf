<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_eventos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');       // visita, clique_whatsapp, clique_login
            $table->string('nome');       // nome do botão: hero-fale-conosco, plano-2x, area-aluno-header, etc.
            $table->string('sessao_id');  // identificador da sessão (cookie)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_eventos');
    }
};
