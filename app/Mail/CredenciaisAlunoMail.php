<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CredenciaisAlunoMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $plainPassword;

    public function __construct(User $user, string $plainPassword)
    {
        $this->user = $user;
        $this->plainPassword = $plainPassword;
    }

    public function build()
    {
        return $this->subject('Bem-vindo à Boxing House PF')
            ->view('emails.credenciais_aluno')
            ->with([
                'user' => $this->user,
                'senha' => $this->plainPassword,
            ]);
    }
}
