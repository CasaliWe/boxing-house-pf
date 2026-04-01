<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horarios';

    protected $fillable = [
        'dia_semana',
        'hora_inicio',
        'hora_fim',
        'vagas',
    ];

    public const LIMITE_ALUNOS_PADRAO = 3;

    /**
     * Alunos vinculados ao horário (apenas usuários com role 'aluno').
     */
    public function alunos(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'horario_user')
            ->withTimestamps()
            ->where('users.role', 'aluno')
            ->withPivot(['aprovado']);
    }

    /**
     * Retorna label do dia da semana.
     */
    public function getDiaSemanaLabelAttribute(): string
    {
        $map = [
            1 => 'Segunda-feira',
            2 => 'Terça-feira',
            3 => 'Quarta-feira',
            4 => 'Quinta-feira',
            5 => 'Sexta-feira',
            6 => 'Sábado',
            7 => 'Domingo',
        ];
        return $map[$this->dia_semana] ?? 'Desconhecido';
    }

    /**
     * Limite de vagas deste horário (usa o campo 'vagas' ou o padrão).
     */
    public function getLimiteAlunosAttribute(): int
    {
        return (int) ($this->vagas ?? self::LIMITE_ALUNOS_PADRAO);
    }

    /**
     * Vagas disponíveis (considerando somente aprovados).
     */
    public function getVagasDisponiveisAttribute(): int
    {
        $ocupadas = $this->alunos()->wherePivot('aprovado', true)->count();
        return max(0, $this->limite_alunos - $ocupadas);
    }

    /**
     * Indica se ainda há vagas disponíveis.
     */
    public function getTemVagaAttribute(): bool
    {
        return $this->vagas_disponiveis > 0;
    }

    /**
     * Método pronto para futura matrícula de aluno em um horário.
     * Garante limite de 3 alunos e que o usuário é aluno.
     */
    public function adicionarAluno(User $usuario): void
    {
        if ($usuario->role !== 'aluno') {
            throw new \InvalidArgumentException('Apenas usuários com papel de aluno podem ser matriculados.');
        }
        if (!$this->tem_vaga) {
            throw new \RuntimeException('Horário sem vagas disponíveis.');
        }
        $this->alunos()->syncWithoutDetaching([$usuario->id => ['aprovado' => true]]);
        // Limpa cache do accessor
        unset($this->attributes['vagas_disponiveis']);
    }

    /**
     * Mutators para garantir que o banco sempre receba HH:MM:SS
     */
    public function setHoraInicioAttribute($value): void
    {
        $this->attributes['hora_inicio'] = \Illuminate\Support\Carbon::parse($value)->format('H:i:s');
    }

    public function setHoraFimAttribute($value): void
    {
        $this->attributes['hora_fim'] = \Illuminate\Support\Carbon::parse($value)->format('H:i:s');
    }
}
