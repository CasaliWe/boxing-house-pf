<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela de movimentações financeiras (entradas e saídas).
     */
    public function up(): void
    {
        Schema::create('movimentacoes', function (Blueprint $table) {
            $table->id();
            // Tipo: 'entrada' (receita) ou 'saida' (despesa)
            $table->string('tipo', 10);
            // Aluno relacionado (apenas em entradas vinculadas a aluno)
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            // Descrição livre (ex.: "Água", "Luz", "Pacote 8 aulas")
            $table->string('descricao');
            // Valor em reais
            $table->decimal('valor', 10, 2);
            // Status: 'aberto', 'atraso', 'pago'
            $table->string('status', 10)->default('aberto');
            // Data de vencimento (obrigatória para controle de atraso)
            $table->date('data_vencimento');
            // Data efetiva do pagamento (preenchida quando marcada como pago)
            $table->date('data_pagamento')->nullable();
            // Observações adicionais (ex.: "Referente a 8 aulas — pago via PIX")
            $table->text('observacoes')->nullable();
            $table->timestamps();

            $table->index(['tipo', 'status']);
            $table->index('data_vencimento');
        });
    }

    /**
     * Reverte a criação da tabela.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimentacoes');
    }
};
