<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SistemaAluno extends Model
{
    protected $table = 'sistema_aluno';

    protected $fillable = [
        'titulo',
        'descricao',
        'resumo_items',
        'detalhes',
        'imagens',
        'ativo'
    ];

    protected $casts = [
        'resumo_items' => 'array',
        'imagens' => 'array',
        'ativo' => 'boolean'
    ];
}
