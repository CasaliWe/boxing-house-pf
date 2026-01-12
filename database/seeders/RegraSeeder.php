<?php

namespace Database\Seeders;

use App\Models\Regra;
use Illuminate\Database\Seeder;

class RegraSeeder extends Seeder
{
    /**
     * Popula regras e aceites com textos revisados/comerciais.
     */
    public function run(): void
    {
        $itens = [
            [
                'titulo' => 'Regras',
                'conteudo' => 'Respeito e conduta: envolvimento em brigas fora da academia gera desligamento imediato, mesmo com mensalidade paga.',
                'ordem' => 1,
            ],
            [
                'titulo' => 'Regras',
                'conteudo' => 'Faltas e reposição: não há reposição de aulas. São 2 treinos por semana; faltou, a aula é considerada perdida.',
                'ordem' => 2,
            ],
            [
                'titulo' => 'Regras',
                'conteudo' => 'Mudanças de turma: alterações de dia/horário dependem de disponibilidade no horário desejado.',
                'ordem' => 3,
            ],
            [
                'titulo' => 'Regras',
                'conteudo' => 'Pontualidade: aulas de 1h exata. Atrasos reduzem o tempo de treino e não geram compensação.',
                'ordem' => 4,
            ],
            [
                'titulo' => 'Regras',
                'conteudo' => 'Respeito obrigatório: mantemos um ambiente seguro, acolhedor e respeitoso para todos.',
                'ordem' => 5,
            ],
            [
                'titulo' => 'Regras',
                'conteudo' => 'Mensalidade e regras: pagamento não garante permanência em caso de violação das normas.',
                'ordem' => 6,
            ],
            [
                'titulo' => 'Regras',
                'conteudo' => 'Cancelamento: solicite com antecedência mínima para organização interna e ajuste de vagas.',
                'ordem' => 7,
            ],
            [
                'titulo' => 'Regras',
                'conteudo' => 'Uso de imagem: autorizo o uso de minha imagem em fotos e vídeos da academia para fins institucionais e promocionais.',
                'ordem' => 8,
            ],
            [
                'titulo' => 'Regras',
                'conteudo' => 'Termo de ciência: ao se matricular, declaro estar ciente e de acordo com todas as regras.',
                'ordem' => 9,
            ],
        ];

        foreach ($itens as $i) {
            Regra::firstOrCreate(
                ['titulo' => $i['titulo'], 'conteudo' => $i['conteudo']],
                [
                    'ativo' => true,
                    'ordem' => $i['ordem'],
                ]
            );
        }
    }
}
