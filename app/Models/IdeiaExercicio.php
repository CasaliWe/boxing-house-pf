<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdeiaExercicio extends Model
{
    use HasFactory;

    protected $table = 'ideias_exercicios';

    protected $fillable = [
        'nome',
        'descricao',
        'video_path',
    ];
}
