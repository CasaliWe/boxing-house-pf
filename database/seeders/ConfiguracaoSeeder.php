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
            'pix' => '',
            'whatsapp' => '',
            'maps_src' => '',
            'email' => '',
        ]);
    }
}
