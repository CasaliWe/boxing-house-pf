<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Executa todos os seeders do sistema Boxing House PF
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);
    }
}
