<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Anotacao extends Model
{
    use HasFactory;

    protected $table = 'anotacoes';

    protected $fillable = [
        'user_id',
        'titulo',
        'conteudo',
        'data_anotacao',
    ];

    protected $casts = [
        'data_anotacao' => 'date',
    ];

    /**
     * Relacionamento com o usuário
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}