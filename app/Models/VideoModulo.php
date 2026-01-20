<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoModulo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'descricao',
        'tema',
        'aula_minima_acesso',
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
        'aula_minima_acesso' => 'integer',
        'ordem' => 'integer',
    ];

    /**
     * Vídeos pertencentes a este módulo.
     */
    public function videos()
    {
        return $this->hasMany(Video::class, 'video_modulo_id')->orderBy('ordem');
    }

    /**
     * Verifica se o aluno tem acesso ao módulo baseado no número de aulas.
     */
    public function alunoTemAcesso(User $aluno): bool
    {
        $numeroAulasAluno = $aluno->treinos()->count();
        return $numeroAulasAluno >= $this->aula_minima_acesso;
    }

    /**
     * Scope para módulos ativos.
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