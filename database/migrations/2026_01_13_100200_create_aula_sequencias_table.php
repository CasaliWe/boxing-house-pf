<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Sequência de aulas por número.
     */
    public function up(): void
    {
        Schema::create('aula_sequencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('numero')->unique();
            $table->text('descricao');
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Drop.
     */
    public function down(): void
    {
        Schema::dropIfExists('aula_sequencias');
    }
};
