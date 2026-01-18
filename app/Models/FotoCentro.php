<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoCentro extends Model
{
    use HasFactory;

    protected $table = 'fotos_centro';

    protected $fillable = [
        'caminho_arquivo',
        'nome_original',
        'descricao',
        'ordem',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    /**
     * Escopo para fotos ativas
     */
    public function scopeAtivas($query)
    {
        return $query->where('ativo', true);
    }

    /**
     * Escopo para ordenação
     */
    public function scopeOrdenadas($query)
    {
        return $query->orderBy('ordem')->orderBy('id');
    }
}