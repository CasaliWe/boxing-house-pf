<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabela de valores por quantidade de treinos semanais.
     */
    public function up(): void
    {
        Schema::create('valores', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('vezes_semana'); // 1..5
            $table->decimal('valor', 8, 2); // preço
            $table->timestamps();

            $table->unique(['vezes_semana'], 'uniq_valor_vezes_semana');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('valores');
    }
};
