<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Movimentações financeiras: entradas (receitas) e saídas (despesas).
 */
class Movimentacao extends Model
{
    use HasFactory;

    protected $table = 'movimentacoes';

    // Tipos possíveis
    public const TIPO_ENTRADA = 'entrada';
    public const TIPO_SAIDA   = 'saida';

    // Status possíveis
    public const STATUS_ABERTO = 'aberto';
    public const STATUS_ATRASO = 'atraso';
    public const STATUS_PAGO   = 'pago';

    protected $fillable = [
        'tipo',
        'user_id',
        'descricao',
        'valor',
        'status',
        'data_vencimento',
        'data_pagamento',
        'observacoes',
    ];

    protected function casts(): array
    {
        return [
            'valor'           => 'decimal:2',
            'data_vencimento' => 'date',
            'data_pagamento'  => 'date',
        ];
    }

    /**
     * Aluno associado (apenas para entradas vinculadas).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Scope de entradas */
    public function scopeEntradas($q) { return $q->where('tipo', self::TIPO_ENTRADA); }

    /** Scope de saídas */
    public function scopeSaidas($q)   { return $q->where('tipo', self::TIPO_SAIDA); }

    /** Scope por status */
    public function scopeStatus($q, string $status) { return $q->where('status', $status); }

    /**
     * Recalcula o status para "atraso" se a data de vencimento já passou
     * e o pagamento ainda não foi efetuado. Usado ao listar / antes de exibir.
     */
    public function atualizarStatusAtraso(): void
    {
        if ($this->status === self::STATUS_PAGO) {
            return;
        }
        if ($this->data_vencimento && $this->data_vencimento->lt(Carbon::today())) {
            if ($this->status !== self::STATUS_ATRASO) {
                $this->status = self::STATUS_ATRASO;
                $this->saveQuietly();
            }
        } elseif ($this->status === self::STATUS_ATRASO) {
            // Caso a data tenha sido reagendada para o futuro
            $this->status = self::STATUS_ABERTO;
            $this->saveQuietly();
        }
    }

    /**
     * Cor associada ao status (para exibição em badges Tailwind).
     */
    public function getStatusCorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PAGO   => 'bg-green-500/20 text-green-300',
            self::STATUS_ATRASO => 'bg-red-500/20 text-red-300',
            default             => 'bg-yellow-500/20 text-yellow-300',
        };
    }

    /**
     * Label amigável do status.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PAGO   => 'Pago',
            self::STATUS_ATRASO => 'Em atraso',
            default             => 'Em aberto',
        };
    }
}
