<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Cria usuários iniciais para o sistema Boxing House PF
     */
    public function run(): void
    {
        // Usuário Professor (Master/Admin)
        \App\Models\User::updateOrCreate(
            ['email' => 'professor@boxinghousepf.com'],
            [
                'name' => 'Professor Boxing House',
                'email' => 'professor@boxinghousepf.com',
                'email_verified_at' => now(),
                'password' => bcrypt('boxinghouse123'), // Altere esta senha!
                'role' => 'professor',
            ]
        );

        // Usuário aluno de exemplo para testes
        \App\Models\User::updateOrCreate(
            ['email' => 'aluno@teste.com'],
            [
                'name' => 'Aluno Teste',
                'email' => 'aluno@teste.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123456'), // Apenas para testes
                'role' => 'aluno',
            ]
        );

        $this->command->info('Usuários criados com sucesso!');
        $this->command->info('Professor: professor@boxinghousepf.com / boxinghouse123');
        $this->command->info('Aluno (teste): aluno@teste.com / 123456');
    }
}
