<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria os posts planejados para Instagram.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('tipo', 20);
            $table->dateTime('data_postagem');
            $table->text('legenda')->nullable();
            $table->json('arquivos')->nullable();
            $table->timestamps();

            $table->index(['tipo', 'data_postagem']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
