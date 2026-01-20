<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    protected $table = 'avaliacoes';

    protected $fillable = [
        'user_id',
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
}
