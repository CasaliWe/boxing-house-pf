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
            ['email' => 'professor@gmail.com'],
            [
                'name' => 'Professor Boxing House',
                'email' => 'professor@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('bmxxxx123'), // Altere esta senha!
                'role' => 'professor',
            ]
        );

        // Usuário aluno de exemplo para testes
        \App\Models\User::updateOrCreate(
            ['email' => 'aluno@teste.com'],
            [
                'name' => 'Aluno Teste',
                'email' => 'aluno@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('bmxxxx123'), // Apenas para testes
                'role' => 'aluno',
            ]
        );

        $this->command->info('Usuários criados com sucesso!');
        $this->command->info('Professor: professor@gmail.com / bmxxxx123');
        $this->command->info('Aluno (teste): aluno@gmail.com / bmxxxx123');
    }
}
