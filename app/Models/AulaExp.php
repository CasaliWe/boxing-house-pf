<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AulaExp extends Model
{
    use HasFactory;

    protected $table = 'aulas_exp';

    protected $fillable = [
        'nome',
        'data',
        'dia_semana',
        'horario',
        'numero',
        'observacao',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'date',
        ];
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
     * Mutator para garantir formato HH:MM:SS no horário.
     */
    public function setHorarioAttribute($value): void
    {
        $this->attributes['horario'] = \Illuminate\Support\Carbon::parse($value)->format('H:i:s');
    }
}
