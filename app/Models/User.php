<?php

namespace App\Models;

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
        'aulas_contratadas',
        'aulas_restantes',
        'valor_aula',
        'valor_total_aulas',
        'aulas_pacote_at',
        'aulas_sem_saldo_notificado_at',
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
            'aulas_contratadas' => 'integer',
            'aulas_restantes' => 'integer',
            'valor_aula' => 'decimal:2',
            'valor_total_aulas' => 'decimal:2',
            'aulas_pacote_at' => 'date',
            'aulas_sem_saldo_notificado_at' => 'date',
        ];
    }

    /**
     * Quantos horarios fixos o aluno pode ocupar pelo pacote comprado.
     */
    public function getLimiteHorariosAttribute(): int
    {
        if ((int) $this->aulas_contratadas > 0) {
            return max(1, (int) ceil((int) $this->aulas_contratadas / 4));
        }

        return (int) ($this->plano_vezes ?? 0);
    }

    /**
     * Texto curto do pacote atual.
     */
    public function getResumoPacoteAttribute(): string
    {
        if ((int) $this->aulas_contratadas <= 0) {
            return 'Sem pacote definido';
        }

        return $this->aulas_contratadas . ' aulas no mes';
    }

    /**
     * Define ou renova o pacote de aulas do aluno.
     */
    public function registrarPacoteAulas(int $aulas, float $valorAula, ?int $aulasRestantes = null): void
    {
        $aulas = max($aulas, 1);
        $valorAula = max($valorAula, 0);
        $restantes = $aulasRestantes === null ? $aulas : min($aulas, max($aulasRestantes, 0));

        $this->forceFill([
            'plano_vezes' => max(1, (int) ceil($aulas / 4)),
            'aulas_contratadas' => $aulas,
            'aulas_restantes' => $restantes,
            'valor_aula' => number_format($valorAula, 2, '.', ''),
            'valor_total_aulas' => number_format($aulas * $valorAula, 2, '.', ''),
            'aulas_pacote_at' => now()->toDateString(),
            'aulas_sem_saldo_notificado_at' => null,
        ])->save();
    }

    /**
     * Consome creditos quando uma presenca em treino e registrada.
     */
    public function consumirAulas(int $quantidade = 1): void
    {
        if ((int) $this->aulas_contratadas <= 0) {
            return;
        }

        $this->forceFill([
            'aulas_restantes' => max(0, (int) $this->aulas_restantes - max($quantidade, 0)),
        ])->save();
    }

    /**
     * Devolve creditos quando uma presenca em treino e removida.
     */
    public function devolverAulas(int $quantidade = 1): void
    {
        if ((int) $this->aulas_contratadas <= 0) {
            return;
        }

        $this->forceFill([
            'aulas_restantes' => min(
                (int) $this->aulas_contratadas,
                (int) $this->aulas_restantes + max($quantidade, 0)
            ),
        ])->save();
    }

    /**
     * Relacao com horarios do aluno (pivot horario_user).
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
     * Anotacoes do aluno.
     */
    public function anotacoes()
    {
        return $this->hasMany(\App\Models\Anotacao::class);
    }
}
