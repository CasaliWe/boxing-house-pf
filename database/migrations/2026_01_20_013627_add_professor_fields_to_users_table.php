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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('anos_boxe')->nullable()->after('plano_vezes')->comment('Anos praticando boxe');
            $table->unsignedTinyInteger('anos_instrutor')->nullable()->after('anos_boxe')->comment('Anos como instrutor');
            $table->text('descricao_professor')->nullable()->after('anos_instrutor')->comment('Descrição do professor');
            $table->json('imagens_professor')->nullable()->after('descricao_professor')->comment('Até 5 imagens do professor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'anos_boxe',
                'anos_instrutor', 
                'descricao_professor',
                'imagens_professor'
            ]);
        });
    }
};
