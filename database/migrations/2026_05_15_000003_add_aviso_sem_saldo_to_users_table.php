<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'aulas_sem_saldo_notificado_at')) {
                $table->date('aulas_sem_saldo_notificado_at')->nullable()->after('aulas_pacote_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'aulas_sem_saldo_notificado_at')) {
                $table->dropColumn('aulas_sem_saldo_notificado_at');
            }
        });
    }
};
