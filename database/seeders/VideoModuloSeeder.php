<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VideoModulo;

class VideoModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modulos = [
            [
                'titulo' => 'Fundamentos do Jab',
                'descricao' => 'Aprenda a técnica correta do soco jab, desde a posição inicial até a execução perfeita.',
                'tema' => 'ataque',
                'aula_minima_acesso' => 1,
                'ativo' => true,
                'ordem' => 1,
            ],
            [
                'titulo' => 'Postura e Guarda',
                'descricao' => 'Domine a posição fundamental do boxe: como manter a guarda correta e postura eficiente.',
                'tema' => 'guarda',
                'aula_minima_acesso' => 1,
                'ativo' => true,
                'ordem' => 2,
            ],
            [
                'titulo' => 'Deslocamentos Básicos',
                'descricao' => 'Movimentação no ringue: como se deslocar de forma eficiente durante o combate.',
                'tema' => 'deslocamento',
                'aula_minima_acesso' => 3,
                'ativo' => true,
                'ordem' => 3,
            ],
            [
                'titulo' => 'Combinações 1-2',
                'descricao' => 'Aprenda as combinações básicas jab-direto e como aplicá-las efetivamente.',
                'tema' => 'combinacoes',
                'aula_minima_acesso' => 5,
                'ativo' => true,
                'ordem' => 4,
            ],
            [
                'titulo' => 'Equipamentos e Segurança',
                'descricao' => 'Como usar corretamente os equipamentos de boxe e manter a segurança durante os treinos.',
                'tema' => 'equipamentos',
                'aula_minima_acesso' => 1,
                'ativo' => true,
                'ordem' => 5,
            ],
            [
                'titulo' => 'Técnicas Avançadas de Ataque',
                'descricao' => 'Desenvolva ataques mais complexos e eficientes para elevadores intermediários.',
                'tema' => 'avancado',
                'aula_minima_acesso' => 10,
                'ativo' => true,
                'ordem' => 6,
            ],
        ];

        foreach ($modulos as $moduloData) {
            VideoModulo::create($moduloData);
        }
    }
}