<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela de senhas e acessos do professor.
     */
    public function up(): void
    {
        Schema::create('acessos', function (Blueprint $table) {
            $table->id();
            $table->string('plataforma');
            $table->string('url')->nullable();
            $table->string('login')->nullable();
            $table->text('senha')->nullable();
            $table->timestamps();

            $table->index('plataforma');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acessos');
    }
};
