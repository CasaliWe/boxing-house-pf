<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'vencimento_at',
        'idade',
        'peso', 
        'whatsapp',
        'instagram',
        'endereco',
        'contato_emergencia_nome',
        'contato_emergencia_whatsapp',
        'data_nascimento',
        'saude_problema',
        'restricao_medica',
        'saude_problema_descricao',
        'restricao_descricao',
        'plano_vezes',
        'objetivos',
        'anos_boxe',
        'anos_instrutor',
        'descricao_professor',
        'imagens_professor',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'vencimento_at' => 'date',
            'data_nascimento' => 'date',
            'saude_problema' => 'boolean',
            'restricao_medica' => 'boolean',
            'objetivos' => 'array',
            'imagens_professor' => 'json',
        ];
    }

    /**
     * Relação com horários do aluno (pivot horario_user).
     */
    public function horarios()
    {
        return $this->belongsToMany(Horario::class, 'horario_user')
            ->withTimestamps()
            ->withPivot(['aprovado']);
    }
    
    /**
     * Treinos onde o aluno esteve presente.
     */
    public function treinos()
    {
        return $this->belongsToMany(\App\Models\Treino::class, 'treino_user')->withTimestamps();
    }

    /**
     * Anotações do aluno.
     */
    public function anotacoes()
    {
        return $this->hasMany(\App\Models\Anotacao::class);
    }
}
