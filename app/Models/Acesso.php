<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acesso extends Model
{
    use HasFactory;

    protected $table = 'acessos';

    protected $fillable = [
        'plataforma',
        'url',
        'login',
        'senha',
    ];

    protected $casts = [
        'senha' => 'encrypted',
    ];
}
