<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    protected $table = 'avaliacoes';

    protected $fillable = [
        'user_id',
        'nome_publico',
        'foto_avaliacao',
        'comentario',
        'ativo',
        'exibir_landing'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'exibir_landing' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Retorna o nome para exibição (aluno cadastrado ou nome público).
     */
    public function getNomeExibicaoAttribute(): string
    {
        return $this->user?->name ?? $this->nome_publico ?? 'Anônimo';
    }
}
