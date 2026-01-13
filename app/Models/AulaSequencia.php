<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AulaSequencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'descricao',
        'ativo',
    ];

    protected $casts = [
        'numero' => 'integer',
        'ativo' => 'boolean',
    ];
}
