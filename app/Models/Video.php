<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'video_modulo_id',
        'titulo',
        'descricao',
        'arquivo_path',
        'duracao_segundos',
        'ativo',
        'ordem',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'ativo' => 'boolean',
        'video_modulo_id' => 'integer',
        'duracao_segundos' => 'integer',
        'ordem' => 'integer',
    ];

    /**
     * Módulo ao qual este vídeo pertence.
     */
    public function modulo()
    {
        return $this->belongsTo(VideoModulo::class, 'video_modulo_id');
    }

    /**
     * Formata a duração em formato MM:SS.
     */
    public function getDuracaoFormatadaAttribute(): string
    {
        $minutos = floor($this->duracao_segundos / 60);
        $segundos = $this->duracao_segundos % 60;
        return sprintf('%02d:%02d', $minutos, $segundos);
    }

    /**
     * Scope para vídeos ativos.
     */
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    /**
     * Scope para ordenar por ordem definida.
     */
    public function scopeOrdenados($query)
    {
        return $query->orderBy('ordem');
    }
}