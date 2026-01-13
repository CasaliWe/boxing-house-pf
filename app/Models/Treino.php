<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treino extends Model
{
    use HasFactory;

    protected $fillable = [
        'data',
        'foto_path',
        'especial',
    ];

    protected $casts = [
        'data' => 'date',
        'especial' => 'boolean',
    ];

    /**
     * Alunos presentes no treino.
     */
    public function alunos()
    {
        return $this->belongsToMany(User::class, 'treino_user')->withTimestamps();
    }
}
