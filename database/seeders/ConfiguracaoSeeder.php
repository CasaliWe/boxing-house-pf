<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuracao;

class ConfiguracaoSeeder extends Seeder
{
    /**
     * Cria um registro inicial de configurações, se não existir.
     */
    public function run(): void
    {
        Configuracao::firstOrCreate(['id' => 1], [
            'pix' => '04190191035',
            'whatsapp' => '54991538488',
            'maps_src' => '',
            'email' => 'wesleicasali18@gmail.com',
        ]);
    }
}
