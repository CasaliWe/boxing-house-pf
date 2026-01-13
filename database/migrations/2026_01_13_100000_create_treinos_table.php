<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Criar tabela de treinos com foto, data e flag especial.
     */
    public function up(): void
    {
        Schema::create('treinos', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->string('foto_path');
            $table->boolean('especial')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Dropar tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('treinos');
    }
};
