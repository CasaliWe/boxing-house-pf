<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Tarefa do quadro Fazer / Fazendo / Feito.
 */
class Tarefa extends Model
{
    use HasFactory;

    protected $table = 'tarefas';

    public const STATUS_FAZER   = 'fazer';
    public const STATUS_FAZENDO = 'fazendo';
    public const STATUS_FEITO   = 'feito';

    protected $fillable = [
        'titulo',
        'descricao',
        'status',
    ];

    /**
     * Ordem lógica dos estados (usada para avançar / retroceder).
     */
    public const ORDEM = [
        self::STATUS_FAZER,
        self::STATUS_FAZENDO,
        self::STATUS_FEITO,
    ];

    /**
     * Próximo status na sequência. Retorna null se já estiver no último.
     */
    public function proximoStatus(): ?string
    {
        $i = array_search($this->status, self::ORDEM, true);
        return ($i === false || $i >= count(self::ORDEM) - 1) ? null : self::ORDEM[$i + 1];
    }

    /**
     * Status anterior na sequência. Retorna null se já estiver no primeiro.
     */
    public function statusAnterior(): ?string
    {
        $i = array_search($this->status, self::ORDEM, true);
        return ($i === false || $i <= 0) ? null : self::ORDEM[$i - 1];
    }

    /**
     * Label amigável.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_FAZENDO => 'Fazendo',
            self::STATUS_FEITO   => 'Feito',
            default              => 'A fazer',
        };
    }
}
