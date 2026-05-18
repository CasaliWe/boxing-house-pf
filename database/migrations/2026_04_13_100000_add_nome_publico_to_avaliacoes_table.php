<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Permitir avaliacoes publicas (sem user logado).
     * Adiciona campo nome_publico e torna user_id nullable.
     */
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            Schema::table('avaliacoes', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });
        }

        Schema::table('avaliacoes', function (Blueprint $table) {
            $table->string('nome_publico')->nullable()->after('user_id')->comment('Nome do avaliador quando nao e aluno cadastrado');
            $table->foreignId('user_id')->nullable()->change();
        });

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            Schema::table('avaliacoes', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            Schema::table('avaliacoes', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });
        }

        Schema::table('avaliacoes', function (Blueprint $table) {
            $table->dropColumn('nome_publico');
            $table->foreignId('user_id')->nullable(false)->change();
        });

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            Schema::table('avaliacoes', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            });
        }
    }
};
