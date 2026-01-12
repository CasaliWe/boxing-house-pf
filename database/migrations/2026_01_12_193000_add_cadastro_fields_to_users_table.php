<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status', ['ativo', 'pendente', 'inativo'])->default('pendente')->after('role');
            $table->date('vencimento_at')->nullable()->after('status');

            $table->unsignedTinyInteger('idade')->nullable()->after('password');
            $table->decimal('peso', 5, 2)->nullable()->after('idade');
            $table->string('whatsapp')->nullable()->after('peso');
            $table->string('instagram')->nullable()->after('whatsapp');
            $table->string('endereco')->nullable()->after('instagram');
            $table->string('contato_emergencia_nome')->nullable()->after('endereco');
            $table->string('contato_emergencia_whatsapp')->nullable()->after('contato_emergencia_nome');
            $table->date('data_nascimento')->nullable()->after('contato_emergencia_whatsapp');
            $table->boolean('saude_problema')->default(false)->after('data_nascimento');
            $table->boolean('restricao_medica')->default(false)->after('saude_problema');
            $table->unsignedTinyInteger('plano_vezes')->nullable()->after('restricao_medica');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'status', 'vencimento_at', 'idade', 'peso', 'whatsapp', 'instagram', 'endereco',
                'contato_emergencia_nome', 'contato_emergencia_whatsapp', 'data_nascimento',
                'saude_problema', 'restricao_medica', 'plano_vezes'
            ]);
        });
    }
};
