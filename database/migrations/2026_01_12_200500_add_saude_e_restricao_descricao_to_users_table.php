<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('saude_descricao')->nullable()->after('saude_problema');
            $table->text('restricao_descricao')->nullable()->after('restricao_medica');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['saude_descricao', 'restricao_descricao']);
        });
    }
};
