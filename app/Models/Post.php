<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public const TIPO_POST = 'post';
    public const TIPO_VIDEO = 'video';
    public const TIPO_SLIDE = 'slide';

    public const TIPOS = [
        self::TIPO_POST => 'Post',
        self::TIPO_VIDEO => 'Video',
        self::TIPO_SLIDE => 'Slide',
    ];

    protected $fillable = [
        'titulo',
        'tipo',
        'data_postagem',
        'legenda',
        'arquivos',
    ];

    protected $casts = [
        'data_postagem' => 'datetime',
        'arquivos' => 'array',
    ];

    public function getTipoLabelAttribute(): string
    {
        return self::TIPOS[$this->tipo] ?? ucfirst($this->tipo);
    }
}
