<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValorPlano extends Model
{
    use HasFactory;

    protected $table = 'valores';

    public const TIPO_PACOTE = 'pacote';
    public const TIPO_EXPERIMENTAL = 'experimental';

    protected $fillable = [
        'tipo',
        'aulas_mes',
        'valor_aula',
        'vezes_semana',
        'valor',
    ];

    protected function casts(): array
    {
        return [
            'aulas_mes' => 'integer',
            'valor_aula' => 'decimal:2',
            'vezes_semana' => 'integer',
            'valor' => 'decimal:2',
        ];
    }

    /**
     * Pacotes cobrados por quantidade de aulas no mes.
     */
    public function scopePacotes($query)
    {
        return $query->where('tipo', self::TIPO_PACOTE)->whereNotNull('aulas_mes');
    }

    /**
     * Valor da aula experimental.
     */
    public function scopeExperimental($query)
    {
        return $query->where('tipo', self::TIPO_EXPERIMENTAL);
    }

    /**
     * Busca o pacote que atende a quantidade escolhida pelo aluno.
     */
    public static function pacoteParaQuantidade(int $aulas): ?self
    {
        return self::pacotes()
            ->where('aulas_mes', '>=', $aulas)
            ->orderBy('aulas_mes')
            ->first()
            ?: self::pacotes()->orderByDesc('aulas_mes')->first();
    }

    /**
     * Valor total se o aluno usar todo o limite deste pacote.
     */
    public function getValorTotalAttribute(): float
    {
        if ($this->tipo === self::TIPO_EXPERIMENTAL) {
            return (float) $this->valor_aula;
        }

        return (float) $this->aulas_mes * (float) $this->valor_aula;
    }

    /**
     * Label amigavel para exibicao.
     */
    public function getVezesLabelAttribute(): string
    {
        if ($this->tipo === self::TIPO_EXPERIMENTAL) {
            return 'Aula experimental';
        }

        return 'Ate ' . $this->aulas_mes . ' aulas no mes';
    }
}
